<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/18/2019
 * Time: 11:11 AM
 */

//include_once('Post.php');

class PostManager extends CI_Model {

    /**
     * PostManager constructor.
     * Loaded the DB connection module to do DB functions.
     */
    public function __construct() {
        $this->load->database();
    }

    /**
     * @param $postContent
     * @param $userId
     *
     * Creating a post using both the content and user ID.
     */
    public function createPost($postContent, $userId) {
        $dateTime = date("Y-m-d H:i:s");
        $newPost = new Post();
        $newPost->createPost($postContent, $dateTime, $userId);
        $this->db->insert('post', $newPost);
    }

    /**
     * @param $userId
     * @return mixed
     *
     * retrieving selected user's post.
     */
    public function retrievePosts($userId) {
        $this->db->where('userId', $userId);
        $this->db->order_by('dateTime', 'desc');
        $result = $this->db->get('post');

        if($result->num_rows() > 0) {
            return $result->custom_result_object('Post');
        }
    }


    /**
     * @param $postId
     * @return mixed
     *
     * Method to edit selected post.
     */
    public function editSelectedPost($postId) {
        $this->db->where('postId', $postId);
        $result = $this->db->get('post');

             if($result->num_rows() > 0) {
                 return $result->custom_result_object('Post');
             }
    }


    /**
     * @param $postId
     * @param $postContent
     *
     * Method to edit/update post.
     */
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


    /**
     * @param $postId
     *
     * Method to delete selected post using post ID.
     */
    public function deleteSelectedPost($postId) {
        $this->db->where('postId', $postId);
        $this->db->delete('post');
    }


    /**
     * @param $userId
     * @return array|null
     *
     * Method to populate timeline posts by combining user's own posts and follower's post and then merging them on to an array
     * and then reordering them in descending time order.
     */
    public function getTimelinePosts($userId) {

        $userPosts = array();
        $otherPosts = array();
        $this->db->select('post.postId, post.postContent, user.userId, user.avatarUrl, user.profileName, user.username, post.dateTime');
        $this->db->from('post');
        $this->db->join('user', 'user.userId = post.userId');
        $this->db->where('user.userId', $userId);
        $this->db->order_by('post.dateTime', 'desc');
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $userPosts = $result->result();
        }


        $this->db->select('post.postId, post.postContent, user.userId, user.avatarUrl, user.profileName, user.username, post.dateTime');
        $this->db->from('post');
        $this->db->join('connection', 'post.userId = connection.followingUserId');
        $this->db->join('user', 'connection.followingUserId = user.userId');
        $this->db->where("connection.currentUserId = $userId");
        $this->db->order_by('post.dateTime', 'desc');
        $timelineResult = $this->db->get();

        if($timelineResult->num_rows() > 0){
            $otherPosts = $timelineResult->result();
        }

        if(count($userPosts)!=0 AND count($otherPosts)!=0) {
            $allPosts = array_merge($userPosts, $otherPosts);

            usort($allPosts, function($a, $b) {
                return strtotime($b->dateTime) - strtotime($a->dateTime);
            });

            return $allPosts;
        }elseif(count($userPosts)!=0 AND count($otherPosts)==0){
            return $userPosts;
        }elseif(count($userPosts)==0 AND count($otherPosts)!=0){
            return $otherPosts;
        }else {
            return null;
        }


    }

    /**
     * @param $postId
     * @return string
     *
     * Validation to prevent unauthorized post deletion.
     */
    public function getPostOwnerId($postId) {
        $this->db->select('userId');
        $this->db->where('postId', $postId);
        $ownerResult = $this->db->get('post');

        if ($ownerResult->num_rows() > 0) {
            return $ownerResult->row(0)->userId;
        } else {
            return 'Error';
        }

    }

}