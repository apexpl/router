<?php

use Apex\Router\Router;
use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7\Factory\Psr17Factory;
use League\Uri\Http;

require_once("./vendor/autoload.php");

// Define a uri to test with
$uri = Http::createFromString("http://example.com/category/cars");
$uri = Http::createFromString("http://example.com/product/car/1234");

// Generate PSR7 compliant server request object
$factory = new Psr17Factory();
$creator = new ServerRequestCreator($factory, $factory, $factory, $factory);
$request = $creator->fromGlobals()->withUri($uri);

// Handle http request via router
$router = new Router();
$response = $router->handle($request);

// If this is handled via Syrus auto-routing, the 
// HTML would have already been output to the user. 
// Otherwise, $response is a PSR7 ResponseInterface object.

// Alternatively, we can use the lookup method
$response = $router->lookup($request);

// This simply determines the route, obtains any dynamic path parameters, 
// and instantiates the middleware, but does not execute the process() method within it.
// Instead, $response is a Apex\Router\RouterResponse instance.

// Now, to execute the middle wear and output:
$router->execute($response, true);


