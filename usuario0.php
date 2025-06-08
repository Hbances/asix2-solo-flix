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

    <title>USUARIO 0</title>
</head>

<body>
    <nav class="navbar navbar-default" style="padding: 0 10px;">
        <div class="container-fluid">
            <!-- Título del sitio -->
            <div class="navbar-header">
                <a class="navbar-brand" href="usuario0.php">ASIX Website</a>
            </div>

            <!-- Opciones del usuario -->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="contraseña.php" class="d-flex align-items-center" style="padding: 8px; text-decoration: none;">
                        <img src="imagenes/contrasena.gif" style="width: 20px; height: 20px; margin-right: 5px;" alt="Icono de contraseña">
                        <span>Cambiar Contraseña</span>
                    </a>
                </li>
                <li>
                    <form action="" method="post" style="display:inline;">
                        <button type="submit" name="login" class="btn btn-link d-flex align-items-center" style="padding: 8px; text-decoration: none;">
                            <img src="imagenes/cerrar-sesion.gif" style="width: 20px; height: 20px; margin-right: 5px;" alt="Cerrar sesión">
                            <span>Cerrar sesión</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="welcome-header">
            <h1>Bienvenido <?php echo $_SESSION['nombre_usuario']?> de nivel <?php echo $_SESSION['nivel']?> al portal genérico</h1>
            <p>SOLO TIENES LA OPCIÓN DE CAMBIAR TU CONTRASEÑA</p>
        </div>

        <!-- Opciones de mensajes -->
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
