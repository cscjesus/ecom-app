# Lista de comandos utilizados para generar la app

## `laravel new ecom-app`
## seleccionar none 
## 1
## La bd puede ser cualquiera, se cambiara despues
## ejecutar `npm install` y `npm run build`
## Instalara laravel jetstream 
`composer require laravel/jetstream`
`php artisan jetstream:install livewire --dark`
## ejecutar migraciones

## crear host virtual en Windows
Como administrador ejecutar `notepad` y buscar `C:\Windows\System32\drivers\etc\hosts`, agregar `127.0.0.1       ecom-app.test y guardar.

Ahora ir a `C:\xampp\apache\conf\extra\httpd-vhosts.conf` y agregar lo siguiente al final:
```
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot "C:/xampp/htdocs"
</VirtualHost>

<VirtualHost *:80>
    ServerName ecom-app.test
    DocumentRoot "C:/xampp/htdocs/laravel/ecom-app/public"
</VirtualHost>
```
Reiniciar apache.
## Crear una base de datos para el proyecto
Ir a phpmyadmin y agregar una base de datos con el nombre de `ecom_app`, ademas configurar la conexion en `.env`, ejecutar migraciones.
## Traducir la aplicacion a español, ejecutar

`composer require laravel-lang/common`
`php artisan lang:add es`
Cambiar en `.env` el valor de `APP_LOCALE=es`
los pasos a seguir estan en `https://laravel-lang.com/basic-usage.html#installation`

## para ver el rendimiento de la aplicacion
`composer require barryvdh/laravel-debugbar --dev`

## Solucionar problema de imagen con faker

### Abre el archivo de configuración:
Presiona `Ctrl + P` en Visual Studio Code (VSC) y busca el siguiente archivo:
```php
vendor/fakerphp/faker/src/Faker/Provider/Image.php
```

### Modifica la variable del proveedor de imágenes:
Una vez abierto el archivo, localiza la variable `BASE_URL` y reemplaza su valor por el nuevo proveedor. Por ejemplo:

```php
// public const BASE_URL = 'https://via.placeholder.com';
public const BASE_URL = 'https://placehold.jp';
```

### Ejecuta los seeders nuevamente:
Después de realizar el cambio, guarda el archivo y ejecuta los seeders de nuevo para que los cambios surtan efecto.

## Crear acceso directo a `storage`
Ejecutar `php artisan storage:link` para crear un acceso directo a la carpeta `storage/app/public` en `public/storage`.
## software requerido

- Composer
- nodejs v22.16.0
- npm v10.9.2
- php 8.2.12

