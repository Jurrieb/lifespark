<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class AssetsHelper extends Helper
{
    public $helpers = ['Html'];
    private $config;

    public function css($name = null)
    {
        return $this->fetch($name, 'css');
    }

    public function script($name = null)
    {
        return $this->fetch($name, 'js');
    }

    private function fetch($name, $type)
    {
        $assets = null;
        $this->readConfig();
        if(!Configure::read('debug')) {
            if($type == 'css') {
                $assets = $this->Html->css( $this->config[$type][$name]['cache'] );
            }
            if($type == 'js') {
                $assets = $this->Html->script( $this->config[$type][$name]['cache'] );
            }
            return $assets;
        }
        foreach($this->config[$type][$name]['files'] as $file) {
           if($type == 'css') {
            $assets .= $this->Html->css($file);
           }
           if($type == 'js') {
            $assets .= $this->Html->script($file);
           }
        }
        return $assets;
    }

    private function readConfig()
    {
        if(!file_exists(ROOT . DS . 'config' . DS . 'assets.json')) {
            return false;
        }
        $json = file_get_contents(ROOT . DS . 'config' . DS . 'assets.json');
        $this->config = json_decode($json, true);
    }
}