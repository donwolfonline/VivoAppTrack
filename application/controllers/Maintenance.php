<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	 function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->model('maintenance_model');
		  $this->load->model('partsinventory_model');
          $this->load->model('trips_model');
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');
     }

	public function index()
	{
		$data['maintenancelist'] = $this->maintenance_model->getall_maintenance();
		$this->template->template_render('maintenance_management',$data);
	}
	public function addmaintenance()
	{
		$data['partsinventory'] = $this->partsinventory_model->getall_partsinventory();
		$data['vechiclelist'] = $this->trips_model->getall_vechicle();
		$this->template->template_render('maintenance_add',$data);
	}
	public function insertmaintenance()
	{
		$testxss = true;
		if($testxss){
			$pu_p_id = $_POST['pu_p_id'];
			$pu_qty = $_POST['pu_qty'];
			unset($_POST['pu_p_id']);
			unset($_POST['pu_qty']);
			$response = $this->maintenance_model->add_maintenance($this->input->post());
			if($response) {
				$pu_m_id  = $this->db->insert_id();
				foreach ($pu_p_id as $key => $itemName) {
					if($pu_p_id[$key]!='') {
						$my_data[$key]['pu_m_id'] = $pu_m_id;
						$my_data[$key]['pu_p_id'] = $pu_p_id[$key];
						$my_data[$key]['pu_qty'] = $pu_qty[$key];
						$my_data[$key]['pu_created_date'] = date('Y-m-d H:i:s');
					}
				}
				if(!empty($my_data)) {
					foreach($my_data as $partsused) {
						$this->db->set('p_stock', 'p_stock - '.$partsused["pu_qty"],false);
						$this->db->where('p_id', $partsused['pu_p_id']);
						$this->db->update('partsinventory');
					}
					$this->db->insert_batch('vehicle_maintenance_parts_used',$my_data); 
				}
				$this->session->set_flashdata('successmessage', 'New maintenance added successfully..');
			} else {
				$this->session->set_flashdata('warningmessage', validation_errors());
			}
			redirect('maintenance');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('maintenance');
		}
	}
	public function deletemaintenance()
	{
		$r_id = $_POST['del_id'];
		$returndata = $this->maintenance_model->deletemaintenance($r_id);
		if($returndata) {
			$this->session->set_flashdata('successmessage', 'Maintenance deleted successfully..');
			redirect('maintenance');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error..! Try again..');
		    redirect('maintenance');
		}
	}
	public function updatemaintenance()   
	{
		$mid = $this->uri->segment(3);
		$status = $this->uri->segment(4);
        $this->db->where('m_id', $mid);
        $this->db->update('vehicle_maintenance', array('m_status'=>$status));
		$this->session->set_flashdata('successmessage', 'Maintenance updated successfully.');
		redirect('maintenance');
	}
}
