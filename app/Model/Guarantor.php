<?php
class Guarantor extends AppModel {

	public $name = 'Guarantor';

	public $cacheQueries = false ;


	public $specific = true;

	/*public $virtualFields = array(
	 'Guarantor.full_name' => 'CONCAT(Guarantor.gau_first_name," ", Guarantor.gau_last_name)'
	);*/

	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}

	
	function insertGuarantor($data =array(),$action='insert',$id,$addressData,$contactData){
		//debug($data['Person']);debug($addressData);debug($contactData);exit;

		$addressData['is_active']=array_values($addressData['is_active']);
		$contactData['is_active']=array_values($contactData['is_active']);
		
		$this->uses=array('Guarantor');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
		$dateFormat = ClassRegistry::init('DateFormatComponent');
		$this->create();
		$efdate = $dateFormat->formatDate2STD($data['Person']['gau_eff_date_add'],Configure::read('date_format_us'));
		$enddate = $dateFormat->formatDate2STD($data['Person']['gau_end_date_add'],Configure::read('date_format_us'));
		$dob = $dateFormat->formatDate2STD($data['Person']['dobg'],Configure::read('date_format_us'));
		//debug($data);exit;
		if(!empty($data['Person']['gau_first_name'])){
			$this->saveAll(array('gau_initial_id'=>$data['Person']['gau_initial_id'],'gau_first_name'=>$data['Person']['gau_first_name'],
				'gau_middle_name'=>$data['Person']['gau_middle_name'],'ckeckGua_patient_portal'=>$data['Person']['ckeckGua_patient_portal'],
				'gau_last_name'=>$data['Person']['gau_last_name'],'special_need'=>$data['Person']['special_need'],
				'gau_tele_code'=>$data['Person']['gau_tele_code'],'gau_equi_code'=>$data['Person']['gau_equi_code'],
				'venteran'=>$data['Person']['venteran'],'vip'=>$data['Person']['vip'],'is_active_gua'=>$data['Person']['is_active_gua'],'is_active_address'=>$data['Person']['is_active_address'],
				'gau_county'=>$data['Person']['gau_county'],'guarantor_id'=>$data['Person']['guarantor_id'],'is_active_contact'=>$data['Person']['is_active_contact'],
				'epi_id'=>$data['Person']['epi_id'],'dobg'=>$dob,'gau_sex'=>$data['Person']['gau_sex'],
				'gau_ssn'=>$data['Person']['gau_ssn'],'relation'=>$data['Person']['relation'],'gau_plot_no'=>$data['Person']['gau_plot_no'],
				'gau_landmark'=>$data['Person']['gau_landmark'],'gau_city'=>$data['Person']['gau_city'],
				'gau_state'=>$data['Person']['gau_state'],'gau_zip'=>$data['Person']['gau_zip'],'gau_work'=>$data['Person']['gau_work'],
				'gau_home_phone'=>$data['Person']['gau_home_phone'],'gau_mobile'=>$data['Person']['gau_mobile'],
				'gau_email'=>$data['Person']['gau_email'],'gau_fax'=>$data['Person']['gau_fax'],'gau_country'=>$data['Person']['gau_country'],
				'gau_country_code'=>$data['Person']['gau_country_code'],'gau_city_code'=>$data['Person']['gau_city_code'],
				'gau_local_number'=>$data['Person']['gau_local_number'],'gau_any_text'=>$data['Person']['gau_any_text'],
				'gau_extension'=>$data['Person']['gau_extension'],'gau_eff_date_add'=>$efdate,'gau_address_type'=>$data['Person']['gau_address_type'],
				'gau_end_date_add'=>$enddate,'gau_primary_chk'=>$data['Person']['gau_primary_chk'],'person_id' => $id));
		}
		///return($latest_insert_id);
		//debug($addressData);exit;
		
		$guaID=$this->getInsertId();
		$this->updateAll(array('Guarantor.order_id'=>$guaID),array('Guarantor.id'=> $guaID));
		
		$caregiverAddress = ClassRegistry::init('CaregiverAddress');
		$size = count($addressData['gau_plot_no']);
		//$address->deleteAll(array('Address.address_type_id' => $person_id), false);
		for($p=$size-1;$p>=0;$p--)
		{
			if(!empty($addressData['gau_plot_no'][$p])){
				$resetData['CaregiverAddress'][$p]['guarantor_id'] = $guaID;
				$resetData['CaregiverAddress'][$p]['gau_address_type'] =  $addressData['gau_address_type'][$p];
				$resetData['CaregiverAddress'][$p]['gau_plot_no'] =  $addressData['gau_plot_no'][$p];
				$resetData['CaregiverAddress'][$p]['gau_landmark'] = $addressData['gau_landmark'][$p];
				$resetData['CaregiverAddress'][$p]['gau_city']=  $addressData['gau_city'][$p];
				$resetData['CaregiverAddress'][$p]['gau_state']= $addressData['gau_state'][$p];
				$resetData['CaregiverAddress'][$p]['gau_zip']= $addressData['gau_zip'][$p];
				$resetData['CaregiverAddress'][$p]['gau_country']=$addressData['gau_country'][$p];
				$resetData['CaregiverAddress'][$p]['special_need']=  $addressData['special_need'][$p];
				$resetData['CaregiverAddress'][$p]['gau_county']=  $addressData['gau_county'][$p];
				$resetData['CaregiverAddress'][$p]['is_active']=  $addressData['is_active'][$p];
			}
		}//debug($resetData['CaregiverAddress']);
		$caregiverAddress->saveAll($resetData['CaregiverAddress']);
		
		$caregiverContact = ClassRegistry::init('CaregiverContact');
		$size1 = count($contactData['gau_tele_code']);
		//$address->deleteAll(array('Address.address_type_id' => $person_id), false);
		for($q=$size1-1;$q>=0;$q--)
		{
			if(!empty($contactData['gau_tele_code'][$q])){
			$resetData['CaregiverContact'][$q]['guarantor_id'] = $guaID;
			$resetData['CaregiverContact'][$q]['gau_tele_code'] =  $contactData['gau_tele_code'][$q];
			$resetData['CaregiverContact'][$q]['gau_equi_code'] = $contactData['gau_equi_code'][$q];
			$resetData['CaregiverContact'][$q]['gau_city_code']=  $contactData['gau_city_code'][$q];
			$resetData['CaregiverContact'][$q]['gau_country_code']= $contactData['gau_country_code'][$q];
			$resetData['CaregiverContact'][$q]['gau_email']= $contactData['gau_email'][$q];
			$resetData['CaregiverContact'][$q]['gau_local_number']=$contactData['gau_local_number'][$q];
			$resetData['CaregiverContact'][$q]['gau_any_text']=  $contactData['gau_any_text'][$q];
			$resetData['CaregiverContact'][$q]['gau_extension']=  $contactData['gau_extension'][$q];
			$resetData['CaregiverContact'][$q]['is_active']=  $contactData['is_active'][$q];
			}
		}//debug($resetData['CaregiverContact']);exit;
		$caregiverContact->saveAll($resetData['CaregiverContact']);
	}
	

	/****BOF add more guarantor****/
	function addmoreGuarantor($data,$person_id,$addressData1,$addressData2,$contactData1,$contactData2){
		
		$data['is_active_gua']=array_values($data['is_active_gua']);
		$data['is_active_address']=array_values($data['is_active_address']);
		$data['is_active_contact']=array_values($data['is_active_contact']);
		
		$addressData1['is_active']=array_values($addressData1['is_active']);
		$addressData2['is_active']=array_values($addressData2['is_active']);
		$contactData1['is_active']=array_values($contactData1['is_active']);
		$contactData2['is_active']=array_values($contactData2['is_active']);
		
		$guarantor = ClassRegistry::init('Guarantor');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
		$dateFormat = ClassRegistry::init('DateFormatComponent');
		$sizeg = count($data['gau_first_name']);
		//$guarantor->deleteAll(array('Guarantor.person_id' => $person_id), false);
		for($s=$sizeg-1;$s>=0;$s--)
		{
			if(!empty($data['gau_first_name'])){
				$dob = $dateFormat->formatDate2STD($data['dobg'][$s],Configure::read('date_format_us'));
				$efdate = $dateFormat->formatDate2STD($data['gau_eff_date_add'][$s],Configure::read('date_format_us'));
				$enddate = $dateFormat->formatDate2STD($data['gau_end_date_add'][$s],Configure::read('date_format_us'));
				$resetData['Guarantor'][$s]['gau_initial_id'] = $data['gau_initial_id'][$s];
				$resetData['Guarantor'][$s]['relation'] = $data['relation'][$s];
				$resetData['Guarantor'][$s]['gau_first_name'] =  $data['gau_first_name'][$s];
				$resetData['Guarantor'][$s]['gau_sex']=  $data['gau_sex'][$s];
				$resetData['Guarantor'][$s]['gau_middle_name']= $data['gau_middle_name'][$s];
				$resetData['Guarantor'][$s]['dobg']= $dob;
				$resetData['Guarantor'][$s]['gau_last_name']=$data['gau_last_name'][$s];
				$resetData['Guarantor'][$s]['gau_ssn']=  $data['gau_ssn'][$s];
				$resetData['Guarantor'][$s]['gau_eff_date_add'] = $efdate;
				$resetData['Guarantor'][$s]['gau_end_date_add'] = $enddate;
				$resetData['Guarantor'][$s]['guarantor_id'] =  $data['guarantor_id'][$s];
				$resetData['Guarantor'][$s]['epi_id']=  $data['epi_id'][$s];
				$resetData['Guarantor'][$s]['gau_address_type']= $data['gau_address_type'][$s];
				$resetData['Guarantor'][$s]['gau_plot_no']= $data['gau_plot_no'][$s];
				$resetData['Guarantor'][$s]['gau_landmark']= $data['gau_landmark'][$s];
				$resetData['Guarantor'][$s]['gau_city']=$data['gau_city'][$s];
				$resetData['Guarantor'][$s]['gau_state']=  $data['gau_state'][$s];
				$resetData['Guarantor'][$s]['gau_zip'] =  $data['gau_zip'][$s];
				$resetData['Guarantor'][$s]['gau_country']=  $data['gau_country'][$s];
				$resetData['Guarantor'][$s]['special_need']=  $data['special_need'][$s];
				$resetData['Guarantor'][$s]['gau_primary_chk']= $data['gau_primary_chk'][$s];
				$resetData['Guarantor'][$s]['venteran']= $data['venteran'][$s];
				$resetData['Guarantor'][$s]['vip']= $data['vip'][$s];
				$resetData['Guarantor'][$s]['gau_county']= $data['gau_county'][$s];
				$resetData['Guarantor'][$s]['gau_tele_code']=$data['gau_tele_code'][$s];
				$resetData['Guarantor'][$s]['gau_equi_code']=  $data['gau_equi_code'][$s];
				$resetData['Guarantor'][$s]['gau_city_code'] =  $data['gau_city_code'][$s];
				$resetData['Guarantor'][$s]['gau_country_code']=  $data['gau_country_code'][$s];
				$resetData['Guarantor'][$s]['gau_email']= $data['gau_email'][$s];
				$resetData['Guarantor'][$s]['gau_local_number']= $data['gau_local_number'][$s];
				$resetData['Guarantor'][$s]['gau_any_text']=$data['gau_any_text'][$s];
				$resetData['Guarantor'][$s]['gau_extension']=  $data['gau_extension'][$s];
				$resetData['Guarantor'][$s]['is_active_gua']=  $data['is_active_gua'][$s];
				$resetData['Guarantor'][$s]['is_active_address']=  $data['is_active_address'][$s];
				$resetData['Guarantor'][$s]['is_active_contact']=  $data['is_active_contact'][$s];
				$resetData['Guarantor'][$s]['person_id']=  $person_id;
				$guarantor->id = '';
				$guarantor->save($resetData['Guarantor'][$s]); // save gaurantor
				$guarantor->updateAll(array('Guarantor.order_id'=>$guarantor->id),array('Guarantor.id'=> $guarantor->id));
				$caregiverAddress = ClassRegistry::init('CaregiverAddress');
				$sizea = count($addressData1['gau_plot_no']);
				for($y=$sizea-1;$y>=0;$y--)
				{
					if(!empty($addressData1['gau_plot_no'])){
						$resetData['CaregiverAddress'][$y]['guarantor_id'] = $guarantor->id;
						$resetData['CaregiverAddress'][$y]['gau_address_type'] =  $addressData1['gau_address_type'][$y];
						$resetData['CaregiverAddress'][$y]['gau_plot_no'] =  $addressData1['gau_plot_no'][$y];
						$resetData['CaregiverAddress'][$y]['gau_landmark'] = $addressData1['gau_landmark'][$y];
						$resetData['CaregiverAddress'][$y]['gau_city']=  $addressData1['gau_city'][$y];
						$resetData['CaregiverAddress'][$y]['gau_state']= $addressData1['gau_state'][$y];
						$resetData['CaregiverAddress'][$y]['gau_zip']= $addressData1['gau_zip'][$y];
						$resetData['CaregiverAddress'][$y]['gau_country']=$addressData1['gau_country'][$y];
						$resetData['CaregiverAddress'][$y]['special_need']=  $addressData1['special_need'][$y];
						$resetData['CaregiverAddress'][$y]['gau_county']=  $addressData1['gau_county'][$y];
						$resetData['CaregiverAddress'][$y]['is_active']=  $addressData1['is_active_address'][$y];
					}
				}//debug($resetData['CaregiverAddress']);
				$caregiverAddress->saveAll($resetData['CaregiverAddress']);
				$addressData1 = $addressData2;//shifting variable to add next address array
				
				$caregiverContact = ClassRegistry::init('CaregiverContact');
				$sizec = count($contactData1['gau_tele_code']);
				for($z=$sizec-1;$z>=0;$z--)
				{
					if(!empty($contactData1['gau_tele_code'])){
						$resetData['CaregiverContact'][$z]['guarantor_id'] = $guarantor->id;
						$resetData['CaregiverContact'][$z]['gau_tele_code'] =  $contactData1['gau_tele_code'][$z];
						$resetData['CaregiverContact'][$z]['gau_equi_code'] = $contactData1['gau_equi_code'][$z];
						$resetData['CaregiverContact'][$z]['gau_city_code']=  $contactData1['gau_city_code'][$z];
						$resetData['CaregiverContact'][$z]['gau_country_code']= $contactData1['gau_country_code'][$z];
						$resetData['CaregiverContact'][$z]['gau_email']= $contactData1['gau_email'][$z];
						$resetData['CaregiverContact'][$z]['gau_local_number']=$contactData1['gau_local_number'][$z];
						$resetData['CaregiverContact'][$z]['gau_any_text']=  $contactData1['gau_any_text'][$z];
						$resetData['CaregiverContact'][$z]['gau_extension']=  $contactData1['gau_extension'][$z];
						$resetData['CaregiverContact'][$z]['is_active']=  $contactData1['is_active_contact'][$z];
					}
				}//debug($resetData['CaregiverContact']);exit;
				$caregiverContact->saveAll($resetData['CaregiverContact']);
				$contactData1 = $contactData2;//shifting variable to add next contact array
			}
		}
	}
	/****EOF add more guarantor****/
	
	
	/****BOF edit add more guarantor****/
	function editmoreGuarantor($data,$person_id,$addressData0,$addressData1,$addressData2,$contactData0,$contactData1,$contactData2){
		
		$data['is_active_gua']=array_values($data['is_active_gua']);
		$data['is_active_address']=array_values($data['is_active_address']);
		$data['is_active_contact']=array_values($data['is_active_contact']);
		
		$addressData0['is_active']=array_values($addressData0['is_active']);
		$addressData1['is_active']=array_values($addressData1['is_active']);
		$addressData2['is_active']=array_values($addressData2['is_active']);
		$contactData0['is_active']=array_values($contactData0['is_active']);
		$contactData1['is_active']=array_values($contactData1['is_active']);
		$contactData2['is_active']=array_values($contactData2['is_active']);
		
		$guarantor = ClassRegistry::init('Guarantor');
		$caregiverAddress = ClassRegistry::init('CaregiverAddress');
		$caregiverContact = ClassRegistry::init('CaregiverContact');
		$session     = new cakeSession();
		$userid 	 = $session->read('userid') ;
		$locationId  = $session->read('locationid') ;
		$dateFormat = ClassRegistry::init('DateFormatComponent');
		$sizeg = count($data['gau_first_name']);
		
		//first delete previous address
		$guarantor->deleteAll(array('Guarantor.person_id' => $person_id), false);
		$caregiverAddress->deleteAll(array('CaregiverAddress.person_id' => $person_id), false); 
		$caregiverContact->deleteAll(array('CaregiverContact.person_id' => $person_id), false);
		for($s=$sizeg-1;$s>=0;$s--)
		{
			if(!empty($data['gau_first_name'])){
				$dob = $dateFormat->formatDate2STD($data['dobg'][$s],Configure::read('date_format_us'));
				$efdate = $dateFormat->formatDate2STD($data['gau_eff_date_add'][$s],Configure::read('date_format_us'));
				$enddate = $dateFormat->formatDate2STD($data['gau_end_date_add'][$s],Configure::read('date_format_us'));
				$resetData['Guarantor'][$s]['gau_initial_id'] = $data['gau_initial_id'][$s];
				$resetData['Guarantor'][$s]['relation'] = $data['relation'][$s];
				$resetData['Guarantor'][$s]['gau_first_name'] =  $data['gau_first_name'][$s];
				$resetData['Guarantor'][$s]['gau_sex']=  $data['gau_sex'][$s];
				$resetData['Guarantor'][$s]['gau_middle_name']= $data['gau_middle_name'][$s];
				$resetData['Guarantor'][$s]['dobg']= $dob;
				$resetData['Guarantor'][$s]['gau_last_name']=$data['gau_last_name'][$s];
				$resetData['Guarantor'][$s]['gau_ssn']=  $data['gau_ssn'][$s];
				$resetData['Guarantor'][$s]['gau_eff_date_add'] = $efdate;
				$resetData['Guarantor'][$s]['gau_end_date_add'] = $enddate;
				$resetData['Guarantor'][$s]['guarantor_id'] =  $data['guarantor_id'][$s];
				$resetData['Guarantor'][$s]['epi_id']=  $data['epi_id'][$s];
				$resetData['Guarantor'][$s]['gau_address_type']= $data['gau_address_type'][$s];
				$resetData['Guarantor'][$s]['gau_plot_no']= $data['gau_plot_no'][$s];
				$resetData['Guarantor'][$s]['gau_landmark']= $data['gau_landmark'][$s];
				$resetData['Guarantor'][$s]['gau_city']=$data['gau_city'][$s];
				$resetData['Guarantor'][$s]['gau_state']=  $data['gau_state'][$s];
				$resetData['Guarantor'][$s]['gau_zip'] =  $data['gau_zip'][$s];
				$resetData['Guarantor'][$s]['gau_country']=  $data['gau_country'][$s];
				$resetData['Guarantor'][$s]['special_need']=  $data['special_need'][$s];
				$resetData['Guarantor'][$s]['gau_primary_chk']= $data['gau_primary_chk'][$s];
				$resetData['Guarantor'][$s]['venteran']= $data['venteran'][$s];
				$resetData['Guarantor'][$s]['vip']= $data['vip'][$s];
				$resetData['Guarantor'][$s]['gau_county']= $data['gau_county'][$s];
				$resetData['Guarantor'][$s]['gau_tele_code']=$data['gau_tele_code'][$s];
				$resetData['Guarantor'][$s]['gau_equi_code']=  $data['gau_equi_code'][$s];
				$resetData['Guarantor'][$s]['gau_city_code'] =  $data['gau_city_code'][$s];
				$resetData['Guarantor'][$s]['gau_country_code']=  $data['gau_country_code'][$s];
				$resetData['Guarantor'][$s]['gau_email']= $data['gau_email'][$s];
				$resetData['Guarantor'][$s]['gau_local_number']= $data['gau_local_number'][$s];
				$resetData['Guarantor'][$s]['gau_any_text']=$data['gau_any_text'][$s];
				$resetData['Guarantor'][$s]['gau_extension']=  $data['gau_extension'][$s];
				$resetData['Guarantor'][$s]['is_active_gua']=  $data['is_active_gua'][$s];
				$resetData['Guarantor'][$s]['is_active_address']=  $data['is_active_address'][$s];
				$resetData['Guarantor'][$s]['is_active_contact']=  $data['is_active_contact'][$s];
				$resetData['Guarantor'][$s]['order_id']=  $data['order_id'][$s];
				$resetData['Guarantor'][$s]['person_id']=  $person_id;
				$guarantor->id = '';
				
				$guarantor->save($resetData['Guarantor'][$s]); // save gaurantor
				
				$sizea = count($addressData0['gau_plot_no']);
				
				for($y=$sizea-1;$y>=0;$y--)
				{
					if(!empty($addressData0['gau_plot_no'])){
						$resetData['CaregiverAddress'][$y]['guarantor_id'] = $guarantor->id;
						$resetData['CaregiverAddress'][$y]['gau_address_type'] =  $addressData0['gau_address_type'][$y];
						$resetData['CaregiverAddress'][$y]['gau_plot_no'] =  $addressData0['gau_plot_no'][$y];
						$resetData['CaregiverAddress'][$y]['gau_landmark'] = $addressData0['gau_landmark'][$y];
						$resetData['CaregiverAddress'][$y]['gau_city']=  $addressData0['gau_city'][$y];
						$resetData['CaregiverAddress'][$y]['gau_state']= $addressData0['gau_state'][$y];
						$resetData['CaregiverAddress'][$y]['gau_zip']= $addressData0['gau_zip'][$y];
						$resetData['CaregiverAddress'][$y]['gau_country']=$addressData0['gau_country'][$y];
						$resetData['CaregiverAddress'][$y]['special_need']=  $addressData0['special_need'][$y];
						$resetData['CaregiverAddress'][$y]['gau_county']=  $addressData0['gau_county'][$y];
						$resetData['CaregiverAddress'][$y]['is_active']=  $addressData0['is_active_address'][$y];
						$resetData['CaregiverAddress'][$y]['person_id']=  $person_id;
						//$caregiverAddress->id = '';
					}
				}
				$caregiverAddress->saveAll($resetData['CaregiverAddress']);
				$addressData0 = $addressData1;//shifting variable to add next address array
				$addressData1 = $addressData2;
				
				$sizec = count($contactData0['gau_tele_code']);
				for($z=$sizec-1;$z>=0;$z--)
				{
					if(!empty($contactData0['gau_tele_code'])){
						$resetData['CaregiverContact'][$z]['guarantor_id'] = $guarantor->id;
						$resetData['CaregiverContact'][$z]['gau_tele_code'] =  $contactData0['gau_tele_code'][$z];
						$resetData['CaregiverContact'][$z]['gau_equi_code'] = $contactData0['gau_equi_code'][$z];
						$resetData['CaregiverContact'][$z]['gau_city_code']=  $contactData0['gau_city_code'][$z];
						$resetData['CaregiverContact'][$z]['gau_country_code']= $contactData0['gau_country_code'][$z];
						$resetData['CaregiverContact'][$z]['gau_email']= $contactData0['gau_email'][$z];
						$resetData['CaregiverContact'][$z]['gau_local_number']=$contactData0['gau_local_number'][$z];
						$resetData['CaregiverContact'][$z]['gau_any_text']=  $contactData0['gau_any_text'][$z];
						$resetData['CaregiverContact'][$z]['gau_extension']=  $contactData0['gau_extension'][$z];
						$resetData['CaregiverContact'][$z]['is_active']=  $contactData0['is_active_contact'][$z];
						$resetData['CaregiverContact'][$z]['person_id']=  $person_id;
						$caregiverContact->id = '';
					}
				}//debug($resetData['CaregiverContact']);exit;
				$caregiverContact->saveAll($resetData['CaregiverContact']);
				$contactData0 = $contactData1;//shifting variable to add next contact array
				$contactData1 = $contactData2;
				}
			$guarantor->id= '';
		}
	}
	/****EOF edit add more guarantor****/
}
?>