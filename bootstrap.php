<?php

require 'vendor/autoload.php';

$app = new Silex\Application();
require __DIR__ . '/config/services.php';
require __DIR__ . '/config/routes.php';
$app->run();
