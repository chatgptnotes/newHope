<?php
/**
 * MultipleOrderSet Model
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       MultipleOrderSet Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pawan Meshram
 */
class MultipleOrderSet extends AppModel {

	public $specific = true;
	public $name = 'MultipleOrderSet';
	public $useTable = false;
	public $searchKey = array('anaesthesia'=>array('anesthesia','anaesthesia'),'anesthesia'=>array('anaesthesia','anesthesia'),
							'gynaecology' => array('gynecology','gynaecology'),'gynecology' => array('gynaecology','gynecology'),
							'x-ray' =>array('xray','x ray','x-ray'),'xray' =>array('x-ray','x ray','xray'),'x ray' =>array('x-ray','xray','x ray'),
							'haemoglobin' => array('haemoglobin','hemoglobin'),'hemoglobin' => array('haemoglobin','hemoglobin')
	);
	
	
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	function matchSearchKeys($searchCode,$like){//pr($options);exit;
		$matchingSearchKeys = $this->searchKey[$searchCode];
		$count = count($matchingSearchKeys);
		$searchString = '';
		if($count > 0){
			for($i=0; $i < $count; $i++){
				if($i < ($count-1))
					$searchString  .= 'name like ' . '"' .$like.$matchingSearchKeys[$i].'%' . '"' ." OR ";
				else $searchString  .= 'name like ' . '"' .$like.$matchingSearchKeys[$i].'%' . '"';
			}
			return $searchString;
		}else if(!empty($searchCode)){
			return $searchString = 'name like ' . '"' .$like.$searchCode.'%'.  '"' ;
		}else if(empty($searchCode)){
			return $searchString = 'name like ' . '"' .$like.'%'.  '"' ;
		}
		
	}
	/////BOF-Mahalaxmi
	public function insertOrdersetCategories($data=array(),$lastInsertOrdersetId){	
		//debug($data);//exit;
		$session = new cakeSession();
		$reviewSubCategoryModel = ClassRegistry::init('ReviewSubCategory');
		$ordersetMasterModel = ClassRegistry::init('OrdersetMaster');
		$orderSubcategoryModel = ClassRegistry::init('OrderSubcategory');	
		$orderCategoryModel = ClassRegistry::init('OrderCategory');		
		$ordersetCategoryMappingModel = ClassRegistry::init('OrdersetCategoryMapping');
		
		$getStrghTxt=Configure::read('strength');
		$getRoopTxt=Configure :: read('roop');
		$getRouteAdmTxt=Configure :: read('route_administration');
		$getFrqTxt=Configure :: read('frequency');
		
				
		
		$ordersetCategoryMappingModel->deleteAll(array('orderset_master_id'=>$lastInsertOrdersetId)); 
		foreach ($data["ordercategory_id"] as $key=>$dataOrderIdNumeric){
			if(is_numeric($dataOrderIdNumeric)){					
					$data["ordercategory_idnew"][$key]=$dataOrderIdNumeric;
			}
		}
		
		$data["ordercategory_idnew"]=array_filter($data["ordercategory_idnew"]);
		$data["ordercategory_idnew"]=array_values($data["ordercategory_idnew"]);			
		$countCat=count($data["ordercategory_idnew"]);		
		
		for($k=0;$k<$countCat;$k++){			
			$data['OrdersetCategoryMapping']['orderset_master_id']=$lastInsertOrdersetId;
			$data['OrdersetCategoryMapping']['order_category_id']=$data["ordercategory_idnew"][$k];
			$ordersetCategoryMappingModel->saveAll($data['OrdersetCategoryMapping']);
		}
		for($j=0;$j<$countCat;$j++){			
			$getOrderCategoryData=$orderCategoryModel->find('first',array('fields'=>array('order_description','id'),'conditions'=>array('OrderCategory.id'=>$data["ordercategory_idnew"][$j],'OrderCategory.status'=>1,'OrderCategory.is_deleted'=>0)));
		
			///*****All type Category common save*****////
			$OrderNameRemoveSp = str_replace(' ', '', $getOrderCategoryData['OrderCategory']['order_description']);
			
			$data[$OrderNameRemoveSp."name"]=array_filter($data[$OrderNameRemoveSp."name"]);
			$count=count($data[$OrderNameRemoveSp."name"]);
			for($i=0;$i<$count;$i++){	
				$data['OrderSubcategory']['order_sentence']='';
				if($data["ordercategory_idnew"][$j]=='33'){
					$resultOfSubCategory  =$reviewSubCategoryModel->find('first',array('fields'=>array('id','name'),
							'conditions'=>array('parameter'=>'Intake','review_category_id'=>'4','id'=>$data['intake'][$i],
									'OR'=>array('ReviewSubCategory.name LIKE "%continuous infusion%"','ReviewSubCategory.name LIKE "%medications%"','ReviewSubCategory.name LIKE "%parenteral%"'))));
				
					$orderSentMed=$data['dosageValue'][$i]." ".$getRoopTxt[$data['strength'][$i]].",".$getRouteAdmTxt[$data['route_administration'][$i]].",".$getFrqTxt[$data['frequency'][$i]].", Intake: ".$resultOfSubCategory['ReviewSubCategory']['name'].", Quantity: ".$data['quantity'][$i];
					$data['OrderSubcategory']['order_sentence']=$orderSentMed;
				}
				
				$data['OrderSubcategory']['id']=$data['OrderSubcategory'.$OrderNameRemoveSp.'_id'][$i];
				$data['OrderSubcategory']['name']=$data[$OrderNameRemoveSp."name"][$i];
				$data['OrderSubcategory']['order_category_id']=$data["ordercategory_idnew"][$j];
				$data['OrderSubcategory']['orderset_master_id']=$lastInsertOrdersetId;				
				$orderSubcategoryModel->saveAll(array($data['OrderSubcategory']));
			}
		}
		//exit;
		
		
		
		return $lastInsertOrdersetId;
		
	}
}