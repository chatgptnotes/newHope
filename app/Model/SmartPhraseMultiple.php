<?php
/**
 * SmartPhraseMultiple Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       SmartPhraseMultiple Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class SmartPhraseMultiple extends AppModel {

	public $specific = true;
	public $name = 'SmartPhraseMultiple';
	var $useTable = 'smart_phrase_multiple';
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	/**
	 * Function to insert Multiple Smart Phrase to master
	 * @param request array
	 * @return boolean true
	 */
	public function insertMultiplePhrase($data = array()){
	
		$session     = new cakeSession();
	
		$this->create();
		$value = $this->save($data['SmartPhraseMultiple']);
	
		return $value;
	
	}

}
?>