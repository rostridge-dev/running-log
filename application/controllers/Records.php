<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Records extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index() {
		
		$ci =& get_instance();
		
		$data = array();
		
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
		
		// Get the list of active entries
		$entries = array();
		$query = $this->db->get_where('entries',array('active'=>true,'deleted'=>NULL,'user_id'=>$this->session->userdata('user_id'),'type_id'=>1));
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$alias = "entries".$row->id;
				$ci->load->model('Entry_model',$alias);
				$entries[$row->id] = $ci->{$alias}->load($row->id);
			}
		}
		$entries = $this->sortPersonalRecords($entries);
		$data['entries'] = $entries;
		
		// Load the view for this controller
		$data['title'] = "Personal Records";
		$this->template->view('records_all',$data);
		
	}
	
	/**
	 * Sorts a list of entries into list of personal records
	 *
 	 * @param array $entries A list of running entry objects
	 * @return array $sorted A list of running entry objects, sorted and filtered
	 */
	private function sortPersonalRecords($entries) {
		
		// Load the time library
		$this->load->library('times');
		
		$sorted = $patialSorted = array();
		
		// First we need to group the records by distance
		if (!empty($entries)) {
			
			$groupedEntries = array();
			foreach($entries as $id => $entry) {
				$groupedEntries[$entry->getDistance()][] = $entry;
			}
			
			// Now we need to sort the distance groups by fastest time and pick the fastest (first) entry
			foreach($groupedEntries as $distance => $group) {
				$sortByTime = array();
				foreach ($group as $index => $entry) {
					$sortByTime[$entry->getID()] = $this->times->convertToSeconds($entry->getTime());
				}
				asort($sortByTime);
				foreach ($sortByTime as $nid => $entry) {
					$patialSorted[$nid] = $entries[$nid];
					break;
				}
			}
			
			// Now we need to sort the fastest entries by lowest distance first
			$groupedEntries = array();
			foreach ($patialSorted as $id => $entry) {
				$groupedEntries[$id] = $entry->getDistance();
			}
			asort($groupedEntries);
			foreach ($groupedEntries as $id => $distance) {
				$sorted[$id] = $entries[$id];
			}
			
		}
		
		return $sorted;
		
	}
}