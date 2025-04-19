<?php
/** PatientDocumentDetail model
*
* PHP 5
*
* @copyright     Copyright 2016 DrMHope Pvt Ltd  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Atul Chandankhede
*/
 
class PatientDocumentDetail extends AppModel {

	public $name = 'PatientDocumentDetail';
    public $specific = true;    		
	var $useTable = 'patient_document_details';
    
	
	function __construct($id = false, $table = null, $ds = null) {
	        $session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	        parent::__construct($id, $table, $ds);
    } 
    
    // insert patient document -Atul
  /*  function insertPatientDocument($data=array(),$patientId){ 
    	$session = new cakeSession();
    	$imageUpload =  new ImageUploadComponent(new ComponentCollection()); // object of ImageUpload Componant
    	$allListIDS=$this->find('list',array('fields'=>array('id','id'),
    			'conditions'=>array('PatientDocumentDetail.patient_id'=>$patientId,'PatientDocumentDetail.is_deleted'=>'0')));
    	$imagename1 = '';
    	if(!empty($data)){
    		//debug($data);exit;
    			if(!empty($data['PatientDocumentDetail']['filename_report']['name'])){
    				$original_image_extension1 = explode(".",$data['PatientDocumentDetail']['filename_report']['name']);
    				if(!isset($original_image_extension1[1])){
    					$imagename1= $data['PatientDocumentDetail']['filename_report']['name'].'_doc_'.mktime().'.'.$original_image_extension1[0];
    				}else{
    					$imagename1= $original_image_extension1[0].'_'.mktime().'.'.$original_image_extension1[1];
    				}
    				$imagename1 = trim($imagename1);
    				$requiredArray1  = array('data' =>array('PatientDocumentDetail'=>array('filename_report'=>$data['PatientDocumentDetail']['filename_report'])));
    				$showError1 = $imageUpload->uploadFile($requiredArray1,'filename_report','uploads/radiology_data',$imagename1);
    				$patientDocArry['PatientDocumentDetail']['filename_report'] = $imagename1;
    			}
    			
    			if(empty($showError1)) {
    				// making thumbnail of 100X100
    				$imageUpload->load($data['PatientDocumentDetail']['filename_report']['tmp_name']);
    				$imageUpload->resize(100,100);
    				$imageUpload->save('uploads/radiology_data/thumbnail/'.$imagename1); 
    			}else{
    				return $showError1 ;
    			}
    			if(empty($data['PatientDocumentDetail']['patient_document_id'])){
    				$this->id='';
    				$patientDocArry['PatientDocumentDetail']['create_time'] = date('Y-m-d H:i:s');
    				$patientDocArry['PatientDocumentDetail']['created_by'] = $session->read('userid');
    			}else{
    				$patientDocArry['PatientDocumentDetail']['modify_time'] = date('Y-m-d H:i:s');
    				$patientDocArry['PatientDocumentDetail']['modified_by'] = $session->read('userid');
    			}
    			$patientDocArry['PatientDocumentDetail']['location_id'] = $session->read("locationid");
    			$patientDocArry['PatientDocumentDetail']['patient_id'] = $patientId;
    			$patientDocArry['PatientDocumentDetail']['category_id'] = $data['PatientDocumentDetail']['category_id'];
    			$patientDocArry['PatientDocumentDetail']['sub_category_id'] = $data['PatientDocumentDetail']['sub_category_id'];
    			$patientDocArry['PatientDocumentDetail']['intraop_sub_category_id'] = $data['PatientDocumentDetail']['intraop_sub_category_id'];
    			
    			$patientDocArry['PatientDocumentDetail']['package_category_id'] = $data['PatientDocumentDetail']['package_category_id'];
    			$patientDocArry['PatientDocumentDetail']['package_sub_category_id'] = $data['PatientDocumentDetail']['package_sub_category_id'];
    			$patientDocArry['PatientDocumentDetail']['package_subsub_category_id'] = $data['PatientDocumentDetail']['package_subsub_category_id'];
    			
    			$patientDocArry['PatientDocumentDetail']['date'] =date('Y-m-d H:i:s');
    			$patientDocArry['PatientDocumentDetail']['document_description'] = $data['PatientDocumentDetail']['description'];
    			$this->save($patientDocArry);
    			return array($imagename1,$data['PatientDocumentDetail']['description']) ; //return image name to display as thumbnail and description
    			
    	}
    }*/
    
    
    function insertPatientDocument($data=array(),$patientId){
    	#debug($data);exit;
    	$session = new cakeSession();
    	$imageUpload =  new ImageUploadComponent(new ComponentCollection()); // object of ImageUpload Componant
    	$imagename1 = '';
    	if(!empty($data)){
    			if($data['PatientDocumentDetail']['is_link'] == '1'){
	    			$patientDocArry['PatientDocumentDetail']['filename_report'] = $data['PatientDocumentDetail']['filename_report_link'] ;
	    			$patientDocArry['PatientDocumentDetail']['is_link'] = $data['PatientDocumentDetail']['is_link'] ;
	    		}else{
    				if(!empty($data['PatientDocumentDetail']['filename_report']['name'])){
	    				$uploadImg = $data['PatientDocumentDetail']['filename_report'] ;
		    			$original_image_extension1 = explode(".",$uploadImg['name']);
		    			
		    			if(!isset($original_image_extension1[1])){
		    				$imagename1= $uploadImg['name'].'_doc_'.mktime().'.'.$original_image_extension1[0];
		    			}else{
		    				$imagename1= $original_image_extension1[0].'_'.mktime().'.'.$original_image_extension1[1];
		    			}
		    			$imagename1 = trim($imagename1);
		    			$requiredArray1  = array('data' =>array('PatientDocumentDetail'=>array('filename_report'=>$uploadImg)));
		    			$showError1 = $imageUpload->uploadFile($requiredArray1,'filename_report','uploads/radiology_data',$imagename1);
		    			$patientDocArry['PatientDocumentDetail']['filename_report'] = $imagename1;
		    		
		    	
		    		if(empty($showError1)) {
		    			// making thumbnail of 100X100
		    			$imageUpload->load($uploadImg['tmp_name']);
		    			$imageUpload->resize(100,100);
		    			$imageUpload->save('uploads/radiology_data/thumbnail/'.$imagename1);
		    		}else{
		    			return $showError1 ;
		    		}
	    		}
    		}
    		if(empty($data['PatientDocumentDetail']['patient_document_id'])){
    			$this->id='';
    			$patientDocArry['PatientDocumentDetail']['create_time'] = date('Y-m-d H:i:s');
    			$patientDocArry['PatientDocumentDetail']['created_by'] = $session->read('userid');
    		}else{
    			$patientDocArry['PatientDocumentDetail']['modify_time'] = date('Y-m-d H:i:s');
    			$patientDocArry['PatientDocumentDetail']['modified_by'] = $session->read('userid');
    		}
	    		$patientDocArry['PatientDocumentDetail']['location_id'] = $session->read("locationid");
	    		$patientDocArry['PatientDocumentDetail']['patient_id'] = $patientId;
	    		$patientDocArry['PatientDocumentDetail']['category_id'] = $data['PatientDocumentDetail']['category_id'];
	    		$patientDocArry['PatientDocumentDetail']['sub_category_id'] = $data['PatientDocumentDetail']['sub_category_id'];
	    		$patientDocArry['PatientDocumentDetail']['intraop_sub_category_id'] = $data['PatientDocumentDetail']['intraop_sub_category_id'];
	    		 
	    		$patientDocArry['PatientDocumentDetail']['package_category_id'] = $data['PatientDocumentDetail']['package_category_id'];
	    		$patientDocArry['PatientDocumentDetail']['package_sub_category_id'] = $data['PatientDocumentDetail']['package_sub_category_id'];
	    		$patientDocArry['PatientDocumentDetail']['package_subsub_category_id'] = $data['PatientDocumentDetail']['package_subsub_category_id'];
	    		 
	    		$patientDocArry['PatientDocumentDetail']['date'] =date('Y-m-d H:i:s');
	    		$patientDocArry['PatientDocumentDetail']['document_description'] = $data['PatientDocumentDetail']['description'];

	    	#	debug($patientDocArry);exit;
	    		$this->save($patientDocArry);
	    		$this->id = '';
	    		//$multipleImgArr[]= $imagename1;
	    		$multipleImgArr= $imagename1;
    		 //}
    		 
    		 return array($multipleImgArr,$data['PatientDocumentDetail']['description']) ; //return image name to display as thumbnail and description
    			
    		}
    	
    }
    
  /**
   * get patient document details by patient id-Atul
   */  
    public function getPatientDocumentByPatientId($patientId){
    	
    	$patientDocData=$this->find('all',array('fields'=>array('id','patient_id','date','category_id','sub_category_id','intraop_sub_category_id',
    			'package_category_id','package_sub_category_id','package_subsub_category_id','document_description','filename_report','is_download_allow','is_link'),
    			'conditions'=>array('PatientDocumentDetail.patient_id'=>$patientId,'PatientDocumentDetail.is_deleted'=>'0')));
		return $patientDocData;
    }
    
   
}
?>