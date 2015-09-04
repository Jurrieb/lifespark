<?php
namespace User\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function validationLogin(Validator $validator)
    {
		$validator->notEmpty('email');
		$validator->notEmpty('password');
        return $validator;
    }

    public function validationRegister(Validator $validator)
    {
		$validator->notEmpty('email');
		$validator->notEmpty('password');

        return $validator
            ->notEmpty('name')
            ->notEmpty('password')
            ->notEmpty('passwordConfirm')
            ->notEmpty('email')
            ->add('email', 'validFormat', [
                'rule' => 'email'])
            ->add('email', [
                'unique' => ['rule' => 'validateUnique', 'provider' => 'table']
            ])
            ->add('password', 'custom', [
                'rule' => function ($value, $context) {
                    if($value === $context['data']['passwordConfirm']) {
                        return true;
                    }
                  return false;
            }]);
        return $validator;
    }
}