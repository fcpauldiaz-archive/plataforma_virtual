<?php
    //$db = parse_url(getenv('CLEARDB_DATABASE_URL'));
    $container->setParameter('database_driver', 'pdo_mysql');
    $container->setParameter('database_host', getenv('DB_HOST'));
    $container->setParameter('database_port', 3306);
    $container->setParameter('database_name', getenv('DB_NAME'));
    $container->setParameter('database_user', getenv('DB_USERNAME'));
    $container->setParameter('database_password', getenv('DB_PASSWORD'));
    $container->setParameter('secret', getenv('SECRET'));
    $container->setParameter('locale', 'es');
    $container->setParameter('mailer_transport', gmail);
    $container->setParameter('mailer_host', null);
    $container->setParameter('mailer_user', getenv('EMAIL_USER'));
    $container->setParameter('mailer_password', getenv('EMAIL_PASSWORD'));