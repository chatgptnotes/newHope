<?php  if(!($this->request['isAjax'])){
	/* echo $this->Html->script(array('jquery.fancybox-1.3.4','jquery.blockUI'));
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css')); */
	echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js',
			'jquery.validationEngine2','/js/languages/jquery.validationEngine-en','ui.datetimepicker.3.js','jquery.fancybox-1.3.4','jquery.blockUI'));
	echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','jquery.fancybox-1.3.4.css')) ;
	
}?>

 
<div style="padding-left: 20px; padding-top: 20px">
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center;border: solid 1px black">
		<tr>
			<th class="table_cell" colspan="8" align="left">Patient Name : <?php 
			if(is_null($data[0]['PharmacySalesBill']['patient_id']))
				echo ucfirst($data[0]['PharmacySalesBill']['customer_name']);
			else
				echo ucfirst($data[0]['Patient']['lookup_name']);?></th>
		
		</tr>
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
			<td class="table_cell" align="left"><strong><?php echo  __('Discount', true); ?></strong>
			</td>
			 <td class="table_cell" align="left"><strong><?php echo __('Action', true);?> </strong>
			</td>
			
			
		</tr>
		<?php 
		$cnt =0; $totalBill=0; 
		if(count($data) > 0) {
       foreach($data as $sale):
       $cnt++;
       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format" align="left"><?php echo  ($sale['PharmacySalesBill']['bill_code']); ?>
			</td>
			
			<!-- <td class="row_format" align="left"><?php
			if(is_null($sale['PharmacySalesBill']['patient_id']))
				echo ucfirst($sale['PharmacySalesBill']['customer_name']);
			else
				echo ucfirst($sale['Patient']['lookup_name']);
			?>
			</td>-->
			<td class="row_format" align="left"><?php echo ucfirst($sale['PharmacySalesBill']['payment_mode']); ?>
			</td><?php //debug($sale);?>
			<?php //if(!empty($sale['PharmacySalesBill']['modified_time'])){ ?>
			<!--<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['PharmacySalesBill']['modified_time'],Configure::read('date_format')); ?>
			</td>-->
			<?php //}else{ ?>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['PharmacySalesBill']['create_time'],Configure::read('date_format')); ?>
			</td>
			<?php //} ?>
			<td class="row_format" align="left"><?php $total = $sale['PharmacySalesBill']['total'];
			 echo  number_format($total,2);?>
			</td>
			
			<td class="row_format" align="left">
				<?php
				$discount = $sale['PharmacySalesBill']['discount']; 
				$paid = $sale['PharmacySalesBill']['paid_amnt'];
			 	echo  number_format($paid/*-$discount*/,2); ?>
			</td>
			
			<td class="row_format" align="left"><?php $discount=$sale['PharmacySalesBill']['discount'];
			 echo  number_format($discount,2);?>
			</td>
			<td class="row_action" align="left">
			<?php echo $this->Html->link($this->Html->image('/img/icons/edit-icon.png', array('title' => 'Edit Direc Sales')),array('action' => 'inventory_edit_sales_bill',$sale['PharmacySalesBill']['id'],'editDirectView'), array('escape' => false));?>
			<?php echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales')),'javascript:void(0)'/*array('action' => 'get_pharmacy_details','sales',$sale['PharmacySalesBill']['id'])*/, array('class'=>'view','escape' => false,'id'=>'sales_'.$sale['PharmacySalesBill']['id'])); ?>
			<?php echo $this->Html->link($this->Html->image('/img/icons/return.png', array('title' => 'Return Sales')),'javascript:void(0)', array('class'=>'return','escape' => false,'id'=>'return_'.$sale['PharmacySalesBill']['id'])); ?>
			<?php echo $this->Html->image('/img/icons/cash_collected.png', array('title' => 'Cash Collect','class'=>'cashCollected','id'=>'cash_'.$sale['PharmacySalesBill']['id'],'account_id'=>$sale['PharmacySalesBill']['account_id']));  ?>
			<?php 
			$website=$this->Session->read('website.instance');
			if($website=='kanpur')
			{
			echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', 
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacySalesBill',$sale['PharmacySalesBill']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print without Header')); 
            echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
		            array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacySalesBill',$sale['PharmacySalesBill']['id'],'?'=>'flag=header'))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print with Header'));
			/* echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
		            array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printRefundPayment','inventory'=>false,$sale['PharmacySalesBill']['id'] /*,'?'=>'flag=header))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print Refund Receipt')); */
			}elseif($website=='vadodara')
			{
				/*echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
						array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacySalesBill',$sale['PharmacySalesBill']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print without Header'));*/
				echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
						array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacySalesBill',$sale['PharmacySalesBill']['id'],'?'=>'flag=header'))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print with Header'));
			}
			else
			{
				echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
						array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacySalesBill',$sale['PharmacySalesBill']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));
				
			}
?>        	
			<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action'=>'inventory_sales_delete','sales', $sale['PharmacySalesBill']['id']), array('escape' => false),__('Are you sure?', true)); ?>
			</td>
			</tr>
		<?php $totalBill=$totalBill+$total;
		endforeach;
		}
		?>
 		<tr>
 		<td colspan="3" align="right"><b>Total Bill Cost :</b></td>
 		<td align="left"><b><?php echo number_format(round($totalBill),2);?></b> </td></tr>
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
		'type': 'iframe',
		'href': "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "get_pharmacy_details","sales","inventory"=>true)); ?>"+'/'+billId[1],
		'onLoad': function () {//window.location.reload();
			}
		});
 })
 
  $('.return').click(function(){
		var return_id = $(this).attr('id');
		var billId = return_id.split('_');
	 $.fancybox({
		'width' : '80%',
		'height' : '80%',
		'autoScale': false,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'iframe',
		'href': "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "get_other_pharmacy_details","return_detials","inventory"=>true)); ?>"+'?saleBill_id='+billId[1],
		'onLoad': function () {//window.location.reload();
			}
		});
 })

   $('.cashCollected').click(function(){
		var cash_id = $(this).attr('id');
		var billId = cash_id.split('_');
	 $.fancybox({
		'width' : '80%',
		'height' : '80%',
		'autoScale': false,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'iframe',
		'href': "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "get_other_pharmacy_details","cash_collected","inventory"=>true)); ?>"+'?saleBill_id='+billId[1],
		//'href': "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "get_other_pharmacy_details","return_detials","inventory"=>true)); ?>"+'?saleBill_id='+billId[1],
		'onLoad': function () {//window.location.reload();
			}
		});
 })
 </script>