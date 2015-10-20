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
        require_once('classloader.class.php');
        new Classloader();
        $database = new \Model\Database();
        $this->loadSystem($database);
    }

    private function loadSystem($database){
        $cmd = new routeHandle();
        var_dump($cmd);
        $loader = new \Twig_Loader_Filesystem('View/vendor/theme/guestbook');
        $this->template = new \Twig_Environment($loader);

        // we need to start the session, because we check userLogin over the session
        session_start();

        // our TemplateIndexFile is index.html, there are the header and footer, the rest will be loaded from $content
        $template = $this->template->loadTemplate('index.html');
        $content = $this->cmdSwitch($database, $this->template);
        echo $template->render(array('CONTENT' => $content));

    }
    public function cmdSwitch($database, $template)
    {

        switch ($_GET['cmd']) {
            case 'json':
                include_once 'controller/json.class.php';
                $JSON = new \Controller\JsonController();
                $JSON->getData($database);
                die();
                break;
            case 'logout':
                // The complete login is done over the session, so we destroy the complete session to logout the user
                session_unset();
                session_destroy();
                header('Location: ?cmd=login');
                break;
            case 'login':
                $loginContent = $template->loadTemplate('login.html');

                // if submit is set, the user wants to login, so we try if he can or not
                if (isset($_POST['submit'])) {
                    $user = new \Model\User('', $_POST['username'], '', '', $_POST['password'], '');

                    /* If the login data from the user are correct, we send him to survey, so he can answer the questions
                    if not, we tell him the data are wrong. We don't tell him what is wrong, because it will be
                    easier for hackers to find out correct data */
                    if ($user->checkLogin($database)) {
                        $user->saveUserIsLoggedIn($database);
                        header('Location: ?cmd=overview');
                    } else {
                        $content = $loginContent->render(array('ERROR_MESSAGE' => 'Login Daten sind falsch', "USERNAME" => $user->getName()));
                    }
                }
                // if submit isn't set, we render the empty template, so the user can tip in the data and submit the form
                else {
                    $content = $loginContent->render(array());
                }

                break;
            case 'register':
                $registerContent = $template->loadTemplate('register.html');

                // if submit is set, the user tries to register, so we check if we can register him or not
                if (isset($_POST['submit'])) {
                    $user = new \Model\User('', $_POST['username'], $_POST['firstname'], $_POST['lastname'], $_POST['password'],$_POST['email']);

                    // we check the data again, for users which have turned of javascript in browser
                    $errorData = $user->checkregisterData($database);

                    // if all data are correct, we save the new user and send him to survey, so he can answer the questions
                    if ($errorData == "") {
                        $user->save($database);
                        $user->saveUserIsLoggedIn($database);
                        header('Location: ?cmd=survey');
                    }

                    // if there is a problem with the data, we tell this to the user and refill the form with his data
                    else {
                        $content = $registerContent->render(array(
                            'ERROR_MESSAGE' => $errorData,
                            'USERNAME' => $user->getName(),
                            'FIRSTNAME' => $user->getFirstname(),
                            'LASTNAME' => $user->getLastname(),
                            'E_MAIL' => $user->getEmail(),
                        ));
                    }
                }
                // if submit isn't set, we render the empty template, so the user can tip in the data and submit the form
                else {
                    $content = $registerContent->render(array());
                }
                break;
        }
        return $content;
    }

}