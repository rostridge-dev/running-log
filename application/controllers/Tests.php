<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function models() {
		
		$ci =& get_instance();
		$test_output = "";
		
		/********************************************************************/
		// Unit test a user model, load the model and mock it up
		$test_alias = "unit_user";
		$this->load->library('unit_test',null,$test_alias);
		$this->{$test_alias}->use_strict(TRUE);
		$test_output .= "<h2>Tests for User model</h2>";
		$alias = "user";
		$ci->load->model('User_model',$alias);
		$mock = $ci->{$alias};
		
		// Test object type
		$test_name = "Create the user object";
		$this->{$test_alias}->run($mock,'is_object',$test_name);
		
		// Test getting the userID
		$test_name = "Get the user ID";
		$mock->setID(10);
		$test = $mock->getID();
		$result = 10;
		$this->{$test_alias}->run($test,$result,$test_name);
		
		// Test getting the username
		$test_name = "Get the username";
		$mock->setUsername("rostridge@digitalwanderer.net");
		$test = $mock->getUsername();
		$result = "rostridge@digitalwanderer.net";
		$this->{$test_alias}->run($test,$result,$test_name);
		
		// Test getting the user first name
		$test_name = "Get the user first name";
		$mock->setFirstName("Randy");
		$test = $mock->getFirstName();
		$result = "Randy";
		$this->{$test_alias}->run($test,$result,$test_name);
		
		// Test getting the user last name
		$test_name = "Get the user last name";
		$mock->setLastName("Ostridge");
		$test = $mock->getLastName();
		$result = "Ostridge";
		$this->{$test_alias}->run($test,$result,$test_name);
		
		// Run the Entries tests
		$test_output .= $this->{$test_alias}->report();
		
		echo $test_output;
	}
	
	/**
	 * Index Page for this controller.
	 *
	 */
	public function libraries() {
		
		$ci =& get_instance();
		$test_output = "";
		
		/********************************************************************/
		// Unit test the Times library, mock it up
		$test_alias = "unit_times";
		$this->load->library('unit_test',null,$test_alias);
		$this->{$test_alias}->use_strict(TRUE);
		$test_output .= "<h2>Tests for Time library</h2>";
		$alias = "times";
		$ci->load->library('Times',$alias);
		$mock = $ci->{$alias};
		
		// Test object type
		$test_name = "Create the Times object (new)";
		$this->{$test_alias}->run($mock,'is_object',$test_name);
		
		// Test convert value to seconds
		$test_name = "convertToSeconds (0 to 0)";
		$test = $mock->convertToSeconds('0');
		$result = 0;
		$this->{$test_alias}->run($test,$result,$test_name);
		
		$test_name = "convertToSeconds (00:00 to 0)";
		$test = $mock->convertToSeconds('00:00');
		$result = 0;
		$this->{$test_alias}->run($test,$result,$test_name);
		
		$test_name = "convertToSeconds (00:00:00 to 0)";
		$test = $mock->convertToSeconds('00:00:00');
		$result = 0;
		$this->{$test_alias}->run($test,$result,$test_name);
		
		$test_name = "convertToSeconds (00:01:59 to 119)";
		$test = $mock->convertToSeconds('00:01:59');
		$result = 119;
		$this->{$test_alias}->run($test,$result,$test_name);
		
		$test_name = "convertToSeconds (01:01:59 to 3719)";
		$test = $mock->convertToSeconds('01:01:59');
		$result = 3719;
		$this->{$test_alias}->run($test,$result,$test_name);
		
		// Test seconds value to standard time
		$test_name = "convertToRunningTime (0 to 00:00:00)";
		$test = $mock->convertToRunningTime(0);
		$result = '00:00:00';
		$this->{$test_alias}->run($test,$result,$test_name);
		
		$test_name = "convertToRunningTime (59 to 00:00:59)";
		$test = $mock->convertToRunningTime(59);
		$result = '00:00:59';
		$this->{$test_alias}->run($test,$result,$test_name);
		
		$test_name = "convertToRunningTime (119 to 00:01:59)";
		$test = $mock->convertToRunningTime(119);
		$result = '00:01:59';
		$this->{$test_alias}->run($test,$result,$test_name);
		
		$test_name = "convertToRunningTime (3719 to 01:01:59)";
		$test = $mock->convertToRunningTime(3719);
		$result = '01:01:59';
		$this->{$test_alias}->run($test,$result,$test_name);
		
		// Run the tests
		$test_output .= $this->{$test_alias}->report();
		
		/********************************************************************/
		// Unit test the Dates library, mock it up
		$test_alias = "unit_dates";
		$this->load->library('unit_test',null,$test_alias);
		$this->{$test_alias}->use_strict(TRUE);
		$test_output .= "<h2>Tests for Dates library</h2>";
		$alias = "dates";
		$ci->load->library('Dates',$alias);
		$mock = $ci->{$alias};
		
		// Test object type
		$test_name = "Create the Dates object (new)";
		$this->{$test_alias}->run($mock,'is_object',$test_name);
		
		// Get the start and end dates for selected year
		$test_name = "returnSelectedYear (2009)";
		$test = $mock->returnSelectedYear(2009);
		$result = array('start'=>'2009-01-01','end'=>'2009-12-31');
		$this->{$test_alias}->run($test,$result,$test_name);
		
		// Get the start and end dates for selected year
		$test_name = "returnPreviousMonthsByYear (start January 2009 for 6 months)";
		$test = $mock->returnPreviousMonthsByYear(6,2009,1);
		$result = array(
			0=>array('start'=>'2009-01-01','end'=>'2009-01-31'),
			1=>array('start'=>'2008-12-01','end'=>'2008-12-31'),
			2=>array('start'=>'2008-11-01','end'=>'2008-11-30'),
			3=>array('start'=>'2008-10-01','end'=>'2008-10-31'),
			4=>array('start'=>'2008-09-01','end'=>'2008-09-30'),
			5=>array('start'=>'2008-08-01','end'=>'2008-08-31')
		);
		$this->{$test_alias}->run($test,$result,$test_name);
		
		$test_name = "returnPreviousMonthsByYear (start August 2020 for 7 months [leap])";
		$test = $mock->returnPreviousMonthsByYear(7,2020,8);
		$result = array(
			0=>array('start'=>'2020-08-01','end'=>'2020-08-31'),
			1=>array('start'=>'2020-07-01','end'=>'2020-07-31'),
			2=>array('start'=>'2020-06-01','end'=>'2020-06-30'),
			3=>array('start'=>'2020-05-01','end'=>'2020-05-31'),
			4=>array('start'=>'2020-04-01','end'=>'2020-04-30'),
			5=>array('start'=>'2020-03-01','end'=>'2020-03-31'),
			6=>array('start'=>'2020-02-01','end'=>'2020-02-29')
		);
		$this->{$test_alias}->run($test,$result,$test_name);
		
		$test_name = "returnPreviousWeeksbyDate (start 2010-03-04 for 6 weeks)";
		$test = $mock->returnPreviousWeeksbyDate(6,'2010-03-04');
		$result = array(
			0=>array('start'=>'2010-02-28','end'=>'2010-03-06'),
			1=>array('start'=>'2010-02-21','end'=>'2010-02-27'),
			2=>array('start'=>'2010-02-14','end'=>'2010-02-20'),
			3=>array('start'=>'2010-02-07','end'=>'2010-02-13'),
			4=>array('start'=>'2010-01-31','end'=>'2010-02-06'),
			5=>array('start'=>'2010-01-24','end'=>'2010-01-30')
		);
		$this->{$test_alias}->run($test,$result,$test_name);
		
		// Run the tests
		$test_output .= $this->{$test_alias}->report();
		
		echo $test_output;
	}
}