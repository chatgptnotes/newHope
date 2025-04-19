
<?php

/* 
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
class NewInsurance extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'NewInsurance';

	public $useTable='new_insurances';

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
	/* public function patientsinsurance($data=array()){
		$newInsurance = ClassRegistry::init('NewInsurance');
		$TariffStandard = ClassRegistry::init('TariffStandard');
		$insuranceCompany = ClassRegistry::init('InsuranceCompany');
		$countries = ClassRegistry::init('Country');
		$States = ClassRegistry::init('State');
		$getPatients = ClassRegistry::init('Patient');
		$dateFormat = new DateFormatComponent();
		if(!empty($data)){
			$efdate = $dateFormat->formatDate2STD($data['NewInsurance']['effective_date'],Configure::read('date_format_us'));
			$subscriberdate = $dateFormat->formatDate2STD($data['NewInsurance']['subscriber_dob'],Configure::read('date_format_us'));
			if(!empty($data['NewInsurance']['upload_card']['name'])){
				$file = $data['NewInsurance']['upload_card'];
				move_uploaded_file($file['tmp_name'], WWW_ROOT.'uploads'.DS.'patient_images'.DS.'thumbnail'.DS.$file['name']);
				$data['NewInsurance']['upload_card'] = $file['name'];
			}
			else if(!empty($data['Person']['web_cam_card'])){
				$im = imagecreatefrompng($data['Person']['web_cam_card']);
	
				if($im){
					$imagename= "insurancecard_".mktime().'.png';
						
					$is_uploaded = imagejpeg($im,WWW_ROOT.'/uploads/patient_images/thumbnail/'.$imagename);
					if($is_uploaded){
	
						$data["NewInsurance"]['upload_card']  = $imagename ;
	
					}
				}else{
					unset($data["NewInsurance"]['upload_card']);
				}
	
			}
			else {
				unset($data['NewInsurance']['upload_card'] );
			}
			if($newInsurance->saveAll($data)){
				return true;
				
			}
			else{
				return false;
				
			}
			//$this->Session->setFlash(__('Insurance has been saved', true));
				
	
		}
	} */
}
?>


