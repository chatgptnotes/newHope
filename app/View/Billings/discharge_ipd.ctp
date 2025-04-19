<style>
label{
padding-top:0;
text-align:left;
width:100%;
}</style>
<?php   echo $this->Html->script(array('jquery.fancybox-1.3.4'));  
		echo $this->Html->script(array('permission','jquery.ui.timepicker','jquery.blockUI'));
		echo $this->Html->css(array('jquery.fancybox-1.3.4')) ;
		
		$splitDate = explode(' ',$patient['Patient']['form_received_on']);?>
<script>
var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
var explode = admissionDate.split('-');

$(document).ready(function(){ 
	patient_ID='<?php echo $patientID; ?>';
	//getServiceData(patient_ID);
	getbillreceipt(patient_ID);
	addCalenderOnDynamicField(); //default calender field


	$("input[type='radio'][name='serviceGroupData'][value='mandatoryServices']").attr('checked',true);
	   $('#payment_category').val('mandatoryServices');
	   $('#serviceGroupId').val('mandatoryServices');
		   $('#mandatoryServicesSection').show();
		   $('#ajaxMandatoryServiceData').show();
		   $('#servicesSection').hide();
		   $('#ajaxSeviceData').hide();
		   $('#ajaxLabData').hide();
		   $('#ajaxConsultaionData').hide();
		   $('#ajaxRadData').hide();
		   $('#ajaxDailyroomData').hide();
		   $('#ajaxProcedureData').hide();
		   getMandatoryServiceData('<?php echo $patientID;?>');

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
			 	ID=currentID.slice(-1); 
			 	var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
				$("#service_id"+ID).autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+"/"+subGroupID,
					 minLength: 1,
					 select: function( event, ui ) {					 
						$('#onlyServiceId_'+ID).val(ui.item.id);
						var id = ui.item.id; 
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
	$(".ConsultantDate, .ServiceDate").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',				 
		dateFormat:'dd/mm/yy HH:II:SS',
		//minDate : new Date(explode[0],explode[1] - 1,explode[2]),
		
	}); 

	$('.nofTime').on('keyup',function(){
    	currentID = $(this).attr('id') ; 
    	ID = currentID.slice(-1); 
    	
		serviceAmt=$('#service_amount'+ID).val(); 
    	valtimes = $(this).val(); 
    	if(isNaN(valtimes)==false){ 
			if(serviceAmt !=''){
		    	totalAmt=serviceAmt*valtimes;
		    	$('#amount_'+ID).html(totalAmt);
			}else{
				alert('Please enter Unit price.');
				$('#service_amount'+ID).val(''); 
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
      	ID = currentID.slice(-1); 
      	
  		noOfTime=$('#no_of_times'+ID).val(); 
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
/*
 function checkApplyInADay(tarrifListID,standardId,tmp,apply_in_a_day){
	var count = 0;
	 if($.trim(apply_in_a_day)!="" && parseInt(apply_in_a_day)>0){
	  	if(parseInt(apply_in_a_day)>3)
	  		apply_in_a_day =3;
	  	var arr = new Array("morning"+tmp,"evening"+tmp,"night"+tmp);
		if($("#morning"+tmp).attr("checked")==true)
			count = count+1;
		if($("#evening"+tmp).attr("checked")==true)
			count = count+1;
		if($("#night"+tmp).attr("checked")==true)
			count = count+1;		
  		if(parseInt(apply_in_a_day) == count){
  			if($("#morning"+tmp).attr("checked")!=true)
  				$("#morning"+tmp).attr("disabled","disabled")
  			if($("#evening"+tmp).attr("checked")!=true)
  				$("#evening"+tmp).attr("disabled","disabled")
  			if($("#night"+tmp).attr("checked")!=true)
  				$("#night"+tmp).attr("disabled","disabled")
 		}else if(count < parseInt(apply_in_a_day)){
			if($("#morning"+tmp).attr("checked")!=true)
  				$("#morning"+tmp).removeAttr("disabled", "disabled");
  			if($("#evening"+tmp).attr("checked")!=true)
  				$("#evening"+tmp).removeAttr("disabled", "disabled");
  			if($("#night"+tmp).attr("checked")!=true)
  				$("#night"+tmp).removeAttr("disabled", "disabled");
		}			
   }
 }

 function defaultNoOfTimes(id,tariffListId){
		currentCount = Number($('#noOfTimes' + tariffListId).val()) ;		
		if($('#' + id).is(":checked")){			
			$('#noOfTimes' + tariffListId).val(currentCount+1);
		}else{
			if(currentCount > 0) 
				$('#noOfTimes' + tariffListId).val(currentCount-1);
			else
				$('#noOfTimes' + tariffListId).val('');
		}
	 }	*/
</script>


<div class="inner_title">
	<h3>&nbsp; <?php echo __('Billing', true); ?></h3>
</div>
<?php 
echo $this->Form->hidden('totalCharge',array('id'=>'totalCharge'));
echo $this->Form->hidden('totalPaid',array('id'=>'totalPaid'));
?>
<div>&nbsp;</div>
<div class=""><?php //echo $this->element('print_patient_info');?>
<table width="50%" cellpadding="0" cellspacing="0" border="0" class="tbl" style="border:1px solid #3e474a;">
	<tr>
		<td width="50%" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="5" >
			<tr>
				<td width="38%" height="25" valign="top">Name :</td>
				<td align="left" valign="top"> <?php echo $complete_name  =  $patient['Patient']['lookup_name'] ; ?> </td>
	     	</tr>
	    	<tr>
           		 <td valign="top"  id="boxSpace4" >Sex / Age :</td>
          		 <td align="left" valign="top" style="padding-bottom:10px;"><?php echo ucfirst($sex);?> / <?php echo ucfirst($age)?></td>
        	</tr>
        	<tr>
           		 <td valign="top"  id="boxSpace4" >Tariff :</td>
          		 <td align="left" valign="top" style="padding-bottom:10px;"><?php echo $tariffData[$patient['Patient']['tariff_standard_id']] ;?></td>
        	</tr>
		</table> 
	  	</td>
                           
     	<td width="50%" valign="top">
	  		<table width="100%" border="0" cellspacing="0" cellpadding="5" >
	   			<tr>
	            	<td width="110" height="25" valign="top"  id="boxSpace3" align="right">Registration ID :</td>
	             	<td align="left" valign="top"><?php echo $patient['Patient']['admission_id'] ;?></td>
            	</tr>
            	<tr>
                	<td valign="top"  id="boxSpace3" align="right">Patient ID :</td>
                	<td align="left" valign="top" style="padding-bottom:10px;"><?php echo $patient['Patient']['patient_id'] ;?> </td>
            	</tr>
	    	</table>
	  	 </td>
	   
    </tr>
</table>

</div>
<div>&nbsp;</div>
<div id="ajaxBillReceipt"></div>

<div id="new_item">
<table style="margin-bottom: 30px;" width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<!-- <td width="18%">Claim No. 	Insurance company not selected</td>
		<td width="15%"><?php echo $this->Form->input('', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false)); ?></td>
		 -->
		<td width="5%"><?php 
			echo $this->Html->link('Invoice','javascript:void(0)',
				array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printReceipt',
				$patientID))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?></td>
		<td width="10%"><a href="javascript:void(0);" class="blueBtn" id="singleBillPayment">Single Bill Payment</a></td>
		<?php if($patient['Patient']['admission_type']=='IPD'){ ?>
		<td width="10%"><?php echo $this->Html->link('Revoke Discharge',array('controller'=>'billings','action'=>'revokeDischarge',$patientID),array('class'=> 'blueBtn','id'=>'revoke','escape' => false,'label'=>false,'div'=>false));?></td>
		<?php }?>
		<td ><?php echo $this->Html->link('Detailed Invoice','javascript:void(0)',
				array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'billings','action'=>'detail_payment',$patientID
				))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1050,height=670,left=150,top=100'); return false;"));
		?></td>
	</tr>
</table>
</div>
 
<!-- date section start here -->
		<?php
		//if($patient['Patient']['admission_type']!='OPD' && $patient['Patient']['is_discharge']!=1){
		//if($patient['Patient']['is_discharge']!=1){ ?>
<table width="100%" align="right" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td > 
			 <input type="radio" value="mandatoryServices" id="mService" name="serviceGroupData" autocomplete="off" />Mandatory Services
	     	
		<?php  foreach($service_group as $key =>$value){  
					$serviceGroupData[$value['ServiceCategory']['id']]=$value['ServiceCategory']['name']; 
				}  
		 		 echo $this->Form->input('', array('id' =>'add-service-group-id1',
				'name'=>'serviceGroupData','options' => $serviceGroupData,'legend' =>false,'label' => false,
				'div'=>false,'class'=>'serviceGroupData add-service-group-id','type' => 'radio','separator'=>' '));?>
        </td>
        <!-- 
		<td width="85">
	      <label>
	         <input type="radio" name="billtype" value="Services" id="servicesSectionBtn" checked="checked" autocomplete="off" />
	         Services
	     </label>
        </td>
		
		<td width="171">
	      <label>
	         <input type="radio" name="billtype" value="Consultant"  id="consultantSectionBtn" autocomplete="off" />
			Consultation for IPD
	     </label>
        </td>
		<!--  
		<td width="95">
	      <label>
	         <input type="radio" name="billtype" id="pharmacy-sectionBtn" value="Pharmacy" autocomplete="off" />
	         Pharmacy
	     </label>
        </td>
		 
		<td width="95">
	      <label>
	         <input type="radio" name="billtype" id="pathologySectionBtn" value="Pathology" autocomplete="off" />
	         Laboratory
	     </label>
        </td>
        
		<td width="100">
	      <label>
	         <input type="radio" name="billtype" id="radiologySectionBtn" value="Radiology" autocomplete="off" />
	        Radiology
	     </label>
        </td>
		
		<td width="130">
	      <label>
	         <input type="radio" name="billtype" id="DailySectionBtn" value="Daily" autocomplete="off" />
	     	 Room And Daily
	     </label>
        </td>
		
		<td width="100">
	      <label>
	         <input type="radio" name="billtype" id="ProcedureSectionBtn" value="Procedure" autocomplete="off" />
	     	 Procedure
	     </label>
        </td>
      <!--  
	 	<td width="79">
	      <label>
	         <input type="radio" name="billtype" id="implant-sectionBtn" value="Implant" autocomplete="off" />
	     	Implant
	     </label>
        </td>
		
		<td width="129">
	      <label>
	         <input type="radio" name="billtype" id="otherServicesSectionBtn" value="Pharmacy" autocomplete="off" />
	     	Other Services
	     </label>
        </td>
		 -->
		<td>&nbsp;</td>
		<td class="tdLabel"><!-- Date --></td>
		<td width="140"><?php //echo date('d/m/Y')?></td>
		<td width="25" align="right"></td>
	</tr>
</table>

<?php //}?>
<!-- 	
<table style="margin-bottom: 30px;margin-top: 20px" width="35%" align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>Bill Date</td>
		<td><?php echo $this->Form->input('', array('label'=>false,'id' => 'group_name','class'=> 'textBoxExpnd','div'=>false)); ?></td>
		<td>Payment Type</td>
		<td><a href="#" class="blueBtn">Cheque</a></td>
		<td><a href="#" class="blueBtn">Credit Card</a></td>
	</tr>
</table>
 -->	 	
				
<!--  pathology section start-->
<?php if($patient['Patient']['is_discharge']!=1){ ?>
<div id="pathologySection" style="display: none; width: 100%">				

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
			<td width="12%">
				<?php echo $this->Form->input('', array('type'=>'text','id' => 'labDate','label'=>false,'div'=>false,
				'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  labDate','style'=>'width:120px;',
				'readonly'=>'readonly','name'=>'LaboratoryTestOrder[start_date][]')); ?>
			</td>
				
			<td ><?php echo $this->Form->input('',array('name'=>'LaboratoryTestOrder[lab_name][]','class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd test_name','escape'=>false,'multiple'=>false,
							'type'=>'text','label'=>false,'div'=>false,'id'=>'test_name_1','autocomplete'=>false,'placeHolder'=>'Lab Search'));
				echo $this->Form->hidden('', array('name'=>'LaboratoryTestOrder[laboratory_id][]','type'=>'text','label'=>false,'id' => 'labid_1','class'=> 'textBoxExpnd labid','div'=>false));
			?><span class="orderText" id="orderText_1" style="float:right; cursor: pointer;" title="Order Detail"><strong>...</strong></span> </td>
		
			<td>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>$serviceProviders,'empty'=>__('None'),'id'=>'service_provider_id_1',
											'label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd','name'=>"data[LaboratoryTestOrder][service_provider_id][]"))?>
			
			<td><?php echo $this->Form->input('', array('name'=>'LaboratoryTestOrder[amount][]','type'=>'text','label'=>false,'id' => 'labAomunt_1','class'=> 'textBoxExpnd specimentype','div'=>false));?></td>
			
			<td><?php echo $this->Form->input('', array('name'=>'LaboratoryTestOrder[description][]','type'=>'text','label'=>false,'id' => 'description_1','class'=> 'textBoxExpnd description','div'=>false));?></td>
		
			<td>&nbsp;</td>
		</tr>
		
		<tr id="orderRow_1">
			<td colspan="6" class="orderArea" id="orderArea_1" style="display:none"></td>
		</tr>
		
	</tbody>
</table>
<div>&nbsp;</div>
		<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
				 <td width="50%"><input name="" type="button" value="Add More Visits" class="blueBtn addMoreLab" /> </td>
				 <td width="50%" align="right">
				 <input class="blueBtn" type="button" value="Save" id="saveLabBill">
				</td>
			</tr>
		</table>
		
<?php echo $this->Form->end();?>
</div>
<?php }?>
<!--  pathology section end-->







<!--  radiology section start-->
<?php if($patient['Patient']['is_discharge']!=1){ ?>
<div id="radiologySection" style="display: none; width: 100%">

 
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
			<th class="table_cell"><strong><?php echo __('Date'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Radiology Test Name'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('External Requisition'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Amount(Rs.)'); ?></strong></th>
			<th class="table_cell"><strong><?php echo __('Description'); ?></strong></th>
			<th class="table_cell" width="50"><strong><?php echo __('Action'); ?></strong></th>
		</tr>
		<tr>
			<td width="12%">
				<?php echo $this->Form->input('', array('type'=>'text','id' => 'radDate','label'=>false,'div'=>false,
				'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  radDate','style'=>'width:120px;',
				'readonly'=>'readonly','name'=>'data[RadiologyTestOrder][radiology_order_date][]')); ?>
			</td>
			
			<td ><?php echo $this->Form->input('', array('id' => 'radiologyname_1','type'=>'text', 'label'=> false, 'div' => false,
					 'error' => false,'autocomplete'=>false,'class'=>'validate[required,custom[mandatory-enter]] radiology_name textBoxExpnd','name'=>'data[RadiologyTestOrder][rad_name][]'));
			echo $this->Form->hidden('', array('type'=>'text','name'=>'data[RadiologyTestOrder][radiology_id][]','id'=>'radiologytest_1','class'=>'radiology_test'));
			?>
			<span class="radOrderText" id="radOrderText_1" style="float:right; cursor: pointer;" title="Radiology Order Detail"><strong>...</strong></span></td>
		
			<td>
			<?php echo $this->Form->input('',array('type'=>'select','options'=>$serviceProviders,'empty'=>__('None'),'id'=>'service_provider_id_1',
											'label'=>false,'div'=>false,'error'=>false,'class'=>'textBoxExpnd','name'=>"data[RadiologyTestOrder][service_provider_id][]"))?>
			
			<td><?php echo $this->Form->input('', array('name'=>'data[RadiologyTestOrder][amount][]','type'=>'text','label'=>false,'id' => 'radAomunt_1','class'=> 'textBoxExpnd radAomunt','div'=>false));?></td>
			
			<td><?php echo $this->Form->input('', array('name'=>'data[RadiologyTestOrder][description][]','type'=>'text','label'=>false,'id' => 'description_1','class'=> 'textBoxExpnd description','div'=>false));?></td>
		
			<td>&nbsp;</td>
		</tr>
		
		
		<tr id="orderRad_1">
			<td colspan="6" class="radOrderArea" id="radOrderArea_1" style="display:none"></td>
		</tr>
		
	</tbody>
</table>
<div>&nbsp;</div>
	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
		<tr>
			 <td width="50%"><input name="" type="button" value="Add More Visits" class="blueBtn addMoreRad" /></td>
			 <td width="50%" align="right"><input class="blueBtn" type="button" value="Save" id="saveRadBill"></td>
		</tr>
	</table>
<?php echo $this->Form->end();?>
</div>
<?php }?>
<!--  radiology section end-->





<!--MRI Section starts here-->
<div id="MriSection" style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">


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
<!--Mri Section Ends here-->






<!--CT Section starts here-->
<div id="CTSection" style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">

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
<!--CT Section Ends here-->








<!--Implant Section starts here-->
<div id="ImplantSection"
	style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">
<table cellspacing="1" width="100%">
	<tr>
		<td align="right"><?php 
		echo $this->Html->link(__('Request Test'),array('controller'=>'laboratories','action' => 'lab_order',$patient['Patient']['id'],'?'=>array('dept'=>'implant','return'=>'invoice')), array('escape' => false,'class'=>'blueBtn'));
		?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<table class="tabularForm" style="position: relative; width: 100%"
	cellspacing="1">
	<tbody>
	<?php if(!empty($implant)){?>
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
		$impCost = 0 ;
		foreach($implant as $radKey=>$implantCost){
			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
			$impCost += $implantCost['TariffAmount'][$hosType] ;
			?>
		<tr>
			<td valign="top"><?php echo $i++ ;?></td>
			<td>&nbsp;&nbsp;<?php echo $implantCost['Radiology']['name'];?></td>
			<td>&nbsp;&nbsp;<?php
			$splitDateIn=  explode(" ",$implantCost['RadiologyTestOrder']['radiology_order_date']);
			echo $this->DateFormat->formatDate2Local($implantCost['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);
			?></td>
			<td align="right" valign="top"><?php echo $implantCost['ServiceProvider']['name'];?></td>
			<td align="right" valign="top"><?php echo $this->Number->currency($implantCost['TariffAmount'][$hosType]);?></td>
			<td align="center" valign="top"><?php 
				if($implantCost['RadiologyResult']['confirm_result'] != 1){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), 
					array('action' => 'deleteTest', $implantCost['RadiologyTestOrder']['id'],$implantCost['RadiologyTestOrder']['patient_id'],"implant"), 
					array('escape' => false),__('Are you sure?', true));
				}?>
			</td>
		</tr>
		<?php
		//}
		}
		if($impCost>0){
			?>
		<tr>
			<td colspan="4" align="right"><!-- <div class="inner_title"><h3>Sub Total</h3><div class="clr"></div><div align="right"><h3><?php echo $this->Number->currency($impCost); ?></h3></div></div>
			Total--></td>
			<td align="right"><?php echo $this->Number->currency($impCost); ?></td>
			<td>&nbsp;</td>
		</tr>
		<?php
		}?>
		<?php }else{?>
		<tr>
			<td align="center" colspan="4">No Record in Radiology for <?php echo $patient['Patient']['lookup_name'];?></td>
		</tr>
		<?php }?>
	</tbody>
</table>
</div>
<!--Implant Section Ends here-->













<!--  pharmacy section start-->
<div id="pharmacy-section"
	style="margin-bottom: 10px; margin-top: 80px; display: none; width: 100%">


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
<!--  pharmacy section end-->










<!-- Other Services Section Starts -->
<div id="otherServicesSection" style="margin-top: 30px; display: none">
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
<!-- Other Services Section Ends -->



<!-- ******** -->

	
	<!-- date section end here -->
		<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'consultantBilling','type' => 'file','id'=>'ConsultantBilling','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
		)
		));
		echo $this->Form->hidden('ConsultantBilling.patient_id',array('value'=>$patientID));
		?>
	
	
	<!-- BOF Consultant Section -->
<table id="consultantSection" width="100%" style="display: none; float:left;">
	<tr>
		<td></td>
	</tr>
	<tr>
		<td>
		<table width="100%"  cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center" id="consulTantGrid">
			<tr>
				<th width="230"><?php echo __('Date');?></th>
				<th width="250"><?php echo __('Type');?></th>
				<th width="250" style=""><?php echo __('Name');?></th>
				<th width="250" style=""><?php echo __('Service Group/Sub Group');?></th>
				<th width="250" style=""><?php echo __('Service');?></th>
				<th width="250" style=""><?php echo __('Hospital Cost');?></th>
				<th width="80"><?php echo __('Amount');?></th>
				<th width="80"><?php echo __('Description');?></th>
				<th width="80"><?php echo __('Action');?></th>
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
				
			<tr id="row1">
				<td valign="top" width="260">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php echo $this->Form->input('', array('type'=>'text','id' => 'ConsultantDate1','class' => 'validate[required,custom[mandatory-date]] textBoxExpnd ConsultantDate',
					'style'=>'width:117px;','readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ConsultantBilling][date][]')); ?>
				</td>
			
				<td valign="top">
					<?php echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd category_id','div' => false,'label' => false,'empty'=>__('Please select'),'options'=>array('External Consultant','Treating Consultant'),
					'id' => 'category_id1','style'=>'width:152px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][category_id][]',"onchange"=>"categoryChange(this)")) ?>
				</td> 
				<td valign="top" style="text-align: left;">
					<?php echo $this->Form->input('ConsultantBilling.doctor_id', array('class' =>
					 'validate[required,custom[mandatory-select]] textBoxExpnd doctor_id','div' => false,'label' => false,'empty'=>__('Please Select'),
					 'options'=>array(''),'id' => 'doctor_id1','style'=>'width:152px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][doctor_id][]',
					 "onchange"=>"doctor_id(this)")); ?>
				</td> 
				<td valign="top" style="text-align: left;">
					<select
						onchange="getListOfSubGroup(this);" name="data[ConsultantBilling][service_category_id][]"
						id="service-group-id1" style="width:167px;" class="textBoxExpnd service-group-id"  fieldNo="1">
						<option value="">Select Service Group</option>
						<?php foreach($service_group as $key =>$value){ ?>
						<option value="<?php echo $value['ServiceCategory']['id'];?>"><?php echo $value['ServiceCategory']['name'];?></option>
						<?php } ?>
					</select>
					<!-- <br />
					<select id="service-sub-group1" name="data[ConsultantBilling][service_sub_category_id][]" style="width:167px;" 
						fieldNo="1" class="textBoxExpnd service-sub-group"	onchange="serviceSubGroup(this)" >
					</select> -->
				</td>
				<td valign="top" style="text-align: left;">
					<?php  /* echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd consultant_service_id',
								'div' => false,'label' => false,'empty'=>__('Please Select'),'options'=>array(''),'id' => 'consultant_service_id1',
								'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][consultant_service_id][]' ,
								"onchange"=>"consultant_service_id(this)")); */
					
					echo $this->Form->input('', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd consultant_service_id',
							'div' => false,'label' => false  ,'id' => 'consultant_service_id1',
							'style'=>'width:150px;','fieldNo'=>1,  'name'=>'data[ConsultantBilling][consultant_service_id][]'));
					?> 
				</td>
				<td valign="top" style="text-align: center;">
					<?php  echo $this->Form->input('', array('class' => 'textBoxExpnd','type'=>'select','options'=>array('private'=>'Private','cghs'=>'CGHS','other'=>'Other'),
								'div' => false,'label' => false,'empty'=>__('Please Select'),'id' => 'hospital_cost1',
								'style'=>'width:130px;','name'=>'data[ConsultantBilling][hospital_cost][]'));
					?>
					<div id="hospital_cost_area" style="padding-top:5px;">
						<span id="private" style="display:none"></span>
						<span id="cghs" style="display:none"></span>
						<span id="other" style="display:none"></span>
					</div>
				</td> 
				<td valign="top" style="text-align: center;"><?php echo $this->Form->input('amount',array('class' => 'validate[required,custom[onlyNumber]] amount textBoxExpnd','legend'=>false,'label'=>false,'id' => 'amount1','style'=>'width:80px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][amount][]')); 
				?></td>
				<td valign="top" style="text-align: center;"><?php echo $this->Form->input('description',array('class' => 'description textBoxExpnd','legend'=>false,'label'=>false,'id' => 'description1','style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ConsultantBilling][description][]')); 
				?></td>
				<td valign="top" style="text-align:center;">  </td>  
			</tr>

			<!-- <tr id="ampoutRow">
				<td colspan="6" valign="middle" align="right"><?php echo __('Total Amount');?></td>
				<td valign="middle" style="text-align: right;"><?php echo $totalAmount;?>
				</td>
				<td>&nbsp;</td>
			</tr> -->
		</table>
		</td>
	</tr>
	<tr>
		<td>
		<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
			<td>&nbsp;</td>
			</tr>
			<tr>
				 <td width="50%"><input name="" type="button" value="Add More Visits" class="blueBtn addMore" tabindex="17" onclick="addConsultantVisitElement();"/> &nbsp;&nbsp;<input name="removeVisit" type="button" value="Remove" class="blueBtn" tabindex="17" onclick="removeConsultantVisitElement();" id="removeVisit" style="visibility:hidden"/></td>
				 <td width="50%" align="right">
				
				 <input class="blueBtn" type="button" value="Save" id="saveConsultantBill">
				 <!-- <input class="blueBtn" type="submit" value="Save" id="saveConsultantBill"> --> 
				 <?php //echo $this->Html->link(__('Cancel'),'#', array('id'=>'consultantCancel','escape' => false,'class'=>'blueBtn'));?>
				</td>
			</tr>
			
		</table>
		</td>
	</tr>
	
</table>

<?php echo $this->Form->end(); ?>
				
				
	

<!-- ******** -->
<!--  Service section start-->

<?php //if($patient['Patient']['admission_type']!='OPD' && $patient['Patient']['is_discharge']!=1){
	if($patient['Patient']['is_discharge']!=1){ ?>
<div id="servicesSection" style="display: none">
 
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
				<th width="140"><?php echo __('Date');?></th>
				<!--<th width="250"><?php //echo __('Type');?></th>
				<th width="250" style=""><?php //echo __('Name');?></th>-->
				<!--<th width="250" style=""><?php //echo __('Service Group/Sub Group');?></th>-->
				<!-- <th width="150" style=""><?php echo __('Service Group');?></th> -->
				<th width="150" style=""><?php echo __('Service Sub Group');?></th>
				<th width="150" style=""><?php echo __('Service');?></th>
				<!--<th width="100" style=""><?php echo __('Hospital Cost');?></th> -->
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
			<tr id="row1">
				<td align="center" width="140">
					<input type="hidden" value="1" id="no_of_fields">	
					<?php echo $this->Form->input('', array('type'=>'text','id' => 'ServiceDate1','label'=>false,'div'=>false,
					'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd  ServiceDate','style'=>'width:120px;',
					'readonly'=>'readonly','fieldNo'=>1,'name'=>'data[ServiceBill][0][date]')); ?>
				</td>
				 
				<!-- <td align="center" width="150px">
					<select onchange="getListOfSubGroupServices(this);" name="data[ServiceBill][0][service_id]"
						id="add-service-group-id1" style="width:150px;" class="textBoxExpnd add-service-group-id"  fieldNo="1">
						<option value="">Select Service Group</option>
						<?php foreach($service_group as $key =>$value){ ?>
						<option value="<?php echo $value['ServiceCategory']['id'];?>"><?php echo $value['ServiceCategory']['name'];?></option>
						<?php } ?>
					</select>
				</td> -->
				
				<td align="center" width="150"> 
					<?php echo $this->Form->input('',array('type'=>'text','class'=>'service-sub-group textBoxExpnd','id'=>'add-service-sub-group1'));
						  echo $this->Form->hidden('', array('name'=>'data[ServiceBill][0][sub_service_id]','id'=>'addServiceSubGroupId_1','class'=>'addServiceSubGroupId'));?></td>
				
				<td align="center" width="150">
					<?php  /* echo $this->Form->input('', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd service_id',
								'div' => false,'label' => false,'empty'=>__('Please Select'),'options'=>array(''),'id' => 'service_id1',
								'style'=>'width:150px;','fieldNo'=>1,'name'=>'data[ServiceBill][0][tariff_list_id]' ,
								"onchange"=>"service_id(this)")); */
					
					echo $this->Form->input('', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd service_id',
					 	 'div' => false,'label' => false  ,'id' => 'service_id1','style'=>'width:150px;','fieldNo'=>1, ));

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
				<?php echo $this->Form->input('amount',array('class' => 'validate[required,custom[onlyNumber]] textBoxExpnd service_amount','legend'=>false,'label'=>false,'id' => 'service_amount1','style'=>'width:80px;','fieldNo'=>1,'name'=>'data[ServiceBill][0][amount]')); ?></td>
				
				<td align="center">
					<?php echo $this->Form->input('no_of_times',array('class'=>'validate[required,custom[onlyNumber]] textBoxExpnd no_of_times nofTime','id'=>'no_of_times1','type'=>'text','style'=>'width:80px;','name'=>'data[ServiceBill][0][no_of_times]','label'=>false,'div'=>false,'value'=>'1'));?></td>
				
				<td id="amount_1" class="amount" valign="middle" style="text-align:center;"></td>
				<td align="center">
					<?php echo $this->Form->input('description',array('class'=>' textBoxExpnd description','id'=>'description','type'=>'text','style'=>'width:150px;','name'=>'data[ServiceBill][0][description]','label'=>false,'div'=>false));?></td>
				<td valign="middle" style="text-align:center;"></td>  
			</tr>
			
			<!-- row ends -->
			
			
			<!-- row to display the total amount for services -->
			<!--<tr id="ampoutRow">
				<td colspan="6" valign="middle" align="right"><?php echo __('Total Amount');?></td>
				<td valign="middle" style="text-align: right;"><?php echo $this->Number->currency($totalAmount);?>
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
<div id="ajaxMandatoryServiceData"></div>
<div id="ajaxSeviceData"></div>
<div id="ajaxLabData"></div>
<div id="ajaxRadData"></div>
<div id="ajaxImplantData"></div>
<div id="ajaxBloodData"></div>		
<div id="ajaxProcedureData"></div>
<div id="ajaxPharmacyData"></div>	
<div>&nbsp;</div>
<div>&nbsp;</div>
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
?> 

<table  width="100%" cellspacing="0" cellpadding="0" border="0" style="padding-left: 10px;" align="center" bgcolor="LightGray" >
     <tbody><tr>
     	<td width="47%" valign="top">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
      		<tbody>
      			<tr>
                <td width="200" height="35" class="tdLabel2"><?php echo __('Total Amount' );?></td>
                <td width="100"><?php echo $this->Form->input('Billing.total_amount',array('readonly'=>'readonly','value' => $this->Number->format(ceil($totalCost),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totalamount','style'=>'text-align:right;','readonly'=>'readonly'));
		               ?>
                 </td>
                 <td>&nbsp;</td>
                 </tr>
                 <tr>
                 <td height="35" class="tdLabel2">Advance Amount</td>
                 <td> <?php echo $this->Form->input('Billing.amount_paid',array('readonly'=>'readonly','value' => $this->Number->format(ceil($totalAdvancePaid),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'text-align:right;','readonly'=>'readonly'));
				     ?>
     			</td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
			    <td>Amount Paid</td>
			    <td><?php echo $this->Form->input('Billing.amount',array('autocomplete'=>'off','type'=>'text','value'=>'','legend'=>false,'label'=>false,'id' => 'amount','style'=>'text-align:right;'));?>
			    </td>
			    <td><span style="float:left;"><font color="red">&nbsp;&nbsp;*&nbsp;</font></span>
			    <?php echo $this->Form->input('Billing.date',array('class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'discharge_date','style'=>'width:150px;'));?>
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
    <td><?php echo $this->Form->input('Billing.mode_of_payment', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:141px;',
   								'div' => false,'label' => false,'empty'=>__('Please select'),'autocomplete'=>'off',
   								'options'=>array('Cash'=>'Cash','Cheque'=>'Cheque','Credit Card'=>'Credit Card','Credit'=>'Credit','NEFT'=>'NEFT'),'id' => 'mode_of_payment')); ?>
   	</td>
   </tr> 
   <tr id="creditDaysInfo" style="display:none">
	  	<td height="35" class="tdLabel2"> 
	  		Credit Period<font color="red">*</font><br /> (in days)</td>
	    <td><?php echo $this->Form->input('Billing.credit_period',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'credit_period','class'=> 'validate[required,custom[mandatory-enter-only]]'));?></td>
   </tr> 
   <tr id="paymentInfo" style="display:none">
	  	<td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%" > 
			    <tr>
				    <td>Bank Name</td>
				    <td><?php echo $this->Form->input('Billing.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_paymentInfo'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('Billing.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfo'));?></td>
				</tr>
				    <tr>
				    <td>Cheque/Credit Card No.</td>
				    <td><?php echo $this->Form->input('Billing.check_credit_card_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?></td>
			    </tr>
		    </table>
	    </td>
   </tr>
   <tr id="neft-area" style="display:none;">
	  	<td height="35" colspan="2" class="tdLabel2"> 
		  	<table width="100%"> 
			    <tr>
				    <td width="47%">Bank Name</td>
				    <td><?php echo $this->Form->input('Billing.bank_name_neft',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'BN_neftArea'));?></td>
				</tr>
				    <tr>
				    <td>Account No.</td>
				    <td><?php echo $this->Form->input('Billing.account_number_neft',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_neftArea'));?></td>
				</tr> 
			    <tr>
				    <td>NEFT No.</td>
				    <td><?php echo $this->Form->input('Billing.neft_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number'));?></td>
				</tr>
				    <tr>
				    <td>NEFT Date</td>
				    <td><?php echo $this->Form->input('Billing.neft_date',array('type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd','id' => 'neft_date'));?></td>
				</tr>
		    </table>
	    </td>
  </tr> 
  <?php }  ?>
          <tr>
	      <td height="35" class="tdLabel2">Remark</td>
	      <td width="200" colspan="2"><?php echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,'id' => 'remark'));
	      //echo $this->Form->input('Billing.remark', array('value'=>'','class' => ' textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'id' => 'remark'));  ?></td>
      	</tr>                          
        </tbody>
     	</table>
    	</td>
        <td width="50">&nbsp;</td>
                               
     </tr>
     <tr>
        <td valign="top" style="padding-top: 15px;" colspan="2"> 
	 		 <input class="blueBtn" type="button" value="Save" id="payAmount">   
	 		 <!-- <input class="blueBtn" type="button" value="Final Payment And Discharge" id="doneAndPrint"> -->
		</td>
        <td valign="top" align="right" style="padding-top: 15px;">&nbsp;</td>
     </tr>
     <tr>
		<td>&nbsp;</td>
	 </tr>
    </tbody>
</table> 
 <?php echo $this->Form->end(); ?>        
</div> 
<!-- /****EOF payment details****/ -->

<style>
#consultantSection {
	display: none;
}
</style>

<script>
 /*var viewSection="<?php echo $viewSection;?>";
  var admissionDate = <?php echo json_encode($splitDate[0]); ?>;
 var explode = admissionDate.split('-');


	 $('#consultantCancel').click(function() {
		document.getElementById('ConsultantBilling').reset();
		$("#servicesSectionBtn").attr('checked', true);
		$("#consultantSection").hide();
		$("#servicesSection").show();
	 });
	   
	 $('#dischargeBill').click(function() {
		 $("#servicesSectionBtn").attr('checked', true);
		 $("#pharmacy-section").hide();
		 $("#pathologySection").hide();
		 $("#consultantSection").hide();
		 $("#servicesSection").show();
		 $("#otherServicesSection").hide();
      });
	 $('#advancePayment').click(function() {
		 $("#servicesSectionBtn").attr('checked', true);
		 $("#pharmacy-section").hide();
		 $("#pathologySection").hide();
		 $("#consultantSection").hide();
		 $("#servicesSection").show();
		 $("#otherServicesSection").hide();
      });
	 	 $("#servicesSection").show();
         $('#saveConsultantBill').click(function() {
            jQuery("#ConsultantBilling").validationEngine();
         });
         
         $('#saveServiceBill').click(function() {
            jQuery("#servicefrm").validationEngine();
         });

         $('body').click(function() {
          // jQuery("#ConsultantBilling").validationEngine('hide');
         //  jQuery("#servicefrm").validationEngine('hide');
         });
         $('#saveOtherServices').click(function() {
             jQuery("#otherServices").validationEngine();
          });
         
	 
	if(viewSection !=''){
		$("#consultantSection").hide();
		$("#servicesSection").hide();
		$("#servicesSectionBtn").attr('checked', false);
		$("#consultantSectionBtn").attr('checked', false);
		$("#"+viewSection).show();
		$("#"+viewSection+'Btn').attr('checked', true);
		//alert(viewSection);
	}
	
	
	 $(".servicesClick").click(function(){
		var checkboxId = this.id;
		var splitArr = checkboxId.split("_");
		var enableInput = splitArr[0]+'_quantity_'+splitArr[1];
		//alert(enableInput);
		if ($("#"+checkboxId).is(":checked")) {
			 $("#"+enableInput).attr("readonly", false);
			 $("#"+enableInput).val(1);
		}else{
		 	$("#"+enableInput).attr("readonly", 'readonly');
		 	$("#"+enableInput).val('');
		}

     });
	 
	 $("#servicesSectionBtn").click(function(){
		 $("#consultantSection").hide();
		 $("#servicesSection").show();
		 $("#pharmacy-section").hide();
		 $("#ImplantSection").hide();
         $("#pathologySection").hide();
         $("#MriSection").hide();
         $("#CTSection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
     });
     
	 $("#consultantSectionBtn").click(function(){
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").show();
		 $("#servicesSection").hide();
		 $("#pharmacy-section").hide();
		 $("#ImplantSection").hide();
		 $("#MriSection").hide();
		 $("#CTSection").hide();
         $("#pathologySection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
     });
     
	 $("#pathologySectionBtn").click(function(){
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#pharmacy-section").hide();
		 $("#MriSection").hide();
         $("#pathologySection").show();
		 $("#radiologySection").hide();
		 $("#ImplantSection").hide();
		 $("#CTSection").hide();
		 $("#OtherServicesSection").hide();
		 $("#otherServicesSection").hide();
     });
     
	 $("#radiologySectionBtn").click(function(){
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#pharmacy-section").hide();
		 $("#ImplantSection").hide();
		 $("#MriSection").hide();
         $("#pathologySection").hide();
         $("#CTSection").hide();
         $("#radiologySection").show();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
		 //alert('here');
     });
 
	 $("#pharmacy-sectionBtn").click(function(){ 
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#MriSection").hide();
		 $("#ImplantSection").hide();
		 $("#pharmacy-section").show();
		 $("#CTSection").hide();
         $("#pathologySection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
		 //alert('here');
     });


	 $("#implant-sectionBtn").click(function(){ 
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#MriSection").hide();
		 $("#pharmacy-section").hide();
		 $("#ImplantSection").show();
		 $("#CTSection").hide();
         $("#pathologySection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
		 //alert('here');
     });
     

	 $("#DailySectionBtn").click(function(){ 
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#pharmacy-section").hide();
		 $("#ImplantSection").hide();
		 $("#MriSection").hide();
		 $("#CTSection").hide();
         $("#pathologySection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
		 //alert('here');
     });

	 $("#ProcedureSectionBtn").click(function(){ 
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#pharmacy-section").hide();
		 $("#MriSection").hide();
		 $("#CTSection").hide();
         $("#pathologySection").hide();
         $("#ImplantSection").hide();
         $("#radiologySection").hide();
         $("#OtherServicesSection").hide();
         $("#otherServicesSection").hide();
		 //alert('here');
     });

	 $("#otherServicesSectionBtn").click(function(){ 
		 document.getElementById('ConsultantBilling').reset();
		 $("#consultantSection").hide();
		 $("#servicesSection").hide();
		 $("#MriSection").hide();
		 $("#CTSection").hide();
		 $("#ImplantSection").hide();
		 $("#pharmacy-section").hide();
         $("#pathologySection").hide();
         $("#radiologySection").hide();
         $("#otherServicesSection").show();
		 //alert('here');
     });	

	 $("#addOtherServices").click(function(){ 
		 $("#viewAddService").show();
		 $("#viewOtherServices").hide();
		 $("#addOtherServices").hide();
	 });

	 $("#otherServicesCancel").click(function(){ 
		 $("#viewAddService").hide();
		 $("#viewOtherServices").show();
		 $("#addOtherServices").show();
	 });
	 
	   
	$(function() {
			$("#billDate").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',				 
				dateFormat: 'dd/mm/yy',
				maxDate: new Date(),	
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),	
				onSelect: function (theDate)
			    {			        // The "this" keyword refers to the input (in this case: #someinput)
			   		window.location.href = '?serviceDate='+theDate;
			    	 
			    }	
	 		}); 

			$("#otherServiceDate").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',				 
				dateFormat: 'dd/mm/yy',	
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),
	 			maxDate: new Date(),		
			});

			$("#ConsultantDate").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',				 
				dateFormat: 'dd/mm/yy',	
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),
				maxDate: new Date(),		
			});
 
			$("#ServiceDate").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',				 
	 			dateFormat: 'dd/mm/yy',	
				minDate : new Date(explode[0],explode[1] - 1,explode[2]),
				maxDate: new Date(),		
			});
			

			$("#search_service_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","name",'null','null','null', "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});

			
     	//fnction to display hospital cost 
 		$("#hospital_cost").change(function(){ 
 			/*$("#hospital_cost_area").each(function() {
 			   $(this).hide();
 			});*//*
 			 $("#hospital_cost_area").find('span').each(function(){ 
  	 			 	$("#"+$(this).attr('id')).hide();
 			 });
 			$("#"+$(this).val()).show();
 	 	});
 });
*/
 
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
					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#service-group-id'+fieldno).val()+"/",
					  context: document.body,				  		  
					  success: function(data){ 
	 				  	data= $.parseJSON(data);
					  	$("#consultant_service_id"+fieldno+" option").remove();
					  	$("#consultant_service_id"+fieldno).append( "<option value=''>Select Service</option>" );
						$.each(data, function(val, text) {
						    $("#consultant_service_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
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
		 $("#amount"+fieldno).val('');
		 $("#doctor_id"+fieldno).val('Please Select');
		 $("#charges_type"+fieldno).val('Please Select');
		 $.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getDoctorList", "admin" => false)); ?>"+"/"+$('#category_id'+fieldno).val(),
			  context: document.body,				  		  
			  success: function(data){//alert(data);
			  	data= $.parseJSON(data);
 			  	$("#doctor_id"+fieldno+" option").remove();
			  	$("#doctor_id"+fieldno).append( "<option value=''>Please Select</option>" );
				$.each(data, function(val, text) {
				    $("#doctor_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
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
					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#service-group-id'+fieldno).val()+"/"+$('#service-sub-group'+fieldno).val(),
					  context: document.body,				  		  
	 				  success: function(data){ 
					  	data= $.parseJSON(data);
					  	$("#consultant_service_id"+fieldno+" option").remove();
					  	$("#consultant_service_id"+fieldno).append( "<option value=''>Select Service</option>" );
						$.each(data, function(val, text) {
						    $("#consultant_service_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
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
 					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantServices", "admin" => false)); ?>"+"/"+$('#add-service-group-id'+fieldno).val()+"/"+$('#add-service-sub-group'+fieldno).val(),
 					  context: document.body,				  		  
 					  success: function(data){ 
 					  	data= $.parseJSON(data);
 	 				  	$("#service_id"+fieldno+" option").remove();
 					  	$("#service_id"+fieldno).append( "<option value=''>Select Service</option>" );
 						$.each(data, function(val, text) {
 						    $("#service_id"+fieldno).append( "<option value='"+val+"'>"+text+"</option>" );
 						});
 					  }
 				});
 			
 		 } 
		 
	//cost of consutatnt
	  function consultant_service_id(obj){
	   var currentField = $(obj);
    	var fieldno = currentField.attr('fieldNo') ;
			$("#amount"+fieldno).val(''); 
				var tariff_standard_id ='<?php echo $patient['Patient']['tariff_standard_id'];?>';
				$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getConsultantCost", "admin" => false)); ?>"+"/"+$(obj).val()+"/"+tariff_standard_id,
					  context: document.body,				  		  
					  success: function(data){ 
	 				  	data= $.parseJSON(data);
					  	$("#amount"+fieldno).val(data.tariff_amount);
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
    	 $("#amount"+fieldno).val(''); 
    	 $("#charges_type"+fieldno).val('Please Select');
     } 


        if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
	 		 $("#paymentInfo").show();
	 		 $("#creditDaysInfo").hide();
	 		 $('#neft-area').hide();
	 	} else if($("#mode_of_payment").val() == 'Credit') {
	 	 	$("#creditDaysInfo").show();
	 	 	$("#paymentInfo").hide();
	 	 	$('#neft-area').hide();
	 	} else if($('#mode_of_payment').val()=='NEFT') {
	 	    $("#creditDaysInfo").hide();
	 		$("#paymentInfo").hide();
	 		$('#neft-area').show();
	 	}
   	
      $("#mode_of_payment").change(function(){
			//alert('here');
			if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
				 $("#paymentInfo").show();
				 $("#creditDaysInfo").hide();
				 $('#neft-area').hide();
			} else if($("#mode_of_payment").val() == 'Credit') {
			 	$("#creditDaysInfo").show();
			 	$("#paymentInfo").hide();
			 	$('#neft-area').hide();
			} else if($('#mode_of_payment').val()=='NEFT') {
			    $("#creditDaysInfo").hide();
				$("#paymentInfo").hide();
				$('#neft-area').show();
			}else{
				 $("#creditDaysInfo").hide();
				 $("#paymentInfo").hide();
				 $('#neft-area').hide();
			}
	 });

      
      $("#payAmount").click(function(){
		var patient_id='<?php echo $patientID;?>';
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
					  $("#busy-indicator").hide();			  
				  },
				  beforeSend:function(){$("#busy-indicator").show();},		  
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
			//minDate:new Date(<?php echo $this->General->minDate($wardInDate) ?>),
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
    		dateFormat:'dd/mm/yy',
    		//minDate:new Date(),
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
  				dateFormat:'dd/mm/yy',
  				//minDate:new Date(),
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

     //save services
      $("#ServiceBillsData").click(function(){
        groupID=$('#serviceGroupId').val();
    	//jQuery("#servicefrm").validationEngine();
    	var validatePerson = jQuery("#servicefrm").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
  		var patient_id='<?php echo $patientID;?>';
  		formData = $('#servicefrm').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "servicesBilling", "admin" => false)); ?>"+'/'+patient_id,
  				  context: document.body,
  				  success: function(data){ 
  					$("#servicefrm").trigger('reset');
  					$(".amount").html('');
  					if(groupID=='1'){
  	  					getServiceData(patient_id);	
  					}else if(groupID=='5'){
  						getImplantData(patient_id);
  	  				}else if(groupID=='6'){
  	  					getBloodData(patient_id);
  	  				}
  					getbillreceipt(patient_id);
  					$("#busy-indicator").hide();
  				  },
  				  beforeSend:function(){$("#busy-indicator").show();},		  
  			});
  		//return true;  
        });

      function getServiceData(patient_id){
    	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxServiceData","admin" => false)); ?>"+'/'+patient_id;
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
         			 $('#ajaxSeviceData').html(data);
         			// medCount = $("#noMeddisable").val() ;
          	}
          },
  		});
      }
     
	 //EOF save services
	 
	 
	 //save consultation for opd
	 $("#saveConsultantBill").click(function(){
    	var validatePerson = jQuery("#ConsultantBilling").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}
  		var patient_id='<?php echo $patientID;?>';
  		formData = $('#ConsultantBilling').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ConsultantBilling", "admin" => false)); ?>"+'?Flag=consultaionBill',
  				  context: document.body,
  				  success: function(data){ 
  					$("#ConsultantBilling").trigger('reset');
  					//$(".amount").html('');
  	  				getConsultaionData(patient_id);
  	  				getbillreceipt(patient_id);	
  					$("#busy-indicator").hide();
  					  			  
  				  },
  				  beforeSend:function(){$("#busy-indicator").show();},		  
  			});
  		
        });

	 function getConsultaionData(patient_id){
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxConsultationData","admin" => false)); ?>"+'/'+patient_id;
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
        			 $('#ajaxConsultaionData').html(data);
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
  		var patient_id='<?php echo $patientID;?>';
  		formData = $('#labServices').serialize();
  			$.ajax({
  				  type : "POST",
  				  data: formData,
  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "addLab", "admin" => false)); ?>"+'/'+patient_id,
  				  context: document.body,
  				  success: function(data){ 
  					$("#labServices").trigger('reset');
  					//$(".amount").html('');
  	  				getLabData(patient_id);	
  	  				getbillreceipt(patient_id);
  					$("#busy-indicator").hide();
  				  },
  				  beforeSend:function(){$("#busy-indicator").show();},		  
  			});
  		
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
	         	if(data!=''){
	        			 $('#ajaxLabData').html(data);
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
			$("#labOrderArea")
			.append($('<tr>').attr({'id':'orderRowNew_'+counter})
				.append($('<td>').append($('<input>').attr({'id':'labDate_'+counter,'class':'textBoxExpnd labDate','type':'text','name':'LaboratoryTestOrder[start_date][]'})))
				.append($('<td>').append($('<input>').attr({'id':'test_name_'+counter,'placeholder':'Lab Search','class':'validate[required,custom[mandatory-enter]] textBoxExpnd AutoComplete test_name','type':'text','name':'LaboratoryTestOrder[lab_name][]'}))
						.append($('<input>').attr({'id':'labid_'+counter,'class':'textBoxExpnd labid','type':'hidden','name':'LaboratoryTestOrder[laboratory_id][]'}))
						.append($('<span>').attr({'class':'orderText','id':'orderText_'+counter,'style':'float:right; cursor: pointer;','title':'Order Detail'}).append($('<strong>...</strong>'))))
	    		.append($('<td>').append($('<select>').attr({'id':'service_provider_id_'+counter,'class':'textBoxExpnd ','type':'select','name':'LaboratoryTestOrder[service_provider_id][]'}).append($('<option value="">').text('None'))))
	    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd ','type':'text','name':'LaboratoryTestOrder[amount][]'})))
	    		.append($('<td>').append($('<input>').attr({'class':'textBoxExpnd ','type':'text','name':'LaboratoryTestOrder[description][]'})))
	    		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
    					.attr({'class':'removeButton','id':'removeButton_'+counter,'title':'Remove current row'}).css('float','right')))
    			)	
	    	.append($('<tr>').attr({'id':'orderRow_'+counter})
						.append($('<td>').attr({'style':'display: none','id':'orderArea_'+counter,'class':'orderArea','colspan':'6'})))		
	    	
	     getExtReq(counter);
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
  				dateFormat:'dd/mm/yy',
  				//minDate:new Date(),
  				onSelect:function(){$(this).focus();}

  			});
	 });

	 function getExtReq(flag){
 		var selectExtReq = <?php echo $serviceProviders;?>;
 		var cnt = 0 ;
	 	$.each(selectExtReq, function(key, value) {
	 		$('#service_provider_id_'+flag).append($('<option>', { value : key }).text(value));
	 		/*if( cnt == 0 ){
	 			$('#service_provider_id_'+flag).append($('<option value="">').text('None'));
	 			cnt++;
 	 		}else{
	 	 	 $('#service_provider_id_'+flag).append($('<option>', { value : key }).text(value));
 	 		}*/
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
			$("#RadiologyArea")
			.append($('<tr>').attr({'id':'radiologyRow_'+counRad})
				.append($('<td>').append($('<input>').attr({'id':'radDate_'+counter,'class':'textBoxExpnd radDate','type':'text','name':'data[RadiologyTestOrder][radiology_order_date][]'})))
				.append($('<td>').append($('<input>').attr({'id':'radiologyname_'+counRad,'class':'validate[required,custom[mandatory-enter]] radiology_name textBoxExpnd','type':'text','name':'data[RadiologyTestOrder][rad_name][]'}))
						.append($('<input>').attr({'id':'radiologytest_'+counRad,'class':'textBoxExpnd radiology_test','type':'hidden','name':'data[RadiologyTestOrder][radiology_id][]'}))
						.append($('<span>').attr({'class':'radOrderText','id':'radOrderText_'+counRad,'style':'float:right; cursor: pointer;','title':'Radiology Order Detail'}).append($('<strong>...</strong>'))))
	    		.append($('<td>').append($('<select>').attr({'id':'service_provider_id_'+counRad,'class':'textBoxExpnd ','type':'select','name':'data[RadiologyTestOrder][service_provider_id][]'}).append($('<option value="">').text('None'))))
	    		.append($('<td>').append($('<input>').attr({'id':'radAomunt_'+counRad,'class':'textBoxExpnd radAomunt','type':'text','name':'data[RadiologyTestOrder][amount][]'})))
	    		.append($('<td>').append($('<input>').attr({'id':'description_'+counRad,'class':'textBoxExpnd description','type':'text','name':'data[RadiologyTestOrder][description][]'})))
	    		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
    					.attr({'class':'removeRadiology','id':'removeRadiology_'+counRad,'title':'Remove current row'}).css('float','right')))
				)
    		.append($('<tr>').attr({'id':'orderRad_'+counRad})
						.append($('<td>').attr({'style':'display: none','id':'radOrderArea_'+counRad,'class':'radOrderArea','colspan':'6'})))		
	    	
	     getExtReq(counter);
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
  				dateFormat:'dd/mm/yy',
  				//minDate:new Date(),
  				onSelect:function(){$(this).focus();}
  			});
	 });
	 
	 function getExtReq(flag){
 		var selectExtReq = <?php echo $serviceProviders;?>;
 		var cnt = 0 ;
	 	$.each(selectExtReq, function(key, value) {
	 		$('#service_provider_id_'+flag).append($('<option>', { value : key }).text(value));
	 		/*if( cnt == 0 ){
	 			$('#service_provider_id_'+flag).append($('<option value="">').text('None'));
	 			cnt++;
 	 		}else{
	 	 	 $('#service_provider_id_'+flag).append($('<option>', { value : key }).text(value));
 	 		}*/
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
	  		var patient_id='<?php echo $patientID;?>';
	  		formData = $('#radServices').serialize();
	  			$.ajax({
	  				  type : "POST",
	  				  data: formData,
	  				  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "addRad", "admin" => false)); ?>"+'/'+patient_id,
	  				  context: document.body,
	  				  success: function(data){ 
	  					$("#radServices").trigger('reset');
	  					//$(".amount").html('');
	  	  				getRadData(patient_id);	
	  	  				getbillreceipt(patient_id);
	  					$("#busy-indicator").hide();
	  				  },
	  				  beforeSend:function(){$("#busy-indicator").show();},		  
	  			});
	  		
	        });

		 function getRadData(patient_id,ID){
		   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxRadData","admin" => false)); ?>"+'/'+patient_id;
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
		        			 $('#ajaxRadData').html(data);
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
	
	 //$('#payment_category').val($("input[type='radio'][name='serviceGroupData']").val());
	 
	 $("input[type='radio'][name='serviceGroupData']").on('change',function(){ //alert($(this).val());
		   $('#payment_category').val($(this).val());
		   $('#serviceGroupId').val($(this).val());
		   if($(this).val()=='mandatoryServices'){
			   $('#mandatoryServicesSection').show();
			   $('#ajaxMandatoryServiceData').show();
			   $('#ajaxPharmacyData').hide();
			   $('#servicesSection').hide();
			   $('#ajaxSeviceData').hide();
			   $('#pathologySection').hide();
			   $('#radiologySection').hide();
			   $('#ajaxLabData').hide();
			   $('#ajaxConsultaionData').hide();
			   $('#ajaxRadData').hide();
			   $('#ajaxDailyroomData').hide();
			   $('#ajaxProcedureData').hide();
			   $('#ajaxBloodData').hide();
			   $('#ajaxImplantData').hide();
			   getMandatoryServiceData('<?php echo $patientID;?>');
		   }else if($(this).val()=='1'){
			   $('#mandatoryServicesSection').hide();
			   $('#ajaxMandatoryServiceData').hide();
			   $('#ajaxPharmacyData').hide();
			   $('#servicesSection').show();
			   $('#ajaxSeviceData').show();
			   $('#pathologySection').hide();
			   $('#radiologySection').hide();
			   $('#ajaxLabData').hide();
			   $('#ajaxConsultaionData').hide();
			   $('#ajaxRadData').hide();
			   $('#ajaxDailyroomData').hide();
			   $('#ajaxProcedureData').hide();
			   $('#ajaxBloodData').hide();
			   $('#ajaxImplantData').hide();
			   getServiceData('<?php echo $patientID;?>');
		   }else if($(this).val()=='2'){
			   $('#mandatoryServicesSection').hide();
			   $('#ajaxMandatoryServiceData').hide();
			   $('#ajaxPharmacyData').hide();
			   $('#servicesSection').hide();
			   $('#radiologySection').hide();
			   $('#ajaxLabData').show();
			   $('#pathologySection').show();
			   $('#ajaxSeviceData').hide();
			   $('#ajaxConsultaionData').hide();
			   $('#ajaxRadData').hide();
			   $('#ajaxDailyroomData').hide();
			   $('#ajaxBloodData').hide();
			   $('#ajaxImplantData').hide();
			   getLabData('<?php echo $patientID;?>');
			   $('#ajaxProcedureData').hide();
		   }else if($(this).val()=='3'){
			   $('#mandatoryServicesSection').hide();
			   $('#ajaxMandatoryServiceData').hide();
			   $('#ajaxPharmacyData').hide();
			   $('#servicesSection').hide();
			   $('#pathologySection').hide();
			   $('#radiologySection').show();
			   $('#ajaxRadData').show();
			   $('#ajaxLabData').hide();
			   $('#ajaxSeviceData').hide();
			   $('#ajaxConsultaionData').hide();
			   $('#ajaxDailyroomData').hide();
			   $('#ajaxProcedureData').hide();
			   $('#ajaxBloodData').hide();
			   $('#ajaxImplantData').hide();
			   getRadData('<?php echo $patientID;?>');
		   }else if($(this).val()=='4'){
			   $('#mandatoryServicesSection').hide();
			   $('#ajaxMandatoryServiceData').hide();
			   $('#servicesSection').hide();
			   $('#pathologySection').hide();
			   $('#radiologySection').hide();
			   $('#ajaxRadData').hide();
			   $('#ajaxLabData').hide();
			   $('#ajaxSeviceData').hide();
			   $('#ajaxBloodData').hide();
			   $('#ajaxImplantData').hide();
			   getPharmacyData('<?php echo $patientID;?>');
		   }else if($(this).val()=='5'){
			   $('#mandatoryServicesSection').hide();
			   $('#ajaxMandatoryServiceData').hide();
			   $('#ajaxPharmacyData').hide();
			   $('#servicesSection').show();
			   $('#ajaxImplantData').show();
			   $('#ajaxSeviceData').hide();
			   $('#pathologySection').hide();
			   $('#radiologySection').hide();
			   $('#ajaxLabData').hide();
			   $('#ajaxBloodData').hide();
			   $('#ajaxRadData').hide();
			   $('#ajaxProcedureData').hide();
			   getImplantData('<?php echo $patientID;?>');
		   }else if($(this).val()=='6'){
			   $('#mandatoryServicesSection').hide();
			   $('#ajaxMandatoryServiceData').hide();
			   $('#ajaxPharmacyData').hide();
			   $('#servicesSection').show();
			   $('#ajaxBloodData').show();
			   $('#ajaxSeviceData').hide();
			   $('#pathologySection').hide();
			   $('#radiologySection').hide();
			   $('#ajaxLabData').hide();
			   $('#ajaxRadData').hide();
			   $('#ajaxImplantData').hide();
			   $('#ajaxProcedureData').hide();
			   getBloodData('<?php echo $patientID;?>');
		   }else if($(this).val()=='7'){
			   $('#mandatoryServicesSection').hide();
			   $('#ajaxMandatoryServiceData').hide();
			   $('#ajaxPharmacyData').hide();
			   $('#servicesSection').hide();
			   $('#pathologySection').hide();
			   $('#radiologySection').hide();
			   $('#ajaxProcedureData').hide();
			   $('#ajaxDailyroomData').hide();
			   $('#ajaxRadData').hide();
			   $('#ajaxLabData').hide();
			   $('#ajaxSeviceData').hide();
			   $('#ajaxBloodData').hide();
			   //getProcedureData('<?php echo $patientID;?>');
		   }else if($(this).val()=='8'){
			   $('#mandatoryServicesSection').hide();
			   $('#ajaxMandatoryServiceData').hide();
			   $('#ajaxPharmacyData').hide();
			   $('#servicesSection').hide();
			   $('#pathologySection').hide();
			   $('#radiologySection').hide();
			   $('#ajaxProcedureData').show();
			   $('#ajaxDailyroomData').hide();
			   $('#ajaxRadData').hide();
			   $('#ajaxLabData').hide();
			   $('#ajaxSeviceData').hide();
			   $('#ajaxBloodData').hide();
			   getProcedureData('<?php echo $patientID;?>');
		   }else{
			   $('#totalamount').val('');
			   $('#ajaxSeviceData').hide();
			   $('#ajaxConsultaionData').hide();
			   $('#ajaxLabData').hide();
			   $('#ajaxRadData').hide();
			   $('#ajaxPharmacyData').hide();
			   $('#ajaxProcedureData').hide();
			   $('#servicesSection').hide();
			   $('#pathologySection').hide();
			   $('#radiologySection').hide();
			   $('#mandatoryServicesSection').hide();
			   $('#ajaxMandatoryServiceData').hide();
			   
		   }
		});  
 
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

	     
	 $("#singleBillPayment").click(function(){ 
		 totalCharge=$("#totalCharge").val();
		 totalPaid=$("#totalPaid").val();
		 patientID='<?php echo $patientID;?>';
		 $.fancybox({ 
			 	'width' : '100%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'onClosed':function(){
					getbillreceipt(patientID);
					//window.location.href='<?php echo $this->Html->url(array("controller"=>'billings',"action" => "dischargeIpd",$patientID));?>'
				},
				'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"finalDischarge","admin"=>false)); ?>"+'/'+patientID/*+'?totalCharge='+totalCharge+'&totalPaid='+totalPaid*/,
		 });
	 });

	 function getDailyData(patient_id){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxDailyroomData","admin" => false)); ?>"+'/'+patient_id;
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
	        			 $('#ajaxDailyroomData').html(data);
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }

	 function getProcedureData(patient_id){
	   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxProcedureData","admin" => false)); ?>"+'/'+patient_id;
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
	        			 $('#ajaxProcedureData').html(data);
	        			// medCount = $("#noMeddisable").val() ;
	         	}
	         },
	 		});
	     }

	 $("#amount").keyup(function(){
	 	/*total_amount=$('#totalamount').val();
	 	amount_paid=$(this).val();
		balance=total_amount - amount_paid;	 
		$('#totalamountpending').val(balance);*/

		total_amount=parseInt($('#totalamount').val()); 
	 	total_advance=parseInt($('#totaladvancepaid').val()); 
	 	amount_paid=parseInt($(this).val());
	 	amount_paid=total_advance + amount_paid; 
		balance=total_amount - amount_paid;	 
		if(isNaN(balance)==false){
			$('#totalamountpending').val(balance);
		}else{
			$('#totalamountpending').val('');
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
		 	ID=currentID.slice(-1); 
		 	var subGroupID = $("#addServiceSubGroupId_"+ID).val() ;
			$("#service_id"+ID).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices","admin" => false,"plugin"=>false)); ?>/"+selectedGroup+"/"+subGroupID,
				 minLength: 1,
				 select: function( event, ui ) {					 
					$('#onlyServiceId_'+ID).val(ui.item.id);
					var id = ui.item.id; 
					//serviceSubGroups(this);
				 },
				 messages: {
				        noResults: '',
				        results: function() {}
				 }
			});
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
		 ID=currentID.slice(-1); 
		 if($(this).val()==''){
			 $('#onlyServiceId_'+ID).val('');
		 }
	 });


	 //BOF implant section
	 function getImplantData(patient_id){
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxImplantData","admin" => false)); ?>"+'/'+patient_id;
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
        			 $('#ajaxImplantData').html(data);
        			// medCount = $("#noMeddisable").val() ;
         	}
         },
 		});
     }
	//EOF implant section
	
	//BOF blood section
	 function getBloodData(patient_id){
   	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxBloodData","admin" => false)); ?>"+'/'+patient_id;
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
        			 $('#ajaxBloodData').html(data);
        			// medCount = $("#noMeddisable").val() ;
         	}
         },
 		});
     }
	//EOF blood section

	//BOF Pharmacy section
	 function getPharmacyData(patient_id){
  	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxPharmacyData","admin" => false)); ?>"+'/'+patient_id;
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
       			 $('#ajaxPharmacyData').html(data);
       			// medCount = $("#noMeddisable").val() ;
        	}
        },
		});
    }
	//EOF Pharmacy section
	
	//BOF mandatory services section
	 function getMandatoryServiceData(patient_id){
  	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "ajaxMandatoryServiceData","admin" => false)); ?>"+'/'+patient_id;
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
       			 $('#ajaxMandatoryServiceData').html(data);
       			// medCount = $("#noMeddisable").val() ;
        	}
        },
		});
    }
	//EOF mandatory services section
</script>