<?php
/**
 * RadiologyReport model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       LaboratoryParameter Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanjari
 * @functions 	 : insertReport(insert/update radiology lab result data).	
 */
class RadiologyReport extends AppModel {
	
		public $name = 'RadiologyReport';
		/*public $hasMany = array(
        'LaboratoryParameter' => array(
            'className'  => 'LaboratoryParameter'           
        )
    	);*/
	  public $actsAs = array('Cipher' => array('autoDecypt' => true));   	 
	  
	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
		function insertReports($data=array(),$RadiologyResultID=null){
				$session = new cakeSession();
				$data['RadiologyReport']['radiology_result_id'] = $RadiologyResultID;
				if(empty($data['RadiologyReport']['id'])){
					$data['RadiologyReport']['created_by'] = $session->read('userid');
					//$data['RadiologyReport']['create_time'] = date("Y-m-d H:i:s");
					unset($data['RadiologyReport']['id']);
				}else{					 
					$data['RadiologyReport']['modified_by'] = $session->read('userid');
					$data['RadiologyReport']['modify_time'] = date("Y-m-d H:i:s");
				}			
				  
			 	$result = $this->save($data['RadiologyReport']);	
			 	$this->id='';
				return $result ;
			
		}
}