<?php

session_start();

require dirname(__DIR__) . '/vendor/autoload.php';


$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


$router = new Core\Router();
$router->injectAppRoutes(App\Routes::getRoutes());
$router->add('{controller}/{action}');
$router->add("{action}",["controller" => "Index"]);
$router->add("",["controller" => "Index","action" => "index"]);



try {
    $router->dispatch($_SERVER['QUERY_STRING']);
} catch (\Throwable $e) {
    echo App\Error::exceptionHandler($e);
}


