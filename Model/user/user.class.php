<?php
/**
 * File for class user
 * 
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @copyright Adrian Berger <adrian.berger2112@gmail.com>
 * @link https://bitbucket.org/SuperSuperAdrian/simplybook
 * @return empty
 * @since 0.0.1
 * @version 1.0.0
 **/

namespace Model;

/**
 * This class is used to hanlde user management
 *
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @since 0.0.1
 * @version 1.0.0
 **/

class User
{
    /**
     * @var int id of user
     */
    protected $id;

    /**
     * @var string firstname of user
     */
    protected $firstname;

    /**
     * @var string astname of user
     */
    protected $lastname;

    /**
     * @var string password
     */
    protected $password;

    /**
     * @var string email
     */
    protected $email;

    /**
     * @var string username
     */
    protected $name;

    /**
     * constructor for the user class
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param integer $id
     * @param string $name
     * @param string $firstname
     * @param string $lastname
     * @param string $password
     * @param string $email
     * @return void
     */
    public function __construct($id, $name, $firstname, $lastname, $password, $email)
    {
            isset($id) ? $this->id = $id : '';
            isset($name) ? $this->name = $name : '';
            isset($firstname) ? $this->firstname = $firstname : '';
            isset($lastname) ? $this->lastname = $lastname : '';
            isset($password) ? $this->password = $password : '';
            isset($email) ? $this->email = $email : '';
    }

    /**
     * getter for id
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * getter for name
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * getter for lastname
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * getter for firstname
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * getter for email
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * store a user into database
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param object $database
     * @return void
     */
    public function save($database)
    {
        $query = 'INSERT INTO `user`(`name`,`firstname`,`lastname`,`password`,`email`)
                  VALUES(\'' .
                            $database->real_escape_string($this->name) . '\',\'' .
                            $database->real_escape_string($this->firstname) . '\',\'' .
                            $database->real_escape_string($this->lastname) . '\',\'' .
                            hash("sha224", $this->password) . '\',\'' .
                            $database->real_escape_string($this->email) . '\'
                )';
        $database->executeQuery($query);
    }

    /**
     * check if a username already exists
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param object $database
     * @param $username String
     * @return bol
     */
    public function checkUserExists($database, $username)
    {
        $query = 'SELECT count(id) AS `count` FROM `user`
                    WHERE `name` = "' . $database->real_escape_string($username) . '";';
        $result = $database->executeQuery($query);
        $fetchedResult = $result->fetch_assoc();
        // if there is no count, the username don't exists in database, so we send back false
        if ($fetchedResult["count"] == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * check if the data from the registration form are ok
     *
     * only ckeck the most important things, because the check should be already done in javascript. We do this for
     * users which have turned javascript off, so we dont get empty data from them
     *
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param object $database
     * @return String with error message
     */
    public function checkregisterData($database)
    {
        $error_message = "";
        if (isset($this->name)) {

            // username must be 6 chars long, only contain alphanumeric chars and can only exist once
            if (strlen($this->name) != 6) {
                $error_message .= "- Benutzername muss genau 6 Zeichen lang sein ";
            } elseif (!ctype_alnum($this->name)) {
                $error_message .= "- Benutzername darf nur aus Buchstaben und Ziffern bestehen ";
            } elseif ($this->checkUserExists($database, $this->name)) {
                $error_message .= "Benutzername ist bereits vergeben ";
            }
        } else {
            $error_message .= "Benutzername muss gesetzt sein ";
        }

        // we only check if the rest is set, because the validation is done over javascript and if its turned off, its
        // not our problem, its the users problem and it is also his problem if his password is not strong
        if (!isset($this->firstname)) {
            $error_message .= "- Vorname muss gesetzt sein ";
        }
        if (!isset($this->lastname)) {
            $error_message .= "- Nachname muss gesetzt sein ";
        }
        if (!isset($this->password)) {
            $error_message .= "- Passwort muss gesetzt sein ";
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $error_message .= "- E-Mail Adresse ist ungültig ";
        }
        return $error_message;
    }

    /**
     * Create session for user, so we can check if he is logged in
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param object $database
     * @return void
     */
    public function saveUserIsLoggedIn($database)
    {
        $_SESSION['loggedIn'] = true;
        $_SESSION['userName'] = $this->name;
        $_SESSION['userId'] = $this->getIdByName($database);
    }

    /**
     * Check if username and password do match
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param object $database
     * @return true if user is logged in, false if not
     */
    public function checkLogin($database)
    {
        $query = 'SELECT count(id) as counted FROM `user`
                    WHERE `name` = "' . $database->real_escape_string($this->name) . '"
                    AND `password` ="' . hash("sha224", $this->password) . '";';
        $result = $database->executeQuery($query);
        $fetchedResult = $result->fetch_assoc();
        if ($fetchedResult["counted"] == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get the id of a user by his username
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param object $database
     * @return integer id
     */
    public function getIdByName($database)
    {
        $query = 'SELECT id FROM `user`
                    WHERE `name` = "' . $database->real_escape_string($this->name) . '";';
        $result = $database->executeQuery($query);
        $fetchedResult = $result->fetch_assoc();
        return $fetchedResult["id"];
    }

    /**
     * get then username by the id of ther user
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param object $database
     * @return string name
     */
    public function getNameById($database)
    {
        $query = 'SELECT `name` FROM `user`
                    WHERE `id` = "' . intval($this->id) . '";';
        $result = $database->executeQuery($query);
        $fetchedResult = $result->fetch_assoc();
        return $fetchedResult["name"];
    }

    /**
     * change the password for a user
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param object $database
     * @return void
     */
    public function changePassword($database){
        $query = 'UPDATE `user`
                  SET `password` = "' . hash("sha224", $this->password) . '"
                  WHERE `id` = '.intval($this->id).';';
        $database->executeQuery($query);
    }
}