<?php
include_once("conexion.php"); // Incluye el archivo de conexión a la base de datos



if (isset($_POST['registro'])) {
    // Obtengo los valores del formulario
    $nombre = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // con nivel 0 por defecto
    $nivel = 0;

    // Encriptar la contraseña
    $encriptado = password_hash($contraseña, PASSWORD_DEFAULT);

    // Llamar a la función para añadir el usuario
    $resultado = añadir($nombre, $encriptado, $nivel);

    if ($resultado) {
        $_SESSION['mensaje_ok']= "Usuario registrado exitosamente. Puedes iniciar sesión ahora.";
    } else {
        $_SESSION['mensaje_error'] = "Error al registrar usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>CREAR USUARIO</title>
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <form action="" method="POST" class="p-4 border rounded bg-white shadow" style="width: 350px;">
        <h2 class="text-center mb-4">CREAR USUARIO</h2>
        <hr>

        <!-- Mostrar mensaje de éxito o error -->
        <?php 
        if (isset($_SESSION['mensaje_error'])) {
            echo "<div class='alert alert-danger'>" . $_SESSION['mensaje_error'] . "</div>";
            unset($_SESSION['mensaje_error']); // Eliminar el mensaje después de mostrarlo
        } elseif (isset($_SESSION['mensaje_ok'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['mensaje_ok'] . "</div>";
            unset($_SESSION['mensaje_ok']); // Eliminar el mensaje después de mostrarlo
        }
        ?>

        <!-- Campo de Usuario -->
        <div class="mb-3">
            <label for="usuario" class="form-label"><i class="fa-solid fa-user"></i> Usuario</label>
            <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Nombre de usuario" required>
        </div>
        
        <!-- Campo de Contraseña -->
        <div class="mb-3">
            <label for="contraseña" class="form-label"><i class="fa-solid fa-lock"></i> Contraseña</label>
            <input type="password" name="contraseña" id="contraseña" class="form-control" placeholder="Contraseña" required>
        </div>

        <hr>
        <!-- Botón para crear una cuenta -->
        <button type="submit" name="registro" class="btn btn-outline-success w-100 mb-2">CREAR CUENTA</button>

        <!-- Botón para redirigir al inicio de sesión -->
        <a href="iniciarsesion.php" class="btn btn-primary w-100">INICIAR SESIÓN</a>
    </form>
</body>
</html>
