<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Network\Exception\UnauthorizedException;

class AppController extends Controller
{
    public $authenticate = true;
    public $allow = [];

    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication');

        if(!$this->Authentication->validate($this->allow)) {
            if($this->request->is('json')) {
               throw new UnauthorizedException('You are not authorized');
            }
            $this->Flash->error(__('You are not authorized to view this page'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }

        $this->set('production', ($_SERVER['SERVER_NAME'] == 'lifespark.dev' ? false : true));
    }
}