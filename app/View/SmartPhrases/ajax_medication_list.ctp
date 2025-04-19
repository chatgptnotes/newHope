<?php 
  	echo $this->Html->script('jquery.autocomplete');
  	echo $this->Html->css('jquery.autocomplete.css');
?>
<?php echo $this->Form->create('',array('action'=>'ajaxMedicationList','id'=>'frmMed'));?>	
<table width="100%" border="0" cellspacing="1" cellpadding="0"
							id='DrugGroup' style="padding: 0px !important;margin-top: 10px;" class="tabularForm">
<tr>
								<td align="left" valign="top" class="tdLabel" width="10%">Drug Name</td>
								<td align="left" valign="top" class="tdLabel" width="10%">Strength</td>
								<td align="left" valign="top" class="tdLabel" width="10%">Dosage</td>							
								<td align="left" valign="top" class="tdLabel" width="10%">Dose Form</td>
								<td align="left" valign="top" class="tdLabel" width="10%">Route</td>
								<td  align="left" valign="top" class="tdLabel" width="10%">Frequency</td>	
								<td  align="left" valign="top" class="tdLabel" width="10%">Days</td>	
								<td  align="left" valign="top" class="tdLabel" width="10%">Qty</td>									
								<td  align="left" valign="top" class="tdLabel" width="10%">Active</td>	
								<?php //if(!empty($getArrayMedication['NewCropPrescription'])){?>
								<td  align="left" valign="top" class="tdLabel"  width="10%">Remove</td>	
								<?php //}?>	
</tr>
<?php 
if(empty($getArrayMedication)){
$count=3;
for($k=0;$k<$count;$k++){ ?>
<tr id="DrugGroup<?php echo $k;?>">
							<td align="left" valign="top" style="padding-right: 3px">
								<?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText validate[required,custom[mandatory-enter]]' ,'id'=>"drugText_$k",'name'=> 'drugText[]','value'=>stripslashes($getMedicationRecordsXml['NewCropPrescription'][$k]['description']),'autocomplete'=>'off','counter'=>$k,'style'=>'width:200px !important;','label'=>false,'div'=>false)); 
								echo $this->Form->hidden("",array('class'=>'allHiddenId','id'=>"drug_$k",'name'=>'drug_id[]','value'=>$getMedicationRecordsXml['NewCropPrescription'][$k]['id'],'div'=>false));
								?>
								<span id="drugType_<?php echo $k?>"></span>&nbsp;<span id="formularylinkId_<?php echo $k?>"></span>
							</td>
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','multiple'=>false,'style'=>'margin:0px;width:13px;','class' => ' dose_val','id'=>"dose_type$k",'name' => 'dose_type[]','label'=>false,'div'=>false)); 
							echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('strength'),'style'=>'margin: 0 0 0 0px;width:40px;','multiple'=>false,'class' => '','id'=>"Dfrom$k",'name' => 'DosageForm[]','label'=>false,'div'=>false));?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px"><?php  echo $this->Form->input('', array('size'=>2,'type'=>'text','style'=>'margin:0px;','class' => 'validate[required,custom[mandatory-enter]] dosage_Value','id'=>"dosage_value$k",'name' => 'dosageValue[]','style'=>'width:60px!important;background-color:#fff !important;','label'=>false,'div'=>false)); ?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('roop'),'multiple'=>false,'style'=>'margin:0px;width:60px;','class' => '','id'=>"strength$k",'name' => 'strength[]','label'=>false,'div'=>false));?>
							</td>
							<!--  <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('strength'),'multiple'=>false,'style'=>'margin:0px;width:60px;','class' => '','id'=>"Dfrom$k",'name' => 'DosageForm[]','label'=>false,'div'=>false));?>
							</td>-->
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('route_administration'),'multiple'=>false,'style'=>'width:60px;margin: 0 0 0 0px;','class' => '','id'=>"route_administration$k",'name' => 'route_administration[]','label'=>false,'div'=>false)); ?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('frequency'),'multiple'=>false,'style'=>'width:60px;margin: 0 0 0 0px;','class' => ' frequency_value','id'=>"frequency_$k",'name' => 'frequency[]','label'=>false,'div'=>false)); ?>
							</td>
							
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','style'=>'width:50px;margin: 0 0 0 0px;','class' => 'days','id'=>"days_$k",'name' => 'days[]','label'=>false,'value'=>'30','div'=>false)); ?>
							</td>	
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off','class' => "quantity_$k",'id'=>"quantity$k",'style'=>'margin:0px;background:#fff!important;width:50px!important;','name' => 'quantity[]','label'=>false,'div'=>false)); ?>
							</td>
				
							<td align="center" valign="top" style=""><?php $options_active = array('1'=>'Yes','0'=>'No');
										echo $this->Form->input('', array( 'options'=>$options_active,'class' => '','id'=>"isactive$k",'name' => 'isactive[]','label'=>false,'style'=>'margin:0px;width:50px;','multiple'=>false));?>
							</td>
							
							<td class="removeMedRow" id ="medRow_<?php echo $k?>"><?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove','title' => 'Remove','style'=>"margin:0px 0px 15px 10px;"));?></td>
							
</tr>		
<?php }}else{
$count=count($getArrayMedication['NewCropPrescription']);
echo $this->Form->hidden("",array('class'=>'','name'=>'pharse_name','value'=>$namePharse));
//debug($getArrayMedication['NewCropPrescription']);
foreach($getArrayMedication['NewCropPrescription'] as $k=>$setData ){
?>
<tr id="DrugGroup<?php echo $k;?>">
							<td align="left" valign="top" style="padding-right: 3px">
								<?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText validate[required,custom[mandatory-enter]]' ,'id'=>"drugText_$k",'name'=> 'drugText[]','value'=>$setData['description'],'autocomplete'=>'off','counter'=>$k,'style'=>'width:200px!important;','label'=>false)); 
								echo $this->Form->hidden("",array('class'=>'allHiddenId','id'=>"drug_$k",'name'=>'drug_id[]','value'=>$setData['drug_id']));
								?>
								<span id="drugType_<?php echo $k?>"></span>&nbsp;<span id="formularylinkId_<?php echo $k?>"></span>
							</td>
							<td align="left" valign="top" style="padding-right: 3px" >
							<?php echo $this->Form->input('', array('type'=>'text','multiple'=>false,'style'=>'margin:0px;width:13px;','class' => ' dose_val','id'=>"dose_type$k",'name' => 'dose_type[]','label'=>false,'value'=>$setData['dose'],'div'=>false)); 
							echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('strength'),'style'=>'margin: 0 0 0 0px;width:40px;','multiple'=>false,'class' => '','id'=>"Dfrom$k",'name' => 'DosageForm[]','label'=>false,'value'=>$setData['doseForm'],'div'=>false));
							  /*echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('dose_type'),
									'multiple'=>false,'style'=>'margin:0px;width:100px;','class' => ' dose_val',
									'id'=>"dose_type$k",'name' => 'dose_type[]','label'=>false,'value'=>$setData['dose'])); */?>
							
							</td>

							<td align="left" valign="top" style="padding-right: 3px"><?php  echo $this->Form->input('', array('size'=>2,'type'=>'text','style'=>'margin:0px;','class' => 'validate[required,custom[mandatory-enter]] dosage_Value','id'=>"dosage_value$k",'name' => 'dosageValue[]','style'=>'width:60px!important;background-color:#fff !important;','label'=>false,'value'=>$setData['dosage'],'div'=>false)); ?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('roop'),'multiple'=>false,'style'=>'margin:0px;width:60px;','class' => '','id'=>"strength$k",'name' => 'strength[]','label'=>false,'value'=>$setData['strength'],'div'=>false));?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('route_administration'),'multiple'=>false,'style'=>'width:60px;margin: 0 0 0 0px;','class' => '','id'=>"route_administration$k",'name' => 'route_administration[]','label'=>false,'value'=>$setData['route'],'div'=>false)); ?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('frequency'),'multiple'=>false,'style'=>'width:60px;margin: 0 0 0 0px;','class' => ' frequency_value','id'=>"frequency_$k",'name' => 'frequency[]','label'=>false,'value'=>$setData['frequency'],'div'=>false)); ?>
							</td>
							
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','style'=>'width:50px;margin: 0 0 0 0px;','class' => 'days','id'=>"days_$k",'name' => 'days[]','label'=>false,'value'=>$setData['days'],'div'=>false)); ?>
							</td>	
							
							
							<td align="left" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off','class' => "quantity_$k",'id'=>"quantity$k",'style'=>'margin: 0 0 0 10px;','name' => 'quantity[]','value'=>$setData['quantity'],'label'=>false,'style'=>'width:50px !important; background:#fff !important;','div'=>false)); ?>
							</td>

							<td align="center" valign="top" style="" ><?php $options_active = array('1'=>'Yes','0'=>'No');
										echo $this->Form->input('', array( 'options'=>$options_active,'class' => 'showLogPopUp','id'=>"isactive$i",'name' => 'isactive[]','value'=>$setData['Active'],'multiple'=>false,'label'=>false,'style'=>'width:50px!important;'));?>
							</td>
							
							
							<td class="removeMedRow" id ="medRow_<?php echo $k?>"><?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove','title' => 'Remove','style'=>"margin:0px 0px 15px 10px;"));?></td>
							
</tr>
<?php }}?>	
<?php echo $this->Form->hidden('',array('id'=>"smartName",'name'=>"smartName")); ?>
</table>
<table>
<tr>
					
					<td align="left" style="padding-left: 20px" colspan='6'>
						<input type="button" id="addButton" value="Add Row"> <?php if($count > 0){?>
						<!-- <input type="button" id="removeButton1" value="Remove"> --> <?php }else{ ?> 
						<!--<input type="button" id="removeButton" value="Remove"  style="display: none;"> --> <?php } ?></td>
				</tr>
<tr>
	<td><!-- <input type="button" value="Done" class="blueBtn" id="done"/> --></td>	
</tr>		

<?php echo $this->Form->end();?>
<script>
jQuery(document).ready(function(){
	$('#smartName').val($('#template_type').val());
	
});
var currentDateForAddMore='';
var splitCurrentDateForAddMore='';
		//$('.drugText').on('focus',function() {
		$(document).on('focus', '.drugText', function() { // Important
					var currentId=	$(this).attr('id').split("_"); // Important
					var attrId = this.id;
					
				var counter = $(this).attr(
							"counter");
					
					if ($(this).val() == "") {
						$("#Pack" + counter).val("");
					}
					$(this).autocomplete(
																																
									"<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','null','name',"admin" => false,"plugin"=>false)); ?>",
									{										
										width : 250,
										selectFirst : true,
										valueSelected:true,
										minLength: 1,
										delay: 1000,
										isOrderSet:true,
										showNoId:true,
										loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+/*$(this).attr('id').replace("drugText_",'dose_type')
										+*/','+$(this).attr('id').replace("drugText_",'strength')
											+','+$(this).attr('id').replace("drugText_",'route_administration'),
																					
									});
					

				});//EOF autocomplete
/*$('#done').click(function(){
var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "ajaxMedicationList","admin" => false)); ?>";
var formData = $('#frmMed').serialize();
$.ajax({
	beforeSend : function() {
		$('#busy-indicator').show('fast');
	},
	type: 'POST',
url: ajaxUrl,
	data: formData,
	dataType: 'html',
  	success: function(data){
	 	if(data!=''){
	 		$('#busy-indicator').hide('fast');
	 		//alert(data);
	   	
	  	}	
 	},
});
});*/
var counter = '<?php echo $count?>';
var calenderAry = new Array();
 $("#addButton").click(
			function() {			
				counter++;					
				var newCostDiv = $(document.createElement('tr'))
			     .attr("id", 'DrugGroup' + counter);			
			var dose_option ='<select style="background: #fff !important;width: 50px !important;" id="dose_type'+counter+'" class="dose_val" name="dose_type[]"><option value="">Select</option>';//+dose_option_value;
			var dosage_form = '<select style="margin: 0 0 0 0px; width:40px", id="Dfrom'+counter+'" class="dosageform" name="DosageForm[]"><option value="">Select</option>';//+str_option_value;
			var route_option = '<select style="width:60px;margin: 0 0 0 0px;" id="route_administration'+counter+'" class="" name="route_administration[]"><option value="">Select</option>';//+route_option_value;
			var frequency_option = '<select style="width:60px;margin: 0 0 0 0px;" id="frequency_'+counter+'" class="frequency_value" name="frequency[]"><option value="">Select</option>';//+freqConfig;
		var refills_option = '<select style="width:60px;margin: 0 0 0 0px;" id="strength'+counter+'" class="frequency" name="strength[]"><option value="">Select</option>';//+roopNameConfig;
var strength_option = '<select style="width:79px;" id="strength'+counter+'" class="" name="strength[]"><option value="">Select</option>';//+str_option_value;

var prn_option = '<select style="width:40px;" id="prn'+counter+'" class="" name="prn[]"><option value="1">Yes</option><option value="0">No</option></select>';
var daw_option = '<select style="width:40px;" id="daw'+counter+'" class="" name="daw[]"><option value="1">Yes</option><option value="0">No</option></select>';
var active_option = '<select style="width:50px;" id="isactive'+counter+'" class="" name="isactive[]"><option value="1">Yes</option><option value="0">No</option></select>';
<?php if(!empty($getMedicationRecordsXml['NewCropPrescription'])){?>
			var is_adv = '<?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_history','id'=>"pMH$count"));?>';
<?php }else{?>
var is_adv=" ";
<?php }?>
			
			var options = '<option value=""></option>';
for (var i = 1; i < 25; i++) {
	if (i < 13) {
		str = i + 'am';
	} else {
		str = (i - 12) + 'pm';
	}
	options += '<option value="'+i+'"'+'>'
			+ str + '</option>';
}

timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
		+ options
		+ '</select></td> ';
timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 67px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
		+ options
		+ '</select></td> ';
timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
		+ options
		+ '</select></td> ';
timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
		+ options
		+ '</select></td> ';
timer = timerHtml1 + timerHtml2
		+ timerHtml3 + timerHtml4
		+ '</tr></table></td>';

var newHTml = '<td valign="top"><input  type="text" style="width:200px !important;" value="" id="drugText_' + counter + '"  class="drugText validate[required,custom[mandatory-enter]]" name="drugText[]" autocomplete="off" counter='+counter+'>'+
					'<input  type="hidden" class="allHiddenId" id="drug_' + counter + '"  name="drug_id[]" > <span id="drugType_' + counter + '"></span>&nbsp;<span id="formularylinkId_' + counter + '"></span></td>'
		+'<td valign="top"><input size="2" type="text" value="" id="dose_type'+counter+'"  name="dose_type[]" "autocomplete"="off" style="background:#fff !important;margin:0px;width:13px;">'+dosage_form+'</td>'
		+ '</td><td valign="top" >'  
		+ '<input size="2" type="text" value="" id="dosage_value'+counter+'" class="validate[required,custom[mandatory-enter]] dosage_Value" name="dosageValue[]" "autocomplete"="off" style="margin:0px;width:60px !important;background-color:#fff !important;">'
		+ '</td><td valign="top">'
		+ refills_option
		+ '</td>'
		
		+ '<td valign="top">'
		+ route_option
		+ '</td>'
		+ '<td valign="top">'
		+ frequency_option
		+ '</td>'
		+ '<td valign="top" ><input size="2" type="text" value="30" id="days_'+counter+'" class="days" name="days[]" "autocomplete"="off" style="background:#fff !important;width:50px!important;"></td>'
		+ '<td valign="top" ><input size="2" type="text" value="" id="quantity'+counter+'" class="quantity_'+counter+'" name="quantity[]" style="background:#fff !important;width:50px!important;"></td>'
		+ '<td valign="top" align="center" >'
		+ active_option
		+'</td>'
		+'<td  class="removeMedRow" id="medRow_' + counter + '"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>"margin:0px 0px 15px 10px;"),array());?></td>'
		;
			 			 
newCostDiv.append(newHTml);		 
newCostDiv.appendTo("#DrugGroup");	
var route_option_value = <?php echo json_encode(Configure::read('route_administration'));?>;
$.each(route_option_value, function (key, value) {
	$('#route_administration'+counter).append( new Option(value, key) );
});			
var str_option_value = <?php echo json_encode(Configure::read('strength'));?>;
$.each(str_option_value, function (key, value) {
	$('#Dfrom'+counter).append( new Option(value, key) );
});
var roopNameConfig = <?php echo json_encode(Configure::read('roop'));?>;
$.each(roopNameConfig, function (key, value) {
	$('#strength'+counter).append( new Option(value, key) );
});
var freqConfig = <?php echo json_encode(Configure :: read('frequency'));?>;
$.each(freqConfig, function (key, value) {
	$('#frequency_'+counter).append( new Option(value, key) );
});
var dose_type = <?php echo json_encode(Configure :: read('dose_type'));?>;
$.each(dose_type, function (key, value) {
	$('#dose_type'+counter).append( new Option(value, key) );
});
		if (counter > 0)
		$('#removeButton').show('slow');
		
});
 $("#removeButton1").click(function() {	
		counter--;
		
		$("#DrugGroup"+counter).remove();
		if (counter == 0)
			$('#removeButton').hide('slow');
	});
 
 	$(document).on('click','.removeMedRow', function() { 	 
		if(confirm("Do you really want to delete this record?")){
			currentId=$(this).attr('id'); 
			splitedId=currentId.split('_');
			ID=splitedId['1'];	
		//	var setTonewCropId=$('#newCrop'+ID).val();				
			
			  $("#DrugGroup"+ID).remove();		
	
						
		}else{
			return false;
		}			
	});


 	
 	$(document).on('change','.frequency_value', function() { 
		currentId = $(this).attr('id') ;
  		splittedVar = currentId.split("_");		 
  		Id = splittedVar[1];

  		if($(this).val()=='32'){
			$('#dosage_value'+Id).val('2');	
			$('#days'+Id).val('1');
			$('#quantity'+Id).val('1');
			return false;
  		}else if($('#frequency_'+Id).val()=='31'){ 
			$('#days'+Id).val('1');
  			freq='1';
  			dose=$('#dosage_value'+Id).val();
			if($('#dosage_value'+Id).val()=='')dose='1';
			if(dose=='0.5/half')dose='0.5';
			if(dose=='1-2')dose='2';
			if(dose=='1-3')dose='3';
			if(dose=='2-3')dose='3';
			if(dose=='0.33/third')dose='0.33';
			if(dose=='0.5-1')dose='1';
			qty=(dose)*(freq);
			qtyId=$('#quantity'+Id).val(qty);
			$('#dosage_value'+Id).val('2'); 
  		}else if($('#dosage_value'+Id).val()=="" || $('#frequency_'+Id).val()==""){
  			$('#quantity'+Id).val("");
			return false;
		}else{
	  		freq_val = <?php echo json_encode(Configure::read('frequency_value'));?>;
			freq=$(this).val(); 
			dose=$('#dosage_value'+Id).val();
			if(dose=='0.5/half')dose='0.5';
			if(dose=='1-2')dose='2';
			if(dose=='1-3')dose='3';
			if(dose=='2-3')dose='3';
			if(dose=='0.33/third')dose='0.33';
			if(dose=='0.5-1')dose='1';
			freq_val1=freq_val[$.trim(freq)];		
			qty=(dose)*(freq_val1);			
			qty=Math.round(qty);
			qtyId=$('#quantity'+Id).val(qty);
			$('#day'+Id).val("30");
		}
	});

	
		$(document).on('keyup','.dosage_Value', function() { 	
		currentId = $(this).attr('id') ;
		Id = currentId.slice(-1);
		if($('#dosage_value'+Id).val()=="" || $('#frequency_'+Id).val()==""){
			$('#quantity'+Id).val("");			
			return false;
		}else if($('#frequency_'+Id+'option:selected').val()=='31'){ 
			$('#days'+Id).val('1');
			doseID=$(this).attr('id');
			dose=$('#'+doseID).val();			
			if(dose=='0.5/half')dose='0.5';
			if(dose=='1-2')dose='2';
			if(dose=='1-3')dose='3';
			if(dose=='2-3')dose='3';
			if(dose=='0.33/third')dose='0.33';
			if(dose=='0.5-1')dose='1';
			freq='1';
			qty=(dose)*(freq); 
			qtyId=$('.quantity_'+Id).val(qty);
  		}else if($('#frequency_'+Id+'option:selected').val()=='32'){ 
			$('#day'+Id).val('1');
			doseID=$(this).attr('id');
			dose=$('#'+doseID).val();
			if(dose=='0.5/half')dose='0.5';
			if(dose=='1-2')dose='2';
			if(dose=='1-3')dose='3';
			if(dose=='2-3')dose='3';
			if(dose=='0.33/third')dose='0.33';
			if(dose=='0.5-1')dose='1';
			freq='1';
			qty=(dose)*(freq); 
			qtyId=$('.quantity_'+Id).val(qty);
  		}else{    	  			
			doseID=$(this).attr('id');
			dose=$('#'+doseID).val();			
			if(dose=='0.5/half')dose='0.5';
			if(dose=='1-2')dose='2';
			if(dose=='1-3')dose='3';
			if(dose=='2-3')dose='3';
			if(dose=='0.33/third')dose='0.33';
			if(dose=='0.5-1')dose='1';
			freq=$('#frequency_'+Id).val();			
			freq_val = <?php echo json_encode(Configure::read('frequency_value'));?>;			
			freq_val1=freq_val[$.trim(freq)];			
			qty=(dose)*(freq_val1);			
			qty=Math.round(qty);
			qtyId=$('.quantity_'+Id).val(qty);
			
			$('#days'+Id).val("30");
		}
	});

	$(document).on('keyup','.days', function() { 
		days=$(this).val();
		currentId = $(this).attr('id') ;
		
		Id = currentId.slice(-1);
		if($(this).val()==""){
			$('.quantity_'+Id).val("");
		}
		dose=$('#dosage_value'+Id).val();
		if(dose=='0.5/half')dose='0.5';
		if(dose=='1-2')dose='2';
		if(dose=='1-3')dose='3';
		if(dose=='2-3')dose='3';
		if(dose=='0.33/third')dose='0.33';
		if(dose=='0.5-1')dose='1';
		freqency=$('#frequency_'+Id+' option:selected').val();
		
		if(freqency=='1' || freqency=='2' || freqency=='4' || freqency=='18' || freqency=='19' || freqency=='35' || freqency=='32'
			|| freqency=='31' || freqency=='34' || freqency=='35' || freqency=='42'|| freqency=='43'|| freqency=='44')freqency='1';
	if(freqency=='5'||freqency=='11' ||freqency=='36'||freqency=='37')freqency='2';
	if(freqency=='6'||freqency=='10')freqency='3';
	if(freqency=='7'||freqency=='9' ||freqency=='24')freqency='4';
	if(freqency=='28'||freqency=='24')freqency='8';
	if(freqency=='26'||freqency=='12'||freqency=='39')freqency='0.5';
	if(freqency=='29')freqency='12';
	if(freqency=='8')freqency='6';
	if(freqency=='23')freqency='0.33';
	if(freqency=='14' || freqency=='40')freqency='0.1429';
	if(freqency=='15' || freqency=='38')freqency='0.0714';
	if(freqency=='16')freqency='0.0476';
	if(freqency=='25')freqency='16';
	if(freqency=='27')freqency='0.2857';
	if(freqency=='20')freqency='0.4856';
	if(freqency=='22')freqency='0.0333';		
		qty=dose*freqency*days;
		qty=Math.round(qty);
		$('.quantity_'+Id).val(qty);
		return;
	});
 	
 	</script>