<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Patient_Admissions_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
<STYLE type='text/css'>
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
   
</STYLE>
<?php $treatment_type =  array('4' => 'First Consultation','5' => 'Follow-Up Consultation', '6' => 'Preventive Health Check-up', '7' => 'Vaccination', '8' => 'Pre-Employment Check-up', '9' => 'Pre Policy Check up'); ?>
<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
                  <tr class="row_title">
   <td colspan = "11" align="center"><h2><?php echo __('Patient Admissions Report'); ?></h2></td>
  </tr>
				  <tr class="row_title">
				       <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="18%"><strong><?php echo __('Date Of Reg.'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('MRN'); ?></strong></td>
					    <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('Patient Name'); ?></strong></td>
						<td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Blood Group'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Age'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Sex'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Sponsor Name'); ?></strong></td> 
					   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Patient Type'); ?></strong></td>
					    <td height="30px" align="center" valign="middle" width="12%"><strong><?php echo __('Specilty'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Doctor'); ?></strong></td>
					   <?php
					   if(!empty($selctedFields)){ 
						   foreach($selctedFields as $key=>$value){
						   		echo ' <td height="30px" align="center" valign="middle" width="12%"><strong>'.$fieldsArr["$value"].'</strong></td>';
						   }
					   }
					  ?>
				   </tr>
					   <?php   
	  	 $toggle =0;
	  	 
	      if(count($reports) > 0) {
			   $k = 1; 
			// if you select fields of finalbilling table //
                        $finalBillingFields = array('bill_number', 'total_amount', 'amount_paid', 'discount_rupees', 'amount_pending');
	      		foreach($reports as $key =>$pdfData){	
					$patient = $pdfData['Patient'];
					$person = $pdfData['Person'];
					$doctor = $pdfData['DoctorProfile'];
					if(isset($pdfData['Department'])){
						$department = $pdfData['Department'];
					}
                                        if(isset($pdfData['FinalBilling'])){ 
						$finalBillingPart = $pdfData['FinalBilling'];
					}
					?>
					<tr>
					    <td align='center' height='17px'><?php echo $k ?></td> 
						<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($patient['form_received_on'],Configure::read('date_format')); ?></td>
						<td align='center' height='17px'><?php echo $patient['admission_id'] ?></td>  
						<td align='center' height='17px'><?php echo $pdfData['PatientInitial']['name']." ".$patient['lookup_name'] ?></td>
					    <td align='center' height='17px'><?php echo $person['blood_group'] ?></td>	   
					    <td align='center' height='17px'><?php echo $person['age'] ?></td>  
					    <td align='center' height='17px'><?php echo ucfirst($person['sex']); ?></td>
					    <td align='center' height='17px'>
						 <?php 
						       if($pdfData['Corporate']['name']) echo $pdfData['Corporate']['name']; 
						       elseif($pdfData['InsuranceCompany']['name']) echo $pdfData['InsuranceCompany']['name'];
							   else echo __('Private');
					     ?>
						</td>
						<?php if($patient['is_emergency'] == 1 AND $patient['admission_type'] == 'IPD'){		?>							
								<td align='center' height='17px'>Emergency</td>
						<?php } else { ?>
								<td align='center' height='17px'><?php echo $patient['admission_type'];?></td>
						<?php } ?>
						
					    <td align='center' height='17px'><?php echo $pdfData['Department']['name'] ?></td>
					    <td align='center' height='17px'><?php echo $pdfData[0]['doctor_name'] ?></td>
					     <?php
						   if(!empty($selctedFields)){ 
							   foreach($selctedFields as $key=>$value){
								    if($key=='admission_type' AND $patient_type == 'Emergency' AND $patient['admission_type'] == 'IPD'){									
										$patient['admission_type'] = 'Emergency';
									}
							   		if($value =='department_id'){
							   			echo "<td align='center' height='17px'>".$department["name"]."</td>";
										 
							   		}elseif(in_array($value, $finalBillingFields)){
							   			echo "<td align='center' height='17px'>".$finalBillingPart["$value"]."</td>";
										 
							   		}else{							   			
							   			if($value=='doc_ini_assessment' || $value=='nurse_assessment'){
							   				if($patient["$value"]==1){
							   					echo "<td align='center' height='17px'>Yes</td>";
							   				}else{
							   					echo "<td align='center' height='17px'>No</td>";
							   				}
							   			}else{
							   				echo "<td align='center' height='17px'>".$patient["$value"]."</td>";
							   			}
							   		}
							   }
						   }
					    ?>
					</tr>
					<?php   
				 $k++; 
			   }

			  ?>
			   <tr> 
			   		<td height="30px" align="center" valign="bottom" colspan="<?php echo count($selctedFields)+11; ?>"><strong>Total Patients:<?php echo (count($reports)) ; ?></strong></td>											
							
						</tr>
				<?php 		  
				 } else {
					?> <tr>
									<td align="center" height="17px" colspan="11" > No Record Found</td>
									
								</tr>
<?php 
				 }
		?>			   		  
		</table>
		
