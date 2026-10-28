document.querySelectorAll('input').forEach(input => {
    input.setAttribute('autocomplete', 'off');
});

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

//* filtrar recomendaciones por autor

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
function eliminarLibroDelPrestamo(inputTitle, inputId){
    const titleInput = document.getElementById(inputTitle);
    const idInput = document.getElementById(inputId);

    if (!titleInput || !idInput) {
        console.warn('No se encontraron los inputs para el título o el ID del libro');
        return;
    }
    titleInput.value = '';
    idInput.value = '';
}

function cambiarSeccionPrestamo(idA, idB) {
    const seccionA = document.getElementById(idA);
    const seccionB = document.getElementById(idB);

    if (!seccionA || !seccionB) {
        console.warn('No se encontraron las secciones de préstamo');
        return;
    }

    seccionA.classList.remove('hidden');
    seccionB.classList.add('hidden');
}

function cambiarSeccionSubrayada(idA, idB) {
    const seccionA = document.getElementById(idA);
    const seccionB = document.getElementById(idB);

    if (!seccionA || !seccionB) {
        console.warn('No se encontraron las secciones de préstamo');
        return;
    }

    seccionA.classList.remove('subrayado');
    seccionB.classList.add('subrayado');
}

//* gestionar visibilidad de formularios
function rotarIcono(el){
    console.log('rotarIcono called', el);
    if (!el) {
        console.warn('rotarIcono: no element passed');
        return;
    }
    el.classList.toggle('rotado');
}

function abrirFormulario(id){
    const formulario = typeof id === 'string'
        ? document.getElementById(id)
        : id instanceof Element ? id : null;

    if (!formulario) {
        console.warn('abrirFormulario: no se encontró el formulario');
        return;
    }

    const cerrado = formulario.classList.toggle('cerrado');
    formulario.setAttribute('aria-hidden', String(cerrado));
    formulario.inert = cerrado;
}
