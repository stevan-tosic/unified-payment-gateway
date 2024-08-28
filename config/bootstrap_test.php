<?php

require dirname(__DIR__) . '/vendor/autoload.php';
require_once __DIR__ . '/../src/Kernel.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;

$_ENV['APP_ENV'] = 'test';
$_SERVER['APP_ENV'] = 'test';
$_SERVER['APP_DEBUG'] = true;
$_SERVER += $_ENV;

$kernel = new App\Kernel($_SERVER['APP_ENV'], $_SERVER['APP_DEBUG']);
$kernel->boot();

$container = $kernel->getContainer();
$application = new Application($kernel);
$application->setAutoExit(false);

$chandler = 'default';
