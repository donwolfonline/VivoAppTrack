<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance_model extends CI_Model{
	
	public function add_maintenance($data) { 
		$data['m_start_date'] = reformatDate($data['m_start_date']); 
		$data['m_end_date'] = reformatDate($data['m_end_date']); 
		return	$this->db->insert('vehicle_maintenance',$data);
	} 
    public function getall_maintenance() { 
      $this->db->select("vehicle_maintenance.*,vehicles.v_name");
	  $this->db->from('vehicle_maintenance');
	  $this->db->join('vehicles', 'vehicle_maintenance.m_v_id=vehicles.v_id','LEFT');
	  $this->db->order_by('m_id','desc');
	  $query = $this->db->get();
	  $all_maintenance =  $query->result_array();
	  if (!empty($all_maintenance)) {
		foreach ($all_maintenance as $key => $am) {
			$newdata[$key] = $am;
			if (!empty($am)) {
				$this->db->select("vehicle_maintenance_parts_used.pu_qty,partsinventory.p_name");
				$this->db->from('vehicle_maintenance_parts_used');
				$this->db->join('partsinventory', 'vehicle_maintenance_parts_used.pu_p_id=partsinventory.p_id','LEFT');
				$this->db->where('pu_m_id',$am['m_id']);
				$query = $this->db->get();
				$partsused =  $query->result_array();
				$newdata[$key]['partsused'] = $partsused;
			} else {
				$newdata[$key]['partsused'] = '';
			}
		}
		return $newdata;
	}
	} 
	public function deletemaintenance($r_id) { 
		$this->db->where('m_id', $r_id);
    	$this->db->delete('vehicle_maintenance');
    	return true;
    }
	
} 