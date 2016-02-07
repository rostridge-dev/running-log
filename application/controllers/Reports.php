<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index() {
		
		$this->load->model('Report_model');
		$report = $this->Report_model->instance();
		
		// Get the list of run types
		$data['run_types'] = $this->insertEmptyIndex($this->config->item('run_types'));
		
		$data['report'] = $report;
		$data['form_action'] = "reports/results";
		
		// Load the view for this controller
		$data['title'] = "Reports";
		$data['footer_js'] = $this->returnFooterJS();
		$this->template->view('reports_form',$data);
	}
	
	/**
	 * The report results method
	 *
	 */
	public function results() {
		
		$ci =& get_instance();
		
		$this->load->model('Report_model');
		$report = $this->Report_model->instance();
		
		// Get the list of run types
		$data['run_types'] = $this->insertEmptyIndex($this->config->item('run_types'));
		
		// Check to see the form was submitted
		if($this->input->post('action') == 'submit'){
		
			$report->setUserID($this->session->userdata('user_id'));
			$report->setStartDate($this->input->post('start_date'));
			$report->setEndDate($this->input->post('end_date'));
			$report->setTypeID($this->input->post('type_id'));
				
			$results = $report->find();
			$data['results'] = $results;
			
			if (!empty($results['entries'])) {
				
				// Get the list of active routes
				$routes = array();
				$this->db->order_by('name','ASC');
				$query = $this->db->get_where('routes',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$alias = "routes".$row->id;
						$ci->load->model('Route_model',$alias);
						$routes[$row->id] = $ci->{$alias}->load($row->id);
					}
				}
				$data['routes'] = $routes;
			}
			
		}
		
		$data['report'] = $report;
		$data['form_action'] = "reports/results";
		
		// Load the view for this controller
		$data['title'] = "Reports";
		$data['footer_js'] = $this->returnFooterJS();
		$this->template->view('reports_form',$data);
		
	}
	
	private function returnFooterJS() {
		$js = "";
		
		$js .= "<script>\n";
		$js .= "$(function() {\n";
		$js .= "	$('#start_date').datepicker().on('changeDate', function(e) {\n";
        $js .= "			$('#end_date').datepicker('setDate',e.date);\n";
        $js .= "		});\n";
        $js .= "});\n";
		$js .= "</script>\n";
		
		return $js;
		
	}
	
	private function insertEmptyIndex($array) {
		$array[NULL] = "";
		ksort($array);
		return $array;
	}
}