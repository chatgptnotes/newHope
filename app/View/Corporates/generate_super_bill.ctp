<?php echo $this->Html->css(array( 'jquery.fancybox' /*,'colResizable.css'*/));  
 	  echo $this->Html->script(array('jquery.fancybox' /*,'colResizable-1.4.min.js'*/ )); ?> 
<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.TbodySales {
	width: 100%;
	max-height: 400px; 
	overflow: auto;
}

.tabularForm td td {
	padding: 0;
}
element.style {
    min-height: 77px;
}

textarea {
	width: 85px;
}

.tdLabel2 img{ float:none !important;}

tr.rowColor td{
  background-color: #FFAAAA;
}

tr.selectedColor td{
	background-color: #B18E8C;
}

#ui-datepicker-div{z-index:10000;}

#busy-indicator{z-index:10000;}
</style>
<script type="text/javascript">

$(function() {
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
		
 $("#to").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});
});	
</script>
<?php  
 	  //echo $this->element('corporate_billing_report');?>
 
<?php 
	$flashMsg = $this->Session->flash('still') ;
	if(!empty($flashMsg)){ ?>
	<div>
		<?php echo $flashMsg ;?>
	</div> 
<?php } ?>
<div class="inner_title">
	<h3>Generate Super Bill<?php // echo $tariffData[$tariffStandardID];?></h3>
    	<div style="float:right;">
		<span style="float:right;">
    		<?php	
 	  			echo $this->Form->create('',array('url'=>array('controller'=>'Corporates','action'=>'generate_super_bill','admin'=>false),'id'=>'otherOutRepFrm','type'=>'get')); 
				echo $this->Html->link('Back',array('controller'=>'Corporates','action'=>'corporate_super_bill_list'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
				
				if($this->params->pass[0]){
					$tariffStdId=$this->params->pass[0];
				}else{
					$tariffStdId='no';
				}
				//echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,$tariffStdId,'excel',		
				//	'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));	?>
		</span>
	</div>			
</div>
<div class="clr ht5"></div>
<table width="" cellpadding="0" cellspacing="0" border="0" class="tdLabel2" style="color: #000;">
	<tr>
		  <td valign="top">					
		  <td style="color:#000;" valign="top">
				<?php echo __("Patient : ")."&nbsp;".$this->Form->input('lookup_name', array('id' => 'lookup_name','value'=>$this->params->query['lookup_name'],
						 'label'=> false, 'div' => false ,'autocomplete'=>'off','class'=>'name'));
				
						echo $this->Form->hidden('patient_id',array('id'=>'patient_id','value'=>$_GET['patient_id']));
				?> 
		  </td>
		  <td>&nbsp;&nbsp;</td> 		 
		  <td valign="top">
		  <span id="look_up_name" class="LookUpName">
					<?php echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false));
					//echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'other_outstanding_report',$tariffStandardID,'admin'=>'TRUE'),array('escape'=>false, 'title' => 'Refresh'));
					echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),'javascript:void(0)',array('escape'=>false, 'title' => 'Reset','id'=>'reset'));
					?>
		 </span>
		  </td>						
	</tr>
</table>
<?php  echo $this->Form->end();?>	
 <div class="clr">&nbsp;</div>
<div id="container">  


<?php echo $this->Form->create('',array('id'=>"superBill"));?>
<?php if(!empty($results)){?>
<div style="width:100%" class="TbodySales">
<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable resizable sticky" id="item-row" style="top:0px;  overflow: scroll;">
	<thead>
		<th width="2%"  align="center" style="text-align:center;">#</th>
	    <th width="2%"  align="center" style="text-align:center;">No.</th>
		<th width="20%"  align="center" style="text-align:center;">Name Of Patient</th>
		<th width="5%"  align="center" style="text-align: center;">Patient ID</th>
		<th width="5%"  align="center" style="text-align: center;">MRN ID</th>
		<th width="10%"  align="center" style="text-align: center;">Corporate Name</th>
		<th width="10%"  align="center" style="text-align: center;">Date of Admission</th> 
		<th width="10%"  align="center" style="text-align: center;">Date of Discharge</th>
		<th width="5%"  align="center" style="text-align: center;">Total Amount</th> 
		<th width="5%"  align="center" style="text-align: center;">Discount</th> 
		<th width="5%"  align="center" style="text-align: center;">Amount Paid By Patient</th> 
		<th width="5%"  align="center" style="text-align: center;">Hospital Invoice Amount</th> 
		<th width="5%"  align="center" style="text-align: center;">Corporate Advance Received</th>
		<th width="5%"  align="center" style="text-align: center;">TDS </th>
		<th width="5%"  align="center" style="text-align: center;">Other Deduction</th>
		<th width="5%"  align="center" style="text-align: center;">Balance</th> 
		 
	<!-- 	<th width="10%"  align="center" style="text-align: center;" >Bill due<br /> Date</th>
		<th width="20%" valign="center" align="center" style="text-align: center; min-width: 100px;">Action</th> -->
	</thead>
	
	<tbody>
	<?php 
	echo $this->Form->hidden('patient_id_place_holder',array('id'=>'patient_id_place_holder')) ;
	echo $this->Form->hidden('person_id',array('value'=>$results[0]['Patient']['person_id']));
	echo $this->Form->hidden('corporate_super_bill_id',array('value'=>$corporate_super_bill_id));
	echo $this->Form->hidden('tariff_standard_id',array('value'=>$results['0']['Patient']['tariff_standard_id']));
	
	$i=0;$val = 0;$tariffStandardID=$results['0']['Patient']['tariff_standard_id'];
	$displayTotalAmount = 0;
	foreach($results as $result)
	{//debug($result);
		$i++;
		$patient_id = $result['Patient']['id'];
		$bill_id = $result['FinalBilling']['id'];
		//holds the id of patient corpotateDiscount
		 
		$total_amount = $result['FinalBilling']['total_amount']-$result[0]['patientPaid'];
		$advance_paid=$result[0]['advacnePAid'];//$result[0]['paid_amount'];
		$tds=$result[0]['TDSPAid'];
		$discount = $result[0]['total_discount'];
		$totalPaid = $advance_paid+ $tds+$discount ; 
		$color = '' ;
		$showEdit='';
		$showDelete='';
		 
		if($total_amount == $totalPaid && $result['FinalBilling']['total_amount']>'0'){
			$color = 'paid_payment';
			$showEdit='none';
			if($result['FinalBilling']['amount_pending']<='0')$showDelete='';
		}else{
			$showEdit='';
			$showDelete='none';
		}
		
		if($result['FinalBilling']['amount_pending']<='0'){
			$showSettlement='none';
		}else{
			$showSettlement='';
		}
		
		$cardAdvance=0;
		/*debug($result);
		foreach($result['PatientCard'] as $cardKey=>$cardValue){
			if($cardValue['type']=='Corporate Advance'){
				$cardAdvance=$cardAdvance+$cardValue['amount'];
			}
		}*/
		
		$isPatientSelected = '';
		$class = "rowColor";
		if(in_array($result['Patient']['id'], $patientSelected)){
			//$isPatientSelected = "checked";
			$isPatientSelected = "disabled";
			$class = "selectedColor";
			//$date = $dischargeDate = $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format'));
		}
		
		?>
	<tr class="<?php echo $class; ?>" id="row_<?php echo $result['Patient']['id'];?>" >
		<td align="center" style="text-align:center;cursor:pointer;color: red; font-size:20px; font-weight: bold;" id="patientid-<?php echo $patientID = $result['Patient']['id']; ?>" class="<?php echo $color ;?> toggleServices">
		+
		</td>
		<td><?php
		echo $this->Form->input('chkPatient',array('type'=>'checkbox','label'=>false,'fieldset'=>false,'autocomplete'=>'off','value'=>$patientID,'disabled'=>$isPatientSelected,'id'=>'checkAll_'.$patientID,'class'=>'subCheckAll','hiddenField'=>false)); ?></td>
		<!-- <td><?php  echo $i; ?></td> -->
		<td  class="<?php echo $color ;?>"> <?php echo $result['Patient']['lookup_name'];  ?> </td>  
		<td  class="<?php echo $color ;?>"> <?php echo $result['Patient']['patient_id'];?></td> 
		<td  class="<?php echo $color ;?>"> <?php echo $result['Patient']['admission_id'];?></td> 
		<td  class="<?php echo $color ;?>"> <?php echo $tariffStandard[$result['Patient']['tariff_standard_id']];?></td> 
		<td  class="<?php echo $color ;?>">
			<?php echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); //date of admission	?>
		</td> 
		<td class="<?php echo $color ;?>" id="dischargeDate_<?php echo $patientID;?>">
			<?php  echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); //date of discharge ?>
		</td>
		<td  class="<?php echo $color ;?>"><?php //debug($result['FinalBilling']['discount']);?>
			<?php echo $this->Form->hidden('cmp_amt_paid', array('id'=>'amt_'.$bill_id,'type' => 'text','style'=>"width:20%",'label'=>false ,
					'div'=>false,'style'=>"width: 70%;",'class'=>'cmp_amt_paid','value'=> round($result['FinalBilling']['total_amount']-round($result['FinalBilling']['discount']))/*$total_amount*/));
				  echo  round($totalAmount=$result['FinalBilling']['total_amount']/*-round($result['FinalBilling']['discount'])*/);//$total_amount ;?>
		</td>  
		<td  class="<?php echo $color ;?>"><?php echo round($result['FinalBilling']['discount']);?></td>
		<td  class="<?php echo $color ;?>"> <?php echo $amntRecievedByPatient =round($result[0]['patientPaid']-$result[0]['total_refund']); // Amount by patient ?> </td> 
		<td  class="<?php echo $color ;?>"> <?php echo $amntpending =round($totalAmount-$amntRecievedByPatient); // Amount pending  ?> </td> 
		<td  class="<?php echo $color ;?>"> <?php echo $amntRecieved =round($result[0]['advacnePAid']+$result['Account']['card_balance']);//$result[0]['advacneCardPAid']; // Amount received  ?> </td>   
		<td  class="<?php echo $color ;?>"> <?php echo $tdsAmnt=round($result[0]['TDSPAid']); //tds amountt  ?> </td> 
		<td  class="<?php echo $color ;?>"> <?php echo $otherDeduction=round($result[0]['total_discount']) ; ?> </td> 
		<td  class="<?php echo $color ;?>"> <?php 
			if($amntpending>0){
				echo $balAmount=round($amntpending-$amntRecieved-$tdsAmnt-$otherDeduction-$corpoateDiscount);//bal amount 
			}else{
				echo "0";//balance will zero if amount pending is zero 
			}
		?></td>
		<!-- <td width="21" align="center" style="text-align: center; min-width: 21px;" class="<?php echo $color ;?>">
		   <?php 
		   		echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete Bill Settled')),
					array('controller'=>'Corporates','action' =>'patient_delete', $result['Patient']['id'],'admin'=>false), 
					array('style'=>'display:'.$showDelete,'escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true)); 
		    
				echo '<a   class="fancybox" href="#corporateClaims" style="display:'.$showEdit.'"  total_amount="'.$result['FinalBilling']['total_amount'].'"  advance_received="'.$result['FinalBilling']['package_amount'].'" patient_id="'.$result['Patient']['id'].'" patient_name="'.$result['Patient']['lookup_name'].'" patient_tariffStandardId="'.$result['Patient']['tariff_standard_id'].'">';
				echo $this->Html->image('icons/edit-icon.png',array('Payment','alt'=>'Edit','title'=>'Edit'));
				echo '</a>';
				
				
				echo $this->Html->link($this->Html->image('icons/money.png',array('title'=>'Bill Settlement')),
					array('controller'=>'Billings','action'=>'full_payment',$result['Patient']['id'],'admin'=>false),
					array( 'style'=>'display:'.$showSettlement,'patient_id'=> $result['Patient']['id'],'class'=>'corporateClaimSave final_payment','escape'=>false));
				
				if($result['Patient']['is_discharge']=='1'){
					echo $this->Html->link($this->Html->image('icons/upload-excel.png',array('alt'=>'Excel Upload','title'=>'Excel Upload')),
						array('controller'=>'billings','action'=>'uploadCorporateExcel',$result['Patient']['id'],'admin'=>false),
						array('class'=> 'uploadExcel billingServicesAction','id'=>'uploadExcel_'.$result['Patient']['id'].'_'.$result['Patient']['tariff_standard_id'],'escape' => false));
					
					if($result['PatientDocument']['filename']){
						echo $this->Html->link($this->Html->image('icons/download-excel.png'),array('controller'=>'Corporates','action' =>'downloadExcel',
								$result['Patient']['id'],$result['PatientDocument']['id'],'admin'=>false),
							array('escape' => false,'title' => 'Download Uploaded Excel', 'alt'=>'Download Uploaded Excel'));
					} 
				}
			?>
    	</td> -->
	</tr>
	<tr id="services-<?php echo $result['Patient']['id'];?>" style="display:none;" class="service-area">
		<td colspan="2"></td>
		<td colspan="14">
			<table>
				<tr><th></th><th>Service</th><th>Total</th></tr>
				<!-- <tr><td><?php echo $this->Form->input('',array('type'=>'checkbox','label'=>false,'fieldset'=>false,'id'=>'checkAll_'.$patientID,'class'=>'subCheckAll')); ?></td>
					<td>Check All</td></tr> -->
				<?php $isSelected = 0; //debug($patientData);
				foreach($patientData as $key =>$value){ 
						if(is_array($value[$result['Patient']['id']])){//e.g services , lab etc 
							foreach($value[$result['Patient']['id']] as $servicesKey =>$servicesVal){ 
									$pID = $result['Patient']['id'];//$servicesVal['patient_id']['patient_id'];
									$isSuperBillIdExists = $servicesVal['patient_id']['corporate_super_bill_id'];
									$checked = '';
									if($isPatientSelected == "checked"){
										$checked = "checked";	//to cehcked services selected
										$isSelected = 1;	//to set patient is selected (is_checked_patient)
										$displayTotalAmount += $servicesVal['amount'];
									} 
									$no_of_times = $servicesVal['count'];
									
								?>

								<tr>
									<!-- <td colspan="2"></td> -->
									<td><?php echo $this->Form->input("$key.id",array('autocomplete'=>"off",'name'=>"data[$key][$pID][$servicesKey]",'type'=>'checkbox',
											'amount'=>$total = $servicesVal['amount'],'class'=>"service-check checked_".$pID,'label'=>false,'fieldset'=>false,'checked'=>$checked,
											'disabled'=>$isPatientSelected,	'div'=>false,'patient_id'=>$pID));?></td>
									<td><?php echo $servicesVal['name'];?></td>
									<td align="center"><?php echo $total;?></td>
								</tr>
							<?php }
						}
					  }?> 
			</table>
			<?php echo $this->Form->hidden('is_checked_patient',array('name'=>"data[Patient][selected][$patientID]",'id'=>'isChecked_'.$result['Patient']['id'],'value'=>$isSelected,'class'=>'isChecked'))?>
		</td>
	</tr>  
	<?php }  ?> 
	</tbody>
</table>
</div>
<table>
	<tr>
		<td> 
			<?php echo $this->Form->hidden('total_amount',array('id'=>"total-amount",'label'=>false,'value'=>$displayTotalAmount,'autocomplete'=>"off"));?>
			Total: <span id="total-amount-area" style="color: red; font-size:20px; font-weight: bold;"><?php echo $displayTotalAmount; ?></span>
		</td>
		<!-- <td>
			<?php //echo __("Approved Amount : ").$this->Form->input('',array('div'=>false,'label'=>false,'autocomplete'=>"off",'name'=>"data[Patient][approved_amount]",'id'=>'approvedAmount'));?>
		</td> -->
		<td><?php echo __("Date : ");?></td>
		<td>
			<?php echo $this->Form->input('',array('div'=>false,'label'=>false,'autocomplete'=>"off",'name'=>"data[Patient][date]",'class'=>'validate[required]','id'=>'date','value'=>$date));?>
		</td>
		<td>
			<?php  
			//$options=array('General'=>'General','Semi-Private'=>'Semi-Private','Private'=>'Private'); 
			$options=Configure::read('corporateStatus') ;
			echo __("Patient Type <font color=red>*</font> : ").$this->Form->input('patient_type',array('div'=>false,'label'=>false,'class'=>'validate[required,mandatory-select]','empty'=>'Please Select','autocomplete'=>"off",'value'=>$results[0]['Patient']['corporate_status'],'name'=>"data[Patient][patient_type]",'id'=>'patient_type'	,'options'=>$options));?>
		</td>
		<td>
		<?php 
			echo $this->Form->submit(__('Submit'),array('type'=>'submit','class'=>'blueBtn','div'=>false,'error'=>false,'id'=>'submit'));
			?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>


<table align="center">
	<tr>
		<?php 
		$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
		 
		?>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
		
		</TD>
	</tr>
</table> 
<?php }?>
 
 </div>
		<?php 	 

		function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
		{
			$date = $cur_date;
			$date = strtotime($date);
			$date = strtotime("+$no_days day", $date);
			return date('Y-m-d', $date);
		}

?>
<Script>  

/*$("#tariff").change(function(){
	var corporate = $(this).val();
	window.location="<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "selectCorporate", "admin" => false)); ?>"+"/"+corporate;
});*/
	$(document).ready(function(){ 
		$('.fancybox').click(function(){
			$('#patient_id_place_holder').val($(this).attr('patient_id')); 
			$('#patient_name').val($(this).attr('patient_name'));
			$('#advance_received').val($(this).attr('advance_received'));
			$('#total_amount').val($(this).attr('total_amount'));
			var tariffStandardID =$(this).attr('patient_tariffStandardId');
			 
			$('.fancybox').fancybox({ 
				'type':'ajax',
				'href':'<?php echo $this->Html->url(array('controller'=>"corporates",'action'=>"corporate_advance_payment",'admin'=>false)) ?>/'+tariffStandardID+'/'+$("#patient_id_place_holder").val() ,
			     helpers     : { 
			    	locked     : true, 
			        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
			     }
			}); 
		});
		
		
		$(".final_payment").click(function(){ 
			$.fancybox({
				'autoDimensions':false,
		    	'width'    : '85%',
			    'height'   : '90%',
			    'autoScale': true,
			  	'transitionIn': 'fade',
			    'transitionOut': 'fade', 
			    'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200,				    
			    'type': 'iframe',
			    'helpers'   : { 
			    	   'overlay' : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox 
			    	  },
			    'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"full_payment","admin"=>false)); ?>/"+$(this).attr('patient_id')+"?corporate=corporate",
			});
		}); 
	});

	 
	$("#submit").click(function(){
		var valid = jQuery("#superBill").validationEngine('validate'); 
		if(!valid){ 
			return false;
		}
	}); 

	 (function($){
		    $.fn.validationEngineLanguage = function(){ };
		    $.validationEngineLanguage = {
		        newLang: function(){
		            $.validationEngineLanguage.allRules = {
		                "required": { // Add your regex rules here, you can take telephone as an example
		                    "regex": "none",
		                    "alertText":"Required.",
		                    "alertTextCheckboxMultiple": "* Please select an option",
		                    "alertTextCheckboxe": "* This checkbox is required"
		                },
		            };
		        }
		    };
		    $.validationEngineLanguage.newLang();
		})(jQuery);
		
	$(".subCheckAll").click(function(){
		var patientID = $(this).attr('id').split("_")[1];
		//$("#patientid-"+patientID).trigger("click");
		if($(this).is(':checked') == true){ 
			$(".checked_"+$(this).attr('id').split("_")[1]).each(function(){
				$(this).prop('checked',true);
			});
			$("#row_"+patientID).removeClass("rowColor").addClass( "selectedColor" );
		}else{
			$(".checked_"+$(this).attr('id').split("_")[1]).each(function(){
				$(this).prop('checked',false);
			}); 
			$("#row_"+patientID).removeClass("selectedColor").addClass( "rowColor" );
		}
		getTotal();
		checkPatientSelected(patientID);
	});

	function getTotal(){
		var total = 0;
		$(".service-check").each(function(){
			if($(this).is(':checked') == true){
				var amount = parseFloat($(this).attr('amount'));
				total += amount;
			}
		});
		$("#total-amount").val(Math.round(total));
		$("#total-amount-area").html(Math.round(total));
		$("#approvedAmount").val(Math.round(total));
	}
	
	
		//functino to toggle between services
		$(".toggleServices").click(function(){
			currentID = $(this).attr('id').split("-")[1];
			var div = document.getElementById("services-"+currentID); 
			if (div.style.display !== 'none') {
				$("#patientid-"+currentID).html('+');
		    }
		    else {
		    	$("#patientid-"+currentID).html('-');
		    }
			$("#services-"+currentID).toggle('fast'); 
		});


		$(function(){
		$(".service-check").click(function(){  
			var total = 0;
			amount = parseFloat($(this).attr('amount')); 
			currentTotal = parseFloat($("#total-amount").val()) ;  
			checkPatientSelected($(this).attr('patient_id'));
			getTotal();
			if($(this).is(":checked")){
				///total = currentTotal+amount;
				//$("#total-amount").val(total.toFixed(2));
				//$("#total-amount-area").html(total.toFixed(2));
			}else{ 
				//total = currentTotal-amount;
				//$("#total-amount").val(total.toFixed(2));
				//$("#total-amount-area").html(total.toFixed(2));
			}
			//$("#approvedAmount").val(total.toFixed(2));
			
		});
		 
		//to preveny redirect on edit and delte buttons of all services 
		$(document).on('click',".corporateClaimSave",function(event){ 
			event.preventDefault();
		});
		
		
		
				/*  var onSampleResized = function(e){  
				    var table = $(e.currentTarget); //reference to the resized table
				  };  
	
				 $("#item-row").colResizable({
				    liveDrag:true,
				    gripInnerHtml:"<div class='grip'></div>", 
				    draggingClass:"dragging", 
				    onResize:onSampleResized
				  });    */
			});	

	function checkPatientSelected(patientId){
		var isChecked = false; 
		var isBlank = false;
		$('.service-check').each(function() {  
			if($(this).attr('patient_id') === patientId && $(this).is(":checked") == true){		//only once for single patient
				isChecked = true;
			}
			if($(this).attr('patient_id') === patientId && $(this).is(":checked") == false){	//only once for single patient
				isBlank = true;
			}
		});

		//to hold the selected patient id if any service of that patient is selected
		if(isChecked == true){
			$("#isChecked_"+patientId).val(1);
		}else{
			$("#isChecked_"+patientId).val(0);
		}

		//to check/uncheck checkAll of particular encounter checkbox
		if(isBlank == true){
			$("#checkAll_"+patientId).prop('checked',false); 
		}else{
			$("#checkAll_"+patientId).prop('checked',true); 
		}

		//to set the last checked encounter discharge date
		var dischargeDate = '';
		$(".subCheckAll").each(function(){
			var patientID = $(this).attr('id').split("_")[1]; 
			if($(this).is(":checked") == true){
				dischargeDate = $("#dischargeDate_"+patientID).text().trim();
			}
		});
		$("#date").val(dischargeDate);	//to set the last checked encounter discharge date
	}

	$("#lookup_name").autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no",'is_discharge=1&tariff_standard_id!='.$pvtTariffId,"admin" => false,"plugin"=>false)); ?>", 
		select: function(event,ui){ 
 			$("#patient_id").val(ui.item.id);
		},
		messages: {
	         noResults: '',
	         results: function() {},
	  	}
	});
	
	$( ".cmp_paid_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		onSelect:function(date){
			var idd = $(this).attr('id');
			 splittedId=idd.split('_'); 
			 var bill_id = $("#bill_"+splittedId[3]).val(); 
			$.ajax({
				type:'POST',
	   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "CMPpaidDate", "admin" => false));?>"+"/"+bill_id,
	   			data:'id='+bill_id+"&date="+date,
	   			success: function(data)
	   			{
		   			//alert(data);
		   		}
			});
		},
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '-50:+50',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',
	});

	$( "#date" ).datepicker({
    	showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		yearRange: '1950',	
		maxDate: new Date(),		  
		dateFormat: '<?php echo $this->General->GeneralDate("HH:II:SS");?>',		
    });

	$('.uploadExcel').click(function(){
		var currentID=$(this).attr('id');
		var splitedVar=currentID.split('_');
		patient_id=splitedVar[1];
		tariffStdId= splitedVar[2];    <?php //echo $tariffStandardID;?>
		
		$('.uploadExcel').fancybox({ 
			'type':'ajax',						    
		    'helpers'   : { 
		    	   'overlay' : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox 
		    	  },
			'href':'<?php echo $this->Html->url(array('controller'=>"Billings",'action'=>"uploadCorporateExcel",'admin'=>false)) ?>'+'/'+patient_id+'?flag=reportUpload&tariffStdId='+tariffStdId,
		     helpers     : { 
		    	locked     : true, 
		        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		     }
		}); 
	});

	
	$('#reset').click(function(){
		//for resetting filtrs
 		$('#otherOutRepFrm').trigger('reset');
 		$('#from').val('');
 		$('#to').val('');
 		$('#lookup_name').val('');
	});

	$('#excel_report').click(function(){
			var tariff=$('#tariff').val();
			if(!tariff){
				alert('Please select tariff');
				$('#tariff').focus();
				return false;
			}else
				return true;
	});
	
 
</script>