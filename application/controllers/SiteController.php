<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SiteController extends CI_Controller
{

//    public $postResult = '';
//    public $searchResult = '';

    /**
     * SiteController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserManager');
        $this->load->model('PostManager');
    }


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
        $userId = $this->session->userData[1];
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $results = $this->UserManager->getProfileData($userId);
        $this->load->view('user_profile', array('userDbProfileData' => $results));
        $this->load->view('footer');
    }

    public function homepage()
    {
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->displayProfileData();
//        $this->displayPosts();
        $this->load->view('footer');
    }

    public function timelinePage() {

    }

    public function searchPage()
    {
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->displaySearch();
        $this->load->view('footer');

    }

    public function viewUserProfile() {
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->loadPosts();
        $this->load->view('footer');
    }

    public function registerUser()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirmPassword]');
        $this->form_validation->set_rules('confirmPassword', 'trim|Password Confirmation', 'required');
//        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');

        if($this->form_validation->run() == FALSE) {
            redirect('/SiteController/registration');

        } else {
            $formUsername = $this->input->post('username');
            $formPassword = $this->input->post('password');
            $this->UserManager->registerUser($formUsername, $formPassword);
            redirect('/SiteController/login');
        }
    }

    public function loginUser()
    {

        $formUsername = $this->input->post('username');
        $formPassword = $this->input->post('password');
        $userData = $this->UserManager->loginUser($formUsername, $formPassword);
        if ($userData !== NULL) {
            $this->session->userData = $userData;
            redirect('/SiteController/homepage');
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
        $formEmail =  $this->input->post('emailAddress');
        $result = $this->UserManager->createProfile($formProfileName, $formAvatarUrl, $formGenres, $formEmail);
        redirect('/SiteController/homepage');
    }

    public function deleteProfile() {
        $result = $this->UserManager->deleteProfileData();
        $this->logoutUser();
    }

    public function displayProfileData() {
        $userId = $this->session->userData[1];
        $getProfileResult = $this->UserManager->getProfileData($userId);
        $postResult = $this->PostManager->retrievePosts($userId);
        $this->load->view('user_homepage', array('posts' => $postResult,
            'profileData' => $getProfileResult));
//        return $getProfileResult;
//        $this->load->view('user_homepage', array('profileData' => $getProfileResult));
    }

    public function createPost()
    {
        $postData = $this->input->post('postContent');
        $userId = $this->session->userData[1];
        $result = $this->PostManager->createPost($postData, $userId);
        redirect('/SiteController/homepage');

    }

//    public function displayPosts()
//    {
//        $userId = $this->session->userData[1];
//        $postResult = $this->PostManager->retrievePosts($userId);
//        $getProfileResult = $this->displayProfileData($userId);
//        $this->load->view('user_homepage', array('posts' => $postResult,
//            'profileData' => $getProfileResult));
//    }


    public function searchUser()
    {
        $this->session->selectedGenre = $this->input->post('genres');
//        $searchResult = $this->UserManager->searchUsers($this->session->selectedGenre);
        $searchResult = $this->UserManager->searchUsers($this->session->selectedGenre);

//        print_r($searchResult["result"]);

        $this->session->searchResult = $searchResult;
        redirect('/SiteController/searchPage');
//        $this->session->searchResult = $searchResult;
//        print_r($searchResult);
//        redirect('/SiteController/searchPage');
    }

    public function displaySearch() {
        $searchResult = $this->UserManager->searchUsers($this->session->selectedGenre);
        $this->load->view('user_search', array('usersList' => $searchResult));
        $this->session->selectedGenre = null;
    }

    public function loadPosts() {
        $userId = $this->uri->segment(3);
        $getProfileResult = $this->UserManager->getProfileData($userId);
        $postResult = $this->PostManager->retrievePosts($userId);
        $this->load->view('user_profile_page', array('posts' => $postResult,
            'profileData' => $getProfileResult));
    }

    public function followUser() {
        $actionType = $this->uri->segment(2);
        $foundUserId = $this->uri->segment(3);
        $actionResult = $this->UserManager->userActions($actionType, $foundUserId);
        redirect('/SiteController/searchPage');

    }

    public function unfollowUser() {
        $actionType = $this->uri->segment(2);
        $foundUserId = $this->uri->segment(3);
        $actionResult = $this->UserManager->userActions($actionType, $foundUserId);
        redirect('/SiteController/searchPage');
    }

}