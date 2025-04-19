<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Department Wise Collection_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
<div class="inner_title">
<h3>&nbsp;<?php echo __('Department Wise Revenue', true); ?></h3>
</div>
 
<?php if($getBillingCash){?>
<?php $totalAmount = 0; ?>
<table  width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm">
     <thead>
        <tr class="row_title">
             <th colspan = "2" align="center"><h3>Billing</h3></th>
         </tr>
    </thead>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="1" 	class="tabularForm">

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
	         <td align='center' height='17px'><?php echo round($totalBillAmt) ?></td>
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
 <table  width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm">
     <thead>
        <tr class="row_title">
             <th colspan = "2" align="center"><h3>Radiology</h3></th>
         </tr>
    </thead>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="1" 	class="tabularForm">

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
	         <td align='center' height='17px'><?php echo round($totalRadBillAmt) ?></td>
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
 <table  width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm">
     <thead>
        <tr class="row_title">
             <th colspan = "2" align="center"><h3>Laboratory</h3></th>
         </tr>
    </thead>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="1" 	class="tabularForm">

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
	         <td align='center' height='17px'><?php echo round($totalLabBillAmt) ?></td>
            </tr>
 <?php       } else { $cntBilling = "norecord"; ?>
            <tr>	
             <td align='center' height='17px' colspan="1"><?php echo  __('No Record Found'); ?></td>		
	        </tr>
 <?php       }
 ?>

 </table> <?php }?>
 <?php if($getPharmacyCash){?>
  <table  width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm">
     <thead>
        <tr class="row_title">
             <th colspan = "2" align="center"><h3>Pharmacy</h3></th>
         </tr>
    </thead>
</table>
 <table width="100%" cellpadding="0" cellspacing="1" border="1" 	class="tabularForm">

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
	         <td align='center' height='17px'><?php echo round($totalPharmaBillAmt) ?></td>
            </tr>
 <?php       } else { $cntBilling = "norecord"; ?>
            <tr>	
             <td align='center' height='17px' colspan="1"><?php echo  __('No Record Found'); ?></td>		
	        </tr>
 <?php       }
 ?>

 </table>
 <?php }?>
 

