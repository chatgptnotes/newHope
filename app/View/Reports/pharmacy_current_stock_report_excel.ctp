<?php 
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Pharmacy_Current_Stock_Status_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Expiry Report" );
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
   .row_title{
		background: #ddd;
	}
	 .rowColor{
   		background-color:gray;
   		border-bottom-color: black;
   }
</STYLE>
<table width="100%" cellpadding="2" cellspacing="0" border="1" class="table_format" style="padding-top:10px" >
 			  <tr style='background:#3796CB;color:#FFFFFF;'>
				<td colspan = "6" align="center"><strong><?php echo ucfirst($getLocName);?></strong></td>
			  </tr>
			  <tr>
				<td colspan = "6" align="center"><strong><?php echo ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country);?></strong></td>
			  </tr>
			  
<tr style='background:#3796CB;color:#FFFFFF;'>
				<td colspan = "6" align="center"><strong>Pharmacy Current Stock Status Report</strong></td>
</tr>
<tr>
				<td colspan = "6" align="center"><strong><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false);?> upto</strong></td>
</tr>		
<tr style='background:#3796CB;color:#FFFFFF;'> 
<th width="6%" align="center" valign="top">Sr.No.</th>
	<th width="25%" align="center" valign="top">Product Name</th>
	<th width="17%" align="center" valign="top" style="text-align: center;">Batch No. </th>
	<th width="17%" align="center" valign="top" style="text-align: center;">Expiry Date</th>
	<th width="17%" align="center" valign="top" style="text-align: center;">Quantity</th> 
	<th width="17%" align="center" valign="top" style="text-align: center;">Value</th> 
	
</tr>
	
<?php $cnt=1;
$i=1;
$amt=0;
foreach($pharmacyItemDetails as $key=>$pharmacyItemDetailss){

$getQuantity=((int)$pharmacyItemDetailss['PharmacyItem']['pack']*$pharmacyItemDetailss['PharmacyItemRate']['stock'])+$pharmacyItemDetailss['PharmacyItemRate']['loose_stock'];
if($getQuantity<0)
		continue;
//if(empty($pharmacyItemDetailss['PharmacyItemRate']['expiry_date']) || $pharmacyItemDetailss['PharmacyItemRate']['expiry_date']=="0000-00-00")
//	continue;

?>
<tr <?php if($i%2 == 0) echo "style='background:#E5F4FC;'"; ?>>
<td align="center"><?php echo $cnt;?>
</td>
<td align="center"><?php echo $pharmacyItemDetailss['PharmacyItem']['name'];?>
</td>
<td align="center"><?php echo $pharmacyItemDetailss['PharmacyItemRate']['batch_number'];?>
</td>
<td align="center"><?php echo $this->DateFormat->formatDate2Local($pharmacyItemDetailss['PharmacyItemRate']['expiry_date'],Configure::read('date_format'));
?>
</td>
<td align="center"><?php 

echo $getQuantity; ?>
</td> 
<td align="center"><?php $getValue=$pharmacyItemDetailss['PharmacyItemRate']['sale_price']/$pharmacyItemDetailss['PharmacyItem']['pack'];
$amt =$amt+($getQuantity*$getValue);
echo number_format(((int)$getQuantity*$getValue), 2); ?>
</td> 
</tr>
<?php $cnt++;
$i++;
}?>
<tr>
	<td colspan="5" align="center">Total </td>
	<td><?php echo $amt; ?></td>
</tr>
</table>