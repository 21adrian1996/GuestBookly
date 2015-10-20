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
    private $params;
    public function __construct(){
        return $this->getParams();
    }
    public function getParams(){
        $this->params = Array('post' => $_POST, 'get' => $_GET);
        foreach($this->params as $key => $value){
            foreach($value as $key2 => $value){
                $key = INPUT_POST;
                $this->params[$key][$key2] = filter_input(($key == post ? INPUT_POST : INPUT_GET), $key2);
            }
        }

        return $this->params;
    }

    public function doHandel(){

    }
}