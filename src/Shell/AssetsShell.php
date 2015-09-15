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
        $files = $this->getConfig();
        if($this->validateConfig($files)){
            $myfile = fopen(ROOT . DS . 'webroot' . DS . 'css' . DS . $files['css']['target'], "w");
            foreach($files['css']['files'] as $file) {
                $path = ROOT . DS . 'webroot' . DS . 'css' . DS . $file;
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
            $myfile = fopen(ROOT . DS . 'webroot' . DS . 'js' . DS . $files['js']['target'], "w");
            foreach($files['js']['files'] as $file) {
                $path = ROOT . DS . 'webroot' . DS . 'js' . DS . $file;
                $this->out($path);
                if(file_exists($path)) {
                    $data = file_get_contents($path);
                    $data = $this->compressJs($data);
                    fwrite($myfile, $data);
                } else {
                    $this->out('Could not find file: ' . $file);
                }
            }
            fclose($myfile);
            $this->out('compressed files');
        }
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

            if($key != 'css' && $key != 'js') {
                $errors = true;
                $this->out('Wrong asset type defined: ' . $key);
            }

            if(!isset($val['target'])) {
                $errors = true;
                $this->out('No target file defined');
            }

            if(!isset($val['files'])) {
                $errors = true;
                $this->out('No files to compress defined');
            }
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