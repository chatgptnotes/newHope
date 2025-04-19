<?php 
/**
 *serializeDataConfiguration model
 *
 * PHP 5
 *
 * @copyright     ----
 * @link          http://www.drmhope.com/
 * @package       serializeDataConfiguration Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Swati Newale
 */
class SerializeDataConfiguration extends AppModel {

	public $name = 'SerializeDataConfiguration';
	var $useTable = 'serialize_data_configurations';
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

	/**
	 * function to insert serialized data  
	 * @param array $saveArray
	 * @return boolean
	 * @author Swati Newale
	 */
	public function saveData($subjectId,$subjectName,$objectName,$data = array(),$roomType,$locationId=null){
		$session = new CakeSession();
			$saveArray["subject_id"]= $subjectId;
			$saveArray["subject_name"] = $subjectName;
			$saveArray["object_name"] = $objectName;
			$saveArray["data"] = serialize($data);
			$saveArray["location_id"]  = $locationId ? $locationId : Configure::read('CorporateLocationId'); 
			$this->create();
			$this->save($saveArray);
			return $this->id;
	}
        
        /**
	 * function to update serialized data  
	 * @param array $saveArray
	 * @return boolean
	 * @author Swati Newale
	 */
	public function updateData($serializeDataConfigurationId,$data = array()){
			$saveArray["id"]= $serializeDataConfigurationId;
			$saveArray["data"] = serialize($data);
			$this->save($saveArray);
			return $this->id;
	}
        
        /*
         * function to fetch list of approver
         * @param $subjectId is key of Config variable approveHead
         * @author gaurav chauriya
         */
        public function getApprovalUser($subjectId){
            $session = new cakeSession();
            $User = Classregistry::init('User');
            $userApproval = $this->find('first',array('fields'=>array('data'),
                'conditions'=>array("SerializeDataConfiguration.subject_name"=>"approveHead",'SerializeDataConfiguration.subject_id'=>$subjectId)));
            $roleID = array_filter(explode(',', $userApproval['SerializeDataConfiguration']['data']));
            $User->unbindModel(array( 'belongsTo' => array('City','State','Country','Role')));
            $locationCondition['OR']=array('User.location_id'=>array('1',$session->read('locationid')),'User.other_location_id LIKE'=>'%,'.$session->read('locationid').',%');
            return $User->find('list',array('conditions'=>array('User.role_id'=>$roleID,$locationCondition,'User.is_deleted'=>0,'User.is_active'=>1),
				'fields'=>array('full_name'), 'recursive' => 1,'callbacks' => false));
        }
        
        /**
         * @author Amit Jain
         * @see Model::beforeFind()
         */
        public function beforeFind($queryData) {
        	parent::beforeFind();
        	$queryData['conditions']['is_deleted'] = '0';
        	return $queryData;
        }
        
}