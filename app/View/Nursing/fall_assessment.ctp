<style>
#busy-indicator {
    display: none;
    left: 50%;
    margin-top: 225px;
    position: absolute;
}
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
.tddate img{float:inherit;}
</style>
<div class="inner_title">
	<h3><?php echo __('Fall Assessment'); ?></h3>
	<span><?php echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'patient_information/',$this->params['pass'][0]), array('escape' => false,'class'=>'blueBtn'));?></span>
	</div>

<div class="clr ht5"></div>
<form name="itemfrm" id="itemfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "fall_assessment/".$this->params['pass'][0])); ?>" method="post" >

<?php echo $this->element('patient_information');?>
  
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php $options = array('Yes' => 'Yes', 'No' => 'No');?>
   <!-- two column table start here -->
 <div id = "formTable">
  
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="row" align="center">
  <tr>
	<td width="2%" height="35" valign="middle" align="" ><span id="dateLabel">Date of Fall<font color="red">*</font>&nbsp;</span></td>
	<td width="6%" align="left" valign="middle" class="tddate"><span id="first_date"><?php 
			//echo $this->Form->input('FallAssessment.date', array('type'=>'text','id'=>'date','label'=> false, 'div' => false, 'error' => false,'style'=>'width:150px;','readonly'=>'readonly','onchange'=> $this->Js->request(array('action' => 'fall_assessment','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#formTable', 'data' => '{date:$("#date").val(),patient_id:'.$this->params['pass'][0].'}', 'dataExpression' => true, 'div'=>false))));
		
			echo $this->Form->input('FallAssessment.date', array('type'=>'text','id'=>'date','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class'=> 'validate[required,custom[mandatory-date]] textBoxExpnd'));?>
		</span>
	
	</td>
	<td colspan="3" width="17%"valign="middle" class="tddate"><?php echo $this->Form->checkbox('previousRecord', array('id' => 'previousRecord','label'=>false,'div'=>false,'onclick'=>'getChanged(this.id);')); ?>&nbsp;Date of Previous Fall&nbsp;<span id="second_date"><?php echo $this->Form->input('FallAssessment.datePrevious', array('type'=>'text','id'=>'previousDate','label'=> false, 'div' => false, 'error' => false,'style'=>'width:150px;','readonly'=>'readonly','onchange'=> $this->Js->request(array('action' => 'fall_assessment','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#formTable', 'data' => '{date:$("#previousDate").val(),patient_id:'.$this->params['pass'][0].'}', 'dataExpression' => true, 'div'=>false))));?></span></td>
  </tr>
</table>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center" id="formTable">
	<tr>
		<th width="6%" align="center">Sr. No.</th>	
		<th width="20%" align="center">Terms</th>
		<th width="30%" align="center">Values</th>
		<th width="2%" align="center">Score</th>
	</tr>
	<tr>
	 <td align="center">1</td>
	  <td> History Of Falling</td>
	  <td style="padding-left:21px;"><?php echo $this->Form->radio('FallAssessment.history',$options,array('id'=>'NursingHistory','legend'=>false,'label'=>false,'checked','onClick'=>'getChecked();'));?></td>
	  <td><?php echo $this->Form->input('FallAssessment.history_score',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','readonly'=>'readonly'));?></td>                   		  
	</tr>
	<tr>
	  <td align="center">2</td>
	  <td>Secondary Diagnosis</td>
	  <td style="padding-left:21px;"><?php echo $this->Form->radio('FallAssessment.secondary_diagnosis',$options,array('id'=>'secondary_diagnosis','legend'=>false,'label'=>false,'checked','onClick'=>'getChecked();'));?></td>
	  <td><?php echo $this->Form->input('FallAssessment.secondary_diagnosis_score',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','readonly'=>'readonly'));?></td>                   		  
	</tr>
	<tr>
	  <td align="center">3</td>
	  <td>Ambulatory Aid </td>
	  <td><table width="65%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><input id="ambulatory_one" type="radio" class="textBoxExpnd" value="non_bed_rest_nurse_assist" name="data[FallAssessment][ambulatory_aid]" checked onClick="getChecked();"/></td>
				<td width="189">None/Bed Rest/Nurse Assist</td>
			</tr>
			 <tr>
			   <td width="29"><input id="ambulatory_two" type="radio" class="textBoxExpnd" value="crutches_cane_walker" name="data[FallAssessment][ambulatory_aid]" onClick="getChecked();"/></td>
				<td>Crutches/Cane/Walker</td>
			 </tr>
			 <tr>
			   <td width="29"><input id="ambulatory_three" type="radio" class="textBoxExpnd" value="furniture" name="data[FallAssessment][ambulatory_aid]" onClick="getChecked();"/></td>
				<td>Furniture</td>
			 </tr>
			
		  </table> </td>
	  <td><?php echo $this->Form->input('FallAssessment.ambulatory_aid_score',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','readonly'=>'readonly'));?></td>                   		  
	</tr>
	<tr>
	  <td align="center">4</td>
	  <td>IV or IV Access</td>
	  <td style="padding-left:21px;"><?php echo $this->Form->radio('FallAssessment.access',$options,array('legend'=>false,'label'=>false,'checked','onClick'=>'getChecked();'));?></td>
	  <td><?php echo $this->Form->input('FallAssessment.access_score',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','readonly'=>'readonly'));?></td>                   		  
	</tr>
	<tr>
	  <td align="center">5</td>
	  <td>Gait</td>
	  <td><table width="233" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><input id="gait_one" type="radio" class="textBoxExpnd" value="Normal_bed_rest_wheelchair" name="data[FallAssessment][gait]" checked onClick="getChecked();"/></td>
				<td width="191">Normal/Bed Rest/Wheelchair</td>
			</tr>
			 <tr>
			   <td width="27"><input id="gait_two" type="radio" class="textBoxExpnd" value="week" name="data[FallAssessment][gait]" onClick="getChecked();"/></td>
				<td>Weak</td>
			 </tr>
			 <tr>
			   <td width="27"><input id="gait_three" type="radio" class="textBoxExpnd" value="impaired" name="data[FallAssessment][gait]" onClick="getChecked();"/></td>
				<td>Impaired</td>
			 </tr>
			
		  </table>  </td>
	  <td><?php echo $this->Form->input('FallAssessment.gait_score',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','readonly'=>'readonly'));?></td>                   		  
	</tr>
	<tr>
	  <td align="center">6</td>
	  <td>Mental status </td>
	  <td><table width="245" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><input id="mental_status_one" type="radio" class="textBoxExpnd" value="oriented_to_own_ability" name="data[FallAssessment][mental_status]" checked onClick="getChecked();"/></td>
				<td width="217">Oriented to own ability</td>
			</tr>
			 <tr>
			   <td width="28"><input id="mental_status_two" type="radio" class="textBoxExpnd" value="overestimates_or_forgets_limitations" name="data[FallAssessment][mental_status]" onClick="getChecked();"/></td>
				<td>Overestimates or forgets limitations</td>
			 </tr>
			
		  </table></td>
	  <td><?php echo $this->Form->input('FallAssessment.mental_status_score',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','readonly'=>'readonly'));?></td>                   		  
	</tr>
		
   </table>		
	<!-- two column table end here -->
	<div class="ht5">&nbsp;</div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="tdLabel1">
		<tr>
			<td width="33%" height="28"  valign="middle"><strong>Total Score :</strong> <?php
			 echo $this->Form->input('FallAssessment.total_score',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;',
			 'readonly'=>'readonly'));?></td>
			 
			<td width="50%" height="28"  valign="middle"><strong>Risk Level :</strong>
				<?php echo $this->Form->input('FallAssessment.risk_level',array('legend'=>false,'label'=>false,'div'=>false,
				'class'=>' ','readonly'=>'readonly'));?>
			</td>
		</tr> 
	</table>
	<div class="clr ht5"></div>
	<div class="btns" style="">
		   <input name="" type="submit" id ="submit"  value="Save" class="blueBtn" onClick="return getValidate();" style="padding:5px;12px;"/>
		  
		   
		   <?php $this->Form->hidden('savTotal',array('id'=>'saveTotal','legend'=>false,'label'=>false,'div'=>false,'value'=>''));?>
	 </div>
	<div class="clr ht5"></div>
   <!-- Right Part Template ends here -->
   </td>
   
</table>
</form>
<!-- Left Part Template Ends here -->

</div>  
<script>
$(document).ready(function(){
	$('#second_date').hide('fast');
	$('#FallAssessmentTotalScore').val(0);
  //For History		
	if(document.getElementById('NursingHistoryNo').checked){		
		$("#FallAssessmentHistoryScore").val(0);
	} else {		
		$("#FallAssessmentHistoryScore").val(25);
	}
  //Seconday Diagnosis
	if(document.getElementById('SecondaryDiagnosisNo').checked){
		$("#FallAssessmentSecondaryDiagnosisScore").val(0);
	} else {
		$("#FallAssessmentSecondaryDiagnosisScore").val(25);
	}
  // For Ambulatory Aid
	if(document.getElementById('ambulatory_one').checked){
		$("#FallAssessmentAmbulatoryAidScore").val(0);
	} else if(document.getElementById('ambulatory_two').checked){
		$("#FallAssessmentAmbulatoryAidScore").val(15);
	} else if(document.getElementById('ambulatory_three').checked){
		$("#FallAssessmentAmbulatoryAidScore").val(30);
	}
  // IV or IV access
	if(document.getElementById('FallAssessmentAccessNo').checked){
		$("#FallAssessmentAccessScore").val(0);
	} else {
		$("#FallAssessmentAccessScore").val(20);
	}
  //For Gait
	if(document.getElementById('gait_one').checked){
		$("#FallAssessmentGaitScore").val(0);
	} else if(document.getElementById('gait_two').checked){
		$("#FallAssessmentGaitScore").val(10);
	} else if(document.getElementById('gait_three').checked){
		$("#FallAssessmentGaitScore").val(20);
	}
   //For Mental Status
	if(document.getElementById('mental_status_one').checked){
		$("#FallAssessmentMentalStatusScore").val(0);
	} else if(document.getElementById('mental_status_two').checked){
		$("#FallAssessmentMentalStatusScore").val(10);
	}
})

// To asign values on check
function getChecked(){
	if(document.getElementById('NursingHistoryNo').checked){
		$("#FallAssessmentHistoryScore").val(0);
	} else {
		
		$("#FallAssessmentHistoryScore").val(25);
	}
  //Seconday Diagnosis
	if(document.getElementById('SecondaryDiagnosisNo').checked){
		$("#FallAssessmentSecondaryDiagnosisScore").val(0);
	} else {
		$("#FallAssessmentSecondaryDiagnosisScore").val(25);
	}
  // For Ambulatory Aid
	if(document.getElementById('ambulatory_one').checked){
		$("#FallAssessmentAmbulatoryAidScore").val(0);
	} else if(document.getElementById('ambulatory_two').checked){
		$("#FallAssessmentAmbulatoryAidScore").val(15);
	} else if(document.getElementById('ambulatory_three').checked){
		$("#FallAssessmentAmbulatoryAidScore").val(30);
	}
  // IV or IV access
	if(document.getElementById('FallAssessmentAccessNo').checked){
		$("#FallAssessmentAccessScore").val(0);
	} else {
		$("#FallAssessmentAccessScore").val(20);
	}
  //For Gait
	if(document.getElementById('gait_one').checked){
		$("#FallAssessmentGaitScore").val(0);
	} else if(document.getElementById('gait_two').checked){
		$("#FallAssessmentGaitScore").val(10);
	} else if(document.getElementById('gait_three').checked){
		$("#FallAssessmentGaitScore").val(20);
	}
   //For Mental Status
	if(document.getElementById('mental_status_one').checked){
		$("#FallAssessmentMentalStatusScore").val(0);
	} else if(document.getElementById('mental_status_two').checked){
		$("#FallAssessmentMentalStatusScore").val(10);
	}

	var total = parseInt($("#FallAssessmentHistoryScore").val()) + parseInt($("#FallAssessmentSecondaryDiagnosisScore").val()) + parseInt($("#FallAssessmentAmbulatoryAidScore").val()) + parseInt($("#FallAssessmentAccessScore").val()) +
	parseInt($("#FallAssessmentGaitScore").val()) +
	parseInt($("#FallAssessmentMentalStatusScore").val());

	$('#FallAssessmentTotalScore').val(total);
	if(total <=24){
		risk_level = 'Low Risk Level';
	 } else if(total >= 25  && total <= 44){		
		risk_level = 'Medium Risk Level';	
	 } else if(total >=45){
		risk_level = 'Highest Risk Level';
	 }
	$('#FallAssessmentRiskLevel').val(risk_level);
}

// To validate the form
function getValidate(){
	if($('#date').val() == ''){
	//	alert('Please select date.');
		return false;
	}
}

$(document).ready(function(){

	jQuery("#itemfrm").validationEngine({
	validateNonVisibleFields: true,
	updatePromptsPosition:true,
	});
	$('#submit')
	.click(
	function() { 
	//alert("hello");
	var validatePerson = jQuery("#itemfrm").validationEngine('validate');
	//alert(validatePerson);
	if (validatePerson) {$(this).css('display', 'none');}
	return false;
	});
	});


$(function () {	
			 var daysToEnable = <?php echo json_encode($arrayDate); ?>;	
	// This is for datepicker
	 $("#date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			beforeShowDay: disableSpecificDates,
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
			minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>)
		});

	
			//alert(daysToEnable);
            $('#previousDate').datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				maxDate: new Date(),
                beforeShowDay: enableSpecificDates,
               dateFormat:'<?php echo $this->General->GeneralDate();?>',
            });
 
	//Function created to collect previous dates only. Return true if date found and false to hide date not in table
            function enableSpecificDates(date) {
                var month = date.getMonth();
                var day = date.getDate();
                var year = date.getFullYear();
                for (i = 0; i < daysToEnable.length; i++) {
                    if ($.inArray((month + 1) + '-' + day + '-' + year, daysToEnable) != -1) {
                        return [true];
                    }
                }
                return [false];
            }

	//Disable specific days
		 function disableSpecificDates(date) {
                var month = date.getMonth();
                var day = date.getDate();
                var year = date.getFullYear();
                for (i = 0; i < daysToEnable.length; i++) {
                    if ($.inArray((month + 1) + '-' + day + '-' + year, daysToEnable) != -1) {
                        return [false];
                    }
                }
                return [true];
            }
        });

	function getChanged(id){
		$('.message').hide('fast');
		if(document.getElementById('previousRecord').checked){
			//alert($('#first_date').innerHtml);
			$('#first_date').hide('slow');
			$('#dateLabel').hide('slow');
			$('#submit').hide('slow');
			$('#second_date').show('fast');

		} else {
			$('#first_date').show('fast');
			$('#dateLabel').show('fast');
			$('#second_date').hide('slow');
			$('#submit').show('fast');
		}
	}
</script>

