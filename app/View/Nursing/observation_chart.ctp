<style>
.tddate img {
	float: inherit;
}
</style>
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

.tabularForm td td.hrLine {
	background: url(images/line-dot.gif) repeat-x center;
}

.tabularForm td td.vertLine {
	background: url(images/line-dot.gif) repeat-y 0 0;
}

#busy-indicator {
	display: none;
	left: 50%;
	margin-top: 250px;
	position: absolute;
}
</style>
<style>
td.highlight {
	background-color: #9400D3;
	border: 1px blue;
}
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}

</style>

<div class="inner_title">
	<h3>
		<?php echo __('Observation Chart'); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'observation_chart_list',$patient_id), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>

<div class="clr ht5"></div>
<form name="itemfrm" id="itemfrm"
	action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "observation_chart/".$this->params['pass'][0])); ?>"
	method="post">

	<table>
		<tr>
			<td align="right">Observation Date<font color="red">*</font> :
			</td>
			<td class="tddate"><?php echo $this->Form->input('ObservationChart.date', array('type'=>'text','id'=>'date','label'=> false,'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd', 'div' => false, 'error' => false,'style'=>'width:116;','readonly'=>'readonly','onchange'=> $this->Js->request(array('action' => 'observation_chart','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#itemfrm', 'data' => '{date:$("#date").val(),patient_id:'.$this->params['pass'][0].'}', 'dataExpression' => true, 'div'=>false))));?>
			</td>
			<td>&nbsp;</td>
			<td>Time<font color="red">*</font>



			</td>
			<td width="144px"><?php echo $this->Form->input('ObservationChart_1.time',array('id'=>'ObservationChart_1','legend'=>false,'label'=>false,'div'=>false,'class'=>'getselected textBoxExpnd','options'=>$timeSlots,'empty'=>'Select'));?>
			</td>
		</tr>

		<!-- <td align="right">Previous Observations Date : </td>
				<td>
					<?php echo $this->Form->input('previousDate', array('type'=>'text','id'=>'previousDate','label'=> false, 'div' => false, 'error' => false,'style'=>'width:150px;','readonly'=>'readonly','onchange'=> $this->Js->request(array('action' => 'observation_chart','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#itemfrm', 'data' => '{date:$("#previousDate").val(),patient_id:'.$this->params['pass'][0].'}', 'dataExpression' => true, 'div'=>false))));?>
				</td> -->
		</tr>

	</table>
	<div class="clr ht5"></div>
	<div id="updateForm">
		<table width='100%'>
			<tr>
				<td width='50%'>
					<table width='100%'>
						<tr>
							<th style="text-align: center;" colspan='2'><h2>Vital</h2>
							</th>
						</tr>

						<tr>
							<th width="19%" style="text-align: center;">Pulse</th>
							<td width="18%"><?php echo $this->Form->input('ObservationChart_1.pulse',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;'));?>bpm
							</td>
						</tr>
						<tr>
							<th width="19%" style="text-align: center;">R/R</th>
							<td width="18%"><?php echo $this->Form->input('ObservationChart_1.rr',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;'));?>bpm</td>
						</tr>
						<tr>
							<th width="19%" style="text-align: center;">SBP (Systolic Blood
								Pressure)</th>
							<td width="18%"><?php echo $this->Form->input('ObservationChart_1.bp.0',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;'));?>mmHg</td>
						</tr>
						<tr>
							<th width="19%" style="text-align: center;">DMP (Diastolic Blood
								Pressure)</th>
							<td width="18%"><?php echo $this->Form->input('ObservationChart_1.bp.1',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;'));?>mmHg</td>
						</tr>
						<tr>
							<th width="19%" style="text-align: center;">MAP (Mean Arterial
								Pressure)</th>
							<td width="18%"><?php echo $this->Form->input('ObservationChart_1.bp.1',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;'));?>mmHg</td>
						</tr>
						<tr>
							<th width="19%" style="text-align: center;">TEMP</th>
							<td width="18%"><?php echo $this->Form->input('ObservationChart_1.temp',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;'));?>DegC</td>
						</tr>
						<tr>
							<th width="19%" style="text-align: center;">O<sub>2</sub>SAT
							</th>
							<td width="18%"><?php echo $this->Form->input('ObservationChart_1.osat',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;'));?>%</td>
						</tr>
						<tr>
							<th width="19%" style="text-align: center;">RBS</th>
							<td width="18%"><?php echo $this->Form->input('ObservationChart_1.rbs',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;'));?>md/dl

							</td>
						</tr>
					</table>
				</td>
				<td width='100%'>
				<table width='100%'>
						<tr>
							<th style="text-align: center;" colspan='2'><h2>Hemodynamics</h2>
							</th>
						</tr>
						<tr>
							<th width="19%" style="text-align: left;">CPP (Coronary Artery Perfusion
								Pressure)<font color="red">*</font>



							</th>




							<td width="18%"><?php echo $this->Form->input('ObservationChart_1.time',array('id'=>'ObservationChart_1','legend'=>false,'label'=>false,'div'=>false,'class'=>'getselected validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:139px;','options'=>$timeSlots,'empty'=>'Select'));?>

							</td>
						</tr>

						<tr>
							<th style="text-align: center;">ICP (Intracranial Pressure)</th>
							<td width="55"><?php echo $this->Form->input('ObservationChart_1.pulse',array('legend'=>false,'label'=>false,'div'=>false, 'class'=>'textBoxExpnd','style'=>'width:123px;'));?>

							</td>
						</tr>
						<tr>
							<th width="19%" style="text-align: center;">CVP (Central Venous Pressure)</th>
							<td width="20%"><?php echo $this->Form->input('ObservationChart_1.rr',array('legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','div'=>false,'style'=>'width:124px;'));?>

							</td>
						</tr>
						</tr>



					</table>
				</td>
			</tr>
			
			<tr>
				<th colspan="4" style="text-align: center;">
					<table width="100%" width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td colspan="4" height="60" align="center"
								style="border-bottom: 1px solid #3E474A;">Intake</td>
						</tr>
						<tr>
							<td width="20%" height="33" align="center">IVF</td>
							<td width="20%"><?php echo $this->Form->input('ObservationChart_1.ivf',array('legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','div'=>false,'style'=>'width:118px;','onkeyup'=>'getTotalInput(this.id);','onblur'=>'getTotalInput(this.id);','onchange'=>'getTotalInput(this.id);'));?>

							</td>
						</tr>
						<tr>
							<td width="20%" height="32" align="center">RTF</td>
							<td width="20%"><?php echo $this->Form->input('ObservationChart_1.rtf',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;', 'class'=>'textBoxExpnd','onkeyup'=>'getTotalInput(this.id);','onblur'=>'getTotalInput(this.id);',
									'onchange'=>'getTotalInput(this.id);'));?></td>
						</tr>
						<tr>

							<td width="20%" height="32" align="center">OTHER</td>
							<td width="20%"><?php echo $this->Form->input('ObservationChart_1.other',array('legend'=>false,'label'=>false,'div'=>false, 'class'=>'textBoxExpnd','style'=>'width:118px;','onkeyup'=>'getTotalInput(this.id);','onblur'=>'getTotalInput(this.id)',
									'onchange'=>'getTotalInput(this.id);'));?></td>
						</tr>
						<tr>

							<td width="60" height="32" align="center">TOTAL</td>
							<td width="20%"><?php echo $this->Form->input('ObservationChart_1.total_intake',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;', 'class'=>'textBoxExpnd','readonly'=>'readonly','onchange'=>'getTotalInput(this.id);','onchange'=>'getTotalInput(this.id);'));?>

							</td>
						</tr>
					</table>
				</th>
			</tr>
			<tr>
				<th colspan="2" style="text-align: center;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td colspan="2" height="30" align="center"
								style="border-bottom: 1px solid #465053;">Output</td>
						</tr>
						<tr>
							<td width="20%" height="32" align="center">Urine</td>
							<td width="20%" ><?php echo $this->Form->input('ObservationChart_1.total_output',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;','readonly'=>'readonly', 'class'=>'textBoxExpnd','onkeyup'=>'getTotalOutput(this.id);','onblur'=>'getTotalOutput(this.id);','onchange'=>'getTotalOutput(this.id);'));?>

							</td>

						</tr>
						<tr>
							<td width="20%" height="32" align="center">Hourly</td>
							<td width="20%"><?php echo $this->Form->input('ObservationChart_1.total_output',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;','readonly'=>'readonly','onkeyup'=>'getTotalOutput(this.id);', 'class'=>'textBoxExpnd','onblur'=>'getTotalOutput(this.id);','onchange'=>'getTotalOutput(this.id);'));?>

							</td>
						</tr>
						<tr>
							<td width="20%" height="32" align="center">Total</td>
							<td width="20%"><?php echo $this->Form->input('ObservationChart_1.total_output',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:118px;', 'class'=>'textBoxExpnd','readonly'=>'readonly','onkeyup'=>'getTotalOutput(this.id);','onblur'=>'getTotalOutput(this.id);','onchange'=>'getTotalOutput(this.id);'));?>

							</td>
						</tr>
						<tr>
				<td width="20%" height="32" align="center">Bowel</td>
		
				<td width="20%"> <?php echo $this->Form->input('ObservationChart_1.bowel',array('legend'=>false,'label'=>false, 'class'=>'textBoxExpnd','div'=>false,'style'=>'width:118px;'));?>
				
				</td>>

			</tr>
						
						
					</table>
				</th>
			</tr>
			

			<tr>
				<?php 
				$flag = false;
		$patient_id = $this->params['pass'][0];	?>
				<!-- <td width="46"><?php echo $this->Form->input('ObservationChart_1.time',array('id'=>'ObservationChart_1','legend'=>false,'label'=>false,'div'=>false,'class'=>'getselected','style'=>'width:93px;','options'=>$timeSlots,'empty'=>'Select'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.pulse',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.rr',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
				<td width="82"><?php echo $this->Form->input('ObservationChart_1.bp.0',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:24px;'));?>
								/<?php echo $this->Form->input('ObservationChart_1.bp.1',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:24px;'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.temp',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.osat',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.rbs',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.ivf',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','onkeyup'=>'getTotalInput(this.id);','onblur'=>'getTotalInput(this.id);','onchange'=>'getTotalInput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.rtf',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','onkeyup'=>'getTotalInput(this.id);','onblur'=>'getTotalInput(this.id);',
				'onchange'=>'getTotalInput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.other',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','onkeyup'=>'getTotalInput(this.id);','onblur'=>'getTotalInput(this.id)',
				'onchange'=>'getTotalInput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.total_intake',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','readonly'=>'readonly','onchange'=>'getTotalInput(this.id);','onchange'=>'getTotalInput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.hourly',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','onkeyup'=>'getTotalOutput(this.id);','onblur'=>'getTotalOutput(this.id);','onchange'=>'getTotalOutput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.total_output',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;','readonly'=>'readonly','onkeyup'=>'getTotalOutput(this.id);','onblur'=>'getTotalOutput(this.id);','onchange'=>'getTotalOutput(this.id);'));?></td>
				<td width="55"><?php echo $this->Form->input('ObservationChart_1.bowel',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:27px;'));?></td>
		 -->
			</tr>

		</table>
		<div class="clr">&nbsp;</div>
		<div class="btns" style="margin-right: -9px;" id="buttons">
			<input type="button" id='addButton' value="Add More" class="blueBtn"
				tabindex="17" /> <input type="button" id='removeButton'
				value="Remove" class="grayBtn" tabindex="17" />

		</div>
		<div class="clr">&nbsp;</div>
		<table width="100%" cellpadding="0" cellspacing="1" border="0"
			class="tabularForm" id="progress">
			<tr>
				<th>Progress in last 24 hours:</th>
			</tr>
			<tr>
				<td><?php echo $this->Form->input('ObservationChart.progress_remark',array('legend'=>false,'label'=>false,'div'=>false,'rows'=>'3','cols'=>'10','style'=>'width:98%;'));
				//echo $this->Form->hidden('arrayDate',array('legend'=>false,'label'=>false,'div'=>false,'id'=>'arrayDate','value'=>$arrayDate));
				?>
				</td>
			</tr>
		</table>
	</div>
	<div class="btns" id="buttons">
		<input type="submit" value="Save" class="blueBtn" tabindex="17" id="save"
			onclick="return getValidate();">
		<?php 
		//pr($lastRecord);exit;
		if(!empty($lastRecord)){
			echo $this->Html->link(__('Print Chart'),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_observation',$this->params['pass'][0]))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));

		} ?>

	</div>

</form>
<!-- Left Part Template Ends here -->

<script>
	
// Set this variable as global variable
		var counter = 2;
// Spart add more here 
 $(document).ready(function(){
	// do not show unless the roe has been added	
		$('#removeButton').hide('fast');
		$('#date').val('');
	
	})	  //EOF add n remove drug inputs		


	$(document).ready(function(){

		jQuery("#itemfrm").validationEngine({
		validateNonVisibleFields: true,
		updatePromptsPosition:true,
		});
		$('#save')
		.click(
		function() { 
		//alert("hello");
		var validatePerson = jQuery("#itemfrm").validationEngine('validate');
		//alert(validatePerson);
		if (validatePerson) {$(this).css('display', 'none');}
		return false;
		});
		});	
	

// Validate for date and time


	function getValidate(){
		
		if(counter == 2){
			var count = 1;
		} else {
			var count = counter - 1;;
		}
		var time = $("#ObservationChart_"+count).val();
		var observaionDate = $('#date').val();
		
		
		if(time == '' || observaionDate == ''){
		//	alert("Please select date and time!");
			return false;
		} else if(time == ''){
		//	alert("Please select time!");
			return false;
		} else if(observaionDate == ''){
		//	alert("Please select date!");
			return false;
		}		
		
	}

// To calculate the total of Intake
	function getTotalInput(id){
	// Separate the number from ID	
		var numb = id.match(/\d/g);
		numb = numb.join("");
	//  Initialize variable  
		var total = 0;
		var IVF = $('#ObservationChart_'+(numb)+'Ivf').val();
		var RTF = $('#ObservationChart_'+(numb)+'Rtf').val();
		var Other = $('#ObservationChart_'+(numb)+'Other').val();
		//alert(RTF)
		var isNumIVF = /^[0-9]$/.test(IVF);
		var isNumRTF = /^[0-9]$/.test(RTF);
		var isNumOther = /^[0-9]$/.test(Other);
	// Clear empty 	
		if(IVF == '' || IVF == 'undefined'){ 
			IVF = 0;
		} 
		if(RTF =='' || RTF =='undefined'){
			RTF = 0;
		} 
		if(Other == '' || Other == 'undefined'){
			Other = 0;
		}
	// Whne all empty Total is also Empty
		if(IVF == 0 && RTF == 0 && Other == 0){
			$('#ObservationChart_'+(numb)+'TotalIntake').val(0);
		}
	// Calculate Total 
		if(IVF != '' || RTF != '' || Other != ''){				
			total = parseFloat(IVF)+parseFloat(RTF)+parseFloat(Other);
		// Set total
			$('#ObservationChart_'+(numb)+'TotalIntake').val(total);
		} 
	}

var allTotal = 0;
// To Calculte Out Put Total

	function getTotalOutput(id){	
		
		var numb = id.match(/\d/g);
		numb = numb.join("");
		var total = 0;
		
		
		var Hourly = $('#ObservationChart_'+(numb)+'Hourly').val();
		
		//var Hourly = /^[0-9]$/.test(Hourly);		
		
		
		if(Hourly == '' || Hourly == 'undefined'){ 
			Hourly = 0;
			$('#ObservationChart_'+(numb)+'TotalOutput').val(0)
		} 
		
		/*if($('#ObservationChart_'+(numb-1)+'TotalOutput').val() == '' || $('#ObservationChart_'+(numb-1)+'TotalOutput').val() == 'undefined'){ 
			$('#ObservationChart_'+(numb-1)+'TotalOutput').val(0);
		}*/

		if(numb == 1 && Hourly != ''){				
			total = parseFloat(Hourly);
			$('#ObservationChart_'+(numb)+'TotalOutput').val(total);
						
		} else if(Hourly != '' && numb > 1){

			total = parseFloat(Hourly) + parseFloat($('#ObservationChart_'+(numb-1)+'TotalOutput').val());			
			$('#ObservationChart_'+(numb)+'TotalOutput').val(total);
			var row = counter-1;
			
			for(i=numb; i<=row;i++){				
				total = parseFloat(Hourly) + parseFloat($('#ObservationChart_'+(numb-1)+'TotalOutput').val());	
				$('#ObservationChart_'+(i)+'TotalOutput').val(total);				
				
			} 
		 }			
	  } 	
	
	
// This is for datepicker
	 $("#date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			 
			beforeShowDay: highlightDays,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			
		});
var dates = <?php echo json_encode($arrayDateHighlight); ?>;
function highlightDays(date) {
        for (var i = 0; i < dates.length; i++) {
            if (new Date(dates[i]).toString() == date.toString()) {              
                          return [true, 'highlight'];
                  }
          }
          return [true, ''];

 }
</script>
