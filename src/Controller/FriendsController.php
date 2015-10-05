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
        $friendIds = $this->Friends->findIds($this->Authentication->getUser('id'));
        $friends = $this->Friends->findFriends($friendIds);

        $this->set('friends', $friends);
        $this->set('_serialize', ['friends']);
    }

    public function search()
    {

    }

    public function relation()
    {
        if ($this->request->is('post')) {
            $connection = $this->Friends->updateConnection($this->Authentication->getUser('id'), $this->request->data['slug'], $this->request->data['action']);
            $this->set('connection', $connection);
            $this->set('_serialize', ['connection']);
        }
    }

}
