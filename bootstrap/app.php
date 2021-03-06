<?php

session_start();

use Slim\Factory\AppFactory;
use League\Container\Container;

require __DIR__ . '/../vendor/autoload.php';

\Cartalyst\Sentinel\Native\Facades\Sentinel::instance(
    new \Cartalyst\Sentinel\Native\SentinelBootstrapper(
        require(__DIR__ . '/../config/auth.php')
    )
);

require __DIR__ . '/database.php';

$container = new Container();

AppFactory::setContainer($container);

$app = AppFactory::create();

require_once __DIR__ . '/container.php';
require_once __DIR__ . '/middleware.php';
require_once __DIR__ . '/controllers.php';
require_once __DIR__ . '/exceptions.php';
require_once __DIR__ . '/validation.php';

require_once __DIR__ . '/../routes/web.php';