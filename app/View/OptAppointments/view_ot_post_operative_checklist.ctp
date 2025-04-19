<div class="inner_title">
 <h3><?php echo __('Post Operative Check List'); ?></h3>
<span> <a class="blueBtn" href="<?php echo $this->Html->url("/opt_appointments/ot_post_operative_checklist/". $patient_id); ?>"><?php echo __('Back'); ?></a></span>
</div>
<div class="patient_info">
 <?php echo $this->element('patient_information');?>
</div> 
<div class="clr"></div>
<div style="text-align: right;" class="clr inner_title"></div>
<p class="ht5"></p>  

	<!-- BOF new HTML -->	 
	 	 	 
			 <table class="table_format"  id="schedule_form">	
			 <tr>
			    <td><label><?php echo __('Surgery');?>:</label></td>
			    <td>
			    	 
			    	<?php  
			    		echo $patientPOCheckListDetails['Surgery']['name'];
			    	?>
			     	
			    </td>
			   </tr>			    			    
			   <tr>
			    <td><label><?php echo __('S/B Registrar');?>:</label></td>
			    <td>
			    	 
			    	<?php  
			    		echo $patientPOCheckListDetails['PatientInitial']['name']." ".$patientPOCheckListDetails[0]['registrar'];
			    	?>
			     	
			    </td>
			   </tr>				   
			   <tr>
			    <td><label><?php echo __('S/B  Consultant');?>:</label></td>
			    <td>
			    	<?php
			    		echo $patientPOCheckListDetails['Initial']['name']." ".$patientPOCheckListDetails[0]['doctor_name'];
			    	?>
			     	
			    </td>
			   </tr>
			    <tr>
			    <td><label><?php echo __('Date');?>:</label></td>
			    <td>
			    	<?php
			    		 
			    		echo isset($patientPOCheckListDetails['Note']['note_date'])?$this->DateFormat->formatDate2Local($patientPOCheckListDetails['Note']['note_date'],Configure::read('date_format'), true):'';
			    	?>
			     	
			    </td>
			   </tr>
                           <tr>
			    <td><label><?php echo __('Note');?>:</label></td>
			    <td>
			    	<?php
			             echo nl2br($patientPOCheckListDetails['Note']['post_opt']);
			    	?>
			     	
			    </td>
			   </tr>
			  </table>	  
		 
	
