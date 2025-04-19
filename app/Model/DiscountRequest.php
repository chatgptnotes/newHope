<?php
App::uses('AppModel', 'Model');
/*
 * @author Swati Newale
 * 
 */
class DiscountRequest extends AppModel {

	public $name = 'DiscountRequest';
	
  	public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
   function SaveRequest($data=array()){   	
   		$session = new cakeSession();
   		$patientModel = ClassRegistry::init('Patient');
      $configurationModel = ClassRegistry::init('Configuration');
      $messageModel = ClassRegistry::init('Message');
   		if($data['type']=="Amount"){
   			$data['discount_amount'] = $data['discount'];
   		}elseif($data['type']=="Percentage"){
   			$data['discount_percentage'] = $data['discount'];
   		}
   		$data['create_time'] = date("Y-m-d H:i:s");
   		$data['request_by']	 = $session->read('userid');
   		
   		$this->save($data);
   		
   		///BOF-Mahalaxmi-For send SMS to Owner  
   		$lastInsertId = $this->getInsertID();
   		//$getEnableFeatureChk=$_SESSION['sms_feature_chk'];
      $smsActive=$configurationModel->getConfigSmsValue('Discount Request');     
     

      if($smsActive){
        if(trim($data['type'])=='Amount'){
          $getAmount='Discount of Rs.'.$data['discount_amount'];
        }else if(trim($data['type'])=='Percentage'){
          $getAmountOfPercentage=($data['discount_percentage']/100)*$data['total_amount'];
          $getAmount='Discount of Rs.'.$getAmountOfPercentage;
        }else if(trim($data['type'])=='Refund'){       
          $getAmount='Refund of Rs. '.$data['refund_amount'];
        }
        $patientData = $patientModel->find('first',array('fields'=>array('Patient.lookup_name','Patient.is_discharge'),'conditions'=>array('Patient.id'=>$data['patient_id'],'Patient.is_deleted'=>0)));
        
        //$msgText=$getAmount.' is requested for pt. '.$patientData['Patient']['lookup_name'].'. The total bill amt is Rs.'.$data['total_amount'];   			
   			if($patientData['Patient']['is_discharge']!='1'){
          $showMsg= sprintf(Configure::read('OwnerDiscountRequest'),$getAmount,$patientData['Patient']['lookup_name'],$data['total_amount']);        
                 
          $messageModel->sendToSms($showMsg,Configure::read('owner_no')); 
   			       // $patientModel->sendToSmsPatient($patientData['Patient']['person_id'],'OwnerDiscountRequest',$lastInsertId);   
   			}			
   		}
   		///EOF-Mahalaxmi-For send SMS to Owner
   		return true;
   }
   
   function UpdateApprovalStatus($data = array()){
   	  $patientModel = ClassRegistry::init('Patient');
      $configurationModel = ClassRegistry::init('Configuration');
      $messageModel = ClassRegistry::init('Message');
   		$newData = array();
   		$newData['id'] = $data['id'];
   		$newData['modify_time'] =  date("Y-m-d H:i:s");
   		$newData['is_approved'] = $data['is_approved'];
   		$newData['is_approved_for_refund'] = $data['is_approved_for_refund'];
  		$this->save($newData);
  		///BOF-Mahalaxmi-For send SMS to Owner
  		if($data['is_approved']=='1' && !empty($data['id'])){
  		  $smsActive=$configurationModel->getConfigSmsValue('Discount Request Approval'); 
    		if($smsActive){	      
  				$patientModel->bindModel(array(
  						'belongsTo' => array(
  								'DiscountRequest' =>array('foreignKey' => false,'conditions'=>array('DiscountRequest.patient_id=Patient.id')),
  						)));
  				$patientData=$patientModel->find('first',array('fields'=>array('Patient.lookup_name','Patient.is_discharge','DiscountRequest.*'),'conditions'=>array('DiscountRequest.id'=>$data['id'],'DiscountRequest.is_deleted'=>0)));

          if(trim($patientData['DiscountRequest']['type'])=='Amount'){
            $getAmount='Requested discount amount of Rs.'.$patientData['DiscountRequest']['discount_amount'];
          }else if(trim($patientData['DiscountRequest']['type'])=='Percentage'){
            $getAmountOfPercentage=($patientData['DiscountRequest']['discount_percentage']/100)*$patientData['DiscountRequest']['total_amount'];
            $getAmount='Requested discount of Rs. '.$getAmountOfPercentage;
          }else if(trim($patientData['DiscountRequest']['type'])=='Refund'){
            //$getAmountOfRefundPercentage=($patientData['DiscountRequest']['refund_amount']/100)*$patientData['DiscountRequest']['total_amount'];
            $getAmount='Requested Refund of Rs. '.$patientData['DiscountRequest']['refund_amount'];
          }     
          
  				if($patientData['Patient']['is_discharge']!='1'){
            $showMsg= sprintf(Configure::read('OwnerDiscountRequestApproval'),$getAmount,$patientData['Patient']['lookup_name'],$patientData['DiscountRequest']['total_amount']);     
            $messageModel->sendToSms($showMsg,Configure::read('owner_no')); 
  				//$patientModel->sendToSmsPatient($patientData['Patient']['person_id'],'OwnerDiscountRequestApproval',$data['id']);
  				}
  			
  			}
		}
		///EOF-Mahalaxmi-For send SMS to Owner
   }
   
   function DeleteRequest($data = array())
   {
   		$session = new cakeSession();
   		$data['request_by']	 = $session->read('userid');
   		
   		$val = $this->find('first',array(
   								'conditions'=>array('DiscountRequest.patient_id'=>$data['patient_id'],'DiscountRequest.request_by'=>$data['request_by'],
   													'DiscountRequest.request_to'=>$data['request_to'],'DiscountRequest.type'=>$data['type'],
   													'DiscountRequest.payment_category'=>$data['payment_category']),
   								'order'=>array('DiscountRequest.id'=>"DESC")));
		
   		$this->id = $val['DiscountRequest']['id'];		//primaruy id of discount_request
   		$data['is_approved'] = 0;		// unset approval
   		$data['is_deleted'] = 1;		// delete
   		$this->save($data);			//update
   }
   
   
   function SetClosedStatus($data = array()){
		$discData = $this->find('first',array('conditions'=>array('patient_id'=>$data['patient_id'],'type'=>"Refund",'closed'=>0,'is_deleted'=>0,'payment_category'=>$data['payment_category'],'total_amount'=>$data['total_amount'])));
		if(!empty($discData['DiscountRequest']['id'])){
			$this->id = $discData['DiscountRequest']['id'];
			$newData['closed'] = 1;
			$this->save($newData);
		}
   }
  function SetClosedStatusForDiscount($data = array()){
  		
  		$discData = $this->find('first',array('conditions'=>array('patient_id'=>$data['patient_id'],'type'=>$data['disc_type'],'closed'=>0,'is_deleted'=>0,'payment_category'=>$data['payment_category'],'total_amount'=>$data['total_amount'])));
		if(!empty($discData['DiscountRequest']['id'])){
			$this->id = $discData['DiscountRequest']['id'];
			$newData['closed'] = 1;
			$this->save($newData);
			$this->id = "";
		}
   }
   
}
?>