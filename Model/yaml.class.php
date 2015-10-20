<?php
/**
 * This file is used for class Yaml
 *
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @copyright Adrian Berger <adrian.berger2112@gmail.com>
 * @link https://bitbucket.org/SuperSuperAdrian/simplybook
 * @return yaml settings
 * @since 0.0.1
 * @version 1.0.0
 **/

namespace Model;

/**
 * This class is used to read yaml files
 *
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @since 0.0.1
 * @version 1.0.0
 **/
class Yaml{

    /**
     * @var string path to file
     */
    private $file;

    /**
     * constructor for the yaml class
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param $file file to parse
     * @return void
     */
    public function __construct($file){
        $this->file = $file;
    }

    /**
     * parse a yml file, so we can get the data out of it
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return yaml settings
     */
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
