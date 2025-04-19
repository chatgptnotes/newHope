<?php
$documentName = $getBasicData['Patient']['lookup_name']."-".$getBasicData['Patient']['admission_id'] ;
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=".$documentName.".doc");    

ob_clean();
flush();
?>

<style >
	body{margin:10% 0 0 0 !important; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;}
</style>

 <table width="100%" style="border-bottom: solid 2px black">
		<!-- <tr>
			<td width="50%"><?php echo $this->Html->image('hope-logo-sm.gif');?></td>
			<td width="50%"><b>Hope Hospitals</b> Plot No. 2, Behind Go Gas,Teka Naka, <br>Kamptee
				Road, Nagpur - 440 017 <br> <b>Phone: </b>+91 712 2980073 <b>Email:
			</b>info@hopehospital.com<br><b>Website: </b>www.hopehospital.com</td>
		</tr> -->
		<tr><td style="font-size: 20px;font-weight: bold; text-align: center;" colspan="2"><?php echo "INVOICE";?></td></tr>
	</table> 
<table width="100%" border="0" cellspacing="2" cellpadding="2" align="center" style="background:#fff;" >
  <tr>
    	<td>Date : <?php echo   date('jS F Y',strtotime($savedData['OpdInvoice']['date'])) ; //$this->DateFormat->formatDate2Local($savedData['OpdInvoice']['date'],Configure::read('date_format'))?></td>
  </tr>
   <tr>
    	<td>Invoice No : <?php echo $savedData['OpdInvoice']['bill_number'] ; ?></td>
  </tr>
  <tr>
    	<td>MRN Number : <?php echo $getBasicData['Patient']['admission_id'] ; ?></td>	
  </tr>
  <tr>
		<td><?php echo __('Buckle ID'); ?> :  <?php echo $buckleId = ($savedData['OpdInvoice']['executive_emp_id_no']) ? $savedData['OpdInvoice']['executive_emp_id_no'] : $getBasicData['Patient']['executive_emp_id_no'] ; ?></td>
	</tr>
	<tr>
		<td><?php echo __('Name of Police Station'); ?> : <?php echo $nameOfpoliceStation = ($savedData['OpdInvoice']['name_police_station']) ? $savedData['OpdInvoice']['name_police_station'] : $getBasicData['Patient']['name_police_station'] ;
			
		  ?></td>
	</tr>
  <tr>
    	<td>Patient Name :<?php echo $getBasicData['Patient']['lookup_name'] ; ?></td>
  </tr>
  <tr>
    	<td>Age/Sex : <?php echo  $age."/".ucfirst($getBasicData['Patient']['sex']) ;; ?> </td>
  </tr>
  <tr>
    	<td>Description of Services : <?php echo $savedData['OpdInvoice']['service_description'] ; ?></td>
  </tr>

  <tr>
    	<td>Tests Included </td>
  </tr>

  <?php foreach ($savedData['OpdInvoiceDetail'] as $key => $value) { ?>
	 <tr>	    		
			    <td>	
			    	<?php echo $key+1 ; ?> . 
			    	<?php echo $value['services'] ;?>
			    </td>
		</tr>
		<?php } ?>

		<tr>
    	<td><strong>Total Amount :  INR <?php echo number_format($savedData['OpdInvoice']['total_amount'],2); ; ?></strong></strong></td>
  </tr>
  <tr>
  	<td>
		Payment Terms: Due upon receipt <br>
		Please make your payment to "DrM Hope Hospital Pvt Ltd" by cash, cheque, or bank transfer. <br> Kindly mention the invoice number on the cheque or in the transaction reference if paying via bank transfer. <br> Our Bank Name: Pusad Urban Co-Operative Bank. <br>Account Number:002006910000003 <br>Account Name: DrM HOPE HOSPITAL PRIVATE LIMITED <br>Branch Name: NAGPUR BRANCH <br>IFSC Code:PUSD0000020<br>
		Thank you for choosing Hope Hospital for your medical check-up needs. <br>We appreciate your trust in our services and look forward to serving you in the future.
		Sincerely,
  		
  	</td>
  </tr>
 </table>
 <table style="padding-top: 40px;">
 	<tr>
 		<td>
 			Shrikant Bhalerao<br>
			Director corporate,<br>
			Hope Hospital
 		</td>
 	</tr>
 </table>




