<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trips_model extends CI_Model{
	public function add_trips($data) {   
		unset($data['bookingemail']);
		$insertdata = $data;
		$insertdata['t_trackingcode'] = uniqid();
		$regEx = '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/';
		preg_match($regEx, $data['t_start_date'], $result);
		if(!empty($result)) {
			$insertdata['t_start_date'] = reformatDatetime($data['t_start_date']);
			$insertdata['t_end_date'] = reformatDatetime($data['t_end_date']);
		} else {
			$insertdata['t_start_date'] = $data['t_start_date'];
			$insertdata['t_end_date'] = $data['t_start_date'];
		}
		$this->db->insert('trips',$insertdata);
		//echo $this->db->last_query();
		return $this->db->insert_id();
	} 
    public function getall_customer() { 
		return $this->db->select('*')->from('customers')->order_by('c_name','asc')->get()->result_array();
	} 
	public function getall_vechicle() { 
		$this->db->select("vehicles.*,vehicle_group.gr_name");
		$this->db->from('vehicles');
		$this->db->join('vehicle_group', 'vehicles.v_group=vehicle_group.gr_id','LEFT');
		$query = $this->db->get();
		return $query->result_array();
	} 
	public function getall_mybookings($c_id) { 
		return $this->db->select('*')->from('trips')->where('t_customer_id',$c_id)->order_by('t_id','asc')->get()->result_array();
	}
	public function getall_driverlist() { 
		return $this->db->select('*')->from('drivers')->get()->result_array();
	}
	public function getall_trips_expense($t_id) { 
		return $this->db->select('*')->from('trips_expense')->where('e_trip_id',$t_id)->get()->result_array();
	} 
	public function get_paymentdetails($t_id) { 
		return $this->db->select('*')->from('trip_payments')->where('tp_trip_id',$t_id)->get()->result_array();
	}
	
	public function getall_trips($trackingcode=false) { 
		$newtripdata = array();
		if($trackingcode) {
			$tripdata = $this->db->select('*')->from('trips')->where('t_trackingcode',$trackingcode)->order_by('t_id','desc')->get()->result_array();
		} else {
			$tripdata = $this->db->select('*')->from('trips')->order_by('t_id','desc')->get()->result_array();
		}
		if(!empty($tripdata)) {
			foreach ($tripdata as $key => $tripdataval) {
				$newtripdata[$key] = $tripdataval;
				$newtripdata[$key]['t_customer_details'] =  $this->db->select('*')->from('customers')->where('c_id',$tripdataval['t_customer_id'])->get()->row();
				$newtripdata[$key]['t_vechicle_details'] =  $this->db->select('*')->from('vehicles')->where('v_id',$tripdataval['t_vechicle'])->get()->row();
				$newtripdata[$key]['t_driver_details'] =   $this->db->select('*')->from('drivers')->where('d_id',$tripdataval['t_driver'])->get()->row();
			}
			return $newtripdata;
		} else 
		{
			return false;
		}
	}
	public function getaddress($lat,$lng)
	{
	 $google_api_key = $this->config->item('google_api_key'); 
	 $url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$google_api_key.'&latlng='.trim($lat).','.trim($lng).'&sensor=false';
	$json = @file_get_contents($url);
	$data = json_decode($json);
        if (!empty($data)) {
            $status = $data->status;
            if ($status == "OK") {
                return $data->results[1]->formatted_address;
            } else {
                return false;
            }
        } else {
            return '';
        }
    }
	public function get_tripdetails($t_id) { 
		return $this->db->select('*')->from('trips')->where('t_id',$t_id)->get()->result_array();
	}
	public function update_trips($data) { 
		$data['t_start_date'] = reformatDatetime($data['t_start_date']);
		$data['t_end_date'] = reformatDatetime($data['t_end_date']);
		$this->db->where('t_id',$this->input->post('t_id'));
		$this->db->update('trips',$data);
		return $this->input->post('t_id');
	}
	public function trip_reports($from,$to,$v_id) { 
		$newtripdata = array();
		if($v_id=='all') {
			$where = array('t_start_date>='=>$from,'t_start_date<='=>$to);
		} else {
			$where = array('t_start_date>='=>$from,'t_start_date<='=>$to,'t_vechicle'=>$v_id);
		}
		
		$tripdata = $this->db->select('*')->from('trips')->where($where)->order_by('t_id','desc')->get()->result_array();
		if(!empty($tripdata)) {
			foreach ($tripdata as $key => $tripdataval) {
				$newtripdata[$key] = $tripdataval;
				$newtripdata[$key]['t_customer_details'] =  $this->db->select('*')->from('customers')->where('c_id',$tripdataval['t_customer_id'])->get()->row();
				$newtripdata[$key]['t_vechicle_details'] =  $this->db->select('*')->from('vehicles')->where('v_id',$tripdataval['t_vechicle'])->get()->row();
				$newtripdata[$key]['t_driver_details'] =   $this->db->select('*')->from('drivers')->where('d_id',$tripdataval['t_driver'])->get()->row();
			}
			return $newtripdata;
		} else 
		{
			return array();
		}
	}
} 