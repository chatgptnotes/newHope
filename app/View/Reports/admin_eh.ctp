<?php
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));

?>

<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Clinical Quality Measure For EH', true); ?>
	</h3>
</div>
<?php echo $this->Form->create('clinical_quality_measure',array('id'=>'ClinicalQualityMeasureFrm',
		array('controller'=>'Reports','action'=>'admin_eh','admin'=>true),
		'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
<table id="managerial" width="100%">

<tr class='row_gray'>
		<td width="20%" height="30px"><b>Start Date:</b></td>
		<td width="10%" height="10px"><b>:</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Form->input('start_date', array('class'=>'textBoxExpnd','style'=>'width:120px;','type'=>'text','size'=>'20','id' => 'Start_date'));?>
		</b></td>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>Duration:</b></td>
		<td width="10%" height="10px"><b>:</b></td>
		<td width="10%" height="30px"><b><?php echo $this->Form->input('end_date', array('empty'=>__('Select'),'options'=>array('90'=>'90 days','365'=>'1 Year'),'id' => 'end_date','style'=>'width:120px')); ?>
		</b></td>
	</tr>
	<tr class='row_gray'>
		<td algin=margin-right: '20px' width="10%" height="30px" style=""
			colspan='6'><input type="submit" name="Search" value="Search"
			class="blueBtn">
		</td>
	</tr>  
	<!-- <tr>
		<td align="right"><?php echo __('Report Type') ?> <font color="red">*</font>:</td>
		<td class="row_format"><?php 
		echo    $this->Form->input(null, array('name' => 'duration', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => array('90' => '90 Days', '01-01_12-31' => 'Full Year', '01-01_03-31' => 'First Quarter', '04-01_06-30' => 'Second Quarter', '07-01_09-30' => 'Third Quarter', '10-01_12-31' => 'Fourth Quarter'), 'empty' => 'Select Duration', 'style' => 'width:300px;',  'id' => 'duration', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $duration));
		?>
		</td>
	</tr>
	<tr id="showyear" style="<?php if($duration != "90" && $duration != "") echo "display:block important;";  else echo "display:none;"; ?>">
		<td align="right"><?php echo __('Year') ?>:</td>
		<td class="row_format"><?php 
		$currentYear = date("Y");
		for($i=0;$i<=10;$i++) {
				    $lastTenYear[$currentYear] = $currentYear;
				    $currentYear--;
			         }
			         echo    $this->Form->input(null, array('name' => 'year', 'options' => $lastTenYear,  'style' => 'width:300px;',  'id' => 'year', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' => $year));
			         ?>
		</td>
	</tr>
	<tr id="showdate" style="<?php if($duration == "90" && $duration != "") echo "display:block important;";  else echo "display:none;"; ?>">

		<td align="right"><?php echo __('Start Date') ?> <font color="red">*</font>:</td>
		<td class="row_format"><?php 
		if($startdate) {
			 echo $this->Form->input(null, array('class' => 'validate[required,custom[dateSelect]]','name' => 'startdate', 'id' => 'startdate', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false, value => date("m/d/Y", strtotime($startdate))));
			} else {
                         echo $this->Form->input(null, array('class' => 'validate[required,custom[dateSelect]]','name' => 'startdate', 'id' => 'startdate', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
            }
            ?>
		</td>
		<tr class='row_gray'>
		<td algin=margin-right: '20px' width="10%" height="30px" style=""
			colspan='6'><input type="submit" name="Search" value="Search"
			class="blueBtn">
		</td>
	</tr>
	</tr>  -->
</table>
<?php if(!empty($this->request->data) || $GenerateView=='1'){?>
<h3>
	&nbsp;
	<?php echo __('', true); ?>
</h3>
<table id="managerial" width="100%">
<tr >
		<td align= 'right' width="80%" height="30px" style="">
		<?php echo $this->Html->link("Generate Consolidated Report",array('controller' => 'Reports', 'action' =>'consolidates_eh_qrda3',$startdate,$enddate)); ?>
		</td>
		<td align='right' width="15%" height="30px" style="" colspan='12'>
		<?php echo $this->Html->link("View Consolidated Report",'#',array('onClick'=>'qrdaview("DrmHope_EH_qrda3")')); ?>
		</td>
	</tr>
	</table>
<table id="managerial" width="100%">
	<tr class='row_gray'>
		<td ><b>Sr. No.</b></td>
		<td width="80%" ><b>Clinical Quality Measure</b></td>
		<td ><b>Numerator</b></td>
		<td ><b>Denominator</b></td>
		<td ><b>Numerator Exclusion</b></td>
		<td ><b>Denominator Exception</b></td>
		<td ><b>Denominator Exclusion</b></td>
		<td ><b>Generate</b></td>
		<td ><b>Download</b></td>
	</tr>
	<tr class='row_gray'>
		<?php //debug($ehdata); exit;?>
		<td width="10%" height="30px"><b>1</b></td>
		<td width="20%" height="30px">Stroke 2 Ischemic stroke- discharged
				on anti-thrombotic therapy </td>
		<td width="20%" height="30px"><b><?php echo $ehdata['0']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['0']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['0']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['0']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0435)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0435'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0435')); ?>
		</b></td>
	</tr>
	<tr class='row'>
		<td width="10%" height="30px"><b>2</b></td>
		<td>Stroke 3 Ischemic stroke- Anticoagulation therapy for Atrial
			fibrillation/flutter</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['1']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['1']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['1']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['1']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0436)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0436'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0436')); ?>
		</b></td>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>3</b></td>
		<td>Stroke 5 Ischemic stroke- Anti-thrombotic therapy by end of
			Hospital day two</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['2']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['2']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['2']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['2']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0438)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0438'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0438')); ?>
		</b></td>
	</tr>
	<tr class='row'>
		<td width="10%" height="30px"><b>4</b></td>
		<td>Stroke 6 Ischemic stroke- Discharged on Statin Medication</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['3']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['3']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo  "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['3']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['3']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0439)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0439'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0439')); ?>
		</b></td>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>5</b></td>
		<td>AMI 10 Statin prescribed at discharge</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['4']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['4']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['4']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['4']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0639)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0639'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0639')); ?>
		</b></td>
	</tr>
	</tr>
	<tr class='rowy'>
		<td width="10%" height="30px"><b>6</b></td>
		<td>Stroke 4 Ischemic stroke- Thrombolytic therapy</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['5']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['5']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['5']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['5']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0437)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0437'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0437')); ?>
		</b></td>
	</tr>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>7</b></td>
		<td width="20%" height="30px">(VTE)-1 VTE prohylaxis</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['6']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['6']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['6']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['6']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0371)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0371'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0371')); ?>
		</b></td>
	</tr>
	<tr class='row'>
		<td width="10%" height="30px"><b>8</b></td>
		<td>VTE2 Intensive Care Unit (ICU) VTE prohylaxis</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['7']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['7']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['7']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['7']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0372)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0372'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0372')); ?>
		</b></td>
	</tr>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>9</b></td>
		<td>Aspirin Prescribed at Discharge</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['8']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['8']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['8']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['8']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0142)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0142'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0142')); ?>
		</b></td>
	</tr>
	</tr>
	<tr class='row'>
		<td width="10%" height="30px"><b>10</b></td>
		<td>VTE-5 VTE discharge Instruction</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['9']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['9']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['9']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['9']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0375)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0375'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0375')); ?>
		</b></td>
	</tr>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>11</b></td>
		<td>PC-01 Elective Delivery prior to 39 completed weeks gestation</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['10']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['10']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['10']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['10']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0469)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0469'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0469')); ?>
		</b></td>
	</tr>

	<tr class='row'>
		<td width="10%" height="30px"><b>12</b></td>
		<td>Fibrinolytic Therapy Received Within 30 Minutes of Hospital
			Arrival</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['11']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['11']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['11']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['11']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0164)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0164'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0164')); ?>
		</b></td>
	</tr>

	<tr class='row_gray'>
		<td width="10%" height="30px"><b>13</b></td>
		<td>Urinary catheter removed on Postoperative Day 1 (POD 1) or
			Postoperative Day 2 (POD 2) with day of surgery being day zero</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['12']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['12']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['12']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['12']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0453)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0453'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0453')); ?>
		</b></td>
	</tr>
	<tr class='row'>
		<td width="10%" height="30px"><b>14</b></td>
		<td>Incidence of Potentially-Preventable Venous Thromboembolism</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['13']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['13']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['13']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['13']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0376)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0376'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0376')); ?>
		</b></td>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>15</b></td>
		<td>Venous Thromboembolism Patients Receiving Unfractionated Heparin
			with Dosages/Platelet Count Monitoring by Protocol or Nomogram</td>
		<td width="20%" height="30px"><b><?php echo $ehdata['14']['CqmReportEh']['numerator_count']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $ehdata['14']['CqmReportEh']['denominator_count']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['14']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['14']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0374)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0374'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0374')); ?>
		</b></td>
	</tr>
	<tr class='row'>
		<td width="10%" height="30px"><b>16</b></td>
	
		<td>Median time form ED arrival to ED departure for discharge ED Patients</td>
		<td width="20%" height="30px"><?php echo $ehdata['15']['CqmReportEh']['measure_pop']."&nbsp; (Measure Population) " ?>
		</td>
		<td width="20%" height="30px"><?php echo $ehdata['15']['CqmReportEh']['ipp_count']."&nbsp; (Intial Patient Population) " ?>
		</td>
		<td width="10%" height="30px"><b><?php echo "NONE"; ?> </b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['15']['CqmReportEh']['exception_denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $ehdata['15']['CqmReportEh']['exclusion_denominator']; ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(0496)')); ?>
		</b></td>
		<td width="20%" height="30px"><b>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXmlEh','0496'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat0496')); ?>
		</b></td>
	</tr>

</table>
<?php echo $this->Form->end(); }?>
<script>
jQuery(document)
.ready(
		
		function() {
$("#Start_date")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange : '-73:+0',
		//	maxDate : new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();
			//foramtEnddate(); //is not defined hence commented
		}
		});
$("#End_date")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange : '-73:+0',
		//	maxDate : new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();
			//foramtEnddate(); //is not defined hence commented
		}
		});
		});

function view_consolidate_ccda(id) {
	
	id= '1409';
	 
	 var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "ccda", "action" => "isCcdaGenerated","admin" => false)); ?>";
        $.ajax({
          type: 'POST',
          url: ajaxUrl+"/"+id,
          data: '',
          dataType: 'html',
          success: function(data){
	           
				if(data==1){
					$.fancybox({ 
						'width' : '85%',
						'height' : '100%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "view_consolidate")); ?>"
						+ '/' + id 
						});
				}else{
					alert("Please generate CCDA and try again");
					return false ;
				}
		  },
		  error: function(message){
              alert(message);
          }        
       });


          return false ;

  }
function qrdaview(filename) {
	var f_name=filename;
	
	
	//var patient_id = $('#Patientsid').val();
	
	
	$
			.fancybox({

				'width' : '100%',
				'height' : '120%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Reports", "action" => "qrda3view")); ?>"+"/"+f_name
						
			});}
		</script>
	<script>
	jQuery("#duration").change(function() {
		if(jQuery("#duration").val() == 90) {
		  jQuery("#showdate").show();
		  jQuery("#showyear").hide();
		} else {
		  jQuery("#showdate").hide();
		  jQuery("#showyear").show();
		}
		});
	function showdowmloadicon(n){

	//alert('Cat-I Generate');
		if(n==0435){
			//alert('Cat-I Generate');
	  		jQuery(".DownLoadCat0435").show();
		}
		if(n==0436){
	  		jQuery(".DownLoadCat0436").show();
		}
		if(n==0438){
	  		jQuery(".DownLoadCat0438").show();
		}
		if(n==0439){
	  		jQuery(".DownLoadCat0439").show();
		}
		if(n==0639){
	  		jQuery(".DownLoadCat0639").show();
		}
		if(n==0437){
	  		jQuery(".DownLoadCat0437").show();
		}
		if(n==0371){
	  		jQuery(".DownLoadCat0371").show();
		}
		if(n==0372){
	  		jQuery(".DownLoadCat0372").show();
		}
		if(n==0375){
	  		jQuery(".DownLoadCat0375").show();
		}
		if(n==0142){
	  		jQuery(".DownLoadCat0142").show();
		}
		if(n==0469){
	  		jQuery(".DownLoadCat0469").show();
		}
		if(n==0164){
	  		jQuery(".DownLoadCat0164").show();
		}
		if(n==0453){
	  		jQuery(".DownLoadCat0453").show();
		}
		if(n==0376){
	  		jQuery(".DownLoadCat0376").show();
		}
		if(n==0374){
	  		jQuery(".DownLoadCat0374").show();
		}
		if(n==0496){
	  		jQuery(".DownLoadCat0496").show();
		}
		
	}
	</script>
