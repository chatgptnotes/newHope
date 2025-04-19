<?php 
echo $this->Html->script(array('jquery.min.js?ver=3.3','ui.datetimepicker.3.js'));

echo $this->Html->css('internal_style.css');

echo $this->Html->script(array('jquery.fancybox-1.3.4'));



?>
<?php //echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>
<?php 

//echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','ui.datetimepicker.3.js'));
//echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
?>
<style>
.inline_labels {
	float: left;
	margin: 0px;
	width: 200px;
}
</style>
</head>
<body>


	<?php echo $this->Form->create('OrderSentence',array('type' => 'file','id'=>'OrderSentence','inputDefaults' => array(
			'label' => false,
			'div' => false,
			'error' => false,
			'legend'=>false,
			'fieldset'=>false,
			'url' => array('controller' => 'patients', 'action' => 'ordersentence',$patient_id)
	)
	));


	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5"><label id="showName"
				style="width: 70%; text-align: left"></label>
			</th>
		</tr>
		<?php if(!empty($getResultedRecord)){ ?>
		<tr>
			<?php /* debug($rule);exit; if($rule!=0){ */ 
				foreach ($getResultedRecord as $getResultedRecords){
				//debug($getResultedRecords);
				$radioOptions[$getResultedRecords['OrderSentence']['sentence']] = $getResultedRecords['OrderSentence']['sentence'];
}
			/*}
			 else{
echo $this->Form->hidden('PatientOrder.isMultiple',array('value'=>'Yes'));
echo $this->Form->hidden('PatientOrder.loinc',array('value'=>$loinc,'id'=>'keyclick'));
foreach ($getResultedRecord as $getResultedRecords){
	$radioOptions[$getResultedRecords['OrderSentence']['sentence']] = $getResultedRecords['OrderSentence']['sentence'];
	$radioOptions[$getResultedRecords['OrderSubcategory']['order_sentence']] = $getResultedRecords['OrderSubcategory']['order_sentence'];
}
} */
?>

			<td width="19%" valign="middle" class="tdLabel" id="boxspace"><?php  echo '<ul style="list-style:none">'; echo $this->Form->radio('PatientOrder.sentence', $radioOptions,array('style'=>'align:right','label'=>false,'id'=>'radioId','name'=>'radioId', 'legend'=>false,'separator'=>'</li><li>')).'<br/>';echo '</ul>';

			?></td>
		</tr>
		<tr>
			<td align="right" style="padding-right: 10px;"><input class="blueBtn"
				type="submit" value="Submit" id="submit1">
			</td>
		</tr>
		<?php }else {?>
		<tr>
			<td align="center"
				style="padding-left: 10px; padding-top: 10px; color: red"><b><?php  echo __("No order sentence found")?>
			</b>
			</td>
		</tr>
		<?php }
		if($category=='34'){?>
		<tr>
		
		
		<tr>
			<td>&nbsp;</td>
		</tr>
		<th colspan="4" style="margin-top: 10px;">Add new Order Sentence</th>
		</tr>

		<?php //$getResultedRecords['OrderSentence']['sentence']=>$getResultedRecords['OrderSentence']['sentence']?>
		<?php echo $this->Form->hidden('PatientOrder.patient_id',array('value'=>$patient_id,'id'=>'patient_id'));?>
		<?php echo $this->Form->hidden('PatientOrder.name',array('value'=>'','id'=>'name'));?>
		<?php echo $this->Form->hidden('PatientOrder.location_id',array('value'=>$this->Session->read('locationid')));?>

		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace">
				<table width="100%">
					<tr>
						<td><div id='labCheck' style='display: none'>
								<font color='red'>Please check the validations.</font>
							</div></td>
					</tr>
					<?php echo $this->Form->hidden('OrderSentence.allData',array('value'=>$allData,'id'=>'allData'));?>
					<tr>
						<td><?php echo __('Specimen Type',true); ?><font color="red">*</font>
						</td>
						<td><?php
						echo $this->Form->input('OrderSentence.specimen_type_id',array('empty'=>'Please Select','style'=>'width:165px','readonly'=>'readonly',
											'options'=>$spec_type,'selected'=>$getDataLab['LaboratoryToken']['specimen_type_id'],'id'=>'specimen_type_id','div'=>false,'label'=>false));?>
						</td>
						<td><?php echo __('Collection Priority',true); ?><font color="red">*</font>
						</td>
						<td><?php echo $this->Form->input('OrderSentence.collection_priority', array('empty'=>'Please select','options'=> Configure :: read('collection_priority'), 'id' => 'collection_priority',
												'selected'=>$getDataLab['LaboratoryToken']['collection_priority'],'label'=>false,'class'=>'validate[required,custom[mandatory-select]]' ));?>
						</td>
					</tr>
					<tr>
						<td><?php echo __('Frequency',true); ?>
						</td>
						<td><?php echo $this->Form->input('OrderSentence.frequency_l', array('empty'=>'Please select','options'=> Configure :: read('frequency_lr'), 'id' => 'frequency_l',
												'selected'=>$getDataLab['LaboratoryToken']['frequency_l'],'label'=>false,'class'=>'validate[required,custom[mandatory-select]]' ));?>
						</td>
					</tr>
					<tr>
						<td align="right" style="padding-right: 10px; padding-top: 10px"
							colspan="4"><?php
							echo  $this->Js->link('<input type="button" value="Add" class="blueBtn" id="submit2">',"#",
 array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('hide', array('buffer' => false)),'update'=>'#resultorder', 'data' => '{finddata:$("#finddata").val(),patientid:$("#patientid").val(),category:$("#category").val()}','dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();
				?>
						</td>
					</tr>
				</table>
				<div align="center" id='busy-indicator' style="display: none;">
					&nbsp;
					<?php echo $this->Html->image('indicator.gif', array()); ?>
				</div>
			</td>
		</tr>
		<?php }
	else if($category=='33'){?>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<th colspan="4" style="margin-top: 10px;">Add new Order Sentence</th>
		</tr>

		<?php //$getResultedRecords['OrderSentence']['sentence']=>$getResultedRecords['OrderSentence']['sentence']?>
		<?php echo $this->Form->hidden('PatientOrder.patient_id',array('value'=>$patient_id,'id'=>'patient_id'));?>
		<?php echo $this->Form->hidden('PatientOrder.name',array('value'=>'','id'=>'name'));?>
		<?php echo $this->Form->hidden('PatientOrder.location_id',array('value'=>$this->Session->read('locationid')));?>

		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace">
				<table width="100%">

					<tr>
						<td><div id='labCheck' style='display: none'>
								<font color='red'>Please check the validations.</font>
							</div></td>
					</tr>

					<?php echo $this->Form->hidden('OrderSentence.allData',array('value'=>$allData,'id'=>'allData'));?>
					<tr>
						<td><?php echo __('Dose',true); ?><font color="red">*</font>
						</td>
						<td><?php
						echo $this->Form->input('OrderSentence.dose',array('empty'=>'Please Select','style'=>'width:165px','readonly'=>'readonly',
											'options'=> Configure :: read('dose_type'),'selected'=>$getDataLab['LaboratoryToken']['specimen_type_id'],'id'=>'specimen_type_id','div'=>false,'label'=>false));?>
						</td>
						<td><?php echo __('Form',true); ?><font color="red">*</font>
						</td>
						<td><?php echo $this->Form->input('OrderSentence.strength', array('empty'=>'Please select','options'=> Configure :: read('strength'), 'id' => 'collection_priority',
												'selected'=>$getDataLab['LaboratoryToken']['collection_priority'],'label'=>false,'class'=>'validate[required,custom[mandatory-select]]' ));?>
						</td>
					</tr>
					<tr>
						<td><?php echo __('Route of administration',true); ?>
						</td>
						<td><?php echo $this->Form->input('OrderSentence.route', array('empty'=>'Please select','options'=> Configure :: read('route_administration'), 'id' => 'frequency_l',
												'selected'=>$getDataLab['LaboratoryToken']['frequency_l'],'label'=>false,'class'=>'validate[required,custom[mandatory-select]]' ));?>
						</td>
						<td><?php echo __('Frequency',true); ?>
						</td>
						<td><?php echo $this->Form->input('OrderSentence.frequency', array('empty'=>'Please select','options'=> Configure :: read('frequency'), 'id' => 'frequency_l',
												'selected'=>$getDataLab['LaboratoryToken']['frequency_l'],'label'=>false,'class'=>'validate[required,custom[mandatory-select]]' ));?>
						</td>
					</tr>
					<tr>
						<td><?php echo __('Intake And Output',true); ?>
						</td>
						<td><?php echo $this->Form->input('OrderSentence.intake', array('empty'=>'Please select','options'=> $resultOfSubCategory, 'id' => 'intake',
												'selected'=>$getDataLab['LaboratoryToken']['frequency_l'],'label'=>false,'class'=>'validate[required,custom[mandatory-select]]' ));?>
						</td>
					</tr>
					<tr>
						<td align="right" style="padding-right: 10px; padding-top: 10px"
							colspan="4"><?php
							echo  $this->Js->link('<input type="button" value="Add" class="blueBtn" id="submit3">',"#",
 array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('hide', array('buffer' => false)),'update'=>'#resultorder', 
'data' => '{finddata:$("#finddata").val(),patientid:$("#patientid").val(),category:$("#category").val(),intake:$("#intake").val()}','dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();
				?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<div align="center" id='busy-indicator' style="display: none;">
			&nbsp;
			<?php echo $this->Html->image('indicator.gif', array()); ?>
		</div>
		<?php }
	else {?>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<th colspan="4" style="margin-top: 10px;">Add new Order Sentence</th>
		</tr>

		<?php echo $this->Form->hidden('OrderSentence.allData',array('value'=>$allData,'id'=>'allData'));?>
		<?php echo $this->Form->hidden('PatientOrder.patient_id',array('value'=>$patient_id,'id'=>'patient_id'));?>
		<?php echo $this->Form->hidden('PatientOrder.name',array('value'=>'','id'=>'name'));?>
		<?php echo $this->Form->hidden('PatientOrder.location_id',array('value'=>$this->Session->read('locationid')));?>

		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxspace">
				<table width="100%" border="0">
					<tr>
					
					
					<tr>
						<td><div id='labCheck' style='display: none'>
								<font color='red'>Please check the validations.</font>
							</div></td>
					</tr>
					<td><?php echo __('Collection Priority',true); ?><font color="red">*</font>
					</td>
					<td><?php echo $this->Form->input('RadiologyTestOrder.collection_priority', array('empty'=>'Please select','options'=> Configure :: read('collection_priority'), 'id' => 'collection_priority','selected'=>$collection_priority,'label'=>false,'class'=>'validate[required,custom[mandatory-select]]' ));?>
					</td>
					<td valign="top"><?php echo __('Reason for exam - DCP',true); ?><font
						color="red">*</font>
					</td>
					<td valign="top"><?php echo $this->Form->input('RadiologyTestOrder.reason_exam', array('empty'=>'Please select','options'=> Configure :: read('reason_exam'), 'id' => 'reason_exam','width'=> '100%','selected'=>$reason_exam,'label'=>false,'class'=>'textBoxExpnd' ));?>
					</td>
					</tr>
					<tr>
						<td valign="top"><?php echo __('Start Date',true); ?>
						</td>
						<td valign="top"><?php echo $this->Form->input('RadiologyTestOrder.Start_date', array('type'=>'text','id'=>'start_date_rad','label'=>false));?>
						</td>
					</tr>
					<tr>
						<td align="right" style="padding-right: 10px; padding-top: 10px"
							colspan="4"><?php
							echo  $this->Js->link('<input type="button" value="Add" class="blueBtn" id="submit4">',"#",
 array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('hide', array('buffer' => false)),'update'=>'#resultorder', 'data' => '{finddata:$("#finddata").val(),patientid:$("#patientid").val(),category:$("#category").val()}','dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();
				?>
						</td>
					</tr>

				</table>
				<div align="center" id='busy-indicator' style="display: none;">
					&nbsp;
					<?php echo $this->Html->image('indicator.gif', array()); ?>
				</div>
			</td>
		</tr>
		<?php }?>
	</table>
	<?php echo $this->Form->end();?>



</body>

</html>
<script>

var lastClickedElement = parent.lastClickedElement;
var clickName=$(lastClickedElement).find('input:hidden:first').attr('value')+"-"+"Select Order Sentence";
var name=$(lastClickedElement).find('input:hidden:first').attr('value');
$("#showName").html(clickName);
$("#name").val(name);
		$(document).ready(function(){
			

		if('<?php echo $_SESSION['issave'] == '1'?>'){
		alert('Order Saved Succesfully. Please click on "Done" button to complete your order');
		parent.$.fancybox.close();
	}
			$("#start_date")
			.datepicker(
					{
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						'float':'right',
						yearRange : '-73:+0',
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',

					});

			
			$("#start_date_rad")
			.datepicker(
					{
						showOn : "button",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						'float':'right',
						yearRange : '-73:+0',
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',

					});
			$("#submit1").click(function(){
				
		//parent.$.fancybox.close();
				});
				//$("#mySubmit").click(function(){
				//	var radivalue = $("input[type='radio'][name='radioId']:checked").val();
				//	var key=$("#keyclick").val();
				//	var myval=$( '#prob'+key, parent.document ).val(radivalue);
				//	parent.$.fancybox.close();
				//	});
			$("#submit2").click(function(){
				
				var specimen_type_id=$("#specimen_type_id").val();
				var collection_priority=$("#collection_priority").val();
				var collected_date=$("#collected_date").val();
				var frequency_l=$("#frequency_l").val();
				var allData=$("#allData").val();
				var splitData = allData.split('~~');
			
				if(specimen_type_id==''||specimen_type_id===undefined||collection_priority==''||collection_priority===undefined){
					$('#labCheck').show();
					return;
				}
				var splitData = allData.split('~~');
					  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "AddNewOrderSet","admin"=>false)); ?>"+"/"+allData;
						//alert(ajaxUrl);
								$.ajax({
									type : "POST",
									data:$('#OrderSentence').serialize(),
									url : ajaxUrl , 
									//context : document.body,
									success: function(data){
								
									location.href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "ordersentence")); ?>"+"/"+splitData[0]+"/"+splitData[1]+"/"+splitData[2]+"/"+0;
										},
									
									error: function(message){
									alert(message);
									}
									
								});
				});
$("#submit3").click(function(){
				
				var specimen_type_id=$("#specimen_type_id").val();
				var collection_priority=$("#collection_priority").val();
				var allData=$("#allData").val();
				var splitData = allData.split('~~');
				if(specimen_type_id==''||specimen_type_id===undefined||collection_priority==''||collection_priority===undefined){
					$('#labCheck').show();
					return;
				}
				var collected_date=$("#collected_date").val();
				var frequency_l=$("#frequency_l").val();
				var allData=$("#allData").val();
				var splitData = allData.split('~~');
					  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "AddNewOrderSet","admin"=>false)); ?>"+"/"+allData;
						//alert(ajaxUrl);
								$.ajax({
									type : "POST",
									data:$('#OrderSentence').serialize(),
									url : ajaxUrl , 
									//context : document.body,
									success: function(data){
										//window.location.reload="<?php echo $this->Html->url(array("controller" => "patients", "action" => "orders")); ?>" +"/"+id+"/"+2
										location.href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "ordersentence")); ?>"+"/"+splitData[0]+"/"+splitData[1]+"/"+splitData[2]+"/"+0;
										},
									
									error: function(message){
									alert(message);
									}
									
								});
				});
$("#submit4").click(function(){
	
	var specimen_type_id=$("#reason_exam").val();
	var collection_priority=$("#collection_priority").val();
	var collected_date=$("#collected_date").val();
	var frequency_l=$("#frequency_l").val();
	var allData=$("#allData").val();
	if(specimen_type_id==''||specimen_type_id===undefined||collection_priority==''||collection_priority===undefined){
		$('#labCheck').show();
		return;
	}
	var splitData = allData.split('~~');
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "AddNewOrderSet","admin"=>false)); ?>"+"/"+allData;
			//alert(ajaxUrl);
					$.ajax({
						type : "POST",
						data:$('#OrderSentence').serialize(),
						url : ajaxUrl , 
						//context : document.body,
						success: function(data){
							//window.location.reload="<?php echo $this->Html->url(array("controller" => "patients", "action" => "orders")); ?>" +"/"+id+"/"+2
							location.href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "ordersentence")); ?>"+"/"+splitData[0]+"/"+splitData[1]+"/"+splitData[2]+"/"+0;
	
		
								},
						
						error: function(message){
						alert(message);
						}
						
					});
	});
			});
		
 
</script>
