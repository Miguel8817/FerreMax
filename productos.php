<?php
$pageTitle = "Catálogo de Productos - Ferretería De La Rosa";
$extraCss = "productos.css";
$extraJs = "productos.js";
require_once __DIR__ . '/header.php';

// Cargar productos de la base de datos MySQL si está conectada
$productos_lista = [];
if (isset($db_connected) && $db_connected) {
    $res = $conn->query("SELECT * FROM productos ORDER BY id DESC");
    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $productos_lista[] = $row;
        }
    }
}

// Fallback por defecto si no hay conexión a BD MySQL aún
if (empty($productos_lista)) {
    $productos_lista = [
        [
            'nombre' => 'Bomba de Agua Periférica',
            'descripcion' => 'Sistema de alta presión para movimiento continuo y eficiente de líquidos en instalaciones residenciales e industriales.',
            'precio' => '89.99',
            'categoria' => 'plomeria',
            'imagen' => 'img/bomba_agua_hd.jpg',
            'badge' => 'Destacado'
        ],
        [
            'nombre' => 'Adaptador Rosca PVC',
            'descripcion' => 'Conecta partes con extremos de diferente diámetro en sistemas de tuberías de presión con empaque hermético.',
            'precio' => '15.99',
            'categoria' => 'plomeria',
            'imagen' => 'img/Adaptador.jpg',
            'badge' => 'PVC Heavy Duty'
        ],
        [
            'nombre' => 'Juego de Llaves Combinadas',
            'descripcion' => 'Set profesional de llaves cromo vanadio de alta resistencia para trabajo pesado.',
            'precio' => '45.00',
            'categoria' => 'herramientas',
            'imagen' => 'img/bomba_agua_hd.jpg',
            'badge' => 'Grado Industrial'
        ]
    ];
}
?>

<section class="catalog-hero">
    <div class="hero-badge">
        <i class="fa-solid fa-store"></i> Catálogo de Exposición
    </div>
    <h2>Catálogo General de Productos</h2>
    <p>Conoce la variedad de herramientas, materiales de plomería y equipos de alta calidad disponibles en nuestra ferretería.</p>

    <div class="filter-bar">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Buscar por nombre o descripción...">
        </div>

        <div class="category-tabs">
            <button class="tab-btn active" data-category="all">Todos los Productos</button>
            <button class="tab-btn" data-category="plomeria">Plomería</button>
            <button class="tab-btn" data-category="herramientas">Herramientas</button>
        </div>
    </div>
</section>

<div class="products-grid">
    <?php foreach ($productos_lista as $prod): ?>
        <article class="product-card" data-category="<?php echo htmlspecialchars($prod['categoria']); ?>">
            <div class="product-img-wrapper">
                <span class="card-category"><?php echo ucfirst(htmlspecialchars($prod['categoria'])); ?></span>
                <?php if (!empty($prod['badge'])): ?>
                    <span class="card-badge"><?php echo htmlspecialchars($prod['badge']); ?></span>
                <?php endif; ?>
                <img src="<?php echo htmlspecialchars($prod['imagen']); ?>" alt="<?php echo htmlspecialchars($prod['nombre']); ?>">
            </div>
            <div class="product-body">
                <h4 class="product-title"><?php echo htmlspecialchars($prod['nombre']); ?></h4>
                <p class="product-desc"><?php echo htmlspecialchars($prod['descripcion']); ?></p>
                <div class="product-meta">
                    <div class="price-box">
                        <span class="price-label">Precio Referencial</span>
                        <span class="price-value">$<?php echo number_format((float)$prod['precio'], 2); ?></span>
                    </div>
                    <div class="stock-indicator">
                        <span class="stock-dot"></span> En Tienda
                    </div>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
