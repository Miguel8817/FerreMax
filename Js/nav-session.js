function updateSessionUI() {
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
    const userName = localStorage.getItem('userName') || 'Usuario';
    const navs = document.querySelectorAll('.nav, .top-nav');
    navs.forEach(nav => {
        const loginLink = nav.querySelector('a[href="login.html"]');
        const registerLink = nav.querySelector('a[href="Registro.html"]');
        let userBadge = nav.querySelector('.user-session-badge');
        let logoutBtn = nav.querySelector('.logout-btn');
        if (isLoggedIn) {
            if (loginLink) loginLink.style.display = 'none';
            if (registerLink) registerLink.style.display = 'none';
            if (!userBadge) {
                userBadge = document.createElement('span');
                userBadge.className = 'nav-link user-session-badge';
                userBadge.style.color = '#FFC107';
                userBadge.style.fontWeight = '700';
                userBadge.innerHTML = `<i class="fa-solid fa-circle-user"></i> Hola, ${userName}`;
                nav.appendChild(userBadge);
            } else {
                userBadge.innerHTML = `<i class="fa-solid fa-circle-user"></i> Hola, ${userName}`;
            }
            if (!logoutBtn) {
                logoutBtn = document.createElement('a');
                logoutBtn.href = '#';
                logoutBtn.className = 'nav-link logout-btn';
                logoutBtn.innerHTML = `<i class="fa-solid fa-right-from-bracket"></i> Salir`;
                logoutBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    localStorage.removeItem('isLoggedIn');
                    localStorage.removeItem('userName');
                    localStorage.removeItem('userEmail');
                    window.location.reload();
                });
                nav.appendChild(logoutBtn);
            }
        } else {
            if (loginLink) loginLink.style.display = '';
            if (registerLink) registerLink.style.display = '';
            if (userBadge) userBadge.remove();
            if (logoutBtn) logoutBtn.remove();
        }
    });
}
document.addEventListener('DOMContentLoaded', updateSessionUI);
