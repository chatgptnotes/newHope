<div class="inner_title">
<h3>&nbsp; Monthly Summary Of Sale Vouchers <span style="color:RED;font-weight:lighter;"><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false); ?> to <?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);?></span></h3>
</div>
<br />

<table border="0" class="tabularForm"  cellpadding="0" cellspacing="1" width="100%" >	
			  <tr>
				<td colspan = "5" align="center"><strong></strong></td>
			  </tr>
			  
			  <tr>		  	  
				    <th align="center" valign="middle" style="text-align:center;" width="20%"><strong><?php echo __('Gross Amt'); ?></strong></th>					  
				    <th align="center" valign="middle" style="text-align:center;" width="20%"><strong><?php echo __('Disc Amt'); ?></strong></th>  
				   	<th align="center" valign="middle" style="text-align:center;" width="20%"><strong><?php echo __('Total Amt'); ?></strong></th> 
 					<th align="center" valign="middle" style="text-align:center;" width="20%"><strong><?php echo __('Cash Amt'); ?></strong></th> 
 					<th align="center" valign="middle" style="text-align:center;" width="20%"><strong><?php echo __('Credit Amt'); ?></strong></th> 
			   </tr>		
						<tr>							
							<td align='center'><?php echo $getGrossAmt;?></td>	
							<td align='center'><?php echo $getTotalDiscAmt;?></td>								
							<td align='center'><?php echo $getTotalAmt; ?></td>		
							<td align='center'><?php echo $totalCashAmt; ?></td>
							<td align='center'><?php echo $totalCreditAmt; ?></td>
						</tr>						
				
</table>