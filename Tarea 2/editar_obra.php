<?php
$codigo = $_GET['codigo'] ?? '';
$obras = file_exists('datos/obras.json') ? json_decode(file_get_contents('datos/obras.json'), true) : [];

$obra = null;
foreach ($obras as $o) {
    if ($o['codigo'] === $codigo) {
        $obra = $o;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($obras as &$o) {
        if ($o['codigo'] === $codigo) {
            $o['nombre'] = $_POST['nombre'];
            $o['descripcion'] = $_POST['descripcion'];
            $o['pais'] = $_POST['pais'];
            $o['autor'] = $_POST['autor'];
            $o['tipo'] = $_POST['tipo'];
            $o['foto_url'] = $_POST['foto_url'];
            break;
        }
    }
    file_put_contents('datos/obras.json', json_encode($obras, JSON_PRETTY_PRINT));
    header("Location: detalle.php?codigo=" . urlencode($codigo));
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Obra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(56, 102, 84);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            text-align: center;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 15px;
            color: #333;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            margin-top: 5px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .button-group {
            text-align: center;
            margin-top: 20px;
        }

        button,
        .btn-link {
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            background-color:rgb(0, 0, 0);
            color: white;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 0 5px;
        }

        button:hover,
        .btn-link:hover {
            background-color:rgb(255, 0, 0);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Editar Obra</h2>

    <?php if ($obra): ?>
    <form method="post">
        <label>Nombre:
            <input type="text" name="nombre" value="<?= htmlspecialchars($obra['nombre']) ?>">
        </label>

        <label>Descripción:
            <textarea name="descripcion"><?= htmlspecialchars($obra['descripcion']) ?></textarea>
        </label>

        <label>País:
            <input type="text" name="pais" value="<?= htmlspecialchars($obra['pais']) ?>">
        </label>

        <label>Autor:
            <input type="text" name="autor" value="<?= htmlspecialchars($obra['autor']) ?>">
        </label>

        <label>Tipo:
            <input type="text" name="tipo" value="<?= htmlspecialchars($obra['tipo']) ?>">
        </label>

        <label>Foto URL: <input type="text" name="foto_url" value="<?= htmlspecialchars($obra['foto_url']) ?>"></label><br>

        <div class="button-group">
            <button type="submit">Guardar cambios</button>
            <a href="detalle.php?codigo=<?= urlencode($codigo) ?>" class="btn-link">← Volver a detalles</a>
        </div>
    </form>
    <?php else: ?>
        <p>Obra no encontrada.</p>
    <?php endif; ?>
</div>

</body>
</html>
