<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");



	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment;  filename=\"Payment_Receivable-".$this->DateFormat->formatDate2Local(date('d-m-Y H:i:s'),Configure::read('date_format'),true).".xls");
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
   <td colspan = "10" align="center"><strong>Payment Receivable</strong></td>
  </tr>
  <tr class="row_title">
   <td colspan = "10" align="center"><strong>Billing</strong></td>
  </tr>
  <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Sr.No.'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="5%"><strong><?php echo __('Date'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('MRN'); ?></strong></td> 
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Name'); ?></strong></td>					  
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Patient Type'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Mobile No'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Address'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Total Amount'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Paid'); ?></strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong><?php echo __('Balance'); ?></strong></td>
  </tr>
   
 <?php $totalAmount = array();
 		$paidSum= array();
        // get billing cash //
         $from = strtotime($this->DateFormat->formatDate2STD($this->request->data['from'],Configure::read('date_format'))) ;
         $to =   strtotime($this->DateFormat->formatDate2STD($this->request->data['to'],Configure::read('date_format'))) ;
        if(count($getBillingPending) > 0) {
         $dateshow = "";
         	$totalPaidAmt =0;
         	
	         foreach($getBillingPending as $getBillingPendingVal) {
	           
	                            
	            $dateExp = explode(" ", date("d/m/Y H:i:s", strtotime($getBillingPendingVal['Billing']['date'])));	
	            //display only record those are comes under selected date range 
	            $perDayTime  = strtotime($this->DateFormat->formatDate2STD($dateExp[0],Configure::read('date_format')));
	            $tillPaid 		=  array_sum($paidSum[$getBillingPendingVal['Patient']['id']]) ;
                $totalAmt  		=  $patientCharges[$getBillingPendingVal['Patient']['id']]['charges']-$tillPaid;  
                $paidAmt  		=  $getBillingPendingVal[0]['amount'];
                $paidSum[$getBillingPendingVal['Patient']['id']][] = $paidAmt ;    
                if($perDayTime >= $from && $perDayTime <= $to) {  
                	   $billingCnt++;	
		               $totalPaid 		+=  $paidAmt ;
		               $pendingAmt 		=  $totalAmt - $paidAmt ;  
		               //$totalAmount[$getBillingPendingVal['Patient']['id']]= $patientCharges[$getBillingPendingVal['Patient']['id']]['charges'];
		               if(!(array_key_exists($getBillingPendingVal['Patient']['id'],$totalAmount))){
		              	 $totalAmount[$getBillingPendingVal['Patient']['id']]= $totalAmt;
		               }
		               $totalBalance[$getBillingPendingVal['Patient']['id']]= $pendingAmt;
		                
		               if($dateshow != $dateExp[0] && $billingCnt!= 1) {   ?>
				            <tr>			
				             <td align='right' height='17px' colspan="9"><strong><?php echo  __('Total Pending'); ?></strong></td>		
					         <td align='center' height='17px'><?php echo $billingDaysTotal ?></td>
				            </tr>
				           <?php $billingDaysTotal = 0;  
		               } 			                 
			           ?>
			           <tr>	
			            <td align='center' height='17px'><?php echo $billingCnt; ?></td>	
			            <td align='center' height='17px'><?php echo $dateExp[0] ?></td>					
				        <td align='center' height='17px'><?php echo $getBillingPendingVal['Patient']['admission_id'] ?></td>
				        <td align='center' height='17px'><?php echo $getBillingPendingVal['PatientInitial']['name'].' '.$getBillingPendingVal['Patient']['lookup_name'] ?></td>
			            <td align='center' height='17px'><?php echo $getBillingPendingVal['Patient']['admission_type']; ?></td>
			            <td align='center' height='17px'><?php echo $getBillingPendingVal['Patient']['mobile_phone'] ?></td>
			            <td align='center' height='17px'><?php echo $patientCharges[$getBillingPendingVal['Patient']['id']]['address']?></td>
			            <td align='center' height='17px'><?php echo $totalAmt ?></td>
			            <td align='center' height='17px'><?php echo $paidAmt ?></td>
			            <td align='center' height='17px'><?php echo $pendingAmt ?></td>
			           </tr>
		          	  <?php   $billingDaysTotal += $pendingAmt;  
                } //EOF date comparision if block  
	           	$dateshow = $dateExp[0];
	         } //EOF FOR loop ?>
            <tr>	
             <td align='right' height='17px' colspan="7"><strong><?php echo  __('Total Pending'); ?></strong></td>		
	         <td align='right' height='17px' colspan="3"><?php echo $billingDaysTotal ?></td>
            </tr>
 <?php  } else {  $cntBilling = "norecord"; ?>
		   <tr class="row_title">
		   <td colspan = "10" align="center">No record found</td>
		  </tr>
  <?php
        }
 ?>
  
 <?php
if($cntBilling != 'norecord') {
	 $total = array_sum($totalAmount);
	 $totalBalance  = array_sum($totalBalance);
 ?>
 <tr>					
  <td align='right' height='17px' colspan="7"><strong>Total</strong></td>
  <td align='center' height='17px' ><strong><?php echo $total; ?></strong></td>
  <td align='center' height='17px' ><strong><?php echo $totalPaid; ?></strong></td>
  <td align='center' height='17px' ><strong><?php echo $totalBalance; ?></strong></td>
 </tr>
<?php } ?>

           
</table>
		
