<?php
/**
 * ServiceCategory file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Bed Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
class ServiceSubCategory extends AppModel {
	
	public $name = 'ServiceSubCategory';
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

    public $belongsTo = array(
		'ServiceCategory' => array(
		'className' => 'ServiceCategory',
		'dependent' => true,
		'foreignKey' => 'service_category_id',
		)
	); 
    
    /**
     * for list of sub-groups
     * @return Ambigous <multitype:, NULL, mixed>
     * @yashwant
     */
    public function getAllSubCategories(){
    	return($this->find('list',array('fields'=>array('id','name'),'consitions'=>array('ServiceSubCategory.is_view'=>1,"ServiceSubCategory.is_deleted"=>0))));
    }
}