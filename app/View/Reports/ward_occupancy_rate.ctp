<?php #pr($yaxisArray);exit; ?>


<div class="inner_title">
<h3><?php echo __('Bed Occupancy Report', true); ?></h3>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'ward_occupancy_rate','type'=>'post', 'id'=> 'datefilterfrm'));?>	
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="500px" >
	        <tr class="row_title">				 
			
			<td class="row_format" align="right"><?php echo __('Year') ?> :</td>										
			<td class="row_format"  width="35%" align="left">											 
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
 		  <tr class="row_title">				 
			<td class="row_format" align="right" colspan="2" style="padding-right:60px;">
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
   <?php        if(empty($reportMonth)) {
                echo $this->Form->create('Reports',array('action'=>'ward_occupancy_rate_chart','type'=>'post', 'id'=> 'showloschartfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportMonth', 'value' =>$reportMonth));
		        echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
                }
                echo $this->Form->create('Reports',array('action'=>'ward_occupancy_rate_xls','type'=>'post', 'id'=> 'losxlsfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportMonth', 'value' =>$reportMonth));
		        echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
   ?>
  <div class="clr ht5"></div>
  </div> 
</div>  
<?php 
       // for daily reports
       if(!empty($reportMonth)) {
?>      
         <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <td style="text-align:center;"><strong><?php echo __('Days', true); ?></strong></td>
	       <td style="text-align:center;"><strong><?php  echo __('Total Number of Inpatient Days', true);  ?></strong></td>
	       <td style="text-align:center;"><strong><?php  echo __('Total Number of Available Bed Days', true);  ?></strong></td>
           <td style="text-align:center;"><strong><?php  echo __('Occupancy Rate', true);  ?></strong></td>
          </tr>
		  <?php 
		       // print_r($filterIpdCountArray);exit;
		        foreach($yaxisArray as $key => $yaxisArrayVal) { //debug($filterIpdCountArray);exit;
		  ?>
		   <tr>
		    <td align="center"><?php echo $yaxisArrayVal; ?></td>
		    <td align="center"><?php if(!empty($filterIpdCountArray[$key])) echo $filterIpdCountArray[$key];
		  //if(@in_array($key, $filterIpdDateArray)) {  echo $filterIpdCountArray[$key]; } ?></td>
		    <td align="center"><?php if($totalBed >0) {  echo $totalBed ; } ?></td>
			<td align="center">
                         <?php //debug(@array_key_exists($key, $filterIpdCountArray));debug($filterIpdCountArray);
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
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th></th>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <th style="text-align:center;"><?php echo $yaxisArrayVal; ?></th>
           <?php } ?>
           </tr>
           
           <tr>
          <td>Total Number of Inpatient Days</td>
          
           <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                   <?php 
                         if(@in_array($key, $filterIpdDateArray)) { echo $filterIpdCountArray[$key]; } else { echo "0"; }
                   ?>
                </td>
          <?php } ?>
           
           </tr>
           
           
           <tr>
          <td>Total Number of Available Bed Days</td> 
          
           <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
                     $month = date("m", strtotime($key));
                     $year = date("Y", strtotime($key));
                     $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	  ?>
                <td align="center">
                   <?php 
                         
                           //if(@in_array($key, $filterWardArray)) { 
                            //  if($year == date("Y")) {
                            //   echo $filterWardCountArray[$key]*(date("d")-1); 
                             // }else {
                             //  echo $filterWardCountArray[$key]*$numberOfDays;
                            //  }
                           //} else { echo "0"; }
                            if(strtotime($key) <= strtotime(date("F-Y"))) {
	                           if($totalBed) {//debug($numberOfDays);
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
          <td><strong>Occupancy Rate</strong></td> 
          
           <?php #pr($yaxisArray);
           
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	  ?>
                <td align="center">
                   <?php 
                  		#$filterWardCountArray[$key]=4;
                        // if(@in_array($key, $filterWardArray) && @in_array($key, $filterIpdDateArray)) { 
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
                         	
                         } else { 
                         	echo "0%"; 
                         }
                   ?>
                </td>
          <?php } ?>
           
           </tr>
           
	  </table>
<?php } ?>
	  <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>