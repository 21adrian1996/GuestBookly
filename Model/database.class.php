<?php
/**
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @copyright Adrian Berger <adrian.berger2112@gmail.com>
 * @link https://bitbucket.org/SuperSuperAdrian/simplybook
 * @package guestbook
 * @return MYSQLI Connection
 * @since 0.0.1
 * @version 0.0.1
 **/

namespace Model;

class Database extends \mysqli{

    public function __construct(){
        return $this->createConnection();
    }
    private function createConnection(){
        $yamlController = new \Model\Yaml("Controller/config/settings.yml");
        $settings = $yamlController->parseYAML();
        $connection = parent::__construct($settings['database']['host'], $settings['database']['user'], $settings['database']['password'], $settings['database']['name']);
        if(mysqli_connect_errno()){
            echo mysqli_connect_error();
            die();
        }else{
            return $connection;
        }
    }
    public function executeQuery($query){
        return $this->query($query);
    }

}