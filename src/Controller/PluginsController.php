<?php
namespace App\Controller;

use App\Controller\AppController;


class PluginsController extends AppController
{
    public function index()
    {
        $plugins = $this->Plugin->UsersPlugins->find()
            ->where(['user_id' => $this->Authentication->getUser('id')])
            ->all();
        $this->set('plugins', $plugins);
    }

    public function removePlugin()
    {
        if($this->request->is('post')) {
            $plugin = $this->Plugin->UsersPlugins->find()
                ->where(['user_id' => $this->Authentication->getUser('id'), 'plugin_id' => $this->request->data['plugin']])
                ->all();
            if($this->Plugin->UsersPlugins->delete($plugin)){
                $this->set('message', ['message' => 'plugin removed']);
            } else {
                $this->set('message', ['message' => 'plugin not removed']);
            }
            $this->set('_serialize', true);
        }
    }

    public function addPlugin()
    {
        if($this->request->is('post')) {
            $plugin = $this->Plugin->UsersPlugins->find()
                ->where(['user_id' => $this->Authentication->getUser('id')])
                ->all();
            if($plugin) {
                $this->set('message', ['message' => 'plugin allready added']);
            } else {
                if($this->Plugin->UsersPlugins->delete($plugin)){
                    $this->set('message', ['message' => 'plugin added']);
                } else {
                    $this->set('message', ['message' => 'plugin not added']);
                }
                $this->set('_serialize', true);
            }
        }
    }
}
