<?php
/**
 * RoomsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Rooms Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */

class PreferencesController extends AppController {

	public $name = 'Preferences';
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	public $uses = array('Facility','Preferencecard','Surgery');

	public function admin_index(){
		if ($this->request->is('post')) {

			$this->Facility->id = $this->Session->read('facilityid');
			$this->request->data['Facility']['preference'] = serialize($this->request->data);
			$this->Facility->save($this->request->data);
			$this->Session->write('preferences',$this->request->data['Facility']['preference']);
			$this->Session->setFlash(__('Preference settings has been Saved successfully!'),'default',array('class'=>'message'));
			$this->redirect(array("controller" => "Preferences", "action" => "index", "admin" => true));
		}

		$facility = $this->Facility->read(null,$this->Session->read('facilityid'));
		$this->set("data",unserialize($facility['Facility']['preference']));
	}
	public function websitepreference(){
		if ($this->request->is('post')) {

			$this->Facility->id = $this->Session->read('facilityid');
			$this->request->data['Facility']['preference'] = serialize($this->request->data);
			$this->Facility->save($this->request->data);
			$this->Session->write('preferences',$this->request->data['Facility']['preference']);
			$this->Session->setFlash(__('Preference settings has been Saved successfully!'),'default',array('class'=>'message'));
			$this->redirect(array("controller" => "Preferences", "action" => "index", "admin" => true));
		}

		$facility = $this->Facility->read(null,$this->Session->read('facilityid'));
		$this->set("data",unserialize($facility['Facility']['preference']));
	}
	public function preferencecard($patientid=null,$type=null)
	{
		$this->layout = "default";
		//$this->layout = "ajax";
		//debug($patientid);
		$this->patient_info($patientid);
		$this->Preferencecard->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id=Preferencecard.doctor_id')),
						'Surgery'=>array('foreignKey'=>false,'fields'=>array('Surgery.name'),'conditions'=>array('Surgery.id=Preferencecard.procedure_id'))
				)),false);
		$getData=$this->Preferencecard->find('all',array('conditions'=>array('Preferencecard.patient_id'=>$patientid,'Preferencecard.is_deleted'=>0,'Preferencecard.type'=>$type)));
		//debug($getData);exit;
		$this->set("getData",$getData);
		$this->set("patientid",$patientid);

	}

	public function user_preferencecard(){
		
		$role = $this->Session->read('role');
		$array1 = array('Account Assistant','Admin');
		$isexist = in_array($role, $array1);
		if($isexist == 1){ 
			$this->patient_info($patientid);
			$this->Preferencecard->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id=Preferencecard.doctor_id')),
					),
					'hasMany'=>array('PreferencecardProcedure'=>array('foreignKey'=>'preference_card_id','conditions' => array('PreferencecardProcedure.is_deleted' => '0')),
					)),false);
			
			$getData=$this->Preferencecard->find('all',array('conditions'=>array('Preferencecard.is_deleted'=>0),'order'=>array('Preferencecard.create_time'=>'DESC')));
			$getUnserializeMed=unserialize($getData['Preferencecard']['medications']);
			
			$surgery = array();
			foreach($getData as $key=>$value){
				foreach($getData[$key]['PreferencecardProcedure'] as $prefKey=>$prefValue){ 
					$surgery[$key][] = $prefValue['procedure_id'];
				}
				$surgeryName = $this->Surgery->find('list',array('fields'=>array('Surgery.id','Surgery.name'),'conditions'=>array('Surgery.id'=>$surgery[$key],'Surgery.is_deleted'=>0)));
				$getData[$key]['Surgery'] = $surgeryName;
			}
			$this->set("getData",$getData);
			$this->set("patientid",$patientid);
		}
		if($role=='Primary Care Provider'){
			$this->patient_info($patientid);
			$this->Preferencecard->bindModel(array(
					'belongsTo' => array(
							'User' =>array('foreignKey' => false,'fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id=Preferencecard.doctor_id')),
					),
					'hasMany'=>array('PreferencecardProcedure'=>array('foreignKey'=>'preference_card_id','conditions' => array('PreferencecardProcedure.is_deleted' => '0')),
					)),false);
			
			$getData=$this->Preferencecard->find('all',array('conditions'=>array('Preferencecard.doctor_id'=> $this->Session->read('userid'),'Preferencecard.type'=>$type)));
			$surgery = array();
			foreach($getData as $key=>$value){
				foreach($getData[$key]['PreferencecardProcedure'] as $prefKey=>$prefValue){ 
					$surgery[$key][] = $prefValue['procedure_id'];
				}
				$surgeryName = $this->Surgery->find('list',array('fields'=>array('Surgery.id','Surgery.name'),'conditions'=>array('Surgery.id'=>$surgery[$key],'Surgery.is_deleted'=>0)));
				$getData[$key]['Surgery'] = $surgeryName;
			}
			$this->set("getData",$getData);
			$this->set("patientid",$patientid);
		}
	}


	public function add($patientid=null,$type=null)
	{

		$this->layout = "advance";
		//$this->layout = "ajax";

		$this->uses =array('Surgery','DoctorProfile');
		
		$this->patient_info($patientid);
		$this->set('procedure', $this->Surgery->find('list', array('fields'=> array('id', 'name'),'order' => array('Surgery.name'))));

		$this->set('doctorlist',$this->DoctorProfile->getDoctors());
		$this->set("type",$type);
		$this->set("patientid",$patientid);
	}

    
	public function delete($id = null) {

		if($id){
			$this->Preferencecard->id = $id;
			//find the bed_id

			if ($this->Preferencecard->save(array('is_deleted' => 1))) {

				$this->Session->setFlash(__('Preference card Deleted Successfully','',array('class'=>'message')));
				$this->redirect($this->referer());
			}
		}else{
			$this->Session->setFlash(__('Invalid Operation'),array('class'=>'error'));
			$this->redirect(array('action' => 'index'));
		}

	}

	
	public function print_preferencecard($id=null){
		$this->layout = 'print_with_header';
		$this->uses = array('Preferencecard','PreferencecardInstrumentitem','PreferencecardOritem','PreferencecardSpditem','PharmacyItem','PreferencecardProcedure','Surgery');
		$this->Preferencecard->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id=Preferencecard.doctor_id')),
						/*'Surgery'=>array('foreignKey'=>false,'fields'=>array('Surgery.name'),'conditions'=>array('Surgery.id=Preferencecard.procedure_id'))*/
					),
				'hasMany'=>array('PreferencecardInstrumentitem'=>array('foreignKey'=>'preferencecard_id','conditions' => array('PreferencecardInstrumentitem.is_deleted' => '0')),
						'PreferencecardSpditem'=>array('foreignKey'=>'preferencecard_id','conditions' => array('PreferencecardSpditem.is_deleted' => '0')),
						'PreferencecardOritem'=>array('foreignKey'=>'preferencecard_id','conditions' => array('PreferencecardOritem.is_deleted' => '0')),
						'PreferencecardProcedure'=>array('foreignKey'=>'preference_card_id','conditions' => array('PreferencecardProcedure.is_deleted' => '0')),
						)),false);
		
		$getData=$this->Preferencecard->find('first',array('conditions'=>array('Preferencecard.is_deleted'=>0)));
		$this->set('getData',$getData);
		$getprefcard = '';
		if(!empty($id)){
			//Get preference card details
			$getprefcard = $this->Preferencecard->find('first',array('conditions'=>array('Preferencecard.id'=>$id,'Preferencecard.location_id'=>$this->Session->read('locationid'),'Preferencecard.is_deleted' => '0')));
			$getUnserializeMed=unserialize($getprefcard['Preferencecard']['medications']);
			$getPharmacyData=$this->PharmacyItem->find('all',array('fields'=>array('PharmacyItem.*'),'conditions'=>array('PharmacyItem.id'=>$getUnserializeMed['0'],'PharmacyItem.is_deleted'=>0)));
			
			$surgeryId = array();
			foreach($getprefcard['PreferencecardProcedure'] as $surgeValue){
				if(!empty($surgeValue)){
					$surgeryId[]  = $surgeValue['procedure_id'];
				}
			}
			$this->set("getPharmacyData",$getPharmacyData);
			
			$surgeryName = $this->Surgery->find('all',array('fields'=>array('Surgery.id','Surgery.name'),'conditions'=>array('Surgery.id'=>$surgeryId)));
			//fetch data from items table
			$instrument_item=$this->PreferencecardInstrumentitem->find('all',array('conditions'=>array('PreferencecardInstrumentitem.preferencecard_id'=>$id,'PreferencecardInstrumentitem.is_deleted' => '0')));
			$spd_item=$this->PreferencecardSpditem->find('all',array('conditions'=>array('PreferencecardSpditem.Preferencecard_id'=>$id,'PreferencecardSpditem.is_deleted' => '0')));
			$or_item=$this->PreferencecardOritem->find('all',array('conditions'=>array('PreferencecardOritem.Preferencecard_id'=>$id,'PreferencecardOritem.is_deleted' => '0')));
			
			$this->set(array('getprefcard'=>$getprefcard,'instrument_item'=>$instrument_item,'spd_item'=>$spd_item,'or_item'=>$or_item,'surgeryName'=>$surgeryName));
			 
		}
		$this->set('title', __('Preference Card', true)); // THis is the title for the printout

	}//end of print Preference Card

	public function view_preference($id = null,$patientid=null) {
		$this->patient_info($patientid);
		$this->uses = array('Preferencecard','User','Surgery','PharmacyItem');
		$this->Preferencecard->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id=Preferencecard.doctor_id')),
						/*'Surgery'=>array('foreignKey'=>false,'fields'=>array('Surgery.name'),'conditions'=>array('Surgery.id=Preferencecard.procedure_id')),*/
						),
				'hasMany'=>array('PreferencecardInstrumentitem'=>array('foreignKey'=>'preferencecard_id','conditions' => array('PreferencecardInstrumentitem.is_deleted' => '0')),
						'PreferencecardSpditem'=>array('foreignKey'=>'preferencecard_id','conditions' => array('PreferencecardSpditem.is_deleted' => '0')),
						'PreferencecardOritem'=>array('foreignKey'=>'preferencecard_id','conditions' => array('PreferencecardOritem.is_deleted' => '0')),
						'PreferencecardProcedure'=>array('foreignKey'=>'preference_card_id','conditions' => array('PreferencecardProcedure.is_deleted' => '0')),
						)),false);
		
		$getData=$this->Preferencecard->find('first',array('conditions'=>array('Preferencecard.id'=>$id,'Preferencecard.is_deleted'=>0)));
		$surgeryId = array();
		foreach($getData['PreferencecardProcedure'] as $surgeValue){
			if(!empty($surgeValue)){
				$surgeryId[]  = $surgeValue['procedure_id'];
			}
		}
		$surgeryName = $this->Surgery->find('all',array('fields'=>array('id','name'),'conditions'=>array('Surgery.id'=>$surgeryId)));
		$getData['Procedure'] = $surgeryName;
		
		$getUnserializeMed=unserialize($getData['Preferencecard']['medications']);
		$getPharmacyData=$this->PharmacyItem->find('all',array('fields'=>array('PharmacyItem.*'),'conditions'=>array('PharmacyItem.id'=>$getUnserializeMed['0'],'PharmacyItem.is_deleted'=>0)));
		
		$this->set("getPharmacyData",$getPharmacyData);
		$this->set("getData",$getData);
		$this->set("patientid",$patientid);
	}// END of view preference
	
	public function edit_preference($id = null,$patientid=null) {		
		$this->layout = "advance";
		$this->patient_info($patientid);
		$this->uses = array('Preferencecard','User','Surgery','DoctorProfile','PharmacyItem','PreferencecardInstrumentitem','PreferencecardOritem','PreferencecardSpditem','PreferencecardProcedure');
		$this->Preferencecard->bindModel(array(
				'belongsTo' => array(
						'User' =>array('foreignKey' => false,'fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id=Preferencecard.doctor_id')),
						'Surgery'=>array('foreignKey'=>false,'fields'=>array('Surgery.name'),'conditions'=>array('Surgery.id=Preferencecard.procedure_id')),
				),
				'hasMany'=>array('PreferencecardInstrumentitem'=>array('foreignKey'=>'preferencecard_id','conditions' => array('PreferencecardInstrumentitem.is_deleted' => '0')),
						'PreferencecardSpditem'=>array('foreignKey'=>'preferencecard_id','conditions' => array('PreferencecardSpditem.is_deleted' => '0')),
						'PreferencecardOritem'=>array('foreignKey'=>'preferencecard_id','conditions' => array('PreferencecardOritem.is_deleted' => '0')),
						'PreferencecardProcedure'=>array('foreignKey'=>'preference_card_id','conditions' => array('PreferencecardProcedure.is_deleted' => '0')),
						)),false);
		
		
		$this->set('doctorlist',$this->DoctorProfile->getDoctors());
		$this->set('procedure', $this->Surgery->find('list', array('fields'=> array('id', 'name'),'order' => array('Surgery.name'))));
		$getData=$this->Preferencecard->find('first',array('fields'=>array('Preferencecard.*'),'conditions'=>array('Preferencecard.id'=>$id,'Preferencecard.is_deleted'=>0))); 
		$getUnserializeMed=unserialize($getData['Preferencecard']['medications']);
		$surgeryId = array();
		foreach($getData['PreferencecardProcedure'] as $surgeValue){
			if(!empty($surgeValue)){
				$surgeryId[]  = $surgeValue['procedure_id'];
			}
		}
		$surgeryName = $this->Surgery->find('all',array(
				'fields'=>array('id','name'),
				'conditions'=>array('Surgery.id'=>$surgeryId)));
		$getData['Procedure'] = $surgeryName;
		
		$getPharmacyData=$this->PharmacyItem->find('all',array('fields'=>array('PharmacyItem.*'),'conditions'=>array('PharmacyItem.id'=>$getUnserializeMed['0'],'PharmacyItem.is_deleted'=>0)));
		$this->set("getPharmacyData",$getPharmacyData);
		$this->set("getData",$getData); 
		$this->set("patientid",$patientid);
		$this->set(compact(array('drugQty','drugId','medicatn','quant','getPrefName')));
	}//end of edit preference



	public function getdeviceused(){
		$this->uses = array('DeviceUse');
		$data = $this->DeviceUse->find('list',array('fields'=> array("device_name","device_name")));

		$output ="";
		foreach ($data as $key=>$value) {
			$output .=$value."|".$key."\n";
		}
		echo $output;

		exit;
	}
	public function getspditem(){
		$this->uses = array('MedicalItem');
		$data = $this->MedicalItem->find('list',array('fields'=> array("name","name"),'conditions' => array("MedicalItem.ot_item_category_id"=>9)));

		$output ="";
		foreach ($data as $key=>$value) {
			$output .=$value."|".$key."\n";
		}
		echo $output;

		exit;
	}
	public function getoritem(){
		$this->uses = array('MedicalItem');
		$data = $this->MedicalItem->find('list',array('fields'=> array("name","name"),'conditions' => array("MedicalItem.ot_item_category_id"=>2)));

		$output ="";
		foreach ($data as $key=>$value) {
			$output .=$value."|".$key."\n";
		}
		echo $output;

		exit;
	}

	public function save_preference_card(){
		//$this->autoRender = false;
		//$this->patient_info($patientid);
		
		$this->autoRender = false;
		$this->uses = array('Preferencecard');
		if ($this->request->data) {
			if(!empty($this->request->data['Preferencecard']['id'])){
				$this->request->data["Preferencecard"]["modify_time"] = date("Y-m-d H:i:s");
				$this->request->data["Preferencecard"]["modified_by"] = $this->Session->read('userid');
				$this->request->data["Preferencecard"]["location_id"] = $this->Session->read('locationid');
			}else{
				$this->request->data["Preferencecard"]["create_time"] = date("Y-m-d H:i:s");			
				$this->request->data["Preferencecard"]["created_by"] = $this->Session->read('userid');			
				$this->request->data["Preferencecard"]["location_id"] = $this->Session->read('locationid');
			}
			
			$this->Preferencecard->insertpreference($this->request->data);		
			$this->Session->setFlash(__('Preference card has been Saved successfully!'),'default',array('class'=>'message'));
			 $this->set('flag',1);
			$this->redirect(array("controller" => "Preferences", "action" => "user_preferencecard", "admin" => false));		
		}
	}
	public function deleteItems($modelName,$preRecordId,$IDofRow){
		$this->uses=array('Preferencecard','PreferencecardInstrumentitem','PreferencecardOritem','PreferencecardSpditem');
	
		
		if($modelName=='Instruction'){		
			$this->PreferencecardInstrumentitem->updateAll(array('PreferencecardInstrumentitem.is_deleted'=>'1'),array('id'=>$preRecordId));
			exit;
		}else if($modelName=='SPD'){			
			$this->PreferencecardSpditem->updateAll(array('PreferencecardSpditem.is_deleted'=>'1'),array('id'=>$preRecordId));
			exit;
		}else if($modelName=='OR'){			
			$this->PreferencecardOritem->updateAll(array('PreferencecardOritem.is_deleted'=>'1'),array('id'=>$preRecordId));
			exit;
		}else if($modelName=='MED'){		
			$getPreferenceData=$this->Preferencecard->find('first',array('fields'=>array('medications','quantity'),'conditions'=>array('id'=>$preRecordId)));
			/****BOF-For Deleting Medications******/
			$expUnserMedData=unserialize($getPreferenceData['Preferencecard']['medications']);		
			foreach($expUnserMedData['0'] as $keyMed=>$getMedData){
				if($keyMed==$IDofRow){
					unset($expUnserMedData['0'][$keyMed]);
				}
				
			}
			
			$expserMedData=serialize($expUnserMedData);			
			/****EOF-For Deleting Medications******/
			
			/****BOF-For Deleting quantity******/
			$expUnserQtyData=unserialize($getPreferenceData['Preferencecard']['quantity']);
			foreach($expUnserQtyData['0'] as $keyQty=>$getQtyData){
				if($keyQty==$IDofRow){
					unset($expUnserQtyData['0'][$keyQty]);
				}
			
			}
		
			$expserQtyData=serialize($expUnserQtyData);					
			/****EOF-For Deleting quantity******/
			$getPrefData=$this->Preferencecard->updateAll(array('Preferencecard.medications'=>"'".$expserMedData."'",'Preferencecard.quantity'=>"'".$expserQtyData."'"),array('Preferencecard.id'=>$preRecordId));
			exit;
		}else{
	
		}
	
	}
}