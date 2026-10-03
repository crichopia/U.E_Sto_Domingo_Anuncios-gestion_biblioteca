//* Load elements 

function loadElement(element, elementPath) {
    fetch(elementPath)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const style = doc.querySelector('style');
            if (style) {
                document.head.appendChild(style.cloneNode(true));
            }
            document.getElementById(element).innerHTML = doc.body.innerHTML;
        })
        .catch(error => {
            console.error('No se pudo cargar ' + elementPath + ':', error);
        });
}

//* modal functions 

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

//* filtrar libros por titulo

function filtrarPorTitulo(inputId, itemSelector, titleSelector = '.title') {
    const input = document.getElementById(inputId);
    const items = document.querySelectorAll(itemSelector);

    if (!input) {
        console.warn(`No se encontró el input con id "${inputId}"`);
        return;
    }

    const aplicarFiltro = () => {
        const texto = input.value.trim().toLowerCase();

        items.forEach(item => {
            const titulo = item.querySelector(titleSelector);
            const contenido = titulo ? titulo.textContent.toLowerCase() : '';

            if (contenido.includes(texto)) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    };

    aplicarFiltro();
}

//* filtrar libros por categoría
function filtrarLibros(){
    const selectYear = document.getElementById('year');
    const selectMateria = document.getElementById('materia');

    if (!selectYear || !selectMateria) {
        console.warn('No se encontraron los filtros de año y materia');
        return;
    }

    const filtroA = selectYear.value.trim().toLowerCase();
    const filtroB = selectMateria.value.trim().toLowerCase();

    const libros = document.querySelectorAll('.bookItem');
    
    libros.forEach(libro => {
        const year = (libro.dataset.year || '').trim().toLowerCase();
        const materia = (libro.dataset.materia || '').trim().toLowerCase();
        const coincideYear = filtroA === '' || year === filtroA;
        const coincideMateria = filtroB === '' || materia === filtroB;

        libro.classList.toggle('hidden', !(coincideYear && coincideMateria));
    });
}

//*filtrar noticias por importanca

function filtrarNoticias(){
    const select = document.getElementById('importance');
    if (!select) {
        console.warn('No se encontró el filtro de importancia');
        return;
    }

    const filtro = select.value;
    const noticias = document.querySelectorAll('.news_item');
    
    noticias.forEach(noticia => {
        const coincide = filtro === '' || noticia.classList.contains(filtro);
        noticia.style.display = coincide ? '' : 'none';
    });
}

//* añadir libro al prestamo
function prestarLibro(inputTitle, inputId, bookTitle, bookId){
    const titleInput = document.getElementById(inputTitle);
    const idInput = document.getElementById(inputId);

    if (!titleInput || !idInput) {
        console.warn('No se encontraron los inputs para el título o el ID del libro');
        return;
    }
    titleInput.value = bookTitle;
    idInput.value = bookId;
}