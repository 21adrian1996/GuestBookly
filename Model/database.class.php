<?php
/**
 * This file is used for the class Database
 *
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @copyright Adrian Berger <adrian.berger2112@gmail.com>
 * @link https://bitbucket.org/SuperSuperAdrian/simplybook
 * @return MYSQLI Connection
 * @since 0.0.1
 * @version 1.0.0
 **/

namespace Model;

/**
 * This class is used as database connection. It extends from mysqli
 * We can execute and fetch querys here
 *
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @since 0.0.1
 * @version 1.0.0
 **/
class Database extends \mysqli{

    /**
     * constructor for the database connection
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return MySQLY Connection
     */
    public function __construct(){
        return $this->createConnection();
    }

    /**
     * create a mysqli connection using login info out of Controller/config/settings.yml
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access private
     * @return $connection MySQLY Connection
     */
    private function createConnection(){

        // get login data out of setting.yml, and parse over our own YAML Class. We need our own yaml parser,
        // because yml is not incleded in standard xampp server
        $yamlController = new \Model\Yaml("Controller/config/settings.yml");
        $settings = $yamlController->parseYAML();

        $connection = parent::__construct(
            $settings['database']['host'],
            $settings['database']['user'],
            $settings['database']['password'],
            $settings['database']['name']
        );
        if(mysqli_connect_errno()){
            echo mysqli_connect_error();
            die();
        }else{
            return $connection;
        }
    }

    /**
     * execute a MySQL query and return the result
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param  MySQL-Query $query
     * @return executed result MySQLI Result
     */
    public function executeQuery($query){
        return $this->query($query);
    }

}