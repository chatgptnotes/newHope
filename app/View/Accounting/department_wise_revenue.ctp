<script>
$(function() {
	$("#from").datepicker({
		showOn: "both",
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
		showOn: "both",
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
<style>
    .textW{
        width: 120px;
    }
    .tabularForm {
	    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
	    background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 5px 10px;
	}
        
        
         .tabularForm th {
            text-align: center !important;
         }
         .alignment{
            text-align: center;
            vertical-align: middle;
         }
</style>
<div class="inner_title">
<h3>&nbsp;<?php echo __('Department Wise Revenue', true); ?></h3>
<span class="" >
			
<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
</span>	
</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "department_wise_revenue")); ?>" method="post" >
 <table align="center">

	<tr>
	
		<td align="right"><?php echo __('Year') ?> :</td>
		<td class="row_format"><?php  
		$currentYear = date("Y");
		for($i=0;$i<=10;$i++) {
			$lastTenYear[$currentYear] = $currentYear;
			$currentYear--;
		}
		echo    $this->Form->input(null, array('name' => 'reportYear', 'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'reportYear', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$lastTenYear, 'value' =>$reportYear));
		?></td>
	
		<td align="right"><?php echo __('Month') ?> :</td>
		<td class="row_format"><?php 
		$monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December',);
		echo $this->Form->input(null, array('name' => 'reportMonth', 'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'reportMonth', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$monthArray, 'empty'=> 'Select', 'value' =>$reportMonth));
		?></td>

       
	  
	<td><?php echo __('Select Type'); ?></td>
	 <td>
	  <?php 
             echo $this->Form->input('billtype', array('class'=>'textBoxExpnd textW','id'=>'bill_type','label'=> false, 'div' => false, 'error' => false, 'options'=>array('TOTAL BILL'=>'TOTAL BILL','RADIOLOGY'=>'RADIOLOGY','LABORATORY'=>'LABORATORY','PHARMACY'=>'PHARMACY')));
          ?>
	 </td>

         <td>
            <input type="submit" value="Get Report" class="blueBtn" id="submit" onClick="return getValidate();">&nbsp;&nbsp;
           
         </td>
         <td><?php echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>'Accounting','action'=>'department_wise_revenue','excel','?'=>$this->params->query,'admin'=>false,'alt'=>'Export To Excel'),array('escape'=>false,'title' => 'Export To Excel'))?><?php echo $this->Form->end();?></td>
        </tr>
	
	
	<?php /*
			$currentYear = date("Y");
			 for($i=0;$i<=10;$i++) {
				$lastTenYear[$currentYear] = $currentYear;
				$currentYear--;
			 }*/
	  ?>
	 
	<!-- 
 
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
	</tr>-->

      </table>
      
 </form>
 
<?php if($getBillingCash){?>
<?php $totalAmount = 0; ?>
<table  width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
     <thead>
        <tr class="row_title">
             <th colspan = "12" align="center"><h3>Billing</h3></th>
         </tr>
    </thead>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">

 <thead>
    <tr class="row_title">
    
     <th class="alignment" ><strong><?php echo __('Department'); ?></strong></th>	
     <th class="alignment"><strong><?php echo __('Total Revenue'); ?></strong></td>
    </tr>
  </thead>
 <?php 
        // get billing cash //
        if(count($getBillingCash) > 0) {
 ?>
  
 <?php 
		foreach($getBillingCash as $key=> $getBillingCashVal) {
          	if($key == '')continue;
            foreach ($getBillingCashVal as $bKey => $Bvalue) {
               if($Bvalue['Department']['name']==$key){
               	$totalOfDept[$key] += $Bvalue[0]['sum_amount'];
				}

            }  
           $totalBillAmt += $totalOfDept[$key];        
 ?>
        <tr>		
        	
            <td align='center' height='17px'><?php echo $key ?></td>
         	<td align='center' height='17px'><?php if(!empty($totalOfDept[$key])){
            										echo round($totalOfDept[$key]);
            										}else{
													echo "-";
													} ?></td>
       </tr>
          
           
 <?php       } //end of foreach?>
             <tr>	
             <td align='right' height='17px' colspan="1"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $this->Number->currency(round($totalBillAmt));; ?></td>
            </tr>
 <?php       } else { $cntBilling = "norecord"; ?>
            <tr>	
             <td align='center' height='17px' colspan="1"><?php echo  __('No Record Found'); ?></td>		
	        </tr>
 <?php       }
 ?>

 </table>
 <?php }?>
 <?php if($getRadiologyTestCash){?>
 <table  width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
     <thead>
        <tr class="row_title">
             <th colspan = "12" align="center"><h3>Radiology</h3></th>
         </tr>
    </thead>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">

 <thead>
    <tr class="row_title">
	    <th class="alignment" ><strong><?php echo __('Department'); ?></strong></th>	
	    <th class="alignment"><strong><?php echo __('Total Radiology Revenue'); ?></strong></td>
    </tr>
 </thead>
 <?php 
        // get billing cash //
        if(count($getRadiologyTestCash) > 0) {
 ?>
  
 <?php 
		foreach($getRadiologyTestCash as $key=> $getRadCashVal) {
          	if($key == '')continue;
            foreach ($getRadCashVal as $radKey => $radValue) {
               if($radValue['Department']['name']==$key){
               	$totalOfDeptRad[$key] += $radValue[0]['sum_amount'];
				}

            }  
           $totalRadBillAmt += $totalOfDeptRad[$key];        
 ?>
        <tr>		
        	
            <td align='center' height='17px'><?php echo $key ?></td>
         	<td align='center' height='17px'><?php if(!empty($totalOfDeptRad[$key])){
            										echo round($totalOfDeptRad[$key]);
            										}else{
													echo "-";
													} ?></td>
       </tr>
          
           
 <?php       } //end of foreach?>
             <tr>	
             <td align='right' height='17px' colspan="1"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $this->Number->currency(round($totalRadBillAmt)) ?></td>
            </tr>
 <?php       } else { $cntBilling = "norecord"; ?>
            <tr>	
             <td align='center' height='17px' colspan="1"><?php echo  __('No Record Found'); ?></td>		
	        </tr>
 <?php       }
 ?>

 </table>

 <?php }?>
 <?php if($getLaboratoryTestCash){?>
 <table  width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
     <thead>
        <tr class="row_title">
             <th colspan = "12" align="center"><h3>Laboratory</h3></th>
         </tr>
    </thead>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">

 <thead>
    <tr class="row_title">
	    <th class="alignment" ><strong><?php echo __('Department'); ?></strong></th>	
	    <th class="alignment"><strong><?php echo __('Total Laboratory Revenue'); ?></strong></td>
    </tr>
 </thead>
 <?php 
        // get billing cash //
        if(count($getLaboratoryTestCash) > 0) {
 ?>
  
 <?php 
		foreach($getLaboratoryTestCash as $key=> $getLabCashVal) {
          if($key == '')continue;
            foreach ($getLabCashVal as $labKey => $labValue) {
               if($labValue['Department']['name']==$key){
               	$totalOfDeptLab[$key] += $labValue[0]['sum_amount'];
				}

            }  
           $totalLabBillAmt += $totalOfDeptLab[$key];        
 ?>
        <tr>		
        	
            <td align='center' height='17px'><?php echo $key ?></td>
         	<td align='center' height='17px'><?php if(!empty($totalOfDeptLab[$key])){
            										echo round($totalOfDeptLab[$key]);
            										}else{
													echo "-";
													} ?></td>
       </tr>
          
           
 <?php       } //end of foreach?>
             <tr>	
             <td align='right' height='17px' colspan="1"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $this->Number->currency(round($totalLabBillAmt)); ?></td>
            </tr>
 <?php       } else { $cntBilling = "norecord"; ?>
            <tr>	
             <td align='center' height='17px' colspan="1"><?php echo  __('No Record Found'); ?></td>		
	        </tr>
 <?php       }
 ?>

 </table> <?php }?>
 <?php if($getPharmacyCash){?>
  <table  width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
     <thead>
        <tr class="row_title">
             <th colspan = "12" align="center"><h3>Pharmacy</h3></th>
         </tr>
    </thead>
</table>
 <table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">

 <thead>
    <tr class="row_title">
	    <th class="alignment" ><strong><?php echo __('Department'); ?></strong></th>	
	    <th class="alignment"><strong><?php echo __('Total Pharmacy Revenue'); ?></strong></td>
    </tr>
 </thead>
 <?php 
        // get billing cash //
        if(count($getPharmacyCash) > 0) {
 ?>
  
 <?php 
		foreach($getPharmacyCash as $key=> $getPharmaCashVal) {

          	if($key == '')continue;
            foreach ($getPharmaCashVal as $pharmaKey => $pharmaValue) {
               if($pharmaValue['Department']['name']==$key){
               	$totalOfDeptPharma[$key] += $pharmaValue[0]['sum_amount'];
				}

            }  
           $totalPharmaBillAmt += $totalOfDeptPharma[$key];        
 ?>
        <tr>		
        	
            <td align='center' height='17px'><?php echo $key ?></td>
         	<td align='center' height='17px'><?php if(!empty($totalOfDeptPharma[$key])){
            										echo round($totalOfDeptPharma[$key]);
            										}else{
													echo "-";
													} ?></td>
       </tr>
          
           
 <?php       } //end of foreach?>
             <tr>	
             <td align='right' height='17px' colspan="1"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $this->Number->currency(round($totalPharmaBillAmt)) ?></td>
            </tr>
 <?php       } else { $cntBilling = "norecord"; ?>
            <tr>	
             <td align='center' height='17px' colspan="1"><?php echo  __('No Record Found'); ?></td>		
	        </tr>
 <?php       }
 ?>

 </table>
 <?php }?>
 


  <script language="javascript" type="text/javascript">


  $( "#reportfrm" ).click(function(){
      var fromdate = new Date($( '#from' ).val());
      var todate = new Date($( '#to' ).val());
      if(fromdate.getTime() > todate.getTime()) {
       alert("To date should be greater than from date");
       return false;
      }
      
});	
  /*  function getValidate(){  
		
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