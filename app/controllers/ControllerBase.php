<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    /**
     * Go Back from whence you came
     * @return type
     */
    protected function _redirectBack() {
        return $this->response->redirect($this->request->getHTTPReferer());
    }
    protected function _forwardBack() {
        $controller = $this->dispatcher->getPreviousControllerName();
        $action = $this->dispatcher->getPreviousActionName();

        return $this->dispatcher->forward([
            "controller" => $controller,
            "action" => $action
        ]);
    }
    public function afterExecuteRoute($dispatcher)
    {
        $this->session->set('lastControllerAction', $dispatcher->getControllerName().'/'.$dispatcher->getActionName());
    }

    protected function getLastControllerAction()
    {
        return $this->session->get('lastControllerAction');
    }
}
