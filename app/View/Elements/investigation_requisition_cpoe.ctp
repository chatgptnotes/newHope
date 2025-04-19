<?php
//echo $this->Html->script('jquery.autocomplete');
//echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->Script('ui.datetimepicker.3.js');
echo $this->Html->css('internal_style.css');

?>
<style>
.blueBtn {
	color: #000000;
}

.tddate img {
	float: inherit;
}

#ekg-investigation .table_format {
	padding: 0 0 0 20px;
}

#history {
	float: left;
	margin: 7px 0 0 2px;
	height:27px; line-height:27px;
}

#history_txt {
	float: left;
}

.cardiactxt {
	float: left;
	margin: 13px 0 0 0px;
}

.cardiac_MAINtxt {
	margin: 0px 0 10px 16px;
	font-size: 15px;
	color: #000;
	text-transform: uppercase;
	font-weight: bold;
}

#cardianheading {
	float: left;
	margin: 12px 0 0 0px;
}
.table_format{ padding:0px !important;}
.textBoxExpnd{ width:66.3%;}
</style>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<?php  if(($this->params->named['source'] =="fromNotes") && ($this->params->named['type'] =="IPD" )) {?>
	<!-- <tr>
		<td align="left"><a class="tdLabel2"
			style="text-decoration: underline;" href="#"
			id="swap_investigation_ekg">Click To View EKG</a></td>
	</tr> -->
	<?php }else{?>
	<tr>
		<td></td>
		<td align="left"><a class="tdLabel2"
			style="text-decoration: underline;" href="#" id="swap_investigation">Click
				To View Radiology</a></td>



		<td align="right"><a class="tdLabel2"
			style="text-decoration: underline; cursor: pointer; color: #FFFFFF"
			id="swap_investigation_ekg">Click To View EKG</a></td>
	</tr>
	<?php }?>
	<tr>
		<td>&nbsp;</td>
	</tr>

</table>


<div align="center" id='temp-busy-indicator1' style="display: none;">
	&nbsp;
	<?php echo $this->Html->image('indicator.gif', array()); ?>
</div>
<div class="clr"></div>
<!-- <table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" id="searchBar">
	<tr>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td width="60" class="tdLabel2"><strong><?php echo __("Lab Search");?></strong></td>
					<td width="250" cellpadding:right='200px'><?php 
					echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'search','autocomplete'=>'true','label'=>false,'div'=>false));
					

					?></td>
					<td width="" colspan="4"><?php 

					echo $this->Html->link(__('Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:snomed_labrad_test()'));
					?>
					</td>
					<td width="" colspan="4"><?php 

					echo $this->Form->input('LaboratoryTestOrder.toTest',array('empty'=>__('Select'),'options'=>'','escape'=>false,'multiple'=>false,'value'=>'',
	                                  'style'=>'width:400px;','id'=>'SelectLeft','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:changeTest()'));
	                                 ?>
					</td>

				</tr>
			</table>
		</td>
	</tr>
</table> -->
<?php  if(($this->params->named['source'] =="fromNotes") && ($this->params->named['type'] =="IPD" )) {
	$display ="none";
}else{
			$display ="block";
		}?>
<div id="lab-investigation" style= "display:<?php echo $display ;?>">

	<div class="clr ht5"></div>
	<table width="99%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm">

		<tr>
			<td valign="top">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="25%"><strong><?php echo __("Lab Search"); ?> </strong>
					  	<td width="22%"><strong><?php echo __("Lab Search"); ?> </strong>
						</td>
						<td width="31%"><?php 

						echo $this->Form->input('test_name',array('class'=>'textBoxExpnd','escape'=>false,'multiple'=>false,
	                                 'label'=>false,'div'=>false,'id'=>'test_name','autocomplete'=>false));
	                                 ?>
						</td>
						<td></td>
						<td width="7%" class="tdLabel2"><strong><?php echo __("OR");?> </strong>
						</td>

						<td width="46%px"><?php 

						/*echo $this->Form->input('LaboratoryTestOrder.toTest',array('empty'=>__('Select'),'options'=>$test_data,'escape'=>false,'multiple'=>false,'value'=>'',
						 'class'=>'textBoxExpnd','id'=>'SelectLab','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:getLabDetail()'));*/

echo $this->Html->link(__('IMO Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:proceduresearch("forlab")'));
?>
						</td>
					</tr>
				</table>
			</td>

		</tr>

	</table>
	<!-- billing activity form end here -->

	<table border="0" class="" cellpadding="0" cellspacing="0"
		width="98%" style="text-align: left; color: #fff;">
		<tr>
			<td width="50%" id="boxSpace" class="tdLabel">Universal Service
				Identifier: <font color="red">*</font>
			</td>
			<td width="19%"><?php  echo $this->Form->input('LaboratoryToken.testname',array('class'=>'textBoxExpnd','div'=>false,'label'=>false,'id'=>'testname','readonly'=>'readonly'));
			echo $this->Form->hidden('LaboratoryToken.curdate',array('id'=>'curdate'));
			echo $this->Form->hidden('LaboratoryTestOrder.lab_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testcode'));
			echo $this->Form->hidden('LaboratoryTestOrder.sct_concept_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'sctCode'));
			echo $this->Form->hidden('LaboratoryTestOrder.sct_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'sctDesc'));
			echo $this->Form->hidden('LaboratoryTestOrder.isIMO',array('type'=>'text','div'=>false,'label'=>false,'id'=>'isIMO'));

			echo $this->Form->hidden('LaboratoryTestOrder.cpt_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cptCode'));
			echo $this->Form->hidden('LaboratoryTestOrder.lonic_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'LonicCode'));
			echo $this->Form->hidden('LaboratoryTestOrder.lonic_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'LonicDesc'));

			echo $this->Form->hidden('LaboratoryTestOrder.cpt_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'cptDesc'));
			echo $this->Form->hidden('LaboratoryTestOrder.icd9_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd9Code'));
			echo $this->Form->hidden('LaboratoryTestOrder.icd9_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd9Desc'));

			echo $this->Form->hidden('LaboratoryTestOrder.icd10pcs_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd10pcsCode'));
			echo $this->Form->hidden('LaboratoryTestOrder.icd10pcs_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'icd10pcsDesc'));
			echo $this->Form->hidden('LaboratoryTestOrder.hcpcs_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'hcpcsCode'));

			echo $this->Form->hidden('LaboratoryTestOrder.hcpcs_desc',array('type'=>'text','div'=>false,'label'=>false,'id'=>'hcpcsDesc'));





			echo $this->Form->hidden('LaboratoryTestOrder.patient_id', array('value'=>$patient_id));
			echo $this->Form->hidden('LaboratoryToken.id',array('id'=>'token_id','div'=>false,'label'=>false));
			echo $this->Form->hidden('LaboratoryToken.testOrder_id',array('type'=>'text','id'=>'testOrder_id','div'=>false,'label'=>false));
			?></td>
            </tr>
            
           <tr>
			<td width="19%" id="boxSpace" class="tdLabel">Specimen Type:<font
				color="red">*</font>
			</td>
			<td width="19%"><?php  echo $this->Form->input('LaboratoryToken.specimen_type_id',array('class'=>'textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_type,'id'=>'specimen_type_id','div'=>false,'label'=>false));
			?>
			</td>
		</tr>
		<tr>
			<!--<td>Status:</td>
			<td><?php //echo $this->Form->input('LaboratoryToken.status', array('readonly'=>'readonly','style'=>'width:160px','options'=>array("Entered"=>__('Entered'),'Approved'=>__('Approved'),'Ordered'=>__('Ordered')),'id'=>'status','label' => false)); ?>
			</td>-->

			<td width="19%" id="boxSpace" class="tdLabel">Specimen Collection
				Date: <font color="red">*</font>
			</td>
			<td width="19%" style="width:163px; float:left;"><?php echo $this->Form->input('LaboratoryToken.collected_date',array('class'=>'textBoxExpnd','id'=>'collected_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false,'value'=>date('m/d/y H:i:s') )); ?>
			</td>
            </tr>
            <tr>
			<td width="19%" id="boxSpace" class="tdLabel">Sample:</td>
			<td width="30%"><?php echo $this->Form->input('LaboratoryToken.sample', array('class'=>'textBoxExpnd','readonly'=>'readonly','options'=>array("Office"=>__('Office'),' PSC'=>__(' PSC')),'label' => false,'id' => 'sample')); ?>
			</td>
           </tr>

		<tr>
			<td width="19%" id="boxSpace" class="tdLabel">Start date: <!--  <font color="red">*</font> -->
			</td>
          <td width="19%"><?php echo $this->Form->input('LaboratoryTestOrder.start_date',array('id'=>'lab_start','class'=>'textBoxExpnd start_cal','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
			</td>
            </tr>
            <tr>

		<td width="19%" id="boxSpace" class="tdLabel">End date/time: <!--  <font color="red">*</font> -->
			</td>

			<td width="19%"><?php echo $this->Form->input('LaboratoryToken.end_date',array('class'=>'textBoxExpnd','id'=>'end_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
			</td>
            </tr>
          <tr>
			<td width="19%" id="boxSpace" class="tdLabel">Specimen Action Code:</td>
			<td width="20%"><?php  echo $this->Form->input('LaboratoryToken.specimen_action_id',array('class'=>'textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_action,'id'=>'specimen_action_id','div'=>false,'label'=>false));
			?>
			</td>
		</tr>
        <tr>
			<td width="19%" id="boxSpace" class="tdLabel">Ac.Id:</td>
			<td width="19%"><?php  echo $this->Form->input('LaboratoryToken.ac_id',array('class'=>'textBoxExpnd','type'=>'text','id'=>'ac_id','div'=>false,'label'=>false));  ?>

			</td>

		</tr>
        <tr>
			<td width="19%" id="boxSpace" class="tdLabel">Specimen Condition:</td>
			<td width="25%"><?php  echo $this->Form->input('LaboratoryToken.specimen_condition_id',array('class'=>'textBoxExpnd','empty'=>'Please Select','options'=>$spec_cond,'id'=>'specimen_condition_id','div'=>false,'label'=>false));  ?>

			</td>

		</tr>
		
            <tr>
			<td width="19%" id="boxSpace" class="tdLabel">Condition Original
				Text:</td>
			<td width="19%"><?php echo $this->Form->input('LaboratoryToken.cond_org_txt', array('class'=>'textBoxExpnd','type'=>'text','label' => false,'id' => 'cond_org_txt')); ?>
			</td>
            </tr>
            <tr>
			<td width="19%" id="boxSpace" class="tdLabel">Alt. Specimen Type:</td>
			<td width="19%"><?php  echo $this->Form->input('LaboratoryToken.alt_spec',array('class'=>'textBoxExpnd','type'=>'text','id'=>'alt_spec','div'=>false,'label'=>false));  ?>
			</td>
		</tr>
            
        <tr>
			<td width="19%" id="boxSpace" class="tdLabel">Spec. Reject Reason:</td>
			<td width="19%"><?php echo $this->Form->input('LaboratoryToken.specimen_rejection_id', array('class'=>'textBoxExpnd','empty'=>'Please Select','readonly'=>'readonly','options'=>$spec_rej,'label' => false,'id' => 'spec_rej')); ?>
			</td>
            </tr>
        
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel">Reject Reason Original
				Txt:</td>
			<td width="19%"><?php echo $this->Form->input('LaboratoryToken.rej_reason_txt', array('class'=>'textBoxExpnd','type'=>'text','label' => false,'id' => 'rej_reason_txt')); ?>
			</td>
            </tr>
            <tr>
			<td width="19%" id="boxSpace" class="tdLabel">No of written
				Lab orders:</td>
			<td width="19%"><?php echo $this->Form->input('LaboratoryTestOrder.lab_order', array('class'=>'textBoxExpnd','type'=>text,'div'=>false,'label'=>false,'id' => 'lab_order')); ?>
			</td>
            </tr>
            
		
            <tr>
			<td width="19%" id="boxSpace" class="tdLabel">Alt. Specimen
				Condition:</td>
			<td width="20%"><?php  echo $this->Form->input('LaboratoryToken.alt_spec_cond',array('class'=>'textBoxExpnd','type'=>'text','id'=>'alt_spec_cond','div'=>false,'label'=>false));  ?>

			</td>

		</tr>
		<!-- 
		<tr>
			<td>Bill Type:</td>
			<td><?php //echo $this->Form->input('LaboratoryToken.bill_type', array('id'=>'bill_type','style'=>'width:165px','options'=>array("None"=>__('None'),'Patient'=>__('Patient'),'Client'=>__('Client'),'Third Party'=>__('Third Party')),'label' => false)); 
			?>
			</td>
			<td>Account No:</td>
			<td><?php  //echo $this->Form->input('LaboratoryToken.account_no',array('id'=>'account_no','class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false));  ?>
			</td>
			
		</tr>
		 -->
            <tr>
			<td width="19%" id="boxSpace" class="tdLabel"><?php echo __("Send To Laboratory");?>:</td>
			<td width="31%"><?php echo $this->Form->input('LaboratoryTestOrder.service_provider_id', array('class'=>'textBoxExpnd','empty'=>'Please Select','id'=>'service_provider_id','options'=>$serviceProviders,'label' => false)); ?>
			</td>


			
		</tr>
		
            <tr>

			<td width="19%" id="boxSpace" class="tdLabel">Date of order:</td>
			<td width="19%"><?php echo $this->Form->input('LaboratoryTestOrder.lab_order_date', array('class'=>'textBoxExpnd','id' => 'lab_order_date','type'=>'text','label'=>false )); ?>
			</td>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

		
		<!-- 
		<tr>
			<td>Number of written Laboratory orders:</td>
			<td><?php //echo $this->Form->input('LaboratoryTestOrder.lab_order', array('type'=>text,'div'=>false,'label'=>false,'id' => 'lab_order'  )); ?>
			</td>

			<td>Date of order:</td>
			<td><?php //echo $this->Form->input('LaboratoryTestOrder.lab_order_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id' => 'lab_order_date','type'=>'text','label'=>false )); ?>
			</td>
		</tr>
		 -->
		<tr>
			<td colspan='4' align='right' valign='bottom'><?php echo $this->Form->submit(__('Submit'),array('id'=>'labsubmit','class'=>'blueBtn','onclick'=>"javascript:save_laborder($('#testname').val());return false;")); ?>
			</td>

		</tr>




	</table>
	<!--BOF list -->
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="10%" style="text-align: center;">
		<?php if(isset($test_ordered) && !empty($test_ordered)){  ?>
		<tr class="row_title">
			<td class="table_cell" align="left"><strong> <?php echo __('Lab Order id'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Lab creation Date'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Lab Name'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php  echo __('Lonic Code'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Speci. Type'); ?>
			</strong></td>
			<!-- 
			<td class="table_cell" align="left"><strong> <?php echo __('Specimen Collection Date'); ?>
			</strong></td> -->
			<!--  <td class="table_cell" align="left"><strong> <?php echo __('End Date/Time'); ?>
			</strong></td>-->
			<td class="table_cell" align="left"><strong> <?php echo __('Speci. Cond.'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Status'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Is Sample Taken'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Action'); ?>
			</strong></td>

		</tr>

		<?php 
		$toggle =0;
		$time = '';
		if(count($test_ordered) > 0) {

									foreach($test_ordered as $labs){

										   /*$splitDateTime   = explode(" ",$labs['LaboratoryTestOrder']['create_time']) ;
										    $splitTime = explode(":",$splitDateTime[1]);
										   $currentTime =  $splitTime[0].":".$splitTime[1];
										   $timeWtoutSec = $splitDateTime[0]." ".$currentTime ;*/
							   			   $currentTime = $labs['LaboratoryTestOrder']['batch_identifier'];
							   			   if($time != $currentTime ){
										   		if(!empty($test_ordered)) {
										   			echo "<tr class='row_title'><td colspan='11' align='right' style='padding: 8px 5px;'>" ;
										   			echo $this->Form->button(__('Print Slip'),
													     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'laboratories','action'=>'investigation_print',$patient_id,$currentTime))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
													echo "</td></tr>" ;
		                                 		}else{
		                                 			echo "<tr class='row_title'><td colspan='11'>&nbsp;</td></tr>" ;
		                                 		}
										   }

										   $time  =  $currentTime;
										   if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr class='row_gray'>";
												$toggle = 0;
										   }
										   //status of the report
										   if($labs['LaboratoryResult']['confirm_result']==1){
										   		$status = 'Result published' ;

										   }else{
										   		$status = 'Pending';

										   }
										   ?>
		<td class="row_format" align="left"><?php echo $labs['LaboratoryTestOrder']['order_id']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($labs['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),false); ?>
		</td>
		<td class="row_format" align="left"><?php  echo ucfirst($labs['Laboratory']['name']); ?>
		</td>
		<td class="row_format" align="left"><?php  echo $labs['Laboratory']['lonic_code']; ?>
		</td>
		<td class="row_format" align="left"><?php echo ucfirst($labs['LaboratoryToken'][0]['specimen_type_id']); ?>

			<script>/* document.write("Hello World!"); */</script>
		</td>
		<!-- 
		<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($labs['LaboratoryToken'][0]['collected_date'],Configure::read('date_format'),true); ?>
		</td> -->
	<!--  	<td class="row_format" align="left"><?php 
		if(!empty($labs['LaboratoryToken'][0]['end_date']) && ($labs['LaboratoryToken'][0]['end_date'] != '0000-00-00 00:00:00'))
			echo $this->DateFormat->formatDate2Local($labs['LaboratoryToken'][0]['end_date'],Configure::read('date_format'),true); ?>
		</td> -->
		<!-- 	<td class="row_format">
			<?php // echo $status; ?>
		</td>  -->
		<td class="row_format" align="left"><?php echo $labs['LaboratoryToken'][0]['specimen_condition_id']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $status; ?>
		</td>
		<td class="row_format"><?php 
		if(!empty($labs['LaboratoryToken'][0]['ac_id']) || !empty($labs['LaboratoryToken'][0]['specimen_type_id'])){
					echo "Yes";
				  }else{
					echo "No";
				 }
				 ?>
		</td>

		<td class="row_format" align="left"><?php 
		if($status == 'Pending'){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'laboratories','action' => 'deleteLabTest', $labs['LaboratoryTestOrder']['id']), array('escape' => false),__('Are you sure?', true));
				}
					
				$labo_id = $labs['LaboratoryToken'][0]['id'];
				echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_laborder($labo_id);return false;")), array(), array('escape' => false));
				$ord_id = $labs['LaboratoryTestOrder']['order_id'];

				/* $rolename = $this->Session->read('role');
				 if((strtolower($rolename) != strtolower(trim(Configure::read('medicalAssistantLabel'))))){
				echo $this->Html->link($this->Html->image('icons/sign-icon.png',array('title'=>'Generate HL7','alt'=>'Generate HL7', 'onclick'=>"gen_HL7_Lab('$ord_id');return false;")), array(), array('escape' => false));
				} */
				?></td>
		</tr>
		<?php } 	
		//set get variables to pagination url
		$this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
		?>
		<tr>
			<TD colspan="8" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"> <?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span>
			</TD>
		</tr>
		<?php } ?>
		<?php					  
			} else {} ?>

		<?php  echo $this->Js->writeBuffer(); ?>
	</table>
</div>
<?php
//EOF lab order
//BOF radiology order
?>
<div id="radiology-investigation" style="display: none;">
	<table width="50%" cellpadding="0" cellspacing="1" border="0"
		id="searchBar">
		<!-- class="tabularForm" -->
		<tr>
			<td valign="top">
				<!--<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="14%" class="tdLabel2"><strong><?php //echo __("Radiology Search");?>
						</strong></td>
						<td width="323" cellpadding:right='200px'><?php 
						//echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'search','autocomplete'=>'true','label'=>false,'div'=>false));
							

						?></td>
						<td width="" colspan="4"><?php 

					//	echo $this->Html->link(__('Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:snomed_labrad_test()'));
						?>
						</td>
						<td width="" colspan="4"><?php 

						//echo $this->Form->input('LaboratoryTestOrder.toTest',array('empty'=>__('Select'),'options'=>'','escape'=>false,'multiple'=>false,'value'=>'',
	                                 // 'style'=>'width:358px;','id'=>'SelectLeft','label'=>false,'div'=>false,'empty'=> 'Please Select','onChange'=>'javascript:changeTest()'));
	                                 ?>
						</td>

					</tr>
				</table> -->
			</td>
		</tr>
	</table>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm" style="color: #fff;">

		<tr>
			<td valign="top" width="30%">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>


				  		<td><?php 

						echo $this->Form->input('RadiologyTestOrder.toTest',array('empty'=>__('Please Select'),'options'=>$rad_data,'escape'=>false,'multiple'=>false,
	                                  'style'=>'width:220px;','id'=>'SelectRad','label'=>false,'div'=>false,'onChange'=>'javascript:getRadDetail()'));
	                                 ?>
						</td>

						<td><?php 
						echo  $this->Form->input('RadiologyTestOrder.is_procedure', array('label'=>false,'type'=>'checkbox','id'=>'is_procedure'));
						?>
						</td>
						<td class="tdLabel2">Is Procedure</td>
						<td class="tdLabel2"><strong>OR</strong></td>
						<td><?php echo $this->Html->link(__('IMO'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:proceduresearch("forrad")'));?>
						</td>
					</tr>

				</table>
			</td>

		</tr>

	</table>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="65%" style="text-align: left; color: #fff;">
		<tr>

			<td width="4%" class="tdlabel" id="boxspace">Test Name:<font color="red">*</font></td>
			<td width="10%"><?php  echo $this->Form->input('RadiologyTestOrder.testname',array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false,'label'=>false,'id'=>'rad_testname','readonly'=>'readonly','style'=>'width:307px;'));  
			echo $this->Form->hidden('RadiologyTestOrder.testcode',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_testcode','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.sct_concept_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_sctCode','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.lonic_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_LonicCode','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.cpt_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_cptCode','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.icd9code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_icd9code','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.radTestId',array('id'=>'radTestId'));
			?>
			</td>
		</tr>

		<tr>

			<td class="tdlabel" id="boxspace">Start Date: <!--  <font color="red">*</font> -->
			</td>

			<td class="tddate"><?php echo $this->Form->input('RadiologyTestOrder.start_date',array('class'=>'start_cal textBoxExpnd','id'=>'start_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
			</td>
		</tr>

		<tr>
			<td class="tdlabel" id="boxspace">Number of written radiology orders:</td>
			<td><?php echo $this->Form->input('RadiologyTestOrder.radiology_order', array('type'=>'text','id' => 'radiology_order','label'=>false,'class' => 'textBoxExpnd','style'=>'width:307px;' )); ?>
			</td>
		</tr>
		<tr>
			<td class="tdlabel" id="boxspace">Date of order:</td>
			<td class="tddate"><?php echo $this->Form->input('RadiologyTestOrder.radiology_order_date', array('class' => 'textBoxExpnd','id' => 'radiology_order_date','type'=>'text','label'=>false )); ?>
			</td>


		</tr>
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel"><?php echo __("Send To Radiology Facility");?>:</td>
			<td width="31%"><?php echo $this->Form->input('RadiologyTestOrder.service_provider_id', array('class'=>'textBoxExpnd','empty'=>'Please Select','id'=>'rad_service_provider_id','options'=>$serviceProviders,'label' => false)); ?>
			</td>


			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan='4' align='right' valign='bottom'><?php  echo $this->Form->submit(__('Submit'),array('id'=>'radsubmit','class'=>'blueBtn','onclick'=>"javascript:save_radorder($('#rad_testname').val()); return false;")); ?>
			</td>
		</tr>
	</table>

	<!--BOF list -->
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center;">
		<?php if(isset($radiology_test_ordered) && !empty($radiology_test_ordered)){ 

			//debug($radiology_test_ordered);

			?>
		<tr class="row_title">
			<td class="table_cell" align="left"><strong> <?php echo  __('Radiology Order id', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo  __('Order Time', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Test Name', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo  __('CPT Code', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo  __('Status'); ?>
			</strong></td>

			<td class="table_cell" align="left"><strong> <?php echo  __('Action'); ?>
			</strong></td>

		</tr>
		<?php //echo "<pre>"; print_r($radiology_test_ordered);
			$toggle =0;
			$time ='' ;
			if(count($radiology_test_ordered) > 0) {
									foreach($radiology_test_ordered as $labs){
							   			   /*$splitDateTime   = explode(" ",$labs['RadiologyTestOrder']['create_time']) ;
							   			    $splitTime = explode(":",$splitDateTime[1]);
							   			   $currentTime =  $splitTime[0].":".$splitTime[1];
							   			   $timeWtoutSec = $splitDateTime[0]." ".$currentTime ;*/
										   $currentTime = $labs['RadiologyTestOrder']['batch_identifier'];
										   if($time != $currentTime ){
										   		if(!empty($radiology_test_ordered)) {
										   			echo "<tr class='row_title'><td colspan='6' align='right' style='padding: 8px 5px;'>" ;
										   			echo $this->Form->Button(__('Print Slip'),
													     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'radiologies','action'=>'investigation_print',$patient_id,$currentTime))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
													echo "</td></tr>" ;
		                                 		}else{
		                                 			echo "<tr class='row_title'><td colspan='6'>&nbsp;</td></tr>" ;
		                                 		}
										   }

										   $time  =  $currentTime;
										   if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr>";
												$toggle = 0;
										   }
										   //status of the report
										   if($labs['RadiologyResult']['confirm_result']==1){
										   		$status = 'Result published';

										   }else{
										   		$status = 'Pending';

										   }
										   ?>
		<td class="row_format" align="left"><?php echo $labs['RadiologyTestOrder']['order_id']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($labs['RadiologyTestOrder']['start_date'],Configure::read('date_format')); ?>
		</td>
		<td class="row_format" align="left"><?php echo ucfirst($labs['Radiology']['name']); ?>

		</td>
		<td class="row_format" align="left"><?php echo $labs['Radiology']['cpt_code']; ?>
		</td>

		<td class="row_format" align="left"><?php echo $status; ?>
		</td>

		<td class="row_format" align="left"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'radiologies','action' => 'ra', $labs['RadiologyTestOrder']['id'],$currentTime), array('escape' => false),__('Are you sure?', true));
		$radio_id = $labs['RadiologyTestOrder']['id'];
		echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_radorder($radio_id);return false;")), array(), array('escape' => false));
		?>
		</td>
		</tr>
		<?php } 

		//set get variables to pagination url
		$this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
		?>
		<tr>
			<TD colspan="8" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"> <?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span>
			</TD>
		</tr>
		<?php } ?>
		<?php					  
		} else { }?>

		<?php echo $this->Js->writeBuffer();
		?>
	</table>

</div>
<?php //EOF radiology order ?>


<?php // BOF EKG ?>
<?php  if(($this->params->named['source'] =="fromNotes") && ($this->params->named['type'] =="IPD" )) {
	$display="block";
}else{
			$display="none";
		}?>
<div id="ekg-investigation" style= "display:<?php echo $display?>;">
	<td width="10px" colspan="2" class="tdlabel" id="boxspace">
		<div class="cardiac_MAINtxt">CARDIAC</div>
	</td>
	<table border="0" class="" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: left; color: #fff;">
		<div class="tdlabel" id="historys" style="float:left;margin: 10px 0 0;width: 146px;">
			History:
			<?php
			echo $this->Form->hidden('EKG.patient_id',array('value'=>$patient_id));
			?>
			<font color="red">*</font>
		</div>
		<div class="tdlabel" id="history_txt">
			<?php echo $this->Form->input('EKG.history',array('type' => 'text','id'=>'history','div'=>false,'label'=>false))?>
		</div>
		<div class="tdlabel" id="cardianheading" valign="middle" width="10%" style="float:left;">
			<?php echo __('Cardiac Medications, If Any:')?>
		</div>
		<div class="cardiactxt">
			<?php echo $this->Form->textarea('EKG.cardiac_medication', array('id' => 'cardiac_medication','Style' =>' height:27px; width:138px;','row'=>'3')); ?>
		</div>
		<div class="tdlabel" id="pateint_pacemaker"
			style="float: left; margin: 15px 0 0; clear: left;">
			<?php echo  __('Does Patient Have a Pacemaker?:')?>
		</div>
		<div class="tdlabel" id="pacemaker_selector"
			style="float: left; margin: 15px 0 0;">
			<?php echo $this->Form->radio('EKG.pacemaker', array('yes'=>'Yes','no'=>'No','unknown'=>'Unknown'),array('name'=>'pacemaker','legend'=>false,'label'=>false, 'div'=>false ));?>
		</div>
		<div class="tdlabel" id="boxspace"
			style="float: left; margin: 20px 0 0; clear: left;width: 164px;">
			<?php echo  __('PLEASE CHECK ONE:')?>
		</div>
		<div style="float: left; padding: 0 0 0 10px; margin: 15px 0 0;">
			<?php 
			$radValue = array('12 Lead EKG With Rhythm Strip'=>'12 Lead EKG With Rhythm Strip','Pacemaker Test'=>'Pacemaker Test','Holter Monitor'=>'Holter Monitor') ;
			echo $this->Form->input('EKG.check_one', array('empty'=>__('Please Select'),'readonly'=>'readonly','options'=>$radValue,'id'=>'check_one', 'class'=>'textBoxExpnd', 'legend'=>false,'label'=>false ));?>
		</div>
		<br clear="all" />
		<div>
			<div class="tdlabel" id="boxspace">
				<h6>
					<strong>NOTICE TO OFFICIALS:</strong> A Portable EKG is being
					ordered since this patient would find it physically and/or
					psychologically taxing, because of advanced age and/or physical
					limitations to receive EKG outside this home.
			</div>

			<div>
				<div style="float: left; width: 270px;" class="tdlabel"
					id="assignment_sec">
					<?php echo  __('Assignment Accepted:')?>
					</td>
					<div class="tdlabel" id="assignment_check_sec"
						style="float: right; padding: 0 !important; margin: 0 !important;">
						<?php echo $this->Form->radio('EKG.assignment_accepted', array('yes'=>'Yes','no'=>'No'),array('name'=>'assignment_accepted','legend'=>false,'label'=>false ));?>
					</div>
				</div>

				<tr>
					<td colspan='4' align='right' valign='bottom'><?php 
					echo $this->Html->link('Submit','#',array('id'=>'ekgsubmit','class'=>'blueBtn'));?>
					</td>
				</tr>

				<?php //-------------------------Display Records---------?>
				<tr>
					<td width="100%">
						<table border="0" class="table_format" cellpadding="0"
							cellspacing="0" width="100%" style="text-align: center;">
							<?php if(isset($ekgData) && !empty($ekgData)){  ?>
							<tr class="row_title">
								<td class="table_cell" align="left"><strong> <?php echo  __('History', true); ?>
								</strong></td>
								<td class="table_cell" align="left"><strong> <?php echo  __('Pacemaker', true); ?>
								</strong></td>
								<td class="table_cell" align="left"><strong> <?php echo  __('Assignment Accepted ', true); ?>
								</strong></td>
								<td class="table_cell" align="left"><strong> <?php echo  __('Cardiac Medications', true); ?>
								</strong></td>
								<td class="table_cell" align="left"><strong> <?php echo  __('Action'); ?>
								</strong></td>
							</tr>
							<?php
							$toggle =0;
							if(count($ekgData) > 0) {
									foreach($ekgData as $key=>$ekgDisplay){
											 if(!empty($ekgDisplay)) {
											}else{
		                                 			echo "<tr class='row_title'><td colspan='5>&nbsp;</td></tr>" ;
		                                 		}
		                                 		if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr>";
												$toggle = 0;
										   }
										   //status of the report
										   ?>

							<td class="row_format" align="left"><?php echo $ekgDisplay['EKG']['history']; ?>
							</td>
							<td class="row_format" align="left"><?php echo $ekgDisplay['EKG']['pacemaker']; ?>
							</td>
							<td class="row_format" align="left"><?php echo $ekgDisplay['EKG']['assignment_accepted']; ?>
							</td>
							<td class="row_format" align="left"><?php echo $ekgDisplay['EKG']['cardiac_medication']; ?>
							</td>

							<td class="row_format" align="left"><?php $ekg_id = $ekgDisplay['EKG']['id'];

							echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'EKG','action' =>'delete', $ekg_id), array('escape' => false),__('Are you sure?', true));

							echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_ekg($ekg_id,$patient_id);return false;")), array(), array('escape' => false));
							?>
							</td>

							<?php } 
						}
			} else { }?>

						</table>
					</td>
				</tr>
	
	</table>
	<?php echo $this->Js->writeBuffer();?>
</div>


<script language="javascript" type="text/javascript">


	function ekg_success(){ 
		  
		//$("#ekg-investigation :input").reset();
		$("#ekg-investigation").closest('#ekg-investigation').find("input[type=text], textarea").val("");
		$("#ekg-investigation input:radio").attr("checked", false);
		
            	$("#accordionCust").accordion({
	                collapsible: true,
	                active: false,
	                alwaysOpen: false
	            });
           
		  
	}
	$(document).ready(function() {
		 $('#swap_investigation').click(function() {

					if ($('#lab-investigation').css(
							'display') == 'none') {
						$('#searchBar').fadeIn('fast');
						$('#radiology-investigation').fadeOut('fast');
						$('#lab-investigation').fadeIn('slow');
						$(this).text('Click to view Radiology');
						$('#ekg-investigation').fadeOut('fast');
					} else {
						$('#searchBar').fadeIn('fast');
						$('#lab-investigation').fadeOut('fast');
						$('#radiology-investigation').fadeIn('slow');
						$(this).text('Click to view Laboratories');
					}
					return false;
		});

		$('#swap_investigation_ekg').click(function() { 
				$('#ekg-investigation').fadeIn('slow');
				$('#lab-investigation').fadeOut('fast');
				$('#radiology-investigation').fadeOut('fast');
				$('#searchBar').fadeOut('fast');
				//$(this).text('Click to view EKG'); 
				return false;
	    });
						
		//BOF pankaj
		$("#is-external").click(function() {
			if ($(this).attr('checked') == true) {
				$("#service-provider").show('slow');
			} else {
				$("#service-provider").hide('slow');
			}
		});
		//EOF pankaj   
		
		// BOF Gaurav
$("#collected_date").datepicker({
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange : '1950',
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
				maxDate : new Date(),
				//don't give general date format (date Format as per US syntax)
                /*dateFormat : 'yy,mm,dd,HH,II,SS',
				onSelect : function() {
				$(this).focus();
				var format = $(this).val().split(",");
				var now = new Date(format[0],format[1],format[2],format[3],format[4],format[5]); 
				var now_utc = new Date(now.getUTCFullYear(), now.getUTCMonth()-1, now.getUTCDate(),  now.getHours(), now.getMinutes(), now.getSeconds());
				document.getElementById("collected_date").value =  now_utc;
				//foramtCollecteddate();
				}, */
			});
						
						
$("#end_date").datepicker({
	showOn : "button",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange : '2013',
	dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
	minDate : new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>),
	//don't give general date format (date Format as per US syntax)
	//don't give general date format
    /*dateFormat : 'yy,mm,dd,HH,II,SS',
	onSelect : function() {
	$(this).focus();
	var format = $(this).val().split(",");
    var now = new Date(format[0],format[1],format[2],format[3],format[4],format[5]); 
	var now_utc = new Date(now.getUTCFullYear(), now.getUTCMonth()-1, now.getUTCDate(),  now.getHours(), now.getMinutes(), now.getSeconds());
	document.getElementById("end_date").value =  now_utc;
	},*/
									
});
						
$( ".start_cal" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
	buttonText:'Date of Incident',
	minDate:new Date(<?php echo date("Y", strtotime($patient['Patient']['form_received_on']))?>,<?php echo date("m", strtotime($patient['Patient']['form_received_on'])) -1?>,<?php echo date("d", strtotime($patient['Patient']['form_received_on']))?>),
	onSelect: function(){
		var dateval = $("#intrinsic_date").val();
		var patientid = $("#patientid").val();
		//window.location.href = '<?php echo $this->Html->url('/hospital_acquire_infections/index/'); ?>'+patientid+'/'+dateval;
           // $("#intrinsic_date").action = "<?php echo $this->Html->url('/hospital_acquire_infections/index'); ?>"
		//alert($( "#intrinsic_date" ).val());
	}
});
						
// EOF Gaurav
$("#lab-search").keypress(function() {
		$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'laboratories', "action" => "ajax_sort_test", "admin" => false)); ?>",
			data : {"searchParam" : $("#lab-search").val(),
				"patient_id" : <?php echo $patient_id ;?>
			},
			context : document.body,
			beforeSend : function() {
				//this is where we append a loading image
				$('#temp-busy-indicator').show('fast');
			},
			success : function(data) {
				$('#temp-busy-indicator').hide('fast');
				data = $.parseJSON(data);
				$("#SelectLeft option").remove();
				$.each(data, function(val,text) {
									$("#SelectLeft").append("<option value='"+val+"'>"+ text + "</option>"); 
					});
				
			}
	});
		changeTest();    
});
						
$('#diagnosisfrm').submit(function() {
	$("#SelectRight option").attr("selected","selected");
});

$(function() {
	$("#MoveRight,#MoveLeft")
		.click(
			function(event) {
				var id = $(event.target).attr("id");
				var selectFrom = id == "MoveRight" ? "#SelectLeft" : "#SelectRight";
				var moveTo = id == "MoveRight" ? "#SelectRight" : "#SelectLeft";
				var selectedItems = $(selectFrom + " :selected").toArray();
				$(moveTo).append(selectedItems);
				selectedItems.remove;
	});
});

						//BOF radiology JS
$(document).ready(function() {
	$("#radiology-search").keyup(function() {
		$.ajax({
				url : "<?php echo $this->Html->url(array("controller" => 'radiologies', "action" => "ajax_sort_test", "admin" => false)); ?>",
				data : {"searchParam" : $("#radiology-search").val(),
						"patient_id" : <?php echo $patient_id ;?> },
				context : document.body,
				beforeSend : function() {
					//this is where we append a loading image
					$('#temp-busy-indicator').show('fast');
				},
				success : function(data) {
					$('#temp-busy-indicator').hide('fast');
					data = $.parseJSON(data);
					$("#RadSelectLeft option").remove();
					$.each(data, function(val,text) {
					$("#RadSelectLeft").append("<option value='"+val+"'>"+ text+ "</option>");
					});
				}
			});
		});

	$('#diagnosisfrm').submit(function() {
		$("#RadSelectRight option").attr("selected","selected");
	});
});

	$(function() {
		$("#RadMoveRight,#RadMoveLeft").click(function(event) {
			var id = $(event.target).attr("id");
			var selectFrom = id == "RadMoveRight" ? "#RadSelectLeft" : "#RadSelectRight";
			var moveTo = id == "RadMoveRight" ? "#RadSelectRight" : "#RadSelectLeft";
			var selectedItems = $(selectFrom + " :selected").toArray();
			$(moveTo).append(selectedItems);
			selectedItems.remove;
		});
	});
});

	var testnameIndex = '';
	var codeIndex = '';
	var SctCode = '';
	var LonicCode = '';
	var CptCode = '';
		function changeTest() 
		{ 
			var e = document.getElementById("SelectLeft");
	        var strUser = e.options[e.selectedIndex].text; 
			testnameIndex = e.selectedIndex;
			document.getElementById("testname").value = strUser;
			document.getElementById("testcode").value = codeIndex[testnameIndex];
			document.getElementById("LonicCode").value = LonicCode[testnameIndex];
			document.getElementById("sctCode").value = SctCode[testnameIndex];
			document.getElementById("cptCode").value = CptCode[testnameIndex];
			document.getElementById("rad_testname").value = strUser;
			document.getElementById("rad_testcode").value = codeIndex[testnameIndex];
			document.getElementById("rad_sctCode").value = SctCode[testnameIndex];
			document.getElementById("rad_LonicCode").value = LonicCode[testnameIndex];
			document.getElementById("rad_cptCode").value = CptCode[testnameIndex];
			
		}

	function createTitle(data){
		 var options = '';
		  $.each(data, function(index, name) {
		  options += '<option value=' + index + '>' + name + '</option>';
		 });
		 return options;
	}
		
	function snomed_labrad_test() { 
		var searchtest = $('#search').val();
	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "snowmed",$patient_id,"admin" => false)); ?>";
	  var formData = $('#diagnosisfrm').serialize();
	 
	   $.ajax({
           type: 'POST',
          url: ajaxUrl+"/"+searchtest,
           data: formData,
           dataType: 'html',
           //--------------
           beforeSend: function() {

           	$("#temp-busy-indicator1").show();
			},
			complete: function() {
				$("#temp-busy-indicator1").hide();
			}, 
           //-------------
           success: function(data){ 
	        
           data = JSON && JSON.parse(data) || $.parseJSON(data);
           	titleData = createTitle(data.testTitle);
				codeIndex = data.testCode;
           	SctCode = data.SctCode;
           	LonicCode = data.LonicCode;
           	CptCode = data.CptCode; 
            $('#SelectLeft').html(titleData);
           },
			error: function(message){
			 alert("Internal Error Occured. Unable To Save Data.");
           },       
           });
     
     return false;
		
	}


//*************LAB and Radiology***Functions-------------
	

	function getLabDetail(){
			   var labid = $('#SelectLab').val(); 
			   alert(labid);
				  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "diagnoses", "action" => "getLabDetails","admin" => false)); ?>";
			        $.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+labid,
			          data: '',
			          dataType: 'html',
			          success: function(data){ 
			       	var data = data.split("|");	
			        $("#testname").val(data[0]);
			        $("#sctCode").val(data[1]);
			        $("#LonicCode").val(data[2]);
			        $("#testcode").val(data[3]);
					},
						
						error: function(message){
			              alert("Internal Error Occured. Unable to set data.");
			          }        });
			    
			    return false; 
			}

	function getRadDetail(){
		   var labid = $('#SelectRad').val();
		   if(labid==''){
			   $('#rad_testname').val('');
		   }
		   if(labid!=''){
			  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "diagnoses", "action" => "getRadDetails","admin" => false)); ?>";
		        $.ajax({
		          type: 'POST',
		          url: ajaxUrl+"/"+labid,
		          data: '',
		          dataType: 'html',
		          success: function(data){ 
		          data = jQuery.parseJSON(data);
		        $("#rad_testname").val(data.name);
		        $("#rad_sctCode").val(data.test_code);
		        $("#rad_LonicCode").val(data.lonic_code);
		        $("#rad_testcode").val(data.sct_concept_id);
		        $("#rad_cptCode").val(data.cpt_code);
		        },
					
					error: function(message){
		              alert("Internal Error Occured. Unable to set data.");
		          }        });
		    
		    return false; 
		}
	}
	
	
	

	
	function save_laborder(Clinical){ 
		if($('#specimen_type_id').val()==""){
			alert('Check validations');
			return false;
		}
		if($('#testname').val()==""){
			alert('Check validations');
			return false;
		}
		var getdata=Clinical;
		var token = $('#token_id').val();
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "save_laborder",$patient_id,"admin" => false)); ?>";

		 var formData = $('#diagnosisfrm').serialize(); 
		 if(formData==""){
			 var formData = $('#patientnotesfrm').serialize();
			 var renderpage=true;
			}
		patientid="<?php echo $patient_id?>";
		   $.ajax({
	            type: 'POST',
	           	url: ajaxUrl+"/"+token,
	            data: formData,
	            dataType: 'html',
	            beforeSend : function() {
					//this is where we append a loading image
	            	$('#busy-indicator').show('fast');
				},
				success: function(data){ 
					$('#busy-indicator').hide('fast');
					getLAbRadEkg();
	            if(data.match(/Please enter/)){
					///----error message
            		
            		return false;
	            }else{
		            if($('#token_id').val() == '')
		           		alert("Record added successfully") ;
		            else
			            alert("Record updated successfully");
		            if(!renderpage){
					if(data == 'ambulatory'){
		            window.location.href = '<?php echo $this->Html->url('/diagnoses/add_ambi/'); ?>'+patientid;
		            }else{
		            	window.location.href = '<?php echo $this->Html->url('/diagnoses/add/'); ?>'+patientid+'/'+getdata;
		            }
		            }else{
		            	$("#accordionCust").accordion({
			                collapsible: true,
			                active: false,
			                alwaysOpen: false
			            });
		            	if(getdata=='HbA1c')
		    			{
		            		$('#changecolor').css('color','green');
	
		    			}
		            	else{
		            		//alert(getdata);
		            	}
		            }
	            }
	            },
				error: function(message){
	                alert("Internal Error Occured. Unable To Save Data.");
	            }        });
	      
	      return false;
	}
	

	function edit_laborder(id){
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "edit_laborder","admin" => false)); ?>";
		   var formData = $('#diagnosisfrm').serialize();
			   if(formData==""){
				 var formData = $('#patientnotesfrm').serialize();
				 var renderpage=true;
				}
	           $.ajax({
	        	   beforeSend : function() {
						//this is where we append a loading image
		            	$('#busy-indicator').show('fast');
					},
	            type: 'POST',
	           url: ajaxUrl+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
		            alert(data);
		            
	            	$('#busy-indicator').hide('fast');
				var data = data.split("|"); 
					$("#token_id").val(id);
					$("#testOrder_id").val($.trim(data[0]));
					$("#testname").val(data[1]);
				//	$("status").val(); = data[2];
					$("#sample").val(data[3]);
					$("#collected_date").val(data[4]); 
					$("#spec_rej").val(data[5]);
					$("#rej_reason_txt").val(data[6]);
					$("#cond_org_txt").val(data[7]);
					$("#bill_type").val(data[8]);
					$("#testcode").val(data[9]);
					$("#specimen_type_id").val(data[10]);
					$("#alt_spec").val(data[11]);
					$("#ac_id").val(data[12]);
					$("#specimen_condition_id").val(data[13]);
					$("#alt_spec_cond").val(data[14]);
					$("#account_no").val(data[15]);
					$("#specimen_action_id").val(data[16]);
					$("#end_date").val(data[17]);
					$("#sctCode").val(data[18]);
					$("#LonicCode").val(data[19]);
					$("#lab_start").val(data[21]);
					$("#lab_order").val(data[22]);
					$("#lab_order_date").val(data[23]);
					$("#service_provider_id").val(data[24]);
						
					
					},
				error: function(message){
	                alert("Error in Retrieving data");
	            }        });
	      
	      return false; 
	}
	
	function save_radorder(Clinical){
		var getdata=Clinical;
		//alert(getdata);
		if($('#rad_testname').val()==""){
			alert('Check Validations');
			return false;
		}
		var testOrdId = $('#radTestId').val();
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "save_radorder",$patient_id,"admin" => false)); ?>";
		   var formData = $('#diagnosisfrm').serialize();
			   if(formData==""){
				 var formData = $('#soapId').serialize();
				 var renderpage=true;
				}
		   patientid="<?php echo $patient_id?>";
	
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+testOrdId,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
	            	alert("Record update successfully") ;
	            	if(!renderpage){			            
			            if(data == 'ambulatory'){
			            window.location.href = '<?php echo $this->Html->url('/diagnoses/add_ambi/'); ?>'+patientid;
			            }else{
			            	window.location.href = '<?php echo $this->Html->url('/diagnoses/add/'); ?>'+patientid+'/'+getdata;			            	
			            }
			            }else{
			            	$("#accordionCust").accordion({
				                collapsible: true,
				                active: false,
				                alwaysOpen: false
				            });
				          //  alert(getdata);
			            	if(getdata=='Pap smear')
			    			{
			            		$('#changecolor1').css('color','green');		
			    			}
			            	else{
			            		//alert(getdata);
			            	}
			            }
		            }
		            ,
					error: function(message){
		                alert("Internal Error Occured. Unable To Save Data.");
		            }        });
		      
		      return false;
		}
		
	
	function edit_radorder(id){
	
				  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "diagnoses", "action" => "edit_radorder","admin" => false)); ?>";
				   var formData = $('#diagnosisfrm').serialize();
					   if(formData==""){
						 var formData = $('#patientnotesfrm').serialize();
						 var renderpage=true;
						}
			           $.ajax({
			            type: 'POST',
			           url: ajaxUrl+"/"+id,
			            data: formData,
			            dataType: 'html',
			            success: function(data){
						var data = data.split("|"); 
				
							document.getElementById("rad_testname").value = data[0];
							document.getElementById("rad_testcode").value = data[1];
							document.getElementById("radTestId").value = data[2];
							document.getElementById("rad_sctCode").value = data[3];
							document.getElementById("rad_LonicCode").value = data[4];
							document.getElementById("rad_cptCode").value = data[5];
							document.getElementById("start_date").value = data[6];
								
							if(data[7] != ''){
					        	$('#is_procedure').attr('checked','checked');
					        	
					        	 }
							document.getElementById("radiology_order").value = data[8];	
							document.getElementById("radiology_order_date").value = data[9];
							document.getElementById("rad_service_provider_id").value = data[10];
			            },
						error: function(message){
							alert("Error in Retrieving data");
			            }        });
			      
			      return false; 
			}
	function edit_ekg(id,patient_id){
		
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "EKG", "action" => "edit_investigation_ekg","admin" => false)); ?>";
		   var formData = $('#diagnosisfrm').serialize();
			   if(formData==""){
				 var formData = $('#patientnotesfrm').serialize();
				 var renderpage=true;
				}
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+id+"/"+patient_id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
	            	data = jQuery.parseJSON(data);
		           $("#history").val(data.EKG.history);
		          	$("#cardiac_medication").val(data.EKG.cardiac_medication);
		          	if(data.EKG.pacemaker == 'yes'){ 
		          		$("#EKGPacemakerYes").attr('checked','checked');
		          	}else if(data.EKG.pacemaker == 'no'){
		          		$("#EKGPacemakerNo").attr('checked','checked');
		          	}else if(data.EKG.pacemaker == 'unknown'){
		          		$("#EKGPacemakerUnknown").attr('checked','checked');
		          	}
		          	$("#check_one").val(data.EKG.check_one);
		          	if(data.EKG.assignment_accepted == 'yes'){ 
		          		$("#EKGAssignmentAcceptedYes").attr('checked','checked');
		          	}else if(data.EKG.assignment_accepted == 'no'){
		          		$("#EKGAssignmentAcceptedNo").attr('checked','checked');
		          	}
					$("#ekgId").val(data.EKG.id);
					//$("#ekg-investigation").html(data);	
				},
				error: function(message){
					alert("Error in Retrieving data");
	            }        });
	      
	      return false; 
	}
	
function gen_HL7_Lab(id){
	
		var curdate = caldate();
		$("#curdate").val(curdate);
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Hl7Messages", "action" => "gen_HL7_Lab","admin" => false)); ?>";
		   var formData = $('#diagnosisfrm').serialize();
		   patientid="<?php echo $patient_id?>";
		  
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl+"/"+patientid+"/"+id,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
					window.location.href = '<?php echo $this->Html->url('/diagnoses/add/'); ?>'+patientid;
	            },
				error: function(message){
	                alert("Internal Error Occured. Unable To Generate Message.");
	            },        });
	      
	      return false;
	}
	
	function caldate(){
		var now = new Date(); 
		var now_utc = new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(),  now.getHours(), now.getMinutes(), now.getSeconds());
		return now_utc;
	}
	$("#radiology_order_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true, 
				minDate: new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				'float' : 'right',	
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});


	$("#lab_order_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,

				changeYear : true, 

				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				'float' : 'right',	
				onSelect : function() {
					$(this).focus();
					//foramtEnddate(); //is not defined hence commented
				}
				
			});

	// EOF *********Lab*** Rad-------gaurav
	

	//EOF radiology JS
	// lab test autocomplete
	
	jQuery(document).ready(function(){
		/*$('#test_name').keydown(function(){
			$("#testname").val('');	 
			var currentDepartmentId = $("#testname").val();
			if(currentDepartmentId != '')
				$( "#test_name").trigger( "autocomplete" );   
			//textBoxExpnd
		});*/ 
	 

			$("#test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","Laboratory",'id',"name",'common=1',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				valueSelected:true,
				loadId : 'testname,testcode'
			});

			$("#ekgsubmit").bind("click", function (event) {
				if($('#history').val()==''){
					alert('Check Validation');
					return false;
				}
				//alert($('#pacemaker:checked').val());
						/*
				//$.ajax({data:$("#diagnosisfrm").serialize(),
					 success:function (data, textStatus) {
						 ekg_success();
						 }, 
					 type:"post", 
					 url:"<?php //echo $this->Html->url(array('controller'=>'EKG','action'=>'add',$patient_id))?>"});*/

					 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "EKG", "action" => "add","admin" => false)); ?>";
					   	var history = $('#history').val();
					   	var assignment_accepted = $('input[name=assignment_accepted]:checked').val();
					   	var pacemaker =$('input[name=pacemaker]:checked').val();
			  		   	var cardiac_medication = $('#cardiac_medication').val();
			  		 	var check_one =$('#check_one').val();//ekgId
			  		 	var id = ($('#ekgId').val() != '') ? $('#ekgId').val() : '';
					  
				           $.ajax({
				        	   beforeSend : function() {
				           		$('#busy-indicator').show('fast');
				             	},
				            type: 'POST',
				           	url: ajaxUrl+"/"+'<?php echo $patient_id?>',
				            data: {id: id, history: history, check_one:check_one,assignment_accepted: assignment_accepted,pacemaker: pacemaker,cardiac_medication: cardiac_medication },
				            dataType: 'html',
				            success: function(data){
				            	$('#busy-indicator').hide('fast');
					            $("#accordionCust").accordion({
					                collapsible: true,
					                active: false,
					                alwaysOpen: false
					            });
								//window.location.href = '<?php echo $this->Html->url('/diagnoses/add/'); ?>'+<?php echo $patient_id?>;
				            },
							error: function(message){
				                alert("Internal Error Occured. Unable To Generate Message.");
				            },        });
				      
				      return false;
			return false;});
			
  
	 });
	
	/*function proceduresearch(source) {
	    var identify =""; 
		identify = source;
		$.fancybox({
					'width' : '100%',
					'height' : '100%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "proceduresearch")); ?>" + "/" + identify,
				});
       } */
	
	
</script>
