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
<h3> &nbsp;<?php echo __('Patient Reminder', true); if($this->params->query[flag]=='cancer'){echo "- Cervical cancer screening"; }elseif($this->params->query[flag]=='influenza'){echo "- Influenza vaccination"; }
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
		  
		  	<td class=" " align="right" width=" ">&nbsp;</td> 
			<td class=" ">&nbsp;</td> 
			
		  	<td class=" " align="right" width=" ">&nbsp;</td> 
			<td class=" ">&nbsp;</td> 
			
		</tr>
		
		<tr>	
			<td colspan="9" align="right" style="padding-top: 10px"  >
				<?php echo $this->Html->link(__('Reset'),array('controller'=>'MeaningfulReport', 'action'=>'patient_reminder','?'=>array('flag'=>$this->params->query['flag']), 'admin' => false), array('id'=>'reset','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn', 'style'=>'text-decoration:none' ));?>
			</td>
			<td align="right" style="padding-top: 10px; padding-left: 10px"  >
				<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	?>
			</td>
		 </tr>	
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
 
 
<div class="clr inner_title" style="text-align:right;">
<?php echo $this->Html->link('Excel Report',array('controller'=>'MeaningfulReport','action'=>'patient_reminder','?'=>array('flag'=>$this->params->query['flag'],'type'=>'excel')),array('id'=>'excel_report','class'=>'blueBtn'));?> </div>
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
										$displayRed='block';
										$displayGreen='none';
										
										$action='';
										$cursor='cursor:not-allowed';
										
										$actionRed='block';
										$noactionRed='none';
									}else{
										$displayRed='none';
										$displayGreen='block';
										
										$action='tookAction';
										$cursor='';
										
										if($patients['ReminderPatientList']['reminder_followup_taken']=='Yes'){
											$actionRed='none';
											$noactionRed='block';
										}else{
											$actionRed='block';
											$noactionRed='none';
										}
										
									}
								  ?>	
								   <td class="row_format"><?php echo ucfirst($patients['Person']['first_name']) .' '.ucfirst($patients['Person']['last_name']); ?></td>
								   <?php $dob=$this->DateFormat->formatDate2LocalForReport($patients['Person']['dob'],Configure::read('date_format'),true);?>
								   <td class="row_format"><?php echo $dob; ?></td>
								   <?php 
								   if($patients['Patient']['age']=='0' || empty($patients['Patient']['age'])){
										$age=$this->General->getCurrentAge($patients['Person']['dob']);
									}else{
										$age=$patients['Patient']['age'];
									}
								   ?>
								   <td class="row_format"><?php echo rtrim($age,"Years "); ?></td>
								   <td class="row_format"><?php echo $patients['Patient']['sex']; ?></td>
								   <td class="row_format"><?php echo $patients['Person']['person_local_number']; ?></td>
								   
								   
								   <td class="row_format reminder" id="rem_<?php echo $patients['Person']['id']?>"> 
								   <?php echo $this->Html->image('icons/red.png',array('title'=>'','class'=>'reminderSent','id'=>'reminderSentr_'.$patients['Person']['id'],'style'=>'display:'.$displayRed)); ?>
								   <?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed; display:'.$displayGreen,'title'=>'','class'=>'','id'=>'reminderSentg_'.$patients['Person']['id'])); ?>
								   </td>
								 
								   <td class="row_format" id="script_<?php echo $patients['Person']['id']?>"><?php echo $this->Form->input('phone_reminder_script', array('type'=>'text','class'=>'phoneReminderScript','id' => 'phoneReminderScript_'.$patients['Person']['id'], 'label'=> false, 'div' => false, 'error' => false,'value'=>$patients['ReminderPatientList']['phone_reminder_script']));?> </td> 
								  
								   <td class="row_format" id="action_<?php echo $patients['Person']['id']?>" >
								   <?php echo $this->Html->image('icons/red.png',array('style'=>$cursor,'title'=>'','class'=>$action,'id'=>'tookActionr_'.$patients['Person']['id'],'style'=>'display:'.$actionRed)); ?>
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
<script>
$(".reminderSent").click(function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	recordId = splittedVar[1];
	//value = $(this).val();
//$('#pharmacy_id_'+Id).html();
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "MeaningfulReport", "action" => "savePatientReminder", "admin" => false)); ?>"+"/"+recordId+"/"+"<?php echo $this->params->query['flag']; ?>",
			  context: document.body,	
			  //data : "value="+value,
			  beforeSend:function(){
				  loading('load','id');
			  }, 	  		  
			  success: function(data){					  
				  //$('#busy-indicator').hide('fast');
				  inlineMsg(currentId,'Reminder sent Successfully.');
				  $("#reminderSentr_"+recordId).hide();
				  $("#reminderSentg_"+recordId).show();
				  
				  $("#tookActionr_"+recordId).addClass('tookAction');
				  $("#tookActionr_"+recordId).removeAttr("style");
				  //$("#reminderSentg_"+currentId).attr('src','../theme/Black/img/icons/green.png').attr('style','cursor:not-allowed;','title','Reminder Sent','disabled','disabled').removeClass('reminderSent');
				  onCompleteRequest('load','id');
			  }
		});		 
});


$(document).on('click',".tookAction",function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	recordId = splittedVar[1];
	//value = $(this).val();
//$('#pharmacy_id_'+Id).html();
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "MeaningfulReport", "action" => "savePatientReminderFollowup", "admin" => false)); ?>"+"/"+recordId+"/"+"<?php echo $this->params->query['flag']; ?>",
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
				  //$("#"+currentId).attr('src','../theme/Black/img/icons/green.png').attr('style','cursor:not-allowed;','title','Reminder Sent','disabled','disabled').removeClass('tookAction');
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
			  url: "<?php echo $this->Html->url(array("controller" => "MeaningfulReport", "action" => "savePatientScript", "admin" => false)); ?>"+"/"+personId+"/"+"<?php echo $this->params->query['flag']; ?>"+"/"+comment,
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
