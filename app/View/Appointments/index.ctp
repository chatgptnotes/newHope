<div class="inner_title">
	 
	<h3>
		<?php
			echo $this->Html->image('/img/icons/appointment_icon.png');
		?>
	  &nbsp; <?php echo __('Appointments') ?></h3>
	<span> <?php			 
	 echo $this->Html->link(__('Search Patient'),array('controller'=>'patients','action' => 'search'), array('escape' => false,'class'=>'blueBtn')); ?></span>
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
	<div class="patient_info">
			<table width="100%">
				<tr>
					
					<td width="100%" valign="top">
						<?php 
							echo $this->Form->create(null, array('url' => array('controller' => 'doctor_schedules', 'action'=>'doctor_event'), 'id'=>'appointmentfrm', 'inputDefaults' => array('label' => false,'div' => false))); 
						?>
						<table width="50%">
							<tr>
								<td><?php 	echo __('List Appointments by Doctors')?></td>
							</tr>
							<tr>
								<td>
									<?php										  	 
											echo $this->Form->input(null,array('name' => 'doctor_userid', 'id'=> 'doctor_userid', 'empty'=>__('Please select'),'options'=>$doctors));											
									?>
								</td>
								<td>
									<?php
											echo $this->Form->submit(__('Show'),array('class'=>'blueBtn','label' => false,'div' => false));										
									?>
								</td>
							</tr>
						</table>
						<?php echo $this->Form->end(); ?>
					</td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>			 
			<div id="no_app" >
				<?php
					/*if(empty($data)){
						echo "<span class='error'>";
						echo __('There is no pending appointment.');
						echo "</span>";
					}*/
				?>		 	
			</div>		
			<div class="inner_title" style="text-align:right;">
	  		<?php 
		   		//echo $this->Html->link(__('Set new appointment'),array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
		    ?>
	 	</div>
		<?php if(!empty($data)){ ?>
				<table border="0"    cellpadding="0" cellspacing="2" width="100%" style="text-align:center;">
				  <tr>
				  	<td colspan="8" align="right">
				  		<?php 
					   		
					   ?>
					   </td>
				  </tr>
				  <tr class="row_title row_gray_dark">
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Appointment.date', __('Date/Time/Details', true)); ?></strong></td>
					  <td class="table_cell"><strong><?php echo  __('Patients', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Appointments', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>					   
				  </tr>
				  <?php 
				  	  $toggle =0;
				      $i=0 ;		
				      	
				      		foreach($data as $appointment){
				       
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr class='row_gray_dark'>";
								       	$toggle = 0;
							       }
								  ?>								  
								   <td>
								   		<table width="100%" cellspacing='2' cellpaddding="0">
								   			<tr>
								   			 	<td  cellspacing='2'>
											   		<?php
											   		    echo $this->DateFormat->formatDate2Local($appointment['Appointment']['date'],Configure::read('date_format')); 
											   		?> 
											   	</td>
											 </tr>
											<tr>
											 	<td>
											 		<?php 
											 			echo $appointment['Appointment']['start_time'];
											 			echo (!empty($appointment['Appointment']['end_time']))?"-".$appointment['Appointment']['end_time']:"";
											 	 	?> </td>
											 </tr>
											 
											 <tr>		   						   
											 	<td>
											 		<?php if(isset($appointment['Department']['name'])) echo $appointment['Department']['name']; ?> 
											 	</td>
											 </tr>
											 <tr>		   						   
											 	<td  >
											 		<?php if(isset($appointment[0]['full_name'])) echo $appointment['Patient']['full_name']; ?> </td>
											 </tr>
								   		</table>
								   </td>
								   <td >
								   		<table width="100%">
								   			<tr>
									   			<td>								   				 
								   					<?php 
						   									echo $this->Html->link($this->Html->image("icons/patient.png"), 
						   				 						 array('controller'=>'patinets','action' => 'patient_information', $appointment['Appointment']['patient_id']), array('escape' => false));
						   							?>										   				 
									   			</td>
									   			<td>
									   				<table>
									   					<tr>
									   						<td>
									   							<?php 
									   									echo $this->Html->link($appointment['Patient']['full_name'], 
						   				 						 		array('controller'=>'patients','action' => 'patient_information', $appointment['Appointment']['patient_id']), array('escape' => false));
									   							?></td>
									   					</tr>
									   					<tr>
									   						<td>
									   							<?php  echo "Age: ".$appointment['Patient']['age'].' Yrs'; ?>
									   						</td>
									   					</tr>								   						
									   				</table>
									   			</td>
								   			</tr>							   			
								   		</table>
								   </td>								   	
								   <td  width="600px"><?php echo $appointment['Appointment']['purpose']; ?> </td>	   
								   <td style="padding:0px:" width="170px;">
								   		<?php 
								   			echo $this->Html->link($this->Html->image('icons/edit-icon.png'), 
								   				 array('controller'=>'appointments','action' => 'app_edit', $appointment['Appointment']['id']), array('escape' => false));
								   		?>
								  
								   		<?php 							   		 
 
								   			echo $this->Html->link($this->Html->image('icons/delete-icon.png'), 
								   				 array('controller'=>'appointments','action' => 'delete', $appointment['Appointment']['id']), array('escape' => false),"Are you sure you wish to cancel this appointment?");
								   		?>
								  </td>
								  </tr>
					  <?php 		}
					  
					 // debug($this->Paginator->params());
					  
					   ?>
					   <tr>
					    <TD colspan="8" align="center">
					    <!-- Shows the page numbers -->
					 <?php
					  
					 	
					 $this->Paginator->options(array('url' => array("?"=>$this->request->query))); 			 
 
					 	
					  echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
					 
					 <?php echo $this->Paginator->prev(__('« Previous', true),null, null, array('class' => 'paginator_links')); ?>
					 <?php echo $this->Paginator->next(__('Next »', true),null, null, array('class' => 'paginator_links')); ?>
					 <!-- prints X of Y, where X is current page and Y is number of pages -->
					 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links'));
					
					 
					  ?>
					    </TD>
					   </tr>					  		  
				 </table>
			<?php }  	?>
	</div>
	
		<script>
			jQuery(document).ready(function(){
				// binds form submission and fields to the validation engine
				jQuery("#appointmentfrm").validationEngine();		
			});
	 
		//script to include datepicker
		$(function() {
		
			var events = [ 
			    { Title: "Five K for charity", Date: new Date("11/13/2011") }, 
			    { Title: "Dinner", Date: new Date("11/25/2011") }, 
			    { Title: "Meeting with manager", Date: new Date("11/01/2011") }
			];
			
			
			$( "#datepicker" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			beforeShowDay: function(date) {
			    var result = [true, '', null];
			    var matching = $.grep(events, function(event) {
			        return event.Date.valueOf() === date.valueOf();
			    });
			
			    if (matching.length) {
			        result = [true, 'highlight', null];
			    }
			    return result;
			},
			onSelect: function(date) {
			  $("#sDate").val(date);
			  $('#appointmentfrm').submit();
			},
			defaultDate:"<?php  if(isset($this->data['Appointment']['sDate'])) echo $app_date_calender ;?>",					
			
		}); 
		 
		});
 		
 		 
		</script>
		 