<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT"); 
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Patient Reminder - ".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls" );
header ("Content-Description: Generated Report" ); 
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');
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
<div class="inner_title">
<h3> &nbsp;<?php echo __('Patient Reminder', true); if($this->params->query[flag]=='cancer'){echo "- Cervical cancer screening"; }elseif($this->params->query[flag]=='influenza'){echo "- Influenza vaccination"; }
elseif($this->params->query[flag]=='smoking'){echo "- Smoking"; }elseif($this->params->query[flag]=='diabetes'){echo "- Diabetes"; }elseif($this->params->query[flag]=='depression'){echo "- Depression"; }elseif($this->params->query[flag]=='highbp'){echo "- Hign Blood Pressure"; }else {}?></h3>

</div>
<br/>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width=100%>
	<tr class="row_title">
	   <td class="table_cell"><strong><?php echo  __('Patient\'s Name', true); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('Date of Birth', true); ?></strong></td>
       <td class="table_cell"><strong><?php echo  __('Age', true); ?></strong></td>
       <td class="table_cell"><strong><?php echo  __('Sex', true); ?></strong></td>
       <td class="table_cell"><strong><?php echo  __('Patient\'s Phone number', true); ?></strong></td>
       <td class="table_cell"><strong><?php echo  __('Reminder sent', true); ?></strong></td>
       <td class="table_cell"><strong><?php echo  __('Script  of phone reminders', true); ?></strong></td>
       <td class="table_cell"><strong><?php echo  __('Patient took action', true); ?></strong></td>
	  
    </tr>
<?php 
  	  $toggle =0;
      if(count($data) > 0) {
      		foreach($data as $patients){ //debug($patients['ReminderPatientList']['id']);
			       if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }
			       
			       if(empty($patients['ReminderPatientList']['id'])){
						$displayRed='No';
						if($patients['ReminderPatientList']['reminder_followup_taken']=='Yes'){
							$noactionRed='Yes';
						}else{
							$noactionRed='No';
						}
					}else{
						$displayRed='Yes';
						if($patients['ReminderPatientList']['reminder_followup_taken']=='Yes'){
							$noactionRed='Yes';
						}else{
							$noactionRed='No';
						}
					}
				  ?>	
			   <td class="row_format"><?php echo ucfirst($patients['Person']['first_name']) .' '.ucfirst($patients['Person']['last_name']); ?></td>
			   <?php $dob=$this->DateFormat->formatDate2LocalForReport($patients['Person']['dob'],Configure::read('date_format'),true);?>
			   <td class="row_format" style="text-align: left;"><?php echo $dob; ?></td>
			   <?php 
			   if($patients['Patient']['age']=='0' || empty($patients['Patient']['age'])){
					$age=$this->General->getCurrentAge($patients['Person']['dob']);
				}else{
					$age=$patients['Patient']['age'];
				}
			   ?>
			   <td class="row_format" style="text-align: left;"><?php echo rtrim($age,"Years "); ?></td>
			   <td class="row_format"><?php echo $patients['Patient']['sex']; ?></td>
			   <td class="row_format" style="text-align: left;"><?php echo $patients['Person']['person_local_number']; ?></td>
			   <td class="row_format reminder" id="rem_<?php echo $patients['Person']['id']?>"> <?php echo $displayRed;?></td>
			   <td class="row_format"><?php echo $patients['ReminderPatientList']['phone_reminder_script'];?> </td> 
			   <td class="row_format" id="action_<?php echo $patients['Person']['id']?>" > <?php echo $noactionRed;?></td>
			  </tr>
			<?php }  
			 } else { ?>
		  <tr>
			   <TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
		  </tr>
		  <?php } ?>
 </table>