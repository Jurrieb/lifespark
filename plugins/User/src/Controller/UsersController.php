<?php
namespace User\Controller;

use User\Controller\AppController;

class UsersController extends AppController
{

    public function login()
    {
        $user = $this->Users->newEntity($this->request->data());
        if ($this->request->is('post')) {
            if (!$user->errors()) {

            }
        }
        $this->set('user', $user);
    }

    public function register()
    {
        $user = $this->Users->newEntity($this->request->data());
        if ($this->request->is('post')) {
            if (!$user->errors()) {
                $this->Users->save($user);
            }
        }
        $this->set('user', $user);
    }

    public function logout()
    {

    }
}
