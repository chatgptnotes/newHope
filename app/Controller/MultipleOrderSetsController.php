<?php
/**
 * MessagesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       MultipleOrderSetsController Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Aditya Chitmitwar
 */

class MultipleOrderSetsController extends AppController {
	public $name = 'MultipleOrderSets';
	public $uses = array('MultipleOrderSet');
	public $helpers = array('Html','Form', 'Js','General','DateFormat');
	public $components = array('RequestHandler','Email','Auth','Session', 'Acl','Cookie','DateFormat');
	
	public function admin_audit_logs(){

	}
	/* public function index(){

	} */
	/////BOF-Mahalaxmi
	public function admin_index($orderSetMasterId=null){
		$this->layout= "advance";
		$this->uses=array('OrdersetMaster','OrderCategory','OrderSubcategory');
			
		//////**************BOF-For All OrdercCategory Link********////
		$getOrderCategoryData=$this->OrderCategory->find('all',array('fields'=>array('order_description'),'conditions'=>array('OrderCategory.status'=>1,'OrderCategory.is_deleted'=>0)));
		
		//////**************EOF-For All OrdercCategory Link********////
		
		/////**************BOF-Search & all Records*********///////
		if(!empty($this->request->query['ordersetname'])){
			$conditionArray = array('is_deleted'=>0,'OrdersetMaster.name'=>$this->request->query['ordersetname'],'location_id'=>$this->Session->read('locationid'));
		}else{
			$conditionArray = array('is_deleted'=>0,'location_id'=>$this->Session->read('locationid'));
		}		
		
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'conditions' => $conditionArray
		);	
		$this->set('dataTest',$this->paginate('OrdersetMaster'));		
		/////**************EOF-Search & all Records*********///////		
		
		if(!empty($orderSetMasterId)){			
			$this->data = $this->OrdersetMaster->read(null,$orderSetMasterId);			
		/*	$getAllOrderCategoryData=$this->OrderSubcategory->find('all',array('conditions'=>array('OrderSubcategory.orderset_master_id'=>$orderSetMasterId)));
			foreach($getAllOrderCategoryData as $key=>$getAllOrderCategoryDatas){
				$orderIdArr[$getAllOrderCategoryDatas['OrderSubcategory']['order_category_id']]=$getAllOrderCategoryDatas['OrderSubcategory']['order_category_id'];
				//$orderIdArr[$key] = array_unique($orderIdArr);			
			}*/			
				
		}
		$this->set(array('getOrderCategoryData'=>$getOrderCategoryData,'getOrderSubcategoryData'=>$getOrderSubcategoryData,'getAllOrderCategoryData'=>$getAllOrderCategoryData,'orderIdArr'=>json_encode($orderIdArr)));
	}
	/////BOF-Mahalaxmi
	public function save_orderset(){	
		$this->uses=array('OrdersetMaster','OrderCategory','OrderSubcategory','OrdersetCategoryMapping');		
		if(isset($this->request->data) && !empty($this->request->data)){
			if(!empty($this->request->data['OrdersetMaster']['id'])){
				$this->request->data['OrdersetMaster']['modify_time'] = date("Y-m-d H:i:s");
				$this->request->data['OrdersetMaster']['modified_by']	 = $this->Session->read('userid');				
			}else{
				$this->request->data['OrdersetMaster']['create_time'] = date("Y-m-d H:i:s");
				$this->request->data['OrdersetMaster']['created_by']	 = $this->Session->read('userid');				
			}
			$this->request->data['OrdersetMaster']['location_id']=$this->Session->read('locationid');
			
			$this->OrdersetMaster->save($this->request->data);
			$lastInsertOrdersetId = $this->OrdersetMaster->getInsertID();
			
			if(empty($lastInsertOrdersetId))
				$lastInsertOrdersetId=$this->request->data['OrdersetMaster']['id'];			
			
			$result=$this->MultipleOrderSet->insertOrdersetCategories($this->request->data,$lastInsertOrdersetId);
			
			$errors = $this->OrdersetMaster->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			} else {
				$this->Session->setFlash(__('Order saved successfully', true, array('class'=>'message')));
				$this->redirect(array('action'=>'index','admin'=>true));
			}
			}		
		exit;	
	}
	/////BOF-Mahalaxmi
	public function admin_order_delete($id=null){
		$this->uses=array('OrdersetMaster');		
		if(!empty($id)){
			$this->OrdersetMaster->id= $id ;
			$this->OrdersetMaster->save(array('is_deleted'=>1));			
			$this->Session->setFlash(__('Order have been deleted', true, array('class'=>'message')));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		$this->redirect($this->referer());
	}
	/////BOF-Mahalaxmi
	public function ajaxDefaultList($orderCategorytId=null,$ordersetMasterId=null){
		$this->loadModel('ReviewSubCategory');
		$this->uses=array('OrderCategory');		
		$this->layout=false;
		/** Default for all Dynamic**/
		if(!empty($orderCategorytId)){
			$getArrayDefault=$this->loadLinkDefaults($orderCategorytId,$ordersetMasterId);
			$this->set('getArrayDefault',$getArrayDefault);
			$this->set('ordersetId',$ordersetId);
		}
		//////**************BOF-For All OrdercCategory Link********////
		$getOrderCategoryData=$this->OrderCategory->find('first',array('fields'=>array('order_description','id'),'conditions'=>array('OrderCategory.id'=>$orderCategorytId,'OrderCategory.status'=>1,'OrderCategory.is_deleted'=>0)));
	
		//////**************EOF-For All OrdercCategory Link********////
		
		$resultOfSubCategory  = $this->ReviewSubCategory->find('list',array('fields'=>array('id','name'),
				'conditions'=>array('parameter'=>'Intake','review_category_id'=>'4',
						'OR'=>array('ReviewSubCategory.name LIKE "%continuous infusion%"','ReviewSubCategory.name LIKE "%medications%"','ReviewSubCategory.name LIKE "%parenteral%"'))));
			
		$this->set('getOrderCategoryData',$getOrderCategoryData);
		$this->set('resultOfSubCategory',$resultOfSubCategory);
	
	}
	public function loadLinkDefaults($orderCategorytId=null,$ordersetMasterId=null){
		$this->uses=array('OrderCategory','OrderSubcategory');
		$getAllOrderCategoryData=$this->OrderSubcategory->find('all',array('conditions'=>array('OrderSubcategory.order_category_id'=>$orderCategorytId,'OrderSubcategory.orderset_master_id'=>$ordersetMasterId,'OrderSubcategory.is_deleted'=>0)));
		$getStrghTxt=Configure::read('selected_strength');
		$getRoopTxt=Configure :: read('selected_roop');
		$getRouteAdmTxt=Configure :: read('selected_route_administration');
		$getFrqTxt=Configure :: read('selected_frequency');
		$cnt="0";
		
		foreach($getAllOrderCategoryData as $key=>$data){
			$newArry=(array) $data;				
			$returnAtty['OrderSubcategory'][$cnt]['name']=$newArry['OrderSubcategory']['name'];
			$returnAtty['OrderSubcategory'][$cnt]['order_sentence']=$newArry['OrderSubcategory']['order_sentence'];
			$returnAttyOrderExplode=explode(',',$returnAtty['OrderSubcategory'][$cnt]['order_sentence']);
			
			
				
			$getExpIntakedrp=explode(':',$returnAttyOrderExplode['3']); /////IntakeDrp
			$getQuantity=explode(':',$returnAttyOrderExplode['4']); /////quantity
				
			$resultOfSubCategory  =$this->ReviewSubCategory->find('first',array('fields'=>array('id','name'),
					'conditions'=>array('parameter'=>'Intake','review_category_id'=>'4','name'=>trim($getExpIntakedrp['1']),
							'OR'=>array('ReviewSubCategory.name LIKE "%continuous infusion%"','ReviewSubCategory.name LIKE "%medications%"','ReviewSubCategory.name LIKE "%parenteral%"'))));
		
		
			///$data['dosageValue'][$i]/---strenght value=====
			///$data['DosageForm'][$i]/---strenght Drp====
			///$data['strength'][$i]/---Dose Form====
			///$data['route_administration'][$i]/---Route Form
			///$data['frequency'][$i]/---frequency Form   ,,,,,
			///Intake:
			///$data['intake'][$i]/---intake Form
			$getExpFirstArr=explode(' ',$returnAttyOrderExplode['0']);			////First array of 3 values
		
			$returnAtty['OrderSubcategory'][$cnt]['dosageValue']=$getExpFirstArr['0'];//// dosageValue
			$returnAtty['OrderSubcategory'][$cnt]['DosageForm']=$getStrghTxt[$getExpFirstArr['1']];////strength drpList
			$returnAtty['OrderSubcategory'][$cnt]['strength']=$getRoopTxt[$getExpFirstArr['2']];////dose Form drpList
		
			$returnAtty['OrderSubcategory'][$cnt]['route_administration']=$getRouteAdmTxt[$returnAttyOrderExplode['1']];////routes Admin
			$returnAtty['OrderSubcategory'][$cnt]['frequency']=$getFrqTxt[$returnAttyOrderExplode['2']];////frequency Admin
			$returnAtty['OrderSubcategory'][$cnt]['intake']=$resultOfSubCategory['ReviewSubCategory']['id'];////frequency Admin
			$returnAtty['OrderSubcategory'][$cnt]['id']=$newArry['OrderSubcategory']['id'];
			$returnAtty['OrderSubcategory'][$cnt]['quantity']=$getQuantity[1];
				
			$cnt++;
		}
		return ($returnAtty);
	}

	
	//function to check Orderset Name availability
	function admin_ajaxValidateOrderSetname(){
		$this->uses=array('OrdersetMaster');
		$this->layout = 'ajax';
		$this->autoRender =false ;
		$orderSetname = $this->params->query['fieldValue'];
		if($orderSetname == ''){
			return;
		}
		$orderSetname = $this->params->query['fieldValue'];
		$count = $this->OrdersetMaster->find('count',array('conditions'=>array('name'=>$orderSetname,'OrdersetMaster.is_deleted' => 0)));
		if(!$count){
			return json_encode(array('name',true,'* This Order Set name is available')) ; //name-is the id of that textbox
		}else{ return json_encode(array('name',false,'* This Order Set name is already taken')) ;
		}
	
		exit;
	}
	
	public function deleteSubCategoryRecord($preRecordId){
		$this->uses=array('OrderSubcategory');	
		$this->OrderSubcategory->updateAll(array('OrderSubcategory.is_deleted'=>'1'),array('id'=>$preRecordId));
		exit;
	}
	public function index ($patient_id=null,$master_id=null,$myarray=array()){
		$this->layout= "advance";
		$this->uses=array('OrdersetMaster','MultipleOrderContaint','OrdersetCategoryMapping','OrderCategory','OrderSubcategory',
				'OrderSentence','PatientOrder','Patient','PatientOrderEncounter');
		// To save the data in tables
		
		if(isset($this->request->data) &&!empty($this->request->data)){			
			// important becoz now person id is used in newcrop
			
			if(empty($this->request->data['PatientOrderEncounter']['id'])){
				$this->request->data['PatientOrderEncounter']['create_time'] = date("Y-m-d H:i:s");
				$this->request->data['PatientOrderEncounter']['created_by']	 = $this->Session->read('userid');
			}else{
				$this->request->data['PatientOrderEncounter']['modified_time'] = date("Y-m-d H:i:s");
				$this->request->data['PatientOrderEncounter']['modify_by']	 = $this->Session->read('userid');
			}
			$this->request->data['PatientOrderEncounter']['patient_id']=$this->request->data['patientId'];
			$this->request->data['PatientOrderEncounter']['note_id']=$_SESSION['noteId'];
			
			$this->PatientOrderEncounter->save($this->request->data['PatientOrderEncounter']);
			$lastInsertPatientOrderEncounterId = $this->PatientOrderEncounter->getInsertID();
			if(!empty($lastInsertPatientOrderEncounterId)){
				$this->request->data['lastInsertPatientOrderEncounterId']=$lastInsertPatientOrderEncounterId;
			}else{
				$this->request->data['lastInsertPatientOrderEncounterId']=$this->request->data['PatientOrderEncounter']['id'];
			}
			//debug($this->request->data['lastInsertPatientOrderEncounterId']);
			$getPersonId=$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$this->request->data['patientId']),'fields'=>array('person_id')));
			$result=$this->MultipleOrderContaint->saveOtherData($this->request->data['patientId'],$this->request->data['conponentName'],$getPersonId['Patient']['person_id'],$this->request->data['lastInsertPatientOrderEncounterId']);
			//debug($result);
			echo $result."_".$this->request->data['lastInsertPatientOrderEncounterId']."_".$this->request->data['PatientOrderEncounter']['note_id'];
			exit;
		}
		$this->OrdersetMaster->bindModel(array(
				'hasMany'=>array('OrdersetCategoryMapping'=>array('foreignKey'=>'orderset_master_id'))));
			
		$data = $this->OrdersetMaster->find('all',array('conditions'=>array('OrdersetMaster.id'=>$master_id)));

		$multiOrderType=$data[0]['OrdersetMaster']['name'];
		$this->set('multiOrderType',$multiOrderType);
		foreach($data as $key => $value){
			if(!empty($value['OrdersetCategoryMapping'])){
				foreach($value['OrdersetCategoryMapping'] as $subKey =>$subValue){
					$customArray[$value['OrdersetCategoryMapping']['order_category_id']][$subValue['order_category_id']]  = $subValue['order_category_id'] ;
					$OrderCategoryId[] = $subValue['order_category_id'] ;
				}
			}
		}
		/*$this->OrderCategory->bindModel(array(
		 'belongsTo'=>array(
		 		'OrderSubcategory'=>array('foreignKey'=>false,'conditions'=>array('OrderSubcategory.order_category_id=OrderCategory.id')))));*/

		$this->OrderCategory->bindModel(array(
				'hasMany'=>array(
						'OrderSubcategory'=>array('foreignKey'=>'order_category_id','conditions'=>array('OrderSubcategory.orderset_master_id'=>$master_id),
								'fields'=>array('OrderSubcategory.*'),
								/*'PatientOrder'=>array('foreignKey'=>'order_category_id','conditions'=>array('PatientOrder.patient_id'=>$patient_id),
								 'fields'=>array('PatientOrder.name','PatientOrder.sentence'))*/
						))));

		$getAllOrderCategoryData=$this->PatientOrderEncounter->find('all',array('conditions'=>array('PatientOrderEncounter.id'=>$OrderCategoryId)));
		$getAllOrderCategoryData=$this->OrderCategory->find('all',array('conditions'=>array('OrderCategory.id'=>$OrderCategoryId)));
		//debug($OrderCategoryId);
		//$this->patient_info($patient_id);
		
		$this->set('getMultiOrderData',$getAllOrderCategoryData);
		//$this->set('getCategory',$this->OrderCategory->find('all',array('fields'=>array('id','order_description'),'conditions'=>array('status'=>'1'))));
		$this->set('patient_id',$patient_id);
	}

	public function addordermultiples($patient_id=null){
		$this->layout = false;
		$this->uses=array('OrdersetMaster');
		$this->set('patient_id',$patient_id);
		if($this->request->query['finddata']!=''){
			$conditions['OrdersetMaster']['name LIKE'] = "%".$this->request->query['finddata']."%";
			//$conditions=array_merge($search_key,$conditions);
			$conditions = $this->postConditions($conditions);

			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'conditions' =>$conditions,
					'fields'=>array('OrdersetMaster.name','OrdersetMaster.id')
			);
			$data = $this->paginate('OrdersetMaster');
			$this->set('data', $data);

			$this->set('patient_id',$this->request->query['patientid']);
			//$this->set('category',$this->request->query['category']);
			$this->set('isAjax', $this->RequestHandler->isAjax());
			$this->layout = false;
			$this->render('ajaxordermultiple');
			//echo  json_encode($result_demograpic);exit;

		}
	}

	public function ivsolution()
	{
		$this->uses= array('PatientOrder','NewCropPrescription');
		if ($this->request->is('post'))
		{
			if ($this->request->data['PatientOrder']['type']=='IV Solution')
			{
				$this->request->data['PatientOrder']['type']='IV_Sol';
			}


			$getrecord=$this->PatientOrder->find('count' ,array('conditions' => array('patient_id' => $this->request->data['PatientOrder']['patient_id'],'order_category_id' => $this->request->data['PatientOrder']['order_category_id'])));

			$order_category_id= $this->request->data['PatientOrder']['order_category_id'];
			$order_subcategory_id= $this->request->data['PatientOrder']['order_subcategory_id'];

			if($getrecord > 0){
				$date=$this->DateFormat->formatDate2STD($this->request->data['PatientOrder']['first_dose'],Configure::read('date_format'));
				$sentence=$date.", ".$this->request->data['PatientOrder']['infuse_rate'].", ".$this->request->data['PatientOrder']['infuse_rate_volume'].", ".
						$this->request->data['PatientOrder']['frequency'].", ".$this->request->data['PatientOrder']['quantity'].", ".
						$this->request->data['PatientOrder']['quantity_volume'].", ".$this->request->data['PatientOrder']['weight'].", ".
						$this->request->data['PatientOrder']['weight_volume'].", ".$this->request->data['PatientOrder']['volume'].", ".
						$this->request->data['PatientOrder']['volume_weight'].", ".$this->request->data['PatientOrder']['dose_volume'];
				$patient_id= $this->request->data['PatientOrder']['patient_id'];
				$name= $this->request->data['PatientOrder']['name'];
				$overrideInstruction= $this->request->data['PatientOrder']['overrideInstruction'];
				$is_orverride= $this->request->data['PatientOrder']['is_orverride'];
				$type= $this->request->data['PatientOrder']['type'];
				$order_category_id= $this->request->data['PatientOrder']['order_category_id'];
				$order_subcategory_id= $this->request->data['PatientOrder']['order_subcategory_id'];
				$status= $this->request->data['PatientOrder']['status'];
				$isMultiple= 'Yes';
				$review_id=$this->request->data['PatientOrder']['review_id'];
				$location_id= $this->Session->read('locationid');
				$mapping_id= $this->request->data['PatientOrder']['mapping_id'];
				$mtime=date('Y-m-d H:i:s');

				$this->PatientOrder->updateAll(array('patient_id'=>"'$patient_id'",'name'=>"'$name'",
						'sentence'=>"'$sentence'",
						'overrideInstruction'=>"'$overrideInstruction'",
						'is_orverride'=>"'$is_orverride'",
						'type'=>"'$type'",
						'order_category_id'=>"'$order_category_id'",
						'order_subcategory_id'=>"'$order_subcategory_id'",
						'status'=>"'$status'",
						'isMultiple'=>"'$isMultiple'",
						'review_id'=>"'$review_id'",
						'location_id'=>"'$location_id'",
						'modified_time' =>"'$mtime'",
						'mapping_id'=>"'$mapping_id'"),array('patient_id'=>$this->request->data['PatientOrder']['patient_id'],'order_category_id' => $this->request->data['PatientOrder']['order_category_id']));
				$this->set('patient_id',$patient_id);
				/* if(empty($patient_id)){
					$patient_id = $this->request->data['PatientOrder']['patient_id'];
				}
				$this->redirect(array('action' => 'index',$patient_id)); */
			}
			else
			{

				$ctime=date('Y-m-d H:i:s');
				$date=$this->DateFormat->formatDate2STD($this->request->data[PatientOrder][first_dose],Configure::read('date_format'));
				$sentence=$date.", ".$this->request->data[PatientOrder][infuse_rate].", ".$this->request->data[PatientOrder][infuse_rate_volume].", ".
						$this->request->data[PatientOrder][frequency].", ".$this->request->data[PatientOrder][quantity].", ".
						$this->request->data[PatientOrder][quantity_volume].", ".$this->request->data[PatientOrder][weight].", ".
						$this->request->data[PatientOrder][weight_volume].", ".$this->request->data[PatientOrder][volume].", ".
						$this->request->data[PatientOrder][volume_weight].", ".$this->request->data[PatientOrder][dose_volume];
				$isMultiple= 'Yes';
				$dataArray = array('patient_id'=>$this->request->data['PatientOrder']['patient_id'],
						'name'=>$this->request->data['PatientOrder']['name'],
						'sentence'=>$sentence,
						'overrideInstruction'=>$this->request->data['PatientOrder']['overrideInstruction'],
						'is_orverride'=>$this->request->data['PatientOrder']['is_orverride'],
						'type'=>$this->request->data['PatientOrder']['type'],
						'order_category_id'=>$this->request->data['PatientOrder']['order_category_id'],
						'order_subcategory_id'=>$this->request->data['PatientOrder']['order_subcategory_id'],
						'status'=>$this->request->data['PatientOrder']['status'],
						'isMultiple'=>$isMultiple,
						'review_id'=>$this->request->data['PatientOrder']['review_id'],
						'location_id'=>$this->Session->read('locationid'),
						'mapping_id'=>$this->request->data['PatientOrder']['mapping_id'],
						'create_time' =>$ctime,
						'patient_id' =>$this->request->data['PatientOrder']['patient_id']) ;
				$this->PatientOrder->saveAll($dataArray);
				/* $this->set('patient_id',$patient_id);
				 if(empty($patient_id)){
				$patient_id = $this->request->data['PatientOrder']['patient_id'];
				}
				$this->redirect(array('action' => 'index',$patient_id)); */
			}

			$patientorder=$this->PatientOrder->find('first' ,array('conditions' => array('patient_id' => $this->request->data['PatientOrder']['patient_id'],'order_subcategory_id' => $this->request->data['PatientOrder']['order_subcategory_id'])));

			if(!empty($patientorder['PatientOrder']['id']))
			{
				$getnewrecord=$this->NewCropPrescription->find('count' ,array('conditions' => array('patient_order_id' =>$patientorder['PatientOrder']['id'],'order_subcategory_id' => $this->request->data['PatientOrder']['order_subcategory_id'])));

				if($getnewrecord > 0){

					$NewCropPrescription['firstdose']="'".$this->DateFormat->formatDate2STD($this->request->data['PatientOrder']['first_dose'],Configure::read('date_format'))."'";
					$NewCropPrescription['infuse_rate']="'".$this->request->data['PatientOrder']['infuse_rate']." ".$this->request->data['PatientOrder']['infuse_rate_volume']."'";
					$NewCropPrescription['quantity']="'".$this->request->data['PatientOrder']['quantity']." ".$this->request->data['PatientOrder']['quantity_volume']."'";
					$NewCropPrescription['weight']="'".$this->request->data['PatientOrder']['weight']." ".$this->request->data['PatientOrder']['weight_volume']."'";
					$NewCropPrescription['volume']="'".$this->request->data['PatientOrder']['volume']." ".$this->request->data['PatientOrder']['volume_weight']."'";
					$NewCropPrescription['dose']="'".$this->request->data['PatientOrder']['dose_volume']."'";
					$NewCropPrescription['patient_id']= "'".$this->request->data['PatientOrder']['patient_id']."'";
					$NewCropPrescription['drug_name']= "'".$this->request->data['PatientOrder']['name']."'";
					$NewCropPrescription['type']= "'".$this->request->data['PatientOrder']['type']."'";
					$NewCropPrescription['patient_order_id']="'".$patientorder['PatientOrder']['id']."'";
					$NewCropPrescription['order_category_id']= "'".$this->request->data['PatientOrder']['order_category_id']."'";
					$NewCropPrescription['order_subcategory_id']= "'".$this->request->data['PatientOrder']['order_subcategory_id']."'";
					$NewCropPrescription['modified']="'".date('Y-m-d H:i:s')."'";


					$this->NewCropPrescription->updateAll($NewCropPrescription,array('patient_order_id' =>$patientorder['PatientOrder']['id'],
							'order_subcategory_id' =>$this->request->data['PatientOrder']['order_subcategory_id']));
					$this->set('patient_id',$patient_id);
					if(empty($patient_id)){
						$patient_id = $this->request->data['PatientOrder']['patient_id'];
					}
					$this->redirect(array('action' => 'index',$patient_id));
				}
				else
				{
					$NewCropPrescription['firstdose']=$this->DateFormat->formatDate2STD($this->request->data['PatientOrder']['first_dose'],Configure::read('date_format'));
					$NewCropPrescription['infuse_rate']=$this->request->data['PatientOrder']['infuse_rate']." ".$this->request->data['PatientOrder']['infuse_rate_volume'];
					$NewCropPrescription['quantity']=$this->request->data['PatientOrder']['quantity']." ".$this->request->data['PatientOrder']['quantity_volume'];
					$NewCropPrescription['weight']=$this->request->data['PatientOrder']['weight']." ".$this->request->data['PatientOrder']['weight_volume'];
					$NewCropPrescription['volume']=$this->request->data['PatientOrder']['volume']." ".$this->request->data['PatientOrder']['volume_weight'];
					$NewCropPrescription['dose']=$this->request->data['PatientOrder']['dose_volume'];
					$NewCropPrescription['patient_id']= $this->request->data['PatientOrder']['patient_id'];
					$NewCropPrescription['drug_name']= $this->request->data['PatientOrder']['name'];
					$NewCropPrescription['type']= $this->request->data['PatientOrder']['type'];
					$NewCropPrescription['patient_order_id']=$patientorder['PatientOrder']['id'];
					$NewCropPrescription['order_category_id']= $this->request->data['PatientOrder']['order_category_id'];
					$NewCropPrescription['order_subcategory_id']= $this->request->data['PatientOrder']['order_subcategory_id'];
					$NewCropPrescription['created']=date('Y-m-d H:i:s');



					$this->NewCropPrescription->saveAll($NewCropPrescription);
					$this->set('patient_id',$patient_id);
					if(empty($patient_id)){
						$patient_id = $this->request->data['PatientOrder']['patient_id'];
					}
					$this->redirect(array('action' => 'index',$patient_id));
				}
			}


		}

	}


	// to dispaly trhe new pages in sections
	function displayorderform($noteid=null,$patient_id=null,$patient_order_id=null,$patient_order_type=null,$id=null,$order_category_id=null,$name=null,$order_description=null){
		
		$this->autoRender=false;
		
		//$this->layout = false;
		$this->uses =array('Configuration','RadiologyTestOrder','NewCropPrescription','PatientOrder','SpecimenType','Laboratory','LaboratoryTestOrder','ReviewSubCategory',
				'LaboratoryToken','Patient','MultipleOrder','OrderSubcategory','PatientOrder','OrderDataMaster','MultipleOrderContaint','Person');
		$this->set('patient_order_id',$patient_order_id);
		$this->set('patient_id',$patient_id);
		$this->set('id',$id);
		$this->set('order_category_id',$order_category_id);
		$this->set('name',$name);
		$this->set('order_description',$order_description);
		$this->set('noteid',$noteid);
		$this->set('patientencounterid',$this->params->query[patientencounterId]);
		
		if($patient_order_type=='med'){
			$strength = array_change_key_case(Configure::read('selected_strength'), CASE_LOWER);
			$dosageForm = array_change_key_case(Configure::read('selected_roop'), CASE_LOWER);
			$route = array_change_key_case(Configure::read('selected_route_administration'), CASE_LOWER);
			$frequencyArray = array_change_key_case(Configure::read('selected_frequency'), CASE_LOWER);
			//for medication
			$getDataMedication=$this->NewCropPrescription->find('first',array('conditions'=>array('NewCropPrescription.patient_order_id'=>$patient_order_id,'NewCropPrescription.patient_uniqueid'=>$patient_id),'order'=>array('NewCropPrescription.id' => 'desc')));
			$this->set('getDataMedication',$getDataMedication);
			$patient_order=$this->PatientOrder->find('first',array('fields'=>array('patient_id','name','sentence','status','overrideInstruction','is_orverride'),'conditions'=>array('PatientOrder.id'=>$patient_order_id)));
			$intakeForm = $this->ReviewSubCategory->find('list',array('fields'=>array('id','name'),
					'conditions'=>array('parameter'=>'Intake','review_category_id'=>'4',
							'OR'=>array('ReviewSubCategory.name LIKE "%continuous infusion%"','ReviewSubCategory.name LIKE "%medications%"','ReviewSubCategory.name LIKE "%parenteral%"'))));
			$this->set('intakeForm',$intakeForm);
			$this->set('patient_order',$patient_order);
			// check Overridden
			$patient_id=$patient_order['PatientOrder']['patient_id'];
			//explode sentence
			$sentences_split=explode(",",$patient_order['PatientOrder']['sentence']);

			//split dose strength
			$sentences_split_ds=explode(" ",$sentences_split[0]);
			$DosageForm=explode(",",strtoupper($sentences_split_ds[1]));

			//$sentences_split_firstdosedate=explode("dose : ",$sentences_split[3]);
			//set each values
			//split intake
			$sentences_split_intake=explode("take: ",$sentences_split[3]);
			$qtyval=explode("Quantity: ",$sentences_split[4]);
			
			$sentences_split_instructions=explode("instructions :",$sentences_split[5]);
			$this->set(array("dose_type"=>$sentences_split_ds[0],//,'strength'=>$strength[trim(strtolower($sentences_split_ds[1]))],//"firstdose_datetime"=>trim($sentences_split_firstdosedate[1]),
					'DosageForm'=>$dosageForm[trim(strtolower($sentences_split_ds[1]))],"route"=> $route[trim(strtolower($sentences_split[1]))],
					"frequency"=>$frequencyArray[trim(strtolower($sentences_split[2]))],"duration"=>$sentences_split[3],
					"special_instruction"=>trim($sentences_split_instructions[1]),"patient_id_new"=>$patient_id,'intake'=>array_search($sentences_split_intake[1], $intakeForm),"qtyval"=>$qtyval["1"]));
			$this->render('medication_order');

		}else if($patient_order_type=='lab'){

			$this->LaboratoryToken->bindModel(array(
					'belongsTo' => array(
							'LaboratoryTestOrder' =>array('foreignKey'=>false,'conditions' => array('LaboratoryToken.laboratory_test_order_id=LaboratoryTestOrder.id')),
							'Laboratory' =>array('foreignKey'=>false,'conditions' => array('Laboratory.id=LaboratoryTestOrder.laboratory_id')),
					)));
			$getDataLab=$this->LaboratoryToken->find('first',array('conditions'=>array('LaboratoryToken.patient_id'=>$patient_id,'LaboratoryToken.patient_order_id'=>$patient_order_id),'order'=>array('Laboratory.id' => 'desc')));
			$this->set('getDataLab',$getDataLab);
			$patient_order_lab=$this->PatientOrder->find('first',array('fields'=>array('patient_id','name','sentence','status'),'conditions'=>array('PatientOrder.id'=>$patient_order_id)));
			$this->set('patient_order_lab',$patient_order_lab);
			//explode sentence
			$sentences_split_lab=explode(",",$patient_order_lab['PatientOrder']['sentence']);
			$sentences_split_collecteddate=explode(": ",$sentences_split_lab[2]);
			$spec_type  = $this->SpecimenType->find('list',array('fields'=>array('SpecimenType.description','SpecimenType.description'),'order' => array('SpecimenType.description ASC')));
			$this->set(array("specimen_type"=>$sentences_split_lab[0],"collection_priority"=>trim($sentences_split_lab[1]),"collected_date"=> $sentences_split_collecteddate[1],"comment"=>$sentences_split_lab[3]));
			$this->set("spec_type",$spec_type);
			$this->render('patient_lab_order');

		}else if($patient_order_type=='rad'){

			$getDataRad=$this->RadiologyTestOrder->find('first',array('conditions'=>array('RadiologyTestOrder.patient_id'=>$patient_id,
					'RadiologyTestOrder.patient_order_id'=>$patient_order_id),'order'=>array('RadiologyTestOrder.id' => 'desc')));
			$this->set('getDataRad',$getDataRad);
			$patient_order_rad=$this->PatientOrder->find('first',array('fields'=>array('patient_id','name','sentence','status'),
					'conditions'=>array('PatientOrder.id'=>$patient_order_id)));
			$this->set('patient_order_rad',$patient_order_rad);
			//explode sentence
			$sentences_split_rad=explode(", ",$patient_order_rad['PatientOrder']['sentence']);
			$sentences_split_requesteddate=explode(": ",$sentences_split_rad[0]);
			$sentences_split_reasonexam=explode(": ",$sentences_split_rad[2]);
			$this->set(array("requested_date"=>$sentences_split_requesteddate[1],"collection_priority"=>trim($sentences_split_rad[1]),"reason_exam"=> $sentences_split_reasonexam[1],"pregnant"=>$sentences_split_rad[3],"spec_instr"=>$sentences_split_rad[4]));
			$this->Person->bindModel(array(
					'hasOne'=>array(
							'Patient' =>array('foreignKey' => false,'conditions'=>array('Patient.person_id=Person.id')))),false);
			$getpatientGender=$this->Person->find('first',array('fields'=>array('Patient.id','sex'),'conditions'=>array('Patient.id'=>$patient_id)));
			$this->set('getpatientGender',$getpatientGender);
			$this->render('patient_rad_order');
		}else{
			$patientOrderRec = $this->PatientOrder->find('first',array('fields'=>array('PatientOrder.patient_id,PatientOrder.name,
					PatientOrder.sentence,PatientOrder.overrideInstruction,PatientOrder.is_orverride,PatientOrder.type,
					PatientOrder.order_category_id,PatientOrder.status,PatientOrder.isMultiple,PatientOrder.review_id,
					PatientOrder.location_id,PatientOrder.mapping_id'),'conditions'=>array('PatientOrder.patient_id'=>$patient_id,'PatientOrder.id'=>$patient_order_id)));
			//find data for Multiple Order containt table
			$multipleOrderContent = $this->MultipleOrderContaint->find('first',array('conditions'=>array('MultipleOrderContaint.patient_id'=>$patient_id,'MultipleOrderContaint.patient_order_id'=>$patient_order_id,'MultipleOrderContaint.type'=>$patient_order_type)));
			if(!empty($multipleOrderContent['MultipleOrderContaint']['id'])){
				$start_datetimevalue=$this->DateFormat->formatDate2Local($multipleOrderContent['MultipleOrderContaint']['start_date'],Configure::read('date_format'),true);
				if($multipleOrderContent['MultipleOrderContaint']['stop_date']!='0000-00-00 00:00:00'){
					$stop_datetimevalue=$this->DateFormat->formatDate2Local($multipleOrderContent['MultipleOrderContaint']['stop_date'],Configure::read('date_format'),true);
				}
				$start_date=$start_datetimevalue;
				$frequency=trim($multipleOrderContent['MultipleOrderContaint']['frequency']);
				$duration=trim($multipleOrderContent['MultipleOrderContaint']['frequency']);
				$duration_split=explode(" ",$duration);
				$prn=trim($multipleOrderContent['MultipleOrderContaint']['prn']);
				$stop_date=$stop_datetimevalue;
				$special_inst=trim($multipleOrderContent['MultipleOrderContaint']['special_instruction']);
				$temperature=trim($multipleOrderContent['MultipleOrderContaint']['temprature']);
				$heart_rate=trim($multipleOrderContent['MultipleOrderContaint']['heart_rate']);
				$bp=trim($multipleOrderContent['MultipleOrderContaint']['bp']);
				$respiratory=trim($multipleOrderContent['MultipleOrderContaint']['respiratory']);
				$npo=trim($multipleOrderContent['MultipleOrderContaint']['npo']);
				$oxygen_therapy=trim($multipleOrderContent['MultipleOrderContaint']['oxygen_therapy']);
			}else{
				$sentences_split=explode(", ",$patientOrderRec['PatientOrder']['sentence']);
				if($patient_order_type=='act'){
					if($sentences_split['0']=="T;N"){
						$multipleOrderContent['MultipleOrderContaint']['chktn']="T;N";
						$start_date=date('m/d/Y H:i:s');
					}else{
					 $sentences_split_startDate=explode("Start Date: ",$sentences_split[0]);
					 $start_date=$this->DateFormat->formatDate2Local($sentences_split_startDate['1'],Configure::read('date_format'),true);
					}
					$special_inst=$sentences_split['1'];
				}else if($patient_order_type=='cond'){
					if($sentences_split['0']=="T;N"){
						$multipleOrderContent['MultipleOrderContaint']['chktn']="T;N";
						$start_date=$this->DateFormat->formatDate2Local(date('m/d/Y H:i:s'),Configure::read('date_format'),true);
					}else{
						$sentences_split_startDate=explode("Start Date: ",$sentences_split[0]);
						$start_date=$this->DateFormat->formatDate2Local($sentences_split_startDate['1'],Configure::read('date_format'),true);
					}
					$multipleOrderContent['MultipleOrderContaint']['admit_status']=$sentences_split['2'];
					$multipleOrderContent['MultipleOrderContaint']['admitto']=$sentences_split['1'];
				}else if($patient_order_type=='vits'){
					if($sentences_split['0']=="T;N"){
						$multipleOrderContent['MultipleOrderContaint']['chktn']="T;N";
						$start_date=date('m/d/Y H:i:s');
					}else{
						$sentences_split_startDate=explode("Start Date: ",$sentences_split[0]);
						$start_date=$this->DateFormat->formatDate2Local($sentences_split_startDate['1'],Configure::read('date_format'),true);
					}
					$frequency=$sentences_split['1'];
				}else if($patient_order_type=='vits'){
					if($sentences_split['0']=="T;N"){
						$multipleOrderContent['MultipleOrderContaint']['chktn']="T;N";
						$start_date=date('m/d/Y H:i:s');
					}else{
						$sentences_split_startDate=explode("Start Date: ",$sentences_split[0]);
						$start_date=$this->DateFormat->formatDate2Local($sentences_split_startDate['1'],Configure::read('date_format'),true);
					}
					$frequency=$sentences_split['1'];
				}
				if($patient_order_type=='diet'){
					if($sentences_split['0']=="T;N"){
						$multipleOrderContent['MultipleOrderContaint']['chktn']="T;N";
						$start_date=$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'),true);
					}else{
						$sentences_split_startDate=explode("Start Date: ",$sentences_split[0]);
						$start_date=$this->DateFormat->formatDate2Local($sentences_split_startDate['1'],Configure::read('date_format'),true);
					}
					$special_inst=$sentences_split['1'];
				}
				if($patient_order_type=='ptcare'){
					if($sentences_split['0']=="T;N"){
						$multipleOrderContent['MultipleOrderContaint']['chktn']="T;N";
						$start_date=date('m/d/Y H:i:s');
							
					}else{
						$sentences_split_startDate=explode("Start Date: ",$sentences_split[0]);
						$start_date=$this->DateFormat->formatDate2Local($sentences_split_startDate['1'],Configure::read('date_format'),true);
					}
					$special_inst=$sentences_split['1'];
				}
			}
			//end
			$orderDatamasterId=$this->OrderDataMaster->find('first' ,array('fields'=>array('OrderDataMaster.id'),
					'conditions' => array('OrderDataMaster.order_category_id' => $patientOrderRec['PatientOrder']['order_category_id'],
							'OrderDataMaster.name' => $patientOrderRec['PatientOrder']['name'])));
			$this->set(array('patientOrder'=>$patientOrderRec,'orderDatamasterId'=>$orderDatamasterId['OrderDataMaster']['id'],'patient_order_id'=>$patient_order_id,'name'=>$patientOrderRec['PatientOrder']['name'],'start_date'=>$start_date,'special_instruction' =>$special_inst,"frequency"=>$frequency,"special_instruction"=>$special_inst,"prn"=>$prn,"stop_date"=>$stop_date,'multipleOrderContent'=>$multipleOrderContent));
			$this->render($patient_order_type);
		}
	}

	public function orders($id=null,$updateStatus=null,$patientOrderEnc=null){	
		$this->uses= array('OrderCategory','PatientOrder','OrderSubcategory','OrdersetMaster','OrdersetSubcategoryMapping','User','OrderSentence','Note');
		$this->patient_info($id);
		$this->set('patientOrderEnc',$patientOrderEnc);
		if(!empty($this->params->query['noteId'])){
			$this->Session->write('noteId',$this->params->query['noteId']);
		}
		$this->layout='advance';
		/*$getOrderData=$this->OrderCategory->find('all',array('fields'=>array('id','order_description'),'conditions'=>array('OrderCategory.status'=>'1','OrderCategory.folder_category_id'=>'0')));
		this->set('getOrderData',$getOrderData);*/
		
		$this->set('patient_id',$id);
		/** To display the Primary care provider name in order set  **/
		/*$getRegistrarId=$this->Note->find('first',array('conditions'=>array('id'=>$this->params->query['noteId']),'fields'=>array('sb_registrar')));
		$getDocName=$this->User->getDoctorByID($getRegistrarId['Note']['sb_registrar']);debug($getRegistrarId);
		$this->set('getDocName',$getDocName);*/
		/** EOD **/
		//----------------------Display Added Records----------------------------------------
		$this->OrderCategory->bindModel(array(
				'hasMany' => array(
						'PatientOrder' =>array('foreignKey' => 'order_category_id','conditions'=>array('PatientOrder.patient_id'=>$id,'note_id'=>$_SESSION['noteId'],'PatientOrder.patient_order_encounter_id'=>$patientOrderEnc),
								'order'=>array('PatientOrder.modified_time DESC')))),false);
		$this->OrdersetMaster->bindModel(array(
				'hasMany'=>array(
						'OrdersetCategoryMapping'=>array('foreignKey'=>'orderset_master_id'))));
		$data = $this->OrdersetMaster->find('all',array('conditions'=>array('OrdersetMaster.id'=>'1')));
		$i=0 ;
		foreach($data as $key => $value){
			if(!empty($value['OrdersetCategoryMapping'])){
				foreach($value['OrdersetCategoryMapping'] as $subKey =>$subValue){
					$customArray[$value['OrdersetCategoryMapping']['name']][$subValue['id']]  = $subValue['name'] ;
					$ids[] = $subValue['id'] ;
				}
			}else{
				$customArray[$value['ReviewCategory']['name']]   = $value['ReviewCategory']['name']; //only main category
			}
		}
		$getTotalData=$this->OrderCategory->find('all',array('conditions'=>array('OrderCategory.status'=>'1','OrderCategory.folder_category_id'=>'0')));//,array('conditions'=>array()));'OrderCategory.id=PatientOrder.order_category_id',
		
		$getCountOfOrders=$this->PatientOrder->find('count',array('conditions'=>array('PatientOrder.patient_id'=>$id,'note_id'=>$_SESSION['noteId'])));

		//for checking left side checkbox
		if($updateStatus=='1'){
			$this->Session->setFlash(__('Order Successfully Saved', true),true,array('class'=>'message'));
		}
		if($updateStatus=='2'){
			$this->Session->setFlash(__('Order Successfully Update', true),true,array('class'=>'message'));
		}
		
		$this->set('setdata',$getTotalData);
		$this->set('setCount',$getCountOfOrders);
	}
	public function addorders($id=null,$categoryOrderId=null){
		$this->uses=array('OrderCategory');
		$getDataCategory=$this->OrderCategory->find('list',array('fields'=>array('id','order_description'),'conditions'=>array('status'=>'1')));
		$this->set('patient_id',$id);
		$this->set('getDataCategory',$getDataCategory);
		$this->set('categoryOrderId',$categoryOrderId);
		$this->layout=false;

	}


	public function updateorderset($id=null,$order_id=null,$type=null){
		$this->layout=false;
		$this->uses=array('PatientOrder','NewCropPrescription','LaboratoryToken','LaboratoryTestOrder','RadiologyTestOrder');
		$getStatus=$this->PatientOrder->find('first',array('fields'=>array('PatientOrder.status'),'conditions'=>array('PatientOrder.patient_id'=>$id,'PatientOrder.id'=>$order_id)));
		if($getStatus['PatientOrder']['status']=='Pending'){
			$changeStatus='Cancelled';
			$isdeleted="1";
		}
		else if($getStatus['PatientOrder']['status']=='Ordered'){
			$changeStatus='Cancelled';
			$isdeleted="1";
		}
		else{
			$changeStatus='Ordered';
			$isdeleted="0";
		}
		if($type=='med'){
			$updateData=$this->PatientOrder->updateAll(array('PatientOrder.status'=>"'".$changeStatus."'"),array('PatientOrder.patient_id'=>$id,'PatientOrder.id'=>$order_id));
			
			$changeStatus = trim(str_replace("\n","",$changeStatus));
			$getStatusToUpdateMedication=$this->NewCropPrescription->find('first',array('fields'=>array('NewCropPrescription.archive'),'conditions'=>array('NewCropPrescription.patient_order_id'=>$order_id,'NewCropPrescription.patient_uniqueid'=>$id)));
			if($getStatusToUpdateMedication){
				$changeArchive=$getStatusToUpdateMedication['NewCropPrescription']['archive'];
				if($changeArchive=='N'){
					$setArchive='Y';
				}
				else{
					$setArchive='N';
				}
				$updateDataMedication=$this->NewCropPrescription->updateAll(array('NewCropPrescription.archive'=>"'".$setArchive."'",'NewCropPrescription.is_deleted'=>$isdeleted),
						array('NewCropPrescription.patient_order_id'=>$order_id,'NewCropPrescription.patient_uniqueid'=>$id));

			}

			echo json_encode(array('status'=>$setArchive));exit;
		}

		else if($type=='lab'){
			$updateData=$this->PatientOrder->updateAll(array('PatientOrder.status'=>"'".$changeStatus."'"),array('PatientOrder.patient_id'=>$id,'PatientOrder.id'=>$order_id));
			
			$getIdLabToUpdate=$this->LaboratoryTestOrder->find('first',array('fields'=>array('LaboratoryTestOrder.id','LaboratoryTestOrder.is_deleted'),
					'conditions'=>array('LaboratoryTestOrder.patient_order_id'=>$order_id,'LaboratoryTestOrder.patient_id'=>$id)));
			
			
			if($getIdLabToUpdate['LaboratoryTestOrder']['is_deleted']=='1'){
				$changeStatus='0';
			}
			else{
				$changeStatus='1';
			}
			$check=$this->LaboratoryTestOrder->updateAll(array('LaboratoryTestOrder.is_deleted'=>$changeStatus),array('id'=>$getIdLabToUpdate['LaboratoryTestOrder']['id']));
			echo json_encode(array('status'=>$changeStatus));exit;
		}
		else if($type=='rad'){

			$updateData=$this->PatientOrder->updateAll(array('PatientOrder.status'=>"'".$changeStatus."'"),array('PatientOrder.patient_id'=>$id,'PatientOrder.id'=>$order_id));
			$getIdRadToUpdate=$this->RadiologyTestOrder->find('first',array('fields'=>array('RadiologyTestOrder.id','RadiologyTestOrder.is_deleted'),
					'conditions'=>array('RadiologyTestOrder.patient_order_id'=>$order_id,'RadiologyTestOrder.patient_id'=>$id)));
				
				
			if($getIdRadToUpdate['RadiologyTestOrder']['is_deleted']=='1'){
				$changeStatus='0';
			}
			else{
				$changeStatus='1';
			}
			$check=$this->RadiologyTestOrder->updateAll(array('RadiologyTestOrder.is_deleted'=>$changeStatus),array('id'=>$getIdRadToUpdate['RadiologyTestOrder']['id']));
			echo json_encode(array('status'=>$changeStatus));exit;
		}
		else{ 

		}
		$this->redirect(array('action'=>'orders',$id));
		$this->Session->setFlash(__('Order Successfully Updated', true),true,array('class'=>'message'));
		exit;

	}
	public function ordersentenceOLD($id=null,$category=null,$loinc=null,$drug_id=null,$codeId=null){
		$this->Session->write('issave',"0");
		$this->uses=array('Configuration','PharmacyItem','Radiology','Laboratory','OrderSentence','PatientOrder',
				'SpecimenType','OrderSubcategory','ReviewSubCategory','PharmacyItemDetail','OrderCategory');
		$this->layout=false;

		if(!empty($this->request->data)){
			//--- New Medication Unit DOSE AND STRENGHT ADD DO NOT REMOVE
			$getConfigueMedication=$this->Configuration->find('all');
			$explSentence=explode(', ',$this->request->data['radioId']);
			$explFirst=explode(' ',$explSentence[0]);
			$route=$explSentence[1];
			$dose=$explFirst[0];
			$strenght=$explFirst[1];
			if (!(in_array($dose, unserialize($getConfigueMedication[1]['Configuration']['value'])))) {
				$addElementInDose=unserialize($getConfigueMedication[1]['Configuration']['value']);
				$addElementInDose[$dose]=$dose;
				$addDose=strip_tags(serialize($addElementInDose));
				$ckhStatus=$this->Configuration->updateAll(array('value'=>"'$addDose'"),array('name'=>'dose'));
			}
			if (!(in_array($strenght, unserialize($getConfigueMedication[0]['Configuration']['value'])))) {
				$addElementInStrenght=unserialize($getConfigueMedication[0]['Configuration']['value']);
				$addElementInStrenght[$strenght]=$strenght;
				$addStrenght=strip_tags(serialize($addElementInStrenght));
				$ckhStatus=$this->Configuration->updateAll(array('value'=>"'$addStrenght'"),array('name'=>'strength'));
			}
			if (!(in_array($route, unserialize($getConfigueMedication[2]['Configuration']['value'])))) {
				$addElementInRoute=unserialize($getConfigueMedication[2]['Configuration']['value']);
				$addElementInRoute[$route]=$route;
				$addRoute=strip_tags(serialize($addElementInRoute));
				$ckhStatus=$this->Configuration->updateAll(array('value'=>"'$addRoute'"),array('name'=>'route'));
			}
			//exit;
			if($this->request->data['from'] == 'from'){
				$this->layout=false;
				$this->request->data['PatientOrder']['note_id']=$_SESSION['noteId'];
				if($this->PatientOrder->saveAll($this->request->data['PatientOrder'])){
					echo true;exit;
				}
					
			}else{
				$this->request->data['PatientOrder']['order_category_id']=$category;
				$this->request->data['PatientOrder']['note_id']=$_SESSION['noteId'];
				$this->request->data['PatientOrder']['patient_id']=$_SESSION['patientId'];
				if($category=='33'){
					if(!empty($codeId) && ($codeId != null)){
						//$this->request->data['radioId'] = $codeId;
					}
					$reviewName=explode('Intake:',$this->request->data['radioId']);

					$reviewName=trim($reviewName[1]);
					$this->request->data['PatientOrder']['type']='med';
					$this->request->data['PatientOrder']['sentence']=$this->request->data['radioId'];
					$this->request->data['PatientOrder']['review_id']=$reviewName;
				}
				else if($category=='36'){
					if(!empty($codeId) && ($codeId != null)){
						//$this->request->data['radioId'] = $codeId;
					}
					$this->request->data['PatientOrder']['type']='rad';
					$this->request->data['PatientOrder']['sentence']=$this->request->data['radioId'];
				}
				else if($category=='34'){
					if(!empty($codeId) && ($codeId != null)){
						//$this->request->data['radioId'] = $codeId;
					}
					$this->request->data['PatientOrder']['type']='lab';
					$this->request->data['PatientOrder']['sentence']=$this->request->data['radioId'];
				}
				else
				{
					//for all other category except med, rad and lab
					$this->OrderCategory->unbindModel(array('hasMany'=>array('OrderDataMaster')));
					$orderCategoryNameAlias  = $this->OrderCategory->find('first',array('fields'=>array('OrderCategory.order_alias'),
							'conditions' => array('OrderCategory.id'=>$this->request->data['PatientOrder']['order_category_id'])));
					$this->request->data['PatientOrder']['type']=$orderCategoryNameAlias['OrderCategory']['order_alias'];
					$this->request->data['PatientOrder']['sentence']=$this->request->data['radioId'];


				}
			}
			$this->Session->setFlash(__('Order Successfully Saved', true),true,array('class'=>'message'));
			$this->PatientOrder->save($this->request->data['PatientOrder']);
			$this->Session->write('issave',"1");exit;
		}else{
			$spec_type  = $this->SpecimenType->find('list',array('fields'=>array('SpecimenType.description','SpecimenType.description'),'order' => array('SpecimenType.description ASC')));;
			$resultOfSubCategory  = $this->ReviewSubCategory->find('list',array('fields'=>array('id','name'),
					'conditions'=>array('parameter'=>'Intake','review_category_id'=>'4',
							'OR'=>array('ReviewSubCategory.name LIKE "%continuous infusion%"','ReviewSubCategory.name LIKE "%medications%"','ReviewSubCategory.name LIKE "%parenteral%"'))));
			$this->set('resultOfSubCategory',$resultOfSubCategory);


			//find name of ordercategory
			if($loinc == 'Laboratory'){
				$loinc = $this->Laboratory->read(array('lonic_code'),$codeId);
				$loinc = $loinc['Laboratory']['lonic_code'];
			}elseif($loinc == 'Radiology'){
				$loinc = $this->Radiology->read(array('cpt_code'),$codeId);
				$loinc = $loinc['Radiology']['cpt_code'];
			}elseif($loinc == 'OrderDataMaster'){
				$loinc = $codeId;
			}else if($drug_id == 'PharmacyItem'){
				$drug_id = $this->PharmacyItem->read(array('rxcui','drug_id'),$codeId);
				$loinc =  $drug_id['PharmacyItem']['rxcui'];
				$drug_id = $drug_id['PharmacyItem']['drug_id'];
			}
			//echo $loinc.'--'.$drug_id.'--'.$codeId;exit;
			// to get the default order sentence for the Pharmacy_details Table
			$checkUpdateOrderSentence=$this->OrderSentence->find('first',array('fields'=>array('code'),'conditions'=>array('code'=>$loinc)));

			if(empty($checkUpdateOrderSentence)){
				$getPharmacyDetailsData=$this->PharmacyItem->find('first',array('fields'=>array('MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR'),'conditions'=>array('drug_id'=>$drug_id)));
					
				if(!empty($getPharmacyDetailsData)){
					$sentence=$getPharmacyDetailsData['PharmacyItem']['MED_STRENGTH']." ".$getPharmacyDetailsData['PharmacyItem']['MED_STRENGTH_UOM'].", ".$getPharmacyDetailsData['PharmacyItem']['MED_ROUTE_ABBR'];

					$this->OrderSentence->saveAll(array('code'=>$loinc,'sentence'=>$sentence,'type'=>'med','status'=>'1'));
				}
			}
			$allData=$id.'~~'.$category.'~~'.$loinc;
			$this->set('allData',$allData);
			$this->set('category',$category);
			$this->set('spec_type',$spec_type);
			//$getResultedRecords=$this->OrderSentence->find('all',array('conditions'=>array('FIND_IN_SET(\''. $loinc .'\',OrderSentence.code)')));
			$getResultedRecords=$this->OrderSentence->find('all',array('conditions'=>array('code'=>$loinc)));
			$this->set('getResultedRecord',$getResultedRecords);
			$this->set('rule',$flag);
			$this->set('loinc',$loinc);

			$this->set('patient_id',$id);
			$this->set('name',$name);
		}

	}
	public function ordersentence($id=null,$category=null,$loinc=null,$drug_id=null,$codeId=null,$patientOrderEncid=null){
		$this->Session->write('issave',"0");
		$this->uses=array('PharmacyItem','Radiology','Laboratory','OrderSentence','PatientOrder',
				'SpecimenType','OrderSubcategory','ReviewSubCategory','PharmacyItemDetail','OrderCategory');
		$this->layout=false;
		if(!empty($this->request->data)){
			
			//--- New Medication Unit DOSE AND STRENGHT ADD DO NOT REMOVE
			$explSentence=explode(', ',$this->request->data['radioId']);
			$explFirst=explode(' ',$explSentence[0]);
			$route=$explSentence[1];
			$dose=$explFirst[0];
			$strenght=$explFirst[1];

			if($this->request->data['from'] == 'from'){			
				/*$this->request->data['PatientOrder']['order_category_id']=$this->request->data['PatientOrder']['0']['order_category_id'];
				$this->request->data['PatientOrder']['sentence']=$this->request->data['PatientOrder']['0']['sentence'];
				$this->request->data['PatientOrder']['note_id']=$_SESSION['noteId'];
				$this->request->data['PatientOrder']['patient_id']=$_SESSION['patientId'];
				$this->request->data['PatientOrder']['patient_order_encounter_id']=$this->request->data['patientEnId'];
				$this->request->data['PatientOrder']['type']=$this->request->data['PatientOrder']['0']['type'];
				$this->request->data['PatientOrder']['review_id']=$this->request->data['PatientOrder']['0']['review_id'];	*/
				
			//if($this->PatientOrder->save($this->request->data['PatientOrder'])){
			//		$log = $this->PatientOrder->getDataSource()->getLog(false, false);
					//debug($log);
					echo true;exit;
			//	}
			}else{
				$this->request->data['PatientOrder']['order_category_id']=$category;
				$this->request->data['PatientOrder']['note_id']=$_SESSION['noteId'];
				$this->request->data['PatientOrder']['patient_id']=$_SESSION['patientId'];
				$this->request->data['PatientOrder']['patient_order_encounter_id']=$patientOrderEncid;
				
				if($category=='33'){
					$reviewName=explode('Intake:',$this->request->data['radioId']);
					$reviewName=trim($reviewName[1]);
					$this->request->data['PatientOrder']['type']='med';
					$this->request->data['PatientOrder']['sentence']=$this->request->data['radioId'];
					$this->request->data['PatientOrder']['review_id']=$reviewName;
					$this->request->data['PatientOrder']['status']="Ordered";
				}else if($category=='36'){
					$this->request->data['PatientOrder']['type']='rad';
					$this->request->data['PatientOrder']['sentence']=$this->request->data['radioId'];
					$this->request->data['PatientOrder']['status']="Ordered";
				}else if($category=='34'){
					$this->request->data['PatientOrder']['type']='lab';
					$this->request->data['PatientOrder']['sentence']=$this->request->data['radioId'];
					$this->request->data['PatientOrder']['status']="Ordered";
				}else{
					//for all other category except med, rad and lab
					$this->OrderCategory->unbindModel(array('hasMany'=>array('OrderDataMaster')));
					$orderCategoryNameAlias  = $this->OrderCategory->find('first',array('fields'=>array('OrderCategory.order_alias'),
							'conditions' => array('OrderCategory.id'=>$this->request->data['PatientOrder']['order_category_id'])));
					$this->request->data['PatientOrder']['type']=$orderCategoryNameAlias['OrderCategory']['order_alias'];
					$this->request->data['PatientOrder']['sentence']=$this->request->data['radioId'];
					$this->request->data['PatientOrder']['status']="Ordered";
				}
				//debug($this->request->data['PatientOrder']);
				$this->Session->setFlash(__('Order Successfully Saved', true),true,array('class'=>'message'));
				$this->PatientOrder->save($this->request->data['PatientOrder']);
				$this->Session->write('issave',"1");exit;
			}
			
		}else{
			$resultOfSubCategory  = $this->ReviewSubCategory->find('list',array('fields'=>array('id','name'),
					'conditions'=>array('parameter'=>'Intake','review_category_id'=>'4',
							'OR'=>array('ReviewSubCategory.name LIKE "%continuous infusion%"','ReviewSubCategory.name LIKE "%medications%"','ReviewSubCategory.name LIKE "%parenteral%"'))));
			$this->set('resultOfSubCategory',$resultOfSubCategory);
			//find name of ordercategory
			if($loinc == 'Laboratory'){
				$spec_type  = $this->SpecimenType->find('list',array('fields'=>array('SpecimenType.description','SpecimenType.description'),
						'order' => array('SpecimenType.description ASC')));;
				$this->set('spec_type',$spec_type);
				$type = 'lab';
			}elseif($loinc == 'Radiology'){
				$type = 'rad';
			}elseif($loinc == 'OrderDataMaster'){
				$loinc = $codeId;
			}else if($drug_id == 'PharmacyItem' || $loinc == 'PharmacyItem'){
				$type = 'med';
			}
			
			$allData=$id.'~~'.$category.'~~'.$loinc.'~~'.$drug_id.'~~'.$codeId.'~~'.$patientOrderEncid;
			$this->set('allData',$allData);
			$this->set('category',$category);

			$getResultedRecords=$this->OrderSentence->find('all',array('conditions'=>array('OrderSentence.code'=>$codeId,'OrderSentence.type'=>$type,'status'=>1)));
			$this->set('getResultedRecord',$getResultedRecords);
			$this->set('rule',$flag);
			$this->set('loinc',$codeId);
			$this->set('patient_id',$id);
			$this->set('patientOrderEncid',$patientOrderEncid);
			
			$this->set('name',$name);
		}
	}
	public function orderresults(){
		$this->uses=array('Laboratory','Radiology','PharmacyItem','PharmacyItem','OrderDataMaster');
		$this->autoRender=false;
		//echo $this->request->query['race']."<br/>";
		//echo $this->request->query['category']."<br/>";
			
		if($this->request->query['category']=='34'){
			if($this->request->query['finddata']!='')
				$conditions['Laboratory']['name LIKE'] = $this->request->query['finddata']."%";
			$conditions['Laboratory']['lonic_code NOT']='';
			//$conditions=array_merge($search_key,$conditions);
			$conditions = $this->postConditions($conditions);
			/* $this->paginate = array(
			 'limit' => Configure::read('number_of_rows'),
					'conditions' =>$conditions,
					'fields'=>array('Laboratory.name','Laboratory.lonic_code')
			);
			$data = $this->paginate('Laboratory'); */
			$data =$this->Laboratory->find('all',array('conditions'=>array($conditions),'limit'=>Configure::read('number_of_rows')));
			$this->set('data', $data);
			$this->set('patient_id',$this->request->query['patientid']);
			$this->set('category',$this->request->query['category']);
			$this->set('isAjax', $this->RequestHandler->isAjax());
			//$this->layout = false;
			$this->render('ajaxorderresult');
			//echo  json_encode($result_demograpic);exit;

		}
		else if($this->request->query['category']=='36'){

			if($this->request->query['finddata']!=''){
				$conditions['Radiology']['name LIKE'] = $this->request->query['finddata']."%";
				$conditions['Radiology']['cpt_code NOT']='';
			}

			//$conditions=array_merge($search_key,$conditions);
			$conditionsForRad = $this->postConditions($conditions);

			/* $this->paginate = array(
			 'limit' => Configure::read('number_of_rows'),
					'conditions' =>$conditionsForRad

			); */
			//$data = $this->paginate('Radiology');
			$data =$this->Radiology->find('all',array('conditions'=>array($conditionsForRad),'limit'=>Configure::read('number_of_rows')));
			$this->set('data', $data);
			$this->set('patient_id',$this->request->query['patientid']);
			$this->set('category',$this->request->query['category']);
			$this->set('isAjax', $this->RequestHandler->isAjax());
			$this->layout = false;
			$this->render('ajaxradiologyresult');
			//echo  json_encode($result_demograpic);exit;

		}
		else if($this->request->query['category']=='33'){

			if($this->request->query['finddata']!=''){
				$conditions['PharmacyItem']['name LIKE'] = $this->request->query['finddata']."%";
				$conditions['PharmacyItem']['rxcui NOT']='';
			}

			//$conditions=array_merge($search_key,$conditions);
			$conditionsForMed = $this->postConditions($conditions);

			/* $this->paginate = array(
			 'limit' => Configure::read('number_of_rows'),
					'conditions' =>$conditionsForMed

			); */
			/* $this->paginate('PharmacyItem'); */
			$data =$this->PharmacyItem->find('all',array('conditions'=>array($conditionsForMed),'limit'=>Configure::read('number_of_rows')));
			$this->set('data', $data);
			$this->set('patient_id',$this->request->query['patientid']);
			$this->set('category',$this->request->query['category']);
			$this->set('isAjax', $this->RequestHandler->isAjax());
			$this->layout = false;
			$this->render('ajaxmedicationresult');
			//echo  json_encode($result_demograpic);exit;

		}
		else
		{

			if($this->request->query['finddata']!=''){
				$conditions['OrderDataMaster']['name LIKE'] = $this->request->query['finddata']."%";
				$conditions['OrderDataMaster']['status']='1';
				$conditions['OrderDataMaster']['order_category_id']=$this->request->query['category'];
			}

			//$conditions=array_merge($search_key,$conditions);
			$conditionsForother = $this->postConditions($conditions);

			/* $this->paginate = array(
			 'limit' => Configure::read('number_of_rows'),
					'conditions' =>$conditionsForMed

			); */
			/* $this->paginate('PharmacyItem'); */
			$data =$this->OrderDataMaster->find('all',array('conditions'=>array($conditionsForother),'limit'=>Configure::read('number_of_rows')));
			$this->set('data', $data);
			$this->set('patient_id',$this->request->query['patientid']);
			$this->set('category',$this->request->query['category']);
			$this->set('isAjax', $this->RequestHandler->isAjax());
			$this->layout = false;
			$this->render('ajaxothercategory');
			//echo  json_encode($result_demograpic);exit;

		}
	}
	public function SaveOrderMedication($is_overridden=null){
		$this->uses=array('NewCropAllergies','NewCropPrescription','PatientOrder','ReviewSubCategory');

		if(!empty($this->request->data)){
			$strength = Configure::read('strength');
			$dosageForm = Configure::read('roop');
			$route = Configure::read('route_administration');
			$frequencyArray = Configure::read('frequency');
			$intakeForm = $this->ReviewSubCategory->find('list',array('fields'=>array('id','name'),
					'conditions'=>array('parameter'=>'Intake','review_category_id'=>'4',
							'OR'=>array('ReviewSubCategory.name LIKE "%continuous infusion%"','ReviewSubCategory.name LIKE "%medications%"','ReviewSubCategory.name LIKE "%parenteral%"'))));
			// to bring Allergy of Patient -aditya-====================================================================
			$getAllAlergy=$this->NewCropAllergies->find('all',array('fields'=>array('CompositeAllergyID','name'),'conditions'=>array('patient_uniqueid'=>$this->request->data['NewCropPrescription']['patient_uniqueid'],'status'=>'A')));
			//========================================================================================================
			/* debug($this->request->data);exit; */
			$this->request->data['NewCropPrescription']['firstdose']=$this->DateFormat->formatDate2STD($this->request->data['NewCropPrescription']['firstdose_time'],Configure::read('date_format'));
			$this->request->data['NewCropPrescription']['stopdose']=$this->DateFormat->formatDate2STD($this->request->data['NewCropPrescription']['stopdose_time'],Configure::read('date_format'));
			$this->request->data['NewCropPrescription']['checkoverride']=$is_overridden;
			if(!empty($this->request->data['NewCropPrescription']['overrideInstruction'])){
				$mdDateMed=date('Y-m-d H:i:s');
				$this->PatientOrder->updateAll(array('overrideInstruction'=>"'".$this->request->data['NewCropPrescription']['overrideInstruction']."'",'is_orverride'=>'1'
						,'PatientOrder.modified_time'=>"'$mdDateMed'"),array('id'=>$this->request->data['NewCropPrescription']['patient_order_id']));
			}else{
				$getConditonalData=$this->NewCropPrescription->insertMedication_order($this->request->data,$getAllAlergy);
				if($getConditonalData=='update' ||$getConditonalData=='save' ){
					$conditionAllergy='';
				}else{
					$conditionAllergy=$getConditonalData['allergyInteraction']['rowcount']=='1';
				}

			}
			if($is_overridden!=1){
				$this->request->data['NewCropPrescription']['firstdose']=$this->DateFormat->formatDate2Local($this->request->data['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);
				if(!empty($getConditonalData['interactionData']['AllDataChk'])  && ($getConditonalData!='update') && ($getConditonalData!='save') || ($conditionAllergy)){
					if(!empty($getConditonalData['interactionData']['AllDataChk'])){
						$this->set('getConditonalData',$getConditonalData['interactionData']['AllDataChk']);
						$this->set('newCropPrescriptionId',$getConditonalData['interactionData']['AllDataChk']);
					}
					if(!empty($getConditonalData['allergyInteraction']['rowDta'])){
						$this->set('allAlergy',$getConditonalData['allergyInteraction']['rowDta']);
							
					}

					echo $this->render('interaction_details');
					exit;
				}
			}
			else {
				$this->request->data['NewCropPrescription']['firstdose']=$this->DateFormat->formatDate2Local($this->request->data['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);
				$sentenceimplode='';
				if(!empty($this->request->data['NewCropPrescription']['dose']))
					$sentenceimplode.=$this->request->data['NewCropPrescription']['dose']." ";
				else
					$sentenceimplode= $sentenceimplode;
				if(!empty($this->request->data['NewCropPrescription']['strength']))
					$sentenceimplode.=$strength[$this->request->data['NewCropPrescription']['strength']]." ";
				else
					$sentenceimplode= $sentenceimplode;
				if(!empty($this->request->data['NewCropPrescription']['DosageForm']))
					$sentenceimplode.= $dosageForm[$this->request->data['NewCropPrescription']['DosageForm']].", ";
				else
					$sentenceimplode= $sentenceimplode;
				if(!empty($this->request->data['NewCropPrescription']['route']))
					$sentenceimplode.= $route[$this->request->data['NewCropPrescription']['route']].", ";
				else
					$sentenceimplode= $sentenceimplode;
				if(!empty($this->request->data['NewCropPrescription']['frequency']))
					$sentenceimplode.= $frequencyArray[$this->request->data['NewCropPrescription']['frequency']].", ";
				else
					$sentenceimplode = $sentenceimplode;
				/*if(!empty($this->request->data['NewCropPrescription']['duration']))
					$sentenceimplode.=$this->request->data['NewCropPrescription']['duration'].", ";
				else
					$sentenceimplode = "unknown duration, ";*/
				/*if(!empty($this->request->data['NewCropPrescription']['refills']))
					$sentenceimplode.=$this->request->data['NewCropPrescription']['refills']." refills, ";
				else
					$sentenceimplode=$sentenceimplode;*/
				
				if(!empty($this->request->data['NewCropPrescription']['review_sub_category_id']))
					$sentenceimplode.= "intake: ".$intakeForm[$this->request->data['NewCropPrescription']['review_sub_category_id']].", ";
				else
					$sentenceimplode .= "intake: __, ";
				
				if(!empty($this->request->data['NewCropPrescription']['quantity']))
					$sentenceimplode.="Quantity: ".$this->request->data['NewCropPrescription']['quantity'].", ";
				else
					$sentenceimplode .= "Quantity: __, ";
				
				if(!empty($this->request->data['NewCropPrescription']['firstdose']))
					$sentenceimplode.="first dose : ".$this->request->data['NewCropPrescription']['firstdose'].", ";
				else
					$sentenceimplode = "first dose : __, ";
				if(!empty($this->request->data['NewCropPrescription']['special_instruction']))
					$sentenceimplode.= "instructions : ".$this->request->data['NewCropPrescription']['special_instruction'];

				/* $sentenceimplode=implode(', ',
				 array($this->request->data['NewCropPrescription']['dose']." ".$this->request->data['NewCropPrescription']['strength'],
				 		$this->request->data['NewCropPrescription']['route'],
				 		$this->request->data['NewCropPrescription']['frequency'],
				 		$this->request->data['NewCropPrescription']['duration'],$this->request->data['NewCropPrescription']['refills']." refills","first dose : ".$this->request->data['NewCropPrescription']['firstdose'],$this->request->data['NewCropPrescription']['special_instruction'])); */
				$this->request->data['NewCropPrescription']['firstdose']=$this->DateFormat->formatDate2Local($this->request->data['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);
				$mdDateMed=date('Y-m-d H:i:s');
				$this->PatientOrder->updateAll(array('PatientOrder.sentence'=>"'$sentenceimplode'",'PatientOrder.status'=>"'Ordered'",'PatientOrder.modified_time'=>"'$mdDateMed'"),array('PatientOrder.id'=>$this->request->data['NewCropPrescription']['patient_order_id']));
				if(trim($getConditonalData)=='save'){
					echo trim($getConditonalData);
					$this->Session->setFlash(__('Medication Order Successfully Signed'),true,array('class'=>'message'));
					exit;
					//$this->redirect(array('action'=>'orders',$this->request->data['NewCropPrescription']['patient_uniqueid']));
					$this->redirect("/MultipleOrderSets/orders/".$this->request->data['NewCropPrescription']['patient_uniqueid']."/?Preview=preview&noteId=".$this->request->data['NewCropPrescription']['noteid']);
					//$this->redirect("/MultipleOrderSets/orders/".$this->request->data['NewCropPrescription']['patient_uniqueid']."/null/".$getid['PatientOrderEncounter']['id']."?Preview=preview&noteId=".$this->request->data['NewCropPrescription']['noteid']);

				}
				else{
					echo trim($getConditonalData);
					$this->Session->setFlash(__('Medication Order Updated And Signed Successfully'),true,array('class'=>'message'));
					exit;
					$this->redirect("/MultipleOrderSets/orders/".$this->request->data['NewCropPrescription']['patient_uniqueid']."/?Preview=preview&noteId=".$this->request->data['NewCropPrescription']['noteid']);

				}

			}
			if(!empty($getConditonalData['AllDataChk']) && ($getConditonalData['AllDataChk']=='1')){
				$this->set('getConditonalData',$getConditonalData['AllDataChk']);
				$this->set('newCropPrescriptionId',$getConditonalData['AllDataChk']);
				echo $this->render('interaction_details');
				exit;
			}
			else {

				$sentenceimplode='';
				if(!empty($this->request->data['NewCropPrescription']['dose']))
					$sentenceimplode.=$this->request->data['NewCropPrescription']['dose']." ";
				else
					$sentenceimplode=$sentenceimplode;
				if(!empty($this->request->data['NewCropPrescription']['strength']))
					$sentenceimplode.=$strength[$this->request->data['NewCropPrescription']['strength']]." ";
				else
					$sentenceimplode= $sentenceimplode;
				if(!empty($this->request->data['NewCropPrescription']['DosageForm']))
					$sentenceimplode.= $dosageForm[$this->request->data['NewCropPrescription']['DosageForm']].", ";
				else
					$sentenceimplode= $sentenceimplode;
				if(!empty($this->request->data['NewCropPrescription']['route']))
					$sentenceimplode.= $route[$this->request->data['NewCropPrescription']['route']].", ";
				else
					$sentenceimplode=$sentenceimplode;
				if(!empty($this->request->data['NewCropPrescription']['frequency']))
					$sentenceimplode.= $frequencyArray[$this->request->data['NewCropPrescription']['frequency']].", ";
				else
					$sentenceimplode=$sentenceimplode;
				
				
				if(!empty($this->request->data['NewCropPrescription']['review_sub_category_id']))
					$sentenceimplode.="intake: ".$intakeForm[$this->request->data['NewCropPrescription']['review_sub_category_id']].", ";
				else
					$sentenceimplode .= "intake: __, ";
				
				if(!empty($this->request->data['NewCropPrescription']['quantity']))
					$sentenceimplode.="Quantity: ".$this->request->data['NewCropPrescription']['quantity'].", ";
				else
					$sentenceimplode .= "Quantity: __, ";
				
				if(!empty($this->request->data['NewCropPrescription']['firstdose']))
					$sentenceimplode.="first dose : ".$this->request->data['NewCropPrescription']['firstdose'].", ";
				else
					$sentenceimplode = "first dose : __, ";
				
				
				if(!empty($this->request->data['NewCropPrescription']['special_instruction']))
					$sentenceimplode.="instructions : ".$this->request->data['NewCropPrescription']['special_instruction'];
				else
					$sentenceimplode=$sentenceimplode;
				$mdDateMed=date('Y-m-d H:i:s');
				$this->PatientOrder->updateAll(array('PatientOrder.sentence'=>"'$sentenceimplode'",'PatientOrder.status'=>"'Ordered'",'PatientOrder.modified_time'=>"'$mdDateMed'"),array('PatientOrder.id'=>$this->request->data['NewCropPrescription']['patient_order_id']));
				if(trim($getConditonalData)=='1save'){
					echo trim($getConditonalData);
					$this->Session->setFlash(__('Medication Successfully Signed', true),true,array('class'=>'message'));
					exit;
					$this->redirect("/MultipleOrderSets/orders/".$this->request->data['NewCropPrescription']['patient_uniqueid']."/?Preview=preview&noteId=".$this->request->data['NewCropPrescription']['noteid']);
					

				}
				else{
					echo trim($getConditonalData);
					$this->Session->setFlash(__('Medication Order Updated Successfully Signed', true),true,array('class'=>'message'));
					exit;
					$this->redirect("/MultipleOrderSets/orders/".$this->request->data['NewCropPrescription']['patient_uniqueid']."/?Preview=preview&noteId=".$this->request->data['NewCropPrescription']['noteid']);

				}


			}

		}

	}

	public function SaveOrderLab(){
		$this->uses=array('LaboratoryTestOrder','PatientOrder','Laboratory');
		if(!empty($this->request->data)){

			$labId=$this->Laboratory->find('first',array('fields'=>array('id'),'conditions'=>array('Laboratory.name'=>$this->request->data['Laboratory']['name'])));
			$this->request->data['LaboratoryTestOrder']['collected_date']=$this->DateFormat->formatDate2STD($this->request->data['LaboratoryTestOrder']['collected_date'],Configure::read('date_format'));
			$this->request->data['LaboratoryTestOrder']['end_date']=$this->DateFormat->formatDate2STD($this->request->data['LaboratoryTestOrder']['end_date'],Configure::read('date_format'));
			$this->request->data['LaboratoryTestOrder']['laboratory_id']=$labId['Laboratory']['id'];

			$checkupdate=$this->LaboratoryTestOrder->insertTestOrder($this->request->data);
			$sentenceimplode='';
			if(!empty($this->request->data['LaboratoryTestOrder']['specimen_type_id']))
				$sentenceimplode.=$this->request->data['LaboratoryTestOrder']['specimen_type_id'].", ";
			else
				$sentenceimplode=$sentenceimplode;
			if(!empty($this->request->data['LaboratoryTestOrder']['collection_priority']))
				$sentenceimplode.=$this->request->data['LaboratoryTestOrder']['collection_priority'].", ";
			else
				$sentenceimplode=$sentenceimplode;
			if(!empty($this->request->data['LaboratoryTestOrder']['frequency_l']))
				$sentenceimplode.=$this->request->data['LaboratoryTestOrder']['frequency_l'].", ";
			else
				$sentenceimplode=$sentenceimplode;
			if(!empty($this->request->data['LaboratoryTestOrder']['duration_l']))
				$sentenceimplode.=$this->request->data['LaboratoryTestOrder']['duration_l']." ".$this->request->data['LaboratoryTestOrder']['duration_unit'];
			else
				$sentenceimplode=$sentenceimplode;
			/* $sentenceimplode=implode(', ',
			 array($this->request->data['LaboratoryTestOrder']['specimen_type_id'],
			 		$this->request->data['LaboratoryTestOrder']['collection_priority'],
			 		$this->request->data['LaboratoryTestOrder']['frequency_l'],
			 		$this->request->data['LaboratoryTestOrder']['duration_l'].$this->request->data['LaboratoryTestOrder']['duration_unit'])); */
			$mdDateLab=date('Y-m-d H:i:s');
			$this->PatientOrder->updateAll(array('PatientOrder.sentence'=>"'$sentenceimplode'",'PatientOrder.status'=>"'Ordered'",'PatientOrder.modified_time'=>"'$mdDateLab'"),array('PatientOrder.id'=>$this->request->data['LaboratoryTestOrder']['patient_order_id']));

			if(trim($checkupdate['dbState'])=="save"){
				$this->Session->setFlash(__('Lab Order Successfully Signed', true),true,array('class'=>'message'));
				$this->redirect(array('action'=>'orders',$this->request->data['Laboratory']['patient_id'],"?"=>array('noteId'=>$_SESSION['noteId'])));
			}
			else {
				$this->Session->setFlash(__('Lab Order Updated and Signed Successfully', true),true,array('class'=>'message'));
				$this->redirect(array('action'=>'orders',$this->request->data['Laboratory']['patient_id'],"?"=>array('noteId'=>$_SESSION['noteId'])));
			}


		}

	}
	public function SaveOrderRad(){

		$this->uses=array('RadiologyTestOrder','PatientOrder','Patient');
		$this->request->data['RadiologyTestOrder']['is_procedure']='0';
		$this->request->data['RadiologyTestOrder']['collected_date']=$this->DateFormat->formatDate2STD($this->request->data['RadiologyTestOrder']['collected_date'],Configure::read('date_format'));

		if(!empty($this->request->data)){
			debug($this->request->data);
			$checkRadupdate=$this->RadiologyTestOrder->insertRadioTestOrder($this->request->data);
			$sentenceimplode='';
			if(!empty($this->request->data['RadiologyTestOrder']['collection_priority']))
				$sentenceimplode.=" ".$this->request->data['RadiologyTestOrder']['collection_priority'].", ";
			else
				$sentenceimplode.=$sentenceimplode;
			if(!empty($this->request->data['RadiologyTestOrder']['frequency_r']))
				$sentenceimplode.=" ".$this->request->data['RadiologyTestOrder']['frequency_r'].", ";
			else
				$sentenceimplode.=$sentenceimplode;
			if(!empty($this->request->data['RadiologyTestOrder']['reason_exam']))
				$sentenceimplode.=" ".$this->request->data['RadiologyTestOrder']['reason_exam'].", ";
			else
				$sentenceimplode.=$sentenceimplode;
			/* $sentenceimplode=implode(',',
			 array($this->request->data['RadiologyTestOrder']['collection_priority'],
			 		$this->request->data['RadiologyTestOrder']['frequency_r'],
			 		$this->request->data['RadiologyTestOrder']['reason_exam'])); */
			$mdDateRad=date('Y-m-d H:i:s');
			$this->PatientOrder->updateAll(array('PatientOrder.sentence'=>"'$sentenceimplode'",'PatientOrder.status'=>"'Ordered'",'PatientOrder.modified_time'=>"'$mdDateRad'"),array('PatientOrder.id'=>$this->request->data['RadiologyTestOrder']['patient_order_id']));
			if(trim($checkRadupdate)=='save'){
				$this->Session->setFlash(__('Radiology Successfully Signed', true),true,array('class'=>'message'));
				$this->redirect(array('action'=>'orders',$this->request->data['RadiologyTestOrder']['patient_id'],"?"=>array('noteId'=>$_SESSION['noteId'])));
			}
			else{
				$this->Session->setFlash(__('Radiology Order Updated and Signed Successfully', true),true,array('class'=>'message'));
				$this->redirect(array('action'=>'orders',$this->request->data['RadiologyTestOrder']['patient_id'],"?"=>array('noteId'=>$_SESSION['noteId'])));
			}

			exit;

		}


	}
	public function SaveOtherOrder($type=null){
		$this->uses=array('MultipleOrderContaint','PatientOrder');
		$isMultiple="No";
		$this->request->data['PatientOrder']['type']=$type;
		$this->request->data['PatientOrder']['start_date']=$this->DateFormat->formatDate2STD($this->request->data['PatientOrder']['start_date'],Configure::read('date_format'));
		$this->request->data['PatientOrder']['stop_date']=$this->DateFormat->formatDate2STD($this->request->data['PatientOrder']['stop_date'],Configure::read('date_format'));
		if(!empty($this->request->data)){
			$dbStatus=$this->MultipleOrderContaint->insertOrder($this->request->data['PatientOrder'],$isMultiple);
			//create order sentence for different categoriest
			if($type=='act')
			{
				if(!empty($this->request->data['PatientOrder']['chktn']))
				{
					$start_date="T;N";
				}
				else
				{
					$start_date="Start Date: ".$this->request->data['PatientOrder']['start_date'];
				}
					
				$sentenceimplode=implode(', ',
						array($start_date,
								$this->request->data['PatientOrder']['special_instruction']));
					
				if(!empty($this->request->data['PatientOrder']['frequency']))
				{
					$sentenceimplode.=", ".$this->request->data['PatientOrder']['frequency'];

				}
				if(!empty($this->request->data['PatientOrder']['prn']))
				{
					$prnvalue="PRN";
					$sentenceimplode.=", ".$prnvalue;

				}
				if(!empty($this->request->data['PatientOrder']['duration']) && !empty($this->request->data['PatientOrder']['duration_unit']))
				{
					$sentenceimplode.=", ".$this->request->data['PatientOrder']['duration']." ".$this->request->data['PatientOrder']['duration_unit'];

				}
				if(!empty($this->request->data['PatientOrder']['stop_date']))
				{
					$sentenceimplode.=", Stop Date: ".$this->request->data['PatientOrder']['stop_date'];

				}
					
			}

			if($type=='diet')
			{
				if(!empty($this->request->data['PatientOrder']['chktn']))
				{
					$start_date="T;N";
				}
				else
				{
					$start_date=$this->request->data['PatientOrder']['start_date'];
				}

				$sentenceimplode=implode(', ',
						array($start_date,
								$this->request->data['PatientOrder']['special_instruction']));
					
				if(!empty($this->request->data['PatientOrder']['frequency']))
				{
					$sentenceimplode.=", ".$this->request->data['PatientOrder']['frequency'];

				}
				if(!empty($this->request->data['PatientOrder']['npo']))
				{
					$sentenceimplode.=", ".$this->request->data['PatientOrder']['npo'];

				}
				if(!empty($this->request->data['PatientOrder']['duration']) && !empty($this->request->data['PatientOrder']['duration_unit']))
				{
					$sentenceimplode.=", ".$this->request->data['PatientOrder']['duration']." ".$this->request->data['PatientOrder']['duration_unit'];

				}
					
			}

			if($type=='vits')
			{
				if(!empty($this->request->data['PatientOrder']['chktn']))
				{
					$start_date="T;N";
				}
				else
				{
					$start_date="Start Date: ".$this->request->data['PatientOrder']['start_date'];
				}
					
				$sentenceimplode=implode(', ',
						array($start_date,
								$this->request->data['PatientOrder']['frequency'],$this->request->data['PatientOrder']['temprature'],$this->request->data['PatientOrder']['bp'],$this->request->data['PatientOrder']['heart_rate']));
					
				if(!empty($this->request->data['PatientOrder']['oxygen_therapy']))
				{
					$sentenceimplode.=", Oxygen Therapy : ".$this->request->data['PatientOrder']['oxygen_therapy'];

				}
				if(!empty($this->request->data['PatientOrder']['respiratory']))
				{
					$sentenceimplode.=", Respiratory : ".$this->request->data['PatientOrder']['respiratory'];

				}
				if(!empty($this->request->data['PatientOrder']['special_instruction']))
				{
					$sentenceimplode.=", ".$this->request->data['PatientOrder']['special_instruction'];

				}

					
			}

			if($type=='cond')
			{

				if(!empty($this->request->data['PatientOrder']['chktn']))
				{
					$start_date="T;N";
				}
				else
				{
					$start_date="Start Date: ".$this->request->data['PatientOrder']['start_date'];
				}
					
					
				$sentenceimplode=implode(', ',
						array($start_date,
								$this->request->data['PatientOrder']['admit_status']));
					
				if(!empty($this->request->data['PatientOrder']['admitto']))
				{
					$sentenceimplode.=", Admit to : ".$this->request->data['PatientOrder']['admitto'];

				}
				if(!empty($this->request->data['PatientOrder']['resuscitation_status']))
				{
					$sentenceimplode.=", Resuscitation Status : ".$this->request->data['PatientOrder']['resuscitation_status'];

				}
				if(!empty($this->request->data['PatientOrder']['special_instruction']))
				{
					$sentenceimplode.=", ".$this->request->data['PatientOrder']['special_instruction'];

				}
					
					
			}

			if($type=='ptcare')
			{
				if(!empty($this->request->data['PatientOrder']['chktn']))
				{
					$start_date="T;N";
				}
				else
				{
					$start_date=$this->request->data['PatientOrder']['start_date'];
				}
					
				$sentenceimplode=implode(', ',
						array($start_date,
								$this->request->data['PatientOrder']['special_instruction']));
					
				if(!empty($this->request->data['PatientOrder']['frequency']))
				{
					$sentenceimplode.=", ".$this->request->data['PatientOrder']['frequency'];

				}
				if(!empty($this->request->data['PatientOrder']['urinary_catherer_insertion']))
				{
					$sentenceimplode.=", ".$this->request->data['PatientOrder']['urinary_catherer_insertion'];

				}

				if(!empty($this->request->data['PatientOrder']['prn']))
				{
					$prnvalue="PRN";
					$sentenceimplode.=", ".$prnvalue;

				}

					
			}

			//debug($sentenceimplode);
			$mdDateOther=date('Y-m-d H:i:s');
			$this->PatientOrder->updateAll(array('PatientOrder.sentence'=>"'$sentenceimplode'",'PatientOrder.status'=>"'Ordered'",'PatientOrder.modified_time'=>"'$mdDateOther'"),array('PatientOrder.id'=>$this->request->data['PatientOrder']['patient_order_id']));
			if(trim($dbStatus)=='save'){
				$this->Session->setFlash(__('Order Successfully Signed', true),true,array('class'=>'message'));
				$this->redirect(array('action'=>'orders',$this->request->data['PatientOrder']['patient_id']));
			}
			else{
				$this->Session->setFlash(__(' Order Updated and Signed Successfully', true),true,array('class'=>'message'));
				$this->redirect(array('action'=>'orders',$this->request->data['PatientOrder']['patient_id']));
			}


		}


	}
	public function AddNewOrderSet($specimen_type_id=null,$collection_priority=null,$frequency_l=null,$allData=null){
		$this->layout = false;
		$this->uses=array('OrderSentence');
		$alldata=explode('~~',$this->request->data['OrderSentence']['allData']);
		$code=$alldata['4'];
		if($alldata['1']=='34'){
			$type='lab';
			$specimenTypeId=$this->request->data['OrderSentence']['specimen_type_id'];
			$collectionPriority=$this->request->data['OrderSentence']['collection_priority'];
			$frequency=$this->request->data['OrderSentence']['frequency_l'];
			$newSentence='';
			if(!empty($specimenTypeId)){
				$newSentence.=$specimenTypeId.", ";
			}
			if(!empty($collectionPriority)){
				$newSentence.=$collectionPriority.", ";
			}
			if(!empty($frequency)){
				$newSentence.=$frequency;
			}
			$newSentence=trim($newSentence);
			$cnd=substr($newSentence,-1);
			if($cnd==',')
			{
				$newSentence=rtrim($newSentence,',');
			}

			/* $newSentence=$this->request->data['OrderSentence']['specimen_type_id'].",".$this->request->data['OrderSentence']['collection_priority'].", ".
			 $this->request->data['OrderSentence']['frequency_l'].",".$this->request->data['OrderSentence']['startDate']; */

			$this->OrderSentence->save(array('sentence'=>$newSentence,'type'=>$type,'code'=>$code,'status'=>'1'));
		}
		else if($alldata['1']=='33'){
			// 1 GM INJ., INJECT INTRAMUSCULAR, TWICE A DAY, first dose : 09/12/2014 13:06:08, intake: Enteral
			$type='med';
			$dose=$this->request->data['OrderSentence']['dose_name']." ".$this->request->data['OrderSentence']['Form_name']." ".$this->request->data['OrderSentence']['DosageForm_name'];
			$route=$this->request->data['OrderSentence']['route_name'];
			$frequency=$this->request->data['OrderSentence']['Fre_name'];
			//$firstDose = "first dose :  ";
			$review_id=$this->request->data['OrderSentence']['intake'];
			$newSentence='';
			if(!empty($dose)){
				$newSentence.=$dose.", ";
			}
			if(!empty($route)){
				$newSentence.=$route.", ";
			}
			if(!empty($frequency)){
				$newSentence.=$frequency.", ";
			}
			/*if(!empty($firstDose)){
				$newSentence.=$firstDose.", ";
			}*/
			if(!empty($review_id)){
				$newSentence.="Intake: ".$this->request->data['OrderSentence']['intake_name'];
			}
			$newSentence=trim($newSentence);
			$cnd=substr($newSentence,-1);
			if($cnd==',')
			{
				$newSentence=rtrim($newSentence,',');
			}
			/* $newSentence=$this->request->data['OrderSentence']['dose']." ".$this->request->data['OrderSentence']['strength'].", ".$this->request->data['OrderSentence']['route']
			 .", ".$this->request->data['OrderSentence']['frequency']; */

			$this->OrderSentence->save(array('sentence'=>$newSentence,'review_id'=>$review_id,'type'=>$type,'code'=>$code,'status'=>'1'));

		}
		else if($alldata['1']=='36'){
			$type='rad';
			$startDate="Requested Date : ".$this->request->data['RadiologyTestOrder']['Start_date'];
			$collectionPriority=$this->request->data['RadiologyTestOrder']['collection_priority'];
			$reasonExam="Reason for exam : ".$this->request->data['RadiologyTestOrder']['reason_exam'];
			$newSentence='';
			if(!empty($this->request->data['RadiologyTestOrder']['Start_date'])){
				$newSentence.=$startDate.", ";
			}
			if(!empty($this->request->data['RadiologyTestOrder']['collection_priority'])){
				$newSentence.=$collectionPriority.", ";
			}
			if(!empty($this->request->data['RadiologyTestOrder']['reason_exam'])){
				$newSentence.=$reasonExam;
			}
			$newSentence=trim($newSentence);
			$cnd=substr($newSentence,-1);
			if($cnd==',')
			{
				$newSentence=rtrim($newSentence,',');
			}
			$this->OrderSentence->save(array('sentence'=>$newSentence,'type'=>$type,'code'=>$code,'status'=>'1'));

		}
		exit;

	}


	public function moreInteractionData(){

	}

	function check_druginteraction($id=null,$proposed_medication=null,$current_medication=null)
	{
		$this->uses=array('Patient');
		$this->Patient->drugdruginteracton($id,$proposed_medication,$current_medication);
	}

	function getFancyBox($patientId = 36){
		$this->set('patientId',$patientId);
	}

/*	function getPackage($patientId=null,$patientOrderEnc=null){
		//$this->getAssociations();
		$this->uses = array('OrderCategory','Location','Laboratory','Radiology','PharmacyItem');
		$this->layout = false;
		$orderCategories = $this->OrderCategory->find('all',array('fields' => array('OrderCategory.order_description','OrderCategory.order_alias'),
				'conditions' => array('OrderCategory.folder_category_id' => '0','OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $this->Session->read('locationid'))));
		$locations = $this->Location->find('list',array('fields'=>array('id','name'),array('conditions'=>array('is_deleted' => '0','is_active'=>'1'))));
		//pr($orderCategories);exit;
		//for laboratory

		$labData=$this->Laboratory->find('all',array('fields' => array('id','name','lonic_code'),
				'conditions' => array('Laboratory.common' => '1','Laboratory.is_deleted' => '0'),'order'=>array('Laboratory.name')));
		$this->set('labData', $labData);
		//debug($labData);

		//for radiology

		$radData=$this->Radiology->find('all',array('fields' => array('id','name','cpt_code'),
				'conditions' => array('Radiology.common' => '1','Radiology.is_deleted' => '0'),'order'=>array('Radiology.name')));
		$this->set('radData', $radData);

		//for medication

		$medData=$this->PharmacyItem->find('all',array('fields' => array('id','name','code','rxcui'),
				'conditions' => array('PharmacyItem.common' => '1','PharmacyItem.is_deleted' => '0'),'group'=>array('PharmacyItem.name')));
		$this->set('medData', $medData);
		//debug($medData);
		$this->set('patientOrderEnc',$patientOrderEnc);
		$this->set('patientId',$patientId);
		$this->set('orderCategories',$orderCategories);
		$this->set('locations',$locations);
		$this->set('currentLocation',$this->Session->read('locationid'));
		$this->Session->write('patientId',$patientId);

		$this->set('laboratory_category_id',Configure::read('Laboratory_Category_id'));
		$this->set('radiology_category_id',Configure::read('Radiology_Category_id'));
		$this->set('medication_category_id',Configure::read('Medication_Category_id'));

	}*/
	function getPackage($patientId=null,$type=null){
		//$this->getAssociations();
		$this->uses = array('OrderCategory','Location','Laboratory','Radiology','PharmacyItem','Patient');
	
		$patientDetails = $this->Patient->usPatientHeader($patientId);//For Patient header
		$this->set('patientDetails',$patientDetails);
	
		$this->layout = false;
		$orderCategories = $this->OrderCategory->find('all',array('fields' => array('OrderCategory.order_description','OrderCategory.order_alias'),
				'conditions' => array('OrderCategory.folder_category_id' => '0','OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $this->Session->read('locationid'))));
		$locations = $this->Location->find('list',array('fields'=>array('id','name'),array('conditions'=>array('is_deleted' => '0','is_active'=>'1'))));
		$this->set('patientId',$patientId);
		$this->set('orderCategories',$orderCategories);
		$this->set('locations',$locations);
		$this->set('currentLocation',$this->Session->read('locationid'));
		$this->Session->write('patientId',$patientId);
	
		$this->set('type',$type);
		$this->set('laboratory_category_id',Configure::read('Laboratory_Category_id'));
		$this->set('radiology_category_id',Configure::read('Radiology_Category_id'));
		$this->set('medication_category_id',Configure::read('Medication_Category_id'));
	
	}

	public function getCustomOrderSet($patientId,$type=null,$locationId=null){
		$this->uses = array('OrderCategory','PharmacyItem','Radiology','Laboratory');
		$this->layout = false;
		if($type == 'none' || $type == 'All'){
			$type = '';
		}
		if(empty($locationId)){

			$locationId = $this->Session->read('locationid');

		}
		if(!empty($type)){
			if(strtolower($type) == 'home'){
				$conditions = array('OrderCategory.folder_category_id' => '0','OrderCategory.user_id = 0','OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
				$labData=$this->Laboratory->find('all',array('fields' => array('id','name','lonic_code'),
						'conditions' => array('Laboratory.common' => '1','Laboratory.is_deleted' => '0'),'order'=>array('Laboratory.name')));
				$this->set('labData', $labData);
				//debug($labData);

				//for radiology

				$radData=$this->Radiology->find('all',array('fields' => array('id','name','cpt_code'),
						'conditions' => array('Radiology.common' => '1','Radiology.is_deleted' => '0'),'order'=>array('Radiology.name')));
				$this->set('radData', $radData);

				//for medication

				$medData=$this->PharmacyItem->find('all',array('fields' => array('id','name','code','rxcui'),
						'conditions' => array('PharmacyItem.common' => '1','PharmacyItem.is_deleted' => '0'),'group'=>array('PharmacyItem.name')));
				$this->set('medData', $medData);
			}
			if(strtolower($type) == 'favourite'){
				$conditions = array('OrderCategory.folder_category_id' => '1','OrderCategory.user_id'=>$this->Session->read('userid'),'OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
				$labData=$this->Laboratory->find('all',array('fields' => array('id','name','lonic_code'),
						'conditions' => array('Laboratory.favourite' => '1','Laboratory.is_deleted' => '0'),'order'=>array('Laboratory.name')));
				$this->set('labData', $labData);
				//debug($labData);

				//for radiology

				$radData=$this->Radiology->find('all',array('fields' => array('id','name','cpt_code'),
						'conditions' => array('Radiology.favourite' => '1','Radiology.is_deleted' => '0'),'order'=>array('Radiology.name')));
				$this->set('radData', $radData);

				//for medication

				$medData=$this->PharmacyItem->find('all',array('fields' => array('id','name','code','rxcui'),
						'conditions' => array('PharmacyItem.favourite' => '1','PharmacyItem.is_deleted' => '0'),'group'=>array('PharmacyItem.name')));
				$this->set('medData', $medData);

			}
			if(strtolower($type) == 'common'){
				$conditions = array('OrderCategory.common'=>'1','OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
				/*$this->OrdersetFolder->bindModel(array(
				 'hasMany'=>array('Laboratory'=>array('foreignKey'=>'orderset_folder_id')),
						'hasMany'=>array('Radiology'=>array('foreignKey'=>'orderset_folder_id')),
						'hasMany'=>array('PharmacyItem'=>array('foreignKey'=>'orderset_folder_id')),
				));*/
			}

		}else{
			$conditions = array('OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
		}
		$orderCategories = $this->OrderCategory->find('all',array('fields' => array('OrderCategory.order_description','OrderCategory.order_alias'),
				'conditions' => $conditions));
		//debug($orderCategories);exit;
		//pr($orderCategories);exit;
		$this->set('orderCategories',$orderCategories);
		$this->render('get_custom_order_set');
	}

	public function serachOrderSet($searchCode,$lastClickedFolder,$type=null,$locationId=null){
		$this->uses = array('Laboratory','Radiology','PharmacyItem','OrderDataMaster','OrderCategory','OrdersetMaster','MultipleOrderSet','MultipleLabMaster');
		$this->layout = 'advance_ajax';
		$type = $this->params->query['like'];
		if(!empty($type)){
			if($type == '1'){
				$like = "%";
			}else if($type == '2'){
				$like = '';
			}
		}else{
			$like = '';
		}
		$locationId = $this->params->query['location'];
		if(empty($locationId)){
			$locationId = $this->Session->read('locationid');
		}

		$searchCode = trim($this->params->query['q']);
		$searchCode = strtolower($searchCode);
		$lastClickedFolder = $this->params->query['lastClickedFolder'];
		if($lastClickedFolder == 'none' || $lastClickedFolder == 'All'){

			$lastClickedFolder = '';

		}
		$searchCode = $this->MultipleOrderSet->matchSearchKeys($searchCode,$like);
		if(!empty($lastClickedFolder)){
			if(strtolower($lastClickedFolder) == 'home'){
				$conditions = array('OrderCategory.folder_category_id' => '0','OrderCategory.common'=>'1','OrderCategory.user_id != 0','OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
			}
			if(strtolower($lastClickedFolder) == 'favourite'){
				$conditions = array('OrderCategory.favourite'=>'1','OrderCategory.user_id'=>$this->Session->read('userid'),'OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
			}
			if(strtolower($lastClickedFolder) == 'common'){
				$conditions = array('OrderCategory.home'=>'1','OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $locationId);
			}
			$this->OrderCategory->unbindModel(array('hasMany'=>array('OrderDataMaster')));
			$orderCategories = $this->OrderCategory->find('list',array('fields' => array('OrderCategory.order_description','OrderCategory.id'),
					'conditions' => $conditions));
			/*$this->OrderDataMaster->bindModel(array(
					'belongsTo'=>array('OrderCategory'=>array('foreignKey'=>'order_category_id')),
			));
			$orderDataMaster = $this->OrderDataMaster->find('all',array('fields' => array('OrderCategory.id','OrderDataMaster.name','OrderCategory.order_description','OrderDataMaster.id','OrderCategory.order_alias'),
					'conditions' => array('OrderDataMaster.order_category_id' => $orderCategories,$searchCode)));*/


			foreach ($orderDataMaster as $key=>$value) {

				echo $value['OrderDataMaster']['name']."    ".$value['OrderCategory']['id'].$value['OrderCategory']['order_description']."|".$value['OrderDataMaster']['id'].$value['OrderCategory']['order_alias']."\n";
			}

			$labData = $this->Laboratory->find('all',array('fields'=>array('Laboratory.id','Laboratory.name'),
					'conditions' => array($searchCode,'Laboratory.location_id' => $locationId,'Laboratory.common' => '1'),'limit' => Configure::read('order_set_number_of_rows')));
			$radData = $this->Radiology->find('all',array('fields'=>array('Radiology.id','Radiology.name'),
					'conditions' => array($searchCode,'Radiology.location_id' => $locationId,'Radiology.common' => '1'),'limit' => Configure::read('order_set_number_of_rows')));
			$drugData = $this->PharmacyItem->find('all',array('fields'=>array('PharmacyItem.id','PharmacyItem.name'),
					'conditions' => array($searchCode,'PharmacyItem.location_id' => $locationId,'PharmacyItem.common' => '1'),'limit' => Configure::read('order_set_number_of_rows')));
			//$MultilabData = $this->MultipleLabMaster->find('all',array('fields'=>array('MultipleLabMaster.id','MultipleLabMaster.title'),'limit' => Configure::read('order_set_number_of_rows')));

			foreach ($orderSetMaster as $key=>$value) {
					
				echo "Multiple - ".$value['OrdersetMaster']['name']."    ".$value['OrdersetMaster']['id']."####".$value['OrdersetMaster']['id']."|Multiple\n";
			}

			if(strtolower($lastClickedFolder) == 'home'){
				foreach ($orderDataMaster as $key=>$value) {

					echo $value['OrderDataMaster']['name']."    ".$value['OrderCategory']['id'].$value['OrderCategory']['order_description']."|".$value['OrderDataMaster']['id'].$value['OrderCategory']['order_alias']."\n";
				}

				foreach ($radData as $key=>$value) {

					echo $value['Radiology']['name']."    ".$value['Radiology']['id']."####".$orderCategories['rad']."|Radiology\n";

				}

				foreach ($labData as $key=>$value) {

					echo $value['Laboratory']['name']."    ".$value['Laboratory']['id']."####".$orderCategories['lab']."|Laboratory\n";

				}

				foreach ($drugData as $key=>$value) {

					echo $value['PharmacyItem']['name']."    ".$value['PharmacyItem']['id']."####".$orderCategories['med']."|PharmacyItem\n";

				}
				foreach ($MultilabData as $key=>$value) {

					echo $value['MultipleLabMaster']['title']."    ".$value['MultipleLabMaster']['id']."####".$orderCategories['mul']."|MultipleLabMaster\n";

				}
			}

		}else{
			//$conditions = array('OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $this->Session->read('locationid'));
			$this->OrderCategory->unbindModel(array('hasMany'=>array('OrderDataMaster')));

			$orderCategories = $this->OrderCategory->find('list',array('fields' => array('OrderCategory.order_alias','OrderCategory.id'),

			));
			//pr($orderCategories);exit;
			$labData = $this->Laboratory->find('all',array('fields'=>array('Laboratory.id','Laboratory.name'),'conditions' => array($searchCode,'Laboratory.location_id' => $locationId),'limit' => Configure::read('order_set_number_of_rows')));
			$radData = $this->Radiology->find('all',array('fields'=>array('Radiology.id','Radiology.name'),'conditions' => array($searchCode,'Radiology.location_id' => $locationId),'limit' => Configure::read('order_set_number_of_rows')));
			$drugData = $this->PharmacyItem->find('all',array('fields'=>array('PharmacyItem.id','PharmacyItem.name'),'conditions' => array($searchCode,'PharmacyItem.location_id' => $locationId),'limit' => Configure::read('order_set_number_of_rows')));
			//$MultilabData = $this->MultipleLabMaster->find('all',array('fields'=>array('MultipleLabMaster.id','MultipleLabMaster.title'),'limit' => Configure::read('order_set_number_of_rows')));
			$this->OrderDataMaster->bindModel(array(
					'belongsTo'=>array('OrderCategory'=>array('foreignKey'=>'order_category_id')),
			));

			/*$orderDataMaster = $this->OrderDataMaster->find('all',array('fields' => array('OrderCategory.id','OrderDataMaster.name','OrderCategory.order_description','OrderDataMaster.id','OrderCategory.order_alias'),
					'conditions' => array('OrderDataMaster.order_category_id' => $orderCategories,$searchCode)));*/

			$orderSetMaster = $this->OrdersetMaster->find('all',array('fields' => array('OrdersetMaster.id','OrdersetMaster.name'),
					'conditions' => array($searchCode)));
			//debug($orderSetMaster);
			foreach ($orderSetMaster as $key=>$value) {

				echo "Multiple - ".$value['OrdersetMaster']['name']."    ".$value['OrdersetMaster']['id']."####".$value['OrdersetMaster']['id']."|Multiple\n";
			}


			foreach ($orderDataMaster as $key=>$value) {
					
				echo $value['OrderDataMaster']['name']."    ".$value['OrderCategory']['id'].$value['OrderCategory']['order_description']."|".$value['OrderDataMaster']['id'].$value['OrderCategory']['order_alias']."\n";
			}

			foreach ($radData as $key=>$value) {
					
				echo $value['Radiology']['name']."    ".$value['Radiology']['id']."####".$orderCategories['rad']."|Radiology\n";
					
			}

			foreach ($labData as $key=>$value) {

				echo $value['Laboratory']['name']."    ".$value['Laboratory']['id']."####".$orderCategories['lab']."|Laboratory\n";
					
			}

			foreach ($drugData as $key=>$value) {
					
				echo $value['PharmacyItem']['name']."    ".$value['PharmacyItem']['id']."####".$orderCategories['med']."|PharmacyItem\n";

			}
			foreach ($MultilabData as $key=>$value) {
					
				echo $value['MultipleLabMaster']['title']."    ".$value['MultipleLabMaster']['id']."####".$orderCategories['mul']."|MultipleLabMaster\n";
					
			}
		}
		exit;
	}

	public function getOrderSentence($searchCode){
		$this->layout = false;
		$this->uses = array('OrderSentence');
		$orderSentences = $this->OrderSentence->getOrderSentence($searchCode);
		if($this->request['isAjax']){
			echo json_encode(array('count'=> count($orderSentences),'orderSentences' =>$orderSentences));
			exit;
		}else{
			return $orderSentences;
		}
	}

	function selectOrderSentence($searchCode){
		$this->layout = false;
		$orderSentences = $this->getOrderSentence($searchCode);
		$this->set('orderSentences',$orderSentences);
	}

	function saveOrderSentence(){
		pr($this->request->data);exit;
	}

	public function getAssociations(){
		$this->uses = array('OrderCategory','MemcacheInstance');
		$orderCategories = $this->OrderCategory->find('all',array('fields' => array('OrderCategory.order_description'),
				'conditions' => array('OrderCategory.status' => '1','OrderCategory.is_deleted' => '0','OrderCategory.location_id' => $this->Session->read('locationid'))));

		//pr(unserialize($OrderCategories));exit;
		$this->set('orderCategories',array('count'=> count($orderCategories),'orderCategories' =>$orderCategories));
	}

	public function reloadAllMaster(){
		$this->uses = array('MemcacheInstance');
		$this->loadModel('MemcacheInstance');
		$this->MemcacheInstance->reloadAllMaster();
		$this->MemcacheInstance->getOrderSetData();
	}

	public function labAddMaster(){
		$this->uses=array('MultipleLabMaster');
		$this->layout = false;
		if(!empty($this->request->data))
		{
			//$this->request->data['MultipleLabMaster']['patient_id'] = $patient_id;
			$this->request->data['MultipleLabMaster']['title'] = $this->request->data['tile'];
			$this->request->data['MultipleLabMaster']['name'] = serialize($this->request->data['nameLab']); //serializing the data's
			$success = $this->MultipleLabMaster->insertdata($this->request->data);
		}

	}

	public function ajaxaddordermultiplesnew(){

		$this->layout = "ajax";
		$this->loadModel('MultipleLabMaster');
		/**  To get All the added master records Amit**/
		$this->set('multiorderlab',$this->MultipleLabMaster->find('all',array('fields'=>array('id','title','name'),'conditions'=> array('is_deleted'=> '0'))));
		echo $this->render('ajaxaddordermultiplesnew');
		exit;
		/** EOD**/
	}

	public function delete_lab_master_item($id = null) {

		$this->uses=array('MultipleLabMaster');
		$this->set('title_for_layout', __('- Delete MultipleLabMaster', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Multiple Lab'),'default',array('class'=>'error'));
			$this->redirect(array('action'=>'labAddMaster'));
		}
		$updatearray=array('MultipleLabMaster.is_deleted'=>'1');
		if ($this->MultipleLabMaster->updateAll($updatearray,array('MultipleLabMaster.id'=>$id))) {
			$this->Session->setFlash(__('Multiple Lab successfully deleted'),'default',array('class'=>'message'));
			$this->redirect(array('action'=>'labAddMaster'));
		}
	}
/*	public function sendTo($patient){
		$this->uses=array('Note','PatientOrderEncounter');
		$this->autoRender=false;
		$this->Note->bindModel(array(
				'belongsTo'=>array(
						'PatientOrderEncounter'=>array('foreignKey'=>false,'conditions'=>array("PatientOrderEncounter.note_id=Note.id"))
				)));
		$getid=$this->Note->find('first',array('conditions'=>array('Note.patient_id'=>$patient,'Note.compelete_note'=>0),'fields'=>array('Note.id','PatientOrderEncounter.id'),'order'=>array('PatientOrderEncounter.id'=>'DESC')));
		
		if(empty($getid)){
			$data = array('patient_id'=>$patient,'create_time'=>date('Y-m-d H:i:s')) ;
			$this->Note->save($data);
			$noteId=$this->Note->getLastInsertID();
			$this->redirect("/MultipleOrderSets/orders/".$patient."/?Preview=preview&noteId=".$noteId);
		}
		else{
			$this->redirect("/MultipleOrderSets/orders/".$patient."/null/".$getid['PatientOrderEncounter']['id']."?Preview=preview&noteId=".$getid['Note']['id']);
		}

	}
	*/
	public function sendTo($patient){
		$this->uses=array('Note');
		$this->autoRender=false;
		$getid=$this->Note->find('first',array('conditions'=>array('Note.patient_id'=>$patient,'Note.compelete_note'=>0),'fields'=>array('id')));
		if(empty($getid)){
			if(strtolower($this->params->query['type'])=='ipd'){
				$data = array('patient_id'=>$patient,'note_date'=>date('Y-m-d')) ;
				$this->Note->save($data);
				$noteId=$this->Note->getLastInsertID();
				$this->redirect("/MultipleOrderSets/ipdClinicalNotes/".$patient."/".$noteId."#setFocus");
			}else{
				$data = array('patient_id'=>$patient,'note_date'=>date('Y-m-d')) ;
				$this->Note->save($data);
				$noteId=$this->Note->getLastInsertID();
				$this->redirect("/MultipleOrderSets/orders/".$patient."/?Preview=preview&noteId=".$noteId);
			}
		}
		else{
			if(strtolower($this->params->query['type'])=='ipd'){
				$this->redirect("/MultipleOrderSets/ipdClinicalNotes/".$patient."/".$getid['Note']['id']."#setFocus");
			}else{
				$this->redirect("/MultipleOrderSets/orders/".$patient."/?Preview=preview&noteId=".$getid['Note']['id']);
			}
		}
	
	}
	public function orderList($patientId){
		$this->layout = 'advance_ajax' ;
		$this->uses=array('PatientOrder');
		$getList=$this->PatientOrder->encounterOrder($patientId);
		$this->set('getList',$getList);
	}
	
	public function ipdClinicalNotes($id,$noteID){
		$this->layout="advance_ajax";
		$this->uses= array('Patient','ServiceCategory','OrderCategory','PatientOrder','OrderSubcategory','OrdersetMaster','OrdersetSubcategoryMapping','User','OrderSentence','Note','NoteDiagnosis');
	
		$this->set('patientID',$id);
		$this->set('noteID',$noteID);
		$configInstance=$this->Session->read('website.instance');
		
		$this->Patient->unBindModel(array(
				'hasMany' => array('PharmacySalesBill','InventoryPharmacySalesReturn')));
	
		$this->Patient->bindModel(array(
				'belongsTo' => array(
						'Person' =>array('foreignKey' => false,'type'=>'INNER','conditions'=>array('Person.id=Patient.person_id')),
				)));
		$admission_type=$this->Patient->find('first',array('conditions'=>array('Patient.id'=>$id),
				'fields'=>array('Patient.admission_type','Patient.lookup_name','Person.dob','Person.sex','Patient.admission_id','Person.patient_uid','Patient.person_id')));
	
		$noteData=$this->Note->find('all',array('conditions'=>array('Note.patient_id'=>$id,'Note.note_type'=>''),
				'fields'=>array('Note.cc','Note.id','Note.note_date'),'order'=>array('id DESC')));
	
		if(date('Y-m-d',strtotime($noteData['0']['Note']['note_date']))==date('Y-m-d')){
			$currentDayNotes['id']=$noteData['0']['Note']['id'];
			$currentDayNotes['cc']=$noteData['0']['Note']['cc'];
			$this->set('currentDayNotes',$currentDayNotes);
		}else{
	
		}
		$this->set('noteData',$noteData);
		$this->set("admission_type",$admission_type);
	
		$this->patient_info($id);
		if(!empty($this->params->query['noteId'])){
			$this->Session->write('noteId',$this->params->query['noteId']);
		}
		$getOrderData=$this->OrderCategory->find('all',array('fields'=>array('id','order_description'),'conditions'=>array('OrderCategory.status'=>'1','OrderCategory.folder_category_id'=>'0')));
		$this->set('getOrderData',$getOrderData);
		$this->set('patient_id',$id);
	
		/** To get All the srevice -Aditya **/
		$this->ServiceCategory->unBindModel(array('hasMany' => array('ServiceSubCategory')));//as we dont need services sub groups  --yashwant
		$service_group = $this->ServiceCategory->find("all",array(
				"conditions"=>array("ServiceCategory.is_deleted"=>0,"ServiceCategory.is_view"=>1,
						"ServiceCategory.service_type"=>array($admission_type['Patient']['admission_type'],'Both'),
						"ServiceCategory.location_id"=>array($this->Session->read('locationid'),'0')),));
		$this->set("service_group",$service_group);
		/** To get All the srevice -EOD**/
	
		/** To get PatientData For services -Aditya**/
		$patientDataForService=$this->Patient->find('first',
				array('fields'=>array('doctor_id','admission_type','id','tariff_standard_id','discharge_date','person_id','clearance'),'conditions'=>array('id'=>$id)));
		$this->set("patient",$patientDataForService);
		/** To get PatientData For services-EOD**/
		//----------------------Display Added Records----------------------------------------
		$this->OrderCategory->bindModel(array(
				'hasMany' => array(
						'PatientOrder' =>array('foreignKey' => 'order_category_id','conditions'=>array('PatientOrder.patient_id'=>$id),
								'order'=>array('PatientOrder.modified_time DESC')))),false);
		$this->OrdersetMaster->bindModel(array(
				'hasMany'=>array(
						'OrdersetCategoryMapping'=>array('foreignKey'=>'orderset_master_id'))));
		$data = $this->OrdersetMaster->find('all',array('conditions'=>array('OrdersetMaster.id'=>'1')));
		$i=0 ;
		foreach($data as $key => $value){
			if(!empty($value['OrdersetCategoryMapping'])){
				foreach($value['OrdersetCategoryMapping'] as $subKey =>$subValue){
					$customArray[$value['OrdersetCategoryMapping']['name']][$subValue['id']]  = $subValue['name'] ;
					$ids[] = $subValue['id'] ;
				}
			}else{
				$customArray[$value['ReviewCategory']['name']]   = $value['ReviewCategory']['name']; //only main category
			}
		}
		$getTotalData=$this->OrderCategory->find('all',array('conditions'=>array('OrderCategory.status'=>'1','OrderCategory.folder_category_id'=>'0')));//,array('conditions'=>array()));'OrderCategory.id=PatientOrder.order_category_id',
		$getCountOfOrders=$this->PatientOrder->find('count',array('conditions'=>array('PatientOrder.patient_id'=>$id,'note_id'=>$_SESSION['noteId'])));
	
		//for checking left side checkbox
		if($updateStatus=='1'){
			$this->Session->setFlash(__('Order Successfully Saved', true),true,array('class'=>'message'));
		}
		if($updateStatus=='2'){
			$this->Session->setFlash(__('Order Successfully Update', true),true,array('class'=>'message'));
		}
		//debug($getTotalData);
		$this->set('setdata',$getTotalData);
		$this->set('setCount',$getCountOfOrders);
	
		$allViewData=$this->viewAll($id);
		$this->set('allViewData',$allViewData);
	
	}
	

	public function preOtNotes($patientid,$noteID){
		$this->layout="ajax";
		$this->uses = array('User', 'Consultant', 'Note', 'Surgery','OptAppointment');
		$this->set('title_for_layout', __('Pre Operative Notes', true));
			
		// Surgery list
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	
		// Load Doctor and Anas...
		$optData=$this->OptAppointment->find('first',array('conditions'=>array('OptAppointment.patient_id'=>$patientid)));
	
		$this->set('surgeon',$this->User->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as name','User.id'),'conditions'=>array('User.id'=>$optData['OptAppointment']['doctor_id']))));
	
		$this->set('ansth',$this->User->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as name','User.id'),'conditions'=>array('User.id'=>$optData['OptAppointment']['department_id']))));
			
		$this->set('patient_id',$patientid);
	
		// get notes details
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
				'Surgery' =>array('foreignKey'=>false, 'conditions'=> array('Surgery.id=Note.surgery_id')),
		)),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Note.id' => 'desc'),
				'fields'=> array('Note.id', 'Note.pre_opt', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.create_time', 'Note.pre_opt', 'Surgery.name', 'CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'),
				'conditions'=>array('Note.patient_id'=>$patientid,'Note.note_type ='=>'pre-operative')
		);
		$data = $this->paginate('Note');
		$this->set('data',$data);
			
		echo $this->render("pre_ot_notes");
	
		exit;
	}
	
	public function postOptNotes($patientid,$noteID){
		$this->layout="ajax";
		$this->uses = array('User', 'Consultant', 'Note', 'Surgery','OptAppointment');
		$this->set('title_for_layout', __('Post Operative Notes', true));
			
		// Surgery list
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	
		// Load Doctor and Anas...
		$optData=$this->OptAppointment->find('first',array('conditions'=>array('OptAppointment.patient_id'=>$patientid)));
	
		$this->set('surgeon',$this->User->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as name','User.id'),'conditions'=>array('User.id'=>$optData['OptAppointment']['doctor_id']))));
	
		$this->set('ansth',$this->User->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as name','User.id'),'conditions'=>array('User.id'=>$optData['OptAppointment']['department_id']))));
			
		$this->set('patient_id',$patientid);
	
		// get notes details
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
				'Surgery' =>array('foreignKey'=>false, 'conditions'=> array('Surgery.id=Note.surgery_id')),
		)),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Note.id' => 'desc'),
				'fields'=> array('Note.id', 'Note.post_opt', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.create_time', 'Note.pre_opt', 'Surgery.name', 'CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'),
				'conditions'=>array('Note.patient_id'=>$patientid,'Note.note_type ='=>'post-operative')
		);
		$data = $this->paginate('Note');
		$this->set('data',$data);
			
		echo $this->render("post_opt_notes");
	
		exit;
	}
	
	public function sugOptNotes($patientid,$noteID){
		$this->layout="ajax";
		$this->uses = array('User', 'Consultant', 'Note', 'Surgery','OptAppointment');
		$this->set('title_for_layout', __('Post Operative Notes', true));
			
		// Surgery list
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	
		// Load Doctor and Anas...
		$optData=$this->OptAppointment->find('first',array('conditions'=>array('OptAppointment.patient_id'=>$patientid)));
	
		$this->set('surgeon',$this->User->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as name','User.id'),'conditions'=>array('User.id'=>$optData['OptAppointment']['doctor_id']))));
	
		$this->set('ansth',$this->User->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as name','User.id'),'conditions'=>array('User.id'=>$optData['OptAppointment']['department_id']))));
			
		$this->set('patient_id',$patientid);
	
		// get notes details
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
				'Surgery' =>array('foreignKey'=>false, 'conditions'=> array('Surgery.id=Note.surgery_id')),
		)),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Note.id' => 'desc'),
				'fields'=> array('Note.id', 'Note.implants', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.create_time', 'Surgery.name', 'CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'),
				'conditions'=>array('Note.patient_id'=>$patientid,'Note.note_type ='=>'sug-operative')
		);
		$data = $this->paginate('Note');
		$this->set('data',$data);
			
		echo $this->render("sug_opt_notes");
	
		exit;
	}
	
	public function anesthesiaOptNotes($patientid,$noteID){
		$this->layout="ajax";
		$this->uses = array('User', 'Consultant', 'Note', 'Surgery','OptAppointment');
		$this->set('title_for_layout', __('Post Operative Notes', true));
			
		// Surgery list
		$this->Surgery->bindModel(array('hasOne' => array('OptAppointment' =>array('foreignKey' => 'surgery_id'))));
		$this->set('surgeries', $this->Surgery->find('list', array('conditions' => array('Surgery.location_id' => $this->Session->read('locationid'), 'Surgery.is_deleted' => 0, 'OptAppointment.patient_id' => $patientid), 'recursive' => 1)));
	
		// Load Doctor and Anas...
		$optData=$this->OptAppointment->find('first',array('conditions'=>array('OptAppointment.patient_id'=>$patientid)));
	
		$this->set('surgeon',$this->User->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as name','User.id'),'conditions'=>array('User.id'=>$optData['OptAppointment']['doctor_id']))));
	
		$this->set('ansth',$this->User->find('first',array('fields'=>array('CONCAT(User.first_name, " ", User.last_name) as name','User.id'),'conditions'=>array('User.id'=>$optData['OptAppointment']['department_id']))));
			
		$this->set('patient_id',$patientid);
	
		// get notes details
		$this->Note->bindModel(array('belongsTo' => array(
				'Patient' =>array('foreignKey'=>'patient_id'),
				'User' =>array('foreignKey'=>'sb_registrar'),
				'Doctor' =>array('foreignKey'=>'sb_consultant'),
				'Surgery' =>array('foreignKey'=>false, 'conditions'=> array('Surgery.id=Note.surgery_id')),
		)),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Note.id' => 'desc'),
				'fields'=> array('Note.id', 'Note.anaesthesia_note', 'Note.note_type', 'Note.created_by', 'Note.note_date', 'Note.create_time', 'Note.anaesthesia_note', 'Surgery.name', 'CONCAT(User.first_name, " ", User.last_name) as doctor_name','CONCAT(Doctor.first_name, " ", Doctor.last_name) as registrar'),
				'conditions'=>array('Note.patient_id'=>$patientid,'Note.note_type ='=>'anaesthesia-operativ')
		);
		$data = $this->paginate('Note');
		$this->set('data',$data);
			
		echo $this->render("anesthesia_opt_notes");
	
		exit;
	}
	public function viewAll($patientid){
		/*$this->layout="ajax";*/
		$this->uses = array('Patient','NewCropPrescription','NoteDiagnosis','RadiologyTestOrder','LaboratoryTestOrder','NewCropAllergies','Diagnosis','BmiResult','BmiBpResult');
	
		$allDataMed=$this->NewCropPrescription->find('all',array(
				'fields'=>array('NewCropPrescription.id','NewCropPrescription.description','NewCropPrescription.created','NewCropPrescription.archive'),
				'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$patientid,'archive'=>'N')));
		//=======================================================================================================================
	
		$allDataAly=$this->NewCropAllergies->find('all',array(
				'fields'=>array('NewCropAllergies.id','NewCropAllergies.name','NewCropAllergies.AllergySeverityName','NewCropAllergies.created','NewCropAllergies.status'),'conditions'=>array('NewCropAllergies.patient_uniqueid'=>$patientid,'NewCropAllergies.status'=>'A'),'group'=>array('NewCropAllergies.id')));
	
		//=======================================================================================================================
		$this->LaboratoryTestOrder->bindModel(array('belongsTo' => array(
				'Laboratory' =>array('foreignKey'=>false,'conditions'=>array('Laboratory.id=LaboratoryTestOrder.laboratory_id')),
		)),false);
		$allDataLabs=$this->LaboratoryTestOrder->find('all',array(
				'fields'=>array('LaboratoryTestOrder.id','Laboratory.name','LaboratoryTestOrder.order_id','LaboratoryTestOrder.start_date'),'conditions'=>array('LaboratoryTestOrder.patient_id'=>$patientid)));
		//========================================================================================================================
		$this->RadiologyTestOrder->bindModel(array('belongsTo' => array(
				'Radiology' =>array('type'=>'INNER','foreignKey'=>false,'conditions'=>array('Radiology.id=RadiologyTestOrder.radiology_id')),
		)),false);
		$allDataRads=$this->RadiologyTestOrder->find('all',array(
				'fields'=>array('RadiologyTestOrder.id','Radiology.name','RadiologyTestOrder.order_id','RadiologyTestOrder.radiology_order_date','RadiologyTestOrder.start_date'),'conditions'=>array('RadiologyTestOrder.patient_id'=>$patientid),'group'=>array('order_id')));
	
		//==========================================================================================================================
		$problemDaigonis=$this->NoteDiagnosis->find('all',array('fields'=>array('diagnoses_name','disease_status','comment'),'conditions'=>array('patient_id'=>$patientid)));
	
		//==========================================================================================================================
		$this->BmiResult->bindModel(array(
				'belongsTo' => array('BmiBpResult'=>array('conditions'=>array('BmiBpResult.bmi_result_id=BmiResult.id'),'foreignKey'=>false)
				)));
		$vitalsResult = $this->BmiResult->find('first',array('fields'=>array('temperature','temperature1','temperature2','myoption','myoption1','myoption2','respiration','respiration_volume','BmiBpResult.systolic','BmiBpResult.systolic1',
				'BmiBpResult.systolic2','BmiBpResult.diastolic','BmiBpResult.diastolic1','BmiBpResult.diastolic2','BmiBpResult.pulse_text','BmiBpResult.pulse_text1','BmiBpResult.pulse_text2',
				'BmiBpResult.pulse_volume','BmiBpResult.pulse_volume1','BmiBpResult.pulse_volume2'),
				'conditions'=>array('patient_id'=>$patientid)));
	
		return array('med'=>$allDataMed,'allergy'=>$allDataAly,'labs'=>$allDataLabs,'rad'=>$allDataRads,'problem'=>$problemDaigonis,'vitalsResult'=>$vitalsResult);
	
	}
}
