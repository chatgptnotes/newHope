<?php echo $this->Html->css(array('internal_style.css'));?>
<style>
.td_cell {
    font-size: 13px;
    color :black;
}

</style>
<div class="inner_title"> 
			<h3 style="font-size:13px; margin-left: 5px; padding-left:20px;"><?php 
			echo __('Past Immunization Details'); ?> </h3>
					 
			<div style="text-align:right;">
			<?php if($initialFlag == 'InitialAssessment' || $this->params->query['pageView'] == 'ajax'){
				echo $this->Html->link(__('Back'), array('controller'=>'Diagnoses','action' => 'initialAssessment',$patient_id,$this->Session->read('diagnosesID'),$this->Session->read('initialAppointmentID')), array('class'=>'blueBtn','style'=>'margin: 0 10px 0 0;'));
					echo $this->Html->link(__('Add Immunization'), array('controller'=>'imunization','action' => 'add',$patient_id,'?'=>array('pageView'=>"ajax")), array('class'=>'blueBtn','style'=>'margin: 0 13px 0 0;'));
																		
			 }else{
			 	if($initial != 'initial'){
			  		echo $this->Html->link(__('Back'), array('controller'=>'PatientsTrackReports','action' => 'sbar',$patient_id,'Situation'), array('class'=>'blueBtn','style'=>'margin: 0 10px 0 0;'));
			 	}													
			  echo $this->Html->link(__('Add Immunization'), array('controller'=>'imunization','action' => 'add',$patient_id,'?'=>array('pageView'=>"sbar")), array('class'=>'blueBtn','style'=>'margin: 0 13px 0 0;'));													
			}?>
			</div>
			
</div>		
		<div class="patient_info">
			<div id="no_app">
				<?php
					if(empty($immunization)){
						echo "<span class='error'>";
						echo __('No Record');
						echo "</span>";
					}
				?>		 	
			</div>				
			<?php if(!empty($immunization)){ ?> 
				<table border="0"    cellpadding="0" cellspacing="2" width="100%" style="text-align:center;">				 
				  <tr class="row_title row_gray_dark">				
					   <td class="table_cell"><strong><?php echo  __('Immunization', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Administered Amount', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Lot Number', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Manufacturer Name', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Administration Date', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Vaccine Expiration Date', true); ?></strong></td>
					   
					   <td class="table_cell"><strong><?php echo  __('Action', true); ?></strong></td>							   					   
				  </tr>
				  <?php
				  
				$count=0; 
				$toggle =0;
				
				foreach($immunization as $imu){
							
						if($toggle == 0) {
							echo "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							echo "<tr>";
							$toggle = 0;
						}
				$count++;	 ?>
				  <tr>							  
					   <td>
					   		<table width="100%" cellspacing='2' cellpaddding="0">								   			
								 <tr>
								 	<td class="td_cell">
								 		<?php echo $imu['Imunization']['cpt_description'];?>
								 	</td>								 		
								 </tr>				 
					   		</table>
					   </td>
					   <td class="td_cell">
					   	<?php echo $imu['Immunization']['amount'];?>&nbsp;<?php echo $imu['PhvsMeasureOfUnit']['value_code']; ?><?php if(empty($imu['Immunization']['amount'])){echo ('Unknown'); } ?>
						</td>						
				 		<td class="td_cell">
				 			<?php echo $imu['Immunization']['lot_number'];?><?php if(empty($imu['Immunization']['lot_number'])){echo ('Unknown'); } ?>
				 		</td>				 		 
				 		<td class="td_cell">
				 			<?php echo $imu['PhvsVaccinesMvx']['description'];?><?php if(empty($imu['Immunization']['manufacture_name'])){echo ('Unknown'); } ?>
				 		</td>				 		 
				 		<td class="td_cell">
				 			<?php echo $this->DateFormat->formatDate2Local($imu['Immunization']['date'],Configure::read('date_format'),true);?><?php if(empty($imu['Immunization']['date'])){echo ('Unknown'); } ?>
				 		</td>				 		 	
				 		<td class="td_cell">
				 			<?php echo $this->DateFormat->formatDate2Local($imu['Immunization']['expiry_date'],Configure::read('date_format'),true);?><?php if(empty($imu['Immunization']['expiry_date'])){echo ('Unknown'); } ?>
				 		</td>				 		 		   			      
					    <td style="padding:0px" width="170px";>					   
					   		<?php if($initialFlag == 'InitialAssessment' || $this->params->query['pageView'] == 'ajax'){
					   		/* echo $this->Html->link($this->Html->image('icons/view-icon.png'), 
					   				array('controller'=>'imunization','action' => 'view',$patient_id, $imu['Immunization']['id'],'?'=>array('pageView'=>"ajax")), array('escape' => false));	
					   		 */echo $this->Html->link($this->Html->image('icons/view-icon.png'),
									array('controller'=>'imunization','action' => 'view',$patient_id, $imu['Immunization']['id'],'?'=>array('pageView'=>"ajax")), array('escape' => false,'Title'=>'View'));
								echo $this->Html->link($this->Html->image('icons/edit-icon.png'), 
					   				array('controller'=>'imunization','action' => 'edit',$patient_id, $imu['Immunization']['id'],'?'=>array('pageView'=>"ajax")), array('escape' => false));
                                 echo $this->Html->link($this->Html->image('icons/send5.png'),
		                      array('controller'=>'imunization','action' => 'send_registry',$patient_id, $imu['Immunization']['id'],'?'=>array('pageView'=>"ajax")), array('escape' => false,'Title'=>'Send to Immunization Registry'));	
				   				echo $this->Html->link($this->Html->image('icons/delete-icon.png'), 
				   				 	array('controller'=>'imunization','action' => 'delete',$patient_id, $imu['Immunization']['id'],$imu['Immunization']['parent_id'],'?'=>array('pageView'=>"ajax")), array('escape' => false),__('Are you sure?', true));
					   		}else{
									echo $this->Html->link($this->Html->image('icons/view-icon.png'),
											array('controller'=>'imunization','action' => 'view',$patient_id, $imu['Immunization']['id']), array('escape' => false,'Title'=>'View'));
									echo $this->Html->link($this->Html->image('icons/edit-icon.png'),
											array('controller'=>'imunization','action' => 'edit',$patient_id, $imu['Immunization']['id']), array('escape' => false));
echo $this->Html->link($this->Html->image('icons/send5.png'),
		array('controller'=>'imunization','action' => 'send_registry',$patient_id, $imu['Immunization']['id'],'?'=>array('pageView'=>"ajax")), array('escape' => false,'Title'=>'Send to Immunization Registry'));
									echo $this->Html->link($this->Html->image('icons/delete-icon.png'),
											array('controller'=>'imunization','action' => 'delete',$patient_id, $imu['Immunization']['id'],$imu['Immunization']['parent_id']), array('escape' => false),__('Are you sure?', true));

							}	   			
							?>						
					  </td>
					</tr>
					<?php } ?>										   				  		  
				 </table>
			<?php } ?>			 
		</div>
		