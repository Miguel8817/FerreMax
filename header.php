<?php
require_once __DIR__ . '/config.php';
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
    <link rel="stylesheet" href="Css/global.css">
    <?php if (isset($extraCss)): ?>
        <link rel="stylesheet" href="Css/<?php echo $extraCss; ?>">
    <?php endif; ?>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <a href="index.php" class="logo-brand">
                <h1>Ferre<span>Max</span></h1>
            </a>
            <nav class="nav">
                <a href="index.php" class="nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
                    Inicio
                </a>
                <a href="productos.php" class="nav-link <?php echo $currentPage == 'productos.php' ? 'active' : ''; ?>">
                    Catálogo
                </a>
                <a href="inventario.php" class="nav-link <?php echo $currentPage == 'inventario.php' ? 'active' : ''; ?>">
                    Inventario
                </a>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="ventas.php" class="nav-link <?php echo $currentPage == 'ventas.php' ? 'active' : ''; ?>">
                        Ventas
                    </a>
                    <a href="clientes.php" class="nav-link <?php echo $currentPage == 'clientes.php' ? 'active' : ''; ?>">
                        Clientes
                    </a>
                    <a href="reportes.php" class="nav-link <?php echo $currentPage == 'reportes.php' ? 'active' : ''; ?>">
                        Reportes
                    </a>
                    <?php if ($rol === 'admin'): ?>
                        <a href="usuarios.php" class="nav-link <?php echo $currentPage == 'usuarios.php' ? 'active' : ''; ?>">
                            Usuarios
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['usuario_nombre'])): ?>
                    <span class="user-badge" title="Rol: <?php echo ucfirst($rol); ?>">
                        <?php echo htmlspecialchars($nombreUsuario); ?> (<?php echo ucfirst($rol); ?>)
                    </span>
                    <a href="logout.php" class="nav-link">Salir</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link <?php echo $currentPage == 'login.php' ? 'active' : ''; ?>">
                        Iniciar Sesión
                    </a>
                    <a href="registro.php" class="nav-link btn-nav-accent <?php echo $currentPage == 'registro.php' ? 'active' : ''; ?>">
                        Registrarse
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="main-content">
