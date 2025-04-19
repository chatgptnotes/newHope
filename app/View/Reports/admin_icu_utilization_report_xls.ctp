<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"ICU_Utilisation_Rate".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
  <tr><td colspan="13" align="center"><h2><?php echo __("ICU Utilisation Rate")." - ".$reportYear; ?></h2></td></tr>
          <tr>
           <td width='30%'></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <td height='30px' align='center' valign='middle' width='12%'><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
           </tr>
	  <tr>
		<td><?php echo __('Total ICU Hours', true); ?></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                   <?php 
				         // check total bed count if update in past //
						  if(array_key_exists($key, $getLastListBedMonthCount)) {
							 if($getLastListBedMonthCount[$key] != "") 
								 $allBedCountWithpast = $getLastListBedMonthCount[$key];
							 else 
								 $allBedCountWithpast = $totalBedCount;
						  }
				         $dateExp = explode("-", date("Y-m", strtotime($key)));
	                     $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $dateExp[1], $dateExp[0]);
                         if($allBedCountWithpast > 0) { print($allBedCountWithpast*24*$daysInMonth*60); } else { echo "0"; }
                   ?>
                </td>
          <?php } ?>
          </tr>
          <tr>
		   <td><?php  echo __('Total Patient Hours in ICU', true);  ?></td>   
			  <?php 
				foreach($yaxisArray as $key => $yaxisArrayVal) {
			  ?>
                 <td align="center">
                      <?php if(@in_array($key, $filterIpdDateArray)) {  echo $filterIpdCountArray[$key]; } else { echo "0"; } ?>
                 </td>
          <?php } ?>
          </tr>
		  
         <tr>
		<td><b><?php  echo __('ICU Utilisation Rate', true); ?></b></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                    <?php 
					     // check total bed count if update in past //
						  if(array_key_exists($key, $getLastListBedMonthCount)) {
							 if($getLastListBedMonthCount[$key] != "") 
								 $allBedCountWithpast = $getLastListBedMonthCount[$key];
							 else 
								 $allBedCountWithpast = $totalBedCount;
						  }
					     $dateExp = explode("-", date("Y-m", strtotime($key)));
	                     $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $dateExp[1], $dateExp[0]);
                         if($allBedCountWithpast > 0) { $icuHours = ($allBedCountWithpast*24*$daysInMonth*60); } else { $icuHours = 0; }
                         if(@in_array($key, $filterIpdDateArray)) {  
                             $icuUtiRate =  ($filterIpdCountArray[$key]/$icuHours)*100;
							 echo $this->Number->toPercentage($icuUtiRate);
						 } else { 
							 echo "0"; 
						 }
                   ?>
                </td>
          <?php } ?>
          </tr>
        </table>

