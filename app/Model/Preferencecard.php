<?php

App::uses('AppModel', 'Model');
/**
 * CollaborateCompany Model
 *
 * @property Patient $Patient
*/
class Preferencecard extends AppModel {

	public $specific = true;
	public $name = 'Preferencecard';
	var $useTable = 'preferencecards';

	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	public function insertpreference($data=array()){
		
      		$session = new cakeSession();
      		$preferencecard	= ClassRegistry::init('Preferencecard');      	
      		$preferencecard_instrumentitems=ClassRegistry::init('PreferencecardInstrumentitem');
			$preferencecard_oritems=ClassRegistry::init('PreferencecardOritem');
			$preferencecard_spditems=ClassRegistry::init('PreferencecardSpditem');	
			$preferencecard_procedure=ClassRegistry::init('PreferencecardProcedure');
			
			//$data['Preferencecard']['medications'] = serialize(array($data['drug_id']));
			$data['Preferencecard']['medications'] = serialize(array($data['drug_id']));	
			$data['Preferencecard']['quantity'] = serialize(array($data['medqt']));
			$preferencecard->save($data);
			
			$last_insert_id = $preferencecard->getInsertID();		
      			
      		//BOF check and insert drugs
		//	debug($data);exit;
			foreach($data['instrument'] as $keyInstr =>$valueInstr){
				if(!empty($valueInstr)){
					if(!empty($data['PreferencecardInstrumentitemid'][$keyInstr])){
						$updateInstr['PreferencecardInstrumentitem']['preferencecard_id'] = "'".$data['Preferencecard']['id']."'";
						$updateInstr['PreferencecardInstrumentitem']['item_name'] = "'".$data['instrument'][$keyInstr]."'";
						$updateInstr['PreferencecardInstrumentitem']['modify_time'] = "'".date("Y-m-d H:i:s")."'";
						$updateInstr['PreferencecardInstrumentitem']['modified_by'] = "'".AuthComponent::user('id')."'";						
						$preferencecard_instrumentitems->updateAll($updateInstr['PreferencecardInstrumentitem'],array('PreferencecardInstrumentitem.id'=>$data['PreferencecardInstrumentitemid'][$keyInstr]));
					}else{
						//,'modify_time'=> $data['Preferencecard']['modify_time'],'modified_by'=> $data['Preferencecard']['modified_by']
						if(empty($last_insert_id)){
							$last_insert_id=$data['Preferencecard']['id'];
						}
						$preferencecard_instrumentitems->save(array('preferencecard_id'=>$last_insert_id,'item_name'=>$valueInstr,'create_time'=>$data['Preferencecard']['create_time'],'created_by'=> $data['Preferencecard']['created_by']));
						$preferencecard_instrumentitems->id="";						
					}
					 
				}
			}
			
      		foreach($data['spd'] as $key =>$value){			
      			if(!empty($value)){  
      				if(!empty($data['PreferencecardSpditemid'][$key])){ 	
      				$updateSpd['PreferencecardSpditem']['preferencecard_id'] = "'".$data['Preferencecard']['id']."'";
      				$updateSpd['PreferencecardSpditem']['item_name'] = "'".$data['spd'][$key]."'";
      				$updateSpd['PreferencecardSpditem']['quantity'] = "'".$data['spdqt'][$key]."'";
      				$updateSpd['PreferencecardSpditem']['modify_time'] = "'".date("Y-m-d H:i:s")."'";
      				$updateSpd['PreferencecardSpditem']['modified_by'] = "'".AuthComponent::user('id')."'";
      				$preferencecard_spditems->updateAll($updateSpd['PreferencecardSpditem'],array('PreferencecardSpditem.id'=>$data['PreferencecardSpditemid'][$key]));
      				}else{	
      				//,'modify_time'=> $data['Preferencecard']['modify_time'],'modified_by'=> $data['Preferencecard']['modified_by']	
      				if(empty($last_insert_id)){
      					$last_insert_id=$data['Preferencecard']['id'];
      				}		      				
						$preferencecard_spditems->save(array('preferencecard_id'=>$last_insert_id,'item_name'=>$value,'quantity'=>$data['spdqt'][$key],'create_time'=>$data['Preferencecard']['create_time'],'created_by'=> $data['Preferencecard']['created_by'])); 
						$preferencecard_spditems->id="";
      				}
	      				
	      			}      			
			}	     			
      		
			//debug($data);exit;
			foreach($data['or'] as $key =>$value){
				if(!empty($value)){
			if(!empty($data['PreferencecardOritemid'][$key])){ 	
      				$updateOr['PreferencecardOritem']['preferencecard_id'] = "'".$data['Preferencecard']['id']."'";
      				$updateOr['PreferencecardOritem']['item_name'] = "'".$data['or'][$key]."'";
      				$updateOr['PreferencecardOritem']['quantity'] = "'".$data['orqt'][$key]."'";
      				$updateOr['PreferencecardOritem']['modify_time'] = "'".date("Y-m-d H:i:s")."'";
      				$updateOr['PreferencecardOritem']['modified_by'] = "'".AuthComponent::user('id')."'";
      				$preferencecard_oritems->updateAll($updateOr['PreferencecardOritem'],array('PreferencecardOritem.id'=>$data['PreferencecardOritemid'][$key]));
      				}else{	
      				//,'modify_time'=> $data['Preferencecard']['modify_time'],'modified_by'=> $data['Preferencecard']['modified_by']	
      				if(empty($last_insert_id)){
      					$last_insert_id=$data['Preferencecard']['id'];
      				}		      		
      					$preferencecard_oritems->save(array('preferencecard_id'=>$last_insert_id,'item_name'=>$value,'quantity'=>$data['orqt'][$key],'create_time'=>$data['Preferencecard']['create_time'],'created_by'=> $data['Preferencecard']['created_by'])); 
						$preferencecard_oritems->id="";
	      				
	      			}  
				}    			
	      			 		     			
      			}
				
			foreach($data['procedure_id'] as $key =>$value){
				if(!empty($value)){ 
					if(!empty($data['PreferencecardProcedureid'][$key])){ 	
	      				$updateProcedure['PreferencecardProcedure']['preference_card_id'] = $data['Preferencecard']['id'];
	      				$updateProcedure['PreferencecardProcedure']['procedure_id'] = $data['procedure_id'][$key];
	      				$updateProcedure['PreferencecardProcedure']['modified_time'] = "'".date("Y-m-d H:i:s")."'";
	      				$updateProcedure['PreferencecardProcedure']['created_by']= $session->read('userid');
	      				$preferencecard_procedure->updateAll($updateProcedure['PreferencecardProcedure'],array('PreferencecardProcedure.id'=>$data['PreferencecardProcedureid'][$key]));
      				}else{	
	      				if(empty($last_insert_id)){
	      					$last_insert_id=$data['Preferencecard']['id'];
      					}		      		
      					$preferencecard_procedure->save(array('preference_card_id'=>$last_insert_id,'procedure_id'=>$value,'create_time'=>$data['Preferencecard']['create_time'],'created_by'=> $data['Preferencecard']['created_by'])); 
						$preferencecard_procedure->id="";
	      			}  
				}    			
	      	}
      		return $last_insert_id;
      		//EOF check and insert drugs     		    		
      }
	
}
?>