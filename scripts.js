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

async function buscarLibrosModal(event) {
    event.preventDefault();

    const input = document.getElementById('searchInput');
    const list = document.querySelector('#modal_libros #modalBooksList');
    const status = document.getElementById('bookSearchStatus');
    if (!input || !list || !status) {
        console.warn('No se encontraron los elementos de búsqueda de libros');
        return;
    }

    if (buscarLibrosModal.controller) {
        buscarLibrosModal.controller.abort();
    }
    const controller = new AbortController();
    buscarLibrosModal.controller = controller;
    status.textContent = 'Buscando libros...';

    try {
        const searchUrl = new URL(list.dataset.searchUrl, window.location.href);
        searchUrl.searchParams.set('q', input.value.trim());
        const response = await fetch(searchUrl, {
            headers: { 'Accept': 'application/json' },
            signal: controller.signal
        });
        if (!response.ok) {
            throw new Error(`La búsqueda respondió con el estado ${response.status}`);
        }

        const result = await response.json();
        if (!Array.isArray(result.books)) {
            throw new Error(result.error || 'La respuesta de búsqueda no es válida');
        }

        const fragment = document.createDocumentFragment();
        result.books.forEach(book => {
            const wrapper = document.createElement('div');
            wrapper.className = 'controlled_book';

            const card = document.createElement('div');
            card.className = 'bookItem';
            card.id = String(book.id);
            card.dataset.year = book.year || '';
            card.dataset.materia = book.materia || '';

            const image = document.createElement('img');
            image.src = book.img_url || '';
            image.alt = 'Portada del Libro';
            card.appendChild(image);

            const details = document.createElement('div');
            details.style.cssText = 'display:flex;width:100%;flex-direction:column;gap:5px;';

            const title = document.createElement('h3');
            title.className = 'book_title';
            title.textContent = book.title || '';
            details.appendChild(title);

            const year = document.createElement('h4');
            year.textContent = `Año: ${book.year || ''}`;
            details.appendChild(year);

            const subject = document.createElement('h4');
            subject.textContent = `Materia: ${book.materia || ''}`;
            details.appendChild(subject);

            if (Number(book.num_copies) > 0) {
                const buttonWrapper = document.createElement('div');
                buttonWrapper.className = 'centerTheDamnButton';
                const selectButton = document.createElement('button');
                selectButton.className = 'controlarLibro';
                selectButton.type = 'button';
                selectButton.setAttribute('aria-label', 'Seleccionar libro');
                const icon = document.createElement('i');
                icon.className = 'fa-solid fa-check';
                selectButton.appendChild(icon);
                selectButton.addEventListener('click', () => {
                    cerrarModal('modal_libros');
                    prestarLibro('book_name', 'book_id', book.title || '', Number(book.id));
                    cambiarBotonPrestamo('boton_Aniadir', 'boton_Eliminar');
                });
                buttonWrapper.appendChild(selectButton);
                details.appendChild(buttonWrapper);
            }

            card.appendChild(details);
            wrapper.appendChild(card);
            fragment.appendChild(wrapper);
        });

        list.replaceChildren(fragment);
        status.textContent = result.books.length
            ? `${result.books.length} libros encontrados`
            : 'No se encontraron libros.';
    } catch (error) {
        if (error.name === 'AbortError') {
            return;
        }
        console.error('No se pudo buscar libros:', error);
        status.textContent = 'No se pudo completar la búsqueda. Inténtalo de nuevo.';
    }
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

function cambiarBotonPrestamo(idAniadir, idEliminar) {
    const botonAniadir = document.getElementById(idAniadir);
    const botonEliminar = document.getElementById(idEliminar);
    botonAniadir.classList.toggle('hidden');
    botonEliminar.classList.toggle('hidden');
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
