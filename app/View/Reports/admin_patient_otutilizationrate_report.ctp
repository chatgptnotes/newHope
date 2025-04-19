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
			dateFormat: 'dd/mm/yy',			
		});	
			
	 $("#to").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'dd/mm/yy',			
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
<h3>&nbsp; <?php echo __('OT Utilization Rate', true); ?></h3>

</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "admin_patient_otutilizationrate_report/", )); ?>" method="post" >
 <table align="center">
	
	
	 <tr>
	 <td colspan="8" align="right">Format</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('PatientOtReport.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'onChange'=>'checkFormat(this.value);','options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF','GRAPH'=>'GRAPH')));
	 ?></td>
	 </tr>
	 <tr id="fromDate">
	 <td colspan="8" align="right">From<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientOtReport.from', array('id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	  </tr>
	<tr id="toDate">
	   <td colspan="8" align="right">To<font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientOtReport.to', array('id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
		
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
        echo $this->Form->input('PatientRegistrationReport.year', array('id'=>'year','label'=> false, 'div' => false, 'error' => false,'options' =>$lastTenYear));?>
		
	 </td>
	</tr>
 <?php
	$monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December',);
 ?>
	<!-- <tr id="month" style="display:none;">
	   <td colspan="8" align="right">Month<font color="red">*</font></td>
		<td valign="top"><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientRegistrationReport.month', array('id'=>'month','label'=> false, 'div' => false, 'error' => false,'options' =>$monthArray,'empty'=>'All'));?>
		
	  </td>
	   
  </tr>  -->
  <tr>
	   <td colspan="8" align="right">Type of Surgery</td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientOtReport.sergery_type', array('id'=>'to','label'=> false, 'div' => false, 'error' => false,'empty'=>'All','options'=>array('major'=>'Major','minor'=>'minor')));?>
		
	  </td>
	   
  </tr>
  <tr>
	 <td colspan="8" align="right">Surgery</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('PatientOtReport.surgery', array('id' => 'itemtype', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'All','options'=>$sergery));
	 ?></td>
</tr>
  	
    
      
   <!-- <tr>
	   <td colspan="8" align="right">&nbsp;</td>
	   <td>&nbsp;</td>
	   
	  <td id="changeCreditTypeList" align="left"> &nbsp;</td>
  </tr> -->
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
    function getValidate(){  
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;		
		
		var from = SDate.split('-');
		var to = EDate.split('-');
		
		var fromDate = from[1]+'/'+from[0]+'/'+from[2];
		var toDate = to[1]+'/'+to[0]+'/'+to[2];

		var startDate = new Date(fromDate);
		var endDate = new Date(toDate);
		//alert(endDate);
		 if (SDate == '' || EDate == '') {
			alert("Plesae enter both the dates!");
			return false;

		} else if((startDate) > (endDate)){
			alert("Please ensure that the End Date is greater than to the Start Date.");
			
			return false;
		}
		
		
	}
// to check graph

$(document).ready(function(){
	var basePath = "<?php echo $this->webroot;?>";
	if($("#formattype option:selected").val() ==  'GRAPH'){			
			$('#year').show();
			$('#month').show();
			$('#graph').show();
			document.getElementById('fromDate').style.display = 'none';
			document.getElementById('toDate').style.display = 'none';
			document.getElementById('submit').style.display = 'none';
		// Change the action graph
			document.reportfrm.action =basePath+"admin/reports/otutilizationrate_report_chart";
			
		} else {
			$('#fromDate').show();
			$('#toDate').show();
			document.getElementById('year').style.display = 'none';
			//document.getElementById('month').style.display = 'none';
			document.getElementById('graph').style.display = 'none';		
			$('#submit').show();
		// Change the action for pdf and excel
		document.reportfrm.action =basePath+"admin/reports/patient_otutilizationrate_report";	

		}
})

// TO set the format wise date or year selection
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
			document.reportfrm.action =basePath+"admin/reports/otutilizationrate_report_chart";
			
		} else {
			$('#fromDate').show();
			$('#toDate').show();
			document.getElementById('year').style.display = 'none';
			//document.getElementById('month').style.display = 'none';
			document.getElementById('graph').style.display = 'none';	
			
			$('#submit').show();
		// Change the action for pdf and excel
			document.reportfrm.action =basePath+"admin/reports/patient_otutilizationrate_report";	

		}

		
	}

	</script> 