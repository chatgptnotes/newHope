<div class="inner_title">
	<h3>
		&nbsp;
		<?php  echo __('Response Time Patient List', true); ?>
	</h3>
	<span style="float: right;"><?php	 
	echo $this->Html->link('Excel Report',array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',
'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));?><?php 
	echo $this->Html->link('Back',array('controller'=>'MeaningfulReport','action'=>'pcmh_automated_measure', 'admin'=>true),array('escape'=>false,'class'=>'blueBtn'));?> </span>
</div>

<?php echo $this->Form->create('responseTimeList',array('type'=>'GET','id'=>'responseTimeList','url'=>array('controller'=>'MeaningfulReport','action'=>'response_time_report','admin'=>false),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
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
		<td class="table_cell"><strong><?php echo __('Encounter type'); ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Time of Patient contact with doctor'); ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Contact during office hours'); ?> </strong></td>		
		<td class="table_cell"><strong><?php echo __('Note submission time'); ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Response time'); ?> </strong></td>
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
				<td class="table_cell" style="text-align: left"><?php echo $value['Patient']['lookup_name'];?></td>
				<td>
				<?php 
				if(!empty($value['Patient']['mode_communication'])){
					echo $value['Patient']['mode_communication'];
				}
				else{
					echo "Walk-in";
				}				
				?></td>
				<td class="table_cell" ><?php echo $this->DateFormat->formatDate2LocalForReport($value['Patient']['form_received_on'],
						Configure::read('date_format'),true);?></td>				
				<td class="table_cell" ><?php echo $contactTime[$value['Patient']['id']]['contact'];?></td>
				
				<td class="table_cell"><?php echo $this->DateFormat->formatDate2LocalForReport($value['Note']['create_time'],
						Configure::read('date_format'),true);?></td>
				<td class="table_cell" ><?php $response=$this->DateFormat->dateDiff($value['Patient']['form_received_on'],$value['Note']['create_time']);
				if($response->h<=9)
						$hours='0'.$response->h;
					else
						$hours=$response->h;
					if($response->i<=9)
						$min='0'.$response->i;
						else
							$min=$response->i;
				echo $hours.':'.$min;?></td>
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
