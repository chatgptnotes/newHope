<style>
td{ font-size:13px;}
</style>

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
<h3>&nbsp; <?php echo __('Total Number Of UID Registrations', true); ?></h3>

</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "admin_patient_registration_report/", )); ?>" method="post" >
 <table align="center">
	
	<!-- <tr>
	 <td colspan="8" align="right">Report Type</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('PatientRegistrationReport.type', array('id' => 'itemtype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('Daily'=>'Daily','Weekly'=>'Weekly','Monthly'=>'Monthly','Yearly'=>'Yealy')));
	 ?></td>
	 </tr> -->
	 <tr>
	 <td colspan="8" align="right" class="tdLabel">Format</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left" class="tdLabel"><?php
		echo $this->Form->input('PatientRegistrationReport.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
	 </tr>
	<tr>
	 <td colspan="8" align="right" class="tdLabel">From<font color="red">*</font></td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left" class="tdLabel">
		<?php 
        echo $this->Form->input('PatientRegistrationReport.from', array('class'=>'textBoxExpnd validate[required,custom[mandatory-date]] ','style'=>'width:120px','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	  </tr>
	<tr>
	   <td colspan="8" align="right" class="tdLabel">To<font color="red">*</font></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left" class="tdLabel">
		<?php 
        echo $this->Form->input('PatientRegistrationReport.to', array('class'=>'textBoxExpnd  validate[required,custom[mandatory-date]]','style'=>'width:120px','id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	   
  </tr>
  	<tr>
	   <td colspan="8" align="right" class="tdLabel"><?php echo __('Sex'); ?></td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left" class="tdLabel">
		<?php 
        echo $this->Form->input('PatientRegistrationReport.sex', array('id'=>'sex','label'=> false, 'div' => false, 'error' => false,'empty'=>'All','options'=>array('male'=>'Male','female'=>'Female')));?>
		
	  </td>
	   
  </tr>
    <tr>
	   <td colspan="8" align="right" class="tdLabel">Age</td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left" class="tdLabel">
		<?php 
		$options = array('0-10'=>'0-10','11-20'=>'11-20','21-30'=>'21-30','31-40'=>'31-40','41-50'=>'41-50','51-60'=>'51-60','61-100'=>'61+');
        echo $this->Form->input('PatientRegistrationReport.age', array('id'=>'age','label'=> false, 'div' => false, 'error' => false,'options'=>$options,'empty'=>'All'));?>
		
	  </td>
	   
  </tr>
  <!--<tr>
	   <td colspan="8" align="right" class="tdLabel">Blood Group</td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left" class="tdLabel">
		<?php 
		$options = array('A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-');
        echo $this->Form->input('PatientRegistrationReport.blood_group', array('id'=>'blood_group','empty'=>'All','id'=>'to','label'=> false, 'div' => false, 'error' => false,'options'=>$options));?>
		
	  </td>
	   
  </tr>
  <tr>
	   <td colspan="8" align="right" class="tdLabel">Patient Location</td>
	   <td><b>:</b></td>
	   <td colspan="8" align="left" class="tdLabel">
              <select id="patient_location" name="data[PatientRegistrationReport][patient_location]">
                <option value="">Please Select</option>
                <?php foreach($locationlist as $locationlistVal) { if($locationlistVal) { ?>
                 <option value="<?php echo $locationlistVal ?>"><?php echo $locationlistVal ?></option>
                <?php } } ?>
              </select>
	  </td>
  </tr> -->
 
 </table>
 <div class="clr ht5"></div>
  <table width="38%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center" id="fieldsSelect">
		<tr>
			<th width="100%" colspan="3">Press "ctrl" and select multiple field to be displayed in report</th>
			
		</tr>
		<tr>
		  <td valign="top" align="center" class="tdLabel">
				<?php 
						echo $this->Form->input('PatientRegistrationReport.field_id',array('options'=>$fieldsArr,'escape'=>false,'multiple'=>true,'style'=>'width:62%;min-height:106px;','id'=>'SelectRight','label'=>false));
				?>
		 </td>
		</tr>
   </table>
   <p class="ht5"></p>
   <div align="center">
  
	<div class="btns" style="float:none">
			<input type="submit" value="Get Report" class="blueBtn" id="submit" onclick = "return getValidate();">
                        &nbsp;&nbsp;
                         <?php //echo $this->Html->link(__('Show Graph', true),array('action' => 'patient_registration_chart','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
                        
			<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'grayBtn'));?>
	</div>
	
 </div>

 </form>
 <table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th> UID </th>
            <th>Patient ID</th>
            <th>Patient Name</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Address</th>
            <th>Payment Mode</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($reports)): ?>
            <?php foreach ($reports as $key => $report): ?>
                <tr>
                    <!-- Serial Number -->
                    <td><?= h($key + 1); ?></td>
                    
                    <!-- Date Of UID Reg. -->
                    <td><?= h(date('d-m-Y', strtotime($report['Person']['create_time']))); ?></td>
                    
                    <!-- Patient ID -->
                    <td><?= h($report['Person']['patient_uid']); ?></td>
                    
                    <!-- Patient Name -->
                    <td><?= h($report[0]['first_name']); ?> <?= h($report[0]['last_name']); ?></td>
                    
                    <!-- Age -->
                    <td><?= h($report['Person']['age']); ?></td>
                    
                    <!-- Sex -->
                    <td><?= h($report['Person']['sex']); ?></td>
                    
                    <!-- Address -->
                    <td><?= h($report[0]['payment_category']); ?></td>
                     <td><?= h($report['Person']['payment_category']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align: center;">No Records Found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

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
  <script language="javascript" type="text/javascript">
	  jQuery(document).ready(function(){
		  $()
		  $('#formattype').change(function(){
			  	if($(this).val()=='PDF'){
			  		$('#fieldsSelect').fadeOut();
				}else{
					$('#fieldsSelect').fadeIn();
				}
			  	$('#from').val('');
			  	$('#to').val('');
			  	$('#sex').val('');
			  	$('#age').val('');
			  	$('#blood_group').val('');
		  });
		  
	  });


	   $( "#reportfrm" ).click(function(){
		   var fromdate = new Date($( '#from' ).val());
	        var todate = new Date($( '#to' ).val());
	        if(fromdate.getTime() > todate.getTime()) {
            alert("To date should be greater than from date");
            return false;
           }
           
});	
	  

	  
    function getValidate(){  
		
		var SDate = document.getElementById('from').value;
		var EDate = document.getElementById('to').value;
		var type = document.getElementById('formattype').value;
		var SelectRight = document.getElementById('SelectRight').value;
                
		if(type=='EXCEL'){
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
	}
</script> 