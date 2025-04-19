<div class="inner_title">
	<h3><?php echo __('Admit to hospital.'); ?></h3>
</div>
<?php echo $this->Form->create('toIpd',array('url'=>array("controller" => "Notes", "action" => "toIpd"),'type' => 'file','id'=>'tarifflist','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
			echo $this->Form->input('toIpd.patient_id',array('type'=>'hidden','value'=>$patientId)); 
			echo $this->Form->input('toIpd.note_id',array('type'=>'hidden','value'=>$noteId));
			?>
	<table class="table_format" border="0" cellpadding="0" cellspacing="0" width="100%"  align="center"> 
		<tr>
		<td align=""><?php echo __(' Procedure to be undertaken:'); ?><font color="red"></font></td>
		<td><?php
		echo $this->Form->input('toIpd.procedure',array('type'=>'text')); ?>
		</td>
		</tr>
		
		<tr>
		<td align=""><?php echo __(' Proposed date for Admission:'); ?><font color="red"></font></td>
		<td><?php
		echo $this->Form->input('toIpd.admission_date',array('type'=>'text','id'=>'admission_date','readonly'=>'readonly','class'=>'textBoxExpnd')); ?>
		</td>
		</tr>
		
		<tr>
		<td align=""><?php echo __('Implants to be Used:'); ?><font color="red"></font></td>
		<td><?php
		echo $this->Form->input('toIpd.implants',array('type'=>'text')); ?>
		</td>
		</tr>
		
		<tr>
		<td align=""><?php echo __('The Rooms to be booked:'); ?><font color="red"></font></td>
		<td><?php
		echo $this->Form->input('toIpd.room',array('type'=>'text')); ?>
		</td>
		</tr>
		
		<tr>
		<td align=""><?php echo __(' Major Breakup of Proposed Bill in case of Package <br/>to be mentioned with special instructions as to How the Payments to be taken from Patients.:'); ?><font color="red"></font></td>
		<td><?php
		echo $this->Form->input('toIpd.bills',array('type'=>'text')); ?>
		</td>
		</tr>
		
		<tr>
		<td align=""><?php echo __('Special Terms & Conditions if any:'); ?><font color="red"></font></td>
		<td><?php
		echo $this->Form->input('toIpd.terms',array('type'=>'text')); ?>
		</td>
		</tr>
		<tr>
		<td align=""><?php echo __('Fornt Office Name:'); ?><font color="red"></font></td>
		<td><?php $listArray=array();
		 foreach($getId['User'] as $newData){
			$listArray[$newData['id']]=$newData['first_name'].' '.$newData['last_name'];
		}
		//debug($listArray);
		echo $this->Form->input('toIpd.inform_to',array('empty'=>'Please select','options'=>$listArray,'id' => '','autocomplete'=>'off'));?>
		</td>
		</tr>
		
		<?php //debug($getId);?>
		<tr>
		<td align=""><?php echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));?></td>
		</tr>
	</table>
		
<?php echo $this->Form->end();?>
<script>

/*
 * 
 
$("#admission_date")
	.datepicker(
			{
				showOn : "both",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange: '-100:' + new Date().getFullYear(),
				minDate : new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					//$(this).focus();										
					$(this).validationEngine("hide");
				}						
			});
			*/
		</script>