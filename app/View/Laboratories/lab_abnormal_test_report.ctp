<?php //debug($testOrdered);?>
<?php $this->request->data['Lab'] = $this->request->query;?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Abnormal Lab Test Results', true); ?>
	</h3>
</div>
<div class="clr">&nbsp;</div>
<?php

echo $this->Form->create ( '', array (
		'action' => 'labAbnormalTestReport',
		'type' => 'get',
		'id' => 'labAbnormalTestReportForm',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );
?>
<table border="0" class="table_format_body" cellpadding="0"
	cellspacing="0" width="100%">
	<tr class="row_title">
		<td id="boxSpace" class="tdLabel" width="9%" valign="middle"><?php echo __("From Date");?>
			<font color="red">*</font></td>
		<td class="table_cell"><strong><?php echo $this->Form->input('Lab.from_date', array('type'=>'text','class' => 'date validate[required,custom[mandatory-date]] textBoxExpnd','id' => 'from_date'));?>
		</strong></td>
		<td id="boxSpace" class="tdLabel" width="10%" valign="middle"><?php echo __("To Date");?>
			<font color="red">*</font></td>
		<td class="table_cell" colspan="3"><strong><?php echo $this->Form->input('Lab.to_date', array('type'=>'text','class' => 'date validate[required,custom[mandatory-date]] textBoxExpnd','id' => 'to_date'));?>
		</strong></td>
		<td id="boxSpace" class="tdLabel" width="10%" valign="middle"><?php echo __("Patient Name");?>
		</td>
		<td class="table_cell" colspan="3"><strong><?php echo $this->Form->input('Lab.lookup_name', array('type'=>'text','class' => 'textBoxExpnd','id' =>'lookup_name'));?>
		</strong> <?php echo $this->Form->hidden('Lab.patient_id',array('id'=>'patient_id'));?>
		</td>
		<td class="table_cell" colspan="3"><?php echo $this->Form->Submit('Continue', array('class' => 'blueBtn','id' => 'submit'));?>
		</td>
	</tr>
</table>
<?php $this->Form->end();?>
<div class="inner_title"></div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<?php if($testOrdered){?>
	<tr class="row_title">
		<td class="tdLabel" align="left"><strong><?php echo  __('Patient Name', true); ?>
		</strong></td>
		<td class="tdLabel" align="left"><strong><?php echo  __('Lab Order id', true); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __('Test Name', true); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __('Abnormal Flag', true); ?>
		</strong></td>
		<td class="table_cell" align="left" width="20%"><strong><?php echo __('Order Date', true); ?>
		</strong></td>
		<td class="table_cell" align="left" width="20%"><strong><?php echo __('Published Date', true); ?>
		</strong></td>
	</tr>
	<?php }if(!$testOrdered && isset($testOrdered)){?>
	<tr>
		<td class="message" align="left"><?php echo __('No Record Found');?></td>
	</tr>
	<?php }?>
	<?php
	$toggle = 0;
	if (count ( $testOrdered ) > 0) {
		$toggle ++;
		foreach ( $testOrdered as $key => $labs ) {
			if ($toggle == 0) {
				echo "<tr class='row_gray'>";
				$toggle = 1;
			} else {
				echo "<tr>";
				$toggle = 0;
			}
			?>
	<td class="row_format" align="left"><?php echo $labs['Patient']['lookup_name']; ?>
	</td>
	<td class="row_format" align="left"><?php echo $labs['LaboratoryTestOrder']['order_id']; ?>
	</td>
	<td class="row_format" align="left"><?php echo $labs['Laboratory']['name']; ?>
	</td> <?php $flag = $labs['LaboratoryHl7Result']['abnormal_flag']?>
	<?php if($flag == 'A'){ $abnFlag = 'Abnormal (applies to non-numeric results)';}elseif($flag == 'H'){$abnFlag = 'Above high normal'; }else{$abnFlag = 'Below low normal';}?>
	<td class="row_format" align="left"><?php echo $abnFlag; ?>
	</td>
	 <?php $labTime = substr($this->DateFormat->formatDate2LocalForReport($labs['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true),-9); ?>
	<td class="tdLabel" align="left"><?php echo $this->DateFormat->formatDate2Local($labs['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),false).' '.$labTime; ?>
	</td>
	<td class="tdLabel" align="left"><?php echo $this->DateFormat->formatDate2LocalForReport($labs['LaboratoryHl7Result']['create_time'],Configure::read('date_format'),true); ?>
	</td>
	</tr>
	<?php } ?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</TD>
	</tr>
	<?php
	}
	?>
</table>
<script language="javascript" type="text/javascript">
$(function() {
	 	$("#labAbnormalTestReportForm").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});
		$(".date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
			}			
		});	

	$( "#lookup_name" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","lookup_name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#patient_id').val(ui.item.id); 
		},
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
	$('#lookup_name').click(function(){
		$(this).val('');
		$("#patient_id").val('');	 
	 });
});
</script>