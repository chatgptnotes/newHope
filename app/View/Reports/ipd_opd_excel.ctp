<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\" Time_Taken_For_Admission".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?><STYLE type='text/css'>
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
<table border='1' class='table_format'  cellpadding='0' cellspacing='0' width='100%' style='text-align:left;padding-top:50px;'>		
<tr class="row_title">
   <td colspan = "13" align="center"><h2> Time Taken For Admission</h2></td>
  </tr>
	  <tr class='row_title'> 
	       <td height='30px' align='center' valign='middle'><strong>Sr.No.</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Date of Reg.</strong></td>
		   <td height='30px' align='center' valign='middle'><strong><?php echo __("MRN")?></strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Patient Name</strong></td>		    
		   <td height='30px' align='center' valign='middle'><strong>Patient Type</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Com/Pvt</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Form Received</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Reg. Completed Time</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>Time Taken For Reg.</strong></td>
		  <!--  <td height='30px' align='center' valign='middle'><strong>Doctor Attend Time</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>St. of Nursing Assessment</strong></td>
		   <td height='30px' align='center' valign='middle'><strong>End of Nursing Assessment</strong></td> -->
		   
	 </tr>
 <?php  
 $toggle =0;
	  if(count($reports) > 0) {
	  	   $finalWaitingTime ='';
		   $finalremTime = '';
		   $i = 1;
		   $timeCount =0 ;
			foreach($reports as $pdfData){	
				$excelDataChanged= $pdfData['Patient'];	
				
				$waiting_time ='';
				$finalTime='';
				$timeTaken ='';
				if(!empty($excelDataChanged['form_received_on']) && !empty($excelDataChanged['form_completed_on'])){
				 		//$timeTaken = strtotime($excelDataChanged['create_time'])-strtotime($excelDataChanged['form_received_on']) ;
	 					$datetime1 = new DateTime($excelDataChanged['form_completed_on']);
						$datetime2 = new DateTime($excelDataChanged['form_received_on']);
						$interval = $datetime1->diff($datetime2);
						
						//EOF cal
						$timeDay 	= $interval->days;
						$timeDaySec = $timeDay*3600*24;
						$timeHr 	= $interval->h;
						$timeHrSec 	= $timeHr*3600;
						$timeMin 	= $interval->i;
						$timeMinSec = $timeMin*60;
						$timeSec 	= $interval->s;
						$timeSecSec = $interval->s  ;
					    $finalremTime +=  (int)$timeDaySec+(int)$timeHrSec+(int)$timeMinSec+(int)$timeSecSec;
						
						$finalTime =  $timeDay." days ".$timeHr." hours ".$timeMin." minutes ".$timeSec." seconds " ;
						
						
	  					$timeCount++ ;
	
					  
				} 
				 		
				if(!empty($excelDataChanged['doc_ini_assess_on']) && !empty($excelDataChanged['form_completed_on'])){
			   		 	//$waiting_time = strtotime($excelDataChanged['doc_ini_assess_on']) - strtotime($excelDataChanged['create_time'])  ;
			   		 	$datetime1 = new DateTime($excelDataChanged['doc_ini_assess_on']);
						$datetime2 = new DateTime($excelDataChanged['form_completed_on']);
						$interval = $datetime1->diff($datetime2);						
						//EOF cal
						$timeDay = $interval->days." day ";
						$timeHr = $interval->h." hr ";
						$timeMin = $interval->i." min ";
						$timeSec = $interval->s." sec ";
						$waiting_time =  $timeDay." ".$timeHr." ".$timeMin." ".$timeSec ;
				}
				 
				
						
						
				 $corporate ='';
	   			 if($excelDataChanged['credit_type_id']==1) $corporate = 'Corporate';
				 else if ($excelDataChanged['credit_type_id']==2) $corporate= 'Insurance';
	   		         $doc_ini_assess_on = isset($excelDataChanged['doc_ini_assess_on'])?$this->DateFormat->formatDate2Local($excelDataChanged['doc_ini_assess_on'],Configure::read('date_format'),true):'';
                     $nurse_assess_on =  isset($excelDataChanged['nurse_assess_on'])?$this->DateFormat->formatDate2Local($excelDataChanged['nurse_assess_on'],Configure::read('date_format')):"";
                     $nurse_assess_end_on =  isset($excelDataChanged['nurse_assess_end_on'])?$this->DateFormat->formatDate2Local($excelDataChanged['nurse_assess_end_on'],Configure::read('date_format')):"";
				 
?>
	<tr> 
	    <td align='center' height='17px'><?php echo $i; ?> </td>
	    <td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($excelDataChanged['form_received_on'],Configure::read('date_format'),false); ?></td>	 
		<td align='center' height='17px'><?php echo $excelDataChanged['admission_id']; ?> </td>
	    <td align='center' height='17px'><?php echo $pdfData['PatientInitial']['name']." ".$excelDataChanged['lookup_name']; ?> </td>
	    
	   	<td align='center' height='17px'><?php echo $excelDataChanged['admission_type']; ?> </td>
	   	<td align='center' height='17px'><?php echo/*  $corporate */ $pdfData['TariffStandard']['name'] ;?></td>
	   	<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($excelDataChanged['form_received_on'] ,Configure::read('date_format'),true); ?> </td>	   	
	   	<td align='center' height='17px'><?php echo $this->DateFormat->formatDate2Local($excelDataChanged['form_completed_on'] ,Configure::read('date_format'),true);  ?></td>
	   	<td align='center' height='17px'><?php echo $finalTime; ?> </td>	   	
	   <!-- 	<td align='center' height='17px'><?php echo $doc_ini_assess_on; ?> </td>
	   	<td align='center' height='17px'><?php echo $nurse_assess_on; ?> </td>
	   	<td align='center' height='17px'><?php echo $nurse_assess_end_on; ?> </td> -->
	   	
	 </tr>
					
<?php $i++;  }

				
			  $finalremTime =  $finalremTime /$timeCount ; 
			//BOF 
				$days = (int) ($finalremTime/86400);
				$finalremTime = $finalremTime-($days*86400);
				$hours = (int)($finalremTime/3600);
				$finalremTime = $finalremTime-($hours*3600);
				$minutes = (int)($finalremTime/60);
				$finalremTime =(int) $finalremTime-($minutes*60);
			//EOF			
			$avgtime = ($days>0)?$days."Days ":"0 Days " ;
			$avgtime .= ($hours>0)?$hours."hrs ":"0 Hrs " ; 
			$avgtime .= ($minutes>0)?$minutes."Minutes ":"0 Minutes " ;  	
			$avgtime .= ($finalremTime>0)?$finalremTime."Sec ":"0 sec " ;
	} else { ?>
		<tr>
			<td colspan = '13' align='center' height='30px'>No Record Found</td>
		</tr>
	 <?php } ?>
	<tr>
		<td height="30px" align="center" valign="middle" colspan="13"><strong>Average Time Taken for Admissions:</strong><?php echo $avgtime;?></td>									
		
	 </tr>
			   		  
</table>
