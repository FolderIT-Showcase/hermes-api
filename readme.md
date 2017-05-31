## HERMES WEB - Summer'18 - API

Hermes es un Sistema de Gestión Comercial (ERP).

## Tecnologías

* PHP 7.1.1
* Laravel 5.4
* MariaDB 10.1.21

## Requerimientos Previos

Para que el API funcione correctamente se deben instalar los elementos básicos asociados a las tecnologías. Estos son:
* Apache 2.4.25
* MariaDB 10.1.21
* PHP 7.1.1

Se recomienda descargar e instalar XAMPP:
* Para plataformas Windows se obtiene de [acá](https://www.apachefriends.org/xampp-files/7.1.1/xampp-win32-7.1.1-0-VC14-installer.exe).
* Para plataformas Linux se ontiene de [acá](https://www.apachefriends.org/xampp-files/7.1.1/xampp-linux-x64-7.1.1-0-installer.run).

Instalar [Composer](https://getcomposer.org/download/) para gestionar los paquetes de PHP.

## Instalación de HermesWeb - API

Pasos para instalar HermesWeb - API:
1. Clonar este repositorio al equipo local
2. Desde línea de comandos, pararse en el raiz del proyecto y ejecutar: `composer install` 
3. Conectarse al motor de base de datos (via PHPMyAdmin o MySQLWorkbench) y crear una base de datos nueva con Collation `utf8 - default collation`.
4. Copiar `.env.example` a `.env`
5. Actualizar los datos en `.env` relacionados a la base de datos creada en el paso 3 (parametros DB_*).
6. Actualizar los datos en `.env` relacionados al servidor smtp que se utilizará para enviar emails.
7. Desde línea de comandos, pararse en el raiz del proyecto y ejecutar: `php artisan migrate --seed`.
8. Crear un Virtual Host en el Apache para levantar el API:
```
<VirtualHost hermes.api:80>
  DocumentRoot "C:\Folder\HermesWeb\hermes.api\public"
  ServerAdmin hermes.api
  <Directory "C:\Folder\HermesWeb\hermes.api">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
  </Directory>
</VirtualHost>
``` 
9. Crear una entrada en el archivo `hosts` del SO para que la URL del API apunte al local: `127.0.0.1  hermes.api`
10. Crear la key con `php artisan key:generate`
11. Para comprobar que el API levantó correctamente abrir `http://hermes.api`, la página de inicio de Laravel debe desplegarse.


## Documentación

Laravel:
 * [Laravel documentation](https://laravel.com/docs).
 * [Laracasts](https://laracasts.com).
 
## Licencia

Hermes Web - Summer'18 es un producto propietario de Folder IT.
