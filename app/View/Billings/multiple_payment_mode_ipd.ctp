<?php 
//variables changed according to headers variable for query optimization  --yashwant  (*DO NOT REMOVE THIS*)

$tariffStandardID=$patient['Patient']['tariff_standard_id'];
$isDischarge=$patient['Patient']['is_discharge'];
$patientDischargeDate=$patient['Patient']['discharge_date'];
$personID=$patient['Patient']['person_id'];
$clearanceData = unserialize($patient['Patient']['clearance']);
$clearanceDone=$clearanceData[$patientID]['clearance_done'];
$patientType = $patient['Person']['vip_chk'];

echo $this->Html->script(array('inline_msg','permission','jquery.blockUI','jquery.fancybox'));
echo $this->Html->css(array('jquery.fancybox'));
// added by atul for restrict print on page refresh 
$referral = $this->request->referer();
echo $this->Form->hidden('formReferral',array('value'=>'','id'=>'formReferral'));
/*
 #adminSearch{
	padding-right: 200px !important;
}
 */
if(Configure::read('singlePay')=='1'){
	$finalPayAction='full_payment';
}else{
	$finalPayAction='multiplePaymentModeIpd';
}
?>

<style>
label {
    color: #000 !important;
    float: none !important;
    font-size: 13px;
    margin-right: 10px;
    padding-top: 7px;
    text-align: right;
    width: none !important;
    cursor: pointer;
    vertical-align: super !important;
}
 
#msg{
 	 background:#d7c487;
	 padding:7px 5px;
	 border:1px solid #e8d495;
	 font-size:13px;  
	 color:#8c0000;
	 font-weight:bold;
	 text-shadow:1px 1px 1px #ecdca8;
	 margin: 5px 0;
	 display:block;
	 left: 40%;
     margin: 0 auto;
     padding: 5px 10px 5px 18px;
     position: absolute;
     top: 0;
     z-index: 2000;
}


.preLink{
	color:indigo !important;
}

.cursor{
	cursor: pointer;
}

#finalPayHtml{
	width:850px;
	background-color:#FFFFC4;

}

/*.billInfo tr:nth-child(2n+1)*/
 .rowOdd{
	 background: #b6f8de none repeat scroll 0 0 !important;
}

/*.billInfo tr:nth-child(2n)*/
.rowEven {
    background: #ffffc4 none repeat scroll 0 0 !important;
}
.billPrepareInput{width: 200px !important;}
.badge-success {
    color: #fff;
    background-color: #28a745;
}

.badge {
    display: inline-block;
    padding: .25em .4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
</style>
<?php /***--changing class of background because it is not required in IPD--***/
/*if(strtolower($patient['Patient']['admission_type'])=='ipd'){?>
<style>
.paid_payment{
	background: none repeat scroll 0 0 #ddd !important;
}
.pending_payment{
	background: none repeat scroll 0 0 #ddd !important;
}
</style>
<?php }*/?>

<?php  // echo $this->Html->script(array('jquery.fancybox-1.3.4'));  
		//echo $this->Html->script(array('permission','jquery.ui.timepicker','jquery.blockUI'));
		//echo $this->Html->css(array('jquery.fancybox-1.3.4')) ;
		
 


		$billableCondition = (isset($packageInstallment)) ?  'is_billable=1' : '';
		$splitDate = explode(' ',$patient['Patient']['form_received_on']);?>
		<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">-->
  <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>-->
  <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>-->
  <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>-->
<script>
//var errorMsg='The master for tariff of the TPA/Corporate is not updated. You will not be able to complete the process.';
var errorMsg='Charges for this service are not updated in master.';
var errorDiscountMsg='Discount can not be greater than Amount Paid.';
var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
var explode = admissionDate.split('-');
/** Global variable to check patient is packaged -- Gaurav */
var isPackagedPatient = '<?php echo (isset($packageInstallment)) ?  true : false; ?>';
var packagedPatientId = '<?php echo $packagedPatientId;?>';
var billableCondition = '<?php echo $billableCondition; ?>';
var radioName = (isPackagedPatient) ? 'privatepackage' : 'mandatoryservices'; //gaurav
$(document).ready(function(){ 
	// following script for open IPD Print sheet after registration- AtulC
     var print="<?php echo isset($this->params->query['printIpdSheet'])?$this->params->query['printIpdSheet']:'' ?>";	
	 //var patientId="<?php echo isset($this->params->pass[0])?$this->params->pass[0]:'' ?>"; 
	 var referral = "<?php echo $referral ; ?>" ;
	 if(print  && referral != '/' && $("#formReferral").val()==''){
		$("#formReferral").val('yes') ;
		var url="<?php echo $this->Html->url(array('controller'=>'patients','action'=>'opd_patient_detail_print',$this->params->pass[0])); ?>";
	    window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready
		}	 
	
		
		//to preveny redirect on edit and delte buttons of all services 
		$(document).on('click',".billingServicesAction",function(event){ 
			    event.preventDefault();
		});

		   $('.serviceGroupData').attr('disabled',false);// do not remove this  --yashwant
		   patient_ID='<?php echo $patientID; ?>';
		   //getServiceData(patient_ID);
		   getbillreceipt(patient_ID);
		   addCalenderOnDynamicField(); //default calender field

		   /**-- default loading of radio button --**/
		   if ($("input[type='radio'][radioname="+radioName+"_radio]").length ==0) {
			   radioName ='laboratory';
		   }
		   
		   $("input[type='radio'][radioname="+radioName+"_radio]").attr('checked',true);
		   selRadio = $("input[type='radio'][radioname="+radioName+"_radio]").val()  ;//[isMandatory='yes']
		  // $('#amount').attr('readonly',true);All readonly of amount fields are removed for hospital billing... 
		   //$('#msgForServicePayment').html('Full payment is required for mandatory services.');
		   $('#payment_category').val(selRadio);
			$('#tariff_service_name').val(radioName);
		   $('#serviceGroupId').val(selRadio);
		   if(isPackagedPatient){
			   $('#privatePackageTable').show();
			   getPackageData(packagedPatientId);
			}else{
				   var websiteInstance='<?php echo $configInstance;?>';
				   var admissionType='<?php echo strtolower($patient['Patient']['admission_type']);?>';
				   $(".partialRefundRow").hide();
				   if((websiteInstance=='kanpur' && admissionType=='ipd')|| websiteInstance=='vadodara'){
					   $(".partialDiscountRow").hide();
				   }else{
					   $(".partialDiscountRow").show();
				   }
				   
		   		//$("#servicesSection").show(); // if patient is not packaged then show 'servicesSection'
		  		//$('#service_id_1').focus();pathologySection
		  		if(radioName=='laboratory'){
		  			$("#pathologySection").show();
		  			getLabData('<?php echo $patientID;?>','<?php echo $tariffStandardId ?>');
			  	}else{ 
			  		$("#servicesSection").show();//addmore not for mandatory service
		   			getServiceData('<?php echo $patientID;?>',selRadio,'mandatoryservices','default');
				}
		   }

		   /**-- EOF default loading radio button --**/


		   
		   //autocomplete for service sub group 
		   var selectedGroup = '1';
		   $(document).on('focus','.service-sub-group', function() {
				currentID=$(this).attr('id');
			 	ID=currentID.slice(-1);
				 $("#add-service-sub-group"+ID).autocomplete({
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

			 $(document).on('focus','.service_id', function() {
				currentID=$(this).attr('id');
				splitedVar=currentID.split('_');
			 	ID=splitedVar[2]; 
			 	selectedGroup=$('#payment_category').val();
			 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
			 	var tariffStandardID = '<?php echo $tariffStandardID ?>';
				$("#service_id_"+ID).autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
					 minLength: 1,
					 select: function( event, ui ) {					 
						$('#onlyServiceId_'+ID).val(ui.item.id);
						var id = ui.item.id; 
						var charges=ui.item.charges;
						if(charges == '0'){
							charges ='';
						}
						if(charges !== undefined && charges !== null && charges !== ''){
							$('#service_amount_'+ID).val(charges.trim());
							if(ui.item.fix_discount !== undefined && ui.item.fix_discount !== null && ui.item.fix_discount !== ''){
								$('#fix_discount_'+ID).val(ui.item.fix_discount);
							}
							$('#amount_'+ID).html(charges.trim());
						}else{
							$('#service_amount_'+ID).val('');
							$('#amount_'+ID).html('');
							$('#fix_discount_'+ID).val('');
							inlineMsg(currentID,errorMsg,10);
						}
						//serviceSubGroups(this);
					 },
					 messages: {
					        noResults: '',
					        results: function() {}
					 }
				});
			});
	//making amount fields readonly in all groups
	var websiteInstance='<?php echo $configInstance;?>';			
	if(websiteInstance=='kanpur'){
		$('.kanpurAmount').attr('readonly',true);
	} 


	///
	/* var currentTariffID='<?php //echo $patient['Patient']['tariff_standard_id'];?>';
	 var privateID='<?php //echo $privatepatientID;?>';
	//alert(currentTariffID);
	//alert(privateID);
	
	if(currentTariffID != privateID){alert('if');
		$("#mode_of_payment").val('Credit');
	}else{
		alert('else');
	}*/
	///    
});

function addCalenderOnDynamicField(){
	$(".ConsultantDate, .ServiceDate, .bloodDate, .implantDate, .wardDate, .otherServiceDate, .radiotheraphyDate").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		defaultDate: new Date(),				 
		dateFormat:'dd/mm/yy HH:II:SS',
		minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
		maxDate : new Date(),
	}); 

	$('.wardQty').on('keyup',function(){
    	currentID = $(this).attr('id') ; 
    	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
		serviceAmt=$('#wardAmount_'+ID).val(); 
    	valtimes = $(this).val(); 
    	if(isNaN(valtimes)==false && valtimes!=0){ 
			if(serviceAmt !=''){
		    	totalAmt=serviceAmt*valtimes;
		    	$('#wardTotalAmount_'+ID).html(totalAmt);
			}else{
				alert('Please enter Unit price.');
				$('#wardAmount_'+ID).val(''); 
				$(this).val('');
				return false;
			}
    	}else{
    		alert('Please enter valid data.');
			$(this).val('');
			return false;
        }
  	});


	$('.wardAmount').on('keyup',function(){
      	currentID = $(this).attr('id') ; 
      	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
  		noOfTime=$('#wardQty_'+ID).val(); 
      	valprice = $(this).val(); 
      	if(isNaN(valprice)==false){ 
	  		if(noOfTime !=''){
	  	    	totalAmt=noOfTime*valprice;
	  	    	$('#wardTotalAmount_'+ID).html(totalAmt);
	  		}
      	}else{
    		alert('Please enter valid amount.');
    		$(this).val('');
			return false;
        }
    });
    

	$('.implantQty').on('keyup',function(){
    	currentID = $(this).attr('id') ; 
    	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
    	
		serviceAmt=$('#implantAmount_'+ID).val(); 
    	valtimes = $(this).val(); 
    	if(isNaN(valtimes)==false && valtimes!=0){ 
			if(serviceAmt !=''){
		    	totalAmt=serviceAmt*valtimes;
		    	$('#implantTotalAmount_'+ID).html(totalAmt);
			}else{
				alert('Please enter Unit price.');
				$('#implantAmount_'+ID).val(''); 
				$(this).val('');
				return false;
			}
    	}else{
    		alert('Please enter valid data.');
			$(this).val('');
			return false;
        }
  	});


	$('.implantAmount').on('keyup',function(){
      	currentID = $(this).attr('id') ; 
      	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
      	
  		noOfTime=$('#implantQty_'+ID).val(); 
      	valprice = $(this).val(); 
      	if(isNaN(valprice)==false){ 
	  		if(noOfTime !=''){
	  	    	totalAmt=noOfTime*valprice;
	  	    	$('#implantTotalAmount_'+ID).html(totalAmt);
	  		}
      	}else{
    		alert('Please enter valid amount.');
    		$(this).val('');
			return false;
        }
    });

	$('.radiotheraphyQty').on('keyup',function(){
    	currentID = $(this).attr('id') ; 
    	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
    	
		serviceAmt=$('#radiotheraphyAmount_'+ID).val(); 
    	valtimes = $(this).val(); 
    	if(isNaN(valtimes)==false && valtimes!=0){ 
			if(serviceAmt !=''){
		    	totalAmt=serviceAmt*valtimes;
		    	$('#radiotheraphyTotalAmount_'+ID).html(totalAmt);
			}else{
				alert('Please enter Unit price.');
				$('#radiotheraphyAmount_'+ID).val(''); 
				$(this).val('');
				return false;
			}
    	}else{
    		alert('Please enter valid data.');
			$(this).val('');
			return false;
        }
  	});


	$('.radiotheraphyAmount').on('keyup',function(){
      	currentID = $(this).attr('id') ; 
      	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
      	
  		noOfTime=$('#radiotheraphyQty_'+ID).val(); 
      	valprice = $(this).val(); 
      	if(isNaN(valprice)==false){ 
	  		if(noOfTime !=''){
	  	    	totalAmt=noOfTime*valprice;
	  	    	$('#radiotheraphyTotalAmount_'+ID).html(totalAmt);
	  		}
      	}else{
    		alert('Please enter valid amount.');
    		$(this).val('');
			return false;
        }
    });

	$('.bloodQty').on('keyup',function(){
    	currentID = $(this).attr('id') ; 
    	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
    	
		serviceAmt=$('#bloodAmount_'+ID).val(); 
    	valtimes = $(this).val(); 
    	if(isNaN(valtimes)==false && valtimes!=0){ 
			if(serviceAmt !=''){
		    	totalAmt=serviceAmt*valtimes;
		    	$('#bloodTotalAmount_'+ID).html(totalAmt);
			}else{
				alert('Please enter Unit price.');
				$('#bloodAmount_'+ID).val(''); 
				$(this).val('');
				return false;
			}
    	}else{
    		alert('Please enter valid data.');
			$(this).val('');
			return false;
        }
  	});


	$('.bloodAmount').on('keyup',function(){
      	currentID = $(this).attr('id') ; 
      	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
      	
  		noOfTime=$('#bloodQty_'+ID).val(); 
      	valprice = $(this).val(); 
      	if(isNaN(valprice)==false){ 
	  		if(noOfTime !=''){
	  	    	totalAmt=noOfTime*valprice;
	  	    	$('#bloodTotalAmount_'+ID).html(totalAmt);
	  		}
      	}else{
    		alert('Please enter valid amount.');
    		$(this).val('');
			return false;
        }
    });


	$('.otherServiceQty').on('keyup',function(){
    	currentID = $(this).attr('id') ; 
    	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
    	
		serviceAmt=$('#otherServiceAmount_'+ID).val(); 
    	valtimes = $(this).val(); 
    	if(isNaN(valtimes)==false && valtimes!=0){ 
			if(serviceAmt !=''){
		    	totalAmt=serviceAmt*valtimes;
		    	$('#otherServiceTotalAmount_'+ID).html(totalAmt);
			}else{
				alert('Please enter Unit price.');
				$('#otherServiceAmount_'+ID).val(''); 
				$(this).val('');
				return false;
			}
    	}else{
    		alert('Please enter valid data.');
			$(this).val('');
			return false;
        }
  	});


	$('.otherServiceAmount').on('keyup',function(){
      	currentID = $(this).attr('id') ; 
      	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
      	
  		noOfTime=$('#otherServiceQty_'+ID).val(); 
      	valprice = $(this).val(); 
      	if(isNaN(valprice)==false){ 
	  		if(noOfTime !=''){
	  	    	totalAmt=noOfTime*valprice;
	  	    	$('#otherServiceTotalAmount_'+ID).html(totalAmt);
	  		}
      	}else{
    		alert('Please enter valid amount.');
    		$(this).val('');
			return false;
        }
    });
    
  	
	$('.nofTime').on('keyup',function(){
    	currentID = $(this).attr('id') ; 
    	splitedVar = currentID.split('_');
    	ID=splitedVar[3]; 
    	
		serviceAmt=$('#service_amount_'+ID).val(); 
    	valtimes = $(this).val(); 
    	if(isNaN(valtimes)==false && valtimes!=0){ 
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
      	currentID = $(this).attr('id') ; 
      	splitedVar = currentID.split('_');
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

  $(".totalSertviceQty").on('keyup',function(){
		 var totalCServiceCharge=0;
		 var totalCServiceQty=0;
		 $(".clinicalServiceAmount").each(function () {
			var currentID=$(this).attr('id');
			var splitedVar=currentID.split('_');
			ID=splitedVar[2];
			 var currentAmount=($("#service_amount_"+ID).val()=='')?'0':$("#service_amount_"+ID).val();
			 var currentQty=($("#no_of_times_"+ID).val()=='')?'0':$("#no_of_times_"+ID).val();
			 totalCServiceCharge=parseInt(totalCServiceCharge)+parseInt(currentAmount)*parseInt(currentQty);
		 });
		 $('#totalCServiceAmount').html('Total :'+totalCServiceCharge);
	 });

  $(".otherServiceQty").on('keyup',function(){
		 var totalOtherServiceCharge=0;
		 var totalOtherServiceQty=0;
		 $(".otherServiceAmount").each(function () {
			var currentID=$(this).attr('id');
			var splitedVar=currentID.split('_');
			ID=splitedVar[1];
			 var currentAmount=($("#otherServiceAmount_"+ID).val()=='')?'0':$("#otherServiceAmount_"+ID).val();
			 var currentQty=($("#otherServiceQty_"+ID).val()=='')?'0':$("#otherServiceQty_"+ID).val();
			 totalOtherServiceCharge=parseInt(totalOtherServiceCharge)+parseInt(currentAmount)*parseInt(currentQty);
		 });
		 $('#totalOtherServiceAmount').html('Total :'+totalOtherServiceCharge);
	 });

  $(".radiotheraphyQty").on('keyup',function(){
		 var totalRadiotheraphyCharge=0;
		 var totalRadiotheraphyQty=0;
		 $(".radiotheraphyQty").each(function () {
			var currentID=$(this).attr('id');
			var splitedVar=currentID.split('_');
			ID=splitedVar[1];
			 var currentAmount=($("#radiotheraphyAmount_"+ID).val()=='')?'0':$("#radiotheraphyAmount_"+ID).val();
			 var currentQty=($("#radiotheraphyQty_"+ID).val()=='')?'0':$("#radiotheraphyQty_"+ID).val();
			 totalRadiotheraphyCharge=parseInt(totalRadiotheraphyCharge)+parseInt(currentAmount)*parseInt(currentQty);
		 });
		 $('#totalRadiotheraphyAmount').html('Total :'+totalRadiotheraphyCharge);
	 });
}
 
</script>
<?php 
	$flashMsg = $this->Session->flash('still') ;
	if(!empty($flashMsg)){ ?>
	<div>
		<?php echo $flashMsg ;?>
	</div> 
<?php } //debug($patient);?>

<div class="inner_title" style="height: 40px">
 <table width="100%">
	 <tr>
	 	<?php 
	 	if($patient['Patient']['is_discharge']=='1'){
	 		if(strtolower($patient['Patient']['admission_type'])=='ipd'){
	 			$dischaged= " - <font color='red'><b><i>(Discharged)</i></b></font>";
	 		}else{
	 			$dischaged= " - <font color='red'><b><i>(Visit Closed)</i></b></font>";
	 		}
	 	}else{
	 		$dischaged= "";
	 	}?>
	 	
	 	<td width="45%">
	 		<h3>&nbsp; <?php  echo __('Billing - <font color="#1A35D5">' .$patient['Patient']['lookup_name'].' '.$patient['Patient']['patient_id'].' ('.$patient['TariffStandard']['name'].')</font>'.' '.$couponPatient.$dischaged, true); ?>
	 			
	 			 <?php if($patient['Person']['vip_chk']=='1'){
				echo $this->Html->image("vip.png", array("alt" => "VIP", "title" => "VIP"));
				}?>
	 		</h3>
	 	</td>
	 	
		<td><?php //echo $this->element('card_balance');?></td>
	  
	 	<td><?php echo $this->Form->hidden('totalCharge',array('id'=>'totalCharge'));
				  echo $this->Form->hidden('totalPaid',array('id'=>'totalPaid')); 
				  echo $this->element('admission_search');?> 
		</td>
	 
		<td><?php //commented -- as patient card is not used in hope -- pooja
		//if($configInstance!='kanpur')echo $this->Html->link(__('View Patient Card'),'javascript:void(0)',array('escape'=>false,'class'=>'blueBtn','id'=>'fancyCard'));?></td>
	 	<td><?php echo $this->Html->link('Discount/Refund',array('action'=>'discount_only',$patient['Patient']['id']),array('escape'=>false,'class'=>'blueBtn'));?></td>
	 <td>
	      <!-- Show Button (Pure HTML) -->
    <button id="showBtn" class ='blueBtn' onclick="document.getElementById('invoiceBtn').style.display='inline-block'; document.getElementById('hideBtn').style.display='inline-block'; this.style.display='none';">Show </button>
    <!-- Hide Button (Pure HTML) -->
    <button id="hideBtn" class ='blueBtn' style="display:none;" onclick="document.getElementById('invoiceBtn').style.display='none'; this.style.display='none'; document.getElementById('showBtn').style.display='inline-block';">Hide</button>
	 </td>
	 	<?php if($this->Session->read('website.instance')=='hope') { ?>
                <td  align="left" ><?php 
                $pharConfig=unserialize($configPharmData['Configuration']['value']);
				 	if($this->params->query['showPhar']){
                		$pharConfig['addChargesInInvoice']='yes';
               		}
					if($pharConfig['addChargesInInvoice']=='yes'){
						$buttonLabel="Hide Pharmacy Charge";
						$link =array("controller" => 'Billings',"action" => "multiplePaymentModeIpd",$patient['Patient']['id'], "admin" => false);
					}else{
						$buttonLabel="Show Pharmacy Charge";
						$link = array("controller" => 'Billings',"action" => "multiplePaymentModeIpd",$patient['Patient']['id'],'?'=>array('showPhar'=>'1'), "admin" => false);
						
					}
					
					if($patient['Patient']['is_discharge']=='1' && $patient['Patient']['tariff_standard_id']!=$privatepatientID){
		            	echo $this->Html->Link($buttonLabel,$link,array('style'=>'','type'=>'button','class'=>'blueBtn','div'=>false,'error'=>false,'id'=>'showPharm'));
		            }else if($patient['Patient']['is_discharge']=='0'){
						echo $this->Html->Link($buttonLabel,$link,array('style'=>'','type'=>'button','class'=>'blueBtn','div'=>false,'error'=>false,'id'=>'showPharm'));
					}
		            ?>
		      </td>
	<?php }?>
	
	 </tr>
<!--	 <tr>-->
<!--    <td>-->
        <!-- Status Light Image -->
<!--        <div id="status-light" style="width: 20px; height: 20px; border-radius: 50%; background-color: gray; border: 1px solid #ccc;">-->
<!--        </div>-->
<!--    </td>-->
<!--</tr>-->
 </table>
</div>

<!-- BOF for previour encounter list -->

<table>
	<?php $count = count($encounterId);
//claim date condition added -- pooja
if($count>1 || $expectedAmount['FinalBilling']['dr_claim_date']){
?>
	<tr style="background-color: #DDDDDD;">
		<td colspan="<?php echo $count;?>"><strong>Encounters Of Patient :</strong></td>
		<?php /* if($expectedAmount['FinalBilling']['dr_claim_date']){ ?>
		<td><strong><?php 
			$billDateSub=$this->DateFormat->formatDate2Local($expectedAmount['FinalBilling']['dr_claim_date'],Configure::read('date_format'),true);
			$billPrepared =$this->DateFormat->formatDate2Local($expectedAmount['FinalBilling']['bill_uploading_date'],Configure::read('date_format'),true);
			echo 'Bill Prepared On : <font color="red" style=font-weight:bold;>'.$billPrepared.'</font> Bill Submitted On : <font color="red" style=font-weight:bold;>'.$billDateSub.'</font> Expected Amount : <font color="red" style=font-weight:bold;>Rs . '.$expectedAmount['FinalBilling']['expected_amount'].'</font>'?></strong></td>
			<td><?php echo $this->Html->link($this->Html->image('icons/download-excel.png',array('title'=>'GenerateExcel')),array("controller" =>'Corporates',"action" => "getExcel",$patient['Patient']['id'],"admin" => false),array('id'=>'corpExcel','escape' => false));?></td>
			<?php } */ ?>
	</tr>
	<tr style="background-color: #DDDDDD;">
		<?php $regDate=explode(' ',$regDate);
			foreach($encounterId as $encounterId){ 
		//for($p=0;$p<=$count-1;){
			$date=$this->DateFormat->formatDate2Local($encounterId['Patient']['form_received_on'],Configure::read('date_format'),false);
			if($date==$regDate['0'])continue;?>
		<td><?php $class='';
		 if($encounterId['Patient']['id']==$this->params->pass[0]){
			$class='preLink';
		 }
			echo $this->Html->link($date,array('controller'=>'Billings','action'=>'multiplePaymentModeIpd',$encounterId['Patient']['id'],'#'=>'serviceOptionDiv','?'=>array('apptId'=>$encounterId['Appointment']['id'])),
					array('class'=>"link $class",'style'=>$style,'id'=>'previousEncounter_'.$encounterId['Patient']['id'],'escape' => false,'label'=>false,'div'=>false));?>
		</td>
		<?php  }//$p++;}?> 

	</tr>
	<?php }?>
	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'checkbox','id'=>'duplicateSalesAllow','checked'=>$use_duplicate_sales=='1'?'checked':'','label'=>'Use edited Pharmacy Sales','div'=>false)); ?></td>
		<?php if(Configure::read('Coupon') and $patient['Patient']['coupon_name']==''){
				if($patient['Patient']['tariff_standard_id']==$getTariffRgjayId or true){?>
				<td><?php echo $this->Form->input('Patient.is_coupon', array('label'=>false,'type'=>'checkbox','class' => 'is_coupon','id' => 'is_coupon',
                    'label'=>'Apply Coupon','hiddenField'=>false,'div'=>false,'style'=>'')); ?></td>
        		<td><?php echo  $this->Form->input('Patient.coupon', array('label'=>false,'autocomplete' => 'off','style'=>'float:left;display:none;','div'=>false,'class' => 'coupon','id' => 'coupon_name')); ?></td>
        		<td id="validcoupon" style='float:left; color:green;'></td>
        		<td id='subButton' style='display:none; float:left;'>
            		<?php echo $this->Html->image('icons/saveSmall.png',array('title'=>'Save Coupon','class'=>'saveCoupon','style'=>'display:'.$grey,
                        'id'=>'grey_'.$patients['Patient']['id'])); ?>
        		</td>  
		<?php }
			}?>
	</tr>
</table>
<?php ?>
<div></div>
<?php if($patient['Patient']['tariff_standard_id'] != 7  /*&& empty($expectedAmount['FinalBilling']['dr_claim_date'])*/){ //not equal to 

 ?>
	<table id="expected-amount-area">
		<?php if($patient['Patient']['is_discharge'] != 1 ){ ?>
		<tr>
			<td >
				<strong><u>NOC Tracking</u></strong>
			</td>
		</tr>
		<tr>
			<td width="20%">
				<strong>05 Days Reminder SMS : <br></strong> <?php echo $this->Form->input(null,array('type'=>'select','empty'=>'Please Select','options'=>array('Sent'=>'Sent','Not Sent'=>'Not Sent'),'label'=>false,'div'=>false,'id'=>'fiveDayReminder','class'=>'textBoxExpnd billPrepareInput','value'=>$patient['Patient']['five_day_reminder'])) ?>
			</td>

			<td>
				<strong>NOC Taken : <br></strong> <?php echo $this->Form->input(null,array('type'=>'select','empty'=>'Please Select','options'=>array('Yes'=>'Yes','No'=>'No'),'label'=>false,'div'=>false,'id'=>'fiveDayNocTaken','class'=>'textBoxExpnd billPrepareInput','value'=>$patient['Patient']['five_day_noc_taken'])) ?>
			</td>


			<td>
				<strong>12 Days Reminder SMS :<br> </strong><?php echo $this->Form->input(null,array('type'=>'select','empty'=>'Please Select','options'=>array('Sent'=>'Sent','Not Sent'=>'Not Sent'),'label'=>false,'div'=>false,'id'=>'twelveDayReminder','class'=>'textBoxExpnd billPrepareInput','value'=>$patient['Patient']['twelve_day_reminder'])) ?>
			</td>

			<td>
				<strong>NOC Taken : <br></strong> <?php echo $this->Form->input(null,array('type'=>'select','empty'=>'Please Select','options'=>array('Yes'=>'Yes','No'=>'No'),'label'=>false,'div'=>false,'id'=>'tweleveDayNocTaken','class'=>'textBoxExpnd billPrepareInput','value'=>$patient['Patient']['twelve_day_noc_taken'])) ?>
			</td>

			<td><?php echo $this->Form->input('Save NOC details', array( 'label'=>false,'type'=>'text', 'id' => 'save-noc-detail' ,
			    					'div'=>false,'type'=>'button' )); ?></td>
		</tr>
		<?php }else{ ?>
		<tr>
			<td>
				<strong><u>Bill Preparation</u></strong>
			</td>
		</tr>

	    <tr>

	    	<?php //if(empty($expectedAmount['FinalBilling']['dr_claim_date'])){ ?>
	    		<td>
		    		<?php $uploadDate=$this->DateFormat->formatDate2Local($expectedAmount['FinalBilling']['bill_uploading_date'],Configure::read('date_format'),true); ?>
		    		<strong>Date Of Bill Preparation : <br></strong>
	    			<?php echo $this->Form->input(null, array('placeholder'=>'Bill Prepared Date','value'=>$uploadDate,'class'=>'lab_order_date textBoxExpnd billPrepareInput',
	    				'label'=>false,'type'=>'text', 'id' => 'bill_uploading_date' ,'div'=>false,'style'=>'float:left;'));?>
    			</td>
    			<td>
	        		<strong>Bill Amount : <br></strong>
    				<?php echo $this->Form->input(null, array('placeholder'=>'Bill Amount','label'=>false,'type'=>'text', 'id' => 'bill-amount' ,'div'=>false,'class'=>'textBoxExpnd billPrepareInput','value'=>$expectedAmount['FinalBilling']['hospital_invoice_amount']));?>
    			</td>
	        	<td>
	        		<strong>Expected Amount : <br></strong>
    				<?php echo $this->Form->input(null, array('placeholder'=>'Expected Amount','value'=>$expectedAmount['FinalBilling']['expected_amount'],'label'=>false,'type'=>'text', 'id' => 'expected-amount' ,'div'=>false,'class'=>'textBoxExpnd billPrepareInput'));?>
    			</td>
    			
    			<td>
	        		<strong>Billing Executive : <br></strong>
    				<?php echo $this->Form->input(null, array('type'=>'select','empty'=>'Please Select','options'=>$userList, 'id' => 'billing-executive','value'=>$expectedAmount['FinalBilling']['bill_prepared_by'],'label'=>false,'div'=>false,'class'=>'textBoxExpnd billPrepareInput'));?>
    			</td>

    			<td width="20%">
				<strong>Reason For Delay :<br></strong> <?php echo $this->Form->textarea(null,array('label'=>false,'div'=>false,'id'=>'reasonForDelay','class'=>'billPrepareInput','value'=>$expectedAmount['FinalBilling']['reason_for_delay'],'placeholder'=>'Do not add Single,Double quotes or slash')) ?>
			</td>
    			
	        <?php //} ?>

	    	<td>
		    	<?php  //if bill is submitted then o futher edit is allowed
 					//if(empty($expectedAmount['FinalBilling']['dr_claim_date'])){
			    		/*if(!empty($expectedAmount['FinalBilling']['is_bill_finalize']) && strtolower($this->Session->read('role'))=='admin' ){
			    			echo $this->Form->input('Revoke Prepared Bill', array( 'label'=>false,'type'=>'text', 'id' => 'revoke-for-submission' ,
			    					'div'=>false,'style'=>'float:right;','type'=>'button' ,'value'=>'Ready for Submission'));
			    		}else{*/
			    			echo $this->Form->input('Bill prepared', array( 'label'=>false, 'id' => 'ready-for-submission' ,
			    					'div'=>false,'type'=>'button' ,'value'=>'Ready for Submission'));
			    		//} 
		    		//}
		    	?>
	        </td>	  
	 	</tr>

	 	

	 	<tr>
			<td colspan="5">
				<strong><u>NMI Tracking</u></strong>
			</td>
		</tr>
		<tr>
			<?php $nmiDate =$this->DateFormat->formatDate2Local($expectedAmount['FinalBilling']['nmi_date'],Configure::read('date_format'),true); ?>
			<td>
				<strong>NMI Date : <br></strong><?php echo $this->Form->input(null,array('type'=>'text','label'=>false,'div'=>false,'id'=>'nmiDate','class'=>'textBoxExpnd lab_order_date billPrepareInput','value'=>$nmiDate)) ?>
			</td>

			<td width="20%">
				<strong>NMI :<br></strong> <?php echo $this->Form->textarea(null,array('label'=>false,'div'=>false,'id'=>'nmi','class'=>'billPrepareInput','value'=>$expectedAmount['FinalBilling']['nmi'],'placeholder'=>'Do not add Single,Double quotes or slash')) ?>
			</td>

			<td>
				<strong>NMI Answered :<br></strong> <?php echo $this->Form->input(null,array('type'=>'select','empty'=>'Please Select','options'=>array('Yes'=>'Yes','No'=>'No'),'label'=>false,'div'=>false,'id'=>'nmiAns','class'=>'textBoxExpnd billPrepareInput','value'=>$expectedAmount['FinalBilling']['nmi_answered'])) ?>
			</td>
			<td><?php echo $this->Form->input('Save NMI details', array( 'label'=>false, 'id' => 'save-nmi-detail' ,'div'=>false,'type'=>'button' )); ?></td>

		</tr>

		


	 	<!-- <td><?php echo $this->Html->link($this->Html->image('icons/download-excel.png',array('title'=>'GenerateExcel')),array("controller" =>'Corporates',"action" => "getExcel",$patient['Patient']['id'],/*$val['TariffStandard']['name'],*/"admin" => false),array('id'=>'corpExcel','escape' => false,'style'=>"display:$display"));?></td> -->
	 	
	 	<?php //Excel for specific corporate
	        	if(!empty($expectedAmount['FinalBilling']['is_bill_finalize'])){
						$display='table-cell';
				}else{
						$display='none';
				}
		?>

	 	<?php // new section to add when the bill was submitted-- pooja
	 	//if(empty($expectedAmount['FinalBilling']['dr_claim_date'])){?>

 		<tr>
			<td colspan="5" class="bill_submit" style="display:<?php echo $display; ?>;">
				<strong><u>Bill Submission</u></strong>
			</td>
		</tr>

		<tr>

			<?php $billSubmitDate =$this->DateFormat->formatDate2Local($expectedAmount['FinalBilling']['dr_claim_date'],Configure::read('date_format'),true); ?>

			<td class="bill_submit" style="display:<?php echo $display; ?>;" >
				<strong>Date Of Submission : <br></strong> <?php echo $this->Form->input('bill_submitted_on',array('class'=>'lab_order_date textBoxExpnd billPrepareInput','label'=>false,'div'=>false,'style'=>"float:left; display:$display",'value'=>$billSubmitDate));?>
			</td>

			<td class="bill_submit" style="display:<?php echo $display; ?>;">
				<strong>Executive Who Submitted  :<br> </strong><?php echo $this->Form->input(null, array('type'=>'select','empty'=>'Please Select','options'=>$userList, 'id' => 'bill_submitted_by','label'=>false,'div'=>false,'class'=>'textBoxExpnd billPrepareInput','value'=>$expectedAmount['FinalBilling']['bill_submitted_by']));?>
			</td>

			<td class="bill_submit" style="display:<?php echo $display; ?>;">	 	
		 	<?php echo $this->Form->input('Bill submitted', array( 'label'=>false, 'id' => 'bill_button','div'=>false,'type'=>'button' ,'value'=>'Bill Submitted'));?></td>
		 	<?php // }?>

		</tr>
	</table>	
<?php } ?>


<?php }  ?>

<?php  echo $this->Form->create('PatientDocumentDetail',array('class'=>'upload_data','id'=>"billLinkForm",'inputDefaults'=>array('label'=>false,'div'=>false)));?>
	<table>
		<tr>
			<td>
				<strong><u>Bill Link/Referral Letter</u></strong>
			</td>
		</tr>

	    <tr>

	    		<td>
	        		<strong>Bill Link In Spreadsheet : <br></strong>
    				<?php 
    				echo $this->Form->input(null, array('type'=>'text','name'=>'data[Coprporates][billing_link]', 'id' => 'billing-link','value'=>$patient['Person']['billing_link'],'label'=>false,'div'=>false,'class'=>'textBoxExpnd billPrepareInput'));?>
    			</td>
	    		
    			
    			<td>
	        		<strong>Referral Letter:<br></strong>
    				<?php echo $this->Form->input(null, array('type'=>'file','name'=>'data[Coprporates][referral_letter]', 'id' => 'referral-letter','label'=>false,'div'=>false,'class'=>'textBoxExpnd billPrepareInput'));
    					echo $this->Form->hidden(null,array('name'=>'data[Coprporates][referral_letter_old]','value'=>$patient['Person']['referral_letter']));
    				?>
    			</td>
	    	
		    	<!-- <td><?php echo $this->Form->button('Save Bill Link', array( 'label'=>false, 'id' => 'save-bill-link' ,'div'=>false,'type'=>'button' )); ?></td> -->

		    	<td class="theads"><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../../img/icons/saveSmall.png')) ;?>
												 	</td>

			 	<?php //Pic
			 	if($patient['Person']['billing_link']){  ?>

			 	<td>
			 	<?php $replacedText = $patient['Person']['billing_link'];
				echo $this->Html->link ( 'Click Here for Link ',$replacedText, array (
						'escape' => false,
						'target' => '__blank',
						'style' => 'text-decoration:underline;' 
				) ); ?>
				</td>
				<?php } ?>

		<?php //Pic
			 	if($patient['Person']['referral_letter']){  ?>

			 	<td>
			 	<?php $replacedText = $patient['Person']['referral_letter'];
				echo $this->Html->link ( "Click here For Referral Letter", '/uploads/referral_letter/' . $patient['Person']['referral_letter'], array (
						'escape' => false,
						'target' => '__blank',
						'style' => 'text-decoration:underline;' 
				) ); ?>
				</td>
		<?php } ?>
			
	          	     <!--<td><?php echo $this->Form->button('Start Package', array( 'label'=>false, 'id' => 'save-bill-link' ,'div'=>false,'type'=>'button' )); ?></td> -->

	 	</tr>
	</table>
<?php echo $this->Form->end(); ?>
    <?php echo $this->Form->create(null, ['url' => ['action' => 'start_package']]); ?>

<table>
    <tr>
        <td>
             <?php 
                // Hidden fields for Person and Patient IDs
                echo $this->Form->hidden('Person.id', ['value' => $patient['Person']['id']]); 
                echo $this->Form->hidden('Patient.id', ['value' => $patient['Patient']['id']]);
            ?>
           <?php echo $this->Form->input('Person.package_date', [
                'type' => 'text', // Using text to apply a calendar with JavaScript
                'label' => false,
                'class' => 'form-control',
                'id' => 'next_visite_date',
                'style' => 'width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; color: #333;',
                'required' => true, // Adding required field validation
                'placeholder' => 'Please select date', // Adding placeholder
                'value' => isset($patient['Person']['package_date']) ? $patient['Person']['package_date'] : '' // Setting value from the patient data
            ]); ?>
        </td>
        <td style="text-align: center;">
            <?php echo $this->Form->button('Start Package', ['class' => 'badge badge-success']); ?>
        </td>
        <td>
        <!-- Status Light Image -->
        <div id="status-light" style="width: 20px; height: 20px; border-radius: 50%; background-color: gray; border: 1px solid #ccc;">
        </div>
    </td>
    </tr>
</table>

<script>
    $(document).ready(function() {
    // Function to check the date and update light color
    function updateLight() {
        var packageDate = '<?php echo isset($patient['Person']['package_date']) ? $patient['Person']['package_date'] : ''; ?>'; // Get the package date from PHP
        var currentDate = new Date(); // Get the current date
        var lightElement = $('#status-light'); // Get the light element

        // If the package date is not empty
        if (packageDate) {
            var dateParts = packageDate.split('-'); // Assuming date format is 'YYYY-MM-DD'
            var packageDateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]); // Create Date object from package date

            // Calculate the difference in days between current date and package date
            var timeDiff = currentDate - packageDateObj;
            var daysDiff = timeDiff / (1000 * 3600 * 24); // Convert time difference to days

            // Check the condition for the light color
            if (daysDiff <= 3) {
                lightElement.css('background-color', 'green'); // Green light for 3 days or less
            } else {
                lightElement.css('background-color', 'red'); // Red light for more than 3 days
            }
        } else {
            lightElement.css('background-color', 'gray'); // Off light if no package date is set
        }
    }

    // Call the updateLight function on page load to check initial condition
    updateLight();
});

</script>

<?php echo $this->Form->end(); ?>
<!-- Include Flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateInput = document.getElementById('next_visite_date');
        
        // Flatpickr लागू करें
        flatpickr(dateInput, {
            dateFormat: "Y-m-d", // डेट का फॉर्मेट
            altInput: true,
            altFormat: "F j, Y", // वैकल्पिक रीडेबल फॉर्मेट
            allowInput: true // मैनुअली डेट टाइप करने की अनुमति
        });
    });
</script>

<!-- <table>
<tr>
			<td>
				<strong><u>Bill Link/Referral Letter</u></strong>
			</td>
		</tr>

	<tr>
		<?php //Pic
			 	if($patient['Person']['billing_link']){  ?>

			 	<td>
			 	<?php $replacedText = $patient['Person']['billing_link'];
				echo $this->Html->link ( 'Click Here for Link ',$replacedText, array (
						'escape' => false,
						'target' => '__blank',
						'style' => 'text-decoration:underline;' 
				) ); ?>
				</td>
				<?php } ?>

		<?php //Pic
			 	if($patient['Person']['referral_letter']){  ?>

			 	<td>
			 	<?php $replacedText = $patient['Person']['referral_letter'];
				echo $this->Html->link ( "Click here For Referral Letter", '/uploads/referral_letter/' . $patient['Person']['referral_letter'], array (
						'escape' => false,
						'target' => '__blank',
						'style' => 'text-decoration:underline;' 
				) ); ?>
				</td>
		<?php } ?>
	</tr>
</table> -->

<?php $CouponType = $CouponPrivilageType == 'Privilege Card' ?  "Privilege Card Patient :-" : "Coupon Patient :-"; ?> 	
<?php if(Configure::read('Coupon') and $patient['Patient']['coupon_name'] !=''/* and $patient['Patient']['admission_type']!='IPD'and  $patient['Patient']['is_discharge'] != '1' and $patient['Patient']['known_fam_physician']=='7'*/){ ?>
 <strong><?php echo $CouponType.$CouponServices; ?></strong>
 <?php }?>
<div>&nbsp;</div>
<div style="min-height:220px" id="ajaxBillReceipt"></div>

<div id="new_item">
<table style="margin-bottom: 30px;" width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		 <?php //if($isDischarge!=1){ removed -- pooja 21/09/16?>
		 	<?php if($configInstance!='vadodara' && strtolower($patient['Patient']['admission_type'])=='ipd'){?>
			<td width="20%" >
			<?php echo $this->Html->link('Advance Payment',array('controller'=>'billings','action'=>'advanceBillingPayment',$patientID),
					array('class'=> 'blueBtn advancePayment billingServicesAction','id'=>'advancePayment','escape' => false,'label'=>false,'div'=>false));?>
			<!-- <a href="javascript:void(0);" class="blueBtn advancePayment" id="advancePayment">Advance Payment</a> -->
			</td>
			<?php// }?>
			<?php $provisionalInvoiceAction = ($configInstance == 'kanpur') ? 'provisionalInvoice'  : 'printReceipt' ;
			$provisionalInvoiceActionReduce = ($configInstance == 'kanpur') ? 'provisionalInvoice'  : 'printReceiptReduce' ;?>

		
			<?php if ($patientType == 1 || $patientType == 3) { ?>
    <td width="20%">
        <?php 
            // Invoice button
            echo $this->Html->link('submit', '#', array(
                  'id' => 'invoiceBtn',
                'style' => 'display:none;',
                'class' => 'blueBtn',
                'escape' => false,
                'onclick' => "var openWin = window.open('" . $this->Html->url(array(
                    'action' => $provisionalInvoiceAction, 
                    $patientID, 
                    '?' => array('privatePackage' => $billableCondition)
                )) . "', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"
            ));
        ?>
  <?php 
            // Invoice button
            echo $this->Html->link('Invoice', '#', array(
                // 'style' => 'display:none;',
                'class' => 'blueBtn',
                'escape' => false,
                'onclick' => "var openWin = window.open('" . $this->Html->url(array(
                    'action' => $provisionalInvoiceActionReduce, 
                    $patientID, 
                    '?' => array('privatePackage' => $billableCondition)
                )) . "', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"
            ));
        ?>
        <!-- Demo1 button -->
        <?php 
            echo $this->Html->link('Corporate Bill', '#', array(
                'style' => '',
                'class' => 'blueBtn',//detail_payment
                'escape' => false,
                'onclick' => "var openWin = window.open('" . $this->Html->url(array(
                    'action' => 'corporate_bill', 
                    $patientID, 
                    '?' => array('privatePackage' => $billableCondition)
                )) . "', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); return false;"
            ));
        ?>

        <!-- Demo2 button -->
       
    </td>
<?php } ?>

			
			<?php if($configInstance=='kanpur'){?>
			<td width="20%" >
			<?php echo $this->Html->link('Summary Invoice','#',
					array('style'=>'','class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'summaryInvoice',
					$patientID))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
			</td>
			<?php }?>
			
			<?php if(strtolower($patient['Patient']['admission_type'])=='opd' ||strtolower($patient['Patient']['admission_type'])=='lab' ||strtolower($patient['Patient']['admission_type'])=='rad'){?>
			<td width="20%">
			<?php echo $this->Html->link('Total Payment',array('controller'=>'billings','action'=>$finalPayAction,$patientID),
					array('class'=> 'blueBtn singleBillPayment billingServicesAction','id'=>'payAllTotal','escape' => false,'label'=>false,'div'=>false));?>
			<!--  <input class="blueBtn singleBillPayment" type="button" value="Total Payment" id="payAllTotal">-->
			</td>
	 		<?php }?>
	 		
			<?php if(strtolower($patient['Patient']['admission_type'])=='ipd'){?>
			<td width="20%">
			<?php echo $this->Html->link('Final Payment',array('controller'=>'billings','action'=>$finalPayAction,$patientID),
					array('class'=> 'blueBtn singleBillPayment billingServicesAction','id'=>'singleBillPayment','escape' => false,'label'=>false,'div'=>false));?>
					<!-- <a href="javascript:void(0);" class="blueBtn singleBillPayment" id="singleBillPayment">Final Payment<?php //echo $text;?></a> -->
			</td>
			<?php }?>
			<?php if($patient['Patient']['admission_type']=='IPD' && !isset($packageInstallment)){ ?>
			<td width="15%"><?php echo $this->Html->link('Detailed Invoice','javascript:void(0)',
					array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'billings','action'=>'detail_payment',$patientID
					))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1050,height=670,left=150,top=100'); return false;"));
			?></td>
			<?php }?>
			<?php if($patientType == 2){ ?>
			<td width="20%"><?php echo $this->Html->link('Package Invoice','#',
                    array('disabled'=>$diabled,'class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'billings','action'=>'print_package_invoice',$patientID))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
                        
            </td>
        	<?php } ?>
			<td></td>
		<?php }else{?>
			<?php if($configInstance!='vadodara'){?>
			<td width="15%" id="advancePaymentArea">
			<?php echo $this->Html->link('Advance Payment',array('controller'=>'billings','action'=>'advanceBillingPayment',$patientID),
					array('class'=> 'blueBtn advancePayment billingServicesAction','id'=>'advancePayment','escape' => false,'label'=>false,'div'=>false));?>
					<!-- <a href="javascript:void(0);" class="blueBtn advancePayment" id="advancePayment">Advance Payment</a> -->
			</td>
			<?php }?>
			<?php $provisionalInvoiceAction = ($configInstance == 'kanpur') ? 'provisionalInvoice'  : 'printReceipt' ;?>
			<td width="15%"><?php 
				// session condition removed and new params condition is added which will patient specific -- pooja
				if($this->params->query['showPhar']){
					$url =$this->Html->url(array('action'=>$provisionalInvoiceAction,
					$patientID,'?'=>array('showPhar'=>'1')));
				}else{
					$url =$this->Html->url(array('action'=>$provisionalInvoiceAction,
					$patientID));
				}
				echo $this->Html->link('Invoice','javascript:void(0)',
					array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$url."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?></td>
			
		 <?php if($configInstance=='kanpur'){?>
			<td width="20%" >
			<?php echo $this->Html->link('Summary Invoice','#',
					array('style'=>'','class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'summaryInvoice',
					$patientID,'print'))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
			</td>
			<?php }?>
			
			<?php if(strtolower($patient['Patient']['admission_type'])=='opd'){?>
				<td width="20%">
				<?php echo $this->Html->link('Total Payment',array('controller'=>'billings','action'=>$finalPayAction,$patientID),
						array('class'=> 'blueBtn singleBillPayment billingServicesAction','id'=>'"singleBillPayment"','escape' => false,'label'=>false,'div'=>false));?>
				<!-- <a href="javascript:void(0);" class="blueBtn singleBillPayment" id="singleBillPayment">Total Payment</a> -->
				</td>
				
			<?php }else{?>
				<td width="20%">
				<?php echo $this->Html->link('Single Bill Payment',array('controller'=>'billings','action'=>$finalPayAction,$patientID),
						array('class'=> 'blueBtn singleBillPayment billingServicesAction','id'=>'"singleBillPayment"','escape' => false,'label'=>false,'div'=>false));?>
				<!-- <a href="javascript:void(0);" class="blueBtn singleBillPayment" id="singleBillPayment">Single Bill Payment</a> -->
				</td>
			<?php } 
			 
			
			$dischargeDateMax=date("d/m/Y H:m:s",strtotime($patientDischargeDate.' +24 hours'));
			if($patient['Patient']['admission_type']=='IPD'){//for ipd patient revoke discharge is for only two days  --yashwant
				$currDateForIPD=date("d/m/Y H:m:s");
				if($configInstance != 'hope'){
					if($dischargeDateMax >= $currDateForIPD){//revoke discharge is only for one day --yashwant?>
						<td width="20%"><?php echo $this->Html->link('Revoke Discharge',array('controller'=>'billings','action'=>'revokeDischarge',$patientID),array('class'=> 'blueBtn','id'=>'revoke','escape' => false,'label'=>false,'div'=>false));?></td>
			<?php 	}
				}else{
						//if($patient['Patient']['tariff_standard_id']==$privatepatientID){
				if(($expectedAmount['FinalBilling']['is_bill_finalize'] !='1') && strtolower($this->Session->read('role'))=='admin'){?>
					<td width="20%"><?php echo $this->Html->link('Revoke Discharge',array('controller'=>'billings','action'=>'revokeDischarge',$patientID),array('class'=> 'blueBtn','id'=>'revoke','escape' => false,'label'=>false,'div'=>false));?></td>
		<?php 	}
			  }
			}else{
				$patientDischargeDate=$this->DateFormat->formatDate2Local($patientDischargeDate,Configure::read('date_format'),false);
				$currDateOPD=date("d/m/Y");
				if($configInstance != 'hope'){
					if($patientDischargeDate==$currDateOPD){ ?>
					<td width="15%"><?php echo $this->Html->link('Continue Visit',array('controller'=>'billings','action'=>'continueVisit',$patientID),array('class'=> 'blueBtn','id'=>'continueVisit','escape' => false,'label'=>false,'div'=>false));?></td>
			<?php 	}
				}else{
					if($patient['Patient']['tariff_standard_id']==$privatepatientID){?>
					<td width="15%"><?php echo $this->Html->link('Continue Visit',array('controller'=>'billings','action'=>'continueVisit',$patientID),array('class'=> 'blueBtn','id'=>'continueVisit','escape' => false,'label'=>false,'div'=>false));?></td>
		  <?php     }
				}
			}?>
			  
			<?php if($patient['Patient']['admission_type']=='IPD' && !isset($packageInstallment)){ ?>
			<td width="15%"><?php 
			if($this->params->query['showPhar']){
					$durl =$this->Html->url(array('action'=>'detail_payment',
					$patientID,'?'=>array('showPhar'=>'1')));
				}else{
					$durl =$this->Html->url(array('action'=>'detail_payment',
					$patientID));
				}
			echo $this->Html->link('Detailed Invoice','javascript:void(0)',
					array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$durl."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1050,height=670,left=150,top=100'); return false;"));
			?></td>
			<?php }?>
			<td></td>
		<?php }?>
	</tr>
</table>
</div>
<?php if($configInstance=='vadodara'){?>
<div style="width: 20%">
<?php echo $this->Form->input('allDoctorList',array('type'=>'select','options'=>$allDoctorList,'empty'=>'Please Select Doctor',
	'id'=>'allDoctorList','label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd allDoctorList'));?>
</div>
<?php }?>
<!-- date section start here -->
		<?php ?>
<table width="100%" align="right" cellpadding="0" cellspacing="0" border="0" id="serviceOptionDiv">
	<tr>
		<td > 
				
		<?php  $configPharmacyData=unserialize($configPharmData['Configuration']['value']);
				foreach($service_group as $key =>$value){
					$serviceGroupData = array()  ;
					$radioName = str_replace(" ", '',strtolower($value['ServiceCategory']['name'])) ;
					/** condition for non packaged patient ( hiding private package head) */
					if(!isset($packageInstallment) && $radioName == 'privatepackage') continue;
					$serviceGroupData[$value['ServiceCategory']['id']]= $value['ServiceCategory']['alias'] ?ucfirst(strtolower($value['ServiceCategory']['alias'])):ucfirst(strtolower($value['ServiceCategory']['name']));
					if($value['ServiceCategory']['location_id']==0){
						$checked = 'checked' ;
						$isMandatory = 'yes' ;
					}else{
						$checked = '' ;
						$isMandatory = 'no' ;
					}
					if($radioName!='pharmacy'){
						if($radioName=='otpharmacy' && $configInstance=='vadodara'){
							continue;//for vadodara OT Pharmacy radio button will not appear  --yashwant 
						}else{
							echo $this->Form->input('', array('isMandatory'=>$isMandatory,'checked'=>$checked,'autocomplete'=>'off','radioName'=>$radioName."_radio",
							'name'=>'serviceGroupData','options' => $serviceGroupData,'legend' =>false,'label' => true,
							'div'=>false,'class'=>'cursor serviceGroupData add-service-group-id','type' => 'radio','separator'=>' ','disabled'=>'disabled'));
						}
					}else{
						if(strtolower($configPharmacyData['cashCounter'])=='no'){
							echo $this->Form->input('', array('isMandatory'=>$isMandatory,'checked'=>$checked,'autocomplete'=>'off','radioName'=>$radioName."_radio",
								'name'=>'serviceGroupData','options' => $serviceGroupData,'legend' =>false,'label' => true,
								'div'=>false,'class'=>'cursor serviceGroupData add-service-group-id','type' => 'radio','separator'=>' ','disabled'=>'disabled'));
						}
					}
				}  
		?>
        </td>
        
		<td>&nbsp;</td>
		<td class="tdLabel"><!-- Date --></td>
		<td width="140"><?php //echo date('d/m/Y')?></td>
		<td width="25" align="right"></td>
	</tr>
</table>

<?php ///}?>
  	
				
<!--  pathology section start-->
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="pathologySection" style="display: none; width: 100%">				

<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'addLab','type' => 'file','id'=>'labServices','inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)
));
?>				

<table class="tabularForm" style="clear:both ; width:100% " cellspacing="1" id="labOrderArea">
	<tbody>
		<tr class="row_title">
			<?php if(isset($packageInstallment)){?>
			<th class="table_cell" width="105"><strong><?php echo __('Billable Service'); ?></strong></th>
			<?php }?>
			<th class="table_cell" width="20"><strong><?php echo __('Date'); ?></strong></th> 
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<!-- <th class="table_cell"><strong><?php echo __('Specimen Type'); ?></strong></th> 
			<th class="table_cell"><strong><?php echo __('Order Date'); ?></strong></th>-->
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Description'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<tr>
			<?php if(isset($packageInstallment)){?>
			<td><?php echo $this->Form->input('',array('name'=>'LaboratoryTestOrder[is_billable][]','class'=>'textBoxExpnd',
					'escape'=>false,'hiddenField'=>false,'multiple'=>false,'type'=>'checkbox','label'=>false,'div'=>false,'id'=>'isBillable_1','autocomplete'=>false));?></td>
			<?php }?>
			<td width="15%">
				<?php $todayLabDate=date("d/m/Y H:i:s");
				echo $this->Form->input('', array('type'=>'text','id' => 'labDate_1','label'=>false,'div'=>false,
				'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  labDate','style'=>'width:120px;',
				'readonly'=>'readonly','name'=>'LaboratoryTestOrder[start_date][]','value'=>$todayLabDate)); ?>
			</td>
				
			<td ><?php echo $this->Form->input('',array('name'=>'LaboratoryTestOrder[lab_name][]','class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd test_name',
					'escape'=>false,'multiple'=>false,'type'=>'text','label'=>false,'div'=>false,'id'=>'test_name_1','autocomplete'=>false,
					'placeHolder'=>'Lab Search'));
				echo $this->Form->hidden('', array('name'=>'LaboratoryTestOrder[laboratory_id][]','type'=>'text','label'=>false,
					'id' => 'labid_1','class'=> 'textBoxExpnd labid','div'=>false));
			?><!-- <span class="orderText" id="orderText_1" style="float:right; cursor: pointer;" title="Order Detail"><strong>...</strong></span> --> </td>
		
			<td>
			<?php 
			if(strtolower($configInstance)=='kanpur'){
				echo $this->Form->input('',array('type'=>'select','options'=>$serviceProviders,
					'id'=>'service_provider_id_1','label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd externalRequisition',
					'name'=>"data[LaboratoryTestOrder][service_provider_id][]"));
			}else{
				echo $this->Form->input('',array('type'=>'select','options'=>$serviceProviders,'empty'=>__('None'),
					'id'=>'service_provider_id_1','label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd externalRequisition',
					'name'=>"data[LaboratoryTestOrder][service_provider_id][]"));
			}?>
			
			<td><?php 
			
			if(strtolower($this->Session->read('role'))==strtolower(Configure::read('Senior_RGJAY')) ||
					strtolower($this->Session->read('role'))==strtolower('admin')
					){
						echo $this->Form->input('', array( 'style'=>'text-align:right',
								'name'=>'LaboratoryTestOrder[amount][]','type'=>'text','label'=>false,'id' => 'labAomunt_1',
								'class'=> 'validate[required,custom[mandatory-enter]] textBoxExpnd specimentype kanpurAmount labServiceAmount','div'=>false));
			}else{
				echo $this->Form->input('', array('readonly'=>'readonly','style'=>'text-align:right',
						'name'=>'LaboratoryTestOrder[amount][]','type'=>'text','label'=>false,'id' => 'labAomunt_1',
						'class'=> 'validate[required,custom[mandatory-enter]] textBoxExpnd specimentype kanpurAmount labServiceAmount','div'=>false));
			}
			echo $this->Form->input('', array('name'=>'LaboratoryTestOrder[fix_discount][]',
					'type'=>'hidden','label'=>false,'id' => 'lfix_discount_1',
					'class'=> 'fix_discount','div'=>false));
			?></td>
			
			<td><?php echo $this->Form->input('', array('name'=>'LaboratoryTestOrder[description][]','type'=>'text','label'=>false,
					'id' => 'description_1','class'=> 'textBoxExpnd description','div'=>false));?></td>
		
			<td>&nbsp;</td>
		</tr>
		
		
	</tbody>
</table>
<?php if($configInstance=='vadodara'){?>
<div style="padding-top: 10px"><strong><font color="red"><span id="totalLabAmount" style="float:right; padding-right: 27%"></span></font></strong></div>
<?php }else{?>
<div>&nbsp;</div>
<?php }?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		 <td width="50%"><input name="" type="button" value="Add More Labs" class="blueBtn addMoreLab" /> </td>
		 <td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveLabBill"> </td>
	</tr>
</table>
		
<?php echo $this->Form->end();?>
</div>
<?php }?>
<!--  pathology section end-->







<!--  radiology section start-->
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="radiologySection" style="display: none; width: 100%">
<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'addRad','type' => 'file','id'=>'radServices','inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)
));
?>
<table class="tabularForm" style="clear:both ; width:100% " cellspacing="1" id="RadiologyArea">
	<tbody>
		<tr class="row_title">
			<?php if(isset($packageInstallment)){?>
			<th class="table_cell" width="105"><strong><?php echo __('Billable Service'); ?></strong></th>
			<?php }?>
			<th class="table_cell"><strong><?php echo __('Date'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Radiology Test Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Description'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<tr>
		<?php if(isset($packageInstallment)){?>
		<td><?php echo $this->Form->input('',array('name'=>'data[RadiologyTestOrder][is_billable][]','class'=>'textBoxExpnd',
					'escape'=>false,'hiddenField'=>false,'multiple'=>false,'type'=>'checkbox','label'=>false,'div'=>false,'id'=>'isBillable_1','autocomplete'=>false));?></td>
					<?php }?>
			<td width="15%">
				<?php $todayRadDate=date("d/m/Y H:i:s");
				echo $this->Form->input('', array('type'=>'text','id' => 'radDate_1','label'=>false,'div'=>false,
				'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  radDate','style'=>'width:120px;',
				'readonly'=>'readonly','name'=>'data[RadiologyTestOrder][radiology_order_date][]','value'=>$todayRadDate)); ?>
			</td>
			
			<td ><?php echo $this->Form->input('', array('id' => 'radiologyname_1','type'=>'text', 'label'=> false, 'div' => false,
					 'error' => false,'autocomplete'=>false,'class'=>'validate[required,custom[mandatory-enter]] radiology_name textBoxExpnd','name'=>'data[RadiologyTestOrder][rad_name][]'));
			echo $this->Form->hidden('', array('type'=>'text','name'=>'data[RadiologyTestOrder][radiology_id][]','id'=>'radiologytest_1','class'=>'radiology_test'));
			?></td>
		
			<td>
			<?php 
			if(strtolower($configInstance)=='kanpur'){
				echo $this->Form->input('',array('type'=>'select','options'=>$radServiceProviders,'id'=>'service_provider_id1',
					'label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd','name'=>"data[RadiologyTestOrder][service_provider_id][]"));
			}else{
				echo $this->Form->input('',array('type'=>'select','options'=>$radServiceProviders,'empty'=>__('None'),'id'=>'service_provider_id1',
					'label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd','name'=>"data[RadiologyTestOrder][service_provider_id][]"));
			}?>
			<td><?php echo $this->Form->input('', array('readonly'=>'readonly','style'=>'text-align:right','name'=>'data[RadiologyTestOrder][amount][]','type'=>'text',
					'label'=>false,'id' => 'radAomunt_1','class'=> 'validate[required,custom[mandatory-enter]] textBoxExpnd radAomunt kanpurAmount radServiceAmount','div'=>false));
			echo $this->Form->input('', array('name'=>'data[RadiologyTestOrder][fix_discount][]','type'=>'hidden',
					'label'=>false,'id' => 'rfix_discount_1','class'=> 'fix_discount','div'=>false));?></td>
			
			<td><?php echo $this->Form->input('', array('name'=>'data[RadiologyTestOrder][description][]','type'=>'text','label'=>false,'id' => 'description_1','class'=> 'textBoxExpnd description','div'=>false));?></td>
		
			<td>&nbsp;</td>
		</tr>
		
		
	</tbody>
</table>
<?php if($configInstance=='vadodara'){?>
<div style="padding-top: 10px"><strong><font color="red"><span id="totalRadAmount" style="float:right; padding-right: 26%"></span></font></strong></div>
<?php }else{?>
<div>&nbsp;</div>
<?php }?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		 <td width="50%"><input name="" type="button" value="Add More Radiologies" class="blueBtn addMoreRad" /></td>
		 <td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveRadBill"></td>
	</tr>
</table>
<?php echo $this->Form->end();?>
</div>
<?php }?>
<!--  radiology section end-->





<!--MRI Section starts here-->
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="MriSection" style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">
<table cellspacing="1" width="100%">
	<tr>
		<td align="right"><?php 
		echo $this->Html->link(__('Request Test'),array('controller'=>'laboratories','action' => 'lab_order',$patient['Patient']['id'],'?'=>array('dept'=>'mri','return'=>'invoice')), array('escape' => false,'class'=>'blueBtn'));
		?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table class="tabularForm" style="position: relative; width: 100%"
	cellspacing="1">
	<tbody>
	<?php if(!empty($mri)){?>
		<tr class="row_title">
			<th class="table_cell" width="20"><strong><?php echo __('Sr.No.'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Date & Time'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<?php

		//BOF laboratory
		$i=1;
		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
		$mCost = 0 ;
		foreach($mri as $mriKey=>$mriCost){
			
			$mCost = $mCost + $mriCost['TariffAmount'][$hosType] ;
			?>
		<tr>
			<td valign="top"><?php echo $i++ ;?></td>
			<td>&nbsp;&nbsp;<?php echo $mriCost['Radiology']['name'];?></td>
			<td>&nbsp;&nbsp;<?php
			$splitDateIn=  explode(" ",$mriCost['RadiologyTestOrder']['radiology_order_date']);
			echo $this->DateFormat->formatDate2Local($mriCost['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);
			?></td>
			<td align="right" valign="top"><?php echo $mriCost['ServiceProvider']['name'];?></td>
			<td align="right" valign="top"><?php echo $this->Number->currency($mriCost['TariffAmount'][$hosType]);?></td>
			<td align="center" valign="top"><?php 
				if($mriCost['RadiologyResult']['confirm_result'] != 1){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), 
					array('action' => 'deleteTest', $mriCost['RadiologyTestOrder']['id'],$mriCost['RadiologyTestOrder']['patient_id'],"mri"), 
					array('escape' => false),__('Are you sure?', true));
				}?>
			</td>
		</tr>
		<?php
		//}
		}
		if($mCost>0){
			?>
		<tr>
			<td colspan="4" align="right"><!-- <div class="inner_title"><h3>Sub Total</h3><div class="clr"></div><div align="right"><h3><?php echo $this->Number->currency($mCost); ?></h3></div></div>
			 --> Total</td>
			<td align="right"><?php echo $this->Number->currency($mCost); ?></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}?>
		<?php }else{?>
		<tr>
			<td align="center"  colspan="4">No Record in MRI for <?php echo $patient['Patient']['lookup_name'];?></td>
		</tr>
		<?php }?>
	</tbody>
</table>
</div>
<?php }?>
<!--Mri Section Ends here-->






<!--CT Section starts here-->
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="CTSection" style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">

<table cellspacing="1" width="100%">
	<tr>
		<td align="right"><?php 
		echo $this->Html->link(__('Request Test'),array('controller'=>'laboratories','action' => 'lab_order',$patient['Patient']['id'],'?'=>array('dept'=>'ct','return'=>'invoice')), array('escape' => false,'class'=>'blueBtn'));
		?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table class="tabularForm" style="position: relative; width: 100%" cellspacing="1">
	<?php if(!empty($ct)){?>
	<thead>
		<tr class="row_title">
			<th class="table_cell" width="20"><strong><?php echo __('Sr.No.'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Service Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Date & Time'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
	</thead>	
	<?php
		$i=1;
		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
		$cCost = 0 ;
		foreach($ct as $mriKey=>$ctCost){
			$cCost += $ctCost['TariffAmount'][$hosType] ;
	?>
	<tbody>
		<tr>
			<td valign="top"><?php echo $i++ ;?></td>
			<td>&nbsp;&nbsp;<?php echo $ctCost['Radiology']['name'];?></td>
			<td>&nbsp;&nbsp;<?php
			$splitDateIn=  explode(" ",$ctCost['RadiologyTestOrder']['radiology_order_date']);
			echo $this->DateFormat->formatDate2Local($ctCost['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);
			?></td>
			<td align="right" valign="top"><?php echo $ctCost['ServiceProvider']['name'];?></td>
			<td align="right" valign="top"><?php echo $this->Number->currency($ctCost['TariffAmount'][$hosType]);?></td>
			<td align="center" valign="top">
			<?php 
				if($ctCost['RadiologyResult']['confirm_result'] != 1){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), 
					array('action' => 'deleteTest', $ctCost['RadiologyTestOrder']['id'],$ctCost['RadiologyTestOrder']['patient_id'],"ct"), 
					array('escape' => false),__('Are you sure?', true));
				}?>
			</td>
		</tr>
		<?php }?>
	</tbody>
	<?php if($cCost>0){ ?>
		<tr>
			<td colspan="4" align="right"><!-- <div class="inner_title"><h3>Sub Total</h3><div class="clr"></div><div align="right"><h3><?php echo $this->Number->currency($cCost); ?></h3></div></div>
			 --> Total</td>
			<td align="right"><?php echo $this->Number->currency($cCost); ?></td>
			<td>&nbsp;</td>
		</tr>
	<?php }} else {?>
	<tr>
			<td align="center" colspan="4">No Record in CT for <?php echo $patient['Patient']['lookup_name'];?></td>
		</tr>
	<?php }?>
</table>
</div>
<?php }?>
<!--CT Section Ends here-->








<!--Implant Section starts here-->
<div class="dynamicServiceSection" id="implantSection" style="display: none">

<?php  if($configInstance=='hope' && $this->Session->read('userid') == "128" || $this->Session->read('userid') == "1"){ //using static id only for hope and amol cashier id by amit jain?> 
 <table height="40px" width="100%" cellpadding="0" cellspacing="1" border="0" style=" clear:both">
	 <tr>
		<td><a href="javascript:void(0);" class="blueBtn spotImplantService" id="spotImplantService">Spot Implant Payment</a></td>
	 </tr>
 </table>
<?php  }?>

<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>

 
<!--  BOF blood  -->
<?php echo $this->Form->create('implantService',array('controller'=>'billings','action'=>'',$patient['Patient']['id'],'type' => 'file','id'=>'implantServiceFrm','inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)
));


echo $this->Form->hidden('billings.location_id', array('value'=>$this->Session->read('locationid')));
echo $this->Form->hidden('billings.patient_id', array('id'=>'patient_id','value'=>$patientID)); 
?>
 


<table width="100%" cellpadding="0" cellspacing="1" border="0" style=" clear:both" class="tabularForm" id="implantArea">
			<tr>
				<th width="140"><?php echo __('Date');?></th>
				<th width="150" style=""><?php echo __('Suplier');?></th>
				<th width="150" style=""><?php echo __('Service');?></th>
				<th width="100"><?php echo __('Unit Price');?></th>
				<th width="80" style=""><?php echo __('No of times');?></th>
				<th width="100" style=""><?php echo __('Amount');?></th>
				<th width="100" style=""><?php echo __('Description');?></th>
				<th width="50"><?php echo __('Action');?></th>
			</tr>
			
			<tr id="row_1">
				<td align="center" width="140">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php $todayImplantDate=date("d/m/Y H:i:s");
					echo $this->Form->input('', array('type'=>'text','id' => 'implantDate_1','label'=>false,'div'=>false,
					'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  implantDate','style'=>'width:135px;',
					'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ServiceBill][0][date]','value'=>$todayImplantDate)); ?>
				</td>
				 
			 	<td align="center">
				<?php echo $this->Form->input('suplier',array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd suplier',
						'id'=>'suplier_1','name'=>'data[ServiceBill][0][suplier]','empty'=>'Please select','options'=>$supliers,
						'label'=>false,'div'=>false));?></td>
							
				<td align="center" width="150">
					<?php   
					echo $this->Form->input('implant_service', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd implant_service',
					 	 'div' => false,'label' => false,'autocomplete'=>'off','id' => 'implantServiceId_1','style'=>'width:150px;','fieldNo'=>1, ));

					echo $this->Form->hidden('', array('class' => 'onlyImplantId','id' => 'onlyImplantId_1',
						'name'=>'data[ServiceBill][0][tariff_list_id]'));
					?> </td>
				 
				<td align="center">
				<?php echo $this->Form->input('amount',array('readonly'=>'readonly','class' => 'validate[required,custom[onlyNumber]] textBoxExpnd implantAmount kanpurAmount',
						'legend'=>false,'label'=>false,'id' => 'implantAmount_1','style'=>'width:95px; text-align:right;','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][amount]','autocomplete'=>'off')); ?></td>
				
				<td align="center">
					<?php echo $this->Form->input('no_of_times',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd implantQty',
							'id'=>'implantQty_1','type'=>'text','style'=>'width:80px;','name'=>'data[ServiceBill][0][no_of_times]',
							'label'=>false,'div'=>false,'value'=>'1','autocomplete'=>'off'));
					echo $this->Form->input('fix_discount',array('class'=>'fix_discount',
							'id'=>'ifix_discount_1','type'=>'hidden','name'=>'data[ServiceBill][0][fix_discount]',
							'label'=>false,'div'=>false,'autocomplete'=>'off'));?></td>
				
				<td id="implantTotalAmount_1" class="implantTotalAmount" valign="middle" style="text-align:center;"></td>
				<td align="center">
					<?php echo $this->Form->input('description',array('class'=>' textBoxExpnd implantDescription','id'=>'implantDescription_1',
							'type'=>'text','style'=>'width:150px;','name'=>'data[ServiceBill][0][description]','label'=>false,'div'=>false));?></td>
							
				<td valign="middle" style="text-align:center;"></td>  
			</tr>
	 </table>
		
<div id="pageNavPosition" align="center"></div>
<!-- billing activity form end here -->
<div>&nbsp;</div>

	<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
		<tr>
			<td width="50%"><input name="addImplant" type="button"
				value="Add More Implant Services" class="blueBtn addMoreImplant" onclick="addImplantService();" />  
			</td>
			<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveImplantData"> </td>
		</tr>
	</table>

	<?php echo $this->Form->end();// EOF service bill form ?>

<?php } //EOF discharge conditions?>
<!--Implant Section Ends here-->
</div>

 



<!--ward procedure Section starts here-->
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="wardSection" style="display: none">
 
 
<?php echo $this->Form->create('wardService',array('controller'=>'billings','action'=>'','type' => 'file','id'=>'wardProcedureFrm','inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)
));
 
?>

<table width="100%" cellpadding="0" cellspacing="1" border="0" style=" clear:both" class="tabularForm" id="wardArea">
			<tr>
				<th width="140"><?php echo __('Date');?></th>
				<th width="150" style=""><?php echo __('Service');?></th>
				<th width="100"><?php echo __('Unit Price');?></th>
				<th width="80" style=""><?php echo __('No of times');?></th>
				<th width="100" style=""><?php echo __('Amount');?></th>
				<th width="100" style=""><?php echo __('Description');?></th>
				<th width="50"><?php echo __('Action');?></th>
			</tr>
			
			<tr id="row_1">
				<td align="center" width="140">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php $todayWardDate=date("d/m/Y H:i:s");
					echo $this->Form->input('', array('type'=>'text','id' => 'wardDate_1','label'=>false,'div'=>false,
					'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  wardDate','style'=>'width:135px;',
					'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ServiceBill][0][date]','value'=>$todayWardDate)); ?>
				</td>
				 
				<td align="center" width="150">
					<?php   
					echo $this->Form->input('ward_service', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd ward_service',
					 	 'div' => false,'label' => false,'autocomplete'=>'off','id' => 'wardServiceId_1','style'=>'width:150px;','fieldNo'=>1, ));

					echo $this->Form->hidden('', array('class' => 'onlyWardId','id' => 'onlyWardId_1','name'=>'data[ServiceBill][0][tariff_list_id]'));
					?> </td>
				 
				<td align="center">
				<?php echo $this->Form->input('amount',array('readonly'=>'readonly','class' => 'validate[required,custom[onlyNumber]] textBoxExpnd wardAmount kanpurAmount',
						'legend'=>false,'label'=>false,'id' => 'wardAmount_1','style'=>'width:95px; text-align:right;','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][amount]','autocomplete'=>'off')); ?></td>
				
				<td align="center">
					<?php echo $this->Form->input('no_of_times',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd wardQty',
							'id'=>'wardQty_1','type'=>'text','style'=>'width:80px;','name'=>'data[ServiceBill][0][no_of_times]',
							'label'=>false,'div'=>false,'value'=>'1','autocomplete'=>'off'));?></td>
				
				<td id="wardTotalAmount_1" class="wardTotalAmount" valign="middle" style="text-align:center;"></td>
				<td align="center">
					<?php echo $this->Form->input('description',array('class'=>' textBoxExpnd wardDescription','id'=>'wardDescription_1',
							'type'=>'text','style'=>'width:150px;','name'=>'data[ServiceBill][0][description]','label'=>false,'div'=>false));?></td>
							
				<td valign="middle" style="text-align:center;"></td>  
			</tr>
	 </table>
		
<div id="pageNavPosition" align="center"></div>
<!-- billing activity form end here -->
<div>&nbsp;</div>

	<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
		<tr>
			<td width="50%"><input name="addWard" type="button"
				value="Add More Ward Procedures" class="blueBtn addMoreWard" onclick="addWardService();" />  
			</td>
			<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveWardData"> </td>
		</tr>
	</table>

	<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--ward procedure Section Ends here-->





<!--other service Section starts here-->
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="otherServiceSection" style="display: none">
<?php echo $this->Form->create('other_service',array('controller'=>'billings','action'=>'','type' => 'file','id'=>'otherServiceFrm','inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)));?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style=" clear:both" class="tabularForm" id="otherServiceArea">
			<tr>
				<th width="140"><?php echo __('Date');?></th>
				<th width="150" style=""><?php echo __('Service');?></th>
				<th width="100"><?php echo __('Unit Price');?></th>
				<th width="80" style=""><?php echo __('No of times');?></th>
				<th width="100" style=""><?php echo __('Amount');?></th>
				<th width="100" style=""><?php echo __('Description');?></th>
				<th width="50"><?php echo __('Action');?></th>
			</tr>
			
			<tr id="row_1">
				<td align="center" width="140">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php $todayOtherServiceDate=date("d/m/Y H:i:s");
					echo $this->Form->input('', array('type'=>'text','id' => 'otherServiceDate_1','label'=>false,'div'=>false,
					'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  otherServiceDate','style'=>'width:135px;',
					'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ServiceBill][0][date]','value'=>$todayOtherServiceDate)); ?>
				</td>
				 
				<td align="center" width="150">
					<?php   
					echo $this->Form->input('other_service', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd other_service',
					 	 'div' => false,'label' => false,'autocomplete'=>'off','id' => 'otherService_1','style'=>'width:150px;','fieldNo'=>1, ));

					echo $this->Form->hidden('', array('class' => 'otherServiceId','id' => 'otherServiceId_1','name'=>'data[ServiceBill][0][tariff_list_id]'));
					?> </td>
				 
				<td align="center">
				<?php echo $this->Form->input('amount',array('readonly'=>'readonly','class' => 'validate[required,custom[onlyNumber]] textBoxExpnd otherServiceAmount kanpurAmount',
						'legend'=>false,'label'=>false,'id' => 'otherServiceAmount_1','style'=>'width:95px; text-align:right;','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][amount]','autocomplete'=>'off')); ?></td>
				
				<td align="center">
					<?php echo $this->Form->input('no_of_times',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd otherServiceQty',
							'id'=>'otherServiceQty_1','type'=>'text','style'=>'width:80px;','name'=>'data[ServiceBill][0][no_of_times]',
							'label'=>false,'div'=>false,'value'=>'1','autocomplete'=>'off'));?></td>
				
				<td id="otherServiceTotalAmount_1" class="otherServiceTotalAmount" valign="middle" style="text-align:center;"></td>
				<td align="center">
					<?php echo $this->Form->input('description',array('class'=>' textBoxExpnd otherServiceDescription','id'=>'otherServiceDescription_1',
							'type'=>'text','style'=>'width:150px;','name'=>'data[ServiceBill][0][description]','label'=>false,'div'=>false));?></td>
							
				<td valign="middle" style="text-align:center;"></td>  
			</tr>
	 </table>
		
<div id="pageNavPosition" align="center"></div>
<!-- billing activity form end here -->

<?php if($configInstance=='vadodara'){?>
<div style="padding-top: 10px"><strong><font color="red"><span id="totalOtherServiceAmount" style="float:right; padding-right: 30%"></span></font></strong></div>
<?php }else{?>
<div>&nbsp;</div>
<?php }?>

<div>&nbsp;</div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
		<tr>
			<td width="50%"><input name="addOtherServiceRows" type="button" value="Add More Other Services" class="blueBtn addMoreOtherService" onclick="addOtherService(null);" /> </td>
			<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveOtherServiceData"> </td>
		</tr>
	</table>
	<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--other service Section Ends here-->

 



<!--radiotheraphy service Section starts here-->
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="radiotheraphySection" style="display: none">
<?php echo $this->Form->create('Radiotheraphy',array('controller'=>'billings','action'=>'','type' => 'file','id'=>'radiotheraphyFrm','inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false
)));?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style=" clear:both" class="tabularForm" id="radiotheraphyArea">
			<tr>
				<th width="140"><?php echo __('Date');?></th>
				<th width="150" style=""><?php echo __('Service');?></th>
				<th width="100"><?php echo __('Unit Price');?></th>
				<th width="80" style=""><?php echo __('No of times');?></th>
				<th width="100" style=""><?php echo __('Amount');?></th>
				<th width="100" style=""><?php echo __('Description');?></th>
				<th width="50"><?php echo __('Action');?></th>
			</tr>
			
			<tr id="row_1">
				<td align="center" width="140">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php $todayRadiotheraphyDate=date("d/m/Y H:i:s");
					echo $this->Form->input('', array('type'=>'text','id' => 'radiotheraphyDate_1','label'=>false,'div'=>false,
					'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  radiotheraphyDate','style'=>'width:135px;',
					'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ServiceBill][0][date]','value'=>$todayRadiotheraphyDate)); ?>
				</td>
				 
				<td align="center" width="150">
					<?php echo $this->Form->input('radiotheraphy_service', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd radiotheraphy_service',
					 	 'div' => false,'label' => false,'autocomplete'=>'off','id' => 'radiotheraphy_1','style'=>'width:150px;','fieldNo'=>1, ));

					echo $this->Form->hidden('', array('class' => 'radiotheraphyId','id' => 'radiotheraphyId_1','name'=>'data[ServiceBill][0][tariff_list_id]'));
					?> </td>
				 
				<td align="center">
				<?php echo $this->Form->input('amount',array(/*'readonly'=>'readonly',*/'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd radiotheraphyAmount kanpurAmount',
						'legend'=>false,'label'=>false,'id' => 'radiotheraphyAmount_1','style'=>'width:95px; text-align:right;','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][amount]','autocomplete'=>'off')); ?></td>
				
				<td align="center">
					<?php echo $this->Form->input('no_of_times',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd radiotheraphyQty',
							'id'=>'radiotheraphyQty_1','type'=>'text','style'=>'width:80px;','name'=>'data[ServiceBill][0][no_of_times]',
							'label'=>false,'div'=>false,'value'=>'1','autocomplete'=>'off'));?></td>
				
				<td id="radiotheraphyTotalAmount_1" class="radiotheraphyTotalAmount" valign="middle" style="text-align:center;"></td>
				<td align="center">
					<?php echo $this->Form->input('description',array('class'=>' textBoxExpnd radiotheraphyDescription','id'=>'radiotheraphyDescription_1',
							'type'=>'text','style'=>'width:150px;','name'=>'data[ServiceBill][0][description]','label'=>false,'div'=>false));?></td>
							
				<td valign="middle" style="text-align:center;"></td>  
			</tr>
	 </table>
		
<div id="pageNavPosition" align="center"></div>
<!-- billing activity form end here -->

<?php if($configInstance=='vadodara'){?>
<div style="padding-top: 10px"><strong><font color="red"><span id="totalRadiotheraphyAmount" style="float:right; padding-right: 30%"></span></font></strong></div>
<?php }else{?>
<div>&nbsp;</div>
<?php }?>

<div>&nbsp;</div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
		<tr>
			<td width="50%"><input name="addRadiotheraphyRows" type="button" value="Add More Radiotheraphy" class="blueBtn addMoreRadiotheraphy" onclick="addRadiotheraphy(null);" /> </td>
			<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveRadiotheraphyData"> </td>
		</tr>
	</table>
	<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--radiotheraphy Section Ends here-->

  


<!--  pharmacy section start-->
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="pharmacy-section" style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">

<table cellspacing="1" width="100%">
	<tr>
		<td align="right"><?php echo $this->Html->link(__('Add'),array("controller" => "pharmacy", "action" => "sales_bill",$patient['Patient']['id'],"inventory" => true,"plugin"=>false), array( 'escape' => false,'class'=>'blueBtn'));?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>

		<?php
		if(isset($patient_pharmacy_details)){
			$credit_amount = 0;
			$cash_amount = 0;
			$total = 0;
			?>

<table class="tabularForm" style="position: relative; width: 100%">
	<tbody>
		<tr>
			<th>Sr. No.</th>
			<th>Bill No.</th>
			<th>Bill Date</th>
			<th>Amount</th>
			<th>Payment Mode</th>
		</tr>
	</tbody>
	<?php

	foreach($patient_pharmacy_details as $key =>$value){
			
		?>
	<tr>
		<td><?php echo $key+1;?></td>
		<td><?php echo $value['PharmacySalesBill']['bill_code'];?></td>
		<td><?php //echo $value['PharmacySalesBill']['create_time'];
		echo $this->DateFormat->formatDate2Local($value['PharmacySalesBill']['create_time'],Configure::read('date_format'),true);
		?></td>
		<td><?php //echo $value['PharmacySalesBill']['total'];
		echo $this->Number->currency(ceil($value['PharmacySalesBill']['total']));
		?></td>
		<td><?php echo ucfirst($value['PharmacySalesBill']['payment_mode']);?></td>
	</tr>
	<?php
	$total = $total+(double)$value['PharmacySalesBill']['total'];
	if($value['PharmacySalesBill']['payment_mode'] == "cash")
	$cash_amount =$cash_amount+(double)$value['PharmacySalesBill']['total'];
	}
	?>

</table>
<table style="position: relative; width: 100%">
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right">Total Amount <?php			
		echo $this->Number->currency(ceil($total-$cash_amount));
		 
	 ?></td>
	</tr>

	<?php

	?>
</table>
	<?php }else{?>

<table class="tabularForm" style="position: relative; width: 100%"
	width="100%">
	<tbody>
		<tr>
			<td align="center" colspan="4">No Record In Pharmacy For <?php echo $patient['Patient']['lookup_name'];?></td>
		</tr>
	</tbody>
</table>
<?php }?></div>
<?php }?>
<!--  pharmacy section end-->
 

 
<!-- ******** -->

	
<!-- date section end here -->
	
<!-- BOF Consultant Section -->
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="consultantBillingSection" style="display: none;">
<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'consultantBilling','type' => 'file','id'=>'ConsultantBillingNew','inputDefaults' => array(
																						        'label' => false,
																						        'div' => false,
																						        'error' => false,
																						        'legend'=>false,
																						        'fieldset'=>false
)
));
echo $this->Form->hidden('patient_id',array('value'=>$patientID));
?>

<table width="100%"  cellpadding="0" cellspacing="1" border="0" align="left" class="tabularForm"id="consulTantGridNew">
			<tr>
				<th width=""><?php echo __('Date');?></th>
				<th><?php echo __('Not To Pay Doctor');?></th>
				<th width=""><?php echo __('Type');?></th>
				<th width="" style=""><?php echo __('Name');?></th>
				<!-- <th width="250" style=""><?php echo __('Service Group/Sub Group');?></th> -->
				<th width="" style=""><?php echo __('Service');?></th>
				<!-- <th width="250" style=""><?php //echo __('Hospital Cost');?></th> -->
				<th width=""><?php echo __('Amount');?></th>
				<th width=""><?php echo __('Description');?></th>
				<th width=""><?php echo __('Pay');?></th>
				<th width=""><?php echo __('Action');?></th>
			</tr>
				
			<tr id="row_1">
				<td valign="top" width="">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php $todayConsultantDate=date("d/m/Y H:i:s");
					echo $this->Form->input('', array('type'=>'text','id' => 'ConsultantDate_1','label'=>false,'div'=>false,
					'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  ConsultantDate','style'=>'width:135px;',
					'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ConsultantBilling][0][date]','value'=>$todayConsultantDate)); ?>
				</td>
			
				<td valign="top"><input type="checkbox" class="notToPayDr" id="notToPayDr_1" name="data[ConsultantBilling][0][not_to_pay_dr]" value="1"> </td> 
			
				<td valign="top">
					<?php echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd category_id',
						'div' => false,'label' => false,'empty'=>__('Please select'),'options'=>array('External Consultant','Treating Consultant'),
						'id' => 'category_id_1','style'=>'width:152px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][0][category_id]',
						'type'=>'select',"onchange"=>"categoryChange(this)")) ?>
				</td> 
				<td valign="top" style="text-align: left;">
					<?php echo $this->Form->input('ConsultantBilling.doctor_id', array('class' =>
					 'validate[required,custom[mandatory-select]] textBoxExpnd doctor_id','div' => false,'label' => false,'empty'=>__('Please Select'),
					 'options'=>array(''),'id' => 'doctor_id_1','style'=>'width:152px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][0][doctor_id]',
					 "onchange"=>"doctor_id(this)")); ?>
				</td> 
				 
				<td valign="top" style="text-align: left;">
					<?php   
					echo $this->Form->input('', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd consultant_service_id',
							'div' => false,'label' => false  ,'id' => 'consultant_service_id_1',
							'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][0][consultant_service_name]'));
					 
					echo $this->Form->hidden('', array('class' => 'onlyConsultantServiceId','id' => 'onlyConsultantServiceId_1',
						'name'=>'data[ConsultantBilling][0][consultant_service_id]'));?> 
				</td> 
				
				<td valign="top" align="right"><?php echo $this->Form->input('amount',
						array('class' => 'validate[required,custom[onlyNumber]] amount textBoxExpnd kanpurAmount','legend'=>false,'label'=>false,'readonly'=>'readonly',	
							'id' => 'amountConsultant_1','style'=>'width:80px; text-align:right;','fieldNo'=>1,'name'=>'data[ConsultantBilling][0][amount]')); 
				?></td>
				<td valign="top" style="text-align: center;"><?php echo $this->Form->input('description',
						array('class' => 'description textBoxExpnd','legend'=>false,'label'=>false,'id' => 'description_1',
						'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][0][description]')); 
				?></td>
				
				<td valign="top" style="text-align: center;"><?php echo $this->Form->input('pay_to_consultant',
						array('class' => 'pay_to_consultant textBoxExpnd validate[optional,custom[onlyNumber]]','legend'=>false,'label'=>false,'id' => 'payToConsultant_1',
						'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][0][pay_to_consultant]')); 
				?></td>
				
				<td valign="top" style="text-align:center;">  </td>  
			</tr>
</table>
		 
<div>	 
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="left">
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
		 <td width="50%">
		 <input name="addConsultant" type="button"
				value="Add More Visits" class="blueBtn addMoreConsultant" onclick="addConsultantVisitElement();" />
		 
		<!--  <input name="" type="button" value="Add More Visits" class="blueBtn addMore" tabindex="17" 
		 onclick="addConsultantVisitElement();"/> &nbsp;&nbsp;<input name="removeVisit" type="button" value="Remove" 
		 class="blueBtn" tabindex="17" onclick="removeConsultantVisitElement();" id="removeVisit" style="visibility:hidden"/> --></td>
		 
		 <td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveConsultantBillData"> </td>
		  
	</tr>
	 
</table>

</div>
<?php echo $this->Form->end(); ?>
</div>				
<?php }?>				
	

<!-- ******** -->
<!--  Service section start-->

<?php //if($patient['Patient']['admission_type']!='OPD' && $patient['Patient']['is_discharge']!=1){
if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="servicesSection" style="display: none">
 
<!--  BOF servcices  -->
<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'servicesBilling',$patient['Patient']['id'],'type' => 'file','id'=>'servicefrm','inputDefaults' => array(
																						        'label' => false,
																						        'div' => false,
																						        'error' => false,
																						        'legend'=>false,
																						        'fieldset'=>false
)
));

/*echo $this->Form->create('billings',array('controller'=>'billings','action'=>'servicesBilling',),
					array('id'=>'servicefrm','label'=>false,'div'=>false));*/
echo $this->Form->hidden('serviceGroupId', array('id'=>'serviceGroupId'));
echo $this->Form->hidden('location_id', array('value'=>$this->Session->read('locationid')));
echo $this->Form->hidden('patient_id', array('id'=>'patient_id','value'=>$patientID));
if(isset($corporateId) && $corporateId != ''){
	echo $this->Form->hidden('corporate_id', array('value'=>$corporateId));
}else{
	echo $this->Form->hidden('corporate_id', array('value'=>''));
}?>

<table width="100%" cellpadding="0" cellspacing="1" border="0" style=" clear:both" class="tabularForm" id="serviceGrid">
			<tr>
				<?php if(isset($packageInstallment)){?>
				<th class="table_cell" width="63"><strong><?php echo __('Billable Service'); ?></strong></th>
				<?php }?>
				<th width="140"><?php echo __('Date');?></th>
				<th width="150" style=""><?php echo __('Service');?></th>
				<th width="100"><?php echo __('Unit Price');?></th>
				<th width="80" style=""><?php echo __('No of times');?></th>
				<th width="100" style=""><?php echo __('Amount');?></th>
				<th width="100" style=""><?php echo __('Description');?></th>
				<th width="50"><?php echo __('Action');?></th>
			</tr>
			
			<!-- row to display the applied services -->
			<?php //debug($servicesData);?>
			<?php foreach($servicesData as $services){?>
			<tr>
			
				<td align="center">
					<?php //echo $services['ServiceBill']['date'];
					if(!empty($services['ServiceBill']['date']))
				echo $this->DateFormat->formatDate2Local($services['ServiceBill']['date'],Configure::read('date_format'),true);
				?>
				</td>
				<td><?php echo $services['ServiceCategory']['name'];?></td>
				<td><?php echo $services['ServiceSubCategory']['name'];?></td>
				<td><?php echo $services['TariffList']['name'];?></td>
				<td align="center">
					<?php if(!empty($services['TariffAmount']['non_nabh_charges']))
							{	echo $amount = $services['TariffAmount']['non_nabh_charges']; }
						if(!empty($services['TariffAmount']['non_charges']))
						{	echo $amount = $services['TariffAmount']['non_charges']; }
					?>
				</td>
				<td align="center"><?php echo $no_of_time = $services['ServiceBill']['no_of_times'];?></td>
				<td align="right"><?php echo ($amount*$no_of_time); unset($amount);?></td>
				<td align="center">
					<?php 
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',
													 array('title'=>'Delete','alt'=>'Delete')),
													 array('action' => 'deleteServicesCharges',
													 $services['ServiceBill']['id'],
													 $services['ServiceBill']['patient_id']),
													 array('escape' => false),__('Are you sure?', true));?>
				</td>
				
			</tr>
			<?php }?>
			<!-- row ends -->
			
			<?php //echo $this->Form->create('ServiceBill',array('controller'=>'Billings','action'=>'servicesBilling',$patient['Patient']['id']))?>
			
			<!-- row to add services -->
			<tr id="row_1">
			<?php if(isset($packageInstallment)){?>
				<td><?php echo $this->Form->input('',array('name'=>'data[ServiceBill][0][is_billable]','class'=>'textBoxExpnd',
					'escape'=>false,'hiddenField'=>false,'multiple'=>false,'type'=>'checkbox','label'=>false,'div'=>false,'id'=>'isBillableService_1','autocomplete'=>false));?></td>
					<?php }?>
				<td align="center" width="140">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php $todayServiceDate=date("d/m/Y H:i:s");
					echo $this->Form->input('', array('type'=>'text','id' => 'ServiceDate_1','label'=>false,'div'=>false,
					'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  ServiceDate','style'=>'width:135px;',
					'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ServiceBill][0][date]','value'=>$todayServiceDate)); ?>
				</td>
				 
				 
				<td align="center" width="150">
					<?php  
					echo $this->Form->input('', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd service_id',
					 	 'div' => false,'label' => false  ,'id' => 'service_id_1','style'=>'width:150px;','fieldNo'=>1, ));

					echo $this->Form->hidden('', array('class' => 'onlyServiceId','id' => 'onlyServiceId_1','name'=>'data[ServiceBill][0][tariff_list_id]'));
					?> </td>
				  
				<td align="center">
				<?php echo $this->Form->input('amount',array('readonly'=>'readonly','class' => 'validate[required,custom[onlyNumber]] textBoxExpnd service_amount kanpurAmount clinicalServiceAmount',
						'legend'=>false,'label'=>false,'id' => 'service_amount_1','style'=>'width:95px; text-align:right;','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][amount]','autocomplete'=>'off')); ?></td>
				
				<td align="center">
					<?php echo $this->Form->input('no_of_times',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd no_of_times nofTime totalSertviceQty',
							'id'=>'no_of_times_1','type'=>'text','style'=>'width:80px;','name'=>'data[ServiceBill][0][no_of_times]',
							'label'=>false,'div'=>false,'value'=>'1'));
					echo $this->Form->input('fix_discount',array('class'=>'fix_discount',
							'id'=>'fix_discount_1','type'=>'hidden','name'=>'data[ServiceBill][0][fix_discount]',
							'label'=>false,'div'=>false,'autocomplete'=>'off'));?></td>
				
				<td id="amount_1" class="amount" valign="middle" style="text-align:center;"></td>
				<td align="center">
					<?php echo $this->Form->input('description',array('class'=>' textBoxExpnd description','id'=>'description_1',
							'type'=>'text','style'=>'width:150px;','name'=>'data[ServiceBill][0][description]','label'=>false,'div'=>false));?></td>
				<td valign="middle" style="text-align:center;"></td>  
			</tr>
			
			<!-- row ends -->
	 </table>
		<!-- EOF services --> 
		
<div id="pageNavPosition" align="center"></div>
<!-- billing activity form end here -->
<?php if($configInstance=='vadodara'){?>
<div style="padding-top: 10px"><strong><font color="red"><span id="totalCServiceAmount" style="float:right; padding-right: 30%"></span></font></strong></div>
<?php }else{?>
<div>&nbsp;</div>
<?php }?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
	<tr>
		<td width="50%"><input name="addService" type="button" value="Add More Services" class="blueBtn addMore" onclick="addServiceVisitElement();" /> </td>
		<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="ServiceBillsData"> </td>
	</tr>
</table>


	<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--  Service section end-->

<div>&nbsp;</div>




<!--  blood section start-->
<?php if(($isDischarge!=1 && $patient['Patient']['tariff_standard_id']==$privatepatientID) || ($patient['Patient']['tariff_standard_id']!=$privatepatientID /*&& $isDischarge==1*/)){?>
<div class="dynamicServiceSection" id="bloodSection" style="display: none">
 
<!--  BOF blood  -->
<?php echo $this->Form->create('bloodService',array('controller'=>'billings','action'=>'',$patient['Patient']['id'],'type' => 'file','id'=>'bloodServiceFrm','inputDefaults' => array(
																						        'label' => false,
																						        'div' => false,
																						        'error' => false,
																						        'legend'=>false,
																						        'fieldset'=>false
)
));


echo $this->Form->hidden('billings.location_id', array('value'=>$this->Session->read('locationid')));
echo $this->Form->hidden('billings.patient_id', array('id'=>'patient_id','value'=>$patientID));

?>

<table width="100%" cellpadding="0" cellspacing="1" border="0" style=" clear:both" class="tabularForm" id="bloodArea">
			<tr>
				<th width="140"><?php echo __('Date');?></th>
				<th width="150" style=""><?php echo __('Blood Bank');?></th>
				<th width="150" style=""><?php echo __('Service');?></th>
				<th width="100"><?php echo __('Unit Price');?></th>
				<th width="80" style=""><?php echo __('No of times');?></th>
				<th width="100" style=""><?php echo __('Amount');?></th>
				<th width="100" style=""><?php echo __('Description');?></th>
				<th width="50"><?php echo __('Action');?></th>
			</tr>
			
			<tr id="row_1">
				<td align="center" width="140">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php $todayBloodDate=date("d/m/Y H:i:s");
					echo $this->Form->input('', array('type'=>'text','id' => 'bloodDate_1','label'=>false,'div'=>false,
					'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  bloodDate','style'=>'width:135px;',
					'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ServiceBill][0][date]','value'=>$todayBloodDate)); ?>
				</td>
				 
			 	<td align="center">
				<?php echo $this->Form->input('blood_bank',array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd bloodBank',
						'id'=>'bloodBank_1','name'=>'data[ServiceBill][0][blood_bank]','empty'=>'Please select','options'=>$bloodBanks,
						'label'=>false,'div'=>false));?></td>
							
				<td align="center" width="150">
					<?php   
					echo $this->Form->input('blood_service', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd blood_service',
					 	 'div' => false,'label' => false  ,'id' => 'bloodServiceId_1','style'=>'width:150px;','fieldNo'=>1, ));

					echo $this->Form->hidden('', array('class' => 'onlyBloodId','id' => 'onlyBloodId_1',
						'name'=>'data[ServiceBill][0][tariff_list_id]'));
					?> </td>
				 
				<td align="center">
				<?php echo $this->Form->input('amount',array('readonly'=>'readonly', 'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd bloodAmount kanpurAmount',
						'legend'=>false,'label'=>false,'id' => 'bloodAmount_1','style'=>'width:95px; text-align:right;','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][amount]','autocomplete'=>'off')); 
				echo $this->Form->hidden('fix_discount',array('readonly'=>'readonly', 'class' => 'fix_discount',
						'legend'=>false,'label'=>false,'id' => 'bfix_discount_1','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][fix_discount]','autocomplete'=>'off'));?></td>
				
				<td align="center">
					<?php echo $this->Form->input('no_of_times',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd bloodQty',
							'id'=>'bloodQty_1','type'=>'text','style'=>'width:80px;','name'=>'data[ServiceBill][0][no_of_times]',
							'label'=>false,'div'=>false,'value'=>'1'));?></td>
				
				<td id="bloodTotalAmount_1" class="bloodTotalAmount" valign="middle" style="text-align:center;"></td>
				<td align="center">
					<?php echo $this->Form->input('description',array('class'=>' textBoxExpnd bloodDescription','id'=>'bloodDescription_1',
							'type'=>'text','style'=>'width:150px;','name'=>'data[ServiceBill][0][description]','label'=>false,'div'=>false));?></td>
							
				<td valign="middle" style="text-align:center;"></td>  
			</tr>
	 </table>
		
<div id="pageNavPosition" align="center"></div>
<!-- billing activity form end here -->
<div>&nbsp;</div>

	<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
		<tr>
			<td width="50%"><input name="addBlood" type="button"
				value="Add More Blood Services" class="blueBtn addMoreBlood" onclick="addBloodService();" />  
			</td>
			<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveBloodData"> </td>
		</tr>
	</table>

	<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--  Service section end-->

<!--  Gallery Section-->

<div class="dynamicServiceSection" id="gallerySection" style="display: none; width: 100%">
<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'galleryPackageDetails','type' => 'file','id'=>'addGalleryDetails','inputDefaults' => array(
																							        'label' => false,
																							        'div' => false,
																							        'error' => false,
																							        'legend'=>false,
																							        'fieldset'=>false
)
));
echo $this->Form->input('',array('type'=>'hidden','id'=>'','name'=>"data[GalleryPackageDetail][gallery_package_id]",'value'=>$packageGalleryData['GalleryPackageDetail']['id']));
?>
<table class="tabularForm" style="clear:both ; width:50% " cellspacing="1" >
	<tbody>
		<tr class="row_title">
			<th class="table_cell"><strong><?php echo __('Package Category'); ?></strong></th>
			<th class="table_cell showCat" style="display: none"><strong><?php echo __('Package Sub Category'); ?></strong></th>
			<th class="table_cell showCat" style="display: none"><strong><?php echo __('Package Sub-Sub Category'); ?></strong></th>
			<th class="table_cell" style="width: 1%"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<tr>
			
			<td style="width: 30%">
			<?php echo $this->Form->input('',array('type'=>'text','id'=>'packageCategory','label'=>false,'div'=>false,'error'=>false,'placeHolder'=>"Select Package",
					'class'=>'textBoxExpnd','name'=>"data[GalleryPackageDetail][package_category_name]" ));
			      echo $this->Form->input('',array('type'=>'hidden','id'=>'packageCategoryId','name'=>"data[GalleryPackageDetail][package_category_id]"));
			?>
			</td>
			
			<td class="showCat" style="display: none">
			<?php echo $this->Form->input('',array('type'=>'text','id'=>'packageSubCategory','label'=>false,'div'=>false,'error'=>false,'placeHolder'=>"Select Sub Package",
					'class'=>'textBoxExpnd' ,'name'=>"data[GalleryPackageDetail][package_sub_category_name]" ));
				  echo $this->Form->input('',array('type'=>'hidden','id'=>'packageSubCategoryId','name'=>"data[GalleryPackageDetail][package_sub_category_id]"));
			?>
			</td >
			
			<td class="showCat" style="display: none">
			<?php echo $this->Form->input('',array('type'=>'text','id'=>'packageSubSubCategory','label'=>false,'div'=>false,'error'=>false,'placeHolder'=>"Select Sub Sub Package",
					'class'=>'textBoxExpnd ' ,'name'=>"data[GalleryPackageDetail][package_subsub_category_name]" ));
			      echo $this->Form->input('',array('type'=>'hidden','id'=>'packageSubSubCategoryId','name'=>"data[GalleryPackageDetail][package_subsub_category_id]"));
			?>
			</td>
			
		
			<td align="right"><input class="blueBtn" type="button" value="Save" id="saveGalleryDetails"></td>
		</tr>
		 
		
	</tbody>
</table>
<?php echo $this->Form->end();?>
<?php if(!empty($packageGalleryData)){?>
<table class="tabularForm" style="clear:both ; width:50%;margin-top: 2% " cellspacing="1" >
	<tbody>
		<tr class="row_title">
			<th class="table_cell"><strong><?php echo __('Package Category'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Package Sub Category'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Package Sub-Sub Category'); ?></strong></th>
		</tr>
		<tr>
			
			<td class="alignCenter"><?php echo $packageCategory[$packageGalleryData['GalleryPackageDetail']['package_category_id']];?></td>
			<td class="alignCenter"><?php echo $packageSubCategory[$packageGalleryData['GalleryPackageDetail']['package_sub_category_id']];?></td>
			<td class="alignCenter"><?php echo $packageSubSubCategory[$packageGalleryData['GalleryPackageDetail']['package_subsub_category_id']];?></td>
		</tr>
	</tbody>
</table>
<?php }?>
</div>

<!--  Gallary section Ends here-->

<div>&nbsp;</div> 

<div id="newLayout">
<!-- - GLOBAL DIV PAWAN-->
<div id="globalDivId" style="float: left; width: 49%;  max-height: 550px;  overflow: auto;"></div>
<!-- - GLOBAL DIV PAWAN-->

<div id="paymentDetailDiv" style="float: right; width: 49%; " >
<?php {?>
<?php //$displayPaymentBlock =($isDischarge!=1) ? "style='display : block;'" : "style='display : none;'";

if($isDischarge!=1){
	$displayPaymentBlock ="style='display : block;'";
}else{
	$displayPaymentBlock ="style='display : none;'";
}
?>
<div id="displayPaymentBlock" <?php echo $displayPaymentBlock;?>>
<table width="100%" cellspacing="0" cellpadding="0" border="0"  style="clear:both; border-bottom: 1px solid rgb(62, 71, 74); padding-bottom: 10px;">
 	<tr>	
        <td class="tdLabel2"><strong>Payment Detail</strong>&nbsp;</td>
    </tr>
</table> 

<div id="finalDischargeDiv"> 

<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'finalDischarge','id'=>'paymentDetail','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('Billing.payment_category',array('id'=>'payment_category'));
echo $this->Form->hidden('Billing.tariff_service_name',array('id'=>'tariff_service_name'));
echo $this->Form->hidden('Billing.tariff_list_id',array('id'=>'tariff_list_id'));
echo $this->Form->hidden('Billing.service_amt',array('id'=>'service_amt'))
?> 

<table  width="100%" cellspacing="0" cellpadding="0" border="0" style="padding-left: 10px;" align="center" bgcolor="LightGray" >
     <tbody><tr>
     	<td width="80%" valign="top">
        <table width="100%" cellspacing="0" cellpadding="0" align="center">
      		<tbody>
      			<tr>
                <td width="200" height="35" class="tdLabel2"><?php echo __('Total Amount' );?></td>
                <td width="100"><?php
                		echo $this->Form->input('Billing.total_amount',array('readonly'=>'readonly','value' => $this->Number->format(ceil($totalCost),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totalamount','style'=>'text-align:right;'));
                		echo $this->Form->hidden('Billing.oneShotTotal',array('id'=>'oneShotTotal'));
                		?>
                 </td>
                 
                 <td width="50" style="vertical-align: top;" >
					<?php if(isset($packageInstallment)){?>
						<table cellspacing="1" cellpadding="0" border="0" width="99%" style="display:none;"
							class="tabularForm" style="clear: both; margin: 2px 0px;" id="privatePackageTable">
							<tr>
								<th class="table_cell">Date</th>
								<th class="table_cell">Amount</th>
								<th class="table_cell">Instruction</th>
							</tr>
							<?php foreach($packageInstallment as $installmentData){?>
							<tr>

								<td><?php echo $installmentData['date']?></td>
								<td><?php echo $installmentData['amount']?></td>
								<td><?php echo $installmentData['instruction']?></td>
							</tr>
							<?php }?>
						</table>
						<?php }?>
					</td>
					
					
                 <!--<td id="msgForServicePayment" style="color: red;"></td>-->
                 </tr>
                 
                 <tr>
                 <td height="35" class="tdLabel2">Advance Amount</td>
                 <td> <?php echo $this->Form->input('Billing.amount_paid',array('readonly'=>'readonly',
                 		'value' => $this->Number->format(ceil($totalAdvancePaid)),'legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'text-align:right;'));
				     echo $this->Form->hidden('Billing.amount_for_discount',array('id'=>'amount_for_discount'));?>
     			</td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
			    <td>Amount to Pay</td>
			    <td><?php echo $this->Form->input('Billing.amount',array('autocomplete'=>'off','type'=>'text','value'=>'','legend'=>false,
			    		'label'=>false,'id' => 'amount','style'=>'text-align:right;','readonly'=>'readonly','class' => 'validate[optional,custom[onlyNumber]] num'));
			    
			    ?>
			    </td>
			    <td><!-- <span style="float:left;"><font color="red">&nbsp;&nbsp;*&nbsp;</font></span> -->
			    <?php $todayDate=date("d/m/Y H:i:s");
			    echo $this->Form->input('Billing.date',array('readonly'=>'readonly','class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:120px;','value'=>$todayDate));?>
			    </td>
			    </tr>
			    
			    <?php //show previously given discount ?>
			    <tr id="prevDiscountArea">
					<td height="35" class="tdLabel2">Previous Discount:</td>
					<td id="prevDiscount">0</td>
					<td>&nbsp;</td>
				</tr>
			    
			     <tr id="prevRefundArea">
					<td height="35" class="tdLabel2">Previous Refund:</td>
					<td id="prevRefund">0</td>
					<td>&nbsp;</td>
				</tr>
			    
			   <tr class="partialDiscountRow">
			    <td>Discount</td>
			    <td width="165">
			    	<?php $discount=array('Amount'=>'Amount','Percentage'=>'Percentage');
						echo $this->Form->input('Billing.discount_type', array('id' =>'discountType','options' => $discount,
							'autocomplete'=>'off','readonly'=>false,'legend' =>false,'label' => false,'div'=>false,'class'=>'discountType',
							'type' => 'radio','separator'=>'</br>','disabled'=>false));
						echo $this->Form->hidden('Billing.disc_type',array('id'=>'discType','value'=>''));
						echo $this->Form->hidden('Billing.maintainDiscount',array('id'=>'maintainDiscount','value'=>''));
						?>
			    </td>
			    <td width="500" height="80px" style="padding:0px;">
			    	<table height="60px">
			    		<tr>
			    			<td style="padding:0px;"> 
			    				<?php
							          echo $this->Form->input('Billing.is_discount',array('type'=>'text','legend'=>false,'label'=>false,
											'id' => 'discount','autocomplete'=>'off','style'=>'text-align:right; display:none; width:60px;',
											'value'=>$discountAmount,'readonly'=>false,'class' => 'validate[optional,custom[onlyNumber]] num'));
							          echo $this->Form->hidden('Billing.discount',array('id'=>'disc', 'value'=>''));
							    ?>
							   	<span id="show_percentage" style="display:none">%</span>
			    			</td>
			    			<td style="padding:0px;">
			    				<?php echo $this->Form->input('Billing.discount_by', array('class' => ' textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Select User',$authPerson),'id' => 'discount_authorize_by','style'=>"display:none; width:100px;",'readonly'=>false)); ?>
			    			</td>
			    			<td style="padding:0px;">
		               			<?php $disountReason = array('VIP'=>'VIP','Poor and needy'=>'Poor and needy','Hospital staff'=>'Hospital staff','Waiver'=>'Waiver','Others'=>'Others');
		                 		echo $this->Form->input('Billing.discountReason', array('class' => ' textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Select Reason',$disountReason),'id' => 'discount_reason','style'=>"display:none; width:105px;")); ?>
		                 	</td>
			    		</tr>
			    		<tr>
			    			<td style="padding:0px;" colspan="3">
			                 	<?php 
									echo $this->Html->link(__('Send request for discount'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send-approval',"style"=>"display:none;"));
									echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-approval',"style"=>"display:none;"));
									echo $this->Form->hidden('Billing.is_approved',array('value'=>0,'id'=>'is_approved'));
			                 	?>
		                 	</td>
			    		</tr>
			    	</table> 
			    </td>
			    </tr>
                
                <tr class="partialRefundRow">
			    <td>Refund : <?php echo $this->Form->input('Billing.refund',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'is_refund','title'=>'Check For Refund'));?></td>
			   
			    <td width="500" height="80px">
			    	<table height="60px">
			    		<tr>
			    			<td>
						    	<?php echo $this->Form->input('Billing.paid_to_patient',array('type'=>'text','class'=>'num','readonly'=>'readonly','id'=>'refund_amount','style'=>"display:none; "));?>
						    </td>
						    <td>
						    	<?php echo $this->Form->input('Billing.refund_authorize_by', array('class' => 'textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Please select',$authPerson),'id' => 'discount_authorize_by_for_refund','style'=>"display:none;"));?>
					        </td>
					    </tr>
			    		<tr>
						    <td></br>
						    	<?php 
						    		echo $this->Html->link(__('Send request for Refund'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send-approval-for-refund',"style"=>"display:none;"));
					                echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-refund-approval',"style"=>"display:none;"));
					                echo $this->Form->hidden('Billing.is_refund_approved',array('value'=>0,'id'=>'is_refund_approved'));
					             ?>
						    </td>
			   			 </tr>
			   		</table>
			   	</td>
			   	 <td width="165">
			    	<?php 
			    		  echo $this->Form->hidden('Billing.hrefund',array('id'=>'hrefund','value'=>''));
			    		  echo $this->Form->hidden('Billing.maintainRefund',array('id'=>'maintainRefund','value'=>''));
			    		  echo $this->Form->hidden('Billing.refundIds',array('id'=>'refundIds','value'=>''));
			    	?>
			    </td>
			   	</tr>
                
                
                 <tr>
                <td height="35" class="tdLabel2"><strong>Balance</strong></td>
                <td> <?php echo $this->Form->input('Billing.amount_pending',array('readonly'=>'readonly','value' => $this->Number->format(ceil($totalAmountPending-$dAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totalamountpending','style'=>'text-align:right;','readonly'=>'readonly'));
				  ?>
   				</td>
			   	<td>&nbsp;</td>
			 	</tr>
                
 <?php //if(($totalAmountPending >0 )/*&& $patient['Patient']['is_discharge']==1) /*|| $patient['Patient']['is_discharge']!=1*/){?>
 	<?php if($configInstance!='kanpur' /* || $configInstance=='hope'*/){?>
 	<tr>
 		<td>Move From Card</td>
   		<td><?php echo $this->Form->input('Billing.is_card',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'card_pay'));?></td>
   	</tr>
   	<tr id="patientCard" style="display:none">
	  	<td height="35" class="tdLabel2"><b>Balance In Card </b></td>
	    <td><font id="cardBal" color="green" style="font-weight: bold;"><?php echo !empty($patientCardAmt['Account']['card_balance'])?$patientCardAmt['Account']['card_balance']:'0'; ?></font>
   		</td>
		
   </tr>
   <tr id="patientCardDetails" style="display:none"><td>Amount To Be Moved From Card</td>
      <td >
   <?php if(empty($patientCardAmt['Account']['card_balance'])){
					  		$payFromCard='0';
					  	}
					  	if($patientCardAmt['Account']['card_balance']>=$totalCost){
					  		$payFromCard=$totalCost;
					  	}elseif($patientCardAmt['Account']['card_balance']<=$totalCost){
							$payFromCard=$patientCardAmt['Account']['card_balance'];
						}
						$payOtherMode=$totalCost-$payFromCard;
					  	echo $this->Form->input('Billing.patient_card',array('type'=>'text','legend'=>false,'label'=>false,'value'=>$payFromCard,'id' => 'patient_card'));?></td>
		</td>
		<td><?php echo '<b>Pay By Other Mode : <font color="red"><span id="otherPay"></span></font></b>';?></td>
		</tr>
   	<?php }?>
 	 
 	<tr>
    <td height="35" class="tdLabel2"><strong>Mode Of Payment<font color="red">*</font></strong></td>
    <td><?php 
    
    if($patient['Patient']['tariff_standard_id']!=$privatepatientID){
    	$options=array('Credit'=>'Credit','Cash'=>'Cash','Bank Deposit'=>'Bank Deposit','Cheque'=>'Cheque','Debit Card'=>'Debit Card','Credit Card'=>'Credit Card','NEFT'=>'NEFT');
    	$mandClass='';
	}else{
    	$options=array('Cash'=>'Cash','Bank Deposit'=>'Bank Deposit','Cheque'=>'Cheque','Debit Card'=>'Debit Card','Credit Card'=>'Credit Card','Credit'=>'Credit','NEFT'=>'NEFT');
    	$mandClass='validate[required,custom[mandatory-enter-only]]';
	}
    echo $this->Form->input('Billing.mode_of_payment', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:150px;',
   								'div' => false,'label' => false,/*'empty'=>__('Please select'),*/'autocomplete'=>'off',//'default'=>'Cash',
   								'options'=>$options,
    							'id' => 'mode_of_payment')); ?>
   	</td>
   	
   </tr> 
   <tr id="creditDaysInfo" style="display:none">
	   <?php if($patient['Patient']['tariff_standard_id']!=$privatepatientID){?>
	   <td height="35" class="tdLabel2">Credit Period<br /> (in days)</td>
	   <?php }else{?>
	   <td height="35" class="tdLabel2">Credit Period<font color="red">*</font><br /> (in days)</td>
	   <?php }?>
	   <td><?php echo $this->Form->input('Billing.credit_period',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'credit_period','class'=> $mandClass));?></td>
   </tr>
    
   <tr id="bankDeposite" style="display:none">
	  	<td height="35" class="tdLabel2">Bank Name<font color="red">*</font></td>
	    <td><?php echo $this->Form->input('Billing.bank_deposite',array('empty'=>__('Please select'),'options'=>$bankData,'legend'=>false,'label'=>false,'id' => 'bank_deposite',
	    		'class'=> 'validate[required,custom[mandatory-select]]'));?></td>
   </tr>
   
   
    
 
   <tr id="paymentInfo" style="display:none">
	  	<td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%" > 
			    <tr>
				    <td>Bank Name<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.bank_name',array('empty'=>__('Please select'),'options'=>$bankData,'class'=>'validate[required,custom[mandatory-select]]',
				    		'legend'=>false,'label'=>false,'id' => 'BN_paymentInfo'));?></td>
				</tr>
				<tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('Billing.account_number',array('class'=>'','type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfo'));?></td>
				</tr>
				<tr>
				    <td ><span id="chequeCredit"></span><font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.check_credit_card_number',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?></td>
			    </tr>
			    <tr>
				    <td>Date<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.cheque_date',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd','id' => 'cheque_date'));?></td>
				</tr>
		    </table>
	    </td>
   </tr>
   <tr id="neft-area" style="display:none;">
	  	<td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%"> 
			    <tr>
				    <td width="47%">Bank Name<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.bank_name_neft',array('empty'=>__('Please select'),'options'=>$bankData,'class'=>'validate[required,custom[mandatory-select]]',
				    		'legend'=>false,'label'=>false,'id' => 'BN_neftArea'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('Billing.account_number_neft',array('class'=>'','type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_neftArea'));?></td>
				</tr> 
			    <tr>
				    <td>NEFT No.<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.neft_number',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number'));?></td>
				</tr>
				    <tr>
				    <td>NEFT Date<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.neft_date',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd','id' => 'neft_date'));?></td>
				</tr>
		    </table>
	    </td>
  </tr> 
  <?php //}  ?>
          <tr>
	      <td height="35" class="tdLabel2">Remark</td>
	      <td width="200" colspan="2" class="paymentRemarkReceived"><?php echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,
	      		'id' => 'receivedRemark','cols'=>'20','rows'=>'5','value'=>'Being cash received towards  from pt. '.$patient['Patient']['lookup_name'].' against R. No.:'));
	      //echo $this->Form->input('Billing.remark', array('value'=>'','class' => ' textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'id' => 'remark'));  ?></td>
	      
	      <td width="200" colspan="2" class="paymentRemarkRefund" style="display: none"><?php echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,
	      		'id' => 'refundRemark','cols'=>'20','disabled'=>'disabled','rows'=>'5','value'=>'Being cash refunded towards  from pt. '.$patient['Patient']['lookup_name'].' against R. No.:'));  ?></td>
      	</tr>                          
        </tbody>
     	</table>
    	</td>
     </tr>
     
     <?php //if($isDischarge!=1){?>
     <tr>
        <td valign="top" style="padding-top: 15px; float:left;" > 
	 		<!--  <input class="blueBtn" type="button" value="Payment Received" id="payAmount"> -->
	 		 <?php echo $this->Html->link('Payment Received',array('controller'=>'billings','action'=>'savePaymentDetail',$patientID),
	 		 		array('class'=> 'blueBtn billingServicesAction','id'=>'payAmount','escape' => false,'label'=>false,'div'=>false));?>
	 	</td>
	 	 
	</tr>
	<tr>
        <td valign="top" align="left" style="padding-top: 15px;">&nbsp;
        	<div style="float: left; margin-top: 3px;">
				   <i id="mesage" style="display:none;">
				   	(<font color="red">Note: </font> <span id="status-approved-message"></span> )  
				   		<span class="gif" id="image-gif" style="float: right; margin: -3px 0px 0px 7px;"> </span>
				   	</i>
			  </div> 
		</td>
     </tr>
     
     <tr>
        <td valign="top" align="left" style="padding-top: 15px;">&nbsp;
        	<div style="float: left; margin-top: 3px;">
				   <i id="mesage2" style="display:none;">
				   	(<font color="red">Note: </font> <span id="status-approved-message-for-refund"></span> )  
				   		<span class="gif" id="image-gif2" style="float: right; margin: -3px 0px 0px 7px;"> </span>
				   	</i>
			  </div> 
		</td>
     </tr>
     <?php //}?>
     <tr>
		<td>&nbsp;</td>
	 </tr>
    </tbody>
</table> 
 <?php echo $this->Form->end();

 
 ?>        
</div> 
<!-- /****EOF payment details****/ -->
</div>
<?php }?>
</div>

</div>

<div id="finalPayHtml" style="display: none;">

</div>

<style>
#consultantSection {
	display: none;
}
</style>

<script> 
 
 var interval = ''; //settimeout
 var refund_interval = ''; //set time for refund 
 tariffStandardID = '<?php echo $tariffStandardID ?>';
 var instance = "<?php echo $configInstance;?>";
 var partialAmountPaid = "";
 $('.coupon').keyup(function(){ 
	    $('#validcoupon').html('');
         $('#subButton').hide();
		name = $('.coupon').val(); 
	  	  if(name.length < 6) return false;
                             $.ajax({
                                 type:'POST',
                                 url : "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "couponValidate","admin" => false));?>"+"/"+name,
                                 context: document.body,   
                                 success: function(data){ 
                                     data= jQuery.parseJSON(data);
                                     if(data[0] == 'Coupon Available' ){
                                        $('#validcoupon').html('Valid Coupon');
                                         $('#subButton').show();
                                     }else{ 
                                          $('#validcoupon').html(data);
                                         $('#subButton').hide();

                                     }
                                 }
                             }); 
	});
	 $('.saveCoupon').click(function(){
		var patientId = '<?php echo $patientID; ?>';
		var couponName = $(".coupon").val(); 
				 $.ajax({
					method : 'Post' ,
		   			url : "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "couponsave", "admin" => false));?>",
		   			data:"coupon_name="+couponName+"&id="+patientId,
                                     context: document.body,
                                     success: function(data){  
                                         window.location.reload();
                                        
			   		}
				});
		}); 
		
 $('#is_coupon').click(function(){
		if($("#is_coupon").is(':checked')){
			$('#coupon_name').show();	
		}else{
			$('#coupon_name').hide();	
		}
	});	
	
 function getListOfSubGroup(obj){
 	var currentField = $(obj);
    var fieldno = currentField.attr('fieldNo') ;
 	 $.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getListOfSubGroup", "admin" => false)); ?>"+"/"+obj.value,
			  context: document.body,				  		  
			  success: function(data){
 				  	//alert(data);
			  	data= $.parseJSON(data); 
			  	$("#service-sub-group"+fieldno+" option").remove();
			  	$("#service-sub-group"+fieldno).append( "<option value=''>Select Sub Group</option>" ); 
			  
				$.each(data, function(val, text) { 
				    $("#service-sub-group1").append( "<option value='"+val+"'>"+text+"</option>" );
				});	
			  }
		});
 
 	
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#service-group-id'+fieldno).val()+"/"+'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
				  context: document.body,				  		  
				  success: function(data){ 
 				  	data= $.parseJSON(data);
				  	$("#consultant_service_id_"+fieldno+" option").remove();
				  	$("#consultant_service_id_"+fieldno).append( "<option value=''>Select Service</option>" );
					$.each(data, function(val, text) {
					    $("#consultant_service_id_"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
					});
				  }
			});
 }

//for services copied from above
//for services radio option by swapnil 
 function getListOfSubGroupServices(obj){
	 	 
	 	var currentField =  obj ;
	    var fieldno = currentField.attr('fieldNo') ;

	    var group_id=obj.value ;
	 /*$.ajax({
				  url:"<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getListOfSubGroup", "admin" => false)); ?>"+"/"+group_id,
				  context: document.body,				  		  
				  success: function(data){
					//alert(data);
				  	data= $.parseJSON(data); 
 				  	$("#add-service-sub-group"+fieldno+" option").remove();
				  	$("#add-service-sub-group"+fieldno).append( "<option value=''>Select Sub Group</option>" ); 
				  
					$.each(data, function(val, text) { 
					    $("#add-service-sub-group"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
					});	
				  }
			});
	 
	 
			$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+group_id+"/",
				  context: document.body,				  		  
				  success: function(data){ 
				  	data= $.parseJSON(data);
 				  	$("#service_id"+fieldno+" option").remove();
				  	$("#service_id"+fieldno).append( "<option value=''>Select Service</option>" );
					$.each(data, function(val, text) {
					    $("#service_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
					});
				  }
			});*/
	 }
 
       // var pager = new Pager('serviceGrid', 20); 
        //pager.init(); 
        //pager.showPageNav('pager', 'pageNavPosition'); 
        //pager.showPage(1);
		
	 function categoryChange(obj){ 
		var currentField = $(obj);
    	var fieldno = currentField.attr('fieldNo') ;
		 $("#amountConsultant_"+fieldno).val('');
		 $("#doctor_id_"+fieldno).val('Please Select');
		 $("#charges_type_"+fieldno).val('Please Select');
		 $.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getDoctorList", "admin" => false)); ?>"+"/"+$('#category_id_'+fieldno).val(),
			  context: document.body,				  		  
			  success: function(data){
				  
			  	data= $.parseJSON(data);
			  //console.log(data);
			  	$("#doctor_id_"+fieldno+" option").remove();
			  	$("#doctor_id_"+fieldno).append( "<option value=''>Please Select</option>" );
				$.each(data, function(val, text) {
					$("#doctor_id_"+fieldno).append( "<option value='"+text+"'>"+val+"</option>" );
				});
				//$('#doctor_id'+fieldno).attr('disabled', '');					  			
			    		
			  }
		});
     }
     function serviceSubGroup(obj){
	 	var currentField = $(obj);
    	var fieldno = currentField.attr('fieldNo') ;
			$("#amount"+fieldno).val(''); 
			
				$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices","admin" => false)); ?>"+"/"+$('#service-group-id'+fieldno).val()+"/"+$('#service-sub-group'+fieldno).val()+'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
					  context: document.body,				  		  
	 				  success: function(data){ 
					  	data= $.parseJSON(data);
					  	$("#consultant_service_id_"+fieldno+" option").remove();
					  	$("#consultant_service_id_"+fieldno).append( "<option value=''>Select Service</option>" );
						$.each(data, function(val, text) {
						    $("#consultant_service_id_"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
						});
					  }
				});
			
		 } 


	 //for services copied fron above
	 
     function serviceSubGroups(obj){
 	 	var currentField = $(obj);
     	var fieldno = currentField.attr('fieldNo') ;
 			$("#amount"+fieldno).val(''); 
 			
 				$.ajax({
 					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#add-service-group-id'+fieldno).val()+"/"+$('#add-service-sub-group'+fieldno).val()+'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
 					  context: document.body,				  		  
 					  success: function(data){ 
 					  	data= $.parseJSON(data);
 	 				  	$("#service_id_"+fieldno+" option").remove();
 					  	$("#service_id_"+fieldno).append( "<option value=''>Select Service</option>" );
 						$.each(data, function(val, text) {
 						    $("#service_id_"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
 						});
 					  }
 				});
 			
 		 } 
		 
	//cost of consutatnt
	  function consultant_service_id(obj){
	   var currentField = $(obj);
    	var fieldno = currentField.attr('fieldNo') ;
			$("#amountConsultant_"+fieldno).val(''); 
				var tariff_standard_id ='<?php echo $patient['Patient']['tariff_standard_id'];?>';
				$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantCost", "admin" => false)); ?>"+"/"+$(obj).val()+"/"+tariff_standard_id,
					  context: document.body,				  		  
					  success: function(data){ 
	 				  	data= $.parseJSON(data);
					  	$("#amountConsultant_"+fieldno).val(data.tariff_amount);
					  	$("#hospital_cost").val(''); 
					  	$("#hospital_cost_area").find('span').each(function(){ 
		 	 			 	$("#"+$(this).attr('id')).hide();
		 			    });
					  	$("#private").html(data.private);
					  	$("#cghs").html(data.cghs);
					  	$("#other").html(data.other);
					  }
				});
			
		 } 


	//cost for services
	
	  function service_id(obj){
		   var currentField = $(obj);
	    	var fieldno = currentField.attr('fieldNo') ;
				$("#amount"+fieldno).val(''); 
					var tariff_standard_id ='<?php echo $patient['Patient']['tariff_standard_id'];?>';
					$.ajax({
						  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantCost", "admin" => false)); ?>"+"/"+$(obj).val()+"/"+tariff_standard_id,
						  context: document.body,				  		  
						  success: function(data){ 
						  	data= $.parseJSON(data);
	 					  	//alert(data.tariff_amount);
						  	$("#service_amount"+fieldno).val(data.tariff_amount);
						  	$("#hospital_cost").val(''); 
						  	$("#hospital_cost_area").find('span').each(function(){ 
			 	 			 	$("#"+$(this).attr('id')).hide();
			 			    });
						  	$("#private").html(data.private);
						  	$("#cghs").html(data.cghs);
						  	$("#other").html(data.other);
						  }
					});
				
			 } 
		 
		 
      function doctor_id(obj){
	 	var currentField = $(obj);
    	var fieldno = currentField.attr('fieldNo') ;
    	 $("#amountConsultant_"+fieldno).val(''); 
    	 $("#charges_type_"+fieldno).val('Please Select');
     } 


        if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque' || $("#mode_of_payment").val() == 'Debit Card'){
	 		 $("#paymentInfo").show();
	 		 $("#creditDaysInfo").hide();
	 		 $('#neft-area').hide();
	 		 $('#bankDeposite').hide();
	 	}else if($("#mode_of_payment").val() == 'Credit') {
	 	 	$("#creditDaysInfo").show();
	 	 	$("#paymentInfo").hide();
	 	 	$('#neft-area').hide();
	 	 	$('#bankDeposite').hide();
	 	}else if($('#mode_of_payment').val()=='NEFT') {
	 	    $("#creditDaysInfo").hide();
	 		$("#paymentInfo").hide();
	 		$('#neft-area').show();
	 		$('#bankDeposite').hide();
	 	}else if($('#mode_of_payment').val()=='Bank Deposit') {
	 	    $("#creditDaysInfo").hide();
	 		$("#paymentInfo").hide();
	 		$('#neft-area').hide();
	 		$('#bankDeposite').show();
	 	}else if ($('#mode_of_payment').val()=='Patient Card'){
	 		 $("#patientCard").show();
	 		 $("#paymentInfo").hide();
	 		 $("#creditDaysInfo").hide();
	 		 $('#neft-area').hide();
	 		 $('#bankDeposite').hide();
	 	}
   	
      $("#mode_of_payment").change(function(){

          $('#chequeCredit').html($(this).val()+' No.');
          
			if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque' || $("#mode_of_payment").val() == 'Debit Card'){
				 $("#patientCard").hide();
				 $("#paymentInfo").show();
				 $("#creditDaysInfo").hide();
				 $('#neft-area').hide();
				 $('#bankDeposite').hide();
			} else if($("#mode_of_payment").val() == 'Credit') {
				$("#patientCard").hide();
			 	$("#creditDaysInfo").show();
			 	$("#paymentInfo").hide();
			 	$('#neft-area').hide();
			 	$('#bankDeposite').hide();
			} else if($('#mode_of_payment').val()=='NEFT') {
				$("#patientCard").hide();
			    $("#creditDaysInfo").hide();
				$("#paymentInfo").hide();
				$('#neft-area').show();
				$('#bankDeposite').hide();
			}else if($('#mode_of_payment').val()=='Bank Deposit') {
				$("#patientCard").hide();
			    $("#creditDaysInfo").hide();
				$("#paymentInfo").hide();
				$('#neft-area').hide();
				$('#bankDeposite').show();
			}else if ($('#mode_of_payment').val()=='Patient Card'){
				 $("#patientCard").show();		 		 
		 		 $("#paymentInfo").hide();
		 		 $("#creditDaysInfo").hide();
		 		 $('#neft-area').hide();
		 		 $('#bankDeposite').hide();
		 		 var amt=$('#amount').val();
		 		 var patCard=$('#patient_card').val()
		 		 if(amt>patCard){
			 		 alert('Insufficient Funds In Patient Card');
			 		 $('#mode_of_payment').val('Cash');
			 		 $("#patientCard").hide();			 		
			 		 $('#amount').val('');
			 		 $("#busy-indicator").hide();
			 		 return false;		 
		 		 }
		 	}else{
		 		 $("#patientCard").hide();
				 $("#creditDaysInfo").hide();
				 $("#paymentInfo").hide();
				 $('#neft-area').hide();
				 $('#bankDeposite').hide();
			}
	 });

      
      $("#payAmount").click(function(){
    	var validatePerson = jQuery("#paymentDetail").validationEngine('validate'); 
  	 	if(!validatePerson){
  		 	return false;
  		}

  	 	if($('#mode_of_payment').val()=='Credit'){
			alert('Please Select Valid Mode of Payment. You have Selected Credit Mode.');
			$('#mode_of_payment').focus();
			return false;
  	  	}
  		
        is_refund_approved = parseInt($("#is_refund_approved").val());
        is_approved = parseInt($("#is_approved").val());

        if($("#amount").val()=='0'){//to not allow 0 payment  --yashwant
        	$("#amount").val('');
        }
        
        if($("#is_refund").is(":checked")){
			  if($("#amount").val()=='' && $("#discount").val()=='' && $("#refund_amount").val()==''){
				  alert('Please pay some amount.');
				  return false;
			  }
		  }else{
			  if($("#amount").val()=='' && $("#discount").val()==''){
				  alert('Please pay some amount.');
				  return false;
			  }
		  }
		  
        if(is_refund_approved == 1){
            alert("Could not be saved, please wait for approval confirmation");
            return false;
        }
        if(is_approved == 1){
            alert("Could not be saved, please wait for approval confirmation");
            return false;
        }

        if(is_approved == 3){
            alert("Your Request has been cancelled by User,\nplease cancel the approval request to save..");
            return false;
        }
          /*alert($('#payment_category').val());
          return false;*/
        var amountPaid=$('#amount').val();  
		var patient_id='<?php echo $patientID;?>';
		//var groupID=$('#serviceGroupId').val(); not working after discharge hence commented
		var groupID=$('#payment_category').val();
		/*var validatePerson = jQuery("#paymentDetail").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}*/
	 	/*if(amountPaid=='0' || amountPaid==''){
		 	alert('Please pay amount.');
		 	return false;
		}*/
		
		formData = $('#paymentDetail').serialize();
		
			$.ajax({
				  type : "POST",
				  data: formData,
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "savePaymentDetail", "admin" => false)); ?>"+'/'+patient_id,
				  context: document.body,
				//  data:"mapTarget="+icd_id+"&diagnoses_name="+diagnoses_name+"&patient_id="+patient_id+"&id="+dia_id+"&patient_info="+patientInfo,
				  success: function(data){ 	
					  $("#paymentDetail").trigger('reset');
					  getbillreceipt(patient_id);
					  if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='pharmacy_radio'){
						  getPharmacyData(patient_id,'<?php echo $tariffStandardID ;?>');
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='otpharmacy_radio'){
						  getOtPharmacyData(patient_id,'<?php echo $tariffStandardId ?>');
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='laboratory_radio'){
						  getLabData(patient_id,'<?php echo $tariffStandardId ?>');
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='radiology_radio'){
						  getRadData(patient_id,'<?php echo $tariffStandardId ?>');
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='surgery_radio'){
						  getProcedureData(patient_id,'<?php echo $tariffStandardId ?>');
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='roomtariff_radio'){
						  getDailyRoomData(patient_id,'<?php echo $tariffStandardId ?>');
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='consultant_radio'){
						  getConsultationData(patient_id,'<?php echo $tariffStandardId ?>');
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='blood_radio'){
						  getBloodData(patient_id,groupID);
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='implant_radio'){
						  getImplantData(patient_id,groupID);
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='otherservices_radio'){
						  getOtherServiceData(patient_id,groupID);
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='radiotheraphy_radio'){
						  getRadiotheraphyData(patient_id,groupID);
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='ward_radio'){
						  getWardData(patient_id,groupID);
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='privatepackage_radio'){
						  getPackageData(packagedPatientId);
					  }else{ 
						  if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')== 'mandatoryservices_radio'){
							   //$('#amount').attr('readonly',true);
							   $("#servicesSection").show();
							   getServiceData('<?php echo $patientID;?>',groupID,'mandatoryservices');
						   }else{
							   $("#servicesSection").show();
							  // $('#amount').attr('readonly',true);
							   getServiceData('<?php echo $patientID;?>',groupID);
						   }
						  //getServiceData(patient_id,groupID);
					  } 

					  $('#payAmount').show();
					  $("#creditDaysInfo").hide();
					  $("#neft-area").hide();
					  $("#paymentInfo").hide();
					  $("#busy-indicator").hide();	
					  $('#bankDeposite').hide();
					  	
					  $("#receivedRemark").prop("disabled",false);
					  $("#refundRemark").prop("disabled",true);

					  // Patient card  detail
					   	 $("#card_pay").attr("checked",false);
						 $('#patient_card').val('');
						 $("#patientCard").hide();
						 $("#patientCardDetails").hide();

						 resetPaymentDetail();
				  },
				  beforeSend:function(){
					  $("#busy-indicator").show();
					  $('#payAmount').hide();
				  },		  
			});
		//return true;  
      });

      $( "#discharge_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
			maxDate : new Date(),
			onSelect:function(){$(this).focus();}
		});

      $( ".lab_order_date" ).datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['discharge_date']); ?>),
			onSelect:function(){$(this).focus();}
		});

      $(".radDate").datepicker(
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
    		minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
    		maxDate:new Date(),
    		onSelect:function(){$(this).focus();}
    	});

      $(".galleryDate").datepicker(
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
    	    		minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
    	    		maxDate:new Date(),
    	    		onSelect:function(){$(this).focus();}
    	    	});

      
      
      $(".labDate").datepicker(
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
  				minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
  				maxDate:new Date(),
  				onSelect:function(){$(this).focus();}
  	});
      	

      $( "#neft_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
		//	minDate:new Date(<?php //echo $this->General->minDate($wardInDate) ?>),
			onSelect:function(){$(this).focus();}
		});

      $( "#cheque_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			//minDate:new Date(<?php //echo $this->General->minDate($wardInDate) ?>),
			onSelect:function(){$(this).focus();}
		});

     //save services
     $(function(){jQuery("#servicefrm").validationEngine({promptPosition : "topLeft", autoPositionUpdate: true});});
      $("#ServiceBillsData").click(function(){
        groupID=$('#serviceGroupId').val();
		
    	var validatePerson = jQuery("#servicefrm").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
 
	 	$('.onlyServiceId').each(function(){ 
			if($(this).val() == ''){
				alert('This service is not exist, Please enter another service.');
				isOk=false;
				var lastId = $( ".service_id" ).last().attr( "id" );
				idCounter=lastId.split('_');
				$('#service_id_'+idCounter[2]).val('');
				$('#onlyServiceId_'+idCounter[2]).val('');
				return false;
			}else{
				isOk=true;
				return true;
			}
		});

	 	if(isOk){
  		var patient_id='<?php echo $patientID;?>';
  		var primaryCareProvider=$('#allDoctorList').val();
  		
  		formData = $('#servicefrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id+'?doctor_id='+primaryCareProvider,
  				  context: document.body,
  				  success: function(data){ 
  					$("#servicefrm").trigger('reset');
  					$(".serviceAddMoreRows").remove();
  					$(".amount").html('');
  					//if(groupID=='1'){
  					
  					if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='mandatoryservices_radio'){
  	  					getServiceData(patient_id,groupID,'mandatoryservices');	
  					}else{
  						getServiceData(patient_id,groupID);	
  	  				}
  					 
  					getbillreceipt(patient_id);
  					$("#busy-indicator").hide();
  					$("#ServiceBillsData").show();
  				  },
  				  beforeSend:function(){
  	  				  $("#busy-indicator").show();
  	  				  $("#ServiceBillsData").hide();
  	  				  },		  
  			});
  		//return true; 
	 	} 
        });

      function getServiceData(patient_id,groupID,isMandatory,isDefault){
    	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxServiceData","admin" => false)); ?>"+'/'+patient_id+'?groupID='+groupID+'&isMandatory='+isMandatory;
          $.ajax({
          	beforeSend : function() {
              	loading();
          		$("#busy-indicator").show();
            	},
          type: 'POST',
          url: ajaxUrl,
          dataType: 'html',
          success: function(data){
         	if(isMandatory=='mandatoryservices'){
         		$("#servicesSection").show();
           	}else{
           		$("#servicesSection").show();
         	}
        	
        	$('.amount').html('');
        	if(isDefault!='default')
        		$('#service_id_1').focus();
          	//onCompleteRequest("outerDiv","class");
          	$("#busy-indicator").hide();
          	onCompleteRequest();
          	if(data!=''){        
          		$("#servicefrm").trigger('reset');
            	$(".onlyServiceId").val('');//resetting hidden field of serviceId  --yashwant
            	$(".serviceAddMoreRows").remove();
            	$('#newLayout').show();
        		$('#finalPayHtml').hide();   		  
         		$('#globalDivId').html(data);
         		//discountApproval();
         		//RefundApproval();
         		// medCount = $("#noMeddisable").val() ;
          	}
          },
  		});
      }
      
	 //EOF save services
	 
	 
	 //save consultation for opd
	 $("#saveConsultantBillData").click(function(){
    	var validatePerson = jQuery("#ConsultantBillingNew").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}

	 	$('.onlyConsultantServiceId').each(function(){ 
			if($(this).val() == ''){
				alert('This Consultant service is not exist, Please enter another Consultant service.');
				isOk=false;
				var lastId = $( ".consultant_service_id" ).last().attr( "id" );
				idCounter=lastId.split('_');
				$('#consultant_service_id_'+idCounter[3]).val('');
				$('#onlyConsultantServiceId_'+idCounter[3]).val('');
				return false ;
			}else{
				isOk=true;
				return true;
			}
		});

		if(isOk){
  		var patient_id='<?php echo $patientID;?>';
  		
  		formData = $('#ConsultantBillingNew').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "consultantBilling", "admin" => false)); ?>"+'/'+patient_id+'?Flag=consultaionBill',
  				  context: document.body,
  				  success: function(data){ 
  					$("#ConsultantBillingNew").trigger('reset');
  					$(".consultantAddMoreRows").remove();
  					//$(".amount").html('');
  	  				getConsultationData(patient_id,'<?php echo $tariffStandardID ?>');
  	  				getbillreceipt(patient_id);	
  					$("#busy-indicator").hide();
  					$("#saveConsultantBillData").show();			  
  				  },
  				  beforeSend:function(){
  	  				  $("#busy-indicator").show();
  	  				  $("#saveConsultantBillData").hide();
  	  				  },		  
  			});
		}
        });

	 function getConsultationData(patient_id,tariffStandardId){
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxConsultationData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId;
	   	$.ajax({
	     	beforeSend : function() {
	         	//loading("outerDiv","class");
	     		$("#busy-indicator").show();
	       	},
	     type: 'POST',
	     url: ajaxUrl,
	     dataType: 'html',
	     success: function(data){
	     	//onCompleteRequest("outerDiv","class");
	     	$("#busy-indicator").hide();
	     	if(data!=''){
	     		 $("#ConsultantBillingNew").trigger('reset');
	     		 $(".onlyConsultantServiceId").val('');//resetting hidden consultant serviceID  --yashwant
				 $(".consultantAddMoreRows").remove();
				 $('#newLayout').show();
         		 $('#finalPayHtml').hide();
    			 $('#globalDivId').html(data);
    			 //discountApproval();
    			 //RefundApproval();
    			// medCount = $("#noMeddisable").val() ;
	     	}
	     },
		});
     }
	 
	//EOF save consultation for opd
	
	// save lab
	$("#saveLabBill").click(function(){ 
    	var validatePerson = jQuery("#labServices").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}

	 	$('.labid').each(function(){ 
			if($(this).val() == ''){
				alert('This lab is not exist, Please enter another lab.');
				isOk=false;
				var lastId = $( ".test_name" ).last().attr( "id" );
				idCounter=lastId.split('_');
				$('#test_name_'+idCounter[2]).val('');
				$('#labid_'+idCounter[2]).val('');
				return false;
			}else{
				isOk=true;
				return true;
			}
		});

	 	if(isOk){
  		var patient_id='<?php echo $patientID;?>';
  		var primaryCareProvider=$('#allDoctorList').val();
  		formData = $('#labServices').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "addLab", "admin" => false)); ?>"+'/'+patient_id+'?doctor_id='+primaryCareProvider,
  				  context: document.body,
  				  success: function(data){ 
  					$("#labServices").trigger('reset');
  					$(".labAddMoreRows").remove();
  					//$(".amount").html('');
  	  				getLabData(patient_id);	
  	  				getbillreceipt(patient_id);
  	  				
  					$("#busy-indicator").hide();
  					$("#saveLabBill").show();
  				  },
  				  beforeSend:function(){
  	  				  $("#busy-indicator").show();
  	  				  $("#saveLabBill").hide();
  	  				  },		  
  			});
	 	}
        });

	 function getLabData(patient_id,ID){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxLabData","admin" => false)); ?>"+'/'+patient_id;
	         $.ajax({
	         	beforeSend : function() {
	             	//loading("outerDiv","class");
	         		$("#busy-indicator").show();
	           	},
	         type: 'POST',
	         url: ajaxUrl,
	         dataType: 'html',
	         success: function(data){
	         	//onCompleteRequest("outerDiv","class");
	         	$("#busy-indicator").hide();
	         	onCompleteRequest();
	         	if(data!=''){
	         			 $("#labServices").trigger('reset');//resetting addmore form on clicking radio button --yashwant
	         			 $(".labid").val('');//resetting hidden field of labid on clicking radio button --yashwant
	         			 $(".labAddMoreRows").remove();
	         			 $('#newLayout').show();
		         		 $('#finalPayHtml').hide();
	        			 $('#globalDivId').html(data);
	        			 //discountApproval();
	        			 //RefundApproval();
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }

	 	function getLabDetail(patient_id,ID){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "addLab","admin" => false)); ?>"+'/'+patient_id;
	         $.ajax({
	         	beforeSend : function() {
	             	//loading("outerDiv","class");
	         		$("#busy-indicator").show();
	           	},
	         type: 'POST',
	         url: ajaxUrl,
	         dataType: 'html',
	         success: function(data){
	         	//onCompleteRequest("outerDiv","class");
	         	$("#busy-indicator").hide();
	         	if(data!=''){
	        			 $('#orderArea_'+ID).html(data);
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }

	 $(document).on('click','.orderText', function() {  
	 	currentid=$(this).attr('id');
		splitedVar=currentid.split('_');
		ID=splitedVar[1];  
		var visibility =  $('#orderArea_'+ID).is(':visible') ; 		
		$('#orderArea_'+ID).toggle(); 
		if(visibility == false && $('#orderArea_'+ID).attr('isVisible') !='yes'){ //call only if form is now there 
			getLabDetail('<?php echo $patientID;?>',ID);
			$('#orderArea_'+ID).attr('isVisible','yes') ;
		} 
	 });

	patientID='<?php echo $patientID;?>';
	 	 
	 $(document).on('focus','.test_name', function() {
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['2'];
	//$('.test_name').on('keyup.autocomplete', function(){
		$(this).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "labChargesAutocomplete","admin" => false,"plugin"=>false)); ?>"+'/'+patientID+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
				 minLength: 1,
				 select: function( event, ui ) { 
					$('#labAomunt_'+ID).val('');
					$('#lfix_discount_'+ID).val('');
					$('#labid_'+ID).val(ui.item.id);
					charges=ui.item.charges;
					valueRes=ui.item.value;
					<?php  if(strtolower($this->Session->read('role'))==strtolower(Configure::read('Senior_RGJAY')) ||
						        	strtolower($this->Session->read('role'))==strtolower('admin')) { ?>
					skipCharge='yes'; //added by w
					<?php } ?>
					if(charges == '0'){
						charges ='';
					}
					var websiteInstance='<?php echo $configInstance;?>';
					if(websiteInstance == 'vadodara'){
						if(valueRes=='Lab Charge' || valueRes=='Histo Lab Charge'){
							$('#labAomunt_'+ID).attr('readonly',false);
						}else{
							$('#labAomunt_'+ID).attr('readonly',true);
						}
					}
					if(charges !== undefined && charges !== null && charges !== '' || skipCharge=='yes'){
						if(charges){
							charges = charges.replace(/,/g, '');
							$('#labAomunt_'+ID).val($.trim(charges));
							$('#lfix_discount_'+ID).val(ui.item.fix_discount);
							//if(ui.item.id != '');
							$( '.labServiceAmount').trigger("change");
						}
					}else{
						$('#labAomunt_'+ID).val('');
						$('#lfix_discount_'+ID).val('');
						$('#totalLabAmount').html('');
						inlineMsg(currentId,errorMsg,10);
					}
				 },
				 messages: {
				        noResults: '',
				        results: function() {},
				 }
			});
		
	 });
	 			
	 var counter=2;
	 $(document).on('click','.addMoreLab', function() {
			var newCounter=counter-1;
		 	if($('#labid_'+newCounter).val()==''){
				alert('This Lab is not exist. Please enter another Lab.');
				$('#test_name_'+newCounter).val('');
				$('#labid_'+newCounter).val('');
				return false;
			}else{ 
				addMoreLabHtml();
			}	
	 });

	 function addMoreLabHtml(){

		//making amount fields readonly in all groups
		var websiteInstance='<?php echo $configInstance;?>'; 
		if(websiteInstance=='kanpur'){
			var appendOption="";
		}else{
			var appendOption= "<option value=''>None</option>";//"$('<option value="">').text('None')";
		}

		var today = new Date();
		var todayDate=today.format('d/m/Y H:i:s');
		 
		$("#labOrderArea")
			.append($('<tr>').attr({'id':'orderRowNew_'+counter,'class':'labAddMoreRows'})
				.append($('<td id=billableLab_'+counter+'>').append($('<input>').attr({'id':'isBillable_'+counter,'class':'textBoxExpnd','type':'checkbox','name':'LaboratoryTestOrder[is_billable][]','value' : '1'})))
				.append($('<td>').append($('<input>').attr({'readonly':'readonly','id':'labDate_'+counter,'class':'textBoxExpnd labDate','type':'text','name':'LaboratoryTestOrder[start_date][]','value':todayDate})))
				.append($('<td>').append($('<input>').attr({'id':'test_name_'+counter,'placeholder':'Lab Search','class':'validate[required,custom[mandatory-enter]] textBoxExpnd AutoComplete test_name','type':'text','name':'LaboratoryTestOrder[lab_name][]'}))
						.append($('<input>').attr({'id':'labid_'+counter,'class':'textBoxExpnd labid','type':'hidden','name':'LaboratoryTestOrder[laboratory_id][]'}))
						//.append($('<span>').attr({'class':'orderText','id':'orderText_'+counter,'style':'float:right; cursor: pointer;','title':'Order Detail'}).append($('<strong>...</strong>')))
						)
	    		.append($('<td>').append($('<select>').attr({'id':'service_provider_id_'+counter,'class':'textBoxExpnd externalRequisition','type':'select','name':'LaboratoryTestOrder[service_provider_id][]'}).append(appendOption)))
	    		.append($('<td>').append($('<input>').attr({'readonly':'readonly','style':'text-align:right','id':'labAomunt_'+counter,'class':'textBoxExpnd validate[required,custom[mandatory-enter]] labServiceAmount','type':'text','name':'LaboratoryTestOrder[amount][]'}))
	    				.append($('<input>').attr({'id':'lfix_discount_'+counter,'class':'fix_discount','type':'hidden','name':'LaboratoryTestOrder[fix_discount][]'}))
	    	    		)
	    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd ','type':'text','name':'LaboratoryTestOrder[description][]'})))
	    		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
    					.attr({'class':'removeButton','id':'removeButton_'+counter,'title':'Remove current row'}).css('float','right')))
    			);	
	    	//.append($('<tr>').attr({'id':'orderRow_'+counter,'class':'labAddMoreRows'})
						//.append($('<td>').attr({'style':'display: none','id':'orderArea_'+counter,'class':'orderArea','colspan':'6'})))		
	    	
	   		var selectExtReq = <?php echo json_encode($serviceProviders);?>;
		   		$.each(selectExtReq, function (key, value) {
		   			$('#service_provider_id_'+counter).append( new Option(value, key) );
			});

			/*if(websiteInstance != 'kanpur'){ //DO NOT REMOVE COMMENTED CODE --YASHWANT
				$('#labAomunt_'+counter).attr('readonly',false);
			}else{
				$('#labAomunt_'+counter).attr('readonly',true);
			}*/
				
			//removing first td for "non private packaged patient"
			if(!isPackagedPatient)
				$('td#billableLab_'+counter).remove();
			$('#test_name_'+counter).focus();//taking focus on sevice field
		 	counter++;

		 $(".labDate").datepicker(
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
  				defaultDate: new Date(),
  				minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
  				maxDate:new Date(),
  				onSelect:function(){$(this).focus();}
  			});

		 
	 }

	 
	 	
	 $(document).on('click','.removeButton', function() {
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$("#orderRowNew_"+ID).remove();
			$( '.labServiceAmount').trigger("change"); //to maintain total lab amount  --yashwant
			 
	 });	
	// Eof save lab

	//BOF on key up enter event to add new row
	$(document).on('keypress','.test_name', function(event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		currentID=$(this).attr('id');
		splitedVar=currentID.split('_');
		ID=splitedVar[2]; 
		selVal = $('#labid_'+ID).val();
		if(keycode == '13' && selVal != '' ){ 
			if(selVal) //addnew row only if selection is done 
			addMoreLabHtml();//insert new row 
		}
		
	});
	//EOF enter event by pankaj 
	/// save radiology
	
	 var counRad=2;
	 $(document).on('click','.addMoreRad', function() {  

		 	var newCounterRad=counRad-1;
		 	if($('#radiologytest_'+newCounterRad).val()==''){
				alert('This Radiology is not exist. Please enter another Radiology.');
				$('#radiologyname_'+newCounterRad).val('');
				$('#radiologytest_'+newCounterRad).val('');
				return false;
			}else{
				addMoreRadHtml() ; 
			}
	 });
	 
	 //BOF on key up enter event to add new row
		$(document).on('keypress','.radiology_name', function(event) {
			var keycode = (event.keyCode ? event.keyCode : event.which);
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
			ID=splitedVar[1]; 
			selVal = $('#radiologytest_'+ID).val();
			if(keycode == '13' && selVal != '' ){ 
				if(selVal) //addnew row only if selection is done 
				addMoreRadHtml();//insert new row 
			}
			
		});
		//EOF enter event by pankaj 
		
		
	
	

	 function addMoreRadHtml(){
		//making amount fields readonly in all groups
		var websiteInstance='<?php echo $configInstance;?>';	
		if(websiteInstance=='kanpur'){
			var appendRadOption= "";
		}else{
			var appendRadOption= "<option value=''>None</option>";
		}

		var today = new Date();
		var todayDate=today.format('d/m/Y H:i:s');
			
		 $("#RadiologyArea")
			    .append($('<tr>').attr({'id':'radiologyRow_'+counRad,'class':'radAddMoreRows'})
				.append($('<td id=billableRad_'+counter+'>').append($('<input>').attr({'id':'isBillable_'+counRad,'class':'textBoxExpnd','type':'checkbox','name':'data[RadiologyTestOrder][is_billable][]','value' : '1'})))
				.append($('<td>').append($('<input>').attr({'readonly':'readonly','id':'radDate_'+counRad,'class':'textBoxExpnd radDate','type':'text','name':'data[RadiologyTestOrder][radiology_order_date][]','value':todayDate})))
				.append($('<td>').append($('<input>').attr({'id':'radiologyname_'+counRad,'class':'validate[required,custom[mandatory-enter]] radiology_name textBoxExpnd','type':'text','name':'data[RadiologyTestOrder][rad_name][]'}))
				.append($('<input>').attr({'id':'radiologytest_'+counRad,'class':'textBoxExpnd radiology_test','type':'hidden','name':'data[RadiologyTestOrder][radiology_id][]'}))
			  //.append($('<span>').attr({'class':'radOrderText','id':'radOrderText_'+counRad,'style':'float:right; cursor: pointer;','title':'Radiology Order Detail'}).append($('<strong>...</strong>')))
						)
	    		.append($('<td>').append($('<select>').attr({'id':'service_provider_id'+counRad,'class':'textBoxExpnd ','type':'select','name':'data[RadiologyTestOrder][service_provider_id][]'}).append(appendRadOption)))
	    		.append($('<td>').append($('<input>').attr({'readonly':'readonly','style':'text-align:right','id':'radAomunt_'+counRad,'class':'textBoxExpnd radAomunt validate[required,custom[mandatory-enter]] radServiceAmount','type':'text','name':'data[RadiologyTestOrder][amount][]'}))
	    				.append($('<input>').attr({'id':'rfix_discount_'+counRad,'class':'fix_discount','type':'hidden','name':'data[RadiologyTestOrder][fix_discount][]'})))
	    		.append($('<td>').append($('<input>').attr({'id':'description_'+counRad,'class':'textBoxExpnd description','type':'text','name':'data[RadiologyTestOrder][description][]'})))
	    		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
    					.attr({'class':'removeRadiology','id':'removeRadiology_'+counRad,'title':'Remove current row'}).css('float','right')))
				)
    		//.append($('<tr>').attr({'id':'orderRad_'+counRad,'class':'radAddMoreRows'})
					//	.append($('<td>').attr({'style':'display: none','id':'radOrderArea_'+counRad,'class':'radOrderArea','colspan':'6'})))		
	    	
	    	var selectExtReq = <?php echo json_encode($radServiceProviders);?>;
	   		$.each(selectExtReq, function (key, value) {
	   			$('#service_provider_id'+counRad).append( new Option(value, key) );
			});

	   		/*if(websiteInstance != 'kanpur'){  //DO NOT REMOVE COMMENTED CODE --YASHWANT
				$('#radAomunt_'+counter).attr('readonly',false);
			}else{
				$('#radAomunt_'+counter).attr('readonly',true);
			}*/
			
	   		//removing first td for "non private packaged patient"
			if(!isPackagedPatient)
				$('td#billableRad_'+counter).remove();
	   		$('#radiologyname_'+counRad).focus();//taking focus on sevice field
		 	counRad++;

			 $(".radDate").datepicker(
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
	  				defaultDate: new Date(),
	  				minDate:new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
	  				maxDate:new Date(),
	  				onSelect:function(){$(this).focus();}
	  			});
		 }
	 	
	 $(document).on('click','.removeRadiology', function() {
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$("#radiologyRow_"+ID).remove();
			$('.radServiceAmount').trigger("change"); //to maintain total lab amount  --yashwant
			
			 
	 });


	 $(document).on('focus','.radiology_name', function() {
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$(this).autocomplete({
				 source: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "radChargesAutocomplete","admin" => false,"plugin"=>false)); ?>"+'/'+patientID+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
					 minLength: 1,
					 select: function( event, ui ) { 
						$('#radAomunt_'+ID).val('');
						$('#rfix_discount_'+ID).val('');
						charges= ui.item.charges;
						if(charges == '0'){
							charges ='';
						}
						$('#radiologytest_'+ID).val(ui.item.id);
						if(charges !== undefined && charges !== null && charges !== ''){
							charges = charges.replace(/,/g, '');
							$('#radAomunt_'+ID).val($.trim(charges));
							$('#rfix_discount_'+ID).val(ui.item.fix_discount);
							$('.radServiceAmount').trigger("change");
						}else{
							$('#radAomunt_'+ID).val('');
							$('#rfix_discount_'+ID).val('');
							$('#totalRadAmount').html('');
							inlineMsg(currentId,errorMsg,10);
						}
					 },
					 messages: {
					        noResults: '',
					        results: function() {},
					 }
				});
		 });

		 


	 $("#saveRadBill").click(function(){ 
	    	var validatePerson = jQuery("#radServices").validationEngine('validate'); 
		 	if(!validatePerson){
			 	return false;
			}

		 	$('.radiology_test').each(function(){ 
				if($(this).val() == ''){
					alert('This radiology is not exist, Please enter another radiology.');
					isOk=false;
					var lastId = $( ".radiology_name" ).last().attr( "id" );
					idCounter=lastId.split('_');
					$('#radiologyname_'+idCounter[1]).val('');
					$('#radiologytest_'+idCounter[1]).val('');
					return false;
				}else{
					isOk=true;
					return true;
				}
			});

			if(isOk){
	  		var patient_id='<?php echo $patientID;	?>';
	  		var primaryCareProvider=$('#allDoctorList').val();
	  		formData = $('#radServices').serialize();
	  			$.ajax({
	  				  type : "POST",
	  				  data: formData,
	  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "addRad", "admin" => false)); ?>"+'/'+patient_id+'?doctor_id='+primaryCareProvider,
	  				  context: document.body,
	  				  success: function(data){ 
	  					$("#radServices").trigger('reset');
	  					$(".radAddMoreRows").remove();
	  					//$(".amount").html('');
	  	  				getRadData(patient_id,'<?php echo $tariffStandardID ?>');	
	  	  				getbillreceipt(patient_id);
	  					$("#busy-indicator").hide();
	  					$("#saveRadBill").show();
	  				  },
	  				  beforeSend:function(){
		  				  $("#busy-indicator").show();
		  				  $("#saveRadBill").hide();
		  				  },		  
	  			});
			}
	        });

		 function getRadData(patient_id,tariffStandardId){
			  
		   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxRadData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId ;
		         $.ajax({
		         	beforeSend : function() {
		             	//loading("outerDiv","class");
		         		$("#busy-indicator").show();
		           	},
		         type: 'POST',
		         url: ajaxUrl,
		         dataType: 'html',
		         success: function(data){
		         	//onCompleteRequest("outerDiv","class");
		         	$("#busy-indicator").hide();
		         	onCompleteRequest();
		         	if(data!=''){
	  					$("#radServices").trigger('reset');
	  					$(".radiology_test").val('');//resetting hiidden field of radId --yashwant
	  					$(".radAddMoreRows").remove();
	  					$('#newLayout').show();
		         		$('#finalPayHtml').hide();
	        			$('#globalDivId').html(data);
	        			//discountApproval();
	        			//RefundApproval();
		        			// medCount = $("#noMeddisable").val() ;
		         	}
		         },
		 		});
		     }

		 function getRadDetail(patient_id,IDs){
		   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "addRad","admin" => false)); ?>"+'/'+patient_id;
		         $.ajax({
		         	beforeSend : function() {
		             	//loading("outerDiv","class");
		         		$("#busy-indicator").show();
		           	},
		         type: 'POST',
		         url: ajaxUrl,
		         dataType: 'html',
		         success: function(data){
		         	//onCompleteRequest("outerDiv","class");
		         	$("#busy-indicator").hide();
		         	if(data!=''){
		        			 $('#radOrderArea_'+IDs).html(data);
		        			// medCount = $("#noMeddisable").val() ;
		         	}
		         },
		 		});
		     }

		 $(document).on('click','.radOrderText', function() { 
			 	currentId=$(this).attr('id');
				splitedVars=currentId.split('_');
				IDs=splitedVars[1];  
				var radVisibility =  $('#radOrderArea_'+IDs).is(':visible') ; 		
				$('#radOrderArea_'+IDs).toggle(); 
				if(radVisibility == false && $('#radOrderArea_'+IDs).attr('isVisibleRad') !='rad'){ //call only if form is now there 
					getRadDetail('<?php echo $patientID;?>',IDs);
					$('#radOrderArea_'+IDs).attr('isVisibleRad','rad') ;
				} 
		 });
	/// Eof save radiology
	
	// pharmacy
		 function getPharmacyData(patient_id,tariffStandardId){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxPharmacyData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId ;
	         $.ajax({
	         	beforeSend : function() {
	             	//loading("outerDiv","class");
	         		$("#busy-indicator").show();
	           	},
	         type: 'POST',
	         url: ajaxUrl,
	         dataType: 'html',
	         success: function(data){
	         	//onCompleteRequest("outerDiv","class");
	         	$("#busy-indicator").hide();
	         	onCompleteRequest();
	         	if(data!=''){
		         		 $('#newLayout').show();
		         		 $('#finalPayHtml').hide();
	        			 $('#globalDivId').html(data);
	        			// discountApproval();
	        			 //RefundApproval();
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }
	//EOF pharmacy
	
	// BOF ot pharmacy
	 function getOtPharmacyData(patient_id,tariffStandardId){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxOtPharmacyData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId ;
	         $.ajax({
	         	beforeSend : function() {
	             	//loading("outerDiv","class");
	         		$("#busy-indicator").show();
	           	},
	         type: 'POST',
	         url: ajaxUrl,
	         dataType: 'html',
	         success: function(data){
	         	//onCompleteRequest("outerDiv","class");
	         	$("#busy-indicator").hide();
	         	onCompleteRequest();
	         	if(data!=''){
		         		 $('#newLayout').show();
		         		 $('#finalPayHtml').hide();
	        			 $('#globalDivId').html(data);
	        			 //discountApproval();
	        			 //RefundApproval();
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }
	//EOF ot pharmacy
	
	
	//BOF blood
	 function getBloodData(patient_id,groupID){
		  
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxBloodData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID ;
         $.ajax({
         	beforeSend : function() {
             	//loading("outerDiv","class");
         		$("#busy-indicator").show();
           	},
         type: 'POST',
         url: ajaxUrl,
         dataType: 'html',
         success: function(data){
         	//onCompleteRequest("outerDiv","class");
         	$("#busy-indicator").hide();
         	onCompleteRequest();
         	if(data!=''){
		             $('#newLayout').show();
		         	 $('#finalPayHtml').hide();
        			 $('#globalDivId').html(data);
        			 //discountApproval();
        			 //RefundApproval();
        			// medCount = $("#noMeddisable").val() ;
         	}
         },
 		});
	 }
	//EOF blood
	
	 //$('#payment_category').val($("input[type='radio'][name='serviceGroupData']").val());
	 
	 $("input[type='radio'][name='serviceGroupData']").on('click',function(){		//service Group Id 
		   loading(); //for blocking radio option area 
		   var websiteInstance='<?php echo $configInstance;?>';
		   $('#payment_category').val($(this).val());
			   tariff_service_name=$(this).attr('radioname');
			   tariff_service_name=tariff_service_name.split('_');
			   $('#tariff_service_name').val(tariff_service_name['0']); //for printing receipt
		   $('#serviceGroupId').val($(this).val());
		   $('.dynamicServiceSection').hide();
		   $(".serviceAddMoreRows").remove();
		   $(".radAddMoreRows").remove();
		   $(".labAddMoreRows").remove();
		   $('#privatePackageTable').hide();

		   $("#patientCard").hide();
		   $("#creditDaysInfo").hide();
		   $("#paymentInfo").hide();
		   $('#neft-area').hide();
		   $('#bankDeposite').hide();
		   $( '#card_pay', parent.document ).attr('disabled',false);
		   //resetPaymentDetail(); //commented by Swapnil 04.12.2015
		   $('form').each(function() {this.reset()});// to clear previous data on form
		   
		    if(websiteInstance=='vadodara'){
		    	 $(".partialDiscountRow").hide();//hide discount block for vadodara
		    	 $(".partialRefundRow").hide();//hide refund block for vadodara
		    	 $("#prevDiscountArea").hide();//hide prev. discont area
		    	 $("#prevRefundArea").hide();//hide prev. refund area
			}else{
				$(".partialDiscountRow").show();
				$(".partialRefundRow").show();
				$("#prevDiscountArea").show();
		    	$("#prevRefundArea").show();
			}
		   
		    if('<?php echo $isDischarge;?>'=='1'){//do not remove, to hide payment block initialy --yashwant
			   $("#displayPaymentBlock").hide();
			}
			
			if($(this).attr('radioName')=='laboratory_radio'){ //for lab services
			   $("#pathologySection").show();
			   $("#paymentDetailDiv").show();
			   $('#test_name_1').focus();
			//   $(".partialDiscountRow").show();
			//   $(".partialRefundRow").show();
			   //$('#amount').attr('readonly',true);
			   //$('#msgForServicePayment').html('Full payment is required for laboratory .');
			   getLabData('<?php echo $patientID;?>');
		   }else if($(this).attr('radioName')=='radiology_radio'){//radiology
			   $("#radiologySection").show();
			   $("#paymentDetailDiv").show();
			   $('#radiologyname_1').focus();
			//   $(".partialDiscountRow").show();
			//   $(".partialRefundRow").show();
			   //$('#amount').attr('readonly',true);
			   //$('#msgForServicePayment').html('Full payment is required for radiology .');
			   getRadData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>');
		   }else if($(this).attr('radioName')=='pharmacy_radio'){ //pharmacy
			   //$("#pharmacySection").show();
			   $("#paymentDetailDiv").show();
			//   $(".partialDiscountRow").show();
			//   $(".partialRefundRow").show();
			   var websiteInstanceToCheck='<?php echo $configInstance;?>';
			   if(websiteInstanceToCheck=='hope'){//to show payment block for pharmacy in hope
				   $("#displayPaymentBlock").show();
			   } 
			   getPharmacyData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>');
		   }else if($(this).attr('radioName')=='roomtariff_radio'){ //roomtariff
			   //$("#pharmacySection").show();
			   $("#paymentDetailDiv").show();
			//   $(".partialDiscountRow").show();
			//   $(".partialRefundRow").show();
			   //$('#amount').attr('readonly',false);
			   //$('#msgForServicePayment').html('');
			   getDailyRoomData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>',$(this).val());
		   }else if($(this).attr('radioName')=='surgery_radio'){ //surgery
			   //$("#pharmacySection").show();
			   $("#paymentDetailDiv").show();
			//   $(".partialDiscountRow").show();
			//   $(".partialRefundRow").show();
			  // $('#amount').attr('readonly',false);
			  // $('#msgForServicePayment').html('');
			   getProcedureData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>');
		   }else if($(this).attr('radioName')=='consultant_radio'){ //consultant billing
			   $("#consultantBillingSection").show();
			   $("#paymentDetailDiv").show(); 
			   $('#consultant_service_id_1').focus();
			//   $(".partialDiscountRow").show();
			//   $(".partialRefundRow").show();
			   getConsultationData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>');
		   }else if($(this).attr('radioName')=='otpharmacy_radio'){ //consultant billing
			   $("#paymentDetailDiv").show(); 
			   getOtPharmacyData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>');
		   }else if($(this).attr('radioName')=='blood_radio'){ //blood billing
			   $("#bloodSection").show();
			   $("#paymentDetailDiv").show(); 
			   $('#bloodServiceId_1').focus();
			//   $(".partialDiscountRow").show();
			//   $(".partialRefundRow").show();
			   getBloodData('<?php echo $patientID;?>',$(this).val());
		   }else if($(this).attr('radioName')=='implant_radio'){ //implant billing
			   $("#implantSection").show();
			   $("#paymentDetailDiv").show(); 
			   $('#implantServiceId_1').focus();
			//   $(".partialDiscountRow").show();
			//   $(".partialRefundRow").show();
			   getImplantData('<?php echo $patientID;?>',$(this).val());
		   }else if($(this).attr('radioName')=='ward_radio'){ //ward procedure billing
			   $("#wardSection").show();
			   $("#paymentDetailDiv").show(); 
			   $('#wardServiceId_1').focus();
			//   $(".partialDiscountRow").show();
			//   $(".partialRefundRow").show();
			   getWardData('<?php echo $patientID;?>',$(this).val(),'ward');
		   }else if($(this).attr('radioName')=='otherservices_radio'){ //ward procedure billing
			   $("#otherServiceSection").show();
			   $("#paymentDetailDiv").show(); 
			   $('#otherService_1').focus();
			   getOtherServiceData('<?php echo $patientID;?>',$(this).val());
		   }else if($(this).attr('radioName')=='radiotheraphy_radio'){ //ward procedure billing
			   $("#radiotheraphySection").show();
			   $("#paymentDetailDiv").show(); 
			   $('#radiotheraphy_1').focus();
			   var websiteInstanceToCheck='<?php echo $configInstance;?>';
			   if(websiteInstanceToCheck=='vadodara'){//to show payment block for pharmacy in hope
				   $("#displayPaymentBlock").show();
			   } 
			   getRadiotheraphyData('<?php echo $patientID;?>',$(this).val());
		   }else if($(this).attr('radioName')=='privatepackage_radio'){ //consultant billing
			   getPackageData(packagedPatientId);
			   $('#privatePackageTable').show();
			//   $(".partialDiscountRow").show();
			//   $(".partialRefundRow").show();
		   }else if($(this).attr('radioName')=='gallerykeyword_radio'){ //only for gallery image details
			   $("#gallerySection").show();
			   $("#paymentDetailDiv").hide();
			   $('#globalDivId').html('');
			   onCompleteRequest();
		   } else{ //else for dynamic services
			   $("#paymentDetailDiv").show();
			   if($(this).attr('radioName') != 'mandatoryservices_radio'){
			//	   $(".partialDiscountRow").show();
			//	   $(".partialRefundRow").show();
				   $("#servicesSection").hide();
				  // $('#service_id_1').focus();
				 //  $('#amount').attr('readonly',true);
				  // $('#msgForServicePayment').html('');
				   getServiceData('<?php echo $patientID;?>',$(this).val());
			   }else{ 
				   var websiteInstance='<?php echo $configInstance;?>';
				   var admissionType='<?php echo strtolower($patient['Patient']['admission_type']);?>';
				   $(".partialRefundRow").hide();
				   if(websiteInstance=='kanpur' && admissionType=='ipd'){
					   $(".partialDiscountRow").hide();
				   }/*else{
					   $(".partialDiscountRow").show();
				   }*/
				   $("#servicesSection").show();
				   getServiceData('<?php echo $patientID;?>',$(this).val(),'mandatoryservices');
			   }
		   } 
			
	});		//end of service group click  


	function holdAmount(){
		partialAmountPaid = $("#amount").val(); 
		$('#amount_for_discount').val(partialAmountPaid);
		//alert(partialAmountPaid);
		
		 $('#totalLabAmount').html(''); //to maintain total lab amount  --yashwant
		 $('#totalRadAmount').html(''); //to maintain total rad amount  --yashwant
		 $('#totalCServiceAmount').html(''); //to maintain total clinical service amount  --yashwant
		 $('#totalOtherServiceAmount').html('');
		 $('#totalRadiotheraphyAmount').html('');
		 
		 getCardBalance();//for card balance  --yashwant
	}
	//fnction to check discount approval
	function discountApproval(){
		
		resetDiscountRefund();			//reset all (Discount/Refund)
		patientId = '<?php echo $patientID; ?>';
    	payment_category = $('#serviceGroupId').val();

    	clearInterval(refund_interval); 		//clear refund intervals if any
		clearInterval(interval); 		//clear discount intervals if any
		holdAmount();
		 
		//return ; //no need to xcute below code added by pankajk  w
	  $.ajax({
			  type : "POST",
			  data: "patient_id="+patientId+"&payment_category="+payment_category,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "checkDiscountApproval","admin" => false)); ?>",
			  context: document.body,
			  beforeSend:function(){
				 // $("#busy-indicator").show();
			  },	
			  success: function(data){
				 // $("#busy-indicator").hide(); 
				  parseData = $.parseJSON(data);
				  console.log(parseData);
				  
			 if(parseData != null) {
				 
				  is_approved = parseInt(parseData.is_approved);
				  request_to = parseInt(parseData.request_to);
				  reasonType = parseData.reason;
				  is_type = parseData.type;
				  payment_category = $('#serviceGroupId').val();

				  $.ajax({
					  type : "POST",
					  data: "patient_id="+patientId+"&request_to="+request_to+"&type="+is_type+"&payment_category="+payment_category,
					  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "cancelApproval","admin" => false)); ?>",
					  context: document.body,
					  beforeSend:function(){
						  $("#busy-indicator").show();
					  },	
					  async: false,
					  success: function(data){ 
						$("#busy-indicator").hide(); 
						clearInterval(interval); 					// stop the interval
						resetDiscountRefund();
						display();
					  }
				});

				 /*

					$('input:radio[class=discountType][value="' + is_type + '"]').prop('checked',true); 	//checked radio Amount/Percentage
				  discount_amount = parseInt(parseData.discount_amount);								//discount_amount
				  discount_percentage = parseInt(parseData.discount_percentage);						//discount_percentage					

				  var discount = '';
				  if(discount_amount != ''){
					  discount = discount_amount;
					  $("#discType").val("Amount");
					  $("#show_percentage").hide();	
				  }else if(discount_percentage != ''){
					  discount = discount_percentage;
					  $("#discType").val("Percentage");
					  $("#show_percentage").show();	
				  }

				  $(".discountType").prop("disabled",true);
				  $("#discount").attr('readonly',true);
				  $("#discount_authorize_by").show();		//show Approval users
				  $("#discount_authorize_by").val(request_to);
				  $("#discount_authorize_by").attr('disabled',true);
				  $("#discount_reason").show();
				  $("#discount_reason").val(reasonType);
				  $("#discount_reason").attr('disabled',true);
				  $("#discount_authorize_by").attr('disabled',true);
				  $("#cancel-approval").show();			//show cancel button to remove approval
				  
				if(parseInt(is_approved) == 0)
				{
					$("#mesage").show();
					$("#status-approved-message").html("Please wait for Approval");
					$("#is_approved").val(1);	//for approval waiting
					$("#image-gif").show();
					$("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
  					interval = setInterval("Notifications()", 10000);  // this will call Notifications() function in each 5000ms
				  }
				else if(is_approved == 1)
				{	
					  $("#mesage").show();
					  $("#status-approved-message").html('<font color="green">Request for discount has been completed</font>');
					  $("#is_approved").val(2);
					  $("#image-gif").hide();
				}
				else if(is_approved == 2)
				{
					$("#mesage").show();
					$("#status-approved-message").html('<font color="red">Request for discount has been rejected</font>');
					$("#image-gif").hide();
					$("#is_approved").val(3);	// for approval reject
			 	} 		
			 	
				$("#discount").val(discount); */
				display();	//calculate balance			  
			  }
			} 	//end of success
		}); 	//end of ajax
	}


	function RefundApproval(){
		
		resetRefund();			//reset all Refund)
		patientId = '<?php echo $patientID; ?>';
    	payment_category = $('#serviceGroupId').val();

		clearInterval(refund_interval); 		//clear refund intervals if any
		clearInterval(interval); 		//clear discount intervals if any
		return ; //W
		$.ajax({
			  type : "POST",
			  data: "patient_id="+patientId+"&payment_category="+payment_category,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "checkRefundApproval","admin" => false)); ?>",
			  context: document.body,
			  beforeSend:function(){
				  //$("#busy-indicator").show();
			  },	
			  success: function(data){
				  //$("#busy-indicator").hide(); 
				  parseData = $.parseJSON(data);
				  console.log(parseData);
				  
			 if(parseData != null) {

				 is_approved = parseInt(parseData.is_approved);
				  request_to = parseInt(parseData.request_to);
				  reasonType = parseData.reason;
				  is_type = parseData.type;
				  payment_category = $('#serviceGroupId').val();

				  
				  $.ajax({
					  type : "POST",
					  data: "patient_id="+patientId+"&request_to="+request_to+"&type="+is_type+"&payment_category="+payment_category,
					  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "cancelApproval","admin" => false)); ?>",
					  context: document.body,
					  beforeSend:function(){
						  $("#busy-indicator").show();
					  },	
					  async: false,
					  success: function(data){ 
						$("#busy-indicator").hide(); 
						clearInterval(interval); 					// stop the interval
						resetDiscountRefund();
						display();
					  }
				});

				/*	
				  is_approved = parseInt(parseData.is_approved);
				  refund_amount = parseInt(parseData.refund_amount);
				  request_to = parseInt(parseData.request_to);
				  $('input:checkbox[id=is_refund]').prop('checked',true); 	//to checked refund checkbox
				  $("#refund_amount").show();
				  $("#refund_amount").val(refund_amount);
				  $("#discount_authorize_by_for_refund").show();
				  
				if(parseInt(is_approved) == 0)
				{
					$("#mesage2").show();
					$("#status-approved-message-for-refund").html("apporval Request for Refund has been sent, please wait for approval");
					$("#is_refund_approved").val(1);	//for approval waiting
					$("#image-gif2").show();
					$("#image-gif2").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
					$("#refund_amount").attr('readonly',true);
					$("#is_refund").attr('disabled',true);
					$("#discount_authorize_by_for_refund").show();
					$("#discount_authorize_by_for_refund").val(request_to);
			        $("#discount_authorize_by_for_refund").attr('disabled',true);
			        $("#cancel-refund-approval").show();
					//set interval for clicked service group 
					refund_interval = setInterval("NotificationsForRefund()", 10000);  // this will call Notifications() function in each 5000ms
				  }
				else if(is_approved == 1)
				{	
					  $("#mesage2").show();
					  $("#status-approved-message-for-refund").html('<font color="green">Request for Refund has been completed</font>');
					  $("#is_refund_approved").val(2);	
					  $("#image-gif2").hide();
					  $("#refund_amount").attr('readonly',true);
					  $("#is_refund").attr('disabled',true);	
					  $("#discount_authorize_by_for_refund").hide();	
					  $("#hrefund").val(1);		  
				  }
				else if(is_approved == 2)
				{
					resetRefund();
					$("#mesage2").show();
					$("#status-approved-message-for-refund").html('<font color="red">Request for Refund has been rejected</font>');
					$("#image-gif2").hide();
					$("#is_refund_approved").val(3);	// for approval reject
					$("#discount_authorize_by_for_refund").hide();	
					$("#hrefund").val(1);
			 	} 		
			 	*/
				//$("#discount").val(discount);
				display();	//calculate balance			  
			  }
			} 	//end of success
		}); 	//end of ajax

		maintainPrevRefundDiscount();
	}

	
 
	 function getbillreceipt(patient_id){
	 	<?php if($this->params->query['showPhar'] ==1){?>
	 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxBillReceipt",$patient['Patient']['id'],'?'=>array('showPhar'=>'1'),"admin" => false)); ?>";
	 	<?php }else{?>
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxBillReceipt","admin" => false)); ?>"+'/'+patient_id;
	   	<?php }?>
	         $.ajax({
	         	beforeSend : function() {
	             	//loading("outerDiv","class");
	         		$("#busy-indicator").show();
	           	},
	         type: 'POST',
	         url: ajaxUrl,
	         dataType: 'html',
	         success: function(data){
	         	//onCompleteRequest("outerDiv","class");
	         	$("#busy-indicator").hide();
	         	if(data!=''){
	        			 $('#ajaxBillReceipt').html(data);
	        			 $('#newLayout').show();
		         		 $('#finalPayHtml').hide();
	        			 //discountApproval();
	             		 //RefundApproval();
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }

	     
	 $(".singleBillPayment").click(function(){ 
	 	 if($(this).attr('id')=='payAllTotal'){
			var totalPaymentFlag='payOnlyAmount';
		 }else{
			 var totalPaymentFlag='';
		 }
	 	var singleBillPay='';
		 <?php if($patient['Patient']['is_discharge']) {?>
		 	var singleBillPay ='yes';
		 	<?php }?>
		
		 totalCharge=$("#totalCharge").val();
		 totalPaid=$("#totalPaid").val();
		 patientID='<?php echo $patientID;?>';
		 appoinmentID='<?php echo $appoinmentID;?>';
		 /*$.fancybox({ 
			 	'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'onClosed':function(){
					//getbillreceipt(patientID);
					//window.location.reload();
					//window.location.href='<?php //echo $this->Html->url(array("controller"=>'billings',"action" => "dischargeIpd",$patientID));?>'
				},
				'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"finalDischarge","admin"=>false)); ?>"+'/'+patientID+'?appoinmentID='+appoinmentID+'&privatePackage='+billableCondition+'&totalPaymentFlag='+totalPaymentFlag,
		 });*/
		 if(<?php echo  Configure::read('singlePay')?>=='1'){//full_payment
		 $.fancybox(
				    { 
							
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
					    'iframe' : {
							scrolling : 'auto',
							preload   : false //opening the fancy box before it gets loaded 
						},
					    'helpers'   : { 
					    	   'overlay' : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox 
					    	  },
					    'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"full_payment","admin"=>false)); ?>"+'/'+patientID+'?appoinmentID='+appoinmentID+'&privatePackage='+billableCondition+'&totalPaymentFlag='+totalPaymentFlag+'&singleBillPay='+singleBillPay,
			});
		 $(document).scrollTop(0);
		 }else{ //new payment
		 <?php if($this->params->query['showPhar']){?>
		 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"newSinglePayment","admin"=>false)); ?>"+'/'+patientID+'?showPhar=1&appoinmentID='+appoinmentID+'&privatePackage='+billableCondition+'&totalPaymentFlag='+totalPaymentFlag+'&singleBillPay='+singleBillPay;
		 <?php }else{ ?>	
		 		var ajaxUrl = "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"newSinglePayment","admin"=>false)); ?>"+'/'+patientID+'?appoinmentID='+appoinmentID+'&privatePackage='+billableCondition+'&totalPaymentFlag='+totalPaymentFlag+'&singleBillPay='+singleBillPay;
		 <?php }?> 
		   	$.ajax({
	         	beforeSend : function() {
	             	//loading("outerDiv","class");
	         		$("#busy-indicator").show();
	           	},
	         type: 'POST',
	         url: ajaxUrl,
	         dataType: 'html',
	         success: function(data){
	         	//onCompleteRequest("outerDiv","class");
	         	$("#busy-indicator").hide();
	         	//onCompleteRequest();
	         	if(data!=''){
		         		 $('#newLayout').hide();
		         		 $('#finalPayHtml').show();
		         		 $('#finalPayHtml').focus();
	        			 $('#finalPayHtml').html(data);
	        			 $('html, body').animate({ scrollTop: $('#finalPayHtml').offset().top }, 'slow');//to scroll page at this position
	        			 //$('#ftotalamount').focus();
	        			 //discountApproval();
	        			 //RefundApproval();
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
		 }
	 });

	 function getDailyRoomData(patient_id,tariffStandardId,groupId){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxDailyroomData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId+'/'+groupId;
		   	$.ajax({
	         	beforeSend : function() {
	             	//loading("outerDiv","class");
	         		$("#busy-indicator").show();
	           	},
	         type: 'POST',
	         url: ajaxUrl,
	         dataType: 'html',
	         success: function(data){
	         	//onCompleteRequest("outerDiv","class");
	         	$("#busy-indicator").hide();
	         	onCompleteRequest();
	         	if(data!=''){
		         		 $('#newLayout').show();
		         		 $('#finalPayHtml').hide();
	        			 $('#globalDivId').html(data);
	        			 //discountApproval();
	        			 //RefundApproval();
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }

	 function getProcedureData(patient_id,tariffStandardId){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxProcedureData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId;
		   	$.ajax({
	         	beforeSend : function() {
	             	//loading("outerDiv","class");
	         		$("#busy-indicator").show();
	           	},
	         type: 'POST',
	         url: ajaxUrl,
	         dataType: 'html',
	         success: function(data){
	         	//onCompleteRequest("outerDiv","class");
	         	$("#busy-indicator").hide();
	         	onCompleteRequest();
	         	if(data!=''){
		         		 $('#newLayout').show();
		         		 $('#finalPayHtml').hide();
	        			 $('#globalDivId').html(data);
	        			 //discountApproval();
	        			 //RefundApproval();
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }
	 

	 function getPackageData(packagedPatientId){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxPrivatePackageData","admin" => false)); ?>"+'/'+packagedPatientId;
		   	$.ajax({
	        	beforeSend : function() {
	             	$("#busy-indicator").show();
	           	},
		        type: 'POST',
		        url: ajaxUrl,
		        dataType: 'html',
		        success: function(data){
		        	$("#busy-indicator").hide();
		        	onCompleteRequest();
		        	if(data!=''){
		        		$('#newLayout').show();
		         		$('#finalPayHtml').hide();
		        		$('#globalDivId').html(data);
		        	}
		        },
	 		});
	     }

     
	 $("#amount").keyup(function(){
		if(!$("#amount").is('[readonly]')){
		 	display();	//manupulate all values and calculate the balance
		 	$('#mode_of_payment').val('Cash');
		 	$("#patientCard").hide();
			$("#paymentInfo").hide();
			$("#creditDaysInfo").hide();
			$('#neft-area').hide();
			$('#bankDeposite').hide();
		}
	 });
	 

	 $("#doneAndPrint").click(function(){     	 
  		var patient_id='<?php echo $patientID;?>';  		 
  			$.ajax({
  				  type : "POST",
  				 // data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "finalDischarge", "admin" => false)); ?>"+'/'+patient_id,
  				  context: document.body,
  				  success: function(data){   
  	  				  onCompleteRequest('finalDischargeDiv','id');	
  	  				  $('#finalDischargeDiv').html(data);
  					 
  				  },
  				  beforeSend:function(){
  					loading('finalDischargeDiv','id');
  	  			  },		  
  			});
  		
    });

	 $(".serviceGroupData").click(function(){ 
		 var selectedGroup = $(this).val();
		 //autocomplete for service sub group 
		 $(document).on('focus','.service-sub-group', function() {
			currentID=$(this).attr('id');
		 	ID=currentID.slice(-1);
			 $("#add-service-sub-group"+ID).autocomplete({
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

		 $(document).on('focus','.service_id', function() {
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
		 	ID=splitedVar[2];
		 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
			$("#service_id_"+ID).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
				 minLength: 1,
				 select: function( event, ui ) {
					$('#service_amount_'+ID).val('');
					$('#amount_'+ID).html('');	
					$('#fix_discount_'+ID).val('');			 
					$('#onlyServiceId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					if(charges == '0'){
						charges ='';
					}
					if(charges !== undefined && charges !== null && charges !== ''){
						charges = charges.replace(/,/g, '');
						$('#service_amount_'+ID).val(charges.trim());
						$('#amount_'+ID).html(charges.trim());
						if(ui.item.fix_discount !== undefined && ui.item.fix_discount !== null && ui.item.fix_discount !== ''){
							$('#fix_discount_'+ID).val(ui.item.fix_discount);
						}
						$( '.clinicalServiceAmount').trigger("change");//to maintain clinical service amount  --yashwant
					}else{
						$('#service_amount_'+ID).val('');
						$('#amount_'+ID).html('');
						$('#fix_discount_'+ID).val('');
						$('#totalCServiceAmount').html('');
						inlineMsg(currentID,errorMsg,10);
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

//radiotheraphy_service

 	$(document).on('focus','.radiotheraphy_service', function() {
		currentID=$(this).attr('id');
		splitedVar=currentID.split('_');
	 	ID=splitedVar[1]; 
	 	selectedGroup=$('#serviceGroupId').val();
	 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
		$("#radiotheraphy_"+ID).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
			 minLength: 1,
			 select: function( event, ui ) {
				$('#radiotheraphyAmount_'+ID).val('');
				$('#radiotheraphyTotalAmount_'+ID).html('');				 
				$('#radiotheraphyId_'+ID).val(ui.item.id);
				var id = ui.item.id; 
				var charges=ui.item.charges;
				if(charges == '0'){
					charges ='';
				}
				if(charges !== undefined && charges !== null && charges !== ''){
					charges = charges.replace(/,/g, '');
					$('#radiotheraphyAmount_'+ID).val(charges.trim());
					$('#radiotheraphyTotalAmount_'+ID).html(charges.trim());
					$( '.radiotheraphyAmount').trigger("change");//to maintain clinical service amount  --yashwant
				}else{
					$('#radiotheraphyAmount_'+ID).val('');
					$('#radiotheraphyTotalAmount_'+ID).html('');
					inlineMsg(currentID,errorMsg,10);
				}
					//serviceSubGroups(this);
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	});

	

	 $(document).on('focus','.consultant_service_id', function() {
		currentID=$(this).attr('id');
		splitedVar=currentID.split('_');
	 	ID=splitedVar[3]; 
	 	selectedGroup=$('#serviceGroupId').val();
	 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
		$("#consultant_service_id_"+ID).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
			 minLength: 1,
			 select: function( event, ui ) {
				$('#amountConsultant_'+ID).val('');					 
				$('#onlyConsultantServiceId_'+ID).val(ui.item.id);
				var id = ui.item.id; 
				var charges=ui.item.charges;
				if(charges == '0'){
					charges ='';
				}
				if(charges !== undefined && charges !== null && charges !== ''){
					charges = charges.replace(/,/g, '');
					$('#amountConsultant_'+ID).val(charges.trim());
					//$('#amount'+ID).html(charges.trim());
				}else{
					$('#amountConsultant_'+ID).val('');
					inlineMsg(currentID,errorMsg,10);
				}
				//serviceSubGroups(this);
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	});


	//BOF on key up enter event to add new row
		$(document).on('keypress','.consultant_service_id', function(event) {
			var keycode = (event.keyCode ? event.keyCode : event.which);
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
			ID=splitedVar[3]; 
			selVal = $('#onlyConsultantServiceId_'+ID).val();
			if(keycode == '13' && selVal != '' ){ 
				if(selVal) //addnew row only if selection is done 
				addConsultantVisitElement();//insert new row 
			}
			
		});
		//EOF enter event by pankaj 

	 $(document).on('focus','.blood_service', function() {
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
		 	ID=splitedVar[1]; 
		 	selectedGroup=$('#serviceGroupId').val();
		 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
			$("#bloodServiceId_"+ID).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
				 minLength: 1,
				 select: function( event, ui ) {	
					$('#bloodAmount_'+ID).val('');
					$('#bfix_discount_'+ID).val('');
					$('#bloodTotalAmount_'+ID).html('');				 
					$('#onlyBloodId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					if(charges == '0'){
						charges ='';
					}
					if(charges !== undefined && charges !== null && charges !== ''){
						charges = charges.replace(/,/g, '');
						$('#bloodAmount_'+ID).val(charges.trim());
						$('#bloodTotalAmount_'+ID).html(charges.trim());
						$('#bfix_discount_'+ID).val(ui.item.fix_discount);
					}else{
						$('#bloodAmount_'+ID).val('');
						$('#bfix_discount_'+ID).val('');
						$('#bloodTotalAmount_'+ID).html('');
						inlineMsg(currentID,errorMsg,10);
					}
					//serviceSubGroups(this);
				 },
				 messages: {
				        noResults: '',
				        results: function() {}
				 }
			});
		});

		//BOF on key up enter event to add new row
		$(document).on('keypress','.blood_service', function(event) {
			var keycode = (event.keyCode ? event.keyCode : event.which);
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
			ID=splitedVar[1]; 
			selVal = $('#onlyBloodId_'+ID).val();
			if(keycode == '13' && selVal != '' ){ 
				if(selVal) //addnew row only if selection is done 
				addMoreBloodHtml();//insert new row 
			}
			
		});
		//EOF enter event by pankaj 



	 $(document).on('focus','.implant_service', function() {
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
		 	ID=splitedVar[1]; 
		 	selectedGroup=$('#serviceGroupId').val();
		 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
			$("#implantServiceId_"+ID).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
				 minLength: 1,
				 select: function( event, ui ) {
					$('#implantAmount_'+ID).val('');
					$('#ifix_discount_'+ID).val('');
					$('#implantTotalAmount_'+ID).html('');					 
					$('#onlyImplantId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					if(charges == '0'){
						charges ='';
					}
					if(charges !== undefined && charges !== null && charges !== ''){
						charges = charges.replace(/,/g, '');
						$('#implantAmount_'+ID).val(charges.trim());
						$('#ifix_discount_'+ID).val(ui.item.fix_discount);
						$('#implantTotalAmount_'+ID).html(charges.trim());
					}else{
						$('#implantAmount_'+ID).val('');
						$('#ifix_discount_'+ID).val('');
						$('#implantTotalAmount_'+ID).html('');
						inlineMsg(currentID,errorMsg,10);
					}
					//serviceSubGroups(this);
				 },
				 messages: {
				        noResults: '',
				        results: function() {}
				 }
			});
		});


	 $(document).on('focus','.other_service', function() {
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
		 	ID=splitedVar[1]; 
		 	selectedGroup=$('#serviceGroupId').val();
			$("#otherService_"+ID).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getOtherServicesAutocomplete","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
				 minLength: 1,
				 select: function( event, ui ) {
					$('#otherServiceAmount_'+ID).val('');
					$('#otherServiceTotalAmount_'+ID).html('');					 
					$('#otherServiceId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					var group=ui.item.group;
					var groupRes = group.toLowerCase();
					if(charges == '0'){
						charges ='';
					}
					var websiteInstance='<?php echo $configInstance;?>';
					var misChargeGroup='<?php echo Configure::read('miscChargesGroup');?>';
					if(websiteInstance == 'vadodara'){
						if(groupRes==misChargeGroup){//Editable amount field only for mis charges
							$('#otherServiceAmount_'+ID).attr('readonly',false);
						}else{
							$('#otherServiceAmount_'+ID).attr('readonly',true);
						}
					}
					if(charges !== undefined && charges !== null && charges !== ''){
						charges = charges.replace(/,/g, '');
						$('#otherServiceAmount_'+ID).val(charges.trim());
						$('#otherServiceTotalAmount_'+ID).html(charges.trim());
					}else{
						$('#otherServiceAmount_'+ID).val('');
						$('#otherServiceTotalAmount_'+ID).html('');
						inlineMsg(currentID,errorMsg,10);
					}
					$( '.otherServiceAmount').trigger("change");//to maintain clinical service amount  --yashwant
				 },
				 messages: {
				        noResults: '',
				        results: function() {}
				 }
			});
		});
		

	 $(document).on('focus','.ward_service', function() {
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
		 	ID=splitedVar[1]; 
		 	selectedGroup=$('#serviceGroupId').val();
		 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
			$("#wardServiceId_"+ID).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>",
				 minLength: 1,
				 select: function( event, ui ) {		
					$('#wardAmount_'+ID).val('');
					$('#wardTotalAmount_'+ID).html('');			 
					$('#onlyWardId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					if(charges == '0'){
						charges ='';
					}
					if(charges !== undefined && charges !== null && charges !== ''){
						charges = charges.replace(/,/g, '');
						$('#wardAmount_'+ID).val(charges.trim());
						$('#wardTotalAmount_'+ID).html(charges.trim());
					}else{
						$('#wardAmount_'+ID).val('');
						$('#wardTotalAmount_'+ID).html('');
						inlineMsg(currentID,errorMsg,10);
					}
					//serviceSubGroups(this);
				 },
				 messages: {
				        noResults: '',
				        results: function() {}
				 }
			});
		});
		
		
	 $(document).on('focusout','.service-sub-group', function() {
		 currentID=$(this).attr('id');
		 ID=currentID.slice(-1); 
		 if($(this).val()==''){
			 $('#addServiceSubGroupId_'+ID).val('');
		 }
	 });

	 $(document).on('keyup','.service_id', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[2]; 
		 if($(this).val()==''){
			 $('#onlyServiceId_'+ID).val('');
			 $('#service_amount_'+ID).val('');
			 $('#fix_discount_'+ID).val('');
			 $('#amount_'+ID).html('');
			 $( '.clinicalServiceAmount').trigger("change");//to maintain clinical service amount  --yashwant
		 }
	 });

	 $(document).on('keyup','.other_service', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[1]; 
		 if($(this).val()==''){
			 $('#otherServiceId_'+ID).val('');
			 $('#otherServiceAmount_'+ID).val('');
			 $('#otherServiceTotalAmount_'+ID).html('');
			 $( '.otherServiceAmount').trigger("change");//to maintain clinical service amount  --yashwant
		 }
	 });

	 //$(document).on('focusout','.test_name', function() {
	 $(document).on('keyup','.test_name', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[2];  
		 if($(this).val()==''){
			 $('#labid_'+ID).val('');
			 $('#labAomunt_'+ID).val('');
			 $( '.labServiceAmount').trigger("change"); //to maintain total lab amount  --yashwant
		 }
	 });

	 $(document).on('keyup','.radiology_name', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[1];  
		 if($(this).val()==''){
			 $('#radiologytest_'+ID).val('');
			 $('#radAomunt_'+ID).val('');
			 $('#rfix_discount_'+ID).val('');
			 $( '.radServiceAmount').trigger("change"); //to maintain total rad amount  --yashwant
		 }
	 });

	 $(document).on('keyup','.consultant_service_id', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[3];  
		 if($(this).val()==''){
			 $('#amountConsultant_'+ID).val('');
		 }
	 });

	 $(document).on('keyup','.blood_service', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[1];  
		 if($(this).val()==''){
			 $('#bloodAmount_'+ID).val('');
			 $('#bfix_discount_'+ID).val('');
			 $('#bloodTotalAmount_'+ID).html('');
		 }
	 });

	 $(document).on('keyup','.implant_service', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[1];  
		 if($(this).val()==''){
			 $('#implantAmount_'+ID).val('');
			 $('#ifix_discount_'+ID).val('');
			 $('#implantTotalAmount_'+ID).html('');
		 }
	 });

	 $(document).on('keyup','.ward_service', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[1];  
		 if($(this).val()==''){
			 $('#wardAmount_'+ID).val('');
			 $('#wardTotalAmount_'+ID).html('');
		 }
	 });
	 
	//BOF Implant section
	 function getImplantData(patient_id,groupID){
		  
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxImplantData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID ;
         $.ajax({
         	beforeSend : function() {
             	//loading("outerDiv","class");
         		$("#busy-indicator").show();
           	},
         type: 'POST',
         url: ajaxUrl,
         dataType: 'html',
         success: function(data){
         	//onCompleteRequest("outerDiv","class");
         	$("#busy-indicator").hide();
         	onCompleteRequest();
         	if(data!=''){
         		$('#newLayout').show();
        		$('#finalPayHtml').hide();
        		$('#globalDivId').html(data);
        		//discountApproval();
        		//RefundApproval();
         	}
         },
 		});
	 }
	//EOF Implant section
	
	//BOF other Service section
	 function getOtherServiceData(patient_id,groupID){
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxOtherServiceData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID ;
         $.ajax({
         	beforeSend : function() {
              	//loading("outerDiv","class");
         		$("#busy-indicator").show();
           	},
         type: 'POST',
         url: ajaxUrl,
         dataType: 'html',
         success: function(data){
         	//onCompleteRequest("outerDiv","class");
         	$("#busy-indicator").hide();
         	$('.otherServiceTotalAmount').html('');
         	onCompleteRequest();
         	if(data!=''){
         		$('#newLayout').show();
        		$('#finalPayHtml').hide();
        		$('#globalDivId').html(data);
        		//discountApproval();
        		//RefundApproval();
         	}
         },
 		});
	 }
	//EOF other Service section
	
	
	//BOF ward section
	 function getWardData(patient_id,groupID,ward){

	 
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxWardProcedureData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'?isWard='+ward ;
         $.ajax({
         	beforeSend : function() {
             	//loading("outerDiv","class");
         		$("#busy-indicator").show();
           	},
         type: 'POST',
         url: ajaxUrl,
         dataType: 'html',
         success: function(data){
         	//onCompleteRequest("outerDiv","class");
         	$("#busy-indicator").hide();
         	onCompleteRequest();
         	if(data!=''){
         		$('#newLayout').show();
        		$('#finalPayHtml').hide();
        		$('#globalDivId').html(data);
        		//discountApproval();
        		//RefundApproval();
         	}
         },
 		});
	 }
	//EOF ward section 
	
	// add more for ward procedures data
	function addWardService()
	{	 
		//making amount fields readonly in all groups
		var websiteInstance='<?php echo $configInstance;?>';	
		/*if(websiteInstance=='kanpur'){
			var readonly = 'readonly = true';
		}else{
			 var readonly = '';
		}*/
		
		if($('#onlyWardId_'+parseInt($("#no_of_fields").val())).val()==''){
			alert('This service is not exist. Please enter another service.');
			$('#wardServiceId_'+parseInt($("#no_of_fields").val())).val('');
			$('#onlyWardId_'+parseInt($("#no_of_fields").val())).val('');
			return false;
		}else{

		 var today = new Date(); 
		 var todayDate=today.format('d/m/Y H:i:s');
		 var field = '';
		 var number_of_field = parseInt($("#no_of_fields").val())+1;
		 var amoutRow = $("#ampoutRow");
		 $("#ampoutRow").remove();
			
		 field +='<tr id="row_'+number_of_field+'" class="wardAddMoreRows">';
		 field +='<td valign="middle" width="140"><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:135px;" class="validate[required,custom[mandatory-date]] textBoxExpnd wardDate  " id="wardDate_'+number_of_field+'" name="data[ServiceBill]['+number_of_field+'][date]" value="'+todayDate+'"> </td>';
		 field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="wardServiceId_'+number_of_field+'" class="validate[required,custom[mandatory-enter]] textBoxExpnd ward_service"  div="false" label="false"> <input type="hidden" fieldno="'+number_of_field+'"  id="onlyWardId_'+number_of_field+'" class="onlyWardId" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" ></td>';
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="wardAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd wardAmount" readonly="readonly" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
		 field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="wardQty_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd wardQty" name="data[ServiceBill]['+number_of_field+'][no_of_times]" value="1"></td>';
	     field +='<td id="wardTotalAmount_'+number_of_field+'" class="wardTotalAmount" align="center" width="100"></td>';
	     field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="wardDescription_'+number_of_field+'" class=" textBoxExpnd wardDescription" name="data[ServiceBill]['+number_of_field+'][description]"></td>';
		 field +=' <td align="center" width="50"><a href="javascript:void(0);" id="delete_row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="<?php echo $this->webroot ?>theme/Black/img/cross.png" ></a></td>  </tr>';
		 $("#no_of_fields").val(number_of_field);
		  
		 $("#wardArea").append(field);
		// $('#add-service-group-id1 option').clone().appendTo('#add-service-group-id'+number_of_field);
		 $("#removeVisit").css("visibility","visible");
 
		 $('#wardServiceId_'+number_of_field).focus();//taking focus on sevice
		 //add  calender 
		 addCalenderOnDynamicField();
		 return number_of_field;
		}
	}
	
	//EOF ward data
	
		
	// add more for implant data
	function addImplantService()
	{	 
		if($('#onlyImplantId_'+parseInt($("#no_of_fields").val())).val()==''){
			alert('This service is not exist. Please enter another service.');
			$('#implantServiceId_'+parseInt($("#no_of_fields").val())).val('');
			$('#onlyImplantId_'+parseInt($("#no_of_fields").val())).val('');
			return false;
		}else{
			addMoreImplantHtml();		
		}
	}
	
	function addMoreImplantHtml()
	{	 
		//making amount fields readonly in all groups
		var websiteInstance='<?php echo $configInstance;?>';	
		if($('#onlyImplantId_'+parseInt($("#no_of_fields").val())).val()==''){
			alert('This service is not exist. Please enter another service.');
			$('#implantServiceId_'+parseInt($("#no_of_fields").val())).val('');
			$('#onlyImplantId_'+parseInt($("#no_of_fields").val())).val('');
			return false;
		}else{

		 var today = new Date(); 
		 var todayDate=today.format('d/m/Y H:i:s');
		 var field = '';
		 var number_of_field = parseInt($("#no_of_fields").val())+1;
		 var amoutRow = $("#ampoutRow");
		 $("#ampoutRow").remove();
			
		 var suplier_option ='<select fieldno="'+number_of_field+'"   id="suplier_'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd suplier" name="data[ServiceBill]['+number_of_field+'][suplier]"> <option value="">Please Select</option>'+suplierList;
		 
		 field +='<tr id="row_'+number_of_field+'" class="implantAddMoreRows">';
		 field +='<td valign="middle" width="140"><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:135px;" class="validate[required,custom[mandatory-date]] textBoxExpnd implantDate  " id="implantDate_'+number_of_field+'" name="data[ServiceBill]['+number_of_field+'][date]" value="'+todayDate+'"> </td>';
		 field +='<td valign="middle">'+suplier_option+'</td>';
		 field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="implantServiceId_'+number_of_field+'" class="validate[required,custom[mandatory-enter]] textBoxExpnd implant_service"  div="false" label="false"> <input type="hidden" fieldno="'+number_of_field+'"  id="onlyImplantId_'+number_of_field+'" class="onlyImplantId" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" ></td>';
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="implantAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd implantAmount" readonly="readonly" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
		 field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="implantQty_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd implantQty" name="data[ServiceBill]['+number_of_field+'][no_of_times]" value="1">';
		 field +='<input type="hidden" fieldno="'+number_of_field+'"  id="ifix_discount_'+number_of_field+'" class="fix_discount" name="data[ServiceBill]['+number_of_field+'][fix_discount]" ></td>';
	     field +='<td id="implantTotalAmount_'+number_of_field+'" class="implantTotalAmount" align="center" width="100"></td>';
	     field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="implantDescription_'+number_of_field+'" class=" textBoxExpnd implantDescription" name="data[ServiceBill]['+number_of_field+'][description]"></td>';
		 field +=' <td align="center" width="50"><a href="javascript:void(0);" id="delete_row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="<?php echo $this->webroot ?>theme/Black/img/cross.png" ></a></td>  </tr>';
		 $("#no_of_fields").val(number_of_field);
		  
		 $("#implantArea").append(field);
		// $('#add-service-group-id1 option').clone().appendTo('#add-service-group-id'+number_of_field);
		 $("#removeVisit").css("visibility","visible");

		 var suplierList = <?php echo json_encode($supliers);?>;
   		 $.each(suplierList, function (key, value) {
   			$('#suplier_'+number_of_field).append( new Option(value, key) );
		 });

 
		 $('#implantServiceId_'+number_of_field).focus();//taking focus on sevice
		 //add  calender 
		 addCalenderOnDynamicField();
		 return number_of_field;
		}
	}
	
	//EOF implant data	
	
	// add more for other service data
	function addOtherService(obj)
	{	 
		var websiteInstance='<?php echo $configInstance;?>';	
		if(obj==null){
			splittedVarID =$("#no_of_fields").val(); //added by yashwant to add more by button.
		}else{
			splittedVarID = $(obj).attr('id').split("_")[1]; //added by panakj to avoid this bloody message.
		}
		
		if($('#otherServiceId_'+parseInt($("#no_of_fields").val())).val()=='' && splittedVarID == $("#no_of_fields").val()){
			alert('This service is not exist. Please enter another service.');
			$('#otherService_'+parseInt($("#no_of_fields").val())).val('');
			$('#otherServiceId_'+parseInt($("#no_of_fields").val())).val('');
			return false;
		}else{ 
			
			 var today = new Date(); 
			 var todayDate=today.format('d/m/Y H:i:s');
			 var field = ''; 
			 var amoutRow = $("#ampoutRow");
			 $("#ampoutRow").remove();
			 var number_of_field = parseInt($("#no_of_fields").val())+1;
			// var suplier_option ='<select fieldno="'+number_of_field+'"   id="suplier_'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd suplier" name="data[ServiceBill]['+number_of_field+'][suplier]"> <option value="">Please Select</option>'+suplierList;
			 
			 field +='<tr id="row_'+number_of_field+'" class="otherServiceAddMoreRows">';
			 field +='<td valign="middle" width="140"><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:135px;" class="validate[required,custom[mandatory-date]] textBoxExpnd otherServiceDate " id="otherServiceDate_'+number_of_field+'" name="data[ServiceBill]['+number_of_field+'][date]" value="'+todayDate+'"> </td>';
			// field +='<td valign="middle">'+suplier_option+'</td>';
			 field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="otherService_'+number_of_field+'" class="validate[required,custom[mandatory-enter]] textBoxExpnd other_service"  div="false" label="false"> <input type="hidden" fieldno="'+number_of_field+'"  id="otherServiceId_'+number_of_field+'" class="otherServiceId" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" ></td>';
			 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="otherServiceAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd otherServiceAmount " readonly="readonly" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
			 field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="otherServiceQty_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd otherServiceQty" name="data[ServiceBill]['+number_of_field+'][no_of_times]" value="1"></td>';
		     field +='<td id="otherServiceTotalAmount_'+number_of_field+'" class="otherServiceTotalAmount" align="center" width="100"></td>';
		     field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="otherServiceDescription_'+number_of_field+'" class=" textBoxExpnd otherServiceDescription" name="data[ServiceBill]['+number_of_field+'][description]"></td>';
			 field +=' <td align="center" width="50"><a href="javascript:void(0);" id="delete_row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="<?php echo $this->webroot ?>theme/Black/img/cross.png" ></a></td>  </tr>';
			 $("#no_of_fields").val(number_of_field);
			  
			 $("#otherServiceArea").append(field);
			 $("#removeVisit").css("visibility","visible");
	
			/* var suplierList = <?php //echo json_encode($supliers);?>;
	   		 $.each(suplierList, function (key, value) {
	   			$('#suplier_'+number_of_field).append( new Option(value, key) );
			 });*/
	 
			 $('#otherService_'+number_of_field).focus();//taking focus on sevice
			 //add  calender 
			 addCalenderOnDynamicField();
			 return number_of_field;
		}
	}
	//EOF other service addmore
	
	 
	// add more for radiotheraphy data
	function addRadiotheraphy(obj)
	{	 
		var websiteInstance='<?php echo $configInstance;?>';	
		if(obj==null){
			splittedVarID =$("#no_of_fields").val(); //added by yashwant to add more by button.
		}else{
			splittedVarID = $(obj).attr('id').split("_")[1]; //added by panakj to avoid this bloody message.
		}
		
		if($('#radiotheraphyId_'+parseInt($("#no_of_fields").val())).val()=='' && splittedVarID == $("#no_of_fields").val()){
			alert('This service is not exist. Please enter another service.');
			$('#radiotheraphy_'+parseInt($("#no_of_fields").val())).val('');
			$('#radiotheraphyId_'+parseInt($("#no_of_fields").val())).val('');
			return false;
		}else{ 
			
			 var today = new Date(); 
			 var todayDate=today.format('d/m/Y H:i:s');
			 var field = ''; 
			 var amoutRow = $("#ampoutRow");
			 $("#ampoutRow").remove();
			 var number_of_field = parseInt($("#no_of_fields").val())+1;
			 
			 field +='<tr id="row_'+number_of_field+'" class="radiotheraphyAddMoreRows">';
			 field +='<td valign="middle" width="140"><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:135px;" class="validate[required,custom[mandatory-date]] textBoxExpnd radiotheraphyDate " id="radiotheraphyDate_'+number_of_field+'" name="data[ServiceBill]['+number_of_field+'][date]" value="'+todayDate+'"> </td>';
			 field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="radiotheraphy_'+number_of_field+'" class="validate[required,custom[mandatory-enter]] textBoxExpnd radiotheraphy_service"  div="false" label="false"> <input type="hidden" fieldno="'+number_of_field+'"  id="radiotheraphyId_'+number_of_field+'" class="radiotheraphyId" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" ></td>';
			 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="radiotheraphyAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd radiotheraphyAmount "  name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
			 field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="radiotheraphyQty_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd radiotheraphyQty" name="data[ServiceBill]['+number_of_field+'][no_of_times]" value="1"></td>';
		     field +='<td id="radiotheraphyTotalAmount_'+number_of_field+'" class="radiotheraphyTotalAmount" align="center" width="100"></td>';
		     field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="radiotheraphyDescription_'+number_of_field+'" class=" textBoxExpnd radiotheraphyDescription" name="data[ServiceBill]['+number_of_field+'][description]"></td>';
			 field +=' <td align="center" width="50"><a href="javascript:void(0);" id="delete_row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="<?php echo $this->webroot ?>theme/Black/img/cross.png" ></a></td>  </tr>';
			 $("#no_of_fields").val(number_of_field);
			  
			 $("#radiotheraphyArea").append(field);
			 $("#removeVisit").css("visibility","visible");
	 
			 $('#radiotheraphy_'+number_of_field).focus();//taking focus on sevice
			 //add  calender 
			 addCalenderOnDynamicField();
			 return number_of_field;
		}
	}
	//EOF radiotheraphy addmore
	
	
	//add more code for blood service
	
	function addBloodService()
	{	 
		if($('#onlyBloodId_'+parseInt($("#no_of_fields").val())).val()==''){
			alert('This service is not exist. Please enter another service.');
			$('#bloodServiceId_'+parseInt($("#no_of_fields").val())).val('');
			$('#onlyBloodId_'+parseInt($("#no_of_fields").val())).val('');
			return false;
		}else{
			addMoreBloodHtml();		
		}
	}


	function addMoreBloodHtml(){
		//making amount fields readonly in all groups
		var websiteInstance='<?php echo $configInstance;?>';	
		/*if(websiteInstance=='kanpur'){
			var readonly = 'readonly = true';
		}else{
			 var readonly = '';
		}*/
		 var today = new Date(); 
		 var todayDate=today.format('d/m/Y H:i:s');
		 var field = '';
		 var number_of_field = parseInt($("#no_of_fields").val())+1;
		 var amoutRow = $("#ampoutRow");
		 $("#ampoutRow").remove();
			
		 var bank_option ='<select fieldno="'+number_of_field+'"   id="bloodBank_'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd bloodBank" name="data[ServiceBill]['+number_of_field+'][blood_bank]"> <option value="">Please Select</option>'+bankName;
		 
		 field +='<tr id="row_'+number_of_field+'" class="bloodAddMoreRows">';
		 field +=' <td valign="middle" width="140"><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:135px;" class="validate[required,custom[mandatory-date]] textBoxExpnd bloodDate " id="bloodDate_'+number_of_field+'" name="data[ServiceBill]['+number_of_field+'][date]" value="'+todayDate+'"> </td>';
		 field +=' <td valign="middle">'+bank_option+'</td>';
		 field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="bloodServiceId_'+number_of_field+'" class="validate[required,custom[mandatory-enter]] textBoxExpnd blood_service"  div="false" label="false"> <input type="hidden" fieldno="'+number_of_field+'"  id="onlyBloodId_'+number_of_field+'" class="onlyBloodId" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" ></td>';
		// field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="bloodAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd bloodAmount" '+readonly+' name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="bloodAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd bloodAmount" readonly="readonly" name="data[ServiceBill]['+number_of_field+'][amount]">';
		 field +='<input type="hidden" fieldno="'+number_of_field+'" id="bfix_discount_'+number_of_field+'" class="fix_discount" readonly="readonly" name="data[ServiceBill]['+number_of_field+'][fix_discount]"></td>';
		 field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="bloodQty_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd bloodQty" name="data[ServiceBill]['+number_of_field+'][no_of_times]" value="1"></td>';
	     field +='<td id="bloodTotalAmount_'+number_of_field+'" class="bloodTotalAmount" align="center" width="100"></td>';
	     field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="bloodDescription_'+number_of_field+'" class=" textBoxExpnd bloodDescription" name="data[ServiceBill]['+number_of_field+'][description]"></td>';
		 field +=' <td align="center" width="50"><a href="javascript:void(0);" id="delete_row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="<?php echo $this->webroot ?>theme/Black/img/cross.png" ></a></td>  </tr>';
		 $("#no_of_fields").val(number_of_field);
		  
		 $("#bloodArea").append(field);
		// $('#add-service-group-id1 option').clone().appendTo('#add-service-group-id'+number_of_field);
		// $("#bloodArea").append(amoutRow);
		 $("#removeVisit").css("visibility","visible");

		 var bankName = <?php echo json_encode($bloodBanks);?>;
   		 $.each(bankName, function (key, value) {
   			$('#bloodBank_'+number_of_field).append( new Option(value, key) );
		 });

 
		 $('#bloodServiceId_'+number_of_field).focus();//taking focus on sevice
		 //add  calender 
		 addCalenderOnDynamicField();
		 return number_of_field;
	}
	
	//EOF blood service  
	
	//BOF on key up enter event to add new row
    //BOF on key up enter event to add new row
$(document).on('keypress','.service_id', function(event) {
	var keycode = (event.keyCode ? event.keyCode : event.which);
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	ID=splitedVar[2]; 
	selVal = $('#onlyServiceId_'+ID).val();
	if(keycode == '13' && selVal != '' ){ 
		if(selVal) //addnew row only if selection is done 
		addServiceVisitElement();//insert new row 
	}
	
});

$(document).on('keypress','.totalSertviceQty', function(event) {
	var keycode = (event.keyCode ? event.keyCode : event.which);
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	ID=splitedVar[3]; 
	selVal = $('#onlyServiceId_'+ID).val();
	if(keycode == '13' && selVal != '' ){ 
		if(selVal) //addnew row only if selection is done 
		addServiceVisitElement();//insert new row 
	}
	
});
//EOF enter event by pankaj

$(document).on('keypress','.other_service, .otherServiceQty', function(event) {
	var keycode = (event.keyCode ? event.keyCode : event.which);
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	ID=splitedVar[1]; 
	selVal = $('#otherServiceId_'+ID).val();
	if(keycode == '13' && selVal != '' ){ 
		if(selVal) //addnew row only if selection is done 
			addOtherService(this);//insert new row 
	}
	
});

$(document).on('keypress','.implant_service, .implantQty', function(event) {
	var keycode = (event.keyCode ? event.keyCode : event.which);
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	ID=splitedVar[1]; 
	selVal = $('#implantQty_'+ID).val();
	if(keycode == '13' && selVal != '' ){ 
		if(selVal) //addnew row only if selection is done 
			addMoreImplantHtml();//insert new row 
	}
});

//keypress addmore for radiotheraphy  --yashwant
$(document).on('keypress','.radiotheraphy_service, .radiotheraphyQty', function(event) {
	var keycode = (event.keyCode ? event.keyCode : event.which);
	currentID=$(this).attr('id');
	splitedVar=currentID.split('_');
	ID=splitedVar[1]; 
	selVal = $('#radiotheraphyId_'+ID).val();
	if(keycode == '13' && selVal != '' ){ 
		if(selVal) //addnew row only if selection is done 
			addRadiotheraphy(this);//insert new row 
	}
	
});

	//Add more for services moved from permission.js
	function addServiceVisitElement()
	{	 
		//making amount fields readonly in all groups
		var websiteInstance='<?php echo $configInstance;?>';	
		/*if(websiteInstance=='kanpur'){ //DO NOT REMOVE COMENTED CODE  --YASHWANT
			var readonly = 'readonly = true';
		}else{
			 var readonly = '';
		}*/
		 
		if($('#onlyServiceId_'+$("#no_of_fields").val()).val()==''){
			alert('This service is not exist. Please enter another service.');
			$('#service_id_'+$("#no_of_fields").val()).val('');
			$('#onlyServiceId_'+$("#no_of_fields").val()).val('');
			return false;
		}else{

		 var today = new Date(); 
		 var tadayDate=today.format('d/m/Y H:i:s');
		 var field = '';
		 var number_of_field = parseInt($("#no_of_fields").val())+1; 
		 var amoutRow = $("#ampoutRow");
		 $("#ampoutRow").remove();
		 field +='<tr id="row_'+number_of_field+'" class="serviceAddMoreRows">';
		 if(isPackagedPatient){
		 field += '<td><input type="checkbox" fieldno="'+number_of_field+'" value="1" id="isBillableService_'+number_of_field+'"  class="textBoxExpnd" name="data[ServiceBill]['+number_of_field+'][is_billable]"></td>';
		}
		field +=' <td valign="middle" width="140"><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:135px;" class="validate[required,custom[mandatory-date]] textBoxExpnd ServiceDate" id="ServiceDate_'+number_of_field+'" name="data[ServiceBill]['+number_of_field+'][date]" value="'+tadayDate+'"> </td>';
		// field +=' <td align="center" width="150"><select fieldno="'+number_of_field+'" class="textBoxExpnd add-service-group-id" style="width:150px;" id="add-service-group-id'+number_of_field+'" 	  name="data[ServiceBill]['+number_of_field+'][service_id]" onchange="getListOfSubGroupServices(this);"> </select></td>';
		// field +=' <td align="center"width="150"><select fieldno="'+number_of_field+'" style="width:150px;" class="textBoxExpnd add-service-sub-group" name="data[ServiceBill]['+number_of_field+'][sub_service_id]" id="add-service-sub-group'+number_of_field+'"   onchange="serviceSubGroups(this)"> </select></td>';
		// field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'"  id="add-service-sub-group'+number_of_field+'" class="service-sub-group textBoxExpnd " name=" " > <input type="hidden" fieldno="'+number_of_field+'"  id="addServiceSubGroupId_'+number_of_field+'" class="addServiceSubGroupId" name="data[ServiceBill]['+number_of_field+'][sub_service_id]" ></td>';
		 field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="service_id_'+number_of_field+'" class="validate[required,custom[mandatory-enter]] textBoxExpnd service_id" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" div="false" label="false"> <input type="hidden" fieldno="'+number_of_field+'"  id="onlyServiceId_'+number_of_field+'" class="onlyServiceId" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" ></td>';
		 //field +=' <td align="center" width="150"><select fieldno="'+number_of_field+'" style="width:150px;" id="service_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd service_id" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" onchange="service_id(this);"> <option value="">Please Select</option> <option value="0"></option> </select></td>';
		 //field +='<td align="center" width="100"><select fieldno="'+number_of_field+'" style="width:100px;" id="service_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd " name="data[ServiceBill]['+number_of_field+'][hospital_cost]" onchange="service_id(this);"> <option value="">Please Select</option> <option value="0"></option> </select></td>';
		// field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="service_amount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd service_amount " '+readonly+' name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="service_amount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd service_amount clinicalServiceAmount" readonly="readonly" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
		 field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="no_of_times_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd no_of_times nofTime totalSertviceQty" name="data[ServiceBill]['+number_of_field+'][no_of_times]" value="1">';
		 field +='<input type="hidden" fieldno="'+number_of_field+'" id="fix_discount_'+number_of_field+'" class=" fix_discount" name="data[ServiceBill]['+number_of_field+'][fix_discount]"></td>';
	     field +='<td id="amount_'+number_of_field+'" class="amount" align="center" width="100"></td>';
	     field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="description_'+number_of_field+'" class=" textBoxExpnd description" name="data[ServiceBill]['+number_of_field+'][description]"></td>';
		 field +=' <td align="center" width="50"><a href="javascript:void(0);" id="delete_row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="<?php echo $this->webroot ?>theme/Black/img/cross.png" ></a></td>  </tr>';
		 $("#no_of_fields").val(number_of_field);
		  
		 $("#serviceGrid").append(field);
		 $('#add-service-group-id1 option').clone().appendTo('#add-service-group-id'+number_of_field);
		 $("#consulTantGrid").append(amoutRow);
		 $("#removeVisit").css("visibility","visible");

		 $('#service_id_'+number_of_field).focus();//taking focus on sevice
		 //add  calender 
		 addCalenderOnDynamicField();
		 return number_of_field;
		}
 
	}

	//EOF Add more for services
	
	
	// BOF Add more consultant visits
	
	function addConsultantVisitElement()
	{
		//making amount fields readonly in all groups
		var websiteInstance='<?php echo $configInstance;?>';	
		/*if(websiteInstance=='kanpur'){
			var readonly = 'readonly = true';
		}else{
			 var readonly = '';
		}*/
		
		if($('#onlyConsultantServiceId_'+$("#no_of_fields").val()).val()==''){
			alert('This Consultatn service is not exist. Please enter another Consultant.');
			$('#consultant_service_id_'+$("#no_of_fields").val()).val('');
			$('#onlyConsultantServiceId_'+$("#no_of_fields").val()).val('');
			return false;
		}else{
			
		 var today = new Date(); 
		 var tadayDate=today.format('d/m/Y H:i:s');
		 var field = '';
		 var number_of_field = parseInt($("#no_of_fields").val())+1; 
		 var amoutRow = $("#ampoutRow");
		 $("#ampoutRow").remove();
		 field +='<tr id="row_'+number_of_field+'" class="consultantAddMoreRows">';
		 field +=' <td valign="middle" width=""><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:135px;" class="validate[required,custom[mandatory-date]] textBoxExpnd ConsultantDate" id="ConsultantDate_'+number_of_field+'" name="data[ConsultantBilling]['+number_of_field+'][date]" value="'+tadayDate+'"> </td>';
		 field +=' <td valign="middle"><input type="checkbox" fieldno="'+number_of_field+'" class="notToPayDr" id="notToPayDr_'+number_of_field+'" name="data[ConsultantBilling]['+number_of_field+'][not_to_pay_dr]" value="1"> </td>';
		 field +=' <td valign="middle"> <select fieldno="'+number_of_field+'" style="width:152px;" id="category_id_'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd category_id" name="data[ConsultantBilling]['+number_of_field+'][category_id]" onchange="categoryChange(this)"> <option value="">Please select</option> <option value="0">External Consultant</option> <option value="1">Treating Consultant</option> </select> </td>';
		 field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" style="width:152px;" id="doctor_id_'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd doctor_id" 	name="data[ConsultantBilling]['+number_of_field+'][doctor_id]" onchange="doctor_id(this)"> <option value="">Please Select</option> <option value="0"></option> </select> </td>';
		 //field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" class="textBoxExpnd service_category_id" style="width:167px;" id="service-group-id'+number_of_field+'" 	  name="data[ConsultantBilling][service_category_id][]" onchange="getListOfSubGroup(this);"> </select></td>';
		 field +='<td align="center" width=""><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="consultant_service_id_'+number_of_field+'" class="validate[required,custom[mandatory-enter]] textBoxExpnd consultant_service_id" name="data[ConsultantBilling]['+number_of_field+'][consultant_service_name]" div="false" label="false"> <input type="hidden" fieldno="'+number_of_field+'"  id="onlyConsultantServiceId_'+number_of_field+'" class="onlyConsultantServiceId" name="data[ConsultantBilling]['+number_of_field+'][consultant_service_id]" ></td>';
		 //field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd consultant_service_id" style="width:150px;" name="data[ConsultantBilling][consultant_service_id][]" id="consultant_service_id'+number_of_field+'"   onchange="consultant_service_id(this)"><option value="">Please Select</option></select></td>';
		 //field +=' <td valign="middle" style="text-align: center;"><select fieldno="'+number_of_field+'" style="width:130px;" id="hospital_cost'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd hospital_cost" name="data[ConsultantBilling][hospital_cost][]" ><option value="">Please Select</option><option value="private">Private</option><option value="cghs">CGHS</option><option value="other">Other</option></select></td>';
		// field +='<td valign="middle" style="text-align: right;"><input type="text" fieldno="'+number_of_field+'" style="width:80px; text-align:right;" id="amountConsultant_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd amount" '+readonly+' name="data[ConsultantBilling][amount]['+number_of_field+']"></td>';
		 field +='<td valign="middle" style="text-align: right;"><input type="text" fieldno="'+number_of_field+'" style="width:80px; text-align:right;" id="amountConsultant_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd amount" readonly="readonly" name="data[ConsultantBilling]['+number_of_field+'][amount]"></td>';
		 field +='<td valign="middle" style="text-align: center;"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="description_'+number_of_field+'" class="textBoxExpnd description" name="data[ConsultantBilling]['+number_of_field+'][description]"></td>';
		 field +='<td valign="middle" style="text-align: center;"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="payToConsultant_'+number_of_field+'" class="textBoxExpnd pay_to_consultant class="validate[optional,custom[onlyNumber]]" name="data[ConsultantBilling]['+number_of_field+'][pay_to_consultant]"></td>';
		 field +=' <td valign="middle" style="text-align:center;"><a href="javascript:void(0);" id="delete row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="<?php echo $this->webroot ?>theme/Black/img/cross.png" ></a></td>  </tr>';
		 $("#no_of_fields").val(number_of_field);
		 $("#consulTantGridNew").append(field);
		 $('#service-group-id'+(number_of_field-1)+' option').clone().appendTo('#service-group-id'+number_of_field);
		 $("#consulTantGridNew").append(amoutRow);
		 $("#removeVisit").css("visibility","visible");
		 
		 $('#consultant_service_id_'+number_of_field).focus();//taking focus on sevice
		 //add  calender 
		 addCalenderOnDynamicField();
		 return number_of_field;
		}
	}
	
	// EOF Add more consultant visits
	
	// delete visit row
	
	 function deleteVisitRow(rowID){
		var number_of_field = parseInt($("#no_of_fields").val());
		
		if(number_of_field > 1){
			$("#row_"+rowID).remove();
			$("#no_of_fields_").val(number_of_field-1);
		}
		if (parseInt($("#no_of_fields").val()) == 1){
			$("#removeVisit").show();
		}
		
		$( '.clinicalServiceAmount').trigger("change");//to maintain clinical service amount  --yashwant
		$( '.otherServiceAmount').trigger("change");//to maintain other service amount  --yashwant
		$( '.radiotheraphyAmount').trigger("change");//to maintain radiotheraphy amount  --yashwant
	 }

	/* function deleteConsultantVisitRow(rowID){
		var number_of_field = parseInt($("#no_of_consultant_fields").val());
		
		if(number_of_field > 1){
			$("#rowConsultant_"+rowID).remove();
			$("#no_of_consultant_fields").val(number_of_field-1);
		}
		if (parseInt($("#no_of_consultant_fields").val()) == 1){
			$("#removeVisit").show();
		}
	 }*/
	
	$(".discountType").change(function(){
		var type = $(this).val();
		$("#discount").show(); 
		$("#discount").val('');
		if(type == "Percentage"){
			$("#show_percentage").show();	
		}else{
			$("#show_percentage").hide();	
		}
		//display();
		discountFunction();
	 	if($("#card_pay").is(":checked")){
			$("#card_pay").trigger('click');
	 	}
	});



	 $("#is_refund").click(function(){
	    if($('#is_refund').is(':checked')){
	        $("#refund_amount").show();
	        $("#hrefund").val(1);
	        /*if(parseInt($("#totalamount").val()) >= 10000)	
			{
		        $("#discount_authorize_by_for_refund").show();
		        $("#send-approval-for-refund").show();
			}*/
		}else{
			$("#refund_amount").hide();
			$("#hrefund").val(0);
			/*$("#discount_authorize_by_for_refund").hide();
			$("#send-approval-for-refund").hide();
			$("#refund_amount").val(0);*/
		}
		display();
	 });	 

		function refundFunction(){//for maintaining refund checkbox  --yashwant
			if($('#is_refund').is(':checked')){ 
		        $("#refund_amount").show();
		        $("#hrefund").val(1);
			}else{
				var configPharmacyData='<?php echo strtolower($configPharmacyData['cashCounter']); ?>';
				if(configPharmacyData=='no'){ 
					$("#refund_amount").show(); 
					$("#is_refund").show();
					//$("#is_refund").attr("checked",true);
					$("#hrefund").val(1);
				}else{ 
					//$("#refund_amount").hide();
					$("#hrefund").val(0);
				}
			}
			display();
		}
	
	$("#discount").keyup(function(){ //code is used in two places --yashwant 
		var currentID=$(this).attr('id');
		var disAmount=parseInt($(this).val());
		var disChargebleAmount=parseInt($('#amount_for_discount').val()); 
		//conditions for discount more than chargable amount is not allowed  --yashwant
		var disTypeVar=returnDiscType();
		if(disTypeVar=='Amount'){
			if(disAmount<=disChargebleAmount){
				discountFunction();
				if($("#card_pay").is(":checked")){
					$("#card_pay").trigger('click');
			 	}
			}else{
				inlineMsg(currentID,errorDiscountMsg,5);
				$(this).val('');
				discountFunction();
			}
		}else{
			if(disAmount<=100){
				discountFunction();
				if($("#card_pay").is(":checked")){
					$("#card_pay").trigger('click');
			 	}
			}else{
				inlineMsg(currentID,errorDiscountMsg,5);
				$(this).val('');
				discountFunction();
			}
		}
		//EOF
	});

	function returnDiscType(){
		var type  = ''; 
		$(".discountType").each(function () {  
	        if ($(this).prop('checked')) {
	           type = this.value;
	        }
		});
		return type;
	}

	
	function discountFunction(){
		display();
		//$("#totalamountpending").val(0);//DO NOT REMOVE, coz maintaining balance  --yashwant
		if(instance == "vadodara"){
			if(parseInt($("#totalamount").val()) >= 10000 && $("#discount").val()>=1)	//if total amount is greater or equal to 10000 then it is possible to give approval for discount or refund
			{
				$("#discount_authorize_by").show();
				$("#discount_reason").show();
				if($("#is_approved").val() == 0){
					$("#send-approval").show();
				}
				$("#is_approved").val(1);
			}else if(parseInt( $("#discount").val())>=1){
				$("#discount_authorize_by").show();
				$("#discount_reason").show();
			}else{
				$("#discount_authorize_by").hide();
				$("#discount_reason").hide();
				$("#send-approval").hide();
				$("#is_approved").val(0);
			}
		}
		/*if(instance == "vadodara"){
			if(parseInt( $("#discount").val())>=1)	//if total amount is greater or equal to 10000 then it is possible to give approval for discount or refund
			{
				$("#discount_authorize_by").show();
				$("#discount_reason").show();
			}else{
				$("#discount_authorize_by").hide();
				$("#discount_reason").hide();
			}
		}*/
		else if(instance == "kanpur"){	
			if(parseInt($("#totalamount").val()) >= 1 && $("#discount").val()>=1)	//if total amount is greater or equal to 10000 then it is possible to give approval for discount or refund
			{
				$("#discount_authorize_by").show();
				$("#discount_reason").show();
				if($("#is_approved").val() == 0){
					$("#send-approval").show();
				}
				$("#is_approved").val(1);
			}else{
				$("#discount_authorize_by").hide();
				$("#discount_reason").hide();
				$("#send-approval").hide();
				$("#is_approved").val(0);
			}
		}
	}

	var balanCe = parseInt($("#totalamountpending").val());	//hold the balance
	/*$("#refund_amount").keyup(function(){ //--comented dy yashwant
		showRefundButton();
	});*/

	/*$("#refund_amount").keyup(function(){ 
		//for hope pharmacy //--comented removed dy yashwant
		var selRadioForRefund=$("input[type='radio'][name='serviceGroupData']:checked").attr('radioName');
		selRadioForRefund=selRadioForRefund.split('_');
		selRadioForRefund=selRadioForRefund[0];
		var configPharmacyData='<?php //echo strtolower($configPharmacyData['cashCounter']); ?>';
		if(selRadioForRefund=='pharmacy' && configPharmacyData=='no'){ 
			if(!$("#refund_amount").attr("readonly")){  
				display();//showRefundButton();
			}
		} 
	});*/

	function showRefundButton(){// to show refund button  --yashwant
		refund = ($('#refund_amount').val()!='')?$('#refund_amount').val() : 0;
		if(instance == "vadodara"){
			if(refund >= 10000){	// if refund amount >=10,000, request for approval by Swapnil G.Sharma
				$("#discount_authorize_by_for_refund").show();
			    $("#send-approval-for-refund").show();
			    $("#is_refund_approved").val(1);
			}else{
				$("#discount_authorize_by_for_refund").hide();
				$("#send-approval-for-refund").hide();
				$("#is_refund_approved").val(0);
			}
		}
		else if(instance == "kanpur"){		
			if(refund >= 1){	// if refund amount >=10,000, request for approval by Swapnil G.Sharma
				$("#discount_authorize_by_for_refund").show();
			    $("#send-approval-for-refund").show();
			    $("#is_refund_approved").val(1);
			}else{
				$("#discount_authorize_by_for_refund").hide();
				$("#send-approval-for-refund").hide();
				$("#is_refund_approved").val(0);
			}
		}
 
		/*mRefund = ($("#maintainRefund").val()!='')?$("#maintainRefund").val():0;
		mDiscount = ($("#maintainDiscount").val()!='')?$("#maintainDiscount").val():0;
		var adV = parseInt($("#totaladvancepaid").val());
		var discount = parseInt(($("#discount").val()!='')?$("#discount").val():0);
		var amountPaid = parseInt(($("#amount").val()!='')?$("#amount").val():0);
		var total = parseInt($("#totalamount").val()) - adV -amountPaid-discount-parseInt(mDiscount)+ parseInt(refund) +parseInt(mRefund);
		$("#totalamountpending").val(total);*/

			//for changing remark for received and refunded amount  
			if(refund!='' && refund!=0){
				$(".paymentRemarkReceived").hide();
				$(".paymentRemarkRefund").show();
				$("#receivedRemark").prop("disabled",true);
				$("#refundRemark").prop("disabled",false);
				
			}else{
				$(".paymentRemarkReceived").show();
				$(".paymentRemarkRefund").hide();
				$("#refundRemark").prop("disabled",true);
				$("#receivedRemark").prop("disabled",false);
			}
		}
	
	function showRefundButton1(){// to show refund button  --yashwant
		refund = ($('#refund_amount').val()!='')?$('#refund_amount').val() : 0;
		if(instance == "vadodara"){
			if(refund >= 10000){	// if refund amount >=10,000, request for approval by Swapnil G.Sharma
				$("#discount_authorize_by_for_refund").show();
			    $("#send-approval-for-refund").show();
			    $("#is_refund_approved").val(1);
			}else{
				$("#discount_authorize_by_for_refund").hide();
				$("#send-approval-for-refund").hide();
				$("#is_refund_approved").val(0);
			}
		}
		else if(instance == "kanpur"){		
			if(refund >= 1){	// if refund amount >=10,000, request for approval by Swapnil G.Sharma
				$("#discount_authorize_by_for_refund").show();
			    $("#send-approval-for-refund").show();
			    $("#is_refund_approved").val(1);
			}else{
				$("#discount_authorize_by_for_refund").hide();
				$("#send-approval-for-refund").hide();
				$("#is_refund_approved").val(0);
			}
		}
 
		mRefund = ($("#maintainRefund").val()!='')?$("#maintainRefund").val():0;
		mDiscount = ($("#maintainDiscount").val()!='')?$("#maintainDiscount").val():0;
		var adV = parseInt($("#totaladvancepaid").val());
		var discount = parseInt(($("#discount").val()!='')?$("#discount").val():0);
		var amountPaid = parseInt(($("#amount").val()!='')?$("#amount").val():0);
		var total = parseInt($("#totalamount").val()) - adV -amountPaid-discount-parseInt(mDiscount)+ parseInt(refund) +parseInt(mRefund);
		$("#totalamountpending").val(total);

			//for changing remark for received and refunded amount  
			if(refund!='' && refund!=0){
				$(".paymentRemarkReceived").hide();
				$(".paymentRemarkRefund").show();
				$("#receivedRemark").prop("disabled",true);
				$("#refundRemark").prop("disabled",false);
				
			}else{
				$(".paymentRemarkReceived").show();
				$(".paymentRemarkRefund").hide();
				$("#refundRemark").prop("disabled",true);
				$("#receivedRemark").prop("disabled",false);
			}
		}
	 
	function display()	//calculate final balance
	{
		/*var validatePerson = jQuery("#paymentDetail").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}*/
		paymentCategory=$("input[type='radio'][name='serviceGroupData']:checked").attr('radioName');
		paymentCategory=paymentCategory.split('_');
		paymentCategory=paymentCategory[0];
		/*if(paymentCategory=='mandatoryservices' || paymentCategory=='laboratory' || paymentCategory=='radiology'){//for mandattory services,lab,rad don aloow partial payment
			$('#amount').val($("#totalamountpending").val());
		}*///commented for hospital billing
		var disc = '';
		total_amount = ($('#totalamount').val() != '') ? parseInt($('#totalamount').val()) : 0; 
		discount_on_amount=($('#amount_for_discount').val() != '') ? parseInt($('#amount_for_discount').val()) : 0; 
		$(".discountType").each(function () {  
	        if ($(this).prop('checked')) {
	           var type = this.value;
			   $("#discType").val(type);
	           if(type == "Amount")
	            {    
	            	disc = ($("#discount").val() != '') ? parseInt($("#discount").val()) : 0;
	            }else if(type == "Percentage")
	            {
	            	var discount_value = ($("#discount").val()!= '') ? parseInt($("#discount").val()) : 0;
					if(discount_value < 101){
	       		    	//disc = parseInt(Math.ceil((total_amount*discount_value)/100));
						disc = parseInt(Math.ceil((discount_on_amount*discount_value)/100));
					}else{
						alert("Percentage should be less than or equal to 100");
						$("#discount").val('');
					}
	            }
	           $("#disc").val(disc);	
	        }
	    });
	    
		mRefund = ($("#maintainRefund").val()!='')?$("#maintainRefund").val():0;
		mDiscount = ($("#maintainDiscount").val()!='')?$("#maintainDiscount").val():0;
		balance = ($('#totalamountpending').val() != '') ? parseInt($("#totalamountpending").val()) : 0;
		
		var tariffListArray=$('#tariff_list_id').val();//to maintain per service discount --yashwant 
		/*if($("#amount").attr("readonly") && tariffListArray!=''){ 
			$("#amount").val(partialAmountPaid - disc - parseInt(mDiscount));
	    }else */
	    console.log(partialAmountPaid);
	    if($("#amount").attr("readonly")){  
	    	$("#amount").val(partialAmountPaid - disc);//by swapnil
		}
		amount_paid = ($('#amount').val() != '') ? parseInt($("#amount").val()) : 0;
	 	total_advance = ($('#totaladvancepaid').val() != '') ? parseInt($('#totaladvancepaid').val()) : 0;
	 	
	 	if($('#is_refund').is(':checked'))
		{
	 		refund_amount = ($('#refund_amount').val() != '') ? parseInt($("#refund_amount").val()) : 0;
	 	}else{
			refund_amount = 0;
	 	} 	
	 	 
		bal = total_amount - total_advance - amount_paid - disc -parseInt(mDiscount) + parseInt(refund_amount)+parseInt(mRefund);

		if(isNaN(bal)==false)
			$('#totalamountpending').val(bal);	//show bal reduce refund , remove for vadodara, used in hope
		else
			$('#totalamountpending').val('');

		
		/*if(paymentCategory=='mandatoryservices' || paymentCategory=='laboratory' || paymentCategory=='radiology'){//for mandattory services,lab,rad dont aloow partial payment
			$('#amount').val(bal);
		}else{
	 		$('#totalamountpending').val(bal);
		}*///commented for hospital billing
	}

	
	$("#send-approval").click(function(){

		if($("#discount").val() == '' || $("#discount").val() == 0)
		{
			alert('Please Enter Discount');
			return false;
		}
		else if($("#discount_authorize_by").val() == 'empty')
	    {
	    	alert('Please select the user for approval');
			return false;
	    }else if($('#discount_reason').val() == 'empty')
		{
			alert("Please select reason for discount");
		}
	    else if($("#discount_authorize_by").val() != 'empty' && $("#discount").val() != '')
		{
	    	$(".discountType").each(function () {  		//check the radio whether Amount or Percentage
		        if ($(this).prop('checked')) {
					type = this.value;				
		        }
		    });

		    patientId = '<?php echo $patientID; ?>';
			discount = $("#discount").val();			//discount may be amount or percentage
			totalamount = $("#totalamount").val();
			user = $("#discount_authorize_by").val();	//authhorized user whom we are sending approval
			reasonForDiscount = $('#discount_reason').val();
			payment_category = $('#serviceGroupId').val();


			$.ajax({
				  type : "POST",
				  data: "patient_id="+patientId+"&type="+type+"&discount="+discount+"&total_amount="+totalamount+"&request_to="+user+"&payment_category="+payment_category+"&reason="+reasonForDiscount,
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "requestForApproval","admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					  $("#busy-indicator").show();
				  },	
				  success: function(data){ 
					 $("#busy-indicator").hide(); 
					 $("#mesage").show();
					 if(parseInt(data) == 1)
					{
						$("#status-approved-message").html(" send apporval Request for discount has been sent, please wait for approval");
						$("#is_approved").val(1);	//for approval waiting
						 $("#image-gif").show();
						 $("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
						 $("#send-approval").hide();	//hide send approval button 
						 $("#cancel-approval").show();	//show reset button
						 $(".discountType").prop("disabled",true);
						 $("#discount").attr('readonly',true);
						 $("#discount_authorize_by").attr('disabled',true);
						 $("#discount_reason").attr('disabled',true);
						 interval = setInterval("Notifications()", 10000);  // this will call Notifications() function in each 5000ms
					}
				} //end of success
			}); //end of ajax
		} //end of if else
		
	});


	//set request timer to check approval status 
	function Notifications()
	{
		type = '' ; //amount or percentage 
		$(".discountType").each(function () {  		//check the radio whether Amount or Percentage
	        if ($(this).prop('checked')) {
				type = this.value;				
	        }
	    });
		patientId = '<?php echo $patientID; ?>';
    	user = $("#discount_authorize_by").val();
    	payment_category = $('#serviceGroupId').val();

    	
        $.ajax({
        	type : "POST",
			  data: "patient_id="+patientId+"&type="+type+"&request_to="+user+"&payment_category="+payment_category,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "Resultofrequest","admin" => false)); ?>",
			  context: document.body,	
			  success: function(data){ 

				  $("#mesage").show();	//message Container
				  $(".discountType").prop("disabled",true);
				  $("#discount").attr('readonly',true);
				  $("#discount_authorize_by").show();			//show Approval users
				  $("#discount_authorize_by").attr('disabled',true);
				  $("#discount_reason").show();					//show Reason
				  $("#discount_reason").attr('disabled',true);
				  $("#discount_authorize_by").attr('disabled',true);
				  $("#send-approval").hide();
				  $("#cancel-approval").show();			//show cancel button to remove approval
				  
				if(parseInt(data) == 0)
				{
					$("#status-approved-message").html("Request for discount has been sent, please wait for approval");
					$("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>');
					$("#is_approved").val(1);
					$("#send-approval").hide();
				}else
				if(data == 1)		//approved
				{
					$("#status-approved-message").html('<font color="green">Request for discount has been completed</font>');
					$("#image-gif").hide();
					$("#discount").prop("readonly", true);
					$("#is_approved").val(2);  //for approval complete
					clearInterval(interval); // stop the interval
				}
				else
				if(data == 2)		// if rejected by users
				{
					$("#mesage").show();
					$("#status-approved-message").html('<font color="red">Request for discount has been rejected</font>');
					$("#image-gif").hide();
					$("#is_approved").val(3);	// for approval reject
					clearInterval(interval); 	// stop the interval 
					resetDiscountRefund();//do not remove, for clearing request
					display();
				}
			} //end of success
		});
	}

	function resetDiscountRefund()
	{
		$("#is_approved").val(0);
		$("#disc").val(0);
		$("#discount").hide();
		$("#show_percentage").hide();
		$("#discount_authorize_by").hide();
		$("#discount_authorize_by").attr('disabled',false);
		$("#discount_reason").attr('disabled',false);
		$("#discount_reason").hide();
		$("#send-approval").hide();
		$("#cancel-approval").hide();
		$("#discount").prop("readonly", false);
		$("#discount").prop('disabled',false);
		$(".discountType").prop("disabled",false);
		$(".discountType").attr('checked',false)
		$("#mesage").hide();
	}

	function resetRefund()
	{
		$("#is_refund").attr('disabled',false);
		$("#disc").val(0);
		$("#is_refund").attr('checked',false);
		$("#refund_amount").attr('readonly',false);
		$("#refund_amount").val('');

		var selRadioForRefund=$("input[type='radio'][name='serviceGroupData']:checked").attr('radioName');
		selRadioForRefund=selRadioForRefund.split('_');
		selRadioForRefund=selRadioForRefund[0];
		var configPharmacyData='<?php echo strtolower($configPharmacyData['cashCounter']); ?>';
		if(selRadioForRefund=='pharmacy' && configPharmacyData=='no'){ 
			$("#refund_amount").hide();
			$("#is_refund").attr("checked",true);
			$("#is_refund").show();
			$("#is_refund").attr('type','checkbox');
		}else{
			$("#refund_amount").hide();
		}
		$("#discount_authorize_by_for_refund").attr('disabled',false);
		$("#discount_authorize_by_for_refund").hide();
		$("#send-approval-for-refund").hide();
		$("#cancel-refund-approval").hide();
		$("#mesage2").hide();
	}
		
		
	
	//for cancelling the unapproved approval of discount only
	 $("#cancel-approval").click(function(){

		 var conResult = confirm("Are you sure to cancel the request for discount?");
		 if(conResult == true)
		 {
			patientId = '<?php echo $patientID; ?>';
			discount = $("#discount").val();
			user = $("#discount_authorize_by").val();
			payment_category = $('#serviceGroupId').val();

			
			$('input:radio').each(function () { 
		        if ($(this).prop('checked')) {
		            type = this.value;
		            }
		        });

			$.ajax({
				  type : "POST",
				  data: "patient_id="+patientId+"&request_to="+user+"&type="+type+"&payment_category="+payment_category,
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "cancelApproval","admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					  $("#busy-indicator").show();
				  },	
				  async: false,
				  success: function(data){ 
					$("#busy-indicator").hide(); 
					clearInterval(interval); 					// stop the interval
					resetDiscountRefund();
					display();
					resetPaymentDetail();//to reset payment detail block --yashwant 
				  }
			});
	 	}else{
		 	return false;
	 	}
	 });

	 $("#send-approval-for-refund").click(function(){

			/*if($("#refund_amount").val() == '' || $("#refund_amount").val() == 0)
			{
				alert('Please Enter refund amount');
				return false;
			}
			else*/ 
			if($("#discount_authorize_by_for_refund").val() == 'empty')
		    {
		    	alert('Please select the user for refund approval');
				return false;
		    }
		    else if($("#discount_authorize_by_for_refund").val() != 'empty' && $("#refund_amount").val() != '')
			{
					var user = $("#discount_authorize_by_for_refund").val();
					var patientId = '<?php echo $patientID; ?>';
					refundAmount = $("#refund_amount").val();
					payment_category = $('#serviceGroupId').val();

					total_amount = $("#totalamount").val();
			
					$.ajax({
						  type : "POST",
						  data: "patient_id="+patientId+"&type=Refund&refund_amount="+refundAmount+"&total_amount="+total_amount+"&request_to="+user+"&payment_category="+payment_category,
						  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "requestForApproval","admin" => false)); ?>",
						  context: document.body,
						  async: false,
						  beforeSend:function(){
							  $("#busy-indicator").show();
						  },	
						  success: function(data){ 
							 $("#busy-indicator").hide(); 
							 $("#mesage2").show();
							 if(data == 1)
							{
								$("#status-approved-message-for-refund").html("Request for Refund has been sent, please wait for approval");
								$("#is_refund_approved").val(1);	//for approval waiting
								 $("#image-gif2").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
								 refund_interval = setInterval("NotificationsForRefund()", 10000);  // this will call Notifications() function in each 5000ms
								$("#refund_amount").attr('readonly',true);
								$("#is_refund").attr('disabled',true);
								$("#discount_authorize_by_for_refund").attr('disabled',true); 
								$("#send-approval-for-refund").hide();
								$("#cancel-refund-approval").show();
							}
						} //end of success
					}); //end of ajax
			} //end of if else
			
		});


	//for cancelling the unapproved approval of discount only
	 $("#cancel-refund-approval").click(function(){
		var confirmResult = confirm("Are you sure to cancel the request for refund?");
		if(confirmResult == true){
			patientId = '<?php echo $patientID; ?>';
			refund_amount = $("#refund_amount").val();
			user = $("#discount_authorize_by_for_refund").val();
			payment_category = $('#serviceGroupId').val();

			type = "Refund";
			
			$.ajax({
				  type : "POST",
				  data: "patient_id="+patientId+"&request_to="+user+"&type="+type+"&payment_category="+payment_category,
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "cancelApproval","admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					  $("#busy-indicator").show();
				  },	
				  async: false,
				  success: function(data){ 
					$("#busy-indicator").hide(); 
					$("#is_refund_approved").val(0);
					clearInterval(refund_interval); 					// stop the interval
					resetRefund();
					display();
					resetPaymentDetail();//to reset payment detail block --yashwant 
				  }
			});
		}else{
			return false;
		}
	 });

	 function NotificationsForRefund()
		{
			type = "Refund" ;  
			patientId = '<?php echo $patientID; ?>';
	    	user = $("#discount_authorize_by_for_refund").val();
	    	payment_category = $('#serviceGroupId').val();

	    	
	        $.ajax({
	        	type : "POST",
				  data: "patient_id="+patientId+"&type="+type+"&request_to="+user+"&payment_category="+payment_category,
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "Resultofrequest","admin" => false)); ?>",
				  context: document.body,	
				  async: false,
				  success: function(data){ 
					 //$("#busy-indicator").hide(); 
					 $("#mesage2").show();
					if(parseInt(data) == 0)
					{
						$("#status-approved-message-for-refund").html("Request for Refund has been sent, please wait for approval");
						$("#image-gif2").html('<?php echo $this->Html->image('/img/wait.gif')?>');
						$("#is_refund_approved").val(1);
					}else
					if(parseInt(data) == 1)		//approved
					{
						$("#status-approved-message-for-refund").html('<font color="green">Request for Refund has been completed</font>');
						$("#image-gif2").hide();
						$("#is_refund_approved").val(2); //allow to submit the form by swapnil
						$("#hrefund").val(1);
						$("#discount_authorize_by_for_refund").hide();						
					}
					else
					if(parseInt(data) == 2)		// if rejected by users
					{
						$("#status-approved-message-for-refund").html('<font color="red">Request for Refund has been rejected</font>');
						$("#image-gif2").hide();
						$("#is_refund_approved").val(3);	// for approval reject
						clearInterval(refund_interval); 	// stop the interval
						$("#hrefund").val(0);
						resetRefund();//do not remove, for clearing request
						display();
					}
				} //end of success
			});
		}


	 //save blood data
	 
	 $("#saveBloodData").click(function(){
        groupID=$('#serviceGroupId').val();
    	var validatePerson = jQuery("#bloodServiceFrm").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
 
	 	$('.onlyBloodId').each(function(){ 
			if($(this).val() == ''){
				alert('This service is not exist, Please enter another service.');
				isOk=false;
				var lastId = $( ".blood_service" ).last().attr( "id" );
				idCounter=lastId.split('_');
				$('#bloodServiceId_'+idCounter[1]).val('');
				$('#onlyBloodId_'+idCounter[1]).val('');
				return false;
			}else{
				isOk=true;
				return true;
			}
		});

	 	if(isOk){
  		var patient_id='<?php echo $patientID;?>';
  		var primaryCareProvider=$('#allDoctorList').val();
  		formData = $('#bloodServiceFrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'?doctor_id='+primaryCareProvider,
  				  context: document.body,
  				  async: false,
  				  success: function(data){ 
  					$("#bloodServiceFrm").trigger('reset');
  					$(".bloodAddMoreRows").remove();
  					$(".bloodTotalAmount").html('');
  					 
  					getBloodData(patient_id,groupID);	
  					getbillreceipt(patient_id);
  					$("#busy-indicator").hide();
  					$("#saveBloodData").show();
  				  },
  				  beforeSend:function(){
  	  				  $("#busy-indicator").show();
  	  				  $("#saveBloodData").hide();
  	  				  },		  
  			});
	 	} 
        });
	 
	 //EOF blood data
	 
	//for blocking area  --yashwant
	
	
	
	function loading(){
	    $('#serviceOptionDiv').block({
	        message: '',
	       /* css: {
	            padding: '5px 0px 5px 18px',
	            border: 'none',
	            padding: '15px',
	            backgroundColor: '#000000',
	            '-webkit-border-radius': '10px',
	            '-moz-border-radius': '10px',
	            color: '#fff',
	            'text-align':'left'
	        },*/
	        //overlayCSS: { backgroundColor: '#cccccc' }
	    });
	}
	
	function onCompleteRequest(){
	    $('#serviceOptionDiv').unblock();
	}

	$( document ).ajaxStart(function() {
		loading();
	});
	
	$( document ).ajaxStop(function() {
		onCompleteRequest();       
	});

	
	//EOF blocking area
	
	
	//save implant data  --yashwant
	$("#saveImplantData").click(function(){
        groupID=$('#serviceGroupId').val();
    	var validatePerson = jQuery("#implantServiceFrm").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
 
	 	$('.onlyImplantId').each(function(){ 
			if($(this).val() == ''){
				alert('This service is not exist, Please enter another service.');
				isOk=false;
				var lastId = $( ".implant_service" ).last().attr( "id" );
				idCounter=lastId.split('_');
				$('#implantServiceId_'+idCounter[1]).val('');
				$('#onlyImplantId_'+idCounter[1]).val('');
				return false;
			}else{
				isOk=true;
				return true;
			}
		});

	 	if(isOk){
  		var patient_id='<?php echo $patientID;?>';
  		var primaryCareProvider=$('#allDoctorList').val();
  		formData = $('#implantServiceFrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'?doctor_id='+primaryCareProvider,
  				  context: document.body,
  				  success: function(data){ 
  					$("#implantServiceFrm").trigger('reset');
  					$(".implantAddMoreRows").remove();
  					$(".implantTotalAmount").html('');
  					 
  					getImplantData(patient_id,groupID);	
  					getbillreceipt(patient_id);
  					$("#busy-indicator").hide();
  					$("#saveImplantData").show();
  				  },
  				  beforeSend:function(){
  	  				$("#busy-indicator").show();
  	  				$("#saveImplantData").hide();
  	  			  },		  
  			});
	 	} 
        });
	//EOF impalant data
	
	 
	//save other service data  --yashwant
	$("#saveOtherServiceData").click(function(){
        groupID=$('#serviceGroupId').val();
    	var validatePerson = jQuery("#otherServiceFrm").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
 
	 	$('.otherServiceId').each(function(){ 
			if($(this).val() == ''){
				alert('This service is not exist, Please enter another service.');
				isOk=false;
				var lastId = $( ".other_service" ).last().attr( "id" );
				idCounter=lastId.split('_');
				$('#otherService_'+idCounter[1]).val('');
				$('#otherServiceId_'+idCounter[1]).val('');
				return false;
			}else{
				isOk=true;
				return true;
			}
		});

	 	if(isOk){
  		var patient_id='<?php echo $patientID;?>';
  		var primaryCareProvider=$('#allDoctorList').val();
  		formData = $('#otherServiceFrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'?doctor_id='+primaryCareProvider,
  				  context: document.body,
  				  success: function(data){ 
  					$("#otherServiceFrm").trigger('reset');
  					$(".otherServiceAddMoreRows").remove();
  					$(".otherServiceTotalAmount").html('');
  					 
  					getOtherServiceData(patient_id,groupID);	
  					getbillreceipt(patient_id);
  					$("#busy-indicator").hide();
  					$("#saveOtherServiceData").show();
  				  },
  				  beforeSend:function(){
  	  				$("#busy-indicator").show();
  	  				$("#saveOtherServiceData").hide();
  	  			  },		  
  			});
	 	} 
        });
	//EOF other service data
	
	 
	 //save ward procedure data  --yashwant
	$("#saveWardData").click(function(){
        groupID=$('#serviceGroupId').val();
    	var validatePerson = jQuery("#wardProcedureFrm").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
 
	 	$('.onlyWardId').each(function(){ 
			if($(this).val() == ''){
				alert('This service is not exist, Please enter another service.');
				isOk=false;
				var lastId = $( ".ward_service" ).last().attr( "id" );
				idCounter=lastId.split('_');
				$('#wardServiceId_'+idCounter[1]).val('');
				$('#onlyWardId_'+idCounter[1]).val('');
				return false;
			}else{
				isOk=true;
				return true;
			}
		});

	 	if(isOk){
  		var patient_id='<?php echo $patientID;?>';
  		var primaryCareProvider=$('#allDoctorList').val();
  		formData = $('#wardProcedureFrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'?doctor_id='+primaryCareProvider,
  				  context: document.body,
  				  success: function(data){ 
  					$("#wardProcedureFrm").trigger('reset');
  					$(".wardAddMoreRows").remove();
  					$(".wardTotalAmount").html('');
  					 
  					getWardData(patient_id,groupID);	
  					getbillreceipt(patient_id);
  					$("#busy-indicator").hide();
  					$("#saveWardData").show();
  				  },
  				  beforeSend:function(){
  	  				$("#busy-indicator").show();
  	  				$("#saveWardData").hide();
  	  			  },		  
  			});
	 	} 
        });
	//EOF impalant data
	
    
    //spot implant payment
    $("#spotImplantService").click(function(){ 
	 	  
		 patientID='<?php echo $patientID;?>';
		 appoinmentID='<?php echo $appoinmentID;?>';
		 $.fancybox({ 
			 	'width' : '50%',
				'height' : '100%',
				//'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'onClosed':function(){
				},
				'helpers'   : { 
			    	   'overlay' : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox 
			    },
				'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"spotImplantPayment",$patientID,"admin"=>false)); ?>",
		 });
		 $(document).scrollTop(0);
	 });
        

	//hide pay field of consultant  ---yashwant
	$(document).on('click','.notToPayDr', function(){
		 var currentID=$(this).attr('id');
		 var splitedVar=currentID.split('_');
		 var ID=splitedVar[1];
 
		 if(!$(this).is(":checked")){
			 $('#payToConsultant_'+ID).show();
		 }else{
			 $('#payToConsultant_'+ID).hide();
		 }
	 });

	//type only numeric values.. by Swapnil G.Sharma
	$(document).on("keyup keypress blur input",".num",function()
  	{ 
    	if (/[^0-9\.]/g.test(this.value))
        {
        	 this.value = this.value.replace(/[^0-9\.]/g,'');
        }
  	});

	$('#card_pay').click(function(){
		cardPay();
	});

	function cardPay(){
		var amtInCard="<?php echo $patientCardAmt['Account']['card_balance'];?>";
		 var chkpay= $('#amount').val();
		 
		 if($("#card_pay").is(":checked")){
		 	if(!$('#amount').val() || $('#amount').val()<='0'){
			      alert('Please Pay Some Amount');
			      $("#card_pay").attr("checked",false);
				  $("#patientCard").hide();	
				  $('#patientCardDetails').hide();
				  return false;
			 }else{			 	
		 		$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getCardBalance","admin" =>false)); ?>"+'/'+patientID,
				  context: document.body,	
				  beforeSend:function(){
	  	  				$("#payAmount").hide();//hide pay amount button till card process  --yashwant
	  	  				$("#card_pay").hide();//to avoid multiple clicks while processcing  --yashwant
	  	  				$("#busy-indicator").show();
	  	  			},			  		  
				  success: function(data){
					data= $.parseJSON(data);
					if(data.Account.id=='0' || isNaN(data.Account.id)){
				 		if(data.Account.card_balance=='0' || isNaN(data.Account.card_balance)){				
							 alert("Insufficient Funds in Patient Card");
							 $("#card_pay").attr("checked",false);
							 $("#patientCard").hide();
							 $('#patientCardDetails').hide();
							 $("#busy-indicator").hide();
							 $("#payAmount").show();//show pay amount button till card process  --yashwant
							 $("#card_pay").show();//to avoid multiple clicks while processcing  --yashwant
							 return false; //for unceking card payment in readiotheraphy  --yashwant
						 }
					 }else{
						 if(data.Account.card_balance=='0' || isNaN(data.Account.card_balance)){				
							 alert("Insufficient Funds in Patient Card");
							 $("#card_pay").attr("checked",false);
							 $("#patientCard").hide();
							 $('#patientCardDetails').hide();
							 $("#busy-indicator").hide();
							 $("#payAmount").show();//show pay amount button till card process  --yashwant
							 $("#card_pay").show();//to avoid multiple clicks while processcing  --yashwant
							 return false; //for unceking card payment in readiotheraphy  --yashwant
						 }
					 	$('#cardBal').text(data.Account.card_balance);
					 	$('#patient_card').val(data.Account.card_balance);
					 	amtInCard=data.Account.card_balance;
						var cardPay=amtInCard;
						var otherPay=0;
						if(parseInt(chkpay)<parseInt(cardPay)){
							otherPay=0;
						    $('#patient_card').val(chkpay);
						}else{					
						   otherPay=chkpay-cardPay;
						   $('#patient_card').val(cardPay);
						}		
						$('#otherPay').text(otherPay);				
						$("#patientCard").show();
						$('#patientCardDetails').show();
					 } 

					$("#payAmount").show();//show pay amount button till card process  --yashwant
					$("#card_pay").show();//to avoid multiple clicks while processcing  --yashwant
					$("#busy-indicator").hide();
			  	}
	 				
					  
		});
		}	 			 
		}else{
			$("#patientCard").hide();
			 $('#patientCardDetails').hide();
		}
	}

	 $('#patient_card').keyup(function(){
		 var amtInCard=$('#cardBal').text();
		 var changeAmt=$(this).val();
		 var otherPay=$('#otherPay').text();
		 if(parseInt(changeAmt) > parseInt(amtInCard)){
			 
			 alert("Insufficient Funds in Patient Card");
			 $("#card_pay").attr("checked",false);
			 $('#patient_card').val('');
			 $("#patientCard").hide();
			 $("#patientCardDetails").hide();
			 $("#busy-indicator").hide();
			 return false;
		 }else{
			 var chkVal=$('#amount').val();
			 if(parseInt(changeAmt)>parseInt(chkVal)){
				 alert("Amount Paid is greater");
				 $("#card_pay").attr("checked",false);
				 $('#patient_card').val('');
				 $("#patientCard").hide();
				 $("#patientCardDetails").hide();
				 return false;
			 }
			 var otherPay=chkVal-changeAmt;
			 if(parseInt(otherPay)<=0)
				 otherPay=0;	
			 $('#otherPay').text(otherPay); 
		 }
		 
	 });


	 //for advance payment  --yashwant
	 $(".advancePayment").click(function(){ 
		 totalCharge=$("#totalCharge").val();
		 totalPaid=$("#totalPaid").val();
		 patientID='<?php echo $patientID;?>';
		 appoinmentID='<?php echo $appoinmentID;?>';
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
				'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"advanceBillingPayment","admin"=>false)); ?>"+'/'+patientID,
		 });
		 $(document).scrollTop(0);
	 });

	 
	/*--function for showing prev discount, refund rows-- yashwant--*/
	function maintainPrevRefundDiscount(){
		var prevDiscount=$('#prevDiscount').text();
		var prevRefund=$('#prevRefund').text();
		 
		if(prevDiscount=='0' || prevDiscount==''){
			$('#prevDiscountArea').hide();
		}else{
			$('#prevDiscountArea').show();
		}

		if(prevRefund=='0' || prevRefund==''){
			$('#prevRefundArea').hide();
		}else{
			$('#prevRefundArea').show();
		}
	}

	/*-function for reseting payment detail -- yashwant-*/
	
	function resetPaymentDetail(){
		var patient_id='<?php echo $patientID;?>';
		var groupID=$('#payment_category').val();
  
		$("#paymentDetail").trigger('reset');
		  getbillreceipt(patient_id);
		  if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='pharmacy_radio'){
			  getPharmacyData(patient_id,'<?php echo $tariffStandardID ;?>');
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='otpharmacy_radio'){
			  getOtPharmacyData(patient_id,'<?php echo $tariffStandardId ?>');
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='laboratory_radio'){
			  getLabData(patient_id,'<?php echo $tariffStandardId ?>');
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='radiology_radio'){
			  getRadData(patient_id,'<?php echo $tariffStandardId ?>');
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='surgery_radio'){
			  getProcedureData(patient_id,'<?php echo $tariffStandardId ?>');
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='roomtariff_radio'){
			  getDailyRoomData(patient_id,'<?php echo $tariffStandardId ?>',groupID);
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='consultant_radio'){
			  getConsultationData(patient_id,'<?php echo $tariffStandardId ?>');
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='blood_radio'){
			  getBloodData(patient_id,groupID);
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='implant_radio'){
			  getImplantData(patient_id,groupID);
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='otherservices_radio'){
			  getOtherServiceData(patient_id,groupID);
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='radiotheraphy_radio'){
			  getRadiotheraphyData(patient_id,groupID);
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='ward_radio'){
			  getWardData(patient_id,groupID);
		  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='privatepackage_radio'){
			  getPackageData(packagedPatientId);
		  }else{ 
			  if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')== 'mandatoryservices_radio'){
				   //$('#amount').attr('readonly',true);
				   $("#servicesSection").show();
				   getServiceData('<?php echo $patientID;?>',groupID,'mandatoryservices');
			   }else{
				   $("#servicesSection").show();
				  // $('#amount').attr('readonly',true);
				   getServiceData('<?php echo $patientID;?>',groupID);
			   }
			  //getServiceData(patient_id,groupID);
		  } 

		  $('#payAmount').show();
		   var websiteInstance='<?php echo $configInstance;?>';
		   var tariffStanderdID='<?php echo $patient['Patient']['tariff_standard_id'];?>';
		   var privatePatientID='<?php echo $privatepatientID;?>';
		   if(websiteInstance=='vadodara' && tariffStanderdID!=privatePatientID){
		   		$("#creditDaysInfo").show();
		   }else{
			   $("#creditDaysInfo").hide();
		   }
		  $("#neft-area").hide();
		  $("#paymentInfo").hide();
		  $("#busy-indicator").hide();	
		  $('#bankDeposite').hide();
		  	
		  $("#receivedRemark").prop("disabled",false);
		  $("#refundRemark").prop("disabled",true);

		  // Patient card  detail
		   	 $("#card_pay").attr("checked",false);
			 $('#patient_card').val('');
			 $("#patientCard").hide();
			 $("#patientCardDetails").hide();
	}

	//inlineMsg(currentID,'The master for tariff of the TPA/Corporate is not updated. You will not be able to complete the process.');
	$('.link').click(function(){
			$('.link').each(function(){
					$(this).removeClass('preLink');
			});
			$(this).addClass('preLink');
	});

	//for advance payment  --yashwant
	 $("#fancyCard").click(function(){ 
		 patientID='<?php echo $patientID;?>';
		 if($('#card_pay').is(':checked')){
			 $('#card_pay').trigger('click');
		 }
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
			    'afterClose':function(){
				    getbillreceipt(patientID);
				},
				'href' : "<?php echo $this->Html->url(array("controller" =>"Accounting","action" =>"patient_card","admin"=>false)); ?>"+'/'+patientID,
		 });
		 $(document).scrollTop(0);
	 });

	 $("#submittedBilledAmount").click(function(){
		    patient_id='<?php echo $patientID;?>';
		    submited_amount = $('#submited_amount').val();
		 	if(submited_amount=='' || submited_amount=='0'){
			 	alert('Please enter billed amount.');
			 	return false;
			}

		 	$.ajax({
  				type : "POST",
  				data: "submited_amount="+submited_amount,
  				url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "updateBilledAmount",$patientID,"admin" => false)); ?>",
  				context: document.body,
  				success: function(data){ 
  					$('#submited_amount').val('');
  					inlineMsg('submited_amount','Amount saved successfully',3);
  					$("#busy-indicator").hide();
  				},
  				beforeSend:function(){
  	  				$("#busy-indicator").show();
  	  			},		  
	  		});
	 });

 	/* $("#uploadExcel").click(function(){
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
				'href' : "<?php //echo $this->Html->url(array("controller" =>"Billings","action" =>"uploadCorporateExcel",$patientID,"admin"=>false)); ?>",
		 });
		 $(document).scrollTop(0);
	 });*/

	 $('#uploadExcel').fancybox({ 
		'type':'ajax',
		'href':'<?php echo $this->Html->url(array('controller'=>"Billings",'action'=>"uploadCorporateExcel",$patient_id,'admin'=>false)) ?>',
	     helpers     : { 
	    	locked     : true, 
	        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
	     }
	}); 

	 $('.labServiceAmount').on('change',function(){//maintain total of lab amount --yashwant
		 var totalLabCharge=0;
		 $(".labServiceAmount").each(function () {
			 var currentAmount=($(this).val()=='')?'0':$(this).val();
			 totalLabCharge=parseInt(totalLabCharge)+parseInt(currentAmount);
		 });
 		 $('#totalLabAmount').html('Total :'+totalLabCharge);
	 });

	 $('.radServiceAmount').on('change',function(){ //maintain total of rad amount --yashwant
		 var totalRadCharge=0;
		 $(".radServiceAmount").each(function () {
			 var currentAmount=($(this).val()=='')?'0':$(this).val();
			 totalRadCharge=parseInt(totalRadCharge)+parseInt(currentAmount);
		 });
 		 $('#totalRadAmount').html('Total :'+totalRadCharge);
	 });

	 $('.clinicalServiceAmount').on('change',function(){ //maintain total of clinical service amount --yashwant
		 var totalCServiceCharge=0;
		 $(".clinicalServiceAmount").each(function () {
			 var currentID=$(this).attr('id');
			 var splitedVar=currentID.split('_');
			 ID=splitedVar[2];
			 var currentAmount=($(this).val()=='')?'0':$(this).val();
			 var currentQty=($("#no_of_times_"+ID).val()=='')?'0':$("#no_of_times_"+ID).val();
			 totalCServiceCharge=parseInt(totalCServiceCharge)+parseInt(currentAmount)*parseInt(currentQty);
		 });
 		 $('#totalCServiceAmount').html('Total :'+totalCServiceCharge);
	 });
 

	 $(document).on('change','.otherServiceAmount',function(){ //maintain total of other service amount --yashwant
		 var totalOtherServiceCharge=0;
		 $(".otherServiceAmount").each(function () {
			 var currentID=$(this).attr('id');
			 var splitedVar=currentID.split('_');
			 ID=splitedVar[1];
			 var currentAmount=($(this).val()=='')?'0':$(this).val();
			 var currentQty=($("#otherServiceQty_"+ID).val()=='')?'0':$("#otherServiceQty_"+ID).val();
			 totalOtherServiceCharge=parseInt(totalOtherServiceCharge)+parseInt(currentAmount)*parseInt(currentQty);
		 });
 		 $('#totalOtherServiceAmount').html('Total :'+totalOtherServiceCharge);
	 });

	 $(document).on('change','.radiotheraphyAmount',function(){ //maintain total of other service amount --yashwant
		 var totalRadiotheraphyCharge=0;
		 $(".radiotheraphyAmount").each(function () {
			 var currentID=$(this).attr('id');
			 var splitedVar=currentID.split('_');
			 ID=splitedVar[1];
			 var currentAmount=($(this).val()=='')?'0':$(this).val();
			 var currentQty=($("#radiotheraphyQty_"+ID).val()=='')?'0':$("#radiotheraphyQty_"+ID).val();
			 totalRadiotheraphyCharge=parseInt(totalRadiotheraphyCharge)+parseInt(currentAmount)*parseInt(currentQty);
		 });
 		 $('#totalRadiotheraphyAmount').html('Total :'+totalRadiotheraphyCharge);
	 });

	 function getCardBalance(){//for getting card balance  --yashwant
		 $.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "cardBalanceAmount",$personID, "admin" => false)); ?>",
			  context: document.body,				  		  
			  success: function(data){
				  $('#cardHead').html(data);
			  }
		});
	 }

	//BOF getRadiotheraphyData section
	 function getRadiotheraphyData(patient_id,groupID){
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxRadiotheraphyData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID ;
         $.ajax({
         	beforeSend : function() {
              	//loading("outerDiv","class");
         		$("#busy-indicator").show();
           	},
         type: 'POST',
         url: ajaxUrl,
         dataType: 'html',
         success: function(data){
         	//onCompleteRequest("outerDiv","class");
         	$("#busy-indicator").hide();
         	onCompleteRequest();
         	if(data!=''){
         		$('#newLayout').show();
        		$('#finalPayHtml').hide();
        		$('#globalDivId').html(data);
        		//discountApproval();
        		//RefundApproval();
         	}
         },
 		});
	 }
	//EOF getRadiotheraphyData section
	
	//save radiotheraphy data  --yashwant
	$("#saveRadiotheraphyData").click(function(){
        groupID=$('#serviceGroupId').val();
    	var validatePerson = jQuery("#radiotheraphyFrm").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
 
	 	$('.radiotheraphyId').each(function(){ 
			if($(this).val() == ''){
				alert('This service is not exist, Please enter another service.');
				isOk=false;
				var lastId = $( ".radiotheraphy_service" ).last().attr( "id" );
				idCounter=lastId.split('_');
				$('#radiotheraphy_'+idCounter[1]).val('');
				$('#radiotheraphyId_'+idCounter[1]).val('');
				return false;
			}else{
				isOk=true;
				return true;
			}
		});

	 	if(isOk){
  		var patient_id='<?php echo $patientID;?>';
  		var primaryCareProvider=$('#allDoctorList').val();
  		formData = $('#radiotheraphyFrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'?doctor_id='+primaryCareProvider,
  				  context: document.body,
  				  success: function(data){ 
  					$("#radiotheraphyFrm").trigger('reset');
  					$(".radiotheraphyAddMoreRows").remove();
  					$(".radiotheraphyTotalAmount").html('');
  					 
  					getRadiotheraphyData(patient_id,groupID);	
  					getbillreceipt(patient_id);
  					$("#busy-indicator").hide();
  					$("#saveRadiotheraphyData").show();
  				  },
  				  beforeSend:function(){
  	  				$("#busy-indicator").show();
  	  				$("#saveRadiotheraphyData").hide();
  	  			  },		  
  			});
	 	} 
        });

    $("#isPackage").click(function () {    
    	  
    		if($(this).is(':checked')==true){
    			var conResult = confirm("Are you sure to make this Patient as Packaged Patient?");   
    			if(conResult==true){
	      			$('#package').val('1');
	      			isPackage=$('#package').val();
    			}else{
        			return false;
        		}
        	}else if($(this).is(':checked')==false) {
        		var conResult = confirm("Are you sure to make this Patient as Non-Packaged Patient?");  
        		if(conResult==true){ 
	        		 $('#package').val('0');
	        		 isPackage=$('#package').val();
        		}else{
        			return false;
        		}
           	}           
			var patientId = $(this).attr('patientId') ; 
     		$.ajax({
					url : "<?php echo $this->Html->url(array("controller" => 'Billings', "action" => "isPackagePatient", "admin" => false));?>"+"/"+patientId+"/"+isPackage,

					beforeSend:function(data){
					$('#busy-indicator').show();
				},
					success: function(data){
					$('#busy-indicator').hide();
					 getbillreceipt(patientId);
				}
			});
        
    });
	//EOF radiotheraphy data
	
	// if patients encounter is currently running,then you can not revoke discharge of previous encounter-atul
	
	$("#revoke").click(function(){ 
		var count ="<?php echo count($encounterId);?>";
		if(count>1){
		var isCheck="<?php echo $encounterId['Patient']['is_discharge'];?>";
		if(isCheck=='' || isCheck=='0'){
			alert("This patient has another encounter running you can not revoke , please contact admisnistrator");
			return false;
			}
		}
	});

	 $('#showPharm').click(function (){
		 /*$.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "pharmacyShow", "admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					  $('#busy-indicator').show('slow');
					  }, 	  		  
				  success: function(data){
					  $('#busy-indicator').hide('slow');
					  window.location.reload(true);
					  }
				  
			});*/

		/*<?php if($this->params->query['showPhar']){ ?>
			window.location.href="<?php echo $this->Html->url(
								array("controller" => 'Billings',"action" => "multiplePaymentModeIpd",$patient['Patient']['id'],'?'=>array('showPhar'=>'1'), "admin" => false)); ?>";
		<?php }else{?>
			window.location.href="<?php echo $this->Html->url(
								array("controller" => 'Billings',"action" => "multiplePaymentModeIpd",$patient['Patient']['id'], "admin" => false)); ?>";
		<?php }?>*/

	});
	
	    $(function() {
		  // Handler for .ready() called.		  
		 /* $('#expected-amount').blur(function(){
			  $.ajax({
					url : "<?php echo $this->Html->url(array("controller" => 'Corporates',
							"action" => "setExpectedAmount", "admin" => false));?>",
					data:'patient_id='+<?php echo  $patient['Patient']['id']?>+'&expected_amount='+$(this).val(),
					method:'post',
					beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success: function(data){
						$('#busy-indicator').hide(); 
						//window.location.reload(); 
					}
			});
		}); 
*/
		//fucntion to check invoice to submit 
		$("#ready-for-submission").click(function(){ 
			 if($('#expected-amount').val() == ''){ alert('Please enter expected amount.'); $('#expected-amount').focus();return false ;} 
			 /*if(this.id == 'revoke-for-submission' ){
				 var finalize = 0;
			 }else{*/
				 var finalize = 1;
			 //}

			var uploadDate=$('#bill_uploading_date').val();
		  	var expectedAmnt=$('#expected-amount').val();
		  	var billAmount=$('#bill-amount').val();
		  	var bill_prepared_by = $('#billing-executive').val();
		  	var reasonForDelay = $('#reasonForDelay').val();

			 $.ajax({
				url : "<?php echo $this->Html->url(array("controller" => 'Corporates',"action" => "setExpectedAmount", "admin" => false));?>",
				data:'finalize='+finalize+'&bill_uploading_date='+uploadDate +'&expected_amount='+expectedAmnt +'&bill_amount='+billAmount +'&bill_prepared_by='+bill_prepared_by+'&reason_for_delay='+reasonForDelay +'&patient_id='+<?php echo  $patient['Patient']['id'] ; ?>,
				method:'post',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					window.location.reload(); 
					$('#busy-indicator').hide(); 
					/*$('#corpExcel').show();
					$('.bill_submit').show();
					$('#bill_submitted_on').show();*/
				}
			}); 
		});


		//fucntion to save noc detail
		$("#save-noc-detail").click(function(){ 
			 
			
		  	var fiveDayReminder=$('#fiveDayReminder').val();
		  	var twelveDayReminder=$('#twelveDayReminder').val();
		  	var fiveDayNocTaken=$('#fiveDayNocTaken').val();
		  	var tweleveDayNocTaken=$('#tweleveDayNocTaken').val();
		  	//if(nocTaken == ''){ alert('Please Select NOC Taken Or Not.'); $('#nocTaken').focus();return false ;} 

			 $.ajax({
				url : "<?php echo $this->Html->url(array("controller" => 'Corporates',"action" => "saveNocDetail", "admin" => false));?>",
				data:'five_day_reminder='+fiveDayReminder+'&twelve_day_reminder='+twelveDayReminder+'&patient_id='+<?php echo  $patient['Patient']['id']?>+'&five_day_noc_taken='+fiveDayNocTaken+'&twelve_day_noc_taken='+tweleveDayNocTaken,
				method:'post',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					window.location.reload(); 
					$('#busy-indicator').hide(); 
				}
			}); 
		});

		//fucntion to save noc detail
		$("#save-nmi-detail").click(function(){ 
			 
			
		  	var nmi=$('#nmi').val();
		  	var nmiDate=$('#nmiDate').val();
		  	var nmiAns=$('#nmiAns').val();

		  	if(nmiAns == ''){ alert('Please Select NMI Answered Or Not.'); $('#nmiAns').focus();return false ;} 

			 $.ajax({
				url : "<?php echo $this->Html->url(array("controller" => 'Corporates',"action" => "saveNmiDetail", "admin" => false));?>",
				data:'nmi='+nmi+'&nmi_date='+nmiDate+'&nmi_answered='+nmiAns+'&patient_id='+<?php echo  $patient['Patient']['id']?> ,
				method:'post',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					window.location.reload(); 
					$('#busy-indicator').hide(); 
				}
			}); 
		});




		
	 }); 
         
    $("#duplicateSalesAllow").click(function(){ 
        var allow = '';
        if($(this).is(':checked') == true){
            allow = '1';
        }else{ 
            allow = '0';
        } 
        $.ajax({
            url : "<?php echo $this->Html->url(array("controller" => 'Patients',"action" => "updateUseDuplicateCharges",$patientID, "admin" => false));?>"+'/'+allow,
            beforeSend:function(data){
                $('#busy-indicator').show();
            },
            success: function(data){
                window.location.reload(); 
            }
        });
    });

    $("#saveGalleryDetails").click(function(){ 
    	var validatePerson = jQuery("#addGalleryDetails").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
  		var patient_id='<?php echo $patientID;	?>';
  		formData = $('#addGalleryDetails').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "galleryPackageDetails", "admin" => false)); ?>"+'/'+patient_id,
  				  context: document.body,
  				  success: function(data){ 
  					$("#busy-indicator").hide();
  					resetFormm();
  					document.getElementById("addGalleryDetails").reset();
  				  },
  				  beforeSend:function(){
	  				  $("#busy-indicator").show();
	  				  },		  
  			});
        });

    function resetFormm(){
    	var formData = document.getElementById("addGalleryDetails");
    	$(formData).find('input').each(function() {
        	$(this).val('');
        	$("#saveGalleryDetails").val('Save');
        }); 
    }
    
    $("#packageCategory").autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getListOfPackage","admin" => false,"plugin"=>false)); ?>",
		 setPlaceHolder : false,
		 select: function( event, ui ) {
			 $("#packageCategoryId").val(ui.item.id);
			 catID = ui.item.id;
			 if(catID == '7' || catID == '8' || catID == '9' || catID == '10' || catID == '11' || catID == '12'){
				 $(".showCat").show();
			  }else{
				  $(".showCat").hide();
			  }
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
    $(document).on('focus',"#packageSubCategory",function(){
    	 var packageCatId = $("#packageCategoryId").val();
         if(packageCatId == ''){
			alert("Please Select Package Category");
			$("#packageSubCategory").val('');
          }
         
	    $(this).autocomplete({
	    	
				 source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getListOfSubPackage","admin" => false,"plugin"=>false)); ?>"+"/"+$("#packageCategoryId").val(),
				 setPlaceHolder : false,
				 select: function( event, ui ) {
					 $("#packageSubCategoryId").val(ui.item.id);
				 },
				 messages: {
				        noResults: '',
				        results: function() {}
				 }
	          
		});
   });

    $(document).on('focus',"#packageSubSubCategory",function(){
   	 var packageCatId = $("#packageCategoryId").val();
   	 var packageSubCatId = $("#packageSubCategoryId").val();
       if(packageCatId == ''){
			alert("Please Select Package Category");
			$("#packageSubSubCategory").val('');
         }
        if(packageSubCatId == ''){
			alert("Please Select Sub Package Category");
			$("#packageSubSubCategory").val('');
         }
	    $(this).autocomplete({
				 source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getListOfSubSubPackage","admin" => false,"plugin"=>false)); ?>"+"/"+packageCatId+"/"+packageSubCatId,
				 setPlaceHolder : false,
				 select: function( event, ui ) {
					 $("#packageSubSubCategoryId").val(ui.item.id);
				 },
				 messages: {
				        noResults: '',
				        results: function() {}
				 }
	          
		});
  });

  $('#bill_button').click(function(e){
  		e.preventDefault();
  		var billDate=$('#bill_submitted_on').val();
  		var billSubmittedBy=$('#bill_submitted_by').val();
  		var patientId="<?php echo  $patient['Patient']['id']?> ";
  		$.ajax({
  			type : "POST",
  			data :"bill_submit_date="+billDate+"&bill_submitted_by="+billSubmittedBy+"&patient_id="+patientId,
  			url : "<?php echo $this->Html->url(array("controller" => 'Corporates',"action" => "setBillSubmit", "admin" => false));?>",
			context: document.body,
			beforeSend:function(){
			  $("#busy-indicator").show();
			},
		    success: function(data){ 
				$("#busy-indicator").hide();
				/*$('.bill_submit').hide();
				$('#revoke-for-submission').hide();*/
				window.location.reload();
		  	},
		  	

  		});
  });

  // save 
	 $(document).on('submit','#billLinkForm',function(e){

		e.preventDefault(); //to prevent default form submit
	
  		var patientId="<?php echo  $patient['Person']['id']?> ";
  		//formData = $('#billLinkForm').serialize();
  		var formData = new FormData(this);
  		

  		console.log(formData);
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Corporates", "action" => "addBillLink", "admin" => false)); ?>"+'/'+patientId,
  				  context: document.body,
  				  cache: false,
		       	  contentType: false,
			      processData: false,
  				  success: function(data){ 
  					$("#busy-indicator").hide();
  					window.location.reload();
  				  },
  				  beforeSend:function(){
  	  				  $("#busy-indicator").show();
  	  				
				  },		  
  			});
	 	
    });

  
</script>