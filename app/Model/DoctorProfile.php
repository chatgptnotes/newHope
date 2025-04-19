<?php
/**
 * DoctorProfileModel file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class DoctorProfile extends AppModel {

	public $name = 'DoctorProfile';
	public $useTable = 'doctors';	
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
 * association with departments and users table.
 *
 */
	  public $belongsTo = array('Department' => array('className'    => 'Department',
                                                  'foreignKey'    => 'department_id'
                                                 ),
                                  'User' => array('className'    => 'User',
                                                   'foreignKey'    => 'user_id'
                                                 ),
                                  /*'Initial' => array('className' => 'Initial',
                                                           'foreignKey'    => false,
                                                           'conditions'=>array('Initial.id=User.initial_id')
                                                 )*/
                                  );
                                  
      public function getDoctors($dept_id=null){
      	App::import('Model', 'CakeSession');
		$session = new CakeSession(); 
          $this->unbindModel(array(
                                'belongsTo' => array('Department', 'User','Initial')
                          ));
          /* $this->virtualFields = array(
    							'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
							);*/

			/*$this->virtualFields = array(
    							'doctorname' => 'CONCAT(DoctorProfile.first_name," ",DoctorProfile.last_name)'
							);*/
          $this->bindModel(array('hasOne' => array(
                                                  'User' => array(
                                                  'foreignKey' => false,
                                                  'conditions' => array('User.id = DoctorProfile.user_id')
                                                                      ),
                                                  'Initial' => array(
                                                  'foreignKey' => false,
                                                  'conditions' => array('Initial.id = User.initial_id')
                                                                    )
                                                   )
                                ));
           
          // debug($session->read('locationid'));
          if($dept_id){ 
          		$result  =  $this->find('all',array('fields'=>array('Initial.name as nameInitial','user_id','doctor_name'), 
      			'conditions'=>array('DoctorProfile.department_id'=>$dept_id,'User.is_deleted'=>0,'DoctorProfile.is_deleted'=>0,'DoctorProfile.is_active'=>1,'User.is_active'=>1,
      					'User.location_id'=>$session->read('locationid')/*, 'DoctorProfile.is_registrar'=>0*/,'User.is_doctor'=>1),'order'=>array('DoctorProfile.doctor_name'),
          				'contain' => array('User', 'Initial'), 'recursive' => 1));
          }else{ 
          		$result  =   $this->find('all',array('fields'=>array('Initial.name as nameInitial','user_id','doctor_name'),
      			'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'User.location_id'=>$session->read('locationid'),
      					/* 'DoctorProfile.is_registrar'=>0,*/'DoctorProfile.is_active'=>1,'User.is_active'=>1,'User.is_doctor'=>1),'order'=>array('DoctorProfile.doctor_name'),

          				
          			'contain' => array('User', 'Initial'),'order' => array('DoctorProfile.doctor_name'), 'recursive' => 1));	
          }    
          $doctorArr=array();
          foreach($result as $keyDoc=>$results){
          	$doctorArr[$results['DoctorProfile']['user_id']] = $results['Initial']['nameInitial'].' '.$results['DoctorProfile']['doctor_name'];
          }
          return $doctorArr;
			/*foreach($result   as $key =>$value){
				if($value == '' || $value==null|| empty($value)) continue ;
				$value ==  str_replace ("("," ",$value);
				$value ==  str_replace (")"," ",$value);
				$res[$key] = str_replace (","," ",$value);
			}  */    
		
			//return $res ;         
      	 
      	
      } 
	  
    
		public function getDoctorByID($doctor_id=null){ 
			/*$this->unbindModel(array(
                                'belongsTo' => array('Department', 'User')
                          ));  */
			/*$this->virtualFields = array(
    							'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
							);*/
         	/*$this->bindModel(array('hasOne' => array(
                                                  'User' => array(
                                                  'foreignKey' => false,
                                                  'conditions' => array('User.id = DoctorProfile.user_id')
                                                                      ),
                                                  'Initial' => array(
                                                  'foreignKey' => false,
                                                  'conditions' => array('Initial.id = User.initial_id')
                                                                    )
                                                   )));  */
      		if(!empty($doctor_id)){		
      			return $this->Find('first',array('conditions'=>array('user_id'=>$doctor_id),'order'=>array('DoctorProfile.doctor_name')));
      			//return $this->read('doctor_name',$doctor_id);
      		}
        } 

/**
 *
 * get registrar listing 
 *
**/
   public function getRegistrar(){
      	  App::import('Model', 'CakeSession');
		  $session = new CakeSession(); 
        /*  $this->unbindModel(array(
                                'belongsTo' => array('Department', 'User')
                          ));*/
          /* $this->virtualFields = array(
    							'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
							);*/
		  $this->virtualFields = array(
		  		'doctor_name' => 'DoctorProfile.doctor_name'
		  );
		  $this->unbindModel(array(
		  		'belongsTo' => array('Department', 'User','Initial')
		  ));
		  /* $this->virtualFields = array(
		   'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
		  );*/
		  $this->bindModel(array('hasOne' => array(
		  		'User' => array(
		  				'foreignKey' => false,
		  				'conditions' => array('User.id = DoctorProfile.user_id')
		  		),
		  		'Initial' => array(
		  				'foreignKey' => false,
		  				'conditions' => array('Initial.id = User.initial_id')
		  		)
		  )
		  ));
		$registrarArr=array();
      	$getRegistrarData=$this->find('all',array('fields'=>array('Initial.name as nameInitial','user_id','doctor_name','id','first_name'),
      	'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'User.location_id'=>$session->read('locationid'), 'DoctorProfile.is_registrar'=>1,'User.is_active' =>'1'),'order'=>array('DoctorProfile.doctor_name'),'contain' => array('User', 'Initial'), 'recursive' => 1));
      	foreach($getRegistrarData as $keyRegistrar=>$getRegistrarDatas){
      		$registrarArr[$getRegistrarDatas['DoctorProfile']['user_id']] = $getRegistrarDatas['Initial']['nameInitial'].' '.$getRegistrarDatas['DoctorProfile']['doctor_name'];
      	}      	
      	return $registrarArr;
   }

 /**
 *
 * get surgeon listing 
 *
**/
public function getSurgeon($dept_id=null){
      	App::import('Model', 'CakeSession');
		$session = new CakeSession(); 
		
          $this->unbindModel(array(
                                'belongsTo' => array('Department', 'User','Initial')
                          ));
          /* $this->virtualFields = array(
    							'doctor_name' => 'CONCAT(Initial.name, " ", DoctorProfile.doctor_name)'
							);*/
          $this->bindModel(array('hasOne' => array(
                                                  'User' => array(
                                                  'foreignKey' => false,
                                                  'conditions' => array('User.id = DoctorProfile.user_id')
                                                                      ),
                                                  'Initial' => array(
                                                  'foreignKey' => false,
                                                  'conditions' => array('Initial.id = User.initial_id')
                                                                    )
                                                   )
                                ));
          $surgeonArr= array();
         	$getSurgeonData=$this->find('all',array('fields'=>array('Initial.name as nameInitial','user_id','doctor_name'),
      			'conditions'=>array('User.is_deleted'=>0, 'DoctorProfile.is_deleted'=>0,'User.location_id'=>$session->read('locationid'), 'DoctorProfile.is_registrar'=>0, 'DoctorProfile.is_surgeon'=>1),'order'=>array('DoctorProfile.doctor_name'),'contain' => array('User', 'Initial'), 'recursive' => 1));
         	foreach($getSurgeonData as $key=>$getSurgeonDatas){
         		$surgeonArr[$getSurgeonDatas['DoctorProfile']['user_id']] = $getSurgeonDatas['Initial']['nameInitial'].' '.$getSurgeonDatas['DoctorProfile']['doctor_name'];
         	}               
       	return $surgeonArr;
      }   
	  
      //by pankaj to fetch doctor list by doctor id
	  public function getDoctorByDepartmentWise($department_id=null){

		$session = new CakeSession()  ;

		$this->recursive = -1 ;
		if($session->read('website.instance')=='vadodara'){
			if($department_id)				 
				$condition = array('DoctorProfile.is_opd_allow'=>'1','DoctorProfile.is_deleted'=>'0','DoctorProfile.department_id'=>$department_id,'DoctorProfile.is_active'=>1) ;
			else				 
				$condition = array('DoctorProfile.is_opd_allow'=>'1','DoctorProfile.is_deleted'=>'0','DoctorProfile.is_active'=>1) ;

		}else{
			if($department_id)				 
				$condition = array('DoctorProfile.is_opd_allow'=>'1','DoctorProfile.is_deleted'=>'0','DoctorProfile.department_id'=>$department_id,'DoctorProfile.is_active'=>1,'DoctorProfile.location_id'=>$session->read('locationid')) ;
			else				 
				$condition = array('DoctorProfile.is_opd_allow'=>'1','DoctorProfile.is_deleted'=>'0','DoctorProfile.is_active'=>1,'DoctorProfile.location_id'=>$session->read('locationid')) ; 
		}

		$result =  $this->find('list',array('fields'=>array('user_id','doctor_name'),'conditions'=>$condition,'order'=>array('DoctorProfile.doctor_name ASC')));

		return  $result;
	  } 

}
?>