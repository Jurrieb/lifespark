<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 */
class CommentsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('comments', $this->paginate($this->Comments));
        $this->set('_serialize', ['comments']);
    }

    public function view($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => []
        ]);
        $this->set('comment', $comment);
        $this->set('_serialize', ['comment']);
    }

    public function create()
    {
        $comment = $this->Comments->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->Authentication->getUser('id');
            $comment = $this->Comments->patchEntity($comment, $this->request->data);
            if ($this->Comments->save($comment)) {
                $comment = $this->Comments
					->find()
					->where(['Comments.id' => $comment->id] )
					->contain([
			   			'Users',
					])
					->first();

                $this->set(compact('comment'));
                $this->set('_serialize', ['comment']);
            }
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->Comments->get($id);
        $this->Comments->delete($comment);
        $this->set('_serialize', true);
    }
}
