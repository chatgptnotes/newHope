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
<div class="inner_title">
<h3>&nbsp;<?php echo __('Appointment Report', true); ?></h3>

</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => "reports", "action" => "appointment")); ?>" method="post" >
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
             echo $this->Form->input('from', array('id'=>'from','label'=> false, 'div' => false, 'error' => false, 'class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;'));
           ?>
	  </td>
	</tr>
	<tr id="toDate">
	   <td colspan="8" align="right"><?php echo __('To'); ?><font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left">
	   <?php 
            echo $this->Form->input('to', array('id'=>'to','label'=> false, 'div' => false, 'error' => false, 'class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px;'));
           ?>
	  </td>
	 </tr>
	 
	<tr>
	 <td colspan="8" align="right"><?php echo __('Age'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left">
	 <?php 
		$options = array('0-10'=>'0-10','11-20'=>'11-20','21-30'=>'21-30','31-40'=>'31-40','41-50'=>'41-50','51-60'=>'51-60','61-100'=>'61+');
        echo $this->Form->input('age', array('id'=>'age','label'=> false, 'div' => false, 'error' => false,'options'=>$options,'empty'=>'Select Age'));
     ?>
	 </td>
	</tr>
	<tr>
	 <td colspan="8" align="right"><?php echo __('Sex'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left">
	  <?php 
             echo $this->Form->input('gender', array('id'=>'gender','label'=> false, 'div' => false, 'error' => false, 'empty'=> __('Select Sex'),'options'=>array('male'=>'Male','female'=>'Female')));
          ?>
	 </td>
	</tr>
	 <tr>
	 <td colspan="8" align="right"><?php echo __('Visit Type'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left">
	  <?php 
	         $options = array("First_Visit"=> "First Visit","Emergency"=> "Emergency","Follow_Up"=> "Follow-Up","Vaccination"=> "Vaccination");
             echo $this->Form->input('visit_type', array('id'=>'visit_type','label'=> false, 'div' => false, 'error' => false,'empty' => 'Select Visit Type', 'options'=>$options));
          ?>
	 </td>
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
	 <td colspan="8" align="right"><?php echo __('Doctor'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left" id="changeDoctorList">
	  <select name="name="data[doctor]" id="doctorlist">
	   <option value="">Select Doctor</option>
	  </select>
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
   /* function getValidate(){  
		
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