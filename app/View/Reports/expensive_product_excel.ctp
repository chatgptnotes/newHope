<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"expensive_Product_report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Generated Report" );
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
   
</STYLE>
<table border="1" class="table_format"  cellpadding="2"  align="center" cellspacing="0" width="70%" style="text-align:left;padding-top:50px;">	
                  <tr class="row_title">
                   <td colspan="3" align="center">Expensive Product Reports</td>
                  </tr>
				  <tr class="row_title">
				       <td height="30px" align="center" valign="middle" ><strong><?php echo __('Sr.No.'); ?></strong></td>
				       <td height="30px" align="center" valign="middle" ><strong><?php echo __('Product Name'); ?></strong></td>
					   <td height="30px" align="center" valign="middle" ><strong><?php echo __('Stock'); ?></strong></td>	
				 </tr>
	<?php  
	  	 $toggle =0;
	      if(count($reports) > 0) {
			   $k = 1; 
	      		foreach($reports as $exlData){
	      		    $valCnt++;	
					//$person = $pdfData['Person'];
					?>
					<tr>
					    <td align='center' height='17px'><?php echo $valCnt; ?></td> 
						<td align='center' height='17px'><?php echo !empty($exlData['PharmacyItem']['name'])?$exlData['PharmacyItem']['name']:$exlData['Product']['name']; ?></td>
						<td align='center' height='17px'><?php echo !empty($exlData['PharmacyItem']['stock'])?$exlData['PharmacyItem']['stock']:$exlData['Product']['quantity']; ?></td>	 
					   
					</tr>
					<?php   
				 $k++; 
			   }
               
			  ?>
			   <tr> 
			   	<td height="30px" align="center" valign="bottom">
			   	 <strong>Total Products:<?php echo (count($reports)) ; ?></strong>
				</td>											
			   </tr>
				<?php 		  
				 } else {
					?> <tr>
							<td align="center" height="17px" colspan="9" > No Record Found</td>
									
						</tr>
<?php 
				 }
		?>			   		  
		</table>
		
