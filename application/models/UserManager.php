<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/17/2019
 * Time: 12:29 PM
 */

include_once('User.php');

class UserManager extends CI_Model {

    private $message = "";
    public $user_obj = array();

    public function __construct() {
        $this->load->database();
    }

    public function registerUser($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userData = new User($username, $hashedPassword);

        $result = $this->db->insert('users', $userData);
    }

    public function loginUser($username, $password) {
        $this->db->where('username', $username);

        $result = $this->db->get('users');

        if($result->num_rows() == 1) {
            $dbPassword = $result->row(0)->password;
            if (password_verify($password, $dbPassword)) {
                return $result->row(0)->username;
            }
        }
    }

    public function updateProfile($formProfileName, $formAvatarUrl, $formGenres, $password) {
        $username = $this->session->username;
        $this->db->where('username', $username);
        $result = $this->db->get('users');

        if($result->num_rows() == 1) {
            $dbPassword = $result->row(0)->password;
            if (password_verify($password, $dbPassword)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $userObj = new User($username, $hashedPassword);
                $userObj->updateProfileData($formProfileName, $formAvatarUrl, $formGenres);
                $this->db->update('users', $userObj);
            }
        }
    }

}