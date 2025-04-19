<?php // debug($data);?>
<div class="">
	<div id="no_app">
		<?php
		if(empty($data)){
			echo "<span class='error'>";
			echo __('There is no scheduled OR.');
			echo "</span>";
		}
		?>
	</div>
	<?php if(!empty($data)){  ?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%"
		class="table_format" style="margin:0px">
		<tr class="row_title">
			<td width="2%" valign="top" class="table_cell">Patient</td>
			<td width="6%" valign="top" class="table_cell">Surgery</td>
			
			<td width="3%" valign="top" class="table_cell">Anaesthetist / <br/>Surgeon</td>
			
			<td width="3%" valign="top" class="table_cell">Room <br/>Table</td>
			<td width="1%" valign="top" class="table_cell">OT Complete</td>
			<td width="1%" valign="top" class="table_cell">Date Of Surgery <br/>In time <br/> Out time</td>
			<td width="1%" valign="top" class="table_cell">Anae. Consent Form</td>
			<td width="1%" valign="top" class="table_cell">Consent Form</td>
			<td width="1%" valign="top" class="table_cell">Surgery Consent Form</td>
			<td width="1%" valign="top" class="table_cell">Interpreter Stmt.</td>
			<td width="1%" valign="top" class="table_cell">Pt. Specific Consent Form</td>
			<td width="1%" valign="top" class="table_cell">Pre Operative Checklist</td>
			<!-- <td width="1%" valign="top" class="table_cell">Post Operative Checklist</td> -->
			<td width="1%" valign="top" class="table_cell">Surgical Safety Checklist</td>
			<!--  <td width="1%" valign="top" class="table_cell">Anae. Notes</td>
			<td width="1%" valign="top" class="table_cell">Surgery Notes</td>-->
			
			<td width="1%" valign="top" class="table_cell">Task</td>
			<?php /*?>
			<td width="1%" valign="top" class="table_cell">Transfer</td><?php */ ?> 
		</tr>
		<?php 
		$toggle =0;
		$i=0 ;
		$role  = $this->Session->read('role');
		foreach($data as $ot){
			$currentAppointment =  strtotime($this->DateFormat->formatDate2Local($ot['OptAppointment']['starttime'],Configure::read('date_format'), false));
			
			if($currentAppointment == strtotime(date('Y-m-d')) && $futureApp){
				return false;
			}
			   $i++;
			   if($toggle == 0) {
			       	echo "<tr class='row_gray'>";
			       	$toggle = 1;
		       }else{
			       	echo "<tr class='row_gray_dark'>";
			       	$toggle = 0;
		       }
		   

 			echo $this->Form->create('OptAppointment',array('action'=>'dashboard','default'=>false,'id'=>'otform')) ;
			?>

		<!--  <td align="left" valign="middle" style="text-align: left;">
		<?php echo $this->Html->link($ot['Patient']['lookup_name'],array('controller'=>'PatientsTrackReports','action'=>'sbar',$ot['Patient']['id']),
									array('style'=>'text-decoration:underline;padding:2px 0px;'));?>
		</td>-->
<td><?php   echo $ot['Patient']['lookup_name'];
//echo $this->Html->link($ot['Patient']['lookup_name'],array('controller'=>'OptAppointments','action'=>'patient_information',$ot['Patient']['id']));?>
</td>
		<td style="text-align: left;"><?php 
		if(!empty($ot['Preferencecard']['card_title'])){
							$PrefeText="<b>Pref. Card -</b>";
		}else{
							$PrefeText="";
		}
		
		echo ($ot['Surgery']['name'])."<br/>".$PrefeText.
				$this->Html->link($ot['Preferencecard']['card_title'],'javascript(void(0))',
						array('escape' => false ,'onclick'=>"var openWin = window.open('".$this->Html->url(array
								('controller'=>'Preferences','action'=>'print_preferencecard',$ot['OptAppointment']['preferencecard_id']
								))."','_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');
											        return false;"));
		;?>
		</td>
		
		<td valign="middle" style="text-align: left;" ><?php 
		/*$anaesthetistId = 'anaesthetist_'.$ot['OptAppointment']['id'];
		echo $this->Form->input('anaesthetist_id',array('style'=>'width:155px;','type'=>'select','options'=>$departmentlist,
					'empty'=>"Please Select",'value'=>$ot['OptAppointment']['department_id'],'class'=>'anaesthetist','id'=>$anaesthetistId,'label'=>false,'div'=>false));*/?>
					<?php echo __($departmentlist[$ot['OptAppointment']['department_id']])."<br/>".$doctorlist[$ot['OptAppointment']['doctor_id']];?>
		</td>
		
		
		
		
		<td style="text-align: left;"><?php echo ucfirst($ot['Opt']['name'])."<br/>".$ot['OptTable']['name']; ?>
		</td>
		
		<td style="text-align: left;"><?php $procedureId = 'procedure_'.$ot['OptAppointment']['id'];
		if($this->Session->read('website.instance') == 'kanpur')
			$disable = $ot['OptAppointment']['procedure_complete'] ? true : false;
		$disable = $futureApp ? true : $disable;
		echo $this->Form->input(null,array('name' => 'procedurecomplete', 'id'=> $procedureId, 'options'=> array('0' => 'No','1'=>'Yes'),
			 'label' => false, 'value'=>$ot ['OptAppointment']['procedure_complete'],'class'=>'procedure','disabled'=>$disable, 'patient_id'=>$ot['OptAppointment']['patient_id']));?>
		</td>
		<?php $surDate= $this->DateFormat->formatDate2Local($ot['OptAppointment']['schedule_date'],Configure::read('date_format'), true);
		
		?>
		
		
		<?php $inTime = ($ot['OptAppointment']['ot_in_date']) ? $ot['OptAppointment']['ot_in_date'] : $ot['OptAppointment']['starttime'];?>
		<?php $startDate= explode(" ",$this->DateFormat->formatDate2Local($inTime,Configure::read('date_format'), true));
		?>
		
		<?php $outTime = ($ot['OptAppointment']['out_date']) ? $ot['OptAppointment']['out_date'] : $ot['OptAppointment']['endtime'];?>
		<?php $endDate= explode(" ",$this->DateFormat->formatDate2Local($outTime,Configure::read('date_format'), true));
		?>
		
		<?php $optAppointmentId=$ot['OptAppointment']['id'];
			$optAppointmentPatientId=$ot['OptAppointment']['patient_id'];
		?>
		<td style="text-align: left;"><?php  echo $surDate."<br/>".date("H:i", strtotime($startDate['1']))."<br/>".date("H:i", strtotime($endDate['1'])); ?>
		</td>
		<td><?php if(!empty($ot["AnaesthesiaConsentForm"]["id"])){
			echo $this->Html->link($this->Html->image('icons/green.png'), array('controller'=>'opt_appointments','action' => 'anaesthesia_consent', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Anaesthesia Consent Form','target'=>'_blank'));
		}else{
			echo $this->Html->link($this->Html->image('icons/red.png'), array('controller'=>'opt_appointments','action' => 'anaesthesia_consent', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Anaesthesia Consent Form','target'=>'_blank'));
		}?></td>
		<td><?php if(!empty($ot["SurgeryConsentForm"]["id"])){
			echo $this->Html->link($this->Html->image('icons/green.png'), array('controller'=>'opt_appointments','action' => 'surgery_consent', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Consent Form','target'=>'_blank'));
		}else{
			echo $this->Html->link($this->Html->image('icons/red.png'), array('controller'=>'opt_appointments','action' => 'surgery_consent', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Consent Form','target'=>'_blank'));
		}?></td>
		
		<td><?php if(!empty($ot["ConsentForm"]["id"])){
		 	echo $this->Html->link($this->Html->image('icons/green.png'), array('controller'=>'opt_appointments','action' => 'surgery_consentform', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Surgery Consent Form','target'=>'_blank'));
		 }else{
			echo $this->Html->link($this->Html->image('icons/red.png'), array('controller'=>'opt_appointments','action' => 'surgery_consentform', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Surgery Consent Form','target'=>'_blank'));
			}?></td>
		
		<td><?php if(!empty($ot["InterpreterStatement"]["id"])){
			echo $this->Html->link($this->Html->image('icons/green.png'), array('controller'=>'opt_appointments','action' => 'interpreter_statement', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Interpreter Stmt.','target'=>'_blank'));
		}else{
			echo $this->Html->link($this->Html->image('icons/red.png'), array('controller'=>'opt_appointments','action' => 'interpreter_statement', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Interpreter Stmt.','target'=>'_blank'));
		}?></td>
		
		<td><?php if(!empty($ot["Consent"]["id"])){
			echo $this->Html->link($this->Html->image('icons/green.png'), array('controller'=>'consents','action' => 'patient_specific_consent', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Patient Specific Consent Form','target'=>'_blank'));
		}else{
			echo $this->Html->link($this->Html->image('icons/red.png'), array('controller'=>'consents','action' => 'patient_specific_consent', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Patient Specific Consent Form','target'=>'_blank'));
			}
			?></td>
		
		<td><?php if(!empty($ot["PreOperativeChecklist"]["id"])){
			echo $this->Html->link($this->Html->image('icons/green.png'), array('controller'=>'opt_appointments','action' => 'ot_pre_operative_checklist', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Pre Operative Checklist','target'=>'_blank'));
		}else{
			echo $this->Html->link($this->Html->image('icons/red.png'), array('controller'=>'opt_appointments','action' => 'ot_pre_operative_checklist', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Pre Operative Checklist','target'=>'_blank'));
		}
		?></td>
	
		<!-- <td><?php if(!empty($ot["Note"]["post_opt"])){
			echo $this->Html->link($this->Html->image('icons/green.png'), array('controller'=>'opt_appointments','action' => 'ot_post_operative_checklist', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Post Operative Checklist','target'=>'_blank'));
		}else{
			echo $this->Html->link($this->Html->image('icons/red.png'), array('controller'=>'opt_appointments','action' => 'ot_post_operative_checklist', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Post Operative Checklist','target'=>'_blank'));
		}?></td> -->
	
		<td><?php if(!empty($ot["SurgicalSafetyChecklist"]["id"])){
			 echo $this->Html->link($this->Html->image('icons/green.png'), array('controller'=>'opt_appointments','action' => 'surgical_safety_checklist', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Surgical Safety Checklist','target'=>'_blank'));
		}else{
			echo $this->Html->link($this->Html->image('icons/red.png'), array('controller'=>'opt_appointments','action' => 'surgical_safety_checklist', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Surgical Safety Checklist','target'=>'_blank'));
		}?></td>
		
		<!-- <td><?php 
		if(!empty($ot["Note"]["anaesthesia_note"])){
		echo $this->Html->link($this->Html->image('icons/green.png'), array('controller'=>'opt_appointments','action' => 'anaesthesia_notes', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Anaesthesia Notes','target'=>'_blank'));
		}else{
		echo $this->Html->link($this->Html->image('icons/red.png'), array('controller'=>'opt_appointments','action' => 'anaesthesia_notes', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Anaesthesia Notes','target'=>'_blank'));
		}?></td>
	
		<td><?php if(!empty($ot["Note"]["surgery"])){
			echo $this->Html->link($this->Html->image('icons/green.png'), array('controller'=>'opt_appointments','action' => 'surgery_notes', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Surgery Notes','target'=>'_blank'));
		}else{
			echo $this->Html->link($this->Html->image('icons/red.png'), array('controller'=>'opt_appointments','action' => 'surgery_notes', $ot['OptAppointment']['patient_id']), array('escape' => false,'title'=>'Surgery Notes','target'=>'_blank'));
		}?></td> -->
		
		<td class="under" style="text-align: left;">
		<?php 
		
			$taskOptions=array('OrderSet'=>'Order Set','InteractiveView'=>'Interactive View', 'CriticalCare'=>'Critical Care Dashboard','PostOperativeChecklist'=>'Post Operative Checklist','AnaeNotes'=>'Anae. Notes','SurgeryNotes'=>'Surgery Notes');
		
		
		 echo $this->Form->input('task',array('style'=>'width:100px;','type'=>'select','label'=>false,
						     'options'=>$taskOptions,'empty'=>"Select Task",'value'=>'','class'=>'currentDropdown task','patient_id'=>$ot['OptAppointment']['patient_id'],
							 'id'=>'task_'.$ot['OptAppointment']['patient_id']));?> </td>
		<?php /*?>
		<td>
		
		<?php 
		  if((($ot['OptAppointment']['out_time'] == '') || empty($ot['OptAppointment']['out_time'])) &&  empty($ot['OptAppointment']['ot_in_time'])){
			echo $this->Form->link(__('Transfer to OT'),(array('type'=>'button','class'=>"blueBtn transferToOT",'value'=>'To OT','patient_id'=>$optAppointmentPatientId,'id'=>$ot['OptAppointment']['id'], 'label'=>false ,'style'=>"width:80px")));
		  }else if(($ot['OptAppointment']['out_time'] == '') || empty($ot['OptAppointment']['out_time'])){
		 	echo $this->Form->link(__('Transfer to Ward'),(array('type'=>'button','class'=>"blueBtn transferToWard",'value'=>'To Ward','patient_id'=>$optAppointmentPatientId,'id'=>$ot['OptAppointment']['id'], 'label'=>false ,'style'=>"width:80px")));
		  }else{

		  }?>
		</td>
		<?php */ ?>
		<?php echo $this->Form->end(); ?>
		</tr>
		<?php 	 } ?>
		<tr style="text-align: center;">
			<td colspan="8">
			<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#content-list',    												
						'complete' => "onCompleteRequest();",
		    		 	'before' => "loading();"), null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#content-list',    												
						'complete' => "onCompleteRequest();",
		    		 	'before' => "loading();"), null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span>
			</td>
		</tr>
	</table>
	<?php }  

	echo	$this->Paginator->options(array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));
		echo $this->Js->writeBuffer();
		?>
</div>
<script>
var websiteInstance = '<?php echo $this->Session->read('website.instance');?>';
function edit(optAppointmentId,optAppointmentPatientId)
{
	$.fancybox({
		'width' : '60%',
		'height' : '60%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
	
		'href' : "<?php echo $this->Html->url('/optAppointments/note_dashboard'); ?>"+"/"+optAppointmentId+"/"+optAppointmentPatientId
		
	});
	
}

$(".anaesthetist").on('change',function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	patientId = splittedVar[1]; 
	value = $('#'+currentId).val();
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => 'OptAppointments', "action" => "dashboard_update","anaesthetist","admin" => false)); ?>"+"/"+patientId,
		  context: document.body,	
		  data : "value="+value,
		  beforeSend:function(){
		    // this is where we append a loading image
		    //$('#busy-indicator').show('fast');
		  }, 	  		  
		  success: function(data){					  
			  //$('#busy-indicator').hide('fast');
			  inlineMsg(currentId,'Done');
		  }
	});		 
});

$(".doctor").on('change',function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	patientId = splittedVar[1]; 
	value = $(this).val();		 
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => 'OptAppointments', "action" => "dashboard_update","doctor","admin" => false)); ?>"+"/"+patientId,
		  context: document.body,	
		  data : "value="+value,
		  beforeSend:function(){
		    // this is where we append a loading image
		    //$('#busy-indicator').show('fast');
		  }, 	  		  
		  success: function(data){					  
			  //$('#busy-indicator').hide('fast');
			  inlineMsg(currentId,'Done');
		  }
	});		 
});

$(".procedure").on('change',function(){
	currentId = $(this).attr('id') ;
	splittedVar = currentId.split("_");		 
	optId = splittedVar[1]; 
	value = $(this).val();
	if(websiteInstance == 'kanpur'){	
		setTimes(optId,value,$(this).attr('patient_id'))	
	}else{ 
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => 'OptAppointments', "action" => "dashboard_update","procedure","admin" => false)); ?>"+"/"+optId,
			  context: document.body,	
			  data : "value="+value,
			  beforeSend:function(){
			    // this is where we append a loading image
			    //$('#busy-indicator').show('fast');
			  }, 	  		  
			  success: function(data){					  
				  //$('#busy-indicator').hide('fast');
				  inlineMsg(currentId,'Done');
			  }
		});	
	}	 
});

$('.transferToOT').click(function(){
    var opt_id = $(this).attr('id') ;
    var patient_id = $(this).attr('patient_id') ;
    var from = 'optDashdoard' ;
    
	$.fancybox({
        'width'    : '90%',
	    'height'   : '90%',
	    'autoScale': true,
	    'transitionIn': 'fade',
	    'transitionOut': 'fade',
	    'type': 'iframe',
	    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "optPatients"/* ,'?'=>array('from'=>'optDashdoard') */)); ?>"+'/'+patient_id+'/'+opt_id
	});
	
});
$('.transferToWard').click(function(){
    var opt_id = $(this).attr('id') ;
    var patient_id = $(this).attr('patient_id') ;
    var from = 'optDashdoard' ;
    
	$.fancybox({
        'width'    : '90%',
	    'height'   : '90%',
	    'autoScale': true,
	    'transitionIn': 'fade',
	    'transitionOut': 'fade',
	    'type': 'iframe',
	    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "patient_transfer"/* ,'?'=>array('from'=>'optDashdoard') */)); ?>"+'/'+patient_id+'/null/'+opt_id+'/?from=optDashdoard'                   
	});
	
});
var formChildFormSubmitted = '0';
function setTimes(optId,value,patientId){
	 $.fancybox({
        'width'    : '85%',
	    'height'   : '90%',
	    'autoScale': true,
	    'transitionIn': 'fade',
	    'transitionOut': 'fade',
	    'type': 'iframe',
	    'onClosed' : function (){
		    if(formChildFormSubmitted == '1')
			   $('#procedure_'+optId).attr('disabled','disabled')
			 else
				 $('#procedure_'+optId).removeAttr('disabled').val(formChildFormSubmitted);  
		    },
	    'href': "<?php echo $this->Html->url(array("controller" => "opt_appointments", "action" => "ot_editevent")); ?>"+'?patient_id='+patientId+'&id='+optId+'&start=-330&end=-330&procedurecomplete='+value                   
	});
};

$('.task').change(function(){
	var id=$(this).attr('patient_id');
	var value=$(this).val();
	if(value=='OrderSet'){
		 window.location.href = '<?php echo $this->Html->url(array('controller'=>'MultipleOrderSets','action'=>'sendTo'));?>'+'/'+$(this).attr('patient_id');
			
		//var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'MultipleOrderSets','action'=>'sendTo'))?>/'+$(this).attr('patient_id'), '_blank',
      //  'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');
	}else if(value=='InteractiveView'){
        window.location.href = '<?php echo $this->Html->url(array('controller'=>'Nursings','action'=>'interactive_view'));?>'+'/'+$(this).attr('patient_id');
	}else if(value=='CriticalCare'){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'PatientsTrackReports'));?>'+'/index/'+$(this).attr('patient_id')
        //window.location.href = '<?php echo $this->Html->url(array('controller'=>'PatientsTrackReports','action'=>'index'));?>'+'/'+$(this).attr('person_id')+'/capturefingerprint:'+$(this).attr('person_id')+'?'+$(this).attr('person_id');
	}else if(value=='printsheet'){
		var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'opd_patient_detail_print'))?>/'+id, '_blank',
        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=100,top=200,height=800');
	}else if(value=='PostOperativeChecklist'){
		 window.location.href = '<?php echo $this->Html->url(array('controller'=>'opt_appointments','action'=>'ot_post_operative_checklist'));?>'+'/'+$(this).attr('patient_id');
	}else if(value=='AnaeNotes'){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'opt_appointments','action'=>'anaesthesia_notes'));?>'+'/'+$(this).attr('patient_id');
	}else if(value=='SurgeryNotes'){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'opt_appointments','action'=>'surgery_notes'));?>'+'/'+$(this).attr('patient_id');
	}else{
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Estimates','action'=>'packageEstimate'));?>'+'/null/'+$(this).attr('person_id')+'/?patientId='+$(this).attr('patient_id');
	}
});

		</script>
