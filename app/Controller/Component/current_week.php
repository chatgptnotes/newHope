<?php
/**
 * CurrentWeek file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class CurrentWeekComponent extends Component {
	
	function get_week() {
		$currentDay = date('l');
		if($currentDay == 'Monday'){
			$timestampFirstDay = strtotime('monday');
		}else{
			$timestampFirstDay = strtotime('last monday');
		}
		$currentDay = $timestampFirstDay;
		$weekArray=array();
		for ($i = 0 ; $i < 7 ; $i++) {
		    array_push($weekArray, date('Y-m-d', $currentDay));
		    $currentDay += 24 * 3600;
		}
		return $weekArray;
	}
}