<?php 
header('Cache-Control: max-age=900');
echo $this->Html->script(array('jquery.blockUI'));?>
<?php 
	$flashMsg = $this->Session->flash('still') ;
	if(!empty($flashMsg)){ ?>
	<div>
		<?php echo $flashMsg ;?>
	</div> 
<?php } ?>
<div class="inner_title">
<?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
	<h3>
		<?php echo __('Goods Received Note', true); ?>
	</h3>
	<span>
		<?php
			echo $this->Html->link(__('Add Purchase Order'),array('controller'=>'PurchaseOrders','action'=>'add_order'), array('escape' => false,'class'=>'blueBtn'));
			echo "&nbsp;";
			echo $this->Html->link(__('Back'),array('controller'=>'Pharmacy','action'=>'department_store'), array('escape' => false,'class'=>'blueBtn'));
		?>
	</span>
	<div class="clr ht5"></div>
</div>
<?php echo $this->Form->create('PurchaseReceipt',array('id'=>'PurchaseReceipt'));?>
<table border="0" class="table_format" cellpadding="5" cellspacing="0"
		width="100%">
		<tbody>
			<tr class="row_title">
			<td> &nbsp;</td>
				
				<td><?php echo __("From :"); ?></td>
				<td><?php
					echo  $this->Form->input("from", array('type'=>'text','class'=>'textBoxExpnd','id' => 'from_date','name'=>'from_date','label'=> false, 'div' => false, 'error' => false));
				?>
				</td>

				<td><?php echo __("To :"); ?></td>
				<td><?php
					echo  $this->Form->input("to", array('type'=>'text','class'=>'textBoxExpnd','id' => 'to_date','name'=>'to_date','label'=> false, 'div' => false, 'error' => false));
				?>
				</td>

				<td><?php echo __("Supplier :"); ?></td>
				<td><?php
					echo  $this->Form->input("supplier_name", array('type'=>'text','class'=>'textBoxExpnd','id' => 'supplier_name','name'=>'supplier_name','label'=> false, 'div' => false, 'error' => false));
					echo $this->Form->hidden("supplier_id",array('name'=>'supplier_id','id'=>'supplier_id'));
				?>
				</td>
				
				<td><?php echo __("Location :"); ?></td>
				<td><?php
					echo  $this->Form->input("store_location", array('class'=>'textBoxExpnd','type'=>'select','empty'=>'all','options'=>$storeLocations,'id' => 'store_location','name'=>'store_location','label'=> false, 'div' => false, 'error' => false));
				?>
				</td>
				
				<td><?php echo __("GRN No :"); ?></td>
				<td><?php
					echo  $this->Form->input("grn_no", array('type'=>'text','class'=>'textBoxExpnd','id' => 'grn_no','name'=>'grn_no','label'=> false, 'div' => false, 'error' => false));
				?>
				</td>
				
				<td align="right">
				<input name="" type="button" value="Search" class="blueBtn search" tabindex="36" />
				</td> 
				<td>
	                <?php echo $this->Html->link($this->Html->image('icons/print.png', array('alt' => __('Print All GRN', true),'title' => __('Print All GRN', true),'class'=>'printButton','id'=>'print')),'javascript:void(0)', array('escape' => false));

	               ?> 
            	</td>
			</tr>

		</tbody>
	</table>
<?php echo $this->Form->end();?>
<div id="container">

</div>
<?php //$purchaseOrderId = $this->params['pass'][0] ;?>


<?php 					
	if(isset($this->params->query['print']) && !empty($_GET['id'])){ 
		if($_GET['page'] == 'order'){
			echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'PurchaseOrders','action'=>'printPurchaseOrder',$_GET['id']))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
		}else if($_GET['page'] == 'grn'){
			echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'PurchaseOrders','action'=>'printPurchaseReceived',$_GET['id'],$_GET['grnID']))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
		}
	}
?>


<script>
function disableBackButton()
{
	window.history.forward();
}

$(document).ready(function(){ 
	disableBackButton();
	var purchaseOrderId = "<?php echo $this->params['pass'][0] ;?>";
	var id = (purchaseOrderId!="")?purchaseOrderId:null ;
	//by default load ajax to display filters and all Purchase Orders list
	Search(id);
		
	$('#supplier_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name",'null','no','null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			var service_provider_id = ui.item.id;
			$("#supplier_id").val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
	
	$('#grn_no').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "PurchaseOrders", "action" => "searchGrn","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			var service_provider_id = ui.item.id;
			$("#purchase_order_id").val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});

	$(".search").click(function(){
		Search();
	});

	
	$(document).on("click",".Back-to-List",function() {
		Search();
	});
	
	function Search(id){
		if(id != null){
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'PurchaseOrders', "action" => "getItemDetails", "admin" => false));?>";
			$.ajax({
			url : ajaxUrl + '/' + id,
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success: function(data){
				$('#busy-indicator').hide();
				$("#container").html(data).fadeIn('slow');
			}
			});
		}else{
			var form_value = $("#PurchaseReceipt").serialize(); 
			$.ajax({
			  type: 'GET',
			  url: "<?php echo $this->Html->url(array("controller" => 'PurchaseOrders', "action" => "AjaxAllPurchaseReceipts")); ?>",
			  data: form_value, 		  
			  beforeSend:function(data){
				$('#busy-indicator').show();
			  },
			  success: function(data){
				$('#busy-indicator').hide();
				$("#container").html(data).fadeIn('slow');
				}
			});
		}
	}


	$( "#to_date" ).datepicker({
    	showOn: "both",
    	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
    	buttonImageOnly: true,
    	changeMonth: true,
    	changeYear: true,
    	yearRange: '1950',			 
    	maxDate: new Date(),			 
    	dateFormat:'<?php echo $this->General->GeneralDate("");?>',	
    });

	$( "#from_date" ).datepicker({
    	showOn: "both",
    	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
    	buttonImageOnly: true,
    	changeMonth: true,
    	changeYear: true,
    	yearRange: '1950',
    	maxDate: new Date(),
    	dateFormat:'<?php echo $this->General->GeneralDate("");?>',	
    });

	$("#print").click(function() {
		 var from=$("#from_date").val();
		 var to=$("#to_date").val();
		 var supplier_id=$("#supplier_id").val();
		 var store_location=$("#store_location").val();
		 var grn_no=$("#grn_no").val();

		 var queryString = "?from_date="+from+"&to_date="+to+"&supplier_id="+supplier_id+"&store_location="+store_location+"&grn_no="+grn_no;
		 var url="<?php echo $this->Html->url(array('controller'=>'PurchaseOrders','action'=>'grn_print','print')); ?>"+ queryString;
		 window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200");
	});
});
</script>