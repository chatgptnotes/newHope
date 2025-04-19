<div class="inner_title">
	<h3>
		<?php echo __('Contracts', true); ?>
	</h3>
	<span>
		<?php 
			echo $this->Html->link(__('Add Contract'),array('controller'=>'Contracts','action'=>'add_contract'), array('escape' => false,'class'=>'blueBtn'));
			echo "&nbsp;";
			echo $this->Html->link(__('Back'),array('controller'=>'Pharmacy','action'=>'department_store'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>

<div class="clr ht5"></div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align: center;">

	<tr class="row_title">
		<td class="table_cell"><strong><?php echo  __('Sr.no') ;  ?>
		</td>
		<td class="table_cell"><strong><?php echo  __('Contract Name') ;  ?>
		</td>
		
		<td class="table_cell"><strong><?php echo  __('Contract with');?>
		</td>
		
		<td class="table_cell"><strong><?php echo  __('Supplier');?>
		</td>
 
		<td class="table_cell"><strong><?php echo  __('Duaration', true); ?>
		</td>		
		
		<td class="table_cell"><strong><?php echo  __('PO Amount Range (Min - Max)', true); ?>
		</td>
		
		<td class="table_cell"><strong><?php echo  __('Action', true); ?>
		</td>
	</tr>
	<?php 
	// qdebug($contracts);
	//$srno=$this->params->paging['Product']['limit']*($this->params->paging['Product']['page']-1);
	$count = 0;
	foreach($contracts as $contract)
	{	$srno++;
		$count++;  ?>
	<tr <?php if($count%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format">
				<?php echo $srno;?>
		</td>
		<td class="row_format">
			<?php echo $contract['Contract']['name'];?>
		</td>
		
		<td class="row_format">
			<?php //echo $contract['Contract']['with'];?>
			<?php $cont_type = array(
								'1'=>'Enterprise (' .$this->Session->read("facility") .')',
								'2'=>'Company (' .$contract['Company']['name'] .')',
								'3'=>'Facility (' .$contract['Location']['name'] .')'
							);
			 if(array_key_exists($contract['Contract']['contract_type'], $cont_type))
			 {
				echo $cont_type[$contract['Contract']['contract_type']]; 
			 }
			?>
		</td>
		
		<td class="row_format">
			<?php echo $contract['InventorySupplier']['name'];?>
		</td>
		
		<td class="row_format">
		<?php echo $this->DateFormat->formatDate2Local($contract['Contract']['start_date'],Configure::read('date_format')). " to " .$this->DateFormat->formatDate2Local($contract['Contract']['end_date'],Configure::read('date_format'));?>
		</td>
		
		<td class="row_format">
			<?php echo $this->Number->currency($contract['Contract']['min_po_amount']). " to " .$this->Number->currency($contract['Contract']['max_po_amount']);?>
		</td>
		
		<td class="row_action" style="text-align:center;"><?php
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Item', true),'title' => __('View Item', true))),array('action'=>'view_contract_products',$contract['Contract']['id']), array('escape' => false));
		?> <?php 
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Item', true),'title' => __('Edit Item', true))),array('action'=>'index',$contract['Contract']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Item', true),'title' => __('Delete Item', true))),array('action'=>'index',$contract['Contract']['id']), array('escape' => false),__('Are you sure?', true));

		?>
		</td>
	</tr>
	<?php }?>
	
</table>

<table width="100%">
	<tr>
		<td colspan="4" align="center">
			<?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     		<?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
    		<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
     		<span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
		</td>
	</tr>
</table>
