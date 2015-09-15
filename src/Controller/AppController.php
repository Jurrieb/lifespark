<?php

namespace App\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{
    public $authenticate = true;
    public $allow = [];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication');

        if(!$this->Authentication->validate($this->allow)){
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }
    }
}
