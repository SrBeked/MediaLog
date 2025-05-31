<?php
function calcularEdad($fechaNacimiento) {
    $hoy = new DateTime();
    $nacimiento = new DateTime($fechaNacimiento);
    $edad = $hoy->diff($nacimiento);
    return $edad->y;
}

function signoZodiacal($fechaNacimiento) {
    $fecha = new DateTime($fechaNacimiento);
    $mes = (int)$fecha->format('m');
    $dia = (int)$fecha->format('d');

    $signos = [
        ['capricornio', 1, 19], ['acuario', 2, 18], ['piscis', 3, 20],
        ['aries', 4, 19], ['tauro', 5, 20], ['geminis', 6, 20],
        ['cancer', 7, 22], ['leo', 8, 22], ['virgo', 9, 22],
        ['libra', 10, 22], ['escorpio', 11, 21], ['sagitario', 12, 21],
        ['capricornio', 12, 31]
    ];

    foreach ($signos as $signo) {
        if ($mes == $signo[1] && $dia <= $signo[2]) {
            return ucfirst($signo[0]);
        }
    }
    return 'Desconocido';
}

$codigoObra = $_GET['codigo'] ?? '';

$obras = file_exists('datos/obras.json') ? json_decode(file_get_contents('datos/obras.json'), true) : [];
$personajes = file_exists('datos/personajes.json') ? json_decode(file_get_contents('datos/personajes.json'), true) : [];

$obra = null;
foreach ($obras as $o) {
    if ($o['codigo'] === $codigoObra) {
        $obra = $o;
        break;
    }
}

$personajesObra = array_filter($personajes, fn($p) => $p['obra_codigo'] === $codigoObra);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Obra</title>
    <style>
        body { font-family: Arial; background-color:rgba(111, 221, 77, 0.72); padding: 20px; }
        h2, h3 { margin-top: 0; }
        img { max-width: 200px; }
        .personaje { margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
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

<?php if ($obra): ?>
    <h2>Detalle de la Obra</h2>
    <img src="<?= htmlspecialchars($obra['foto_url']) ?>" alt="Imagen de la obra"><br>
    <p><strong>Código:</strong> <?= htmlspecialchars($obra['codigo']) ?></p>
    <p><strong>Tipo:</strong> <?= htmlspecialchars($obra['tipo']) ?></p>
    <p><strong>Nombre:</strong> <?= htmlspecialchars($obra['nombre']) ?></p>
    <p><strong>Descripción:</strong> <?= htmlspecialchars($obra['descripcion']) ?></p>
    <p><strong>País:</strong> <?= htmlspecialchars($obra['pais']) ?></p>
    <p><strong>Autor:</strong> <?= htmlspecialchars($obra['autor']) ?></p>

    <h3>Personajes</h3>
    <?php if (count($personajesObra) > 0): ?>
        <?php foreach ($personajesObra as $p): ?>
            <div class="personaje">
                <img src="<?= htmlspecialchars($p['foto_url']) ?>" alt="Foto del personaje"><br>
                <strong><?= htmlspecialchars($p['nombre']) . ' ' . htmlspecialchars($p['apellido']) ?></strong><br>
                <small>Edad: <?= calcularEdad($p['fecha_nacimiento']) ?> años</small><br>
                <small>Signo Zodiacal: <?= signoZodiacal($p['fecha_nacimiento']) ?></small><br>
                <p><strong>Habilidades:</strong> <?= htmlspecialchars(implode(", ", $p['habilidades'])) ?></p>
                <p><strong>Comida Favorita:</strong> <?= htmlspecialchars($p['comida_favorita']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay personajes registrados para esta obra.</p>
    <?php endif; ?>

<?php else: ?>
    <p>Obra no encontrada.</p>
<?php endif; ?>

<div class="back">
    <a href="ver_obras.php">← Volver a la lista</a>
    <a href="editar_obra.php?codigo=<?= urlencode($obra['codigo']) ?>">Editar Obra</a>
</div>


</body>
</html>
