<?php
require_once __DIR__ . '/config.php';

// Detectar la página actual
$currentPage = basename($_SERVER['PHP_SELF']);
$rol = $_SESSION['usuario_rol'] ?? 'invitado';
$nombreUsuario = $_SESSION['usuario_nombre'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'FerreMax'; ?></title>
    <!-- Estilos Base Globales (Emeli: Azul Oscuro y Gris) -->
    <link rel="stylesheet" href="Css/global.css">
    <?php if (isset($extraCss)): ?>
        <link rel="stylesheet" href="Css/<?php echo $extraCss; ?>">
    <?php endif; ?>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header class="header">
        <div class="header-container">
            <a href="index.php" class="logo-brand">
                <div class="logo-icon">
                    <i class="fa-solid fa-wrench"></i>
                </div>
                <h1>Ferre<span>Max</span></h1>
            </a>
            <nav class="nav">
                <a href="index.php" class="nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-house"></i> Inicio
                </a>
                <a href="productos.php" class="nav-link <?php echo $currentPage == 'productos.php' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-boxes-stacked"></i> Catálogo
                </a>
                <a href="inventario.php" class="nav-link <?php echo $currentPage == 'inventario.php' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-warehouse"></i> Inventario
                </a>

                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="ventas.php" class="nav-link <?php echo $currentPage == 'ventas.php' ? 'active' : ''; ?>">
                        <i class="fa-solid fa-cash-register"></i> Ventas
                    </a>
                    <a href="clientes.php" class="nav-link <?php echo $currentPage == 'clientes.php' ? 'active' : ''; ?>">
                        <i class="fa-solid fa-users"></i> Clientes
                    </a>
                    <a href="reportes.php" class="nav-link <?php echo $currentPage == 'reportes.php' ? 'active' : ''; ?>">
                        <i class="fa-solid fa-chart-line"></i> Reportes
                    </a>

                    <?php if ($rol === 'admin'): ?>
                        <a href="usuarios.php" class="nav-link <?php echo $currentPage == 'usuarios.php' ? 'active' : ''; ?>">
                            <i class="fa-solid fa-user-gear"></i> Usuarios
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <a href="creditos.php" class="nav-link <?php echo $currentPage == 'creditos.php' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-circle-info"></i> Créditos
                </a>

                <?php if (isset($_SESSION['usuario_nombre'])): ?>
                    <span class="user-badge" title="Rol: <?php echo ucfirst($rol); ?>">
                        <i class="fa-solid fa-user-shield"></i> <?php echo htmlspecialchars($nombreUsuario); ?> (<?php echo ucfirst($rol); ?>)
                    </span>
                    <a href="logout.php" class="nav-link"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link <?php echo $currentPage == 'login.php' ? 'active' : ''; ?>">
                        <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
                    </a>
                    <a href="registro.php" class="nav-link btn-nav-accent <?php echo $currentPage == 'registro.php' ? 'active' : ''; ?>">
                        <i class="fa-solid fa-user-plus"></i> Registrarse
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main class="main-content">
