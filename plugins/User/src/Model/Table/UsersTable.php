<?php
namespace User\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

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