
# Middleware Classes

HTTP requests are handled by PSR15 compliant classes, examples of which can be seen within ~/middleware of the installation directory, or also on [Github within the /middleware directory](https://github.com/apexpl/router/blob/master/middleware).

All middleware classes must reside under the same root namespace, which is defined as the `$middleware_namespace` constructor parameter within the router.  For example, if you define `App\Routing\Middleware`, the router will prepend that to the values within the routes.yml file and forward the HTTP request to it.

As per PSR15 standards, the middleware classes only require one function called `process()` that takes two parameters, the PSR7 request object, and a handler object which is simply an instance of the `Apex\Router\Router` class.

All middleware classes fully support both, attribute and constructor based dependancy injection.

## Example

There are examples within ~/middleware of the installation directory, but one is below:

~~~php
&lt;?php
declare(strict_types = 1);

namespace Middleware;

use Nyholm\Psr7\Response;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

/**
 * Default http controller, generally intended to serve public web site.
 */
class PathParamsExample implements MiddlewareInterface
{

    #[Inject('path_params')]
    private array $params;

    /**
     * Process request
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        // Set variables
        $category = $this->params['category'];
        $product_id = $this->params['product_id'];

        // Set response
        $html = "You are looking at the product id $product_id from category $category\n";

        // Return PSR7 response
        $response = new Response(200, [], $html);
        return $response;
    }

}
~~~



Again, just a standard PSR15 middleware class which returns a PSR7 response.  If necessary, simply use the above code as a template for all middleware classes.

As you will notice, above also includes an example of how to utilize dynamic path parameters.  Simply inject them into the class by adding the following lines just under the class declaration:

~~~php
#[Inject('path_params')]
private array $params;
~~~

A `$params` property will then be available within the class that consists of an associative array of all dynamic path parameters.


