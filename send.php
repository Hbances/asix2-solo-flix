<?php
// para enviar mensajes a otros usuarios de cualquier nivel
include "conexion.php";
session_start();

if (!isset($_SESSION['id'])) {
    die("Error: No se ha iniciado sesión.");
}

// Obtener el nombre del usuario remitente
$remitente_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT usuario FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $remitente_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $remitente_nombre = $result->fetch_assoc()['usuario'];
} else {
    die("Error: No se pudo obtener el nombre del remitente.");
}

// Obtener lista de usuarios para el select (excepto el remitente)
$stmt = $conn->prepare("SELECT id, usuario FROM usuarios WHERE id != ?");
$stmt->bind_param("i", $remitente_id);
$stmt->execute();
$usuarios_result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destinatario = $_POST['destinatario'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];

    // Validar destinatario
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $destinatario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("El destinatario no existe.");
    }

    // Insertar mensaje
    $stmt = $conn->prepare("INSERT INTO mensajes (remitente_id, destinatario_id, asunto, mensaje) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $remitente_id, $destinatario, $asunto, $mensaje);

    if ($stmt->execute()) {
        header("location: inbox.php");
        exit;
    } else {
        die("Error al enviar el mensaje: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Missatge</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Enviar Missatge</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="remitente">Remitent</label>
                <input type="text" name="remitente" class="form-control" value="<?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="destinatario">Destinatari</label>
                <select name="destinatario" class="form-control" required>
                    <option value="">-- Selecciona un usuario --</option>
                    <?php while ($row = $usuarios_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars($row['usuario']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="asunto">Assumpte</label>
                <input type="text" name="asunto" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="mensaje">Missatge</label>
                <textarea name="mensaje" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <hr>

        <?php
        if (isset($_SESSION['nivel'])) {
            if ($_SESSION['nivel'] == 5) {
                echo "<a href='intranet.php' class='btn btn-primary'>Volver a usuario 5</a>";
            } elseif ($_SESSION['nivel'] == 99) {
                echo "<a href='usuario99.php' class='btn btn-primary'>Volver a usuario 99</a>";
            } elseif ($_SESSION['nivel'] == 0) {
                echo "<a href='usuario0.php' class='btn btn-primary'>Volver a usuario 0</a>";
            } elseif ($_SESSION['nivel'] == 666) {
                echo "<a href='gestion_usuarios.php' class='btn btn-primary'>Volver a usuario 66</a>";
            }
        }
        ?>
    </div>
</body>

</html>