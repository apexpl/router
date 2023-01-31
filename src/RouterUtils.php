<?php
declare(strict_types=1);

namespace Apex\Router;

use Apex\Container\Interfaces\ApexContainerInterface;
use Apex\Router\RouterResponse;
use Apex\Router\Interfaces\RouterResponseInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Router utils
 */
class RouterUtils
{

    // Properties
    protected ?RouterResponseInterface $router_response = null;
    protected ApexContainerInterface $cntr;

    /**
     * Output response
     */
    public function outputResponse(ResponseInterface $response):void
    {

        // Set status
        http_response_code($response->getStatusCode());

        // Set headers
        $headers = $response->getHeaders();
        foreach ($headers as $key => $values) { 
            $line = $key . ': ' . $response->getHeaderLine($key);
            header($line);
        }

        // Send body
        echo $response->getBody();
    }

    /**
     * Set router response
     */
    public function setRouterResponse(RouterResponseInterface $response):void
    {
        $this->router_response = $response;
        $this->cntr->set(RouterResponse::class, $response);
        $this->cntr->set('path_params', $response->getPathParams());
    }

    /**
     * Get router response
     */
    public function getRouterResponse():?RouterResponseInterface
    {
        return $this->router_response;
    }

}


