<div class="inner_title"> 
			<h3><?php echo __('Diagnosis Details'); ?> </h3>
			<?php 
				if(empty($diagnosis)){
			?>		 
			<div style="text-align:right;">
			<?php 
			pr($diagnosis);
					    echo $this->Js->link(__('Add Assessment'), array('controller'=>'diagnoses','action' => 'add',$patient_id), array('class'=>'blueBtn'));													
			?>
			</div>
			<?php } ?>
</div>		
		<div class="patient_info">
			<div id="no_app" >
				<?php
					if(empty($diagnosis)){
						echo "<span class='error'>";
						echo __('No Record');
						echo "</span>";
					}
				?>		 	
			</div>				
			<?php if(!empty($diagnosis)){ ?>
				<table border="0"    cellpadding="0" cellspacing="2" width="100%" style="text-align:center;">				 
				  <tr class="row_title row_gray_dark">				
					   <td class="table_cell"><strong><?php echo  __('Diagnosis', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Action', true); ?></strong></td>							   					   
				  </tr>
				  <tr>							  
					   <td>
					   		<table width="100%" cellspacing='2' cellpaddding="0">								   			
								 <tr>
								 	<td>
								 		<?php			echo $diagnosis['Diagnosis']['diagnosis']; 	?> </td>
								 </tr>				 
					   		</table>
					   </td>				   			      
					   <td style="padding:0px" width="170px">
					   		<?php 
					   			echo $this->Js->link($this->Html->image('icons/edit-icon.png'), 
					   				 array('controller'=>'diagnoses','action' => 'add', $diagnosis['Diagnosis']['patient_id']), array('escape' => false));						   			
							?>
					  </td>
					</tr>										   				  		  
				 </table>
			<?php } ?>			 
		</div>
		