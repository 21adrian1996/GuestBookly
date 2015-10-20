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
        $connection = parent::__construct('host', 'user', 'pw', 'db');
        if(mysqli_connect_errno()){
            echo mysqli_connect_error();
            die();
        }else{
            return $connection;
        }
    }

}