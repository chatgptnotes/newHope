<div class="inner_title">
<h3><?php echo __('OPD Patient Survey Report', true); ?></h3>
</div>
<?php echo $this->Form->create('Reports',array('action'=>'opdpatientsurvey_reports','type'=>'post', 'id'=> 'datefilterfrm'));?>	
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
                        echo $this->Form->create('Reports',array('action'=>'opdpatientsurvey_chart','type'=>'post', 'id'=> 'showloschartfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		        echo $this->Form->submit(__('Show Graph'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
    
                        echo $this->Form->create('Reports',array('action'=>'opdpatientsurvey_xls','type'=>'post', 'id'=> 'losxlsfrm', 'style'=> 'float:left;'));
		        echo $this->Form->input(null, array('type' => 'hidden', 'name'=> 'reportYear', 'value' =>$reportYear));
		        echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
		        echo $this->Form->end();
   ?>
  <div class="clr ht5"></div>
  </div> 
  <?php 
           $questions[1] = 'The cleanliness and comfort in the waiting area met my expectation?';
           $questions[2] = 'Toilets were clean and well maintained?';
           $questions[3] = 'All my doubts were answered by reception staff?';
           $questions[4] = 'Staff ensured that privacy of my information was maintained?';
           $questions[5] = 'I was seen at the appointment time by the doctor?';
           $questions[6] = 'I was guided for the doctor\'s consulation?';
           $questions[7] = 'I was taken in for my investigation at the appointed time?';
           $questions[8] = 'I was well informed about the procedure?';
           $questions[9] = 'I was informed about collecting report days and timing?';
           $questions[10] = 'Billing procedure was completed in 5 minute?';
           $questions[11] = 'I received my investigation reports at the scheduled time?';
           $questions[12] = 'I was able to get all the medicine in th Hospital pharmacy prescribed by the doctor?';
           $questions[13] = 'Reception Staff was polite,respectful and friendly with me?';
           $questions[14] = 'I was able to find my way to the investigation room easily?';
           $questions[15] = 'My personal privacy was maintained during  investigation?';
           $questions[16] = 'I was given full attention by the doctor?';
           $questions[17] = 'All my querries were answered by the doctor?';
           $questions[18] = 'I would recommend this hospital to others?';
           $questions[19] = 'Overall I am satisfied with the OPD services received in Hope Hospital?';
           $questionArray = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19');
           $cleanlinessQid = array('1', '2');
           $serviceQid = array('3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
           $satisfactionQid = array('13', '14', '15', '16', '17');
           $recommendationQid = array('18', '19');
    ?>
</div>  
   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
          <tr>
           <td></td>
           <td></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                  <td style="text-align:center;" colspan="7"><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
		          <td style="text-align:center;" colspan="7"><strong><?php echo __('Total'); ?></strong></td>
           </tr>
          <tr>
           <td><strong><?php echo __('Parameters'); ?></strong></td>
           <td><strong><?php echo __('Questions'); ?></strong></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td  align="center"><strong><?php echo __('Strongly Agree'); ?></strong></td>
                    <td align="center"><strong><?php echo __('Agree'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('Neither Agree Nor Disagree'); ?></strong></td>
                    <td align="center"><strong><?php echo __('Disagree'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('Strongly Disagree'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('Total Score'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('% to Highest Score (70*5)'); ?></strong></td>
           <?php } ?>
		            <td  align="center"><strong><?php echo __('Strongly Agree'); ?></strong></td>
                    <td align="center"><strong><?php echo __('Agree'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('Neither Agree Nor Disagree'); ?></strong></td>
                    <td align="center"><strong><?php echo __('Disagree'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('Strongly Disagree'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('Total Score'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('% to Highest Score (70*5)'); ?></strong></td>
		  
           </tr>
         <?php 
                  $cleanlinessShow=0;
                  $serviceShow=0;
                  $satisfactionShow=0;
                  $recommendationShow=0;
                  // for calculating total score //
                  $totalScore=0; 
                  $totalStrongAgree = 0;
                  $totalAgree = 0;
                  $totalNand = 0;
                  $totalDisagree = 0;
                  $totalStDisagree = 0;
                  $highestCent = 0;
				  // for total at the end of year //
				  $saRowsCount = 0;
				  $aRowsCount = 0;
				  $nandRowsCount = 0;
				  $dRowsCount = 0;
				  $sdRowsCount = 0;
				  $tsRowsCount = 0;
				  $hsRowsCount = 0;

                   for($i=1; $i <20; $i++) {
         ?>
	  <tr>
             <?php if($cleanlinessShow == 0) { ?>
		<?php if(in_array($i, $cleanlinessQid)) { $cleanlinessShow++;?>
		<td rowspan="2"><?php echo __('Cleanliness'); ?></td>
		<?php } ?>
             <?php } ?>
             <?php if($serviceShow == 0) { ?>
		<?php  if(in_array($i, $serviceQid)) {  $serviceShow++;?>
		<td rowspan="10"><?php echo __('Service'); ?></td>
		<?php } ?>
             <?php } ?>
             <?php if($satisfactionShow == 0) { ?>
		<?php  if(in_array($i, $satisfactionQid)) {  $satisfactionShow++; ?>
		<td rowspan="5"><?php echo __('Satisfaction'); ?></td>
		<?php } ?>
             <?php } ?>
            <?php if($recommendationShow == 0) { ?>
		<?php  if(in_array($i, $recommendationQid)) {  $recommendationShow++;?>
		<td rowspan="2"><?php echo __('Recommendation'); ?></td>
		<?php } ?>
            <?php } ?>
	     <td><?php echo $questions[$i]; ?></td>
	       <?php 
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	       ?>
                    <td align="center"> 
                      <?php 
                         // for strong agree answer plus cleanliness parameter //
                         if(@in_array($i, $stAgreeQuestIdCleanArray)) {
                           if(@in_array($key, array_keys($stAgreeAnsCountCleanArray[$i]))) {
							   $totalStrongAgree = $stAgreeAnsCountCleanArray[$i][$key]*5;
							   $saRowsCount += $stAgreeAnsCountCleanArray[$i][$key];
							  				  
                               echo $stAgreeAnsCountCleanArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for strong agree answer plus service parameter //
                         elseif(@in_array($i, $stAgreeQuestIdServiceArray)) {
                           if(@in_array($key, array_keys($stAgreeAnsCountServiceArray[$i]))) {
                            $totalStrongAgree = $stAgreeAnsCountServiceArray[$i][$key]*5;
							$saRowsCount += $stAgreeAnsCountServiceArray[$i][$key];

							 echo $stAgreeAnsCountServiceArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for strong agree answer plus satisfaction parameter //
                         elseif(@in_array($i, $stAgreeQuestIdSatisArray)) {
                           if(@in_array($key, array_keys($stAgreeAnsCountSatisArray[$i]))) {
                             $totalStrongAgree = $stAgreeAnsCountSatisArray[$i][$key]*5;
							 $saRowsCount += $stAgreeAnsCountSatisArray[$i][$key];
                             echo $stAgreeAnsCountSatisArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for strong agree answer plus recommendation parameter //
                         elseif(@in_array($i, $stAgreeQuestIdRecomArray)) {
                           if(@in_array($key, array_keys($stAgreeAnsCountRecomArray[$i]))) {
                            $totalStrongAgree = $stAgreeAnsCountRecomArray[$i][$key]*5;
							$saRowsCount += $stAgreeAnsCountRecomArray[$i][$key];
                            echo $stAgreeAnsCountRecomArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         else {
                            echo "0";
                         } 
                      ?>
                    </td>
                     <td align="center"> 
                      <?php 
                         // for  agree answer plus cleanliness parameter//
                         if(@in_array($i, $agreeQuestIdCleanArray)) {
                           if(@in_array($key, array_keys($agreeAnsCountCleanArray[$i]))) {
                            $totalAgree = $agreeAnsCountCleanArray[$i][$key]*4;
							$aRowsCount += $agreeAnsCountCleanArray[$i][$key];
                            echo $agreeAnsCountCleanArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for agree answer plus service parameter //
                         elseif(@in_array($i, $agreeQuestIdServiceArray)) {
                           if(@in_array($key, array_keys($agreeAnsCountServiceArray[$i]))) {
                            $totalAgree = $agreeAnsCountServiceArray[$i][$key]*4;
							$aRowsCount += $agreeAnsCountServiceArray[$i][$key];
                            echo $agreeAnsCountServiceArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for agree answer plus satisfaction parameter //
                         elseif(@in_array($i, $agreeQuestIdSatisArray)) {
                           if(@in_array($key, array_keys($agreeAnsCountSatisArray[$i]))) {
                            $totalAgree = $agreeAnsCountSatisArray[$i][$key]*4;
							$aRowsCount += $agreeAnsCountSatisArray[$i][$key];
                            echo $agreeAnsCountSatisArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for  agree answer plus recommendation parameter //
                         elseif(@in_array($i, $agreeQuestIdRecomArray)) {
                           if(@in_array($key, array_keys($agreeAnsCountRecomArray[$i]))) {
                            $totalAgree = $agreeAnsCountRecomArray[$i][$key]*4;
							$aRowsCount += $agreeAnsCountRecomArray[$i][$key];
                            echo $agreeAnsCountRecomArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } 
                         else {
                            echo "0";
                         } 
                      ?>
                    </td>
                     <td align="center"> 
                      <?php 
                         // for neither agree nor disagree answer plus cleanliness //
                         if(@in_array($i, $nandQuestIdCleanArray)) {
                           if(@in_array($key, array_keys($nandAnsCountCleanArray[$i]))) {
                            $totalNand = $nandAnsCountCleanArray[$i][$key]*3;
							$nandRowsCount += $nandAnsCountCleanArray[$i][$key];
                            echo $nandAnsCountCleanArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } 
                         // for neither agree nor disagree answer plus service parameter //
                         elseif(@in_array($i, $nandQuestIdServiceArray)) {
                           if(@in_array($key, array_keys($nandAnsCountServiceArray[$i]))) {
                            $totalNand = $nandAnsCountServiceArray[$i][$key]*3;
							$nandRowsCount += $nandAnsCountServiceArray[$i][$key];
                            echo $nandAnsCountServiceArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for neither agree nor disagree answer plus satisfaction parameter //
                         elseif(@in_array($i, $nandQuestIdSatisArray)) {
                           if(@in_array($key, array_keys($nandAnsCountSatisArray[$i]))) {
                            $totalNand = $nandAnsCountSatisArray[$i][$key]*3;
							$nandRowsCount += $nandAnsCountSatisArray[$i][$key];
                            echo $nandAnsCountSatisArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for neither agree nor disagree plus recommendation parameter //
                         elseif(@in_array($i, $nandQuestIdRecomArray)) {
                           if(@in_array($key, array_keys($nandAnsCountRecomArray[$i]))) {
                            $totalNand = $nandAnsCountRecomArray[$i][$key]*3;
							$nandRowsCount += $nandAnsCountRecomArray[$i][$key];
                            echo $nandAnsCountRecomArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } 
                         else {
                            echo "0";
                         } 
                      ?>
                    </td>
                    <td align="center"> 
                      <?php 
                         // for disagree answer plus cleanliness//
                         if(@in_array($i, $disgreeQuestIdCleanArray)) {
                           if(@in_array($key, array_keys($disgreeAnsCountCleanArray[$i]))) {
                            $totalDisagree = $disgreeAnsCountCleanArray[$i][$key]*2;
							$dRowsCount  += $disgreeAnsCountCleanArray[$i][$key];
                            echo $disgreeAnsCountCleanArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } 
                         // for strong agree answer plus service parameter //
                         elseif(@in_array($i, $disgreeQuestIdServiceArray)) {
                           if(@in_array($key, array_keys($disgreeAnsCountServiceArray[$i]))) {
                            $totalDisagree = $disgreeAnsCountServiceArray[$i][$key]*2;
							$dRowsCount  += $disgreeAnsCountServiceArray[$i][$key];
                            echo $disgreeAnsCountServiceArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for strong agree answer plus satisfaction parameter //
                         elseif(@in_array($i, $disgreeQuestIdSatisArray)) {
                           if(@in_array($key, array_keys($disgreeAnsCountSatisArray[$i]))) {
                            $totalDisagree = $disgreeAnsCountSatisArray[$i][$key]*2;
							$dRowsCount  += $disgreeAnsCountSatisArray[$i][$key];
                            echo $disgreeAnsCountSatisArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for strong agree answer plus recommendation parameter //
                         elseif(@in_array($i, $disgreeQuestIdRecomArray)) {
                           if(@in_array($key, array_keys($disgreeAnsCountRecomArray[$i]))) {
                            $totalDisagree = $disgreeAnsCountRecomArray[$i][$key]*2;
							$dRowsCount  += $disgreeAnsCountRecomArray[$i][$key];
                            echo $disgreeAnsCountRecomArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } 
                         else {
                            echo "0";
                         } 
                      ?>
                    </td>
                    <td align="center"> 
                      <?php 
                         // for strong disagree answer plus cleanliness//
                         if(@in_array($i, $stdQuestIdCleanArray)) {
                           if(@in_array($key, array_keys($stdAnsCountCleanArray[$i]))) {
                            $totalStDisagree = $stdAnsCountCleanArray[$i][$key]*1;
							$sdRowsCount  += $stdAnsCountCleanArray[$i][$key];
                            echo $stdAnsCountCleanArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } 
                         // for strong disagree answer plus service parameter //
                         elseif(@in_array($i, $stdQuestIdServiceArray)) {
                           if(@in_array($key, array_keys($stdAnsCountServiceArray[$i]))) {
                            $totalStDisagree = $stdAnsCountServiceArray[$i][$key]*1;
							$sdRowsCount  += $stdAnsCountServiceArray[$i][$key];
                            echo $stdAnsCountServiceArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for strong disagree answer plus satisfaction parameter //
                         elseif(@in_array($i, $stdQuestIdSatisArray)) {
                           if(@in_array($key, array_keys($stdAnsCountSatisArray[$i]))) {
                            $totalStDisagree = $stdAnsCountSatisArray[$i][$key]*1;
							$sdRowsCount  += $stdAnsCountSatisArray[$i][$key];
                            echo $stdAnsCountSatisArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         }
                         // for strong disagree answer plus recommendation parameter //
                         elseif(@in_array($i, $stdQuestIdRecomArray)) {
                           if(@in_array($key, array_keys($stdAnsCountRecomArray[$i]))) {
                            $totalStDisagree = $stdAnsCountRecomArray[$i][$key]*1;
							$sdRowsCount  += $stdAnsCountRecomArray[$i][$key];
                            echo $stdAnsCountRecomArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } 
                         else {
                            echo "0";
                         } 
                      ?>
                    </td>
                    <td align="center">
                     <?php 
                           $totalScore = ($totalStrongAgree + $totalAgree + $totalNand + $totalDisagree + $totalStDisagree);
					       $tsRowsCount  += $totalScore;
                           echo $totalScore;
                      ?>
                    </td>
                    <td align="center">
                     <?php 
                         $highestCent = ($totalScore/(70*5))*100;  
					     $hsRowsCount   += $highestCent;
                         echo $this->Number->toPercentage($highestCent);
                     ?>
                    </td>  
             <?php
                  $totalScore=0; 
                  $totalStrongAgree = 0;
                  $totalAgree = 0;
                  $totalNand = 0;
                  $totalDisagree = 0;
                  $totalStDisagree = 0;
                  $highestCent = 0;
                } 
             ?>
			<td align="center"><?php echo $saRowsCount; ?> </td>
			<td align="center"><?php echo $aRowsCount ; ?> </td>
			<td align="center"><?php echo $nandRowsCount ; ?> </td>
			<td align="center"><?php echo $dRowsCount ; ?> </td>
			<td align="center"><?php echo $sdRowsCount ; ?> </td>
			<td align="center"><?php echo $tsRowsCount ; ?> </td>
			<td align="center"><?php echo $this->Number->toPercentage($hsRowsCount); ?> </td>

          </tr>
         <?php } ?>

        </table>
           
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'patient_survey_type', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>