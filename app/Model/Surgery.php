<?php
class Surgery extends AppModel {

	public $name = 'Surgery';



        public $validate = array(
		        'name' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter name."
			    ),
                         'charges' => array(
			    'rule' => 'numeric',
			    'message' => "Please valid charges."
			    ),
                         'description' => array(
			    'rule' => "notEmpty",
			    'message' => "Please enter description."
			    ),

                );


/**
 * for delete surgery.
 *
 */

      public function deleteSurgery($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["Surgery"]["id"] = $postData['pass'][0];
      	$this->data["Surgery"]["is_deleted"] = '1';
      	$this->save($this->data);
      	return true;
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

	function importData(&$dataOfSheet){
 		$surgerySubCategory = Classregistry::init('SurgerySubcategory');
		$surgeryCategory = Classregistry::init('SurgeryCategory');
 		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
		try
  			{

					for($row=3;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
                     $category_id = '';
                     $sub_category_id = '';
					 $surgery_name = addslashes(trim( $dataOfSheet->val($row,1,$dataOfSheet->sheet)));
					 $surgery_description = addslashes(trim( $dataOfSheet->val($row,2,$dataOfSheet->sheet)));
                     $category_name = addslashes(trim( $dataOfSheet->val($row,3,$dataOfSheet->sheet)));
                     $category_description = addslashes(trim( $dataOfSheet->val($row,4,$dataOfSheet->sheet)));
					 $sub_category_name = addslashes(trim( $dataOfSheet->val($row,5,$dataOfSheet->sheet)));
					 $sub_category_description = addslashes(trim( $dataOfSheet->val($row,6,$dataOfSheet->sheet)));
					 $createtime = date("Y-m-d H:i:s");
					 $createdby = $session->read('userid');

					 /* for Category */ ;
					 $category = $surgeryCategory->find("first",array("conditions" =>array("SurgeryCategory.name"=>$category_name,"SurgeryCategory.location_id"=>$session->read('locationid'))));

					 if(!empty($category)){
						$category_id = $category['SurgeryCategory']['id'];
					 }else{
						$surgeryCategory->create();
						$surgeryCategory->save(array(
							"location_id"=>$session->read('locationid'),
							"name"=>$category_name,
							"description"=>$category_description,
							"created_by" =>$createdby,
                            "create_time" =>$createtime
							));
						$category_id = $surgeryCategory->id;
					 }
					  /* for Sub Category Item*/
					 $surgery_sub_category = $surgerySubCategory->find("first",array("conditions" =>array("SurgerySubcategory.name"=>$sub_category_name,"SurgerySubcategory.surgery_category_id"=>$category_id )));

					 if(!empty($surgery_sub_category)){
                        $sub_category_id = $surgery_sub_category['SurgerySubcategory']['id'];
					 }else{
						$surgerySubCategory->create();
						$surgerySubCategory->save(array(
							"location_id"=>$session->read('locationid'),
						    "name"=>$sub_category_name,
                            "surgery_category_id"=>$category_id,
							"description"=>$sub_category_description,
							"created_by" =>$createdby,
                            "create_time" =>$createtime
							 ));
						$sub_category_id = $surgerySubCategory->id;
					 }

                         /* for Surgery*/
                        $surgery = $this->find("first",array("conditions" =>array("Surgery.name"=>$surgery_name,"Surgery.surgery_category_id"=>$category_id,"Surgery.surgery_subcategory_id"=>$sub_category_id,"Surgery.location_id"=>$session->read('locationid'))));
                         if(!empty($surgery)){
                         }else{
    						 $this->create();
    						 $this->save(array(
                                "location_id"=>$session->read('locationid'),
    							"name"=>$surgery_name,
    							"surgery_category_id"=>$category_id,
                                "surgery_subcategory_id"=>$sub_category_id,
                                "description"=>$surgery_description,
                                "created_by" =>$createdby,
                                "create_time" =>$createtime

    						 ));
                        }

				}
				return true;
			}catch(Exception $e){
				return false;
			}


	}
	// Following function for importing surgery on vadodara
	function importSurgeryData(&$dataOfSheet){
		$surgeryCategory = Classregistry::init('SurgeryCategory');
		$surgerySubCategory = Classregistry::init('SurgerySubcategory');
		$service_category = Classregistry::init('ServiceCategory');
		$service_sub_category = Classregistry::init('ServiceSubCategory');
		$tariff_list = Classregistry::init('TariffList');
		$tariff_amount = Classregistry::init('TariffAmount');
		$tariff_standard = Classregistry::init('TariffStandard');
		$tariff_amt_type = Classregistry::init('TariffAmountType');
		
		$session = new cakeSession();
		$dataOfSheet->row_numbers=false;
		$dataOfSheet->col_letters=false;
		$dataOfSheet->sheet=0;
		$dataOfSheet->table_class='excel';
		

			 for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
				$category_id = '';
				$sub_category_id = '';
				$ser_category_id = '';
				$ser_sub_category_id = '';
				$surgery_name = addslashes(trim( $dataOfSheet->val($row,1,$dataOfSheet->sheet)));
				if(!$surgery_name) continue ;
				$surgery_category_name = addslashes(trim( $dataOfSheet->val($row,2,$dataOfSheet->sheet)));
				$service_category_name = addslashes(trim( $dataOfSheet->val($row,4,$dataOfSheet->sheet)));
				$serviceCode = addslashes(trim( $dataOfSheet->val($row,5,$dataOfSheet->sheet)));
				$validity = "1";
				$createtime = date("Y-m-d H:i:s");
				$createdby = $session->read('userid');
	
				

				//find service group if exist
				$service_category_id = $service_category->find("first",array("conditions" =>array("ServiceCategory.name"=>$service_category_name,
						"ServiceCategory.location_id"=>$session->read('locationid'),
						"ServiceCategory.is_deleted"=>'0')));
			
				if(!empty($service_category_id)){
					$ser_category_id = $service_category_id['ServiceCategory']['id'];
				}else{
					//or insert SC
					$service_category->create();
					$service_category->save(
							array("name"=>$surgery_category_name,
									'location_id'=>$session->read('locationid'),
									"is_view"=>"1",
									"create_time"=> $createtime,
									"created_by"=>$createdby));
					$ser_category_id = $service_category->id;
				}
				
				/* for Tariff Sub Category*/
		    /*  $subcategory = $service_sub_category->find("first",array("conditions" =>array("ServiceSubCategory.name"=>$surgery_sub_category_name,"ServiceSubCategory.service_category_id"=>$ser_category_id)));
		     
				 if(!empty($subcategory)){
				$ser_sub_category_id = $subcategory['ServiceSubCategory']['id'];
				}else{
				$service_sub_category->create();
				$service_sub_category->save(array("name"=>$surgery_sub_category_name,'location_id'=>$session->read('locationid'),"is_view"=>"1","service_category_id"=>$ser_category_id,"create_time"=> $createtime,"created_by"=>$createdby));
				$ser_sub_category_id = $service_sub_category->id;
				} 
				*/
				
				$tariffList = $tariff_list->find("first",array("conditions" =>array("TariffList.name"=>$surgery_name,"TariffList.service_category_id"=>$ser_category_id,"TariffList.location_id"=>$session->read('locationid'))));
				if(!empty($tariffList)){
					$tariff_list_id = $tariffList['TariffList']['id'];
					$tariff_list->save(array(
							"id"=>$tariff_list_id,
							"location_id"=>$session->read('locationid'),
							"name"=>$surgery_name,
							"service_category_id"=>$ser_category_id,
							"apply_in_a_day" =>$validity,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
				}else{
					$tariff_list->create();
					$tariff_list->save(array(
							
							"location_id"=>$session->read('locationid'),
							"name"=>$surgery_name,
							"service_category_id"=>$ser_category_id,
							"apply_in_a_day" =>$validity,	
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					$tariff_list_id = $tariff_list->id;
				}
				
				
				/* for Category */ ;
				$surgury_category = $surgeryCategory->find("first",array("conditions" =>array("SurgeryCategory.name"=>$surgery_category_name,"SurgeryCategory.location_id"=>$session->read('locationid'),"SurgeryCategory.is_deleted"=>'0')));
				
				if(!empty($surgury_category)){
					$category_id = $surgury_category['SurgeryCategory']['id'];
				}else{
					$surgeryCategory->create();
					$surgeryCategory->save(array(
							"location_id"=>$session->read('locationid'),
							"name"=>$surgery_category_name,
							"description"=>$surgery_category_name,
							"created_by" =>$createdby,
							"create_time" =>$createtime
					));
					$category_id = $surgeryCategory->id;
				}
				/* for Sub Category Item*/
				/*$surgery_sub_category = $surgerySubCategory->find("first",array("conditions" =>array("SurgerySubcategory.name"=>$surgery_sub_category_name,"SurgerySubcategory.surgery_category_id"=>$category_id,"SurgerySubcategory.is_deleted"=>'0' )));
				
				if(!empty($surgery_sub_category)){
					$sub_category_id = $surgery_sub_category['SurgerySubcategory']['id'];
				}else{
					$surgerySubCategory->create();
					$surgerySubCategory->save(array(
							"location_id"=>$session->read('locationid'),
							"name"=>$surgery_sub_category_name,
							"surgery_category_id"=>$category_id,
							"description"=>$surgery_sub_category_name,
							"created_by" =>$createdby,
							"create_time" =>$createtime
					));
					$sub_category_id = $surgerySubCategory->id;
				}
				*/
				/* for Surgery*/
				$surgery = $this->find("first",array("conditions" =>array("Surgery.name"=>$surgery_name,"Surgery.surgery_category_id"=>$category_id,"Surgery.location_id"=>$session->read('locationid'))));
				if(!empty($surgery)){
					$this->save(array(
							"id"=>$surgery['Surgery']['id'],
							"location_id"=>$session->read('locationid'),
							"name"=>$surgery_name,
							"surgery_category_id"=>$category_id,
							"tariff_list_id"=>$tariff_list_id,
							"description"=>$surgery_name,
							"created_by" =>$createdby,
							"create_time" =>$createtime
					
					));
				}else{
					$this->create();
					$this->save(array(
							"location_id"=>$session->read('locationid'),
							"name"=>$surgery_name,
							"surgery_category_id"=>$category_id,
							"tariff_list_id"=>$tariff_list_id,
							"description"=>$surgery_name,
							"created_by" =>$createdby,
							"create_time" =>$createtime
				
					));
				}
				
					$hospitalType = $session->read('hospitaltype');

					$check_edit_amount = $tariff_amount->find("first",array("conditions"=>array(
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>"20"
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
							"service_code"=>$serviceCode,
							"tariff_standard_id"=>"20",
							"unit_days"=>$validity ,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
				}else{
					$tariff_amount->create();
					$tariff_amount->save(array(
							"location_id"=>$session->read('locationid'),
							"tariff_list_id"=>$tariff_list_id,
							"tariff_standard_id"=>"20",
							"nabh_charges"=>$chargeNabh,
							"non_nabh_charges"=>$chargeNonNabh,
							"service_code"=>$serviceCode,
							"unit_days"=>$validity ,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
				}
				$tariff_amount->id = '';
				/* for TAriff Amount Type*/
				
				}
	      
	}

	public function getSurgeryList(){
		$session = new cakeSession();
		return $this->find('list',array('fields'=>array('id','name'),'conditions'=>array('is_deleted'=>'0','location_id'=>$session->read('locationid'))));
	}
}
?>