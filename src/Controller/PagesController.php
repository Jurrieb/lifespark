<?php
namespace App\Controller;

class PagesController extends AppController
{
    public function initialize()
    {
        $this->allow = ['index'];
        parent::initialize();
    }

    public function index()
    {
        $this->layout = 'website';
    }

    public function overview()
    {
        $this->Friends = $this->loadModel('Friends');
        $userId = $this->Authentication->getUser('id');
        $friendIds = $this->Friends->findIds($userId);
        $friends = $this->Friends->Users->find()
                ->where(['Users.id IN' => $friendIds])
                ->all();
        $this->set('friends', $friends);
    }
}
