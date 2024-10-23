<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partsinventory_model extends CI_Model{
	
	public function add_partsinventory($data) { 
		return	$this->db->insert('partsinventory',$data);
	} 
    public function getall_partsinventory() { 
      $this->db->select("*");
	  $this->db->from('partsinventory');
	  $query = $this->db->get();
	  return $query->result_array();
	} 
	public function deletepartsinventory($p_id) { 
		$this->db->where('p_id', $p_id);
    	$this->db->delete('partsinventory');
    	return true;
    }
	public function get_partsdetails($p_id) { 
		$this->db->select("*");
		$this->db->from('partsinventory');
		$this->db->where('p_id', $p_id);
		$query = $this->db->get();
		return $query->result_array();
	  } 
	
} 