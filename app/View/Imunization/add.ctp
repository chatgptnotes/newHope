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
.tddate img{float:inherit;}

.tabularForm td td.hrLine {
	background: url(../img/line-dot.gif) repeat-x center;
}

.tabularForm td td.vertLine {
	background: url(../img/line-dot.gif) repeat-y 0 0;
}

.tbl{}
td{ font-size:13px;}
</style>
<!-- Right Part Template -->
<div class="inner_title">
<h3 style="font-size:13px; margin-left: 5px; padding-left:20px;">
	<?php echo __('Add Immunization'); ?>

</h3>
</div>
<?php  echo $this->element('patient_information');  ?>

<?php
if($sbarFlag == 'sbar'){
 	echo $this->Form->create('Immunization',array('id'=>'Immunization','url'=>array('controller'=>'imunization','action'=>'add','?'=>array('pageView'=>"ajax")),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
}else{
	echo $this->Form->create('Immunization',array('id'=>'Immunization','url'=>array('controller'=>'imunization','action'=>'add'),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
}
?>
<?php 
echo $this->Form->hidden('appointment_id',array('value'=>$appointment_id));
echo $this->Form->hidden('patient_id',array('value'=>$patient_id));
echo $this->Form->hidden('id',array());
echo $this->Form->hidden('sbar',array('value'=>$sbarFlag));
if($initialAssessment == 'initialAssessment'){
	echo $this->Form->hidden('initialAssessment',array('value'=>$initialAssessment));
}

?>


<table width="auto" border="0" cellspacing="1" cellpadding="3"
	class="tbl" style="border:1px solid #ccc; padding:20px;" align="center">
	<tr>
		<td width="49%">Administration Notes :</td>
		<td ><?php echo $this->Form->input('admin_note', array('empty'=>__('Please Select'),'readonly'=>'readonly','style'=>'width:289px','options'=>$PhvsImmunizationInfo,'id' => 'admin_note','onchange'=>'javascript:Immunization();')); ?></td>
	</tr>
	<tr>
		<td class="">Vaccine Administered :</td>
		<td class=""> <?php
		echo $this->Form->input('vaccine_type', array('empty'=>__('Please Select'),'id' => 'cptdescription','style'=>'width:289px', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options'=>$Imunization));
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
	<tr id='Administered-Amount'>
		<td>Administered Amount :</td>
		<td><?php 
		echo $this->Form->input('amount',array('style'=>'width:80px','id'=>'vaccineAmount'));
		?>&nbsp;<span id= 'unit'>in<?php echo $this->Form->input('phvs_unitofmeasure_id', array('empty'=>__('Units'),'readonly'=>'readonly','style'=>'width:190px;margin:0 0 0 5px;','options'=>$phvsMeasureOfUnit,'id' => 'Phvs_measureofunit')); ?></span> 
		</td>

	</tr>
	<tr id="provider">
		<td>Administering Provider :</td>
		<td><select name="data[Immunization][provider]"  style="width:289px">
				<option value="">Select User</option>
				<?php
				foreach($users as $key => $value){  
				?>
				<option value="<?php echo $value['User']['id'];?>" <?php if(isset($user) && $user[$model]['id']==$value[$model]['id']){ echo " selected=selected";}?>><?php echo $value['User']['first_name']." ".$value['User']['middle_name']." ".$value['User']['last_name'];?> </option>
				<?php
					}
				?>
				</select>
		</td>
	</tr>

	<tr id="lot_number">
		<td>Substance Lot Number :</td>
		<td><?php 
		echo $this->Form->input('lot_number',array('style'=>'width:289px'));
		?>
		</td>
	</tr>
	<tr id="date">
		<td>Date/Time Start of Administration:</td>
		<td><?php 
		echo $this->Form->input('date',array('style'=>'width:92%;float:left;','class'=>'date','type'=>'text','id'=>"my_date",'autocomplete'=>'off'));
		?>
		</td>
	</tr>
	<tr id="expiry_date">
		<td>Substance Expiration Date:</td>
		<td><?php 
		echo $this->Form->input('expiry_date',array('style'=>'width:92%;float:left;','class'=>'date_administered_cal1','type'=>'text','id'=>"expiry_date_ca",'autocomplete'=>'off'));
		?>
		</td>
	</tr>
	<tr id = 'manufacture_name'>
		<td>Substance Manufacturer Name :</td>
		<td><?php 
		echo $this->Form->input('manufacture_name',array('empty'=>__('Please Select'),'readonly'=>'readonly','style'=>'width:289px','options'=>$PhvsVaccinesMvx));
		?>
		</td>
	</tr>
	<tr id = 'route'>
		<td>Route :</td>
		<td><?php 
		echo $this->Form->input('route',array('empty'=>__('Please Select'),'readonly'=>'readonly','style'=>'width:289px','options'=>$PhvsAdminsRoute));
		?>
		</td>
	</tr>
	<tr id = 'admin_site'>
		<td>Administration Site :</td>
		<td><?php 
		echo $this->Form->input('admin_site',array('empty'=>__('Please Select'),'readonly'=>'readonly','style'=>'width:289px','options'=>$PhvsAdminSite));
			
		?></td>
	</tr>
	
	<tr id = "refusal_reason">
		<td>Substance/Treatment Refusal Reason :</td>
		<td><?php 
		
		echo $this->Form->input('reason',array('empty'=>__('Please Select'),'style'=>'width:289px','options'=>$nipCode003));
			
		
		//echo $this->Form->input('reason',array('type'=>'textarea'));
		?></td>
	</tr>
	<tr id = 'registry_status'>
		<td>Immunization Registry Status :</td>
		<td><?php echo $this->Form->input('registry_status', array('empty'=>__('Please Select'),'readonly'=>'readonly','style'=>'width:289px','options'=>$ImmunizationRegistryStatus)); ?>
		</td>
	</tr>
	<tr id = 'publicity_code'>
		<td>Publicity Code :</td>
		<td><?php 
		echo $this->Form->input('publicity_code',array('empty'=>__('Please Select'),'readonly'=>'readonly','style'=>'width:289px','options'=>$publicitycode));
			
		?></td>
	</tr>
	<tr id = 'protection_indicator'>
		<td>Protection Indicator :</td>
		<td><?php 
		echo $this->Form->input('protection_indicator',array('readonly'=>'readonly','style'=>'width:289px','options'=>array(''=>__('Please Select'),'Y'=>__('Yes'),'N'=>__('No'))));
			
		?></td>
	</tr>
	<tr id='indicator_date'>
		<td>Protection Indicator Effective Date :</td>
		<td><?php 
		echo $this->Form->input('indicator_date',array('style'=>'width:92%;float:left;','class'=>'date_administered_cal','type'=>'text','autocomplete'=>'off',));
		?>
		</td>
	</tr>
	<tr id='publicity_date'>
		<td>Publicity Code Effective Date :</td>
		<td><?php 
		echo $this->Form->input('publicity_date',array('style'=>'width:92%;float:left;','class'=>'date_administered_cal','type'=>'text','id'=>"publicity_date_ca",'readonly'=>'readonly'));
		?>
		</td>
	</tr>
	<tr id='registry_date'>
		<td>Registry Status Effective Date :</td>
		<td><?php 
		echo $this->Form->input('registry_status_date',array('style'=>'width:92%;float:left;','class'=>'date_administered_cal','type'=>'text','id'=>"registry_date_ca",'readonly'=>'readonly'));
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
	<tr id = 'funding_category'>
		<td>Vaccine funding program eligibility category :</td>
		<td><?php 
		echo $this->Form->input('funding_category',array('empty'=>__('Please Select'),'readonly'=>'readonly','style'=>'width:289px','options'=>$PhvsObservationIdentifier,'default'=>24));
		
		?></td>
	</tr>
	<?php ?>
	<tr id='published_date_0'>
		<td id ='published_name'>Vaccine Information published date :</td>
		<td><?php 
		echo $this->Form->input('Published.published_date_name0',array('style'=>'width:92%;float:left;','class'=>'datePublished','type'=>'text','id'=>"published_date_ca",'autocomplete'=>'off'));
		?>
		</td>
	</tr>
	<!-- 
  	<tr >
		<td>Presented Date :</td>
		<td><?php 
		//echo $this->Form->input('presented_date',array('style'=>'width:289px;float:left;','class'=>'','type'=>'text','id'=>"newval",'class'=>'date','autocomplete'=>'off'));
		?>
		</td>
	</tr> --> 
	<tr id='observation_date'>
		<td>Date vaccine information statement presented :</td>
		<td><?php 
		echo $this->Form->input('observation_date',array('style'=>'width:92%;float:left;','class'=>'date','type'=>'text','id'=>"observation_date_ca",'readonly'=>'readonly'));
		?>
		</td>
	</tr>
	<tr id = 'observation_method'>
		<td>Observation Method :</td>
		<td><?php 
		echo $this->Form->input('observation_method',array('readonly'=>'readonly','style'=>'width:289px','options'=>array(''=>__('Please Select'),'Eligibility captured at the immunization level'=>__('Eligibility captured at the immunization level'),'Eligibility captured at the visit level'=>__('Eligibility captured at the visit level'))));
			
		?></td>
	</tr>
	<tr id = 'observation_value'>
		<td>Observation value :</td>
		<td><?php 
		echo $this->Form->input('observation_value',array('empty'=>__('Please Select'),'readonly'=>'readonly','style'=>'width:289px','options'=>$PhvsFinancialClass));
		
		?></td>
	</tr>
    <tr><td>&nbsp;</td></tr>
	<tr>
		<td align="left"><?php 
		echo $this->Form->hidden('type',array('value'=>'','name'=>'expString','id'=>'expString'));
		echo $this->Form->submit('Submit And Add More',array('name'=>'submitandaddmore','class'=>'blueBtn','id'=>'submitandaddmore','div'=>false,'label'=>false,'onclick'=>'implodeString()'));
		echo $this->Form->hidden('parent_id',array('value'=>$parent_id,'type'=>'text'));
		echo $this->Html->link(__('Add Vaccinations'), array('controller'=>'imunization','action' => 'vaccinationfuture',$patient_id), array('escape' => false,'class'=>'blueBtn'));?>
		</td>
		<td align="right"><?php 
		if($initialAssessment != 'initialAssessment' || $this->params->query['pageView'] != 'ajax'){
			echo $this->Html->link(__('Cancel'), array('controller'=>'imunization','action' => 'index',$patient_id), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
		}else{
			echo $this->Html->link(__('Cancel'), array('controller'=>'imunization','action' => 'index',$patient_id,'?'=>array('pageView'=>"ajax")), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
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
<div id="vaccineTypeDropDown" style="display:none"><?php
		echo $this->Form->input('data[VaccineType][vaccine_type_0]', array('empty'=>__('Please Select'),'id' => 'cptdescription_0','style'=>'width:289px', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options'=>$Imunization));
		?></div>
<!--  <div><a href="#" onclick="addMoreDates()">Add More</a></div>-->
<script>

var dateText = '<tr><td>Vaccine Information published date :</td><td><?php echo $this->Form->input("Published.published_date_name",array("class"=>"datePublished","type"=>"text","id" =>"published_date_name"));?></td></tr>';
var newTest = '<tr><td>Vaccine Information published date :</td><td><input type="text" id="published_date_name" class="datePublished" name="data[Published][published_date_name2]"></td></tr>';
var vaccineDropDown = '<tr id="vaccine_type_dynamic_0" class="dynamicHtml"><td class="">Vaccine Administered #####NAME#####:</td><td class="">#####VACCINETYPE#####</td></tr>';
var vaccineDropDown1 = '<tr id="vaccine_type_dynamic_0" class="dynamicHtml"><td class="">Vaccine Administered #####NAME#####:</td><td class="">#####VACCINETYPE#####</td></tr>';
$('#cptdescription') .change(
			function (){
				if( $('#admin_note').val() === '1' ){
				$('.dynamicHtml').remove();
				$('#published_name').text('Vaccine Information published date');
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

		       // $(".vaccineTypeTr").remove();
		        for (var i = 0; i < vacc_ary.length-1; i++) {
		        	/*dateText = dateText.replace("published_date_name","published_date_name"+(i+1));
		        	dateText = dateText.replace("Vaccine Information published date","Vaccine Information published date for "+vacc_ary[i+1]);
		        	$(dateText).insertAfter('#published_date_0'); 
		        	dateText = dateText.replace("published_date_name"+(i+1),"published_date_name");
		        	dateText = dateText.replace("published_date_name"+(i+1),"published_date_name");
		        	dateText = dateText.replace("Vaccine Information published date for "+vacc_ary[i+1],"Vaccine Information published date");*/

		        	vaccineDropDown = vaccineDropDown1;
		        	vaccineDropDown = vaccineDropDown.replace("#####VACCINETYPE#####",$("#vaccineTypeDropDown").html()); 
		        	vaccineDropDown = vaccineDropDown.replace("vaccine_type_dynamic_0","vaccine_type_dynamic_"+i); 
		        	vaccineDropDown = vaccineDropDown.replace("#####NAME#####",vacc_ary[i+1]);
		        	vaccineDropDown = vaccineDropDown.replace("cptdescription_0","cptdescription_"+i);
		        	vaccineDropDown = vaccineDropDown.replace("vaccine_type_0","vaccine_type_"+(i+1));

		        	
		        	
		        	$(vaccineDropDown).insertAfter("#published_date_"+i);

		        	newText = '<tr class="vaccineTypeTr dynamicHtml" id="published_date_'+( i+1) +'"><td>Vaccine Information published date '+vacc_ary[i+1]+':</td><td><input type="text" id="published_date_name_'+i+'" class="datePublished" name="data[Published][published_date_name'+[i+1]+']"></td></tr>' ;
		        	$(newText).insertAfter("#vaccine_type_dynamic_"+i);
		        	
		    		
		        };
		        $('.datePublished').datepicker({	
					showOn : "both",
					changeMonth : true,
					changeYear : true,
					yearRange: firstYr+':'+lastYr,
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
				}
	});


function Immunization(){ 

	if($('#admin_note').val() !== '1' && $('#admin_note').val() !== ''){
		//$("#unit").hide();
		//$("#date").hide();
		$("#Administered-Amount").hide();
		$('#vaccineAmount').val('999');
		$("#provider").hide();
		$("#lot_number").hide();
		$("#published_date_0").hide();
		$("#manufacture_name").hide();
		$("#admin_site").hide();
		$("#route").hide(); 
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
	//	$('#unit,#provider,#lot_number,#expiry_date,#manufacture_name,#admin_site,#route,#refusal_reason').val('');
	//	$('#registry_status,#publicity_code,#protection_indicator,#indicator_date,#publicity_date,#registry_date,#funding_category').val('');
	//	$('#published_date,#presented_date,#observation_date,#observation_method,#observation_value').val('');
		key = '';
		$('#unit').val(key);
	}else{
		$("#unit").show();
		$("#date").show();
		$("#Administered-Amount").show();
		$('#vaccineAmount').val('');
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

var firstYr = new Date().getFullYear()-100;
var lastYr = new Date().getFullYear()+10;

	//$(".date_administered_cal").live("click",function() {
		//$(document).on('click','.date_administered_cal', function() {
		
		$('.date_administered_cal').datepicker({
					showOn : "both",	
					changeMonth : true,
					changeYear : true,
					yearRange: firstYr+':'+lastYr,
					//maxDate : new Date(),
				//	minDate : new Date(explode[0], explode[1] - 1,
				//			explode[2]),
					dateFormat : '<?php echo $this->General->GeneralDate("");?>',
					buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly : true,
					onSelect : function() {
						$(this).focus();
					}
				});
		$('#expiry_date_ca').datepicker({
			showOn : "both",	
			changeMonth : true,
			changeYear : true,
			yearRange: firstYr+':'+lastYr,
		//	maxDate : new Date(),
		//	minDate : new Date(explode[0], explode[1] - 1,
		//			explode[2]),
			dateFormat : '<?php echo $this->General->GeneralDate("");?>',
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			onSelect : function() {
				$(this).focus();
			}
		});
//});

//$(".date").live("click",function() {
	//$(document).on('click','.date', function() {
		$('.date').datepicker({	
					showOn : "both",
					changeMonth : true,
					changeYear : true,
					yearRange: firstYr+':'+lastYr,
					maxDate : new Date(),
				//	minDate : new Date(explode[0], explode[1] - 1,
				//			explode[2]),
					dateFormat : '<?php echo $this->General->GeneralDate("HH:II:SS");?>',					
					buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly : true,
					onSelect : function() {
						$(this).focus();
					}
				});
		$('.datePublished').datepicker({	
			showOn : "both",
			changeMonth : true,
			changeYear : true,
			yearRange: firstYr+':'+lastYr,
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


	/*	$(document).ready(function(){
	    	 
			$("#cptdescription").autocomplete("<?php // echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Imunization","cpt_description",'null','null',$this->Session->read('locationid'),'admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
				width: 289,
				selectFirst: true
			});
					
					
			 	});	*/
	 	
</script>
