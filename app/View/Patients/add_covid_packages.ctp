<style>

.message{
	
	font-size: 15px;
}
.table_format {
    padding: 3px !important;
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
			<?php echo $patientData['Patient']['lookup_name']." - ".$patientData['Patient']['admission_id'] ;?>
		</div>
	<span>
	<?php echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'doctor_dashboard'), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px')); ?>
	</span>
</div>


<p class="ht5"></p> 

<table class="table_format" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
	<tr>
		<td width="50%">
			<?php
echo $this->Form->create('PatientCovidPackage',array('type' => 'file','id'=>'CovidPackageForm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));

echo $this->Form->hidden('patient_id',array('id'=>'patientId','value'=>$patientData['Patient']['id'],'autocomplete'=>"off"));

?>
 <table class="table_format" border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
	
	<tr>
		<td align="right"><?php echo __('CLAIM ID'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.claim_id', array('type'=>'text','class' => 'textBoxExpnd', 'id' => 'claim_id', 'label'=> false, 'div' => false,'error' => false,'style'=>'width:40%'));
		 	?>
				 	
	 	</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('SELECT PACKAGE COST'); ?><font color="red">*</font> </td>
		<td><?php echo $this->Form->input('PatientCovidPackage.package_cost', array('type'=>'select','empty'=>'Please Select','options'=>Configure::read('covidpackage'),'class' => 'textBoxExpnd validate[required,custom[mandatory-select]]', 'id' => 'package-cost', 'label'=> false, 'div' => false,'error' => false,'style'=>'width:40%'));
		 	?>
				 	
	 	</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('PACKAGE START DATE'); ?><font color="red">*</font> </td>
		<td><?php echo $this->Form->input('PatientCovidPackage.package_start_date', array('type'=>'text','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'package_start_date', 'label'=> false, 'div' => false,
			 'error' => false,'autocomplete'=>'off'));?>
		</td>
	</tr>
	
	<tr>
		<td align="right"><?php echo __('PACKAGE END DATE'); ?><font color="red">*</font></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.package_end_date', array('type'=>'text','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'package_end_date', 'label'=> false, 'div' => false,
			 'error' => false,'autocomplete'=>'off'));?>
		</td>
	</tr>

	
	<tr>
		<td align="right"><?php echo __('IS PPE ADDED'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.is_ppe_added', array('type'=>'select','empty'=>'Please Select','options'=>array('0'=>'No','1'=>'Yes'),'class' => 'textBoxExpnd','id' => 'is_ppe_added', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>
	<tr style="display: none;" class="ShowPPEBlock">
		<td align="right"><?php echo __('NO OF PPE USED'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.ppe_count', array('type'=>'number','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>
	<tr style="display: none;" class="ShowPPEBlock">
		<td align="right"><?php echo __('PPE UNIT COST'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.ppe_unit_cost', array('type'=>'number','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>
	<!-- <tr>
		<td align="right"><?php echo __('RTPCR'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.is_rtpcr_done', array('type'=>'select','empty'=>'Please Select','options'=>array('0'=>'No','1'=>'Yes'),'class' => 'textBoxExpnd','id' => 'is_rtpcr_done', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>
	<tr style="display: none;" class="ShowRTPCRCountBLOCK">
		<td align="right"><?php echo __('RTPCR TEST COUNT'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.rtpcr_test_count', array('type'=>'number','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>
	<tr style="display: none;" class="ShowRTPCRCountBLOCK">
		<td align="right"><?php echo __('RTPCR UNIT COST'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.rtpcr_unit_cost', array('type'=>'number','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('ANTIGEN TEST'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.is_antigen_done', array('type'=>'select','empty'=>'Please Select','options'=>array('0'=>'No','1'=>'Yes'),'class' => 'textBoxExpnd','id' => 'is_antigen_done', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>

	<tr style="display: none;" class="ShowAntigenCountBlock">
		<td align="right"><?php echo __('ANTIGEN TEST COUNT'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.antigen_test_count', array('type'=>'number','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>

	<tr style="display: none;" class="ShowAntigenCountBlock">
		<td align="right"><?php echo __('ANTIGEN UNIT COST'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.antigen_unit_cost', array('type'=>'number','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>


	<tr>
		<?php $radiology = array('XRAY'=>'XRAY','ULTRASOUND'=>'ULTRASOUND','HRCT'=>'HRCT','MRI'=>'MRI'); ?>
		<td align="right"><?php echo __('RADIOLOGY'); ?></td>
		<td><?php foreach ($radiology as $key => $value) { ?>
			<span>
				<?php echo $this->Form->input('',array('name'=>'data[PatientCovidPackage][radiology_investigation][]','type'=>'checkbox','label'=>$value,'div'=>false,'id'=>'rady_'.$key,'hiddenField'=>false,'value'=>$value))
				?>
			</span>
			
		<?php } ?>
		</td>
	</tr> -->

	<tr>
		<td align="right"><?php echo __('SELECT DOCTOR'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.doctor_id', array('type'=>'select','empty'=>'Please Select','options'=>$doctorList,'class' => 'textBoxExpnd','id' => 'is_antigen_done', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>

	<tr>
		<td align="right"><?php echo __('DOCTOR VISITING CHARGES'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.doctor_visiting_charge', array('type'=>'text','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>
	<tr>
		<td align="right"><?php echo __('NO OF VISITS'); ?></td>
		<td><?php echo $this->Form->input('PatientCovidPackage.no_of_visit', array('type'=>'number','class' => 'textBoxExpnd','id' => '', 'label'=> false, 'div' => false,'error' => false,'autocomplete'=>'off','style'=>'width:40%'));?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><?php	
				echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false,'id'=>'saveBtn'));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
		</td>
		<td width="50%" style="vertical-align: top;">
			<table class="table_format" border="1" cellpadding="0" cellspacing="0" width="60%" align="center">
			<thead>
				
				<tr>
					<th><?php echo __('PACKAGE'); ?></th>
					<th><?php echo __('START DATE'); ?></th>
					<th><?php echo __('END DATE'); ?></th>
					<th><?php echo __('PACKAGE DAYS'); ?></th>
					<th><?php echo __('ACTION'); ?></th>
				</tr>
				<?php foreach ($packageList as $key => $value) { ?>
					<tr>
					<td><?php echo $value['PatientCovidPackage']['package_cost']." / Day"; ?></td>
					<td><?php echo date('d/m/Y',strtotime($value['PatientCovidPackage']['package_start_date'])); ; ?></td>
					<td><?php echo date('d/m/Y',strtotime($value['PatientCovidPackage']['package_end_date'])); ?></td>
					<td><?php echo $value['PatientCovidPackage']['package_days'] ; ?></td>
					<td><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_covid_package',$value['PatientCovidPackage']['id']), array('escape' => false),__('Are you sure?', true)); ?></td>
					</tr>
				<?php } ?>
			</thead>
		</table>
		</td>
	</tr>
</table>


<script>
$(document).ready(function(){

	// binds form submission and fields to the validation engine
	$(document).on('click',"#saveBtn",function(){
		var validateForm = $("#CovidPackageForm").validationEngine('validate');

		if (validateForm == true)
		{
			$("#saveBtn").hide();
		}else{

			$("#saveBtn").show();
			return false;
		}

	});
	
 	$("#package_start_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate('');?>',
        
	});

	$("#package_end_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate('');?>',
        
	});

	$(document).on('click','#is_ppe_added',function(){
		var val = $(this).val();
		if(val == '1'){
			$('.ShowPPEBlock').show();
		}else{
			$('.ShowPPEBlock').hide();
		}
	});

	$(document).on('click','#is_rtpcr_done',function(){
		var val = $(this).val();
		if(val == '1'){
			$('.ShowRTPCRCountBLOCK').show();
		}else{
			$('.ShowRTPCRCountBLOCK').hide();
		}
	});

	$(document).on('click','#is_antigen_done',function(){
		var val = $(this).val();
		if(val == '1'){
			$('.ShowAntigenCountBlock').show();
		}else{
			$('.ShowAntigenCountBlock').hide();
		}
	});

});


</script>