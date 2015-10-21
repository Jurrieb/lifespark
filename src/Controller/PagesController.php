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
        $this->viewBuilder()->layout('website');
    }

    public function overview()
    {
        $this->Friends = $this->loadModel('Friends');
        $this->Posts = $this->loadModel('Posts');
        $userId = $this->Authentication->getUser('id');

        $friendIds = $this->Friends->findIds($userId);
        $friends = $this->Friends->findFriends($friendIds);

        $postUserIds = $friendsIds[] = $userId;
        $posts = $this->Posts->findByUserId($postUserIds);

        $this->set('posts', $posts);
        $this->set('friends', $friends);
    }
}
