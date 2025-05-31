<?php
$archivoObras = 'datos/obras.json';
$archivoPersonajes = 'datos/personajes.json';

$obras = file_exists($archivoObras) ? json_decode(file_get_contents($archivoObras), true) : [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $personajes = file_exists($archivoPersonajes) ? json_decode(file_get_contents($archivoPersonajes), true) : [];

    $nuevo_codigo = uniqid("pers_");

    $nuevo_personaje = [
        "codigo" => $nuevo_codigo, // 👈 AÑADIDO
        "cedula" => $_POST["cedula"],
        "foto_url" => $_POST["foto_url"],
        "nombre" => $_POST["nombre"],
        "apellido" => $_POST["apellido"],
        "fecha_nacimiento" => $_POST["fecha_nacimiento"],
        "sexo" => $_POST["sexo"],
        "habilidades" => explode(",", $_POST["habilidades"]),
        "comida_favorita" => $_POST["comida_favorita"],
        "obra_codigo" => $_POST["obra_codigo"]
    ];

    $personajes[] = $nuevo_personaje;

    file_put_contents($archivoPersonajes, json_encode($personajes, JSON_PRETTY_PRINT));

    echo "<p style='color:Black;'>✅ Personaje registrado con éxito.</p>";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Personaje</title>
  <style>
    body { font-family: Arial; background-color:rgb(56, 102, 84); padding: 20px; }
    form { text-align: center; max-width: 600px; margin: auto; background: #f9f9f9; padding: 29px; border-radius: 8px; }
    input, select, textarea { width: 100%; padding: 8px; margin: 8px 0; }
    button { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
    h2 { text-align: center; color:rgb(255, 255, 255); }
    button:hover { background-color: #45a049; }
    .back { text-align: center; margin-top: 20px; }
    .back a { background-color:rgb(0, 0, 0);
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
  <h2>Agregar Personaje</h2>

  <form method="POST">
    <label>Cédula:</label>
    <input type="text" name="cedula" required>

    <label>Foto (URL):</label>
    <input type="text" name="foto_url" required>

    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>Apellido:</label>
    <input type="text" name="apellido" required>

    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nacimiento" required>

    <label>Sexo:</label>
    <select name="sexo">
      <option>Masculino</option>
      <option>Femenino</option>
    </select>

    <label>Habilidades (separadas por comas):</label>
    <input type="text" name="habilidades" placeholder="Ej: volar, invisibilidad">

    <label>Comida favorita:</label>
    <input type="text" name="comida_favorita">

    <label>Obra relacionada:</label>
    <select name="obra_codigo" required>
      <?php foreach ($obras as $obra): ?>
        <option value="<?= $obra['codigo'] ?>"><?= $obra['nombre'] ?> (<?= $obra['codigo'] ?>)</option>
      <?php endforeach; ?>
    </select>

    <button type="submit">Guardar personaje</button>
  </form>

  <div class="back">
    <a href="index.php">← Volver al inicio</a>
    
  </div>
</body>
</html>
