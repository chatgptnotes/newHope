<?php
class CorporateSublocation extends AppModel {

	public $name = 'CorporateSublocation';
	public $belongsTo = array('Corporate' => array('className'    => 'Corporate',
                                                  'foreignKey'    => 'corporate_id'
                                                 ),
                                  'CorporateLocation' => array('className'    => 'CorporateLocation',
                                                  'foreignKey'    => 'corporate_location_id'
                                                 )
                                  );
        public $validate = array(
                'name' => array(
			'rule' => "notEmpty",
			'message' => "Please enter name."
			),
                'description' => array(
			'rule' => "notEmpty",
			'message' => "Please enter description."
			),
                'corporate_location_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select corporate location."
			),
		'corporate_id' => array(
			'rule' => "notEmpty",
			'message' => "Please select corporate."
			)
                );
/**
 * for delete corporate sublocation.
 *
 */
      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
      public function deleteCorporateSublocation($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["CorporateSublocation"]["id"] = $postData['pass'][0];
      	$this->data["CorporateSublocation"]["is_deleted"] = '1';
      	$this->save($this->data);
      	return true;
      }	
      
      
      //BOF amit jain
      /**
       * afterSave function for saving data in accounting groups table--Amit jain
       *
       **/
      public function afterSave($id=null)
      {
      	$session = new CakeSession();
      	$accountingGroupObj = Classregistry::init('AccountingGroup');
     
      	$subLoctionId = $this->data['CorporateSublocation']['id'];
      	$id=$accountingGroupObj->find('first',array('fields'=>array('AccountingGroup.id'),'conditions'=>array('AccountingGroup.system_user_id'=>$subLoctionId,
      			'AccountingGroup.user_type'=>'Sublocation','AccountingGroup.location_id'=>$session->read('locationid'),'AccountingGroup.is_deleted'=>'0')));
      	if(!empty($id)){
      		if($this->data['CorporateSublocation']['is_deleted']=='1'){
      			$accountingGroupObj->updateAll(array('AccountingGroup.is_deleted'=>'1'),array('AccountingGroup.system_user_id' =>$subLoctionId,
      					'AccountingGroup.user_type'=>'Sublocation','AccountingGroup.location_id'=>$session->read('locationid')));
      			return ;
      		}
      		$accountingGroupObj->id=$id['AccountingGroup']['id'];
      		$this->data['AccountingGroup']['location_id'] = $session->read('locationid');
      		$this->data['AccountingGroup']['id']=$id['AccountingGroup']['id'];
      		$this->data['AccountingGroup']['name']=$this->data['CorporateSublocation']['name'];
      		$this->data['AccountingGroup']['account_type']='Asset';
      		$this->data['AccountingGroup']['modified_time']=date("Y-m-d H:i:s");
      		$this->data['AccountingGroup']['user_type']='Sublocation';
      		$this->data['AccountingGroup']['system_user_id']=$subLoctionId;
      		$accountingGroupObj->save($this->data['AccountingGroup']);
      	}else{
      		if($this->data['CorporateSublocation']['is_deleted']=='1'){
      			return ; //return if delete
      		}
      		$this->data['AccountingGroup']['location_id']=$session->read('locationid');
      		$this->data['AccountingGroup']['name']=$this->data['CorporateSublocation']['name'];
      		$this->data['AccountingGroup']['account_type']='Asset';
      		$this->data['AccountingGroup']['created_time']=date("Y-m-d H:i:s");
      		$this->data['AccountingGroup']['user_type']='Sublocation';
      		$this->data['AccountingGroup']['system_user_id']=$this->data['CorporateSublocation']['id'];
      		$accountingGroupObj->save($this->data['AccountingGroup']);
      		$accountingGroupObj->id = "";
      	}
      }
      
      public function getSublocationNameById($id){
      	if($id){
      		$subLocationName = $this->find('first',array('conditions'=>array('CorporateSublocation.id'=>$id),'fields'=>array('CorporateSublocation.id','CorporateSublocation.name','CorporateSublocation.corporate_id')));
      	}
      	return $subLocationName;
      }
      /**
      * fetch list CorporateSublocation data function
      * By Mahalaxmi
      * @params location_id
      * return result query list
      */
      function getCorporateSublocationList($tariffStandId=null){
      	if(!empty($tariffStandId)){
      		$condition['CorporateSublocation.tariff_standard_id'] = $tariffStandId;
      	}
        $res=$this->find('list',array('fields'=>array('id','name'),
        		'conditions'=>array('CorporateSublocation.is_deleted'=>0,$condition/*,'CorporateSublocation.corporate_location_id'=>$location_id*/),
        		'order' => array ('CorporateSublocation.name'=>'ASC')));    
        $result=array_filter($res);
        $yourArray=array_map('strtolower', $result);// for converting string into lowercase
        $resultData = array_map('ucwords', $yourArray);//for first letter of string capital 
        return $resultData;
      }   
}
?>