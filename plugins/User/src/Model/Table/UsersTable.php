<?php
namespace User\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

class UsersTable extends Table
{
    public function validationLogin(Validator $validator)
    {
        return $validator
            ->notEmpty('email')
            ->notEmpty('password');
    }

    public function validationRegister(Validator $validator)
    {
        return $validator
            ->notEmpty('name')
            ->notEmpty('email')
            ->notEmpty('password')
            ->notEmpty('passwordConfirm')
            ->add('email', 'validFormat', [
                'rule' => 'email'])
            ->add('email', [
                'unique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table'
                ]
            ])
            ->add('password', 'custom', [
                'rule' => function ($value, $context) {
                    if($value == $context['data']['password_confirm']) {
                        return true;
                    }
                  return false;
            }]);
    }

    public function identify($data = []){
        if(isset($data['email']) && isset($data['password'])){
            $salt = $this->find()
                ->where(['Users.email' => $data['email']])
                ->select(['Users.password_salt'])
                ->first();
            
            if(isset($salt->password_salt) && !empty($salt->password_salt)){
                $user = $this->find()
                ->where([
                    'Users.email' => $data['email'],
                    'Users.password' => SHA1($data['password'] . $salt->password_salt)
               ])->select([
                   'name',
                   'email',
                   'created_at',
                   'modified_at'
                ])
               ->first();
               if($user){
                   return $user;
               }
            }
        }
        return false;
    }

    private function generateSalt()
    {
        return uniqid(mt_rand(), true);
    }

    public function beforeSave (\Cake\Event\Event $event, \Cake\ORM\Entity $entity, ArrayObject $options)
    {
        if(isset($entity->password)){
            $entity->password_salt = $this->generateSalt();
            $entity->password = SHA1($entity->password . $entity->password_salt);
        }
    }

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
    }
}