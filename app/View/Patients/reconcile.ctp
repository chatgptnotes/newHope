<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array('jquery.fancybox-1.3.4')); ?>
<?php  echo $this->Html->script('fckeditor/fckeditor');  ?>
<style>
#boxspace {
	border-right: 0.3px solid #384144;
	padding-right: 5px;
}
</style>

<?php //echo $this->element('patient_information');?>


<div class="inner_title">
	<h3>
		<?php echo __('Reconcile'); ?>
		<div style="float: right;">
			<?php

			//echo $this->Html->link(__('Back to List'), array('controller'=>'imunization','action' => 'index',$patient_id,$id), array('escape' => false,'class'=>'blueBtn'));
			?>
		</div>
	</h3>

</div>

<table border="0">
	<tr>
		<td width="33%">
			<table>
				<tr>
					<td valign="middle"><strong><?php echo ('Medication List Source');?>
					</strong>
					</td>
					<td valign="middle">:</td>
					<td valign="middle" id="boxspace"><?php 
					echo $this->Form->input('type',array('readonly'=>'readonly','label'=>false,'style'=>'width:160px','options'=>array(''=>__('Please Select'),'1'=>__('Reported by patient')),'selected'=>'1','class'=>'type','onchange'=>'javascript:Reconcile();'));

					?>
					</td>
					<td>&nbsp;</td>
					<td valign="middle"><strong><?php echo ('Medication List Source');?>
					</strong></td>
					<td>:</td>
					<td valign="middle" id="boxspace"><?php 
					echo $this->Form->input('type1',array('readonly'=>'readonly','label'=>false,'style'=>'width:160px','options'=>array(''=>__('Please Select'),'4'=>__('Referral Summary')),'selected'=>'4','class'=>'type1','onchange'=>'javascript:Reconcile();'));

					?>
					</td>
					<td>&nbsp;</td>
					<td valign="middle" class="description2" style='display: none'><strong><?php echo ('Reconciled Medication List');?>
					</strong></td>
				</tr>
				<tr>
					<td colspan="3" valign="top">
						<table>
							<tr>
								<?php if(empty($prescription_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>
								<?php
								echo "<tr class='description' style='display:none'><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Medication" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Date of Prescription" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($prescription_data as $prescription_datas){
			
									//echo"<pre>";print_r($prescription_datas);
									$medication_name=$prescription_datas['NewCropPrescription']['description'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='description' style='display:none'><td>".$cnt.') '."</td><td>".$prescription_datas['NewCropPrescription']['description'] ."</td><td valign='middle' id='boxspace'>".$prescription_datas['NewCropPrescription']['date_of_prescription'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>
								<?php //echo $this->Form->create('User', array('type' => 'post','url' => 'https://preproduction.newcropaccounts.com/InterfaceV7/RxEntry.aspx','target'=>'aframe'));?>
								<?php
								echo "<tr class='rx'><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Medication" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Date of Prescription" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($patient_prescription_data as $patient_prescription_datas){
			
									//echo"<pre>";print_r($prescription_datas);
									$medication_name=$patient_prescription_datas['NewCropPrescription']['description'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='rx'><td>".$cnt.') '."</td><td>".$patient_prescription_datas['NewCropPrescription']['description'] ."</td><td valign='middle' id='boxspace'>".$patient_prescription_datas['NewCropPrescription']['date_of_prescription'] ."</td></tr>";
								?>
								</td>
								<?php }?>
								<td colspan="3" class="rx">
									<!-- <input type="button" id="medicationButton" value="Medication Rx" style="cursor:pointer", class= "blueBtn_hl7"> -->
									<?php echo $this->Form->input('Medication Rx', array('type' => 'button', 'class'=> 'blueBtn_hl7', 'id'=>'medicationRx', 'div' => false, 'label'=> false)); ?>
								</td>
							</tr>
						</table>
					</td>
					<td>&nbsp;</td>
					<td colspan="3" valign="top">
						<table>
							<tr>
								<?php if(empty($refferal_summary_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>
								<?php
								echo "<tr class='description1'><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Medication" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Date of Prescription" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($refferal_summary_data as $refferal_summary_datas){
			
									//echo"<pre>";print_r($prescription_datas);
									$refferal_name=$refferal_summary_datas['NewCropPrescription']['description'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='description1'><td>".$cnt.') '."</td><td>".$refferal_summary_datas['NewCropPrescription']['description'] ."</td><td id='boxspace'>".$refferal_summary_datas['NewCropPrescription']['date_of_prescription'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>
								<td class="rx1" style='display: none'><?php echo $this->Form->create('User', array('type' => 'post','url' => 'https://preproduction.newcropaccounts.com/InterfaceV7/RxEntry.aspx','target'=>'aframe'));?>
									<?php echo $this->Form->input('Past Medication Rx', array('type' => 'submit', 'class'=> 'blueBtn_hl7', 'id'=>'Rx', 'div' => false, 'label'=> false)); ?>
								</td>
								<?php echo $this->Form->end(); ?>
							</tr>
						</table>
					</td>
					<td>&nbsp;</td>
					<td colspan="3" valign="top">

						<table>
							<tr class='description2' style='display: none'>
								<?php if(empty($consolidated_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>

								<?php
								echo "<tr class='description2' style='display: none'><td>"."</td><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Medication" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Date of Prescription" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($consolidated_data as $consolidated_datas){
									//echo"<pre>";print_r($consolidated_datas);
									//$consolidated_data=$consolidated_datas['NewCropPrescription']['description'];
									$consolidated_data_id=$consolidated_datas['NewCropPrescription']['id'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='description2' style='display: none'><td><input type=checkbox class=ads_Checkbox value=$consolidated_data_id />"."</td><td>".$cnt.') '."</td><td>".$consolidated_datas['NewCropPrescription']['description'] ."</td><td id='boxspace'>".$consolidated_datas['NewCropPrescription']['date_of_prescription'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							
							<tr>
								<td  class="action" style='display: none'>Updated Date :</td>
								<td>&nbsp;</td>
								
								<td colspan='2' class="action" style='display: none'><?php echo $this->Form->input('NewCropPrescription.drm_date', array('type'=>'text','id' => 'drm_date','class' => 'dateclass', 'div' => false, 'label'=> false));?>
								</td>
							</tr> 
							<tr>
								<td colspan='3' class="action" style='display: none'><?php echo $this->Form->link('Delete', array('type' => 'button','value'=>'Delete', 'class'=> 'blueBtn_hl7', 'id'=>'delete', 'div' => false, 'label'=> false)); ?>
									<?php echo $this->Form->link('Undo', array('type' => 'button', 'value'=>'Undo','class'=> 'blueBtn_hl7', 'id'=>'undo', 'div' => false, 'label'=> false)); ?>
								</td>
								
								<td class="action" style='display: none'><?php echo $this->Form->link('Update Facesheet', array('type' => 'button', 'value'=>'Update Facesheet','class'=> 'blueBtn_hl7', 'id'=>'update_facesheet', 'div' => false, 'label'=> false)); ?>
								</td>
							</tr>
							
						</table>

						<table>
							<tr class='description_facesheet' style='display: none'>
								<?php if(empty($consolidated_facesheet_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>

								<?php
								echo "<tr class='description_facesheet' style='display: none'><td>"."</td><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Medication" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Date of Prescription" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($consolidated_facesheet_data as $consolidated_facesheet_datas){
									//echo"<pre>";print_r($consolidated_facesheet_datas);
									//$consolidated_data=$consolidated_datas['NewCropPrescription']['description'];
									$consolidated_facesheet_data_id = $consolidated_facesheet_datas['NewCropPrescription']['id'];

									$cnt++;
									//print_r($cnt);
			
									?>
								<td><?php
								echo "<tr class='description_facesheet' style='display: none'><td><input type=checkbox class=ads_facesheet_Checkbox value=$consolidated_facesheet_data_id />"."</td><td>".$cnt.') '."</td><td>".$consolidated_facesheet_datas['NewCropPrescription']['description'] ."</td><td id='boxspace'>".$consolidated_facesheet_datas['NewCropPrescription']['date_of_prescription'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>
								<td colspan='3' class="action_facesheet" style='display: none'>
									<?php echo $this->Form->link('Delete', array('type' => 'button','value'=>'Delete', 'class'=> 'blueBtn_hl7', 'id'=>'delete_facesheet', 'div' => false, 'label'=> false)); ?>
									<?php echo $this->Form->link('Undo', array('type' => 'button', 'value'=>'Undo','class'=> 'blueBtn_hl7', 'id'=>'undo_facesheet', 'div' => false, 'label'=> false)); ?>
								</td>
								<td class="action_facesheet" style='display: none'><?php echo $this->Form->link('Update Facesheet', array('type' => 'button', 'value'=>'Update Facesheet','class'=> 'blueBtn_hl7', 'id'=>'update_facesheet_medication', 'div' => false, 'label'=> false)); ?>
								</td>
							</tr>
						</table>

					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>

<table>
	<tr>
		<td class="reconcile"><?php echo $this->Form->link('Reconcile', array('type' => 'button','value'=>'Reconcile', 'class'=> 'blueBtn_hl7', 'onclick'=>'javascript:reconcile_show();', 'div' => false, 'label'=> false)); ?>
			<?php //echo $this->Form->input('Reconcile', array('type' => 'button', 'class'=> 'blueBtn_hl7', 'id'=>'reconcile_show', 'div' => false, 'label'=> false)); ?>
		</td>
		<td class="reconcile1" style='display: none'><?php echo $this->Form->link('Reconcile1', array('type' => 'button','value'=>'Reconcile1', 'class'=> 'blueBtn_hl7', 'onclick'=>'javascript:reconcile_facesheet_show();', 'div' => false, 'label'=> false)); ?>
		</td>
	</tr>
</table>

<hr></hr>

<div class="inner_title">
	<h3>
		<?php echo __('Problem'); ?>
		<div style="float: right;">
			<?php

			//echo $this->Html->link(__('Back to List'), array('controller'=>'imunization','action' => 'index',$patient_id,$id), array('escape' => false,'class'=>'blueBtn'));
			?>
		</div>
	</h3>

</div>

<table border="0">
	<tr>
		<td width="33%">
			<table>
				<tr>
					<td valign="middle"><strong><?php echo ('Problem List Source');?> </strong>
					</td>
					<td valign="middle">:</td>
					<td valign="middle" id="boxspace"><?php 
					echo $this->Form->input('problem_type',array('readonly'=>'readonly','label'=>false,'style'=>'width:160px','options'=>array(''=>__('Please Select'),'5'=>__('Reported by patient')),'selected'=>'5','class'=>'problem_type','onchange'=>'javascript:Reconcile();'));

					?>
					</td>
					<td>&nbsp;</td>
					<td valign="middle"><strong><?php echo ('Problem List Source');?> </strong>
					</td>
					<td>:</td>
					<td valign="middle" id="boxspace"><?php 
					echo $this->Form->input('problem_type1',array('readonly'=>'readonly','label'=>false,'style'=>'width:160px','options'=>array(''=>__('Please Select'),'8'=>__('Referral Summary')),'selected'=>'8','class'=>'problem_type1','onchange'=>'javascript:Reconcile();'));

					?>
					</td>
					<td>&nbsp;</td>
					<td valign="middle" class="problem_description2"
						style='display: none'><strong><?php echo ('Reconciled Problem List');?>
					</strong></td>
				</tr>
				<tr>
					<td colspan="3" valign="top">
						<table>
							<tr>
								<?php if(empty($problem_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>
								<?php
								echo "<tr class='problem_description'><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Problem" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Start Date" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($problem_data as $problem_datas){
			
									//echo"<pre>";print_r($prescription_datas);
									$medication_name=$problem_datas['NoteDiagnosis']['description'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='problem_description'><td>".$cnt.') '."</td><td>".$problem_datas['NoteDiagnosis']['diagnoses_name'] ."</td><td valign='middle' id='boxspace'>".$problem_datas['NoteDiagnosis']['start_dt'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>
								<td colspan="3" class="problem_rx" ><?php //echo $this->Form->create('User', array('type' => 'post','url' => 'https://preproduction.newcropaccounts.com/InterfaceV7/RxEntry.aspx','target'=>'aframe'));?>
									<a href="javascript:snowmed()"><?php echo $this->Form->input('Problem', array('type' => 'submit', 'class'=> 'blueBtn_hl7', 'id'=>'Problem', 'div' => false, 'label'=> false)); ?></a>
								
								</td>
								
							</tr>
							<tr>

								<td colspan="2" class="tempHead"><?php

								echo $this->Form->input('ICD_code',array('type'=>'hidden','id'=>'icd_ids'));

								
								if(empty($problem_data[0]['NoteDiagnosis']['id'])){
			              	  				$displayICD ="none";
			              	  			}else{
			              	  				$displayICD ="block";
									
			              	  			}
			              	  			?>
									<div id="icdSlc" style="display: <?php echo $displayICD ;?>">

										<?php               	  			 
										$noOfIds =  count($problem_data);
										echo $this->Form->input('ICD_code_count',array('type'=>'hidden','id'=>'icd_ids_count','value'=>$noOfIds));
										
										for($k=0;$k<$noOfIds;){
			              	  					$myIcd = '"'.$problem_data[$k]['NoteDiagnosis']['icd_id']."::".$problem_data[$k]['NoteDiagnosis']['snowmedid']."::".$problem_data[$k]['NoteDiagnosis']['diagnoses_name'].'"' ;
			              	  					echo "<p id="."icd_".$id." style='padding:0px 10px;' >";
			              	  					echo $problem_data[$k]['NoteDiagnosis']['icd_id']."::".$problem_data[$k]['NoteDiagnosis']['diagnoses_name'];
			              	  					//echo $this->Html->image('/img/icons/cross.png',array("align"=>"right","id"=>"ers_$id","onclick"=>"javascript:remove_icd(\"".$id."\");","title"=>"Remove"
			              	  					//                       ,"style"=>"cursor: pointer;","alt"=>"Remove","class"=>"icd_eraser"));
			              	  					echo "</p>";
			              	  					/*
			              	  					 echo "<a id="."icd_".$id." style='padding:0px 10px;'  href='javascript:openbox(".$myIcd.")' >";
			              	  					echo $problem_data[$k]['NoteDiagnosis']['icd_id']."::".$problem_data[$k]['NoteDiagnosis']['diagnoses_name'];
			              	  					//echo $this->Html->image('/img/icons/cross.png',array("align"=>"right","id"=>"ers_$id","onclick"=>"javascript:remove_icd(\"".$id."\");","title"=>"Remove"
			              	  					//                       ,"style"=>"cursor: pointer;","alt"=>"Remove","class"=>"icd_eraser"));
			              	  					echo "</a></br>";
			              	  					 */
			              	  					$k++ ;
			              	  				}

			              	  				?>
									</div>
								</td>
							</tr>
						</table>
					</td>
					<td>&nbsp;</td>
					<td colspan="3" valign="top">
						<table>
							<tr>
								<?php if(empty($problem_refferal_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>
								<?php
								echo "<tr class='problem_description1'><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Problem" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Start Date" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($problem_refferal_data as $problem_refferal_datas){
			
									//echo"<pre>";print_r($prescription_datas);
									$refferal_name=$problem_refferal_datas['NoteDiagnosis']['diagnoses_name'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='problem_description1'><td>".$cnt.') '."</td><td>".$problem_refferal_datas['NoteDiagnosis']['diagnoses_name'] ."</td><td id='boxspace'>".$problem_refferal_datas['NoteDiagnosis']['start_dt'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>
								<td class="problem_rx1" style='display: none'><?php echo $this->Form->create('User', array('type' => 'post','url' => 'https://preproduction.newcropaccounts.com/InterfaceV7/RxEntry.aspx','target'=>'aframe'));?>
									<?php echo $this->Form->input('Past Medication Rx', array('type' => 'submit', 'class'=> 'blueBtn_hl7', 'id'=>'Rx', 'div' => false, 'label'=> false)); ?>
								</td>
								<?php echo $this->Form->end(); ?>
							</tr>
						</table>
					</td>
					<td>&nbsp;</td>
					<td colspan="3" valign="top">

						<table>
							<tr class='problem_description2'>
								<?php if(empty($consolidated_problem_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>

								<?php
								echo "<tr class='problem_description2' style='display: none'><td>"."</td><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Problem" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Start Date" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($consolidated_problem_data as $consolidated_problem_datas){
								
									$consolidated_problem_data_id=$consolidated_problem_datas['note_diagnosis']['id'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='problem_description2' style='display: none'><td><input type=checkbox class=ads_Checkbox1 value=$consolidated_problem_data_id />"."</td><td>".$cnt.') '."</td><td>".$consolidated_problem_datas['note_diagnosis']['diagnoses_name'] ."</td><td id='boxspace'>".$consolidated_problem_datas['note_diagnosis']['start_dt'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>
								<td colspan='3' class="problem_action" style='display: none'><?php echo $this->Form->link('Delete', array('type' => 'button','value'=>'Delete', 'class'=> 'blueBtn_hl7', 'id'=>'problem_delete', 'div' => false, 'label'=> false)); ?>
									<?php echo $this->Form->link('Undo', array('type' => 'button', 'value'=>'Undo','class'=> 'blueBtn_hl7', 'id'=>'problem_undo', 'div' => false, 'label'=> false)); ?>
								</td>
								<td class="problem_action" style='display: none'><?php echo $this->Form->link('Update Facesheet', array('type' => 'button', 'value'=>'Update Facesheet','class'=> 'blueBtn_hl7', 'id'=>'update_problem_facesheet', 'div' => false, 'label'=> false)); ?>
								</td>
							</tr>

						</table>

					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>

<table>
	<tr>
		<td ><?php echo $this->Form->link('Problem Reconcile', array('type' => 'button','value'=>'Problem Reconcile', 'class'=> 'blueBtn_hl7', 'onclick'=>'javascript:problem_reconcile_show();', 'div' => false, 'label'=> false)); ?>
			<?php //echo $this->Form->input('Reconcile', array('type' => 'button', 'class'=> 'blueBtn_hl7', 'id'=>'reconcile_show', 'div' => false, 'label'=> false)); ?>
		</td>
	</tr>
</table>

<hr></hr>

<div class="inner_title">
	<h3>
		<?php echo __('Allergy'); ?>
		<div style="float: right;">
			<?php

			//echo $this->Html->link(__('Back to List'), array('controller'=>'imunization','action' => 'index',$patient_id,$id), array('escape' => false,'class'=>'blueBtn'));
			?>
		</div>
	</h3>

</div>

<table border="0">
	<tr>
		<td width="33%">
			<table>
				<tr>
					<td valign="middle"><strong><?php echo ('Allergy List Source');?> </strong>
					</td>
					<td valign="middle">:</td>
					<td valign="middle" id="boxspace"><?php 
					echo $this->Form->input('allergy_type',array('readonly'=>'readonly','label'=>false,'style'=>'width:160px','options'=>array(''=>__('Please Select'),'9'=>__('Reported by patient')),'selected'=>'9','class'=>'allergy_type','onchange'=>'javascript:Reconcile();'));

					?>
					</td>
					<td>&nbsp;</td>
					<td valign="middle"><strong><?php echo ('Allergy List Source');?> </strong>
					</td>
					<td>:</td>
					<td valign="middle" id="boxspace"><?php 
					echo $this->Form->input('allergy_type1',array('readonly'=>'readonly','label'=>false,'style'=>'width:160px','options'=>array(''=>__('Please Select'),'12'=>__('Referral Summary')),'selected'=>'12','class'=>'allergy_type1','onchange'=>'javascript:Reconcile();'));

					?>
					</td>
					<td>&nbsp;</td>
					<td valign="middle" class="allergy_description2"
						style='display: none'><strong><?php echo ('Reconciled Allergy List');?>
					</strong></td>
				</tr>
				<tr>
					<td colspan="3" valign="top">
						<table>
							<tr>
								<?php if(empty($allergy_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>
								<?php
								echo "<tr class='allergy_description' style='display:none'><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Allergy" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Created Date" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($allergy_data as $allergy_datas){
			
									//echo"<pre>";print_r($prescription_datas);
									//$medication_name=$allergy_datas['NoteDiagnosis']['description'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='allergy_description' style='display:none'><td>".$cnt.') '."</td><td>".$allergy_datas['NewCropAllergies']['name'] ."</td><td valign='middle' id='boxspace'>".$allergy_datas['NewCropAllergies']['created'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>

								<?php
								echo "<tr class='allergy_rx'><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Allergy" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Created Date" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($patient_allergy_data as $patient_allergy_datas){
			
									//echo"<pre>";print_r($patient_allergy_datas);
									//$medication_name=$allergy_datas['NoteDiagnosis']['description'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='allergy_rx'><td>".$cnt.') '."</td><td>".$patient_allergy_datas['NewCropAllergies']['name'] ."</td><td valign='middle' id='boxspace'>".$patient_allergy_datas['NewCropAllergies']['created'] ."</td></tr>";
								?>
								</td>
								<?php }?>
								<td colspan="3" class="allergy_rx"><?php //echo $this->Form->create('User', array('type' => 'post','url' => 'https://preproduction.newcropaccounts.com/InterfaceV7/RxEntry.aspx','target'=>'aframe'));?>
									<?php echo $this->Form->input('Allergy', array('type' => 'button', 'class'=> 'blueBtn_hl7', 'id'=>'allergy', 'div' => false, 'label'=> false)); ?>
								</td>
							</tr>
						</table>
					</td>
					<td>&nbsp;</td>
					<td colspan="3" valign="top">
						<table>
							<tr>
								<?php if(empty($allergy_refferal_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>
								<?php
								echo "<tr class='allergy_description1'><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Allergy" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Created Date" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($allergy_refferal_data as $allergy_refferal_datas){
			
									//echo"<pre>";print_r($prescription_datas);
									//$refferal_name=$problem_refferal_datas['NoteDiagnosis']['diagnoses_name'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='allergy_description1'><td>".$cnt.') '."</td><td>".$allergy_refferal_datas['NewCropAllergies']['name'] ."</td><td id='boxspace'>".$allergy_refferal_datas['NewCropAllergies']['created'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>
								<td class="allergy_rx1" style='display: none'><?php //echo $this->Form->create('User', array('type' => 'post','url' => 'https://preproduction.newcropaccounts.com/InterfaceV7/RxEntry.aspx','target'=>'aframe'));?>
									<?php echo $this->Form->input('Past Medication Rx', array('type' => 'submit', 'class'=> 'blueBtn_hl7', 'id'=>'Rx', 'div' => false, 'label'=> false)); ?>
								</td>
								<?php echo $this->Form->end(); ?>
							</tr>
						</table>
					</td>
					<td>&nbsp;</td>
					<td colspan="3" valign="top">

						<table>
							<tr class='allergy_description2' style='display:none'>
								<?php if(empty($consolidated_allergy_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>

								<?php
								echo "<tr class='allergy_description2' style='display: none'><td>"."</td><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Allergy" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Created Date" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($consolidated_allergy_data as $consolidated_allergy_datas){
			
									//echo"<pre>";print_r($consolidated_problem_datas);exit;
									//$consolidated_data=$consolidated_datas['NewCropPrescription']['description'];
									$consolidated_allergy_data_id=$consolidated_allergy_datas['NewCropAllergies']['id'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='allergy_description2' style='display: none'><td><input type=checkbox class=ads_Checkbox1 value=$consolidated_allergy_data_id />"."</td><td>".$cnt.') '."</td><td>".$consolidated_allergy_datas['NewCropAllergies']['name'] ."</td><td id='boxspace'>".$consolidated_allergy_datas['NewCropAllergies']['created'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>
								<td colspan='3' class="allergy_action" style='display: none'><?php echo $this->Form->link('Delete', array('type' => 'button','value'=>'Delete', 'class'=> 'blueBtn_hl7', 'id'=>'allergy_delete', 'div' => false, 'label'=> false)); ?>
									<?php echo $this->Form->link('Undo', array('type' => 'button', 'value'=>'Undo','class'=> 'blueBtn_hl7', 'id'=>'allergy_undo', 'div' => false, 'label'=> false)); ?>
								</td>
								<td class="allergy_action" style='display: none'><?php echo $this->Form->link('Update Facesheet', array('type' => 'button', 'value'=>'Update Facesheet','class'=> 'blueBtn_hl7', 'id'=>'update_allergy_facesheet', 'div' => false, 'label'=> false)); ?>
								</td>
							</tr>

						</table>

						<table>
							<tr class='allergy_description_facesheet' style='display:none' >
								<?php if(empty($consolidated_facesheet_allergy_data)){ ?>
								<td>No data recorded</td>
								<?php }  ?>
							</tr>
							<tr>

								<?php
								echo "<tr class='allergy_description_facesheet' style='display: none'><td>"."</td><td>".""." "."<strong>". "Sr No" ."</strong>"."</td><td>".""." "."<strong>". "Allergy" ."</strong>"."</td><td id='boxspace'>".""." "."<strong>". "Created Date" ."</strong>"."</td></tr>";
								$cnt = 0;
								foreach($consolidated_facesheet_allergy_data as $consolidated_facesheet_allergy_datas){
			
									//echo"<pre>";print_r($consolidated_problem_datas);exit;
									//$consolidated_data=$consolidated_datas['NewCropPrescription']['description'];
									$consolidated_facesheet_allergy_data_id=$consolidated_facesheet_allergy_datas['NewCropAllergies']['id'];
									$cnt++;
									//print_r($cnt);
									?>
								<td><?php
								echo "<tr class='allergy_description_facesheet' style='display: none'><td><input type=checkbox class=ads_Checkbox1 value=$consolidated_facesheet_allergy_data_id />"."</td><td>".$cnt.') '."</td><td>".$consolidated_facesheet_allergy_datas['NewCropAllergies']['name'] ."</td><td id='boxspace'>".$consolidated_facesheet_allergy_datas['NewCropAllergies']['created'] ."</td></tr>";
								?>
								</td>
								<?php }?>
							</tr>
							<tr>
								<td colspan='3' class="allergy_action_facesheet"
									style='display: none'><?php echo $this->Form->link('Delete', array('type' => 'button','value'=>'Delete', 'class'=> 'blueBtn_hl7', 'id'=>'allergy_delete_facesheet', 'div' => false, 'label'=> false)); ?>
									<?php echo $this->Form->link('Undo', array('type' => 'button', 'value'=>'Undo','class'=> 'blueBtn_hl7', 'id'=>'allergy_undo_facesheet', 'div' => false, 'label'=> false)); ?>
								</td>
								<td class="allergy_action_facesheet" style='display: none'><?php echo $this->Form->link('Update Facesheet', array('type' => 'button', 'value'=>'Update Facesheet','class'=> 'blueBtn_hl7', 'id'=>'update_allergy_facesheet_fc', 'div' => false, 'label'=> false)); ?>
								</td>
							</tr>

						</table>

					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>

<table>
	<tr>
		<td class="allergy_reconcile"><?php echo $this->Form->link('Allergy Reconcile', array('type' => 'button','value'=>'Allergy Reconcile', 'class'=> 'blueBtn_hl7', 'onclick'=>'javascript:allergy_reconcile_show();', 'div' => false, 'label'=> false)); ?>
			<?php //echo $this->Form->input('Reconcile', array('type' => 'button', 'class'=> 'blueBtn_hl7', 'id'=>'reconcile_show', 'div' => false, 'label'=> false)); ?>
		</td>
		<td class="allergy_reconcile_facesheet" style='display: none'><?php echo $this->Form->link('Allergy Reconcile1', array('type' => 'button','value'=>'Allergy Reconcile1', 'class'=> 'blueBtn_hl7', 'onclick'=>'javascript:allergy_facesheet_reconcile_show();', 'div' => false, 'label'=> false)); ?>
		</td>
	</tr>
</table>

<script>
function Reconcile(){ //alert($('.type').val());

	if($('.type').val() == '2'){
		$(".description").show();
		$(".description2").hide();
		$(".action").hide();//reconcile1
		$(".reconcile").hide();
		$(".reconcile1").show();
		$(".medication").show();
		$(".sr_no").show();
		//$(".unit").show();
		$(".rx").hide();
	}else if($('.type').val() == '1'){
		$(".description").hide();
		$(".description2").hide();//description_facesheet
		$(".description_facesheet").hide();
		$(".action_facesheet").hide();
		$(".action").hide();
		$(".reconcile1").hide();
		$(".reconcile").show();
		$(".medication").hide();
		$(".sr_no").hide();
		$(".unit").show();
		$(".rx").show();
	}else{
		$(".description").show();
		$(".description2").show();
		$(".action").show();
		$(".reconcile1").show();
		$(".medication").show();
		$(".sr_no").show();
		//$(".unit").show();
		$(".rx").hide();
	}

	if($('.type1').val() == '4'){
		$(".description1").show();
		$(".description2").hide();
		$(".action").hide();
		//$(".medication").show();
		//$(".sr_no").show();
		//$(".unit").show();
		$(".rx1").hide();
	}else if($('.type1').val() == '3'){
		$(".description1").hide();
		$(".description2").hide();
		$(".action").hide();
		//$(".medication").hide();
		//$(".sr_no").hide();
		//$(".unit").show();
		$(".rx1").show();
	}else{
		$(".description1").show();
		$(".description2").show();
		$(".action").show();
		//$(".medication").show();
		//$(".sr_no").show();
		//$(".unit").show();
		$(".rx1").hide();
	}

	if($('.problem_type').val() == '6'){
		$(".problem_description").show();
		$(".problem_description2").hide();
		$(".problem_action").hide();
		//$(".problem_medication").show();
		$(".problem_sr_no").show();
		//$(".unit").show();
		$(".problem_rx").hide();
	}else if($('.problem_type').val() == '5'){
		$(".problem_description").hide();
		$(".problem_description2").hide();
		$(".problem_action").hide();
		//$(".problem_medication").hide();
		$(".problem_sr_no").hide();
		$(".problem_unit").show();
		$(".problem_rx").show();
	}else{
		$(".problem_description").show();//problem_rx
		$(".problem_description2").hide();
		$(".problem_action").hide();
		//$(".problem_medication").show();
		$(".problem_sr_no").show();
		//$(".unit").show();
		$(".problem_rx").show();
	}

	if($('.problem_type1').val() == '8'){
		$(".problem_description1").show();
		$(".problem_description2").hide();
		$(".problem_action").hide();
		//$(".medication").show();
		//$(".sr_no").show();
		//$(".unit").show();
		$(".problem_rx1").hide();
	}else if($('.problem_type1').val() == '7'){
		$(".problem_description1").hide();
		$(".problem_description2").hide();
		$(".problem_action").hide();
		//$(".medication").hide();
		//$(".sr_no").hide();
		//$(".unit").show();
		$(".problem_rx1").show();
	}else{
		$(".problem_description1").show();
		$(".problem_description2").hide();
		$(".problem_action").hide();
		//$(".medication").show();
		//$(".sr_no").show();
		//$(".unit").show();
		$(".problem_rx1").hide();
	}

	if($('.allergy_type').val() == '10'){//class="allergy_reconcile_facesheet" style='display:none'
		$(".allergy_description").show();
		$(".allergy_description2").hide();
		$(".allergy_action").hide();
		$(".allergy_reconcile_facesheet").show();
		//$(".problem_medication").show();
		$(".allergy_sr_no").show();
		//$(".unit").show();
		$(".allergy_rx").hide();
		$(".allergy_reconcile").hide();
	}else if($('.allergy_type').val() == '9'){
		$(".allergy_description").hide();
		$(".allergy_description2").hide();
		$(".allergy_reconcile_facesheet").hide();//allergy_action_facesheet
		$(".allergy_description_facesheet").hide();
		$(".allergy_action").hide();
		$(".allergy_action_facesheet").hide();
		//$(".problem_medication").hide();
		$(".allergy_sr_no").hide();
		$(".allergy_unit").show();
		$(".allergy_rx").show();
		$(".allergy_reconcile").show();
	}else{
		$(".allergy_description").show();
		$(".allergy_description2").hide();
		$(".allergy_action").hide();
		//$(".problem_medication").show();
		$(".allergy_sr_no").show();
		//$(".unit").show();
		$(".allergy_rx").hide();
		$(".allergy_reconcile").show();
	}

	if($('.allergy_type1').val() == '12'){
		$(".allergy_description1").show();
		$(".allergy_description2").hide();
		$(".allergy_action").hide();
		//$(".medication").show();
		//$(".sr_no").show();
		//$(".unit").show();
		$(".allergy_rx1").hide();
	}else if($('.allergy_type1').val() == '11'){
		$(".allergy_description1").hide();
		$(".allergy_description2").hide();
		$(".allergy_action").hide();
		//$(".medication").hide();
		//$(".sr_no").hide();
		//$(".unit").show();
		$(".allergy_rx1").show();
	}else{
		$(".allergy_description1").show();
		$(".allergy_description2").hide();
		$(".allergy_action").hide();
		//$(".medication").show();
		//$(".sr_no").show();
		//$(".unit").show();
		$(".allergy_rx1").hide();
	}

	


		
}

function reconcile_show(){ 
	if($('.Reconcile').val() == 'Reconcile'){//alert('Hello');
		$(".description2").show();
		$(".action").show();
		
	}else{ //alert('Here');
		$(".description2").show();
		$(".action").show();
		
	}	
}

function reconcile_facesheet_show(){ 
	if($('.Reconcile1').val() == 'Reconcile1'){//alert('Hello');
		$(".description_facesheet").show();
		$(".action_facesheet").show();
		
	}else{ //alert('Here');
		$(".description_facesheet").show();
		$(".action_facesheet").show();
		
	}	
}

function problem_reconcile_show(){ 
	if($('.Problem Reconcile').val() == 'Problem Reconcile'){
		$(".problem_description2").show();
		$(".problem_action").show();
		
	}else{ 
		$(".problem_description2").show();
		$(".problem_action").show();
		
	}	
}

function allergy_reconcile_show(){ 
alert($('.Allergy Reconcile').val());
	if($('.Allergy Reconcile').val() == 'Allergy Reconcile'){//alert('Hello');
		$(".allergy_description2").show();
		$(".allergy_action").show();
		
	}else{ //alert('Here');
		$(".allergy_description2").show();
		$(".allergy_action").show();
		
	}	
}

function allergy_facesheet_reconcile_show(){ 
	if($('.Allergy Reconcile1').val() == 'Allergy Reconcile1'){alert('Hello');
		$(".allergy_description_facesheet").show();
		$(".allergy_action_facesheet").show();
		
	}else{ //alert('Here');
		$(".allergy_description_facesheet").show();
		$(".allergy_action_facesheet").show();
		
	}	
}

$(function(){
	
    $('#update_facesheet').click(function(){ //alert('Hello');
		
         var update = document.getElementById("drm_date").value;
        //alert(update);
    	var id = '<?php echo $id;?>';
	   // alert(val);
	 var a=confirm("Are you sure to Update Facesheet?");
	 if (a==true)
	  {
		  //alert('Hello');
		 window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "update_facesheet","admin"=>false)); ?>"+"/"+id+"/"+update;
	  }
	else
	  {
	  	//alert('Here');
	  }//alert(x);
	   // window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_prescription","admin"=>false)); ?>"+"/"+val;
    });
  });

$(function(){
	
    $('#update_facesheet_medication').click(function(){ //alert('Hello');
    	var id = '<?php echo $id;?>';
	   // alert(val);
	 var a=confirm("Are you sure to Update Facesheet?");
	 if (a==true)
	  {
		  //alert('Hello');
		 window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "update_facesheet_medication","admin"=>false)); ?>"+"/"+id;
	  }
	else
	  {
	  	//alert('Here');
	  }//alert(x);
	   // window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_prescription","admin"=>false)); ?>"+"/"+val;
    });
  });

$(function(){
	
    $('#update_problem_facesheet').click(function(){ //alert('Update');
    	var id = '<?php echo $id;?>';
	   // alert(val);
	 var a=confirm("Are you sure to Update Facesheet?");
	 if (a==true)
	  {
		  //alert('Hello');
		 window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "update_problem_facesheet","admin"=>false)); ?>"+"/"+id;
	  }
	else
	  {
	  	//alert('Here');
	  }
    });
  });

$(function(){
	
    $('#update_allergy_facesheet').click(function(){ //alert('Update');
    	var id = '<?php echo $id;?>';
	   // alert(val);
	 var a=confirm("Are you sure to Update Facesheet?");
	 if (a==true)
	  {
		  //alert('Hello');
		 window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "update_allergy_facesheet","admin"=>false)); ?>"+"/"+id;
	  }
	else
	  {
	  	//alert('Here');
	  }
    });
  });

$(function(){
	
    $('#update_allergy_facesheet_fc').click(function(){ //alert('Update');
    	var id = '<?php echo $id;?>';
	   // alert(val);
	 var a=confirm("Are you sure to Update Facesheet?");
	 if (a==true)
	  {
		  //alert('Hello');
		 window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "update_allergy_facesheet_fc","admin"=>false)); ?>"+"/"+id;
	  }
	else
	  {
	  	//alert('Here');
	  }
    });
  });

$(function(){
	
    $('#delete').click(function(){ //alert('Hello');
    	var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
	   // alert(val);
	 var r=confirm("Are you sure to delete?");
	 if (r==true)
	  {
		 window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_prescription","admin"=>false)); ?>"+"/"+val;
	  }
	else
	  {
	  	
	  }//alert(x);
	   // window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_prescription","admin"=>false)); ?>"+"/"+val;
    });
  });

$(function(){
	
    $('#delete_facesheet').click(function(){ 
    	var val = [];
    	//alert($(this).val());
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
	    alert(val);
	 var r=confirm("Are you sure to delete?");
	 if (r==true)
	  {
		 window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_prescription_facesheet","admin"=>false)); ?>"+"/"+val;
	  }
	else
	  {
	  	
	  }//alert(x);
	   // window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_prescription","admin"=>false)); ?>"+"/"+val;
    });
  });

$(function(){
	
    $('#problem_delete').click(function(){ //alert('Hello');
    	var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
	   // alert(val);
	 var r=confirm("Are you sure to delete?");
	 if (r==true)
	  {
		 window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_problem__prescription","admin"=>false)); ?>"+"/"+val;
	  }
	else
	  {
	  	
	  }//alert(x);
	   // window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_prescription","admin"=>false)); ?>"+"/"+val;
    });
  });

$(function(){
	
    $('#allergy_delete').click(function(){ //alert('Hello');
    	var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
	   // alert(val);
	 var r=confirm("Are you sure to delete?");
	 if (r==true)
	  {
		 window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_allergy","admin"=>false)); ?>"+"/"+val;
	  }
	else
	  {
	  	
	  }//alert(x);
	   // window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_prescription","admin"=>false)); ?>"+"/"+val;
    });
  });

$(function(){
	
    $('#allergy_delete_facesheet').click(function(){ //alert('Hello');
    	var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
	   // alert(val);
	 var r=confirm("Are you sure to delete?");
	 if (r==true)
	  {
		 window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_allergy_facesheet","admin"=>false)); ?>"+"/"+val;
	  }
	else
	  {
	  	
	  }//alert(x);
	   // window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "delete_prescription","admin"=>false)); ?>"+"/"+val;
    });
  });

$(function(){
	var id = '<?php echo $id;?>';
	
    $('#undo').click(function(){ //alert('Hello');
    //alert(id);
	    window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "undo_delete_prescription","admin"=>false)); ?>"+"/"+id;
    });
  });

$(function(){
	var id = '<?php echo $id;?>';
	
    $('#undo_facesheet').click(function(){ //alert('Hello');
    //alert(id);
	    window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "undo_delete_prescription_facesheet","admin"=>false)); ?>"+"/"+id;
    });
  });

$(function(){
	var id = '<?php echo $id;?>';
	
    $('#problem_undo').click(function(){ //alert('Hello');
    //alert(id);
	    window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "undo_delete_problem_prescription","admin"=>false)); ?>"+"/"+id;
    });
  });

$(function(){
	var id = '<?php echo $id;?>';
	
    $('#allergy_undo').click(function(){ //alert('Hello');
    //alert(id);
	    window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "undo_delete_allergy","admin"=>false)); ?>"+"/"+id;
    });
  });

$(function(){
	var id = '<?php echo $id;?>';
	
    $('#allergy_undo_facesheet').click(function(){ //alert('Hello');
    //alert(id);
	    window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "undo_delete_allergy_facesheet","admin"=>false)); ?>"+"/"+id;
    });
  });
</script>


<script>
$('#medicationRx').click(function(){//alert('Here');
    var patient_id = <?php echo $id; ?> ;
	$.fancybox({
        'width'    : '70%',
	    'height'   : '100%',
	    'autoScale': true,
	    'transitionIn': 'fade',
	    'transitionOut': 'fade',
	    'type': 'iframe',
	    'href': "<?php echo $this->Html->url(array("controller" => "patients", "action" => "patient_medication")); ?>"+'/'+patient_id,
	    'onClosed': function () {window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "medication_allergy_redirect","admin"=>false)); ?>"+"/"+patient_id;} 
    });
    return false ;
});
//EOF fancybox
$('#allergy').click(function(){//alert('Here');
    var patient_id = <?php echo $id; ?> ;
	$.fancybox({
        'width'    : '70%',
	    'height'   : '100%',
	    'autoScale': true,
	    'transitionIn': 'fade',
	    'transitionOut': 'fade',
	    'type': 'iframe',
	    'href': "<?php echo $this->Html->url(array("controller" => "patients", "action" => "patient_medication")); ?>"+'/'+patient_id,
	    'onClosed': function () {window.location.href = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "medication_allergy_redirect","admin"=>false)); ?>"+"/"+patient_id;} 
    });
    return false ;
});

function snowmed() { //alert('here');
	
	var patient_id = <?php echo $id; ?> ;  
	//alert(patient_id);
	if (patient_id == '') {
		alert("Please select patient");
		return false;
	}
	$
			.fancybox({

				'width' : '70%',
				'height' : '120%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed_patient")); ?>"
						+ '/' + patient_id
			});

	}

function openbox(icd,note_id) {

	var patient_id = <?php echo $id; ?> ;
	
	icd = icd.split("::");
	
	if (patient_id == '') {
		alert("Please select patient");
		return false;
	}
	$
			.fancybox({

				'width' : '40%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis_patient")); ?>"
						 + '/' + patient_id + '/' + icd + '/'+note_id 
			});

}

function remove_icd(val) {
	 
	
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "deleteNoteDiagnosis","admin" => false)); ?>";
	$.ajax({
		type : "POST",
		url : ajaxUrl +"/"+val, 
		context : document.body,
		success : function(data) {
			if(data == 1 ){
				
				var ids = $('#icd_ids').val();
				tt = ids.replace(val + '|', '');
				 
				$('#icd_ids').val(tt);
				$('#icd_' + val).remove();
			}else{  
				alert("Please try again");
			} 
		}
	});
};

$("#drm_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,
	yearRange: '1950',
	dateFormat:'<?php echo $this->General->GeneralDate();?>'
	});

</script>

