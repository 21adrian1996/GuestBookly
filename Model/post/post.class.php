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

namespace Model;

class Post
{
    protected $id;
    protected $title;
    protected $content;
    protected $user_id;
    protected $date;

    public function __construct($id, $title, $content, $user_id, $date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->date = $date;
    }
    public function getId(){
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getContent(){
        return $this->content;
    }
    public function setTitle($title){
        $this->title = $title;
    }
    public function setContent($content){
        $this->content = $content;
    }
    public function getUserId(){
        return $this->user_id;
    }
    public function getById($database){
        $query = 'SELECT * FROM `post` WHERE `id` = '.$this->id.';';
        $result = $database->executeQuery($query);
        $fetchedResult = $result->fetch_assoc();
        $this->title = $fetchedResult['titel'];
        $this->content = $fetchedResult['content'];
        $this->user_id = $fetchedResult['user_id'];
        $this->date = $fetchedResult['date'];
    }
    public function save($database)
    {
        $query = 'INSERT INTO `post`(`titel`,`content`,`user_id`, `date`)
                  VALUES(\'' . $this->title . '\',\'' . $this->content . '\',' . $this->user_id . ', \''. date('Y-m-d H:i:s',$this->date) .'\')';
        $database->executeQuery($query);
    }
    public function update($database)
    {
        $query = 'UPDATE `post`
                    SET `titel` = "'.$this->title.'",
                    `content` = "'.$this->content.'"
                    WHERE `id` ='.$this->id;
        $database->executeQuery($query);
    }
    public function delete($database)
    {
        $query = 'DELETE FROM `post` WHERE `id` = '.$this->id.';';
        $database->executeQuery($query);
    }

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