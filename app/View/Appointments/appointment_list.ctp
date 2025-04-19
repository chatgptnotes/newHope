<div class="inner_title"><h3>
			<div style="float:left"><?php echo __('Appointment Details'); ?> </div>			
			<div style="text-align:right;">
			<?php
						 
					    //echo $this->Js->link(__('Schedule New Appointment'), array('controller'=>'appointments','action' => 'add',$id), array('update' => '#list_content','method'=>'post','class'=>'blueBtn'));
					    //above is the ajax link to add app
						echo $this->Html->link(__('Schedule New Appointment'), array('controller'=>'patients','action' => 'edit',$this->params['pass'][0]), array('escape'=>false,'class'=>'blueBtn'));?>
			</div>
			</h3></div>
		
		<div class="patient_info">
			<div id="no_app" >
				<?php
					if(empty($data)){
						echo "<span class='error'>";
						echo __('There is no pending appointment.');
						echo "</span>";
					}
				?>		 	
			</div>		
			
			<?php if(!empty($data)){ ?>
				<table border="0"    cellpadding="0" cellspacing="2" width="100%" style="text-align:center;">
				 
				  <tr class="row_title row_gray_dark">
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Appointment.date', __('Date/Time/Details', true)); ?></strong></td>
					
					   <td class="table_cell"><strong><?php echo  __('Appointments', true); ?></strong></td><!--
					   <td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>					   
				  --></tr>
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
											 	<td>
											 		<?php if(isset($appointment[0]['full_name'])) echo $appointment[0]['full_name']; ?> 
											 	</td>
											 </tr>
								   		</table>
								   </td>
								  
								   <td  width="600px"><?php echo $appointment['Appointment']['purpose']; ?> </td><!--	   
								   <td style="padding:0px" width="170px">
								   		<?php 
								   			/*echo $this->Js->link($this->Html->image('icons/edit-icon.png'), 
								   				 array('controller'=>'appointments','action' => 'edit', $appointment['Appointment']['id']), array('escape' => false,'update'=>'#list_content','method'=>'post'));								   			
 
								   			echo $this->Js->link($this->Html->image('icons/delete-icon.png'), 
								   				 array('controller'=>'appointments','action' => 'delete', $appointment['Appointment']['id'],$appointment['Appointment']['patient_id']), array('escape' => false,'update'=>'#list_content','method'=>'post','confirm'=>"Are you sure you wish to cancel this appointment?"),"Are you sure you wish to cancel this appointment?");
								   		*/?>
								  </td>
								  --></tr>
					  <?php 		} ?>
					   <tr>
					    <TD colspan="8" align="center">
					    <!-- Shows the page numbers -->
					 <?php /*echo $this->Paginator->numbers(array('class' => 'paginator_links','update'=>'#list_content',    												
    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))
    												));*/ ?>
					 <!-- Shows the next and previous links -->
					 <?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#list_content',    												
    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
					 <?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#list_content',    												
    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
					 <!-- prints X of Y, where X is current page and Y is number of pages -->
					 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); 					 
					 
					 ?>
					    </TD>
					   </tr>					  		  
				 </table>
			<?php } 
				
					 
			echo	$this->Paginator->options(array(
				    'update' => '#list_content',
				    'evalScripts' => true,
				    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
				    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
				));
				echo $this->Js->writeBuffer();	
			?>
		</div>
		