
# Syrus Template Engine Integration

Full optional integration with the Syrus template engine is available, essentially turning the router into a micro-framework.  It also allows you to easily define routes based on HTTP verb, which the routes.yml file does not support for cleanliness reasons.  

Syrus is already installed with the router as a dependancy.  For full details on Syrus, please visit the Github site at: [https://github.com/apexpl/syrus/](https://github.com/apexpl/syrus/).

## Setting Up

First, copy the file located at ~/vendor/apex/syrus/config.container.php somewhere into your project and modify as necessary.  Mainly, you want to modify the following variables:

* syrus.template_dir
* syrus.site_yml
* syrus.php_namespace

When you instantiate the router, ensure to define the `$syrus_container_file` parameter, such as:

~~~php
use Apex\Router\Router;

$router = new Router(
    routes_yaml_file: '/path/to/routes.yml',
    middelware_namespace: "App\\Routing\\Middelware",
    syrus_container_file: '/path/to/container.php'
);
~~~

Second, copy over the contents of the ~/vendor/apex/syrus/views directory to the directory you specified as the "syrus.template_dir" variable within the container.php file.  Clear the /html and /php sub-directories as well.

Third, ensure what you specified as the "syrus.php_namespace" variable within container.php points to the /views/php directory.

Last, within the routes.yml file, set whatever route(s) you would like (ie. "default") to the value of "Syrus".  The necessary middleware is already included with the router, and if needed can be grabbed via [Github at this link](https://github.com/apexpl/router/blob/master/middelware/Syrus.php).


## Usage

By default Syrus does take advantage of [auto routing](https://github.com/apexpl/syrus/blob/master/docs/autorouting.md), meaning it will map the URI being accessed to a file based on directory structure.  For example, if accessing /services/support, it's going to check for a template located at /html/services/support.html.

`  Considering that, go ahead and [start creating some templates](https://github.com/apexpl/syrus/blob/master/docs/designers/getting_started.md).

Most importantly, ensure to [create a PHP class](https://github.com/apexpl/syrus/blob/master/docs/execute_php.md) for each template, which allows for full dependancy injection, and per-HTTP verb methods (ie. get(), post(), delte(), et al), allowing you to define your routes based on HTTP verb.


