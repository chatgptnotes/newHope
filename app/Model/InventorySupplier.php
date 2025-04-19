<?php
/**
 * WardModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       InventorySupplier Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class InventorySupplier extends AppModel {

	public $name = 'InventorySupplier';

 public $validate = array(
		'name' => array(
		 'isUnique' => array (
            'rule' => array('checkUniqueName'),
			 'on' => 'create',
            'message' => 'This Supplier Name already exists.'
        )
		)
		);
	public $hasMany = array(
		'InventoryPurchaseDetail' => array(
		'className' => 'InventoryPurchaseDetail',
		'dependent' => true,
		'foreignKey' => 'party_id',
		),

	);


function checkUniqueName() {
  		$session = new cakeSession();
		return ($this->find('count', array('conditions' => array('InventorySupplier.is_deleted'=>0,'InventorySupplier.name' => $this->data['InventorySupplier']['name'],"InventorySupplier.location_id" => $session->read('locationid')))) ==0);
	}
	/**
 * for delete insurance type.
 *
 */
	public function deleteInventorySupplierItem($postData) {
	  	$pharmacyItem = Classregistry::init('PharmacyItem');
      	$this->id = $postData;
		$supplier = $this->find('first', array('conditions' => array('InventorySupplier.id' => $postData)));
		foreach($supplier['PharmacyItem'] as $key =>$value)
		{
			$pharmacyItem->id = $value['id'];

      	$this->data["PharmacyItem"]["supplier_id"] = '';
			$pharmacyItem->save($this->data);
		}
      	$this->data["InventorySupplier"]["id"] =$postData;
      	$this->data["InventorySupplier"]["is_deleted"] = '1';
      	$this->save($this->data);
      	return true;
      }
	  public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    
    /**
     * afterSave function for saving data in account table--Pooja
     *
     **/
    
    public function afterSave($id=null)
    {	
    	//For generating account code for account table
    	$session = new CakeSession();
      	$getRegistrar = Classregistry::init('Account'); 
      	$accountingGroup = Classregistry::init('AccountingGroup');
      	$count = $getRegistrar->find('count',array('conditions'=>array('Account.create_time like'=> "%".date("Y-m-d")."%",'Account.location_id'=>$session->read('locationid'))));
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
      	$unique_id   = 'IN';
      	$unique_id  .= ucfirst(substr($hospital,0,1)); //first letter of the hospital name
      	$unique_id  .= strtoupper(substr($session->read('location'),0,2));//first 2 letter of d location
      	$unique_id  .= date('y'); //year
      	$unique_id  .= $month_array[date('n')-1];//first letter of month
      	$unique_id  .= date('d');//day
      	$unique_id .= $count;
      	
      	$sundryCreditors = $accountingGroup->getAccountingGroupID(Configure::read('sundry_creditors'));
      	$var=$getRegistrar->find('first',array('fields'=>array('id','account_code','accounting_group_id'),'conditions'=>array('system_user_id'=>$this->data['InventorySupplier']['id'],'user_type'=>'InventorySupplier','Account.location_id'=>$session->read('locationid'))));
      	if($var!='')
    	{
    		//avoid delete updatation
    		if($this->data['InventorySupplier']['is_deleted']==1){
    			$getRegistrar->updateAll(array('is_deleted'=>1), array('Account.system_user_id' => $this->data['InventorySupplier']['id'],'Account.user_type'=>'InventorySupplier','Account.location_id'=>$session->read('locationid')));
    			return ;
    		}
    		$this->data['Account']['id']=$var['Account']['id'];
    		$this->data['Account']['modify_time']=date("Y-m-d H:i:s");
    		if(empty($var['Account']['account_code']))
    		{
    			$this->data['Account']['account_code']=$unique_id;
    		}
    		if(empty($var['Account']['accounting_group_id']))
    		{
    			$this->data['Account']['accounting_group_id']=$sundryCreditors;
    		}
    	
    	}
    	else {
    		if($this->data['InventorySupplier']['is_deleted']==1){
    			return ; //return if delete
    		}
    		$this->data['Account']['create_time']=date("Y-m-d H:i:s");
    		$this->data['Account']['account_code']=$unique_id;
    		$this->data['Account']['status']='Active';
    	}
    	$this->data['Account']['name']=$this->data['InventorySupplier']['name'];
    	$this->data['Account']['user_type']='InventorySupplier';
    	$this->data['Account']['system_user_id']=$this->data['InventorySupplier']['id'];
    	$this->data['Account']['location_id']=$session->read('locationid');
    	$this->data['Account']['accounting_group_id']=$this->data['InventorySupplier']['accounting_group_id'];
    	$getRegistrar->save($this->data['Account']);
    }
    
    /* this function use for imprt the data in the master*/
    function importData(&$dataOfSheet){
    	$supplier = Classregistry::init('InventorySupplier');
    	
    	$session = new cakeSession();
    	$dataOfSheet->row_numbers=false;
    	$dataOfSheet->col_letters=false;
    	$dataOfSheet->sheet=0;
    	$dataOfSheet->table_class='excel';
    	/* $noOfSheets = count($dataOfSheet->sheets) ;
    	if($noOfSheets ==0) $dataOfSheet->sheets  =  1 ; */
    
    	try
    	{
    			for($row=2;$row<=$dataOfSheet->rowcount($dataOfSheet->sheet);$row++) {
    				
    				$suppliername = trim($dataOfSheet->val($row,2,$dataOfSheet->sheet));
    				if(!$suppliername) continue;
    				$createtime = date("Y-m-d H:i:s");
    				$createdby = $session->read('userid');

    			$supplier_list = $supplier->find("first",array("conditions" =>array("InventorySupplier.name"=>$suppliername,
						"InventorySupplier.location_id"=>$session->read('locationid'))));
				 
				if(!empty($supplier_list)){
					$supplier_list_id = $supplier_list['InventorySupplier']['id'];
				}else{
					$supplier->create();
					$supplier->save(array(
						
							
							"location_id"=>$session->read('locationid'),
							"name"=>$suppliername,
							"create_time"=> $createtime,
							"created_by"=>$createdby
					));
					$supplier_list_id = $supplier_list->id;
				}  
		
    			}
    		
    		return true;
    	}catch(Exception $e){
    		//pr($e);exit;
    		return false;
    	} 
    }   

	 

	//insert by pankaj
	public function insertSupplier($data){
		$this->save($data);
	}

	//get supliers
	function getSuplier($category=null){
		$session=new CakeSession() ;
		$condition['location_id'] = $session->read('locationid');
		$condition['is_implant'] = 1; //active
		$condition['is_deleted'] = 0;
		 
		$result = $this->Find('list',array('conditions'=>$condition)) ;	
		return $result; 
	}
	
}
?>