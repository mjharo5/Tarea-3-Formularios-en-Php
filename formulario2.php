<?php
// ---------- REINICIAR VENTA ----------
if (isset($_POST['nueva_venta'])) {
    $_POST = [];
}

// ---------- PRECIOS ----------
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

// ---------- VARIABLES ----------
$subtotal = 0;
$iva = 0;
$total = 0;
$pago = 0;
$cambio = 0;
$error = "";
$mostrarTotales = false;
$mostrarPago = false;

// ---------- PROCESAMIENTO ----------
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['nueva_venta'])) {

    // --- PAQUETES ---
    if (!empty($_POST["paquete"]) && $_POST["paquete"] !== "ninguno") {
        switch ($_POST["paquete"]) {
            case "paquete1": $subtotal = 62; break;
            case "paquete2": $subtotal = 107; break;
            case "paquete3": $subtotal = 57; break;
        }
    } else {
        // --- PRODUCTOS ---
        foreach ($precios as $producto => $precio) {
            $cantidad = intval($_POST[$producto] ?? 0);
            $subtotal += $cantidad * $precio;
        }
    }

    // --- TOTALES ---
    $iva = $subtotal * 0.15;
    $total = $subtotal + $iva;
    $mostrarTotales = true;

    // --- PAGAR ---
    if (($_POST["accion"] ?? '') === "pagar") {
        $pago = floatval($_POST["pago"] ?? 0);

        if ($pago < $total) {
            $error = "Pago insuficiente";
        } else {
            $cambio = $pago - $total;
        }
        $mostrarPago = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Formulario de Ventas</title>
<link rel="stylesheet" href="estilos2.css">
</head>
<body>

<h2>FORMULARIO DE VENTAS</h2>

<div class="contenedor">
<form method="POST" action="#resultado">

<!-- ================= BLOQUE SUPERIOR ================= -->
<div class="bloque-superior">

    <!-- PAQUETES -->
    <fieldset>
        <legend>Paquetes</legend>

        <label>
            <input type="radio" name="paquete" value="paquete1"
            <?= ($_POST["paquete"] ?? '') === 'paquete1' ? 'checked' : '' ?>>
            $62 Hamburguesa + Papas + Refresco
        </label><br>

        <label>
            <input type="radio" name="paquete" value="paquete2"
            <?= ($_POST["paquete"] ?? '') === 'paquete2' ? 'checked' : '' ?>>
            $107 Pizza + Nuggets + Refresco
        </label><br>

        <label>
            <input type="radio" name="paquete" value="paquete3"
            <?= ($_POST["paquete"] ?? '') === 'paquete3' ? 'checked' : '' ?>>
            $57 Ensalada + Yogurth + Agua
        </label><br>

        <label>
            <input type="radio" name="paquete" value="ninguno"
            <?= ($_POST["paquete"] ?? '') === 'ninguno' ? 'checked' : '' ?>>
            Otras opciones
        </label>
    </fieldset>

    <!-- PEDIDOS -->
    <fieldset>
        <legend>Pedidos</legend>
        <div class="pedidos-grid">
            <?php foreach ($precios as $producto => $precio): ?>
                <div><?= ucfirst($producto) ?> ($<?= $precio ?>):</div>
                <input type="number" name="<?= $producto ?>" min="0"
                       value="<?= $_POST[$producto] ?? 0 ?>" class="caja">
            <?php endforeach; ?>
        </div>
    </fieldset>

</div>

<button type="submit" name="accion" value="calcular">CALCULAR</button>

<!-- ================= RESULTADOS ================= -->
<?php if ($mostrarTotales): ?>
<div id="resultado">
<fieldset class="resultado">
<legend>Resultado de la Venta</legend>

<div class="resultado-grid">

<!-- COLUMNA IZQUIERDA -->
<div class="col-izq">
    <div class="fila"><span>Subtotal:</span><span class="caja">$<?= number_format($subtotal,2) ?></span></div>
    <div class="fila"><span>IVA (15%):</span><span class="caja">$<?= number_format($iva,2) ?></span></div>
    <div class="fila total-final"><span>TOTAL:</span><span class="caja">$<?= number_format($total,2) ?></span></div>
</div>

<!-- COLUMNA DERECHA -->
<div class="col-der">

<?php if (!$mostrarPago): ?>
    <fieldset>
        <legend>Pago</legend>
        <div class="fila">
            <span>Pago del cliente:</span>
            <input type="number" name="pago" step="0.01" required class="caja">
        </div>
        <button type="submit" name="accion" value="pagar">PAGAR</button>
    </fieldset>
<?php else: ?>
    <div class="fila"><span>Pago:</span><span class="caja">$<?= number_format($pago,2) ?></span></div>
    <div class="fila">
        <span><?= $error ? "Error:" : "Cambio:" ?></span>
        <span class="caja <?= $error ? 'error' : '' ?>">
            <?= $error ?: '$'.number_format($cambio,2) ?>
        </span>
    </div>

<?php endif; ?>

</div>
</div>
</fieldset>
</div>
<?php endif; ?>

</form>
</div>

<footer class="autor">
    Desarrollado por: <strong>Maria Jose Haro</strong>
</footer>

</body>
</html>
