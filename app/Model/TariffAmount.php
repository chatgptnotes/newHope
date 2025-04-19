<?php
class TariffAmount extends AppModel {

	public $name = 'TariffAmount';
	 
	
	 
//function to overwrite the paginator count '
	/*public function PaginateCount($conditions = null, $recursive =0, $extra = array()) {
				$session = new cakeSession();
                $rec = empty($extra['extra']['recursive']) ? $recursive : $extra['extra']['recursive'];
                $this->bindModel(array(
 								'belongsTo' => array( 		
    													'TariffStandard' =>array('type'=>'RIGHT','foreignKey' => 'tariff_standard_id'),									 
														
    												)),false); 
    												
                return $this->find('count', array(
                        'conditions' => array('TariffStandard.location_id'=>$session->read('locationid'),'TariffStandard.is_deleted'=>0),
                		'fields'=>array('COUNT(DISTINCT(TariffStandard.name)) as count'),
                        'recursive' => $rec,
                		'group'=>array('TariffStandard.name')
                ));
        } */
	
	
        public $specific = true;
	  function __construct($id = false, $table = null, $ds = null) {
       if (empty ( $ds )) {
			$session = new cakeSession ();
			$this->db_name = $session->read ( 'db_name' );
		} else {
			$this->db_name = $ds;
		}
		parent::__construct ( $id, $table, $ds );
    }  
    
    
    public function beforefind($queryData) {
      	parent::beforeFind();
      
    	if (isset($queryData['conditions']['tariff_standard_id']) && empty($queryData['conditions']['tariff_standard_id']) || 
    			(isset($queryData['conditions']['TariffAmount.tariff_standard_id']) && empty($queryData['conditions']['TariffAmount.tariff_standard_id']))) {
    		$queryData['conditions']['tariff_standard_id'] = Configure::read('privateTariffId'); //add private tariff id if nothingi s there in array 
    	} 
    	 
    	return $queryData;
    }
    
    //return charges of services as per standard
    public function getTariffAmount($tariff_standard_id=null,$tariff_list_id=null){
    	if(!$tariff_standard_id || !$tariff_list_id) return false ;
    	
    	$session = new CakeSession() ; 
    	$hospitalType = $session->read('hospitaltype');
    	
    	if($hospitalType == 'NABH'){
    		$fieldName = 'nabh_charges';
    	}else{
    		$fieldName = 'non_nabh_charges';    			
    	}    	
    	$result = $this->find('first',array('conditions'=>array('TariffAmount.tariff_list_id'=>$tariff_list_id,
    			'TariffAmount.tariff_standard_id'=>$tariff_standard_id)));
    	
    	return $result['TariffAmount'][$fieldName] ; //return nabh or non_nabh charges 
    }

    //return charges of perticular service and respective discount - Atul chandankhede
    public function getTariffAmountAndDiscount($tariff_list_id=null,$tariff_standard_id=null){
        if(!$tariff_standard_id || !$tariff_list_id) return false ;
        $returnArray = array();
        $session = new CakeSession() ; 
        $hospitalType = $session->read('hospitaltype');
        
        if($hospitalType == 'NABH'){
            $fieldName = 'nabh_charges';
        }else{
            $fieldName = 'non_nabh_charges';                
        }       
        $result = $this->find('first',array('fields'=>array('TariffAmount.nabh_charges','TariffAmount.non_nabh_charges','TariffAmount.standard_tariff'),'conditions'=>array('TariffAmount.tariff_list_id'=>$tariff_list_id,
                'TariffAmount.tariff_standard_id'=>$tariff_standard_id)));
        
        $returnArray['amount'] = $result['TariffAmount'][$fieldName] ;
        $returnArray['discount'] = $result['TariffAmount']['standard_tariff'] ;
        return $returnArray ; //return nabh or non_nabh charges  and respective discount
    }
        
     
	
}