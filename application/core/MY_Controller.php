<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 */
class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		// All pages using this class are secured; the session must be logged in
		if (!$this->session->userdata('logged_in')) {
			redirect(base_url());
		}
	}
}