<?php   echo $this->Html->script('jquery.autocomplete');
 		echo $this->Html->css('jquery.autocomplete.css');?>
<div id="doctemp_content">
	<?php
	if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"
		align="center">
		<tr>
			<td colspan="2" align="left" class="error"><?php 
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
			<h3>
				<?php echo __('Template')." : <b>".$template_name."</b>"; ?>
			</h3>
			<span> <?php
			echo $this->Html->link(__('Back'),array('action' => 'index'), array('escape' => false ,'class'=>'blueBtn'));
			?>
			</span>
		</div>
		<?php 	echo $this->Form->create('Note',array('action'=>'admin_template_text_add','id'=>'NoteTemplateTextfrm', 'inputDefaults' => array('label' => false,'div' => false)));
		echo $this->Form->hidden('NoteTemplateText.id');
		echo $this->Form->hidden('NoteTemplateText.template_id',array('value'=>$template_id));
		?>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="500px">
			<tr>
				<td><label><?php echo __('Template Type');?>:<font color="red">*</font>
				</label></td>
				<td><?php $context_type= array('assessment'=>'Assessment','procedure'=>'Description of Procedure','event-note'=>'Event Notes',
						'subjective'=>'HPI','investigation'=>'Investigation Notes','implants'=>'Implants Notes','lab'=>'Lab Tempaltes',
						'notes'=>'Notes','plan'=>'Plan','post-opt'=>'Post Operative Notes','pre-opt'=>'Pre Operative Notes',
						'objective'=>'Physical Examination','review of system'=>'Review of System','treatment'=>'Treatment Notes');
						     				echo $this->Form->input('NoteTemplateText.context_type', array('options'=>$context_type,'empty'=>__('Please select'),'class' => 'validate[required,custom[mandatory-select]]','id' => 'context_type')); ?>
				</td>
			</tr>
			<tr>
				<td><label><?php echo __('Template Text');?>:</label></td>
				<td><?php echo $this->Form->textarea('NoteTemplateText.template_text', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
				</td>
				<td class="row_format" align="right" colspan="2">
				<?php	echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));	?>
				</td>
			</tr>
		</table>
		<?php echo $this->Form->end();?>
		<?php echo $this->Form->create('',array('url'=>array('controller'=>'Notes','action'=>'admin_template_index',$template_id),'id'=>'NoteTemplateTextfrmsearch', 'inputDefaults' => array('label' => false,'div' => false)));
			//echo $this->Form->hidden('NoteTemplateText.template_id',array('value'=>$template_id));?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="padding-left:19px;padding-right:20px;" >
		<tbody>		 		    			 				    
			<tr class="row_title">	
				<td></td>	
				<td width="9%" class="" style="padding-left:40px;border:none!important;font-size:13px;" ><?php echo __('Template Type :') ?> </td> 
				<td width="13%" style="border:none!important;">											 
	    		<?php  echo $this->Form->input('NoteTemplateText.context_type', array('type'=>'text','id' => 'template_type_search', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));?>
	  			</td> 	
	  			<td style="border:none!important;" width="3%"><font color="RED">OR</font></td>			
				<td width="9%" class="" style="padding-left:40px;border:none!important;font-size:13px;" ><?php echo __('Template Text :') ?> </td> 
				<td width="13%" style="border:none!important;">											 
	    		<?php  echo $this->Form->input('NoteTemplateText.template_text', array('type'=>'text','id' => 'template_text_search', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));?>
	  			</td> 	 			
	  			<td width="46%" style="padding-right:576px;border:none!important">
		<?php echo $this->Form->submit(__('Search'),array('label'=> false, 'name'=>'button','div' => false, 'error' => false,'class'=>'blueBtn','title'=>'Search','style'=>'margin-left:10px;'));?>
		<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'admin_template_index',$template_id),array('escape'=>false, 'title' => 'refresh'));?>
				</td>		 
		 	</tr>							
		</tbody>	
	</table>	
	<?php echo $this->Form->end();?>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%">

			<tr class="row_title">
				<td class="table_cell"><strong><?php echo $this->Paginator->sort('NoteTemplateText.context_type', __('Template Type', true)); ?></strong></td>		 
				<td class="table_cell"><strong><?php echo $this->Paginator->sort('NoteTemplateText.template_text', __('Template Text', true)); ?>
				</strong></td>
				<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
				</td>
			</tr>
			<?php 
			$cnt =0;
			if(count($data) > 0) {
		       foreach($data as $doctortemp):
		       $cnt++;
		       ?>
			<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
				<td class="row_format"><?php echo $context_type[$doctortemp['NoteTemplateText']['context_type']]; ?> </td>
		  
				<td class="row_format"><?php echo $doctortemp['NoteTemplateText']['template_text']; ?>
				</td>

				<td><?php
				echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true),
		   			 					'alt'=> __('Edit', true))), array('action' => 'admin_template_index',$template_id,$doctortemp['NoteTemplateText']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Doctor Template Edit', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'admin_template_text_delete', $doctortemp['NoteTemplateText']['id']), array('escape' => false ));

		   ?>
			
			</tr>
			<?php endforeach;  ?>
			<tr>
				<TD colspan="8" align="center" class="table_format"><?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#doctemp_content',    												
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
				 
		 		 jQuery("#NoteTemplateTextfrm").validationEngine();
		 
				 
				 
			});	
			$(document).ready(function(){	
				$("#template_text_search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NoteTemplateText","template_text",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});	
				$("#template_type_search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NoteTemplateText","context_type",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});	
			});
</script>
