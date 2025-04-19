<style>
.elapsedRed {
	color: red;
}

.elapsedGreen {
	color: Green;
}

.elapsedYellow {
	color: yellow;
}

.pastClass {
	background-color: pink !important;
}

.row_title td {
	 background-color: turquoise !important;
	 }
</style>
 
<div class="">
	<div id="no_app">
		<?php
		if (empty ( $data ) && $closed == 'closed') {
			echo "<span class='error'>";
			echo __ ( 'There are no Closed Appointments.' );
			echo "</span>";
		} else if (empty ( $data )) {
			echo "<span class='error'>";
			echo __ ( 'There is no pending appointment.' );
			echo "</span>";
		}
		?>
	</div>
	<div id="parent-content" style="display: none;">
		<div id="chambers"
			style="height: 100px; width: 350px; background-color: rgb(204, 204, 204); text-align: center; padding: 10px; border-radius: 6px;">
			<span style="float: right;"> <?php
			echo $this->Html->link ( $this->Html->image ( 'icons/cross.png', array (
					"title" => "Remove",
					"style" => "cursor: pointer;",
					"alt" => "Remove" 
			) ), "#", array (
					"onclick" => "onCompleteRequest();",
					'escape' => false 
			) );
			?>
			</span>
			<p style="color: #000; font-weight: bold;">Examination Room</p>
			<?php
			echo $this->Form->input ( 'Room', array (
					'empty' => 'Please Select',
					'div' => false,
					'label' => false,
					'type' => 'select',
					'options' => $chambers,
					'div' => false,
					'class' => "textBoxExpnd",
					'id' => 'appointment-room' 
			) );
			
			?>
		</div>
	</div>
	<?php
	
$role = $this->Session->read ( 'role' );
	if (! empty ( $data )) {
		$queryStr = $this->General->removePaginatorSortArg ( $this->params->query ); // for sort column
		$this->Paginator->options ( array (
				'url' => array (
						"?" => $queryStr 
				) 
		) );
		?>
		<span style="font-size: 15px; padding-left: 20px;"><?php $opdCount=$this->Paginator->params();
		if(!empty($dateSearched)){
			$totText= "$dateSearched Total OPD : ".$opdCount['count'];
		}else
			$totText= "Today's Total OPD : ".$opdCount['count'];?></span>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="infoDiv  textAlign">
		<tr class="row_title"> 
			<td     valign="top"  ><?php
						echo $this->Paginator->sort ( 'Patient.lookup_name', __ ( 'Patient Name', true ), array (
								'update' => '#content-list',
								'evalScripts' => true,
								'before' => $this->Js->get ( '#busy-indicator' )->effect ( 'fadeIn', array (
										'buffer' => false 
								) ),
								'complete' => $this->Js->get ( '#busy-indicator' )->effect ( 'fadeOut', array (
										'buffer' => false 
								) ) 
						) );
		?></td>

			<td valign="top" >   Gender,Age </td>
			<td>Admit To Hospital</td>
			<td>Payment Received</td>
			<td >Followup Schedule</td>
			<td>Soap Notes</td>
			<td>Initial Assessment</td>
			<td>Token No</td>
			<td>Task</td>
			<td>LAB. RAD</td>
		</tr>
		<?php
		$toggle = 0;
		$i = 0;
		$personObj=new Person();
		foreach ( $data as $appkey => $appointment ) {
			$futureFlag = 0;			 
			$i++; 
			 
			echo "<tr >"; 
		  
			?> 
		<td>
    <?php  
    $name = trim($appointment['Patient']['lookup_name']) . ' -' . $appointment['Patient']['admission_id']; 

    echo $this->Html->link(
        $name,
        array('controller' => 'Patients', 'action' => 'new_patient_hub', $appointment['Patient']['id'], $appointment['Appointment']['person_id']),
        array('style' => 'text-decoration:underline;padding:2px 0px;', 'escape' => false)
    );
    ?>
</td>
		<td><?php if(strtolower($appointment['Person']['sex'])=='male'){
						$sex= "M";
				  }else if(strtolower($appointment['Person']['sex'])=='female'){
						$sex= "F";
				 }else{
						$sex= "Others";
				 }
				$age=$personObj->getCurrentAge($appointment['Person']['dob']);
				echo "$sex/$age" ?>
		</td>
		<td>
		<?php
			if($appointment['Patient']['is_opd']=='1'){
					echo $this->Html->image('icons/green.png');
			}else{
			echo $this->Html->link($this->Html->image('icons/red.png'),array('controller'=>'Patients','action'=>'add','?'=>array('type'=>'IPD','is_opd'=>'1','patient_id'=>$appointment['Appointment']['patient_id'],'apptId'=>$appointment['Appointment']['id'])),array('escape'=>false));
			}
			?>
		</td>
		<td  ><?php 
		// paid
			if (! empty ( $appointment ['Billing'] ['patient_id'] )) {
				if ($appointment ['Appointment'] ['is_future_app'] == '1') { // future appt is 1
					echo $this->Html->image ( 'icons/red.png', array (
							'style' => 'cursor:not-allowed;',
							'title' => 'Register Patient First/Patient Not arrived yet' 
					) );
				} else {
					if ($appointment ['Appointment'] ['status'] == '' || $appointment ['Appointment'] ['status'] == 'Scheduled' || $appointment ['Appointment'] ['status'] == 'Pending' || $appointment ['Appointment'] ['status'] == 'Confirmed with Patient' || $appointment ['Appointment'] ['status'] == 'Cancelled' || $appointment ['Appointment'] ['status'] == 'No-Show') {
						echo $this->Html->image ( 'icons/red.png', array (
								'style' => 'cursor:not-allowed;',
								'title' => 'Patient Not arrived yet' 
						) );
					} else {
						$paid = $billData [$appointment ['Appointment'] ['patient_id']] ['total'] - ($billData [$appointment ['Appointment'] ['patient_id']] ['paid'] + $billData [$appointment ['Appointment'] ['patient_id']] ['discount']);
						if ($paid <= 0 /*&& $appointment['0']['amount_pending']<=0*/){
							echo $this->Html->link ( $this->Html->image ( 'icons/green.png', array () ), array (
									'controller' => 'Billings',
									'action' => 'multiplePaymentModeIpd',
									$appointment ['Appointment'] ['patient_id'],
									'#' => 'serviceOptionDiv',
									'?' => array (
											'apptId' => $appointment ['Appointment'] ['id'] 
									) 
							), array (
									'escape' => false,
									'title' => 'View Payment Info' 
							) );
						} else {
							echo $this->Html->link ( $this->Html->image ( 'icons/orange_new.png', array () ), array (
									'controller' => 'Billings',
									'action' => 'multiplePaymentModeIpd',
									$appointment ['Appointment'] ['patient_id'],
									'#' => 'serviceOptionDiv',
									'?' => array (
											'apptId' => $appointment ['Appointment'] ['id'] 
									) 
							), array (
									'escape' => false,
									'title' => 'View Payment Info' 
							) );
						}
					}
				}
			} else {
				if ($appointment ['Appointment'] ['status'] == '' || $appointment ['Appointment'] ['status'] == 'Scheduled' || $appointment ['Appointment'] ['status'] == 'Pending' || $appointment ['Appointment'] ['status'] == 'Confirmed with Patient' || $appointment ['Appointment'] ['status'] == 'Cancelled' || $appointment ['Appointment'] ['status'] == 'No-Show') {
					echo $this->Html->image ( 'icons/red.png', array (
							'style' => 'cursor:not-allowed;',
							'title' => 'Patient Not arrived yet' 
					) );
				} else {
					// echo $this->Html->link($this->Html->image('icons/red.png',array()),array('controller'=>'Billings','action'=>'dischargeBill',$appointment['Appointment']['patient_id']),array('escape'=>false));
					echo $this->Html->link ( $this->Html->image ( 'icons/red.png', array () ), array (
							'controller' => 'Billings',
							'action' => 'multiplePaymentModeIpd',
							$appointment ['Appointment'] ['patient_id'],
							'#' => 'serviceOptionDiv',
							'?' => array (
									'apptId' => $appointment ['Appointment'] ['id'] 
							) 
					), array (
							'escape' => false,
							'title' => 'View Payment Info' 
					) );
				}
			}
			?>
		</td> 
		<td>
			<?php echo $this->Html->link($this->Html->image('icons/red.png',array()),'javascript:void(0)',
							 array('escape' => false,'title'=>'Followup Scheduled','id'=>'setMultiApp_'.$appointment['Appointment']['patient_id'],'class'=>'setMultiApp'));?>


		</td>
		<td> <?php  
		if(isset($appointment['Note']['id']) && !empty($appointment['Note']['id'])){
			echo $this->Html->link(
							$this->Html->image('icons/green.png',array()),
							array('controller'=>'Notes','action'=>'soapNote',$appointment['Appointment']['patient_id'],$appointment['Note']['id'],'appt'=>$appointment['Appointment']['id'],'?'=>array('arrived_time'=>$appointment['Appointment']['arrived_time'],'from'=>'BackToOPD')),array('class'=>'doc_clicked','id'=>$appointment['Appointment']['patient_id'],'escape'=>false,'title'=>'SOAP Not Complete'));
		}else{
			echo $this->Html->link(
							$this->Html->image('icons/red.png',array()),
							array('controller'=>'Notes','action'=>'soapNote',$appointment['Appointment']['patient_id'],'appt'=>$appointment['Appointment']['id'],'?'=>array('arrived_time'=>$appointment['Appointment']['arrived_time'],'from'=>'BackToOPD')),array('class'=>'doc_clicked','id'=>$appointment['Appointment']['patient_id'],'escape'=>false,'title'=>'SOAP Not Complete'));
		}
					
			?>
		</td> 
		<td> <?php  
		if(isset($appointment['Diagnosis']['id']) && !empty($appointment['Diagnosis']['id'])){
	
							echo $this->Html->link($this->Html->image('icons/green.png',array()),array("controller" => "Diagnoses", "action" => "initialAssessment",$appointment['Patient']['id'],$appointment['Diagnosis']['id'],$appointment['Appointment']['id'],"admin" => false,'?'=>array('arrived_time'=>$appointment['Appointment']['arrived_time'],'from'=>'BackToOPD')),array('escape'=>false,'class'=>'','id'=>'initial_'.$appointment['Diagnosis']['id'].'_'.$appointment['Patient']['id']));
					}else{
						echo $this->Html->link($this->Html->image('icons/red.png',array()),array("controller" => "Diagnoses", "action" => "initialAssessment",$appointment['Patient']['id'],'null',$appointment['Appointment']['id'],"admin" => false,'?'=>array('arrived_time'=>$appointment['Appointment']['arrived_time'],'from'=>'BackToOPD')),array('escape'=>false,'class'=>'','id'=>'initial_'.$appointment['Diagnosis']['id'].'_'.$appointment['Patient']['id']));
		}
					
			?>
		</td>
		<td>
			<?php 
			if(!empty($appointment ['Appointment'] ['token_no'])){
				echo $appointment ['Appointment'] ['token_no'];
			}else{
				echo $this->Form->input ( 'token_no', array (
					'style' => 'width:100px;',
					'type' => 'number',
					'label' => false,
					'value' => '',
					'class' => 'tokenNo',
					'patient_id' => $appointment ['Appointment'] ['patient_id'],
					'id' => $appointment ['Appointment'] ['id'] 
			) );
			}
			 ?>
		</td>
		<td> <?php
			if ($isFingerPrintEnable == 1)
				$taskOptions = array (
					'qrCode' => 'Print QR Code',/* 'packageEstimate'=>'Estimate', */'Patient Survey' => 'Patient Survey',
						'fingerprint' => 'Capture Fingerprint',
						'printsheet' => 'Print Sheet','printSticker'=>'Print Sticker','invoice'=>'Invoice'
				);
			else
				$taskOptions = array (
						'qrCode' => 'Print QR Code',/* 'packageEstimate'=>'Estimate', */'Patient Survey' => 'Patient Survey',
						'printsheet' => 'Print Sheet',
						'printsheetinvoice' => 'Print sheet Invoice' ,'printSticker'=>'Print Sticker','invoice'=>'Invoice'
				);
			
			echo $this->Form->input ( 'task', array (
					'style' => 'width:100px;',
					'type' => 'select',
					'label' => false,
					'options' => $taskOptions,
					'empty' => "Select Task",
					'value' => '',
					'class' => 'currentDropdown task',
					'patient_id' => $appointment ['Appointment'] ['patient_id'],
					'person_id' => $appointment ['Appointment'] ['person_id'],
					'id' => 'task_' . $appointment ['Appointment'] ['patient_id'] 
			) );
			?></td> 
			<td valign="middle" class="td_ht"><?php  
    $patientId = $appointment ['Appointment'] ['patient_id'];  
    $labOrder = isset($customArray[$patientId]['LaboratoryTestOrder']['lab']) ? (int)$customArray[$patientId]['LaboratoryTestOrder']['lab'] : 0;
    $labResult = isset($customArray[$patientId]['LaboratoryResult'][0]['labResult']) ? (int)$customArray[$patientId]['LaboratoryResult'][0]['labResult'] : 0;
    if ($labOrder > 0)
        $labResUrl = array('controller' => 'laboratories', 'action' => 'labTestHl7List', $patientId, '?' => array('return' => 'laboratories'));
    else
        $labResUrl = "#";
    echo $this->Html->link("$labResult/$labOrder</br>", $labResUrl, array('escape' => false, 'title' => 'Click to view result', 'style' => 'cursor:pointer;'));
    $radOrder = isset($customArray[$patientId]['RadiologyTestOrder']['rad']) ? (int)$customArray[$patientId]['RadiologyTestOrder']['rad'] : 0;
    $radResult = isset($customArray[$patientId]['RadiologyResult'][0]['radResult']) ? (int)$customArray[$patientId]['RadiologyResult'][0]['radResult'] : 0;
    if ($radOrder > 0)
        $radResUrl = array('controller' => 'radiologies', 'action' => 'radiology_test_list', $patientId, '?' => array('return' => 'radiologies'));
    else
        $radResUrl = "#";
    echo $this->Html->link("$radResult/$radOrder", $radResUrl, array('escape' => false, 'title' => 'Click to view result', 'style' => 'cursor:pointer;'));
?>
</td>
		</tr>
		<?php  }?> 
		 
		
		<?php 
}
	$queryStr = $this->General->removePaginatorSortArg ( $this->params->query ); // for sort column
	if (empty ( $queryStr )) {
		if ($this->params->pass [0] == 'closed') {
			$queryStr = 'closed=closed';
		}
	}
	$this->Paginator->options ( array (
			'url' => array (
					"?" => $queryStr 
			) 
	) );
	
	// code added by- Leena
	
	echo $this->Paginator->options ( array (
			'update' => '#content-list',
			'evalScripts' => true,
			'before' => "loading();",
			'complete' => "onCompleteRequest();",
			'url' => array (
					"?" => $queryStr 
			) 
	)
	 
	 );
	?>
		<tr style="text-align: center; height: 31px;">
			<td colspan="20">&nbsp;<!-- blank row to unhide lower rows -->
			</td>
		</tr>
		<tr style="text-align: center;">
			<td colspan="20">
			
			<?php
			
$queryStr = $this->General->removePaginatorSortArg ( $this->params->query ); // for sort column
			$this->Paginator->options ( array (
					'url' => array (
							"?" => $queryStr 
					) 
			) );
			?>
			<!-- Shows the next and previous links --> <?php
			echo $this->Paginator->first ( __ ( '« First', true ), array (
					'class' => 'paginator_links' 
			) );
			echo $this->Paginator->prev ( __ ( '« Previous', true ), array (
					'class' => 'paginator_links' 
			) );
			echo $this->Paginator->numbers ( array (
					'update' => '#content-list' 
			) );
			echo $this->Paginator->next ( __ ( 'Next »', true ), array (
					'class' => 'paginator_links' 
			) );
			echo $this->Paginator->last ( __ ( 'Last »', true ), array (
					'class' => 'paginator_links' 
			) );
			?> <!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span> <!-- Below code Commented by- Leena --> <!-- Shows the next and previous links --> <?php 
/*
				                                                                                                  * echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#content-list',
				                                                                                                  * 'complete' => "onCompleteRequest();",
				                                                                                                  * 'before' => "loading();"), null, array('class' => 'paginator_links')); ?>
				                                                                                                  * <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links'));
				                                                                                                  */
		?>
			</span>
				 <?php //debug($this->Paginator->params());
/*
		       * echo $this->Paginator->next(__('Next »', true), array('update'=>'#content-list',
		       * 'complete' => "onCompleteRequest();",
		       * 'before' => "loading();"), null, array('class' => 'paginator_links'));
		       */
					?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->

			</td>
		</tr>
	</table>
	 <?php 
	echo	$this->Paginator->options(array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));

		echo $this->Js->writeBuffer();
		$paggingArray = $this->Paginator->params() ;
			
		echo $this->Form->hidden('patient_count',array('id'=>'patient-count' , "value"=>$paggingArray['count'] ,'url'=>$this->Paginator->url()));
		/****** For refreshing - Pooja**********/
		if(!empty($this->params->pass)){
			$is_search='1';
		}else if(!empty($this->request->data)){
			$is_search='1';
		}else if(!empty($this->request->query['dateFrom'])||!empty($this->request->query['dateTo'])){
			$is_search='1';
		}else if(!empty($this->request->query['doctorsId'])){
			$is_search='1';
		}else if(!empty($this->params->query['closed'])){
			$is_search='1';
		}
		else{
			$is_search='0';
		}
		echo $this->Form->input('search',array('type'=>'hidden','id'=>'is_search','value'=>$is_search));
		/****** End of refreshing **********/
		?>
</div>
<script> 
$( document ).ready(function () {
		//To change the status of selected options from disabled to enable.--Pooja
	$(".status").find("option:selected").attr('disabled', false);
	
	 
	$('#totCount',parent.document).html("<?php echo $totText; ?>");
	$('select').hover(function() {
		var value=$(this).val();
		 this.title = this.options[this.selectedIndex].text; 
	})
 	});

$('.task').change(function(){
	var id=$(this).attr('patient_id');
	var value=$(this).val();
	if(value=='qrCode'){
		var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'qr_card'))?>/'+id, '_blank',
        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');
	}else if(value=='Patient Survey'){
        window.location.href = '<?php echo $this->Html->url(array('controller'=>'surveys','action'=>'opd_patient_surveys'));?>'+'/'+$(this).attr('patient_id');
	}else if(value=='fingerprint'){
        window.location.href = '<?php echo $this->Html->url(array('controller'=>'persons','action'=>'finger_print'));?>'+'/'+$(this).attr('person_id')+'/capturefingerprint:'+$(this).attr('person_id')+'?'+$(this).attr('person_id');
	}else if(value=='printsheet'){
		var website= '<?php echo $this->Session->read("website.instance");?>'; 
		if(website=='vadodara'){
			    var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'opd_print_sheet'))?>/'+id, '_blank',
		        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=100,top=200,height=800');
			
			}else{
		   var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'opd_patient_detail_print'))?>/'+id, '_blank',
            'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=100,top=200,height=800');
			}
	}else if(value=='printsheetinvoice'){ 
            var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'opd_patient_detail_print'))?>/'+id+"?invoice", '_blank',
                'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=100,top=200,height=800');
	}else if(value=='printSticker'){ 
            var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'persons','action'=>'printSticker'))?>/'+id, '_blank',
                'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=100,top=200,height=800');
	}else if(value == 'invoice'){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'createOpdInvoice'));?>'+'/'+$(this).attr('patient_id');
	}
	else{
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Estimates','action'=>'packageEstimate'));?>'+'/null/'+$(this).attr('person_id')+'/?patientId='+$(this).attr('patient_id');
	}
});
$(document).on('click','.initial',function(){
	 
	currentId = $(this).attr('id') ;
	conditionsFilter = $(this).attr('conditionsFilter') ;
	todayOrder = $(this).attr('todayOrder') ;
	opdPageCount = $(this).attr('opdPageCount') ;
	closedStatus = $(this).attr('closedStatus') ;
	splittedVar = currentId.split("_");	
	apptId=splittedVar[1];
	ptId=splittedVar[2];
	if(closedStatus =='Closed'){
		var status='Closed';
	}else{
		var status='In-Progress';
	}
	var arrived_time=$("#arrived_time_"+apptId).html();
	//var atym=arrived_time.split(':');
	//var atym1=atym['0']+'p'+atym['1'];
	arrived_time.trim();
	var field='status';
	var obj = $(this) ;
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "update_appointment_status", "admin" => false)); ?>"+"/"+status+"/"+field,
		  context: document.body,
		  data:"id="+apptId,	
		  beforeSend:function(){
			  loading();
		  }, 	  		  
		  success: function(data){
			  <?php if($role==Configure::read('nurseLable')){?>  
			  $("#"+apptId).removeClass("yellowBulb");
			  $("#"+apptId).addClass("greyBulb");
			  <?php } ?>
			  var url = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "initialAssessment", "admin" => false)); ?>"+"/"+ptId+"/"+'null'+"/"+apptId+"/?type="+arrived_time+"&from=BackToOPD&conditionsFilter="+conditionsFilter+"&todayOrder="+todayOrder+"&opdPageCount="+opdPageCount
			  window.location.href = url;
			  onCompleteRequest();
			  
		  }
	});
});

$(document).on('keyup blur','.tokenNo',function(){
	var id = $(this).attr('id');
	var patientId = $(this).attr('patient_id');
	var tokenNo = $(this).val();
	updateTokenNo(id,patientId,tokenNo);
});
function updateTokenNo(id,patientId,tokenNo){
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "update_token_number", "admin" => false)); ?>",
		  context: document.body,
		  data :"id="+id+'&patient_id='+patientId+'&token_no='+tokenNo,
		  beforeSend:function(){
			  loading();
		  }, 	  		  
		  success: function(data){
		
			  var url = "<?php echo $this->Html->url(array("controller" => "Appointments", "action" => "appointments_management", "admin" => false)); ?>" ;
			  window.location.href = url;
			  onCompleteRequest();
			  
		  }
	});
}
</script>


