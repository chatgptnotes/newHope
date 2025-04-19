<?php 
class CampParticipantsDetail extends AppModel{
	public $name = 'CampParticipantsDetail';
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	/**
	 * Camp particaipants details List
	 * @param unknown_type $conditions
	 * @return Ambigous <multitype:, NULL, mixed>
	 * Pooja Gupta
	 */
	function getCampDetails($conditions){
		$this->bindModel(array(
				'belongsTo'=>array(
						'CampDetail'=>array('foreignKey'=>false	,'type'=>'INNER',
								'conditions'=>array('CampParticipantsDetail.camp_detail_id=CampDetail.id')),
						'User'=>array('foreignKey'=>false	,'type'=>'INNER',
								'conditions'=>array('CampParticipantsDetail.doctor_id=User.id'))
						)));
		$details=$this->find('all',array('conditions'=>array('CampDetail.is_deleted'=>'0',$conditions)));
		return $details;
	}
	
	/**
	 * save camp participants data
	 * @param unknown_type $data
	 * @param unknown_type $camp_id
	 * @return boolean
	 * Pooja gupta
	 */
	function savePatientData($data,$camp_id){
		$session=new CakeSession();
		//$this->deleteAll(array('CampParticipantsDetail.camp_detail_id'=>$camp_id));
		foreach($data['Camp']['name'] as $nKey=>$name){//debug($data['Camp']);
			$arr['camp_detail_id']=$camp_id;
			$arr['name']=$name;
			$arr['age']=$data['Camp']['age'][$nKey];
			$arr['sex']=$data['Camp']['sex'][$nKey+1];
			$arr['mobile_no']=$data['Camp']['mobile_no'][$nKey];
			$arr['address']=$data['Camp']['address'][$nKey];
			$arr['invt']=$data['Camp']['invt'][$nKey];
			$arr['admit_chk']=$data['Camp']['admit_chk'][$nKey+1];
			$arr['doctor_id']=$data['Camp']['doctor_id'][$nKey];
			$arr['remark']=$data['Camp']['remark'][$nKey];
			$arr['created_by']=$session->read('userid');
			$arr['created_time']=date('Y-m-d H:i:s');
			//debug($arr);exit;
			$this->save($arr);
			$this->id='';
			$arr=array();
		}
		return true;		
	}
}
?>