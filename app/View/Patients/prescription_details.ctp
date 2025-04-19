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
<?php echo $this->Form->create('NewCropPrescription',array('type' => 'file','id'=>'NewCropPrescription','inputDefaults' => array(
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
		<th colspan="5"><?php echo __("Prescription Details") ; ?></th>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Date of Prescription");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('date_of_prescription_1', array('type'=>'text','label'=>false,'style'=>'width:150px','id' => 'date_of_prescription_1','value'=>$this->DateFormat->formatDate2Local($this->request->data['NewCropPrescription']['date_of_prescription_1'],Configure::read('date_format_us'),true))); ?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Stage1/Stage2");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace">
		<?php echo $this->Form->input('stage1_stage2', array('onchange'=>'toggel()','style'=>'width:150px; float:left;','options'=>array("Stage 1"=>"Stage 1","Stage 2"=>"Stage 2"),'id'=>'stage1_stage2'));?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("No of prescription(Not Controlled)");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('no_of_prescription_not_controlled', array('type'=>'text','label'=>false,'style'=>'width:150px','id' => 'no_of_prescription_not_controlled','value'=>$prescriptionCount)); ?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("No of transmitted prescription(Not Controlled)");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('no_of_transmitted_prescription_not_controlled', array('type'=>'text','label'=>false,'style'=>'width:150px','id' => 'no_of_transmitted_prescription_not_controlled')); ?>
		</td>
	</tr>
	<tr id="controlled" style="display:none">
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("No of prescription( Controlled)");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('no_of_prescription_controlled', array('type'=>'text','label'=>false,'style'=>'width:150px','id' => 'no_of_prescription_controlled')); ?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("No of transmitted prescription( Controlled)");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('no_of_transmitted_prescription_controlled', array('type'=>'text','label'=>false,'style'=>'width:150px','id' => 'no_of_transmitted_prescription_controlled')); ?>
		</td>
	</tr>
	<tr id="controlled1" style="display:none">
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Prescription queried for drug formulary");?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php 
		echo $this->Form->input('prescription_queried_for_drug_formulary', array('style'=>'width:150px; float:left;','empty'=>__('Please select'),'options'=>array("Yes"=>"Yes","No"=>"No"),'id'=>'prescription_queried_for_drug_formulary'));
		//echo $this->Form->input('prescription_queried_for_drug_formulary', array('options'=>array("Yes"=>"Yes","No"=>"No"),'type'=>'text','label'=>false,'style'=>'width:250px','id' => 'prescription_queried_for_drug_formulary')); ?>
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace">&nbsp;
		</td>
		
		<td width="19%" valign="middle" class="tdLabel" id="boxspace">&nbsp;
		</td>
	</tr>
	
	
	
	
</table>
<?php 
echo $this->Form->hidden('patient_id',array('value'=>$patient_id,'id' => 'patient_id'));
	

?>
<input class="blueBtn" type=submit value="Send" name="Send" id="send" >
<input class="blueBtn" type=button value="cancel" name="cancel" id="cancel" onclick="closeFancyBox()">
<?php echo $this->Form->end();?>
<?php }?>
<script>
$(function() { 
	$( "#date_of_prescription_1" ).datepicker({
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

/*$('#"cancel"').click(function() {alert('hello');
	parent.$.fancybox.close();
	
});*/

function closeFancyBox(){
	parent.$.fancybox.close();
}

function toggel(){
	var selected = $("#stage1_stage2").val();
	if(selected == 'Stage 1'){
		$("#controlled").hide();
		$("#controlled1").hide();
	}else{
		$("#controlled").show();
		$("#controlled1").show();
	}

	//alert($("#stage1_stage2").val());
}

</script>


</body>

</html>