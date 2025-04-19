<?php
/**
 * Diagnosis file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj wanajari
 */
class Drug extends AppModel {

	 public $name = 'Drug';
	 
	 //insert drug                                  
     public function insertDrug($data=array(),$action='insert'){      		
     		return $this->find('list',array('fields'=>array('user_id','doctor_name'),'conditions'=>array('is_deleted'=>0)));
     }
	      public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
}
?>