<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/17/2019
 * Time: 12:29 PM
 */

include_once('User.php');

class UserManager extends CI_Model
{

    private $message = "";
    public $user_obj = array();

    public function __construct()
    {
        $this->load->database();
    }

    public function registerUser($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $userData = new User();
        $userData->createUser($username, $hashedPassword);
        $result = $this->db->insert('users', $userData);
    }

    public function loginUser($username, $password)
    {
        $this->db->where('username', $username);
        $result = $this->db->get('users');
        if ($result->num_rows() == 1) {
            $dbPassword = $result->row(0)->password;
            if (password_verify($password, $dbPassword)) {
                return array($result->row(0)->username, $result->row(0)->userId);
            }
        } else {
            return NULL;
        }
    }

    public function createProfile($formProfileName, $formAvatarUrl, $formGenres, $formEmail)
    {
        $userId = $this->session->userData[1];
        $this->db->where('userId', $userId);
        $result = $this->db->get('users');
        if ($result->num_rows() == 1) {
            $userObjArray = $result->custom_result_object('User');
            $userObj = $userObjArray[0];
            $userObj->updateProfileData($formProfileName, $formAvatarUrl, $formGenres, $formEmail);
            $this->db->where('userId', $userId);
            $this->db->update('users', $userObj);
        }
    }

    public function getProfileData($userId) {
        $this->db->where('userId', $userId);
        $result = $this->db->get('users');
        if ($result->num_rows() == 1) {
            return $result->custom_result_object('User');
        }
    }

    private function resultsFollowUser($results)
    {
        $userId = $this->session->userData[1];
        $relations = array();
        foreach ($results as $result)
        {
            $resultId = $result->getUserId();
            $followings = $result->getFollowingId();
            $followings = explode(",", $followings);

            array_pop($followings);
            $found = false;
            foreach ($followings as $followee)
            {
                if ($followee == $userId)
                {
                    //$follower->$relation = "follower";
//                    $x = array(
//                        "followerId" => $resultId,
//                        "relation" => "follower"
//                    );
                    array_push($relations, $resultId);
                }
            }

//            if (!$found) {
//                $x = array(
//                    "followerId" => $resultId,
//                    "relation" => "non-follower"
//                );
//                array_push($relations, $x);
//            }

            return $relations;
        }
    }

    public function searchUsers($selectedGenre) {
        $userId = $this->session->userData[1];
        if($selectedGenre!==null){
            $this->db->trans_start();
            $this->db->like('likedGenres', $selectedGenre);
            $this->db->where_not_in('userId', $userId);
            $result = $this->db->get('users');

            if($result->num_rows() > 0) {
                $finalResult = $result->custom_result_object('User');
                // Get user's followers
//                $this->db->select('*');
//                $this->db->where('userId', $userId);
//                $resulty = $this->db->get('users');
//
//                $currentUser = $resulty->custom_result_object('User');

//                print_r($resulty);
                $this->db->trans_complete();

//                print_r($result);
//                print_r($result[0]->getUserId());

                $relations = $this->resultsFollowUser($finalResult);

                return array(
                    "result" => $finalResult,
                    "relations" => $relations
                );
            }


//            if($result->num_rows() > 0) {
//                return $result->custom_result_object('User');
//            }
        }
    }

    public function userAction($actionType, $foundUserId) {

        $userId = $this->session->userData[1];

        if($actionType !== null && $foundUserId !== null) {

            if($actionType === 'followUser') {
                $this->db->trans_start();
                $this->db->where('userId', $userId);
                $resultFollower = $this->db->get('users');
                if ($resultFollower->num_rows() == 1) {
                    $userObjArray = $resultFollower->custom_result_object('User');
                    $userObj = $userObjArray[0];

                    // TODO use getFollowingID to fetch previously stored ids
                    $userObj->setFollowingId($foundUserId . ',');
                    $this->db->where('userId', $userId);
                    $this->db->update('users', $userObj);
                }

                $this->db->where('userId', $foundUserId);
                $resultFollowing = $this->db->get('users');
                if ($resultFollowing->num_rows() == 1) {
                    $userObjArray = $resultFollowing->custom_result_object('User');
                    $userObj = $userObjArray[0];
                    $userObj->setFollowersId($userId . ',');
                    $this->db->where('userId', $foundUserId);
                    $this->db->update('users', $userObj);
                }
                $this->db->trans_complete();

            } elseif ($actionType === 'unfollowUser') {
                $this->db->trans_start();
                $this->db->where('userId', $userId);
                $resultFollower = $this->db->get('users');
                if ($resultFollower->num_rows() == 1) {
                    $userObjArray = $resultFollower->custom_result_object('User');
                    $userObj = $userObjArray[0];
                    $userObj->setFollowingId($foundUserId . ',');
                    $this->db->where('userId', $userId);
                    $this->db->update('users', $userObj);
                }

                $this->db->where('userId', $foundUserId);
                $resultFollowing = $this->db->get('users');
                if ($resultFollowing->num_rows() == 1) {
                    $userObjArray = $resultFollowing->custom_result_object('User');
                    $userObj = $userObjArray[0];
                    $userObj->setFollowersId($userId . ',');
                    $this->db->where('userId', $foundUserId);
                    $this->db->update('users', $userObj);
                }
                $this->db->trans_complete();
            }
        }
    }


}