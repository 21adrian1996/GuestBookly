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

class PostList
{
    public function getList($database, $template)
    {
        $query = 'SELECT `id`, `titel`, `content`, `user_id`, `date` FROM `post`;';
        $result = $database->executeQuery($query);
        $fetchedResult = $result->fetch_all();
        $content = "";
        foreach($fetchedResult as $postData){
            $post = new \Model\Post($postData[0],$postData[1],$postData[2], $postData[3], $postData[4]);
            $content .= $post->getOutput($database, $template);
        }
        return $content;
    }

}