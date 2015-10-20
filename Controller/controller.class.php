<?php
/**
 * This file is used for teh class Controller
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
 * This class is the main Controller of the System. It handles all requests
 *
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @since 0.0.1
 * @version 1.0.0
 **/
class Controller
{

    /**
     * constructor for the main controller
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return void
     */
    public function __construct(){
        $this->loadSystem();
    }

    /**
     * get all classes, the database connection and the twig template. After that,
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access private
     * @return void (outputs html from twig)
     */
    private function loadSystem(){

        // load all classes over classloder, so we have a overview of used classes
        require_once('classloader.class.php');
        new Classloader();

        // load the database connection where we output our mysql querys
        $database = new \Model\Database();

        // load twig template framework - see http://twig.sensiolabs.org
        $loader = new \Twig_Loader_Filesystem('View/vendor/theme/guestbook');
        $template = new \Twig_Environment($loader);

        // our TemplateIndexFile is index.html, there are the header and footer, the rest will be loaded from $content
        $templateIndex = $template->loadTemplate('index.html');

        $handler = new \Controller\routeHandle();
        $content = $handler->doHandle($database, $template);

        // we have to different navigations for users and visitors without account,
        // because you should not be able to add entries if you have no account
        if (isset($_SESSION['userName'])) {
            $nav = file_get_contents('View/vendor/theme/guestbook/nav.html');
        }else{
            $nav = file_get_contents('View/vendor/theme/guestbook/nav_unregisterd.html');
        }

        echo $templateIndex->render(array(
            'CONTENT' => $content,
            'NAVIGATION' => $nav
        ));

    }


}