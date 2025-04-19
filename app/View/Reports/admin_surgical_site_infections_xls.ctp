<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Surgical_Site_Infections_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
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
   <table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>	
  <tr><td colspan="13" align="center"><h2><?php echo __("Surgical Site Infections Report")." - ".$reportYear; ?></h2></td></tr>
          <tr>
           <td width='40%'></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
            <td height='30px' align='center' valign='middle' width='12%'><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
           </tr>
	  <tr>
		<td height='30px' align='left' valign='middle'><strong><?php echo __('Total Number of Surgical Site Infections', true); ?></strong></td>
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                   <?php 
                         if(@in_array($key, $filterSsiDateArray)) { echo $filterSsiCountArray[$key]; } else { echo "0"; }
                   ?>
                </td>
          <?php } ?>
          </tr>
          <tr>
		<td height='30px' align='left' valign='middle'><strong><?php  echo __('Total Number of Surgical Procedure', true);  ?></strong></td> 
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td align="center">
                  <?php 
                         if(@in_array($key, $filterSpDateArray)) { echo $filterSpCountArray[$key]; } else { echo "0"; }
                   ?>
                 </td>
          <?php } ?>
          </tr>
         <tr>
		<td height='30px' align='left' valign='middle'><strong><?php  echo __('Surgical Site Infections Rate', true); ?></strong></td>
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                  <?php 
                        if(@in_array($key, $filterSsiDateArray) && @in_array($key, $filterSpDateArray)) {
                           $SsiRate = ($filterSsiCountArray[$key]/$filterSpCountArray[$key])*100;
                           echo $this->Number->toPercentage($SsiRate);
                          } else {
                           echo "0%";
                          }
                   ?>
                </td>
          <?php } ?>
          </tr>
        </table>

