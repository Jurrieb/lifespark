<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class AuthenticationComponent extends Component
{

    public function initialize(array $config)
    {
        $this->Users = TableRegistry::get('Users');
    }

    public function validate(array $allowedActions)
    {
        if(in_array($this->request->params['action'], $allowedActions))
        {
            return true;
        }
        $user = $this->request->session()->read('User');
        if($user) {
            return true;
        }
        return false;
    }

    public function checkUser($email, $password)
    {
        $salt = $this->Users->findSalt($email);

        $id = $this->Users->find()
                   ->where(['email' => $email, 'password' => SHA1($password. $salt), 'activated' => true])
                   ->extract('id')
                   ->first();
        if($id) {
            return $this->loginUser($id);
        }

        return false;
    }

    public function getUser($field = null)
    {
        if($field != null) {
            return $this->request->session()->read('User.'. $field);
        }
        return $this->request->session()->read('User');
    }

    public function setUser($id)
    {
        return $this->loginUser($id);
    }

    public function logoutUser()
    {
        $this->request->session()->delete('User');
        return true;
    }

    private function loginUser($id)
    {
        $user = $this->Users->get($id);
        if($user) {
            $this->request->session()->write(['User' => $user]);
            return true;
        }
    }
}

