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
    protected $template;

    public function __construct(){
        require_once('classloader.class.php');
        new Classloader();
        $database = new \Model\Database();
        $this->loadSystem($database);
    }

    private function loadSystem($database){
        $loader = new \Twig_Loader_Filesystem('View/vendor/theme/guestbook');
        $this->template = new \Twig_Environment($loader);

        // we need to start the session, because we check userLogin over the session
        session_start();

        // our TemplateIndexFile is index.html, there are the header and footer, the rest will be loaded from $content
        $template = $this->template->loadTemplate('index.html');
        $handler = new \Controller\routeHandle();
        $content = $handler->doHandle($database, $this->template);
        if (isset($_SESSION['userName'])) {
            $nav = file_get_contents('View/vendor/theme/guestbook/nav.html');
        }else{
            $nav = file_get_contents('View/vendor/theme/guestbook/nav_unregisterd.html');
        }
        echo $template->render(array('CONTENT' => $content, 'NAVIGATION' => $nav));

    }


}