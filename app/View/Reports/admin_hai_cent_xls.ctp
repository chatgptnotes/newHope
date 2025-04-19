<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"HAI_Rate".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
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
  <tr><td colspan="13" align="center"><h2><?php echo __("Hospital Associated Infections Rate")." - ".$reportYear; ?></h2></td></tr>
          <tr>
           <td width='40%'></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <td height='30px' align='center' valign='middle' width='12%'><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
           </tr>
	  <tr>
		<td height='30px' align='left' valign='middle'><strong><?php echo __('Total HAI', true); ?></strong></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                     <?php    
                                    if(empty($filterSsiCountArray[$key])) $filterSsiCountArray[$key] = 0;
                                    if(empty($filterVapCountArray[$key])) $filterVapCountArray[$key] = 0;
                                    if(empty($filterUtiCountArray[$key])) $filterUtiCountArray[$key] = 0;
                                    if(empty($filterBsiCountArray[$key])) $filterBsiCountArray[$key] = 0;
                                    if(empty($filterThromboCountArray[$key])) $filterThromboCountArray[$key] = 0;
                                    if(empty($filterOtherCountArray[$key])) $filterOtherCountArray[$key] = 0;                 
                                    $totalCount = $filterSsiCountArray[$key] + $filterVapCountArray[$key] + $filterUtiCountArray[$key] + $filterBsiCountArray[$key] + $filterThromboCountArray[$key]+$filterOtherCountArray[$key];
                                    
                                    if($totalCount > 0) {
				      echo $totalCount;
				    } else { echo "0"; }
				    $totalCount = 0;
		    ?>
                </td>
          <?php } ?>
          </tr>
         <tr>
		<td height='30px' align='left' valign='middle'><strong><?php  echo __('Total Number of Discharge + Number of Death', true);  ?></strong></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td align="center">
                  <?php 
                         if(@in_array($key, $filterdischargeDeathDateArray)) { echo $filterdischargeDeathCountArray[$key]; } else { echo "0"; }
                   ?>
                 </td>
          <?php } ?>
          </tr>
          <tr>
		<td height='30px' align='left' valign='middle'><strong><?php  echo __('HAI Rate', true);  ?></strong></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td align="center">
                  <?php 
                                    if(empty($filterSsiCountArray[$key])) $filterSsiCountArray[$key] = 0;
                                    if(empty($filterVapCountArray[$key])) $filterVapCountArray[$key] = 0;
                                    if(empty($filterUtiCountArray[$key])) $filterUtiCountArray[$key] = 0;
                                    if(empty($filterBsiCountArray[$key])) $filterBsiCountArray[$key] = 0;
                                    if(empty($filterThromboCountArray[$key])) $filterThromboCountArray[$key] = 0;
                                    if(empty($filterOtherCountArray[$key])) $filterOtherCountArray[$key] = 0;                 
                                    $totalCount = $filterSsiCountArray[$key] + $filterVapCountArray[$key] + $filterUtiCountArray[$key] + $filterBsiCountArray[$key] + $filterThromboCountArray[$key]+$filterOtherCountArray[$key];
                                    if($filterdischargeDeathCountArray[$key] > 0  && $totalCount > 0) {
                                       $totalHaiRate =  ($totalCount/$filterdischargeDeathCountArray[$key])*100; 
                                       echo $this->Number->toPercentage($totalHaiRate);
                                    } else {
                                       echo $this->Number->toPercentage(0);
                                    }
                   ?>           
                 </td>
          <?php } ?>
          </tr>
        </table>

