<?php
$pageTitle = "Registro de Ventas - Ferretería De La Rosa";
$extraCss = "productos.css";
require_once __DIR__ . '/header.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<div style='text-align:center; padding:3rem;'><h2>Acceso Restringido</h2><p>Inicia sesión para ingresar ventas.</p><a href='login.php' class='btn-nav-accent' style='display:inline-block; margin-top:1rem; padding:0.6rem 1.2rem; border-radius:8px;'>Iniciar Sesión</a></div>";
    require_once __DIR__ . '/footer.php';
    exit;
}

$mensaje = "";
$error = "";

// Cargar listas
$prods = [];
$clis = [];
if ($db_connected) {
    $resP = $conn->query("SELECT * FROM productos WHERE stock > 0 ORDER BY nombre ASC");
    if ($resP) while ($r = $resP->fetch_assoc()) $prods[] = $r;

    $resC = $conn->query("SELECT * FROM clientes ORDER BY nombre ASC");
    if ($resC) while ($r = $resC->fetch_assoc()) $clis[] = $r;
}

if (empty($prods)) {
    $prods = [
        ['id' => 1, 'nombre' => 'Bomba de Agua Periférica', 'precio' => 89.99, 'stock' => 15],
        ['id' => 2, 'nombre' => 'Adaptador Rosca PVC', 'precio' => 15.99, 'stock' => 10],
        ['id' => 3, 'nombre' => 'Juego de Llaves Combinadas', 'precio' => 45.00, 'stock' => 20]
    ];
}

// Procesar Venta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prod_id  = (int)($_POST['producto_id'] ?? 0);
    $cant     = (int)($_POST['cantidad'] ?? 1);
    $cliente  = !empty($_POST['cliente_id']) ? (int)$_POST['cliente_id'] : "NULL";
    $metodo   = $_POST['metodo_pago'] ?? 'efectivo';

    if ($prod_id > 0 && $cant > 0) {
        // Obtener precio del producto
        $precioUnit = 0;
        foreach ($prods as $p) {
            if ($p['id'] == $prod_id) {
                $precioUnit = $p['precio'];
                break;
            }
        }
        $total = $precioUnit * $cant;
        $user_id = $_SESSION['usuario_id'];

        if ($db_connected) {
            $conn->query("INSERT INTO ventas (usuario_id, cliente_id, total, metodo_pago) VALUES ($user_id, $cliente, $total, '$metodo')");
            $v_id = $conn->insert_id;
            $conn->query("INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario, subtotal) VALUES ($v_id, $prod_id, $cant, $precioUnit, $total)");
            $conn->query("UPDATE productos SET stock = stock - $cant WHERE id = $prod_id");
            $mensaje = "¡Venta registrada con éxito! Factura #$v_id generada por $$total";
        } else {
            $mensaje = "¡Venta de prueba registrada correctamente por $$total! (Modo Demo)";
        }
    } else {
        $error = "Selecciona un producto y cantidad válida.";
    }
}

// Cargar ultimas ventas
$ventasHistorial = [];
if ($db_connected) {
    $q = "SELECT v.id, v.total, v.metodo_pago, v.fecha, u.nombre as usuario, c.nombre as cliente 
          FROM ventas v 
          JOIN usuarios u ON v.usuario_id = u.id 
          LEFT JOIN clientes c ON v.cliente_id = c.id 
          ORDER BY v.id DESC LIMIT 10";
    $resV = $conn->query($q);
    if ($resV) while ($r = $resV->fetch_assoc()) $ventasHistorial[] = $r;
}
?>

<div class="catalog-hero">
    <div class="hero-badge"><i class="fa-solid fa-cash-register"></i> Módulo Ventas & Facturación</div>
    <h2>Registro de Ventas y Emisión de Comprobantes</h2>
    <p>Ingresa facturas, selecciona métodos de pago y descuenta automáticamente del inventario.</p>
</div>

<?php if ($mensaje): ?>
    <div style="background: rgba(16,185,129,0.15); color: #10B981; border: 1px solid #10B981; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<div style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 1.5rem; border-radius: 14px; margin-bottom: 2rem;">
    <h3 style="color: var(--text-bright); margin-bottom: 1rem;"><i class="fa-solid fa-cart-plus" style="color: var(--accent);"></i> Registrar Nueva Venta</h3>
    <form action="ventas.php" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <div>
            <label style="font-size:0.85rem; color: var(--text-muted);">Seleccionar Producto</label>
            <select name="producto_id" required style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
                <?php foreach ($prods as $p): ?>
                    <option value="<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['nombre']); ?> - $<?php echo number_format((float)$p['precio'],2); ?> (Disponibles: <?php echo $p['stock']; ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--text-muted);">Cantidad</label>
            <input type="number" name="cantidad" value="1" min="1" required style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--text-muted);">Cliente (Opcional)</label>
            <select name="cliente_id" style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
                <option value="">-- Cliente General --</option>
                <?php foreach ($clis as $c): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nombre']); ?> (<?php echo htmlspecialchars($c['documento']); ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--text-muted);">Método de Pago</label>
            <select name="metodo_pago" style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta de Débito / Crédito</option>
                <option value="transferencia">Transferencia Bancaria</option>
            </select>
        </div>
        <div style="grid-column: 1 / -1; margin-top: 0.5rem;">
            <button type="submit" style="background: var(--primary); color:#fff; border:none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight:700; cursor:pointer;">
                <i class="fa-solid fa-file-invoice-dollar"></i> Procesar Venta y Facturar
            </button>
        </div>
    </form>
</div>

<h3 style="color: var(--text-bright); margin-bottom: 1rem;"><i class="fa-solid fa-history" style="color: var(--accent);"></i> Historial Reciente de Ventas</h3>
<div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 14px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-main);">
        <thead>
            <tr style="background: #0F172A; border-bottom: 1px solid var(--border-color);">
                <th style="padding: 1rem;">N° Factura</th>
                <th style="padding: 1rem;">Vendedor</th>
                <th style="padding: 1rem;">Cliente</th>
                <th style="padding: 1rem;">Método Pago</th>
                <th style="padding: 1rem;">Total Venta</th>
                <th style="padding: 1rem;">Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($ventasHistorial)): ?>
                <tr><td colspan="6" style="padding:1.5rem; text-align:center; color: var(--gray-muted);">No hay registros de ventas recientes.</td></tr>
            <?php else: ?>
                <?php foreach ($ventasHistorial as $v): ?>
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 1rem; font-weight:700; color: var(--accent);">#FACT-<?php echo sprintf("%04d", $v['id']); ?></td>
                    <td style="padding: 1rem;"><?php echo htmlspecialchars($v['usuario']); ?></td>
                    <td style="padding: 1rem;"><?php echo htmlspecialchars($v['cliente'] ?: 'Cliente General'); ?></td>
                    <td style="padding: 1rem; color: var(--gray-muted);"><?php echo ucfirst($v['metodo_pago']); ?></td>
                    <td style="padding: 1rem; font-weight:800; color:#10B981;">$<?php echo number_format((float)$v['total'], 2); ?></td>
                    <td style="padding: 1rem; font-size:0.85rem; color: var(--gray-muted);"><?php echo $v['fecha']; ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
