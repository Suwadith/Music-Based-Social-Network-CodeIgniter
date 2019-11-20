<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/17/2019
 * Time: 8:03 AM
 */

class User
{
    public $userId;
    public $username;
    public $password;
    public $profileName;
    public $userEmail;
    public $avatarUrl;
    public $likedGenres;
    public $followersId;
    public $followingId;

    public function createUser($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }


    public function updateProfileData($profileName, $avatarUrl, $likedGenres, $userEmail) {
        $this->profileName = $profileName;
        $this->avatarUrl = $avatarUrl;
        $this->likedGenres = implode(',', (array) $likedGenres);
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
    public function getProfileName()
    {
        return $this->profileName;
    }

    /**
     * @return mixed
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * @return mixed
     */
    public function getLikedGenres()
    {
        return $this->likedGenres;
    }

    /**
     * @return array
     */
    public function getFollowersId()
    {
        return $this->followersId;
    }

    /**
     * @param array $followersId
     */
    public function setFollowersId($followersId)
    {
        $this->followersId = $followersId;
    }

    /**
     * @return array
     */
    public function getFollowingId()
    {
        return $this->followingId;
    }

    /**
     * @param array $followingId
     */
    public function setFollowingId($followingId)
    {
        $this->followingId = $followingId;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }





}