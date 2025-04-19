<?php
/**
 * TariffCharge Model file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 Drmhope Softwares  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       Hope
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Gaurav Chauriya
*/


class TariffCharge extends AppModel {

	public $name = 'TariffCharge';
	public $useTable = 'tariff_charges';	
	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    } 
	public function saveDayWiseTariff($data = array()){
		$session = new cakeSession();
		if(empty($data['TariffCharge']['tariff_amount_id'])){
			$TariffAmount = Classregistry::init('TariffAmount');
			$addTariffAmount =  $data['TariffCharge'] ;
			$addTariffAmount['location_id'] =  $session->read('locationid') ;
			$addTariffAmount['created_by'] =  $session->read('userid') ;
			$addTariffAmount['create_time'] =  date('Y-m-d H:i:s') ;
			$TariffAmount->save($addTariffAmount);
			$data['TariffCharge']['tariff_amount_id'] = $TariffAmount->id ;
		}
		
			if(empty($data['TariffCharge']['id'])){
				$data['TariffCharge']['location_id'] =  $session->read('locationid') ;
				$data['TariffCharge']['created_by'] =  $session->read('userid') ;
				$data['TariffCharge']['create_time'] =  date('Y-m-d H:i:s') ;
			}else{
				$data['TariffCharge']['location_id'] =  $session->read('locationid') ;
				$data['TariffCharge']['modified_by'] =  $session->read('userid') ;
				$data['TariffCharge']['modify_time'] =  date('Y-m-d H:i:s') ;
			}
		$this->save($data);
		$this->updateAll(array('TariffCharge.unit_days' => "'".$data['TariffCharge']['unit_days']."'"),
				array('TariffCharge.tariff_list_id' => $data['TariffCharge']['tariff_list_id'],'TariffCharge.doctor_id'=>$data['TariffCharge']['doctor_id'])
		);
	}
}
