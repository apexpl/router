
# Apex Router

Light weight, easy to understand and use HTTP router that also comes fully and optionally integrated with the [Syrus template engine](https://github.com/apexpl/syrus/), essentially turning it into a cool little micro framework.  Not meant for leavy lifting, but excellent if you just need something well structured up and running quickly.  Supports the following:

* Simplistic YAML file to define routes which supports partial and full matching paths, dynamic path parameters, and multiple hostnames.
* Fully supports PSR15 and PSR7, and uses middleware classes for forwarding of all HTTP requests.
* All middleware classes fully support both, attribute and constructor based dependancy injection via the [Apex Container](https://github.com/apexpl/container).
* Optional built-in integration with the [Syrus Template Engine](https://github.com/apexpl/syrus/), allowing for auto-routing / mapping of templates, a separate PHP file with each template, and HTTP method-specific PHP functions within each PHP class.


## Installation

Install via Composer with:

> `composer require apex/routing`


## Table of Contents

1. [Base Configuration](https://github.com/apexpl/router/blob/master/docs/config.md)
2. [Routes YAML File](https://github.com/apexpl/router/blob/master/docs/routes.md)
3. [Middleware Classes](https://github.com/apexpl/router/blob/master/docs/middleware.md)
4. [Router Functions](https://github.com/apexpl/router/blob/master/docs/functions.md)
5. [Syrus Template Engine Integration](https://github.com/apexpl/router/blob/master/docs/syrus.md)

## Basic Usage

For a quick example, check the [example.php](https://github.com/apexpl/router/blob/master/example.php) script that comes with this package.

First, add some routes to your YAML file:

~~~
routes:
    default: Syrus
    members: MembersArea
    contact$: ContactPage
    "product/:category/:product_id": PathParamsExample

~~~


~~~php
use Apex\Router\Router;
use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7\Factory\Psr17Factory;
use League\Uri\Http;

require_once("./vendor/autoload.php");

// Define a uri to test with
$uri = Http::createFromString("http://example.com/category/cars");

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
~~~

## Support

If you have any questions, issues or feedback, please feel free to drop a note on the <a href="https://reddit.com/r/apexpl/">ApexPl Reddit sub</a> for a prompt and helpful response.

