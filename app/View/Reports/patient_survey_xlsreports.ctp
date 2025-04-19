<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"PatientSurveyReports.xls" );
header ("Content-Description: Generated Report" );
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
<table>
                                
                   		<tr>
                                 <td><b><?php echo __('Sr.', true); ?></b></td>
                                 <td><b><?php echo __('Questions', true); ?></b></td>
                                 <td><b><?php echo __('Strongly Agree', true); ?></b></td>
                                 <td><b><?php echo __('Agree', true); ?></b></td>
                                 <td><b><?php echo __('Neither Agree Nor  Disagree', true); ?></b></td>
                                 <td><b><?php echo __('Disagree', true); ?></b></td>
                                 <td><b><?php echo __('Strongly Disagree', true); ?></b></td>
                                 <td><b><?php echo __('Not Applicable', true); ?></b></td>
				</tr>
              <?php 
                   for($i=1; $i <33; $i++) {
              ?>
              <tr>
						 <td><?php echo $i; ?></td>
						 <td><?php echo $questions[$i]; ?></td>
						 <td>
						  <?php 
                                                   if(in_array($i, $strongAgreeQuestionIdArray)) 
                                                     echo $this->Number->toPercentage((($strongAgreeResultArray[$i]*100)/$totalNumber));
                                                   else 
                                                     echo "0%";
                                                 ?>
						 </td>
                                                 <td>
						  <?php 
                                                   if(in_array($i, $agreeQuestionIdArray)) 
                                                     echo $this->Number->toPercentage((($agreeResultArray[$i]*100)/$totalNumber));
                                                   else 
                                                     echo "0%";
                                                 ?>
						 </td>
                                                 <td>
						  <?php 
                                                   if(in_array($i, $nandQuestionIdArray)) 
                                                     echo $this->Number->toPercentage((($nandResultArray[$i]*100)/$totalNumber));
                                                   else 
                                                     echo "0%";
                                                 ?>
						 </td>
                                                 <td>
						  <?php 
                                                   if(in_array($i, $disagreeQuestionIdArray)) 
                                                     echo $this->Number->toPercentage((($disagreeResultArray[$i]*100)/$totalNumber));
                                                   else 
                                                     echo "0%";
                                                 ?>
						 </td>
                                                 <td>
						  <?php 
                                                   if(in_array($i, $strongDisagreeQuestionIdArray)) 
                                                     echo $this->Number->toPercentage((($strongDisagreeResultArray[$i]*100)/$totalNumber));
                                                   else 
                                                     echo "0%";
                                                 ?>
						 </td>
                                                 <td>
						  <?php 
                                                   if(in_array($i, $naQuestionIdArray)) 
                                                     echo $this->Number->toPercentage((($naResultArray[$i]*100)/$totalNumber));
                                                   else 
                                                     echo "0%";
                                                 ?>
						 </td>
						</tr>
              <?php
                   }
              ?>
</table>

