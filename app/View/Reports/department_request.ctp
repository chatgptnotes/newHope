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
<h3>&nbsp; <?php echo __('Department Request', true); ?></h3>
	 <span align="right" >
	 <?php echo $this->Html->link(__('Back'), array('controller'=>'pharmacy','action' => 'department_store'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
	
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('',array('type'=>'GET','id'=>'department_containt'));?>
 
			<table  align="center" cellpadding="0" cellspacing="" border="0" >
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
					<td><?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false)); ?></td>
					<td>&nbsp;</td>
					<td><?php 
		$queryString  = $this->params->query; 
		$queryString['action']='excel' ; 
		echo $this->Html->link('Generate Excel',array('controller'=>'Reports','action'=>'department_request','?'=>$queryString),array('escape'=>false,'title' => 'Export To Excel','class'=>'blueBtn','escape' => false));
	?></td>
					 <td>&nbsp;</td>
					<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'department_request'),array('escape'=>false, 'title' => 'refresh'));?></td>
				</tr>
			</table> 
				<div class="clr ht5"></div>
			<table width="100%" cellpadding="0" cellspacing="0" border="" class="tabularForm">
				<thead>
					<tr height="25px">
						<th width="5px"  align="center" style="text-align:center;"><?php echo __('SNO.');?></th>
						<th width="51px" align="center" style="text-align:center;"><?php echo __('DEPARTMENT_NAME');?></th>
						<th width="51px" align="center" style="text-align:center;"><?php echo __('GRAND_QUANTITY');?></th>
						<th width="50px" align="center" style="text-align:center;"><?php echo __('GRAND_MRP_PRICE');?></th>
						<th width="48px" align="center" style="text-align:center;"><?php echo __('GRAND_COST_PRICE');?></th>
						<th width="90px" align="center" style="text-align:center;"><?php echo __('GRAND_RATE');?></th>
					</tr>
				</thead>
				<tbody>
				<?php if(count($record)>1){  $count = 0;
				 	foreach($record as $key=>$val): if(!empty($val['qty'])){ $count++;  ?>
				<tr>
					<td align="center" style="text-align:center;"><?php echo $count; ?></td>
					<td align="center" style="text-align:center;"><?php echo $val['department']; ?></td>
					<td align="center" style="text-align:center;"><?php echo number_format($val['qty']); ?></td>
					<td align="center" style="text-align:center;"><?php echo number_format($val['amount']); ?></td>
					<td align="center" style="text-align:center;"><?php echo number_format($val['price']);; ?></td>
					<td align="center" style="text-align:center;"><?php echo ''; ?></td>
				</tr>
				<?php } endforeach;?>
				<?php } else { ?>
					<tr>
						<td colspan="6" align="center"><?php echo __("no record found"); ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table> 


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

