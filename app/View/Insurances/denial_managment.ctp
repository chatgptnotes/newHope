<?php 
echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js',
		'jquery.validationEngine2','/js/languages/jquery.validationEngine-en','ui.datetimepicker.3.js'));
echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css'));

?>
<style>
.drop {
	border: 0.1em solid #808000;
}

table {
    border-collapse: inherit;
    border-spacing: 0;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Edit Claims', true); ?>
	</h3>
</div>


<?php 
echo $this->Form->create('denial',array('id'=>'denial_managment','url'=>array('controller'=>'Insurances','action'=>'denial_managment','admin'=>false,$details[0]['ClaimTransaction']['patient_id']),));
?>
<table width="100%">	
	<tr>
		<td colspan="2">
			<table width="100%" align="center" class="formFull">
				<tr>
					<td width="10%" class="tdLabel"><?php echo __('Patient', true); ?>
					</td>
					<td width="20%" class="tdLabel"><?php echo $this->Form->input('User.first_name',array('id' => 'Patientname','label'=> false, 'div' => false,'value'=>$patientData[0]['Patient']['lookup_name'])); ?>
					</td>
					<td width="10%" class="tdLabel"><?php echo __('Date of Service',true); ?>
					</td>
					<td width="20%" class="tdLabel"><?php 
								$date=$this->DateFormat->formatDate2Local($patientData[0]['Patient']['form_received_on'],Configure::read('date_format'),false);
								echo $this->Form->input('Patient.dateofservice',array('id' => 'dateofservice','label'=> false, 'div' => false,'value'=>$date)); ?>
					</td>
					<!-- <td width="10%" class="tdLabel"><?php echo __('Diagnosis1',array())?>
					</td>
					<td width="" class="tdLabel"><?php echo $this->Form->input('diagnosis1',array('type'=>'select','options'=>$options,
							'id'=>'diagnosis1','label'=> false, 'div' => false,'empty'=>'Please Select'))?>
					</td>-->
				</tr>
				<tr>
					<td width="10%" class="tdLabel"><?php echo __('Encounter', true); ?>
					</td>
					<td width="20%" class="tdLabel"><?php echo $this->Form->input('Patient.encounter',array('id' => 'encounter','label'=> false, 'div' => false,'value'=>$patientData[0]['Patient']['admission_id'])); ?>
					</td>
					<td width="10%" class="tdLabel"><?php echo __('Clearing Track #',true)?>
					</td>
					<td width="" class="tdLabel"><?php echo "101100165788" ;?></td>
					<!-- <td class="tdLabel" width="10%"><?php echo __('Procedures');?></td>
					<td class="tdLabel" width="20%"><?php echo $this->Form->input('procedure',array('type'=>'select','options'=>$options,
							'id'=>'procedure','label'=> false, 'div' => false,'empty'=>'Please Select'))?>
					</td>-->
					<!-- <td width="10%" class="tdLabel"><?php echo __('Diagnosis2',true)?>
					</td>
					<td width="" class="tdLabel"><?php echo $this->Form->input('diagnosis2',array('type'=>'select','options'=>$options,
							'id'=>'diagnosis2','label'=> false, 'div' => false,'empty'=>'Please Select'))?>
					</td>-->
				</tr>
				<tr>
					<td width="10%" class="tdLabel"><?php echo __('Case',true);?></td>
					<td width="20%" class="tdLabel"><?php echo $this->Form->input('case',array('type'=>'select','options'=>$options,
							'id'=>'case','label'=> false, 'div' => false,'empty'=>'case1'))?>
					</td>
					<td width="10%" class="tdLabel"><?php echo __('Modifier 1 ',true);?>
					</td>
					<td width="20%" class="tdLabel"><?php echo $this->Form->input('modifier1',array('type'=>'select','options'=>$options,
							'id'=>'modifier1','label'=> false, 'div' => false,'empty'=>'Please Select'))?>
					</td>
					<!-- <td width="10%" class="tdLabel"><?php echo __('Diagnosis 3',true)?>
					</td>
					<td width="" class="tdLabel"><?php echo $this->Form->input('diagnosis3',array('type'=>'select','options'=>$options,
							'id'=>'diagnosis3','label'=> false, 'div' => false,'empty'=>'Please Select'))?>
					</td>-->
				</tr>
				<tr>
					<td width="10%" class="tdLabel"><?php echo __('Provider',true);?></td>
					<td width="20%" class="tdLabel"><?php echo $this->Form->input('provider',array('id' => 'provider','label'=> false, 'div' => false,'value'=>$patientData[0]['User']['first_name']." ".$patientData[0]['User']['last_name'])); ?>
					</td>
					<td width="10%" class="tdLabel"><?php echo __('Modifier 2',true);?>
					</td>
					<td width="20%" class="tdLabel"><?php echo $this->Form->input('modifier2',array('type'=>'select','options'=>$options,
							'id'=>'modifier2','label'=> false, 'div' => false,'empty'=>'Please Select'))?>
					</td>
					<!-- <td width="10%" class="tdLabel"><?php echo __('Diagnosis 4',true)?>
					</td>
					<td width="" class="tdLabel"><?php echo $this->Form->input('diagnosis4',array('type'=>'select','options'=>$options,
							'id'=>'diagnosis4','label'=> false, 'div' => false,'empty'=>'Please Select'))?>
					</td>-->
				</tr>
				<tr>
					<td width="10%" class="tdLabel"><?php echo __('Location',true);?></td>
					<td width="20%" class="tdLabel"><?php echo $this->Form->input('location',array('id'=>'location','label'=> false, 'div' => false,'value'=>$this->Session->read('facility')))?>
					</td>
					<td width="10%" class="tdLabel"><?php echo __('Type of Service',true);?>
					</td>
					<td width="20%" class="tdLabel"><?php echo $this->Form->input('service',array('type'=>'select','options'=>$options,
							'id'=>'service','label'=> false, 'div' => false,'empty'=>'Please Select'))?>
					</td>
					
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="width: 30%">
			<table class="formFull" width="100%" align="center">
				<tr class="row_gray">
					<td width="10%" class="tdLabel" colspan="4" valign="top"><b><?php echo __('Summary',true);?>
					</b></td>
				</tr></table></td></tr></table>
				<div id="patient-info-acc" class="accordionCust" >
				<h3 style="font-weight: bold;">
		<a href="#"><?php echo __("Diagnosis"); ?>
		</a>
	</h3>
		<table width="100%" cellspacing="0" cellpadding="0" class="patient_info section">
				<tr class="row_gray">
					<td class="tdLabel" width="10px"><?php echo __("Sr.no",true);?></td>	
					<td class="tdLabel" width="20%"><?php echo __("Diagnosis Name",true);?></td>
					<td class="tdLabel" ><?php echo __("ICD Code",true);?></td>				
				</tr>
				<?php $sno=1;
				foreach($diagnosis as $diagnosis)
				{?>
				<tr class="row_gray">
				<td class="tdLabel" ><?php echo $sno;?></td>
				<td class="tdLabel"><?php echo $diagnosis['NoteDiagnosis']['diagnoses_name'];?></td>				
				<td class="tdLabel"><?php echo $this->Form->input('cpt',array('label'=> false, 'div' => false,'value'=>$diagnosis['NoteDiagnosis']['icd_id'],'style'=>'text-align:right;width:70px'));?></td>
				</tr><?php $sno++; }?>
				</table>
			<h3 style="font-weight: bold;">
		<a href="#"><?php echo __("Procedures"); ?>
		</a>
	</h3>
						<table width="100%" cellspacing="0" cellpadding="0" class="patient_info section">
							<tr class="row_gray">
								<td class="tdLabel"><?php echo __("Procedure Code",true)?>
								</td>
								<td class="tdLabel"><?php echo __("Units",true)?>
								</td>
								<td class="tdLabel" colspan="2"><?php echo __("Unit Charges",true)?>
								</td>								
								<td class="tdLabel" colspan="2"><?php echo __("Total Charges",true)?>
								</td>
								<td class="tdLabel" colspan="2"><?php echo __("Adjustments",true)?>
								</td>
								<td class="tdLabel" colspan="2"><?php echo __("Adjusted Charges",true)?>
								</td>
								<td class="tdLabel" colspan="2"><?php echo __("Patient Payments",true)?>
								</td>
								<td class="tdLabel" colspan="2"><?php echo __("Insurance Payments",true)?>
								</td>
								<td class="tdLabel" colspan="2"><?php echo __("Total Payments",true)?>
								</td>
								<td class="tdLabel" colspan="2"><?php echo __("Patient Balance",true)?>
								</td>
								<td class="tdLabel" colspan="2"><?php echo __("Insurance Balance",true)?>
								</td>
							</tr>
							<tr>
								<?php $r=0;
								foreach($servicesData as $key=>$service)
								{
									if($r=1)
									{
										echo "</tr><tr class='".row_gray."'>";
										$r=0;
									}
								?>
								<td class="tdLabel"><?php echo $this->Form->input('ServiceBill.ICD10PCS',array('label'=> false, 'div' => false,'value'=>$service['Icd10pcMaster']['ICD10PCS'],'style'=>'text-align:right;width:70px'));?>
								</td>
								<td class="tdLabel"><?php echo $this->Form->input('ServiceBill.unit',array('label'=> false,'class'=>'myUnit','id'=>"unit_$key", 'div' => false,'value'=>$service[0]['recordcount'],'style'=>'text-align:right;width:90%'));?>
								</td>
								<td class="tdLabel" width="2px"><?php echo $currency;?></td>
								<td class="tdLabel" ><?php echo $this->Form->input('ServiceBill.charges',array('label'=> false,'id'=>"charge_$key", 'div' => false,'value'=>$service['Icd10pcMaster']['charges'],'style'=>'text-align:right;width:56px'));?>
								</td>								
								<td class="tdLabel" width="2px"><?php echo $currency;?></td>
								<td class="tdLabel"><?php $total=$service[0]['recordcount']*$service['Icd10pcMaster']['charges'];
								echo $this->Form->input('ServiceBill.charges',array('label'=> false,'id'=>"total_$key", 'div' => false,
												'value'=>$total,'style'=>'text-align:right;width:60px','disabled'=>'disabled'));?>
								</td>
								<td class="tdLabel" width="2px"><?php echo $currency;?></td>
								<td class="tdLabel"><?php echo $this->Form->input('ServiceBill.adjustment',array('label'=> false,'id'=>"", 'div' => false,
												'value'=>'0','style'=>'text-align:right;width:60px','disabled'=>'disabled','id'=>"adjustment_$key"));?>
								</td>
								<td class="tdLabel" width="2px"><?php echo $currency;?></td>
								<td class="tdLabel"><?php echo $this->Form->input('ServiceBill.adjusted_charge',array('label'=> false,'id'=>"", 'div' => false,
												'value'=>'0','style'=>'text-align:right;width:60px','disabled'=>'disabled','id'=>"adjustCharge_$key"));?>
								</td>
								<td class="tdLabel" width="2px"><?php echo $currency;?></td>
								<td class="tdLabel"><?php echo $this->Form->input('ServiceBill.patient_payment',array('label'=> false,'id'=>"", 'div' => false,
												'value'=>'0','style'=>'text-align:right;width:60px','disabled'=>'disabled'));?>
								</td>
								<td class="tdLabel" width="2px"><?php echo $currency;?></td>
								<td class="tdLabel"><?php echo $this->Form->input('ServiceBill.insurance_payment',array('label'=> false,'id'=>"", 'div' => false,
												'value'=>'0','style'=>'text-align:right;width:60px','disabled'=>'disabled'));?>
								</td>
								<td class="tdLabel" width="2px"><?php echo $currency;?></td>
								<td class="tdLabel"><?php echo $this->Form->input('ServiceBill.total_payment',array('label'=> false,'id'=>"", 'div' => false,
												'value'=>'0','style'=>'text-align:right;width:60px','disabled'=>'disabled'));?>
								</td>
								<td class="tdLabel" width="2px"><?php echo $currency;?></td>
								<td class="tdLabel"><?php echo $this->Form->input('ServiceBill.patient_balance',array('label'=> false,'id'=>"", 'div' => false,
												'value'=>'0','style'=>'text-align:right;width:60px','disabled'=>'disabled'));?>
								</td>
								<td class="tdLabel" width="2px"><?php echo $currency;?></td>
								<td class="tdLabel"><?php echo $this->Form->input('ServiceBill.insurance_payment',array('label'=> false,'id'=>"", 'div' => false,
												'value'=>'0','style'=>'text-align:right;width:60px','disabled'=>'disabled'));?>
								</td>
								<?php $r++;
								$totalCharges=$totalCharges+$total;
							}?>
							</tr>
							<tr class="row_gray"><td colspan="4">
							<table width="100%"><tr>
					<td  class="tdLabel"><?php echo __('Total charges',true);?>
					</td>
					<td class="tdLabel" id="cur_total"><?php if($totalCharges!='')
					echo $this->Number->currency($totalCharges);
					else $this->Number->currency(0);?></td>
				</tr>				
				<tr>
					<td  class="tdLabel"><?php echo __('Total Balance',true);?>
					</td>
					<td class="tdLabel"><?php echo $this->Number->currency(1120); ?></td>
				</tr>
			</table>
			</td>
			<td colspan="20"></td></tr></table>
						
					</div>				
		
			<table class="formFull" id="transactionTable" width="100%" align="center" cellpadding="0" cellspacing="0">
				<tr class="row_gray">
					<td width="10%" class="tdLabel" colspan="4"><font size="4"><b><?php echo __('Transactions',true);?>
					</b></font></td>
				</tr>
				<tr>
					<td width="30%" class="tdLabel"><?php echo __('Transactions',true);?>
					</td>
					<td width="20%" class="tdLabel"><?php echo __('Amount',true);?></td>
					<td width="20%" class="tdLabel"><?php echo __('Patient Responsibility',true);?></td>
					<td width="20%"><?php echo __('Total Balance',true);?></td>
				</tr>
				<tr class="row_gray">
					<td colspan="4" align="center"><b><?php echo __('Description',true);?></b>
					</td>
				</tr>
				
				<?php $toggle == 0;$row=0;
				foreach($details as $detail){
				if($toggle == 0) {
								       	echo "<tr class='".$detail['ClaimTransaction']['id']."'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr class='".$detail['ClaimTransaction']['id']." row_gray'>";
								       	$toggle = 0;
							       }?>
							       <td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($detail['ClaimTransaction']['claim_submitted_date'],Configure::read('date_format'),false);
							       echo "&nbsp;&nbsp;"; 
							       echo $detail['ClaimTransaction']['claim_status'];?></td>
							       <td class="tdLabel"><?php echo $this->Number->currency($detail['ClaimTransaction']['amount']);?></td>
							       <td class="tdLabel"><?php echo $this->Number->currency($detail['ClaimTransaction']['patient_resp_amount']);?></td>
							       <td class="tdLabel"><?php						       
							       	//$total= $detail['ClaimTransaction']['amount'];							       
							        echo $this->Number->currency($detail['ClaimTransaction']['total_balance']);?></td>
							       </tr>
							       <?php if($row == 0) {
								       		echo "<tr class='".$detail['ClaimTransaction']['id']."'>";
								       	$row = 1;
							       }else{
								       	echo "<tr class='".$detail['ClaimTransaction']['id']." row_gray'>";
								       	$row = 0;
							       }?>
							       <td class="tdLabel" colspan="4"><?php echo $detail['ClaimTransaction']['claim_reason_message']; ?></td>							       
							       </tr>
							       
				<?php $lastId = $detail['ClaimTransaction']['id']; 
				}?> 
				</tr>
			</table>
	<table width="30%" cellspacing="0" cellpaddind="0">
	<tr><td><?php echo $this->Form->submit('save',array('class'=>'blueBtn','div'=>false));?></td>
			<td><?php echo $this->Html->link(__('Cancel'),'javascript:void(0)',array('class'=>'blueBtn','div'=>false,'id'=>'cancel'));?></td>
			<td><?php echo $this->Form->button('Delete last transaction',array('type'=>'button','class'=>'blueBtn','id'=>'delete','label'=>false));?><td>
			<td><?php echo $this->Form->button('Action',array('class'=>'blueBtn action'));?>
			</td></tr>
		</table>	

  <script>
  $(document).ready(function(){
		$( "#patient-info-acc" ).accordion({
			collapsible: true,
			autoHeight: false,
			clearStyle :true,	 
			navigation: true, 
			active:false
		});
	});
  var totalAmt=0;
	$('.myUnit').blur(function(){
		var currentId= $(this).attr('id');							
		var unitValue=$('#'+currentId).val();							
		var key =currentId.split('_');							
		var charge=$('#charge_'+key[1]).val();								
		var total=unitValue*charge;
		$('#total_'+key[1]).val(total);
		//For adjusted charge field		
		var	adjusted=total-$('#adjustment_'+key[1]).val();	
		$('#adjustCharge_'+key[1]).val(adjusted);
		$( ".myUnit" ).each(function( index ) {
			if($('#total_'+index).val()!='')
			{
			var amt=$('#total_'+index).val();
			totalAmt= totalAmt+parseInt(amt);
			
			}
			});	
		//alert(totalAmt);
		$('#cur_total').html("<?php echo $currency?>"+totalAmt);	
		totalAmt=0;
		});
	$( '#cancel').click(function(){
		parent.$.fancybox.close();
	});
	$('#delete').click(function(){
		
		var classVar = $('#transactionTable tr:last').attr('class').split(' ');
		var id= classVar[0];
		if(confirm("Do you really want to delete this record?")){
			
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Insurances", "action" =>"deleteTransaction","admin" => false)); ?>";
		$.ajax({
			  type : "GET",
			  url: ajaxUrl+"/"+id,
			  context: document.body,
			  success: function(data){
				  $( "tr."+id ).remove();
				},
			  error : function (){
					alert('hi');
				  }
		});
		}
	});
		</script>
	
