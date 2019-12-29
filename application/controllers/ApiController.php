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
    }

    public function index_get() {

    }

    public function contact_get() {
        $userId = $this->session->userdata('userId');
        $lastName = $this->uri->segment(3,false);
        $output = NULL;
        if($lastName === false) {
//            echo 'get all';
            $output = $this->ContactManager->get_contacts($userId);
        }else {
//            echo $contactId;
            $output = $this->ContactManager->get_contact($userId, urldecode($lastName));
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