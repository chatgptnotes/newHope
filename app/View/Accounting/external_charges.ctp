<style>
.textBoxExpnd {
    width: 48%;
}
</style>
<div class="inner_title">
	<h3><?php echo __('External Charges', true); ?></h3>
</div>

<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Service',array('id'=>'serviceDetails','url'=>array('controller'=>'Accounting','action'=>'external_charges','admin'=>false)));?>
<table border="0" class="formFull" cellpadding="0" cellspacing="0" width="60%" align="center">
	<tr>
		<th colspan="2"><?php echo __("Add External Charges") ; ?></th>
	</tr>
	<td colspan="2" align="center"><br></td>
	 
	<tr>
		<td class="tdLabel" width="50%"><?php echo __('Service Group :'); ?><font style="color:Red">*</font></td>
		<td><?php echo $this->Form->input('Service.name',array('id'=>'name','label'=>false,'div'=>false,'type'=>'text','autocomplete'=>'off',
				'class' => 'validate[required,custom[mandatory-enter]]'));
				echo $this->Form->hidden('Service.id',array('id'=>'id'));?>
		</td>
	</tr>
	
	<tr>
		<td class="tdLabel" width="50%"><?php echo __('External Charges (%) :'); ?><font style="color:Red">*</font></td>
		<td><?php echo $this->Form->input('Service.external_charges',array('class' => 'validate[required,custom[onlyNumber]] textBoxExpnd',
				'id' => 'externalCharges','label'=> false, 'div' => false,'autocomplete'=>'off')); ?>
		</td>
	</tr>
	
	<tr>
		<td class="tdLabel" width="50%"><?php echo __('Hospital Charges (%) :'); ?><font style="color:Red">*</font></td>
		<td><?php echo $this->Form->input('Service.hospital_charges',array('class' => 'validate[required,custom[onlyNumber]] textBoxExpnd',
				'id' => 'hospitalCharges','label'=> false, 'div' => false,'autocomplete'=>'off')); ?>
		</td>
	</tr>
	
	<tr>
		<td class="tdLabel" width="50%"><?php echo __('From:'); ?><font style="color:Red">*</font></td>
		<td><?php echo $this->Form->input('Service.from', array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','style'=>'width:120px',
				'id'=>'from','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From','autocomplete'=>'off'));?>
		</td>
	</tr>

	<tr>
		<td></td>
		<td align="left">
			<?php echo $this->Form->submit(__('Save'), array('class'=>'blueBtn','div'=>false,'id'=>'submit')); ?>
			<?php $cancelBtnUrl =  array('controller'=>'accounting','action'=>'index');?>
     		<?php echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false)); ?>
     	</td>
	</tr>
	
</table>
<?php if(!empty($data)){?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="padding-top:10px">
	<tr>
	<td width="100%" valign="top" align="center">
		<div id="container">
			<table width="60%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
				<thead>
					<tr> 
						<th width="26%" align="center" valign="top"><?php echo __("Service Group");?></th> 
						<th width="17%" align="center" valign="top" style="text-align: center;"><?php echo __("External Charges (%)");?></th> 
						<th width="17%" align="center" valign="top" style="text-align: center;"><?php echo __("Hospital Charges (%)");?></th> 
						<th width="20%" align="center" valign="top" style="text-align: center;"><?php echo __("From");?></th>
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach($data as $key=> $serviceData) { 
					$dataDetails = unserialize($serviceData['Configuration']['value']);
						foreach($dataDetails as $key=> $serviceData){?>
						<tr>
							<td align="left" valign="top" style= "text-align: left;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $serviceData['name']; ?>
								</div>
							</td>
						
							<td class="tdLabel"  style= "text-align: center;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $serviceData['external_charges']; ?>
								</div>
							</td>
							<td class="tdLabel"  style= "text-align: center;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $serviceData['hospital_charges']; ?>
								</div>
							</td>
							<td class="tdLabel"  style= "text-align: center;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $serviceData['from']; ?>
								</div>
							</td>
					  	</tr>
					  	<?php }?>
			  	<?php }?>
			  	<?php ?>
			  	<?php foreach($consultantDetails as $key=> $consultantDetails) {
					$consultantData = unserialize($consultantDetails['User']['doctor_commision']); ?>
						<tr>
							<td align="left" valign="top" style= "text-align: left;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $consultantData['name']; ?>
								</div>
							</td>
						
							<td class="tdLabel"  style= "text-align: center;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $consultantData['external_charges']; ?>
								</div>
							</td>
							<td class="tdLabel"  style= "text-align: center;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $consultantData['hospital_charges']; ?>
								</div>
							</td>
							<td class="tdLabel"  style= "text-align: center;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $consultantData['from']; ?>
								</div>
							</td>
					  	</tr>
			  	<?php }?>
						<?php foreach($externalDetails as $key=> $externalDetails) {
					$externalData = unserialize($externalDetails['Consultant']['doctor_commision']); ?>
						<tr>
							<td align="left" valign="top" style= "text-align: left;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $externalData['name']; ?>
								</div>
							</td>
						
							<td class="tdLabel"  style= "text-align: center;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $externalData['external_charges']; ?>
								</div>
							</td>
							<td class="tdLabel"  style= "text-align: center;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $externalData['hospital_charges']; ?>
								</div>
							</td>
							<td class="tdLabel"  style= "text-align: center;">
								<div style="padding-left:0px;padding-bottom:3px;">
									<?php echo $externalData['from']; ?>
								</div>
							</td>
					  	</tr>
			  	<?php }?>
				</tbody>
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>
<?php } ?>
<?php echo $this->Form->end()?>
<script>$(document).ready(function(){

	$("#externalCharges").keyup(function(){
		if($(this).val() > 100){
			alert("Percentage should be less than or equal to 100");
			$(this).val("");
			}
		
		var display = 100 - this.value;
		$("#hospitalCharges").val(display);
		
	});

	$("#hospitalCharges").keyup(function(){
		if($(this).val() > 100){
			alert("Percentage should be less than or equal to 100");
			$(this).val("");
			}
		
		var display = 100 - this.value;
		$("#externalCharges").val(display);
	});
	
    
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		minDate: new Date(),
	//	maxDate: new Date(),
		//maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	
	//$("#to").datepicker({
		//showOn: "button",
		//buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		//buttonImageOnly: true,
		//changeMonth: true,
		//changeYear: true,
		//yearRange: '1950',
		//maxDate: new Date(),
		//yearRange: '-100:' + new Date().getFullYear(),
		//dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	//}); 

	 $( "#name" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","ServiceCategory",
		 		"name",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			$('#id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});
	 jQuery("#serviceDetails").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});	
});
		
</script>