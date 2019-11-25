<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SiteController extends CI_Controller
{

    /**
     * SiteController constructor.
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('UserManager');
        $this->load->model('PostManager');
        $this->form_validation->set_error_delimiters('<div class="errorMessage">', '</div><br>');
    }


    public function profile() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $userId = $this->session->userdata('userId');
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $profileResult = $this->UserManager->getProfileData($userId);
        $this->load->view('user_profile', array('profileData' => $profileResult[0],
            'genreData' => $profileResult[1]));
        $this->load->view('footer');
    }


    public function homepage() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->displayProfileData();
        $this->load->view('footer');
    }


    public function timelinePage() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $userId = $this->session->userdata('userId');
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $timelinePostsResult = $this->PostManager->getTimelinePosts($userId);
        $this->load->view('user_timeline', array('timelinePosts' => $timelinePostsResult));
        $this->load->view('footer');
    }


    public function searchPage() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->displaySearch();
        $this->load->view('footer');

    }


    public function viewUserProfile() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->loadUserProfile();
        $this->load->view('footer');
    }

    public function connections() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $userId = $this->session->userdata('userId');
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $followingResult = $this->UserManager->getFollowing($userId);
        $followerResult = $this->UserManager->getFollowers($userId);
        $friendsResult = $this->UserManager->getFriends($userId);
        $this->load->view('user_connections', array('followingData' => $followingResult,
            'followerData' => $followerResult,
            'friendsData' => $friendsResult));
        $this->load->view('footer');
    }


    public function createProfile() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
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
            $createProfileResult = $this->UserManager->createProfile($userId, $formProfileName, $formAvatarUrl, $formGenres, $formEmail);
            redirect(base_url('/user/home'));
        }

    }


    public function deleteProfile() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $userId = $this->session->userdata('userId');
        $deleteProfileResult = $this->UserManager->deleteProfileData($userId);
        redirect(base_url('/user/logout'));
    }


    public function displayProfileData() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $userId = $this->session->userdata('userId');
        $profileResult = $this->UserManager->getProfileData($userId);
        $postResult = $this->PostManager->retrievePosts($userId);
        $followingResult = $this->UserManager->getFollowing($userId);
        $followerResult = $this->UserManager->getFollowers($userId);
        $friendsResult = $this->UserManager->getFriends($userId);
        $this->load->view('user_homepage', array('posts' => $postResult,
            'profileData' => $profileResult[0],
            'genreData' => $profileResult[1],
            'followingData' => $followingResult,
            'followerData' => $followerResult,
            'friendsData' => $friendsResult));
    }


    public function createHomePost() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $this->form_validation->set_rules('postContent', 'Post Content', 'required|max_length[140]',
            array('max_length' => 'Maximum character length of a post is 140.'));

        if ($this->form_validation->run() == FALSE) {
            $this->homepage();

        } else {
            $postData = $this->input->post('postContent');
            $userId = $this->session->userdata('userId');
            $createPostResult = $this->PostManager->createPost($postData, $userId);
            redirect(base_url('/user/home'));
        }
    }


    public function createTimelinePost() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $this->form_validation->set_rules('postContent', 'Post Content', 'required|max_length[140]',
            array('max_length' => 'Maximum character length of a post is 140.'));

        if ($this->form_validation->run() == FALSE) {
            $this->homepage();

        } else {
            $postData = $this->input->post('postContent');
            $userId = $this->session->userdata('userId');
            $createPostResult = $this->PostManager->createPost($postData, $userId);
            redirect(base_url('/user/timeline'));
        }
    }


    public function editPost() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $postId = $this->uri->segment(4);
        $editPostResult = $this->PostManager->editSelectedPost($postId);
        if($this->PostManager->getPostOwnerId($postId) === 'Error' OR $this->session->userdata('userId') != $editPostResult[0]->getUserId()){
            redirect(base_url('/user/home'));
        }
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->load->view('edit_post', array('posts' => $editPostResult));
        $this->load->view('footer');
    }


    public function updatePost() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $this->form_validation->set_rules('postContent', 'Post Content', 'required|max_length[140]',
            array('max_length' => 'Maximum character length of a post is 140.'));

        if ($this->form_validation->run() == FALSE) {
            $this->editPost();

        } else {
            $postContent = $this->input->post('postContent');
            $postId = $this->uri->segment(4);
            $updatePostResult = $this->PostManager->updateSelectedPost($postId, $postContent);
            redirect(base_url('/user/home'));
        }
    }


    public function deletePost() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $postId = $this->uri->segment(4);
        if($this->session->userdata('userId') != $this->PostManager->getPostOwnerId($postId)){
            redirect(base_url('/user/login'));
        }
        $deletePostResult = $this->PostManager->deleteSelectedPost($postId);
        redirect(base_url('/user/home'));
    }


    public function searchUser() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $userId = $this->session->userdata('userId');
        $this->session->selectedGenre = $this->input->post('genres');
        $searchResult = $this->UserManager->searchUsers($userId, $this->session->selectedGenre);
        $this->session->searchResult = $searchResult;
        redirect(base_url('/user/search'));

    }


    public function displaySearch() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $emptyResult = '';
        $userId = $this->session->userdata('userId');
        $searchResult = $this->UserManager->searchUsers($userId, $this->session->selectedGenre);
        if(empty($searchResult[0]) AND empty($searchResult[1]) AND empty($searchResult[2]) AND isset($this->session->selectedGenre)) {
            $emptyResult = 'No Users Found.';
        }
        $this->load->view('user_search', array('usersList' => $searchResult, 'notFound' => $emptyResult));
        $this->session->selectedGenre = null;
    }


    public function loadUserProfile() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $currentUserId = $userId = $this->session->userdata('userId');
        $userId = $postId = $this->uri->segment(4);
        if($this->UserManager->checkIfUserExists($userId) === 'Error') {
            redirect(base_url('/user/home'));
        }
        $profileResult = $this->UserManager->getProfileData($userId);
        $postResult = $this->PostManager->retrievePosts($userId);
        $ifFollowingResult = $this->UserManager->findIfFollowing($currentUserId, $userId);
        $this->load->view('user_profile_page', array('posts' => $postResult,
            'profileData' => $profileResult[0],
            'genreData' => $profileResult[1],
            'isFollowing' => $ifFollowingResult));
    }


    public function followUser() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $userId = $this->session->userdata('userId');
        $actionType = $this->uri->segment(2);
        $foundUserId = $this->uri->segment(3);
        $actionResult = $this->UserManager->userActions($userId, $actionType, $foundUserId);
        redirect(base_url('/user/home'));

    }


    public function unfollowUser() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect(base_url('/user/login'));
        }
        $userId = $this->session->userdata('userId');
        $actionType = $this->uri->segment(2);
        $foundUserId = $this->uri->segment(3);
        $actionResult = $this->UserManager->userActions($userId, $actionType, $foundUserId);
        redirect(base_url('/user/home'));
    }


}