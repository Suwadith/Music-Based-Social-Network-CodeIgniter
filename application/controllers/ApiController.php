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
        header('Content-type: application/json');
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


        print json_encode($output);


    }

    public function contact_post() {
        header('Content-type: application/json');
        $userId = $this->session->userdata('userId');
        $firstName = $this->post('firstName');
        $lastName = $this->post('lastName');
        $emailAddress = $this->post('emailAddress');
        $telephoneNumber = $this->post('telephoneNumber');
        $relationalTag = $this->post('relationalTag');
        $output = NULL;

         if(!empty($firstName) AND !empty($lastName) AND !empty($emailAddress) AND !empty($telephoneNumber) AND !empty($relationalTag)) {
             $output = $this->ContactManager->addBothContact($userId, urldecode($firstName), urldecode($lastName),
                 urldecode($emailAddress), urldecode($telephoneNumber), urldecode($relationalTag));
         }elseif(!empty($firstName) AND !empty($lastName) AND !empty($emailAddress) AND !empty($telephoneNumber) AND empty($relationalTag)) {
             $output = $this->ContactManager->addNormalContact($userId, urldecode($firstName), urldecode($lastName),
                 urldecode($emailAddress), urldecode($telephoneNumber));
         }
        print json_encode($output);
    }

    public function contact_put() {
        header('Content-type: application/json');
        $userId = $this->session->userdata('userId');
        $contactId = $this->put('contactId');
        $firstName = $this->put('firstName');
        $lastName = $this->put('lastName');
        $emailAddress = $this->put('emailAddress');
        $telephoneNumber = $this->put('telephoneNumber');
        $relationalTag = $this->put('relationalTag');
        $output = NULL;

        if(!empty($contactId) AND !empty($firstName) AND !empty($lastName) AND !empty($emailAddress) AND !empty($telephoneNumber) AND !empty($relationalTag)) {
            $output = $this->ContactManager->updateBothContact($userId, urldecode($contactId), urldecode($firstName), urldecode($lastName),
                urldecode($emailAddress), urldecode($telephoneNumber), urldecode($relationalTag));
        }elseif(!empty($contactId) AND !empty($firstName) AND !empty($lastName) AND !empty($emailAddress) AND !empty($telephoneNumber) AND empty($relationalTag)) {
            $output = $this->ContactManager->updateNormalContact($userId, urldecode($contactId), urldecode($firstName), urldecode($lastName),
                urldecode($emailAddress), urldecode($telephoneNumber));
        }

        print json_encode($output);


    }

    public function contact_delete() {
        header('Content-type: application/json');
        $userId = $this->session->userdata('userId');
        $contactId = $this->uri->segment(3);
        $output = NULL;

        $output = $this->ContactManager->deleteContact($userId, $contactId);

        print json_encode($output);
    }

}