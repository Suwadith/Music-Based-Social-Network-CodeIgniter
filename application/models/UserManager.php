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
        }
    }

    public function createProfile($formProfileName, $formAvatarUrl, $formGenres)
    {
        $userId = $this->session->userData[1];
        $this->db->where('userId', $userId);
        $result = $this->db->get('users');
        if ($result->num_rows() == 1) {
            $userObjArray = $result->custom_result_object('User');
            $userObj = $userObjArray[0];
            $userObj->updateProfileData($formProfileName, $formAvatarUrl, $formGenres);
            $this->db->where('userId', $userId);
            $this->db->update('users', $userObj);
        }
    }


}