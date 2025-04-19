<?php
class City extends AppModel {

	public $name = 'City';
        		
	public $cacheQueries = false ;
	//public $useDbConfig = 'test';
	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
        	$session = new CakeSession();
			$this->db_name =  $session->read('db_name');
	 	}else{
	 		$this->db_name =  $ds;
	 	}
        parent::__construct($id, $table, $ds);
    }  
    
    function checkIsCityAvailable($city,$state_id){
    	if(!$city) return false ;
    	$session = new CakeSession();
    	if(!$state_id) return false ; //if state is not available
    	$result = $this->find('first',array('conditions'=>array('name'=>trim($city),'state_id'=>$state_id)));
    	if(!empty($result['City']['name'])){ 
    		return $result['City']['id'];
    	}else{  
    		$this->save(array('name'=>trim($city),'state_id'=>$state_id,
    				'created_by'=>$session->read('userid'),'create_time'=>date("Y-m-d H:i:s"),
    				'location_id'=>$session->read('locationid')));
    		return $this->id ; // return latest insert city id 
    	}
    	
    }
    /**
     * Function to City List
     * where loaction_id is not null
     * @param unknown_type loaction_ids
     * Mahalaxmi
     */
    public function getCityListId($data = array()){
        
        if(!empty($data)){
    	   $conditions['City.id']=$data;
        }
    	return $dataCities=$this->find('list',array('fields'=>array('id','name'),'conditions'=>$conditions,'order'=>array('id')));
    }
     /**
     * Function to City List
     * where loaction_id is not null
     * @param unknown_type loaction_ids
     * Mahalaxmi
     */
    public function getCitiesLists($data = array()){
       // debug($data);
        if(!$data) return ;
        $this->bindModel(array('belongsTo' => array(                          
                                'State' =>array('foreignKey'=>false,'conditions'=>array('State.id=City.state_id'),
                                            ),                                       
                                )
                        )); 
        $cityData = $this->find('all', array('fields'=> array('City.id', 'City.name'),'conditions'=>array('State.name'=>$data),'order'=>array('City.name'=>'ASC')));
      //  debug($cityData);
        foreach ($cityData  as $key => $value) {
            $cityArr[$value['City']['id']]=$value['City']['name'];
        }      
        return $cityArr;
    }
    
    
}
?>