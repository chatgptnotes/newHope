<?php
class DischargeSummary extends AppModel {

	public $name = 'DischargeSummary';
   //public $actsAs = array('Cipher' => array('autoDecypt' => true,'cipher'=>array('complaints','general_examine',/* 'final_diagnosis', 'present_condition'*/'advice')));  
	public $validate = array(
                'review_on' => array(
										'rule' => "notEmpty",
										'message' => "Please enter review date."
									),
				 
				 
		);
	 
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
    
    
	public function insertDischargeSummary($data=array()){
                  $session = new cakeSession();
      		$drug			= ClassRegistry::init('PharmacyItem');      	
      		$dischargedDrug	= ClassRegistry::init('DischargeDrug');  
      		$dischargedSurgery	= ClassRegistry::init('DischargeSurgery');
      		$optAppointment	= ClassRegistry::init('OptAppointment');  	  	
      			
      		//$dateFormat	= ClassRegistry::init('DateFormatComponent');
      		
      		if(!empty($data["DischargeSummary"]['review_on'])){
      			$splittedText  = explode(' ',$data["DischargeSummary"]['review_on']);
      			$data["DischargeSummary"]['review_on'] = DateFormatComponent::formatDate2STD($data["DischargeSummary"]['review_on'],Configure::read('date_format'));
      		}
      		if(!empty($data["DischargeSummary"]['anti_discharge_date'])){
      			$splittedText  = explode(' ',$data["DischargeSummary"]['anti_discharge_date']);
      			$data["DischargeSummary"]['anti_discharge_date'] = DateFormatComponent::formatDate2STD($data["DischargeSummary"]['anti_discharge_date'],Configure::read('date_format'));
       		}
      		if(!empty($data["DischargeSummary"]['requested_start_date'])){
      			$splittedText  = explode(' ',$data["DischargeSummary"]['requested_start_date']);
      			$data["DischargeSummary"]['requested_start_date'] = DateFormatComponent::formatDate2STD($data["DischargeSummary"]['requested_start_date'],Configure::read('date_format'));
      		}
      		 
      		if(isset($data['DischargeSummary']['id']) && !empty($data['DischargeSummary']['id'])){
      			
      			//set id for update d record
      			$data['DischargeSummary']['modify_time']= date("Y-m-d H:i:s");
	       		$data['DischargeSummary']["modified_by"] =  $session->read('userid');
	       		
	       		if(empty($data['DischargeSummary']['discharge_service']))
	       			$data['DischargeSummary']['discharge_service'] = implode(',',$data['DischargeSummary']['discharge_service']);
	       		//debug($data['DischargeSummary']['discharge_service']);
	       		//exit;
      		 
      			$DischargeSummary_id =$data['DischargeSummary']['id'] ; 
      			
      		}else{   
      			
      			
      			$data['DischargeSummary']['create_time'] = date("Y-m-d H:i:s");
	       		$data['DischargeSummary']["created_by"]  =  $session->read('userid'); 
	       		
      		}   
      		
      		
      		
      		$DischargeSummarySave  = $this->save($data);  //return of main query
      	      		$errors = $this->invalidFields();
      		if($errors){
      			return false ;
      		}
      		if(empty($DischargeSummary_id)){
      			$DischargeSummary_id = $this->getInsertID();
      		}
      		//EOF check and insert diagnosis of patient
      		//BOF OT  
      		
      		foreach($data['DischargeSurgery'] as $surgery =>$sergeryArr){
      			
      			if(!empty($sergeryArr['surgery_schedule_date'])){ 
      				
		      		//Also update same entry in optAppointment
		      		if(!empty($sergeryArr['opt_appointment_id']) && !empty($sergeryArr['surgery_schedule_date'])){ 
		      			
		      			$optAppointmentArr['id'] = $sergeryArr['opt_appointment_id'] ;
		      			$splitSurgeryDateTime = explode(" ",$sergeryArr['surgery_schedule_date']) ;//split date n time 
		      			 
		      			$optAppointmentArr['start_time'] = $splitSurgeryDateTime[1] ;
		      			$optAppointmentArr['schedule_date'] = DateFormatComponent::formatDate2STD($splitSurgeryDateTime[0],Configure::read('date_format')) ;
		      			$optAppointmentArr['anaesthesia'] = $sergeryArr['anaesthesia'] ;
		      			//$optAppointmentArr['description'] = $sergeryArr['description'] ; 
		      			$optAppointmentArr['department_id'] = $sergeryArr['anaesthesian_id'] ;
		      			$optAppointmentArr['doctor_id'] = $sergeryArr['surgon_id'] ;
		      			$optAppointmentArr['description'] = $sergeryArr['description'] ; 
		      			$optAppointment->save($optAppointmentArr);
		      			$optAppointment->id='';
		      		}else{//EOF OT update
		      			
		      			if(/*isset($sergeryArr['id']) && */!empty($sergeryArr['id'])){
		      			//set id for update d record
		      			$sergeryArr['modify_time']= date("Y-m-d H:i:s");
			       		$sergeryArr["modified_by"] =  $session->read('userid');  
			      		}else{      			
			      			$sergeryArr['create_time'] = date("Y-m-d H:i:s");
				       		$sergeryArr["created_by"]  =  $session->read('userid');     			
			      		}
			      		if(!empty($sergeryArr['surgery_schedule_date'])){
			      			$splittedText  = explode(' ',$sergeryArr['surgery_schedule_date']);
			      			$sergeryArr['surgery_schedule_date'] = DateFormatComponent::formatDate2STD($sergeryArr['surgery_schedule_date'],Configure::read('date_format'));
			      		}  
			      		$sergeryArr['patient_id'] = $data["DischargeSummary"]['patient_id'];
			      		$sergeryArr['discharge_summary_id'] = $DischargeSummary_id;
			      		
		      			$dischargedSurgery->save($sergeryArr);		      		
		      			//$dischargedSurgery->id='';
		      		}
      			}
      		}
      		
      		//EOF OT
      	    $dischargedDrug->deleteAll(array('DischargeDrug.discharge_summaries_id' => $DischargeSummary_id), false); 

      		//BOF check and insert drugs
      		foreach($data['drug'] as $key =>$value){   
      			if(!empty($value)){   			
	      			$drugResult= $drug->find('first',array('fields'=>array('id','name'),'conditions'=>array('PharmacyItem.name'=>$value,"PharmacyItem.pack"=>$data['Pack'][$key])));      			 
	      			$drug->id ='';
	      			$dischargedDrug->id = '';
	      			if($drugResult){
	      				$data['SuggestedDrug']['drug_id'] = $drugResult['PharmacyItem']['id'];
	      			}else{
	      				$drug->save(array('name'=>$value,'pack'=>$data['Pack'][$key],'location_id'=> $session->read('locationid')));      				 
	      				$data['SuggestedDrug']['drug_id']= $drug->getInsertID();
	      			}    
	      			//BOF check and insert diagnosis drugs of patient	      			
	      			$data['SuggestedDrug']['discharge_summaries_id']=$DischargeSummary_id; 
      				$data['SuggestedDrug']['route']=  $data['route'][$key];
            			$data['SuggestedDrug']['dose']= $data['dose'][$key]; 
            			$data['SuggestedDrug']['frequency']= $data['frequency'][$key];
            			$data['SuggestedDrug']['quantity']= $data['quantity'][$key]; 
            			$data['SuggestedDrug']['remark']= $data['remark'][$key];
                              if(empty($data['is_sms_checked'][$key])){
                                    $data['is_sms_checked'][$key]=0;
                              }
                              $data['SuggestedDrug']['is_sms_checked']= $data['is_sms_checked'][$key];
                              $data['SuggestedDrug']['start_date']= DateFormatComponent::formatDate2STD($data['start_date'][$key],Configure::read('date_format'));   
                             # debug(DateFormatComponent::formatDate2STD($data['start_date'][$key],Configure::read('date_format')));
                              #debug(date('Y-m-d H:i:s', strtotime(DateFormatComponent::formatDate2STD($data['start_date'][$key],Configure::read('date_format')) . ' +'.$data['dose'][$key].' day')));
                              $data['SuggestedDrug']['end_date']= date('Y-m-d H:i:s', strtotime(DateFormatComponent::formatDate2STD($data['start_date'][$key],Configure::read('date_format')) . ' +'.($data['dose'][$key]-1).' day'));    
      				if(is_array($data['drugTime'][$key])){	      			    
	      			    $data['SuggestedDrug']['first']=  isset($data['drugTime'][$key][0])?$data['drugTime'][$key][0]:'';
	      			    $data['SuggestedDrug']['second']= isset($data['drugTime'][$key][1])?$data['drugTime'][$key][1]:''; 
	      			    $data['SuggestedDrug']['third']= isset($data['drugTime'][$key][2])?$data['drugTime'][$key][2]:'';
	      			    $data['SuggestedDrug']['forth']= isset($data['drugTime'][$key][3])?$data['drugTime'][$key][3]:'';      			    
	      			}	      			 
	      			$dischargedDrug->save($data['SuggestedDrug']);	      			 
      				//EOF check and insert diagnosis drugs of patient       			
      			}
      		}
                 # exit;
      		return $DischargeSummary_id  ;
      		//EOF check and insert drugs     		    		
      }
      
      function insertDischargeSummaryData($data = array()){
      		$session = new cakeSession();
      		
      		if(!empty($data["DischargeSummary"]['anti_discharge_date']))
      			$data["DischargeSummary"]['anti_discharge_date'] = DateFormatComponent::formatDate2STD($data["DischargeSummary"]['anti_discharge_date'],Configure::read('date_format'));
      		
      		if(!empty($data["DischargeSummary"]['requested_start_date']))
      			$data["DischargeSummary"]['requested_start_date'] = DateFormatComponent::formatDate2STD($data["DischargeSummary"]['requested_start_date'],Configure::read('date_format'));
      		
      		if(!empty($data["DischargeSummary"]['review_on']))
      			$data["DischargeSummary"]['review_on'] = DateFormatComponent::formatDate2STD($data["DischargeSummary"]['review_on'],Configure::read('date_format'));
      		
      		if(!empty($this->request->data['DischargeSummary']['bp']['1']))
      			$data['DischargeSummary']['bp']= implode('/',$data['DischargeSummary']['bp']);
      		else
      			$data['DischargeSummary']['bp']= $data['DischargeSummary']['bp']['0'];
      		
      		if(!empty($data['DischargeSummary']['discharge_service']))
      			$data['DischargeSummary']['discharge_service'] = implode('|',$data['DischargeSummary']['discharge_service']);
      		
      		if(!empty($data['DischargeSummary']['discharge_diet']))
      			$data['DischargeSummary']['discharge_diet'] = implode('|',$data['DischargeSummary']['discharge_diet']);
      		
      		if(!empty($data['DischargeSummary']['rn_discharge_instruction']))
      			$data['DischargeSummary']['rn_discharge_instruction'] = implode('|',$data['DischargeSummary']['rn_discharge_instruction']);
      		
      		if(!empty($data['DischargeSummary']['additional_discharge_instruction']))
      			$data['DischargeSummary']['additional_discharge_instruction'] = implode('|',$data['DischargeSummary']['additional_discharge_instruction']);
      		
      		if(!empty($data['DischargeSummary']['frequent_contact_number']))
      			$data['DischargeSummary']['frequent_contact_number'] = implode('|',$data['DischargeSummary']['frequent_contact_number']);
      		
      		if(!empty($data['DischargeSummary']['consult_to_schedule']))
      			$data['DischargeSummary']['consult_to_schedule'] = implode('|',$data['DischargeSummary']['consult_to_schedule']);
      		
      		if(!empty($data['DischargeSummary']['call_provider']))
      			$data['DischargeSummary']['call_provider'] = implode('|',$data['DischargeSummary']['call_provider']);
      		
      		if(!empty($data['DischargeSummary']['activity_limitation']))
      			$data['DischargeSummary']['activity_limitation'] = implode('|',$data['DischargeSummary']['activity_limitation']);
      		
      		if(isset($data['DischargeSummary']['id']) && !empty($data['DischargeSummary']['id'])){
      			$data['DischargeSummary']['modify_time']= date("Y-m-d H:i:s");
      			$data['DischargeSummary']["modified_by"] =  $session->read('userid');
      			$data['DischargeSummary']["location_id"] =  $session->read('locationid');
      		}else{
      			$data['DischargeSummary']['create_time'] = date("Y-m-d H:i:s");
      			$data['DischargeSummary']["created_by"]  =  $session->read('userid');
      			$data['DischargeSummary']["location_id"] =  $session->read('locationid');
      		}
      		
      		$DischargeSummarySave  = $this->save($data);
      		$data['DischargeSummary']["id"] = $this->id;
      		$this->insertDischargeDrug($data);
      		
      		return $DischargeSummarySave;
      	
      	
      }
      
      function insertDischargeDrug($data= array()){
      	
      	$session = new cakeSession();
      	$DischargeDrug = ClassRegistry::init('DischargeDrug');
      	for($i=1;$i<=count($data['SuggestedDrug']);$i++){
      	
      	if(!empty($data['SuggestedDrug'][$i]['start_date']))
      		$data['SuggestedDrug'][$i]['start_date'] = DateFormatComponent::formatDate2STD($data['SuggestedDrug'][$i]['start_date'],Configure::read('date_format'));
      	
      	if(!empty($data['SuggestedDrug'][$i]['end_date']))
      		$data['SuggestedDrug'][$i]['end_date'] = DateFormatComponent::formatDate2STD($data['SuggestedDrug'][$i]['end_date'],Configure::read('date_format'));
      	
      	$data['SuggestedDrug'][$i]['patient_id'] = $data['DischargeSummary']['patient_id'];
      	$data['SuggestedDrug'][$i]['discharge_summaries_id'] = $data['DischargeSummary']['id'];
      	$DischargeDrug->id = '';
      	if(!empty($data['SuggestedDrug'][$i]['drug_id']))
      	$DischargeDrug->save($data['SuggestedDrug'][$i]);
      
      	}	
      	return true;
      	
      }
      
     
}