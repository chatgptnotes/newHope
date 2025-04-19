<div class="inner_title">
	<h3>
		<?php echo __('Account Voucher-'.$patientData['Patient']['lookup_name'], true); ?>
	</h3>
</div>
<div class="clr">&nbsp;</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
				foreach($errors as $errorsval){
					         echo $errorsval[0];
					         echo "<br />";
					    }
					    ?>
			</div>
		</td>
	</tr>
</table>
<?php } 
echo $this->Form->create('Patient_Details',array('id'=>'patient_recievable','url'=>array('controller'=>'Accounting','action'=>'patient_account_receivable','admin'=>false),));?>

<table align="center" style="margin-top: 10px">
		<tr>
			<td align="center"><strong><?php echo __('Account');?></strong>
			</td>
			<td><?php echo $this->Form->input('Patient.name',array('id'=>'user','label'=>false,'div'=>false,'type'=>'text','autocomplete'=>'off','class' => 'validate[required,custom[mandatory-enter]]'));
			echo $this->Form->hidden('Patient.user_id',array('id'=>'user_id'));?>
		
			<td><?php //echo __('From');?></td>
			<td><?php 
        	//echo $this->Form->input('Patient.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
			</td>
			<td><?php //echo __('To');?></td>
			<td><?php 
       		//echo $this->Form->input('Patient.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
			</td>
			<td><?php echo $this->Form->submit('Submit',array('class'=>'blueBtn','label'=> false, 'div' => false));
			echo $this->Form->end();?>
			</td>
		</tr>
	</table>
	<?php if($click==1){?>
<table width="100%" cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td>Account:<?php echo ucwords($patientData['Patient']['lookup_name']);?></td>
		<td colspan="6" style="text-align: right"><?php echo $this->DateFormat->formatDate2Local($patientData['Patient']['form_received_on'],Configure::read('date_format'),false); ?> To <?php echo ($patientData['Patient']['discharge_date'])?$this->DateFormat->formatDate2Local($patientData['Patient']['discharge_date'],Configure::read('date_format'),false):$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'),false );?>
		</td>
	</tr>
</table>
<table
	width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">
	<tr>
		<th width="100" align="center" valign="top"
			style="text-align: center; min-width: 100px;">Date</th>
		<th width="100" align="center" valign="top"
			style="text-align: center;">Particulars</th>
		<th width="150" align="center" valign="top"
			style="text-align: center; min-width: 150px;">Voucher Type</th>
		<th width="90" align="center" valign="top" style="text-align: center;">Voucher
			No.</th>
		<th width="125" align="center" valign="top"
			style="text-align: center;">Debit</th>
		<th width="125" align="center" valign="top"
			style="text-align: center;">Credit</th>
	</tr>
	<?php 
	$bal=0;
	foreach($data as $datas){
		$date=$this->DateFormat->formatDate2Local($datas['Billing']['date'],Configure::read('date_format'),true);?>
	<tr>
		<td align="center" valign="top" style="text-align: center;"><?php echo $date ?>
		</td>
		<td align="center" valign="top" style="text-align: center;"><i><?php echo $datas['Billing']['narration'] ?>
		</i></td>
		<td align="center" valign="top" style="text-align: center;"><?php echo "Journal";  ?>
		</td>
		<td align="center" valign="top" style="text-align: center;"><?php echo $this->Number->currency($datas['Billing']['amount']); ?>
		</td>
		<td align="center" valign="top" style="text-align: center;"><?php   ?>
		</td>
		<td align="center" valign="top" style="text-align: center;"><?php ?></td>
	</tr>

	<?php 
	$bal=$bal+$datas['Billing']['amount'];
	}
	?>

	<?php $srNo=0;?>
	<?php if($patient['Patient']['payment_category']!='cash'){?>
	<tr>
		<td align="center" class="tdBorderRt">&nbsp;</td>
		<td class="tdBorderRt" style="font-size: 12px;"><i><strong>Conservative
					Charges </strong><span id="firstConservativeText"></span> </i> <?php 
					$v++ ;
					?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");?></td>
		<!--<td class="tdBorderRt" style="font-size:12px;"><strong><i>Conservative Charges</i></strong></td>
            -->
		<td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong></td>		
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
		<td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
		</tr>

	<?php $lastSection='Conservative Charges';?>
	<?php }?>
	<?php 
	if($registrationRate!='' && $registrationRate !=0){
					$srNo++;
					?>
	<tr>
		<td align="center" class="tdBorderRt"><?php echo $date; ?></td>
		<td class="tdBorderRt">MRN Charges</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account type
					//echo $registrationChargesData['TariffList']['cdm'];	?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo $registrationChargesData['TariffList']['cbt'];?>
		</td>
		<td align="right" valign="top"><?php 
		echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php
		echo $registrationChargesData['TariffList']['cghs_code'];
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
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">
			<?php echo $consultantBilling[0]['TariffList']['cghs_code'];?>
		</td>
		<td class="tdBorderRt"><?php echo __("Journal");
	          	//if($consultantBilling['ConsultantBilling']['category_id'] == 0){
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
	          		/* echo $consultantBilling[0]['ServiceCategory']['name'];
	          		$completeConsultantName = $consultantBilling[0]['Initial']['name'].$consultantBilling[0]['Consultant']['first_name'].' '.$consultantBilling[0]['Consultant']['last_name'];
	          		echo '<br>&nbsp;&nbsp;<i>'.$completeConsultantName.'</i> ';
	          		$sDate = explode(" ",$consultantBilling[0]['ConsultantBilling']['date']);
	          		$lRec = end($consultantBilling);
	          		$eDate = explode(" ",$lRec['ConsultantBilling']['date']);

	          		if($patient['Patient']['admission_type']=='OPD'){
	   					echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).')';
	   		         	}else{
	            		echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).' - '.$this->DateFormat->formatDate2Local($lRec['ConsultantBilling']['date'],Configure::read('date_format')).')';
	            	    } */
	                   ?></td>
		<td align="right" valign="top" class="tdBorderRt"><?php 
				echo $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.',
				'before'=>false,'thousands'=>false));
		?>
		</td>
		<td align="right" valign="top"><?php 
				echo $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),
				array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		?>
		</td>
		<td align="center" valign="top" class="tdBorderRt"><?php 
		$totalCost = $totalCost + ($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling));
		echo count($consultantBilling);
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
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">
			<?php echo $consultantBilling[0]['TariffList']['cghs_code'];?>
		</td>
		<td class="tdBorderRt"><?php  echo __("Journal");//account Type?>
		<?php /*if($consultantBilling['ConsultantBilling']['charges_type']=='Consultant'){
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

            	/* echo $consultantBilling[0]['ServiceCategory']['name'];
            	echo '<br>&nbsp;&nbsp;<i>'.$consultantBilling[0]['Initial']['name'].$consultantBilling[0]['DoctorProfile']['doctor_name'].'</i> ';
            	$sDate = explode(" ",$consultantBilling[0]['ConsultantBilling']['date']);
            	$lRec = end($consultantBilling);
            	$eDate = explode(" ",$lRec['ConsultantBilling']['date']);
            	if($patient['Patient']['admission_type']=='OPD'){
            		echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).')';
            		}else{
            		echo '('.$this->DateFormat->formatDate2Local($consultantBilling[0]['ConsultantBilling']['date'],Configure::read('date_format')).' - '.$this->DateFormat->formatDate2Local($lRec['ConsultantBilling']['date'],Configure::read('date_format')).')';
                   	} */
               	?>
		</td>
		<td align="right" valign="top" class="tdBorderRt"><?php 
				echo $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],
				array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		?>
		</td>
		<td align="right" valign="top"><?php 
				echo $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),
				array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		?>
		</td>
		<td align="center" valign="top" class="tdBorderRt"><?php 
		$totalCost = $totalCost + ($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling));
		echo count($consultantBilling);
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
		<td class="tdBorderRt" style="font-size: 12px;"><i><strong>Surgical
					Charges</strong> </i> <?php  
					$endOfSurgery = strtotime($uniqueSlot['surgery_billing_date']." +".$uniqueSlot['validity']." days");
					$startOfSurgery  = $this->DateFormat->formatDate2Local($uniqueSlot['start'],Configure::read('date_format')) ;
		            echo $surgeryDate = "<i>(".$startOfSurgery."-".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s',$endOfSurgery),Configure::read('date_format')).")</i>";?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type?></td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
		<td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
		<td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
	</tr>
	<?php $v++; 
	}
	//if surgery is package
	if($uniqueSlot['validity']> 1){

				 ?>
	<tr>
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt" style="padding-left: 10px;"><?php  
		echo $uniqueSlot['name'];
		$splitDate = explode(" ",$uniqueSlot['start']);
		echo "<br><i>(".$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true)."-".
				$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['end'],Configure::read('date_format'),true).")</i>";
		?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type?><?php //echo $uniqueSlot['moa_sr_no'];?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['cbt'];?>
		</td>
		<td align="right" valign="top"><?php 
		echo $uniqueSlot['cost'];
		$totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost'];
		?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $uniqueSlot['cghs_code'];?>
		</td>
	</tr>

	<?php }else{    ?>
	<tr>
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
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
			            ?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type?><?php // echo $uniqueSlot['cdm'];?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['cbt'];?>
		</td>
		<td align="right" valign="top"><?php 
		//echo $uniqueSlot['cost'];
		echo "<br>".$uniqueSlot['cost'];
		echo "<br>".$uniqueSlot['anaesthesist_cost'];
		$totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost']+$uniqueSlot['anaesthesist_cost'];
		?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $uniqueSlot['cghs_code'];?>
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
		<td class="tdBorderRt" style="font-size: 12px;"><i><strong>Conservative
					Charges</strong> <?php 
					echo ' ('.$inDate.'-'.$outDate.')' ;
					?> </i></td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo __("Journal");//account Type?>
		</td>
		<td align="right" valign="top" class="tdBorderRt"><?php echo __("Journal");?></td>
		<td align="right" valign="top" class="tdBorderRt">&nbsp;</td>
		<td align="center" class="tdBorderRt">&nbsp;</td>
	</tr>

	<?php }?>
	<?php $v++;?>
	<?php }?>
	<?php //echo $uniqueSlot[$wardNameKey][0]['moa_sr_no'].'here';exit;?>
	<tr>
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt"><?php 
		echo $wardNameKey.' ('.$inDate.'-'.$outDate.')';
		?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//echo $uniqueSlot[$wardNameKey][0]['cdm'];
			?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo $uniqueSlot[$wardNameKey][0]['cbt'];?>
		</td>
		<td align="right" valign="top"><?php 
		//echo $this->Number->format(($totalWardDays*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		echo $this->Number->format(($total*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		$totalNewWardCharges = $totalNewWardCharges + ($total*$wardCostPerWard);
		?>
		</td>
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
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt">Doctor Charges <?php 
		?>
		</td>
		<td align="center" class="tdBorderRt"><?php 
		//echo $doctorChargesData['TariffAmount']['moa_sr_no'].'here';exit;
		echo __("Journal");
		//echo $doctorChargesData['TariffList']['cdm'];
		?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo $doctorChargesData['TariffList']['cbt'];?>
		</td>
		<td align="right" valign="top"><?php 
		//echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		$totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$doctorRate);
		?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
		echo $doctorChargesData['TariffList']['cghs_code'];

		?>
		</td>
	</tr>
	<?php }?>
	<?php $v++;?>
	<?php if($nursingRate!='' && $nursingRate!=0){
		$srNo++;
		?>
	<tr>
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt">Nursing Charges <?php 
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Nursing Charges','legend'=>false,'label'=>false));
		?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type
		//echo $nursingChargesData['TariffList']['cdm'];
		?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo $nursingChargesData['TariffList']['cbt'];?>
		</td>
		<td align="right" valign="top"><?php 
		//echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
		echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		$totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$nursingRate);
		?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
		echo $nursingChargesData['TariffList']['cghs_code'];

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
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt"><?php echo ($patient['TariffList']['name'])?($patient['TariffList']['name']):'Consultation Fee' ;?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type
		//echo $doctorChargesData['TariffList']['cdm'];?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo $doctorChargesData['TariffList']['cbt'];?>
		</td>
		<td align="right" valign="top"><?php 
		echo $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		$totalNewWardCharges = $totalNewWardCharges + ($doctorRate);
		?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
		echo $doctorChargesData['TariffList']['cghs_code'];
		?>
		</td>
		<td align="right" valign="top" class="tdBorderRt"><?php 
		echo $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		//echo $doctorRate;
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
				$this->Number->format($nursingServicesCost['TariffAmount'][$nursingServiceCostType],
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
		   	?>

	<tr>
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt"><?php echo $nursingService['name'];?></td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal"); //account Type
		/* if($nursingService['cdm']!='')
			echo $nursingService['cdm'];
		else echo '&nbsp;'; */
		?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo $nursingService['cbt'];?>
		</td>
		<td align="right" valign="top"><?php 
		$hospitalType = $this->Session->read('hospitaltype');
		$totalNursingCharges1=0;
		echo $this->Number->format($totalUnit*$nursingService['cost'],
		  			array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];
		?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
		if($nursingService['nabh_non_nabh']!='')
			echo $nursingService['nabh_non_nabh'];
		else echo '&nbsp;';
		?>
		</td>
	</tr>
	<?php }	?>
	<?php //$totalCost=$totalCost+$wardDetailCharges['wardOtherCharges']
	if($pharmacy_charges !='' && $pharmacy_charges!=0){
		   	$v++;$srNo++;
		   	  	?>
	<tr>
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt ">Pharmacy Charges</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type?></td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
		<td align="right" valign="top"><?php 
		echo $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					//echo $this->Number->format($pharmacy_charges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>
		</td>
		<td align="right" valign="top" class="tdBorderRt "><?php   echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		echo $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		?>
		</td>
	</tr>
	<?php  } ?>
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
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt">Laboratory Charges <?php $v++;?></td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type?></td>
		<td align="center" class="tdBorderRt">&nbsp;</td>
		<td align="right" valign="top"><?php echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,
				'thousands'=>false));?>	</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
		
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
          				$lCost += $labCost['TariffAmount'][$nabhType] ;    ?>
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
          	?>
	<tr>
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt">Radiology Charges
		</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type?></td>
		<td align="center" class="tdBorderRt">&nbsp;</td>
		<td align="right" valign="top"><?php echo $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
		
		<!-- gaurav-----service category heading added -->
		<!-- <td class="tdBorderRt">
						<?php //echo $nursingService['service_category']; ?> <br> <i>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $nursingService['name'];?></i>
					</td> -->
		<!-- g -->


	</tr>
	<?php }?>
	<!-- 	<?php 
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
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt"><?php echo $diagnosisCharge['SnomedMappingMaster']['sctName'];?></td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type?></td>
		<td align="center" class="tdBorderRt"><?php echo $diagnosisCharge['SnomedMappingMaster']['mapTarget'];?></td>
		<td align="right" valign="top"><?php
		echo $this->Number->format(($diagnosisCharge['TariffAmount'][$nabhType]),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		$diagnosisChanges = $diagnosisChanges + ($diagnosisCharge['TariffAmount'][$nabhType]);
		?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
	</tr>

	<?php } ?>

	<?php 
	$otherServicesCharges=0;
	foreach($otherServicesData as $otherServiceD){
          $v++;$srNo++;
          ?>

	<tr>
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt"><?php echo $otherServiceD['OtherService']['service_name'];?>
			<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $otherServiceD['OtherService']['service_name'],'legend'=>false,'label'=>false));?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type?></td>
		<td align="center" class="tdBorderRt">&nbsp;</td>
		<td align="right" valign="top"><?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($otherServiceD['OtherService']['service_amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
		echo $this->Number->format(($otherServiceD['OtherService']['service_amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		$otherServicesCharges = $otherServicesCharges + ($otherServiceD['OtherService']['service_amount']);
		?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
	</tr>

	<?php }?>
	<!-- Services For IPD patient gaurav -->
	<?php if($person['Patient']['admission_type'] == 'IPD'){
		foreach($servicesData as $serviceData){
         		 $v++;$srNo++;
         		 ?>
	<tr>
		<td align="center" class="tdBorderRt"><?php echo $date;?></td>
		<td class="tdBorderRt"><?php echo trim($serviceData['Icd10pcMaster']['ICD10PCS_FULL_DESCRIPTION']);?>
		</td>
		<td align="center" class="tdBorderRt"><?php echo __("Journal");//account Type?></td>
		<td align="center" class="tdBorderRt"><?php echo $serviceData['Icd10pcMaster']['ICD10PCS'];?>
		</td>
		<td align="right" valign="top"><?php echo $this->Number->format((trim($serviceData['Icd10pcMaster']['charges'])),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		$otherServicesCharges = $otherServicesCharges + (trim($serviceData['Icd10pcMaster']['charges']));
		?>
		</td>
		<td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
	</tr>
	<?php }
		  }?>
	<!-- Services For IPD patient Ends -->
	<!--  MRN Charges -->
	<?php  
	$total=0;
	foreach($getIpdServices as $amount){
		$total=$total+$amount['Icd10pcMaster']['charges'];
	}
	$current_bal=$total-$bal;
	?>
	<tr>
		<td colspan="4"></td>
		<td colspan="2">
			<table width="100%">
				<tr>
					<td style="text-align: right;">Opening Balance:</td>
					<td style="text-align: left;"><?php echo $this->Number->currency(ceil($total));?>
					</td>
				</tr>
				<tr>
					<td style="text-align: right;">Current Total:</td>
					<td style="text-align: left;"><?php echo $this->Number->currency(ceil($current_bal));?>
					</td>
				</tr>
				<tr>
					<td><?php $this->Form->submit('Save',array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;')) ; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

</table>
<?php }?>
<script>
$(document).ready(function(){
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	 
 	$("#to").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});
	 
	$( "#patient_recievable" ).click(function(){
	   	 var fromdate = new Date($( '#from' ).val());
	     var todate = new Date($( '#to' ).val());
	      if(fromdate.getTime() > todate.getTime()) {
	     alert("To date should be greater than from date");
	     return false;
	    }
	});

	 $( "#user" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","lookup_name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			$('#user_id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});
	 jQuery("#patient_recievable").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});	
});
</script>
