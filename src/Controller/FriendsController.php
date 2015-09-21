<?php
namespace App\Controller;

class FriendsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $userId = $this->Authentication->getUser('id');
        $friendIds = $this->Friends->findIds($userId);
        $friends = $this->Friends->Users->find()
                ->where(['Users.id IN' => $friendIds])
                ->all();
        $this->set('friends', $friends);
        $this->set('_serialize', ['friends']);
    }

    public function search()
    {

    }

    public function relation()
    {
        
    }

}
