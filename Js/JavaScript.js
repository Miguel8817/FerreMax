document.getElementById('registroForm').addEventListener('submit', function (event) {
    const nombre = document.getElementById('nombre').value;
    const correo = document.getElementById('correo').value;
    const telefono = document.getElementById('telefono').value;
    const password = document.getElementById('password').value;
    const confirmar = document.getElementById('confirmar').value;
    if (password !== confirmar) {
        alert('Las contraseñas no coinciden.');
        event.preventDefault();
        return;
    }
    if (correo === '' || password === '' || nombre === '' || telefono === '') {
        alert('Por favor, ingresa todos los campos.');
        event.preventDefault();
        return;
    }
    window.location.href = 'productos.html';
});
