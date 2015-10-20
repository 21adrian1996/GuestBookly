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

class routeHandle{
    protected $cmd;

    public function __construct(){
        $this->findRoute();
    }

    private function findRoute()
    {
        if (!isset($_GET['cmd'])) {
            // if user is not logged in, we send hem to register page, so he can register or go to login from there
            // else we send him to the survey so he can answer the questions or see the evaluation
            if (!isset($_SESSION['userName'])) {
                $this->cmd = 'register';
            } else {
                $this->cmd = 'overview';
            }
        } elseif (!isset($_SESSION['userName']) && $_GET['cmd'] != 'login') {
            $this->cmd = 'register';
        } else {
            $this->cmd = $_GET['cmd'];
        }

        // if we need to send data over json, the cmd in POST must be json, so we can go to json handler
        if(isset($_POST['cmd']) && $_POST['cmd'] == 'json'){
            $this->cmd = 'json';
        }
    }

    public function doHandle($database, $template){
        switch ($this->cmd) {
            case 'json':
                require_once 'Controller/json.class.php';
                $JSON = new \Controller\JsonController();
                $JSON->getData($database);
                die();
                break;
            case 'logout':
                // The complete login is done over the session, so we destroy the complete session to logout the user
                session_unset();
                session_destroy();
                header('Location: ?cmd=login');
                die();
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
            case 'passwordChange':
                if(isset($_POST['submit'])){
                    $user = new \Model\User($_SESSION['userId'], '', '', '', $_POST['password'], '');
                    $user->changePassword($database);
                }
                $model = $template->loadTemplate('changePassword.html');
                $content = $model->render(Array());
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
            case 'overview':
                if(isset($_GET['act'])){
                    switch($_GET['act']){
                        case 'edit':
                            $post = new \Model\Post($_GET['id'],'', '', '', '');
                            $post->getById($database);
                            if($post->getUserId() == $_SESSION['userId']) {
                                if(isset($_POST['submit'])){
                                    if(isset($_POST['title']) && isset($_POST['content'])){
                                        $post->setContent($_POST['content']);
                                        $post->setTitle($_POST['title']);
                                        $post->update($database);
                                        header('Location: ?cmd=overview');
                                        die();
                                    }
                                }else{
                                    $model = $template->loadTemplate('modifyPost.html');
                                    $content = $model->render(array(
                                        'HEADING' => 'Eintrag bearbeiten',
                                        'TITLE' => $post->getTitle(),
                                        'POSTCONTENT' => $post->getContent(),
                                        'ACT' => 'edit&id='.$post->getId()
                                    ));
                                }
                            }else{
                                header('Location: ?cmd=overview');
                                die();
                            }

                            break;
                        case 'delete':
                            $post = new \Model\Post($_GET['id'],'', '', '', '');
                            $post->getById($database);
                            if($post->getUserId() == $_SESSION['userId']) {
                                $post->delete($database);
                            }
                            header('Location: ?cmd=overview');
                            die();
                            break;
                        case 'add':
                            if(isset($_POST['submit'])){
                                if(isset($_POST['title']) && isset($_POST['content'])){
                                    $post = new \Model\Post('',$_POST['title'], $_POST['content'], $_SESSION['userId'], time());
                                    $post->save($database);
                                }
                            }
                            $model = $template->loadTemplate('modifyPost.html');
                            $content = $model->render(array(
                                'HEADING' => 'Neuer Eintrag',
                                'ACT' => 'add'
                            ));
                            default:
                            break;
                    }
                }else{
                    $list = new \Model\PostList($database, $template);
                    $content = $list->getList($database, $template);
                   // $content = 'overview';
                }
                break;
            default:
                $content = 'You found a dead link';
                break;
        }
        return $content;
    }
}