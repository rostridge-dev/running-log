<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends MY_Model {
	
	/**
	 * The user associated to the report
	 *
	 * @var integer
	 */
	protected $_user_id;
	
	/**
	 * The start date of the report (YYYY-MM-DD)
	 *
	 * @var string
	 */
	protected $_start_date;
	
	/**
	 * The end date of the report (YYYY-MM-DD)
	 *
	 * @var string
	 */
	protected $_end_date;
	
	/**
	 * The type ID of the report (easy, long, etc)
	 *
	 * @var integer
	 */
	protected $_type_id;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Loads an empty instance of the entry model
	 *
	 */
	public function instance() {
	
		return $this;
	
	}
	
	/**
	 * Return the list of running entry objects for the criteria specified
	 *
	 */
	public function find() {
		
		$CI =& get_instance();
		
		// Load the distance and time libraries
		$CI->load->library('distances');
		$CI->load->library('times');
		
		$results = array();
		$results['count'] = NULL;
		$results['distance'] = NULL;
		$results['time'] = NULL;
		$results['entries'] = array();
		
		$results['distance'] = $CI->distances->returnDistanceTotal($this->_user_id,$this->_start_date,$this->_end_date,$this->_type_id);
		$results['time'] = $CI->times->returnTimeTotal($this->_user_id,$this->_start_date,$this->_end_date,$this->_type_id);
		$results['entries'] = $CI->distances->returnDistanceList($this->_user_id,$this->_start_date,$this->_end_date,$this->_type_id);
		$results['count'] = count($results['entries']);
		
		return $results;
	}
	
	/**
	 * Get the userID for the report
	 *
	 * @return string
	 */
	public function getUserID() {
		return $this->_user_id;
	}
	
	/**
	 * Set the userID for the report
	 *
	 * @param integer $value The userID of the report
	 */
	public function setUserID($value) {
		$this->_user_id = $value;
	}
	
	/**
	 * Get the start date for the report
	 *
	 * @return string
	 */
	public function getStartDate() {
		return $this->_start_date;
	}
	
	/**
	 * Set the start date for the report
	 *
	 * @param string $value The start date of the report
	 */
	public function setStartDate($value) {
		$this->_start_date = $value;
	}
	
	/**
	 * Get the end date for the report
	 *
	 * @return string
	 */
	public function getEndDate() {
		return $this->_end_date;
	}
	
	/**
	 * Set the end date for the report
	 *
	 * @param string $value The end date of the report
	 */
	public function setEndDate($value) {
		$this->_end_date = $value;
	}
	
	/**
	 * Get the type ID for the report
	 *
	 * @return integer
	 */
	public function getTypeID() {
		return $this->_type_id;
	}
	
	/**
	 * Set the type ID for the report
	 *
	 * @param integer $value The type ID of the report
	 */
	public function setTypeID($value) {
		$this->_type_id = $value;
	}
}