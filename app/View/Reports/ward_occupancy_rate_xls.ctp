<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Bed_Occupancy_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );
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
<?php 
       // for daily reports
       if(!empty($reportMonth)) {
?>      
         <table width="100%" cellpadding="0" cellspacing="0" border="1" class="tabularForm">
		 <tr class="row_title">
           <td colspan = "4" align="center"><h2><?php echo __('Bed Occupancy Report').' - '.$reportYear; ?></h2></td>
         </tr>
          <tr>
           <td style="text-align:center;"><strong><?php echo __('Days', true); ?></strong></td>
	       <td style="text-align:center;"><strong><?php  echo __('Total Number of Inpatient Days', true);  ?></strong></td>
	       <td style="text-align:center;"><strong><?php  echo __('Total Number of Available Bed Days', true);  ?></strong></td>
           <td style="text-align:center;"><strong><?php  echo __('Occupancy Rate', true);  ?></strong></td>
          </tr>
		  <?php 
		       // print_r($filterIpdCountArray);exit;
			   foreach($yaxisArray as $key => $yaxisArrayVal) { 
		  ?>
		   <tr>
		    <td align="center"><?php echo $yaxisArrayVal; ?></td>
		    <td align="center"><?php if(@in_array($key, $filterIpdDateArray)) {  echo $filterIpdCountArray[$key]; } ?></td>
		    <td align="center"><?php if($totalBed >0) {  echo $totalBed ; } ?></td>
			<td align="center">
                         <?php
                                if(@in_array($key, $filterIpdDateArray) && $totalBed >0) {
                                   $wardOccupancyRate = ($filterIpdCountArray[$key]/$totalBed)*100;
                                   echo $this->Number->toPercentage($wardOccupancyRate);
                                } else {
                                   echo "0%";
                                }
                              
                         ?>
                        </td>
			 </tr>
          <?php } ?>
         </table>
<?php  } else { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="1" class="tabularForm">
        <tr class="row_title">
           <td colspan = "13" align="center"><h2><?php echo __('Bed Occupancy Report').' - '.$reportYear; ?></h2></td>
         </tr>
          <tr>
           <td width="200"></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <td width="100" style="text-align:center;"><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
           </tr>
           
           <tr>
          <td width="200" ><strong>Total Number of Inpatient Days</strong></td>
          
           <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center" width="100">
                   <?php 
                         if(@in_array($key, $filterIpdDateArray)) { echo $filterIpdCountArray[$key]; } else { echo "0"; }
                   ?>
                </td>
          <?php } ?>
           
           </tr>
           
           
           <tr>
          <td width="200"><strong>Total Number of Available Bed Days</strong></td> 
          
           <?php 
		     foreach($yaxisArray as $key => $yaxisArrayVal) {
                    $month = date("m", strtotime($key));
                     $year = date("Y", strtotime($key));
                     $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	       ?>
                <td align="center" width="100">
                   <?php 
                         
		                  if(strtotime($key) <= strtotime(date("F-Y"))) {
	                           if($totalBed) {
	                           	 echo $totalBed*$numberOfDays;
	                           }else { 
	                           	 echo "0"; 
	                           }
                           } else {
                           	  echo "0"; 
                           }
                   ?>
                </td>
          <?php } ?>
           
           </tr>
           
           
           <tr>
          <td width="200"><strong>Occupancy Rate</strong></td> 
          
           <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center" width="100">
                   <?php 
                  		#$filterWardCountArray[$key]=4;
                         //if(@in_array($key, $filterWardArray) && @in_array($key, $filterIpdDateArray)) { 
                         if(@in_array($key, $filterIpdDateArray) && $totalBed > 0) { 
                         	$month = date("m", strtotime($key));
                         	$year = date("Y", strtotime($key));
                         	$numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                if($year == date("Y")) {
                                  //echo $this->Number->toPercentage(($filterIpdCountArray[$key]/($filterWardCountArray[$key]*(date("d")-1)))*100);
                                  echo $this->Number->toPercentage(($filterIpdCountArray[$key]/($totalBed*$numberOfDays))*100); 
                                }else {
                                  //echo $this->Number->toPercentage(($filterIpdCountArray[$key]/($filterWardCountArray[$key]*$numberOfDays))*100);
                                  echo $this->Number->toPercentage(($filterIpdCountArray[$key]/($totalBed*$numberOfDays))*100);
                                }
                         	//echo $this->Number->toPercentage(($filterIpdCountArray[$key]/($filterWardCountArray[$key]*$numberOfDays))*100);
                         	#echo $filterIpdCountArray[$key]/$filterWardCountArray[$key]*100; 
                         } else { 
                         	echo "0%"; 
                         }
                   ?>
                </td>
          <?php } ?>
           
           </tr>
           
	  </table>
<?php } ?>