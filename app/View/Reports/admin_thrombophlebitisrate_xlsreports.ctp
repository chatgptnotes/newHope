<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"ThrombophlebitisRate.xls" );
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
  <tr><td colspan="3"><h3><?php echo __("Thrombophlebitis Rate Reports"); ?></h3></td></tr>
                   		<tr class='row_title'>
						 <td height='30px' align='center' valign='middle' width='35%'><strong><?php echo __('Number of Thrombophlebitis', true); ?></strong></td>
						 <td height='30px' align='center' valign='middle' width='35%'><strong><?php echo __('Number of Peripheral Line', true); ?></strong></td>
                                                 <td height='30px' align='center' valign='middle' width='30%'><strong><?php echo __('Thrombophlebitis Rate', true); ?></strong></td>
                                </tr>
                                <tr>
						 <td align="center" height="17px" ><?php if(count($thromboCount) > 0) echo $thromboCount[0][0]['thrombocount']; else echo  __('Record Not Found', true); ?></td>
						 <td align="center" height="17px" ><?php if(count($plCount) > 0) echo $plCount[0][0]['plcount']; else echo  __('Record Not Found', true); ?></td>
                                                 <td align="center" height="17px" >
                                                 <?php if($thromboCount[0][0]['thrombocount']>0 && $plCount[0][0]['plcount']) {
                                                         $thromborate = ($thromboCount[0][0]['thrombocount']/$plCount[0][0]['plcount'])*100;
                                                         echo $this->Number->toPercentage($thromborate);
                                                       } else {
                                                         echo  __('Record Not Found', true);
                                                       }
                                                 ?></td>
                                                                                                
				</tr>
                   </table>