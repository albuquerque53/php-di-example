<?php

use Albuca\DiPhp\App\Application;
use Albuca\DiPhp\App\Di\Container;

require_once 'vendor/autoload.php';

$dependencies = require('settings/dependencies.php');
$container = new Container($dependencies);

$app = new Application($container);
$app->run();