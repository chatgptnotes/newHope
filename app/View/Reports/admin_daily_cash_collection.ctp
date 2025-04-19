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
<h3>&nbsp;<?php echo __('Daily Cash Collection', true); ?></h3>
<span class="" >
			
<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
</span>	
</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => "reports", "action" => "daily_cash_collection")); ?>" method="post" >
 <table align="center">

	<tr>
	 <td><?php echo __('Format'); ?>:</td>
	 <td><?php
		echo $this->Form->input('format', array('class'=>'textBoxExpnd textW','id' => 'format', 'label'=> false, 'div' => false, 'error' => false,'onChange'=>'checkFormat(this.value);','options'=>array('PAGE'=>'PAGE','EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
         <td><?php echo __('Payment Type'); ?>:</td>
	 <td><?php
		echo $this->Form->input('mode_of_payment', array('class'=>'textBoxExpnd textW','id' => 'paymentType', 'label'=> false, 'div' => false, 'error' => false,'empty'=>'All','options'=>array('Cash'=>'Cash','Cheque'=>'Cheque','NEFT'=>'NEFT','Credit Card'=>'Credit Card')));
	 ?></td>
         <td> <?php echo __('From'); ?>:</td>
	  <td>
	   <?php 
             echo $this->Form->input('from', array('class'=>'textBoxExpnd','style'=>'width:120px;','id'=>'from','autocomplete'=>'off','label'=> false, 'div' => false, 'error' => false));
           ?>
	  </td>
          
          <td colspan="8" align="right"><?php echo __('To'); ?>:</td>
	   <td colspan="8" align="left">
	   <?php 
            echo $this->Form->input('to', array('class'=>'textBoxExpnd','style'=>'width:120px;','id'=>'to','autocomplete'=>'off','label'=> false, 'div' => false, 'error' => false));
           ?>
	  </td>
           
         <td colspan="8" align="right"><?php echo __('Patient Type'); ?></td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left">
	  <?php 
             echo $this->Form->input('admission_type', array('class'=>'textBoxExpnd textW','id'=>'admission_type','label'=> false, 'div' => false, 'error' => false, 'options'=>array(''=>'All','IPD'=>'IPD','OPD'=>'OPD')));
          ?>
	 </td>
         
      
	  
	   <td id="showIpdPatientStatus" style="display:none;">
	   <?php 
	         $ipdoptions = array('' => 'All',
			                     '1' => 'Discharged',
			                     '0' => 'Not Discharged',
			                     );
             echo $this->Form->input('ipd_patient_status', array('class'=>'textBoxExpnd textW','id'=>'ipd_patient_status','label'=> false, 'div' => false, 'error' => false, 'options'=>$ipdoptions,'placeHolder'=>'Patient Status'));
          ?>
	  </td>

	   <td id="showOpdPatientStatus" style="display:none;">
	   <?php 
	         $opdop = array('' => 'All',
			                     '1' => 'OP Process Completed',
			                     '0' => 'OP In-Progress',
			                     );
             echo $this->Form->input('opd_patient_status', array('class'=>'textBoxExpnd textW','id'=>'opd_patient_status','label'=> false, 'div' => false, 'error' => false, 'options'=>$opdop,'placeHolder'=>'Patient Status'));
          ?>
	  </td>
	
	
	   <td id="showSkipRegistration" style="display:none;">
	   <?php 
	         /* $opdoptions = array('' => 'All',
			                     '4' => 'First Consultation',
			                     '5' => 'Follow-Up Consultation',
			                     '6' => 'Preventive Health Check-up',
			                     '7' => 'Vaccination',
			                     '8' => 'Pre-Employment Check-up',
			                     '9' => 'Pre Policy Check up',
			                     '0'=>'Skip Registration/Consultation'); */
             echo $this->Form->input('skip_registration', array('empty'=>__('Select Type'),'id'=>'skip_registration','label'=> false, 'div' => false, 'error' => false, 'options'=>$opdoptions));
          ?>
	  </td>
          <td><?php echo __('Select Type'); ?></td>
	 <td>
	  <?php 
             echo $this->Form->input('billtype', array('class'=>'textBoxExpnd textW','id'=>'bill_type','label'=> false, 'div' => false, 'error' => false, 'options'=>array('TOTAL BILL'=>'TOTAL BILL','RADIOLOGY'=>'RADIOLOGY','LABORATORY'=>'LABORATORY','PHARMACY'=>'PHARMACY')));
          ?>
	 </td>
         <td>
            <input type="submit" value="Get Report" class="blueBtn" id="submit" onClick="return getValidate();">&nbsp;&nbsp;
            <input type="submit" value="Show Graph" class="blueBtn" id="graph" onclick = "return getChecked();" style="display:none;" >&nbsp;&nbsp;
         </td>
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
<?php $totalAmount = 0;
 ?>
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
     <!--<th class="alignment" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></th>-->
     <th class="alignment" width="8%"><strong><?php echo __('Date'); ?></strong></th>	
     <th class="alignment" width="8%"><strong><?php echo __('MRN'); ?></strong></td>
     <th class="alignment" width="20%"><strong><?php echo __('Patient Name'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Patient Status'); ?></strong></th>
     <th class="alignment" width="10%"><strong><?php echo __('Patient Type'); ?></strong></th>	
     <th class="alignment" width="20%"><strong><?php echo __('Mobile No'); ?></strong></th>
     <th class="alignment" width="25%"><strong><?php echo __('Address'); ?></strong></th>
     <th class="alignment" width="10%"><strong><?php echo __('Payment Type'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Collected By'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Payment Date'); ?></strong></th>	
     <th class="alignment" width="15%"><strong><?php echo __('Amount'); ?></strong></th>
    </tr>
  </thead>
 <?php 
        // get billing cash //
        if(count($getBillingCash) > 0) {
         $dateshow = "";
 ?>
  
 <?php 
          foreach($getBillingCash as $getBillingCashVal) {
                  $billingCnt++;
                  
                  $totalAmount += $getBillingCashVal[0]['sum_amount'];
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getBillingCashVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getBillingCashVal['Billing']['date'],'yyyy/mm/dd', true))));
                  if(!$getBillingCashVal[0]['sum_amount']) continue;
                  
 ?>
          <?php 
         
             if($dateshow!= '' && $dateshow != $dateExp[0] && $billingCnt!= 1) {
           ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo round($billingDaysTotal) ?></td>
            </tr>
           <?php
                 $billingDaysTotal = 0;
               } 
               
           ?>
           <tr>		
            <!--<td align='center' height='17px'><?php echo $billingCnt; ?></td>-->	
            <td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getBillingCashVal['Patient']['form_received_on'],'yyyy/mm/dd', true))); ?></td>		
            <td align='center' height='17px'><?php echo $getBillingCashVal['Patient']['admission_id'] ?></td>
            <td align='center' height='17px'><?php echo $getBillingCashVal['PatientInitial']['name']." ".$getBillingCashVal['Patient']['lookup_name'] ?></td>
			<td align='center' height='17px'>
			 <?php if($getBillingCashVal['Patient']['admission_type'] == "IPD") {
			        if($getBillingCashVal['Patient']['is_discharge'] == 1) {  
						echo __('Discharged');
					} else {
						echo __('Not Discharged');
					}
		           }
				   if($getBillingCashVal['Patient']['admission_type'] == "OPD") {
			        if($getBillingCashVal['Patient']['is_discharge'] == 1) {  
						echo __('OP Process Completed');
					} else {
						echo __('OP In-Progress');
					}
		           }
			?>
			</td>
            <td align='center' height='17px'><?php echo $getBillingCashVal['Patient']['admission_type']; ?></td>
			 
            <td align='center' height='17px'><?php if(!empty($getBillingCashVal['Person']['mobile'])){
            										echo $getBillingCashVal['Person']['mobile'];
            										}else{
													echo "-";
													} ?></td>
            <td align='center' height='17px'><?php if(!empty($formatted_address)){
            										echo $formatted_address; 
            										}else{
													echo "-";
													}?></td>
			 								
			<td align='center' height='17px'><?php 	if(!empty($getBillingCashVal['Billing']['mode_of_payment'])){
														echo $getBillingCashVal['Billing']['mode_of_payment'];
													}else{
														echo "-";
														} ?></td>
			<td align='center' height='17px'><?php echo $getBillingCashVal['User']['first_name']." ".$getBillingCashVal['User']['last_name']  ?></td>		
			<td align='center' height='17px'><?php echo $dateExp[0] ?></td>
            <td align='center' height='17px'><?php if(!empty($getBillingCashVal[0]['sum_amount'])){
            										echo round($getBillingCashVal[0]['sum_amount']);
            										}else{
													echo "-";
													} ?></td>
           </tr>
           <?php  $dateshow = $dateExp[0]; $billingDaysTotal += $getBillingCashVal[0]['sum_amount']; ?>
           
 <?php     } ?>
             <tr>	
             <td align='right' height='17px' colspan="10"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo round($billingDaysTotal) ?></td>
            </tr>
 <?php       } else { $cntBilling = "norecord"; ?>
            <tr>	
             <td align='center' height='17px' colspan="10"><?php echo  __('No Record Found'); ?></td>		
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
     <!--<th class="alignment" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></th>-->
     <th class="alignment" width="8%"><strong><?php echo __('Date'); ?></strong></th>	
     <th class="alignment"  width="8%"><strong><?php echo __('MRN'); ?></strong></td>
     <th class="alignment" width="20%"><strong><?php echo __('Patient Name'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Patient Status'); ?></strong></th>
     <th class="alignment" width="10%"><strong><?php echo __('Patient Type'); ?></strong></th>	
     <th class="alignment" width="20%"><strong><?php echo __('Mobile No'); ?></strong></th>
     <th class="alignment" width="25%"><strong><?php echo __('Address'); ?></strong></th>
     <th class="alignment" width="10%"><strong><?php echo __('Payment Type'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Collected By'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Payment Date'); ?></strong></th>	
     <th class="alignment" width="15%"><strong><?php echo __('Amount'); ?></strong></th>
    </tr>
  </thead>
  <?php 
        // get radiology test cash //
        if(count($getRadiologyTestCash) >0) {
          $dateshow = "";
  ?>
   
   <?php       foreach($getRadiologyTestCash as $getRadiologyTestCashVal) {
                  $radiologyCnt++;
                  $totalAmount += $getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount'];
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getRadiologyTestCashVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getRadiologyTestCashVal['RadiologyTestOrder']['create_time'],'yyyy/mm/dd', true))));
                  if(!$getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount'])continue; 
 ?>
 
          <?php 
             if($dateshow!= '' && $dateshow != $dateExp[0] && $radiologyCnt != 1) {
              
           ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo round($radiologyDaysTotal) ?></td>
            </tr>
           <?php
                 $radiologyDaysTotal = 0;
               } 
           ?>
           <tr>		
            <!--<td align='center' height='17px'><?php echo $radiologyCnt; ?></td>-->	
            <td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getRadiologyTestCashVal['Patient']['form_received_on'],'yyyy/mm/dd', true))); ?></td>
	        <td align='center' height='17px'><?php echo $getRadiologyTestCashVal['Patient']['admission_id'] ?></td>
	        <td align='center' height='17px'><?php echo $getRadiologyTestCashVal['PatientInitial']['name']." ".$getRadiologyTestCashVal['Patient']['lookup_name'] ?></td>
            <td align='center' height='17px'>
			 <?php if($getRadiologyTestCashVal['Patient']['admission_type'] == "IPD") {
			        if($getRadiologyTestCashVal['Patient']['is_discharge'] == 1) {  
						echo __('Discharged');
					} else {
						echo __('Not Discharged');
					}
		           }
				   if($getRadiologyTestCashVal['Patient']['admission_type'] == "OPD") {
			        if($getRadiologyTestCashVal['Patient']['is_discharge'] == 1) {  
						echo __('OP Process Completed');
					} else {
						echo __('OP In-Progress');
					}
		           }
			?>
			</td>
            <td align='center' height='17px'><?php echo $getRadiologyTestCashVal['Patient']['admission_type']; ?></td>
            <td align='center' height='17px'><?php if(!empty($getRadiologyTestCashVal['Person']['mobile'])){
            										echo $getRadiologyTestCashVal['Person']['mobile'];
            										}else{
													echo "-";
													} ?></td>
            <td align='center' height='17px'><?php echo $formatted_address; ?></td>
			<td align='center' height='17px'><?php echo $getRadiologyTestCashVal['Billing']['mode_of_payment'] ?></td>
			<td align='center' height='17px'><?php echo $getRadiologyTestCashVal['User']['first_name']." ".$getRadiologyTestCashVal['User']['last_name'] ?></td>
			<td align='center' height='17px'><?php echo $dateExp[0] ?></td>
            <td align='center' height='17px'><?php echo round($getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount']) ?></td>
           </tr>
           <?php $dateshow = $dateExp[0]; $radiologyDaysTotal += $getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount']; ?>
<?php     } ?>
             <tr>
             <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo round($radiologyDaysTotal) ?></td>
            </tr>
 <?php       } else {
 	$cntRadiology = "norecord"; ?>
            <tr>
             <td align='center' height='17px' colspan="10"><?php echo __('No Record Found'); ?></td>		
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
    <!-- <th class="alignment" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></th>-->
     <th class="alignment" width="8%"><strong><?php echo __('Date'); ?></strong></th>	
     <th class="alignment" width="8%"><strong><?php echo __('MRN'); ?></strong></td>
     <th class="alignment" width="20%"><strong><?php echo __('Patient Name'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Patient Status'); ?></strong></th>
     <th class="alignment" width="10%"><strong><?php echo __('Patient Type'); ?></strong></th>	
     <th class="alignment" width="20%"><strong><?php echo __('Mobile No'); ?></strong></th>
     <th class="alignment" width="25%"><strong><?php echo __('Address'); ?></strong></th>
     <th class="alignment" width="10%"><strong><?php echo __('Payment Type'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Collected By'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Payment Date'); ?></strong></th>	
     <th class="alignment" width="15%"><strong><?php echo __('Amount'); ?></strong></th>
    </tr>
  </thead>
  
 <?php 
        // get laboratory test cash //
        if(count($getLaboratoryTestCash) > 0) {
         $dateshow = "";
 ?>
   
 <?php 
          foreach($getLaboratoryTestCash as $getLaboratoryTestCashVal) {
                  $totalAmount += $getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount'];
                  $laboratoryCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getLaboratoryTestCashVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getLaboratoryTestCashVal['LaboratoryTestOrder']['create_time'],'yyyy/mm/dd', true))));
                  if(!$getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount'])continue; 
                  
 ?>
          <?php 
             if($dateshow!= '' &&  $dateshow != $dateExp[0] && $laboratoryCnt != 1) {
             
           ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $laboratoryDaysTotal ?></td>
            </tr>
           <?php
                 $laboratoryDaysTotal = 0;
               } 
           ?>
           <tr>		
          <!-- <td align='center' height='17px'><?php echo $laboratoryCnt; ?></td>	-->
		   <td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getLaboratoryTestCashVal['Patient']['form_received_on'],'yyyy/mm/dd', true))); ?></td>
           <td align='center' height='17px'><?php echo $getLaboratoryTestCashVal['Patient']['admission_id'] ?></td>
	       <td align='center' height='17px'><?php echo $getLaboratoryTestCashVal['PatientInitial']['name']." ".$getLaboratoryTestCashVal['Patient']['lookup_name'] ?></td>
		   <td align='center' height='17px'>
           <?php if($getLaboratoryTestCashVal['Patient']['admission_type'] == "IPD") {
			        if($getLaboratoryTestCashVal['Patient']['is_discharge'] == 1) {  
						echo __('Discharged');
					} else {
						echo __('Not Discharged');
					}
		           }
				   if($getLaboratoryTestCashVal['Patient']['admission_type'] == "OPD") {
			        if($getLaboratoryTestCashVal['Patient']['is_discharge'] == 1) {  
						echo __('OP Process Completed');
					} else {
						echo __('OP In-Progress');
					}
		           }
			?>
			</td>
            <td align='center' height='17px'><?php echo $getLaboratoryTestCashVal['Patient']['admission_type'] ?></td>
            <td align='center' height='17px'><?php if(!empty($getLaboratoryTestCashVal['Person']['mobile'])){
            											echo $getLaboratoryTestCashVal['Person']['mobile'];
            										}else{
														echo "-";
														} ?></td>
            <td align='center' height='17px'><?php echo $formatted_address ?></td>
			<td align='center' height='17px'><?php echo $getLaboratoryTestCashVal['Billing']['mode_of_payment'] ?></td>
			 <td align='center' height='17px'><?php echo $getLaboratoryTestCashVal['User']['first_name']." ".$getLaboratoryTestCashVal['User']['last_name'] ?></td>
			<td align='center' height='17px'><?php echo $dateExp[0] ?></td>
            <td align='center' height='17px'><?php echo round($getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount']) ?></td>
           
           </tr>
           <?php $dateshow = $dateExp[0]; $laboratoryDaysTotal += $getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount'];?>
           
 <?php     } ?>
            <tr>			
                <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
                <td align='center' height='17px'><?php echo round($laboratoryDaysTotal) ?></td>
            </tr>
<?php        } else { $cntLaboratory = "norecord"; ?>
            <tr>			
             <td align='center' height='17px' colspan="10"><strong><?php echo __('No Record Found'); ?></strong></td>		
            </tr>
 <?php
        }
 ?>
 </table>
 <?php }?>
 <?php if($getPharmacyCash){?>
  <table  width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
     <thead>
        <tr class="row_title">
             <th colspan = "12" align="center"><h3>Pharmacy</h3></th>
         </tr>
    </thead>
</table>
 <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
  <thead>
    <tr class="row_title">
     <!--<th class="alignment" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></th>-->
     <th class="alignment" width="8%"><strong><?php echo __('Date'); ?></strong></th>	
     <th class="alignment" width="8%"><strong><?php echo __('MRN'); ?></strong></td>
     <th class="alignment" width="20%"><strong><?php echo __('Patient Name'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Patient Status'); ?></strong></th>
     <th class="alignment" width="10%"><strong><?php echo __('Patient Type'); ?></strong></th>	
     <th class="alignment" width="20%"><strong><?php echo __('Mobile No'); ?></strong></th>
     <th class="alignment" width="25%"><strong><?php echo __('Address'); ?></strong></th>
     <th class="alignment" width="10%"><strong><?php echo __('Payment Type'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Collected By'); ?></strong></th>	
     <th class="alignment" width="10%"><strong><?php echo __('Payment Date'); ?></strong></th>	
     <th class="alignment" width="15%"><strong><?php echo __('Amount'); ?></strong></th>
    </tr>
  </thead>
 <?php 
        // get laboratory test cash //
        if(count($getPharmacyCash) > 0) {
         $dateshow =  "";
  ?>
   
  <?php
          foreach($getPharmacyCash as $getPharmacyCashVal) {
                  $totalAmount += $getPharmacyCashVal['PharmacySalesBill']['total'];
                  $pharmacyCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getPharmacyCashVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getPharmacyCashVal['PharmacySalesBill']['create_time'],'yyyy/mm/dd', true))));
                  if(!$getPharmacyCashVal['PharmacySalesBill']['total'])continue;
                  
 ?>
           <?php 
             if($dateshow!= '' &&  $dateshow != $dateExp[0] && $pharmacyCnt != 1) {
               
           ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo round($pharmacyDaysTotal) ?></td>
            </tr>
           <?php
                 $pharmacyDaysTotal = 0;
               } 
           ?>
           <tr>		
           <!-- <td align='center' height='17px'><?php echo $pharmacyCnt; ?></td>-->
            <td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getPharmacyCashVal['Patient']['form_received_on'],'yyyy/mm/dd', true))); ?></td>	
	        <td align='center' height='17px'><?php echo $getPharmacyCashVal['Patient']['admission_id'] ?></td>
	        <td align='center' height='17px'><?php echo $getPharmacyCashVal['PatientInitial']['name']." ".$getPharmacyCashVal['Patient']['lookup_name'] ?></td>
			<td align='center' height='17px'>
			<?php if($getPharmacyCashVal['Patient']['admission_type'] == "IPD") {
			        if($getPharmacyCashVal['Patient']['is_discharge'] == 1) {  
						echo __('Discharged');
					} else {
						echo __('Not Discharged');
					}
		           }
				   if($getPharmacyCashVal['Patient']['admission_type'] == "OPD") {
			        if($getPharmacyCashVal['Patient']['is_discharge'] == 1) {  
						echo __('OP Process Completed');
					} else {
						echo __('OP In-Progress');
					}
		           }
			?>
			</td>
            <td align='center' height='17px'><?php echo $getPharmacyCashVal['Patient']['admission_type'] ?></td>
            <td align='center' height='17px'><?php if(!empty($getPharmacyCashVal['Person']['mobile'])){
            										echo $getPharmacyCashVal['Person']['mobile'];
            										}else{
														echo "-";
													} ?></td>
            <td align='center' height='17px'><?php if(!empty($formatted_address)){
            										echo $formatted_address;
            										}else{
													echo "-";
													} ?></td>
			<td align='center' height='17px'><?php echo $getPharmacyCashVal['PharmacySalesBill']['payment_mode'] ?></td>
			<td align='center' height='17px'><?php echo $getPharmacyCashVal['User']['first_name']." ".$getPharmacyCashVal['User']['last_name'] ?></td>
			<td align='center' height='17px'><?php echo $dateExp[0] ?></td>
            <td align='center' height='17px'><?php echo round($getPharmacyCashVal['PharmacySalesBill']['total']) ?></td>
           </tr>
            <?php $dateshow = $dateExp[0]; $pharmacyDaysTotal += $getPharmacyCashVal['PharmacySalesBill']['total'];?>
           
 <?php     } ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo round($pharmacyDaysTotal) ?></td>
            </tr>
 <?php       } else {
               $cntPharmacy = "norecord";
 ?>
            <tr>			
             <td align='center' height='17px' colspan="10"><?php echo __('No Record Found'); ?></td>		
	        </tr>
<?php
        }
 ?>
 </table>
 <?php }?>
 
 <?php
  //if($cntPharmacy != '' || $cntLaboratory != '' || $cntRadiology != '' || $cntBilling != '') {
 ?>
 <table border="0" class="tabularForm"  cellpadding="0" cellspacing="1" width="100%" style="">
 <tr>					
  <td align='right' height='17px' colspan="10"><strong>Total Amount</strong></td>
  <td align='right' height='17px' colspan="1"><strong><?php echo $this->Number->currency(round($totalAmount)) ; ?></strong></td>
 </tr>
 </table>
<?php //} ?>

 <table style="display:none">
        <tr>
            <td align="right" height="17px" colspan="1">
                <strong id="totalAmount"><?php echo $this->Number->currency(round($totalAmount)) ; ?></strong> <!-- The value to be sent -->
            </td>
        </tr>
    </table>

    <div style="display:none" id="status">Waiting to send the first message...</div>

    <script>
        // WhatsApp API Details
        const apiUrl = "https://public.doubletick.io/whatsapp/message/template";
        const apiKey = "key_8sc9MP6JpQ";

        // Function to Send WhatsApp Message
        async function sendWhatsAppMessage(amount) {
            const payload = {
                messages: [
                    {
                        to: "+917387737062", // Replace with the recipient's number9373111709
                        content: {
                            templateName: "hope_daily_money_collection", // Template name
                            language: "en", // Language
                            templateData: {
                                body: {
                                    placeholders: ["Dr. Murli",amount,amount,amount] // Dynamic placeholders
                                }
                            }
                        }
                    }
                ]
            };

            try {
                const response = await fetch(apiUrl, {
                    method: "POST",
                    headers: {
                        "accept": "application/json",
                        "content-type": "application/json",
                        "Authorization": apiKey
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (response.ok) {
                    document.getElementById('status').textContent = `Message sent successfully at ${new Date().toLocaleTimeString()}!`;
                    console.log("Message sent:", result);
                } else {
                    document.getElementById('status').textContent = `Error: ${result.message || "Something went wrong."}`;
                    console.error("Failed to send message:", result);
                }
            } catch (error) {
                document.getElementById('status').textContent = "Error sending message. Check the console for details.";
                console.error("Error:", error);
            }
        }

        // Function to Extract Value from the Table and Send Message
        function extractAndSend() {
            const amount = document.getElementById('totalAmount').textContent.trim(); // Extract the amount from the table
            sendWhatsAppMessage(amount); // Send the extracted amount
        }

        // Automatically Send Message Every 1 Minute (60000 ms)
        setInterval(extractAndSend, 3600000);

        // Initial call to send message immediately
        extractAndSend();
    </script>
    

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