Learn-In Platform
==================
[![Heroku](https://heroku-badge.herokuapp.com/?app=learn-in)](http://learn-in.herokuapp.com)
[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/fcpauldiaz/plataforma_virtual/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
[![Symfony](http://img.shields.io/badge/Symfony2-2.7.6-blue.svg)](http://syfmony.com)
![PHP](http://img.shields.io/badge/Buildpack-PHP-lightgrey.svg)
[![NodeJS](http://img.shields.io/badge/Buildpack-NodeJS-lightgrey.svg)](http://nodejs.com)

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

Urlize specific fields to create unique slug. [Doctrine-Extensions][11].

Soft delete entities [STOF][12].

Unit Tests and Functional tests [PHPUnit][13].

Populate database with fake data [AliceBundle][14].

Integrate Select2 as entity search [Genemu][15].

[jQuery][16].

[Bootstrap input style.][17]


###Usage instructions

1. Install [Symfony y Composer][4]
2. Install [MySQL][5]
3. Install PHP
4. Run MySQL service
5. Clone this repository
6. Go to terminal
7. Run composer install in folder path
8. Create database: php app/console doctrine:database:create
9. Create tables:  php app/console doctrine:schema:update --force
10. Run server: php app/console server:run

 

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
[17]:http://markusslima.github.io/bootstrap-filestyle/




