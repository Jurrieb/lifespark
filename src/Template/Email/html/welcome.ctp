<?php
	echo $this->Html->link('Account verivieren',
	['controller' => 'Users', 'action' => 'verifyEmail', $token, '_full' => true]);
 ?>