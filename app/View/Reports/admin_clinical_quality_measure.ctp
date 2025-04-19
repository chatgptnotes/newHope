<?php
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));

?>

<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Clinical Quality Measure', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'blueBtn','div'=>false)); ?></span>
</div>
<?php echo $this->Form->create('clinical_quality_measure',array('id'=>'ClinicalQualityMeasureFrm',
		array('controller'=>'Reports','action'=>'clinical_quality_measure','admin'=>true),
		'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
<table id="managerial" width="100%">
	<!--  <tr class='row_gray'>
		<td width="10%" height="30px" style=""><b>Doctor</b></td>
		<td width="10%" height="10px"><b>:</b></td>
		<td><b><?php echo $this->Form->input('doctor_name', array('empty'=>__('Select'),'options'=>$doctors,'id' => 'doctor_name','style'=>'width:230px')); ?>
		</b></td>
	</tr>
	<tr class='row_gray'>
		<td width="20%" height="30px"><b>Start Date:</b></td>
		<td width="10%" height="10px"><b>:</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Form->input('start_date', array('type'=>'text','style'=>'width:136px','size'=>'20','id' => 'Start_date'));?>
		</b></td>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>Duration:</b></td>
		<td width="10%" height="10px"><b>:</b></td>
		<td width="10%" height="30px"><b><?php echo $this->Form->input('end_date', array('empty'=>__('Select'),'options'=>array('90'=>'90 days','365'=>'1 Year'),'id' => 'end_date','style'=>'width:120px')); ?>
		</b></td>
		
	</tr> -->
	<tr>
		<td align="right"><?php echo __('Provider') ?> <font color="red">*</font>:</td>
		<td class="row_format"><?php 
		echo $this->Form->input('doctor_name', array('empty'=>__('Select'),'options'=>$doctors,'id' => 'doctor_name','style'=>'width:230px'));
		?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('Report Duration') ?> <font color="red">*</font>:</td>
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
			 echo $this->Form->input(null, array('class' => 'validate[required,custom[dateSelect]] textBoxExpnd','style'=>'width:120px;','name' => 'startdate', 'id' => 'startdate', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false, value => date("m/d/Y", strtotime($startdate))));
			} else {
                         echo $this->Form->input(null, array('class' => 'validate[required,custom[dateSelect]] textBoxExpnd','style'=>'width:120px;','name' => 'startdate','name' => 'startdate', 'id' => 'startdate', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
            }
            ?>
		</td>
	</tr>
	<tr class='row_gray'>
		<td align=margin-right: '20px' width="10%" height="30px" style=""
			colspan='6'><input type="submit" name="Search" value="Search"
			class="blueBtn"> <?php //echo $this->Form->submit('Search' ,array('escape' => false,'class'=>'blueBtn')); ?>
		</td>
	</tr>

</table>
<h3>
	&nbsp;
	<?php echo __('', true); ?>
	<?php $dateqrda=explode('_',$this->request->data[duration]);
	$start_date1=$dateqrda[0]."-".$this->request->data[year];
	$end_date1=$dateqrda[1]."-".$this->request->data[year];
	$start_date=$this->DateFormat->formatDate2STD($start_date1,Configure::read('date_format_us'));
	$end_date=$this->DateFormat->formatDate2STD($end_date1,Configure::read('date_format_us'));
	$d_id=$this->request->data['clinical_quality_measure']['doctor_name'];
	?>
</h3>
<?php if(!empty($this->request->data) || $GenerateView=='1'){?>
<table id="managerial" width="100%">
	<tr>
		<td align='right' width="70%" height="30px" style=""><?php echo $this->Html->link("Generate Consolidated Report",array('controller' => 'Reports', 'action' =>'consolidated_qrda3',
				substr($start_date,0,10),substr($end_date,0,10),$d_id)); ?>
		</td>
		<td align='right' width="13%" height="30px" style="" colspan='12'><?php echo $this->Html->link("View Consolidated Report",'#',array('onClick'=>'qrdaview("DrmHope_EP_111_qrda3")')); ?>
		</td>
	</tr>
</table>
	<table id="managerial" width="100%">
	<tr class='row_gray'>
		<td style=""><b>Sr. No.</b></td>
		<td width="80%"><b>Clinical Quality Measure</b></td>
		<td  ><b>Numerator </b></td>
		<td ><b>Denominator </b></td>
		<td ><b>Numerator Exclusion </b></td>
		<td><b>Denominator Exclusion </b></td>
		<td ><b>Denominator Exception </b></td>
		<td><b>Generate </b></td>
		<td ><b>Download </b></td>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>1</b></td>
		<td>Controlling High Blood Presure</td>

		<td width="20%" height="30px"><b><?php echo $recordBp[0]['CqmReport']['numerator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $recordBp[0]['CqmReport']['denominator'];?>
		</b></td>
		<td width="10%" height="30px"><b>N/A </b></td>
		<td width="10%" height="30px"><b><?php echo $recordBp[0]['CqmReport']['den_exclusion'];?>
		</b></td>
		<td width="10%" height="30px"><b>NONE </b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(1)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','0018'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat1')); ?>
		</b></td>
	</tr>
	<tr>
		<td width="10%" height="30px"><b>2</b></td>
		<td>Prevention Care and Screening Tobacco Use Screening and Cessation
			Intervention</td>
		<td width="20%" height="30px"><b><?php echo $resultOfTS[0]['CqmReport']['numerator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $resultOfTS[0]['CqmReport']['denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b>N/A</b></td>
		<td width="10%" height="30px"><b>NONE</b></td>
		<td width="10%" height="30px"><b><?php echo $resultOfTS[0]['CqmReport']['den_exception'];?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(2)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','0028'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat2')); ?>
		</b></td>
	</tr>

	<tr class='row_gray'>
		<td width="10%" height="30px"><b>3</b></td>
		<td>Use of Imaging studies for Low Back Pain</td>
		<td width="20%" height="30px"><b><?php echo $resultOfLowBackPain[0]['CqmReport']['numerator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $resultOfLowBackPain[0]['CqmReport']['denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b>N/A</b></td>
		<td width="10%" height="30px"><b><?php echo $resultOfLowBackPain[0]['CqmReport']['den_exclusion'];?>
		</b></td>
		<td width="10%" height="30px"><b>NONE </b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(3)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','0052'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat3')); ?>
		</b></td>
	</tr>
	<tr>
		<td width="10%" height="30px"><b>4</b></td>
		<td>Prevention Care and Screeing Screening for Clinical Depression and
			Follow-up Plan</td>
		<td width="20%" height="30px"><b><?php echo $resultOfDepression[0]['CqmReport']['numerator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $resultOfDepression[0]['CqmReport']['denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b>N/A </b></td>
		<td width="10%" height="30px"><b><?php echo $resultOfDepression[0]['CqmReport']['den_exclusion'];?>
		</b></td>
		<td width="10%" height="30px"><b><?php echo $resultOfDepression[0]['CqmReport']['den_exception'];?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(4)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','0418'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat4')); ?>
		</b></td>
	</tr>

	<tr class='row_gray'>
		<td width="10%" height="30px"><b>5(I)</b></td>
		<td>Prevention Care and Screeing:Body Mass Index (BMI) Screening and
			Flow-Up(A)</td>
		<td width="20%" height="30px"><b><?php echo $recordBMIA[0]['CqmReport']['numerator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $recordBMIA[0]['CqmReport']['denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b>N/A </b></td>
		<td width="10%" height="30px"><b><?php echo $recordBMIA[0]['CqmReport']['den_exclusion'];?>
		</b></td>
		<td width="10%" height="30px"><b>NONE </b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(5)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','0421'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat5')); ?>
		</b></td>
	</tr>
	<tr>
		<td width="10%" height="30px"><b>5(II)</b></td>
		<td>Prevention Care and Screeing:Body Mass Index (BMI) Screening and
			Flow-Up(B)</td>
		<td width="20%" height="30px"><b><?php echo $recordBMIB[0]['CqmReport']['numerator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $recordBMIB[0]['CqmReport']['denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b>N/A</b></td>
		<td width="10%" height="30px"><b><?php echo $recordBMIB[0]['CqmReport']['den_exclusion'];?>
		</b></td>
		<td width="10%" height="30px"><b>NONE</b></td>
		<?php //debug($resultOfBMI_B);?>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(6)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','0421'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat6')); ?>
		</b></td>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>6</b></td>
		<td>Documentation of Current Medications in the Medical Record</td>
		<td width="20%" height="30px"><b><?php echo $recordDCM[0]['CqmReport']['numerator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $recordDCM[0]['CqmReport']['denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b>N/A</b></td>
		<td width="10%" height="30px"><b>NONE</b></td>
		<td width="10%" height="30px"><b><?php echo $recordDCM[0]['CqmReport']['den_exclusion']; ?>
		</b></td>
		<?php // echo "<pre>";print_r($resultOfDCM); ?>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(7)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','0419'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat7')); ?>
		</b></td>
	</tr>

	<tr>
		<td width="10%" height="30px"><b>7</b></td>
		<td>Pregnant women that has HBsAg testing</td>
		<td width="20%" height="30px"><b><?php echo $recordW[0]['CqmReport']['numerator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $recordW[0]['CqmReport']['denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b>N/A</b></td>
		<td width="10%" height="30px"><b>NONE</b></td>
		<td width="10%" height="30px"><b><?php echo $recordW[0]['CqmReport']['den_exception']; ?>
		</b></td>
		<?php 
		//debug($resultOfWomen[4]);
		$i=0;
		foreach($resultOfWomen[3] as $resultOfWomens){
		$idd[$i]=$resultOfWomens['NoteDiagnosis']['patient_id'];
		$i++;
		}
		$idd=count($idd);
		$j=0;
		foreach($resultOfWomen[4] as $resultOfWomenss){
			$idn[$j]=$resultOfWomenss['NoteDiagnosis']['patient_id'];
			$j++;

}
$idn=count($idn);
?>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(8)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','0608'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat8')); ?>
		</b></td>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>8</b></td>
		<td>Use of High-Risk Medications in the Elderly 1+</td>
		<td width="20%" height="30px"><b><?php echo $recordEM[0]['CqmReport']['numerator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $recordEM[0]['CqmReport']['denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b>N/A </b></td>
		<td width="10%" height="30px"><b>NONE</b></td>
		<td width="10%" height="30px"><b>NONE</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(9)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','0022'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat9')); ?>
		</b></td>
	</tr>
	<tr>
		<td width="10%" height="30px"><b>9</b></td>
		<td>Use of High-Risk Medications in the Elderly 2+</td>
		<td width="20%" height="30px"><b><?php echo $recordEM2[0]['CqmReport']['numerator']; ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $recordEM2[0]['CqmReport']['denominator']; ?>
		</b></td>
		<td width="10%" height="30px"><b>N/A </b></td>
		<td width="10%" height="30px"><b>NONE</b></td>
		<td width="10%" height="30px"><b>NONE</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(10)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','0022'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat10')); ?>
		</b></td>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>10</b></td>
		<td>Hypertension: Improvement in blood pressure</td>
		<td width="20%" height="30px"><b><?php echo $BpImprove[0]['CqmReport']['numerator']; ?></b>
		</td>
		<td width="20%" height="30px"><b><?php echo $BpImprove[0]['CqmReport']['denominator']; ?></b>
		</td>
		<td width="10%" height="30px"><b>N/A</b></td>
		<td width="10%" height="30px"><b><?php echo $BpImprove[0]['CqmReport']['den_exclusion']; ?>
		</b></td>
		<td width="10%" height="30px"><b>NONE</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/xml-icon.png",array('alt'=>'Generate Report','title'=>'Generate Report')),'javascript:void(0)',array('escape'=>false ,'alt'=>'Generate Report','title'=>'Generate Report','onClick'=>'showdowmloadicon(11)')); ?>
		</b></td>
		<td width="20%" height="30px"><b><?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download Report','title'=>'Download Report')),array('action'=>'downloadXml','HYPIMP'),array('escape'=>false ,'style'=>'display:none;','class'=>'DownLoadCat11')); ?>
		</b></td>
	</tr>
	<!-- 	<tr class='row_gray'>
		<td width="10%" height="30px"><b>10</b></td>
		<td>Stroke-3 Anticoagulation Therapy for Antrial Fibrillation/Flutter</td>
		<td width="20%" height="30px"><?php echo $count_stroke_Anticoagulation1; ?>
		</td>
		<td width="20%" height="30px"><?php echo $count_stroke_Anticoagulation; ?>
		</td>
		<td width="10%" height="30px"><?php echo $cal_percentage_Anticoagulation; ?>%
		</td>
	</tr>
	<tr class='row_gray'>
		<td width="10%" height="30px"><b>11</b></td>
		<td>Stroke-4 Ischemic Stroke Thrombolytic Therapy</td>
		<td width="20%" height="30px"><?php echo $count_stroke_Anticoagulation1; ?>
		</td>
		<td width="20%" height="30px"><?php echo $count_stroke_Anticoagulation; ?>
		</td>
		<td width="10%" height="30px"><?php echo $cal_percentage_Anticoagulation; ?>%
		</td>
	</tr>-->

</table>
<?php echo $this->Form->end(); }?>
<script>
jQuery(document)
.ready(
		
		function() {
$("#startdate")
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
function qrdaview(filename) {
	var f_name=filename;
	
	//alert(deno);
	//var patient_id = $('#Patientsid').val();
	
	
	$
			.fancybox({

				'width' : '100%',
				'height' : '170%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Reports", "action" => "qrda3view")); ?>"+"/"+f_name
						
			});}
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#automatedmeasurecalfrm").validationEngine();
	
});
jQuery("#duration").change(function() {
if(jQuery("#duration").val() == 90) {
  jQuery("#showdate").show();
  jQuery("#showyear").hide();
} else {
  jQuery("#showdate").hide();
  jQuery("#showyear").show();
}
});
//-----------------------hide in show the Download icons---------------------------------
function showdowmloadicon(n){
	if(n==1){
  		jQuery(".DownLoadCat1").show();
	}
	if(n==2){
  		jQuery(".DownLoadCat2").show();
	}
	if(n==3){
  		jQuery(".DownLoadCat3").show();
	}
	if(n==4){
  		jQuery(".DownLoadCat4").show();
	}
	if(n==5){
  		jQuery(".DownLoadCat5").show();
	}
	if(n==6){
  		jQuery(".DownLoadCat6").show();
	}
	if(n==7){
  		jQuery(".DownLoadCat7").show();
	}
	if(n==8){
  		jQuery(".DownLoadCat8").show();
	}
	if(n==9){
  		jQuery(".DownLoadCat9").show();
	}
	if(n==10){
  		jQuery(".DownLoadCat10").show();
	}
	if(n==11){
  		jQuery(".DownLoadCat11").show();
	}
	
}

		</script>
