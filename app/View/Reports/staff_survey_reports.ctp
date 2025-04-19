<?php //echo $this->Html->css(array('jquery.timepicker','jquery.weekcalendar'));?>
<?php //echo $this->Html->script(array('FusionCharts')); ?>
<div class="inner_title">
<h3><?php echo __('Staff Survey Reports', true); ?></h3>
</div>
<!--<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">   	  
      <tr>
        <td width="49%" align="left" valign="top" style="padding-top:7px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <td width="100" height="25" valign="top" class="tdLabel1" id="boxSpace1">
                </td>
                <td align="left" valign="top">
                </td>
              </tr>
         </table>  
       </td>
      </tr>
    </table>-->
    <div>&nbsp;</div>    
     <div class="clr ht5"></div>
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
<div style="text-align: right;" class="inner_title">
   <?php 
    echo $this->Html->link(__('Generate Excel Report'), array('action' => 'staff_survey_xlsreports'), array('escape' => false,'class'=>'blueBtn'));
   ?>
</div>                   
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
						 <th><?php echo __('Sr.', true); ?></th>
						 <th><?php echo __('Questions', true); ?></th>
						 <th><?php echo __('Yes', true); ?></th>
                                                 <th><?php echo __('No', true); ?></th>
						</tr>
              <?php 
                   for($i=1; $i <20; $i++) {
              ?>
              <tr>
						 <td><?php echo $i; ?></td>
						 <td><?php echo $questions[$i]; ?></td>
						 <td>
                                                 <?php 
                                                   if(in_array($i, $yesQuestionIdArray)) 
                                                     //echo $this->Number->toPercentage((($yesResultArray[$i]*100)/$totalNumber));
                                                     echo $yesResultArray[$i];
                                                   else 
                                                     echo "0";
                                                 ?>
						 </td>
                                                 <td>
						  <?php 
                                                   if(in_array($i, $noQuestionIdArray)) 
                                                     //echo $this->Number->toPercentage((($noResultArray[$i]*100)/$totalNumber));
                                                     echo $noResultArray[$i];
                                                   else 
                                                     echo "0";
                                                 ?>
						 </td>
						</tr>
              <?php
                   }
              ?>
                   </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
   <div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_reports'),array('class'=>'blueBtn','div'=>false)); ?>
       </div>