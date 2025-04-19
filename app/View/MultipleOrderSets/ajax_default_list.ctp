

<?php 	
$OrderNameRemoveSp = str_replace(' ', '', $getOrderCategoryData['OrderCategory']['order_description']); /////for All type Categorywise name?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" align="right" style="text-align: right !important;">
<tr>
								<td align="left" valign="top" class="tdLabel" width="10%" colspan="2" style="text-align: right !important;"><input type="button" class="HideCtegoryData" id="<?php echo $OrderNameRemoveSp."_".$getOrderCategoryData['OrderCategory']['id'];?>" value="Hide <?php echo $getOrderCategoryData['OrderCategory']['order_description'];?>">
							<input type="button" id="showDiet" value="Show Diet" style="display:none;"></td>
							
																			
</tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="0"	id="<?php echo $OrderNameRemoveSp;?>Group" style="padding: 0px !important;margin-top: 10px;" class="tabularForm">
<tr>
								<td align="left" valign="top" class="tdLabel" width="10%"><?php echo $getOrderCategoryData['OrderCategory']['order_description'];?> Name</td>
								<?php if($getOrderCategoryData['OrderCategory']['id']=='33'){ //////Medication?>	
								<td align="left" valign="top" class="tdLabel" width="10%">Strength</td>
								<td align="left" valign="top" class="tdLabel" width="10%">Dosage</td>							
								<td align="left" valign="top" class="tdLabel" width="10%">Dose Form</td>
								<td align="left" valign="top" class="tdLabel" width="10%">Route</td>
								<td  align="left" valign="top" class="tdLabel" width="10%">Frequency</td>
								
								<td  align="left" valign="top" class="tdLabel" width="10%">Quantity</td>											
								<td  align="left" valign="top" class="tdLabel" width="10%">Intake & Output</td>	
								<?php } ?>
								<td align="left" valign="top" class="tdLabel" width="10%">Action</td>															
</tr>
<?php 
if(empty($getArrayDefault)){
$count=3;
for($k=0;$k<$count;$k++){ ?>
<tr id="<?php echo $OrderNameRemoveSp;?>Group<?php echo $k;?>">
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] '.$OrderNameRemoveSp ,'id'=>$OrderNameRemoveSp."name_".$k,'name'=> $OrderNameRemoveSp.'name[]','autocomplete'=>'off','counter'=>$k,'style'=>'width:200px !important;','label'=>false,'div'=>false)); 
								//echo $this->Form->hidden('',array('id'=>'ordercategory'.$OrderNameRemoveSp.'id'.$i,'name'=>"ordercategory_id[]",'class'=>'ordercategory'.$OrderNameRemoveSp.'_Cls1'));
								?>
							</td>
							<?php if($getOrderCategoryData['OrderCategory']['id']=='33'){ //////Medication?>							
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('strength'),'style'=>'margin: 0 0 0 0px;width:57px;','multiple'=>false,'class' => 'validate[required,custom[mandatory-select]]','id'=>"Dfrom$k",'name' => 'DosageForm[]','label'=>false,'div'=>false));?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px"><?php  echo $this->Form->input('', array('size'=>2,'type'=>'text','style'=>'margin:0px;','class' => 'validate[required,custom[mandatory-enter]] dosage_Value','id'=>"dosage_value$k",'name' => 'dosageValue[]','style'=>'width:60px!important;background-color:#fff !important;','label'=>false,'div'=>false)); ?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('roop'),'multiple'=>false,'style'=>'margin:0px;width:60px;','class' => 'validate[required,custom[mandatory-select]]','id'=>"strength$k",'name' => 'strength[]','label'=>false,'div'=>false));?>
							</td>
							
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('route_administration'),'multiple'=>false,'style'=>'width:60px;margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]]','id'=>"route_administration$k",'name' => 'route_administration[]','label'=>false,'div'=>false)); ?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('frequency'),'multiple'=>false,'style'=>'width:60px;margin: 0 0 0 0px;','class' => ' validate[required,custom[mandatory-select]] frequency_value','id'=>"frequency_$k",'name' => 'frequency[]','label'=>false,'div'=>false)); ?>
							</td>							
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off','class' => "quantity_$k",'id'=>"quantity$k",'style'=>'margin:0px;background:#fff!important;width:50px!important;','name' => 'quantity[]','label'=>false,'div'=>false)); ?>
							</td>				
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=> $resultOfSubCategory, 'id' => "intake$k",'label'=>false,'style'=>"width: 85%;",'class'=>'validate[required,custom[mandatory-select]]','name' => 'intake[]' ));?>
							</td>
							
							<?php }?>
							<td class="removeRow" id ="<?php echo $OrderNameRemoveSp;?>Row_<?php echo $k?>"><?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove','title' => 'Remove','style'=>"margin:0px 0px 15px 10px;"));?></td>
							
</tr>		
<?php }}else{
$count=count($getArrayDefault['OrderSubcategory']);
foreach($getArrayDefault['OrderSubcategory'] as $k=>$setData ){?>
<tr id="<?php echo $OrderNameRemoveSp;?>Group<?php echo $k;?>">
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]'.$OrderNameRemoveSp  ,'id'=>$OrderNameRemoveSp."name_$k",'name'=> $OrderNameRemoveSp.'name[]','value'=>$setData['name'],'autocomplete'=>'off','counter'=>$k,'style'=>'width:200px!important;','label'=>false));
									echo $this->Form->hidden('',array('id'=>'OrderSubcategory'.$OrderNameRemoveSp.'_id'.$k,'name'=> 'OrderSubcategory'.$OrderNameRemoveSp.'_id[]','value'=>$setData['id']));
									//echo $this->Form->hidden('',array('id'=>'ordercategory'.$OrderNameRemoveSp.'_id','name'=>"ordercategory".$OrderNameRemoveSp."_id[]"));
								//	echo $this->Form->hidden('',array('id'=>'ordercategory'.$OrderNameRemoveSp.'id'.$k,'name'=>"ordercategory_id[]",'class'=>'ordercategory'.$OrderNameRemoveSp.'_Cls1'));
								 ?>								
							</td>
							<?php if($getOrderCategoryData['OrderCategory']['id']=='33'){ //////Medication?>
							<td align="left" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('strength'),'style'=>'margin: 0 0 0 0px;width:60px;','multiple'=>false,'class' => 'validate[,custom[mandatory-select]]','id'=>"Dfrom$k",'name' => 'DosageForm[]','label'=>false,'value'=>$setData['DosageForm'],'div'=>false));?>							
							</td>
							<td align="left" valign="top" style="padding-right: 3px"><?php  echo $this->Form->input('', array('size'=>2,'type'=>'text','style'=>'margin:0px;','class' => 'validate[required,custom[mandatory-enter]] dosage_Value','id'=>"dosage_value$k",'name' => 'dosageValue[]','style'=>'width:60px!important;background-color:#fff !important;','label'=>false,'value'=>$setData['dosageValue'],'div'=>false)); ?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('roop'),'multiple'=>false,'style'=>'margin:0px;width:60px;','class' => 'validate[required,custom[mandatory-select]]','id'=>"strength$k",'name' => 'strength[]','label'=>false,'value'=>$setData['strength'],'div'=>false));?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('route_administration'),'multiple'=>false,'style'=>'width:60px;margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]]','id'=>"route_administration$k",'name' => 'route_administration[]','label'=>false,'value'=>$setData['route_administration'],'div'=>false)); ?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px" ><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('frequency'),'multiple'=>false,'style'=>'width:60px;margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]] frequency_value','id'=>"frequency_$k",'name' => 'frequency[]','label'=>false,'value'=>$setData['frequency'],'div'=>false)); ?>
							</td>
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off','class' => "quantity_$k",'id'=>"quantity$k",'style'=>'margin:0px;background:#fff!important;width:50px!important;','name' => 'quantity[]','label'=>false,'value'=>$setData['quantity'],'div'=>false)); ?>
							</td>							
							<td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=> $resultOfSubCategory, 'id' => "intake$k",'label'=>false,'style'=>"width: 85%;",'class'=>'validate[required,custom[mandatory-select]]','name' => 'intake[]','value'=>$setData['intake'])); ?>
							</td>	
							<?php } ?>						
							<td class="removeRow" id ="<?php echo $OrderNameRemoveSp;?>Row_<?php echo $k?>"><?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove','title' => 'Remove','style'=>"margin:0px 0px 15px 10px;"));?></td>
							
</tr>
<?php }}?>	
</table>
<table id="hide<?php echo $OrderNameRemoveSp;?>Button">
<tr>
					
					<td align="left" style="padding-left: 20px" colspan='6'>
						<input type="button" id="addButton<?php echo $OrderNameRemoveSp;?>" value="Add Row"></td>
				</tr>
				</table>
						

</td>
</tr>
</table>
<script>
var counter = '<?php echo $count?>';
 $("#addButton<?php echo $OrderNameRemoveSp;?>").click(function() {
				counter++;					
				var newCostDiv = $(document.createElement('tr'))
			     .attr("id", '<?php echo $OrderNameRemoveSp;?>Group' + counter);				
				var dosage_form = '<select style="margin: 0 0 0 0px; width:57px", id="Dfrom'+counter+'" class="validate[required,custom[mandatory-select]] dosageform" name="DosageForm[]"><option value="">Select</option>';//+str_option_value;
				var refills_option = '<select style="width:60px;margin: 0 0 0 0px;" id="strength'+counter+'" class="validate[required,custom[mandatory-select]] frequency" name="strength[]"><option value="">Select</option>';//+roopNameConfig;
				var resultOfSubCategoryDrp = '<select style="margin: 0 0 0 0px; width:85px", id="intake'+counter+'" class="validate[required,custom[mandatory-select]] dosageform" name="intake[]"><option value="">Select</option>';//+resultOfSubCategory;
				var route_option = '<select style="width:60px;margin: 0 0 0 0px;" id="route_administration'+counter+'" class="validate[required,custom[mandatory-select]]" name="route_administration[]"><option value="">Select</option>';//+route_option_value;
				var frequency_option = '<select style="width:60px;margin: 0 0 0 0px;" id="frequency_'+counter+'" class="validate[required,custom[mandatory-select]] frequency_value" name="frequency[]"><option value="">Select</option>';//+freqConfig;
			
var newHTml = '<td valign="top"><input  type="text" style="width:200px !important;" value="" id="<?php echo $OrderNameRemoveSp;?>name_' + counter + '"  class="validate[required,custom[mandatory-enter]] <?php echo $OrderNameRemoveSp;?>" name="<?php echo $OrderNameRemoveSp;?>name[]" autocomplete="off" counter='+counter+'>'+
					'</td>'
		<?php if($getOrderCategoryData['OrderCategory']['id']=='33'){ //////Medication?>
		+'<td valign="top">'+dosage_form+'</td>'
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
		+ '</td><td valign="top" >'  
		+ '<input size="2" type="text" value="" id="quantity'+counter+'" class="validate[required,custom[mandatory-enter]]" name="quantity[]" "autocomplete"="off" style="margin:0px;width:50px !important;background-color:#fff !important;">'
		+ '</td>'
		+ '<td valign="top" align="center" >'
		+ resultOfSubCategoryDrp
		+'</td>'
		<?php } ?>
		+'<td  class="removeRow" id="<?php echo $OrderNameRemoveSp;?>Row_' + counter + '"><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>"margin:0px 0px 15px 10px;"),array());?></td>'
		;
		 			 
newCostDiv.append(newHTml);		 
newCostDiv.appendTo("#<?php echo $OrderNameRemoveSp;?>Group");
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
var resultOfSubCategoryDrpList = <?php echo json_encode($resultOfSubCategory);?>;
	$.each(resultOfSubCategoryDrpList, function (key, value) {
		$('#intake'+counter).append( new Option(value, key) );
	});
	
});

 
 $(document).on('focus', '.Medication', function() { // Important
	/*	var currentId=	$(this).attr('id').split("_"); // Important
		var attrId = this.id;
		
	var counter = $(this).attr(
				"counter");
		
		if ($(this).val() == "") {
			$("#Pack" + counter).val("");
		}*/
		$(this)
				.autocomplete(
																													
						"<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','null','name',"admin" => false,"plugin"=>false)); ?>",
						{
							
							width : 250,
							selectFirst : true,
							valueSelected:true,
							minLength: 1,
							delay: 1000,
							isOrderSet:true,
							showNoId:true,
							loadId : 'Medication,testCode',
						
						});
		

	});//EOF autocomplete
	
	$(document).on('focus', '.Lab', function() {
 		$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "labRadAutocomplete"
 				,"Laboratory",'id',"dhr_order_code","name","admin" => false,"plugin"=>false)); ?>", {
 			width: 250,
 			selectFirst: true,
 			valueSelected:true,
 			showNoId:true,
 			loadId : 'lab,testCode',
 			
 		});	
 		});
	
 		$(document).on('focus', '.DiagnosticTest', function() {
 			 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "labRadAutocomplete","Radiology",'id',"dhr_order_code","name","admin" => false,"plugin"=>false)); ?>", {
 		    	width: 250,
 		    	selectFirst: true,
 		    	valueSelected:true,
 		    	showNoId:true,
 		    	loadId : 'dianame,test_CodeRad',
 		    	
 		    });
 		});
 	</script>