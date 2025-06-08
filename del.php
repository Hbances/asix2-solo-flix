<?php
session_start();
include "conexion.php";


// si el usuario es de nivel 5  eliminar la noticia
if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 5){
  if (isset($_GET['id'])) {

  
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM noticias WHERE id=?");
    $stmt->bind_param("s", $id);
  
    $stmt->execute();
  
    $conn->close();
  
    header("location:intranet.php?op=delok");
  }
}


// si el usuario es de nivel 99 eliminar el usuario

if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 99){
  if (isset($_GET['id'])) {



    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt->bind_param("s", $id);

    $stmt->execute();
      
    $conn->close();
      
    header("location:usuario99.php?op=delok");
  }
}




// si el usuario es de nivel 66 eliminar el usuario
if(isset($_SESSION['nivel']) && $_SESSION['nivel'] == 666){
  if (isset($_GET['id'])) {



    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt->bind_param("s", $id);

    $stmt->execute();
      
    $conn->close();
      
    header("location: gestion_usuarios.php?op=delok");
  }
}