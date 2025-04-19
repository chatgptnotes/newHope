<?php
/**
 * CqmList Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Aditya Chitmitwar
*/


class CqmList extends AppModel {

	public $name = 'CqmList';
	public $useTable = 'cqmlists';
	public $cacheQueries = false ;
	
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
}
?>