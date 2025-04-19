<div class="inner_title">
<h3><?php echo __('Patient Summary With Cash/Card Type', true); ?></h3>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'patient_summary','type'=>'post', 'id'=> 'datefilterfrm'));?>	
<table border="0"   cellpadding="0" cellspacing="0" width="500px" >
	        <tr >				 
			
			<td align="right"><?php echo __('Year') ?> :</td>										
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
                 <tr>				 
			
			<td  align="right"><?php echo __('Month') ?> :</td>										
			<td class="row_format">											 
		    	<?php 
                                $monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December',);
		    		echo    $this->Form->input(null, array('name' => 'reportMonth', 'class' => 'validate[required,custom[mandatory-select]]', 'id' => 'reportMonth', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$monthArray, 'empty'=> 'Select', 'value' =>$reportMonth));
		    	?>
		  	</td>
		 </tr>
                 <tr>				 
			<td class="row_format" align="left" colspan="2" style="padding-left:130px;">
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
   <?php 
                        if(empty($reportMonth)) { 
                           echo $this->Form->create('Reports',array('action'=>'patient_summary_chart','type'=>'post', 'id'=> 'patientsummarychartfrm', 'style'=> 'float:left;'));
		           echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
                           echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		           echo $this->Form->end();
                        } 
                              
                        echo $this->Form->create('Reports',array('action'=>'patient_summary_xls','type'=>'post', 'id'=> 'patientsummaryxlsfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
                        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportMonth', 'value' =>$reportMonth));
                        echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
   ?>
  <div class="clr ht5"></div>
  </div> 
  
</div>  
   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <?php 
                 
                 // for daily reports
                 if(!empty($reportMonth)) {
          ?> 
          <tr>
           <td style="text-align:center;"><strong><?php echo __('Days', true); ?></strong></td>
	       <td style="text-align:center;"><strong><?php echo __('Total Number of IPD Patient With Cash Type', true); ?></strong></td>
           <td style="text-align:center;"><strong><?php echo __('Total Number of IPD Patient With Card Type', true); ?></strong></td>
           <td style="text-align:center;"><strong><?php echo __('Total Number of OPD Patient With Cash Type', true); ?></strong></td>
           <td style="text-align:center;"><strong><?php echo __('Total Number of OPD Patient With Card Type', true); ?></strong></td>
           <td style="text-align:center;"><strong><?php echo __('Total Number', true); ?></strong></td>
	  </tr>
           <?php
                  $totalNumber=0;
                 foreach($yaxisArray as $key => $yaxisArrayVal) { 
           ?>
             <tr>
             <td style="text-align:center;"><?php echo $yaxisArrayVal; ?></td>
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
           <?php $totalNumber = 0; } ?>
          <?php } else { ?>
                  <tr>
                   <td></td>
                   <?php $totalNumber= array();
                        foreach($yaxisArray as $key => $yaxisArrayVal) { 
                   ?>
                    <td><?php echo $yaxisArrayVal; ?></td>
                   <?php } ?>
	          </tr>
                  <tr>
                   <td><?php echo __('Total Number of IPD Patient With Cash Type', true); ?></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td>
                     <?php 
                          if(@in_array($key, $filterYearIPDCashDateArray)) { $totalNumber[$key] += $filterYearIPDCashCountArray[$key]; echo $filterYearIPDCashCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
                   <tr>
                   <td><?php echo __('Total Number of IPD Patient With Card Type', true); ?></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td>
                     <?php 
                          if(@in_array($key, $filterYearIPDCardDateArray)) { $totalNumber[$key] += $filterYearIPDCardCountArray[$key]; echo $filterYearIPDCardCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
                   <tr>
                   <td><?php echo __('Total Number of OPD Patient With Cash Type', true); ?></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td>
                     <?php 
                          if(@in_array($key, $filterYearOPDCashDateArray)) { $totalNumber[$key] += $filterYearOPDCashCountArray[$key]; echo $filterYearOPDCashCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   <?php } ?>
                  </tr>
                   <tr>
                   <td><?php echo __('Total Number of OPD Patient With Card Type', true); ?></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td>
                     <?php 
                          if(@in_array($key, $filterYearOPDCardDateArray)) { $totalNumber[$key] += $filterYearOPDCardCountArray[$key]; echo $filterYearOPDCardCountArray[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   
                   <?php } ?>
                  </tr>
                  <tr>
                   <td><strong><?php echo __('Total Number', true); ?></strong></td>
                   <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td>
                     <?php 
                          if(@array_key_exists($key, $totalNumber)) {  echo $totalNumber[$key]; } else { echo "0"; }
                     ?>
                    </td>
                   
                   <?php } ?>
                  </tr>
                  
          <?php } ?>
        </table>
           
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>