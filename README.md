Learn-In Platform
==================

A Symfony project created on June 16, 2015, 3:20 am.

Welcome to the Symfony Standard Edition - a fully-functional Symfony2
application that you can use as the skeleton for your new applications.

For details on how to download and get started with Symfony, see the
[Installation][1] chapter of the Symfony Documentation.

This project contains a custom [UserBundle][2] based on [FOSUserBundle][3].

Features Custom Registration, Password Resetting, Custom Email Activation,
Custom Profile, Custom Profile Edition, Standard Login. Powered By
Bootstrap.

###Instrucciones de instalación local

1. Instalar [Symfony y Composer][4]
2. Instalar [MySQL][5]
3. Asegurarse de que se haya instalado PHP4
4. Iniciar el servicio de MySQL
5. Clonar este repositorio de github
6. Dirigirse a la carpeta desde la terminal
7. Actualizar composer con: composer install
8. Verificar que se haya creado la carpeta vendor
9. Crear base de datos con: php app/console doctrine:database:create
10. Crear tablas: Ejecutar php app/console doctrine:schema:update --force
11. Correr el Servidor: php app/console server:run
12. Dirigirse hacia localhost:8000 en un explorador web
 

[1]:  http://symfony.com/doc/2.6/book/installation.html
[2]:  https://github.com/fcpauldiaz/plataforma_virtual/tree/master/src/UserBundle
[3]:  https://github.com/FriendsOfSymfony/FOSUserBundle
[4]:http://symfony.com/doc/current/book/installation.html
