<?php 
echo $this->Html->script(array('pager','jquery.fancybox-1.3.4','jquery.autocomplete','inline_msg','jquery.blockUI'));
echo $this->Html->css(array('jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));
?>
<style>
.iconTd {
	font-size: 9px;
	width: 5%;
	cursor: pointer;
	text-align: center;
}

.tableCell {
	border: 1px solid #4C5E64;
	padding: 2px 5px;
}

.table_cell {
	padding: 2px 5px;
}

.selectedRow {
	background-color: #24483C; /* #64F3C8*/
}

img {
	float: inherit;
}

.imageBtn {
	background: url("../img/icons/refresh.png") no-repeat center 2px;
	cursor: pointer;
	border: medium none;
}

.errorRow{
	color: red;
}

</style>
<div id="flashMessage" class="message" style="display: none">&nbsp;</div>
<div class="inner_title">
	<h3>
		<?php echo __('Edit/Error Management'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Billing',array('url'=>array('controller'=>'Insurances','action'=>'editErrorManagement'),'name'=>'editErrorManagement','id'=>'editErrorManagement','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table width="100%" style="border: 1px solid #4C5E64; margin: 5px;">
	<tr>
		<td><strong><?php echo __('Claim Status'); ?> </strong></td>
		<?php $claimStatus = Configure::read('claim_status');unset($claimStatus['ERA Received']);?>
		<td><?php echo $this->Form->input('claim_status', array('empty' => 'All Current Statuses','options'=>$claimStatus,'style'=>'width: 43%','id' => 'suffix')); ?>
		</td>
		<td><strong><?php echo __('Insurance'); ?> </strong></td>
		<td><?php echo $this->Form->input('tariff_standard_idnotused', array('options'=>$tariffStandards,'empty'=>'All Payers')); ?>
		</td>
	</tr>
</table>
<table style="border: 1px solid #4C5E64; margin: 5px;" width="100%">
	<tr>
		<td class="iconTd" onclick='pager.prev();'><?php echo $this->Html->image('/img/icons/prev.png',array('alt'=>'Previous','title'=>'Previous'));?>
		</td>
		<td class="iconTd" onclick='pager.next();'><?php echo $this->Html->image('/img/icons/next.png',array('alt'=>'Next','title'=>'Next'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->link($this->Html->image('/img/icons/refresh-icon.png'),
				array('controller'=>'Insurances','action' => 'editErrorManagement'),
				array('escape' => false,'title'=>'Refresh','style'=>'text-decoration: none;'));?>
		</td>
		<td class="iconTd"><span class="selectAll"><?php echo $this->Html->image('/img/icons/select.png',array('alt'=>'Select/Deselect','title'=>'Select/Deselect'));?>
		</span>
		</td>
		<td class="iconTd"><span class="hideError"><?php echo $this->Html->image('/img/icons/hide_errors.png',array('alt'=>'Hide Errors','title'=>'Hide Errors'));?>
		</span>
		</td>
		<td class="iconTd"><span class="reset"><?php echo $this->Html->image('/img/icons/reset.png',array('alt'=>'Reset','title'=>'Reset'));?>
		</span></td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/drop.png',array('alt'=>'Drop To Paper','title'=>'Drop To Paper'));?>
		</td>
		<td class="iconTd"><span class="assignClaim"><?php echo $this->Html->image('/img/icons/assign_claims.png',array('alt'=>'Assign Claims','title'=>'Assign Claims','id'=>'assignClaims'));?>
		</span></td>
		<td class="iconTd"><span class="autoAssign"><?php echo $this->Html->image('/img/icons/assign_management.png',array('alt'=>'Auto-Assign Management','title'=>'Auto-Assign Management'));?>
		</span></td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/status_manage.png',array('alt'=>'Status Management','title'=>'Status Management'));?>
		</td>
		<td class="iconTd"><span class="followUp"><?php echo $this->Html->image('/img/icons/followup.png',array('alt'=>'Followup','title'=>'Followup'));?>
		</span>
		</td>
		<td class="iconTd"><span class="history"><?php echo $this->Html->image('/img/icons/history.png',array('alt'=>'History','title'=>'History'));?>
		</span>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/notes_error.png',array('alt'=>'Notes','title'=>'Notes'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/unlock.png',array('alt'=>'Unlock','title'=>'Unlock'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/send_edi.png',array('alt'=>'Send EDI','title'=>'Send EDI'));?>
		</td>
		<td class="iconTd"><span class='editClaims'><?php echo $this->Html->image('/img/icons/edit_claims.png',array('alt'=>'Edit Claims','title'=>'Edit Claims'));?>
		</span>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/claim_change_report.PNG',array('alt'=>'Claim Change Report','title'=>'Claim Change Report'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/patient_report.png',array('alt'=>'Patient Report','title'=>'Patient Report'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/edit_error.png',array('alt'=>'Edit / Error Mgmt Report','title'=>'Edit / Error Mgmt Report'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/delete.png',array('alt'=>'Delete','title'=>'Delete'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/support_ticket.png',array('alt'=>'Support','title'=>'Support'));?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="iconTd" onclick='pager.prev();'>Prev</td>
		<td class="iconTd" onclick='pager.next();'>Next</td>
		<td class="iconTd"><?php echo $this->Html->link('Refresh',
				array('controller'=>'Insurances','action' => 'editErrorManagement'),
				array('escape' => false,'title'=>'Refresh','style'=>'text-decoration: none;'));?>
		</td>
		<td class="iconTd"><span class="selectAll">Select/Deselect</span></td>
		<td class="iconTd"><span class="hideError" id="hideError">Hide Errors</span></td>
		<td class="iconTd"><span class="reset">Reset</span></td>
		<td class="iconTd">Drop To Paper</td>
		<td class="iconTd"><span class="assignClaim" id='assignText'>Assign
				Claims</span></td>
		<td class="iconTd"><span class="autoAssign">Auto-Assign Management</span></td>
		<td class="iconTd">Status Management</td>
		<td class="iconTd"><span class="followUp">Followup</span></td>
		<td class="iconTd"><span class="history">History</span></td>
		<td class="iconTd">Notes</td>
		<td class="iconTd">Unlock</td>
		<td class="iconTd">Send EDI</td>
		<td class="iconTd"><span class='editClaims'>Edit Claims</span></td>
		<td class="iconTd">Claim Change Report</td>
		<td class="iconTd">Patient Report</td>
		<td class="iconTd">Edit/Error Mgmt Report</td>
		<td class="iconTd">Delete</td>
		<td class="iconTd">Support Ticket</td>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%">
	<tr class="row_title">
		<td width="2%" align="center"><?php echo $this->Html->image('/img/icons/phone.png',array('style'=>'float: none;'));?>
		</td>
		<td width="2%" align="center"><?php echo $this->Html->image('/img/icons/followup_header.png',array('style'=>'float: none;'));?>
		</td>
		<td width="2%" align="center"><?php echo $this->Html->image('/img/icons/status_management.png',array('style'=>'float: none;'));?>
		</td>
		<td width="2%" align="center"><?php echo __('#')?></td>
		<td width="9%"><?php echo __('Claim Status')?></td>
		<td width="8%"><?php echo __('Batch Name')?></td>
		<td width="9%"><?php echo __('Service Date')?></td>
		<td width="9%"><?php echo __('Acct.#/MRN')?></td>
		<td width="9%"><?php echo __('Patient Name')?></td>
		<td width="9%"><?php echo __('Provider Name')?></td>
		<td width="9%"><?php echo __('Payer Name')?></td>
		<td width="9%"><?php echo __('Assigned')?></td>
		<td width="9%"><?php echo __('Office')?></td>
		<td width="2%" align="center"><?php echo $this->Html->image('/img/icons/green-bullet.png',array('style'=>'float: none;'));?>
		</td>
	</tr>
	<tr>
		<td class="tableCell"></td>
		<td class="tableCell"></td>
		<td class="tableCell"></td>
		<td class="tableCell"></td>
		<td class="tableCell"></td>
		<td class="tableCell"><?php echo $this->Form->input('batch_name',array('type'=>'text','style'=>'width:80%;'));?>
		</td>
		<td class="tableCell"><?php echo $this->Form->input('service_date',array('type'=>'text','style'=>'width:70%;',
				'readOnly'=>true,'class'=>'dateCalender textBoxExpnd'));?>
		</td>
		<td class="tableCell"><?php echo $this->Form->input('patient_id',array('type'=>'text','id'=>'patientId'));?>
		</td>
		<td class="tableCell"><?php echo $this->Form->input('lookup_name',array('type'=>'text','id'=>'lookupName'));?>
		</td>
		<td class="tableCell"><?php echo $this->Form->input('doctor_name', array('id' => 'doctor_name')); 
		echo $this->Form->hidden('doctor_id', array('type'=>'text','id'=>'doctor_id'));
		?>
		</td>
		<td class="tableCell"><?php echo $this->Form->input('payer_name', array('id' => 'payer_name')); 
		echo $this->Form->hidden('tariff_standard_id', array('type'=>'text','id'=>'payer_id'));
		?>
		</td>
		<td class="tableCell"><?php echo $this->Form->input('assigned_coder',array('empty'=>'Please Select','options'=>$medicalCoder));?>
		</td>
		<td class="tableCell"><?php echo $this->Form->input('location_name', array('id' => 'location_name')); 
		echo $this->Form->hidden('location_id', array('type'=>'text','id'=>'location_id'));
		?>
		</td>
		<td class="tableCell" rowspan="3" align="center"><?php echo $this->Form->input('',array('type'=>'submit','class'=>'imageBtn','id'=>'submit'));?>
		</td>
	</tr>
	<tr>
		<td colspan="13">
			<table width="100%">
				<tr class="row_title">
					<td width="17%"><?php echo __('Error Number')?></td>
					<td width="32%"><?php echo __('Error Category')?></td>
					<td><?php echo __('Error Description')?></td>
				</tr>
				<tr>
					<td class="tableCell"><?php echo $this->Form->input('error_number',array('type'=>'text','style'=>'width:80%;'));?>
					</td>
					<td class="tableCell"><?php $categoryArry =  array(''=>'Please Select','Claim'=>'Claim','Eligibility'=>'Eligibility');
					 echo $this->Form->input('error_category',array('options'=>$categoryArry,'style'=>'width:32%;'));?>
						&nbsp;<?php $secondCategoryArry =array(''=>'Please Select','Data Validation'=>'Data Validation',
								'HIPPA-Related Edits'=>'HIPPA-Related Edits','Rejected'=>'Rejected');
					echo $this->Form->input('error_category_second',array('options'=>$secondCategoryArry,'style'=>'width:60%;'));?>
					</td>
					<td class="tableCell"><?php echo $this->Form->input('error_description',array('type'=>'text','style'=>'width:97%;'));?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>
<?php echo $this->Form->create('FinalBilling',array('id'=>'FinalBillingFrm','inputDefaults' => array('label' => false)));?>
<table width="100%" id="errorTable" cellspacing="0">
	<tr style="display: none;">
		<td></td>
	</tr>
	<?php $toggle=0;?>
	<?php foreach($patientData as $data){ ?>
	<?php $action=$data['FinalBilling']['id'];?>
	<?php $errorRow = ($data['FinalBilling']['claim_status'] == 'Rejected') ? 'errorRow' : '';?>
	<?php if($toggle==0){ 
		$greyClass = "row_gray"; $toggle=1;
	}else{$toggle=0; $greyClass='';
}?>
	<tr
		class="<?php echo $data['Patient']['id'].' '.'td_'.$action;?> selectable <?php echo $greyClass.' '.$errorRow?>"
		style="border: none;">
		<td class="table_cell" colspan="3" width="11%"></td>
		<td class="table_cell <?php echo $action." ".'td_'.$action ;?>"
			style="display: block;" width="100%"><span id="<?php echo 'td_'.$action ;?>" class="<?php echo $errorRow?>"><?php echo $data['FinalBilling']['claim_status'];?></span><sup
			id="text_<?php echo  $action?>"> <?php echo $this->Html->image('/img/icons/post_reply.gif',array('width'=>'10px','height'=>'10px','id'=>$action,'class'=>'action'));?>
		</sup></td>
		<td class="table_cell <?php echo $action ." ".'drop_'.$action ;?>"
			style="display: none;" width="9%"><?php echo $this->Form->input('UpdateStatus.claim_status', array('empty' => 'Please Select','options'=>Configure::read('claim_status'),
					'value'=>$data['FinalBilling']['claim_status'],'class'=>'textBoxExpnd status_drops',
					'style'=>"width:100px",'id' => 'statusDrop_'.$action )); ?><sup
			id="text_<?php echo  $action?>"> <?php echo $this->Html->image('/img/icons/post_reply.gif',array('width'=>'10px','height'=>'10px','id'=>$action,'class'=>'action'));?>
		</sup>
		</td>
		<td class="table_cell" width="10%">Batch name</td>
		<td class="table_cell" width="9%"><?php echo $this->DateFormat->formatDate2Local($data['Patient']['form_received_on'],Configure::read('date_format'),false);?>
		</td>
		<td class="table_cell" width="11%"><?php echo $data['Patient']['patient_id'];?>
		</td>
		<td class="table_cell" width="11%"><?php echo ucwords(strtolower($data['Patient']['lookup_name']));?>
		</td>
		<td class="table_cell" width="12%"><?php echo ucwords(strtolower($data['User']['first_name']. ' ' .$data['User']['last_name']));?>
		</td>
		<td class="table_cell" width="11%"><?php echo $data['TariffStandard']['name'];?>
		</td>
		<td class="table_cell coder" width="12%" style="display: block;"><?php echo ($data['MedicalCoder']['id'])? $data['MedicalCoder']['first_name']. ' ' .$data['MedicalCoder']['last_name'] : 'Not Assigned';?>
		</td>
		<td class="table_cell coder" width="12%" style="display: none;"><?php echo $this->Form->input("FinalBilling.$action.assigned_coder",array('empty'=>'Please Select','options'=>$medicalCoder,'value'=>$data['MedicalCoder']['id'],'class'=>'assigned'));?>
			<?php echo $this->Form->input("FinalBilling.$action.id",array('type'=>'hidden','value'=>$action));?>
		</td>
		<td class="table_cell" width="11%"><?php echo $this->Session->read('facility');?>
		</td>
	</tr>
	<tr
		class="<?php echo $data['Patient']['id'].' '.'td_'.$action;?> selectable <?php echo $greyClass.' '.$errorRow?>"
		style="border: none;">
		<td class="table_cell" colspan="4">200.1.252.25452.1</td>
		<td class="table_cell" colspan="3"><span style="padding-left: 14px;">Claim</span><span
			style="padding-left: 140px;">HIPPA-Related Edits</span></td>
		<td class="table_cell" colspan="5"><?php echo substr('Medicare Eligiblity check prior to
			claim submission indicates Medicare is NOT the Primary Payer for this
			claim');?></td>
	</tr>
	<?php }?>
</table>
<?php echo $this->Form->end(); ?>
<div>&nbsp;</div>
<div
	id="pageNavPosition" style="display: none;"></div>
<script>
var pager = new Pager('errorTable', 20); 
var selectedRowId = '';
$( document ).ready(function (){
	<?php if(!empty($patientData)) { ?>
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);
	<?php } ?>
	hideFlash();
});

	function hideFlash(){
		setTimeout(function() {
	        $("#flashMessage").hide('blind', {}, 500)
	    }, 5000);
	}
	$(".dateCalender").datepicker({
		showOn : "button",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true, 
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();
		}
	});

	$("#doctor_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'doctor_name,doctor_id'
	});

	$("#payer_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffStandard",'id',"name",'location_id='.$this->Session->read('locationid').'&is_deleted=0',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'payer_name,payer_id'
	});

	$("#location_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Location",'id',"name","is_active=1&is_deleted=0","admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'location_name,location_id'
	});
	
	$("#lookupName").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name", "admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});			 
	$("#patientId").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id", "admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});

	$('.assigned').click(function (event){
		event.stopPropagation();
		return false;
	});

	$( '.selectable' ).click(function (){
		selectedRowId = '';
		if($( '.'+$(this).attr('class').split(' ')[0] ).hasClass('selectedRow') === true){
			$( 'tr.'+$(this).attr('class').split(' ')[0] ).removeClass('selectedRow');
		}else{
			$( 'tr.'+$(this).attr('class').split(' ')[0] ).addClass('selectedRow');
			selectedRowId = $(this).attr('class').split(' ')[0] ;
			
		}
		if($( document ).find('.selectable').hasClass('selectedRow') === true){
			$( document ).find('.selectable').removeClass('selectedRow');
			$( 'tr.'+$(this).attr('class').split(' ')[0] ).addClass('selectedRow');
			selectedRowId = $(this).attr('class').split(' ')[0] ;
		}
	});
	
	$( '.selectAll' ).click(function (){
		if($( document ).find('.selectable').hasClass('selectedRow') === true){
			$( document ).find('.selectable').removeClass('selectedRow');
			selectedRowId = '';
		}
	});
	
	$( '.reset' ).click(function (){
		$(this).closest('form').find("input[type=text], textarea, select").val("");
	});
	$(".hideError").click(function (){
		var html = ($('#hideError').html().replace(/\s/g, "") == 'HideErrors') ? 'Show Errors' : 'Hide Errors';
		$('#hideError').html(html);
		if(html == 'Show Errors'){
			selectedRowId = '';
			$('tr.errorRow').css('display' , 'none');
		}else{
			$('tr.errorRow').show();
		}
		//selectedRowId = (html == 'Show Errors')? '' : selectedRowId;
		//$('.errorRow').toggle();
	});
	
	$('.assignClaim').click(function (){
		if($('.assignClaim').hasClass('submitCoder') === true){
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "assignCoder", "admin" => false)); ?>";
		$.ajax({
			data: $('#FinalBillingFrm').serialize(),
	  		type: 'POST',
			url: ajaxUrl,
			dataType: 'html',
			 beforeSend:function(){
				  loading();
			  }, 
			success: function(data){ 
				window.location.reload(true);
				onCompleteRequest();
			}
	 	});
		}
		var html = ($('#assignText').html().replace(/\s/g, "") == 'AssignClaims') ? 'Submit Assignment' : 'Assign Claims';
		if(html == 'Submit Assignment'){
			$( '.assignClaim' ).addClass('submitCoder');
		}else{
			$( '.assignClaim' ).removeClass('submitCoder');
		}
		$('#assignText').html(html);
		$('.coder').toggle();
	});

	$('.autoAssign').click(function (){
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "autoAssignManagement", "admin" => false)); ?>";
		$.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: 'coder=<?php echo serialize($medicalCoder); ?>',
			beforeSend:function(){
				  loading();
			}, 
			success: function(data){ 
				window.location.reload(true);
				onCompleteRequest();
			}
	 	});
	});
	
	$('.action').click(function (event){ 
		event.stopPropagation();
		var recordId = $(this).attr('id');
		$('.'+recordId).toggle();
	});
	
	$('.status_drops').click(function (event){
		event.stopPropagation();
		return false;
	});
	
	$(".status_drops").change(function(){
		currentId = $(this).attr('id') ;
		splittedVar = currentId.split("_");		 
		recordId = splittedVar[1];
		value = $(this).val();
		$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "liveClaimsFeed",$patient_id, "admin" => false)); ?>"+"/"+recordId,
		  context: document.body,	
		  data : "value="+value,
		  beforeSend:function(){
			  loading();
		  }, 	  		  
		  success: function(data){					  
			 inlineMsg(currentId,'Updated');
			 ids = currentId.split("_");
			 $('.'+ids[1]).toggle();
			 $('#td_'+ids[1]).html(value);
			 if(value != 'Rejected'){
				 $('.td_'+ids[1]).removeClass('errorRow');
				 $('#td_'+ids[1]).removeClass('errorRow');
			 }else{
				 $('.td_'+ids[1]).addClass('errorRow');
				 $('#td_'+ids[1]).addClass('errorRow');
			 }
			 onCompleteRequest();
		  }
		});		 
	});
	
	function loading(){
	 $('#errorTable').block({ 
       message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please Wait...</h1>', 
       css: {            
           padding: '5px 0px 5px 18px',
           border: 'none', 
           padding: '15px', 
           backgroundColor: '#000000', 
           '-webkit-border-radius': '10px', 
           '-moz-border-radius': '10px',               
           color: '#fff',
           'text-align':'left' 
       },
       overlayCSS: { backgroundColor: '#cccccc' } 
   }); 
	}
	
	function onCompleteRequest(){
		$('#errorTable').unblock(); 
	}
	
	$( '.editClaims' ).click(function (){ 
		if(selectedRowId == ''){
			alert('Please Select Claim');
			return false;
		}
		var callingUrl = '<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "addNewEncounter", "admin" => false)); ?>'
		$.fancybox({ 
			'width': '70%',
			'height': '95%',
		    'autoScale': true, 
		    'scrolling':'auto',
		    'href': callingUrl+'/'+selectedRowId+'?request=iframe',
		    'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	true,
			'type':'iframe'
			 
	    });
	});
	$( '.history' ).click(function (){ 
		if(selectedRowId == ''){
			alert('Please Select Claim');
			return false;
		}
		var Url = '<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "denial_managment", "admin" => false)); ?>'
		$.fancybox({ 
			'width': '98%',
			'height': '95%',
		    'autoScale': true, 
		    'scrolling':'auto',
		    'href': Url+'/'+selectedRowId+'?request=iframe',
		    'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	true,
			'type':'iframe'
			 
	    });
	});
	
	$( '.followUp' ).click(function (){ 
		if(selectedRowId == ''){
			alert('Please Select Claim');
			return false;
		}
		var finalBillId = $('.'+selectedRowId).attr('class') ;
		finalBillId = finalBillId.split(' ')[1].split('_')[1];
		var Url = '<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "claimFollowp", "admin" => false)); ?>'
		$.fancybox({ 
			'width': '40%',
			'height': '40%',
		    'autoScale': true, 
		    'scrolling':'auto',
		    'href': Url+'/'+selectedRowId+'/'+finalBillId,
		    'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	true,
			'type':'iframe'
			 
	    });
	});

</script>
