<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Times {
	
	/**
	 * Return the summed time for a run for a specific user, between two dates if desired (includes the end dates)
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
 	 * @param integer $type The type of entry to be located (easy, long, etc)
	 * @return number $time Returns the total time calculated between the two dates
	 */
    public function returnTimeTotal($user_id,$start=NULL,$end=NULL,$type=NULL) {
		
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
		$query = $CI->db->get('entries');
		
		$time_in_seconds = 0;
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$time_in_seconds += $this->convertToSeconds($row->time);
			}
		}
		
		$time = $this->convertToRunningTime($time_in_seconds);
		
		return $time;
		
	}
	
	/**
	 * Converts running log times to seconds so that math can be performed
	 *
 	 * @param string $time The time in format HH:MM:SS
	 * @return integer $seconds Returns the total time in seconds
	 */
	public function convertToSeconds($time) {
		$segments = explode(':',$time);
		$length = count($segments);
		switch ($length) {
			case 3:
				$seconds = $segments[0] * 3600 + $segments[1] * 60 + $segments[2];
				break;
			case 2:
				$seconds = $segments[0] * 60 + $segments[1];
				break;
			case 1:
				$seconds = $segments[0];
				break;
			default:
				$seconds = 0;
				break;
		}
		
		return $seconds;
	}
	
	/**
	 * Converts times expressed in seconds to the format HH:MM:SS (with leading days if necessary)
	 *
 	 * @param integer $seconds The time in seconds
	 * @return integer $time Returns the total time in the format HH:MM:SS (with leading days if necessary)
	 */
	private function convertToRunningTime($seconds) {
		if ($seconds != 0) {
			$days = floor($seconds / 86400);
			$hours = sprintf('%02d',round(floor(($seconds - ($days * 86400)) / 3600)));
			$minutes = sprintf('%02d',round(floor(($seconds - ($hours * 3600) - ($days * 86400))/60)));
			$seconds = sprintf('%02d',round(($seconds - ($minutes * 60) - ($hours * 3600) - ($days * 86400))));
			$outputdays = "";
			if ($days > 0) {
				$outputdays = $days." days ";
			}
			$time = $outputdays.$hours.":".$minutes.":".$seconds;
		} else {
			$time = "00:00:00";
		}
		
		return $time;
	}

}