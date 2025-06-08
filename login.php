<?php
session_start();

// verifico se la ssesion esta activa
if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    // Redirigir al usuario a la página 
    if($_SESSION['nivel'] == 0){
        header('Location: usuario0.php');
        exit();
    }
    if($_SESSION['nivel'] == 5){
        header('Location: intranet.php');
        exit();
    }
    if($_SESSION['nivel'] == 99){
        header('Location: usuario99.php');
        exit();
    }
    if($_SESSION['nivel'] == 666){
        header('Location: gestion_usuarios.php');
        exit();
    }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>INICIAR SESIÓN</title>
</head>
<style>
    .btn-float {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        animation: bounce 9s infinite;
        /* Animación de rebote */
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-10px);
        }

        60% {
            transform: translateY(-5px);
        }
    }
</style>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <form action="iniciarsesion.php" method="POST" class="p-4 border rounded bg-white shadow" style="width: 350px;">
        <h2 class="text-center mb-4">INICIAR SESIÓN</h2>
        <hr>
        <!-- Mostrar mensaje de error si existe -->
        <?php
        if (isset($_SESSION['mensaje_error'])) {
            echo "<div class='alert alert-danger mt-3'>{$_SESSION['mensaje_error']}</div>";
            unset($_SESSION['mensaje_error']);
        }
        ?>

        <!-- Campo de Nombre de Usuario -->
        <div class="mb-3">
            <label for="nombre_usuario" class="form-label"><i class="fa-solid fa-user"></i> Nombre de usuario</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" placeholder="Nombre de usuario">
        </div>

        <!-- Campo de Contraseña -->
        <div class="mb-3">
            <label for="contraseña" class="form-label"><i class="fa-solid fa-lock"></i> Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" class="form-control" placeholder="Contraseña">
        </div>

        <hr>

        <!-- Botón de Enviar -->
        <button type="submit" class="btn btn-primary w-100 mb-3">INICIAR SESIÓN</button>

        <!-- Botón para crear una cuenta -->
        <a class="btn btn-outline-success w-100 mb-2" href="registro.php">CREAR CUENTA</a>
    </form>

    <!-- Botón flotante -->
    <a href="index.php" class="btn btn-primary btn-float">Volver a Noticias</a>
</body>

</html>