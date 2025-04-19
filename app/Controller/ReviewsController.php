<?php
/**
 * UsersController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class ReviewsController extends AppController {

	public $name = 'Reviews';
	//public $uses = array('Hl7Message');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email','Auth','Session', 'Acl','Cookie');


	public function beforeFilter() {

	}

	public function index(){
	}



	public function document_list()
	{
		//$this->set(’document_list’, $this->Document_List->find(’all’));



	}

	public function edit_patient_xml($id=null)
	{
		$this->uses=array('Review','Initial','User','Role');

		$user_select = $this->User->find("all",array('fields'=>array('Initial.name','first_name','last_name','Role.name'),'conditions'=>array("(User.is_deleted = '0' and User.location_id = '".$this->Session->read('locationid')."') and (Role.name !='superadmin' and Role.name !='admin')"),'group'=>'User.id'));
		for($k=0;$k<count($user_select);$k++){
			$usernames[] = $user_select[$k][Initial][name].$user_select[$k][User][first_name].$user_select[$k][User][last_name]."(".$user_select[$k][Role][name].")";
		}

		debug($usernames);
		$this->set('user_select', $usernames);

		$initails=$this->Initial->find("list",array("fields"=>array("id","name")));

		$this->Review->bindModel(array(
				'belongsTo' => array(
						'User' =>array(
								'foreignKey'=>false,
								'conditions' => array('User.id=Review.user_name'),
								'fields' => array('User.first_name','User.last_name','User.initial_id'),
						)),
				'hasOne' => array(
						'Role' =>array(
								'foreignKey'=>false,
								'conditions' => array('Role.id=User.role_id'),
								'fields' => array('Role.name'),
						)),
				'hasOne' => array(
						'Initial' =>array(
								'foreignKey'=>false,
								'conditions' => array('Initial.id=User.initial_id'),
								'fields' => array('Initial.name'),
						),
				)),true);


		$users = $this->Review->find("all",array('fields'=>array('user_name'),'conditions'=>array('Review.id' => $id)));
		$user_name=$this->request->data['Review']['user_name'];
		$initial_id= $this->request->data['Review']['initial_id'];
		$patient_name= $this->request->data['Review']['patient_name'];
		$type_name= $this->request->data['Review']['type_name'];
		$to_person= $this->request->data['Review']['to_person'];
		$first_name= $this->request->data['Review']['first_name'];
		$last_name= $this->request->data['Review']['last_name'];
		$add_line1= $this->request->data['Review']['add_line1'];
		$add_line2= $this->request->data['Review']['add_line2'];
		$city= $this->request->data['Review']['city'];
		$zip= $this->request->data['Review']['zip'];
		$work_tel= $this->request->data['Review']['work_tel'];
		$cell_phone= $this->request->data['Review']['cell_phone'];
		$fax= $this->request->data['Review']['fax'];
		$email= $this->request->data['Review']['email'];
		$clinic_name= $this->request->data['Review']['clinic_name'];
		$clinic_add1= $this->request->data['Review']['clinic_add1'];
		$clinic_add2= $this->request->data['Review']['clinic_add2'];
		$clinic_city= $this->request->data['Review']['clinic_city'];
		$clinic_zip= $this->request->data['Review']['clinic_zip'];
		$clinic_tel= $this->request->data['Review']['clinic_tel'];
		$clinic_fax= $this->request->data['Review']['clinic_fax'];
		$purpose= $this->request->data['Review']['purpose'];
		//	debug($this->request->data);
		if(!empty($this->request->data))
		{

			$this->Review->updateAll(array( 'user_name'=>"'$user_name'",
					'initial_id'=>"'$initial_id'",'patient_name'=>"'$patient_name'",'type_name'=>"'$type_name'",'to_person'=>"'$to_person'",	'to_person'=>"'$to_person'",
					'first_name'=>"'$first_name'",	'last_name'=>"'$last_name'",	'add_line1'=>"'$add_line1'",	'add_line2'=>"'$add_line2'",	'city'=>"'$city'",	'city'=>"'$city'",
					'zip'=>"'$zip'",	'work_tel'=>"'$work_tel'",	'city'=>"'$city'",	'cell_phone'=>"'$cell_phone'",	'fax'=>"'$fax'",	'email'=>"'$email'",	'clinic_name'=>"'$clinic_name'",
					'clinic_add1'=>"'$clinic_add1'",'clinic_add2'=>"'$clinic_add2'",	'clinic_city'=>"'$clinic_city'",	'clinic_zip'=>"'$clinic_zip'",	'clinic_tel'=>"'$clinic_tel'",
					'clinic_fax'=>"'$clinic_fax'",'purpose'=>"'$purpose'"
			),array("Review.id" => $id));
		}
		$getreview = $this->Review->find("all",array("conditions" =>array('Review.id' => $id)));
		$this->set('getreview', $getreview);
		$this->set('initails', $initails);
		$this->set('users', $users);
	}

	public function patient_xml()
	{
		$this->uses= array('Review','Initial','User','Role');
		$usernames = '';
		
		
		$initails=$this->Initial->find("list",array("fields"=>array("id","name")));
		
		$users = $this->User->find("all",array('fields'=>array('Initial.name','first_name','last_name','Role.name'),'conditions'=>array("(User.is_deleted = '0' and User.location_id = '".$this->Session->read('locationid')."') and (Role.name !='superadmin' and Role.name !='admin')"),'group'=>'User.id'));
		for($k=0;$k<count($users);$k++){
			$usernames[] = $users[$k][Initial][name].$users[$k][User][first_name].$users[$k][User][last_name]."(".$users[$k][Role][name].")";
		}
		$this->set('users', $usernames);
		$this->set('initails', $initails);
		if($this->request->data){
			
			

			$this->Review->save($this->request->data);
			

		}
	}

	function ccd_ccr()
	{

		$this->uses= array('Review');
		$getreview = $this->Review->find("all",array('fields'=>array('Review.id','Review.created', 'Review.type_name', 'Review.to_person')));
		$this->set('getreview',$getreview);
		//debug($getreview);

		//exit;


	}


	//$user = $this->Review->find('all', array('fields'=>array('id','id'),'conditions'=>array('OwnersList.user_id'=>1)));
	//$results = $this->Review->find('all',array(
	//	'Post.owner_id'=>$user_ids
	//));



}

?>