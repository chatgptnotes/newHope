<?php

/* Review Controller
 *
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @package       REview.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pankaj Wanjari
*/
class Review extends AppModel {
	 
	public $name = 'Review'; 
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
}
?>