<?php
header("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"Monthly_Summary_Of_Sale_Vouchers_" . $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'), Configure::read('date_format'), true) . ".xls");
header("Content-Description: Generated Report");
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
    /*.row_title{
                 background: #ddd;
         }
          .rowColor{
                 background-color:gray;
                 border-bottom-color: black;
    }*/
</STYLE>

<table border="1" class="table_format"  cellpadding="2" cellspacing="0" width="100%" style="text-align:left;padding-top:50px;">	
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