<?php
$pageTitle = "Gestión de Inventario - FerreMax";
$extraCss = "productos.css";
require_once __DIR__ . '/header.php';

$mensaje = "";
$error = "";

// Permitir guardar o modificar stock
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuario_id'])) {
    $codigo   = trim($_POST['codigo'] ?? '');
    $nombre   = trim($_POST['nombre'] ?? '');
    $precio   = (float)($_POST['precio'] ?? 0);
    $stock    = (int)($_POST['stock'] ?? 0);
    $minimo   = (int)($_POST['stock_minimo'] ?? 5);
    $cat      = trim($_POST['categoria'] ?? 'general');

    if (!empty($codigo) && !empty($nombre)) {
        if ($db_connected) {
            $stmt = $conn->prepare("INSERT INTO productos (codigo, nombre, precio, stock, stock_minimo, categoria) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE nombre=?, precio=?, stock=?, stock_minimo=?, categoria=?");
            $stmt->bind_param("ssdiisdsiis", $codigo, $nombre, $precio, $stock, $minimo, $cat, $nombre, $precio, $stock, $minimo, $cat);
            if ($stmt->execute()) {
                $mensaje = "Producto guardado correctamente en inventario.";
            } else {
                $error = "Error al guardar el producto.";
            }
        } else {
            $mensaje = "Producto registrado en modo demostración.";
        }
    } else {
        $error = "El código y el nombre son obligatorios.";
    }
}

// Cargar inventario
$inventario = [];
if ($db_connected) {
    $res = $conn->query("SELECT * FROM productos ORDER BY stock ASC");
    if ($res) {
        while ($r = $res->fetch_assoc()) $inventario[] = $r;
    }
}
if (empty($inventario)) {
    $inventario = [
        ['codigo' => 'PROD-001', 'nombre' => 'Bomba de Agua Periférica', 'precio' => 89.99, 'stock' => 15, 'stock_minimo' => 3, 'categoria' => 'plomeria'],
        ['codigo' => 'PROD-002', 'nombre' => 'Adaptador Rosca PVC 1/2"', 'precio' => 15.99, 'stock' => 2, 'stock_minimo' => 10, 'categoria' => 'plomeria'],
        ['codigo' => 'PROD-003', 'nombre' => 'Juego de Llaves Combinadas', 'precio' => 45.00, 'stock' => 20, 'stock_minimo' => 5, 'categoria' => 'herramientas']
    ];
}
?>

<div class="catalog-hero">
    <div class="hero-badge">Módulo Inventario</div>
    <h2>Control de Inventario y Alertas de Stock</h2>
    <p>Consulta las existencias, registra productos y supervisa las alertas de bajo inventario.</p>
</div>

<?php if ($mensaje): ?>
    <div style="background: rgba(16,185,129,0.15); color: #10B981; border: 1px solid #10B981; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div style="background: rgba(239,68,68,0.15); color: #EF4444; border: 1px solid #EF4444; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['usuario_id']) && ($_SESSION['usuario_rol'] ?? '') === 'admin'): ?>
<div style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
    <h3 style="color: var(--text-bright); margin-bottom: 1rem;">Registrar / Actualizar Producto</h3>
    <form action="inventario.php" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <div>
            <label style="font-size:0.85rem; color: var(--gray-muted);">Código</label>
            <input type="text" name="codigo" placeholder="PROD-001" required style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--gray-muted);">Nombre Producto</label>
            <input type="text" name="nombre" placeholder="Nombre" required style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--gray-muted);">Precio ($)</label>
            <input type="number" step="0.01" name="precio" placeholder="0.00" required style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--gray-muted);">Stock Actual</label>
            <input type="number" name="stock" placeholder="0" required style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--gray-muted);">Stock Mínimo Alerta</label>
            <input type="number" name="stock_minimo" value="5" required style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--gray-muted);">Categoría</label>
            <select name="categoria" style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
                <option value="plomeria">Plomería</option>
                <option value="herramientas">Herramientas</option>
                <option value="ofertas">Ofertas</option>
                <option value="general">General</option>
            </select>
        </div>
        <div style="grid-column: 1 / -1; margin-top: 0.5rem;">
            <button type="submit" style="background: var(--primary); color:#fff; border:none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight:700; cursor:pointer;">
                Guardar Producto
            </button>
        </div>
    </form>
</div>
<?php endif; ?>

<div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 8px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-main);">
        <thead>
            <tr style="background: #0F172A; border-bottom: 1px solid var(--border-color);">
                <th style="padding: 1rem;">Código</th>
                <th style="padding: 1rem;">Producto</th>
                <th style="padding: 1rem;">Categoría</th>
                <th style="padding: 1rem;">Precio</th>
                <th style="padding: 1rem;">Stock Disponible</th>
                <th style="padding: 1rem;">Estado Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventario as $item): 
                $bajoStock = ($item['stock'] <= $item['stock_minimo']);
            ?>
            <tr style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: 1rem; font-weight:700; color: var(--accent);"><?php echo htmlspecialchars($item['codigo']); ?></td>
                <td style="padding: 1rem; font-weight:600;"><?php echo htmlspecialchars($item['nombre']); ?></td>
                <td style="padding: 1rem; color: var(--gray-muted);"><?php echo ucfirst(htmlspecialchars($item['categoria'])); ?></td>
                <td style="padding: 1rem; font-weight:700;">$<?php echo number_format((float)$item['precio'], 2); ?></td>
                <td style="padding: 1rem; font-weight:800; font-size:1.1rem;"><?php echo $item['stock']; ?></td>
                <td style="padding: 1rem;">
                    <?php if ($bajoStock): ?>
                        <span style="background: rgba(239, 68, 68, 0.2); color: #EF4444; padding: 0.3rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; border: 1px solid rgba(239, 68, 68, 0.4);">
                            Bajo Inventario (Min: <?php echo $item['stock_minimo']; ?>)
                        </span>
                    <?php else: ?>
                        <span style="background: rgba(16, 185, 129, 0.2); color: #10B981; padding: 0.3rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700;">
                            Stock Óptimo
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
