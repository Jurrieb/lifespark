<?php 
	echo $this->Html->link('Verander wachtwoord', 
	['controller' => 'Users', 'action' => 'passwordReset', $securityKey,'_full' => true]);
 ?>