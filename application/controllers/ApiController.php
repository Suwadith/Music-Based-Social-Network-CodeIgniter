<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 12/29/2019
 * Time: 11:12 PM
 */

use chriskacerguis\RestServer\RestController;

require BASEPATH.'libraries\chriskacerguis\Restserver\RestController.php';
require BASEPATH.'libraries\chriskacerguis\Restserver\Format.php';

class ApiController extends RestController {

    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        header('Access-Control-Allow-Origin: *');
        $this->load->model('ContactManager');
        if(!$this->session->userdata('user_logged_in')) {
            redirect('/UserController/login');
        }
    }

    public function index_get() {
    }

    public function contact_get() {
        $userId = $this->session->userdata('userId');
//        $lastName = $this->uri->segment(3,false);
//        $relationalTag = $this->uri->segment(4,false);
        $lastName = $this->input->get('lastName');
        $relationalTag = $this->input->get('relationalTag');
        $output = NULL;

        if(empty($lastName) AND empty($relationalTag)) {
            //fetch all
            $output = $this->ContactManager->getAllContacts($userId);
        }elseif(!empty($lastName) AND empty($relationalTag)) {
            //fetch using name only
            $output = $this->ContactManager->getLastNameContact($userId, urldecode($lastName));
        }elseif(empty($lastName) AND !empty($relationalTag)) {
            //fetch using tag only
            $output = $this->ContactManager->getRelationalTagContact($userId, urldecode($relationalTag));
//            echo urldecode($relationalTag);
        }else{
            //fetch using both name & tag
            $output = $this->ContactManager->getBothContact($userId, urldecode($lastName), urldecode($relationalTag));
        }


        print_r(json_encode($output));

    }

    public function contact_post() {

    }

    public function contact_put() {

    }

    public function contact_delete() {

    }

}