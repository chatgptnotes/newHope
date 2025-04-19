<?php
class Corporate extends AppModel {

	public $name = 'Corporate';
	public $belongsTo = array('CorporateLocation' => array('className'    => 'CorporateLocation',
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
			)
                );
	
/**
 * for delete corporate.
 *
 */
      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
      public function deleteCorporate($postData) {
      	$this->id = $postData['pass'][0];
      	$this->data["Corporate"]["id"] = $postData['pass'][0];
      	$this->data["Corporate"]["is_deleted"] = '1';
      	$this->save($this->data);
      	return true;
      }		
      
      public function getCorporateByID($id=null){
      	if(!$id) return ;
      	
      	$result  = $this->find('first',array('fields'=>array('name'),'conditions'=>array('Corporate.id'=>$id)));
      	return $result['Corporate']['name']; 
      	
      }
	
}
?>