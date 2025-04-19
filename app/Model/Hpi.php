<?php

 /* Hpi model
*
* PHP 5
*
* @copyright     Copyright 2011 Drmhope Inc.  
* @link          http://www.klouddata.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Aditya Chitmitwar
*/
class Hpi extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'Hpi';

	

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	*/
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	public function saveHpi($data=array(),$patient_id){
		debug($data);
		exit;
		$session = new cakeSession();
		$keyMain=array_keys($data['subCategory_examination']);
		for($i=0;$i<count(array_keys($data['subCategory_examination']));$i++){
			$subCategory[]=array_keys($data['subCategory_examination'][$keyMain[$i]]);
		}
		$this->deleteAll(array('patient_id'=>$patient_id));
		
		 for($i=0;$i<=count($data['subCategory_examination']);$i++){
		 	for($j=0;$j<count($data['subCategory_examination'][$keyMain[$i]]);$j++){
		 		if($data['subCategory_examination'][$keyMain[$i]][$subCategory[$i][$j]]=='1'){
		 			$category=$keyMain[$i];
		 			$category_sub=$subCategory[$i][$j];
		 			$this->saveAll(array('patient_id'=>"$patient_id",'category_id'=>"$category",'sub_category_id'=>"$category_sub",'location_id'=>$session->read('locationid')));
		 		}

		 		
		 	}
		 	
		} 
		return true;
	}
}
?>