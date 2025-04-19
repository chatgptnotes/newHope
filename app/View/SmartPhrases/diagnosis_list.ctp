<?php
/*echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css'));*/
?>
<style>.row_action img{float:inherit;}</style>

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
		<?php echo __('Diagnosis List', true); ?>
	</h3>
	<span> <?php 
	echo $this->Html->link(__('Add Diagnosis'), array('action' => 'add_diagnosis'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'menu', '?' => array('type'=>'master'),'admin'=>true), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px'));
	?>

	</span>

</div>
<?php echo $this->Form->create('',array('action'=>'diagnosis_list'));?>
	<table border="0" class="table_format" cellpadding="3" cellspacing="0"
		width="100%" align="center">
		<tr class="row_title">
			<td class=" " align="left" width="12%"><?php echo __('Name') ?>
				:</td>
			<td class=" "><?php 
			echo $this->Form->input('icd9name', array( 'id' => 'icd9name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
			echo $this->Form->hidden('hiddenId',array('id'=>'snomedMpping_id'));
			?>
			</td>			
			<td><?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?></td>
			<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'diagnosis_list'),array('escape'=>false, 'title' => 'refresh'));?></td>
		</tr>	  
	</table>
	<?php echo $this->Form->end();?>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
<!-- 	<tr> -->
<!-- 		<td colspan="8" align="right"></td> -->
<!-- 	</tr> -->
 	    <tr class="row_title"> 
     	<td class="table_cell" align="left"><strong><?php echo __('Diagnosis Name', true); ?></strong>
		
		</td>
		<td class="table_cell" align="left"><strong><?php echo __('Is Active', true); ?></strong>
		
		</td>
		<td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong>
		
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $key=>$diagnosis):
       $cnt++;
 ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

		<td class="row_format" align="left"><?php echo $diagnosis['SnomedMappingMaster']['icd9name']; ?>
		</td>
		
		<td class="row_format" align="left"><?php 
		if($diagnosis['SnomedMappingMaster']['active']=='1'){
			echo "Yes"; 
		}elseif($diagnosis['SnomedMappingMaster']['active']=='0'){
			echo "No";
		}?>
		</td>
		
		<td class="row_action" align="left"><?php 
		//echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Insurance Type', true),'title' => __('View Item', true))), array('action' => 'view_supplier',  $supplier['InventorySupplier']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Diagnosis', true),'title' => __('Edit Diagnosis', true))),array('action' => 'edit_diagnosis',$diagnosis['SnomedMappingMaster']['id']), array('escape' => false));
		 	echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_diagnosis', $diagnosis['SnomedMappingMaster']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
		?></td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="10" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
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
	/* $('#icd9name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","SnomedMappingMaster","id&icd9name",'null',"null",'no','null','null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {		
			 $('#snomedMpping_id').val(ui.item.id); 
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	}); */ 
		
	$(document).ready(function(){
	$('#icd9name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","SnomedMappingMaster","icd9name",'null',"no",'no','is_deleted=0',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#snomedMpping_id').val(ui.item.id); 
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
	});	
	
</script>
