<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"VAP_Rate".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
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
  <tr><td colspan="13" align="center"><h2><?php echo __("VAP Rate")." - ".$reportYear; ?></h2></td></tr>
          <tr>
           <td width='30%'></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <td height='30px' align='center' valign='middle' width='12%'><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
           </tr>
	  <tr>
		<td height='30px' align='left' valign='middle'><strong><?php echo __('Total Number of VAP Cases', true); ?></strong></td>
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td height='30px' align='center' valign='middle'>
                   <?php 
                         if(@in_array($key, $filterVapDateArray)) { echo $filterVapCountArray[$key]; } else { echo "0"; }
                   ?>
                </td>
          <?php } ?>
          </tr>
          <tr>
		<td height='30px' align='left' valign='middle'><strong><?php  echo __('Total Number of VAP Days', true);  ?></strong></td>  
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td height='30px' align='center' valign='middle'>
                  <?php 
                         if(@in_array($key, $filterVapTotalDateArray)) { echo $filterVapTotalCountArray[$key]; } else { echo "0"; }
                   ?>
                 </td>
          <?php } ?>
          </tr>
         <tr>
		<td height='30px' align='left' valign='middle'><strong><?php  echo __('VAP Rate', true); ?></strong></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td height='30px' align='center' valign='middle'>
                  <?php 
                        if(@in_array($key, $filterVapDateArray) && @in_array($key, $filterVapTotalDateArray)) {
                           $vapRate = ($filterVapCountArray[$key]/$filterVapTotalCountArray[$key])*100;
                           echo $this->Number->toPercentage($vapRate);
                          } else {
                           echo "0";
                          }
                   ?>
                </td>
          <?php } ?>
          </tr>
        </table>

