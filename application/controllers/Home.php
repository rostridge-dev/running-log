<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{
		$data = array();
		
		// Load the distance and time libraries
		$this->load->library('distances');
		$this->load->library('times');
		$this->load->library('dates');
		
		// Grab some dashboard stats for the current year and forever
		$data['current_year'] = date("Y");
		$dates_current_year = $this->dates->returnCurrentYear();
		$data['distance_overall_total'] = $this->distances->returnDistanceTotal($this->session->userdata('user_id'));
		$data['time_overall_total'] = $this->times->returnTimeTotal($this->session->userdata('user_id'));
		$data['distance_overall_year'] = $this->distances->returnDistanceTotal($this->session->userdata('user_id'),$dates_current_year['start'],$dates_current_year['end']);
		$data['time_overall_year'] = $this->times->returnTimeTotal($this->session->userdata('user_id'),$dates_current_year['start'],$dates_current_year['end']);
		
		// Grab the data for the last six months
		$data_last_six_months = array();
		$dates_last_six_months = $this->dates->returnPreviousMonths(6);
		foreach($dates_last_six_months as $dates_months) {
			$data_last_six_months[date("M Y",strtotime($dates_months['start']))]['distance'] = $this->distances->returnDistanceTotal($this->session->userdata('user_id'),$dates_months['start'],$dates_months['end']);
			$data_last_six_months[date("M Y",strtotime($dates_months['start']))]['time'] = $this->times->returnTimeTotal($this->session->userdata('user_id'),$dates_months['start'],$dates_months['end']);
		}
		$data['data_last_six_months'] = $data_last_six_months;
		
		// Grab the data for the last six weeks
		$data_last_six_weeks = array();
		$dates_last_six_weeks = $this->dates->returnPreviousWeeks(6);
		foreach($dates_last_six_weeks as $dates_weeks) {
			$data_last_six_weeks[date("M j, Y",strtotime($dates_weeks['start'])).' - '.date("M j, Y",strtotime($dates_weeks['end']))]['distance'] = $this->distances->returnDistanceTotal($this->session->userdata('user_id'),$dates_weeks['start'],$dates_weeks['end']);
			$data_last_six_weeks[date("M j, Y",strtotime($dates_weeks['start'])).' - '.date("M j, Y",strtotime($dates_weeks['end']))]['time'] = $this->times->returnTimeTotal($this->session->userdata('user_id'),$dates_weeks['start'],$dates_weeks['end']);
		}
		$data['data_last_six_weeks'] = $data_last_six_weeks;
		
		// Load the Flot library
		$this->load->library('flot');
		
		// Grab the data for the last two weeks to graph
		$today = date("Y-m-d");
		$two_weeks_ago = date("Y-m-d",strtotime($today." -2 weeks"));
		$two_weeks_list = $this->distances->returnDistanceList($this->session->userdata('user_id'),$two_weeks_ago,$today);
		$graph_data = $this->flot->buildDailyGraph($two_weeks_list);
		
		// Load the view for this controller
		$data['title'] = "Home";
		$data['footer_js'] = $this->flot->returnFooterJS().$this->flot->returnFrontPageInit($graph_data,$two_weeks_ago,$today);
		$this->template->view('home',$data);
	}
}