<?php
namespace App\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;


class SluggableBehavior extends Behavior
{
    protected $_defaultConfig = [
        'field' => 'name',
        'slug' => 'slug',
        'replacement' => '.',
    ];

    public function createSlug($slug, $count, $id = 0){
        $usersTable = TableRegistry::get('Users');

        if($count > 0){
            $newSlug = $slug.'.'.$count;
        } else {
            $newSlug = $slug;
        }

        if($usersTable->find()
                ->where(['slug' => $newSlug,'id !=' => $id])
                ->first()
            ) {
            $count++;
        } else {
            return $newSlug;
        }

        return $this->createSlug($slug, $count, $id);
    }

    public function beforeSave(Event $event, Entity $entity)
    {
        $config = $this->config();
        $value = $entity->get($config['field']);
        $id = (isset($entity->id) ? $entity->id : 0);

        $slug = $this->createSLug(strtolower(Inflector::slug($value, $config['replacement'])), 0, $id);

        $entity->set($config['slug'], $slug);

    }

}