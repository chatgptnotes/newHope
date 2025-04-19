<?php
/**
 * @model LeaveApproval model
 * @author Swapnil
 * @created : 08.03.2016
 */

	class LeaveApproval extends AppModel {

		public $name = 'LeaveApproval';  
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
            
            public function getAllPreviousLeave($userId,$date){ 
                if(empty($userId)) return;
                $returnArr = array();
                $result = $this->find('all',array(
                    'fields'=>array(
                        'leave_type','leave_from'
                    ),
                    'conditions'=>array(
                        'user_id'=>$userId,
                        'MONTH(leave_from) NOT'=>date('m', strtotime($date)),
                        'YEAR(leave_from)'=>date('Y', strtotime($date)),
                        'is_deleted'=>'0',
                        'is_approved'=>'1'
                    ),
                    'group'=>array( 
                        'leave_type','id'
                    )
                )); 
                foreach($result as $key => $val){
                    $returnArr[$val['LeaveApproval']['leave_type']][] = $val['LeaveApproval']['leave_from'];
                }
                return $returnArr;
            }
             
    /*
    * function to get the logined user
    * @author : Swapnil
    * @created : 12.03.2016
    */
    public function getTodaysLeave(){
        return $this->find('count',array('conditions'=>array('is_deleted'=>'0','leave_from'=>date("Y-m-d"))));
    }
    
    /*
    * function to get all paid Leaves of current month
    * @author : Swapnil
    * @created : 12.03.2016
    */
    public function getAllPaidLeavesCount($year,$month,$date){ 
        if(!empty($date)){
            $conditions['LeaveApproval.leave_from'] = $year."-".$month."-".$date;
        }else{
            $conditions['YEAR(LeaveApproval.leave_from)'] = $year;
            $conditions['MONTH(LeaveApproval.leave_from)'] = $month;
        }
        $leaveData = $this->find('all',array(
            'fields'=>array(
                'COUNT(LeaveApproval.leave_type) as count,LeaveApproval.leave_type'
            ),
            'conditions'=>array($conditions,  
                'LeaveApproval.is_deleted'=>'0',
                'LeaveApproval.is_approved'=>'1'),
            'group'=>array(
                'LeaveApproval.leave_type'
            )
        ));  
        foreach($leaveData as $key => $val){
            $returnArr[$val['LeaveApproval']['leave_type']] = $val[0]['count'];
        }   
        return $returnArr;
    } 
    
    
    /*
    * function to get list of leave request from date difference of particular user
    * @author : Swapnil
    * @created : 12.03.2016
    */
    public function getAllLeavesListofUser($userId,$from,$to){ 
        if(empty($userId)){
            return false;
        } 
        $leaveData = $this->find('all',array(
            'fields'=>array(
                'LeaveApproval.id, LeaveApproval.leave_type, LeaveApproval.leave_from, LeaveApproval.is_approved '
            ),
            'conditions'=>array(  
                'LeaveApproval.is_deleted'=>'0',
                'LeaveApproval.user_id'=>$userId,
                'LeaveApproval.leave_from BETWEEN ?AND?'=>array($from,$to)),
            'group'=>array(
                'LeaveApproval.id'
            )
        ));    
        return $leaveData;
    } 
} 
?>