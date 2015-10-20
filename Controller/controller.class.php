<?php
/**
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @copyright Adrian Berger <adrian.berger2112@gmail.com>
 * @link https://bitbucket.org/SuperSuperAdrian/simplybook
 * @package guestbook
 * @return empty
 * @since 0.0.1
 * @version 0.0.1
 **/

namespace Controller;

class Controller{

    public function __construct(){
        $this->loadClasses();
        $this->getDatabaseConnection();
        $this->loadSystem();
    }
    private function loadClasses(){
        require_once('classloader.class.php');
        $classLoader = new Classloader();
        $classLoader->loadClasses();
    }
    private function getDatabaseConnection(){

    }
    private function loadSystem(){
       
    }

}