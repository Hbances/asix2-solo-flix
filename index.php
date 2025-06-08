<?php

include 'conexion.php';

// se obtiene la fecha actual
$fechaActual = date("Y-m-d H:i:s");

// se obtienen las noticias que ya se pueden mostrar
$sql = "SELECT * FROM noticias WHERE fecha_publico <= ? ORDER BY fecha_publico ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fechaActual);
$stmt->execute();
$result = $stmt->get_result();


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <title>PAGINA PRINCIPAL</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto">
        <li class="nav-item active">
          <a class="nav-link btn btn-success mx-2" href="iniciarsesion.php">INICIAR SESIÓN<span class="sr-only"></span></a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-4">
    <h2 class="text-center">Últimas Noticias</h2>

    <table class="table table-hover table-striped mt-4">
      <thead class="bg-primary text-white">
        <tr>
          <th>#</th>
          <th>Título</th>
          <th>Descripción</th>
          <th>Fecha creación</th>
          <th>Fecha publicación</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $contador = 1;
        while ($row = $result->fetch_assoc()) {
          $descripcionCorta = substr($row['descripcion'], 0, 50) .  '...';
          $titulocorto = substr($row['titulo'], 0, 50) .  '...';

          echo "<tr data-bs-toggle='modal' data-bs-target='#noticiaModal{$contador}' style='cursor: pointer;'>";
          echo "<td>{$contador}</td>";
          echo "<td>{$titulocorto}</td>";
          echo "<td>{$descripcionCorta}</td>";
          echo "<td>{$row['fecha']}</td>";
          echo "<td>{$row['fecha_publico']}</td>";
          echo "</tr>";
        ?>
        <!-- modal -->
          <div class="modal fade" id="noticiaModal<?php echo $contador; ?>" tabindex="-1" aria-labelledby="modalLabel<?php echo $contador; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalLabel<?php echo $contador; ?>"><?php echo $row['titulo']; ?></h5>
                  <button type="button" class="btn-close btn btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p><?php echo $row['descripcion']; ?></p>
                </div>
              </div>
            </div>
          </div>
        <?php
          $contador++;
        }
        ?>
      </tbody>
    </table>
  </div>
</body>