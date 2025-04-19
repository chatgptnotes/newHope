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
	backg-color: #F0F0F0;
}

input,textarea {
	border: 1px solid #999999;
	padding: none !important;
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
	width: 47%;
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
	width: 7%;
}

.prntDiv7 {
	float: left;
	width: 6%;
	
}

.prntDiv8 {
	float: left;
	width: 6%;
	padding:0px 0px 0px 5px;
}

.chldDiv1 {
	float: left;
	padding: 0 6px 0 0;
	width: 46%;
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
	width: 6%;
}

.chldDiv8 {
	float: left;
	width: 6%;
	padding:0px 0px 0px 5px;
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

#ui-datepicker-div{
		width: 190px;
}
</style>
<script type="text/javascript">
        $(document).ready(function() {
        		checkBalance();		//check balance if >0 display reason of balance
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
<?php 	 

	$qryStr=$this->params->query;
	if($qryStr['print']=='print' && $this->Session->read('website.instance')=='vadodara'){
			if($this->params->query['corporate']){	
					echo '<script>	parent.location.reload(); 
	    							parent.$.fancybox.close();</script>';
			}		
		?> 
		<script>
		<?php if($patient['Patient']['admission_type']=='IPD'){?>
		 var url="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'printReceipt',$patient['Patient']['id'],$this->params->query['print'])); ?>";
		 <?php }else{?>
		 var url="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'getBilledServicePrint',$qryStr['billId'])); ?>";
		 <?php }?>
	    window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready
	    parent.location.reload(); 
	    parent.$.fancybox.close();
		/* var url="<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'printReceipt',$patient['Patient']['id'],$this->params->query['print'])); ?>";
	    window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready
	    parent.location.reload(); 
	    parent.$.fancybox.close();*/
	    </script>
	    <?php  
	}	
	echo $this->Form->create('billings',array('url'=>array('controller'=>'billings','action'=>'full_payment',$patient['Patient']['id'],'?'=>$qryStr),
	'inputDefaults' => array('label' => false,'div' => false,'error' => false,'legend'=>false,'fieldset'=>false)));
	echo $this->Form->hidden('Billing.patient_id',array('value'=>$patient['Patient']['id']));
	echo $this->Form->hidden('Billing.bill_number',array('value'=>$billNumber));
	echo $this->Form->hidden('Billing.tariff_id',array('value'=>$tariffStdData['Patient']['tariff_standard_id']));
	echo $this->Form->hidden('Billing.appoinment_id',array('value'=>$appoinmentID));
	echo $this->Form->hidden('payOnlyAmount',array('value'=>$totalPaymentFlag));
	if($corporateEmp!=''){
			$hideCGHSCol = '';
			if(strtolower($corporateEmp) == 'private'){
				$hideCGHSCol = "display: none"; ;
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
	
	$pharmaConfig='no';
	?>
<div style="margin-bottom: 10px">
	<a id='collapse-all' href='javascript:void(0);' class='blueBtn' >
		Collapse All
	</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a id='expand-all' href='javascript:void(0);' class='blueBtn' >
		Expand All
	</a>
</div>
<div style="max-width: 1100px; border: 1px solid black">
	<div  style="clear: both; width: 734px;">
		<div align="center" class="tdBorderBt"
			style="float: left; height: 32px;">&nbsp;</div>
		<div align="center" class="tdBorderRtBt"
			style="float: left; width: 53%; height: 32px;">Item</div>
		<?php // padding: 0px 107px 0px 0px;?>
		<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
		<div style="float: left; width: 6%; height: 32px;" align="center"
			class="tdBorderRtBt">
			<?php //padding: 0px 97px 0px 0px;?>
			<?php echo $patient['TariffStandards']['name'];?>
			MOA Sr. No.
		</div>
		<?php }?>
		<div style="<?php echo $hideCGHSCol ;?>; float: left;  width: 5%; height: 32px;" align="center" class="tdBorderRtBt" >CGHS
			Code No.</div>
		<?php //padding: 0px 97px 0px 0px; ?>
		<div style="float: left; width: 8%; height: 32px;" align="center"
			class="tdBorderRtBt">Rate</div>
		<?php //padding: 0px 87px 0px 0px;?>
		<div style="float: left; width: 7%; height: 32px;" align="center"
			class="tdBorderRtBt">Qty.</div>
		<?php // padding: 0px 95px 0px 0px;?>
		<div style="float: left; width: 8%; height: 32px;" align="center"
			class="tdBorderRtBt">Amount</div>
		<?php // padding: 0px 34px 0px 0px;?>
		<div style="float: left; height: 32px;" align="center"
			class="tdBorderBt">Discount</div>
		<div style="height: 32px;" align="center"
			class="tdBorderBt">Paid Amount</div>
			
		<?php // padding: 0px 25px 0px 0px;?>
	</div>
	<div style="width:100%">
	<div id="tree" style="max-height: 250px; overflow: scroll; clear: both; float: left; width: 754px;">
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
			<div align="center" class="prntDiv8">&nbsp;</div>
			<!--  <td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong></td>  -->
		</div>
		<br>
		<?php $lastSection='Conservative Charges';?>
		<?php }?>

		<ul>
			<!-- Start of Main UL -->
			<?php if($registrationRate!='' && $registrationRate !=0){
				$srNo++;
				?>
			<div>
				<li>
					<div align="center" class="tdBorder" style="float: left;">
						<?php echo $this->Form->input('Billing.reg_check',array('type'=>'checkbox','id'=>'reg','class'=>'chk_dhild'));?>
					</div>
					<div class="tdBorderRt prntDiv1">Registration Charges</div> <?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
					<div align="center" class="tdBorderRt prntDiv2 ">
						<?php echo $registrationChargesData['TariffAmount']['moa_sr_no'];
						echo $this->Form->hidden('',array('name'=>'data[Billing][0][moa_sr_no]','value' => $registrationChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
						?>
					</div> <?php }?>
					<div align="center" class="tdBorderRt prntDiv3" style="<?php echo $hideCGHSCol ;?>;">
						<?php 

						echo $registrationChargesData['TariffList']['cghs_code'];
						echo $this->Form->hidden('',array('name'=>'data[Billing][0][nabh_non_nabh]','value' => $registrationChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
						?>
					</div>
					<div align="center" valign="top" class="tdBorderRt prntDiv4">
						<?php echo $this->Form->hidden('',array('name'=>'data[Billing][0][unit]','value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
						// echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
						echo $registrationRate;
						?>
					</div>
					<div align="center" valign="top" class="tdBorderRt prntDiv5">
						<?php 
						echo $this->Form->hidden('',array('name'=>'data[Billing][0][name]','value' => 'Registration Charges','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						#echo $this->Form->hidden('',array('name'=>'data[Billing][0][unit]','value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						echo $this->Form->hidden('',array('name'=>'data[Billing][0][rate]','value' => $registrationRate,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						echo '--';
						?>
					</div>

					<div align="center" valign="top" class="tdBorderRt prntDiv6">
						<?php 
						echo $this->Form->hidden('',array('name'=>'data[Billing][0][amount]','value' => $registrationRate,'legend'=>false,'label'=>false,'id' => 'registration_amount','style'=>'text-align:right;'));
						//echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
						echo $registrationRate;
						?>
					</div>
					<div align="center" class="prntDiv7">&nbsp;</div>
					<div align="center" class="prntDiv8">&nbsp;</div>
				</li>
			</div>
			<br>
			<br>
			<br>
			<?php }?>
			<?php //debug($serviceCategoryName);
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
									 $consultPaid=($consultantAdv+$phyAdv);
									 if($consultPaid!='0' || $consultPaid>0){
											$class='chk_parent_paid';
										}
										//Deducting the total paid and discount amuont from total service amount
										$conDis=$phyDiscount+$consultantDiscount;									
								if(!empty($totalCostConsultant) || $totalCostConsultant !=0){?>

			<li>
				<div>
					<div align="center" class="tdBorder" style="float: left;">
						<?php echo $this->Form->input('Billing.consultant_charges',array('type'=>'checkbox','id'=>"consultant_$consultantServiceId",'class'=>'chk_parent '.$class,'value'=>$totalCostConsultant-($consultPaid+$conDis)));?>
					</div>
					<div class="tdBorderRt prntDiv1">
						<?php echo $serviceCategoryName[$serviceKey];?>
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
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][consultant_rate]",'value' => $totalCostConsultant,'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
						echo $totalCostConsultant;
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
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][consultant_amount]",'value' => $totalCostConsultant,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo $totalCostConsultant;
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class="prntDiv7">
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][consultant_discount]",'class'=>'discount_parent_consultant_'.$consultantServiceId,'value' => $phyDiscount+$consultantDiscount,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round(($phyDiscount+$consultantDiscount));
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class="prntDiv8">
						<?php $paidCon=round($consultPaid);
						if($paidCon<=0){
							echo "0";
							$paidCon=0;
						}else echo round($paidCon);
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][consultant_paid_amount]",'class'=>'paid_parent_consultant_'.$consultantServiceId,'value' =>($paidCon),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						
						//echo $this->Number->format($lCost) ;
						$paidCon=0;
						?>
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
							//$totalWardDays=0;
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
											$surgeryAdv=$surgeryAdv+$uniqueSlot['paid_amount'];//-$uniqueSlot['discount'];
											$surgeryDis=$surgeryDis+$uniqueSlot['discount'];
										}	
										$totalOtServiceCharge=0;
								}

								if(!empty($totalSurgeryCost) || $totalSurgeryCost!=0){?>
			<li>
				<div>
					<div align="center" class="tdBorder" style="float: left;">
						<?php echo $this->Form->input('Billing.surgery_charges',array('type'=>'checkbox','id'=>"surgery_$surgeryServiceId",'class'=>'chk_parent','value'=>$totalSurgeryCost-($surgeryAdv+$surgeryDis)));?>
					</div>
					<div class="tdBorderRt prntDiv1">
						<?php echo $serviceCategoryName[$serviceKey];?>
						<?php $v++;
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
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][surgery_amount]",'value' => $totalSurgeryCost,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo $totalSurgeryCost;
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class="prntDiv7">
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][surgery_discount]",'class'=>'discount_parent_surgery_'.$surgeryServiceId,'value' => $surgeryDis,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($surgeryDis);
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class="prntDiv8">
						<?php $surPaid=round($surgeryAdv);
						if($surPaid<=0){
								echo '0';
								$surPaid=0;
								
						}else
						echo $surPaid;
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][surgery_paid_amount]",'class'=>'paid_parent_surgery_'.$surgeryServiceId,'value' => $surPaid,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						
						?>
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
							}*/
							 foreach($wardNew['day'] as $roomKey=>$roomCost){
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
								/*foreach($wardRow as $wardrCost){
										$wardCharges=$wardCost;
										//$wardCharges=$wardCharges+($wardCost['days']*$wardCost['rate']);
										//$wardAdv=$wardAdv;//-$wardCost['discount'];
										$wardDis=$wardDis+$wardrCost['discount'];
								}*/
								$class='';$divClass='';
								if((($wardAdv+$wardDis)) < $wardCharges){//if partially paid from pharmacy then remaing balance should be able to pay
									$class=' chk_parent';
									$divClass=' pending_payment';
								}else{
									$wardDisable="disabled";
									$class=' chk_parent_paid';
									$divClass=' paid_payment';
										
								}
								/*if($wardAdv!='0' || $wardAdv>0){
									$class='chk_parent_paid';
								}*/
								if(!empty($wardCharges) || $wardCharges!=0){
						?>
			<li><div>
					<div align="center" class="tdBorder" style="float: left;" >
						<?php echo $this->Form->input('Billing.'.$category.'.'.$serviceKey.'.'.'valChk',array('type'=>'checkbox','id'=>"ward_$wardServiceId",'class'=>'exclude_discount service_'.$wardServiceId.$class,'value'=>$wardCharges-($wardAdv+$wardDis)));
						//echo $this->Form->input('Billing.ward_charges',array('type'=>'checkbox','id'=>"ward_$wardServiceId",'class'=>'exclude_discount chk_parent service_'.$wardServiceId.$class,'value'=>$wardCharges-($wardAdv+$wardDis)));?>
					</div>
					<div class="<?php echo "prntDiv1 tdBorderRt $divClass";?>">
						<?php echo $serviceCategoryName[$serviceKey]; //Room Tariff?>
						<?php $v++;
						echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][name]",'value' => "ward_charges",'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][service_id]",'value' =>$serviceKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][id]",'value' =>$serviceKey,'legend'=>false,'label'=>false));
						?>
						<br>
					</div>
					<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
					<div align="center" class="<?php echo "prntDiv2 tdBorderRt $divClass";?>">&nbsp;</div>
					<?php }?>
					<div align="center" class="<?php echo "prntDiv3 tdBorderRt $divClass";?>" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
					<div align="center" valign="top" class="<?php echo "prntDiv4 tdBorderRt $divClass";?>">
						<?php
						echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][rate]",'value' => $wardCharges,'legend'=>false,'label'=>false,'id' => 'ward_rate','style'=>'text-align:right;'));
						echo $wardCharges;
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class="<?php echo "prntDiv5 tdBorderRt $divClass";?>">
						<?php 
						echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
						echo '--';

						?>
					</div>

					<div align="center" valign="top" class="<?php echo "prntDiv6 tdBorderRt $divClass";?>">
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][amount]",'value' => $wardCharges,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo $wardCharges;
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class="<?php echo "prntDiv7  $divClass";?>">
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][discount]",'class'=>'discount_parent_ward_'.$wardServiceId,'value' => $wardDis,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($wardDis);
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class="<?php echo "prntDiv8 $divClass";?>">
						<?php $wardPaid=round($wardAdv);
						if($wardPaid<=0){
							echo '0';
							$wardPaid=0;
						}else echo round($wardPaid);
						echo $this->Form->hidden('',array('name'=>"data[Billing][$category][$serviceKey][paid_amount]",'class'=>'paid_parent_ward_'.$wardServiceId,'value' => $wardPaid,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						
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
								$manDiscount=$manDiscount+$nursingServicesCost['ServiceBill']['discount'];
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

						$mandatoryAdv=$mandatoryAdv+$doctorPaidCharges+$nursePaidCharges/*-($manDiscount+$doctorDiscount+$nurseDiscount)*/;
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
							if($mandatoryAdv!='0' && $mandatoryAdv>0){
								$class='chk_parent_paid';
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
						<?php echo $serviceCategoryName[$serviceKey]; //Mandatory Services?>
						<?php $v++;
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
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' => $this->Number->format($totalMandatoryServiceCharge,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'mandatory_rate','style'=>'text-align:right;'));
						echo $this->Number->format($totalMandatoryServiceCharge,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
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
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' => $this->Number->format($totalMandatoryServiceCharge,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo $this->Number->format($totalMandatoryServiceCharge,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top"
						class="<?php echo "prntDiv7 pending_payment" ?>">
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][discount]",'class'=>'discount_parent_mandatory_'.$mandatoryKey,'value' => ($manDiscount+$doctorDiscount+$nurseDiscount),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round(($manDiscount+$doctorDiscount+$nurseDiscount));
						?>
					</div>
					<div align="center" valign="top"
						class="<?php echo "prntDiv8 pending_payment" ?>">
						<?php 
							$manPaid=round($mandatoryAdv);
							if($manPaid<=0){
								echo '0';
								$manPaid=0;
							}else{
								echo $manPaid;
							}
							echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][paid_amount]",'class'=>'paid_parent_mandatory_'.$mandatoryKey,'value' => $manPaid,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						?>
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


			<?php if($pharmConfig){
			if($category==Configure::read('Pharmacy')){
				$pharmaConfig='yes';
				$pharmacyKey =$serviceKey;
				if($pharmacyPaidData['0'][0]['total'] !='' && $pharmacyPaidData['0'][0]['total']!=0){
					$pharmacy_charges=$pharmacyPaidData['0'][0]['total'];

						?>
			<li><?php //dpr($pharmacyPaidData['0'][0]['total']);
						//dpr($pharmacyreturnData[0][0]['total']);
			$pharCost=$pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total'];/*-$pharmacyPaidData['0'][0]['paid_amount']);$pharDisable='';*/
			$pharDiscount=$pharmacyPaidData['0'][0]['discount']-$pharmacyreturnData['0']['0']['total_discount'];
			if($pharmacyPaidData['0'][0]['paid_amount']!='0'){
				$pharmacyAdv=$pharmacyPaidData['0'][0]['paid_amount']-$pharmacyReturnPaid['pharmacy']['0']['total'];//-$pharmacyPaidData['0'][0]['discount']);
			}else{
					$pharmacyAdv=0;
			}			
			if($pharmacyAdv >= $pharCost-$pharDiscount){//if partially paid from pharmacy then remaing balance should be able to pay
				$pharDisable="disabled";
				$class='chk_parent_paid';
				$divClass='paid_payment';
			}else{				
				$class='chk_parent';
			}
						$srNo++;	?>
				<div>
					<div align="center" class="<?php echo "tdBorder";?>" style="float: left;">
						<?php echo $this->Form->input("Billing.Pharmacy.".$serviceKey.".valChk",array('type'=>'checkbox','id'=>'pharmacy_'.$pharmacyKey,'class'=>"$class service_".$pharmacyKey,'value'=>$pharCost-$pharmacyAdv-$pharDiscount,'label'=>false));?>
					</div>
					<div class="<?php echo "prntDiv1 tdBorderRt $divClass";?>" >
						<?php echo $serviceCategoryName[$serviceKey]; //Pharmacy Charges ?>
						<?php $v++;
						echo '&nbsp;'.$this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][editAmt]",'id'=>'phar_'.$serviceKey,'class'=>'textAmt','value' =>$pharCost,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][id]",'value' =>$pharmacyKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][service_id]",'value' =>$pharmacyKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][name]",'value' => "Pharmacy Charges",'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][discount]",'class'=>'pharmacy_discount_'.$pharmacyKey,'value' => $pharDiscount,'legend'=>false,'label'=>false));
						?>
					</div>
					<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
					<div align="center" class="<?php echo "prntDiv2 tdBorderRt $divClass";?>">&nbsp;</div>
					<?php }?>
					<div align="center" class="<?php echo "prntDiv3 tdBorderRt $divClass";?>" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
					<div align="center" valign="top" class="<?php echo "prntDiv4 tdBorderRt $divClass";?>">
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][rate]",'value' => $this->Number->format(($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']/*-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							echo round(($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']));
						?>
					</div>
					<div align="center" valign="top" class="<?php echo "prntDiv5 tdBorderRt $divClass";?>">
						<?php 	
							echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
							echo '--';
						?>
					</div>

					<div align="center" valign="top" class="<?php echo "prntDiv6 tdBorderRt $divClass";?>">
						<?php 
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][amount]",'value' => $this->Number->format(($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total']/*-$pharmacyAdv-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						//echo $this->Number->format(($pharmacyPaidData['0'][0]['total'])-($pharmacyreturnData[0][0]['total']-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
						echo round(($pharmacyPaidData['0'][0]['total']-$pharmacyreturnData[0][0]['total'])/*-$pharmacyPaidAmount*/);
									//echo $this->Number->format($pharmacyPaidData['0'][0]['total'])-($pharmacyreturnData[0][0]['total'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>
					</div>
					<div align="center" valign="top" class="<?php echo "prntDiv7  $divClass";?>">
						<?php 
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][discount]",'class'=>'discount_parent_pharmacy_'.$pharmacyKey,'value' => $pharDiscount,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][discount]",'class'=>'pharmacy_discount_'.$pharmacyKey,'value' =>$pharDiscount,'legend'=>false,'label'=>false));
						echo round($pharDiscount);
						?>
					</div>
					<div align="center" valign="top" class="<?php echo "prntDiv8  $divClass";?>">
						<?php 
						$pharPaid=round($pharmacyAdv);//-$pharmacyPaidData['0'][0]['discount'];
						if($pharPaid<=0){
							echo '0';
							$pharPaid=0;
						}else {
						echo round($pharPaid);
						}
						echo $this->Form->hidden('',array('name'=>"data[Billing][Pharmacy][$serviceKey][paid_amount]",'class'=>'paid_parent_pharmacy_'.$pharmacyKey,'value' => $this->Number->format(($pharPaid),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						
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
		  			 	}
		  		}?>
			<!-- End Of Pharmacy Charges -->
			
			<!-- OT Pharmacy Charges -->


			<?php 
			if($category==Configure::read('OtPharmacy')){
				$pharmaConfig='yes';
				$otPharmacyKey =$serviceKey;//debug($oTpharmacyPaidData);
				if($oTpharmacyPaidData['0'][0]['total'] !='' && $oTpharmacyPaidData['0'][0]['total']!=0){
						?>
			<li><?php //debug($pharmacyPaidData);
						//debug($oTpharmacy_charges);
			$oTpharCost=($oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']);/*-$pharmacyPaidData['0'][0]['paid_amount']);$pharDisable='';*/
			if($oTpharmacyPaidData['0'][0]['paid_amount']){
				$oTpharmacyAdv=($oTpharmacyPaidData['0'][0]['paid_amount']-$pharmacyReturnPaid['otpharmacy']['0']['total']);//-$otpharDiscount);
			}else{
				$oTpharmacyAdv=0;
			}
			$otpharDiscount=($oTpharmacyPaidData['0'][0]['discount']-$oTpharmacyReturnData['0']['0']['total_discount']);
			$oTpharDisable='';$class='';$divClass='';
						if(($oTpharmacyAdv+$otpharDiscount) >= ($oTpharCost)){ //if partially paid from pharmacy then remaing balance should be able to pay
							$oTpharDisable="disabled";
							$class='chk_parent_paid';
							$divClass='paid_payment';
						}else{
							$class='chk_parent';						
						}
						$srNo++;?>
				<div>
					<div align="center" class="<?php echo "tdBorder";?>" style="float: left;">
						<?php echo $this->Form->input("Billing.OtPharmacy.".$serviceKey.".valChk",array('type'=>'checkbox','id'=>'otpharmacy_'.$otPharmacyKey,'class'=>"$class service_".$otPharmacyKey,'value'=>$oTpharCost-$oTpharmacyAdv-$otpharDiscount,'label'=>false));?>
					</div>
					<div class="<?php echo "prntDiv1 tdBorderRt $divClass";?>" >
						<?php echo $serviceCategoryName[$serviceKey]; //OtPharmacy Charges ?>
						<?php $v++;
						echo '&nbsp;'.$this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][editAmt]",'id'=>'otphar_'.$serviceKey,'class'=>'textAmt','value' =>$oTpharCost,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][id]",'value' =>$otPharmacyKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][service_id]",'value' =>$otPharmacyKey,'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][name]",'value' => "OtPharmacy Charges",'legend'=>false,'label'=>false));
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][discount]",'class'=>'otpharmacy_discount_'.$otPharmacyKey,'value' => $otpharDiscount,'legend'=>false,'label'=>false));
						?>
					</div>
					<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
					<div align="center" class="<?php echo "prntDiv2 tdBorderRt $divClass";?>">&nbsp;</div>
					<?php }?>
					<div align="center" class="<?php echo "prntDiv3 tdBorderRt $divClass";?>" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
					<div align="center" valign="top" class="<?php echo "prntDiv4 tdBorderRt $divClass";?>">
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][rate]",'value' => $this->Number->format(($oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']/*-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
							echo $this->Number->format(round($oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']));
						?>
					</div>
					<div align="center" valign="top" class="<?php echo "prntDiv5 tdBorderRt $divClass";?>">
						<?php 	
							echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][unit]",'value' => '--','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
							echo '--';
						?>
					</div>

					<div align="center" valign="top" class="<?php echo "prntDiv6 tdBorderRt $divClass";?>">
						<?php 
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][amount]",'value' => $this->Number->format(($oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']/*-$oTpharmacyAdv-$pharmacyPaidAmount*/),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						//echo $this->Number->format(($oTpharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
						echo $this->Number->format(round($oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']/*-$pharmacyPaidAmount*/));
									//echo $this->Number->format($oTpharmacy_charges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>
					</div>
					<div align="center" valign="top" class="<?php echo "prntDiv7  $divClass";?>">
						<?php 
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][discount]",'class'=>'discount_parent_otpharmacy_'.$otPharmacyKey,'value' =>$otpharDiscount,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][discount]",'class'=>'pharmacy_otdiscount_'.$otPharmacyKey,'value' => $otpharDiscount,'legend'=>false,'label'=>false));
						echo round($otpharDiscount);
						?>
					</div>
					<div align="center" valign="top" class="<?php echo "prntDiv8  $divClass";?>">
						<?php 
						$otpharPaid=($oTpharmacyAdv);//-$otpharDiscount;
						if($otpharPaid<=0){
							echo '0';
							$otpharPaid=0;
						}else {
						echo round($otpharPaid);
						}
						echo $this->Form->hidden('',array('name'=>"data[Billing][OtPharmacy][$serviceKey][paid_amount]",'class'=>'paid_parent_otpharmacy_'.$otPharmacyKey,'value' => $this->Number->format(($pharPaid),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						
						?>
					</div>
				</div> <br>
				<ul>
					<!-- OtPharmacy data  -->
					<li>
						<!--id='pharmacy_'.$otPharmacyKey.'-'.$pharmacyId class='chk_child pharmacy_'.$otPharmacyKey-->
					</li>
					<!-- end OtPharmacy data  -->
				</ul>
			</li>
			<?php 
		   					}
		  			 	}?>
			<!-- End Of OT Pharmacy Charges -->

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
							$labDis+= $labCost['LaboratoryTestOrder']['discount'];
						}else{
							$lCost += $labCost['TariffAmount'][$nabhType] ;
							$labAdv += $labCost['LaboratoryTestOrder']['paid_amount'] ;
							$labDis+= $labCost['LaboratoryTestOrder']['discount'];
						}
						//$lCost += $labCost['TariffAmount'][$nabhType] ;

			          }
			          $labRCost=$lCost;
			          $lCost = $lCost - $labPaidAmount;$srNo++;
			          //}
			          ?>
			<li>
				<div>
					<div align="center" class="tdBorder" style="float: left;">
						<?php echo $this->Form->input('Billing.lab_charges',array('type'=>'checkbox','id'=>'laboratory_'.$laboratoryKey,'class'=>'chk_parent','value'=>$labRCost-$labAdv-$labDis));?>
					</div>
					<div class="tdBorderRt prntDiv1">
						<?php echo $serviceCategoryName[$serviceKey]; //Laboratory Charges?>
						<?php $v++;
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
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' => $this->Number->format($labRCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						echo round($labRCost);
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
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' => $this->Number->format($labRCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($labRCost);
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class="prntDiv7">
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][discount]",'class'=>'discount_parent_laboratory_'.$laboratoryKey,'value' => $labDis,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($labDis);
						?>
					</div>
					<div align="center" valign="top" class="prntDiv8">
						<?php $lPaid=round($labAdv);//-$labDis;
						if($lPaid<=0){
							echo '0';
							$lPaid=0;
						}else
						echo round($lPaid);
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][paid_amount]",'class'=>'paid_parent_laboratory_'.$laboratoryKey,'value' => $this->Number->format(($lPaid),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						
						?>
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
								$radDis+= $radCost['RadiologyTestOrder']['discount'] ;
							}else{
								$rCost += $radCost['TariffAmount'][$nabhType] ;
								$radAdv += $radCost['RadiologyTestOrder']['paid_amount'] ;
								$radDis+= $radCost['RadiologyTestOrder']['discount'] ;
							}
							//$rCost += $labCost['TariffAmount'][$nabhType] ;
          				}
          				//$rCost = $rCost - $radPaidAmount;
          				$srNo++;
          				echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][name]",'value' => "Radiology Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
          				?>
			<li>
				<div>
					<div align="center" class="tdBorder" style="float: left;">
						<?php echo $this->Form->input('Billing.rad_charge',array('type'=>'checkbox','id'=>'radiology_'.$radiologyKey,'class'=>'chk_parent','value'=>$rCost-$radAdv-$radDis));?>
					</div>
					<div class="tdBorderRt prntDiv1">
						<?php echo $serviceCategoryName[$serviceKey]; //Radiology Charges ?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][name]",'value' => "Radiology Charges",'legend'=>false,'label'=>false));?>
					</div>
					<?php if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only?>
					<div align="center" class="tdBorderRt prntDiv2">&nbsp;</div>
					<?php }?>
					<div align="center" class="tdBorderRt prntDiv3" style="<?php echo $hideCGHSCol ;?>">&nbsp;</div>
					<div align="center" valign="top" class="tdBorderRt prntDiv4">
						<?php 		
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' => $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						echo round($rCost);
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
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' => $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($rCost);
						//echo $rCost;
						?>
					</div>
					<div align="center" valign="top" class="prntDiv7">
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][discount]",'class'=>'discount_parent_radiology_'.$radiologyKey,'value' => $radDis,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($radDis);
						//echo $rCost;
						?>
					</div>
					<div align="center" valign="top" class="prntDiv8">
						<?php $rPaid=round($radAdv);
						if($rPaid<=0){
							echo '0';
							$rPaid=0;
						}else
						echo ($rPaid);
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][paid_amount]",'class'=>'paid_parent_radiology_'.$radiologyKey,'value' => $rPaid,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						
						?>
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
						   $category!=Configure::read('OtPharmacy') &&
						   $category!=Configure::read('Consultant') &&
						   $category!=Configure::read('surgeryservices')){
				    	    $servicekey =$serviceKey;
				    	    $name=explode(' ',$category);
				    	    $dynamicCnt = 0; ${
								$name[0].'charge'}=0;$serviceAdv=0;$serviceDis=0;
								foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){
									if($nursingServicesCost['ServiceBill']['service_id']==$servicekey) {
										${$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['service_bill_id'] = $nursingServicesCost['ServiceBill']['id'];
										${$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['name'] = $nursingServicesCost['TariffList']['name'] ;
										${$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['cost'] = $nursingServicesCost['ServiceBill']['amount'];
										${$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['qty'] = $nursingServicesCost['ServiceBill']['no_of_times'];
										${$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['paid_amount'] =$nursingServicesCost['ServiceBill']['paid_amount'];
										${$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
										${$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code'];
										${$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['tariff_list_id'] = $nursingServicesCost['TariffList']['id'];
										${$name[0].'NursingServices'}[$nursingServicesCost['ServiceBill']['id']]['discount'] = $nursingServicesCost['ServiceBill']['discount'];
										${$name[0].'charge'}=${$name[0].'charge'}+($nursingServicesCost['ServiceBill']['no_of_times']*$nursingServicesCost['ServiceBill']['amount']);
										$serviceAdv=$serviceAdv+$nursingServicesCost['ServiceBill']['paid_amount'];
										$serviceDis=$serviceDis+$nursingServicesCost['ServiceBill']['discount'];
										


										
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
										$serviceAdv=$serviceAdv+$nursingServicesCost['ServiceBill']['paid_amount'];
										$serviceDis=$serviceDis+$nursingServicesCost['ServiceBill']['discount'];
										$service[$name[0]]=$serviceAdv;
										$dynamicCnt++;$adi++;*/
										//debug(${$name[0].'NursingServices'});
			    					}
			    					
			    					
		    					}
		    					//debug(${$name[0].'NursingServices'});
		    					
		    		if(!empty(${$name[0].'charge'}) || ${$name[0].'charge'}!=0){
		    		$totalCost=$totalCost+${$name[0].'charge'};
					?>
			<li>
				<div>
					<div align="center" class="tdBorder" style="float: left;">
						<?php echo $this->Form->input('Billing.'.$name[0].'_charges',array('type'=>'checkbox','id'=>$name[0].'_'.$servicekey,'class'=>'chk_parent','value'=>${$name[0].'charge'}-$serviceAdv-$serviceDis));?>
					</div>
					<div class="tdBorderRt prntDiv1">
						<?php //padding: 0px 108px 0px 0px;?>
						<?php  echo $serviceCategoryName[$serviceKey]; //dynamic services
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
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' => 
															${$name[0].'charge'},'legend'=>false,'label'=>false,
															'id' => 'clinical_rate','style'=>'text-align:right;'));
						echo ${$name[0].'charge'};
						//echo $lCost ;
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
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' => 
								${$name[0].'charge'},
								'legend'=>false,'label'=>false,'style'=>'text-align:right'));
							echo ${$name[0].'charge'};
								//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class=" prntDiv7">
						<?php // padding: 0px 53px 0px 10px;?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][discount]",'class'=>'discount_parent_'.$name[0].'_'.$servicekey,'value' => $serviceDis,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo round($serviceDis);
						//echo $this->Number->format($lCost) ;
						?>
					</div>
					<div align="center" valign="top" class=" prntDiv8">
						<?php // padding: 0px 53px 0px 10px;?>
						<?php $serPaid=round($serviceAdv);
						if($serPaid<=0){
							echo '0';
							$serPaid=0;
						}else
						 echo round($serPaid);
						 echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][paid_amount]",'class'=>'paid_parent_'.$name[0].'_'.$servicekey,'value' => $serPaid,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						
						?>
					</div>
				</div> <br>
				<ul>
					<?php //echo '<pre>';
						//print_r(${$name[0].'NursingServices'});exit;
						$servicesArray=${$name[0].'NursingServices'};
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
						echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][rate]",'value' => $otherServicesCharges,'legend'=>false,'label'=>false,'id' => 'other_rate','style'=>'text-align:right;'));
						echo $otherServicesCharges;
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
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$serviceKey][amount]",'value' => $otherServicesCharges,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
						echo $otherServicesCharges;
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
					$totalCost = $totalCost+$totalServiceCharge+$labRCost+$rCost+$totalSurgeryCost+$totalMandatoryServiceCharge+$wardCharges+$totalCostConsultant+$pharmacy_charges+$oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']-$pharmacyreturnData[0][0]['total'];
					$totalAdvance=$consultPaid+$surgeryAdv+$mandatoryAdv+$labAdv+$radAdv+$totalServiceAdv+$pharmacyAdv+$oTpharmacyAdv;
				}else{
					$totalCost = $totalCost+$totalServiceCharge+$labRCost+$rCost+$totalSurgeryCost+$totalMandatoryServiceCharge+$wardCharges+$totalCostConsultant+$oTpharmacyPaidData['0'][0]['total']-$oTpharmacyReturnData['0']['0']['total']/*+$pharmacy_charges*/;
					$totalAdvance=$consultPaid+$surgeryAdv+$mandatoryAdv+$labAdv+$radAdv+$totalServiceAdv+$oTpharmacyAdv/*+$pharmacyAdv*/;
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
					<div align="center" valign="top" class="tdBorderRt prntDiv8"></div>
				</div>
			</li>
		</ul>
		<br>
		<!-- EOF Main ul -->
	</div>
	<!-- EOF tree div -->
	
	
	<!-- Billing Section Starts  Pooja-->
	<div style="float: right; width: 300; vertical-align: top;">
		<div style="clear: both; width:100% ;">
			<table width="100%" cellspacing='0' cellpadding='0'>
				<tr class="row_gray">
					<td style="padding: 0px 0px 0px 2px; height: 30px"><b>Total Bill</b></td>
					<td style=" padding: 0px 0px 0px 2px; text-align: right; font-size: 18px ;">
							<?php //$totalCost=round($totalCost);
							 echo "<font style='font-weight: bold; font-size: 18px' >".round($totalCost)."</font>";
								  echo $this->Form->hidden('Billing.total_amount',
											array('value' => $totalCost,'legend'=>false,'label'=>false,'id'=>'totalamount'));
							?>
					</td>
					</tr>
					<tr>
					<td style="padding: 0px 0px 0px 2px; height: 30px"><b>Total Discount</b></td>
					<td style="text-align: right; font-size: 18px ;"><?php if(!empty($billDetail['0']['0']['discount'])){
								$discountAmount=($billDetail['0']['0']['discount']-$oTpharmacyReturnData['0']['0']['total_discount']-$pharmacyreturnData['0']['0']['total_discount']);
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
						<td style="text-align: right; font-size: 18px ;">
						<?php //if($discountData['FinalBilling']['refund']=='1'){
	                        if(!empty($billDetail['0']['0']['refund'])){
								$balance=$balance+$billDetail['0']['0']['refund'];
								echo round($billDetail['0']['0']['refund']);
							}else{
								echo '0';
							}
							?>
						</td>
					</tr>
					<tr>
					<td style="padding: 0px 0px 0px 2px; height: 30px"><b>Total Paid</b></td>
					<td style="text-align: right; font-size: 18px ;">
						<?php 	if(!empty($billDetail['0']['0']['amount'])|| !empty($advanceAmount[0]['advance'])){
								$paidBill=($billDetail['0']['0']['amount']+$advanceAmount[0]['advance']-$billDetail['0']['0']['refund']);
								if($paidBill<0){
									$paidBill=0;
								}
						}else{
							$paidBill=0;
						}
						echo round($paidBill);
								echo $this->Form->hidden('Billing.amount_paid',array('value' => $paidBill,'legend'=>false,'label'=>false));
						
						
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
								echo "<font style='font-weight: bold;' >".($balance-$advanceAmount['0']['paidAdvance']/*$totalCost-$totalAdvance-$discountAmount+$totalRefund*/)."</font>";
								echo $this->Form->hidden('Billing.amount_pending',array('value' => ($balance-$advanceAmount['0']['paidAdvance']/*$totalCost-$totalAdvance-$discountAmount+$totalRefund*/),'id'=>'balanceAmount','legend'=>false,'label'=>false));
							?>	
					</td>
					</tr>-->
					<tr class="row_gray">
					<td style="padding: 0px 0px 0px 2px; height: 30px"> <b>Selected service cost</b></td>
					<td style="padding: 10px 0px 5px 0px; text-align: right">
							<span style="font-weight: bold; font-size: 18px ; color : #C00000" id="selectedChks"  class="checkedValue"></span>
							<input type="hidden" class="checkedValue" name="TotalPayBill" readonly="readonly">
					</td>
					</tr>
					<tr>
						<td style="padding: 0px 0px 0px 2px; height: 30px"> <b>Balance In Card</b></td>
						<td style="padding: 10px 0px 5px 0px; text-align: right; font-weight: bold; font-size: 18px ;">
						<?php echo !empty($patientCard['Account']['card_balance'])?$patientCard['Account']['card_balance']:'0';?></td>
					</tr>
					<!--<tr>
					<td style="padding: 0px 0px 0px 2px; height: 30px"> <b>Advance Amount</b></td>
					<td style="padding: 10px 0px 5px 0px">
							<?php 
							echo $advanceAmount['0']['advance']-$advanceAmount['0']['paidAdvance'];?>
					</td>
					</tr>-->
					<tr class="row_gray">
					<td style="padding: 0px 0px 0px 2px; height: 30px"><b>Selected service payable</b></td>
					<td style="text-align: right; font-size: 18px ;"><?php 
					if($this->Session->read('website.instance')=='hope'){
						echo $this->Form->input('Billing.changeAmt',array('id'=>'actAmount',
											'style'=>'font-weight: bold; font-size: 20px; color: green; width:65%'));
					}else{
						echo '<span style="text-align: right; font-weight: bold; font-size: 20px; color: green;" id="actAmountSpan"></span>';
						echo $this->Form->hidden('Billing.changeAmt',array('id'=>'actAmount','readonly'=>'readonly',
								'style'=>'font-weight: bold; font-size: 20px; color: green; width:65%'));
					}
					//"<font style='font-weight: bold; font-size: 30px' color='green'   id= 'actAmount'></font>";
									/*if($advanceAmount[0]['advance'])
										$advAmt=$advanceAmount[0]['advance'];*/
							echo $this->Form->hidden('Billing.advance_used',array('id'=>'advance_balance'));
							echo $this->Form->hidden('Billing.advance_not_used',array('id'=>'advance_not_used_balance'));?>
					</td>
					</tr>
					
					
			</table>
		</div>
</div> <!-- EOF selection and billing html -->
		<div style="clear: both; width:100%; ">
			<table>
				<tr>
					<?php
					 if($this->Session->read('website.instance')!='kanpur'){?>
					<td style=" padding: 0px 0px 0px 2px;">
						<?php echo 'Move From Card'.$this->Form->input('Billing.is_card',array('type'=>'checkbox',
								'div'=>false,'label'=>false,'id'=>'card_pay'));?><br>
								<span><b>Balance In Card : <font  color="green">
								<?php echo !empty($patientCard['Account']['card_balance'])?$patientCard['Account']['card_balance']:'0';?>
								</font></b></span></td>
						<?php }else{
								echo '<td>&nbsp;</td>';
						}?>
					<td>
						<?php if(strtolower($corporateEmp) != 'private'){
							$value='Credit';
						}else{
							$value='Cash';
						}
						$options=array('Bank Deposit'=>'Bank Deposit','Cash'=>'Cash','Cheque'=>'Cheque','Debit Card'=>'Debit Card','Credit Card'=>'Credit Card','Credit'=>'Credit','NEFT'=>'NEFT');
				  				echo 'Payment Mode <span id="mandatoryModeOfPayment"><font color="red">*</font></span><br> '.$this->Form->input('Billing.payment_mode', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:150px;',
	   								'div' => false,'label' => false,/*'empty'=>__('Please select'),*/'autocomplete'=>'off','default'=>'Cash','style'=>'float: none; width: 133px;',
	   								'options'=>$options,'value'=>$value,
	    							'id' => 'mode_of_payment'));
							  echo "<b style='padding: 0px 0px 0px 10px; '>Pay By Other Mode : <font color='red'><span id='otherPay'>$payOtherMode</span></font></b>";
						 ?>
					</td>
				</tr>
				
				<!--<?php if($patient['Patient']['admission_type']=='OPD'){?>
				<tr><td><?php echo 'Pay Later'.$this->Form->input('Billing.pay_later',array('type'=>'checkbox',
								'div'=>false,'label'=>false,'id'=>'pay_later'));?></td>
					<td>
	    				<?php echo $this->Form->input('Billing.pay_later_auth_id',array('empty'=>__('Please select'),'options'=>$authPerson,'style'=>"display:none;",'class'=>'validate[required,custom[mandatory-select]]',
				    		'legend'=>false,'label'=>false,'id' => 'pay_later_auth_by'));
	    				//echo $this->Form->input('Billing.pay_later_auth_id', array('class' => 'validate[required,custom[mandatory-select]]','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Please select',$authPerson),'id' => 'pay_later_auth_by','style'=>"display:none;",'readonly'=>false)); ?>
	    			</td></tr>
				<?php }?>-->
			</table>
			<table id="paymentInfo" style="display:none">
				<tr>
				    <td>Bank Name<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.bank_name',array('empty'=>__('Please select'),'options'=>$bankData,'class'=>'validate[required,custom[mandatory-select]]',
				    		'legend'=>false,'label'=>false,'id' => 'BN_paymentInfo'));?></td>
				    <td>Account No.<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.account_number',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_paymentInfo'));?></td>
				</tr>				
				<tr>
				    <td ><span id="chequeCredit"></span><font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.check_credit_card_number',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?></td>
			    	<td>Date<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.cheque_date',array('type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]','id' => 'cheque_date'));?></td>
				</tr>
		    </table>
		    <table id="neft-area" style="display:none;">
		    	<tr>
				    <td >Bank Name<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.bank_name_neft',array('empty'=>__('Please select'),'options'=>$bankData,'class'=>'validate[required,custom[mandatory-select]]',
				    		'legend'=>false,'label'=>false,'id' => 'BN_neftArea'));?></td>
					<td>Account No.<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.account_number_neft',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'AN_neftArea'));?></td>
				</tr> 
			    <tr>
				    <td>NEFT No.<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.neft_number',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number'));?></td>
					<td>NEFT Date<font color="red">*</font></td>
				    <td><?php echo $this->Form->input('Billing.neft_date',array('class'=>'validate[required,custom[mandatory-enter]]','type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd','id' => 'neft_date'));?></td>
				</tr>
		    </table>
		    <table id="creditDaysInfo" style="display:none">
		    	<tr>
		    	<?php if($this->Session->read('website.instance')=='vadodara'){?>	    	
					<td height="35" class="tdLabel2" style=" padding: 0px 0px 0px 2px;">Credit Period(in days)</td>
					<td> <?php echo $this->Form->input('Billing.credit_period',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'credit_period',));?>
					</td>
					<?php }else{?>
						<td height="35" class="tdLabel2" style=" padding: 0px 0px 0px 2px;">Credit Period<font color="red">*</font>(in days)</td>
					<td> <?php echo $this->Form->input('Billing.credit_period',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'credit_period','class'=> 'validate[required,custom[mandatory-enter-only]]'));?>
					</td>
					<?php }?>			
				</tr>
   		    </table>
   		    <table id="bankDeposite" style="display:none">
		    	<tr>
					<td height="35" class="tdLabel2">Bank Name<font color="red">*</font></td>
					<td><?php echo $this->Form->input('Billing.bank_deposite',array('empty'=>__('Please select'),'options'=>$bankData,'legend'=>false,'label'=>false,'id' => 'bank_deposite',
					    		'class'=> 'validate[required,custom[mandatory-select]]'));?>
					</td>
   				</tr>
   		    </table>
   		    <table  id="patientCard" style="display:none">
   		    	<tr>
					<td style=" padding: 0px 0px 0px 2px;">
					  	<?php 
					  	if(empty($patientCard['Account']['card_balance'])){
					  		$payFromCard='0';
					  	}
					  	if($patientCard['Account']['card_balance']>=$totalCost){
					  		$payFromCard=$totalCost;
					  	}elseif($patientCard['Account']['card_balance']<=$totalCost){
							$payFromCard=$patientCard['Account']['card_balance'];
						}
						$payOtherMode=$totalCost-$payFromCard;
					  	echo 'Amount To Deduct From Card  '.$this->Form->input('Billing.patient_card',array('type'=>'text','legend'=>false,'label'=>false,'value'=>$payFromCard,'id' => 'patient_card'));?></td>
				   <td ><?php echo "<b>Pay By Other Mode : <font color='red'><span id='otherPay'>$payOtherMode</span></font></b>";?></td>
				</tr>   		    
   		    </table>
	    	    
		</div>
		
	<div style="clear: both; width:100%; ">
	
		<table  id="partialDiscountRow" width="100%">
		
			<tr>			   
			   <td colspan="7">
			        <div style="width: 100%">
			        <?php 
			        if($this->Session->read('website.instance')!='vadodara' || $this->params->query['corporate']){?>
			        <!--<div style="width: 53% ; float: left" id='disRow'>
			        <div style="float: left; width:17%;  padding: 0px 0px 0px 2px;" ><?php $discount=array('Amount'=>'Amount','Percentage'=>'Percentage');
						echo '<b>Discount </b><br>' .$this->Form->input('Billing.discount_type', array('id' =>'discountType','options' => $discount,
							'autocomplete'=>'off','readonly'=>false,'legend' =>false,'label' => false,'div'=>false,'class'=>'discountType',
							'type' => 'radio','separator'=>'</br>','disabled'=>false));
						echo $this->Form->hidden('Billing.discount_type',array('id'=>'typeDiscount','value'=>''));
						echo $this->Form->hidden('Billing.maintainDiscount',array('id'=>'maintainDiscount','value'=>''));
						?>
					</div>
					<div style="float: right; width:80%">
						<table>
						   		<tr>
				    			<td> 
				    				<?php
								          echo $this->Form->input('Billing.is_discount',array('type'=>'text','legend'=>false,'label'=>false,
												'id' => 'discount','autocomplete'=>'off','style'=>'text-align:right; display:none;',
												'value'=>$discountAmount,'readonly'=>false,'class' => 'validate[optional,custom[onlyNumber]]'));
								          echo $this->Form->hidden('Billing.discount',array('id'=>'disc', 'value'=>''));
								    ?>
								   	<span id="show_percentage" style="display:none">%</span>
								   	<br><?php echo '<span id=inAmt style="display:none">Amt</span><span id=inPer style="display:none">In per(%)</span>'.'&nbsp; <span id="calDis"></span>';//.$this->Form->hidden('Billing.calDis',array('id'=>'calDis','style'=>'display:none', 'disabled'=>true));
					    					 echo $this->Form->hidden('Billing.discount_per',array('id'=>"calPer"));?>
				    			</td>
				    			<td>
				    				<?php echo $this->Form->input('Billing.discount_by', array('class' => ' textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Please select',$authPerson),'id' => 'discount_authorize_by','style'=>"display:none;",'readonly'=>false)); ?>
				    			</td>
				    			<td style="padding:0px;">
			               			<?php $disountReason = array('VIP'=>'VIP','Poor and needy'=>'Poor and needy','Hospital staff'=>'Hospital staff','Waiver'=>'Waiver','Others'=>'Others');
			                 		echo $this->Form->input('Billing.discountReason', array('class' => ' textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Select Reason',$disountReason),'id' => 'discount_reason','style'=>"display:none; width:105px;")); ?>
			                 	</td>
				    		</tr>
				    		<tr>
				    			<td colspan="3">
				                 	<?php 
										echo $this->Html->link(__('Send request for discount'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send-approval',"style"=>"display:none;"));
										echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-approval',"style"=>"display:none;"));
										echo $this->Form->hidden('Billing.is_approved',array('value'=>0,'id'=>'is_approved'));
				                 	?>
			                 	</td>
				    		</tr>
				    		
				    		<tr>
					        <td valign="top" align="left" style="padding-top: 15px;" colspan="2">&nbsp;
					        	<div style="float: left; margin-top: 3px;">
									   <i id="mesage" style="display:none;">
									   	(<font color="red">Note: </font> <span id="status-approved-message"></span> )  
									   		<span class="gif" id="image-gif" style="float: right; margin: -3px 0px 0px 7px;"> </span>
									   	</i>
								  </div> 
							</td>
					     </tr>
				    	</table>
				     </div>
			    </div>	-->
			    <?php }?>
			    	    	
			    <div style="width: 46%; float: left;">
			    <?php if($this->Session->read('website.instance')!='vadodara'){?>	
			   		<div style="float: left; width:30%" ><?php echo '<b>Refund</b>'.$this->Form->input('Billing.refund',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'is_refund'));
			    		  echo $this->Form->hidden('Billing.hrefund',array('id'=>'hrefund','value'=>''));
			    		  echo $this->Form->hidden('Billing.maintainRefund',array('id'=>'maintainRefund','value'=>''));
			    	?>
			    	Yes/No</div>
			    	<?php }?>
			   		<div style="float: right; width:70%" >
				   		<table>
				    		<tr>
				    			<td>
							    	<?php if($this->Session->read('website.instance')=='kanpur'){
							    			echo $this->Form->input('Billing.refund_to_patient',array('type'=>'text','id'=>'refund_amount','readonly'=>'readonly','style'=>"display:none;"));
							    		}else if($this->Session->read('website.instance')=='hope'){
											echo $this->Form->input('Billing.refund_to_patient',array('type'=>'text','id'=>'refund_amount','style'=>"display:none; "));
										}
							    	echo $this->Form->input('Billing.paid_to_patient',array('type'=>'text','id'=>'refund_paid', 'style'=>'display:none' ));?>
							    </td>
							    <td>
							    	<?php echo $this->Form->input('Billing.refund_authorize_by', array('class' => 'textBoxExpnd','style'=>'width:100px;','autocomplete'=>'off','div' => false,'label' => false,'type'=>'select','options'=>array('empty'=>'Please select',$authPerson),'id' => 'discount_authorize_by_for_refund','style'=>"display:none;"));?>
						        </td>
						    </tr>
				    		<tr>
							    <td colspan="2">
							    	<?php 
							    		echo $this->Html->link(__('Send request for Refund'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'send-approval-for-refund',"style"=>"display:none;"));
						                echo $this->Html->link(__('Cancel Request'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'cancel-refund-approval',"style"=>"display:none;"));
						                echo $this->Form->hidden('Billing.is_refund_approved',array('value'=>0,'id'=>'is_refund_approved'));
						             ?>
							    </td>
				   			 </tr>
				   			 <tr>
					        <td valign="top" align="left" style="padding-top: 15px;" colspan="2">&nbsp;
					        	<div style="float: left; margin-top: 3px;">
									   <i id="mesage2" style="display:none;">
									   	(<font color="red">Note: </font> <span id="status-approved-message-for-refund"></span> )  
									   		<span class="gif" id="image-gif2" style="float: right; margin: -3px 0px 0px 7px;"> </span>
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
	<div style="clear: both; width:100%; ">
		<table>
			<tr>
				<?php if($patient['Patient']['admission_type']=='IPD'){?>			
				<td height="30" class="tdLabel2" >
					<?php if($patient['Patient']['is_discharge']==1)
							 $readOnly1 = 'disabled';else $readOnly1 = '';
							 $reason =isset($finalBillingData['FinalBilling']['reason_of_discharge'])?$finalBillingData['FinalBilling']['reason_of_discharge']:'';
							 echo '<strong style="float:left; padding: 0 15px 0 2px;">Reason Of Discharge<font color="red">*</font></strong> &nbsp;'.$this->Form->input('Billing.reason_of_discharge', array('value'=>$reason,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'empty'=>__('Please select'),
	   											 'options'=>array('Recovered'=>'Recovered','DischargeOnRequest'=>'Discharge On Request','DAMA'=>'DAMA','Death'=>'Death','Reffered to higher center'=>'Reffered to higher center'),'id' => 'mode_of_discharge','disabled'=>$readOnly1));
	   				?>
				</td>			
				<?php }?>
				<td class="tdLabel2">
		    		<?php $todayDate=date("d/m/Y H:i:s");
		    				echo '<strong style="float:left; padding: 0 53px 0 px;">Payment Date<font color="red">*</font></strong>'.$this->Form->input('Billing.date',array('readonly'=>'readonly',
								 'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd ','type'=>'text','style'=>'width:50%','legend'=>false,'label'=>false,
								 'id' => 'discharge_date','autocomplete'=>'off','value'=>$todayDate));?>
		    	</td>
			</tr>
			<tr >
				<td id="reasonForBalance" style="display:none;" height="30" class="tdLabel2"><?php echo '<strong style="float:left; padding: 0 15px 0 0;">Reason For Balance<font color="red">*</font></strong>'.$this->Form->input('Billing.reason_of_balance', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'empty'=>__('Please select'),
									'options'=>array('Insufficient Money'=>'Insufficient Money','No Money'=>'No Money','Poor'=>'Poor','Credit Period'=>'Credit Period'),'id' => 'reason_of_balance'));  ?>
		    	</td>
				<td height="30" class="tdLabel2 guarant" style="display: none" colspan="2">
				<?php echo '<strong style="float:left; padding: 0 15px 0 0;">Guarantor<span id="mandatoryGuarantor" style="display: none"><font color="red">*</font>	</span></strong>'.$this->Form->input('Billing.guarantor',
						 array('class' =>'textBoxExpnd','style'=>'width:141px;','div' => false,'label' => false,'empty'=>__('Please select'),
									'options'=>$guarantor,'id' => 'guarantor'));?>
				</td>
		  </tr>
		  <tr>
				<td height="30" style="vertical-align: top;" colspan="2" class="tdLabel2 paymentRemarkReceived"><?php echo '<span style="vertical-align: top; padding: 0 17px 0 82px;">Remark</span>  ';echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,
	      		     'id' => 'receivedRemark','cols'=>'45','rows'=>'3','value'=>'Being cash received towards  from pt. '.$patient['Patient']['lookup_name'].' against R. No.:'));
	      		 ?></td>
	      		 <td  class="paymentRemarkRefund" style="display: none"><?php echo '<span style="vertical-align: top; padding: 0 17px 0 82px;">Remark</span>  ';echo $this->Form->textarea('Billing.remark',array('legend'=>false,'label'=>false,
	      		       'id' => 'refundRemark','cols'=>'20','disabled'=>'disabled','rows'=>'5','value'=>'Being cash refunded towards  from pt. '.$patient['Patient']['lookup_name'].' against R. No.:'));  ?></td>	 
		 </tr>
		</table>
	</div>
	
	<div><?php 
	if(strtolower($corporateEmp) != 'private'){
		echo $this->Form->submit('Transfer To Company',array('id'=>'submit','class'=>'blueBtn','div'=>false,'label'=>false));
	}else{
		echo $this->Form->submit('Make Payment',array('id'=>'submit','class'=>'blueBtn','div'=>false,'label'=>false));
	}
	echo $this->Html->link('Reset','javascript:void(0);',
					array('class'=> 'blueBtn','id'=>'resetAll','escape' => false,'label'=>false,'div'=>false));
  			   echo $this->Form->end();?></div>
	</div>

	<!-- EOF Billing Section -->

</div>
<script>

var instance="<?php echo $configInstance;?>";  //by swapnil
var interval = "";
var refund_interval = "";

$(document).ready(function(){

 


//$('#patient_card').val('');
$('#discountType').val('');
$('#typeDiscount').val('');
$('#maintainDiscount').val('');
$('#disc').val('');
//$('#discount').val('');
$('#discount_authorize_by').val('');
$('#hrefund').val('');
$('#maintainRefund').val('');
$('#refund_amount').val('');
$("#refund_paid").val('');
$('#discount_authorize_by_for_refund').val('');
$('#credit_period').val('');
$('#bank_deposite').val('');
$('#BN_paymentInfo').val('');
$('#AN_paymentInfo').val('');
$('#card_check_number').val('');
$('#cheque_date').val('');
$('#BN_neftArea').val('');
$('#AN_neftArea').val('');
$('#neft_number').val('');
$('#neft_date').val('');
<?php if(strtolower($corporateEmp) != 'private'){?>
	$('#card_pay').attr('checked', false);
<?php }else {?>
	$('#card_pay').attr('checked', true);
<?php }?>

discountApproval();	//check any previous approval for discount for finalBill only
RefundApproval();	//check any previous approval for refund for finalBill only

	 /*var validatePerson = jQuery("#billingsFullPaymentForm").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}*/
		var defaultVal=0;var totalChk=0;
		<?php if(strtolower($corporateEmp) != 'private'){?>
		 $('.select_all').attr('checked', false);
		 $('.chk_parent').attr('checked', false);
		 $('.chk_child').attr('checked', false);
		 $('.chk_child_paid').attr('checked', true);
		 $('.chk_parent_paid').attr('checked', true);
		 $('.chk_parent_paid').attr('disabled', true);
		 $('.chk_child_mandatory').attr('checked', false);
		 $('.chk_child_doc').attr('checked', false); 
		 $('.chk_parent').parent('div').siblings().addClass('pending_payment');
		 $('.chk_parent_paid').parent('div').siblings().removeClass('pending_payment');
	     $('.chk_parent_paid').parent('div').siblings().addClass('paid_payment');

	     $(".chk_parent").each(function (){
	 		var count=0; 
	 		  checkId=this.id;
	 		  selectedParent =checkId.split('_')[1] ;	 	        
	 	        	  $('.service_'+selectedParent).each(function () {
	 	        		 if(!$(this).is(':disabled')){
	 	        			totalChk++;
	 	        			count++;
	 	        		 } 
	 		            	/*if(!$(this).is(':disabled') && $(this).is(':checked')){
	 		            		totalChk++;
	 			            	count++;
	 			            	serCost=parseFloat($(this).val());
	 		 		            	if(serCost==1)
	 	 	 		 		            serCost=0;
	 		 		            	defaultVal =defaultVal+parseFloat(serCost);
	 			            			   
	 		      		  	}*/		      		  		
	 			     	});
	 			     	if(parseFloat(count)===0){
		 			     	
	 				     	$(this).removeClass('chk_parent');
	 				     	$(this).addClass('chk_parent_paid');
	 				     	$(this).parent('div').siblings().removeClass('pending_payment');
	 				     	$(this).parent('div').siblings().addClass('paid_payment');				     	
	 			     		$(this).attr('disabled',true);
	 			     		$(this).prop('checked',true);
	 			     	}else{
	 			     		$(this).parent('div').siblings().addClass('pending_payment');
	 				     	$(this).parent('div').siblings().removeClass('paid_payment');
	 				     	$(this).attr('disabled',false);
	 			     	}
	 					
	 					if(totalChk=='0'){
	 			     		$('#disRow').hide();
	 			     	}else{
	 						$('#disRow').show();
	 					}

	 					if(instance=='hope'){
	 						$('#disRow').show();
	 					}
	 	         
	 	 });
		
	<?php }else{?>
		 /*$('.select_all').attr('checked', true);
		 $('.chk_parent').attr('checked', true);
		 $('.chk_child').attr('checked', true);
		 $('.chk_child_paid').attr('checked', true);
		 $('.chk_parent_mandatory').attr('checked', true);
		 $('.chk_parent_paid').attr('checked', true);
		 $('.chk_parent_paid').attr('disabled', true);
		 $('.chk_child_mandatory').attr('checked', true);
		 $('.chk_child_doc').attr('checked', true); */
		 $('.select_all').attr('checked', false);
		 $('.chk_parent').attr('checked', false);
		 $('.chk_child').attr('checked', false);
		 $('.chk_child_paid').attr('checked', false);
		 $('.chk_parent_mandatory').attr('checked', false);
		 $('.chk_parent_paid').attr('checked', false);
		 $('.chk_parent_paid').attr('disabled', false);
		 $('.chk_child_mandatory').attr('checked', false);
		 $('.chk_child_doc').attr('checked', false);
	 
	$(".chk_parent:checked").each(function (){
		var count=0; 
		  checkId=this.id;
		  selectedParent =checkId.split('_')[1] ;
	         if($(this).is(':checked')){ 
	        	  $('.service_'+selectedParent).each(function () { 
		            	if(!$(this).is(':disabled') && $(this).is(':checked')){
		            		totalChk++;
			            	count++;
			            	serCost=parseFloat($(this).val());
		 		            	if(serCost==1)
	 	 		 		            serCost=0;
		 		            	defaultVal =defaultVal+parseFloat(serCost);
			            			   
		      		  	}		      		  		
			     	});
			     	
			     	if(parseFloat(count)===0){
				     	$(this).removeClass('chk_parent');
				     	$(this).addClass('chk_parent_paid');
				     	$(this).parent('div').siblings().removeClass('pending_payment');
				     	$(this).parent('div').siblings().addClass('paid_payment');				     	
			     		$(this).attr('disabled',true);
			     	}else{
			     		$(this).parent('div').siblings().addClass('pending_payment');
				     	$(this).parent('div').siblings().removeClass('paid_payment');
				     	$(this).attr('disabled',false);
			     	}
					
					if(totalChk=='0'){
			     		$('#disRow').hide();
			     	}else{
						$('#disRow').show();
					}

					if(instance=='hope'){
						$('#disRow').show();
					}
	         }
	 });
	 <?php }?>
	 <?php 
		if(strtolower($corporateEmp) != 'private'){?>
		/**Default select all displaying from billing table for paid amount, discount and refund**/
		// calBillingValue=Math.round(<?php //echo round($totalCost-($paidBill+$discountAmount));?>);
    	 $(".checkedValue").text(0);
         $(".checkedValue").val(0);
         <?php }else{?>
         	/**Default select all displaying from billing table for paid amount, discount and refund**/
         			 calBillingValue=<?php echo $totalCost-($paidBill+$discountAmount);?>;
         	         calBillingValue=Math.round(calBillingValue);
         	         $(".checkedValue").val(calBillingValue);        	         
        	    	 $(".checkedValue").text(calBillingValue);
		<?php }?>
		 checkBalance();


			/*  all calculations are done in checkBalance()-pooja 
		var paidAdvance="<?php echo $advanceAmount[0]['paidAdvance'];?>"
		var advance="<?php echo $advanceAmount[0]['advance'];?>";
		var diffAdvance='0';
		if(parseFloat(paidAdvance)<parseFloat(advance)){
			diffAdvance=parseFloat(advance)-parseFloat(paidAdvance);
		}
			var subAmt=parseFloat(defaultVal)-parseFloat(diffAdvance);
			if(subAmt<0)subAmt=0;
			$('#amtSpan').show();
			$('#actAmount').val(subAmt);
			$('#actAmountSpan').text(subAmt);
			$('#advance_balanced').val(diffAdvance);
			*/
		/*}else{			
			var subAmt=parseFloat(defaultVal);
			$('#amtSpan').show();
			$('#actAmount').text(subAmt);
			$('#advance_balance').val(subAmt);
		}*/

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

	 var screenHeight = $(window).height();
	 	if(screenHeight < 800 ) screenHeight  = 800 ;	
		var tableFull = $("#fullTbl").height();	
		var tableHead = $("#tblHead").height();
		var tableContent = $("#tblContent").height();
		var tableFooter = $("#tblFooter").height();
		//  alert(tableFull);
		if(screenHeight > tableFull)
		{
			var requireHt = screenHeight - (tableFull);
			$("#addColumnHt").css("height", (requireHt+130)+"px");
		}
		else
		{
			var division = tableFull / screenHeight;
			 
			if(division < 1.07)
			{				
				var requireHt = screenHeight - (tableFull);
				$("#addColumnHt").css("height", (requireHt+50)+"px");
			}
			else if(division > 1.07 && division < 2.36)// second page
			{
				var screenHeight = 842;
				var requireHt = (screenHeight*2) - tableFull;
				$("#addColumnHt").css("height", (requireHt+200)+"px");		
			}	
			else if(division > 2.36)// Third page
			{
				//alert(division);
				var screenHeight = 842;
				var requireHt = (screenHeight*3) - tableFull;
				$("#addColumnHt").css("height", (requireHt+430)+"px");
			}	
		}
 });

 function checkBalance(){ 
	 var configInstance="<?php echo $this->Session->read('website.instance')?>";
		if(parseFloat($("#balanceAmount").val()) > parseFloat($('.checkedValue').val())){
			$("#reasonForBalance").show();
		}else{
			$("#reasonForBalance").hide();
		}
		var subAmt=0;
		var selectedValue=$('.checkedValue').val();
		if(configInstance=='vadodara'){
			if($('#card_pay').is(':checked')){
				var cardAdv="<?php echo !empty($patientCard['Account']['card_balance'])?$patientCard['Account']['card_balance']:'0';?>";
				if(cardAdv!='0'){
					if(parseFloat(selectedValue)!='0'){
						if(parseFloat(selectedValue)< parseFloat(cardAdv)){							
							subAmt='0';
						}else{
							subAmt=parseFloat(selectedValue)-parseFloat(cardAdv);
						}
						if(subAmt<0)subAmt=0;
						subAmt=Math.round(subAmt);
						$('#actAmount').val(subAmt);
						$('#actAmount').attr('limit',subAmt);
						$('#actAmountSpan').text(subAmt);
						$('#otherPay').text(subAmt);
					}else{
						subAmt=parseFloat(Math.round(selectedValue));
						$('#amtSpan').show();
						subAmt=Math.round(subAmt);
						$('#actAmount').val(subAmt);
						$('#actAmount').attr('limit',subAmt);
						$('#actAmountSpan').text(subAmt);
						$('#otherPay').text(subAmt);
					}
				}else{
					$('#card_pay').attr('checked',false);
					//For corporate where card is not used Advance amount is used
					var notUsedAdvance='0';		
					var paidAdvance="<?php echo $advanceAmount[0]['paidAdvance'];?>"
						var advance="<?php echo $advanceAmount[0]['advance'];?>";
						var diffAdvance='0';
						if(parseFloat(paidAdvance) < parseFloat(advance)){
							diffAdvance=parseFloat(advance)-parseFloat(paidAdvance);
						}
					if(parseFloat(selectedValue)!='0'){
						if(parseFloat(selectedValue)< parseFloat(diffAdvance)){
							subAmt='0';
							notUsedAdvance=parseFloat(diffAdvance)-parseFloat(selectedValue);
							diffAdvance=parseFloat(selectedValue);
							
						}else{
							subAmt=parseFloat(selectedValue)-parseFloat(diffAdvance);
						}
						if(subAmt<0){
							subAmt=0;
						}
						$('#amtSpan').show();
						if(subAmt<0)subAmt=0;
						subAmt=Math.round(subAmt);
						$('#actAmount').val(subAmt);
						$('#actAmount').attr('limit',subAmt);
						$('#actAmountSpan').text(subAmt);
						$('#otherPay').text(subAmt);
						diffAdvance=Math.round(diffAdvance)
						$('#advance_balance').val(diffAdvance);
						notUsedAdvance=Math.round(notUsedAdvance)
						$('#advance_not_used_balance').val(notUsedAdvance);
					}else{	
						subAmt=parseFloat(Math.round(selectedValue));
						$('#amtSpan').show();
						subAmt=Math.round(subAmt);
						$('#actAmount').val(subAmt);
						$('#actAmount').attr('limit',subAmt);
						$('#actAmountSpan').text(subAmt);
						$('#otherPay').text(subAmt);
					}
				}
			}else{
				var notUsedAdvance='0';		
				var paidAdvance="<?php echo $advanceAmount[0]['paidAdvance'];?>"
					var advance="<?php echo $advanceAmount[0]['advance'];?>";
					var diffAdvance='0';
					if(parseFloat(paidAdvance) < parseFloat(advance)){
						diffAdvance=parseFloat(advance)-parseFloat(paidAdvance);
					}
				if(parseFloat(selectedValue)!='0'){
					if(parseFloat(selectedValue)< parseFloat(diffAdvance)){
						subAmt='0';
						notUsedAdvance=parseFloat(diffAdvance)-parseFloat(selectedValue);
						diffAdvance=parseFloat(selectedValue);
						
					}else{
						subAmt=parseFloat(selectedValue)-parseFloat(diffAdvance);
					}
					if(subAmt<0){
						subAmt=0;
					}
					$('#amtSpan').show();
					if(subAmt<0)subAmt=0;
					
					subAmt=Math.round(subAmt);
					$('#actAmount').val(subAmt);
					$('#actAmount').attr('limit',subAmt);
					$('#actAmountSpan').text(subAmt);
					$('#otherPay').text(subAmt);
					diffAdvance=Math.round(diffAdvance)
					$('#advance_balance').val(diffAdvance);
					notUsedAdvance=Math.round(notUsedAdvance);
					$('#advance_not_used_balance').val(notUsedAdvance);
				}else{
					subAmt=parseFloat(selectedValue);
					$('#amtSpan').show();
					subAmt=Math.round(subAmt);
					$('#actAmount').val(subAmt);
					$('#actAmount').attr('limit',subAmt);
					$('#actAmountSpan').text(subAmt);
					$('#otherPay').text(subAmt);
				}
			}

		}else{
			//For corporate where card is not used Advance amount is used
				var notUsedAdvance='0';		
				var paidAdvance="<?php echo $advanceAmount[0]['paidAdvance'];?>"
					var advance="<?php echo $advanceAmount[0]['advance'];?>";
					var diffAdvance='0';
					if(parseFloat(paidAdvance) < parseFloat(advance)){
						diffAdvance=parseFloat(advance)-parseFloat(paidAdvance);
					}
				if(parseFloat(selectedValue)!='0'){
					if(parseFloat(selectedValue)< parseFloat(diffAdvance)){
						subAmt='0';
						notUsedAdvance=parseFloat(diffAdvance)-parseFloat(selectedValue);
						diffAdvance=parseFloat(selectedValue);
						
					}else{
						subAmt=parseFloat(selectedValue)-parseFloat(diffAdvance);
					}
					if(subAmt<0){
						subAmt=0;
					}
					$('#amtSpan').show();
					if(subAmt<0)subAmt=0;
					subAmt=Math.round(subAmt);
					$('#actAmount').val(subAmt);
					$('#actAmount').attr('limit',subAmt);
					$('#actAmountSpan').text(subAmt);
					$('#otherPay').text(subAmt);
					diffAdvance=Math.round(diffAdvance)
					$('#advance_balance').val(diffAdvance);
					notUsedAdvance=Math.round(notUsedAdvance)
					$('#advance_not_used_balance').val(notUsedAdvance);
				}else{
				 	subAmt=parseFloat(selectedValue);
					$('#amtSpan').show();
					subAmt=Math.round(subAmt);
					$('#actAmount').val(subAmt);
					$('#actAmount').attr('limit',subAmt);
					$('#actAmountSpan').text(subAmt);
					$('#otherPay').text(subAmt);
					$('#advance_balance').val('0');
					diffAdvance=Math.round(diffAdvance)
					$('#advance_not_used_balance').val(diffAdvance);
				}
			}
		$('#actAmount').trigger('change');	
	}

 $('#select').click(function(event) {  //on click
	 if($('.discountType').is(':checked')){
    	 resetDiscountRefund();
    	 
         }
	 if($('#card_pay').is(':checked')){
		 $('#card_pay').trigger('click');
    	 
         }
	 var selectVal=0;
     if(this.checked) { // check select status
         $('.chk_parent').each(function() { //loop through each checkbox
             this.checked = true;  //select all checkboxes with class "chk_parent"
             selectedParent =$(this).attr('id').split('_')[1] ;
             
         	 $('.service_'+selectedParent).each(function () { 
	            	if(!$(this).is(':disabled')){
	            		serCost=parseFloat($(this).val());
	 		            	if(serCost==1)
 	 		 		            serCost=0;
	 		            	selectVal = parseFloat(selectVal)+parseFloat(serCost);	   
	      		  	}	            	
	            	
		     });	                              
         });

         //for mandatory charges such as doctor charges
         /*$('.chk_parent_paid').each(function(){
        	 this.checked = true;  //select all checkboxes with class "chk_parent"
             selectedParent =$(this).attr('id').split('_')[1] ;
	         	  $('.service_'+selectedParent).each(function () { 
	         		 if($(this).is(':disabled') && !$(this).is(':checked')){
	              		selectVal =selectVal+parseFloat($(this).val());		   
	        		  	}
		            	
			     	});	  
        	 
        });*/

        $('.chk_parent_paid').attr('checked',true);
        $('.chk_child_paid').attr('checked',true);
        
         var mandCharges=parseFloat($('.chk_parent_mandatory').val());
    	 if(!isNaN(mandCharges))
    		 selectVal=parseFloat(selectVal)+parseFloat(mandCharges);

    	 /**Default select all displaying from billing table for paid amount, discount and refund**/
    	 
    	<?php if(strtolower($corporateEmp) != 'private'){?>
	    	
	     	selectVal=Math.round(selectVal);	
	     	$(".checkedValue").val(selectVal);	
	     	$(".checkedValue").text(selectVal);		 
         <?php }else{?>
         calBillingValue=<?php echo $totalCost-($paidBill+$discountAmount);?>;         
         calBillingValue=Math.round(calBillingValue);
    	 $(".checkedValue").val(calBillingValue);
         $(".checkedValue").text(calBillingValue);
		<?php 	}?>
         checkBalance();

         $('.chk_child').each(function() { //loop through each checkbox
             this.checked = true;  //select all checkboxes with class "chk_child"
         });
         
     }else{
         $('.chk_parent').each(function() { //loop through each checkbox
             this.checked = false; //deselect all checkboxes with class "chk_parent"                             
         });
          
         $('.chk_child').each(function() { //loop through each checkbox
             this.checked = false;  //select all checkboxes with class "chk_child"
         });
         $('.chk_parent_paid').attr('checked',true);

         $('.chk_child_paid').attr('checked',true);

         /*$('.chk_parent_paid').each(function(){
        	 this.checked = true;  //select all checkboxes with class "chk_parent"
             selectedParent =$(this).attr('id').split('_')[1] ;
	         	  $('.service_'+selectedParent).each(function () { 
	         		 if($(this).is(':disabled') && !$(this).is(':checked')){
	         			serCost=parseFloat($(this).val());
	 		            	if(serCost==1)
	 		 		            serCost=0;
	 		            	selectVal = parseFloat(selectVal)+parseFloat(serCost);	   
	        		  }
		            	
				});
         });*/
		 /*$('.chk_parent').each(function(){
			 if($(this).hasClass('chk_parent_paid') && !$(this).is(':disabled')){
				 this.checked = false;
				 }        	 
             selectedParent =$(this).attr('id').split('_')[1] ;
	         	  $('.service_'+selectedParent).each(function () { 
	         		 if($(this).is(':disabled') && !$(this).is(':checked')){
	         			serCost=parseFloat($(this).val());
	 		            	if(serCost==1)
	 		 		            serCost=0;
	 		            	selectVal = parseFloat(selectVal)+parseFloat(serCost);		   
	        		  	}
		            	
				});
         });*/
		 /*var mandCharges=parseFloat($('.chk_parent_mandatory').val());
		 if(!isNaN(mandCharges))
		 	selectVal=parseFloat(selectVal)+parseFloat(mandCharges);*/
		 	selectVal=0;
		 $(".checkedValue").val(selectVal);
		 $(".checkedValue").text(selectVal);
         checkBalance();      
     }
 	});

 	$(document).ready(function(){
 		$('.chk_parent').bind('click', function(){   
 			var that = this; 	 
 	    	setTimeout(function(){
				 
 	 	    	if($('.discountType').is(':checked')){
 	 	       	 resetDiscountRefund();
 	 	       	 //resetRefund();
 	 	        }
 	 	   	 	if($('#card_pay').is(':checked')){
 	 	   		 	$('#card_pay').trigger('click');
 	 	       	}
 	 	   	 	var val=0;var calamt=0;
 	 	   	 	var phar=$(that).attr('id').split('_')[0];
 	 	        selectedParent = $(that).attr('id').split('_')[1] ;
 	 	        var selectVal='0'; 
 	 	        
 	 	        if(!$(that).is(':checked')){
 	 	        	$('#select').attr('checked', false); 	 	       		    	
 	 	        }
 	 	        
 	 	      $('.chk_parent').each(function() { //loop through each checkbox
	 	     		if(!$(this).is(':disabled') && $(this).is(':checked')){ 
	              	  selectedParent =$(this).attr('id').split('_')[1] ;
	 	         	  $('.service_'+selectedParent).each(function () { 
	 	         			if(!$(this).is(':disabled') && $(this).prop('checked')){
 		 		            	serCost=parseFloat($(this).val());
 		 		            	if(serCost==1)
 	 	 		 		            serCost=0;
 		 		            	selectVal = parseFloat(selectVal)+parseFloat(serCost);		   
	 		      		  	}	            	
	 			     	});	 
	 	     		}                             
	         	 });
			    $('.chk_child_paid').prop('checked',true);
			   	var mandCharges=parseFloat($('.chk_parent_mandatory').val());
			   	if(!isNaN(mandCharges))
					 	selectVal=parseFloat(selectVal)+parseFloat(mandCharges);
			   	selectVal=Math.round(selectVal);
			   	$(".checkedValue").val(selectVal);  
			   	$(".checkedValue").text(selectVal); 
			   	 checkBalance();
 	 	        
 	 	        }, 500);  
 	    	
 	     });
 	 });
 	
    

		 var finalArrayChk=[];var chk1Array=[];var checkedServices=[];
		 $('.chk_child').bind('click', function(){ 
			 if($('.discountType').is(':checked')){
		    	 resetDiscountRefund();
		    	 //resetRefund();
		     }
			 if($('#card_pay').is(':checked')){
				 $('#card_pay').trigger('click');
		    }
		    selectedChildName = $(this).attr('id').split("-");  
         	var val=0;
         	var countchk=0;
         	var countUnchk=0;
         	var checkChildStatus = 0 ;
         	var paymentTariffId=$(this).attr('id').split("_")[1];
         	var serviceTariffId=paymentTariffId.split("-")[0];
         	var paymentCategoryId=paymentTariffId.split("-")[1];
         	var totalAmt=$(".checkedValue").val();
         	
         	$('.service_'+serviceTariffId).each(function () { 
             	if ($(this).is(':checked')){
             		countchk++; 
					//service wise array to get the checked child services
					if(!$(this).is(':disabled')){
						var tariffId=$(this).attr('id').split('-');
						var inarray = chk1Array.indexOf(tariffId[1]);
						if(selectedChildName[1]==tariffId[1]){
							/*var textAmt=$("#txt_"+tariffId[1]).val();
							$("#txt_"+tariffId[1]).attr('disabled',false);
							if(!isNaN(textAmt) && typeof(textAmt)!='undefined'){
		         	   			val =parseFloat(totalAmt)+parseFloat(textAmt); 
							}else{*/
								serCost=parseFloat($(this).val());
		 		            	if(serCost==1)
	 	 		 		            serCost=0;
		 		            	val =parseFloat(totalAmt)+parseFloat(serCost);
							//}
						} 
						
					}
	        	}else{
		        	
		        	//To pop the unchecked services from the array
	        		var tariffId=$(this).attr('id').split('-');
					if(selectedChildName[1]==tariffId[1]){
						countUnchk++;
						serCost=parseFloat($(this).val());
 		            	if(serCost==1)
	 		 		       serCost=0;
 		            	val =parseFloat(totalAmt)-parseFloat(serCost);					
					}
	        	}    	
             	
							        		   
	     	});
	     	
         	if(countchk<=0) 
		        $("#"+selectedChildName[0]).attr('checked',false);//uncheck parent if none of the child is checked 
		        val=Math.round(val);
				$(".checkedValue").val(val);
				$(".checkedValue").text(val);
				checkBalance();
		 	    val=0; 
      });

     
	if($("#mode_of_payment").val() == 'Credit Card' || 
		$("#mode_of_payment").val() == 'Cheque' || 
		$("#mode_of_payment").val() == 'Debit Card'){
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
			// $("#patientCard").hide();
			 $("#paymentInfo").show();
			 $("#creditDaysInfo").hide();
			 $('#neft-area').hide();
			 $('#bankDeposite').hide();
		} else if($("#mode_of_payment").val() == 'Credit') {
			//$("#patientCard").hide();
		 	$("#creditDaysInfo").show();
		 	$("#paymentInfo").hide();
		 	$('#neft-area').hide();
		 	$('#bankDeposite').hide();
		} else if($('#mode_of_payment').val()=='NEFT') {
			//$("#patientCard").hide();
		    $("#creditDaysInfo").hide();
			$("#paymentInfo").hide();
			$('#neft-area').show();
			$('#bankDeposite').hide();
		}else if($('#mode_of_payment').val()=='Bank Deposit') {
			//$("#patientCard").hide();
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
	 		 }
	 	}else{
	 		 $("#patientCard").hide();
			 $("#creditDaysInfo").hide();
			 $("#paymentInfo").hide();
			 $('#neft-area').hide();
			 $('#bankDeposite').hide();
		}
});


$('.chk_child_paid').on('click', function(){
	var chkId=$(this).attr('id');
	var selectVal=0;
 	var paymentTariffId=$(this).attr('id').split("_")[1];
 	var totalAmt=$("#refund_amount").val();
 	if($('#'+chkId).is(':checked')){
 	 	if(totalAmt=='' || totalAmt==null){
 	 		selectVal=Math.round($('.paid_'+paymentTariffId).val());
 	 	}else
	 	selectVal =parseFloat(totalAmt)+Math.round($('.paid_'+paymentTariffId).val());		   
		
 	}else{
 		if(totalAmt!='' || totalAmt!=null){
 		selectVal =parseFloat(totalAmt)-Math.round($('.paid_'+paymentTariffId).val());
 		}else	
 	 		selectVal='0';
 	}
 	if($('#is_refund').is(':checked')){
 		selectVal=Math.round(selectVal);
	 	$("#refund_amount").val(selectVal);
	 	$("#refund_paid").val(selectVal);
	 	$("#refund_amount").trigger('keyup');
 	}
 	
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
	onSelect:function(){$(this).focus();}
});

$('#is_refund').click(function(){
	if ($(this).prop('checked')) {
		resetDiscountRefund();
		$("#refund_amount").show();
		$('#select').attr('checked', false);
		$('#select').attr('disabled', true);
		$('.chk_parent').each(function() { //loop through each checkbox
			 $(this).attr('disabled',true);
             this.checked = false; //deselect all checkboxes with class "chk_parent"                             
        });	          
        $('.chk_child').each(function() { //loop through each checkbox
        	  $(this).attr('disabled',true);
             this.checked = false;  //select all checkboxes with class "chk_child"
        });
        $('.chk_parent_paid').each(function() { //loop through each checkbox
    	   if($(this).hasClass('chk_parent'))
			    $(this).attr('disabled',false);
    	   else
        	    $(this).attr('disabled',false);
             this.checked = false; //deselect all checkboxes with class "chk_parent_paid"                             
        });	          
        $('.chk_child_paid').each(function() { //loop through each checkbox
        	if($(this).hasClass('chk_child'))
			    $(this).attr('disabled',false);
        	else
            	  $(this).attr('disabled',false);
             this.checked = false;  //select all checkboxes with class "chk_child_paid"
        });   
        $('.checkedValue').val('0');
        $(".checkedValue").text('0');
        checkBalance();
        
	         
	}else{
		$('.paymentRemarkRefund').hide();		
		$('.paymentRemarkReceived').show();
		$('#select').attr('disabled', false);
		$('#select').prop('checked', true);
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
			            		selectVal =selectVal+parseFloat($(this).val());		   
			      		  	}
				     	});	                              
	         });
	      	var mandCharges=parseFloat($('.chk_parent_mandatory').val());
			 if(!isNaN(mandCharges))
			 	selectVal=parseFloat(selectVal)+parseFloat(mandCharges);
			 selectVal=Math.round(selectVal);
	         $(".checkedValue").val(selectVal);
			  $(".checkedValue").text(selectVal);
	         checkBalance();

	         $('.chk_child').each(function() { //loop through each checkbox
	             this.checked = true;  //select all checkboxes with class "chk_child"
	         });
	         $("#refund_amount").val('');
	         $("#refund_amount").val('');
			$("#refund_amount").hide();
			$('#send-approval-for-refund').hide();
			$("#discount_authorize_by_for_refund").hide();
		}
	
});

//fnction to check discount approval
	function discountApproval(){

		resetDiscountRefund();			//reset all (Discount/Refund)
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
				 // $("#busy-indicator").show();
			  },	
			  success: function(data){
				 // $("#busy-indicator").hide(); 
				  parseData = $.parseJSON(data);
				  //console.log(parseData);

			if(parseData != null) {

				patientId = '<?php echo $patient['Patient']['id']; ?>';
				payment_category = 'Finalbill';
			    is_approved = parseFloat(parseData.is_approved);
			    request_to = parseFloat(parseData.request_to);
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
						clearInterval(interval); 					// stop the interval
						interval='';
						resetDiscountRefund();
						display();
					  }
				});

				/*				
				  $("#discount").show();
				  is_approved = parseFloat(parseData.is_approved);
				  request_to = parseFloat(parseData.request_to);
				  reasonType = parseData.reason;
				  is_type = parseData.type;
				  $('input:radio[class=discountType][value="' + is_type + '"]').prop('checked',true); 	//checked radio Amount/Percentage
				  discount_amount = parseFloat(parseData.discount_amount);								//discount_amount
				  discount_percentage = parseFloat(parseData.discount_percentage);						//discount_percentage					

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

				  $("#mesage").show();
				  $("#discount").val(discount);
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
				  
				if(parseFloat(is_approved) == 0)
				{
					$("#status-approved-message").html("apporval Request for discount has been sent, please wait for approval");
					$("#is_approved").val(1);	//for approval waiting
					$("#image-gif").show();
					$("#image-gif").html('<?php echo $this->Html->image('/img/wait.gif')?>'); //loader
					//set interval for clicked service group 
					interval = setInterval("Notifications()", 5000);  // this will call Notifications() function in each 5000ms
				  }
				else if(is_approved == 1)
				{	
					  $("#status-approved-message").html('<font color="green">Request for discount has been completed</font>');
					  $("#is_approved").val(2);	
					  $("#image-gif").hide(); 				  
				  }
				else if(is_approved == 2)
				{
					$("#status-approved-message").html('<font color="red">Request for discount has been rejected</font>');
					$("#image-gif").hide();
					$("#is_approved").val(3);	// for approval reject
			 	} 		
			 	*/
				display();	//calculate balance			  
			  }
			} 	//end of success
		}); 	//end of ajax
	}


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
				    is_approved = parseFloat(parseData.is_approved);
				    request_to = parseFloat(parseData.request_to);
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
				  is_approved = parseFloat(parseData.is_approved);
				  refund_amount = parseFloat(parseData.refund_amount);
				  request_to = parseFloat(parseData.request_to);
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
			        
				if(parseFloat(is_approved) == 0)
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

	$(".discountType").change(function(){
		if($('#is_refund').is(':checked')){
				resetRefund();				
		}
		var type = $(this).val();
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

	
	 $("#is_refund").click(function(){
	    if($('#is_refund').is(':checked')){
	    	$(".discountType").attr('disabled',true);
	        $("#refund_amount").show();
		}else{
			$("#refund_amount").hide(); 
			$(".discountType").attr('disabled',false);
		}
		display();
	 });	 

	$("#discount").keyup(function(){  
		display();
		if(instance == "vadodara"){
			$("#discount_authorize_by").show();
			$("#discount_reason").show();
			if(parseFloat($("#totalamount").val()) >= 10000 && $(this).val()>=1)	//if total amount is greater or equal to 10000 then it is possible to give approval for discount or refund
			{
				
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
		else if(instance == "kanpur"){	
			if(parseFloat($("#totalamount").val()) >= 1 && $(this).val()>=1)	//if total amount is greater or equal to 10000 then it is possible to give approval for discount or refund
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
	});

	var balanCe = parseFloat($("#totalamountpending").val());	//hold the balance
	$("#refund_amount").keyup(function(){
		var instance="<?php echo $configInstance;?>";
		refund = ($(this).val()!='')?$(this).val() : 0;
		
		if(instance == "vadodara"){
			$("#discount_authorize_by_for_refund").show();
			if(refund >= 10000){	// if refund amount >=10,000, request for approval by Swapnil G.Sharma
				
				if($("#is_refund_approved").val() == 0){
					$("#send-approval-for-refund").show();
				}
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
				if($("#is_refund_approved").val() == 0){
					$("#send-approval-for-refund").show();
				}
			    $("#is_refund_approved").val(1);
			}else{
				$("#discount_authorize_by_for_refund").hide();
				$("#send-approval-for-refund").hide();
				$("#is_refund_approved").val(0);
			}
		}
			
		mRefund = ($("#maintainRefund").val()!='')?$("#maintainRefund").val():0;
		mDiscount = ($("#maintainDiscount").val()!='')?$("#maintainDiscount").val():0;
		var adV = parseFloat($("#totaladvancepaid").val());
		var discount = parseFloat(($("#discount").val()!='')?$("#discount").val():0);
		var amountPaid = parseFloat(($("#amount").val()!='')?$("#amount").val():0);
		var total = parseFloat($("#totalamount").val()) - adV -amountPaid-discount-parseFloat(mDiscount)+ parseFloat(refund) +parseFloat(mRefund);
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
	});
	$(document).ready(function(){
			amtToPay=$('#actAmount').val();
			 
	});
	$('#actAmount').change(function(){
			amtToPay=$('#actAmount').val();
		});
	
	
	function display()	//calculate final balance
	{
		  
		/*var validatePerson = jQuery("#paymentDetail").validationEngine('validate'); 
	 	if(!validatePerson){
		 	return false;
		}*/
		/*paymentCategory=$("input[type='radio'][name='serviceGroupData']:checked").attr('radioName');
		paymentCategory=paymentCategory.split('_');
		paymentCategory=paymentCategory[0];*/
		/*if(paymentCategory=='mandatoryservices' || paymentCategory=='laboratory' || paymentCategory=='radiology'){//for mandattory services,lab,rad don aloow partial payment
			$('#amount').val($("#totalamountpending").val());
		}*///commented for hospital billing
		var disc = '';
		total_amount = $('#selectedChks').text();//($('#totalamount').val() != '') ? parseFloat($('#totalamount').val()) : 0; 
		<?php if($this->Session->read('website.instance')=='hope'){ ?>
			total_amount =amtToPay;
		<?php } ?>
		/*$(".discountType").each(function () {  
	        if ($(this).prop('checked')) {
	           var type = this.value;
	           $('#typeDiscount').val(type);
	           var perDis=0;
	           if(type == "Amount")
	            {    
	            	disc = ($("#discount").val() != '') ? parseFloat($("#discount").val()) : 0;
	            	if(parseFloat(disc)>parseFloat(total_amount)){
						alert("Discount cannot be greater than total bill amount. Please enter amount less than "+parseFloat(total_amount));
						$("#discount").val('');
						return false;
	            	}
					if(disc!='0'){
							var perDis=(parseFloat(disc)/parseFloat(total_amount))*100;
							$('.chk_child').each(function() { //loop through each checkbox
								if($(this).is(':checked') && !$(this).is(':disabled')){
					        	  var selId=$(this).attr('id');
					        	  var splitId=selId.split('_')[1];
					        	  var selVal=$(this).val();
					        	  var disAmt=parseFloat((selVal*perDis)/100);
					        	  //if(!$('.discount_'+splitId).val() || isNaN($('.discount_'+splitId).val()) || parseFloat($('.discount_'+splitId).val()=='0'))//Discount to get distributed only if there is no previous discount
					        	  $('.discount_'+splitId).val(disAmt);
								}
					        });
								var disAmt=0;
					        $('.chk_parent').each(function(){
					        	if($(this).is(':checked') && !$(this).is(':disabled')){
										var pId=$(this).attr('id');
										var splitPId=pId.split('_')[0];
										var pharId=pId.split('_')[1];
										if(splitPId=='pharmacy'){
										  var selVal=$(this).val();alert(selVal);
										  var disAmt=parseFloat((selVal*perDis)/100);
										  alert(disAmt);
										  //alert($('.pharmacy_discount_'+pharId).val());
										  //if(!$('.pharmacy_discount_'+pharId).val() || isNaN($('.pharmacy_discount_'+pharId).val())|| parseFloat($('.pharmacy_discount_'+pharId).val())=='0')
							        	  $('.pharmacy_discount_'+pharId).val(disAmt);
										}else if(splitPId=='otpharmacy'){
											  var selVal=$(this).val();alert(selVal);
											  var disAmt=parseFloat((selVal*perDis)/100);
											  alert(disAmt);
											  //alert($('.pharmacy_discount_'+pharId).val());
											  //if(!$('.pharmacy_discount_'+pharId).val() || isNaN($('.pharmacy_discount_'+pharId).val())|| parseFloat($('.pharmacy_discount_'+pharId).val())=='0')
								        	  $('.otpharmacy_discount_'+pharId).val(disAmt);
											}
					        	}
						     });
							
							
	            	}
	            }else if(type == "Percentage")
	            {
	            	var discount_value = ($("#discount").val()!= '') ? parseFloat($("#discount").val()) : 0;
	            	if(discount_value < 101){
						if(discount_value!=0){
		       		    	disc = parseFloat((total_amount*discount_value)/100);
							$('.chk_child').each(function() { //loop through each checkbox
								if($(this).is(':checked') && !$(this).is(':disabled')){
					        	  var selId=$(this).attr('id');
					        	  var splitId=selId.split('_')[1];
					        	  var selVal=$(this).val();
					        	  var disAmt=parseFloat((selVal*discount_value)/100);
					        	  //if(!$('.discount_'+splitId).val() || isNaN($('.discount_'+splitId).val()) || parseFloat($('.discount_'+splitId).val())=='0')
					        	  $('.discount_'+splitId).val(disAmt);
								}
					        });
								var disAmt=0;
					        $('.chk_parent').each(function(){
					        	if($(this).is(':checked') && !$(this).is(':disabled')){
										var pId=$(this).attr('id');
										var splitPId=pId.split('_')[0];
										var pharId=pId.split('_')[1];
										if(splitPId=='pharmacy'){
										  var selVal=$(this).val();alert(selVal);
										  disAmt=parseFloat((selVal*discount_value)/100);
										  alert(disAmt);
										  //if(!$('.pharmacy_discount_'+pharId).val() || isNaN($('.pharmacy_discount_'+pharId).val()) || parseFloat($('.pharmacy_discount_'+pharId).val())=='0')
							        	  $('.pharmacy_discount_'+pharId).val(disAmt);
										}else if(splitPId=='otpharmacy'){
											  var selVal=$(this).val();alert(selVal);
											  var disAmt=parseFloat((selVal*perDis)/100);
											  alert(disAmt);
											  //alert($('.pharmacy_discount_'+pharId).val());
											  //if(!$('.pharmacy_discount_'+pharId).val() || isNaN($('.pharmacy_discount_'+pharId).val())|| parseFloat($('.pharmacy_discount_'+pharId).val())=='0')
								        	  $('.otpharmacy_discount_'+pharId).val(disAmt);
											}
					        	}
						     });
					        
						}else
							disc=0;
					}else{
						alert("Percentage should be less than or equal to 100");
					}
	            }
	            $("#disc").val(disc);
	           
	           if((!isNaN(amtToPay) || amtToPay!='0')){
	           	(!isNaN(disc) || disc!='0')
			   		$('#actAmount').val(parseFloat(amtToPay)-parseFloat(disc));
					 
			   		//$('#card_pay').trigger('click');
			   }	
	        }
	       
	    });*/

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
	            	disc = ($("#discount").val() != '') ? parseFloat($("#discount").val()) : 0;
	            	if(parseFloat(disc)>parseFloat(total_amount)){
	            		$('#actAmount').val(parseFloat(amtToPay));
	            		$('#actAmountSpan').text(parseFloat(amtToPay));
						alert("Discount cannot be greater than total bill amount. Please enter amount less than "+parseFloat(total_amount));
						$("#discount").val('');
						resetRowDiscount();
						return false;
	            	}
					if(disc!='0'){
						if(parseFloat(disc) >= 10000){
							<?php if($this->Session->read('website.instance')=='hope'){?>
								$("#is_approved").val(0);
							<?php }else{ ?>
							if($("#is_approved").val() == 0){
								$("#send-approval").show();
							}
							$("#is_approved").val(1);
							<?php } ?>
						}
						else{
							$("#send-approval").hide();
							$("#is_approved").val(0);
						}
							var perDis=(parseFloat(disc)/parseFloat(total_amount))*100;
							$('.chk_child').each(function() { //loop through each checkbox
								if($(this).is(':checked') && !$(this).is(':disabled')){
									if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
		 		            			var selId=$(this).attr('id');
							        	var splitId=selId.split('_')[1];
							        	var selVal=$(this).val();
							        	var disAmt=parseFloat((selVal*perDis)/100);
							        	$('.discount_'+splitId).val(disAmt);
							        	$('.discount_'+splitId).text(disAmt.toFixed(2));
							        	$('.paid_'+splitId).text(parseFloat(selVal-disAmt));
									}
								}
					        });
								var disAmt=0;
					        $('.chk_parent').each(function(){
					        	if($(this).is(':checked') && !$(this).is(':disabled')){
										var pId=$(this).attr('id');
										var splitPId=pId.split('_')[0];
										var pharId=pId.split('_')[1];
										if(splitPId=='pharmacy'){
										  var selVal=$(this).val();
										  var disAmt=parseFloat((selVal*perDis)/100);
										  $('.pharmacy_discount_'+pharId).text(disAmt.toFixed(2));
								          $('.pharmacy_discount_'+pharId).val(disAmt.toFixed(2));
							        	  $('.pharmacy_paid_'+pharId).text(parseFloat(selVal-disAmt).toFixed(2));
								          $('.pharmacy_paid_'+pharId).val(parseFloat(selVal-disAmt).toFixed(2));
										}
					        	}
						     });							
							
	            	}
					$('#calDis').text(perDis.toFixed(2));
					$('#calPer').val(perDis.toFixed(2));
	            }else if(type == "Percentage")
	            {
	            	$('#inAmt').show();
			        $('#calDis').show();
			        $('#calDis').text('');
			        $('#calPer').val('');
			        $('#inPer').hide();
			        
	            	var discount_value = ($("#discount").val()!= '') ? parseFloat($("#discount").val()) : 0;
	            	if(discount_value < 101){
	            		if(discount_value!=0){
	            			if(total_amount==0){
					        	alert("Selected service cost should be greater than zero");
								$("#discount").val('');
								resetRowDiscount();
								return false;
					        }
		       		    	disc = parseFloat((total_amount*discount_value)/100);
		       		    	if(parseFloat(disc) >= 10000){
								if($("#is_approved").val() == 0){
									$("#send-approval").show();
								}
								$("#is_approved").val(1);
							}
							else{
								$("#send-approval").hide();
								$("#is_approved").val(0);
							}
							$('.chk_child').each(function() { //loop through each checkbox
								if($(this).is(':checked') && !$(this).is(':disabled')){
									if(!($(this).hasClass('exclude_discount')) && !($(this).hasClass('discount_excluded'))){
		 		            			  var selId=$(this).attr('id');
							        	  var splitId=selId.split('_')[1];
							        	  var selVal=$(this).val();
							        	  var disAmt=parseFloat((selVal*discount_value)/100);
							        	  $('.discount_'+splitId).val(disAmt.toFixed(2));
							        	  $('.discount_'+splitId).text(disAmt.toFixed(2));
								          $('.paid_'+splitId).text(parseFloat(selVal-disAmt).toFixed(2));
									}
								}
					        });
								var disAmt=0;
					        $('.chk_parent').each(function(){
					        	if($(this).is(':checked') && !$(this).is(':disabled')){
										var pId=$(this).attr('id');
										var splitPId=pId.split('_')[0];
										var pharId=pId.split('_')[1];
										if(splitPId=='pharmacy'){
										  var selVal=$(this).val();
										  disAmt=parseFloat((selVal*discount_value)/100);
										   
										  $('.pharmacy_discount_'+pharId).text(disAmt.toFixed(2));
								          $('.pharmacy_discount_'+pharId).val(disAmt.toFixed(2));
							        	  $('.pharmacy_paid_'+pharId).text(parseFloat(selVal-disAmt).toFixed(2));
								          $('.pharmacy_paid_'+pharId).val(parseFloat(selVal-disAmt).toFixed(2));
										}
					        	}
						     });
					        
						}else
							disc=0;
					}else{
						amtToPay=Math.round(parseFloat(amtToPay));
						$('#actAmount').val(amtToPay);
						$('#actAmountSpan').text(amtToPay);
						alert("Percentage should be less than or equal to 100");
						$("#discount").val('');
						resetRowDiscount();
						return false;
						
					}
	            	$('#calDis').text(disc);
	            	$('#calPer').val(discount_value.toFixed(2));
	            }
	            $("#disc").val(disc);

	            
	           if((!isNaN(amtToPay) || amtToPay!='0')){
	           		if(disc!='0'){ 
		           		subAmt=parseFloat(amtToPay)-parseFloat(disc);
		           		if(subAmt<0){
		           			subAmt=0;
		           			alert('Either select more services or reduce the discount amount. As the total amount paid is greater than total Bill');
		           			$('#resetAll').trigger('click');
		           			return false;
			           		}
		           		subAmt=Math.round(parseFloat(subAmt));
			   			$('#actAmount').val(subAmt);
			   			$('#actAmount').attr('limit',subAmt);
			   			$('#actAmountSpan').text(subAmt);
	           		}else{ 
		           		if(amtToPay){
		           			subAmt=Math.round(parseFloat(amtToPay));
				   			$('#actAmount').val(subAmt);
				   			$('#actAmount').attr('limit',subAmt);
				   			$('#actAmountSpan').text(subAmt);
		           		}
	           			
		           	}
			   		
			   }	
	        }
	       
	    });
		mRefund = ($("#maintainRefund").val()!='')?$("#maintainRefund").val():0;
		mDiscount = ($("#maintainDiscount").val()!='')?$("#maintainDiscount").val():0;
		balance = ($('#totalamountpending').val() != '') ? parseFloat($("#totalamountpending").val()) : 0;
		amount_paid = ($('#amount').val() != '') ? parseFloat($("#amount").val()) : 0;
	 	total_advance = ($('#totaladvancepaid').val() != '') ? parseFloat($('#totaladvancepaid').val()) : 0;
	 	
	 	if($('#is_refund').is(':checked'))
		{
	 		refund_amount = ($('#refund_amount').val() != '') ? parseFloat($("#refund_amount").val()) : 0;
	 	}else{
			refund_amount = 0;
	 	} 	
	 	
		bal = total_amount - total_advance - amount_paid - disc -parseFloat(mDiscount) + parseFloat(refund_amount)+parseFloat(mRefund);

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
					 if(parseFloat(data) == 1)
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


				 
				if(parseFloat(data) == 0)
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
        $('#calDis').text('');
        $('#calPer').val('');
        $('#calDis').hide();
        $('#inAmt').hide();
	}

	function resetRefund()
	{
		
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
			            	if(!$(this).is(':disabled')){
			            		selectVal =selectVal+parseFloat($(this).val());		   
			      		  	}
				     	});	                              
	         });
	      	var mandCharges=parseFloat($('.chk_parent_mandatory').val());
			 if(!isNaN(mandCharges))
			 	selectVal=parseFloat(selectVal)+parseFloat(mandCharges);
			 selectVal=Math.round(selectVal)
	         $(".checkedValue").val(selectVal);
			 $(".checkedValue").text(selectVal);
	         checkBalance();

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
		$("#refund_amount").attr('readonly',false);
		$("#refund_amount").hide();
		$("#discount_authorize_by_for_refund").attr('disabled',false);
		$("#discount_authorize_by_for_refund").hide();
		$("#send-approval-for-refund").hide();
		$("#cancel-refund-approval").hide();
		$("#mesage2").hide();
		$('#inPer').hide();
        $('#calDis').text('');
        $('#calPer').val('');
        $('#calDis').hide();
        $('#inAmt').hide();
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
					            	defaultVal =parseFloat(defaultVal)+parseFloat($(this).val());		   
				      		  	}
				      		  	if($(this).is(':disabled') && !$(this).is(':checked'))
				      		  	 defaultVal =parseFloat(defaultVal)+parseFloat($(this).val());	
					     	});
					     	if(count==0){
						     	$(this).removeClass('chk_parent');
						     	$(this).addClass('chk_parent_paid');
						     	$(this).parent('div').siblings().addClass('paid_payment');
						     	$(this).parent('div').removeClass('pending_payment');
					     		$(this).attr('disabled',true);
					     	}else{
					     		$(this).parent('div').siblings().addClass('pending_payment');
						     	//$(this).parent('div').removeClass('paid_payment');
					     	}
							
							if(totalChk=='0'){
					     		$('#disRow').hide();
					     	}else{
								$('#disRow').show();
							}
							if(instance=='hope'){
								$('#disRow').show();
							}
			         }
			 });
			 var mandCharges=parseFloat($('.chk_parent_mandatory').val());
			 if(!isNaN(mandCharges))
				 defaultVal=parseFloat(defaultVal)+parseFloat(mandCharges);

			 defaultVal= Math.round(defaultVal);
			 $(".checkedValue").val(defaultVal);
			 $(".checkedValue").text(defaultVal);
			 
			 checkBalance();
				/* all calculations are done in checkBalance()-pooja 
				var paidAdvance="<?php echo $advanceAmount[0]['paidAdvance'];?>"
				var advance="<?php echo $advanceAmount[0]['advance'];?>";
				var diffAdvance='0';
				if(parseFloat(paidAdvance)<parseFloat(advance)){
					diffAdvance=parseFloat(advance)-parseFloat(paidAdvance);
				}
					var subAmt=parseFloat(defaultVal)-parseFloat(diffAdvance);
					if(subAmt<0){
						subAmt=0;
					}
					$('#amtSpan').show();
					$('#actAmount').val(subAmt);
					$('#actAmountSpan').text(subAmt);
					$('#advance_balanced').val(diffAdvance);*/
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
							            		selectVal =selectVal+parseFloat($(this).val());		   
							      		  	}
								     	});	                              
					         });
					      	var mandCharges=parseFloat($('.chk_parent_mandatory').val());
							 if(!isNaN(mandCharges))
							 	selectVal=parseFloat(selectVal)+parseFloat(mandCharges);

							 selectVal=Math.round(selectVal);
					         $(".checkedValue").val(selectVal);
					         $(".checkedValue").text(selectVal);
					         checkBalance();

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
					if(parseFloat(data) == 0)
					{
						$("#status-approved-message-for-refund").html("Request for Refund has been sent, please wait for approval");
						$("#image-gif2").html('<?php echo $this->Html->image('/img/wait.gif')?>');
						$("#is_refund_approved").val(1);
					}else
					if(parseFloat(data) == 1)		//approved
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
					if(parseFloat(data) == 2)		// if rejected by users
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
	
	 $("#submit").click(function(){
		 var disp_msg='';
		 var instance="<?php echo $configInstance;?>";
	    	var validatePerson = jQuery("#billingsFullPaymentForm").validationEngine('validate'); 
	  	 	if(!validatePerson){
	  		 	return false;
	  		}
	  	  	var chkpay= $('.checkedValue').val();	


	  	  	if(parseFloat(chkpay)!=0 && $('#mode_of_payment').val()=='Credit' && !($('#pay_later').is(':checked'))){
		  	  	alert('Please Select Valid Payment Mode For Payment. You have Selected Credit Mode');
		  	  	$('#mode_of_payment').focus();
		  	    $('#mode_of_payment').select();
		  	 	 return false;
		  	 	$('#mode_of_payment').focus();

	  	  	}  		
	        is_refund_approved = parseFloat($("#is_refund_approved").val());
	        is_approved = parseFloat($("#is_approved").val());
			
	        
	        
	        if($("#is_refund").is(":checked")){
				  if($("#refund_amount").val()==''){
					  alert('Please pay some refund amount.');
					  return false;
				  }else{
					  refpay=$("#refund_amount").val();
					  var disp_msg="Please confirm your refund amount before proceeding, refund amount is Rs ."+refpay;
				  }
			  }else{
				  if($(".discountType").is(":checked")){
				  	if(is_approved=='1' || is_refund_approved=='1'){
				       // alert($("#is_approved").val());
				        alert("Please wait for approval");
				        return false;
			        }

			        if($("#is_approved").val()=='3' || $("#is_refund_approved").val()=='3'){
				        alert("Your approval has been rejected bu user, please cancel the request to save");
				        return false;
			        }
				  if($("#discount").val()==''){
					  alert('Please pay some amount In Discount.');
					  return false;
				  }
				  if((instance=='vadodara' && parseFloat($("#totalamount").val())>=10000) || instance=='kanpur'){
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
				  chkpay=chkpay-parseFloat($('#disc').val());
				  }
			  }
			  var advDeduct=parseFloat($('#advance_balance').val());
			  if(advDeduct=='0' || isNaN(advDeduct)){
				  advDeduct=0;
			  }
			  if(parseFloat(chkpay)<parseFloat(advDeduct)){
				  chkpay='0';
			  }else{
	        	  chkpay=parseFloat(chkpay)-parseFloat(advDeduct);
			  }
		

				if($('#pay_later').is(':checked')){
					disp_msg="Proceeding for Pay later for selected services";
				}else if(disp_msg=='' || disp_msg==null){
				  disp_msg="Please confirm your payment amount before proceeding, payment amount is Rs. "+chkpay;	        	
			  	}
			  var confirm_pay= confirm(disp_msg);
	        if (confirm_pay== true){
	        	$('#submit').hide();
	            return true;
	        }else
		        return false;
	 });

	 $('#card_pay').click(function(){
		 var configInstance="<?php echo $this->Session->read('website.instance');?>";
		 var amtInCard="<?php echo $patientCard['Account']['card_balance'];?>";
		 if($("#card_pay").is(":checked")){
			//var chkpay= $('.checkedValue').val();
			 var chkpay=$('#actAmount').val();
			 if(chkpay=='0'){
				  alert('Please Select Some Services To Pay');
				  $("#patientCard").hide();	
				  return false;			 
			 }
			 
			 if(amtInCard=='0' || isNaN(amtInCard)){
				 alert("Insufficient Funds in Patient Card");
				 $("#card_pay").attr("checked",false);
				 $("#patientCard").hide();
			 }else{	
				 if(configInstance=='vadodara'){
					 var cardAdv=$('#patient_card').val();
					 	if(cardAdv!='0'){
							if(parseFloat(chkpay)!='0'){
								if(parseFloat(chkpay)< parseFloat(cardAdv)){							
									subAmt='0';
								}else{
									subAmt=parseFloat(chkpay)-parseFloat(cardAdv);
								}
								if(subAmt<0)subAmt=0;
								$('#actAmount').val(Math.round(subAmt));
								$('#otherPay').text(Math.round(subAmt));
								$('#actAmountSpan').text(Math.round(subAmt));
							}else{
								subAmt=Math.round(parseFloat(chkpay));
								$('#amtSpan').show();
								$('#actAmount').val(subAmt);
								$('#actAmount').attr('limit',subAmt);
								$('#otherPay').text(subAmt);
								$('#actAmountSpan').text(subAmt);
							}
						}
				 }else{
					var cardPay=$('#patient_card').val();
					var otherPay=0;
					if(parseFloat(chkpay)<parseFloat(cardPay)){
						otherPay=0;
					    $('#patient_card').val(chkpay);
					}else{
					   $('#patient_card').val(cardPay);
					   otherPay=Math.round(chkpay-cardPay);
					   
						 
					}		
					 $('#otherPay').text(otherPay);				
				 	 $("#patientCard").show();
				 }
			 }
		 }else{
			 subAmt=$('#selectedChks').text();
			 subAmt=Math.round(parseFloat(subAmt));
				$('#amtSpan').show();
				$('#actAmount').val(subAmt);
				$('#actAmount').attr('limit',subAmt);
				$('#otherPay').text(subAmt);
				$('#actAmountSpan').text(subAmt);
			 $("#patientCard").hide();
		 }

		 });

	 $('#patient_card').change(function(){
		 var amtInCard="<?php echo $patientCard['Account']['card_balance'];?>";
		 var changeAmt=$(this).val();
		 var otherPay=$('#otherPay').text();
		 if(parseFloat(changeAmt)>parseFloat(amtInCard)){
			 alert("Insufficient Funds in Patient Card");
			 $("#card_pay").attr("checked",false);
			 $('#patient_card').val(amtInCard);
			 $("#patientCard").hide();
		 }
		 var chkVal=$('.checkedValue').val();
		 if(parseFloat(changeAmt)>parseFloat(chkVal)){
			 alert("Amount Paid is greater");
			 $("#card_pay").attr("checked",false);
			 $('#patient_card').val(amtInCard);
			 $("#patientCard").hide();
			 return false;
		 }else{
			 var otherPay=Math.round(chkVal-changeAmt);
			 if(parseFloat(otherPay)<=0)
				 otherPay=0;	
			 
		 }
		 $('#otherPay').text(otherPay); 
	 });

	 $('#reason_of_balance').change(function(){
		  /*if($(this).val() != ''){
			$("#balance_authorize_by").show();
			$("#send_approval_for_balance").show();
			$("#balance_approved").val(1);
		  }else{
			  $("#balance_authorize_by").hide();
			  $("#send_approval_for_balance").hide();
			  $("#balance_approved").val(0);
		  }*/
				  
		  if($(this).val()=='Credit Period'){
			  $('.guarant').show();
			  $('#mandatoryGuarantor').show();
			  $('#guarantor').addClass('validate[required,custom[mandatory-select]]');
		  }else{
			  $('.guarant').hide();
			  $('#mandatoryGuarantor').hide();
			  $('#guarantor').removeClass('validate[required,custom[mandatory-select]]');
		  }
	  });

	  $(function (){
		  $('.chk_parent_paid').on('click', function(){
  		 var val=0;var calamt=0;
	    	 var phar=$(this).attr('id').split('_')[0];
	         selectedParent = $(this).attr('id').split('_')[1] ;
	         var selectVal='0';	
	         if($(this).is(':checked')){ 
	        	 $('.chk_parent_paid').each(function() { //loop through each checkbox
	 	     		if($(this).is(':checked')){ 
		 	     		var chkId=$(this).attr('id'); 	     		
	              	  	selectVal =parseFloat(selectVal)+parseFloat($('.paid_parent_'+chkId).val()); 			     	 
	 	     		}                             
	         	 });
	        	 //var mandCharges=parseFloat($('.chk_parent_mandatory').val());
	        	 //if(!isNaN(mandCharges))
	 			 	//selectVal=parseFloat(selectVal)+parseFloat(mandCharges);
	 			 	
	 			 	if($('#is_refund').is(':checked')){
	 			 		selectVal=Math.round(selectVal);
	 			 		$("#refund_amount").val(selectVal); 
			             $("#refund_paid").val(selectVal); 
			            // $("#refund_amount").text(selectVal);
			             $("#refund_amount").trigger('keyup');
	 			 	}

	         }else{
	        	 $('#select').attr('checked', false);
	        	$('.chk_parent').each(function() { //loop through each checkbox
 		 	     		if($(this).is(':checked')){ 
 		              	  selectedParent =$(this).attr('id').split('_')[1] ;
 		 	         	  $('.service_'+selectedParent).each(function () { 
 		 		            	if(!$(this).is(':disabled')){
 		 		            		selectVal =parseFloat(selectVal)+Math.round($(this).val());		   
 		 		      		  	}	            	
 		 			     	});	 
 		 	     		}                             
	 		    });
	        	var mandCharges=parseFloat($('.chk_parent_mandatory').val());
	        	if(!isNaN(mandCharges))
	 			 	selectVal=parseFloat(selectVal)+parseFloat(mandCharges);
	        	selectVal=Math.round(selectVal);
	        	 $(".checkedValue").val(selectVal);  
	        	 $(".checkedValue").text(selectVal);
	        	 $("#refund_amount").val(0);
	        	 $("#refund_paid").val(0);  
	        	 $("#refund_amount").trigger('keyup');
	             //$("#refund_amount").text(0); 
	        	 checkBalance();    	
	         }
	         
	     });
		     });


	     $('#resetAll').on('click',function(){
	    	 resetDiscountRefund();
	    	 resetRefund();
	    	$('#discountType').val('');
	    	 $('#typeDiscount').val('');
	    	 $('#maintainDiscount').val('');
	    	 $('#disc').val('');
	    	 //$('#discount').val('');
	    	 $('#discount_authorize_by').val('');
	    	 $('#hrefund').val('');
	    	 $('#maintainRefund').val('');
	    	 $('#refund_amount').val('');
	    	 $("#refund_paid").val('');
	    	 $('#discount_authorize_by_for_refund').val('');
	    	 $('#credit_period').val('');
	    	 $('#bank_deposite').val('');
	    	 $('#BN_paymentInfo').val('');
	    	 $('#AN_paymentInfo').val('');
	    	 $('#card_check_number').val('');
	    	 $('#cheque_date').val('');
	    	 $('#BN_neftArea').val('');
	    	 $('#AN_neftArea').val('');
	    	 $('#neft_number').val('');
	    	 $('#neft_date').val('');
	    	 $('#inPer').hide();
	         $('#calDis').text('');
	         $('#calPer').val('');
	         $('#calDis').hide();
	         $('#inAmt').hide();
	         $('#otherPay').text('');
			 $('#patientCard').hide();
			 $('#card_pay').attr('checked', false);
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
	    	 			            	defaultVal =defaultVal+parseFloat($(this).val());		   
	    	 		      		  	}
	    	 		      		  	if($(this).is(':disabled') && !$(this).is(':checked'))
	    	 		      		  	 defaultVal =defaultVal+parseFloat($(this).val());	
	    	 			     	});
	    	 			     	if(count==0){
	    	 				     	$(this).removeClass('chk_parent');
	    	 				     	$(this).addClass('chk_parent_paid');
	    	 				     	$(this).parent('div').siblings().addClass('paid_payment');
	    	 				     	$(this).parent('div').removeClass('pending_payment');
	    	 			     		$(this).attr('disabled',true);
	    	 			     	}else{
	    	 			     		$(this).parent('div').siblings().addClass('pending_payment');
	    	 				     	//$(this).parent('div').removeClass('paid_payment');
	    	 			     	}
	    	 					
	    	 					if(totalChk=='0'){
	    	 			     		$('#disRow').hide();
	    	 			     	}else{
	    	 						$('#disRow').show();
	    	 					}
	    	 					if(instance=='hope'){
	    							$('#disRow').show();
	    						}
	    	 	         }
	    	 	 });
	    	 	 var mandCharges=parseFloat($('.chk_parent_mandatory').val());
	    	 	 if(!isNaN(mandCharges))
	    	 		 defaultVal=parseFloat(defaultVal)+parseFloat(mandCharges);
	    	 	selectVal=Math.round(defaultVal);	        	  
	        	$(".checkedValue").val(defaultVal); 
	    	 	 $(".checkedValue").text(selectVal);
	    	 	 checkBalance();
	    	 		/* var paidAdvance="<?php echo $advanceAmount[0]['paidAdvance'];?>"
	    	 		var advance="<?php echo $advanceAmount[0]['advance'];?>";
	    	 		var diffAdvance='0';
	    	 		if(parseFloat(paidAdvance)<parseFloat(advance)){
	    	 			diffAdvance=parseFloat(advance)-parseFloat(paidAdvance);
	    	 		}
	    	 			var subAmt=parseFloat(defaultVal)-parseFloat(diffAdvance);
						if(subAmt<0)subAmt=0;
	    	 			$('#amtSpan').show();
	    	 			$('#actAmount').val(subAmt);
	    	 			$('#actAmountSpan').text(subAmt);
	    	 			$('#advance_balanced').val(diffAdvance);*/
				


		     });

	     $('#pay_later').click(function(){
		     if($(this).is(':checked')){
					$('#pay_later_auth_by').show();
					//$('#pay_later_auth_by').addClass('validate[required,custom[mandatory-select]]');
					//$('#mode_of_payment').removeClass('validate[required,custom[mandatory-select]]');
		     }else{
		    	 	$('#pay_later_auth_by').hide();
					//$('#pay_later_auth_by').removeClass('validate[required,custom[mandatory-select]]');
					//$('#mode_of_payment').addClass('validate[required,custom[mandatory-select]]');
		     }
			
		 });

		 $('#actAmount').keyup(function(){
				var limit =$(this).attr('limit');
			 	var textVal=$(this).val();
				if(limit!='' || typeof(limit)!=undefined || !isNaN(limit)){
					if(parseInt(textVal) > parseInt(limit)){
						$(this).val('');
						alert('Please Enter Amount less than Rs.'+parseInt(limit));
					}
				}
					
		 });
 
</script>
</body>
</html>

<?php 
	function consultantHtml($patient,$cCArray,$formHelper,$numberHelper,$consultantServiceId,$hideCGHSCol){
	//$dateFormatComponent = new DateFormatHelper();
	//$formHelper =new FormHelper;// Classregistry::init('Form');
	//$numberHelper =new NumberHelper;// Classregistry::init('Number');

	$totalCost=0;$v=0;
	foreach ($cCArray as $cBilling){
			          foreach($cBilling as $consultantBillingDta){
			          	foreach($consultantBillingDta as $consultantBilling){
							foreach($consultantBilling as $singleKey=>$singleData){
					          	$v++;$srNo++;$paidAmt=0;
					          	//checkBox value contains amount amt*qty
					          	$rowCost = $singleData['ConsultantBilling']['amount'];
					          	$paidAmt=$rowCost-(($singleData['ConsultantBilling']['paid_amount']+$singleData['ConsultantBilling']['discount']));
					          	$disabled='';
					          	if(round($paidAmt)<=0){
									$disabled='disabled';
									$class='chk_child_paid'	;
								}else{
									$class='chk_child'	;
								}
					          	$consultant_id=$singleData['ConsultantBilling']['id'];			          	 
					          	$consultantHtml.="<div>";
					          	$consultantHtml.="<li>";
					          	$consultantHtml.="<div align='center' class='tdBorder' style=' float: left;'>";			          	
					          	$consultantHtml.=$formHelper->input("Billing.Consultant.".$consultant_id.".valChk",array('type'=>'checkbox','id'=>'consultant_'.$consultantServiceId.'-'.$consultant_id ,$disabled,'class'=>'service_'.$consultantServiceId.' '.$class,'value'=>$paidAmt));
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
								$consultantHtml.= $formHelper->hidden("Billing.Consultant.".$consultant_id.".unit",array('value' =>count($consultantBilling),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
								$consultantHtml.=$singleData['ConsultantBilling']['amount'];
								$consultantHtml.="</div>";
								$consultantHtml.="<div align='center' valign='top' class='tdBorderRt chldDiv5' >";
								$totalCost = $totalCost + $singleData['ConsultantBilling']['amount'];
								$consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".rate",array('value' => $numberHelper->format($singleData['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
								$consultantHtml.= 1;
								$consultantHtml.="</div>";
								 
								$consultantHtml.="<div align='center' valign='top' class='tdBorderRt chldDiv6'>";
								$consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".amount",array('value' => $numberHelper->format(($singleData['ConsultantBilling']['amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_amount','style'=>'text-align:right;'));
								$consultantHtml.=$singleData['ConsultantBilling']['amount'];						
								$consultantHtml.='</div>';
								$consultantHtml.='<div align="center" valign="top" class="chldDiv7">';
								$consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".discount",array('value' => $singleData['ConsultantBilling']['discount'],'class'=>'discount_'.$consultantServiceId.'-'.$consultant_id,'legend'=>false,'label'=>false));
					          	$consultantHtml.=isset($singleData['ConsultantBilling']['discount'])?round($singleData['ConsultantBilling']['discount']):'0';
								$consultantHtml.='</div>';
						        $consultantHtml.='<div align="center" valign="top" class="chldDiv8">';
						        $paid=$singleData['ConsultantBilling']['paid_amount'];
					            if($paid<=0){
					           		$consultantHtml.='0';
					           		$paid=0;
					            }else{
								   $consultantHtml.=round($paid);
			 				    }
			 				    $consultantHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".paid_amount",array('value' => $numberHelper->format($paid,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'class'=>'paid_'.$consultantServiceId.'-'.$consultant_id,'style'=>'text-align:right;'));
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
		//$dateFormatComponent = new DateFormatHelper();
		#pr($consultantBillingDataD);exit;
		//if($consultantBilling['ConsultantBilling']['category_id'] == 1){
		foreach ($cDArray as $cBilling){
			foreach($cBilling as $consultantBillingDta){
				foreach($consultantBillingDta as $consultantBilling){
					foreach($consultantBilling as $singleKey=>$singleData){
						$v++;$srNo++;$paidAmt=0;
						//checkBox value contains amount amt*qty
						$rowCost = $singleData['ConsultantBilling']['amount'];
						$paidAmt=$rowCost-($singleData['ConsultantBilling']['paid_amount']+$singleData['ConsultantBilling']['discount']);
						$disabled='';
						if(round($paidAmt)<=0){
							$disabled='disabled';
							$class='chk_child_paid'	;
						}else{
							$class='chk_child'	;
						}
						$consultant_id=$singleData['ConsultantBilling']['id'];
						$physicianHtml.="<div>";
						$physicianHtml.="<li>";
						$physicianHtml.="<div align='center' class='tdBorder' style=' float: left;'>";
						$physicianHtml.=$formHelper->input("Billing.Consultant.".$consultant_id.".valChk",array('type'=>'checkbox','id'=>'consultant_'.$consultantServiceId.'-'.$consultant_id ,$disabled,'class'=>'service_'.$consultantServiceId.' '.$class,'value'=>$paidAmt));
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
						$physicianHtml.= $formHelper->hidden("Billing.Consultant.".$consultant_id.".unit",array('value' =>count($consultantBilling),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
						$physicianHtml.=$singleData['ConsultantBilling']['amount'];
						$physicianHtml.="</div>";
						$physicianHtml.="<div align='center' valign='top' class='tdBorderRt chldDiv5' >";
						$totalCost = $totalCost + $singleData['ConsultantBilling']['amount'];
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".rate",array('value' => $numberHelper->format($singleData['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
						$physicianHtml.= 1;
						$physicianHtml.="</div>";
							
						$physicianHtml.="<div align='center' valign='top' class='tdBorderRt chldDiv6'>";
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".amount",array('value' => $numberHelper->format(($singleData['ConsultantBilling']['amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_amount','style'=>'text-align:right;'));
						$physicianHtml.=$singleData['ConsultantBilling']['amount'];
						$physicianHtml.='</div>';
						$physicianHtml.='<div align="center" valign="top" class="chldDiv7">';
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".discount",array('value' => $singleData['ConsultantBilling']['discount'],'class'=>'discount_'.$consultantServiceId.'-'.$consultant_id,'legend'=>false,'label'=>false));
						$physicianHtml.=isset($singleData['ConsultantBilling']['discount'])?round($singleData['ConsultantBilling']['discount']):'0';
						$physicianHtml.='</div>';
						$physicianHtml.='<div align="center" valign="top" class="chldDiv8">';
						$paid=$singleData['ConsultantBilling']['paid_amount'];
						if($paid<=0){
							$physicianHtml.='0';
							$paid=0;
						}else{
							$physicianHtml.=round($paid);
						}
						$physicianHtml.=$formHelper->hidden("Billing.Consultant.".$consultant_id.".paid_amount",array('value' => $numberHelper->format($paid,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'class'=>'paid_'.$consultantServiceId.'-'.$consultant_id,'style'=>'text-align:right;'));
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
			$surgeryRCost=0;$totalOtServiceCharge=0;$paidAmt=0;
			$surgeryNameKey = key($uniqueSlot);
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
			$paidAmt=$surgeryRCost-($uniqueSlot['paid_amount']+$uniqueSlot['discount']);
			$disabled='';
			if(round($paidAmt)<=0){
				$disabled='disabled';
				$class='chk_child_paid'	;
			}else{
				$class='chk_child'	;
			}
			if($patient['Patient']['payment_category']!='cash' && $uniqueSlot['validity']> 1 ){
					$lastSection = '';
					$surgeryHtml.='<div>';
					$surgeryHtml.='<li>';
					$surgeryHtml.='<div align="center" class="tdBorder" style=" float: left;">';
					$surgeryHtml.=$formHelper->input("Billing.Surgery.".$uniqueSlot['opt_id'].".valChk",array('type'=>'checkbox','id'=>"surgery_$surgeryServiceId-".$uniqueSlot['opt_id'],$disabled,'class'=>"service_$surgeryServiceId ".' '.$class,'value'=>$paidAmt));
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
						$surgeryHtml.='<div align="center" valign="top" class="chldDiv8">&nbsp;</div>';
						$surgeryHtml.='</li>';
						$surgeryHtml.='</div>';
						$v++;
		}
		//if surgery is package
		if($uniqueSlot['validity']> 1){
					$surgeryHtml.='<div>';
					$surgeryHtml.='<li>';
					$surgeryHtml.='<div align="center" class="tdBorder" style=" float: left;">';
					$surgeryHtml.=$formHelper->input("Billing.Surgery.".$uniqueSlot['opt_id'].".valChk",array('type'=>'checkbox','id'=>"surgery_$surgeryServiceId-".$uniqueSlot['opt_id'],$disabled,'class'=>"service_$surgeryServiceId".' '.$class,'value'=>$paidAmt));
					$surgeryHtml.='</div>';
					$surgeryHtml.='<div class="tdBorderRt chldDiv1">';					
					$surgeryHtml.=$uniqueSlot['TariffList']['name'];
					//$splitDate = explode(" ",$uniqueSlot['start']);
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
		            $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".discount",array('value' =>$uniqueSlot['discount'],'class'=>"discount_$surgeryServiceId-".$uniqueSlot['opt_id'],'legend'=>false,'label'=>false));
					$surgeryHtml.='<br><br>'.isset($uniqueSlot['discount'])?round($uniqueSlot['discount']):'0';
		            $surgeryHtml.='</div>';
		            $surgeryHtml.='<div align="center" valign="top" class="chldDiv8" >';
		            $paid=round($uniqueSlot['paid_amount']);
		            if($paid<=0){
						$surgeryHtml.='<br><br>0';
						$paid=0;
					}else{
						$surgeryHtml.='<br><br>'.$paid;
					}
		            $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".paid_amount",array('value' => $numberHelper->format($paid,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'class'=>"paid_$surgeryServiceId-".$uniqueSlot['opt_id'],'style'=>'text-align:right;'));
		            
		            $surgeryHtml.='</div>';
		            $surgeryHtml.='</li>';
		            $surgeryHtml.='</div>';
				}else{
					 $surgeryHtml.='<div>';
					 $surgeryHtml.='<li>';
					 $surgeryHtml.='<div align="center" class="tdBorder" style=" float: left;">';
					 $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".editAmt",array('id'=>'txt_'.$uniqueSlot['opt_id'],$disabled,'class'=>'textAmt','value' =>$paidAmt,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
					 $surgeryHtml.=$formHelper->input("Billing.Surgery.".$uniqueSlot['opt_id'].".valChk",array('type'=>'checkbox','id'=>"surgery_$surgeryServiceId-".$uniqueSlot['opt_id'],$disabled,'class'=>"service_$surgeryServiceId".' '.$class,'value'=>$paidAmt));
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
					  
					 /*$surgeryHtml.=$uniqueSlot['name'].'('.$uniqueSlot['start'].')</br>';
					 $surgeryHtml.='&nbsp;&nbsp;&nbsp;&nbsp;<b>Surgeon Charges</b>' ;
					 $surgeryHtml.='<i> ('.$uniqueSlot['doctor'].')</i>';
					 $surgeryHtml.=($uniqueSlot['anaesthesist_cost'])?'<br/>&nbsp;&nbsp;&nbsp;&nbsp;<b>Anaesthesia Charges</b>':'' ;
					 $surgeryHtml.=($uniqueSlot['anaesthesist_cost'])?'<i> ('.$uniqueSlot['anaesthesist'].')</i>':'';
					 $surgeryHtml.='<br/>&nbsp;&nbsp;&nbsp;&nbsp;<b>OT Charges</b>';*/

					 
					 //EOF anaesthesia charges
					 //$splitDate = explode(" ",$uniqueSlot['start']);
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
		          	    foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
		          	    	$surgeryHtml.='<br>'.$charge;		          	    	
		          	    }
		          	    	
		          	   /* if($uniqueSlot['anaesthesist_cost']){
		            	$anaeCost = "<br>".$uniqueSlot['anaesthesist_cost'] ;
		            	$anaeUnit = "<br>1" ;
			            }
			            if($uniqueSlot['ot_charges']){
			            	$otCost = "<br>".$uniqueSlot['ot_charges'] ;
			            	$otUnit = "<br>1" ;
			            }
		            $surgeryHtml.="<br>".$uniqueSlot[cost];
		            $surgeryHtml.=(!empty($uniqueSlot['anaesthesist_cost']))?"<br>".$uniqueSlot['anaesthesist_cost']:'';
		            $surgeryHtml.=(!empty($uniqueSlot['ot_charges']))?"<br>".$uniqueSlot['ot_charges']:'';*/
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
		          	    $totalOtServiceCharge=0;
		            		foreach($uniqueSlot['ot_extra_services'] as $name=>$charge){
		            			$surgeryHtml.='<br>'.$charge;
		            			$totalOtServiceCharge = $totalOtServiceCharge + $charge;
		            		}
		            	
			           /* $totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost']+$uniqueSlot['surgeon_cost']+$uniqueSlot['asst_surgeon_one_charge']+
			            $uniqueSlot['asst_surgeon_two_charge']+$uniqueSlot['anaesthesist_cost']+$uniqueSlot['cardiologist_charge']+$uniqueSlot['ot_assistant']+
			            $uniqueSlot['ot_charges']+$uniqueSlot['extra_hour_charge'] + $totalOtServiceCharge;*/
			        $surgeryHtml.='</div>';
		            $surgeryHtml.='<div align="center" valign="top" class="chldDiv7" ><br><br>';
		            $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".discount",array('value' =>$uniqueSlot['discount'],'class'=>"discount_$surgeryServiceId-".$uniqueSlot['opt_id'],'legend'=>false,'label'=>false));
					$surgeryHtml.=isset($uniqueSlot['discount'])?round($uniqueSlot['discount']):'0';
		            $surgeryHtml.='</div>';
		            $surgeryHtml.='<div align="center" valign="top" class="chldDiv8" >';
		            $paid=round($uniqueSlot['paid_amount']);
		            if($paid<=0){
						$surgeryHtml.='<br><br>0';
						$paid=0;
					}else{
						$surgeryHtml.='<br><br>'.$paid;
					}
		            $surgeryHtml.=$formHelper->hidden("Billing.Surgery.".$uniqueSlot['opt_id'].".paid_amount",array('value' => $numberHelper->format($paid,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'class'=>"paid_$surgeryServiceId-".$uniqueSlot['opt_id'],'style'=>'text-align:right;'));
		            
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
			/*foreach($wardServicesDataNew as $keyUnset=>$uniqueSlot){
				$wardNameKey = key($uniqueSlot);
				if($wardNameKey =='start'){
					unset($wardServicesDataNew[$keyUnset]);
				}else{
					$newWardArray[$wardNameKey]=$uniqueSlot[$wardNameKey];
				}

			}*/
				
				
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
					$paidAmt=$wardRCost-$uniqueSlot['paid_amount']-$uniqueSlot['discount'];
					if(round($paidAmt)<=0){
						$disable='disabled';
						$class='chk_child_paid'	;
					}else{
						$class='chk_child'	;
					}
					/*if($uniqueSlot['paid_amount']>0){
						$class.=' chk_child_paid';
					}*/
					//if($patient['Patient']['payment_category']!='cash'){
						//if($conservativeCount==0) {
							//$conservativeDateRange = '('.$inDate.'-'.$outDate.')' ;								
							/*$roomHtml.='<script>';
							 	$roomHtml.=$('#firstConservativeText').html("'.$conservativeDateRange.'");
								$('#first_conservative_cost').html("<?php echo 'Conservative Charges '.$conservativeDateRange; ?>");
								$roomHtml.='</script>';*/								
							//}
							//$conservativeCount++;
							/*if($lastSection !='Conservative Charges'){
				
							$roomHtml.='<div align="center" class="tdBorder" style=" float: left;">';
							$roomHtml.=$formHelper->input("Billing.RoomTariff.".$wardId.".valChk",array('type'=>'checkbox',$disable,'id'=>"ward_$wardServiceId-$wardId",'class'=>$class.' '.'service_'.$wardServiceId,'value'=>$paidAmt));
							$roomHtml.='</div>';
							$roomHtml.='<div class="tdBorderRt chldDiv1"><i><strong>Conservative Charges</strong>';
							$roomHtml.= '('.$inDate.'-'.$outDate.')' ;
							$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".editAmt",array('id'=>'txt_'.$wardId,$disabled,'class'=>'textAmt','value' =>$wardRCost,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
							$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".name",array('value' => $uniqueSlot['name'],'legend'=>false,'label'=>false));
							$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".discount",array('value' => $uniqueSlot['discount'],'class'=>"discount_$wardServiceId-$wardId",'legend'=>false,'label'=>false));
							$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".amount",array('value' => $wardRCost,'legend'=>false,'label'=>false));
							$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".id",array('value' =>$wardId,'legend'=>false,'label'=>false));
							$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".service_id",array('value' => $wardServiceId,'legend'=>false,'label'=>false));
							$roomHtml.='</i></div>';
							if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
									$roomHtml.='<div align="center" class="tdBorderRt chldDiv2">&nbsp;</div>';
								}
								$roomHtml.='<div align="center" class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.'">&nbsp';
								$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".name",array('value' => 'Conservative Charges','legend'=>false,'label'=>false));
								$roomHtml.='</div>';
								$roomHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv4" >&nbsp;</div>';
								$roomHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5" >&nbsp;</div>';
								$roomHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6">&nbsp;</div>';
								$roomHtml.='<div align="center" valign="top" class="chldDiv8">&nbsp;</div>';
								$roomHtml.='</li>';
								$roomHtml.='</div><br>';
			          	}*/
			          	//$v++;
			         // }else{
			          
			          $roomHtml.='<div align="center" class="tdBorder" style=" float: left;">';
			          $roomHtml.=$formHelper->input("Billing.RoomTariff.".$wardId.".valChk",array('type'=>'checkbox',$disable,'id'=>"ward_$wardServiceId-$wardId",'class'=>$class.' '.'exclude_discount service_'.$wardServiceId,'value'=>$paidAmt-$uniqueSlot['discount']));
			          $roomHtml.='</div>';
			          $roomHtml.='<div class="tdBorderRt chldDiv1">';
			          $roomHtml.=$uniqueSlot['name'].' ('.$inDate.'-'.$outDate.')';
			          $roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".editAmt",array('id'=>'txt_'.$wardId,$disabled,'class'=>'textAmt','value' =>$wardRCost,'legend'=>false,'label'=>false,'style'=>"width:75px; padding:2px"));
					  $roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".name",array('value' => $uniqueSlot['name'],'legend'=>false,'label'=>false));
					  $roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".discount",array('value' => $uniqueSlot['discount'],'class'=>"discount_$wardServiceId-$wardId",'legend'=>false,'label'=>false));
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
			   			$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".discount",array('value' => $uniqueSlot['discount'],'class'=>"discount_$wardServiceId-$wardId",'legend'=>false,'label'=>false));
					    $roomHtml.=round($uniqueSlot['discount']);
			   			$roomHtml.='</div>';
			   			$roomHtml.='<div align="center" valign="top" class="chldDiv8">';
			   			$paid=$uniqueSlot['paid_amount']-$uniqueSlot['discount'];
			   			if($paid<=0){
							$roomHtml.='0';
							$paid=0;
						}else{
			   				$roomHtml.=round($paid);
			   			}
			   			$roomHtml.=$formHelper->hidden("Billing.RoomTariff.".$wardId.".paid_amount",array('value' => $numberHelper->format($paid,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'class'=>"paid_$wardServiceId-$wardId",'legend'=>false,'label'=>false,'style'=>'text-align:right'));
			   			$roomHtml.='</div>';
			   			$roomHtml.='</li>';
			   			$roomHtml.='</div><br>';
			   			$v++;
			          //}
			          
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
			$paidAmt=$cost-($nursingService['paid_amount']+$nursingService['discount']);
			if(round($paidAmt)<=0){
				$disable='disabled';
				$class='chk_child_paid'	;
			}else{
				//$disable='disabled';
				//$class='chk_child_mandatory'	;
				$class='chk_child';
			}
				$mandatoryHtml.=$formHelper->input("Billing.Mandatory.".$nursingService['service_bill_id'].".valChk",array('type'=>'checkbox','id'=>'mandatory_'.$mandatoryKey.'-'.$nursingService['service_bill_id'],$disable ,'class'=>$class.' '.'service_'.$mandatoryKey,'label'=>false,'div'=>false,'value'=>$paidAmt));
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
				$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".discount",array('value' => $nursingService['discount'],'class'=>'discount_'.$mandatoryKey.'-'.$nursingService['service_bill_id'],'legend'=>false,'label'=>false));
		 		$mandatoryHtml.=round($nursingService['discount']);
				$mandatoryHtml.='</div>';
				$mandatoryHtml.='<div align="center" valign="top" class="chldDiv8">';
				$paidMan=($nursingService['paid_amount']);
				if($paidMan<=0){
					$mandatoryHtml.='0';
					$paidMan=0;
				}else{
					$mandatoryHtml.=round($paidMan);
				}
				$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.".$nursingService['service_bill_id'].".paid_amount",array('value' => $numberHelper->format($paidMan,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'class'=>'paid_'.$mandatoryKey.'-'.$nursingService['service_bill_id'],'style'=>'text-align:right;'));
				
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
					//if($tariffDocListId!=$nursingService['tariff_list_id'] && $tariffNurseListId!=$nursingService['tariff_list_id']){
					$mandatoryHtml.='<div>';
					$mandatoryHtml.='<li>';$disable='';
					$docAmt=$totalWardDays*$doctorRate;
					$paidDocAmt=$docAmt-($doctorPaidCharges+$doctorDiscount);					
					if(round($paidDocAmt)<=0){
						$disable='disabled';
						$class='chk_child_paid'	;
					}else{
						//$disable='disabled';
						//$class='chk_child_mandatory'	;
						$class='chk_child';
					}
					/*if($doctorPaidCharges>0){
						$class.=' chk_child_paid';
					}*/
					$mandatoryHtml.='<div align="center" class="tdBorder" style="float: left;">';
					$mandatoryHtml.=$formHelper->input("Billing.Mandatory.doctor_charges.valChk",array('type'=>'checkbox',$disable,'id'=>'mandatory_'.$mandatoryKey.'-doc','class'=>$class.' '.'exclude_discount service_'.$mandatoryKey , 'value'=>$paidDocAmt));
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
			 		//echo $totalWardDays;
			 		$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.unit",array('value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
			 		//echo $this->Number->format($doctorRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
			 		$mandatoryHtml.=$doctorRate;
				 	$mandatoryHtml.='</div>';
				 	$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv5" >';
				 	//echo $doctorRate;
				 	$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.rate",array('value' => $doctorRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
				 	$mandatoryHtml.=$totalWardDays;
				 	$mandatoryHtml.='</div>';
				 	$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6" >';
				 	//echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
				 	$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.amount",array('value' => $numberHelper->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
				 	//echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
				 	$mandatoryHtml.=$numberHelper->format($totalWardDays*$doctorRate);
				 	$totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$doctorRate);
				 	$mandatoryHtml.='</div>';
				 	$mandatoryHtml.='<div align="center" valign="top" class="chldDiv7">';
				 	$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.discount",array('value' => $doctorDiscount,'class'=>'discount_'.$mandatoryKey.'-doc','legend'=>false,'label'=>false));
		 		    $mandatoryHtml.=round($doctorDiscount);
				 	$mandatoryHtml.='</div>';
				 	$mandatoryHtml.='<div align="center" valign="top" class="chldDiv8">';
				 	$paidDoc=$doctorPaidCharges;
				 	if(round($paidDoc)<=0){
				 		$mandatoryHtml.='0';
				 		$paidDoc=0;
				 	}else{
				 		$mandatoryHtml.=round($paidDoc);
				 	}
				 	$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.doctor_charges.paid_amount",array('value' => $numberHelper->format($paidDoc,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'class'=>'paid_'.$mandatoryKey.'-doc','style'=>'text-align:right;'));
				 	
				 	$mandatoryHtml.='</div>';
				 	$mandatoryHtml.='</li>';
				 	$mandatoryHtml.='</div><br>';
				 	}
				 	
				 	if($nurseFlag==0){
	
				 	//Nursing Charges
				 	$nurseRCost=$totalWardDays*$nursingRate;$disable='';
				 	$paidNurseAmt=$nurseRCost-($nursePaidCharges+$nurseDiscount);
				 	if(round($paidNurseAmt)<=0){
						$disable='disabled';
						$class='chk_child_paid'	;
					}else{
						//$disable='disabled';
						//$class='chk_child_mandatory'	;
						$class='chk_child';
					}
					/*if($nursePaidCharges>0){
						$class.=' chk_child_paid';
					}*/
				 		
				 	$mandatoryHtml.='<div>';
				 	$mandatoryHtml.='<li>';
				 	$mandatoryHtml.='<div align="center" class="tdBorder" style="float: left;">';
				 	$mandatoryHtml.=$formHelper->input("Billing.Mandatory.nursing_charges.valChk",array('type'=>'checkbox',$disable,'id'=>'mandatory_'.$mandatoryKey.'-nurse','class'=>$class.' '.'exclude_discount service_'.$mandatoryKey,'value'=>$paidNurseAmt));
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
						//$mandatoryHtml.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][moa_sr_no]",'value' => $nursingService['moa_sr_no'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
						$mandatoryHtml.='</div>';
					}
					$mandatoryHtml.='<div align="center" class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.';">';
					$mandatoryHtml.=$nursingChargesData['TariffList']['cghs_code'];
					//$mandatoryHtml.=$formHelper->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $nursingChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));
					$mandatoryHtml.='--</div>';
					$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv4">';
					//echo $totalWardDays;
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.unit",array('value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
					//echo $this->Number->format(($nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$mandatoryHtml.=$numberHelper->format($nursingRate);
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='<div class="tdBorderRt chldDiv5" align="center" valign="top">';
					//echo $nursingRate;
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.rate",array('value' => $nursingRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					$mandatoryHtml.=$totalWardDays;
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='<div align="center" valign="top" class="tdBorderRt chldDiv6" >';
					//echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.amount",array('value' => $numberHelper->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					//echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$mandatoryHtml.=$numberHelper->format($totalWardDays*$nursingRate);
					$totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$nursingRate);
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='<div align="center" valign="top" class="chldDiv7">';
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.discount",array('value' => $nurseDiscount,'class'=>'discount_'.$mandatoryKey.'-nurse','legend'=>false,'label'=>false));
		 		    $mandatoryHtml.=round($nurseDiscount);
					$mandatoryHtml.='</div>';
					$mandatoryHtml.='<div align="center" valign="top" class="chldDiv8">';
					$paidNurse=$nursePaidCharges;
					if($paidNurse){
						$mandatoryHtml.=round($paidNurse);
						$paidNurse=0;
					}else{
						$mandatoryHtml.='0';
					}
					$mandatoryHtml.=$formHelper->hidden("Billing.Mandatory.nursing_charges.paid_amount",array('value' =>$paidNurse,'legend'=>false,'label'=>false,'class'=>'paid_'.$mandatoryKey.'-nurse','style'=>'text-align:right;'));
					
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
           			$paidAmt=$labCost['LaboratoryTestOrder']['amount']-($labCost['LaboratoryTestOrder']['paid_amount']+$labCost['LaboratoryTestOrder']['discount']);
           			$disable='';
           			if(round($paidAmt)<=0){
           				$disable='disabled';
						$class='chk_child_paid'	;
					}else{
						$class='chk_child'	;
					}           			
           			$labHtml.=$formHelper->input("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".valChk",array('type'=>'checkbox','id'=>'laboratory_'.$laboratoryKey.'-'.$labCost['LaboratoryTestOrder']['id'],$disable,'class'=>$class.' '.'service_'.$laboratoryKey,'value'=>$paidAmt));
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
           			$labHtml.=$formHelper->hidden("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".discount",array('value' =>$labCost['LaboratoryTestOrder']['discount'],'class'=>'discount_'.$laboratoryKey.'-'.$labCost['LaboratoryTestOrder']['id'],'legend'=>false,'label'=>false));
           			$labHtml.=round(($labCost['LaboratoryTestOrder']['discount']));
           			$labHtml.='</div>';
           			$labHtml.='<div align="center" valign="top" class="chldDiv8">';
           			$paidLab=($labCost['LaboratoryTestOrder']['paid_amount']);
           			if($paidLab<=0){
           				$labHtml.='0';
           				$paidLab=0;	
           			}else{
           				$labHtml.=round($paidLab);
           			}
           			$labHtml.=$formHelper->hidden("Billing.laboratory.".$labCost['LaboratoryTestOrder']['id'].".paid_amount",array('value' => $paidLab,'class'=>'paid_'.$laboratoryKey.'-'.$labCost['LaboratoryTestOrder']['id'],'legend'=>false,'label'=>false));
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
	//if($radCost['RadiologyTestOrder']['test_done']=='true'){
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
	$paidAmt=$raCost-($radCost['RadiologyTestOrder']['paid_amount']+$radCost['RadiologyTestOrder']['discount']);
	$disable='';
	if(round($paidAmt)<=0){
		$disable='disabled';
		$class='chk_child_paid'	;
	}else{
		$class='chk_child'	;
	}   
	$radHtml.=$formHelper->input("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".valChk",array('type'=>'checkbox','id'=>'radiology_'.$radiologyKey.'-'.$radCost['RadiologyTestOrder']['id'],$disable,'class'=>$class.' '.'service_'.$radiologyKey,'value'=>$paidAmt));
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
	$radHtml.=$formHelper->hidden("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".discount",array('value' =>$radCost['RadiologyTestOrder']['discount'],'class'=>'discount_'.$radiologyKey.'-'.$radCost['RadiologyTestOrder']['id'],'legend'=>false,'label'=>false));
	$radHtml.=round($radCost['RadiologyTestOrder']['discount']);
	$radHtml.='</div>';
	$radHtml.='<div align="center" valign="top" class="chldDiv8">';
	$paidRad=($radCost['RadiologyTestOrder']['paid_amount']);
	if($paidRad<=0){
		$radHtml.='0';
		$paidRad=0;
	}else{
		$radHtml.=round($paidRad);
	}
	$radHtml.=$formHelper->hidden("Billing.radiology.".$radCost['RadiologyTestOrder']['id'].".paid_amount",array('value' =>$paidRad,'class'=>'paid_'.$radiologyKey.'-'.$radCost['RadiologyTestOrder']['id'],'legend'=>false,'label'=>false));
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
	
	/*function clinicalService($patient,$resetNursingServices,$Clinicalkey,$formHelper,$numberHelper,$hideCGHSCol){
#pr($resetNursingServices);exit;
//EOF pankaj
echo $formHelper->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Nursing Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
foreach($resetNursingServices as $resetNursingServicesName=>$nursingService){
	$k++;
	$totalUnit= $nursingService['qty'];
	$srNo++;

	echo $formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][name]",'value' => $nursingService['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
	$clinical.='<div >';
	$clinical.='<li>';
	$clinical.='<div align="center" class="tdBorder" style="float: left;">';
	if(!empty($nursingService['cost'])){
				$cost=$nursingService['qty']*$nursingService['cost'];
			}else{
				$cost=0;
			}
			$clinical.=$formHelper->input($nursingService['name'],array('type'=>'checkbox','id'=>'clinical_'.$Clinicalkey.'-'.$nursingService['tariff_list_id'],'name'=>'clinical_'.$Clinicalkey,'class'=>'chk_child clinical_'.$Clinicalkey,'label'=>false,'div'=>false,'value'=>$cost));
			$clinical.='</div>';
			$clinical.='<div class="tdBorderRt" style=" float: left; padding: 0px 32px 0px 0px;  width: 25%;">';
			$clinical.=$nursingService['name'];
			$clinical.='</div>';
			if(strtolower($patient['TariffStandard']['name'])!=Configure::read('privateTariffName')) { //7 for private patient only
            	$clinical.='<div align="center" class="pvt tdBorderRt" style="float: left; width: 5%;"> ';
            	if($nursingService['moa_sr_no']!='')
            		$clinical.=$nursingService['moa_sr_no'];
            	else $clinical.='&nbsp;';
            	$clinical.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][moa_sr_no]",'value' => $nursingService['moa_sr_no'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            	$clinical.='</div>';
            }
            $clinical.='<div align="center" class="tdBorderRt" style="'.$hideCGHSCol.'; float: left; padding: 0px 97px 0px 0px; width: 5%;">';
            if($nursingService['nabh_non_nabh']!='')
            	$clinical.=$nursingService['nabh_non_nabh'];
            else $clinical.='&nbsp;';
            $clinical.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][nabh_non_nabh]",'value' => $nursingService['nabh_non_nabh'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            $clinical.='</div>';
            $clinical.='<div align="center" valign="top" class="tdBorderRt" style="float: left; padding: 0px 82px 0px 10px; width: 5%;">';
            $clinical.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][rate]",'value' => $nursingService['cost'],'legend'=>false,'label'=>false,'id' => 'nursing_service_rate','style'=>'text-align:right;'));
            $clinical.=$numberHelper->format($nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            $clinical.='</div>';
            $clinical.='<div align="center" valign="top" class="tdBorderRt" style="float: left; padding: 0px 97px 0px 0px; width: 5%;">';
            if($totalUnit<1) $totalUnit=1;
            $clinical.=$totalUnit;
            $clinical.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => $totalUnit,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
            $clinical.='</div>';
            $clinical.='<div align="center" valign="top" style="float: left; padding: 0px 97px 0px 10px; width: 5%;">';
            $totalNursingCharges1=0;
            $clinical.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $numberHelper->format($totalUnit*$nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'nursing_service_amount','style'=>'text-align:right;'));
            $clinical.=$numberHelper->format($totalUnit*$nursingService['cost']);
            //echo $this->Number->format($totalUnit*$nursingService['cost']);
            $totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];
            $clinical.='</div>';
            $clinical.='</li>';
            $clinical.='</div>';
            $clinical.='<br><br>';
            }
            return $clinical;
	}*/
	
	function dynamicService($patient,$dynamicNursingServices,$dynamickey,$formHelper,$numberHelper,$hideCGHSCol,$category){
	foreach($dynamicNursingServices as $resetNursingServicesName=>$nursingService){
		$k++;//debug($nursingService);
		$totalUnit= $nursingService['qty'];
		$srNo++;$paidAmount=0;
		//$dynamic.='<div >';
		$dynamic.='<li>';
		$dynamic.='<div align="center" class="tdBorder" style="float: left;">';
		if(!empty($nursingService['cost'])){
					$cost=$nursingService['qty']*$nursingService['cost'];
		}else{
					$cost=0;
		}
		$paidAmount=$cost-($nursingService['paid_amount']+$nursingService['discount']);
		$disabled='';
		if(round($paidAmount)<=0 /*|| $cost==$nursingService['discount']*/){
			$disabled='disabled';
			$class='chk_child_paid'	;
		}else{
			$class='chk_child'	;
		}		
		$dynamic.=$formHelper->input("Billing.".$category.".".$nursingService['service_bill_id'].".valChk",array('type'=>'checkbox','id'=>$category.'_'.$dynamickey.'-'.$nursingService['service_bill_id'],$disabled,'class'=>$class.' '.'service_'.$dynamickey,'label'=>false,'div'=>false,'value'=>$paidAmount));
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
			//$dynamic.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][moa_sr_no]",'value' => $nursingService['moa_sr_no'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			$dynamic.='</div>';
		}
		$dynamic.='<div align="center" class="tdBorderRt chldDiv3" style="'.$hideCGHSCol.';">';
		if($nursingService['nabh_non_nabh']!='')
			$dynamic.=$nursingService['nabh_non_nabh'];
		else $dynamic.='&nbsp;';
		//$dynamic.=$formHelper->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][nabh_non_nabh]",'value' => $nursingService['nabh_non_nabh'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
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
		//echo $this->Number->format($totalUnit*$nursingService['cost']);
		$totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];
		$dynamic.='</div>';
		$dynamic.='<div align="center" valign="top" class="chldDiv7" >';
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".discount",array('value' =>$nursingService['discount'],'class'=>'discount_'.$dynamickey.'-'.$nursingService['service_bill_id'],'legend'=>false,'label'=>false));
		$dynamic.=round($nursingService['discount']);
		$dynamic.='</div>';
		$dynamic.='<div align="center" valign="top" class="chldDiv8" >';
		$dymic=round($nursingService['paid_amount']);
		if($dymic<=0){
			$dynamic.='0';
			$dymic=0;
		}else{
			$dynamic.=($dymic);
		}
		$dynamic.=$formHelper->hidden("Billing.".$category.".".$nursingService['service_bill_id'].".paid_amount",array('value' =>$dymic,'class'=>'paid_'.$dynamickey.'-'.$nursingService['service_bill_id'],'legend'=>false,'label'=>false));
		$dynamic.='</div>';
		$dynamic.='</li>';
		//$dynamic.='</div>';
		//$dynamic.='<br>';
		}
            return $dynamic;
	}
?>