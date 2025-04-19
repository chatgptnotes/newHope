<?php
/**
 * ServiceCategory file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Bed Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */

	
	
	class TariffSentence extends AppModel {
	
	
	public $name = 'TariffSentence';
		
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
			// To save data in tariff sentence

			public function saveSentences($arry){
				$arryData['TariffSentence']['sub_grp']=$arry['subGrp'];
				$arryData['TariffSentence']['template_name']=$arry['templateName'];
				$arryData['TariffSentence']['tariff_id']=$arry['tariffId'];
				if(isset($arry['id']))
					$arryData['TariffSentence']['id']=$arry['id'];
				$this->save($arryData['TariffSentence']);
			}

			public function getSentences($tariffId){
				return $this->find('all',array('conditions'=>array('tariff_id'=>$tariffId)));
			}
	
}