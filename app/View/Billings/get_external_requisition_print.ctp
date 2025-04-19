<style>
tr { border-bottom:1px dashed #494949; }
</style>
<?php echo $this->Form->create('',array('url'=>array('action'=>'saveTestOrderDetails'),'id'=>'radiologyExternalRequisition'));?>
<table align="center" width="100%" >
	<tr height="50px">
		<td style="color: red;font-size: 18px;text-align: center; margin:0 auto;" colspan="3"><u>
			<?php echo strtoupper($radData['ServiceProvider']['name']);?> REQUISITION</u>
			<?php echo $this->Form->hidden('',array('name'=>'external_requisition_id','value'=>$radData['ExternalRequisition']['id']));
					if($radData['RadiologyTestOrder']['amount']>0.1) {
						$tariffAmount = $radData['RadiologyTestOrder']['amount'];
					}else{
						$tariffAmount = $radData['TariffAmount']['nabh_charges']>0 ? $radData['TariffAmount']['nabh_charges'] : $radData['TariffAmount']['non_nabh_charges'];
					}
				  echo $this->Form->hidden('',array('name'=>'tariff_amount','value'=>$tariffAmount));
				  echo $this->Form->hidden('',array('name'=>'private_amount','id'=>'private_amount','value'=>$privateAmount = $radData['ExternalRequisitionCommission']['private_amount']));
				  echo $this->Form->hidden('',array('name'=>'cghs_amount','id'=>'cghs_amount','value'=>$cghsAmount = $radData['ExternalRequisitionCommission']['cghs_amount']));?>
		</td>
	</tr>
	<tr>
         <td align="left">Date : <b><?php echo $this->DateFormat->formatDate2local($radData['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'));//date("d/m/Y"); ?></b>
         <td align="right">Tariff : <b><?php echo $radData['TariffStandard']['name']; ?></b>
         <?php $setTariff = $radData['ExternalRequisition']['mode']!=''?$radData['ExternalRequisition']['mode']:$tariff; 
         		echo $this->Form->hidden('',array('id'=>'serviceProviderID','name'=>'service_provider_id','value'=>$radData['ServiceProvider']['id']));?>
         <td align="right">Mode : <?php echo $this->Form->input('',array('name'=>'mode','type'=>'select','div'=>false,'label'=>false,'options'=>array('On Cash'=>'On Cash','On Credit'=>'On Credit'),'value'=>$setTariff));  ?>
	</tr>
</table>
<style>
input{
	border: none; 
}	
.borderBott{
	border-bottom:1px dashed #494949;
}
</style>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="10">
	<tr>
		<td align="left" width="35%"><?php echo __('Requisition Tariff : ');?></td>
		<td colspan="3" align="left" ><?php echo $this->Form->input('',array('name'=>'requisition_tariff','id'=>'requisitionTariff','class'=>'cost','div'=>false,'label'=>false,'type'=>'select','options'=>Configure::read('requisitionTariff'),'value'=>$radData['ExternalRequisition']['requisition_tariff']));?>
		<span id="privateAmount" style="display:none;"><?php echo number_format($privateAmount,2); ?></span>
		<span id="cghsAmount" style="display:none;"><?php echo number_format($cghsAmount,2); ?></span></td>
	</tr>
	<tr>
		<td align="left" width="35%"><?php echo __('Money Collected by Hospital : ');?></td>
		<td colspan="3" align="left" ><?php echo $this->Form->input('',array('name'=>'collected_by_hospital','id'=>'collectedByHospital','class'=>'cost','div'=>false,'label'=>false,'type'=>'checkbox'));?>
			</td>
	</tr>
	<tr>
		<td align="left" width="35%">Money Collected by <?php echo strtoupper($radData['ServiceProvider']['name']); ?> : </td>
		<td colspan="3" align="left" ><?php echo $this->Form->input('',array('name'=>'collected_by_provider','id'=>'collectedByProvider','div'=>false,'label'=>false,'type'=>'checkbox'));?>
			</td>
	</tr>
	<tr>
		<td align="left" width="35%">Service Amount : </td>
		<td colspan="3" align="left" ><?php echo number_format($tariffAmount,2); ?></td>
	</tr>
	<tr>
		<td align="left" width="35%">Name : </td>
		<td colspan="3" align="left" ><?php echo $radData['Patient']['lookup_name']; echo $this->Form->hidden('',array('name'=>'patient_id','value'=>$radData['Patient']['id'])); echo $this->Form->hidden('',array('name'=>'tariff_standard_id','value'=>$radData['Patient']['tariff_standard_id']));?></td>
	</tr>
	<tr>
		<td align="left" width="35%">Age : </td>
		<td width="25%" ><?php 
	//	echo explode("Y",$radData['Patient']['age'][0])." yrs"; changes by mahalaxmi
	echo $this->General->convertYearsMonthsToDaysSeparate($radData['Patient']['age']); ?></td>
		<td width="10%">Sex : </td>
		<td ><?php echo ucfirst($radData['Patient']['sex']); ?></td>
	</tr>
	<tr>
		<td align="left" width="35%">Referring Doctor : </td>
		<td colspan="3" ><?php echo "Dr. BK Murali";//echo "Dr. ".$radData[0]['user_name']; ?></td>
	</tr>
	<tr>
		<td align="left" width="35%">Clinical Details : </td>
		<td colspan="3" class="borderBott"><?php echo $this->Form->input('',array('type'=>'text','name'=>'clinical_details','div'=>false,'label'=>false,'value'=>$radData['ExternalRequisition']['clinical_details'],'style'=>"width:90%"));?></td>
	</tr>
	<tr>
		<td align="left" width="35%">Diagnosis : </td>
		<td colspan="3" class="borderBott"><?php echo $this->Form->input('',array('type'=>'text','name'=>'final_diagnosis','div'=>false,'style'=>"width:90%",'label'=>false,'value'=>$radData['Diagnosis']['final_diagnosis'])); echo $this->Form->hidden('',array('name'=>'diagnosis_id','value'=>$radData['Diagnosis']['id']));?></td></tr>
	<tr>
		<td align="left" width="35%">Detail of Investigation required : </td>
		<td colspan="3" class="borderBott"><?php echo $radData['RadiologyTestOrder']['testname']; echo $this->Form->hidden('',array('name'=>'radiology_test_order_id','value'=>$radData['RadiologyTestOrder']['id']));?></td>
	</tr>
	<tr>
		<td></td>
		<td colspan="3"><?php  echo $this->Form->input('',array('type'=>'text','name'=>'investigation_details','style'=>"width:90%",'div'=>false,'label'=>false,'value'=>$radData['ExternalRequisition']['investigation_details']));?></td>
	</tr>
</table>
<table align="center" border="0" width="100%">
	<tr>
         <td align="center"><div class="btns"><input name="submit" type="submit" value="Submit & Print" class="blueBtn"/></div></td>
	</tr>
</table>

<?php echo $this->Form->end();?>
 
 <script>
	 $(document).ready(function () {
		 checkTariffAmount();
		$("#collectedByHospital").click(function(){ 
			$("#collectedByProvider").prop('checked',false);
		});

		$("#collectedByProvider").click(function(){  
			$("#collectedByHospital").prop('checked',false);
		});

		$("#requisitionTariff").change(function(){
			checkTariffAmount();
		});
	});

	 function checkTariffAmount(){
		 if($("#requisitionTariff").val() == "Private"){
			$("#privateAmount").show();
			$("#cghsAmount").hide();
		}else{
			$("#cghsAmount").show();
			$("#privateAmount").hide();
		} 
	 }
	
 </script>