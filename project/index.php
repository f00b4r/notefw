<?php

require_once __DIR__ . '/vendor/autoload.php';

use Note\App;
use Note\Events\Event;
use Note\SimpleApp;
use Tracy\Debugger;

Debugger::enable(Debugger::DEVELOPMENT);
Debugger::$logDirectory = __DIR__;
Debugger::$strictMode = TRUE;

$factory = new SimpleApp();
$factory->setTempDir(__DIR__ . '/temp');
$factory->setEnv(App::DEVELOPMENT);
$factory->addExtension('router', new Note\Extra\Router\Nette\DI\NetteRouterExtension());
$factory->addExtension('view', new Note\Extra\View\Latte\DI\LatteExtension());
$app = $factory->create();

$app->route('', function () {
    return 'TEST2';
});

$app->route('name/<name [0-9]>', function ($request, $response, $params) {
    $stop();
    return 'TEST3';
});

$app->run();