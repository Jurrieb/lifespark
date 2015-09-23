<?php
	echo $this->Html->link('Verander wachtwoord',
	['controller' => 'Users', 'action' => 'passwordReset', $token, '_full' => true]);
 ?>