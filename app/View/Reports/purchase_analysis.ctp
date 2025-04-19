<?php
	echo $this->Html->script(array('inline_msg','jquery.selection.js','jquery.fancybox-1.3.4'  ,'jquery.blockUI','jquery.contextMenu'));
?>

<style>

.tabularForm th{
	padding: 0px 0px ;
}
.table_format {
	/*border: 1px solid #3E474A;*/
	background:#f5f5f5;
}
.first_row{
	padding-bottom: 185px;
	
}
.row_gray{ background:none;}
.nav_link{ width:85%; float:left; margin:0px; padding:20px;}
.links{ float:left; font-size:13px; clear:left; line-height:30px;}
.links:hover{ background:#F5F5F5;padding:0px; margin:0px;text-decoration: none !important;}
.nav_link a:hover{text-decoration: none !important;}
.table_format td{ border-bottom:1px solid #DCDCDC;}
#report_1{ font-weight: bold;};



</style>



<div class="inner_title">
<?php echo $this->element('navigation_menu',array('pageAction'=>'Store')); ?>
<h3>&nbsp; <?php echo __('Drug Sale Report', true); ?></h3>
	 <span align="right" >
	 
	 	<?php echo $this->Html->link(__('Back'), array('controller'=>'pharmacy','action' => 'department_store'), array('escape' => false,'class'=>'blueBtn'));?>
		<?php echo $this->Form->submit(__('Generate Excel'),array('style'=>'padding:0px;','class'=>'blueBtn','id'=>'ExcelGenerate','div'=>false,'label'=>false)); ?> 
		
	 </span>
	
</div>
<?php echo $this->Form->create('',array('id'=>'purchaseAnalysis'));?>
 
			<table align="center" cellpadding="0" cellspacing="" border="0" >
			<tr>
			<td><?php echo __(' From : '); ?></td>
				<td>
					<?php echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",'value'=>$this->params->data['dateFrom'],
														'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From'));
					?>
				 </td>
				 <td>&nbsp;</td>
				 <td><?php echo __(' To : '); ?></td>
				 <td>				
					<?php echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",'value'=>$this->params->data['dateTo'],
										'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To'));
					?>
				</td>
				<td>&nbsp;</td>
				<td><?php echo __(' Department : '); ?></td>
		 		<td>
		 			<?php echo $this->Form->input('',array('name'=>'department','empty'=>'Please select','options'=>array('Pharmacy'=>'Pharmacy'),'class'=>'textBoxExpnd','id'=>'guarantor_id', 'label'=> false,'div' => false,)); ?>
		 		</td>
		 		<td>&nbsp;</td>
				<td><?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false)); ?>
				<td>&nbsp;</td>			
				</td>
		 		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'drug_sale_report'),array('escape'=>false, 'title' => 'refresh'));?></td>
		 		
			</tr>
			</table>
				<div class="clr ht5"></div>
				<div class="clr ht5"></div>
			<table  width="100%" cellpadding="0" cellspacing="0" border="" class="tabularForm">
				<tr>
					<thead>
					<th width="5px" valign="top" align="center" style="text-align:center;">SNo.</th>
					<th width="51px" valign="top" align="center" style="text-align:center;">Item Name</th>
					<th width="51px" valign="top" align="center" style="text-align:center;">Batch No. Of</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Purchase Cost</th>
					<th width="48px" valign="top" align="center" style="text-align:center;">Selling Price</th>
					<th width="90px" valign="top" align="center" style="text-align:center;">LastG</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Qty</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Average week</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Purchase Value</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Selling</th>
					</thead>
				</tr>
				
				<tr>
				</tr>
			</table> 
<?php echo $this->Form->end();?>

<script>

$(document).ready(function(){		
	$("#dateFrom").datepicker
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
			
	 $("#dateTo").datepicker
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
