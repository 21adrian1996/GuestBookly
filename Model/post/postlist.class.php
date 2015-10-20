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
        $query = 'SELECT `id`, `titel`, `content`, `user_id`, `date` FROM `post` ORDER BY `date` DESC;';
        $result = $database->executeQuery($query);
        while ($row = $result->fetch_assoc()) {
            $fetchedResult[] = $row;
        }
        $content = "";
        foreach($fetchedResult as $postData){
            $post = new \Model\Post($postData['id'],$postData['titel'],$postData['content'], $postData['user_id'], $postData['date']);
            $content .= $post->getOutput($database, $template);
        }
        return $content;
    }

}