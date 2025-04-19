
<style>
.blueBtn {
	color: #000000;
}
</style>
<?php //BOF lab order ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td></td>
		<td align="right"><a class="tdLabel2"
			style="text-decoration: underline;" href="#" id="swap_investigation">Immunization</a></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>

<div id="lab-investigation">

	<a href="#" onclick="showOrder()">Order</a>&nbsp;&nbsp;&nbsp;&nbsp;<a
		href="#" onclick="showResult()">Result</a>
		<div id="successMessage" align="center" class="message" style="display:none"></div>
	<div class="clr ht5"></div>
	<div align="center" id='temp-busy-indicator1' style="display: none;">
		&nbsp;
		<?php echo $this->Html->image('indicator.gif', array()); ?>
	</div>
	<div id="order" style="cursor: hand; display: none">
		<table width="100%" cellpadding="0" cellspacing="1" border="0"
			class="tabularForm">

			<tr>
				<td valign="top">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="60" class="tdLabel2"><strong>Order</strong></td>
							<td width="250" cellpadding:right='200px'>Look Up Name</td>
							<td width="250" cellpadding:right='200px'>From</td>
							<td width="250" cellpadding:right='200px'>To</td>
							<td width="250" cellpadding:right='200px'>
							<td colspan='4' align='right' valign='bottom'><?php echo $this->Html->link(__('Report'),"",array('id'=>'','class'=>'blueBtn')); ?></td>
						</tr>
						<tr>
							<td width="250" cellpadding:right='200px'></td>
							<td width="250" cellpadding:right='200px'><?php echo $this->Form->input('name', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','value'=>$setName,'id'=>'name','autocomplete'=>'off','label'=>false,'div'=>false)); ?></td>
							<td width="250" cellpadding:right='200px'><?php echo $this->Form->input('from', array('class' => 'textBoxExpnd from','style'=>'padding:7px 10px; width:120px','id'=>'from','autocomplete'=>'off','label'=>false,'div'=>false)); ?></td>
							<td width="250" cellpadding:right='200px'><?php echo $this->Form->input('to', array('class' => 'textBoxExpnd to','style'=>'padding:7px 10px; width:120px','id'=>'to','autocomplete'=>'off','label'=>false,'div'=>false)); ?></td>
							<td width="250" cellpadding:right='200px'>
							<td colspan='4' align='right' valign='bottom'></td>
						</tr>
					</table>
				</td>

			</tr>

		</table>

		<!--BOF list -->
		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%" style="text-align: center;">
			<?php if(isset($testOrdered_lab) && !empty($testOrdered_lab)){  ?>
			<tr class="row_title">
				<td class="table_cell"><strong> <?php echo __('Lab Order id'); ?>
				</strong></td>
				<td class="table_cell"><strong> <?php echo __('Test'); ?>
				</strong></td>
				<td class="table_cell"><strong> <?php echo __('Lab creation Date'); ?>
				</strong></td>
				<td class="table_cell"><strong> <?php echo __('Order'); ?>
				</strong></td>
				<!-- 	<td class="table_cell"><strong> <?php // echo __('SNOMED Codes'); ?>
			</strong></td> -->
				<td class="table_cell"><strong> <?php echo __('Status'); ?>
				</strong></td>


			</tr>

			<?php 

							  $toggle =0;
							  $time = '';
							  if(count($testOrdered_lab) > 0) {
									foreach($testOrdered_lab as $labs){
										   /*$splitDateTime   = explode(" ",$labs['LaboratoryTestOrder']['create_time']) ;
							   			   $splitTime = explode(":",$splitDateTime[1]);
							   			   $currentTime =  $splitTime[0].":".$splitTime[1];
							   			   $timeWtoutSec = $splitDateTime[0]." ".$currentTime ;*/
							   			   $currentTime = $labs['LaboratoryTestOrder']['batch_identifier'];
										   if($time != $currentTime ){
										   		if(!empty($test_ordered)) {
										   			echo "<tr class='row_title'><td colspan='10' align='right' style='padding: 8px 5px;'>" ;
		                                 			echo $this->Html->link(__('Print Slip'),
													     '#',
													     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'laboratories','action'=>'investigation_print',$patient_id,$currentTime))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
													echo "</td></tr>" ;
		                                 		}else{
		                                 			echo "<tr class='row_title'><td colspan='10'>&nbsp;</td></tr>" ;
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
										   		$status = 'Resulted';
										   		 
										   }else{
										   		$status = 'Pending';
										   		 
										   }
										  ?>
			<td class="row_format"><?php echo $labs['LaboratoryTestOrder']['order_id']; ?></td>

			<td class="row_format"><?php echo $labs['LaboratoryToken']['laboratory_id']; ?></td>

			<td class="row_format"><?php echo $labs['LaboratoryTestOrder']['create_time']; ?></td>

			<?php $order =$labs['LaboratoryTestOrder']['order_id']; ?>
			<td class="row_format"><?php echo  $substring = substr($order, 0, -11); ?></td>


			<td class="row_format"><?php 
				if($status == 'Pending'){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'laboratories','action' => 'deleteLabTest', $labs['LaboratoryTestOrder']['id']), array('escape' => false),__('Are you sure?', true));	
				}
						 
$labo_id = $labs['LaboratoryToken'][0]['id'];
echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_laborder($labo_id);return false;")), array(), array('escape' => false));
/* echo $this->Html->link($this->Html->image('icons/sign-icon.png',array('title'=>'Generate HL7','alt'=>'Generate HL7', 'onclick'=>"gen_HL7_Lab($labo_id);return false;")), array(), array('escape' => false));
	*/ ?>
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
						  } else {
					 ?>
			<tr>
				<TD colspan="8" align="center" class="error"><?php echo __('No test assigned to selected patients', true); ?>.
				</TD>
			</tr>
			<?php
						  }
						  
						  echo $this->Js->writeBuffer();
					  ?>
		</table>
	</div>
	<div id="result" style="cursor: hand; display: none">
		<table width="100%" cellpadding="0" cellspacing="1" border="0"
			class="tabularForm">

			<tr>
				<td valign="top">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="60" class="tdLabel2"><strong>Order</strong></td>
							<td width="250" cellpadding:right='200px'>Look Up Name</td>
							<td width="250" cellpadding:right='200px'>From</td>
							<td width="250" cellpadding:right='200px'>To</td>
							<td width="250" cellpadding:right='200px'>
							<td colspan='4' align='right' valign='bottom'><?php echo $this->Html->link(__('Report'),"",array('id'=>'','class'=>'blueBtn')); ?></td>
						</tr>
						<tr>
							<td width="250" cellpadding:right='200px'></td>
							<td width="250" cellpadding:right='200px'><?php echo $this->Form->input('name', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','value'=>$setName,'id'=>'name','autocomplete'=>'off','label'=>false,'div'=>false)); ?></td>
							<td width="250" cellpadding:right='200px'><?php echo $this->Form->input('from', array('class' => 'textBoxExpnd from','style'=>'padding:7px 10px; width:120px','id'=>'from','autocomplete'=>'off','label'=>false,'div'=>false)); ?></td>
							<td width="250" cellpadding:right='200px'><?php echo $this->Form->input('to', array('class' => 'textBoxExpnd to','style'=>'padding:7px 10px; width:120px','id'=>'to','autocomplete'=>'off','label'=>false,'div'=>false)); ?></td>
							<td width="250" cellpadding:right='200px'>
							<td colspan='4' align='right' valign='bottom'></td>
						</tr>
					</table>
				</td>

			</tr>

		</table>

		<!--BOF list -->
		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%" style="text-align: center;">
			<?php/*  if(isset($testOrdered_lab) && !empty($testOrdered_lab)){   */?>
			<td class="table_cell"><strong> <?php echo __('Order#'); ?>
			</strong></td>
			<td class="table_cell"><strong> <?php echo __('U_ID'); ?>
			</strong></td>
			<!-- <td class="table_cell"><strong> <?php echo __('Test Name'); ?>
			</strong></td>-->
			<td class="table_cell"><strong> <?php echo __('OrderType'); ?>
			</strong></td>
			<!-- 
			<td class="table_cell"><strong> <?php echo __('Review'); ?>
			</strong></td>-->
			<td class="table_cell"><strong><?php echo __('Action'); ?></strong></td>


			</tr>

			<?php 

$getCount=count($get_Result);
//echo "<pre>";print_r($get_Result);exit;
for($i=0;$i<count($get_Result);$i++){

$result_hl7[]=explode("\n",$get_Result[$i]['Hl7Result']['message']);
}
$cnt=count($result_hl7);


for($i=0;$i<count($result_hl7);$i++){
$result_MSH[]=explode('|',$result_hl7[$i]['0']);
$result_PID[]=explode('|',$result_hl7[$i]['1']);
$result_ORC[]=explode('|',$result_hl7[$i]['2']);
$result_OBR[]=explode('|',$result_hl7[$i]['3']);
$result_NTE[]=explode('|',$result_hl7[$i]['4']);
$result_TQ1[]=explode('|',$result_hl7[$i]['5']);
$result_OBX[]=explode('|',$result_hl7[$i]['6']);
$result_SPM[]=explode('|',$result_hl7[$i]['7']);
}




							  $toggle =0;
							  $time = '';
							  if(count($get_Result) > 0) {//debug($get_Result);

									for($i=0;$i<count($get_Result);$i++){
										 
										   if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr class='row_gray'>";
												$toggle = 0;
										   }
									
										  ?>
			<td class="row_format"><?php 
			$o_r_d  = explode("^",$result_ORC[$i]['2']);
			echo  $o_r_d[0]?></td>
			<?php $u_id=explode('^',$result_PID[$i]['3']); ?>
			<?php //for($i=0;$i<=count($get_Result);$i++){ ?>
			<td class="row_format"><?php echo $this->Html->link($u_id['0'],array('controller' => 'diagnoses', 'action' => 'viewresult',$u_id['0'],$i)); ?></td>
			
			<!-- <td class="row_format"><?php echo $labs['LaboratoryTestOrder']['create_time']; ?></td> -->

			<?php $order =$labs['LaboratoryTestOrder']['order_id']; ?>
			<td class="row_format">LAB<?php //echo  $substring = substr($order, 0, -11); ?></td>
			<!-- <td class="row_format"><?php echo $labs['LaboratoryTestOrder']['order_id']; ?></td> -->






			<td class="row_format"><?php 
				if($status == 'Pending'){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'laboratories','action' => 'deleteLabTest', $labs['LaboratoryTestOrder']['id']), array('escape' => false),__('Are you sure?', true));	
				}
						 
$labo_id = $labs['LaboratoryToken'][0]['id'];
echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_laborder($labo_id);return false;")), array(), array('escape' => false));
/* echo $this->Html->link($this->Html->image('icons/sign-icon.png',array('title'=>'Generate HL7','alt'=>'Generate HL7', 'onclick'=>"gen_HL7_Lab($labo_id);return false;")), array(), array('escape' => false));
	*/ 
$uid = $u_id['0'];
echo $this->Html->image('icons/post_reply.gif',array('title'=>'Send','alt'=>'Send', 'onclick'=>"openPopUp('$uid','$i','$patient_id')"));//$u_id['0'],$i)
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
			<?php } ?><?php //} ?>
			<?php					  
						/*   } else { */
					 ?>
			<!-- <tr>
				<TD colspan="8" align="center" class="error"> --><?php /*echo __('No test assigned to selected patients', true); */ ?>
				<!-- </TD>
			</tr> -->
			<?php
						/*   }
						  
						  echo $this->Js->writeBuffer(); */ 
					  ?>
		</table>
	</div>
</div>

<!-- ====================================================================================================================================== -->
<?php
			//EOF lab order 
		 	//BOF radiology order
		 	?>
<div id="radiology-investigation" style="display: none;">

	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm">

		<tr>
			<td valign="top">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="60" class="tdLabel2"><strong>Search</strong></td>
						<td width="250"><?php 
                            	echo $this->Form->input('search', array('class' => 'textBoxExpnd','style'=>'padding:7px 10px;','id'=>'radiology-search','autocomplete'=>'off','label'=>false,'div'=>false));
                            	echo $this->Form->hidden('RadiologyTestOrder.patient_id', array('value'=>$patient_id));
                            	echo $this->Form->hidden('RadiologyTestOrder.from_assessment', array('value'=>1));
						?>
						</td>
						<td width="450"><?php	echo $this->Form->input('RadiologyTestOrder.radiology',array('options'=>$radiology_test_data,'escape'=>false,'empty'=>'Please Select',
	                            					'multiple'=>false,'style'=>'width:400px;','id'=>'RadSelectLeft','label'=>false,'div'=>false,'onChange'=>'javascript:changeTestRad()'));
                            ?>
						</td>
						<td>
							<div align="center" id='temp-busy-indicator'
								style="display: none;">
								&nbsp;
								<?php echo $this->Html->image('indicator.gif', array()); ?>
							</div>
						</td>

					</tr>
				</table>
			</td>

		</tr>

	</table>

	<!--BOF list -->
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center;">
		<?php if(isset($radiology_test_ordered) && !empty($radiology_test_ordered)){ 

					
					
					?>
		<tr class="row_title">
			<td class="table_cell"><strong> <?php echo $this->Paginator->sort('RadiologyTestOrder.order_id', __('Radiology Order id', true)); ?>
			</strong></td>
			<td class="table_cell"><strong> <?php echo $this->Paginator->sort('RadiologyTestOrder.create_time', __('Order Time', true)); ?>
			</strong></td>
			<td class="table_cell"><strong> <?php echo $this->Paginator->sort('Radiology.name', __('Test Name', true)); ?>
			</strong></td>
			<td class="table_cell"><strong> <?php echo  __('Status'); ?>
			</strong></td>
			<td class="table_cell"><strong> <?php echo  __('Action'); ?>
			</strong></td>

		</tr>
		<?php 
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
										   			echo "<tr class='row_title'><td colspan='5' align='right' style='padding: 8px 5px;'>" ;
		                                 			echo $this->Html->link(__('Print Slip'),
													     '#',
													     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'radiologies','action'=>'investigation_print',$patient_id,$currentTime))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
													echo "</td></tr>" ;
		                                 		}else{
		                                 			echo "<tr class='row_title'><td colspan='5'>&nbsp;</td></tr>" ;
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
										   		$status = 'Resulted';
										   		 
										   }else{
										   		$status = 'Pending';
										   		 
										   }
										  ?>
		<td class="row_format"><?php echo $labs['RadiologyTestOrder']['order_id']; ?>
		</td>
		<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($labs['RadiologyTestOrder']['create_time'],Configure::read('date_format'),true); ?>
		</td>
		<td class="row_format"><?php echo ucfirst($labs['Radiology']['name']); ?>
		</td>
		<!--  <td class="row_format">
			<?php echo $status; ?>
		</td>-->
		<td class="row_format"><?php echo $labs['RadiologyTestOrder']['status']; ?>
		</td>
		<td class="row_format"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'radiologies','action' => 'deleteRadTest', $labs['RadiologyTestOrder']['id'],$currentTime), array('escape' => false),__('Are you sure?', true));
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
						  } else {
					 ?>
		<tr>
			<TD colspan="8" align="center" class="error"><?php echo __('No test assigned to selected patients', true); ?>.
			</TD>
		</tr>
		<?php
						  }
						  
						  echo $this->Js->writeBuffer();
					  ?>
	</table>

</div>
<?php //EOF radiology order ?>

<script language="javascript" type="text/javascript">
	$(document)
			.ready(
					function() {

						$('#swap_investigation')
								.click(
										function() {

											if ($('#lab-investigation').css(
													'display') == 'none') {
												$('#radiology-investigation')
														.fadeOut('fast');
												$('#lab-investigation').fadeIn(
														'slow');
												$(this)
														.text(
																'Immunization');
											} else {
												$('#lab-investigation')
														.fadeOut('fast');
												$('#radiology-investigation')
														.fadeIn('slow');
												$(this)
														.text(
																'Clinical');
											}
											return false;
										});
						

					
						
					});
	$(".to")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange : '-50:+50',
				maxDate : new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
			});
	$(".from")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>
	",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange : '-50:+50',
						maxDate : new Date(),
						dateFormat:'<?php echo $this->General->GeneralDate();?>',
					});

	//EOF radiology JS
</script>
<script>
function showOrder(){
	
	$('#order').show();
	$('#result').hide();
}
function showResult(){
	
	$('#order').hide();
	$('#result').show();
}

function openPopUp(uid,id,patient_id){


$.fancybox({

	'width' : '50%',
	'height' : '120%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "sendHl7Message")); ?>"+'/'+ uid+'/'+ id+'/'+ patient_id
});
}

</script>
