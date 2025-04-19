<?php 
        if(empty($LicensedPrescriberName['User']['address1']))
			$LicensedPrescriberName['User']['address1']=Configure::read('doctor_addr1');
        if(empty($LicensedPrescriberName['User']['address2']))
			$LicensedPrescriberName['User']['address2']=Configure::read('doctor_addr2');
		if(empty($city_location_prescriber))
			$city_location_prescriber=Configure::read('doctor_city');
	    if(empty($LicensedPrescriberName['User']['fax']))
			$LicensedPrescriberName['User']['fax']=Configure::read('primaryFaxNumber');
       if(empty($LicensedPrescriberName['User']['zipcode']))
			$LicensedPrescriberName['User']['zipcode']=Configure::read('doctor_zip');
       if(empty($state_location_prescriber))
	     $state_location_prescriber=Configure::read('doctor_state');

$freq=Configure :: read('frequency');
$dose=Configure :: read('dose_type');
$dosageForm=Configure :: read('strength'); //dosage form
$frequencyFullform=Configure :: read('frequency_fullform'); //dosage form
$routeValue=Configure :: read('route_administration'); //dosage form
	   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php //echo __('Hope', true); ?>
		 
	</title>
	<?php echo $this->Html->css('internal_style.css');?> 
	
	<style>
	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;}
	.heading{font-weight:bold; padding-bottom:10px; font-size:19px; text-decoration:underline;}
	.headBorder{border:1px solid #ccc; padding:3px 0 15px 3px;}
	.title{font-size:14px; text-decoration:underline; font-weight:bold; padding-bottom:10px;color:#000;}
	input, textarea{border:1px solid #999999; padding:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.tbl .totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	.tabularForm td{background:none;}
	@media print {
  		#printButton{display:none;}
    }
</style>
 
</head>
<body style="background:none;width:98%;margin:auto;">

<!--
set padding to 50px to adjust print page with default header coming on page
	-->
	
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="padding-top:10px;padding-left:10px;">
		  <tr>
			  <td colspan="3" align="right">
			  <div id="printButton">
			  <?php 
			 		 
			   		echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();'));
			  ?>
			  </div>
		 	 </td>
		  </tr>
		  
		  <tr>
		  <td colspan="3">
		  <table border="0" cellspacing="0" cellpadding="0" width="100%">
		  <tr><td align="center" style="font-size:18px;"><?php echo $LicensedPrescriberName[User][first_name]." ".$LicensedPrescriberName[User][last_name];?></td></tr>
		  <tr><td align="center"><strong>DEA:</strong><?php echo $LicensedPrescriberName[User][dea];?>&nbsp;&nbsp;<strong> NPI:</strong><?php echo $LicensedPrescriberName[User][npi];?></td></tr>
		  <tr><td align="center"><strong><?php echo $hospitalLocation;?></strong></td></tr>
		  <tr><td align="center"><strong><?php echo $LicensedPrescriberName[User][address1]."".$LicensedPrescriberName[User][address2].", ".$city_location_prescriber.", ".$state_location_prescriber." ".$LicensedPrescriberName['User']['zipcode'];?></strong></td></tr>
		  <tr><td align="center"><strong>Phone:</strong><?php echo $LicensedPrescriberName['User']['phone1']?>&nbsp;&nbsp;<strong>Fax: </strong><?php echo $LicensedPrescriberName['User']['fax']?></td></tr>
		  </table>
		  </td>
		  </tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr>
		  <td colspan="3">
		  <table border="0" cellspacing="0" cellpadding="0" width="100%">
		  <?php 

                      $PatientDob=explode("-",$UIDpatient_details['Person']['dob']);

		        $patientDob1=$PatientDob["2"]."/".$PatientDob["1"]."/".$PatientDob["0"];
 
		  ?>
		  <tr><td><strong>Patient :</strong> <?php echo $UIDpatient_details['Person']['first_name']." ".$UIDpatient_details['Person']['last_name']?><strong> &nbsp;&nbsp; Gender :</strong> <?php echo $UIDpatient_details['Person']['sex']?></td><td ><strong>DOB : </strong><?php echo $patientDob1;?></td> <?php if(!empty($UIDpatient_details['Person']['person_lindline_no'])){?><td><strong>Day TEL :</strong><?php echo $UIDpatient_details['Person']['person_lindline_no']?></td><?php }?></tr>
		  <tr><td><strong><?php echo $UIDpatient_details['Person']['plot_no']." ".$UIDpatient_details['Person']['landmark'].",".$UIDpatient_details['Person']['city'].",".$state_location_patient." ".$UIDpatient_details['Person']['pin_code'];?></strong></td><td><strong>MRN :</strong><?php echo $UIDpatient_details['Patient']['admission_id'];?></td> <td></td></tr>
		  <tr><td><strong>Height :</strong><?php echo $bmiResult["BmiResult"]["height"]." ".$bmiResult["BmiResult"]["height_volume"]?></td><td><strong>Weight :</strong><?php echo $bmiResult["BmiResult"]["weight"]." ".$bmiResult["BmiResult"]["weight_volume"]?></td></tr>
		  </table>
		  </td>
		  </tr>
		  <tr><td>&nbsp;</td></tr>
		  <!-- Medication to print  -->
		  <?php if(!empty($getMedicationRecords)){?>
		  <tr>
		  <td colspan="3">
		  <table border="0" cellspacing="0" cellpadding="2" width="100%">
		 <tr>
										<td width="8%" height="20" align="center" valign="top"
											style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000"><strong>Drug</strong></td>
										<td width="5%" height="20" align="center" valign="top"
											 style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000"><strong>SIG</strong></td>
										<td width="5%" height="20" align="center" valign="top"
											style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000"><strong>Dispense</strong></td>
										<td width="5%" height="20" align="center" valign="top"
											style="border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000"><strong>Refills</strong></td>
										
										
									</tr> 
									<?php 

                                  foreach($getMedicationRecords as $medications){	

									
																		
									$dispense=$medications['NewCropPrescription']['quantity'];
									$dose_val=$dose[$medications['NewCropPrescription']['dose']];
			                        $route_val=$routeValue[$medications['NewCropPrescription']['route']];
									//$route_val=$medications['NewCropPrescription']['route'];
			                       
                                    $dosageFormVal=$dosageForm[$medications['NewCropPrescription']['DosageForm']];
                                    $frequencyFullformVal=$frequencyFullform[$medications['NewCropPrescription']['frequency']];
                                   
			                        $sig=$dose_val.", ".$dosageFormVal.", ".$route_val. ", ".$frequencyFullformVal;
			                        
			                        
                                     if(!(empty($medications['NewCropPrescription']['PrescriptionNotes'])))
                                       $sig.="<br/>Additional Sig: ".$medications['NewCropPrescription']['PrescriptionNotes'];

                                     if(!(empty($medications['NewCropPrescription']['PharmacistNotes'])))
                                       $sig.="<br/>Pharm. Message: ".$medications['NewCropPrescription']['PharmacistNotes'];

                                        
			                       
					             	?>
									<tr>
										<td width="8%" height="20" align="left" valign="top"
											style="border-left:1px solid #000;border-bottom:1px solid #000"><?php echo $medications['NewCropPrescription']['description']?></td>
										<td width="5%" height="20" align="left" valign="top" style="border-left:1px solid #000;border-bottom:1px solid #000"><?php echo $sig;?></td>
										<td width="5%" height="20" align="center" valign="top" style="border-left:1px solid #000;border-bottom:1px solid #000" ><?php echo $medications['NewCropPrescription']['quantity'];?></td>
										<td width="5%" height="20" align="center" valign="top" style="border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" ><?php echo $medications['NewCropPrescription']['refills'];?></td>
										
										
									</tr>
									<?php }?>
		  </table>
		  </td>
		  </tr>
		  <?php }?>
		   <!-- Medication to print EOD -->
		  
		  <tr><td>&nbsp;</td></tr>
		   <!-- Aller to print  -->
		   <?php if(!empty($getAllergyRecords)){?>
		  <tr>
		  <td colspan="3">
		  <table border="0" cellspacing="0" cellpadding="2" width="100%">
		 <tr>
										<td width="8%" height="20" align="center" valign="top"
											style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000"><strong>Allergy</strong></td>
										<td width="5%" height="20" align="center" valign="top"
											 style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000"><strong>Reaction</strong></td>
											 <td width="5%" height="20" align="center" valign="top"
											 style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000"><strong>Severity Level</strong></td>
										<td width="5%" height="20" align="center" valign="top"
											style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000"><strong>Onset Date</strong></td>
	
									</tr>
									<?php
									foreach($getAllergyRecords as $allergies){ ?>	 
									<tr>
										<td width="8%" height="20" align="left" valign="top"
											style="border-left:1px solid #000;border-bottom:1px solid #000"><?php echo $allergies["NewCropAllergies"]["name"]?></td>
										<td width="5%" height="20" align="left" valign="top" style="border-left:1px solid #000;border-bottom:1px solid #000"><?php echo $allergies["NewCropAllergies"]["reaction"]?></td>
										<td width="5%" height="20" align="left" valign="top" style="border-left:1px solid #000;border-bottom:1px solid #000;"><?php echo $allergies["NewCropAllergies"]["AllergySeverityName"]?></td>	
                                        <td width="5%" height="20" align="left" valign="top" style="border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000"><?php echo $allergies['NewCropAllergies']['onset_date'] = $this->DateFormat->formatDate2Local($allergies['NewCropAllergies']['onset_date'],Configure::read('date_format_us'),false); ?></td>
									</tr>
                                     <?php }?>
		  </table>
		  </td>
		  </tr>
		  <?php }?>
		   <!-- Aller to print  EOD -->
		  <tr><td><strong> Drugs Prescribed: </strong>&nbsp;<?php echo count($getMedicationRecords);?> </td><td>&nbsp;</td><td colspan=3><strong>Signature:</strong> <br/><br/>__________________________</td></tr>
		  
		  
	</table> 
 
</body>
 </html>                    
  
 