<div class="inner_title">
	<h3>
		&nbsp;
		<?php  echo __('Patient List', true); ?>
	</h3>
	<span><?php 
	echo $this->Html->link('Back',array('controller'=>'MeaningfulReport','action'=>'pcmh_automated_measure', 'admin'=>true),array('escape'=>false,'class'=>'blueBtn'));?> </span>
	<span style="float: right;"><?php	 
		echo $this->Html->link('Excel Report',array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',$doctor_id,
		'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));?></span>
	</div>

<?php if(!empty($patientList)){?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center" width=85%
	 style="text-align: center;">
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo __('Sr No'); ?> </strong></td>
		<td class="table_cell" style="text-align: left"><strong><?php echo __('Physician Name'); ?>
		</strong></td>
		<td class="table_cell" style="text-align: left"><strong><?php echo __('Patient Seen'); ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Date'); ?> </strong></td>
		</tr>
<?php 
	$toggle=0;
	if($this->params->paging['Appointment']['page']==1) {
		$srno=0;
	}else{
		$srno= $this->params->paging['Appointment']['limit']*($this->params->paging['Appointment']['page']-1) ;		
	}
	
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
				<td class="table_cell" width="20%" style="text-align: left"><?php 
				echo $value['User']['first_name'].' '.$value['User']['last_name'];				
				?></td>
				<td width="40%" class="table_cell" style="text-align: left">
				<?php echo $value['Patient']['lookup_name'];?></td>
				<td width="20%"><?php echo $this->DateFormat->formatDate2Local($value['Appointment']['date'],
						Configure::read('date_format'),true);?></td>
						
<?php } ?>
	<tr>
	<TD colspan="8" align="center">
			 <!-- Shows the page numbers -->
		 <?php //debug($this->params['pass']);
		  $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		 $this->Paginator->options(array('url' =>array($this->params['pass'][0],$this->params['pass'][1],"?"=>$queryStr)));
		 echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
		 <!-- Shows the next and previous links -->
		 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
		 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
		 <!-- prints X of Y, where X is current page and Y is number of pages -->
		 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		    </TD>
		   </tr>

</table><?php }?>
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
