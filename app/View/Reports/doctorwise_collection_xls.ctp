<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Doctor_Wise_Billing".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
   <td colspan = "10" align="center"><h2><?php echo __('Doctor Wise Billing'); ?></h2></td>
  </tr>
  <tr class="row_title">
   <td height="30px" align="center" valign="middle" width="5%"><strong>Sr.No.</strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong>Date of Reg.</strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong><?php echo __("MRN")?></strong></td>
   <td height="30px" align="center" valign="middle" width="15%"><strong>Patient Name</strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong>Patient Status</strong></td>
   <td height="30px" align="center" valign="middle" width="5%"><strong>Patient Type</strong></td>  
   <td height="30px" align="center" valign="middle" width="10%"><strong>Consultant Type</strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong>Consultant</strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong>Payment Date</strong></td>
   <td height="30px" align="center" valign="middle" width="10%"><strong>Amount</strong></td>
 
  </tr>
  <?php 
        $cntCollection=0;
        $totalAmount = 0; 
        
  ?>
 <?php 
        // get doctor wise collection //
       // debug($getDoctorWiseCollection);exit;
        if(count($getDoctorWiseCollection) > 0) {
          foreach($getDoctorWiseCollection as $getDoctorWiseCollectionVal) {
            $cntCollection++;
			$registration_date = date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getDoctorWiseCollectionVal['Patient']['form_received_on'],'yyyy/mm/dd',true)));
			$totalAmount += $getDoctorWiseCollectionVal['ConsultantBilling']['amount'];  
			
 ?>
           <tr>			
		    <td align='center' height='17px'><?php echo $cntCollection; ?></td>
			<td align='center' height='17px'><?php echo $registration_date; ?></td>
			<td align='center' height='17px'><?php echo $getDoctorWiseCollectionVal['Patient']['admission_id']; ?></td>
	        <td align='center' height='17px'><?php echo $getDoctorWiseCollectionVal['PatientInitial']['name'].' '.$getDoctorWiseCollectionVal['Patient']['lookup_name']; ?></td>
	        <td align='center' height='17px'>
			 <?php if($getDoctorWiseCollectionVal['Patient']['admission_type'] == "IPD") {
			        if($getDoctorWiseCollectionVal['Patient']['is_discharge'] == 1) {  
						echo __('Discharged');
					} else {
						echo __('Not Discharged');
					}
		           }
				   if($getDoctorWiseCollectionVal['Patient']['admission_type'] == "OPD") {
			        if($getDoctorWiseCollectionVal['Patient']['is_discharge'] == 1) {  
						echo __('OP Process Completed');
					} else {
						echo __('OP In-Progress');
					}
		           }

			?>
			</td>
			<td align='center' height='17px'><?php echo $getDoctorWiseCollectionVal['Patient']['admission_type']; ?></td>
            <td align='center' height='17px'>
			 <?php 
			       if(!empty($getDoctorWiseCollectionVal['ConsultantBilling']['doctor_id'])) { 
			         echo  __('Treating Consultant');
			       }
				   if(!empty($getDoctorWiseCollectionVal['ConsultantBilling']['consultant_id'])) { 
			         echo  __('External Consultant');
			       }
			 ?>
			</td>
			<td align='center' height='17px'>
			<?php 
			       if(!empty($getDoctorWiseCollectionVal['ConsultantBilling']['doctor_id'])) { 
			         echo  $getDoctorWiseCollectionVal['Initial']['name'].' '.$getDoctorWiseCollectionVal['DoctorProfile']['doctor_name'];
			       }
				   if(!empty($getDoctorWiseCollectionVal['ConsultantBilling']['consultant_id'])) { 
			         echo  $getDoctorWiseCollectionVal['InitialAlias']['name'].' '.$getDoctorWiseCollectionVal['Consultant']['first_name'].' '.$getDoctorWiseCollectionVal['Consultant']['last_name'];
			       }
			 ?>
			</td>
			<td align='center' height='17px'><?php echo date("d/m/Y", strtotime($this->DateFormat->formatDate2Local($getDoctorWiseCollectionVal['ConsultantBilling']['date'],'yyyy/mm/dd',true))); ?></td>
            <td align='center' height='17px'><?php echo $getDoctorWiseCollectionVal['ConsultantBilling']['amount']; ?></td>
            
           </tr>
           
 <?php     
           
          }
        } else {
            $cntDoctorWiseCollection = "norecord";
        }
 ?>
 <?php
if($cntDoctorWiseCollection != 'norecord') {
 ?>
 <tr>					
  <td align='right' height='17px' colspan="9"><strong>Total Amount</strong></td>
  <td align='center' height='17px' colspan="1"><strong><?php echo $totalAmount; ?></strong></td>
 </tr>
<?php } ?>
<?php
if($cntDoctorWiseCollection == 'norecord') {
 ?>
 <tr>					
  <td align='center' height='17px' colspan="10">No Record Found</td>
 </tr>
<?php } ?>
           
</table>
		
