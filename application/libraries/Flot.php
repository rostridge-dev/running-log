<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flot {
	
	/**
	 * Return the JS that initializes the front page graph
	 *
	 * @param string $data The JS data string to be graphed
	 * @param datestamp $start The start date of the graph edges
 	 * @param datestamp $end The end date of the graph edges
	 * @return string $js The string representing the JS includes for Flot
	 */
	public function returnFrontPageInit($data,$start,$end) {
		
		$start = date("Y,m,d",strtotime($this->utilCorrectDate($start)." -1 days"));
		$end = date("Y,m,d",strtotime($this->utilCorrectDate($end)." +1 days"));
		
		$js = "";
		
		if (strlen($data) > 0) {
			$js .= "		<script>\n";
			$js .= "			$(function() {\n";
			$js .= $data;
			$js .= "				$.plot(\"#placeholder\",\n";
			$js .= "					[\n";
			$js .= "						{label: \"&nbsp;Easy\", color: \"#85e685\", data: dataEasy, bars: {show: true, barWidth: 40000000, align: \"center\"}},\n";
			$js .= "						{label: \"&nbsp;Long\", color: \"#f28504\", data: dataLong, bars: {show: true, barWidth: 40000000, align: \"center\"}},\n";
			$js .= "						{label: \"&nbsp;Tempo\", color: \"#6dcff6\", data: dataTempo, bars: {show: true, barWidth: 40000000, align: \"center\"}},\n";
			$js .= "						{label: \"&nbsp;Race\", color: \"#ed1c24\", data: dataRace, bars: {show: true, barWidth: 40000000, align: \"center\"}},\n";
			$js .= "						{label: \"&nbsp;Interval\", color: \"#b658b7\", data: dataInterval, bars: {show: true, barWidth: 40000000, align: \"center\"}},\n";
			$js .= "						{label: \"&nbsp;Fartlek\", color: \"#dfd455\", data: dataFartlek, bars: {show: true, barWidth: 40000000, align: \"center\"}}\n";
			$js .= "					], {\n";
			$js .= "					xaxis: {\n";
			$js .= "						mode: \"time\",\n";
			$js .= "						minTickSize: [1, \"day\"],\n";
			$js .= "						min: (new Date(".$start.")).getTime(),\n";
			$js .= "						max: (new Date(".$end.")).getTime(),\n";
			$js .= "						timeformat: \"%Y/%m/%d\"\n";
			$js .= "					}\n";
			$js .= "				});\n";
			$js .= "			});\n";
			$js .= "		</script>\n";
		}
		
		return $js;
	}
	
	/**
	 * Builds a list of JS vars to be used by the Flot library
	 *
	 * @param array $list An array of running entry objects
	 * @return string $output The string representing the JS includes for Flot
	 */
	public function buildDailyGraph($list) {
		
		$output = $easy = $long = $tempo = $race = $interval = $fartlek = "";
		
		if (!empty($list)) {
			foreach ($list as $id => $entry) {
				$date = date("Y,m,d",strtotime($this->utilCorrectDate($entry->getDate())));
				$string = "[(new Date(".$date.")).getTime(),".$entry->getDistance()."],";
				switch ($entry->getTypeID()) {
					case 1:
						$race .= $string;
						break;
					case 2:
						$easy .= $string;
						break;
					case 3:
						$tempo .= $string;
						break;
					case 4:
						$long .= $string;
						break;
					case 5:
						$fartlek .= $string;
						break;
					case 6:
						$interval .= $string;
						break;
				}
			}
		}
		
		$output .= "				var dataRace = [".$this->utilTrim($race)."];\n";
		$output .= "				var dataEasy = [".$this->utilTrim($easy)."];\n";
		$output .= "				var dataTempo= [".$this->utilTrim($tempo)."];\n";
		$output .= "				var dataLong = [".$this->utilTrim($long)."];\n";
		$output .= "				var dataFartlek = [".$this->utilTrim($fartlek)."];\n";
		$output .= "				var dataInterval = [".$this->utilTrim($interval)."];\n";
		
		return $output;
			
	}

	/**
	 * Return the JS includes for Flot
	 *
	 * @return string $js The string representing the JS includes for Flot
	 */
    public function returnFooterJS() {
	
		$js = "";
		$js .= "		<script src=\"".base_url()."js/jquery.flot.min.js\"></script>\n";
		$js .= "		<script src=\"".base_url()."js/jquery.flot.categories.min.js\"></script>\n";
		$js .= "		<script src=\"".base_url()."js/jquery.flot.time.min.js\"></script>\n";
		
		return $js;
	}
	
	/**
	 * Simply strips any dangling commas off of JS data variables
	 *
	 * @param string $string The string to be formatted
	 * @return string $string The string after formatting
	 */
	private function utilTrim($string) {
		if (strlen($string) > 0) {
			$string = substr($string,0,-1);  
		}
		return $string;
	}
	
	/**
	 * Correction for Flot; changes the month value in a datestamp by reducing it by one
	 *
	 * @param string $string The string to be formatted
	 * @return string $string The string after formatting
	 */
	private function utilCorrectDate($string) {
		$string =  date("Y",strtotime($string))."-".date("m",strtotime($string." -1 month"))."-".date("d",strtotime($string));
		return $string;
	}
		
}