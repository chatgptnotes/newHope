<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Laundry_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Generated Report" );
?>
<STYLE type="text/css">
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
<table border="1" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
	 <tr class="row_title">
	   <td colspan = "9" align="center"><h2>Laundry Items Management - Report</h2></td>
	</tr>
	  <tr class="row_title">
		   <td height="30px" align="center" valign="middle" width="7%"><strong>Sr.No.</strong></td>
		   <td height="30px" align="center" valign="middle"><strong>Date</strong></td>
		   <td height="30px" align="center" valign="middle"><strong>Item Code</strong></td>
		   <td height="30px" align="center" valign="middle"><strong>Item Name</strong></td>					   
		   <td height="30px" align="center" valign="middle"><strong>Total Stock</strong></td>
		   <td height="30px" align="center" valign="middle"><strong><?php echo __("Room");?></strong></td>
	<?php 
			if($linenType == 'In Linen'){ ?>
				<td height="30px" align="center" valign="middle"><strong>In Linen</strong></td>
		<?php } else if($linenType == 'Out Linen'){ ?>
				<td height="30px" align="center" valign="middle"><strong>Out Linen</strong></td>
		<?php } else { ?>
				<td height="30px" align="center" valign="middle"><strong>Type</strong></td>
				<td height="30px" align="center" valign="middle"><strong>Last Entry</strong></td>
		<?php } ?>
			<td height="30px" align="center" valign="middle"><strong>In Stock</strong></td>
					   				   
	     </tr>
				 <?php  
				 $toggle =0;
				      if(count($reports) > 0) {
						   $i = 1;
				      		foreach($reports as $pdfData){	
								$ward = ClassRegistry::init('Ward')->field('name',array('Ward.id'=>$pdfData["InstockLaundry"]["ward_id"]));
				?>
		<tr>
			   <td align="center" height="17px" valign="middle"><?php echo $i; ?></td>
			   <td align="center" height="17px" valign="middle"><?php
			  			echo $this->DateFormat->formatDate2Local($pdfData["InstockLaundry"]["create_time"],Configure::read('date_format'),true);
        		  ?></td>
			   <td align="center" height="17px" valign="middle"><?php echo $pdfData["InstockLaundry"]["item_code"];?></td>
			   <td align="center" height="17px" valign="middle"><?php echo $pdfData["InstockLaundry"]["item_name"];?></td>
			   <td align="center" height="17px" valign="middle"><?php echo ucfirst($pdfData["InstockLaundry"]["total_quantity"])?></td>
			   <td align="center" height="17px" valign="middle"><?php echo ucfirst($ward)?> </td>
			<?php 
					if(!empty($linenType)){ ?>
							<td align="center" height="17px" valign="middle"><?php echo ucfirst($pdfData["InstockLaundry"]["last_entry"]);?></td>
					<?php } else {   ?>
							<td align="center" height="17px" valign="middle"><?php echo ucfirst($pdfData["InstockLaundry"]["type"]); ?></td>
							<td align="center" height="17px" valign="middle"><?php echo ucfirst($pdfData["InstockLaundry"]["last_entry"]); ?></td>

					<?php } ?>
							<td align="center" height="17px" valign="middle"><?php echo $pdfData["InstockLaundry"]["in_stock"]; ?></td>					  					   
								   							   
		</tr>
					<?php $i++;  
						   } 
					 } else { ?>
		<tr>
			<td colspan = "8" align="center" height="30px">No Record Found For the Selection!</td>
		</tr>
	 <?php } ?>
			   		  
</table>
