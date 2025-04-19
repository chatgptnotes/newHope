<?php
/**
 * Group Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Languages.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class TestGroup extends AppModel {
	public $name = 'TestGroup';
	public $actsAs = array('Containable');
	
    public $specific = true;
    
    /*public $hasMany = array(
    		'Laboratory' // Load the model from this same plugin
    );*/
    
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }
    

    //$type : laboratory/radiology
    
    public $validate = array(
    	'name' => array(
    				'rule' => "notEmpty",
    				'message' => "Please enter sub speciality."
    	),
    	'code' => array(
    				'rule' => "notEmpty",
    				'message' => "Please enter sub speciality code."
    	)
    );
    
    function saveRecord($data,$type){
    	$session = new cakeSession();
    	if($data['TestGroup']['id']){
    		$data['TestGroup']['modify_time']  = date('Y-m-d H:i:s'); 
    		$data['TestGroup']['modified_by']   = $session->read('userid');
    	}else{
    		$data['TestGroup']['create_time']  = date("Y-m-d H:i:s");
    		$data['TestGroup']['created_by']   = $session->read('userid');
    		$data['TestGroup']['type']= $type;
    	}
    	return $this->save($data);
    }
    
    function getGroupByID($id){
    	return $this->read(null,$id) ;
    }
    
    function getAllGroups($type){
    	return $this->find('list',array('conditions'=>array('type'=>$type),'fields'=>array('name')));
    }
}
