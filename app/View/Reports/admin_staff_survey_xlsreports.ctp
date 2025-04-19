<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"StaffSurveyReports.xls" );
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
<tr><td colspan="4"  align="center"><h3><?php echo __("Staff Survey Reports"); ?></h3></td></tr>
<tr class='row_title'>
   <td height='30px' align='center' valign='middle' width='5%'><strong><?php echo __('Sr.', true); ?></strong></td>
   <td height='30px' align='left' valign='middle' width='75%' ><strong><?php echo __('Questions', true); ?></strong></td>
   <td height='30px' align='center' valign='middle' width='10%'><strong><?php echo __('Yes', true); ?></strong></td>
   <td height='30px' align='center' valign='middle' width='10%'><strong><?php echo __('No', true); ?></strong></td>
  </tr>
  <?php 
      for($i=1; $i <20; $i++) {
  ?>
  <tr>
   <td align="center" height="17px" ><?php echo $i; ?></td>
   <td align="left" height="17px" ><?php echo $questions[$i]; ?></td>
   <td align="center" height="17px" >
    <?php 
       if(in_array($i, $yesQuestionIdArray)) 
         echo $this->Number->toPercentage((($yesResultArray[$i]*100)/($yesResultArray[$i]+$noResultArray[$i])));
         //echo $yesResultArray[$i];
       else 
          echo "0";
    ?>
   </td>
   <td align="center" height="17px" >
    <?php 
        if(in_array($i, $noQuestionIdArray)) 
          echo $this->Number->toPercentage((($noResultArray[$i]*100)/($yesResultArray[$i]+$noResultArray[$i])));
          //echo $noResultArray[$i];
        else 
           echo "0";
    ?>
    </td>
   </tr>
   <?php
     }
   ?>
</table>

