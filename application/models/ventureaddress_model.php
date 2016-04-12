<?php

class Ventureaddress_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //zone areas
    function create_address($data) {
        $this->db->insert('venture_address', $data);
        return $this->db->insert_id();
    }

    /**
     * Method to update address by Venture_id
     * 
     * @param type $data
     * @return type
     */
    function update_address($venture_id = false, $data = false, $address_id = false) {
        //$this->db->where('id', $data['adr_id']);
        if ($address_id) {
            $this->db->where('id', $address_id);
        }
        if ($venture_id) {
            $this->db->where('venture_id', $venture_id);
        }
        $this->db->update('venture_address', $data);
        return $this->db->insert_id();
    }

    function delete_address($address_id) {
        $this->db->where(array('id' => $address_id))->delete('venture_address');
    }

    function get($add_id) {
        $result = $this->db->get_where('venture_address', array('id' => $add_id));
        return $result->row();
    }

    function getByVenture($ven_id) {
        $result = $this->db->get_where('venture_address', array('venture_id' => $ven_id));
        return $result->row();
    }

}
