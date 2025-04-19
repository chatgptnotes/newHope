<?php 
#pr($finalBillingData);exit;
#echo $totalWardCharges;exit;
?>
<?php //debug($patient['Patient']['tariff_standard_id']);?>
<style>
	body{padding:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000;}
	.boxBorder{border:1px solid #3E474A;}
	.boxBorderBot{border-bottom:1px solid #3E474A;}
	.boxBorderRight{border-right:1px solid #3E474A;}
	.tdBorderRtBt{border-right:1px solid #3E474A; border-bottom:1px solid #3E474A;}
	.tdBorderBt{border-bottom:1px solid #3E474A;}
	.tdBorderTp{border-top:1px solid #3E474A;}
	.tdBorderRt{border-right:1px solid #3E474A;}
	.tdBorderTpBt{border-bottom:1px solid #3E474A; border-top:1px solid #3E474A;}
	.tdBorderTpRt{border-top:1px solid #3E474A; border-right:1px solid #3E474A;}
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
</style>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:20px;" align="center">
<tr><td>
&nbsp;</td>
</tr>

<tr><td align="right">
<?php //if(isset($finalBillingData['FinalBilling']['discharge_date'])){?>
<?php 
echo $this->Html->link('Print','#',
			 array('style'=>'margin:0px;','class'=>'grayBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".html_entity_decode($this->Html->url(array('admin' => false, 'action'=>'printReceipt',$patient['Patient']['id'],$mode),true))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400,width:800,height:800');  return false;"));
   	
  // echo $this->Html->link(__('Print'),array('action' => 'printReceipt',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn'));
   ?>
<?php //}?>
</td>
</tr>
<tr>
    <td width="100%" align="center" valign="top" class="heading"><strong><?php 
    if($mode=='direct') echo 'PROVISIONAL INVOICE';
    else echo 'FINAL INVOICE';
    ?></strong></td>
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
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" class="boxBorder" >
  <tr>
    <td width="100%" align="left" valign="top" class="boxBorderBot">
        <table width="800" border="0" cellspacing="0" cellpadding="5" id="ExtraRow">
  <tr>
    <td width="370" align="left" valign="top">Name Of Patient</td>
    <td width="10" valign="top">:</td>
    <td valign="top"><?php echo $patient['PatientInitial']['name']." ".$patient['Patient']['lookup_name'];?></td>
  </tr>
  <?php if($person['Person']['name_of_ip']!=''){?>
  <tr>
    <td align="left" valign="top">Name Of the I. P.</td>
    <td valign="top">:</td>
    <td valign="top"><?php //echo $patient['Patient']['lookup_name'];
			//echo $this->Form->input('Billing.name_of_ip',array('value'=>$person['Person']['name_of_ip'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'name_of_ip','style'=>'width:150px;'));
			echo $person['Person']['name_of_ip'];
			?></td>
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
    ?></td>
  </tr>
  <?php }  ?>
   <tr>
    <td align="left" valign="top">Age/Sex</td>
    <td valign="top">:</td>
    <td valign="top"><?php
    	echo $person['Person']['age']."/".ucfirst($person['Person']['sex']);
    ?></td>
  </tr>  
  <tr>
    <td align="left" valign="top">Address</td>
    <td valign="top">:</td>
    <td valign="top"> <?php echo $address; ?></td>
  </tr> 
  <?php
  
  if($person['Person']['insurance_number']!='' || $person['Person']['executive_emp_id_no']!='' || $person['Person']['non_executive_emp_id_no']!=''){?>
  <tr>
    <td align="left" valign="top">Insurance Number/Staff Card No/Pensioner Card No.</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    if($person['Person']['insurance_number']!=''){
    	echo $person['Person']['insurance_number'];
    }elseif($person['Person']['executive_emp_id_no']!=''){
    	echo $person['Person']['executive_emp_id_no'];
    }elseif($person['Person']['non_executive_emp_id_no']!=''){
    	echo $person['Person']['non_executive_emp_id_no'];
    }
    ?></td>
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
    ?></td>
  </tr>
  <?php }?>
  
  <?php if($patient['Patient']['form_received_on']!=''){?>
  <tr>
    <td align="left" valign="top">Date Of Registration</td>
    <td valign="top">:</td>
    <td valign="top"><?php $admissionDate = explode(" ",$patient['Patient']['form_received_on']);
                   	  	  	echo 
                   	  	  	$this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),true);?></td>
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
    <td align="left" valign="top">Date Of <?php echo $dynamicText ;?></td>
    <td valign="top">:</td>
    <td valign="top"><?php #pr($finalBillingData);exit;
              
   if(isset($finalBillingData['FinalBilling']['discharge_date']) && $finalBillingData['FinalBilling']['discharge_date']!=''){
   	$splitDate = explode(" ",$finalBillingData['FinalBilling']['discharge_date']);
   	echo $this->DateFormat->formatDate2Local($finalBillingData['FinalBilling']['discharge_date'],Configure::read('date_format'),true);
   }
   ?></td>
  </tr>
  <?php } ?> 
  <tr>
    <td align="left" valign="top">Condition of the patient on <?php echo $dynamicText ;?></td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    echo $this->Form->input('Billing.patient_discharge_condition',array('value'=>$finalBillingData['FinalBilling']['patient_discharge_condition'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'patient_discharge_condition','style'=>'width:150px;'));
    ?></td>
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
    <td valign="top"><?php echo $patient['Patient']['admission_id'];?></td>
  </tr>
  <?php }?>
  <?php if($corporateEmp!=''){
  		$hideCGHSCol = '';
  		if(strtolower($corporateEmp) == 'private'){
  			$hideCGHSCol = 'none' ;
  		}
  		 
  		$corporateEmp = strtolower($corporateEmp);
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
    <td align="left" valign="top">Credit Period (in days)</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
 if(isset($finalBillingData['FinalBilling']['credit_period'])){
   echo $this->Form->input('Billing.credit_period',array('value'=>$finalBillingData['FinalBilling']['credit_period'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'width:100px;')); 
 }else{
 	echo $this->Form->input('Billing.credit_period',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'width:100px;'));
 }
   ?></td>
  </tr>
  
  <tr>
    <td align="left" valign="top">Primary Consultant</td>
    <td valign="top">:</td>
    <td valign="top"><?php echo $this->Form->input('Billing.primary_consultant',array('value'=>$primaryConsultant[0]['fullname'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'width:150px;')); 
				?></td>
  </tr>
 
  
  <tr>
    <td align="left" valign="top">Other Consultant Name</td>
    <td valign="top">:</td>
    <td valign="top"><?php 
    if(isset($finalBillingData['FinalBilling']['other_consultant'])){
    	echo $this->Form->input('Billing.other_consultant',array('value'=>$finalBillingData['FinalBilling']['other_consultant'],'class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'width:150px;')); 
	
    }else{
    	echo $this->Form->input('Billing.other_consultant',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'totaladvancepaid','style'=>'width:150px;')); 
	}?>
	<input type="button" id="addButton" value="Add more" align="right" class="blueBtn">&nbsp;&nbsp;&nbsp;
	<?php echo $this->Html->link('Tariff & Services',array('controller'=>'tariffs','action'=>'viewTariffAmount'),array('style'=>'text-decoration:underline;','target'=>'_blank'));?>
	</td>
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
  <tr><td><table width="100%" cellpadding="5" cellspacing="0" border="0">
            	<tr>
                	<td valign="top">
                	Diagnosis<br />
                    <?php //echo $patient['Diagnosis']['final_diagnosis'];
  echo $this->Form->textarea('Billing.final_diagnosis', array('value'=>$diagnosisData['Diagnosis']['final_diagnosis'],'class' => 'textBoxExpnd','id' => 'diagnosis','row'=>'3')); 
  ?>
                    </td>
                </tr>
                <?php if(!empty($surgeriesData)){?>
                <tr>
                	<td valign="top">
                	Surgeries<br />
                    <?php 
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
            </table></td></tr>
  <tr>
    <td width="100%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="5" class="tdBorderTpBt">
          <thead>
          <td width="50" align="center" class="tdBorderRtBt">Sr. No.</td>
          
          <?php if($corporateEmp != Configure::read('privateLabel')) { //7 for private patient only?>
          	<td width="80" align="center" class="tdBorderRtBt"><?php echo $patient['TariffStandards']['name'];?> MOA Sr. No.</td>
          <?php } ?>
          
            <td align="center" class="tdBorderRtBt">Item</td>
            <td width="80" align="center" class="tdBorderRtBt" style="display:<?php echo $hideCGHSCol ;?>">CGHS Code No.</td>
            <td width="65" align="center" class="tdBorderRtBt">Rate</td>
            <td width="65" align="center" class="tdBorderRtBt">Qty.</td>            
            <td width="100" align="center" class="tdBorderBt">Amount</td>
          </tr>
          <?php $srNo=0; ?>
          <?php if($patient['Patient']['payment_category']!='cash'){?>
          <tr>
            <td align="center" class="tdBorderRt">&nbsp;</td>
              <?php if($corporateEmp != Configure::read('privateLabel')) { //7 for private patient only?>
            <td align="center" class="tdBorderRt">&nbsp;</td>
            <?php } ?>
            <!--<td class="tdBorderRt" style="font-size:12px;"><strong><i>Conservative Charges</i></strong></td>
            -->
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
          </thead>
          
          
          
          <?php $lastSection='Conservative Charges';?>
          <?php }?>
          <?php if($registrationRate!='' && $registrationRate !=0){
          
          		$srNo++;
          ?>
		          <tr>
		          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
		          	
		          	<?php if($corporateEmp != Configure::read('privateLabel')) { //7 for private patient only?>
		          	<td align="center" class="tdBorderRt"><?php echo $registrationChargesData['TariffAmount']['moa_sr_no'];
		          	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $registrationChargesData['TariffAmount']['moa_sr_no'],
		          		'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
		          	?></td>
		          	<?php } ?>
		          	
		            <td class="tdBorderRt">Registration Charges</td>
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
		            //echo $this->Number->format($registrationRate,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),",";
		            echo $this->Number->currency($registrationRate);
		            ?></td>
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
	          	
	          	<?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
	          	<td align="center" class="tdBorderRt">&nbsp;</td>
	          	<?php }?>
	          	
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
           foreach($cBilling as $consultantBillingDta){#pr($consultantBilling);exit;
           	foreach($consultantBillingDta as $consultantBilling){#pr($consultantBilling);exit;
           $v++;$srNo++;
           	?>
           <tr>
           <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
           
           <?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
           <td align="center" class="tdBorderRt">&nbsp;</td>
           <?php }?>
           
            <td class="tdBorderRt">
            <?php 
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
	            //echo $this->Number->format(($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling)),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
	            echo $this->Number->currency($consultantBilling[0]['ConsultantBilling']['amount']*count($consultantBilling));
            ?></td>
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
					
					<?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<?php }?>
					
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
				 //if surgery is package
				 	if($uniqueSlot['validity']> 1){
				 		
				 ?>
		          	<tr>
			          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
			          	
			          	<?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
			          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['moa_sr_no'];?></td>
			          	<?php }?>
			          	
			            <td class="tdBorderRt" style="padding-left:10px;"><?php  
				            echo $uniqueSlot['name'];
				            //echo '(<i>'.$uniqueSlot['doctor'].'</i>)';
				           		      
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
			            //echo '1';
			            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => 1,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
			            echo $uniqueSlot['cost'];
			            ?></td>
			            <td align="center" valign="top" class="tdBorderRt"><?php 
			            //echo $uniqueSlot['cost'];
			            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $uniqueSlot['cost'],'legend'=>false,'label'=>false,'style'=>'text-align:right'));
			            echo '1';
			            ?></td>
			            
			            <td align="right" valign="top"><?php 
			            //echo $uniqueSlot['cost'];
			            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $uniqueSlot['cost'],'legend'=>false,'label'=>false,'style'=>'text-align:right'));
			            echo $uniqueSlot['cost'];
			            $totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost'];
			            ?></td>
		          	</tr>	
		          	
				<?php }else{    ?>
					<tr>
		          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
		          	
		          	<?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
		          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot['moa_sr_no'];?></td>
		          	<?php }?>
		          	
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
		            //echo $uniqueSlot['cost'];
		            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $surgonCost,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
		            echo "<br>".$uniqueSlot['cost'];
		            echo "<br>".$uniqueSlot['anaesthesist_cost'];
		            $totalNewWardCharges = $totalNewWardCharges + $uniqueSlot['cost']+$uniqueSlot['anaesthesist_cost'];
		            ?></td>
		          	</tr>
				<?php 	
				}//EOF package cond for surgery display
				
          		}else{
					$v++;
					$wardNameKey = key($uniqueSlot);#pr($uniqueSlot[$wardNameKey][0]['cost']);exit;
					$wardCostPerWard = $uniqueSlot[$wardNameKey][0]['cost'];
					 
					$daysCountPerWard=count($uniqueSlot[$wardNameKey]);
					$totalWardNewCost = $totalWardNewCost + (count($uniqueSlot[$wardNameKey]) * $wardCostPerWard);
					$totalWardDays = $totalWardDays + count($uniqueSlot[$wardNameKey]);
					$totalWardDaysW = count($uniqueSlot[$wardNameKey]);
					
					/*************************************************************/
					$splitDateIn = explode(" ",$uniqueSlot[$wardNameKey][0]['in']);
		            $splitDateOut = explode(" ",$uniqueSlot[$wardNameKey][$daysCountPerWard-1]['out']);
		   	 		$inDate= $this->DateFormat->formatDate2Local($uniqueSlot[$wardNameKey][0]['in'],'yyyy/mm/dd');//.' '.$splitDateIn[1];
		            $outDate= $this->DateFormat->formatDate2Local($uniqueSlot[$wardNameKey][$daysCountPerWard-1]['out'],'yyyy/mm/dd');//.' '.$splitDateOut[1];
					/*************************************************************/
					
			if($patient['Patient']['payment_category']!='cash'){
				
				if($conservativeCount==0) {
					$conservativeDateRange = ' ('.$inDate.'-'.$outDate.')' ;
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
					
					<?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
					<td align="center" class="tdBorderRt">&nbsp;</td>
					<?php }?>
					
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
          	<?php //echo $uniqueSlot[$wardNameKey][0]['moa_sr_no'].'here';exit;?>
          	<tr>
          	<td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
          	
          	<?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
          	<td align="center" class="tdBorderRt"><?php echo $uniqueSlot[$wardNameKey][0]['moa_sr_no'];
          	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $uniqueSlot[$wardNameKey][0]['moa_sr_no'],'legend'=>false,'label'=>false));
          	?></td>
          	<?php }?>
          	
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
   			?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php 
            
          	if($hospitalType == 'NABH'){ 
   				echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot[$wardNameKey][0]['cghs_nabh'],'legend'=>false,'label'=>false));
   			}else{ 
   				echo $this->Form->hidden('',array('name'=>"data[Billing][$v][nabh_non_nabh]",'value' => $uniqueSlot[$wardNameKey][0]['cghs_non_nabh'],'legend'=>false,'label'=>false));
   			}
   			
   			
   			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][unit]",'value' => $totalWardDays,'legend'=>false,'label'=>false,'style'=>'text-align:center'));
   			//echo $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
   			echo $this->Number->currency($wardCostPerWard);
   			?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            //echo $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($wardCostPerWard,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $totalWardDaysW;
            ?></td>
            
            <td align="right" valign="top"><?php 
            //echo $this->Number->format(($totalWardDays*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            //echo $this->Number->format(($totalWardDaysW*$wardCostPerWard),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->currency($totalWardDaysW*$wardCostPerWard);
            $totalNewWardCharges = $totalNewWardCharges + ($totalWardDaysW*$wardCostPerWard);
            ?></td>
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
          
          <?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
          <td align="center" class="tdBorderRt"><?php 
          //echo $doctorChargesData['TariffAmount']['moa_sr_no'].'here';exit;
          echo $doctorChargesData['TariffAmount']['moa_sr_no'];
          echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $doctorChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false));
          ?></td>
          <?php  }?>
          
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
           
            //echo $forHiddenDoctorRate  = $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            //echo $doctorRate;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $forHiddenDoctorRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $totalWardDays;
            ?></td>
            
            <td align="right" valign="top"><?php 
            //echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            //echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->currency($totalWardDays*$doctorRate);
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
          	
          <?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
          	<td align="center" class="tdBorderRt"><?php 
          	echo $nursingChargesData['TariffAmount']['moa_sr_no'];
          	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $nursingChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false));
          	?></td>
            <?php }?>
            
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
            //echo $this->Number->format(($nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->currency($nursingRate);
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            //echo $nursingRate;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $nursingRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo $totalWardDays;
            ?></td>
            
            <td align="right" valign="top"><?php 
            //echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            //echo $this->Number->format(($totalWardDays*$nursingRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->currency($totalWardDays*$nursingRate);
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
          	
          	<?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
          	<td align="center" class="tdBorderRt"><?php 
          echo $doctorChargesData['TariffAmount']['moa_sr_no'];
          echo $this->Form->hidden('',array('name'=>"data[Billing][$v][moa_sr_no]",'value' => $doctorChargesData['TariffAmount']['moa_sr_no'],'legend'=>false,'label'=>false));
          ?></td>
            <?php }?>
            
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
            //echo $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->currency($doctorRate);
            //echo $doctorRate;
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
            //echo $doctorRate;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $doctorRate,'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            echo '1';
            ?></td>
            
            <td align="right" valign="top"><?php 
            //echo $this->Number->format(($totalWardDays*$doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][amount]",'value' => $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'style'=>'text-align:right'));
            //echo $this->Number->format(($doctorRate),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->currency($doctorRate);
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
			$nursingCnt = 0;
		   	foreach($nursingServices as $nursingServicesKey=>$nursingServicesCost){ 
				$resetNursingServices[$nursingCnt]['qty'] = $nursingServicesCost['ServiceBill']['no_of_times'];
				$resetNursingServices[$nursingCnt]['name'] = $nursingServicesCost['TariffList']['name'] ; 																						
				$resetNursingServices[$nursingCnt]['cost'] = $nursingServicesCost['ServiceBill']['amount'];
				$resetNursingServices[$nursingCnt]['moa_sr_no'] = $nursingServicesCost['TariffAmount']['moa_sr_no'];
				$resetNursingServices[$nursingCnt]['nabh_non_nabh'] = $nursingServicesCost['TariffList']['cghs_code']; 
				$nursingCnt++;
		   	}
		   
		   	 #pr($resetNursingServices);exit;
	   		//EOF pankaj
		   	#if($patient['Patient']['admission_type']!='OPD')
		  	#echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Nursing Charges",'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		   	foreach($resetNursingServices as $resetNursingServicesName=>$nursingService){
		  	$k++;
		  	$totalUnit=$nursingService['qty'];
		  	  $srNo++;
		  	
		  	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][name]",'value' => $nursingService['name'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		  	?>
          
            <tr>
            <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
           
           <?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
            <td align="center" class="tdBorderRt"><?php 
            if($nursingService['moa_sr_no']!='')
            	echo $nursingService['moa_sr_no'];
            else echo '&nbsp;';
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][moa_sr_no]",'value' => $nursingService['moa_sr_no'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
            ?></td>
            <?php }?>
            
            <td class="tdBorderRt"><?php echo $nursingService['name'];?></td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>"><?php 
            if($nursingService['nabh_non_nabh']!='')
            	echo $nursingService['nabh_non_nabh'];
            else echo '&nbsp;';
            ?></td>
            <td align="right" valign="top" class="tdBorderRt"><?php
            	 	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][nabh_non_nabh]",'value' => $nursingService['nabh_non_nabh'],'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
           			//$totalUnit = array_sum($nursingService['qty']);
				  	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][rate]",'value' => $nursingService['cost'],'legend'=>false,'label'=>false,'id' => 'nursing_service_rate','style'=>'text-align:right;'));
				  	echo $nursingService['cost'];
            ?></td>
            <td align="center" valign="top" class="tdBorderRt"><?php 
              	if($totalUnit<1) $totalUnit=1;
            	echo $totalUnit;
             	echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][unit]",'value' => $totalUnit,'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:center;'));
		    
            
            ?></td>
            
            <td align="right" valign="top"><?php 
		  $hospitalType = $this->Session->read('hospitaltype');
            $totalNursingCharges1=0;
		  			echo $this->Form->hidden('',array('name'=>"data[Billing][$v][hasChild][$k][amount]",'value' => $this->Number->format($totalUnit*$nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'nursing_service_amount','style'=>'text-align:right;'));
					//echo $this->Number->format($totalUnit*$nursingService['cost'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		  			echo $this->Number->currency($totalUnit*$nursingService['cost']);
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
		   
		  <?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
		   <td align="center" class="tdBorderRt">&nbsp;</td>
		   <?php }?>
		   
            <td class="tdBorderRt ">Pharmacy Charges</td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt ">
<?php   echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
		//echo $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
		echo $this->Number->currency(ceil($pharmacy_charges-$pharmacyPaidAmount));
		
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
            //echo $this->Number->format(ceil($pharmacy_charges-$pharmacyPaidAmount),array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            echo $this->Number->currency(ceil($pharmacy_charges-$pharmacyPaidAmount));
            //echo $this->Number->format($pharmacy_charges,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?></td>
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
           
           <?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
           <td align="center" class="tdBorderRt">&nbsp;</td>
           <?php }?>
           
            <td class="tdBorderRt">Laboratory Charges
            <?php $v++;
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][name]",'value' => "Laboratory Charges",'legend'=>false,'label'=>false));
            ?>
            </td>
            <td align="center" class="tdBorderRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderRt">
            <?php
            echo $this->Form->hidden('',array('name'=>"data[Billing][$v][rate]",'value' => $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)),'legend'=>false,'label'=>false,'id' => 'registration_rate','style'=>'text-align:right;'));
			//echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false)); 
			echo $this->Number->currency($lCost);
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
            		//echo $this->Number->format($lCost,array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
            		echo $this->Number->currency($lCost);
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
           
          <?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
           <td align="center" class="tdBorderRt">&nbsp;</td>
           <?php }?>
           
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
          
          <?php 
          $otherServicesCharges=0;
          foreach($otherServicesData as $otherServiceD){
          $v++;$srNo++;
          	?>
         
         <tr>
         <td align="center" class="tdBorderRt"><?php echo $srNo;?></td>
         
         <?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
         <td align="center" class="tdBorderRt">&nbsp;</td>
         <?php }?>
         
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
          
		  	<!--  Registration Charges -->
  			<?php 
  			//echo $otherServicesCharges .'-'. $registrationRate .'-'. $totalNursingCharges .'-'. $totalDoctorCharges .'-'. $totalNewWardCharges .'-'. $totalCost .'-'.+ $lCost.'-'. $rCost;exit;
  			#$totalCost = $otherServicesCharges + $registrationRate + $totalNursingCharges + $totalDoctorCharges + $totalNewWardCharges + $totalCost + $lCost + $rCost;//-$radPaidAmount-$labPaidAmount;// + $extraSurgeryCost;
  			$totalCost = $otherServicesCharges + $registrationRate + $totalNursingCharges + $totalDoctorCharges + $totalNewWardCharges + $totalCost + $lCost + $rCost-$radPaidAmount-$labPaidAmount+$anesthesiaCharges;// + $extraSurgeryCost;
  			
  			?>
  			<!-- Registration Charges -->
          
          <tr>
          	<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
          	<?php if($corporateEmp != Configure::read('privateLabel')) { // for private patient only?>
          	<td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
          	<?php }?>
            <td align="right" valign="top" class="tdBorderTpRt"><strong>Total</strong></td>
            <td align="center" class="tdBorderTpRt" style="display:<?php echo $hideCGHSCol ;?>">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
            <td align="right" valign="top" class="tdBorderTpRt">&nbsp;</td>
            
            <td align="right" valign="top" class="tdBorderTp totalPrice"><strong><span class="WebRupee"></span><?php 
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
            <td valign="top" class="boxBorderRight columnPad">
            	Amount Chargeable (in words)<br />
				<strong><?php 
				$totalCost = ceil($totalCost);
				echo $this->RupeesToWords->no_to_words($totalCost);?></strong>            </td>
            	<td width="292">
            	<table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Advance Paid</td>
                        <td align="right" valign="top" class="tdBorderBt"><?php 
                         //echo $this->Html->image('icons/rupee_symbol_white.png');
                        echo $this->Number->currency(ceil($totalAdvancePaid));
                        echo $this->Form->hidden('Billing.amount_paid',array('value' => ($totalAdvancePaid),'legend'=>false,'label'=>false));
                        ?></td>
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
                        ?></td>
                    </tr>
                    
                    <tr>
                    	<td width="121" height="20" valign="top" class="tdBorderRtBt">&nbsp;Reason for Discount</td>
                        <td align="right" valign="top" class="tdBorderBt"><?php 
                       
                        echo $finalBillingData['FinalBilling']['reason_for_discount'];
                        echo $this->Form->hidden('Billing.reason_for_discount',array('value' => $finalBillingData['FinalBilling']['reason_for_discount'],'legend'=>false,'label'=>false));
                        ?></td>
                    </tr>
                    <?php }?>
                	<tr>
                	  <td height="20" valign="top" class="tdBorderRtBt">&nbsp;
                	  <?php if($mode=='direct') echo 'To Pay on '.$dynamicText;
    						else echo 'To Pay ';?>
                	  
                	  </td>
                	  <td align="right" valign="top" class="tdBorderBt"><?php 
                	  //echo $this->Html->image('icons/rupee_symbol_white.png');
                	  echo $this->Number->currency(ceil($totalCost-$totalAdvancePaid-$discountAmount));
                	  echo $this->Form->hidden('Billing.amount_pending',array('value' => ($totalCost-$totalAdvancePaid-$discountAmount),'legend'=>false,'label'=>false));
                	  ?></td>
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
            	<td height="18" align="left" valign="top">Hospital Service Tax No.</td>
              	<td width="15" align="center" valign="top">:</td>
                <td align="left" valign="top"><strong><?php echo $this->Session->read('hospital_service_tax_no');?></strong></td>      
      		</tr>
        	<tr>
        	  <td height="20" align="left" valign="top">Hospitals PAN</td>
        	  <td align="center" valign="top">:</td>
        	  <td align="left" valign="top"><strong><?php echo $this->Session->read('hospital_pan_no');?></strong></td>
      	  </tr>
        	<tr>
        	  <td height="20" align="left" valign="top"><strong>Signature of Patient :</strong></td>
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
            <td width="55%" class="columnPad boxBorderRight">&nbsp;
            </td>
            <td width="45%" align="right" valign="bottom" class="columnPad tdBorderTp">
            	<strong><?php echo $this->Session->read('billing_footer_name');?></strong><br /><br /><br />
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td width="85">Bill Manager</td>
                        <td width="65">Cashier</td>
                        <td width="80">Med.Supdt. </td>
                        <td align="right">Authorised Signatory</td>
                	</tr>
                </table>
            </td>
          </tr>
        </table>
    </td>
  </tr>
  
</table>
<table width="800"  cellspacing="3" cellpadding="3" border="0" align="center">
<tr><td align="right">
						<?php 
    //if($mode=='direct') echo '';
    //else {?>
    	<input class="blueBtn" style="margin:0px" type="submit" value="Save">
    	<?php 
    	echo $this->Html->link(__('Cancel'),array('action' => 'patientSearch',$patient['Patient']['id']), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0px'));
    //}
    ?>
                	  
                	  

</td></tr>



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
});
 </script>