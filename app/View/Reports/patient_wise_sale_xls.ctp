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
<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}

.top-header {
	background: #3e474a;
	height: 60px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

textarea {
	width: 85px;
}

<?php //echo $this->element('reports_menu');
 ?>
 <div class="clr ht5"></div>
<div align="center" class="inner_title">
	<h3>Patient wise Sale Report</h3>  
</div>
<div id="container">                
<table width="100%" cellpadding="0" cellspacing="1" border="1"
	class="tabularForm top-header">
	<tr>
	     <th width="5%"  align="center" style="text-align:center;">No.</th>
		<th width="40%" align="left" style="text-align:center;"><strong>
		 <?php echo $this->Paginator->sort('InventorySupplier.name', __('Patient Name', true)); ?></strong></th>		 
		<th width="15%"  align="center"  style="text-align: center;"> Product Name</th>
		<th width="15%"  align="center"  style="text-align: center;"> Total amount</th>
		<th width="15%"  align="center"  style="text-align: center;"> Payment Type</th>
		<th width="15%"  align="center"  style="text-align: center;"> Qty</th>
	    <th width="15%"  align="center"  style="text-align: center;"><strong>
	   <?php echo $this->Paginator->sort('InventoryPurchaseDetail.create_time', __('Date', true)); ?></strong></th>		 
	</tr>
	<?php 
		$i=0; 
		foreach($reports as $result)
		{   $i++;
		$total = $result['PharmacySalesBill']['total'];
		$val = $val+ $total;
	 ?>
		<tr>
    		<td width="5" align="center" style="text-align:center;">
    			<?php echo $i; ?>
    		</td>
			<td width="97px"  align="center" style="text-align:center;">
				<?php 
				 //Patient name
			     	echo $result['Patient']['lookup_name']; 
			     ?>
		    </td>
		    
			<td width="149px" align="center"style="text-align:center;">
			     	<?php echo 	$items; ?>
		     </td>
			     	
		    <td width="144px"  align="center"style="text-align:center;">
			     	<?php echo $result['PharmacySalesBill']['total'];  ?>
			 </td>
	        <td width="144px"  align="center"style="text-align:center;">
			     	<?php echo $result['PharmacySalesBill']['payment_mode']; ?>
			 </td>
	          <td width="144px"  align="center"	style="text-align:center;">
			     	<?php echo $result['PharmacySalesBill']['tax'] ?>
			 </td>
			<td width="91px"  align="center"  style="text-align: center;">
				<?php 
				 $date = $this->DateFormat->formatDate2Local($result['PharmacySalesBill']['create_time'],Configure::read('date_format'));
				     echo $date;  ?>
			  </td>
	</tr>
	<?php }  ?>
	<tr> 
   <td   align="center"  style="text-align: center;font-weight:bold;"colspan="3">Aotal Amount Receivable </td>	
  </td>
   <td   align="center" style="text-align: center; font-weight:bold;"> <?php echo  $val;?></td>
   <td   align="center" style="text-align: center; font-weight:bold;" colspan="3"> <?php ?></td>
   </tr> 
</table>




	