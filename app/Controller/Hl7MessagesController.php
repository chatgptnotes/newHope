<?php
/**
 * HL7Message Controller file
 *
 * PHP 5.4.3
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
 */
class Hl7MessagesController extends AppController {

	public $name = 'Hl7Messages';
	public $uses = array('Hl7Message');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email','Auth','Session', 'Acl','Cookie');
	
	public function gen_HL7_Lab($patientid=null,$testid=null){
	
		$this->autoRender = false;
		$date = $this->request->data['LaboratoryToken']['curdate'];
		$MSH = $this->Hl7Message->generateHL7MSH($date);
		$PID = $this->Hl7Message->generateHL7PID($patientid);
		$ORC = $this->Hl7Message->generateHL7ORC($patientid,$testid);
		$OBR = $this->Hl7Message->generateHL7OBR($patientid,$testid); 
		$msg = $MSH."\n".$PID."\n".$ORC."\n".$OBR;
		$this->Hl7Message->save(array('message'=>$msg,'message_from'=>'lab','patient_id'=>$patientid));
		echo $msg;
		exit;
	}
	

	
}
?>