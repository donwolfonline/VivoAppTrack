<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partsinventory extends CI_Controller {

	 function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->load->model('partsinventory_model');
          $this->load->helper(array('form', 'url','string'));
          $this->load->library('form_validation');
          $this->load->library('session');
     }

	public function index()
	{
		$data['partsinventorylist'] = $this->partsinventory_model->getall_partsinventory();
		$this->template->template_render('partsinventory_management',$data);
	}
	public function addpartsinventory()
	{
		$this->template->template_render('partsinventory_add');
	}
	public function insertpartsinventory()
	{
		$testxss = xssclean($_POST);
		if($testxss){
			$response = $this->partsinventory_model->add_partsinventory($this->input->post());
			if($response) {
				$this->session->set_flashdata('successmessage', 'New partsinventory added successfully..');
			} else {
				$this->session->set_flashdata('warningmessage', validation_errors());
			}
			redirect('partsinventory');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error! Your input are not allowed.Please try again');
			redirect('partsinventory');
		}
	}
	public function editparts()
	{
		$p_id = $this->uri->segment(3);
		$data['partsdetails'] = $this->partsinventory_model->get_partsdetails($p_id);
		$this->template->template_render('partsinventory_add',$data);
	}
	public function updatepartsinventory()
	{   
		$this->db->where('p_id',$this->input->post('p_id'));
		$response = $this->db->update('partsinventory',$this->input->post());
		if($response) {
			$this->session->set_flashdata('successmessage', 'Partsinventory updated successfully..');
		} else {
			$this->session->set_flashdata('warningmessage', validation_errors());
		}
		redirect('partsinventory');
	}
	public function deletepartsinventory()
	{
		$p_id = $_POST['del_id'];
		$returndata = $this->partsinventory_model->deletepartsinventory($p_id);
		if($returndata) {
			$this->session->set_flashdata('successmessage', 'partsinventory deleted successfully..');
			redirect('partsinventory');
		} else {
			$this->session->set_flashdata('warningmessage', 'Error..! Try again..');
		    redirect('partsinventory');
		}
	}
}
