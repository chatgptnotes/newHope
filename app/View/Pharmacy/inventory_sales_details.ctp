<?php  /*echo $this->Html->script(array('inline_msg','jquery.blockUI','jquery.fancybox-1.3.4'));
		echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.fancybox-1.3.4.css' ));*/ 
			echo $this->Html->script(array('jquery.fancybox','jquery.blockUI'));
	echo $this->Html->css(array('jquery.fancybox'));  ?>
<style>
.row_action img{
	float:inherit;
}
.inner_title{
	padding-top: 1px;
}
.table_format {
    padding: 0px;
}
.Tbody {
	width: 100%;
	height: 500px;
	display: list-item;
	overflow: auto;
} 
 
</style>


<div>
	<div class="inner_title">
		<?php echo $this->element('navigation_menu',array('pageAction'=>'Pharmacy')); ?>
		<h3>Sales Details</h3>
		<form action='<?php echo $this->Html->url(array('action' => 'pharmacy_details','sales','search'));?>'>
			<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center" width="80%" style="text-align: center;">
				<tr>
					<td>Bill No.</td>
					<td><input type="text" name="billno" id="bill_no" class="textBoxExpnd" value=''></td>
					<td>Patient Name/ID</td>
					<td><input type="text" name="customer_name" id="customer_name" class="textBoxExpnd"
						value=''><input type='hidden' name='person_id' id='person_id'
						value=''></td>
					<td><?php echo $this->Form->input('all_encounter',array('type'=>'checkbox','label'=>false,'div'=>false,'id'=>'all_encounter','title'=>'Show all encounter of patient')); 
						echo $this->Form->hidden('isChecked',array('id'=>'is_checked','value'=>'0')); ?>All Encounter</td>
					<td>Date</td>
					<td><input type="text" name="date" id="date" value='' size="12"
						class="textBoxExpnd"></td>
					<td><input type="submit" name="search" value="Search" class="blueBtn"></td>
					<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action' => 'pharmacy_details','sales'), array('escape' => false)); ?>
					</td>
				</tr>
			</table>
		</form>
<span><?php
		echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>
	<?php
	//echo $this->Html->script(array('jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js','permission.js'));
	//echo $this->Html->css(array(/*'datePicker.css',*/'jquery-ui-1.8.16.custom','jquery.ui.all.css','internal_style.css'));
	//echo $this->Html->script('jquery.autocomplete_pharmacy');
	//echo $this->Html->css('jquery.autocomplete.css');
	?>
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
		$cnt =0; $totalBill=0;
		if(count($data) > 0) { //debug($data);
       foreach($data as $sale):
       $total=0;$paidTotal=0;$balanceTotal=0;
       $cnt++;
       ?>
       
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="">
				<table>
					<tr>
						<td class="" align="left" id="patient_name"><?php
						if(is_null($sale['PharmacySalesBill']['patient_id'])) {
							echo ucfirst($sale['PharmacySalesBill']['customer_name']);
							if(empty($sale['PharmacySalesBill']['id'])){
								echo ucfirst($sale['Patient']['lookup_name']);
							}
						}
						else{
							echo ucfirst($sale['Patient']['lookup_name']);}
						?>
						</td>
					</tr>
					<tr>
						<td class="" align="left" id="admission_id"><?php echo $sale['Patient']['admission_id'];?></td>
					</tr>
				</table>
			</td>
			<td class="row_format" align="left" id="tariff"><?php echo $tariff[$sale['Patient']['id']];?></td>
			<td class="row_format" align="left"><?php $total=$sale['0']['pharma'] + $sale['0']['pharmaTax'] ;
			 echo  number_format((float)round($total),2,'.', '');?>
			</td>
			
			<td class="row_format" align="left"><?php 
				//$discount  =  $sale['0']['disc']; 
				$discount  = $billDisc = (double)$billDiscount[$sale['PharmacySalesBill']['patient_id']];//ebug($discount);
					
				if($this->Session->read('website.instance') == "hope"){
					$paidTotal= (double)($paidAmt[$sale['PharmacySalesBill']['patient_id']]/* - $discount*/);
				}else{
					$paidTotal = (double)(($sale['0']['paidAmnt']) - $returnAmountArray[$sale['PharmacySalesBill']['patient_id']]);
				}
				
				$refundTotal = (double)$refund[$sale['PharmacySalesBill']['patient_id']]; 
			 echo number_format((float)round($paidTotal),2,'.', '')?>
			</td>
			<td class="row_format" align="left"><?php  
				echo  number_format((float)round($discount),2,'.', '');?>
			</td>
			<td class="row_format" align="left"><?php  
				echo  number_format((float)round($refundTotal),2,'.', '');?>
			</td>
			
			<td class="row_format" align="left"><?php 
			 $discAmnt[$sale['PharmacySalesBill']['patient_id']];
			 $returnAmt = !empty($returnListArray[$sale['PharmacySalesBill']['patient_id']])?$returnListArray[$sale['PharmacySalesBill']['patient_id']]:0 ;
			 $returnDiscount = !empty($returnDiscountArray[$sale['PharmacySalesBill']['patient_id']])?$returnDiscountArray[$sale['PharmacySalesBill']['patient_id']]:0 ;
			 $returnDataDisc = ($returnAmt*$returnDiscount)/100; 
			 $discAmount = !empty($discAmnt[$sale['PharmacySalesBill']['patient_id']])?$discAmnt[$sale['PharmacySalesBill']['patient_id']]:0 ;
			$totalReturn = $returnAmt - $discAmount;
			
			 echo  number_format((float)round($totalReturn),2,'.', ''); //debug($returnAmt);?>
			</td>
			<td class="row_format" align="left"><?php 
			//echo "$total - ( $returnAmt + $paidTotal + $billDisc) + $refundTotal";
			$balanceTotal = round($total - ( $totalReturn + $paidTotal + $discount) + $refundTotal );
			 echo  number_format($balanceTotal,2);?>
			</td>
			<td class="row_action" align="left">
				<?php $patientId = $sale['Patient']['id'];?>
				<?php echo $this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales','class'=>'view_detail','patient_id'=>$sale['Patient']['id']));?>
				<?php echo $this->Html->image('/img/icons/money.png', array('title' => 'Money Collected','class'=>'bill_detail','patient_id'=>$sale['Patient']['id']));?>
				<?php if($configPharmacy['cashCounter']=="yes"){ echo $this->Html->image('/img/icons/cash_collected.png', array('title' => 'Cash Collect','class'=>'cash_detail','patient_id'=>$sale['Patient']['id'])); } ?>
			    
				<?php 
				if(strtolower($this->Session->read('website.instance')) == "kanpur"){
					echo $this->Html->image('icons/rupee_symbol.png',array('title' => 'Advance Collection','class'=>'pharmacy_advance_payment','patient_id'=>$sale['Patient']['id']));
				} 
				 echo $this->Html->image('/img/icons/sale_details.png', array('title' => 'Sale Details','class'=>'all_detail','onclick'=>"viewDetails($patientId)"));
				 echo $this->Html->image('/img/icons/view_all.png', array('title' => 'Medication Details','class'=>'medication_detail','onclick'=>"medicationDetails($patientId)")); 
				//echo $this->Html->link($this->Html->image('icons/rupee_symbol.png',array('style'=>'height:20px;width:18px;')),'javascript:void(0)',
					//array('id'=>'pharmacyAdvancePayment_'.$sale['Patient']['id'],'class'=>'pharmacy_advance_payment','escape' => false,'title'=>'Pharmacy Refund Amount'));
				?> 

				<?php echo $this->Html->image('icons/notes_error.png',array('style'=>'height:20px;width:18px;','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'dailyTreatmentSheet',$sale['Patient']['id'],'inventory'=>false))."', '_blank',	
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Treatment Sheet')); ?>
				<?php /*echo $this->Html->image('icons/paid.jpg',array('style'=>'height:20px;width:18px;','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacySalesBill',$sale['PharmacySalesBill']['id']))."', '_blank',	
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));*/?>
				<?php /*echo $this->Html->link($this->Html->image('icons/paid.jpg',array('style'=>'height:20px;width:18px;')),'#', 
					array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'inventory_print_view','PharmacySalesBill',$sale['PharmacySalesBill']['id']))."', '_blank',

			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));  ?>
			    <?php echo $this->Html->link($this->Html->image('/img/icons/view_all.png', array('title' => 'All Details')),'javascript:void(0)', array('escape' => false,'class'=>'all_detail','onclick'=>"viewDetails($patientID)"));?>

			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print')); */ ?>
			 
			</td>
			
				<?php
// 				$url = Router::url($this->Html->image('icons/print.png',array("controller" => "pharmacy", "action" => "inventory_print_view",'PharmacySalesBill',$sale['PharmacySalesBill']['id'],'inventory'=>true)));
// 				
				?>
		
<!-- 				<input name="print" type="button" value="Print" class="blueBtn" tabindex="36" 
					onclick="window.open('<?php //echo $url;?>','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );" />-->
					
				
		</tr>
		
		<?php  $totalBill=$totalBill+$total; // total Of all Sales bill
			   $totalBalance = $totalBalance + $balanceTotal; /// Total of all Sales bill Balance
		$total=0;$paidTotal=0;
		endforeach;
		?>
 		<tr>
 		<td align="right"><b>Total Balance Amount:</b></td>
 		<td align="left" colspan="10"><b><?php echo number_format($totalBalance,2);  ?></b> </td></tr>
 		<tr> 
 		<?php
        if($data){
 		$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		$this->Paginator->options(array('url' =>array('sales',"?"=>$queryStr)));
         }?>
 			<TD colspan="10" align="center"> 
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('� Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next �', true), null, null, array('class' => 'paginator_links')); ?>
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
	<div style="width: 44%; float: right;margin-left:0px;" id="content-list"></div>
</div>

<?php 					
		if(isset($this->params->query['print']) && !empty($_GET['id'])){ 
			echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'Pharmacy','action'=>'inventory_print_view','PharmacySalesBill',$_GET['id']))."', '_blank',
			           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
		}
	?>
<script>
$(document).ready(function() {
	$("#customer_name").focus(function()
	{
		var t = $(this);
		$("#credit-link-container").html("");
		$(this).autocomplete({
			source:	"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","no","inventory" => true,"plugin"=>false)); ?>"+"/"+$("#is_checked").val(),
			onItemSelect:function (li) {
			  if( li == null ) return alert("No match!");
			var person_id = li.extra[0];
			$("#person_id").val(person_id);
			},
		autoFill:false
		}
		);
	});

	
	//by swapnil
	$("#customer_name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name","inventory" => true,"plugin"=>false)); ?>",
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
		source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_bill","bill_code","inventory" => true,"plugin"=>false)); ?>",
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


$( "#from" ).datepicker({
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


$( "#to" ).datepicker({
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
		  url: "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "pharmacy_details","detail_bill","inventory"=>true)); ?>"+'?customer_name='+patient_name+'&person_id='+patient_id,
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
		  url: "<?php echo $this->Html->url(array("controller"=>"Billings", "action" => "get_pharmacy_bill","inventory"=>false)); ?>"+'/'+patient_id,
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
		  url: "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "pharmacy_details","cash_collected","inventory"=>true)); ?>"+'?customer_name='+patient_name+'&person_id='+patient_id,
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

 $(".pharmacy_advance_payment").click(function(){
	 var currentID=$(this).attr('id'); 
	 var patientID=$(this).attr('patient_id'); 
	 //patientID=splitedVar[1];
	 $.fancybox({ 
		 	'width' : '50%',
			'height' : '80%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'showCloseButton':true,
			'onClosed':function(){
			},
			'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"advanceBillingPayment","admin"=>false)); ?>"+'/'+patientID+'?category=pharmacy',
	 });
	// $(document).scrollTop(0);
 });

	$("#all_encounter").click(function(){
		if($(this).is(":checked")){
			$("#is_checked").val(1);
		}else{
			$("#is_checked").val(0);
		}
	});

function viewDetails(patientId){
	
	window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "view_details","inventory"=>true)); ?>/'+patientId+"/original",
	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); 
}

function medicationDetails(patientId){
	
	window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "medication_detail","inventory"=>false)); ?>/'+patientId+"/original",
	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); 
}
</script>
