<?php
class Tariff extends AppModel {

	public $name = 'Tariff';

	public $useTable = false;

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	/* this function use for imprt the data in the master, only for vadodara-atul*/
	function importData(&$dataOfSheet){
		ini_set('max_execution_time', 900);
		$service_category = Classregistry::init('ServiceCategory');
		$service_sub_category = Classregistry::init('ServiceSubCategory');
		$tariff_list = Classregistry::init('TariffList');
		$tariff_amount = Classregistry::init('TariffAmount');
		$tariff_standard = Classregistry::init('TariffStandard');
		$tariff_amt_type = Classregistry::init('TariffAmountType');

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
					$service = addslashes(trim($dataOfSheet->val($row,2,$dataOfSheet->sheet)));
					if(!$service) continue ;
					$opd_charge=trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));
					$gen_ward_charge=trim($dataOfSheet->val($row,4,$dataOfSheet->sheet));
					$semi_ward_charge=trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));
					$spcl_ward_charge=trim($dataOfSheet->val($row,6,$dataOfSheet->sheet));
					$dlx_ward_charge=trim($dataOfSheet->val($row,7,$dataOfSheet->sheet));
					$isolation_ward_charge=trim($dataOfSheet->val($row,8,$dataOfSheet->sheet));
					$tariff_code=trim($dataOfSheet->val($row,9,$dataOfSheet->sheet));
					// $serviceSC = trim($dataOfSheet->val($row,7,$dataOfSheet->sheet));
					// $tariffS = trim($dataOfSheet->val($row,7,$dataOfSheet->sheet));
					// $serviceShort = addslashes(trim($dataOfSheet->val($row,2,$dataOfSheet->sheet)));
					// $cpt = trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));
					// $cghs = trim($dataOfSheet->val($row,4,$dataOfSheet->sheet));
					// $apply_in_day =trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));
					// $moa = trim($dataOfSheet->val($row,11,$dataOfSheet->sheet));
					// $chargeNabh = trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));
					// $chargeNonNabh = trim($dataOfSheet->val($row,12,$dataOfSheet->sheet));
					// $cdmCode = trim($dataOfSheet->val($row,16,$dataOfSheet->sheet));
					//$validity = trim($dataOfSheet->val($row,14,$dataOfSheet->sheet));
					$createtime = date("Y-m-d H:i:s");
					$createdby = $session->read('userid');
					// $cost_pvt = trim($dataOfSheet->val($row,7,$dataOfSheet->sheet));
					// $cost_cghs = trim($dataOfSheet->val($row,9,$dataOfSheet->sheet));
					// $cost_other = trim($dataOfSheet->val($row,10,$dataOfSheet->sheet));

					/* if(empty($cpt))
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
					     	"ServiceCategory.is_deleted"=>'0')));
					if(!empty($category)){
						$category_id = $category['ServiceCategory']['id'];
					}else{
						//or insert SC
						$service_category->create();
						$service_category->save(
							  array("name"=>$serviceC,
									"alias"=>strtolower($serviceC),
									'location_id'=>$session->read('locationid'),
									"is_view"=>"1",
								    "create_time"=> $createtime,
								    "created_by"=>$createdby));
						$category_id = $service_category->id;
					}

					/* for Tariff Sub Category*/
					/*  $subcategory = $service_sub_category->find("first",array("conditions" =>array("ServiceSubCategory.name"=>$serviceSC,"ServiceSubCategory.service_category_id"=>$category_id)));
					 if(!empty($subcategory)){
					$sub_category_id = $subcategory['ServiceSubCategory']['id'];
					}else{
					$service_sub_category->create();
					$service_sub_category->save(array("name"=>$serviceSC,'location_id'=>$session->read('locationid'),"is_view"=>"1","service_category_id"=>$category_id,"create_time"=> $createtime,"created_by"=>$createdby));
					$sub_category_id = $service_sub_category->id;
					} */

					/* for Tariff Standard*/
					/*$tariff = $tariff_standard->find("first",array("conditions" =>array("TariffStandard.name"=>$tariffS,"TariffStandard.location_id"=>$session->read('locationid'))));
					 if(!empty($tariff)){
					$tariff_standard_id = $tariff['TariffStandard']['id'];
					}else{
					$tariff_standard->create();
					$tariff_standard->save(array("name"=>$tariffS,'location_id'=>$session->read('locationid'),"create_time"=> $createtime,"created_by"=>$createdby));
					$tariff_standard_id = $tariff_standard->id;
					}*/

					/* for Tariff List*/
					$tariffList = $tariff_list->find("first",array("conditions" =>array("TariffList.name"=>$service,"TariffList.service_category_id"=>$category_id,"TariffList.service_sub_category_id"=>$sub_category_id,"TariffList.location_id"=>$session->read('locationid'))));
					if(!empty($tariffList)){
						$tariff_list_id = $tariffList['TariffList']['id'];
					}else{
						$tariff_list->create();
						$tariff_list->save(array(
								"name"=>$service,
								"location_id"=>$session->read('locationid'),
								"service_category_id"=>$category_id,
								"apply_in_a_day" =>$validity,
								"create_time"=> $createtime,
								"created_by"=>$createdby
								//	"service_sub_category_id"=>$sub_category_id,
								
						));
						$tariff_list_id = $tariff_list->id;
					}

					//BOF tariff amount
					$tariffStandardArray  =array('0'=>'7','1'=>'41','2'=>'16','3'=>'34','4'=>'35',
					 '5'=>'36','6'=>'37','7'=>'38','8'=>'39','9'=>'5','10'=>'40','11'=>'43','12'=>'44','13'=>'45' ) ;
					
				 /*$tariffStandardArray  =array('0'=>'7','1'=>'43','2'=>'16','3'=>'92','4'=>'93',
					 '5'=>'94','6'=>'96','7'=>'95','8'=>'98','9'=>'5','10'=>'97','11'=>'29','12'=>'15','13'=>'28' ) ;*/

						
			 /* 	$tariffStandardArray  =array('43'=>'Maa Yojna','91'=>'ECHS','92'=>'ONGC','93'=>'IOCL','94'=>'GNFC',
				 '96'=>'REL','95'=>'KANDLA','98'=>'HEAVY W','5'=>'BSNL','97'=>'ROTARY','140'=>'general') ; */


					$hospitalType = $session->read('hospitaltype');

					$check_ward_amount =$tariff_amt_type ->find("first",array("conditions"=>array(
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>$tariffStandardArray[$s]
					)));
					
					$check_edit_amount = $tariff_amount->find("first",array("conditions"=>array(
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>$tariffStandardArray[$s]
					)));

					if($hospitalType=='NABH'){
					 $chargeNabh = trim($dataOfSheet->val($row,4,$dataOfSheet->sheet));
					$chargeNonNabh=0;
					}else{
					$chargeNonNabh = trim($dataOfSheet->val($row,4,$dataOfSheet->sheet));;
					$chargeNabh=0;
					} 
					/* for Tariff Amount*/
		
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
					$tariff_amount->id = '';
					/* for Tariff Amount*/
					/* for TAriff Amount Type*/
					if(!empty($check_ward_amount)){
						$tariff_amt_type->save(array(
								"id"=>$check_ward_amount['TariffAmountType']['id'],
								"opd_charge"=>$opd_charge,
								"general_ward_charge"=>$gen_ward_charge,
								"special_ward_charge"=>$spcl_ward_charge,
								"delux_ward_charge"=>$dlx_ward_charge,
								"semi_special_ward_charge"=>$semi_ward_charge,
								"isolation_ward_charge"=>$isolation_ward_charge,
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
								"delux_ward_charge"=>$dlx_ward_charge,
								"semi_special_ward_charge"=>$semi_ward_charge,
								"isolation_ward_charge"=>$isolation_ward_charge,
								"code"=>$tariff_code,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
					}
					$tariff_amt_type->id =  '' ;
					/* for TAriff Amount Type*/
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
		$laboratory = Classregistry::init('Laboratory');
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
				$sub_category_id="";
				$tariff_standard_id="";
				$tariff_list_id ="";
				$service = addslashes(trim($dataOfSheet->val($row,1,$dataOfSheet->sheet)));
				if(!$service) continue ;
				$serviceC = trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
				if(empty($validity))
					$validity = "1";

				//find service group if exist
				$category = $service_category->find("first",array("conditions" =>array("ServiceCategory.name"=>$serviceC,
						"ServiceCategory.location_id"=>$session->read('locationid'),
						"ServiceCategory.is_deleted" => '0'
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



				//BOF tariff amount
				$hospitalType = $session->read('hospitaltype');

					$check_edit_amount = $tariff_amount->find("first",array("conditions"=>array(
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>'20'
					)));

					if($hospitalType=='NABH'){
						$chargeNabh = trim($dataOfSheet->val($row,2,$dataOfSheet->sheet));
						$chargeNonNabh=0;
					}else{
						$chargeNonNabh = trim($dataOfSheet->val($row,2,$dataOfSheet->sheet));;
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
	
	// Following Two functions (importDataLab and importDataGlobusLab) for importing lab - AtulC
	
	/* this function use for imprt the Lab in the master */
	function importDataLab(&$dataOfSheet) {
		//ini_set('max_execution_time', 900);
		$service_category = Classregistry::init('ServiceCategory');
		$service_sub_category = Classregistry::init('ServiceSubCategory');
		$tariff_list = Classregistry::init('TariffList');
		$tariff_amount = Classregistry::init('TariffAmount');
		$tariff_standard = Classregistry::init('TariffStandard');
		$tariff_amt_type = Classregistry::init('TariffAmountType');

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
					$serviceShort = addslashes(trim($dataOfSheet->val($row,3,$dataOfSheet->sheet)));
					// $tariffS = trim($dataOfSheet->val($row,7,$dataOfSheet->sheet));
					$service = addslashes(trim($dataOfSheet->val($row,4,$dataOfSheet->sheet)));
					if(!$service) continue ;
					//$genericName=addslashes(trim($dataOfSheet->val($row,5,$dataOfSheet->sheet)));
					$cpt = trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));
					$opd_charge=trim($dataOfSheet->val($row,6,$dataOfSheet->sheet));
					$gen_ward_charge=trim($dataOfSheet->val($row,7,$dataOfSheet->sheet));
					$semi_ward_charge=trim($dataOfSheet->val($row,8,$dataOfSheet->sheet));
					$spcl_ward_charge=trim($dataOfSheet->val($row,9,$dataOfSheet->sheet));
					$dlx_ward_charge=trim($dataOfSheet->val($row,10,$dataOfSheet->sheet));
					$tariff_code=trim($dataOfSheet->val($row,11,$dataOfSheet->sheet));
				
					$createtime = date("Y-m-d H:i:s");
					$createdby = $session->read('userid');
					

					/* if(empty($cpt))
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
					     	"ServiceCategory.is_deleted"=>'0')));
					if(!empty($category)){
						$category_id = $category['ServiceCategory']['id'];
					}else{
						//or insert SC
						$service_category->create();
						$service_category->save(
							  array("name"=>$serviceC,
									"alias"=>$serviceC,
									'location_id'=>$session->read('locationid'),
									"is_view"=>"1",
								    "create_time"=> $createtime,
								    "created_by"=>$createdby));
						$category_id = $service_category->id;
					}

					/* for Tariff Sub Category*/
					 $subcategory = $service_sub_category->find("first",array("conditions" =>array("ServiceSubCategory.name"=>$serviceSC,"ServiceSubCategory.service_category_id"=>$category_id,"ServiceSubCategory.is_deleted"=>'0')));
					 if(!empty($subcategory)){
					$sub_category_id = $subcategory['ServiceSubCategory']['id'];
					}else{
					$service_sub_category->create();
					$service_sub_category->save(array("name"=>$serviceSC,'location_id'=>$session->read('locationid'),"is_view"=>"1","service_category_id"=>$category_id,"create_time"=> $createtime,"created_by"=>$createdby));
					$sub_category_id = $service_sub_category->id;
					} 

					/* for Tariff Standard*/
					/*$tariff = $tariff_standard->find("first",array("conditions" =>array("TariffStandard.name"=>$tariffS,"TariffStandard.location_id"=>$session->read('locationid'))));
					 if(!empty($tariff)){
					$tariff_standard_id = $tariff['TariffStandard']['id'];
					}else{
					$tariff_standard->create();
					$tariff_standard->save(array("name"=>$tariffS,'location_id'=>$session->read('locationid'),"create_time"=> $createtime,"created_by"=>$createdby));
					$tariff_standard_id = $tariff_standard->id;
					}*/

					/* for Tariff List*/
					$tariffList = $tariff_list->find("first",array("conditions" =>array("TariffList.name"=>$service,"TariffList.service_category_id"=>$category_id,"TariffList.service_sub_category_id"=>$sub_category_id,"TariffList.location_id"=>$session->read('locationid'))));
					if(!empty($tariffList)){
						$tariff_list_id = $tariffList['TariffList']['id'];
					}else{
						$tariff_list->create();
						$tariff_list->save(array(
								
								"short_name" =>  $serviceShort,
								"location_id"=>$session->read('locationid'),
								"name"=>$service,
							//	"generic_name"=>$genericName,
								"service_category_id"=>$category_id,
								"service_sub_category_id"=>$sub_category_id,
								"cbt"=>$cpt,
								"apply_in_a_day" =>$validity,
								"create_time"=> $createtime,
								"created_by"=>$createdby
								//	"cdm" => $cdmCode,
								//	"cghs_code"=>$cghs,
								//	"price_for_private"=>$cost_pvt,
								//	"price_for_cghs"=>$cost_cghs,
								//	"price_for_other"=>(!empty($cost_other))?$cost_other:0,
								
						));
						$tariff_list_id = $tariff_list->id;
					}

					//BOF tariff amount
					
				/*	$tariffStandardArray  =array('0'=>'46','1'=>'47','2'=>'45' ) ;*/ //only for histo
					
					$tariffStandardArray  =array('0'=>'7','1'=>'41','2'=>'16','3'=>'34','4'=>'35',
					 '5'=>'36','6'=>'37','7'=>'38','8'=>'39','9'=>'5','10'=>'40','11'=>'43','12'=>'44','13'=>'45' ) ;
					
				/*$tariffStandardArray  =array('0'=>'7','1'=>'43','2'=>'16','3'=>'92','4'=>'93',
					 '5'=>'94','6'=>'96','7'=>'95','8'=>'98','9'=>'5','10'=>'97','11'=>'29','12'=>'15','13'=>'28' ) ;*/

						
			 /* 	$tariffStandardArray  =array('43'=>'Maa Yojna','91'=>'ECHS','92'=>'ONGC','93'=>'IOCL','94'=>'GNFC',
				 '96'=>'REL','95'=>'KANDLA','98'=>'HEAVY W','5'=>'BSNL','97'=>'ROTARY','140'=>'general') ; */


					$hospitalType = $session->read('hospitaltype');

					$check_ward_amount =$tariff_amt_type ->find("first",array("conditions"=>array(
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>$tariffStandardArray[$s]
					)));
					
					$check_edit_amount = $tariff_amount->find("first",array("conditions"=>array(
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>$tariffStandardArray[$s]
					)));

					if($hospitalType=='NABH'){
					 $chargeNabh = trim($dataOfSheet->val($row,7,$dataOfSheet->sheet));
					 $chargeNonNabh=0;
					}else{
					 $chargeNonNabh = trim($dataOfSheet->val($row,7,$dataOfSheet->sheet));;
					 $chargeNabh=0;
					} 
					/* for Tariff Amount*/
		
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
					$tariff_amount->getl = '';
					/* for Tariff Amount*/
					/* for TAriff Amount Type*/
					if(!empty($check_ward_amount)){
						$tariff_amt_type->save(array(
								"id"=>$check_ward_amount['TariffAmountType']['id'],
								"opd_charge"=>$opd_charge,
								"general_ward_charge"=>$gen_ward_charge,
								"special_ward_charge"=>$spcl_ward_charge,
								"delux_ward_charge"=>$dlx_ward_charge,
								"semi_special_ward_charge"=>$semi_ward_charge,
								"code"=>$tariff_code,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
						 
					}else{
						//$tariff_amt_type->create();
						$tariff_amt_type->save(array(
								"location_id"=>$session->read('locationid'),
								"tariff_list_id"=>$tariff_list_id,
								"tariff_standard_id"=>$tariffStandardArray[$s],
								"opd_charge"=>$opd_charge,
								"general_ward_charge"=>$gen_ward_charge,
								"special_ward_charge"=>$spcl_ward_charge,
								"delux_ward_charge"=>$dlx_ward_charge,
								"semi_special_ward_charge"=>$semi_ward_charge,
								"code"=>$tariff_code,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
					}
					$tariff_amt_type->id =  '' ;
					/* for TAriff Amount Type*/
				}
			}
		

		
	}
	
	// added for only kanpur instance(LAb Import)--Atulc
	function importDataGlobusLab(&$dataOfSheet,$tariff){
		$service_category = Classregistry::init('ServiceCategory');
		$service_sub_category = Classregistry::init('ServiceSubCategory');
		$tariff_list = Classregistry::init('TariffList');
		$tariff_amount = Classregistry::init('TariffAmount');
		$tariff_standard = Classregistry::init('TariffStandard');
		$laboratory = Classregistry::init('Laboratory');
	
		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
	
		try
		{
			for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
				$category_id= "";
				//$sub_category_id="";
				$tariff_standard_id="";
				$tariff_list_id ="";
				$lab_id="";
				$serviceC = trim($dataOfSheet->val($row,1,$dataOfSheet->sheet));
				//$serviceSC = trim($dataOfSheet->val($row,2,$dataOfSheet->sheet));
				//$tariffS = trim($dataOfSheet->val($row,10,$dataOfSheet->sheet));
				$service = addslashes(trim($dataOfSheet->val($row,2,$dataOfSheet->sheet)));
				if(!$service) continue ;
				//$serviceShort = addslashes(trim($dataOfSheet->val($row,3,$dataOfSheet->sheet)));
				//$cpt = trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));
				//$cghs = trim($dataOfSheet->val($row,4,$dataOfSheet->sheet));
				//$apply_in_day =trim($dataOfSheet->val($row,5,$dataOfSheet->sheet));
				// $moa = trim($dataOfSheet->val($row,11,$dataOfSheet->sheet));
	
	
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
				/*$subcategory = $service_sub_category->find("first",array("conditions" =>array("ServiceSubCategory.name"=>$serviceSC,
				 "ServiceSubCategory.service_category_id"=>$category_id)));
	
				if(!empty($subcategory)){
				$sub_category_id = $subcategory['ServiceSubCategory']['id'];
				}else{
				$service_sub_category->create();
				$service_sub_category->save(array("name"=>$serviceSC,'location_id'=>$session->read('locationid'),"is_view"=>"1","service_category_id"=>$category_id,"create_time"=> $createtime,"created_by"=>$createdby));
				$sub_category_id = $service_sub_category->id;
				}*/
	
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
	
				/* for Tariff List/ For mapping lab charges have to create one service with same name as lab*/
				$tariffList = $tariff_list->find("first",array("conditions" =>array("TariffList.name"=>$service,
						"TariffList.service_category_id"=>$category_id,
						"TariffList.location_id"=>$session->read('locationid'))));
	
				if(!empty($tariffList)){
					$tariff_list_id = $tariffList['TariffList']['id'];
				}else{
					$tariff_list->create();
					$tariff_list->save(array(
							//"cdm" => $cdmCode,
							//"short_name" =>  $serviceShort,
							"location_id"=>$session->read('locationid'),
							"name"=>$service,
							//"cghs_code"=>$cghs,
							"service_category_id"=>$category_id,
							//	"service_sub_category_id"=>$sub_category_id,
							//	"cbt"=>$cpt,
							//"apply_in_a_day" =>$apply_in_day,
							//"price_for_private"=>$cost_pvt,
							//"price_for_cghs"=>$cost_cghs,
							//"price_for_other"=>(!empty($cost_other))?$cost_other:0,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					$tariff_list_id = $tariff_list->id;
				}
	
	
				$lab = $laboratory->find("first",array("conditions" =>array("Laboratory.name"=>$service,
						"Laboratory.service_group_id"=>$category_id,
						"Laboratory.location_id"=>$session->read('locationid'))));
				if(!empty($lab)){
					$lab_id = $lab['Laboratory']['id'];
				}else{
					$laboratory->create();
					$laboratory->save(array(
	
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
					$lab_id = $laboratory->id;
				}
					
				/**
				 * PAWAN to add laboratories *
				 */
				/*
				 * $laboratory = Classregistry::init('Laboratory');
				*
				* $locationId = $session->read('locationid');
				*
				* $laboratory->set('name',$service);
				* $laboratory->set('location_id',$locationId);
				* $laboratory->set('is_deleted','0');
				* $laboratory->set('is_active','1');
				* $laboratory->set('tariff_standard_id',$tariff_standard_id); //need to confirm with pawana , y we need tariff standard id in lab
				* $laboratory->set('tariff_list_id',$tariff_list_id);
				* $laboratory->set('test_group_id',$category_id);
				* $laboratory->set('service_group_id',$category_id);
				* $laboratory->set('cbt',$cpt);
				* $laboratory->save();
				* $laboratory->id = '';
				* $laboratory->set('id','');
				*/
				/**
				 * PAWAN to add laboratories *
				 */
	
				//BOF tariff amount
				$tariffStandardArray  =array($tariff=>'3') ;
				/* 	$tariffStandardArray  =array('43'=>'Maa Yojna','91'=>'ECHS','92'=>'ONGC','93'=>'IOCL','94'=>'GNFC',
				 '96'=>'REL','95'=>'KANDLA','98'=>'HEAVY W','5'=>'BSNL','97'=>'ROTARY') ; */
	
				//as per  vadodara instance id of Tariff standards
				/* GENERAL - 1,MAA YOJNA-2,ECHS-3,ONGC- 4,IOCL-5,GNFC-6,RELIANCE-7,KANDLA PORT TRUST-8,HEAVY WATER PLANT- 9,
				 * BSNL- 10,ROTARY CLUB OF GANDEVI-11 */
				$hospitalType = $session->read('hospitaltype');
	
				foreach($tariffStandardArray as $tariff_standard_id => $rowNo){
					$check_edit_amount = $tariff_amount->find("first",array("conditions"=>array(
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>$tariff_standard_id
					)));
	
					if($hospitalType=='NABH'){
						$chargeNabh = trim($dataOfSheet->val($row,$rowNo,$dataOfSheet->sheet));
						$chargeNonNabh=0;
					}else{
						$chargeNonNabh = trim($dataOfSheet->val($row,$rowNo,$dataOfSheet->sheet));;
						$chargeNabh=0;
					}
					/* for Tariff Amount*/
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
								"tariff_standard_id"=>$tariff_standard_id,
								"nabh_charges"=>$chargeNabh,
								"non_nabh_charges"=>$chargeNonNabh,
								"moa_sr_no"=>$moa,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
					}
					$tariff_amount->id =  '' ;
				}//EOF for loop of tariff standard array
			}
	
			return true;
		}catch(Exception $e){
	
			return false;
		}
	
	
	}
	
	
	function importDataTariff(&$dataOfSheet,$tariff){
		$tariff_amount = Classregistry::init('TariffAmount');

		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
	
		
			for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
				
				$tariffListId = trim($dataOfSheet->val($row,1,$dataOfSheet->sheet));
				$chargeNabh = trim($dataOfSheet->val($row,2,$dataOfSheet->sheet));
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
				$validity = "1";
				
				$tariff_amount->create();
				$tariff_amount->save(array(
								"location_id"=>$session->read('locationid'),
								"tariff_list_id"=>$tariffListId,
								"tariff_standard_id"=>$tariff,
								"nabh_charges"=>$chargeNabh,
								"unit_days"=>$validity ,
								"create_time"=> $createtime,
								"created_by"=>$createdby
						));
				$tariff_amount->id =  '' ;
	
			}

	}
	
	function importPackageData(&$dataOfSheet){
		ini_set('max_execution_time', 900);
		$packageCategory = Classregistry::init('PackageCategory');
		$packageSubCategory = Classregistry::init('PackageSubCategory');
		$packageSubSubCategory = Classregistry::init('PackageSubSubCategory');
	
		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
		
			for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
				$pcategory_id= "";
				$pScategory_id="";
				$pSScategory_id="";
				
				$packageName = trim($dataOfSheet->val($row,1,$dataOfSheet->sheet));
				$subPackageName = trim($dataOfSheet->val($row,2,$dataOfSheet->sheet));
				$subSubPackageName = trim($dataOfSheet->val($row,3,$dataOfSheet->sheet));
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
	
	
	
				//find package category if exist
				$pCategory = $packageCategory->find("first",array("conditions" =>array("PackageCategory.name"=>$packageName,"PackageCategory.is_deleted"=>'0')));
				if(!empty($pCategory)){
					$pcategory_id = $pCategory['PackageCategory']['id'];
				}else{
					//or insert SC
					$packageCategory->create();
					$packageCategory->save(
							  array("name"=>$packageName,
									"create_time"=> $createtime,
									"created_by"=>$createdby));
					$pcategory_id = $packageCategory->id;
				}
	
				/* for package sub Sub Category*/
			  $pSubcategory = $packageSubCategory->find("first",array("conditions" =>array("PackageSubCategory.name"=>$subPackageName,"PackageSubCategory.package_category_id"=>$pcategory_id)));
			 if(!empty($pSubcategory)){
				$pScategory_id = $pSubcategory['PackageSubCategory']['id'];
				}else{
				$packageSubCategory->create();
				$packageSubCategory->save(array(
											"name"=>$subPackageName,
											"package_category_id"=>$pcategory_id,
											"create_time"=> $createtime,
											"created_by"=>$createdby));
				$pScategory_id = $packageSubCategory->id;
				} 
	 if(!empty($subSubPackageName)){
				$psubSubcategory = $packageSubSubCategory->find("first",array("conditions" =>array("PackageSubSubCategory.name"=>$subPackageName,"PackageSubSubCategory.package_category_id"=>$pcategory_id,
						"PackageSubSubCategory.package_sub_category_id"=>$pScategory_id)));
				if(!empty($psubSubcategory)){
					$pSScategory_id = $psubSubcategory['PackageSubSubCategory']['id'];
				}else{
					$packageSubSubCategory->create();
					$packageSubSubCategory->save(array(
							"name"=>$subSubPackageName,
							"package_category_id"=>$pcategory_id,
							"package_sub_category_id"=>$pScategory_id,
							"create_time"=> $createtime,
							"created_by"=>$createdby));
					$pSScategory_id = $packageSubSubCategory->id;
				}
	  }
	
		}
	}
	
	// added for only kanpur instance--Atulc
	function importClinicalServices(&$dataOfSheet){
		$service_category = Classregistry::init('ServiceCategory');
		$service_sub_category = Classregistry::init('ServiceSubCategory');
		$tariff_list = Classregistry::init('TariffList');
		$tariff_amount = Classregistry::init('TariffAmount');
		$tariff_standard = Classregistry::init('TariffStandard');
		$laboratory = Classregistry::init('Laboratory');
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
				$tariff_list_id ="";
				$serviceCode = trim($dataOfSheet->val($row,1,$dataOfSheet->sheet));
				$service = addslashes(trim($dataOfSheet->val($row,2,$dataOfSheet->sheet)));
				if(!$service) continue ;
				$serviceC = trim($dataOfSheet->val($row,4,$dataOfSheet->sheet));
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
				
				if(empty($validity))
					$validity = "1";
	
					//find service group if exist
					$category = $service_category->find("first",array("conditions" =>array("ServiceCategory.name"=>$serviceC,
							"ServiceCategory.location_id"=>$session->read('locationid'),
							"ServiceCategory.is_deleted" => '0'
					)));
	
	
					if(!empty($category)){
						$category_id = $category['ServiceCategory']['id']; //already exist
					}else{
						//or insert SC
						$service_category->create();
						$service_category->save(array("name"=>$serviceC,'location_id'=>$session->read('locationid'),"is_view"=>"1","create_time"=> $createtime,"created_by"=>$createdby));
						$category_id = $service_category->id;
					}
	
	
					
					$tariffList = $tariff_list->find("first",array("conditions" =>array("TariffList.name"=>$service,
							"TariffList.service_category_id"=>$category_id,
							"TariffList.location_id"=>$session->read('locationid'))));
	
					if(!empty($tariffList)){
						$tariff_list_id = $tariffList['TariffList']['id'];
						$tariff_list->save(array(
								"id"=>$tariff_list_id,
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
	
	
	
					//BOF tariff amount
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
								"service_code"=>$serviceCode,
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
								"tariff_standard_id"=>'20',
								"service_code"=>$serviceCode,
								"nabh_charges"=>$chargeNabh,
								"non_nabh_charges"=>$chargeNonNabh,
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
	
	
	


}