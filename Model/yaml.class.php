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
                $yamlData = explode(':', str_replace(array("\r", "\n", ' '), '', $line));
                if(empty($yamlData[1])){
                    $section = $yamlData[0];
                }else if($yamlData[1] == 'notset') {
                    $yml[$section][$yamlData[0]] = '';
                }else{
                    $yml[$section][$yamlData[0]] = $yamlData[1];
                }
            }
            fclose($handle);
        }
        return $yml;
    }

}
