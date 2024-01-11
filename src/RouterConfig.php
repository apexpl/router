<?php
declare(strict_types = 1);

namespace Apex\Router;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Router config
 */
class RouterConfig
{

    /**
     * Constructor
     */
    public function __construct(
        private string $routes_yaml_file = __DIR__ . '/../routes.yml'
    ) {

    }

    /**
     * Add route
     */
    public function add(string $path, string $http_controller, string $host = 'default'):void
    {

        // Load router file'
        $yaml = $this->load();
        $routes = $yaml['routes'] ?? [];

        // Add route as needed
        if (isset($routes[$host]) && is_array($routes[$host]) && !isset($routes[$host][$path])) { 
            $routes[$host][$path] = $http_controller;
        } elseif (!isset($routes[$path])) { 
            $routes[$path] = $http_controller;
        } else { 
            return;
        }

        // Save file
        $yaml['routes'] = $routes;
        $this->save($yaml);
    }

    /**
     * Remove a route
     */
    public function remove(string $path, string $host = 'default'):void
    {

        // Load router file'
        $yaml = $this->load();
        $routes = $yaml['routes'] ?? [];

        // Add route as needed
        if (isset($routes[$host]) && is_array($routes[$host]) && isset($routes[$host][$path])) { 
            unset($routes[$host][$path]);
        } elseif (isset($routes[$path])) { 
            unset($routes[$path]);
        } else { 
            return;
        }

        // Save file
        $yaml['routes'] = $routes;
        $this->save($yaml);
    }

    /**
     * Load YAML file
     */
    private function load():array
    {

        // Load Yaml file
        try {
            $yaml = Yaml::parseFile($this->routes_yaml_file);
        } catch (\Symfony\Component\Yaml\Exception\ParseException $e) { 
            throw new \Exception("Unable to parse routes.yml YAML file, error: " . $e->getMessage());
        }

        // Set and return
        return $yaml;
    }

    /**
     * Save yaml file
     */
    private function save(array $yaml):void
    {

        // Set YAML text
        $text = "\n##########\n";
        $text .= "# Below defines the various HTTP routes supported by the system \n";
        $text .= "# and which controller within the /src/HttpControllers/ directory handles them.\n#\n";
        $text .= "# Please refer to the documentation for full details.\n";
        $text .= "##########\n\n";
        $text .= Yaml::dump($yaml, 6);

        // Save YAML file
        file_put_contents($this->routes_yaml_file, $text);
    }

}




