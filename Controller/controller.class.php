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


class Controller
{

    public function __construct(){
        $this->loadClasses();
        $database = $this->getDatabaseConnection();
        $this->loadSystem($database);
    }
    private function loadClasses(){
        require_once('classloader.class.php');
        new Classloader();
    }
    private function getDatabaseConnection(){
        return new \Model\Database();
    }
    private function loadSystem($database){
        $loader = new \Twig_Loader_Filesystem('View/vendor/theme/guestbook');
        $this->template = new \Twig_Environment($loader);

        // we need to start the session, because we check userLogin over the session
        session_start();


        // our TemplateIndexFile is index.html, there are the header and footer, the rest will be loaded from $content
        $template = $this->template->loadTemplate('index.html');

        echo $template->render(array('CONTENT' => file_get_contents('View/vendor/theme/guestbook/login.html')));
    }

}