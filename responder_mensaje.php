<?php
include "conexion.php";
session_start();

if (!isset($_SESSION['id'])) {
    die("Error: No se ha iniciado sesión.");
}

$userId = $_SESSION['id'];

if (isset($_GET['id'])) {
    $mensajeId = $_GET['id'];

    // Obtener los detalles del mensaje al que se va a responder
    $sql = "SELECT mensajes.asunto, mensajes.mensaje, mensajes.remitente_id, usuarios.usuario AS remitente_nombre 
            FROM mensajes
            JOIN usuarios ON mensajes.remitente_id = usuarios.id
            WHERE mensajes.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mensajeId);
    $stmt->execute();
    $mensaje = $stmt->get_result()->fetch_assoc();

    if (!$mensaje) {
        die("El mensaje no existe.");
    }

    // Procesar el envío de la respuesta
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $respuesta = $_POST['respuesta'];

        // Insertar la respuesta en la base de datos como un nuevo mensaje
        $sqlInsert = "INSERT INTO mensajes (remitente_id, destinatario_id, asunto, mensaje, fecha_envio, leido) 
                      VALUES (?, ?, ?, ?, NOW(), 0)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("iiss", $userId, $mensaje['remitente_id'], $mensaje['asunto'], $respuesta);

        if ($stmtInsert->execute()) {
            header("location: inbox.php");
            exit();
        } else {
            die("Error al enviar el mensaje: " . $stmtInsert->error);
        }
    }
} else {
    die("No se ha especificado el mensaje.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Responder Mensaje</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
</head>
<body>
<div class="container">
    <h1>Responder mensaje</h1>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Asunto:</strong> <?= $mensaje['asunto']?></div>
        <div class="panel-body">
            <p><strong>De:</strong> <?= $mensaje['remitente_nombre'] ?></p>
            <p><strong>Mensaje:</strong></p>
            <p><?= $mensaje['mensaje'] ?></p>
        </div>
    </div>

    <form action="responder_mensaje.php?id=<?= $mensajeId ?>" method="POST">
        <div class="form-group">
            <label for="respuesta">Tu respuesta:</label>
            <textarea name="respuesta" id="respuesta" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
    </form>
</div>
</body>
</html>
