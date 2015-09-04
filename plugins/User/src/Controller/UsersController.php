<?php
namespace User\Controller;

use User\Controller\AppController;

class UsersController extends AppController
{

    public function login()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

        }
        $this->set('user', $user);
    }

    public function register()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

        }
        $this->set('user', $user);
    }

    public function logout()
    {

    }
}
