// Función que recibe una ruta, lee el JSON y compara con los inputs
async function verificarCredenciales(ruta) {
    // Obtener valores de los inputs
    const usernameInput = document.getElementById('usernameInput').value;
    const passwordInput = document.getElementById('passwordInput').value;
    // Validar que los campos no estén vacíos
    if (!usernameInput || !passwordInput) {
        document.getElementById('login-error').innerText = '⚠️ Por favor ingresa usuario y contraseña.';
        return;
    }
    try {
        // Leer el archivo JSON desde la ruta proporcionada
        const respuesta = await fetch(ruta);
        
        // Verificar si la solicitud fue exitosa
        if (!respuesta.ok) {
            throw new Error(`No se pudo cargar el archivo: ${respuesta.status}`);
        }
        const datos = await respuesta.json();
        // Comparar los valores del JSON con los inputs
        if (datos.username === usernameInput && datos.password === passwordInput) {
            document.getElementById('login-error').innerText = '';
            loadElement('main', 'views/adminDashboard.html');
            loadElement('header', 'views/headerAdmin.html');
            cerrarModal();
            alert("Bienvenido, sr admin");

        } else {
            document.getElementById('login-error').innerText = '❌ Usuario o contraseña incorrectos.';
        }
    } catch (error) {
        console.error(error);
        document.getElementById('login-error').innerText = `❌ Error al leer el archivo: ${error.message}`;
    }
}

function logout(){
    loadElement('main', 'views/workinprogress.html');
    loadElement('header', 'views/header.html');
    // document.getElementById('login-error').innerText = '';
    
}