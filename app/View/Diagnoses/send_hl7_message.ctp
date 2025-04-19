<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>
<?php 
echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>
</head>
<body>
<?php echo $this->Form->create('ambulatoryResult',array('type' => 'file','id'=>'ambulatoryResult','inputDefaults' => array(
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
		<th colspan="5"><?php echo __("Send Lab Result") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Namespace ID");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('namespace_id', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'namespace_id')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Universal ID");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('universal_id', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'universal_id')); ?>
		</td>
	</tr>
	
	
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Universal ID Type");?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('universal_id_type', array('type'=>'text','label'=>false,'style'=>'width:250px','id' => 'universal_id_type')); ?>
		</td>
	</tr>
	
</table>
<?php echo $this->Form->hidden('patientUid',array('value'=>$patientUid,'id' => 'patientUid'));
		echo $this->Form->hidden('messageId',array('value'=>$itemId,'id' => 'messageId'));

?>
		<input class="blueBtn" type=submit value="Send" name="Send" id="send" >
<?php echo $this->Form->end();?>
</body>

<script>
//jQuery(document).ready(function() {alert($("namespace_id").val());

	$('#send').click(function() {
		parent.$("#successMessage").show();
		parent.$("#successMessage").html("Message sent successfully to "+$("#namespace_id").val());
		parent.$.fancybox.close();
		

	});


//});
</script>