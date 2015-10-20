<?php
/**
 * File for class PostList
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
 * This class is used to get all posts and list them
 *
 * @author Adian Berger <adrian.berger2112@gmail.com>
 * @since 0.0.1
 * @version 1.0.0
 **/

class PostList
{
    /**
     * get the overview over all posts
     * @author Adrian Berger <adrian.berger2112@gmail.com>
     * @version 1.0.0
     * @access public
     * @param $database MySQLI Connection
     * @param $template Twig Template
     * @return $content Twig Template File
     */
    public function getList($database, $template)
    {
        $query = 'SELECT `id`, `title`, `content`, `user_id`, `date` FROM `post` ORDER BY `date` DESC;';
        $result = $database->executeQuery($query);
        while ($row = $result->fetch_assoc()) {
            $fetchedResult[] = $row;
        }
        $content = "";
        foreach($fetchedResult as $postData){
            $post = new \Model\Post($postData['id'],$postData['title'],$postData['content'], $postData['user_id'], $postData['date']);
            $content .= $post->getOutput($database, $template);
        }
        return $content;
    }

}