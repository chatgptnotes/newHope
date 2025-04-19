<style>

.message{
	
	font-size: 15px;
}
.table_format {
    padding: 3px !important;
}
.rowClass td{
	 background: none repeat scroll 0 0 #ffcccc!important;
}

#patient-info-box{
 	display: none;
    position: absolute;
    right: 0;
    left:992px;
    top: 34px;
    z-index: 29;
    background: none repeat scroll 0 0 #ffffff;
    border: 1px solid #000000;
    border-radius: 3px;
    box-shadow: 0 0 3px 2px #000;
    margin-top: -1px;
    padding: 6px;
    width: 400px;
    font-size:13px;
    list-style-type: none;
    
}
 .row_format th{
 	 background: #d2ebf2 none repeat scroll 0 0 !important;
    border-bottom: 1px solid #3e474a;
    color: #31859c !important;
    font-size: 12px;
    padding: 3px;
    text-align: center;
 }
 .row_format td{
 	padding: 1px;
 }
  
.row_format tr:nth-child(even) {background: #CCC}
.row_format tr:nth-child(odd) {background: #e7e7e7} 
</style> 

<div class="Row inner_title" style="float: left; width: 100%; clear:both">
		<div style="font-size: 20px; font-family: verdana; color: darkolivegreen;" >			 
			<?php echo "Claim Submission Check List" ;?>
		</div>
	<span>
	<?php echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'doctor_dashboard'), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px')); ?>
	<?php if($checkList['NivTreatmentSheet']['id'] !='') { 
		echo $this->Html->link(__('Print Preview'),'#',
		     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'claim_submission_checklist',$patientData['Patient']['id'],'print'))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
    
    }?>
	</span>
</div>


<p class="ht5"></p> 



<table style="width: 100%">
	<tr>
		<td style="width: 50%;vertical-align: top;" >
			<?php echo $this->Form->create('NivTreatmentSheet',array('type' => 'file','id'=>'oxygenTreatForm','inputDefaults' => array(
						'label' => false,
						'div' => false,
						'error' => false,
						'legend'=>false,
						'fieldset'=>false
				)
				));
				//echo $this->Form->hidden('id',array('id'=>'recId','value'=>$nivDetails['NivTreatmentSheet']['id'],'autocomplete'=>"off"));
				echo $this->Form->hidden('patient_id',array('id'=>'patientId','value'=>$patientData['Patient']['id'],'autocomplete'=>"off"));


				?>
	<?php 
			
			if($patientData['Patient']['form_received_on']){
				$admissionDate = $this->DateFormat->formatDate2Local($patientData['Patient']['form_received_on'],Configure::read('date_format'),true);
				
			}else{
				$admissionDate = $this->DateFormat->formatDate2Local($nivDetails[0]['NivTreatmentSheet']['admission_date'],Configure::read('date_format'),true);
			}

			
			$reportDate = date('d/m/Y H:i:s');
		
			$ipapOption = array('12'=>'12','17'=>'17','22'=>'22','27'=>'27','30'=>'30');
			$epapOption = array('5'=>'5','8'=>'8','11'=>'11','15'=>'15','17'=>'17','20'=>'20');
			$o2SaturationOption = array('70'=>'70','75'=>'75','80'=>'80','85'=>'85','90'=>'90','97'=>'97','98'=>'98','99'=>'99','100'=>'100');
			$o2InLiterOption = array('1'=>'1','2'=>'2','4'=>'4','6'=>'6','9'=>'9','10'=>'10','11'=>'11','13'=>'13','14'=>'14','15'=>'15');
			$highFlowOption  = array('High flow mask'=>'High flow mask','Nasal'=>'Nasal');
	 ?>
			<table class="table_format" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">
	
				<tr>
					<td><?php echo __('Name of Patient'); ?></td>
					<td>:</td>
					<td><?php echo $patientData['Patient']['lookup_name'];?></td>
				</tr>
				<tr>
					<td><?php echo __('Registration Number'); ?></td>
					<td>:</td>
					<td><?php echo $this->Session->read('facility');?></td>
				</tr>
				<tr>
					<td><?php echo __('Age/Gender'); ?></td>
					<td>:</td>
					<td><?php echo $patientData['Patient']['age']." / ".$patientData['Patient']['sex'];?></td>
				</tr>

			 	<tr>
					<td><?php echo __('Date of Admission'); ?></td>
					<td>:</td>
					<td><?php echo $this->Form->input('NivTreatmentSheet.admission_date', array('type'=>'text','class' => 'textBoxExpnd', 'id' => 'admission_date', 'label'=> false, 'div' => false,'error' => false,'style'=>'width:40%','value'=>$admissionDate));
					 	?>
							 	
				 	</td>
				</tr>
				<tr>
					<td><?php echo __('Date of Reporting'); ?></td>
					<td>:</td>
					<td><?php echo $this->Form->input('NivTreatmentSheet.report_date', array('type'=>'text','class' => 'textBoxExpnd', 'id' => 'discharge_date', 'label'=> false, 'div' => false,'error' => false,'style'=>'width:40%','value'=>$reportDate));
					 	?>	 	
				 	</td>
				</tr>
			</table>

			 <table class="table_format" border="0" cellpadding="3" cellspacing="1" width="60%" align="center">

			 	
				
						
				<tr>
					<td><strong><?php echo "Time" ; ?></strong></td>
					<td><strong><?php echo "IPAP" ; ?></strong></td>
					<td><strong><?php echo "EPAP" ; ?></strong></td>
					<td><strong><?php echo "O2 SATURATION" ; ?></strong></td>
					<td><strong><?php echo "O2 IN LITER" ; ?></strong></td>
					<td><strong><?php echo "HIGH FLOW MASK/NASAL" ; ?></strong></td>
					<!-- <td><strong><?php echo "DOCTOR SIGN" ; ?></strong></td>
					<td><strong><?php echo "NURSES SIGN" ; ?></strong></td> -->
					
				</tr>
				<tr>
					<td><strong><?php echo "4 AM" ; ?></strong></td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][4_am][ipap]','type'=>'select','empty'=>'Please Select','options'=>$ipapOption,'class' => 'textBoxExpnd', 'id' => '4amipap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][4_am][epap]','type'=>'select','empty'=>'Please Select','options'=>$epapOption,'class' => 'textBoxExpnd', 'id' => '4amepap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][4_am][o2_saturation]','type'=>'select','empty'=>'Please Select','options'=>$o2SaturationOption,'class' => 'textBoxExpnd', 'id' => '4amsaturation', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][4_am][o2_in_liter]','type'=>'select','empty'=>'Please Select','options'=>$o2InLiterOption,'class' => 'textBoxExpnd', 'id' => '4amo2liter', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][4_am][high_flow_mask]','type'=>'select','empty'=>'Please Select','options'=>$highFlowOption,'class' => 'textBoxExpnd', 'id' => '4amhighFlow', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<!-- <td>&nbsp;</td>
					<td>&nbsp;</td> -->
					
				</tr>
				<tr>
					<td><strong><?php echo "8 AM" ; ?></strong></td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][8_am][ipap]','type'=>'select','empty'=>'Please Select','options'=>$ipapOption,'class' => 'textBoxExpnd', 'id' => '8amipap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][8_am][epap]','type'=>'select','empty'=>'Please Select','options'=>$epapOption,'class' => 'textBoxExpnd', 'id' => '8amepap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][8_am][o2_saturation]','type'=>'select','empty'=>'Please Select','options'=>$o2SaturationOption,'class' => 'textBoxExpnd', 'id' => '8amsaturation', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][8_am][o2_in_liter]','type'=>'select','empty'=>'Please Select','options'=>$o2InLiterOption,'class' => 'textBoxExpnd', 'id' => '8amo2liter', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][8_am][high_flow_mask]','type'=>'select','empty'=>'Please Select','options'=>$highFlowOption,'class' => 'textBoxExpnd', 'id' => '8amhighFlow', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<!-- <td>&nbsp;</td>
					<td>&nbsp;</td> -->
					
				</tr>
				<tr>
					<td><strong><?php echo "12 NOON" ; ?></strong></td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][12_pm][ipap]','type'=>'select','empty'=>'Please Select','options'=>$ipapOption,'class' => 'textBoxExpnd', 'id' => '12pmipap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][12_pm][epap]','type'=>'select','empty'=>'Please Select','options'=>$epapOption,'class' => 'textBoxExpnd', 'id' => '12pmepap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][12_pm][o2_saturation]','type'=>'select','empty'=>'Please Select','options'=>$o2SaturationOption,'class' => 'textBoxExpnd', 'id' => '12pmsaturation', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][12_pm][o2_in_liter]','type'=>'select','empty'=>'Please Select','options'=>$o2InLiterOption,'class' => 'textBoxExpnd', 'id' => '12pmo2liter', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][12_pm][high_flow_mask]','type'=>'select','empty'=>'Please Select','options'=>$highFlowOption,'class' => 'textBoxExpnd', 'id' => '12pmhighFlow', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<!-- <td>&nbsp;</td>
					<td>&nbsp;</td> -->
					
				</tr>
				<tr>
					<td><strong><?php echo "4 PM" ; ?></strong></td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][4_pm][ipap]','type'=>'select','empty'=>'Please Select','options'=>$ipapOption,'class' => 'textBoxExpnd', 'id' => '4pmipap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][4_pm][epap]','type'=>'select','empty'=>'Please Select','options'=>$epapOption,'class' => 'textBoxExpnd', 'id' => '4pmepap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][4_pm][o2_saturation]','type'=>'select','empty'=>'Please Select','options'=>$o2SaturationOption,'class' => 'textBoxExpnd', 'id' => '4pmsaturation', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][4_pm][o2_in_liter]','type'=>'select','empty'=>'Please Select','options'=>$o2InLiterOption,'class' => 'textBoxExpnd', 'id' => '4pmo2liter', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][4_pm][high_flow_mask]','type'=>'select','empty'=>'Please Select','options'=>$highFlowOption,'class' => 'textBoxExpnd', 'id' => '4pmhighFlow', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<!-- <td>&nbsp;</td>
					<td>&nbsp;</td> -->
					
				</tr>
				<tr>
					<td><strong><?php echo "8 PM" ; ?></strong></td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][8_pm][ipap]','type'=>'select','empty'=>'Please Select','options'=>$ipapOption,'class' => 'textBoxExpnd', 'id' => '8pmipap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][8_pm][epap]','type'=>'select','empty'=>'Please Select','options'=>$epapOption,'class' => 'textBoxExpnd', 'id' => '8pmepap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][8_pm][o2_saturation]','type'=>'select','empty'=>'Please Select','options'=>$o2SaturationOption,'class' => 'textBoxExpnd', 'id' => '8pmsaturation', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][8_pm][o2_in_liter]','type'=>'select','empty'=>'Please Select','options'=>$o2InLiterOption,'class' => 'textBoxExpnd', 'id' => '8pmo2liter', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][8_pm][high_flow_mask]','type'=>'select','empty'=>'Please Select','options'=>$highFlowOption,'class' => 'textBoxExpnd', 'id' => '8pmhighFlow', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<!-- <td>&nbsp;</td>
					<td>&nbsp;</td> -->
				
				</tr>
				<tr>
					<td><strong><?php echo "12 MID NIGHT" ; ?></strong></td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][12_am][ipap]','type'=>'select','empty'=>'Please Select','options'=>$ipapOption,'class' => 'textBoxExpnd', 'id' => '12amipap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][12_am][epap]','type'=>'select','empty'=>'Please Select','options'=>$epapOption,'class' => 'textBoxExpnd', 'id' => '12amepap', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][12_am][o2_saturation]','type'=>'select','empty'=>'Please Select','options'=>$o2SaturationOption,'class' => 'textBoxExpnd', 'id' => '12amsaturation', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][12_am][o2_in_liter]','type'=>'select','empty'=>'Please Select','options'=>$o2InLiterOption,'class' => 'textBoxExpnd', 'id' => '12amo2liter', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<td><?php echo $this->Form->input('', array('name'=>'data[NivTreatmentSheet][niv_details][12_am][high_flow_mask]','type'=>'select','empty'=>'Please Select','options'=>$highFlowOption,'class' => 'textBoxExpnd', 'id' => '12amhighFlow', 'label'=> false, 'div' => false,'error' => false));
					 	?>	 	
				 	</td>
					<!-- <td>&nbsp;</td>
					<td>&nbsp;</td> -->
					
				</tr>


				
				<tr>
					<td colspan="5"></td>
					
					<td><?php	
							echo "&nbsp;&nbsp;".$this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false,'id'=>'saveBtn'));?>
					</td>
				</tr>
			</table>
			<?php echo $this->Form->end();?>
		</td>
		
		<td style="width: 50%;vertical-align: top;">
			
			<table class="table_format" border="1" cellpadding="0" cellspacing="0" width="60%" align="center">
				<thead>
					
					<tr>
						<th><?php echo __('SR.NO'); ?></th>
						<th><?php echo __('REPORTING DATE'); ?></th>
						<th><?php echo __('ADMISSION DATE'); ?></th>
						<th><?php echo __('ACTION'); ?></th>
					</tr>
					<?php foreach ($nivDetails as $key => $value) { ?>
						<tr>
						<td><?php echo $key+1 ; ?></td>
						<td><?php echo date('d/m/Y H:i:s',strtotime($value['NivTreatmentSheet']['report_date'])); ; ?></td>
						<td><?php echo date('d/m/Y H:i:s',strtotime($value['NivTreatmentSheet']['admission_date'])); ?></td>
						
						<td><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete_niv_treatment_sheet',$value['NivTreatmentSheet']['id']), array('escape' => false),__('Are you sure?', true)); ?>
							
							<?php echo $this->Html->link($this->Html->image('icons/printer_mono.png'),'#',array('escape' => false,'title'=>'Print with Header',
					'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_niv_treatment_sheet',$value['NivTreatmentSheet']['id'])).
					"', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=800');  return false;")); ?>
						</td>

						
						</tr>
					<?php } ?>
				</thead>
			</table>
		</td>
	</tr>
</table>


		

<script>
$(document).ready(function(){

	// binds form submission and fields to the validation engine
	$(document).on('click',"#saveBtn",function(){
		var validateForm = $("#oxygenTreatForm").validationEngine('validate');

		if (validateForm == true)
		{
			$("#saveBtn").hide();
		}else{

			$("#saveBtn").show();
			return false;
		}

	});
	
 	$("#admission_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
       dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
        
	});

	$("#discharge_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1950',
        maxDate: new Date(),
        dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
        
	});

	

});


</script>