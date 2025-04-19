<?php 
//pr($data);exit;
  if(!empty($errors)) {
?>
<!-- <script>	
	
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#reportfrm").validationEngine();
	});
</script> -->

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
<h3>&nbsp; <?php echo __('Insurance wise Patient Report', true); ?></h3>

</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "admin_patient_sponsor_report/", )); ?>" method="post" >
 <table align="center" width="100%">
	 <tr>
	 <td colspan="8" align="right" width="38%">Format</td>
	 <td width="1%"><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('PatientRegistrationReport.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'onChange'=>'checkFormat(this.value);','options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF','GRAPH'=>'GRAPH')));
		//echo $this->Form->input('PatientRegistrationReport.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
	 </tr>
	 <tr id="fromDate">
	 <td colspan="8" align="right">From<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientRegistrationReport.from', array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	  </tr>
	<tr id="toDate">
	   <td colspan="8" align="right">To<font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientRegistrationReport.to', array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
		
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
	 <td valign="top"><b>:</b></td>
	 <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientRegistrationReport.year', array('id'=>'year','label'=> false, 'div' => false, 'error' => false,'options' =>$lastTenYear));?>
		
	 </td>
	</tr>
 <?php
	//$monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December',);
 ?>
	<!--<tr id="month" style="display:none;">
	   <td colspan="8" align="right">Month<font color="red">*</font></td>
		<td valign="top"><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        //echo $this->Form->input('PatientRegistrationReport.month', array('id'=>'month','label'=> false, 'div' => false, 'error' => false,'options' =>$monthArray,'empty'=>'All'));?>
		
	  </td>
	   
  </tr> -->
  <tr>
	   <td colspan="8" align="right">Patient Location</td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
              <select id="patient_location" name="data[PatientRegistrationReport][patient_location]">
                <option value="">All</option>
                <?php foreach($locationlist as $locationlistVal) { if($locationlistVal) { ?>
                 <option value="<?php echo $locationlistVal ?>"><?php echo $locationlistVal ?></option>
                <?php } } ?>
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

			echo $this->Form->input('PatientRegistrationReport.payment_category', array('style'=>'width:25%;','label'=>false,'empty'=>__('All'),'options'=>$paymentCategory,'class' => 'textBoxExpnd','id' => 'paymentType',
            'onchange'=> $this->Js->request(array('action' => 'getPaymentType','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 
'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{paymentType:$("#paymentType").val()}', 'dataExpression' => true, 'div'=>false)))); 
        ?>
		
	  </td>
	   
  </tr>
  <tr>
	<td colspan="8" align="right" valign="top">&nbsp;</td>
	<td valign="top">&nbsp;</td>
	<td colspan="8" align="left" id="changeCreditTypeList">
	
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

	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#reportfrm").validationEngine();
		});

	   $( "#reportfrm" ).click(function(){
		   var fromdate = new Date($( '#from' ).val());
	        var todate = new Date($( '#to' ).val());
	        if(fromdate.getTime() > todate.getTime()) {
            alert("To date should be greater than from date");
            return false;
           }
           
});	
	    
   /* function getValidate(){

		var sponsorText = $("#paymentType option:selected").text();
		var sponsorValue = $("#paymentType option:selected").val();		 
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;
		
		
		var from = SDate.split('-');
		var to = EDate.split('-');
		
		var fromDate = from[1]+'/'+from[0]+'/'+from[2];
		var toDate = to[1]+'/'+to[0]+'/'+to[2];

		var startDate = new Date(fromDate);
		var endDate = new Date(toDate);
		//alert(endDate);
	// TO Check start date and end date
		if (SDate == '' || EDate == '') {
		//	alert("Plesae enter both the dates!");
			return false;
		
		} else if((startDate) > (endDate)){
		//	alert("Please ensure that the End Date is greater than to the Start Date.");
			
			return false;
		}*/
	// To validate sponsor details
		/*if(sponsorText == 'Card'){
			if($("#corporate_id option:selected").val() == ''){
				alert('Please select credit type.');
				return false;
			} else if($("#corporate option:selected").val() == ''){
				alert('Please select corporate location.');
				return false;

			} else if($("#subLocation option:selected").val() == ''){
				alert('Please select corporate name.');
				return false;

			} else if($("#insType option:selected").val() == ''){
				alert('Please select insurence company type .');
				return false;	
			
			} else if($("#insurenceCom option:selected").val() == ''){
				alert('Please select insurence company.');
				return false;			
			}
	
		} 

  }*/

 // Validate the graph

		function getChecked(){

		var sponsorText = $("#paymentType option:selected").text();
		var sponsorValue = $("#paymentType option:selected").val();		 
		
		
	// To validate sponsor details
	/*	if(sponsorText == 'Card'){
			if($("#corporate_id option:selected").val() == ''){
				alert('Please select credit type.');
				return false;
			} else if($("#corporate option:selected").val() == ''){
				alert('Please select corporate location.');
				return false;

			} else if($("#subLocation option:selected").val() == ''){
				alert('Please select corporate name.');
				return false;

			} else if($("#insType option:selected").val() == ''){
				alert('Please select insurence company type .');
				return false;	
			
			} else if($("#insurenceCom option:selected").val() == ''){
				alert('Please select insurence company.');
				return false;			
			}
	
		} else if(sponsorValue == ''){
			alert('Please select sponsor details.');
				return false;
		} */

  }
 
 // TO set the format wise date or year selection
	function checkFormat(get){
		var basePath = "<?php echo $this->webroot;?>";
		if(get == 'GRAPH'){
			
			$('#year').show();
			$('#month').show();
			$('#graph').show();
			$('#sponsor-red').show();
			document.getElementById('fromDate').style.display = 'none';
			document.getElementById('toDate').style.display = 'none';			
			document.getElementById('submit').style.display = 'none';
		// Change the action graph
			document.reportfrm.action =basePath+"admin/reports/patient_sponsor_report_chart";
			
		} else {
			$('#fromDate').show();
			$('#toDate').show();
			document.getElementById('year').style.display = 'none';
			//document.getElementById('month').style.display = 'none';
			document.getElementById('graph').style.display = 'none';	
			
			$('#submit').show();
		// Change the action for pdf and excel
			document.reportfrm.action =basePath+"admin/reports/patient_sponsor_report";	

		}

		
	}

$(document).ready(function(){
	  
		var basePath = "<?php echo $this->webroot;?>";
		var sponsorText = $("#paymentType option:selected").text();
		var sponsorValue = $("#paymentType option:selected").val();	

		if($("#formattype option:selected").val() ==  'GRAPH'){
			
			$('#year').show();
			$('#month').show();
			$('#graph').show();
			document.getElementById('fromDate').style.display = 'none';
			document.getElementById('toDate').style.display = 'none';
			document.getElementById('submit').style.display = 'none';
		// Change the action graph
			document.reportfrm.action =basePath+"admin/reports/patient_sponsor_report_chart";
			
		} else {
			$('#fromDate').show();
			$('#toDate').show();
			document.getElementById('year').style.display = 'none';
			//document.getElementById('month').style.display = 'none';
			document.getElementById('graph').style.display = 'none';		
			$('#submit').show();
		// Change the action for pdf and excel
		document.reportfrm.action =basePath+"admin/reports/patient_sponsor_report";	

		}
	});
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
		});
	});	

  
</script>