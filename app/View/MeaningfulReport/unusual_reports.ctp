<div class="inner_title">
	<h3>
		&nbsp;
		<?php  echo __('Unusual high Prescription/lab/rad orders Report', true); ?></h3>
		<span style="float: right;"><?php	 
	echo $this->Html->link('Excel Report',array('controller'=>$this->params->controller,'action'=>$this->params->action,$report,'excel',
'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));?><?php 
	echo $this->Html->link('Back',array('controller'=>'MeaningfulReport','action'=>'pcmh_automated_measure', 'admin'=>true),array('escape'=>false,'class'=>'blueBtn'));?> </span>
</div>
<?php
echo $this->Form->create('patientWiseList',array('id'=>'patientWiseList','type'=>'get','url'=>array('controller'=>'MeaningfulReport','action'=>'unusual_reports',$report,'admin'=>false),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
<table width="35%" align="center">
	<tr>
		<td width="10%"><?php echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",
						'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From','value'=>$this->params->query['dateFrom']));?>
		</td>
		<td width="10%"><?php echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",
						'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To','value'=>$this->params->query['dateTo']));?>
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

<?php if(!empty($patientList)){
?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center" width=85%
	 style="text-align: center;">
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo __('Sr No'); ?> </strong></td>
		<td class="table_cell" style="text-align: left"><strong><?php echo __('Patient Name'); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Patient MRN '); ?> </strong></td>		
		</tr>
		<?php if($report=='rad'){
			$pagingOption='RadiologyTestOrder';
		}
		if($report=='lab'){
			$pagingOption='LaboratoryTestOrder';
		}
		if($report=='prescriptions'){
			$pagingOption='NewCropPrescription';
		}
		
		$srno= $this->params->paging[$pagingOption]['limit']*($this->params->paging[$pagingOption]['page']-1) ;		
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
				<td class="table_cell" width="5%"><?php echo $srno;?></td>
				<td class="table_cell" width="20%" style="text-align: left"><?php echo $value['Patient']['lookup_name'];?></td>
				<td width="40%">
				<?php 
				echo $value['Patient']['patient_id'];				
				?></td>
				
				
<?php }?>
</tr>
<tr>
	<TD colspan="8" align="center">
			 <!-- Shows the page numbers -->
		 <?php //debug($this->params['pass']);
		  $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		 $this->Paginator->options(array('url' =>array($this->params['pass'][0],"?"=>$queryStr)));
		  ?>
		 <!-- Shows the next and previous links -->
		 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
		 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links'));?>
		 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
		 <!-- prints X of Y, where X is current page and Y is number of pages -->
		 <span class="paginator_links"><?php echo '<br >'.$this->Paginator->counter(array('class' => 'paginator_links')); ?>
		    </TD>
		   </tr>
</table>
<?php }?>

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
