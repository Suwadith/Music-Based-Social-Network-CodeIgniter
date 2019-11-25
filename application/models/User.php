<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/17/2019
 * Time: 8:03 AM
 */

class User extends CI_Model {
    public $userId;
    public $username;
    public $password;
    public $profileName;
    public $userEmail;
    public $avatarUrl;

    /**
     * @param $username
     * @param $password
     * @param $userEmail
     *
     * Method to set important user data on registration on to the user object.
     */
    public function createUser($username, $password, $userEmail) {
        $this->username = $username;
        $this->password = $password;
        $this->userEmail = $userEmail;
    }


    /**
     * @param $profileName
     * @param $avatarUrl
     * @param $userEmail
     *
     * Method to update profile data
     */
    public function updateProfileData($profileName, $avatarUrl, $userEmail) {
        $this->profileName = $profileName;
        if(empty($avatarUrl)) {
            $avatarUrl = NULL;
        }
        $this->avatarUrl = $avatarUrl;
        $this->userEmail = $userEmail;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }


    /**
     * @return mixed
     */
    public function getProfileName()
    {
        if($this->profileName !== NULL){
            return $this->profileName;
        }
        else {
            return NULL;
        }

    }

    /**
     * @return mixed
     */
    public function getAvatarUrl()
    {
        if(isset($this->avatarUrl)) {
            return $this->avatarUrl;
        } else {
            return "https://semantic-ui.com/images/avatar/large/steve.jpg";
        }

    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }





}