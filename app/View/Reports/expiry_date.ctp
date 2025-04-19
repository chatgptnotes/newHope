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
		
	 </span>
	
</div>
<?php echo $this->Form->create('',array('id'=>'expiryDate'));?>
 <div class="clr ht5"></div>
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
		 			<?php echo $this->Form->input('',array('name'=>'department','empty'=>'Please select','options'=>array('Pharmacy'=>'Pharmacy'),'id'=>'guarantor_id', 'class'=>'textBoxExpnd','label'=> false,'div' => false,)); ?>
		 		</td>
		 		<td>&nbsp;</td> 
				<td><?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false)); ?>
								
				</td>
				<td>&nbsp;</td> 
				<td><?php echo $this->Form->submit(__('Generate Excel'),array('style'=>'padding:0px;','class'=>'blueBtn','id'=>'ExcelGenerate','div'=>false,'label'=>false)); ?></td>
				<td>&nbsp;</td> 
		 		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'expiry_date'),array('escape'=>false, 'title' => 'refresh'));?></td>
		 		
			</tr>
			</table>
				
				<div class="clr ht5"></div>
			<table  width="100%" cellpadding="0" cellspacing="0" border="" class="tabularForm">
				<tr>
					<thead>
					<th width="5px" valign="top" align="center" style="text-align:center;">SNo.</th>
					<th width="51px" valign="top" align="center" style="text-align:center;">Item Name</th>
					<th width="51px" valign="top" align="center" style="text-align:center;">Cur.Stock</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Batch No.</th>
					<th width="48px" valign="top" align="center" style="text-align:center;">ExpiryDate</th>
					<th width="90px" valign="top" align="center" style="text-align:center;">ReorderLevel</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">PurPrice</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">MRP</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Grn No.</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Invoice Date</th>
					<th width="50px" valign="top" align="center" style="text-align:center;">Supplier Name</th>
					</thead>
				</tr>
				
				<?php 
					$i=0;
					foreach($record as $records){ 
						$i++;
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $records['Product']['name'];?></td>
					<td><?php echo $records['PurchaseOrderItem']['stock_available'];?></td>
					<td><?php echo $records['PurchaseOrderItem']['batch_number'];?></td>
					<td><?php echo $records['PurchaseOrderItem']['expiry_date'];?></td>
					<td><?php echo $records['Product']['reorder_level'];?></td>
					<td><?php echo $records['PurchaseOrderItem']['purchase_price'];?></td>
					<td><?php echo $records['PurchaseOrderItem']['mrp'];?></td>
					<td><?php echo $records['PurchaseOrder']['purchase_order_number'];?></td>
					<td><?php echo $records['PurchaseOrder']['create_time'];?></td>
					<td><?php echo $records['Product']['supplier_name'];?></td>
				</tr>
				<?php }?>
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
