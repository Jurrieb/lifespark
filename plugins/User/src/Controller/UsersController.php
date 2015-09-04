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
                $userData = $this->Users->identify($this->request->data);
                if($userData) {
                    $this->Flash->success(__d('user', 'Welcome {0}', [$userData->name]));
                } else {
                  $this->Flash->error(__d('user', 'The given combination of email and password is invalid'));
                }
            }
        }
        $this->set('user', $user);
    }

    public function register()
    {
        $user = $this->Users->newEntity($this->request->data());
        if ($this->request->is('post')) {
            if (!$user->errors()) {
                if($this->Users->save($user)){
                    $this->Flash->success(__d('user', '{0} youre account has been registerd', [$user->name]));
                    return $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->error(__d('user' , 'Cannot save to database'));
                    return $this->redirect(['action' => 'register']);
                }
            }
        }
        $this->set('user', $user);
    }

    public function logout()
    {

    }
}
