<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/17/2019
 * Time: 12:29 PM
 */

class UserManager extends CI_Model
{

    /**
     * UserManager constructor.
     * Loaded the DB connection module to do DB functions.
     */
    public function __construct() {
        $this->load->database();
    }


    /**
     * @param $username
     * @param $password
     * @param $emailAddress
     *
     * Registering a new user with the above parameters
     */
    public function registerUser($username, $password, $emailAddress) {

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $userData = new User();
        $userData->createUser($username, $hashedPassword, $emailAddress);
        $this->db->trans_start();
        $insertUserResult = $this->db->insert('user', $userData);

        $this->db->where('username', $username);
        $getUserResult = $this->db->get('user');

        if ($getUserResult->num_rows() == 1) {

            $userId = $getUserResult->row(0)->userId;
            $genreData = new Genre();
            $genreData->setGenres($userId, NULL);
            $genreResult = $this->db->insert('genre', $genreData);
            $this->db->trans_complete();
        }
    }


    /***
     * @param $username
     * @param $password
     * @return array|string
     *
     * Logging in user. Returning string value to display login errors.
     */
    public function loginUser($username, $password) {
        $this->db->where('username', $username);
        $result = $this->db->get('user');

        if ($result->num_rows() == 1) {
            $dbPassword = $result->row(0)->password;

            if (password_verify($password, $dbPassword)) {
                return array('username' => $result->row(0)->username, 'userId' => $result->row(0)->userId, 'user_logged_in' => true);
            } else {
                return 'Invalid Password.';
            }
        } else {
            return 'User not found.';
        }
    }

    /**
     * @param $userId
     * @param $formProfileName
     * @param $formAvatarUrl
     * @param $formGenres
     * @param $formEmail
     *
     * Sending needed parameters to create/update the profile of a new user.
     */
    public function createProfile($userId, $formProfileName, $formAvatarUrl, $formGenres, $formEmail) {
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

    /**
     * @param $userId
     * @return array
     *
     * Gathering User and Genre data of a selected user.
     */
    public function getProfileData($userId) {
        $this->db->where('userId', $userId);
        $output = array();
        $userResult = $this->db->get('user');

        if ($userResult->num_rows() == 1) {
            array_push($output, $userResult->custom_result_object('User'));
        }
        $this->db->where('userId', $userId);
        $genreResult = $this->db->get('genre');

        if ($genreResult->num_rows() == 1) {
            array_push($output, $genreResult->custom_result_object('Genre'));
        }
        return $output;
    }


    /**
     * @param $userId
     *
     * Deleting user.
     */
    public function deleteProfileData($userId) {
        $this->db->where('userId', $userId);
        $this->db->delete('user');
    }

    /**
     * @param $userId
     * @param $selectedGenre
     * @return array
     *
     * populating the search page with proper follow/unfollow buttons by combining all 3 connection, genre & user tables.
     */
    public function searchUsers($userId, $selectedGenre) {
        $followingList = array();
        $nonFollowingList = array();
        $finalGenreResult = null;

        if ($selectedGenre !== null) {
            $this->db->select('user.userId, user.username, genre.userId, genre.likedGenres');
            $this->db->from('user');
            $this->db->where_not_in('user.userId', $userId);
            $this->db->join('genre', 'genre.userId = user.userId');
            $this->db->like('genre.likedGenres', $selectedGenre);

            $genreResult = $this->db->get();

            if ($genreResult->num_rows() > 0) {
                $finalGenreResult = $genreResult->custom_result_object('User');

                $this->db->select('user.userId, user.username, connection.followingUserId');
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
                            $followingList[$res->getUserId()] = $res->getUsername();

                        } else {
                            $nonFollowingList[$res->getUserId()] = $res->getUsername();
                        }
                    }
                }
            }
        }
        return array($followingList, $nonFollowingList, $finalGenreResult);
    }


    public function userActions($userId, $actionType, $foundUserId) {
        if ($actionType !== null && $foundUserId !== null) {

            if ($actionType === 'followUser') {
                $followObj = new Connection();
                $followObj->setUserIds($userId, $foundUserId);
                $this->db->insert('connection', $followObj);

            } elseif ($actionType === 'unfollowUser') {
                $followObj = new Connection();
                $this->db->delete('connection', array('currentUserId' => $userId, 'followingUserId' => $foundUserId));
            }
        }
    }

    /**
     * @param $userId
     * @return mixed
     *
     * Method to populate follower list.
     */
    public function getFollowers($userId) {
        $this->db->select('connection.currentUserId as userId, connection.followingUserId, user.username, user.avatarUrl');
        $this->db->from('user');
        $this->db->join('connection', 'connection.currentUserId = user.userId ');
        $this->db->where('connection.followingUserId', $userId);
//        $this->db->where_not_in('connection.currentUserId', $userId);
        $followerResult = $this->db->get();

        if ($followerResult->num_rows() > 0) {
            $finalFollowerResult = $followerResult->custom_result_object('User');
            return $finalFollowerResult;
        }
    }

    /**
     * @param $userId
     * @return mixed
     *
     * Method to populate following user list.
     */
    public function getFollowing($userId) {
        $this->db->select('connection.currentUserId, connection.followingUserId as userId, user.username, user.avatarUrl');
        $this->db->from('user');
        $this->db->join('connection', 'connection.followingUserId = user.userId ');
        $this->db->where('connection.currentUserId', $userId);
        $followingResult = $this->db->get();

        if ($followingResult->num_rows() > 0) {
            $finalFollowingResult = $followingResult->custom_result_object('User');
            return $finalFollowingResult;
        }
    }


    /**
     * @param $userId
     * @return mixed
     *
     * Method to find friends (Following & Followed)
     */
    public function getFriends($userId) {

        $this->db->select('t1.followingUserId as userId, user.avatarUrl, user.username');
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

    /**
     * @param $userId
     * @param $profileUserId
     * @return bool
     *
     * Method to find only the following users.
     */
    public function findIfFollowing($userId, $profileUserId) {
        $this->db->select('connection.currentUserId, connection.followingUserId');
        $this->db->from('connection');
        $this->db->where("connection.currentUserId = $userId AND connection.followingUserId = $profileUserId");
        $ifFollowingResult = $this->db->get();

        if ($ifFollowingResult->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @param $userId
     * @return string
     *
     * Validation to prevent unauthorized URL manipulation
     */
    public function checkIfUserExists($userId) {
        $this->db->select('userId');
        $this->db->where('userId', $userId);
        $userResult = $this->db->get('user');

        if ($userResult->num_rows() > 0) {
            return $userResult->row(0)->userId;
        } else {
            return 'Error';
        }
    }


}