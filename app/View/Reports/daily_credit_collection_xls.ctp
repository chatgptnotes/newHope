<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Daily_Credit_Card_Collection".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Generated Report" );
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
   <td colspan = "11" align="center"><h2>Daily Credit Card Collection</h2></td>
  </tr>
  <tr class="row_title">
   <td colspan = "11" align="center"><h3>Billing</h3></td>
  </tr>
  <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date of Reg.'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('MRN'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Status'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Type'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Address'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Sponsor Name'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Type'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Date'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Amount'); ?></strong></td>
  </tr>
  <?php $totalAmount = 0; ?>
 <?php 
        // get billing credit //
        if(count($getBillingCredit) > 0) {
          $dateshow = "";
          foreach($getBillingCredit as $getBillingCreditVal) {
                  $totalAmount += $getBillingCreditVal['Billing']['amount'];
                  $billingCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getBillingCreditVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getBillingCreditVal['Billing']['date'],'yyyy/mm/dd', true))));
 ?>
 <?php 
             if($dateshow != $dateExp[0] && $billingCnt!= 1) {
             
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
            <td align='center' height='17px'><?php echo $billingCnt ?></td>			
            <td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getBillingCreditVal['Patient']['form_received_on'],'yyyy/mm/dd', true))) ?></td>
	        <td align='center' height='17px'><?php echo $getBillingCreditVal['Patient']['admission_id'] ?></td>
	        <td align='center' height='17px'><?php echo $getBillingCreditVal['PatientInitial']['name'].' '.$getBillingCreditVal['Patient']['lookup_name'] ?></td>
			<td align='center' height='17px'>
			<?php if($getBillingCreditVal['Patient']['admission_type'] == "IPD") {
			        if($getBillingCreditVal['Patient']['is_discharge'] == 1) {  
						echo __('Discharged');
					} else {
						echo __('Not Discharged');
					}
		           }
				   if($getBillingCreditVal['Patient']['admission_type'] == "OPD") {
			        if($getBillingCreditVal['Patient']['is_discharge'] == 1) {  
						echo __('OP Process Completed');
					} else {
						echo __('OP In-Progress');
					}
		           }

				   
			?>
			</td>
            <td align='center' height='17px'><?php echo $getBillingCreditVal['Patient']['admission_type']; ?></td>
            <td align='center' height='17px'><?php echo $formatted_address; ?></td>
			<td align='center' height='17px'>
			<?php 
			       if($getBillingCreditVal['Corporate']['name']) 
			          echo $getBillingCreditVal['Corporate']['name'];
		           elseif($getBillingCreditVal['InsuranceCompany']['name']) 
					   echo $getBillingCreditVal['InsuranceCompany']['name'];
				   else 
					   echo __('Private');

				   
			?>
			</td>
			<td align='center' height='17px'><?php echo $getBillingCreditVal['Billing']['reason_of_payment']; ?></td>
			<td align='center' height='17px'><?php echo $dateExp[0] ?></td>
            <td align='center' height='17px'><?php echo $getBillingCreditVal['Billing']['amount'] ?></td>
           </tr>
           <?php  $dateshow = $dateExp[0]; $billingDaysTotal += $getBillingCreditVal['Billing']['amount']; ?>
 <?php  
        }
 ?>
       <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $billingDaysTotal ?></td>
            </tr>
  <?php      } else {     $cntBilling = "norecord"; ?>
         <tr>			
             <td align="center" height="17px" colspan="11"><?php echo  __('No Record Found'); ?></td>		
	      </tr>
  <?php
        }
 ?>
 </table>
 <table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">
 <tr class="row_title">
   <td colspan = "11" align="center"><h3>Pharmacy</h3></td>
  </tr>
  <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Date of Reg.'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('MRN'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Status'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Type'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Address'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Sponsor Name'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Type'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Payment Date'); ?></strong></td>	
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Amount'); ?></strong></td>
  </tr>
 <?php 
        // get laboratory test credit //
        if(count($getPharmacyCredit) > 0) {
          $dateshow = "";
          foreach($getPharmacyCredit as $getPharmacyCreditVal) {
                  $totalAmount += $getPharmacyCreditVal[0]['amount'];
                  $pharmacyCnt++;
                  $formatted_address = $this->requestAction("/patients/setAddressFormat",array('pass' => array($getPharmacyCreditVal['Person'])));
				  
                  $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($this->DateFormat->formatDate2Local($getPharmacyCreditVal['PharmacySalesBill']['create_time'],'yyyy/mm/dd', true))));
 ?>
          <?php 
             if($dateshow != $dateExp[0] && $pharmacyCnt!= 1) {
             
           ?>
            <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $pharmacyDaysTotal ?></td>
            </tr>
           <?php
                 $pharmacyDaysTotal = 0;
               } 
               
           ?>
           <tr>	
            <td align='center' height='17px'><?php echo $pharmacyCnt ?></td>
			<td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getPharmacyCreditVal['Patient']['form_received_on'],'yyyy/mm/dd', true))) ?></td>
            <td align='center' height='17px'><?php echo $getPharmacyCreditVal['Patient']['admission_id'] ?></td>
	        <td align='center' height='17px'><?php echo $getPharmacyCreditVal['PatientInitial']['name'].' '.$getPharmacyCreditVal['Patient']['lookup_name'] ?></td>
			<td align='center' height='17px'>
			 <?php if($getPharmacyCreditVal['Patient']['admission_type'] == "IPD") {
			        if($getPharmacyCreditVal['Patient']['is_discharge'] == 1) {  
						echo __('Discharged');
					} else {
						echo __('Not Discharged');
					}
		           }
				   if($getPharmacyCreditVal['Patient']['admission_type'] == "OPD") {
			        if($getPharmacyCreditVal['Patient']['is_discharge'] == 1) {  
						echo __('OP Process Completed');
					} else {
						echo __('OP In-Progress');
					}
		           }
			?>
			</td>
            <td align='center' height='17px'><?php echo $getPharmacyCreditVal['Patient']['admission_type']; ?></td>
            <td align='center' height='17px'><?php echo $formatted_address ?></td>
			<td align='center' height='17px'>
			<?php 
			       if($getPharmacyCreditVal['Corporate']['name']) 
			          echo $getPharmacyCreditVal['Corporate']['name'];
		           elseif($getPharmacyCreditVal['InsuranceCompany']['name']) 
					   echo $getPharmacyCreditVal['InsuranceCompany']['name'];
				   else 
					   echo __('Private');

				   
			?>
			</td>
			<td align='center' height='17px'></td>
			<td align='center' height='17px'><?php echo $dateExp[0] ?></td>	
            <td align='center' height='17px'><?php echo $getPharmacyCreditVal[0]['amount'] ?></td>
           </tr>
           <?php  $dateshow = $dateExp[0]; $pharmacyDaysTotal += $getPharmacyCreditVal[0]['amount']; ?>
 <?php     }
 ?>
           <tr>			
             <td align='right' height='17px' colspan="10"><strong><?php echo  __('Total'); ?></strong></td>		
	         <td align='center' height='17px'><?php echo $pharmacyDaysTotal ?></td>
            </tr>
 <?php
        } else {   $cntPharmacy = "norecord"; ?>
            <tr>			
             <td align='center' height='17px' colspan="11"><?php echo  __('No record found'); ?></td>		
	        </tr>  
 <?php
        }
 ?>
 </table>
 
 <?php
if($cntPharmacy != 'norecord' || $cntBilling != 'norecord') {
 ?>
 <table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">
 <tr>					
  <td align='right' height='17px' colspan="10"><strong>Total Amount(Billing, Pharmacy)</strong></td>
  <td align='center' height='17px' colspan="1"><strong><?php echo $totalAmount; ?></strong></td>
 </tr>
 </table>
<?php } ?>
           

		
