<?php
/**
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @copyright Adrian Berger <adrian.berger2112@gmail.com>
 * @link https://bitbucket.org/SuperSuperAdrian/simplybook
 * @package guestbook
 * @return yaml settings
 * @since 0.0.1
 * @version 0.0.1
 **/

namespace Model;

class Yaml{
    private $file;

    public function __construct($file){
        $this->file = $file;
    }
    public function parseYAML(){
        $handle = fopen($this->file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $configData = explode(':', str_replace(array("\r", "\n", ' '), '', $line));
                if(empty($configData[1])){
                    $section = $configData[0];
                }else{
                    $config[$section][$configData[0]] = $configData[1];
                }
            }
            fclose($handle);
        }
        return $config;
    }

}
