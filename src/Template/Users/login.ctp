<?php
echo'<h3>'. __d('user', 'Login with LifeSpark').'</h3>';
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
echo $this->Form->button(__d('user', 'Login'), ['class' => 'button']);
echo $this->Html->link(__d('user', 'Register account'), [
    'action' => 'register']);
echo $this->Html->link(__d('user', 'Password reset'), [
    'action' => 'requestPasswordReset']);
echo $this->Form->end();
