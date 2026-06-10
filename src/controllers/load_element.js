
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
