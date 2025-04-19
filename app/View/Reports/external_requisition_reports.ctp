<style>
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
}
.tabularForm td {
	 background: none repeat scroll 0 0 #fff !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}
</style>
<div class="inner_title">
	<h3><?php echo __('EXTERNAL REQUISITION REPORTS', true); ?></h3>
</div>
<div>&nbsp;</div>    
<div class="clr ht5"></div>
<div class="btns">
<?php echo $this->Form->create('',array('type'=>'GET'));?>
	<?php echo $this->Form->submit(__('Generate Report'), array( 'value'=>'Generate Report','class'=>'blueBtn','label'=>false,'div'=>false,'name'=>'generate_report')); ?>
	<?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'all_report', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
</div>
<table> 
	<tr>
		<td>
			<?php echo __('Select Provider : '); ?>
		</td>
		
		<td>
			<?php $serviceProvider = (array('all'=>'All') + $serviceProvider); ?>
			<?php echo $this->Form->input('service_provider_id',array('type'=>'select','empty'=>'please select','options'=>$serviceProvider,'div'=>false,'label'=>false,
					'class'=>'textBoxExpnd','value'=>$this->params->query['service_provider_id'],'id'=>'service_provider_id'));?>
		</td>
		<td>
			<?php echo __('From Date : '); ?>
		</td>
		<td>
			<?php echo $this->Form->input('from_date',array('type'=>'text','div'=>false,'label'=>false,'class'=>'textBoxExpnd',
					'value'=>$this->params->query['from_date'],'id'=>'from_date'));?>
		</td>
		<td>
			<?php echo __('To Date : '); ?>
		</td>
		<td>
			<?php echo $this->Form->input('to_date',array('type'=>'text','div'=>false,'label'=>false,'class'=>'textBoxExpnd',
					'value'=>$this->params->query['to_date'],'id'=>'to_date'));?>
		</td>
		<td>
			<?php echo __('Mode : '); ?>
		</td>
		<td> 
			<?php echo $this->Form->input('mode',array('type'=>'select','options'=>array('On Credit'=>'On Credit','On Cash'=>'On Cash'),'div'=>false,'label'=>false,
					'class'=>'textBoxExpnd','value'=>$this->params->query['mode'],'id'=>'mode'));?>
		</td>
		<td>
			<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn'));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>
<?php $serviceProviderName = $serviceProvider[$this->params->query['service_provider_id']];   ?>
<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="container-table" >
 	<thead>
		<tr>
			<th width="10%" valign="top" align="center" style="text-align: center;"><?php echo __('Diagnostic Center'); ?></th>
			<th width="10%" valign="top" align="center" style="text-align: center;"><?php echo __('Date'); ?></th>
			<th width="15%" valign="top" align="center" style="text-align: center;"><?php echo __('Patient Name'); ?></th>
			<th width="15%" valign="top" align="center" style="text-align: center"><?php echo __('Private/Corporate'); ?></th>	
			<th width="15%" valign="top" align="center" style="text-align: center;"><?php echo __('Investigation'); ?></th>
			<th width="15%" valign="top" align="center" style="text-align: center;"><?php echo __('Cash/Credit'); ?></th> 
			<th width="10%" valign="top" align="center" style="text-align: center;"><?php echo __('Amount Received by Diagnostic Center'); ?></th>
			<th width="10%" valign="top" align="center" style="text-align: center;"><?php echo __("Center's Tariff"); ?></th>
			<th width="10%" valign="top" align="center" style="text-align: center;"><?php echo __('Receivable from Diagnostic Center'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if(count($radData)>0){ ?>
			<?php foreach ($radData as $key=>$val){ $party = $hospital = ''; ?> 
			<?php $tariffAmount = $val['ExternalRequisition']['tariff_amount']; 
					$commission = $val['ExternalRequisition']['hospital_commission'];
					$mode = $val['ExternalRequisition']['mode'];
				/* if($mode === "On Credit"){
					$party = $tariffAmount;
					$tariff = '';
				}else */
					if($val['ExternalRequisition']['mode'] == "On Credit")
					{
						$tariff = '';
						$party = $tariffAmount - $commission; 
						$hospital = ''; 
					}else{
						$tariff = $tariffAmount;
						$party = $tariffAmount - $commission;
						$hospital = $commission;	
					}
				?>
			<tr>
				<td style="text-align: left;"><?php echo $val['ServiceProvider']['name'];?></td>
			    <td style="text-align: left;"><?php echo $this->DateFormat->formatDate2Local($val['ExternalRequisition']['created_time'],Configure::read('date_format'), false);?></td>
			    <td style="text-align: left;"><?php echo $val['Patient']['lookup_name'];?></td>
			    <td style="text-align: left;"><?php echo $val['TariffStandard']['name'];?></td>
			    <td style="text-align: left;"><?php echo $val['RadiologyTestOrder']['testname'];?></td>
			    <td style="text-align: left;"><?php echo $mode;?></td>
			    <td style="text-align: right;"><?php echo $tariff; $totalTariff += $tariff; ?></td>
			    <td style="text-align: right;"><?php echo $party; $totalParty += $party;?></td>
			    <td style="text-align: right;"><?php echo $hospital; $totalHospital += $hospital;?></td>
			</tr>
		<?php } ?>
			<tr>
			    <td style="text-align: right;" colspan="6"><?php echo __('Total : ');?></td>
			    <td style="text-align: right;"><?php echo number_format($totalTariff,2); ?></td>
			    <td style="text-align: right;"><?php echo number_format($totalParty,2);?></td>
			    <td style="text-align: right;"><?php echo number_format($totalHospital,2);?></td>
			</tr>
		<?php }else{ ?>
			<tr>
			    <td style="text-align: center;" colspan="9"><b><?php echo __("No record found..");?></b></td>
			</tr>
		<?php } ?>
	</tbody>
</table> 

<script>

$(document).ready(function(){		
	$("#from_date").datepicker
	({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
			
	 $("#to_date").datepicker
	 ({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});

});					
</script>