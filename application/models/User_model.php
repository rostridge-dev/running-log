<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {
	
	/**
	 * The table name for this model
	 *
	 * @var string
	 */
	protected $_table = "users";
	
	/**
	 * The username of this user
	 *
	 * @var string
	 */
	protected $_username;
	
	/**
	 * The first name of this user
	 *
	 * @var string
	 */
	protected $_firstname;
	
	/**
	 * The last name of this user
	 *
	 * @var string
	 */
	protected $_lastname;
	
	/**
	 * The active status of this user
	 *
	 * @var string
	 */
	protected $_active;

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Loads the user
	 *
	 * @param string $id The ID of the user to be loaded
 	 * @param boolean $active Whether the user is active or not
	 * @return object $this Returns a copy of the user object or false if not found
	 */
	public function load($id,$active=true) {
	
		$query = $this->db->get_where($this->_table,array('id'=>$id,'active'=>$active));
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$this->_id = $row->id;
				$this->_username = $row->username;
				$this->_firstname = $row->firstname;
				$this->_lastname = $row->lastname;
				$this->_active = $row->active;
			}
			return $this;
		} else {
			return false;
		}
	
	}
	
	/**
	 * Authenticate the user
	 *
	 * @param string $username The username to authenticate
	 * @param string $password The password for the selected user
	 * @return boolean $authenticated
	 */
	public function authenticate ($username,$password) {
		
		$authenticated = false;
		
		$query = $this->db->get_where($this->_table,array('username'=>$username,'password'=>$password,'active'=>true));
		foreach ($query->result() as $row) {
			$authenticated = $row->id;
		}
		
		return $authenticated;
		
	}
	
	/**
	 * Get the first name for the user
	 *
	 * @return string
	 */
	public function getFirstname() {
		return $this->_firstname;
	}
	
	/**
	 * Get the first name for the user
	 *
	 * @return string
	 */
	public function getLastname() {
		return $this->_lastname;
	}

}