<?php
$host = "localhost";
$user = "root";
$pass = "";
$bd = "noticias";

// Conexión a la base de datos
$conn = mysqli_connect($host, $user, $pass, $bd);

// verifico si la conexion fue exitosa
if($conn->connect_error){
    echo ("conexion error: " .$conn->connect_error);
    exit;
}

// funcion para añadir un usuario
function añadir($usuario , $contraseña, $nivel)
{
    global $conn;

    // Verificar si el nombre de usuario ya existe
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si ya existe el nombre de usuario, devolver false
    if ($result->num_rows > 0) {
        return false;  // El nombre de usuario ya está en uso
    } else {
        // Preparar la consulta
        $sql = $conn->prepare("INSERT INTO usuarios (usuario, contraseña, nivel) VALUES (?, ?, ?)");
        
        if ($sql === false) {
            echo "Error al preparar la consulta: " . $conn->error;
            return false;
        }
    }



    // Vincular los parámetros
    $sql->bind_param("ssi", $usuario, $contraseña , $nivel);

    // Ejecutar la consulta y verificar el resultado
    if ($sql->execute()) {
        return true;
    } else {
        echo "Error al registrar usuario: " . $sql->error;
        return false;
    }
}
?>
