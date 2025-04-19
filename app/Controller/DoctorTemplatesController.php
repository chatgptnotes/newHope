<?php
/**
 * DoctorTemplatesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       DoctorTemplates.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class DoctorTemplatesController extends AppController {

	public $name = 'DoctorTemplates';
	public $uses = array('DoctorTemplate','DoctorTemplateText');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * doctor template listing 
 *
 */	 
	public function index() {
               
   		$this->layout = 'ajax';
        $this->set('title_for_layout', __('Doctor Templates', true));
        $this->DoctorTemplate->recursive = -1; 
        $data = $this->DoctorTemplate->find('all',array('conditions' => array('DoctorTemplate.is_deleted' => 0)));
        $this->set('data', $data);             
   }
    /**
     * 
     * @param $updateID:DIV ID
     * @return not allowed
     */
   public function doctor_template($updateID=null) {
                $this->layout = 'ajax';
                
                 
                if (!empty($this->request->data['DoctorTemplate'])) {                       
                      $this->request->data['DoctorTemplate']['user_id'] = $this->Auth->user('id');
                      $this->request->data['DoctorTemplate']['location_id'] = $this->Session->read('locationid');
                      $this->request->data['DoctorTemplate']['created_by'] = $this->Auth->user('id');
                      $this->request->data['DoctorTemplate']['create_time'] = date("Y-m-d H:i:s");
                       
                      $this->DoctorTemplate->save($this->request->data);
                      $errors = $this->DoctorTemplate->invalidFields();
                     					 
			          if(!empty($errors)) {			          	
			            	$this->set("errors", $errors);
			            	 
			          }else {
		                     $this->Session->setFlash(__('Doctor template have been saved', true, array('class'=>'message')));
		                     $this->redirect("/doctor_templates/add/".$this->request->data['DoctorTemplate']['template_type']."/null/".$updateID);
			          }          
                }else{
                	 $this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
                	 $this->redirect("/doctor_templates/add/".$this->request->data['DoctorTemplate']['template_type']);
                }
	}
	/**
	 * 
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function add($templateType=null,$template_id=null,$updateID=null){ 

	//	debug($templateType."  ".$template_id.'   '.$updateID);

		//	 $this->layout = 'ajax';		
         $this->set('title_for_layout', __('Doctor Templates', true));
         $this->set('emptyTemplateText',false);  	
		 if (!empty($this->request->data['DoctorTemplate'])) {                       
                      $this->request->data['DoctorTemplate']['user_id'] = $this->Auth->user('id');
                      $this->request->data['DoctorTemplate']['location_id'] = $this->Session->read('locationid');
                      $this->request->data['DoctorTemplate']['created_by'] = $this->Auth->user('id');
                      $this->request->data['DoctorTemplate']['create_time'] = date("Y-m-d H:i:s");
                      $this->request->data['DoctorTemplate']['department_id'] = $this->Session->read('departmentid');
                       
                      $this->DoctorTemplate->save($this->request->data);
                      $errors = $this->DoctorTemplate->invalidFields();
                     		 
	          if(!empty($errors)) {			        
	          		$this->set('emptyTemplateText',true);  	
	            	$this->set("errors", $errors);	            	 
	          }else {
	                     $this->Session->setFlash(__('Doctor template have been saved', true, array('class'=>'message')));
	                     $this->redirect("/doctor_templates/add/".$this->request->data['DoctorTemplate']['template_type']."/null/".$updateID);
	          }          
         } 
	         $this->DoctorTemplate->recursive = -1; 
	         if(!empty($_POST['searchStr'])){
	         	$strKey['DoctorTemplate.template_name like '] = "%".$_POST['searchStr']."%";         	
	         }else{
	         	$strKey ='';
	         } 
	         $this->loadModel('Location');
	         //retrive all the location of logged in user's hospital
	         $locationArr = $this->Location->find('list',array('fields'=>array('id'),'conditions'=>array('is_deleted'=>0)));

	         $roleType = $this->Session->read('role');
	    	 if(strtolower($roleType) == strtolower(Configure::read('doctorLabel'))){
	    	 	$data = $this->DoctorTemplate->find('all',array('conditions' =>array('DoctorTemplate.is_deleted' => 0,
	    	 			"(DoctorTemplate.user_id  = ".$this->Session->read('userid')." OR DoctorTemplate.user_id  = 0) AND DoctorTemplate.department_id =". $this->Session->read('departmentid'),
	    	 			'DoctorTemplate.template_type like'=>"%".$templateType,$strKey,'DoctorTemplate.location_id IN ('.implode(",",$locationArr).')') ));
	         }else{
	         	$data = $this->DoctorTemplate->find('all',array('conditions' =>array('DoctorTemplate.is_deleted' => 0,
	         			'DoctorTemplate.template_type like'=>"%".$templateType,$strKey,'DoctorTemplate.location_id IN ('.implode(",",$locationArr).')') ));
	         	
	         }	
	        
	         
	                           
	         $this->set(array('data'=>$data,'template_type'=>$templateType,'updateID'=>"templateArea-".$templateType));
	         if(!empty($template_id)){         		
	         	$this->data = $this->DoctorTemplate->read(null,$template_id);
	         }

	         /*$getBasicData=$this->Patient->find('first',array('fields'=>array('id','person_id','Person.dob','lookup_name','age','sex','patient_weight','Patient.admission_type','epenImages', 'Patient.admission_id', 'Person.patient_uid'),
				'conditions'=>array('Patient.id'=>$patientId)));*/
	         
          $this->render('add');
	}	
	
	/**
	 * fucntion to search template 
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function template_search($templateType=null){ 
		//	 $this->layout = 'ajax';		
         $this->set('title_for_layout', __('Doctor Templates', true));
         $this->DoctorTemplate->recursive = -1; 
         
         if(!empty($_POST['searchStr'])){
         	$strKey['DoctorTemplate.template_name like '] = "%".$_POST['searchStr']."%";         	
         }else{
         	$strKey ='';
         }
         
         $data = $this->DoctorTemplate->find('all',array('conditions' => array('DoctorTemplate.is_deleted' => 0,
         								"(DoctorTemplate.user_id  = ".$this->Session->read('userid')." OR 
		        					   	DoctorTemplate.user_id  = 0) ",'DoctorTemplate.template_type like'=>"%".$templateType,$strKey)));         
         
         $this->set(array('data'=>$data,'template_type'=>$templateType,'updateID'=>"templateArea-".$templateType));
         if(!empty($template_id)){         		
         	$this->data = $this->DoctorTemplate->read(null,$template_id);
         }
	}	 
	
	/**
	 * fucntion to search template 
	 * @param $templateType
	 * @param $template_id
	 * @return unknown_type
	 */
	public function template_text_search($template_id=null,$templateType=null){ 
		 //$this->layout = 'ajax';		
		 $this->uses = array('DoctorTemplateText');
         $this->set('title_for_layout', __('Doctor Templates', true));
         
         if(!empty($_POST['searchStr'])){
         	$strKey['DoctorTemplateText.template_text like '] = "%".$_POST['searchStr']."%";         	
         }else{
         	$strKey ='';
         }
         
	     $data = $this->DoctorTemplateText->find('all',array('conditions' => array('DoctorTemplateText.is_deleted' => 0,'DoctorTemplateText.template_id'=>$template_id,$strKey)));
	     //retrive template details
	     $this->DoctorTemplate->recursive = -1; 
	     $templateData = $this->DoctorTemplate->read(null,$template_id);
	     $this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
	    				 'updateID'=>"templateArea-".$templateData['DoctorTemplate']['template_type']));
         
	}
	//function to add tempalte text
	/*
	 * 
	 * @param $template_id
	 * @param $template_text_id
	 * @param $updateID : DIV ID for placing return html
	 * @return rendering HTML
	 */
	function add_template_text($template_id=null,$template_text_id=null,$updateID=null){
		//$this->layout = 'ajax'; 
		$this->uses = array('DoctorTemplateText');
	     $this->DoctorTemplate->recursive = -1; 
	    $this->set('emptyText',false);
	    
	    if(!empty($this->request->data)){	    	
	    	 if(empty($this->request->data['DoctorTemplateText']['template_text'])){
	    	 	$this->Session->setFlash(__('Please enter template text'),true,array('class'=>'error'));
	    	 	$this->set('emptyText',true);
	    	 	if(!$template_id)  $template_id = $this->request->data['DoctorTemplateText']['template_id']; 
	    	 }else{		    	 
		    	 $result = $this->DoctorTemplateText->insertTemplateText($this->request->data);
		    	 $errors = $this->DoctorTemplateText->invalidFields();
	             if(!empty($errors)) {
	                $this->set("errors", $errors);
	             }else{
		    	 	$this->Session->setFlash(__('Template saved'),true,array('class'=>'message'));
	             	$this->redirect(array('action'=>'add_template_text',$this->request->data['DoctorTemplateText']['template_id']));
	             }
	    	 }
	    }
	    if(!empty($template_text_id)){	 	    	 
	    	$this->set('emptyText',true);//to display edit form for template text
	    	$this->data = $this->DoctorTemplateText->read(null,$template_text_id);	    	 
	    }   
	    
	    $data = $this->DoctorTemplateText->find('all',array('conditions' => array('DoctorTemplateText.is_deleted' => 0,
	    'DoctorTemplateText.template_id'=>$template_id )));
	    //retrive template details
	    $templateData = $this->DoctorTemplate->read(null,$template_id);
	    $this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
	    				 'updateID'=>"templateArea-".$templateData['DoctorTemplate']['template_type']));
	}
	
	
	
 	public function edit($id=null) {
                $this->layout = 'ajax';
                if (!empty($this->request->data['DoctorTemplate'])) {
                		
                      $this->request->data['DoctorTemplate']['template_type'] = 'diagnosis';
                      $this->request->data['DoctorTemplate']['user_id'] = $this->Auth->user('id');
                      $this->request->data['DoctorTemplate']['location_id'] = $this->Session->read('locationid');
                      $this->request->data['DoctorTemplate']['created_by'] = $this->Auth->user('id');
                      $this->request->data['DoctorTemplate']['create_time'] = date("Y-m-d H:i:s");
                      $this->DoctorTemplate->save($this->request->data);
                      $errors = $this->DoctorTemplate->invalidFields();						 
			          if(!empty($errors)) {
			            	$this->set("errors", $errors);
			          }else {
	                      $this->Session->setFlash(__('Doctor template have been updated', true, array('class'=>'message')));
	                      $this->redirect("/doctor_templates/");
			          }                      
                }
                 $this->DoctorTemplate->recursive = -1; 
                
                $data = $this->DoctorTemplate->find('all',array('conditions' => array('DoctorTemplate.is_deleted' => 0)));
                $this->set('data', $data);
                $this->data = $this->DoctorTemplate->read(null,$id);
	     }
	     
     public function delete($templateType=null,$id=null,$updateID=null){	     	
     	$this->layout = 'ajax';
     	if(!empty($id)){     		
	     	$this->DoctorTemplate->id= $id ;
	     	$this->DoctorTemplate->save(array('is_deleted'=>1));
            $this->Session->setFlash(__('Doctor template have been deleted', true, array('class'=>'message')));            	 
     	}else{	     		
     		$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
     	}
     	//$this->redirect("/doctor_templates/");     
     	$this->redirect("/doctor_templates/add/".$templateType."/null/".$updateID);
     	
     }
     
  	 //add template from admin section
     public function admin_index($template_id=null){  
     	$this->layout = 'advance';
     	$this->loadModel('Department');
     	 $this->set('title_for_layout', __('Doctor Templates', true));
                $this->DoctorTemplate->recursive = -1;
                 $this->paginate = array(
                'evalScripts' => true,
		        'limit' => Configure::read('number_of_rows'),                    
                 'order' => array('DoctorTemplate.id'=>'DESC'),
		        'conditions' => array('DoctorTemplate.is_deleted' => 0,
		        'DoctorTemplate.user_id'=>0,'DoctorTemplate.location_id'=>$this->Session->read('locationid'))
   			);
         $data = $this->paginate('DoctorTemplate');
         if($template_id){
         	$this->data  = $this->DoctorTemplate->read(null,$template_id);
         }
         $this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name'),
         		'group'=>'Department.name')));
         $this->set('data', $data);
         $this->set('histoSections',Configure::read('histopathology_data'));
         $this->set('histoCategoriesData', Configure::read('lab_histo_template_sub_groups'));
        
     }
     
     //add template from admin section
     public function admin_template_add(){     	
      			if (!empty($this->request->data['DoctorTemplate'])) {                 
                      $this->DoctorTemplate->insertGeneralTemplate($this->request->data,'insert');
                       $errors = $this->DoctorTemplate->invalidFields();						 
			          if(!empty($errors)) {
			            	$this->set("errors", $errors);
			          }else {
	                      $this->Session->setFlash(__('Doctor template have been saved', true, array('class'=>'message')));
	                      $this->redirect('index');       
			          }   
                }else{
                 	$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
                 	$this->redirect($this->referer());
                }             
     } 
     
	public function admin_template_delete($id=null){
     	if(!empty($id)){
	     	$this->DoctorTemplate->id= $id ;
	     	$this->DoctorTemplate->save(array('is_deleted'=>1));
	     	$this->DoctorTemplateText->updateAll(array('is_deleted'=>1),array('template_id'=>$id));
            $this->Session->setFlash(__('Doctor template have been deleted', true, array('class'=>'message')));            	 
     	}else{	     		
     		$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
     	}
     	$this->redirect($this->referer());	
    }
    
 	//add template text from admin section
     public function admin_template_index($template_id=null,$template_text_id=null){
     		if(!empty($template_id)){     	
		     	 $this->set('title_for_layout', __('Template Text ', true));
		                
                $this->paginate = array(
                'evalScripts' => true,
		        'limit' => Configure::read('number_of_rows'),                    
		        'conditions' => array('DoctorTemplateText.is_deleted' => 0,'DoctorTemplateText.template_id'=>$template_id)
	   			);
		        $data = $this->paginate('DoctorTemplateText');
		        if($template_text_id){
		         	$this->data  = $this->DoctorTemplateText->read(null,$template_text_id);
		        }
		        $template_name = $this->DoctorTemplate->read(array('template_name','template_type'),$template_id);
		        $this->set(array('template_data'=>$template_name,'data'=>$data,'template_id'=>$template_id,'template_name'=>$template_name['DoctorTemplate']['template_name']));
		        
     		}else{
     			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
                $this->redirect($this->referer());
     		}
     		$this->set('histoSections',Configure::read('histopathology_data'));
     }
     
	//add template from admin section
     public function admin_template_text_add(){     	
      			if (!empty($this->request->data['DoctorTemplateText'])) {                 
                      $this->DoctorTemplateText->insertTemplateText($this->request->data,'insert');
                      $errors = $this->DoctorTemplateText->invalidFields();						 
			          if(!empty($errors)) {
			            	$this->set("errors", $errors);
			          }else {
	                      $this->Session->setFlash(__('Template text have been saved', true, array('class'=>'message')));
	                      $this->redirect($this->referer());
			          }          
                }else{
                 	$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
                 	$this->redirect($this->referer());
                }             
     }
     
 	//edittemplate from admin section
     public function admin_template_text_edit(){     	
      			if (!empty($this->request->data['DoctorTemplate'])) {                 
                      $this->DoctorTemplateText->insertTemplateText($this->request->data,'insert');
                      $errors = $this->DoctorTemplateText->invalidFields();						 
			          if(!empty($errors)) {
			            	$this->set("errors", $errors);
			          }else {
	                      $this->Session->setFlash(__('template text have been saved', true, array('class'=>'message')));
	                      $this->redirect($this->referer());    
			          }      
                }else{
                 	$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
                 	$this->redirect($this->referer());
                }             
     }
     
	public function admin_template_text_delete($id=null){
     	if(!empty($id)){
	     	$this->DoctorTemplateText->id= $id ;
	     	$this->DoctorTemplateText->save(array('is_deleted'=>1));
	     	$errors = $this->DoctorTemplateText->invalidFields();						 
	          if(!empty($errors)) {
	            	$this->set("errors", $errors);
	          }else {
           		 $this->Session->setFlash(__('Doctor template text have been deleted', true, array('class'=>'message')));   
	          }         	 
     	}else{	     		
     		$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
     	}
     	$this->redirect($this->referer());	
    }
    
    	 //add template from admin section
     public function histo($template_id=null){  
     	$this->layout = 'advance';
     	$this->loadModel('Department');
     	 $this->set('title_for_layout', __('Doctor Templates', true));
                //$this->DoctorTemplate->recursive = -1;
                
                 $this->paginate = array(
                'evalScripts' => true,
		        'limit' => Configure::read('number_of_rows'),                    
                 'order' => array('DoctorTemplate.id'=>'DESC'),
		        'conditions' => array('DoctorTemplate.is_deleted' => 0,
		        'DoctorTemplate.template_type'=>'histo_pathology','DoctorTemplate.user_id'=>0,'DoctorTemplate.location_id'=>$this->Session->read('locationid'))
   			);
         $data = $this->paginate('DoctorTemplate');
         $this->DoctorTemplate->unbindModel ( array ('belongsTo' => array ('Location','User')));
                $this->DoctorTemplate->bindModel ( array (
						'belongsTo' => array (
								'DoctorTemplateText' => array (
										'foreignKey' => false,
										'conditions' => array (
												'DoctorTemplateText.template_id = DoctorTemplate.id' 
										)/* ,'order' => 'Patient.id DESC' */),
                                                    )));
         if($template_id){
         	$this->data  = $this->DoctorTemplate->read(null,$template_id);
         }
         $this->set('departments',$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name'),
         		'group'=>'Department.name')));
         $this->set('data', $data);
         $this->set('histoSections',Configure::read('histopathology_data'));
         $this->set('histoCategoriesData', Configure::read('lab_histo_template_sub_groups'));
        
     }
     
     //add template text from admin section
     public function template_histo($template_id=null,$template_text_id=null){
     		if(!empty($template_id)){     	
		     	 $this->set('title_for_layout', __('Template Text ', true));
		                
                $this->paginate = array(
                'evalScripts' => true,
		        'limit' => Configure::read('number_of_rows'),                    
		        'conditions' => array('DoctorTemplateText.is_deleted' => 0,'DoctorTemplateText.template_id'=>$template_id)
	   			);
		        $data = $this->paginate('DoctorTemplateText');
		        if($template_text_id){
		         	$this->data  = $this->DoctorTemplateText->read(null,$template_text_id);
		        }
		        $template_name = $this->DoctorTemplate->read(array('template_name','template_type'),$template_id);
		        $this->set(array('template_data'=>$template_name,'data'=>$data,'template_id'=>$template_id,'template_name'=>$template_name['DoctorTemplate']['template_name']));
		        
     		}else{
     			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
                $this->redirect($this->referer());
     		}
     		$this->set('histoSections',Configure::read('histopathology_data'));
     }
     
     function add_template_text_histo($template_id=null,$template_text_id=null,$updateID=null){
		//$this->layout = 'ajax'; 
		$this->uses = array('DoctorTemplateText');
	     $this->DoctorTemplate->recursive = -1; 
	    $this->set('emptyText',false);
	    
	    if(!empty($this->request->data)){	    	
	    	 if(empty($this->request->data['DoctorTemplateText']['template_text'])){
	    	 	$this->Session->setFlash(__('Please enter template text'),true,array('class'=>'error'));
	    	 	$this->set('emptyText',true);
	    	 	if(!$template_id)  $template_id = $this->request->data['DoctorTemplateText']['template_id']; 
	    	 }else{		    	 
		    	 $result = $this->DoctorTemplateText->insertTemplateText($this->request->data);
		    	 $errors = $this->DoctorTemplateText->invalidFields();
	             if(!empty($errors)) {
	                $this->set("errors", $errors);
	             }else{
		    	 	$this->Session->setFlash(__('Template saved'),true,array('class'=>'message'));
	             	$this->redirect(array('action'=>'add_template_text',$this->request->data['DoctorTemplateText']['template_id']));
	             }
	    	 }
	    }
	    if(!empty($template_text_id)){	 	    	 
	    	$this->set('emptyText',true);//to display edit form for template text
	    	$this->data = $this->DoctorTemplateText->read(null,$template_text_id);	    	 
	    }   
	    
	    $data = $this->DoctorTemplateText->find('all',array('conditions' => array('DoctorTemplateText.is_deleted' => 0,
	    'DoctorTemplateText.template_id'=>$template_id )));
	    //retrive template details
	    $templateData = $this->DoctorTemplate->read(null,$template_id);
	    $this->set(array('data'=>$data,'template_id'=>$template_id,'template_data'=>$templateData,
	    				 'updateID'=>"templateArea-".$templateData['DoctorTemplate']['template_type']));
	}
        
        public function template_add_histo(){     
            $this->uses = array('DoctorTemplateText','DoctorTemplate');
      			if (!empty($this->request->data['DoctorTemplate'])) {                 
                      $this->DoctorTemplate->insertGeneralTemplate($this->request->data,'insert');
                      $this->DoctorTemplateText->insertTemplateText($this->request->data,'insert');
                      $errors = $this->DoctorTemplate->invalidFields();						 
			          if(!empty($errors)) {
			            	$this->set("errors", $errors);
			          }else {
	                      $this->Session->setFlash(__('Doctor template have been saved', true, array('class'=>'message')));
	                      $this->redirect('histo');       
			          }   
                }else{
                 	$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
                 	$this->redirect($this->referer());
                }             
     } 
     
	public function template_delete_histo($id=null){
     	if(!empty($id)){
	     	$this->DoctorTemplate->id= $id ;
	     	$this->DoctorTemplate->save(array('is_deleted'=>1));
	     	$this->DoctorTemplateText->updateAll(array('is_deleted'=>1),array('template_id'=>$id));
            $this->Session->setFlash(__('Doctor template have been deleted', true, array('class'=>'message')));            	 
     	}else{	     		
     		$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
     	}
     	$this->redirect($this->referer());	
    }
    
     public function template_text_add_histo(){     	
      			if (!empty($this->request->data['DoctorTemplateText'])) {                 
                      $this->DoctorTemplateText->insertTemplateText($this->request->data,'insert');
                      $errors = $this->DoctorTemplateText->invalidFields();						 
			          if(!empty($errors)) {
			            	$this->set("errors", $errors);
			          }else {
	                      $this->Session->setFlash(__('Template text have been saved', true, array('class'=>'message')));
	                      $this->redirect($this->referer());
			          }          
                }else{
                 	$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
                 	$this->redirect($this->referer());
                }             
     }
    

    public function delete_template_text($templateid,$id){
			$this->uses=array('DoctorTemplateText');
			$this->DoctorTemplateText->delete(array('id'=>$id));
			$this->Session->setFlash(__('Template text have been deleted', true, array('class'=>'message')));
			$this->redirect("/doctor_templates/add_template_text/".$templateid);
		}
    
}
?>