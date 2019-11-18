<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/18/2019
 * Time: 11:11 AM
 */

class Post {

    public $postContent;
    public $dateTime;
    public $userId;

    /**
     * Post constructor.
     * @param $postContent
     * @param $dateTime
     * @param $userId
     */
//    public function __construct($postContent, $dateTime, $userId)
//    {
//        $this->postContent = $postContent;
//        $this->dateTime = $dateTime;
//        $this->userId = $userId;
//    }

    public function createPost($postContent, $dateTime, $userId) {
        $this->postContent = $postContent;
        $this->dateTime = $dateTime;
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getPostContent()
    {

        $output = $this->postContent;

        $regex_images = '~https?://\S+?(?:png|gif|jpe?g)~';
        $regex_links = '~(?<!src=\')https?://\S+\b~';

        $output = preg_replace($regex_images, "<img src='\\0'>", $output);
        $output = preg_replace($regex_links, "<a href='\\0'>\\0</a>", $output);
//        echo $content;


        return $output;
    }




}