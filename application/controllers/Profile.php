<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index() {
		$data = array();
		
		// Load the view for this controller
		$data['title'] = "Profile";
		$data['message'] = "This section not yet completed.";
		$this->template->view('errors',$data);
	}
}