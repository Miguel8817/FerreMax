    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-info">
                <p>&copy; <?php echo date('Y'); ?> FerreMax S.R.L. - Todos los derechos reservados | Desarrollado por Emeli</p>
            </div>
            <div class="footer-links">
                <a href="productos.php">Productos</a>
                <a href="ofertas.php">Ofertas</a>
                <a href="creditos.php">Créditos</a>
            </div>
        </div>
    </footer>

    <?php if (isset($extraJs)): ?>
        <script src="Js/<?php echo $extraJs; ?>"></script>
    <?php endif; ?>
</body>
</html>
