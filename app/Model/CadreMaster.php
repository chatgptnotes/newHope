<?php 
/**
 * CadreMaster model
 *
 * PHP 5
 *
 * @link          http://www.drmhope.com/
 * @package       CadreMaster Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Swati Newale
 */
class CadreMaster extends AppModel {

	public $name = 'CadreMaster';
	public $useTable = 'cadre_masters';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	public function saveCadre($data = array()){ 
		$session = new cakeSession();
		if($data['id']){
			$data['modify_time'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $session->read('userid');
			$data['location_id'] = $session->read('locationid');
		}else{
			$data['create_time'] = date('Y-m-d H:i:s');
			$data['created_by'] = $session->read('userid');
			$data['location_id'] = $session->read('locationid');
		}	
		$this->save($data);
		return $this->id;	
	}
	
}