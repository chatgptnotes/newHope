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
		<td align="right"><?php 
		echo $this->Html->link('Print','#',
			 array('style'=>'margin:0px;','class'=>'blueBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".html_entity_decode($this->Html->url(array('admin' => false, 'action'=>'printReceipt',$patient['Patient']['id'],$mode),true))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400,width:800,height:800');  return false;"));

  // echo $this->Html->link(__('Print'),array('action' => 'printReceipt',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
   ?> <?php //}?>
		</td>
	</tr>
	<tr>
		<td width="100%" align="center" valign="top" class="heading"><strong><?php 
		if($mode=='direct') echo 'PROVISIONAL INVOICE';
		else echo 'FINAL INVOICE';
		?>
		</strong></td>
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
		<td width="100%" align="left" valign="top" class="boxBorderBot">
			<table width="800" border="0" cellspacing="0" cellpadding="5"
				id="ExtraRow">
				<tr>
					<td width="370" align="left" valign="top">Name Of Patient</td>
					<td width="10" valign="top">:</td>
					<td valign="top"><?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'];?>
					</td>
				</tr>
				<?php if($person['Person']['name_of_ip']!=''){?>
				<tr>
					<td align="left" valign="top">Name Of the I. P.</td>
					<td valign="top">:</td>
					<td valign="top"><?php //echo $patient['Patient']['lookup_name'];
//echo $this->Form->input('Billing.name_of_ip',array('value'=>$person['Person']['name_of_ip'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'name_of_ip','style'=>'width:150px;'));
echo $person['Person']['name_of_ip'];
?>
					</td>
				</tr>
				<?php }?>
				<?php if($person['Person']['relation_to_employee']!=''){?>
				<tr>
					<td align="left" valign="top">Relation with I. P.</td>
					<td valign="top">:</td>
					<td valign="top"><?php 
					//echo $this->Form->input('Billing.relation_to_employee',array('value'=>$person['Person']['relation_to_employee'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'relation_to_employee','style'=>'width:150px;'));
					$relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
					echo $relation[$person['Person']['relation_to_employee']];
					?>
					</td>
				</tr>
				<?php }  ?>
				<tr>
					<td align="left" valign="top">Age/Sex</td>
					<td valign="top">:</td>
					<td valign="top"><?php
					echo $person['Person']['age']."/".ucfirst($person['Person']['sex']);
					?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">Address</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $address; ?></td>
				</tr>
				<?php

  if($person['Person']['insurance_number']!='' || $person['Person']['executive_emp_id_no']!='' || $person['Person']['non_executive_emp_id_no']!=''){?>
				<tr>
					<td align="left" valign="top">Insurance Number/Staff Card
						No/Pensioner Card No.</td>
					<td valign="top">:</td>
					<td valign="top"><?php 
					if($person['Person']['insurance_number']!=''){
    	echo $person['Person']['insurance_number'];
    }elseif($person['Person']['executive_emp_id_no']!=''){
    	echo $person['Person']['executive_emp_id_no'];
    }elseif($person['Person']['non_executive_emp_id_no']!=''){
    	echo $person['Person']['non_executive_emp_id_no'];
    }
    ?>
					</td>
				</tr>
				<?php }?>
				<?php if($patient['Patient']['date_of_referral']!=''){?>
				<tr>
					<td align="left" valign="top">Date of Referral</td>
					<td valign="top">:</td>
					<td valign="top"><?php 
					//$dateOfReferral = explode(" ",$patient['Patient']['date_of_referral']);
					if($patient['Patient']['date_of_referral']!='')
						echo
						$this->DateFormat->formatDate2Local($patient['Patient']['date_of_referral'],Configure::read('date_format'));
					?>
					</td>
				</tr>
				<?php }?>

				<?php if($patient['Patient']['form_received_on']!=''){?>
				<tr>
					<td align="left" valign="top">Date Of MRN</td>
					<td valign="top">:</td>
					<td valign="top"><?php $admissionDate = explode(" ",$patient['Patient']['form_received_on']);
					echo
					$this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?>
					</td>
				</tr>
				<?php }
				if($patient['Patient']['admission_type']=='IPD'){
  		$dynamicText = 'discharge' ;
  	}else{
  		$dynamicText = 'completion of OPD process' ;
  	}
  	?>

				<?php if($finalBillingData['FinalBilling']['discharge_date']!=''){?>
				<tr>
					<td align="left" valign="top">Date Of <?php echo $dynamicText ;?>
					</td>
					<td valign="top">:</td>
					<td valign="top"><?php #pr($finalBillingData);exit;

   if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
   	$splitDate = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
   	echo $this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'),true);
   }
   ?>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td align="left" valign="top">Condition of the patient at <?php echo $dynamicText ;?>
					</td>
					<td valign="top">:</td>
					<td valign="top"><?php 
					echo $this->Form->input('Billing.patient_discharge_condition',array('value'=>$finalBillingData['FinalBilling']['patient_discharge_condition'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'patient_discharge_condition','style'=>'width:150px;'));
					?>
					</td>
				</tr>

				<?php if($mode!='direct'){?>
				<tr>
					<td align="left" valign="top">Invoice No.</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $billNumber;?></td>
				</tr>
				<?php }?>
				<?php if($patient['Patient']['admission_id']!=''){?>
				<tr>
					<td align="left" valign="top">Registration No.</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $patient['Patient']['admission_id'];?>
					</td>
				</tr>
				<?php }?>
				<?php if($corporateEmp!=''){
					$hideCGHSCol = '';
					if(strtolower($corporateEmp) == 'private'){
  			$hideCGHSCol = 'none' ;
  		}
  		?>
				<tr>
					<td align="left" valign="top">Category</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $corporateEmp;?></td>
				</tr>
				<?php }?>
				<!-- 
  <tr>
    <td align="left" valign="top">Category Details</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;</td>
  </tr>
   -->

				<tr>
					<td align="left" valign="top">Primary Consultant</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $this->Form->input('Billing.primary_consultant',array('value'=>$primaryConsultant[0]['fullname'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'width:150px;')); 
					?>
					</td>
				</tr>

				<tr>
					<td align="left" valign="top">Credit Period (in days)</td>
					<td valign="top">:</td>
					<td valign="top"><?php 
					if(isset($finalBillingData['FinalBilling']['credit_period'])){
   echo $this->Form->input('Billing.credit_period',array('value'=>$finalBillingData['FinalBilling']['credit_period'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'width:100px;'));
 }else{
 	echo $this->Form->input('Billing.credit_period',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'width:100px;'));
 }
 ?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">Other Consultant Name</td>
					<td valign="top">:</td>
					<td valign="top"><?php 
					if(isset($finalBillingData['FinalBilling']['other_consultant'])){
    	echo $this->Form->input('Billing.other_consultant',array('value'=>$finalBillingData['FinalBilling']['other_consultant'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'width:150px;'));

    }else{
    	echo $this->Form->input('Billing.other_consultant',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'width:150px;'));
	}?> <input type="button" id="addButton" value="Add more" align="right"
						class="blueBtn">
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">Insurance Company</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $corporateEmp;?></td>
				</tr>
				<tr>
					<td align="left" valign="top">Billing NPI:</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $corporateEmp;?></td>
				</tr>
				<tr>
					<td align="left" valign="top">Ordering Physician</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $corporateEmp;?></td>
				</tr>
				<tr>
					<td align="left" valign="top">Interpreting Physician</td>
					<td valign="top">:</td>
					<td valign="top"><?php echo $corporateEmp;?></td>
				</tr>

				<?php if(!empty($finalBillingData['FinalBillingOption'])){
					$count = 0 ;
					foreach($finalBillingData['FinalBillingOption'] as $finalOptions){
				$newHtml =  '<tr id="ExtraRow'.$count.'">';
				$newHtml .= '<td valign="top" align="left">' ;
				$newHtml .= '<input type="text" value="'.$finalOptions['name'].'" id="name'.$count.'" class="textBoxExpnd" name="data[FinalBillingOption]['.$count.'][name]">' ;
				$newHtml .= '</td>' ;
				$newHtml .= '<td valign="top">:</td>';
				$newHtml .= '<td valign="top">';
				$newHtml .= '<input type="text" value="'.$finalOptions['value'].'" style="width:150px;" id="" class="textBoxExpnd" name="data[FinalBillingOption]['.$count.'][value]">';
				$newHtml .= $this->Html->image('/img/icons/cross.png',array('id'=>"remove_$count",'class'=>"removeButton"));
				$newHtml .= '</td>';
				$newHtml .= '</tr>';
				echo $newHtml  ;
				$count++ ;
			}

				}
				?>
			</table>
		</td>
	</tr>
	<?php 
	$hospitalType = $this->Session->read('hospitaltype');
	if($hospitalType == 'NABH'){
   				$nabhKey = 'nabh_charges';
   				$nabhKeyC = 'cghs_nabh';
   			}else{
   				$nabhKey = 'non_nabh_charges';
   				$nabhKeyC = 'cghs_non_nabh';
   			}
   			?>
	<tr>
		<td><table width="100%" cellpadding="5" cellspacing="0" border="0">

				<?php if(!empty($surgeriesData)){?>
				<tr>
					<td valign="top">Surgeries<br /> <?php 
					$b=1;
					foreach($surgeriesData as $surg){
                    	if($b==1 && $surg['Surgery']['name']!=''){
                    		echo $b.'. '.$surg['Surgery']['name'];
                    		$b++;
                    	}
                    	else if($surg['Surgery']['name'] != ''){
                    		echo ', '.$b.'. '.$surg['Surgery']['name'];
                    		$b++;
                    	}
                    }
                     
                    ?>
					</td>
				</tr>
				<?php }?>
			</table></td>
	</tr>
	<tr>
		<td width="100%" align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="5"
				class="tdBorderTpBt">
				<tr>
					<td width="50" align="center" class="tdBorderRtBt">Sr. No.</td>
					<td width="80" align="center" class="tdBorderRtBt">CDM</td>
					<td width="80" align="center" class="tdBorderRtBt">CPT/ICD</td>
					<td align="center" class="tdBorderRtBt" width="500">Item</td>
					<td width="80" align="center" class="tdBorderRtBt" style="display:<?php echo $hideCGHSCol ;?>">CGHS
						Code No.</td>
					<td width="65" align="center" class="tdBorderRtBt">Charges</td>
					<td width="65" align="center" class="tdBorderRtBt">Qty.</td>
					<td width="100" align="center" class="tdBorderBt">Payments/Adjustments</td>
					<td width="100" align="center" class="tdBorderBt">Patient Balance</td>

				</tr>
				<?php //**********************ALL Charges Removed and services added**********************************************************************?>
				<!--  <?php $srNo=0;?>
          <?php if($patient['Patient']['payment_category']!='cash'){?>
          <tr>
            <td align="center" class="tdBorderRt">&nbsp;</td>
            <td align="center" class="tdBorderRt">&nbsp;</td>
            <td align="center" class="tdBorderRt">&nbsp;</td>
            <td class="tdBorderRt" style="font-size: 12px;"><i><strong>Conservative Charges </strong><span id="firstConservativeText"></span></i>
            <?php 
	            echo $this->Form->hidden('',array('name'=>"data[Billing][0][name]",'id'=>'first_conservative_cost','value' => 'Conservative Charges','legend'=>false,'label'=>false));
	            $v++ ;
	        ?>
            
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt"><strong>&nbsp;</strong></td>
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
		          	?></td>
		          	<td align="center" class="tdBorderRt"><?php echo $registrationChargesData['TariffList']['cbt'];?>
		          	</td>
		            <td class="tdBorderRt">MRN Charges</td>
		            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
		            
		            echo $registrationChargesData['TariffList']['cghs_code'];
		             ?></td>
		            <td align="right" valign="top" class="tdBorderRt">
		            <?php
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
		            ?></td>
		            
		            <td align="right" valign="top"><?php 
		            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_amount','style'=>'text-align:right;'));
		            echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		            ?></td>
		          </tr>
          <?php }?>
          
           <?php $totalCost=0;$v=1;
          foreach ($cCArray as $cBilling){ 
	          foreach($cBilling as $consultantBillingDta){
	          	foreach($consultantBillingDta as $consultantBilling){
	          	$v++;$srNo++;
	          ?>
	          <tr>
	          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
	          	<td align="center" class="tdBorderRt">&nbsp;</td>
	            <td class="tdBorderRt"><?php 
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
	            <?php echo $consultantBilling[0]['TariffList']['cghs_code'];?></td>
	            <td align="right" valign="top" class="tdBorderRt"><?php 
	            	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => count($consultantBilling),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
	            	echo $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
	            	?></td>
	            <td align="center" valign="top" class="tdBorderRt"><?php 
	            $totalCost = $totalCost + ($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling));
	            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
	            echo count($consultantBilling);
	            ?></td>
	            
	            <td align="right" valign="top"><?php 
	            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_amount','style'=>'text-align:right;'));
	            echo $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
	            ?></td>
	          </tr>
	            	
	          <?php }
          }
          
          }
          ?>
          
          
          <?php
          foreach ($cDArray as $cBilling){ 
           foreach($cBilling as $consultantBillingDta){
           	foreach($consultantBillingDta as $consultantBilling){
           $v++;$srNo++;
           	?>
           <tr>
           <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
           <td align="center" class="tdBorderRt">&nbsp;</td>
            <td class="tdBorderRt">
            <?php 
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
            	<?php echo $consultantBilling[0]['TariffList']['cghs_code'];?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => count($consultantBilling),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
            	echo $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            	?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
	            $totalCost = $totalCost + ($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling));
	            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($consultantBilling[0]['ConsultantBilling']['amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_rate','style'=>'text-align:right;'));
	            echo count($consultantBilling); 
            ?></td> 
            <td align="right" valign="top"><?php 
	            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'consultant_amount','style'=>'text-align:right;'));
	            echo $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            ?></td>
          </tr>
          <?php }
          }
          } 
          ?>
          <?php 
		  $totalCost = $totalCost+$pharmacy_charges-$pharmacyPaidAmount;
		    
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
		            <td class="tdBorderRt" style="font-size:12px;"><i><strong>Surgical Charges</strong> </i>
		            	<?php  
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
				
				 	if($uniqueSlot['validity']> 1){
				 		
				 ?>
		          	<tr>
			          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
			          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['moa_sr_no'];?></td>
			          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['cbt'];?>
		          		</td>
			            <td class="tdBorderRt" style="padding-left:10px;"><?php  
				            echo $uniqueSlot['name'];
				           $splitDate = explode(" ",$uniqueSlot['start']);
				   			echo "<br><i>(".$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['start'],Configure::read('date_format'),true)."-".
				   			$this->DateFormat->formatDate2LocalNonUTC($uniqueSlot['end'],Configure::read('date_format'),true).")</i>";
				   			
				            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Surgeon Charges ('.$uniqueSlot['name'].')</br>'.'<i>'.$uniqueSlot['doctor_name'].'</i> ('.$this->DateFormat->formatDate2Local($uniqueSlot['start'],Configure::read('date_format'),true).')','legend'=>false,'label'=>false));
				            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot['cghs_code'],'legend'=>false,'label'=>false));
				            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $uniqueSlot['moa_sr_no'],'legend'=>false,'label'=>false));
				            ?>
			            </td>
			            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $uniqueSlot['cghs_code'];?></td>
			            <td align="right" valign="top" class="tdBorderRt"><?php 
			          
			            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
			            echo $uniqueSlot['cost'];
			            ?></td>
			            <td align="center" valign="top" class="tdBorderRt"><?php 
			           
			            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $uniqueSlot['cost'],'legend'=>false,'label'=>false,'style'=>'text-align:right'));
			            echo '1';
			            ?></td>
			            
			            <td align="right" valign="top"><?php 
			            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $uniqueSlot['cost'],'legend'=>false,'label'=>false,'style'=>'text-align:right'));
			            echo $uniqueSlot['cost'];
			            $totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost'];
			            ?></td>
		          	</tr>	
		          	
				<?php }else{    ?>
					<tr>
		          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
		          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['cdm'];?></td>
		          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['cbt'];?>
		          		</td>
		            <td class="tdBorderRt" style="padding-left:10px;"><?php 
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
		            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php echo $uniqueSlot['cghs_code'];?></td>
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
		            ?></td>
		            
		            <td align="right" valign="top"><?php 
		            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $surgonCost,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
		            echo "<br>".$uniqueSlot['cost'];
		            echo "<br>".$uniqueSlot['anaesthesist_cost'];
		            $totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost']+$uniqueSlot['anaesthesist_cost'];
		            ?></td>
		          	</tr>
				<?php 	
				}//EOF package cond for surgery display
				
          		}else{
					
					$wardNameKey = key($uniqueSlot);
					
					$wardCostPerWard = $uniqueSlot[$wardNameKey][0]['cost'];
					 
					$daysCountPerWard=count($uniqueSlot[$wardNameKey]);
					$totalWardNewCost = $totalWardNewCost + (count($uniqueSlot[$wardNameKey]) * $wardCostPerWard);
					$totalWardDays = $totalWardDays + count($uniqueSlot[$wardNameKey][1]['in']);
					$totalWardDaysW = count($uniqueSlot[$wardNameKey]);
					
					/*************************************************************/
					$date = $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'));
					$splitDateIn = explode(" ",$uniqueSlot[$wardNameKey][0]['in']);
		            $splitDateOut = explode(" ",$uniqueSlot[$wardNameKey][$daysCountPerWard-1]['out']);
		           
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
		            <td class="tdBorderRt" style="font-size:12px;"><i><strong>Conservative Charges</strong>
		            	<?php 
		            		echo ' ('.$inDate.'-'.$outDate.')' ; 
		            	?>
		            </i></td>
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
          	<tr>
          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot[$wardNameKey][0]['cdm'];
          	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $uniqueSlot[$wardNameKey][0]['moa_sr_no'],'legend'=>false,'label'=>false));
          	?></td>
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
   			}else{
   				echo $uniqueSlot[$wardNameKey][0]['cghs_code'];
   			}
   			?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            
          	if($hospitalType == 'NABH'){ 
   				echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot[$wardNameKey][0]['cghs_nabh'],'legend'=>false,'label'=>false));
   			}else{ 
   				echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot[$wardNameKey][0]['cghs_non_nabh'],'legend'=>false,'label'=>false));
   			}
   			
   			
   			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
   			echo $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
   			?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
           $a = 1;
           $total = $totalWardDaysW - $a;
            echo $total;
            ?></td>
            
            <td align="right" valign="top"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $this->Number->format(($total*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            $totalNewWardCharges = $totalNewWardCharges + ($total*$wardCostPerWard);
            ?></td>
          	</tr>
          	<?php $v++;?>
          	
				<?php }?>
         
          <?php 
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
          echo $doctorChargesData['TariffList']['cdm'];
          echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $doctorChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false));
          ?></td>
          <td align="center" class="tdBorderRt"><?php echo $doctorChargesData['TariffList']['cbt'];?>
		          		</td>
            <td class="tdBorderRt">Doctor Charges
            <?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Doctor Charges','legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            echo $doctorChargesData['TariffList']['cghs_code'];
            
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $doctorChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));
            
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
           
            echo $forHiddenDoctorRate  = $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $forHiddenDoctorRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $totalWardDays;
            ?></td>
            
            <td align="right" valign="top"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            $totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$doctorRate);
            ?></td>
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
          	?></td>
          	<td align="center" class="tdBorderRt"><?php echo $nursingChargesData['TariffList']['cbt'];?>
		          		</td>
            <td class="tdBorderRt">Nursing Charges
            <?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => 'Nursing Charges','legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            echo $nursingChargesData['TariffList']['cghs_code'];
            
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $nursingChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));
            
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
            echo $this->Number->format(($nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $nursingRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $totalWardDays;
            ?></td>
            
            <td align="right" valign="top"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            $totalNewWardCharges = $totalNewWardCharges + ($totalWardDays*$nursingRate);
            ?></td>
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
          ?></td>
          <td align="center" class="tdBorderRt"><?php echo $doctorChargesData['TariffList']['cbt'];?>
		          		</td>
            <td class="tdBorderRt"><?php echo ($patient['TariffList']['name'])?($patient['TariffList']['name']):'Consultation Fee' ;?>
            <?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $patient['TariffList']['name'],'legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            echo $doctorChargesData['TariffList']['cghs_code'];
            
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $doctorChargesData['TariffList']['cghs_code'],'legend'=>false,'label'=>false));
            
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
            echo $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $doctorRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo '1';
            ?></td>
            
            <td align="right" valign="top"><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            $totalNewWardCharges = $totalNewWardCharges + ($doctorRate);
            ?></td>
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
		   		
				$resetNursingServices[$nursingServicesCost['TariffList']['id']]['qty'][] = $nursingServicesCost['ServiceBill']['no_of_times'];
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
		   
		   	//EOF pankaj
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
            ?></td>
            <td align="center" class="tdBorderRt"><?php echo $nursingService['cbt'];?>
		          		</td>
            <td class="tdBorderRt"><?php echo $nursingService['name'];?></td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            if($nursingService['nabh_non_nabh']!='')
            	echo $nursingService['nabh_non_nabh'];
            else echo '&nbsp;';
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php
            	 	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][nabh_non_nabh]",'value' => $nursingService['nabh_non_nabh'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
           			$totalUnit = array_sum($nursingService['qty']);
				  	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][rate]",'value' => $nursingService['cost'],'legend'=>false,'label'=>false,'id' => 'nursing_service_rate','style'=>'text-align:right;'));
				  	echo $nursingService['cost'];
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
              	if($totalUnit<1) $totalUnit=1;
            	echo $totalUnit;
             	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => $totalUnit,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
		    
            
            ?></td>
            
            <td align="right" valign="top" class="tdBorderRt"><?php 
		  $hospitalType = $this->Session->read('hospitaltype');
            $totalNursingCharges1=0;
		  			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $this->Number->format($totalUnit*$nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'nursing_service_amount','style'=>'text-align:right;'));
					echo $this->Number->format($totalUnit*$nursingService['cost'],
		  			array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];
				
					
			?></td>
		  	
		  	<td align="right" valign="top"><?php 
		  $hospitalType = $this->Session->read('hospitaltype');
            $totalNursingCharges1=0;
		  			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $this->Number->format($totalUnit*$nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'nursing_service_amount','style'=>'text-align:right;'));
					echo $this->Number->format($totalUnit*$nursingService['cost'],
		  			array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
					$totalNursingCharges = $totalNursingCharges + $totalUnit*$nursingService['cost'];
				
					
			?></td>
          </tr>
          <?php }
          
          ?>  
            
            
		
		   <?php 
		   if($pharmacy_charges !='' && $pharmacy_charges!=0){
		   	$v++;$srNo++;
		   	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Pharmacy Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;')); 
            ?>
		   <tr>
		   <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
		   <td align="center" class="tdBorderRt">&nbsp;</td>
            <td class="tdBorderRt ">Pharmacy Charges</td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt ">
<?php   echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		echo $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		
?>
</td>
            <td align="center" valign="top" class="tdBorderRt ">
<?php 	
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
		echo '--';
?>
</td>
            
            <td align="right" valign="top" ><?php 
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            echo $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            ?></td>
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
				<!-- 
          <?php if(count($labRate)>0){
          foreach($labRate as $lab=>$labCost){
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
            <td class="tdBorderRt">Laboratory Charges
            <?php $v++;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Laboratory Charges",'legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">
            <?php
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)); 
            ?>
            </td>
            <td align="center" valign="top" class="tdBorderRt">
<?php 
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
            		echo '--';
		
?>
</td>
            
            <td align="right" valign="top">
            <?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            		echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            ?>
            </td>
          </tr>
          
          <?php $v++;
          }?>
          -->
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
				<!-- 
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
            <td class="tdBorderRt">Radiology Charges
            <?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Radiology Charges",'legend'=>false,'label'=>false));?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">
<?php 		
			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			echo $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
?>
</td>
            <td align="center" valign="top" class="tdBorderRt">
<?php 	
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '--','legend'=>false,'label'=>false,'style'=>'text-align:center'));
		echo '--';
		
?>
</td>

            
            <td align="right" valign="top">
<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
		echo $this->Number->format($rCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
?>
</td>
          </tr>
          <?php }?>
        -->
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
				<!-- 
          <?php foreach($diagnosisCharges as $diagnosisCharge){//pr($diagnosisCharge);exit; ?>
         <tr>
         <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
         <td align="center" class="tdBorderRt">&nbsp;</td>
         <td align="center" class="tdBorderRt"><?php echo $diagnosisCharge['SnomedMappingMaster']['mapTarget'];?></td>
            <td class="tdBorderRt"><?php echo $diagnosisCharge['SnomedMappingMaster']['sctName'];?>
            <?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => $diagnosisCharge['SnomedMappingMaster']['icdName'],'legend'=>false,'label'=>false));?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">
<?php 	
			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($diagnosisCharge['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			echo $this->Number->format($diagnosisCharge['TariffAmount'][$nabhType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
?>
</td>
            <td align="center" valign="top" class="tdBorderRt">
<?php 	
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '1','legend'=>false,'label'=>false,'style'=>'text-align:center'));
		#echo $otherServiceD[0]['tUnit'];
		echo '1';		
?>
</td>
            
            <td align="right" valign="top">
<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($diagnosisCharge['TariffAmount'][$nabhType]),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
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
            <td align="right" valign="top" class="tdBorderRt">
<?php 	
			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($otherServiceD['OtherService']['service_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			echo $this->Number->format($otherServiceD['OtherService']['service_amount'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
?>
</td>
            <td align="center" valign="top" class="tdBorderRt">
<?php 	
		echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => '1','legend'=>false,'label'=>false,'style'=>'text-align:center'));
		#echo $otherServiceD[0]['tUnit'];
		echo '1';		
?>
</td>
            
            <td align="right" valign="top">
<?php echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($otherServiceD['OtherService']['service_amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
		echo $this->Number->format(($otherServiceD['OtherService']['service_amount']),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		$otherServicesCharges = $otherServicesCharges + ($otherServiceD['OtherService']['service_amount']);
		?>
</td>
          </tr>
         
    <?php }?>     
          -->
				<?php //**********************ALL Charges Removed and services added**********************************************************************?>

				<?php 
				$srNo = 0;
				foreach($servicesData as $serviceData){
         		 $v++;$srNo++;
          ?>

				<tr>
					<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<td align="center" class="tdBorderRt"><?php echo $serviceData['Icd10pcMaster']['ICD10PCS'];?></td>
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

				<?php }?>
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
							?></strong></td>
					<td align="right" valign="top" class="tdBorderTp totalPrice"><strong><span
							class="WebRupee"></span> <?php 
							//echo $this->Html->image('icons/rupee_symbol_white.png');
							echo $this->Number->currency(ceil($totalCost));
							echo $this->Form->hidden('Billing.total_amount',array('value' => ($totalCost),'legend'=>false,'label'=>false));
							?></strong></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td width="100%" align="left" valign="top" class="tdBorderTp">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" class="boxBorderRight columnPad">Amount Chargeable
						(in words)<br /> <strong><?php 
						$totalCost = ceil($totalCost);
						echo $this->RupeesToWords->no_to_words($totalCost);?>
					</strong>
					</td>
					<td width="292">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Advance
									Paid</td>
								<td align="right" valign="top" class="tdBorderBt"><?php 
								//echo $this->Html->image('icons/rupee_symbol_white.png');
								echo $this->Number->currency(ceil($totalAdvancePaid));
								echo $this->Form->hidden('Billing.amount_paid',array('value' => ($totalAdvancePaid),'legend'=>false,'label'=>false));
								?>
								</td>
							</tr>

							<?php 
							if(isset($finalBillingData['FinalBilling']['discount_rupees']) && $finalBillingData['FinalBilling']['discount_rupees'] !=''){
                        	$discountAmount = $finalBillingData['FinalBilling']['discount_rupees'];
                    }else{
                        	$discountAmount=0;
                    }
                    if($discountAmount != '' && $discountAmount!=0){
                    ?>

							<tr>
								<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Discount</td>
								<td align="right" valign="top" class="tdBorderBt"><?php 
								// echo $this->Html->image('icons/rupee_symbol_white.png');
								echo $this->Number->currency(ceil($discountAmount));
								echo $this->Form->hidden('Billing.discount_amount',array('value' => $discountAmount,'legend'=>false,'label'=>false));
								?>
								</td>
							</tr>

							<tr>
								<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Reason
									for Discount</td>
								<td align="right" valign="top" class="tdBorderBt"><?php 

								echo $finalBillingData['FinalBilling']['reason_for_discount'];
								echo $this->Form->hidden('Billing.reason_for_discount',array('value' => $finalBillingData['FinalBilling']['reason_for_discount'],'legend'=>false,'label'=>false));
								?></td>
							</tr>
							<?php }?>
							<tr>
								<td height="20" valign="top" class="tdBorderRtBt">&nbsp; <?php if($mode=='direct') echo 'To Pay on '.$dynamicText;
    						else echo 'To Pay ';?>

								</td>
								<td align="right" valign="top" class="tdBorderBt"><?php 
								//echo $this->Html->image('icons/rupee_symbol_white.png');
								echo $this->Number->currency(ceil($totalCost-$totalAdvancePaid-$discountAmount));
								echo $this->Form->hidden('Billing.amount_pending',array('value' => ($totalCost-$totalAdvancePaid-$discountAmount),'legend'=>false,'label'=>false));
								?>
								</td>
							</tr>


						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="100%" align="left" valign="top" class="columnPad">
			<table width="" cellpadding="0" cellspacing="0" border="0">

				<tr>
					<td height="20" align="left" valign="top"><strong>Signature of
							Patient :</strong></td>
					<td align="center" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td width="100%" align="left" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="55%" class="columnPad boxBorderRight">&nbsp;</td>
					<td width="45%" align="right" valign="bottom"
						class="columnPad tdBorderTp"><strong><?php echo $this->Session->read('billing_footer_name');?>
					</strong><br /> <br /> <br />
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td width="85">Bill Manager</td>
								<td width="65">Cashier</td>
								<td width="80">Med.Supdt.</td>
								<td align="right">Authorised Signatory</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>

</table>
<table width="800" cellspacing="3" cellpadding="3" border="0"
	align="center">
	<tr>
		<td align="right"><?php 
		//if($mode=='direct') echo '';
		//else {?> <?php
    	echo $this->Html->link(__('Cancel'),array('action' => 'advancePayment',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0px'));
    	//}
    	?> <input class="blueBtn" style="margin: 0px" type="submit"
			value="Save" id="save">
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

