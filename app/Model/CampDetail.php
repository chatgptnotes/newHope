<?php 
class CampDetail extends AppModel{
	public $name = 'CampDetail';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	/**
	 * Function to get list of camps organised
	 * @param unknown_type $conditions
	 * @return Ambigous <multitype:, NULL, mixed>
	 */
	function getCampList($conditions=NULL){
		$list=$this->find('all',array('conditions'=>array('is_deleted'=>'0',$conditions)));
		return $list;
	}
	
}
?>