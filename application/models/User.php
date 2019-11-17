<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/17/2019
 * Time: 8:03 AM
 */

class User
{

    private $username;
    private $password_hash;
    private $profileName;
    private $avatarUrl;
    private $likedGenres;

    public function __construct($un, $ph)
    {
        $this->username = $un;
        $this->password_hash = $ph;
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
    public function getPasswordHash()
    {
        return $this->password_hash;
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