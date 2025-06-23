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

los pasos a seguir estan en `https://laravel-lang.com/basic-usage.html#installation`


## software requerido

- Composer
- nodejs v22.16.0
- npm v10.9.2
- php 8.2.12
