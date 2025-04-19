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
			<h3><?php echo __('Template')." : <b>".'('.$result['Radiology']['name'].')'.' '.$template_name."</b>"; ?></h3>
			<span>
				<?php
						echo $this->Html->link(__('Back'),array('action' => 'template'), array('escape' => false ,'class'=>'blueBtn'));					
		   		?>		
			</span>
		</div>
		<?php 	echo $this->Form->create('',array('action'=>'admin_template_text_add','id'=>'RadiologyTemplateTextfrm', 'inputDefaults' => array('label' => false,'div' => false)));
				echo $this->Form->hidden('RadiologyTemplateText.id');
				echo $this->Form->hidden('RadiologyTemplateText.template_id',array('value'=>$template_id));
				echo $this->Form->hidden('RadiologyTemplateText.radiology_id',array('value'=>$this->params->query['radiologyId']));
			?>	
				<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="500px" >
						  
						 <tr>
						  <td><label><?php echo __('Template Text');?>:</label></td>
						  <td>						  		
						     		<?php echo $this->Form->textarea('RadiologyTemplateText.template_text', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
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
				
		   <tr class="row_title"><!--
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTemplateText.id', __('Id', true)); ?></strong></td>		  
		   --><td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTemplateText.template_text', __('Template Text', true)); ?></strong></td> 
		   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
		  </tr>
		  <?php 
		      $cnt =0;
		      if(count($data) > 0) {
		       foreach($data as $doctortemp):
		       $cnt++;
		  ?>
		   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		   <!--<td class="row_format"><?php echo $doctortemp['RadiologyTemplateText']['id']; ?> </td>
		   --><td class="row_format"><?php echo $doctortemp['RadiologyTemplateText']['template_text']; ?> </td>
		    
		   <td>
		   <?php
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true),
		   			 					'alt'=> __('Edit', true))), array('action' => 'admin_template_index',$template_id,$doctortemp['RadiologyTemplateText']['id'],'?'=>array('radiologyId'=>$this->params->query['radiologyId'])), array('escape' => false,'class'=>'editClass'));					
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Doctor Template Delete', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'admin_template_text_delete', $doctortemp['RadiologyTemplateText']['id']), array('escape' => false ));					
		   					 							
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
		 		 jQuery("#RadiologyTemplateTextfrm").validationEngine();
			});	
</script>
				