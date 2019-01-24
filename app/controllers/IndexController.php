<?php

class IndexController extends ControllerBase
{

    public function indexAction($error='')
    {
        //$this->response->redirect('material_value/index');
        $this->view->auth = $this->session->auth;
        $this->view->error = $error;
    }

}

