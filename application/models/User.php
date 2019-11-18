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

    public function __construct($un, $ph)
    {
        $this->username = $un;
        $this->password = $ph;
    }

    public function updateProfileData($pN, $aU, $lG) {
        $this->profileName = $pN;
        $this->avatarUrl = $aU;
        $this->likedGenres = implode(',', (array) $lG);
    }

}