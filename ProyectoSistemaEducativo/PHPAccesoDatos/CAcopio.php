<?php
require_once __DIR__ . '/Coneccion.php';

try {
    $pdo = Coneccion::obtenerConexion();

    // --- AGREGAR ---
    if (isset($_POST['agregar'])) {
        $sql = "INSERT INTO centros_acopio (nombre, provincia, materiales, horario) VALUES (?, ?, ?, ?)";
        $stmtInsert = $pdo->prepare($sql);
        $stmtInsert->execute([$_POST['nombre'], $_POST['provincia'], $_POST['materiales'], $_POST['horario']]);
    }

    // --- ELIMINAR ---
    if (isset($_GET['eliminar'])) {
        $sql = "DELETE FROM centros_acopio WHERE id = ?";
        $stmtDelete = $pdo->prepare($sql);
        $stmtDelete->execute([$_GET['eliminar']]);
    }

    // --- CONSULTAR ---
    $sql = "SELECT id, nombre, provincia, materiales, horario FROM centros_acopio";
    $stmt = $pdo->query($sql);

} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Centros de Acopio | EduAmbiente</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../css/styles.css">

</head>

<body class="bg-light">

<!-- header -->
<header class="navbar navbar-dark fw-bold bg-success">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="MDashboard.html">
      <img src="../../img/Logo.png" alt="Logo EduAmbiente" width="40" class="me-2 rounded-circle">
      EduAmbiente
    </a>
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link text-white d-flex align-items-center" href="perfil.html">
          <i class="bi bi-person-circle me-2"></i>
          Mi Perfil
        </a>
      </li>
    </ul>
  </div>
</header>

<div class="container-fluid">
<div class="row">

<!-- sidebar -->
<div class="col-2 bg-dark min-vh-100 p-3">
  <ul class="nav nav-pills flex-column">
    <a href="EdAmbiental.php" class="nav-link text-white mb-2 ulh">
      <i class="bi bi-book me-1"></i>Educación Ambiental
    </a>
    <a href="CAcopio.php" class="nav-link text-white mb-2 ulh">
      <i class="bi bi-recycle me-1"></i>Centros de Acopio
    </a>
    <a href="RuReciclaje.php" class="nav-link text-white mb-2 ulh">
      <i class="bi bi-compass-fill me-1"></i>Rutas de Reciclaje
    </a>
    <a href="RsEducativos.php" class="nav-link text-white mb-2 ulh">
      <i class="bi bi-book-half me-1"></i>Recursos Educativos
    </a>
  </ul>
</div>

<!-- contenido dinámico -->
<div class="container-fluid col-10 p-4">

  <h2 class="text-success">Centros de Acopio</h2>
  <p>
    En esta sección podrás encontrar diferentes centros de acopio donde los
    ciudadanos pueden llevar materiales reciclables para su correcta gestión
    y reutilización.
  </p>

  <!-- Formulario para agregar -->
  <div class="card p-3 mb-4">
    <h4 class="text-success">Agregar nuevo centro</h4>
    <form method="POST" action="CAcopio.php">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del centro</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="provincia" class="form-label">Provincia</label>
        <input type="text" name="provincia" id="provincia" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="materiales" class="form-label">Materiales que reciben</label>
        <textarea name="materiales" id="materiales" class="form-control" required></textarea>
      </div>
      <div class="mb-3">
        <label for="horario" class="form-label">Horario</label>
        <input type="text" name="horario" id="horario" class="form-control" required>
      </div>
      <button type="submit" name="agregar" class="btn btn-success">Agregar</button>
    </form>
  </div>

  <!-- Lista de centros -->
  <h3 class="text-success mb-4">Centros disponibles</h3>
  <div class="row g-4">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($row['nombre']) ?></h5>
            <p class="card-text"><strong>Provincia:</strong> <?= htmlspecialchars($row['provincia']) ?></p>
            <p class="card-text"><strong>Materiales:</strong> <?= htmlspecialchars($row['materiales']) ?></p>
            <p class="card-text"><strong>Horario:</strong> <?= htmlspecialchars($row['horario']) ?></p>
            <a href="CAcopio.php?eliminar=<?= $row['id'] ?>" class="btn btn-danger btn-sm mt-2">Eliminar</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>

</div>

</div>
</div>

<!-- footer -->
<footer class="bg-success text-white text-center p-3">
© 2026 EduAmbiente | Universidad Fidelitas | Cliente Servidor Web | Grupo 1
</footer>

</body>
</html>
