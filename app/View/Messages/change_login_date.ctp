<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>
<?php 
echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3.js'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>
</head>
<body>
<?php if(isset($message) && !empty($message)){?>
<div class="message" id="message" align="center"><?php echo $message;?></div>
<?php }else{?>

<?php echo $this->Form->create('Person',array('type' => 'file','id'=>'Person','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
			?>
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Change Login Date") ; ?></th>
	</tr>
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Login Date");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('first_login_date', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'first_login_date')); ?>
		</td>
	</tr>
	</table>
<?php 
echo $this->Form->hidden('patient_id',array('value'=>$patient_id,'id' => 'patient_id'));
	

?>
		<input class="blueBtn" type=submit value="Change" name="Change" id="Change" >
		<input class="blueBtn" type=submit value="Cancel" name="Cancel" id="Cancel" onclick="closeFancyBox()" >
		
<?php echo $this->Form->end();?>
<?php }?>
<script>
//jQuery(document).ready(function() {alert($("namespace_id").val());

function closeFancyBox(){
	parent.$.fancybox.close();
}
	
		
$(function() { 
			$( "#first_login_date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			});
		
		});



//});
</script>
</body>