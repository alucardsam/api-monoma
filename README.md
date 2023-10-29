<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Prueba técnica - MONOMA

Proceso de instalación y ejecución de este proyecto:

1. Clonar el repositorio o descomprimir el archivo zip del proyecto.
2. Ingresar al directorio root del proyecto para renombrar el archivo *__.env.example__* por *__.env__* y asi cargar todas las configuraciones del proyecto.
3. Abrir el proyecto en una terminal, para ejecutar los siguientes comandos.
4. Ejecutar el siguiente comando para descargar todas las dependencias utilizadas en este proyecto, es necesario el gestor de paquetes llamado __Composer__.
> ```console
> composer install
5. Ejecutar el siguiente comando para revisar la lista de todas las rutas (endpoint's) de la api.
> ```console
> php artisan route:list --path=api
6. Ejecutar el siguiente comando para realizar todas las migraciones y cargar los seeders para ejecutar las pruebas del proyecto.
> Desde la consola
> ```console
> php artisan migrate:fresh --seed
7. Ejecutar el siguiente comando para revisar el test unitario.
> Desde la consola
> ```console
> php artisan test --without-tty
8. Ejecutar el siguiente comando para habilitar el servidor de laravel.
> Desde la consola
> ```console
> php artisan serve
9. Utilizar un cliente REST para revisar los endpoint's; se puede utilizar la herramienta llamada __Postman__.
>Endpoints
>- POST *__URL_SERVER/api/auth__* para obtener el token (JWT).
>- GET *__URL_SERVER/api/leads__* para obtener la lista de candidatos.
>- GET *__URL_SERVER/api/lead/{id}__* para obtener un candidato.
>- POST *__URL_SERVER/api/lead__* para crear un candidato.
10. *__Opcional:__* Dentro las extensiones de VSCode existe la herramienta llamada [RESTClient](https://marketplace.visualstudio.com/items?itemName=humao.rest-client); con dicha extensión se puede hacer uso de los 4 archivos por endpoint dentro del directorio llamado api-request que se encuentra en la raiz del proyecto.
>_En cada archivo __*.rest__ es necesario cargar el body o token (JWT) requerido:_
>- Archivo *__POST_auth_login.rest__* para obtener el token (JWT).
>- Archivo *__GET_leads_index.rest__* para obtener la lista de candidatos.
>- Archivo *__GET_lead_show.rest__* para obtener un candidato.
>- Archivo *__POST_lead_create.rest__* para crear un candidato.

## Archivos creados para este proyecto

__api-request__
- POST_auth_login.rest
- GET_leads_index.rest
- GET_lead_show.rest
- POST_lead_create.rest

__app/Http/Controllers__
- UsuarioController.php
- CandidatoController.php
- RoleController.php
- JWTController.php

__app/Http/Middleware__
- CheckRole.php
- CheckJWT.php

__app/Http/Requests__
- UsuarioLoginRequest.php
- CandidatoCreateRequest.php

__app/Http/Resources__
- MetaTrueResource.php
- MetaFalseResource.php
- CandidatoCollection.php
- CandidatoResource.php

__app/Models__
- Usuario.php
- Candidato.php

__app/database/factories__
- UsuarioFactory.php
- CandidatoFactory.php

__app/database/migrations__
- 2023_10_27_021853_create_usuarios_table.php
- 2023_10_27_021854_create_candidatos_table.php
- 2023_10_27_135021_create_permission_tables.php

__app/database/seeders__
- UsuarioSeeder.php
- CandidatoSeeder.php
- RolesPermisosSeeder.php

__Test__
- UsuarioControllerTest.php
- CandidatoControllerTest.php

## Archivos editados para este proyecto

__app/Exceptions__
- Handler.php

__routes__
- web.php (Se borraron las rutas)
- api.php (Se crearon los 4 endpoints para la api)


## Elaborado por

[Ing. Samuel Adrián González González](mailto:samueladriang@gmail.com).