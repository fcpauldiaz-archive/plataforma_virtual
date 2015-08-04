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
2. Instalar MySQL y PHP
3. Iniciar el servicio de MySQL
4. Clonar este repositorio de github
5. Dirigirse a la carpeta desde la terminal
6. Actualizar composer con: composer update
7. Verificar que se haya instalado la carpeta vendor
8. Ejecutar php app/console doctrine:schema:update --force
9. Ejecutar: php app/console server:run
10. Dirigirse hacia localhost:8000 en un explorador web
 

[1]:  http://symfony.com/doc/2.6/book/installation.html
[2]:  https://github.com/fcpauldiaz/plataforma_virtual/tree/master/src/UserBundle
[3]:  https://github.com/FriendsOfSymfony/FOSUserBundle
[4]:http://symfony.com/doc/current/book/installation.html
