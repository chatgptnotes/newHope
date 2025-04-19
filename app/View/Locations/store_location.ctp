
<div id="doctemp_content">
	<div class="inner_title">
		<h3>
			<?php echo __($title_for_layout, true); ?>
		</h3>
		<span> <?php

		echo $this->Html->link(__('Add', true),"javascript:void(0);", array('escape' => false,'class'=>'blueBtn','id'=>'add-note'));

		echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master'),'admin'=>true), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>
	<?php echo $this->Form->create('StoreLoc',array('url'=>array('controller'=>'Locations','action'=>'storeLocation'),'id'=>'storeLocationfrm', 'inputDefaults' => array('label' => false,'div' => false)));
	echo $this->Form->hidden('StoreLocation.id',array('id'=>'note-id'));
	if($action=='edit') $display  = '' ;
	else $display = 'none';
	?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="500px" align="right" style="display:<?php echo $display; ?>;" id="note-add-form">
		<tr>
			<td><label style="width: 99px;"><?php echo __('Location Name');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input('StoreLocation.name', array('style'=>'width:157px;','type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
			</td>
		</tr>
		
		<tr>
			<td><label style="width: 99px;"><?php echo __('Code Name');?>:</label>
			</td>
			<td><?php echo $this->Form->input('StoreLocation.code_name', array('style'=>'width:157px;','type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'code_name','readonly'=>false)); ?>
			<i>(for configuration purpose)</i>
			</td>
		</tr>
		
		<tr>
			<td><label><?php echo __("Specialty");?>:<font color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input('StoreLocation.department_id', array('empty'=>__('Please Select'),'options'=>$departments,'style'=>'width:172px;','class' => 'validate[required,custom[mandatory-select]]','id' => 'department_id','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Role");?>:</label>
			</td>
			<td><?php echo $this->Form->input('StoreLocation.role_id', array('empty'=>__('Please Select'),'multiple'=>true,'options'=>$role,'style'=>'width:172px;','id' => 'role','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Account");?>:</label>
			</td>
			<td><?php echo $this->Form->input('StoreLocation.account_id', array('empty'=>__('Please Select'),'options'=>$account,'style'=>'width:172px;','id' => 'account','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Type");?>:</label>
			</td>
			<td><?php echo $this->Form->input('StoreLocation.location_type_id', array('empty'=>__('Please Select'),'options'=>$types,'style'=>'width:172px;','id' => 'type','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Assignment Path Rule");?>:</label>
			</td>
			<td><?php echo $this->Form->input('StoreLocation.assignment_path_rule', array('empty'=>__('Please Select'),'options'=>array('Default'=>'Default'),'style'=>'width:172px;','id' => 'assignmentPathRule','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label style="width: 99px;"><?php echo __('Description');?>: </label>
			</td>
			<td><?php echo $this->Form->textarea('StoreLocation.description', array('id' => 'description')); ?>
			</td>
		</tr>
		
		<tr>
			<td><label style="width: 99px;"><?php echo __('Allow Purchase');?>: </label>
			</td>
			<td><?php echo $this->Form->input('StoreLocation.allow_purchase', array('id' => 'allow_description','type'=>'checkbox','label'=>false)); ?>
			</td>
		</tr>
		
		<tr>
			<td class="row_format" align="right" colspan="2"><?php
			echo $this->Html->link('Cancel','javascript:void(0);',array('escape' => false,'id'=>'note-cancel','class'=>'blueBtn'));
			echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
			?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
	<div>&nbsp;</div>
	<?php echo $this->Form->create('StoreLocation',array('url'=>array('controller'=>'Locations','action'=>'storeLocation'),'type'=>'Get','id'=>'storeLocationfrmsearch', 'inputDefaults' => array('label' => false,'div' => false)));?>
	<table border="0" cellpadding="0" cellspacing="0" width="500px;"
		style="padding-left: 19px; padding-right: 20px;">
		<tbody>
			<tr class="row_title">
				<td width="30%" class=""
					style="border: none !important; font-size: 13px;"><?php echo __('Location Name :') ?>
				</td>
				<td width="30%" style="border: none !important;"><?php  echo $this->Form->input('name', array('type'=>'text','id' => 'name_search', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));?>
				</td>
				<td width="40%" style="border: none !important;"><?php echo $this->Form->submit(__('Search'),array('label'=> false,'div' => false, 'error' => false,'class'=>'blueBtn','title'=>'Search','style'=>'margin-left:10px;'));	?>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Locations','action'=>'storeLocation'),array('escape'=>false, 'title' => 'refresh'));?>
				</td>
			</tr>
		</tbody>
	</table>
	<?php echo $this->Form->end();?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('StoreLocation.name', __('Location Name', true)); ?>
			</strong>
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('StoreLocation.description', __('Description', true)); ?>
			</strong>
			</td>
			<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
			</td>
		</tr>
		<?php 
		$cnt =0;
		if(count($data) > 0) {
		       foreach($data as $locationAry):
		       $cnt++;
		       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"><?php echo $locationAry['StoreLocation']['name']; ?>
			</td>
			<td class="row_format"><?php echo $locationAry['StoreLocation']['description']; ?>
			</td>
			<td><?php
			echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
		   			 					'alt'=> __('View', true))), array('controller'=>'Locations','action' => 'viewStoreLocation', $locationAry['StoreLocation']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			 					'alt'=> __('Edit', true))), array('controller'=>'Locations','action' => 'storeLocation', $locationAry['StoreLocation']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('controller'=>'Locations','action' => 'deleteStoreLocation', $locationAry['StoreLocation']['id']), array('escape' => false ),"Are you sure you wish to delete this location?");
			?>
		
		</tr>
		<?php endforeach;  ?>
		<tr>
			<TD colspan="8" align="center" class="table_format"><?php 
			$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			echo $this->Paginator->counter(array('class' => 'paginator_links'));
			echo $this->Paginator->prev(__('« Previous', true), array(/*'update'=>'#doctemp_content',*/
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

				<?php 
				echo $this->Paginator->numbers(); ?> <?php echo $this->Paginator->next(__('Next »', true), array(/*'update'=>'#doctemp_content',*/
							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

				<span class="paginator_links"> </span>
			</TD>
		</tr>
		<?php
 			} else {
		  	?>
		<tr>
			<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php }
		echo $this->Js->writeBuffer(); 	//please do not remove
		?>
	</table>
</div>
<script>
jQuery(document).ready(function(){
	//code name could not be editable in edit case
	//by swapnil G.Sharma
	var code_name = $("#code_name").val();
	if(code_name !=''){
		$("#code_name").attr('readonly',true);
	}else{
		$("#code_name").attr('readonly',false);
	}
	
	
	
 	jQuery("#storeLocationfrm").validationEngine();						 
				 

	$("#add-note").click(function(){
		$( "#storeLocationfrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) {
			$(this).val('');
		});
		$("#note-add-form").show('slow') ;
	});

	$("#note-cancel").click(function(){
		$( "#storeLocationfrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) { //reset current form
			$(this).val('');
		});
		$("#note-add-form").hide('slow') ;
	});
});
</script>
