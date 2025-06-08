<?php
include("conexion.php");
session_start();

// verifico se la ssesion esta activa
if (!isset($_SESSION["login"]) || $_SESSION["login"] === false) {
    // Redirigir al usuario a la página de inicio de sesión
    header('Location: iniciarsesion.php');
    exit();
}



//proceso el cierre de la session
if (isset($_POST['login'])) {

    //dedstruyo la session
    session_destroy();

    //redirigo al  usuario al inicio de session 
    header('Location: iniciarsesion.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Pagina principal</title>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="intranet.php">BIENVENIDO <?php echo $_SESSION['nombre_usuario'] ?> DE NIVEL <?php echo $_SESSION['nivel'] ?></a>
                </div>
                <ul class="nav navbar-nav">
                    <!-- Formulario de cierre de sesión -->
                    <form action="" method="post" style="display:inline;">
                        <button type="submit" name="login" class="btn btn-link navbar-btn"><i class="glyphicon glyphicon-log-out"></i> Cerrar sesión</button>
                    </form>
                    <li class="active"><a href="index.php"><i class="glyphicon glyphicon-list"></i> Llista</a></li>
                    <li><a href="create.php"><i class="glyphicon glyphicon-plus"></i> Crear</a></li>
                </ul>
            </div>
        </nav>

        <h1>Llista noticies</h1>

        <table class='table'>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Titular</th>
                    <th>Descripción</th>
                    <th>Fecha creacion</th>
                    <th>Fecha publicacion</th>
                    <th>Operacions</th>
                </tr>
            </thead>
            <tbody>
                <?php


                $sql = "SELECT * FROM noticias";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['titulo'] . "</td>";
                        echo "<td>" . $row['descripcion'] . "</td>"; 
                        echo "<td>" . $row['fecha'] . "</td>";
                        echo "<td>" . $row['fecha_publico'] . "</td>";
                        echo "<td>";
                        echo "<a href='edit.php?id=$id'class='btn btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit</a> ";
                        echo "<a href='del.php?id=$id' class='btn btn-danger'><i class='glyphicon glyphicon-remove'></i> Del</a> ";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>&nbsp;</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <?php
        if (isset($_GET['op'])) {
            if ($_GET['op'] == 'delok') {
                echo '<div class="alert alert-success">';
                echo '<strong><i class="glyphicon glyphicon-ok-circle"></i> Success!</strong> Registre eliminat correctament.';
                echo '</div>';
            }
            if ($_GET['op'] == 'upok') {
                echo '<div class="alert alert-success">';
                echo '<strong><i class="glyphicon glyphicon-ok-circle"></i> Success!</strong> Registre actualitzat correctament.';
                echo '</div>';
            }
            if ($_GET['op'] == 'errpeticio') {
                echo '<div class="alert alert-danger">';
                echo "<strong><i class='glyphicon glyphicon-exclamation-sign'></i> ERROR!</strong> S'ha produit un error en l'operació.";
                echo '</div>';
            }

            unset($_GET['op']);
        }
        ?>
    </div>

    <!-- Opciones de mensajes -->
    <div class="container mt-5">
        <div class="message-options mt-4">
            <h3>Mensajería</h3>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="inbox.php" class="btn btn-info">
                        Ver mensajes recibidos
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="send.php" class="btn btn-success">
                        Enviar mensaje a otro usuario
                    </a>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>