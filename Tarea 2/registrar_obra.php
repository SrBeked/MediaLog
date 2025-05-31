<?php
$archivo = 'datos/obras.json';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nueva_obra = [
        "codigo" => $_POST["codigo"],
        "foto_url" => $_POST["foto_url"],
        "tipo" => $_POST["tipo"],
        "nombre" => $_POST["nombre"],
        "descripcion" => $_POST["descripcion"],
        "pais" => $_POST["pais"],
        "autor" => $_POST["autor"]
    ];

    $obras = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

    $obras[] = $nueva_obra;

    file_put_contents($archivo, json_encode($obras, JSON_PRETTY_PRINT));
    
    echo "<p style='color:Black;'>✅ Obra registrada con éxito.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Obra</title>
  <style>
    body { font-family: Arial; background-color:rgb(56, 102, 84); padding: 20px; }
    form { text-align: center; max-width: 500px; margin: auto; background: #f9f9f9; padding: 29px; border-radius: 8px; }
    input, select, textarea { width: 100%; padding: 8px; margin: 8px 0; }
    button { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
    h2 { text-align: center; color:rgb(255, 255, 255); }
    button:hover { background-color: #45a049; }
    .back { text-align: center; margin-top: 20px; }
    .back a {
      background-color:rgb(0, 0, 0);
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.3s ease;
    }
    .back a:hover {
      background-color:rgb(255, 0, 0);
    }
  </style>
</head>

<body>
  <h2>Registrar Nueva Obra</h2>
  <form method="POST">
    <label>Código:</label>
    <input type="text" name="codigo" required>

    <label>URL de la foto:</label>
    <input type="text" name="foto_url" required>

    <label>Tipo:</label>
    <select name="tipo">
      <option>Serie</option>
      <option>Película</option>
      <option>Otro</option>
    </select>

    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Descripción:</label>
    <textarea name="descripcion" rows="3"></textarea>

    <label>País:</label>
    <input type="text" name="pais" required>

    <label>Autor:</label>
    <input type="text" name="autor" required>

    <button type="submit">Registrar Obra</button>
  </form>

  <div class="back">
    <a href="index.php">← Volver al inicio</a>
  </div>
</body>
</html>
