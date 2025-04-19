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

	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#reportfrm").validationEngine();
	});
</script>

<?php 

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
<h3>&nbsp; <?php echo __('Total Surgery Report', true); ?></h3>

</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "admin_patient_ot_report/", )); ?>" method="post" >
 <table align="center">
	
	
	 <tr>
	 <td colspan="8" align="right">Format</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('PatientOtReport.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
	 </tr>
	<tr>
	 <td colspan="8" align="right">From<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientOtReport.from', array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	  </tr>
	<tr>
	   <td colspan="8" align="right">To<font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
        echo $this->Form->input('PatientOtReport.to', array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;','id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	   
  </tr>
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
		echo $this->Form->input('PatientOtReport.surgery', array('id' => 'itemtype', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'All','options'=>$sergery,'style'=>'width:15% !important '));
	 ?></td>
</tr>
  <tr>
	 <td colspan="8" align="right"><?php echo __('Specilty'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left">
	  <?php 
             echo $this->Form->input('department', array('id'=>'department','label'=> false, 'div' => false, 'error' => false, 'empty'=>'Select Department','options'=>$departmentList,'onchange'=> $this->Js->request(array('action' => 'getDepartmentDoctorsList','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeDoctorList', 'data' => '{deptid:$("#department").val()}', 'dataExpression' => true, 'div'=>false))));
          ?>
	 </td>
	</tr>
	 <tr>
	 <td colspan="8" align="right"><?php echo __('Doctor');  ?> </td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left" id="changeDoctorList">
	  <select name="name="data[doctor]" id="doctorlist">
	   <option value="">Select Doctor</option>
	  </select>
	 </td>
	</tr>	
    <tr>
	   <td colspan="8" align="right">Procedure Complete</td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
		<?php 
		$options = array('1'=>'Yes','0'=>'No');
        echo $this->Form->input('PatientOtReport.procedure_complete', array('id'=>'procedure_complete','empty'=>'All','label'=> false, 'div' => false, 'error' => false,'options'=>$options));?>
		
	  </td>
	   
  </tr>

 </table>
  
 
	   <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
				<input type="submit" value="Get Report" class="blueBtn" id="submit" onclick="return getValidate();">
                                &nbsp;&nbsp;
                                <?php //echo $this->Html->link(__('Show Graph', true),array('action' => 'patient_ot_chart','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
                               
				<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
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
 /*   function getValidate(){  
		
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
			//alert("Plesae enter both the dates!");
			return false;

		} else if((startDate) > (endDate)){
		//	alert("Please ensure that the End Date is greater than to the Start Date.");
			
			return false;
		}
		
		
	}*/

		

	</script> 