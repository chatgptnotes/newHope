<?php
/**
 * Services controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Bed Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanjari
 * $function 	  :AEVD
 */
class ServicesController extends AppController {

	public $name = 'Services';
	public $uses = array('Service','Corporate','InsuranceCompany');
	public $helpers = array('Html','Form', 'Js','DateFormat','Number');
	public $components = array('RequestHandler','Email'); 
	
	
	public function admin_index() {#pr($this->request->data);exit;
			 $this->uses = array('SubService','Corporate','InsuranceCompany');
			 if(isset($this->request->data) && !empty($this->request->data)){
				 
				  
				//BOF pankaj
				if(!empty($this->request->data['Service']['credit_type_id'])){
					$corporate_id = $this->request->data['Service']['credit_type_id'];
					if($corporate_id == 1){
						$corporate_list = $this->Corporate->find('list');
						$corporate_type = 'corporate';
					} else if($corporate_id == 2){
						$corporate_list = $this->InsuranceCompany->find('list');
						$corporate_type = 'insurance';
					} else if($corporate_id == 0){
						$corporate_type = '';			
					}
					$this->set('corporate_type',$corporate_type);
					$this->set('corporate_list',$corporate_list);
				 
				}
				
				
				//EOF pankaj
			 	if(isset($this->request->data['Service']['corporate_id']) && $this->request->data['Service']['corporate_id'] != ''){
			 		$this->paginate = array(
			        	'limit' => Configure::read('number_of_rows'),
				    	'conditions' => array('is_deleted'=>0,'Service.corporate_id' => $this->request->data['Service']['corporate_id']),		 	 
				 		'fields'=>array('Service.id,Service.name,Service.description'),
			        	'order' => array(
			            'Service.id' => 'asc'
			        	)
    				);
			 	} else if(isset($this->request->data['Service']['insurance_company_id']) && $this->request->data['Service']['insurance_company_id'] != ''){
					$this->paginate = array(
			        	'limit' => Configure::read('number_of_rows'),
				    	'conditions' => array('is_deleted'=>0,'Service.insurance_company_id' => $this->request->data['Service']['insurance_company_id']),		 	 
				 		'fields'=>array('Service.id,Service.name,Service.description'),
			        	'order' => array(
			            'Service.id' => 'asc'
			        	)
    				);
				}
			 }else{
			 	$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
				    'conditions' => array('is_deleted'=>0),		 	 
				 	'fields'=>array('Service.id,Service.name,Service.description'),
			        'order' => array(
			            'Service.id' => 'asc'
			        )
    			);
			 }
			 
            $this->set('title_for_layout', __('Manage Services', true));	 
            	 
            $data = $this->SubService->find('all');
            $this->set('subService', $data);
            $this->set('service',$this->paginate('Service'));
            $corporates = $this->Corporate->find('list',array('conditions' => array('Corporate.is_deleted' => 0), 'fields' => array('Corporate.id', 'Corporate.name')));
	    	$this->set('corporates',$corporates);
	}
	
	//funtion to view city details
	public function admin_view($id = null) {
	    $this->set('title_for_layout', __('View Service Detail', true));
	    $this->uses = array('SubService');
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for services.', true));
			$this->redirect(array('action'=>'index'));
		}		 
		$this->set('services', $this->SubService->find('all',array('fields'=>array('Service.name,Service.description,SubService.service,SubService.cost'),
		'conditions'=>array('Service.id'=>$id,'Service.is_deleted'=>0))));
	}
	
	//funtion to add city 
	public function admin_add() {    
        $this->set('title_for_layout', __('Add Service', true));            
		$this->uses = array('SubService','Corporate');
        if (!empty($this->request->data)) {	
          //pr($this->request->data);exit;
        	$this->request->data['Service']['location_id'] = $this->Session->read('locationid');
			$this->Service->insertService($this->request->data,'insert');
			$errors = $this->Service->invalidFields();		 						
			
            if(!empty($errors)) {
                          $this->set("errors", $errors);
            }else {
                        $subServices = $this->request->data['SubService']['sub_service'];
                        $subServicesCost = $this->request->data['SubService']['cost'];
                        $latest_insert_id = $this->Service->getInsertId();
				foreach($subServices as $key =>$values){		
					 				
					$this->request->data['SubService']['service'] =  $values;	
					$this->request->data['SubService']['cost']    =  $subServicesCost[$key];														 
					$this->SubService->insertSubService($this->request->data,$latest_insert_id,'insert');			
					$this->SubService->id  = '' ;//set null to id to avoid								
				}
	                        $this->Session->setFlash(__('Service has been added successfully'),'default',array('class'=>'message'));
	  	 		$this->redirect(array("action" => "index", "admin" => true));
	            }
		}
		$corporates = $this->Corporate->find('list',array('conditions' => array('Corporate.is_deleted' => 0), 'fields' => array('Corporate.id', 'Corporate.name')));
	    $this->set('corporates',$corporates);	         
	} //EOF of function add
	 
	//funtion to delete role 
	public function admin_delete($id = null) {
		    $this->set('title_for_layout', __('- Delete Service', true));
		    $this->uses = array('SubService');
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for Service'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			}
			$this->Service->id  = $id ; 
			
			if ($this->Service->save(array('is_deleted'=>1))) {
				
				$this->SubService->updateAll(array('is_deleted'=>1),array('SubService.service_id'=>$id)) ;
				
				$this->Session->setFlash(__('Service deleted secessfully'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index'));
			}
			$this->Session->setFlash(__('There is some problem while processing your request ,Please try again'),'default',array('class'=>'error'));
		 	$this->redirect(array('action'=>'index'));
			
	}
	
	 
	
	public function admin_edit($id = null) {
		 	$this->set('title_for_layout', __('Edit Service Details', true));	
		 	$this->uses = array('SubService','Corporate');	 	            
			if (!empty($this->request->data)) {	
				$this->uses = array('SubService');
				$this->Service->insertService($this->request->data,'insert');
				$errors = $this->Service->invalidFields();					
			
	            if(!empty($errors)) {
	                          $this->set("errors", $errors);
	            }else {
	                $subServices = $this->request->data['SubService']['sub_service'];
	                $subServicesCost = $this->request->data['SubService']['cost'];
	                //delete add the instance of current srevice id from subService table n insert
	              //  $this->unbindModel(array('belongsTo'));
	                $this->SubService->deleteAll(array('SubService.service_id'=>$this->request->data['Service']['id']),false);
					foreach($subServices as $key =>$values){					 				
						$this->request->data['SubService']['service'] =  $values;	
						$this->request->data['SubService']['cost']    =  $subServicesCost[$key];														 
						$this->SubService->insertSubService($this->request->data,$this->request->data['Service']['id'],'insert');			
						$this->SubService->id  = '' ;//set null to id to avoid								
					}
		            $this->Session->setFlash(__('Service has been updated successfully'),'default',array('class'=>'message'));
		  	 		$this->redirect(array("action" => "index", "admin" => true));
		        }
			}else if(empty($this->request->data) && (empty($id)))	{
				 $this->Session->setFlash(__('There is some problem with update,Please try again.'),'default',array('class'=>'error'));
		  	 	 $this->redirect(array("action" => "index", "admin" => true));
			}
			
			$this->data = $this->Service->read(null,$id);
			$this->set('services', $this->SubService->find('all',array('fields'=>array('Service.name,Service.description,SubService.service,SubService.cost'),
			'conditions'=>array('Service.id'=>$id,'Service.is_deleted'=>0))));
			$corporates = $this->Corporate->find('list',array('conditions' => array('Corporate.is_deleted' => 0), 'fields' => array('Corporate.id', 'Corporate.name')));
	    	$this->set('corporates',$corporates);
	}
		
	//BOF billing activity
	public function add_service_bill($corporateId = ''){
		$this->set('title_for_layout', __('Add Billing Activity', true));
		$this->uses = array('SubServiceDateFormat','ServiceBill','Corporate');
		if($corporateId !=''){
			$this->set('service',$this->Service->find('all',array('conditions'=>array('corporate_id' => $corporateId))));
		}else{
			$this->set('service',$this->Service->find('all'));	
		}
		$corporates = $this->Corporate->find('list',array('conditions' => array('Corporate.is_deleted' => 0), 'fields' => array('Corporate.id', 'Corporate.name')));
	    if($corporateId != ''){
			$this->set('corporate',$corporates[$corporateId]);
			$this->set('corporateId',$corporateId);
	    }
		else{
	    	$this->set('corporate','');
		}
		if (!empty($this->request->data)) {				
				$data = $this->request->data ;
				$data["ServiceBill"]['date'] = $this->DateFormat->formatDate2STD($data["ServiceBill"]['date'],Configure::read('date_format'));
				//check for existance for date for a patient
				$count  =$this->ServiceBill->find('count',array('conditions'=>array('patient_id'=>$data['ServiceBill']['patient_id'],'date'=>$data["ServiceBill"]['date'])));
				 
				if($count>0){
					$this->Session->setFlash(__('Billing activity already present for same date'),'default',array('class'=>'error'));
            		//$this->redirect($this->referer());					
				}//EOF check
				else{
					$this->ServiceBill->insertServiceBill($data,'insert') ;
					$this->Session->setFlash(__('Billing activity added successfully'),'default',array('class'=>'message'));
	            	$this->redirect(array("controller" => "services", "action" => "service_bill_list"));		
				}								 				
		}		 
	}
	
	public function edit_service_bill($patient_id=null,$date=null){
		$this->set('title_for_layout', __('Edit Billing Activity', true));
		$this->uses = array('SubService','ServiceBill');
		$serviceData =$this->ServiceBill->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
 		$corporateId = $serviceData['ServiceBill']['corporate_id'];
 		
 		if($corporateId != ''){
			$this->set('service',$this->Service->find('all',array('conditions' => array('corporate_id' =>$corporateId))));
 		}else{
 			$this->set('service',$this->Service->find('all'));
 		}
		
		#$serviceBillData = $this->ServiceBill->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
		#pr($serviceBillData);exit;
		if (!empty($this->request->data)) {				
				$data = $this->request->data ;
				$data["ServiceBill"]['corporate_id'] = $corporateId;
				$data["ServiceBill"]['date'] = $this->DateFormat->formatDate2STD($data["ServiceBill"]['date'],Configure::read('date_format'));
				$count  =$this->ServiceBill->find('count',array('conditions'=>array('patient_id'=>$data['ServiceBill']['patient_id'],'date'=>$data["ServiceBill"]['date'])));
				//if($count){
					//$this->Session->setFlash(__('Billing activity already present for same date'),'default',array('class'=>'error'));
            		//$this->redirect($this->referer());					
				//}//EOF check
				//else{ 
					//delete previous entries and then insert.
					$this->ServiceBill->deleteAll(array('patient_id'=>$data['ServiceBill']['patient_id'],'date'=>$data["ServiceBill"]['date']),false);
					$this->ServiceBill->insertServiceBill($data,'insert') ;
					$this->Session->setFlash(__('Billing activity updated successfully', true));
	            	$this->redirect(array("controller" => "services", "action" => "service_bill_list"));
				//}							 				
		}
		
 		if(empty($patient_id) || empty($date)){
 			$this->Session->setFlash(__('Invalid process of editing ,Please try again'),'default',array('class'=>'error'));
            $this->redirect(array("controller" => "services", "action" => "service_bill_list"));
 		}
 		$serviceData =$this->ServiceBill->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
 		$corporateId = $serviceData['ServiceBill']['corporate_id'];
 		$this->ServiceBill->bindModel(array(
 								'belongsTo' => array( 											 
								'Patient' =>array(
											'foreignKey'=>'patient_id'				 
 											),							
 						))); 
 		
 	$this->data =$this->ServiceBill->find('all',array('fields'=>array('ServiceBill.*,Patient.lookup_name'),'conditions'=>array('ServiceBill.patient_id'=>$patient_id,'ServiceBill.date'=>$date)));
 		
 				 
	}
	
	
	public function view_service_bill($patient_id=null,$date=null){
		$this->set('title_for_layout', __('View Billing Activity', true));
		$this->uses = array('ServiceBill');
		$serviceData =$this->ServiceBill->find('first',array('conditions'=>array('patient_id'=>$patient_id)));
 		$corporateId = $serviceData['ServiceBill']['corporate_id'];
 		
		$this->ServiceBill->bindModel(array(
 								'belongsTo' => array( 											 
								'Patient' =>array(
											'foreignKey'=>'patient_id'				 
 											),							
 						))); 
 						
		if($corporateId != ''){
			$this->set('service',$this->Service->find('all',array('conditions' => array('corporate_id' =>$corporateId))));
 		}else{
 			$this->set('service',$this->Service->find('all'));
 		}				
		$this->data = $this->ServiceBill->find('all',array('fields'=>array('ServiceBill.*,Patient.lookup_name'),
					  'conditions'=>array('ServiceBill.patient_id'=>$patient_id,'ServiceBill.date'=>$date)));
               
		
	}
	
	public function print_service_bill($patient_id=null,$date=null){
		$this->set('title_for_layout', __('View Billing Activity', true));
		$this->uses = array('ServiceBill');
		$this->layout = false ;
		$this->ServiceBill->bindModel(array(
 								'belongsTo' => array( 											 
								'Patient' =>array(
											'foreignKey'=>'patient_id'				 
 											),							
 						))); 
 		$this->set('service',$this->Service->find('all'));				
		$this->data = $this->ServiceBill->find('all',array('fields'=>array('ServiceBill.*,Patient.full_name'),
					  'conditions'=>array('ServiceBill.patient_id'=>$patient_id,'ServiceBill.date'=>$date)));
		 
	}
	
	public function service_bill_list(){
		$this->set('title_for_layout', __('Billing Activity', true));
		$this->uses = array('SubService','ServiceBill');
		$this->ServiceBill->bindModel(array(
 								'belongsTo' => array( 											 
								'Patient' =>array(
											'foreignKey'=>'patient_id'				 
 											),
 								
 						)),false); 
 			
 		if(!empty($this->request->data)){	
 			$search_key = array('ServiceBill.is_deleted'=>0,'ServiceBill.location_id'=>$this->Session->read('locationid'));    	 
	    	$search_ele = $this->request->data['ServiceBill'] ;
	    	
	    	if(!empty($search_ele['lookup_name'])){
	    		    $search_key['Patient.lookup_name like '] = "%".$search_ele['lookup_name']."%" ;	
	    	}if(!empty($search_ele['admission_id'])){
	    		    $search_key['Patient.admission_id like '] = "%".$search_ele['admission_id'] ;	
	    	}if(!empty($search_ele['date'])){
	    			$search_ele['date'] = $this->DateFormat->formatDate2STD($search_ele['date'],Configure::read('date_format'));
	    		    $search_key['ServiceBill.date like '] = "%".$search_ele['date']."%" ;	
	    	}      	 
	    	$this->paginate = array(
				        'limit' => Configure::read('number_of_rows'),
				        'order' => array('ServiceBill.id' => 'desc'),
 						'fields'=>array('DISTINCT(ServiceBill.date),Patient.lookup_name,Patient.admission_id,ServiceBill.id,ServiceBill.date,ServiceBill.patient_id,ServiceBill.service_id,
										ServiceBill.sub_service_id'),	    
 						'conditions'=>$search_key,
 						'group'=>array('ServiceBill.date','ServiceBill.patient_id'),
	    				 		 
 						);
 			$this->ServiceBill->PaginateCount($search_key);			
	    	$this->set('service',$this->paginate('ServiceBill'));
	    }else{ 
	    	$this->paginate = array(
				        'limit' => Configure::read('number_of_rows'),
				        'order' => array('ServiceBill.id' => 'desc'),
 						'fields'=>array('DISTINCT(ServiceBill.date)','Patient.lookup_name,Patient.admission_id,ServiceBill.id,ServiceBill.date,ServiceBill.patient_id,ServiceBill.service_id,
										ServiceBill.sub_service_id'),	    
 						'conditions'=>array('ServiceBill.is_deleted'=>0,'ServiceBill.location_id'=>$this->Session->read('locationid')),
 						'group'=>array('ServiceBill.date','ServiceBill.patient_id'),
	    				 
	    				 
 						);				
 			$this->set('service',$this->paginate('ServiceBill'));
	    }	 		
		 
				
	} 
	
	function delete_service_bill($patient_id=null,$date=null){
		$this->uses = array('ServiceBill');
		if(empty($patient_id) || empty($date)){
 			$this->Session->setFlash(__('Invalid process of editing ,Please try again'),'default',array('class'=>'error'));
            $this->redirect(array("controller" => "services", "action" => "service_bill_list"));
 		}else{
			$this->ServiceBill->updateAll(array('is_deleted'=>1),array('patient_id'=>$patient_id,'date'=>$date));
			$this->Session->setFlash(__('Record deleted'),'default',array('class'=>'message'));
			$this->redirect(array("controller" => "services", "action" => "service_bill_list"));
 		}
	}
	//EOF billing activity
	
	function selectCorporate(){
		$this->uses = array('Corporate');
		$corporates = $this->Corporate->find('list',array('conditions' => array('Corporate.is_deleted' => 0, 'Corporate.location_id' => $this->Session->read('locationid')), 'fields' => array('Corporate.id', 'Corporate.name')));
	        $this->set('corporates',$corporates);
	    if(isset($this->request->data) && !empty($this->request->data)){
	    	$corporateId = $this->request->data['Service']['corporate_id'];
	    	if($corporateId != ''){
	    		$this->redirect(array("controller" => "services", "action" => "add_service_bill",$corporateId));
	    	}else{
	    		$this->redirect(array("controller" => "services", "action" => "add_service_bill"));
	    	}
	    }
		
	}

  public function getcorporate(){
	   if($this->params['isAjax']) {
		$corporate_id = $this->params->query['corporateType'];
		if($corporate_id == 1){
			$corporate_list = $this->Corporate->find('list');
			$corporate_type = 'corporate';
		} else if($corporate_id == 2){
			$corporate_list = $this->InsuranceCompany->find('list');
			$corporate_type = 'insurance';
		} else if($corporate_id == 0){
			$corporate_type = '';			
		}
		//pr($corporate_list);exit;
		$this->set(compact('corporate_type'));
		$this->set(compact('corporate_list'));
		$this->layout = 'ajax';
         $this->render('ajaxgetcorporate');
	 } 
	
	}
	
	
	public function getExpensesDetail($consultId,$month,$year){
		 
		$this->layout="advance_ajax";
		$this->uses=array('Patient','VoucherPayment','Billing','Laboratory','Radiology','PharmacySalesBill','SpotApproval');
		//debug($consultId);debug($month);debug($year);
		$fromDate=$year.'-'.$month.'-'.'01 00:00:00';
		$countDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$toDate=$year.'-'.$month.'-'.$countDays.' 23:59:59';
		$conditions['VoucherPayment.is_deleted '] = '0';
		$conditions['VoucherPayment.type like'] ='RefferalCharges';
		$conditions['VoucherPayment.date >='] = $fromDate;
		$conditions['VoucherPayment.date <='] = $toDate;
		$conditions['Patient.consultant_id'] = $consultId;
		$conditions['OR']=array(array('VoucherPayment.narration LIKE'=>"%"."Spot"."%") ,
				array('VoucherPayment.narration LIKE'=>"%"."Backing"."%"));
		$this->Patient->bindModel(array(
				'belongsTo'=>array(
						'VoucherPayment'=>array('type'=>'INNER','foreignKey'=>false,
								'conditions'=>array('VoucherPayment.patient_id=Patient.id')),
						'SpotApproval'=>array('type'=>'INNER','foreignKey'=>false, 
								'conditions' => array('SpotApproval.voucher_payment_id=VoucherPayment.id')),),				
				));
		$patData=$this->Patient->find('all',array('fields'=>array('Patient.id','Patient.lookup_name',
				'Patient.admission_type',
				'Patient.consultant_id','SpotApproval.*','VoucherPayment.date','VoucherPayment.id'),
				'conditions'=>array($conditions)));
		foreach($patData as $patientData){
			$patArray[$patientData['Patient']['id']]['name']=$patientData['Patient']['lookup_name'];
			if($patientData['SpotApproval']['type']=='S'){
				$patArray[$patientData['Patient']['id']]['spot']=$patArray[$patientData['Patient']['id']]['spot']+$patientData['SpotApproval']['amount'];
			}
			if($patientData['SpotApproval']['type']=='B'){
				$patArray[$patientData['Patient']['id']]['back']=$patArray[$patientData['Patient']['id']]['back']+$patientData['SpotApproval']['amount'];
			}
			$patArray[$patientData['Patient']['id']]['billAmt']=$this->Billing->getPatientTotalBill($patientData['Patient']['id'],$patientData['Patient']['admission_type']);
		}
		$this->set('patArray',$patArray);
		
		
	}
		
}//EOF class