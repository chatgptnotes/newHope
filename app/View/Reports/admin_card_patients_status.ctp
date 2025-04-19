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
<div class="inner_title">
<h3>&nbsp;<?php echo __('Card Patients Status', true); ?></h3>

</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => "reports", "action" => "card_patients_status")); ?>" method="post" >
 <table align="center">

	<tr>
	 <td colspan="8" align="right"><?php echo __('Format'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('format', array('id' => 'format', 'label'=> false, 'div' => false, 'error' => false,'onChange'=>'checkFormat(this.value);','options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
	 </tr>
	<tr id="fromDate">
	 <td colspan="8" align="right"><?php echo __('From'); ?><font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left">
	   <?php 
             echo $this->Form->input('from', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'from','label'=> false, 'div' => false, 'error' => false));
           ?>
	  </td>
	</tr>
	<tr id="toDate">
	   <td colspan="8" align="right"><?php echo __('To'); ?><font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
	   <?php 
            echo $this->Form->input('to', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'to','label'=> false, 'div' => false, 'error' => false));
           ?>
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
	  <td colspan="8" align="right"><?php echo __('Year'); ?><font color="red">*</font></td>
	  <td><b>:</b></td>
	  <td colspan="8" align="left">
	   <?php 
	      echo $this->Form->input('year', array('id'=>'year','label'=> false, 'div' => false, 'error' => false,'options' =>$lastTenYear));
           ?>
	  </td>
	 </tr>
	  <?php
		$monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December',);
	  ?>
	<tr id="month" style="display:none;">
	 <td colspan="8" align="right"><?php echo __('Month'); ?><font color="red">*</font></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left">
	  <?php 
	    echo $this->Form->input('month', array('id'=>'month','label'=> false, 'div' => false, 'error' => false,'options' =>$monthArray,'empty'=>'All'));
          ?>
	 </td>
	</tr>
	<tr>
	 <td colspan="8" align="right"><?php echo __('Patient Type'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left">
	  <?php 
             echo $this->Form->input('admission_type', array('id'=>'admission_type','label'=> false, 'div' => false, 'error' => false, 'empty'=>'All','options'=>array('IPD'=>'IPD','OPD'=>'OPD')));
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
      </table>
      <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
			<input type="submit" value="Get Report" class="blueBtn" id="submit" onClick="return getValidate();">&nbsp;&nbsp;
				<input type="submit" value="Show Graph" class="blueBtn" id="graph" onclick = "return getChecked();" style="display:none;" >&nbsp;&nbsp;
				<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'grayBtn'));?>
		</div>		
	 </div>
 </form>
  <script language="javascript" type="text/javascript">

  $( "#reportfrm" ).click(function(){
	  var fromdate = new Date($( '#from' ).val());
	     var todate = new Date($( '#to' ).val());
	     if(fromdate.getTime() > todate.getTime()) {
       alert("To date should be greater than from date");
       return false;
      }
      
});	
 
          
    /*function getValidate(){  
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;

		 
		
		var from = SDate.split('-');
		var to = EDate.split('-');
		
		var fromDate = from[1]+'/'+from[0]+'/'+from[2];
		var toDate = to[1]+'/'+to[0]+'/'+to[2];

		var startDate = new Date(fromDate);
		var endDate = new Date(toDate);
		//alert(endDate);
		if($("#SelectRight option:selected").val() == 'undefined'){
			alert('Please select the field to be displayed.');
			return false;

		} else if (SDate == '' || EDate == '') {
			alert("Plesae enter both the dates!");
			return false;

		} else if((startDate) > (endDate)){
			alert("Please ensure that the End Date is greater than to the Start Date.");
			
			return false;
		}
		
		
	}*/
		


</script> 