<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Badges {
	
	/**
	 * Returns whether or not the selected year qualifies for badge processing (must have at least 30 run entries)
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
 	 * @param integer $year The calendar year used to search for badges
	 * @return boolean $qualify Returns whether a year qualifies or not
	 */
	public function returnBadgeQualification($user_id,$year) {
		
		$qualify = false;
		$totals = 0;
		
		$CI =& get_instance();
		
		$CI->load->library("dates");
		$dates = $CI->dates->returnSelectedYear($year);
		
		$CI->db->order_by('distance','DESC');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('active',1);
		$CI->db->where('deleted',NULL);
		$CI->db->where('date >= ',$dates['start']);
		$CI->db->where('date <=',$dates['end']);
		$query = $CI->db->get('entries');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$totals++;
			}
		}
		
		if ($totals > 30) {
			$qualify = true;
		}
		
		return $qualify;
	}
	
	/**
	 * Return the list of badges for a user within a given calendar year
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
 	 * @param integer $year The calendar year used to search for badges
	 * @return array $badges Returns the list of badges for a user
	 */
	public function returnBadgesForYear($user_id,$year) {
		
		$CI =& get_instance();
		$CI->load->library("dates");
		
		$badges = array();
		$dates = $CI->dates->returnSelectedYear($year);
		
		$personalRecords = array();
		$personalRecords = $this->returnBadgesPersonalRecords($user_id,$dates['end']);
		
		$badgesList = array();
		$badgesList[] = $this->returnBadgeSocial($user_id,$dates['start'],$dates['end']);
		$badgesList[] = $this->returnBadgeTotals($user_id,$dates['start'],$dates['end']);
		$badgesList[] = $this->returnBadgeLongest($user_id,$dates['start'],$dates['end']);
		$badgesList[] = $this->returnBadgeRaces($user_id,$dates['start'],$dates['end']);
		$badgesList[] = $this->returnBadgeHottest($user_id,$dates['start'],$dates['end']);
		$badgesList[] = $this->returnBadgeColdest($user_id,$dates['start'],$dates['end']);
		$badgesList[] = $this->returnBadgeConsecutiveDays($user_id,$dates['start'],$dates['end']);
		$badgesList[] = $this->returnBadgeUniqueRoutes($user_id,$dates['start'],$dates['end']);
		$badgesList[] = $this->returnBiggestMonth($user_id,$dates['start']);
		if (!empty($personalRecords)) {
			foreach ($personalRecords as $badgeRecord) {
				$badgesList[] = $badgeRecord;
			}
		}
		$badgesList = $this->sortBadgesByRank($badgesList);
		
		$badges['large'][] = $badgesList[0];
		$badges['large'][] = $badgesList[1];
		$badges['small'][] = $badgesList[2];
		$badges['small'][] = $badgesList[3];
		$badges['small'][] = $badgesList[4];
		$badges['small'][] = $badgesList[5];
		$badges['small'][] = $badgesList[6];
		$badges['small'][] = $badgesList[7];
		
		return $badges;
		
	}
	
	/**
	 * Sort the badges array by the 'rank' value
	 *
 	 * @param array $badges An array containing the badges list
	 * @return array $sorted Returns the list of sorted badges
	 */
	private function sortBadgesByRank($badges) {
		$sorting = array();
		foreach ($badges as $index => $badge) {
			$sorting[$index] = $badge['rank'];
		}
		asort($sorting);
		
		$sorted = array();
		foreach ($sorting as $index => $rank) {
			$sorted[] = $badges[$index];
		}
		$sorted = array_reverse($sorted);
		
		return $sorted;
		
	}
	
	/**
	 * Return the totals run for the given year in both km and days/hours/minutes/seconds
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
	 * @return array $badge Returns the badge details
	 */
	private function returnBadgeTotals($user_id,$start,$end) {
		
		$CI =& get_instance();
		$CI->load->library("distances");
		$CI->load->library("times");
		
		$distance = $CI->distances->returnDistanceTotal($user_id,$start,$end);
		$time = $CI->times->returnTimeTotal($user_id,$start,$end);
		
		if (($distance > 0) && ($distance <= 200)) {
			$rank = 1;
		} else if (($distance > 200) && ($distance <= 400)) {
			$rank = 2;
		} else if (($distance > 400) && ($distance <= 600)) {
			$rank = 3;
		} else if (($distance > 600) && ($distance <= 800)) {
			$rank = 4;
		} else if (($distance > 800) && ($distance <= 1000)) {
			$rank = 5;
		} else if (($distance > 1000) && ($distance <= 1200)) {
			$rank = 6;
		} else if (($distance > 1200) && ($distance <= 1500)) {
			$rank = 7;
		} else if ($distance > 1500) {
			$rank = 8;
		}
		
		$badge = array();
		$badge['rank'] = $rank;
		$badge['icon'] = "glyphicon-stats";
		$badge['title'] = "Number Crunch";
		$badge['content'] = "Total distance: ".$distance." km<br>Total time: ".$time;
		
		return $badge;
		
	}
	
	/**
	 * Return the number of times a user has run with another person between two dates (includes the end dates); races are automatically social
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
	 * @return array $badge Returns the badge details
	 */
	private function returnBadgeSocial($user_id,$start,$end) {
		$total = $rank = 0;
		
		$CI =& get_instance();
		
		$CI->db->where('user_id',$user_id);
		$CI->db->where('active',1);
		$CI->db->where('deleted',NULL);
		$CI->db->where('date >= ',$start);
		$CI->db->where('date <=',$end);
		$query = $CI->db->get('entries');
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if ($row->type_id == 1) {
					$total++;
				}
				if (!empty($row->notes)) {
					$total++;
				}
			}
		}
		
		if (($total > 0) && ($total <= 10)) {
			$rank = 1;
		} else if (($total > 10) && ($total <= 20)) {
			$rank = 2;
		} else if (($total > 20) && ($total <= 30)) {
			$rank = 3;
		} else if ($total > 30) {
			$rank = 4;
		}
		
		$badge = array();
		$badge['rank'] = $rank;
		$badge['icon'] = "glyphicon-heart";
		$badge['title'] = "Social Runner";
		$badge['content'] = "You ran with another person ".$total." times this year!";
		
		return $badge;
		
	}
	
	/**
	 * Return the longest run located for a user in a given year
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
	 * @return array $badge Returns the badge details
	 */
	private function returnBadgeLongest($user_id,$start,$end) {
		
		$CI =& get_instance();
		
		$CI->db->order_by('distance','DESC');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('active',1);
		$CI->db->where('deleted',NULL);
		$CI->db->where('date >= ',$start);
		$CI->db->where('date <=',$end);
		$query = $CI->db->get('entries');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$distance = $row->distance;
				$time = $row->time;
				break;
			}
		}
		
		if (($distance > 0) && ($distance <= 10)) {
			$rank = 1;
		} else if (($distance > 10) && ($distance <= 15)) {
			$rank = 2;
		} else if (($distance > 15) && ($distance <= 20)) {
			$rank = 3;
		} else if (($distance > 20) && ($distance <= 25)) {
			$rank = 4;
		} else if (($distance > 25) && ($distance <= 30)) {
			$rank = 5;
		} else if (($distance > 30) && ($distance <= 35)) {
			$rank = 6;
		} else if (($distance > 35) && ($distance <= 40)) {
			$rank = 7;
		} else if ($distance > 40) {
			$rank = 8;
		}
		
		$badge = array();
		$badge['rank'] = $rank;
		$badge['icon'] = "glyphicon-send";
		$badge['title'] = "Go Long";
		$badge['content'] = "Your longest run was ".$distance." km in ".$time."!";
		
		return $badge;
	}
	
	/**
	 * Return the total number of races in a given year
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
	 * @return array $badge Returns the badge details
	 */
	private function returnBadgeRaces($user_id,$start,$end) {
		$total = $rank = 0;
		
		$CI =& get_instance();
		
		$CI->db->where('user_id',$user_id);
		$CI->db->where('type_id',1);
		$CI->db->where('active',1);
		$CI->db->where('deleted',NULL);
		$CI->db->where('date >= ',$start);
		$CI->db->where('date <=',$end);
		$query = $CI->db->get('entries');
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$total++;
			}
		}
		
		if (($total > 0) && ($total <= 3)) {
			$rank = 1;
		} else if (($total > 3) && ($total <= 6)) {
			$rank = 2;
		} else if (($total > 6) && ($total <= 9)) {
			$rank = 3;
		} else if (($total > 9) && ($total <= 12)) {
			$rank = 4;
		} else if (($total > 12) && ($total <= 15)) {
			$rank = 4;
		} else if ($total > 15) {
			$rank = 5;
		}
		
		$badge = array();
		$badge['rank'] = $rank;
		$badge['icon'] = "glyphicon-flag";
		$badge['title'] = "Competitive Spirit";
		$badge['content'] = "You ran a total of ".$total." races this year!";
		
		return $badge;
		
	}
	
	/**
	 * Return the hottest run located for a user in a given year
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
	 * @return array $badge Returns the badge details
	 */
	private function returnBadgeHottest($user_id,$start,$end) {
		
		$CI =& get_instance();
		
		$CI->db->order_by('temperature','DESC');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('active',1);
		$CI->db->where('deleted',NULL);
		$CI->db->where('date >= ',$start);
		$CI->db->where('date <=',$end);
		$query = $CI->db->get('entries');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if (!empty($row->temperature)) {
					$temperature = $row->temperature;
					break;
				}
			}
		}
		
		if (($temperature > 0) && ($temperature <= 10)) {
			$rank = 1;
		} else if (($temperature > 10) && ($temperature <= 20)) {
			$rank = 2;
		} else if (($temperature > 20) && ($temperature <= 30)) {
			$rank = 3;
		} else if (($temperature > 30) && ($temperature <= 40)) {
			$rank = 4;
		} else if ($temperature > 40) {
			$rank = 5;
		}
		
		$badge = array();
		$badge['rank'] = $rank;
		$badge['icon'] = "glyphicon-certificate";
		$badge['title'] = "Hot to Trot";
		$badge['content'] = "Your hottest run was a scorching ".$temperature." &#176;C!";
		
		return $badge;
	}
	
	/**
	 * Return the coldest run located for a user in a given year
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
	 * @return array $badge Returns the badge details
	 */
	private function returnBadgeColdest($user_id,$start,$end) {
		
		$CI =& get_instance();
		
		$CI->db->order_by('temperature','ASC');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('active',1);
		$CI->db->where('deleted',NULL);
		$CI->db->where('date >= ',$start);
		$CI->db->where('date <=',$end);
		$query = $CI->db->get('entries');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if (!empty($row->temperature)) {
					$temperature = $row->temperature;
					break;
				}
			}
		}
		
		if ($temperature <= -20) {
			$rank = 5;
		} else if (($temperature > -20) && ($temperature <= -10)) {
			$rank = 4;
		} else if (($temperature > -10) && ($temperature <= 0)) {
			$rank = 3;
		} else if (($temperature > 0) && ($temperature <= 10)) {
			$rank = 2;
		} else if ($temperature > 10)  {
			$rank = 1;
		}
		
		$badge = array();
		$badge['rank'] = $rank;
		$badge['icon'] = "glyphicon-cloud";
		$badge['title'] = "Cool Running";
		$badge['content'] = "Your coldest run was a chilly ".$temperature." &#176;C!";
		
		return $badge;
	}
	
	/**
	 * Return the number of days consecuatively run for a user
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
	 * @return array $badge Returns the badge details
	 */
	private function returnBadgeConsecutiveDays($user_id,$start,$end) {
		$dates = array();
		$datespans = array();
		$counting = 1;
		$consecutive = 0;
		
		$CI =& get_instance();
		
		$CI->db->order_by('date','ASC');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('active',1);
		$CI->db->where('deleted',NULL);
		$CI->db->where('date >= ',$start);
		$CI->db->where('date <=',$end);
		$query = $CI->db->get('entries');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$dates[] = $row->date;
			}
		}
		
		$dates = array_values(array_unique($dates));

		foreach ($dates as $index => $date) {
			if ($index < count($dates)-1) {
				if (strtotime($date." 12:00:00 +1 day" ) == strtotime($dates[$index+1]." 12:00:00 ")) {
					$counting++;
				} else {
					if ($counting > 1) {
						$datespans[] = $counting;
					}
					$counting = 1;
				}
			} else {
				$datespans[] = $counting;
			}
		}
		
		rsort($datespans);
		if (!empty($datespans)) {
			$consecutive = $datespans[0];
		}
		
		$badge = array();
		$badge['rank'] = $consecutive;
		$badge['icon'] = "glyphicon-signal";
		$badge['title'] = "Another Day...";
		$badge['content'] = "The most consecutive days you ran was ".$consecutive." in a row!";
		
		return $badge;
	}
	
	/**
	 * Returns a list of person bests for the runner
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
	 * @return array $badge Returns the badge details
	 */
	private function returnBadgesPersonalRecords($user_id,$end) {
		
		$entries = $badges = array();
		
		$CI =& get_instance();
		
		// Get the list of active entries
		$CI->db->where('date <=',$end);
		$query = $CI->db->get_where('entries',array('active'=>true,'deleted'=>NULL,'user_id'=>$user_id,'type_id'=>1));
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$alias = "entries".$row->id;
				$CI->load->model('Entry_model',$alias);
				$entries[$row->id] = $CI->{$alias}->load($row->id);
			}
		}
		if (!empty($entries)) {
			$entries = $this->sortPersonalRecords($entries);
			foreach ($entries as $entry) {
				if (date("Y", strtotime($end)) == date("Y", strtotime($entry->getDate()))) {
					$badge = array();
					$badge['rank'] = 7;
					$badge['icon'] = "glyphicon-star";
					$badge['title'] = "Personal Best";
					$badge['content'] = "You set a new ".$entry->getDistance()." k personal best of ".$entry->getTime()."!";
					$badges[] = $badge;
				}
			}
		}
		
		return $badges;
		
	}
	
	/**
	 * Sorts a list of entries into list of personal records
	 *
 	 * @param array $entries A list of running entry objects
	 * @return array $sorted A list of running entry objects, sorted and filtered
	 */
	private function sortPersonalRecords($entries) {
		
		$CI =& get_instance();
		
		// Load the time library
		$CI->load->library('times');
		
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
					$sortByTime[$entry->getID()] = $CI->times->convertToSeconds($entry->getTime());
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
			arsort($groupedEntries);
			foreach ($groupedEntries as $id => $distance) {
				$sorted[$id] = $entries[$id];
			}
			
		}
		
		return $sorted;
		
	}
	
	/**
	 * Return the number of unique routes run on for this user
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start date of the running query (YYYY-MM-DD)
 	 * @param datestamp $end The end date of the running query (YYYY-MM-DD)
	 * @return array $badge Returns the badge details
	 */
	private function returnBadgeUniqueRoutes($user_id,$start,$end) {
		
		$count = 0;
		
		$CI =& get_instance();
		
		$CI->db->select('count(DISTINCT(route_id)) AS count');
		$CI->db->where('user_id',$user_id);
		$CI->db->where('active',1);
		$CI->db->where('deleted',NULL);
		$CI->db->where('date >= ',$start);
		$CI->db->where('date <=',$end);
		$query = $CI->db->get('entries');
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$count = $row->count;
			}
		}
		
		$badge = array();
		$badge['rank'] = round($count/4);
		$badge['icon'] = "glyphicon-picture";
		$badge['title'] = "Change of Scenery";
		$badge['content'] = "You ran on ".$count." different routes this year!";
		
		return $badge;
		
	}
	
	/**
	 * Return the biggest month by milage for the given year
	 *
 	 * @param integer $user_id The user ID that is used to locate the runs
	 * @param datestamp $start The start year for the query
	 * @return array $badge Returns the badge details
	 */
	public function returnBiggestMonth($user_id,$start) {
		
		$CI =& get_instance();
		
		// Load the time library
		$CI->load->library('times');
		$CI->load->library('distances');
		$CI->load->library('dates');
		
		$stamp = strtotime($start);
		$start_year = date("Y",$stamp);
		$start_month = date("m",$stamp);
		$totals = array();
		
		// Grab the data for the last year
		$dates_totals = array();
		$dates_totals = $CI->dates->returnPreviousMonthsByYear(12,$start_year,12);
		foreach($dates_totals as $dates_months) {
			$totals[date("F",strtotime($dates_months['start']))]['distance'] = $CI->distances->returnDistanceTotal($user_id,$dates_months['start'],$dates_months['end']);
		}
		
		// Sort the totals
		$sorting = array();
		foreach ($totals as $datestamp => $data) {
			$sorting[$datestamp] = $data['distance'];
		}
		arsort($sorting);
		reset($sorting);
		$date = key($sorting);
		$total = $sorting[$date];
		
		if (($total > 0) && ($total <= 30)) {
			$rank = 1;
		} else if (($total > 30) && ($total <= 60)) {
			$rank = 2;
		} else if (($total > 60) && ($total <= 90)) {
			$rank = 3;
		} else if (($total > 90) && ($total <= 120)) {
			$rank = 4;
		} else if ($total > 120) {
			$rank = 5;
		}
		
		$badge = array();
		$badge['rank'] = $rank;
		$badge['icon'] = "glyphicon-calendar";
		$badge['title'] = "Massive Month";
		$badge['content'] = "Your biggest month was ".$date." totalling ".$total." km!";
		
		return $badge;
	}

}