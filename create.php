<?php
session_start();

include "conexion.php"; // Conexión a la base de datos


// si el nivel es 5, mostrar formulario de creación de noticia
if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 5) {
    if (isset($_POST['txtTitular'], $_POST['txtContent'], $_POST['txtFechaPublico'])) {

        // Preparar y enlazar la consulta
        $stmt = $conn->prepare("INSERT INTO noticias (titulo, descripcion, fecha_publico) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $sTitular, $sContent, $sFechaPublico);

        // Asignar valores a los parámetros
        $sTitular = $_POST['txtTitular'];
        $sContent = $_POST['txtContent'];
        $sFechaPublico = $_POST['txtFechaPublico'];

        // Validar que la fecha de publicación sea anterior a la actual
        if (strtotime($sFechaPublico) == time()) {
        } else {
            // Ejecutar consulta
            if ($stmt->execute()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Noticia creada exitosamente</div>";
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Error al crear la noticia: " . $stmt->error . "</div>";
            }
        }

        // Cerrar conexión
        $stmt->close();
        $conn->close();

        // Redirigir para evitar reenvío del formulario
        header("Location: create.php");
        exit();
    }
}



// si el nivel es 99, mostrar formulario de creación de usuario
if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 99) {
    if(isset($_POST['txtUsuario'], $_POST['txtNivel'], $_POST['txtpasswor'])){

        

        // Asignar valores a los parámetros
        $sUsuario = $_POST['txtUsuario'];
        $sNivel = $_POST['txtNivel'];
        $sPass = $_POST['txtpasswor'];


        // restringir la creacion de un usuario de nivel 666
        if($sNivel == 666){
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Error: No está permitido crear usuarios con nivel 66.</div>";
        }else{
            // si el nivel es valido procedo a la creacion de los usuarios 

            // si se ha introducido una nueva contraseña, se actualiza
            $PassworHash = password_hash($sPass, PASSWORD_DEFAULT);
                
            // Preparar y enlazar la consulta
            $stmt = $conn->prepare("INSERT INTO usuarios (usuario, nivel, contraseña) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $sUsuario, $sNivel, $PassworHash);
            

            // Ejecutar consulta
            if ($stmt->execute()) {
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuario creado exitosamente</div>";
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Error al crear el usuario: " . $stmt->error . "</div>";
            }

            // Cerrar conexión
            $stmt->close();

            
        }

        
        $conn->close();
        // Redirigir para evitar reenvío del formulario
        header("Location: create.php");
        exit();
        
    }
}


///si el nivel es 66, mostrar formulario de creación de usuario
if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 666) {
    if(isset($_POST['txtUsuario'], $_POST['txtNivel'], $_POST['txtpasswor'])){

        

        // Asignar valores a los parámetros
        $sUsuario = $_POST['txtUsuario'];
        $sNivel = $_POST['txtNivel'];
        $sPass = $_POST['txtpasswor'];


        // si se ha introducido una nueva contraseña, se actualiza
        $PassworHash = password_hash($sPass, PASSWORD_DEFAULT);
            
        // Preparar y enlazar la consulta
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, nivel, contraseña) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $sUsuario, $sNivel, $PassworHash);
        

        // Ejecutar consulta
        if ($stmt->execute()) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Usuario creado exitosamente</div>";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Error al crear el usuario: " . $stmt->error . "</div>";
        }

        // Cerrar conexión
        $stmt->close();
        $conn->close();

        // Redirigir para evitar reenvío del formulario
        header("Location: create.php");
        exit();
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
    <title>Crear Noticia</title>
</head>

<body>
    <div class="container" style="margin-top: 30px;">

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
                    <li class="active"><a href="create.php"><i class="glyphicon glyphicon-plus"></i> Crear</a></li>
                </ul>
            </div>
        </nav>



        <!-- formulario de crear noticia para el nivel 5 -->
    <?php
        if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 5) {
            echo '
                    <h1>Crear Noticia</h1>
                
                    <form method="POST" action="create.php">
                        <div class="form-group">
                            <label for="idtxtFechaPublico">Fecha de Publicación:</label>
                            <input type="datetime-local" class="form-control" name="txtFechaPublico" id="idtxtFechaPublico" required>
                        </div>
                        <div class="form-group">
                            <label for="idtxtTitular">Titular de la Noticia:</label>
                            <input type="text" class="form-control" name="txtTitular" id="idtxtTitular" required>
                        </div>
                        <div class="form-group">
                            <label for="idtxtContent">Contenido de la Noticia:</label>
                            <textarea class="form-control" name="txtContent" id="idtxtContent" cols="30" rows="10" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                        <div class="form-group">';
                            // Mostrar el mensaje si existe en la sesión
                            if (isset($_SESSION["msg"])) {
                                echo $_SESSION["msg"];
                                unset($_SESSION["msg"]); // Eliminar mensaje después de mostrarlo
                            }
                            echo '
                        </div>
                    </form>';
        }






        // <!-- formulario de crear usuario para el nivel 99 -->
        if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 99) {
            echo '
            <h1>Crear usuario</h1>
        
            <form method="POST" action="create.php">
                <div class="form-group">
                    <label for="idtxtUsuario">Nombre usuario:</label>
                    <input type="text" class="form-control" name="txtUsuario" id="idtxtUsuario" required>
                </div>
                <div class="form-group">
                    <label for="idtxtNivel">Nivel:</label>
                    <input type="number" class="form-control" name="txtNivel" id="idtxtNivel" required>
                </div>
                <div class="form-group">
                    <label for="idtxtpasswor">Contraseña:</label>
                    <input type="password" class="form-control" name="txtpasswor" id="idtxtpasswor" placeholder="Ejemplo 1234" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
                <div class="form-group">';
                    // Mostrar el mensaje si existe en la sesión
                    if (isset($_SESSION["msg"])) {
                        echo $_SESSION["msg"];
                        unset($_SESSION["msg"]); // Eliminar mensaje después de mostrarlo
                    }
                    echo '
                </div>
            </form>';
        }







        // <!-- formulario de crear usuario para el nivel 666 -->
        if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 666) {
            echo '
            <h1>Crear usuario</h1>
        
            <form method="POST" action="create.php">
                <div class="form-group">
                    <label for="idtxtUsuario">Nombre usuario:</label>
                    <input type="text" class="form-control" name="txtUsuario" id="idtxtUsuario" required>
                </div>
                <div class="form-group">
                    <label for="idtxtNivel">Nivel:</label>
                    <input type="number" class="form-control" name="txtNivel" id="idtxtNivel" required>
                </div>
                <div class="form-group">
                    <label for="idtxtpasswor">Contraseña:</label>
                    <input type="password" class="form-control" name="txtpasswor" id="idtxtpasswor" placeholder="Ejemplo 1234" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
                <div class="form-group">';
                    // Mostrar el mensaje si existe en la sesión
                    if (isset($_SESSION["msg"])) {
                        echo $_SESSION["msg"];
                        unset($_SESSION["msg"]); // Eliminar mensaje después de mostrarlo
                    }
                    echo '
                </div>
            </form>';
        }
    ?>

    </div>
</body>

</html>