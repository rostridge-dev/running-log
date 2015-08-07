<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routes extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index() {
		
		$ci =& get_instance();
		
		$data = array();
		
		// Get the list of route types
		$data['route_types'] = $this->config->item('route_types');
		$data['route_surface_types'] = $this->config->item('route_surface_types');
		
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
		
		// Load the view for this controller
		$data['title'] = "Routes";
		$this->template->view('routes_all',$data);
	}
	
	/**
	 * The add route method
	 *
	 */
	public function add() {
		
		$this->load->model('Route_model');
		$route = $this->Route_model->instance();
	
		// Check to see the form was submitted
		if($this->input->post('action') == 'submit'){
		
			// Load the form validation library
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="bg-danger"><p class="text-danger">&nbsp;<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> ','</p></div>');
		
			// Assign validation rules
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('distance', 'Distance', 'required');
			$this->form_validation->set_rules('surface_id', 'Surface', 'required|integer');
			$this->form_validation->set_rules('type_id', 'Type', 'required|integer');
		
			// Validate the form
			if ($this->form_validation->run() == TRUE){
				
				$route->setUserID($this->session->userdata('user_id'));
				$route->setName($this->input->post('name'));
				$route->setDistance($this->input->post('distance'));
				$route->setSurfaceID($this->input->post('surface_id'));
				$route->setTypeID($this->input->post('type_id'));
				$route->setActive(true);
				$route->add();
				
				redirect(base_url()."routes");
			}
		}
	
		$data = array();		
		$data['title'] = "Routes: Add";
		$data['form_action'] = "routes/add";
		$data['route'] = $route;
		
		// Get the list of route types
		$data['route_types'] = $this->config->item('route_types');
		$data['route_surface_types'] = $this->config->item('route_surface_types');
		
		//load the template view
		$this->template->view('routes_form',$data);
	
	}
	
	/**
	 * The edit route method
	 *
	 */
	public function edit() {
	
		$id = $this->uri->segment(3);
		$this->load->model('Route_model');
		$route = $this->Route_model->load($id);
		
		// Check to see the form was submitted
		if($this->input->post('action') == 'submit'){
		
			// Load the form validation library
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="bg-danger"><p class="text-danger">&nbsp;<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> ','</p></div>');
		
			// Assign validation rules
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('distance', 'Distance', 'required');
			$this->form_validation->set_rules('surface_id', 'Surface', 'required|integer');
			$this->form_validation->set_rules('type_id', 'Type', 'required|integer');
		
			// Validate the form
			if ($this->form_validation->run() == TRUE){
				
				if ($route->getUserID() == $this->session->userdata('user_id')) {
					$route->setName($this->input->post('name'));
					$route->setDistance($this->input->post('distance'));
					$route->setSurfaceID($this->input->post('surface_id'));
					$route->setTypeID($this->input->post('type_id'));
					$route->edit();
				}
				
				redirect(base_url()."routes");
			}
		}
		
		$data = array();		
		$data['title'] = "Routes: Edit";
		$data['form_action'] = "routes/edit/".$id;
		$data['route'] = $route;
		
		// Get the list of route types
		$data['route_types'] = $this->config->item('route_types');
		$data['route_surface_types'] = $this->config->item('route_surface_types');
		
		//load the template view
		$this->template->view('routes_form',$data);
		
	}
	
	/**
	 * Delete for this controller
	 *
	 */
	public function delete() {
		
		$id = $this->uri->segment(3);
		$this->load->model('Route_model');
		$route = $this->Route_model->load($id);
		
		// Make sure the current user is deleting their own routes
		$user_id = $this->session->userdata('user_id');
		if ($user_id == $route->getUserID()) {
			$route->delete();
		}		
		redirect(base_url()."routes");
		
		
	}
}