<?php
/**
 * Package Estimate Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 */


class PackageEstimate extends AppModel {

	public $name = 'PackageEstimate';
	public $useTable = 'package_estimates';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function savePackage($data = array()){
		$session = new cakeSession();
		$data['location_id'] =  $session->read('locationid') ;
		$data['created_by'] =  $session->read('userid') ;
		$data['create_time'] =  date('Y-m-d H:i:s') ;
		$data['modified_by'] =  $session->read('userid') ;
		$data['modify_time'] =  date('Y-m-d H:i:s') ;
		$data['misc_breakup'] =  serialize($data['misc_breakup']) ;
		$this->save($data);
		return $this->id;
	}
}
