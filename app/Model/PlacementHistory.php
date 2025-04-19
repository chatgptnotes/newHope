<?php 
/**
 * PlacementHistory model
 *
 * PHP 5
 *
 * @link          http://www.drmhope.com/
 * @package       PlacementHistory Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Swati Newale
 */
class PlacementHistory extends AppModel {

	public $name = 'PlacementHistory';
	public $useTable = 'placement_histories';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
 public	function findUserShiftID($userId){
		return $this->find('first',array('fields'=>array('PlacementHistory.id','PlacementHistory.shifts'),'conditions'=>array('PlacementHistory.user_id'=>$userId)));
	}
}