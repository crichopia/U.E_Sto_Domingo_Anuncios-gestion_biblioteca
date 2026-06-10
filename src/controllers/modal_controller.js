
function abrirModal(id) {

    const modal = document.getElementById(id);
    const overlay = document.querySelector('.overlay');

    modal.classList.remove('hidden')
    overlay.classList.remove('hidden');


}

function cerrarModal() {
    const overlay = document.querySelector('.overlay');
    const modal = document.querySelector('.modal');

    modal.classList.add('hidden');
    overlay.classList.add('hidden');
}

