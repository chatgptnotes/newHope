<div class="inner_title">
	<h3>
		<?php echo __('Edit Surgery', true); ?>
	</h3>
</div>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#surgeryfrm").validationEngine();
	});

</script>

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
<form name="surgeryfrm" id="surgeryfrm"
	action="<?php echo $this->Html->url(array("action" => "edit")); ?>"
	method="post" enctype="multipart/form-data" onSubmit="return Validate(this);">
	<?php
	echo $this->Form->input('Surgery.id', array('type' => 'hidden'));
	?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="60%" align="center">
		<tr>
			<td class="form_lables"><?php echo __('Name',true); ?><font
				color="red">*</font>
			</td>
			<td><?php
			echo $this->Form->input('Surgery.name', array('class' => 'validate[required,custom[name]]','id' => 'surgeryname', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Description',true); ?> <font
				color="red">*</font>
			</td>
			<td><?php
			echo $this->Form->textarea('Surgery.description', array('class' => 'validate[required,custom[customdescription]]', 'cols' => '35', 'rows' => '10', 'id' => 'customdescription', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Category',true); ?><font
				color="red">*</font>
			</td>
			<td><?php
			echo $this->Form->input('Surgery.surgery_category_id', array('style' => 'width:450px;','class' => 'validate[required,custom[mandatory-select]]', 'options' => $surgerycategory, 'empty' => 'Select Surgery Category', 'id' => 'surgery_category_id', 'label'=> false, 'div' => false, 'error' => false, 'onchange'=> $this->Js->request(array('action' => 'getSurgerySubcategory'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changesubcategory', 'data' => '{surgery_category:$("#surgery_category_id").val()}', 'dataExpression' => true))));
	   ?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Subcategory',true); ?>
			</td>
			<td id="changesubcategory"><?php
			echo $this->Form->input('Surgery.surgery_subcategory_id', array('id' => 'surgery_subcategory_id', 'empty' => 'Select Surgery Subcategory', 'options' => $surgerysubcategory, 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>

		<tr>
			<td class="form_lables"><?php echo __('Map Surgery',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('Surgery.tariff_list_id', array('type'=>'select','options'=>array('empty' => 'Select Service',$getService),'id' => 'tariff_list_id', 'label'=> false, 'div' => false, 'error' => false,'class' => 'validate[required,custom[mandatory-select]]'));
			?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Upload File',true); ?>
			</td>
			<td><?php
			echo $this->Form->input('', array('name'=>'surgery_info_file_name','style' => 'width:450px;', 'label'=> false, 'div' => false, 'error' => false,'type' => 'file'));
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
