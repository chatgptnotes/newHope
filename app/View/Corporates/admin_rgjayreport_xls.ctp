<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
//header ("Content-Disposition: attachment; filename=\"TOR_report_".date('d-m-Y').".xls");
header ("Content-Disposition: attachment; filename=\"RGJAY_Patient_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: RGJAY Report" );
?>

<STYLE type='text/css'>
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
	  <tr class='row_title'> 
		   <td colspan="13" width="100%" height='30px' align='center' valign='middle'><h2><?php echo __('RGJAY Patient Report'); ?></h2></td>
	  </tr>
	  				  
	  <tr class='row_title'> 
	  	<td height="30px" align="center" valign="center" width="1%" style="text-align:center;"><strong>No.</strong></td>
	  	<td height="30px" align='center' valign='middle' width="1%"><strong>Name /<br>Case.No /<br>Hosp.No /<br>Asgn.To</strong></td>
	  	<!--<td height='30px' align='center' valign='middle' width="7%"><strong>Hospital No</strong></td>
		<td height='30px' align='center' valign='middle' width="7%"><strong>Patient Name</strong></td>-->
		<td height="30px" align='center' valign='middle' width="7%"><strong>Procedure Name</strong></td>
		<td height="30px" align='center' valign='middle' width="7%"><strong>Adm.Dt/<br>Pack.Dt</strong></td>					   
		<!--<td align='center' valign='middle' width="7%"><strong>Package Dt</strong></td>-->
		<td height="30px" align='center' valign='middle' width="7%"><strong>No.Days</strong></td>  
		<td height="30px" align='center' valign='middle' width="7%"><strong>Extension</strong></td>	
		<td height="30px" align='center' valign='middle' width="7%"><strong>Pck Amt</strong></td>					   
		<td height="30px" align='center' valign='middle' width="7%"><strong>Enroll</strong></td>
		<td height="30px" align='center' valign='middle' width="7%"><strong>Preauth Send/Approved</strong></td>
		<td height="30px" align='center' valign='middle' width="7%"><strong>Surgery Pending/Done</strong></td>
		<td height="30px" align='center' valign='middle' width="7%"><strong>Surgery Update</strong></td>
		<td height="30px" align='center' valign='middle' width="7%"><strong>Post of Notes Update</strong></td>
		<td height="30px" align='center' valign='middle' width="7%"><strong>Disch.Dt/Disch.Upd</strong></td>
		<!--<td height="30px" align='center' valign='middle' width="7%"><strong>Discharge Upd</strong></td>  -->
		<td height="30px" align='center' valign='middle' width="7%"><strong>Bill.Dt/ Days/ Bill Upl.Dt</strong></td>
		<!--<td height="30px" align='center' valign='middle' width="7%"><strong>No.days</strong></td>					   
		<td height="30px" align='center' valign='middle' width="7%"><strong>BillUpl Dt</strong></td>-->
		<td height="30px" align='center' valign='middle' width="7%"><strong>Claim.Dt/Pend.Dt</strong></td>  
		<!--<td height="30px" align='center' valign='middle' width="7%"><strong>Pending Days</strong></td>					   -->
		<td height="30px" align='center' valign='middle' width="7%"><strong>CMO.Dt/Pend. Days</strong></td>
		<!--<td height="30px" align='center' valign='middle' width="7%"><strong>Pending Days</strong></td>  -->
		<td height="30px" align='center' valign='middle' width="7%"><strong>Remark</strong></td>					   
		<td height="30px" align='center' valign='middle' width="7%"><strong>Status</strong></td>
		<!--<td height='30px' align='center' valign='middle' width="7%"><strong>Team</strong></td>  -->
	</tr>
 	  
		<?php $curnt_date = date("Y-m-d");	//for current date
              $i=0;       	
		foreach($results as $key=>$result) 
		{ 
			$patient_id = $result['Patient']['id']; 	//holds the id of patient
			$bill_id = $result['FinalBilling']['id'];	//holds the bill id of patient
			$i++ ; ?>
				              	
	<tr>   
		<td>
			<?php echo $i; ?>
		</td>  
		<td align="center">
			<?php 
				echo $result['Patient']['lookup_name'].
				"<br>".
				$result['Patient']['case_no'].
				",".
		        $result['Patient']['hospital_no'].
		        ",".
		        $result['Patient']['assigned_to'].
		        "<br>".
		        $result['Person']['district']; 
		     ?>
		</td>
		
		<!--<td align="center">
			<?php echo $result['Patient']['hospital_no'];?>
		</td>
		                	
		<td>
			<?php echo $result['Patient']['lookup_name'];?>
		</td>-->
                     		
 		<td align="center" style="text-align:center;" width="7%">
     		<?php 
     			foreach ($surgeriesData as $surgery)
         		{ 
         			if($result['Patient']['id'] == $surgery['OptAppointment']['patient_id'])
         			{
         				echo $surgery['Surgery']['name'];	//display only the surgery of rgjay patients
         			}
         		}
     		?>
 		</td>
                     		
 		<td align="center" style="text-align:center;">
     		<?php 
     			 
     			echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format'))."<br>"; 
     			echo $comp_date = add_dates($result['Patient']['form_received_on'], 7);	//package completion date after 7 days of admission
     		?>
     	</td>
	                     	
 		<!--<td align="center" style="text-align:center;">
 			<?php 
 				echo $comp_date = add_dates($result['Patient']['form_received_on'], 7);	//package completion date after 7 days of admission
			?> 
		</td>-->
							
 		<td align="center" style="text-align:center;">
 			<?php
         		//if the patient is discharged or approved then display green button otherwise display the no of completion days after package 
         			if(isset($result['Patient']['discharge_date']) || $result['Patient']['extension_status']==1)		
         			{
         				echo "-";
					}
					else
					{ ?>
						
             			<?php echo $no_days = "<font style=\"color:red; font-size:18px;\">".diff_bet_dates($comp_date,$curnt_date)."</font>";	?>
             			
				<?php	}
				?>
		</td>
							
 		<td align="center" style="text-align:center;">
     		<?php 
     			if(isset($result['Patient']['discharge_date']))
         		{
         			echo "Discharged";
         		} 
				else
				if($result['Patient']['discharge_date']==0 && isset($no_days))
     			{
					echo "not approved";
				}
         		else
         		{
         			 echo "Approved";
         		}
     		?>
 		</td>		
        
        <td align="center" style="text-align:center;">
        	<?php 
        		echo  $result['FinalBilling']['package_amount'];
        	?>
        </td>
		
		<td align="center" style="text-align:center;">
        	<?php 
        		echo  $result['Patient']['enrollment_date'];
        	?>
        </td>
		
		<td align="center" style="text-align:center;">
        	<?php 
        		echo  $result['Patient']['preauth_send_date'];
				echo "/";
        		echo  $result['Patient']['preauth_approved_date'];
        	?>
        </td>
		
		<td align="center" style="text-align:center;">
        	<?php 
        		echo  $result['Patient']['surgery_pending_date'];
				echo "/";
        		echo  $result['Patient']['surgery_done_date'];
        	?>
        </td>

		<td align="center" style="text-align:center;">
        	<?php 
				echo $result['Patient']['surgery_notes_update_date'];
        	?>
        </td>
        
		<td align="center" style="text-align:center;">
        	<?php 
				echo $result['Patient']['post_of_notes_update_date'];
        	?>
        </td>
		
        <td align="center" style="text-align:center;">
        	<?php 
        		echo  $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format'))."<br>";
        	?>
        	<?php 
	 		 	if(isset($result['Patient']['discharge_update']))
 				{
 				 	echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_update'],Configure::read('date_format'));
 				}
 				else
 				{
 					echo "----";
 				/*echo $this->Form->input("discharge_update_$patient_id",array('style'=>"width: 57%;",'class'=>'textBoxExpnd discharge_update','label'=>false));	*/              	//$i is used to change the name of datepicker in every loop
 				}?>
        </td>
        
 		<!--<td align="center" width="90" style="text-align:center;">
	 		<?php 
	 		 	if(isset($result['Patient']['discharge_update']))
 				{
 				 	echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_update'],Configure::read('date_format'));
 				}
 				else
 				{
 					echo "";
 				/*echo $this->Form->input("discharge_update_$patient_id",array('style'=>"width: 57%;",'class'=>'textBoxExpnd discharge_update','label'=>false));	*/              	//$i is used to change the name of datepicker in every loop
 				}?>
 				
	 		 
 		</td>-->
 		
 		<td align="center" style="text-align:center;">
 			<?php 
 				if(isset($result['Patient']['discharge_update']))
 				{
 				 	echo  $bill_open = add_dates($result['Patient']['discharge_update'], 10);
 				}
 				else
 				if(isset($result['Patient']['discharge_date']))
 				{
 					echo  $bill_open = add_dates($result['Patient']['discharge_date'], 10);
 				}
 				else
 				{
					echo $bill_open = NULL;
				}
			?> 
			<?php echo "<br>"; ?>
			<?php if(isset($bill_open) && empty($result['FinalBilling']['bill_uploading_date']))
     			{
     				echo $days_bill_opening=diff_bet_dates($bill_open, $curnt_date);
     			}
     			else 
     			{
					echo $days_bill_opening=NULL;
				}
     						
     		?>  
     		<?php echo "<br>"; ?>
     		<?php 
        	if(isset($result['FinalBilling']['bill_uploading_date']))
        	{
				echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
			}
			else
			{
				echo "";
        		/*echo $this->Form->input("bill_uploading_date_$bill_id",array('style'=>"width: 67%;",'class'=>'textBoxExpnd bill_uploading_date','label'=>false));*/ 
			}
        	?>
		</td>
		
 		<!--<td align="center" style="text-align:center;">
     		<?php if(isset($bill_open) && empty($result['FinalBilling']['bill_uploading_date']))
     			{
     				echo $days_bill_opening=diff_bet_dates($bill_open, $curnt_date);
     			}
     			else 
     			{
					echo $days_bill_opening=NULL;
				}
     						
     		?>  
		</td>-->
        
        <!--<td align="center" style="text-align:center;">
        	<?php 
        	if(isset($result['FinalBilling']['bill_uploading_date']))
        	{
				echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
			}
			else
			{
				echo "";
        		/*echo $this->Form->input("bill_uploading_date_$bill_id",array('style'=>"width: 67%;",'class'=>'textBoxExpnd bill_uploading_date','label'=>false));*/ 
			}
        	?>
        </td>-->
        
 		<td align="center" style="text-align:center;">
 			<?php
	 			if(isset($result['FinalBilling']['dr_claim_date']))
	        	{ 
					  echo $dr_claim_date = $this->DateFormat->formatDate2Local($result['FinalBilling']['dr_claim_date'],Configure::read('date_format'));
				}
				else
				{ 
        			echo "";
        			/*echo $this->Form->input("dr_claim_date_$bill_id",array('style'=>"width: 67%;",'class'=>'textBoxExpnd dr_claim_date','label'=>false)); */
        		}
        	?>
        	<?php echo "<br>"; ?>
        	<?php 	
 				if(isset($dr_claim_date) && $result['FinalBilling']['dr_claim_pending_approval']==0)
 				{ 
 				 echo "<font style=\"color:red;\">".$dr_claim = diff_bet_dates($dr_claim_date, $curnt_date)."</font>";
	 							unset($dr_claim_date); 
 				}
 				else
 				if($result['FinalBilling']['dr_claim_pending_approval']==1)
				{
					echo "approved";
					//echo $this->Html->image('icons/green_bullet.png',array('escape' => false,'div'=>false)); 
				}		 
 				else
 				{
 					echo $dr_claim = NULL;
				}
     		?>	
 		</td>
 		
 		<!--<td align="center" style="text-align:center;">
 			<?php 	
 				if(isset($dr_claim_date) && $result['FinalBilling']['dr_claim_pending_approval']==0)
 				{ 
 				 echo "<font style=\"color:red;\">".$dr_claim = diff_bet_dates($dr_claim_date, $curnt_date)."</font>";
	 							unset($dr_claim_date); 
 				}
 				else
 				if($result['FinalBilling']['dr_claim_pending_approval']==1)
				{
					echo "approved";
					//echo $this->Html->image('icons/green_bullet.png',array('escape' => false,'div'=>false)); 
				}		 
 				else
 				{
 					echo $dr_claim = NULL;
				}
     		?>	
 		</td>-->
 		
 		<td align="center" style="text-align:center;">
 			<?php
	 			if(isset($result['FinalBilling']['CMO_claim_date']))
	        	{ 
					  echo $CMO_claim_date = $this->DateFormat->formatDate2Local($result['FinalBilling']['CMO_claim_date'],Configure::read('date_format'));
				}
				else
				{ 
        			echo ""; 
        		}
        	?>
        	<?php echo "<br>"; ?>
        	<?php 	
 			
 				if(isset($CMO_claim_date) && $result['FinalBilling']['CMO_claim_pending_approval']==0)
 				{ 
 					echo "<font style=\"color:red;\">".$CMO_claim = diff_bet_dates($CMO_claim_date, $curnt_date)."</font>";
	 				unset($CMO_claim_date);
 				}
 				else
 				if($result['FinalBilling']['CMO_claim_pending_approval']==1)
				{
					echo "approved"; 
				}
				else
 				{
					echo $CMO_claim = NULL;
				}
     		?>
 		</td>
 		
 		<!--<td align="center" style="text-align:center;">
 			<?php 	
 			
 				if(isset($CMO_claim_date) && $result['FinalBilling']['CMO_claim_pending_approval']==0)
 				{ 
 					echo "<font style=\"color:red;\">".$CMO_claim = diff_bet_dates($CMO_claim_date, $curnt_date)."</font>";
	 				unset($CMO_claim_date);
 				}
 				else
 				if($result['FinalBilling']['CMO_claim_pending_approval']==1)
				{
					echo "approved"; 
				}
				else
 				{
					echo $CMO_claim = NULL;
				}
     		?>
 		</td>-->
 		
 		<td align="center" style="text-align:center;">
 			<?php 
	 			if(isset($result['Patient']['remark']))
	 			{
					echo $result['Patient']['remark'];
				}
				else
				{
	 				echo "";
	 			}
	 		?>
 		</td>
            
        <td>
        	<?php echo $result['Patient']['claim_status']; ?>
        </td>
        
       <!-- <td align="center">
        	<?php echo $result['Patient']['assigned_to']; ?>
        </td>-->
                 		
     </tr>  
                   	
    <?php }?>
	 	  
</table>

<?php 
     function diff_bet_dates($start,$end)	// difference between two dates
     {
     	$start_ts = strtotime($start);
		$end_ts = strtotime($end);
		$diff = $end_ts - $start_ts;
		if($diff<0)
		{ 
			return "-";
		}
		else 
		{
			return round($diff / 86400);	//60 * 60 * 24	(60sec * 60min * 24hrs) = 86400
        }
     }
     
     function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
     {
 		$date = $cur_date; 
		$date = strtotime($date);
		$date = strtotime("+$no_days day", $date);
		return date('d-m-Y', $date);
     }
          

 ?>
