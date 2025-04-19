<style>
.formError .formErrorContent {
	width: 60px;
}
</style>
<?php echo $this->Html->script(array('jquery.fancybox.js'));
echo $this->Html->css(array('jquery.fancybox'));
$referral = $this->request->referer();
echo $this->Form->hidden('formReferral',array('value'=>'','id'=>'formReferral'));
?>
<div class="inner_title">

	<?php if($this->params->query['pharmacy']){  ?>
	<?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
	<h3>
		<?php echo __('Received Requisition List'); ?>
	</h3>
	<span> <?php 
	
	echo $this->Html->link(__('Add Store Requisition'),
			array('action' => 'store_requisition','?'=>array('pharmacy'=>'pharmacy')), 
			array('escape' => false,'class'=>'blueBtn','title'=>'Add Store Requisition'));
	echo $this->Html->link(__('Delivered Requisition'),
			array('action' => 'store_requisition_list','?'=>array('pharmacy'=>'pharmacy')), 
			array('escape' => false,'class'=>'blueBtn','title'=>'Recieved Requisition List'));
	?>
	</span>
	<?php }else{?>
	<?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
	<h3>
		<?php echo __('Received Requisition List'); ?>
	</h3>
	<span> <?php 
	echo $this->Html->link(__('Delivered Requisition'),array('action' => 'store_requisition_list'), array('escape' => false,'class'=>'blueBtn','title'=>'Delivered Requisition List'));
	echo $this->Html->link(__('Add Store Requisition'),array('action' => 'store_requisition'), array('escape' => false,'class'=>'blueBtn','title'=>'Add Store Requisition'));

	?>
	</span>
	<?php }?>
</div>

<table border="0" class="table_format" cellpadding="5" cellspacing="0"
		width="100%">
		<?php echo $this->Form->create('',array('action'=>'store_inbox_requistion_list','type'=>'GET')); ?>
		<tbody>
			<tr class="row_title">
			<td> &nbsp;</td>
			  <?php if($this->Session->read('role')==Configure::read('adminLabel')||$this->Session->read('role')==Configure::read('storemanager') ) {?>
				<td><?php echo __("Store Location :"); ?></td>
				<td><?php
					echo  $this->Form->input("store_location_id", array('type'=>'select','empty'=>'All','options'=>$storeLoc,'id' => 'store','label'=> false, 'div' => false, 'error' => false));
					//echo $this->Form->hidden("store_location",array('id'=>'store_location','value'=>''));
				?>
				</td>
				<?php }?>
			<!-- 	<td><?php //echo __("Purchase Order No :"); ?></td>
				<td><?php
					//echo  $this->Form->input("order_no", array('type'=>'text','id' => 'purchase_order','name'=>'purchase_order','label'=> false, 'div' => false, 'error' => false));
					//echo $this->Form->hidden("purchase_order_id",array('id'=>'purchase_order_id','value'=>''));
				?>
				</td>
				 -->
				<td><?php echo __("Status:");?></td>
				<td><?php $status = array('Requesting'=>'Pending','Issued'=>'Issued','Partially Issued '=>'Partially Issued','Returned'=>'Returned');?>
			  <?php echo $this->Form->input('status',array('type'=>'select','empty'=>'All','options'=>$status,'class'=>'textBoxExpnd','id'=>'status','div'=>false,'label'=>false));?>
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
		<td class="table_cell" width="5%"><?php echo  __('#', true); ?></td>
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
			echo "IND-".str_pad($value['StoreRequisition']['id'], 3, '0', STR_PAD_LEFT);
		?>
		</td>
		<td class="row_format" align="center"><?php 
		if(!empty($value['StoreRequisition']['for'])){
			echo ucfirst($value['StoreRequisition']['for']);
		?> (<?php
			echo ucfirst($value['StoreLocationAlias']['name']);
		?>)
		<?php }else{
			echo ucfirst($value['StoreLocationAlias']['name']);
		}?></td>


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
		else
			echo $status = $value['StoreRequisition']['status'];
		?>
		</td>
		<td style="padding: 0 0 0 167px;">
		<?php 
		
		//echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Store Requisition', true),'title' => __('View Store Requisition', true))),array('action' => 'store_requisition',$value['StoreRequisition']['id'],0,1 ), array('escape' => false));
		 echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Store Requisition', true),'style'=>'padding:0 9 0 9px','title' => __('View Store Requisition', true))),'javascript:void(0);', array('class'=>"viewRequisition",'id'=>'viewReq_'.$value['StoreRequisition']['id'],'escape' => false));
		
		//if($status == 'Pending'){	//by swapnil 14.03.2015
			$url = basename($_SERVER['REQUEST_URI']);
			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Store Requisition', true),'title' => __('Edit Store Requisition', true))),array('action' => 'store_requisition',$value['StoreRequisition']['id'],'?'=>array('pharmacy'=>'pharmacy','page'=>$url)), array('escape' => false));
		//}
		
		if($status == "Issued" || $status == "Partially Issued") {
			echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
				array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'store_requisition',$value['StoreRequisition']['id'],true))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));
		}/* else{
			echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print Store Requisition', true),'title' => __('Print Store Requisition', true))), array('action' => 'store_requisition', $value['StoreRequisition']['id'],true), array('escape' => false,"target"=>"_blank"));
		} */
		if($status == "Pending" || $status == "Partially Issued") { 
			echo $this->Html->link($this->Html->image('icons/issue_product.png', array('alt' => __('Issue Store Requisition', true),'style'=>'padding:0 0 0 9px','title' => __('Issue Store Requisition', true))), array('controller'=>'Store','action' => 'issue_requisition', $value['StoreRequisition']['id'],'Issued'), array('escape' => false));
		
		}  
	}?><?php
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

jQuery(document).ready(function(){

    var print="<?php echo isset($this->params->query['requisitionId'])?$this->params->query['requisitionId']:'' ?>";
    var referral = "<?php echo $referral ; ?>" ;
	if(print && referral != '/' && $("#formReferral").val()==''){
		$("#formReferral").val('yes') ;
	    var url="<?php echo $this->Html->url(array('controller'=>'InventoryCategories','action'=>'printRequisitionAfterIssue',$this->params->query['requisitionId'])); ?>";
		    window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200");
		}	
	})	
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
		'href': "<?php echo $this->Html->url(array("action" => "store_requisition")); ?>"+'/'+billId[1]+'/'+valOne+'/'+valTwo+'/'+0+'/'+flag,
		
		});
});
</script>