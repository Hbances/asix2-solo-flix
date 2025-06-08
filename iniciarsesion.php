<?php
session_start();
include("conexion.php");

// Verifico si se han enviado correctamente el nombre de usuario y la contraseña mediante el formulario
if (isset($_POST['nombre_usuario']) && isset($_POST['contraseña'])) {
    // Obtengo el nombre de usuario y la contraseña del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $contraseña = $_POST['contraseña'];

    // Verifico si el campo del nombre de usuario está vacío
    if (empty($nombre_usuario)) {
        header("location: login.php?error=El nombre de usuario es requerido");
        exit();
    } elseif (empty($contraseña)) {
        header("location: login.php?error=La contraseña es requerida");
        exit();
    } else {
        // Preparo la consulta para obtener el usuario de la base de datos por nombre_usuario
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifico si se encontró un usuario con el nombre que ponemos en el formulario
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Comparo las contraseñas, si coinciden inicio sesión
            if (password_verify($contraseña, $row['contraseña'])) {
                // Inicio sesión y almaceno la información del usuario
                $_SESSION['login'] = true;
                $_SESSION['nombre_usuario'] = $row['usuario'];
                $_SESSION['nivel'] = $row['nivel'];
                $_SESSION['id'] = $row['id'];

                if ($row['nivel'] == 0) {
                    // Redirijo al usuario a la página de inicio
                    header("location: usuario0.php");
                    exit();
                } elseif ($row['nivel'] == 5) {
                    // Redirijo al usuario a la página de inicio
                    header("location: intranet.php");
                    exit();
                } elseif ($row['nivel'] == 99) {
                    header("location: usuario99.php");
                    exit();
                }elseif($row['nivel'] == 666){
                    header("location: gestion_usuarios.php");
                    exit();
                }
                
            } else {
                // Si las contraseñas no coinciden, mando un error
                $_SESSION['mensaje_error'] = "Usuario o contraseña incorrectos.";
                header("location: login.php");
                exit();
            }
        } else {
            // Si no se encuentra el usuario
            $_SESSION['mensaje_error'] = "Usuario o contraseña incorrectos.";
            header("location: login.php");
            exit();
        }

        // $stmt->close(); // Cierro la consulta
    }
} else {
    header("location: login.php");
    exit();
}
