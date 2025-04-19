<?php
//by swapnil to get the loggined data and users - 09.09.2015
class UserSession extends AppModel {

	public $specific = false; 
	public $useTable = 'cake_sessions'; 
	
	//function to unserialize session data
	function unserializesession( $data ){
		if(  strlen( $data) == 0) {
			return array();
		}
		// match all the session keys and offsets
		preg_match_all('/(^|;|\})([a-zA-Z0-9_]+)\|/i', $data, $matchesarray, PREG_OFFSET_CAPTURE);
		$returnArray = array();
		$lastOffset = null;
		$currentKey = '';
		foreach ( $matchesarray[2] as $value ) {
			$offset = $value[1];
			if(!is_null( $lastOffset)) {
				$valueText = substr($data, $lastOffset, $offset - $lastOffset );
				$returnArray[$currentKey] = unserialize($valueText);
			}
			$currentKey = $value[0];
			$lastOffset = $offset + strlen( $currentKey )+1;
		}
		$valueText = substr($data, $lastOffset );
		$returnArray[$currentKey] = unserialize($valueText);
		return $returnArray;
	}
	
	//function to get logined User
	function getLoggedInUsersInner() { 
		$sessions = $this->find('all', array('fields' => 'data'));
		$loggedInUsers = array();
		foreach ($sessions as $s => $val){
			$vals = $this->unserializesession($val['UserSession']['data']);
			if (isset($vals['Auth']['User']['id'])) {
				$loggedInUsers[] = $vals['Auth']['User']['id'];
			}
		}
		return array_unique($loggedInUsers);
	}
}
?>