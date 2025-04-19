<?php //debug($diagnosis['PregnancyCount']);exit;?>
	<style>
		.formFull td {
    color: #333333;
    font-size: 13px;
    padding: 2px 0;
}
.tabularForm {
    background:#000;
}

.tabularForm td {
    background: #ffffff;
    color: #333333;
    font-size: 13px;
    padding: 5px 8px;
   /*border:1px solid #3e474a;*/
}

.{color:#333333; }

#printBtn{
	float:right;
	padding:10px 40px 0px 0px;
}

.fontSize{
	font-weight:bold;
}
.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.tbl .totalPrice{font-size:14px;}
	</style>
	<div id="printButton" >
		<?php echo $this->Html->link('Print',"#",array('escape'=>true,'class'=>'blueBtn','onclick'=>'window.print();'))?>
	</div>
	<div class="clr"></div>
	<?php echo $this->element('print_patient_info');?>
	<!-- two column table end here -->
    
     <table class="" style="text-align:left;" width="100%">
 		<!-- BOF alleries -->
 			<?php
 				//BOF removing "since and frequency " text  if any 
 				 
 				$diagnosis['PatientPastHistory']     = array_map('removeText',$diagnosis['PatientPastHistory']) ;
 				$diagnosis['PatientFamilyHistory']     = array_map('removeText',$diagnosis['PatientFamilyHistory']) ;
 				$diagnosis['PatientPersonalHistory'] = array_map('removeText',$diagnosis['PatientPersonalHistory']) ;
 				
 				function removeText($value){  
 						if(($value == 'Since') || ($value == 'Frequency')){  
 							return '' ;
 						}else{
 							return $value ;
 						} 	 
 				}
 				//EOF since & frequency removal
 				
 				$allergies = array_map('trim',$diagnosis['PatientAllergy']) ; //remove white spaces
 				if((
 					($allergies['allergies']==1) && (($allergies['from1']) || ($allergies['from2']) || ($allergies['from3']) ||
 													($allergies['reaction1']) || ($allergies['reaction2']) || ($allergies['reaction3']))
 					) || ($allergies['allergies']==0)
 				  ){
 		 
            			
 			?>
 			<tr>
	             <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">
	                    Allergies
	             </td>
	            <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
	               <table width="100%" border="0" cellspacing="0" cellpadding="0" class="">
	                     <tr>
		                       <td>
			                        <?php   
			                        	if($diagnosis['PatientAllergy']['allergies']==1){
				                       	 	$class = '';
				                        }else{
				                       	 	$class  ='hidden';
				                        } 
				                     ?>
		                         </td>
		                         <td>
		                         	<?php 
		                         		echo ($diagnosis['PatientAllergy']['allergies']!='1')?'No':'';                        	 	
		                         	?>
			                     </td>
			             </tr>
			         </table>
	                 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm <?php echo $class ;?>"   id="allergy-table">
	                 		<tr>
	                 			<td valign="middle"><strong>Drugs/Food/Latex/Contrast/Other</strong></td>
	                 			<td valign="middle"><strong>Reaction </strong></td>
	                 		</tr>
	                 		<?php if(!empty($diagnosis['PatientAllergy']['from1']) || !empty($diagnosis['PatientAllergy']['reaction1'])) {?>                        		
	                        <tr>
		                        
		                        <td valign="top">
			                        <?php 
			                        	echo $diagnosis['PatientAllergy']['from1'] ;                          
			                         ?>
		                        </td>
		                        
		                        <td valign="top">
			                        <?php
			                        	echo $diagnosis['PatientAllergy']['reaction1'] ;                         
			                         ?>
		                        </td>
	                        </tr>
	                        <?php } ?>
	                        <?php if(!empty($diagnosis['PatientAllergy']['from2']) || !empty($diagnosis['PatientAllergy']['reaction2'])) {?>
	                        <tr>
		                        
		                        <td valign="top">
		                        <?php 
		                        echo $diagnosis['PatientAllergy']['from2'] ;                          
		                         ?>
		                        </td>
		                        
		                        <td valign="top">
		                        <?php        	echo $diagnosis['PatientAllergy']['reaction2'] ;           ?>
		                        </td>
	                        </tr>
	                        <?php } ?>
	                        <?php if(!empty($diagnosis['PatientAllergy']['from3']) || !empty($diagnosis['PatientAllergy']['reaction3'])) {?>
	                        <tr>
		                        
		                        <td valign="top">
		                        <?php 
		                        echo $diagnosis['PatientAllergy']['from3'] ; 
		                          
		                         ?>
		                        </td>
		                       
		                        <td valign="top">
		                        <?php echo $diagnosis['PatientAllergy']['reaction3'] ; ?>
	                        	</td>
	                        </tr>
	                        <?php } ?>	                        		                   		 
	                  </table>
	            </td>                       
   			</tr>
   			<?php } if($diagnosis['Diagnosis']['complaints']!=''){ ?>
   			<tr>
   				 <td width="19%" valign="top" class=" fontSize" style="padding-top:10px;">
   				 		<?php echo __('Presenting Complaints With Duration');?>
   				 </td>
   				  <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
   				  	<?php echo nl2br($diagnosis['Diagnosis']['complaints']); ?>
   				  </td>
   			</tr>
   			<?php } if($diagnosis['Diagnosis']['lab_report']!=''){ ?>
    		<tr>
   				 <td width="19%" valign="top" class=" fontSize" style="padding-top:10px;">
   				 		<?php echo __('Significant Tests Done/Laboratory Reports');?>
   				 </td>
   				  <td width="80%" valign="top" style="padding-top:10px;padding-left:10px;">
   				  	<?php echo nl2br($diagnosis['Diagnosis']['lab_report']); ?>
   				  </td>
   			</tr>	 	
   			<?php } ?>	                  
        	<?php if(!empty($diagnosis)){ 
        	//debug($diagnosis['NewCropPrescription'][0]['drug_name']);//exit;?>
        		<tr>  
        	<td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">Current Treatment</td>
                         <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">
			

			<?php if(!empty($diagnosis['NewCropPrescription']['0']['drug_name'])){?>	
		
			<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
				<tr>

					<td class="sub_title"><strong><?php echo __("Drug Name");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("Dose");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("From");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("Route");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("Frequency");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("Days");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("Qty");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("Refills");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("PRN");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("DAW");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("Special Instruction");?>
					</strong>
					</td>
					<td class="sub_title"><strong><?php echo __("Is Active");?>
					</strong>
					</td>									
				</tr>
				<?php foreach($diagnosis['NewCropPrescription'] as $history){ ?>
				<tr>

					<td><?php echo $history['drug_name'];?>
					</td>
					<td><?php echo $history['dose'];?>
					</td>
					<td><?php echo $history['strength'];?>
					</td>
					<td><?php echo $history['route'];?>
					</td>
					<td><?php echo $history['frequency'];?>
					</td>
					<td><?php echo $history['day'];?>
					</td>
					<td><?php echo $history['quantity'];?>
					</td>
					<td><?php echo $history['refills'];?>
					</td>
					<td><?php echo $history['prn'];?>
					</td>
					<td><?php echo $history['daw'];?>
					</td>
					<td><?php echo $history['special_instruction'];?>
					</td>
					<td><?php echo $history['archive'];?>
					</td>			
				</tr>
				<?php } ?>
			</table>		
	<?php }?>	
	</td>
	</tr>
        	<tr>
        	 <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;"><strong>Significant History</strong></td>
        	 </tr>
        	 
        	 
        	<tr>  
        	<td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">Past Medical History</td>
                         <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">
			

			<?php if(!empty($diagnosis['PastMedicalHistory']['0']['illness'])){?>	
		
			<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
				<tr>

					<td width="17% !important" class="sub_title"><strong><?php echo __("Problem");?>
					</strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Status");?>
					</strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Duration");?>
					</strong>
					</td>
					<td width="17%" class="sub_title"><strong><?php echo __("Comment");?>
					</strong>
					</td>
				</tr>
				<?php foreach($diagnosis['PastMedicalHistory'] as $history){ ?>
				<tr>

					<td><?php echo $history['illness'];?>
					</td>
					<td><?php echo $history['status'];?>
					</td>
					<td><?php echo $history['duration'];?>
					</td>
					<td><?php echo $history['comment'];?>
					</td>
				</tr>
				<?php } ?>
			</table>		
	<?php }?>	
	</td>
	</tr>
	<?php if(!empty($diagnosis['PastMedicalRecord']['preventive_care'])){?>
	<tr>

	 <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;"></td>
                         <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_btm">
				<tr>
					<td valign="top" width="120"><?php echo __("Preventive Care :"); ?>
					
					</td>
					<td><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$diagnosis['PastMedicalRecord']['preventive_care'];?>
						<?php // echo $medicalHistory['PastMedicalRecord']['preventive_care'];?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<?php }?>
		<tr>
			
			 <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">Family History</td>
                         <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">
			

			<?php if(!empty($diagnosis['FamilyHistory']['problemf']) || !empty($diagnosis['FamilyHistory']['problemm']) || !empty($diagnosis['FamilyHistory']['problemb']) || !empty($diagnosis['FamilyHistory']['problems']) || !empty($diagnosis['FamilyHistory']['problemson']) || !empty($diagnosis['FamilyHistory']['problemd'])){ ?>	
		
			<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
				<tr>
	
					<td width="17% !important" class="sub_title"><strong><?php echo __("Relation");?>
					</strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Problem");?>
					</strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Status");?>
					</strong>
					</td>
					
					<td width="17%" class="sub_title"><strong><?php echo __("Comment");?>
					</strong>
					</td>
				</tr>
				<?php if(!empty($diagnosis['FamilyHistory']['problemf'])){ ?>
				<tr>

					<td><?php echo __("Father");?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['problemf'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['statusf'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['commentsf'];?>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($diagnosis['FamilyHistory']['problemm'])){ ?>
				<tr>

					<td><?php echo __("Mother");?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['problemm'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['statusm'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['commentsm'];?>
					</td>
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['FamilyHistory']['problemb'])){ ?>
				<tr>

					<td><?php echo __("Brother");?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['problemb'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['statusb'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['commentsb'];?>
					</td>
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['FamilyHistory']['problems'])){ ?>
				<tr>

					<td><?php echo __("Sister");?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['problems'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['statuss'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['commentss'];?>
					</td>
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['FamilyHistory']['problemson'])){ ?>
				<tr>

					<td><?php echo __("Son");?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['problemson'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['statusson'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['commentsson'];?>
					</td>
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['FamilyHistory']['problemd'])){ ?>
				<tr>

					<td><?php echo __("Daughter");?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['problemd'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['statusd'];?>
					</td>
					<td><?php echo $diagnosis['FamilyHistory']['commentsd'];?>
					</td>
				</tr>
				<?php } ?>
				
			</table>		
	<?php }?>	
	</td>
	</tr>
	
	<tr>
	<td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">Obstetric History</td>
    <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">	

			<?php  if(!empty($diagnosis['PastMedicalRecord']['age_menses']) || !empty($diagnosis['PastMedicalRecord']['length_period']) || !empty($diagnosis['PastMedicalRecord']['days_betwn_period']) || !empty($diagnosis['PastMedicalRecord']['recent_change_period']) || !empty($diagnosis['PastMedicalRecord']['age_menopause'])){ ?>	
		
			<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
				
				<?php if(!empty($diagnosis['PastMedicalRecord']['age_menses'])){ ?>
				<tr>

					<td width="19%"><?php echo __("Age Onset of Menses:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['age_menses'];?>
					</td>
					
				</tr>
				<?php } ?>
				<?php if(!empty($diagnosis['PastMedicalRecord']['length_period'])){ ?>
				<tr>

					<td><?php echo __("Length of Periods:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['length_period'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['PastMedicalRecord']['days_betwn_period'])){ ?>
				<tr>

					<td><?php echo __("Number of days between Periods:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['days_betwn_period'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['PastMedicalRecord']['recent_change_period'])){ ?>
				<tr>

					<td><?php echo __("Any recent changes in Periods: ");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['recent_change_period'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['PastMedicalRecord']['age_menopause'])){ ?>
				<tr>

					<td><?php echo __("Age at Menopause: ");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['age_menopause'];?>
					</td>					
				</tr>
				<?php } ?>				
			</table>		
	<?php }?>	
	</td>
	</tr>
	 
        	<tr>  
        	<td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;"></td>
                         <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">Number of Pregnancies:
                         </td>
                         </tr>
			<tr>  
        	<td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;"></td>
                         <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">

			<?php if(!empty($diagnosis['PregnancyCount']['0']['date_birth'])){?>	
		
			<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
				<tr>

					<td width="17% !important" class="sub_title"><strong><?php echo __("Date of Birth");?>
					</strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Weight (in lbs)");?>
					</strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Baby's Gender");?>
					</strong>
					</td>
					<td width="17%" class="sub_title"><strong><?php echo __("Weeks Pregnant");?>
					</strong>
					</td>
					<td width="5%" class="sub_title"><strong><?php echo __("Type of Delivery");?>
					</strong>
					</td>
					<td width="17%" class="sub_title"><strong><?php echo __("Complications");?>
					</strong>
					</td>
				</tr>
				<?php foreach($diagnosis['PregnancyCount'] as $history){ ?>
				<tr>

					<td><?php echo $history['date_birth'];?>
					</td>
					<td><?php echo $history['weight'];?>
					</td>
					<td><?php echo $history['baby_gender'];?>
					</td>
					<td><?php echo $history['week_pregnant'];?>
					</td>
					<td><?php echo $history['type_delivery'];?>
					</td>
					<td><?php echo $history['complication'];?>
					</td>					
				</tr>
				<?php } ?>
			
			</table>		
	<?php }?>	
	</td>
	</tr>
	
	<tr>

	 <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;"></td>
                         <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder table_format_btm">
				<tr>
					<td valign="top" width="120"><?php echo __("Abortions. Still Births. Miscarriages:"); ?>
					
					</td>
					<td><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$diagnosis['PastMedicalRecord']['abortions_miscarriage'];?>
						<?php // echo $medicalHistory['PastMedicalRecord']['preventive_care'];?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	
	<tr>
	<td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">Gynecology History</td>
    <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">	

			<?php  if(!empty($diagnosis['PastMedicalRecord']['present_symptom']) || !empty($diagnosis['PastMedicalRecord']['past_infection']) || !empty($diagnosis['PastMedicalRecord']['hx_abnormal_pap']) || !empty($diagnosis['PastMedicalRecord']['hx_cervical_bx']) || !empty($diagnosis['PastMedicalRecord']['hx_fertility_drug'])|| !empty($diagnosis['PastMedicalRecord']['hx_hrt_use'])|| !empty($diagnosis['PastMedicalRecord']['hx_irregular_menses'])|| !empty($diagnosis['PastMedicalRecord']['lmp'])|| !empty($diagnosis['PastMedicalRecord']['symptom_lmp'])){ ?>	
		
			<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
				
				<?php if(!empty($diagnosis['PastMedicalRecord']['present_symptom'])){ ?>
				<tr>

					<td width="19%"><?php echo __("Present Symptoms:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['present_symptom'];?>
					</td>
					
				</tr>
				<?php } ?>
				<?php if(!empty($diagnosis['PastMedicalRecord']['past_infection'])){ ?>
				<tr>

					<td><?php echo __("Past Infections:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['past_infection'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['PastMedicalRecord']['hx_abnormal_pap'])){ ?>
				<tr>

					<td><?php echo __("History of abnormal PAP smear:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['hx_abnormal_pap'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['PastMedicalRecord']['hx_cervical_bx'])){ ?>
				<tr>

					<td><?php echo __("History of cervical biopsy:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['hx_cervical_bx'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['PastMedicalRecord']['hx_fertility_drug'])){ ?>
				<tr>

					<td><?php echo __("History of fertility drugs:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['hx_fertility_drug'];?>
					</td>					
				</tr>
				<?php } ?>	
				<?php if(!empty($diagnosis['PastMedicalRecord']['hx_hrt_use'])){ ?>
				<tr>

					<td><?php echo __("History of HRT use: ");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['hx_hrt_use'];?>
					</td>					
				</tr>
				<?php } ?>		
				<?php if(!empty($diagnosis['PastMedicalRecord']['hx_irregular_menses'])){ ?>
				<tr>

					<td><?php echo __("History of irregular menses: ");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['hx_irregular_menses'];?>
					</td>					
				</tr>
				<?php } ?>		
				<?php if(!empty($diagnosis['PastMedicalRecord']['lmp'])){ ?>
				<tr>

					<td><?php echo __("L.M.P. :");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['lmp'];?>
					</td>					
				</tr>
				<?php } ?>					
				<?php if(!empty($diagnosis['PastMedicalRecord']['symptom_lmp'])){ ?>
				<tr>

					<td><?php echo __("Symptoms since L.M.P. : ");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['symptom_lmp'];?>
					</td>					
				</tr>
				
				<?php } ?>
							
			</table>	
				
	<?php }?>	
	</td>
	</tr>
	
	<tr>
	<td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;"></td>
    <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">Sexual Activity:</td>
    </tr>
    <tr>
<td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;"></td>
    <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">
			<?php  if(!empty($diagnosis['PastMedicalRecord']['sexually_active']) || !empty($diagnosis['PastMedicalRecord']['birth_controll']) || !empty($diagnosis['PastMedicalRecord']['breast_self_exam']) || !empty($diagnosis['PastMedicalRecord']['new_partner']) || !empty($diagnosis['PastMedicalRecord']['partner_notification'])|| !empty($diagnosis['PastMedicalRecord']['hx_hrt_use'])|| !empty($diagnosis['PastMedicalRecord']['hiv_education'])|| !empty($diagnosis['PastMedicalRecord']['pap_education'])|| !empty($diagnosis['PastMedicalRecord']['gyn_referral'])){ ?>	
		
			<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
				
				<?php if(!empty($diagnosis['PastMedicalRecord']['sexually_active'])){ ?>
				<tr>

					<td width="19%"><?php echo __("Are you sexually active? ");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['sexually_active'];?>
					</td>
					
				</tr>
				<?php } ?>
				<?php if(!empty($diagnosis['PastMedicalRecord']['birth_controll'])){ ?>
				<tr>

					<td><?php echo __("Do you use birth control? ");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['birth_controll'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['PastMedicalRecord']['breast_self_exam'])){ ?>
				<tr>

					<td><?php echo __("Do you do regular Breast self-exam? ");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['breast_self_exam'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['PastMedicalRecord']['new_partner'])){ ?>
				<tr>

					<td><?php echo __("New Partners? ");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['new_partner'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['PastMedicalRecord']['partner_notification'])){ ?>
				<tr>

					<td><?php echo __("Partner Notification");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['partner_notification'];?>
					</td>					
				</tr>
				<?php } ?>	
				<?php if(!empty($diagnosis['PastMedicalRecord']['hiv_education'])){ ?>
				<tr>

					<td><?php echo __("HIV Education Given:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['hiv_education'];?>
					</td>					
				</tr>
				<?php } ?>		
				<?php if(!empty($diagnosis['PastMedicalRecord']['pap_education'])){ ?>
				<tr>

					<td><?php echo __("PAP / STD Education Given:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['pap_education'];?>
					</td>					
				</tr>
				<?php } ?>		
				<?php if(!empty($diagnosis['PastMedicalRecord']['gyn_referral'])){ ?>
				<tr>

					<td><?php echo __("GYN Referral:");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['gyn_referral'];?>
					</td>					
				</tr>
				<?php } ?>					
			</table>	
				
	<?php }?>	
	</td>
	</tr>
	
	<?php if(!empty($diagnosis['PatientPersonalHistory'])){?>
	<tr>
	 <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">Social History</td>
                         <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">
                         
                         
			
		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
				<tr>

					<td width="17% !important" class="sub_title"><strong><?php echo __('Smoking:');?> </strong>
					</td>
					<td width="65%"><?php //debug($diagnosis);exit;
					 $smokingStatus = ($diagnosis['PatientPersonalHistory']['smoking'] == 1)? "Yes" : "No"; echo $smokingStatus;?>
					</td>
			
				<?php 
				if($smokingStatus == 'Yes'){?>
					
					<td><?php echo __($diagnosis['PatientPersonalHistory']['smoking_desc']);?>
					</td>	
					
					<td><?php echo $diagnosis['SmokingStatusOncs']['description'];?>
					</td>
				
					<td><?php echo $diagnosis['PatientSmoking']['smoking_fre'];?>
					</td>
				</tr>
				<?php } ?>

				<tr>

					<td><strong><?php echo __('Alcohol:');?> </strong>
					</td>
					<td><?php $alcoholStatus = ($diagnosis['PatientPersonalHistory']['alcohol'] == 1)? "Yes" : "No"; echo $alcoholStatus;?>
					</td>
				
				<?php if($alcoholStatus == 'Yes'){?>
				
					<td><?php echo __($diagnosis['PatientPersonalHistory']['alcohol_desc']);?>
					</td>
				
					<td><?php echo $diagnosis['PatientPersonalHistory']['alcohol_fre'];?>
					</td>
				</tr>
				<?php } ?>

				<tr>

					<td><strong><?php echo __('Substance Use:');?> </strong>
					</td>
					<td><?php $drugsStatus = ($diagnosis['PatientPersonalHistory']['drugs'] == 1)? "Yes" : "No"; echo $drugsStatus;?>
					</td>
		
				<?php if($drugsStatus == 'Yes'){?>
			
					<td><?php echo __($diagnosis['PatientPersonalHistory']['drugs_desc']);?>
					</td>				
					<td><?php echo $diagnosis['PatientPersonalHistory']['drugs_fre'];?>
					</td>
				</tr>
				<?php } ?>
				<tr>

					<td><?php echo __('Retired:');?>
					</td>
					<td><?php echo $diagnosis['PatientPersonalHistory']['retired'];?>
					</td>
				</tr>
				<tr>

					<td><strong><?php echo __('Caffiene Usage:');?> </strong>
					</td>
					<td><?php $tobaccoStatus = ($diagnosis['PatientPersonalHistory']['tobacco'] == 1)? "Yes" : "No"; echo $tobaccoStatus;?>
					</td>
				
				<?php if($tobaccoStatus == 'Yes'){?>
			
					<td><?php echo __($diagnosis['PatientPersonalHistory']['tobacco_desc']);?>
					</td>

				
					<td><?php echo $diagnosis['PatientPersonalHistory']['tobacco_fre'];?>
					</td>
				</tr>
				<?php } ?>

				<tr>

					<td><strong><?php echo __('Diet:');?> </strong>
					</td>
					<td><?php $dietStatus = ($diagnosis['PatientPersonalHistory']['diet'] == 1)? "Non-Veg" : "Veg"; echo $dietStatus;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php } //debug($medicalHistory['ProcedureHistory']);?>
	<?php if(!empty($diagnosis['ProcedureHistory'])){?>
	
	<tr>
	 <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">Surgical/Hospitalization History</td>
                         <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">
                         
                         
			
		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
				<tr>

					<td width="17% !important" class="sub_title"><strong><?php echo __("Surgical/Hospitalization");?>
					</strong>
					</td>
					<td width="6%" class="sub_title"><strong><?php echo __("Provider");?>
					</strong>
					</td>
					<td width="6%" class="sub_title"><strong><?php echo __("Age");?> </strong>
					</td>
					<td width="6%" class="sub_title"><strong><?php echo __("Date");?> </strong>
					</td>
					<td width="13%" class="sub_title"><strong><?php echo __("Comment");?>
					</strong>
					</td>
				</tr>
				<?php foreach($diagnosis['ProcedureHistory'] as $history){ ?>
				<tr>
					<td width="13%"><?php echo $history['procedure_name'];?>
					</td>
					<td width="8%"><?php echo $history['provider_name'];?>
					</td>
					<td><?php echo $history['age_value']." ".$history['age_unit'];?></td>
					<td><?php echo $this->DateFormat->formatDate2LocalForReport($history['procedure_date'],Configure::read('date_format'),false);?>
					</td>
					<td><?php echo $history['comment'];?></td>
				</tr>
				
				<?php }?>			
				
				<?php }//PastMedicalRecord ?>
			</table>
		</td>
	</tr>
	<?php  if(!empty($diagnosis['Diagnosis']['final_diagnosis'])){?>
	<tr>
	 <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">Diagnosis</td>
                         <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align='left' class="formFull formFullBorder table_format_btm">
				<tr>
					<td><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$diagnosis['Diagnosis']['final_diagnosis'];?>
						<?php // echo $medicalHistory['PastMedicalRecord']['preventive_care'];?>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
	<?php }?>
	
	<tr>
    <td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;"><strong>Investigation</strong></td>
    </tr>
     
	<tr>
	<td width="19%" valign="top" class=" fontSize" id="boxSpace" style="padding-top:10px;">Vitals</td>
    <td  width="80%" valign="top"   style="padding-top:10px;padding-left:10px;">	

			<?php  //if(!empty($diagnosis['BmiResult']['temperature']) || !empty($diagnosis['PastMedicalRecord']['temp_source']) || !empty($diagnosis['PastMedicalRecord']['hx_abnormal_pap']) || !empty($diagnosis['BmiResult']['hx_cervical_bx']) || !empty($diagnosis['PastMedicalRecord']['hx_fertility_drug'])|| !empty($diagnosis['PastMedicalRecord']['hx_hrt_use'])|| !empty($diagnosis['PastMedicalRecord']['hx_irregular_menses'])|| !empty($diagnosis['PastMedicalRecord']['lmp'])|| !empty($diagnosis['PastMedicalRecord']['symptom_lmp'])){ ?>	
		
			<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm">
				
				<?php if(!empty($diagnosis['BmiResult']['temperature'])){ ?>
				<tr>

					<td width="19%"><?php echo __("Temperature:");?>
					</td>
					<td><?php echo $diagnosis['BmiResult']['temperature'].''.$diagnosis['BmiResult']['myoption'];?>
					</td>
					
				
				<?php } if(!empty($diagnosis['BmiResult']['temp_source'])){ ?>
					<td><?php echo $diagnosis['BmiResult']['temp_source'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['BmiResult']['comment'])){ ?>
				<tr>

					<td><?php echo __("Comment :");?>
					</td>
					<td><?php echo $diagnosis['BmiResult']['comment'];?>
					</td>					
				</tr>
				<?php } if(!empty($diagnosis['BmiResult']['chief_complaint'])){ ?>
				<tr>
					<td><?php echo __("Chief Complaint");?>
					</td>
					<td><?php echo $diagnosis['BmiResult']['chief_complaint'];?>
					</td>					
				</tr>
				<?php } ?>
					<?php if(!empty($diagnosis['BmiResult']['respiration'])||($diagnosis['BmiResult']['respiration_volume'])){ ?>
				<tr>

					<td><?php echo __("Respiration: ");?>
					</td>
					<td><?php echo $diagnosis['BmiResult']['respiration'];?>
					</td>
					<td><?php echo $diagnosis['BmiResult']['respiration_volume'];?>
					</td>					
				</tr>
				<?php } ?>	
				<?php if(!empty($diagnosis['BmiResult']['weight'])||($diagnosis['BmiResult']['weight_volume'])){ ?>
				<tr>

					<td><?php echo __("Weight:");?>
					</td>
					<td><?php echo $diagnosis['BmiResult']['weight'].''.$diagnosis['BmiResult']['weight_volume'];?>
					</td>					
				</tr>
				<?php } ?>		
				<?php if(!empty($diagnosis['BmiResult']['height'])){ ?>
				<tr>

					<td><?php echo __("Height: ");?>
					</td>
					<td><?php echo $diagnosis['BmiResult']['height'].''.$diagnosis['BmiResult']['height_volume'];?>
					</td>			
					<td><?php echo $diagnosis['BmiResult']['feet_result'].'inches'.$diagnosis['BmiResult']['height_result'];?>
					</td>							
				</tr>
				<?php } ?>		
				<?php if(!empty($diagnosis['PastMedicalRecord']['lmp'])){ ?>
				<tr>

					<td><?php echo __("L.M.P. :");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['lmp'];?>
					</td>					
				</tr>
				<?php } ?>					
				<?php if(!empty($diagnosis['PastMedicalRecord']['symptom_lmp'])){ ?>
				<tr>

					<td><?php echo __("Symptoms since L.M.P. : ");?>
					</td>
					<td><?php echo $diagnosis['PastMedicalRecord']['symptom_lmp'];?>
					</td>					
				</tr>
				
				<?php } ?>
							
			</table>	
				
	<?php //}?>	
	</td>
	</tr>
	
	<?php }?>
	</tr>
        	<tr><td>&nbsp;</td></tr>
        	<tr><!--
                  <td width="19%" valign="top" class=""  style="padding-top:10px;">&nbsp;</td>
                  --><td  width="100%" colspan="2" valign="top"   style="padding-top:10px;">
                  	<table width="100%" border="0" cellspacing="1" cellpadding="5" class="">
                  		<tr>
                  			<td width="49%" valign="top">
                  				<table width="100%" border="0" cellspacing="1" cellpadding="0">	
                  					<tr>
                  						<td valign="top">Declaration by the Patient / Relative / Accompanying Person</td>
                  					</tr>
                  					<tr>
			                  			<td valign="top">
			                  				I  hereby declare that the facts recorded above are based on my narration and are accurate to the best of my knowledge
			                  			</td>
                  					</tr>
                  				</table>                  				
                  			</td>      
                  			<td>&nbsp;</td>            			
                  			<td width="49%">
                  				<table width="100%" border="0" cellspacing="1" cellpadding="5">	
                  					<tr>
                  						<td colspan="2" valign="top">Name of Patient / Relative / Accompanying</td>
                  					</tr>
                  					<tr>
			                  			<td valign="top">Person </td>
			                  			<td>:__________________________</td>
                  					</tr>
                  					<tr>
			                  			<td valign="top">Relationship With Patient </td>
			                  			<td>:__________________________</td>
                  					</tr>
                  					<tr>
			                  			<td valign="top">Signature  </td>
			                  			<td>:__________________________</td>
                  					</tr>
                  					<tr>
			                  			<td colspan="2" valign="top">Date : ___________ Time : _______</td>
                  					</tr>
                  				</table>                  				
                  			</td>
                  		</tr>                  		
                  	</table>                   
                  </td>
              </tr>  
 		</table>
  
		 	 
		  