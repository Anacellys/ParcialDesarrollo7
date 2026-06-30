# Proyecto Evento Tecnológico

## Requisitos
- XAMPP con Apache, MySQL y PHP 8.
- Extensión OpenSSL habilitada.
- Navegador moderno.

## Ruta del proyecto
- Carpeta en XAMPP: htdocs/ParcialSoftware7/ProyectoEvento

## Instalación
1. Copia la carpeta ProyectoEvento dentro de htdocs de XAMPP.
2. Inicia Apache y MySQL.
3. Importa el archivo database/script.sql en phpMyAdmin.
4. Abre http://localhost/ParcialSoftware7/ProyectoEvento/

## Base de datos
- Nombre: parcial_itech
- Tablas: paises, areas_interes, inscriptores, inscriptor_area

## Configuración
- El archivo app/config/config.php define la conexión a MySQL.
- Ajusta DB_USER y DB_PASS si tu XAMPP usa credenciales distintas.

## Uso
- Completa el formulario de inscripción.
- Visualiza el reporte con nacionalidad, fecha y estado de integridad.
- Exporta los datos a Excel desde el botón correspondiente.

## Exportación Excel
- El botón Exportar Excel genera un archivo .xlsx con todas las columnas del reporte.

## OpenSSL
- El sistema genera automáticamente las llaves en app/config/keys/ al cargar por primera vez.
- Si deseas regenerarlas, elimina los archivos private.pem y public.pem de esa carpeta y recarga la aplicación.
- Las llaves quedan fuera del repositorio gracias a .gitignore.
