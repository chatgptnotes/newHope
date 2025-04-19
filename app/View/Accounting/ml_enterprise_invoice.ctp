<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
@media print {
  		#printButton{display:none;}
    }</style>
</head>
<body style="background:none;width:98%;margin:auto;">  
<div></div>
<div  align="right"  id="printButton">
	<?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();')); ?>
 </div>
 <table width="1000px" align="center" cellpadding="0" cellspacing="1"  class="table_format">
		<tr>
   			<h1 align="center"> 
 			<?php echo __(' M.L.ENTERPRISES' ); ?> </h1> 
		  <h3 align="center"> 
 			<?php echo __(' Distributor of orthopaedic & Arthroplasty Implants'); ?> </h3> 
 		  <h5 align="center"> 
 			<?php echo __(' B6 , PLOT NO. 3,CHAYA COMPLEX, WATHODA RING ROAD, NAGPUR'); ?> </h5> 
 		 <h5 align="center"> 
 			<?php echo __('Tel. : 0712-2715156'); ?></h5>
 		 </tr>
 		 <tr>
 		 	 <table width="1000px" align="center" cellpadding="1" cellspacing="0" border="1" style="max-height: 500px;">
 		     <tr>
 		        <td>
 		          <table width="1000px" align="center" cellspacing="0"  style="max-height: 400px;">
 		           <tr> <td width="74%" style="padding: 0 0 0 9px; height:93px;">M/S. &nbsp; <?php echo __('Hope Hospital')."<br>" ?>
 		           
 			  			<?php echo __('2,Teka Naka Square,Kamptee Road <br>Nagpur-440017,<br>Maharashtra'); ?> </td>
 			  		    <td width="24%" colspan="2"  style="border-left:1px solid; max-height: 400px;">
 			  				<table>
 			  					<tr><td>Bill No:</td>
 			  					  <td><?php echo $this->Form->input('Accounting.rate', array('type'=>'text', 'id' => 'customfirstname', 'label'=> false, 'div' => false, 'error' => false));?> </td>

 			  					</tr>
 			  					<tr><td>Date:</td><td><?php echo $this->DateFormat->formatDate2Local($voucherPaymentData['VoucherPayment']['date'],Configure::read('date_format'),false); ?></td>
 			  					</tr>
 			  				</table>
 			  			</td>
 			  		 </tr>
 		        	</table>
 		        </td>
 		    </tr>
 		  </table> 
 		 </tr>
 <table width="1000px" align="center"  cellpadding="1" cellspacing="1"  style="border:1px solid; max-height: 500px;">
    <tr bgcolor="LightGray"> 
	 			<td width="800px" align='center'  style="font-weight: bold; border-left:1px solid; padding: 0 0 0 9px;">DESCRIPTION</td>
	 			<td width="800px" align='center'  style="font-weight: bold; border-right:1px solid;  padding: 0 0 0 9px;">QUANTITY</td>
	 			<td width="800px" align='center'  style="font-weight: bold; padding: 0 0 0 9px;">RATE</td>
	 			<td width="800px" align='center'  style="font-weight: bold; padding: 0 0 0 9px;">Amount</td>
	 </tr>
	 <tr>
	 			<td width="50%" valign='top' align='center' style="border-right:1px solid; height:400px">&nbsp; <?php echo "Orthopaedic Implant" ?> </td>
	 			<td width="9%" valign='top' align='center'  style="border-right:1px solid;">&nbsp; 1  </td>
	 			<td width="9%" valign='top' align='center'  style="border-right:1px solid;">&nbsp;<?php echo $voucherPaymentData['VoucherPayment']['paid_amount'];?> </td>
	 			<td width="10%" valign='top' align='center'  style="border-bottom:1px solid;">&nbsp; <b><?php echo $voucherPaymentData['VoucherPayment']['paid_amount']; ?></b></td>
	 </tr>
     <tr >
      <td colspan="2" style="font-weight: bold; border-top:1px solid; padding: 0 0 0 9px;"> Rupees</td>
      <td colspan="1" style="font-weight: bold; border-top:1px solid; padding: 0 0 0 9px;"> Grand Total</td>
      <td colspan="1" style="font-weight: bold; border-left:1px solid; padding: 0 0 0 9px;"><?php echo $this->Number->currency($voucherPaymentData['VoucherPayment']['paid_amount']);?> </td>
     </tr> 	
    <tr>
    	<td colspan="2"  style="padding: 0 0 0 9px; border-top:1px solid; font-size:12px;" > "I we hereby certify that my/your registration certificate under the Maharashtra Value Added Tax,1002 is in force on 
    	 the date on which the sale of thhe goods specified in this tax invoice is made by me.us and that transaction of sales
    	 coverd by this tax invoice has been effected by me/us and it shall be accounted for the turnover of sale
    	 while filling of return and the due tax,if any, payable on the sale has been paid said or shall be paid."
    	 </td>
    	<td colspan="2"  style="padding: 0 0 0 9px; border-top:1px solid; font-size:12px; " > B.S.T. No. : 440008/S2562 Dt. 08/12/99 <BR>
    	     C.S.T No. : 440008/C/2195 Dt. 08/12/99 <BR>
    	     VAT No. :27090190261V
    	 </td>
    </tr>	
   <tr>
   		  <td colspan="2"  style="padding: 0 0 0 9px; border-top:1px solid; font-size:12px; " >TERMS & CONDITIONS <br>
   		  1)This bill is payble immediately on presentation,otherwise intrest @24% will be charged.<br> 
   		  2)Our risk & responsibility ceases on goods leaving our premises.<br> 
   		  3)Place od settlement and jusisdicition is Nagpur , not withstanding anything conntrary stipulated in the buyers letters,orders or contrats.<br> 
   		  4)Cheaques are to be made cross other in favour of company. 
   		  </td>
   		  <td colspan="2" valign="top" style="font-weight: bold; border-top:1px solid; padding: 0 0 0 9px; ">&nbsp; For M.L.ENTERPRISES
   		  </td></tr>
  </table>
    </tr> 
</td></tr></table>
</div>
 </body>
 </html>