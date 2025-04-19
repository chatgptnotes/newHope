<style>
.formError .formErrorContent {
	width: 60px;
}
</style>
<?php echo $this->Html->script(array('jquery.fancybox.js'));
echo $this->Html->css(array('jquery.fancybox'));?>
<div class="inner_title">

	<?php if($this->params->query['pharmacy']){  ?>
	<?php echo $this->element('pharmacy_menu');?>
	<h3>
		<?php echo __('Received Stock Requisition List'); ?>
	</h3>
	<span> <?php 
	
	echo $this->Html->link(__('Add Stock Requisition'),
			array('action' => 'stock_requisition','?'=>array('pharmacy'=>'pharmacy')), 
			array('escape' => false,'class'=>'blueBtn','title'=>'Add Stock Requisition'));
	echo $this->Html->link(__('Delivered Stock Requisition'),
			array('action' => 'stock_requisition_list','?'=>array('pharmacy'=>'pharmacy')), 
			array('escape' => false,'class'=>'blueBtn','title'=>'Recieved Stock Requisition List'));
	?>
	</span>
	<?php }else{?>
	<h3>
		<?php echo __('Received Stock Requisition List'); ?>
	</h3>
	<span> <?php 
	echo $this->Html->link(__('Delivered  Stock Requisition'),array('action' => 'stock_requisition_list'), array('escape' => false,'class'=>'blueBtn','title'=>'Recieved Stock Requisition List'));
	echo $this->Html->link(__('Add Stock Requisition'),array('action' => 'stock_requisition'), array('escape' => false,'class'=>'blueBtn','title'=>'Add Stock Requisition'));

	?>
	</span>
	<?php }?>
</div>

<table border="0" class="table_format" cellpadding="5" cellspacing="0"
		width="100%">
		<?php echo $this->Form->create('',array('type'=>'GET')); ?>
		<tbody>
			<tr class="row_title">
			<td> &nbsp;</td>
				<td><?php echo __("Location  From:"); ?></td>
				<td><?php
					  echo $this->Form->input('',array('name'=>"location_from_id",'label'=> false, 'error' => false,'empty'=>'Select Other Location','multiple'=>false,
                                'options'=>$accessableLocation,'div'=>false,'class'=>'requisition_selector','id'=>'location_from','selected'=>$this->Session->read('locationid'))); 
				?>
				</td>
				<td><?php echo __("Location  To:"); ?></td>
				<td><?php
						echo $this->Form->input('',array('name'=>"location_to",'label'=> false, 'error' => false,'empty'=>'Select Other Location','multiple'=>false,
                                'options'=>$accessableLocation,'div'=>false,'class'=>'requisition_selector','id'=>'location_to'));
					?>
				</td>							
				<td><?php echo __("Status:");?></td>
				<td><?php $status = array('Pending'=>'Pending','Issued'=>'Issued'/*,'Partial'=>'Partial','Returned'=>'Returned'*/);?>
			<?php echo $this->Form->input('',array('type'=>'select','empty'=>'All','options'=>$status,'class'=>'textBoxExpnd','name'=>"status",'id'=>'status','div'=>false,'label'=>false));?>
				</td>
				
				<td align="right" colspan="2">
				<input name="" type="submit" value="Search" class="blueBtn search" />
				</td>
				<td></td>
			</tr>
		</tbody>
		<?php echo $this->Form->end(); ?>
	</table>
	

<table width="100%" cellspacing="0" cellpadding="0" border="0"
	style="text-align: center;" class="table_format">
	<tr class="row_title"><?php //debug($data);?>
	<?php if(count($data)>0){ 
	 $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
	$this->Paginator->options(array('url' =>array("?"=>$queryStr))); ?>
		<td class="table_cell" width="20%"><?php echo  __('Requisition For', true); ?></td>

		<td class="table_cell" width="20%"><?php echo $this->Paginator->sort('requisition_by',__('Requisition By', true)); ?>
		</td>
		<td class="table_cell" width="20%"><?php echo $this->Paginator->sort('requisition_date',__('Requisition Date', true)); ?>
		</td>
		<!--  <td  class="table_cell"><?php echo $this->Paginator->sort('approved_by',__('Approved By', true)); ?></td>-->
		<td class="table_cell" width=""><?php echo $this->Paginator->sort('status', __('Status', true)); ?>
		</td>
		<td class="table_cell" width="" style="text-align:center">Action</td>
		<?php }?>
	</tr>

	<?php
	$cnt =0;//debug($data);
	if(count($data)>0){
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
		<td class="row_format" align="center"><?php
		if($value['StoreRequisition']['status']=='Requesting')
			echo $status = 'Pending';
		else if(empty($value['StoreRequisition']['status']))
			echo $status ='Partially Issued';
		else
			echo $status = $value['StoreRequisition']['status'];
		?>
		</td>
		<td style="padding: 0 0 0 203px;">
		<?php 
		
		//echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Store Requisition', true),'title' => __('View Store Requisition', true))),array('action' => 'store_requisition',$value['StoreRequisition']['id'],0,1 ), array('escape' => false));
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Stock Requisition', true),'title' => __('View Stock Requisition', true))),'javascript:void(0);', array('class'=>"viewRequisition",'id'=>'viewReq_'.$value['StoreRequisition']['id'],'escape' => false));
		//echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Stock Requisition', true),'title' => __('Edit Stock Requisition', true))),array('action' => 'stock_requisition',$value['StoreRequisition']['id'] ), array('escape' => false));
		if($status == "Issued" || $status == "Partially Issued" || $status == "Recieved") {
			echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'javascript:void(0);',
				array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'stock_requisition',$value['StoreRequisition']['id'],true))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));
		}/* else{
			echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print Store Requisition', true),'title' => __('Print Store Requisition', true))), array('action' => 'store_requisition', $value['StoreRequisition']['id'],true), array('escape' => false,"target"=>"_blank"));
		} */
		if($status == "Pending" || $status == "Partially Issued") { 
			echo $this->Html->link($this->Html->image('icons/issue_product.png', array('alt' => __('Issue Stock Requisition', true),'style'=>'padding:0 0 0 5px','title' => __('Issue Stock Requisition', true))), array('controller'=>'Store','action' => 'issue_stock_requisition', $value['StoreRequisition']['id'],'Issued'), array('escape' => false));
		
		}  
		
	}
	
	?><?php
		// echo $this->Html->link($this->Html->image('1353933922_tick.png', array('alt' => __('Approve Store Requisition', true),'title' => __('Approve Store Requisition', true))), array('action' => 'store_requisition_status_approved', $value['StoreRequisition']['id'],'Approved'), array('escape' => false));
		//echo $this->Html->link($this->Html->image('icons/returnProduct.png', array('alt' => __('Return Product', true),'style'=>'padding:0 0 0 5px','title' => __('Return Product', true))), array('controller'=>'Store','action' => 'return_product', $value['StoreRequisition']['id'],'Returned'), array('escape' => false));
		?>
		
		</td>
	</tr>

	<?php
	}
	
	?>
</table>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table align="center">
	<tr>
		<TD colspan="10" align="center">
		<?php  $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		$this->Paginator->options(array('url' =>array("?"=>$queryStr))); ?>
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

</script>