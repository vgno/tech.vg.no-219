<?php
/**
 * Redirector plugin
 *
 * This plugin will generate a canonical url using the current route and parameters found in the
 * request instance. It will then compare that url to the one currently requested. If they do not
 * match, do a 301 redirect to the correct url.
 *
 * Routes are responsible for putting the correct information about the accessed resource in the
 * request parameters for this to work. Take a look at the
 * Application_Controllers_Router_Route_Article class to see how this is accomplished.
 */
class Application_Controller_Plugin_Redirector extends Zend_Controller_Plugin_Abstract {
    /**
     * Route shutdown hook
     *
     * @param Zend_Controller_Request_Abstract $request The current request instance
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request) {
        // Fetch the current route
        $route = Zend_Controller_Front::getInstance()->getRouter()->getCurrentRoute();

        // Skip redirection by adding a noRedirect query parameter
        if (!$request->has('noRedirect')) {
            $canonicalUrl = $request->getBaseUrl() . '/' . $route->assemble($request->getParams());

            if ($canonicalUrl !== $request->getRequestUri()) {
                // The accessed url is not correct. Issue a 301 redirect.
                $this->getResponse()->setRedirect($canonicalUrl, 301)
                                    ->sendResponse();
            }
        }
    }
}
