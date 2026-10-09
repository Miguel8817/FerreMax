<?php
$pageTitle = "Créditos del Proyecto - Ferretería De La Rosa";
$extraCss = "creditos.css";
require_once __DIR__ . '/header.php';
?>

<section class="credits-hero">
    <div class="credits-badge">
        <i class="fa-solid fa-code"></i> Equipo & Reconocimientos
    </div>
    <h2>Créditos del Proyecto</h2>
    <p>Reconocimiento al trabajo de diseño, desarrollo frontend y backend PHP dedicado a la creación del portal de Ferretería De La Rosa.</p>
</section>

<section class="credits-grid">
    <article class="credit-card">
        <div class="avatar-wrapper">
            <div class="avatar-inner">
                <i class="fa-solid fa-user-astronaut"></i>
            </div>
        </div>
        <span class="credit-role">Desarrolladora & Estudiante</span>
        <h3 class="credit-name">Emeli</h3>
        <p class="credit-desc">Arquitectura del proyecto, diseño en tonos azul oscuro y gris, y desarrollo del sistema modular en PHP.</p>
    </article>

    <article class="credit-card">
        <div class="avatar-wrapper">
            <div class="avatar-inner">
                <i class="fa-solid fa-palette"></i>
            </div>
        </div>
        <span class="credit-role">Diseño UI / UX</span>
        <h3 class="credit-name">Emeli</h3>
        <p class="credit-desc">Diseño de interfaz oscura, paleta de colores industrial elegante, maquetación adaptativa y componentes CSS.</p>
    </article>

    <article class="credit-card">
        <div class="avatar-wrapper">
            <div class="avatar-inner">
                <i class="fa-solid fa-server"></i>
            </div>
        </div>
        <span class="credit-role">Desarrollo Backend PHP & SQL</span>
        <h3 class="credit-name">Emeli</h3>
        <p class="credit-desc">Programación modular en PHP, lógica de sesiones, autenticación de usuarios y script de base de datos MySQL.</p>
    </article>

    <article class="credit-card">
        <div class="avatar-wrapper">
            <div class="avatar-inner">
                <i class="fa-solid fa-building"></i>
            </div>
        </div>
        <span class="credit-role">Proveedor de Información</span>
        <h3 class="credit-name">Ferretería y Pinturas De La Rosa</h3>
        <p class="credit-desc">Suministro de datos de inventario, descripción técnica de materiales de plomería y herramientas.</p>
    </article>
</section>

<section class="tech-banner">
    <h4><i class="fa-solid fa-layer-group" style="color: var(--accent);"></i> Tecnologías Utilizadas</h4>
    <div class="tech-pills">
        <span class="tech-pill"><i class="fa-brands fa-php" style="color: #777BB4;"></i> PHP 8.x Modular</span>
        <span class="tech-pill"><i class="fa-solid fa-database" style="color: #00758F;"></i> MySQL / MariaDB</span>
        <span class="tech-pill"><i class="fa-brands fa-html5" style="color: #E34F26;"></i> HTML5 Semántico</span>
        <span class="tech-pill"><i class="fa-brands fa-css3-alt" style="color: #1572B6;"></i> CSS3 Glassmorphism</span>
        <span class="tech-pill"><i class="fa-brands fa-js" style="color: #F7DF1E;"></i> JavaScript ES6</span>
        <span class="tech-pill"><i class="fa-solid fa-icons" style="color: #528DD7;"></i> FontAwesome 6</span>
    </div>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
