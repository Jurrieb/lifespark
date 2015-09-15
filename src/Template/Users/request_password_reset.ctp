<?php
echo $this->Form->create($user, [
    'context' => ['validator' => 'requestPasswordReset']
]);
echo $this->Form->input('email', [
    'type' => 'email',
    'label' => __d('user', 'Email')
]);
echo $this->Form->button(__d('user', 'Send email'));
echo $this->Form->end();
