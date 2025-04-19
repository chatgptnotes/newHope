<div class="inner_title">
<h3><?php echo __('ICU Utilisation Rate', true); ?></h3>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'icu_utilization_report','type'=>'post', 'id'=> 'icuutiratefrm'));?>	
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
 		  <tr >				 
			<td class="row_format" align="left" colspan="2" style="padding-left:145px;">
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
                echo $this->Form->create('Reports',array('action'=>'icu_utilization_report_chart','type'=>'post', 'id'=> 'icuutiratechartfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		        echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
    
                echo $this->Form->create('Reports',array('action'=>'icu_utilization_report_xls','type'=>'post', 'id'=> 'icuutiratexlsfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		        echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
   ?>
  <div class="clr ht5"></div>
  </div> 
  
</div>  
   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th></th>
           <?php  foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
           <th style="text-align:center;"><?php echo $yaxisArrayVal; ?></th>
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
           
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>