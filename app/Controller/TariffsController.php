<?php
class TariffsController extends AppController {

	public $name = 'Tariffs';

	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General', 'JsFusionChart');
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat','QRCode','Session');

	public function index(){
		#Configure::write('debug',2);
	}

	public function addTariff(){
		$this->uses = array('TariffList','ServiceCategory','Account','Location');
		$data = $this->ServiceCategory->getServiceGroup();
		$dataAccount = $this->Account->find("list",array("conditions"=>array("Account.location_id=".$this->Session->read('locationid'))));
		$location = $this->Location->find("list",array("conditions"=>array('Location.is_deleted'=>'0')));
		$this->set(array('service_group_category'=>$data,'accountList'=>$dataAccount,'location'=>$location));
		if($this->request->data){
			// Check if Servise already exist.
			$old_data = $this->TariffList->find('count',array('conditions'=>array('TariffList.name'=>$this->request->data['TariffList']['name'],'TariffList.service_group'=>$this->request->data['TariffList']['service_group'],'TariffList.is_deleted'=>0,'TariffList.location_id'=>$this->Session->read('locationid'))));
			if($old_data < 1){ 
				$this->request->data['TariffList']['location_id']=$this->Session->read('locationid');
				$this->request->data['TariffList']['created_by']=$this->Session->read('userid');
				$this->request->data['TariffList']['create_time']=date('Y-m-d H:i:s');
				if($this->TariffList->save($this->request->data['TariffList'])){
					$lastTariffListId = $this->TariffList->getLastInsertID();
					$str = substr("000000",1,6-strlen($lastTariffListId));
					$serviceAccountCode=strtoupper(substr($dataAccount[$this->request->data['TariffList']['account_id']],0,3)).$str.$lastTariffListId;
					$this->TariffList->save(array('id'=>$lastTariffListId,'service_account_code'=>$serviceAccountCode));
					$this->Session->setFlash(__('Service has been created successfully!'),'default',array('class'=>'message'));
					$this->redirect(array("controller" => "Tariffs", "action" => "viewTariff"));
				} else {
					$this->Session->setFlash(__('Service can not be created! Please try again.'),'default',array('class'=>'error'));
					$this->redirect(array("controller" => "Tariffs", "action" => "viewTariff"));
				}
			} else {
				$this->Session->setFlash(__('Service already exist! Please try again.'),'default',array('class'=>'error'));
				$this->redirect(array("controller" => "Tariffs", "action" => "addTariff"));
			}

		}
		$servicegroup = array('general' => 'General', 'package'=> 'Package', 'nursing' => 'Nursing', 'OPD' => 'OPD', 'surgery' => 'Surgery','procedure'=>'Procedure','investigation'=>'Investigation','icu'=>'ICU',
				'consultant'=>'Consultant','anaesthesia'=>'Anaesthesia','other'=>'Other');
		$this->set('servicegroup', $servicegroup);
	}

	public function editTariff($id=''){
		$this->uses = array('TariffList','ServiceCategory','ServiceSubCategory','Location','TariffSentence','PackageSubCategory','PackageCategory','PackageSubSubCategory');
		$this->layout = 'advance';
		$data = $this->ServiceCategory->getServiceGroup();
		$this->set('service_group_category',$data);

		
		if($this->request->data){
			$packCntOne=$this->PackageCategory->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>$this->request->data['TariffList']['name'])));
			if(empty($packCntOne)){
				$savePack['PackageCategory']['name']=$this->request->data['TariffList']['name'];
				$savePack['PackageCategory']['template_name']=$this->request->data['TariffList']['template_name'];
				$savePack['PackageCategory']['is_deleted']=0;
				$this->PackageCategory->save($savePack);
			}else{
				$savePack['PackageCategory']['name']=$this->request->data['TariffList']['name'];
				$savePack['PackageCategory']['template_name']=$this->request->data['TariffList']['template_name'];
				$savePack['PackageCategory']['is_deleted']=0;
				$savePack['PackageCategory']['id']=$packCntOne['PackageCategory']['id'];
				$this->PackageCategory->save($savePack);
			}
			$this->request->data['TariffList']['id'] = $id;
			$this->request->data['TariffList']['name'] = $this->request->data['TariffList']['name'];
			$this->request->data['TariffList']['location_id']=$this->Session->read('locationid');
			$this->request->data['TariffList']['created_by']=$this->Session->read('userid');
			$this->request->data['TariffList']['create_time']=date('Y-m-d H:i:s');
			if($this->TariffList->save($this->request->data['TariffList'])){
				$this->Session->setFlash(__('Service has been created successfully!'),'default',array('class'=>'message'));
				$this->redirect(array("controller" => "Tariffs", "action" => "viewTariff"));
			} else {
				$this->Session->setFlash(__('Service can not be created! Please try again.'),'default',array('class'=>'error'));
				$this->redirect(array("controller" => "Tariffs", "action" => "viewTariff"));
			}

		}
		$data = $this->TariffList->read(null,$id);
		/* Sub Cat by Aditya Vijay...*/
			$packCnt=$this->PackageCategory->find('first',array('fields'=>array('id','template_name'),'conditions'=>array('name'=>$data['TariffList']['name'])));
			$this->set('packCntVal',$packCnt);

			if(!empty($packCnt)){
				$subpackValues=$this->PackageSubCategory->getSubPackageByID($packCnt['PackageCategory']['id']);
				$this->set('subpackValues',$subpackValues);
				
				$subSubPackValues=$this->PackageSubSubCategory->find('all',array('conditions'=>array('package_category_id'=>$packCnt['PackageCategory']['id'])));
				$this->set('subSubPackValues',$subSubPackValues);

			}
				


		/* EOD*/
		$ServiceSubCategory = $this->ServiceSubCategory->find("list",array("conditions"=>array("ServiceSubCategory.is_deleted"=>0,'ServiceSubCategory.service_category_id'=>$data['TariffList']['service_category_id'])));
		$this->set('service_sub_group_category',$ServiceSubCategory);
		$this->request->data=$data;
		$location = $this->Location->find("list",array("conditions"=>array('Location.is_deleted'=>'0')));
		$this->set('location',$location);
		$servicegroup = array('general' => 'General', 'package'=> 'Package', 'nursing' => 'Nursing', 'OPD' => 'OPD', 'surgery' => 'Surgery','procedure'=>'Procedure','investigation'=>'Investigation','icu'=>'ICU',
				'consultant'=>'Consultant','anaesthesia'=>'Anaesthesia','other'=>'Other');
		$this->set('servicegroup', $servicegroup);
	}

	public function deleteTariff($id=''){
		$this->uses = array('TariffList');
		$this->request->data['TariffList']['is_deleted']=1;
		$this->request->data['TariffList']['id']=$id;
		$this->TariffList->id= $id;
		if($this->TariffList->save($this->request->data['TariffList'])){
			$this->redirect(array("controller" => "Tariffs", "action" => "viewTariff"));
		}

	}

	public function viewTariff(){
$this->uses = array('TariffList','ServiceSubCategory','ServiceCategory');
		$this->TariffList->bindModel(array(
 						'belongsTo' => array(
						'ServiceCategory' =>array( 'foreignKey'=>'service_category_id','conditions'=>array('ServiceCategory.is_deleted'=>'0')),
    					'ServiceSubCategory' =>array('foreignKey'=>'service_sub_category_id','conditions'=>array('ServiceSubCategory.is_deleted'=>'0')),

						//'ServiceCategory' =>array('foreignKey'=>false,'conditions'=>array('TariffList.service_category_id=ServiceCategory.id')),
						//'ServiceSubCategory' =>array('foreignKey'=>false,'conditions'=>array('ServiceSubCategory.service_category_id=ServiceCategory.id'))
				)),false);
		$condition['TariffList.is_deleted'] = 0;
		$condition['TariffList.location_id'] = $this->Session->read('locationid');
		//TariffList.location_id='.$this->Session->read('locationid').'|| TariffList.location_id=0
		if(!empty($this->params->query)){
			
			if(!empty($this->params->query['code_type']))
				$condition['TariffList.code_type'] = $this->params->query['code_type'];
			
			if(!empty($this->params->query['service_name']))
				$condition['TariffList.name LIKE'] = $this->params->query['service_name']."%";
			
			if(!empty($this->params->query['service_group']))
				$condition['ServiceCategory.alias LIKE'] = $this->params->query['service_group']."%";
			
			if(!empty($this->params->query['service_sub_group']))
				$condition['ServiceSubCategory.name LIKE'] = $this->params->query['service_sub_group']."%";
				
			
			/* if(!empty($this->request->data['groupServiceSubId']))
				$condition['TariffList.service_sub_category_id'] = $this->request->data['groupServiceSubId']; */
		//debug($condition);exit;
		}
		
	/*	$searchServiceName='';
		$codeType='';
		$searchServiceGroupName='';
		$searchServiceSubGroupName='';
		//debug($this->request->data);
		if( isset($this->request->data) && $this->request->data['service_name']!=''||$this->request->data['code_type']!=''){
			$searchServiceName = $this->request->data['service_name'];
			$codeType = $this->request->data['code_type']; }
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_group']!=''){
				$searchServiceGroupName = $this->request->data['service_group'];
		}
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_subgroup_name']!=''){
			$searchServiceSubGroupName = $this->request->data['service_subgroup_name'];
		}
		//debug($searchServiceSubGroupName); exit;
		
		if(!empty($searchServiceName) && empty($codeType)){
			$condition = array('TariffList.name like '=>$searchServiceName.'%','TariffList.is_deleted'=>0,'(TariffList.location_id='.$this->Session->read('locationid').'|| TariffList.location_id=0)');
		} 
		elseif(empty($searchServiceName) && !empty($codeType)){
			$condition =array('TariffList.code_type'=>$codeType);

		}elseif(!empty($searchServiceName) && !empty($codeType)){

			$condition = array('TariffList.name like '=>$searchServiceName.'%','TariffList.code_type'=>$codeType,'TariffList.is_deleted'=>0,'(TariffList.location_id='.$this->Session->read('locationid').'|| TariffList.location_id=0)');
		}elseif(!empty($searchServiceGroupName))
		{
		$condition = array('ServiceCategory.name like' =>$searchServiceGroupName.'%' ,'TariffList.service_group like'=>$this->request->data['groupServiceId'].'%','TariffList.is_deleted'=>0,'(TariffList.location_id='.$this->Session->read('locationid').'|| TariffList.location_id=0)');
		}elseif(!empty($searchServiceSubGroupName))
		{
		$condition = array('ServiceSubCategory.name like' =>$searchServiceSubGroupName.'%' ,'TariffList.service_subcategory_id like'=>$this->request->data['groupServiceSubId'].'%','TariffList.is_deleted'=>0,'(TariffList.location_id='.$this->Session->read('locationid').'|| TariffList.location_id=0)');
		}else{
			$condition = array('TariffList.is_deleted'=>0,'TariffList.location_id='.$this->Session->read('locationid').' || TariffList.location_id=0');
		}	*/	
		//$finalConditions = array($condition,'OR'=>$oRcondition);	'TariffList.id' => 'asc',
		
		$this->paginate = array(
				'limit' => '20',
				'order' => array(
						'TariffList.name' => 'asc',

				),'conditions'=>$condition);
		$data = $this->paginate('TariffList');
		$this->set('data', $data);
		
	}

 
	
	
	/* public function addStandard(){
		$this->uses = array('TariffStandard','User','Location','Country');
	//	pr($this->request->data);exit;
		$country = $this->Country->find('list',array('fields'=>array('id','name'),'conditions'=>array('OR'=>array(array('Country.name'=>'India'),array('Country.name'=>'USA')))));
		$this->set('countries',$country);

		$getUserSsn=$this->User->find('first',array('fields'=>array('id','ssn','npi'),'conditions'=>array('User.id'=>$this->Session->read('userid'))));
		$this->set(compact('getUserSsn'));

		$getLocationTaxid=$this->Location->find('first',array('fields'=>array('id','hospital_service_tax_no'),'conditions'=>array('Location.id'=>$this->Session->read('locationid'))));

		$this->set('getLocationTaxid',$getLocationTaxid['Location']['hospital_service_tax_no']);
		if($this->request->data){
			//Claim
			if(!empty($this->request->data['TariffStandard']['outpatient_claim']))
				$this->request->data['TariffStandard']['outpatient_claim'] = implode(',',$this->request->data['TariffStandard']['outpatient_claim']);
			if(!empty($this->request->data['TariffStandard']['inpatient_claim']))
				$this->request->data['TariffStandard']['inpatient_claim'] = implode(',',$this->request->data['TariffStandard']['inpatient_claim']);
			if(!empty($this->request->data['TariffStandard']['nonpatient_claim']))
				$this->request->data['TariffStandard']['nonpatient_claim'] = implode(',',$this->request->data['TariffStandard']['nonpatient_claim']);
				
			//For Goverment
			if(!empty($this->request->data['TariffStandard']['outpatient_gov_sub1']))
				$this->request->data['TariffStandard']['outpatient_gov_sub1'] = implode(',',$this->request->data['TariffStandard']['outpatient_gov_sub1']);
			if(!empty($this->request->data['TariffStandard']['inpatient_gov_sub2']))
				$this->request->data['TariffStandard']['inpatient_gov_sub2'] = implode(',',$this->request->data['TariffStandard']['inpatient_gov_sub2']);
			if(!empty($this->request->data['TariffStandard']['nonpatient_gov_sub3']))
				$this->request->data['TariffStandard']['nonpatient_gov_sub3'] = implode(',',$this->request->data['TariffStandard']['nonpatient_gov_sub3']);
				
			//For Commercial
			if(!empty($this->request->data['TariffStandard']['outpatient_commercial_sub1']))
				$this->request->data['TariffStandard']['outpatient_commercial_sub1'] = implode(',',$this->request->data['TariffStandard']['outpatient_commercial_sub1']);
			if(!empty($this->request->data['TariffStandard']['inpatient_commercial_sub2']))
				$this->request->data['TariffStandard']['inpatient_commercial_sub2'] = implode(',',$this->request->data['TariffStandard']['inpatient_commercial_sub2']);
			if(!empty($this->request->data['TariffStandard']['nonpatient_commercial_sub3']))
				$this->request->data['TariffStandard']['nonpatient_commercial_sub3'] = implode(',',$this->request->data['TariffStandard']['nonpatient_commercial_sub3']);
				
			//For Managed Plan care
			if(!empty($this->request->data['TariffStandard']['outpatient_plan_sub1']))
				$this->request->data['TariffStandard']['outpatient_plan_sub1'] = implode(',',$this->request->data['TariffStandard']['outpatient_plan_sub1']);
			if(!empty($this->request->data['TariffStandard']['inpatient_plan_sub2']))
				$this->request->data['TariffStandard']['inpatient_plan_sub2'] = implode(',',$this->request->data['TariffStandard']['inpatient_plan_sub2']);
			if(!empty($this->request->data['TariffStandard']['nonpatient_plan_sub3']))
				$this->request->data['TariffStandard']['nonpatient_plan_sub3'] = implode(',',$this->request->data['TariffStandard']['nonpatient_plan_sub3']);

			$this->request->data['TariffStandard']['effective_date'] = $this->DateFormat->formatDate2STD($this->request->data['TariffStandard']['effective_date'],Configure::read('date_format'));
			$this->request->data['TariffStandard']['to_date'] = $this->DateFormat->formatDate2STD($this->request->data['TariffStandard']['to_date'],Configure::read('date_format'));
				
			$this->request->data['TariffStandard']['location_id']=$this->Session->read('locationid');
				
			$this->request->data['TariffStandard']['created_by']=$this->Session->read('userid');
			$this->request->data['TariffStandard']['create_time']=date('Y-m-d H:i:s');
			$this->request->data['TariffStandard']['state']=$this->request->data['Person']['state'];
			
				
			if ($this->TariffStandard->save($this->request->data['TariffStandard'])){
				$this->Session->setFlash(__('Payer saved successfully'),true);
				$this->redirect(array("controller" => "Tariffs", "action" => "viewStandard"));
			} else {
				$this->Session->setFlash('Unable to add your Payer.');
			}
		}
	} */
	
	public function addStandard(){
		$this->uses = array('TariffStandard');
		#pr($this->request->data);exit;
		if($this->request->data){
			$this->request->data['TariffStandard']['location_id']=$this->Session->read('locationid');
			$this->request->data['TariffStandard']['created_by']=$this->Session->read('userid');
			$this->request->data['TariffStandard']['create_time']=date('Y-m-d H:i:s');
			$this->TariffStandard->save($this->request->data['TariffStandard']);
			$this->redirect(array("controller" => "Tariffs", "action" => "viewStandard"));
		}
	
	}

	public function reimbursement_onchange($id){

		$traditionalVal=Configure::read('traditionalval');
		$fixedPaymentVal=Configure::read('fixedpaymentval');
		$prospectivePaymentSystemVal=Configure::read('prospectivepaymentsystemval');
		if($id=='Traditional'){
			echo json_encode($traditionalVal);
		}else if($id=='Fixed Payment'){
			echo json_encode($fixedPaymentVal);
		}else if($id=='Prospective Payment System(PPS)'){
			echo json_encode($prospectivePaymentSystemVal);
		}
		exit;
	}
	/* public function editStandard($id=''){
		$this->uses = array('TariffStandard','User','Location','Country','State');

		$getDataHospital=$this->TariffStandard->find('first',array('fields'=>array('id','hospital_name','participant','chkclick','reimbursement_methods','category_payer','country','state'),'conditions'=>array('TariffStandard.id'=>$id)));
		$this->set(compact('getDataHospital'));
		
		$country = $this->Country->find('list',array('fields'=>array('id','name'),'conditions'=>array('OR'=>array(array('Country.name'=>'India'),array('Country.name'=>'USA')))));
		$this->set('countries',$country);
		if($getDataHospital['TariffStandard']['country'] == '2'){
			$state=$this->State->find('list',array('fields'=>array('id','name'),'conditions'=>array('State.country_id'=>$getDataHospital['TariffStandard']['country'])));
		}else{
			$state=$this->State->find('list',array('fields'=>array('name','name'),'conditions'=>array('State.country_id'=>$getDataHospital['TariffStandard']['country'])));
		}
		$this->set('State',$state);

		$getUserSsn=$this->User->find('first',array('fields'=>array('id','ssn','npi'),'conditions'=>array('User.id'=>$this->Session->read('userid'))));
		$this->set(compact('getUserSsn'));

		$getLocationTaxid=$this->Location->find('first',array('fields'=>array('id','hospital_service_tax_no'),'conditions'=>array('Location.id'=>$this->Session->read('locationid'))));

		$this->set('getLocationTaxid',$getLocationTaxid['Location']['hospital_service_tax_no']);

		if($this->request->data){
			//For Claim
			if(!empty($this->request->data['TariffStandard']['outpatient_claim']))
				$this->request->data['TariffStandard']['outpatient_claim'] = implode(',',$this->request->data['TariffStandard']['outpatient_claim']);
			if(!empty($this->request->data['TariffStandard']['inpatient_claim']))
				$this->request->data['TariffStandard']['inpatient_claim'] = implode(',',$this->request->data['TariffStandard']['inpatient_claim']);
			if(!empty($this->request->data['TariffStandard']['nonpatient_claim']))
				$this->request->data['TariffStandard']['nonpatient_claim'] = implode(',',$this->request->data['TariffStandard']['nonpatient_claim']);
				
			//For Goverment
			if(!empty($this->request->data['TariffStandard']['outpatient_gov_sub1']))
				$this->request->data['TariffStandard']['outpatient_gov_sub1'] = implode(',',$this->request->data['TariffStandard']['outpatient_gov_sub1']);
			if(!empty($this->request->data['TariffStandard']['inpatient_gov_sub2']))
				$this->request->data['TariffStandard']['inpatient_gov_sub2'] = implode(',',$this->request->data['TariffStandard']['inpatient_gov_sub2']);
			if(!empty($this->request->data['TariffStandard']['nonpatient_gov_sub3']))
				$this->request->data['TariffStandard']['nonpatient_gov_sub3'] = implode(',',$this->request->data['TariffStandard']['nonpatient_gov_sub3']);

			//For Commercial
			if(!empty($this->request->data['TariffStandard']['outpatient_commercial_sub1']))
				$this->request->data['TariffStandard']['outpatient_commercial_sub1'] = implode(',',$this->request->data['TariffStandard']['outpatient_commercial_sub1']);
			if(!empty($this->request->data['TariffStandard']['inpatient_commercial_sub2']))
				$this->request->data['TariffStandard']['inpatient_commercial_sub2'] = implode(',',$this->request->data['TariffStandard']['inpatient_commercial_sub2']);
			if(!empty($this->request->data['TariffStandard']['nonpatient_commercial_sub3']))
				$this->request->data['TariffStandard']['nonpatient_commercial_sub3'] = implode(',',$this->request->data['TariffStandard']['nonpatient_commercial_sub3']);
				
			//For Managed Plan care
			if(!empty($this->request->data['TariffStandard']['outpatient_plan_sub1']))
				$this->request->data['TariffStandard']['outpatient_plan_sub1'] = implode(',',$this->request->data['TariffStandard']['outpatient_plan_sub1']);
			if(!empty($this->request->data['TariffStandard']['inpatient_plan_sub2']))
				$this->request->data['TariffStandard']['inpatient_plan_sub2'] = implode(',',$this->request->data['TariffStandard']['inpatient_plan_sub2']);
			if(!empty($this->request->data['TariffStandard']['nonpatient_plan_sub3']))
				$this->request->data['TariffStandard']['nonpatient_plan_sub3'] = implode(',',$this->request->data['TariffStandard']['nonpatient_plan_sub3']);
				
			$this->request->data['TariffStandard']['effective_date'] = $this->DateFormat->formatDate2STD($this->request->data['TariffStandard']['effective_date'],Configure::read('date_format'));
			$this->request->data['TariffStandard']['to_date'] = $this->DateFormat->formatDate2STD($this->request->data['TariffStandard']['to_date'],Configure::read('date_format'));
			
			if(isset($this->request->data['Person']['state']) && !empty($this->request->data['Person']['state']))
			$this->request->data['TariffStandard']['state']=$this->request->data['Person']['state'];
			
			$this->request->data['TariffStandard']['location_id']=$this->Session->read('locationid');
			$this->request->data['TariffStandard']['modified_by']=$this->Session->read('userid');
			$this->request->data['TariffStandard']['modify_time']=date('Y-m-d H:i:s');
		//	pr($this->request->data);exit;
			if($this->TariffStandard->save($this->request->data['TariffStandard'])){
				$this->Session->setFlash(__('Payer updated successfully'),true);
				$this->redirect(array("controller" => "Tariffs", "action" => "viewStandard"));
			}else {
				$this->Session->setFlash('Unable to add your Payer.');
			}
		}
		else{
			$data = $this->TariffStandard->read(null,$id);
			$data['TariffStandard']['effective_date'] = $this->DateFormat->formatDate2Local($data['TariffStandard']['effective_date'],Configure::read('date_format'),false);
			$data['TariffStandard']['to_date'] = $this->DateFormat->formatDate2Local($data['TariffStandard']['to_date'],Configure::read('date_format'),false);
			$this->request->data=$data;
		}
		$this->data;
	} */

	public function editStandard($id=''){
		$this->uses = array('TariffStandard');
		#pr($this->request->data);exit;
		if($this->request->data){
			$this->request->data['TariffStandard']['location_id']=$this->Session->read('locationid');
			$this->request->data['TariffStandard']['created_by']=$this->Session->read('userid');
			$this->request->data['TariffStandard']['create_time']=date('Y-m-d H:i:s');
			if($this->TariffStandard->save($this->request->data['TariffStandard'])){
				$this->redirect(array("controller" => "Tariffs", "action" => "viewStandard"));
			}
		}
		$data = $this->TariffStandard->read(null,$id);
		$this->request->data=$data;
	}
	
	public function deleteStandard($id=''){
		$this->uses = array('TariffStandard');
		$this->request->data['TariffStandard']['is_deleted']=1;
		$this->request->data['TariffStandard']['id']=$id;
		$this->TariffStandard->id= $id;
		if($this->TariffStandard->save($this->request->data['TariffStandard'])){
			$this->Session->setFlash(__('Payer deleted successfully'),true);
			$this->redirect(array("controller" => "Tariffs", "action" => "viewStandard"));
		}
	}

	public function viewStandard($searchtest=null){
		$this->uses = array('TariffStandard');
		if(empty($searchtest)){
			if(isset($this->request->data['TariffStandard']['name'])){
				$this->request->query['name'] = $this->request->data['TariffStandard']['name'];
			}
			$port = "42011";
		}else{
			$getdata = $searchtest;
			$port = "42045";
		}
		$getdata=$this->request->data['TariffStandard']['name'];
		if(isset($getdata)|| $getdata==''){
			$this->paginate = array(
					'limit' => Configure::read('number_of_rows'),
					'order' => array(
							'TariffStandard.name' => 'asc',
					),'conditions'=>array('TariffStandard.name LIKE'=> "%"."".$getdata.""."%",'TariffStandard.is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid'))
			);
			$data = $this->paginate('TariffStandard');
			if($this->request['isAjax'] == 1){
				echo json_encode($data);exit;
			}
		}
		$this->set('data', $data);
	}
	
   
	public function tariffAmount($tariffStandardId=''){
		$this->uses = array('TariffList','TariffAmount','TariffStandard');
		if($this->request->data['TariffStandard']['standardName']){
			$tariffStandardId = $this->request->data['TariffStandard']['standardName'];
		}
		$this->TariffList->bindModel(array(
				'hasOne' => array(
						'TariffAmount' =>array('foreignKey' => 'tariff_list_id','conditions'=>array('tariff_standard_id'=>$tariffStandardId)),

				)),false);
		#echo $tariffStandardId;exit;
		$data = $this->TariffList->find('all',array('conditions'=>array('TariffList.is_deleted'=>0)));
		#pr($data);
		$this->set('data',$data);
		$this->set('tariffStandardId',$tariffStandardId);

		$tariffStandardsData = $this->TariffStandard->read('name',$tariffStandardId);
		#pr($tariffStandardsData);exit;
		$this->set('tariffStandardsData',$tariffStandardsData);

		$tariffStandards = $this->TariffStandard->find('list',array('conditions'=>array('is_deleted'=>0)));
		$this->set('tariffStandards',$tariffStandards);


		#pr($data);exit;
	}

	public function saveTariffAmount(){
		$this->uses = array('TariffList','TariffAmount');
		if($this->request->data){
			#pr($this->request->data);exit;
			foreach($this->request->data['TariffAmount']['nabh_charges'] as $key=>$charges){
				$chargesData['tariff_list_id']=$key;
				$chargesData['nabh_charges']=$charges;
				$chargesData['non_nabh_charges']=$this->request->data['TariffAmount']['non_nabh_charges'][$key];
				$chargesData['tariff_standard_id']=$this->request->data['TariffList']['tariffStandardId'];
				#$chargesData['location_id']=$this->Session->read('locationid');
				$chargesData['created_by']=$this->Session->read('userid');
				$chargesData['create_time']=date("Y-m-d H:i:s");
				$this->TariffAmount->save($chargesData);
				$this->TariffAmount->id='';
				#pr($chargesData);exit;

			}
			$this->Session->setFlash(__('Record added successfully'), 'default', array('class' => 'message'));
			$this->redirect(array("controller" => "tariffs", "action" => "viewTariffAmount"));
		}
	}

	public function selectTariffStandard(){
		$this->uses = array('TariffStandard');
		$data = $this->TariffStandard->find('list',array('conditions'=>array('is_deleted'=>0)));
		$this->set('data',$data);

		#pr($data);exit;
	}

	public function viewTariffAmount(){
		$this->uses = array('TariffAmount','TariffStandard');
		$this->layout = 'advance';
		$this->set('title_for_layout', __('Payer', true));
		if(!$this->params->query['fromPackage'])//gaurav
			$this->set('title_for_layout', __('Payer Amounts', true));
		$conditions = array('TariffStandard.is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid'));
		if(!empty($this->request->data)){
			$conditions['TariffStandard.name LIKE'] = $this->request->data['TariffAmount']['name'].'%';
		}
		
		/*$this->TariffAmount->bindModel(array(
		 'belongsTo' => array(
		 		'TariffStandard' =>array('type'=>'RIGHT','foreignKey' => 'tariff_standard_id','conditions'=>array('TariffStandard.location_id='.$this->Session->read('locationid'))),

		 )),false);
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'TariffAmount.tariff_standard_id' => 'desc',
				),
				'conditions'=>array('TariffStandard.is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid')),
				'group'=>array('TariffStandard.id')
		);
		$this->TariffAmount->PaginateCount(array('TariffAmount.is_deleted'=>0,'TariffAmount.location_id'=>$this->Session->read('locationid')));
		$data = $this->paginate('TariffAmount');*/

		$data = $this->TariffStandard->find('all',array('conditions'=>array('TariffStandard.is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid')),
		));
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'conditions'=>$conditions,
				'group'=>array('TariffStandard.id'),
				'order'=>array('TariffStandard.name'=>'ASC'),
		);

		$data = $this->paginate('TariffStandard') ;;
		$this->set('data', $data);
		// pr($data);exit;

	}

	public function editTariffAmount($standardId){
		set_time_limit(0);

// 
//		$this->uses = array('TariffAmount','TariffStandard','TariffList');
//		$this->TariffList->bindModel(array(
//				'belongsTo' => array(
//						'TariffAmount' =>array('foreignKey'=>false,
//								'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id','TariffAmount.tariff_standard_id'=>$standardId)),
//				)));
//
////		$data = $this->TariffList->find('all',array('group'=>array('TariffList.id'),
////				'conditions'=>array('TariffList.is_deleted'=>0,'TariffList.location_id ='.$this->Session->read('locationid').'  || TariffList.location_id=0'),
////				'order' =>array('TariffList.name' => 'ASC')
////		));
//
//		$this->paginate = array(
//				'limit' => '10',
//				'order' => array('TariffList.name' =>'ASC'),
//				'conditions'=>array('TariffList.is_deleted'=>0,'TariffList.location_id ='.$this->Session->read('locationid')),
//				'group'=>array('TariffList.id'),
//		);
//		$data = $this->paginate('TariffList');
		ob_end_clean();
			ob_start("ob_gzhandler");
		$this->uses = array('TariffAmount','TariffStandard','TariffList');
		$tariffList = $this->TariffList->find('all',array('conditions'=>array('is_deleted'=>0,'location_id'=>$this->Session->read('locationid')),
			'order'=>array('TariffList.name')));
		
		

		$tariffAmount = $this->TariffAmount->find('all',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'tariff_standard_id'=>$standardId)));


	    foreach($tariffAmount as $amtKey=>$amtVal){
			$resetAmtArray[$amtVal['TariffAmount']['tariff_list_id']] =  $amtVal;
			
			
		}
		$this->set('data',$tariffList);
		$this->set('resetAmtArray',$resetAmtArray); 

		/*$this->TariffList->bindModel(array(
			'belongsTo' => array(
					'TariffAmount' =>array('foreignKey'=>false,
							'conditions'=>array('TariffAmount.tariff_standard_id'=>$tariff_standard_id,'TariffAmount.tariff_list_id=TariffList.id',
									'TariffAmount.location_id='.$this->Session->read('locationid'))),
			)),false);
	
	 
		$conditions['TariffList']['is_deleted'] = '0';
		$conditions['TariffList']['location_id'] = $this->Session->read('locationid');
		
		$conditions = $this->postConditions($conditions);			
		$data = $this->TariffList->find('all',array('order'=>array('name Asc'),'group'=>array('TariffList.id'),'conditions'=>$conditions));
		$this->set('data',$data);*/
		
//		$this->TariffAmount->bindModel(array(
//				'belongsTo' => array(
//						'TariffList' =>array('foreignKey'=>false,'type'=>'RIGHT',
//								'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id','TariffList.is_deleted=0',
//								'TariffList.location_id='.$this->Session->read('locationid'),'TariffAmount.tariff_standard_id='.$standardId)),
//				)),false);
//		
//		  
//			
//			//$conditions['TariffAmount.tariff_standard_id']=$standardId ;
//
//		//	$conditions = $this->postConditions($conditions);	
//
//
//
//		$this->paginate = array(
//				'limit' => '10', 
//				'conditions'=>$conditions, 
//		);
//		$data = $this->paginate('TariffAmount') ;
//		
//			//$data = $this->TariffAmount->find('all',array('order'=>array('name //Asc'),'limit'=>'10','group'=>array('TariffList.id'),'conditions'=>$conditions));
//			$this->set('data',$data);
//		





		$this->set('tariffStandardId',$standardId);
		$tariffStandardsData = $this->TariffStandard->read(array('name'),$standardId);

		$this->set('tariffStandardsData',$tariffStandardsData);

		$tariffStandards = $this->TariffStandard->find('list',array('conditions'=>array('is_deleted'=>0,
				'TariffStandard.location_id'=>$this->Session->read('locationid'))));
		$this->set('tariffStandards',$tariffStandards);


	}
	public function CheckApplyInADay($standardId,$tariffListId){
		$this->uses = array('TariffAmount','TariffStandard','TariffList');
		$this->TariffList->bindModel(array(
				'hasOne' => array(
						'TariffAmount' =>array('foreignKey' => 'tariff_list_id','conditions'=>array('tariff_standard_id'=>$standardId,'TariffAmount.location_id='.$this->Session->read('locationid'))),

				)),false);
		$data = $this->TariffList->find('first',array('conditions'=>array('TariffList.id'=>$tariffListId)));
		echo json_encode($data['TariffAmount']);
		exit;

	}
	public function copyTariffAmount(){
		set_time_limit(0);
		$this->uses = array('TariffAmount','TariffStandard','TariffList');
		
		if($this->request->data){
			ob_end_clean();
			ob_start("ob_gzhandler");
			#pr($this->request->data);exit;
			$copyFromStandardId = $this->request->data['TariffStandard']['standardName'];
			$tariffStandardId = $this->request->data['TariffList']['tariffStandardId'];
		}#echo $tariffStandardId;exit;
		$locationId=$this->Session->read('locationid');
		$this->TariffList->bindModel(array(
				'hasOne' => array(
						'TariffAmount' =>array('type'=>'INNER','foreignKey' => 'tariff_list_id','conditions'=>array('tariff_standard_id'=>$copyFromStandardId,'TariffAmount.location_id='.$locationId)),

				)),false);
		$data = $this->TariffList->find('all',array('conditions'=>array('TariffList.is_deleted'=>0,'TariffList.location_id = '.$locationId.' || TariffList.location_id=0')));
		$this->set('data',$data);
		//BOF pankaj
		$this->TariffList->bindModel(array(
				'hasOne' => array(
						'TariffAmount' =>array('type'=>'INNER','foreignKey' => 'tariff_list_id','conditions'=>array('tariff_standard_id'=>$tariffStandardId,'TariffAmount.location_id='.$locationId)),

				)),false);
		$currentData = $this->TariffList->find('all',array('conditions'=>array('TariffList.is_deleted'=>0,'TariffList.location_id = '.$locationId.' || TariffList.location_id=0')));

		//EOF pankaj

		$this->set(array('tariffStandardId'=>$tariffStandardId,'currentData'=>$currentData));
		 
		$tariffStandards = $this->TariffStandard->find('list',array('conditions'=>array('is_deleted'=>0,'TariffStandard.location_id'=>$this->Session->read('locationid'))));
		$this->set('tariffStandards',$tariffStandards); 
		$tariffStandardsData = $this->TariffStandard->read('name',$tariffStandardId);
		 
		$this->set('tariffStandardsData',$tariffStandardsData);
		
	}


	public function updateTariffAmount(){
		
		set_time_limit(0);
		$this->uses = array('TariffList','TariffAmount','ServiceAmount','TariffAmountType');

		if($this->request->data){
			$Model = 'TariffAmount';
			$website=$this->Session->read('website.instance');
		    if($website=='vadodara'){
			foreach($this->request->data['TariffAmountType'] as $key=>$charges){
            
				if(is_array($charges)){
					#$this->TariffAmount->id=$key;
					if($charges['id'] !=''){						
						$this->TariffAmountType->id=$charges['id'];
						$charges['location_id']=$this->Session->read('locationid');
						$charges['modified_by']=$this->Session->read('userid');
						$charges['modify_time']=date("Y-m-d H:i:s");
						//pr($charges);exit;
						$this->TariffAmountType->save($charges);
						$this->TariffAmountType->id='';
					}else{				
						$charges['tariff_list_id']=$key;
						$charges['location_id']=$this->Session->read('locationid');
						$charges['created_by']=$this->Session->read('userid');
						$charges['create_time']=date("Y-m-d H:i:s");
						$charges['modified_by']=$this->Session->read('userid');
						$charges['modify_time']=date("Y-m-d H:i:s");
						//pr($this->request->data['TariffAmount']['Model']);exit;
						$this->TariffAmountType->save($charges);
						$this->TariffAmountType->id='';
					}
				}
			}
			foreach($this->request->data['TariffAmount'] as $key=>$charges){
				 
				if(is_array($charges)){
					#$this->TariffAmount->id=$key;
					if($charges['id'] !=''){
						$this->$Model->id=$charges['id'];
						$charges['location_id']=$this->Session->read('locationid');
						$charges['modified_by']=$this->Session->read('userid');
						$charges['modify_time']=date("Y-m-d H:i:s");
						//pr($charges);exit;
						$this->$Model->save($charges);
						$this->$Model->id='';
					}else{
						$charges['tariff_list_id']=$key;
						$charges['location_id']=$this->Session->read('locationid');
						$charges['created_by']=$this->Session->read('userid');
						$charges['create_time']=date("Y-m-d H:i:s");
						$charges['modified_by']=$this->Session->read('userid');
						$charges['modify_time']=date("Y-m-d H:i:s");
						//pr($this->request->data['TariffAmount']['Model']);exit;
						$this->$Model->save($charges);
						$this->$Model->id='';
					}
				}
			}
		    }else{
		    	
		    	foreach($this->request->data['TariffAmount'] as $key=>$charges){
		    	
		    		if(is_array($charges)){
		    			#$this->TariffAmount->id=$key;
		    			if($charges['id'] !=''){
		    				$this->$Model->id=$charges['id'];
		    				$charges['location_id']=$this->Session->read('locationid');
		    				$charges['modified_by']=$this->Session->read('userid');
		    				$charges['modify_time']=date("Y-m-d H:i:s");
		    				//pr($charges);exit;
		    				$this->$Model->save($charges);
		    				$this->$Model->id='';
		    			}else{
		    				$charges['tariff_list_id']=$key;
		    				$charges['location_id']=$this->Session->read('locationid');
		    				$charges['created_by']=$this->Session->read('userid');
		    				$charges['create_time']=date("Y-m-d H:i:s");
		    				$charges['modified_by']=$this->Session->read('userid');
		    				$charges['modify_time']=date("Y-m-d H:i:s");
		    				//pr($this->request->data['TariffAmount']['Model']);exit;
		    				$this->$Model->save($charges);
		    				$this->$Model->id='';
		    			}
		    		}
		    	}
		    }
			$this->Session->setFlash(__('Record updated successfully'), 'default', array('class' => 'message'));
			//$this->redirect(array("controller" => "tariffs", "action" => "viewTariffAmount"));
			$this->redirect($this->referer());
		}
		$this->redirect(array("controller" => "tariffs", "action" => "viewTariffAmount")); //for safe backup
	}

	public function addCopyAmount(){
		set_time_limit(0);
		$this->uses = array('TariffList','TariffAmount'); 
		if($this->request->data){ 
			$i=0 ;
			 Configure::write('debug',2);
			foreach($this->request->data['TariffAmount'] as $key=>$charges){ 
			if(is_array($charges)){ 
					/*if($charges['id'] !=''){
						$this->TariffAmount->id=$charges['id'];
						$chargesArray['id']=$charges['id'];
						$chargesArray['location_id']=$this->Session->read('locationid');
						$chargesArray['modified_by']=$this->Session->read('userid');
						$chargesArray['modify_time']=date("Y-m-d H:i:s");						
						 $this->TariffAmount->id=''; 
						$i++ ; 
					}else{*/
				
						#if($charges['id']){
							$charges1 = $charges ; 
							if(!$charges1['moa_sr_no']) unset($charges1['moa_sr_no']) ;
							$charges1['tariff_list_id']=$key;
							$charges1['location_id']=$this->Session->read('locationid');
							$charges1['modified_by']=$this->Session->read('userid');
							$charges1['modify_time']="'".date("Y-m-d H:i:s")."'"; 
							#$this->TariffAmount->save($charges);
							if($charges1['id']){  
								$this->TariffAmount->updateAll($charges1,array('id'=>$charges1['id']));
							}else{
								 
								$this->TariffAmount->save($charges1);
							}
							$this->TariffAmount->id='';
							
						#}
					//}
				}  
			}		
			/*if(!empty($chargesArray))
			$this->TariffAmount->save($chargesArray); *///insert new record
		
			$this->Session->setFlash(__('Record updated successfully'), 'default', array('class' => 'message'));
			 $this->redirect(array("controller" => "tariffs", "action" => "viewTariffAmount"));
		}
	}

	public function addNursing(){
		$this->uses = array('TariffList','Nursing','TariffStandard');
		if($this->request->data){
			//pr($this->request->data);exit;
			$data=array();
			$data['location_id']=$this->Session->read('locationid');
			$data['created_by']=$this->Session->read('userid');
			$data['create_time']=date("Y-m-d H:i:s");
			$data['service_name']=$this->request->data['Nursing']['service_name'];
			$data['tariff_list_id']=$this->request->data['Nursing']['tariff_list_id'];
			#$data['tariff_standard_id']=$this->request->data['Nursing']['tariff_standard_id'];
			#pr($data);exit;
			$this->Nursing->save($data);
			$this->redirect(array("controller" => "tariffs", "action" => "viewNursing"));
		}

		$data = $this->TariffList->find('list',array('conditions'=>array('TariffList.is_deleted'=>0)));
		unset($data[1]);
		unset($data[2]);
		unset($data[3]);
		#pr($data);exit;
		$this->set('data',$data);
		#$tariffStandard = $this->TariffStandard->find('list',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_deleted'=>0)));
		#$this->set('tariffStandard',$tariffStandard);
	}

	public function viewNursing(){
		$this->uses = array('Nursing');
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'Nursing.service_name' => 'desc',

				),'conditions'=>array('Nursing.is_deleted'=>0,'Nursing.location_id'=>$this->Session->read('locationid'))
		);
		$data = $this->paginate('Nursing');
		$this->set('data', $data);
	}

	public function editNursing($nursingId = null){
		//pr($this->params);exit;
		$this->uses = array('TariffList','Nursing','TariffStandard');
		if($this->request->data){
			#pr($this->request->data);exit;
			//	$data=array();
			#$this->request->data['Nursing']['location_id']=$this->Session->read('locationid');
			$this->request->data['Nursing']['created_by']=$this->Session->read('userid');
			$this->request->data['Nursing']['create_time']=date("Y-m-d H:i:s");

			#pr($data);exit;
			$this->Nursing->save($this->request->data['Nursing']);
			$this->redirect(array("controller" => "tariffs", "action" => "viewNursing"));
		}

		$data = $this->TariffList->find('list',array('conditions'=>array('TariffList.is_deleted'=>0)));
		$this->set('data',$data);
		#$tariffStandard = $this->TariffStandard->find('list',array('conditions'=>array('location_id'=>$this->Session->read('locationid'),'is_deleted'=>0)));
		#$this->set('tariffStandard',$tariffStandard);
		$this->request->data = $this->Nursing->read(null,$nursingId);
	}

	public function deleteNursing($id=''){
		$this->uses = array('Nursing');
		$this->request->data['Nursing']['is_deleted']=1;
		$this->Nursing->id= $id;
		if($this->Nursing->save($this->request->data['Nursing'])){
			$this->redirect(array("controller" => "Tariffs", "action" => "viewNursing"));
		}

	}

	/* service categary and subcategary part*/
	public function service_category_list(){
		$this->uses = array('ServiceCategory');


		$searchServiceGroupName='';
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_group_name']!=''){
			$searchServiceGroupName = $this->request->data['service_group_name'];
		}

		if(!empty($searchServiceGroupName)){
			$searchConditions = array('ServiceCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'), 'ServiceCategory.alias LIKE ' => $searchServiceGroupName.'%');
		} else {
			$searchConditions = array('ServiceCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'));
		}

		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'ServiceCategory.name' => 'asc',

				),'conditions'=>$searchConditions
		);

		$this->set('data', $this->paginate('ServiceCategory'));
	}

	public function service_sub_category_list(){
	
		$this->uses = array('ServiceSubCategory');
		$this->ServiceSubCategory->bindModel("ServiceCategory");
		$searchServiceSubGroupName='';
		$searchServiceGroupName=''; 
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_subgroup_name']!=''){
			$searchServiceSubGroupName = $this->request->data['service_subgroup_name']; //debug($searchServiceSubGroupName); exit;
		} 
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_group_name']!=''){
			$searchServiceGroupName = $this->request->data['service_group_name'];
		}
		if(!empty($searchServiceSubGroupName)){
			$searchConditions = array('ServiceSubCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'), 'ServiceSubCategory.name LIKE ' => $searchServiceSubGroupName.'%');
		}
		 else if(!empty($searchServiceGroupName)){
			$searchConditions = array('ServiceCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'), 'ServiceCategory.alias LIKE ' => $searchServiceGroupName.'%');
		} 
	     else {
		$searchConditions = array('ServiceSubCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'));
		} 

		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'order' => array(
						'ServiceSubCategory.name' => 'asc',

				),'conditions'=>$searchConditions
		);
		$this->set('data', $this->paginate('ServiceSubCategory'));
}

   
	public function service_category_add(){
	 $this->uses = array('ServiceCategory');
		if($this->request->data){
			
			// Check if Service Group already exists.
			$old_data = $this->ServiceCategory->find('count',array('conditions'=>array('ServiceCategory.name'=>$this->request->data['ServiceCategory']['name'],'ServiceCategory.is_deleted'=>0,'ServiceCategory.location_id'=>$this->Session->read('locationid'))));
			
			if($old_data < 1){	
			$this->request->data['ServiceCategory']['location_id']=$this->Session->read('locationid');
			$this->request->data['ServiceCategory']['created_by']=$this->Session->read('userid');
			$this->request->data['ServiceCategory']['create_time']=date("Y-m-d H:i:s");
			$this->ServiceCategory->save($this->request->data);
			$errors = $this->ServiceCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else{
				$this->Session->setFlash(__('Record addedd sucessfully'), 'default', array('class' => 'message'));
				$this->redirect(array("controller" => "Tariffs", "action" => "service_category_list"));
			     }
			} else {
				$this->Session->setFlash(__('Service Group already exist! Please try again.'),'default',array('class'=>'error'));
				$this->redirect(array("controller" => "Tariffs", "action" => "service_category_add"));
			}
		}
	}
	public function service_category_edit($id = null){
		$this->uses = array('ServiceCategory');
		if (empty($this->request->data)) {
			$this->request->data = $this->ServiceCategory->findById($id);
		} else {

			$this->ServiceCategory->id = $id;
			$this->ServiceCategory->save($this->request->data);
			$errors = $this->ServiceCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else{
				$this->Session->setFlash(__('Record edit sucessfully'), 'default', array('class' => 'message'));
				$this->redirect(array("controller" => "Tariffs", "action" => "service_category_list"));
			}
		}
	}
	public function service_category_delete($id = null){
		$this->uses = array('ServiceCategory');
		$this->ServiceCategory->id = $id;
		$this->ServiceCategory->save(array("is_deleted"=>1));
		$errors = $this->ServiceCategory->invalidFields();
		if(!empty($errors)) {
			$this->set("errors", $errors);
		}else{
			$this->Session->setFlash(__('Record deleted sucessfully'), 'default', array('class' => 'message'));
			$this->redirect(array("controller" => "Tariffs", "action" => "service_category_list"));
		}
	}
	public function service_sub_category_add(){
		$this->uses = array('ServiceCategory','ServiceSubCategory');
		$data = $this->ServiceCategory->getServiceGroup();
		$this->set('service_group_category',$data);
		if($this->request->data){
			$this->request->data['ServiceSubCategory']['location_id']=$this->Session->read('locationid');
			$this->request->data['ServiceSubCategory']['created_by']=$this->Session->read('userid');
			$this->request->data['ServiceSubCategory']['create_time']=date("Y-m-d H:i:s");
			$this->ServiceSubCategory->save($this->request->data);
			$errors = $this->ServiceSubCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else{
				$this->Session->setFlash(__('Record addedd sucessfully'), 'default', array('class' => 'message'));
				$this->redirect(array("controller" => "Tariffs", "action" => "service_sub_category_list"));
			}
		}
	}
	public function service_sub_category_edit($id = null){
		$this->uses = array('ServiceCategory','ServiceSubCategory');
		$data = $this->ServiceCategory->getServiceGroup();
		$this->set('service_group_category',$data);
		if (empty($this->request->data)) {
			$this->request->data = $this->ServiceSubCategory->findById($id);
		} else {

			$this->ServiceSubCategory->id = $id;
			$this->ServiceSubCategory->save($this->request->data);
			$errors = $this->ServiceSubCategory->invalidFields();
			if(!empty($errors)) {
				$this->set("errors", $errors);
			}else{
				$this->Session->setFlash(__('Record edit sucessfully'), 'default', array('class' => 'message'));
				$this->redirect(array("controller" => "Tariffs", "action" => "service_sub_category_list"));
			}
		}
	}
	public function service_sub_category_delete($id = null){
		$this->uses = array('ServiceSubCategory');
		$this->ServiceSubCategory->id = $id;
		$this->ServiceSubCategory->save(array("is_deleted"=>1));
		$errors = $this->ServiceSubCategory->invalidFields();
		if(!empty($errors)) {
			$this->set("errors", $errors);
		}else{
			$this->Session->setFlash(__('Record deleted sucessfully'), 'default', array('class' => 'message'));
			$this->redirect(array("controller" => "Tariffs", "action" => "service_sub_category_list"));
		}
	}

	public function admin_import_data(){
		$this->uses = array('TariffStandard');
		App::import('Vendor', 'reader');
		$this->set('title_for_layout', __('Tariff- Export Data', true));
		$website=$this->Session->read("website.instance");
		if ($this->request->is('post')) { //pr($this->request->data);
			if($this->request->data['importData']['import_file']['error'] !="0"){
				$this->Session->setFlash(__('Please Upload the file'), 'default', array('class' => 'error'));
				$this->redirect(array("controller" => "Tariffs", "action" => "import_data","admin"=>true));
			}
			/*if($this->request->data['importData']['import_file']['size'] > "1000000"){
			 $this->Session->setFlash(__('Size exceed Please upload 1 MB size file.'), 'default', array('class' => 'error'));
			$this->redirect(array("controller" => "Tariffs", "action" => "import_data","admin"=>true));
			}*/
			
			$tariff=$this->request->data['importData']['tariffId'];
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			ini_set('memory_limit',-1);
			set_time_limit(0);
			$path = WWW_ROOT.'uploads/import/'. $this->request->data['importData']['import_file']['name'];
			move_uploaded_file($this->request->data['importData']['import_file']['tmp_name'],$path );
			chmod($data->path,777);
			$data = new Spreadsheet_Excel_Reader($path);
		    $is_uploaded = $this->Tariff->importClinicalServices($data);
		

			if($is_uploaded == true){
				unlink( $path );
				$this->Session->setFlash(__('Data imported sucessfully'), 'default', array('class' => 'message'));
				$this->redirect(array("controller" => "Tariffs", "action" => "import_data","admin"=>true));
			}else{
				unlink( $path );
				$this->Session->setFlash(__('Error Occured Please check your Excel sheet.'), 'default', array('class' => 'error'));
				$this->redirect(array("controller" => "Tariffs", "action" => "import_data","admin"=>true));
			}

		}
		$privateID = $this->TariffStandard->getPrivateTariffID();
		$this->set('privateID',$privateID);
		$tariffStandard=$this->TariffStandard->find("list",array(array('id','name'),"conditions"=>
				array("TariffStandard.is_deleted"=>0,
						'TariffStandard.location_id'=>$this->Session->read('locationid')
				)
		));
		$this->set('tariffStandard',$tariffStandard);

	}

	/* function tariffListOptions($tariff_standard_id= null,$serviceType = null,$listNameLike= null){

		if(!$tariff_standard_id) $this->redirect($this->referer());
		$this->uses = array('TariffAmount','TariffStandard','TariffList','Icd10pcMaster');
		$searchServiceName='';$searchConditions='';
		if(empty($serviceType) || $serviceType == 'cpt'){

			$letters = $this->TariffList->find('all',array('fields'=>array('DISTINCT SUBSTRING(`TariffList`.`name`, 1, 1) as name' ),
					'order'=> array('name')));
			 
			if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_name']!=''){
				$searchConditions = array('TariffList.name like'=>$this->request->data['service_name'].'%',
						'TariffList.is_deleted'=>0,'TariffList.location_id '=>$this->Session->read('locationid'));
			}else
				if(isset($listNameLike) && !empty($listNameLike)){
				$searchConditions = array('TariffList.name like'=>$listNameLike.'%',
						'TariffList.is_deleted'=>0,'TariffList.location_id '=>$this->Session->read('locationid'));
			}else
				if(isset($this->request->data) && isset($this->request->data) && $this->request->data['search_cpt_code']!=''){
				$searchConditions = array('TariffList.cbt like'=>$this->request->data['search_cpt_code'].'%',
						'TariffList.is_deleted'=>0,'TariffList.location_id '=>$this->Session->read('locationid'));
			}
			$this->TariffList->bindModel(array(
					'belongsTo' => array(
							'TariffAmount' =>array('foreignKey'=>false,
									'conditions'=>array('TariffAmount.tariff_standard_id'=>$tariff_standard_id,'TariffAmount.tariff_list_id=TariffList.id',
											'TariffAmount.location_id='.$this->Session->read('locationid'))))),false);

			if(!empty($searchConditions)){
				$data = $this->TariffList->find('all',array('group'=>array('TariffList.id'),'conditions'=>$searchConditions));
				$this->set('data',$data);
			}
			$serviceType = 'cpt';
		}else{
			$letters = $this->Icd10pcMaster->find('all',array('fields'=>array('DISTINCT SUBSTRING(`Icd10pcMaster`.`ICD10PCS_FULL_DESCRIPTION`, 1, 1) as name' ),
					'order'=> array('Icd10pcMaster.ICD10PCS_FULL_DESCRIPTION'),'conditions'=>array('Icd10pcMaster.is_deleted'=>0,
							'Icd10pcMaster.location_id '=>$this->Session->read('locationid'),'is_valid'=>1)));
				
			if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_name']!=''){
				$searchConditions = array('Icd10pcMaster.ICD10PCS_FULL_DESCRIPTION like'=>$this->request->data['service_name'].'%',
						'Icd10pcMaster.is_deleted'=>0,'Icd10pcMaster.location_id '=>$this->Session->read('locationid'),'is_valid'=>1);
			}else
				if(isset($listNameLike) && !empty($listNameLike)){
				$searchConditions = array('Icd10pcMaster.ICD10PCS_FULL_DESCRIPTION like'=>$listNameLike.'%',
						'Icd10pcMaster.is_deleted'=>0,'Icd10pcMaster.location_id '=>$this->Session->read('locationid'),'is_valid'=>1);
			}else
				if(isset($this->request->data) && isset($this->request->data) && $this->request->data['search_cpt_code']!=''){
				$searchConditions = array('Icd10pcMaster.ICD10PCS like'=>$this->request->data['search_cpt_code'].'%',
						'Icd10pcMaster.is_deleted'=>0,'Icd10pcMaster.location_id '=>$this->Session->read('locationid'),'is_valid'=>1);
			}
			$this->Icd10pcMaster->bindModel(array(
					'belongsTo' => array(
							'ServiceAmount' =>array('foreignKey'=>false,
									'conditions'=>array('ServiceAmount.tariff_standard_id'=>$tariff_standard_id,'ServiceAmount.icd10pc_masters_id=Icd10pcMaster.id',
											'ServiceAmount.location_id='.$this->Session->read('locationid'))))),false);
			if(!empty($searchConditions)){
				$data = $this->Icd10pcMaster->find('all',array('fields'=>array('Icd10pcMaster.id','Icd10pcMaster.ICD10PCS',
						'Icd10pcMaster.ICD10PCS_FULL_DESCRIPTION','ServiceAmount.id','ServiceAmount.icd10pc_masters_id',
						'ServiceAmount.tariff_standard_id','ServiceAmount.base_price','ServiceAmount.allowed_price'),
						'group'=>array('Icd10pcMaster.id'),'conditions'=>$searchConditions));
				$this->set('data',$data);
			}
			$serviceType = 'icd';
				
		}
		$tariffStandardsData = $this->TariffStandard->read(array('name'),$tariff_standard_id);
		$this->set('tariffStandardsData',$tariffStandardsData);
		$this->set('tariffStandardId',$tariff_standard_id);
		$this->set('letters',$letters);
		$this->set('serviceType',$serviceType);

	}
 */
	
	function tariffListOptions($tariff_standard_id= null){
		$this->layout = 'advance';
		if(!$tariff_standard_id) $this->redirect($this->referer());
		
		$searchServiceId='';	
		$searchServiceName='';
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['service_name']!=''){
			$searchServiceName = $this->request->data['service_name'];
			$conditions['TariffList']['name like'] = $searchServiceName.'%';
		}
	
		
		
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['groupServiceId']!=''){
				$searchServiceId = $this->request->data['groupServiceId'];
				$conditions['TariffList']['service_category_id'] = $searchServiceId;
		}
	
		$this->uses = array('TariffAmount','TariffStandard','TariffList');
		$this->TariffList->bindModel(array(
				'belongsTo' => array(
						'TariffAmount' =>array('foreignKey'=>false,
								'conditions'=>array('TariffAmount.tariff_standard_id'=>$tariff_standard_id,'TariffAmount.tariff_list_id=TariffList.id',
										'TariffAmount.location_id='.$this->Session->read('locationid'))),
						
						'TariffAmountType' =>array('foreignKey'=>false,
								'conditions'=>array('TariffAmountType.tariff_standard_id'=>$tariff_standard_id,'TariffAmountType.tariff_list_id=TariffList.id',
										'TariffAmountType.location_id='.$this->Session->read('locationid'))),
						
						
				)),false);
		
		if(!empty($searchServiceName) || !empty($searchServiceId)){		
			$conditions['TariffList']['is_deleted'] = '0';
			$conditions['TariffList']['location_id'] = $this->Session->read('locationid');
			
			$conditions = $this->postConditions($conditions);			
			$data = $this->TariffList->find('all',array('order'=>array('name Asc'),'group'=>array('TariffList.id'),'conditions'=>$conditions/*array('OR'=>array('TariffList.service_category_id'=>$searchServiceId,'TariffList.name like'=>$searchServiceName.'%'),
					'TariffList.is_deleted'=>0,'TariffList.location_id '=>array($this->Session->read('locationid'),0))*/));
			$this->set('data',$data);
		}
		$tariffStandardsData = $this->TariffStandard->read(array('id','name'),$tariff_standard_id);
	
		$this->set('tariffStandardsData',$tariffStandardsData);
		//$privateID = $this->TariffStandard->getPrivateTariffID();
		//$this->set('privateID',$privateID); -commented by atul
	
	
		$this->set('tariffStandardId',$tariff_standard_id);
	}
	
	function autocomplete($model=null,$field=null,$type=null,$is_deleted=null,$location=null,$argConditions=null,$group=array()){

		$location_id = $this->Session->read('locationid');

		$this->layout = "ajax";

		$this->loadModel($model);

		$conditions =array();

		//debug($conditions);exit;
		
		if(!empty($argConditions)){

			if(strpos($argConditions, "&")){

				$allCondition = explode('&',$argConditions);

				foreach($allCondition as $cond){

					if(!empty($cond)){

						$condPara = explode('=',$cond);

						if(!empty($condPara[0]) && (!empty($condPara[1])||$condPara[0]==0)){

							$conditions[$condPara[0]] = $condPara[1];

						}

					}

				}

			}else{

				$condPara = explode('=',$argConditions);

				if(!empty($condPara[0]) && !empty($condPara[1])){

					$conditions["$condPara[0]"] = $condPara[1];

				}

			}

		}else{

			$conditions =array();

		}



		$searchKey = $this->params->query['q'] ;

		//converting date from local to DB format.

		if($type=="date"){

			$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'));

		}elseif($type=="datetime"){  //converting datetime from local to DB format.

			$searchKey = $this->DateFormat->formatDate2STD($this->params->query['q'],Configure::read('date_format'),true);

		}

		//filter deleted items



		if(empty($is_deleted) || $is_deleted=='null'):

		$conditions['is_deleted'] = 0 ;

		endif ;



		$conditions['location_id '] = array(0,$location_id) ;

		if($model =='OtItem'){
			$conditions['OtItem.ot_item_category_id'] = $this->params->query['category'];
		}
		if($model =='Patient'){
			$conditions['Patient.is_discharge'] = '0';
			$conditions['Patient.is_deleted'] = '0';

		}
		if($model =='PharmacyItem'){



			$conditions["PharmacyItem.supplier_id <>"] ="";

			$conditions["PharmacyItem.is_deleted"] ='0';

			if(isset($this->params->query['supplierID'])){

				$conditions["PharmacyItem.supplier_id"] = $this->params->query['supplierID'];

			}



		}

		if($model =='User'){



			$conditions["User.username <>"] ="admin";

			$conditions["User.username !="] ="superadmin";





		}

		$conditions['trim('.$field.") like"] = "%".$searchKey."%";

		$patientArray = $this->$model->find('list', array('fields'=> array('id', $field),'conditions'=>$conditions,'group'=>$group));



		foreach ($patientArray as $key=>$value) {

			//converting date from local to DB format.

			if($type=="date"){

				$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'));

			}elseif($type=="datetime"){  //converting datetime from local to DB format.

				$value = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'),true);

			}

			echo "$value|$key\n";

		}

		exit;//dont remove this

	}
	function getServiceByCategory() {
		$this->layout = false;
		$category = $this->request->query['Surgery'];
		$searchKey = $this->request->query['q'];
		$this->uses = array('ServiceCategory','TariffList');
		$this->ServiceCategory->unBindModel(array(
				'hasMany' => array('ServiceSubCategory')));
		$categoryId = $this->ServiceCategory->findAllByName($category);
		$categoryId = $categoryId[0]['ServiceCategory']['id'];
		 
		$data = $this->TariffList->find('all',array('conditions'=>array('TariffList.service_category_id'=>$categoryId,'TariffList.name like "'.$searchKey.'%"')));

		foreach ($data as $tariffList) {
			echo $tariffList['TariffList']['name']."    ".$tariffList['TariffList']['id']."|".$tariffList['TariffList']['id']."\n";
		}
		exit;
	}
	
	public function tariffCharges($tariffStandardId,$tariffListId,$tariffChargeId = null){
		$this->layout = 'advance';
		if(!$tariffStandardId || !$tariffListId) $this->redirect($this->referer());
		$this->uses = array('TariffStandard','TariffCharge','User');
		$this->TariffStandard->bindModel(array(
				'hasOne'=>array(
						'TariffList'=>array('foreignKey'=>false,'conditions'=>array("TariffList.id=$tariffListId")),
						'TariffAmount'=>array('foreignKey'=>false,
								'conditions'=>array("TariffAmount.tariff_list_id=$tariffListId","TariffAmount.tariff_standard_id=$tariffStandardId",
										'TariffAmount.is_deleted=0'))
						)));
		$tariffStandardsData = $this->TariffStandard->find('first',array('fields'=>array('TariffStandard.id','TariffStandard.name',
				'TariffList.id','TariffList.name','TariffAmount.id'),
				'conditions'=>array('TariffStandard.id'=>$tariffStandardId)));
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'conditions'=>array('TariffCharge.is_deleted'=>0,'TariffCharge.location_id'=>$this->Session->read('locationid'),
						'TariffCharge.tariff_standard_id'=>$tariffStandardId,'TariffCharge.tariff_list_id'=>$tariffListId)
		);
		$tariffChargeData = $this->paginate('TariffCharge');
		if($tariffChargeId)
			$this->data = $this->TariffCharge->read(null,$tariffChargeId);
		//$this->set('doctorList',$this->User->getAllDoctors());
		$this->set('doctorList',$this->User->getOpdDoctors());
		$this->set(array('tariffStandardsData'=>$tariffStandardsData,'tariffChargeData'=>$tariffChargeData));
	
	}
	
	function saveTariffCharges(){
		$this->uses = array('TariffAmount','TariffCharge');
		
		$this->TariffCharge->saveDayWiseTariff($this->request->data);
		$message = ($this->request->data['TariffCharge']['id']) ? 'Updated Successfully' : 'Added Successfully';
		$this->Session->setFlash(__($message, true, array('class'=>'message')));
		$this->redirect(array("controller" => "Tariffs", "action" => "tariffCharges",$this->request->data['TariffCharge']['tariff_standard_id'],$this->request->data['TariffCharge']['tariff_list_id'],"admin"=>false));
	}
	
	function deleteTariffCharges($tariffChargeId, $tariffStandardId = null, $tariffListId = null){
		$this->uses = array('TariffAmount','TariffCharge');
		$this->TariffCharge->updateAll(array('TariffCharge.is_deleted' => "'1'"),array('TariffCharge.id' => $tariffChargeId));
		$this->Session->setFlash(__('Deleted Successfully', true, array('class'=>'message')));
		$this->redirect(array("controller" => "Tariffs", "action" => "tariffCharges",$tariffStandardId,$tariffListId,"admin"=>false));
	}

	//ajax charge update by pankaj
	function ajaxChargeUpdate(){
		$this->layout = ajax ;
		$this->autoRender = false;
		$this->loadModel('TariffAmount');
		$charges = $this->request->data ;
		$hospitalType = $this->Session->read('hospitaltype');
		if($hospitalType == 'NABH'){
			$charges['nabh_charges'] = $charges['cost'];
		}else{
			$charges['non_nabh_charges'] = $charges['cost'];
		}
		$charges['award_amount'] = $charges['awardAmount'];
		$charges['moa_sr_no'] = $charges['moaSrNo'];
		$charges['unit_days'] = $charges['unitDays'];
		if($charges['id'] !=''){						
			$this->TariffAmount->id=$charges['id'];
			$charges['location_id']=$this->Session->read('locationid');
			$charges['created_by']=$this->Session->read('userid');
			$charges['create_time']=date("Y-m-d H:i:s");			
			$this->TariffAmount->save($charges);
		}else{						
 			$charges['location_id']=$this->Session->read('locationid');
			$charges['modified_by']=$this->Session->read('userid');
			$charges['modify_time']=date("Y-m-d H:i:s");			
			$this->TariffAmount->save($charges);
		}
		return $this->TariffAmount->id;
	}
	public function saveTemplate(){
		$this->layout = ajax ;
		$this->autoRender = false;
		$this->loadModel('PackageSubCategory');
		$this->loadModel('PackageCategory');

		if(isset($this->request->data) && !empty($this->request->data)){
			$packCnt=$this->PackageCategory->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>$this->request->data['name_pack'])));
			if(empty($packCnt)){
				$savePack['PackageCategory']['name']=$this->request->data['name_pack'];
				$savePack['PackageCategory']['is_deleted']='0';
				$this->PackageCategory->save($savePack);
				$package_category_id=$this->PackageCategory->getInsertId();
			}else{
				$package_category_id=$packCnt['PackageCategory']['id'];
			}
			
			if(isset($this->request->data['id']) && !empty($this->request->data['id']))
			$saveSubPack['PackageSubCategory']['id']=$this->request->data['id'];
			
			$saveSubPack['PackageSubCategory']['name']=$this->request->data['subGrp'];
			$saveSubPack['PackageSubCategory']['template_name']=$this->request->data['templateName'];
			$saveSubPack['PackageSubCategory']['package_category_id']=$package_category_id;
			$saveSubPack['PackageSubCategory']['is_deleted']='0';
			$this->PackageSubCategory->save($saveSubPack);
		}
	}

	public function saveSubTemplate(){
		$this->layout = ajax ;
		$this->autoRender = false;
		$this->loadModel('PackageSubCategory');
		$this->loadModel('PackageSubSubCategory');
		if(isset($this->request->data) && !empty($this->request->data)){
			$packCnt=$this->PackageSubCategory->find('first',array('fields'=>array('package_category_id'),'conditions'=>array('id'=>$this->request->data['sub_cat_id'])));

			$savesubSubPack['PackageSubSubCategory']['name']=$this->request->data['name_sub'];
			$savesubSubPack['PackageSubSubCategory']['package_sub_category_id']=$this->request->data['sub_cat_id'];
			$savesubSubPack['PackageSubSubCategory']['package_category_id']=$packCnt['PackageSubCategory']['package_category_id'];
			$savesubSubPack['PackageSubSubCategory']['is_deleted']='0';
			$savesubSubPack['PackageSubSubCategory']['template_name']=$this->request->data['sub_template_name'];
			$this->PackageSubSubCategory->save($savesubSubPack);
		}
	}
}
