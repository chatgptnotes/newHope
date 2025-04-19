<style>
.changeBackground{
background: none repeat scroll 0 0 #f7f67b !important;
}
</style>
<?php echo $this->Form->create('pharmacy',array('controller'=>'billings','action'=>'','type' => 'file','id'=>'prescriptionFrm','inputDefaults' => array(
																							        'label' => false,
																							        'div' => false,
																							        'error' => false,
																							        'legend'=>false,
																							        'fieldset'=>false
)
)); 

if(strtolower($this->Session->read('website.instance'))=='kanpur'){//for kanpur instance
	if($pharmacyGroupDataWithId){//for medication whose salebill is done
		foreach($pharmacyGroupDataWithId as $key=>$pharmacyData){//debug($pharmacyData);  ?>	
			<table class="loading" style="text-align: left; padding: 0px !important; " width="100%">
				<tr>
					<td width="100%" valign="top" align="left" colspan="4">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm">
							<!-- row 1 -->
							<tr>
								<td width="100%" valign="top" align="left" colspan="6">
									<table width="100%" border="0" cellspacing="1" cellpadding="0" id='DrugGroup' style="padding: 0px !important;margin-top: 10px;" class="tabularForm">
										<tr>
											<th  height="20" align="left" valign="top" style="padding-right: 3px;" class="">Drug Name</th>
											<!-- <th  align="left" valign="top" class="">Qty</th> -->
											<th  align="left" valign="top" class="">Received Qty</th>
											<!-- <th  height="20" align="left" valign="top" class="">Strength</th>
											<th  height="20" align="left" valign="top" class="" >Dosage</th>
											<th  align="left" valign="top" class="">Dose Form</th>
											<th  height="20" align="left" valign="top" class="">Route</th>
											<th  align="left" valign="top" class="">Frequency</th>
											<th  align="left" valign="top" class="">Days</th> -->
											<!-- <th  align="left" valign="top" class="">As Needed (p.r.n)</th>
											<th  align="left" valign="top" class="">Dispense As Written</th> -->
											<!-- <th  align="left" valign="top" class="" >First Dose Date/Time</th>
											<th  align="left" 	valign="top" class="" >Stop Date/Time</th> -->
											<!-- <th  align="left" valign="top" class="">Active</th> -->
										</tr>
										<?php 
											echo $this->Form->hidden('pharmacy_sales_bill_id',array('id'=>'pharmacySalesBillId','value'=>$key));
						               		foreach($pharmacyData as $i=>$data){//debug($data['']['']); 
												if($data['NewCropPrescription']['pharmacy_sales_bill_id'] && $data['NewCropPrescription']['is_override']== 0)
													$background='paid_payment';
												else if($data['NewCropPrescription']['is_deleted'] == 1)
													$background='pending_payment';
												else if(!empty($data['NewCropPrescription']['pharmacy_sales_bill_id']) && $data['NewCropPrescription']['is_override']== 1)
													$background='changeBackground';
												else
													$background='';
												?>
						               	<tr id="DrugGroup<?php echo $i;?>">
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo stripslashes($data['NewCropPrescription']['description']); ?></td>
											
											<!-- <td align="left" valign="top" style="padding-right: 3px"><?php //echo $data['NewCropPrescription']['quantity'];?></td> -->
											
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $data['PharmacySalesBillDetail']['qty'];?></td>
											
											<!-- <td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
												$strengthArray=Configure :: read('strength');
												if($data['NewCropPrescription']['dose']==0){
													echo $strengthArray[$data['NewCropPrescription']['DosageForm']];
												}else{
													echo $data['NewCropPrescription']['dose'] .', '.$strengthArray[$data['NewCropPrescription']['DosageForm']]; 
												}?></td>
											
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $data['NewCropPrescription']['dosageValue'];?></td>
											
				                            <td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
					                            $roopArray=Configure :: read('roop');
					                            echo $roopArray[$data['NewCropPrescription']['strength']];?></td>
				
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
												$route_administrationArray=Configure :: read('route_administration');
												echo $route_administrationArray[$data['NewCropPrescription']['route']];?></td>
				
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
												$frequencyArray=Configure :: read('frequency'); 
												echo $frequencyArray[$data['NewCropPrescription']['frequency']];?></td>
											
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $data['NewCropPrescription']['day'];?></td> -->
				
											<!--  <td align="center" valign="top" style=""><?php $options = array('1'=>'Yes','0'=>'No');
													echo $options[$data['NewCropPrescription']['prn']];?></td>
				
											<td align="center" valign="top" style=""><?php echo $options[$data['NewCropPrescription']['daw']];?></td>-->
				
											<!-- <td align="center" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $this->DateFormat->formatDate2Local($data['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);?></td>
				
											<td align="center" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $this->DateFormat->formatDate2Local($data['NewCropPrescription']['stopdose'],Configure::read('date_format'),true);?></td> -->
											<!-- 
											<td align="center" valign="top" class="<?php //echo $background;?>"><?php //$options_active = array('N'=>'Yes','Y'=>'No');
													//echo $options_active[$data['NewCropPrescription']['archive']];?></td> -->
										</tr>
										
									<?php } //}?>
									</table>
								</td>
							</tr>
							<?php if($pharmacyData[0]['PharmacySalesBill']['is_received']=='0'){?>
			                <tr>
			                	<td align="right">
				                	<h3 style="font-size:13px;">
										<?php echo $this->Html->link('Received','javascript:void(0);',array('class'=>'received blueBtn','id'=>'received_'.$key,'escape' => false,'label'=>false,'div'=>false));?>
									</h3>
			                	</td>
			                </tr>
			                <?php }?>
						</table>
					</td>
				</tr>
			</table> 
	<?php }
	}
	if($pharmacyGroupDataWithoutId){//for medication whose salebill is not done  ?>
			<table class="loading" style="text-align: left; padding: 0px !important;" width="100%">
				<tr>
					<td width="100%" valign="top" align="left" colspan="4">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm">
							<!-- row 1 -->
							<tr>
								<td><strong>Medication Without Sale Bill</strong></td>
							</tr>
							<tr>
								<td width="100%" valign="top" align="left" colspan="6">
									<table width="100%" border="0" cellspacing="1" cellpadding="0" id='DrugGroup' style="padding: 0px !important;margin-top: 10px;" class="tabularForm">
										<tr>
											<th  height="20" align="left" valign="top" style="padding-right: 3px;" class="">Drug Name</th>
											<th  align="left" valign="top" class="">Qty</th>
											<!-- <th  align="left" valign="top" class="">Received Qty</th> -->
											<!-- <th  height="20" align="left" valign="top" class="">Strength</th>
											<th  height="20" align="left" valign="top" class="" >Dosage</th>
											<th  align="left" valign="top" class="">Dose Form</th>
											<th  height="20" align="left" valign="top" class="">Route</th>
											<th  align="left" valign="top" class="">Frequency</th>
											<th  align="left" valign="top" class="">Days</th> -->
											<!-- <th  align="left" valign="top" class="">As Needed (p.r.n)</th>
											<th  align="left" valign="top" class="">Dispense As Written</th> -->
											<!-- <th  align="left" valign="top" class="" >First Dose Date/Time</th>
											<th  align="left" 	valign="top" class="" >Stop Date/Time</th>
											<th  align="left" valign="top" class="">Action</th> -->
										</tr>
										<?php foreach($pharmacyGroupDataWithoutId as $k=>$dataWthoutId){ 
										
											if($dataWthoutId['NewCropPrescription']['pharmacy_sales_bill_id'] && $dataWthoutId['NewCropPrescription']['is_override']== 0)
												$background='paid_payment';
											else if($dataWthoutId['NewCropPrescription']['is_deleted'] == 1)
												$background='pending_payment';
											else if(!empty($dataWthoutId['NewCropPrescription']['pharmacy_sales_bill_id']) && $dataWthoutId['NewCropPrescription']['is_override']== 1)
												$background='changeBackground';
											else 
												$background='';?>
												
						               	<tr id="DrugGroup<?php echo $k;?>">
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo stripslashes($dataWthoutId['NewCropPrescription']['description']); ?></td>
											
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $dataWthoutId['NewCropPrescription']['quantity'];?></td>
											
											<!-- <td align="left" valign="top" style="padding-right: 3px"><?php //echo $dataWthoutId['PharmacySalesBillDetail']['qty'];?></td> -->
											
											<!-- <td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
												$strengthArray=Configure :: read('strength');
												if($dataWthoutId['NewCropPrescription']['dose']==0){
													echo $strengthArray[$dataWthoutId['NewCropPrescription']['DosageForm']];		
												}else{
													echo $dataWthoutId['NewCropPrescription']['dose'] .', '.$strengthArray[$dataWthoutId['NewCropPrescription']['DosageForm']];
												} ?></td>
											
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $dataWthoutId['NewCropPrescription']['dosageValue'];?></td>
											
				                            <td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
					                            $roopArray=Configure :: read('roop'); 
					                            echo $roopArray[$dataWthoutId['NewCropPrescription']['strength']];?></td>
				
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
												$route_administrationArray=Configure :: read('route_administration');
												echo $route_administrationArray[$dataWthoutId['NewCropPrescription']['route']];?></td>
				
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
												$frequencyArray=Configure :: read('frequency');
												echo $frequencyArray[$dataWthoutId['NewCropPrescription']['frequency']];?></td>
											
											<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $dataWthoutId['NewCropPrescription']['day'];?></td> -->
				
											<!--  <td align="center" valign="top" style=""><?php $options = array('1'=>'Yes','0'=>'No');
													echo $options[$dataWthoutId['NewCropPrescription']['prn']];?></td>
				
											<td align="center" valign="top" style=""><?php echo $options[$dataWthoutId['NewCropPrescription']['daw']];?></td>-->
				
											<!-- <td align="center" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $this->DateFormat->formatDate2Local($dataWthoutId['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);?></td>
				
											<td align="center" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $this->DateFormat->formatDate2Local($dataWthoutId['NewCropPrescription']['stopdose'],Configure::read('date_format'),true);?></td> -->
				
											<td align="center" valign="top" class="<?php echo $background;?>"><?php 
												if((!$dataWthoutId['NewCropPrescription']['pharmacy_sales_bill_id']) && ($dataWthoutId['NewCropPrescription'][is_deleted]==0)){
													echo $this->Html->image('icons/delete-icon.png',array('alt'=>'Delete','title'=>'delete','class'=>'deleteMedication','id'=>'deleteMedication_'.$dataWthoutId['NewCropPrescription']['id']));
												}else {
													echo $this->Html->image('',array('title'=>'delete','class'=>'deleteMedication','id'=>'deleteMedication_'.$dataWthoutId['NewCropPrescription']['id']));
												}
											//$options_active = array('N'=>'Yes','Y'=>'No');
											//echo $options_active[$dataWthoutId['NewCropPrescription']['archive']];?></td>
										</tr>
									<?php } //}?>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table> 
<?php } 
}else{//for other instance

if($getPreviousMedication){?>
<table class="loading" style="text-align: center; padding: 0px !important;" width="100%">
	<tr>
		<td width="100%" valign="top" align="left" colspan="4">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm">
				<tr>
					<td width="100%" valign="top" align="left" colspan="6">
						<table width="100%" border="0" cellspacing="1" cellpadding="0" id='DrugGroup' style="padding: 0px !important;" class="tabularForm">
							<tr>
								<th  height="20" align="left" valign="top" style="padding-right: 3px;" class="">Drug Name</th>
								<th  align="left" valign="top" class="">Qty</th>
								<th  align="left" valign="top" class="">Received Qty</th>
								<!-- <th  height="20" align="left" valign="top" class="">Strength</th>
								<th  height="20" align="left" valign="top" class="" >Dosage</th>
								<th  align="left" valign="top" class="">Dose Form</th>
								<th  height="20" align="left" valign="top" class="">Route</th>
								<th  align="left" valign="top" class="">Frequency</th>
								<th  align="left" valign="top" class="">Days</th> -->
								<!-- <th  align="left" valign="top" class="">As Needed (p.r.n)</th>
								<th  align="left" valign="top" class="">Dispense As Written</th> -->
								<!-- <th  align="left" valign="top" class="" >First Dose Date/Time</th>
								<th  align="left" 	valign="top" class="" >Stop Date/Time</th> -->
								<!-- <th  align="left" valign="top" class="">Active</th> -->
								<th  align="left" valign="top" class="">Action</th>
							</tr>
							<?php 
							if(isset($getPreviousMedication) && !empty($getPreviousMedication)){
			               		foreach($getPreviousMedication as $s=>$dataMed){ 
								if($dataMed['NewCropPrescription']['pharmacy_sales_bill_id'] && $dataMed['NewCropPrescription']['is_override']== 0)
									$background='paid_payment';
								else if($dataMed['NewCropPrescription']['is_deleted'] == 1)
									$background='pending_payment';
								else if(!empty($dataMed['NewCropPrescription']['pharmacy_sales_bill_id']) && $dataMed['NewCropPrescription']['is_override']== 1)
									$background='changeBackground';
								else 
									$background='';
								?>
			               	<tr id="DrugGroup<?php echo $s;?>"> 
								<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo stripslashes($dataMed['NewCropPrescription']['description']); ?></td>
								
								<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $dataMed['NewCropPrescription']['quantity'];?></td>
								
								<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php //debug($dataMed['NewCropPrescription']);exit;
								if($dataMed['NewCropPrescription']['recieved_quantity']!="" || $dataMed['NewCropPrescription']['recieved_quantity']!=0){
									echo $dataMed['NewCropPrescription']['recieved_quantity'];
								}else{
									echo $dataMed['PharmacySalesBillDetail']['qty'];
								}
								?></td>
								
								<!-- <td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
									$strengthArray=Configure :: read('strength');
									echo $dataMed['NewCropPrescription']['dose'] .', '.$strengthArray[$dataMed['NewCropPrescription']['DosageForm']]; ?></td>
								
								<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $dataMed['NewCropPrescription']['dosageValue'];?></td>
								
	                            <td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
		                            $roopArray=Configure :: read('roop');
		                            echo $roopArray[$dataMed['NewCropPrescription']['strength']];?></td>
	
								<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
									$route_administrationArray=Configure :: read('route_administration');
									echo $route_administrationArray[$dataMed['NewCropPrescription']['route']];?></td>
	
								<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php 
									$frequencyArray=Configure :: read('frequency');
									echo $frequencyArray[$dataMed['NewCropPrescription']['frequency']];?></td>
								 
								<td align="left" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $dataMed['NewCropPrescription']['day'];?></td> -->
	
								<!--  <td align="center" valign="top" class="<?php echo $background;?>"><?php $options = array('1'=>'Yes','0'=>'No');
										echo $options[$dataMed['NewCropPrescription']['prn']];?></td>
	
								<td align="center" valign="top" class="<?php echo $background;?>"><?php echo $options[$dataMed['NewCropPrescription']['daw']];?></td>-->
	
								<!-- <td align="center" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $this->DateFormat->formatDate2Local($dataMed['NewCropPrescription']['firstdose'],Configure::read('date_format'),true);?></td>
	
								<td align="center" valign="top" style="padding-right: 3px" class="<?php echo $background;?>"><?php echo $this->DateFormat->formatDate2Local($dataMed['NewCropPrescription']['stopdose'],Configure::read('date_format'),true);?></td> -->
	
								<!-- <td align="center" valign="top" class="<?php //echo $background;?>"><?php //$options_active = array('N'=>'Yes','Y'=>'No');
									//echo $options_active[$dataMed['NewCropPrescription']['archive']];?></td> -->
										
								<td align="center" valign="top" class="<?php echo $background;?>"><?php
									if((!$dataMed['NewCropPrescription']['pharmacy_sales_bill_id']) && ($dataMed['NewCropPrescription'][is_deleted]==0)){
											echo $this->Html->image('icons/delete-icon.png',array('alt'=>'Delete','title'=>'delete','class'=>'deleteMedication','id'=>'deleteMedication_'.$dataMed['NewCropPrescription']['id']));
									}else{
											echo $this->Html->image('',array('title'=>'delete','class'=>'deleteMedication','id'=>'deleteMedication_'.$dataMed['NewCropPrescription']['id']));
									}?></td>
							</tr>
						<?php } }?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table> 
  
<?php } }?>
 
<?php echo $this->Form->end();?>
<script>

$('.received').on('click',function(){
	var patient_id='<?php echo $patientId;?>';
	//var recID=$('#pharmacySalesBillId').val();
	var currentId=$(this).attr('id');
	var splitedVar=currentId.split('_');
	var recID=splitedVar[1];
	 
	$.ajax({
	  type : "POST",
	  url: "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "updatePharmacyReceived", "admin" => false)); ?>"+'/'+patient_id+'/'+recID,
	  context: document.body,
	  success: function(data){ 
	  window.location.href="<?php echo $this->Html->url(array("controller"=>'Notes',"action" => "addNurseMedication"));?>"+"/"+patient_id+"?from=Nurse";
			$("#busy-indicator").hide();
	  },
	  beforeSend:function(){
  			$("#busy-indicator").show();
	  },		  
	});
});

$('.deleteMedication').on('click',function(){// for deleting the medication whose sale bill is not done 
	
	var currentId=$(this).attr('id');
	var splitedVar=currentId.split('_');
	var recId=splitedVar[1];
	var patient_id='<?php echo $patientId;?>';
	var date='<?php echo $date;?>';
	$.ajax({
		type:"POST",
		url:"<?php echo $this->Html->url(array("controller"=>"Notes","action"=>"deleteMedication"));?>"+"/"+recId+'/'+patient_id+'/'+date,
		context:document.body,
		success:function(data){
			if(data!=''){
   			 $('#previousPriscriptionDiv').html(data);
	     	}
	     	$('#deleteMedication_'+recId).hide();
			$("#busy-indicator").hide();
		},
		beforeSend:function(){
			$("#busy-indicator").show();
		},
	}); 	
});
										
</script>
