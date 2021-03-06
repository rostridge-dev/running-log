<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index() {
		
		$data = array();
		
		// Check to see that we have everything we need to add an entry
		$requirements = $this->checkRequirements();
		if ($requirements['validated']) {
			
			// Count all the active runs for this user
			$query = $this->db->get_where('entries',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
			$data['count'] = $query->num_rows();
			$data['limit'] = 50;
			$data['page'] = 1;
		
			// Load the view for this controller
			$data['title'] = "Entries";
			$js = "";
			$js .= "	<script>\n";
			$js .= "		$(function() {\n";
			$js .= "			$.ajax({url: '".base_url("entries/show/".$data['limit']."/".$data['page'])."', success: function(result){\n";
			$js .= "				$('#entries-list').html(result);\n";
			$js .= "			}});\n";
			$js .= "		});\n";
			$js .= "	</script>\n";
			$data['footer_js'] = $js;
			$this->template->view('entries_all',$data);
			
		} else {
			
			// Load the view for this controller
			$data['title'] = "Entries";
			$data['message'] = $requirements['message'];
			$this->template->view('errors',$data);
		}
	}
	
	/**
	 * Displays a set of rows for a specificed number of entries
	 *
	 */
	public function show($limit=50,$page=1) {
		
		$data = array();
		
		// Grab a list of the entries
		$data = $this->find($limit,$page);
			
		// Load the view for this controller
		$this->load->view('entries_ajax',$data);
			
	}
	
	/**
	 * The add entry method
	 *
	 */
	public function add() {
		
		$ci =& get_instance();
		
		$this->load->model('Entry_model');
		$entry = $this->Entry_model->instance();
	
		// Check to see the form was submitted
		if($this->input->post('action') == 'submit'){
			
			// Assign the validation rules
			$this->setValidation();
		
			// Validate the form
			if ($this->form_validation->run() == TRUE){
				
				$entry->setUserID($this->session->userdata('user_id'));
				$entry->setDate($this->input->post('date'));
				$entry->setTimeOfDay($this->input->post('time_of_day'));
				$entry->setTypeID($this->input->post('type_id'));
				$entry->setRouteID($this->input->post('route_id'));
				$entry->setDistance($this->input->post('distance'));
				$entry->setTime($this->input->post('time'));
				$entry->setShoeID($this->input->post('shoe_id'));
				$entry->setQuality($this->input->post('quality'));
				$entry->setEffort($this->input->post('effort'));
				if ($this->input->post('weather') != NULL) {
					$entry->setWeatherIDs(implode(",",$this->input->post('weather')));
				} else {
					$entry->setWeatherIDs($this->input->post('weather'));
				}
				$entry->setTemperature($this->input->post('temperature'));
				$entry->setNotes($this->input->post('notes'));
				
				if($this->input->post('is_race') == 1){
					$entry->setField($this->input->post('field'));
					$entry->setPlacement($this->input->post('placement'));
					$entry->setGroupMinAge($this->input->post('group_min_age'));
					$entry->setGroupMaxAge($this->input->post('group_max_age'));
					$entry->setGroupAgeSize($this->input->post('group_age_size'));
					$entry->setGroupAgePlacement($this->input->post('group_age_placement'));
					$entry->setGroupGenderSize($this->input->post('group_gender_size'));
					$entry->setGroupGenderPlacement($this->input->post('group_gender_placement'));
				}
			
				$entry->setActive(true);
				$entry->add();
				
				redirect(base_url()."entries");
			}
		}
	
		$data = array();

		// Check to see that we have everything we need to add an entry
		$requirements = $this->checkRequirements();
		if ($requirements['validated']) {	
		
			$data['title'] = "Entries: Add";
			$data['form_action'] = "entries/add";
			$data['entry'] = $entry;
			
			// Get the list of run types
			$data['run_types'] = $this->config->item('run_types');
			
			// Get the list of weather types
			$data['weather_types'] = $this->config->item('weather_types');
			
			// Get the list of active routes
			$routes = $routes_list = array();
			$this->db->order_by('name','ASC');
			$query = $this->db->get_where('routes',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$alias = "routes".$row->id;
					$ci->load->model('Route_model',$alias);
					$routes_list[$row->id] = $ci->{$alias}->load($row->id);
					$routes[$row->id] = $routes_list[$row->id]->getName();
				}
			}
			$data['routes'] = $routes;
			
			// Get the list of shoe manufacturers
			$data['makes'] = $this->config->item('shoe_manufacturers');
			
			// Get the list of active shoes
			$shoes = $shoes_list = array();
			$this->db->order_by('id','DESC');
			$query = $this->db->get_where('shoes',array('retired'=>false,'active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$alias = "shoes".$row->id;
					$ci->load->model('Shoe_model',$alias);
					$shoes_list[$row->id] = $ci->{$alias}->load($row->id);
					$shoes[$row->id] = $data['makes'][$shoes_list[$row->id]->getMakeID()]." ".$shoes_list[$row->id]->getModel();
				}
			}
			$data['shoes'] = $shoes;
			
			// Add some JS for controlling the race portion of the form
			$data['footer_js'] = $this->entryRaceJS();
			
			//load the template view
			$this->template->view('entries_form',$data);
		
		} else {
			
			// Load the view for this controller
			$data['title'] = "Entries";
			$data['message'] = $requirements['message'];
			$this->template->view('errors',$data);
		}
	
	}
	
	/**
	 * The edit entry method
	 *
	 */
	public function edit() {
		
		$ci =& get_instance();
	
		$id = $this->uri->segment(3);
		$this->load->model('Entry_model');
		$entry = $this->Entry_model->load($id);
		
		// Check to see the form was submitted
		if($this->input->post('action') == 'submit'){
			
			// Assign the validation rules
			$this->setValidation();
		
			// Validate the form
			if ($this->form_validation->run() == TRUE){
				
				$entry->setUserID($this->session->userdata('user_id'));
				$entry->setDate($this->input->post('date'));
				$entry->setTimeOfDay($this->input->post('time_of_day'));
				$entry->setTypeID($this->input->post('type_id'));
				$entry->setRouteID($this->input->post('route_id'));
				$entry->setDistance($this->input->post('distance'));
				$entry->setTime($this->input->post('time'));
				$entry->setShoeID($this->input->post('shoe_id'));
				$entry->setQuality($this->input->post('quality'));
				$entry->setEffort($this->input->post('effort'));
				if ($this->input->post('weather') != NULL) {
					$entry->setWeatherIDs(implode(",",$this->input->post('weather')));
				} else {
					$entry->setWeatherIDs($this->input->post('weather'));
				}
				$entry->setTemperature($this->input->post('temperature'));
				$entry->setNotes($this->input->post('notes'));
				
				if($this->input->post('is_race') == 1){
					$entry->setField($this->input->post('field'));
					$entry->setPlacement($this->input->post('placement'));
					$entry->setGroupMinAge($this->input->post('group_min_age'));
					$entry->setGroupMaxAge($this->input->post('group_max_age'));
					$entry->setGroupAgeSize($this->input->post('group_age_size'));
					$entry->setGroupAgePlacement($this->input->post('group_age_placement'));
					$entry->setGroupGenderSize($this->input->post('group_gender_size'));
					$entry->setGroupGenderPlacement($this->input->post('group_gender_placement'));
				}
				
				$entry->edit();
				
				redirect(base_url()."entries");
			}
		}
		
		$data = array();		
		$data['title'] = "Entries: Edit";
		$data['form_action'] = "entries/edit/".$id;
		$data['entry'] = $entry;
		
		// Get the list of run types
		$data['run_types'] = $this->config->item('run_types');
		
		// Get the list of weather types
		$data['weather_types'] = $this->config->item('weather_types');
		
		// Get the list of active routes
		$routes = $routes_list = array();
		$this->db->order_by('name','ASC');
		$query = $this->db->get_where('routes',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$alias = "routes".$row->id;
				$ci->load->model('Route_model',$alias);
				$routes_list[$row->id] = $ci->{$alias}->load($row->id);
				$routes[$row->id] = $routes_list[$row->id]->getName();
			}
		}
		$data['routes'] = $routes;
		
		// Get the list of shoe manufacturers
		$data['makes'] = $this->config->item('shoe_manufacturers');
		
		// Get the list of active shoes
		$shoes = $shoes_list = array();
		$this->db->order_by('id','DESC');
		$query = $this->db->get_where('shoes',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$alias = "shoes".$row->id;
				$ci->load->model('Shoe_model',$alias);
				$shoes_list[$row->id] = $ci->{$alias}->load($row->id);
				$retiredLabel = "";
				if ($row->retired == true) {
					$retiredLabel = "(Retired) ";
				}
				$shoes[$row->id] = $retiredLabel.$data['makes'][$shoes_list[$row->id]->getMakeID()]." ".$shoes_list[$row->id]->getModel();
			}
		}
		$data['shoes'] = $shoes;
		
		// Add some JS for controlling the race portion of the form
		$data['footer_js'] = $this->entryRaceJS();
		
		//load the template view
		$this->template->view('entries_form',$data);
		
	}
	
	/**
	 * Delete for this controller
	 *
	 */
	public function delete() {
		
		$id = $this->uri->segment(3);
		$this->load->model('Entry_model');
		$entry = $this->Entry_model->load($id);
		
		// Make sure the current user is deleting their own routes
		$user_id = $this->session->userdata('user_id');
		if ($user_id == $entry->getUserID()) {
			$entry->delete();
		}		
		redirect(base_url()."entries");
		
		
	}
	
	/**
	 * Returns the JS required for the race component of the forms
	 *
	 */
	private function entryRaceJS() {
		
		$js = "<script>\n";
		$js .= "	$(function() {\n";
		$js .= "		if ($('#is_race').val() == 1) {\n";
		$js .= "			$('#race-data').show();\n";
		$js .= "		} else {\n";
		$js .= "			$('#race-data').hide();\n";
		$js .= "		}\n";
		$js .= "		$('#type_id').change(function() {\n";
		$js .= "			if ($('#type_id').val() == true) {\n";
		$js .= "				$('#race-data').show();\n";
		$js .= "				$('#is_race').val(1);\n";
		$js .= "			} else {;\n";
		$js .= "				$('#race-data').hide();\n";
		$js .= "				$('#is_race').val(0);\n";
		$js .= "			};\n";
		$js .= "		});\n";
		$js .= "	});\n";
		$js .= "</script>\n";
		
		return $js;
		
	}
	
	/**
	 * Sets up the common form validation for the add and edit controllers
	 *
	 */
	private function setValidation() {
		
		// Load the form validation library
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="bg-danger"><p class="text-danger">&nbsp;<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> ','</p></div>');
	
		// Assign validation rules
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('time_of_day', 'Time of day', 'required');
		$this->form_validation->set_rules('type_id', 'Run type', 'required|integer');
		$this->form_validation->set_rules('route_id', 'Route', 'required|integer');
		$this->form_validation->set_rules('shoe_id', 'Shoe', 'required|integer');
		$this->form_validation->set_rules('distance', 'Distance', 'required|numeric');
		$this->form_validation->set_rules('time', 'Time', 'required');
		$this->form_validation->set_rules('quality', 'Quality', 'integer');
		$this->form_validation->set_rules('effort', 'Effort', 'integer');
		$this->form_validation->set_rules('temperature', 'Temperature', 'integer');
		
		if($this->input->post('is_race') == 1){
			$this->form_validation->set_rules('placement', 'Overall position', 'required|integer');
			$this->form_validation->set_rules('field', 'Size of field', 'required|integer');
			$this->form_validation->set_rules('group_min_age', 'Age group min', 'integer');
			$this->form_validation->set_rules('group_max_age', 'Age group max', 'integer');
			$this->form_validation->set_rules('group_age_placement', 'Age group placement', 'integer');
			$this->form_validation->set_rules('group_age_size', 'Age group size', 'integer');
			$this->form_validation->set_rules('group_gender_placement', 'Gender group placement', 'integer');
			$this->form_validation->set_rules('group_gender_size', 'Gender group size', 'integer');
		}
		
	}
	
	/**
	 * Checks to see if we can view, add, edit entries; must have at least one route AND one shoe in the system
	 *
	 */
	private function checkRequirements() {
		
		$requirements = array();
		$requirements['validated'] = true;
		$requirements['message'] = "OK";
		
		// Check to see if any routes have been added
		$query = $this->db->get_where('routes',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
		if ($query->num_rows() == 0) {
			$requirements['validated'] = false;
			$requirements['message'] = "There are no routes entered into the system. Please add at least one route before adding an entry.";
		}
		
		// Check to see if any shoes have been added
		$query = $this->db->get_where('shoes',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
		if ($query->num_rows() == 0) {
			$requirements['validated'] = false;
			$requirements['message'] = "There are no shoes entered into the system. Please add at least one shoe before adding an entry.";
		}
		
		return $requirements;
		
	}
	
	/**
	 * Loads a data list of entries based upon a limit and pagination value (offset repeats based upon initial limit)
	 *
 	 * @param integer $limit The number of entries to be returned in this list
	 * @param integer $page The current page of results to be returned (starting at an offset based upon limit)
	 * @return array $data An array containing all the data related to this list
	 */
	private function find($limit=0,$page=1) {
		
		$ci =& get_instance();
		$data = array();
		
		$data['limit'] = $limit;
		$data['page'] = $page;
		$data['offset'] = ($page - 1) * $limit;
		
		$query = $this->db->get_where('entries',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
		$data['count'] = $query->num_rows();
		
		// Get the list of run types
		$data['run_types'] = $this->config->item('run_types');
		
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
			
		// Get the list of active entries
		$entries = array();
		$this->db->order_by('date','DESC');
		if (($data['limit'] > 0) && ($data['offset'] == 0)) {
			$this->db->limit($data['limit']);
		}
		if (($data['limit'] > 0) && ($data['offset'] > 0)) {
			$this->db->limit($data['limit'],$data['offset']);
		}
		$query = $this->db->get_where('entries',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$alias = "entries".$row->id;
				$ci->load->model('Entry_model',$alias);
				$entries[$row->id] = $ci->{$alias}->load($row->id);
			}
		}
		$data['entries'] = $entries;
		
		return $data;
	}
}