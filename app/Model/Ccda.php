<?php
/**
 * Ccda Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gulshan Trivedi
*/  
class Ccda extends AppModel { 
	public $name = 'Ccda';
	public $useTable = false;
	public $cacheQueries = false ; 
	public $specific = true;
	
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
    //return complete array of sent and rcvd items 
    function overdue_summary_care_count($limit=null){
    	if($limit=='') {
    		$baseLimit = 10 ;
    		$fetchLimit = 1 ; 
    	}else{
    		$baseLimit = $limit ;
    		$fetchLimit = $limit+10 ; 
    	}
    	 
    	$transmittedCcda = Classregistry::init('TransmittedCcda') ;
    	$incorporatedPatient = Classregistry::init('IncorporatedPatient') ;
    	$session = new cakeSession(); 
    	
    	$sentItems =  $transmittedCcda->find('all',array('fields'=>array('id','patient_id','file_name','created_on','to','subject','notify'),
    			'conditions'=>array('created_by'=>$session->read('userid'),
    			'location_id'=>$session->read('locationid'),'TransmittedCcda.address_type'=>'Specialist' ) , 'limit'=>$baseLimit, 'offset'=>$fetchLimit,'order'=>array('TransmittedCcda.id Desc') )); 
    	
    	$receivedItems = $incorporatedPatient->find('list',array('fields'=>array('xml_file','fromAddress'),'conditions'=>array('created_by'=>$session->read('userid'),
    			'location_id'=>$session->read('locationid'),'patient_id IS NULL','fromName IS NOT NULL'), 'limit'=>$baseLimit, 'offset'=>$fetchLimit ,'order'=>array('IncorporatedPatient.id Desc'))); 
    	
    	
    	if($limit==''){//fetch total count for sent & rcved records
    		$sentItemsCount =  $transmittedCcda->find('count',array( 
    				'conditions'=>array('created_by'=>$session->read('userid'),'location_id'=>$session->read('locationid'),'TransmittedCcda.address_type'=>'Specialist' ) ));
    		 
    		$receivedItemsCount = $incorporatedPatient->find('count',array('conditions'=>array('created_by'=>$session->read('userid'),
    				'location_id'=>$session->read('locationid'),'patient_id IS NULL','fromName IS NOT NULL')));
    	}
    	if($sentItemsCount > $receivedItemsCount) $ccdaCount =  $sentItemsCount;
    	else $ccdaCount = $receivedItemsCount ;
    	return  array('sentItems'=>$sentItems,'receivedItems'=>$receivedItems,'ccdaCount'=>$ccdaCount);
    	 
    	
    } 
}
?>