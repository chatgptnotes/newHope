<style>
.td_cell {
	font-size: 13px;
}
</style>
<?php
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');

if($status == "success"){?>
<script> 
			jQuery(document).ready(function() { 
			parent.$.fancybox.close(); 
		});
		</script>
<?php   } ?>
<style>
.tabularForm td td {
	padding: 0px;
	font-size: 13px;
	color: #e7eeef;
	background: #1b1b1b;
}

.tabularForm th td {
	padding: 0px;
	font-size: 13px;
	color: #e7eeef;
	background: none;
}

.death-textarea {
	width: 400px;
}

.tabularForm td td.hrLine {
	background: url(../img/line-dot.gif) repeat-x center;
}

.tabularForm td td.vertLine {
	background: url(../img/line-dot.gif) repeat-y 0 0;
}
</style>
<!-- Right Part Template -->
<div class="inner_title">
	<h3 style="font-size: 13px; margin-left: 5px; padding-left: 20px;">
		<?php echo __('Edit Immunization'); ?>

	</h3>
</div>
<?php 

		 echo $this->element('patient_information');  

	  ?>
<?php echo $this->Form->create('Immunization',array('id'=>'Immunization','url'=>array('controller'=>'imunization','action'=>'edit',$patient_id,$id),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
echo $this->Form->hidden('type',array('value'=>'','name'=>'expString','id'=>'expString'));
echo $this->Form->hidden('patient_id',array('value'=>$editData['Immunization']['patient_id'],'type'=>'text'));
echo $this->Form->hidden('id',array('value'=>$editData['Immunization']['id'],'type'=>'text'));
echo $this->Form->hidden('sbar',array('value'=>$sbarFlag));
?>
<table width="40%" border="0" cellspacing="1" cellpadding="3"
	class="tbl" style="border: 1px solid #ccc; padding: 0 20px;"
	align="center">
	<tr>
		<td class="td_cell" style="padding-top: 10px;" width="20%">Administration Notes :</td>
		<td width="3%"><?php
		echo $this->Form->hidden('patient_id',array('value'=>$editData['Immunization']['patient_id'],'type'=>'text'));
		echo $this->Form->hidden('id',array('value'=>$editData['Immunization']['id'],'type'=>'text'));

		echo $this->Form->input('admin_note', array('empty'=>__('Please Select'),'value'=>$editData['Immunization']['admin_note'],'readonly'=>'readonly','style'=>'width:270px;margin-top:10px;','options'=>$PhvsImmunizationInfo,'id' => 'admin_note','onchange'=>'javascript:Immunization();')); ?>
		</td>
	</tr>
	<tr>
		<td class="td_cell">Vaccine Administered :</td>
		<td class=""><?php
		echo $this->Form->input('vaccine_type', array('empty'=>__('Please Select'),'value'=>$editData['Immunization']['vaccine_type'],'id' => 'cptdescription','style'=>'width:270px', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options'=>$Imunization));
		?>
		</td>
	</tr>


	<!-- <tr>
		<td>Date/Time Start of Administration:</td>
		<td><?php 
		//echo $this->Form->input('date',array('class'=>'','id'=>'date_administered','type'=>'text'));
		?>
		</td>
	</tr> -->
	<?php 
	if($editData['Immunization']['admin_note'] == 1){
                        			$displayValue='blank';
                        		}else{
											$displayValue='none';
										}?>
	<tr style="display:<?php echo $displayValue ?>;">
		<td class="td_cell">Administered Amount :</td>

		<td><?php 
		echo $this->Form->input('amount',array('value'=>$editData['Immunization']['amount']));
		?>&nbsp;<span id='unit'>in<?php echo $this->Form->input('phvs_unitofmeasure_id', array('empty'=>__('Units'),'value'=>$editData['Immunization']['phvs_unitofmeasure_id'],'selected=selected','readonly'=>'readonly','style'=>'width:80px','options'=>$phvsMeasureOfUnit,'id' => 'Phvs_measureofunit')); ?>
		</span>
		
		</td>

	</tr>
	<tr id="provider">
		<td class="td_cell">Administering Provider :<?php //echo '<pre>';print_r($user);?>
		</td>
		<td><select name="data[Immunization][provider]" style="width: 270px">
				<option value="">Select User</option>

				<?php
				foreach($users as $key => $value){  //echo '<pre>';print_r($value);exit;
				?>
				<option value="<?php echo $value['User']['id'];?>"
				<?php if(isset($value) && $value['User']['id']==$editData['Immunization']['provider']){ echo " selected='selected'";}?>>
					<?php echo $value['User']['first_name']." ".$value['User']['last_name'];?>
					(
					<?php echo $value['Role']['name'];?>
					)
				</option>
				<?php
					}
					?>
		</select>
		
		</td>
	</tr>

	<tr id="lot_number">
		<td class="td_cell">Substance Lot Number :</td>
		<td><?php 
		echo $this->Form->input('lot_number',array('style'=>'width:270px','value'=>$editData['Immunization']['lot_number']));
		?>
		</td>
	</tr>
	<tr id="date">
		<td class="td_cell">Date/Time of Administration:</td>
		<td><?php 
		echo $this->Form->input('date',array('class'=>'date','style'=>'width:270px;float:left;','type'=>'text','id'=>"my_date",'value'=>$this->DateFormat->formatDate2Local($editData['Immunization']['date'],Configure::read('date_format'),true)));
		?>
		</td>
	</tr>
	<tr id="expiry_date">
		<td class="td_cell">Substance Expiration Date:</td>
		<td><?php 
		echo $this->Form->input('expiry_date',array('style'=>'width:270px;float:left;','class'=>'date_administered_cal','type'=>'text','id'=>"expiry_date_ca",'value'=>$this->DateFormat->formatDate2Local($editData['Immunization']['expiry_date'],Configure::read('date_format'),true)));
		?>
		</td>
	</tr>


	<tr id='manufacture_name'>
		<td class="td_cell">Substance Manufacturer Name :</td>
		<td><?php 
		echo $this->Form->input('manufacture_name',array('empty'=>__('Please Select'),'value'=>$editData['Immunization']['manufacture_name'],'readonly'=>'readonly','style'=>'width:270px','options'=>$PhvsVaccinesMvx));
		?>
		</td>
	</tr>
	<tr id='route'>
		<td class="td_cell">Route :</td>
		<td><?php 
		echo $this->Form->input('route',array('empty'=>__('Please Select'),'value'=>$editData['Immunization']['route'],'readonly'=>'readonly','style'=>'width:270px','options'=>$PhvsAdminsRoute));
		?>
		</td>
	</tr>
	<tr id='admin_site'>
		<td class="td_cell">Administration Site :</td>
		<td><?php 
		echo $this->Form->input('admin_site',array('empty'=>__('Please Select'),'value'=>$editData['Immunization']['admin_site'],'readonly'=>'readonly','style'=>'width:270px','options'=>$PhvsAdminSite));
			
		?>
		</td>
	</tr>

	<tr id = "refusal_reason" style="display:<?php echo $displayValue ?>;">
		<td class="td_cell">Substance/Treatment Refusal Reason :</td>
		<td><?php 
		echo $this->Form->input('reason',array('empty'=>__('Please Select'),'style'=>'width:270px','options'=>$nipCode003,'selected' => $editData['Immunization']['reason']));
		//echo $this->Form->input('reason',array('type'=>'textarea','value'=>$editData['Immunization']['reason']));
		?>
		</td>
	</tr>
	<tr id = 'registry_status' style="display:<?php echo $displayValue ?>;">
		<td class="td_cell">Immunization Registry Status :</td>
		<td><?php echo $this->Form->input('registry_status', array('empty'=>__('Please Select'),'value'=>$editData['Immunization']['registry_status'],'readonly'=>'readonly','style'=>'width:270px','options'=>$ImmunizationRegistryStatus)); ?>
		</td>
	</tr>
	<tr id = 'publicity_code' style="display:<?php echo $displayValue ?>;">
		<td class="td_cell">Publicity Code :</td>
		<td><?php 
		echo $this->Form->input('publicity_code',array('empty'=>__('Please Select'),'value'=>$editData['Immunization']['publicity_code'],'readonly'=>'readonly','style'=>'width:270px','options'=>$publicitycode));
			
		?>
		</td>
	</tr>
	<tr id='protection_indicator'>
		<td class="td_cell">Protection Indicator :</td>
		<td><?php 
		echo $this->Form->input('protection_indicator',array('readonly'=>'readonly','value'=>$editData['Immunization']['protection_indicator'],'style'=>'width:270px','options'=>array(''=>__('Please Select'),'Y'=>__('Yes'),'N'=>__('No'))));
			
		?>
		</td>
	</tr>
	<tr id='indicator_date'>
		<td class="td_cell">Protection Indicator Effective Date :</td>
		<td><?php 
		echo $this->Form->input('indicator_date',array('style'=>'width:270px;float:left;','class'=>'date_administered_cal','type'=>'text','value'=>$this->DateFormat->formatDate2Local($editData['Immunization']['indicator_date'],Configure::read('date_format'),true)));
		?>
		</td>
	</tr>
	<tr id='publicity_date' style="display:<?php echo $displayValue ?>;">
		<td class="td_cell">Publicity Code Effective Date :</td>
		<td><?php 
		echo $this->Form->input('publicity_date',array('style'=>'width:270px;float:left;','class'=>'date_administered_cal','type'=>'text','id'=>"publicity_date_ca",'value'=>$this->DateFormat->formatDate2Local($editData['Immunization']['publicity_date'],Configure::read('date_format'),true)));
		?>
		</td>
	</tr>
	<tr id='registry_date' style="display:<?php echo $displayValue ?>;">
		<td class="td_cell">Registry Status Effective Date :</td>
		<td><?php 
		echo $this->Form->input('registry_status_date',array('style'=>'width:270px;float:left; ','class'=>'date_administered_cal','type'=>'text','id'=>"registry_date_ca",'value'=>$this->DateFormat->formatDate2Local($editData['Immunization']['registry_status_date'],Configure::read('date_format'),true)));
		?>
		</td>
	</tr>
	<!-- <tr>
		<td>Entered By :</td>
		<td><?php 
		// echo $this->Form->input('entered_by',array('type'=>'text'));
			
		?></td>
	</tr>
	<tr>
		<td>Ordered By :</td>
		<td><?php 
		// echo $this->Form->input('ordered_by',array('type'=>'text'));
			
		?></td>
	</tr> -->
	<tr id = 'funding_category' style="display:<?php echo $displayValue ?>;">
		<td class="td_cell">Vaccine funding program eligibility category :</td>
		<td><?php 
		echo $this->Form->input('funding_category',array('empty'=>__('Please Select'),'readonly'=>'readonly','style'=>'width:270px','options'=>$PhvsObservationIdentifier,'value'=>$editData['Immunization']['funding_category']));

		?>
		</td>
	</tr>
	<?php $vaccineAdmin = explode('|',$editData['Immunization']['vaccin_single_code']);
	$vaccineDate = explode('|',$editData['Immunization']['published_date']);
	$vaccineName = explode('-',$Imunization[$editData['Immunization']['vaccine_type']]);
	?>
	<?php for($i=0;$i<count($vaccineAdmin);$i++){?>
	<?php $cntVar = ($i == 0) ? 'undefined' : $i-1;?>
	<tr id="vaccine_type_dynamic_<?php echo $cntVar; ?>"
		class="dynamicHtml">
		<td class="td_cell">Vaccine Administered <?php echo $vaccineName[$i];?>:
		</td>
		<td class="td_cell"><?php
		echo $this->Form->input("vaccine_type_$cntVar", array('empty'=>__('Please Select'),'id' => "cptdescription_$cntVar",'style'=>'width:270px',
			 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options'=>$Imunization,'value'=>trim($vaccineAdmin[$i])));
		?>
		</td>
	</tr>
	<?php $className = ($i == 0) ? '' : 'class="dynamicHtml"';?>
	<tr id="published_date_<?php echo $i;?>" <?php echo $className;?>>
		<td class="td_cell" id="published_name">Vaccine Information published
			date for <?php echo $vaccineName[$i];?>:
		</td>
		<td class="td_cell"><?php echo $this->Form->input("Published.published_date_name$i",array('type'=>'text','style'=>"width: 270px;float:left;",'id'=>"published_date_name$i",
				'class'=>'datePublished','value'=>trim($vaccineDate[$i])));?>
		</td>
	</tr>
	<?php } ?>
	<!-- 
	<tr>
		<td class="td_cell">Presented Date :</td>
		<td><?php 
		echo $this->Form->input('presented_date',array('style'=>'width:270px;float:left;','class'=>'date_administered_cal','type'=>'text','id'=>"newval",'value'=>$this->DateFormat->formatDate2Local($editData['Immunization']['presented_date'],Configure::read('date_format'),true)));
		?>
		</td>
	</tr> -->
	<tr id='observation_date' style="display:<?php echo $displayValue ?>;">
		<td class="td_cell">Date/Time of Observation :</td>
		<td><?php 
		echo $this->Form->input('observation_date',array('style'=>'width:270px;float:left;','class'=>'date_administered_cal','type'=>'text','id'=>"observation_date_ca",'value'=>$this->DateFormat->formatDate2Local($editData['Immunization']['observation_date'],Configure::read('date_format'),true)));
		?></td>
	</tr>
	<tr id = 'observation_method' style="display:<?php echo $displayValue ?>;">
		<td class="td_cell">Observation Method :</td>
		<td><?php 
		echo $this->Form->input('observation_method',array('readonly'=>'readonly','style'=>'width:270px','value'=>$editData['Immunization']['observation_method'],'options'=>array(''=>__('Please Select'),'Eligibility captured at the immunization level'=>__('Eligibility captured at the immunization level'),'Eligibility captured at the visit level'=>__('Eligibility captured at the visit level'))));
			
		?>
		
		</td>
	</tr>
	<tr id = 'observation_value' style="display:<?php echo $displayValue ?>;">
		<td class="td_cell">Observation value :</td>
		<td><?php 
		echo $this->Form->input('observation_value',array('empty'=>__('Please Select'),'value'=>$editData['Immunization']['observation_value'],'readonly'=>'readonly','style'=>'width:270px','options'=>$PhvsFinancialClass));

		?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left"><?php 
		//echo $this->Form->submit('Submit And Add More',array('name'=>'submitandaddmore','class'=>'blueBtn','id'=>'submitandaddmore','div'=>false,'label'=>false));
		echo $this->Form->hidden('parent_id',array('value'=>$parent_id,'type'=>'text'));?>
		</td>
		<td align="right" style="padding-right:28px; padding-bottom: 20px;"><?php 
		if($initialAssessment != 'initialAssessment'){
			echo $this->Html->link(__('Cancel'), array('controller'=>'imunization','action' => 'index',$patient_id), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0 10px 0 0'));

		}else{
			echo $this->Html->link(__('Cancel'), array('controller'=>'imunization','action' => 'index',$patient_id,'?'=>array('pageView'=>"ajax")), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0 10px 0 0'));
		}
		echo $this->Form->submit('Submit',array('class'=>'blueBtn','id'=>'submit','div'=>false,'label'=>false,'onclick'=>'implodeString()'));
		?>
		</td>
	</tr>

</table>
<?php 
echo $this->Form->end();
?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div id="vaccineTypeDropDown" style="display: none">
	<?php
	echo $this->Form->input('data[VaccineType][vaccine_type_0]', array('empty'=>__('Please Select'),'id' => 'cptdescription_0','style'=>'width:270px', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options'=>$Imunization));
	?>
</div>
<script>
var dateText = '<tr><td class="td_cell">Vaccine Information published date :</td><td><?php echo $this->Form->input("Published.published_date_name",array("class"=>"datePublished","type"=>"text","id" =>"published_date_name"));?></td></tr>';
var newTest = '<tr><td class="td_cell">Vaccine Information published date :</td><td><input type="text" id="published_date_name" class="datePublished" name="data[Published][published_date_name2]"></td></tr>';
var vaccineDropDown = '<tr id="vaccine_type_dynamic_0" class="dynamicHtml"><td class="td_cell">Vaccine Administered #####NAME#####:</td><td class="td_cell">#####VACCINETYPE#####</td></tr>';
var vaccineDropDown1 = '<tr id="vaccine_type_dynamic_0" class="dynamicHtml"><td class="td_cell">Vaccine Administered #####NAME#####:</td><td class="td_cell">#####VACCINETYPE#####</td></tr>';
$('#cptdescription') .change(function (){
	$('.dynamicHtml').remove();
	$('#published_name').text('Vaccine Information published date');
	$('#published_date_name0').val('');
	vaccin_name = $('#cptdescription').text();
	public_name = $('#published_name').text();
	var e = document.getElementById("cptdescription");
	var strUser = e.options[e.selectedIndex].text;
	var vacc_ary = strUser.split("-");
	public_name = public_name.replace(public_name,"Vaccine Information published date for "+vacc_ary[0]+":");
	$('#published_name').html(public_name);
	 //ImmunizationFundingCategory
	if(vacc_ary.length > 0){
		vaccineDropDown = vaccineDropDown1;
		vaccineDropDown = vaccineDropDown.replace("#####VACCINETYPE#####",$("#vaccineTypeDropDown").html()); 
		vaccineDropDown = vaccineDropDown.replace("#####NAME#####",vacc_ary[0]); 
		vaccineDropDown = vaccineDropDown.replace("vaccine_type_dynamic_0","vaccine_type_dynamic_"+i); 
		vaccineDropDown = vaccineDropDown.replace("cptdescription_0","cptdescription_"+i);
		vaccineDropDown = vaccineDropDown.replace("vaccine_type_0","vaccine_type_"+i);
		$(vaccineDropDown).insertAfter("#funding_category");
	}
	for (var i = 0; i < vacc_ary.length-1; i++) {
		vaccineDropDown = vaccineDropDown1;
		vaccineDropDown = vaccineDropDown.replace("#####VACCINETYPE#####",$("#vaccineTypeDropDown").html()); 
		vaccineDropDown = vaccineDropDown.replace("vaccine_type_dynamic_0","vaccine_type_dynamic_"+i); 
		vaccineDropDown = vaccineDropDown.replace("#####NAME#####",vacc_ary[i+1]);
		vaccineDropDown = vaccineDropDown.replace("cptdescription_0","cptdescription_"+i);
		vaccineDropDown = vaccineDropDown.replace("vaccine_type_0","vaccine_type_"+(i+1));
		$(vaccineDropDown).insertAfter("#published_date_"+i);
		newText = '<tr class="td_cell vaccineTypeTr dynamicHtml" id="published_date_'+( i+1) +'"><td class="td_cell">Vaccine Information published date '+vacc_ary[i+1]+':</td><td class="td_cell"><input type="text" id="published_date_name_'+i+'" class="datePublished" style="width:270px" name="data[Published][published_date_name'+[i+1]+']"></td></tr>' ;
		$(newText).insertAfter("#vaccine_type_dynamic_"+i);
	};
});

function Immunization(){ 
	if($('#admin_note').val() !== '1' && $('#admin_note').val() !== ''){
		$("#Administered-Amount").hide();
		$("#provider").hide();
		$("#refusal_reason").hide(); 
		$("#registry_status").hide(); 
		$("#publicity_code").hide(); 
		$("#protection_indicator").hide(); 
		$("#indicator_date").hide(); 
		$("#publicity_date").hide(); 
		$("#registry_date").hide(); 
		$("#funding_category").hide();
		$("#published_date").hide(); 
		$("#presented_date").hide(); 
		$("#observation_date").hide(); 
		$("#observation_method").hide(); 
		$("#observation_value").hide();
		key = '';
		$('#unit').val(key);
	}else{
		$("#unit").show();
		$("#Administered-Amount").show();
		$("#provider").show();
		$("#lot_number").show();
		$("#expiry_date").show();
		$("#manufacture_name").show();
		$("#admin_site").show();
		$("route").show(); 
		$("#refusal_reason").show(); 
		$("#registry_status").show(); 
		$("#publicity_code").show(); 
		$("#protection_indicator").show(); 
		$("#indicator_date").show(); 
		$("#publicity_date").show(); 
		$("#registry_date").show(); 
		$("#funding_category").show();
		$("#published_date").show(); 
		$("#presented_date").show(); 
		$("#observation_date").show(); 
		$("#observation_method").show(); 
		$("#observation_value").show();
	}
}

//$(document).on('click','.date_administered_cal', function() {
	$('.date_administered_cal').datepicker({
		changeMonth : true,
		changeYear : true,
		yearRange : '1950',
		dateFormat:'<?php echo $this->General->GeneralDate("");?>',
		showOn : 'both',
		//maxDate : new Date(),
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		buttonText: "Calendar",
		onSelect : function() {
			$(this).focus();
		}
	});
//});
//$(document).on('click','.date', function() {	
	$('.date').datepicker({
		changeMonth : true,
		changeYear : true,
		yearRange : '1950',
		maxDate : new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
		showOn : 'both',
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		buttonText: "Calendar",
		onSelect : function() {
			$(this).focus();
		}
	});
	$('#expiry_date_ca').datepicker({
		changeMonth : true,
		changeYear : true,
		yearRange : '1950',
		//maxDate : new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
		showOn : 'both',
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		buttonText: "Calendar",
		onSelect : function() {
			$(this).focus();
		}
	});	

	$('.datePublished').datepicker({	
		showOn : "both",
		changeMonth : true,
		changeYear : true,
		yearRange: '1950',
		maxDate : new Date(),
	//	minDate : new Date(explode[0], explode[1] - 1,
	//			explode[2]),
		dateFormat : '<?php echo $this->General->GeneralDate();?>',					
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		onSelect : function() {
			$(this).focus();
		}
	});
//});
function implodeString(){
	cptdescription = $("#cptdescription option:selected").text();
	var cptdescriptionLen=cptdescription.split("-"); 
	finString = $("#cptdescription_undefined" ).val(); 
	for(i=0; i < cptdescriptionLen.length-1; i++){
		finString = finString + "|" + $("#cptdescription_" + i).val(); 
	}
	$("#expString").val(finString);
}
</script>
		