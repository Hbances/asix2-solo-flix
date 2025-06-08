<?php
// Ver los mensajes de otros usuarios
include "conexion.php";
session_start();

if (!isset($_SESSION['id'])) {
    die("Error: No se ha iniciado sesión.");
}

$userId = $_SESSION['id'];

// Consultar mensajes junto con el nombre del remitente
$sql = "
    SELECT mensajes.id, mensajes.asunto, mensajes.fecha_envio, mensajes.mensaje, usuarios.usuario AS remitente_nombre
    FROM mensajes
    JOIN usuarios ON mensajes.remitente_id = usuarios.id
    WHERE mensajes.destinatario_id = ?
    ORDER BY mensajes.fecha_envio ASC
";

$result = $conn->prepare($sql);
$result->bind_param("i", $userId);
$result->execute();
$mensajes = $result->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bústia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>TUS MENSAGES</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Remitent</th>
            <!-- <th>Para</th> -->
            <th>Assumpte</th>
            <th>Data</th>
            <th>Mensaje</th>
            <th>Acció</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($mensajes as $mensaje): ?>
            <tr>
                <td><?= ($mensaje['remitente_nombre']) ?></td>
                <!-- <td><?= ($_SESSION['nombre_usuario']) ?></td>    no hace falta ponerlo-->
                <td><?= ($mensaje['asunto']) ?></td>
                <td><?= ($mensaje['fecha_envio']) ?></td>
                <td><?= ($mensaje['mensaje']) ?></td>
                <td>
                    <a href="responder_mensaje.php?id=<?= $mensaje['id']?>" class="btn btn-success">responder</a>
                </td>
                
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php 
        if(isset($_SESSION['nivel'])){
            if($_SESSION['nivel'] == 5){
                echo "<a href='intranet.php' class='btn btn-primary'>volver a usuario 5</a>";
            }elseif($_SESSION['nivel'] == 99){
                echo "<a href='usuario99.php' class='btn btn-primary'>volver a usuario 99</a>";
            }elseif($_SESSION['nivel'] == 0){
                echo "<a href='usuario0.php' class='btn btn-primary'>volver a usuario 0</a>";
            }elseif($_SESSION['nivel'] == 666){
                echo "<a href='gestion_usuarios.php' class='btn btn-primary'>volver a usuario 66</a>";
            }
        }
    
    ?>
</div>
</body>
</html>
