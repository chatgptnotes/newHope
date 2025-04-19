<div class="inner_title">
<h3><?php echo __('Hospital Associated Infections Cases', true); ?></h3>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'hospital_acquire_infections_reports','type'=>'post', 'id'=> 'datefilterfrm'));?>	
<table border="0"   cellpadding="0" cellspacing="0" width="500px" align="left">
	        <tr >				 
			
			<td   align="right" ><?php echo __('Year') ?> :</td>										
			<td class="row_format">											 
		    	<?php  
                                 $currentYear = date("Y");
                                 for($i=0;$i<=10;$i++) {
                                    $lastTenYear[$currentYear] = $currentYear;
                                    $currentYear--;
                                 }
		    		 echo    $this->Form->input(null, array('name' => 'reportYear', 'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'reportYear', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$lastTenYear, 'value' =>$reportYear));
		    	?>
		  	</td>
		 </tr>	
                 <tr >				 
			
			<td  align="right"><?php echo __('Month') ?> :</td>										
			<td class="row_format">											 
		    	<?php 
                                $monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December',);
		    		echo    $this->Form->input(null, array('name' => 'reportMonth', 'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'reportMonth', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$monthArray, 'empty'=> 'Select', 'value' =>$reportMonth));
		    	?>
		  	</td>
		 </tr>
                 <tr >				 
			
			<td  align="right"><?php echo __('Filter By') ?> :</td>										
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input(null, array('name' => 'reportType', 'class' => 'validate[required,custom[mandatory-select]]', 'options' => array('1' => 'Cases', '2' => 'Rate'), 'id' => 'reportType', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false, 'value' =>$reportType));
		    	?>
		  	</td>
		 </tr>	 
		  <tr>				 
			<td class="row_format" align="left" colspan="2" style="padding-left:155px;">
				<?php
					echo $this->Form->submit(__('Show Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
		
</table>	
 <?php echo $this->Form->end();?>
   <div>&nbsp;</div>    
     <div class="clr ht5"></div>
       <div style="float: right;border:none;" class="inner_title">
		   <?php if(empty($reportMonth)) { 
		                echo $this->Form->create('Reports',array('action'=>'hai_reports_chart','type'=>'post', 'id'=> 'showcharfrm', 'style'=> 'float:left;'));
				echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportType', 'value' =>$reportType));
				echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
				echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportMonth', 'value' =>$reportMonth));
		                echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				echo $this->Form->end();
		    } 
		               echo $this->Form->create('Reports',array('action'=>'hai_xlsreports','type'=>'post', 'id'=> 'haixlsfrm', 'style'=> 'float:left;'));
				echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportType', 'value' =>$reportType));
				echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
				echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportMonth', 'value' =>$reportMonth));
		                echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				echo $this->Form->end();
		   ?>		  
  	  </div> 
  
</div>  
<?php 
       // for daily reports
       if(!empty($reportMonth)) {
?>      
         <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th><?php echo __('Days', true); ?></th>
	   <th style="text-align:center;"><?php if($reportType == 2) echo __('SSI Rate', true); else echo __('SSI Cases', true); ?> </th>
	   <th style="text-align:center;"> <?php if($reportType == 2) echo __('VAP Rate', true); else echo __('VAP Cases', true); ?> </th>
           <th style="text-align:center;"> <?php if($reportType == 2) echo __('UTI Rate', true); else echo __('UTI Cases', true); ?> </th>
           <th style="text-align:center;"> <?php if($reportType == 2) echo __('BSI Rate', true); else echo __('BSI Cases', true); ?> </th>
	   <th style="text-align:center;"> <?php if($reportType == 2) echo __('Thrombophlebitis Rate', true); else echo __('Thrombophlebitis Cases', true); ?> </th>
	   <?php if($reportType == 1)  { ?><th style="text-align:center;"> <?php if($reportType == 2) echo __('Other Rate', true); else echo __('Other Cases', true); ?> </th><?php } ?>
           <?php if($reportType == 1)  { ?><th style="text-align:center;"> <?php echo __('Total HAI', true); ?> </th><?php } ?>
          </tr>
		  <?php 
		           
			   foreach($yaxisArray as $key => $yaxisArrayVal) {
		  ?>
		   <tr>
		    <td ><?php echo $yaxisArrayVal; ?></td>
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
             <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th></th>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <th style="text-align:center;"> <?php echo $yaxisArrayVal; ?> </th>
           <?php } ?>
           </tr>
	  <tr>
		<td><?php if($reportType == 2) echo __('SSI Rate', true); else echo __('SSI Cases', true); ?></td>   
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
		<td><?php if($reportType == 2) echo __('VAP Rate', true); else echo __('VAP Cases', true); ?></td>   
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
		<td><?php if($reportType == 2) echo __('UTI Rate', true); else echo __('UTI Cases', true); ?></td>   
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
		<td><?php if($reportType == 2) echo __('BSI Rate', true); else echo __('BSI Cases', true); ?></td>   
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
		<td><?php if($reportType == 2) echo __('Thrombophlebitis Rate', true); else echo __('Thrombophlebitis Cases', true); ?></td>   
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
		<td><?php echo __('Other Cases', true); ?></td>   
	  <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center"><?php if(in_array($key, $filterOtherDateArray)) { echo $filterOtherCountArray[$key]; } else { echo "0"; }?></td>
          <?php } ?>
          </tr>
          <?php } ?>
          <?php if($reportType == 1) { ?>
          <tr>
		<td><strong><?php echo __('Total HAI', true); ?></strong></td>   
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
         <?php } ?>
        </table>
         
        
 <?php } ?>
           
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>