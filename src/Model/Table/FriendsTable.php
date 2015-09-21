<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class FriendsTable extends Table
{
    public function initialize(array $config)
    {
        $this->belongsTo('Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id',
        ]);

        $this->belongsTo('Friends', [
            'className' => 'Users',
            'foreignKey' => 'friend_id',
        ]);
    }

    public function findIds($userId)
    {
        $friends1 = $this->find()
            ->orWhere(['friend_id' => $userId, 'accepted' => true])
            ->extract('user_id')
            ->toArray();
        $friends2 = $this->find()
            ->where(['user_id' => $userId, 'accepted' => true])
            ->extract('friend_id')
            ->toArray();
        return array_merge($friends1, $friends2);

    }
}
