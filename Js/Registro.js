document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registroForm');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirmar');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            document.querySelectorAll('.error-message').forEach(el => {
                el.style.display = 'none';
            });
            let isValid = true;
            const nombre = document.getElementById('nombre').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = passwordInput ? passwordInput.value : '';
            const confirmar = confirmInput ? confirmInput.value : '';
            if (nombre === '') {
                const err = document.getElementById('nombre-error');
                if (err) err.style.display = 'block';
                isValid = false;
            }
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                const err = document.getElementById('email-error');
                if (err) err.style.display = 'block';
                isValid = false;
            }
            if (password.length < 8) {
                const err = document.getElementById('password-error');
                if (err) err.style.display = 'block';
                isValid = false;
            }
            if (password !== confirmar) {
                const err = document.getElementById('confirmar-error');
                if (err) err.style.display = 'block';
                isValid = false;
            }
            if (isValid) {
                localStorage.setItem('isLoggedIn', 'true');
                localStorage.setItem('userName', nombre);
                localStorage.setItem('userEmail', email);
                window.location.href = 'productos.html';
            }
        });
    }
});
