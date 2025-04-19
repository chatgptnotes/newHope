<?php echo $this->Html->script(array('jquery.fancybox','jquery.blockUI'));
	 echo $this->Html->css(array('jquery.fancybox'));  ?>
<style>.row_action img{float:inherit;}
 .inner_title{
	padding-top: 1px;
}
.table_format {
    padding: 0px;
}
 </style>


<div class="inner_title" >
<?php echo $this->element('pharmacy_menu');?>
   <h3>View Sales Return Details</h3>
   <span><?php
   echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
   ?></span>
 </div>

<?php

 //echo $this->Html->script(array('jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js','permission.js'));
//	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','jquery.ui.all.css','internal_style.css'));

 //echo $this->Html->script('jquery.autocomplete_pharmacy');
 //echo $this->Html->css('jquery.autocomplete.css');
?>
 <form action='<?php echo $this->Html->url(array('action' => 'pharmacy_details','sales_return','search'));?>'>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
   <tr>
      <td>Patient Name </td><td><input type="text" name="customer_name" id="customer_name" value='' class="textBoxExpnd"><input type='hidden' name='person_id' id='person_id' value=''></td>
      <td>Bill No.</td><td><input type="text" name="bill_no" id="bill_no" value='' size="12" class="textBoxExpnd"></td>
      <td>From Date</td><td><input type="text" name="from_date" id="fromDate" value='' size="12" class="textBoxExpnd"></td>
      <td>To Date</td><td><input type="text" name="to_date" id="toDate" value='' size="12" class="textBoxExpnd"></td>
      <td><input type="submit" name="search" value="Search" class="blueBtn"></td>
      <td></td>
      <td align="right"><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action' => 'pharmacy_details','sales_return'), array('escape' => false)); ?>
   </tr>
   
</table>
 </form>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr>
  <td colspan="8" align="right">

  </tr>
  <tr class="row_title">

      <td class="table_cell" align="left"><strong><?php echo __('Patient Name', true); ?></strong></td>
       <td class="table_cell" align="left"><strong><?php echo __('Bill No.', true); ?></strong></td>
      <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('InventoryPharmacySalesReturn.create_time', __('Date', true)); ?></strong></td>
      <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('InventoryPharmacySalesReturn.total', __('Amount', true)); ?>(<?php echo $this->Session->read('Currency.currency_symbol') ; ?>)</strong></td>
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
        	if(!empty($sale['InventoryPharmacySalesReturn']['patient_id'])){
				$date = $this->DateFormat->formatDate2Local($sale['InventoryPharmacySalesReturn']['create_time'],Configure::read('date_format'));
			}else{
				$date = $this->DateFormat->formatDate2Local($sale['InventoryPharmacySalesReturn']['return_date'],Configure::read('date_format'));
			}
            if(is_null($sale['InventoryPharmacySalesReturn']['patient_id']))
                echo ucfirst($sale['InventoryPharmacySalesReturn']['customer_name']);
            else
                echo ucfirst($sale['Patient']['lookup_name']);
        ?>
        </td>
        <td  class="row_format" align="left"><?php echo $sale['InventoryPharmacySalesReturn']['bill_code'];?></td>
        <td class="row_format" align="left"><?php echo $date; ?> </td>
        <td class="row_format" align="left"><?php echo  number_format($sale['InventoryPharmacySalesReturn']['total'],2); ?> </td>
        <td class="row_action" align="left"><?php //echo $this->Html->link($this->Html->image('/img/icons/edit-icon.png', array('title' => 'Edit Sales')),array('action' => 'inventory_sales_return','sales_return_edit',$sale['InventoryPharmacySalesReturn']['id']), array('escape' => false));
        //echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales')),array('action' => 'get_pharmacy_details','sales_return',$sale['InventoryPharmacySalesReturn']['id']), array('escape' => false));
       ?>
        <?php $returnId = $sale['InventoryPharmacySalesReturn']['id']; ?>
        			<?php echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales','onclick'=>"displayReturnList($returnId)")),'javascript:void(0);', array('escape' => false)); ?>
        <?php if(!empty($sale['InventoryPharmacySalesReturn']['patient_id'])){?>
        <?php echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', 
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','InventoryPharmacySalesReturnsDetail',$sale['InventoryPharmacySalesReturn']['id'],'?'=>'flag=header'))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print With Header'));

        echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', 
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','InventoryPharmacySalesReturnsDetail',$sale['InventoryPharmacySalesReturn']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print Without Header')); ?>
        <?php }else{?>
        	<?php echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#', 
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','DirectSalesReturn',$sale['InventoryPharmacySalesReturn']['id'],'?'=>'flag=header'))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print with Header'));
            
        	echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;')),'#',
        			array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','DirectSalesReturn',$sale['InventoryPharmacySalesReturn']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print Without Header'));
        	?>
	  <?php }?>
			           	<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action'=>'inventory_sales_delete','return',$sale['InventoryPharmacySalesReturn']['id']), array('escape' => false),__('Are you sure?', true)); ?>
			           	
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
			source:"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","inventory" => true,"plugin"=>false)); ?>",
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
	
		$("#bill_no").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_return_bill_num","bill_code","inventory" => true,"plugin"=>false)); ?>",
			minLength: 1, 
			select: function( event, ui ) {
				console.log(ui.item);
			},
			messages: {
		        noResults: '',
		        results: function() {}
		 	}	
			});
		
$( "#fromDate" ).datepicker({
			showOn: "button",
			buttonImage: "/img/js_calendar/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',

		});

$( "#toDate" ).datepicker({
	showOn: "button",
	buttonImage: "/img/js_calendar/calendar.gif",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,
	yearRange: '1950',
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
        });
});

function displayReturnList(id){
	 $.fancybox({
		'width' : '80%',
		'height' : '100%',
		'autoScale': false,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'iframe',
		'href': "<?php echo $this->Html->url(array('controller'=>'Pharmacy','action' => 'get_pharmacy_details','sales_return')); ?>"+"/"+id,
		'onLoad': function () {//window.location.reload();
			}
		});
}
</script>