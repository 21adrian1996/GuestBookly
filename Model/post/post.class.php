<?php
/**
 * This is the file for the class post
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
 * This class is used for all guestbook entries. We save, edit and delete them here.
 *
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @since 0.0.1
 * @version 1.0.0
 **/
class Post
{
    /**
     * @var integer id of post
     */
    protected $id;

    /**
     * @var string title of post
     */
    protected $title;

    /**
     * @var string content of post
     */
    protected $content;

    /**
     * @var integer id of user which is creator of the post
     */
    protected $user_id;

    /**
     * @var integer time when post last changed
     */
    protected $date;

    /**
     * constructor for the post class
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param $id int
     * @param $title string
     * @param $content string
     * @param $user_id integer
     * @param $date integer
     * @return void
     */
    public function __construct($id, $title, $content, $user_id, $date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->date = $date;
    }

    /**
     * getter for id
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return integer $id
     */
    public function getId(){
        return $this->id;
    }

    /**
     * getter for title
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return string $title
     */
    public function getTitle(){
        return $this->title;
    }

    /**
     * getter for Content
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return string $content
     */
    public function getContent(){
        return $this->content;
    }

    /**
     * getter for userid
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @return integer $userId
     */
    public function getUserId(){
        return $this->user_id;
    }

    /**
     * setter for title
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param string $title
     */
    public function setTitle($title){
        $this->title = $title;
    }

    /**
     * setter for content
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param string $content
     */
    public function setContent($content){
        $this->content = $content;
    }

    /**
     * load post data over id
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param MySQLI-Object $database
     * @return void
     */
    public function getById($database){
        $query = 'SELECT * FROM `post` WHERE `id` = '.intval($this->id).';';
        $result = $database->executeQuery($query);
        $fetchedResult = $result->fetch_assoc();
        $this->title = $fetchedResult['title'];
        $this->content = $fetchedResult['content'];
        $this->user_id = $fetchedResult['user_id'];
        $this->date = $fetchedResult['date'];
    }

    /**
     * save a post in database
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param MySQLI-Object $database Database where we save the posts
     * @param $purifier HTMLPurifier Object
     * @return void
     */
    public function save($database, $purifier)
    {
        $query = 'INSERT INTO `post`(`title`,`content`,`user_id`, `date`)
                  VALUES(\'' .
                            $database->real_escape_string($this->title) . '\',\'' .
                            $database->real_escape_string($purifier->purify($this->content)) . '\',' .
                            $database->real_escape_string($this->user_id) . ', \''.
                            date('Y-m-d H:i:s',$this->date) .'\')';
        $database->executeQuery($query);
    }

    /**
     * update a post in database
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param MySQLI-Object $database Database where we update the posts
     * @param $purifier HTMLPurifier Object
     * @return void
     */
    public function update($database, $purifier)
    {
        $query = 'UPDATE `post`
                    SET `title` = "'.$database->real_escape_string($this->title).'",
                    `content` = "'.$database->real_escape_string($purifier->purify($this->content)).'"
                    WHERE `id` ='.intval($this->id);
        $database->executeQuery($query);
    }

    /**
     * delete a post in database
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param MySQLI-Object $database Database where we delete the posts
     * @return void
     */
    public function delete($database)
    {
        $query = 'DELETE FROM `post` WHERE `id` = '.intval($this->id).';';
        $database->executeQuery($query);
    }

    /**
     * create html output for one single post
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param MySQLI-Object $database Database where the posts are stored
     * @param $template Twig Object
     * @return Twig Object
     */
    public function getOutput($database, $template){
        $model = $template->loadTemplate('post.html');
        $user = new \Model\User($this->user_id, '', '', '', '', '', '');
        $action = '';
        if($this->user_id == $_SESSION['userId']){
            $action = '<a class=\'pull-right\' href=\'?cmd=overview&act=delete&id='.$this->id.'\'>
                           l&ouml;schen <i class="fa fa-times"></i>
                       </a>
                       <a class=\'pull-right editPost\' href=\'?cmd=overview&act=edit&id='.$this->id.'\'>
                           editieren <i class="fa fa-pencil-square-o"></i>
                       </a>';
        }
        return $model->render(array(
            'TITLE' => $this->title,
            'POSTCONTENT' => $this->content,
            'TIME' => date('H:i',strtotime($this->date)),
            'DATE' => date('d.m.Y',strtotime($this->date)),
            'USER' => $user->getNameById($database),
            'ACTION' => $action
        ));

    }

}