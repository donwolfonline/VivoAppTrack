<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicle extends CI_Controller {
	function __construct()
    {
          parent::__construct();
          $this->load->database();
          $this->load->model('vehicle_model');
          $this->load->model('incomexpense_model');
          $this->load->model('geofence_model');
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');
    }
	public function index()
	{
		$data['vehiclelist'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('vehicle_management',$data);
	}
	public function addvehicle()
	{
		$data['v_group'] = $this->vehicle_model->get_vehiclegroup();
		$data['traccar_list'] = json_decode(traccar_call('api/devices','','GET'),true);
		$this->template->template_render('vehicle_add',$data);
	}
	public function insertvehicle()
	{
		$this->form_validation->set_rules('v_registration_no','Registration Number','required|trim|is_unique[vehicles.v_registration_no]');
		$this->form_validation->set_message('is_unique', '%s is already exist');
		$this->form_validation->set_rules('v_model','Model','required|trim');
		$this->form_validation->set_rules('v_chassis_no','Chassis No','required|trim');
        $this->form_validation->set_rules('v_engine_no', 'Engine No', 'required|trim');
		$this->form_validation->set_rules('v_manufactured_by','Manufactured By','required|trim');
		$this->form_validation->set_rules('v_type','Vehicle Type','required|trim');
		$this->form_validation->set_rules('v_color','Vehicle Color','required|trim');
		if($this->form_validation->run()==TRUE){
			$response = $this->vehicle_model->add_vehicle($this->input->post());
			if($response) {
				$this->session->set_flashdata('successmessage', 'New vehicle added successfully..');
			    redirect('vehicle');
			}
		} else	{
			$this->session->set_flashdata('warningmessage',preg_replace( "/\r|\n/", "", trim(str_replace('.',',',strip_tags(validation_errors())))));
			redirect('vehicle/addvehicle');
		}
	}
	public function editvehicle()
	{
		$v_id = $this->uri->segment(3);
		$data['v_group'] = $this->vehicle_model->get_vehiclegroup();
		$data['vehicledetails'] = $this->vehicle_model->get_vehicledetails($v_id);
		$data['traccar_list'] = json_decode(traccar_call('api/devices','','GET'),true);
		$this->template->template_render('vehicle_add',$data);
	}

	public function updatevehicle()
	{
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
					$_POST['v_file'] = $uploadData['file_name'];
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
					$_POST['v_file1'] = $uploadData['file_name'];
				}
			} 
		}
		$testxss = xssclean($_POST);
		if($testxss){
			$response = $this->vehicle_model->edit_vehicle($this->input->post());
				if($response) {
					$this->session->set_flashdata('successmessage', 'Vehicle updated successfully..');
				    redirect('vehicle');
				} else
				{
					$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
				    redirect('vehicle');
				}
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('vehicle');
		}
	}
	public function viewvehicle()
	{
		$v_id = $this->uri->segment(3);
		$vehicledetails = $this->vehicle_model->get_vehicledetails($v_id);
		$bookings = $this->vehicle_model->getall_bookings($v_id);
		$vgeofence = $this->geofence_model->getvechicle_geofence($v_id);
		$vincomexpense = $this->incomexpense_model->getvechicle_incomexpense($v_id);
		$geofence_events = $this->geofence_model->countvehiclengeofence_events($v_id);
		if(isset($vehicledetails[0]['v_id'])) {
			$data['vehicledetails'] = $vehicledetails[0];
			$data['bookings'] = $bookings;
			$data['vechicle_geofence'] = $vgeofence;
			$data['vechicle_incomexpense'] = $vincomexpense;
			$data['geofence_events'] = $geofence_events;
			$this->template->template_render('vehicle_view',$data);
		} else {
			$this->template->template_render('pagenotfound');
		}
	}
	public function vehiclegroup()
	{
		$data['vehiclegroup'] = $this->vehicle_model->get_vehiclegroup();
		$this->template->template_render('vehicle_group',$data);
	}
	public function vehiclegroup_delete()
	{
		$gr_id = $this->uri->segment(3);
		$returndata = $this->vehicle_model->vehiclegroup_delete($gr_id);
		if($returndata) {
			$this->session->set_flashdata('successmessage', 'Group deleted successfully..');
			redirect('vehicle/vehiclegroup');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error..! Some vechicle are mapped with this group. Please remove from vechicle management');
		    redirect('vehicle/vehiclegroup');
		}
	}
	public function addgroup()
	{
		$response = $this->db->insert('vehicle_group',$this->input->post());
		if($response) {
			$this->session->set_flashdata('successmessage', 'Group added successfully..');
		    redirect('vehicle/vehiclegroup');
		} else
		{
			$this->session->set_flashdata('warningmessage', 'Something went wrong..Try again');
		    redirect('vehicle/vehiclegroup');
		}
	}
	public function deletevehicle()
	{
		$v_id = $this->input->post('del_id');
		$deleteresp = $this->db->delete('vehicles', array('v_id' => $v_id)); 
		if($deleteresp) {
			$this->session->set_flashdata('successmessage', 'Vehicle deleted successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', 'Unexpected error..Try again');
		}
		redirect('vehicle');
	}
}
