<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

class UsersTable extends Table
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

        $this->belongsTo('UsersVerifyTokens', [
            'className' => 'UsersVerifyTokens',
            'dependent' => true
        ]);

        $this->belongsTo('UsersPasswordTokens', [
            'className' => 'UsersPasswordTokens',
            'dependent' => true
        ]);

        $this->hasMany('Friends', [
            'className' => 'Friends',
            'dependent' => true
        ]);

        $this->addBehavior('Sluggable');
    }

    public function findBySlug($slug)
    {
        return $this->find()
                    ->where(['slug' => $slug])
                    ->first();
    }

    public function findSalt($email)
    {
       return $this->find()
                    ->where(['email' => $email])
                    ->extract('password_salt')
                    ->first();
    }

    public function saveVerifyToken($userId)
    {
        if(!$this->UsersVerifyTokens->exists(['user_id' => $userId])){
            $user = $this->UsersVerifyTokens->newEntity(['user_id' => $userId, 'token' => $this->randomString(32)]);
            return $this->UsersVerifyTokens->save($user);
        }
    }

    public function deleteVerifyToken($userId)
    {
        $token = $this->UsersVerifyTokens->find()
                ->where(['user_id' => $userId])
                ->first();
        if($token){
            return $this->UsersVerifyTokens->delete($token);
        }
    }

    public function activateAccount($id) {
        $user = $this->find()
              ->where(['id', $id])
              ->first();
        $user->activated = true;
        if($this->save($user)) {
            $this->deleteVerifyToken($id);
            return true;
        }
        return false;
    }

    public function savePasswordToken($email)
    {
        $userId = $this->find()
                    ->where(['email' => $email, 'activated' => true])
                    ->extract('id')
                    ->first();
        if($userId){
            if(!$this->UsersPasswordTokens->exists(['user_id' => $userId])){
                $token = $this->randomString(32);
                $user = $this->UsersPasswordTokens->newEntity(['user_id' => $userId, 'token' => $token]);
                if($this->UsersPasswordTokens->save($user)) {
                    return $token;
                }
            }
        }
    }

    public function deletePasswordToken($userId)
    {
        $token = $this->UsersPasswordTokens->find()
                ->where(['user_id' => $userId])
                ->first();
        if($token){
            return $this->UsersPasswordTokens->delete($token);
        }
    }

    public function randomString($length = 16)
    {
		$string = "";
		$possible = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		for($i=0;$i < $length;$i++) {
			$char = $possible[mt_rand(0, strlen($possible)-1)];
			$string .= $char;
		}
		return $string;
	}

    public function validationLogin(Validator $validator)
    {
        $validator
            ->notEmpty('email', _('Email is required'))
            ->add('email', 'valid-email', ['rule' => 'email'])
            ->notEmpty('password', _('Password is required'));
        return $validator;
    }

    public function validationRegister(Validator $validator)
    {
        return $validator
            ->notEmpty('name', _('Name is required'))
            ->notEmpty('email', _('Email is required'))
            ->notEmpty('password', _('Password is required'))
            ->add('name', [
                'minLength' => [
                    'rule' => ['minLength', 5],
                    'last' => true,
                    'message' => 'Min length of 5.'
                ],
                'maxLength' => [
                    'rule' => ['maxLength', 40],
                    'message' => 'max length of 40'
                ],
                'alphaNumeric' => [
                    'rule' => 'alphaNumeric',
                    'message' => 'Can only contain letters and numbers'
                ]
            ])
            ->notEmpty('passwordConfirm', _('Password confirm is required'))
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => 'E-mail must be valid'
            ])
            ->add('email', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Articles must have a substantial body.'
            ])
            ->add('password', 'custom', [
                'rule' => function ($value, $context) {
                    if($value == $context['data']['passwordConfirm']) {
                        return true;
                    }
                  return false;
                },
                'message' => 'De ingevulde wachtwoorden zijn niet gelijk.'
            ])
            ->add('passwordConfirm', 'custom', [
                'rule' => function ($value, $context) {
                    if($value == $context['data']['password']) {
                        return true;
                    }
                  return false;
                },
                'message' => 'De ingevulde wachtwoorden zijn niet gelijk.'
            ]);
    }

    public function validationRequestPasswordReset(Validator $validator)
    {
        return $validator
            ->notEmpty('email', _('Email is required'))
            ->add('email', 'valid-email', ['rule' => 'email']);
    }

    public function validationPasswordReset(Validator $validator)
    {
        return $validator
            ->notEmpty('password', _('Password is required'))
            ->notEmpty('passwordConfirm', _('Password confirm is required'))
            ->add('password', 'custom', [
                'rule' => function ($value, $context) {
                    if($value == $context['data']['passwordConfirm']) {
                        return true;
                    }
                  return false;
                },
                'message' => 'De ingevulde wachtwoorden zijn niet gelijk.'
            ])
            ->add('passwordConfirm', 'custom', [
                'rule' => function ($value, $context) {
                    if($value == $context['data']['password']) {
                        return true;
                    }
                  return false;
                },
                'message' => 'De ingevulde wachtwoorden zijn niet gelijk.'
            ]);
    }

    public function beforeSave (\Cake\Event\Event $event, \Cake\ORM\Entity $entity, ArrayObject $options)
    {
        if(isset($entity->password) && !empty($entity->password)) {
            $entity->password_salt = $this->randomString(24);
            $entity->password = SHA1($entity->password . $entity->password_salt);
            unset($entity->passwordConfirm);
        }
    }

    public function afterSave(\Cake\Event\Event $event, \Cake\ORM\Entity $entity, ArrayObject $options)
    {
        if ($entity->isNew()) {
            $this->saveVerifyToken($entity->id);
        }
    }
}
