<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('report_homepage', new Route('/hello/{name}', array(
    '_controller' => 'ReportBundle:Default:index',
)));

return $collection;
