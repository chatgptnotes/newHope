<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"HAI_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
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
 <?php 
       // for daily reports
       if(!empty($reportMonth)) { 
?>      
         <table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>	
          <tr>
		   <td <?php if($reportType == 1)   echo 'colspan="8"'; else echo 'colspan="6"'; ?> align="center"><h2><?php echo __("Hospital Associated Infections Cases")." - ".$reportYear; ?></h2></td></tr>
           <td height='30px' align='center' valign='middle' width="25%"><strong><?php echo __('Days', true); ?></strong></td>
	       <td height='30px' align='center' valign='middle' width="15%"><strong><?php if($reportType == 2) echo __('SSI Rate', true); else echo __('SSI Cases', true); ?></strong></td>
	       <td height='30px' align='center' valign='middle' width="15%"><strong><?php if($reportType == 2) echo __('VAP Rate', true); else echo __('VAP Cases', true); ?></strong></td>
           <td height='30px' align='center' valign='middle' width="15%"><strong><?php if($reportType == 2) echo __('UTI Rate', true); else echo __('UTI Cases', true); ?></strong></td>
           <td height='30px' align='center' valign='middle' width="15%"><strong><?php if($reportType == 2) echo __('BSI Rate', true); else echo __('BSI Cases', true); ?></strong></td>
	       <td height='30px' align='center' valign='middle' width="15%"><strong><?php if($reportType == 2) echo __('Thrombophlebitis Rate', true); else echo __('Thrombophlebitis Cases', true); ?></strong></td>
	   <?php if($reportType == 1)  { ?><td height='30px' align='center' valign='middle' width="15%"><strong><?php if($reportType == 2) echo __('Other Rate', true); else echo __('Other Cases', true); ?></strong></td><?php } ?>
           <?php if($reportType == 1)  { ?><td height='30px' align='center' valign='middle' width="15%"><strong><?php echo __('Total HAI', true); ?></strong></td><?php } ?>
          </tr>
		  <?php 
		           
			   foreach($yaxisArray as $key => $yaxisArrayVal) {
		  ?>
		   <tr>
		    <td align="center"><?php echo $yaxisArrayVal; ?></td>
			<td align="center">
                         <?php
                              // reportType 1 is for cases otherwise rate
                              // ssi rate or ssi cases //
                              if($reportType == 2)  {
                                if(@in_array($key, $filterSsiDateArray) && @in_array($key, $filterSpDateArray)) {
                                   $ssiRate = ($filterSsiCountArray[$key]/$filterSpCountArray[$key])*100;
                                   echo $this->Number->toPercentage($ssiRate);
                                } else {
                                   echo "0%";
                                }
                              } else {
                                if(@in_array($key, $filterSsiDateArray)) { echo $filterSsiCountArray[$key]; } else { echo "0"; }
                              }
                         ?>
                        </td>
			<td align="center">
                         <?php 
                              // vap rate or vap cases //
                              if($reportType == 2)  {
                                if(@in_array($key, $filterVapDateArray) && @in_array($key, $filterMvDateArray)) {
                                   $vapRate = ($filterVapCountArray[$key]/$filterMvCountArray[$key])*100;
                                   echo $this->Number->toPercentage($vapRate);
                                }  else {
                                   echo "0%";
                                }
                              } else {
                                if(@in_array($key, $filterVapDateArray)) { echo $filterVapCountArray[$key]; } else { echo "0"; }
                              }
                         ?>
                        </td>
			<td align="center">
                         <?php 
                             // uti rate or uti cases //
                             if($reportType == 2)  {
                                if(@in_array($key, $filterUtiDateArray) && @in_array($key, $filterUcDateArray)) {
                                   $utiRate = ($filterUtiCountArray[$key]/$filterUcCountArray[$key])*100;
                                   echo $this->Number->toPercentage($utiRate);
                                }  else {
                                   echo "0%";
                                }
                              } else {
                                if(@in_array($key, $filterUtiDateArray)) { echo $filterUtiCountArray[$key]; } else { echo "0"; }
                              }
                         ?>
                        </td>
			<td align="center">
                         <?php 
                             // bsi rate or bsi cases //
                             if($reportType == 2)  {
                                if(@in_array($key, $filterBsiDateArray) && @in_array($key, $filterClDateArray)) {
                                   $bsiRate = ($filterBsiCountArray[$key]/$filterClCountArray[$key])*100;
                                   echo $this->Number->toPercentage($bsiRate);
                                }  else {
                                   echo "0%";
                                }
                              } else {
                                if(@in_array($key, $filterBsiDateArray)) { echo $filterBsiCountArray[$key]; } else { echo "0"; }
                              }
                             
                         ?>
                        </td>
			<td align="center">
                         <?php 
                             // thrombo rate or thrombo cases //
                             if($reportType == 2)  {
                                if(@in_array($key, $filterThromboDateArray) && @in_array($key, $filterPlDateArray)) {
                                   $thromboRate = ($filterThromboCountArray[$key]/$filterPlCountArray[$key])*100;
                                   echo $this->Number->toPercentage($thromboRate);
                                }  else {
                                   echo "0%";
                                }
                              } else {
                                if(@in_array($key, $filterThromboDateArray)) { echo $filterThromboCountArray[$key]; } else { echo "0"; }
                              }
                           
                         ?>
                        </td>
                        <?php if($reportType == 1)  { ?>
			<td align="center">
                         <?php if(@in_array($key, $filterOtherDateArray)) { echo $filterOtherCountArray[$key]; } else { echo "0"; }?>
                        </td>
                        <?php } ?>
                       <?php   
                                    // Total HAI //
                                   if($reportType == 1)  {
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
          <?php } ?>
         </table>
<?php  } else { ?>
         <table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>	
          <tr><td colspan="13" align="center"><h2><?php echo __("Hospital Associated Infections Cases")." - ".$reportYear; ?></h2></td></tr>
           <td width='20%'></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <td height='30px' align='center' valign='middle' width='12%'><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
           </tr>
	  <tr>
		<td height='30px' align='left' valign='middle'><strong><?php if($reportType == 2) echo __('SSI Rate', true); else echo __('SSI Cases', true); ?></td></strong></td>    
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                   <?php 
                        if($reportType == 2) {
                          if(@in_array($key, $filterSsiDateArray) && @in_array($key, $filterSpDateArray)) {
                           $ssiRate = ($filterSsiCountArray[$key]/$filterSpCountArray[$key])*100;
                           echo $this->Number->toPercentage($ssiRate);
                          } else {
                           echo "0%";
                          }
                        } else {
                         if(@in_array($key, $filterSsiDateArray)) { echo $filterSsiCountArray[$key]; } else { echo "0"; }
                        }
                   ?>
                </td>
          <?php } ?>
          </tr>
          <tr>
		<td height='30px' align='left' valign='middle'><strong><?php if($reportType == 2) echo __('VAP Rate', true); else echo __('VAP Cases', true); ?></td></strong></td>    
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td align="center">
                  <?php 
                        if($reportType == 2) {
                          if(@in_array($key, $filterVapDateArray) && @in_array($key, $filterMvDateArray)) {
                           $vapRate = ($filterVapCountArray[$key]/$filterMvCountArray[$key])*100;
                           echo $this->Number->toPercentage($vapRate);
                          } else {
                           echo "0%";
                          }
                        } else {
                         if(in_array($key, $filterVapDateArray)) { echo $filterVapCountArray[$key]; } else { echo "0"; }
                        }
                   ?>
                 </td>
          <?php } ?>
          </tr>
         <tr>
		<td height='30px' align='left' valign='middle'><strong><?php if($reportType == 2) echo __('UTI Rate', true); else echo __('UTI Cases', true); ?></td></strong></td>    
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                  <?php 
                        if($reportType == 2) {
                          if(@in_array($key, $filterUtiDateArray) && @in_array($key, $filterUcDateArray)) {
                           $utiRate = ($filterUtiCountArray[$key]/$filterUcCountArray[$key])*100;
                           echo $this->Number->toPercentage($utiRate);
                          } else {
                           echo "0%";
                          }
                        } else {
                         if(in_array($key, $filterUtiDateArray)) { echo $filterUtiCountArray[$key]; } else { echo "0"; }
                        }
                   ?>
                </td>
          <?php } ?>
          </tr>
          <tr>
		<td height='30px' align='left' valign='middle'><strong><?php if($reportType == 2) echo __('BSI Rate', true); else echo __('BSI Cases', true); ?></td></strong></td>    
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td align="center">
                   <?php 
                        if($reportType == 2) {
                          if(@in_array($key, $filterBsiDateArray) && @in_array($key, $filterClDateArray)) {
                           $bsiRate = ($filterBsiCountArray[$key]/$filterClCountArray[$key])*100;
                           echo $this->Number->toPercentage($bsiRate);
                          } else {
                           echo "0%";
                          }
                        } else {
                         if(in_array($key, $filterBsiDateArray)) { echo $filterBsiCountArray[$key]; } else { echo "0"; }
                        }
                   ?>
                  
                 </td>
          <?php } ?>
          </tr>
          <tr>
		<td height='30px' align='left' valign='middle'><strong><?php if($reportType == 2) echo __('Thrombophlebitis Rate', true); else echo __('Thrombophlebitis Cases', true); ?></td></strong></td>    
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                 <td align="center">
                  <?php 
                        if($reportType == 2) {
                          if(@in_array($key, $filterThromboDateArray) && @in_array($key, $filterPlDateArray)) {
                           $thromboRate = ($filterThromboCountArray[$key]/$filterPlCountArray[$key])*100;
                           echo $this->Number->toPercentage($thromboRate);
                          } else {
                           echo "0%";
                          }
                        } else {
                         if(in_array($key, $filterThromboDateArray)) { echo $filterThromboCountArray[$key]; } else { echo "0"; }
                        }
                   ?>
                  
                 </td>
          <?php } ?>
          </tr>
          <?php if($reportType == 1) { ?>
          <tr>
		<td height='30px' align='left' valign='middle'><strong><?php echo __('Other Cases', true); ?></td></strong></td>    
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center"><?php if(in_array($key, $filterOtherDateArray)) { echo $filterOtherCountArray[$key]; } else { echo "0"; }?></td>
          <?php } ?>
          </tr>
          <?php } ?>
          <?php if($reportType == 1) { ?>
          <tr>
		<td height='30px' align='left' valign='middle'><strong><?php echo __('Total HAI', true); ?></td></strong></td>    
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                     <?php    
                                    $totalCount = $filterSsiCountArray[$key] + $filterVapCountArray[$key] + $filterUtiCountArray[$key] + $filterBsiCountArray[$key] + $filterThromboCountArray[$key]+$filterOtherCountArray[$key];
                                    
                                    if($totalCount > 0) {
				      echo $totalCount;
				    } else { echo "0"; }
				    $totalCount = 0;
		    ?>
                </td>
          <?php } ?>
          </tr>
         <?php } ?>
        </table>
         
        
 <?php } ?>

