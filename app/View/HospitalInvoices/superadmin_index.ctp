

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
<h3>&nbsp; <?php echo __('Enterprise Invoice', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Enterprise Rate', true),array('controller' => 'hospital_invoices', 'action' => 'hospital_rate', 'superadmin' => true), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
 <form name="reportfrm" id="reportfrm" action="" method="post" >
 <table align="center" >
	<tr><td colspan="3">&nbsp;</td></tr>
	 <tr>
	   <td align="right"><?php echo __('Enterprise'); ?><font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td align="left">
		<?php 
        echo $this->Form->input('PatientAdmissionReport.hospital', array('class' => 'validate[required,custom[mandatory-select]]', 'id'=>'hospital', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'Select Hospital','options'=> $facilities,'default'=>$facility_id));?>
	    </td>
    </tr>
	 <tr>
	 <td align="right"><?php echo __('Format'); ?></td>
	 <td><b>:</b></td>
	 <td align="left" width="70%"><?php
		echo $this->Form->input('PatientAdmissionReport.format', array("onchange"=>"checkFormat(this.value);",'id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
		  
	 ?></td>
	 </tr>
	<tr id="fromDate">
	 <td align="right"><?php echo __('From'); ?><font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td align="left" style="width: 215px;" >
		<?php 
        echo $this->Form->input('PatientAdmissionReport.from', array('id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	  </tr>
	<tr id="toDate">
	   <td align="right"><?php echo __('To'); ?><font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td align="left">
		<?php 
        echo $this->Form->input('PatientAdmissionReport.to', array('id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	   
	</tr>
	   
	<tr>
	   <td align="right"><?php echo __('Patient Type'); ?></td>
	   <td><b>:</b></td>
	   <td align="left">
		<?php 
        echo $this->Form->input('PatientAdmissionReport.type', array('id'=>'patient_type','onchange'=>'getPerpose(this.value);','label'=> false, 'div' => false, 'error' => false,'empty'=>'All','options'=>array('IPD'=>'Inpatient','OPD'=>'Outpatient','Emergency'=>'Emergency')));?>
		
	  </td>
	   
  </tr>
  
 
  	<tr id="sex">
	   <td align="right"><?php echo __('Sex'); ?></td>
	   <td><b>:</b></td>
	   <td align="left">
		<?php 
        echo $this->Form->input('PatientAdmissionReport.sex', array('id'=>'to','label'=> false, 'div' => false, 'error' => false,'empty'=>'Select Sex','options'=>array('male'=>'Male','female'=>'Female')));?>
		
	  </td>
	   
  </tr>
    <tr id="age">
	   <td align="right"><?php echo __('Age'); ?></td>
	   <td><b>:</b></td>
	   <td align="left">
		<?php 
		$options = array('0-10'=>'0-10','11-20'=>'11-20','21-30'=>'21-30','31-40'=>'31-40','41-50'=>'41-50','51-60'=>'51-60','61-100'=>'61+');
        echo $this->Form->input('PatientAdmissionReport.age', array('id'=>'to','label'=> false, 'div' => false, 'error' => false,'options'=>$options,'empty'=>'Select Age'));?>
		
	  </td>
	   
  </tr>
  <tr id="bloodGroup">
	   <td align="right"><?php echo __('Blood Group'); ?></td>
	   <td><b>:</b></td>
	   <td align="left">
		<?php 
		$options = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
        echo $this->Form->input('PatientAdmissionReport.blood_group', array('empty'=>'Select Blood Group','id'=>'to','label'=> false, 'div' => false, 'error' => false,'options'=>$options));?>
		
	  </td>
	   
  </tr>
  
 </table>
 <div class="clr ht5"></div>

  <table width="38%" height="175px" cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center" id="fieldsSelect">
		<tr>
			<th width="100%" colspan="3">Press "ctrl" and select multiple field to be displayed in report</th>
			
		</tr>
		<tr>
		  <td valign="middle" align="center">
				<?php 
						echo $this->Form->input('PatientAdmissionReport.field_id',array('options'=>$fieldsArr,'escape'=>false,'div'=>false,'multiple'=>true,'style'=>'width:74%;min-height:135px;','id'=>'SelectRight','label'=>false));
				?>
		 </td>
		</tr>
   </table>
    <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
				<input type="submit" value="Get Report" class="blueBtn" id="submit" onclick = "return getValidate();">&nbsp;&nbsp;
				<?php echo $this->Html->link(__('Cancel', true),array('controller'=>'users','action' => 'common','superadmin'=>false ), array('escape' => false,'class'=>'grayBtn'));?>
		</div>
		
	 </div>

 </form> 
  <script language="javascript" type="text/javascript">
    
    function getValidate(){  
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;
		var type = document.getElementById('formattype').value;
		var SelectRight = document.getElementById('SelectRight').value;
		if(type=='EXCEL'){
			var from = SDate.split('/');
			var to = EDate.split('/');
			
			var fromDate = from[1]+'/'+from[0]+'/'+from[2];
			var toDate = to[1]+'/'+to[0]+'/'+to[2];
	
			var startDate = new Date(fromDate);
			var endDate = new Date(toDate);
			//alert(endDate);
			/*if($("#SelectRight option:selected").val() == 'undefined'){
				alert('Please select the field to be displayed.');
				return false;
	
			} else*/ if (SDate == '' || EDate == '') {
				alert("Plesae enter both the dates!");
				return false;
	
			}else if((startDate) > (endDate)){
				alert("Please ensure that the End Date is greater than to the Start Date.");
				
				return false;
			}
		}
		
		
	}

		

	</script> 
	
  <script language="javascript" type="text/javascript">
    function getValidate1(){  
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;

		var SelectRight = document.getElementById('SelectRight').value;
		
		var from = SDate.split('/');
		var to = EDate.split('/');
		
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

		} else if(SelectRight == ''){
			alert('Please Slelect the field to be displayed in report.');
			return false;

		} else if((startDate) > (endDate)){
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
			document.getElementById('fromDate').style.display = 'none';
			document.getElementById('toDate').style.display = 'none';
			document.getElementById('sex').style.display = 'none';
			document.getElementById('age').style.display = 'none';
			document.getElementById('bloodGroup').style.display = 'none';
			document.getElementById('fieldsSelect').style.display = 'none';
			document.getElementById('submit').style.display = 'none';
		// Change the action graph
			document.reportfrm.action =basePath+"superadmin/hospital_invoices/patient_admission_report_chart/<?php echo $facility_id; ?>";
			
		} else {
			document.getElementById('year').style.display = 'none';
			document.getElementById('month').style.display = 'none';
			document.getElementById('graph').style.display = 'none';
			$('#fromDate').show();
			$('#toDate').show();
			$('#sex').show();
			$('#age').show();
			$('#bloodGroup').show();
			$('#field').show();
			$('#submit').show();
		// Change the action for pdf and excel
		document.reportfrm.action =basePath+"superadmin/hospital_invoices/index/<?php echo $facility_id; ?>";	

		}

		
	}

	$(document).ready(function(){
	  // Call this function to show visit perpose or not
		
		var basePath = "<?php echo $this->webroot;?>";
		if($("#formattype option:selected").val() ==  'GRAPH'){
			
			$('#year').show();
			$('#month').show();
			document.getElementById('fromDate').style.display = 'none';
			document.getElementById('toDate').style.display = 'none';
			document.getElementById('sex').style.display = 'none';
			document.getElementById('age').style.display = 'none';
			document.getElementById('bloodGroup').style.display = 'none';
			document.getElementById('field').style.display = 'none';
			document.getElementById('submit').style.display = 'none';
		// Change the action graph
			document.reportfrm.action =basePath+"superadmin/hospital_invoices/patient_admission_report_chart/<?php echo $facility_id; ?>";
			
		} else {
			
			$('#fromDate').show();
			$('#toDate').show();
			$('#sex').show();
			$('#age').show();
			$('#bloodGroup').show();
			$('#field').show();
			$('#submit').show();
		// Change the action for pdf and excel
		document.reportfrm.action =basePath+"superadmin/hospital_invoices/index/<?php echo $facility_id; ?>";	

		}
	});


	/*$("#hospital").live("change",function(){ 
		if($(this).val() !=""){ 
			window.location.href = '<?php echo $this->Html->url(array("controller"=>"hospital_invoices",'action'=>"index","superadmin"=>true));?>/index/'+this.value;
		
		}
		
	});*/
	

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
			dateFormat:'<?php echo $this->General->GeneralDate();?>',			
		});	
			
	 $("#to").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',			
		});
	});	

	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#reportfrm").validationEngine();
	
	});
</script>