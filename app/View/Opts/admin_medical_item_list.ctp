<style>
.row_action img{
float:inherit;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Medical Items', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Medical Item Allocation'), array(  'action' => 'admin_medical_requisition_list' ,"admin"=>true), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Add Medical Item'), array('action' => 'medical_item_add',"admin"=>true), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'),array('controller'=>'users','action' => 'menu',"admin"=>true,"?type=master"), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">

	<tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('OtItemCategory.name', __('Medical Item Category', true)); ?>
		</strong></td>
		<td class="table_cell"align="left"><strong><?php echo $this->Paginator->sort('PharmacyItem.name', __('Medical Item', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('MedicalItem.description', __('Description', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('MedicalItem.in_stock', __('In Stock', true)); ?>
		</strong></td>
		<td class="table_cell" align="left" ><strong><?php echo __('Action', true); ?>
		</strong></td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $medical_item):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format" align="left"><?php echo $medical_item['OtItemCategory']['name']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $medical_item['PharmacyItem']['name']; ?>
		</td>
		<td class="row_format" align="left"><?php
		if(strlen($medical_item['MedicalItem']['description']) > 50) {
           	echo substr($medical_item['MedicalItem']['description'], 0, 50);
           } else {
           	echo $medical_item['MedicalItem']['description'];
           }
           ?>
		</td>
		<td class="row_format" align="left"><?php echo $medical_item['MedicalItem']['in_stock']; ?>
		</td>
		<td class="row_action" align="left"><?php 
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Medical Item', true),'title' => __('View Medical Item', true))), array('action' => 'medical_item_view',  $medical_item['MedicalItem']['id'],"admin"=>true), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Medical Item', true),'title' => __('Edit Medical Item', true))),array('action' => 'medical_item_edit', $medical_item['MedicalItem']['id'],"admin"=>true), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Medical Item', true),'title' => __('Delete Medical Item', true))), array('action' => 'medical_item_delete', $medical_item['MedicalItem']['id'],"admin"=>true), array('escape' => false),__('Are you sure?', true));
		?>
		</td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="5" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
		</span>
		</TD>
	</tr>
	<?php
         } else {
  ?>
	<tr>
		<TD colspan="5" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>
</table>

