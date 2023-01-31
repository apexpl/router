
# Router Functions

Quite simplistic package, and necessary public methods needed are below.


## Instantiate

~~~php~~~
use Apex\Apex\Router;

$router = new Router(
    routes_yaml_file: '/path/to/routes.yml',
    middleware_namespace: "App\\Routing\\Middleware",
    syrus_container_file: '/path/to/container.php'
);


All three parameters are optional, and defaults are:

* routes_yaml_file -- __DIR__ . '/../routes.yml'
* middleware_namespace -- Middleware
* syrus_container_file -- ''

## handle(ServerRequestInterface $request): ResponseInterface

Pass it a ServerRequestInterface object, it will lookup your routing table to determine the proper middleware, execute the process() function within middleware, then output the resulting ResponseInterface object to the client. 


## lookup(ServerRequestInterface $request):RouterResponseInterface

Pass it a ServerRequestInterface object, it'll go through your routes and determine one, then provide you with a RouterResponse object.  Please check /src/interfaces/RouterResponseInterface.php interface for methods available.


## execute(RouterResponseInterface $response, bool $output = true):ResponseInterface

The `lookup()` method provides a ResponseInterface object.  This one will take that object, execute the process() method within the middleware class, and optionally output the results of the ResponseInterface object to the browser.




