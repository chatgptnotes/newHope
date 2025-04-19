<?php  
	echo $this->Html->script(array('inline_msg','jquery.blockUI','jquery.fancybox-1.3.4'));
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.fancybox-1.3.4.css' ));   
 
	//echo $this->Html->script('jquery.autocomplete_pharmacy');
	//echo $this->Html->css('jquery.autocomplete.css');
?>

<style>.row_action img{float:inherit;}
.inner_title{
	padding-top: 1px;
}
.table_format {
    padding: 0px;
}
.Tbody {
	width: 100%;
	height: 500px;
	display: list-item;
	overflow: auto;
}
</style>

<div>
	<div class="inner_title">
		<?php echo $this->element('pharmacy_menu');?>
		<h3>Direct Sales Details</h3>
		<?php $search = "search"; $sales = "sales"; ?>
		<form action='<?php echo $this->Html->url(array('type'=>'get','action' => 'get_other_pharmacy_details',$sales,$search),true);?>'>
		<?php ?>
			<table border="0" class="table_format" cellpadding="0" cellspacing="0"
				align="center" width="85%" style="text-align: center;">
				<tr>
					<td>Bill No.</td>
					<td><input type="text" name="billno" id="bill_no" value='' class="textBoxExpnd"></td>
					<td>Patient Name/ID</td>
					<td><input type="text" name="customer_name" id="customer_name" class="textBoxExpnd" value="<?php echo $this->request->data['customer_name']?>"></td>
				
					<td>From:</td>
					<td><input type="text" name="fromDate" id="fromDate" value="<?php echo $this->request->query['fromDate']?>" size="12" class="textBoxExpnd"></td>
					
					<td>To:</td>
					<td><input type="text" name="toDate" id="toDate" value="<?php echo $this->request->query['toDate']?>" size="12" class="textBoxExpnd"></td>
					
					<td><input type="submit" name="search" value="Search" class="blueBtn"></td>
					<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action' => 'get_other_pharmacy_details','sales','search'), array('escape' => false)); ?></td>
				</tr>
			</table>
		</form>
<span><?php
		echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>

	<div style="width:55%; float: left;max-height:500px;overflow:scroll;">   
	<?php echo $this->Form->create('InventoryOtherSalesBill');?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" align ="center" style="text-align: center;">
	<Tbody>
		<tr>
			<td colspan="8" align="right">
		</tr>
		<tr class="row_title">

			<td class="table_cell" align="left"><strong><?php echo __('Patient Name', true); ?> </strong></td>
			<!--<td class="table_cell" align="left"><strong><?php echo  __('Date', true); ?></strong></td>-->
			<!--<td class="table_cell" align="left"><strong><?php echo __('Mode', true); ?> </strong></td>-->
			<td class="table_cell" align="left"><strong><?php echo  __('Total', true); ?></strong></td>
			<td class="table_cell" align="left"><strong><?php echo  __('Paid', true); ?></strong></td>
			<td class="table_cell" align="left"><strong><?php echo  __('Discount', true); ?></strong></td>
			<td class="table_cell" align="left"><strong><?php echo  __('Refund', true); ?></strong></td>
			<td class="table_cell" align="left"><strong><?php echo  __('Return', true); ?></strong></td>
			<td class="table_cell" align="left"><strong><?php echo  __('Bal', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo __('Action', true);?> </strong></td>
		</tr>
		
		<?php
			$cnt =0; 	
		if(count($saleBill)>0){	
	       foreach($saleBill as $sale){ 
		   	$cnt++;
       ?>
       <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
       		<input name="customer_id" id="customer_id" value="<?php echo $sale['PharmacySalesBill']['id'];?>" type="hidden" />
       		<input name="customer_id" id="account_id" value="<?php echo $sale['PharmacySalesBill']['account_id'];?>" type="hidden" /><?php /* debug($sale['PharmacySalesBill']['id']);
       		debug($sale['PharmacySalesBill']['customer_name']);*/ ?>

			<td class="row_format" align="left" id="customer_nm"><?php echo $sale['PharmacySalesBill']['customer_name'];?></td>
				
			<!--<td class="row_format" align="left" id="date">
			<?php
				echo $this->DateFormat->formatDate2Local($sale['PharmacySalesBill']['create_time'],Configure::read('date_format'));  
			?>
			</td>
			--><!--<td class="row_format" align="left" id="payment_mode">
			<?php echo $sale['PharmacySalesBill']['payment_mode'];?>
			</td>-->
			<?php $refund = $sale[0]['refundAmount'];?>
			
			<?php //if($sale['PharmacySalesBill']['payment_mode']== 'Cash' ){ ?>
				<td class="row_format" align="left" id="saleBillTotal">	
				
					<?php $total=$sale[0]['total'];   $discount = $sale[0]['disc']; 
						echo number_format($total,2); ?>
				</td>
				<td class="row_format" align="left" id="paid">
					<?php $paidAmnt = $sale[0]['paidAmnt']/* - $discount*/;
						echo number_format($paidAmnt,2); ?>
				</td>
				<td class="row_format" align="left" >
					<?php 
						echo number_format($discount,2); ?>
				</td>
				<td class="row_format" align="left"><?php  
				 echo number_format($refund,2);?>
				</td>
				<td class="row_format" align="left"><?php  
				 $returnAmt = !empty($returnListArray[$sale['PharmacySalesBill']['account_id']])?$returnListArray[$sale['PharmacySalesBill']['account_id']]:0 ;
				 echo  number_format($returnAmt,2);?>
				</td>
				<td class="row_format" align="left"><?php echo number_format(round($total- $paidAmnt - $discount + $refund - $returnAmt),2); ?></td>
			<?php //}else{
			if(1==0){ //not in use ?>
				<td class="row_format" align="left" id="saleBillTotal">
					<?php  $total=$sale['PharmacySalesBill']['total'] ; $discount =  $sale['PharmacySalesBill']['discount'];
						  echo 	number_format(round($total),2);	
					 ?>
				</td>
				<td class="row_format" align="left" id="paid">
					<?php if(!empty($sale['PharmacySalesBill']['paid_amnt'])){
							echo $paidAmnt = round($sale['PharmacySalesBill']['paid_amnt'])/* - $discount*/;
						}else{
								echo "0.00";
							} ?>
				</td>
				<td class="row_format" align="left"><?php  
				 $returnAmt = !empty($returnListArray[$sale['PharmacySalesBill']['id']])?$returnListArray[$sale['PharmacySalesBill']['id']]:0 ;
				 echo  number_format(round($returnAmt),2);?>
				</td>
				<!--<td class="row_format" align="left"><?php echo "0.00" ;?></td>-->
				<td class="row_format" align="left"><?php echo number_format(round($total-$paidAmnt - $sale['0']['disc'] - $returnAmt + $refund- $returnAmt),2); ?></td>
			<?php } ?>
			<td class="row_format" align="left">
				<?php 
				 echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales')),'javascript:void(0)', array('escape' => false,'class'=>'view_sales','customer_id'=>$sale['PharmacySalesBill']['id'],
				'account_id'=>$sale['PharmacySalesBill']['account_id']));
				?>
				<?php echo $this->Html->image('/img/icons/money.png', array('title' => 'Money Collected','class'=>'bill_detail','customer_id'=>$sale['PharmacySalesBill']['account_id']));?>
				<?php //debug($sale['PharmacySalesBill']['id']); ?>
				<?php //echo $this->Html->image('/img/icons/cash_collected.png', array('title' => 'Cash Collect','class'=>'cash_detail','customer_id'=>$sale['PharmacySalesBill']['id'],'account_id'=>$sale['PharmacySalesBill']['account_id']));  ?>
				<?php //echo $this->Html->image('/img/icons/return.png', array('title' => 'Return','class'=>'return','customer_id'=>$sale['PharmacySalesBill']['id'],'account_id'=>$sale['PharmacySalesBill']['account_id']));  ?>
			</td>
		</tr>
		<?php }?>
		<tr> 
		<?php 
// 		if($saleBill){
// 				$queryStr = $this->General->removePaginatorSortArg($this->request->query) ;  //for sort column
// 				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
// 			}
			
		?>
		<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array('sales','search',"?"=>$queryStr)));?>
 			<TD colspan="8" align="center"> 
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			
 			</TD> 
 		</tr> 
		<?php }else{?>
		<tr>
			<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php } ?>
		</Tbody> 
	</table>
	<?php echo $this->Form->end();?>
	</div>
	<div style="width: 44%; float: right;margin-left:10px;" id="rightView_content"></div>
</div>
<script>
$(document).ready(function(){
	$('#customer_name').autocomplete({
		source:	"<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","PharmacySalesBill","customer_name","null","null","no","1=1","account_id", "admin" => false,"plugin"=>false)); ?>",
		minLength: 1,
		 select: function( event, ui ) {
			console.log(ui.item);	
		 },
		 messages: {
	        noResults: '',
	        results: function() {}
		 }
	});

	$("#bill_no").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_direct_bill","bill_code","inventory" => true,"plugin"=>false)); ?>",
		minLength: 1, 
		select: function( event, ui ) {
			console.log(ui.item);
		},
		messages: {
	        noResults: '',
	        results: function() {}
	 	}	
		}); 
});
		
$('.view_sales').click(function(){ 
	//var customer_nm = $('#customer_nm').html(); 
	var customerId = $(this).attr('customer_id');
	var accountId = $(this).attr('account_id');
	
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "get_other_pharmacy_details","detailView",'',"inventory"=>true)); ?>"+'/'+null+'/'+accountId+'?customer_id='+customerId,
		  context: document.body,
		  beforeSend:function(){
			  loading('rightView_content','id');
		  }, 	  		  
		  success: function(data){ 
				
				$('#rightView_content').html(data);
				onCompleteRequest('rightView_content','id');
		}
		  
	});
	
	});
	
	$('.bill_detail').click(function(){
	var patient_id=$(this).attr('customer_id');
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "get_direct_bill","inventory"=>false)); ?>"+'/'+patient_id,
		  context: document.body,
		  beforeSend:function(){
			  loading('rightView_content','id');
		  }, 	  		  
		  success: function(data){ 
				$('#rightView_content').html(data);
				onCompleteRequest('rightView_content','id');
			 // obj.attr('src','../theme/Black/img/icons/green.png').attr('title','Medication Administered').removeClass('med');
		  }
		  
	});
});

	$( "#fromDate" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
	});

	$( "#toDate" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,
		yearRange: '1950',
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
	});
	/*$('.cash_detail').click(function(){
		 var patient_id = $(this).attr('customer_id') ; 
		 var patient_name = $('#customer_nm').html();
		 var accountId = $(this).attr('account_id');
		
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "get_other_pharmacy_details","cash_collected","inventory"=>true)); ?>"+'/'+null+'/'+accountId+'?patientName='+patient_name+'&saleBill_id='+patient_id,
		  context: document.body,
		  beforeSend:function(){
			  loading('rightView_content','id');
		  }, 	  		  
		  success: function(data){ 
				$('#rightView_content').html(data);
				onCompleteRequest('rightView_content','id');
		  }
		  
		});
	});*/

	/*$(document).on('click','.return',function(){
		 var patient_id = $(this).attr('customer_id') ; 
		 var patient_name = $('#customer_nm').html();
		 var accountId = $(this).attr('account_id');
		
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "get_other_pharmacy_details","return_detials","inventory"=>true)); ?>"+'/'+null+'/'+accountId+'?patientName='+patient_name+'&saleBill_id='+patient_id,
		  context: document.body,
		  beforeSend:function(){
			  loading('rightView_content','id');
		  }, 	  		  
		  success: function(data){ 
				$('#rightView_content').html(data);
				onCompleteRequest('rightView_content','id');
		  }
		  
		});
	});*/

</script>