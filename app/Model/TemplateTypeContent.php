<?php
App::uses('AppModel', 'Model');
/**
 * TemplateTypeContent Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gulshan Trivedi
*/
class TemplateTypeContent extends AppModel {

	public $name = 'TemplateTypeContent';
	public $usetable = 'template_type_contents';
	public $specific = true;
	


	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
			
	}

public function insertCategory($data=array(),$note_id,$patient_id,$from_discharge='no',$diagnosisId,$note_template_id){
		/**if($note_id!='0'){
			if($from_discharge=='no'){
					
				$this->deleteAll(array('OR'=>array('TemplateTypeContent.note_id'=>'0','TemplateTypeContent.note_id'=>$note_id),'TemplateTypeContent.diagnoses_id'=>$diagnosisId,'TemplateTypeContent.template_category_id=1')) ;
				//$this->deleteAll(array('TemplateTypeContent.note_id'=>$note_id,'TemplateTypeContent.template_category_id=1')) ;
				//exit;
			}else{
					
				$this->deleteAll(array('TemplateTypeContent.patient_id'=>$patient_id,'TemplateTypeContent.template_category_id=1','TemplateTypeContent.from_discharge'=>1)) ;
			}
		}
		else{

			$this->deleteAll(array('TemplateTypeContent.patient_id'=>$patient_id,'TemplateTypeContent.note_id'=>'0')) ;
		}*/
		$this->deleteAll(array('TemplateTypeContent.patient_id'=>$patient_id,'TemplateTypeContent.note_id'=>$note_id,'TemplateTypeContent.template_category_id=1'/*,'note_template_id'=>$note_template_id*/)) ;
		//BOF custom options
		$templateSubCategories = Classregistry::init('TemplateSubCategories');
		$session = new cakeSession();
		/*if(!empty($data['textbox2'])){
			foreach($data['textbox2'] as $templateID => $text){
				$text = trim($text);
				$tempIdExplode=explode('_',$templateID);
				if(!empty($text)){
					//find there is same option exist
					$isExist = $templateSubCategories->find('first',array('conditions'=>array('sub_category'=>trim($text),'template_id'=>$tempIdExplode[0])));
					if(empty($isExist)){
						//insert into TemplateSubCategories
						$templateSubCategories->save(array('template_category_id'=>1,'template_id'=>$templateID,'sub_category'=>$text,'created_by'=>$session->read('userid'),'create_time'=>date('Y-m-d H:i:s')));
						$templateSubCategoriesID = $templateSubCategories->id;
					}else{
						$templateSubCategoriesID = $isExist['TemplateSubCategories']['id'];
					}
					$array1['template_category_id']='1';
					$array1['note_id']=$note_id;
					$array1['patient_id']=$patient_id ;
					$array1['template_id']=$templateID;
					$array1['note_template_id']=$note_template_id;
					$array1['template_subcategory_id']=$templateSubCategoriesID;
					//$this->save($array1);
					$templateSubCategories->id='';
					//$this->id='';
					$data[$templateID][$templateSubCategoriesID]= 1 ;
					//unset($data[$templateID]) ; //unset for other option
				}
			}
		}

		unset($data['textbox2']) ;*/

			
		//EOF custom options

		foreach($data as $key=>$datas){
			 
			if(!empty($datas)){
				$array['template_category_id']='1';
				$array['note_id']=$note_id;
				$array['template_id']=$key;
				$array['patient_id']=$patient_id;
				$array['note_template_id']=$note_template_id;
				$array['diagnoses_id']=$diagnosisId;
				$array['patient_specific_template']=serialize($datas['patient_specific_template']);
				unset($datas['patient_specific_template']);
				$array['template_subcategory_id']=serialize($datas);
				//array of selection
				$this->save($array);
				$this->id='';
			}
		}
		return true;
	}
	public function insertCategoryHPI($data=array(),$note_id,$patient_id,$from_discharge='no',$diagnosisId=null,$note_template_id,$hpiIdentified){
		
		/*if($note_id!='0'){
			if($from_discharge=='no'){
				$this->deleteAll(array('OR'=>array(array('TemplateTypeContent.note_id'=>'0'),array('TemplateTypeContent.note_id'=>$note_id)),'TemplateTypeContent.diagnoses_id'=>$diagnosisId,'TemplateTypeContent.template_category_id=3')) ;
			}else{			
				$this->deleteAll(array('TemplateTypeContent.patient_id'=>$patient_id,'TemplateTypeContent.template_category_id=3','TemplateTypeContent.from_discharge'=>1)) ;
			}
		}
		else{
			$this->deleteAll(array('TemplateTypeContent.patient_id'=>$patient_id,'TemplateTypeContent.note_id'=>$note_id)) ;
		}*/
		$this->deleteAll(array('TemplateTypeContent.patient_id'=>$patient_id,'TemplateTypeContent.template_category_id=3','TemplateTypeContent.note_id'=>$note_id/*,'TemplateTypeContent.note_template_id'=>$note_template_id*/)) ;
		//BOF custom options
		$templateSubCategories = Classregistry::init('TemplateSubCategories');
		$session = new cakeSession();
		/*if(!empty($data['textbox2'])){
			foreach($data['textbox2'] as $templateID => $text){
				$text = trim($text);
				if(!empty($text)){
					//find there is same option exist
					$isExist = $templateSubCategories->find('first',array('conditions'=>array('sub_category'=>trim($text),'template_id'=>$templateID)));
					if(empty($isExist)){
						//insert into TemplateSubCategories
						$templateSubCategories->save(array('template_category_id'=>3,'template_id'=>$templateID,'sub_category'=>$text,'created_by'=>$session->read('userid'),'create_time'=>date('Y-m-d H:i:s')));
						$templateSubCategoriesID = $templateSubCategories->id;
					}else{
						$templateSubCategoriesID = $isExist['TemplateSubCategories']['id'];
					}
					$array1['template_category_id']='3';
					$array1['note_id']=$note_id;
					$array1['patient_id']=$patient_id ;
					$array1['template_id']=$templateID;
					$array1['note_template_id']=$note_template_id;
					$array1['hpi_identified']=$hpiIdentified;
					$array1['template_subcategory_id']=$templateSubCategoriesID;
					//$this->save($array1);
					$templateSubCategories->id='';
					//$this->id='';
					$data[$templateID][$templateSubCategoriesID]= 1 ;
					//unset($data[$templateID]) ; //unset for other option
				}
			}
			
		}
	
		unset($data['textbox2']) ;*/
	
			
		//EOF custom options
		if(!empty($data['freeText'])){
			$dateFreeText=$data['freeText'];
			$array['template_category_id']='3';
			$array['note_id']=$note_id;
			$array['diagnoses_id']=$diagnosisId;
			$array['template_id']='871';
			$array['patient_id']=$patient_id;
			$array['hpi_identified']=$hpiIdentified;
			$array['note_template_id']=$note_template_id;
			$array['template_subcategory_id']=addslashes($dateFreeText);
			//array of selection
			$this->save($array);
			$this->id='';
		}
		unset($data['freeText']) ;
		foreach($data as $key=>$datas){
			if(!empty($datas)){
				$array['template_category_id']='3';
				$array['note_id']=$note_id;
				$array['diagnoses_id']=$diagnosisId;
				$array['template_id']=$key;
				$array['note_template_id']=$note_template_id;
				$array['hpi_identified']=$hpiIdentified;
				$array['patient_id']=$patient_id;
				$array['patient_specific_template']=serialize($datas['patient_specific_template']);
				unset($datas['patient_specific_template']);
				$array['template_subcategory_id']=serialize($datas);
				//array of selection
				$this->save($array);
				$this->id='';
			}
		}
		return true;
	}
	public function insertRosExamination($data=array(),$note_id,$patientId,$organSystem,$extaData=array(),$extaData1=array(),$note_template_id){ 
		$orgData = $data ;
		$data = $data['subCategory_examination']  ; //by pankaj 
		
		$session = new cakeSession();
		$templateMiddleCategory = Classregistry::init('TemplateMiddleCategory');
		$this->deleteAll(array('TemplateTypeContent.patient_id'=>$patientId,'TemplateTypeContent.template_category_id=2','TemplateTypeContent.note_id'=>$note_id/*,'TemplateTypeContent.note_template_id'=>$note_template_id*/)) ;
		// important for deleted the perv... entries -Aditya
		$newIds=array_unique($extaData['ids']);
		$newIds = array_values($newIds);
		$templateMiddleCategory->deleteAll(array('TemplateMiddleCategory.patient_id'=>$patientId,'TemplateMiddleCategory.template_subcategory_id'=>$newIds)) ;
		// EOD
		//BOF custom options
		$templateSubCategories = Classregistry::init('TemplateSubCategories');
		//EOF custom options

		foreach($data as $key=>$datas){ 
			if(!empty($datas)){  
				//BOF pankaj for dropdown options
				$extraBtnOptions = '';
				if(!empty($orgData['dropdown_options'][$key]) || !empty($orgData['extra_textarea_data'][$key]) )
				$extraBtnOptions = array('dropdown_options'=>$orgData['dropdown_options'][$key],'extra_textarea_data'=>$orgData['extra_textarea_data'][$key]) ;
				//EOF pankaj
				$array['template_category_id']='2';
				$array['note_id']=$note_id;
				$array['template_id']=$key;
				$array['patient_id']=$patientId;
				$array['note_template_id']=$note_template_id;
				$array['organ_system']=$organSystem;
				$array['patient_specific_template']=serialize($datas['patient_specific_template']);
				unset($datas['patient_specific_template']);
				$array['template_subcategory_id']=serialize($datas);
				$array['extra_btn_options'] = serialize($extraBtnOptions) ; //by pankaj for dropdown
				//array of selection
				 
				$this->save($array);
				$this->id='';
			}
		}
		if(!empty($extaData)){
			$newExtra=array();
			$newDescp=array();
			foreach($extaData['name'] as $key=>$saveData){
				$name=$saveData;
				$despImplode=implode(',',$newDescp);
				$newExtra['TemplateMiddleCategory']['name']=$name;
				$newExtra['TemplateMiddleCategory']['descriptions']=serialize($extaData[$key]);
				$newExtra['TemplateMiddleCategory']['template_id']='2';
				$newExtra['TemplateMiddleCategory']['template_subcategory_id']=$newIds[$key]; 
				$newExtra['TemplateMiddleCategory']['patient_id']=$patientId; 
				$templateMiddleCategory->saveAll($newExtra);
				unset($newDescp);
				$despImplode='';
				$this->id='';
			}
		}
		if(!empty($extaData1)){
			$newExtra=array();
			$newDescp=array();
			foreach($extaData1['name'] as $key=>$saveData){
				$name=$saveData;
				$despImplode=implode(',',$newDescp);
				$newExtra['TemplateMiddleCategory']['name']=$name;
				$newExtra['TemplateMiddleCategory']['descriptions']=serialize($extaData1[$key]);
				$newExtra['TemplateMiddleCategory']['template_id']='2';
				$newExtra['TemplateMiddleCategory']['template_subcategory_id']=$newIds[$key];
				$newExtra['TemplateMiddleCategory']['patient_id']=$patientId;
				$templateMiddleCategory->saveAll($newExtra);
				unset($newDescp);
				$despImplode='';
				$this->id='';
			}
		}
		return true;
	} 
	function afterSave($created){
		if($created){
			$diagnoses = Classregistry::init('Diagnosis');
			$diagnoses->addBlankEntry($this->data['TemplateTypeContent']['patient_id']);
		}
	}
	
	public function insertCategoryIni($data=array(),$diagnosesId,$patient_id,$from_discharge='no'){
		if($diagnosesId!='0'){
			if($from_discharge=='no'){
					
					
				$this->deleteAll(array('TemplateTypeContent.diagnoses_id'=>$diagnosesId,'TemplateTypeContent.template_category_id=1')) ;
				//exit;
			}else{
					
				$this->deleteAll(array('TemplateTypeContent.patient_id'=>$patient_id,'TemplateTypeContent.template_category_id=1','TemplateTypeContent.from_discharge'=>1)) ;
			}
		}
		else{
	
			$this->deleteAll(array('TemplateTypeContent.patient_id'=>$patient_id,'TemplateTypeContent.note_id'=>'0')) ;
		}
		//BOF custom options
		$templateSubCategories = Classregistry::init('TemplateSubCategories');
		$session = new cakeSession();
	
		if(!empty($data['textbox'])){
			foreach($data['textbox'] as $templateID => $text){
				$text = trim($text);
				if(!empty($text)){
					//find there is same option exist
					$isExist = $templateSubCategories->find('first',array('conditions'=>array('sub_category'=>trim($text),'template_id'=>$templateID)));
					if(empty($isExist)){
						//insert into TemplateSubCategories
						$templateSubCategories->save(array('template_category_id'=>1,'template_id'=>$templateID,'sub_category'=>$text,'created_by'=>$session->read('userid'),'create_time'=>date('Y-m-d H:i:s')));
						$templateSubCategoriesID = $templateSubCategories->id;
					}else{
						$templateSubCategoriesID = $isExist['TemplateSubCategories']['id'];
					}
					$array1['template_category_id']='3';
					$array1['diagnoses_id']=$diagnosesId;
					$array1['note_id'] = 0;
					$array1['patient_id']=$patient_id ;
					$array1['template_id']=$templateID;
					$array1['template_subcategory_id']=$templateSubCategoriesID;
					//$this->save($array1);
					$templateSubCategories->id='';
					//$this->id='';
					$data[$templateID][$templateSubCategoriesID]= 1 ;
					//unset($data[$templateID]) ; //unset for other option
				}
			}
		}
	
		unset($data['textbox']) ;
	
			
		//EOF custom options
	
		foreach($data as $key=>$datas){
			/* debug($datas);
			 exit; */
			if(!empty($datas)){
				$array['template_category_id']='3';
				$array['diagnoses_id']=$diagnosesId;
				$array1['note_id'] = 0;
				$array['template_id']=$key;
				$array['patient_id']=$patient_id;
				$array['template_subcategory_id']=serialize($datas);
				//array of selection
				$this->save($array);
				$this->id='';
			}
		}
		if(!empty($data['freeText'])){
			$dateFreeText=$data['freeText'];
			$array['template_category_id']='3';
			$array['diagnoses_id']=$diagnosesId;
			$array['template_id']=$key;
			$array['patient_id']=$patient_id;
			$array['template_subcategory_id']=$dateFreeText;
			//array of selection
			$this->save($array);
			$this->id='';
		}
		return true;
	}
}