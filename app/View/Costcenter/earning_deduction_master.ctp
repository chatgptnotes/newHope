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
	<?php if($action=='edit') $display  = '' ;
	else $display = 'none';?>
	<div id="note-add-form" style="display:<?php echo $display; ?>;">
	<?php  echo $this->Form->create('EarningDeduction',array('url'=>array('controller'=>'Costcenter','action'=>'earningDeductionMaster'),'id'=>'EarningDeductionfrm',
			 'inputDefaults' => array('label' => false,'div' => false)));
	echo $this->Form->hidden('EarningDeduction.id',array('id'=>'note-id'));
	
	?>

	<table width="420" cellpadding="0" cellspacing="3" border="0" align="center">
		<tr>
			<td width="120" class="tdLabel2" align="right"><?php echo __("Name");?>:
			</td>
			<td><?php echo $this->Form->input('EarningDeduction.name', array('type'=>'text','id' => 'name','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td width="120" class="tdLabel2" align="right"><?php echo __("Service Category");?>:<font color="red">*</font> 
			</td>
			<td><?php echo $this->Form->input('EarningDeduction.category', array('empty'=>__('Please Select'),'options'=>Configure::read('EarningDeductionCategory'),
					'style'=>'width:140px;','class' => 'validate[required,custom[mandatory-select]]','id' => 'category','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td width="120" class="tdLabel2" align="right"><?php echo __('Service Type');?>:<font
					color="red">*</font> 
			</td>
			<td><?php echo $this->Form->input('EarningDeduction.type', array('empty'=>__('Please Select'),'options'=>Configure::read('EarningDeductionType'),
					'style'=>'width:140px;','class' => 'validate[required,custom[mandatory-enter]]','id' => 'type')); ?>
			</td>
		</tr>
		
		<tr>
			<td width="120" class="tdLabel2" align="right"><?php echo __("Payment Type");?>:
			</td>
			<td><?php echo $this->Form->input('EarningDeduction.payment_type', array('empty'=>__('Please Select'),'options'=>Configure::read('EarningDeductionPaymentType'),
					'style'=>'width:140px;','id' => 'paymentType','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td width="120" class="tdLabel2" align="right"><?php echo __("Ward Service");?>:
			</td>
			<td><?php echo $this->Form->input('EarningDeduction.is_ward_service', array('type'=>'checkbox','id' => 'isWardService','label'=> false)); ?>
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
	</div>
	<div>&nbsp;</div>
	<?php echo $this->Form->create('EarningDeductionSearch',array('url'=>array('controller'=>'Costcenter','action'=>'earningDeductionMaster'),'type'=>'Get','id'=>'Costcenterfrmsearch', 'inputDefaults' => array('label' => false,'div' => false)));?>
	<table border="0" cellpadding="0" cellspacing="0" width="500px;"
		style="padding-left: 19px; padding-right: 20px;">
		<tbody>
			<tr class="row_title">
				<td width="30%" class=""
					style="border: none !important; font-size: 13px;"><?php echo __('Name :') ?>
				</td>
				<td width="30%" style="border: none !important;"><?php  echo $this->Form->input('name', array('type'=>'text','id' => 'name_search', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));?>
				</td>
				<td width="40%" style="border: none !important;"><?php echo $this->Form->submit(__('Search'),array('label'=> false,'div' => false, 'error' => false,'class'=>'blueBtn','title'=>'Search','style'=>'margin-left:10px;'));	?>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Costcenter','action'=>'earningDeductionMaster'),array('escape'=>false, 'title' => 'refresh'));?>
				</td>
			</tr>
		</tbody>
	</table>
	<?php echo $this->Form->end();?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('EarningDeduction.name', __('Name', true)); ?>
			</strong>
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('EarningDeduction.category', __('Service Category', true)); ?>
			</strong>
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('EarningDeduction.type', __('Service Type', true)); ?>
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
			<td class="row_format"><?php echo $locationAry['EarningDeduction']['name']; ?>
			</td>
			<td class="row_format"><?php echo $locationAry['EarningDeduction']['category']; ?>
			</td>
			<td class="row_format"><?php echo $locationAry['EarningDeduction']['type']; ?>
			</td>
			<td><?php
			//echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
		   	//		 					'alt'=> __('View', true))), array('controller'=>'Costcenter','action' => 'earningDeductionMaster', $locationAry['EarningDeduction']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			 					'alt'=> __('Edit', true))), array('controller'=>'Costcenter','action' => 'earningDeductionMaster', $locationAry['EarningDeduction']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('controller'=>'Costcenter','action' => 'deleteEarningDeduction', $locationAry['EarningDeduction']['id']), array('escape' => false ),"Are you sure you wish to delete this service ?");
			?>
		
		</tr>
		<?php endforeach;  ?>
		<tr>
			<TD colspan="8" align="center" class="table_format"><?php 
			$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			echo $this->Paginator->counter(array('class' => 'paginator_links'));
			echo $this->Paginator->prev(__('« Previous', true), array(
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

				<?php 
				echo $this->Paginator->numbers(); ?> <?php echo $this->Paginator->next(__('Next »', true), array(
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
<script>
jQuery(document).ready(function(){
	
 	jQuery("#EarningDeductionfrm").validationEngine();						 
				 

	$("#add-note").click(function(){
		$( "#EarningDeductionfrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) {
			$(this).val('');
		});
		$("#note-add-form").show('slow') ;
	});

	$("#note-cancel").click(function(){
		$( "#EarningDeductionfrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) { //reset current form
			$(this).val('');
		});
		$("#note-add-form").hide('slow') ;
	});
});
</script>
