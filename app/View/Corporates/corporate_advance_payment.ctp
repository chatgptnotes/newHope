<?php  echo $this->Form->create('corporateClaims',array('id'=>'corporateClaims','default'=>false,  
		'url'=>array('controller'=>'corporates','action'=>'updatePackageAmount') ,'inputDefault'=>array('div'=>false,'label'=>false,'error'=>false)));?>
		 
		<table  width="100%" class="tabularForm">
			<tr>
				<th width="20%">Name</th>
				<th width="20%">Hospital Invoice</th>
				<th width="20%">Advance Received</th> 
				<th width="10%">Previous Deduction</td>
				<th width="10%">Bill No</th>
				<th width="10%">Amount Received</th>
				<th width="10%">TDS</th>
				<th width="10%">Other Deduction</th>
				<th width="20%">Date</th>
				<th width="20%">Remark</th> 
				<th width="20%">Action</th>
			</tr>
			<tr>
				<td><?php
					 $totalAmount = $totalAmount-$patientPaidAmt-$discountGiven ;
					 echo $this->Form->hidden('patient_id',array('type'=>'text','id'=>'patient_id','value'=>$patient_id));
					 echo $this->Form->hidden('advance_received',array('type'=>'text','id'=>'advance_received','value'=>$corporatePaidAmt));
					 echo $this->Form->hidden('total_amount',array('type'=>'text','id'=>'total_amount','value'=>$totalAmount)); 
					 echo $this->Form->hidden('previous_discount',array('type'=>'text','id'=>'previous_discount','value'=>$discountGiven));
				 ?>
					<span id="patient_name"><?php echo $patient['Patient']['lookup_name']?></span>
				</td>
				
				<td id="hospitalInv"> <?php  echo $this->Number->currency($totalAmount); ?> </td> 
				
				<td><?php echo $this->Number->currency($corporatePaidAmt); ?> </td>
				
				<td><?php echo $this->Number->currency($discountGiven); ?></td>
				
				<td><?php echo $this->Form->input('bill_number', array('id'=>'bill_'.$bill_id,'type' => 'text','style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_bill_number' ));?></td> 
				
				<td ><?php echo $this->Form->input('cmp_amt_paid', 
						array('id'=>'amount_received','type' => 'text','style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'formClaim validate[optional,custom[onlyNumber]]','value'=>0 )); ?> </td> 
						
				<td ><?php echo $this->Form->input('tds', array('id'=>'tds','type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'formClaim validate[optional,custom[onlyNumber]]' ,'value'=>0));?></td>
				
				<td><?php echo $this->Form->input('other_deduction', array('id'=>'otherDeduction','type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class' =>'validate[optional,custom[onlyNumber]]'));?></td> 
				 
				<td><?php $d= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
				 	  echo $this->Form->input('bill_uploading_date',array( 'class'=>'bill_uploading_date','label'=>false,'value'=>$d ));  ?> </td> 
				
				<td><?php echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','label'=>false,'rows'=>'1','cols'=>'10','class'=>'add_remark' ));?></td>
				 
				<td><?php echo $this->Html->image('icons/savesmall.png',array('id'=>'save-corporate-claim','class'=>'corporateClaims')) ; ?></td>
			</tr>
		</table> 
		<?php 
		echo $this->Form->end(); ?>
		
		<table cellspacing="1" cellpadding="0" border="0" width="100%" align="center" class="tabularForm" style="margin-top:40px;">
        	<tbody><?php //if(!empty($advancePayment) || $patient['Patient']['admission_type']=='IPD'){ ?>
            	<tr>
                	<th width="20%">Date</th>
                	<th width="20%">Advance Payment</th>
               		<th width="20%" style="">TDS</th>
                 	<th width="20%">Other Deduction</th>
                 	<th width="20%">Bill No.</th>
                 	<th width="20%">Remark</th>
             		<th width="20%">Action</th>                            
          		</tr>
			<?php  foreach ($advanceData as $adKey =>$adValue){?>
				<tr id="<?php   echo $listContainer ;?>">
					<td><?php   echo  $this->DateFormat->formatDate2Local($adValue[0]['date'],Configure::read('date_format'),true); ?></td>
        			<td><?php  	echo $this->Number->currency($adValue[0]['amount']);?></td>
		        	<td><?php 	echo $this->Number->currency($adValue[1]['amount']); ?></td>
		        	<td><?php   echo $this->Number->currency($adValue[0]['discount_amount']); ?></td>
		        	<td><?php   echo $adValue[0]['bill_number']; ?></td>
		        	<td><?php   echo $adValue[0]['remark']; ?></td>
		        	<td><?php   echo $this->Html->link($this->Html->image('icons/delete-icon.png'),array('action' => 'corporateAdvanceDelete'), 
		        					array('escape' => false,'class'=>'deleteAdvanceEntry','id'=>'deleteAdvanceEntry_'.$adValue[0]['id']),__('Are you sure?', true));?></td> 
           		</tr>
			<?php } ?>
			</tbody>
		</table> 
            
<script>
	$(document).on('click',".deleteAdvanceEntry",function(event){ 
	    event.preventDefault();
	});

	$( ".bill_uploading_date" ).datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		buttonText: "Calendar",
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		maxDate: new Date(),
		maxTime : true,
        showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate($CalenderTime);?>',
	});
	
	$('.corporateClaims').click(function(){ 
			var validatePerson = jQuery("#corporateClaims").validationEngine('validate'); 
	  	 	if(!validatePerson){
	  		 	return false;
	  		}
  		
			/*var discountVar=$('#otherDeduction').val();
			if(discountVar!='' || discountVar!='0'){
				var conResult = confirm("You are giving discount of rupees "+discountVar);
				if(conResult==false){
					return false;
				} 
			}*/
			
			postdata = $("#corporateClaims").serialize() ; 
			concat  = "Please confirm your payment amount before proceeding, payment amount is Rs.";
			if($("#amount_received").val() != ''){
				concat += $("#amount_received").val();
			}
			if($("#tds").val() != ''){
				concat += ", TDS is "+$("#tds").val();
			}
			if($("#otherDeduction").val() != ''){
				concat += " and  Other deduction is "+$("#otherDeduction").val();
			} 
			
			res = confirm(concat);
			if(res){
				$.ajax({
					url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "updatePackageAmount", "admin" => false));?>"+'/'+$('#patient_id_place_holder').val()+"/"+<?php echo $tariff_standard_id ;?>,
					type: 'POST',
					data : $("#corporateClaims").serialize(),  
					beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success: function(data){
						$('#container').html(data);
						$('#busy-indicator').hide();
						$.fancybox.close();
						window.location.reload();
					}
				});
			}
			return false ;
		}); 
 
	$('#amount_received,#tds').keyup(function(){
		var hospitalAMt="<?php echo $totalAmount;?>";
		var amtRec=$("#amount_received").val();
		var tds=$("#tds").val();
		var advance  = $("#advance_received").val(); 
		var previous_discount =parseInt($('#previous_discount').val()); 	// Advance Recieved coming from database 50 
		total = parseInt(amtRec)+parseInt(tds)+parseInt(advance)+parseInt(previous_discount); 
		 
		if(parseInt(total) > parseInt(hospitalAMt)){
			$(this).val('');
			$("#otherDeduction").val('0');
			alert("Addition of amount received and TDS is greater than Hospital invoice");
			return false;
		} 
	}); 
	
	 $('.deleteAdvanceEntry').click(function(){
		 var currentID=$(this).attr('id');
		 var splitedVar=currentID.split('_');
		 var recID=splitedVar[1]; 
	 
		 $.ajax({
				url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "corporateAdvanceDelete", "admin" => false));?>"+'/'+recID,
				type: 'POST',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$.fancybox.close();
					window.location.reload();
				}
			});
 

	 });  

	$('.formClaim').keyup(function(){
		    var bill = $(this).attr('id') ;
		    splittedId = bill.split("_");
		    packageId = splittedId[1];
		    var val = $(this).val();
		    var subtract	= parseInt($('#total_amount').val()); 	// Hospital Amount Recieved 192
			var adv_rcd =parseInt($('#advance_received').val()); 	// Advance Recieved coming from database 50 
			var tds = ($('#tds').val() != '') ? parseInt($('#tds').val()) : 0; 		// TDS amount  0
			var amtRec = parseInt($('#amount_received').val()); 	// Amount Recieved from CGHS  
		
			if(isNaN(subtract)){
				subtract=0;
				}
			if(isNaN(amtRec)){
				amtRec=0;
				}
			if(isNaN(adv_rcd)){
				adv_rcd=0;
				}
			if(isNaN(tds)){
				tds=0;
				}
			if(isNaN(val)){
				val=0;
				}
			var totalAmnt = parseInt(subtract) -(parseInt(amtRec)+parseInt(adv_rcd)+parseInt(tds));
			$('#tds').val(tds);
			if(isNaN(totalAmnt)){
				totalAmnt=0;
			}
			$('#otherDeduction').val(totalAmnt); 
	});
</script>