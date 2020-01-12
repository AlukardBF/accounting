<?php

class SessionController extends \Phalcon\Mvc\Controller
{
	private function _registerSession($user)
    {
        $this->session->set(
            'auth',
            [
                'id'   => $user->getUserId(),
                'email' => $user->getEmail(),
                'role' => $user->getRole(),
            ]
        );
    }

    public function indexAction()
    {
    	if (!$this->request->isPost()) {
            return $this->response->redirect('index/index');
    	}
    	$email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // $user = User::findFirstByEmail($email);
        $user = User::findFirst([
                [
                    "email" => $email,
                ],
            ],
        );
        // $user = User::findFirst();

        if ($user !== false && $this->security->checkHash($password, $user->getPassword())) {
            $this->_registerSession($user);

            if ($user->getRole() == 'admin') {
                return $this->response->redirect('material_value/index');
            } else {
                return $this->response->redirect('index');
            }

        }

        return $this->dispatcher->forward(
            [
                'controller' => 'index',
                'action'     => 'index',
                'params' => [error=>'Введен неправильный логин или пароль'],
            ]
        );
    }

     public function logoutAction()
    {
        $this->session->destroy();
        return $this->response->redirect();
    }

}

