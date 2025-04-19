<div class="inner_title">
	<h3>
		&nbsp;
		<?php  echo __('Hospital readmissions within 30 days Report', true); ?></h3>
		<span style="float: right;"><?php	 
	echo $this->Html->link('Excel Report',array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',
'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));?><?php 
	echo $this->Html->link('Back',array('controller'=>'MeaningfulReport','action'=>'pcmh_automated_measure', 'admin'=>true),array('escape'=>false,'class'=>'blueBtn'));?> </span>
</div>

<?php 
if(!empty($patientList)){?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center" width=85%
	 style="text-align: center;">
	<tr class="row_title">
		<td class="table_cell" style="text-align: left"><strong><?php echo __('Patient Name'); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Patient Visit ID'); ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Date Of Birth'); ?> </strong></td>
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
				echo $value['Patient']['patient_id'];				
				?></td>
				<td width="20%"><?php echo $this->DateFormat->formatDate2Local($value['Person']['dob'],
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
