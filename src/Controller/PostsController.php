<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{

    public function index()
    {
        $this->Friends = $this->loadModel('Friends');

        $offset = ($this->request->data('offset') ? $this->request->data('offset') : 0);
        $userId = ($this->request->data('user_id') ? $this->request->data('user_id') : $this->Authentication->getUser('id'));


        if($userId !== $this->Authentication->getUser('id')) {
            if(! $this->Friends->isFriend($userId)) {
                throw new NotFoundException('Could not find posts');
            }
        }

        $posts = $this->Post->find()
            ->where(['user_id' => $id])
            ->contain([
                     'Comments.Users', 'Users', 'Profile'
                 ])
			->limit(25)
            ->offset($offset)
            ->order(['Posts.created_at' => 'DESC'])
            ->all();

        $this->set('posts', $posts);
        $this->set('_serialize', true);
    }

    public function view($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => []
        ]);
        $this->set('post', $post);
        $this->set('_serialize', true);
    }

    public function create()
    {
        $post = $this->Posts->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->Authentication->getUser('id');
            $post = $this->Posts->patchEntity($post, $this->request->data);
            if ($this->Posts->save($post)) {
                $post = $this->Posts
					->find()
					->where(['Posts.id' => $post->id] )
					->contain([
			   			'Comments.Users', 'Users', 'Profile'
					])
					->first();

                $this->set(compact('post'));
                $this->set('_serialize', true);
            }
        }
    }

    public function update($id = null)
    {
        $post = $this->Posts->get($id);
        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->data);
            $this->Posts->save($post);
            $this->set(compact('post'));
            $this->set('_serialize', true);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        $this->Posts->delete($post);
        $this->set('_serialize', true);
    }

}
