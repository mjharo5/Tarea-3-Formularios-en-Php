<?php

$precios = [
    "hamburguesa" => 35,
    "papas" => 15,
    "refresco" => 12,
    "pizza" => 70,
    "nuggets" => 25,
    "ensalada" => 30,
    "yogurth" => 15,
    "agua" => 12
];

$subtotal = 0;

/* PAQUETES */
if (!empty($_POST["paquete"])) {
    switch ($_POST["paquete"]) {
        case "paquete1":
            $subtotal += 35 + 15 + 12;
            break;
        case "paquete2":
            $subtotal += 70 + 25 + 12;
            break;
        case "paquete3":
            $subtotal += 30 + 15 + 12;
            break;
    }
}

/* PRODUCTOS INDIVIDUALES */
foreach ($precios as $producto => $precio) {
    $cantidad = intval($_POST[$producto] ?? 0);
    $subtotal += $cantidad * $precio;
}

$iva = $subtotal * 0.16;
$total = $subtotal + $iva;
$pago = floatval($_POST["pago"]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de Venta</title>
    <link rel="stylesheet" href="estilos2.css">
</head>
<body>

<h2>RESULTADO DE LA VENTA</h2>

<p>Subtotal: $<?= number_format($subtotal,2) ?></p>
<p>IVA (16%): $<?= number_format($iva,2) ?></p>
<p>Total a pagar: $<?= number_format($total,2) ?></p>
<p>Pago del cliente: $<?= number_format($pago,2) ?></p>

<?php
if ($pago < $total) {
    echo "<p class='error'>❌ Pago insuficiente</p>";
} else {
    $cambio = $pago - $total;
    echo "<p>Cambio: $" . number_format($cambio,2) . "</p>";
}
?>

<a href="formulario2.html">⬅ Volver</a>

</body>
</html>
