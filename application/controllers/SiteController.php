<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SiteController extends CI_Controller
{

    public $postResult = '';
//    public $searchResult = '';

    public function login()
    {
        $this->load->view('header');
        $this->load->view('user_login');
        $this->load->view('footer');
    }

    public function registration()
    {
        $this->load->view('header');
        $this->load->view('user_registration');
        $this->load->view('footer');
    }

    public function profile()
    {
        $this->load->view('header');
        $this->load->view('user_profile');
        $this->load->view('footer');
    }

    public function homepage()
    {
        $this->load->view('header');
        $this->displayPosts();
        $this->load->view('footer');
    }

    public function searchPage()
    {
        $this->load->view('header');
//        $this->searchUser();
        $this->load->view('user_search');
//        $this->searchUser();

        $this->load->view('footer');

    }

    public function registerUser()
    {
        $formUsername = $this->input->post('username');
        $formPassword = $this->input->post('password');
        $this->load->model('UserManager');
        $this->UserManager->registerUser($formUsername, $formPassword);
        redirect('/SiteController/login');
    }

    public function loginUser()
    {
        $formUsername = $this->input->post('username');
        $formPassword = $this->input->post('password');
        $this->load->model('UserManager');
        $userData = $this->UserManager->loginUser($formUsername, $formPassword);
        if ($userData !== NULL) {
            $this->session->userData = $userData;
            redirect('/SiteController/profile');
        }
    }

    public function logoutUser()
    {
        $this->session->sess_destroy();
        redirect('/SiteController/login');
    }


    public function createProfile()
    {
        $formProfileName = $this->input->post('profileName');
        $formAvatarUrl = $this->input->post('avatarUrl');
        $formGenres = $this->input->post('genres');
        $this->load->model('UserManager');
        $result = $this->UserManager->createProfile($formProfileName, $formAvatarUrl, $formGenres);


    }

    public function createPost()
    {
        $postData = $this->input->post('postContent');
        $userId = $this->session->userData[1];
        $this->load->model('PostManager');
        $result = $this->PostManager->createPost($postData, $userId);
        redirect('/SiteController/homepage');

    }

    public function displayPosts()
    {
        $userId = $this->session->userData[1];
        $this->load->model('PostManager');
        $postResult = $this->PostManager->retrievePosts($userId);
        $this->load->view('user_homepage', array('posts' => $postResult));
    }



//        print_r($postResult);


    public function searchUser()
    {
//        if ($this->input->post('genres') !== null) {
            $selectedGenre = $this->input->post('genres');
            $this->load->model('UserManager');
            $searchResult = $this->UserManager->searchUsers($selectedGenre);
//            print_r($searchResult);
            $this->load->view('user_search', array('usersList' => $searchResult));
//            $this->searchPage();
//            $this->searchPage();
//redirect('/SiteController/searchPage');

//        }

    }

}