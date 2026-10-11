<?php
$pageTitle = "Registro de Usuario - Ferretería De La Rosa";
$extraCss = "login.css";
require_once __DIR__ . '/header.php';
$error = "";
$success = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = trim($_POST['password'] ?? '');
    $confirmar = trim($_POST['confirmar'] ?? '');
    if (empty($nombre) || empty($email) || empty($password) || empty($confirmar)) {
        $error = "Por favor completa todos los campos del formulario.";
    } elseif ($password !== $confirmar) {
        $error = "Las contraseñas ingresadas no coinciden.";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        if (isset($db_connected) && $db_connected) {
            $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            if ($check->get_result()->num_rows > 0) {
                $error = "Este correo electrónico ya está registrado.";
            } else {
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $nombre, $email, $hashed);
                if ($stmt->execute()) {
                    $_SESSION['usuario_id'] = $stmt->insert_id;
                    $_SESSION['usuario_nombre'] = $nombre;
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Ocurrió un error al registrar el usuario en la base de datos.";
                }
            }
        } else {
            $_SESSION['usuario_nombre'] = $nombre;
            header("Location: index.php");
            exit;
        }
    }
}
?>
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Crear una Cuenta</h2>
            <p>Regístrate para consultar nuestro catálogo completo</p>
        </div>
        <?php if (!empty($error)): ?>
            <div class="alert-box alert-error">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form action="registro.php" method="POST" class="auth-form">
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <div class="input-box">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan Pérez" value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <div class="input-box">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="tucorreo@ejemplo.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Mínimo 6 caracteres" required>
                </div>
            </div>
            <div class="form-group">
                <label for="confirmar">Confirmar contraseña</label>
                <div class="input-box">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="confirmar" name="confirmar" placeholder="Repite tu contraseña" required>
                </div>
            </div>
            <button type="submit" class="auth-btn">Crear Cuenta</button>
            <div class="auth-link">
                ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>
