<?php

 /* PatientOrder model
*
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
* @link          http://www.klouddata.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Mayank Jain
*/
class PatientOrder extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'PatientOrder';

	

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
	public function createSenctence($sentenceArray=array(),$patientInfo=array()){
		$sentence=$sentenceArray['dose_type']." ".$sentenceArray['DosageForm']." ".
				$sentenceArray['route_administration']." ".$sentenceArray['frequency']." "."First Dose".$sentenceArray['start_date'];
		
		$saveArray['PatientOrder']['sentence']=$sentence;
		$saveArray['PatientOrder']['patient_id']=$patientInfo['patientId'];
		$saveArray['PatientOrder']['note_id']=$patientInfo['noteId'];
		$saveArray['PatientOrder']['name']=$sentenceArray['drugText'];
		$saveArray['PatientOrder']['status']='Ordered';
		$saveArray['PatientOrder']['type']='med';
		$saveArray['PatientOrder']['order_category_id']='33';
		
		//debug($saveArray);
		if($this->save($saveArray)){
			return true;
		}else{
			return false;
		}
		
	}
}
?>