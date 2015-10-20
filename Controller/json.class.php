<?php

/**
 * Json Controller Class
 *
 * @package    SimplyPartners
 * @author     Adrian Berger <adrian.berger2112@gmail.com>
 * @copyright  2014 Adrian Berger
 * @version    1.0.0
 */

namespace Controller;

class JsonController
{
    /**
     * return data to ajax
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @param $database PDO Object
     * @access public
     * @return json Data
     */
    public function getData($database){

        // checkuserexists = user tried to register and we tell him if the user is available or not, so he can can it
        // if its already in use

        if($_POST['act'] == 'checkuserexists'){

            $user = new \Model\User('','','','','','');

            $userExists = $user->checkUserExists($database, $_POST['user']);

            echo json_encode(array("value" => $userExists));
        }
   }
}