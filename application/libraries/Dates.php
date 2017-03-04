<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dates {
	
	/**
	 * Return the start and end dates for the current year
	 *
	 * @return array $dates Returns the start and end dates for the desired period
	 */
    public function returnCurrentYear() {
		
		$dates = array();
		$current_year = date("Y");
		$dates['start'] = $current_year."-01-01";
		$dates['end'] = $current_year."-12-31";
		
		return $dates;
		
	}
	
	/**
	 * Return a list of start dates and end dates for the last XX months
	 *
	 * @param integer $months The number of months that we want start and end dates for
	 * @return array $dates Returns the start and end dates for the desired period
	 */
    public function returnPreviousMonths($months) {
		
		$dates = array();
		$current_year = date("Y");
		$current_month = date("m");
		for ($counter = 0; $counter < $months; $counter++) {
			$endpoints = array();
			$stamp = strtotime($current_year.'-'.$current_month.'-01 -'.$counter.' months');
			$endpoints['start'] = date("Y-m-d",$stamp);
			$days = cal_days_in_month(CAL_GREGORIAN,date("m",$stamp),date("Y",$stamp));
			$endpoints['end'] = date("Y",$stamp).'-'.date("m",$stamp).'-'.$days;
			$dates[] = $endpoints;
		}
		
		return $dates;
		
	}
	
	/**
	 * Return a list of start dates and end dates for the last XX weeks
	 *
	 * @param integer $weeks The number of weeks that we want start and end dates for
	 * @return array $dates Returns the start and end dates for the desired period
	 */
    public function returnPreviousWeeks($weeks) {
		
		$dates = array();
		$current_day_week = date("w");
		
		switch ($current_day_week) {
			case 0:
				$stamp = strtotime(date('Y-m-d'));
				break;
			case 1:
				$stamp = strtotime(date('Y-m-d').' -1 days');
				break;
			case 2:
				$stamp = strtotime(date('Y-m-d').' -2 days');
				break;
			case 3:
				$stamp = strtotime(date('Y-m-d').' -3 days');
				break;
			case 4:
				$stamp = strtotime(date('Y-m-d').' -4 days');
				break;
			case 5:
				$stamp = strtotime(date('Y-m-d').' -5 days');
				break;
			case 6:
				$stamp = strtotime(date('Y-m-d').' -6 days');
				break;
		}
		
		$week_start_day = date("d",$stamp);
		$week_month_start = date("m",$stamp);
		$week_year_start = date("Y",$stamp);
		
		for ($counter = 0; $counter < $weeks; $counter++) {
			$endpoints = array();
			$stamp = strtotime($week_year_start.'-'.$week_month_start.'-'.$week_start_day.' -'.$counter.' weeks');
			$endpoints['start'] = date("Y-m-d",$stamp);
			$stamp = strtotime($endpoints['start'].' +6 days');
			$endpoints['end'] = date("Y-m-d",$stamp);
			$dates[] = $endpoints;
		}
		
		return $dates;
		
	}

}