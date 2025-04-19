<?php

/* Message Model
 *
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
* @link          http://www.klouddata.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pawan Meshram
*/
class Message extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'Message';
	//public $actsAs = array('Cipher' => array('autoDecypt' => true));
	public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('final_diagnosis')));

	public $useTable = false;
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
	
	
	public function createCredentials($patientId,$email,$date){
		$from = Configure::read('mailFrom');
		//$this->loadModel('Patient');
		//$this->uses = array('Patient','Person');
		$patient = ClassRegistry::init('Patient');
		$person = ClassRegistry::init('Person');
		//	if(!empty($patientId)){
		$password = $this->generatePassword(8);
	
		$patient->bindModel(array(
				//'hasOne' => array(
				'belongsTo'=> array(
						'Person' =>array('foreignKey' => 'person_id') ,
	
						'Guarantor' =>array('foreignKey' => false,'conditions'=>array('Patient.person_id=Guarantor.person_id' ))
				),
		),false);
		$patientData = $patient->find('first',array('conditions'=>array('Patient.id' => $patientId)));
	
		$this->Person->id = $patientData['Person']['id'];
		$person->save(array('password' => sha1($password),'role_id' => 45,'modify_time'=>date('Y-m-d H:i:s'),'patient_credentials_created_date'=>$date));//hardcoded
		if(empty($email)){
			$email = $patientData['Person']['email'];
		}
		$this->username = $patientData['Patient']['patient_id'];
		$this->password = $password;
		//echo $patientData['Patient']['patient_id'].'<->'.($password); //exit;
		if($this->sendCredentialsOnEmail($patientData['Guarantor']['gau_email'],$email,$from,$patientData['Person']['patient_uid'],$password,$patientData['Person']['first_name'].' '.$patientData['Person']['last_name'])){
				
			return true;;
	
		}else{
			return false;
		}
	
		//$this->redirect(array('controller'=>'patients','action'=>'patient_information',$patientId));
	
		//}else{
		//$this->Session->setFlash(__('Patient id can not be null'),'default',array('class'=>'message'));
		//	$this->redirect(array('controller'=>'patients','action'=>'patient_information'));
		//}
	}
	
	
	
	public function sendCredentialsOnEmail($toGurantar,$to,$from,$userId,$password,$name){
	
		 
		$subject = "Credentials for Patient Portal";
	
		$message = "
		<html>
		<head>
		<title>HTML email</title>
		</head>
		<body>
		<p>Hello $name</p>
		<p>Please find the credentials below to login on patient portal</p>
		<table>
		<tr>
			<td>Website link:</td><td>".FULL_BASE_URL."</td>
		</tr>
		<tr>
			<td>Username:</td><td>$userId</td>
		</tr>
		<tr>
			<td>Password:</td><td>$password</td>
		</tr>
		</table>
		</body>
		</html>
		";
	
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	
		// More headers
			$headers .= 'From: '.$from . "\r\n";
		//--------------------------------------------------------------
			App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer/class.phpmailer.php'));
			$mail = new PHPMailer();
			
			///////////////////////
			$mail->IsSMTP();  // telling the class to use SMTP
			$mail->Host     = Configure::read('mailHost'); // SMTP server
			$mail->Port = Configure::read('mailPort');
			$mail->SMTPDebug  = 0;
			$mail->IsHTML(true);
			//Ask for HTML-friendly debug output
			$mail->Debugoutput = Configure::read('Debugoutput');
			$mail->AddAddress(trim($to));
			$mail->Username =Configure::read('smtpUsername');
			$mail->Password =Configure::read('smtpPassword');
			$mail->SetFrom(Configure::read('smtpUsername'), Configure::read('smtpUsername'));
			//$mail->AddReplyTo(Configure::read('mailFrom'), 'DrmHope');
			//////////////////////
			//$mail->Username = "pankajw@drmhope.com";
			//$mail->Password	="hopehospital" ;
			//$mail->ReturnPath = "info@drmhope.com";					
			//$mail->SetFrom($from, 'info@drmhope.com');
			//$mail->AddReplyTo($from, 'info@drmhope.com');				
			$mail->Subject  = $subject ;
			$mail->Body     = $message;
			$mail->WordWrap = 50;
		 	$send =  $mail->Send() ;
		 
			if($send){
				return true;
			}else{
				return false;
			}
		
	}
			
	/**
	 * Password generator function
	 *
	 */
	function generatePassword ($length = 8){
		// inicializa variables
		$password = "";
		$i = 0;
		$possible = "0123456789bcdfghjkmnpqrstvwxyz";
	
		// agrega random
		while ($i < $length){
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
	
			if (!strstr($password, $char)) {
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}

	/**
	 * function for send SMS to unicode in hindi.
	 * @param unknown_type Message.
	 * @Mahalaxmi
	 */
	public function utf8_to_unicode($str) {
        $unicode = array();
        $values = array();
        $lookingFor = 1;
        for ($i = 0; $i < strlen($str); $i++) {
            $thisValue = ord($str[$i]);
            if ($thisValue < 128) {
                $number = dechex($thisValue);
                $unicode[] = (strlen($number) == 1) ? '%u000' . $number : "%u00" . $number;
            } else {
                if (count($values) == 0)
                    $lookingFor = ( $thisValue < 224 ) ? 2 : 3;
                $values[] = $thisValue;
                if (count($values) == $lookingFor) {
                    $number = ( $lookingFor == 3 ) ?
                            ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ) :
                            ( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64
                            );
                    $number = dechex($number);
                    $unicode[] =
                            (strlen($number) == 3) ? "%u0" . $number : "%u" . $number;
                    $values = array();
                    $lookingFor = 1;
                } // if
            } // if
        }
        return implode("", $unicode);
    }
	/**
	 * function for send SMS to whovere we have to put Msg as well as Mobile no.
	 * @param unknown_type Message as well as Mobile no.
	 * @Mahalaxmi
	 */
	public function sendToSms($msg,$mobNo,$type=null){	
		
		if(!$this->is_connected()) return; //check for internet connectivity .
		/****BOF-Only Sending SMS *****/
			$sender_id=Configure::read('sender_id');           // sender id
			//$mob_no = $mobNo;     //123, 456 being recepients number To-Physician no or Patient no
			$userName=Configure::read('user_name');   ///User Name
			$pwd=Configure::read('pwd');               //your SMS gatewayhub account password
			//$msg=$msgText;      //your message		
			$msg = str_replace(array("\n", "\r"), ' ', $msg);
			$str = trim(str_replace(' ', '%20', $msg));		
			if($type=="Hexa"){
				$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&dc=8&gwid=2';
			//Its only for Unicode msg
			}else{
				$url=Configure::read('url').'?user='.$userName.'&pwd='.$pwd.'&to='.$mobNo.'&sid='.$sender_id.'&msg='.$str.'&fl=0&gwid=2';
			}	
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		$data=curl_exec($ch);		
		curl_close($ch);		
		$getExplode=explode("<",$data);			
		//For send Sms with confirmation		
		if(preg_match('/\s/',trim($getExplode[0])))
			return "no";
		else
			return "yes";
		/****EOF-Only Sending SMS *****/		
	}
	/**
	 * function for send SMS to whovere we have to put Msg as well as Mobile no.
	 * @param unknown_type Message as well as Mobile no.
	 * @Mahalaxmi
	 */
	public function sendToOneSMSForMultipleNoXml($msg,$mobNo=array(),$type=null){		
		/****BOF-Only Sending SMS *****/
		$sender_id=Configure::read('sender_id');           // sender id
		$userName=Configure::read('user_name');   ///User Name
		$pwd=Configure::read('pwd');               //your SMS gatewayhub account password		
		
		$headers = array("Content-type: text/xml;charset=\"utf-8\"","Accept: text/xml","Cache-Control: no-cache","Pragma: no-cache","SOAPAction: \"run\"");
		$url="http://login.smsgatewayhub.com/RestAPI/MT.svc/mt";		
		$xmlData='<SmsQueue><Account><User>'.$userName.'</User><Password>'.$pwd.'</Password><SenderId>'.$sender_id.'</SenderId><Channel>2</Channel><DCS>0</DCS><FlashSms>0</FlashSms><Route>1</Route></Account><Messages>';
		debug($mobNo);
		foreach($mobNo as $mobNos){
		
			if (strlen(trim($mobNos)) == '10') {			
			$str = trim(str_replace(' ', '%20', $msg));
			$xmlData.='<Message><Number>'.$mobNos.'</Number><Text>'.$str.'</Text></Message>';
			}else{
				continue;
			}
		}	
		$xmlData.='</Messages></SmsQueue>';		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		// Following line is compulsary to add as it is:
		curl_setopt($ch, CURLOPT_POSTFIELDS,$xmlData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		//debug($ch);
		$dataNew = curl_exec($ch);				
		curl_close($ch);
		$array_data = json_decode(json_encode(simplexml_load_string($dataNew)), true);
		//print_r('<pre>');
		//print_r($array_data);
		//print_r('</pre>');
		
		/****EOF-Only Sending SMS *****/
		return $array_data;
		
	}
	
	
	//check if internet is working on machine .
	function is_connected()
	{
		$connected = fsockopen("www.google.com", 80, $errno, $errstr, 10);
		//website, port  (try 80 or 443)
		if ($connected){
			$is_conn = true; //action when connected
			fclose($connected);
		}else{
			$is_conn = false; //action in connection failure
		}
		return $is_conn;
	}
	
	
	
}
?>