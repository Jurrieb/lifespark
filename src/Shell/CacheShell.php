<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class CacheShell extends Shell
{

    public function main()
    {
        $this->out('Commands');
        $this->out('- compress');
    }

    public function clear()
    {
        $this->out('Clearing Cache');
        $this->removeAndCreateFolder(ROOT . DS . 'tmp'. DS . 'cache' . DS . 'models');
        $this->removeAndCreateFolder(ROOT . DS . 'tmp'. DS . 'cache' . DS . 'persistent');
        $this->removeAndCreateFolder(ROOT . DS . 'tmp'. DS . 'cache' . DS . 'views');
        $this->out('Cleared Cache');
    }

    private function removeAndCreateFolder($path)
    {
        $dir = new Folder($path);
        $dir->delete();
        $dir->create($path);
        $file = new File($path . DS . 'empty');
        $file->create();
    }

}