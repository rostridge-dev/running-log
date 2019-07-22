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
		$dates = $this->returnSelectedYear($current_year);
		
		return $dates;
		
	}
	
	/**
	 * Return the start and end dates for the selected year
	 *
	 * @return array $dates Returns the start and end dates for the desired period
	 */
    public function returnSelectedYear($year) {
		
		$dates = array();
		$dates['start'] = $year."-01-01";
		$dates['end'] = $year."-12-31";
		
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
		$dates = $this->returnPreviousMonthsByYear($months,$current_year,$current_month);
		
		return $dates;
		
	}
	
	/**
	 * Return a list of start dates and end dates for the last XX months
	 *
	 * @param integer $months The number of months that we want start and end dates for
	 * @param integer $year The starting year for the date ranges
	 * @param integer $month The starting month for the date ranges
	 * @return array $dates Returns the start and end dates for the desired period
	 */
    public function returnPreviousMonthsByYear($months,$year,$month) {
		
		$dates = array();
		for ($counter = 0; $counter < $months; $counter++) {
			$endpoints = array();
			$stamp = strtotime($year.'-'.$month.'-01 -'.$counter.' months');
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
		$start = date('Y-m-d');
		
		$dates = $this->returnPreviousWeeksbyDate($weeks,$start);
		
		return $dates;
		
	}
	
	/**
	 * Return a list of start dates and end dates for the last XX weeks
	 *
	 * @param integer $weeks The number of weeks that we want start and end dates for
	 * @return array $dates Returns the start and end dates for the desired period
	 */
    public function returnPreviousWeeksbyDate($weeks,$start) {
		
		$dates = array();
		$current_day_week = date("w",strtotime($start));
		
		switch ($current_day_week) {
			case 0:
				$stamp = strtotime($start);
				break;
			case 1:
				$stamp = strtotime($start.' -1 days');
				break;
			case 2:
				$stamp = strtotime($start.' -2 days');
				break;
			case 3:
				$stamp = strtotime($start.' -3 days');
				break;
			case 4:
				$stamp = strtotime($start.' -4 days');
				break;
			case 5:
				$stamp = strtotime($start.' -5 days');
				break;
			case 6:
				$stamp = strtotime($start.' -6 days');
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