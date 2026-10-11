<?php
$pageTitle = "Módulo de Reportes y Estadísticas - Ferretería De La Rosa";
$extraCss = "productos.css";
require_once __DIR__ . '/header.php';
if (!isset($_SESSION['usuario_id'])) {
    echo "<div style='text-align:center; padding:3rem;'><h2>Acceso Restringido</h2><p>Inicia sesión para ver reportes.</p><a href='login.php' class='btn-nav-accent' style='display:inline-block; margin-top:1rem; padding:0.6rem 1.2rem; border-radius:8px;'>Iniciar Sesión</a></div>";
    require_once __DIR__ . '/footer.php';
    exit;
}
$totalVentasMonto = 0;
$totalVentasCant = 0;
$totalProductosLowStock = 0;
$totalUsuariosCant = 0;
if ($db_connected) {
    $r1 = $conn->query("SELECT SUM(total) as suma, COUNT(id) as cnt FROM ventas");
    if ($r1 && $row = $r1->fetch_assoc()) {
        $totalVentasMonto = $row['suma'] ?: 0;
        $totalVentasCant  = $row['cnt'] ?: 0;
    }
    $r2 = $conn->query("SELECT COUNT(id) as cnt FROM productos WHERE stock <= stock_minimo");
    if ($r2 && $row = $r2->fetch_assoc()) {
        $totalProductosLowStock = $row['cnt'] ?: 0;
    }
    $r3 = $conn->query("SELECT COUNT(id) as cnt FROM usuarios");
    if ($r3 && $row = $r3->fetch_assoc()) {
        $totalUsuariosCant = $row['cnt'] ?: 0;
    }
} else {
    $totalVentasMonto = 985.49;
    $totalVentasCant = 5;
    $totalProductosLowStock = 2;
    $totalUsuariosCant = 2;
}
?>
<div class="catalog-hero">
    <div class="hero-badge"><i class="fa-solid fa-chart-line"></i> Módulo Reportes & Métricas</div>
    <h2>Reportes del Sistema y Análisis de Rendimiento</h2>
    <p>Visualiza resumen de ventas diarias/mensuales, rotación de inventario y actividad general.</p>
</div>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    <div style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 1.5rem; border-radius: 14px; text-align: center;">
        <i class="fa-solid fa-dollar-sign" style="font-size:2rem; color:#10B981; margin-bottom:0.5rem;"></i>
        <span style="display:block; font-size:0.85rem; color: var(--gray-muted);">Ingresos Totales por Ventas</span>
        <strong style="font-size:1.8rem; color: var(--text-bright);">$<?php echo number_format((float)$totalVentasMonto, 2); ?></strong>
    </div>
    <div style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 1.5rem; border-radius: 14px; text-align: center;">
        <i class="fa-solid fa-receipt" style="font-size:2rem; color: var(--accent); margin-bottom:0.5rem;"></i>
        <span style="display:block; font-size:0.85rem; color: var(--gray-muted);">Facturas Procesadas</span>
        <strong style="font-size:1.8rem; color: var(--text-bright);"><?php echo $totalVentasCant; ?> Ventas</strong>
    </div>
    <div style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 1.5rem; border-radius: 14px; text-align: center;">
        <i class="fa-solid fa-triangle-exclamation" style="font-size:2rem; color:#EF4444; margin-bottom:0.5rem;"></i>
        <span style="display:block; font-size:0.85rem; color: var(--gray-muted);">Alertas de Stock Bajo</span>
        <strong style="font-size:1.8rem; color: #EF4444;"><?php echo $totalProductosLowStock; ?> Artículos</strong>
    </div>
    <div style="background: var(--bg-card); border: 1px solid var(--border-color); padding: 1.5rem; border-radius: 14px; text-align: center;">
        <i class="fa-solid fa-users" style="font-size:2rem; color:#3B82F6; margin-bottom:0.5rem;"></i>
        <span style="display:block; font-size:0.85rem; color: var(--gray-muted);">Usuarios Registrados</span>
        <strong style="font-size:1.8rem; color: var(--text-bright);"><?php echo $totalUsuariosCant; ?> Usuarios</strong>
    </div>
</div>
<h3 style="color: var(--text-bright); margin-bottom: 1rem;"><i class="fa-solid fa-chart-pie" style="color: var(--accent);"></i> Resumen de Operaciones Generales</h3>
<div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 14px; padding: 2rem; color: var(--text-main);">
    <p style="margin-bottom: 1rem;">El sistema de <strong>Ferretería De La Rosa</strong> mantiene el control automatizado de caja, movimiento de existencias y registro de personal autorizado.</p>
    <ul style="line-height: 2; color: var(--gray-muted); padding-left: 1.2rem;">
        <li><strong style="color:var(--text-bright);">Administrador:</strong> Acceso total a gestión de usuarios, roles, modificación de stock y reportes financieros.</li>
        <li><strong style="color:var(--text-bright);">Empleado:</strong> Capacidad de emitir ventas, consultar stock y añadir clientes.</li>
    </ul>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>
