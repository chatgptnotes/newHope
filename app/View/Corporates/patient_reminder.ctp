<?php // DEBUG($data);EXIT;
  echo $this->Html->script(array('jquery.autocomplete' ,'inline_msg','jquery.blockUI' ));
  echo $this->Html->css('jquery.autocomplete.css');
   
?>
<style>
/*----- Tabs -----*/
.tabs {
    width:100%;
    display:inline-block;
}
 
    /*----- Tab Links -----*/
    /* Clearfix */
    .tab-links:after {
        display:block;
        clear:both;
        content:'';
    }
 
    .tab-links li {
        margin:0px 5px;
        float:left;
        list-style:none;
    }
 
        .tab-links a {
            padding:9px 15px;
            display:inline-block;
            border-radius:3px 3px 0px 0px;
            background:#D2EBF2;
            font-size:16px;
            font-weight:600;
            color:#4c4c4c;
            transition:all linear 0.15s;
        }
 
        .tab-links a:hover {
            background:#a7cce5;
            text-decoration:none;
        }
 
    li.active a, li.active a:hover {
        background:#fff;
        color:#4c4c4c;
    }
 
    /*----- Content of Tabs -----*/
    .tab-content {
        padding:15px;
        border-radius:3px;
       /* box-shadow:-1px 1px 1px rgba(0,0,0,0.15);*/
        background:#fff;
    }
 
        .tab {
            display:none;
        }
 
        .tab.active {
            display:block;
        }
</style>


<div class="inner_title">
	<h3>
		<?php echo __('Patient Reminder', true); ?>
	</h3>
</div>

<div class="tabs" >
    <!-- Navigation header -->
	    <ul class="tab-links" style="padding-left: 10%">
	        <li class=""><a href="#tab1">Review patients for next 3-4 Days</a></li>
	        <li><a href="#tab2">Absent inspite of calling since 4 days</a></li>
	        <li><a href="#tab3">9 Months Pregnant & 1 week absent</a></li>
	        <li><a href="#tab4">Others & 15 days absent</a></li>
	      
	    </ul>
 	<!-- Navigation header End -->
 	
 	<!-- tab Section --> 
    <div class="tab-content">
        <?php $activeTab1 = ($this->params->query['flag'] == 'tab1') ? 'active' : '';?>
        <!-- Patient Details -->
	        <div id="tab1" class="tab <?php echo $activeTab1; ?>">
<?php 			 	
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
  
<!-- <div class="clr">&nbsp;</div>
<div class="">
<h3> &nbsp;<?php /* echo __('Patient Reminder', true); */ if($this->params->query[flag]=='cancer'){echo "- Cervical cancer screening"; }elseif($this->params->query[flag]=='influenza'){echo "- Influenza vaccination"; }
elseif($this->params->query[flag]=='smoking'){echo "- Smoking"; }elseif($this->params->query[flag]=='diabetes'){echo "- Diabetes"; }elseif($this->params->query[flag]=='depression'){echo "- Depression"; }elseif($this->params->query[flag]=='highbp'){echo "- High Blood Pressure"; }else {}?></h3>

</div> -->
<br/>

<?php echo $this->Form->create(null,array('action'=>'patient_reminder','type'=>'get'));?>	
<?php echo $this->Form->hidden('flag',array('value'=>$this->params->query['flag']));?>
<table border="0" class=" "  cellpadding="0" cellspacing="0" width="500px" align="center" style="padding-right: 10px" >
	<tbody>
		<tr class="row_title" >				 
			<td class=" " align="right" width=" "><label><?php echo __('First Name :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('first_name', array('id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			<td class=" " align="right" width=" "><label><?php echo __('Last Name :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('last_name', array('id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			<td class=" " align="right"><label><?php echo __('Gender :') ?> </label></td>
			<td class=" "><?php echo    $this->Form->input('gender', array('type'=>'select','options'=>array(''=>'select','Male'=>'Male','Female'=>'Female'),'id' => 'gender', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));?></td>
		  	<td class=" " align="right"><label><?php echo __('Age :') ?></label></td>
		  	<?php //$optn = array('10'=>'10','20'=>'20','30'=>'30','40'=>'40','50'=>'50','60'=>'60','70'=>'70','80'=>'80','90'=>'90');?>
			<td class=" "><?php echo    $this->Form->input('agefrom', array('type'=>'text','id' => 'agefrom', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:50px'));?></td>
			<td class=" " align="center"><label align="center"><?php echo __('To') ?></label></td>
			<td class=" "><?php echo    $this->Form->input('ageto', array('type'=>'text','id' => 'ageto', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:50px'));?></td>
		
		</tr>
		
		<tr class="row_title" >		
			
				 
			<td class=" " align="right" width=" "><label><?php echo __('Zip Code :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('zip_code', array('id' => 'zip_code', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
			<td class=" " align="right" width=" "><label><?php echo __('City :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('city', array('id' => 'city', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
			<td class=" " align="right"><label><?php echo __('State :') ?> </label></td>
			<td class=" "><?php echo    $this->Form->input('state', array('type'=>'select','options'=>$newState,'empty'=>'select','id' => 'state', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));?></td>
		  
		  	<td class=" " align="right" width=" "><label><?php echo __('Ward :') ?> </label></td> 
			<td class=" "><?php echo    $this->Form->input('ward', array('id' => 'ward', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td>
			</td> 
			
		  	<td class=" " align="right" width=" "><label><?php echo __('Panchayat :') ?> </label></td> 
			<td class=" "><?php echo    $this->Form->input('panchayat', array('id' => 'panchayat', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
		</tr>
		
		<tr>	
			<td colspan="9" align="right" style="padding-top: 10px"  >
				<?php echo $this->Html->link(__('Reset'),array('controller'=>'corporates', 'action'=>'patient_reminder','?'=>array('flag'=>$this->params->query['flag']), 'admin' => false), array('id'=>'reset','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn', 'style'=>'text-decoration:none' ));?>
			</td>
			<td align="right" style="padding-top: 10px; padding-left: 10px"  >
				<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	?>
			</td>
		 </tr>	
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
 
 
<div class="clr inner_title" style="text-align:right;padding-bottom: 10px;">
<?php echo $this->Html->link('Excel Report',array('controller'=>'corporates','action'=>'patient_reminder','?'=>array('flag'=>'tab1','type'=>'excel')),array('id'=>'excel_report','class'=>'blueBtn'));?> </div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" id="load">
<?php //debug(count($data));?>
<?php if(isset($data) && !empty($data)){
	
	//set get variables to pagination url 
				//$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
	?>
			 
				  <tr class="row_title">
					   <td class="table_cell"><strong><?php echo  __('Patient\'s Name', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Age'.'</br>'.'Date of Birth', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Patient ID', true); ?></strong></td>
                 <!--       <td class="table_cell"><strong><?php echo  __('Sex', true); ?></strong></td> -->
                       <td class="table_cell"><strong><?php echo  __('Patient\'s Phone number', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Reminded', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Script  of phone reminders', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Review Date', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Patient attended', true); ?></strong></td>
					  
				  </tr>
				  <?php 
				  	  $toggle =0;
				      if(count($data) > 0) { 
				      		foreach($data as $key=>$patients){ //debug($patients['ReminderPatientList']['id']);
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							    
							       $dat=$data[$key]['ReminderPatientList']['reminder_sent_date'];
							       $date1 = new DateTime($dat);
							       $date2 = new DateTime();
							       $interval = $date1->diff($date2);
							       $days=$interval->days; 

							       		if(empty($patients['ReminderPatientList']['id'])){
										$displayRed='block';
										$displayGreen='none';
										
										$action='';
										$cursor='cursor:not-allowed';
										
										$actionGrey='block';
										$actionRed='none';
										$noactionRed='none';
									}else{
										$displayRed='none';
										$displayGreen='block';
										$actionGrey='block';
										$action='tookAction';
										$cursor='';
										
										if($patients['ReminderPatientList']['reminder_followup_taken']=='Yes'){
											$actionRed='none';
											$noactionRed='block';
											$actionGrey='none';
										}else{
												if($days >=4){
													$actionRed='block';
													$actionGrey='none';
												}else{
													$actionRed='none';
													$actionGrey='block';
												}
											//$actionRed='none';
											$noactionRed='none';
											
										}
										
									}
								  ?>	
								   <td class="row_format"><?php echo ucfirst($patients['Person']['first_name']) .' '.ucfirst($patients['Person']['last_name']); ?></td>
								   <?php $dob=$this->DateFormat->formatDate2LocalForReport($patients['Person']['dob'],Configure::read('date_format'),true);?>
								    <?php 
								   if($patients['Patient']['age']=='0' || empty($patients['Patient']['age'])){
										$age=$this->General->getCurrentAge($patients['Person']['dob']);
									}else{
										$age=$patients['Patient']['age'];
									}
								   ?>
								   <td class="row_format"><?php echo $dob."</br>".rtrim($age,"Years "); ?></td>
								  
								   <td class="row_format"><?php echo $patients['Person']['patient_uid']; ?></td>
						<!-- 		   <td class="row_format"><?php echo $patients['Person']['sex']; ?></td> -->
								   <td class="row_format"><?php echo $patients['Person']['person_local_number']; ?></td>
								   
								   
								   <td class="row_format reminder" id="rem_<?php echo $patients['Person']['id']?>"> 
								   <?php echo $this->Html->image('icons/red.png',array('title'=>'','class'=>'reminderSent','id'=>'reminderSentr_'.$patients['Person']['id'],'style'=>'display:'.$displayRed)); ?>
								   <?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed; display:'.$displayGreen,'title'=>'','class'=>'','id'=>'reminderSentg_'.$patients['Person']['id'])); ?>
								 
								   </td>
								 
								   <td class="row_format" id="script_<?php echo $patients['Person']['id']?>"><?php echo $this->Form->input('phone_reminder_script', array('type'=>'text','class'=>'phoneReminderScript','id' => 'phoneReminderScript_'.$patients['Person']['id'], 'label'=> false, 'div' => false, 'error' => false,'value'=>$patients['ReminderPatientList']['phone_reminder_script']));?> </td> 
								  
								   <td></td>
								  
								   <td class="row_format" id="action_<?php echo $patients['Person']['id']?>" >
								   <?php echo $this->Html->image('icons/grey.png',array('style'=>$cursor,'title'=>'','class'=>$action,'id'=>'tookActionr_'.$patients['Person']['id'],'style'=>'display:'.$actionGrey)); ?>
								   <?php echo $this->Html->image('icons/red.png',array('style'=>$cursor,'title'=>'','class'=>'','id'=>'tookActionr_'.$patients['Person']['id'],'style'=>'display:'.$actionRed)); ?>
								   <?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed; display:'.$noactionRed,'title'=>'','class'=>'','id'=>'tookActiong_'.$patients['Person']['id'])); ?>
								   </td>
								  
								  
								  
								   <!-- <td class="row_format" id="noaction_<?php echo $patients['Person']['id']?>" style="display: <?php echo $noactionRed;?>"><?php echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'','class'=>'','id'=>'tookActiong_'.$patients['Person']['id'])); ?></td> -->
								
								
								 
								  </tr>
					  <?php } 
					 		$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 	
					   ?>
					   <tr>
					    <TD colspan="8" align="center">
							 <!-- Shows the page numbers -->
							 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
							 <!-- Shows the next and previous links -->
							 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
							 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
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
			 	
			</div>
		<!-- End Patient Details -->

		<!-- Admission -->
		 <?php $activeTab2 = ($this->params->query['flag'] == 'tab2') ? 'active' : '';?>
	        <div id="tab2" class="tab <?php echo $activeTab2;?>">
	           
	           <?php 			 	
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
  
<!-- <div class="clr">&nbsp;</div>
<div class="">
<h3> &nbsp;<?php /* echo __('Patient Reminder', true); */ if($this->params->query[flag]=='cancer'){echo "- Cervical cancer screening"; }elseif($this->params->query[flag]=='influenza'){echo "- Influenza vaccination"; }
elseif($this->params->query[flag]=='smoking'){echo "- Smoking"; }elseif($this->params->query[flag]=='diabetes'){echo "- Diabetes"; }elseif($this->params->query[flag]=='depression'){echo "- Depression"; }elseif($this->params->query[flag]=='highbp'){echo "- High Blood Pressure"; }else {}?></h3>

</div> -->
<br/>

<?php echo $this->Form->create(null,array('action'=>'patient_reminder','type'=>'get'));?>	
<?php echo $this->Form->hidden('flag',array('value'=>$this->params->query['flag']));?>
<table border="0" class=" "  cellpadding="0" cellspacing="0" width="500px" align="center" style="padding-right: 10px" >
	<tbody>
		<tr class="row_title" >				 
			<td class=" " align="right" width=" "><label><?php echo __('First Name :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('first_name', array('id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			<td class=" " align="right" width=" "><label><?php echo __('Last Name :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('last_name', array('id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			<td class=" " align="right"><label><?php echo __('Gender :') ?> </label></td>
			<td class=" "><?php echo    $this->Form->input('gender', array('type'=>'select','options'=>array(''=>'select','Male'=>'Male','Female'=>'Female'),'id' => 'gender', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));?></td>
		  	<td class=" " align="right"><label><?php echo __('Age :') ?></label></td>
		  	<?php //$optn = array('10'=>'10','20'=>'20','30'=>'30','40'=>'40','50'=>'50','60'=>'60','70'=>'70','80'=>'80','90'=>'90');?>
			<td class=" "><?php echo    $this->Form->input('agefrom', array('type'=>'text','id' => 'agefrom', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:50px'));?></td>
			<td class=" " align="center"><label align="center"><?php echo __('To') ?></label></td>
			<td class=" "><?php echo    $this->Form->input('ageto', array('type'=>'text','id' => 'ageto', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:50px'));?></td>
		
		</tr>
		
		<tr class="row_title" >		
			
				 
			<td class=" " align="right" width=" "><label><?php echo __('Zip Code :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('zip_code', array('id' => 'zip_code', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
			<td class=" " align="right" width=" "><label><?php echo __('City :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('city', array('id' => 'city', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
			<td class=" " align="right"><label><?php echo __('State :') ?> </label></td>
			<td class=" "><?php echo    $this->Form->input('state', array('type'=>'select','options'=>$newState,'empty'=>'select','id' => 'state', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));?></td>
		  
		  	<td class=" " align="right" width=" "><label><?php echo __('Ward :') ?> </label></td> 
			<td class=" "><?php echo    $this->Form->input('ward', array('id' => 'ward', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td>
			</td> 
			
		  	<td class=" " align="right" width=" "><label><?php echo __('Panchayat :') ?> </label></td> 
			<td class=" "><?php echo    $this->Form->input('panchayat', array('id' => 'panchayat', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
		</tr>
		
		<tr>	
			<td colspan="9" align="right" style="padding-top: 10px"  >
				<?php echo $this->Html->link(__('Reset'),array('controller'=>'corporates', 'action'=>'patient_reminder','?'=>array('flag'=>$this->params->query['flag']), 'admin' => false), array('id'=>'reset','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn', 'style'=>'text-decoration:none' ));?>
			</td>
			<td align="right" style="padding-top: 10px; padding-left: 10px"  >
				<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	?>
			</td>
		 </tr>	
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
 
 
<div class="clr inner_title" style="text-align:right;padding-bottom: 10px;">
<?php echo $this->Html->link('Excel Report',array('controller'=>'corporates','action'=>'patient_reminder','?'=>array('flag'=>'tab2','type'=>'excel')),array('id'=>'excel_report','class'=>'blueBtn'));?> </div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" id="load">
<?php //debug(count($data));?>
<?php if(isset($data) && !empty($data)){
	
	//set get variables to pagination url 
				//$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
	?>
			 
				  <tr class="row_title">
					   <td class="table_cell"><strong><?php echo  __('Patient\'s Name', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Age'.'</br>'.'Date of Birth', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Patient ID', true); ?></strong></td>
                  <!--      <td class="table_cell"><strong><?php echo  __('Sex', true); ?></strong></td> -->
                       <td class="table_cell"><strong><?php echo  __('Patient\'s Phone number', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Reminded', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Script  of phone reminders', true); ?></strong></td>
                        <td class="table_cell"><strong><?php echo  __('Review Date', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Patient attended', true); ?></strong></td>
					  
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
							       
							       $date1=$data['ReminderPatientList']['reminder_sent_date'];
							       $date2=date('Y-m-d');
							       $diff=date_diff($date1,$date2); debug($diff);
							       
							       if(empty($patients['ReminderPatientList']['id'])){
										$displayRed='block';
										$displayGreen='none';
										
										$action='';
										$cursor='cursor:not-allowed';
										
										$actionGrey='block';
										$actionRed='none';
										$noactionRed='none';
									}else{
										$displayRed='none';
										$displayGreen='block';
										$actionGrey='block';
										$action='tookAction';
										$cursor='';
										
										if($patients['ReminderPatientList']['reminder_followup_taken']=='Yes'){
											$actionRed='none';
											$noactionRed='block';
											$actionGrey='none';
										}else{
											$actionRed='none';
											$noactionRed='none';
											$actionGrey='block';
										}
										
									}
								  ?>	
								   <td class="row_format"><?php echo ucfirst($patients['Person']['first_name']) .' '.ucfirst($patients['Person']['last_name']); ?></td>
								   <?php $dob=$this->DateFormat->formatDate2LocalForReport($patients['Person']['dob'],Configure::read('date_format'),true);?>
								    <?php 
								   if($patients['Patient']['age']=='0' || empty($patients['Patient']['age'])){
										$age=$this->General->getCurrentAge($patients['Person']['dob']);
									}else{
										$age=$patients['Patient']['age'];
									}
								   ?>
								   <td class="row_format"><?php echo $dob."</br>".rtrim($age,"Years "); ?></td>
								  
								   <td class="row_format"><?php echo $patients['Person']['patient_uid']; ?></td>
						<!-- 		   <td class="row_format"><?php echo $patients['Person']['sex']; ?></td> -->
								   <td class="row_format"><?php echo $patients['Person']['person_local_number']; ?></td>
								   
								   
								   <td class="row_format reminder" id="rem_<?php echo $patients['Person']['id']?>"> 
								   <?php echo $this->Html->image('icons/red.png',array('title'=>'','class'=>'reminderSent','id'=>'reminderSentr_'.$patients['Person']['id'],'style'=>'display:'.$displayRed)); ?>
								   <?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed; display:'.$displayGreen,'title'=>'','class'=>'','id'=>'reminderSentg_'.$patients['Person']['id'])); ?>
								   </td>
								 
								   <td class="row_format" id="script_<?php echo $patients['Person']['id']?>"><?php echo $this->Form->input('phone_reminder_script', array('type'=>'text','class'=>'phoneReminderScript','id' => 'phoneReminderScript_'.$patients['Person']['id'], 'label'=> false, 'div' => false, 'error' => false,'value'=>$patients['ReminderPatientList']['phone_reminder_script']));?> </td> 
								  
								   <td></td>
								  
								   <td class="row_format" id="action_<?php echo $patients['Person']['id']?>" >
								   <?php echo $this->Html->image('icons/grey.png',array('style'=>$cursor,'title'=>'','class'=>$action,'id'=>'tookActionr_'.$patients['Person']['id'],'style'=>'display:'.$actionGrey)); ?>
								   <?php echo $this->Html->image('icons/red.png',array('style'=>$cursor,'title'=>'','class'=>'','id'=>'tookActionr_'.$patients['Person']['id'],'style'=>'display:'.$actionRed)); ?>
								   <?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed; display:'.$noactionRed,'title'=>'','class'=>'','id'=>'tookActiong_'.$patients['Person']['id'])); ?>
								   </td>
								  
								  
								   <!-- <td class="row_format" id="noaction_<?php echo $patients['Person']['id']?>" style="display: <?php echo $noactionRed;?>"><?php echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'','class'=>'','id'=>'tookActiong_'.$patients['Person']['id'])); ?></td> -->
								
								
								 
								  </tr>
					  <?php } 
					 		$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 	
					   ?>
					   <tr>
					    <TD colspan="8" align="center">
							 <!-- Shows the page numbers -->
							 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
							 <!-- Shows the next and previous links -->
							 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
							 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
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
			
			 </div>
		<!-- #End Admission -->
		 
		 <!-- Patient History -->
		  <?php $activeTab3 = ($this->params->query['flag'] == 'tab3') ? 'active' : '';?>
	        <div id="tab3" class="tab <?php echo $activeTab3;?>">
	            
	            <?php 			 	
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
  
<!-- <div class="clr">&nbsp;</div> -->
<!--<div class="">
 <h3> &nbsp;<?php /* echo __('Patient Reminder', true); */ if($this->params->query[flag]=='cancer'){echo "- Cervical cancer screening"; }elseif($this->params->query[flag]=='influenza'){echo "- Influenza vaccination"; }
elseif($this->params->query[flag]=='smoking'){echo "- Smoking"; }elseif($this->params->query[flag]=='diabetes'){echo "- Diabetes"; }elseif($this->params->query[flag]=='depression'){echo "- Depression"; }elseif($this->params->query[flag]=='highbp'){echo "- High Blood Pressure"; }else {}?></h3>

</div> -->
<br/>

<?php echo $this->Form->create(null,array('action'=>'patient_reminder','type'=>'get'));?>	
<?php echo $this->Form->hidden('flag',array('value'=>$this->params->query['flag']));?>
<table border="0" class=" "  cellpadding="0" cellspacing="0" width="500px" align="center" style="padding-right: 10px" >
	<tbody>
		<tr class="row_title" >				 
			<td class=" " align="right" width=" "><label><?php echo __('First Name :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('first_name', array('id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			<td class=" " align="right" width=" "><label><?php echo __('Last Name :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('last_name', array('id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			<td class=" " align="right"><label><?php echo __('Gender :') ?> </label></td>
			<td class=" "><?php echo    $this->Form->input('gender', array('type'=>'select','options'=>array(''=>'select','Male'=>'Male','Female'=>'Female'),'id' => 'gender', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));?></td>
		  	<td class=" " align="right"><label><?php echo __('Age :') ?></label></td>
		  	<?php //$optn = array('10'=>'10','20'=>'20','30'=>'30','40'=>'40','50'=>'50','60'=>'60','70'=>'70','80'=>'80','90'=>'90');?>
			<td class=" "><?php echo    $this->Form->input('agefrom', array('type'=>'text','id' => 'agefrom', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:50px'));?></td>
			<td class=" " align="center"><label align="center"><?php echo __('To') ?></label></td>
			<td class=" "><?php echo    $this->Form->input('ageto', array('type'=>'text','id' => 'ageto', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:50px'));?></td>
		
		</tr>
		
		<tr class="row_title" >		
			
				 
			<td class=" " align="right" width=" "><label><?php echo __('Zip Code :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('zip_code', array('id' => 'zip_code', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
			<td class=" " align="right" width=" "><label><?php echo __('City :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('city', array('id' => 'city', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
			<td class=" " align="right"><label><?php echo __('State :') ?> </label></td>
			<td class=" "><?php echo    $this->Form->input('state', array('type'=>'select','options'=>$newState,'empty'=>'select','id' => 'state', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));?></td>
		  
		  	<td class=" " align="right" width=" "><label><?php echo __('Ward :') ?> </label></td> 
			<td class=" "><?php echo    $this->Form->input('ward', array('id' => 'ward', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td>
			</td> 
			
		  	<td class=" " align="right" width=" "><label><?php echo __('Panchayat :') ?> </label></td> 
			<td class=" "><?php echo    $this->Form->input('panchayat', array('id' => 'panchayat', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
		</tr>
		
		<tr>	
			<td colspan="9" align="right" style="padding-top: 10px"  >
				<?php echo $this->Html->link(__('Reset'),array('controller'=>'corporates', 'action'=>'patient_reminder','?'=>array('flag'=>$this->params->query['flag']), 'admin' => false), array('id'=>'reset','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn', 'style'=>'text-decoration:none' ));?>
			</td>
			<td align="right" style="padding-top: 10px; padding-left: 10px"  >
				<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	?>
			</td>
		 </tr>	
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
 
 
<div class="clr inner_title" style="text-align:right;padding-bottom: 10px;">
<?php echo $this->Html->link('Excel Report',array('controller'=>'corporates','action'=>'patient_reminder','?'=>array('flag'=>'tab3','type'=>'excel')),array('id'=>'excel_report','class'=>'blueBtn'));?> </div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" id="load">
<?php //debug(count($data));?>
<?php if(isset($data) && !empty($data)){
	
	//set get variables to pagination url 
				//$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
	?>
			 
				  <tr class="row_title">
					   <td class="table_cell"><strong><?php echo  __('Patient\'s Name', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Age'.'</br>'.'Date of Birth', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Patient ID', true); ?></strong></td>
                     <!--   <td class="table_cell"><strong><?php echo  __('Sex', true); ?></strong></td> -->
                       <td class="table_cell"><strong><?php echo  __('Patient\'s Phone number', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Reminded', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Script  of phone reminders', true); ?></strong></td>
                        <td class="table_cell"><strong><?php echo  __('Review Date', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Patient attended', true); ?></strong></td>
					  
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
						
							       $date1=$data['ReminderPatientList']['reminder_sent_date'];
							       $date2=date('Y-m-d');
							       $diff=date_diff($date1,$date2);
							       
							       if(empty($patients['ReminderPatientList']['id'])){
										$displayRed='block';
										$displayGreen='none';
										
										$action='';
										$cursor='cursor:not-allowed';
										
										$actionGrey='block';
										$actionRed='none';
										$noactionRed='none';
									}else{
										$displayRed='none';
										$displayGreen='block';
										$actionGrey='block';
										$action='tookAction';
										$cursor='';
										
										if($patients['ReminderPatientList']['reminder_followup_taken']=='Yes'){
											$actionRed='none';
											$noactionRed='block';
											$actionGrey='none';
										}else{
											$actionRed='none';
											$noactionRed='none';
											$actionGrey='block';
										}
										
									}
								  ?>	
								   <td class="row_format"><?php echo ucfirst($patients['Person']['first_name']) .' '.ucfirst($patients['Person']['last_name']); ?></td>
								   <?php $dob=$this->DateFormat->formatDate2LocalForReport($patients['Person']['dob'],Configure::read('date_format'),true);?>
								    <?php 
								   if($patients['Patient']['age']=='0' || empty($patients['Patient']['age'])){
										$age=$this->General->getCurrentAge($patients['Person']['dob']);
									}else{
										$age=$patients['Patient']['age'];
									}
								   ?>
								   <td class="row_format"><?php echo $dob."</br>".rtrim($age,"Years "); ?></td>
								  
								   <td class="row_format"><?php echo $patients['Person']['patient_uid']; ?></td>
							<!-- 	   <td class="row_format"><?php echo $patients['Person']['sex']; ?></td> -->
								   <td class="row_format"><?php echo $patients['Person']['person_local_number']; ?></td>
								   
								   
								   <td class="row_format reminder" id="rem_<?php echo $patients['Person']['id']?>"> 
								   <?php echo $this->Html->image('icons/red.png',array('title'=>'','class'=>'reminderSent','id'=>'reminderSentr_'.$patients['Person']['id'],'style'=>'display:'.$displayRed)); ?>
								   <?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed; display:'.$displayGreen,'title'=>'','class'=>'','id'=>'reminderSentg_'.$patients['Person']['id'])); ?>
								   </td>
								 
								   <td class="row_format" id="script_<?php echo $patients['Person']['id']?>"><?php echo $this->Form->input('phone_reminder_script', array('type'=>'text','class'=>'phoneReminderScript','id' => 'phoneReminderScript_'.$patients['Person']['id'], 'label'=> false, 'div' => false, 'error' => false,'value'=>$patients['ReminderPatientList']['phone_reminder_script']));?> </td> 
								  
								   <td></td>
								  
								   <td class="row_format" id="action_<?php echo $patients['Person']['id']?>" >
								   <?php echo $this->Html->image('icons/grey.png',array('style'=>$cursor,'title'=>'','class'=>$action,'id'=>'tookActionr_'.$patients['Person']['id'],'style'=>'display:'.$actionGrey)); ?>
								   <?php echo $this->Html->image('icons/red.png',array('style'=>$cursor,'title'=>'','class'=>'','id'=>'tookActionr_'.$patients['Person']['id'],'style'=>'display:'.$actionRed)); ?>
								   <?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed; display:'.$noactionRed,'title'=>'','class'=>'','id'=>'tookActiong_'.$patients['Person']['id'])); ?>
								   </td>
								  
								  
								   <!-- <td class="row_format" id="noaction_<?php echo $patients['Person']['id']?>" style="display: <?php echo $noactionRed;?>"><?php echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'','class'=>'','id'=>'tookActiong_'.$patients['Person']['id'])); ?></td> -->
								
								
								 
								  </tr>
					  <?php } 
					 		$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 	
					   ?>
					   <tr>
					    <TD colspan="8" align="center">
							 <!-- Shows the page numbers -->
							 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
							 <!-- Shows the next and previous links -->
							 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
							 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
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
			
	            
			 </div>
		<!-- #End Patient History -->
		
		<!-- Clinical Finding -->
		<?php $activeTab4 = ($this->params->query['flag'] == 'tab4') ? 'active' : '';?>
	        <div id="tab4" class="tab <?php $activeTab4;?>">
	            <?php 			 	
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
<div class="">
<h3> &nbsp;<?php /* echo __('Patient Reminder', true); */ if($this->params->query[flag]=='cancer'){echo "- Cervical cancer screening"; }elseif($this->params->query[flag]=='influenza'){echo "- Influenza vaccination"; }
elseif($this->params->query[flag]=='smoking'){echo "- Smoking"; }elseif($this->params->query[flag]=='diabetes'){echo "- Diabetes"; }elseif($this->params->query[flag]=='depression'){echo "- Depression"; }elseif($this->params->query[flag]=='highbp'){echo "- High Blood Pressure"; }else {}?></h3>

</div>
<br/>

<?php echo $this->Form->create(null,array('action'=>'patient_reminder','type'=>'get'));?>	
<?php echo $this->Form->hidden('flag',array('value'=>$this->params->query['flag']));?>
<table border="0" class=" "  cellpadding="0" cellspacing="0" width="500px" align="center" style="padding-right: 10px" >
	<tbody>
		<tr class="row_title" >				 
			<td class=" " align="right" width=" "><label><?php echo __('First Name :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('first_name', array('id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			<td class=" " align="right" width=" "><label><?php echo __('Last Name :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('last_name', array('id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			<td class=" " align="right"><label><?php echo __('Gender :') ?> </label></td>
			<td class=" "><?php echo    $this->Form->input('gender', array('type'=>'select','options'=>array(''=>'select','Male'=>'Male','Female'=>'Female'),'id' => 'gender', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));?></td>
		  	<td class=" " align="right"><label><?php echo __('Age :') ?></label></td>
		  	<?php //$optn = array('10'=>'10','20'=>'20','30'=>'30','40'=>'40','50'=>'50','60'=>'60','70'=>'70','80'=>'80','90'=>'90');?>
			<td class=" "><?php echo    $this->Form->input('agefrom', array('type'=>'text','id' => 'agefrom', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:50px'));?></td>
			<td class=" " align="center"><label align="center"><?php echo __('To') ?></label></td>
			<td class=" "><?php echo    $this->Form->input('ageto', array('type'=>'text','id' => 'ageto', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:50px'));?></td>
		
		</tr>
		
		<tr class="row_title" >		
			
				 
			<td class=" " align="right" width=" "><label><?php echo __('Zip Code :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('zip_code', array('id' => 'zip_code', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
			<td class=" " align="right" width=" "><label><?php echo __('City :') ?></label></td> 
			<td class=" "> <?php echo    $this->Form->input('city', array('id' => 'city', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
			<td class=" " align="right"><label><?php echo __('State :') ?> </label></td>
			<td class=" "><?php echo    $this->Form->input('state', array('type'=>'select','options'=>$newState,'empty'=>'select','id' => 'state', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));?></td>
		  
		  	<td class=" " align="right" width=" "><label><?php echo __('Ward :') ?> </label></td> 
			<td class=" "><?php echo    $this->Form->input('ward', array('id' => 'ward', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td>
			</td> 
			
		  	<td class=" " align="right" width=" "><label><?php echo __('Panchayat :') ?> </label></td> 
			<td class=" "><?php echo    $this->Form->input('panchayat', array('id' => 'panchayat', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td> 
			
		</tr>
		
		<tr>	
			<td colspan="9" align="right" style="padding-top: 10px"  >
				<?php echo $this->Html->link(__('Reset'),array('controller'=>'corporates', 'action'=>'patient_reminder','?'=>array('flag'=>$this->params->query['flag']), 'admin' => false), array('id'=>'reset','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn', 'style'=>'text-decoration:none' ));?>
			</td>
			<td align="right" style="padding-top: 10px; padding-left: 10px"  >
				<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	?>
			</td>
		 </tr>	
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
 
 
<div class="clr inner_title" style="text-align:right;padding-bottom: 10px;">
<?php echo $this->Html->link('Excel Report',array('controller'=>'corporates','action'=>'patient_reminder','?'=>array('flag'=>'tab4','type'=>'excel')),array('id'=>'excel_report','class'=>'blueBtn'));?> </div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" id="load">
<?php //debug(count($data));?>
<?php if(isset($data) && !empty($data)){
	
	//set get variables to pagination url 
				//$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
	?>
			 
				  <tr class="row_title">
					   <td class="table_cell"><strong><?php echo  __('Patient\'s Name', true); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Age'.'</br>'.'Date of Birth', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Patient ID', true); ?></strong></td>
                 <!--       <td class="table_cell"><strong><?php echo  __('Sex', true); ?></strong></td> -->
                       <td class="table_cell"><strong><?php echo  __('Patient\'s Phone number', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Reminded', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Script  of phone reminders', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Review Date', true); ?></strong></td>
                       <td class="table_cell"><strong><?php echo  __('Patient attended', true); ?></strong></td>
					  
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
							       
							       $date1=$data['ReminderPatientList']['reminder_sent_date'];
							       $date2=date('Y-m-d');
							       $diff=date_diff($date1,$date2); debug($diff);
							       
							       if(empty($patients['ReminderPatientList']['id'])){
										$displayRed='block';
										$displayGreen='none';
										
										$action='';
										$cursor='cursor:not-allowed';
										
										$actionGrey='block';
										$actionRed='none';
										$noactionRed='none';
									}else{
										$displayRed='none';
										$displayGreen='block';
										$actionGrey='block';
										$action='tookAction';
										$cursor='';
										
										if($patients['ReminderPatientList']['reminder_followup_taken']=='Yes'){
											$actionRed='none';
											$noactionRed='block';
											$actionGrey='none';
										}else{
											$actionRed='none';
											$noactionRed='none';
											$actionGrey='block';
										}
										
									}
								  ?>	
								   <td class="row_format"><?php echo ucfirst($patients['Person']['first_name']) .' '.ucfirst($patients['Person']['last_name']); ?></td>
								   <?php $dob=$this->DateFormat->formatDate2LocalForReport($patients['Person']['dob'],Configure::read('date_format'),true);?>
								    <?php 
								   if($patients['Patient']['age']=='0' || empty($patients['Patient']['age'])){
										$age=$this->General->getCurrentAge($patients['Person']['dob']);
									}else{
										$age=$patients['Patient']['age'];
									}
								   ?>
								   <td class="row_format"><?php echo $dob."</br>".rtrim($age,"Years "); ?></td>
								  
								   <td class="row_format"><?php echo $patients['Person']['patient_uid']; ?></td>
							<!-- 	   <td class="row_format"><?php echo $patients['Person']['sex']; ?></td> -->
								   <td class="row_format"><?php echo $patients['Person']['person_local_number']; ?></td>
								   
								   
								   <td class="row_format reminder" id="rem_<?php echo $patients['Person']['id']?>"> 
								   <?php echo $this->Html->image('icons/red.png',array('title'=>'','class'=>'reminderSent','id'=>'reminderSentr_'.$patients['Person']['id'],'style'=>'display:'.$displayRed)); ?>
								   <?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed; display:'.$displayGreen,'title'=>'','class'=>'','id'=>'reminderSentg_'.$patients['Person']['id'])); ?>
								  
								   </td>
								 
								   <td class="row_format" id="script_<?php echo $patients['Person']['id']?>"><?php echo $this->Form->input('phone_reminder_script', array('type'=>'text','class'=>'phoneReminderScript','id' => 'phoneReminderScript_'.$patients['Person']['id'], 'label'=> false, 'div' => false, 'error' => false,'value'=>$patients['ReminderPatientList']['phone_reminder_script']));?> </td> 
								  
								   <td></td>
								  
								   <td class="row_format" id="action_<?php echo $patients['Person']['id']?>" >
								   <?php echo $this->Html->image('icons/grey.png',array('style'=>$cursor,'title'=>'','class'=>$action,'id'=>'tookActionr_'.$patients['Person']['id'],'style'=>'display:'.$actionGrey)); ?>
								   <?php echo $this->Html->image('icons/red.png',array('style'=>$cursor,'title'=>'','class'=>'','id'=>'tookActionr_'.$patients['Person']['id'],'style'=>'display:'.$actionRed)); ?>
								   <?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed; display:'.$noactionRed,'title'=>'','class'=>'','id'=>'tookActiong_'.$patients['Person']['id'])); ?>
								   </td>
								  
								  
								   <!-- <td class="row_format" id="noaction_<?php echo $patients['Person']['id']?>" style="display: <?php echo $noactionRed;?>"><?php echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'','class'=>'','id'=>'tookActiong_'.$patients['Person']['id'])); ?></td> -->
								
								
								 
								  </tr>
					  <?php } 
					 		$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 	
					   ?>
					   <tr>
					    <TD colspan="8" align="center">
							 <!-- Shows the page numbers -->
							 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
							 <!-- Shows the next and previous links -->
							 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
							 <!-- prints X of Y, where X is current page and Y is number of pages -->
							 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
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
			
			 </div>
		<!-- #End Clinical Finding -->
		

    </div>

    </div>





<script>
	jQuery(document).ready(function() {
	    jQuery('.tabs .tab-links a').on('click', function(e)  {
	        var currentAttrValue = jQuery(this).attr('href');
	     
	        // Show/Hide Tabs
	        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
	 
	        // Change/remove current tab to active
	        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
	        e.preventDefault();
	        if(currentAttrValue=="#tab1"){
	        	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "corporates", "action" => "patient_reminder","?"=>"flag=tab1")); ?>";
	        }
	        else if(currentAttrValue=="#tab2"){
	        	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "corporates", "action" => "patient_reminder","?"=>"flag=tab2")); ?>";
	        }
	        else if(currentAttrValue=="#tab3"){
	        	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "corporates", "action" => "patient_reminder","?"=>"flag=tab3")); ?>";
	        }
	        else if(currentAttrValue=="#tab4"){
	        	var ajaxUrl="<?php echo $this->Html->url(array("controller" => "corporates", "action" => "patient_reminder","?"=>"flag=tab4")); ?>";
	        }
	        else{
		        return false;
	        }
	        $.ajax({
	         	beforeSend : function() {
	         		$('#busy-indicator').show('fast');
	         	},
	         	type: 'POST',
	         	url: ajaxUrl,
	         	dataType: 'html',
	         	//data:formData,
	         	success: function(data){
	         		$('#loadMenu').hide();
	         		$('#busy-indicator').hide('fast');
	         		
	         		var loadID=currentAttrValue.split('#');
	         		$('#'+loadID[1]).html(data);
	         		window.location.href = ajaxUrl;
	      	        	},
	      	  });
	      	  	
	    });
	});

$(".reminderSent").click(function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	recordId = splittedVar[1]; 
	//value = $(this).val();
//$('#pharmacy_id_'+Id).html();
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "corporates", "action" => "savePatientReminder", "admin" => false)); ?>"+"/"+recordId,
			  context: document.body,	
			  //data : "value="+value,
			  beforeSend:function(){
				  loading('load','id');
			  }, 	  		  
			  success: function(data){					  
				  //$('#busy-indicator').hide('fast');
				  inlineMsg(currentId,'Reminded Successfully.');
				  $("#reminderSentr_"+recordId).hide();
				  $("#reminderSentg_"+recordId).show();
				  
				  $("#tookActionr_"+recordId).addClass('tookAction');
				  $("#tookActionr_"+recordId).removeAttr("style");
				  //$("#reminderSentg_"+currentId).attr('src','../theme/Black/img/icons/green.png').attr('style','cursor:not-allowed;','title','Reminded','disabled','disabled').removeClass('reminderSent');
				  onCompleteRequest('load','id');
			  }
		});		 
});
$("#reminderSentg_").click(function(){
	$("#reminderSentg_").hide();
	$("#reminderSentO_").show();
	
});

$(document).on('click',".tookAction",function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	recordId = splittedVar[1];
	//value = $(this).val();
//$('#pharmacy_id_'+Id).html();
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "corporates", "action" => "savePatientReminderFollowup", "admin" => false)); ?>"+"/"+recordId,
			  context: document.body,	
			  //data : "value="+value,
			  beforeSend:function(){
				  loading('load','id');
			  }, 	  		  
			  success: function(data){					  
				  //$('#busy-indicator').hide('fast');
				  inlineMsg(currentId,'Patient FollowUp Taken.');
				  $("#tookActionr_"+recordId).hide();
				  $("#tookActiong_"+recordId).show();
				  //$("#"+currentId).attr('src','../theme/Black/img/icons/green.png').attr('style','cursor:not-allowed;','title','Reminded','disabled','disabled').removeClass('tookAction');
				  onCompleteRequest('load','id');
			  }
		});		 
});


$(".phoneReminderScript").on('focusout',function(){
	Id=$(this).attr('id');
	splittedVar = Id.split("_");		 
	personId = splittedVar[1];
	comment=$(this).val();
	if(comment !=''){
	 	$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "corporates", "action" => "savePatientScript", "admin" => false)); ?>"+"/"+personId+"/"+comment,
			  context: document.body,	
			  //data : "value="+value,
			  beforeSend:function(){
				  loading('load','id');
			  }, 	  		  
			  success: function(data){					  
				  //$('#busy-indicator').hide('fast');
				  //inlineMsg(Id,'Updated');
				 onCompleteRequest('load','id');
			  }
		});
	}else{
		//alert('Please Enter Phone Reminder.');
		return false;
	}
});

//Transmit Ccda

			$(function(){

				//alert('<?php echo $this->params->query['flag'];?>');
				  if('<?php echo $this->params->query['flag'];?>'=='cancer'){
					  $("#gender").val('Female');
					  $("#agefrom").val('21');
					  $("#ageto").val('65');
					}
					
				$("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","first_name",'null','null','null','admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});
				$("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","last_name",'null','null','null','admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});
				$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});
				$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});
				$("#ward").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","landmark",'null','null','null','admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});
				$("#panchayat").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","taluka",'null','null','null','admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				})
				
				$(".transmit").click(function(){
					 id= $(this).attr("id");
					 
					 var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "ccda", "action" => "isCcdaGenerated","admin" => false)); ?>";
				        $.ajax({
				          type: 'POST',
				          url: ajaxUrl+"/"+id,
				          data: '',
				          dataType: 'html',
				          success: function(data){
								if(data){
									$.fancybox({

										'width' : '60%',
										'height' : '50%',
										'autoScale' : true,
										'transitionIn' : 'fade',
										'transitionOut' : 'fade',
										'type' : 'iframe',
										'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "transmit_ccda")); ?>"
										+ '/' + id 
										});
								}else{
									alert("Please generate CCDA first.");
									return false ;
								}
						  },
						  error: function(message){
				              alert(message);
				          }        
				       });


				          return false ;
				
				});
				 
		 	});
		 	

	
</script>
