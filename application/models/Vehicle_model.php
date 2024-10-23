<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class vehicle_model extends CI_Model{
	
	public function add_vehicle($data) { 
		if(!empty($_FILES)) {
			$config['upload_path'] = 'assets/uploads/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|docx'; 
			$this->load->library('upload', $config); 
			if(!empty($_FILES['file']['name'][0])){ 
				$uploadData = '';
				$this->upload->initialize($config); 
				$_FILES['file']['name']     = $_FILES['file']['name']; 
				$_FILES['file']['type']     = $_FILES['file']['type']; 
				$_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name']; 
				$_FILES['file']['error']     = $_FILES['file1']['error']; 
				$_FILES['file']['size']     = $_FILES['file']['size']; 
				if($this->upload->do_upload('file')){ 
					$uploadData = $this->upload->data();
					$data['v_file'] = $uploadData['file_name'];
				}
			} 
			if(!empty($_FILES['file1']['name'][1])){ 
				$uploadData = '';
				$this->upload->initialize($config); 
				$_FILES['file']['name']     = $_FILES['file1']['name']; 
				$_FILES['file']['type']     = $_FILES['file1']['type']; 
				$_FILES['file']['tmp_name'] = $_FILES['file1']['tmp_name']; 
				$_FILES['file']['error']     = $_FILES['file1']['error']; 
				$_FILES['file']['size']     = $_FILES['file1']['size']; 
				if($this->upload->do_upload('file1')){ 
					$uploadData = $this->upload->data();
					$data['v_file1'] = $uploadData['file_name'];
				}
			} 
		}
		$data['v_reg_exp_date'] = reformatDate($data['v_reg_exp_date']); 
		return $this->db->insert('vehicles',$data);
		
	} 
    public function getall_vehicle() {
      $this->db->select("*");
	  $this->db->from('vehicles');
	  $this->db->join('vehicle_group', 'vehicle_group.gr_id=vehicles.v_group','LEFT');
	  $this->db->order_by('v_id','desc');
	  $query = $this->db->get();
	  return $query->result_array();
	} 
	public function get_vehicledetails($v_id) { 
		return $this->db->select('*')->from('vehicles')->where('v_id',$v_id)->get()->result_array();
	} 
	public function edit_vehicle() { 
		$_POST['v_reg_exp_date'] = reformatDate($_POST['v_reg_exp_date']); 
		$this->db->where('v_id',$this->input->post('v_id'));
		return $this->db->update('vehicles',$this->input->post());
	}
	public function getall_bookings($v_id) { 
		$bookings = $this->db->select('*')->from('trips')->where('t_vechicle',$v_id)->order_by('t_id','desc')->get()->result_array();
		if(!empty($bookings)) {
			foreach ($bookings as $key => $tripdataval) {
				$newtripdata[$key] = $tripdataval;
				$newtripdata[$key]['t_customer_details'] =  $this->db->select('*')->from('customers')->where('c_id',$tripdataval['t_customer_id'])->get()->row();
				$newtripdata[$key]['t_driver_details'] =   $this->db->select('*')->from('drivers')->where('d_id',$tripdataval['t_driver'])->get()->row();
			}
			return $newtripdata;
		} else {
			return array();
		}

	} 
	public function get_vehiclegroup() { 
		return $this->db->select('*')->from('vehicle_group')->get()->result_array();
	}
	public function vehiclegroup_delete($gr_id) { 
		$groupinfo = $this->db->select('*')->from('vehicles')->where('v_group',$gr_id)->get()->result_array();
		if(count($groupinfo)>0) {
			return false;
		} else {
			$this->db->where('gr_id', $gr_id);
    		$this->db->delete('vehicle_group');
    		return true;
		}
	} 
} 