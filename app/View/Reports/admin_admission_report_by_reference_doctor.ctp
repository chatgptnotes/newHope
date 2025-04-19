<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <div class="alert">
    <?php 
     foreach($errors as $errorsval) {
         echo $errorsval[0];
         echo "<br />";
     }
    ?>
   </div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
 <h3>&nbsp; <?php echo __('Total New Visit Report By Referral Doctor', true); ?></h3>
</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "admin_admission_report_by_reference_doctor/", )); ?>" method="post" >
 <table align="center">
	 <tr>
	 <td colspan="8" align="right">Format</td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left" width="70%">
           <?php
		echo $this->Form->input('PatientAdmissionReport.format', array("onchange"=>"checkFormat(this.value);",'id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF','GRAPH'=>'GRAPH')));
	   ?>
          </td>
	 </tr>
	<tr id="fromDate">
	 <td colspan="8" align="right">From<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientAdmissionReport.from', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	  </tr>
	<tr id="toDate">
	   <td colspan="8" align="right">To<font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientAdmissionReport.to', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	</tr>
        <?php 
			$currentYear = date("Y");
			 for($i=0;$i<=10;$i++) {
				$lastTenYear[$currentYear] = $currentYear;
				$currentYear--;
			 }
	  ?>
		<tr id = "year" style="display:none;">
		 <td colspan="8" align="right">Year<font color="red">*</font></td>
		 <td><b>:</b></td>
		  <td colspan="8" align="left">
			<?php 
	        echo $this->Form->input('PatientAdmissionReport.year', array('id'=>'year','label'=> false, 'div' => false, 'error' => false,'options' =>$lastTenYear));?>
			
		  </td>
		 </tr>
	 <?php
		$monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December',);
	 ?>
		<tr id="month" style="display:none;">
		   <td colspan="8" align="right">Month<font color="red">*</font></td>
		   <td><b>:</b></td>
		   <td colspan="8" align="left">
			<?php 
	        echo $this->Form->input('PatientAdmissionReport.month', array('id'=>'month','label'=> false, 'div' => false, 'error' => false,'options' =>$monthArray,'empty'=>'All'));?>
			
		  </td>
		   
	  </tr>
	  <tr>
	 <td colspan="8" align="right"><?php echo __('Patient Type'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left">
	  <?php 
             echo $this->Form->input('admission_type', array('id'=>'admission_type','label'=> false, 'div' => false, 'error' => false, 'options'=>array(''=>'All','IPD'=>'IPD','OPD'=>'OPD')));
          ?>
	 </td>
	</tr>
	<tr id="showIpdPatientStatus" style="display:none;">
	   <td colspan="8" align="right">Patient Status</td>
	   <td></td>
	   <td colspan="8" align="left">
	   <?php 
	         $opdoptions = array('' => 'All',
			                     '1' => 'Discharged',
			                     '0' => 'Not Discharged',
			                     );
             echo $this->Form->input('ipd_patient_status', array('id'=>'ipd_patient_status','label'=> false, 'div' => false, 'error' => false, 'options'=>$opdoptions));
          ?>
	  </td>
	 </tr>
	 <tr id="showOpdPatientStatus" style="display:none;">
	   <td colspan="8" align="right">Patient Status</td>
	   <td></td>
	   <td colspan="8" align="left">
	   <?php 
	         $opdoptions = array('' => 'All',
			                     '1' => 'OP Process Completed',
			                     '0' => 'OP In-Progress',
			                     );
             echo $this->Form->input('opd_patient_status', array('id'=>'opd_patient_status','label'=> false, 'div' => false, 'error' => false, 'options'=>$opdoptions));
          ?>
	  </td>
	 </tr>
	 <tr id="showSkipRegistration" style="display:none;">
	   <td colspan="8" align="right"></td>
	   <td></td>
	   <td colspan="8" align="left">
	   <?php 
	         $opdoptions = array('' => 'All',
			                     '4' => 'First Consultation',
			                     '5' => 'Follow-Up Consultation',
			                     '6' => 'Preventive Health Check-up',
			                     '7' => 'Vaccination',
			                     '8' => 'Pre-Employment Check-up',
			                     '9' => 'Pre Policy Check up',
			                     '0'=>'Skip Registration/Consultation');
             echo $this->Form->input('skip_registration', array('id'=>'skip_registration','label'=> false, 'div' => false, 'error' => false, 'options'=>$opdoptions));
          ?>
	  </td>
	 </tr>
        <tr>
	   <td colspan="8" align="right" valign="middle">Referral Doctor</td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
		  //echo $this->Form->input('PatientAdmissionReport.reference_doctor', array('empty'=>'All','id'=>'ref_docotr','label'=> false, 'div' => false, 'error' => false,'options'=>$refrences));
        ?>
		<?php					 
	                              echo $this->Form->input('known_fam_physician', array('empty'=>__('Please Select'),'autocomplete'=>"off", 'id'=>'familyknowndoctor','label'=>false,'class'=>'textBoxExpnd', 'options'=>$reffererdoctors,'onchange'=> $this->Js->request(array('action' => 'getDoctorsList','admin'=> false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
	    						 'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeDoctorsList', 'data' => '{familyknowndoctor:$("#familyknowndoctor").val()}', 'dataExpression' => true, 'div'=>false, ))));
	                          	?>
	                          
	  </td>
  </tr>
  <tr>
   <td colspan="8"></td>
   <td></td>
   <td id="changeDoctorsList"></td>
  </tr>
   
 </table>
    <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
				<input type="submit" value="Get Report" class="blueBtn" id="submit" onclick = "return getValidate();">&nbsp;&nbsp;
				<input type="submit" value="Show Graph" class="blueBtn" id="graph" onclick = "document.pressed=this.value" style="display:none;" >&nbsp;&nbsp;
				<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'grayBtn'));?>
		</div>
		
	 </div>

 </form> 
  <script language="javascript" type="text/javascript">
  $( "#reportfrm" ).click(function(){
	  var fromdate = new Date($( '#from' ).val());
      var todate = new Date($( '#to' ).val());
      if(fromdate.getTime() > todate.getTime()) {
       alert("To date should be greater than From date");
       return false;
      }
      
});	
     /*function getValidate(){  
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;
		var from = SDate.split('/');
		var to = EDate.split('/');
		var fromDate = from[1]+'/'+from[0]+'/'+from[2];
		var toDate = to[1]+'/'+to[0]+'/'+to[2];
		var startDate = new Date(fromDate);
		var endDate = new Date(toDate);
		if (SDate == '' || EDate == '') {
		 alert("Plesae enter both the dates!");
		 return false;
		}else if((startDate) > (endDate)){
		 alert("Please ensure that the End Date is greater than to the Start Date.");
		 return false;
		}
		
	}*/
        function checkFormat(get){
		var basePath = "<?php echo $this->webroot;?>";
		if(get == 'GRAPH'){
			
			$('#year').show();
			$('#month').show();
			$('#graph').show();
			document.getElementById('fromDate').style.display = 'none';
			document.getElementById('toDate').style.display = 'none';
			document.getElementById('submit').style.display = 'none';
		// Change the action graph
			document.reportfrm.action =basePath+"admin/reports/admission_report_by_reference_doctor_chart";
			
		} else {
			document.getElementById('year').style.display = 'none';
			document.getElementById('month').style.display = 'none';
			document.getElementById('graph').style.display = 'none';
			$('#fromDate').show();
			$('#toDate').show();
			$('#submit').show();
		// Change the action for pdf and excel
		document.reportfrm.action =basePath+"admin/reports/admission_report_by_reference_doctor";	

		}

		
	}
</script> 
<script>
$(function() {
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();
			//foramtEnddate(); //is not defined hence commented
		}		
	});	
		
 $("#to").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();
			//foramtEnddate(); //is not defined hence commented
		}	
	});
});	

	jQuery(document).ready(function(){
	jQuery('#admission_type').change(function() {  
	  if(jQuery('#admission_type').val() == "OPD") {
	   jQuery('#showSkipRegistration').show();
	   jQuery('#showOpdPatientStatus').show();
	   jQuery('#showIpdPatientStatus').hide();
	  } else if(jQuery('#admission_type').val() == "IPD") {
	    jQuery('#showIpdPatientStatus').show();
		jQuery('#showSkipRegistration').hide();
	    jQuery('#showOpdPatientStatus').hide();
	  } else {
	   jQuery('#ipd_patient_status').val('');
	   jQuery('#opd_patient_status').val('');
	   jQuery('#skip_registration').val('');
	   jQuery('#showSkipRegistration').hide();
	   jQuery('#showOpdPatientStatus').hide();
	   jQuery('#showIpdPatientStatus').hide();
	  }
	});
	// binds form submission and fields to the validation engine
	jQuery("#reportfrm").validationEngine();
	});
</script>
  
  