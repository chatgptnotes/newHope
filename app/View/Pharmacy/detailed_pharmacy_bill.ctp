<?php  /*if(!($this->request['isAjax'])){
	 
	echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js',
			'jquery.validationEngine2','/js/languages/jquery.validationEngine-en','ui.datetimepicker.3.js','jquery.fancybox-1.3.4','jquery.blockUI'));
	echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','jquery.fancybox-1.3.4.css')) ;

	}*/
	//if(!$this->request->isAjax()){ //added by panakj cause same CTP is viewed on billing page in IFRAME
		//echo $this->Html->script(array('jquery.blockUI','jquery.fancybox'));
		//echo $this->Html->css(array('jquery.fancybox')); 
	//}
	$website=$this->Session->read('website.instance');
?>
<style>
.TbodySales {
	width: 100%;
	max-height: 200px;
	display: list-item;
	overflow: auto;
}
 .table_format td{
	padding-right: 0px !important;
	padding-bottom: none !important;
}
.table_format a {
    padding: 0px !important;
}

.row_format img {
    float: none !important;
}
.mainPharTab{
	font-family: "trebuchet MS","Lucida sans",Arial;
} 
.highlight {
    background: #907a70 !important;  
}
.highlight td{
	color: white !important;
	font-weight: bold;
}
</style>
<script>
var query = "<?php echo $this->params->query['action']; ?>";
if(query == 'print'){
window.onload=function(){self.print();} 
}
</script>  
<table  class="table_format mainPharTab" width="100%" style="padding-left: 0px;  padding-top: 5px; text-align: center; border: solid 1px black" bgcolor="#E0E0E0" max-height: 500px;>
	<tr>
		<td align="left">
			<strong>Patient Name : 
			<?php 
			if(is_null($data[0]['PharmacySalesBill']['patient_id']))
				echo ucfirst($data[0]['PharmacySalesBill']['customer_name']);
			else
				echo ucfirst($data[0]['Patient']['lookup_name']);
			?></strong>
			<?php  if($this->params->query[action] != 'print'){?>
			<strong style="float: right;">
			<?php $queryString  = $this->params->query;  
				  $queryString['action'] = 'print';
			 echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'javascript:void(0);',
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'pharmacy_details','inventory'=>true,'detail_bill','?'=>$queryString))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print All')); 
        	?>
        	</strong>
        	<?php }?>
		</td>
	</tr>
	
	<tr><td><strong>Sales Bill</strong></td></tr>
	<tr>
	<td>
		<div class="TbodySales">
		<table border="0" class="table_format " cellpadding="0" cellspacing="0" width="100%" style="text-align: center; border: solid 1px black">
		<thead>
			<tr class="row_title">
				<td class="table_cell" align="left"><strong><?php echo  __('Bill No.', true); ?></strong>
				</td> 
				<td class="table_cell" align="left"><strong><?php echo  __('Mode', true); ?>
				</strong></td>
				<td class="table_cell" align="left"><strong><?php echo  __('Date', true); ?>
				</strong></td>
				<td class="table_cell" align="right"><strong><?php echo  __('Amt.', true); ?></strong>
				</td>
				<td class="table_cell" align="right"><strong><?php echo  __('Paid', true); ?></strong>
				</td>
				<td class="table_cell" align="right"><strong><?php echo  __('Disc', true); ?>
				</strong>
				</td>
				<td class="table_cell" align="right"><strong><?php echo  __('Net Amt', true); ?>
				</strong>
				</td>
				<?php  if($this->params->query[action] != 'print'){?>
				<td class="table_cell" align="center"><strong><?php echo __('Action', true);?></strong>
				</td>
				<?php }?>
				<?php if($website == 'hope'){?>
				<td class="table_cell" align="center"> <?php  
				echo $this->Form->checkbox('selectAllPresc',array('id'=>'selectAllPresc','div'=>false,'label'=>false,'title'=>'Print All Prescription'));?>
				</td><?php }?>
			</tr>
		</thead>
		<tbody>
		<?php  $cnt =0; $totalBill=0; if(count($data) > 0) {
       			foreach($data as $sale): $cnt++;
       			if($cnt%2 == 0){
       				$rowCls = "row_gray";
       			}else{
       				$rowCls = "";
       			}
       	?>
       
		<tr class="rowMatter <?php  echo $rowCls; ?>">
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
			</td>
			<?php //if(!empty($sale['PharmacySalesBill']['modified_time'])){ ?>
			<!--<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['PharmacySalesBill']['modified_time'],Configure::read('date_format')); ?>
			</td>-->
			<?php //}else{ ?>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['PharmacySalesBill']['create_time'],Configure::read('date_format')); ?>
			</td>
			<?php// } ?>
			<td class="row_format" align="right" title="Amount"><?php $total=$sale['PharmacySalesBill']['total']+ ($sale['PharmacySalesBill']['total'] * $sale['PharmacySalesBill']['tax']/100);
			echo  number_format(round($total),2);?></td>
			<td class="row_format" align="right" title="Paid"><?php //debug($sale['PharmacySalesBill']['payment_mode']);
			if(ucfirst($sale['PharmacySalesBill']['payment_mode']) == "Credit"){
			 		$paid =  $sale['PharmacySalesBill']['paid_amnt'];
			 }else{
				$paid = $sale['PharmacySalesBill']['total']-$sale['PharmacySalesBill']['discount'];
			 }
			 echo  number_format(round($paid),2);?></td>
			<td class="row_format" align="right" title="Discount">
			<?php $discount=$sale['PharmacySalesBill']['discount'];
			echo  number_format(round($discount),2);?>
			</td>
			<td class="row_format" align="right" title="Net Amount">
			<?php $netAmnt = $total-$discount;
				echo  number_format(round($netAmnt),2);?>
			</td>
			<?php  if($this->params->query[action] != 'print'){?>
			<td class="row_format" align="right" >
				<?php echo $this->Html->link($this->Html->image('/img/icons/edit-icon.png', array('title' => 'edit Sales')),array('action' => 'edit_sales_bill',$sale['PharmacySalesBill']['patient_id'],'edit',$sale['PharmacySalesBill']['id']), array('escape' => false));?>

				<?php 
				//if(date('d/m/Y') < '20/03/2021'){

				echo $this->Html->link($this->Html->image('/img/icons/copy.png', array('title' => 'Copy Sales Bill')),array('action' => 'copy_sales_bill',$sale['PharmacySalesBill']['patient_id'],'copy',$sale['PharmacySalesBill']['id']), array('escape' => false)); 
				//}
				?> 

			<?php echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales')),'javascript:void(0)'/*array('action' => 'get_pharmacy_details','sales',$sale['PharmacySalesBill']['id'])*/, array('class'=>'view','escape' => false,'id'=>'sales_'.$sale['PharmacySalesBill']['id'])); ?>
				<?php 
				
				if($website=='kanpur')
				{
					echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacySalesBill',$sale['PharmacySalesBill']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print without Header'));
        echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'javascript:void(0);',
		array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacySalesBill',$sale['PharmacySalesBill']['id'],'?'=>'flag=header'))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print with Header'));
				}
				elseif($website=='vadodara')
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
                    //disallow print for RGJAY and RGJAY (private as on today)'s corporate as per order of Murli Sir by Swapnil - 09.11.2015
                    if(!in_array($sale['Patient']['tariff_standard_id'], $rgjayStdIds)){
						echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
							array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacySalesBill',$sale['PharmacySalesBill']['id']))."', '_blank',
				           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));
                    }
				}
				
				?> <?php //if($websiteConfig['instance'] == "kanpur"){
				//if($roleName == 'Admin'){
			if($paid == 0){
			 echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action'=>'inventory_sales_delete','sales', $sale['PharmacySalesBill']['id']), array('escape' => false),__('Are you sure?', true));
			 }
			 //}
			 //}
			 ?>
			</td>
			<?php }?>
			<?php if($website == 'hope'){?>
			<td align="center"><?php 
					echo $this->Form->input('printPresc',array('type'=>'checkBox','hiddenField'=>false,'class'=>'prescriptionPrint','title'=>'Select to Print',
							'value'=>$sale['PharmacySalesBill']['id'],'div'=>false,'label'=>false));
				?></td>
				<?php }?>
				
		</tr>
		<?php $totalBill=$totalBill+$total; 
			  $totalDiscount = $totalDiscount + $discount;
			  $totalNetAmnt =  $totalNetAmnt + $netAmnt;
			  $totalPaid = $totalPaid + $paid;
		endforeach;
		}
		?>
		<tr height="30px;">
			<td align="right" style="border-top:1px solid;" colspan="3"><b>Total : </b></td>
			<td align="right" style="border-top:1px solid;"><b><?php echo number_format(round($totalBill),2);?> </b></td> 
			<td align="right" style="border-top:1px solid;"><b><?php echo number_format(round($totalPaid),2);?></b></td>
			<td align="right" style="border-top:1px solid;"><b><?php echo number_format(round($totalDiscount),2);?></b></td>
			
			<td align="right" style="border-top:1px solid;"><b><?php echo number_format(round($totalNetAmnt),2);?></b></td>
			<td style="border-top:1px solid;"></td>
			<?php if($website == 'hope'){?>
			<td style="border-top:1px solid;" align="right"><?php 
				echo $this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;','onclick'=>'viewPrescription();','title'=>'Print Selected Prescription'));

			/*echo $this->Form->button($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),array('type'=>'button','onclick'=>'viewPrescription();','style'=>'float : right;'));*/
			?></td>
			<?php }?>
		</tr>
		</tbody>
	</table>
	</div>
	</td>
	</tr>
	<!-- end Sales Bill -->
	
	<!-- Sales Return -->
	<?php if(count($returnData) > 0 ) { ?>
	<tr><td><strong>Sales Return</strong></td></tr>
	<tr>
	<td>
	<div class="TbodySales">
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align: center; border: solid 1px black">
		 
		<tr class="row_title">
			<td class="table_cell" align="left"><?php echo  __('Bill No.', true); ?>
			</td> 
			<td class="table_cell" align="left"><strong><?php echo  __('Date', true); ?>
			</strong></td> 
			<td class="table_cell" align="right"><strong><?php echo  __('Total Amt', true); ?>
			</strong></td> 
			<td class="table_cell" align="right"><strong><?php echo  __('Return Amt', true); ?>
			</strong></td> 
			<td class="table_cell" align="right"><strong><?php echo  __('Discount', true); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong>
			</td> 
			<?php  if($this->params->query[action] != 'print'){?>
			<td class="table_cell" align="center"><strong><?php echo __('Action', true);?></strong>
			</td> 
			<?php }?>
		</tr>
		<?php  $cnt =0; $totalBill = 0; 
       		foreach($returnData as $sale): $cnt++;
       		$cls = '';
       		if($cnt%2 == 0){
       			$cls = 'row_gray';
       		}
       ?>
		<tr class="rowMatter <?php echo $cls; ?>">
			<td class="row_format" align="left"><?php echo  ($sale['InventoryPharmacySalesReturn']['bill_code']); ?>
			</td> 
			<?php if(!empty($sale['PharmacySalesBill']['modified_time'])){ ?>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['InventoryPharmacySalesReturn']['modified_time'],Configure::read('date_format')); ?>
			</td>
			<?php }else{ ?>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['InventoryPharmacySalesReturn']['create_time'],Configure::read('date_format')); ?>
			</td>
			<?php } ?>
			<td class="row_format" align="right"><?php $total=$sale['InventoryPharmacySalesReturn']['total'];
			echo  number_format($total,2);?></td> 
			<td class="row_format" align="right">
			<?php 
				$discountInPerc = $sale['InventoryPharmacySalesReturn']['discount']; 
				$discount = ($total * $discountInPerc)/100;
				$disc = $sale['InventoryPharmacySalesReturn']['discount_amount'];
				$totalAmt=$total-$disc;
			echo  number_format($totalAmt,2);?></td> 
			<td class="row_format" align="right"><?php 
			echo  number_format($disc,2);?></td>
			<?php  if($this->params->query[action] != 'print'){?> 
			<td class="row_format" align="center">
			<?php $returnId = $sale['InventoryPharmacySalesReturn']['id']; ?>
			<?php echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales','onclick'=>"displayReturnList($returnId)")),'javascript:void(0);', array('escape' => false)); ?>
        	<?php echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', 
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','InventoryPharmacySalesReturnsDetail',$sale['InventoryPharmacySalesReturn']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print Without Header')); ?>
			<?php echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', 
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','InventoryPharmacySalesReturnsDetail',$sale['InventoryPharmacySalesReturn']['id'],'?'=>'flag=header'))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print With Header')); ?>          	
			           	
			           	<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action'=>'inventory_sales_delete','return',$sale['InventoryPharmacySalesReturn']['id']), array('escape' => false),__('Are you sure?', true)); ?>
        	</td>
        	<?php }?>
		</tr>
		<?php $totalBill=$totalBill+$total; 
				$totalDisc = $totalDisc + $disc; 
				$totalReturnAmnt = $totalReturnAmnt+$totalAmt;
		endforeach; 
		?>
		<tr>
			<td colspan="2" align="right" style="border-top:1px solid;" ><b>Total :</b></td>
			<td align="right" style="border-top:1px solid;" ><b><?php echo number_format($totalBill,2);?> </b>
			<td align="right" style="border-top:1px solid;" ><b><?php echo number_format($totalReturnAmnt,2);?> </b>
			<td align="right" style="border-top:1px solid;" ><b><?php echo number_format($totalDisc,2);?> </b>
			</td>
			<?php if($website == 'hope'){?>
			
			<td style="border-top:1px solid;" ><?php //echo $this->Form->button('Print Prescription',array('type'=>'button','onclick'=>'viewPrescription();','style'=>'float : right;'));?></td>
			<?php }?>
		</tr>
	</table>
	</div>
	</td>
	</tr>
	<?php } ?>
	<?php if($this->params->query['action'] == 'print'){?>
	<?php $cnt=0; if(count($advancePay)>0){?>
	<tr><td><strong>Advance Paid</strong></td></tr>
	<tr>
	 <td>
		<table border="0" class="table_format TbodySales" cellpadding="0" cellspacing="0" width="100%" style="text-align: center; border: solid 1px black">
		<tr class="row_title">
			<td class="table_cell" align="left"><strong><?php echo  __('Date', true); ?></strong></td> 
			<td class="table_cell" align="left"><strong><?php echo  __('Amount', true); ?></strong></td> 
			<td class="table_cell" align="left"><strong><?php echo  __('Remark', true); ?></strong></td>
			<td class="table_cell" align="left"></td> 
		</tr>
		<?php  $totalBillAmnt = 0;
			foreach($advancePay as $key=>$data){ $cnt++;
			?>
		<tr>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($data['Billing']['date'],Configure::read('date_format'));?></td>
			<td class="row_format" align="left"><?php echo $data['Billing']['amount'];?></td>
			<td class="row_format" align="left"><?php echo $data['Billing']['remark'];?></td>
			<td class="row_format" align="left"></td>
		</tr>
		<?php $totalBillAmnt = $totalBillAmnt + $data['Billing']['amount'];}
		?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td colspan="1" align="right"><b>Total :</b></td>
			<td align="left"><b><?php echo number_format($totalBillAmnt,2);?> </b></td>
		</tr>
		</table>
	 </td>
	</tr>
	<?php }
		}?>
	
</table>

 

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
		'href': "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "get_pharmacy_details","sales","inventory"=>true)); ?>"+'/'+billId[1],
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
		'href': "<?php echo $this->Html->url(array('controller'=>'Pharmacy','action' => 'get_pharmacy_details','sales_return')); ?>"+"/"+id+"/salesBill",
		'onLoad': function () {//window.location.reload();
			}
		});
 }
 
function viewPrescription(){
	 var pharmacyDuplicateSalesBillId = new Array;
	 $(".prescriptionPrint").each(function() {
		 if($(this).is(':checked'))
			 pharmacyDuplicateSalesBillId.push($(this).val());
	});
	 var duplicateSalesBill = pharmacyDuplicateSalesBillId.join();
	 if(duplicateSalesBill != '')
		window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "viewPrescription",$data[0]['Patient']['id'],"inventory"=>false)); ?>/'+duplicateSalesBill+'/PharmacySalesBill',
			'_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
	 else
		 alert('Please select sales record.');
}

 $(document).ready(function(){
	$('#selectAllPresc').click(function(){
		if($(this).is(':checked'))
			$('.prescriptionPrint').prop('checked','checked')
		else
			$('.prescriptionPrint').prop('checked',false)
		});
});

$(document).on('click',".rowMatter",function() { 
    var selected = $(this).hasClass("highlight");
    $(".rowMatter").removeClass("highlight");
    if(!selected) $(this).addClass("highlight");
});
 

 
 </script>
