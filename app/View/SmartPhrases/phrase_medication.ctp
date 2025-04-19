<style>
.pending_payment td{
	 background: none repeat scroll 0 0 #ffcccc !important;
}

</style>
<table width="100%">

<?php if($this->Session->read('website.instance')=='vadodara' || $this->Session->read('website.instance')=='hope'){?>
<tr><td>Select Phrase</td>
<td colspan="13"><?php  echo $this->Form->input('phrase_id',array('type'=>'text','id'=>'phrase','label'=>false,'div'=>false,'value'=>$namePharse));
//echo $this->Form->input('phrase_id',array('id'=>'phrase','options'=>$phrase_array,'empty'=>'Selct Phrase','value'=>$namePharse,'label'=>false))?></td></tr>
<?php }?>
<tr>
	<td  height="20" align="left" valign="top" style="padding-right: 3px;" class="tdLabel">Drug Name<font color="red">*</font></td>
								<td  align="left" valign="top" class="tdLabel">Qty<font color="red">*</font></td>
 								<?php $instance = strtolower($this->Session->read('website.instance')); 
 								if($instance == "vadodara" || $instance == "hope"){
 							?>
	<td  align="left" valign="top" class="tdLabel"><?php echo __("Stock"); ?></td>
	<?php if($instance == "Hope"){?>
	<td  align="left" valign="top" class="tdLabel"><?php echo __("Sale Price"); ?></td>
	<?php }else{?>
	<td  align="left" valign="top" class="tdLabel"><?php echo __("MRP"); ?></td>
	<?php }?>
	<td  align="left" valign="top" class="tdLabel"><?php echo __("Amount"); ?></td>
 								<?php } ?>
	<td  height="20" align="center" valign="top" class="tdLabel" style="text-align: center;">Strength</td>
	<td  height="20" align="left" valign="top" class="tdLabel" style="">Dosage</td>
	<td  align="left" valign="top" class="tdLabel">Dose Form</td>
	<td  height="20" align="left" valign="top" class="tdLabel">Route</td>
	<td  align="left" valign="top" class="tdLabel">Frequency</td>
	<td  align="left" valign="top" class="tdLabel">Days</td>
	<!-- <td  align="center" valign="top" class="tdLabel">As Needed (p.r.n)</td>
	<td  align="center" valign="top" class="tdLabel">Dispense As Written</td> -->
	<td  align="left" valign="top" class="tdLabel" style="">First Dose Date/Time</td>
	<td  align="left" 	valign="top" class="tdLabel" style="">Stop Date/Time</td>
	<?php if($instance == "vadodara"){?>
	<td  align="left" 	valign="top" class="tdLabel" style="">#</td>
	<?php }?>
	<!-- <td  align="center" valign="top" class="tdLabel">Active</td> -->
	<?php if(!empty($getMedicationRecordsXml['NewCropPrescription'])){?>
	<td  align="center" valign="top" class="tdLabel" >Action</td>
	<?php }?>
								
</tr>
	
<?php 

	$count=count($returnArray['NewCropPrescription']);
	echo $this->Form->hidden("",array('class'=>'','name'=>'pharse_name','value'=>$namePharse));
	//debug($getArrayMedication['NewCropPrescription']);
	foreach($returnArray['NewCropPrescription'] as $k=>$setData ){
		if($setData['quantity']>$setData['drugStock']){
				echo "<tr id=DrugGroup$k class=pending_payment>";
				$alert=$this->Html->image('icons/exlpoint.jpeg',array('title'=>'Prescribe quantity is greater than stock quantity',"style"=>"padding: 2px 5px 0px 0px; float: left"));
				$setData['quantity']='';
				$setData['amount']=0;
				
		}else{
				echo "<tr id=DrugGroup$k>";
				$alert='';
		}
		
	?>
	
		<td valign="top" align="left" style="padding-right: 3px">		
		<?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText validate[required,custom[mandatory-enter]]' ,
				'id'=>"drugText_$k",'name'=> 'drugText[]','value'=>$setData['description'],
					'autocomplete'=>'off','counter'=>$k,'style'=>'width:200px!important;','div'=>false,'label'=>false)); 
		echo $this->Form->hidden("",array('class'=>'allHiddenId','id'=>"drug_$k",'name'=>'drug_id[]','value'=>$setData['drug_id']));
		?> <span id="drugType_<?php echo $k?>"></span>&nbsp;<span
			id="formularylinkId_<?php echo $k?>"></span>
		</td>
		<td  valign="top" align="left" style="padding-right: 3px">
		<?php echo $alert.$this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off','class' => "validate[required,custom[mandatory-enter]] quantity quantity_$k",
				'id'=>"quantity$k",'style'=>'margin: 0 0 0 10px;','name' => 'quantity[]','value'=>$setData['quantity'],
				'label'=>false,'style'=>'margin:0px;background:#fff!important;width:40px!important;','div'=>false)); ?>
		</td>
		<?php  $instance = strtolower($this->Session->read('website.instance')); 
			 if($instance == "vadodara" || $instance == "hope"){ ?>
				<td align="left" valign="top" style="padding-right: 3px" >
				<?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off','readonly'=>'readonly',
							'class' => "drugStock_$k",'id'=>"drugStock$k",'style'=>'margin:0px;background:#fff!important;width:40px!important;',
							'name' => 'drugStock[]','value'=>$setData['drugStock'],'label'=>false,'div'=>false)); ?>
				</td>
			
			
				<td align="left" valign="top" style="padding-right: 3px" >
				<?php echo $this->Form->input('', array('size'=>2,'type'=>'text','readonly'=>'readonly','autocomplete'=>'off',
						'class' => "salePrice_$k",'id'=>"salePrice$k",'style'=>'margin:0px;background:#fff!important;width:40px!important;',
						'name' => 'salePrice[]','value'=>$setData['salePrice'],'label'=>false,'div'=>false)); ?>
				</td>
			
				<td align="left" valign="top" style="padding-right: 3px" >
				<?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off','readonly'=>'readonly',
						'class' => "amount_$k amount",'id'=>"amount$k",'style'=>'margin:0px;background:#fff!important;width:40px!important;',
						'name' => 'amount[]',
						'value'=>$setData['amount']?$setData['amount']:0,'label'=>false,'div'=>false)); ?>
				</td>
		<?php } ?>
							
		
		<td  valign="top" align="left" style="padding-right: 3px">
		<?php echo $this->Form->input('', array('type'=>'text','multiple'=>false,'style'=>'margin:0px;width:50px; background:#fff !important;','class' => 'dose_val',
				'id'=>"dose_type$k",'name' => 'dose_type[]','label'=>false,'value'=>$setData['dose'],'div'=>false)); 
		echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('strength'),
				'style'=>'margin:0px;width:50px; background:#fff !important;','multiple'=>false,'class' => '','id'=>"Dfrom$k",
				'name' => 'DosageForm[]','label'=>false,'value'=>$setData['doseForm'],'div'=>false));
		?>	
		</td>
	
		<td align="left" valign="top" style="padding-right: 3px">
		<?php  echo $this->Form->input('', array('size'=>2,'type'=>'text','style'=>'margin:0px;',
				'class' => 'validate[required,custom[mandatory-enter]] dosage_Value','id'=>"dosage_value$k",
				'name' => 'dosageValue[]','style'=>'width:60px!important;background-color:#fff !important;',
				'label'=>false,'value'=>$setData['dosage'],'div'=>false)); ?>
		</td>
		<td align="left" valign="top" style="padding-right: 3px">
		<?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('roop'),
				'multiple'=>false,'style'=>'margin:0px;width:60px;','class' => '',
				'id'=>"strength$k",'name' => 'strength[]','label'=>false,
				'value'=>$setData['strength'],'div'=>false));?>
		</td>
		<td align="left" valign="top" style="padding-right: 3px">
		<?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('route_administration'),
				'multiple'=>false,'style'=>'width:60px;margin: 0 0 0 0px;','class' => '',
				'id'=>"route_administration$k",'name' => 'route_administration[]',
				'label'=>false,'value'=>$setData['route'],'div'=>false)); ?>
		</td>
		<td align="left" valign="top" style="padding-right: 3px">
		<?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('frequency'),
				'multiple'=>false,'style'=>'width:60px;margin: 0 0 0 0px;','class' => ' frequency_value',
				'id'=>"frequency_$k",'name' => 'frequency[]','label'=>false,'value'=>$setData['frequency'],'div'=>false)); ?>
		</td>
	
		<td align="left" valign="top" style="padding-right: 3px">
		<?php echo $this->Form->input('', array('type'=>'text','style'=>'width:50px;margin: 0 0 0 0px;',
				'class' => 'days','id'=>"days_$k",'name' => 'day[]',
				'label'=>false,'value'=>$setData['days'],'div'=>false)); ?>
		</td>
	
	
		
		<td align="center" valign="top" style="padding-right: 3px" >
		<?php echo $this->Form->input('', array('type'=>'text','size'=>16, 
				'class'=>'my_start_date1 textBoxExpnd','name'=> 'start_date[]',
				 'id' =>"start_date".$k ,
				'counter'=>$count,'label'=>false )); ?>
							</td>

		<td align="center" valign="top" style="padding-right: 3px">
		<?php echo $this->Form->input('', array('type'=>'text','size'=>16,
				'class'=>'my_end_date1 textBoxExpnd','name'=> 'end_date[]',
				'id' => "end_date".$k,'counter'=>$count,'label'=>false)); ?>
							</td>
		<td>
		<?php echo $this->Html->image('/img/cross.png',
				array('alt'=>'Delete','title'=>'delete','class'=>'deleteRow',
				'id'=>"rowDelete_$k",'onclick'=>"deleteRow($k)"));?>
							
	</tr>
<?php 
$total=$total+$setData['amount'];

}
echo $this->Form->input('total_amount', array('type'=>'hidden',
		'name'=> 'total_amount','value'=>$total,
		'id' => "custom_total",'label'=>false));?>

</table>
<script>
var counter = '<?php echo $count?>';
$(document).ready(function(){
	$(".my_end_date1").datepicker({
		changeMonth : true,
		changeYear : true,
		yearRange : '1950',
		dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		showOn : 'both',
		buttonText: false ,
		//minDate: new Date(dateStr),
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		buttonText: "Calendar",
		onSelect : function() {
			if($("#start_date"+counter).val() == '') $(this).val('');
		}
	});
	$(".my_start_date1").datepicker({
		changeMonth : true,
		changeYear : true,
		yearRange : '1950',
		dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		showOn : 'both',
		buttonText: false ,
		//minDate: new Date(dateStr),
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		buttonText: "Calendar",
		onSelect : function() {
			if($("#start_date"+counter).val() == '') $(this).val('');
		}
	});
	
});
$('#phrase').change(function(){
	var pharseName=$(this).val();
	if(pharseName){
		   var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "phraseMedication","admin" => false)); ?>";
			$.ajax({
		    	beforeSend : function() {
		    		$('#busy-indicator').show('fast');
		    	},
		   	url: ajaxUrl+'/'+pharseName,
		   //	data: "labName="+toSaveArrayLab+"&RadId="+toSaveArrayRad+"&ProcedureId="+toSaveArrayProcedure,
		  	dataType: 'html',
			  	success: function(data){
				 	if(data!=''){
				   		$('#busy-indicator').hide('fast');
				   		$('#DrugGroup').hide();
				   		$('#DrugGroup').html(data);
				   		$('#DrugGroup').show();
				   		//$('#smartName').val($('#template_type').val());
				   		
				  	}	
			 	},
			});
	}
		  
});
</script>
