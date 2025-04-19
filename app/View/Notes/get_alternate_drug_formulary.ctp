	<?php
        $FormularyStatus=Configure :: read('FormularyStatus');
		$FormularyStatusDesc=Configure :: read('FormularyStatusDesc'); 
	if(!empty($alternateFormularyData)){?>
					<table  width="50%" class="formFull formFullBorder" align="center">
							<tr style="color:gray"><td style="text-align:left;font-weight:bold; background:#d2ebf2 repeat-x;padding: 5px 0 5px 10px;" colspan="5">Alternatives<span style="text-align:right"><?php echo $this->Html->link(__('Close'), 'javascript:void(0)', array('class'=>'blueBtn','style'=>'float:right; width:40px; height:15px !important; text-align:center;','onclick'=>'javascript:closeFormulary()'));?></span></span></td></tr>
					<tr bgcolor="#CCCCCC"><td width=12% style="padding:5px 0 5px 10px;">Drug Name</td>
		<td width=10% style="padding:5px 0 5px 10px;">Formulary Status</td>
		<td width=18% style="padding:5px 0 5px 10px;">Description</td>
		<td width=10% style="padding:5px 0 5px 10px;">Therapeutic Class</td>
		
		</tr>
		<?php 
			foreach($alternateFormularyData as $data){

               $formularyCoverage=(string) $data->formularyCoverage;

              
						?>
					<td width=12% style="padding:5px 0 5px 10px;">
					<?php 
		                 echo $this->Html->link(ucfirst($data->drugDetail->Drug),'#',array('title'=>'Click to change','onclick'=>'changeDrug('.$sequenceNo.',"'.ucfirst($data->drugDetail->Drug).'","'.$data->drugDetail->DrugID.'|")'));?>
					</td>
						<td  width=10% style="padding:5px 0 5px 10px;"><?php echo $FormularyStatus[$formularyCoverage];?></td>
						
						<td  width=18% style="padding:5px 0 5px 10px;"><?php echo $FormularyStatusDesc[$formularyCoverage];?></td>
						<td  width=10% style="padding:5px 0 5px 10px;"><?php echo $data->drugDetail->TherapeuticClass;?></td>
						</tr>
				<?php 	}?>
					</tr></table>
			<?php 	}
				?>
				<script>
				function changeDrug(sequenceno,drugName,drugId)
				{					
					$("#drugText_"+sequenceno).val(drugName);
					$("#drug_"+sequenceno).val(drugId);
					$("#formularylinkId_"+sequenceno).html("");

					getDrugType(sequenceno,drugId);
					
					
				}
				function closeFormulary()
				{
					$("#formularyData").html("");
				}

				function getDrugType(sequenceno,drugId)
				{
					var attrId="drugText_"+sequenceno;
					var doseId = attrId.replace("drugText_",'dosageform_');
					var routeId = attrId.replace("drugText_",'route_administration');

					
					$.ajax({

						  url: "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getDrugType", "admin" => false)); ?>"+"/"+drugId,
						  dataType: 'html',
						  beforeSend:function(){
						    // this is where we append a loading image
						    $('#busy-indicator').show('fast');
							}, 	
							type: "POST",  
						  		  
						  	success: function(data){
						  		finData=data.split("~~~");	
						  		var dosageFrm=<?php echo json_encode(Configure::read('selected_dosageform'));?>;
								var routeFrm=<?php echo json_encode(Configure::read('selected_route'));?>;												  		
						  		var drugType='<br/><strong>Drug Type :</strong>'+finData[0];
						  		
	                               $("#drugType_"+sequenceno).html(drugType);

	                               if(routeFrm[finData[2]]!='')
									   $("#"+routeId).val(routeFrm[finData[2]]);
																												
									if(dosageFrm[finData[1]]!='')
										$("#"+doseId).val(dosageFrm[finData[1]]);
									
									$('#busy-indicator').hide('slow');
						  			
						  	}				  			
						});
				}
				</script>