<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class UsersPluginsTable extends Table
{
    public function initialize(array $config)
    {
        $this->hasOne('Plugins');
    }
}