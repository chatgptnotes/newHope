<style>
label{
	padding-top:0;
	text-align:left;
	width:100%;
}
</style>

<?php   echo $this->Html->script(array('jquery.fancybox-1.3.4'));  
		echo $this->Html->script(array('permission','jquery.ui.timepicker','jquery.blockUI'));
		echo $this->Html->css(array('jquery.fancybox-1.3.4')) ;
		$billableCondition = (isset($packageInstallment)) ?  'is_billable=1' : '';
		$splitDate = explode(' ',$patient['Patient']['form_received_on']);?>
<script>
var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
var explode = admissionDate.split('-');
/** Global variable to check patient is packaged -- Gaurav */
var isPackagedPatient = '<?php echo (isset($packageInstallment)) ?  true : false; ?>';
var packagedPatientId = '<?php echo $packagedPatientId;?>';
var billableCondition = '<?php echo $billableCondition; ?>';
var radioName = (isPackagedPatient) ? 'privatepackage' : 'mandatoryservices'; //gaurav
$(document).ready(function(){ 
		   patient_ID='<?php echo $patientID; ?>';
		   //getServiceData(patient_ID);
		   getbillreceipt(patient_ID);
		   addCalenderOnDynamicField(); //default calender field
			
		   $("input[type='radio'][radioname="+radioName+"_radio]").attr('checked',true);
		   selRadio = $("input[type='radio'][radioname="+radioName+"_radio]").val()  ;//[isMandatory='yes']
		  // $('#amount').attr('readonly',true);All readonly of amount fields are removed for hospital billing... 
		   //$('#msgForServicePayment').html('Full payment is required for mandatory services.');
		   $('#payment_category').val(selRadio);
		   $('#serviceGroupId').val(selRadio);
		   if(isPackagedPatient){
			   $('#privatePackageTable').show();
			   getPackageData(packagedPatientId);
			}else{
		   		$("#servicesSection").show(); // if patient is not packaged then show 'servicesSection'
		  		//$('#service_id_1').focus();
		   		getServiceData('<?php echo $patientID;?>',selRadio,'mandatoryservices','default');
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

function addCalenderOnDynamicField(){
	$(".ConsultantDate, .ServiceDate, .bloodDate, .implantDate, .wardDate").datepicker({
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
}
 
</script>


<div class="inner_title">
	<h3>&nbsp; <?php echo __('Billing', true); ?></h3>
<?php echo $this->Form->hidden('totalCharge',array('id'=>'totalCharge'));
echo $this->Form->hidden('totalPaid',array('id'=>'totalPaid'));?>

<?php if(strtolower($patient['Patient']['admission_type'])=='opd'){ ?>
	<div align="right"><?php echo $this->Html->link('Back',array('controller'=>'Appointments','action'=>'appointments_management'),
			array('class'=> 'blueBtn','id'=>'backToOpd','escape' => false,'label'=>false,'div'=>false));?>
	</div>
<?php }elseif(strtolower($patient['Patient']['admission_type'])=='ipd'){?>
	<div align="right"><?php echo $this->Html->link('Back',array('controller'=>'Users','action'=>'doctor_dashboard'),
			array('class'=> 'blueBtn','id'=>'backToIpd','escape' => false,'label'=>false,'div'=>false));?>
	</div>
<?php }?>
</div>

<div>&nbsp;</div>

<div class=""><?php  //echo $this->element('print_patient_info');?>
<table width="80%" cellpadding="0" cellspacing="0" border="0" class="tbl" style="border:1px solid #3e474a;">
	<tr>
		<td width=" " valign="top" >
		<table width="100%" border="0" cellspacing="0" cellpadding="5" >
			<tr>
				<td width="38%" height="25" valign="top">Name :</td>
				<td align="left" valign="top"> <?php 
				echo $complete_name  =  $patient['Patient']['lookup_name'] ; 
				if($patient['Person']['vip_chk']=='1'){
					echo $this->Html->image("vip.png", array("alt" => "VIP", "title" => "VIP"));
				}/*else if($patient['Person']['vip_chk']=='2'){
					echo $this->Html->image("foreigner.png", array("alt" => "Foreigner", "title" => "Foreigner"));
				}*/?> </td>
	     	</tr>
	    	<tr>
           		 <td valign="top"  id="boxSpace4" >Sex / Age :</td>
          		 <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($sex);?> / <?php echo ucfirst($age)?></td>
        	</tr>
        	<!-- <tr>
           		 <td valign="top"  id="boxSpace4" >Tariff :</td>
          		 <td align="left" valign="top" style="padding-bottom:10px;"><?php //echo $tariffData[$patient['Patient']['tariff_standard_id']] ;?></td>
        	</tr>
        	
        	<tr>
           		 <td valign="top"  id="boxSpace4" >Ragistration Date :</td>
          		 <td align="left" valign="top" style="padding-bottom:10px;"><?php //echo $this->DateFormat->formatDate2LocalForReport($patient['Patient']['form_received_on'],Configure::read('date_format'),true);
          		 ?></td>
        	</tr> -->
		</table> 
	  	</td>
                
        <td width=" " valign="top">
	  		<table width="100%" border="0" cellspacing="0" cellpadding="5" >
	   		<tr>
           		 <td valign="top"  id="boxSpace4" align="right">Tariff :</td>
          		 <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $tariffData[$patient['Patient']['tariff_standard_id']] ;?></td>
        	</tr>
        	
        	<tr>
           		 <td valign="top"  id="boxSpace4" align="right">Registration Date :</td>
          		 <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $regDate=$this->DateFormat->formatDate2LocalForReport($patient['Patient']['form_received_on'],Configure::read('date_format'),true);
          		 ?></td>
        	</tr> 
	    	</table>
	  	 </td>
	  	 
	  	 <td width=" " valign="top">
	  		<table width="100%" border="0" cellspacing="0" cellpadding="5" >
	   			<tr>
	            	<td height="25" valign="top"  id="boxSpace3" align="right">Registration ID :</td>
	             	<td align="left" valign="top"><?php echo $patient['Patient']['admission_id'] ;?></td>
            	</tr>
            	<tr>
                	<td valign="top"  id="boxSpace3" align="right">Patient ID :</td>
                	<td align="left" valign="top" style="padding-bottom:10px;"><?php echo $patient['Patient']['patient_id'] ;?> </td>
            	</tr>
	    	</table>
	  	 </td>
	  	            
     	<td width=" " valign="top">
	  		<table width="100%" border="0" cellspacing="0" cellpadding="5" >
	   			<!-- <tr>
	            	<td height="25" valign="top"  id="boxSpace3" align="right">Registration ID :</td>
	             	<td align="left" valign="top"><?php //echo $patient['Patient']['admission_id'] ;?></td>
            	</tr>
            	<tr>
                	<td valign="top"  id="boxSpace3" align="right">Patient ID :</td>
                	<td align="left" valign="top" style="padding-bottom:10px;"><?php //echo $patient['Patient']['patient_id'] ;?> </td>
            	</tr> -->
            	<tr>
                	<td valign="top"  id="boxSpace3" align="right">Primary Care Provider :</td>
                	<td align="left" valign="top" style="padding-bottom:10px;"><?php echo $patient['User']['first_name'].' '.$patient['User']['last_name'] ;?> </td>
            	</tr>
            	<?php if(isset($packageInstallment)){?>
					<tr>
						<td valign="top" id="boxSpace3" align="right" colspan="2"><strong><i>Packaged Patient</i></strong></td>
					</tr>
					<?php }?>
	    	</table>
	  	 </td>
	   
    </tr>
</table>
</div>

<!-- BOF for previour encounter list -->
<?php $count=count($encounterId);
if($count>1){
?>
<table>
	<tr style="background-color: #DDDDDD;">
		<td colspan="<?php echo $count;?>"><strong>Encounters Of Patient :</strong></td>
	</tr>
	<tr style="background-color: #DDDDDD;">
		<?php $regDate=explode(' ',$regDate);
			foreach($encounterId as $encounterId){ 
		//for($p=0;$p<=$count-1;){
			$date=$this->DateFormat->formatDate2Local($encounterId['Patient']['form_received_on'],Configure::read('date_format'),false);
			if($date==$regDate['0'])continue;?>
		<td><?php 
			echo $this->Html->link($date,array('controller'=>'Billings','action'=>'multiplePaymentModeIpd',$encounterId['Patient']['id'],'#'=>'serviceOptionDiv','?'=>array('apptId'=>$encounterId['Appointment']['id'])),
					array('class'=> '','id'=>'previousEncounter_'.$encounterId['Patient']['id'],'escape' => false,'label'=>false,'div'=>false));?>
		</td>
		<?php  }//$p++;}?>
	</tr>
</table>
<?php }?>
<!-- EOF for previour encounter list -->

<div>&nbsp;</div>
<div style="min-height:180px" id="ajaxBillReceipt"></div>

<div id="new_item">
<table style="margin-bottom: 30px;" width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<!-- <td width="18%">Claim No. 	Insurance company not selected</td>
		<td width="15%"><?php //echo $this->Form->input('', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false)); ?></td>
		 -->
		 <?php if($isDischarge!=1){?>
			<td width="20%"><?php echo $this->Html->link('Provisional Invoice','#',
					array('style'=>'','class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printReceipt',
					$patientID,'?'=>array('privatePackage'=>$billableCondition)))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?></td>
			
			<?php if(strtolower($patient['Patient']['admission_type'])=='opd'){?>
			<td width="20%"><input class="blueBtn singleBillPayment" type="button" value="Total Payment" id="payAllTotal"></td>
	 		<?php }?>
	 		
			<?php //if($patient['Patient']['admission_type']=='OPD' || $patient['Patient']['admission_type']=='RAD')$text='Final Payment';else$text='Final Payment And Discharge';?>
			<td width="20%"><a href="javascript:void(0);" class="blueBtn singleBillPayment" id="singleBillPayment">Final Payment<?php //echo $text;?></a></td>
			<?php if($patient['Patient']['admission_type']=='IPD' && !isset($packageInstallment)){ ?>
			<td width="15%"><?php echo $this->Html->link('Detailed Invoice','javascript:void(0)',
					array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'billings','action'=>'detail_payment',$patientID
					))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1050,height=670,left=150,top=100'); return false;"));
			?></td>
			<?php }?>
			<td></td>
		<?php }else{?>
			<td width="15%"><?php 
				echo $this->Html->link('Invoice','javascript:void(0)',
					array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printReceipt',
					$patientID))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?></td>
			<td width="20%"><a href="javascript:void(0);" class="blueBtn singleBillPayment" id="singleBillPayment">Single Bill Payment</a></td>
			<?php if($patient['Patient']['admission_type']=='IPD'){ ?>
			<td width="20%"><?php echo $this->Html->link('Revoke Discharge',array('controller'=>'billings','action'=>'revokeDischarge',$patientID),array('class'=> 'blueBtn','id'=>'revoke','escape' => false,'label'=>false,'div'=>false));?></td>
			<?php }else{?>
			<td width="15%"><?php echo $this->Html->link('Continue Visit',array('controller'=>'billings','action'=>'continueVisit',$patientID),array('class'=> 'blueBtn','id'=>'continueVisit','escape' => false,'label'=>false,'div'=>false));?></td>
			<?php }?>
			<?php if($patient['Patient']['admission_type']=='IPD' && !isset($packageInstallment)){ ?>
			<td width="15%"><?php echo $this->Html->link('Detailed Invoice','javascript:void(0)',
					array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'billings','action'=>'detail_payment',$patientID
					))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1050,height=670,left=150,top=100'); return false;"));
			?></td>
			<?php }?>
			<td></td>
		<?php }?>
	</tr>
</table>
</div>
 
<!-- date section start here -->
		<?php
		//if($patient['Patient']['admission_type']!='OPD' && $patient['Patient']['is_discharge']!=1){
		//if($patient['Patient']['is_discharge']!=1){ ?>
<table width="100%" align="right" cellpadding="0" cellspacing="0" border="0" id="serviceOptionDiv">
	<tr>
		<td > 
			<!--  <input type="radio" value="mandatoryServices" id="mandatoryServices" name="serviceGroupData" autocomplete="off" />Mandatory Services    --> 	
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
							'name'=>'serviceGroupData','options' => $serviceGroupData,'legend' =>false,'label' => false,
							'div'=>false,'class'=>'serviceGroupData add-service-group-id','type' => 'radio','separator'=>' '));
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
<?php if($isDischarge!=1){?>
<div class="dynamicServiceSection" id="pathologySection" style="display: none; width: 100%">				

<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'addLab','type' => 'file','id'=>'labServices','inputDefaults' => array(
																							        'label' => false,
																							        'div' => false,
																							        'error' => false,
																							        'legend'=>false,
																							        'fieldset'=>false
)
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
			<?php echo $this->Form->input('',array('type'=>'select','options'=>$serviceProviders,'empty'=>__('None'),
					'id'=>'service_provider_id_1','label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd externalRequisition',
					'name'=>"data[LaboratoryTestOrder][service_provider_id][]"))?>
			
			<td><?php echo $this->Form->input('', array(/*'readonly'=>'readonly',*/'style'=>'text-align:right',
					'name'=>'LaboratoryTestOrder[amount][]','type'=>'text','label'=>false,'id' => 'labAomunt_1',
					'class'=> 'textBoxExpnd specimentype','div'=>false));?></td>
			
			<td><?php echo $this->Form->input('', array('name'=>'LaboratoryTestOrder[description][]','type'=>'text','label'=>false,
					'id' => 'description_1','class'=> 'textBoxExpnd description','div'=>false));?></td>
		
			<td>&nbsp;</td>
		</tr>
		
		<!-- <tr id="orderRow_1"><td colspan="6" class="orderArea" id="orderArea_1" style="display:none"></td></tr>-->
		
	</tbody>
</table>
<div>&nbsp;</div>
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
				echo $this->Form->input('', array('type'=>'text','id' => 'radDate','label'=>false,'div'=>false,
				'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  radDate','style'=>'width:120px;',
				'readonly'=>'readonly','name'=>'data[RadiologyTestOrder][radiology_order_date][]','value'=>$todayRadDate)); ?>
			</td>
			
			<td ><?php echo $this->Form->input('', array('id' => 'radiologyname_1','type'=>'text', 'label'=> false, 'div' => false,
					 'error' => false,'autocomplete'=>false,'class'=>'validate[required,custom[mandatory-enter]] radiology_name textBoxExpnd','name'=>'data[RadiologyTestOrder][rad_name][]'));
			echo $this->Form->hidden('', array('type'=>'text','name'=>'data[RadiologyTestOrder][radiology_id][]','id'=>'radiologytest_1','class'=>'radiology_test'));
			?><!-- 
			<span class="radOrderText" id="radOrderText_1" style="float:right; cursor: pointer;" title="Radiology Order Detail"><strong>...</strong></span> --></td>
		
			<td>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>$radServiceProviders,'empty'=>__('None'),'id'=>'service_provider_id1',
											'label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd','name'=>"data[RadiologyTestOrder][service_provider_id][]"))?>
			
			<td><?php echo $this->Form->input('', array(/*'readonly'=>'readonly',*/'style'=>'text-align:right','name'=>'data[RadiologyTestOrder][amount][]','type'=>'text','label'=>false,'id' => 'radAomunt_1','class'=> 'textBoxExpnd radAomunt','div'=>false));?></td>
			
			<td><?php echo $this->Form->input('', array('name'=>'data[RadiologyTestOrder][description][]','type'=>'text','label'=>false,'id' => 'description_1','class'=> 'textBoxExpnd description','div'=>false));?></td>
		
			<td>&nbsp;</td>
		</tr>
		
		
		<!-- <tr id="orderRad_1"><td colspan="6" class="radOrderArea" id="radOrderArea_1" style="display:none"></td></tr> -->
		
	</tbody>
</table>
<div>&nbsp;</div>
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
<?php if($isDischarge!=1){?>
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
<?php if($isDischarge!=1){?>
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
				<?php echo $this->Form->input('amount',array(/*'readonly'=>'readonly',*/ 'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd implantAmount',
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
				<?php echo $this->Form->input('amount',array(/*'readonly'=>'readonly',*/ 'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd wardAmount',
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







<!--  pharmacy section start-->
<?php if($isDischarge!=1){?>
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



 




<!-- Other Services Section Starts -->
<?php if($isDischarge!=1){?>
<div class="dynamicServiceSection" id="otherServicesSection" style="margin-top: 30px; display: none">
<table width="100%" style="margin-top: 70px;" cellpadding="0"
	cellspacing="1" border="0" align="center">
	<tr>
		<td align="right"><input class="blueBtn" type="Button" value="Add"
			id="addOtherServices"></td>
	</tr>
</table>
	
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" align="center" id="viewOtherServices">
	<?php if(!empty($otherServices)){?>
	<tr>
		<th><?php echo __('Date');?></th>
		<th><?php echo __('Service');?></th>
	
		<th><?php echo __('Amount');?></th>
		<th width="50"><?php echo __('Action');?></th>
	</tr>
	<?php
	foreach($otherServices as $otherService){?>
	<tr>
		<td><?php 
		$sDate = explode(" ",$otherService['OtherService']['service_date']);
		echo $this->DateFormat->formatDate2Local($otherService['OtherService']['service_date'],Configure::read('date_format'));
		//echo $otherService['OtherService']['service_date']?></td>
		<td><?php echo $otherService['OtherService']['service_name']?></td>
		<td align="right"><?php echo $this->Number->currency($otherService['OtherService']['service_amount']);?></td>
		<td align="center"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteOtherServices', $otherService['OtherService']['id'],$otherService['OtherService']['patient_id']), array('escape' => false),__('Are you sure?', true));?></td>
	</tr>

	<?php }
	?>
	<?php }else{?>
	<tr>
		<td align="center">No Record in Other Services for <?php echo $patient['Patient']['lookup_name'];?></td>
	</tr>
	<?php }?>
</table>

	<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'saveOtherServices','type' => 'file','id'=>'otherServices','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
	)
	));
	?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	align="center" id="viewAddService" style="display: none">
	<tr>
		<td><?php echo __('Date');?></td>
		<td><?php echo $this->Form->input('OtherService.service_date',array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','legend'=>false,'label'=>false,'id' => 'otherServiceDate','readonly'=>'readonly'));?></td>
	</tr>

	<tr>
		<td><?php echo __('Service');?></td>
		<td><?php echo $this->Form->input('OtherService.service_name',array('class' => 'validate[required,custom[mandatory-enter]]','legend'=>false,'label'=>false,'id' => 'serviceName'));?></td>
	</tr>

	<tr>
		<td><?php echo __('Amount');?></td>
		<td><?php echo $this->Form->input('OtherService.service_amount',array('class' => 'validate[required,custom[mandatory-enter]]','legend'=>false,'label'=>false,'id' => 'serviceAmount','style'=>'text-align:right;'));?></td>
	</tr>

	<tr>
		<td>&nbsp;</td>
		<td align="left" style="padding-left: 53px; padding-top: 10px;"><?php echo $this->Form->hidden('OtherService.patient_id',array('value'=>$patient['Patient']['id'],'legend'=>false,'label'=>false,'id' => 'patientId'));?>

		<input class="blueBtn" style="margin: 0px;" type="submit" value="Save"
			id="saveOtherServices"> <input class="blueBtn" style="margin: 0px;"
			type="button" value="Cancel" id="otherServicesCancel"> <?php //echo $this->Html->link(__('Cancel'),'#', array('id'=>'otherServicesCancel','escape' => false,'class'=>'blueBtn'));?>
		</td>
	</tr>
</table>
	<?php echo $this->Form->end();?></div>
<?php }?>
<!-- Other Services Section Ends -->



<!-- ******** -->

	
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
echo $this->Form->hidden('ConsultantBilling.patient_id',array('value'=>$patientID));
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
			<?php $totalAmount=0;
			foreach($consultantBillingData as $consultantData){ ?>
			<tr>
				<td valign="middle"><?php //echo $consultantData['ConsultantBilling']['date'] ;
				if(!empty($consultantData['ConsultantBilling']['date']))
				echo $this->DateFormat->formatDate2Local($consultantData['ConsultantBilling']['date'],Configure::read('date_format'),true);
				?></td>
				<td valign="middle"><?php 
				$totalAmount = $consultantData['ConsultantBilling']['amount'] + $totalAmount;
				if($consultantData['ConsultantBilling']['category_id']==0){
					echo 'External Consultant';
				}else if($consultantData['ConsultantBilling']['category_id'] ==1){
					echo 'Treating Consultant';
				}
				?></td>
				<td valign="middle" style="text-align: left;"><?php
				if($consultantData['ConsultantBilling']['category_id'] == 0){
					echo $allConsultantsList[$consultantData['ConsultantBilling']['consultant_id']];
				}else if($consultantData['ConsultantBilling']['category_id'] == 1){
					echo $allDoctorsList[$consultantData['ConsultantBilling']['doctor_id']];
				}
				?></td>

				<td valign="middle"><?php echo $consultantData['ServiceCategory']['name']."/".$consultantData['ServiceSubCategory']['name'];?>
				</td>
				<td valign="middle"><?php echo $consultantData['TariffList']['name'];?>
				</td>
				<td valign="middle" style="text-align: center;">---</td> 

				<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($consultantData['ConsultantBilling']['amount']);?>
				</td>
				<td valign="middle" style="text-align: center;"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteConsultantCharges', $consultantData['ConsultantBilling']['id'],$consultantData['ConsultantBilling']['patient_id']), array('escape' => false),__('Are you sure?', true));?>
				</td>
			</tr>
			<?php }?>
				
			<tr id="row_1">
				<td valign="top" width="">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php $todayConsultantDate=date("d/m/Y H:i:s");
					echo $this->Form->input('', array('type'=>'text','id' => 'ConsultantDate_1','label'=>false,'div'=>false,
					'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  ConsultantDate','style'=>'width:135px;',
					'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ConsultantBilling][date][1]','value'=>$todayConsultantDate)); ?>
				</td>
			
				<td valign="top"><input type="checkbox" class="notToPayDr" id="notToPayDr_1" name="data[ConsultantBilling][not_to_pay_dr][1]" value="1"> </td> 
			
				<td valign="top">
					<?php echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd category_id',
						'div' => false,'label' => false,'empty'=>__('Please select'),'options'=>array('External Consultant','Treating Consultant'),
						'id' => 'category_id_1','style'=>'width:152px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][category_id][1]',
						'type'=>'select',"onchange"=>"categoryChange(this)")) ?>
				</td> 
				<td valign="top" style="text-align: left;">
					<?php echo $this->Form->input('ConsultantBilling.doctor_id', array('class' =>
					 'validate[required,custom[mandatory-select]] textBoxExpnd doctor_id','div' => false,'label' => false,'empty'=>__('Please Select'),
					 'options'=>array(''),'id' => 'doctor_id_1','style'=>'width:152px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][doctor_id][1]',
					 "onchange"=>"doctor_id(this)")); ?>
				</td> 
				<!-- <td valign="top" style="text-align: left;">
					<select
						onchange="getListOfSubGroup(this);" name="data[ConsultantBilling][service_category_id][]"
						id="service-group-id1" style="width:167px;" class="textBoxExpnd service-group-id"  fieldNo="1">
						<option value="">Select Service Group</option>
						<?php //foreach($service_group as $key =>$value){ ?>
						<option value="<?php //echo $value['ServiceCategory']['id'];?>"><?php //echo $value['ServiceCategory']['name'];?></option>
						<?php //} ?>
					</select>
					<!-- <br />
					<select id="service-sub-group1" name="data[ConsultantBilling][service_sub_category_id][]" style="width:167px;" 
						fieldNo="1" class="textBoxExpnd service-sub-group"	onchange="serviceSubGroup(this)" >
					</select> ->
				</td> -->
				<td valign="top" style="text-align: left;">
					<?php  /* echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd consultant_service_id',
								'div' => false,'label' => false,'empty'=>__('Please Select'),'options'=>array(''),'id' => 'consultant_service_id1',
								'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][consultant_service_id][]' ,
								"onchange"=>"consultant_service_id(this)")); */
					
					echo $this->Form->input('', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd consultant_service_id',
							'div' => false,'label' => false  ,'id' => 'consultant_service_id_1',
							'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][consultant_service_name][1]'));
					 
					echo $this->Form->hidden('', array('class' => 'onlyConsultantServiceId','id' => 'onlyConsultantServiceId_1',
						'name'=>'data[ConsultantBilling][consultant_service_id][1]'));

					?> 
				</td>
			<!--	<td valign="top" style="text-align: center;">
					<?php  //echo $this->Form->input('', array('class' => 'textBoxExpnd','type'=>'select','options'=>array('private'=>'Private','cghs'=>'CGHS','other'=>'Other'),
							//	'div' => false,'label' => false,'empty'=>__('Please Select'),'id' => 'hospital_cost1',
							//	'style'=>'width:130px;','name'=>'data[ConsultantBilling][hospital_cost][]'));
					?>
					 <div id="hospital_cost_area" style="padding-top:5px;">
						<span id="private" style="display:none"></span>
						<span id="cghs" style="display:none"></span>
						<span id="other" style="display:none"></span>
					</div> 
				</td> -->
				<td valign="top" align="right"><?php echo $this->Form->input('amount',
						array('class' => 'validate[required,custom[onlyNumber]] amount textBoxExpnd','legend'=>false,'label'=>false,
							'id' => 'amountConsultant_1','style'=>'width:80px; text-align:right;','fieldNo'=>1,'name'=>'data[ConsultantBilling][amount][1]')); 
				?></td>
				<td valign="top" style="text-align: center;"><?php echo $this->Form->input('description',
						array('class' => 'description textBoxExpnd','legend'=>false,'label'=>false,'id' => 'description_1',
						'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][description][1]')); 
				?></td>
				
				<td valign="top" style="text-align: center;"><?php echo $this->Form->input('pay_to_consultant',
						array('class' => 'pay_to_consultant textBoxExpnd','legend'=>false,'label'=>false,'id' => 'payToConsultant_1',
						'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][pay_to_consultant][1]')); 
				?></td>
				
				<td valign="top" style="text-align:center;">  </td>  
			</tr>

			<!-- <tr id="ampoutRow">
				<td colspan="6" valign="middle" align="right"><?php //echo __('Total Amount');?></td>
				<td valign="middle" style="text-align: right;"><?php //echo $totalAmount;?>
				</td>
				<td>&nbsp;</td>
			</tr> -->
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
echo $this->Form->hidden('serviceGroupId', array('id'=>'serviceGroupId'));
echo $this->Form->hidden('location_id', array('value'=>$this->Session->read('locationid')));
echo $this->Form->hidden('patient_id', array('id'=>'patient_id','value'=>$patientID));
if(isset($corporateId) && $corporateId != ''){
	echo $this->Form->hidden('corporate_id', array('value'=>$corporateId));
}else{
	echo $this->Form->hidden('corporate_id', array('value'=>''));
}


?>

<table width="100%" cellpadding="0" cellspacing="1" border="0" style=" clear:both" class="tabularForm" id="serviceGrid">
			<tr>
				<?php if(isset($packageInstallment)){?>
				<th class="table_cell" width="63"><strong><?php echo __('Billable Service'); ?></strong></th>
				<?php }?>
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
					<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',
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
				 
				<!-- <td align="center" width="150px">
					<select onchange="getListOfSubGroupServices(this);" name="data[ServiceBill][0][service_id]"
						id="add-service-group-id1" style="width:150px;" class="textBoxExpnd add-service-group-id"  fieldNo="1">
						<option value="">Select Service Group</option>
						<?php //foreach($service_group as $key =>$value){ ?>
						<option value="<?php //echo $value['ServiceCategory']['id'];?>"><?php //echo $value['ServiceCategory']['name'];?></option>
						<?php //} ?>
					</select>
				</td> 
				
				<td align="center" width="150"> 
					<?php //echo $this->Form->input('',array('type'=>'text','class'=>'service-sub-group textBoxExpnd','id'=>'add-service-sub-group1'));
						  //echo $this->Form->hidden('', array('name'=>'data[ServiceBill][0][sub_service_id]','id'=>'addServiceSubGroupId_1','class'=>'addServiceSubGroupId'));?></td>
				-->
				<td align="center" width="150">
					<?php  /* echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd service_id',
								'div' => false,'label' => false,'empty'=>__('Please Select'),'options'=>array(''),'id' => 'service_id1',
								'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ServiceBill][0][tariff_list_id]' ,
								"onchange"=>"service_id(this)")); */
					
					echo $this->Form->input('', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd service_id',
					 	 'div' => false,'label' => false  ,'id' => 'service_id_1','style'=>'width:150px;','fieldNo'=>1, ));

					echo $this->Form->hidden('', array('class' => 'onlyServiceId','id' => 'onlyServiceId_1','name'=>'data[ServiceBill][0][tariff_list_id]'));
					?> </td>
				<!--<td align="center" width="100">
					<?php  echo $this->Form->input('', array('class' => 'textBoxExpnd','type'=>'select','options'=>array('private'=>'Private','cghs'=>'CGHS','other'=>'Other'),
								'div' => false,'label' => false,'empty'=>__('Please Select'),'id' => 'hospital_cost',
								'style'=>'width:100px;','name'=>'data[ServiceBill][0][hospital_cost]' ,  ));
					?>
					<div id="hospital_cost_area" align="center">
						<span id="private" style="display:none"></span>
						<span id="cghs" style="display:none"></span>
						<span id="other" style="display:none"></span>
					</div>
				</td>-->
				
				<td align="center">
				<?php echo $this->Form->input('amount',array(/*'readonly'=>'readonly',*/	'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd service_amount',
						'legend'=>false,'label'=>false,'id' => 'service_amount_1','style'=>'width:95px; text-align:right;','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][amount]','autocomplete'=>'off')); ?></td>
				
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
			
			<!-- row ends -->
			
			
			<!-- row to display the total amount for services -->
			<!--<tr id="ampoutRow">
				<td colspan="6" valign="middle" align="right"><?php //echo __('Total Amount');?></td>
				<td valign="middle" style="text-align: right;"><?php //echo $this->Number->currency($totalAmount);?>
				</td>
				<td>&nbsp;</td>
			</tr> 
			--><!-- row ends -->
	 </table>
		<!-- EOF services -->
		
		
 <div id="pageNavPosition" align="center"></div>
<!-- billing activity form end here -->
<div>&nbsp;</div>

	<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
		<tr>
			<td width="50%"><input name="addService" type="button"
				value="Add More Services" class="blueBtn addMore" onclick="addServiceVisitElement();" /> <!--  &nbsp;&nbsp;
		 <input name="removeVisit" type="button" value="Remove" class="blueBtn"  onclick="removeConsultantVisitElement();" id="removeVisit" style="visibility:hidden"/>
		 -->
			</td>
			<td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="ServiceBillsData"> </td>
		</tr>
	</table>


	<?php echo $this->Form->end();// EOF service bill form ?>
</div>
<?php } //EOF discharge conditions?>
<!--  Service section end-->

<div>&nbsp;</div>




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
				<?php echo $this->Form->input('amount',array(/*'readonly'=>'readonly',*/ 'class' => 'validate[required,custom[onlyNumber]] textBoxExpnd bloodAmount',
						'legend'=>false,'label'=>false,'id' => 'bloodAmount_1','style'=>'width:95px; text-align:right;','fieldNo'=>1,
						'name'=>'data[ServiceBill][0][amount]','autocomplete'=>'off')); ?></td>
				
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

<div>&nbsp;</div>

<div id="newLayout">
<!-- - GLOBAL DIV PAWAN-->

<div id="globalDivId" style="float: left; width: 49%;  max-height: 550px;  overflow: auto;">

</div>

<!-- - GLOBAL DIV PAWAN-->


<div id="paymentDetailDiv" style="float: right; width: 49%" >
<?php //if($isDischarge!=1){?>
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
echo $this->Form->hidden('Billing.tariff_list_id',array('id'=>'tariff_list_id'));
?> 

<table  width="100%" cellspacing="0" cellpadding="0" border="0" style="padding-left: 10px;" align="center" bgcolor="LightGray" >
     <tbody><tr>
     	<td width="80%" valign="top">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
      		<tbody>
      			<tr>
                <td width="200" height="35" class="tdLabel2"><?php echo __('Total Amount' );?></td>
                <td width="100"><?php
                		echo $this->Form->input('Billing.total_amount',array('readonly'=>'readonly','value' => $this->Number->format(ceil($totalCost),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totalamount','style'=>'text-align:right;'));
                		echo $this->Form->hidden('Billing.oneShotTotal',array('id'=>'oneShotTotal'));
                		?>
                 </td>
                 <td id="msgForServicePayment" style="color: red;"></td>
                 </tr>
                 
                 <tr>
                 <td height="35" class="tdLabel2">Advance Amount</td>
                 <td> <?php echo $this->Form->input('Billing.amount_paid',array('readonly'=>'readonly',
                 		'value' => $this->Number->format(ceil($totalAdvancePaid)),'legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'text-align:right;'));
				     ?>
     			</td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
			    <td>Amount Paid</td>
			    <td><?php echo $this->Form->input('Billing.amount',array('autocomplete'=>'off','type'=>'text','value'=>'','legend'=>false,
			    		'label'=>false,'id' => 'amount','style'=>'text-align:right;','class' => 'validate[optional,custom[onlyNumber]]'));?>
			    </td>
			    <td><!-- <span style="float:left;"><font color="red">&nbsp;&nbsp;*&nbsp;</font></span> -->
			    <?php $todayDate=date("d/m/Y H:i:s");
			    echo $this->Form->input('Billing.date',array('readonly'=>'readonly','class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:150px;','value'=>$todayDate));?>
			    </td>
			    </tr>
			    
			     <tr>
			    <td>Discount</td>
			    <td width="165">
			    	<?php $discount=array('Amount'=>'Amount','Percentage'=>'Percentage');
						echo $this->Form->input('Billing.discount_type', array('id' =>'discountType','options' => $discount,
							'autocomplete'=>'off','readonly'=>false,'legend' =>false,'label' => false,'div'=>false,'class'=>'discountType',
							'type' => 'radio','separator'=>'</br>','disabled'=>false));
						echo $this->Form->hidden('Billing.maintainDiscount',array('id'=>'maintainDiscount','value'=>''));
						?>
			    </td>
			    <td width="500" height="80px">
			    	<table height="60px">
			    		<tr>
			    			<td> 
			    				<?php
							          echo $this->Form->input('Billing.is_discount',array('type'=>'text','legend'=>false,'label'=>false,
											'id' => 'discount','autocomplete'=>'off','style'=>'text-align:right; display:none;',
											'value'=>$discountAmount,'readonly'=>false,'class' => 'validate[optional,custom[onlyNumber]]'));
							          echo $this->Form->hidden('Billing.discount',array('id'=>'disc', 'value'=>''));
							    ?>
							   	<span id="show_percentage" style="display:none">%</span>
			    			</td>
			    			<td>
			    				<?php echo $this->Form->input('Billing.discount_by', array('class' => ' textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Please select',$authPerson),'id' => 'discount_authorize_by','style'=>"display:none;",'readonly'=>false)); ?>
			    			</td>
			    		</tr>
			    		<tr>
			    			<td>
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
                
                <tr>
			    <td>Refund</td>
			    <td width="165">
			    	<?php echo $this->Form->input('Billing.refund',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'is_refund'));
			    		  echo $this->Form->hidden('Billing.hrefund',array('id'=>'hrefund','value'=>''));
			    		  echo $this->Form->hidden('Billing.maintainRefund',array('id'=>'maintainRefund','value'=>''));
			    	?>
			    	Yes/No
			    </td>
			    <td width="500" height="80px">
			    	<table height="60px">
			    		<tr>
			    			<td>
						    	<?php echo $this->Form->input('Billing.paid_to_patient',array('type'=>'text','id'=>'refund_amount','style'=>"display:none; "));?>
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
			   	</tr>
                
                
                 <tr>
                <td height="35" class="tdLabel2"><strong>Balance</strong></td>
                <td> <?php echo $this->Form->input('Billing.amount_pending',array('readonly'=>'readonly','value' => $this->Number->format(ceil($totalAmountPending-$dAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totalamountpending','style'=>'text-align:right;','readonly'=>'readonly'));
				  ?>
   				</td>
			   	<td>&nbsp;</td>
			 	</tr>
                
 <?php if(($totalAmountPending >0 && $patient['Patient']['is_discharge']==1) || $patient['Patient']['is_discharge']!=1){?>
 	 
 	<tr>
    <td height="35" class="tdLabel2"><strong>Mode Of Payment<font color="red">*</font></strong></td>
    <td><?php echo $this->Form->input('Billing.mode_of_payment', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:150px;',
   								'div' => false,'label' => false,/*'empty'=>__('Please select'),*/'autocomplete'=>'off','default'=>'Cash',
   								'options'=>array('Bank Deposit'=>'Bank Deposit','Cash'=>'Cash','Cheque'=>'Cheque','Credit Card'=>'Credit Card','Credit'=>'Credit','NEFT'=>'NEFT'),
    							'id' => 'mode_of_payment')); ?>
   	</td>
   </tr> 
   <tr id="creditDaysInfo" style="display:none">
	  	<td height="35" class="tdLabel2">Credit Period<font color="red">*</font><br /> (in days)</td>
	    <td><?php echo $this->Form->input('Billing.credit_period',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'credit_period','class'=> 'validate[required,custom[mandatory-enter-only]]'));?></td>
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
				    <td>Account No.<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.account_number',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfo'));?></td>
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
				    <td>Account No.<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.account_number_neft',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_neftArea'));?></td>
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
  <?php }  ?>
          <tr>
	      <td height="35" class="tdLabel2">Remark</td>
	      <td width="200" colspan="2"><?php echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,
	      		'id' => 'remark','cols'=>'20','rows'=>'5','value'=>'Being cash received towards  from pt. '.$patient['Patient']['lookup_name'].' against R. No.:'));
	      //echo $this->Form->input('Billing.remark', array('value'=>'','class' => ' textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'id' => 'remark'));  ?></td>
      	</tr>                          
        </tbody>
     	</table>
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
                               
     </tr>
     <?php //if($isDischarge!=1){?>
     <tr>
        <td valign="top" style="padding-top: 15px; float:left;" > 
	 		 <input class="blueBtn" type="button" value="Save" id="payAmount">
	 		 <?php  if($configInstance['instance']=='vadodara') // the button is visible only for vadodara instance -- Pooja
	 		 echo $this->Html->link(__('Patient Card'),array('controller'=>'Accounting','action'=>'patient_card',$patientID),array('escape'=>false,'class'=>'blueBtn'));?>
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
 <?php echo $this->Form->end(); ?>        
</div> 
<!-- /****EOF payment details****/ -->
<?php //}?>
</div>

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


        if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
	 		 $("#paymentInfo").show();
	 		 $("#creditDaysInfo").hide();
	 		 $('#neft-area').hide();
	 		 $('#bankDeposite').hide();
	 	} else if($("#mode_of_payment").val() == 'Credit') {
	 	 	$("#creditDaysInfo").show();
	 	 	$("#paymentInfo").hide();
	 	 	$('#neft-area').hide();
	 	 	$('#bankDeposite').hide();
	 	} else if($('#mode_of_payment').val()=='NEFT') {
	 	    $("#creditDaysInfo").hide();
	 		$("#paymentInfo").hide();
	 		$('#neft-area').show();
	 		$('#bankDeposite').hide();
	 	}else if($('#mode_of_payment').val()=='Bank Deposit') {
	 	    $("#creditDaysInfo").hide();
	 		$("#paymentInfo").hide();
	 		$('#neft-area').hide();
	 		$('#bankDeposite').show();
	 	}
   	
      $("#mode_of_payment").change(function(){

          $('#chequeCredit').html($(this).val()+' No.');
          
			if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
				 $("#paymentInfo").show();
				 $("#creditDaysInfo").hide();
				 $('#neft-area').hide();
				 $('#bankDeposite').hide();
			} else if($("#mode_of_payment").val() == 'Credit') {
			 	$("#creditDaysInfo").show();
			 	$("#paymentInfo").hide();
			 	$('#neft-area').hide();
			 	$('#bankDeposite').hide();
			} else if($('#mode_of_payment').val()=='NEFT') {
			    $("#creditDaysInfo").hide();
				$("#paymentInfo").hide();
				$('#neft-area').show();
				$('#bankDeposite').hide();
			}else if($('#mode_of_payment').val()=='Bank Deposit') {
			    $("#creditDaysInfo").hide();
				$("#paymentInfo").hide();
				$('#neft-area').hide();
				$('#bankDeposite').show();
			}else{
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
  		
        is_refund_approved = parseInt($("#is_refund_approved").val());
        is_approved = parseInt($("#is_approved").val());

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
		
		formData = $('#paymentDetail , .serviceAmountToPay, .labAmountToPay, .radAmountToPay').serialize();
		
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
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='ward_radio'){
						  getWardData(patient_id,groupID);
					  }else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='privatepackage_radio'){
						  getPackageData(packagedPatientId);
					  }else{ //else if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')=='1'){
						  //groupID=$('#serviceGroupId').val();
						  if($("input[type='radio'][name='serviceGroupData']:checked").attr('radioName')== 'mandatoryservices_radio'){
							   //$('#amount').attr('readonly',true);
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
			minDate:new Date(<?php echo $this->General->minDate($wardInDate) ?>),
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
  		formData = $('#servicefrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id,
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
    	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxServiceData","admin" => false)); ?>"+'/'+patient_id+'?groupID='+groupID+'&isMandatory='+isMandatory;
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
         		discountApproval();
         		RefundApproval();
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
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxConsultationData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId;
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
    			 discountApproval();
    			 RefundApproval();
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
  		formData = $('#labServices').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "addLab", "admin" => false)); ?>"+'/'+patient_id,
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
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxLabData","admin" => false)); ?>"+'/'+patient_id;
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
	        			 discountApproval();
	        			 RefundApproval();
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
					$('#labAomunt_'+ID).val(ui.item.charges);
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
				addMoreLabHtml()
			}	
	 });

	 function addMoreLabHtml(){
		$("#labOrderArea")
			.append($('<tr>').attr({'id':'orderRowNew_'+counter,'class':'labAddMoreRows'})
				.append($('<td id=billableLab_'+counter+'>').append($('<input>').attr({'id':'isBillable_'+counter,'class':'textBoxExpnd','type':'checkbox','name':'LaboratoryTestOrder[is_billable][]','value' : '1'})))
				.append($('<td>').append($('<input>').attr({'readonly':'readonly','id':'labDate_'+counter,'class':'textBoxExpnd labDate','type':'text','name':'LaboratoryTestOrder[start_date][]','value':'<?php echo $todayLabDate;?>'})))
				.append($('<td>').append($('<input>').attr({'id':'test_name_'+counter,'placeholder':'Lab Search','class':'validate[required,custom[mandatory-enter]] textBoxExpnd AutoComplete test_name','type':'text','name':'LaboratoryTestOrder[lab_name][]'}))
						.append($('<input>').attr({'id':'labid_'+counter,'class':'textBoxExpnd labid','type':'hidden','name':'LaboratoryTestOrder[laboratory_id][]'}))
						//.append($('<span>').attr({'class':'orderText','id':'orderText_'+counter,'style':'float:right; cursor: pointer;','title':'Order Detail'}).append($('<strong>...</strong>')))
						)
	    		.append($('<td>').append($('<select>').attr({'id':'service_provider_id_'+counter,'class':'textBoxExpnd externalRequisition','type':'select','name':'LaboratoryTestOrder[service_provider_id][]'}).append($('<option value="">').text('None'))))
	    		.append($('<td>').append($('<input>').attr({'style':'text-align:right','id':'labAomunt_'+counter,'class':'textBoxExpnd ','type':'text','name':'LaboratoryTestOrder[amount][]'})))
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
  				//minDate:new Date(),
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
		 $("#RadiologyArea")
			.append($('<tr>').attr({'id':'radiologyRow_'+counRad,'class':'radAddMoreRows'})
				.append($('<td id=billableRad_'+counter+'>').append($('<input>').attr({'id':'isBillable_'+counter,'class':'textBoxExpnd','type':'checkbox','name':'data[RadiologyTestOrder][is_billable][]','value' : '1'})))
				.append($('<td>').append($('<input>').attr({'readonly':'readonly','id':'radDate_'+counter,'class':'textBoxExpnd radDate','type':'text','name':'data[RadiologyTestOrder][radiology_order_date][]','value':'<?php echo $todayRadDate;?>'})))
				.append($('<td>').append($('<input>').attr({'id':'radiologyname_'+counRad,'class':'validate[required,custom[mandatory-enter]] radiology_name textBoxExpnd','type':'text','name':'data[RadiologyTestOrder][rad_name][]'}))
						.append($('<input>').attr({'id':'radiologytest_'+counRad,'class':'textBoxExpnd radiology_test','type':'hidden','name':'data[RadiologyTestOrder][radiology_id][]'}))
						//.append($('<span>').attr({'class':'radOrderText','id':'radOrderText_'+counRad,'style':'float:right; cursor: pointer;','title':'Radiology Order Detail'}).append($('<strong>...</strong>')))
						)
	    		.append($('<td>').append($('<select>').attr({'id':'service_provider_id'+counRad,'class':'textBoxExpnd ','type':'select','name':'data[RadiologyTestOrder][service_provider_id][]'}).append($('<option value="">').text('None'))))
	    		.append($('<td>').append($('<input>').attr({'style':'text-align:right','id':'radAomunt_'+counRad,'class':'textBoxExpnd radAomunt','type':'text','name':'data[RadiologyTestOrder][amount][]'})))
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
	  				//minDate:new Date(),
	  				maxDate:new Date(),
	  				onSelect:function(){$(this).focus();
	  				}
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
						$('#radiologytest_'+ID).val(ui.item.id);
						$('#radAomunt_'+ID).val(ui.item.charges);
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
	  		formData = $('#radServices').serialize();
	  			$.ajax({
	  				  type : "POST",
	  				  data: formData,
	  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "addRad", "admin" => false)); ?>"+'/'+patient_id,
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
			  
		   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxRadData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId ;
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
		        			 discountApproval();
		        			 RefundApproval();
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
			  
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxPharmacyData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId ;
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
	        			 discountApproval();
	        			 RefundApproval();
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }
	//EOF pharmacy
	
	
	//BOF blood
	 function getBloodData(patient_id,groupID){
		  
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxBloodData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID ;
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
        			 discountApproval();
        			 RefundApproval();
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


	//fnction to check discount approval
	function discountApproval(){

		resetDiscountRefund();			//reset all (Discount/Refund)
		patientId = '<?php echo $patientID; ?>';
    	payment_category = $("#payment_category").val();
    	clearInterval(refund_interval); 		//clear refund intervals if any
		clearInterval(interval); 		//clear discount intervals if any

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
				  //console.log(parseData);
				  
			 if(parseData != null) {
				 $("#discount").show();
				  is_approved = parseInt(parseData.is_approved);
				  request_to = parseInt(parseData.request_to);
				  is_type = parseData.type;
				  $('input:radio[class=discountType][value="' + is_type + '"]').prop('checked',true); 	//checked radio Amount/Percentage
				  discount_amount = parseInt(parseData.discount_amount);								//discount_amount
				  discount_percentage = parseInt(parseData.discount_percentage);						//discount_percentage					

				  var discount = '';
				  if(discount_amount != ''){
					  discount = discount_amount;
					  $("#show_percentage").hide();	
				  }else if(discount_percentage != ''){
					  discount = discount_percentage;
					  $("#show_percentage").show();	
				  }
				  //alert(discount);
				  
				if(parseInt(is_approved) == 0)
				{
					$("#mesage").show();
					$("#status-approved-message").html("apporval Request for discount has been sent, please wait for approval");
					$("#is_approved").val(1);	//for approval waiting
					$("#image-gif").show();
					$("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
  					  $(".discountType").prop("disabled",true);
					  $("#discount").attr('readonly',true);
					  $("#discount_authorize_by").show();		//show Approval users
					  $("#discount_authorize_by").val(request_to);
					  $("#discount_authorize_by").attr('disabled',true);
					  $("#cancel-approval").show();			//show cancel button to remove approval
					//set interval for clicked service group 
					interval = setInterval("Notifications()", 5000);  // this will call Notifications() function in each 5000ms
				  }
				else if(is_approved == 1)
				{	
					  $("#mesage").show();
					  $("#status-approved-message").html('<font color="green">Request for discount has been completed</font>');
					  $("#is_approved").val(2);	
					  $("#image-gif").hide();
					  $(".discountType").prop("disabled",true);
					  $("#discount").attr('readonly',true);					  
				  }
				else if(is_approved == 2)
				{
					resetDiscountRefund();
					$("#mesage").show();
					$("#status-approved-message").html('<font color="red">Request for discount has been rejected</font>');
					$("#image-gif").hide();
					$("#is_approved").val(3);	// for approval reject
			 	} 		
			 	
				$("#discount").val(discount);
				display();	//calculate balance			  
			  }
			} 	//end of success
		}); 	//end of ajax
	}


	function RefundApproval(){
		resetRefund();			//reset all Refund)
		patientId = '<?php echo $patientID; ?>';
    	payment_category = $("#payment_category").val();
		clearInterval(refund_interval); 		//clear refund intervals if any
		clearInterval(interval); 		//clear discount intervals if any

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
				  //console.log(parseData);
				  
			 if(parseData != null) {
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
					refund_interval = setInterval("NotificationsForRefund()", 5000);  // this will call Notifications() function in each 5000ms
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
			 	
				//$("#discount").val(discount);
				display();	//calculate balance			  
			  }
			} 	//end of success
		}); 	//end of ajax
	}

	
 
	 function getbillreceipt(patient_id){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxBillReceipt","admin" => false)); ?>"+'/'+patient_id;
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

	     
	 $(".singleBillPayment").click(function(){ 
	 	 if($(this).attr('id')=='payAllTotal'){
			var totalPaymentFlag='payOnlyAmount';
		 }else{
			 var totalPaymentFlag='';
		 }	 
		 totalCharge=$("#totalCharge").val();
		 totalPaid=$("#totalPaid").val();
		 patientID='<?php echo $patientID;?>';
		 appoinmentID='<?php echo $appoinmentID;?>';
		 $.fancybox({ 
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
		 });
		 $(document).scrollTop(0);
	 });

	 function getDailyRoomData(patient_id,tariffStandardId){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxDailyroomData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId;
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
	        			 discountApproval();
	        			 RefundApproval();
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }

	 function getProcedureData(patient_id,tariffStandardId){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxProcedureData","admin" => false)); ?>"+'/'+patient_id+'/'+tariffStandardId;
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
	        			 discountApproval();
	        			 RefundApproval();
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

     
	 $("#amount").keyup(function(){
	 	display();	//manupulate all values and calculate the balance
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
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID,
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
				if(charges !== undefined && charges !== null){
					$('#amountConsultant_'+ID).val(charges.trim());
					//$('#amount'+ID).html(charges.trim());
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
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID,
				 minLength: 1,
				 select: function( event, ui ) {					 
					$('#onlyBloodId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					if(charges !== undefined && charges !== null){
						$('#bloodAmount_'+ID).val(charges.trim());
						$('#bloodTotalAmount_'+ID).html(charges.trim());
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
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+/*"/"+subGroupID+*/'?tariff_standard_id='+tariffStandardID,
				 minLength: 1,
				 select: function( event, ui ) {					 
					$('#onlyImplantId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					var charges=ui.item.charges;
					if(charges !== undefined && charges !== null){
						$('#implantAmount_'+ID).val(charges.trim());
						$('#implantTotalAmount_'+ID).html(charges.trim());
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
					if(charges !== undefined && charges !== null){
						$('#wardAmount_'+ID).val(charges.trim());
						$('#wardTotalAmount_'+ID).html(charges.trim());
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
		 }
	 });

	 $(document).on('focusout','.radiology_name', function() {
		 currentID=$(this).attr('id');
		 splitedVar=currentID.split('_');
		 ID=splitedVar[1];  
		 if($(this).val()==''){
			 $('#radiologytest_'+ID).val('');
			 $('#radAomunt_'+ID).val('');
		 }
	 });
	
	//BOF Implant section
	 function getImplantData(patient_id,groupID){
		  
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxImplantData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID ;
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
        		discountApproval();
        		RefundApproval();
         	}
         },
 		});
	 }
	//EOF Implant section
	
	//BOF ward section
	 function getWardData(patient_id,groupID,ward){

	 
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "dummyAjaxWardProcedureData","admin" => false)); ?>"+'/'+patient_id+'/'+groupID+'?isWard='+ward ;
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
        		discountApproval();
        		RefundApproval();
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
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="wardAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd wardAmount" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
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
	
	//EOF implant data
	
		
	// add more for implant data
	function addImplantService()
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
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="implantAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd implantAmount" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
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
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="bloodAmount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd bloodAmount" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
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
//EOF enter event by pankaj


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
		 field +='<td align="center" width="100"><input type="text" fieldno="'+number_of_field+'" style="width:95px; text-align:right;"  id="service_amount_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd service_amount" name="data[ServiceBill]['+number_of_field+'][amount]"></td>';
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
	
	
	// BOF Add more consultant visits
	
	function addConsultantVisitElement()
	{
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
		 field +=' <td valign="middle" width=""><input type="text" fieldno="'+number_of_field+'" readonly="readonly" style="width:135px;" class="validate[required,custom[mandatory-date]] textBoxExpnd ConsultantDate" id="ConsultantDate_'+number_of_field+'" name="data[ConsultantBilling][date]['+number_of_field+']" value="'+tadayDate+'"> </td>';
		 field +=' <td valign="middle"><input type="checkbox" fieldno="'+number_of_field+'" class="notToPayDr" id="notToPayDr_'+number_of_field+'" name="data[ConsultantBilling][not_to_pay_dr]['+number_of_field+']" value="1"> </td>';
		 field +=' <td valign="middle"> <select fieldno="'+number_of_field+'" style="width:152px;" id="category_id_'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd category_id" name="data[ConsultantBilling][category_id]['+number_of_field+']" onchange="categoryChange(this)"> <option value="">Please select</option> <option value="0">External Consultant</option> <option value="1">Treating Consultant</option> </select> </td>';
		 field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" style="width:152px;" id="doctor_id_'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd doctor_id" 	name="data[ConsultantBilling][doctor_id]['+number_of_field+']" onchange="doctor_id(this)"> <option value="">Please Select</option> <option value="0"></option> </select> </td>';
		 //field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" class="textBoxExpnd service_category_id" style="width:167px;" id="service-group-id'+number_of_field+'" 	  name="data[ConsultantBilling][service_category_id][]" onchange="getListOfSubGroup(this);"> </select></td>';
		 field +='<td align="center" width=""><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="consultant_service_id_'+number_of_field+'" class="validate[required,custom[mandatory-enter]] textBoxExpnd consultant_service_id" name="data[ConsultantBilling][consultant_service_name]['+number_of_field+']" div="false" label="false"> <input type="hidden" fieldno="'+number_of_field+'"  id="onlyConsultantServiceId_'+number_of_field+'" class="onlyConsultantServiceId" name="data[ConsultantBilling][consultant_service_id]['+number_of_field+']" ></td>';
		 //field +=' <td valign="middle" style="text-align: left;"><select fieldno="'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd consultant_service_id" style="width:150px;" name="data[ConsultantBilling][consultant_service_id][]" id="consultant_service_id'+number_of_field+'"   onchange="consultant_service_id(this)"><option value="">Please Select</option></select></td>';
		 //field +=' <td valign="middle" style="text-align: center;"><select fieldno="'+number_of_field+'" style="width:130px;" id="hospital_cost'+number_of_field+'" class="validate[required,custom[mandatory-select]] textBoxExpnd hospital_cost" name="data[ConsultantBilling][hospital_cost][]" ><option value="">Please Select</option><option value="private">Private</option><option value="cghs">CGHS</option><option value="other">Other</option></select></td>';
		 field +='<td valign="middle" style="text-align: right;"><input type="text" fieldno="'+number_of_field+'" style="width:80px; text-align:right;" id="amountConsultant_'+number_of_field+'" class="validate[required,custom[onlyNumber]] textBoxExpnd amount" name="data[ConsultantBilling][amount]['+number_of_field+']"></td>';
		 field +='<td valign="middle" style="text-align: center;"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="description_'+number_of_field+'" class="textBoxExpnd description" name="data[ConsultantBilling][description]['+number_of_field+']"></td>';
		 field +='<td valign="middle" style="text-align: center;"><input type="text" fieldno="'+number_of_field+'" style="width:150px;" id="payToConsultant_'+number_of_field+'" class="textBoxExpnd pay_to_consultant" name="data[ConsultantBilling][pay_to_consultant]['+number_of_field+']"></td>';
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
	
	$(".discountType").change(function(){
		var type = $(this).val();
		$("#discount").show();
		$("#discount").val('');
		if(type == "Percentage"){
			$("#show_percentage").show();	
		}else{
			$("#show_percentage").hide();	
		}
		display();
		
		if(parseInt($("#totalamount").val()) >= 10000)	//if total amount is greater or equal to 10000 then it is possible to give approval for discount or refund
		{
			$("#discount_authorize_by").show();
			$("#send-approval").show();
		}
	});



	 $("#is_refund").click(function(){
	    if($('#is_refund').is(':checked')){
	        $("#refund_amount").show();
	        /*if(parseInt($("#totalamount").val()) >= 10000)	
			{
		        $("#discount_authorize_by_for_refund").show();
		        $("#send-approval-for-refund").show();
			}*/
		}else{
			$("#refund_amount").hide();
			/*$("#discount_authorize_by_for_refund").hide();
			$("#send-approval-for-refund").hide();
			$("#refund_amount").val(0);*/
		}
		display();
	 });	 

	$("#discount").keyup(function(){  
		display();
	});

	var balanCe = parseInt($("#totalamountpending").val());	//hold the balance
	$("#refund_amount").keyup(function(){
		refund = ($(this).val()!='')?$(this).val() : 0;
		if(refund >= 10000){	// if refund amount >=10,000, request for approval by Swapnil G.Sharma
			$("#discount_authorize_by_for_refund").show();
		    $("#send-approval-for-refund").show();
		    $("#is_refund_approved").val(1);
		}else{
			$("#discount_authorize_by_for_refund").hide();
			$("#send-approval-for-refund").hide();
			$("#is_refund_approved").val(0);
		}
		mRefund = ($("#maintainRefund").val()!='')?$("#maintainRefund").val():0;
		mDiscount = ($("#maintainDiscount").val()!='')?$("#maintainDiscount").val():0;
		var adV = parseInt($("#totaladvancepaid").val());
		var discount = parseInt(($("#discount").val()!='')?$("#discount").val():0);
		var amountPaid = parseInt(($("#amount").val()!='')?$("#amount").val():0);
		var total = parseInt($("#totalamount").val()) - adV -amountPaid-discount-parseInt(mDiscount)+ parseInt(refund) +parseInt(mRefund);
		$("#totalamountpending").val(total);
	});

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
		$(".discountType").each(function () {  
	        if ($(this).prop('checked')) {
	           var type = this.value;
	           if(type == "Amount")
	            {    
	            	disc = ($("#discount").val() != '') ? parseInt($("#discount").val()) : 0;
	            }else if(type == "Percentage")
	            {
	            	var discount_value = ($("#discount").val()!= '') ? parseInt($("#discount").val()) : 0;
					if(discount_value < 101){
	       		    	disc = parseInt(Math.ceil((total_amount*discount_value)/100));
					}else{
						alert("Percentage should be less than or equal to 100");
					}
	            }
	           $("#disc").val(disc);	
	        }
	    });
		mRefund = ($("#maintainRefund").val()!='')?$("#maintainRefund").val():0;
		mDiscount = ($("#maintainDiscount").val()!='')?$("#maintainDiscount").val():0;
		balance = ($('#totalamountpending').val() != '') ? parseInt($("#totalamountpending").val()) : 0;
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
			payment_category = $("#payment_category").val();

			$.ajax({
				  type : "POST",
				  data: "patient_id="+patientId+"&type="+type+"&discount="+discount+"&total_amount="+totalamount+"&request_to="+user+"&payment_category="+payment_category,
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
						 interval = setInterval("Notifications()", 5000);  // this will call Notifications() function in each 5000ms
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
    	payment_category = $("#payment_category").val();
    	
        $.ajax({
        	type : "POST",
			  data: "patient_id="+patientId+"&type="+type+"&request_to="+user+"&payment_category="+payment_category,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "Resultofrequest","admin" => false)); ?>",
			  context: document.body,	
			  success: function(data){ 
				 //$("#busy-indicator").hide(); 
				 $("#mesage").show();
				if(parseInt(data) == 0)
				{
					$("#status-approved-message").html("Request for discount has been sent, please wait for approval");
					$("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>');
					$("#is_approved").val(1);
				}else
				if(data == 1)		//approved
				{
					$("#status-approved-message").html('<font color="green">Request for discount has been completed</font>');
					$("#image-gif").hide();
					$("#discount").prop("readonly", true);
					$(".discountType").prop("disabled",true);
					$("#is_approved").val(2);  //for approval complete
					clearInterval(interval); // stop the interval
					$("#discount_authorize_by").hide();		//hide Approval users
					$("#cancel-approval").hide();			//hide cancel button
					
				}
				else
				if(data == 2)		// if rejected by users
				{
					$("#status-approved-message").html('<font color="red">Request for discount has been rejected</font>');
					$("#image-gif").hide();
					$("#is_approved").val(3);	// for approval reject

					clearInterval(interval); 	// stop the interval

					$("#is_approved").val(0);  	// for again sending approval
					$('input:radio').removeAttr('checked');		                  
					$("#discount").val('');		// unset discount value
					$("#discount").attr('disabled',true);	// set disabled
					//$("#totalamountpending").val(pendingAmt);	// unset the balance
					$("#discount_authorize_by").hide();	
					$("#send-approval").hide();			
					$("#cancel-approval").hide();		
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
		$("#send-approval").hide();
		$("#cancel-approval").hide();
		$("#discount").prop("readonly", false);
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
		$("#refund_amount").hide();
		$("#discount_authorize_by_for_refund").attr('disabled',false);
		$("#discount_authorize_by_for_refund").hide();
		$("#send-approval-for-refund").hide();
		$("#cancel-refund-approval").hide();
		$("#mesage2").hide();
	}
		
		
	
	//for cancelling the unapproved approval of discount only
	 $("#cancel-approval").click(function(){

		var result = confirm("Are you sure to cancel the request for discount..??");
		 if(result == true)
			patientId = '<?php echo $patientID; ?>';
			discount = $("#discount").val();
			user = $("#discount_authorize_by").val();
			payment_category = $("#payment_category").val();
			
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
				  success: function(data){ 
					$("#busy-indicator").hide(); 
					
					clearInterval(interval); 					// stop the interval
					resetDiscountRefund();
					display();
				  }
			});
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
					payment_category = $("#payment_category").val();
					total_amount = $("#totalamount").val();
			
					$.ajax({
						  type : "POST",
						  data: "patient_id="+patientId+"&type=Refund&refund_amount="+refundAmount+"&total_amount="+total_amount+"&request_to="+user+"&payment_category="+payment_category,
						  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "requestForApproval","admin" => false)); ?>",
						  context: document.body,
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
								 refund_interval = setInterval("NotificationsForRefund()", 5000);  // this will call Notifications() function in each 5000ms
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
		var result = confirm("Are you sure to cancel the request for discount..??");
		if(result == true)
			patientId = '<?php echo $patientID; ?>';
			refund_amount = $("#refund_amount").val();
			user = $("#discount_authorize_by_for_refund").val();
			payment_category = $("#payment_category").val();
			type = "Refund";
			
			$.ajax({
				  type : "POST",
				  data: "patient_id="+patientId+"&request_to="+user+"&type="+type+"&payment_category="+payment_category,
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "cancelApproval","admin" => false)); ?>",
				  context: document.body,
				  beforeSend:function(){
					  $("#busy-indicator").show();
				  },	
				  success: function(data){ 
					$("#busy-indicator").hide(); 
					$("#is_refund_approved").val(0);
					clearInterval(refund_interval); 					// stop the interval
					resetRefund();
					display();
				  }
			});
	 });

	 function NotificationsForRefund()
		{
			type = "Refund" ;  
			patientId = '<?php echo $patientID; ?>';
	    	user = $("#discount_authorize_by_for_refund").val();
	    	payment_category = $("#payment_category").val();
	    	
	        $.ajax({
	        	type : "POST",
				  data: "patient_id="+patientId+"&type="+type+"&request_to="+user+"&payment_category="+payment_category,
				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "Resultofrequest","admin" => false)); ?>",
				  context: document.body,	
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
  		formData = $('#bloodServiceFrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id+'/'+groupID,
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
  		formData = $('#implantServiceFrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id+'/'+groupID,
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
  		formData = $('#wardProcedureFrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id+'/'+groupID,
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
	
    
        
	
</script>