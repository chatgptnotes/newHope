<?php  
	echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg'));  
	echo $this->Html->script(array('permission','jquery.ui.timepicker','jquery.blockUI'));
	echo $this->Html->css(array('jquery.fancybox-1.3.4')) ;
	$splitDate = explode(' ',$patient['Patient']['form_received_on']);?>
<style>
.gradient_img {
    background: rgba(0, 0, 0, 0) url("../img/grey_black.png") repeat-x scroll 0 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
    width: 199px;
    z-index: -1;
}
.bloc {
    display: inline-block;
    overflow: hidden;
    vertical-align: top;
    width: 195px;
}
label {
    color: #000 !important;
    float: none !important;
    font-size: 13px;
    margin-right: 10px;
    padding-top: 7px;
    text-align: right;
    width: none !important;
    cursor: pointer;
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

.cursor{
	cursor: pointer;
}
.hasDatepicker {
    width: 130px;
}
</style>
<script>
var errorMsg='Charges for this service are not updated in master.';
var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
var explode = admissionDate.split('-');
/** Global variable to check patient is packaged -- Gaurav */
var isPackagedPatient = '<?php echo (isset($packageInstallment)) ?  true : false; ?>';
var packagedPatientId = '<?php echo $packagedPatientId;?>';
var radioName = (isPackagedPatient) ? 'privatepackage' : 'clinicalservices'; //gaurav

$(document).ready(function(){ 

	//to preveny redirect on edit and delte buttons of all services 
	$(document).on('click',".billingServicesAction",function(event){ 
		    event.preventDefault();
	});
	
		   patient_ID='<?php echo $patientID; ?>';
		   //getServiceData(patient_ID);
		  // getbillreceipt(patient_ID); //no need of billing heads on nurse service page  --yashwant
		   addCalenderOnDynamicField(); //default calender field
			
		   $("input[type='radio'][radioname=clinicalservices_radio]").attr('checked',true);
		   selRadio = $("input[type='radio'][radioname=clinicalservices_radio]").val()  ;//[isMandatory='yes']
  
		   $('#payment_category').val(selRadio);
		   $('#serviceGroupId').val(selRadio);
		   if(selRadio){
			   if(isPackagedPatient){
				   $('#privatePackageTable').show();
				   getPackageData(packagedPatientId);
				}else{
			   		$("#servicesSection").show(); // if patient is not packaged then show 'servicesSection'
			  		//$('#service_id_1').focus();
			   		getServiceData('<?php echo $patientID;?>',selRadio,'','default');
			   }
		   }
		   
		   var selectedGroup = '1';
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
			 	selectedGroup=$('#payment_category').val();
			 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
			 	var tariffStandardID = '<?php echo $tariffStandardID ?>';
				$("#service_id_"+ID).autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID,
					 minLength: 1,
					 select: function( event, ui ) {	
					 console.log(ui.item);
						$('#onlyServiceId_'+ID).val(ui.item.id);
						var id = ui.item.id; 
						var charges=ui.item.charges;
						if(charges == '0'){
							charges ='';
						}
						if(charges !== undefined && charges !== null && charges !== ''){
							charges = charges.replace(/,/g, '');
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
						/*if(charges !== undefined && charges !== null){
							$('#service_amount_'+ID).val(charges.trim());
							$('#amount_'+ID).html(charges.trim());
						}*/
						//serviceSubGroups(this);
					 },
					 messages: {
					        noResults: '',
					        results: function() {}
					 }
				});
			});
 
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
		maxDate : new Date(),
		
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
    
	$('.wardQty').on('keyup',function(){
    	currentID = $(this).attr('id') ; 
    	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
    	
		serviceAmt=$('#wardAmount_'+ID).val(); 
    	valtimes = $(this).val(); 
    	if(isNaN(valtimes)==false){ 
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
    	if(isNaN(valtimes)==false){ 
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

	$('.bloodQty').on('keyup',function(){
    	currentID = $(this).attr('id') ; 
    	splitedVar = currentID.split('_');
    	ID=splitedVar[1]; 
    	
		serviceAmt=$('#bloodAmount_'+ID).val(); 
    	valtimes = $(this).val(); 
    	if(isNaN(valtimes)==false){ 
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
  	
	$('.nofTime').on('keyup',function(){
    	currentID = $(this).attr('id') ; 
    	splitedVar = currentID.split('_');
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

	//making amount fields readonly in all groups
	var websiteInstance='<?php echo $configInstance;?>'; 
	if(websiteInstance=='kanpur'){
		$('.kanpurAmount').attr('readonly',true);
	}
}
 
</script>

<div class="inner_title" style="margin-top: 20px;">
	<table width="100%">
	 <tr>
		 <td><h3>&nbsp; <?php echo __('Nurse Prescription', true); ?></h3></td>
		 
		 
		 <td align="right"><?php echo $this->element('card_balance');?></td>
		 
		 <td align="right" style="padding-bottom: 10px;">
		 <span style="float: right;">
				<h3 style="font-size:13px; float: left; padding:5px;">
				<?php echo "Search Patient : "; ?>
				</h3>
				<h3 style="font-size:13px; float: left;">
				<?php echo $this->Form->input('admision_id',array('type'=>'text','id'=>'addmissionId','label'=>false,'div'=>false,'style'=>'float:left','class'=>'textBoxExpnd'));?>
				</h3>
				<h3 style="font-size:13px; float: right;">
					<?php echo $this->Html->link('Prescription','javascript:void(0);',array('class'=>'prescription blueBtn','id'=>'prescription','escape' => false,'label'=>false,'div'=>false));?>
				</h3>  
		</span>
		 </td>
	 </tr>
	</table>
</div>

<div>&nbsp;</div>
<div width="50% !important">
<?php echo $this->element('print_patient_info');?>
</div>
<?php 
echo $this->Form->hidden('totalCharge',array('id'=>'totalCharge'));
echo $this->Form->hidden('totalPaid',array('id'=>'totalPaid'));
?>
 
<?php if($configInstance=='vadodara'){?>
<div style="width: 20%">
<?php echo $this->Form->input('allDoctorList',array('type'=>'select','options'=>$allDoctorList,'empty'=>'Please Select Doctor',
	'id'=>'allDoctorList','label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd allDoctorList','value'=>$patient['Patient']['doctor_id']));?>
</div>
<?php }?>

<div>&nbsp;</div>

<!-- date section start here -->
<table width="100%" align="right" cellpadding="0" cellspacing="0" border="0" id="serviceOptionDiv">
	<tr>
		<td > 
		<?php  foreach($service_group as $key =>$value){
			
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
					echo $this->Form->input('', array('isMandatory'=>$isMandatory,'checked'=>$checked,'autocomplete'=>'off','radioName'=>$radioName."_radio",
							'name'=>'serviceGroupData','options' => $serviceGroupData,'legend' =>false,'label' => true,
							'div'=>false,'class'=>'cursor serviceGroupData add-service-group-id','type' => 'radio','separator'=>' '));
				}  ?>
        </td>
        
		<td>&nbsp;</td>
		<td class="tdLabel"><!-- Date --></td>
		<td width="140"><?php //echo date('d/m/Y')?></td>
		<td width="25" align="right"></td>
	</tr>
</table>
<div>&nbsp;</div>
<?php echo $this->Form->create('NurseBillingActivity',array('id'=>'defaultFrm'));?>
<table width="30%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="">

	<tr>
		<th class="table_cell" style="width: 25%"><?php echo __('Frequently Used Services');?></th>
		<th class="table_cell" style="width: 5%"><?php echo __('Action');?></th>
	</tr>
	<tr>
	 <td style="border: 1; padding: 2px;" valign="top">
		<table border="0">
			<tr>
			   <td>
				<div class="  black_white "
					style="padding: 5px 10px 10px; font-size: 11px;">
					<div class="bloc" id="content_1111">
						<?php echo $this->Form->input('Billing.serviceId', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd language','options'=>$serviceArray,'style'=>'margin:1px 0 0 10px;','multiple'=>'true','label'=> false,'id' => 'language','autocomplete'=>'off')); ?>
						<?php //echo $this->Form->input('Billing.serviceId', array('options' => $serviceArray,'value'=>'','multiple' => true,'class'=>'validate[required,custom[mandatory-select]]', 'id' => 'services','label'=> false, 'style'=>'width:380px,margin:1px 0 0 10px','div' => false, 'error' => false));?>
					</div>
				</div>
				</td>
			</tr>
	</table>
    </td>
		<td><input type="button" value="Submit" class="blueBtn" id="Submit" /></td>
	</tr>

</table>
<?php echo $this->Form->end();?>
<div>&nbsp;</div>
  	
				
<!--  pathology section start-->
<?php if($isDischarge!=1){?>
<div class="dynamicServiceSection" id="pathologySection" style="display: none; width: 100%">				

<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'addLab','type' => 'file','id'=>'labServices','inputDefaults' => array(
																							        'label' => false,
																							        'div' => false,
																							        'error' => false,
																							        'legend'=>false,
																							        'fieldset'=>false
)
)); ?>				
<table class="tabularForm" style="clear:both ; width:100% " cellspacing="1" id="labOrderArea">
	<tbody>
		<tr class="row_title">
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
			<td width="15%">
				<?php $todayLabDate=date("d/m/Y H:i:s");
				echo $this->Form->input('', array('type'=>'text','id' => 'labDate_1','label'=>false,'div'=>false,
				'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  labDate','style'=>'width:130px;',
				'readonly'=>'readonly','name'=>'LaboratoryTestOrder[start_date][]','value'=>$todayLabDate)); ?>
			</td>
				
			<td ><?php echo $this->Form->input('',array('name'=>'LaboratoryTestOrder[lab_name][]','class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd test_name',
					'escape'=>false,'multiple'=>false,'type'=>'text','label'=>false,'div'=>false,'id'=>'test_name_1','autocomplete'=>false,
					'placeHolder'=>'Lab Search'));
				echo $this->Form->hidden('', array('name'=>'LaboratoryTestOrder[laboratory_id][]','type'=>'text','label'=>false,
					'id' => 'labid_1','class'=> 'textBoxExpnd labid','div'=>false));
			?></td>
		
			<td>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>$serviceProviders,'empty'=>__('None'),
					'id'=>'service_provider_id_1','label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd externalRequisition',
					'name'=>"data[LaboratoryTestOrder][service_provider_id][]"))?>
			
			<td><?php echo $this->Form->input('', array('readonly'=>'readonly','style'=>'text-align:right',
					'name'=>'LaboratoryTestOrder[amount][]','type'=>'text','label'=>false,'id' => 'labAomunt_1',
					'class'=> 'textBoxExpnd specimentype kanpurAmount','div'=>false));
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
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		 <td width="50%" height="35px"><input name="" type="button" value="Add More Labs" class="blueBtn addMoreLab" /> </td>
		 <td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveLabBill"> </td>
	</tr>
</table>
<?php echo $this->Form->end();?>
</div>
<?php }?>
<!--  pathology section end-->

 

<!--  radiology section start-->
<?php if($isDischarge!=1){?>
<div class="dynamicServiceSection" id="radiologySection" style="display: none; width: 100%">
<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'addRad','type' => 'file','id'=>'radServices','inputDefaults' => array(
																							        'label' => false,
																							        'div' => false,
																							        'error' => false,
																							        'legend'=>false,
																							        'fieldset'=>false
)
));
$website=$this->Session->read('website.instance');
if($website=='kanpur'){?>
<div  style="padding-bottom: 10px"><a class="" href="<?php echo $this->Html->url(array('controller'=>'Radiologies','action'=>'radiology_test_list',$patientID,'?'=>'nurseFlag=nurse')); ?>">Radiology Dashboard</a></div>
<?php }?>
<table class="tabularForm" style="clear:both ; width:100% " cellspacing="1" id="RadiologyArea">
	<tbody>
		<tr class="row_title">
			<th class="table_cell"><strong><?php echo __('Date'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Radiology Test Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Description'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<tr>
			<td width="15%">
				<?php $todayRadDate=date("d/m/Y H:i:s");
				echo $this->Form->input('', array('type'=>'text','id' => 'radDate','label'=>false,'div'=>false,
				'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  radDate','style'=>'width:120px;',
				'readonly'=>'readonly','name'=>'data[RadiologyTestOrder][radiology_order_date][]','value'=>$todayRadDate)); ?>
			</td>
			
			<td ><?php echo $this->Form->input('', array('id' => 'radiologyname_1','type'=>'text', 'label'=> false, 'div' => false,
					 'error' => false,'autocomplete'=>false,'class'=>'validate[required,custom[mandatory-enter]] radiology_name textBoxExpnd','name'=>'data[RadiologyTestOrder][rad_name][]'));
			echo $this->Form->hidden('', array('type'=>'text','name'=>'data[RadiologyTestOrder][radiology_id][]','id'=>'radiologytest_1','class'=>'radiology_test'));
			?></td>
		
			<td><?php echo $this->Form->input('',array('type'=>'select','options'=>$radServiceProviders,'empty'=>__('None'),'id'=>'service_provider_id1',
				'label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd','name'=>"data[RadiologyTestOrder][service_provider_id][]"))?>
			
			<td><?php echo $this->Form->input('', array('readonly'=>'readonly','style'=>'text-align:right','name'=>'data[RadiologyTestOrder][amount][]','type'=>'text','label'=>false,'id' => 'radAomunt_1','class'=> 'textBoxExpnd radAomunt kanpurAmount','div'=>false));

				echo $this->Form->input('', array('name'=>'data[RadiologyTestOrder][fix_discount][]','type'=>'hidden',
					'label'=>false,'id' => 'rfix_discount_1','class'=> 'fix_discount','div'=>false));

			?></td>
			
			<td><?php echo $this->Form->input('', array('name'=>'data[RadiologyTestOrder][description][]','type'=>'text','label'=>false,'id' => 'description_1','class'=> 'textBoxExpnd description','div'=>false));?></td>
		
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>
	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
		<tr>
			 <td width="50%" height="35px"><input name="" type="button" value="Add More Radiologies" class="blueBtn addMoreRad" /></td>
			 <td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveRadBill"></td>
		</tr>
	</table>
<?php echo $this->Form->end();?>
</div>
<?php }?>
<!--  radiology section end-->



<!--Implant Section starts here-->
<?php if($isDischarge!=1){?>
<div class="dynamicServiceSection" id="implantSection" style="display: none">
<!--  BOF blood  -->
<?php echo $this->Form->create('implantService',array('controller'=>'billings','action'=>'',$patient['Patient']['id'],'type' => 'file','id'=>'implantServiceFrm','inputDefaults' => array(
																						        'label' => false,
																						        'div' => false,
																						        'error' => false,
																						        'legend'=>false,
																						        'fieldset'=>false
)
));
echo $this->Form->hidden('billings.location_id', array('value'=>$this->Session->read('locationid')));
echo $this->Form->hidden('billings.patient_id', array('id'=>'patient_id','value'=>$patientID)); ?>
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
						'label'=>false,'div'=>false,'value'=>'1','autocomplete'=>'off'));?></td>
			
			<td id="implantTotalAmount_1" class="implantTotalAmount" valign="middle" style="text-align:center;"></td>
			<td align="center">
				<?php echo $this->Form->input('description',array('class'=>' textBoxExpnd implantDescription','id'=>'implantDescription_1',
						'type'=>'text','style'=>'width:150px;','name'=>'data[ServiceBill][0][description]','label'=>false,'div'=>false));?></td>
						
			<td valign="middle" style="text-align:center;"></td>  
		</tr>
 </table>
<div id="pageNavPosition" align="center"></div>
<!-- billing activity form end here -->
	<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
		<tr>
			<td width="50%" height="35px"><input name="addImplant" type="button" value="Add More Implant Services" class="blueBtn addMoreImplant" onclick="addImplantService();" />  </td>
			<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveImplantData"> </td>
		</tr>
	</table>
	<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--Implant Section Ends here-->

 


<!--ward procedure Section starts here-->
<?php if($isDischarge!=1){?>
<div class="dynamicServiceSection" id="wardSection" style="display: none">
<!--  BOF blood  -->
<?php echo $this->Form->create('wardService',array('controller'=>'billings','action'=>'','type' => 'file','id'=>'wardProcedureFrm','inputDefaults' => array(
																						        'label' => false,
																						        'div' => false,
																						        'error' => false,
																						        'legend'=>false,
																						        'fieldset'=>false
)
)); ?>
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
	<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
		<tr>
			<td width="50%" height="35px"><input name="addWard" type="button" value="Add More Ward Procedures" class="blueBtn addMoreWard" onclick="addWardService();" />   </td>
			<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveWardData"> </td>
		</tr>
	</table>
	<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--ward procedure Section Ends here-->

  

<!--other service Section starts here-->
<?php if($isDischarge!=1){?>
<div class="dynamicServiceSection" id="otherServiceSection" style="display: none">
<?php echo $this->Form->create('other_service',array('controller'=>'billings','action'=>'','type' => 'file','id'=>'otherServiceFrm','inputDefaults' => array(
																						        'label' => false,
																						        'div' => false,
																						        'error' => false,
																						        'legend'=>false,
																						        'fieldset'=>false
)));?>
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
<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
	<tr>
		<td width="50%" height="35px"><input name="addOtherServiceRows" type="button" value="Add More Other Services" class="blueBtn addMoreOtherService" onclick="addOtherService(null);" /> </td>
		<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveOtherServiceData"> </td>
	</tr>
</table>
<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--other service Section Ends here-->




<!--radiotheraphy service Section starts here-->
<?php if($isDischarge!=1){?>
<div class="dynamicServiceSection" id="radiotheraphySection" style="display: none">
<?php echo $this->Form->create('Radiotheraphy',array('controller'=>'billings','action'=>'','type' => 'file','id'=>'radiotheraphyFrm','inputDefaults' => array(
																						        'label' => false,
																						        'div' => false,
																						        'error' => false,
																						        'legend'=>false,
																						        'fieldset'=>false
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
<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
	<tr>
		<td width="50%" height="35px"><input name="addRadiotheraphyRows" type="button" value="Add More Radiotheraphy" class="blueBtn addMoreRadiotheraphy" onclick="addRadiotheraphy(null);" /> </td>
		<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveRadiotheraphyData"> </td>
	</tr>
</table>
<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--radiotheraphy Section Ends here-->


	
<!-- date section end here -->
	
<!-- BOF Consultant Section -->
<?php if($isDischarge!=1){?>
<div class="dynamicServiceSection" id="consultantBillingSection" style="display: none;">
<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'consultantBilling','type' => 'file','id'=>'ConsultantBillingNew','inputDefaults' => array(
																						        'label' => false,
																						        'div' => false,
																						        'error' => false,
																						        'legend'=>false,
																						        'fieldset'=>false
)
));
echo $this->Form->hidden('patient_id',array('value'=>$patientID)); ?>
<table width="100%"  cellpadding="0" cellspacing="1" border="0" align="left" class="tabularForm"id="consulTantGridNew">
			<tr>
				<th width=""><?php echo __('Date');?></th>
				<th><?php echo __('Not To Pay Doctor');?></th>
				<th width=""><?php echo __('Type');?></th>
				<th width="" style=""><?php echo __('Name');?></th>
				<th width="" style=""><?php echo __('Service');?></th>
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
		 <td width="50%" height="35px"> <input name="addConsultant" type="button" value="Add More Visits" class="blueBtn addMoreConsultant" onclick="addConsultantVisitElement();" /></td>
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
if($isDischarge!=1){?>
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
echo $this->Form->hidden('Billing.payment_category',array('id'=>'payment_category'));
echo $this->Form->hidden('serviceGroupId', array('id'=>'serviceGroupId'));
echo $this->Form->hidden('location_id', array('value'=>$this->Session->read('locationid')));
echo $this->Form->hidden('patient_id', array('id'=>'patient_id','value'=>$patientID));
if(isset($corporateId) && $corporateId != ''){
	echo $this->Form->hidden('corporate_id', array('value'=>$corporateId));
}else{
	echo $this->Form->hidden('corporate_id', array('value'=>''));
} ?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" style=" clear:both" class="tabularForm" id="serviceGrid">
			<tr>
				<th width="140"><?php echo __('Date');?></th>
				<!--<th width="250"><?php //echo __('Type');?></th>
				<th width="250" style=""><?php //echo __('Name');?></th>-->
				<!--<th width="250" style=""><?php //echo __('Service Group/Sub Group');?></th>-->
				<!-- <th width="150" style=""><?php //echo __('Service Group');?></th>
				<th width="150" style=""><?php //echo __('Service Sub Group');?></th> -->
				<th width="150" style=""><?php echo __('Service');?></th>
				<!--<th width="100" style=""><?php //echo __('Hospital Cost');?></th> -->
				<th width="100"><?php echo __('Unit Price');?></th>
				<th width="80" style=""><?php echo __('No of times');?></th>
				<th width="100" style=""><?php echo __('Amount');?></th>
				<th width="100" style=""><?php echo __('Description');?></th>
				<th width="50"><?php echo __('Action');?></th>
			</tr>
			
			<!-- row to add services -->
			<tr id="row_1">
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
				<?php echo $this->Form->input('amount',array('readonly'=>'readonly','class' => 'validate[required,custom[onlyNumber]] textBoxExpnd service_amount kanpurAmount','legend'=>false,'label'=>false,'id' => 'service_amount_1','style'=>'width:95px; text-align:right;','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][amount]','autocomplete'=>'off'));
					  echo $this->Form->input('fix_discount',array('class'=>'fix_discount','id'=>'fix_discount_1','type'=>'hidden','name'=>'data[ServiceBill][0][fix_discount]',
							'label'=>false,'div'=>false,'autocomplete'=>'off'));

						 ?></td>
				
				<td align="center">
					<?php echo $this->Form->input('no_of_times',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd no_of_times nofTime',
							'id'=>'no_of_times_1','type'=>'text','style'=>'width:80px;','name'=>'data[ServiceBill][0][no_of_times]',
							'label'=>false,'div'=>false,'value'=>'1'));?></td>
				
				<td id="amount_1" class="amount" valign="middle" style="text-align:center;"></td>
				<td align="center">
					<?php echo $this->Form->input('description',array('class'=>' textBoxExpnd description','id'=>'description_1',
							'type'=>'text','style'=>'width:150px;','name'=>'data[ServiceBill][0][description]','label'=>false,'div'=>false));?></td>
				<td valign="middle" style="text-align:center;"></td>  
			</tr>
	 </table>
		<!-- EOF services -->
 <div id="pageNavPosition" align="center"></div>
<!-- billing activity form end here -->
	<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
		<tr>
			<td width="50%" height="35px"><input name="addService" type="button" value="Add More Services" class="blueBtn addMore" onclick="addServiceVisitElement();" />  </td>
			<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="ServiceBillsData"> </td>
		</tr>
	</table>
	<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--  Service section end-->



<!--  blood section start-->
<?php if($isDischarge!=1){?>
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
echo $this->Form->hidden('billings.patient_id', array('id'=>'patient_id','value'=>$patientID));  ?>
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
				<?php echo $this->Form->input('amount',array('readonly'=>'readonly','class' => 'validate[required,custom[onlyNumber]] textBoxExpnd bloodAmount kanpurAmount',
						'legend'=>false,'label'=>false,'id' => 'bloodAmount_1','style'=>'width:95px; text-align:right;','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][amount]','autocomplete'=>'off'));
					   echo $this->Form->hidden('fix_discount',array('readonly'=>'readonly', 'class' => 'fix_discount',
						'legend'=>false,'label'=>false,'id' => 'bfix_discount_1','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][fix_discount]','autocomplete'=>'off'));

						 ?></td>
				
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
	<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
		<tr>
			<td width="50%" height="35px"><input name="addBlood" type="button" value="Add More Blood Services" class="blueBtn addMoreBlood" onclick="addBloodService();" /> </td>
			<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveBloodData"> </td>
		</tr>
	</table>
	<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--  Service section end-->
 
<div>&nbsp;</div>
<div id="newLayout">
	<!-- - GLOBAL DIV PAWAN-->
	<div id="globalDivId" ></div>
	<!-- - GLOBAL DIV PAWAN-->
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
				  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#service-group-id'+fieldno).val()+"/"+'?tariff_standard_id='+tariffStandardID,
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
	 }
		
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
					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices","admin" => false)); ?>"+"/"+$('#service-group-id'+fieldno).val()+"/"+$('#service-sub-group'+fieldno).val()+'?tariff_standard_id='+tariffStandardID,
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
 					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#add-service-group-id'+fieldno).val()+"/"+$('#add-service-sub-group'+fieldno).val()+'?tariff_standard_id='+tariffStandardID,
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


         
  

      $( ".lab_order_date" ).datepicker({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			//dateFormat:'dd/mm/yy HH:II:SS',
			//minDate:new Date(),
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
  				maxDate:new Date(),
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
          isNursing='<?php echo $isNursing;?>';
    	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxServiceData","admin" => false)); ?>"+'/'+patient_id+'?groupID='+groupID+'&isMandatory='+isMandatory+'&isNursing='+isNursing;
          $.ajax({
          	beforeSend : function() {
              	//loading("outerDiv","class");
              	loading();
          		$("#busy-indicator").show();
            	},
          type: 'POST',
          url: ajaxUrl,
          dataType: 'html',
          success: function(data){
        	$("#servicefrm").trigger('reset');
        	$("#servicesSection").show();
        	$('.amount').html('');
        	if(isDefault!='default')
        		$('#service_id_1').focus();
          	//onCompleteRequest("outerDiv","class");
          	$("#busy-indicator").hide();
          	onCompleteRequest();
          	if(data!=''){           		  
         		$('#globalDivId').html(data);
         		
         		
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
	  isNursing='<?php echo $isNursing;?>';
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxConsultationData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId+'?isNursing='+isNursing;
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
    			 $('#globalDivId').html(data);
    			
    			 
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
		 isNursing='<?php echo $isNursing;?>';
		 
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxLabData","admin" => false)); ?>"+'/'+patient_id+'?isNursing='+isNursing;
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
	        			 $('#globalDivId').html(data);
	        			
	        			 
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
			 source: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "labChargesAutocomplete","admin" => false,"plugin"=>false)); ?>"+'/'+patientID,
				 minLength: 1,
				 select: function( event, ui ) { 
					$('#labid_'+ID).val(ui.item.id);
					var charges=ui.item.charges;
					valueRes=ui.item.value;
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
					if(charges !== undefined && charges !== null && charges !== ''){
						charges = charges.replace(/,/g, '');
						$('#labAomunt_'+ID).val($.trim(charges));
						$('#lfix_discount_'+ID).val(ui.item.fix_discount);
					}else{
						$('#labAomunt_'+ID).val('');
						$('#lfix_discount_'+ID).val('');
						inlineMsg(currentId,errorMsg,10);
					}
					//$('#labAomunt_'+ID).val(ui.item.charges);
					//if(ui.item.id != '');
					//$( '#labid_'+ID).trigger("change");
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
	    			)	
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
			 
	 });	
	// Eof save lab

	
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
					.append($('<td id=billableRad_'+counter+'>').append($('<input>').attr({'id':'isBillable_'+counter,'class':'textBoxExpnd','type':'checkbox','name':'data[RadiologyTestOrder][is_billable][]','value' : '1'})))
					.append($('<td>').append($('<input>').attr({'readonly':'readonly','id':'radDate_'+counter,'class':'textBoxExpnd radDate','type':'text','name':'data[RadiologyTestOrder][radiology_order_date][]','value':todayDate})))
					.append($('<td>').append($('<input>').attr({'id':'radiologyname_'+counRad,'class':'validate[required,custom[mandatory-enter]] radiology_name textBoxExpnd','type':'text','name':'data[RadiologyTestOrder][rad_name][]'}))
							.append($('<input>').attr({'id':'radiologytest_'+counRad,'class':'textBoxExpnd radiology_test','type':'hidden','name':'data[RadiologyTestOrder][radiology_id][]'}))
							//.append($('<span>').attr({'class':'radOrderText','id':'radOrderText_'+counRad,'style':'float:right; cursor: pointer;','title':'Radiology Order Detail'}).append($('<strong>...</strong>')))
							)
		    		.append($('<td>').append($('<select>').attr({'id':'service_provider_id'+counRad,'class':'textBoxExpnd ','type':'select','name':'data[RadiologyTestOrder][service_provider_id][]'}).append(appendRadOption)))
		    		.append($('<td>').append($('<input>').attr({'readonly':'readonly','style':'text-align:right','id':'radAomunt_'+counRad,'class':'textBoxExpnd radAomunt validate[required,custom[mandatory-enter]] radServiceAmount','type':'text','name':'data[RadiologyTestOrder][amount][]'}))
		    			.append($('<input>').attr({'id':'rfix_discount_'+counRad,'class':'fix_discount','type':'hidden','name':'data[RadiologyTestOrder][fix_discount][]'}))
		    			)
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
			 
	 });


	 $(document).on('focus','.radiology_name', function() {
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$(this).autocomplete({
				 source: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "radChargesAutocomplete","admin" => false,"plugin"=>false)); ?>"+'/'+patientID,
					 minLength: 1,
					 select: function( event, ui ) { 
						/*$('#radiologytest_'+ID).val(ui.item.id);
						$('#radAomunt_'+ID).val(ui.item.charges);*/
						var charges= ui.item.charges;
						if(charges == '0'){
							charges ='';
						}
						$('#radiologytest_'+ID).val(ui.item.id);
						if(charges !== undefined && charges !== null && charges !== ''){
							charges = charges.replace(/,/g, '');
							$('#radAomunt_'+ID).val($.trim(charges));
							$('#rfix_discount_'+ID).val(ui.item.fix_discount);
						}else{
							$('#radAomunt_'+ID).val('');
							$('#rfix_discount_'+ID).val('');
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
			 isNursing='<?php echo $isNursing;?>';
			 
		   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxRadData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId+'?isNursing='+isNursing ;
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
		        			 $('#globalDivId').html(data);
		        			
		        			 
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
	        			 $('#globalDivId').html(data);
	        			
	        			 
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }
	//EOF pharmacy
	
	
	//BOF blood
	 function getBloodData(patient_id,groupID){
	  isNursing='<?php echo $isNursing;?>';
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxBloodData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'?isNursing='+isNursing ;
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
        			 $('#globalDivId').html(data);
        			
        			 
        			// medCount = $("#noMeddisable").val() ;
         	}
         },
 		});
	 }
	//EOF blood
	
	 //$('#payment_category').val($("input[type='radio'][name='serviceGroupData']").val());
	 
	 $("input[type='radio'][name='serviceGroupData']").on('click',function(){		//service Group Id 
		   loading(); //for blocking radio option area
		   $('#payment_category').val($(this).val());
		   $('#serviceGroupId').val($(this).val());
		   $('.dynamicServiceSection').hide();
		   $(".serviceAddMoreRows").remove();
		   $(".radAddMoreRows").remove();
		   $(".labAddMoreRows").remove();
		   $('#privatePackageTable').hide();
		   
		   $('form').each(function() {this.reset()});// to clear previous data on form
		   
		   
		   /* if($(this).attr('radioName')=='mandatoryservices_radio'){
			   getMandatoryServiceData('<?php //echo $patientID;?>','<?php //echo $tariffStandardID ;?>');
			}else 
			*/
			
			if($(this).attr('radioName')=='laboratory_radio'){ //for lab services
			   $("#pathologySection").show();
			   $("#paymentDetailDiv").show();
			   $('#test_name_1').focus();
			   //$('#amount').attr('readonly',true);
			   //$('#msgForServicePayment').html('Full payment is required for laboratory .');
			   getLabData('<?php echo $patientID;?>');
		   }else if($(this).attr('radioName')=='radiology_radio'){//radiology
			   $("#radiologySection").show();
			   $("#paymentDetailDiv").show();
			   $('#radiologyname_1').focus();
			   //$('#amount').attr('readonly',true);
			   //$('#msgForServicePayment').html('Full payment is required for radiology .');
			   getRadData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>');
		   }else if($(this).attr('radioName')=='pharmacy_radio'){ //pharmacy
			   //$("#pharmacySection").show();
			   $("#paymentDetailDiv").show();
			   //$('#amount').attr('readonly',false);
			  // $('#msgForServicePayment').html('');
			   getPharmacyData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>');
		   }else if($(this).attr('radioName')=='roomtariff_radio'){ //roomtariff
			   //$("#pharmacySection").show();
			   $("#paymentDetailDiv").show();
			   //$('#amount').attr('readonly',false);
			   //$('#msgForServicePayment').html('');
			   getDailyRoomData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>');
		   }else if($(this).attr('radioName')=='surgery_radio'){ //surgery
			   //$("#pharmacySection").show();
			   $("#paymentDetailDiv").show();
			  // $('#amount').attr('readonly',false);
			  // $('#msgForServicePayment').html('');
			   getProcedureData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>');
		   }else if($(this).attr('radioName')=='consultant_radio'){ //consultant billing
			   $("#consultantBillingSection").show();
			   $("#paymentDetailDiv").show(); 
			   $('#consultant_service_id_1').focus();
			   getConsultationData('<?php echo $patientID;?>','<?php echo $tariffStandardID ?>');
		   }else if($(this).attr('radioName')=='blood_radio'){ //blood billing
			   $("#bloodSection").show();
			   $("#paymentDetailDiv").show(); 
			   $('#bloodServiceId_1').focus();
			   getBloodData('<?php echo $patientID;?>',$(this).val());
		   }else if($(this).attr('radioName')=='implant_radio'){ //implant billing
			   $("#implantSection").show();
			   $("#paymentDetailDiv").show(); 
			   $('#implantServiceId_1').focus();
			   getImplantData('<?php echo $patientID;?>',$(this).val());
		   }else if($(this).attr('radioName')=='ward_radio'){ //ward procedure billing
			   $("#wardSection").show();
			   $("#paymentDetailDiv").show(); 
			   $('#wardServiceId_1').focus();
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
			   getRadiotheraphyData('<?php echo $patientID;?>',$(this).val());
		   }else if($(this).attr('radioName')=='privatepackage_radio'){ //consultant billing
			   getPackageData(packagedPatientId);
			   $('#privatePackageTable').show();
		   }else{ //else for dynamic services
			   $("#paymentDetailDiv").show();
			   if($(this).attr('radioName') != 'mandatoryservices_radio'){
				   $("#servicesSection").hide();
				  // $('#service_id_1').focus();
				 //  $('#amount').attr('readonly',true);
				  // $('#msgForServicePayment').html('');
				   getServiceData('<?php echo $patientID;?>',$(this).val());
			   }else{ 
				   $("#servicesSection").hide();
				   //$('#service_id_1').focus();
				 //  $('#amount').attr('readonly',true);
			   	   //$('#msgForServicePayment').html('Full payment is required for mandatory services.');
				   getServiceData('<?php echo $patientID;?>',$(this).val(),'mandatoryservices');
			   }
		   } 
	});		//end of service group click  


	 
	
 
	 function getbillreceipt(patient_id){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxBillReceipt","admin" => false)); ?>"+'/'+patient_id;
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
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }

	 

	 function getDailyRoomData(patient_id,tariffStandardId){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxDailyroomData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId;
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
	        			 $('#globalDivId').html(data);
	        			
	        			 
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
	        			 $('#globalDivId').html(data);
	        			
	        			 
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
		        		$('#globalDivId').html(data);
		        	}
		        },
	 		});
	     }

     

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
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID,
				 minLength: 1,
				 select: function( event, ui ) {					 
					$('#onlyServiceId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					/*if(charges !== undefined && charges !== null){
						$('#service_amount_'+ID).val(charges.trim());
						$('#amount_'+ID).html(charges.trim());
					}*/
					if(charges == '0'){
						charges ='';
					}
					if(charges !== undefined && charges !== null && charges !== ''){
						charges = charges.replace(/,/g, '');
						$('#service_amount_'+ID).val(charges.trim());
						if(ui.item.fix_discount !== undefined && ui.item.fix_discount !== null && ui.item.fix_discount !== ''){
								$('#fix_discount_'+ID).val(ui.item.fix_discount);
							}
						$('#amount_'+ID).html(charges.trim());
						$( '.clinicalServiceAmount').trigger("change");//to maintain clinical service amount  --yashwant
					}else{
						$('#service_amount_'+ID).val('');
						$('#amount_'+ID).html('');
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



	 $(document).on('focus','.consultant_service_id', function() {
		currentID=$(this).attr('id');
		splitedVar=currentID.split('_');
	 	ID=splitedVar[3]; 
	 	selectedGroup=$('#serviceGroupId').val();
	 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
		$("#consultant_service_id_"+ID).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID,
			 minLength: 1,
			 select: function( event, ui ) {					 
				$('#onlyConsultantServiceId_'+ID).val(ui.item.id);
				var id = ui.item.id; 
				var charges=ui.item.charges;
				/*if(charges !== undefined && charges !== null){
					$('#amountConsultant_'+ID).val(charges.trim());
					//$('#amount'+ID).html(charges.trim());
				}*/
				if(charges == '0'){
					charges ='0'; //for kanpur allow 0 charges to save... --yashwant
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


	 $(document).on('focus','.blood_service', function() {
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
		 	ID=splitedVar[1]; 
		 	selectedGroup=$('#serviceGroupId').val();
		 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
			$("#bloodServiceId_"+ID).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID,
				 minLength: 1,
				 select: function( event, ui ) {					 
					$('#onlyBloodId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					/*if(charges !== undefined && charges !== null){
						$('#bloodAmount_'+ID).val(charges.trim());
						$('#bloodTotalAmount_'+ID).html(charges.trim());
					}*/
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


	 $(document).on('focus','.implant_service', function() {
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
		 	ID=splitedVar[1]; 
		 	selectedGroup=$('#serviceGroupId').val();
		 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
			$("#implantServiceId_"+ID).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID,
				 minLength: 1,
				 select: function( event, ui ) {					 
					$('#onlyImplantId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					/*if(charges !== undefined && charges !== null){
						$('#implantAmount_'+ID).val(charges.trim());
						$('#implantTotalAmount_'+ID).html(charges.trim());
					}*/
					if(charges == '0'){
						charges ='';
					}
					if(charges !== undefined && charges !== null && charges !== ''){
						charges = charges.replace(/,/g, '');
						$('#implantAmount_'+ID).val(charges.trim());
						$('#implantTotalAmount_'+ID).html(charges.trim());
					}else{
						$('#implantAmount_'+ID).val('');
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


	 $(document).on('focus','.ward_service', function() {
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
		 	ID=splitedVar[1]; 
		 	selectedGroup=$('#serviceGroupId').val();
		 	//var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
			$("#wardServiceId_"+ID).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID,
				 minLength: 1,
				 select: function( event, ui ) {					 
					$('#onlyWardId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					/*if(charges !== undefined && charges !== null){
						$('#wardAmount_'+ID).val(charges.trim());
						$('#wardTotalAmount_'+ID).html(charges.trim());
					}*/
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

	 $(document).on('focusout','.service_id', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[2]; 
		 if($(this).val()==''){
			 $('#onlyServiceId_'+ID).val('');
			 $('#service_amount_'+ID).val('');
			 $('#fix_discount_'+ID).val('');
			 $('#amount_'+ID).html('');
		 }
	 });

	 $(document).on('focusout','.test_name', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[2];  
		 if($(this).val()==''){
			 $('#labid_'+ID).val('');
			 $('#labAomunt_'+ID).val('');
			 $('#lfix_discount_'+ID).val('');
		 }
	 });

	 $(document).on('focusout','.radiology_name', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[1];  
		 if($(this).val()==''){
			 $('#radiologytest_'+ID).val('');
			 $('#radAomunt_'+ID).val('');
			 $('#rfix_discount_'+ID).val('');
		 }
	 });

	 $(document).on('focusout','.blood_service', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[1];  
		 if($(this).val()==''){
			 $('#bloodAmount_'+ID).val('');
			 $('#bfix_discount_'+ID).val('');
			 $('#bloodTotalAmount_'+ID).html('');
		 }
	 });
	
	//BOF Implant section
	 function getImplantData(patient_id,groupID){
	  isNursing='<?php echo $isNursing;?>';
		  
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxImplantData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'?isNursing='+isNursing;
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
        		$('#globalDivId').html(data);
        		
        		
         	}
         },
 		});
	 }
	//EOF Implant section
	
	//BOF ward section
	 function getWardData(patient_id,groupID,ward){
	 isNursing='<?php echo $isNursing;?>';
	  
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxWardProcedureData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'?isWard='+ward+'&isNursing='+isNursing ;
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
        		$('#globalDivId').html(data);
        		
        		
         	}
         },
 		});
	 }
	//EOF ward section 
	
	// add more for ward procedures data
	function addWardService()
	{	 
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
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="wardAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd wardAmount kanpurAmount" readonly="readonly" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
		 field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="wardQty_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd wardQty" name="data[ServiceBill]['+number_of_field+'][no_of_times]" value="1"></td>';
	     field +='<td id="wardTotalAmount_'+number_of_field+'" class="wardTotalAmount" align="center" width="100"></td>';
	     field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="wardDescription_'+number_of_field+'" class=" textBoxExpnd wardDescription" name="data[ServiceBill]['+number_of_field+'][description]"></td>';
		 field +=' <td align="center" width="50"><a href="javascript:void(0);" id="delete_row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="<?php echo $this->webroot ?>theme/Black/img/cross.png" ></a></td>  </tr>';
		 $("#no_of_fields").val(number_of_field);
		  
		 $("#wardArea").append(field);
		// $('#add-service-group-id1 option').clone().appendTo('#add-service-group-id'+number_of_field);
		// $("#bloodArea").append(amoutRow);
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
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="implantAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd implantAmount kanpurAmount" readonly="readonly" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
		 field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="implantQty_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd implantQty" name="data[ServiceBill]['+number_of_field+'][no_of_times]" value="1"></td>';
	     field +='<td id="implantTotalAmount_'+number_of_field+'" class="implantTotalAmount" align="center" width="100"></td>';
	     field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="implantDescription_'+number_of_field+'" class=" textBoxExpnd implantDescription" name="data[ServiceBill]['+number_of_field+'][description]"></td>';
		 field +=' <td align="center" width="50"><a href="javascript:void(0);" id="delete_row" onclick="deleteVisitRow('+number_of_field+');"><img title="delete row" alt="Remove" src="<?php echo $this->webroot ?>theme/Black/img/cross.png" ></a></td>  </tr>';
		 $("#no_of_fields").val(number_of_field);
		  
		 $("#implantArea").append(field);
		// $('#add-service-group-id1 option').clone().appendTo('#add-service-group-id'+number_of_field);
		// $("#bloodArea").append(amoutRow);
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
	
	//Add more for services moved from permission.js
	function addServiceVisitElement()
	{	 
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
		 field +=' <td valign="middle" width="140"><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:135px;" class="validate[required,custom[mandatory-date]] textBoxExpnd ServiceDate" id="ServiceDate_'+number_of_field+'" name="data[ServiceBill]['+number_of_field+'][date]" value="'+tadayDate+'"> </td>';
		// field +=' <td align="center" width="150"><select fieldno="'+number_of_field+'" class="textBoxExpnd add-service-group-id" style="width:150px;" id="add-service-group-id'+number_of_field+'" 	  name="data[ServiceBill]['+number_of_field+'][service_id]" onchange="getListOfSubGroupServices(this);"> </select></td>';
		// field +=' <td align="center"width="150"><select fieldno="'+number_of_field+'" style="width:150px;" class="textBoxExpnd add-service-sub-group" name="data[ServiceBill]['+number_of_field+'][sub_service_id]" id="add-service-sub-group'+number_of_field+'"   onchange="serviceSubGroups(this)"> </select></td>';
		// field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'"  id="add-service-sub-group'+number_of_field+'" class="service-sub-group textBoxExpnd " name=" " > <input type="hidden" fieldno="'+number_of_field+'"  id="addServiceSubGroupId_'+number_of_field+'" class="addServiceSubGroupId" name="data[ServiceBill]['+number_of_field+'][sub_service_id]" ></td>';
		 field +='<td align="center" width="150"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="service_id_'+number_of_field+'" class="validate[required,custom[mandatory-enter]] textBoxExpnd service_id" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" div="false" label="false"> <input type="hidden" fieldno="'+number_of_field+'"  id="onlyServiceId_'+number_of_field+'" class="onlyServiceId" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" ></td>';
		 //field +=' <td align="center" width="150"><select fieldno="'+number_of_field+'" style="width:150px;" id="service_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd service_id" name="data[ServiceBill]['+number_of_field+'][tariff_list_id]" onchange="service_id(this);"> <option value="">Please Select</option> <option value="0"></option> </select></td>';
		 //field +='<td align="center" width="100"><select fieldno="'+number_of_field+'" style="width:100px;" id="service_id'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd " name="data[ServiceBill]['+number_of_field+'][hospital_cost]" onchange="service_id(this);"> <option value="">Please Select</option> <option value="0"></option> </select></td>';
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="service_amount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd service_amount kanpurAmount" readonly="readonly" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
		 field +='<input type="hidden" fieldno="'+number_of_field+'" id="fix_discount_'+number_of_field+'" class=" fix_discount" name="data[ServiceBill]['+number_of_field+'][fix_discount]"></td>';

		 field +='<td align="center" width="80"><input type="text" fieldno="'+number_of_field+'" style="width:80px;" id="no_of_times_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd no_of_times nofTime" name="data[ServiceBill]['+number_of_field+'][no_of_times]" value="1"></td>';
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
	
	$('#prescription').on('click',function(){
		 window.location.href = '<?php echo $this->Html->url(array('controller'=>'Notes','action'=>'addNurseMedication',$patientID));?>'+"? from=Nurse";
	});

	//enter key press for addmore
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

	$(document).on('keypress','.nofTime', function(event) {
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

	//keypress addmore for other services  --yashwant
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

	//keypress addmore for other services  --yashwant
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
	
	//keypress addmore for laboratory
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

	//keypress for radiology
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

	//keypress for consultant billing
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

	//keypress for blood sevice
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

	//BOF other Service section
	 function getOtherServiceData(patient_id,groupID){
	  isNursing='<?php echo $isNursing;?>';
  	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxOtherServiceData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'&isNursing='+isNursing; 
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
       		$('#globalDivId').html(data);
        	}
        },
		});
	 }
	//EOF other Service section
	
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
	
	//BOF getRadiotheraphyData section
	 function getRadiotheraphyData(patient_id,groupID){
	  isNursing='<?php echo $isNursing;?>';
  	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxRadiotheraphyData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'&isNursing='+isNursing;
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
       		$('#globalDivId').html(data);
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
	//EOF radiotheraphy data
	
	//other service autocomplete
	$(document).on('focus','.other_service', function() {
			currentID=$(this).attr('id');
			splitedVar=currentID.split('_');
		 	ID=splitedVar[1]; 
		 	selectedGroup=$('#serviceGroupId').val();
			$("#otherService_"+ID).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getOtherServicesAutocomplete","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+'?tariff_standard_id='+tariffStandardID+'&patient_id='+<?php echo $patientID; ?>+"&admission_type="+"<?php echo $patient['Patient']['admission_type'] ;?>"+"&room_type="+"<?php echo $wardInfo['Room']['room_type']?>"+"&is_nurse=yes",
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


	//radiotheraphy autocomplete
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

	$("#Submit").click(function(){ 
		currentId=$(this).attr('id');
    	var validatePerson = jQuery("#defaultFrm").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
  		var patient_id='<?php echo $patientID;	?>';
  		formData = $('#defaultFrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "nurseBillingActivity", "admin" => false)); ?>"+'/'+patient_id,
  				  context: document.body,
  				  success: function(data){ 
  					$("#busy-indicator").hide();
  					document.getElementById("defaultFrm").reset();
  					inlineMsg(currentId,'Service Added Successfully.',10);	
  					var url="<?php echo $this->Html->url(array('controller'=>$this->params['controller'],'action'=>$this->params['action']));?>";
  		    		window.location.href=url+'/'+patient_id;
  				  },
  				  beforeSend:function(){
	  				  $("#busy-indicator").show();
	  				  },		  
  			});
        });

	$("#addmissionId").autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","IPD",'is_discharge=0',"admin" => false,"plugin"=>false)); ?>", 
		select: function(event,ui){
			var patientId = ui.item.id;
			if($( "#addmissionId" ).val() != '')
	    		var url="<?php echo $this->Html->url(array('controller'=>$this->params['controller'],'action'=>$this->params['action']));?>";
	    		window.location.href=url+'/'+patientId;
	    		//$( "#addmissionId" ).trigger( "change" );
	},
	 messages: {
         noResults: '',
         results: function() {},
  }
});

</script>