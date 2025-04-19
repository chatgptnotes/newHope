<?php echo $this->Html->css(array('internal_style'));
#pr($finalBillingData);exit;
#echo $totalWardCharges;exit;
?>
<style>
body {
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #E7EEEF;
}

.boxBorder {
	border: 1px solid #3E474A;
}

.boxBorderBot {
	border-bottom: 1px solid #3E474A;
}

.boxBorderRight {
	border-right: 1px solid #3E474A;
}

.tdBorderRtBt {
	border-right: 1px solid #3E474A;
	border-bottom: 1px solid #3E474A;
}

.tdBorderBt {
	border-bottom: 1px solid #3E474A;
}

.tdBorderTp {
	border-top: 1px solid #3E474A;
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
}

.columnPad {
	padding: 5px;
}

.columnLeftPad {
	padding-left: 5px;
}

.tbl {
	background: #CCCCCC;
}

.tbl td {
	background: #FFFFFF;
}

.totalPrice {
	font-size: 14px;
}

.adPrice {
	border: 1px solid #CCCCCC;
	border-top: 0px;
	padding: 3px;
}
</style>
<table width="800" border="0" cellspacing="0" cellpadding="0"
	style="margin-bottom: 20px;" align="center">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="100%" align="center" valign="top" class="heading"><strong><?php echo 'Claim Details';?> </strong></td>
	</tr>
</table>
<?php echo $this->Form->create('billings',array('controller'=>'billings','action'=>'saveGenerateReceipt','type' => 'file','id'=>'ConsultantBilling','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('Billing.patient_id',array('value'=>$patient['Patient']['id']));
echo $this->Form->hidden('Billing.bill_number',array('value'=>$billNumber));
?>
<table width="800" border="0" cellspacing="0" cellpadding="0"
	align="center" class="boxBorder">
	
	<tr>
		<td width="100%" align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="5"
				class="tdBorderTpBt">
				<tr>
					<td width="50" align="center" class="tdBorderRtBt">Sr. No.</td>
					<td width="80" align="center" class="tdBorderRtBt">CDM</td>
					<td width="80" align="center" class="tdBorderRtBt">CPT/ICD</td>
					<td align="center" class="tdBorderRtBt">Item</td>
					<td width="80" align="center" class="tdBorderRtBt" style="display:<?php echo $hideCGHSCol ;?>">CGHS
						Code No.</td>
					<td width="65" align="center" class="tdBorderRtBt">Rate</td>
					<td width="65" align="center" class="tdBorderRtBt">Qty.</td>
					<td width="100" align="center" class="tdBorderBt">Amount</td>
				</tr>
				<?php $srNo=0;?>
				<?php if($patient['Patient']['payment_category']!='cash'){?>
				<tr>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<!--<td class="tdBorderRt" style="font-size:12px;"><strong><i>Conservative Charges</i></strong></td>
            -->
					<td class="tdBorderRt" style="font-size: 12px;"><i><strong>Conservative
								Charges </strong><span id="firstConservativeText"></span> </i> <?php 
								echo $this->Form->hidden('',array('name'=>"data[Billing][0][name]",'id'=>'first_conservative_cost','value' => 'Conservative Charges','legend'=>false,'label'=>false));
								$v++ ;
								?></td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong>
					</td>
					<td align="right" valign="top" class="tdBorderRt">&nbsp;</td>

					<td align="right" valign="top"><strong>&nbsp;</strong></td>
				</tr>

				<?php $lastSection='Conservative Charges';?>
				<?php }?>
				<?php if($registrationRate!='' && $registrationRate !=0){

					$srNo++;
					?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt"><?php echo $registrationChargesData['TariffList']['cdm'];
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $registrationChargesData['TariffAmount']['moa_sr_no'],
		          		'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
		          	?>
					</td>
					<td align="center" class="tdBorderRt"><?php echo $registrationChargesData['TariffList']['cbt'];?>
					</td>
					<td class="tdBorderRt">MRN Charges</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 

					echo $registrationChargesData['TariffList']['cghs_code'];
					?>
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $registrationChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));

					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
					echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Registration Charges','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					#echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					echo '1';
					?>
					</td>

					<td align="right" valign="top"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_amount','style'=>'text-align:right;'));
					echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
				</tr>
				<?php }?>

				<?php $totalCost=0;$v=1;
				foreach ($cCArray as $cBilling){
	          foreach($cBilling as $consultantBillingDta){
	          	foreach($consultantBillingDta as $consultantBilling){#pr($consultantBilling);exit;
	          	$v++;$srNo++;
	          	#pr($consultantBilling);exit;
	          	?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td class="tdBorderRt"><?php //if($consultantBilling['ConsultantBilling']['category_id'] == 0){
	          	/*if($consultantBilling['ConsultantBilling']['charges_type']=='Consultant'){
	          	 echo 'Consultant Visit Charges';
	            	}else
	            	if($consultantBilling['ConsultantBilling']['charges_type']=='Surgeon'){
	            		echo 'Surgeon Charges';
	            	}else
		            if($consultantBilling['ConsultantBilling']['charges_type']=='Other'){
	            		echo 'Consultant Other Charges';
	            	}else
		            if($consultantBilling['ConsultantBilling']['charges_type']=='Anaesthesia'){
	            		echo 'Anaesthesia Charges';
	            	}else{
						echo 'Consultant Visit Charges';
	            	}//Anaesthesia
	            	*/
	          		echo $consultantBilling[0]['ServiceCategory']['name'];
	          		$completeConsultantName = $consultantBilling[0]['Initial']['name'].$consultantBilling[0]['Consultant']['first_name'].' '.$consultantBilling[0]['Consultant']['last_name'];
	          		echo '<br>&nbsp;&nbsp;<i>'.$completeConsultantName.'</i> ';
	          		$sDate = explode(" ",$consultantBilling[0]['ConsultantBilling']['date']);
	          		$lRec = end($consultantBilling);
	          		$eDate = explode(" ",$lRec['ConsultantBilling']['date']);

	          		if($patient['Patient']['admission_type']=='OPD'){
	   					echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).')';
	   					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][0][name]",'value' => $completeConsultantName.' ('.$this->DateFormat->formatDate2Local($sDate[0],Configure::read('date_format')).')','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
	            	}else{
	            		echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).' - '.$this->DateFormat->formatDate2Local($lRec['ConsultantBilling']['date'],Configure::read('date_format')).')';
	            		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][0][name]",'value' => $completeConsultantName.' ('.$this->DateFormat->formatDate2Local($sDate[0],Configure::read('date_format')).' - '.$this->DateFormat->formatDate2Local($eDate[0],Configure::read('date_format')).')','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
	                }
	                echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $consultantBilling[0]['ServiceCategory']['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));

	                ?></td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">
						<?php echo $consultantBilling[0]['TariffList']['cghs_code'];?>
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => count($consultantBilling),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
					echo $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					$totalCost = $totalCost + ($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling));
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
					echo count($consultantBilling);
					?>
					</td>

					<td align="right" valign="top"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_amount','style'=>'text-align:right;'));
					echo $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
				</tr>

				<?php }
          }

          }
          ?>


				<?php
				foreach ($cDArray as $cBilling){
           foreach($cBilling as $consultantBillingDta){#pr($consultantBilling);exit;
           	foreach($consultantBillingDta as $consultantBilling){#pr($consultantBilling);exit;
           		$v++;$srNo++;
           		?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td class="tdBorderRt"><?php 
					/*if($consultantBilling['ConsultantBilling']['charges_type']=='Consultant'){
					 echo 'Doctor Visit Charges';
            	}else
            	if($consultantBilling['ConsultantBilling']['charges_type']=='Surgeon'){
            		echo 'Surgeon Charges';
            	}else
	            if($consultantBilling['ConsultantBilling']['charges_type']=='Other'){
            		echo 'Doctor Other Charges';
            	}else
	            if($consultantBilling['ConsultantBilling']['charges_type']=='Anaesthesia'){
            		echo 'Anaesthesia Charges';
            	}else{
					echo 'Doctor Visit Charges';
            	}
            	*/

            	echo $consultantBilling[0]['ServiceCategory']['name'];
            	echo '<br>&nbsp;&nbsp;<i>'.$consultantBilling[0]['Initial']['name'].$consultantBilling[0]['DoctorProfile']['doctor_name'].'</i> ';
            	$sDate = explode(" ",$consultantBilling[0]['ConsultantBilling']['date']);
            	$lRec = end($consultantBilling);
            	$eDate = explode(" ",$lRec['ConsultantBilling']['date']);
            	if($patient['Patient']['admission_type']=='OPD'){
            		echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).')';
            		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][0][name]",'value' => $consultantBilling[0]['Initial']['name'].$consultantBilling[0]['DoctorProfile']['doctor_name'].' ('.$this->DateFormat->formatDate2Local($sDate[0],Configure::read('date_format')).')' ,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
   				}else{
            		echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).' - '.$this->DateFormat->formatDate2Local($lRec['ConsultantBilling']['date'],Configure::read('date_format')).')';
            		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][0][name]",'value' => $consultantBilling[0]['Initial']['name'].$consultantBilling[0]['DoctorProfile']['doctor_name'].' ('.$this->DateFormat->formatDate2Local($sDate[0],Configure::read('date_format')).' - '.$this->DateFormat->formatDate2Local($eDate[0],Configure::read('date_format')).')' ,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            	}
            	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $consultantBilling[0]['ServiceCategory']['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));

            	?></td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">
						<?php echo $consultantBilling[0]['TariffList']['cghs_code'];?>
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => count($consultantBilling),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
					echo $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					$totalCost = $totalCost + ($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling));
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
					echo count($consultantBilling);
					?>
					</td>
					<td align="right" valign="top"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_amount','style'=>'text-align:right;'));
					echo $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
				</tr>
				<?php }
          }
          }
          ?>
				<?php //} for end 
          $totalCost = $totalCost+$pharmacy_charges-$pharmacyPaidAmount;//+$ward_charges;

          if($patient['Patient']['admission_type']=='IPD'){
          $totalWardNewCost=0;
          $totalWardDays=0;
          $totalNewWardCharges=0;
          $conservativeCount = 0;
          if(is_array($wardServicesDataNew)){
          	foreach($wardServicesDataNew as $wardDaysKey=>$uniqueSlot){
          		$srNo++;
          		 
          		if(isset($uniqueSlot['name'])){
					$totalWardNewCost = $totalWardNewCost + $uniqueSlot['cost'];
					$v++;
					$lastSection = 'Conservative Charges';
					?>
				<?php if($patient['Patient']['payment_category']!='cash' && $uniqueSlot['validity']> 1 ){
					$lastSection = '';
					?>
				<tr>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td class="tdBorderRt" style="font-size: 12px;"><i><strong>Surgical
								Charges</strong> </i> <?php  
								$endOfSurgery = strtotime($uniqueSlot['surgery_billing_date']." +".$uniqueSlot['validity']." days");
								$startOfSurgery  = $this->DateFormat->formatDate2Local($uniqueSlot['start'],Configure::read('date_format')) ;
		            		echo $surgeryDate = "<i>(".$startOfSurgery."-".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$endOfSurgery),Configure::read('date_format')).")</i>";?>


						<?php 
						echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Surgical Charges $surgeryDate",'legend'=>false,'label'=>false));
						?>
					</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderRt">&nbsp;</td>

					<td align="right" valign="top">&nbsp;</td>
				</tr>
				<?php $v++; 
				}
				//if surgery is package
				if($uniqueSlot['validity']> 1){

				 ?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['moa_sr_no'];?>
					</td>
					<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['cbt'];?>
					</td>
					<td class="tdBorderRt" style="padding-left: 10px;"><?php  
					echo $uniqueSlot['name'];
					//echo '(<i>'.$uniqueSlot['doctor'].'</i>)';

					$splitDate = explode(" ",$uniqueSlot['start']);
					echo "<br><i>(".$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true)."-".
							$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['end'],Configure::read('date_format'),true).")</i>";

					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Surgeon Charges ('.$uniqueSlot['name'].')</br>'.'<i>'.$uniqueSlot['doctor_name'].'</i> ('.$this->DateFormat->formatDate2Local($uniqueSlot['start'],Configure::read('date_format'),true).')','legend'=>false,'label'=>false));
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot['cghs_code'],'legend'=>false,'label'=>false));
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $uniqueSlot['moa_sr_no'],'legend'=>false,'label'=>false));
					?></td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $uniqueSlot['cghs_code'];?>
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 
					//echo '1';
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
					echo $uniqueSlot['cost'];
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					//echo $uniqueSlot['cost'];
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $uniqueSlot['cost'],'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo '1';
					?>
					</td>

					<td align="right" valign="top"><?php 
					//echo $uniqueSlot['cost'];
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $uniqueSlot['cost'],'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $uniqueSlot['cost'];
					$totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost'];
					?>
					</td>
				</tr>

				<?php }else{    ?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['cdm'];?>
					</td>
					<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['cbt'];?>
					</td>
					<td class="tdBorderRt" style="padding-left: 10px;"><?php 
					echo $uniqueSlot['name'].'('.$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true).')</br>';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Charges' ;
					echo '<i> ('.$uniqueSlot['doctor'].','.$uniqueSlot['doctor_education'].')</i>';

					//anaesthesia charges
					echo ($uniqueSlot['anaesthesist_cost'])?'<br/>&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Charges':'' ;
					echo ($uniqueSlot['anaesthesist_cost'])?'<i> ('.$uniqueSlot['anaesthesist'].')</i>':'';
					//EOF anaesthesia charges
					$splitDate = explode(" ",$uniqueSlot['start']);
					if($uniqueSlot['anaesthesist_cost']){
			            	$valueForAnaesthesist = '<br/>&nbsp;&nbsp;&nbsp;&nbsp;Anaesthesia Charges<i> ('.$uniqueSlot['anaesthesist'].')</i>';
			            }else{
			            	$valueForAnaesthesist ='' ;
			            }
			            $valueForSurgeon =  $uniqueSlot['name'].'('.
					            $this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true).')</br>'.
					            '&nbsp;&nbsp;&nbsp;&nbsp;Surgeon Charges <i>('.$uniqueSlot['doctor'].','.
					            $uniqueSlot['doctor_education'].')</i>)'.$valueForAnaesthesist ;

			            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",
			            'value' => $valueForSurgeon,'legend'=>false,'label'=>false));

			            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot['cghs_code'],'legend'=>false,'label'=>false));
			            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $uniqueSlot['moa_sr_no'],'legend'=>false,'label'=>false));
			            ?></td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $uniqueSlot['cghs_code'];?>
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 
					if($uniqueSlot['anaesthesist_cost']){

		            	$anaeCost = "<br>".$uniqueSlot['anaesthesist_cost'] ;
		            	$anaeUnit = "<br>1" ;
		            }

		            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => "<br>1$anaeUnit",'legend'=>false,'label'=>false,'style'=>'text-align:center'));
		            echo "<br>".$uniqueSlot['cost'];
		            echo (!empty($uniqueSlot['anaesthesist_cost']))?"<br>".$uniqueSlot['anaesthesist_cost']:'';
		            ?></td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					$surgonCost = "<br>".$uniqueSlot['cost'].$anaeCost ;
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $surgonCost,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo '<br>1';
					echo ($uniqueSlot['anaesthesist_cost'])?'<br>1':'';
					?>
					</td>

					<td align="right" valign="top"><?php 
					//echo $uniqueSlot['cost'];
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $surgonCost,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo "<br>".$uniqueSlot['cost'];
					echo "<br>".$uniqueSlot['anaesthesist_cost'];
					$totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost']+$uniqueSlot['anaesthesist_cost'];
					?>
					</td>
				</tr>
				<?php 	
					}//EOF package cond for surgery display

          		}else{

					$wardNameKey = key($uniqueSlot);#pr($uniqueSlot[$wardNameKey][0]['cost']);exit;

					$wardCostPerWard = $uniqueSlot[$wardNameKey][0]['cost'];

					$daysCountPerWard=count($uniqueSlot[$wardNameKey]);
					$totalWardNewCost = $totalWardNewCost + (count($uniqueSlot[$wardNameKey]) * $wardCostPerWard);
					$totalWardDays = $totalWardDays + count($uniqueSlot[$wardNameKey][1]['in']);
					$totalWardDaysW = count($uniqueSlot[$wardNameKey]);

					/*************************************************************/
					$date = $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'));
					$splitDateIn = explode(" ",$uniqueSlot[$wardNameKey][0]['in']);
					$splitDateOut = explode(" ",$uniqueSlot[$wardNameKey][$daysCountPerWard-1]['out']);
					#pr( $uniqueSlot[$wardNameKey][1]['in']);exit;

					$inDate= $this->DateFormat->formatDate2Local($uniqueSlot[$wardNameKey][1]['in'],Configure::read('date_format'));//.' '.$splitDateIn[1];
					//echo $inDate;

					$outDate= $this->DateFormat->formatDate2Local($uniqueSlot[$wardNameKey][$daysCountPerWard-1]['out'],Configure::read('date_format'));//.' '.$splitDateOut[1];
					/*************************************************************/

					if($patient['Patient']['payment_category']!='cash'){

				if($conservativeCount==0) {
					$conservativeDateRange = ' ('.$date.'-'.$outDate.')' ;
				 ?>
				<script> 
					 	document.getElementById('firstConservativeText').innerHTML="<?php echo $conservativeDateRange; ?>";
					 	document.getElementById('first_conservative_cost').value="<?php echo 'Conservative Charges '.$conservativeDateRange; ?>"; 
					 </script>
				<?php 
				}
				$conservativeCount++;
				if($lastSection !='Conservative Charges'){
						?>

				<tr>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td class="tdBorderRt" style="font-size: 12px;"><i><strong>Conservative
								Charges</strong> <?php 
								echo ' ('.$inDate.'-'.$outDate.')' ;
								?> </i></td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Conservative Charges'.' ('.$inDate.'-'.$outDate.')','legend'=>false,'label'=>false));
					?>&nbsp;</td>
					<td align="right" valign="top" class="tdBorderRt">&nbsp;</td>

					<td align="right" valign="top">&nbsp;</td>
				</tr>

				<?php }?>
				<?php $v++;?>
				<?php }?>
				<?php //echo $uniqueSlot[$wardNameKey][0]['moa_sr_no'].'here';exit;?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt"><?php echo $uniqueSlot[$wardNameKey][0]['cdm'];
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $uniqueSlot[$wardNameKey][0]['moa_sr_no'],'legend'=>false,'label'=>false));
					?>
					</td>
					<td align="center" class="tdBorderRt"><?php echo $uniqueSlot[$wardNameKey][0]['cbt'];?>
					</td>
					<td class="tdBorderRt"><?php 

					echo $wardNameKey.' ('.$inDate.'-'.$outDate.')';

					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $wardNameKey.' ('.$inDate.'-'.$outDate.')','legend'=>false,'label'=>false));
					?></td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
					$hospitalType = $this->Session->read('hospitaltype');
					if($hospitalType == 'NABH'){
   				echo $uniqueSlot[$wardNameKey][0]['cghs_code'];
   				//echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot[$wardNameKey][0]['cghs_nabh'],'legend'=>false,'label'=>false));
   			}else{
   				echo $uniqueSlot[$wardNameKey][0]['cghs_code'];
   				//echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot[$wardNameKey][0]['cghs_non_nabh'],'legend'=>false,'label'=>false));
   			}
   			?>
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 

					if($hospitalType == 'NABH'){
   				echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot[$wardNameKey][0]['cghs_nabh'],'legend'=>false,'label'=>false));
   			}else{
   				echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot[$wardNameKey][0]['cghs_non_nabh'],'legend'=>false,'label'=>false));
   			}


   			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
   			echo $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
   			?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					//echo $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					$a = 1;
					$total = $totalWardDaysW - $a;
					echo $total;
					?>
					</td>

					<td align="right" valign="top"><?php 
					//echo $this->Number->format(($totalWardDays*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $this->Number->format(($total*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$totalNewWardCharges = $totalNewWardCharges + ($total*$wardCostPerWard);
					?>
					</td>
				</tr>
				<?php $v++;?>

				<?php }?>

				<?php 
				#$totalWardDays=0;
          }
           

          if($totalWardDays>0){
          	$v++;
          	?>
				<?php if($doctorRate!='' && $doctorRate!=0){
					$srNo++;
					?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt"><?php 
					//echo $doctorChargesData['TariffAmount']['moa_sr_no'].'here';exit;
					echo $doctorChargesData['TariffList']['cdm'];
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $doctorChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false));
					?>
					</td>
					<td align="center" class="tdBorderRt"><?php echo $doctorChargesData['TariffList']['cbt'];?>
					</td>
					<td class="tdBorderRt">Doctor Charges <?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Doctor Charges','legend'=>false,'label'=>false));
					?>
					</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
					echo $doctorChargesData['TariffList']['cghs_code'];

					?>
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $doctorChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));

					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));

					echo $forHiddenDoctorRate  = $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?></td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					//echo $doctorRate;
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $forHiddenDoctorRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $totalWardDays;
					?>
					</td>

					<td align="right" valign="top"><?php 
					//echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$doctorRate);
					?>
					</td>
				</tr>
				<?php }?>
				<?php $v++;?>
				<?php if($nursingRate!='' && $nursingRate!=0){
					$srNo++;
					?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt"><?php 
					echo $nursingChargesData['TariffList']['cdm'];
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $nursingChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false));
					?>
					</td>
					<td align="center" class="tdBorderRt"><?php echo $nursingChargesData['TariffList']['cbt'];?>
					</td>
					<td class="tdBorderRt">Nursing Charges <?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Nursing Charges','legend'=>false,'label'=>false));
					?>
					</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
					echo $nursingChargesData['TariffList']['cghs_code'];

					?>
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $nursingChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));

					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
					echo $this->Number->format(($nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					//echo $nursingRate;
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $nursingRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $totalWardDays;
					?>
					</td>

					<td align="right" valign="top"><?php 
					//echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$nursingRate);
					?>
					</td>
				</tr>
				<?php }?>
				<?php }
           }
          }else{$v++;?>
				<?php  if($doctorRate!='' && $doctorRate!=0){
					$srNo++;
					?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt"><?php 
					echo $doctorChargesData['TariffList']['cdm'];
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $doctorChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false));
					?>
					</td>
					<td align="center" class="tdBorderRt"><?php echo $doctorChargesData['TariffList']['cbt'];?>
					</td>
					<td class="tdBorderRt"><?php echo ($patient['TariffList']['name'])?($patient['TariffList']['name']):'Consultation Fee' ;?>
						<?php 
						echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $patient['TariffList']['name'],'legend'=>false,'label'=>false));
						?>
					</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
					echo $doctorChargesData['TariffList']['cghs_code'];

					?>
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $doctorChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));

					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
					echo $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					//echo $doctorRate;
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					//echo $doctorRate;
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $doctorRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo '1';
					?>
					</td>

					<td align="right" valign="top"><?php 
					//echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$totalNewWardCharges = $totalNewWardCharges + ($doctorRate);
					?>
					</td>
				</tr>
				<?php }
          }
           
          $hospitalType = $this->Session->read('hospitaltype');
          $serviceListArray=array();
          $serviceListCountArray=array();
          //$v++;
          $k=0;$totalNursingCharges=0;$v++;

          //BOF pankaj- reset array to service as main key
          $ng=0;$nt=0;
          if($hospitalType == 'NABH'){
					 $nursingServiceCostType = 'nabh_charges';
			  	}else{
			  		 $nursingServiceCostType = 'non_nabh_charges';
			  		  
			  	}
		   	foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){

				$resetNursingServices[$nursingServicesCost['TariffList']['id']]['qty'][] = //$nursingServicesCost['ServiceBill']['morning']+
				//$nursingServicesCost['ServiceBill']['evening']+
				//$nursingServicesCost['ServiceBill']['night'] +
				$nursingServicesCost['ServiceBill']['no_of_times'];
				$resetNursingServices[$nursingServicesCost['TariffList']['id']]['name'] = $nursingServicesCost['TariffList']['name'] ;
				$resetNursingServices[$nursingServicesCost['TariffList']['id']]['cost'] =
				$this->Number->format(
																			$nursingServicesCost['TariffAmount'][$nursingServiceCostType],
		  																	array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));

				//$nursingServicesCost['TariffAmount'][$nursingServiceCostType];
				$resetNursingServices[$nursingServicesCost['TariffList']['id']]['cdm'] = $nursingServicesCost['TariffList']['cdm'];
				$resetNursingServices[$nursingServicesCost['TariffList']['id']]['cbt'] = $nursingServicesCost['TariffList']['cbt'];
				$resetNursingServices[$nursingServicesCost['TariffList']['id']]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code'];


		   	}
		   	 
		   	#pr($resetNursingServices);exit;
	   		//EOF pankaj
		   	#if($patient['Patient']['admission_type']!='OPD')
		   	#echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Nursing Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		   	foreach($resetNursingServices as $resetNursingServicesName=>$nursingService){
		   		$k++;$totalUnit=0;  $srNo++;

		   		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][name]",'value' => $nursingService['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		   		?>

				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt"><?php 
					if($nursingService['cdm']!='')
						echo $nursingService['cdm'];
					else echo '&nbsp;';
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][moa_sr_no]",'value' => $nursingService['cdm'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					?>
					</td>
					<td align="center" class="tdBorderRt"><?php echo $nursingService['cbt'];?>
					</td>
					<td class="tdBorderRt"><?php echo $nursingService['name'];?></td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
					if($nursingService['nabh_non_nabh']!='')
						echo $nursingService['nabh_non_nabh'];
					else echo '&nbsp;';
					?>
					</td>
					<td align="right" valign="top" class="tdBorderRt"><?php
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][nabh_non_nabh]",'value' => $nursingService['nabh_non_nabh'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					$totalUnit = array_sum($nursingService['qty']);
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][rate]",'value' => $nursingService['cost'],'legend'=>false,'label'=>false,'id' => 'nursing_service_rate','style'=>'text-align:right;'));
					echo $nursingService['cost'];
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					if($totalUnit<1) $totalUnit=1;
					echo $totalUnit;
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => $totalUnit,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));


					?>
					</td>

					<td align="right" valign="top"><?php 
					$hospitalType = $this->Session->read('hospitaltype');
					$totalNursingCharges1=0;
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $this->Number->format($totalUnit*$nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'nursing_service_amount','style'=>'text-align:right;'));
					echo $this->Number->format($totalUnit*$nursingService['cost'],
		  			array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];


					//echo $totalNursingCharges1;
		  	?></td>
				</tr>
				<?php }

				?>



				<?php //$totalCost=$totalCost+$wardDetailCharges['wardOtherCharges']
				if($pharmacy_charges !='' && $pharmacy_charges!=0){
		   	$v++;$srNo++;
		   	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Pharmacy Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		   	#echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));


		   	?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td class="tdBorderRt ">Pharmacy Charges</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderRt "><?php   echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					echo $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));

					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt "><?php 	
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
					echo '--';
					?>
					</td>

					<td align="right" valign="top"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					echo $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					//echo $this->Number->format($pharmacy_charges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>
					</td>
				</tr>
				<?php 
		   }?>
				<?php $hospitaType = $this->Session->read('hospitaltype');
				if($hospitaType == 'NABH'){
          	$nabhType='nabh_charges';
          }else{
          	$nabhType='non_nabh_charges';
          }
          ?>
				<!-- BOF lab charges -->
				<?php if(count($labRate)>0){
					foreach($labRate as $lab=>$labCost){
          			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
          				$k++;
          				$lCost += $labCost['TariffAmount'][$nabhType] ;
          }
          $lCost = $lCost - $labPaidAmount;$srNo++;
          //}
          ?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td class="tdBorderRt">Laboratory Charges <?php $v++;
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Laboratory Charges",'legend'=>false,'label'=>false));
					?>
					</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderRt"><?php
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
					echo '--';

					?>
					</td>

					<td align="right" valign="top"><?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
				</tr>

				<?php $v++;
				// echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Laboratory Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
          }?>
				<!-- 
          <?php 
          		$lCost ='';$k=0;
          		#print_r($labRate);
          		foreach($labRate as $lab=>$labCost){
          			//if(!empty($labCost['LaboratoryTokens']['ac_id']) || !empty($labCost['LaboratoryTokens']['sp_id'])){
          				$k++;
          				$lCost += $labCost['TariffAmount'][$nabhType] ;
    echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][name]",'value' => $labCost['Laboratory']['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
    #echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));      				
    
    
    
    ?>
          				 <tr>
					            <td class="tdBorderRt">&nbsp;&nbsp;<i><?php echo $labCost['Laboratory']['name'];?></i></td>
					            <td align="center" valign="top" class="tdBorderRt"><strong>
					            <?php 
	echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));				            
					            ?></strong></td>
					            <td align="right" valign="top" class="tdBorderRt"><?php 
					            //echo $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					            echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][rate]",'value' => $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					            ?></td>
					            
					            <td align="right" valign="top"><strong><?php 
					            //echo $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					            echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					            ?></strong></td>
					      </tr>
          				<?php 
          			//}
          		}
          		?>
          	-->
				<!-- EOF lab charges -->
				<!-- BOF radiology charges -->

				<?php if(count($radRate)>0){
					$v++;
					foreach($radRate as $lab=>$labCost){
          		$rCost += $labCost['TariffAmount'][$nabhType] ;
          	}
          	$rCost = $rCost - $radPaidAmount;
          	$srNo++;
          	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Radiology Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
          	?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td class="tdBorderRt">Radiology Charges <?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Radiology Charges",'legend'=>false,'label'=>false));?>
					</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 		
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					echo $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 	
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
					echo '--';

					?>
					</td>
					<!-- gaurav-----service category heading added -->
					<!-- <td class="tdBorderRt">
						<?php echo $nursingService['service_category']; ?> <br> <i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $nursingService['name'];?></i>
					</td> -->
					<!-- g -->

					<td align="right" valign="top"><?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
				</tr>
				<?php }?>
				<!-- 
          		<?php 
          		$rCost = '';$k=0;
          		foreach($radRate as $lab=>$labCost){
          			 $k++;
          				$rCost += $labCost['TariffAmount'][$nabhType] ;
    //echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][name]",'value' => $labCost['Radiology']['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
    #echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));      				
    
    
    
          				?>
          				 <tr>
					            <td class="tdBorderRt">&nbsp;&nbsp;<i><?php echo $labCost['Radiology']['name'];?></i></td>
					            <td align="center" valign="top" class="tdBorderRt"><strong>

<?php echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => 1,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));?>
</strong></td>
					            <td align="right" valign="top" class="tdBorderRt"><?php 
					            //echo $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					            echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][rate]",'value' => $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					            ?></td>
					            
					            <td align="right" valign="top"><strong><?php 
					            //echo $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					            echo $this->Form->input('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $this->Number->format($labCost['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					            ?></strong></td>
					      </tr>
          				<?php 
          			 
          		}
          ?>
          -->
				<!-- EOF radiology charges -->

				<?php foreach($diagnosisCharges as $diagnosisCharge){//pr($diagnosisCharge);exit; ?>
				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td align="center" class="tdBorderRt"><?php echo $diagnosisCharge['SnomedMappingMaster']['mapTarget'];?>
					</td>
					<td class="tdBorderRt"><?php echo $diagnosisCharge['SnomedMappingMaster']['sctName'];?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $diagnosisCharge['SnomedMappingMaster']['icdName'],'legend'=>false,'label'=>false));?>
					</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 	
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($diagnosisCharge['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					echo $this->Number->format($diagnosisCharge['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 	
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '1','legend'=>false,'label'=>false,'style'=>'text-align:center'));
					#echo $otherServiceD[0]['tUnit'];
					echo '1';
					?>
					</td>

					<td align="right" valign="top"><?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($diagnosisCharge['TariffAmount'][$nabhType]),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $this->Number->format(($diagnosisCharge['TariffAmount'][$nabhType]),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$diagnosisChanges = $diagnosisChanges + ($diagnosisCharge['TariffAmount'][$nabhType]);
					?>
					</td>
				</tr>

				<?php } ?>

				<?php 
				$otherServicesCharges=0;
				foreach($otherServicesData as $otherServiceD){
          $v++;$srNo++;
          ?>

				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td class="tdBorderRt"><?php echo $otherServiceD['OtherService']['service_name'];?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $otherServiceD['OtherService']['service_name'],'legend'=>false,'label'=>false));?>
					</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 	
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($otherServiceD['OtherService']['service_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					echo $this->Number->format($otherServiceD['OtherService']['service_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 	
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '1','legend'=>false,'label'=>false,'style'=>'text-align:center'));
					#echo $otherServiceD[0]['tUnit'];
					echo '1';
					?>
					</td>

					<td align="right" valign="top"><?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($otherServiceD['OtherService']['service_amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $this->Number->format(($otherServiceD['OtherService']['service_amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$otherServicesCharges = $otherServicesCharges + ($otherServiceD['OtherService']['service_amount']);
					?>
					</td>
				</tr>

				<?php }?>
				<!-- Services For IPD patient gaurav -->
				<?php if($person['Patient']['admission_type'] == 'IPD'){
					foreach($servicesData as $serviceData){
         		 $v++;$srNo++;
         		 ?>

				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td align="center" class="tdBorderRt"><?php echo $serviceData['Icd10pcMaster']['ICD10PCS'];?>
					</td>
					<td class="tdBorderRt"><?php echo trim($serviceData['Icd10pcMaster']['ICD10PCS_FULL_DESCRIPTION']);?>
						<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => trim($serviceData['Icd10pcMaster']['ICD10PCS_FULL_DESCRIPTION']),'legend'=>false,'label'=>false));?>
					</td>
					<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderRt"><?php 	
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format(trim($serviceData['ServiceBill']['no_of_times']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
					echo $this->Number->format(trim($serviceData['Icd10pcMaster']['charges']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					?>
					</td>
					<td align="center" valign="top" class="tdBorderRt"><?php 	
					echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $serviceData['ServiceBill']['no_of_times'],'legend'=>false,'label'=>false,'style'=>'text-align:center'));
					#echo $otherServiceD[0]['tUnit'];
					echo $serviceData['ServiceBill']['no_of_times'];
					?>
					</td>

					<td align="right" valign="top"><?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format((trim($serviceData['Icd10pcMaster']['charges'])),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
					echo $this->Number->format((trim($serviceData['Icd10pcMaster']['charges'])),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$otherServicesCharges = $otherServicesCharges + (trim($serviceData['Icd10pcMaster']['charges']));
					?>
					</td>
				</tr>

				<?php }
				}?>
				<!-- Services For IPD patient Ends -->
				<!--  MRN Charges -->
				<?php 
				//echo $otherServicesCharges .'-'. $registrationRate .'-'. $totalNursingCharges .'-'. $totalDoctorCharges .'-'. $totalNewWardCharges .'-'. $totalCost .'-'.+ $lCost.'-'. $rCost;exit;
				#$totalCost = $otherServicesCharges + $registrationRate + $totalNursingCharges + $totalDoctorCharges + $totalNewWardCharges + $totalCost + $lCost + $rCost;//-$radPaidAmount-$labPaidAmount;// + $extraSurgeryCost;
				$totalCost = $diagnosisChanges + $otherServicesCharges + $registrationRate + $totalNursingCharges + $totalDoctorCharges + $totalNewWardCharges + $totalCost + $lCost + $rCost-$radPaidAmount-$labPaidAmount+$anesthesiaCharges;// + $extraSurgeryCost;

				?>
				<!-- MRn Charges -->

				<tr>
					<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
					<td align="center" class="tdBorderTpRt">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderTpRt"><strong>Total</strong>
					</td>
					<td align="center" class="tdBorderTpRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
					<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>

					<td align="right" valign="top" class="tdBorderTp totalPrice"><strong><span
							class="WebRupee"></span> <?php 
							//echo $this->Html->image('icons/rupee_symbol_white.png');
							echo $this->Number->currency(ceil($totalCost));
							echo $this->Form->hidden('Billing.total_amount',array('value' => ($totalCost),'legend'=>false,'label'=>false));
							?> </strong></td>
				</tr>
			</table>
		</td>
	</tr>

</table>

<?php echo $this->Form->end(); ?>

<script>
 $(document).ready(function(){  		 
	//add n remove drud inputs
	 	var counter = <?php echo ($count)?$count:0?>;
 
    	$("#addButton").click(function () {		 				 
		 
			var newCostDiv = $(document.createElement('tr'))
			     .attr("id", 'ExtraRow' + counter);
			 
			newHtml =  '<td valign="top" align="left">' ;
			newHtml += '<input type="text" value="" id="name'+counter+'" class="textBoxExpnd" name="data[FinalBillingOption]['+counter+'][name]">' ;
			newHtml += '</td>' ;
			newHtml += '<td valign="top">:</td>';
			newHtml += '<td valign="top">';
			newHtml += '<input type="text" style="width:150px;" id="" class="textBoxExpnd" name="data[FinalBillingOption]['+counter+'][value]">';
			newHtml += '<img src="<?php echo $this->Html->url('/img/icons/cross.png'); ?>" id="remove_'+counter+'" class="removeButton">';
			newHtml += '</td>';  	
			
			newCostDiv.append(newHtml);		 
			newCostDiv.appendTo("#ExtraRow");		
			  			 			 
			++counter;
			if(counter > 0) $('#removeButton').show('slow');
     	});
     	
    	$('.removeButton').live('click',function(){
        	 
			currentID = $(this).attr('id');
			currentClickedRow = currentID.split("_");
			$("#ExtraRow" + currentClickedRow[1]).remove(); 		 
			counter--;			 
	 		if(counter == 0) $('#removeButton').hide('slow');
	   });
    	$('#save')
    	.click(
    			function() { 
    				var validate = jQuery("#ConsultantBilling").validationEngine('validate');
    				if (validate) {$(this).css('display', 'none');}
    			});
});
 </script>
