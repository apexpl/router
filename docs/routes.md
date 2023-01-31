
# Routes YAML File

All routes are stored within a YAML file, the path of which is defined as the `$routes_yaml_file` parameter during instantiation of the router.  A default routes.yml file is included which if desired you may view on Github at [this link](https://github.com/apexpl/router/blob/master/routes.yml).  The file contains the following contents:

~~~
routes:
    default: Syrus
    members: MembersArea
    contact$: ContactPage
    "product/:category/:product_id": ProductViewer
~~~

Quickly going through this file line by line:

* The root "routes:" element is required.
* Each route is simply a key-value pair, the key being the URI and the value being the middleware class.
* HTTP requests that do not match any routes will use the default route.
* All HTTP requests that begin with the URI "members/" (eg. /members/account/update) will be handled by MembersArea.
* Adding a dollar sign ($) to the end of a route signfies it's an exact match route.  Unlike the above "members" route, only /contact will work but not /contact/something/else.
* Dynamic path parameters can be defined by adding a colon (:) to the beginning of segments.  With the "product/" route, the variables "category" and "product_id" will be available to the middleware.


# Multi Host Routing

Support for multi host routing is included by simply changing the route definitions to be an array of route definitions, with the top-level item of each array being the host name.  For example, within the routes.yml file:

~~~
routes:

  wiki.domain.com:
    admin/: WikiAdmin
    default: Wiki

  default:
    api/: RestApi
    default: PublicSite
~~~

With the above, all HTTP requests to the host wiki.domain.com will be passed to either the `WikiAdmin` or `Wiki` HTTP controllers, and all other HTTP requests will be handled by the other default set of route definitions.


