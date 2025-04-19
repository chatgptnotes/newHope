<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Monthly_Consultations_By_Department".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
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
  
          <?php 
                 // for daily reports
                 if(!empty($reportMonth)) {
          ?> 
		  <tr><td colspan="2" align="center"><h2><?php echo __("Consultations By Specilty").' - '.$reportYear; ?></h2></td></tr>
          <tr>
           <td width="50%" align="center" ><strong><?php echo __('Days', true); ?></strong></td>
	   <td width="50%" style="text-align:center;"><strong><?php echo __('Total Number of Daily Consultations', true); ?></strong></td>
	  </tr>
          <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
          <tr>
           <td width="50%" align="center" ><?php echo $yaxisArrayVal; ?></td>
	   <td width="50%" align="center">
             <?php 
                if(@in_array($key, $filterDepartConsultDateArray)) { echo $filterDepartConsultCountArray[$key]; } else { echo "0"; }
             ?>
          </td>
	  </tr>
          <?php } ?>
          <?php } else { ?>
		  <tr><td colspan="13" align="center"><h2><?php echo __("Consultations By Specilty").' - '.$reportYear; ?></h2></td></tr>
                  <tr>
                   <td width="200"></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td width="100" ><strong><?php echo $yaxisArrayVal; ?></strong></td>
                   <?php } ?>
	          </tr>
                  <tr>
                   <td><strong><?php echo __('Total Number of Monthly Consultations', true); ?></strong></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td align="center">
                     <?php 
                          if(@in_array($key, $filterDepartConsultDateArray)) { echo $filterDepartConsultCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
          <?php } ?>
  </table>

