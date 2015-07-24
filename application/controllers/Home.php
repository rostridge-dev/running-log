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
		$data['firstname'] = $this->session->userdata('firstname');
		$data['lastname'] = $this->session->userdata('lastname');
		
		// Load the Flot library
		$this->load->library('flot');
		
		// Load the view for this controller
		$data['title'] = "Home";
		$data['footer_js'] = $this->flot->returnJS();
		$this->template->view('home',$data);
	}
}