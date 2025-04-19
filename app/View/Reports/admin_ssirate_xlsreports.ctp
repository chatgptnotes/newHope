<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"SSIRate.xls" );
header ("Content-Description: Generated Report" );
ob_clean();
flush();
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
 <table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>	
  <tr><td colspan="3"><h3><?php echo __("SSI Rate Reports"); ?></h3></td></tr>
                   		<tr class='row_title'>
						 <td height='30px' align='center' valign='middle' width='35%'><strong><?php echo __('Number of SSI', true); ?></strong></td>
						 <td height='30px' align='center' valign='middle' width='35%'><strong><?php echo __('Number of Surgical Procedure', true); ?></strong></td>
                                                 <td height='30px' align='center' valign='middle' width='30%'><strong><?php echo __('SSI Rate', true); ?></strong></td>
                                </tr>
                                <tr>
						  <td align="center" height="17px" ><?php if(count($ssiCount) > 0) echo $ssiCount[0][0]['ssicount']; else echo  __('Record Not Found', true); ?></td>
						  <td align="center" height="17px" ><?php if(count($spYesCount) > 0) echo $spYesCount[0][0]['spYescount']; else echo  __('Record Not Found', true); ?></td>
                                                  <td align="center" height="17px" >
                                                 <?php if($ssiCount[0][0]['ssicount']>0 && $spYesCount[0][0]['spYescount']) {
                                                         $centssi = ($ssiCount[0][0]['ssicount']/$spYesCount[0][0]['spYescount'])*100;
                                                         echo $this->Number->toPercentage($centssi);
                                                       } else {
                                                         echo  __('Record Not Found', true);
                                                       }
                                                 ?></td>
                                                                                                
				</tr>
                   </table>

