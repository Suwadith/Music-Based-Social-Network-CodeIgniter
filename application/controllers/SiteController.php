<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SiteController extends CI_Controller
{

    /**
     * SiteController constructor.
     * Loads both the UserManager & PostManager Models to deal with various tasks.
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('UserManager');
        $this->load->model('PostManager');
        $this->form_validation->set_error_delimiters('<div class="errorMessage">', '</div><br>');
    }

    /**
     * Loads the profile edit/update page to gather additional data such as Profile name, email address, Avatar image URL, Genres that the user likes.
     */
    public function profile() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $userId = $this->session->userdata('userId');
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $profileResult = $this->UserManager->getProfileData($userId);
        $this->load->view('user_profile', array('profileData' => $profileResult[0],
            'genreData' => $profileResult[1]));
        $this->load->view('footer');
    }

    /**
     * Loads the home page of a logged in user.
     */
    public function homepage() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->displayProfileData();
        $this->load->view('footer');
    }

    /**
     * Loads the timeline page where the user will be able to see both his posts and the posts of the users' he's following.
     */
    public function timelinePage() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $userId = $this->session->userdata('userId');
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $timelinePostsResult = $this->PostManager->getTimelinePosts($userId);
        $this->load->view('user_timeline', array('timelinePosts' => $timelinePostsResult));
        $this->load->view('footer');
    }

    /**
     * Loads the search page where the user will be able to find other users under a selected genre.
     */
    public function searchPage() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->displaySearch();
        $this->load->view('footer');

    }

    /**
     * Loads a selected user's public home page.
     */
    public function viewUserProfile() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->loadUserProfile();
        $this->load->view('footer');
    }

    /**
     * Load connections page (Shows followers/following users & friends)
     */
    public function connections() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
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


    public function contactsList() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
//        $userId = $this->session->userdata('userId');
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->load->view('user_contacts');
        $this->load->view('footer');
    }

    /**
     * Validations for handling editing/updating profile section
     */
    public function createProfile() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
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
            redirect('/SiteController/homepage');
        }

    }

    /**
     * Delete logged in user's profile
     */
    public function deleteProfile() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $userId = $this->session->userdata('userId');
        $deleteProfileResult = $this->UserManager->deleteProfileData($userId);
        redirect('/UserController/logoutUser');
    }

    /**
     * Display logged in user's home page.
     */
    public function displayProfileData() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $userId = $this->session->userdata('userId');
        $profileResult = $this->UserManager->getProfileData($userId);
        $postResult = $this->PostManager->retrievePosts($userId);
        $this->load->view('user_homepage', array('posts' => $postResult,
            'profileData' => $profileResult[0],
            'genreData' => $profileResult[1]));
    }

    /**
     * Create post within user's home page
     */
    public function createHomePost() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $this->form_validation->set_rules('postContent', 'Post Content', 'required|max_length[140]',
            array('max_length' => 'Maximum character length of a post is 140.'));

        if ($this->form_validation->run() == FALSE) {
            $this->homepage();

        } else {
            $postData = $this->input->post('postContent');
            $userId = $this->session->userdata('userId');
            $createPostResult = $this->PostManager->createPost($postData, $userId);
            redirect('/SiteController/homepage');
        }
    }

    /**
     * Create post from timeline page.
     */
    public function createTimelinePost() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $this->form_validation->set_rules('postContent', 'Post Content', 'required|max_length[140]',
            array('max_length' => 'Maximum character length of a post is 140.'));

        if ($this->form_validation->run() == FALSE) {
            $this->homepage();

        } else {
            $postData = $this->input->post('postContent');
            $userId = $this->session->userdata('userId');
            $createPostResult = $this->PostManager->createPost($postData, $userId);
            redirect('/SiteController/timelinePage');
        }
    }

    /**
     * Edit logged in user's selected post using post ID.
     */
    public function editPost() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $postId = $this->uri->segment(3);
        $editPostResult = $this->PostManager->editSelectedPost($postId);
        if($this->PostManager->getPostOwnerId($postId) === 'Error' OR $this->session->userdata('userId') != $editPostResult[0]->getUserId()){
            redirect('/SiteController/homepage');
        }
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->load->view('edit_post', array('posts' => $editPostResult));
        $this->load->view('footer');
    }

    /**
     * validation for updating edited post
     */
    public function updatePost() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
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

    /**
     * Delete logged in user's selected post.
     */
    public function deletePost() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $postId = $this->uri->segment(3);
        if($this->session->userdata('userId') != $this->PostManager->getPostOwnerId($postId)){
            redirect('/UserController/login');
        }
        $deletePostResult = $this->PostManager->deleteSelectedPost($postId);
        redirect('/SiteController/homepage');
    }

    /**
     * Search user's using their favorite genres from the search page
     */
    public function searchUser() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $userId = $this->session->userdata('userId');
        $this->session->selectedGenre = $this->input->post('genres');
        $searchResult = $this->UserManager->searchUsers($userId, $this->session->selectedGenre);
        $this->session->searchResult = $searchResult;
        redirect('/SiteController/searchPage');

    }

    /**
     * after page refresh by using session stored search result value, displaying search list.
     */
    public function displaySearch() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
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


    /**
     * load selected user's profile wit han option to follow/unfollow
     */
    public function loadUserProfile() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $currentUserId = $userId = $this->session->userdata('userId');
        $userId = $this->uri->segment(3);
        if($this->UserManager->checkIfUserExists($userId) === 'Error') {
            redirect('/SiteController/homepage');
        }
        $profileResult = $this->UserManager->getProfileData($userId);
        $postResult = $this->PostManager->retrievePosts($userId);
        $ifFollowingResult = $this->UserManager->findIfFollowing($currentUserId, $userId);
        $this->load->view('user_profile_page', array('posts' => $postResult,
            'profileData' => $profileResult[0],
            'genreData' => $profileResult[1],
            'isFollowing' => $ifFollowingResult));
    }


    /**
     * follow selected user using his user ID.
     */
    public function followUser() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $userId = $this->session->userdata('userId');
        $actionType = $this->uri->segment(2);
        $foundUserId = $this->uri->segment(3);
        $actionResult = $this->UserManager->userActions($userId, $actionType, $foundUserId);
        redirect('/SiteController/homepage');

    }

    /**
     * unfollow selected user using user ID.
     */
    public function unfollowUser() {
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
        $userId = $this->session->userdata('userId');
        $actionType = $this->uri->segment(2);
        $foundUserId = $this->uri->segment(3);
        $actionResult = $this->UserManager->userActions($userId, $actionType, $foundUserId);
        redirect('/SiteController/homepage');
    }


}