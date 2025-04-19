 <div id="doctemp_content">
<?php
  if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
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
	<div id="docTemplate">
		<div class="inner_title">
			<h3><?php echo __('Template')." : <b>".$template_name."</b>"; ?></h3>
			<span>
				<?php
						echo $this->Html->link(__('Back'),array('action' => 'index'), array('escape' => false ,'class'=>'blueBtn'));					
		   		?>		
			</span>
		</div>
		<?php 	echo $this->Form->create('',array('action'=>'admin_template_text_add','id'=>'DoctorTemplateTextfrm', 'inputDefaults' => array('label' => false,'div' => false)));
				echo $this->Form->hidden('DoctorTemplateText.id');
				echo $this->Form->hidden('DoctorTemplateText.template_id',array('value'=>$template_id));
			?>	
				<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="500px" >
                                    <!--
				<?php if($template_data['DoctorTemplate']['template_type'] == Configure::read('histo_pathology_lable')){?>
						  <tr>

				<td><label><?php echo __("Histo Section");?>:<font
				color="red">*</font></label>

				</td>
				<td><?php echo $this->Form->input('DoctorTemplateText.sub_template_id', array('empty'=>__('Please Select'),'options'=>$histoSections,'style'=>'width:175px;','class' => 'validate[required,custom[mandatory-select]]','id' => 'sub_template_id','label'=> false)); ?>
				</td>
				</tr>
				<?php } ?>
                                    -->
						 <tr>
						  <td><label><?php echo __('Template Text');?>:</label></td>
						  <td>						  		
						     		<?php echo $this->Form->textarea('DoctorTemplateText.template_text', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
						  </td>
						 			 
						  <td class="row_format" align="right" colspan="2">
						   <?php
								echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
						   ?>
						  </td>
						 </tr>	
				</table>	
		 <?php echo $this->Form->end();?>	
	 
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">		 
				
		   <tr class="row_title">
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorTemplateText.id', __('Sr.No.', true)); ?></strong></td>		  
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorTemplateText.template_text', __('Template Text', true)); ?></strong></td> 
		   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
		  </tr>
		  <?php 
		      $cnt =0;
		      if(count($data) > 0) {
		       foreach($data as $doctortemp):
		       $cnt++;
		  ?>
		   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		   <td class="row_format"><?php echo $doctortemp['DoctorTemplateText']['id']; ?> </td>
		   <td class="row_format"><?php echo $doctortemp['DoctorTemplateText']['template_text']; ?> </td>
		    
		   <td>
		   <?php
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true),
		   			 					'alt'=> __('Edit', true))), array('action' => 'admin_template_index',$template_id,$doctortemp['DoctorTemplateText']['id']), array('escape' => false ));					
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Doctor Template Edit', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'admin_template_text_delete', $doctortemp['DoctorTemplateText']['id']), array('escape' => false ));					
		   					 							
		   ?>
		  </tr>
		  <?php endforeach;  ?>
		   <tr>
		       <TD colspan="8" align="center" class="table_format" >		    
							 
							 <?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#doctemp_content',    												
		    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
							 <?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#doctemp_content',    												
		    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
							 
							 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); 					 
							 
							 ?>
				</TD>
		   </tr>
		  <?php
		  
		      } else {
		  ?>
		  <tr>
		   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		  </tr>
		  <?php
		      }
		      
		      echo $this->Js->writeBuffer(); 	//please do not remove 
		  ?>
		  
		 </table>
	 </div>
</div>

<script>
			jQuery(document).ready(function(){
				 
		 		 jQuery("#DoctorTemplateTextfrm").validationEngine();
		 
				 
				 
			});	
</script>
				