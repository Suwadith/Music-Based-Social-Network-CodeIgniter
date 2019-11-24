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
        $userId = $this->session->userdata('userId');
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $profileResult = $this->UserManager->getProfileData($userId);
        $this->load->view('user_profile', array('profileData' => $profileResult[0],
            'genreData' => $profileResult[1]));
        $this->load->view('footer');
    }


    public function homepage() {
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->displayProfileData();
        $this->load->view('footer');
    }


    public function timelinePage() {
        $userId = $this->session->userdata('userId');
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $timelinePostsResult = $this->PostManager->getTimelinePosts($userId);
        $this->load->view('user_timeline', array('timelinePosts' => $timelinePostsResult));
        $this->load->view('footer');
    }


    public function searchPage() {
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->displaySearch();
        $this->load->view('footer');

    }


    public function viewUserProfile() {
        $this->load->view('header');
        $this->load->view('navigation_bar');
        $this->loadUserProfile();
        $this->load->view('footer');
    }

    public function connections() {
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


    public function deleteProfile() {

        $userId = $this->session->userdata('userId');
        $deleteProfileResult = $this->UserManager->deleteProfileData($userId);
        $this->logoutUser();
    }


    public function displayProfileData() {
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


    public function createTimelinePost() {
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


    public function searchUser() {
        $userId = $this->session->userdata('userId');
        $this->session->selectedGenre = $this->input->post('genres');
        $searchResult = $this->UserManager->searchUsers($userId, $this->session->selectedGenre);
        $this->session->searchResult = $searchResult;
        redirect('/SiteController/searchPage');

    }


    public function displaySearch() {
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
        $currentUserId = $userId = $this->session->userdata('userId');
        $userId = $postId = $this->uri->segment(3);
        $profileResult = $this->UserManager->getProfileData($userId);
        $postResult = $this->PostManager->retrievePosts($userId);
        $followingResult = $this->UserManager->getFollowing($userId);
        $followerResult = $this->UserManager->getFollowers($userId);
        $friendsResult = $this->UserManager->getFriends($userId);
        $ifFollowingResult = $this->UserManager->findIfFollowing($currentUserId, $userId);
        $this->load->view('user_profile_page', array('posts' => $postResult,
            'profileData' => $profileResult[0],
            'genreData' => $profileResult[1],
            'followingData' => $followingResult,
            'followerData' => $followerResult,
            'friendsData' => $friendsResult,
            'isFollowing' => $ifFollowingResult));
    }


    public function followUser() {
        $userId = $this->session->userdata('userId');
        $actionType = $this->uri->segment(2);
        $foundUserId = $this->uri->segment(3);
        $actionResult = $this->UserManager->userActions($userId, $actionType, $foundUserId);
        redirect('/SiteController/homepage');

    }


    public function unfollowUser() {
        $userId = $this->session->userdata('userId');
        $actionType = $this->uri->segment(2);
        $foundUserId = $this->uri->segment(3);
        $actionResult = $this->UserManager->userActions($userId, $actionType, $foundUserId);
        redirect('/SiteController/homepage');
    }


}