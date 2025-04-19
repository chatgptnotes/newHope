<?php
class Anesthesia extends AppModel {

	public $name = 'Anesthesia';


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
 * for delete Anesthesia.
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
}
?>