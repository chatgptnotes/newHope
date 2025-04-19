<?php

/* SubClaim model
 *
* PHP 5
*
* @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
* @link          http://www.klouddata.com/
* @package       Languages.Model
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Mayank Jain
*/
class SubClaim extends AppModel {
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $name = 'SubClaim';



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
	public function saveSubClaims($data){
		$Encounter= ClassRegistry::init('Encounter');	
		//debug($data);exit;
		$lastInsertID = $Encounter->getLastInsertID();
		if(empty($data['Encounter']['id'])){		
			
			if($data['Encounter']['primary_insurance']=='P'){
				$data['SubClaim']['encounter_id']=$lastInsertID;
				$data['SubClaim']['policy']=$data['Encounter']['primary_policy'];
				$data['SubClaim']['information_signature_clk']=$data['Encounter']['information_signature_clk'];
				$data['SubClaim']['executed_signature_clk']=$data['Encounter']['executed_signature_clk'];
				$data['SubClaim']['route']=$data['Encounter']['primary_route'];
				$data['SubClaim']['benifits_assignment']=$data['Encounter']['primary_benifits_assignment'];
				$data['SubClaim']['type']="Primary";
				$data['SubClaim']['amount']=$data['Encounter']['payment_amount'];				
				$getData=$this->saveAll($data['SubClaim']);
				//debug($getData);exit;
			}
			/*else if($data['Encounter']['primary_insurance']=='S'){

			}
			else if($data['Encounter']['primary_insurance']=='T'){

			}
			else{
			}*/
		}
		//********************************update Claims*****************************************************************
		else{		
			
			if($data['Encounter']['primary_insurance']=='P'){
				/* $data['SubClaim']['policy']=$data['Encounter']['primary_policy'];
				$data['SubClaim']['information_signature_clk']=$data['Encounter']['information_signature_clk'];
				$data['SubClaim']['executed_signature_clk']=$data['Encounter']['executed_signature_clk'];
				$data['SubClaim']['route']=$data['Encounter']['primary_route'];
				$data['SubClaim']['benifits_assignment']=$data['Encounter']['primary_benifits_assignment'];
				$data['SubClaim']['type']="Primary";
				$data['SubClaim']['amount']=$data['Encounter']['payment_amount'];
				debug($data['SubClaim']); */
				$getData=$this->updateAll(array('policy'=>"'".$data['Encounter']['primary_policy']."'",
						'information_signature_clk'=>"'".$data['Encounter']['information_signature_clk']."'",
						'executed_signature_clk'=>"'".$data['Encounter']['executed_signature_clk']."'",
						'primary_route'=>"'".$data['Encounter']['primary_route']."'",
						'primary_benifits_assignment'=>"'".$data['Encounter']['primary_benifits_assignment']."'",
						'amount'=>"'".$data['Encounter']['payment_amount']."'"),array('type'=>'P','encounter_id'=>$data['Encounter']['id']));		
			}				
		}
		return array($getData,$lastInsertID);
	}
}
?>