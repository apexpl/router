
# Base Configuration

There's a few basic steps you will need to quickly complete to properly setup and instantiate the router, which are explained below.

### Router YAML File

All routes are placed within an easy to read and manipulate [routes.yml file](https://github.com/apexpl/router/blob/master/routes.yml), and the location of that file must be defined during instantiation as the `$routes_yaml_file` construction parameter.  Choose a location within your project for this file.


## Middleware Namespace

All middleware classes must have the same root namespace.  Create a new directory within your project, and note its namespace.

## Syrus Container File

If using the Syrus template integration, you may have a custom container.php file within your project.  If yes, not it's location.


## Construction Parameters

All parameters are optional, but you may instantiate the router with for example:

~~~php
use Apex\Router\Router;

$router = new Router(
    routes_yaml_file: '/path/to/your/routes.yml',
    middleware_namespace: "App\\Router\\Middleware",
    syrus_container_file: /path/to/syrus/container.php'
);
~~~

Again, all three parameters are optional, and defaults are:

* routes_yaml_file -- __DIR__ . '/../routes.yml'
* middleware_namespace -- Middleware
* syrus_container_file -- ''


