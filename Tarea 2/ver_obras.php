<?php
$archivoObras = 'datos/obras.json';
$archivoPersonajes = 'datos/personajes.json';

$obras = file_exists($archivoObras) ? json_decode(file_get_contents($archivoObras), true) : [];
$personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes), true) : [];

function contarPersonajes($codigoObra, $personajes) {
    $total = 0;
    foreach ($personajes as $p) {
        if ($p['obra_codigo'] == $codigoObra) {
            $total++;
        }
    }
    return $total;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Obras Registradas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
  h2 {
    text-align: center;
  }

</style>


</head>
<body class="bg-light">

  <div class="container mt-5">
    <h2 class="mb-4">Obras Registradas</h2>

    <table class="table table-striped table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>País</th>
          <th>Personajes</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($obras as $obra): ?>
          <tr>
            <td><?= htmlspecialchars($obra['nombre']) ?></td>
            <td><?= htmlspecialchars($obra['tipo']) ?></td>
            <td><?= htmlspecialchars($obra['pais']) ?></td>
            <td><?= contarPersonajes($obra['codigo'], $personajes) ?></td>
            <td>
              <a class="btn btn-primary btn-sm" href="detalle.php?codigo=<?= urlencode($obra['codigo']) ?>">
                Ver Detalle
              </a>
              <a href="eliminar_obra.php?codigo=<?= urlencode($obra['codigo']) ?>" class="btn btn-danger btn-sm"
              onclick="return confirm('¿Estás seguro de que deseas eliminar esta obra?');">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <a href="index.php" class="btn btn-secondary mt-3">← Volver al inicio</a>
  </div>

</body>
</html>

