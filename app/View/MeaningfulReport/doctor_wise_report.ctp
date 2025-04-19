<?php
echo $this->Html->script(array('/fusioncharts/fusioncharts', 'expand'));
?>
<div class="inner_title">
<h3><font style="color:#000"><?php 
if(!empty($date)){	
 echo __('Percentage of Patients Seen by Physician Report From '.date('d/m/Y',strtotime($date[0])).' To '.date('d/m/Y',strtotime($date[1])), true);}
 else{
	echo __('Percentage of Patients Seen by Physician Report-'.date('Y'), true);}?> </font></h3>
<span style="float: right;"><?php if(!empty($this->params->query)){	 
			echo $this->Html->link('Excel Report',array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',
			'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));
			}
			else{
			echo $this->Html->link('Excel Report',array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',
					),array('id'=>'excel_report','class'=>'blueBtn'));
			}?><?php 
			echo $this->Html->link('Back',array('controller'=>'MeaningfulReport','action'=>'pcmh_automated_measure', 'admin'=>true),array('escape'=>false,'class'=>'blueBtn'));?> </span>
	</div>
	<?php echo $this->Form->create('doctorWiseReport',array('type'=>'GET','id'=>'doctorWiseReport','url'=>array('controller'=>'MeaningfulReport','action'=>'doctor_wise_report','admin'=>false),
			'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
	<table width="40%" align="center">
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
	<div>&nbsp;</div>    
     <div class="clr ht5"></div>
     
	<div style="float: left;">
	<table width="100%">
	<tr>
	<td><b>Physician Name</b></td>
	<td><b>No.of Patients</b></td>
	</tr>
	<?php //debug($this->params);
     foreach($pieData as $key=>$data){
		echo '<tr><td>'.$data['name'].'</td>';?>
		<td style="text-align:center;"><?php if(!empty($this->params->query)){
			echo $this->Html->link($data['count'],array('controller'=>$this->params->controller,'action'=>$this->params->action,'null',$key,
			'?'=>$this->params->query),array('target' => '_blank'));
		}else{
		echo $this->Html->link($data['count'],array('controller'=>$this->params->controller,'action'=>$this->params->action,'null',$key),array('target' => '_blank'));
		}?><td>
		</tr>
		
	<?php  }
     ?> 
	<tr>
	<td ><?php echo '<b> Total no.of Patients Arrived At Clinic'?></td>
	<td style="text-align:center;"><?php echo $totalPatient[0][0]['count'];?></td></tr>
	</table>
         
     </div>
     <div id="ChartId4" align="center">
	<?php /* showpercentintooltip="0"*/
	$strDiagnosis='<chart showvalues="1" caption="Physician Report" captionPadding="20" showZeroPies="0"  showlegend="1" enablesmartlabels="1" showlabels="0"  bgColor="#1B1B1B" bgAlpha="100" baseFontColor="#fff" legendBgColor="#1B1B1B" toolTipBgColor="#1B1B1B" legendBgAlpha="100" showBorder="0" minimiseWrappingInLegend ="1" legendPosition="RIGHT">';
		foreach($pieData as $key=>$pieData)
		{
			if(!empty($this->params->query)){
				$query = http_build_query($this->params->query) ;
				$url='n-'.$this->here.'/null/'.$key.'?'.$query;
			}else{
				$url='n-'.$this->here.'/null/'.$key;
			}
				$strDiagnosis.='<set value="'.$pieData['count'].'" label="'.$pieData['name'].'" link="'.$url.'"/>';
		}
		$strDiagnosis.='</chart>';?>
	<script> 
		var datastring = '<?php echo $strDiagnosis; ?>';
	</script>
		  <div id="piechartdiv4"></div>
		  <?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/Pie2D.swf", "pieChartId1", "35%", "350", "0", "0", "datastring", "piechartdiv4"); ?>	
	</div>
	
	
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

