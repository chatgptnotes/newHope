<style>.row_action img{float:inherit;}</style>
<div style="padding: 10px">
	<div class="inner_title">
		<h3>Purchase Details</h3>
		<span><?php
		     echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
		?> </span>
	</div>

	<?php

	echo $this->Html->script(array('jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js','permission.js'));
	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','jquery.ui.all.css','internal_style.css'));
	
	echo $this->Html->script('jquery.autocomplete_pharmacy');
	echo $this->Html->css('jquery.autocomplete.css');
	?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center;">
		<form
			action='<?php echo $this->Html->url(array('action' => 'purchase_details_list','search'));?>'>
			<tr>
				<td>Party:&nbsp; <input type="text" name="supplier" id="supplier" value=''>
				<input type='hidden' name='supplier_id' id='supplier_id' value=''></td>
			
				<td>Voucher No.:&nbsp;
				<input type="text" name="vr_no" id="vr_no" value=''></td>
				
				<td width="2%">Date:&nbsp;</td>
				<td ><input class="textBoxExpnd " type="text" name="date" id="date" value='' size="12"></td>
				<td><input type="submit" name="search" value="Search"
					class="blueBtn">
				</td>

				<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action' => 'purchase_details_list'), array('escape' => false)); ?>
				</td>
			</tr>
		</form>
	</table>
	<div style="margin-right: 30px" align="right"></div>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center;">
		<tr>
			<td colspan="8" align="right">
		
		</tr>
		<tr class="row_title">
			<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('InventoryPurchaseDetail.vr_no', __('Voucher No.', true)); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php  echo $this->Paginator->sort('InventoryPurchaseDetail.vr_date', __('Voucher Date', true)); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('InventorySupplier.name', __('Party', true)); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('InventoryPurchaseDetail.payment_mode', __('Mode', true)); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('InventoryPurchaseDetail.credit_amount', __('Credit Amount', true)); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('InventoryPurchaseDetail.total_amount', __('Amount', true)); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong>
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('View', true);?> </strong>
			</td>
		</tr>
		<?php
		$cnt =0;
		if(count($data) > 0) {
       foreach($data as $purchase):
       $cnt++;
       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format" align="left"><?php echo  ($purchase['InventoryPurchaseDetail']['vr_no']); ?>
			</td>
			<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($purchase['InventoryPurchaseDetail']['vr_date'],Configure::read('date_format')); ?>
			</td>
			<td class="row_format" align="left"><?php echo ucfirst($purchase['InventorySupplier']['name']); ?>
			</td>
			<td class="row_format" align="left"><?php echo ucfirst($purchase['InventoryPurchaseDetail']['payment_mode']); ?>
			</td>
			<td class="row_format" align="left"><?php echo  number_format(($purchase['InventoryPurchaseDetail']['credit_amount']),2); ?>
			</td>
			<td class="row_format" align="left"> <?php echo  number_format(($purchase['InventoryPurchaseDetail']['total_amount']),2); ?>
			</td>

			<td class="row_action" align="left"><?php echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Purchase')),array('action' => 'get_pharmacy_details','purchase',$purchase['InventoryPurchaseDetail']['id']), array('escape' => false)); ?>
			</td>
		</tr>
		<?php endforeach;  ?>
		<tr>
			<TD colspan="8" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			
			</TD>
		</tr>
		<?php

      } else {
  ?>
		<tr>
			<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
      }
      ?>

	</table>

</div>

<script>


$( "#date" ).datepicker({
			showOn: "both",
			buttonImage: "/drmHope/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',

		});

$("#supplier").live('focus',function(){
			  var t = $(this);
              $("#credit-link-container").html("");
			 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","InventorySupplier","name","inventory" => false,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
	           onItemSelect:function (li) {
			  if( li == null ) return alert("No match!");
				var person_id = li.extra[0];
				$("#supplier_id").val(person_id);
			},
			autoFill:false
		}
	);

});
</script>
