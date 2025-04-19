<?php 
if($servicesData[0]['Patient']['is_discharge']==1){
	$discharge='yes';
}else{
	$discharge='no';
}

$serviceTotal=0;
$servicePaid=0;
foreach($serviceCharge as $service_charge){
	if($service_charge['Billing']['total_amount']>$serviceTotal)$serviceTotal=$service_charge['Billing']['total_amount'];
	$servicePaid=$servicePaid+$service_charge['Billing']['amount'];
	//$servicePaid=$servicePaid+$service_charge['Billing']['discount'];
}

$hospitalType = $this->Session->read('hospitaltype');
if($hospitalType == 'NABH'){$nursingServiceCostType = 'nabh_charges';}else{$nursingServiceCostType = 'non_nabh_charges';}
 
if(!empty($servicesData)){?>
<table width="100%">
	<tr>
	<?php if($discharge=='no'){?>
		<td style="padding-bottom: 10px" align="right"><?php 
			if($isNursing!='yes')
				echo $this->Html->link('Print Report','javascript:void(0)',array('id'=>'serviceReport','class'=>'blueBtn','escape' => false)); ?>
		</td>
		<?php }?>
	</tr>
 </table> 
<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm" id="serviceGrid">
		<tr>
			<th class="table_cell"><?php echo __('Date');?></th>
			<th class="table_cell"><?php echo __('Service');?></th>
			<th class="table_cell"><?php echo __('Unit Price');?></th>
			<th class="table_cell"><?php echo __('No of times');?></th>
			<th class="table_cell"><?php echo __('Amount');?></th>
			<!-- <th class="table_cell"><?php //echo __('Description');?></th> -->
			<?php if($discharge=='no'){?>
			<th class="table_cell"><?php echo __('Action');?></th>
			<?php }?>
		</tr>
	<?php $totalAmount=0;
	 $i=0;
	foreach($servicesData as $services){ 
		$serviceGroup=($services['ServiceCategory']['alias'])?$services['ServiceCategory']['alias']:$services['ServiceCategory']['name']; ?>
		<tr class="row" id=row_<?php echo $services['ServiceBill']['id']; ?>>
			
		
			<td align="">
				<?php //echo $services['ServiceBill']['date'];
					if(!empty($services['ServiceBill']['date']))echo $this->DateFormat->formatDate2Local($services['ServiceBill']['date'],Configure::read('date_format'),true);
				?>
			</td>
		 
			<td><?php echo $services['TariffList']['name'];?></td>
			<td align="right"><?php echo $services['ServiceBill']['amount'];?></td>
			<td align=""><?php echo $no_of_time = $services['ServiceBill']['no_of_times']?$services['ServiceBill']['no_of_times']:1;?></td>
			<td align="right" class="amountBill" id="<?php echo 'amountBill_'.$i ?>"><?php echo ($totalAmount1=$services['ServiceBill']['amount']*$no_of_time);
			$totalAmount=$totalAmount+$totalAmount1;?></td>
			<?php //hidden field to save partially paid amount 
			if($services['ServiceBill']['id']== $paidService[$services['ServiceBill']['id']] ){
				$paidAmt=$totalAmount1;
			}else{
					$paidAmt='0';
			}
			
			 echo $this->Form->input('partial_paid_amt',array('type'=>'hidden','id'=>'partial_amt_'.$i,'value'=>$paidAmt));?>
			
			<?php if($servicesData[0]['ServiceCategory']['name']!=Configure::read('mandatoryservices')){?>
			<!-- <td  ><?php //echo $services['ServiceBill']['description'];?></td> -->
			<?php if($discharge=='no'){ ?>
			<td align="center">
			<?php 
			if(empty($serviceCharge)){
				echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteService','id'=>'deleteService_'.$services['ServiceBill']['id']),
						array('escape' => false)) ;
			}
			
			/*echo $this->Html->image('icons/edit-icon.png',array('style'=>'display:'.$displayStatus,'title'=>'Edit','alt'=>'Edit','class'=>'editService','id'=>'editService_'.$services['ServiceBill']['id']),
					array('escape' => false));*/
			?>
			</td>
			
			<?php }} ?>
		</tr>
		
		
	<?php $i++; }?>
	
		 
	<tr>
		<td colspan="4" valign="middle" align="right"><?php echo __('Total Amount');?></td>
		<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmount);?></td>
		<td >&nbsp;</td>
	</tr>
</table>
<?php } ?>

<?php if(!empty($serviceCharge) && $isNursing!='yes'){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="clear:both">
	<tr><td >&nbsp;</td></tr>
	<tr>
  		<td style="text-align:center" colspan="5"><strong>Payment Received For Implant</strong></td>
  	</tr>
  	
  	<tr>
  	<td>
  		<table width="100%" cellpadding="0" cellspacing="1" border="0" style="clear:both" class="tabularForm">
		<tr >
		 	<th >Deposit</th>
            <th >Date/Time</th>
            <th >Mode of Payment</th>
            <th >Action</th>
            <th >Print Receipt</th>
		</tr>
		<?php  $totalpaid=0;
			   $paidtopatient=0;
			   $totalpaidDiscount=0;
		foreach($serviceCharge as $serviceCharge){
			if($serviceCharge['Billing']['refund']=='1'){
				//echo $paidtopatient1=$serviceCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$serviceCharge['Billing']['paid_to_patient'];
				continue;
			}else{
				if(!empty($serviceCharge['Billing']['discount'])){
					//echo $totalpaid1=$serviceCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$serviceCharge['Billing']['discount'];
					$totalpaidDiscount=$totalpaidDiscount+$serviceCharge['Billing']['discount'];
					if(empty($serviceCharge['Billing']['amount']))
						continue;
				}
			} ?>
		<tr>
			<td align="right"><?php 
			/*if($serviceCharge['Billing']['refund']=='1'){
				//echo $paidtopatient1=$serviceCharge['Billing']['paid_to_patient'];
				$paidtopatient=$paidtopatient+$serviceCharge['Billing']['paid_to_patient'];
				continue;
			}else{*/
				/*if(empty($serviceCharge['Billing']['amount']) && !empty($serviceCharge['Billing']['discount'])){
					echo $totalpaid1=$serviceCharge['Billing']['discount'];
					$totalpaid=$totalpaid+$totalpaid1;
					$totalpaidDiscount=$totalpaidDiscount+$totalpaid1;
				}else*/if(!empty($serviceCharge['Billing']['amount'])){
					echo $totalpaid1=$serviceCharge['Billing']['amount']/*+$serviceCharge['Billing']['discount']*/;
					$totalpaid=$totalpaid+$totalpaid1;
				}
			//}?></td>
			<td><?php echo $this->DateFormat->formatDate2Local($serviceCharge['Billing']['date'],Configure::read('date_format'),true);?></td>
			<!-- <td><?php echo $serviceCharge['Billing']['reason_of_payment'];?></td> -->
			<td><?php echo $serviceCharge['Billing']['mode_of_payment'];?></td>
			<td><?php 
			echo $this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete','class'=>'deleteServiceRec',
					'id'=>'deleteServiceRec_'.$serviceCharge['Billing']['id']),array('escape' => false));

			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
				 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printAdvanceReceipt',
				 $serviceCharge['Billing']['id']))."', '_blank',
				 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			?></td>
			<td height="30px"><?php  
			if(!empty($serviceCharge['Billing']['tariff_list_id'])){
			echo $this->Html->link('Print Receipt','javascript:void(0)',
			 		array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'billReportLab',
			 				$patientID,'?'=>array('flag'=>'Services','groupID'=>$groupID,'recID'=>$serviceCharge['Billing']['id'])))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
			 }?></td>
		</tr>
		<?php }?> 
		</table>
  	</td>
  	</tr>
  	<tr><td >&nbsp;</td></tr>
  	 
</table>
<?php }?>

<?php //}?>
<script>
var categoryName='<?php echo $servicesData[0]['ServiceCategory']['name'];?>';
var mandatoryFlag='<?php echo Configure::read('mandatoryservices');?>';

$('.checkbox1').attr('checked', true);
$("#selectall").attr('checked', true);
var chk1Array=[];var tCount=0;
$(".checkbox1:checked").each(function () {
	  checkId=this.id;
	  if(!$(this).is(':disabled')){
	   val =$("#"+checkId).val();
	   chk1Array.push(val);
	  }
	});

$( '#paymentDetail', parent.document ).trigger('reset');
$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
$( '#totaladvancepaid', parent.document ).val('<?php echo $servicePaid=$servicePaid/*+$totalpaidDiscount*/;?>');
$( '#maintainRefund', parent.document ).val('<?php echo $paidtopatient;?>');
$( '#maintainDiscount', parent.document ).val('<?php echo $totalpaidDiscount;?>');
$( '#tariff_list_id', parent.document ).val(chk1Array);
$( '#totalamountpending', parent.document ).val('<?php echo $totalAmount+$paidtopatient-$servicePaid-$totalpaidDiscount;?>');
//$( '#amount', parent.document ).val('<?php //echo $totalAmount+$paidtopatient-$servicePaid;?>');commented to allow partial payment..


$(".deleteService").click(function(){
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	recId=splitedVar[1];
	patient_id='<?php echo $patientID;?>';
	groupID='<?php echo $groupID;?>';
	
	if(confirm("Do you really want to delete this record?")){
		$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteServicesCharges", "admin" => false)); ?>"+"/"+recId+"/"+patient_id+'?Flag=opdBill',
			  context: document.body,
			  success: function(data){ 
					  parent.getWardData(patient_id,groupID);
					  parent.getbillreceipt(patient_id);	
				  $("#busy-indicator").hide();			  
			  },
			  beforeSend:function(){$("#busy-indicator").show();},		  
		});
	}else{
		return false;
	}
});



/*
 * edit individual service record
 */
$(".editService, .cancelService").click(function(){
	var currentRecId=$(this).attr('id');
	splitedVar=currentRecId.split('_');
	type=splitedVar[0];
	recId=splitedVar[1];
	if(type=='editService'){
		$(".duplicateRow").hide();
		$(".row").show();
		$("#row_"+recId).hide();
		$("#duplicateRow_"+recId).show();
	}else if(type=='cancelService'){
		$("#duplicateRow_"+recId).hide();
		$("#row_"+recId).show();
	}
});


/*
 * datepicker for service
 */
$(".editServiceDate").datepicker(
	{
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'dd/mm/yy HH:II:SS',
		maxDate:new Date(),
		//onSelect:function(){$(this).focus();}
	});
//});

/*
 * autocomplete for service
 */
 
$(document).ready(function(){
	
	 var tariffStanderdId='<?php echo $servicesData[0]['Patient']['tariff_standard_id']?>';
	 var selectedGroup = '<?php echo $groupID;?>';
	 //autocomplete for service sub group 
	 $(document).on('focus','.getServiceSubGroup', function() {
		var currentRecId=$(this).attr('id');
		splitedVar=currentRecId.split('_');
		ID=splitedVar[1];
		 $("#add-service-sub-group_"+ID).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getListOfSubGroup","admin" => false,"plugin"=>false)); ?>/"+selectedGroup,
			 minLength: 1,
			 select: function( event, ui ) {
				$('#addServiceSubGroupId_'+ID).val(ui.item.id);
				var sub_group_id = ui.item.id; 
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	 });

	 $(document).on('focus','.getServiceID', function() {
		var currentRecId=$(this).attr('id');
		splitedVar=currentRecId.split('_');
		ID=splitedVar[2]; 
	 	var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
		$("#service_id_"+ID).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+"/"+subGroupID+'?tariff_standard_id='+tariffStanderdId,
			 minLength: 1,
			 select: function( event, ui ) {					 
				$('#onlyServiceId_'+ID).val(ui.item.id);
				var id = ui.item.id; 
				var charges=ui.item.charges;
				if(charges !== undefined && charges !== null){
					$('#service_amount_'+ID).val(charges.trim());
					$('#amount_'+ID).html(charges.trim());
				}
				//serviceSubGroups(this);
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	});
		
 });



 $('.nofTime').on('keyup',function(){
	var currentRecId=$(this).attr('id');
	splitedVar=currentRecId.split('_');
	ID=splitedVar[3];
  	
	serviceAmt=$('#service_amount_'+ID).val(); 
  	valtimes = $(this).val(); 
  	if(isNaN(valtimes)==false){ 
			if(serviceAmt !=''){
		    	totalAmt=serviceAmt*valtimes;
		    	$('#amount_'+ID).html(totalAmt);
			}else{
				alert('Please enter Unit price.');
				$('#service_amount_'+ID).val(''); 
				$(this).val('');
				return false;
			}
  	}else{
  		alert('Please enter valid data.');
			$(this).val('');
			return false;
      }
 });

 $('.service_amount').on('keyup',function(){
	 	var currentRecId=$(this).attr('id');
		splitedVar=currentRecId.split('_');
		ID=splitedVar[2]; 
    	
		noOfTime=$('#no_of_times_'+ID).val(); 
    	valprice = $(this).val(); 
    	if(isNaN(valprice)==false){ 
	  		if(noOfTime !=''){
	  	    	totalAmt=noOfTime*valprice;
	  	    	$('#amount_'+ID).html(totalAmt);
	  		}
    	}else{
  		alert('Please enter valid amount.');
  		$(this).val('');
			return false;
        }
 });

/*
 * update service record
 */
 $(".saveService").click(function(){
	  var flag='Service';
	  patient_id='<?php echo $patientID;?>';
	  groupID='<?php echo $groupID;?>';
	  var currentRecId=$(this).attr('id');
	  splitedVar=currentRecId.split('_');
	  recId=splitedVar[1];
	   
  		date = $('#ServiceDate_'+recId).val();
		subGroupID = $('#addServiceSubGroupId_'+recId).val();
		serviceID = $('#onlyServiceId_'+recId).val();
		amount = $('#service_amount_'+recId).val();
		noOfTimes = $('#no_of_times_'+recId).val();
		description = $('#description_'+recId).val();
		suplier = $('#suplier_'+recId).val();

		$.ajax({
  			type : "POST",
  			data: "date="+date+"&amount="+amount+"&subGroupID="+subGroupID+"&serviceID="+serviceID+"&noOfTimes="+noOfTimes+"&description="+description+"&suplier="+suplier,
  			url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "updateService", "admin" => false)); ?>"+'/'+patient_id+'/'+recId+'?flag='+flag+'&groupID='+groupID,
  			context: document.body,
  			success: function(data){ 
  				parent.getWardData(patient_id,groupID);
				parent.getbillreceipt(patient_id);	
  				$("#busy-indicator").hide();
  			},
  			beforeSend:function(){$("#busy-indicator").show();},		  
		});
 });

 /*
  * clear charges after clearing service name
  */
  	$(document).on('focusout','.getServiceSubGroup', function() {
  		var currentRecId=$(this).attr('id');
		splitedVar=currentRecId.split('_');
		ID=splitedVar[1];
		 if($(this).val()==''){
			 $('#addServiceSubGroupId_'+ID).val('');
		 }
	 });
	
	 $(document).on('focusout','.getServiceID', function() {
		 var currentRecId=$(this).attr('id');
		 splitedVar=currentRecId.split('_');
		 ID=splitedVar[2]; 
		 if($(this).val()==''){
			 $('#onlyServiceId_'+ID).val('');
			 $('#service_amount_'+ID).val('');
			 $('#no_of_times_'+ID).val('1');
			 $('#amount_'+ID).html('');
		 }
	 });

/*	 $('#selectall').click(function(event) {  //on click
	        if(this.checked) { // check select status
	            $('.checkbox1').each(function() { //loop through each checkbox
	                this.checked = true;  //select all checkboxes with class "checkbox1"
	                $('.checkbox1').attr('disabled','disabled');              
	            });
	            $( '#paymentDetail', parent.document ).trigger('reset');

	        	$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
	        	$( '#totaladvancepaid', parent.document ).val('<?php echo $servicePaid;?>');
	        	$( '#totalamountpending', parent.document ).val('<?php echo $totalAmount-$servicePaid;?>');
	        }else{
	            $('.checkbox1').each(function() { //loop through each checkbox
	                this.checked = false; //deselect all checkboxes with class "checkbox1"   
	                $('.checkbox1').attr('disabled',false);                  
	            });        
	        }
	    });

	  //If one item deselect then button CheckAll is UnCheck
	    $(".checkbox1").click(function () {
		    if (!$(this).is(':checked')){	
			    //if selected checkbox is unchecked all checkboxes to be enabled	        
	            $("#selectall").prop('checked',true);
	            $('.checkbox1').each(function() { //loop through each checkbox
	                this.checked = true;  //select all checkboxes with class "checkbox1"
	                $('.checkbox1').attr('disabled','disabled');              
	            });
	            // if the checked box is umcheck then reset billing amt to total bill amount
	            $( '#paymentDetail', parent.document ).trigger('reset');
	        	$( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
	        	$( '#totaladvancepaid', parent.document ).val('<?php echo $servicePaid;?>');
	        	$( '#totalamountpending', parent.document ).val('<?php echo $totalAmount-$servicePaid;?>');
	        	$( '#tariff_list_id', parent.document ).val('');//service id
	            		
	        }else{
		        // hidden checkbox to be checked when edit row
		           checkId=this.id;
			       hiddencheck=checkId.split('_')
			       $('#optnCheck_'+hiddencheck[1]).checked=true;

					//Seelcted service amount in billing section
				   var totalAmount= $('#amountBill_'+hiddencheck[1]).html();
				   var tariffId=$('#'+checkId).attr('tariffId');
				   var advPaid=$('#partial_amt_'+hiddencheck[1]).val();
				   var balAmt=totalAmount-advPaid;
				   if(advPaid==''){
					   balAmt='0.00';
					   advPaid='0.00';
				   }
				   $( '#paymentDetail', parent.document ).trigger('reset');
				   $( '#totalamount', parent.document ).val(totalAmount);
				   $( '#tariff_list_id', parent.document ).val(tariffId);//service id
				   $( '#totaladvancepaid', parent.document ).val(advPaid);
		           $( '#totalamountpending', parent.document ).val(balAmt);
			       
			       $(".checkbox1").attr('disabled','disabled');
			       $(this).attr('disabled',false);
			        //For only one service to be selected at a time
	       
	        	
	        }
        	
	    });*/

    $('#selectall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
           	 if(!$(this).is(':disabled'))
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
            $( '#paymentDetail', parent.document ).trigger('reset');
            $( '#discount', parent.document ).hide();
            $( '#totalamount', parent.document ).val('<?php echo $totalAmount;?>');
            $( '#totaladvancepaid', parent.document ).val('<?php echo $servicePaid;?>');
            $( '#tariff_list_id', parent.document ).val(chk1Array);
            $( '#totalamountpending', parent.document ).val('<?php echo $totalAmount+$paidtopatient-$servicePaid;?>');
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
           	 if(!$(this).is(':disabled'))
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });
            $( '#paymentDetail', parent.document ).trigger('reset');
            $( '#discount', parent.document ).hide();
            $( '#totalamount', parent.document ).val('0');
            $( '#totaladvancepaid', parent.document ).val('0');
            $( '#amount', parent.document ).val('0');
            //$( '#totalamountpending', parent.document ).val('<?php //echo $totalAmt+$paidtopatient-$labPaid;?>');
            $( '#totalamountpending', parent.document ).val('0');
            $( '#tariff_list_id', parent.document ).val('');//service id        
        }
    });

   //If one item deselect then button CheckAll is UnCheck
    $(".checkbox1").click(function () {
        if (!$(this).is(':checked'))
            $("#selectall").attr('checked', false);
     var totalAmount=0;var count=0; var tCount=0;
     var advPaid=0;var balAmt=0;
     var chkArray=[];
   		  $(".checkbox1:checked").each(function () {
   			  count++;
   			  checkId=this.id;
   			  hiddencheck=checkId.split('_');
   			  if(!$(this).is(':disabled')){
   			  val =$("#"+checkId).val();
   			   chkArray.push(val);			  
   			   totalAmount=totalAmount+parseInt($('#amountBill_'+hiddencheck[1]).html());
   			   advPaid=advPaid+parseInt($('#partial_amt_'+hiddencheck[1]).val());
   			  }
   			});
   			
   		  balAmt=totalAmount-advPaid;
   		  if(advPaid=='' || isNaN(advPaid)){
   			  balAmt=totalAmount
   			  advPaid='0.00';
   		   }
   		  $('.checkbox1').each(function() { //loop through each checkbox
   			  tCount++; 
   				              
   	         });
   	         if(tCount==count){
   	        	 $("#selectall").prop('checked', true);
   	         }
   		   			
   	   $( '#paymentDetail', parent.document ).trigger('reset');
   	   $( '#totalamount', parent.document ).val(totalAmount);
   	   $( '#tariff_list_id', parent.document ).val(chkArray);//service id
   	   $( '#totaladvancepaid', parent.document ).val(advPaid);
   	   $( '#amount', parent.document ).val(balAmt);
   	   //$('#amount', parent.document).attr('readonly',true);
          $( '#totalamountpending', parent.document ).val(balAmt);

       if(chkArray==''){
       	$( '#paymentDetail', parent.document ).trigger('reset');
       	$( '#totalamount', parent.document ).val('0');
       	$( '#totaladvancepaid', parent.document ).val('0');
       	$( '#amount', parent.document ).val('0');
       	//$( '#totalamountpending', parent.document ).val('<?php //echo $totalAmt+$paidtopatient-$labPaid;?>');
       	$( '#totalamountpending', parent.document ).val('0');
       	$( '#tariff_list_id', parent.document ).val('');//service id
       }
    });
    

  //for printing custom service report.
 	var serviceToPrint = new Array();
 	$('.customCheckbox').click(function(){	
 		var currentId= $(this).attr('id');
 		if($(this).prop("checked"))
 			serviceToPrint.push($('#'+currentId).val());
 		else
 			serviceToPrint.remove($('#'+currentId).val());
 		});
 	 
	$('#serviceReport').click(function(){
		if(serviceToPrint!=''){
			var printUrl='<?php echo $this->Html->url(array("controller" => "Billings", "action" => "billReportLab",$patientID)); ?>';
			var printUrl=printUrl +"?flag=Services&groupID="+'<?php echo $groupID;?>';
			var printUrl=printUrl + "&serviceToPrint="+serviceToPrint;
			var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
		}else{
			alert('Select Service from Print Report.');
			return false;
		}
 	});

	//for deleting billing record
	$('.deleteServiceRec').click(function(){
		currentID=$(this).attr('id');
		splitedVar=currentID.split('_');
		recId=splitedVar[1];

		patient_id='<?php echo $patientID;?>';
		groupID='<?php echo $groupID;?>';
		
		if(confirm("Do you really want to delete this record?")){
			$.ajax({
			  type : "POST",
			  //data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "deleteBillingEntry", "admin" => false)); ?>"+"/"+recId,
			  context: document.body,
			  success: function(data){ 
				  parent.getWardData(patient_id,groupID);
				  parent.getbillreceipt(patient_id);	
			  	  $("#busy-indicator").hide();				  
			  },
			  beforeSend:function(){$("#busy-indicator").show();},		  
			});
		}else{
			return false;
		}
	});
</script>