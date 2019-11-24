<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/18/2019
 * Time: 11:11 AM
 */

include_once('Post.php');

class PostManager extends CI_Model {

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
        $this->db->insert('post', $newPost);
    }


    public function retrievePosts($userId) {
        $this->db->where('userId', $userId);
        $this->db->order_by('dateTime', 'desc');
        $result = $this->db->get('post');

        if($result->num_rows() > 0) {
            return $result->custom_result_object('Post');
        }
    }


    public function editSelectedPost($postId) {
        $this->db->where('postId', $postId);
        $result = $this->db->get('post');

             if($result->num_rows() > 0) {
                 return $result->custom_result_object('Post');
             }
    }


    public function updateSelectedPost($postId, $postContent) {
        $this->db->where('postId', $postId);
        $result = $this->db->get('post');

        if($result->num_rows() > 0) {
            $postObjArray = $result->custom_result_object('Post');
            $postObj = $postObjArray[0];
            $postObj->updatePostData($postContent);
            $this->db->where('postId', $postId);
            $this->db->update('post', $postObj);
        }
    }


    public function deleteSelectedPost($postId) {
        $this->db->where('postId', $postId);
        $this->db->delete('post');
    }


    public function getTimelinePosts($userId) {
        $this->db->select('post.postId');
        $this->db->select('post.postContent');
        $this->db->select('user.userId');
        $this->db->select('user.avatarUrl');
        $this->db->select('user.profileName');
        $this->db->select('user.username');
        $this->db->from('post');
        $this->db->join('connection', 'post.userId = connection.followingUserId');
        $this->db->join('user', 'connection.followingUserId = user.userId');
        $this->db->where("connection.currentUserId = $userId OR post.userId = $userId");
        $this->db->order_by('post.dateTime', 'desc');
        $timelineResult = $this->db->get();

        if ($timelineResult->num_rows() > 0) {
            return $timelineResult->result();
        }
    }

}