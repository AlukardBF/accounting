<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->response->redirect('material_value/index');
    }

}

