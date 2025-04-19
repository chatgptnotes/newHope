<?php
/**
 * 
  PHP 5
 *
 * @link          http://www.drmhope.com/
 * @package       Icd10.Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Pankaj Mankar
 */
class VoucherLog extends AppModel {

    public $specific = true;
    public $name = 'VoucherLog';
    var $useTable = 'voucher_logs';
    
    function __construct($id = false, $table = null, $ds = null) {
    	$session = new cakeSession();
    	$this->db_name =  $session->read('db_name');
    	parent::__construct($id, $table, $ds);
    }
    
    function insertVoucherLog($data=array()){
    	$session = new cakeSession();
    	if(empty($data['create_time'])){
    		$data['create_time'] = date('Y-m-d H:i:s');
    	}
    	if(empty($data['created_by'])){
    		$data['created_by'] = $session->read('userid');
    	}
    	if(empty($data['location_id'])){
    		$data['location_id'] = $session->read('locationid');
    	}
    	if(empty($data['date'])){
    		$data['date'] = date('Y-m-d H:i:s');
    	}
    	$this->save($data);
    	return true;
    }
    
    /**
     * function to return id from voucher_id and voucher_type
     * @param  int voucher_id
     * @param  char voucher_type - "Payment","Receipt","Contra","Journal" etc
     * @return id
     * @author Amit Jain
     */
    function getVoucherId($voucher_id=null,$voucher_type=null,$batch_identifier=null){
    	$session= new CakeSession();
    	if(empty($batch_identifier)){
    		$conditions['VoucherLog.id'] = $voucher_id;
    	}else{
    		$conditions['VoucherLog.batch_identifier'] = $batch_identifier;
    	}
    	$result = $this->find('first',array('fields'=>array('VoucherLog.id'),
    			'conditions'=>array('VoucherLog.voucher_type'=>$voucher_type,'VoucherLog.location_id'=>$session->read('locationid'),$conditions),
    			));
    	return $result['VoucherLog']['id'];
    }
    
    /**
     * function to Voucher Entry in log
     * @param  array request data
     * @return true/false
     * @author Amit Jain
     */
    function insertJvLog($reqData=array()){
    	$reqData['debit_amount'] = $reqData['total'];
    	$this->insertVoucherLog($reqData);
    	return $this->id;
    }
    
    /**
     * function for get count of entry 
     * @param  $id = Account id
     * @return count
     * @author Amit Jain
     */
    function getEntryCount($id){
    	$session= new CakeSession();
    	return $this->find('count',array('conditions'=>array('OR'=>array('VoucherLog.user_id'=>$id,'VoucherLog.account_id'=>$id),'VoucherLog.is_deleted'=>0,
    			'VoucherLog.location_id'=>$session->read('locationid'))));
    }
}
