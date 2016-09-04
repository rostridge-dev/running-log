<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distances {
	
	/**
	 * Return the distance run for a specific user, between two dates if desired (includes the end dates)
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
 	 * @param integer $type The type of entry to be located (easy, long, etc)
 	 * @param integer $route The route for the entry
	 * @return number $distance Returns the distance calculated between the two dates
	 */
    public function returnDistanceTotal($user_id,$start=NULL,$end=NULL,$type=NULL,$route=NULL) {
		
		$CI =& get_instance();
		
		$CI->db->where('user_id',$user_id);
		$CI->db->where('active',1);
		$CI->db->where('deleted',NULL);
		if (($start != NULL) || ($start != "")) {
			$CI->db->where('date >= ',$start);
		}
		if (($end != NULL) || ($end != "")) {
			$CI->db->where('date <=',$end);
		}
		if (($type != NULL) || ($type != "")) {
			$CI->db->where('type_id = ',$type);
		}
		if (($route != NULL) || ($route != "")) {
			$CI->db->where('route_id = ',$route);
		}
		$CI->db->select_sum('distance');
		$query = $CI->db->get('entries');
		
		$distance = 0;
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$distance = number_format((float)$row->distance,0,'.','');
			}
		}
				
		return $distance;
		
	}
	
	/**
	 * Return the list of running entry objects for the date specified
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
 	 * @param integer $type The type of entry to be located (easy, long, etc)
 	 * @param integer $route The route for the entry
	 * @return number $distance Returns the distance calculated between the two dates
	 */
    public function returnDistanceList($user_id,$start=NULL,$end=NULL,$type=NULL,$route=NULL) {
		
		$CI =& get_instance();
		
		$CI->db->order_by('date','DESC');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('active',1);
		$CI->db->where('deleted',NULL);
		if (($start != NULL) || ($start != "")) {
			$CI->db->where('date >= ',$start);
		}
		if (($end != NULL) || ($end != "")) {
			$CI->db->where('date <=',$end);
		}
		if (($type != NULL) || ($type != "")) {
			$CI->db->where('type_id = ',$type);
		}
		if (($route != NULL) || ($route != "")) {
			$CI->db->where('route_id = ',$route);
		}
		$query = $CI->db->get('entries');

		$entries = array();
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$alias = "entries".$row->id;
				$CI->load->model('Entry_model',$alias);
				$entries[$row->id] = $CI->{$alias}->load($row->id);
			}
		}
		
		return $entries;
		
	}

}