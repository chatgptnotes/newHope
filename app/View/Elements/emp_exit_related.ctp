<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
			
			<tr>
				<th style="padding-left: 10px;" colspan="4"><?php echo __('Employee Exit Related');?>
				</th>
			</tr>
		<tr >
		<td width="21%" class="tdLabel"><?php echo __('Date Of Registration',true); ?></td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.date_of_registration', array('type'=>'text', 'id' => 'date_of_registration','class'=>'textBoxExpnd', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false));
		?>
		</td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Last Working Days:',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.last_working_days ', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'textBoxExpnd')); ?>
		</td>
	</tr>
	<!-- <tr>
		<td width="21%" class="tdLabel"  style="font-weight:Bold "><?php echo __('Clearances obtained from:',true); ?></td>

						<td colspan="2"><?php echo __('Reporting Manager').$this->Form->checkbox("HrDetail.clearances_obtained_from.0", array('legend'=>false,'label'=>false)); ?>
					
						<?php echo __('IT Department').$this->Form->checkbox("HrDetail.clearances_obtained_from.1", array('legend'=>false,'label'=>false)); ?>
				

						<?php echo __('Accounts Department').$this->Form->checkbox("HrDetail.clearances_obtained_from.2", array('legend'=>false,'label'=>false)); ?>
						

						<?php echo __('HR Department').$this->Form->checkbox('HrDetail.clearances_obtained_from.3', array('legend'=>false,'label'=>false)); ?>
				</td>		
    </tr> -->
    						
	<tr>
		<td width="21%" class="tdLabel"  style="font-weight:Bold "><?php echo __('Final settlement details :',true); ?></td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Amount',true); ?></td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.final_settalment_amount', array('type'=>'text', 'id' => 'final_settalment_amount', 'style'=>'float: left;','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
	?></td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Payment Mode',true); ?></td>'options' => array('M' => 'Male', 'F' => 'Female'),
		
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.payment_mode', array('empty'=>__('Please Select'),'options'=>array('Cheque'=>'Cheque','Online'=>'Online'),'class' => 'textBoxExpnd', 'id' => 'payment_mode', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false));
	?></td>		
	</tr>
	<tr>
		<td width="21%" class="tdLabel" style="font-weight:Bold "><?php echo __('Details Of Payment',true); ?>
	</tr>
	<tr>	
		<td width="21%" class="tdLabel"><?php echo __('Date',true); ?></td>
		<td><?php 
		echo $this->Form->input('HrDetail.payment_date', array('type'=>'text', 'id' => 'payment_date', 'style'=>'float: left;','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
	?></td>
		<td width="21%" class="tdLabel"><?php echo __('Cheque/Transaction ref number',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.cheque_transaction_ref_no', array('type'=>'text','class'=>'textBoxExpnd', 'id' => 'cheque_transaction_ref_no', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false));
	?></td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Relieving letter issued on :',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.relieving_letter_issued_date', array('type'=>'text', 'id' => 'relieving_letter_issued_date', 'style'=>'float: left;', 'label'=> false,'class'=>'textBoxExpnd', 'div' => false, 'error' => false));
	?></td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Date of relieving :',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.date_of_relieving', array('type'=>'text', 'id' => 'date_of_relieving','class'=>'textBoxExpnd', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false));
	?></td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Experience letter issued on :',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.experience_letter_issued_on', array('type'=>'text','class'=>'textBoxExpnd', 'id' => 'experience_letter_issued_on', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false));
	?></td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('Gratuity closed on :',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.gratuily_closed_on', array('type'=>'text', 'id' => 'gratuily_closed_on','class'=>'textBoxExpnd', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false));
	?></td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('PF :',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.pf', array('empty'=>__('Please Select'),'options'=>array('Closed'=>'Closed','Transferred'=>'Transferred'),'id' => 'pf', 'style'=>'float: left;','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
	?></td>
	<td width="21%" class="tdLabel"><?php echo __('PF Date :',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.pf_date', array('type'=>'text', 'id' => 'pf_date', 'style'=>'float: left;','class'=>'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false));
	?></td>
	</tr>
	<tr>
		<td width="21%" class="tdLabel"><?php echo __('ESI closed Date:',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.esi_closed', array('type'=>'text', 'id' => 'esi_closed','class'=>'textBoxExpnd', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false));
	?></td>
	<td width="21%" class="tdLabel"><?php echo __('ESI closed:',true); ?>
		</td>
		<td width="30%"><?php 
		echo $this->Form->input('HrDetail.esi_closed_date', array('type'=>'text', 'id' => 'esi_closed_date','class'=>'textBoxExpnd', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false));
	?></td>
	</tr>
</table>
<script>
$("#date_of_registration").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',		
});

$("#payment_date").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',		
});

$("#relieving_letter_issued_date").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',		
});

$("#date_of_relieving").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',		
});

$("#experience_letter_issued_on").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',		
});

$("#gratuily_closed_on").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',		
});

$("#pf_date").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',		
});
$("#esi_closed").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	maxDate: new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate();?>',		
});
</script>