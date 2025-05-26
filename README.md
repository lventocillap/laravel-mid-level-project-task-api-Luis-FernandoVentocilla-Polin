# 🧪 PRUEBA TÉCNICA – DESARROLLADOR BACKEND LARAVEL

Desarrollar una API RESTful para la gestión de proyectos y tareas con las siguientes características:<br>
-Relación entre proyectos y tareas (1:N)<br>
-Filtros dinámicos avanzados<br>
-Validaciones estrictas<br>
-Auditoría de acciones (creación, actualización, borrado) usando owen-it/laravel-auditing<br>
-Documentación de API usando L5-Swagger<br>
-Monitoreo de la aplicación usando Laravel Telescope<br>
-Estructura limpia, modular y profesional<br>

* Libreria que se usaron en este projecto<br>
-Laravel Telescope<br>
-laravel-auditing<br>
-L5-Swagger<br>

* Comando para clonar el proyecto:<br>
```bash
git clone https://github.com/lventocillap/laravel-mid-level-project-task-api-Luis-FernandoVentocilla-Polin.git
```
* Luego configuramos el entorno de Laravel usando los siguiente comandos:<br>
```bash
php artisan key:generate
php artisan optimize
```
* Luego configuramos nuestra base de datos en nuestro .env:<br>
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
* Para posteriormnente subir nuestras tablas en la base de datos con: <br>
```bash
php artisan migrate
```
