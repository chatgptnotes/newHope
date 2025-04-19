<div class="inner_title">
<h3>&nbsp; Monthly Summary Of Purchase Vouchers <span style="color:RED;font-weight:lighter;"><?php echo $this->DateFormat->formatDate2Local($from,Configure::read('date_format'), false); ?> to <?php echo $this->DateFormat->formatDate2Local($to,Configure::read('date_format'), false);?></span></h3>
</div>
<br />
<table border="0" class="tabularForm"  cellpadding="0" cellspacing="1" width="100%" >	
			  <tr>
				<td colspan = "3" align="center"><strong></strong></td>
			  </tr>
			  
			  <tr>		  	  
				    <th align="center" style="text-align:center;" width="33%"><strong><?php echo __('Gross Amount'); ?></strong></th>				  
				   	<th align="center" style="text-align:center;"  width="33%"><strong><?php echo __('Total Amount'); ?></strong></th>  		
				   		<th  align="center" style="text-align:center;"  width="33%"><strong><?php echo __('V.A.T.'); ?></strong></th>  								
			   </tr>		
						<tr>							
							<td align='center' ><?php echo round($getGrossAmt);?></td>														
							<td align='center' ><?php echo round($getTotalAmt); ?></td>
							<td align='center'><?php echo round($getVatAmt); ?></td>											
						</tr>						
				
</table>