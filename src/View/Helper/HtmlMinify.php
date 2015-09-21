<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class HtmlMinifyHelper extends Helper
{
    public function test() {
        if(!Configure::read('debug')) {
        }
    }
}