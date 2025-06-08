<?php
include "conexion.php";
session_start();

$msg = "";
$id = null;
$id_noticia = null;
$item = null;




// Si el nivel es >=5, mostrar edición de noticias
if (isset($_SESSION['nivel']) && $_SESSION['nivel'] >= 5) {
    if (isset($_GET['id'])) {
        $id_noticia = $_GET['id'];

        $stmt = $conn->prepare("SELECT * FROM noticias WHERE id=?");
        $stmt->bind_param("s", $id_noticia);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
    } elseif (isset($_POST['id']) && isset($_POST['txtTitular']) && isset($_POST['txtContent'])) {
        $sId = $_POST['id'];
        $sTitular = $_POST['txtTitular'];
        $sContent = $_POST['txtContent'];

        $stmt = $conn->prepare("UPDATE noticias SET titulo=?, descripcion=? WHERE id=?");
        $stmt->bind_param("sss", $sTitular, $sContent, $sId);

        if ($stmt->execute()) {
            $conn->close();
            header('location: intranet.php?op=upok');
        } else {
            $conn->close();
            header('location: intranet.php?op=errpeticio');
        }
    }
}









// Si el nivel es 99, mostrar edición de usuarios
if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 99) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

    } elseif (isset($_POST['id']) && isset($_POST['txtUsuario']) && isset($_POST['txtNivel']) && isset($_POST['txtpasswor'])) {
        $sId = $_POST['id'];
        $sUsuario = $_POST['txtUsuario'];
        $sNivel = $_POST['txtNivel'];
        $sPass =  $_POST['txtpasswor'];
        $bloqueado = isset($_POST['bloqueado']) ? 1 : 0;


        // si se ha introducido una nueva contraseña, se actualiza
        if (isset($_POST['txtpasswor']) && isset($_POST['txtpasswor'])) {
            $PassHash = password_hash($sPass, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("UPDATE usuarios SET usuario=?, nivel=?, bloqueado=?, contraseña=? WHERE id=?");
            $stmt->bind_param("ssisi", $sUsuario, $sNivel, $bloqueado, $PassHash, $sId);
        }

        if ($stmt->execute()) {
            $conn->close();
            header('location: usuario99.php?op=ok');
        } else {
            $conn->close();
            header('location: usuario99.php?op=error');
        }
    }
}








// Si el nivel es 66, mostrar edición de usuarios 
if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 666){
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

    } elseif (isset($_POST['id']) && isset($_POST['txtUsuario']) && isset($_POST['txtNivel']) && isset($_POST['txtpasswor'])) {
        $sId = $_POST['id'];
        $sUsuario = $_POST['txtUsuario'];
        $sNivel = $_POST['txtNivel'];
        $sPass =  $_POST['txtpasswor'];
        


        // si se ha introducido una nueva contraseña, se actualiza
        if (isset($_POST['txtpasswor']) && isset($_POST['txtpasswor'])) {
            $PassHash = password_hash($sPass, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("UPDATE usuarios SET usuario=?, nivel=?, contraseña=? WHERE id=?");
            $stmt->bind_param("sssi", $sUsuario, $sNivel, $PassHash, $sId);
        }

        if ($stmt->execute()) {
            $conn->close();
            header('location: gestion_usuarios.php?op=ok');
        } else {
            $conn->close();
            header('location: gestion_usuarios.php?op=error');
        }
    }
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
    <title>Document</title>
</head>

<body>
    <div class="container">

        <nav class="navbar navbar-default">
            <div class="container-fluid">
             
            <?php
                // <!--redirigir al usuario segun su nivel -->
                if (isset($_SESSION['nivel'])) {
                    if ($_SESSION['nivel'] == 5) {
                        echo '<a class="navbar-brand" href="intranet.php">ASIX Website. Página Nivel 5</a>';
                    } elseif ($_SESSION['nivel'] == 99) {
                        echo '<a class="navbar-brand" href="usuario99.php">ASIX Website. Página Nivel 99</a>';
                    } elseif ($_SESSION['nivel'] == 666) {
                        echo '<a class="navbar-brand" href="gestion_usuarios.php">ASIX Website. Página Nivel 66</a>';
                    } 
                } 
            ?>


                <ul class="nav navbar-nav">
                    <li><a href="index.php"><i class="glyphicon glyphicon-list"></i> Llista</a></li>
                    <li><a href="create.php"><i class="glyphicon glyphicon-plus"></i> Crear</a></li>
                </ul>
            </div>
        </nav>


    <?php
        // Mostrar formulario de edición de noticias si nivel == 5
        if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 5) {
            echo '
            <h1>Actualizar noticia</h1>

            <form method="POST" action="edit.php">
                <input type="hidden" name="id" value="' . $id_noticia . '">
                <div class="form-group">
                    <label for="idtxtTitular">Titular noticia:</label>
                    <input type="text" class="form-control" name="txtTitular" id="idtxtTitular" value="' . ($item["titulo"]) . '">
                </div>
                <div class="form-group">
                    <label for="idtxtContent">Contenido noticia:</label>
                    <textarea class="form-control" name="txtContent" id="idtxtContent" cols="30" rows="10">' . ($item["descripcion"]) . '</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>';
        }



        // Mostrar formulario de edición de usuarios si nivel == 99
        if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 99) {
            echo '
            <h1>Actualizar usuario</h1>

            <form method="POST" action="edit.php">
                <input type="hidden" name="id" value="' . $id . '">
                <div class="form-group">
                    <label for="idtxtUsuario">Usuario:</label>
                    <input type="text" class="form-control" name="txtUsuario" id="idtxtUsuario" value="' . ($item["usuario"]) . '">
                </div>
                <div class="form-group">
                    <label for="idtxtNivel">Nivel:</label>
                    <input type="number" class="form-control" name="txtNivel" id="idtxtNivel" value="' . ($item["nivel"] ) . '">
                </div>
                <div class="form-group">
                    <label for="idtxtpasswor">Contraseña:</label>
                    <input type="password" class="form-control" name="txtpasswor" id="idtxtpasswor" placeholder="Introduce nueva contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>';
        }






        // Mostrar formulario de edición de usuarios si nivel == 666
        if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 666) {
            echo '
            <h1>Actualizar usuario</h1>

            <form method="POST" action="edit.php">
                <input type="hidden" name="id" value="' . $id . '">
                <div class="form-group">
                    <label for="idtxtUsuario">Usuario:</label>
                    <input type="text" class="form-control" name="txtUsuario" id="idtxtUsuario" value="' . ($item["usuario"]) . '">
                </div>
                <div class="form-group">
                    <label for="idtxtNivel">Nivel:</label>
                    <input type="number" class="form-control" name="txtNivel" id="idtxtNivel" value="' . ($item["nivel"] ) . '">
                </div>
                <div class="form-group">
                    <label for="idtxtpasswor">Contraseña:</label>
                    <input type="password" class="form-control" name="txtpasswor" id="idtxtpasswor" placeholder="Introduce nueva contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>';
        }
    ?>
    </div>
       
</body>

</html>
