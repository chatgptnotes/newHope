<?php 
/**
 *BirthDocumentation model
 *
 * PHP 5
 *
 * @copyright     ----
 * @link          http://www.drmhope.com/
 * @package       BirthDocumentation Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Swati Newale
 */
class BirthDocumentation extends AppModel {

	public $name = 'BirthDocumentation';
	var $useTable = 'birth_documentation_details';
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
   
    
    public function saveBirthdata($data = array()){
    	$session = new cakeSession ();
    	$data = array_map(function($val) { return ($val == '') ? null : $val; }, $data);
    	$data['datetime_of_delivery']= DateFormatComponent::formatDate2STD($data['datetime_of_delivery'],Configure::read('date_format'));
    	$data['before_delivery'] = implode(',',$data['before_delivery']);
    	$data['location_id'] = $session->read('locationid');
    		return $this->save($data); 
    	
    }   
}
?> 