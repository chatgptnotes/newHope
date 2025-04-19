<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"SSISurveyReports.xls" );
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
 <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
						 <th><?php echo __('Number of SSI', true); ?></th>
						 <th><?php echo __('Number of Surgical Procedure', true); ?></th>
                                                 <th><?php echo __('SSI%', true); ?></th>
                                </tr>
                                <tr>
						 <td align="center"><?php if(count($ssiCount) > 0) echo $ssiCount[0][0]['ssicount']; else echo  __('Record Not Found', true); ?></td>
						 <td align="center"><?php if(count($spYesCount) > 0) echo $spYesCount[0][0]['spYescount']; else echo  __('Record Not Found', true); ?></td>
                                                 <td align="center">
                                                 <?php if($ssiCount[0][0]['ssicount']>0 && $spYesCount[0][0]['spYescount']) {
                                                         $centssi = ($ssiCount[0][0]['ssicount']/$spYesCount[0][0]['spYescount'])*100;
                                                         echo $this->Number->toPercentage($centssi);
                                                       } else {
                                                         echo  __('Record Not Found', true);
                                                       }
                                                 ?></td>
                                                                                                
				</tr>
                   </table>

