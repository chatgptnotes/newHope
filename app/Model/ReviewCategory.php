<?php
 
class ReviewCategory extends AppModel {	  
	
	public $specific = true; 
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}

	/* this function use for imprt the data in the master*/
	function importData($filename){ 
		 
		 
		// open the file
		$handle = fopen($filename, "r");
		 
		// read the 1st row as headings
		$header = fgetcsv($handle); 

		$subcatOption = Classregistry::init('ReviewSubCategoriesOption');
		$subCategory = Classregistry::init('ReviewSubCategory');
		
		// read each data row in the file
		while (($value = fgetcsv($handle,500, ",")) !== FALSE) {
			$i++;
			$data = array(); 
			  
					if(!empty($value[0])){
						//check already exist
						$categoryResult = $this->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>trim($value[0])))) ;
							
						if(!empty($categoryResult['ReviewCategory']['id'] )){
							$mainCategoryID = $categoryResult['ReviewCategory']['id'] ;
						}else{
							$this->save(array('name'=>trim($value[0]))) ;
							$mainCategoryID = $this->id ;
							$this->id = '' ;//reset current id
						}
						if(!empty($value[1])){
							//sub cat
							$subCategoryResult = $subCategory->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>trim($value[1]),'review_category_id'=>$mainCategoryID))) ;
			
							if(!empty($subCategoryResult['ReviewSubCategory']['id'])){
								$subCategoryID = $subCategoryResult['ReviewSubCategory']['id'] ;
							}else{
								$subCategory->save(array('name'=>trim($value[1]),'review_category_id'=>$mainCategoryID,'parameter'=>trim($value[10]))) ;
								$subCategoryID = $subCategory->id ;
								$subCategory->id = '' ;//reset current id
							}
			
							if(!empty($value[2])){
								//sub sub cat
								$subCategoryOptionsResult = $subcatOption->find('first',array('fields'=>array('id'),'conditions'=>array('name'=>trim($value[2]),'review_sub_categories_id'=>$subCategoryID))) ;
									
								if(!empty($subCategoryOptionsResult['ReviewSubCategoriesOption']['id'])){
									if(!empty($value[3])){
										$values = serialize(explode("@",trim($value[3]))) ;
									}else{
										$values = '' ;
									}
									if($value[7]=='') $cond =0;
									else $cond = $value[7] ;
									
									$subCatOptionArray = array('id'=>$subCategoryOptionsResult['ReviewSubCategoriesOption']['id'],
											'values'=>trim($values),'unit'=>trim($value[4]),
											'score'=>trim($value[5]),'score_total'=>trim($value[6]),'is_conditional'=>trim($cond),'trigger'=>trim($value[8]),'trigger_on'=>trim($value[9]));
									$subcatOption->save($subCatOptionArray) ;
									$subcatOption->id = '' ;//reset current id
								}else{
									if(!empty($value[3])){
										$values = serialize(explode("@",trim($value[3]))) ;
									}else{
										$values = '' ;
									}
									
									if($value[7]=='') $cond =0;
									else $cond = $value[7] ;
									
									$subCatOptionArray = array(
											'name'=>trim($value[2]),
											'review_sub_categories_id'=>$subCategoryID,
											'values'=>trim($values),'unit'=>trim($value[4]),
											'score'=>trim($value[5]),'score_total'=>trim($value[6]),'is_conditional'=>trim($cond),'trigger'=>trim($value[8]) ,'trigger_on'=>trim($value[9])) ;
									$subcatOption->save($subCatOptionArray) ;
									$subcatOptionID = $subcatOption->id ;
									$subcatOption->id = '' ;//reset current id
								}
							}//eof third if
						}//eof sec if 
				} 
		}  
		fclose($handle) ; 
	
	}
}
?>