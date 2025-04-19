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
		<?php echo $this->element('navigation_menu',array('pageAction'=>'Pharmacy')); ?>
		<h3>Duplicate Sales Details</h3>
		<span><?php
		echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>

	  
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="65%" style="text-align: center;">
		<form
			action='<?php echo $this->Html->url(array('action' => 'duplicate_sales_details','sales','search'));?>'>
			<tr>
				<td>Bill No.</td>
				<td><input type="text" name="billno" id="bill_no" value=''></td>
				<td>Patient Name/ID</td>
				<td><input type="text" name="customer_name" id="customer_name"
					value=''><input type='hidden' name='person_id' id='person_id'
					value=''></td>
				<td><?php echo $this->Form->input('all_encounter',array('type'=>'checkbox','label'=>false,'div'=>false,'id'=>'all_encounter','title'=>'Show all encounter of patient')); 
						echo $this->Form->hidden('isChecked',array('id'=>'is_checked','value'=>'0')); ?>All Encounter</td>
				<td>Date</td>
				<td><input type="text" name="date" id="date" value='' size="12" class="textBoxExpnd"></td>
				<td><input type="submit" name="search" value="Search"
					class="blueBtn"></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action' => 'pharmacy_details','sales'), array('escape' => false)); ?>
				</td>
			</tr>
		</form>
	</table>
	<div style="width:55%; float: left;">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"
		 style="text-align: center;">
		<tr>
			<td colspan="8" align="right"></td>
		</tr>
		<tr class="row_title">
			<td class="table_cell" align="left"><strong><?php echo __('Patient ID', true); ?> </strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo __('Patient Name', true); ?> </strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo __('Tariff', true); ?> </strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Total', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Paid', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Return', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo  __('Bal', true); ?></strong>	</td>
			<td class="table_cell" align="left"><strong><?php echo __('Action', true);?> </strong>	</td>
		</tr>
		<?php
		$cnt =0; $totalBill=0;
		if(count($data) > 0) {
       foreach($data as $sale): 
       $patientId = $sale['Patient']['id']; 
       $total=0;$paidTotal=0;$balanceTotal=0;
       $cnt++;
       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format" align="left" id="admission_id"><?php echo $sale['Patient']['admission_id'];?></td>
			<td class="row_format" align="left" id="patient_name"><?php
				echo ucfirst($sale['Patient']['lookup_name']);
			?>
			</td>
			<td class="row_format" align="left" id="tariff"><?php echo $tariff[$sale['Patient']['id']];?></td>
			<td class="row_format" align="left"><?php $total=$sale['0']['pharma'];
			 echo  number_format($total,2);?>
			</td>
			
			<td class="row_format" align="left"><?php $paidTotal=$paidAmt[$sale['PharmacySalesBill']['patient_id']];
			 echo  number_format($paidTotal,2)?>
			</td>
			<td class="row_format" align="left"><?php  
				 
			 $returnAmt = $returnListArray[$sale['PharmacySalesBill']['patient_id']] ;
			 echo  number_format($returnAmt,2);?>
			</td>
			<td class="row_format" align="left"><?php $balanceTotal=number_format(($total-$returnAmt-$paidTotal),2);
			 echo  $balanceTotal?>
			</td>
				<td class="row_action" align="left">
				<?php echo $this->Html->link($this->Html->image('/img/icons/view-icon.png', array('title' => 'View Sales')),/*array('action' => 'get_pharmacy_details','sales',$sale['PharmacySalesBill']['id'])*/'javascript:void(0)', array('escape' => false,'class'=>'view_detail','patient_id'=>$sale['Patient']['id'])); ?>

				<?php
					//echo $this->Html->link($this->Html->image('/img/icons/edit-icon.png', array('title' => 'Clone this bill')),array('action' => 'inventory_clone_duplicate_sales_bill',$sale['PharmacyDuplicateSalesBill']['id'],$sale['PharmacyDuplicateSalesBill']['patient_id']) , array('escape' => false,'class'=>'view_detail' )); ?>
				
				 <?php $website=$this->Session->read('website.instance');
				if($website=='hope')
				{
					 echo $this->Html->image('/img/icons/sale_details.png', array('title' => 'Sale Details','class'=>'all_detail','onclick'=>"viewDetails($patientId)"));
					 echo $this->Html->image('/img/icons/view_all.png', array('title' => 'Medication Details','class'=>'medication_detail','onclick'=>"medicationDetails($patientId)"));
				}	
				?>
				
				</td>
			
				<?php
// 				$url = Router::url($this->Html->image('icons/print.png',array("controller" => "pharmacy", "action" => "inventory_print_view",'PharmacySalesBill',$sale['PharmacySalesBill']['id'],'inventory'=>true)));
				
// 				?>
		
<!-- 				<input name="print" type="button" value="Print" class="blueBtn" tabindex="36" 
					onclick="window.open('<?php //echo $url;?>','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );" />-->
					
				
		</tr>
		<?php $totalBill=$totalBill+$total;
		$total=0;$paidTotal=0;
		endforeach;
		?>
 		<tr>
 		<td align="right"><b>Total Bill Cost :</b></td>
 		<td align="left"><b><?php echo $totalBill;?></b> </td></tr>
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
	<div style="width: 45%; float: right;" id="content-list"></div>

</div>

<?php 					
		if(isset($this->params->query['print']) && !empty($_GET['id'])){ 
			echo "<script>var openWin = window.open('".$this->Html->url(array('controller'=>'Pharmacy','action'=>'inventory_print_view','PharmacyDuplicateSalesBill',$_GET['id']))."', '_blank',
			           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
		}
	?>

<script>

 $("#bill_no").autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_duplicate_bill","bill_code","inventory" => true,"plugin"=>false)); ?>",
    minLength: 1, 
	select: function( event, ui ) {
		console.log(ui.item);
	},
	messages: {
        noResults: '',
        results: function() {}
 	}	
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
 


//by pankaj 
 
$("#customer_name").focus(function(){
	$(this).autocomplete({ 
		source: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_patient_detail","lookup_name",'no',"inventory" => true,"plugin"=>false)); ?>"+"/"+$("#is_checked").val(),
		 minLength: 1, 
		 select: function( event, ui ) {
			 var patient_id = ui.item.id;
			$("#person_id").val(patient_id);
		},
			messages: {
		        noResults: '',
		        results: function() {}
		 }	
	});
});

//EOF pankaj 
$('.view_detail').click(function(){
	var patient_name=$('#patient_name').html();
	var patient_id=$(this).attr('patient_id');
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "duplicate_sales_bill_details","inventory"=>true)); ?>"+'?customer_name='+patient_name+'&person_id='+patient_id,
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
	var patient_id=$(this).attr('patient_id');
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "pharmacy_details","cash_collected","inventory"=>true)); ?>"+'?customer_name='+patient_name+'&person_id='+patient_id,
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

function viewDetails(patientId){
	
	window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "view_details","inventory"=>true)); ?>/'+patientId+"/duplicate",
	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');

	/*$.fancybox({
		'width' : '100%',
		'height' : '100%',
		'autoScale': true,
		'transitionIn': 'fade',
		'transitionOut': 'fade',
		'type': 'iframe',
		'href': "<?php echo $this->Html->url(array("controller"=>"Pharmacy", "action" => "view_details","inventory"=>true)); ?>"+"/"+patientId,
		'onLoad': function () {
			
			}
		});*/
}
function medicationDetails(patientId){
	
	window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "medication_detail","inventory"=>false)); ?>/'+patientId+"/duplicate",
	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');

	
}
$("#all_encounter").click(function(){
	if($(this).is(":checked")){
		$("#is_checked").val(1);
	}else{
		$("#is_checked").val(0);
	}
});

</script>
