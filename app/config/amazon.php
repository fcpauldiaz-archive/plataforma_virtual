<?php

    $container->setParameter('key',getenv('AWS_ACCESS_KEY_ID'));
    $container->setParameter('secret',getenv('AWS_SECRET_ACCESS_KEY'));