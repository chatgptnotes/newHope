<?php 
	echo $this->Html->script(array('jquery.autocomplete_pharmacy'));
	echo $this->Html->css(array('jquery.autocomplete'));
?>
<div class="inner_title">
<h3><?php echo __('Add Complaint', true); ?></h3>
</div>

<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
 


<?php 
	      		echo $this->Form->create('Complaint', array('action'=>'add','id'=>'Complaintfrm','inputDefaults' => array(
															        'label' => false,'div' => false,'error'=>false,'legend'=>false,'O'))) ;
?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
		<td colspan="2" align="center">
		<br>
		</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Patient Name'); ?><font color="red">*</font>
		</td>
		<td >
	        <?php  
			 	 echo $this->Form->input('patient_name', array('type'=>'text','class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]','id' => 'complaint-patient-name'));
			 	 echo $this->Form->input('Complaint.patient_id', array('type'=>'hidden','id' => 'patient_id'));
			 	 echo $this->Form->input('Complaint.id', array('type'=>'hidden'));
			 	 
			?>
		</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Date'); ?><font color="red">*</font>
		</td>
		<td >
	        <?php 
			 echo $this->Form->input('Complaint.date', array('type'=>'text','class' => 'textBoxExpnd validate[required,custom[mandatory-date]]',
			 						'id' => 'complaint-date','style'=>'width:88%'));
			?>
		</td>
	</tr>
	<tr>
		<td class="form_lables">
		<?php echo __('Complaint'); ?><font color="red">*</font>
		</td>
		<td >
	        <?php 
	       
			 echo $this->Form->textarea('Complaint.complaint', array('class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]','id' => 'complaint-complaint','row'=>'10'));
			
	        ?>
		</td>
	</tr>	
	<tr>
		<td class="form_lables">
		<?php echo __('Action Taken'); ?>
		</td>
		<td >
	        <?php 
	       
			 echo $this->Form->textarea('Complaint.action_taken', array('class' => 'textBoxExpnd ','id' => 'complaint-action','row'=>'5'));
			
	        ?>
		</td>
	</tr>
	
	<!--  <tr>
		<td class="form_lables">
		<?php //echo __('Resolution Time Taken'); ?>
		</td>
		<td >
	        <?php  //echo $this->Form->input('Complaint.resolution_time_taken', array('class' => 'textBoxExpnd ','id' => 'complaint-resolution-time')); ?>
		</td>
	</tr> -->
	<tr>
	
		<td class="form_lables">
		<?php echo __('Resolved'); ?>
		</td>
		<td class="form_lables">
	        <?php  
	        	
	        	echo $this->Form->input('Complaint.resolved', array('options'=>array('No','Yes'),'type'=>'radio','id' => 'complaint-resolution-times','class'=>'complaint-resolution-times','autocomplete'=>"off" ,'checked'=>'No')); ?>
		</td>
	</tr> 
	
	<tr id="tr_show">
		<td class="form_lables ">
		<?php echo __('Time of Resolution'); ?>
		</td>
		<td >
	        <?php 
	       
			 echo $this->Form->input('Complaint.time_of_resolution', array('type'=>'text','class' => 'textBoxExpnd'.$class ,'id' => 'complaint-resolution-time','style'=>'width:88%'));
			
	        ?>
		</td>
	</tr>
	
	
	<tr>
	<td colspan="2" align="center">
	<?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>

<script> 


	  $(document).ready(function(){ 

		    jQuery("#Complaintfrm").validationEngine();
			$("#complaint-patient-name").autocomplete( 
							"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name", "admin" => false,"plugin"=>false)); ?>",{
							width: 250,
							selectFirst:true,
							onItemSelect:function(event,ui){ $('#patient_id').val(event.extra[0])},
							//alert(onItemSelect),
							}); 

			$( "#complaint-date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
				buttonImageOnly : true,
				
			});

		 
			$( "#complaint-resolution-time" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
				buttonImageOnly : true,
			}); 
			 

			
			$("#Complaintfrm").submit(function(value) {
				//onItemSelect:function(event,ui){ $('#patient_id').val(event.extra[0])}
				value  = $('#patient_id').val();
				 
				if(value ==""){
					//alert("Entered patient is not valid") ;
					return false ;
				}
				
				
			})	 
			$(".complaint-resolution-times").click(function(){
				
				if ($(this).val()==1)
				{
					$("#tr_show").show("fast");
				}
				else
				{	   
					$("#tr_show").hide("fast");
				}
			  });
	
	  });
	  
	  </script>
 