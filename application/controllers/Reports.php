<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller {
	function __construct()   {
          parent::__construct();
          $this->load->helper('url');
          $this->load->database();
          $this->load->model('vehicle_model');
          $this->load->model('incomexpense_model');
		  $this->load->model('drivers_model');
          $this->load->model('fuel_model');
          $this->load->model('trips_model');
          $this->load->library('session');
    }
	public function booking()	{
		if(isset($_POST['bookingreport'])) {
			$triplist = $this->trips_model->trip_reports(date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('booking_from')))),date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('booking_to')))),$this->input->post('booking_vechicle'));
			if(empty($triplist)) {
				$this->session->set_flashdata('warningmessage', 'No bookings found..');
				$data['triplist'] = '';
			} else {
				unset($_SESSION['warningmessage']);
				$data['triplist'] = $triplist;
			}
		}
		$data['vehiclelist'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('report_booking',$data);
	}
	public function incomeexpense()	{
		if(isset($_POST['incomeexpensereport'])) {
			$incomeexpensereport = $this->incomexpense_model->incomexpense_reports(date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('incomeexpense_from')))),date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('incomeexpense_to')))),$this->input->post('incomeexpense_vechicle'));
			

			if(empty($incomeexpensereport)) {
				$this->session->set_flashdata('warningmessage', 'No data found..');
				$data['incomexpense'] = '';
			} else {
				unset($_SESSION['warningmessage']);
				$data['incomexpense'] = $incomeexpensereport;
			}
		}
		$data['vehiclelist'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('report_incomeexpense',$data);
	}
	public function fuels()	{
		if(isset($_POST['fuelreport'])) {
			$fuelreport = $this->fuel_model->fuel_reports(date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('fuel_from')))),date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('fuel_to')))),$this->input->post('fuel_vechicle'));
			if(empty($fuelreport)) {
				$this->session->set_flashdata('warningmessage', 'No data found..');
				$data['fuel'] = '';
			} else {
				unset($_SESSION['warningmessage']);
				$data['fuel'] = $fuelreport;
			}
		}
		$data['vehiclelist'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('report_fuel',$data);
	}
	public function driversreport()	{
		$data['dlist'] = $this->drivers_model->getall_drivers();
		if(isset($_POST['driverreport'])) {
			$d_id = $_POST['d_id'];
			if($d_id=='all') {
				$where = array('t_start_date >='=>date("Y-m-d", strtotime(str_replace('/', '-', $_POST['r_from']))),'t_start_date<='=>date("Y-m-d", strtotime(str_replace('/', '-', $_POST['r_to']))));
			} else {
				$where = array('t_start_date >='=>date("Y-m-d", strtotime(str_replace('/', '-', $_POST['r_from']))),'t_start_date<='=>date("Y-m-d", strtotime(str_replace('/', '-', $_POST['r_to']))),'t_driver'=>$d_id);
			}
			$driverrep = $this->db->select('*')->from('trips')->where($where)->order_by('t_id','desc')->get()->result_array();
			
			if(empty($driverrep)) {
				$this->session->set_flashdata('warningmessage', 'No data found..');
				$data['drivers'] = '';
			} else {
				unset($_SESSION['warningmessage']);

				if(!empty($driverrep)) {
			foreach ($driverrep as $key => $tripdataval) {
				$newdata[$key] = $tripdataval;
				$newdata[$key]['t_customer_details'] =  $this->db->select('*')->from('customers')->where('c_id',$tripdataval['t_customer_id'])->get()->row();
				$newdata[$key]['t_vechicle_details'] =  $this->db->select('*')->from('vehicles')->where('v_id',$tripdataval['t_vechicle'])->get()->row();
				$newdata[$key]['t_driver_details'] =   $this->db->select('*')->from('drivers')->where('d_id',$tripdataval['t_driver'])->get()->row();
			}
			$data['drivers'] = $newdata;
			}
		}
		}
		$data['vehiclelist'] = $this->vehicle_model->getall_vehicle();
		$this->template->template_render('report_drivers',$data);
	}
}
