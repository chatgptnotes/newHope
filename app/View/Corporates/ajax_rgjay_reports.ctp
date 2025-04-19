<style>	
	.tableFoot{font-size:11px; color:#b0b9ba;}
	.tabularForm td td{padding:0;}
	.top-header
	{
		background:#3e474a;
		height:75px;
		left:0;
		right:0;
		top:0px;
		margin-top:10px;
		position: relative;
	}  
	textarea
	{
		width: 100px;
	}
	
	.inner_title span 
	{
    	margin: -33px 0 0 !important;
 	}
 	.inner_menu
 	{
		padding: 10px 0px;
	}

</style>

<?php
// claim status to select options
$status_update = array(
						'Account Reverified'=>'Account Reverified',
						'CMO Approved(Repudiated)'=>'CMO Approved(Repudiated)',
						'CMO Pending(Repudiated)'=>'CMO Pending(Repudiated)',
						'CMO Pending'=>'CMO Pending',
						'CMO Verified'=>'CMO Verified',
						'Cancelled By Society'=>'Cancelled By Society',
						'Claim Doctor Approved'=>'Claim Doctor Approved',
						'Claim Doctor Pending'=>'Claim Doctor Pending',
						'Claim Doctor Pending Updated'=>'Claim Doctor Pending Updated',
						'Claim Doctor Rejected'=>'Claim Doctor Rejected',
						'Claim Inprocess'=>'Claim Inprocess',
						'Claim Paid'=>'Claim Paid',
						'Claim Sent For Payment'=>'Claim Sent For Payment',
						'Discharge Update'=>'Discharge Update',
						'In Patient Case Registered'=>'In Patient Case Registered',
						'Repudiated Claim Appeal Initiated'=>'Repudiated Claim Appeal Initiated',
						'Sent For Preauthorization'=>'Sent For Preauthorization',
						'Society Approved'=>'Society Approved',
						'Society Pending'=>'Society Pending',
						'Society Rejected'=>'Society Rejected',
						'Surgery Update'=>'Surgery Update',
						'TPA Pending'=>'TPA Pending',
						'TPA Pending Updated'=>'TPA Pending Updated',
						'Terminated By Society'=>'Terminated By Society',
						'Treatment Schedule Update'=>'Treatment Schedule Update',
						'Preauth Approved'=>'Preauth Approved'	
					);
					
$team = array('A'=>'A','B'=>'B','C'=>'C');
?>

 <div id="container"> 
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm top-header">
	  <thead>
		<tr>
			<th width="21" valign="top" align="center"
				style="text-align: center; min-width: 21px;">No.</th>
			<th width="80" valign="top" align="center"
				style="text-align: center; min-width: 80px;">Patient name <br> Case No. <br>
				 Hospital No. <br> Assigned To</th>
			<th width="90" valign="top" align="center"
				style="text-align: center; min-width: 90px;">Procedure Name</th>
			<th width="65" valign="top" align="center"
				style="text-align: center; min-width: 65px;">Adm.Date <br> Pack.Dt</th>
			<th width="21" valign="top" align="center"
				style="text-align: center; min-width: 21px;">comp letion days</th>
			<th width="111" valign="top" align="center"
				style="text-align: center; min-width: 111px">Extension</th>
			<th width="80" valign="top" align="center"
				style="text-align: center; min-width: 80px;">Package Amount</th>
			<th width="65" valign="top" align="center"
				style="text-align: center; min-width: 65px;">Enrollment Date</th>
			<th width="65" valign="top" align="center"
				style="text-align: center; min-width: 65px;">Preauth Send<br> Preauth Approved</th>
			<th width="65" valign="top" align="center"
				style="text-align: center; min-width: 65px;">Surgery Pending<br>Surgery Done</th>
			<th width="65" valign="top" align="center"
				style="text-align: center; min-width: 65px;">Surgery Notes Updated</th>
			<th width="65" valign="top" align="center"
				style="text-align: center; min-width: 65px;">Post of Notes</th>
			<th width="65" valign="top" align="center"
				style="text-align: center; min-width: 65px;">Discharge Date <br> Update
				Date</th>
			<th width="65" valign="top" align="center"
				style="text-align: center; min-width: 65px;">Bill Date <br>Days <br>
				Uploading Date</th>
			<th width="65" valign="top" align="center"
				style="text-align: center; min-width: 65px;">Claim Date <br>Pending
				Days</th>
			<th width="65" valign="top" align="center"
				style="text-align: center; min-width: 65px;">CMO Date <br> Pending Days</th>
			<th width="250" valign="top" align="center"
				style="text-align: center; min-width: 245px;">Claim Status</th>
			<th width="120" valign="top" align="center"style="text-align: center; min-width: 120px;">Remark</th>

			<th width="21" valign="center" align="center"style="text-align: center; min-width: 21px;"><?php echo $this->Html->image('icons/delete-icon.png'); ?>
			</th>
		</tr>
		</thead>
      </table>
              
       <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">     	
		<?php $curnt_date = date("Y-m-d");	//for current date
                   $i = 0;  	
		foreach($results as $key=>$result) 
		{ 
			$patient_id = $result['Patient']['id']; 	//holds the id of patient
			$bill_id = $result['FinalBilling']['id'];	//holds the bill id of patient
			$i++ ; ?>
				              	
	<tr> 
		<td width="21" align="center" style="text-align:center; min-width:21px;">
			<?php echo $i; ?>
		</td> 
		
		<td width="80" align="center" style="text-align:center; min-width:80px;">
			<table cellpadding="0" cellspacing="0" border="0" class="tabularForm">
				<tr>
					<td colspan="2">
						<?php echo $result['Patient']['lookup_name'];?>
					</td>
				</tr>			
				<tr>
					<td>
					<?php
					echo $this->Form->input('case_no', array('id'=>'case_'.$result['Patient']['id'],'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_case','value'=>$result['Patient']['case_no']));
					?>
					</td>
				</tr>
				
				<tr>
					<td>
						<?php
							echo $this->Form->input('hospital_no', array('id'=>'hospital_'.$result['Patient']['id'],'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_hospital','value'=>$result['Patient']['hospital_no']));
						?>
							
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<?php
        					echo $this->Form->input('status_update', array('type' => 'select','label'=>false ,'div'=>false,'class'=>'assigned','id'=>$result['Patient']['id'],'options' => array('empty'=>'---',$team),'selected'=>$result['Patient']['assigned_to']));
        	?>
					</td>	
				</tr>	
				<tr>
					<td colspan="2">
						<?php 
     			echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); 		//date of admission ?>
					</td>
				</tr>
			</table>
		</td> 
                     		
 		<td width="90" align="center" style="text-align:center; min-width:90px;">
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
                     		
 		<td width="65" align="center" style="text-align:center; min-width:65;">
     		<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
					<?php 
     			echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); 		//date of admission ?>
     				</td>
     			</tr>
     			<tr>
     				<td>
     					-----
     				</td>
     			</tr>
     			<tr>
     				<td>
     					<?php 
 				$comp_date = add_dates($result['Patient']['form_received_on'], 7);	//package completion date after 7 days of admission
 				echo $this->DateFormat->formatDate2Local($comp_date,Configure::read('date_format'));
			?>
     				</td>
     			</tr>
     		</table>
     	</td>
							
 		<td width="21" align="center" style="text-align:center; min-width:21px;">
 			<?php
         		//if the patient is discharged or approved then display green button otherwise display the no of completion days after package 
         			if(isset($result['Patient']['discharge_date']) || $result['Patient']['extension_status']==1)		
         			{
         				echo $this->Html->image('icons/green_bullet.png',array('title'=>"approved"));
					}
					else
					{ ?>
						<span id="completion_<?php echo $result['Patient']['id']; ?>">
             			<?php echo "<font style=\"color:red; font-size:18px;\">".diff_bet_dates($comp_date,$curnt_date)."</font>";	// difference betn the completed package date and current date?>
             			</span>
				<?php	}
				?>
		</td>
							
 		<td width="111" align="center" style="text-align:center; min-width: 111px;">
     		<?php 
     			if(!isset($result['Patient']['discharge_date']))
         		{ 
         			echo $this->Form->input('status', array('type' => 'select','label'=>false ,'div'=>false,'class'=>'checkMe','id'=>$result['Patient']['id'],'options' => array('empty'=>'--Select--','1'=>'Approved', '0'=>'Discharged'),'selected'=>$result['Patient']['extension_status']));
					$status = Configure::read('onBedStatus');
         		}
         		else
         		{
         			echo "Discharged"; 
					$status = Configure::read('onDischargeStatus');
         		}
     		?>
 		</td>		
        
        <td width="80" align="center" style="text-align:center; min-width:80px;">
        	<table cellpadding="0" cellspacing="0">
			<td>
			<?php
				echo $this->Form->input('package_amount', array('id'=>'packageAmt_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_package_amount','value'=>$result['FinalBilling']['package_amount']));
			?>
			</td>

			</table>
        </td>
        <!-- Enrollment -->
			<td width="65" align="center" style="text-align: center; min-width: 65px;">
				<?php 
					$enrollment_date = '';
					if(!empty($result['Patient']['enrollment_date'])) { 
						$enrollment_date = $this->DateFormat->formatDate2Local($result['Patient']['enrollment_date'],Configure::read('date_format'));
					}
					echo $this->Form->input("enrollment_date",array('placeholder'=>'Enrollment','value'=>$enrollment_date,'field'=>'enrollment_date','style'=>"width: 65%;",'class'=>'textBoxExpnd enrollment_date','patient_id'=>$patient_id,'label'=>false));
				?> 
			</td>
			<!-- end of enrollment -->
			
			<!-- Preauth Send / Preauth Approved -->
			<td width="65" align="center"
				style="text-align: center; min-width: 65px;">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							<?php 
								$preauth_send_date = '';
								if(!empty($result['Patient']['preauth_send_date'])) { 
									$preauth_send_date = $this->DateFormat->formatDate2Local($result['Patient']['preauth_send_date'],Configure::read('date_format'));
								}
								echo $this->Form->input("preauth_send",array('placeholder'=>'preauth send','value'=>$preauth_send_date,'field'=>'preauth_send_date','style'=>"width: 65%;",'class'=>'textBoxExpnd preauth_send','patient_id'=>$patient_id,'label'=>false));
							?>
 						</td>
					</tr>
					<tr>
						<td align="center">-----</td>
					</tr>
					<tr>
						<td>
							<?php
								$preauth_approved_date = '';
								if(!empty($result['Patient']['preauth_approved_date'])) { 
									$preauth_approved_date = $this->DateFormat->formatDate2Local($result['Patient']['preauth_approved_date'],Configure::read('date_format'));
								}
								echo $this->Form->input("preauth_approved",array('placeholder'=>'preauth approved','value'=>$preauth_approved_date,'field'=>'preauth_approved_date','style'=>"width: 65%;",'class'=>'textBoxExpnd preauth_approved','patient_id'=>$patient_id,'label'=>false));
							?>
						</td>
					</tr>
				</table>
			</td>
			<!-- end of preauth send / preauth approved -->
			
			<!-- Surgery Pending / Surgery Done -->
			<td width="65" align="center"
				style="text-align: center; min-width: 65px;">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td>
							<?php 
								$surgery_pending_date = '';
								if(!empty($result['Patient']['surgery_pending_date'])) { 
									$surgery_pending_date = $this->DateFormat->formatDate2Local($result['Patient']['surgery_pending_date'],Configure::read('date_format'));
								}
								echo $this->Form->input("surgery_pending",array('placeholder'=>'Surgery Pending','value'=>$surgery_pending_date,'field'=>'surgery_pending_date','style'=>"width: 65%;",'class'=>'textBoxExpnd surgery_pending','patient_id'=>$patient_id,'label'=>false));
							?>
 						</td>
					</tr>
					<tr>
						<td align="center">-----</td>
					</tr>
					<tr>
						<td>
							<?php 
								$surgery_done_date = '';
								if(!empty($result['Patient']['surgery_done_date'])) { 
									$surgery_done_date = $this->DateFormat->formatDate2Local($result['Patient']['surgery_done_date'],Configure::read('date_format'));
								}
								echo $this->Form->input("surgery_done_date",array('placeholder'=>'Surgery Done','value'=>$surgery_done_date,'field'=>'surgery_done_date','style'=>"width: 65%;",'class'=>'textBoxExpnd surgery_done','patient_id'=>$patient_id,'label'=>false));
							?>
						</td>
					</tr>
				</table>
			</td>
			<!-- end of Surgery Pending / Surgery Done -->
			
			<!-- Surgery Notes Update -->
			<td width="65" align="center" style="text-align: center; min-width: 65px;">
				<?php 
					$surgery_notes_update_date = '';
					if(!empty($result['Patient']['surgery_notes_update_date'])) { 
						$surgery_notes_update_date = $this->DateFormat->formatDate2Local($result['Patient']['surgery_notes_update_date'],Configure::read('date_format'));
					}
					echo $this->Form->input("surgery_notes_update_date",array('placeholder'=>'Surgery Notes Update','value'=>$surgery_notes_update_date,'field'=>'surgery_notes_update_date','style'=>"width: 65%;",'class'=>'textBoxExpnd surgery_notes_update','patient_id'=>$patient_id,'label'=>false));
				?> 
			</td>
			<!-- end of Surgery notes update -->
			
			<!-- Post of Notes -->
			<td width="65" align="center" style="text-align: center; min-width: 65px;">
				<?php
					$post_of_notes_date = '';
					if(!empty($result['Patient']['post_of_notes_date'])) { 
						$post_of_notes_date = $this->DateFormat->formatDate2Local($result['Patient']['post_of_notes_date'],Configure::read('date_format'));
					}
					echo $this->Form->input("post_of_notes_date",array('placeholder'=>'Post of Notes','value'=>$post_of_notes_date,'field'=>'post_of_notes_date','style'=>"width: 65%;",'class'=>'textBoxExpnd post_of_notes','patient_id'=>$patient_id,'label'=>false));
				?> 
			</td>
			<!-- end of Post of notes -->
			
			<!-- discharge date -->
			<td width="65" align="center"
				style="text-align: center; min-width: 65px;">
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td><?php
						echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format'));
						?>
						</td>
					</tr>
					<tr>
						<td align="center">-----</td>
					</tr>
					<tr>
						<td><?php 
						if(isset($result['Patient']['discharge_update']))
						{
							echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_update'],Configure::read('date_format'));
						}
						else
						{
							echo $this->Form->input("discharge_update_$patient_id",array('style'=>"width: 55%;",'class'=>'textBoxExpnd discharge_update','label'=>false));	              	//$i is used to change the name of datepicker in every loop
						}?></td>
					</tr>
				</table>
			</td>
			<!-- end of discharge date -->

 		
 		<td width="65" align="center" style="text-align:center; min-width: 65px;">
 			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
					<?php 
 				if(isset($result['Patient']['discharge_update']))
 				{
 				 	$bill_open = add_dates($result['Patient']['discharge_update'], 10);
 				 	echo $this->DateFormat->formatDate2Local($bill_open,Configure::read('date_format'));
 				}
 				else
 				if(isset($result['Patient']['discharge_date']))
 				{
 					$bill_open = add_dates($result['Patient']['discharge_date'], 10);
 					echo $this->DateFormat->formatDate2Local($bill_open,Configure::read('date_format'));
 				}
 				else
 				{
					echo $bill_open = NULL;
				}
			?> 
			</td>
			</tr>
			<tr>
				<td>
					<?php if(isset($bill_open) && empty($result['FinalBilling']['bill_uploading_date']))
     			{
     				echo $days_bill_opening=diff_bet_dates($bill_open, $curnt_date);
     			}
     			else 
     			{
					echo $days_bill_opening=NULL;
				}
     						
     		?>  
				</td>
			</tr>
			<tr>
				<td>
					<?php 
        	if(isset($result['FinalBilling']['bill_uploading_date']))
        	{
				echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
			}
			else
			{
				
        		echo $this->Form->input("bill_uploading_date_$bill_id",array('style'=>"width: 65%;",'class'=>'textBoxExpnd bill_uploading_date','label'=>false)); 
			}
        	?>
				</td>
			</tr>
			</table>
		</td>
        
 		<td width="65" align="center" style="text-align:center; min-width: 65px;">
 			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
					<?php
	 			if(isset($result['FinalBilling']['dr_claim_date']))
	        	{ 
					 $dr_claim_date = $result['FinalBilling']['dr_claim_date'];
					 echo $this->DateFormat->formatDate2Local($dr_claim_date,Configure::read('date_format'));
				}
				else
				{ 
        			echo $this->Form->input("dr_claim_date_$bill_id",array('style'=>"width: 65%;",'class'=>'textBoxExpnd dr_claim_date','label'=>false)); 
        		}
        	?>
        	</td>
        	</tr>
        	<tr>
        		<td>
        			<?php 	
 				if(isset($dr_claim_date) && $result['FinalBilling']['dr_claim_pending_approval']==0)
 				{ ?>
 				<span id="dr_claim_approval_<?php echo $bill_id; ?>">
	 				<table width="100%"  cellpadding="0" cellspacing="0">
	 					<tr>
	 						<td>
	 							<?php echo "<font style=\"color:red;\">".$dr_claim = diff_bet_dates($dr_claim_date, $curnt_date)."</font>";
	 							unset($dr_claim_date); ?>
	 						</td>
							<td align="right">
							<span id="<?php echo $bill_id; ?>" class="approveME">
								<?php echo $this->Html->image('icons/red_bullet.png',array('alt' => 'Pending', 'title'=>'Click to approve'),array('escape' => false,'div'=>false)); ?>
							</span>
							</td>
	 					</tr>
	 				</table>
 				</span>
 				<?php 
 				}
 				else
 				if($result['FinalBilling']['dr_claim_pending_approval']==1)
				{
					echo $this->Html->image('icons/green_bullet.png',array('escape' => false,'div'=>false)); 
				}		 
 				else
 				{
 					echo $dr_claim = NULL;
				}
     		?>	
        		</td>
        	</tr>
        	</table>
 		</td>
 		
 		<td width="65" align="center" style="text-align:center; min-width: 65px;">
 			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><?php
	 			if(isset($result['FinalBilling']['CMO_claim_date']))
	        	{ 
					  $CMO_claim_date = $result['FinalBilling']['CMO_claim_date'];
					  echo $this->DateFormat->formatDate2Local($CMO_claim_date,Configure::read('date_format'));
				}
				else
				{ 
        			echo $this->Form->input("CMO_claim_date_$bill_id",array('style'=>"width: 65%;",'class'=>'textBoxExpnd CMO_claim_date','label'=>false)); 
        		}
        	?>
        	</td>
        	</tr>
        	<tr>
        		<td>
        			<?php 	
 				if(isset($CMO_claim_date) && $result['FinalBilling']['CMO_claim_pending_approval']==0)
 				{ ?>
 				<span id="CMO_claim_approval_<?php echo $bill_id; ?>">
	 				<table width="100%"  cellpadding="0" cellspacing="0">
	 					<tr>
	 						<td>
	 							<?php echo "<font style=\"color:red;\">".$CMO_claim = diff_bet_dates($CMO_claim_date, $curnt_date)."</font>";
	 							unset($CMO_claim_date); ?>
	 						</td>
							<td align="right">
							<span id="<?php echo $bill_id; ?>" class="CMOapproveME">
								<?php echo $this->Html->image('icons/red_bullet.png',array('alt' => 'Pending', 'title'=>'Click to approve'),array('escape' => false,'div'=>false)); ?>
							</span>
							</td>
	 					</tr>
	 				</table>
 				</span>
 				<?php 
 				}
 				else
 				if($result['FinalBilling']['CMO_claim_pending_approval']==1)
				{
					echo $this->Html->image('icons/green_bullet.png',array('escape' => false,'div'=>false)); 
				}
				else
 				{
					echo $CMO_claim = NULL;
				}
     		?>
        		</td>
        	</tr>
        	</table>
 		</td>		
            
        <td width="120" align="center" style="text-align:center; min-width:100px;">
        	<?php
        		echo $this->Form->input('claim_status', array('type' => 'select','label'=>false ,'div'=>false,'class'=>'claim_status','id'=>$result['Patient']['id'],'options' => array('empty'=>'--Select--',$status),'selected'=>$result['Patient']['claim_status']));
        	?>
        </td>
        
        <td width="120" align="center" style="text-align:center">
 			<?php echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','label'=>false,'rows'=>'4','cols'=>'1','class'=>'add_remark','value'=>$result['Patient']['remark']));
	 			?>
	 	</td>
        
        <td width="21" align="center" style="text-align:center; min-width:21px;">
		    <a href="javascript:void(0);" id="Generic" onclick="completed($result['Patient']['id']);" style="padding: 0px;">
				<?php echo $this->Html->image('icons/delete-icon.png',array('title'=>'Hide','alt'=>'Hide','class'=>'Hide','patient_id'=>$result['Patient']['id']));?>
			</a>
			
			<?php
				//echo $this->Html->link($this->Html->image('icons/delete-icon.png',''),'javascript:void(0);',id="delete_"$result['Patient']['id'],'admin'=>false),array('escape' => false,'alt'=>"Delete",'title'=>"Delete from report"));
		    ?>
		</td>
                 		
     </tr>  	
    <?php }?>                 	
</table> 

</div>
 
<!--******************************************* table closed *******************************************************-->                    
                     
                    
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
		return date('Y-m-d', $date);
     }
     
     

 ?>
 

 	
                     
<!--*******************************************************************************************************************-->        

            
<script>
jQuery(document).ready(function()
{

function checkExpiryDate(field, rules, i, options)
{
    var today=new Date();
    var curDate = new Date(today.getFullYear(),today.getMonth(),today.getDate());
    var inputDate = field.val().split("/");
    var inputDate1 = new Date(inputDate[2],eval(inputDate[1]-1),inputDate[0]);
    if (field.val() != "") 
    {
        if (inputDate1 <= curDate) {
         return options.allrules.expirydate.alertText;
        }
    }

}

$( ".discharge_update" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		//alert(date);
		 var idd = $(this).attr('id');
		 //alert(idd);
		 splittedId=idd.split('_');
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDischargeDate", "admin" => false));?>",
   			data:'id='+splittedId[2]+"&date="+date,
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});



$( ".enrollment_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		//alert(date);
		 var idd = $(this).attr('id');
		 //alert(idd);
		 splittedId=idd.split('_');
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false));?>",
   			data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});

$( ".preauth_send" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		//alert(date);
		 var idd = $(this).attr('id');
		 //alert(idd);
		 splittedId=idd.split('_');
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false));?>",
   			data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});

$( ".preauth_approved" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		//alert(date);
		 var idd = $(this).attr('id');
		 //alert(idd);
		 splittedId=idd.split('_');
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false));?>",
   			data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});

$( ".surgery_pending" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		//alert(date);
		 var idd = $(this).attr('id');
		 //alert(idd);
		 splittedId=idd.split('_');
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false));?>",
   			data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});

$( ".surgery_done" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		//alert(date);
		 var idd = $(this).attr('id');
		 //alert(idd);
		 splittedId=idd.split('_');
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false));?>",
   			data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});


$( ".surgery_notes_update" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		//alert(date);
		 var idd = $(this).attr('id');
		 //alert(idd);
		 splittedId=idd.split('_');
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false));?>",
   			data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});

$( ".post_of_notes" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		//alert(date);
		 var idd = $(this).attr('id');
		 //alert(idd);
		 splittedId=idd.split('_');
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updateDates", "admin" => false));?>",
   			data:'id='+$(this).attr('patient_id')+"&date="+date+"&field="+$(this).attr('field'),
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});


$( ".bill_uploading_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		var idd = $(this).attr('id');
		 splittedId=idd.split('_');
		 var newId = splittedId[3];
		 
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "billUploadDate", "admin" => false));?>"+"/"+newId,
   			data:'id='+newId+"&date="+date,
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});




$( ".dr_claim_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		var idd = $(this).attr('id');
		//alert(idd);
		 splittedId=idd.split('_');
		 var newId = splittedId[3];
		 
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "drClaimDate", "admin" => false));?>"+"/"+newId,
   			data:'id='+newId+"&date="+date,
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});


 
           

$( ".CMO_claim_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		var idd = $(this).attr('id');
		//alert(idd);
		 splittedId=idd.split('_');
		 var newId = splittedId[3];
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "CMOclaimDate", "admin" => false));?>"+"/"+newId,
   			data:'id='+newId+"&date="+date,
   			success: function(data)
   			{
	   			//alert(data);
	   		}
		});
	},
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});


$( ".date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",	
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '-50:+50',
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
});




$('.add_case').blur(function()
  {
  	//alert("This input field has lost its focus.");
	  var patient = $(this).attr('id') ;
	  //alert(patient);
	   splittedId=patient.split('_');
	   newId = splittedId[1]; 
	   //alert();
	  var val = $(this).val();
	  //alert(val);
	 
	 $.ajax({
	url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getCase", "admin" => false));?>"+"/"+newId+"/"+val,
	
	beforeSend:function(data){
		$('#busy-indicator').show();
		
	},
	success: function(data){
			$('#busy-indicator').hide();
	     }
	});  
	});
	
	
	
$('.add_hospital').blur(function()
  {
	  var patient = $(this).attr('id') ;
	// alert(patient);
	 splittedId = patient.split("_");
	 
	 newId = splittedId[1];
	// alert(newId);
	  var val = $(this).val();
	 //alert(val);

	$.ajax({
	url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getHospital", "admin" => false));?>"+"/"+newId+"/"+val,
	beforeSend:function(data){
		$('#busy-indicator').show();
		//inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
	},
	success: function(data){
				$('#busy-indicator').hide();
	     }
	});
	}
	);
	
	
	

	
$('.add_package_amount').blur(function()
  {
	  var bill = $(this).attr('id') ;
	  splittedId = bill.split("_");
	  newId = splittedId[1]
	  //alert(newId);
	  var val = $(this).val();
	  //alert(val);

	$.ajax({
	url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getPackageAmount", "admin" => false));?>"+"/"+newId+"/"+val,
	//data:'id='+bill+'&amount='+val,
	beforeSend:function(data){
		$('#busy-indicator').show();
		//inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
	},
	
	success: function(data){
				$('#busy-indicator').hide();
	     }
	});}
	);



$('.clickMe').click(function()
  {
	  var patient = $(this).attr('id') ;
	  var val = $("#remark"+patient).val();

	$.ajax({
	url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getRemark", "admin" => false));?>"+"/"+patient+"/"+val,
	
	beforeSend:function(data){
		$('#busy-indicator').show();
		//inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
	},
	
	success: function(data){
				$('#busy-indicator').hide();
	     }
	
	});}
	);



$('.approveME').click(function()
  {
	  var id = $(this).attr('id') ;
	  //alert(id);
	$.ajax({
	type:'POST',
	url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getDrClaimApprove", "admin" => false));?>"+"/"+id,
	data:'id='+id+"&status="+1,
	success: function(data){
				//alert(data);
			var bullet = '<?php echo $this->Html->image("icons/green_bullet.png");?>';
			 	$("#dr_claim_approval_"+id).html(bullet);
	     }
	});}
	);
		
		
		
$('.CMOapproveME').click(function()
  {
	  var id = $(this).attr('id') ;
	  //alert(id);
	$.ajax({
	type:'POST',
	url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getCMOapprove", "admin" => false));?>"+"/"+id,
	data:'id='+id+"&status="+1,
	success: function(data){
				//alert(data);
			var bullet = '<?php echo $this->Html->image("icons/green_bullet.png");?>';
			 	$("#CMO_claim_approval_"+id).html(bullet);
	     }
	});}
	);
	
	

$('.checkMe').change(function()	//.checkMe is the class of select having patient's id as the id
{
 
	var id = $(this).attr('id');	
	//alert(id);	//holda the patient's id in var id
	status = $(this).val();				//holds the value of selected options
		   			
	$.ajax({
		url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getExtension", "admin" => false));?>"+"/"+id+"/"+status,
		success: function(data){
			var bullet = '<?php echo $this->Html->image("icons/green_bullet.png");?>';
		 	$("#completion_"+id).html(bullet);
		}
	});
	});
			   		
			   
			   
			   
$('.claim_status').change(function()	//.checkMe is the class of select having patient's id as the id
{
	var id = $(this).attr('id');	
	//alert(id);						//holds the patient's id in var id
	claim_status = $(this).val();		//holds the value of selected options
	//alert(claim_status);
	$.ajax({
	url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getUpdateStatus", "admin" => false));?>"+"/"+id+"/"+claim_status,
	beforeSend:function(data){
		$('#busy-indicator').show();
		//inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
	},
	
	success: function(data){
				$('#busy-indicator').hide();
	     }
	
});
});
	   
			   
			   
			   
			   
			   
$('.assigned').change(function()	//.checkMe is the class of select having patient's id as the id
{
	var id = $(this).attr('id');	
	//alert(id);	//holda the patient's id in var id
	assigned = $(this).val();				//holds the value of selected options
	$.ajax({
	url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getAssigned", "admin" => false));?>"+"/"+id+"/"+assigned,
	beforeSend:function(data){
		$('#busy-indicator').show();
		//inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
	},
	
	success: function(data){
				$('#busy-indicator').hide();
	     }
	
} );
});
	
$('.add_remark').blur(function()
  {
	  var patient = $(this).attr('id') ;
	  splittedId = patient.split("_");
	  newId = splittedId[1];
	  //alert(newId);
	  var val = $(this).val();
	  //alert(val);

	$.ajax({
	url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getRemark", "admin" => false));?>"+"/"+newId+"/"+val,
	
	beforeSend:function(data){
		$('#busy-indicator').show();
		//inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
	},
	
	success: function(data){
				$('#busy-indicator').hide();
	     }
	
	});
	}
	);

/*
	$('.filter').change(function()	//.checkMe is the class of select having patient's id as the id
	{
		var team = ($('#team').val()) ? $('#team').val() : 'null' ;
		var status = ($('#status').val()) ? $('#status').val() : 'null';
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "rgjay_report", "admin" => true));?>";
		$.ajax({
		url : ajaxUrl + '?assigned_to=' + team + '&claim_status=' + status,
		success: function(data){
			$("#container").html(data).fadeIn('slow');
		}
		});
	});
*/

	$(function() {
		var $sidebar   = $(".top-header"),
            $window    = $(window),
            offset     = $sidebar.offset(),
            topPadding = 0;

        $window.scroll(function() {
            if ($window.scrollTop() > offset.top) {
                //$sidebar.stop().animate({
                 //   top: $window.scrollTop() - offset.top + topPadding
               // });

                $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
            } else {
                $sidebar.stop().animate({
                    top: 0
                });
            }
        });
       
    });
    
    
    
		/*$(function() {
		 
		    var div = $('.top-header');
		    var start = $(div).offset().top;
		 
		    $.event.add(window, "scroll", function() {
		        var p = $(window).scrollTop();
		        $(div).css('position',((p)>start) ? 'fixed' : 'relative');
		        $(div).css('top',((p)>start) ? '0px' : '');
		    });
		 
		});*/




});
</script>
