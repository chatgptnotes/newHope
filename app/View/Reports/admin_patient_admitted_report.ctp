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
	// binds form submission and fields to the validation engine
	jQuery("#reportfrm").validationEngine();
	});
</script>

<?php 
//pr($data);exit;
  if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Patient Check-in Report', true); ?></h3>

</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "admin_patient_admitted_report/", )); ?>" method="post" >
 <table align="center">
	 <tr>
	 <td colspan="8" align="right"><?php echo __('Format'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left" width="70%"><?php
		echo $this->Form->input('PatientAdmissionReport.format', array("onchange"=>"checkFormat(this.value);",'id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF','GRAPH'=>'GRAPH')));
		  
	 ?></td>
	 </tr>
	<tr id="fromDate">
	 <td colspan="8" align="right"><?php echo __('From'); ?><font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left" style="width: 215px;" >
		<?php 
        echo $this->Form->input('PatientAdmissionReport.from', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	  </tr>
	<tr id="toDate">
	   <td colspan="8" align="right"><?php echo __('To'); ?><font color="red">*</font></td>
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
		 <td colspan="8" align="right"><?php echo __('Year'); ?><font color="red">*</font></td>
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
		   <td colspan="8" align="right"><?php echo __('Month'); ?><font color="red">*</font></td>
		   <td><b>:</b></td>
		   <td colspan="8" align="left">
			<?php 
	        echo $this->Form->input('PatientAdmissionReport.month', array('id'=>'month','label'=> false, 'div' => false, 'error' => false,'options' =>$monthArray,'empty'=>'All'));?>
			
		  </td>
		   
	  </tr>
	<tr id="sex">
	   <td colspan="8" align="right"><?php echo __('Sex'); ?></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientAdmissionReport.sex', array('id'=>'to','label'=> false, 'div' => false, 'error' => false,'empty'=>'Select Sex','options'=>array('male'=>'Male','female'=>'Female')));?>
		
	  </td>
	   
  </tr>
    <tr id="age">
	   <td colspan="8" align="right"><?php echo __('Age'); ?></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
		$options = array('0-10'=>'0-10','11-20'=>'11-20','21-30'=>'21-30','31-40'=>'31-40','41-50'=>'41-50','51-60'=>'51-60','61-100'=>'61+');
        echo $this->Form->input('PatientAdmissionReport.age', array('id'=>'to','label'=> false, 'div' => false, 'error' => false,'options'=>$options,'empty'=>'Select Age'));?>
		
	  </td>
	   
  </tr>
  <tr id="bloodGroup">
	   <td colspan="8" align="right"><?php echo __('Blood Group'); ?></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
		$options = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
        echo $this->Form->input('PatientAdmissionReport.blood_group', array('empty'=>'Select Blood Group','id'=>'to','label'=> false, 'div' => false, 'error' => false,'options'=>$options));?>
		
	  </td>
	   
  </tr>
 <tr>
	   <td colspan="8" align="right"><?php echo __('Specilty'); ?></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientAdmissionReport.department_type', array('id'=>'department','label'=> false, 'div' => false, 'error' => false,'empty'=>'Select Specilty','options'=>$departmentList,'onchange'=> $this->Js->request(array('action' => 'getDepartmentDoctorsList','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeDoctorList', 'data' => '{deptid:$("#department").val()}', 'dataExpression' => true, 'div'=>false))));?>
	  </td>
	   
  </tr>
   <tr>
	 <td colspan="8" align="right"><?php echo __('Doctor'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left" id="changeDoctorList">
	  <select name="name="data[doctor]" id="doctorlist">
	   <option value="">Select Doctor</option>
	  </select>
	 </td>
	</tr>
   <tr>
	   <td colspan="8" align="right" valign="top">Sponsor Details</td>
	   <td valign="top"><b>:</b></td>
	   <td colspan="8" align="left">
		<!-- <?php echo $this->Form->input('PatientRegistrationReport.sponsor', array('div' => false,'label' => false,'empty'=>'Self Pay','options'=>array('1'=>'Corporate','2'=>'Insurance'),'id' => 'corporate_id','onchange'=> $this->Js->request(array('action' => 'getcorporate','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{corporateType:$("#corporate_id").val()}', 'dataExpression' => true, 'div'=>false))));  ?> -->

		<?php 
			$paymentCategory = array('cash'=>'Self Pay','card'=>'Card');

			echo $this->Form->input('PatientRegistrationReport.payment_category', array('style'=>'width:100px;','label'=>false,'empty'=>__('All'),'options'=>$paymentCategory,'class' => 'textBoxExpnd','id' => 'paymentType','onchange'=> $this->Js->request(array('action' => 'getPaymentType','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{paymentType:$("#paymentType").val()}', 'dataExpression' => true, 'div'=>false)))); 
        ?>
		
	  </td>
	   
  </tr>
  <tr>
	<td colspan="8" align="right" valign="top">&nbsp;</td>
	<td valign="top">&nbsp;</td>
	<td colspan="8" align="left" id="changeCreditTypeList"></td>
  </tr>
 </table>
 <div class="clr ht5"></div>

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
  jQuery(document).ready(function(){
	  $('#formattype').change(function(){
		  	if($(this).val()=='PDF' || $(this).val()=='GRAPH'){
		  		$('#fieldsSelect').fadeOut();
			}else{
				$('#fieldsSelect').fadeIn();
			}
			
	  });
	  
  });
  function getValidate(){  
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;
		var type = document.getElementById('formattype').value;
		//var SelectRight = document.getElementById('SelectRight').value;
		if(type=='EXCEL'){
			var from = SDate.split('/');
			var to = EDate.split('/');
			
			var fromDate = from[1]+'/'+from[0]+'/'+from[2];
			var toDate = to[1]+'/'+to[0]+'/'+to[2];
	
			var startDate = new Date(fromDate);
			var endDate = new Date(toDate);*/
			//alert(endDate);
			if($("#SelectRight option:selected").val() == 'undefined'){
				alert('Please select the field to be displayed.');
				return false;
	
			} else if (SDate == '' || EDate == '') {
				alert("Plesae enter both the dates!");
				return false;
	
			}else if((startDate) > (endDate)){
				alert("Please ensure that the End Date is greater than to the Start Date.");
				
				return false;
			}
		}
		
		
	}

	   $( "#reportfrm" ).click(function(){
		   var fromdate = new Date($( '#from' ).val());
	        var todate = new Date($( '#to' ).val());
	        if(fromdate.getTime() > todate.getTime()) {
            alert("To date should be greater than from date");
            return false;
           }
           
});	

	</script> 
	
  <script language="javascript" type="text/javascript">
    function getValidate1(){  
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;

		//var SelectRight = document.getElementById('SelectRight').value;
		
		var from = SDate.split('/');
		var to = EDate.split('/');
		
		var fromDate = from[1]+'/'+from[0]+'/'+from[2];
		var toDate = to[1]+'/'+to[0]+'/'+to[2];

		var startDate = new Date(fromDate);
		var endDate = new Date(toDate);
		//alert(endDate);
		 if (SDate == '' || EDate == '') {
			alert("Plesae enter both the dates!");
			return false;

		}  else if((startDate) > (endDate)){
			alert("Please ensure that the End Date is greater than to the Start Date.");
			
			return false;
		}
		
		
	}

// TO set the format wise date or year selection
	function checkFormat(get){
		var basePath = "<?php echo $this->webroot;?>";
		if(get == 'GRAPH'){
			
			$('#year').show();
			$('#month').show();
			$('#graph').show();
			document.getElementById('fromDate').style.display = 'none';
			document.getElementById('toDate').style.display = 'none';
			document.getElementById('sex').style.display = 'none';
			document.getElementById('age').style.display = 'none';
			document.getElementById('bloodGroup').style.display = 'none';
			document.getElementById('submit').style.display = 'none';
		// Change the action graph
			document.reportfrm.action =basePath+"admin/reports/patient_admitted_report_chart";
			
		} else {
			document.getElementById('year').style.display = 'none';
			document.getElementById('month').style.display = 'none';
			document.getElementById('graph').style.display = 'none';
			$('#fromDate').show();
			$('#toDate').show();
			$('#sex').show();
			$('#age').show();
			$('#bloodGroup').show();
			$('#submit').show();
		// Change the action for pdf and excel
		document.reportfrm.action =basePath+"admin/reports/patient_admitted_report";	

		}

		
	}

	$(document).ready(function(){
	  // Call this function to show visit perpose or not
		//getPerpose($('#patient_type').val());

		var basePath = "<?php echo $this->webroot;?>";
		if($("#formattype option:selected").val() ==  'GRAPH'){
			
			$('#year').show();
			$('#month').show();
			$('#graph').show();
			document.getElementById('fromDate').style.display = 'none';
			document.getElementById('toDate').style.display = 'none';
			document.getElementById('sex').style.display = 'none';
			document.getElementById('age').style.display = 'none';
			document.getElementById('bloodGroup').style.display = 'none';
			//document.getElementById('field').style.display = 'none';
			document.getElementById('submit').style.display = 'none';
		// Change the action graph
			document.reportfrm.action =basePath+"admin/reports/patient_admitted_report_chart";
			
		} else {
			document.getElementById('year').style.display = 'none';
			document.getElementById('month').style.display = 'none';
			document.getElementById('graph').style.display = 'none';
			$('#fromDate').show();
			$('#toDate').show();
			$('#sex').show();
			$('#age').show();
			$('#bloodGroup').show();
			//$('#field').show();
			$('#submit').show();
		// Change the action for pdf and excel
		document.reportfrm.action =basePath+"admin/reports/patient_admitted_report";	

		}
	});

</script> 