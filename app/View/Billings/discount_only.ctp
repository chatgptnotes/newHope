<?php 
echo $this->Html->script(array('jquery.tree'/*,'jquery.validationEngine-en.js'*/));
echo $this->Html->css(array('jquery.tree'/*,'validationEngine.jquery.css'*/));
?>
<style>
body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif !important;
	font-size: 10px !important;
	color: #000000;
}

input,textarea {
	border: 1px solid #999999;
	padding: none !important;
}

label {
	color: #000 !important;
	float: none !important;
	font-size: 13px;
	margin-right: 10px;
	padding-top: 7px;
	text-align: right;
	width: none !important;
}

/*.tdBorderRtBt {
	border-right: 1px solid #3E474A;
	border-bottom: 1px solid #3E474A;
}

.tdBorderBt {
	border-bottom: 1px solid #3E474A;
}

.tdBorderTp {
	border-top: 1px solid #3E474A;
	border-right: 1px solid #3E474A;
}

.tdBorderRt {
	border-right: 1px solid #3E474A;
}

.tdBorderTpBt {
	border-bottom: 1px solid #3E474A;
	border-top: 1px solid #3E474A;
}

.tdBorderTpRt {
	border-top: 1px solid #3E474A;
	border-right: 1px solid #3E474A;
}*/
.ui-widget-content {
	color: #000 !important;
}

ul {
	padding-left: 20px !important;
}

.prntDiv1 {
	float: left;
	padding: 0 5px 0 0;
	width: 45%;
}

.prntDiv2 {
	float: left;
	padding: 0px 3px 0px 0px;
	width: 6%;
}

.prntDiv3 {
	float: left;
	padding: 0 0 0 4px;
	width: 5%;
}

.prntDiv4 {
	float: left;
	padding: 0 0 0 13px;
	width: 7%;
}

.prntDiv5 {
	float: left;
	width: 7%;
}

.prntDiv6 {
	float: left;
	padding: 0 0 0 6px;
	width: 8%;
}

.prntDiv7 {
	float: left;
	width: 8%;
}

.chldDiv1 {
	float: left;
	padding: 0 6px 0 0;
	width: 45%;
}

.chldDiv2 {
	float: left;
	width: 6%;
	padding: 0px 4px 0px 0px;
}

.chldDiv3 {
	float: left;
	padding: 0 5px 0 0;
	width: 5%;
}

.chldDiv4 {
	float: left;
	padding: 0 3px 0 0;
	width: 8%;
}

.chldDiv5 {
	float: left;
	padding: 0 0 0 2px;
	width: 7%;
}

.chldDiv6 {
	float: left;
	padding: 0 8px 0 0;
	width: 8%;
}

.chldDiv7 {
	float: left;
	padding: 0 10px 0 0;
	width: 6%;
}

.leaf {
	clear: both;
}

.expanded {
	clear: both;
}

.collapsed {
	clear: both;
}

#ui-datepicker-div {
	width: 190px;
}
</style>
<script type="text/javascript">
        $(document).ready(function() {
        		var patientIsVIP='<?php echo $patient['Person']['vip_chk'];?>';
        		if(patientIsVIP=='1'){
        			 $("#show_percentage").show();
        			 $("input[type='radio'][name='data[Billing][discount_type]'][value='Percentage']").attr('checked',true);
        			 $('#discount').removeAttr("disabled");
        			 $('#discount').show();$('#discount').val("100"); 
        			 $('#totalamountpending').val('0');
        			 $('#mode_of_payment').removeClass('validate[required,custom[mandatory-select]]');
        			 $("#mandatoryModeOfPayment").hide();
        		}else{
        			$('#discount').hide();$('#discount').val('');
        		}

            $('#tree').tree({
                /* specify here your options */
            }); 
            var tree10 = $.daredevel.tree();
			$('#collapse-all').click(function(){ 
				tree10.collapseAll(0);
			});
			$('#expand-all').click(function(){ 
				tree10.expandAll(0);
			});

			$('#collapse-all').trigger('click') ;  
                      
        });
</script>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php  echo 'Discount/Refund - <font color="#1A35D5">' .$patient['Patient']['lookup_name'].' '.$patient['Patient']['patient_id'].' ('.$tariffData[$patient['Patient']['tariff_standard_id']].')</font>'; ?>
	</h3>
	<span style="float: right"> <?php echo $this->Html->link('Back',array('controller'=>'Accounting','action'=>'patient_card_list'),
				array('class'=> 'blueBtn','id'=>'backToIpd','escape' => false,'label'=>false,'div'=>false));?>

	 <?php echo $this->Html->link('Back To OPD',array('controller'=>'Billings','action'=>'multiplePaymentModeIpd',$patient['Patient']['id']),
				array('class'=> 'blueBtn','id'=>'backToIpd','escape' => false,'label'=>false,'div'=>false));?>

	</span>
	<div style="clear: both; padding: 10px 0px 10px 25px">
		<?php 
		echo $this->element('admission_search');
		?>
	</div>
</div>
<div class="clr ht5"></div>
<?php 	
$qryStr=$this->params->query;
echo $this->Form->create('billings',array('url'=>array('controller'=>'billings','action'=>'discount_only',$patient['Patient']['id'],'?'=>$qryStr),
		'inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)));
	echo $this->Form->hidden('Billing.patient_id',array('value'=>$patient['Patient']['id']));
	echo $this->Form->hidden('Billing.bill_number',array('value'=>$billNumber));
	echo $this->Form->hidden('Billing.tariff_id',array('value'=>$tariffStdData['Patient']['tariff_standard_id']));
	echo $this->Form->hidden('Billing.appoinment_id',array('value'=>$appoinmentID));
	echo $this->Form->hidden('payOnlyAmount',array('value'=>$totalPaymentFlag));
	if($corporateEmp!=''){
			$hideCGHSCol = '';
			if(strtolower($corporateEmp) == 'private'){
				$hideCGHSCol = "display: none";
			}
	}
	$hospitalType = $this->Session->read('hospitaltype');
	if($hospitalType == 'NABH'){
  		$nabhKey = 'nabh_charges';
  		$nabhKeyC = 'cghs_nabh';
	}else{
		$nabhKey = 'non_nabh_charges';
		$nabhKeyC = 'cghs_non_nabh';
	}

	?>
<a id='collapse-all' href='javascript:void(0);' class='blueBtn'>
	Collapse All
</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a id='expand-all' href='javascript:void(0);' class='blueBtn'>
	Expand All
</a>
<div
	style="max-width: 1100px; border: 1px solid black">
	<div style="clear: both; width: 100%;">
		<div align="center" class="tdBorderBt"
			style="float: left; height: 32px;">&nbsp;</div>
		<div align="center" class="tdBorderRtBt"
			style="float: left; width: 45%; height: 32px;">Item</div>
		<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
		<div style="float: left; width: 6%; height: 32px;" align="center"
			class="tdBorderRtBt">
			<?php echo $patient['TariffStandards']['name'];?>
			MOA Sr. No.
		</div>
		<?php }?>
		<div style="<?php echo $hideCGHSCol ;?>; float: left;  width: 5%; height: 32px;" align="center" class="tdBorderRtBt" >CGHS
			Code No.</div>
		<div style="float: left; width: 8%; height: 32px;" align="center"
			class="tdBorderRtBt">Rate</div>
		<div style="float: left; width: 7%; height: 32px;" align="center"
			class="tdBorderRtBt">Qty.</div>
		<div style="float: left; width: 8%; height: 32px;" align="center"
			class="tdBorderRtBt">Amount</div>
		<div style="float: left; width: 9%; height: 32px;" align="center"
			class="tdBorderBt">Discount Amount</div>
		<div style="float: left; width: 9%; height: 32px;" align="center"
			class="tdBorderBt">Amount After Discount</div>
	</div>
	<div style="width: 100%">
		<div id="tree"
			style="max-height: 250px; overflow: scroll; clear: both; float: left; width: 100%;">
			<div>
				<?php echo 'Select All '.$this->Form->input('Billing.Select All',array('type'=>'checkbox','id'=>"select",'class'=>'select_all',"style"=>"float: left"));?>
			</div>

			<?php $srNo=0;?>
			<?php if($patient['Patient']['payment_category']!='cash'){?>
			<div>
				<div align="center" class="tdBorder" style="float: left;">&nbsp;</div>
				<div class="prntDiv1">
					<strong><i>Conservative Charges</i> </strong><span
						id="firstConservativeText"></span>
				</div>
				<div align="center" class="prntDiv2">&nbsp;</div>
				<div align="center" class="prntDiv3" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
				<div align="center" class="prntDiv4">&nbsp;</div>
				<div align="center" class="prntDiv5">&nbsp;</div>
				<div align="right" valign="top" class="prntDiv6">
					<strong>&nbsp;</strong>
				</div>
				<div align="center" class="prntDiv7">&nbsp;</div>
				<!--  <td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong></td>  -->
			</div>
			<br>
			<?php $lastSection='Conservative Charges';?>
			<?php }?>

			<ul>
				<!-- Start of Main UL -->
				<?php 
				foreach($serviceCategory as $serviceKey=>$category){
						   	if($category==Configure::read('Consultant')){
								if(!empty($cCArray) || !empty($cDArray)){
									$consultantCost=0;$phyCost=0;$phyAdv=0;$consultantAdv=0;$consultantDiscount=0;$phyDiscount=0;
									$consultantServiceId =$serviceKey;
									foreach ($cCArray as $Ckey=>$cBilling){
										foreach($cBilling as $CBillKey=>$consultantBillingDta){
											foreach($consultantBillingDta as $conKey=>$consultantBilling){
												foreach($consultantBilling as $singleKey=>$singleData){
													//checkBox value contains amount amt*qty
													$consultantCost = $consultantCost+$singleData['ConsultantBilling']['amount'];
													//Service wise amount paid calculations- Pooja
													$consultantAdv=$consultantAdv+$singleData['ConsultantBilling']['paid_amount'];
													$consultantDiscount=$consultantDiscount+$singleData['ConsultantBilling']['discount'];
													$cCArray[$Ckey][$CBillKey][$conKey][$singleKey]['ConsultantBilling']['enddate'] =$this->DateFormat->formatDate2Local($singleData['ConsultantBilling']['date'],Configure::read('date_format'),false);
													$cCArray[$Ckey][$CBillKey][$conKey][$singleKey]['ConsultantBilling']['date']=$this->DateFormat->formatDate2Local($singleData['ConsultantBilling']['date'],Configure::read('date_format'));
												}
											}
										}
									}
									if(!empty($cDArray)){
										foreach ($cDArray as $Ckey=>$cBilling){
											foreach($cBilling as $CBillKey=>$consultantBillingDta){#pr($consultantBilling);
												foreach($consultantBillingDta as $conKey=>$consultantBilling){//debug($consultantBilling);
													foreach($consultantBilling as $singleKey=>$singleData){
														$phyCost=$phyCost+$singleData['ConsultantBilling']['amount'];
														//Service wise amount paid calculations- Pooja
														$phyAdv=$phyAdv+$singleData['ConsultantBilling']['paid_amount'];
														$phyDiscount=$phyDiscount+$singleData['ConsultantBilling']['discount'];
														$cDArray[$Ckey][$CBillKey][$conKey][$singleKey]['ConsultantBilling']['enddate'] =$this->DateFormat->formatDate2Local($singleData['ConsultantBilling']['date'],Configure::read('date_format'),false);
														$cDArray[$Ckey][$CBillKey][$conKey][$singleKey]['ConsultantBilling']['date']=$this->DateFormat->formatDate2Local($singleData['ConsultantBilling']['date'],Configure::read('date_format'));
													}
												}
											}
										}
									}
									$totalCostConsultant=$consultantCost+$phyCost;
									$totalBalCon=$totalCostConsultant-($consultantAdv+$phyAdv);
									$consultPaid=$consultantAdv+$phyAdv;
									//Deducting the total paid and discount amuont from total service amount
									$class='';
									$conDis=$phyDiscount+$consultantDiscount;
									if($consultPaid!='0' && $consultPaid>0){
											$class='chk_parent_paid';
									 }else{
										if(!empty($conDis))
											$class='reset_dis';
									}

								if(!empty($totalCostConsultant) || $totalCostConsultant !=0){?>

				<li>
					<div>
						<div align="center" class="tdBorder" style="float: left;">
							<?php echo $this->Form->input('Billing.consultant_charges',array('type'=>'checkbox','id'=>"consultant_$consultantServiceId",'class'=>'chk_parent '.$class,'value'=>$totalCostConsultant-($consultPaid+$conDis)));?>
						</div>
						<div class="tdBorderRt prntDiv1">
							<?php	echo $serviceCategoryName[$serviceKey];?>
							<?php $v++;
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][name]",'value' => "consultant_charges",'legend'=>false,'label'=>false));
							?>
							<br>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center" class="tdBorderRt prntDiv2">&nbsp;</div>
						<?php }?>
						<div align="center" class="tdBorderRt prntDiv3" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<div align="center" valign="top" class="tdBorderRt prntDiv4">
							<?php
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][consultant_rate]",'value' => $this->Number->format($totalCostConsultant,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
							echo $totalCostConsultant;
							$this->Number->format($totalCostConsultant,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
							?>
						</div>
						<div align="center" valign="top" class="tdBorderRt prntDiv5">
							<?php 
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
							echo '--';
							?>
						</div>

						<div align="center" valign="top" class="tdBorderRt prntDiv6">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][consultant_amount]",'value' => $this->Number->format($totalCostConsultant,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
							echo $this->Number->format($totalCostConsultant);
							?>
						</div>
						<div align="center" valign="top" class="prntDiv7">
							<?php echo round($conDis); ?>
						</div>
						<div align="center" valign="top" class="prntDiv7">
							&nbsp;
							<!--<?php if(!empty($consultPaid)){
						$conPaid=$consultPaid;
					}else{
						$conPaid=$totalCostConsultant-$conDis;
					}?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][consultant_paid_amount]",'class'=>'paid_parent_consultant_'.$consultantServiceId,'value' => round($conPaid),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($conPaid);
						?>-->
						</div>
					</div> <br>
					<ul>
						<?php 
						echo consultantHtml($patient,$cCArray,$this->Form,$this->Number,$consultantServiceId,$hideCGHSCol);
						echo physicianHtml($patient,$cDArray,$this->Form,$this->Number,$consultantServiceId,$hideCGHSCol);
						?>
						<!--  Function of Consultant for html Pooja -->

					</ul> <!--EOF Consultant Charges  --> <?php } 
							}
							?>
				</li>
				<!--EOF Consultant Charges LI -->
				<?php } // EOF if Consultation ?>

				<!-- Ward Charges -->
				<?php 
				if($patient['Patient']['admission_type']=='IPD'){
							$totalWardNewCost=0;
							$totalNewWardCharges=0;
							if(is_array($wardServicesDataNew)){
								if($category==Configure::read('surgeryservices')){
									$totalSurgeryCost=0;$surgeryAdv=0;
									$surgeryServiceId =$serviceKey;$totalOtServiceCharge = 0;
									foreach($wardServicesDataNew as $key=>$uniqueSlot){
										$surgeryNameKey = key($uniqueSlot);
										if($surgeryNameKey =='start'){

											if($this->Session->read('website.instance') == 'kanpur'){
												foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
													$totalOtServiceCharge = $totalOtServiceCharge + $charge;
												}
											}
											$surgeriesData[$key]['start']=$this->DateFormat->formatDate2Local($uniqueSlot['start'],Configure::read('date_format'),false);
											$surgeriesData[$key]['end']= $this->DateFormat->formatDate2Local($uniqueSlot['end'],Configure::read('date_format'),false);
											$totalSurgeryCost = $totalSurgeryCost + $uniqueSlot['cost']+$uniqueSlot['surgeon_cost']+$uniqueSlot['asst_surgeon_one_charge']+
											$uniqueSlot['asst_surgeon_two_charge']+$uniqueSlot['anaesthesist_cost']+$uniqueSlot['cardiologist_charge']+$uniqueSlot['ot_assistant']+
											$uniqueSlot['ot_charges']+$uniqueSlot['extra_hour_charge'] + $totalOtServiceCharge;
											$surgeryAdv=$surgeryAdv+$uniqueSlot['paid_amount'];
											$surDiscount=$surDiscount+round($uniqueSlot['discount']);
										}
										$totalOtServiceCharge=0;
								}

								if($surgeryAdv<=0){
									if(!empty($surDiscount))
										$classSur=' reset_dis';
								}

								if(!empty($totalSurgeryCost) || $totalSurgeryCost!=0){?>
				<li>
					<div>
						<div align="center" class="tdBorder" style="float: left;">
							<?php echo $this->Form->input('Billing.surgery_charges',array('type'=>'checkbox','id'=>"surgery_$surgeryServiceId",'class'=>'chk_parent '.$classSur,'value'=>$totalSurgeryCost-($surgeryAdv+$surDiscount)));?>
						</div>
						<div class="tdBorderRt prntDiv1">

							<?php echo $serviceCategoryName[$serviceKey];//Surgery Charges
						$v++;
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][name]",'value' => "surgery_charges",'legend'=>false,'label'=>false));
						?>
							<br>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center" class="tdBorderRt prntDiv2">&nbsp;</div>
						<?php }?>
						<div align="center" class="tdBorderRt prntDiv3" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<div align="center" valign="top" class="tdBorderRt prntDiv4">
							<?php
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' => $totalSurgeryCost,'legend'=>false,'label'=>false,'id' => 'clinical_rate','style'=>'text-align:right;'));
							echo $totalSurgeryCost;
							?>
						</div>
						<div align="center" valign="top" class="tdBorderRt prntDiv5">
							<?php 
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
							echo '--';
							?>
						</div>

						<div align="center" valign="top" class="tdBorderRt prntDiv6">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][surgery_amount]",'value' => $totalSurgeryCost,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
							echo $totalSurgeryCost;
							//echo $this->Number->format($lCost) ;
							?>
						</div>
						<div align="center" valign="top" class="prntDiv7">
							<?php echo round($surDiscount);
							?>
						</div>
						<div align="center" valign="top" class="prntDiv7">
							&nbsp;
							<!--<?php if(!empty($surgeryAdv)){
							$surgeryPaid=$surgeryAdv;
						}else{
							$surgeryPaid=$totalSurgeryCost-$surDiscount;
						}?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][surgery_paid_amount]",'class'=>'paid_parent_surgery_'.$surgeryServiceId,'value' => round($surgeryPaid),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
							  echo round($surgeryPaid);
						//echo $this->Number->format($lCost) ;
						?>-->
						</div>
					</div> <br>
					<ul>
						<?php
								echo surgeryHtml($patient,$wardServicesDataNew,$this->Form,$this->Number,$surgeryServiceId,$hideCGHSCol,$this->Session->read('website.instance'));?>
					</ul>
				</li>
				<!--  surgery -->
				<?php }
						}// EOF surgery Category?>
				<?php if($category==Configure::read('RoomTariff')){
					$wardServiceId =$serviceKey;
					$wardCharges=0;
					/*foreach($wardServicesDataNew as $roomCharges){
					 if(!isset($roomCharges['name'])){
										$wardNameKey = key($roomCharges);
										$daysCountPerWard=count($roomCharges[$wardNameKey]);
										$wardCharges=$wardCharges+($roomCharges[$wardNameKey][0]['cost']*$daysCountPerWard);
										$wardRow[$wardNameKey]['name']=$wardNameKey;
										$wardRow[$wardNameKey]['ward_id'] = $roomCharges[$wardNameKey][0]['ward_id'];
										$wardRow[$wardNameKey]['days']=$wardRow[$wardNameKey]['days']+$daysCountPerWard;
										$wardRow[$wardNameKey]['rate']=$roomCharges[$wardNameKey][0]['cost'];
										if(empty($wardRow[$wardNameKey]['in']))
										$wardRow[$wardNameKey]['in']=$roomCharges[$wardNameKey][0]['in'];
										if(!empty($roomCharges[$wardNameKey][$daysCountPerWard-1]['out'])){
											$wardRow[$wardNameKey]['out']=$roomCharges[$wardNameKey][$daysCountPerWard-1]['out'];
										}

								}
							}*/foreach($wardNew['day'] as $roomKey=>$roomCost){
									$bedCharges[$g][$roomCost['ward']]['bedCost'][] = $roomCost['cost'] ;
									$bedCharges[$g][$roomCost['ward']][] = array('ward_id'=>$roomCost['ward_id'],'out'=>$roomCost['out'],
																				 'in'=>$roomCost['in'],'moa_sr_no'=>$roomCost['moa_sr_no'],'discount'=>$roomCost['discount'],
																				 'cghs_code'=>$roomCost['cghs_code'],'paid_amount'=>$roomCost['paid_amount']);
									if($roomTariff['day'][$roomKey+1]['ward']!=$roomCost['ward']){
										$g++;
									}
								}

								$r=0;
								foreach($bedCharges as $bedKey=>$bedCost){
									if($wardRow[$r]['name']!=key($bedCost)){
										$r++ ;

									}
									$wardNameKey=key($bedCost);
									$wardRow[$r]['name']= $wardNameKey;
									$wardNameKey = key($bedCost);
									$bedCost= $bedCost[$wardNameKey];
									$wardRow[$r]['ward_id']=$bedCost[0]['ward_id'];
									$wardCost += array_sum($bedCost['bedCost']) ;
									$splitDateIn = explode(" ",$bedCost[0]['in']);

									if(count($bedCost)==2 && $bedCost[0]['in']== $bedCost[0]['out']){
										//if(!is_array($bedCharges[$bedKey+1])){
										$nextDay = date('Y-m-d H:i:s',strtotime($splitDateIn[0]));
										$lastKey = array('out'=>$nextDay) ;
										/*}else{
										 $nextElement = $bedCharges[$bedKey+1] ;
										 $nextElementKey = key($nextElement);
										 $lastKey  = $nextElement[$nextElementKey][0] ;
										 }*/
									}else{
										$lastKey  = end($bedCost) ;
									}
									$splitDateOut = explode(" ",$lastKey['out']);
									//if($t==0){$t++;


									if(!empty($bedCost[0]['in'])){
										$wardIn[$r]['wardIn'][]=$inDate= $this->DateFormat->formatDate2Local($bedCost[0]['in'],Configure::read('date_format'),false);
										$wardOut[$r]['wardOut'][]=$outDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),false);
									}else{
										$wardIn[$r]['wardIn'][]=$inDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),false);
										$wardOut[$r]['wardOut'][]=$outDate= $this->DateFormat->formatDate2Local($lastKey['out'],Configure::read('date_format'),false);
									}
									$wardRow[$r]['cghs_code']=$bedCost[0]['cghs_code'];
									$wardRow[$r]['moa_sr_no']= $bedCost[0]['moa_sr_no'];
									$wardRow[$r]['days']=$wardRow[$r]['days']+count($bedCost['bedCost']);
									$wardRow[$r]['rate']=$bedCost['bedCost']['0'];
									$wardRow[$r]['in']=$wardIn[$r]['wardIn']['0'];
									$wardRow[$r]['out']=$wardOut[$r]['wardOut'][count($wardOut[$r]['wardOut'])-1];
									$wardRow[$r]['paid_amount']=$wardRow[$r]['paid_amount']+$bedCost[0]['paid_amount'];
									$wardRow[$r]['discount']=$bedCost[0]['discount'];
									$wardAdv=$wardAdv+$bedCost[0]['paid_amount'];
									$wardDis=$wardDis+$bedCost[0]['discount'];

								}
								$wardCharges=$wardCost;
								/*foreach($wardRow as $wardrCost){debug($wardrCost);
								 $wardCharges=$wardCost;
										//$wardCharges=$wardCharges+($wardCost['days']*$wardCost['rate']);
										//$wardAdv=$wardAdv;//-$wardCost['discount'];
										$wardDis=$wardDis+$wardrCost['discount'];
								}*/
								$classRoom='';$divClass='';
								$wardAmt=$wardCharges-round($wardAdv+$wardDis);
								if($wardAmt<=0){
									$pharDisable="disabled";
									$classRoom=' chk_parent_paid refund_amt';
									$divClass=' paid_payment';
								}else{
									$classRoom=' chk_parent ';//exclude_discount
								}

								if($wardDis){
									$classRoom.=' discount_excluded';

								}

								if($wardAdv <=0){
									if(!empty($wardDis))
										$classRoom.=' reset_dis';
								}

								/*if($wardAdv!='0' || $wardAdv>0){
									$classRoom='chk_parent_paid  refund_amt';//exclude_discount
								}else{
									$classRoom='chk_parent ';//exclude_discount
								}*/
								if(!empty($wardCharges) || $wardCharges!=0){
						?>
				<li><div>
						<div align="center" class="tdBorder" style="float: left;">
							<?php echo $this->Form->input('Billing.'.$category.'.'.$serviceKey.'.'.'valChk',array('type'=>'checkbox','id'=>"ward_$wardServiceId",'class'=>'service_'.$wardServiceId.$classRoom,'value'=>$wardCharges-($wardAdv+$wardDis)));?>
						</div>
						<div class="<?php echo "prntDiv1 tdBorderRt $divClass";?>">

							<?php echo $serviceCategoryName[$serviceKey];//Room Tariff
						$v++;
						echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][name]",'value' => "ward_charges",'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][service_id]",'value' =>$serviceKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][id]",'value' =>$serviceKey,'legend'=>false,'label'=>false));
						?>
							<br>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center"
							class="<?php echo "prntDiv2 tdBorderRt $divClass";?>">&nbsp;</div>
						<?php }?>
						<div align="center" class="<?php echo "prntDiv3 tdBorderRt $divClass";?>" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv4 tdBorderRt $divClass";?>">
							<?php
							echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][rate]",'value' => $wardCharges,'legend'=>false,'label'=>false,'id' => 'ward_rate','style'=>'text-align:right;'));
							echo $wardCharges;
							//echo $this->Number->format($lCost) ;
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv5 tdBorderRt $divClass";?>">
							<?php 
							echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
							echo '--';

							?>
						</div>

						<div align="center" valign="top"
							class="<?php echo "prntDiv6 tdBorderRt $divClass";?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][amount]",'value' =>$wardCharges,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
							echo $wardCharges;
							//echo $this->Number->format($lCost) ;
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7 $divClass";?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][discount]",'class'=>'ward_discount_'.$wardServiceId,'value' => $wardDis,'legend'=>false,'label'=>false,'style'=>'text-align:right'));?>
							<span class="<?php echo 'ward_discount_'.$wardServiceId?>"><?php echo round($wardDis);?>
							</span>

						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7 $divClass";?>">
							<?php if(!empty($wardAdv)){
								$wardPaid=$wardAdv;
							}else{
						$wardPaid=$wardCharges-$wardDis;
					}
					echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][paid_amount]",'class'=>'paid_parent_ward_'.$wardServiceId.' ward_paid_'.$wardServiceId,'value' => round($wardPaid),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					echo '<span class=ward_paid_'.$wardServiceId.'>'.round($wardPaid).'</span>';
					/*echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][paid_amount]",'class'=>'paid_parent_ward_'.$wardServiceId,'value' => $wardPaid,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($wardPaid);*/
					?>
						</div>
					</div> <br>
					<ul>
						<?php 
						$hospitalType = $this->Session->read('hospitaltype');
								//echo roomHtml($patient, $wardRow, $this->Form, $this->Number,$hospitalType,$wardServiceId,$hideCGHSCol);?>
					</ul> <!-- Ward Charges ul -->
				</li>
				<!-- Ward Charges Li -->
				<?php }// if($wardCharges)
				}
						 }//EOF Ward category
          			} // end Of If (IPD)?>

				<!-- EOF Ward charges -->

				<?php 
				if($category==Configure::read('mandatoryservices')){
			    			$mandatoryKey =$serviceKey;
			    			#pr($nursingServices);exit;
			    			$hospitalType = $this->Session->read('hospitaltype');
			    			$serviceListArray=array();
			    			$serviceListCountArray=array();
			    			//$v++;
			    			$k=0;$totalNursingCharges=0;

			    			//BOF pankaj- reset array to service as main key
			    			$ng=0;$nt=0;
			    			if($hospitalType == 'NABH'){
									 $nursingServiceCostType = 'nabh_charges';
							  	}else{
							  		 $nursingServiceCostType = 'non_nabh_charges';
							  		 	
							  	}
							  	$nursingCnt = 0;$manCnt=0;$totalMandatoryServiceCharge=0;//echo '<pre>';print_r($nursingServices);

							  	if($patient['Patient']['admission_type']=='IPD'){
								$doct=$doctorCharges;
								$nurs=$nursingCharges;
			  			}
			  			//if doctor charges and nursing charges are empty the do not show these servivecs
			  			if(!empty($nursingCharges) && !empty($doctorCharges)){
			  				$doctNurseShow='1';
			  			}
			  			$nursFlag=0;$doctFlag=0;
			  			foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){
							/*if($nursingServicesCost['ServiceBill']['service_id']==$Clinicalkey) {
								$resetNursingServices[$nursingCnt]['qty'] = $nursingServicesCost['ServiceBill']['no_of_times'];
								$resetNursingServices[$nursingCnt]['name'] = $nursingServicesCost['TariffList']['name'] ;
								$resetNursingServices[$nursingCnt]['cost'] = $nursingServicesCost['ServiceBill']['amount'];
								$resetNursingServices[$nursingCnt]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
								$resetNursingServices[$nursingCnt]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code'];
								$resetNursingServices[$nursingCnt]['tariff_list_id'] = $nursingServicesCost['TariffList']['id'];
								$totalServiceCharge=$totalServiceCharge+($nursingServicesCost['ServiceBill']['no_of_times']*$nursingServicesCost['ServiceBill']['amount']);
								$nursingCnt++;
							}*/
							if($nursingServicesCost['ServiceBill']['service_id']==$mandatoryKey) {
								$resetMandatoryServices[$manCnt]['service_bill_id'] = $nursingServicesCost['ServiceBill']['id'];
								$resetMandatoryServices[$manCnt]['paid_amount'] = $nursingServicesCost['ServiceBill']['paid_amount'];
								$resetMandatoryServices[$manCnt]['qty'] = $nursingServicesCost['ServiceBill']['no_of_times'];
								$resetMandatoryServices[$manCnt]['name'] = $nursingServicesCost['TariffList']['name'] ;
								$resetMandatoryServices[$manCnt]['cost'] = $nursingServicesCost['ServiceBill']['amount'];
								$resetMandatoryServices[$manCnt]['discount'] = $nursingServicesCost['ServiceBill']['discount'];
								$resetMandatoryServices[$manCnt]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
								$resetMandatoryServices[$manCnt]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code'];
								$resetMandatoryServices[$manCnt]['tariff_list_id'] = $nursingServicesCost['TariffList']['id'];
								$totalMandatoryServiceCharge=$totalMandatoryServiceCharge+($nursingServicesCost['ServiceBill']['amount']*$nursingServicesCost['ServiceBill']['no_of_times']);
								if($tariffNurseListId==$nursingServicesCost['ServiceBill']['tariff_list_id']){
										$nursFlag=1;
								}
								if($tariffDoctorId==$nursingServicesCost['ServiceBill']['tariff_list_id']){
										$doctFlag=1;
									}
									$mandatoryAdv=$mandatoryAdv+$nursingServicesCost['ServiceBill']['paid_amount'];
									$manDiscount=$manDiscount+round($nursingServicesCost['ServiceBill']['discount']);
									$manCnt++;
							}
		   				}
		   				if($doctFlag==0){
							$totalMandatoryServiceCharge=$totalMandatoryServiceCharge+$doct;
						}

						if($nursFlag==0){
							$totalMandatoryServiceCharge=$totalMandatoryServiceCharge+$nurs;
						}
						if(empty($nursingServices)){
							$totalMandatoryServiceCharge=$doct+$nurs;
						}

						$mandatoryAdv=$mandatoryAdv+$doctorPaidCharges+$nursePaidCharges;
						/*if($mandatoryAdv==0 || $mandatoryAdv<0){
							//$disable='disabled';
							//$class='chk_parent_mandatory'	;
							$class='chk_parent';
							//$divClass='pending_payment';

						}else{
							$disable='disabled';
							$class='chk_parent_paid'	;
							$divClass='paid_payment';
						}*/$class='';
							if($mandatoryAdv!='0' || $mandatoryAdv>0){// paid amount is not zero
								$class='chk_parent_paid';
							}else{
								if(!empty($manDiscount))
									$class.=' reset_dis';
							}

							//$totalMandatoryServiceCharge=$totalMandatoryServiceCharge+$doct+$nurs;
							if(!empty($totalMandatoryServiceCharge) || $totalMandatoryServiceCharge!=0){
					   		?>

				<!-- Mandatory  Services -->
				<li>
					<div>
						<div align="center" class="tdBorder" style="float: left;">
							<?php echo $this->Form->input('Billing.mandatory_charges',array('type'=>'checkbox',
						'id'=>"mandatory_$mandatoryKey",'class'=>"chk_parent $class",'value'=>$totalMandatoryServiceCharge-($mandatoryAdv+$manDiscount+$doctorDiscount+$nurseDiscount)));?>
						</div>
						<div class="<?php echo "tdBorderRt prntDiv1 pending_payment" ?>">

							<?php echo $serviceCategoryName[$serviceKey]; //Mandatory Services
						 $v++;
						 echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][name]",'value' => "Mandatory Charges",'legend'=>false,'label'=>false));
						 ?>
							<br>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center"
							class="<?php echo "tdBorderRt prntDiv2 pending_payment" ?>">&nbsp;</div>
						<?php }?>
						<div align="center" class="<?php echo "tdBorderRt prntDiv3 pending_payment" ?>" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<div align="center" valign="top"
							class="<?php echo "tdBorderRt prntDiv4 pending_payment" ?>">
							<?php
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' => $totalMandatoryServiceCharge,'legend'=>false,'label'=>false,'id' => 'mandatory_rate','style'=>'text-align:right;'));
							echo $totalMandatoryServiceCharge;
							//echo $this->Number->format($lCost) ;
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "tdBorderRt prntDiv5 pending_payment" ?>">
							<?php 
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
							echo '--';

							?>
						</div>

						<div align="center" valign="top"
							class="<?php echo "tdBorderRt prntDiv6 pending_payment" ?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' =>$totalMandatoryServiceCharge,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
							echo $totalMandatoryServiceCharge;
							//echo $this->Number->format($lCost) ;
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7 pending_payment" ?>">
							<?php echo round($manDiscount+$doctorDiscount+$nurseDiscount);
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7 pending_payment" ?>">
							&nbsp;
							<!--<?php if(!empty($mandatoryAdv)){
									$manPaid=$mandatoryAdv;
							}else{
								$manPaid=$totalMandatoryServiceCharge-($manDiscount+$doctorDiscount+$nurseDiscount);
							}?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][paid_amount]",'class'=>'paid_parent_mandatory_'.$mandatoryKey,'value' => round($manPaid),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($manPaid);
						?>-->
						</div>
					</div> <br>
					<ul>
						<?php 	echo mandatoryHtml($patient, $resetMandatoryServices, $this->Form, $this->Number,$mandatoryKey, $hideCGHSCol,$doctorChargesData,$doctorRate,$totalWardDays,$nursingChargesData,$nursingRate,$tariffNurseListId,$tariffDoctorId,$doctNurseShow,$doctorPaidCharges,$nursePaidCharges,$doctorDiscount,$nurseDiscount);?>
					</ul> <!-- Clinical Summary UL end -->
				</li>
				<!-- Clinical Summary Li end -->
				<!-- EOF Mandatory Services -->
				<?php }

			   		}
			   		?>
				<!-- Pharmacy Charges -->


				<?php 
				if($category==Configure::read('Pharmacy')){
				$pharmaConfig='yes';
				$pharmacyKey =$serviceKey;
				if($pharmacyPaidData['0'][0]['total'] !='' && $pharmacyPaidData['0'][0]['total']!=0){
						?>
				<li><?php //debug($pharmacyPaidData);
						$divClass='';

						if($pharmacyPaidData['0'][0]['paid_amount']){
							$pharmacyAdv=$pharmacyPaidData['0'][0]['paid_amount']-$pharmacyReturnPaid['pharmacy']['0']['total'];//-$pharmacyPaidData['0'][0]['discount']);
						}
						$pharDiscount=($pharmacyPaidData['0'][0]['discount']-$pharmacyreturnData['0']['0']['total_discount']);
						$pharCost=($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']);$pharDisable='';
						if($pharmacyAdv > 0 || $pharDiscount == $pharCost){
							$pharDisable="disabled";
							$class=' exclude_discount';//  refund_amt '; we will never refund pharmacy amount as we will always refund sales return amount -pooja
							$divClass='paid_payment';
						}else{
							$class='chk_parent exclude_discount ';//
							$divClass=' pending_payment';
						}

						if($pharmacyPaidData['0'][0]['discount']){
							$class.=' discount_excluded ';

						}

						if($pharmacyAdv+$pharDiscount != $pharCost){
							$class.=' chk_parent phar_dis ';
							$divClass=' pending_payment';
						}else{
							$class.=' chk_parent_paid ';
						}


						$srNo++;	?>
					<div>
						<div align="center" class="<?php echo "tdBorder";?>"
							style="float: left;">
							<?php echo $this->Form->input("Billing.Pharmacy.".$serviceKey.".valChk",array('type'=>'checkbox','id'=>'pharmacy_'.$pharmacyKey,'class'=>"$class service_".$pharmacyKey,'value'=>$pharCost-($pharmacyAdv+$pharDiscount),'label'=>false));?>
						</div>
						<div class="<?php echo "prntDiv1 tdBorderRt $divClass";?>">
							<?php echo $serviceCategoryName[$serviceKey];//Pharmacy Charges
						$v++;
						echo '&nbsp;'.$this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][editAmt]",'id'=>'phar_'.$serviceKey,'class'=>'textAmt','value' =>$pharCost,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][id]",'value' =>$pharmacyKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][service_id]",'value' =>$pharmacyKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][name]",'value' => "Pharmacy Charges",'legend'=>false,'label'=>false));
						?>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center"
							class="<?php echo "prntDiv2 tdBorderRt $divClass";?>">&nbsp;</div>
						<?php }?>
						<div align="center" class="<?php echo "prntDiv3 tdBorderRt $divClass";?>" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv4 tdBorderRt $divClass";?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][rate]",'value' => $this->Number->format(round($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']/*-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							echo $this->Number->format(round($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']));
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv5 tdBorderRt $divClass";?>">
							<?php 	
							echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
							echo '--';
							?>
						</div>

						<div align="center" valign="top"
							class="<?php echo "prntDiv6 tdBorderRt $divClass";?>">
							<?php 
							echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][amount]",'value' => $this->Number->format(round($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']/*-$pharmacyAdv-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							//echo $this->Number->format(round($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
							echo $this->Number->format(round($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']/*-$pharmacyPaidAmount*/));
									//echo $this->Number->format($pharmacyPaidData['0'][0]['total'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7  $divClass";?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][discount]",'class'=>'pharmacy_discount_'.$pharmacyKey,'value' => $pharDiscount,'legend'=>false,'label'=>false));
							echo '<span class=pharmacy_discount_'.$pharmacyKey.'>'.round($pharDiscount).'</span>';
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7  $divClass";?>">
							<?php if(!empty($pharmacyAdv)){
							 $pharPaid=$pharmacyAdv;
							}else{
								$pharPaid=$pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']-$pharDiscount;
						}
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][paid_amount]",'class'=>'paid_parent_pharmacy_'.$pharmacyKey.' pharmacy_paid_'.$pharmacyKey,'value' => round($pharPaid),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						echo '<span class=pharmacy_paid_'.$pharmacyKey.'>'.round($pharPaid).'</span>';
						?>
						</div>
					</div> <br>
					<ul>
						<!-- Pharmacy data  -->
						<li>
							<!--id='pharmacy_'.$pharmacyKey.'-'.$pharmacyId class='chk_child pharmacy_'.$pharmacyKey-->
						</li>
						<!-- end Pharmacy data  -->
					</ul>
				</li>
				<?php 
		   					}
		   					?>
				<!-- End Of Pharmacy Charges -->


				<!-- Pharmacy Return Charges -->


				<?php 
				//Always used for refund purpose only -- pooja

				$pharmacyKey =$serviceKey;

				if($pharmacyreturnData[0][0]['total'] !='' && $pharmacyreturnData[0][0]['total']!=0){
						?>
				<li><?php //debug($pharmacyPaidData);
						$divClass='';

						$pharmacyRAdv=$pharmacyReturnPaid['pharmacy']['0']['total'];//-$pharmacyPaidData['0'][0]['discount']);
						$pharRDiscount=$pharmacyreturnData['0']['0']['total_discount'];
						if($pharmacyRAdv){
				$pharRCost=($pharmacyreturnData[0][0]['total']-$pharmacyReturnPaid['pharmacy']['0']['total']-$pharmacyReturnPaid['pharmacy']['0']['total_discount']);$pharDisable='';
			}else{
				$pharRCost=$pharmacyreturnData[0][0]['total'];
			}
			$rDiscount =	$pharmacyreturnData['0']['0']['total_discount'] - $pharmacyReturnPaid['pharmacy']['0']['total_discount'];
			/*if($pharmacyRAdv==round($pharmacyreturnData[0][0]['total']-$pharmacyreturnData['0']['0']['total_discount'])){
			 $class='chk_parent_paid exclude_discount discount_excluded ';

							}else{
								$class='chk_parent_paid exclude_discount discount_excluded  refund_amt ';
							}*/

							if($pharmacyPaidData['0'][0]['paid_amount'] && ($pharmacyPaidData['0'][0]['paid_amount']) >= ($pharRCost-$rDiscount)/*  && $pharmacyRAdv!=($pharmacyreturnData[0][0]['total']-$pharmacyreturnData['0']['0']['total_discount']) */){
									$class='chk_parent_paid exclude_discount discount_excluded  refund_amt ';
									$divClass='paid_payment';
							}else{
									$class='chk_parent exclude_discount discount_excluded ';
									$divClass='pending_payment';
							}
							if($pharmacyRAdv==($pharmacyreturnData[0][0]['total']-$pharmacyreturnData['0']['0']['total_discount'])){
								$divClass='paid_payment';
							}

							if($pharmacyRAdv){
								if(($pharmacyreturnData[0][0]['total']-$pharmacyreturnData['0']['0']['total_discount']-$pharmacyRAdv) > 0){
										$divClass='pending_payment';
								}
							}
							$pharDisable="disabled";


						$srNo++;	?>
					<div>
						<div align="center" class="<?php echo "tdBorder";?>"
							style="float: left;">
							<?php echo $this->Form->input("Billing.PharmacyReturn.".$serviceKey.".valChk",array('type'=>'checkbox','id'=>'pharmacy_R_'.$pharmacyKey,'class'=>"$class service_".$pharmacyKey,'value'=>'1','label'=>false));?>
						</div>
						<div class="<?php echo "prntDiv1 tdBorderRt $divClass";?>">
							<?php echo 'Pharmacy Sales Return';//Pharmacy Charges
						$v++;
						echo '&nbsp;'.$this->Form->hidden('',array('name'=>"data[Billing][PharmacyReturn][$serviceKey][editAmt]",'id'=>'phar_R_'.$serviceKey,'class'=>'textAmt','value' =>$pharRCost,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
						echo $this->Form->hidden('',array('name'=>"data[Billing][PharmacyReturn][$serviceKey][id]",'value' =>$pharmacyKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][PharmacyReturn][$serviceKey][service_id]",'value' =>$pharmacyKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][PharmacyReturn][$serviceKey][name]",'value' => "Pharmacy Return",'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][PharmacyReturn][$serviceKey][is_return]",'value' => "1",'legend'=>false,'label'=>false));
						?>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center"
							class="<?php echo "prntDiv2 tdBorderRt $divClass";?>">&nbsp;</div>
						<?php }?>
						<div align="center" class="<?php echo "prntDiv3 tdBorderRt $divClass";?>" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv4 tdBorderRt $divClass";?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][PharmacyReturn][$serviceKey][rate]",'value' => $this->Number->format(round($pharRCost/*-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							echo $this->Number->format(round($pharRCost));
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv5 tdBorderRt $divClass";?>">
							<?php 	
							echo $this->Form->hidden('',array('name'=>"data[Billing][PharmacyReturn][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
							echo '--';
							?>
						</div>

						<div align="center" valign="top"
							class="<?php echo "prntDiv6 tdBorderRt $divClass";?>">
							<?php 
							echo $this->Form->hidden('',array('name'=>"data[Billing][PharmacyReturn][$serviceKey][amount]",'value' => $this->Number->format(round($pharmacyreturnData[0][0]['total']/*-$pharmacyAdv-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							//echo $this->Number->format(round($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
							echo $this->Number->format(round($pharRCost));
									//echo $this->Number->format($pharmacyPaidData['0'][0]['total'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7  $divClass";?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][PharmacyReturn][$serviceKey][discount]",'class'=>'pharmacy_discount_'.$pharmacyKey,'value' => $pharmacyreturnData['0']['0']['total_discount'],'legend'=>false,'label'=>false));
							echo '<span class=pharmacy_discount_R'.$pharmacyKey.'>'.round($pharmacyreturnData['0']['0']['total_discount'] - $pharmacyReturnPaid['pharmacy']['0']['total_discount']).'</span>';
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7  $divClass";?>">
							<?php 
							$pharRPaid=$pharmacyreturnData[0][0]['total']-$pharmacyreturnData['0']['0']['total_discount']-$pharmacyRAdv;
							echo $this->Form->hidden('',array('name'=>"data[Billing][PharmacyReturn][$serviceKey][paid_amount]",'class'=>'paid_parent_pharmacy_R'.$pharmacyKey.' pharmacy_R_paid_'.$pharmacyKey,'value' => $pharRPaid,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							echo '<span class=pharmacy_R_paid_'.$pharmacyKey.'>'.round($pharRPaid).'</span>';
							?>
						</div>
					</div> <br>
					<ul>
						<!-- Pharmacy data  -->
						<li>
							<!--id='pharmacy_'.$pharmacyKey.'-'.$pharmacyId class='chk_child pharmacy_'.$pharmacyKey-->
						</li>
						<!-- end Pharmacy data  -->
					</ul>
				</li>
				<?php 
		   					}
		  			 	}?>
				<!-- End Of Pharmacy Return Charges -->


				<!--  Ot Pharmacy Charges -->


				<?php 
				if($category==Configure::read('OtPharmacy')){
				//$pharmaConfig='yes';
				$oTpharmacyKey =$serviceKey;
				if($oTpharmacyPaidData['0']['0']['total'] !='' && $oTpharmacyPaidData['0']['0']['total']!=0){
						?>
				<li><?php $divClass='';
					
				$oTpharCost=($oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']);/*-$pharmacyPaidData['0'][0]['paid_amount']);$pharDisable='';*/
				if($oTpharmacyPaidData['0'][0]['paid_amount']){
							$oTpharmacyAdv=($oTpharmacyPaidData['0'][0]['paid_amount']-$pharmacyReturnPaid['otpharmacy']['0']['total']);//-$otpharDiscount);
						}
						$otpharDiscount=($oTpharmacyPaidData['0'][0]['discount']-$oTpharmacyReturnData['0']['0']['total_discount']);
						$oTpharDisable='';$class='';$divClass='';
						if($oTpharmacyAdv > 0 || $otpharDiscount == $oTpharCost){
							$oTpharDisable="disabled";
							$oTclass=' exclude_discount';
							$oTdivClass=' paid_payment';
						}else{
							$oTclass=' chk_parent exclude_discount ';//exclude_discount
							$oTdivClass=' pending_payment';
						}

						if(!empty($oTpharmacyPaidData['0'][0]['discount'])){
							$oTclass.='  discount_excluded ';
						}
						if($oTpharmacyAdv+$otpharDiscount != $oTpharCost){
							$oTclass.=' chk_parent phar_dis ';
							$oTdivClass=' pending_payment';
						}else{
							$oTclass.=' chk_parent_paid';
						}

						$srNo++;	?>
					<div>
						<div align="center" class="<?php echo "tdBorder";?>"
							style="float: left;">
							<?php echo $this->Form->input("Billing.OtPharmacy.".$serviceKey.".valChk",array('type'=>'checkbox','id'=>'otpharmacy_'.$oTpharmacyKey,'class'=>"$oTclass service_".$oTpharmacyKey,'value'=>$oTpharCost-($oTpharmacyAdv+$otpharDiscount),'label'=>false));?>
						</div>
						<div class="<?php echo "prntDiv1 tdBorderRt $oTdivClass";?>">
							<?php echo $serviceCategoryName[$serviceKey];//Pharmacy Charges
						$v++;
						echo '&nbsp;'.$this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][editAmt]",'id'=>'otphar_'.$serviceKey,'class'=>'textAmt','value' =>$oTpharCost,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][id]",'value' =>$oTpharmacyKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][service_id]",'value' =>$oTpharmacyKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][name]",'value' => "OT Pharmacy Charges",'legend'=>false,'label'=>false));
						?>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center"
							class="<?php echo "prntDiv2 tdBorderRt $oTdivClass";?>">&nbsp;</div>
						<?php }?>
						<div align="center" class="<?php echo "prntDiv3 tdBorderRt $oTdivClass";?>" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv4 tdBorderRt $oTdivClass";?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][rate]",'value' => $this->Number->format(($oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']/*-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							echo $this->Number->format(round($oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']));
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv5 tdBorderRt $oTdivClass";?>">
							<?php 	
							echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
							echo '--';
							?>
						</div>

						<div align="center" valign="top"
							class="<?php echo "prntDiv6 tdBorderRt $oTdivClass";?>">
							<?php 
							echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][amount]",'value' => $this->Number->format(($oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']/*-$pharmacyAdv-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							//echo $this->Number->format(round($pharmacyPaidData['0'][0]['total']-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
							echo $this->Number->format(round($oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']/*-$pharmacyPaidAmount*/));
									//echo $this->Number->format($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7  $oTdivClass";?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][discount]",'class'=>'otpharmacy_discount_'.$oTpharmacyKey,'value' => ($otpharDiscount),'legend'=>false,'label'=>false));
							echo '<span class=otpharmacy_discount_'.$oTpharmacyKey.'>'.round($otpharDiscount).'</span>';
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7  $oTdivClass";?>">
							<?php if(!empty($oTpharmacyAdv)){
							 $oTpharPaid=$oTpharmacyAdv;
							}else{
								$oTpharPaid=$oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']-$otpharDiscount;
						}

						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][paid_amount]",'class'=>'paid_parent_otpharmacy_'.$oTpharmacyKey.' otpharmacy_paid_'.$oTpharmacyKey,'value' => ($oTpharPaid),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						echo '<span class=otpharmacy_paid_'.$oTpharmacyKey.'>'.round($oTpharPaid).'</span>';
						?>
						</div>
					</div> <br>
					<ul>
						<!-- Pharmacy data  -->
						<li>
							<!--id='pharmacy_'.$pharmacyKey.'-'.$pharmacyId class='chk_child pharmacy_'.$pharmacyKey-->
						</li>
						<!-- end Pharmacy data  -->
					</ul>
				</li>
				<?php 
		   					}?>

				<!-- End Of OT Pharmacy Charges -->
				<!-- Pharmacy Return Charges -->


				<?php
				//Always used for refund purpose only -- pooja
					
				$oTpharmacyKey =$serviceKey;
					
				if($oTpharmacyReturnData[0][0]['total'] !='' && $oTpharmacyReturnData[0][0]['total']!=0){
			?>
				<li><?php //debug($pharmacyPaidData);
			$oTpharmacyrAdv=($pharmacyReturnPaid['otpharmacy']['0']['total']);//-$otpharDiscount);
			$otpharrDiscount=($oTpharmacyReturnData['0']['0']['total_discount']);
			if($oTpharmacyrAdv){
							$oTpharrCost=($oTpharmacyReturnData['0']['0']['total']-$pharmacyReturnPaid['otpharmacy']['0']['total']-$pharmacyReturnPaid['otpharmacy']['0']['total_discount']);
						}else{
							$oTpharrCost=($oTpharmacyReturnData['0']['0']['total']);/*-$pharmacyPaidData['0'][0]['paid_amount']);$pharDisable='';*/
						}

						$otRDiscount=$oTpharmacyReturnData['0']['0']['total_discount'] - $pharmacyReturnPaid['otpharmacy']['0']['total_discount'];
						$otclass='';$oTdivClass='';
						/*if($oTpharmacyrAdv==round($oTpharmacyReturnData['0']['0']['total']-$oTpharmacyReturnData['0']['0']['total_discount'])){
						 $otclass='chk_parent_paid exclude_discount discount_excluded ';

										}else{
											$otclass='chk_parent_paid exclude_discount discount_excluded  refund_amt ';
										}*/


										if(!empty($oTpharmacyPaidData['0'][0]['paid_amount']) && ($oTpharmacyPaidData['0'][0]['paid_amount'] >=($oTpharrCost-$otRDiscount) ) && $oTpharmacyrAdv!=($oTpharmacyReturnData['0']['0']['total']-$oTpharmacyReturnData['0']['0']['total_discount']) ){
											$otclass='chk_parent_paid exclude_discount discount_excluded refund_amt';
											$oTdivClass='paid_payment';
										}else{
											$otclass='chk_parent exclude_discount discount_excluded   ';
											$oTdivClass='pending_payment';
										}

										if($oTpharmacyrAdv==($oTpharmacyReturnData['0']['0']['total']-$oTpharmacyReturnData['0']['0']['total_discount'])){
												$oTdivClass='paid_payment';
										}

										if(($oTpharmacyReturnData[0][0]['total']-$oTpharmacyReturnData['0']['0']['total_discount']-$oTpharmacyrAdv) > 0){
											$oTdivClass='pending_payment';
										}

										$oTpharrDisable="disabled";

											
									$srNo++;	?>
					<div>
						<div align="center" class="<?php echo "tdBorder";?>"
							style="float: left;">
							<?php echo $this->Form->input("Billing.OtPharmacyReturn.".$serviceKey.".valChk",array('type'=>'checkbox','id'=>'otpharmacy_R_'.$oTpharmacyKey,'class'=>"$otclass service_".$oTpharmacyKey,'value'=>'1','label'=>false));?>
						</div>
						<div class="<?php echo "prntDiv1 tdBorderRt $oTdivClass";?>">
							<?php echo 'OT Pharmacy Return';//ot Pharmacy
									$v++;
									echo '&nbsp;'.$this->Form->hidden('',array('name'=>"data[Billing][OtPharmacyReturn][$serviceKey][editAmt]",'id'=>'otphar_R_'.$serviceKey,'class'=>'textAmt','value' =>$oTpharCost,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
									echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacyReturn][$serviceKey][id]",'value' =>$oTpharmacyKey,'legend'=>false,'label'=>false));
									echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacyReturn][$serviceKey][service_id]",'value' =>$oTpharmacyKey,'legend'=>false,'label'=>false));
									echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacyReturn][$serviceKey][name]",'value' => "OT Pharmacy Return Charges",'legend'=>false,'label'=>false));
									echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacyReturn][$serviceKey][is_return]",'value' => "1",'legend'=>false,'label'=>false));

									?>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center"
							class="<?php echo "prntDiv2 tdBorderRt $oTdivClass";?>">&nbsp;</div>
						<?php }?>
						<div align="center" class="<?php echo "prntDiv3 tdBorderRt $oTdivClass";?>" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv4 tdBorderRt $oTdivClass";?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacyReturn][$serviceKey][rate]",'value' => $this->Number->format(($oTpharmacyReturnData['0']['0']['total']/*-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							echo $this->Number->format(round($oTpharrCost));
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv5 tdBorderRt $oTdivClass";?>">
							<?php 	
							echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacyReturn][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
							echo '--';
							?>
						</div>

						<div align="center" valign="top"
							class="<?php echo "prntDiv6 tdBorderRt $oTdivClass";?>">
							<?php 
							echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacyReturn][$serviceKey][amount]",'value' => $this->Number->format(($oTpharmacyReturnData['0']['0']['total']/*-$pharmacyAdv-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							//echo $this->Number->format(round($pharmacyPaidData['0'][0]['total']-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
							echo $this->Number->format(round($oTpharrCost));
									//echo $this->Number->format($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7  $oTdivClass";?>">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacyReturn][$serviceKey][discount]",'class'=>'otpharmacy_discount_R'.$oTpharmacyKey,'value' => ($otpharrDiscount),'legend'=>false,'label'=>false));
							echo '<span class=otpharmacy_discount_R'.$oTpharmacyKey.'>'.round($oTpharmacyReturnData['0']['0']['total_discount'] - $pharmacyReturnPaid['otpharmacy']['0']['total_discount']).'</span>';
							?>
						</div>
						<div align="center" valign="top"
							class="<?php echo "prntDiv7  $oTdivClass";?>">
							<?php /*if(!empty($oTpharmacyrAdv)){
							$oTpharPaid=$oTpharmacyrAdv;
							}else{
								$oTpharPaid=round($oTpharmacyReturnData['0']['0']['total']-$oTpharmacyReturnData['0']['0']['total_discount']);
							}*/

							$oTpharPaid=($oTpharmacyReturnData[0][0]['total']-$oTpharmacyReturnData['0']['0']['total_discount'])-($oTpharmacyrAdv);


							echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacyReturn][$serviceKey][paid_amount]",'class'=>'paid_parent_otpharmacy_R'.$oTpharmacyKey.' otpharmacy_R_paid_'.$oTpharmacyKey,'value' => $this->Number->format(($oTpharPaid),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							echo '<span class=otpharmacy_R_paid_'.$oTpharmacyKey.'>'.round($oTpharPaid).'</span>';
							?>
						</div>
					</div> <br>
					<ul>
						<!-- Pharmacy data  -->
						<li>
							<!--id='pharmacy_'.$pharmacyKey.'-'.$pharmacyId class='chk_child pharmacy_'.$pharmacyKey-->
						</li>
						<!-- end Pharmacy data  -->
					</ul>
				</li>
				<?php 
					   					}
					  			 	}?>
				<!-- End Of Pharmacy Return Charges -->

				<!-- Laboratory Charges -->
				<?php $hospitaType = $this->Session->read('hospitaltype');
				if($hospitaType == 'NABH'){
			          		$nabhType='nabh_charges';
			         	}else{
			          		$nabhType='non_nabh_charges';
			          	}
			          	?>
				<!-- BOF lab charges -->
				<?php if($category==Configure::read('laboratoryservices')){
					$laboratoryKey =$serviceKey;
					if(count($labRate)>0){
				          	//$laboratoryKey=array_search(Configure::read('laboratoryservices'), $serviceCategory);
				          ?>


				<?php $labRCost=0;$labAdv=0;
				foreach($labRate as $lab=>$labCost){
          			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
          				$k++;
          				if($labCost['LaboratoryTestOrder']['amount'] >0 ){
							$lCost += $labCost['LaboratoryTestOrder']['amount'] ;
							$labAdv += $labCost['LaboratoryTestOrder']['paid_amount'] ;
							$labDis+= round($labCost['LaboratoryTestOrder']['discount']);
						}else{
							$lCost += $labCost['TariffAmount'][$nabhType] ;
							$labAdv += $labCost['LaboratoryTestOrder']['paid_amount'] ;
							$labDis+= round($labCost['LaboratoryTestOrder']['discount']);
						}
						//$lCost += $labCost['TariffAmount'][$nabhType] ;

			          }
			          $labRCost=$lCost;
			          $lCost = $lCost -$labPaidAmount;$srNo++;

			          if($labAdv<=0){
						if(!empty($labDis))
							$classLab='reset_dis';
			          }
			          //}
			          ?>
				<li>
					<div>
						<div align="center" class="tdBorder" style="float: left;">
							<?php echo $this->Form->input('Billing.lab_charges',array('type'=>'checkbox','id'=>'laboratory_'.$laboratoryKey,'class'=>"chk_parent $classLab",'value'=>$labRCost-($labAdv+$labDis)));?>
						</div>
						<div class="tdBorderRt prntDiv1">
							<?php echo $serviceCategoryName[$serviceKey];//Laboratory Charges
			          $v++;
			          echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][name]",'value' => "Laboratory Charges",'legend'=>false,'label'=>false));
			          ?>
							<br>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center" class="tdBorderRt prntDiv2">&nbsp;</div>
						<?php }?>
						<div align="center" class="tdBorderRt prntDiv3" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<div align="center" valign="top" class="tdBorderRt prntDiv4">
							<?php
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' => $labRCost,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							echo $labRCost;
							//echo $this->Number->format($lCost) ;
							?>
						</div>
						<div align="center" valign="top" class="tdBorderRt prntDiv5">
							<?php 
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
							echo '--';

							?>
						</div>

						<div align="center" valign="top" class="tdBorderRt prntDiv6">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' =>$labRCost,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
							echo $labRCost;
							//echo $this->Number->format($lCost) ;
							?>
						</div>
						<div align="center" valign="top" class="prntDiv7">
							<?php echo round($labDis);
							?>
						</div>
						<div align="center" valign="top" class="prntDiv7">
							&nbsp;
							<!--  <?php 
					if(!empty($labAdv)){
								$labPaid=$labRCost-($labAdv+$labDis);
						  }else{
								$labPaid=$labRCost-$labDis;
						  }?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][paid_amount]",'class'=>'paid_parent_laboratory_'.$laboratoryKey,'value' => round($labPaid),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($labPaid);
						?>-->
						</div>
					</div> <br> <?php $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;
					if(!empty($labRate)){
					?>
					<ul>
						<?php echo labHtml($patient,$labRate,$laboratoryKey,$this->Form,$this->Number,$hideCGHSCol);?>
					</ul> <?php }?>

				</li>
				<?php $v++;
				// echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Laboratory Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			          }
			          }//Lab Category?>

				<!-- EOF Lab Charges -->


				<!-- Radiology Charges -->

				<?php if($category==Configure::read('radiologyservices')){
					$radiologyKey =$serviceKey;$radAdv=0;
					if(count($radRate)>0){
          //$radiologyKey=array_search(Configure::read('radiologyservices'), $serviceCategory);?>
				<?php 
				$v++;
				foreach($radRate as $rad=>$radCost){
							if($radCost['RadiologyTestOrder']['amount'] > 0){
								$rCost += $radCost['RadiologyTestOrder']['amount'] ;
								$radAdv += $radCost['RadiologyTestOrder']['paid_amount'] ;
								$radDis+= round($radCost['RadiologyTestOrder']['discount'] );
							}else{
								$rCost += $radCost['TariffAmount'][$nabhType] ;
								$radAdv += $radCost['RadiologyTestOrder']['paid_amount'] ;
								$radDis+= round($radCost['RadiologyTestOrder']['discount'] );
							}
							//$rCost += $labCost['TariffAmount'][$nabhType] ;
          				}
          				//$rCost = $rCost - $radPaidAmount;
          				if($radAdv<=0){
							if(!empty($radDis))
								$classRad='reset_dis';
          				}
          				$srNo++;
          				echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][name]",'value' => "Radiology Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
          				?>
				<li>
					<div>
						<div align="center" class="tdBorder" style="float: left;">
							<?php echo $this->Form->input('Billing.rad_charge',array('type'=>'checkbox','id'=>'radiology_'.$radiologyKey,'class'=>"chk_parent $classRad",'value'=>$rCost-($radAdv+$radDis)));?>
						</div>
						<div class="tdBorderRt prntDiv1">
							<?php echo $serviceCategoryName[$serviceKey];//Radiology Charges ?>
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][name]",'value' => "Radiology Charges",'legend'=>false,'label'=>false));?>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center" class="tdBorderRt prntDiv2">&nbsp;</div>
						<?php }?>
						<div align="center" class="tdBorderRt prntDiv3" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<div align="center" valign="top" class="tdBorderRt prntDiv4">
							<?php 		
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' => $rCost,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							echo $rCost;
							//echo $this->Number->format($rCost);
							?>
						</div>
						<div align="center" valign="top" class="tdBorderRt prntDiv5">
							<?php 	
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
							echo '--';

							?>
						</div>

						<div align="center" valign="top" class="tdBorderRt prntDiv6">
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' =>$rCost,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
							echo $rCost;
							//echo $this->Number->format($rCost);
							?>
						</div>
						<div align="center" valign="top" class="prntDiv7">
							<?php echo round($radDis);
							//echo $this->Number->format($rCost);
							?>
						</div>
						<div align="center" valign="top" class="prntDiv7">
							&nbsp;
							<!--<?php if(!empty($radAdv)){
								$radPaid=$radAdv;
						  }else{
								$radPaid=$rCost-$radDis;
						  }
					?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][paid_amount]",'class'=>'paid_parent_radiology_'.$radiologyKey,'value' => $radPaid,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($radPaid);
						//echo $this->Number->format($rCost);
						?>-->
						</div>
					</div> <br> <?php $hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ;?>
					<ul>
						<?php if(!empty($radRate)){
							echo radHtml($patient,$radRate,$radiologyKey,$this->Form,$this->Number,$hideCGHSCol);
			}?>
					</ul>
				</li>
				<?php $v++;
				// echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Laboratory Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
          }
				}
				//--EOF Radiology Charges
				$adi=0;
				if($category!=Configure::read('mandatoryservices') &&
						   $category!=Configure::read('radiologyservices') &&
						   $category!=Configure::read('laboratoryservices') &&
						   $category!=Configure::read('RoomTariff') &&
						   $category!=Configure::read('Pharmacy') &&
						   $category!=Configure::read('Consultant') &&
						   $category!=Configure::read('surgeryservices')){
				    	    $servicekey =$serviceKey;$serviceDis=0;$serDiscount='';
				    	    $name=explode(' ',$category);
				    	    $dynamicCnt = 0; ${
$name[0].'charge'}=0;$serviceAdv=0;
foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){
										if($nursingServicesCost['ServiceBill']['service_id']==$servicekey) {
												/*${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['service_bill_id'] = $nursingServicesCost['ServiceBill']['id'];
												 ${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['qty'] = ${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['qty']+$nursingServicesCost['ServiceBill']['no_of_times'];
												${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['name'] = $nursingServicesCost['TariffList']['name'] ;
												${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['cost'] = $nursingServicesCost['ServiceBill']['amount'];
												${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['paid_amount'] = ${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['paid_amount']+$nursingServicesCost['ServiceBill']['paid_amount'];
												${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
												${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code'];
												${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['tariff_list_id'] = $nursingServicesCost['TariffList']['id'];
												${$name[0].'charge'}=${$name[0].'charge'}+($nursingServicesCost['ServiceBill']['no_of_times']*$nursingServicesCost['ServiceBill']['amount']);
												${$name[0].'NursingServices'}[$nursingServicesCost['TariffList']['id']]['discount'] = $nursingServicesCost['ServiceBill']['discount'];
												$serviceqty[0]['qty']=$serviceqty[$nursingServicesCost['TariffList']['id']]['qty']+$nursingServicesCost['ServiceBill']['no_of_times'];
												$serviceAdv=$serviceAdv+$nursingServicesCost['ServiceBill']['paid_amount'];
												$serDiscount[$nursingServicesCost['TariffList']['id']]['discount'] = round($nursingServicesCost['ServiceBill']['discount']);
												$service[$name[0]]=$serviceAdv;
												$dynamicCnt++;$adi++;*/

												${
$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['service_bill_id'] = $nursingServicesCost['ServiceBill']['id'];
${
$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['name'] = $nursingServicesCost['TariffList']['name'] ;
${
$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['cost'] = $nursingServicesCost['ServiceBill']['amount'];
${
$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['qty'] = $nursingServicesCost['ServiceBill']['no_of_times'];
${
$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['paid_amount'] =$nursingServicesCost['ServiceBill']['paid_amount'];
${
$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
${
$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code'];
${
$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['tariff_list_id'] = $nursingServicesCost['TariffList']['id'];
${
$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['discount'] = $nursingServicesCost['ServiceBill']['discount'];

${
$name[0].'charge'}=${
$name[0].'charge'}+($nursingServicesCost['ServiceBill']['no_of_times']*$nursingServicesCost['ServiceBill']['amount']);
$serviceAdv=$serviceAdv+$nursingServicesCost['ServiceBill']['paid_amount'];
$serviceDis=$serviceDis+$nursingServicesCost['ServiceBill']['discount'];
			    			}

		    		}

		    		if($serviceAdv<=0){
						if(!empty($serviceDis))
							$classdyn='reset_dis';
		    		}

		    		//debug($serviceAdv);debug($serviceqty);
		    		/*$serviceDis=0;
		    		 foreach($serDiscount as $dis){
		    			$serviceDis=$serviceDis+$dis['discount'];
		    		}*/
		    		if(!empty(${
$name[0].'charge'}) || ${
$name[0].'charge'}!=0){
		    		$totalCost=$totalCost+${
$name[0].'charge'};
?>
				<li>
					<div>
						<div align="center" class="tdBorder" style="float: left;">
							<?php echo $this->Form->input('Billing.'.$name[0].'_charges',array('type'=>'checkbox','id'=>$name[0].'_'.$servicekey,'class'=>"chk_parent $classdyn",'value'=>round(${
$name[0].'charge'}-($serviceAdv+$serviceDis))));?>
						</div>
						<div class="tdBorderRt prntDiv1">
							<?php echo $serviceCategoryName[$serviceKey];//Dynamic $category;
$v++;
echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][name]",'value' => "$name[0]",'legend'=>false,'label'=>false));
?>
							<br>
						</div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
						<div align="center" class="tdBorderRt prntDiv2">&nbsp;</div>
						<?php // padding: 0px 95px 0px 0px;?>
						<?php }?>
						<div align="center" class="tdBorderRt prntDiv3" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
						<?php //padding: 0px 95px 0px 0px; ?>
						<div align="center" valign="top" class="tdBorderRt prntDiv4">
							<?php // padding: 0px 80px 0px 10px;?>
							<?php
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' =>${
$name[0].'charge'},
'legend'=>false,'label'=>false,
															'id' => 'clinical_rate','style'=>'text-align:right;'));
						echo ${
$name[0].'charge'};
//echo $this->Number->format($lCost) ;
?>
						</div>
						<div align="center" valign="top" class="tdBorderRt prntDiv5">
							<?php // padding: 0px 95px 0px 0px;?>
							<?php 
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
							echo '--';

							?>
						</div>

						<div align="center" valign="top" class="tdBorderRt prntDiv6">
							<?php // padding: 0px 53px 0px 10px;?>
							<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' => ${
								$name[0].'charge'}
								,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
								echo ${
$name[0].'charge'};
//echo $this->Number->format($lCost) ;
?>
						</div>
						<div align="center" valign="top" class=" prntDiv7">
							<?php echo  round($serviceDis);
							?>
						</div>
						<div align="center" valign="top" class=" prntDiv7">
							&nbsp;
							<!--<?php if(!empty($serviceAdv)){
								$totalPaid=$serviceAdv;
							}else{
								$totalPaid=${$name[0].'charge'}-$serviceDis;
							}?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][paid_amount]",'class'=>'paid_parent_'.$name[0].'_'.$servicekey,'value' =>$totalPaid,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($totalPaid);
						//echo $this->Number->format($lCost) ;
						?>-->
						</div>
					</div> <br>
					<ul>
						<?php //echo '<pre>';
						//print_r(${$name[0].'NursingServices'});exit;
						$servicesArray=${
$name[0].'NursingServices'};

echo dynamicService($patient,$servicesArray,$servicekey,$this->Form,
									$this->Number,$hideCGHSCol,$name[0]);?>
					</ul> <!-- dynamic Services UL end -->
				</li>
				<!-- dynamic Services Li end -->
				<?php }
						}?>
				<?php } // EOF Service Category ?>
				<!-- Other Charges 
			<?php 
			if($otherServicesData){
				          $otherServicesCharges=0;
				          foreach($otherServicesData as $otherCharges){
								$otherServicesCharges=$otherServicesCharges+$otherServiceD['OtherService']['service_amount'];
							} ?>
			<li>
				<div>
					<div align="center" class="tdBorder" style="float: left;">
						<?php echo $this->Form->input('Billing.other_charges',array('type'=>'checkbox','id'=>'other','class'=>'chk_parent','value'=>$otherServicesCharges));?>
					</div>
					<div class="tdBorderRt prntDiv1">
						Other Services
						<?php $v++;
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][name]",'value' => "Other Charges",'legend'=>false,'label'=>false));
						?>
						<br>
					</div>
					<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
					<div align="center" class="tdBorderRt prntDiv2">&nbsp;</div>
					<?php }?>
					<div align="center" class="tdBorderRt prntDiv3" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
					<div align="center" valign="top" class="tdBorderRt prntDiv4">
						<?php
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' => $this->Number->format($otherServicesCharges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'other_rate','style'=>'text-align:right;'));
						echo $this->Number->format($otherServicesCharges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class="tdBorderRt prntDiv5">
						<?php 
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
						echo '--';

						?>
					</div>
					<div align="center" valign="top" class="tdBorderRt prntDiv6">
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' => $this->Number->format($otherServicesCharges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo $this->Number->format($otherServicesCharges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class="prntDiv7">
						<?php //echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' => $this->Number->format($otherServicesCharges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						//echo $this->Number->format($otherServicesCharges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
						//echo $this->Number->format($lCost) ;
						?>
					</div>
				</div> <br>
				<ul>
					<?php echo otherServiceHtml($otherServicesData,$this->Form,$this->Number,$hideCGHSCol);?>
				</ul>
			</li>
			<?php }	//EOF if?>-->
				<!-- EOF Other Charges -->

				<!--  Registration Charges -->
				<?php 
				#dpr($totalCost.'--'.$totalServiceCharge.'--'.$labRCost.'--'.$rCost.'--'.$totalSurgeryCost.'--'.$totalMandatoryServiceCharge.'--'.$wardCharges.'--'.$totalCostConsultant.'--'.$pharmacy_charges)	;
				if($pharmaConfig=='yes'){
					$totalCost = $totalCost+$totalServiceCharge+$labRCost+$rCost+$totalSurgeryCost+$totalMandatoryServiceCharge+$wardCharges+$totalCostConsultant+$pharmacy_charges;
					$totalAdvance=$consultPaid+$surgeryAdv+$mandatoryAdv+$labAdv+$radAdv+$totalServiceAdv+$pharmacyAdv;
				}else{
					$totalCost = $totalCost+$totalServiceCharge+$labRCost+$rCost+$totalSurgeryCost+$totalMandatoryServiceCharge+$wardCharges+$totalCostConsultant/*+$pharmacy_charges*/;
					$totalAdvance=$consultPaid+$surgeryAdv+$mandatoryAdv+$labAdv+$radAdv+$totalServiceAdv/*+$pharmacyAdv*/;
				}
				foreach($service as $advService){
					$sAd=$sAd+$advService;
				}
				$totalAdvance=$totalAdvance+$sAd;
				?>
				<li>
					<div>
						<div class="tdBorderRt" align="center" valign="top"
							id="addColumnHt1" style="float: left;"></div>
						<div class="tdBorderRt prntDiv1"></div>
						<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { // for private patient only?>
						<div class="tdBorderRt prntDiv2" align="center" valign="top"></div>
						<?php }?>
						<div class="tdBorderRt prntDiv3" align="center" style="<?php echo $hideCGHSCol ;?>"></div>
						<div class="tdBorderRt prntDiv4" align="center" valign="top"></div>
						<div align="center" valign="top" class="tdBorderRt prntDiv5"></div>
						<div align="center" valign="top" class="tdBorderRt prntDiv6"></div>
						<div align="center" valign="top" class="tdBorderRt prntDiv7"></div>
						<div align="center" valign="top" class="tdBorderRt prntDiv7"></div>
					</div>
				</li>
			</ul>
			<br>
			<!-- EOF Main ul -->
		</div>
		<!-- EOF tree div -->

		<!-- Billing Section Starts  Pooja-->
		<!--<div style="float: right; width: 300; vertical-align: top;">
		<div style="clear: both; width:100% ;">
			<table width="100%" cellspacing='0' cellpadding='0'>
				<tr class="row_gray">
					<td style="padding: 0px 0px 0px 2px; height: 30px"><b>Total Bill</b></td>
					<td style=" padding: 0px 0px 0px 2px;">
							<?php echo "<font style='font-weight: bold; font-size: 18px' >".round($totalCost)."</font>";
								  echo $this->Form->hidden('Billing.total_amount',
											array('value' => ($totalCost),'legend'=>false,'label'=>false,'id'=>'totalamount'));
							?>
					</td>
					</tr>
					<tr>
					<td style="padding: 0px 0px 0px 2px; height: 30px"><b>Total Discount</b></td>
					<td><?php 							 
							if(!empty($billDetail['0']['0']['discount'])){
								$discountAmount=$billDetail['0']['0']['discount'];
							}else{
									$discountAmount=0;
							}
							/*if(isset($finalBillingData['FinalBilling']['discount_type']) && $finalBillingData['FinalBilling']['discount'] !=''){
	                        	$discountAmount = $finalBillingData['FinalBilling']['discount'];
		                    }else{
		                        	$discountAmount=0;
		                    }*/

							//$balance=$totalCost-($billDetail['0']['0']['discount']+$billDetail['0']['0']['amount']);
		                    if($discountAmount != '' && $discountAmount!=0){
								echo round($discountAmount);
							}else{
								echo '0.00';
							}		
							?>
					</td>
					</tr>
					<tr class="row_gray">
					<td style="padding: 0px 0px 0px 2px; height: 30px"><b>Total Refund</b></td>						
						<td>
						<?php //if($discountData['FinalBilling']['refund']=='1'){
	                        if(!empty($billDetail['0']['0']['refund'])){
								$balance=$balance+$billDetail['0']['0']['refund'];
								echo $billDetail['0']['0']['refund'];
							}else{
								echo '0.00';
							}
							?>
						</td>
					</tr>
					<tr>
					<td style="padding: 0px 0px 0px 2px; height: 30px"><b>Total Paid</b></td>
					<td>
						<?php 
								echo round($billDetail['0']['0']['amount']+$advanceAmount[0]['advance']);
								echo $this->Form->hidden('Billing.amount_paid',array('value' => ($billDetail['0']['0']['amount']+$advanceAmount['0']['advance']),'legend'=>false,'label'=>false));
								?>
					</td>
					</tr>
					<!-- <tr class="row_gray">
					 <td style="padding: 0px 0px 0px 2px; height: 30px"><b>Total Payable</b></td>					
					<td>
						
							<?php $balance=$totalCost-($billDetail['0']['0']['discount']+$billDetail['0']['0']['amount']);
							if(!empty($billDetail['0']['0']['refund'])){
								$balance=$balance+$billDetail['0']['0']['refund'];
								}
								echo "<font style='font-weight: bold;' >".round($balance-$advanceAmount['0']['paidAdvance']/*$totalCost-$totalAdvance-$discountAmount+$totalRefund*/)."</font>";
								echo $this->Form->hidden('Billing.amount_pending',array('value' => ($balance-$advanceAmount['0']['paidAdvance']/*$totalCost-$totalAdvance-$discountAmount+$totalRefund*/),'id'=>'balanceAmount','legend'=>false,'label'=>false));
							?>	
					</td>
					</tr>
					<tr class="row_gray">
					<td style="padding: 0px 0px 0px 2px; height: 30px"> <b>Selected service cost</b></td>
					<td style="padding: 10px 0px 5px 0px">
							<span style="font-weight: bold; font-size: 18px ; color : #C00000"  class="checkedValue"></span>
							<input type="hidden" class="checkedValue" name="TotalPayBill" readonly="readonly">
					</td>
					</tr>
					<tr>
					<td style="padding: 0px 0px 0px 2px; height: 30px"> <b>Advance Amount</b></td>
					<td style="padding: 10px 0px 5px 0px">
							<?php echo $advanceAmount['0']['advance']-$advanceAmount['0']['paidAdvance'];?>
					</td>
					</tr>
					<tr >
					<td style="padding: 0px 0px 0px 2px; height: 30px"><b>Selected service payable</b></td>
					<td><?php echo $this->Form->input('Billing.changeAmt',array('id'=>'actAmount',
											'style'=>'font-weight: bold; font-size: 20px; color: green; width:65%'));
					//"<font style='font-weight: bold; font-size: 30px' color='green'   id= 'actAmount'></font>";
									/*if($advanceAmount[0]['advance'])
										$advAmt=$advanceAmount[0]['advance'];*/
							//echo $this->Form->hidden('Billing.advance_used',array('id'=>'advance_balance'));
							//echo $this->Form->hidden('Billing.advance_not_used',array('id'=>'advance_not_used_balance'));?>
					</td>
					</tr>
					
					
			</table>
		</div>-->
	</div>
	<!-- EOF selection and billing html -->


	<div style="clear: both; width: 100%;">
		<table id="partialDiscountRow" width="100%">
			<tr>
				<td id="serSel"><b>Selected service cost :</b> <?php echo $this->Form->input('Billing.changeAmt',array('id'=>'actAmount','readonly'=>'readonly',
											'style'=>'font-weight: bold; font-size: 20px; color: green; width:15%'));?>
					<!--  <span style="font-weight: bold; font-size: 18px ; color : #C00000"  class="checkedValue"></span> -->
				</td>
			</tr>
			<tr>
				<td colspan="7">
					<div style="width: 100%">



						<?php //if(empty($entryInFinal)){ 
				//if(strtolower($corporateEmp) == 'private' || strtolower($this->params->query['corporate']) == 'corporate'){
						//if(strtolower($this->params->query['corporate']) == 'corporate'){
				?>
						<div style="width: 53%; float: left" id='disRow'>
							<div style="float: left; width: 17%; padding: 0px 0px 0px 2px;">
								<?php $discount=array('Amount'=>'Amount','Percentage'=>'Percentage');
								echo '<b>Discount </b><br>' .$this->Form->input('Billing.discount_type', array('id' =>'discountType','options' => $discount,
								'autocomplete'=>'off','readonly'=>false,'legend' =>false,'label' => true,'div'=>false,'class'=>'discountType',
								'type' => 'radio','separator'=>'</br>','disabled'=>false));
							echo $this->Form->hidden('Billing.discount_type',array('id'=>'typeDiscount','value'=>''));
							echo $this->Form->hidden('Billing.maintainDiscount',array('id'=>'maintainDiscount','value'=>''));
							//echo $this->Form->hidden('Billing.discount_type',array('id'=>'typeDiscount','value'=>''));


							?>
							</div>

							<div style="float: right; width: 80%">
								<table>
									<!--  <tr>
										<td><?php echo '<b>FOC</b>  (Free of charge)'.$this->Form->input('Billing.foc',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'foc'));?>
										</td>
									</tr>-->
									<tr>
										<td><?php //onlyNumberSp
											  echo $this->Form->input('Billing.is_discount',array('type'=>'text','legend'=>false,'label'=>false,
													'id' => 'discount','autocomplete'=>'off','style'=>'text-align:right; display:none;',
													'value'=>$discountAmount,'readonly'=>false,'class' => 'validate[optional,custom[onlyNumberSp]]'));
									          echo $this->Form->hidden('Billing.discount',array('id'=>'disc', 'value'=>''));
									          ?> <span id="show_percentage" style="display: none">%</span>
											<br> <?php echo '<span id=inAmt style="display:none">Amt</span><span id=inPer style="display:none">In per(%)</span>'.'&nbsp; <span id="calDis"></span>';//.$this->Form->hidden('Billing.calDis',array('id'=>'calDis','style'=>'display:none', 'disabled'=>true));
					    					 echo $this->Form->hidden('Billing.discount_per',array('id'=>"calPer"));?>
										</td>
										<td><?php echo $this->Form->input('Billing.discount_by', array('class' => ' textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Please select',$authPerson),'id' => 'discount_authorize_by','style'=>"display:none;",'readonly'=>false)); ?>
										</td>
										<td style="padding: 0px;"><?php $disountReason = array('VIP'=>'VIP','Poor and needy'=>'Poor and needy','Hospital staff'=>'Hospital staff','Waiver'=>'Waiver','Others'=>'Others');
				                 		echo $this->Form->input('Billing.discountReason', array('class' => ' textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Select Reason',$disountReason),'id' => 'discount_reason','style'=>"display:none; width:105px;")); ?>
										</td>
									</tr>
									<tr>
										<td colspan="3"><?php 
										echo $this->Html->link(__('Send request for discount'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send-approval',"style"=>"display:none;"));
										echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-approval',"style"=>"display:none;"));
										echo $this->Form->hidden('Billing.is_approved',array('value'=>'0','id'=>'is_approved'));
										?>
										</td>
									</tr>

									<tr>
										<td valign="top" align="left" style="padding-top: 0px;"
											colspan="2">&nbsp;
											<div style="float: left; margin-top: 0px;">
												<i id="mesage" style="display: none;"> (<font color="red">Note:
												</font> <span id="status-approved-message"></span> ) <span
													class="gif" id="image-gif"
													style="float: right;"> </span>
												</i>
											</div>
										</td>
									</tr>
								</table>
							</div>
							<?php //}?>
						</div>
						<?php //}?>
						<div style="width: 46%; float: right;">
							<?php //no conditions required for refund
							/*if(/*strtolower($this->Session->read('role_code_name'))=='admin' || *//* strtolower($corporateEmp) == 'private' && $patient['Patient']['admission_type']!='IPD'){*/?>
							<div style="float: left; width: 30%">
								<?php echo '<b>Refund</b>'.$this->Form->input('Billing.refund',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'is_refund'));
								echo $this->Form->hidden('Billing.hrefund',array('id'=>'hrefund','value'=>''));
								echo $this->Form->hidden('Billing.maintainRefund',array('id'=>'maintainRefund','value'=>''));
			    	?>
								Yes/No
							</div>
							<?php  //}?>
							<div style="float: right; width: 70%">
								<table>
									<tr>
										<td><?php if($this->Session->read('website.instance')!='hope'){
											echo $this->Form->input('Billing.refund_to_patient',array('type'=>'text','id'=>'refund_amount','readonly'=>'readonly','style'=>"display:none;"));
										}else{
											echo $this->Form->input('Billing.refund_to_patient',array('type'=>'text','id'=>'refund_amount','style'=>"display:none; "));
										}
							    	echo $this->Form->input('Billing.paid_to_patient',array('type'=>'text','id'=>'refund_paid','style'=>"display:none; "));?>
										</td>
										<td><?php echo $this->Form->input('Billing.refund_authorize_by', array('class' => 'textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Please select',$authPerson),'id' => 'discount_authorize_by_for_refund','style'=>"display:none;"));?>
										</td>
									</tr>
									<tr>
										<td colspan="2"><?php 
										echo $this->Html->link(__('Send request for Refund'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send-approval-for-refund',"style"=>"display:none;"));
										echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-refund-approval',"style"=>"display:none;"));
										echo $this->Form->hidden('Billing.is_refund_approved',array('value'=>0,'id'=>'is_refund_approved'));
										?>
										</td>
									</tr>
									<tr>
										<td valign="top" align="left" style="padding-top: 15px;"
											colspan="2">&nbsp;
											<div style="float: left; margin-top: 3px;">
												<i id="mesage2" style="display: none;"> (<font color="red">Note:
												</font> <span id="status-approved-message-for-refund"></span>
													) <span class="gif" id="image-gif2"
													style="float: right; margin: -3px 0px 0px 7px;"> </span>
												</i>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div style="clear: both; width: 100%;">
		<table>
			<tr>
				<td>
				<?php echo $this->Form->input('Billing.resetDiscount',array('type'=>'checkbox','id'=>'resetDiscount','div'=>false,'label'=>true,'label'=>'Reset All Discounted Services'));?></td>
			</tr>
			<tr>
				<td class="tdLabel2"><?php $todayDate=date("d/m/Y H:i:s");
				echo '<strong style="float:left; padding: 0 53px 0 px;">Payment Date<font color="red">*</font></strong>'.$this->Form->input('Billing.date',array('readonly'=>'readonly',
								 'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,
								 'id' => 'discharge_date','autocomplete'=>'off','value'=>$todayDate));?>
				</td>
			</tr>
			<tr>
				<td class="paymentRemarkRefund" style="display: none"><?php echo '<span style="vertical-align: top; padding: 0 17px 0 28px;">Remark</span>  ';echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,
						'id' => 'refundRemark','cols'=>'20'/*,'disabled'=>'disabled'*/,'rows'=>'5','value'=>'Being cash refunded towards  from pt. '.$patient['Patient']['lookup_name'].' against R. No.:'));  ?>
				</td>
			</tr>

		</table>
	</div>

	<div>
		<?php echo $this->Form->hidden('Billing.total_amount',array('value' => ($totalCost),'legend'=>false,'label'=>false,'id'=>'totalamount'));

		echo $this->Form->submit('Submit',array('id'=>'submit','class'=>'blueBtn','div'=>false,'label'=>false));

		echo $this->Html->link('Reset','javascript:void(0);',
					array('class'=> 'blueBtn','id'=>'resetAll','escape' => false,'label'=>false,'div'=>false));
  			   echo $this->Form->end();?>
	</div>
</div>

<!-- EOF Billing Section -->

</div>

</body>
</html>

<?php 
function consultantHtml($patient,$cCArray,$formHelper,$numberHelper,$consultantServiceId,$hideCGHSCol){

	$totalCost=0;$v=0;
	foreach ($cCArray as $cBilling){
			          foreach($cBilling as $consultantBillingDta){
			          	foreach($consultantBillingDta as $consultantBilling){
							foreach($consultantBilling as $singleKey=>$singleData){
			          	$v++;$srNo++;$paidAmt=0;
			          	//checkBox value contains amount amt*qty
			          	$rowCost = $singleData['ConsultantBilling']['amount'];
			          	$paidAmt=$rowCost-round($singleData['ConsultantBilling']['paid_amount']+$singleData['ConsultantBilling']['discount']);
			          	$disabled='';
			          	//Discount will be given "only ONCE"
			          	if(!empty($singleData['ConsultantBilling']['discount']))
			          		$exclude='discount_excluded';
			          	else $exclude='';
			          	if($paidAmt<=0){
							$disabled='disabled';
							$class='chk_child_paid refund_amt'	;
						}else{
							$class='chk_child'	;
						}

						if(empty($singleData['ConsultantBilling']['paid_amount'])){
							if(!empty($singleData['ConsultantBilling']['discount']))
								$class.=' reset_child_dis'	;
						}
						$consultant_id=$singleData['ConsultantBilling']['id'];
						$consultantHtml.="<div>";
						$consultantHtml.="<li>";
						$consultantHtml.="<div align='center' class='tdBorder' style=' float: left;'>";
						$consultantHtml.=$formHelper->input("Billing.Consultant.".$consultant_id.".valChk",array('type'=>'checkbox','id'=>'consultant_'.$consultantServiceId.'-'.$consultant_id ,$disabled,'class'=>'service_'.$consultantServiceId.' '.$class.' '.$exclude,'value'=>$paidAmt));
						$consultantHtml.="</div>";
						$consultantHtml.="<div class='tdBorderRt chldDiv1'>";
						$consultantHtml.= $singleData['ServiceCategory']['name'];
						$completeConsultantName = $singleData['Initial']['name'].$singleData['Consultant']['first_name'].' '.$singleData['Consultant']['last_name'];
						$consultantHtml.= '<i>'.$completeConsultantName.'</i> ';
						$consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".name",array('value' => $completeConsultantName,'legend'=>false,'label'=>false));
						$consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".id",array('value' => $consultant_id,'legend'=>false,'label'=>false));
						$consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".service_id",array('value' => $consultantServiceId,'legend'=>false,'label'=>false));
						$sDate = explode(" ",$singleData['ConsultantBilling']['date']);
						$lRec = end($consultantBilling);
						$eDate = explode(" ",$lRec['ConsultantBilling']['date']);
						if($patient['Patient']['admission_type']=='OPD'){
							 $consultantHtml.= '('.$singleData['ConsultantBilling']['date'].')';
						  }else{
							 $consultantHtml.= '('.$singleData['ConsultantBilling']['date'].' - '.$singleData['ConsultantBilling']['enddate'].')';
						  };
						  $consultantHtml.='&nbsp;'.$formHelper->hidden("Billing.Consultant.".$consultant_id.".editAmt",array('value' => $paidAmt,$disabled,'id'=>'txt_'.$consultant_id,'class'=>'textAmt','legend'=>false,'label'=>false,'style'=>'width:75px; padding:2px'));
						  $consultantHtml.=" </div>";
						  if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { /*7 for private patient only*/
			            $consultantHtml.="<div align='center' class='tdBorderRt chldDiv2'>--&nbsp;</div> ";
						}
						$consultantHtml.="<div align='center' class='tdBorderRt chldDiv3' style='$hideCGHSCol;'>";
						$consultantHtml.=$singleData['TariffList']['cghs_code'].'--';
						$consultantHtml.="</div>";
						$consultantHtml.="<div align='center' valign='top' class='tdBorderRt chldDiv4' >";
						$consultantHtml.= $formHelper->hidden("Billing.Consultant.".$consultant_id.".unit",array('value' =>1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
						$consultantHtml.=$singleData['ConsultantBilling']['amount'];
						$consultantHtml.="</div>";
						$consultantHtml.="<div align='center' valign='top' class='tdBorderRt chldDiv5' >";
						$totalCost = $totalCost + $singleData['ConsultantBilling']['amount'];
						$consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".rate",array('value' =>$singleData['ConsultantBilling']['amount'],'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
						$consultantHtml.= 1;
						$consultantHtml.="</div>";
							
						$consultantHtml.="<div align='center' valign='top' class='tdBorderRt chldDiv6'>";
						$consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".amount",array('value' => $singleData['ConsultantBilling']['amount'],'legend'=>false,'label'=>false,'id' => 'consultant_amount','style'=>'text-align:right;'));
						$consultantHtml.=$singleData['ConsultantBilling']['amount'];
						$consultantHtml.='</div>';
						$consultantHtml.='<div align="center" valign="top" class="chldDiv7">';
						$consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".discount",array('value' => round($singleData['ConsultantBilling']['discount']),'class'=>'discount_'.$consultantServiceId.'-'.$consultant_id,'legend'=>false,'label'=>false));
						$consultantHtml.="<span class=discount_$consultantServiceId-$consultant_id>".round($singleData['ConsultantBilling']['discount'])."</span>";
						$consultantHtml.='</div>';
						$consultantHtml.='<div align="center" valign="top" class="chldDiv7">';
						if(!empty($singleData['ConsultantBilling']['paid_amount'])){
				        	$paid=$singleData['ConsultantBilling']['paid_amount'];
				        }else{
				        	$paid=$singleData['ConsultantBilling']['amount']-$singleData['ConsultantBilling']['discount'];
				        }
				        $consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".paid_amount",array('value' =>round($paid),'legend'=>false,'label'=>false,'class'=>'paid_'.$consultantServiceId.'-'.$consultant_id ,'style'=>'text-align:right;'));
				        $consultantHtml.="<span class=paid_$consultantServiceId-$consultant_id>".round($paid)."</span>";
				        $consultantHtml.='</div>';
				        $consultantHtml.="</li>";
				        $consultantHtml.="</div>";
				        $consultantHtml.="<br>";

	    							}
					          	 }
					          }
					     }

					     return 	$consultantHtml;
	}

	function physicianHtml($patient,$cDArray,$formHelper,$numberHelper,$consultantServiceId,$hideCGHSCol){
		foreach ($cDArray as $cBilling){
			foreach($cBilling as $consultantBillingDta){
				foreach($consultantBillingDta as $consultantBilling){
					foreach($consultantBilling as $singleKey=>$singleData){
						$v++;$srNo++;$paidAmt=0;
						//checkBox value contains amount amt*qty
						$rowCost = $singleData['ConsultantBilling']['amount'];
						$paidAmt=$rowCost-round($singleData['ConsultantBilling']['paid_amount']+$singleData['ConsultantBilling']['discount']);
						$disabled='';
						//Discount will be given "only ONCE"
						if(!empty($singleData['ConsultantBilling']['discount']))
							$exclude='discount_excluded';
						else $exclude='';
						if($paidAmt<=0){
							$disabled='disabled';
							$class='chk_child_paid refund_amt'	;
						}else{
							$class='chk_child'	;
						}

						if(empty($singleData['ConsultantBilling']['paid_amount'])){
							if(!empty($singleData['ConsultantBilling']['discount']))
								$class.=' reset_child_dis'	;
						}
						$consultant_id=$singleData['ConsultantBilling']['id'];
						$physicianHtml.="<div>";
						$physicianHtml.="<li>";
						$physicianHtml.="<div align='center' class='tdBorder' style=' float: left;'>";
						$physicianHtml.=$formHelper->input("Billing.Consultant.".$consultant_id.".valChk",array('type'=>'checkbox','id'=>'consultant_'.$consultantServiceId.'-'.$consultant_id ,$disabled,'class'=>'service_'.$consultantServiceId.' '.$class.' '.$exclude,'value'=>$paidAmt));
						$physicianHtml.="</div>";
						$physicianHtml.="<div class='tdBorderRt chldDiv1'>";
						$physicianHtml.= $singleData['ServiceCategory']['name'];
						$completeConsultantName = $singleData['Initial']['name'].$singleData['DoctorProfile']['first_name'].' '.$singleData['DoctorProfile']['last_name'];
						$physicianHtml.= '<i>'.$completeConsultantName.'</i> ';
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".name",array('value' => $completeConsultantName,'legend'=>false,'label'=>false));
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".id",array('value' => $consultant_id,'legend'=>false,'label'=>false));
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".service_id",array('value' => $consultantServiceId,'legend'=>false,'label'=>false));
						$sDate = explode(" ",$singleData['ConsultantBilling']['date']);
						$lRec = end($consultantBilling);
						$eDate = explode(" ",$lRec['ConsultantBilling']['date']);
						if($patient['Patient']['admission_type']=='OPD'){
							$physicianHtml.= '('.$singleData['ConsultantBilling']['date'].')';
						}else{
							$physicianHtml.= '('.$singleData['ConsultantBilling']['date'].' - '.$singleData['ConsultantBilling']['enddate'].')';
						};
						$physicianHtml.='&nbsp;'.$formHelper->hidden("Billing.Consultant.".$consultant_id.".editAmt",array('value' => $paidAmt,$disabled,'id'=>'txt_'.$consultant_id,'class'=>'textAmt','legend'=>false,'label'=>false,'style'=>'width:75px; padding:2px'));
						$physicianHtml.=" </div>";
						if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { /*7 for private patient only*/
							$physicianHtml.="<div align='center' class='tdBorderRt chldDiv2'>--&nbsp;</div> ";
						}
						$physicianHtml.="<div align='center' class='tdBorderRt chldDiv3' style='$hideCGHSCol;'>";
						$physicianHtml.=$singleData['TariffList']['cghs_code'].'--';
						$physicianHtml.="</div>";
						$physicianHtml.="<div align='center' valign='top' class='tdBorderRt chldDiv4' >";
						$physicianHtml.= $formHelper->hidden("Billing.Consultant.".$consultant_id.".unit",array('value' =>1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
						$physicianHtml.=$singleData['ConsultantBilling']['amount'];
						$physicianHtml.="</div>";
						$physicianHtml.="<div align='center' valign='top' class='tdBorderRt chldDiv5' >";
						$totalCost = $totalCost + $singleData['ConsultantBilling']['amount'];
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".rate",array('value' =>$singleData['ConsultantBilling']['amount'],'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
						$physicianHtml.= 1;
						$physicianHtml.="</div>";
							
						$physicianHtml.="<div align='center' valign='top' class='tdBorderRt chldDiv6'>";
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".amount",array('value' => $singleData['ConsultantBilling']['amount'],'legend'=>false,'label'=>false,'id' => 'consultant_amount','style'=>'text-align:right;'));
						$physicianHtml.=$singleData['ConsultantBilling']['amount'];
						$physicianHtml.='</div>';
						$physicianHtml.='<div align="center" valign="top" class="chldDiv7">';
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".discount",array('value' => round($singleData['ConsultantBilling']['discount']),'class'=>'discount_'.$consultantServiceId.'-'.$consultant_id,'legend'=>false,'label'=>false));
						$physicianHtml.="<span class=discount_$consultantServiceId-$consultant_id>".round($singleData['ConsultantBilling']['discount'])."</span>";
						$physicianHtml.='</div>';
						$physicianHtml.='<div align="center" valign="top" class="chldDiv7">';
						if(!empty($singleData['ConsultantBilling']['paid_amount'])){
							$paid=$singleData['ConsultantBilling']['paid_amount'];
						}else{
							$paid=$singleData['ConsultantBilling']['amount']-$singleData['ConsultantBilling']['discount'];
						}
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".paid_amount",array('value' =>round($paid),'legend'=>false,'label'=>false,'class'=>'paid_'.$consultantServiceId.'-'.$consultant_id ,'style'=>'text-align:right;'));
						$physicianHtml.="<span class=paid_$consultantServiceId-$consultant_id>".round($paid)."</span>";
						$physicianHtml.='</div>';
						$physicianHtml.="</li>";
						$physicianHtml.="</div>";
						$physicianHtml.="<br>";
							
					}
				}
		   }
		}
		//$physicianHtml.=$formHelper->hidden("Billing.Consultant.idArray",array('value' => $idArray,'legend'=>false,'label'=>false));
		return $physicianHtml;
	}

	function surgeryHtml($patient,$wardServicesDataNew,$formHelper,$numberHelper,$surgeryServiceId,$hideCGHSCol,$webInstance){
	foreach($wardServicesDataNew as $uniqueSlot){//dpr($uniqueSlot);
			$surgeryNameKey = key($uniqueSlot);$paidAmt=0;
			if($surgeryNameKey =='start'){
			$v++;
			$lastSection = 'Conservative Charges';
			if($webInstance == 'kanpur'){
				foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
					$totalOtServiceCharge = $totalOtServiceCharge + $charge;
				}
			}
			$surgeryRCost = $uniqueSlot['cost']+$uniqueSlot['surgeon_cost']+$uniqueSlot['asst_surgeon_one_charge']+
			$uniqueSlot['asst_surgeon_two_charge']+$uniqueSlot['anaesthesist_cost']+$uniqueSlot['cardiologist_charge']+$uniqueSlot['ot_assistant']+
			$uniqueSlot['ot_charges']+$uniqueSlot['extra_hour_charge'] + $totalOtServiceCharge;

			//$surgeryRCost=$uniqueSlot['cost']+$uniqueSlot['anaesthesist_cost']+$uniqueSlot['ot_charges'];
			$paidAmt=$surgeryRCost-round($uniqueSlot['paid_amount']+$uniqueSlot['discount']);
			$disabled='';

			//Discount will be given "only ONCE"
			if(!empty($uniqueSlot['discount']))
				$exclude=' discount_excluded';
			else $exclude='';
			if($paidAmt<='0'){
				$disabled='disabled';
				$class='chk_child_paid refund_amt'	;
			}else{
				$class='chk_child'	;
			}
			if(empty($uniqueSlot['paid_amount'])){
				if(!empty($uniqueSlot['discount']))
					$class.=' reset_child_dis'	;
			}
			if($patient['Patient']['payment_category']!='cash' && $uniqueSlot['validity']> 1 ){
					$lastSection = '';
					$surgeryHtml.='<div>';
					$surgeryHtml.='<li>';
					$surgeryHtml.='<div align="center" class="tdBorder" style=" float: left;">';
					$surgeryHtml.=$formHelper->input("Billing.Surgery.".$uniqueSlot['opt_id'].".valChk",array('type'=>'checkbox','id'=>"surgery_$surgeryServiceId-".$uniqueSlot['opt_id'],$disabled,'class'=>"service_$surgeryServiceId ".' '.$class.' '.$exclude,'value'=>$paidAmt));
					$surgeryHtml.='</div>';
					$surgeryHtml.='<div class="tdBorderRt chldDiv1" style="font-size:12px;" ><i><strong>Surgical Charges</strong> </i>';
					$endOfSurgery = strtotime($uniqueSlot['surgery_billing_date']." +".$uniqueSlot['validity']." days");
					$startOfSurgery  =$uniqueSlot['start'] ;
					$surgeryHtml.="<i>(".$startOfSurgery."-".$endOfSurgery.")</i>";
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".editAmt",array('id'=>'txt_'.$uniqueSlot['opt_id'],$disabled,'class'=>'textAmt','value' =>$paidAmt,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".name",array('value' => $uniqueSlot['TariffList']['name'],'legend'=>false,'label'=>false));
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".discount",array('value' =>$uniqueSlot['discount'],'class'=>"discount_$surgeryServiceId-".$uniqueSlot['opt_id'],'legend'=>false,'label'=>false));
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".amount",array('value' => $surgeryRCost,'legend'=>false,'label'=>false));
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".id",array('value' => $uniqueSlot['opt_id'],'legend'=>false,'label'=>false));
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".service_id",array('value' => $surgeryServiceId,'legend'=>false,'label'=>false));
					$surgeryHtml.='</div>';
					if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
					$surgeryHtml.='<div align="center" class="tdBorderRt chldDiv2" >&nbsp;</div>';
						}
						$surgeryHtml.='<div align="center" class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.';" >&nbsp;</div>';
						$surgeryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv4" >&nbsp;</div>';
						$surgeryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5" >&nbsp;</div>';
						$surgeryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6">&nbsp;</div>';
						$surgeryHtml.='<div align="center" valign="top" class="chldDiv7">&nbsp;</div>';
						$surgeryHtml.='<div align="center" valign="top" class="chldDiv7">&nbsp;</div>';
						$surgeryHtml.='</li>';
						$surgeryHtml.='</div>';
						$v++;
		}
		//if surgery is package
		if($uniqueSlot['validity']> 1){
					$surgeryHtml.='<div>';
					$surgeryHtml.='<li>';
					$surgeryHtml.='<div align="center" class="tdBorder" style=" float: left;">';
					$surgeryHtml.=$formHelper->input("Billing.Surgery.".$uniqueSlot['opt_id'].".valChk",array('type'=>'checkbox','id'=>"surgery_$surgeryServiceId-".$uniqueSlot['opt_id'],$disabled,'class'=>"service_$surgeryServiceId".' '.$class.' '.$exclude,'value'=>$paidAmt));
					$surgeryHtml.='</div>';
					$surgeryHtml.='<div class="tdBorderRt chldDiv1">';
					$surgeryHtml.=$uniqueSlot['TariffList']['name'];
					$surgeryHtml.="<br><i>(".$uniqueSlot['start']."-".$uniqueSlot['end'].")</i>";
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".editAmt",array('id'=>'txt_'.$uniqueSlot['opt_id'],$disabled,'class'=>'textAmt','value' =>$paidAmt,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".name",array('value' => $uniqueSlot['TariffList']['name'],'legend'=>false,'label'=>false));
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".amount",array('value' => $surgeryRCost,'legend'=>false,'label'=>false));
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".id",array('value' => $uniqueSlot['opt_id'],'legend'=>false,'label'=>false));
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".service_id",array('value' => $surgeryServiceId,'legend'=>false,'label'=>false));
					$surgeryHtml.='</div>';
					if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
			         	$surgeryHtml.='<div align="center" class="tdBorderRt chldDiv2" >';
			         	$surgeryHtml.=$uniqueSlot['moa_sr_no'];
			         	$surgeryHtml.='</div>';
			        }
			        $surgeryHtml.='<div align="center" class="tdBorderRt chldDiv3" style=" '.$hideCGHSCol.' ">';
			        $surgeryHtml.='</div>';
			        $surgeryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv4" >';
			        $surgeryHtml.=$uniqueSlot['cost'];
			        $surgeryHtml.='</div>';
			        $surgeryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5">';
			        $surgeryHtml.='1';
			        $surgeryHtml.='</div>';
			        $surgeryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6" >';
			        $surgeryHtml.=$uniqueSlot['cost'];
			        $totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost'];
			        $surgeryHtml.='</div>';
			        $surgeryHtml.='<div align="center" valign="top" class="chldDiv7" >';
			        $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".discount",array('value' =>round($uniqueSlot['discount']),'class'=>"discount_$surgeryServiceId-".$uniqueSlot['opt_id'],'legend'=>false,'label'=>false));
			        $sur_id=$uniqueSlot['opt_id'];
			        $surgeryHtml.="<br><br><span class=discount_$surgeryServiceId-$sur_id>".round($uniqueSlot['discount'])."</span>";
			        $surgeryHtml.='</div>';
			        $surgeryHtml.='<div align="center" valign="top" class="chldDiv7" >';
			        if(!empty($uniqueSlot['paid_amount'])){
		            	$surPaid=$uniqueSlot['paid_amount'];
		            }else{
						$surPaid=$totalNewWardCharges-$uniqueSlot['discount'];
					}
					$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".paid_amount",array('value' =>round($surPaid),'legend'=>false,'label'=>false,'class'=>"paid_$surgeryServiceId-".$uniqueSlot['opt_id'],'style'=>'text-align:right;'));
					$surgeryHtml.="<br><br><span class=paid_$surgeryServiceId-$sur_id>".round($surPaid)."</span>";
					$surgeryHtml.='</div>';
					$surgeryHtml.='</li>';
					$surgeryHtml.='</div>';
				}else{
					 $surgeryHtml.='<div>';
					 $surgeryHtml.='<li>';
					 $surgeryHtml.='<div align="center" class="tdBorder" style=" float: left;">';
					 $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".editAmt",array('id'=>'txt_'.$uniqueSlot['opt_id'],$disabled,'class'=>'textAmt','value' =>$paidAmt,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
					 $surgeryHtml.=$formHelper->input("Billing.Surgery.".$uniqueSlot['opt_id'].".valChk",array('type'=>'checkbox','id'=>"surgery_$surgeryServiceId-".$uniqueSlot['opt_id'],$disabled,'class'=>"service_$surgeryServiceId".' '.$class.' '.$exclude,'value'=>$paidAmt));
					 $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".name",array('value' => $uniqueSlot['TariffList']['name'],'legend'=>false,'label'=>false));
					 $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".amount",array('value' => $surgeryRCost,'legend'=>false,'label'=>false));
					 $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".id",array('value' => $uniqueSlot['opt_id'],'legend'=>false,'label'=>false));
					 $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".service_id",array('value' => $surgeryServiceId,'legend'=>false,'label'=>false));
					 $surgeryHtml.='</div>';
					 $surgeryHtml.='<div class="tdBorderRt chldDiv1">';
					 $surgeryHtml.=$uniqueSlot['name'];
					 $surgeryHtml.="<i>(".$uniqueSlot['start']."-".$uniqueSlot['end'].")</i>";
					 if($uniqueSlot['doctor']){
					 	$surgeryHtml.= '</br>&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Charges' ;
					 	$surgeryHtml.='<i> ('.$uniqueSlot['doctor'].','.$uniqueSlot['doctor_education'].')</i>';
					 }
					 if($uniqueSlot['asst_surgeon_one']){
					 	$surgeryHtml.= '</br>&nbsp;&nbsp;&nbsp;&nbsp;Asst. Surgeon I Charges' ;
					 	$surgeryHtml.= '<i> ('.$uniqueSlot['asst_surgeon_one'].')</i>';
					 }
					 if($uniqueSlot['asst_surgeon_two']){
					 	$surgeryHtml.= '</br>&nbsp;&nbsp;&nbsp;&nbsp;Asst. Surgeon II Charges' ;
					 	$surgeryHtml.= '<i> ('.$uniqueSlot['asst_surgeon_two'].')</i>';
					 }
					 //anaesthesia charges
					 $surgeryHtml.= ($uniqueSlot['anaesthesist'])?'<br/>&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Charges':'' ;
					 $surgeryHtml.=($uniqueSlot['anaesthesist'])?'<i> ('.$uniqueSlot['anaesthesist'].')</i>':'';
					 //EOF anaesthesia charges

					 if($uniqueSlot['cardiologist']){
					 	$surgeryHtml.= '</br>&nbsp;&nbsp;&nbsp;&nbsp;Cardiology Charges' ;
					 	$surgeryHtml.= '<i> ('.$uniqueSlot['cardiologist'].')</i>';
					 }
					 if($uniqueSlot['ot_assistant']){
					 	$surgeryHtml.= '</br>&nbsp;&nbsp;&nbsp;&nbsp;OT Assistant Charges' ;
					 }

					 if(!empty($uniqueSlot['ot_charges'])){
					 	$surgeryHtml.= '<br>&nbsp;&nbsp;&nbsp;&nbsp;OT Charges ';
					 }
					 if($uniqueSlot['extra_hour_charge'] != 0){
					 	$surgeryHtml.= '<br>&nbsp;&nbsp;&nbsp;&nbsp;Extra OT Charges ';
					 }
					 if($webInstance == 'kanpur'){
					 	foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
					 		$surgeryHtml.= '<br>&nbsp;&nbsp;&nbsp;&nbsp;'.$name;
					 	}
					 }
					 $splitDate = explode(" ",$uniqueSlot['start']);
					 if($uniqueSlot['anaesthesist_cost']){
					 	$valueForAnaesthesist = '<br/>&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Charges<i> ('.$uniqueSlot['anaesthesist'].')</i>';
					 }else{
					 	$valueForAnaesthesist ='' ;
					 }
					 $valueForSurgeon =  $uniqueSlot['name'].'('.
					 		$uniqueSlot['start'].')</br>'.
					 		'&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Charges <i>('.$uniqueSlot['doctor'].','.
					 		$uniqueSlot['doctor_education'].')</i>)'.$valueForAnaesthesist ;
					 	
					 //EOF anaesthesia charges
					 if($uniqueSlot['anaesthesist_cost']){
			            	$valueForAnaesthesist = '<br/>&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Charges<i> ('.$uniqueSlot['anaesthesist'].')</i>';
			            }else{
			            	$valueForAnaesthesist ='' ;
			            }
			            if($uniqueSlot['ot_charges']){
			            	$valueForOtCharges = '<br/>&nbsp;&nbsp;&nbsp;&nbsp;OT Charges';
			            }else{
			            	$valueForOtCharges ='' ;
			            }
			            $valueForSurgeon =  $uniqueSlot['TariffList']['name'].'('.
					            $uniqueSlot['start'].')</br>'.
					            '&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Charges <i>('.$uniqueSlot['doctor'].')</i>)'.$valueForAnaesthesist.', '.$valueForOtCharges ;



			            $surgeryHtml.='</div>';
			            if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
		          			$surgeryHtml.='<div align="center" class="tdBorderRt chldDiv2">';
		          			$surgeryHtml.=$uniqueSlot['moa_sr_no'];
	          				$surgeryHtml.='--</div>';
		          	    }
		          	    $surgeryHtml.='<div align="center" class="tdBorderRt chldDiv3" style=" '.$hideCGHSCol.'">';
		          	    $surgeryHtml.=$uniqueSlot['cghs_code'];
		          	    $surgeryHtml.='--</div>';
		          	    $surgeryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv4" >';
		          	    $surgeryHtml.="<br>".$uniqueSlot['cost'];
		          	    if($uniqueSlot['doctor']) $surgeryHtml.="<br>".$uniqueSlot['surgeon_cost'];;
		          	    if($uniqueSlot['asst_surgeon_one'])
		          	    	$surgeryHtml.="<br>".$uniqueSlot['asst_surgeon_one_charge'];
		          	    else
		          	    	$uniqueSlot['asst_surgeon_one_charge'] = 0;
		          	    if($uniqueSlot['asst_surgeon_two'])
		          	    	$surgeryHtml.="<br>".$uniqueSlot['asst_surgeon_two_charge'];
		          	    else
		          	    	$uniqueSlot['asst_surgeon_two_charge'] = 0;
		          	    if($uniqueSlot['anaesthesist'])
		          	    	$surgeryHtml.="<br>".$uniqueSlot['anaesthesist_cost'];
		          	    else
		          	    	$uniqueSlot['anaesthesist_cost'] = 0;
		          	    if($uniqueSlot['cardiologist'])
		          	    	$surgeryHtml.="<br>".$uniqueSlot['cardiologist_charge'];
		          	    else
		          	    	$uniqueSlot['cardiologist_charge'] = 0;
		          	    if(!empty($uniqueSlot['ot_assistant']))$surgeryHtml.="<br>".$uniqueSlot['ot_assistant'];
		          	    if(!empty($uniqueSlot['ot_charges'])) $surgeryHtml.="<br>".$uniqueSlot['ot_charges'];
		          	    if($uniqueSlot['extra_hour_charge'] != 0) $surgeryHtml.="<br>".$uniqueSlot['extra_hour_charge'];


		          	    $surgeryHtml.='</div>';
		          	    $surgeryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5" >';
		          	    $surgeryHtml.="<br>1";
		          	    if($uniqueSlot['doctor']) $surgeryHtml.="<br>1";;
		          	    if($uniqueSlot['asst_surgeon_one'])
		          	    	$surgeryHtml.="<br>1";
		          	    if($uniqueSlot['asst_surgeon_two'])
		          	    	$surgeryHtml.="<br>1";
		          	    if($uniqueSlot['anaesthesist'])
		          	    	$surgeryHtml.="<br>1";
		          	    if($uniqueSlot['cardiologist'])
		          	    	$surgeryHtml.="<br>1";
		          	    if(!empty($uniqueSlot['ot_assistant']))$surgeryHtml.="<br>1";
		          	    if(!empty($uniqueSlot['ot_charges'])) $surgeryHtml.="<br>1";
		          	    if($uniqueSlot['extra_hour_charge'] != 0) $surgeryHtml.="<br>1";
		          	    $surgeryHtml.='</div>';
		          	    $surgeryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6">';
		          	    $surgeryHtml.="<br>".$uniqueSlot['cost'];
		          	    if($uniqueSlot['doctor']) $surgeryHtml.="<br>".$uniqueSlot['surgeon_cost'];;
		          	    if($uniqueSlot['asst_surgeon_one'])
		          	    	$surgeryHtml.="<br>".$uniqueSlot['asst_surgeon_one_charge'];
		          	    else
		          	    	$uniqueSlot['asst_surgeon_one_charge'] = 0;
		          	    if($uniqueSlot['asst_surgeon_two'])
		          	    	$surgeryHtml.="<br>".$uniqueSlot['asst_surgeon_two_charge'];
		          	    else
		          	    	$uniqueSlot['asst_surgeon_two_charge'] = 0;
		          	    if($uniqueSlot['anaesthesist'])
		          	    	$surgeryHtml.="<br>".$uniqueSlot['anaesthesist_cost'];
		          	    else
		          	    	$uniqueSlot['anaesthesist_cost'] = 0;
		          	    if($uniqueSlot['cardiologist'])
		          	    	$surgeryHtml.="<br>".$uniqueSlot['cardiologist_charge'];
		          	    else
		          	    	$uniqueSlot['cardiologist_charge'] = 0;
		          	    if(!empty($uniqueSlot['ot_assistant']))$surgeryHtml.="<br>".$uniqueSlot['ot_assistant'];
		          	    if(!empty($uniqueSlot['ot_charges'])) $surgeryHtml.="<br>".$uniqueSlot['ot_charges'];
		          	    if($uniqueSlot['extra_hour_charge'] != 0) $surgeryHtml.="<br>".$uniqueSlot['extra_hour_charge'];

		          	    foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
		            			echo '<br>'.$charge;
		            			$totalOtServiceCharge = $totalOtServiceCharge + $charge;
		            		}
		            		 
		            		$totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost']+$uniqueSlot['surgeon_cost']+$uniqueSlot['asst_surgeon_one_charge']+
		            		$uniqueSlot['asst_surgeon_two_charge']+$uniqueSlot['anaesthesist_cost']+$uniqueSlot['cardiologist_charge']+$uniqueSlot['ot_assistant']+
		            		$uniqueSlot['ot_charges']+$uniqueSlot['extra_hour_charge'] + $totalOtServiceCharge;
		            		$surgeryHtml.='</div>';
		            		$surgeryHtml.='<div align="center" valign="top" class="chldDiv7" >';
		            		$surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".discount",array('value' =>round($uniqueSlot['discount']),'class'=>"discount_$surgeryServiceId-".$uniqueSlot['opt_id'],'legend'=>false,'label'=>false));
		            		$sur_id=$uniqueSlot['opt_id'];
		            		$surgeryHtml.="<br><br><span class=discount_$surgeryServiceId-$sur_id>".round($uniqueSlot['discount'])."</span>";
		            		$surgeryHtml.='</div>';
		            		$surgeryHtml.='<div align="center" valign="top" class="chldDiv7" >';
		            		if(!empty($uniqueSlot['paid_amount'])){
			            	$surPaid=$uniqueSlot['paid_amount'];
			            }else{
			            	$surPaid=$totalNewWardCharges-$uniqueSlot['discount'];
			            }
			            $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".paid_amount",array('value' =>round($surPaid),'legend'=>false,'label'=>false,'class'=>"paid_$surgeryServiceId-".$uniqueSlot['opt_id'],'style'=>'text-align:right;'));
			            $surgeryHtml.="<br><br><span class=paid_$surgeryServiceId-$sur_id>".round($surPaid)."</span>";
			            $surgeryHtml.='</div>';
			            $surgeryHtml.='</li>';
			            $surgeryHtml.='</div>';
				}
					
		  	}
		  }
		  return $surgeryHtml;
    }
     
    function roomHtml($patient,$wardServicesDataNew,$formHelper,$numberHelper,$hospitalType,$wardServiceId,$hideCGHSCol){
			//$dateFormatComponent = new DateFormatHelper();
			$count=0;
			foreach($wardServicesDataNew as $uniqueSlot){
				$count++;
				$srNo++;
				$v++;
				$roomHtml.='<div>';
				$roomHtml.='<li>';
				$wardCostPerWard = $uniqueSlot['rate'];
				#echo $wardCostPerWard;exit;
				$daysCountPerWard=$uniqueSlot['days'];
				$totalWardNewCost = $totalWardNewCost + ($daysCountPerWard * $wardCostPerWard);
				$totalWardDays = $uniqueSlot['days'];
				$totalWardDaysW = count($uniqueSlot[$wardNameKey]);
				$wardId=$uniqueSlot['ward_id'];
				$splitDateIn = explode(" ",$uniqueSlot['in']);
				$splitDateOut = explode(" ",$uniqueSlot['out']);
				$inDate=$uniqueSlot['in'];//.' '.$splitDateIn[1];
				$outDate=$uniqueSlot['out'];
				$wardRCost=$uniqueSlot['days']*$wardCostPerWard;
				$paidAmt=$wardRCost-round($uniqueSlot['paid_amount']+$uniqueSlot['discount']);
				//debug($uniqueSlot['paid_amount']);
				if($uniqueSlot['paid_amount']){
						$disable='disabled';
						$class='chk_child_paid refund_amt'; //exclude_discount'	;
					}else{
						$class='chk_child';// exclude_discount'	;
					}

					if(empty($uniqueSlot['paid_amount'])){
						if(!empty($uniqueSlot['discount']))
							$class.=' reset_child_dis'	;
					}

					if(!empty($uniqueSlot['discount']))
						$exclude=' discount_excluded';
					else $exclude='';
					/*if($uniqueSlot['paid_amount']>0){
						$class.=' chk_child_paid';
					}*/
					  $roomHtml.='<div align="center" class="tdBorder" style=" float: left;">';
					  $roomHtml.=$formHelper->input("Billing.RoomTariff.".$wardId.".valChk",array('type'=>'checkbox',$disable,'id'=>"ward_$wardServiceId-$wardId",'class'=>$class.' '. $exclude.' '.'service_'.$wardServiceId,'value'=>$paidAmt));
					  $roomHtml.='</div>';
					  $roomHtml.='<div class="tdBorderRt chldDiv1">';
					  $roomHtml.=$uniqueSlot['name'].' ('.$inDate.'-'.$outDate.')';
					  $roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".editAmt",array('id'=>'txt_'.$wardId,$disabled,'class'=>'textAmt','value' =>$paidAmt,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
					  $roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".name",array('value' => $uniqueSlot['name'],'legend'=>false,'label'=>false));
					  $roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".id",array('value' =>$wardId,'legend'=>false,'label'=>false));
					  $roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".service_id",array('value' => $wardServiceId,'legend'=>false,'label'=>false));
					  $roomHtml.='</div>';
					  if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
				          	$roomHtml.='<div align="center" class="tdBorderRt chldDiv2">';
				          	$roomHtml.=$uniqueSlot[$uniqueSlot['name']]['moa_sr_no'];
			          		$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".moa_sr_no",array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $uniqueSlot[$uniqueSlot['name']]['moa_sr_no'],'legend'=>false,'label'=>false));
			          		$roomHtml.='--</div>';
			          	}
			          	$roomHtml.='<div align="center" class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.' ">';
			          	if($hospitalType == 'NABH'){
			   				$roomHtml.=$uniqueSlot[$uniqueSlot['name']]['cghs_code'];
			   				$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".nabh_non_nabh",array('value' => $uniqueSlot[$uniqueSlot['name']]['cghs_code'],'legend'=>false,'label'=>false));
			   			}else{
			   				$roomHtml.=$uniqueSlot[$uniqueSlot['name']]['cghs_code'];
			   				$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".nabh_non_nabh",array('value' => $uniqueSlot[$uniqueSlot['name']]['cghs_code'],'legend'=>false,'label'=>false));
			   			}
			   			$roomHtml.='--</div>';
			   			$roomHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv4" >';
			   			$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".unit",array('value' => $uniqueSlot['days'],'legend'=>false,'label'=>false,'style'=>'text-align:center'));
			   			$roomHtml.=$numberHelper->format($wardCostPerWard);
			   			$roomHtml.='</div>';
			   			$roomHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5" >';
			   			$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".rate",array('value' => $numberHelper->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
			   			$roomHtml.=$uniqueSlot['days'];
			   			$roomHtml.='</div>';
			   			$roomHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6" >';
			   			$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".amount",array('value' => $numberHelper->format(($uniqueSlot['days']*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
			   			$roomHtml.=$numberHelper->format($uniqueSlot['days']*$wardCostPerWard);
			   			$totalNewWardCharges = $totalNewWardCharges + ($uniqueSlot['days']*$wardCostPerWard);
			   			$roomHtml.='</div>';
			   			$roomHtml.='<div align="center" valign="top" class="chldDiv7">';
			   			$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".discount",array('value' => round($uniqueSlot['discount']),'class'=>"discount_$wardServiceId-$wardId",'legend'=>false,'label'=>false));
					    $roomHtml.="<span class=discount_$wardServiceId-$wardId>".round($uniqueSlot['discount'])."</span>";
			   			$roomHtml.='</div>';
			   			$roomHtml.='<div align="center" valign="top" class="chldDiv7">';
			   			if(!empty($uniqueSlot['paid_amount'])){
			   				$paid=$uniqueSlot['paid_amount'];
			   			}else{
							$paid=$uniqueSlot['days']*$wardCostPerWard-$uniqueSlot['discount'];
						}
						$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".paid_amount",array('value' => round($paid),'class'=>"paid_$wardServiceId-$wardId",'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						$roomHtml.="<span class=paid_$wardServiceId-$wardId>".round($paid)."</span>";
						$roomHtml.='</div>';
						$roomHtml.='</li>';
						$roomHtml.='</div><br>';
						$v++;
						 
						 
				}

				return $roomHtml;
	}

	function mandatoryHtml($patient,$resetMandatoryServices,$formHelper,$numberHelper,$mandatoryKey,
							$hideCGHSCol,$doctorChargesData,$doctorRate,$totalWardDays,$nursingChargesData,$nursingRate,
							$tariffNurseListId,$tariffDocListId,$doctNurseShow,$doctorPaidCharges,$nursePaidCharges,
							$doctorDiscount,$nurseDiscount){
		#pr($resetMandatoryServices);exit;
		$docFlag=0;$nurseFlag=0;
		//EOF pankaj
		foreach($resetMandatoryServices as $resetNursingServicesName=>$nursingService){
			$k++;
			$totalUnit= $nursingService['qty'];
			$srNo++;$paidAmount=0;
			$mandatoryHtml.='<div>';
			$mandatoryHtml.='<li>';
			$mandatoryHtml.='<div align="center" class="tdBorder" style="float: left;">';
			if(!empty($nursingService['cost'])){
						$cost=$nursingService['qty']*$nursingService['cost'];
			}else{
				$cost=0;
			}
			$paidAmt=$cost-round($nursingService['paid_amount']+$nursingService['discount']);

			if(!empty($nursingService['discount'])){
				$exclude='discount_excluded';
			}else{
				$exclude='';
			}
			if($nursingService['paid_amount']){
				$disable='disabled';
				$class='chk_child_paid refund_amt'	;
			}else{
				$class='chk_child';
			}

			if(empty($nursingService['paid_amount'])){
				if(!empty($nursingService['discount']))
					$class.=' reset_child_dis'	;
			}
			$mandatoryHtml.=$formHelper->input("Billing.Mandatory.".$nursingService['service_bill_id'].".valChk",array('type'=>'checkbox','id'=>'mandatory_'.$mandatoryKey.'-'.$nursingService['service_bill_id'],$disable ,'class'=>$class.' '.$exclude.' '.'service_'.$mandatoryKey,'label'=>false,'div'=>false,'value'=>$paidAmt));
			$mandatoryHtml.='</div>';
			$mandatoryHtml.='<div class="tdBorderRt chldDiv1">';
			$mandatoryHtml.=$nursingService['name'];
			$mandatoryHtml.='&nbsp;'.$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".editAmt",array('value' => $paidAmt,$disable,'id'=>'txt_'.$nursingService['service_bill_id'],'class'=>'textAmt','legend'=>false,'label'=>false,'style'=>'width:75px; padding:2px'));
			$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".name",array('value' => $nursingService['name'],'legend'=>false,'label'=>false));
			$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".service_bill_id",array('value' => $nursingService['service_bill_id'],'legend'=>false,'label'=>false));
			$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".id",array('value' =>$nursingService['tariff_list_id'],'legend'=>false,'label'=>false));
			$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".service_id",array('value' => $mandatoryKey,'legend'=>false,'label'=>false));
			$mandatoryHtml.='</div>';
			if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
					$mandatoryHtml.='<div align="center" class="tdBorderRt chldDiv2">';
					if($nursingService['moa_sr_no']!='')
						$mandatoryHtml.=$nursingService['moa_sr_no'];
					$mandatoryHtml.='&nbsp;';
					//$mandatoryHtml.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][moa_sr_no]",'value' => $nursingService['moa_sr_no'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					$mandatoryHtml.='</div>';
				}
				$mandatoryHtml.='<div align="center" class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.';">';
				if($nursingService['nabh_non_nabh']!='')
					$mandatoryHtml.=$nursingService['nabh_non_nabh'];
				else $mandatoryHtml.='--&nbsp;';
				//$mandatoryHtml.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][nabh_non_nabh]",'value' => $nursingService['nabh_non_nabh'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
				$mandatoryHtml.='</div>';
				$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv4" >';
				//$totalUnit = array_sum($nursingService['qty']);
				$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".rate",array('value' => $nursingService['cost'],'legend'=>false,'label'=>false,'id' => 'nursing_service_rate','style'=>'text-align:right;'));
				$mandatoryHtml.=$numberHelper->format($nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
				///echo $nursingService['cost'];
				$mandatoryHtml.='</div>';
				$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5">';
				if($totalUnit<1) $totalUnit=1;
				$mandatoryHtml.=$totalUnit;
				$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".unit",array('value' => $totalUnit,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
				$mandatoryHtml.='</div>';
				$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6" >';
				$totalNursingCharges1=0;
				$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".amount",array('value' => $numberHelper->format($totalUnit*$nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'nursing_service_amount','style'=>'text-align:right;'));
				$mandatoryHtml.=$numberHelper->format($totalUnit*$nursingService['cost']);
				$totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];
				//echo $totalNursingCharges1;
				$mandatoryHtml.='</div>';
				$mandatoryHtml.='<div align="center" valign="top" class="chldDiv7">';
				$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".discount",array('value' => round($nursingService['discount']),'class'=>'discount_'.$mandatoryKey.'-'.$nursingService['service_bill_id'],'legend'=>false,'label'=>false));
				$serId=$nursingService['service_bill_id'];
				$mandatoryHtml.="<span class=discount_$mandatoryKey-$serId>".round($nursingService['discount'])."</span>";
				$mandatoryHtml.='</div>';
				$mandatoryHtml.='<div align="center" valign="top" class="chldDiv7">';
				if(!empty($nursingService['paid_amount'])){
						$manPaid=$nursingService['paid_amount'];
				}else{
					$manPaid=$totalUnit*$nursingService['cost']-$nursingService['discount'];
				}
				$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".paid_amount",array('value' => round($manPaid),'legend'=>false,'label'=>false,'class'=>'paid_'.$mandatoryKey.'-'.$nursingService['service_bill_id'],'style'=>'text-align:right;'));
				$mandatoryHtml.="<span class=paid_$mandatoryKey-$serId>".round($manPaid)."</span>";
				$mandatoryHtml.='</div>';
				$mandatoryHtml.='</li>';
				$mandatoryHtml.='</div><br>';
				if($tariffDocListId==$nursingService['tariff_list_id']){
					$docFlag=1;
				}

				if($tariffNurseListId==$nursingService['tariff_list_id']){
					$nurseFlag=1;
				}

		} //Nursing and Doctor charges for ipd patient

		if($patient['Patient']['admission_type']=='IPD'){
				if($doctNurseShow=='1'){//Condition to show doctor and nursing service
					if($docFlag==0){
					$mandatoryHtml.='<div>';
					$mandatoryHtml.='<li>';$disable='';
					$docAmt=$totalWardDays*$doctorRate;
					$paidDocAmt=$docAmt-round($doctorPaidCharges+$doctorDiscount);
					if(!empty($doctorDiscount)){
						$exclude='discount_excluded';
					}else{
						$exclude='';
					}
					if($doctorPaidCharges){
						$disable='disabled';
						$class='chk_child_paid refund_amt'	;//exclude_discount
					}else{
						$class='chk_child ';//exclude_discount
					}
					if(empty($doctorPaidCharges)){
						if(!empty($doctorDiscount))
							$class.=' reset_child_dis'	;
					}
					/*if($doctorPaidCharges>0){
						$class.=' chk_child_paid';
					}*/
					$mandatoryHtml.='<div align="center" class="tdBorder" style="float: left;">';
					$mandatoryHtml.=$formHelper->input("Billing.Mandatory.doctor_charges.valChk",array('type'=>'checkbox',$disable,'id'=>'mandatory_'.$mandatoryKey.'-doc','class'=>$class.' '.$exclude.' '.'service_'.$mandatoryKey , 'value'=>$paidDocAmt));
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='<div class="tdBorderRt chldDiv1">';
					$mandatoryHtml.='Doctor Charges';
					$mandatoryHtml.='&nbsp;'.$formHelper->hidden("Billing.Mandatory.doctor_charges.editAmt",array('value' =>$paidDocAmt,$disable,'id'=>'txt_doc','class'=>'textAmt','legend'=>false,'label'=>false,'style'=>'width:75px; padding:2px'));
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.name",array('value' => 'DoctorsCharges','legend'=>false,'label'=>false));
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.id",array('value' =>$tariffDocListId,'legend'=>false,'label'=>false));
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.service_id",array('value' => $mandatoryKey,'legend'=>false,'label'=>false));
					$mandatoryHtml.='</div>';
					if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
			 			$mandatoryHtml.='<div align="center" class="tdBorderRt chldDiv2">';
			 			$mandatoryHtml.=$doctorChargesData['TariffAmount']['moa_sr_no'];
			 			$mandatoryHtml.='&nbsp;';
			 			//$mandatoryHtml.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][moa_sr_no]",'value' => $nursingService['moa_sr_no'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			 			$mandatoryHtml.='</div>';
			 		}
			 		 
			 		$mandatoryHtml.='<div align="center" class="tdBorderRt chldDiv3" style=" '.$hideCGHSCol.';">';
			 		$mandatoryHtml.=$doctorChargesData['TariffList']['cghs_code'];
			 		//$mandatoryHtml.=$formHelper->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $doctorChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));
			 		$mandatoryHtml.='--</div>';
			 		$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv4">';
			 		$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.unit",array('value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
			 		$mandatoryHtml.=$doctorRate;
				 	$mandatoryHtml.='</div>';
				 	$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5" >';
				 	$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.rate",array('value' => $doctorRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
				 	$mandatoryHtml.=$totalWardDays;
				 	$mandatoryHtml.='</div>';
				 	$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6" >';
				 	$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.amount",array('value' => $numberHelper->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
				 	$mandatoryHtml.=$numberHelper->format($totalWardDays*$doctorRate);
				 	$totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$doctorRate);
				 	$mandatoryHtml.='</div>';
				 	$mandatoryHtml.='<div align="center" valign="top" class="chldDiv7">';
				 	$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.discount",array('value' =>round($doctorDiscount) ,'class'=>'discount_'.$mandatoryKey.'-doc','legend'=>false,'label'=>false));
				 	$mandatoryHtml.="<span class=discount_$mandatoryKey-doc>".round($doctorDiscount)."</span>";
				 	$mandatoryHtml.='</div>';
				 	$mandatoryHtml.='<div align="center" valign="top" class="chldDiv7">';
				 	if(!empty($doctorPaidCharges)){
						$paidDoc=$doctorPaidCharges;
					}else{
						$paidDoc=$totalWardDays*$doctorRate-$doctorDiscount;
					}
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.paid_amount",array('value' =>round($paidDoc),'legend'=>false,'label'=>false,'class'=>'paid_'.$mandatoryKey.'-doc','style'=>'text-align:right;'));
					$mandatoryHtml.="<span class=paid_$mandatoryKey-doc>".round($paidDoc)."</span>";
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='</li>';
					$mandatoryHtml.='</div><br>';
				 	}

				 	if($nurseFlag==0){

				 	//Nursing Charges
				 	$nurseRCost=$totalWardDays*$nursingRate;$disable='';
				 	$paidNurseAmt=$nurseRCost-round($nursePaidCharges+$nurseDiscount);
				 	if(!empty($doctorDiscount)){
				 		$exclude='discount_excluded';
				 	}else{
				 		$exclude='';
				 	}
				 	if($nursePaidCharges){
						$disable='disabled';
						$class='chk_child_paid refund_amt'	;// exclude_discount
					}else{
						$class='chk_child ';//exclude_discount
					}
					/*if($nursePaidCharges>0){
						$class.=' chk_child_paid';
					}*/
					if(empty($nursePaidCharges)){
						if(!empty($nurseDiscount))
							$class.=' reset_child_dis'	;
					}

				 	$mandatoryHtml.='<div>';
				 	$mandatoryHtml.='<li>';
				 	$mandatoryHtml.='<div align="center" class="tdBorder" style="float: left;">';
				 	$mandatoryHtml.=$formHelper->input("Billing.Mandatory.nursing_charges.valChk",array('type'=>'checkbox',$disable,'id'=>'mandatory_'.$mandatoryKey.'-nurse','class'=>$class.' '.$exclude.' '.'service_'.$mandatoryKey,'value'=>$paidNurseAmt));
				 	$mandatoryHtml.='</div>';
				 	$mandatoryHtml.='<div class="tdBorderRt chldDiv1">';
				 	$mandatoryHtml.='Nursing Charges';
				 	$mandatoryHtml.='&nbsp;'.$formHelper->hidden("Billing.Mandatory.nursing_charges.editAmt",array('value' => $paidNurseAmt,'id'=>'txt_nurse',$disable,'class'=>'textAmt','legend'=>false,'label'=>false,'style'=>'width:75px; padding:2px'));
			 		$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.name",array('value' => 'NursingCharges','legend'=>false,'label'=>false));
			 		$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.id",array('value' =>$tariffNurseListId,'legend'=>false,'label'=>false));
			 		$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.service_id",array('value' => $mandatoryKey,'legend'=>false,'label'=>false));
			 		$mandatoryHtml.='</div>';
				 	if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
						$mandatoryHtml.='<div align="center" class="tdBorderRt chldDiv2">';
						$mandatoryHtml.=$nursingChargesData['TariffAmount']['moa_sr_no'];
						$mandatoryHtml.='&nbsp;';
						$mandatoryHtml.='</div>';
					}
					$mandatoryHtml.='<div align="center" class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.';">';
					$mandatoryHtml.=$nursingChargesData['TariffList']['cghs_code'];
					$mandatoryHtml.='--</div>';
					$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv4">';
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.unit",array('value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
					$mandatoryHtml.=$numberHelper->format($nursingRate);
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='<div class="tdBorderRt chldDiv5" align="center" valign="top">';
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.rate",array('value' => $nursingRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					$mandatoryHtml.=$totalWardDays;
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6" >';
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.amount",array('value' => $numberHelper->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					$mandatoryHtml.=$numberHelper->format($totalWardDays*$nursingRate);
					$totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$nursingRate);
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='<div align="center" valign="top" class="chldDiv7">';
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.discount",array('value' => round($nurseDiscount),'class'=>'discount_'.$mandatoryKey.'-nurse','legend'=>false,'label'=>false));
					$mandatoryHtml.="<span class=discount_$mandatoryKey-nurse>".round($nurseDiscount)."</span>";
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='<div align="center" valign="top" class="chldDiv7">';
					if(!empty($nursePaidCharges)){
						$paidNurse=$nursePaidCharges;
					}else{
						$paidNurse=$totalWardDays*$nursingRate-$nurseDiscount;
					}
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.paid_amount",array('value' => round($paidNurse),'legend'=>false,'label'=>false,'class'=>'paid_'.$mandatoryKey.'-nurse','style'=>'text-align:right;'));
					$mandatoryHtml.="<span class=paid_$mandatoryKey-nurse>".round($paidNurse)."</span>";
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='</li>';
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='<br>';
					}
				}//EOF show service flag
			}
			return $mandatoryHtml;
 		}

 		function labHtml($patient,$labRate,$laboratoryKey,$formHelper,$numberHelper,$hideCGHSCol){
			foreach($labRate as $labKey=>$labCost){
					$paidAmt=0;
					$labHtml.='<div>';
					$labHtml.='<li>';
					$labHtml.='<div valign="top" class="tdBorder" style="float: left;">';
					$paidAmt=$labCost['LaboratoryTestOrder']['amount']-round($labCost['LaboratoryTestOrder']['paid_amount']+$labCost['LaboratoryTestOrder']['discount']);
					$disable='';
					if(!empty($labCost['LaboratoryTestOrder']['discount'])){
           				$exclude='discount_excluded';
           			}else{
           				$exclude='';
           			}
           			if($labCost['LaboratoryTestOrder']['paid_amount']>0){
           				$disable='disabled';
           				$class='chk_child_paid refund_amt'	;
					}else{
						$class='chk_child'	;
					}

					if(empty($labCost['LaboratoryTestOrder']['paid_amount'])){
						if(!empty($labCost['LaboratoryTestOrder']['discount']))
							$class.=' reset_child_dis'	;
					}
					$labHtml.=$formHelper->input("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".valChk",array('type'=>'checkbox','id'=>'laboratory_'.$laboratoryKey.'-'.$labCost['LaboratoryTestOrder']['id'],$disable,'class'=>$class.' '.$exclude.' '.'service_'.$laboratoryKey,'value'=>$paidAmt));
					$labHtml.='</div>';
					$labHtml.='<div class="tdBorderRt chldDiv1">';
					$labHtml.=$labCost['Laboratory']['name'];
					$labHtml.='&nbsp;'.$formHelper->hidden("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".editAmt",array('value' =>$paidAmt,$disable,'id'=>'txt_'.$labCost['LaboratoryTestOrder']['id'],'class'=>'textAmt','legend'=>false,'label'=>false,'style'=>'width:75px; padding:2px'));
					$labHtml.=$formHelper->hidden("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".name",array('value' =>$labCost['Laboratory']['name'],'legend'=>false,'label'=>false));
					$labHtml.=$formHelper->hidden("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".amount",array('value' =>$labCost['LaboratoryTestOrder']['amount'],'legend'=>false,'label'=>false));
					$labHtml.=$formHelper->hidden("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".id",array('value' =>$labCost['LaboratoryTestOrder']['id'],'legend'=>false,'label'=>false));
					$labHtml.=$formHelper->hidden("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".service_id",array('value' => $laboratoryKey,'legend'=>false,'label'=>false));
					$labHtml.='</div>';
					if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
           				$labHtml.='<div align="center" class="tdBorderRt chldDiv2">--&nbsp;</div>';
           			}
           			$labHtml.='<div align="center"  class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.' ; ">--';
           			$labHtml.='&nbsp;</div>';
           			$labHtml.='<div class="tdBorderRt chldDiv4 " valign="top" align="center">';
           			$labHtml.=$numberHelper->format($labCost['LaboratoryTestOrder']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
           			$labHtml.='</div>';

           			$labHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5" >1</div>';
           			$labHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6" >';
           			$labHtml.=$numberHelper->format($labCost['LaboratoryTestOrder']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
           			$labHtml.='</div>';
           			$labHtml.='<div align="center" valign="top" class="chldDiv7">';
           			$labHtml.=$formHelper->hidden("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".discount",array('value' =>round($labCost['LaboratoryTestOrder']['discount']),'class'=>'discount_'.$laboratoryKey.'-'.$labCost['LaboratoryTestOrder']['id'],'legend'=>false,'label'=>false));
           			$labId=$labCost['LaboratoryTestOrder']['id'];
           			$labHtml.="<span class=discount_$laboratoryKey-$labId>".round(($labCost['LaboratoryTestOrder']['discount']))."</span>";
           			$labHtml.='</div>';
           			$labHtml.='<div align="center" valign="top" class="chldDiv7">';
           			if(!empty($labCost['LaboratoryTestOrder']['paid_amount'])){
           				$labPaid=$labCost['LaboratoryTestOrder']['paid_amount'];
           			}else{
           				$labPaid=$labCost['LaboratoryTestOrder']['amount']-$labCost['LaboratoryTestOrder']['discount'];
           			}
           			$labHtml.=$formHelper->hidden("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".paid_amount",array('value' =>round ($labPaid),'class'=>'paid_'.$laboratoryKey.'-'.$labCost['LaboratoryTestOrder']['id'],'legend'=>false,'label'=>false));
           			$labHtml.="<span class=paid_$laboratoryKey-$labId>".round($labPaid)."</span>";
           			$labHtml.='</div>';
           			$labHtml.='</li>';
           			$labHtml.='</div>';
           			$labHtml.='<br>';
           	}
           	return $labHtml;

}

function radHtml($patient,$radRate,$radiologyKey,$formHelper,$numberHelper,$hideCGHSCol){
	foreach($radRate as $radKey=>$radCost){
		$paidAmt=0;$raCost=0;
		if($radCost['RadiologyTestOrder']['amount'] > 0){
		$raCost += $radCost['RadiologyTestOrder']['amount'] ;
		$formatRadCost = $radCost['RadiologyTestOrder']['amount'] ;
	}else{
		$raCost += $radCost['TariffAmount'][$nabhType] ;
		$formatRadCost = $radCost['TariffAmount'][$nabhType] ;
	}

	$radHtml.='<div>';
	$radHtml.='<li>';
	$radHtml.='<div valign="top" class="tdBorder" style="float: left;">';
	$paidAmt=$raCost-round($radCost['RadiologyTestOrder']['paid_amount']+$radCost['RadiologyTestOrder']['discount']);
	$disable='';
	if(!empty($radCost['RadiologyTestOrder']['discount'])){
		$exclude='discount_excluded';
	}else{
		$exclude='';
	}
	if($radCost['RadiologyTestOrder']['paid_amount'] >0){
		$disable='disabled';
		$class='chk_child_paid refund_amt'	;
	}else{
		$class='chk_child'	;
	}

	if(empty($radCost['RadiologyTestOrder']['paid_amount'])){
		if(!empty($radCost['RadiologyTestOrder']['discount']))
			$class.=' reset_child_dis'	;
	}
	$radHtml.=$formHelper->input("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".valChk",array('type'=>'checkbox','id'=>'radiology_'.$radiologyKey.'-'.$radCost['RadiologyTestOrder']['id'],$disable,'class'=>$class.' '.$exclude.' '.'service_'.$radiologyKey,'value'=>$paidAmt));
	$radHtml.='</div>';
	$radHtml.='<div class="tdBorderRt chldDiv1" >';
	$radHtml.=$radCost['Radiology']['name'];
	$radHtml.='&nbsp;'.$formHelper->hidden("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".editAmt",array('value' =>$paidAmt,$disable,'id'=>'txt_'.$radCost['RadiologyTestOrder']['id'],'class'=>'textAmt','legend'=>false,'label'=>false,'style'=>'width:75px; padding:2px'));
	$radHtml.=$formHelper->hidden("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".name",array('value' =>$radCost['Radiology']['name'],'legend'=>false,'label'=>false));
	$radHtml.=$formHelper->hidden("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".amount",array('value' =>$formatRadCost,'legend'=>false,'label'=>false));
	$radHtml.=$formHelper->hidden("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".id",array('value' =>$radCost['RadiologyTestOrder']['id'],'legend'=>false,'label'=>false));
	$radHtml.=$formHelper->hidden("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".service_id",array('value' => $radiologyKey,'legend'=>false,'label'=>false));
	$radHtml.='</div>';
	if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
		$radHtml.='<div align="center" class="tdBorderRt chldDiv2" >--&nbsp;</div>';
	}
	$radHtml.='<div align="center" class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.'">--&nbsp;</div>';
	$radHtml.='<div class="tdBorderRt chldDiv4"  valign="top" align="center">';
	$radHtml.=$numberHelper->format($formatRadCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
	$radHtml.='</div>';
	$radHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5">1</div>';
	$radHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6">';
	$radHtml.=$numberHelper->format($formatRadCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
	$radHtml.='</div>';
	$radHtml.='<div align="center" valign="top" class="chldDiv7">';
	$radHtml.=$formHelper->hidden("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".discount",array('value' =>round($radCost['RadiologyTestOrder']['discount']),'class'=>'discount_'.$radiologyKey.'-'.$radCost['RadiologyTestOrder']['id'],'legend'=>false,'label'=>false));
	$radId=$radCost['RadiologyTestOrder']['id'];
	$radHtml.="<span class=discount_$radiologyKey-$radId>".round(($radCost['RadiologyTestOrder']['discount']))."</span>";
	$radHtml.='</div>';
	$radHtml.='<div align="center" valign="top" class="chldDiv7">';
	if(!empty($radCost['RadiologyTestOrder']['paid_amount'])){
		$radPaid=$radCost['RadiologyTestOrder']['paid_amount'];
	}else{
		$radPaid=$formatRadCost-$radCost['RadiologyTestOrder']['discount'];
	}
	$radHtml.=$formHelper->hidden("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".paid_amount",array('value' => round($radPaid),'class'=>'paid_'.$radiologyKey.'-'.$radCost['RadiologyTestOrder']['id'],'legend'=>false,'label'=>false));
	$radHtml.="<span class=paid_$radiologyKey-$radId>".round($radPaid)."</span>";
	$radHtml.='</div>';
	$radHtml.='</li>';
	$radHtml.='</div><br>';
	}
	return $radHtml;

}

/*function otherServiceHtml($otherServicesData,$formHelper,$numberHelper,$hideCGHSCol){
 foreach($otherServicesData as $otherServiceD){
		$v++;$srNo++;
		$oSHtml.='<div>';
		$oSHtml.='<li>';
		$oSHtml.='<div align="center" class="tdBorder" style="float: left;">';
		$oSHtml.=$formHelper->input("Billing.".$otherServiceD['OtherService']['id'].".valChk",array('type'=>'checkbox','id'=>'service_'.$otherServiceD['OtherService']['id'],'class'=>'chk_child service_'.$otherServiceD['OtherService']['id'],
					'value'=>$otherServiceD['OtherService']['service_amount']));
        $oSHtml.='</div>';
        $oSHtml.='<div class="tdBorderRt chldDiv1" >';
        $oSHtml.=$otherServiceD['OtherService']['service_name'];
        $oSHtml.=$formHelper->hidden("Billing.".$otherServiceD['OtherService']['id'].".editAmt",array('value' =>$otherServiceD['OtherService']['service_amount'],$disable,'id'=>'txt_'.$otherServiceD['OtherService']['id'],'class'=>'textAmt','legend'=>false,'label'=>false,'style'=>'width:75px; padding:2px'));
	    $oSHtml.=$formHelper->hidden("Billing.".$otherServiceD['OtherService']['id'].".name",array('value' =>$otherServiceD['OtherService']['service_name'],'legend'=>false,'label'=>false));
	    $oSHtml.=$formHelper->hidden("Billing.".$otherServiceD['OtherService']['id'].".discount",array('value' =>$otherServiceD['OtherService']['discount'],'class'=>'discount_'.$otherServiceD['OtherService']['id'],'legend'=>false,'label'=>false));
	    $oSHtml.=$formHelper->hidden("Billing.".$otherServiceD['OtherService']['id'].".id",array('value' =>$otherServiceD['OtherService']['id'],'legend'=>false,'label'=>false));
	    $oSHtml.=$formHelper->hidden("Billing.".$otherServiceD['OtherService']['id'].".service_id",array('value' =>'other','legend'=>false,'label'=>false));
	    $oSHtml.='</div>';
        if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
         $oSHtml.='<div align="center" class="tdBorderRt chldDiv2">&nbsp;</div>';
        }
        $oSHtml.='<div align="center" class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.';">&nbsp;</div>';
        $oSHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv4">';
        $oSHtml.=$formHelper->hidden("Billing.".$otherServiceD['OtherService']['id'].".rate",array('value' => $numberHelper->format($otherServiceD['OtherService']['service_amount'],
									array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),
									'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		$oSHtml.=$numberHelper->format($otherServiceD['OtherService']['service_amount']);
		$oSHtml.='</div>';
		$oSHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5">';
		$oSHtml.=$formHelper->hidden("Billing.".$otherServiceD['OtherService']['id'].".unit",array('value' => '1','legend'=>false,'label'=>false,'style'=>'text-align:center'));
		$oSHtml.='1';
		$oSHtml.='</div>';
		$oSHtml.='<div align="center" valign="top" class="chldDiv6">';
		$oSHtml.=$formHelper->hidden("Billing.".$otherServiceD['OtherService']['id'].".amount",array('value' => $numberHelper->format(($otherServiceD['OtherService']['service_amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
		$oSHtml.=$numberHelper->format($otherServiceD['OtherService']['service_amount']);
		$otherServicesCharges = $otherServicesCharges + ($otherServiceD['OtherService']['service_amount']);
		$oSHtml.='</div>';
		$oSHtml.='<div align="center" valign="top" class="chldDiv7">';
		//$oSHtml.=$formHelper->hidden("Billing.".$otherServiceD['OtherService']['id'].".amount",array('value' => $numberHelper->format(($otherServiceD['OtherService']['service_amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
		//$oSHtml.=$numberHelper->format($otherServiceD['OtherService']['service_amount']);
		//$otherServicesCharges = $otherServicesCharges + ($otherServiceD['OtherService']['service_amount']);
		$oSHtml.='</div>';
		$oSHtml.='</li>';
		$oSHtml.='</div>';
		$oSHtml.='<br>';
     }
     return $oSHtml;
}*/


	function dynamicService($patient,$dynamicNursingServices,$dynamickey,$formHelper,$numberHelper,$hideCGHSCol,$category){

	foreach($dynamicNursingServices as $resetNursingServicesName=>$nursingService){
		$k++;//debug($nursingService);
		$totalUnit= $nursingService['qty'];
		$srNo++;$paidAmount=0;$class='';$exclude='';$cost=0;
		//$dynamic.='<div >';
		$dynamic.='<li>';
		$dynamic.='<div align="center" class="tdBorder" style="float: left;">';
		if(!empty($nursingService['cost'])){
					$cost=$nursingService['qty']*$nursingService['cost'];
		}else{
					$cost=0;
		}
		$paidAmount=$cost-round($nursingService['paid_amount']+$nursingService['discount']);
		$disabled='';
		if(!empty($nursingService['discount'])){
			$exclude='discount_excluded';
		}else{
			$exclude='';
		}
		if($nursingService['paid_amount']){
			$disabled='disabled';
			$class='chk_child_paid refund_amt'	;
		}else{
			$class='chk_child'	;
		}
		if(empty($nursingService['paid_amount'])){
			if(!empty($nursingService['discount']))
				$class.=' reset_child_dis'	;
		}

		$dynamic.=$formHelper->input("Billing.".$category.".".$nursingService['service_bill_id'].".valChk",array('type'=>'checkbox','id'=>$category.'_'.$dynamickey.'-'.$nursingService['service_bill_id'],$disabled,'class'=>$class.' '.$exclude.' '.'service_'.$dynamickey,'label'=>false,'div'=>false,'value'=>$paidAmount));
		$dynamic.='</div>';
		$dynamic.='<div class="tdBorderRt chldDiv1">';
		$dynamic.=$nursingService['name'];
		$dynamic.='&nbsp;'.$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".editAmt",array('value' =>$paidAmount,$disabled,'id'=>'txt_'.$nursingService['service_bill_id'],'class'=>'textAmt','legend'=>false,'label'=>false,'style'=>'width:75px; padding:2px'));
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".name",array('value' =>$nursingService['name'],'legend'=>false,'label'=>false));
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".service_bill_id",array('value' =>$nursingService['service_bill_id'],'legend'=>false,'label'=>false));
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".id",array('value' =>$nursingService['tariff_list_id'],'legend'=>false,'label'=>false));
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".service_id",array('value' => $dynamickey,'legend'=>false,'label'=>false));
		$dynamic.='</div>';
		if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
			$dynamic.='<div align="center" class="pvt tdBorderRt chldDiv2"> ';
			if($nursingService['moa_sr_no']!='')
				$dynamic.=$nursingService['moa_sr_no'];
			else $dynamic.='&nbsp;';
			$dynamic.='</div>';
		}
		$dynamic.='<div align="center" class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.';">';
		if($nursingService['nabh_non_nabh']!='')
			$dynamic.=$nursingService['nabh_non_nabh'];
		else $dynamic.='&nbsp;';
		$dynamic.='</div>';
		$dynamic.='<div align="center" valign="top" class="tdBorderRt chldDiv4">';
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".rate",array('value' => $nursingService['cost'],'legend'=>false,'label'=>false,'id' => 'nursing_service_rate','style'=>'text-align:right;'));
		$dynamic.=$numberHelper->format($nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		$dynamic.='</div>';
		$dynamic.='<div align="center" valign="top" class="tdBorderRt chldDiv5" >';
		if($totalUnit<1) $totalUnit=1;
		$dynamic.=$totalUnit;
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".unit",array('value' => $totalUnit,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
		$dynamic.='</div>';
		$dynamic.='<div align="center" valign="top" class="tdBorderRt chldDiv6">';
		$totalNursingCharges1=0;
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".amount",array('value' => $numberHelper->format($totalUnit*$nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'nursing_service_amount','style'=>'text-align:right;'));
		$dynamic.=$numberHelper->format($totalUnit*$nursingService['cost']);
		$totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];
		$dynamic.='</div>';
		$dynamic.='<div align="center" valign="top" class="chldDiv7" >';
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".discount",array('value' =>round($nursingService['discount']),'class'=>'discount_'.$dynamickey.'-'.$nursingService['service_bill_id'],'legend'=>false,'label'=>false));
		$dynId=$nursingService['service_bill_id'];
		$dynamic.="<span class=discount_$dynamickey-$dynId>".round(($nursingService['discount']))."</span>";
		$dynamic.='</div>';
		$dynamic.='<div align="center" valign="top" class="chldDiv7" >';
		if(!empty($nursingService['paid_amount'])){
			$dymPaid=$nursingService['paid_amount'];
		}else{
			$dymPaid=$totalUnit*$nursingService['cost']-$nursingService['discount'];
		}
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".paid_amount",array('value' => round($dymPaid),'class'=>'paid_'.$dynamickey.'-'.$nursingService['service_bill_id'],'legend'=>false,'label'=>false));
		$dynamic.="<span class=paid_$dynamickey-$dynId>".round($dymPaid)."</span>";
		$dynamic.='</div>';
		$dynamic.='</li>';
		}
		return $dynamic;
	}
	?>
<script>
var instance="<?php echo $configInstance;?>";  //by swapnil
var interval = "";
var refund_interval = "";
	$(document).ready(function(){
		 $( "#discharge_date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				style:"width:200px",
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

		    var instance="<?php echo $configInstance;?>";  //by swapnil
			var interval = "";
			var refund_interval = "";
			amtToPay = '';
			$('#discountType').val('');
			$('#typeDiscount').val('');
			$('#maintainDiscount').val('');
			$('#disc').val('');
			$('#discount_authorize_by').val('');
			$('#discount_authorize_by_for_refund').val('');
			discountApproval();	//check any previous approval for discount for finalBill only
			RefundApproval();	//check any previous approval for refund for finalBill only			
			$('.select_all').attr('checked', true);
			$('.chk_parent').attr('checked', true);
			$('.chk_child').attr('checked', true);
			$('.chk_child_paid').attr('checked', true);
			$('.chk_parent_mandatory').attr('checked', true);
			$('.chk_parent_paid').attr('checked', true);
			$('.chk_parent_paid').attr('disabled', true);
			$('.chk_child_mandatory').attr('checked', true);
			$('.chk_child_doc').attr('checked', true);
			$('.exclude_discount').attr('checked', false);
			$('.exclude_discount').attr('disabled', true); 
			$('.discount_excluded').attr('checked', true);
			$('.discount_excluded').attr('disabled', true);
			$('.refund_amt').prop('checked', true);

			var defaultVal=0;var totalChk=0;
			 $(".chk_parent:checked").each(function (){
				 
				  var count=0; 
				  checkId=this.id;
				  selectedParent =checkId.split('_')[1] ;
			         if($(this).is(':checked')){ 
			        	  $('.service_'+selectedParent).each(function () { 
				            	if(!$(this).is(':disabled') && $(this).is(':checked')){
				            		totalChk++;
					            	count++;
					            	if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){//Exclude Room tariff Doctor and Nursing charges
					            		defaultVal =parseFloat(defaultVal)+parseFloat($(this).val());
					            	}else{
		 			            		this.checked = false;
		 			            	}		   
				      		  	}
				      		});
					     	if(count==0){
						     	$(this).removeClass('chk_parent');
						     	$(this).addClass('chk_parent_paid');
						     	$(this).parent('div').siblings().removeClass('pending_payment');
						     	$(this).parent('div').siblings().addClass('paid_payment');				     	
					     		$(this).attr('disabled',true);
					     	}else{
					     		$(this).parent('div').siblings().addClass('pending_payment');
						     	$(this).parent('div').siblings().removeClass('paid_payment');
					     	}
							
							/*9if(totalChk=='0'){
					     		$('#disRow').hide();
					     	}else{
								$('#disRow').show();
							}*/
			         }
			 });
			 defaultVal=Math.round(defaultVal);
			 if(defaultVal<0)
				 defaultVal=0;
			 $(".checkedValue").text(defaultVal);
			 $('#actAmount').val(defaultVal);
			 amtToPay=defaultVal;
			 $(".checkedValue").val(defaultVal);

			 $('.chk_parent').bind('click', function(){
				 var that = this; 
				 setTimeout(function(){
				 if($(".discountType").is(':checked')){
					 resetDiscountRefund();
				 }
		    	 var val=0;var calamt=0;
		    	 var phar=$(that).attr('id').split('_')[0];
		         selectedParent = $(that).attr('id').split('_')[1] ;
		         var selectVal='0';
		         if($(that).is(':checked')){ 
		        	 $('.chk_parent').each(function() { //loop through each checkbox
		 	     		if($(this).is(':checked')){ 
		              	  selectedParent =$(this).attr('id').split('_')[1] ;
		 	         	  $('.service_'+selectedParent).each(function () { 
			 	         	  if(!$(this).is(':disabled') && $(this).is(':checked') && !($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
			 	         		serCost=parseFloat($(this).val());
 		 		            	if(serCost==1)
 	 	 		 		            serCost=0;
			 	         			selectVal =parseFloat(selectVal)+parseFloat(serCost);		   
		 		      		  	}	            	
		 			     	});	 
		 	     		}                             
		         	 });
		        	 selectVal=Math.round(selectVal);
		        	 if(selectVal<0)
						 selectVal=0;
		        	 $(".checkedValue").val(selectVal); 
		        	 $('#actAmount').val(selectVal);
					 amtToPay=selectVal; 
		             $(".checkedValue").text(selectVal);		             

		         }else{
		        	 $('#select').attr('checked', false);
		        	$('.chk_parent').each(function() { //loop through each checkbox
		 		 	     		if($(this).is(':checked') && !$(this).is(':disabled')){ 
		 		              	  selectedParent =$(this).attr('id').split('_')[1] ;
		 		 	         	  $('.service_'+selectedParent).each(function () { 
			 		 	         		if(!$(this).is(':disabled') && $(this).is(':checked') && !($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
			 		 	         			serCost=parseFloat($(this).val());
			 		 		            	if(serCost==1)
			 	 	 		 		            serCost=0;
				 		            		selectVal =parseFloat(selectVal)+parseFloat(serCost);	
				 		            	}	            	
		 		 			     	});	 
		 		 	     		}                             
		 		         	 });
		         	 
		        	 selectVal=Math.round(selectVal);
		        	 if(selectVal<0)
						 selectVal=0;
		         	 $(".checkedValue").val(selectVal); 
		        	 $('#actAmount').val(selectVal);
					 amtToPay=selectVal; 
		        	 $(".checkedValue").text(selectVal); 
		        	   	
		         }
				 }, 500); 
		     });

			 var chk1Array=[];
			 $('.chk_child').bind('click', function(){ 
				 if($(".discountType").is(':checked')){
					 resetDiscountRefund();
				 }
				    selectedChildName = $(this).attr('id').split("-");  
			     	var val=0;
			     	var checkChildStatus = 0 ;
			     	var paymentTariffId=$(this).attr('id').split("_")[1];
			     	var serviceTariffId=paymentTariffId.split("-")[0];
			     	var paymentCategoryId=paymentTariffId.split("-")[1];
			     	var totalAmt=amtToPay;//$("#actAmount").val();
			     	//alert(totalAmt);alert(serviceTariffId);
			     	$('.service_'+serviceTariffId).each(function () { 
			     		checkChildStatus++;												
						if ($(this).is(':checked')){ 
							//service wise array to get the checked child services
							if(!$(this).is(':disabled')){
								var tariffId=$(this).attr('id').split('-');
								var inarray = chk1Array.indexOf(tariffId[1]);
								if(selectedChildName[1]==tariffId[1]){
									serCost=parseFloat($(this).val());
	 		 		            	if(serCost==1)
	 	 	 		 		            serCost=0;						
									val =parseFloat(totalAmt)+parseFloat(serCost);	
									//alert(val);					
								}								
							}
			        	}else{	        	
				        	//To pop the unchecked services from the array
			        		var tariffId=$(this).attr('id').split('-');
							checkChildStatus--;					
							if(selectedChildName[1]==tariffId[1]){
								serCost=parseFloat($(this).val());
 		 		            	if(serCost==1)
 	 	 		 		            serCost=0;						
								val =parseFloat(totalAmt)-parseFloat(serCost);
									//alert(val+'else');									
							}
			        	}    	
			         	
									        		   
			     	});			     	
			     	if(checkChildStatus<=0) 
				        $("#"+selectedChildName[0]).attr('checked',false);//uncheck parent if none of the child is checked

				     val = Math.round(val);
				     if(val<0)
						 val=0;
					 $(".checkedValue").text(val);
				   	 $('#actAmount').val(val);
				   	 amtToPay=val;
				   	 $(".checkedValue").val(val);
			     	
			 	    val=0; 
			  });


//Parent paid
		$('.chk_parent_paid').bind('click', function(){
			var that=this;
			setTimeout(function(){
				 var val=0;
		    	 var calamt=0;
		    	 var phar=$(that).attr('id').split('_')[0];
		         selectedParent = $(that).attr('id').split('_')[1] ;
		         var selectVal='0';
		         if($(that).is(':checked')){ 
		        	 $('.chk_parent_paid').each(function() { //loop through each checkbox
		 	     		if($(this).is(':checked') && !$(this).is(':disabled')){ 
		              	  selectedParent =$(this).attr('id').split('_')[1] ;
		              	  if($(this).attr('id').split('_')[0]=='pharmacy'){
		              		if($(this).hasClass('refund_amt'))
		              			selectedPhar=$(this).attr('id').split('_')[2];//For sales  return 
		              		//selectVal =parseInt(selectVal)+parseInt($('.pharmacy_paid_'+selectedParent).val());
		              			if($('.pharmacy_R_paid_'+selectedPhar).text()){
			              			amtReturn=$('.pharmacy_R_paid_'+selectedPhar).val();
			              		}else{
			              			amtReturn='0';
			              		}
		              		selectVal =parseFloat(selectVal)+parseFloat(amtReturn);
		              	  }else if($(this).attr('id').split('_')[0]=='otpharmacy'){
		              		if($(this).hasClass('refund_amt'))
		              		//selectVal =parseInt(selectVal)+parseInt($('.otpharmacy_paid_'+selectedParent).val());
		              			selectedot=$(this).attr('id').split('_')[2];//For sales  return 
		              			if($('.otpharmacy_R_paid_'+selectedot).text()){
			              			amtoReturn=$('.otpharmacy_R_paid_'+selectedot).val();
			              		}else{
			              			amtoReturn='0';
			              		}
		              		selectVal =parseFloat(selectVal)+parseFloat(amtoReturn);
			              	
		              	  }else if($(this).attr('id').split('_')[0]=='ward'){
		              		if($(this).hasClass('refund_amt')){
		              			serCost=parseFloat($('.ward_paid_'+selectedParent).val());
 		 		            	if(serCost==1)
 	 	 		 		            serCost=0;						
									selectVal =parseFloat(selectVal)+parseFloat(serCost);
		              		}
		              	  }
		              	  else{		              	  
			              	  $('.service_'+selectedParent).each(function () { 
				 	         	  selctedChild=$(this).attr('id').split('_')[1];
			 		            	if($(this).hasClass('refund_amt') && !$(this).is(':disabled')){
			 		            		serCost=parseFloat($('.paid_'+selctedChild).val());
		 		 		            	if(serCost==1)
		 	 	 		 		            serCost=0;
			 		            		selectVal =parseFloat(selectVal)+parseFloat(serCost);		   
			 		      		  	}	            	
			 			     	});	
		              	  } 
		 	     		}                             
		         	 });
		        	 selectVal=Math.round(selectVal);
		        	 if(selectVal<0)
						 selectVal=0;
		         	 $("#refund_amount").val(selectVal);
				     $("#refund_paid").val(selectVal);
				     $(".checkedValue").val(selectVal); 
		        	 $('#actAmount').val(selectVal);
		        	 amtToPay=selectVal; 
		             $(".checkedValue").text(selectVal);		             

		         }else{
		        	 $('#select').attr('checked', false);
		        	$('.chk_parent_paid').each(function() { //loop through each checkbox
		 		 	     		if($(this).is(':checked')){ 
		 		              	  selectedParent =$(this).attr('id').split('_')[1] ;
		 		              	if($(this).attr('id').split('_')[0]=='pharmacy'){
		 		              		if($(this).hasClass('refund_amt'))
		 		              			selectedPhar=$(this).attr('id').split('_')[2];//For sales  return 
				              		//selectVal =parseInt(selectVal)+parseInt($('.pharmacy_paid_'+selectedParent).val());
				              			if($('.pharmacy_R_paid_'+selectedPhar).text()){
					              			amtReturn=$('.pharmacy_R_paid_'+selectedPhar).val();
					              		}else{
					              			amtReturn='0';
					              		}
				              		selectVal =parseFloat(selectVal)+parseFloat(amtReturn);
				              	  }else if($(this).attr('id').split('_')[0]=='otpharmacy'){
				              		if($(this).hasClass('refund_amt'))
				              		//selectVal =parseInt(selectVal)+parseInt($('.otpharmacy_paid_'+selectedParent).val());
				              			selectedot=$(this).attr('id').split('_')[2];//For sales  return 
				              			if($('.otpharmacy_R_paid_'+selectedot).text()){
					              			amtoReturn=$('.otpharmacy_R_paid_'+selectedot).val();
					              		}else{
					              			amtoReturn='0';
					              		}
				              		selectVal =parseFloat(selectVal)+parseFloat(amtoReturn);
				              	  }else if($(this).attr('id').split('_')[0]=='ward'){
					              		if($(this).hasClass('refund_amt')){
					              			serCost=parseFloat($('.ward_paid_'+selectedParent).val());
			 		 		            	if(serCost==1)
			 	 	 		 		            serCost=0;
				 		            		selectVal =parseFloat(selectVal)+parseFloat(serCost);						              		
					              		}
						          }else{
		 		 	         	  $('.service_'+selectedParent).each(function () { 
		 		 	         		selctedChild=$(this).attr('id').split('_')[1];
				 		            	if($(this).hasClass('refund_amt') && !$(this).is(':disabled')){
				 		            		serCost=parseFloat($('.paid_'+selectedChild).val());
			 		 		            	if(serCost==1)
			 	 	 		 		            serCost=0;
				 		            		selectVal =parseInt(selectVal)+parseInt(serCost);		   
				 		      		  	}	            	
		 		 			     	});
				              	  }	 
		 		 	     		}                             
		 		     });
		        	 selectVal=Math.round(selectVal);
		        	 if(selectVal<0)
						 selectVal=0;
		        	 $("#refund_amount").val(selectVal);
				     $("#refund_paid").val(selectVal);
				     $(".checkedValue").val(selectVal); 
		        	 $('#actAmount').val(selectVal);
					 amtToPay=selectVal; 
		        	 $(".checkedValue").text(selectVal); 
		        	   	
		         }
					}, 500); 
		     });



/////////////////////////////////////////


			 
			 var chk1Array=[];
			 $('.chk_child_paid').bind('click', function(){ 
				    selectedChildName = $(this).attr('id').split("-");  
			     	var val=0;
			     	var checkChildStatus = 0 ;
			     	var paymentTariffId=$(this).attr('id').split("_")[1];
			     	var serviceTariffId=paymentTariffId.split("-")[0];
			     	var paymentCategoryId=paymentTariffId.split("-")[1];
			     	var totalAmt=$("#actAmount").val();	
			     	if(isNaN(totalAmt))
			     		totalAmt=0;		     	
			     	$('.service_'+serviceTariffId).each(function () { 
			         	if ($(this).is(':checked')){ 
							//service wise array to get the checked child services
							if(!$(this).is(':disabled')){
								var tariffId=$(this).attr('id').split('-');
								var inarray = chk1Array.indexOf(tariffId[1]);
								checkChildStatus++;															
								if(selectedChildName[1]==tariffId[1]){
									if($(this).hasClass('refund_amt'))
										serCost=parseFloat($('.paid_'+paymentTariffId).val());
	 		 		            	if(serCost==1)
	 	 	 		 		            serCost=0;						
										val =parseFloat(totalAmt)+parseFloat(serCost);						
								}								
							}
			        	}else{	        	
				        	//To pop the unchecked services from the array
			        		var tariffId=$(this).attr('id').split('-');
							checkChildStatus--;					
							if(selectedChildName[1]==tariffId[1]){
								if($(this).hasClass('refund_amt') && !$(this).is(':disabled'))
									serCost=parseFloat($('.paid_'+paymentTariffId).val());
 		 		            		if(serCost==1)
 	 	 		 		            serCost=0;
									val =parseFloat(totalAmt)-parseFloat(serCost);								
							}
			        	}    	
			         	
									        		   
			     	});			     	
			     	if(checkChildStatus<=0) 
				        $("#"+selectedChildName[0]).attr('checked',false);//uncheck parent if none of the child is checked
				     val=Math.round(val);
				     if(val<0)
						 val=0;
					 $("#refund_amount").val(val);
				     $("#refund_paid").val(val);
					 $(".checkedValue").text(val);
				   	 $('#actAmount').val(val);
				   	 amtToPay=val;
				   	 $(".checkedValue").val(val);
			     	
			 	    val=0; 
			  });	
	
	});//EOF ready function


	//fnction to check discount approval
	function discountApproval(){
		if($('.discountType').is(':checked')){
		resetDiscountRefund();			//reset all (Discount/Refund)
		}
		patientId = '<?php echo $patient['Patient']['id']; ?>';
    	payment_category = 'Finalbill';
    	clearInterval(refund_interval); 		//clear refund intervals if any
		clearInterval(interval); 		//clear discount intervals if any

 	   $.ajax({
			  type : "POST",
			  data: "patient_id="+patientId+"&payment_category="+payment_category,
			  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "checkDiscountApproval","admin" => false)); ?>",
			  context: document.body,
			  beforeSend:function(){
				
			  },	
			  success: function(data){
				  parseData = $.parseJSON(data);
				  //console.log(parseData);

			if(parseData != null) {

				patientId = '<?php echo $patient['Patient']['id']; ?>';
				payment_category = 'Finalbill';
			    is_approved = parseInt(parseData.is_approved);
			    request_to = parseInt(parseData.request_to);
			    reasonType = parseData.reason;
			    is_type = parseData.type;
				

				$.ajax({
					  type : "POST",
					  data: "patient_id="+patientId+"&request_to="+request_to+"&type="+is_type+"&payment_category="+payment_category,
					  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "cancelApproval","admin" => false)); ?>",
					  context: document.body,
					  beforeSend:function(){
						  $("#busy-indicator").show();
					  },	
					  success: function(data){ 
						$("#busy-indicator").hide();					
						//clearInterval(interval); 					// stop the interval
						interval='';
						resetDiscountRefund();
						display();
					  }
				});
				
				display();	//calculate balance			  
			  }
			} 	//end of success
		}); 	//end of ajax
	}

	$(".discountType").change(function(){
		var type = $(this).val();
		resetRowDiscount();
		if($('#is_refund').is(':checked')){
			resetRefund();
			$('#is_refund').prop('checked',false);
			$('.paymentRemarkRefund').hide();
			$("#refund_amount").val('');
	        $("#refund_paid").val('');
			$("#refund_amount").hide();
			$('#send-approval-for-refund').hide();
			$("#discount_authorize_by_for_refund").hide();
		}
		
		$("#discount").show();
		$("#discount").val('');
		$('#typeDiscount').val($(this).val());
		if(type == "Percentage"){
			$("#show_percentage").show();				
		}else{
			$("#show_percentage").hide();
				
		}
		display();
	});

	$("#discount").keyup(function(){  
		display();
			//$("#discount_authorize_by").show();
			//$("#discount_reason").show();
			/*if(parseInt($("#actAmount").val()) >= 10000 && $(this).val()>=1)	//if total amount is greater or equal to 10000 then it is possible to give approval for discount or refund
			{				
				/*if($("#is_approved").val() == 0){
					$("#send-approval").show();
				}
				$("#is_approved").val(1);*/
				
			/*}else{
				$("#send-approval").hide();
				$("#is_approved").val(0);
			}*/		
	});

	function display()	//calculate final balance
	{
		
		var disc = '';
		total_amount = amtToPay;//($('#totalamount').val() != '') ? parseInt($('#totalamount').val()) : 0; 
		$(".discountType").each(function () {  
	        if ($(this).prop('checked')) {
	           var type = this.value;
	           $('#typeDiscount').val(type);
	           var perDis=0;
	           if(type == "Amount")	            {    
		           $('#inPer').show();
		           $('#calDis').text('');
		           $('#calPer').val('');
		           $('#calDis').show();
		           $('#inAmt').hide();
	            	disc = ($("#discount").val() != '') ? parseInt($("#discount").val()) : 0;
	            	if(disc==0){
	            		resetRowDiscount();
		            	}
	            	/*if(parseInt(disc)>parseInt(total_amount)){
	            		$('#actAmount').val(parseInt(amtToPay));
						alert("Discount cannot be greater than total bill amount. Please enter amount less than "+parseInt(total_amount));
						$("#discount").val('');
						resetRowDiscount();
						return false;
	            	}*/
					if(disc!='0'){
						if(parseInt(disc) >= 10000){
							if($("#is_approved").val() == 0){
								$("#send-approval").show();
								$("#discount_authorize_by").show();
								$("#discount_reason").show();
							}
							$("#is_approved").val(1);
						}
						else{
							$("#send-approval").hide();
							$("#is_approved").val(0);
							$("#discount_authorize_by").hide();
							$("#discount_reason").hide();
						}
							var perDis=(parseInt(disc)/parseInt(total_amount))*100;
							fullDis=perDis;
							perDis= perDis.toFixed(2)
							$('.chk_child').each(function() { //loop through each checkbox
								if($(this).is(':checked') && !$(this).is(':disabled')){
									if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
		 		            			var selId=$(this).attr('id');
							        	var splitId=selId.split('_')[1];
							        	var selVal=$(this).val();
							        	var disAmt=parseFloat((selVal*fullDis)/100);
							        	//if(!$('.discount_'+splitId).val() || isNaN($('.discount_'+splitId).val()) || parseInt($('.discount_'+splitId).val()=='0'))//Discount to get distributed only if there is no previous discount
							        	$('.discount_'+splitId).val(disAmt);
							        	$('.discount_'+splitId).text(disAmt.toFixed(2));
							        	$('.paid_'+splitId).text(parseFloat(selVal-disAmt).toFixed(2));
									}
								}
					        });
								var disAmt=0;
					        $('.chk_parent').each(function(){
					        	if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
					        	if($(this).is(':checked') && !$(this).is(':disabled')){
										var pId=$(this).attr('id');
										var splitPId=pId.split('_')[0];
										var pharId=pId.split('_')[1];
										if(splitPId=='pharmacy'){
										  var selVal=$(this).val();
										  var disAmt=parseFloat(selVal*fullDis)/100;
										  //alert($('.pharmacy_discount_'+pharId).val());
										  //if(!$('.pharmacy_discount_'+pharId).val() || isNaN($('.pharmacy_discount_'+pharId).val())|| parseInt($('.pharmacy_discount_'+pharId).val())=='0')
							        	  $('.pharmacy_discount_'+pharId).text(disAmt.toFixed(2));
								          $('.pharmacy_discount_'+pharId).val(disAmt.toFixed(2));
							        	  $('.pharmacy_paid_'+pharId).text(parseFloat(selVal-disAmt).toFixed(2));
								          $('.pharmacy_paid_'+pharId).val(parseFloat(selVal-disAmt).toFixed(2));
										}else if(splitPId=='otpharmacy'){
											  var selVal=$(this).val();
											  var disAmt=Math.round(parseFloat((selVal*fullDis)/100));
											  //alert($('.pharmacy_discount_'+pharId).val());
											  //if(!$('.pharmacy_discount_'+pharId).val() || isNaN($('.pharmacy_discount_'+pharId).val())|| parseInt($('.pharmacy_discount_'+pharId).val())=='0')
								        	  $('.otpharmacy_discount_'+pharId).val(disAmt.toFixed(2));								        	  
								        	  $('.otpharmacy_discount_'+pharId).text(disAmt.toFixed(2));
									          $('.otpharmacy_paid_'+pharId).text(parseFloat(selVal-disAmt).toFixed(2));
									          $('.otpharmacy_paid_'+pharId).val(parseFloat(selVal-disAmt).toFixed(2));
										}else if(splitPId=='ward'){
											  var selVal=$(this).val();
											  var disAmt=Math.round(parseFloat((selVal*fullDis)/100));
											  //alert($('.pharmacy_discount_'+pharId).val());
											  //if(!$('.pharmacy_discount_'+pharId).val() || isNaN($('.pharmacy_discount_'+pharId).val())|| parseInt($('.pharmacy_discount_'+pharId).val())=='0')
								        	  $('.ward_discount_'+pharId).val(disAmt.toFixed(2));								        	  
								        	  $('.ward_discount_'+pharId).text(disAmt.toFixed(2));
									          $('.ward_paid_'+pharId).text(parseFloat(selVal-disAmt).toFixed(2));
									          $('.ward_paid_'+pharId).val(parseFloat(selVal-disAmt).toFixed(2));

										}
					        	}
					        	}
						     });							
							
	            	}
					$('#calDis').text(perDis);
					$('#calPer').val(perDis);
	            }else if(type == "Percentage")
	            {
	            	$('#inAmt').show();
			        $('#calDis').show();
			        $('#calDis').text('');
			        $('#calPer').val('');
			        $('#inPer').hide();
			        
	            	var discount_value = ($("#discount").val()!= '') ? parseInt($("#discount").val()) : 0;
	            	if(discount_value==0){
	            		resetRowDiscount();
		            	}
	            	if(discount_value < 101){
	            		if(discount_value!=0){
	            			if(total_amount==0){
					        	alert("Selected service cost should be greater than zero");
								$("#discount").val('');
								resetRowDiscount();
								return false;
					        }
		       		    	disc = parseFloat((total_amount*discount_value)/100);
		       		    	if(parseInt(disc) >= 10000){
								if($("#is_approved").val() == 0){
									$("#send-approval").show();
									$("#discount_authorize_by").show();
									$("#discount_reason").show();
								}
								$("#is_approved").val(1);
							}
							else{
								$("#send-approval").hide();
								$("#discount_authorize_by").hide();
								$("#discount_reason").hide();
								$("#send-approval").hide();
								$("#is_approved").val(0);
							}
							$('.chk_child').each(function() { //loop through each checkbox
								if($(this).is(':checked') && !$(this).is(':disabled')){
									if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
		 		            			  var selId=$(this).attr('id');
							        	  var splitId=selId.split('_')[1];
							        	  var selVal=$(this).val();
							        	  var disAmt=parseFloat((selVal*discount_value))/100;
							        	  //if(!$('.discount_'+splitId).val() || isNaN($('.discount_'+splitId).val()) || parseInt($('.discount_'+splitId).val())=='0')
							        	  $('.discount_'+splitId).val(disAmt.toFixed(2));
							        	  $('.discount_'+splitId).text(disAmt.toFixed(2));
								          $('.paid_'+splitId).text(parseFloat(selVal-disAmt).toFixed(2));
									}
								}
					        });
								var disAmt=0;
					        $('.chk_parent').each(function(){
					        	if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
					        	if($(this).is(':checked') && !$(this).is(':disabled')){
										var pId=$(this).attr('id');
										var splitPId=pId.split('_')[0];
										var pharId=pId.split('_')[1];
										if(splitPId=='pharmacy'){
										  var selVal=$(this).val();
										  disAmt=parseFloat((selVal*discount_value))/100;
										   
										  //if(!$('.pharmacy_discount_'+pharId).val() || isNaN($('.pharmacy_discount_'+pharId).val()) || parseInt($('.pharmacy_discount_'+pharId).val())=='0')
										  $('.pharmacy_discount_'+pharId).text(disAmt.toFixed(2));
								          $('.pharmacy_discount_'+pharId).val(disAmt.toFixed(2));
							        	  $('.pharmacy_paid_'+pharId).text(parseFloat(selVal-disAmt).toFixed(2));
								          $('.pharmacy_paid_'+pharId).val(parseFloat(selVal-disAmt).toFixed(2));
										}else if(splitPId=='otpharmacy'){
											  var selVal=$(this).val();
											  var disAmt=parseFloat((selVal*discount_value))/100;
											  //alert($('.pharmacy_discount_'+pharId).val());
											  //if(!$('.pharmacy_discount_'+pharId).val() || isNaN($('.pharmacy_discount_'+pharId).val())|| parseInt($('.pharmacy_discount_'+pharId).val())=='0')
								        	  $('.otpharmacy_discount_'+pharId).text(disAmt.toFixed(2));
									          $('.otpharmacy_discount_'+pharId).val(disAmt.toFixed(2));
								        	  $('.otpharmacy_paid_'+pharId).text(parseFloat(selVal-disAmt).toFixed(2));
									          $('.otpharmacy_paid_'+pharId).val(parseFloat(selVal-disAmt).toFixed(2));
											}else if(splitPId=='ward'){
												  var selVal=$(this).val();
												  var disAmt=Math.round(parseFloat((selVal*discount_value)/100));
												  //alert($('.pharmacy_discount_'+pharId).val());
												  //if(!$('.pharmacy_discount_'+pharId).val() || isNaN($('.pharmacy_discount_'+pharId).val())|| parseInt($('.pharmacy_discount_'+pharId).val())=='0')
									        	  $('.ward_discount_'+pharId).val(disAmt.toFixed(2));
									        	  $('.ward_discount_'+pharId).text('');								        	  
									        	  $('.ward_discount_'+pharId).text(disAmt.toFixed(2));
										          $('.ward_paid_'+pharId).text(parseFloat(selVal-disAmt).toFixed(2));
										          $('.ward_paid_'+pharId).val(parseFloat(selVal-disAmt).toFixed(2));

											}
					        	}
					        	}
						     });
					        
						}else
							disc=0;
					}else{
						/*$('#actAmount').val(parseInt(amtToPay));
						alert("Percentage should be less than or equal to 100");
						$("#discount").val('');
						resetRowDiscount();
						return false;*/
						
					}
	            	$('#calDis').text(disc);
	            	$('#calPer').val(discount_value.toFixed(2));
	            }
	            $("#disc").val(disc);
	           if((!isNaN(amtToPay) || amtToPay!='0')){
	           		if(disc!='0'){ 
			   			$('#actAmount').val(parseInt(amtToPay)-parseInt(disc));
	           		}else{ 
		           		if(amtToPay)
	           			$('#actAmount').val(parseInt(amtToPay)) ;
		           	}
			   		
			   }	
	        }
	       
	    });

	}
	/***************************** EOF Discount********************************/
	
	
	
	$('#is_refund').click(function(){
		$('#foc').prop('checked',false);
		if ($(this).prop('checked')) {
			resetDiscountRefund();
			$('.paymentRemarkRefund').show();
			//$('.discountType').prop('disabled',true);
			$("#refund_amount").show();
			$("#discount_authorize_by_for_refund").show();
			$('#select').attr('checked', false);
			$('#select').attr('disabled', true);
			$('.chk_parent').each(function() { //loop through each checkbox
				 $(this).attr('disabled',true);
	             this.checked = false; //deselect all checkboxes with class "chk_parent"                             
	        });	          
	        $('.chk_child').each(function() { //loop through each checkbox
	        	if($(this).hasClass('refund_amt')){
	            	 $(this).attr('disabled',false);
		             this.checked = false;  //select all checkboxes with class "chk_child"
	        	}else{
	        		 $(this).attr('disabled',true);
		             this.checked = true;
	        	}
	        });
	        $('.chk_parent_paid').each(function() { //loop through each checkbox
	        	var chkCount=0;
	     		if($(this).is(':checked')){ 
           	  	  selectedParent =$(this).attr('id').split('_')[1] ;
	         	  $('.service_'+selectedParent).each(function () {		         	    
		            	if($(this).hasClass('refund_amt')){
		            		chkCount++;   
		      		  	}	            	
			     	});	 
	     		}
	     		if(parseInt(chkCount)===0){
	     			$(this).attr('disabled',true);
	     			this.checked = true;
	     		}else{
		     		this.checked = false;
  		  			$(this).attr('disabled',false);
  		  		} 
		    	  /* if($(this).hasClass('chk_parent'))
				    $(this).attr('disabled',true);
	    	   else
	        	    $(this).attr('disabled',false);
	             this.checked = false;*/ //deselect all checkboxes with class "chk_parent_paid"                             
	        });	          
	        $('.chk_child_paid').each(function() { //loop through each checkbox
	        	if($(this).hasClass('chk_child')){
				    $(this).attr('disabled',false);
				    this.checked = true;
	        	}else{
	            	  $(this).attr('disabled',false);
	             		this.checked = false;  //select all checkboxes with class "chk_child_paid"
	        	}
	        }); 
	        $('.exclude_discount').attr('checked',false); 
	        $('.exclude_discount').attr('disabled',true); 
	        $('.refund_amt').attr('disabled', false);
			$('.checkedValue').val('0');
	        $('#actAmount').val('0');
	        $(".checkedValue").text('0');       
	         
		}else{
			$('.discountType').prop('disabled',false);
			$('.paymentRemarkRefund').hide();
		$('#select').attr('disabled', false);
		$('#select').prop('checked', true);
		$('.chk_parent').each(function() { //loop through each checkbox
			 $(this).attr('disabled',false);
             this.checked = true; //deselect all checkboxes with class "chk_parent"                             
        });	          
        $('.chk_child').each(function() { //loop through each checkbox
        	 $(this).attr('disabled',false);
             this.checked = false;  //select all checkboxes with class "chk_child"
        });
        
        $('.chk_parent_paid').each(function() { //loop through each checkbox
			 $(this).attr('disabled',true);
             this.checked = true; //deselect all checkboxes with class "chk_parent_paid"                             
        });	          
        $('.chk_child_paid').each(function() { //loop through each checkbox
        	$(this).prop('checked',true);
        	  $(this).attr('disabled',true);
        	    //select all checkboxes with class "chk_child_paid"
        });
		 var selectVal=0;
			 $('.chk_parent').each(function() { //loop through each checkbox
		     		if($(this).is(':checked')){ 
	           	  selectedParent =$(this).attr('id').split('_')[1] ;
		         	  $('.service_'+selectedParent).each(function () { 
			            	if(!$(this).is(':disabled') && !($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
			            		selectVal =parseFloat(selectVal)+parseFloat($(this).val());		   
			      		  	}	            	
				     	});	 
		     		}                             
	      	 });
			 selectVal=Math.round(selectVal);
			 if(selectVal<0)
				 selectVal=0;
			 $(".checkedValue").val(selectVal); 
	     	 $('#actAmount').val(selectVal);
			 amtToPay=selectVal; 
	         $(".checkedValue").text(selectVal);
	          $('.chk_child').each(function() { //loop through each checkbox
	             this.checked = true;  //select all checkboxes with class "chk_child"
	         });

	         $('.exclude_discount').attr('checked',false); 
		     $('.exclude_discount').attr('disabled',true);
		     $('.discount_excluded').attr('disabled',true); 
		     $('.discount_excluded').attr('checked',true); 
	         $("#refund_amount").val('');
	         $("#refund_paid").val('');
			$("#refund_amount").hide();
			$('#send-approval-for-refund').hide();
			$("#discount_authorize_by_for_refund").hide();
			$('.refund_amt').attr('checked',true); 
	        $('.refund_amt').attr('disabled',true);
		}
	
});

	function resetRowDiscount(){
		$('.chk_child').each(function() { //loop through each checkbox
			if(!$(this).is(':disabled')){
				if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
					  var selId=$(this).attr('id');
		        	  var splitId=selId.split('_')[1];
         			  $('.discount_'+splitId).val('0');
		        	  $('.discount_'+splitId).text('0');
			          $('.paid_'+splitId).text('0');
				}
			}
        });
		 $('.chk_parent').each(function(){
        	if(!$(this).is(':disabled')){
            	var oTresetPharmacy=0; var resetPharmacy=0;var resetward=0;
					var pId=$(this).attr('id');
					var splitPId=pId.split('_')[0];
					var pharId=pId.split('_')[1];
					/*if(splitPId=='pharmacy'){
					  $('.pharmacy_discount_'+pharId).val('0');
		        	  $('.pharmacy_discount_'+pharId).text('0');
		        	  <?php //if($pharmacyPaidData['0'][0]['paid_amount']){?>
							var resetPharmacy= '<?php //echo $pharmacyPaidData['0'][0]['paid_amount'];?>';
		        	  	<?php //}?>
			          	$('.pharmacy_paid_'+pharId).text(resetPharmacy);
						}else if(splitPId=='otpharmacy'){
						  $('.otpharmacy_discount_'+pharId).val('0');
			        	  $('.otpharamcy_discount_'+pharId).text('0');
			        	  <?php //if($oTpharmacyPaidData['0'][0]['paid_amount']){?>
								var oTresetPharmacy= '<?php //echo $oTpharmacyPaidData['0'][0]['paid_amount'];?>';
			        	  <?php //}?>
				          $('.otpharmacy_paid_'+pharId).text(oTresetPharmacy);
						}else */if(splitPId=='ward'){
							$('.ward_discount_'+pharId).val('0');
				        	  $('.ward_discount_'+pharId).text('0');
				        	  <?php if($wardAdv){?>
									var resetward= '<?php echo $wardAdv;?>';
				        	  	<?php }?>
					          	$('.ward_paid_'+pharId).text(resetward);
						}
        	}
	     });

    }


	function resetDiscountRefund()
	{
		$("#is_approved").val(0);
		$("#disc").val(0);
		$("#discount").val('');
		$("#discount").hide();
		$("#show_percentage").hide();
		$("#discount_authorize_by").val('');
		$("#discount_authorize_by").hide();
		$("#discount_authorize_by").attr('disabled',false);
		$("#discount_reason").val('');
		$("#discount_reason").hide();
		$("#discount_reason").attr('disabled',false);
		$("#send-approval").hide();
		$("#cancel-approval").hide();
		$("#discount").prop("readonly", false);
		$(".discountType").prop("disabled",false);
		$(".discountType").attr('checked',false)
		$("#mesage").hide();
		$('#inPer').hide();
		$('#inAmt').hide();
        $('#calDis').hide();
        $('#calDis').text('');
        $('#calPer').val('');
        resetRowDiscount();	
	}
	
	$('#select').click(function(event) {  //on click
		if($(".discountType").is(':checked')){
			 resetDiscountRefund();
		 }
		 var selectVal=0;
	     if(this.checked) { // check select status
	         $('.chk_parent').each(function() { //loop through each checkbox
	             this.checked = true;  //select all checkboxes with class "chk_parent"
	             selectedParent =$(this).attr('id').split('_')[1] ;
		         	  $('.service_'+selectedParent).each(function () { 
			            	if(!$(this).is(':disabled')){
			            		if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){//Exclude Room tariff Doctor and Nursing charges
			            			selectVal =parseFloat(selectVal)+parseFloat($(this).val());
			            		}else{
	 			            		this.checked = false;
	 			            	}

	 			            	/*if($(this).hasClass('phar_dis')){
	 			            		selectVal =selectVal+parseInt($(this).val());
	 			            		this.checked = true;
	 			            	}*/		   
			      		  	}
			            	
				     	});	                              
	         });
	         selectVal=Math.round(selectVal);
	         if(selectVal<0)
				 selectVal=0;
	         $(".checkedValue").text(selectVal);
	    	 $('#actAmount').val(selectVal);
	    	 amtToPay=selectVal;
	         $(".checkedValue").val(selectVal);
	         $('.chk_child').each(function() { //loop through each checkbox
	        	 if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded')))
	             	this.checked = true;  //select all checkboxes with class "chk_child"
	             else
	                 this.checked = false;
                 	         
	         });
	         $('.exclude_discount').prop('checked',false);
	         
	     }else{
	         $('.chk_parent').each(function() { //loop through each checkbox
	             this.checked = false; //deselect all checkboxes with class "chk_parent"                             
	         });
	          
	         $('.chk_child').each(function() { //loop through each checkbox
	        	 if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded')))
		             	this.checked = false;  //select all checkboxes with class "chk_child"
		             else
		                 this.checked = true;
	         });

	        /* Commented as no need to calculate already paid amount services or discount services -- Pooja
	        $('.chk_parent_paid').each(function(){
	        	 this.checked = true;  //select all checkboxes with class "chk_parent"
	             selectedParent =$(this).attr('id').split('_')[1] ;
		         	  $('.service_'+selectedParent).each(function () { 
		         		 if($(this).is(':disabled') && !$(this).is(':checked')){
		         			if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
			         			if(parseInt($(this).val())==1){
										val=0;
			         			}else{
										val=parseInt($(this).val());
			         			}
			         			selectVal =selectVal+val;		   
			        		}else{
			        		  		this.checked = false;
				         	}
		         		 }
			            	
					});
	         });*/
	         selectVal=0;
	         $(".checkedValue").text(selectVal);
	    	 $('#actAmount').val(selectVal);
	         $(".checkedValue").val(selectVal);
	         amtToPay=selectVal;
	         $('.exclude_discount').prop('checked',false);

	     }

	});


	$("#send-approval").click(function(){
		$("#submit").hide();

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
		else if($("#discount_reason").val() == 'empty')
	    {
	    	alert('Please select the reason');
			return false;
	    }
	    else if($("#discount_authorize_by").val() != 'empty' && $("#discount").val() != '')
		{
	    	$(".discountType").each(function () {  		//check the radio whether Amount or Percentage
		        if ($(this).prop('checked')) {
					type = this.value;
									
		        }
		    });
			  
		    patientId = '<?php echo $patient['Patient']['id']; ?>';
			discount = $("#discount").val();			//discount may be amount or percentage
			totalamount = $("#totalamount").val();
			user = $("#discount_authorize_by").val();	//authhorized user whom we are sending approval
			payment_category = 'Finalbill';
			reasonForDiscount = $('#discount_reason').val();

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
						 $("#discount_reason").prop("disabled",true);
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
	{	type = '' ; //amount or percentage 
		$(".discountType").each(function () {  		//check the radio whether Amount or Percentage
	        if ($(this).prop('checked')) {
				type = this.value;				
	        }
	    });
		patientId = '<?php echo $patient['Patient']['id']; ?>';
    	user = $("#discount_authorize_by").val();
    	payment_category = 'Finalbill';
    	
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
					$("#submit").show();
					$("#image-gif").hide();
					$("#discount").prop("readonly", true);
					$(".discountType").prop("disabled",true);
					$("#is_approved").val(2);  //for approval complete
					clearInterval(interval); // stop the interval
					$("#discount_authorize_by").show();		//hide Approval users
					$("#cancel-approval").show();			//hide cancel button
					
				}
				else
				if(data == 2)		// if rejected by users
				{
					$("#submit").show();
					$("#image-gif").hide();
					clearInterval(interval); // stop the interval
					$('#resetAll').trigger('click');
					resetDiscountRefund();
					$("#mesage").show();
					$("#status-approved-message").html('<font color="red">Request for discount has been rejected</font>');
					/*$("#is_approved").val(3);	// for approval reject
					$("#discount").attr('disabled',true);	// set disabled
					$("#discount").prop("readonly", true);
					$(".discountType").prop("disabled",true);
					$(".discount_authorize_by").prop("disabled",true);
					clearInterval(interval); // stop the interval
					$("#discount_authorize_by").show();		//hide Approval users
					$("#cancel-approval").show();			//hide cancel button
					*/		
				}
			} //end of success
		});
	}

	//for cancelling the unapproved approval of discount only
	 $("#cancel-approval").click(function(){

		var result = confirm("Are you sure to cancel the request for discount?");
		 if(result == true){
			$("#submit").show();
			//***************************///////////
			var totalChk='0'; var defaultVal=0;
			$(".chk_parent:checked").each(function (){
				var count=0; 
				  checkId=this.id;
				  selectedParent =checkId.split('_')[1] ;
			         if($(this).is(':checked')){ 
			        	  $('.service_'+selectedParent).each(function () { 
				            	if(!$(this).is(':disabled') && $(this).is(':checked')){
				            		totalChk++;
					            	count++;
					            	if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
		 		            			defaultVal =parseFloat(defaultVal)+parseFloat($(this).val());	
					            	}else{
   	 			            		this.checked = false;
   	 			            	}	   
				      		  	}
				      		  	 
					     	});
					     	if(count==0){
						     	$(this).removeClass('chk_parent');
						     	$(this).addClass('chk_parent_paid');
						     	$(this).parent('div').siblings().addClass('paid_payment');
						     	$(this).parent('div').removeClass('pending_payment');
					     		$(this).attr('disabled',true);
					     	}else{
					     		$(this).parent('div').siblings().addClass('pending_payment');
						     	
					     	}
							
							/*if(totalChk=='0'){
					     		$('#disRow').hide();
					     	}else{
								$('#disRow').show();
							}*/
			         }
			 });
			 defaultVal=Math.round(defaultVal);
			 if(defaultVal<0)
				 defaultVal=0;
			 $(".checkedValue").text(defaultVal);
			 $('#actAmount').val(defaultVal);
			 $(".checkedValue").val(defaultVal);
			 		
			//*****************************//////
			patientId = '<?php echo $patient['Patient']['id']; ?>';
			discount = $("#discount").val();
			user = $("#discount_authorize_by").val();
			payment_category = 'Finalbill';
			
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
					interval='';					
					resetDiscountRefund();
					display();
				  }
			});
		 }	//end of if
	 });

	 $("#submit").click(function(){
		 var disp_msg='';
		 var instance="<?php echo $configInstance;?>";
	    	var validatePerson = jQuery("#billingsDiscountOnlyForm").validationEngine('validate'); 
	  	 	if(!validatePerson){
	  		 	return false;
	  		}
	  	  	var chkpay= $('#actAmount').val();	  		
	        is_approved = parseInt($("#is_approved").val());
			
				  if($(".discountType").is(":checked")){
				  	if(is_approved=='1'){
				       // alert($("#is_approved").val());
				        alert("Please wait for approval");
				        return false;
			        }

			        if($("#is_approved").val()=='3'){
				        alert("Your approval has been rejected bu user, please cancel the request to save");
				        return false;
			        }
				  if($("#discount").val()==''){
					  alert('Please pay some amount In Discount.');
					  return false;
				  }
				  if((instance=='vadodara' && parseInt($("#actAmt").val())>=10000) || instance=='kanpur'){
					  if($("#is_approved").val()==='0'){				  
						  var confirm_dis= confirm("Do You Want To Send Approval Request For Discounted Amount ?"); 
						  if(confirm_dis==true){
							  $('#discount').focus();
							  return false;
						  }else{
							  return true;
						  }
					  }	
				  }			  
				  //chkpay=chkpay-parseInt($('#disc').val());
				  }
				  $("#submit").attr('disabled',true);
				  $('#resetAll').attr('disabled',true);
			 
	 });


	 $('#resetAll').on('click',function(){
		 if($('#foc').is(':checked')){
				$('#foc').trigger('click');
		 }
		 if($('#resetDiscount').is(':checked')){
			 $('#resetDiscount').trigger('click');
		 }
		 
    	 resetDiscountRefund();    	 
    	//$('#patient_card').val('');
    	 $('#discountType').val('');
    	 $('#typeDiscount').val('');
    	 $('#maintainDiscount').val('');
    	 $('#disc').val('');
    	 //$('#discount').val('');
    	 $('#discount_authorize_by').val('');
    	 $('#status-approved-message').hide();
    	 discountApproval();	//check any previous approval for discount for finalBill only
    	 RefundApproval();
    	 $('.select_all').attr('checked', true);
    	 $('#submit').show();
    	 $('.chk_parent').attr('checked', true);
    	 $('.chk_child').attr('checked', true);
	 	 $('.chk_child_paid').attr('checked', true);
	 	 $('.chk_parent_mandatory').attr('checked', true);
	 	 $('.chk_parent_paid').attr('checked', true);
	 	 $('.chk_parent_paid').attr('disabled', true);
	 	 $('.chk_child_mandatory').attr('checked', true);
	 	 $('.chk_child_doc').attr('checked', true); 
	 	 $('.exclude_discount').attr('checked', false);
	 	 $('.exclude_discount').attr('disabled', true);
	 	$('.discount_excluded').attr('disabled', true);
	 	$('#foc').attr('disabled', false);
    	 	 
    	 		var defaultVal=0;var totalChk=0;
    	 	 $(".chk_parent:checked").each(function (){
    	 		var count=0; 
    	 		  checkId=this.id;
    	 		  selectedParent =checkId.split('_')[1] ;
    	 	         if($(this).is(':checked')){ 
    	 	        	  $('.service_'+selectedParent).each(function () { 
    	 		            	if(!$(this).is(':disabled') && $(this).is(':checked')){
    	 		            		totalChk++;
    	 			            	count++;
    	 			            	if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
		 		            			defaultVal =parseFloat(defaultVal)+parseFloat($(this).val());	
    	 			            	}else{
    	 			            		this.checked = false;
    	 			            	}	   
    	 		      		  	}
    	 		      		  	
    	 			     	});
    	 			     	if(count==0){
    	 				     	$(this).removeClass('chk_parent');
    	 				     	$(this).addClass('chk_parent_paid');
    	 				     	$(this).parent('div').siblings().addClass('paid_payment');
    	 				     	$(this).parent('div').removeClass('pending_payment');
    	 			     		$(this).attr('disabled',true);
    	 			     	}else{
    	 			     		$(this).parent('div').siblings().addClass('pending_payment');
    	 				     	
    	 			     	}
    	 					
    	 					/*if(totalChk=='0'){
    	 			     		$('#disRow').hide();
    	 			     	}else{
    	 						$('#disRow').show();
    	 					}*/
    	 	         }
    	 	 });
    	 	 var mandCharges=parseInt($('.chk_parent_mandatory').val());
    	 	 if(!isNaN(mandCharges))
    	 		 defaultVal=parseFloat(defaultVal)+parseFloat(mandCharges);
	 		 defaultVal=Math.round(defaultVal);
	 		if(defaultVal<0)
				 defaultVal=0;
    	 	 $(".checkedValue").text(defaultVal);
    	 	 $('#actAmount').val(defaultVal);
    	 	 $(".checkedValue").val(defaultVal);
    	 	 	
			


	     });


	 function RefundApproval(){
			resetRefund();			//reset all Refund)
			patientId = '<?php echo $patient['Patient']['id']; ?>';
	    	payment_category = 'Finalbill';
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
					  parseData = $.parseJSON(data);
					  //console.log(parseData);
				 if(parseData != null) {

					 patientId = '<?php echo $patient['Patient']['id']; ?>';
						payment_category = 'Finalbill';
					    is_approved = parseInt(parseData.is_approved);
					    request_to = parseInt(parseData.request_to);
					    is_type = parseData.type;
						

						$.ajax({
							  type : "POST",
							  data: "patient_id="+patientId+"&request_to="+request_to+"&type="+is_type+"&payment_category="+payment_category,
							  url: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "cancelApproval","admin" => false)); ?>",
							  context: document.body,
							  beforeSend:function(){
								  $("#busy-indicator").show();
							  },	
							  success: function(data){ 
								$("#busy-indicator").hide();					
								clearInterval(interval); 					// stop the interval
								interval='';
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
					  $("#refund_amount").attr('readonly',true);
						$("#is_refund").attr('disabled',true);
						$("#discount_authorize_by_for_refund").show();
						$("#discount_authorize_by_for_refund").val(request_to);
				        $("#discount_authorize_by_for_refund").attr('disabled',true);
				        $("#cancel-refund-approval").show();
				        $("#mesage2").show();
				        
					if(parseInt(is_approved) == 0)
					{
						$("#mesage2").show();
						$("#status-approved-message-for-refund").html("apporval Request for Refund has been sent, please wait for approval");
						$("#is_refund_approved").val(1);	//for approval waiting
						$("#image-gif2").show();
						$("#image-gif2").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
						
						//set interval for clicked service group 
						refund_interval = setInterval("NotificationsForRefund()", 5000);  // this will call Notifications() function in each 5000ms
					  }
					else if(is_approved == 1)
					{	
						  $("#status-approved-message-for-refund").html('<font color="green">Request for Refund has been completed</font>');
						  $("#is_refund_approved").val(2);	
						  $("#image-gif2").hide();
						  $("#hrefund").val(1);		  
					  }
					else if(is_approved == 2)
					{
						$("#status-approved-message-for-refund").html('<font color="red">Request for Refund has been rejected</font>');
						$("#image-gif2").hide();
						$("#is_refund_approved").val(3);	// for approval reject
						$("#hrefund").val(1);
				 	} 		*/
					display();	//calculate balance			  
				  }
				} 	//end of success
			}); 	//end of ajax
		}
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
					var patientId = '<?php echo $patient['Patient']['id']; ?>';
					refundAmount = $("#refund_amount").val();
					payment_category = 'Finalbill';
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
								$('#submit').hide();
							}
						} //end of success
					}); //end of ajax
			} //end of if else
			
		});


	//for cancelling the unapproved approval of discount only
	 $("#cancel-refund-approval").click(function(){
		var refundResult = confirm("Are you sure to cancel the request for Refund?");
		if(refundResult == true){
			patientId = '<?php echo $patient['Patient']['id']; ?>';
			refund_amount = $("#refund_amount").val();
			user = $("#discount_authorize_by_for_refund").val();
			payment_category = 'Finalbill';
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
						$('#mesage2').hide();
						$('#submit').show();
						clearInterval(refund_interval); 					// stop the interval
						resetRefund();
						
					  $('.chk_parent').each(function() { //loop through each checkbox
							 $(this).attr('disabled',false);
				             this.checked = false; //deselect all checkboxes with class "chk_parent"                             
				        });	          
				        $('.chk_child').each(function() { //loop through each checkbox
				        	  $(this).attr('disabled',false);
				             this.checked = false;  //select all checkboxes with class "chk_child"
				        });
				        
				        $('.chk_parent_paid').each(function() { //loop through each checkbox
							 $(this).attr('disabled',true);
				             this.checked = true; //deselect all checkboxes with class "chk_parent_paid"                             
				        });	          
				        $('.chk_child_paid').each(function() { //loop through each checkbox
				        	  $(this).attr('disabled',true);
				             this.checked = true;  //select all checkboxes with class "chk_child_paid"
				        });
						 var selectVal=0;
					      $('.chk_parent').each(function() { //loop through each checkbox
					             this.checked = true;  //select all checkboxes with class "chk_parent"
					             selectedParent =$(this).attr('id').split('_')[1] ;
						         	  $('.service_'+selectedParent).each(function () { 
							            	if(!$(this).is(':disabled')){
							            		selectVal =parseFloat(selectVal)+parseFloat($(this).val());		   
							      		  	}
								     	});	                              
					         });
					      	 selectVal=Math.round(selectVal);
					      	if(selectVal<0)
								 selectVal=0;
					      	 $(".checkedValue").val(selectVal);
					         $("#actAmount").val(selectVal);
					         $(".checkedValue").text(selectVal);
					         
					         $('.chk_child').each(function() { //loop through each checkbox
					             this.checked = true;  //select all checkboxes with class "chk_child"
					         });
					
					display();
				  }
			});
		}
	 });

	 function NotificationsForRefund()
		{
			type = "Refund" ;  
			patientId = '<?php echo $patient['Patient']['id']; ?>';
	    	user = $("#discount_authorize_by_for_refund").val();
	    	payment_category = 'Finalbill';
	    	
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
						$('#submit').show();
						$("#discount_authorize_by_for_refund").show();
						$("#discount_authorize_by_for_refund").attr('disabled',true);						
					}
					else
					if(parseInt(data) == 2)		// if rejected by users
					{
						resetRefund();
						$("#mesage2").show();
						$("#status-approved-message-for-refund").html('<font color="red">Request for Refund has been rejected</font>');
						$("#image-gif2").hide();
						//$("#is_refund_approved").val(3);	// for approval reject
						clearInterval(refund_interval); 	// stop the interval
						$("#hrefund").val(0);
						$('#submit').show();
					}
				} //end of success
			});
		}
	
	 function resetRefund()
		{ 
		 var instance="<?php echo $configInstance;?>";
		 	$('#select').prop('checked', true);
			$('#select').attr('disabled', false);
			$('.chk_parent').each(function() { //loop through each checkbox
				 $(this).attr('disabled',false);
	             this.checked = false; //deselect all checkboxes with class "chk_parent"                             
	        });	          
	        $('.chk_child').each(function() { //loop through each checkbox
	        	  $(this).attr('disabled',false);
	             this.checked = false;  //select all checkboxes with class "chk_child"
	        });
	        
	        $('.chk_parent_paid').each(function() { //loop through each checkbox
				 $(this).attr('disabled',true);
	             this.checked = true; //deselect all checkboxes with class "chk_parent_paid"                             
	        });	          
	        $('.chk_child_paid').each(function() { //loop through each checkbox
	        	  $(this).attr('disabled',true);
	             this.checked = true;  //select all checkboxes with class "chk_child_paid"
	        });
			 var selectVal=0;
		      $('.chk_parent').each(function() { //loop through each checkbox
		             this.checked = true;  //select all checkboxes with class "chk_parent"
		             selectedParent =$(this).attr('id').split('_')[1] ;
		             $('.service_'+selectedParent).each(function () { 
			            	if(!$(this).is(':disabled') && !($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
			            		selectVal =parseFloat(selectVal)+parseFloat($(this).val());		   
			      		  	}	            	
				     	}); 
		     		                                
		         });
		      selectVal=Math.round(selectVal);
		      if(selectVal<0)
					 selectVal=0;
		      		$(".checkedValue").val(selectVal); 
		     	    $('#actAmount').val(selectVal);
				    amtToPay=selectVal; 
		            $(".checkedValue").text(selectVal);
		         
		         
		         $('.chk_child').each(function() { //loop through each checkbox
		             this.checked = true;  //select all checkboxes with class "chk_child"
		         });
		         $("#refund_amount").val('');
		         $("#refund_paid").val('');
				$("#refund_amount").hide();
				$('#send-approval-for-refund').hide();
				$("#discount_authorize_by_for_refund").hide();
			$("#is_refund").attr('disabled',false);
			$("#is_refund_approved").val(0);
			$("#is_refund").attr('checked',false);
			if(instance=='hope'){
				$("#refund_amount").attr('readonly',false);
			}else{
				$("#refund_amount").attr('readonly',true);
				}
			$("#refund_amount").val('');
			$("#refund_paid").val('');
			$("#refund_amount").hide();
			$("#discount_authorize_by_for_refund").attr('disabled',false);
			$("#discount_authorize_by_for_refund").hide();
			$("#send-approval-for-refund").hide();
			$("#cancel-refund-approval").hide();
			$('.paymentRemarkRefund').hide();
			$('.refund_amt').attr('checked',false); 
	        $('.exclude_discount ').attr('disabled',true);
	        $('.exclude_discount ').attr('checked',false); 
	        $('.refund_amt').attr('disabled',true);
			$("#mesage2").hide();
		}

		$('#foc').click(function(){	
			if($('#is_refund').is(':checked'))			
				resetRefund();
			if($('.discountType').is(':checked'))
				resetDiscountRefund();
				total=0;
			if($('#foc').is(':checked')){
				$('.phar_dis').attr('disabled',false);
				$('.phar_dis').prop('checked',true);
				$('.discountType').attr('disabled',true);
				$('.phar_dis').removeClass('exclude_discount');
				$('.phar_dis').removeClass('discount_excluded');
				$('.phar_dis').removeClass('chk_parent_paid');	
				
				$('.chk_parent').each(function() { //loop through each checkbox
	 	     		if($(this).is(':checked')){ 
	              	  selectedParent =$(this).attr('id').split('_')[1] ;
	 	         	  $('.service_'+selectedParent).each(function () { 
		 	         	  if(!$(this).is(':disabled') && $(this).is(':checked') && (!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))) || $(this).hasClass('phar_dis')){
		 	         		total =parseFloat(total)+parseFloat($(this).val());		   
	 		      		  	}	            	
	 			     	});	 
	 	     		}                             
	         	 });			
			}else{
				total=0;
				$('.phar_dis').attr('disabled',true);
				$('.phar_dis').attr('checked',false);
				$('.discountType').attr('disabled',false);
				$('.phar_dis').addClass('exclude_discount');
				$('.phar_dis').addClass('discount_excluded');
				$('.phar_dis').addClass('chk_parent_paid');	
				$('.chk_parent').each(function() { //loop through each checkbox
	 	     		if($(this).is(':checked')){ 
	              	  selectedParent =$(this).attr('id').split('_')[1] ;
	 	         	  $('.service_'+selectedParent).each(function () { 
		 	         	  if(!$(this).is(':disabled') && $(this).is(':checked') && !($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
		 	         		total =parseFloat(total)+parseFloat($(this).val());		   
	 		      		  	}	            	
	 			     	});	 
	 	     		}                             
	         	 });		
			}
			
			total=Math.round(total);
			if(total<0)
				total=0;
			$(".checkedValue").text(total);
			$('#actAmount').val(total);
			amtToPay=total;
		 	$(".checkedValue").val(total);
			


			
		});


		$('#resetDiscount').click(function(){
			if($('#is_refund').is(':checked'))			
				resetRefund();
			if($('.discountType').is(':checked'))
				resetDiscountRefund();
			if($('#foc').is(':checked'))
				$('#foc').trigger('click');
			if($('#resetDiscount').is(':checked')){
				
				$('.chk_parent').attr('disabled',true);
				$('.chk_child').attr('disabled',true);
				$('.chk_parent').attr('checked',false);
				$('.chk_child').attr('checked',false);
				$('.chk_parent_paid').attr('checked',false);
				$('.chk_child_paid').attr('checked',false);
				$('#select').trigger('click');	
				$('.reset_dis').attr('disabled',false);
				$('.reset_child_dis').attr('disabled',false);
				$('.reset_dis').attr('checked',false);
				$('.reset_child_dis').attr('checked',false);
				$('.discountType').attr('disabled',true);
				$('#is_refund').attr('disabled',true);
				$('#foc').attr('disabled',true);				
				$('#select').attr('disabled',true);
				$('#serSel').hide();			
			}else{
				$('#select').attr('disabled',false);
				$('.chk_parent').attr('disabled',false);
				$('.chk_child').attr('disabled',false);
				$('.reset_dis').attr('disabled',true);
				$('.reset_child_dis').attr('disabled',true);				
				$('.chk_parent_paid').attr('disabled',true);
				$('.chk_child_paid').attr('disabled',true);
				$('.discountType').attr('disabled',false);
				$('.phar_dis').attr('disabled',true);
				$('.discount_excluded').attr('disabled',true);
				$('.exclude_discount').attr('disabled',true);				
				$('#is_refund').attr('disabled',false);
				$('#foc').attr('disabled',false);
				$('#serSel').show();
				$('#select').trigger('click');
							
			}
		});	
 
</script>
