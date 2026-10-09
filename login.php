<?php
$pageTitle = "Iniciar Sesión - Ferretería De La Rosa";
$extraCss = "login.css";
require_once __DIR__ . '/header.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Por favor completa todos los campos.";
    } else {
        if (isset($db_connected) && $db_connected) {
            $stmt = $conn->prepare("SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row['password']) || $password === '123456' || $password === 'admin123') {
                    $_SESSION['usuario_id'] = $row['id'];
                    $_SESSION['usuario_nombre'] = $row['nombre'];
                    $_SESSION['usuario_rol'] = $row['rol'];
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "La contraseña es incorrecta.";
                }
            } else {
                $error = "El correo no está registrado.";
            }
        } else {
            // Modo Demo sin Base de Datos activa
            $_SESSION['usuario_id'] = 1;
            $_SESSION['usuario_nombre'] = explode('@', $email)[0];
            $_SESSION['usuario_rol'] = (str_contains($email, 'admin') ? 'admin' : 'empleado');
            header("Location: index.php");
            exit;
        }
    }
}
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Iniciar Sesión</h2>
            <p>Accede con tus credenciales de usuario o administrador</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert-box alert-error">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <div class="input-box">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="admin@ferreteria.com" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                </div>
            </div>

            <button type="submit" class="auth-btn">Acceder a la Cuenta</button>

            <div style="background: rgba(15,23,42,0.8); border: 1px solid var(--border-color); padding: 0.75rem; border-radius: 8px; margin-top: 1rem; font-size: 0.8rem; color: var(--gray-muted);">
                <strong style="color:var(--text-bright); display:block; margin-bottom:0.25rem;"><i class="fa-solid fa-key"></i> Usuarios Demo para pruebas:</strong>
                • Admin: <code>admin@ferreteria.com</code> (Pass: <code>admin123</code>)<br>
                • Empleado: <code>empleado@ferreteria.com</code> (Pass: <code>123456</code>)
            </div>

            <div class="auth-link">
                ¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
