<?php  if(!($this->request['isAjax'])){
	/* echo $this->Html->script(array('jquery.fancybox-1.3.4','jquery.blockUI'));
	 echo $this->Html->css(array('jquery.fancybox-1.3.4.css')); */
	echo $this->Html->script(array('jquery.fancybox-1.3.4','jquery.blockUI'));
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css')) ;

}
?>


<div style="padding-left: 20px; padding-top: 20px">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center; border: solid 1px black">
		<tr>
			<?php          
			// $patientId = $data[0]['PharmacyDuplicateSalesBill']['patient_id'];
			?>
			<th class="table_cell" colspan="8" align="left">Patient Name : <?php 
			if(is_null($data[0]['PharmacyDuplicateSalesBill']['patient_id']))
				echo ucfirst($data[0]['PharmacyDuplicateSalesBill']['customer_name']);
			else
				echo ucfirst($data[0]['Patient']['lookup_name']);?>
			</th>

		</tr>
		<tr class="row_title">
                        <td class="table_cell" align="left"><?php echo  __('#', true); ?>
			</td>
			<td class="table_cell" align="left"><?php echo  __('Bill No.', true); ?>
			</td>
			<!--  <td class="table_cell" align="left"><strong><?php echo __('Customer', true); ?> </strong>
			</td>-->
			<td class="table_cell" align="left"><strong><?php echo  __('Mode', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo  __('Date', true); ?>
			</strong></td>
			<td class="table_cell" align="right"><strong><?php echo  __('Amount', true); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Action', true);?>
			<?php if($this->Session->read('website.instance') !='kanpur' && $this->Session->read('website.instance') != 'vadodara'){?>
			<span style="float:right;"><?php
			echo $this->Form->checkbox('selectAllPresc',array('id'=>'selectAllPresc','div'=>false,'label'=>false,'title'=>'Check to select all prescription'));?>
			</span><?php }?>
			</strong>
			</td>
			
			
		</tr>
		<?php 
		$cnt =0; $totalBill=0;
		if(count($data) > 0) {
       foreach($data as $sale):
       $cnt++;
       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
                        <td class="row_format" align="left"><?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'title'=>'check to add amount in invoice','name'=>'is_add_in_invoice[]','class'=>'isAddInInvoice','sale_bill_id'=>$sale['PharmacyDuplicateSalesBill']['id'],'checked'=>$sale['PharmacyDuplicateSalesBill']['add_charges_in_invoice']=="1"?"checked":'')); ?>
			</td>
			<td class="row_format" align="left"><?php echo  ($sale['PharmacyDuplicateSalesBill']['bill_code']); ?>
			</td>

			<!-- <td class="row_format" align="left"><?php
			if(is_null($sale['PharmacyDuplicateSalesBill']['patient_id']))
				echo ucfirst($sale['PharmacyDuplicateSalesBill']['customer_name']);
			else
				echo ucfirst($sale['Patient']['lookup_name']);
			?>
			</td>-->
			<td class="row_format" align="left"><?php echo ucfirst($sale['PharmacyDuplicateSalesBill']['payment_mode']); ?>
			</td>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['PharmacyDuplicateSalesBill']['create_time'],Configure::read('date_format')); ?>
			</td>
			<td class="row_format" align="right"><?php $total=$sale['PharmacyDuplicateSalesBill']['total'];
			echo  number_format($total,2);?></td>
			<td class="row_action" align="left"><?php //echo $this->Html->link($this->Html->image('/img/icons/edit-icon.png', array('title' => 'edit Sales')),array('action' => 'sales_bill',$sale['PharmacySalesBill']['patient_id'],'edit',$sale['PharmacySalesBill']['id']), array('escape' => false));?>
				<?php //echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales')),'javascript:void(0)'/*array('action' => 'get_pharmacy_details','sales',$sale['PharmacySalesBill']['id'])*/, array('class'=>'view','escape' => false,'id'=>'sales_'.$sale['PharmacySalesBill']['id'])); 
					echo $this->Html->link($this->Html->image('/img/icons/edit-icon.png', array('title' => 'Clone this bill')),array('action' => 'inventory_clone_duplicate_sales_bill',$sale['PharmacyDuplicateSalesBill']['id'],$sale['PharmacyDuplicateSalesBill']['patient_id']) , array('escape' => false,'class'=>'view_detail' ));
				?>
				<?php 
				$website=$this->Session->read('website.instance');
				if($website=='kanpur')
				{
					echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacyDuplicateSalesBill',$sale['PharmacyDuplicateSalesBill']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print Without Header'));
                    echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
	            	array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacyDuplicateSalesBill',$sale['PharmacyDuplicateSalesBill']['id'],'?'=>'flag=header'))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print With Header'));
				}else if($website=='vadodara'){
					echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
						array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacyDuplicateSalesBill',$sale['PharmacyDuplicateSalesBill']['id'],'?'=>'flag=header'))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));

				}else{
                     echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
		             array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacyDuplicateSalesBill',$sale['PharmacyDuplicateSalesBill']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));
				}
				if($website !='kanpur' && $website != 'vadodara'){
					echo $this->Form->input('printPresc',array('type'=>'checkBox','hiddenField'=>false,'class'=>'prescriptionPrint',
						'value'=>$sale['PharmacyDuplicateSalesBill']['id'],'style'=>"float: right;",'div'=>false,'label'=>false));
			 }
				?> <?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action'=>'inventory_sales_delete','duplicate', $sale['PharmacyDuplicateSalesBill']['id']), array('escape' => false),__('Are you sure?', true)); ?>
			</td>
			
			<td class="row_action" align="left"><?php 
					?>
				</td>
				
		</tr>
		<?php $totalBill=$totalBill+$total;
		endforeach;
		}
		?>
		<tr>
			<td colspan="3" align="right"><b>Total Bill Cost :</b></td>
			<td align="left"><b><?php echo $this->Number->currency($totalBill);?>
			</b>
			</td>
			<?php if($website !='kanpur' && $website != 'vadodara'){?>
			<td style="float: right;"><?php echo $this->Form->button('Print Prescription',array('type'=>'button','onclick'=>'viewPrescription();'));?></td>
			<?php }?>
		</tr>
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
function viewPrescription(){
	 var pharmacyDuplicateSalesBillId = new Array;
	 $(".prescriptionPrint").each(function() {
		 if($(this).is(':checked'))
			 pharmacyDuplicateSalesBillId.push($(this).val());
	});
	 var duplicateSalesBill = pharmacyDuplicateSalesBillId.join();
	 if(duplicateSalesBill != '')
		window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "viewPrescription",$data[0]['Patient']['id'],"inventory"=>false)); ?>/'+duplicateSalesBill+'/PharmacyDuplicateSalesBill',
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
 
 $(document).on('click','.isAddInInvoice',function(){
     var saleBillId = $(this).attr('sale_bill_id');
     var addChargesInInvoice = '';
     if($(this).is(':checked') == true){
         addChargesInInvoice = '1';
     }else{
         addChargesInInvoice = '0';
     }
     
     $.ajax({
        url: "<?php echo $this->Html->url(array("controller" => 'Pharmacy', "action" => "setIsAddChargesInInvoice", "admin" => false,'inventory'=>false)); ?>"+"/"+saleBillId+"/"+addChargesInInvoice,
        beforeSend:function(){
            $('#busy-indicator').show('fast');
        },				  		  
        success: function(data){ 
            console.log(data);
            $('#busy-indicator').hide('slow'); 
        }   
    });
 });
 </script>
