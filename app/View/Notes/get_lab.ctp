
<?php 

	if(!empty($testOrdered)){ ?>
<table width="100%" class="formFull formFullBorder">
	<tr style="color: gray">
		<td
			style="text-align: left; font-weight: bold; background: #d2ebf2 repeat-x; padding: 5px 0 5px 10px;"
			colspan="7">Lab Records</td>
	</tr>
	<tr bgcolor="#CCCCCC">
		<td width=15% style="padding: 5px 0 5px 10px;">Lab Name</td>
		<td width=15% style="padding: 5px 0 5px 10px;">Accession ID</td>
		<td width=15% style="padding: 5px 0 5px 10px;">Order Date</td>
		<td width=15% style="padding: 5px 0 5px 10px;">Loinc Code</td>
		<td width=15% style="padding: 5px 0 5px 10px;">Status</td>
		<td width=15% style="padding: 5px 0 5px 10px;">Result</td>
		<td width=15% style="padding: 5px 0 5px 10px;">Action</td>
	</tr>
	<?php 
	$loopCount = 0;
	$isDisplayed = array();
	foreach($testOrdered as $data){//echo '<pre>';print_r($data);
		$abnormalResultsStatus = '';
		foreach($data['LaboratoryHl7Result'] as $deepKey=>$deepRes){
			if($deepRes['abnormal_flag'] && strtoupper($deepRes['abnormal_flag']) != 'N'){
				$abnormalResultsStatus = 'Abnormal';
				break;
			}else{
				$abnormalResultsStatus = 'Normal';
			}
			
		}
		
		if(in_array($data['LaboratoryResult']['id'], $isDisplayed)){//echo '<pre>';print_r($isDisplayed);
			continue;
		}
		if(empty($data['Laboratory']['id'])){
			$data['Laboratory'] = $data['LaboratoryAlias'];
		}
	?>
	<?php $curOrderId = $data["LabManager"]["order_id"];?>
	<?php if($oldOrderId != $data["LabManager"]["order_id"] || $loopCount == 0){?>
	<?php $oldOrderId = $curOrderId;
			$isProcessed = ($data["LabManager"]['is_processed'] == '') ? 'Transmit' : 'Transmitted';
			$cursor = ($isProcessed == 'Transmit') ? 'cursor: pointer;' : '';
		$loopCount++;
	?>
	<tr style="color: gray">
		<td
			style="text-align: right; font-weight: bold; background: #d2ebf2 repeat-x; padding: 5px 60px 5px 10px; <?php echo $cursor?>"
			colspan="7"><span class="blueBtn <?php echo $isProcessed  ?>" id='<?php echo $oldOrderId ?>' 
			style="height: 25px !important; padding: 3px;color: #31859c !important;font-weight: normal;">
			<?php echo $isProcessed;?></span></td>
	</tr>
	<?php } ?>
	<?php if($data["LaboratoryHl7Result"]["abnormal_flag"]=='HH' || $data["LaboratoryHl7Result"]["abnormal_flag"]=='H'){
		$satus="Higer than Normal Range";
		$color="red";
	}else if($data["LaboratoryHl7Result"]["abnormal_flag"]=='LL' || $data["LaboratoryHl7Result"]["abnormal_flag"]=='L'){
							$satus="Lower than Normal Range";
							$color="blue";
						}
						else if($data["LaboratoryHl7Result"]["abnormal_flag"]=='N'){
							$satus="Normal";

						}
						else{
							$satus = $data["LaboratoryHl7Result"]["abnormal_flag"];
						}

						if($toggle == 0) {
							$objHtml.= "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$objHtml.= "<tr>";
							$toggle = 0;
						}
						?>
	<td style="padding: 5px 0 5px 10px;"><?php if(!empty($data["LaboratoryHl7Result"]['0']["result"])){//echo '<pre>';print_r($data);
		//echo //$this->Html->link(($data["LaboratoryResult"]["od_universal_service_text"])?$data["LaboratoryResult"]["od_universal_service_text"]:$data["Laboratory"]["//name"],array('controller'=>'laboratories','action'=>'viewLabTestResultsHl7',
						//$data["LabManager"]["patient_id"],$data["LabManager"]['id'],$data["LaboratoryResult"]['id'],'?'=>array('noteId'=>$noteId)),array('title//'=>'View Detailed Results'));
						echo $this->Html->link(($data["LaboratoryResult"]["od_universal_service_text"])?$data["LaboratoryResult"]["od_universal_service_text"]:$data["Laboratory"]["name"],array('controller'=>'NewLaboratories','action'=>'printlab',
											$data["LabManager"]['id'],$data["LaboratoryResult"]['id']),array('title'=>'View Detailed Results'));
	}
	else{
					echo $this->Html->link($data["Laboratory"]["name"],array('controller'=>'laboratories','action'=>'labTestResultsHl7',
					$data["LabManager"]['id'],$data["LabManager"]["patient_id"],'?'=>array('noteId'=>$noteId)),array('title'=>'Enter Results'));

						}?>
	</td>
	<td style="padding: 5px 0 5px 10px;"><?php echo __($data["LabManager"]["order_id"]);?>
	</td>
	<td style="padding: 5px 0 5px 10px;"><?php if(!empty($data["LabManager"]["start_date"]))
		echo $this->DateFormat->formatDate2Local($data["LabManager"]["start_date"],Configure::read('date_format'),true);
	else
		echo "...";?>
	</td>
	<td style="padding: 5px 0 5px 10px;"><?php if(!empty($data["Laboratory"]["lonic_code"]))
		echo $data["Laboratory"]["lonic_code"];
	else
		echo "...";?>
	</td>
	<td style="padding: 5px 0 5px 10px;"><?php if(!empty($abnormalResultsStatus))
		echo $abnormalResultsStatus;
	else
		echo "...";?>
	</td>
	<?php 
	if(empty($abnormalResultsStatus))
		$result='Result Not Published';
	else
		$result=$result='Result Published';;

	?>
	<td style="padding: 5px 0 5px 10px;"><?php echo $result; ?></td>
	<td style="padding: 5px 0 5px 10px;"><?php 
	$labId=$data[LabManager][id];
	echo $this->Html->image('icons/print.png',
								array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'laboratories','action'=>'investigation_print',$data['LabManager']['patient_id'],$data['LabManager']['batch_identifier']))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,left=400,top=300,height=700');  return false;"));
						echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'laboratories','action' => 'deleteLabTest', $data['LabManager']['id']), array('escape' => false),__('Are you sure?', true));
						echo $this->Html->link($this->Html->image('icons/edit-icon.png',
array('title'=>'Edit','alt'=>'Edit')),'#', array('onclick'=>"edit_laborder('$labId');",'escape' => false));?>
	</td>
	<td width="30%"><?php //echo $this->Form->checkbox('',array('name'=>'medCheck','id'=>$data['LabManager']['batch_identifier'],'value'=>$data['LabManager']['batch_identifier'],'class'=>'LabCheckClass'));?>
	</td>
	</tr>
	<?php 	
	if($data['LaboratoryResult']['id'])
		array_push($isDisplayed, $data['LaboratoryResult']['id']);
	}
	
	?>
	</tr>
</table>
<?php 	}
?>
<script>
				 function edit_laborder(id){
				$.fancybox({
					'width' : '70%',
					'height' : '70%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "editLab")); ?>"
					+'/'+id,

				});
				}
					//Print all
					var labToPrint = new Array();
				 jQuery(document).ready(function() {
						$('.LabCheckClass').attr('checked',true);
						$(".LabCheckClass").each(function(){
							labToPrint.push($(this).val());
						  });
						
					});	
				 $('.LabCheckClass').click(function(){	
						var currentId= $(this).attr('id');


						if($(this).prop("checked"))
							labToPrint.push($('#'+currentId).val());
						else
							labToPrint.remove($('#'+currentId).val());
							

						});
				 function newPrint1(patientId){  
						var printUrl='<?php echo $this->Html->url(array("controller" => "laboratories", "action" => "investigation_print")); ?>';
						var printUrl=printUrl + "?labToPrint="+labToPrint+"&allergyToPrint="+"";

						var openWin =window.open(printUrl, '_blank',
						'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');
						}

				 $('.Transmit').click(function (){
					 var accessionId = $(this).attr('id'); 
						 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "transmitLab","admin" => false)); ?>"+"/"+accessionId;
						   $.ajax({
					            type: 'GET',
					           	url: ajaxUrl,
					            dataType: 'html',
					            beforeSend : function() {
									//this is where we append a loading image
					            	$('#busy-indicator').show('fast');
								},
								success: function(data){ 
									$('#busy-indicator').hide('fast');
									$('#'+accessionId).text('Transmitted').css('cursor','default').removeClass('Transmit');;
								},
							});
					     
					});
				</script>
