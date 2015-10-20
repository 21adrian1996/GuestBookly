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

    public function __construct(){
        return $this->getSettings();
    }
    private function getSettings(){
        $handle = fopen("../Controller/config/settings.yml", "r");
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
