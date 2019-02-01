<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    /**
     * Go Back from whence you came
     * @return type
     */
    protected function _redirectBack() {
        //return $this->response->redirect($this->request->getServer('HTTP_REFERER'));
        return $this->response->redirect($this->request->getHTTPReferer());
    }
}
