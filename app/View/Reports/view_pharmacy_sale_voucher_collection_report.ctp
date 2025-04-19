<div class="inner_title">
    <h3>&nbsp; Monthly Summary Of Sale Vouchers <span style="color:RED;font-weight:lighter;"><?php echo $this->DateFormat->formatDate2Local($from, Configure::read('date_format'), false); ?> to <?php echo $this->DateFormat->formatDate2Local($to, Configure::read('date_format'), false); ?></span></h3>
</div>
<br />

<table border="0" class="tabularForm"  cellpadding="0" cellspacing="1" width="100%" >	
   <tr>
        <td colspan = "6" align="center"><strong>Monthly Summary Of Sale Vouchers From <?php echo $this->DateFormat->formatDate2Local($from, Configure::read('date_format'), false); ?></strong> to <strong><?php echo $this->DateFormat->formatDate2Local($to, Configure::read('date_format'), false); ?></strong></td>
    </tr>

    <tr style='background:#3796CB;color:#FFFFFF;'>		  	  
        <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Corporates'); ?></strong></td>
        <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Gross Amt'); ?></strong></td>					  
        <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Disc Amt'); ?></strong></td>  
        <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Total Amt'); ?></strong></td> 
        <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Cash Amt'); ?></strong></td> 
        <td height="30px" align="center" valign="middle" width="20%"><strong><?php echo __('Credit Amt'); ?></strong></td> 
    </tr> 
    <tr>					
        <td align="center" height='17px'><?php echo __('All Private & Corporate'); ?>
        <td align='center' height='17px'><?php echo $getGrossAmt; ?></td>	
        <td align='center' height='17px'><?php echo $getTotalDiscAmt; ?></td>								
        <td align='center' height='17px'><?php echo $getTotalAmt; ?></td>		
        <td align='center' height='17px'><?php echo $totalCashAmt; ?></td>
        <td align='center' height='17px'><?php echo $totalCreditAmt; ?></td>
    </tr> 
    <tr>	
        <td align="center" height='17px'><?php echo __('RGJAY'); ?>
        <td align='center' height='17px'><?php echo $rgjaygetGrossAmt; ?></td>	
        <td align='center' height='17px'><?php echo $rgjaygetTotalDiscAmt; ?></td>								
        <td align='center' height='17px'><?php echo $rgjaygetTotalAmt; ?></td>		
        <td align='center' height='17px'><?php echo $rgjaytotalCashAmt; ?></td>
        <td align='center' height='17px'><?php echo $rgjaytotalCreditAmt; ?></td>
    </tr> 
    <tr>	
        <td align="center" height='17px'><?php echo __('WCL'); ?>
        <td align='center' height='17px'><?php echo $wclgetGrossAmt; ?></td>	
        <td align='center' height='17px'><?php echo $wclgetTotalDiscAmt; ?></td>								
        <td align='center' height='17px'><?php echo $wclgetTotalAmt; ?></td>		
        <td align='center' height='17px'><?php echo $wcltotalCashAmt; ?></td>
        <td align='center' height='17px'><?php echo $wcltotalCreditAmt; ?></td>
    </tr>						

</table>