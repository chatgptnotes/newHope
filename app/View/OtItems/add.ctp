<div class="inner_title">
	<h3>
		<?php echo __('Add OR Item', true); ?>
	</h3>
</div>


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
<form name="optitemfrm" id="optitemfrm"
	action="<?php echo $this->Html->url(array("action" => "add")); ?>"
	method="post">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="60%" align="center">
		<tr>
			<td class="form_lables"><?php echo __('OR Item Category',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('OtItem.ot_item_category_id', array('class' => 'validate[required,custom[mandatory-select]]','id' => 'optname', 'label'=> false, 'div' => false, 'error' => false, 'options' => $otitemcategories, 'empty' => 'Select Category'));
			?>
			</td>
		</tr>

		<tr>
			<td class="form_lables"><?php echo __('OR Item Name',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('OtItem.name', array('class' => 'validate[required,custom[name]]','id' => 'pharmacy_item', 'label'=> false, 'div' => false, 'error' => false));
			?><?php echo $this->Form->hidden('OtItem.pharmacy_item_id',array('id'=>'pharmacy_item_id'));?>
			<input type="hidden" name="data[OtItem][DrugInfo]" id="DrugInfo" value="OR_IMPLANT" /> <!-- Default value for OR_Item -->
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('OR Item Company Name',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('OtItem.manufacturer', array('class' => 'validate[required,custom[name]]','id' => 'manufacturer', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Description',true); ?> <font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->textarea('OtItem.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'optdescription', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><?php echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn')); ?>
				<input type="submit" value="Submit" class="blueBtn">
			</td>
		</tr>
	</table>
</form>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#optitemfrm").validationEngine();
	
	
	$( "#pharmacy_item" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","PharmacyItem","id&name&item_code&manufacturer",'null','null','null',"admin" => false,"plugin"=>false)); ?>",
		minLength: 1,
		select: function( event, ui ) {
			$("#pharmacy_item_id").val(ui.item.id);
			$("#manufacturer").val(ui.item.manufacturer);
		},
		messages: {
		  noResults: '',
		  results: function() {}
		}
	});
	});
</script>
