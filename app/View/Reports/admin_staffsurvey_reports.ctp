<div class="inner_title">
<h3><?php echo __('Staff Survey Report', true); ?></h3>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'staffsurvey_reports','type'=>'post', 'id'=> 'datefilterfrm'));?>	
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
                        echo $this->Form->create('Reports',array('action'=>'staffsurvey_chart','type'=>'post', 'id'=> 'showloschartfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		        echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
    
                        echo $this->Form->create('Reports',array('action'=>'staffsurvey_xls','type'=>'post', 'id'=> 'losxlsfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		        echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
   ?>
  <div class="clr ht5"></div>
  </div> 
  <?php 
           $questions[1] = 'Safe At Work?';
           $questions[2] = 'We Work Well Together?';
           $questions[3] = 'Opportunity To Participate?';
           $questions[4] = 'Chance To Be Creative?';
           $questions[5] = 'Kept Informed?';
           $questions[6] = 'Satisfied With Workload?';
           $questions[7] = 'Given Tools To Do The Job?';
           $questions[8] = 'Chance To Move Up?';
           $questions[9] = 'Chance For Education & Training?';
           $questions[10] = 'Recognized For My Service?';
           $questions[11] = 'Get The Training I Need?';
           $questions[12] = 'Happy With My Work Hours?';
           $questions[13] = 'I Understand What is Expected?';
           $questions[14] = 'Paid Based On Responsibility?';
           $questions[15] = 'Comfortable With Level of Job Security?';
           $questions[16] = 'Satisfied With benefits?';
           $questions[17] = 'Chance To Help Make Decisions?';
           $questions[18] = 'Boss Treats Me Fairly?';
           $questions[19] = 'Satisfied With My Job?';
           $questionArray = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19');
    ?>
</div>  
   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <th></th>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                  <th style="text-align:center;" colspan="2"><?php echo $yaxisArrayVal; ?></th>
           <?php } ?>
		   <th style="text-align:center;" colspan="2"><?php echo __('Total'); ?></th>
           </tr>
          <tr>
           <td><strong><?php echo __('Questions'); ?></strong></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td  align="center"><?php echo __('Yes'); ?></td>
                    <td align="center"><?php echo __('No'); ?></td>
          <?php } ?>
		  <td  align="center"><?php echo __('Yes'); ?></td>
                    <td align="center"><?php echo __('No'); ?></td>
           </tr>
         <?php 
                   for($i=1; $i <20; $i++) {
         ?>
	  <tr>
	     <td><?php echo $questions[$i]; ?></td>
	       <?php 
		   $countYesRows=0;
		   $countNoRows=0;
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	       ?>
                    <td align="center"> 
                      <?php 
                         // for yes count answer //
                         if(@in_array($i, $filterYesAnsQuestIdArray)) {
                           if(@in_array($key, array_keys($filterYesAnsCountArray[$i]))) {
							 $countYesRows +=   $filterYesAnsCountArray[$i][$key];
                            echo $filterYesAnsCountArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } else {
                            echo "0";
                         } 
                      ?>
                    </td>
                    <td align="center">
                     <?php // for no count answer //
                         if(@in_array($i, $filterNoAnsQuestIdArray)) {
                           if(@in_array($key, array_keys($filterNoAnsCountArray[$i]))) {
							   $countNoRows +=   $filterNoAnsCountArray[$i][$key];
                            echo $filterNoAnsCountArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } else {
                            echo "0";
                         } 
                      ?>
                    </td>
                   
                
             <?php 
                } 
             ?>
            <td align="center"><?php echo $countYesRows;?></td>
			<td align="center"><?php echo $countNoRows;?></td>
          </tr>
         <?php } ?>
        </table>
           
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>