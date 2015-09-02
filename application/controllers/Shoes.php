<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shoes extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index() {
		
		$ci =& get_instance();
		
		$data = array();
		
		// Get the list of shoe manufactureres
		$data['manufacturers'] = $this->config->item('shoe_manufacturers');
		
		// Get the list of active shoes
		$shoes = array();
		$this->db->order_by('purchase_date','DESC');
		$query = $this->db->get_where('shoes',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id')));
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$alias = "shoes".$row->id;
				$ci->load->model('Shoe_model',$alias);
				$shoes[$row->id] = $ci->{$alias}->load($row->id);
				$this->db->select_sum('distance');
				// Add in the total mileage at runtime
				$subquery = $this->db->get_where('entries',array('active'=>true,'deleted'=>NULL,'shoe_id'=>$row->id,'user_id'=>$this->session->userdata('user_id')));
				foreach ($subquery->result() as $subrow) {
					$shoes[$row->id]->setMileage(number_format((float)$subrow->distance,0,'.',''));
				}
			}
		}
		$data['shoes'] = $shoes;
		
		// Load the view for this controller
		$data['title'] = "Shoes";
		$this->template->view('shoes_all',$data);
	}
	
	/**
	 * The add shoe method
	 *
	 */
	public function add() {
		
		$this->load->model('Shoe_model');
		$shoe = $this->Shoe_model->instance();
	
		// Check to see the form was submitted
		if($this->input->post('action') == 'submit'){
		
			// Load the form validation library
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="bg-danger"><p class="text-danger">&nbsp;<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> ','</p></div>');
		
			// Assign validation rules
			$this->form_validation->set_rules('make_id', 'Make', 'required|integer');
			$this->form_validation->set_rules('model', 'Model', 'required');
			$this->form_validation->set_rules('purchase_date', 'Purchase Date', 'required');
			$this->form_validation->set_rules('price', 'Price', 'required|integer');
		
			// Validate the form
			if ($this->form_validation->run() == TRUE){
				
				$shoe->setUserID($this->session->userdata('user_id'));
				$shoe->setMakeID($this->input->post('make_id'));
				$shoe->setModel($this->input->post('model'));
				$shoe->setPurchaseDate($this->input->post('purchase_date'));
				$shoe->setPrice($this->input->post('price'));
				if ($this->input->post('retired') == null) {
					$shoe->setRetired(0);
				} else {
					$shoe->setRetired($this->input->post('retired'));
				}
				$shoe->setActive(true);
				$shoe->add();
				
				redirect(base_url()."shoes");
			}
		}
	
		$data = array();		
		$data['title'] = "Shoes: Add";
		$data['form_action'] = "shoes/add";
		$data['shoe'] = $shoe;
		
		// Get the list of shoe manufacturers
		$data['makes'] = $this->config->item('shoe_manufacturers');
		
		//load the template view
		$this->template->view('shoes_form',$data);
	
	}
	
	/**
	 * The edit shoe method
	 *
	 */
	public function edit() {
	
		$id = $this->uri->segment(3);
		$this->load->model('Shoe_model');
		$shoe = $this->Shoe_model->load($id);
		
		// Check to see the form was submitted
		if($this->input->post('action') == 'submit'){
		
			// Load the form validation library
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="bg-danger"><p class="text-danger">&nbsp;<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> ','</p></div>');
		
			// Assign validation rules
			$this->form_validation->set_rules('make_id', 'Make', 'required|integer');
			$this->form_validation->set_rules('model', 'Model', 'required');
			$this->form_validation->set_rules('purchase_date', 'Purchase Date', 'required');
			$this->form_validation->set_rules('price', 'Price', 'required|integer');
		
			// Validate the form
			if ($this->form_validation->run() == TRUE){
				
				if ($shoe->getUserID() == $this->session->userdata('user_id')) {
					$shoe->setMakeID($this->input->post('make_id'));
					$shoe->setModel($this->input->post('model'));
					$shoe->setPurchaseDate($this->input->post('purchase_date'));
					$shoe->setPrice($this->input->post('price'));
					if ($this->input->post('retired') == null) {
						$shoe->setRetired(0);
					} else {
						$shoe->setRetired($this->input->post('retired'));
					}
					$shoe->edit();
				}
				
				redirect(base_url()."shoes");
			}
		}
		
		$data = array();		
		$data['title'] = "Shoes: Edit";
		$data['form_action'] = "shoes/edit/".$id;
		$data['shoe'] = $shoe;
		
		// Get the list of shoe manufacturers
		$data['makes'] = $this->config->item('shoe_manufacturers');
		
		//load the template view
		$this->template->view('shoes_form',$data);
		
	}
	
	/**
	 * Delete for this controller
	 *
	 */
	public function delete() {
		
		$id = $this->uri->segment(3);
		$this->load->model('Shoe_model');
		$shoe = $this->Shoe_model->load($id);
		
		// Make sure the current user is deleting their own shoes
		$user_id = $this->session->userdata('user_id');
		if ($user_id == $shoe->getUserID()) {
			$shoe->delete();
		}		
		redirect(base_url()."shoes");
		
		
	}
}