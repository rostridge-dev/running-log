<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flot {

	/**
	 * Return the JS includes for Flot
	 *
	 * @return string $js The string representing the JS includes for Flot
	 */
    public function returnJS() {
	
		$js = "";
		$js .= "<script src=\"".base_url()."js/jquery.flot.min.js\"></script>\n";
		$js .= "<script src=\"".base_url()."js/jquery.flot.categories.min.js\"></script>\n";
		$js .= "<script src=\"".base_url()."js/jquery.flot.time.min.js\"></script>\n";
		
		return $js;
	}
		
}