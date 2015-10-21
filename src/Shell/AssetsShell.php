<?php
namespace App\Shell;

use Cake\Console\Shell;

class AssetsShell extends Shell
{

    public function main()
    {
        $this->out('Commands');
        $this->out('- compress');
    }


    public function compress()
    {
        $this->out('loading config file');
        $config = $this->getConfig();
        if($this->validateConfig($config)){

            foreach($config as $type => $list) {
                foreach($list as $env){
                    $taget = $env['cache'];
                    $this->build($taget, $type, $env['files']);
                }
            }

            $this->out('compressed files');
        }
    }

    private function build($target, $type, $files)
    {
        $myfile = fopen(ROOT . DS . 'webroot' . DS . $type . DS . $target, "w");
        foreach($files as $file) {
            $path = ROOT . DS . 'webroot' . DS . $type . DS . $file;
            $this->out($path);
            if(file_exists($path)) {
                $data = file_get_contents($path);
                $data = $this->compressCss($data);
                fwrite($myfile, $data);
            } else {
                $this->out('Could not find file: ' . $file);
            }
        }
        fclose($myfile);
    }

    private function getConfig()
    {
        if(file_exists(ROOT . DS . 'config' . DS . 'assets.json')) {
            $json = file_get_contents(ROOT . DS . 'config' . DS . 'assets.json');
            $config = json_decode($json, true);
            if($this->validateConfig($config)) {
                return $config;
            }
        } else {
            $this->out('could not find asset config file');
        }
        return false;
    }

    private function validateConfig($config)
    {
        $errors = false;
        foreach($config as $key => $val){

        }
        if(!$errors){
            return true;
        }
        return false;
    }

    private function compressJs($data)
    {
        /* remove comments */
        $data = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $data);
        /* remove tabs, spaces, newlines, etc. */
        $data = str_replace(array("\r\n","\r","\t","\n",'  ','    ','     '), '', $data);
        /* remove other spaces before/after ) */
        $data = preg_replace(array('(( )+\))','(\)( )+)'), ')', $data);
        return $data;
    }

    private function compressCss($data)
    {
        $data = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $data);
        // Remove space after colons
        $data = str_replace(': ', ':', $data);
        // Remove whitespace
        $data = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $data);
        return $data;
    }

}