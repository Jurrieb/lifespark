<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class PostsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'modified_at' => 'always'
                ]
            ]
        ]);

        $this->belongsTo('Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id',
        ]);

        $this->hasMany('Comments', [
            'className' => 'Comments',
            'foreignKey' => 'post_id',
        ]);
    }

    public function findByUserIds($id) {
        if(is_array($id)){
            return $this->find()
                   ->where(['user_id IN' => $id])
                    ->contain([
			   			'Comments.Users', 'Users',
					])
                   ->all();
        }
        return $this->find()
            ->where(['user_id' => $id])
            ->contain([
                     'Comments.Users', 'Users',
                 ])
            ->order(['Posts.created_at' => 'DESC'])
            ->all();
    }

}