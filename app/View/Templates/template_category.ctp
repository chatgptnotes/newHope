
<?php echo $this->Html->css(array('internal_style','jquery.autocomplete','validationEngine.jquery.css'));
echo $this->Html->script(array('jquery.validationEngine','/js/languages/jquery.validationEngine-en'));?>
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
		<div style="float:right;"> <?php 
			echo $this->Form->input(__('Add', true),array('type' => 'button','class'=>'blueBtn','id'=>'addCategory','label'=>false,'div'=>false,'style'=>'margin:0 8px 0 0;'));
			if(empty($patientId)){
			echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
			}
			else{
if(empty($controller)){
			echo $this->Html->link(__('Back', true),array('controller' => 'notes', 'action' =>$action,$patientId,$noteId), array('escape' => false,'class'=>'blueBtn'));
			}
			else{
echo $this->Html->link(__('Back', true),array('controller' => 'PatientForms', 'action' =>$action,$patientId,$noteId), array('escape' => false,'class'=>'blueBtn'));
}}

?>
			</div>
			<h3>
				<?php echo __('Add Template Category', true); ?>
			</h3>
			
		</div>
		<form name="templatecategoryfrm" id="templatecategoryfrm"
			action="<?php echo $this->Html->url(array("action" => "template_category")); ?>"
			method="post">


			<table border="0" class="table_format" cellpadding="0" id="addForm" style="display:none;"
				cellspacing="0" width="60%" align="center">
				<tr>
					<td class="form_lables"><?php echo __('Template Category',true); ?><font
						color="red">*</font>
					</td><!-- show if come from Progress Note-->
						<?php echo $this->Form->input('',array('type'=>'hidden','id'=>'ros','value'=>$action));?>
						<!--  EOD-->
					<td><?php   echo $this->Form->input('Template.template_category_id', array('style'=>'width:250px; float:left;','empty'=>__('Select'),'options'=>$option,'id'=>'template_category_id','value'=>$option['Template']['template_name'],'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','label'=>false)); ?>

					</td>
				</tr>
				<tr>
					<td class="form_lables"><?php echo __('Parent Category',true); ?> <font
						color="red">*</font>
					</td>
					<td><?php 
					echo $this->Form->textarea('Template.category_name', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd', 'cols' => '35', 'rows' => '10', 'id' => 'category_name', 'label'=> false, 'div' => false, 'error' => false));
					?>
					</td>
				</tr>
				<tr>
                    <td></td>
					<td colspan="2" align="left" style="padding-right: 82px;">
                    <div style="margin-top:10px;">
                    <input type="submit" value="Submit"
						class="blueBtn">
                        </div>
					</td>
				</tr>
			</table>
		</form>
		<?php echo $this->Form->create('',array('action'=>'template_category','type'=>'get','id'=>'SearchForm'));?>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center"
			width="52%">
			<tr class="row_title">
				<td class="table_cell"><strong><?php echo __('Template Category', true); ?>
				</strong></td>
				<td class="table_cell"><?php   echo $this->Form->input('template_category_id', array('empty'=>__('Select'),'options'=>$option,'class' => 'textBoxExpnd','label'=>false,'value'=>$this->params->query['template_category_id'])); ?></td>
				<td class="table_cell"><strong><?php echo __('Parent Category', true); ?>
				</strong></td>
				<td class="table_cell"><?php echo $this->Form->input('category_name',array('type'=>'text','label'=>false));?></td>
				<td class="table_cell"><strong><?php echo $this->Form->submit(__('Search'),array('id'=>'submit','class'=>'blueBtn','div'=>false,'label'=>false),array('alt'=>'Search','title'=>'Search'));?> </strong>
				</td>
			</tr>
		</table>
		<?php echo $this->Form->end();?>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%">
			<tr class="row_title">
				<td class="table_cell"><strong><?php echo __('Template Category', true); ?>
				</strong></td>
				<td class="table_cell"><strong><?php echo __('Parent Category', true); ?>
				</strong></td>
				<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
				</td>
			</tr>
			<?php 
			$cnt =0;
			if(count($dataTemplate) > 0) {
		       foreach($dataTemplate as $datatemp):
		       $cnt++;
		       ?>
			<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
				<td class="row_format"><?php echo $option[$datatemp['Template']['template_category_id']]; ?>
				</td>
				<td class="row_format"><?php echo $datatemp['Template']['category_name']; ?>
				</td>
				<td><?php
				//	echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
				//	 					'alt'=> __('View', true))), array('action' => 'admin_template_index', $datatemp['Template']['id']), array('escape' => false ));
				echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			 					'alt'=> __('Edit', true))), array('action' => 'edit_template', $datatemp['Template']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'template_delete', $datatemp['Template']['id']), array('escape' => false ),"Are you sure you wish to delete this template?");

		   ?>
			
			</tr>
			<?php endforeach;  ?>
			<tr>
				<TD colspan="8" align="center" class="table_format"><?php 
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
				echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#doctemp_content',    												
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
					<?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#doctemp_content',    												
							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

					<span class="paginator_links"> <?php echo $this->Paginator->counter(array('class' => 'paginator_links'));
					echo $this->Paginator->numbers(); ?>
				</span>
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

	<script>
	jQuery(document).ready(function(){
		if($('#ros').val()=='reviewOfSystem'){
			$('#template_category_id').val('1');
			$('#addForm').toggle('slow');
		}
		if($('#ros').val()=='systemicExamination'){
			$('#template_category_id').val('2');
			$('#addForm').toggle('slow');
		}
		if($('#ros').val()=='hpiCall'){
			$('#template_category_id').val('3');
			$('#addForm').toggle('slow');
		}
	// binds form submission and fields to the validation engine
		jQuery("#templatecategoryfrm").validationEngine();

		$('#addCategory').click(function (){
			$('#addForm').toggle('slow');
			});
	});
</script>