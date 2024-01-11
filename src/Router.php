<?php
declare(strict_types = 1);

namespace Apex\Router;

use Apex\Container\Container;
use Apex\Container\Interfaces\ApexContainerInterface;
use Apex\Router\Interfaces\{RouterInterface, RouterResponseInterface};
use Symfony\Component\Yaml\Yaml;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Apex\Router\Exceptions\{RouterYamlException, RouterNoRoutesException, RouterNoDefaultRouteException, RouterMiddlewareNotExistsException};

/**
 * Router
 */
class Router extends RouterUtils implements RouterInterface
{

    /**
     * Constructor
     */
    public function __construct(
        private string $routes_yaml_file = __DIR__ . '/../routes.yml',
        private string $middleware_namespace = 'Middleware',
        private string $syrus_container_file = '',
        ApexContainerInterface $cntr = new Container()
    ) {
        $cntr->set('syrus_container_file', $syrus_container_file);
        $this->cntr = $cntr;
    }

    /**
     * Handle
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        // Get response
        $response = $this->lookup($request);

        // Process middleware
        $http_response = $this->execute($response, true);

        // Return
        return $http_response;
    }

    /**
     * Execute
     */
    public function execute(RouterResponseInterface $response, bool $output = true):ResponseInterface
    {

        // Execute middleware
        $request = $response->getRequest();
        $middleware = $this->cntr->make($response->getMiddleware());
        $http_response = $middleware->process($request, $this);

        // Output, if needed
        if ($output === true) {
            $this->outputResponse($http_response);
        }

        // Return
        return $http_response;
    }

    /**
     * Lookup route
     */
    public function lookup(ServerRequestInterface $request):RouterResponseInterface
    {

        // Load routes
        $routes = $this->getRoutes($request->getUri()->getHost());

        // Initialize Variables
        $middleware = $routes['default'] ?? 'DefaultPage';
        $path = ltrim($request->getUri()->getPath(), '/');

        $params = [];
        $match_num = 0;

        // Go through routes
        foreach ($routes as $chk_path => $controller) { 
            $chk_path = ltrim($chk_path, '/');
            list($full_match, $param_keys) = [false, []];

            // Check for full match
            if (preg_match("/^(.+)\\$$/", $chk_path, $m)) { 
                $chk_path = $m[1];
                $full_match = true;
            }

            // Check for parameters
            if (preg_match("/^(.+?):(.+$)/", $chk_path, $m)) { 
                $chk_path = $m[1];
                $param_keys = array_map(function($p) { return ltrim($p, ':'); }, explode('/', $m[2]));
            }

            // Check for a match
            if ($full_match === true && $chk_path != $path) { 
                continue;
            } elseif ($full_match !== true && !str_starts_with($path, $chk_path)) { 
                continue;
            }

            // Get params, if needed
            if (count($param_keys) > 0) { 
                $vars = explode('/', preg_replace("/^" . str_replace("/", "\\/", $chk_path) . "/", '', $path));
                $path = $chk_path;

                foreach ($param_keys as $key) {
                    $value = count($vars) > 0 ? array_shift($vars) : '';
                    if ($value != '') {
                        $params[$key] = $value;
                    }
                }
            }

            // Check number of params
        if (count($param_keys) > count($params)) {
            continue;
        }

            // Set controller, and break
            $middleware = $controller;
            break;
        }

        // Load middleware
        $class_name = rtrim($this->middleware_namespace, "\\") . "\\" . $middleware;
        if (!class_exists($class_name)) { 
            throw new RouterMiddlewareNotExistsException("Middleware does not exist at $class_name");
        }
        //$middleware = $this->cntr->make($class_name);

        // Get router response
        $response = new RouterResponse(
            middleware: $class_name,
            path_translated: '/' . $path, 
            params: $params,
            request: $request
        );

        // Set response
        $this->setRouterResponse($response);

        // Return 
        return $response;
    }

    /**
     * Get routes
     */
    private function getRoutes(string $host):array
    {

        // Ensure routes file exists
        if (!file_exists($this->routes_yaml_file)) {
            throw new RouterYamlException("The routes.yml file does not exist at $this->routes_yaml_file");
        }

        // Load router file'
        // Load Yaml file
        try {
            $yaml = Yaml::parseFile($this->routes_yaml_file);
        } catch (\Symfony\Component\Yaml\Exception\ParseException $e) { 
            throw new RouterYamlException("Unable to parse routes.yml YAML file, error: " . $e->getMessage());
        }

        // Get routes
        $routes = $yaml['routes'] ?? [];
        if (count($routes) == 0) { 
            throw new RouterNoRoutesException("No routes exist within the routes.yml file");
        } elseif (!isset($routes['default'])) { 
            throw new RouterNoDefaultRouteException("The routes.yml file does not contain a 'default' entry, which is required.");
        }

        // Check if multi host
        if (!is_array($routes[array_keys($routes)[0]])) { 
            $res = $routes;
        } else { 

            // Check for host based route
            $host = preg_replace("/^www\./", '', strtolower($host));
            $res = $routes[$host] ?? $routes['default'];
        }

        // Sort routes
        uksort($res, function ($a, $b) {
            return substr_count($a, '/') >= substr_count($b, '/') ? -1 : 1;
        });

        // Return
        return $res;
    }

}

