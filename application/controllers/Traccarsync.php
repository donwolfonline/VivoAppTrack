<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class Traccarsync extends REST_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('api_model');
        $this->load->model('geofence_model');

    }  
    public function index_get()     
    {
        $allvech = $this->db->select('v_traccar_id,v_id')->from('vehicles')->where(array('v_is_active'=>'1','v_traccar_id!='=>''))->get()->result_array();
        $futureDate = strtotime(date("Y-m-d H:i:s"))+(60*5);
        $after5mins = $this->toUTC(date("Y-m-d H:i:s", $futureDate));
        $currenttime = $this->toUTC(date("Y-m-d 00:00:00"));
        if(!empty($allvech)) {
            foreach ($allvech as $key => $vech) {
                $apicall = json_decode(traccar_call('api/positions?deviceId='.$vech['v_traccar_id'].'&from='.$currenttime.'&to='.$after5mins,'','GET'),true);
                if(is_array($apicall)) {
                    foreach ($apicall as $key => $tdata) {
                        $this->db->select('traccar_pos_id');
                        $this->db->where('traccar_pos_id',$tdata['id']);
                        $query = $this->db->get('positions');
                        $num = $query->num_rows();
                        if($num==0) {
                            $insert = array('time' => date('Y-m-d H:i:s', strtotime($tdata['deviceTime'])),'v_id' => $vech['v_id'],'latitude' => $tdata['latitude'],'longitude' => $tdata['longitude'],'altitude' => $tdata['altitude'],'speed' => $tdata['speed'],'bearing' => $tdata['longitude'],'accuracy' => $tdata['course'],'provider' => $tdata['protocol'],'comment' => NULL,'traccar_pos_id' => $tdata['id'],'battery_level'=>isset($tdata['attributes']['batteryLevel'])?$tdata['attributes']['batteryLevel']:'','motion'=>isset($tdata['attributes']['motion'])?$tdata['attributes']['motion']:'','address'=>$tdata['address']);
                            $this->db->insert('positions',$insert);
                           
                            $this->checkgeofence($vech['v_id'],$tdata['latitude'],$tdata['longitude']);
                            echo 'Synced<br>';
                        } else {
                            echo 'Already sync done<br>';
                        }
                    }
                } else {
                    echo 'No data';
                }
            }
        } else {
            echo 'No vehicles';
        }
    }

    function toUTC($dateTime){
        $dt = new DateTime($dateTime, new DateTimeZone(date_default_timezone_get()));
        $dt->setTimezone(new DateTimeZone('UTC'));
        $utcTime = $dt->format('Y-m-d H:i:s');
        $returnObject = new DateTime($utcTime);
        $returnIso = substr($returnObject->format(DateTime::ATOM), 0, -6) . '.000Z';
        return $returnIso;
    }
    
    public function checkgeofence($vid,$lat,$log)     
    { 
        $vgeofence = $this->geofence_model->getvechicle_geofence($vid);
        if(!empty($vgeofence)) {
            $points = array("$lat $log");
            foreach($vgeofence as $geofencedata) {
                $lastgeo = explode(" ,",$geofencedata['geo_area']);
                $polygon = $geofencedata['geo_area'].$lastgeo[0];
                $polygondata = explode(' , ',$polygon);
                foreach($polygondata as $polygoncln) {
                    $geopolygondata[] = str_replace("," , ' ',$polygoncln); 
                }
                foreach($points as $key => $point) {
                    $geocheck = pointInPolygon($point, $geopolygondata,false);
                    if($geocheck=='outside' || $geocheck=='boundary' || $geocheck=='inside') {
                        $wharray = array('ge_v_id' => $vid, 'ge_geo_id' => $geofencedata['geo_id'], 'ge_event' => $geocheck,
                            'DATE(ge_timestamp)'=>date('Y-m-d'));
                        $geofence_events = $this->db->select('*')->from('geofence_events')->where($wharray)->get()->result_array();
                       
                        if(count($geofence_events)==0) {
                            $insertarray = array('ge_v_id'=>$vid,'ge_geo_id'=>$geofencedata['geo_id'],'ge_event'=>$geocheck,'ge_timestamp'=>
                                       date('Y-m-d h:i:s'));
                            $this->db->insert('geofence_events',$insertarray);
                        } 
                    }
                }
            }
        }
        
    }

}
