<?php echo $this->Html->css(array('jquery.timepicker'));?>
<?php echo $this->Html->script(array('jquery-1.6.3.min', 'jquery1.7.2-ui.min', 'jquery.timepicker')); ?>
<div class="inner_title">
	<?php
			$complete_name  = ucfirst($this->Session->read('title'))." ".ucfirst($this->Session->read('first_name'))." ".ucfirst($this->Session->read('last_name')) ;
			//echo __('Edit Appoinment For-')." ".$complete_name;
	?> 
	<h3>
		<?php
			echo $this->Html->image('/img/icons/appointment_icon.png');
		?>
	  &nbsp; <?php echo __('Set Appointment For-')." ".$complete_name ?></h3>
 
</div> 
		 
	<?php 
	  if(!empty($errors)) {
	?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
	 <tr>
	  <td colspan="2" align="left" class="error">
	   <?php 
	     foreach($errors as $errorsval){
	         echo $errorsval[0];
	         echo "<br />";
	     }
	   ?>
	  </td>
	 </tr>
	</table>
	<?php } ?>
	<div class="inner_left">    	 
			<?php echo $this->Form->create('Appointment',array('id'=>'appointmentfrm','action'=>'app_edit'
						,'inputDefaults' => array('label' => false,'div' => false))); ?> 
    		<table class="table_format"  id="schedule_form">
 				<tbody>
 					
 					<tr>
    					<td><label>Location Name :</label></td>
 						<td>
 							<?php 								 
 								echo $this->Form->hidden('id', array('value'=>$id));
 								echo $this->Form->hidden('patient_id', array('value'=>$this->data['Appointment']['patient_id']));
 							 ?>
 							<strong>	
			 				<?php echo ucfirst($this->Session->read('location')); ?>
			 				</strong>	  	   					  
						</td>
					</tr>
					<tr>
					     <td><label><?php echo __('Specilty'); ?></label></td>
					     <td>
						    <?php echo $this->Form->input('department_id', array('type'=>'select','empty'=>__('Please select'),'class' => 'validate[required,custom[mandatory-select]]',
 									   'options'=>$departments,'id' => 'department_id', 'label'=> false,
			 					  	   'div' => false,'error' => false)); ?>
					    </td>
					</tr>
					<tr>
					     <td><label><?php echo __('Doctor');?> :</label></td>
					     <td>
						    <?php echo $this->Form->input('doctor_id', array('type'=>'select','empty'=>__('Please select'),'class' => 'validate[required,custom[mandatory-select]]',
 									   'options'=>$doctors,'id' => 'doctor_id', 'label'=> false,
			 					  	   'div' => false,'error' => false)); ?>
					    </td>
					</tr>
					<tr>
					    <td><label>Visit Type :</label></td>
					    <td>
					    	<?php 
					    			$visit_types = array('First_Visit'=>'First Visit','Emergency'=>'Emergency','Follow_Up'=>'Follow-Up',
					    								'Vaccination'=>'Vaccination');
				    				echo $this->Form->input('Appointment.visit_type', array('type'=>'select','empty'=>__('Please select'),
								   							'options'=>$visit_types,'id' => 'visit_type', 'label'=> false,
		 					  	   							'div' => false,'error' => false)); ?>					  
						</td>
				    </tr>					    
				    <tr>
				    	<td><label>Visit Date :</label></td>
				 		<td>
				    		<?php echo $this->Form->input('visit_on', array('class' => 'validate[required,custom[mandatory-date]]','id' => 'visit_on', 'label'=> false,
			 					  	   'div' => false,'error' => false)); ?>
				   		</td>
				   </tr>
				   <tr>
				   		<td><label>Start Time :</label></td>
				 		<td>
				   			<?php echo $this->Form->input('start', array('class' => 'validate[required,custom[mandatory-time]]','id' => 'start', 'label'=> false,
			 					  	   'div' => false,'error' => false)); ?> 
				   		</td>
				   </tr>
				   <tr>
				   		<td><label>End Time :</label></td>
				 		<td>
				   		<?php echo $this->Form->input('end', array( 'id' => 'end', 'label'=> false,
			 					  	   'div' => false,'error' => false)); ?> 
				   		</td>
				   </tr>
				   <tr>
				   		<td><label><?php echo __('Purpose');?></label></td>
				 		<td>
				   		<?php echo $this->Form->textarea('purpose', array( 'id' => 'purpose', 'label'=> false,
			 					  	   'div' => false,'error' => false ,'rows'=>'10','style'=>'width:500px')); ?> 
				   		</td>
				   </tr>
				   <tr>
					   	<td></td>
					 	<td>
					 		<?php 
					 		
					 			echo $this->Html->link($this->Form->button(__('Cancel'),array('class'=>'blueBtn','type'=>'button')),
					 			                       '/appointments/index/',array('escape' => false,'style'=>'text-decoration:none')) ;
					 			
					 		   echo $this->Form->submit(__('Submit'), array('label'=> false,
			 					  	   'div' => false,'error' => false,'class'=>'blueBtn' ));
			 						 					
			 		 	   
			 					  	    ?> 
					   	</td>					 
				 	</tr>
				  
				</tbody>
			</table>
			<?php echo $this->Form->end();?>
		</div>
		<script>
			jQuery(document).ready(function(){
				// binds form submission and fields to the validation engine
				  
					jQuery("#appointmentfrm").submit(function(){
						var returnVal = jQuery("#appointmentfrm").validationEngine('validate');						 
						
					});
				 
				
			});	
	 
		//script to include datepicker
		$(function() {
			$( "#visit_on" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			
		}); 
		$( "#start" ).timepicker({
			'showDuration': true,	
                        'minTime': '8:00am',
                        'maxTime': '7:00pm',
                        'timeFormat': 'H:i',
                        'step': 15		
			
		});
		 
		$( "#end" ).timepicker({
				'showDuration': true,	
                                'minTime': '8:00am',
                                'maxTime': '7:00pm',
                                'timeFormat': 'H:i',
                                'step': 15,
			
			});
		});	 
		
 		
		</script>
		 