<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class FriendsTable extends Table
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

        $this->belongsTo('Friends', [
            'className' => 'Users',
            'foreignKey' => 'friend_id',
        ]);
    }

    public function findFriends($friendIds)
    {
        return $this->Users->find()
            ->where(['Users.id IN' => $friendIds])
            ->all();
    }

    public function findIds($userId)
    {
        $friends1 = $this->find()
            ->where(['friend_id' => $userId, 'accepted' => true])
            ->extract('user_id')
            ->toArray();
        $friends2 = $this->find()
            ->where(['user_id' => $userId, 'accepted' => true])
            ->extract('friend_id')
            ->toArray();
        return array_merge($friends1, $friends2);
    }

    public function checkConnection($userId, $friendId)
    {
        if($userId == $profileId) {
            return 'self';
        }
        $connection = $this->find()
            ->where(['friend_id' => $userId, 'user_id' => $friendId])
            ->orWhere(['user_id' => $userId, 'friend_id' => $friendId])
            ->first();

        if($connection) {

            if($connection->accepted) {
                return 'accepted';
            }

            if($connection->user_id == $userId) {
                return 'requested';
            } else {
                return 'friend-request';
            }

        }
        return false;
    }

    public function updateConnection($userId, $slug, $action)
    {
        $friend = $this->Users->find()
            ->where(['slug' => $slug])
            ->extract('friend_id')
            ->first();

        $connection = $this->checkConnection($userId, $friend->id);

        switch($action) {
            case 'send':
                if($connection) { return false; }
                $newConnection = $this->Posts->newEntity(['friend_id' => $friend->id, 'user_id' => $userId]);
                if($this->save($newConnection)){ return true; }
            break;
            case 'accept':
                if ($connection->accepted) { return false; }
                $connection = $this->patchEntity($connection, ['accepted' => true]);
                if($this->save($connection)){ return true; }
            break;
            case 'delete':
                if($connection->accepted){ return false; }
                if($this->delete($connection)){ return true; }
            break;
            case 'break':
            break;
        }
        
        return false;
    }
}
