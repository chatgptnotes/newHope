<?php  echo $this->Html->script(array('inline_msg','jquery.blockUI','jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.fancybox-1.3.4.css' ));   ?>
<style>.row_action img{float:inherit;}
.inner_title{
	padding-top: 1px;
}
.table_format {
    padding: 0px;
}

</style>


<div>

	<div class="inner_title">
		<?php echo $this->element('ot_pharmacy_menu');?>
		<h3>OT Pharmacy Sales List</h3>
		<form action='<?php echo $this->Html->url(array('action' => 'ot_details','sales','search'));?>'>
			<table border="0" class="" cellpadding="0" cellspacing="0" align="center" width="65%" style="text-align: center;">
				<tr>
					<td>Bill No.</td>
					<td><input type="text" name="billno" id="bill_no" class="textBoxExpnd" value=''></td>
					<td>Patient Name/ID</td>
					<td>
					<input type="text" name="customer_name" id="customer_name" class="textBoxExpnd"value=''>
					<input type='hidden' name='person_id' id='person_id' value=''></td>
					<td>Date</td>
					<td><input type="text" name="date" id="date" value='' size="12"
						class="textBoxExpnd"></td>
					<td><input type="submit" name="search" value="Search" class="blueBtn"></td>
					<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action' => 'ot_details','sales'), array('escape' => false)); ?>
					</td>
				</tr>
			</table>
		</form>
	<span>
	<?php
		//echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>
	
	<div style="width:55%; float: left;max-height:500px;overflow:scroll;"> 
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align: center;">
		<tbody >
		<tr class="row_title">
			<!--<td class="table_cell" align="left"><strong><?php echo __('Patient ID', true); ?> </strong>	</td>
			-->
			<td class="table_cell" align="left"><strong><?php echo __('Patient Name/ID', true); ?> </strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo __('Tariff', true); ?> </strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Total', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Paid', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Discount', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Refund', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Return', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Bal', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo __('Action', true);?> </strong>	</td>
		</tr>
		
		<?php 
		$cnt = 0; $totalBill=0;
		if(count($data) > 0) {
       foreach($data as $sale):
       $total=0;$paidTotal=0;$balanceTotal=0;
       $cnt++;
       ?>
       
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="">
				<table>
					<tr>
						<td class="" align="left" id="patient_name"><?php 
						if(is_null($sale['OtPharmacySalesBill']['patient_id']))
							echo ucfirst($sale['OtPharmacySalesBill']['customer_name']);
						else
							echo $sale['Patient']['lookup_name'];
						?>
						</td>
					</tr>
					<tr>
						<td class="" align="left" id="admission_id"><?php echo $sale['Patient']['patient_id'];?></td>
					</tr>
				</table>
			</td>
			<td class="row_format" align="left" id="tariff"><?php echo $tariff[$sale['Patient']['id']];?></td>
			<td class="row_format" align="left"><?php $total=$sale['0']['pharma'] ;
			 echo  number_format(round($total),2);?>
			</td>
			
			<td class="row_format" align="left"><?php 
				//debug($sale['0']);
				$discount  =  $sale['0']['disc']; 
				//$billDisc = (double)$billDiscount[$sale['OtPharmacySalesBill']['patient_id']];//ebug($discount);
				//$paidTotal= (double)($paidAmt[$sale['OtPharmacySalesBill']['patient_id']]/* - $discount*/);	
				$paidTotal = $sale['0']['paidAmount'];
				$refundTotal =  ($refund[$sale['OtPharmacySalesBill']['patient_id']]); 
			 echo  number_format(round($paidTotal,2));?>
			</td>
			<td class="row_format" align="left"><?php  
				echo  number_format(round($discount),2);?>
			</td>
			<td class="row_format" align="left"><?php  
				echo  number_format(round($refundTotal),2);?>
			</td>
			<td class="row_format" align="left"><?php  
				 
			 $returnAmt = !empty($returnListArray[$sale['OtPharmacySalesBill']['patient_id']])?$returnListArray[$sale['OtPharmacySalesBill']['patient_id']]:0 ;
			 echo  number_format(round($returnAmt),2); //debug($returnAmt);?>
			</td>
			<td class="row_format" align="left"><?php 
			//echo "$total - ( $returnAmt + $paidTotal + $billDisc) + $refundTotal";
			$balanceTotal = $total - ( $returnAmt + $paidTotal + $discount) + $refundTotal  ;
			 echo  number_format(round($balanceTotal),2);?>
			</td>
			<td class="row_action" align="left">
				<?php echo $this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales','class'=>'view_detail','patient_id'=>$sale['Patient']['id']));?>
				<?php echo $this->Html->image('/img/icons/money.png', array('title' => 'Money Collected','class'=>'bill_detail','patient_id'=>$sale['Patient']['id']));?>
				<?php echo $this->Html->image('/img/icons/cash_collected.png', array('title' => 'Cash Collect','class'=>'cash_detail','patient_id'=>$sale['Patient']['id'])); ?>
		</tr>
		
		<?php  $totalBill=$totalBill+$total;
		$total=0;$paidTotal=0;
		endforeach;
		?>
 		<tr>
 		<td align="right"><b>Total Bill Cost :</b></td>
 		<td align="left"><b><?php echo number_format(round($totalBill),2);  ?></b> </td></tr>
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
	</tbody>
	</table>
	
	</div>
	<div style="width: 45%; float: right;" id="content-list"></div>
</div>

<?php 					
		/* if(isset($this->params->query['print']) && !empty($_GET['id'])){ 
			echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'OtPharmacy','action'=>'inventory_print_view','OtPharmacySalesBill',$_GET['id']))."', '_blank',
			           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
		} */
	?>
<script>
$(document).ready(function() {
	/*$("#customer_name").focus(function()
	{
		var t = $(this);
		$("#credit-link-container").html("");
		$(this).autocomplete({
			source:	"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","inventory" => true,"plugin"=>false)); ?>",
			onItemSelect:function (li) {
			  if( li == null ) return alert("No match!");
			var person_id = li.extra[0];
			$("#person_id").val(person_id);
			},
		autoFill:false
		}
		);
	});*/

	
	//by swapnil
	$("#customer_name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","IPD","inventory" => true,"plugin"=>false)); ?>",
		 minLength: 1, 
		 select: function( event, ui ) {
				var person_id = ui.item.id;
				$("#person_id").val(person_id); 
			},
			messages: {
		        noResults: '',
		        results: function() {}
		 }	
			}
		);

	$("#bill_no").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "OtPharmacy", "action" => "fetch_bill","bill_code","plugin"=>false)); ?>",
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


$( "#date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
		});


//EOF pankaj 
$('.view_detail').click(function(){
	var patient_name=$('#patient_name').html();
	var patient_id=$(this).attr('patient_id');
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller"=>"OtPharmacy", "action" => "ot_details","detail_bill")); ?>"+'?customer_name='+patient_name+'&person_id='+patient_id,
		  context: document.body,
		  beforeSend:function(){
			  loading('content-list','id');
		  }, 	  		  
		  success: function(data){ 
				//loading('content-list','id');
				$('#content-list').html(data);
				onCompleteRequest('content-list','id');
			 // obj.attr('src','../theme/Black/img/icons/green.png').attr('title','Medication Administered').removeClass('med');
		  }
		  
	});

	/* $.fancybox({
		'width' : '70%',
		'height' : '100%',
		'autoScale': true,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'iframe',
		'href': "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "pharmacy_details","detail_bill","inventory"=>true)); ?>"+'?customer_name='+patient_name+'&person_id='+patient_id,
		'onLoad': function () {//window.location.reload();
			}
		});*/
	
});

$('.bill_detail').click(function(){
	var patient_id=$(this).attr('patient_id');
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller"=>"OtPharmacy", "action" => "get_ot_bill")); ?>"+'/'+patient_id,
		  context: document.body,
		  beforeSend:function(){
			  loading('content-list','id');
		  }, 	  		  
		  success: function(data){ 
				//loading('content-list','id');
				$('#content-list').html(data);
				onCompleteRequest('content-list','id');
			 // obj.attr('src','../theme/Black/img/icons/green.png').attr('title','Medication Administered').removeClass('med');
		  }
		  
	});
});

$('.cash_detail').click(function(){
	var patient_name=$('#patient_name').html();
	var patient_id=$(this).attr('patient_id');
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller"=>"OtPharmacy", "action" => "ot_details","cash_collected")); ?>"+'?customer_name='+patient_name+'&person_id='+patient_id,
		  context: document.body,
		  beforeSend:function(){
			  loading('content-list','id');
		  }, 	  		  
		  success: function(data){ 
				$('#content-list').html(data);
				onCompleteRequest('content-list','id');
		  }
		  
	});
});



</script>
