<?php 
//echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));

?>

<!-- Right Part Template -->
<?php echo $this->Form->create(null,array('url'=> array('action'=>'sendCcda'),'id'=>'transmit','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
?>

<?php

if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		     		?>
		</td>
	</tr>
</table>
<?php } ?>
<div><?php echo $this->Session->flash(); ?></div>
<div class="inner_title">
<h3 style="float:left;">Transmit Ccda</h3>

<p class="clr"></p>
</div>
<p class="ht5"></p>

<!-- two column table start here -->

		<table width="550" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="35" valign="middle" class="tdLabel1" id="boxSpace2">To <font color="red">*</font>:</td>
				<td align="left" valign="middle">
				<?php echo $this->Form->input('xml_note_id',array('type'=>'hidden','legend'=>false,'label'=>false,'id' => 'xml_note_id','value'=>$xml_note_id,'readonly'=>'readonly')); ?>
				<?php echo $this->Form->input('patient_id',array('type'=>'hidden','legend'=>false,'label'=>false,'id' => 'patient_id','value'=>$id,'readonly'=>'readonly')); ?>
				<?php echo $this->Form->input('to', array('class' => 'validate[required,custom[onlyLetterSp]] textBoxExpnd','type'=>'text','id' => 'to','style'=>'width:50%')); ?></td>
			</tr>
			<tr>
				<td height="35" valign="middle" class="tdLabel1">Subject <font color="red">*</font>:</td>
				<td align="left" valign="middle"><?php echo $this->Form->input('subject',array('class' => 'validate[required,custom[onlyLetterSp]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'subject','style'=>'width:75%')); ?></td>
			</tr>
			<tr>
				<td height="35" valign="middle" class="tdLabel1" id="boxSpace2">File Name:</td>
				<td align="left" valign="middle">
				<?php echo $xml;?>
				<?php echo $this->Form->input('file_name',array('type'=>'hidden','legend'=>false,'label'=>false,'id' => 'file_name','value'=>$xml,'readonly'=>'readonly')); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo $this->Form->submit(__('Send'), array('class'=>'blueBtn','div'=>false)); ?></td>
			</tr>
		</table>
		   
          
<?php echo $this->Form->end(); ?>

