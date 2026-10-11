<?php
$pageTitle = "Gestión de Usuarios y Roles - Ferretería De La Rosa";
$extraCss = "login.css";
require_once __DIR__ . '/header.php';
if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_rol'] ?? '') !== 'admin') {
    echo "<div style='text-align:center; padding:3rem;'><h2>Acceso Denegado</h2><p>Solo el Administrador del sistema puede gestionar usuarios y roles.</p><a href='index.php' class='btn-nav-accent' style='display:inline-block; margin-top:1rem; padding:0.6rem 1.2rem; border-radius:8px;'>Volver al Inicio</a></div>";
    require_once __DIR__ . '/footer.php';
    exit;
}
$mensaje = "";
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['nuevo_rol'])) {
    $uid  = (int)$_POST['user_id'];
    $nrol = $_POST['nuevo_rol'];
    if ($db_connected) {
        $stmt = $conn->prepare("UPDATE usuarios SET rol = ? WHERE id = ?");
        $stmt->bind_param("si", $nrol, $uid);
        if ($stmt->execute()) {
            $mensaje = "Rol del usuario actualizado correctamente.";
        } else {
            $error = "Error al actualizar el rol.";
        }
    } else {
        $mensaje = "Rol actualizado en modo demo.";
    }
}
$usuariosList = [];
if ($db_connected) {
    $res = $conn->query("SELECT id, nombre, email, rol, creado_en FROM usuarios ORDER BY id ASC");
    if ($res) while ($r = $res->fetch_assoc()) $usuariosList[] = $r;
}
if (empty($usuariosList)) {
    $usuariosList = [
        ['id' => 1, 'nombre' => 'Emely Administradora', 'email' => 'admin@ferreteria.com', 'rol' => 'admin', 'creado_en' => date('Y-m-d H:i:s')],
        ['id' => 2, 'nombre' => 'Carlos Empleado', 'email' => 'empleado@ferreteria.com', 'rol' => 'empleado', 'creado_en' => date('Y-m-d H:i:s')]
    ];
}
?>
<div class="catalog-hero" style="margin-bottom: 2rem;">
    <div class="hero-badge"><i class="fa-solid fa-user-gear"></i> Control de Acceso y Roles</div>
    <h2>Gestión de Usuarios del Sistema</h2>
    <p>Asigna o modifica los permisos de Administrador y Empleado dentro de la aplicación.</p>
</div>
<?php if ($mensaje): ?>
    <div style="background: rgba(16,185,129,0.15); color: #10B981; border: 1px solid #10B981; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>
<div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 14px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-main);">
        <thead>
            <tr style="background: #0F172A; border-bottom: 1px solid var(--border-color);">
                <th style="padding: 1rem;">ID</th>
                <th style="padding: 1rem;">Nombre Completo</th>
                <th style="padding: 1rem;">Correo Electrónico</th>
                <th style="padding: 1rem;">Rol Actual</th>
                <th style="padding: 1rem;">Acción / Cambiar Rol</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuariosList as $u): ?>
            <tr style="border-bottom: 1px solid var(--border-color);">
                <td style="padding: 1rem; font-weight:700; color: var(--accent);">#<?php echo $u['id']; ?></td>
                <td style="padding: 1rem; font-weight:600;"><?php echo htmlspecialchars($u['nombre']); ?></td>
                <td style="padding: 1rem; color: var(--gray-muted);"><?php echo htmlspecialchars($u['email']); ?></td>
                <td style="padding: 1rem;">
                    <?php if ($u['rol'] === 'admin'): ?>
                        <span style="background: rgba(37, 99, 235, 0.2); color: #3B82F6; padding: 0.3rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700;">
                            <i class="fa-solid fa-user-shield"></i> Administrador
                        </span>
                    <?php else: ?>
                        <span style="background: rgba(148, 163, 184, 0.2); color: #94A3B8; padding: 0.3rem 0.75rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700;">
                            <i class="fa-solid fa-user-tie"></i> Empleado
                        </span>
                    <?php endif; ?>
                </td>
                <td style="padding: 1rem;">
                    <form action="usuarios.php" method="POST" style="display:flex; gap:0.5rem; align-items:center;">
                        <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                        <select name="nuevo_rol" style="background: #0F172A; border:1px solid var(--border-color); color:#fff; padding:0.4rem 0.6rem; border-radius:6px; font-size:0.85rem;">
                            <option value="empleado" <?php echo $u['rol'] === 'empleado' ? 'selected' : ''; ?>>Empleado</option>
                            <option value="admin" <?php echo $u['rol'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                        <button type="submit" style="background: var(--primary); color:#fff; border:none; padding: 0.4rem 0.8rem; border-radius: 6px; font-weight:600; font-size:0.85rem; cursor:pointer;">
                            Guardar
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>
