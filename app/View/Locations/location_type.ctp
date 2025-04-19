
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
	<?php echo $this->Form->create('LocationTyp',array('url'=>array('controller'=>'Locations','action'=>'locationType'),'id'=>'locationTypefrm', 'inputDefaults' => array('label' => false,'div' => false)));
	echo $this->Form->hidden('LocationType.id',array('id'=>'note-id'));
	if($action=='edit') $display  = '' ;
	else $display = 'none';
	?>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="500px" align="right" style="display:<?php echo $display; ?>;" id="note-add-form">
		<tr>
			<td><label style="width: 99px;"><?php echo __('Location Type');?>:<font
					color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input('LocationType.name', array('style'=>'width:157px;','type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Stock Rule");?>:<font color="red">*</font> </label>
			</td>
			<td><?php echo $this->Form->input('LocationType.stock_rule', array('empty'=>__('Please Select'),'options'=>Configure::read('stockRule'),'style'=>'width:172px;','class' => 'validate[required,custom[mandatory-select]]','id' => 'stockRule','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Restock Rule");?>:</label>
			</td>
			<td><?php echo $this->Form->input('LocationType.restock_rule', array('empty'=>__('Please Select'),'options'=>Configure::read('reStockRule'),'style'=>'width:172px;','id' => 'reStockRule','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Transient Assignment Rule");?>:</label>
			</td>
			<td><?php echo $this->Form->input('LocationType.transient_assignment_rule', array('empty'=>__('Please Select'),'options'=>Configure::read('transientAssignmentRule'),'style'=>'width:172px;','id' => 'transientAssignmentRule','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Product Assignment Rule");?>:</label>
			</td>
			<td><?php echo $this->Form->input('LocationType.product_assignment_rule', array('empty'=>__('Please Select'),'options'=>Configure::read('productAssignmentRule'),'style'=>'width:172px;','id' => 'productAssignmentRule','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Inventory Type");?>:</label>
			</td>
			<td><?php echo $this->Form->input('LocationType.inventory_type', array('empty'=>__('Please Select'),'options'=>Configure::read('inventoryType'),'style'=>'width:172px;','id' => 'inventoryType','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Consignment Type");?>:</label>
			</td>
			<td><?php echo $this->Form->input('LocationType.consignment_type', array('empty'=>__('Please Select'),'options'=>Configure::read('consignmentType'),'style'=>'width:172px;','id' => 'consignmentType','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Account");?>:</label>
			</td>
			<td><?php echo $this->Form->input('LocationType.account_id', array('empty'=>__('Please Select'),'options'=>$account,'style'=>'width:172px;','id' => 'account','label'=> false)); ?>
			</td>
		</tr>
		
		
		<tr>
			<td><label style="width: 99px;"><?php echo __('Description');?>: </label>
			</td>
			<td><?php echo $this->Form->textarea('LocationType.description', array('id' => 'description')); ?>
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
	<?php echo $this->Form->create('LocationSearch',array('url'=>array('controller'=>'Locations','action'=>'locationType'),'type'=>'Get','id'=>'locationTypefrmsearch', 'inputDefaults' => array('label' => false,'div' => false)));?>
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
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Locations','action'=>'locationType'),array('escape'=>false, 'title' => 'refresh'));?>
				</td>
			</tr>
		</tbody>
	</table>
	<?php echo $this->Form->end();?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('LocationType.name', __('Location Name', true)); ?>
			</strong>
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('LocationType.description', __('Description', true)); ?>
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
			<td class="row_format"><?php echo $locationAry['LocationType']['name']; ?>
			</td>
			<td class="row_format"><?php echo $locationAry['LocationType']['description']; ?>
			</td>
			<td><?php
			echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
		   			 					'alt'=> __('View', true))), array('controller'=>'Locations','action' => 'viewLocationType', $locationAry['LocationType']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			 					'alt'=> __('Edit', true))), array('controller'=>'Locations','action' => 'locationType', $locationAry['LocationType']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('controller'=>'Locations','action' => 'deleteLocationType', $locationAry['LocationType']['id']), array('escape' => false ),"Are you sure you wish to delete this location?");
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
	
 	jQuery("#locationTypefrm").validationEngine();						 
				 

	$("#add-note").click(function(){
		$( "#locationTypefrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) {
			$(this).val('');
		});
		$("#note-add-form").show('slow') ;
	});

	$("#note-cancel").click(function(){
		$( "#locationTypefrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) { //reset current form
			$(this).val('');
		});
		$("#note-add-form").hide('slow') ;
	});
});
</script>
