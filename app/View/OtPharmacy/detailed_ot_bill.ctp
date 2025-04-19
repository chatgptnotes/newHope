<?php  
	echo $this->Html->script(array('jquery.fancybox','jquery.blockUI'));
	echo $this->Html->css(array('jquery.fancybox'));
?>

<div style="padding-left: 20px; padding-top: 20px">
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align: center; border: solid 1px black">
		<tr>
			<th class="table_cell" colspan="8" align="left">Patient Name : <?php 
			if(is_null($data[0]['OtPharmacySalesBill']['patient_id']))
				echo ucfirst($data[0]['OtPharmacySalesBill']['customer_name']);
			else
				echo ucfirst($data[0]['Patient']['lookup_name']);?>
			</th>
		</tr>
		
		<tr><td><strong>Sales Bill</strong></td></tr>
		<tr>
		<td>
			<table border="0" class="table_format TbodySales" cellpadding="0" cellspacing="0" width="100%" style="text-align: center; border: solid 1px black">
			<thead>
			<tr class="row_title">
				<td class="table_cell" align="left"><?php echo  __('Bill No.', true); ?>
				</td>
				<!--  <td class="table_cell" align="left"><strong><?php echo __('Customer', true); ?> </strong>
				</td>-->
				<td class="table_cell" align="left"><strong><?php echo  __('Mode', true); ?>
				</strong></td>
				<td class="table_cell" align="left"><strong><?php echo  __('Date', true); ?>
				</strong></td>
				<td class="table_cell" align="left"><strong><?php echo  __('Amt.', true); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong>
				</td>
				<td class="table_cell" align="left"><strong><?php echo  __('Paid', true); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong>
				</td>
				<td class="table_cell" align="left"><strong><?php echo  __('Discount', true); ?>
				</strong>
				</td>
				<td class="table_cell" align="left"><strong><?php echo __('Action', true);?>
				</strong>
				</td>
			</tr>
			</thead>
			<?php
			$cnt =0; $totalBill=0;
			if(count($data) > 0) { foreach($data as $sale):
	       		$cnt++;
	       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format" align="left"><?php echo  ($sale['OtPharmacySalesBill']['bill_code']); ?>
			</td>

			<!-- <td class="row_format" align="left"><?php
			if(is_null($sale['OtPharmacySalesBill']['patient_id']))
				echo ucfirst($sale['OtPharmacySalesBill']['customer_name']);
			else
				echo ucfirst($sale['Patient']['lookup_name']);
			?>
			</td>-->
			<td class="row_format" align="left"><?php echo ucfirst($sale['OtPharmacySalesBill']['payment_mode']); ?>
			</td>
			<?php if(!empty($sale['OtPharmacySalesBill']['modified_time'])){ ?>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['OtPharmacySalesBill']['modified_time'],Configure::read('date_format')); ?>
			</td>
			<?php }else{ ?>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['OtPharmacySalesBill']['created_time'],Configure::read('date_format')); ?>
			</td>
			<?php } ?>
			<td class="row_format" align="left"><?php $total=$sale['OtPharmacySalesBill']['total']+ ($sale['OtPharmacySalesBill']['total'] * $sale['OtPharmacySalesBill']['tax']/100);
			echo  number_format($total,2);?></td>
			<td class="row_format" align="left"><?php
			if(ucfirst($sale['OtPharmacySalesBill']['payment_mode']) == "Credit"){
			 		$paid = $sale['OtPharmacySalesBill']['paid_amount'];
			 }else{
				$paid = $sale['OtPharmacySalesBill']['total']-$sale['OtPharmacySalesBill']['discount'];
			 }
			 echo  number_format($paid,2);?></td>
			<td class="row_format" align="left"><?php $discount=$sale['OtPharmacySalesBill']['discount'];
			echo  number_format($discount,2);?></td>
			<td class="row_action" align="left">
			<?php 
			  echo $this->Html->link($this->Html->image('/img/icons/edit-icon.png', array('title' => 'edit Sales')),
									array('action' => 'edit_sales_bill',$sale['OtPharmacySalesBill']['patient_id'],'edit',$sale['OtPharmacySalesBill']['id']), 
									array('escape' => false));
			  echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales')),'javascript:void(0)', 
									array('class'=>'view','escape' => false,'id'=>'sales_'.$sale['OtPharmacySalesBill']['id']));  
			  echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
									array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_view','OtPharmacySalesBill',
									$sale['OtPharmacySalesBill']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print with Header'));
			if($paid == 0){
			  echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action'=>'sales_delete','sales', 
								$sale['OtPharmacySalesBill']['id']), array('escape' => false),__('Are you sure?', true));
			}
			 ?>
			</td>
		</tr>
		
		<?php $totalBill=$totalBill+$total; 
		endforeach;
		}
		?>
		<tr>
			<td colspan="4" align="right"><b>Total Bill Cost :</b></td>
			<td align="left"><b><?php echo number_format($totalBill,2);?> </b>
			</td>
		</tr>
	</table>
	</td>
	</tr>
	<!-- end Sales Bill -->
	
	<!-- Sales Return -->
	<?php if(count($returnData) > 0 ) { ?>
	<tr><td><strong>Sales Return</strong></td></tr>
	<tr>
	<td>
		<table border="0" class="table_format TbodySales" cellpadding="0" cellspacing="0" width="100%" style="text-align: center; border: solid 1px black">
			<tr class="row_title">
				<td class="table_cell" align="left"><?php echo  __('Bill No.', true); ?>
				</td> 
				<td class="table_cell" align="left"><strong><?php echo  __('Date', true); ?>
				</strong></td> 
				<td class="table_cell" align="left"><strong><?php echo  __('Return Amt', true); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong>
				</td> 
				<td class="table_cell" align="center" style="width: 125px;"><strong><?php echo __('Action', true);?></strong>
				</td> 
			</tr>
			
			<?php  $cnt =0; $totalBill = 0; 
       		foreach($returnData as $sale): $cnt++;
       		?>
			<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
				<td class="row_format" align="left"><?php echo  ($sale['OtPharmacySalesReturn']['bill_code']); ?>
				</td> 
				<?php if(!empty($sale['PharmacySalesBill']['modified_time'])){ ?>
				<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['OtPharmacySalesReturn']['modified_time'],Configure::read('date_format')); ?>
				</td>
				<?php }else{ ?>
				<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['OtPharmacySalesReturn']['created_time'],Configure::read('date_format')); ?>
				</td>
				<?php } ?>
				<td class="row_format" align="left"><?php $total=$sale['OtPharmacySalesReturn']['total'];
				echo  number_format($total,2);?></td> 
				<td class="row_format" align="left">
				<?php $returnId = $sale['OtPharmacySalesReturn']['id'];?>
				<?php echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales','onclick'=>"displayReturnList($returnId)")),'javascript:void(0);', array('escape' => false)); 
				
	        	 	echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', 
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_view','OtPharmacySalesReturn',$sale['OtPharmacySalesReturn']['id']))."', '_blank',
			           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print')); 
				 	echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action'=>'sales_delete','return',$sale['OtPharmacySalesReturn']['id']), array('escape' => false),__('Are you sure?', true));
				 ?>
	        	</td>
			</tr>
			<?php $totalBill=$totalBill+$total; 
			endforeach; 
			?>
			<tr>
				<td colspan="3" align="right"><b>Total Bill Cost :</b></td>
				<td align="left"><b><?php echo number_format($totalBill,2);?> </b>
				</td>
				
			</tr>
		</table>
	</td>
	</tr>
	<?php }?>
	<!-- end Sales Return -->
</table>
</div>

<script>
 $('.view').click(function(){
		var sales_id=$(this).attr('id');
		var billId=sales_id.split('_');
	 $.fancybox({
		'width' : '100%',
		'height' : '150%',
		'autoScale': false,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'ajax',
		'href': "<?php echo $this->Html->url(array("controller"=>"OtPharmacy", "action" => "get_ot_details","sales")); ?>"+'/'+billId[1],
		'onLoad': function () {//window.location.reload();
			}
		});
 })

 function displayReturnList(id){
	 $.fancybox({
		'width' : '80%',
		'height' : '100%',
		'autoScale': false,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'iframe',
		'href': "<?php echo $this->Html->url(array('controller'=>'OtPharmacy','action' => 'get_ot_details','sales_return')); ?>"+"/"+id+"/salesBill",
		'onLoad': function () {//window.location.reload();
			}
		});
 }
 </script>
