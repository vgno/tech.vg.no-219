<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
    /**
     * Initialize routes for the application
     */
    protected function _initRoutes() {
        // Bootstrap and fetch the front controller
        $frontController = $this->bootstrap('frontController')->getResource('frontController');

        // Get the router instance so we can add our routes
        $router = $frontController->getRouter();

        // Remove deafult routes
        $router->removeDefaultRoutes();

        // Define application routes
        $routes = array(
            'front' => new Zend_Controller_Router_Route_Static(
                '/',
                array(
                    'controller' => 'index',
                    'action' => 'index'
                )
            ),
            'article' => new Application_Controller_Router_Route_Article(
                'article/([\d]+)-([a-z0-9-]+)',
                array(
                    'controller' => 'article',
                    'action' => 'index',
                ),
                array(
                    1 => 'id',
                    2 => 'title',
                ),
                'article/%d-%s'
            ),
        );

        // Add routes to the router
        $router->addRoutes($routes);
    }
}
