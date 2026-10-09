<?php
$pageTitle = "Ofertas Especiales - Ferretería De La Rosa";
$extraCss = "ofertas.css";
require_once __DIR__ . '/header.php';
?>

<section class="promo-hero">
    <div class="promo-tag">
        <i class="fa-solid fa-fire"></i> Promociones de Temporada
    </div>
    <h2>Ofertas Especiales en Pinturas y Acabados</h2>
    <p>Aprovecha precios rebajados por tiempo limitado en nuestras líneas de pintura acrílica y látex de máxima cobertura para tu hogar o negocio.</p>
</section>

<section class="offers-grid">
    <article class="offer-card">
        <div class="offer-badge">-5% DESCUENTO</div>
        <div class="offer-img-box">
            <img src="img/pintura_acrilica_hd.jpg" alt="Pintura Vinil Acrílica AURA Red">
        </div>
        <div class="offer-content">
            <h3 class="offer-title">Pintura Vinil Acrílica Premium</h3>
            <p class="offer-desc">Pintura de calidad superior para interiores y exteriores. Fórmula de secado rápido, lavable y con gran poder cubriente contra la intemperie.</p>
            
            <div class="price-comparison">
                <div class="price-old">
                    <span class="label">Precio Habitual</span>
                    <span class="value">$833.00</span>
                </div>
                <div class="price-new">
                    <span class="label">Precio Especial</span>
                    <span class="value">$800.00</span>
                </div>
                <div class="savings-tag">Ahorras $33.00</div>
            </div>

            <p class="offer-note"><i class="fa-solid fa-location-dot" style="color: var(--accent);"></i> Disponible para consulta y compra directa en tienda.</p>
        </div>
    </article>

    <article class="offer-card">
        <div class="offer-badge">-3% DESCUENTO</div>
        <div class="offer-img-box">
            <img src="img/pintura_latex_hd.jpg" alt="Pintura Dura Latex Aurora">
        </div>
        <div class="offer-content">
            <h3 class="offer-title">Pintura Dura Látex Profesional</h3>
            <p class="offer-desc">Especial para salas, dormitorios y oficinas. Excelente resistencia al lavado frecuente, acabado satinado lavable de larga duración.</p>
            
            <div class="price-comparison">
                <div class="price-old">
                    <span class="label">Precio Habitual</span>
                    <span class="value">$460.00</span>
                </div>
                <div class="price-new">
                    <span class="label">Precio Especial</span>
                    <span class="value">$450.00</span>
                </div>
                <div class="savings-tag">Ahorras $10.00</div>
            </div>

            <p class="offer-note"><i class="fa-solid fa-location-dot" style="color: var(--accent);"></i> Disponible para consulta y compra directa en tienda.</p>
        </div>
    </article>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
