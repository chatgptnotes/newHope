<?php
class TemplateSms extends AppModel {

	public $name = 'TemplateSms';

	public $useTable = 'template_smses';
	public $specific = true;
	public function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	public function findListArr(){	
		return $this->find('list',array('fields'=>array('TemplateSms.id','TemplateSms.sms'),'order'=>array('TemplateSms.id'=>"ASC")));
	}

}