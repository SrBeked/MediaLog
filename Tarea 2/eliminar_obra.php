<?php
$codigo = $_GET['codigo'] ?? '';

if (!$codigo) {
    header('Location: ver_obras.php');
    exit;
}

$obras = file_exists('datos/obras.json') ? json_decode(file_get_contents('datos/obras.json'), true) : [];
$obras = array_filter($obras, fn($obra) => $obra['codigo'] !== $codigo);

// Guardar
file_put_contents('datos/obras.json', json_encode(array_values($obras), JSON_PRETTY_PRINT));

header('Location: ver_obras.php');
exit;
?>
