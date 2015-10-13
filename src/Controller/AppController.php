<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Network\Exception\NotFoundException;

class AppController extends Controller
{
    public $helpers = ['Assets', 'Time'];
    public $authenticate = true;
    public $allow = [];

    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication');
        $this->loadComponent('RequestHandler');

        if(!isset($this->allow) || !$this->Authentication->validate($this->allow)) {
            if($this->request->is('json')) {
               throw new UnauthorizedException('You are not authorized');
            }
            $this->Flash->error(__('You are not authorized to view this page'));
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }

        $pluginName = $this->request->params['plugin'];
        if($pluginName != null) {
            $this->UsersPlugins = $this->loadModel('UsersPlugins');
            $plugin = $this->UsersPlugins->find()
               ->where(['user_id' => $this->Authentication->getUser('id'), 'name' => $pluginName])
               ->count();
            if(! $plugin) {
                throw new NotFoundException('Could not find that page');
            }
        }

    }
}