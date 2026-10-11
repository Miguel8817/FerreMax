document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
            document.querySelectorAll('.error-message').forEach(el => {
                el.style.display = 'none';
            });
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            let isValid = true;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                const err = document.getElementById('email-error');
                if (err) err.style.display = 'block';
                isValid = false;
            }
            if (password.length < 6) {
                const err = document.getElementById('password-error');
                if (err) err.style.display = 'block';
                isValid = false;
            }
            if (isValid) {
                const username = email.split('@')[0];
                localStorage.setItem('isLoggedIn', 'true');
                localStorage.setItem('userEmail', email);
                localStorage.setItem('userName', username.charAt(0).toUpperCase() + username.slice(1));
                window.location.href = 'productos.html';
            }
        });
    }
});
