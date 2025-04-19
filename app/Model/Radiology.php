<?php
/**
 * Radiology model
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       LaboratoryParameter Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanjari
 * @functions 	 : AED radiolody test	
 */

class Radiology extends AppModel {
	public $name = 'Radiology';
	
	public $validate = array(
		'name' => array(
		'rule' => array('checkUnique'), 
		'message' => "This name is already taken ,Please try another name"
		) 
	 );
	 
	public function checkUnique($check){
                //$check will have value: array('name' => 'some-value')
                $session = new cakeSession();
                if(isset($this->data['Radiology']['id'])){
                	$extraContions = array('is_deleted' => 0,'id !='=>$this->data['Radiology']['id'],'Radiology.location_id'=>$session->read('locationid'));
                }else{
                	$extraContions = array('is_deleted' => 0);
                }
                
                $conditonsval = array_merge($check,$extraContions);
                $countUser = $this->find( 'count', array('conditions' => $conditonsval, 'recursive' => -1) );
                if($countUser >0) {
                  return false;
                } else {
                  return true;
                }
        }
               
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
	function insertRadioTest($data=array()){
			$session = new cakeSession();
		    $data['Radiology']['location_id'] = $session->read('locationid');
			if(empty($data['Radiology']['id'])){
				$data['Radiology']['created_by'] = $session->read('userid');
				$data['Radiology']['create_time'] = date("Y-m-d H:i:s");
			}else{
				  
				$data['Radiology']['modified_by'] = $session->read('userid');
				$data['Radiology']['modify_time'] = date("Y-m-d H:i:s");
			}  
			$result =  $this->save($data['Radiology']); 
			return $result ;
	}
	function insertRad($data =array()){
		$RadiologyTestOrder= ClassRegistry::init('RadiologyTestOrder');     
		
		$session = new cakeSession();
		$this->deleteAll(array('Radiology.is_orderset'=>'1',false));
		for($i=0;$i<count($data['Radiology']['name']);$i++){
			if($data['Radiology']['name'][$i]!='0'){
				//$this->create();
				$arrayT = array('name'=>$data['Radiology']['name'][$i],'is_orderset'=>'1') ;			 
				$res = $this->save($arrayT);
				if($res){ 
					$lastinsid=$this->getLastInsertID();				  
					$RadiologyTestOrder->saveAll(array('radiology_id'=>$lastinsid,'patient_id'=>$data[patientid]));
					$this->id='';
				}
			}
		}
	
		return true;
	}
	
	//function to return lab charges as per hospital type
	//By aditya
	function getRate($id,$tariffId = null){
		$session = new cakeSession();
		$hospitalType = $session->read('hospitaltype');
		$this->bindModel(array(
				'belongsTo' => array(
						'TariffList'=>array('foreignKey'=>false,'conditions'=>'Radiology.tariff_list_id=TariffList.id'),
						'TariffAmount'=>array('foreignKey'=>false,'conditions'=>array('TariffAmount.tariff_list_id=TariffList.id','TariffAmount.tariff_standard_id'=>$tariffId)),
				)));
		if($hospitalType=='NABH'){
			$getPrice1=$this->find('first',array('fields'=>array('TariffAmount.nabh_charges'),
					'conditions'=>array('Radiology.id'=>$id,'Radiology.location_id'=>$session->read('locationid'))));
			$rate = $getPrice1['TariffAmount']['nabh_charges'];
		}else{
			$getPrice1=$this->find('first',array('fields'=>array('TariffAmount.non_nabh_charges'),
					'conditions'=>array('Radiology.id'=>$id,'Radiology.location_id'=>$session->read('locationid'))));
			$rate = $getPrice1['TariffAmount']['non_nabh_charges'];
		}
	
		return $rate;
	}
	
	/* this function use for imprt the data in the master-vadodara*/
	function importData(&$dataOfSheet){
		ini_set('max_execution_time', 900);
		$service_category = Classregistry::init('ServiceCategory');
		$service_sub_category = Classregistry::init('ServiceSubCategory');
		$tariff_list = Classregistry::init('TariffList');
		$tariff_amount = Classregistry::init('TariffAmount');
		$tariff_amt_type = Classregistry::init('TariffAmountType');
		$tariff_standard = Classregistry::init('TariffStandard');
	
		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		//$dataOfSheet->sheet=2;
		$dataOfSheet->table_class='excel';
		$noOfSheets = count($dataOfSheet->sheets) ;
		if($noOfSheets ==0) $dataOfSheet->sheets  =  1 ;
	
		
			for($s=0;$s<$noOfSheets;$s++){
				$dataOfSheet->sheet = $s ;
				for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
				$category_id= "";
				$sub_category_id="";
				$tariff_standard_id="";
				$tariff_list_id ="";
				$serviceC = trim($dataOfSheet->val($row,1,$dataOfSheet->sheet));
				$serviceSC = trim($dataOfSheet->val($row,2,$dataOfSheet->sheet));
				$service = addslashes(trim($dataOfSheet->val($row,3,$dataOfSheet->sheet)));
				if(!$service) continue ;
				$opd_charge=trim($dataOfSheet->val($row,4,$dataOfSheet->sheet));
				$gen_ward_charge=trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));
				$semi_ward_charge=trim($dataOfSheet->val($row,6,$dataOfSheet->sheet));
				$spcl_ward_charge=trim($dataOfSheet->val($row,7,$dataOfSheet->sheet));
				$dlx_ward_charge=trim($dataOfSheet->val($row,8,$dataOfSheet->sheet));
				$tariff_code=trim($dataOfSheet->val($row,9,$dataOfSheet->sheet));
				//$serviceShort = addslashes(trim($dataOfSheet->val($row,3,$dataOfSheet->sheet)));
				//$cpt = trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));
				//$tariffS = trim($dataOfSheet->val($row,10,$dataOfSheet->sheet));
				//$cghs = trim($dataOfSheet->val($row,4,$dataOfSheet->sheet));
				//$apply_in_day =trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));
				//$moa = trim($dataOfSheet->val($row,11,$dataOfSheet->sheet));		
				//$chargeNabh = trim($dataOfSheet->val($row,13,$dataOfSheet->sheet));
				//$chargeNonNabh = trim($dataOfSheet->val($row,12,$dataOfSheet->sheet));
				//$cdmCode = trim($dataOfSheet->val($row,16,$dataOfSheet->sheet));
				//$validity = trim($dataOfSheet->val($row,14,$dataOfSheet->sheet));
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
				//$cost_pvt = trim($dataOfSheet->val($row,6,$dataOfSheet->sheet));
				//$cost_cghs = trim($dataOfSheet->val($row,11,$dataOfSheet->sheet));
				//$cost_other = trim($dataOfSheet->val($row,10,$dataOfSheet->sheet)); 
	
			/* 	if(empty($cpt))
					$cpt = "";
				if(empty( $cghs))
					$cghs = "";
				if(empty($moa))
					$moa = "";
				if(empty($chargeNabh))
					$chargeNabh = "0.00";
				if(empty($chargeNonNabh))
					$chargeNonNabh = "0.00"; */
		     if(empty($validity))
					$validity = "1";
	
				//$chargeNonNabh = $cost_pvt;
					
	
	
				//find service group if exist 
			    $category = $service_category->find("first",array("conditions" =>array("ServiceCategory.name"=>$serviceC,
			    		"ServiceCategory.location_id"=>$session->read('locationid'),
			    		"ServiceCategory.is_deleted" => '0')));
			    
				
				if(!empty($category)){
					$category_id = $category['ServiceCategory']['id']; //already exist 
				}else{
					//or insert SC
					$service_category->create();
					$service_category->save(array("name"=>$serviceC,'location_id'=>$session->read('locationid'),"is_view"=>"1","create_time"=> $createtime,"created_by"=>$createdby));
					$category_id = $service_category->id;
				} 
	
				/* for Tariff Sub Category*/
	    	    $subcategory = $service_sub_category->find("first",array("conditions" =>array("ServiceSubCategory.name"=>$serviceSC,
						"ServiceSubCategory.service_category_id"=>$category_id,
	    	    		"ServiceSubCategory.is_deleted"=>'0')));
				
				if(!empty($subcategory)){
					$sub_category_id = $subcategory['ServiceSubCategory']['id'];
				}else{
					$service_sub_category->create();
					$service_sub_category->save(array("name"=>$serviceSC,'location_id'=>$session->read('locationid'),"is_view"=>"1","service_category_id"=>$category_id,"create_time"=> $createtime,"created_by"=>$createdby));
					$sub_category_id = $service_sub_category->id;
				}
				
				/* for Tariff Standard*/
				/* $tariff = $tariff_standard->find("first",array("conditions" =>array("TariffStandard.name"=>$tariffS,
						"TariffStandard.location_id"=>$session->read('locationid'))));
				
				if(!empty($tariff)){
					$tariff_standard_id = $tariff['TariffStandard']['id'];
				}else{
					$tariff_standard->create();
					$tariff_standard->save(array("name"=>$tariffS,'location_id'=>$session->read('locationid'),"create_time"=> $createtime,
							"created_by"=>$createdby));
					$tariff_standard_id = $tariff_standard->id;
				} */
	
				/* for Tariff List/ For mapping lab charges have to create one service with same name as rad*/
				$tariffList = $tariff_list->find("first",array("conditions" =>array("TariffList.name"=>$service,
						"TariffList.service_category_id"=>$category_id,"TariffList.service_sub_category_id"=>$sub_category_id,
						"TariffList.location_id"=>$session->read('locationid'))));
				 
				if(!empty($tariffList)){
					$tariff_list_id = $tariffList['TariffList']['id'];
				}else{
					$tariff_list->create();
					$tariff_list->save(array(	
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"service_category_id"=>$category_id,
							"service_sub_category_id"=>$sub_category_id,	
							"apply_in_a_day" =>$validity,
							"create_time"=> $createtime,
							"created_by"=>$createdby
							//"price_for_private"=>$cost_pvt,
							//"price_for_cghs"=>$cost_cghs,
							//"price_for_other"=>(!empty($cost_other))?$cost_other:0,
							//"cghs_code"=>$cghs,
							//"cbt"=>$cpt,
							//"cdm" => $cdmCode,
							//"short_name" =>  $serviceShort,
					));
					$tariff_list_id = $tariff_list->id;
				} 
	
					
					$radiology = Classregistry::init('Radiology');
					
					$locationId = '1';
					
					$radiology->set('name',$service);
					$radiology->set('location_id',$locationId);
					$radiology->set('is_deleted','0');
					$radiology->set('is_active','1');
					$radiology->set('tariff_standard_id',$tariff_standard_id); //need to confirm with pawana , y we need tariff standard id in lab
					$radiology->set('tariff_list_id',$tariff_list_id);
					$radiology->set('test_group_id',$category_id);
					$radiology->set('service_group_id',$category_id);
					$radiology->set('cpt_code',$cpt);
					$radiology->save();
					$radiology->id = '';
					$radiology->set('id','');
	
						
					//BOF tariff amount
					$tariffStandardArray  =array('0'=>'7','1'=>'41','2'=>'16','3'=>'34','4'=>'35',
					 '5'=>'36','6'=>'37','7'=>'38','8'=>'39','9'=>'5','10'=>'40','11'=>'43','12'=>'44','13'=>'45' ) ;
					
				/*	$tariffStandardArray  =array('0'=>'7','1'=>'43','2'=>'16','3'=>'92','4'=>'93',
					 '5'=>'94','6'=>'96','7'=>'95','8'=>'98','9'=>'5','10'=>'97','11'=>'29','12'=>'15','13'=>'28' ) ;*/
					
					/* 	$tariffStandardArray  =array('43'=>'Maa Yojna','91'=>'ECHS','92'=>'ONGC','93'=>'IOCL','94'=>'GNFC',
					 '96'=>'REL','95'=>'KANDLA','98'=>'HEAVY W','5'=>'BSNL','97'=>'ROTARY','140'=>'general') ; */
					
					$hospitalType = $session->read('hospitaltype');
	
					$check_ward_amount = $tariff_amt_type->find("first",array("conditions"=>array(
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>$tariffStandardArray[$s]
					)));
					
					$check_edit_amount = $tariff_amount->find("first",array("conditions"=>array(
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>$tariffStandardArray[$s]
					)));
	
					if($hospitalType=='NABH'){
						$chargeNabh = trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));
						$chargeNonNabh=0;
					}else{
						$chargeNonNabh = trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));;
						$chargeNabh=0;
					}
					/* for Tariff Amount*/
					
					if(!empty($check_ward_amount)){
						$tariff_amt_type->save(array(
								"id"=>$check_ward_amount['TariffAmountType']['id'],
								"opd_charge"=>$opd_charge,
								"general_ward_charge"=>$gen_ward_charge,
								"special_ward_charge"=>$spcl_ward_charge,
								"semi_special_ward_charge"=>$semi_ward_charge,
								"delux_ward_charge"=>$dlx_ward_charge,
								"code"=>$tariff_code,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
					}else{
						$tariff_amt_type->create();
						$tariff_amt_type->save(array(
								"location_id"=>$session->read('locationid'),
								"tariff_list_id"=>$tariff_list_id,
								"tariff_standard_id"=>$tariffStandardArray[$s],
								"opd_charge"=>$opd_charge,
								"general_ward_charge"=>$gen_ward_charge,
								"special_ward_charge"=>$spcl_ward_charge,
								"semi_special_ward_charge"=>$semi_ward_charge,
								"delux_ward_charge"=>$dlx_ward_charge,
								"code"=>$tariff_code,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
					}
					$tariff_amt_type->id =  '' ;
					
					if(!empty($check_edit_amount)){
						$tariff_amount->save(array(
								"id"=>$check_edit_amount['TariffAmount']['id'],
								"nabh_charges"=>$chargeNabh,
								"non_nabh_charges"=>$chargeNonNabh,
								"moa_sr_no"=>$moa,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
					}else{
						$tariff_amount->create();
						$tariff_amount->save(array(
								"location_id"=>$session->read('locationid'),
								"tariff_list_id"=>$tariff_list_id,
								"tariff_standard_id"=>$tariffStandardArray[$s],
								"nabh_charges"=>$chargeNabh,
								"non_nabh_charges"=>$chargeNonNabh,
								"moa_sr_no"=>$moa,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
					}
	
				}
			}
		
	}

	
	// added for only kanpur instance--Atulc
function importDataGlobus(&$dataOfSheet){
		$service_category = Classregistry::init('ServiceCategory');
		$service_sub_category = Classregistry::init('ServiceSubCategory');
		$tariff_list = Classregistry::init('TariffList');
		$tariff_amount = Classregistry::init('TariffAmount');
		$tariff_standard = Classregistry::init('TariffStandard');
		$radiology = Classregistry::init('Radiology');
	
		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
	
		try
		{
			for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
				$category_id= "";
				$tariff_standard_id="";
				$tariff_list_id ="";
				$rad_id="";
				$serviceCode = trim($dataOfSheet->val($row,1,$dataOfSheet->sheet));
				$serviceC = trim($dataOfSheet->val($row,4,$dataOfSheet->sheet));
				$service = addslashes(trim($dataOfSheet->val($row,2,$dataOfSheet->sheet)));
				if(!$service) continue ;
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
				if(empty($validity))
					$validity = "1";
	
				//find service group if exist
				$category = $service_category->find("first",array("conditions" =>array("ServiceCategory.name"=>$serviceC,
						"ServiceCategory.location_id"=>$session->read('locationid'),
						"ServiceCategory.is_deleted"=>'0'
						)));
	
	
				if(!empty($category)){
					$category_id = $category['ServiceCategory']['id']; //already exist
				}else{
					//or insert SC
					$service_category->create();
					$service_category->save(array("name"=>$serviceC,'location_id'=>$session->read('locationid'),"is_view"=>"1","create_time"=> $createtime,"created_by"=>$createdby));
					$category_id = $service_category->id;
				}
	
	
				/* for Tariff List/ For mapping lab charges have to create one service with same name as lab*/
				$tariffList = $tariff_list->find("first",array("conditions" =>array("TariffList.name"=>$service,
						"TariffList.service_category_id"=>$category_id,
						"TariffList.location_id"=>$session->read('locationid'))));
	
				if(!empty($tariffList)){
					$tariff_list_id = $tariffList['TariffList']['id'];
					$tariff_list->save(array(
							'id'=>$tariff_list_id,
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"service_category_id"=>$category_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
				}else{
					$tariff_list->create();
					$tariff_list->save(array(
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"service_category_id"=>$category_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					$tariff_list_id = $tariff_list->id;
				}
	
				$rad = $radiology->find("first",array("conditions" =>array("Radiology.name"=>$service,
						"Radiology.service_group_id"=>$category_id,
						"Radiology.location_id"=>$session->read('locationid'))));
				if(!empty($rad)){
					$rad_id = $rad['Radiology']['id'];
					$radiology->save(array(
							"id"=>$rad_id,
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"is_deleted"=>"0",
							"is_active"=>"1",
							"service_group_id"=>$category_id,
							"tariff_list_id"=>$tariff_list_id,
							"test_group_id"=>$category_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
				}else{
					$radiology->create();
					$radiology->save(array(
				
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"is_deleted"=>"0",
							"is_active"=>"1",
							"service_group_id"=>$category_id,
							"tariff_list_id"=>$tariff_list_id,
							"test_group_id"=>$category_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					$rad_id = $radiology->id;
				}
					
				$hospitalType = $session->read('hospitaltype');
	
				
					$check_edit_amount = $tariff_amount->find("first",array("conditions"=>array(
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>'20'
					)));
						
					if($hospitalType=='NABH'){
						$chargeNabh = trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));
						$chargeNonNabh=0;
					}else{
						$chargeNonNabh = trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));;
						$chargeNabh=0;
					}
					/* for Tariff Amount*/
					if(!empty($check_edit_amount)){
						$tariff_amount->save(array(
								"id"=>$check_edit_amount['TariffAmount']['id'],
								"nabh_charges"=>$chargeNabh,
								"non_nabh_charges"=>$chargeNonNabh,
								"tariff_standard_id"=>'20',
								"moa_sr_no"=>$moa,
								"service_code"=>$serviceCode,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
					}else{
						$tariff_amount->create();
						$tariff_amount->save(array(
								"location_id"=>$session->read('locationid'),
								"tariff_list_id"=>$tariff_list_id,
								"tariff_standard_id"=>'20',
								"nabh_charges"=>$chargeNabh,
								"non_nabh_charges"=>$chargeNonNabh,
								"service_code"=>$serviceCode,
								"moa_sr_no"=>$moa,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
					}
					$tariff_amount->id =  '' ;
				
			}
	
			return true;
		}catch(Exception $e){
			 
			return false;
		}
	
	
	}
	/**
	 * afterSave function for saving data in account table--Amit
	 *
	 **/
	// these services already saved in tarifflist model thats by its not needed ---commented by amit jain
	/* public function afterSave($created)
	{
		//For generating account code for account table
		$session = new CakeSession();
		$getAccount = Classregistry::init('Account');
		$count = $getAccount->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$session->read('locationid'))));
		$count++ ; //count currrent entry also
		if($count==0){
			$count = "001" ;
		}else if($count < 10 ){
			$count = "00$count"  ;
		}else if($count >= 10 && $count <100){
			$count = "0$count"  ;
		}
		$month_array = array('A','B','C','D','E','F','G','H','I','J','K','L');
		//find the Hospital name.
		$hospital = $session->read('facility');
		//creating patient ID
		$unique_id   = 'RAD';
		$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
		$unique_id  .= strtoupper(substr($session->read('location'),0,2));//first 2 letter of d location
		$unique_id  .= date('y'); //year
		$unique_id  .= $month_array[date('n')-1];//first letter of month
		$unique_id  .= date('d');//day
		$unique_id .= $count;
		if($created){
			if($this->data['Radiology']['is_deleted']==1){
				return ; //return if delete
			}
			$this->data['Account']['create_time']=date("Y-m-d H:i:s");
			$this->data['Account']['account_code']=$unique_id;
			$this->data['Account']['status']='Active';
			$this->data['Account']['name']=$this->data['Radiology']['name'];
			$this->data['Account']['user_type']='Radiology';
			$this->data['Account']['system_user_id']=$this->data['Radiology']['id'];
			$this->data['Account']['location_id']=$session->read('locationid');
			$this->data['Account']['accounting_group_id']='3';
			$getAccount->save($this->data['Account']);
		}else{
			$var=$getAccount->find('first',array('fields'=>array('id'),'conditions'=>array('system_user_id'=>$this->data['Radiology']['id'],'user_type'=>'Radiology')));
			//avoid delete updatation
			if($this->data['Radiology']['is_deleted']==1){
				$getAccount->updateAll(array('is_deleted'=>1), array('Account.system_user_id' => $this->data['Radiology']['id'],'Account.user_type'=>'Radiology'));
				return ;
			}
			if(empty($var['Account']['id']))
			{
				$this->data['Account']['account_code']=$unique_id;
				$this->data['Account']['create_time']=date("Y-m-d H:i:s");
				$this->data['Account']['status']='Active';
			}
			$this->data['Account']['name']=$this->data['Radiology']['name'];
			$this->data['Account']['user_type']='Radiology';
			$this->data['Account']['system_user_id']=($this->data['Radiology']['id'])?$this->data['Radiology']['id']:$this->id;
			$this->data['Account']['accounting_group_id']='3';
			$this->data['Account']['id']=$var['Account']['id'];
			$this->data['Account']['modify_time']=date("Y-m-d H:i:s");
			$this->data['Account']['location_id'] = $session->read('locationid');
			$getAccount->save($this->data['Account']);
		}
	}
	 */
	
	// temp import function for hope hospital--Atulc
	function importDataHope(&$dataOfSheet,$tariff=Null){
		$service_category = Classregistry::init('ServiceCategory');
		$service_sub_category = Classregistry::init('ServiceSubCategory');
		$tariff_list = Classregistry::init('TariffList');
		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
		
	for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
				$category_id= "";
				$sub_category_id="";
				$tariff_standard_id="";
				$tariff_list_id ="";
				$serviceC = trim($dataOfSheet->val($row,1,$dataOfSheet->sheet));
				$serviceSC = trim($dataOfSheet->val($row,2,$dataOfSheet->sheet));
				$tariffId = trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));
				$service = addslashes(trim($dataOfSheet->val($row,4,$dataOfSheet->sheet)));
				if(!$service) continue ;
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
				/*if(empty($validity))
				$validity = "1";*/
	
				//find service group if exist
				$category = $service_category->find("first",array("conditions" =>array("ServiceCategory.name"=>$serviceC,
						"ServiceCategory.location_id"=>$session->read('locationid'),
						"ServiceCategory.is_deleted"=>'0'
				)));
	
	
				if(!empty($category)){
					$category_id = $category['ServiceCategory']['id']; //already exist
				}else{
					//or insert SC
					$service_category->create();
					$service_category->save(array("name"=>$serviceC,'location_id'=>$session->read('locationid'),"is_view"=>"1","create_time"=> $createtime,"created_by"=>$createdby));
					$category_id = $service_category->id;
				}
	
				/* for Tariff Sub Category*/
				
				$subcategory = $service_sub_category->find("first",array("conditions" =>array("ServiceSubCategory.name"=>$serviceSC,
				 			"ServiceSubCategory.service_category_id"=>$category_id,'ServiceSubCategory.is_deleted'=>'0')));
			
				  if(!empty($subcategory)){
					$sub_category_id = $subcategory['ServiceSubCategory']['id'];
					}else{
					$service_sub_category->create();
					$service_sub_category->save(array("name"=>$serviceSC,'location_id'=>$session->read('locationid'),"is_view"=>"1","service_category_id"=>$category_id,"create_time"=> $createtime,"created_by"=>$createdby));
					$sub_category_id = $service_sub_category->id;
					}
				
				$tariff_list->updateAll(array('service_sub_category_id'=>$sub_category_id,'create_time'=>"'".$createtime."'",'created_by'=>$createdby), array('TariffList.id' => $tariffId,'TariffList.name'=>$service,"TariffList.service_category_id"=>$category_id));
				
				/* for Tariff List/ For mapping rad charges have to create one service with same name as rad*/
			/*	$tariffList = $tariff_list->find("first",array("conditions" =>array('TariffList.id'=>$tariffId,"TariffList.name"=>$service,
						"TariffList.service_category_id"=>$category_id,
						"TariffList.location_id"=>$session->read('locationid'))));*/
				
				
	
			/*	if(!empty($tariffList)){
					$tariff_list_id = $tariffList['TariffList']['id'];
				}else{
					//$tariff_list->create();
					$tariff_list->save(array(
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"service_category_id"=>$category_id,
							"service_sub_category_id"=>$sub_category_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					//$tariff_list_id = $tariff_list->id;
				}
	*/
				
			/*	$rad = $radiology->find("first",array("conditions" =>array("Radiology.name"=>$service,
						"Radiology.service_group_id"=>$category_id,
						"Radiology.location_id"=>$session->read('locationid'))));
				if(!empty($rad)){
					$rad_id = $rad['Radiology']['id'];
				}else{
					$radiology->create();
					$radiology->save(array(
	
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							"is_deleted"=>"0",
							"is_active"=>"1",
							"service_group_id"=>$category_id,
							"tariff_list_id"=>$tariff_list_id,
							"test_group_id"=>$category_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					$rad_id = $radiology->id;
				}
*/
			}
	
		}
		 /**
	 	 * function to get Radiology details
		 * @param  int $ids --> id;
		 * @return array
		 * @author  Mahalaxmi
		 */  
		public function findRadiologyListByIds($ids=array()){
			return $this->find('list',array('fields'=>array('id','name'),'conditions'=>array('id'=>$ids)));
		}
		 /**
	 	 * function to get Radiology List		
		 * @return list
		 * @author  Mahalaxmi
		 */  
		public function findRadiologyList(){
			return $this->find('list',array('fields'=>array('id','name')));
		}

		public function getRateAndDiscount($id,$tariffId = null) {

		$session = new cakeSession ();
		$hospitalType = $session->read ( 'hospitaltype' );
		$returnArrray =array();
		$this->bindModel ( array (
				'belongsTo' => array (
						'TariffList' => array (
								'foreignKey' => false,
								'conditions' => 'Radiology.tariff_list_id=TariffList.id'
						),
						'TariffAmount' => array (
								'foreignKey' => false,
								'conditions' => array('TariffAmount.tariff_list_id=TariffList.id','TariffAmount.tariff_standard_id'=>$tariffId)
						)
				)
		) );

		if ($hospitalType == 'NABH') {
			$getPrice = $this->find ( 'first', array (
					'fields' => array (
							'TariffAmount.nabh_charges','TariffAmount.standard_tariff'
					),
					'conditions' => array (
							'Radiology.id' => $id,
							
					)
			) );

       
			$returnArrray['amount']= $getPrice['TariffAmount']['nabh_charges'];
            $returnArrray['discount']= $getPrice['TariffAmount']['standard_tariff'];
		} else {
			$getPrice = $this->find ( 'first', array (
					'fields' => array (
							'TariffAmount.non_nabh_charges','TariffAmount.standard_tariff'
					),
					'conditions' => array (
							'Radiology.id' => $id,
							
					)
			) );	
			$returnArrray['amount'] = $getPrice['TariffAmount']['non_nabh_charges'];
	        $returnArrray['discount'] = $getPrice['TariffAmount']['standard_tariff'];		
		}
		return $returnArrray;
	}
		
}