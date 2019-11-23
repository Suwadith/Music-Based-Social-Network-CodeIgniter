<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SiteController extends CI_Controller
{

    /**
     * SiteController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserManager');
        $this->load->model('PostManager');
        $this->form_validation->set_error_delimiters('<div class="errorMessage">', '</div><br>');
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
        $userId = $this->session->userdata('userId');
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $profileResult = $this->UserManager->getProfileData($userId);
        $this->load->view('user_profile', array('profileData' => $profileResult[0],
            'genreData' => $profileResult[1]));
        $this->load->view('footer');
    }

    public function homepage()
    {
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->displayProfileData();
        $this->load->view('footer');
    }

    public function timelinePage()
    {

    }

    public function searchPage()
    {
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->displaySearch();
        $this->load->view('footer');

    }

    public function viewUserProfile()
    {
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->loadPosts();
        $this->load->view('footer');
    }

    public function registerUser()
    {
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

    public function loginUser()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->login();
        } else {
            $formUsername = $this->input->post('username');
            $formPassword = $this->input->post('password');
            $userData = $this->UserManager->loginUser($formUsername, $formPassword);
            if (gettype($userData) !== 'string') {
//                $this->session->userData = $userData;
                $this->session->set_userdata($userData);
                $this->homepage();
            }else{
//                $this->session->errorMsg = $userData;
                $this->session->set_userdata('errorMsg', $userData);
                $this->login();
            }
        }
    }

    public function logoutUser()
    {
        $this->session->sess_destroy();
        $this->login();
    }


    public function createProfile()
    {
        $this->form_validation->set_rules('profileName', 'Profile Name', 'trim|required|min_length[8]|max_length[32]|is_unique[user.username]',
            array('min_length' => 'Username length has to be between 8 & 32 characters.',
                'max_length' => 'Username length has to be between 8 & 32 characters.',
                'is_unique' => 'Username is already in use.'));
        $this->form_validation->set_rules('avatarUrl', 'Avatar URL', 'trim|valid_url|max_length[1024]',
            array('max_length' => 'Avatar URL character length is restricted to 1024.',
                'matches' => 'Passwords do not match.'));
        $this->form_validation->set_rules('genres', 'Genre Selection', 'required');
        $this->form_validation->set_rules('emailAddress', 'Email Address', 'trim|required|valid_email|max_length[64]',
            array('valid_email' => 'Email address is not valid.',
                'max_length' => 'Maximum character length of the Email address is only 64.'));

        if ($this->form_validation->run() == FALSE) {
            $this->profile();
        } else {
            $userId = $this->session->userdata('userId');
            $formProfileName = $this->input->post('profileName');
            $formAvatarUrl = $this->input->post('avatarUrl');
            $formGenres = $this->input->post('genres');
            $formEmail = $this->input->post('emailAddress');
            $result = $this->UserManager->createProfile($userId, $formProfileName, $formAvatarUrl, $formGenres, $formEmail);
            redirect('/SiteController/homepage');
        }

    }

    public function deleteProfile()
    {
        $userId = $this->session->userdata('userId');
        $result = $this->UserManager->deleteProfileData($userId);
        $this->logoutUser();
    }

    public function displayProfileData()
    {
        $userId = $this->session->userdata('userId');
        $profileResult = $this->UserManager->getProfileData($userId);
        $postResult = $this->PostManager->retrievePosts($userId);
        $this->load->view('user_homepage', array('posts' => $postResult,
            'profileData' => $profileResult[0],
            'genreData' => $profileResult[1]));
    }

    public function createPost()
    {
        $this->form_validation->set_rules('postContent', 'Post Content', 'required|max_length[140]',
            array('max_length' => 'Maximum character length of a post is 140.'));
        if ($this->form_validation->run() == FALSE) {
            $this->homepage();
        } else {
            $postData = $this->input->post('postContent');
            $userId = $this->session->userdata('userId');
            $result = $this->PostManager->createPost($postData, $userId);
            redirect('/SiteController/homepage');
        }
    }

    public function editPost() {
        $postId = $this->uri->segment(3);
        $editPostResult = $this->PostManager->editSelectedPost($postId);
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->load->view('edit_post', array('posts' => $editPostResult));
        $this->load->view('footer');
    }

    public function updatePost() {
        $this->form_validation->set_rules('postContent', 'Post Content', 'required|max_length[140]',
            array('max_length' => 'Maximum character length of a post is 140.'));
        if ($this->form_validation->run() == FALSE) {
            $this->editPost();
        } else {
            $postContent = $this->input->post('postContent');
            $postId = $this->uri->segment(3);
            $updatePostResult = $this->PostManager->updateSelectedPost($postId, $postContent);
            redirect('/SiteController/homepage');
        }

    }

    public function deletePost() {
        $postId = $this->uri->segment(3);
        $deletePostResult = $this->PostManager->deleteSelectedPost($postId);
        redirect('/SiteController/homepage');
}


    public function searchUser()
    {
        $userId = $this->session->userdata('userId');
        $this->session->selectedGenre = $this->input->post('genres');
//        $searchResult = $this->UserManager->searchUsers($userId, $this->session->selectedGenre);
        $searchResult = $this->UserManager->searchUsersNew($userId, $this->session->selectedGenre);
        $this->session->searchResult = $searchResult;
        redirect('/SiteController/searchPage');

    }

    public function displaySearch()
    {
        $userId = $this->session->userdata('userId');
        $searchResult = $this->UserManager->searchUsersNew($userId, $this->session->selectedGenre);
        $this->load->view('user_search', array('usersList' => $searchResult));
        $this->session->selectedGenre = null;
    }

    public function loadPosts()
    {
        $userId = $this->uri->segment(3);
        $getProfileResult = $this->UserManager->getProfileData($userId);
        $postResult = $this->PostManager->retrievePosts($userId);
        $this->load->view('user_profile_page', array('posts' => $postResult,
            'profileData' => $getProfileResult));
    }

    public function followUser()
    {
        $userId = $this->session->userdata('userId');
        $actionType = $this->uri->segment(2);
        $foundUserId = $this->uri->segment(3);
        $actionResult = $this->UserManager->userActions($userId, $actionType, $foundUserId);
        redirect('/SiteController/searchPage');

    }

    public function unfollowUser()
    {
        $userId = $this->session->userdata('userId');
        $actionType = $this->uri->segment(2);
        $foundUserId = $this->uri->segment(3);
        $actionResult = $this->UserManager->userActions($userId, $actionType, $foundUserId);
        redirect('/SiteController/searchPage');
    }

}