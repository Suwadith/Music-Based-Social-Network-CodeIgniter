<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 11/24/2019
 * Time: 10:08 PM
 */

class UserController extends CI_Controller {

    /**
     * UserController constructor.
     * Loads the UserManager model to deal with login/registration/logout tasks.
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('UserManager');
        $this->form_validation->set_error_delimiters('<div class="errorMessage">', '</div><br>');
    }

    /**
     * Loading the needed components for the login page.
     */
    public function login() {
        $this->load->view('header');
        $this->load->view('user_login');
        $this->load->view('footer');
    }

    /**
     * Loading the needed components for the registration page.
     */
    public function registration() {
        $this->load->view('header');
        $this->load->view('user_registration');
        $this->load->view('footer');
    }

    /**
     * Performs the needed validations for a user to get registered properly.
     */
    public function registerUser() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[user.username]',
            array('min_length' => 'Username length has to be between 5 & 12 characters.',
                'max_length' => 'Username length has to be between 5 & 12 characters.',
                'is_unique' => 'Username is already in use.'));
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[16]|matches[confirmPassword]',
            array('min_length' => 'Password length has to be between 8 & 16 characters.',
                'max_length' => 'Password length has to be between 8 & 16 characters.',
                'matches' => 'Passwords do not match.'));
        $this->form_validation->set_rules('confirmPassword', 'Password Confirmation', 'required');
        $this->form_validation->set_rules('emailAddress', 'Email Address', 'trim|required|valid_email|is_unique[user.userEmail]',
            array('valid_email' => 'Email is not valid.',
                'is_unique' => 'Email is already in use.'));

        if ($this->form_validation->run() == FALSE) {
            $this->registration();

        } else {
            $formUsername = $this->input->post('username');
            $formPassword = $this->input->post('password');
            $formEmailAddress = $this->input->post('emailAddress');
            $this->UserManager->registerUser($formUsername, $formPassword, $formEmailAddress);
            $this->login();
        }
    }

    /**
     * Performs the needed validations for a user to get logged in properly.
     */
    public function loginUser() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->login();

        } else {
            $formUsername = $this->input->post('username');
            $formPassword = $this->input->post('password');
            $userData = $this->UserManager->loginUser($formUsername, $formPassword);

            if (gettype($userData) !== 'string') {
                $this->session->set_userdata($userData);
                redirect('/SiteController/homepage');

            }else{
                $this->session->set_userdata('errorMsg', $userData);
                $this->login();
            }
        }
    }

    /**
     * logs out the user.
     */
    public function logoutUser() {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('/UserController/login');
    }

}