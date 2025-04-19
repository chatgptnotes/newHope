<script type="text/javascript" src="/js/jquery-1.5.1.min"></script>
<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

<?php
echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
		'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','jquery.autocomplete'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); ?>


<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Edit Medication List', true); ?>
	</h3>
</div>
<?php echo $this->Form->create('editmedication',array('url'=>array('controller'=>'patients','action'=>'edit_rxhistory'),'type'=>'post','id'=>'frm1'));?>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
				foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
			</div></td>
	</tr>
</table>
<?php } ?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr><?php echo $this->Form->hidden('medication_name',array('value'=> $edit_data['0']['NewCropPrescription']['description']));?>
		<td colspan="2" align="left"> Medication Name</td>
		<td colspan="2" align="left"> <?php echo $edit_data['0']['NewCropPrescription']['description'];?></td>
	</tr>
	<tr>
	<td></td>
	</tr>
	<tr>
		<td colspan="2" align="left"> Enter the Date</td>
		<td colspan="2" align="left"> <?php echo $this->Form->input('dob', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[mandatory-enter-only]]','style'=>'width:136px','readonly'=>'readonly', 'size'=>'20','id' => 'dob'));?></td>
	</tr>
	<tr>
		<td colspan="2" align="left"><?php echo $msg;  ?> </td>
		<td colspan="2" align="left"> 	<?php  echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'makd'));?></td>
		
	</tr>
</table>
<script>
$("#dob")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange : '-73:+0',
		//	maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
		});
jQuery(document).ready(function() {

	$('#makd').click(function() {
		alert('Date Edited');
		parent.$.fancybox.close();

	});


});
</script>