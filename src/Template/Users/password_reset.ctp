<?php
echo $this->Form->create($user, [
    'context' => ['validator' => 'passwordReset']
]);
echo $this->Form->input('password', [
    'type' => 'password',
    'label' => __d('user', 'Password')
]);
echo $this->Form->input('passwordConfirm', [
    'type' => 'password',
    'label' => __d('user', 'Password confirm')
]);
echo $this->Form->button(__d('user', 'Change password'));
echo $this->Form->end();
