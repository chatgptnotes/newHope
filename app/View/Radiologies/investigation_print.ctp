	<style>
	 #printButton{ position:relative!important;}
	</style>
   <div style="float:right;" id="printButton">
		<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
	</div>
	  
	<!-- Right Part Template -->
	<div align="center" class="heading" style="text-decoration:none;">
		<?php echo __('Radiology Requisition Slip'); ?> 
	</div> 
	<?php //echo $this->element('print_patient_header'); ?>
		<div><strong><i><?php echo __('Patient Information:'); ?></i></strong></div>
	<?php //echo $this->element('print_patient_header'); ?>
	<table border="0" cellspacing="1" cellpadding="3" class="tbl" width="100%" style="text-align:left;">
		    <tr class=" ">
			   <td class=" " width="20%"><strong><?php echo __('Name: ', true); ?></strong></td> 
			   <td class=" "><?php  echo $getPId['Patient']['lookup_name'];//if(empty($patient[0]['lookup_name'])) echo $patient['Patient']['lookup_name']; else echo $patient[0]['lookup_name'];?></td>
			
			   <td class=" "><strong><?php echo __('Visit Reg ID  : ', true); ?></strong></td> 
			   <td class=" "><?php echo $getPId['Patient']['admission_id']; ?></td>
			</tr>
			
			<tr class=" ">
			   <td class=" "><strong><?php echo __('Age/Sex : ', true); ?></strong></td> 
			   <td class=" "><?php echo $getPId['Patient']['age']." Yrs / ".ucfirst($getPId['Patient']['sex']); ?></td>
			
			   <td class=" "><strong><?php echo __('Treating Consultant : ', true); ?></strong></td> 
			   <td class=" "><?php  $name= explode(".",$treatingConsultantData[0]['fullname']);
							if(count($name) == 2){
							 echo $treatingConsultantData['Initial']['initial_name'].$name[1];//$treatingConsultantData[0]['fullname'];$this->Session->read('first_name') ." ".$this->Session->read('last_name'); //echo $test_ordered['0']['LaboratoryToken']['primary_care_pro']; 
							}
							else{
			                     echo $treatingConsultantData['Initial']['initial_name'].$treatingConsultantData[0]['fullname'] ; 
                                }?></td>
			</tr>				
			
		</table>
	<div>&nbsp;</div>
	<table border="0" cellspacing="1" cellpadding="3" class="tbl" width="100%"  >
	    <tr class=" ">
		   <!--<td class=" "><strong><?php echo __('Radiology Order id', true); ?></strong></td>
		   --> 
		   <td class=" "><strong><?php echo __('Test Name', true); ?></strong></td>
		    <td class=" "><strong><?php echo __('Order Time', true); ?></strong></td>
		   <!-- 
		   <td class=" "><strong><?php echo __('Status'); ?></strong></td> 
	  --></tr>
	  <?php 
		  $toggle =0;
		  
				foreach($test_ordered as $labs){ 
					    
				 	   //status of the report
					/*   if($labs['RadiologyResult']['confirm_result']==1){
					   		$status = 'Resulted';
					   		 
					   }else{
					   		$status = 'Pending';
					   		 
					   }*/
					  ?>		
					   <tr>						  
					   <!--<td class="row_format"><?php echo $labs['RadiologyTestOrder']['order_id']; ?></td>-->
					    <td class="row_format"><?php echo ucfirst($labs['Radiology']['name']); ?> </td>
					   <td class="row_format"><?php echo $this->DateFormat->formatDate2LocalForReport($labs['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true); ?> </td>
					   
					   <!--
					   <td class="row_format"><?php //echo $status; ?> </td>  --></tr>
		  <?php }   ?> 
	</table>  
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <table cellspacing="0" cellpadding="3" border="0" class="tbl"  >
    	<tr>
    		<td><strong>Radiology : </strong></td>
    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    		<td><?php 
				if(!empty($test_ordered[0]['ServiceProvider']['name']))
    				echo ucwords($test_ordered[0]['ServiceProvider']['name']);
    			else
    				echo  $this->Session->read('facility'); ?></td>
    	</tr> 
    	<?php 
    		 //only if test is for external service provider
    		 if($test_ordered[0]['RadiologyTestOrder']['is_external']==1){
    	 		if(!empty($test_ordered[0]['ServiceProvider']['contact_person'])) {?>
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
		    	<?php } 
    		 }
    	?>
    </table>
   <?php if(!empty($allergies_data)){?>
      <table border="0" cellspacing="0" cellpadding="3" class="tbl" width="100%" style="text-align:left;">
	    <tr >
		   <td colspan='3' style="text-align:center; font-size:19px; padding-bottom:10px; font-weight:bold;"><strong><?php echo __('Allergies', true); ?></strong></td>
		   </tr>
           <table cellpadding="3" cellspacing="1" border="0" class="tabularForm tbl" width="100%">
	    <tr class=" ">
		   <td class=" "><strong><?php echo __('Name', true); ?></strong></td>
		   <td class=" "><strong><?php echo __('Reaction', true); ?></strong></td> 
		   <td class=" "><strong><?php echo __('Allergy Severity', true); ?></strong></td>
		   </tr>
		   <?php foreach($allergies_data as $data){?>
		     <tr class=" ">
		   <td class=" "><strong><?php echo $data['NewCropAllergies']['name']; ?></strong></td>
		   <td class=" "><strong><?php echo $data['NewCropAllergies']['reaction']; ?></strong></td> 
		   <td class=" "><strong><?php echo $data['NewCropAllergies']['AllergySeverityName']; ?></strong></td>
		   </tr><?php }?>
           </table>
		   </table>
		   <?php }?>
    <div>&nbsp;</div> 
    <div>&nbsp;</div> 
			        