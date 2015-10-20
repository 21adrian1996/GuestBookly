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

class Classloader{

    public function __construct(){
        return $this->loadClasses();
    }

    public function loadClasses(){
        require_once('Controller/routeHandler.class.php');
        require_once('Model/database.class.php');
        require_once('Model/yaml.class.php');
        require_once('Model/user/user.class.php');
        require_once('View/vendor/autoload.php');
    }

}