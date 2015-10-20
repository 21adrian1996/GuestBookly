<?php
/**
 * This file is used for the class Classloader
 *
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @copyright Adrian Berger <adrian.berger2112@gmail.com>
 * @link https://bitbucket.org/SuperSuperAdrian/simplybook
 * @return empty
 * @since 0.0.1
 * @version 1.0.0
 **/

namespace Controller;

/**
 * This class loads all requiered classes
 *
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @since 0.0.1
 * @version 1.0.0
 **/

class Classloader{

    /**
     * constructor for the classloader
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return void
     */
    public function __construct(){
        $this->loadClasses();
    }

    /**
     * loads all classes. At the moment its statical, later maybe it will be dynamical
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return void
     */
    public function loadClasses(){
        require_once('Controller/routeHandler.class.php');
        require_once('Model/database.class.php');
        require_once('Model/yaml.class.php');
        require_once('Model/user/user.class.php');
        require_once('Model/post/post.class.php');
        require_once('Model/post/postlist.class.php');
        require_once('View/vendor/autoload.php');
    }

}