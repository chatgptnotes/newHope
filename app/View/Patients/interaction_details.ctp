
<?php echo $this->Form->create('',array('type' => 'file','id'=>'saveOrderMedication','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" align="center">
	<tbody>
		<tr class="">
			<td class="table_cell" width="20%" align="center" colspan=3><div id='showInteractionResult' style='display:none'><font color='#00FF40'> Overridden Successfully.</font></div>
			</td>
		</tr>
		<tr class="row_title">
			<td class="table_cell" width="20%" align="left"><?php echo __('Drug/Drug Interaction');?>
			</td>
			<td class="table_cell" align="left" width="20%" colspan=2><?php echo __('Drug Pair');?>
			</td>
		</tr>
		<?php foreach($getConditonalData as $getConditonalRow){?>
		<tr class="">
			<?php 
			$expSeverity=explode(':',$getConditonalRow->SeverityLevel);
			$getColor=$expSeverity[1];
			if (strpos($getColor, Severe) !== false){
     				 $color='red';
				}
				//Moderate
				else if(strpos($getColor, Moderate) !== false){
					$color='orange';
			}
			else{
					$color='yellow';
			}
			//debug($color);
			?>
			<td class="table_cell" width="60%" align="left"><font
				color="<?php echo $color;?>"><?php echo __($getConditonalRow->SeverityLevel); ?>
			</font>
			</td>
			<td class="table_cell" align="left" width="30%"><?php echo __($getConditonalRow->Drug1." ".'with'." ".$getConditonalRow->Drug2);?>
			</td>
			<td class="table_cell" align="left" width="20%"><?php //echo $this->Html->link("More Info",array('onclick'=>'moreInfo()'));?>
				<?php //echo $this->Form->hidden('Discussion',array('value'=>$getConditonalRow->Discussion));?>
				<?php //echo $this->Form->hidden('ClinicalEffects',array('value'=>$getConditonalRow->ClinicalEffects));?>
				<?php //echo $this->Form->hidden('PatientManagement',array('value'=>$getConditonalRow->PatientManagement));?>
				<?php //echo $this->Form->hidden('PredisposingFactors',array('value'=>$getConditonalRow->PredisposingFactors));?>
				<?php //echo $this->Form->hidden('References',array('value'=>$getConditonalRow->References));?>
					
			</td>
		</tr>
		<?php }?>
		<tr class="">
			<td class="table_cell" width="20%" align="left"><div
					id='overrideInstruction' style='display: none'>
					Override Reason<font color=red>*</font>
					<?php echo $this->Form->input('NewCropPrescription.overrideInstruction',array('id'=>'interactive_notes','type'=>'textArea','label'=>false));
					 echo $this->Html->link('Go',"javascript:void('0')",array('class'=>'blueBtn','label'=>false,'id'=>'go'));?>
				</div>
			</td>
		</tr>
		<tr class="row_title">
			<td class="table_cell" width="20%" align="right" colspan=3><?php  echo $this->Form->input(__('Override'),array('type'=>'button','id'=>'override','class'=>'blueBtn','label'=>false)); ?>
			</td>

		</tr>
	</tbody>
</table>
<?php echo $this->Form->end();?>
<script>
$(document).ready(function(){
	$('#overrideInstruction').hide();
});
$('#override').click(function() { 
	var result=confirm('Are you sure you want to override it?');
	if(result==true){
	$('#overrideInstruction').show();
	return false;
	}
});
$('#go').click( function(){
	if($("#interactive_notes").val() != ''){
		//"data[NewCropPrescription][overrideInstruction] = " + $("#interactive_notes").val() + "&data[NewCropPrescription][patient_order_id] = "+ $("#patient_order_id").val() + $('#saveOrderMedication').serialize();
		var postData ="data[NewCropPrescription][overrideInstruction] = " + $("#interactive_notes").val() + "&data[NewCropPrescription][patient_order_id] = "+ $("#patient_order_id").val() + "&data[NewCropPrescription][chlId] = "+ "1";
	}else{
		var postData = $('#saveOrderMedication').serialize();
	}
var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "SaveOrderMedication","admin"=>false)); ?>";
		$.ajax({
			type : "POST",
			data: postData,
			url : ajaxUrl , 
			beforeSend : function() {
	       		$('#busy-indicator').show('fast');
	       		},
			success: function(data){
				 $('#busy-indicator').hide('fast');
				 $('#checkOverride').val('1');
				 $('#flagoverRide').val('1');
				 $('#showInteractionResult').show();
				$('#overrideInstruction').hide();
				},
			
			error: function(message){
			alert(message);
			}
			
		});
});
			</script>
