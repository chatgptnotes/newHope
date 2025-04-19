<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Patient_Summary_With_Cash_And_Card_Type".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
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
  <tr><td <?php if($reportMonth) echo 'colspan="6"'; else echo 'colspan="13"'; ?> align="center"><h2><?php echo __("Patient Summary With Cash/Card Type").' - '.$reportYear; ?></h2></td></tr>
          <?php 
                 // for daily reports
                 if(!empty($reportMonth)) {
          ?> 
		  
          <tr>
           <td align="center" width="200" ><strong><?php echo __('Days', true); ?></strong></td>
	       <td align="center" width="200" ><strong><?php echo __('Total Number of IPD Patient With Cash Type', true); ?></strong></td>
           <td align="center" width="200" ><strong><?php echo __('Total Number of IPD Patient With Card Type', true); ?></strong></td>
           <td align="center" width="200" ><strong><?php echo __('Total Number of OPD Patient With Cash Type', true); ?></strong></td>
           <td align="center" width="200" ><strong><?php echo __('Total Number of OPD Patient With Card Type', true); ?></strong></td>
           <td align="center" width="200" ><strong><?php echo __('Total Number', true); ?></strong></td>
	  </tr>
          <?php 
             $totalNumber=0; 
             foreach($yaxisArray as $key => $yaxisArrayVal) { 
          ?>
             <tr>
             <td align="center"><?php echo $yaxisArrayVal; ?></td>
             <td align="center">
               <?php 
                 if(@in_array($key, $filterMonthIPDCashDateArray)) { $totalNumber += $filterMonthIPDCashCountArray[$key]; echo $filterMonthIPDCashCountArray[$key]; } else { echo "0"; }
               ?>
             </td>
             <td align="center">
               <?php 
                 if(@in_array($key, $filterMonthIPDCardDateArray)) { $totalNumber += $filterMonthIPDCardCountArray[$key]; echo $filterMonthIPDCardCountArray[$key]; } else { echo "0"; }
               ?>
             </td>
             <td align="center">
               <?php 
                 if(@in_array($key, $filterMonthOPDCashDateArray)) { $totalNumber += $filterMonthOPDCashCountArray[$key]; echo $filterMonthOPDCashCountArray[$key]; } else { echo "0"; }
               ?>
             </td>
             <td align="center">
               <?php 
                 if(@in_array($key, $filterMonthOPDCardDateArray)) { $totalNumber += $filterMonthOPDCardCountArray[$key]; echo $filterMonthOPDCardCountArray[$key]; } else { echo "0"; }
               ?>
             </td>
             <td align="center">
              <?php echo $totalNumber; ?>
             </td>
            </tr>
           <?php $totalNumber=0; } ?>
          <?php } else { ?>
		  
                   <tr>
                   <th width="250"></th>
                   <?php 
                        $totalNumber= array();
                        foreach($yaxisArray as $key => $yaxisArrayVal) { 
                   ?>
                    <th width="100"><?php echo $yaxisArrayVal; ?></th>
                   <?php } ?>
	          </tr>
                  <tr>
                   <td align="left" ><strong><?php echo __('Total Number of IPD Patient With Cash Type', true); ?></strong></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td align="center" >
                     <?php 
                          if(@in_array($key, $filterYearIPDCashDateArray)) {  $totalNumber[$key] += $filterYearIPDCashCountArray[$key]; echo $filterYearIPDCashCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
                   <tr>
                   <td align="left" ><strong><?php echo __('Total Number of IPD Patient With Card Type', true); ?></strong></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td align="center" >
                     <?php 
                          if(@in_array($key, $filterYearIPDCardDateArray)) { $totalNumber[$key] += $filterYearIPDCardCountArray[$key]; echo $filterYearIPDCardCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
                   <tr>
                   <td align="left" ><strong><?php echo __('Total Number of OPD Patient With Cash Type', true); ?></strong></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td align="center">
                     <?php 
                          if(@in_array($key, $filterYearOPDCashDateArray)) { $totalNumber[$key] += $filterYearOPDCashCountArray[$key]; echo $filterYearOPDCashCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
                   <tr>
                   <td align="left"><strong><?php echo __('Total Number of OPD Patient With Card Type', true); ?></strong></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td align="center">
                     <?php 
                          if(@in_array($key, $filterYearOPDCardDateArray)) { $totalNumber[$key] += $filterYearOPDCardCountArray[$key]; echo $filterYearOPDCardCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
                  <tr>
                   <td align="left"><strong><?php echo __('Total Number', true); ?></strong></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td align="center">
                     <?php 
                          if(@array_key_exists($key, $totalNumber)) {  echo $totalNumber[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
          <?php } ?>
  </table>

