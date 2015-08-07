<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Route_model extends MY_Model {
	
	/**
	 * The table name for this model
	 *
	 * @var string
	 */
	protected $_table = "routes";
	
	/**
	 * The name of the route
	 *
	 * @var string
	 */
	protected $_name;
	
	/**
	 * The distance of the route
	 *
	 * @var float
	 */
	protected $_distance;
	
	/**
	 * The id of the surface type for the route
	 *
	 * @var integer
	 */
	protected $_surface_id;
	
	/**
	 * The type of the route (route, race)
	 *
	 * @var integer
	 */
	protected $_type_id;
	
	/**
	 * The active status of route
	 *
	 * @var boolean
	 */
	protected $_active;

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Loads the route
	 *
	 * @param string $id The ID of the route to be loaded
 	 * @param boolean $active Whether the route is active or not
	 * @return object $this Returns a copy of the route object or false if not found
	 */
	public function load($id,$active=true) {
	
		$query = $this->db->get_where($this->_table,array('id'=>$id,'active'=>$active,'deleted'=>NULL));
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$this->_id = $row->id;
				$this->_user_id = $row->user_id;
				$this->_name = $row->name;
				$this->_distance = $row->distance;
				$this->_surface_id = $row->surface_id;
				$this->_type_id = $row->type_id;
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
			'name' => $this->_name,
			'distance' => $this->_distance,
			'surface_id' => $this->_surface_id,
			'type_id' => $this->_type_id,
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
			'name' => $this->_name,
			'distance' => $this->_distance,
			'surface_id' => $this->_surface_id,
			'type_id' => $this->_type_id,
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
	 * Loads an empty instance of the route model
	 *
	 */
	public function instance() {
	
		return $this;
	
	}
	
	/**
	 * Get the userID for the route
	 *
	 * @return string
	 */
	public function getUserID() {
		return $this->_user_id;
	}
	
	/**
	 * Set the userID for the route
	 *
	 * @param integer $value The userID of the route
	 */
	public function setUserID($value) {
		$this->_user_id = $value;
	}
	
	/**
	 * Get the name for the route
	 *
	 * @return string
	 */
	public function getName() {
		return $this->_name;
	}
	
	/**
	 * Set the name for the route
	 *
	 * @param integer $value The name of the route
	 */
	public function setName($value) {
		$this->_name = $value;
	}
	
	/**
	 * Get the name for the route
	 *
	 * @return float
	 */
	public function getDistance() {
		return $this->_distance;
	}
	
	/**
	 * Set the distance for the route
	 *
	 * @param float $value The distance of the route
	 */
	public function setDistance($value) {
		$this->_distance = $value;
	}
	
	/**
	 * Get the surface for the route
	 *
	 * @return integer
	 */
	public function getSurfaceID() {
		return $this->_surface_id;
	}
	
	/**
	 * Set the makeID for the route
	 *
	 * @param integer $value The makeID of the route
	 */
	public function setSurfaceID($value) {
		$this->_surface_id = $value;
	}
	
	/**
	 * Get the type ID for the route
	 *
	 * @return string
	 */
	public function getTypeID() {
		return $this->_type_id;
	}
	
	/**
	 * Set the type ID for the route
	 *
	 * @param string $value The type ID of the route
	 */
	public function setTypeID($value) {
		$this->_type_id = $value;
	}
	
	/**
	 * Set the active status for the route
	 *
	 * @param boolean $value The active status of the route
	 */
	public function setActive($value) {
		$this->_active = $value;
	}

}