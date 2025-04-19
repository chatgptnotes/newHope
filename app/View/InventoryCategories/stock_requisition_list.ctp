<?php echo $this->Html->script(array('jquery.fancybox.js','jquery.blockUI','inline_msg'));
echo $this->Html->css(array('jquery.fancybox'));?>

<style>
.formError .formErrorContent {
	width: 60px;
}
.text_left{ margin-left:10px;}
</style>
<div class="inner_title">

	<?php if($this->params->query['pharmacy']){  ?>
	<?php echo $this->element('pharmacy_menu');?>
	<h3>
		<?php echo __('Pharmacy Requisition List'); ?>
	</h3>
	<span> 
	<?php 
		echo $this->Html->link(__('Add Pharmacy Requisition'),array('action' => 'store_requisition','?'=>array('pharmacy'=>'pharmacy')), array('escape' => false,'class'=>'blueBtn','title'=>'Add Pharmacy Requisition'));
		echo $this->Html->link(__('Received Requisition'),array('action' => 'store_inbox_requistion_list','?'=>array('pharmacy'=>'pharmacy')), array('escape' => false,'class'=>'blueBtn','title'=>'Recieved Requisition List'));
	?>
	</span>
	<span style="padding-bottom: 20px;padding-top: 40px;">
	<?php   echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'index','inventory'=>true), array('escape' => false,'class'=>"blueBtn")); ?>
	</span>
	
	<?php
    } else{?><?php // echo $this->element('store_menu');?>
	<h3>
		<?php echo __('Stock Requisition List'); ?>
	</h3>
	<span><?php 
	echo $this->Html->link(__('Back To OTPharmacy'),array('controller' => 'OtPharmacy','action'=>'sales_bill'), array('escape' => false,'class'=>'blueBtn','title'=>'Back To OTPharmacy'));
	echo $this->Html->link(__('Received Stock Requisition'),array('action' => 'stock_inbox_requistion_list'), array('escape' => false,'class'=>'blueBtn','title'=>'Recieved Stock Requisition List'));
	echo $this->Html->link(__('Add Stock Requisition'),array('action' => 'stock_requisition'), array('escape' => false,'class'=>'blueBtn text_left','title'=>'Add Stock Requisition'));

	?> </span>
	<?php } ?>
</div>
<table border="0" class="table_format" cellpadding="5" cellspacing="0"
		width="100%">
		<?php echo $this->Form->create('',array('type'=>'GET')); ?>
		<tbody>
			<tr class="row_title">
			<td> &nbsp;</td>
				
				<td><?php echo __("From :"); ?></td>
				<td><?php
					echo  $this->Form->input("from", array('type'=>'text','id' => 'fromDate','class'=>'textBoxExpnd','name'=>'from','label'=> false, 'div' => false, 'error' => false));
				?>
				</td> 
				<td><?php echo __("To :"); ?></td>
				<td><?php
					echo  $this->Form->input("to", array('type'=>'text','id' => 'toDate','class'=>'textBoxExpnd','name'=>'to','label'=> false, 'div' => false, 'error' => false));
				?>
				</td>
				
				<td><?php echo __("Status :"); ?></td>
				<td><?php
					echo  $this->Form->input("status", array('type'=>'select','empty'=>'Select','options'=>array('Issued'=>'Issued','Returned'=>'Returned'),'id' => 'status','class'=>'textBoxExpnd','name'=>'status','label'=> false, 'div' => false, 'error' => false));
				?>
				</td>
				
				<td align="right" colspan="2">
				<input name="" type="submit" value="Search" class="blueBtn search"/>
				</td>
				<td></td>
			</tr>
		</tbody>
		<?php echo $this->Form->end(); ?>
	</table>
	
<table width="100%" cellspacing="0" cellpadding="0" border="0"
	style="text-align: center;" class="table_format">
	<tr class="row_title">
	<?php if(count($data)>0){
	$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
	$this->Paginator->options(array('url' =>array("?"=>$queryStr)));?>
		<td class="table_cell"><?php echo   __('Requisition For', true); ?></td>

		<td class="table_cell"><?php echo $this->Paginator->sort('requisition_by', __('Requisition By', true)); ?>
		</td>
		<td class="table_cell"><?php echo $this->Paginator->sort('requisition_date', __('Requisition Date', true)); ?>
		</td>
		<!--  <td  class="table_cell"><?php echo $this->Paginator->sort('approved_by', __('Approved By', true)); ?></td>-->
		<td class="table_cell"><?php echo $this->Paginator->sort('status', __('Status', true)); ?>
		</td>
		<!--<td class="table_cell"><?php echo   __('Requisition Sent To', true); ?>
		</td>-->
		<td class="table_cell" width="355px">Action</td>
		<?php }?>
	</tr>

	<?php
	$cnt =0;
	if(count($data)>0){
	$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
	$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
	foreach($data as $value){
	$cnt++;

	?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

		<td class="row_format" align="center"><?php
		echo $value['StoreRequisition']['requested_for'];?></td>


		<td class="row_format" align="center"><?php
		echo $value['StoreRequisition']['requested_by'];
		?>
		</td>
		<td class="row_format" align="center"><?php
		echo $this->DateFormat->formatDate2local($value['StoreRequisition']['requisition_date'],Configure::read('date_format'),true);
		?>
		</td>
		<!-- <td class="row_format" align="center">
                              <?php
									echo $value['StoreRequisition']['approved_by'];
							  ?>
                            </td>-->
         <?php 	$requisitionId = $value['StoreRequisition']['id'];?>
		<td class="row_format" align="center" id="statusUpdate_<?php echo $requisitionId;?>">
		<?php
		if($value['StoreRequisition']['status']=='Requesting')
			echo 'Request Sent';
		else if(empty($value['StoreRequisition']['status']))
			echo $status ='Partially Issued';
		else
		echo $value['StoreRequisition']['status'];
		?>
		</td>
		<!--<td class="row_format" align="center"><?php
		echo $value['StoreLocation']['name'];
		?>
		</td>-->
		<td style="padding: 0 0 0 160px;">
			
		<?php 
		//echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales')),'javascript:void(0)', array('class'=>'view','escape' => false,'id'=>'sales_'.$requisitionId));
			echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Stock Requisition', true),'title' => __('View Stock Requisition', true))),'javascript:void(0);', array('class'=>"viewRequisition",'id'=>'viewReq_'.$requisitionId,'escape' => false));
			
			if($value['StoreRequisition']['status']=="Requesting"){				
				echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Stock Requisition', true),'title' => __('Edit Stock Requisition', true))),array('action' => 'stock_requisition',$requisitionId ), array('escape' => false));
			}
			if($value['StoreRequisition']['status']=="Issued" || empty($value['StoreRequisition']['status'])){
				echo $this->Html->link($this->Html->image('icons/arrow_curved_blue1.png', array('alt' => __('Receive Stock Requisition', true),'title' => __('Receive Stock Requisition', true))),'javascript:void(0);', array('escape' => false,'class'=>'recievedStock','id'=>'recievedStockId_'.$requisitionId));
			}
			/*echo "<script>var openWin = window.open('".$this->Html->url(array( 'controller'=>'Pharmacy', 'action'=>'store_requisition',$value['StoreRequisition']['id'],true))."', '_blank',
			           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ; */
					
			//echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
			//array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'stock_requisition',$value['StoreRequisition']['id'],true))."', '_blank',
			      //     	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));
			//echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print Store Requisition', true),'title' => __('Print Store Requisition', true))), array('action' => 'store_requisition', $value['StoreRequisition']['id'],true), array('escape' => false,"target"=>"_blank"));
			//echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Store Requisition', true),'title' => __('Edit Store Requisition', true))),array('action' => 'stock_requisition',$value['StoreRequisition']['id'] ), array('escape' => false));
			
			if($value['StoreRequisition']['status']=='Issued' || $value['StoreRequisition']['status']=='Partially Issued' || $value['StoreRequisition']['status']=='Partially Rejected'){
			//	echo $this->Html->link($this->Html->image('icons/returnProduct.png', array('alt' => __('Return Product', true),'style'=>'padding:0 0 0 5px','title' => __('Return Product', true))), array('controller'=>'Store','action' => 'return_product', $value['StoreRequisition']['id'],'Returned'), array('escape' => false));
			 
			 }
			 if($value['StoreRequisition']['status']=='Requesting'){
			 	echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteStockRequestList',$requisitionId), array('escape' => false),__('Are you sure?', true));
			 }
		?>
		</td>
	</tr>

	<?php }
	}?>

</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table align="center">
	<tr>
		<TD colspan="10" align="center">
		<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		$this->Paginator->options(array('url' =>array("?"=>$queryStr)));?>
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
		</span>
		</TD>
	</tr>
</table>
<script>
$(document).ready(function(){
	$("#toDate").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif');?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		maxDate: new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

	$("#fromDate").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif');?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		maxDate: new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

$('.viewRequisition').click(function(){
	var requisition_id=$(this).attr('id');
	var billId=requisition_id.split('_');
	var valOne = 0;
	var valTwo = true;
	var flag = 1;
	 $.fancybox({
		'width' : '100%',
		'height' : '150%', 
		'autoScale': false,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'ajax',
		'href': "<?php echo $this->Html->url(array("controller"=>"InventoryCategories","action" => "stock_requisition")); ?>"+'/'+billId[1]+'/'+valOne+'/'+valTwo+'/'+0+'/'+flag,
		
		});
	
});

$('.recievedStock').click(function(){
	var requisition_id=$(this).attr('id');
	var requestId=requisition_id.split('_');	
		$.ajax({
			type:"POST",
			url:"<?php echo $this->Html->url(array("controller" => 'InventoryCategories', "action" => "recievedStock","admin" => false)); ?>"+"/"+requestId[1],
			data:'id='+requestId[1],
			context:document.body,
			beforeSend:function(){
			    // this is where we append a loading image
			    $('#busy-indicator').show('fast');
				}, 	  		  
			success: function(data){				  
				$('#busy-indicator').hide('fast');
				inlineMsg(requisition_id,'Stock Recieved');   
				 	
				$("#statusUpdate_"+requestId[1]).html("Recieved").show();
				 
				$("#"+requisition_id).hide();
			}
		})
	});
});
</script>