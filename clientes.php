<?php
$pageTitle = "Gestión de Clientes y Proveedores - Ferretería De La Rosa";
$extraCss = "productos.css";
require_once __DIR__ . '/header.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<div style='text-align:center; padding:3rem;'><h2>Acceso Restringido</h2><p>Inicia sesión para acceder a este módulo.</p><a href='login.php' class='btn-nav-accent' style='display:inline-block; margin-top:1rem; padding:0.6rem 1.2rem; border-radius:8px;'>Iniciar Sesión</a></div>";
    require_once __DIR__ . '/footer.php';
    exit;
}

$mensaje = "";
$error = "";

// Registrar Cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre'] ?? '');
    $documento = trim($_POST['documento'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    if (!empty($nombre)) {
        if ($db_connected) {
            $stmt = $conn->prepare("INSERT INTO clientes (nombre, documento, telefono, email, direccion) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nombre, $documento, $telefono, $email, $direccion);
            if ($stmt->execute()) {
                $mensaje = "Cliente registrado correctamente.";
            } else {
                $error = "Error o documento ya registrado.";
            }
        } else {
            $mensaje = "Cliente registrado en modo prueba (Demo).";
        }
    } else {
        $error = "El nombre del cliente es obligatorio.";
    }
}

// Cargar Clientes
$clientes = [];
if ($db_connected) {
    $res = $conn->query("SELECT * FROM clientes ORDER BY id DESC");
    if ($res) while ($r = $res->fetch_assoc()) $clientes[] = $r;
}
if (empty($clientes)) {
    $clientes = [
        ['id' => 1, 'nombre' => 'Juan Pérez', 'documento' => 'V-18239401', 'telefono' => '0414-1234567', 'email' => 'juan.perez@email.com', 'direccion' => 'Av. Bolivar Edif 4'],
        ['id' => 2, 'nombre' => 'Maria Rodriguez', 'documento' => 'V-20192834', 'telefono' => '0412-7654321', 'email' => 'maria.rod@email.com', 'direccion' => 'Calle Comercio Casa 12']
    ];
}
?>

<div class="catalog-hero">
    <div class="hero-badge"><i class="fa-solid fa-users"></i> Módulo Gestión de Clientes</div>
    <h2>Directorio de Clientes y Proveedores</h2>
    <p>Registra y consulta el historial de clientes para la emisión de facturas y atención personalizada.</p>
</div>

<?php if ($mensaje): ?>
    <div style="background: rgba(16,185,129,0.15); color: #10B981; border: 1px solid #10B981; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<div style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 1.5rem; border-radius: 14px; margin-bottom: 2rem;">
    <h3 style="color: var(--text-bright); margin-bottom: 1rem;"><i class="fa-solid fa-user-plus" style="color: var(--accent);"></i> Registrar Nuevo Cliente</h3>
    <form action="clientes.php" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <div>
            <label style="font-size:0.85rem; color: var(--text-muted);">Nombre Completo</label>
            <input type="text" name="nombre" placeholder="Juan Pérez" required style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--text-muted);">Cédula / RIF / Doc</label>
            <input type="text" name="documento" placeholder="V-00000000" style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--text-muted);">Teléfono</label>
            <input type="text" name="telefono" placeholder="0414-0000000" style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div>
            <label style="font-size:0.85rem; color: var(--text-muted);">Correo Electrónico</label>
            <input type="email" name="email" placeholder="cliente@correo.com" style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div style="grid-column: 1 / -1;">
            <label style="font-size:0.85rem; color: var(--text-muted);">Dirección Fiscal / Habitación</label>
            <input type="text" name="direccion" placeholder="Dirección completa" style="width:100%; background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.6rem; border-radius:6px;">
        </div>
        <div style="grid-column: 1 / -1; margin-top: 0.5rem;">
            <button type="submit" style="background: var(--primary); color:#fff; border:none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight:700; cursor:pointer;">
                <i class="fa-solid fa-save"></i> Registrar Cliente
            </button>
        </div>
    </form>
</div>

<h3 style="color: var(--text-bright); margin-bottom: 1rem;"><i class="fa-solid fa-address-book" style="color: var(--accent);"></i> Clientes Registrados</h3>
<div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 14px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-main);">
        <thead>
            <tr style="background: #0F172A; border-bottom: 1px solid var(--border-color);">
                <th style="padding: 1rem;">ID</th>
                <th style="padding: 1rem;">Nombre</th>
                <th style="padding: 1rem;">Documento</th>
                <th style="padding: 1rem;">Teléfono</th>
                <th style="padding: 1rem;">Correo</th>
                <th style="padding: 1rem;">Dirección</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $c): ?>
            <tr style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: 1rem; font-weight:700; color: var(--accent);">#<?php echo $c['id']; ?></td>
                <td style="padding: 1rem; font-weight:600;"><?php echo htmlspecialchars($c['nombre']); ?></td>
                <td style="padding: 1rem; color: var(--gray-muted);"><?php echo htmlspecialchars($c['documento']); ?></td>
                <td style="padding: 1rem;"><?php echo htmlspecialchars($c['telefono']); ?></td>
                <td style="padding: 1rem; color: var(--accent);"><?php echo htmlspecialchars($c['email']); ?></td>
                <td style="padding: 1rem; font-size:0.88rem; color: var(--gray-muted);"><?php echo htmlspecialchars($c['direccion']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
