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

    public function getAllContacts($userId) {
        $contacts = array();
        $this->db->select('contact_user.contactId, contact_user.userId, contact_user.firstName, 
        contact_user.lastName, contact_user.emailAddress, contact_user.telephoneNumber, contact_tag.relationalTag');
        $this->db->from('contact_user');
        $this->db->join('contact_tag', 'contact_tag.contactId = contact_user.contactId');
        $this->db->where('contact_user.userId', $userId);
        $this->db->order_by('contact_user.lastName', 'asc');
        $result = $this->db->get();

        if($result->num_rows() > 0) {
//            $contacts[] = array('Message' => 'Contacts Found');
            foreach ($result->result() as $row) {
                $contact = array('contactId' => $row->contactId, 'userId' => $row->userId,
                    'firstName' => $row->firstName, 'lastName' => $row->lastName,
                    'emailAddress' => $row->emailAddress, 'telephoneNumber' => $row->telephoneNumber,
                    'relationalTag' => $row->relationalTag);
                $contacts[] = $contact;
            }
        } else {
//            $contacts[] = array('Message' => 'Yet to add any contacts');
        }
        return $contacts;

    }

    public function getLastNameContact($userId, $lastName) {
        $contacts = array();
        $this->db->select('contact_user.contactId, contact_user.userId, contact_user.firstName,
        contact_user.lastName, contact_user.emailAddress, contact_user.telephoneNumber, contact_tag.relationalTag');
        $this->db->from('contact_user');
        $this->db->join('contact_tag', 'contact_tag.contactId = contact_user.contactId');
        $this->db->where('contact_user.userId', $userId);
        $this->db->like('contact_user.lastName', $lastName);
        $this->db->order_by('contact_user.lastName', 'asc');
        $result = $this->db->get();

        if($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $contact = array('contactId' => $row->contactId, 'userId' => $row->userId,
                    'firstName' => $row->firstName, 'lastName' => $row->lastName,
                    'emailAddress' => $row->emailAddress, 'telephoneNumber' => $row->telephoneNumber,
                    'relationalTag' => $row->relationalTag);
                $contacts[] = $contact;
            }
        }else {
//            $contacts[] = array('Message' => 'Not Found');
        }
        return $contacts;
    }


    public function getRelationalTagContact($userId, $relationalTag) {
        $contacts = array();
        $this->db->select('contact_user.contactId, contact_user.userId, contact_user.firstName, 
        contact_user.lastName, contact_user.emailAddress, contact_user.telephoneNumber, contact_tag.relationalTag');
        $this->db->from('contact_user');
        $this->db->join('contact_tag', 'contact_tag.contactId = contact_user.contactId');
        $this->db->where('contact_user.userId', $userId);
        $this->db->like('contact_tag.relationalTag', $relationalTag);
        $this->db->order_by('contact_user.lastName', 'asc');
        $result = $this->db->get();

        if($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $contact = array('contactId' => $row->contactId, 'userId' => $row->userId,
                    'firstName' => $row->firstName, 'lastName' => $row->lastName,
                    'emailAddress' => $row->emailAddress, 'telephoneNumber' => $row->telephoneNumber,
                    'relationalTag' => $row->relationalTag);
                $contacts[] = $contact;
            }
        }else {
//            $contacts[] = array('Message' => 'Not Found');
        }
        return $contacts;
    }

    public function getBothContact($userId, $lastName, $relationalTag) {
        $contacts = array();
        $this->db->select('contact_user.contactId, contact_user.userId, contact_user.firstName,
        contact_user.lastName, contact_user.emailAddress, contact_user.telephoneNumber, contact_tag.relationalTag');
        $this->db->from('contact_user');
        $this->db->join('contact_tag', 'contact_tag.contactId = contact_user.contactId');
        $this->db->where('contact_user.userId', $userId);
        $this->db->like('contact_user.lastName', $lastName);
        $this->db->like('contact_tag.relationalTag', $relationalTag);
        $this->db->order_by('contact_user.lastName', 'asc');
        $result = $this->db->get();

        if($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $contact = array('contactId' => $row->contactId, 'userId' => $row->userId,
                    'firstName' => $row->firstName, 'lastName' => $row->lastName,
                    'emailAddress' => $row->emailAddress, 'telephoneNumber' => $row->telephoneNumber,
                    'relationalTag' => $row->relationalTag);
                $contacts[] = $contact;
            }
        }else {
//            $contacts[] = array('Message' => 'Not Found');
        }
        return $contacts;
    }



    public function addBothContact($userId, $firstName, $lastName, $emailAddress, $telephoneNumber, $relationalTag) {
        $contact = array('userId' => $userId, 'firstName' => $firstName,
            'lastName' => $lastName, 'emailAddress' => $emailAddress,
            'telephoneNumber' => $telephoneNumber);

        $this->db->trans_start();

        $insertContactResult = $this->db->insert('contact_user', $contact);

        $this->db->where('userId', $userId);
        $this->db->order_by('contactId', 'desc');
        $this->db->limit(1);
        $getContactResult = $this->db->get('contact_user');

        if ($getContactResult->num_rows() == 1) {

            $contactId = $getContactResult->row(0)->contactId;
            $tag = array('contactId' => $contactId, 'relationalTag' => $relationalTag);
            $tagResult = $this->db->insert('contact_tag', $tag);
            $this->db->trans_complete();
        }



    }

    public function addNormalContact($userId, $firstName, $lastName, $emailAddress, $telephoneNumber) {
        $contact = array('userId' => $userId, 'firstName' => $firstName,
            'lastName' => $lastName, 'emailAddress' => $emailAddress,
            'telephoneNumber' => $telephoneNumber);

        $this->db->trans_start();

        $insertContactResult = $this->db->insert('contact_user', $contact);

        $this->db->where('userId', $userId);
        $this->db->order_by('contactId', 'desc');
        $this->db->limit(1);
        $getContactResult = $this->db->get('contact_user');

        if ($getContactResult->num_rows() == 1) {

            $contactId = $getContactResult->row(0)->contactId;
            $tag = array('contactId' => $contactId, 'relationalTag' => '');
            $tagResult = $this->db->insert('contact_tag', $tag);
            $this->db->trans_complete();
        }

    }

    public function updateBothContact($userId, $contactId, $firstName, $lastName, $emailAddress, $telephoneNumber, $relationalTag) {
        $contact = array('firstName' => $firstName, 'lastName' => $lastName,
            'emailAddress' => $emailAddress, 'telephoneNumber' => $telephoneNumber);

        $tag = array('relationalTag' => $relationalTag);

        $this->db->trans_start();
        $this->db->where('userId', $userId);
        $this->db->where('contactId', $contactId);
        $contactResult = $this->db->update('contact_user', $contact);

        $this->db->where('contactId', $contactId);
        $tagResult = $this->db->update('contact_tag', $tag);
        $this->db->trans_complete();

    }

    public function updateNormalContact($userId, $contactId, $firstName, $lastName, $emailAddress, $telephoneNumber) {
        $contact = array('firstName' => $firstName, 'lastName' => $lastName,
            'emailAddress' => $emailAddress, 'telephoneNumber' => $telephoneNumber);

        $this->db->where('userId', $userId);
        $this->db->where('contactId', $contactId);
        $result = $this->db->update('contact_user', $contact);
    }

    public function deleteContact($userId, $contactId) {

        $this->db->where('userId', $userId);
        $this->db->where('contactId', $contactId);
        $this->db->delete('contact_user');

    }

}