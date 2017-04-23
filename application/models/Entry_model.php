<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entry_model extends MY_Model {
	
	/**
	 * The table name for this model
	 *
	 * @var string
	 */
	protected $_table = "entries";
	
	/**
	 * The user associated to the entry
	 *
	 * @var integer
	 */
	protected $_user_id;
	
	/**
	 * The date of the entry (YYYY-MM-DD)
	 *
	 * @var string
	 */
	protected $_date;
	
	/**
	 * The time of day for the entry (H:MM AM/PM)
	 *
	 * @var string
	 */
	protected $_time_of_day;
	
	/**
	 * The type ID of the entry (easy, long, etc)
	 *
	 * @var integer
	 */
	protected $_type_id;
	
	/**
	 * The route ID of the entry
	 *
	 * @var integer
	 */
	protected $_route_id;
	
	/**
	 * The distance run for the entry in kilometers
	 *
	 * @var number
	 */
	protected $_distance;
	
	/**
	 * The time the entry took (HH:MM:SS or MM:SS)
	 *
	 * @var string
	 */
	protected $_time;
	
	/**
	 * The shoe ID for the entry
	 *
	 * @var integer
	 */
	protected $_shoe_id;
	
	/**
	 * The quality score for the entry
	 *
	 * @var integer
	 */
	protected $_quality;
	
	/**
	 * The effort score for the entry
	 *
	 * @var integer
	 */
	protected $_effort;
	
	/**
	 * The weather IDs for the entry (x,y,z)
	 *
	 * @var string
	 */
	protected $_weather_ids;
	
	/**
	 * The temperature for the entry
	 *
	 * @var float
	 */
	protected $_temperature;
	
	/**
	 * The notes for the entry
	 *
	 * @var string
	 */
	protected $_notes;
	
	/**
	 * The field size for the entry (if a race)
	 *
	 * @var string
	 */
	protected $_field;
	
	/**
	 * The placement for the entry (if a race)
	 *
	 * @var integer
	 */
	protected $_placement;
	
	/**
	 * The group min age for the entry (if a race)
	 *
	 * @var integer
	 */
	protected $_group_min_age;
	
	/**
	 * The group max age for the entry (if a race)
	 *
	 * @var integer
	 */
	protected $_group_max_age;
	
	/**
	 * The age group size for the entry (if a race)
	 *
	 * @var integer
	 */
	protected $_group_age_size;
	
	/**
	 * The age group placement for the entry (if a race)
	 *
	 * @var integer
	 */
	protected $_group_age_placement;
	
	/**
	 * The gender group size for the entry (if a race)
	 *
	 * @var integer
	 */
	protected $_group_gender_size;
	
	/**
	 * The gender group placement for the entry (if a race)
	 *
	 * @var integer
	 */
	protected $_group_gender_placement;
	
	/**
	 * The active status of entry
	 *
	 * @var boolean
	 */
	protected $_active;

	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * Loads the entry
	 *
	 * @param string $id The ID of the entry to be loaded
 	 * @param boolean $active Whether the entry is active or not
	 * @return object $this Returns a copy of the entry object or false if not found
	 */
	public function load($id,$active=true) {
	
		$query = $this->db->get_where($this->_table,array('id'=>$id,'active'=>$active,'deleted'=>NULL));
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$this->_id = $row->id;
				$this->_user_id = $row->user_id;
				$this->_date = $row->date;
				$this->_time_of_day = $row->time_of_day;
				$this->_type_id = $row->type_id;
				$this->_route_id = $row->route_id;
				$this->_distance = $row->distance;
				$this->_time = $row->time;
				$this->_shoe_id = $row->shoe_id;
				$this->_quality = $row->quality;
				$this->_effort = $row->effort;
				$this->_weather_ids = $row->weather_ids;
				$this->_temperature = $row->temperature;
				$this->_notes = $row->notes;
				$this->_field = $row->field;
				$this->_placement = $row->placement;
				$this->_group_min_age = $row->group_min_age;
				$this->_group_max_age = $row->group_max_age;
				$this->_group_age_size = $row->group_age_size;
				$this->_group_age_placement = $row->group_age_placement;
				$this->_group_gender_size = $row->group_gender_size;
				$this->_group_gender_placement = $row->group_gender_placement;
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
			'date' => $this->_date,
			'time_of_day' => $this->_time_of_day,
			'type_id' => $this->_type_id,
			'route_id' => $this->_route_id,
			'distance' => $this->_distance,
			'time' => $this->_time,
			'shoe_id' => $this->_shoe_id,
			'quality' => $this->_quality,
			'effort' => $this->_effort,
			'weather_ids' => $this->_weather_ids,
			'temperature' => $this->_temperature,
			'notes' => $this->_notes,
			'field' => $this->_field,
			'placement' => $this->_placement,
			'group_min_age' => $this->_group_min_age,
			'group_max_age' => $this->_group_max_age,
			'group_age_size' => $this->_group_age_size,
			'group_age_placement' => $this->_group_age_placement,
			'group_gender_size' => $this->_group_gender_size,
			'group_gender_placement' => $this->_group_gender_placement,
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
			'date' => $this->_date,
			'time_of_day' => $this->_time_of_day,
			'type_id' => $this->_type_id,
			'route_id' => $this->_route_id,
			'distance' => $this->_distance,
			'time' => $this->_time,
			'shoe_id' => $this->_shoe_id,
			'quality' => $this->_quality,
			'effort' => $this->_effort,
			'weather_ids' => $this->_weather_ids,
			'temperature' => $this->_temperature,
			'notes' => $this->_notes,
			'field' => $this->_field,
			'placement' => $this->_placement,
			'group_min_age' => $this->_group_min_age,
			'group_max_age' => $this->_group_max_age,
			'group_age_size' => $this->_group_age_size,
			'group_age_placement' => $this->_group_age_placement,
			'group_gender_size' => $this->_group_gender_size,
			'group_gender_placement' => $this->_group_gender_placement,
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
	 * Loads an empty instance of the entry model
	 *
	 */
	public function instance() {
	
		return $this;
	
	}
	
	/**
	 * Get the userID for the entry
	 *
	 * @return integer
	 */
	public function getUserID() {
		return $this->_user_id;
	}
	
	/**
	 * Set the userID for the entry
	 *
	 * @param integer $value The userID of the entry
	 */
	public function setUserID($value) {
		$this->_user_id = $value;
	}
	
	/**
	 * Get the date for the entry
	 *
	 * @return string
	 */
	public function getDate() {
		return $this->_date;
	}
	
	/**
	 * Set the date for the entry
	 *
	 * @param string $value The date of the entry
	 */
	public function setDate($value) {
		$this->_date = $value;
	}
	
	/**
	 * Get the time of day for the entry
	 *
	 * @return string
	 */
	public function getTimeOfDay() {
		return $this->_time_of_day;
	}
	
	/**
	 * Set the time of day for the entry
	 *
	 * @param string $value The time of day of the entry
	 */
	public function setTimeOfDay($value) {
		$this->_time_of_day = $value;
	}
	
	/**
	 * Get the type ID for the entry
	 *
	 * @return integer
	 */
	public function getTypeID() {
		return $this->_type_id;
	}
	
	/**
	 * Set the type ID for the entry
	 *
	 * @param integer $value The type ID of the entry
	 */
	public function setTypeID($value) {
		$this->_type_id = $value;
	}
	
	/**
	 * Get the route id for the entry
	 *
	 * @return string
	 */
	public function getRouteID() {
		return $this->_route_id;
	}
	
	/**
	 * Set the route id for the entry
	 *
	 * @param integer $value The route id of the entry
	 */
	public function setRouteID($value) {
		$this->_route_id = $value;
	}
	
	/**
	 * Get the distance of the entry
	 *
	 * @return string
	 */
	public function getDistance() {
		return $this->_distance;
	}
	
	/**
	 * Set the distance for the entry
	 *
	 * @param float $value The distance of the entry
	 */
	public function setDistance($value) {
		$this->_distance = $value;
	}
	
	/**
	 * Get time for the entry
	 *
	 * @return string
	 */
	public function getTime() {
		return $this->_time;
	}
	
	/**
	 * Set the time for the entry; converts to HH:MM:SS
	 *
	 * @param string $value The time of the entry
	 */
	public function setTime($value) {
		$segments = explode(':',$value);
		$length = count($segments);
		switch ($length) {
			case 1:
				$time = "0:00:".sprintf('%02d',$segments[0]);
				break;
			case 2:
				$time = "0:".sprintf('%02d',$segments[0]).":".sprintf('%02d',$segments[1]);
				break;
			default:
				$time = $value;
				break;
		}
		
		$this->_time = $time;
	}
	
	/**
	 * Get shoe ID for the entry
	 *
	 * @return string
	 */
	public function getShoeID() {
		return $this->_shoe_id;
	}
	
	/**
	 * Set the shoe ID for the entry
	 *
	 * @param string $value The shoe ID of the entry
	 */
	public function setShoeID($value) {
		$this->_shoe_id = $value;
	}
	
	/**
	 * Get the quality for the entry
	 *
	 * @return string
	 */
	public function getQuality() {
		return $this->_quality;
	}
	
	/**
	 * Set the quality for the entry
	 *
	 * @param string $value The quality of the entry
	 */
	public function setQuality($value) {
		$this->_quality = $value;
	}
	
	/**
	 * Get the effort for the entry
	 *
	 * @return string
	 */
	public function getEffort() {
		return $this->_effort;
	}
	
	/**
	 * Set the effort for the entry
	 *
	 * @param string $value The effort of the entry
	 */
	public function setEffort($value) {
		$this->_effort = $value;
	}
	
	/**
	 * Get the weather IDS for the entry
	 *
	 * @return string
	 */
	public function getWeatherIDS() {
		return $this->_weather_ids;
	}
	
	/**
	 * Set the weather IDS for the entry
	 *
	 * @param string $value The weather IDS of the entry
	 */
	public function setWeatherIDS($value) {
		$this->_weather_ids = $value;
	}
	
	/**
	 * Get the weather IDS for the entry
	 *
	 * @return string
	 */
	public function getWeatherIDSArray() {
		$array = explode(',',$this->_weather_ids);
		$weather = array();
		foreach ($array as $value) {
			$weather[$value] = $value;
		}
		return $weather;
	}
	
	/**
	 * Get the temperature for the entry
	 *
	 * @return string
	 */
	public function getTemperature() {
		return $this->_temperature;
	}
	
	/**
	 * Set the temperature for the entry
	 *
	 * @param string $value The temperature of the entry
	 */
	public function setTemperature($value) {
		$this->_temperature = $value;
	}
	
	/**
	 * Get the notes for the entry
	 *
	 * @return string
	 */
	public function getNotes() {
		return $this->_notes;
	}
	
	/**
	 * Set the notes for the entry
	 *
	 * @param string $value The notes of the entry
	 */
	public function setNotes($value) {
		if ($value == NULL) {
			$this->_notes = "";
		} else {
			$this->_notes = $value;
		}
	}
	
	/**
	 * Get the race placement for the entry
	 *
	 * @return string
	 */
	public function getPlacement() {
		return $this->_placement;
	}
	
	/**
	 * Set the race placement for the entry
	 *
	 * @param string $value The race placement of the entry
	 */
	public function setPlacement($value) {
		$this->_placement = $value;
	}
	
	/**
	 * Get the race field size for the entry
	 *
	 * @return string
	 */
	public function getField() {
		return $this->_field;
	}
	
	/**
	 * Set the race field size for the entry
	 *
	 * @param string $value The race field size for the entry
	 */
	public function setField($value) {
		$this->_field = $value;
	}
	
	/**
	 * Get the race group min age for the entry
	 *
	 * @return string
	 */
	public function getGroupMinAge() {
		return $this->_group_min_age;
	}
	
	/**
	 * Set the race group min age for the entry
	 *
	 * @param string $value The race group min age for the entry
	 */
	public function setGroupMinAge($value) {
		$this->_group_min_age = $value;
	}
	
	/**
	 * Get the race group max age for the entry
	 *
	 * @return string
	 */
	public function getGroupMaxAge() {
		return $this->_group_max_age;
	}
	
	/**
	 * Set the race group max age for the entry
	 *
	 * @param string $value The race group max age for the entry
	 */
	public function setGroupMaxAge($value) {
		$this->_group_max_age = $value;
	}
	
	/**
	 * Get the race age placement for the entry
	 *
	 * @return string
	 */
	public function getGroupAgePlacement() {
		return $this->_group_age_placement;
	}
	
	/**
	 * Set the race group max age for the entry
	 *
	 * @param string $value The race group max age for the entry
	 */
	public function setGroupAgePlacement($value) {
		$this->_group_age_placement = $value;
	}

	/**
	 * Get the race age group size for the entry
	 *
	 * @return string
	 */
	public function getGroupAgeSize() {
		return $this->_group_age_size;
	}
	
	/**
	 * Set the race age group size for the entry
	 *
	 * @param string $value The race age group size for the entry
	 */
	public function setGroupAgeSize($value) {
		$this->_group_age_size = $value;
	}
	
	/**
	 * Get the race gender group size for the entry
	 *
	 * @return string
	 */
	public function getGroupGenderSize() {
		return $this->_group_gender_size;
	}
	
	/**
	 * Set the race gender group size for the entry
	 *
	 * @param string $value The race gender group size for the entry
	 */
	public function setGroupGenderSize($value) {
		$this->_group_gender_size = $value;
	}
	
	/**
	 * Get the race gender group placement for the entry
	 *
	 * @return string
	 */
	public function getGroupGenderPlacement() {
		return $this->_group_gender_placement;
	}
	
	/**
	 * Set the race gender group placement for the entry
	 *
	 * @param string $value The race gender group placement for the entry
	 */
	public function setGroupGenderPlacement($value) {
		$this->_group_gender_placement = $value;
	}
	
	/**
	 * Calculate the pace for the entry
	 *
	 * @return string
	 */
	public function getPace() {
		$distance = $this->_distance;
		$time = $this->_time;

		$segments = explode(':',$time);
		$length = count($segments);
		switch ($length) {
			case 3:
				$seconds = $segments[0] * 3600 + $segments[1] * 60 + $segments[2];
				break;
			case 2:
				$seconds = $segments[0] * 60 + $segments[1];
				break;
			default:
				$seconds = 0;
				break;
		}

		if ($seconds != 0) {
			$minutes = floor($seconds / $distance / 60);
			$seconds = sprintf('%02d',round(($seconds / $distance / 60 - $minutes) * 60));
			$pace = $minutes.":".$seconds;
		} else {
			$pace = "--";
		}		
		
		return $pace;
	}
	
	/**
	 * Calculate the percentage finish in a race field for the entry
	 *
	 * @return string
	 */
	public function getPercentage() {
		$percentage = "";
		
		if ($this->getIsRace() == true) {
			$placement = $this->_placement;
			$field = $this->_field;
			$percentage = round($placement / $field * 100)."%";
		}
		
		return $percentage;
		
	}
	
	/**
	 * Returns whether the entry is a race or not
	 *
	 * @return boolean
	 */
	public function getIsRace() {
		$boolRace = false;
		if ($this->_type_id == 1) {
			$boolRace = true;
		}
		return $boolRace;
	}
	
	/**
	 * Set the active status for the entry
	 *
	 * @param boolean $value The active status of the entry
	 */
	public function setActive($value) {
		$this->_active = $value;
	}

}