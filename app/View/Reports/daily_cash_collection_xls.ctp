<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Daily_Cash_Collection".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
 
<STYLE type='text/css'>
	.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
   
</STYLE>
<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
  <tr class="row_title">
   <td colspan = "11" align="center"><h2>Daily Cash Collection</h2></td>
  </tr>
   <?php if($getBillingCash){?>
   <?php $totalAmount = 0; ?>
   <tr class="row_title">
   <td colspan = "11" align="center"><h3>Billing</h3></td>
  </tr>
  <tr class="row_title">
   <!--<td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>-->
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Date Of Reg.'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('MRN'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td> 
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Status'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Type'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="8%"><strong><?php echo __('Mobile No'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="25%"><strong><?php echo __('Address'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Type'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Collected By'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Payment Date'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Amount'); ?></strong></td>
  </tr>
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
             if($dateshow!= '' &&  $dateshow != $dateExp[0] && $billingCnt!= 1) {
             
           ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $billingDaysTotal ?></td>
            </tr>
           <?php
                 $billingDaysTotal = 0;
               } 
               
           ?>
           <tr>		
           <!-- <td align='center' height='17px'><?php echo $billingCnt; ?></td>	-->
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
			<td align='center' height='17px'><?php echo $getBillingCashVal['User']['first_name']." ".$getBillingCashVal['User']['last_name']; ?></td>		
			<td align='center' height='17px'><?php echo $dateExp[0] ?></td>
            <td align='center' height='17px'><?php if(!empty($getBillingCashVal[0]['sum_amount'])){
            										echo $getBillingCashVal[0]['sum_amount'];
            										}else{
													echo "-";
													} ?></td>
           </tr>
           <?php  $dateshow = $dateExp[0]; $billingDaysTotal += $getBillingCashVal[0]['sum_amount']; ?>
           
 <?php     } ?>
             <tr>	
             <td align='right' height='17px' colspan="10"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $billingDaysTotal ?></td>
            </tr>
 <?php       } else { $cntBilling = "norecord"; ?>
            <tr>	
             <td align='center' height='17px' colspan="10"><?php echo  __('No Record Found'); ?></td>		
	        </tr>
 <?php       }
 ?>
 <?php }?>
 </table>
 <?php if($getRadiologyTestCash){?>
 <table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
 <tr class="row_title">
   <td colspan = "11" align="center"><h3>Radiology</h3></td>
  </tr>
  <tr class="row_title">
   <!--<td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>	-->
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Date Of Reg'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('MRN'); ?></strong></td> 
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Status'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Type'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Mobile No'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="25%"><strong><?php echo __('Address'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Type'); ?></strong></td>
    <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Collected By'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Date'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Amount'); ?></strong></td>
  </tr>
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
                  if(!$getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount']) continue;
 ?>
 
          <?php 
             if($dateshow!= '' &&  $dateshow != $dateExp[0] && $radiologyCnt != 1) {
              
           ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $radiologyDaysTotal ?></td>
            </tr>
           <?php
                 $radiologyDaysTotal = 0;
               } 
           ?>
           <tr>		
           <!-- <td align='center' height='17px'><?php echo $radiologyCnt; ?></td>-->
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
            <td align='center' height='17px'><?php echo $getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount'] ?></td>
           </tr>
           <?php $dateshow = $dateExp[0]; $radiologyDaysTotal += $getRadiologyTestCashVal['RadiologyTestOrder']['paid_amount']; ?>
<?php     } ?>
             <tr>
             <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $radiologyDaysTotal ?></td>
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
 <table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
 <tr class="row_title">
   <td colspan = "11" align="center"><h3>Laboratory</h3></td>
  </tr>
  <tr class="row_title">
   <!--<td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>	-->
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Date Of Reg'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('MRN'); ?></strong></td>  
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Status'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Type'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Mobile No'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="25%"><strong><?php echo __('Address'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Type'); ?></strong></td>
    <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Collected By'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Date'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Amount'); ?></strong></td>
  
  </tr>
  
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
                  if(!$getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount']) continue;
                  
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
			 <td align='center' height='17px'><?php echo $getLaboratoryTestCashVal['User']['first_name']." ".$getLaboratoryTestCashVal['User']['last_name']  ?></td>
			<td align='center' height='17px'><?php echo $dateExp[0] ?></td>
            <td align='center' height='17px'><?php echo $getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount'] ?></td>
           
           </tr>
           <?php $dateshow = $dateExp[0]; $laboratoryDaysTotal += $getLaboratoryTestCashVal['LaboratoryTestOrder']['paid_amount'];?>
           
 <?php     } ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $laboratoryDaysTotal ?></td>
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
 <table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
 <tr class="row_title">
   <td colspan = "11" align="center"><h3>Pharmacy</h3></td>
  </tr>
  <tr class="row_title">
   <!--<td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>-->
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Date Of Reg'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('MRN'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Status'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Type'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Mobile No'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="25%"><strong><?php echo __('Address'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Type'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Collected By'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Date'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __('Amount'); ?></strong></td>
  </tr>
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
                   if(!$getPharmacyCashVal['PharmacySalesBill']['total']) continue;
                  
 ?>
           <?php 
             if($dateshow!= '' &&  $dateshow != $dateExp[0] && $pharmacyCnt != 1) {
               
           ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $pharmacyDaysTotal ?></td>
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
            <td align='center' height='17px'><?php echo $getPharmacyCashVal['PharmacySalesBill']['total'] ?></td>
           </tr>
            <?php $dateshow = $dateExp[0]; $pharmacyDaysTotal += $getPharmacyCashVal['PharmacySalesBill']['total'];?>
           
 <?php     } ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $pharmacyDaysTotal ?></td>
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
  if($cntPharmacy != 'norecord' || $cntLaboratory != 'norecord' || $cntRadiology != 'norecord' || $cntBilling != 'norecord') {
 ?>
 <table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">
 <tr>					
  <td align='right' height='17px' colspan="10"><strong>Total Amount</strong></td>
  <td align='center' height='17px' colspan="1"><strong><?php echo $totalAmount; ?></strong></td>
 </tr>
 </table>
<?php } ?>

           

		
