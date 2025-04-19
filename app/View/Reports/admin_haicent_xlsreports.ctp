<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"HAICentReports.xls" );
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
						 <th><?php echo __('Total HAI', true); ?></th>
						 <th><?php echo __('Number of Discharge', true); ?></th>
                                                 <th><?php echo __('Number of Death', true); ?></th>
                                                 <th><?php echo __('HAI Rate', true); ?></th>
                                </tr>
                                <tr>
						 <td align="center">
                                                  <?php 
                                                    $totalhai = ($ssiCount[0][0]['ssicount']+$vapCount[0][0]['vapcount']+$utiCount[0][0]['uticount']+$bsiCount[0][0]['bsicount']+$thromboCount[0][0]['thrombocount']); 
                                                    echo $totalhai;
                                                  ?>
                                                 </td>
						 <td align="center"><?php echo  __('5', true); ?></td>
                                                 <td align="center"><?php echo  __('10', true); ?></td>
                                                 <td align="center">
                                                  <?php 
                                                       $haicent = ($totalhai/(5+10))*100; 
                                                       echo $this->Number->toPercentage($haicent);
                                                  ?>
                                                 </td>
                                                 
                                                 
				</tr>
                   </table>
 

