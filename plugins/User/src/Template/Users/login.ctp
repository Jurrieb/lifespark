<?php
echo $this->Form->create($user, [
    'context' => ['validator' => 'login']
]);
echo $this->Form->input('email', [
    'type' => 'email',
    'label' => __d('user', 'Email')
]);
echo $this->Form->input('password', [
    'type' => 'password',
    'label' => __d('user', 'Password')
]);
echo $this->Form->button(__d('user', 'Login'));
echo $this->Form->end();
