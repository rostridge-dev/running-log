<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shoe_model extends MY_Model {
	
	/**
	 * The table name for this model
	 *
	 * @var string
	 */
	protected $_table = "shoes";
	
	/**
	 * The user associated to the shoe
	 *
	 * @var integer
	 */
	protected $_user_id;
	
	/**
	 * The make of the shoe
	 *
	 * @var string
	 */
	protected $_make_id;
	
	/**
	 * The model of the shoe
	 *
	 * @var string
	 */
	protected $_model;
	
	/**
	 * The purchase date of the shoe
	 *
	 * @var string
	 */
	protected $_purchase_date;
	
	/**
	 * The price of the shoe
	 *
	 * @var number
	 */
	protected $_price;
	
	/**
	 * Whether the shoe is retired or not
	 *
	 * @var boolean
	 */
	protected $_retired;
	
	/**
	 * The active status of shoe
	 *
	 * @var boolean
	 */
	protected $_active;

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Loads the shoe
	 *
	 * @param string $id The ID of the shoe to be loaded
 	 * @param boolean $active Whether the shoe is active or not
	 * @return object $this Returns a copy of the shoe object or false if not found
	 */
	public function load($id,$active=true) {
	
		$query = $this->db->get_where($this->_table,array('id'=>$id,'active'=>$active,'deleted'=>NULL));
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$this->_id = $row->id;
				$this->_user_id = $row->user_id;
				$this->_make_id = $row->make_id;
				$this->_model = $row->model;
				$this->_purchase_date = $row->purchase_date;
				$this->_price = $row->price;
				$this->_retired = $row->retired;
				$this->_active = $row->active;
			}
			return $this;
		} else {
			return false;
		}
	
	}
	
	/**
	 * Adds an entry for this model
	 *
	 * @return boolean
	 */
	public function add() {
		
		$data = array(
			'user_id' => $this->_user_id,
			'make_id' => $this->_make_id,
			'model' => $this->_model,
			'purchase_date' => $this->_purchase_date,
			'price' => $this->_price,
			'retired' => $this->_retired,
			'active' => $this->_active			
		);
		$this->db->insert($this->_table,$data);
		
		return true;
	}
	
	/**
	 * Edits an entry for this model
	 *
	 * @return boolean
	 */
	public function edit() {
		
		$data = array(
			'user_id' => $this->_user_id,
			'make_id' => $this->_make_id,
			'model' => $this->_model,
			'purchase_date' => $this->_purchase_date,
			'price' => $this->_price,
			'retired' => $this->_retired,
			'active' => $this->_active			
		);
		$this->db->where('id',$this->_id);
		$this->db->update($this->_table,$data);
		
		return true;
	}	
	
	/**
	 * Deletes an entry for this model
	 *
	 * @return boolean
	 */
	public function delete() {
		
		$data = array('active'=>false,'deleted'=>true);
		$this->db->where('id',$this->_id);
		$this->db->update($this->_table, $data);
		
		return true;
	}
	
	/**
	 * Loads an empty instance of the shoe model
	 *
	 */
	public function instance() {
	
		return $this;
	
	}
	
	/**
	 * Get the userID for the shoe
	 *
	 * @return string
	 */
	public function getUserID() {
		return $this->_user_id;
	}
	
	/**
	 * Set the userID for the shoe
	 *
	 * @param integer $value The userID of the shoe
	 */
	public function setUserID($value) {
		$this->_user_id = $value;
	}
	
	/**
	 * Get the make for the shoe
	 *
	 * @return string
	 */
	public function getMakeID() {
		return $this->_make_id;
	}
	
	/**
	 * Set the makeID for the shoe
	 *
	 * @param integer $value The makeID of the shoe
	 */
	public function setMakeID($value) {
		$this->_make_id = $value;
	}
	
	/**
	 * Get the model for the shoe
	 *
	 * @return string
	 */
	public function getModel() {
		return $this->_model;
	}
	
	/**
	 * Set the model for the shoe
	 *
	 * @param string $value The model of the shoe
	 */
	public function setModel($value) {
		$this->_model = $value;
	}
	
	/**
	 * Get the purchase date for the shoe
	 *
	 * @return string
	 */
	public function getPurchaseDate() {
		return $this->_purchase_date;
	}
	
	/**
	 * Set the purchase date for the shoe
	 *
	 * @param string $value The purchase date of the shoe
	 */
	public function setPurchaseDate($value) {
		$this->_purchase_date = $value;
	}
	
	/**
	 * Get the price for the shoe
	 *
	 * @return string
	 */
	public function getPrice() {
		return $this->_price;
	}
	
	/**
	 * Set the price for the shoe
	 *
	 * @param integer $value The price of the shoe
	 */
	public function setPrice($value) {
		$this->_price = $value;
	}
	
	/**
	 * Get the retired status of the shoe
	 *
	 * @return string
	 */
	public function getRetired() {
		return $this->_retired;
	}
	
	/**
	 * Set the retired status for the shoe
	 *
	 * @param boolean $value The retired status of the shoe
	 */
	public function setRetired($value) {
		$this->_retired = $value;
	}
	
	/**
	 * Get the total mileage for the shoe
	 *
	 * @return string
	 */
	public function getMileage() {
		return 0;
	}
	
	/**
	 * Set the active status for the shoe
	 *
	 * @param boolean $value The active status of the shoe
	 */
	public function setActive($value) {
		$this->_active = $value;
	}

}