<?php
/**
 * Created by PhpStorm.
 * User: Suwadith
 * Date: 12/29/2019
 * Time: 11:29 PM
 */

class ContactManager extends CI_Model {

    public function __construct() {

        $this->load->database();

    }

    public function get_contacts($userId) {
        $contacts = array();
        $this->db->where('userId', $userId);
        $this->db->order_by('lastName', 'asc');
        $result = $this->db->get('contact_user');

        if($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $contact = array('contactId' => $row->contactId, 'userId' => $row->userId,
                    'firstName' => $row->firstName, 'lastName' => $row->lastName,
                    'emailAddress' => $row->emailAddress, 'telephoneNumber' => $row->telephoneNumber);
                $contacts[] = $contact;
            }
        } else {
            $contacts[] = array('Message' => 'Yet to add any contacts');
        }
        return $contacts;

    }

    public function get_contact($userId, $lastName) {
        $contacts = array();
        $this->db->where('userId', $userId);
        $this->db->where('lastName', $lastName);
        $this->db->order_by('lastName', 'asc');
        $result = $this->db->get('contact_user');

        if($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $contact = array('contactId' => $row->contactId, 'userId' => $row->userId,
                    'firstName' => $row->firstName, 'lastName' => $row->lastName,
                    'emailAddress' => $row->emailAddress, 'telephoneNumber' => $row->telephoneNumber);
                $contacts[] = $contact;
            }
        }else {
            $contacts[] = array('Message' => 'Not Found');
        }
        return $contacts;
    }

    public function add_contact($userId) {

    }

    public function update_contact($userId, $contactId) {

    }

    public function delete_contact($userId, $contactId) {

    }

}