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

###Bundles Integrated

Administrate Entities [EasyAdminBundle][6].

Enable tree comments as forum [FOSCommentBundle][7].

Upload PDF and Word documents [VichUploaderBundle][8].

Bootstrap 3.3 [Bootstrap][9].

Translation administration [LexikTranslationBundle][10].
[Doctrine-Extensions][11].

Soft delete entities [STOF][12].

Unit Tests and Functional tests [PHPUnit][13].

Populate database with fake data [AliceBundle][14].

Integrate Select2 as entity search [Genemu][15].

[jQuery][16].


###Instrucciones de instalación local

1. Instalar [Symfony y Composer][4]
2. Instalar [MySQL][5]
3. Asegurarse de que se haya instalado PHP
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
[5]: https://dev.mysql.com/downloads/installer/
[6]:https://github.com/javiereguiluz/EasyAdminBundle
[7]:https://github.com/FriendsOfSymfony/FOSCommentBundle
[8]:https://github.com/dustin10/VichUploaderBundle
[9]:http://getbootstrap.com
[10]:https://github.com/lexik/LexikTranslationBundle
[11]:https://github.com/l3pp4rd/DoctrineExtensions/tree/master/example
[12]:https://github.com/stof/StofDoctrineExtensionsBundle
[13]:http://symfony.com/doc/current/book/testing.html
[14]:https://github.com/hautelook/AliceBundle
[15]:https://github.com/genemu/GenemuFormBundle
[16]:https://packagist.org/packages/symfony-bundle/jquery-bundle

