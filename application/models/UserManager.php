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
            } else {
                return 'Invalid Password.';
            }
        } else {
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

    public function getProfileData($userId)
    {
        $this->db->where('userId', $userId);
        $output = array();
        $userResult = $this->db->get('user');
        if ($userResult->num_rows() == 1) {
            array_push($output, $userResult->custom_result_object('User'));
//            print_r($userResult);
        }
        $this->db->where('userId', $userId);
        $genreResult = $this->db->get('genre');
        if ($genreResult->num_rows() == 1) {
            array_push($output, $genreResult->custom_result_object('Genre'));
//            print_r($genreResult);
        }
        return $output;
    }

    public function deleteProfileData($userId)
    {
        $this->db->where('userId', $userId);
        $this->db->delete('user');
    }

    private function resultsFollowUser($results)
    {
        $userId = $this->session->userData[1];
        $relations = array();
        foreach ($results as $result) {
            $resultId = $result->getUserId();
            $followings = $result->getFollowingId();
            $followings = explode(",", $followings);

            array_pop($followings);
            $found = false;
            foreach ($followings as $followee) {
                if ($followee == $userId) {
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

    public function searchUsers($selectedGenre)
    {
        $userId = $this->session->userData[1];
        if ($selectedGenre !== null) {
            $this->db->trans_start();
            $this->db->like('likedGenres', $selectedGenre);
            $this->db->where_not_in('userId', $userId);
            $result = $this->db->get('user');

            if ($result->num_rows() > 0) {
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

    public function searchUsersNew($userId, $selectedGenre)
    {
        $followingList = array();
        $nonFollowingList = array();
        $finalGenreResult = null;
        if ($selectedGenre !== null) {
            $this->db->select('user.userId');
            $this->db->select('user.username');
            $this->db->select('genre.userId');
            $this->db->select('genre.likedGenres');
            $this->db->from('user');
            $this->db->where_not_in('user.userId', $userId);
            $this->db->join('genre', 'genre.userId = user.userId');
            $this->db->like('genre.likedGenres', $selectedGenre);

            $genreResult = $this->db->get();
            if ($genreResult->num_rows() > 0) {
                $finalGenreResult = $genreResult->custom_result_object('User');

                $this->db->select('user.userId');
                $this->db->select('user.username');
                $this->db->select('connection.followingUserId');
                $this->db->from('connection');
                $this->db->where('connection.currentUserId', $userId);
                $this->db->join('user', 'user.userId = connection.followingUserId');
                $followerResult = $this->db->get();

                if ($followerResult->num_rows() > 0) {
                    $finalFollowerResult = $followerResult->custom_result_object('User');
                    $followResultList = array();

                    foreach ($finalFollowerResult as $result) {
                        array_push($followResultList, $result->getUserId());
                    }

                    foreach ($finalGenreResult as $res) {

                        if (in_array($res->getUserId(), $followResultList)) {
//                            $res->isFollow = true;
                            $followingList[$res->getUserId()] = $res->getUsername();
                        } else {
//                            $res->isFollow = false;
                            $nonFollowingList[$res->getUserId()] = $res->getUsername();
                        }

                    }
                }
            }

        }
        return array($followingList, $nonFollowingList, $finalGenreResult);

    }


    public function userActions($userId, $actionType, $foundUserId)
    {

        if ($actionType !== null && $foundUserId !== null) {
            if ($actionType === 'followUser') {

                $followObj = new Connection();
                $followObj->setUserIds($userId, $foundUserId);
                $this->db->insert('Connection', $followObj);

            } elseif ($actionType === 'unfollowUser') {
                $followObj = new Connection();
                $this->db->delete('Connection', array('currentUserId' => $userId, 'followingUserId' => $foundUserId));


            }
        }

    }

    public function getFollowers($userId)
    {
        $this->db->select('connection.currentUserId as userId');
        $this->db->select('connection.followingUserId');
        $this->db->select('user.username');
        $this->db->select('user.avatarUrl');
        $this->db->from('user');
        $this->db->join('connection', 'connection.currentUserId = user.userId ');
        $this->db->where('connection.followingUserId', $userId);
        $followerResult = $this->db->get();

        if ($followerResult->num_rows() > 0) {
            $finalFollowerResult = $followerResult->custom_result_object('User');
            return $finalFollowerResult;
        }
    }

    public function getFollowing($userId) {
        $this->db->select('connection.currentUserId');
        $this->db->select('connection.followingUserId as userId');
        $this->db->select('user.username');
        $this->db->select('user.avatarUrl');
        $this->db->from('user');
        $this->db->join('connection', 'connection.followingUserId = user.userId ');
        $this->db->where('connection.currentUserId', $userId);
        $followingResult = $this->db->get();

        if ($followingResult->num_rows() > 0) {
            $finalFollowingResult = $followingResult->custom_result_object('User');
            return $finalFollowingResult;
        }
    }

    public function getFriends($userId) {

        $this->db->select('t1.followingUserId as userId');
        $this->db->select('user.avatarUrl');
        $this->db->select('user.username');
        $this->db->from('connection t1');
        $this->db->join('connection t2', 't1.currentUserId = t2.followingUserId AND t2.currentUserId = t1.followingUserId');
        $this->db->join('user', 'user.userId = t1.followingUserId');
        $this->db->where('t1.currentUserId', $userId);
        $friendsResult = $this->db->get();

        if ($friendsResult->num_rows() > 0) {
            $finalFriendsResult = $friendsResult->custom_result_object('User');
            return $finalFriendsResult;
        }
    }


}