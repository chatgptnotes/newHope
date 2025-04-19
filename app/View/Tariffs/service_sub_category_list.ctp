<style>
.row_action img{
float:inherit;
}
</style>
<?php
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<?php 
if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } ?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Service Sub Group', true); ?>
	</h3>
	<span><?php  echo $this->Html->link(__('Add Service Sub Group'), array('action' =>'service_sub_category_add'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	?></</span> <span style="margin-top: -25px;"> </span>

</div>
<table border="0">
	<tr id="tariff-opt-area">
		<?php       echo $this->Form->create('',array('url'=>array('action'=>'service_sub_category_list'), 'id'=>'servicefrm','inputDefaults' => array(
				'label' => false,
				'div' => false,
				'error' => false
		)));
		?>
		<td class=""><?php echo __('Sub Group') ?> :</td>	
		<td align="left"><?php echo $this->Form->input('', array('name'=>'service_subgroup_name','type'=>'text','id' => 'service_subgroup_name','style'=>'width:150px;','autocomplete'=>'off')); ?>
		</td>
		<td class=""><?php echo __('Group') ?> :</td>
		<td align="justify"><?php echo $this->Form->input('',array('name'=>'service_group_name','type'=>'text','id'=>'service_group_name','style'=>'width:150px;','autocomplete'=>'off'));?>
		</td>
		<td align="left"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?>
		</td>
		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'service_sub_category_list'),array('escape'=>false, 'title' => 'refresh'));?>
		</td>
		<?php echo $this->Form->end();?>
	</tr>
</table>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<tr>
		<td colspan="8" align="right"><?php 
		echo $this->Html->link(__('Search Service Sub  Group'), array('action' => 'search','sub_group'), array('escape' => false,'class'=>'blueBtn'));
		?>
		</td>
	</tr>
	<tr class="row_title">

		<td class="table_cell"><strong><?php echo  $this->Paginator->sort('ServiceSubCategory.name', __('Sub Group Name')) ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?>
		
		</td>
		<td class="table_cell"><strong><?php echo  $this->Paginator->sort('ServiceCategory.alias', __('Group Name')) ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?>
		
		</td>
		<td class="table_cell"><strong><?php echo  $this->Paginator->sort('ServiceSubCategory.is_view', __('Status')) ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?>
		
		</td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?>
		
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $service_sub_group):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format"><?php echo ucwords(strtolower($service_sub_group['ServiceSubCategory']['name'])) ;?>
		</td>
		<td class="row_format"><?php echo ucwords(strtolower($service_sub_group['ServiceCategory']['alias']));?>
		</td>
		<td class="row_format"><?php
		if($service_sub_group['ServiceSubCategory']['is_view']=="0")
			echo "Inactive";
		else
			echo "Active";
		?>
		</td>
		<td class="row_action"><?php 
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Service Sub Group', true),'title' => __('Edit Service Sub Group', true))),array('action' => 'service_sub_category_edit', $service_sub_group['ServiceSubCategory']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Service Sub Group', true),'title' => __('Delete Service Sub Group', true))), array('action' => 'service_sub_category_delete', $service_sub_group['ServiceSubCategory']['id']), array('escape' => false),__('Are you sure?', true));
			
		?></td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="10" align="center">
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
		<TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>
</table>
<script>
	$(function() {
		$("#service_subgroup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","ServiceSubCategory","name",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
	});
	$(function() {
		$("#service_group_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","ServiceCategory","alias",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
	});
</script>

