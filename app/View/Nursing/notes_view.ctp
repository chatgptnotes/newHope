<div class="inner_title">
	<h3>
		<?php echo __('Patient'."'".'s Rx'); ?>
	</h3>
	
</div>

<table border="0" class="table_format" width="100%">

	<tr>
		<td class="row_format" colspan=""><strong> <?php echo __('Prescribed Medicine',true); ?>
		</strong>
		</td>
		<td align="right">
		<span> <?php echo $this->Js->link('Administer Medication', array('controller'=>'nursings','action' => 'prescription_list',$patientid), array('class'=>'grayBtn','escape'=>false,'update' => '#list_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'title'=>'Medication Administer'));
					echo $this->Js->writeBuffer();  ?>
		</span>
		</td>
		
		
	</tr>
	<tr>
		<td width="100%" valign="top" align="left" colspan="6">
			<table width="100%" border="0" cellspacing="1" cellpadding="0"
				id='DrugGroup' class="tabularForm">
				<tr>
					<td width="27%" height="20" align="left" valign="top"><b>Name of
							Medication</b></td>
					<td width="7%" align="left" valign="top"><b>Routes</b></td>
					<td width="8%" align="left" valign="top"><b>Start Date</b></td>
					<td width="8%" align="left" valign="top"><b>Frequency</b></td>
					<td width="9%" align="left" valign="top"><b>Dose</b></td>
					<!-- <td width="20%" valign="top" colspan="4" align="center"><b>Timings</b>
					</td>  -->
				</tr>
				<?php 
			 foreach($medicines as $drugs) {
					$date = substr($drugs['NewCropPrescription']['date_of_prescription'], 0,10);
				

					$dbdate= strtotime($drugs['SuggestedDrug']['end_date']);
				//	 if($date <= $dbdate){ ?>
				<tr>
					<td><?php echo $drugs['NewCropPrescription']['description']; ?></td>
					<td><?php echo $drugs['NewCropPrescription']['route']; ?></td>
					<td><?php echo $drugs['NewCropPrescription']['date_of_prescription'];//date('d/m/Y',strtotime($date)); ?></td>
					<td><?php echo $drugs['NewCropPrescription']['frequency']; ?></td>
					<td><?php echo $drugs['NewCropPrescription']['dose']; ?></td>
					<?php /* if(!empty($drugs['SuggestedDrug']['first'])){  ?>
					<td width="5%"><?php  
					if(in_array("first",$drugs['SuggestedDrug']['med_no']) && $drugs['SuggestedDrug']['create_date'] == date("Y-m-d")){
								echo $this->Form->checkbox('first', array('checked'=>true,'disabled'=>"disabled",'class'=>'servicesClick'));
								}else{
								echo $this->Form->checkbox('first', array('class'=>'servicesClick','id'=>'chk','onclick'=>'javascript:save_presc_Record("first",'.$drugs[SuggestedDrug][id].');'));
						}
						if($drugs['SuggestedDrug']['first'] < 12){
							echo $drugs['SuggestedDrug']['first'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['first'] == 12)
								echo $drugs['SuggestedDrug']['first'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['first']-12 .' PM' ;
						}
					}else {?></td>
					<td width="5%">--</td>
					<?php } ?>
					<?php if(!empty($drugs['SuggestedDrug']['second'])){ 
							
						?>
					<td width="5%"><?php 
					if(in_array("second",$drugs['SuggestedDrug']['med_no']) && $drugs['SuggestedDrug']['create_date'] == date("Y-m-d")){
								echo $this->Form->checkbox('second', array('checked'=>true,'disabled'=>"disabled",'class'=>'servicesClick'));
								}else{
						 echo $this->Form->checkbox('second', array('class'=>'servicesClick','id'=>'chk','onclick'=>'javascript:save_presc_Record("second",'.$drugs[SuggestedDrug][id].');'));
					}
					if($drugs['SuggestedDrug']['second'] < 12){
							echo $drugs['SuggestedDrug']['second'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['second'] == 12)
								echo $drugs['SuggestedDrug']['second'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['second']-12 .' PM' ;
						}
					}else {?>
					</td>
					<td width="5%">--</td>
					<?php } ?>
					<?php if(!empty($drugs['SuggestedDrug']['third'])){ 
							
						?>
					<td width="5%"><?php
					if(in_array("third",$drugs['SuggestedDrug']['med_no']) && $drugs['SuggestedDrug']['create_date'] == date("Y-m-d")){
							echo $this->Form->checkbox('third', array('checked'=>true,'disabled'=>"disabled",'class'=>'servicesClick'));
						}else{
							echo $this->Form->checkbox('third', array('class'=>'servicesClick','id'=>'chk','onclick'=>'javascript:save_presc_Record("third",'.$drugs[SuggestedDrug][id].');'));
						}
						if($drugs['SuggestedDrug']['third'] < 12){
							echo $drugs['SuggestedDrug']['third'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['third'] == 12)
								echo $drugs['SuggestedDrug']['third'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['third']-12 .' PM' ;
						}
					}else { ?>
					</td>
					<td width="5%">--</td>
					<?php } ?>
					<?php if(!empty($drugs['SuggestedDrug']['forth']) && $drugs['SuggestedDrug']['create_date'] == date("Y-m-d")){ 

						?>
					<td width="5%"><?php
					if(in_array("forth",$drugs['SuggestedDrug']['med_no']) && $drugs['SuggestedDrug']['create_date'] == date("Y-m-d")){
							echo $this->Form->checkbox('forth', array('checked'=>true,'disabled'=>"disabled",'class'=>'servicesClick'));
						}else{
							echo $this->Form->checkbox('forth', array('class'=>'servicesClick','id'=>'chk','onclick'=>'javascript:save_presc_Record("forth",'.$drugs[SuggestedDrug][id].');'));
						}
						if($drugs['SuggestedDrug']['forth'] < 12){
							echo $drugs['SuggestedDrug']['forth'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['forth'] == 12)
								echo $drugs['SuggestedDrug']['forth'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['forth']-12 .' PM' ;
						}
					}else {?>
					</td>
					<td width="5%">--</td>
					<?php }*/ ?>
				</tr>
				<?php }//} ?>
			</table>
		</td>
	</tr>


	<tr>
		<td class="row_format" colspan="2"><?php 	 

	/*	if(!empty($medicines)){
				echo $this->Html->link(__('Print'),
										 '#',
										 array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'notes','action'=>'print_prescription',$note['Note']['id'],$patientid))."', '_blank',
											   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=800,left=400,top=400');  return false;"));

			}*/
			
			
			
			
			echo $this->Html->link(__('Cancel'), array('controller'=>'nursings','action' => 'patient_information', $patientid), array('escape' => false,'method'=>'post','class'=>'blueBtn'));
				
			?></td>
	</tr>

</table>
<?php  $this->Js->get('#chk')->event('change', $this->Js->request(array('controller'=>'nursings','action'=>'medication_check',$note['Note']['patient_id'],$note['Note']['id']), array(
		'update'=>'#list_content',
		'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		'data'=> $this->Js->serializeForm(array(
            'isForm' => false,
            'inline' => true
            ))
))
);
echo $this->Js->writeBuffer();
?>
<script>
	//------gaurav checkbox's function
	function save_presc_Record(place, suggestedId) {
	//	if (confirm("Do you really want to save prescription ?")) {

			noteid = "<?php echo $note['Note']['id']?>";
			patientid = "<?php echo $note['Note']['patient_id']?>";
			var ajaxUrl = "<?php echo $this->Html->url(array("controller"=>"nursings","action" => "medication_check","admin" => false)); ?>"+ "/"+ patientid+ "/"+ suggestedId+ "/"+ noteid+ "/"+ place;
			var formData = "";
			$.ajax({
				type : 'POST',
				url : ajaxUrl,
				data : formData,
				dataType : 'html',
				success : function(data) {
						//alert("Record Saved");
					//	$('#chk').trigger('change');
						
						},
				error : function(message) {
					alert("Internal Error Occured. Unable To Save Data.");
				}
			});

			return false;
		//}

	}
</script>


