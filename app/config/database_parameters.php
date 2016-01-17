<?php
    $db = parse_url(getenv('CLEARDB_DATABASE_URL'));
    $container->setParameter('database_driver', 'pdo_mysql');
    $container->setParameter('database_host', $db['host']);
    $container->setParameter('database_port', $db['port']);
    $container->setParameter('database_name', substr($db["path"], 1));
    $container->setParameter('database_user', $db['user']);
    $container->setParameter('database_password', $db['pass']);
    $container->setParameter('secret', getenv('SECRET'));
    $container->setParameter('locale', 'es');
    $container->setParameter('mailer_transport', gmail);
    $container->setParameter('mailer_host', null);
    $container->setParameter('mailer_user', getenv('USERNAME_SENGRID'));
    $container->setParameter('mailer_password', getenv('PASSWORD_SENGRID'));
    $container->setParameter('key',getenv('AWS_ACCESS_KEY_ID'));
    $container->setParameter('secret',getenv('AWS_SECRET_ACCESS_KEY'));

