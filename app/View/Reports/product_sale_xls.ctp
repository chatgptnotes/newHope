<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"patient_wise_sale_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Patient Wise sale Report" );
ob_clean();
flush();
?>
<div class="inner_title">
	<h3  align="center">Product wise sale Report</h3>
</div>               
<table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm labTable resizable sticky" id="item-row"
	style="top:0px;overflow: scroll;">
	<tr>
	     <th width="5%"  align="center" style="text-align:center;">No.</th>
		<th width="40%" align="left" style="text-align:center;"><strong> <?php echo $this->Paginator->sort(' ', __('Name Of Product', true)); ?>
		 </strong></th>		 
		<th width="15%"  align="center"  style="text-align: center;"> Total amount</th>
		<th width="15%"  align="center"  style="text-align: center;"> Payment Type</th>
	    <th width="15%"  align="center"  style="text-align: center;"><strong>
	         <?php echo $this->Paginator->sort('PharmacySalesBill.create_time', __('Date', true)); ?>
	     
	     </strong></th>		 
	</tr>
	<?php 
		$i=0; 
		foreach($reports as $result)
		{   $i++;

		$total = $result['InventoryPurchaseDetail']['total_amount'];
		$val1 = $val1 + $total;
	 ?>
		<tr>
    		 <td width="5" align="center" style="text-align:center;">
    		    	<?php echo $i;?>
    		 </td>
			<td width="97px"  align="center" style="text-align:center;">
				<?php //echo  $result['PharmacyItem']['name'];
					echo $items ?>
		     </td>
		     <td width="144px"  align="center"	style="text-align:center;">
			     	<?php echo $result['PharmacySalesBill']['total'] ; ?>
			 </td>
	         <td width="144px"  align="center"	style="text-align:center;">
			     	<?php echo $result['PharmacySalesBill']['payment_mode'];  ?>
			 </td>
			<td width="91px"  align="center"  style="text-align: center;">
				<?php 
				 $date = $this->DateFormat->formatDate2Local($result['PharmacySalesBill']['create_time'],Configure::read('date_format'));
				     echo $date;  ?>
			  </td>
  	  </tr>
	<?php }  ?>
	
</table>
