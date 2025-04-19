<style>
.tabularForm td td {
	padding: 0px;
	font-size: 13px;
	color: #e7eeef;
	background: #1b1b1b;
}

.tabularForm th td {
	padding: 0px;
	font-size: 13px;
	color: #e7eeef;
	background: none;
}

.tabularForm td td.hrLine {
	background: url(../img/line-dot.gif) repeat-x center;
}

.tabularForm td td.vertLine {
	background: url(../img/line-dot.gif) repeat-y 0 0;
}

.line-height p {
	line-height: 0.5;
}

.line-height {
	line-height: 2;}
	{
	.tddate img{float:left;}
}
</style>
<!-- Right Part Template -->

<?php 
if(empty($referral_id) && ($this->params->query['add']!='new')){
		?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php  echo __('Patient Referral', true); ?>
	</h3>
	<span><?php  
	echo $this->Html->link('Back',array('controller'=>'patients','action'=>'patient_information',$this->params['pass'][0]),array('escape'=>false,'class'=>'blueBtn'));
	echo $this->Html->link('Add',array('controller'=>'patients','action'=>'patient_referral',$this->params['pass'][0],'?'=>array('add'=>'new')),array('escape'=>false,'class'=>'blueBtn'));

	?> </span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<?php  if( !empty($dataTransmittedCcda) && empty($data) ){ ?>

	<tr class="row_title">
		<td class="table_cell"><strong><?php echo __('ID'); ?> </strong></td>
		<td class="table_cell" width="570"><strong><?php echo __('Primary Care Provider'); ?>
		</strong></td>
		<td class="table_cell" width="570"><strong><?php echo __('Email Address'); ?>
		</strong></td>
		<td class="table_cell" width="570"><strong><?php echo __('Communication Type'); ?>
		</strong></td>
		<td class="table_cell" width="570"><strong><?php echo __('Problem'); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('File Name '); ?> </strong>
		</td>
		<td class="table_cell"><strong><?php echo __('Subject'); ?> </strong>
		</td>
		<td class="table_cell"><strong><?php echo __('Date time of referral '); ?>
		</strong>
		</td>
	</tr>
	<?php 
	$toggle =0;
	if(count($dataTransmittedCcda) > 0) {
				      		$c=1;
				      		foreach($dataTransmittedCcda as $dataTransmittedCcda){

							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							       ?>
	<td class="row_format"><?php echo $c; ?></td>
	<td class="row_format"><?php  echo $dataTransmittedCcda['User']['alias']; ?>
	</td>
	<td class="row_format"><?php echo $dataTransmittedCcda['User']['email']; ?>
	</td>
	<td class="row_format"><?php echo __('Secure mail'); ?>
	</td>
	<td class="row_format"><?php echo $dataTransmittedCcda['NoteDiagnosis']['diagnoses_name']; ?>
	</td>
	<td class="row_format"><?php echo $dataTransmittedCcda['TransmittedCcda']['file_name'];?>
	</td>
	<td class="row_format"><?php echo $dataTransmittedCcda['TransmittedCcda']['subject'];?>
	</td>
	<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($dataTransmittedCcda['TransmittedCcda']['referral_date'],
			Configure::read('date_format'),true); ?>
	</td>
	</tr>
	<?php $c++ ;
}
	 }
}else{?>
	<?php if(isset($data) && !empty($data)){ ?>
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo __('ID'); ?> </strong></td>
		<td class="table_cell" width="570"><strong><?php echo __('Reason'); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Date of Issue'); ?> </strong>
		</td>
		<td class="table_cell"><strong><?php echo __('Action'); ?> </strong></td>
	</tr>
	<?php 
	$toggle =0;
	if(count($data) > 0) {
				      		$c=1;
				      		foreach($data as $PatientReferral){

							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							       ?>
	<td class="row_format"><?php echo $c; ?></td>
	<td class="row_format"><?php echo wordwrap($PatientReferral['PatientReferral']['complaints'],20); ?>
	</td>
	<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($PatientReferral['PatientReferral']['date_of_issue'],
			Configure::read('date_format'),true); ?>
	</td>
	<td><?php 
	echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'patient_referral',$PatientReferral
								   				['PatientReferral']['patient_id'] ,$PatientReferral['PatientReferral']['id'] ), array('escape' => false,'title'=>'Edit'));

										   		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print','alt'=>'Print')),'#',
											     	array('escape' => false ,'onclick'=>"var openWin = window.open('".$this->Html->url(array
											     	('action'=>'print_patient_referral',$PatientReferral['PatientReferral']['patient_id'],$PatientReferral['PatientReferral']
											     	['id']))."','_blank',
											        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');
											        return false;"));
											    echo $this->Html->link($this->Html->image('icons/delete-icon.png'),
											    array('action' => 'patient_referral_delete',$PatientReferral['PatientReferral']['id'] ), array('escape' => false,'title'=>'Delete'));


								   		?></td>
	</tr>
	<?php $c++ ;
}
//set get variables to pagination url
$this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		
		</TD>
	</tr>
	<?php } ?>
	<?php					  
	} else {
			 ?>
	<tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
			      }
			      ?>
</table>
<?php  }
}else{ ?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php  echo __('Patient Referral', true); ?>
	</h3>
	<span><?php  
	echo $this->Html->link('Back',array('controller'=>'patients','action'=>'patient_referral',$this->params['pass'][0]),array('escape'=>false,'class'=>'blueBtn'));

	?> </span>
</div>
<p class="ht5"></p>

<?php echo $this->element('patient_information');?>
<div class="line-height">To,</div>
<?php echo $this->Form->create('PatientReferral',array('id'=>'PatientReferral','url'=>array('controller'=>'patients','action'=>'patient_referral'),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
echo $this->Form->hidden('patient_id',array('value'=>$this->params['pass'][0]));
echo $this->Form->hidden('id',array());

?>
<table>
	<tr>
		<td width="23%" valign="middle" style="padding-left:33px" class="tdLabel" id="boxSpace"><?php echo __("Dr. Name:");?>
			<font color="red">*</font>
		</td>
		<td width="35%"><?php echo $this->Form->input('dr_name', array('class' => 'validate[required,custom[name],custom[onlyLetterSp]] textBoxExpnd ','id' => 'dr_name')); ?>
		</td>
	</tr>

						<!-- <tr>
                    		<td width="19%" valign="middle" class="tdLabel" id="boxSpace">
							<?php echo __("Problem:");?><font color="red">*</font>
							</td>
							<td><?php echo $this->Form->input('problm', array('empty'=>__('Select'),'options'=>$initials,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'problm','style'=>'width:80px')); ?></td>
                    	</tr>
                    	 -->
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Contact No:");?>
		</td>
		<td><?php echo $this->Form->input('dr_phone', array('class' => 'validate["",custom[phone]] textBoxExpnd','Maxlength'=>'10','id' => 'dr_phone')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Address:");?>
		</td>
		<td><?php echo $this->Form->input('doctor_detail', array('class'=> 'textBoxExpnd', 'type'=>'textarea','rows'=>'3','cols'=>'5','id' => 'doctor_detail')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Patient Detials:");?>
		</td>
		<td width="19%"><?php echo $this->Form->input('patient_detials', array('type'=>'textarea','rows'=>'3','cols'=>'5','class' => 'textBoxExpnd','id' => 'patient_detials')); ?>
		</td>
	</tr>
	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><label
			style="float: inherit"><?php echo __("Reason For Refer :");?><font
				color="red">*</font> </label>
		</td>
		<td width="19%"><?php echo $this->Form->input('complaints', array('type'=>'textarea','rows'=>'3','cols'=>'5', 'class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]','id' => 'complaints')); ?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><label
			style="float: inherit"><?php echo __("Date:");?><font color="red">*</font>
		</label></td>
		<td class="tddate" ><?php 
		if($this->data['PatientReferral']['date_of_issue']){
		                           		$dateOfIssue = $this->DateFormat->formatDate2Local($this->data['PatientReferral']['date_of_issue'],Configure::read('date_format'),true);
		                           	}else{
		                           		$dateOfIssue='';
		                           	}
		                           	echo $this->Form->input('date_of_issue',array('type'=>'text','id'=>'date_of_issue','value'=>$dateOfIssue,'class'=>'validate[required,custom[mandatory-enter-only]]textBoxExpnd','style'=>"float:left",'readonly'=>'readonly'));
		                           	?>
		</td>
	</tr>


	<tr>
		<td width="19%" valign="middle" class="tdLabel" id="boxSpace"></td>
		<td><?php 
		echo $this->Form->submit('Generate Referral',array('class'=>'blueBtn','div'=>false)) ;
		?>
		</td>
	</tr>
</table>
 
<?php 
	echo $this->Form->end();
} ?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>

<script>
$(function() {
	$("#PatientReferral").validationEngine();		
	$( "#date_of_issue" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		//dateFormat: 'dd/mm/yy',
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
		onSelect:function(){$(this).focus();}
		
	});
});	
</script>
