<?php

/* Inbox Model
 *
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @package       Inbox.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Pawan Meshram
*/
class Inbox extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'Inbox';



	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	
	function mailCount($limit=null){
		if($limit=='') {
			$baseLimit = 2 ;
			$fetchLimit = 0 ;
		}else{
			$baseLimit = $limit+2;
			$fetchLimit =  $limit ;
		}
		$session = new cakeSession();
		$mailData =  $this->find('all',array('fields'=>array('id','from_name','to_name','create_time','to','subject','notify'),
				'conditions'=>array('to'=>$session->read('username')), 'limit'=>$baseLimit, 'offset'=>$fetchLimit ,'order'=>array('Inbox.id Desc') ));
		
		if($limit==''){
			$mailCount =  $this->find('count',array(  'conditions'=>array('to'=>$session->read('username') )));
		}
		return  array('mailData'=>$mailData,'mailCount'=>$mailCount);
	}
}
?>