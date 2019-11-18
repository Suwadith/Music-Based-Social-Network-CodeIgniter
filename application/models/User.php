<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/17/2019
 * Time: 8:03 AM
 */

class User
{

    public $username;
    public $password;
    public $profileName;
    public $avatarUrl;
    public $likedGenres;

//    /**
//     * User constructor.
//     * @param $username
//     * @param $password
//     */
//    public function __construct($username, $password)
//    {
//        $this->username = $username;
//        $this->password = $password;
//    }

    public function createUser($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }


    public function updateProfileData($profileName, $avatarUrl, $likedGenres) {
        $this->profileName = $profileName;
        $this->avatarUrl = $avatarUrl;
        $this->likedGenres = implode(',', (array) $likedGenres);
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



}