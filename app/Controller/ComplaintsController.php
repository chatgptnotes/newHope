<?php

/**
 * ComplaintsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Consents Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class ComplaintsController extends AppController {
	
	public $name = 'Complaints';
	public $uses = array('Complaint');
	public $helpers = array('Html','Form', 'Js','DateFormat','General');
	public $components = array('RequestHandler','Email', 'Session','DateFormat');
	
	function index(){
	
			$this->paginate = array(
		        'limit' => Configure::read('number_of_rows'),
		        'order' => array(
		            'Complaints.name' => 'asc'
		        ),
		        'conditions'=>array('Complaint.location_id'=>$this->Session->read('locationid'))
	    	);
                $this->set('title_for_layout', __('Manage Complaints', true));
	 			 
                $data = $this->paginate('Complaint');
                $this->set('data', $data); 
	}
	
	
	function add($complaint_id=null){
		$this->set('title_for_layout', __('Add Complaint', true));
		if($this->request->isPost()){ 
                        $this->request->data["Complaint"]["create_time"] = date("Y-m-d H:i:s");
                        $this->request->data["Complaint"]["modify_time"] = date("Y-m-d H:i:s");
                        $this->request->data["Complaint"]["created_by"] = $this->Session->read('userid');
                        $this->request->data["Complaint"]["modified_by"] = $this->Session->read('userid'); 
                        $this->request->data["Complaint"]["location_id"] = $this->Session->read('locationid');
                        //BOF coverting date
						if(!empty($this->request->data["Complaint"]['date'])){
	                		$last_split_date_time =  $this->request->data['Complaint']['date'];
	            			$this->request->data["Complaint"]['date'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format')) ;
                		}
						if(!empty($this->request->data["Complaint"]['time_of_resolution'])){
	                		$last_split_date_time =  $this->request->data['Complaint']['time_of_resolution'];
	            			$this->request->data["Complaint"]['time_of_resolution'] = $this->DateFormat->formatDate2STD($last_split_date_time,Configure::read('date_format')) ;
                		}
                        //EOF date convertion
                		if(($this->request->data["Complaint"]['resolved']==1 && (!empty($this->request->data["Complaint"]['time_of_resolution'])))){
                			$interval = $this->DateFormat->dateDiff($this->request->data["Complaint"]['date'],$this->request->data["Complaint"]['time_of_resolution']);               			
                			
							//EOF cal
							$timeDay 	= $interval->days;
							$timeDaySec = $timeDay*3600*24;
							$timeHr 	= $interval->h;
							$timeHrSec 	= $timeHr*3600;
							$timeMin 	= $interval->i;
							$timeMinSec = $timeMin*60;
							$timeSec 	= $interval->s;
							$timeSecSec = $interval->s  ;
						    $finalremTime  =  (int)$timeDaySec+(int)$timeHrSec+(int)$timeMinSec+(int)$timeSecSec;
							 
							$this->request->data["Complaint"]['resolution_time_taken'] = $finalremTime;
                		}else{
                			$this->request->data["Complaint"]['resolution_time_taken'] = "";
                		}
                		 
                        $this->Complaint->create();
                        $this->Complaint->save($this->request->data);
			
						$errors = $this->Complaint->invalidFields();
                        if(!empty($errors) || $interval->invert === 0) {
                        	if(!empty($this->request->data["Complaint"]['time_of_resolution'])){
                        		$this->request->data["Complaint"]['time_of_resolution']=$this->DateFormat->formatDate2Local($this->request->data["Complaint"]['time_of_resolution'],Configure::read('date_format'),true) ;
                        	}
                        	if(!empty($this->request->data["Complaint"]['date'])){
                        		$this->request->data["Complaint"]['date']=$this->DateFormat->formatDate2Local($this->request->data["Complaint"]['date'],Configure::read('date_format'),true) ;
                        	}
                        	$this->Session->setFlash(__('Please enter valid resolution date.'),'default',array('class'=>'error'));
                        	$this->request->data['Complaint']['resolution_time_taken']=="" ;                    	 
                            $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('Complaint has been added successfully'),'default',array('class'=>'message'));
  				 		   $this->redirect(array("action" => "index", "admin" => false));
            			}
		}
		 
		if($complaint_id){
			
			$this->Complaint->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'))));
			$result = $this->Complaint->find('first',array('conditions'=>array('Complaint.id'=>$complaint_id),'fields'=>array('Complaint.*','Patient.lookup_name')));	
			if(!empty($result["Complaint"]['time_of_resolution'])){
				$result["Complaint"]['time_of_resolution']=$this->DateFormat->formatDate2Local($result["Complaint"]['time_of_resolution'],Configure::read('date_format'),true) ;
			}
			if(!empty($result["Complaint"]['date'])){
				$result["Complaint"]['date']=$this->DateFormat->formatDate2Local($result["Complaint"]['date'],Configure::read('date_format'),true) ;
			}
			if(!empty($result["Complaint"]['resolution_time_taken'])){
				$result["Complaint"]['resolution_time_taken']=$result["Complaint"]['resolution_time_taken'] ;
			}
			//override patient name from patient table
			$result['Complaint']['patient_name']  = $result['Patient']['lookup_name']; 
			$this->data = $result;
			
		} 
		 
	}
	
	function delete($complaints_id=null){
			 
			if (!$complaints_id) {
				$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->Complaint->delete($complaints_id)) {
				$this->Session->setFlash(__('Complaint successfully deleted'),'default',array('class'=>'message'));
				$this->redirect(array('action'=>'index'));
			}
	}
	
	function view($id){
		
		if(!empty($id)){
			$this->Complaint->bindModel(array('belongsTo'=>array('Patient'=>array('foreignKey'=>'patient_id'))));
			$result = $this->Complaint->find('first',array('conditions'=>array('Complaint.id'=>$id),'fields'=>array('Complaint.*','Patient.lookup_name')));	
			if(!empty($result["Complaint"]['time_of_resolution'])){
				$result["Complaint"]['time_of_resolution']=$this->DateFormat->formatDate2Local($result["Complaint"]['time_of_resolution'],Configure::read('date_format'),true) ;
			}
			if(!empty($result["Complaint"]['date'])){
				$result["Complaint"]['date']=$this->DateFormat->formatDate2Local($result["Complaint"]['date'],Configure::read('date_format'),true) ;
			}
			if(!empty($result["Complaint"]['resolution_time_taken'])){
				$result["Complaint"]['resolution_time_taken']=$result["Complaint"]['resolution_time_taken'] ;
			}
			//override patient name from patient table
			$result['Complaint']['patient_name']  = $result['Patient']['lookup_name']; 
			$this->data = $result;
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
			$this->redirect($this->referer());
		}
	}
}
