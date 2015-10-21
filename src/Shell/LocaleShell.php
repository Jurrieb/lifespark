<?php
namespace App\Shell;

use Cake\Console\Shell;

class LocaleShell extends Shell
{

    public function main()
    {
        $this->out('Commands');
        $this->out('- build');
    }

    public function build()
    {
        $config = $this->readConfig('Locales.json');

        $files = [];
        foreach($config['directories'] as $directory) {
           $files = array_merge($this->loopDir(ROOT . DS . $directory), $files);
        }

        $locales = [];
        foreach($files as $file) {
            $locales = array_merge_recursive($this->findLocales($file), $locales);
        }

        $this->writeFiles($locales, $config['locale_directories']);
    }

    private function loopDir($directory) {
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        $files = [];
        foreach($scanned_directory as $file) {
            if(!is_dir($directory . DS . $file)) {
                $files[] = $directory . DS . $file;
            } else {
                $files = $this->loopDir($directory . DS . $file) + $files;
            }
        }
        return $files;
    }


    private function findLocales($path)
    {
        $content = file_get_contents($path);

        preg_match_all("/\__d\(\'(.*?)'\,\s*\'(.*?)\'\)/", $content, $matches);
        $potags = [];

        foreach($matches[1] as $key => $val) {
            $potags[$val][] =  "msgid \"". $matches[2][$key] . "\"\r\nmsgstr \"\"\r\n\r\n";
        }
        return $potags;
    }

    private function writeFiles($locales, $localedirs)
    {
        foreach($localedirs as $localedir) {
            foreach(array_unique($locales, SORT_REGULAR) as $file => $locale) {
                $locale = array_unique($locale);
                file_put_contents(ROOT . DS . 'src' . DS . 'Locale' . DS . $localedir . DS . $file. '.po', implode($locale));
            }
        }
    }

    private function readConfig($file) {
        $json = file_get_contents(ROOT . DS . 'config' . DS . $file);
        $config = json_decode($json, true);
        return $config;
    }

}