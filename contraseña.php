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




// / Obtener el nivel del usuario desde la base de datos
$usuario = $_SESSION['nombre_usuario'];

$sql = "SELECT nivel FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($nivel);
$stmt->fetch();
$stmt->close();



// proceso de cambiar la contraseña
if (isset($_POST['cambiar_contraseña'], $_POST['nueva_contraseña'], $_POST['confirmar_contraseña'])) {
    $nueva_contraseña = $_POST['nueva_contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    if ($nueva_contraseña === $confirmar_contraseña) {
        $encriptado = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos
        $sql_update = "UPDATE usuarios SET contraseña = ? WHERE usuario = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ss", $encriptado, $usuario);
        $stmt_update->execute();
        $stmt_update->close();

        $_SESSION['mensaje_exito'] = "Contraseña cambiada con éxito.";
    } else {
        $_SESSION['mensaje_error'] = "Las contraseñas no coinciden.";
    }

    header("Location: contraseña.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <title>Cambiar Contraseña</title>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Cambiar Contraseña</h2>

        <!-- Mostrar mensajes -->
        <?php
        if (isset($_SESSION['mensaje_exito'])) {
            echo "<div class='alert alert-success mt-3'>{$_SESSION['mensaje_exito']}</div>";
            unset($_SESSION['mensaje_exito']);
        }

        if (isset($_SESSION['mensaje_error'])) {
            echo "<div class='alert alert-danger mt-3'>{$_SESSION['mensaje_error']}</div>";
            unset($_SESSION['mensaje_error']);
        }
        ?>

        <form action="contraseña.php" method="post" class="mt-4 mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <input
                    type="password"
                    class="form-control form-control-sm"
                    id="nueva_contraseña"
                    name="nueva_contraseña"
                    placeholder="Nueva contraseña">
            </div>
            <div class="mb-3">
                <input
                    type="password"
                    class="form-control form-control-sm"
                    id="confirmar_contraseña"
                    name="confirmar_contraseña"
                    placeholder="Confirmar contraseña">
            </div>
            <button
                type="submit"
                class="btn btn-primary btn-sm w-100"
                name="cambiar_contraseña">
                Cambiar Contraseña
            </button>
            <a href="usuario0.php" class="btn btn-secondary btn-sm w-100 mt-3">Regresar</a>
        </form>
    </div>
</body>

</html>