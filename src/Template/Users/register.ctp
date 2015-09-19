<?php
echo $this->Form->create($user, [
    'context' => ['validator' => 'register']
]);
echo $this->Form->input('name',[
    'type' => 'text',
    'label' => __d('user', 'Name')
]);
echo $this->Form->input('email', [
    'type' => 'email',
    'label' => __d('user', 'Email')
]);
echo $this->Form->input('password', [
    'type' => 'password',
    'label' => __d('user', 'Password')
]);
echo $this->Form->input('passwordConfirm', [
    'type' => 'password',
    'label' => __d('user', 'Password confirm')
]);
echo $this->Form->button(__d('user', 'Register'), ['class' => 'button']);
echo $this->Form->end();
