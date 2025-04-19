<?php
/**
 * 
 * @author Mrunal Matey
 * shell uses to import radiology image from external drive to system
 */
	App::uses('ConnectionManager', 'Model');
	App::uses('AppModel', 'Model');
	App::uses('Component', 'Controller');
	App::uses('TariffStandard', 'Model');
	
	error_reporting(~E_NOTICE && ~E_WARNING);
class ImportRadiologyImageShell extends AppShell {
	public $name = 'ImportRadiologyImage';
	public function main() {
		$this->getRadiologyImage();
	}

	public function getRadiologyImage(){
		$dataSource = ConnectionManager::getDataSource('default');
		$confDeafult = ConnectionManager::$config->defaultHospital;
		$this->database = $confDeafult['database'];
		
		App::uses('CakeSession', 'Model/Datasource'); 
		App::uses('Patient', 'Model');
		$cakeSessionObj = new CakeSession(); 
		$PatientModel = new Patient(null,null,$this->database);
		
		$ftp_conn = ftp_connect('192.168.1.228') or die("Could not connect to 192.168.1.228");
		$log_in = ftp_login($ftp_conn, 'hope', 'hope12345');
		$contents = ftp_nlist($ftp_conn, ".");
		foreach($contents as $value){
			$val = explode(' ',$value);				//get array to find admission_id
			foreach($val as $id){
				$patient = $PatientModel->find('first',array(
					'conditions'=>array('Patient.admission_id like'=>$id),
					'fields'=>array('Patient.id','Patient.location_id','Patient.admission_id','Patient.radiology_images')
				));
				
				if(!empty($patient['Patient']['id'])){
					$images = ftp_nlist($ftp_conn, $value);
					$imagesArr = implode(',', $images);
					$patientArray['id'] = $patient['Patient']['id'];
					$patientArray['radiology_images'] = $imagesArr;
					if($PatientModel->save($patientArray,array('callbacks' => false))){
						echo "Radiology Images succesfully saved for ".$patient['Patient']['admission_id']."\n";
					}
					$PatientModel->id = ''; 
				}
			
			}
		}// end of contenet foreach
	}//end of getRadiologyImage function
	
	

}//END main function