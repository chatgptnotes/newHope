<style>

.message{
	
	font-size: 15px;
}
.table_format {
    padding: 3px !important;
    width: 60%;
}
.rowClass td{
	 background: none repeat scroll 0 0 #ffcccc!important;
}

#patient-info-box{
 	display: none;
    position: absolute;
    right: 0;
    left:992px;
    top: 34px;
    z-index: 29;
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #000000;
    border-radius: 3px;
    box-shadow: 0 0 3px 2px #000;
    margin-top: -1px;
    padding: 6px;
    width: 400px;
    font-size:13px;
    list-style-type: none;
    
}
 .row_format th{
 	 background: #d2ebf2 none repeat scroll 0 0 !important;
    border-bottom: 1px solid #3e474a;
    color: #31859c !important;
    font-size: 12px;
    padding: 3px;
    text-align: center;
 }
 .row_format td{
 	padding: 1px;
 }
  
.row_format tr:nth-child(even) {background: #CCC}
.row_format tr:nth-child(odd) {background: #e7e7e7} 
</style> 

<div class="Row inner_title" style="float: left; width: 100%; clear:both">
		<div style="font-size: 20px; font-family: verdana; color: darkolivegreen;" >			 
			<?php echo "Claim Submission Check List" ;?>
		</div>
	<span>
	<?php echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'doctor_dashboard'), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px')); ?>
	<?php if($checkList['ClaimSubmissionChecklist']['id'] !='') { 
		echo $this->Html->link(__('Print Preview'),'#',
		     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'claim_submission_checklist',$patientData['Patient']['id'],'print'))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
    
    }?>
	</span>
</div>


<p class="ht5"></p> 


<?php
echo $this->Form->create('ClaimSubmissionChecklist',array('type' => 'file','id'=>'ClaimSubmitForm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('id',array('id'=>'recId','value'=>$checkList['ClaimSubmissionChecklist']['id'],'autocomplete'=>"off"));
echo $this->Form->hidden('patient_id',array('id'=>'patientId','value'=>$patientData['Patient']['id'],'autocomplete'=>"off"));

$claimSubmissionCheckList = array(
	'1'=>'Cliam submission check list (All the document should be completely filled or else the claim file will not be submittedfor payment)',
	'2'=>'Copy of Approval Letter',
	'3'=>'Copy of initial Intimation Letter',
	'4'=>'Copy of Unit Officer Member Verification Letter',
	'5'=>'MPKAY ID Card',
	'6'=>'Police ID card',
	'7'=>'NOC From District Unit Where Hospital Is Situated',
	'8'=>'Enhancement Certificate from Unit (In case of Execeeding Bills & Stay)',
	'9'=>'Application for Reimburesement',
	'10'=>'Annexure-1',
	'11'=>'Family Declaration',
	'12'=>'Dependency Certificate',
	'13'=>'Family Planning  Certificate Whenever Necessary.',
	'14'=>'Certificate For Unemployment of wife',
	'15'=>'Emergency Certificate',
	'16'=>'Stay Certificate',
	'17'=>'Form C',
	'18'=>'Form D',
	'19'=>'Discharge Card. In Case of Death Cerificate (Form no 4 copy)& Death Summary Compulsory. OT Notes With Date Of Operation.',
	'20'=>'Original Pharmacy Prescription & Bills Signed By Employee & Doctor.',
	'21'=>'Cosolidated Pharmacy List',
	'22'=>'Original Hospital Consolidated Bill with break -up',
	'23'=>'Original Investigation Reports With Invetigation Bill Break up with Stamp & Sign of Hospital.',
	'24'=>'Copy Of MLC/FIR Report (In Case Of RTA) / Injury Certificate (In Case Of Fall with Stamp & sign of Sr Police Inspector.',
	'25'=>'Indoor Case  Papers',
	'26'=>'All the above Documents should be Signed & Stamped By Hospital Authority Except Member Verification Letter & Member Forms',

);
?>
<?php 
		$unserializeChecklist = unserialize($checkList['ClaimSubmissionChecklist']['checklist']);

		if($patientData['Patient']['form_received_on']){
			$admissionDate = $this->DateFormat->formatDate2Local($patientData['Patient']['form_received_on'],Configure::read('date_format'),true);
		}else{
			 $admissionDate = $this->DateFormat->formatDate2Local($checkList['ClaimSubmissionChecklist']['admission_date'],Configure::read('date_format'),true);
		}

		if($patientData['Patient']['discharge_date']){
			$dischargeDate = $this->DateFormat->formatDate2Local($patientData['Patient']['discharge_date'],Configure::read('date_format'),true);
		}else{
			$dischargeDate = $this->DateFormat->formatDate2Local($checkList['ClaimSubmissionChecklist']['discharge_date'],Configure::read('date_format'),true);
		}
		


 ?>
<table class="table_format" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
	<tr>
		<td><?php echo __('Name of Hospital'); ?></td>
		<td>:</td>
		<td><?php echo $this->Session->read('facility');?></td>
	</tr>
	<tr>
		<td><?php echo __('Name of Patient'); ?></td>
		<td>:</td>
		<td><?php echo $patientData['Patient']['lookup_name'];?></td>
	</tr>
 	<tr>
		<td><?php echo __('Date of Admission'); ?></td>
		<td>:</td>
		<td><?php echo $this->Form->input('ClaimSubmissionChecklist.admission_date', array('type'=>'text','class' => 'textBoxExpnd', 'id' => 'admission_date', 'label'=> false, 'div' => false,'error' => false,'style'=>'width:40%','value'=>$admissionDate));
		 	?>
				 	
	 	</td>
	</tr>
	<tr>
		<td><?php echo __('Date of Discharge'); ?></td>
		<td>:</td>
		<td><?php echo $this->Form->input('ClaimSubmissionChecklist.discharge_date', array('type'=>'text','class' => 'textBoxExpnd', 'id' => 'discharge_date', 'label'=> false, 'div' => false,'error' => false,'style'=>'width:40%','value'=>$dischargeDate));
		 	?>
				 	
	 	</td>
	</tr>
</table>
 <table class="table_format" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">

 	
	<?php foreach ($claimSubmissionCheckList as $key => $value) { 

			if($key == '13' || $key == '14'){
				$options = array('No'=>'No','Yes'=>'Yes');
			}else{
				$options = array('Yes'=>'Yes','No'=>'No');
			}
			
		?>
			
	<tr>
		<td><?php echo $key; ?></td>
		<td><?php echo $value; ?></td>
		<td><?php echo $this->Form->input('', array('name'=>'data[ClaimSubmissionChecklist][checklist]['.$key.']','type'=>'select','options'=>$options,'class' => 'textBoxExpnd', 'id' => 'claimCheckList_'.$key, 'label'=> false, 'div' => false,'error' => false,'value'=>$unserializeChecklist[$key]));
		 	?>
				 	
	 	</td>
	</tr>

	<?php } ?>
	
	<tr>
		<td></td>
		<td></td>
		<td><?php	
				echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false,'id'=>'saveBtn'));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
		

<script>
$(document).ready(function(){

	// binds form submission and fields to the validation engine
	$(document).on('click',"#saveBtn",function(){
		var validateForm = $("#ClaimSubmitForm").validationEngine('validate');

		if (validateForm == true)
		{
			$("#saveBtn").hide();
		}else{

			$("#saveBtn").show();
			return false;
		}

	});
	
 	$("#admission_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
       dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
        
	});

	$("#discharge_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
        
	});

	

});


</script>