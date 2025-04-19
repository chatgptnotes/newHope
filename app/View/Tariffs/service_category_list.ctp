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
		<?php echo __('Service Group', true); ?>
	</h3>

	<span> <?php  echo $this->Html->link(__('Add Service Group'), array('action' => 'service_category_add'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
	?>

	</span>

</div>

<table border="0">
	<tr id="tariff-opt-area">
		<?php       echo $this->Form->create('',array('url'=>array('action'=>'service_category_list'), 'id'=>'servicefrm','inputDefaults' => array(
				'label' => false,
				'div' => false,
				'error' => false
		)));
		?>
		<td align="left"><?php echo $this->Form->input('', array('name'=>'service_group_name','type'=>'text','id' => 'service_group_name','style'=>'width:150px;','autocomplete'=>'off')); ?>
		</td>
		<td align="left"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?>
		</td>
		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'service_category_list'),array('escape'=>false, 'title' => 'refresh'));?>
		</td>
		<?php echo $this->Form->end();?>
	</tr>
</table>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<tr class="row_title">

		<td class="table_cell" align="left"><strong><?php echo  $this->Paginator->sort('ServiceCategory.name', __('Group Name')) ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?>
		
		</td>
		<td class="table_cell" align="left"><strong><?php echo  $this->Paginator->sort('ServiceCategory.is_view', __('Status')) ; //echo $this->Paginator->sort('hasspecility', __('Item Name', true)); ?>
		
		</td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?>
		
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $service_group):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

		<td class="row_format" align="left"><?php echo ucwords(strtolower(($service_group['ServiceCategory']['alias'])?$service_group['ServiceCategory']['alias']:$service_group['ServiceCategory']['name'])); ?>
		</td>
		<td class="row_format" align="left"><?php
		if($service_group['ServiceCategory']['is_view']=="0")
			echo "Inactive";
		else
			echo "Active";
		?>
		</td>
		<td class="row_action"><?php 
		if($service_group['ServiceCategory']['location_id']!="0"){
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Service Group', true),'title' => __('Edit Service Group', true))),array('action' => 'service_category_edit', $service_group['ServiceCategory']['id']), array('escape' => false));

   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Service Group', true),'title' => __('Delete Service Group', true))), array('action' => 'service_category_delete', $service_group['ServiceCategory']['id']), array('escape' => false),__('Are you sure?', true));
   }
   ?>
		</td>
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
		$("#service_group_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","ServiceCategory","alias",'null','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250, selectFirst:true });
	});
</script>

