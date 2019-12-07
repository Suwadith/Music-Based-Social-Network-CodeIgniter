<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/18/2019
 * Time: 11:11 AM
 */

class Post extends CI_Model{

    public $postId;
    public $postContent;
    public $dateTime;
    public $userId;

    /**
     * @param $postContent
     * @param $dateTime
     * @param $userId
     *
     * Method to create a post.
     */
    public function createPost($postContent, $dateTime, $userId) {
        $this->postContent = $postContent;
        $this->dateTime = $dateTime;
        $this->userId = $userId;
    }

    /**
     * @return mixed
     *
     * Method to display images and urls in proper formats using regex
     */
    public function getPostContent() {

        $output = $this->postContent;

        $regex_images = '~https?://\S+?(?:png|gif|jpe?g)~';
        $regex_links = '~(?<!src=\')https?://\S+\b~';

        $output = preg_replace($regex_images, "<br> <img src='\\0'> <br>", $output);
        $output = preg_replace($regex_links, "<a href='\\0' target=\"_blank\">\\0</a>", $output);

        return $output;
    }


    public function getRawPostContent() {
        return $this->postContent;
    }

    /**
     * @return mixed
     */
    public function getPostId() {
        return $this->postId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }




    public function updatePostData($postContent) {
        $this->postContent = $postContent;
    }



}