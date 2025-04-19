<?php
echo $this->Html->script(array('/fusioncharts/fusioncharts', 'expand'));
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php 
		 echo __('Arrived Patient List', true); ?>
	</h3>
	<span><?php 
	if(!$this->request->query['flag'])
	{
		echo $this->Html->link('Back',array('controller'=>'MeaningfulReport','action'=>'pcmh_automated_measure', 'admin'=>true),array('escape'=>false,'class'=>'blueBtn'));
	}else 
		echo $this->Html->link('Back',array('controller'=>'corporates','action'=>'admin_lifespring_reports', 'admin'=>true),array('escape'=>false,'class'=>'blueBtn'));
	if(!empty($patientList)){
		echo $this->Html->link('Excel Report',array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',
			'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn', 'style'=>'margin:0 5px 0 5px'));
		echo $this->Html->link('View Pie Chart',array('controller'=>$this->params->controller,'action'=>$this->params->action,
				'?'=>array('startDate'=>$dateFrom,'endDate'=>$dateTo,'pie'=>'pie')),array('class'=>'blueBtn'));
	
}?> </span>
</div>
<?php echo $this->Form->create('appointmentLog',array('type'=>'GET','id'=>'appointmentLog','url'=>array('controller'=>'MeaningfulReport','action'=>'appointment_arrived_report','admin'=>false),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
		<?php echo $this->Form->input('flag', array('type'=>'hidden', 'value'=>"1")); ?>
<table width="45%" align="center">
	<tr>
		<td ><?php if(!empty($dateFrom)){
		 $from=date('m/d/Y ',strtotime($dateFrom));
		}
		if(!empty($startDate)){
			$from=date('m/d/Y ',strtotime($startDate));
		}
		echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",
						'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From','value'=>$from));?>
		</td>
		<td ><?php if(!empty($dateTo)){
		$to=date('m/d/Y ',strtotime($dateTo));
		}
		if(!empty($endDate)){
			$to=date('m/d/Y ',strtotime($endDate));
		}
		echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",
						'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To','value'=>$to));?>
		</td>
		<td ><?php echo $this->Form->input('doctors',array('id'=>"doctor",'options'=>$doctors,
						'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'doctor','empty'=>'All Doctors','value'=>$doctor));?>
		</td>
		<td ><?php 
		echo $this->Form->submit('View Patient List',array('class'=>'blueBtn','div'=>false)) ;
		?>
		</td>
	</tr>
</table>

<?php 
echo $this->Form->end();
?>

<?php if(!empty($pieDataScheduled)){?>
    <div class="chart_section" style="width:1000px; margin:0 auto;">
	<div id="ChartId4" style="float:left; width:50%">
	<?php /* showpercentintooltip="0"*/
	$strDiagnosis='<chart showvalues="1" caption="Scheduled Appointment Report" captionPadding="20" showZeroPies="1"  showlegend="1" enablesmartlabels="1" showlabels="0"  bgColor="#1B1B1B" bgAlpha="100" baseFontColor="#fff" legendBgColor="#1B1B1B" toolTipBgColor="#1B1B1B" legendBgAlpha="100" showBorder="0" minimiseWrappingInLegend ="1" legendPosition="RIGHT">';
	foreach($pieDataScheduled as $key=>$pieData)
	{
		$strDiagnosis.='<set value="'.$pieData['count'].'" label="'.$pieData['name'].'"/>';
	}
			$strDiagnosis.='</chart>';?>
	<script> 
		var datastring = '<?php echo $strDiagnosis; ?>';
	</script>
		  <div id="piechartdiv4" style="float: left;"></div>
		  <?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/Pie2D.swf", "pieChartId1", "30%", "350", "0", "0", "datastring", "piechartdiv4"); ?>	
	</div>
	
	<div id="ChartId5" style="float:left;">
	<?php /* showpercentintooltip="0"*/
	$strDiagnosis='<chart showvalues="1" caption="Arrived Appointment Report" captionPadding="20" showZeroPies="1"  showlegend="1" enablesmartlabels="1" showlabels="0"  bgColor="#1B1B1B" bgAlpha="100" baseFontColor="#fff" legendBgColor="#1B1B1B" toolTipBgColor="#1B1B1B" legendBgAlpha="100" showBorder="0" minimiseWrappingInLegend ="1" legendPosition="RIGHT">';
	foreach($pieDataArrived as $key=>$pieData)
	{
		$strDiagnosis.='<set value="'.$pieData['count'].'" label="'.$pieData['name'].'"/>';
	}
			$strDiagnosis.='</chart>';?>
	<script> 
		var datastring = '<?php echo $strDiagnosis; ?>';
	</script>
		  <div id="piechartdiv5"></div>
		  <?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/Pie2D.swf", "pieChartId2", "30%", "350", "0", "0", "datastring", "piechartdiv5"); ?>	
	</div>
	</div>
<?php }
if(!empty($patientList)){
$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center" width=85%
	 style="text-align: center;">
	 <tr>
	 <td colspan="2"><?php echo "Total <b>Scheduled</b> Patients: <b>".$scheduleCount[0][0]['count']."</b> &nbsp;&nbsp;&nbsp;
								 Total <b>Arrived</b> Patients: <b>".$arriveCount[0][0]['count']."</b>";?>
	 </td></tr>
	<tr class="row_title">
		<td class="table_cell" style="text-align: left"><strong><?php echo $this->Paginator->sort('Patient.lookup_name', __('Patient Name', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Appointment.status', __('Arrived', true)); ?> </strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Appointment.date', __('Date of Appointment', true)); ?> </strong></td>
		</tr>
<?php 
	$toggle=0;
			foreach($patientList as $key=>$value){
				$srno++;
				if($toggle == 0) {
					echo "<tr class='row_gray'>";
					$toggle = 1;
				}else{
					echo "<tr>";
					$toggle = 0;
				}?>
				<td class="table_cell" width="20%" style="text-align: left"><?php echo $value['Patient']['lookup_name'];?></td>
				<td width="40%">
				<?php 
					echo 'Arrived';				
				?></td>
				<td width="20%"><?php echo $this->DateFormat->formatDate2Local($value['Appointment']['date'],
						Configure::read('date_format'),true);?></td>
<?php }?>
<tr>
	<TD colspan="8" align="center">
			 <!-- Shows the page numbers -->
		 <?php 
		 $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		 $this->Paginator->options(array('url' =>array("?"=>$queryStr)));
		 echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
		 <!-- Shows the next and previous links -->
		 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
		 <!-- prints X of Y, where X is current page and Y is number of pages -->
		 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
		 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
		 
		    </TD>
		   </tr>


<?php }?>
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
