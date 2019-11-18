<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/18/2019
 * Time: 11:11 AM
 */

include "Post.php";

class PostManager extends CI_Model {

    public $postObj = array();

    /**
     * PostManager constructor.
     */
    public function __construct() {
        $this->load->database();
    }

    public function createPost($postContent, $userId) {
        $dateTime = date("Y-m-d H:i:s");
        $newPost = new Post();
        $newPost->createPost($postContent, $dateTime, $userId);
        $this->db->insert('posts', $newPost);
    }

    public function retrievePosts($userId) {
        $this->db->where('userId', $userId);
        $this->db->order_by('dateTime', 'desc');
        $result = $this->db->get('posts');

        if($result->num_rows() > 0) {
            return $result->custom_result_object('Post');
        }
    }


}