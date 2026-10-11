<?php
$pageTitle = "Inicio - FerreMax";
$extraCss = "index.css";
require_once __DIR__ . '/header.php';
?>
<section class="hero-section">
    <h1 class="hero-title">Ferre<span>Max</span></h1>
    <p class="hero-subtitle">Todo lo que necesitas para construcción, plomería, herramientas y renovación industrial en un solo lugar.</p>
    <div class="hero-buttons">
        <a href="productos.php" class="btn-hero btn-hero-primary">
            Ver Catálogo
        </a>
        <a href="ofertas.php" class="btn-hero btn-hero-outline">
            Ver Ofertas
        </a>
    </div>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
