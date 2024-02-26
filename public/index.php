<?php
session_start();

use Engine\Application\Application;
use Engine\Http\Kernel\HttpKernelAbstract;
use Engine\Http\ResponseKernel\HttpResponseKernelAbstract;
use Engine\Http\Request\Request;
ini_set('error_reporting','E_ALL & ~E_DEPRECATED');
require_once __DIR__.'/../AutoLoader.php';
AutoLoader::register();

$app = new Application(
    new \Engine\Container\Container(
        new \App\Bindings()
    )
);

$httpKernel = $app->make(HttpKernelAbstract::class);
$responseHttpKernel = $app->make(HttpResponseKernelAbstract::class);
$request = Request::capture();
$response = $httpKernel->handle($request);
$response = $responseHttpKernel->handle($response,$request);
$response->formResponse();
