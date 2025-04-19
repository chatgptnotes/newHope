<?php 
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Pharmacy_Expiry_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
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
<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;" align="center">	
  <?php if($flagRemaining){
		$getColspanVal="5";
}else{
		$getColspanVal="4";
		}
?>
  <tr style='background:#3796CB;color:#FFFFFF;'>
		<td colspan = "<?php echo $getColspanVal;?>" align="center"><strong><?php echo ucfirst($getLocName);?></strong></td>
  </tr>
  <tr>
		<td colspan = "<?php echo $getColspanVal;?>" align="center"><strong><?php echo ucfirst($getLocAdd1).' '.ucfirst($getLocAdd2).' '.ucfirst($location_zipcode).','.ucfirst($location_country);?></strong></td>
  </tr>
  <tr>
  		<td colspan = "<?php echo $getColspanVal;?>" align="center"><strong>Pharmacy Expiry Report</strong></td>
  </tr>			
  <tr style='background:#3796CB;color:#FFFFFF;' width="100%"> 	
	<?php if($flagRemaining){?>
	<th width="6%" align="center" valign="top">Sr.No.</th>
	<th width="25%" align="center" valign="top">Product Name</th>
	<th width="25%" align="center" valign="top" style="text-align: center;">Batch No. </th>
	<th width="25%" align="center" valign="top" style="text-align: center;">Expiry Date</th>
	<th width="19%" align="center" valign="top" style="text-align: center;">Days Remaining in Expiry/Expired</th> 
	<?php }else if($flagRemaining=="0"){?>
	<th width="6%" align="center" valign="top">Sr.No.</th>
	<th width="35%" align="center" valign="top">Product Name</th>
	<th width="29%" align="center" valign="top" style="text-align: center;">Batch No. </th>
	<th width="30%" align="center" valign="top" style="text-align: center;">Expiry Date</th>
	<?php }?>	
  </tr>
	
<?php 
$cnt=1;
$i=0;

if(count($pharmacyItemDetails)>0) {
foreach($pharmacyItemDetails as $key=>$pharmacyItemDetailss){
$i++;
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
<?php if($flagRemaining){?>
 <td align="center"><?php 
				$getDays = '';
				if(date("Y-m-d") > $pharmacyItemDetailss['PharmacyItemRate']['expiry_date']){
					$getDays="Expired";
				}else{
					$d_start    = new DateTime(date('Y-m-d'));
					$d_end      = new DateTime($pharmacyItemDetailss['PharmacyItemRate']['expiry_date']);
					$diff = $d_start->diff($d_end);	
					$getDays=$diff->days; 
					if($getDays=="0"){
						$getDays="Expired";
					}
				}
echo $getDays;
?>
</td> 
<?php }?>
</tr>
<?php $cnt++;
}
}else{?>
<tr>
<td colspan="5" align="center" style='background:#E5F4FC;'>No Record Found.</td>
</tr>
<?php }?>
</table>