<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SiteController extends CI_Controller {

	public function login()
	{
		$this->load->view('header');
        $this->load->view('user_login');
        $this->load->view('footer');
	}

	public function registration() {
	    $this->load->view('header');
	    $this->load->view('user_registration');
	    $this->load->view('footer');
    }

    public function profile() {
        $this->load->view('header');
        $this->load->view('user_profile');
        $this->load->view('footer');
    }

    public function registerUser() {
        $formUsername = $this->input->post('username');
        $formPassword = $this->input->post('password');

	    $this->load->model('UserManager');

	    $this->UserManager->registerUser($formUsername, $formPassword);

	    redirect('/SiteController/login');
    }

    public function loginUser() {
        $formUsername = $this->input->post('username');
        $formPassword = $this->input->post('password');

        $this->load->model('UserManager');

        $username = $this->UserManager->loginUser($formUsername, $formPassword);

        if($username !== NULL) {
            $this->session->username = $username;

            redirect('/SiteController/profile');
        }
    }

    public function createProfile() {
	    $password = $this->input->post('password');
	    $formProfileName = $this->input->post('profileName');
        $formAvatarUrl = $this->input->post('avatarUrl');
        $formGenres = $this->input->post('genres');
        $this->load->model('UserManager');

        $result = $this->UserManager->updateProfile($formProfileName, $formAvatarUrl, $formGenres, $password);


    }
}
