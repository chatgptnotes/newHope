 <style>.row_action img{float:inherit;}
 .inner_title{
	padding-top: 1px;
}
.table_format {
    padding: 0px;
}
 </style>

<?php  
	echo $this->Html->script(array('jquery.fancybox','jquery.blockUI'));
	echo $this->Html->css(array('jquery.fancybox'));
?>
<div class="inner_title" >
<?php echo $this->element('ot_pharmacy_menu');?>
   <h3>View OT Sales Return </h3>
   <span><?php
   //echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
   ?></span>
 </div>

<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="50%" style="text-align:center;">
    <form action='<?php echo $this->Html->url(array('action' => 'ot_details','sales_return','search'));?>'>
    <tr>
		<td>Patient Name/ID</td><td>
		<input type="text" name="customer_name" id="customer_name" value='' class="textBoxExpnd">
		<input type='hidden' name='person_id' id='person_id' value=''></td>
        <td>Date</td><td>
        <input type="text" name="date" id="date" value='' size="12" class="textBoxExpnd"></td>
   <td><input type="submit" name="search" value="Search" class="blueBtn"></td>
   <td></td>
   <td align="right">
   <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action' => 'ot_details','sales_return'), array('escape' => false)); ?>
    </tr>
    </form>
</table>

<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr>
  <td colspan="8" align="right">

  </tr>
  <tr class="row_title">

      <td class="table_cell" align="left"><strong><?php echo __('Patient Name', true); ?></strong></td>
      <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('OtPharmacySalesReturn.created_time', __('Date', true)); ?></strong></td>
      <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('OtPharmacySalesReturn.total', __('Amount', true)); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong></td>
      <td class="table_cell" align="left"><strong><?php echo __('Action', true);?></strong></td>
  </tr>
  <?php
  	 $cnt =0;
       if(count($data) > 0) {
       foreach($data as $sale): 
         $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

        <td class="row_format" align="left">
        <?php
            if(is_null($sale['OtPharmacySalesReturn']['patient_id']))
                echo ucfirst($sale['OtPharmacySalesReturn']['customer_name']);
            else
                echo ucfirst($sale['Patient']['lookup_name']);
        ?>
        </td>
        <td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($sale['OtPharmacySalesReturn']['created_time'],Configure::read('date_format')); ?> </td>
        <td class="row_format" align="left"><?php echo  number_format($sale['OtPharmacySalesReturn']['total'],2); ?> </td>
        <td class="row_action" align="left">
        <?php echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales')),'javascript:void(0)', 
									array('class'=>'view','escape' => false,'id'=>'sales_'.$sale['OtPharmacySalesReturn']['id']));
       // echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales')),array('action' => 'get_ot_details','sales_return',$sale['OtPharmacySalesReturn']['id']), array('escape' => false)); ?>
        <?php echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', 
				array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_view','OtPharmacySalesReturn',$sale['OtPharmacySalesReturn']['id']))."', '_blank',
			           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print')); ?>
		<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action'=>'sales_delete','return',$sale['OtPharmacySalesReturn']['id']), array('escape' => false),__('Are you sure?', true)); ?>
        </td>
  </tr>  
  <?php endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
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

 <?php 					
		 if(isset($this->params->query['print']) && !empty($_GET['id'])){ 
			echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'Pharmacy','action'=>'inventory_print_view','InventoryPharmacySalesReturnsDetail',$_GET['id'],'?'=>'flag=header'))."', '_blank',
			           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
		} 
	?>
 
<script>
$(document).ready(function(){

	/*$("#customer_name").on('focus',function()
	{
		var t = $(this);
		$("#credit-link-container").html("");*/
		$("#customer_name").autocomplete({
			source:"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_otpatient_detail","lookup_name","inventory" => true,"plugin"=>false)); ?>",
			select:function (event, ui) {
			var person_id = ui.item.id;
			$("#person_id").val(person_id);
			},
			 messages: {
		        noResults: '',
		        results: function() {}
			 }	
		});
	//});
	
$("#bill_no").on('focus',function()
			  {
			  var t = $(this);
			 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_bill","bill_code","inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:function (data1) {
				selectItem(data1);
			},
			autoFill:false
		}
	);

});
$( "#date" ).datepicker({
			showOn: "button",
			buttonImage: "/DrmHope/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',

		});

});

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
	'href': "<?php echo $this->Html->url(array("controller"=>"OtPharmacy", "action" => "get_ot_details","sales_return")); ?>"+'/'+billId[1],
	'onLoad': function () {//window.location.reload();
		}
	});
})
</script>