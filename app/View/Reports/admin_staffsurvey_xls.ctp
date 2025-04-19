<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Staff_Survey_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
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
  <table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>
   <tr><td colspan="27" align="center"><h2><?php echo __("Staff Survey Report")." - ".$reportYear; ?></h2></td></tr>
          <tr>
           <td width='40%'></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                  <td height='30px' align='center' valign='middle' width='12%' colspan="2" ><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
		   <td style="text-align:center;" colspan="2"><strong><?php echo __('Total'); ?></strong></td>
           </tr>
          <tr>
           <td><strong><?php echo __('Questions'); ?></strong></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                  <td align="center"><?php echo __('Yes'); ?></td>
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


          

