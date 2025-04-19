<style>
#printButton {
	position: relative !important;
}
</style>
<div style="float: right; text-align: center;" id="printButton">
		<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
	</div>
<!-- Right Part Template -->
<div align="center" class="heading" style="text-decoration: none;">
		<?php echo __('Lab Requisition Slip'); ?> 
	</div>

<div style="float: left; width: 100%; padding-bottom: 10px;">
	<?php
	
	if (file_exists ( WWW_ROOT . "/uploads/qrcodes/labOrderQrCard/" . $test_ordered ['0'] ['LaboratoryToken'] ['ac_id'] . ".png" )) {
		echo $this->Html->image ( "/uploads/qrcodes/labOrderQrCard/" . $test_ordered ['0'] ['LaboratoryToken'] ['ac_id'] . ".png", array (
				'alt' => $test_ordered ['0'] ['LaboratoryToken'] ['ac_id'],
				'title' => $test_ordered ['0'] ['LaboratoryToken'] ['ac_id'],
				'width' => '30%',
				'height' => '52' 
		) );
	}
	?></div>

<?php
// echo '<pre>';print_r($test_ordered);
$date = date ( 'm/d/Y H:i:s' );
$date1 = explode ( " ", $date );
$date = $date1 ['0'];
$time = $date1 ['1'];
?>
<div>
	<div><?php //echo __('Vendor: Physician\'s Portal of Renaissance analytics, Powered by Dr.M'); ?></div>
	<div><?php //echo __('Paragon Patient ID :'.$accountID['Person']['alternate_patient_uid']); ?></div>
	<!--  <div><?php echo __('Renaissance Lab ID :'.$test_ordered['0']['LaboratoryResult']['dhr_laboratory_patient_id']); ?></div>-->
	<div><?php echo __('Current Date: '.$date); ?></div>
	<div><?php echo __('Current Time: '.$time); ?></div>
</div>
<div>&nbsp;</div>

<div>
	<strong><i><?php echo __('Client Information: '); ?></i></strong>
</div>
<table border="0" cellspacing="1" cellpadding="3" class="tbl"
	width="100%" style="text-align: left;">
	<tr class=" ">
		<td class=" " width="20%"><strong><?php echo __('Name: ', true); ?></strong></td>
		<td class=" "><?php echo $this->Session->read('location_name'); ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Address: ', true); ?></strong></td> 
			   <?php if(!empty($clientInfo['Facility']['address2'])){$space=', ';}else{$space='';} ?>
			   <td class=" "><?php echo $clientInfo['Facility']['address1'].''.$space.''. $clientInfo['Facility']['address2'];?></td>
	</tr>

	<tr class=" ">
		<td class=" "><strong><?php echo __('Zip Code : ', true); ?></strong></td>
		<td class=" "><?php echo $clientInfo['Facility']['zipcode']; ?></td>
	</tr>

	<tr class=" ">
		<td class=" "><strong><?php echo __('City : ', true); ?></strong></td>
		<td class=" "><?php echo $clientInfo['City']['name']; ?></td>
	</tr>

	<tr class=" ">
		<td class=" "><strong><?php echo __('State : ', true); ?></strong></td>
		<td class=" "><?php echo $clientInfo['State']['name']; ?></td>
	</tr>

	<tr class=" ">
		<td class=" "><strong><?php echo __('Country : ', true); ?></strong></td>
		<td class=" "><?php echo $clientInfo['Country']['name']; ?></td>
	</tr>

	<tr class=" ">
		<td class=" "><strong><?php echo __('Account No. : ', true); ?></strong></td>
		<td class=" "><?php echo __('8227'); ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Phone Number:', true); ?></strong></td> 
			   <?php if(!empty($clientInfo['Facility']['phone1']))$phone=$clientInfo['Facility']['phone1'];else$phone=$clientInfo['Facility']['mobile']?>
			   <td class=" "><?php echo $phone; ?></td>
	</tr>
</table>
<div>&nbsp;</div>
<?php //debug($test_ordered);?>
<div>
	<strong><i><?php echo __('Requisition/ Physician Information: '); ?></i></strong>
</div>
<table border="0" cellspacing="1" cellpadding="3" class="tbl"
	width="100%" style="text-align: left;">
	<tr class=" ">
		<td class=" " width="30%"><strong><?php echo __('Requisition/ Ctrl Number(CD-): ', true); ?></strong></td>
		<td class=" "><?php echo $test_ordered['0']['LaboratoryToken']['ac_id'];  ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Physician Name: ', true); ?></strong></td>
		<td class=" "><?php $name= explode(".",$treatingConsultantData[0]['fullname']);
							if(count($name) == 2){
							 echo $treatingConsultantData['Initial']['initial_name'].$name[1];//$treatingConsultantData[0]['fullname'];$this->Session->read('first_name') ." ".$this->Session->read('last_name'); //echo $test_ordered['0']['LaboratoryToken']['primary_care_pro']; 
							}
							else{
							 echo $treatingConsultantData['Initial']['initial_name'].$treatingConsultantData[0]['fullname'];	
							}
							?></td>
	</tr>
	<!-- 	<tr class=" ">
			   <td class=" "><strong><?php echo __('UPIN:', true); ?></strong></td> 
			   <td class=" "><?php echo $phyInfo['User']['upin']; ?></td>
			</tr>
			<tr class=" ">
			   <td class=" "><strong><?php echo __('NPI:', true); ?></strong></td> 
			   <td class=" "><?php echo $phyInfo['User']['npi']; ?></td>
			</tr> -->
	<tr class=" ">
		<td class=" "><strong><?php echo __('Mobile No.', true); ?></strong></td> 
			    <?php
							// if(!empty($clientInfo['Facility']['phone1']))$phone=$clientInfo['Facility']['phone1'];else$phone=$clientInfo['Facility']['mobile']							?>
			   <td class=" "><?php echo $patient['User']['mobile']; ?></td>
	</tr>

	<tr class=" ">
		<td class=" "><strong><?php echo __('Collection Date:', true); ?></strong></td> 
			   
			   <?php
						$coldate = $this->DateFormat->formatDate2Local ( $test_ordered ['0'] ['LaboratoryTestOrder'] ['lab_order_date'], Configure::read ( 'date_format' ), true );
						$coldate = explode ( " ", $coldate );
						$collection_date = $coldate ['0'];
						$collection_time = $coldate ['1'];
						?>
			   <td class=" "><?php echo $collection_date; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Collection Time:', true); ?></strong></td>
		<td class=" "><?php echo $collection_time; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Order Date:', true); ?></strong></td>
		<td class=" "><?php echo $this->DateFormat->formatDate2Local($test_ordered['0']['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),true);; ?></td>
	</tr>
</table>
<div>&nbsp;</div>

<div>
	<strong><i><?php echo __('Patient Information:'); ?></i></strong>
</div>
<?php //echo $this->element('print_patient_header'); ?>
<table border="0" cellspacing="1" cellpadding="3" class="tbl"
	width="100%" style="text-align: left;">
	<tr class=" ">
		<td class=" " width="20%"><strong><?php echo __('Name: ', true); ?></strong></td>
		<td class=" "><?php  if(empty($patient[0]['lookup_name'])) echo $patient['Patient']['lookup_name']; else echo $patient[0]['lookup_name'];?></td>

		<td class=" "><strong><?php echo __('Visit Reg ID  : ', true); ?></strong></td>
		<td class=" "><?php echo $patient['Patient']['admission_id']; ?></td>
	</tr>

	<tr class=" ">
		<td class=" "><strong><?php echo __('Age/Sex : ', true); ?></strong></td>
		<td class=" "><?php echo $patient['Patient']['age']." Yrs / ".ucfirst($patient['Patient']['sex']); ?></td>

		<td class=" "><strong><?php echo __('Treating Consultant : ', true); ?></strong></td>
		<td class=" "><?php  $treatingCon = explode(".",$treatingConsultantData[0]['fullname']); 
							if(count($treatingCon) == 2){
							 echo $treatingConsultantData['Initial']['initial_name'].$treatingCon[1];//$treatingConsultantData[0]['fullname'];$this->Session->read('first_name') ." ".$this->Session->read('last_name'); //echo $test_ordered['0']['LaboratoryToken']['primary_care_pro']; 
							}
							else{
		                     echo $treatingConsultantData['Initial']['initial_name'].$treatingConsultantData[0]['fullname'] ; 
							}?></td>
	</tr>

</table>
<?php if(!empty($insInfo['NewInsurance']['subscriber_name'])){?>
<div>
	<strong><i><?php echo __('Responsible Party/ Insured\'s Information:'); ?></i></strong>
</div>
<table border="0" cellspacing="1" cellpadding="3" class="tbl"
	width="100%" style="text-align: left;">
	<tr class=" ">
		<td class=" " width="20%"><strong><?php echo __('Name: ', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['NewInsurance']['subscriber_name'].' '.$insInfo['NewInsurance']['subscriber_initial'].' '.$insInfo['NewInsurance']['subscriber_last_name'] ; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Relationship:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['NewInsurance']['relation']; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Address:', true); ?></strong></td> 
			   <?php
	if (! empty ( $insInfo ['NewInsurance'] ['subscriber_address2'] )) {
		$sub = ', ';
	} else {
		$sub = '';
	}
	if (! empty ( $insInfo ['NewInsurance'] ['subscriber_city'] )) {
		$sub1 = ', ';
	} else {
		$sub1 = '';
	}
	if (! empty ( $state ['State'] ['name'] )) {
		$sub2 = ', ';
	} else {
		$sub2 = '';
	}
	if (! empty ( $insInfo ['NewInsurance'] ['subscriber_country'] ) && $insInfo ['NewInsurance'] ['subscriber_country'] == '2') {
		$sub3 = ', USA ';
	} else {
		$sub3 = '';
	}
	?>
			   <td class=" "><?php echo $insInfo['NewInsurance']['subscriber_address1'].''.$sub.''.$insInfo['NewInsurance']['subscriber_address2'].''.$sub1.''.$insInfo['NewInsurance']['subscriber_city'].''.$sub2.''.$state['State']['name'].''.$sub3; ?></td>
	</tr>
</table>
<?php }?>
<div>&nbsp;</div>
<?php //debug($insInfo);?>
	<?php if(!empty($insInfo)){?>
<div>
	<strong><i><?php echo __('Primary Billing: Insurance'); ?></i></strong>
</div>
<?php foreach($insInfo as $insInfo){ ?>
<table border="0" cellspacing="1" cellpadding="3" class="tbl"
	width="100%" style="text-align: left;">
	<tr class=" ">
		<td class=" " width="30%"><strong><?php echo __('Medicare Number:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['NewInsurance']['policy_number']; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Medicaid/HMO Number:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['NewInsurance']['insurance_company_id']; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Worker\'s comp:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['NewInsurance']['employer']; ?></td>
	</tr>

	<tr class=" ">
		<td class=" "><strong><?php echo __('Insurance company Name:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['NewInsurance']['insurance_name']; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Payor/Carrier Code:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['NewInsurance']['payer_id']; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Physician\'s Provider Number:', true); ?></strong></td>
		<td class=" "><?php echo $phyInfo['User']['alternate_id']; ?></td>
	</tr>

	<tr class=" ">
		<td class=" "><strong><?php echo __('Insurance Address:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['InsuranceCompany']['address']; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('City:', true); ?></strong></td> 
			   <?php if(is_numeric($insInfo['InsuranceCompany']['city_id']))$insInfo['InsuranceCompany']['city_id']=''; ?>
			   <td class=" "><?php echo $insInfo['InsuranceCompany']['city_id']; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('State:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['State']['name']; ?></td>
	</tr>

	<tr class=" ">
		<td class=" "><strong><?php echo __('Zip:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['InsuranceCompany']['zip']; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Subscriber/ Member #:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['NewInsurance']['subscriber_name'].' '.$insInfo['NewInsurance']['subscriber_initial'].' '.$insInfo['NewInsurance']['subscriber_last_name']; ?></td>
	</tr>
	<tr class=" ">
		<td class=" "><strong><?php echo __('Group Number:', true); ?></strong></td>
		<td class=" "><?php echo $insInfo['NewInsurance']['group_number']; ?></td>
	</tr>
</table>

<div>&nbsp;</div>
<?php } }?>

<table border="0" cellspacing="1" cellpadding="3" class="tbl"
	width="100%" style="text-align: left;">
	<tr class=" ">
		<!--<td class=" "><strong><?php echo __('Lab Order id', true); ?></strong></td>-->
		<!-- <td class=" "><strong><?php echo __('Order Name', true); ?></strong></td> 
		   <td class=" "><strong><?php echo __('Order Time', true); ?></strong></td>-->
		<!--<td class=" "><strong><?php echo __('Status'); ?></strong></td>-->


		<td class=" "><strong><?php echo __('Tests ordered', true); ?></strong></td>
		<!--  <td class=" "><strong><?php echo __('PSC HOLD', true); ?></strong></td> -->
		<td class=" "><strong><?php echo __('Comments', true); ?></strong></td>
		<td class=" "><strong><?php echo __('AOE', true); ?></strong></td>
		<td class=" "><strong><?php echo __('Diagnosis codes', true); ?></strong></td>
		<td class=" "><strong><?php echo __('Stat', true); ?></strong></td>
		<td class=" "><strong><?php echo __('Fasting', true); ?></strong></td>

	</tr>
	  <?php
			$toggle = 0;
			foreach ( $test_ordered as $labs ) { // debug($labs);
				$AOE = unserialize ( $labs ['LaboratoryToken'] ['question'] );
				?>		
					   <tr>
		<!--<td class="row_format"><?php //echo $labs['LaboratoryTestOrder']['order_id']; ?></td>-->
		<!-- <td class="row_format"><?php echo ucfirst($labs['Laboratory']['name']); ?> </td>
					   <td class="row_format"><?php echo $this->DateFormat->formatDate2LocalForReport($labs['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true); ?> </td>
					   <!--<td class="row_format"><?php //echo $status; ?> </td> -->

		<td class="row_format"><?php if(!empty($labs[Laboratory][dhr_order_code])){
			$getOrderCode=" (".$labs[Laboratory][dhr_order_code].")";
		}
		echo ucfirst($labs['Laboratory']['name']).$getOrderCode; ?> </td>
		<!-- <td class="row_format"><?php echo ('N'); ?> </td> -->
		<td class="row_format"><?php echo $labs['LaboratoryToken']['relevant_clinical_info']; ?> </td>

		<td class="row_format">
			<table> 
					   		<?php
				$questions = unserialize ( $labs ['LaboratoryToken'] ['question'] );
				
				foreach ( $labs ['LaboratoryAoeCode'] as $aoeKey => $aoeValue ) {
					$aoeCodes [$aoeValue ['id']] = $aoeValue ['question'];
				}
				
				foreach ( $questions as $key => $value ) {
					$test = strpos ( $key, 'radio_question_' );
					if (strpos ( $key, 'radio_question_' ) !== false) {
						$temp = explode ( "radio_question_", $key );
						$temp = $temp ['1'];
						?>
									<tr>
					<td width="50%" id="boxSpace" class="tdLabel"><?php echo $aoeCodes[$temp];?></td>
					<td width="20%" style="color: #000"> <?php if($value=='1')echo ('Yes');elseif($value=='0')echo ('No');else echo $value;?> </td>
										
											
									<?php
					} else if (strpos ( $key, 'free_text_question_' ) !== false) {
						$temp = explode ( "free_text_question_", $key );
						$temp = $temp ['1'];
						?>
									
				
				
				
				
				
				
				
				
				<tr>
					<td width="50%" id="boxSpace" class="tdLabel"><?php echo $aoeCodes[$temp];?></td>
					<td width="20%"><?php if($value=='1')echo ('Yes');elseif($value=='0')echo ('No');else echo $value;?> </td>
										
										<?php
					} else if (strpos ( $key, 'drop_down_question_' ) !== false) {
						$temp = explode ( "drop_down_question_", $key );
						$temp = $temp ['1'];
						?>
										
				
				
				
				
				
				
				
				
				<tr>
					<td width="50%" id="boxSpace" class="tdLabel"><?php echo $aoeCodes[$temp];?></td>
					<td width="20%"><?php if($value=='1')echo ('Yes');elseif($value=='0')echo ('No');else echo $value;?></td>
										
										<?php } ?>
									</tr>
							<?php } ?>
					   	</table>
		</td>
					  <?php $diagnosis = ($labs['LaboratoryToken']['diagnosis'])?$labs['LaboratoryToken']['diagnosis'].' (ICD9 Code:'.$labs['LaboratoryToken']['icd9_code'].')' : '';?>
					   <td class="row_format"><?php echo $diagnosis; ?> </td>
					   <?php
				
				if ($labs ['LaboratoryToken'] ['priority'] == 'Stat') {
					$Stat = 'Y';
				} else {
					$Stat = '';
				}
				?>
					   <td class="row_format"><?php echo $Stat; ?> </td>
					   <?php
				
				if ($labs ['LaboratoryToken'] ['frequency'] == '35') {
					$fasting = 'Y';
				} else {
					$fasting = '';
				}
				?>
					   <td class="row_format"><?php echo $fasting; ?> </td>


	</tr>
		  <?php }   ?> 
	</table>
<div>&nbsp;</div>
<div>&nbsp;</div>
<table cellspacing="0" cellpadding="3" border="0" class="tbl">
	<tr>
		<td><strong>Laboratory : </strong></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><?php
		if (! empty ( $test_ordered [0] ['ServiceProvider'] ['name'] ))
			echo ucwords ( $test_ordered [0] ['ServiceProvider'] ['name'] );
		else
			echo "Parakh Pathology"; // $this->Session->read('facility');		?></td>
	</tr> 
    	<?php
					// only if test is for external service provider
					if ($test_ordered [0] ['LaboratoryTestOrder'] ['is_external'] == 1) {
						if (! empty ( $test_ordered [0] ['ServiceProvider'] ['contact_person'] )) {
							?>
		    	<tr>
		<td valign="top"><strong>Contact Person : </strong></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><?php	echo ucwords($test_ordered[0]['ServiceProvider']['contact_person']);?></td>
	</tr>
		    	<?php } ?>
		    	<?php  if(!empty($test_ordered[0]['ServiceProvider']['contact_no'])) {?>
		    	<tr>
		<td valign="top"><strong>Contact No : </strong></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><?php	echo ucwords($test_ordered[0]['ServiceProvider']['contact_no']);?></td>
	</tr>
		    	<?php } ?>
		    	<?php  if(!empty($test_ordered[0]['ServiceProvider']['location'])) {?>
		    	<tr>
		<td valign="top"><strong>Address : </strong></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td><?php	echo nl2br($test_ordered[0]['ServiceProvider']['location']);?></td>
	</tr>
		    	<?php
						}
					}
					?>
    </table>
<?php if(!empty($allergies_data)){?>
<table border="0" cellspacing="0" cellpadding="3" class="tbl"
	width="100%" style="text-align: left;">
	<tr>
		<td colspan='3'
			style='text-align: center; font-size: 19px; font-weight: bold; padding-bottom: 10px;'><strong><?php echo __('Allergies', true); ?></strong></td>
	</tr>
	<tr class=" ">
		<table cellpadding="3" cellspacing="1" border="0"
			class="tabularForm tbl" width="100%">
			<tr>
				<td class=" " width="40%"><strong><?php echo __('Name', true); ?></strong></td>
				<td class=" "><strong><?php echo __('Reaction', true); ?></strong></td>
				<td class=" "><strong><?php echo __('Allergy Severity', true); ?></strong></td>
			</tr>

			</tr>
          
       
		   <?php foreach($allergies_data as $data){?>
		     <tr class=" ">

				<td class=" " width="40%"><?php echo $data['NewCropAllergies']['name']; ?></td>
				<td class=" "><?php echo $data['NewCropAllergies']['reaction']; ?></td>
				<td class=" "><?php echo $data['NewCropAllergies']['AllergySeverityName']; ?></td>

			</tr><?php }?>
              </tr>
		</table>

</table>
<?php }?>
<div>&nbsp;</div>
<!-- <div><strong><?php echo ('Diagnosis Codes:'); ?></strong></div> 
	<div>&nbsp;</div> -->
<div>
	<strong><?php echo ('Authorisation: Please Sign and Date:'); ?></strong>
</div>
<div><?php echo ('I hereby authorize the release of medical information related to the services described hereon and authorize payment directly to Parakh Pathology.'); ?></div>

<div style="float: left;">
	<div style="padding: 40px 0px;">
		<div><?php echo ('----------------------------------'); ?></div>
		<div><?php echo ('Patient Signature'); ?></div>
	</div>
	<div style="float: left;">
		<div><?php echo ('----------------------------------'); ?></div>
		<div><?php echo ('Physician Signature'); ?></div>
	</div>
</div>

<div style="float: right;">
	<div style="padding: 40px 0px;">
		<div><?php echo ('----------------------------------'); ?></div>
		<div><?php echo ('Date'); ?></div>
	</div>
	<div style="float: right;">
		<div><?php echo ('----------------------------------'); ?></div>
		<div><?php echo ('Date'); ?></div>
	</div>
</div>



