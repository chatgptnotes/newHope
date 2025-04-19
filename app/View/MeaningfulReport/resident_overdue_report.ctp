<?php // DEBUG($data);EXIT;
  echo $this->Html->script(array('jquery.autocomplete','inline_msg','jquery.blockUI'));
  echo $this->Html->css('jquery.autocomplete.css');
   
  if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		<tr>
	  		<td colspan="2" align="left" class="error">
		   		<?php 
		     		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		   		?>
	  		</td>
	 </tr>
	</table>
<?php } ?>
  
<div class="clr">&nbsp;</div>
<div class="inner_title">
<h3> &nbsp;<?php echo __('Resident Doctor\'s Overdue Report', true); ?></h3>

</div>
<br/>

<?php echo $this->Form->create(null,array('action'=>'resident_overdue_report','type'=>'get'));?>	
<?php echo $this->Form->hidden('flag',array('value'=>$this->params->query['flag']));
?>
	

 
<table border="0" class=" "  cellpadding="0" cellspacing="0" width="60%" align="center" style="padding-right: 10px;display:block;">
	<tbody>
		<tr class="row_title" >				 
			<td class=" " align="right" width=" "><label><?php echo __('Resident Name :') ?></label></td> 
			<td class=" " colspan="2" align="right"><?php echo $this->Form->input('Resident.assigned_name', array('empty'=>'Select Resident','options'=>$Residentlist,'class' => '','id'=>"isadv$i",'selected'=>$this->params->query['assigned_name'],'label'=>false,'style'=>''));?></td>
			
			<td class=" " align="right" width=" " ><label><?php echo __('Assigned From:') ?></label></td> 
			<td class=" " > <?php echo $this->Form->input('from_date', array('id' => 'from_date', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'value'=>$this->params->query['from_date']));?></td> 
			<td class=" " align="right"><label><?php echo __('Assigned To :') ?> </label></td>
			<td class=" " > <?php echo $this->Form->input('to_date', array('id' => 'to_date', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'value'=>$this->params->query['to_date']));?></td>
			
			
		</tr>
		
		
		
		<tr>	
				<td align="right" style="padding-top: 10px; padding-left: 10px"  colspan="8">
				<?php echo $this->Html->link(__('Reset'),array('controller'=>'MeaningfulReport', 'action'=>'resident_overdue_report', 'admin' => false), array('id'=>'reset','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn', 'style'=>'text-decoration:none' ));?>
				<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	?>
			</td>
		 </tr>	
	</tbody>	
</table> 
 <?php echo $this->Form->end();?>	
		 
		 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" id="load">
<?php //debug(count($data));?>
<?php if(isset($residentOverdueData) && !empty($residentOverdueData)){
	
	//set get variables to pagination url 
			
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
	?>
			 
				 <tr class="row_title">
					   <td class="table_cell"><strong><?php echo  __('Patient\'s Name', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Date of Birth', true); ?></strong></td>
					    <td class="table_cell"><strong><?php echo  __('Gender', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Visit Completion Date/Time', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Assigned Date/Time', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Overdue by (Days)', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Completion Date/Time', true); ?></strong></td>
                      
                       
					  
				  </tr>
				  <?php 
				  	  $toggle =0;
				      if(count($residentOverdueData) > 0) {
                          $overDueCount =0;  
				      		foreach($residentOverdueData as $residentOverdueData){ 

                              
                               
                               $arrivedTimeConcat=$residentOverdueData["Appointment"]["date"]." ".$residentOverdueData["Appointment"]["arrived_time"].":00";
                              
                               
                               $seenDate=strtotime($arrivedTimeConcat) + (60*$residentOverdueData["Appointment"]["elapsed_time"]);
                              //debug($patients['ReminderPatientList']['id']);
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							      $residentNotes=unserialize($residentOverdueData['Note']['resident_notes']);
							      
							     					       
							      
							      $overdueDay=$this->DateFormat->dateDiff($residentOverdueData['Note']['signed_date'],$residentNotes["assigned_date"]) ;
							      
							      if($overdueDay->days=='0' || $overdueDay->days=='1')
							      {
							      	$overdueDayValue="Completed on time";
							      }
							      else
							      {
							      	$overdueDayValue=$overdueDay->days." days";
							      	$overDueCount++;
							      }
							       
								  ?>	
								   <td class="row_format"><?php echo ucfirst($residentOverdueData['Person']['first_name']) .' '.ucfirst($residentOverdueData['Person']['last_name']); ?></td>
								   <?php $dob=$this->DateFormat->formatDate2LocalForReport($residentOverdueData['Person']['dob'],Configure::read('date_format'),true);?>
								   <td class="row_format"><?php echo $dob; ?></td>
								   
								   <td class="row_format"><?php echo $residentOverdueData['Patient']['sex']; ?></td>
								   <td class="row_format"><?php $visitCompletionDate=date('Y-m-d H:i:s', $seenDate);
								   
								  
								   echo $this->DateFormat->formatDate2LocalForReport($visitCompletionDate,Configure::read('date_format_us'),true);
								  
								   ?></td>
								   <td class="row_format"><?php echo $residentNotes["assigned_date"];?></td>
								   
								   
								   <td class="row_format reminder"> 
								  <?php echo $overdueDayValue; ?>
								   </td>
								 
								   <td class="row_format"> <?php echo $this->DateFormat->formatDate2LocalForReport($residentOverdueData['Note']['signed_date'],Configure::read('date_format_us'),true);?></td> 
								  
								  
								  
								  
								   <!-- <td class="row_format" id="noaction_<?php echo $patients['Person']['id']?>" style="display: <?php echo $noactionRed;?>"><?php echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'','class'=>'','id'=>'tookActiong_'.$patients['Person']['id'])); ?></td> -->
								
								
								 
								  </tr>
					  <?php } 
					 		//$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 	
					 		
					       $percentageOverdue=($overDueCount * 100)/count($residentOverdueData);
					   ?>
					   <tr><td>Percentage of OverDue Notes: <?php echo $percentageOverdue."%";?></td></tr>
					   <tr>
					    <TD colspan="8" align="center">
							 <!-- Shows the page numbers -->
							 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
							 <!-- Shows the next and previous links -->
							 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
							 <span class="paginator_links"><?php //echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
							 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
							 
						</TD>
					   </tr>
			<?php } ?> <?php					  
			      } else {
			 ?>
			  <tr>
			   <TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
			   
			  </tr>
			  <?php
			      }
			  ?>
		  
		 </table>
<script>

		 	
			$("#from_date").datepicker(
					{
							changeMonth : true,
							changeYear : true,
							yearRange : '1950',
							dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
							showOn : 'both',
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							buttonText: "Calendar",
							onSelect : function() {
								$(this).focus();
							}
			});
			
			$("#to_date").datepicker(
					{
							changeMonth : true,
							changeYear : true,
							yearRange : '1950',
							dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
							showOn : 'both',
							buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
							buttonImageOnly : true,
							buttonText: "Calendar",
							onSelect : function() {
								$(this).focus();
							}
			});

	
</script>
