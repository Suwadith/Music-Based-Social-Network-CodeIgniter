<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/17/2019
 * Time: 12:29 PM
 */

include_once('User.php');
include_once('Genre.php');
include_once('Connection.php');

class UserManager extends CI_Model
{

    private $message = "";
    public $user_obj = array();

    public function __construct()
    {
        $this->load->database();
    }

    public function registerUser($username, $password, $emailAddress)
    {

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $userData = new User();
            $userData->createUser($username, $hashedPassword, $emailAddress);
        $this->db->trans_start();
            $results = $this->db->insert('user', $userData);

            $this->db->where('username', $username);
            $result = $this->db->get('user');

            if ($result->num_rows() == 1) {

                $userId = $result->row(0)->userId;
//                print_r($userId);
                $genreData = new Genre();
                $genreData->setGenres($userId, NULL);
                $resultss = $this->db->insert('genre', $genreData);
                $this->db->trans_complete();
            }
    }

    public function loginUser($username, $password)
    {
        $this->db->where('username', $username);
        $result = $this->db->get('user');
        if ($result->num_rows() == 1) {
            $dbPassword = $result->row(0)->password;
            if (password_verify($password, $dbPassword)) {
                return array('username' => $result->row(0)->username, 'userId' => $result->row(0)->userId);
            }else{
                return 'Invalid Password.';
            }
        }else {
            return 'User not found.';
        }
    }

    public function createProfile($userId, $formProfileName, $formAvatarUrl, $formGenres, $formEmail)
    {
        $this->db->where('userId', $userId);
        $userResult = $this->db->get('user');

        if ($userResult->num_rows() == 1) {
            $userObjArray = $userResult->custom_result_object('User');
            $userObj = $userObjArray[0];
            $userObj->updateProfileData($formProfileName, $formAvatarUrl, $formEmail);
            $this->db->where('userId', $userId);
            $this->db->update('user', $userObj);
        }
        $this->db->where('userId', $userId);
        $genreResult = $this->db->get('genre');
        if ($genreResult->num_rows() == 1) {
            $genreObjArray = $genreResult->custom_result_object('Genre');
            $genreObj = $genreObjArray[0];
            $genreObj->setGenres($userId, $formGenres);
            $this->db->where('userId', $userId);
            $this->db->update('genre', $genreObj);
        }
    }

    public function getProfileData($userId) {
        $this->db->where('userId', $userId);
        $output = array();
        $userResult = $this->db->get('user');
        if ($userResult->num_rows() == 1) {
            array_push($output, $userResult->custom_result_object('User'));
//            print_r($userResult);
        }
        $this->db->where('userId', $userId);
        $genreResult = $this->db->get('genre');
        if($genreResult->num_rows() == 1) {
            array_push($output, $genreResult->custom_result_object('Genre'));
//            print_r($genreResult);
        }
        return $output;
    }

    public function deleteProfileData($userId) {
        $this->db->where('userId', $userId);
        $this->db->delete('user');
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
            $result = $this->db->get('user');

            if($result->num_rows() > 0) {
                $finalResult = $result->custom_result_object('User');
                // Get user's followers
//                $this->db->select('*');
//                $this->db->where('userId', $userId);
//                $resulty = $this->db->get('user');
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

    public function searchUsersNew($userId, $selectedGenre) {
        $searchList = array();
        $followingList = array();
        $nonFollowingList = array();
        $finalGenreResult = null;
//        print_r($userId);
        if($selectedGenre!==null){
            $this->db->select('user.userId');
            $this->db->select('user.username');
            $this->db->select('genre.userId');
            $this->db->select('genre.likedGenres');
            $this->db->from('user');
            $this->db->where_not_in('user.userId', $userId);
            $this->db->join('genre', 'genre.userId = user.userId');
            $this->db->like('genre.likedGenres', $selectedGenre);

            $genreResult = $this->db->get();
            if($genreResult->num_rows() > 0) {
                $finalGenreResult = $genreResult->custom_result_object('User');
//                print_r($finalGenreResult);

                $this->db->select('user.userId');
                $this->db->select('user.username');
                $this->db->select('connection.followingUserId');
                $this->db->from('connection');
                $this->db->where('connection.currentUserId', $userId);
                //$this->db->where('user.userId !=',$userId);
                $this->db->join('user', 'user.userId = connection.followingUserId');
                $followerResult = $this->db->get();

                if($followerResult->num_rows() > 0) {
                    $finalFollowerResult = $followerResult->custom_result_object('User');

//                print_r($finalResult);

                    $followResultList = array();

                    foreach($finalFollowerResult as $result){
                        array_push($followResultList,$result->getUserId());
//                    print_r($result->getUserId());
                    }

                    foreach($finalGenreResult as $res){

                        if(in_array($res->getUserId(), $followResultList)){
                            $res->isFollow = true;
//                            echo 'in';
//                            echo $res->getUsername();
                            $followingList[$res->getUserId()] = $res->getUsername();
                        }else{
                            $res->isFollow = false;
//                            echo 'out';
//                            echo $res->getUsername();
                            $nonFollowingList[$res->getUserId()] = $res->getUsername();
                        }

                    }

//                    print_r($followResultList);
//                    print_r($followingList);
//                    print_r($finalGenreResult);
//                    return array($followingList, $nonFollowingList, $finalGenreResult);
                }
            }






            /*foreach($followerResult as $result){
                array_push($followResultList,$result->userId);
            }

            foreach($genreResult as $res){

                if(in_array($res->userId,$followResultList)){
                    $res->isFollow = true;
                }else{
                   $res->isFollow = false;
                }

            }

            print_r($genreResult);*/



//            $result = $this->db->get('user');
//            if($result->num_rows() > 0) {
//                return $finalResult = $result->custom_result_object('User');
//            }
        }
        return array($followingList, $nonFollowingList, $finalGenreResult);
//        print_r($finalGenreResult);
//        foreach ($finalGenreResult as $obj) {
//            echo $obj->getUserId();
//            echo $obj->getUsername();
//        }
    }

    public function userAction($actionType, $foundUserId) {

        $userId = $this->session->userData[1];

        if($actionType !== null && $foundUserId !== null) {

            if($actionType === 'followUser') {
                $this->db->trans_start();
                $this->db->where('userId', $userId);
                $resultFollower = $this->db->get('user');
                if ($resultFollower->num_rows() == 1) {
                    $userObjArray = $resultFollower->custom_result_object('User');
                    $userObj = $userObjArray[0];

                    // TODO use getFollowingID to fetch previously stored ids
                    $userObj->setFollowingId($foundUserId . ',');
                    $this->db->where('userId', $userId);
                    $this->db->update('user', $userObj);
                }

                $this->db->where('userId', $foundUserId);
                $resultFollowing = $this->db->get('user');
                if ($resultFollowing->num_rows() == 1) {
                    $userObjArray = $resultFollowing->custom_result_object('User');
                    $userObj = $userObjArray[0];
                    $userObj->setFollowersId($userId . ',');
                    $this->db->where('userId', $foundUserId);
                    $this->db->update('user', $userObj);
                }
                $this->db->trans_complete();

            } elseif ($actionType === 'unfollowUser') {
                $this->db->trans_start();
                $this->db->where('userId', $userId);
                $resultFollower = $this->db->get('user');
                if ($resultFollower->num_rows() == 1) {
                    $userObjArray = $resultFollower->custom_result_object('User');
                    $userObj = $userObjArray[0];
                    $userObj->setFollowingId($foundUserId . ',');
                    $this->db->where('userId', $userId);
                    $this->db->update('user', $userObj);
                }

                $this->db->where('userId', $foundUserId);
                $resultFollowing = $this->db->get('user');
                if ($resultFollowing->num_rows() == 1) {
                    $userObjArray = $resultFollowing->custom_result_object('User');
                    $userObj = $userObjArray[0];
                    $userObj->setFollowersId($userId . ',');
                    $this->db->where('userId', $foundUserId);
                    $this->db->update('user', $userObj);
                }
                $this->db->trans_complete();
            }
        }
    }

    public function userActions($userId, $actionType, $foundUserId) {

        if($actionType !== null && $foundUserId !== null) {
            if($actionType === 'followUser') {

                $followObj = new Connection();
                $followObj->setUserIds($userId, $foundUserId);
                $this->db->insert('Connection', $followObj);

            }elseif($actionType === 'unfollowUser') {
                $followObj = new Connection();
                $this->db->delete('Connection', array('currentUserId' => $userId, 'followingUserId' => $foundUserId));


            }
        }

    }




}