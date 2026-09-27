
function abrirModal(id) {

    const modal = document.getElementById(id);
    const overlay = document.querySelector('.overlay');

    modal.classList.remove('hidden')
    overlay.classList.remove('hidden');


}

function cerrarModal(id) {
    const overlay = document.querySelector('.overlay');
    const modal = document.getElementById(id);

    modal.classList.add('hidden');
    overlay.classList.add('hidden');
}

// function activateAdminFunctions() {

//     const adminFunctions = document.querySelector('.adminFunction');

//     adminFunctions.classList.remove('hidden')

// }
// function removeAdminFunctions() {

//     const adminFunctions = document.querySelector('.adminFunction');

//     adminFunctions.classList.add('hidden')

// }
