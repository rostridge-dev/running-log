<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timeline extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{
		$data = array();
		
		// Load the required libraries
		$this->load->library('badges');
		
		// Get the min and max dates for all active entries for this user
		$entries = array();
		$dates_found = false;
		$this->db->select_max('date','max_date');
		$this->db->select_min('date','min_date');
		$query = $this->db->get_where('entries',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if (!empty($row->max_date) && !empty($row->min_date)) {
					$dates_found = true;
					$max_date = DateTime::createFromFormat("Y-m-d",$row->max_date);
					$max_year =$max_date->format("Y");
					$min_date = DateTime::createFromFormat("Y-m-d",$row->min_date);
					$min_year =$min_date->format("Y");
				}
			}
			
			// Organize all the years we'll need to search for badges
			if ($dates_found == true) {
				$years = array();
				for ($counter = $min_year; $counter <= $max_year; $counter++) {
					$years[] = $counter;
				}
				$years = array_reverse($years);
				
				// Find all the badges
				foreach ($years as $year) {
					if ($this->badges->returnBadgeQualification($this->session->userdata('user_id'),$year)) {
						$data['badges'][$year] = $this->badges->returnBadgesForYear($this->session->userdata('user_id'),$year);
					} else {
						$data['badges'][$year] = array();
					}
				}
			}
		}
		
		// Load the view for this controller
		$data['title'] = "Timeline";
		$this->template->view('timeline',$data);
	}
	
}