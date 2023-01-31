<?php
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



