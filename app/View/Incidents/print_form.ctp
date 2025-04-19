<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<style>
.ht5 {
    height: 10px;
    margin: 0;
    padding: 0;
}
body{
font-size:12px;
font-family:arial;
}
</style>

</head>

<body onload="window.print();"> <!-- onload="window.print();window.close();" -->
	
	<table width="100%" border="0" cellspacing="0" cellpadding="5">
		<tr>
			<td width="46%"><b>Who was harmed or nearly harmed?</b></td>
			<td width="54%">&nbsp;<?php echo $data['Incident']['who_harmed']; ?></td>
		</tr> 
		<tr>
			<td width="46%"><b>Inpatient Incident</b></td>
			<td width="54%">&nbsp;<?php echo $data['Incident']['inpatient_outpatient']; ?></td>
		</tr> 
		<tr>
			<td colspan="2"><b>How did you learn about the incident?</b></td>
		</tr>
		<tr>
			<td colspan ="2">	
		  	<table width="100%" cellpadding="0" cellspacing="0" border="1">
			<tr>	
			<?php  $count = 0;
				if(!empty($data['Incident']['witness_involved'])){?>		 
			  <td>&nbsp;<?php echo $data['Incident']['witness_involved'];?></td>			 
			 <?php $count = 1; }
			 if(!empty($data['Incident']['report_by_patient'])){?>
			  <td>&nbsp;<?php echo $data['Incident']['report_by_patient'];?></td>
			 <?php $count += 1; }
			 if(!empty($data['Incident']['report_by_family'])){?> 				  
			  <td>&nbsp;<?php echo $data['Incident']['report_by_family'];?></td>                              
			 <?php $count += 1; }?>
			  <?php if($count == 3){ ?>
			  </tr>
			  <tr>	
			  <?php }?>
			  <?php if(!empty($data['Incident']['report_by_staff'])){?> 					
				<td>&nbsp;<?php echo $data['Incident']['report_by_staff'];?></td>
			  <?php $count += 1; } ?>
			  <?php if($count == 3){ ?>
			  </tr>
			  <tr>	
			  <?php }?>
			 <?php if(!empty($data['Incident']['assetment_after_incident'])){?> 	
				<td>&nbsp;<?php echo $data['Incident']['assetment_after_incident'];?> </td>	
			  <?php $count += 1; } ?>
			 <?php if($count == 3){ ?>
			  </tr>
			  <tr>	
			 <?php }?> 
			 <?php if(!empty($data['Incident']['review_of_record'])){?> 	 
				<td>&nbsp;<?php echo $data['Incident']['review_of_record'];?></td> 					 
			  <?php }?>
				
			</tr>
		  </table>
		 </td>
		</tr> 
		<tr>
			<td colspan="2"><b>Name of Person Affected :- </b></td>
		</tr>
		<tr>
			<td colspan="2">
		  	<table width="100%" cellpadding="0" cellspacing="0" border="1">
			<tr>			  
			  <td width="188" align="left"><b>&nbsp;Last Name</b></td>
			  <td width="219">&nbsp;<?php echo $data['Incident']['last_name'];?></td>			  
			  <td width="178" align="left"><b>&nbsp;First Name</b></td>
			  <td width="243">&nbsp;<?php echo $data['Incident']['first_name'];?></td>			  
			  <td width="208" align="left"><b>&nbsp;Middle Name</b></td>
			  <td width="478">&nbsp;<?php echo $data['Incident']['middle_name'];?></td>                              
			</tr>
			<tr>				
				<td align="left"><b>&nbsp;<?php echo __("MRN");?></b></td>
				<td>&nbsp;<?php echo $data['Incident']['registration_no']; ?></td>
				<td align="left"><b>&nbsp;Sex</b></td>
				<td>&nbsp;<?php echo $data['Incident']['sex']; ?> </td>	
				<td align="left"><b>&nbsp;Age</b></td>	
				<td>&nbsp;<?php echo $data['Incident']['age']; ?></td> 					 
				
			</tr>
		  </table>
		 </td>
		</tr> 
		<tr>
			<td width="46%"><b>Location Where Incident Occurred</b></td>
			<td width="54%">&nbsp;<?php echo $data['Incident']['location_incident']; ?></td>
		</tr>
	 
		<tr>
			<td colspan="2"><b><?php echo __("OP Visit/MRN");?>:-</b></td>
		</tr>
		 
		<tr>
			<td colspan="2">
			  <table width="100%" cellpadding="0" cellspacing="0" border="1">
				<tr>			  
				  <td width="245" align="left"><b>&nbsp;Date of OP Visit/Registration</b></td>
				  <td width="463">&nbsp;<?php if(!empty($data['Incident']['op_visit_date'])) echo $this->DateFormat->formatDate2Local($data['Incident']['op_visit_date'],Configure::read('date_format')); ?></td>			  
				  <td width="233" align="left"><b>&nbsp;Date and Time of Incident</b></td>
				  <td width="577">&nbsp;<?php echo $this->DateFormat->formatDate2Local($data['Incident']['incident_date'],Configure::read('date_format'))." ".$data['Incident']['incident_time']; ?></td>		  
				           
				</tr>
			  </table>
		 </td>
		</tr>
	 
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<!--<tr>
		   	<td colspan="2">
		   		<table width="100%" border="1">
					<tr>				
						<td width="24%" align="center">Incident Analysis </td>
						<td width="76%">&nbsp;<?php echo $data['Incident']['analysis_option']; ?></td>					
				
				</tr>
				<tr>
					<td colspan="2">&nbsp;<?php echo $data['Incident']['incident_description']; ?></td>
				</tr>
			 </table>
			</td>
		</tr>
		--><tr> 
			<td colspan="2"><b><?php echo __('Analysis Option');?> :-</b></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;<?php echo nl2br($data['Incident']['incident_description']); ?></td>
		</tr>
		<tr>
		 
			<td colspan="2"><b>Root Cause Analysis :-</b></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;<?php echo nl2br($data['Incident']['root_cause_ananysis']); ?></td>
		</tr>
		 
		<tr>
			<td colspan="2"><b>Corrective Action :-</b></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;<?php echo nl2br($data['Incident']['corrective_action']); ?></td>
		</tr>
	 
		<tr>
			<td colspan="2"><b>Preventive Action :-</b></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;<?php echo nl2br($data['Incident']['preventive_action']); ?></td>
		</tr>
		 
		<tr>
			<td width="46%"><b>Medication Error :-</b><?php echo $data['Incident']['medication_error']; ?></td>
			<td width="54%">&nbsp;<?php echo nl2br($data['Incident']['medication_error_desc']);?></td>
		</tr>
	 
		<tr>
			<td colspan="2"><b>Harm Score :- </b></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;<?php echo $data['Incident']['harm_score']; ?></td>
		</tr>
	 
		<tr>
			<td colspan="2"><b>Patient clinical service/Specilty at the time of incident</b></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;<?php echo $data['Incident']['patient_clinical_service'];?></td>
		</tr>
		 
		<tr>
			<td colspan="2"><b>Who was notified of the incident?</b></td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%" cellpadding="0" cellspacing="0" border="1">
				  <tr>
					<td width="210" align="left"><b>&nbsp;Covering Consultant</b></td>
					<td width="172">&nbsp;<?php echo $data['Incident']['covering_consultant'];?></td>
					<td width="138" align="left"><b>&nbsp;Date</b></td>
					<td width="184">&nbsp;<?php if(!empty($data['Incident']['notified_date'])) echo $this->DateFormat->formatDate2Local($data['Incident']['notified_date'],Configure::read('date_format'))." ".$data['Incident']['notified_time'];?></td>
					<td width="96" align="left"><b>&nbsp;Patient</b></td>
					<td width="223">&nbsp;<?php echo $data['Incident']['notified_patient']; ?></td>
					<td width="285" align="left"><b>&nbsp;Family/designated contact</b></td>
					<td width="198">&nbsp;<?php echo $data['Incident']['notified_family_contact'];?></td>                              
				  </tr>
                  <tr>
				  	 <td align="left"><b>&nbsp;Director</b></td>
					 <td>&nbsp;<?php echo $data['Incident']['notified_director'];?></td> 
					 <td align="left"><b>&nbsp;Administrator</b></td>
					 <td>&nbsp;<?php echo $data['Incident']['notified_administrator'];?></td>
					 <td align="left"><b>&nbsp;Security</b></td>
					 <td>&nbsp;<?php echo $data['Incident']['notified_security'];?> </td>
					 <td align="left"><b>&nbsp;OTHER(please specify below)</b></td>
					<td>&nbsp;<?php echo $data['Incident']['notified_other'];?> </td>
                 </tr>                            
            </table>
          </td>
        
	</tr>
	 
	<tr>
		<td width="46%"><b>Reporter's role</b></td>
		<td width="54%">&nbsp;<?php echo $data['Incident']['reporters_role']; ?></td>
	</tr>
	 
	<tr>
		<td colspan="2"><b>Person Submitting Report</b></td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%"   border="1" cellpadding="0" cellspacing="0">
			<tr>			  
			  <td width="177" align="left"><b>&nbsp;Name</b></td>
			  <td width="611">&nbsp;<?php echo $data['Incident']['person_submitting_report']; ?></td>			  
			  <td width="218" align="left"><b>&nbsp;Contact No</b></td>
			  <td width="508">&nbsp;<?php echo $data['Incident']['person_submitting_contact_no']; ?></td>	                          
			</tr>
		  </table>
	  </td>
	</tr>
	 
	<tr>
		<td colspan="2"><b>Recommendation</b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;<?php echo $data['Incident']['recommendation']; ?></td>
	</tr>
</table>
</body>
</html>
