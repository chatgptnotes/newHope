<?php
class GeneralComponent extends Component {
	
	public function billingFooter($locationId){
		$location = Classregistry::init('Location');
		$locationData = $location->read(null,$locationId);
		$footer="";
		if(!empty($locationData['Location']['address1'])){
			$footer.= $locationData['Location']['address1'].',';
		}
		if(!empty($locationData['Location']['address2'])){
			$footer.= $locationData['Location']['address2'].',';
		}
		if(!empty($locationData['City']['name'])){
			$footer.= $locationData['City']['name'].'-';
		}
		if(!empty($locationData['Location']['zipcode'])){
			$footer.=$locationData['Location']['zipcode'].',';
		}
		if(!empty($locationData['State']['name'])){
			$footer.= $locationData['State']['name'].',';
		}
		if(!empty($locationData['Location']['email'])){
			$footer.= 'Email-'.$locationData['Location']['email'];
		}
		#pr($footer);exit;
		return $footer;
	}
	
	function getCurrentStandardDateFormat($time_format){
		$date_format =$_SESSION['dateformat'];
		$date_format = explode("/",$date_format);
		if($date_format[0]=='yyyy') $date_format[0] = strtoupper($date_format[0]);
		if($date_format[1]=='yyyy') $date_format[1] = strtoupper($date_format[1]);
		if($date_format[2]=='yyyy') $date_format[2] = strtoupper($date_format[2]);
		
		$date_format =  substr($date_format[0], 0, 1)."/".substr($date_format[1], 0, 1)."/".substr($date_format[2], 0, 1);
		return $date_format." ".$time_format;
	}
	
	function GeneralDate($time=null){
		if(substr($_SESSION['dateformat'], -4, -1) == "yyy"){
			$datestring = substr($_SESSION['dateformat'], 0, -2);
		}else if(substr($_SESSION['dateformat'], 0, 4) == "yyyy"){
			$datestring = substr($_SESSION['dateformat'], 2);
		}else{
			$datestring = $_SESSION['dateformat'];
		}
		$format = $datestring.' '.$time;
			
		return trim($format);
	}
	
	
	/**
	 * @author Pawan Meshram
	 * @param unknown_type $start
	 * @param unknown_type $end
	 *
	 * To pass the format to JS with options like mm/dd/yyyy
	 */
	
	function GeneralDateForJS($time=null){
		return trim($this->Session->read('dateformat').' '.$time);
	}
	
	/**
	 * Funtion to generate random alphanumeric string
	 * @return string
	 * By Pankaj 
	 */
	public function generateRandomBillNo(){
		$characters = array(
		"A","B","C","D","E","F","G","H","J","K","L","M",
		"N","P","Q","R","S","T","U","V","W","X","Y","Z",
		"1","2","3","4","5","6","7","8","9");		
		$keys = array();
		$random_chars ='';		
		while(count($keys) < 7) {			
			$x = mt_rand(0, count($characters)-1);
			if(!in_array($x, $keys)) {
			   $keys[] = $x;
			}
		}		
		foreach($keys as $key){
		   $random_chars .= $characters[$key];
		}
		return $random_chars;	
	}
	
	/**
	 * get_words_until() Returns a string of delimited text parts up to a certain length
	 * If the "words" are too long to limit, it just slices em up to the limit with an ellipsis "..."
	 *
	 * @param $paragraph - The text you want to Parse
	 * @param $limit - The maximum character length, e.g. 160 chars for SMS
	 * @param string $delimiter - Use ' ' for words and '. ' for sentences (abbreviation bug) :)
	 * @param null $ellipsis - Use '...' or ' (more)' - Still respects character limit
	 *
	 * @return string
	 */
	function get_words_until($paragraph, $limit, $delimiter = ' ', $ellipsis = null){
		$parts = explode($delimiter, $paragraph);
	
		$preview = "";
	
		if ($ellipsis) {
			$limit = $limit - strlen($ellipsis);
		}
	
		foreach ($parts as $part) {
			$to_add = $part . $delimiter;
			if (strlen($preview . trim($to_add)) <= $limit) { // Can the part fit?
				$preview .= $to_add;
				continue;
			}
			if (!strlen($preview)) { // Is preview blank?
				$preview = substr($part, 0, $limit - 3) . '...'; // Forced ellipsis
				break;
			}
		}
	
		return trim($preview) . $ellipsis;
	}
	/**
	 * private package information
	 * @author gaurav chauriya
	 */
	public function getPackageNameAndCost($patientId){
		$patientObj = Classregistry::init('Patient');
		$privatePackagedDetails = $patientObj->find('first',array('fields'=>array('is_packaged'),'conditions'=>array('Patient.id'=>$patientId)));
		$packagedPatientId = $privatePackagedDetails['Patient']['is_packaged'];
		if($packagedPatientId){
			$estimateConsultantBillingObj = Classregistry::init('EstimateConsultantBilling');
			$estimateConsultantBillingObj->bindModel(array(
					'hasOne'=>array(
							'PackageEstimate'=>array('foreignKey'=>false,
									'conditions'=>array('EstimateConsultantBilling.package_estimate_id = PackageEstimate.id')),
							'Patient'=>array('foreignKey' => false,
									'conditions'=>array('Patient.is_packaged = EstimateConsultantBilling.patient_id'))
					)));
			$packageData = $estimateConsultantBillingObj->find('first',array('conditions'=>array('EstimateConsultantBilling.patient_id'=>$packagedPatientId),
					'fields'=>array('PackageEstimate.name','EstimateConsultantBilling.discount','EstimateConsultantBilling.total_amount','EstimateConsultantBilling.no_of_days',
							'EstimateConsultantBilling.days_in_icu','Patient.form_received_on','Patient.package_application_date')));
			$packageData['EstimateConsultantBilling']['discount'] = unserialize($packageData['EstimateConsultantBilling']['discount']);
	
			if( $packageData['EstimateConsultantBilling']['discount']['total_discount_package'] )
				$packageAmount = $packageData['EstimateConsultantBilling']['discount']['total_discount_package'];
			else
				$packageAmount = $packageData['EstimateConsultantBilling']['total_amount'];
	
			$totalPackageDays = (int) $packageData['EstimateConsultantBilling']['no_of_days'] + (int) $packageData['EstimateConsultantBilling']['days_in_icu'];
			$startDate = $packageData['Patient']['package_application_date'];
			$endDate = date('Y-m-d H:i:s', strtotime("+$totalPackageDays day", strtotime($packageData['Patient']['package_application_date'])));
	
			return array('packageName'=> $packageData['PackageEstimate']['name'],
					'packageAmount'=> $packageAmount,
					'startDate'=> $startDate,
					'endDate'=> $endDate);
		}else
			return false;
	}
	
	/*
		 * @autor Pawan Meshram
		 * @type (years or months)
		 * @value (e.g. 10)
		 */
		
		function convertYearsMonthsToDays($value,$type,$returnType='days'){
			if($type != 'dob')
			$startDate = date("Y-m-d",strtotime("-" . $value . " ". $type));
			else $startDate = ($type == 'days')? (int) ++$value:$value;
			$startDate = new DateTime($startDate);
			$endDate = new DateTime(date("Y-m-d"));
			$diff = $startDate->diff($endDate, true);
			return $diff->$returnType;
		}

		/*
		 * @autor Mahalaxmi 
		 * @type (years or months or Days) 
		 * @value (age)
		 */
		
		function convertYearsMonthsToDaysSeparate($ageValue){			
			$getExploArr=explode(" ",$ageValue);		
			$getExploArr=array_filter($getExploArr);
			$flagYear=false;
			$flagMonth=false;
			$getAge=null;
			foreach($getExploArr as $getExploArrs){
				$getLastStrValue=substr($getExploArrs,-1);	//find last character as D,M,Y				
				$getExactValueArr=explode($getLastStrValue,$getExploArrs);				
				$getExactValueArr=array_filter($getExactValueArr);		
			
				if($getLastStrValue=="Y" && $flagYear=="0"){
					$getAge=$getExactValueArr['0']." Yrs";
					$flagYear=true;					
				}else if($getLastStrValue=="M" && $flagYear=="0" && $flagMonth=="0"){
					$getAge=$getExactValueArr['0']." Months";
					$flagMonth=true;					
				}else if($getLastStrValue=="D" && $flagMonth=="0" && $flagYear=="0"){
					$getAge=$getExactValueArr['0']." Days";					
				}				
			}			
			return $getAge;		//Return Value as prioritywise means we have fill as year,Month,Day then first priority for year.If we have fill as Month Days then return only Month as well as if we have fill Days then return Days value Only.	
		}
                
    
        /*
         * function to send email 
         * @author : Swapnil
         * @created : 31.03.2016
         */
        public function sendMailwithAttachment($data=array()){ 

                App::import('Vendor', 'PHPMailer', array('file' => 'phpmailer/class.phpmailer.php'));  
                $mail = new PHPMailer(); 
                $mail->IsSMTP();  // telling the class to use SMTP
                $mail->SMTPAuth   = true;
                $mail->Host     = "smtp.gmail.com"; // SMTP server
                $mail->Port = 465;
                $mail->SMTPSecure = 'ssl';
                $mail->SMTPDebug  = 0;
                //Ask for HTML-friendly debug output
                $mail->Debugoutput = 'html'; 
                //$mail->Username = "info@hopehospital.com";
                //$mail->Password	="cmforhope" ; 
                $mail->Username = "mrunalm@drmhope.com";
                $mail->Password	="MRunal13" ;    
                
                //for multiple receiver
                foreach($data['to'] as $key => $val){
                    $mail->AddAddress($val,$key);
                }  
                $mail->SetFrom('info@hopehospital.com', 'Hope Hospitals');
                $mail->AddReplyTo('info@hopehospital.com', 'Hope Hospitals'); 
                $mail->Subject  = $data['subject'] ;
                $mail->Body     = $data['text'];
                $mail->WordWrap = 50;
                $mail->IsHTML(true);
                //$mail->Sign = array('certi', 'filename', '2');
                //temp attachment path			 
                $mail->AddAttachment($data['attachment']);
                //$file_to_attach = 'PATH_OF_YOUR_FILE_HERE';
                //$mail->AddAttachment($file_to_attach);
                if(!$mail->Send()) { 
                        return 'Mailer error: ' . $mail->ErrorInfo;
                } else {
                        //return  'Message has been sent.';
                        return true;
                }

        }
}