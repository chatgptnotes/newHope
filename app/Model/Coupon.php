<?php 
/**
 *CouponGenration model
 *
 * PHP 5
 *
 * @copyright     ----
 * @link          http://www.drmhope.com/
 * @package       CouponGenration Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Swati Newale
 */
class Coupon extends AppModel {

	public $name = 'Coupon';
	var $useTable = 'coupons';
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

	/**
	 * function to insert coupon 
	 * @param array $data
	 * @return boolean
	 * @author Swati Newale
	 */
	public function saveCouponData($data = array()){
		$session = new cakeSession ();
		if(!empty($data['valid_date_from'] ))
			$data['valid_date_from']= DateFormatComponent::formatDate2STD($data['valid_date_from'],Configure::read('date_format'));
		if(!empty($data['valid_date_to'] ))
			$data['valid_date_to']= DateFormatComponent::formatDate2STD($data['valid_date_to'],Configure::read('date_format'));
		if(!empty($data['coupon_amount']))
			foreach ($data['coupon_amount'] as $k => $v){ 
			 $data['sevices_available'][] = $v['serviceId'];
			}
			$data['sevices_available'] = ','.implode(',',$data['sevices_available']).',';
			$data['coupon_amount'] = serialize($data['coupon_amount']);
		
		if($data['id']){
			$couponId = $data['id'];
			$data['modified_time'] = date('Y-m-d H:i:s');
			$data['modified_by'] = $session->read('userid');
			$data['location_id'] = $session->read('locationid');
			$data['sevices_available'] = $data['sevices_available'];
			unset($data['batch_name'],$data['id']);
			
			foreach($data as $key=>$value){
				$data[$key] = "'$value'";
			}
			#debug($data);exit;
			$this->updateAll($data,array('OR'=>array('Coupon.id' => $couponId, 'Coupon.parent_id' => $couponId), 'Coupon.status' => 0));
		}else{
			$data['create_time'] = date('Y-m-d H:i:s');
			$data['created_by'] = $session->read('userid');
			$data['location_id'] = $session->read('locationid');
			//debug($data);exit;
			$this->save($data);
			$this->generateCoupon($this->id,$data);
		}
	}
	
	/**
	 * 
	 */
	public function generateCoupon($couponParentId , $data){
		$session = new cakeSession ();
		$data['parent_id'] = $couponParentId;
		for($i = 1; $i<= $data['no_of_coupons'] ; $i++){
			//generate a random id encrypt it and store it in $uniqueCouponNumber
			$uniqueCouponNumber = crypt(uniqid(rand(),1));
			//to remove any slashes that might have come
			$uniqueCouponNumber = strip_tags(stripslashes($uniqueCouponNumber));
			//Removing any . or / and reversing the string
			$uniqueCouponNumber = str_replace(".","",$uniqueCouponNumber);
			$uniqueCouponNumber = strrev(str_replace("/","",$uniqueCouponNumber));
			$data['batch_name'] = strtoupper(substr($uniqueCouponNumber,0,6));
			$this->create();
			$this->save($data);
		}
	}
}
?>