# Sistema de Inscripción para Evento Tecnológico

## Requisitos
- XAMPP con Apache, MySQL y PHP 8.
- Extensión OpenSSL habilitada en PHP.
- Navegador moderno.

## Instalación
1. Copia la carpeta ProyectoEvento dentro de htdocs de XAMPP.
2. Inicia Apache y MySQL.
3. Importa el archivo database/script.sql en phpMyAdmin.
4. Abre http://localhost/ParcialSoftware7/ProyectoEvento/ o http://localhost/ParcialSoftware7/ProyectoEvento/public/index.php.

## Base de datos
La base de datos se llama parcial_itech y contiene las tablas paises, areas_interes, inscriptores e inscriptor_area.

## Configuración
El archivo app/config/config.php define la conexión a MySQL. Ajusta usuario y contraseña si es necesario.

## Uso
- Completa el formulario de inscripción.
- Visualiza el reporte de participantes.
- Exporta los datos a Excel desde el botón correspondiente.

## Capturas esperadas
- Formulario con diseño responsive y Bootstrap 5.
- Reporte con estados verde y rojo según integridad.
- Exportación en formato xlsx.
