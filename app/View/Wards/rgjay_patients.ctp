 <style>
img{
	float:none;
}
</style>

<?php echo $this->Html->script(array('inline_msg','jquery.fancybox','jquery.blockUI'));
 echo $this->Html->css(array('jquery.fancybox')); 
 
 ?>
 <style>
 .fancybox-inner{
		min-height: 350px !important;
	}
 </style>
<div class="inner_title">
	<h3 style="float: left;">Room Occupancy - <b><?php echo $detailData[0]['TariffStandard']['name'];?></b></h3>
	<div style="float: right;">
		<table width="" cellpadding="0" cellspacing="0" border="0"
			class="tdLabel2" style="color: #b9c8ca;">
			<tr>
				<td width="22" height="30"><?php echo $this->Html->image('icons/free-icon.png');?>
				</td>
				<td width="30">Free</td>
				<td width="22" height="30"><?php echo $this->Html->image('icons/management-icon.png');?>
				</td>
				<td width="80">Maintenance</td>
				<td width="22"><?php echo $this->Html->image('icons/locked-icon.png');?>
				</td>
				<td width="50">Waiting</td>
				<!-- <td width="22"><?php echo $this->Html->image('icons/notes-icon.png');?>
				</td> -->
				<td width="40">Notes</td>
				<td width="22"><?php echo $this->Html->image('icons/transfer-icon.png');?>
				</td>
				<td width="100">Transfer Patient</td>
				<td width="22"><?php echo $this->Html->image('icons/male-icon.png');?>
				</td>
				<td width="30">Male</td>
				<td width="19"><?php echo $this->Html->image('icons/female-icon.png');?>
				</td>
				<td width="40">Female</td>
			<!-- <td width="22"><?php echo $this->Html->image('icons/patient-data-icon.png');?>
				</td> 
				<td width="120">Patient Clinical Data</td>--> 
				
				<td><?php echo $this->Html->link('Back',array('action'=>'ward_occupancy'),array('escape'=>true,'class'=>'blueBtn','style'=>'float:right; height: 18px !important'));?></td>
			     <td style="padding-left: 8px"><?php echo $this->Html->link('Print','#',array('id'=>'printID','escape'=>true,'class'=>'blueBtn','style'=>'float:right; height: 18px!important'));?></td>
			</tr>
		</table>
	</div>
	<div class="clr"></div>
</div>
<div class="clr ht5"></div>

<?php echo $this->Form->create('',array('type'=>'GET'));?>
<table>
	<tr>
		<td width="10%">Select Ward</td>
		<td width="20%"><?php 
		echo $this->Form->input('ward',array('id'=>'ward_id','empty'=>'Select Ward','options'=>array('Select All'=>'Select All',$wardData),'value'=>$this->params->query['ward'],'class'=>'validate[required,custom[mandatory-select]]','div'=>false,'label'=>false,'class'=>'textBoxExpnd'));
		?>
		</td>
		<td width="20%">
			<?php 
					echo $this->Form->input('patient_name',array('class'=>'patient-name textBoxExpnd','id'=>"patient-name",'label'=>false,
							'autofocus'=>'autofocus','autocomplete'=>'off','div'=>false,'value'=>$this->params->query['patient_name']));
			?>
		</td>
		<td width="10%"><?php 
			if($this->params->query['is_discharge'] == 1){
				$checked = true;
			}else{
				$checked = false;
			}
			echo $this->Form->input('is_discharge',array('type'=>'checkbox','class'=>'isDischarge','id'=>"isDischarge",
							'autocomplete'=>'off','label'=>false,'div'=>false,'checked'=>$checked));
					echo "Show Discharged "; ?>
		</td>
		<td><?php echo $this->Form->input('Show Results',array('id'=>'submit','type'=>'Submit','class'=>'blueBtn','div'=>false,'label'=>false,));?>
		</td>
	</tr>
	<?php 
	 if($this->params->query['room']){?>
	<tr class="roomSel">
		<td>Select Bed</td>
		<td><?php echo $this->Form->input('room',array('class'=>'roomSel','empty'=>'Select Room','options'=>$rooms,
								'div'=>false,'label'=>false,'value'=>$this->params->query['room'],'disabled'=>'disabled'));?></td>
	</tr>
	<?php 	}?>
	<tr class="roomRow" style="display: none;">
		<td>Select Bed</td>
		<td><?php 
		foreach($wardData as $wkey=>$ward){
						echo $this->Form->input('room',array('id'=>'room_'.$wkey,'class'=>'room','empty'=>'Select Room','options'=>$roomData[$ward],
								'div'=>false,'label'=>false,'style'=>'display:none','disabled'=>'disabled'));
				}
				?>
		</td>
	</tr>
	<tr>
		
	</tr>
</table>
<?php echo $this->Form->end();?>

<?php if(!empty($detailData)){?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">
	<tr>
		<!-- <th width="5%" align="center" valign="top"
			style="text-align: center; min-width: 100px;">Floor</th> -->
		<th width="5%" align="center" valign="top"
			style="text-align: center;">Bed</th>
		<th width="15%" align="center" valign="top"
			style="text-align: center; min-width: 150px;">Patient Name</th>
		<th width="5%" align="center" valign="top" style="text-align: center;">Age</th>		 
		<th width="10%" align="center" valign="top"
			style="text-align: center;">Primary Care Provider.</th>
		<th width="15%" align="center" valign="top"
			style="text-align: center;">Primary Diagnosis</th>
	    <th width="15%" align="center" valign="top"
			style="text-align: center;">Actual Diagnosis</th>
 		<th width="10%" align="center" valign="top"
			style="text-align: center;">Package For Billing</th>
		<th width="5%" align="center" valign="top"
		    style="text-align: center;">Charges</th>
		<!-- <th width="2%" align="center" valign="top"
		style="text-align: center;">Document Print</th> -->
		 
	</tr>
	<?php 

	$i=0;
	$currentWard =0;
	//count no of bed per ward
 
	foreach($detailData as $wardKey =>$wardVal){
                     		$wardArr[$wardVal['Ward']['name']][] = $wardVal['Ward']['id'];
                     	}
                     	$totalBed = count($detailData);
                     	$booked = 0;
                     	$male =0;
                     	$female=0;
                     	$waiting=0;
                     	$maintenance =0;
                     	foreach($detailData as $wardKey =>$wardVal){

                     	?>
	<tr>
		<?php	if($i==0){ ?>
		<!--<td rowspan="<?php e//cho count($wardArr[$wardVal['Ward']['name']]);?>"
			 align="left" valign="top"
			style="text-align: center; padding-top: 12px;"><?php //echo $wardVal['Ward']['name']?>
		</td> -->
		<?php
		$i++;
                     	}else{
                      	  			$i++;
                      	  		}
                      	  		if($i==count($wardArr[$wardVal['Ward']['name']])){
                      	  			$i = 0;
                      	 	    }
                      	 	    ?>
		<td align="center" valign="middle" style="text-align: center;"><?php echo $wardVal['Room']['bed_prefix'].$wardVal['Bed']['bedno'] ;?>
		</td>
		<td align="left" valign="middle" style="text-align: center;">
			<?php echo ucwords(strtolower($wardVal['Patient']['lookup_name']))."<br/>"."(".$wardVal['Patient']['admission_id'].")";?>
		</td>
		<td valign="middle" style="text-align: center;"><?php echo $wardVal['Patient']['age']?>
		</td>
		<!-- <td valign="middle" style="text-align: center;"><?php //echo $wardVal['Patient']['patient_id']?>
		</td>  -->
		<td valign="middle" style="text-align: center;"><?php echo $wardVal['DoctorProfile']['doctor_name']?>
		</td>
		
		<td valign="middle" style="text-align: center;">
		<?php echo $this->Form->input('final_diagnosis',array('label'=>false,'div'=>false,'class'=>" textBoxExpnd finalDiag",'id'=>'finalDiagnosis_'.$wardVal['Patient']['id']."_".$wardVal['Diagnosis']['id'],'type'=>'text','value'=>$wardVal['Diagnosis']['final_diagnosis']));
		?>
		</td>
		<td valign="middle" style="text-align: center;">
		<?php echo $this->Form->input('actual_diagnosis',array('label'=>false,'div'=>false,'class'=>" textBoxExpnd billingDiag",'id'=>'billingDiagnosis_'.$wardVal['Patient']['id']."_".$wardVal['Diagnosis']['id'],'type'=>'text','value'=>$wardVal['Diagnosis']['actual_diagnosis']));
		?>
		</td>
		
		
		
	<!-- 	<td valign="middle" style="text-align: center;"><?php echo $wardVal['NoteDiagnosis']['diagnoses_name']?></td> -->
		
		<td valign="middle" style="text-align: center;">
			
			<?php 	
			$tariffListName = '' ;
			$serviceCost = '';
			$tariffListId = '' ;
			if($wardVal['TariffList']['name']){
				$tariffListId = $wardVal['TariffList']['id'] ;
				$tariffListName = $wardVal['TariffList']['name'] ;
				$serviceCost = $wardVal['ServiceBill']['amount'] ;
			}
			echo $this->Form->input('service_package',array('value'=>$tariffListName,'label'=>false,'div'=>false,'class'=>"services textBoxExpnd",'id'=>'services-'.$wardVal['Patient']['id']."-".$wardVal['TariffStandard']['id'],'type'=>'text','tariffListId'=>$tariffListId));
			?>
			<?php if($tariffListId) { ?>
			<span><?php echo $this->Html->image('icons/view-icon.png',array('class'=>'viewPrePostInv','id'=>$tariffListId));?></span>
		<?php } ?>
		</td>
		<td>
		<?php  
			echo $this->Form->input('service_charges',array('readonly'=>'readonly','value'=>$serviceCost,'label'=>false,'div'=>false,'class'=>"service-charge textBoxExpnd",'id'=>'services_charges-'.$wardVal['Patient']['id'],'type'=>'text'));
			//echo $this->Form->img('/icons/save-small.jpg',array('title'=>'Save package'));
		?></td>
		<!-- <td>
		<?php 
		   echo $this->Html->link($this->Html->image('icons/print.png'), array( 'controller'=>'PatientDocuments','action' => 'rgjay_print_document', $wardVal['TariffList']['id']), array('escape' => false));
		   ?>
		</td> -->
	</tr>

	<?php  }?>

</table>
<div class="clr ht5"></div>
<table width="100%" cellpadding="5" cellspacing="0" border="0"
	align="center">
	<tr>
		<td align="center"><?php 
		if(empty($detailData)){
			                   			echo "No Record Found"    ;
			                   		}
			                   		?>
		</td>
	</tr>
</table>
<table width="100%" cellpadding="5" cellspacing="0" border="0"
	style="background-color: #c9c9c9;">
	<tr>
		<td width="" class="tdLabel2"><strong>Quick Info &raquo;</strong></td>
		<td width="" class="tdLabel2"><?php  echo $totalBed; ?> Total</td>
		<td width="" class="tdLabel2"><?php 
		echo $booked;
		?> Occupied<?php echo " (".round(($booked*100)/$totalBed).'%)'?></td>
		<td width="" class="tdLabel2"><strong></strong> <?php 
		echo ($totalBed-$booked)-$waiting-$maintenance;
		?> Free</td>
		<td width="" class="tdLabel2"><strong></strong> <?php echo $maintenance; ?>
			Maintenance</td>
		<td width="" class="tdLabel2"><strong></strong> <?php echo $waiting; ?>
			Waiting</td>

		<td width="" class="tdLabel2"><strong></strong> <?php echo $male;?>
			Male</td>
		<td width="" class="tdLabel2"><strong></strong> <?php echo $female;?>
			Female</td>
		<td>&nbsp;</td>
	</tr>
</table>
<div class="clr">&nbsp;</div>
<!--<div class="btns">
                              <input name="" type="button" value="Save" class="blueBtn" tabindex="33"/>
                              <input name="" type="button" value="Cancel" class="grayBtn" tabindex="33"/>
                  </div>-->
<div class="clr"></div>
<!-- billing activity form end here -->
<p class="ht5"></p>
<?php }?>

<script> 
	$(document).ready(function(){

		$("#patient-name").autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'IPD',"admin" => false,"plugin"=>false)); ?>",
				select: function(event,ui){	
					//$( "#patientId" ).val(ui.item.id);			
			},
			 messages: {
		         noResults: '',
		         results: function() {},
		   },
			
		});
		//var tariff_standard_id  = "<?php echo $this->params->query['tariff_standard_id'];?>" ; 
		$(".services").autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "billings", "action" => "getConsultantServices",$rgjayPackage,'?'=>array('tariff_standard_id'=>$this->params->query['tariff_standard_id']),"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				 var selectedID = this.id ;
				 var splittedVar  = selectedID.split("-"); 
			 	 var tariff_standard_id  = splittedVar[2] ;
				 var charges = ui.item.charges;
  				 $('#services_charges-'+splittedVar[1]).val(charges); 
  				 if(charges == ''){
  					inlineMsg('services_charges-'+splittedVar[1],"Please update charges in master for selected package",10);
  	  			 }				
				 $.ajax({
			         	beforeSend : function() {
			         		$("#busy-indicator").show();
			           	},
			         data:"tariff_list_id="+ui.item.id+"&tariff_standard_id="+tariff_standard_id+"&amount="+charges,
			         type: 'POST',
			         url: "<?php echo $this->Html->url(array("controller" => "wards", "action" => "saveServicePackage",$rgjayPackage,"admin" => false,"plugin"=>false)); ?>/"+splittedVar[1],
			         dataType: 'html',
			         success: function(data){				         
				         if(charges !=''){
				        	 $.ajax({
						         	beforeSend : function() {
						         		$("#busy-indicator").show();
						           	},
						         type: 'POST',
						         url: "<?php echo $this->Html->url(array("controller" => "corporates", "action" => "getRemark","admin" => false,"plugin"=>false)); ?>/"+splittedVar[1]+"?remark="+charges+"&source=rgjay",
						         dataType: 'html',
						         success: function(data){						          
						        	 inlineMsg('services_charges-'+splittedVar[1],"Package and charges added",10);
						         },
						 	});
				         }
				         $("#busy-indicator").hide();
			         },
			 	});
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});

		$(".finalDiag").blur(function () {   
			var patientId = $(this).attr('id') ;
			splittedId = patientId.split("_"); 
			patient_id=splittedId[1]
			newId = splittedId[2];
			if(newId=='')
				newId='null';
			var val = $(this).val();
			$.ajax({
				url : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getDiagnosis", "admin" => false));?>"+"/"+patient_id+"/"+newId,
				data:"diagnosis="+val,
				
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
				}
		});
        
    });

	 $('#printID').click(function(){
				var openWin = window.open("<?php echo $this->Html->url(array('action'=>'ward_management','print','?'=>$this->params->query)); ?>", '_blank',
			           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
			  });

		 /*$('.service-charge').blur(function(){
			  var selectedIDNext = this.id ;
			 var splittedVarNext  = selectedIDNext.split("-"); 
			 var chargesNext = this.value;
				 
			  $.ajax({
		         	beforeSend : function() {
		         		$("#busy-indicator").show();
		           	},
		         type: 'POST',
		         url: "<?php //echo $this->Html->url(array("controller" => "corporates", "action" => "getRemark","admin" => false,"plugin"=>false)); ?>/"+splittedVarNext[1]+"?remark="+chargesNext,
		         dataType: 'html',
		         success: function(data){						          
		        	 inlineMsg('services_charges-'+splittedVarNext[1],"Charges updated",10);
		        	 $("#busy-indicator").hide();
		         },
		 	});
		 });*/
	}); 
	$(".billingDiag").blur(function () {   
		var patientId = $(this).attr('id') ;
		splittedId = patientId.split("_"); 
		patient_id=splittedId[1]
		newId = splittedId[2];
		if(newId=='')
			newId='null';
		var val = $(this).val();
		$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "saveBillingDiagnosis", "admin" => false));?>"+"/"+patient_id+"/"+newId,
			data:"billing_diagnosis="+val,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success: function(data){
				$('#busy-indicator').hide();
			}
	});
    
}); 

	$(document).on('click','.viewPrePostInv',function(){
		var id = $(this).attr('id');
		showInvestigations(id);
	});
	function showInvestigations(id){
	       		
   		$.fancybox({
   		'width' : '50%',
   		'height' : '20%',
   		'autoScale': true,
   		'transitionIn': 'fade',
   		'transitionOut': 'fade',
   		'type': 'iframe',
   		'href': "<?php echo $this->Html->url(array("controller" => "Wards", "action" => "showInvestigations")); ?>"+'/'+id,
   		
   		});
   		
	}
</script>
