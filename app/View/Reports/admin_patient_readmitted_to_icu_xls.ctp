<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Total_Number_of_Patient_Readmitted".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
  <tr><td <?php if(!empty($reportMonth))  echo 'colspan="2"'; else echo 'colspan="13"';  ?> align="center"><h2><?php echo __("Total Number of Patient Readmitted to ICU within 48 hrs").' - '.$reportYear;  ?></h2></td></tr>
          <?php 
                 // for daily reports
                 if(!empty($reportMonth)) {
          ?> 
          <tr>
           <td width="50%" align="center" ><strong><?php echo __('Days', true); ?></strong></td>
	   <td width="50%" style="text-align:center;"><strong><?php echo __('Total Number of Patient Readmitted to ICU within 48 hrs', true); ?></strong></td>
	  </tr>
          <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
          <tr>
           <td width="50%" align="center" ><?php echo $yaxisArrayVal; ?></td>
	   <td width="50%" align="center">
             <?php 
                if(@in_array($key, $filterPatientReadmittedDateArray)) { echo $filterPatientReadmittedCountArray[$key]; } else { echo "0"; }
             ?>
          </td>
	  </tr>
          <?php } ?>
          <?php } else { ?>
                  <tr>
                   <th width="200"></th>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <th width="100" ><?php echo $yaxisArrayVal; ?></th>
                   <?php } ?>
	          </tr>
                  <tr>
                   <td><strong><?php echo __('Total Number of Patient Readmitted to ICU within 48 hrs', true); ?><strong></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td align="center">
                     <?php 
                          if(@in_array($key, $filterPatientReadmittedDateArray)) { echo $filterPatientReadmittedCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
          <?php } ?>
  </table>

