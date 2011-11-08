<?php
class ArticleController extends Zend_Controller_Action {
    public function indexAction() {
        // fetch the article from the request instance. The article route has already made sure
        // there is an available article for the current request so that the controller does not
        // have to do the validation.
        $this->view->article = $this->getRequest()->getParam('article');
        $this->view->requestUri = $this->getRequest()->getRequestUri();
    }
}
