<?php 
/**
 * HrDetails model
 *
 * PHP 5
 *
 * @link          http://www.drmhope.com/
 * @package       HrDetails Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mahalaxmi Nakade
 */
class HrDetail extends AppModel {

	public $name = 'HrDetail';
	public $useTable = 'hr_details';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	/**
	 * @param array $data
	 * @author Mahalaxmi Nakade
	 * @return boolean
	 */
	 public function saveData($data=array()){
		 $session = new cakeSession();		
		if(!empty($data)){ 				
					if(!empty($data['HrDetail']['id'])){
						$this->id = $data['HrDetail']['id'];				
						$data["HrDetail"]["modify_time"] = date("Y-m-d H:i:s");
						$data["HrDetail"]["modified_by"] = $session->read('userid');						
					}else{									
						$data["HrDetail"]["create_time"] = date("Y-m-d H:i:s");
						$data["HrDetail"]["created_by"] = $session->read('userid');					
					}					
					$data["HrDetail"]["location_id"] = $session->read('locationid');					
			if($this->save($data["HrDetail"])){							
					return $this->getLastInsertID();
			} 
			
		}
	}
	/**
	 * @param  $data as id
	 * @author Mahalaxmi Nakade
	 * @return data
	 */
	 public function findFirstHrDetails($data,$userType){
		return $this->find('first',array('fields'=>array('HrDetail.*'),'conditions'=>array('HrDetail.user_id'=>$data,'HrDetail.type_of_user'=>$userType)));
	 }

}