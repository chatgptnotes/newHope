<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"IPD_Patient_Survey_Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
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
           $questions[1] = 'I was attended by doctor within 5 minutes of my arrival in the hospital?';
           $questions[2] = 'reception staff was polite,helpful and friendly with me?';
           $questions[3] = 'staff clearly explained to me the charges, estimates and biling procedures?';
           $questions[4] = 'all my queries were answered patiently by the staff at the desk?';
           $questions[5] = 'I had to wait for less than 15 minutes to get a room allocated?';
           $questions[6] = 'I got the room of my choice at the time of admission?';
           $questions[7] = 'the room was ready and clean before I enterd my room?';
           $questions[8] = 'I was explained about the facilities in the room by the nurse?';
           $questions[9] = 'I was seen by a doctor within 15 minutes of my arrival in my room?';
           $questions[10] = 'all the doubts/quaries were answered patiently by the doctor?';
           $questions[11] = 'the doctor explained to me the details of my procedure/diagnosis?';
           $questions[12] = 'I was seen by a doctor regularly during my stay?';
           $questions[13] = 'I was attended by a nurse within 15 minutes of my arrival in the room?';
           $questions[14] = 'I was given the medicine on the time by the nurse?';
           $questions[15] = 'I was informed by the nurse about my investigations ahead to me, time to time?';
           $questions[16] = 'I was attended by a nurse withinutton. 5 minutes of pressing the nurse call b?';
           $questions[17] = 'nurses were attentive, polite,respectful and friendly with me during my stay?';
           $questions[18] = 'I was satisfied with the clinical services received at ICU?';
           $questions[19] = 'I was satisfied with the support services received at ICU?';
           $questions[20] = 'I got my all investigation reports on time?';
           $questions[21] = 'House keeping staff was attentive ,polite,respectful and friendly with me?';
           $questions[22] = 'I was always provided prompt bed side assistance ?';
           $questions[23] = 'I was Transported safely by the staff for all investigation/procedures?';
           $questions[24] = 'During my stay all light fixtures and the fitting were in working condition?';
           $questions[25] = 'Linen provided to me during my stay was clean and spotless?';
           $questions[26] = 'My linen was changed and arranged neatly everyday?';
           $questions[27] = 'I was able to get my prescribe medecine from the hospital pharmacy?';
           $questions[28] = 'I was attended promptly and regularly by physiotherapist?';
           $questions[29] = 'The discharge process was completed in 2 hours?';
           $questions[30] = 'Overall I satisfied with the treatment received from the Hospital?';
           $questions[31] = 'I would recommend Hope Hospital to the others for their care?';
           $questions[32] = 'What do you like best about the hospital?';
           $questionArray = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20','21','22','23','24','25','26','27','28','29','30','31','32');
    ?>
  <table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>
   <tr><td colspan="79" align="center"><h2><?php echo __("IPD Patient Report")." - ".$reportYear; ?></h2></td></tr>
          <tr>
           <td width='40%'></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                  <td height='30px' align='center' valign='middle' width='20%' colspan="6" ><strong><?php echo $yaxisArrayVal; ?></strong></td>
           <?php } ?>
		          <td style="text-align:center;" colspan="6"><strong><?php echo __('Total'); ?></strong></td>
           </tr>
          <tr>
           <td><strong><?php echo __('Questions'); ?></strong></td>
           <?php foreach($yaxisArray as $key => $yaxisArrayVal) { ?>
                    <td  align="center"><strong><?php echo __('Strongly Agree'); ?></strong></td>
                    <td align="center"><strong><?php echo __('Agree'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('Neither Agree Nor Disagree'); ?></strong></td>
                    <td align="center"><strong><?php echo __('Disagree'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('Strongly Disagree'); ?></strong></td>
                    <td align="center"><strong><?php echo __('Not Applicable'); ?></strong></td>
           <?php } ?>
		        <td  align="center"><strong><?php echo __('Strongly Agree'); ?></strong></td>
                    <td align="center"><strong><?php echo __('Agree'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('Neither Agree Nor Disagree'); ?></strong></td>
                    <td align="center"><strong><?php echo __('Disagree'); ?></strong></td>
                    <td  align="center"><strong><?php echo __('Strongly Disagree'); ?></strong></td>
                    <td align="center"><strong><?php echo __('Not Applicable'); ?></strong></td>
           </tr>
         <?php 
                   for($i=1; $i <33; $i++) {
         ?>
	  <tr>
	     <td><?php echo $questions[$i]; ?></td>
	       <?php
		   $sarowsCount=0;
		   $arowsCount=0;
		   $nandrowsCount=0;
		   $drowsCount=0;
		   $sdrowsCount=0;
		   $narowsCount=0;
		foreach($yaxisArray as $key => $yaxisArrayVal) {
	       ?>
                    <td align="center" > 
                      <?php 
                         // for strong agree answer //
                         if(@in_array($i, $filterStAgreeQuestIdArray)) {
                           if(@in_array($key, array_keys($filterStAgreeAnsCountArray[$i]))) {
							   $sarowsCount += $filterStAgreeAnsCountArray[$i][$key];
                            echo $filterStAgreeAnsCountArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } else {
                            echo "0";
                         } 
                      ?>
                    </td>
                     <td align="center"> 
                      <?php 
                         // for  agree answer //
                         if(@in_array($i, $filterAgreeQuestIdArray)) {
                           if(@in_array($key, array_keys($filterAgreeAnsCountArray[$i]))) {
							   $arowsCount += $filterAgreeAnsCountArray[$i][$key];
		  
                            echo $filterAgreeAnsCountArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } else {
                            echo "0";
                         } 
                      ?>
                    </td>
                     <td align="center"> 
                      <?php 
                         // for neither agree nor disagree answer //
                         if(@in_array($i, $filterNandDateArray)) {
                           if(@in_array($key, array_keys($filterNandAnsCountArray[$i]))) {
							    $nandrowsCount += $filterNandAnsCountArray[$i][$key];
		  
                            echo $filterNandAnsCountArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } else {
                            echo "0";
                         } 
                      ?>
                    </td>
                    <td align="center"> 
                      <?php 
                         // for disagree answer //
                         if(@in_array($i, $filterDisgreeDateArray)) {
                           if(@in_array($key, array_keys($filterDisgreeAnsCountArray[$i]))) {
							    $drowsCount += $filterDisgreeAnsCountArray[$i][$key];
		   
                            echo $filterDisgreeAnsCountArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } else {
                            echo "0";
                         } 
                      ?>
                    </td>
                    <td align="center"> 
                      <?php 
                         // for strong disagree answer //
                         if(@in_array($i, $filterStdDateArray)) {
                           if(@in_array($key, array_keys($filterStdAnsCountArray[$i]))) {
							   $sdrowsCount += $filterStdAnsCountArray[$i][$key];
		  
                            echo $filterStdAnsCountArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } else {
                            echo "0";
                         } 
                      ?>
                    </td>
                     <td align="center"> 
                      <?php 
                         // for not applicable answer //
                         if(@in_array($i, $filterNaDateArray)) {
                           if(@in_array($key, array_keys($filterNaAnsCountArray[$i]))) {
							    $narowsCount += $filterNaAnsCountArray[$i][$key];
                            echo $filterNaAnsCountArray[$i][$key];
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
			  <td align="center"><?php echo $sarowsCount ?></td>
			  <td align="center"><?php echo $arowsCount ?></td>
			  <td align="center"><?php echo $nandrowsCount ?></td>
			  <td align="center"><?php echo $drowsCount ?></td>
			  <td align="center"><?php echo $sdrowsCount ?></td>
			  <td align="center"><?php echo $narowsCount ?></td>
			
          </tr>
         <?php } ?>
        </table>


          

