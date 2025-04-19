<style>
	.ho:hover{
		cursor: pointer;
		background-color:#C1BA7C;
		}
</style>

<div class="inner_title">
	<h3> &nbsp; <?php echo __('Generic Search', true); ?></h3>
</div>

<?php echo $this->Form->create();?>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
	<tbody>
		<tr class="row_title">				 
			<td align="right"><lable><?php echo __("Search Generic:"); ?></lable></td>										
			<td><?php echo $this->Form->input('generic_name', array('id' => 'generic_name','type'=>'text', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd')); ?> </td>
			<td></td>
			<td align="right" colspan="2"> <?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	 ?>
			<td> <?php //echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action' => 'search','InventorySupplier'), array('escape' => false)); ?> </td>
		 </tr>	
	</tbody>	
</table>	
<?php echo $this->Form->end(); ?>

<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
	
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo  __('Product Name', true) ; ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Product Code', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Pack', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Stock (MSU)', true); ?></strong></td>
	</tr>
	
	<?php if(count($PharmacyData) > 0){ $count = 0; ?>
	<?php foreach($PharmacyData as $data) { $count++; ?>
	<?php if($count%2==0){
			$class = "ho"; 
		} else {
			$class = "row_gray ho"; 
		} ?>
	<tr class="<?php echo $class; ?>" onclick="return getProduct(<?php echo $data['OtPharmacyItem']['id']; ?>)">
		<td class="table_cell">
			<?php echo $data['OtPharmacyItem']['name'] ; ?>
		</td>
		<td class="table_cell">
			<?php echo $data['OtPharmacyItem']['item_code']; ?>
		</td>
		<td class="table_cell">
			<?php echo $pack = $data['OtPharmacyItem']['pack'] ?>
		</td>
		<td class="table_cell">
			<?php echo ((int)$pack * $data['OtPharmacyItem']['stock'])+ $data['OtPharmacyItem']['loose_stock'];?>
		</td>
	</tr>
	<?php } //end of foreach?>
	<?php }else { ?>
	<tr>
		<td colspan="10" align="center"><?php echo __('No record found', true); ?>.</td>
	</tr>
	<?php } ?>
</table>

 <script>
 	$(document).ready(function(){
 		$("#generic_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "OtPharmacy", "action" => "generic_item",'name',"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				console.log(ui.item);
			 },
			 messages: {
		        noResults: '',
		        results: function() {}
			 }		
		});
 	});

 	function getProduct(id){
 	 	var fieldNo = '<?php echo $field_number; ?>';
		 parent.setInformation(id,fieldNo);		//productId
         parent.$.fancybox.close();
	}
 </script>

