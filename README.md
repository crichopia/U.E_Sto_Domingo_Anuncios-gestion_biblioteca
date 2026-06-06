# U.E_Sto_Domingo_Anuncios-Gestion_biblioteca
Pagina web para publicacion de anuncios escolares y gestion de la biblioteca 

1. Roles y accesos

#Invitado:

¿Cómo se accede?: Por defecto, sin iniciar sesión.

¿Que puede hacer?:

-Ver anuncios activos.
-Consultar disponibilidad de libros.

#Administrador

¿Cómo se accede?: Hace clic en "Acceso administrador" e ingresa una clave única (global).

¿Que puede hacer?:

-Ver anuncios activos.
-Consultar disponibilidad de libros.
-Publicar/editar/eliminar anuncios.
-Gestionar inventario de libros.
-Registrar préstamos y devoluciones.
-Ver historial completo de préstamos.
Nota: El rol Administrador agrupa a profesores, directivos y bibliotecarios. No hay distinciones internas.

2. Módulo de anuncios informativos

#Visualización (Invitado y Administrador)
-Cualquier visitante ve los anuncios activos en orden cronológico inverso (más reciente primero).
-Cada anuncio muestra: título, contenido, fecha de publicación, autor (nombre del administrador que lo creó).
#Gestión de anuncios (solo Administrador)
-Para crear, editar o eliminar un anuncio, el usuario debe autenticarse con la clave única de administración.
-Crear: título y contenido obligatorios. Opcional: fecha de expiración. Si se establece, el anuncio deja de mostrarse después de esa fecha.
-Editar: solo el administrador que creó el anuncio puede editarlo (o cualquier administrador, según prefieras – se puede definir como "cualquier admin puede editar cualquier anuncio" para simplificar).
-Eliminar: cualquier administrador puede eliminar cualquier anuncio.

3. Módulo de gestión de inventario de biblioteca

#Consulta de disponibilidad (Invitado y Administrador)
-Cualquier visitante puede buscar libros por título, autor o categoría.
-El sistema muestra para cada libro: título, autor, número de ejemplares disponibles en ese momento.
-No se muestran datos personales de quién tiene prestado el libro.

#Gestión del catálogo (solo Administrador)
El administrador puede:
– Agregar un nuevo libro (título, autor, categoría, cantidad de ejemplares).
– Editar datos de un libro.
– Eliminar un libro.
– Agregar o quitar ejemplares individuales (cada ejemplar tiene un ID interno y estado: disponible, prestado, extraviado, dañado).

 #Préstamo (solo Administrador)
El administrador autenticado puede registrar un préstamo.

#Requisitos:
– Identificar al estudiante o representante (se ingresa el nombre completo + curso). 
– Seleccionar un ejemplar disponible del libro deseado.

#Reglas:
– Un estudiante no puede tener más de 3 préstamos activos simultáneamente.
– Si el estudiante tiene un préstamo vencido (fecha de devolución pasada), no se le permite un nuevo préstamo hasta que devuelva.
– Fecha de devolución esperada: por defecto 15 días después del préstamo (configurable).
– Al prestar, el ejemplar cambia a estado prestado.

#Devolución (solo Administrador)
El administrador registra la devolución:
– Selecciona el préstamo activo.
– Registra fecha real de devolución.
– El ejemplar vuelve a estado disponible.
– Si el libro se extravía o daña, el administrador puede marcar el ejemplar como extraviado/dañado (no disponible para préstamo).

4. Reglas transversales

# Sesión de administrador
– La clave única de administración se ingresa en un formulario de login sencillo.
– Mientras la sesión esté activa (por ejemplo, mientras la ventana está abierta), el usuario puede realizar acciones administrativas.
– Se puede cerrar la sesión de administrador manualmente con un botón de cerrar sesión.

# Usuario invitado por defecto
– Al entrar a la página web, no se pide ningún login. Se ven directamente los anuncios y el buscador de libros.
– Para acceder a funciones de administración, el usuario debe hacer clic en "Acceso administrador" y proporcionar la clave.

5. Ejemplos de flujos

#Flujo típico de un estudiante (invitado)
1-Entra a la página web.
2-Ve los anuncios activos.
3-Busca un libro por título.
4-El sistema le muestra "Disponible: 2 ejemplares".
5-Para ver su historial, ingresa su número de estudiante y apellido (sin clave admin) y consulta los libros que tiene prestados.

#Flujo de préstamo (administrador)
1-El bibliotecario (admin) hace clic en "Acceso administrador".
2-Ingresa la clave única.
3-Busca el libro que el estudiante quiere.
4-Verifica que haya ejemplares disponibles.
5-Ingresa el ID del estudiante y confirma el préstamo.
6-El sistema actualiza el estado del ejemplar y registra la fecha de devolución esperada.



