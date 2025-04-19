<?php 
/**
 * DutyPlan model
 *
 * PHP 5
 *
 * @link          http://www.drmhope.com/
 * @package       Duty Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Swati Newale
 */
class DutyPlan extends AppModel {

	public $name = 'DutyPlan';
	public $useTable = 'duty_plans';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	/**
	 * @param array $data
	 * @author Swati Newale
	 * @return boolean
	 */
	public function saveDutyPlan( $data = array() ){
		$session = new cakeSession();
		foreach($data['DutyPlan'] as  $key=>$dutyArray){
			
			if($dutyArray[$key]['is_roster_set']) continue;
			if(empty($dutyArray['first_duty_date']) || empty($dutyArray['first_shift']) ) continue;
				$dutyPlans[$key]['id'] = $dutyArray['id'];
				$dutyPlans[$key]['user_id'] = $dutyArray['user_id'];
				$dutyPlans[$key]['allow_day_off'] = $dutyArray['allow_day_off'];
				$dutyPlans[$key]['first_duty_date']= DateFormatComponent::formatDate2STD( $dutyArray['first_duty_date'],Configure::read('date_format'));
				$dutyPlans[$key]['first_shift']= $dutyArray['first_shift'];
				$dutyPlans[$key]['create_time'] = date("Y-m-d H:i:s");
				$dutyPlans[$key]['created_by'] = $session->read('userid');
				$dutyPlans[$key]['location_id']= $session->read('locationid');
		}
		$this->saveAll($dutyPlans);
		return true;
	}

	/**
	 * function to match roster with user in and out time
	 * @author Gaurav Chauriya
	 */

	public function calculateAttendance(){
		$userOBj = classRegistry::init('User');
		$dutyRosterOBj = classRegistry::init('DutyRoster');
		$dutyPlanOBj = classRegistry::init('DutyPlan');
		$userOBj->bindModel(array(
				'hasOne'=>array('DutyPlan'=>array('foreignKey'=>false,'conditions'=>array('User.id = DutyPlan.user_id'))),
				'hasMany'=>array(
						'DutyRoster'=>array('foreignKey'=>'user_id','conditions'=>array(array("DutyRoster.date LIKE "=>date('Y-m-%'))),
								'fields'=>array('DutyRoster.id','DutyRoster.day_off','DutyRoster.date','DutyRoster.shift','DutyRoster.inouttime')))
		));
		return $userOBj->find('all',array('fields'=>array('User.id','User.full_name'),
				'conditions'=>array("DutyPlan.first_duty_date LIKE "=> date('Y-m-')."%" ,"DutyPlan.duty_plan_approved" => '1')));
		
	}

}