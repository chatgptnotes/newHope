<div class="inner_title">
	<h3>
		&nbsp;
		<?php  
		echo __('No-Show Patient List', true); ?>
	</h3>
	<span><?php 
	if(!$this->request->query['flag']){
	echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report', 'admin'=>true),array('escape'=>false,'class'=>'blueBtn'));
	}else {
		echo $this->Html->link('Back',array('controller'=>'corporates','action'=>'admin_lifespring_reports', 'admin'=>true),array('escape'=>false,'class'=>'blueBtn'));
	}
	echo $this->Html->link('Excel Report',array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',
			'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn', 'style'=>'margin:0 5px 0 5px'));?> </span>
</div>
<?php echo $this->Form->create('appointmentLog',array('type'=>'GET','id'=>'appointmentLog','url'=>array('controller'=>'MeaningfulReport','action'=>'appointment_log','admin'=>false),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
		<?php echo $this->Form->input('flag', array('type'=>'hidden', 'value'=>"1")); ?>
		
<table width="35%" align="center">
	<tr>
		<td width="10%"><?php echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",
						'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From'));?>
		</td>
		<td width="10%"><?php echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",
						'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To'));?>
		</td>
		<td width="10%"><?php 
		echo $this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false)) ;
		?>
		</td>
	</tr>
</table>

<?php 
echo $this->Form->end();
?>

<?php 
if(!empty($patientList)){?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center" width=85%
	 style="text-align: center;">
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo __('Sr No'); ?> </strong></td>
		<td class="table_cell" style="text-align: left"><strong><?php echo __('Patient Name'); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('No-Show'); ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Date'); ?> </strong></td>
		</tr>
<?php 
	$toggle=0;$srno=0;
			foreach($patientList as $key=>$value){
				$srno++;
				if($toggle == 0) {
					echo "<tr class='row_gray'>";
					$toggle = 1;
				}else{
					echo "<tr>";
					$toggle = 0;
				}?>
				<td class="table_cell" width="5%"><?php echo $srno;?></td>
				<td class="table_cell" width="20%" style="text-align: left"><?php echo $value['Patient']['lookup_name'];?></td>
				<td width="40%">
				<?php 				
					echo 'No-Show';				
				?></td>
				<td width="20%"><?php echo $this->DateFormat->formatDate2Local($value['Appointment']['date'],
						Configure::read('date_format'),true);?></td>
<?php }
}?>
</table>
<script>
 $(document).ready(function (){ 
		
		
		$("#dateFrom").datepicker({
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					$(this).focus();
					$( "#seen-filter" ).trigger( "change" );
				}
		});
		$("#dateTo").datepicker({
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				$( "#seen-filter" ).trigger( "change" );
			}
	});
 });
 </script>
