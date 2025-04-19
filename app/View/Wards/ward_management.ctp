<style>
img{
	float:none;
}
</style>

<?php echo $this->Html->script(array('jquery.fancybox','jquery.blockUI'));
 echo $this->Html->css(array('jquery.fancybox'));  ?>
 <style>
 .fancybox-inner{
		min-height: 350px !important;
	}
 </style>
 
<div class="inner_title">
	<h3 style="float: left;">Room Occupancy</h3>
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
				<?php if($this->params->query['type']!='dashboard'){?>
				<td><?php echo $this->Html->link('Back',array('action'=>'ward_occupancy'),array('escape'=>true,'class'=>'blueBtn','style'=>'float:right; height: 18px !important'));?></td>
			     <td style="padding-left: 8px"><?php echo $this->Html->link('Print','javascript:void();',array('id'=>'printID','escape'=>true,'class'=>'blueBtn','style'=>'float:right; height: 18px!important'));?></td>
			     <?php }?>
			</tr>
		</table>
	</div>
	<div class="clr"></div>
</div>
<div class="clr ht5"></div>

<?php echo $this->Form->create('',array('type'=>'GET'));?>
<?php if($this->params->query['type']!='dashboard'){?>
<table>
	<tr>
		<td>Select Ward</td>
		<td><?php 
		echo $this->Form->input('ward',array('id'=>'ward_id','empty'=>'Select Ward','options'=>array('Select All'=>'Select All',$wardData),'value'=>$this->params->query['ward'],'class'=>'validate[required,custom[mandatory-select]]','div'=>false,'label'=>false));
		?>
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
		<td><?php echo $this->Form->input('Show Results',array('id'=>'submit','type'=>'Submit','class'=>'blueBtn','div'=>false,'label'=>false,));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<?php }?>
<?php if(!empty($detailData)){?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">
	<tr>
		<th width="10%" align="center" valign="top"
			style="text-align: center; min-width: 100px;">Floor</th>
		<th width="5%" align="center" valign="top"
			style="text-align: center;">Bed</th>
		<th width="15%" align="center" valign="top"
			style="text-align: center; min-width: 150px;">Patient Name</th>
		<th width="5%" align="center" valign="top" style="text-align: center;">Age</th>
		<th width="10%" align="center" valign="top"
			style="text-align: center;">Patient ID</th>
		<th width="15%" align="center" valign="top"
			style="text-align: center;">Reg. ID.</th>
		<th width="10%" align="center" valign="top"
			style="text-align: center;">Primary Care Provider.</th>
		<th width="10%" align="center" valign="top"
			style="text-align: center;">Problem.</th>
		<th width="5%" align="center" valign="top" style="text-align: center;">Sponsor</th>
		<th width="15%" align="center" valign="top"
			style="text-align: center; min-width: 120px;">Options</th>

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
		<td rowspan="<?php echo count($wardArr[$wardVal['Ward']['name']]);?>"
			align="left" valign="top"
			style="text-align: center; padding-top: 12px;"><?php echo $wardVal['Ward']['name']?>
		</td>
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
		<td align="left" valign="middle" style="text-align: center;"><?php echo ucwords(strtolower($wardVal['Patient']['lookup_name']))?>
		</td>
		<td valign="middle" style="text-align: center;"><?php echo $wardVal['Patient']['age']?>
		</td>
		<td valign="middle" style="text-align: center;"><?php echo $wardVal['Patient']['patient_id']?>
		</td>
		<td valign="middle" style="text-align: center;"><?php echo $wardVal['Patient']['admission_id']?>
		</td>
		<td valign="middle" style="text-align: center;"><?php echo $wardVal['DoctorProfile']['doctor_name']?>
		</td>
		<td valign="middle" style="text-align: center;"><?php echo $wardVal['NoteDiagnosis']['diagnoses_name']?>
		</td>
		<td valign="middle" style="text-align: center;"><?php  
		/*if($wardVal['Patient']['credit_type_id']==1){
		 echo ucfirst($wardVal['Corporate']['name']) ;
		                          	}else if($wardVal['Patient']['credit_type_id']==2){
		                          		echo ucfirst($wardVal['InsuranceCompany']['name']);
		                          	}else if($wardVal['Patient']['patient_id']){
		                          		echo "Private";
		                          	}*/
		      
	                         echo $wardVal['TariffStandard']['name'];
	                         ?></td>
		<td valign="middle" style="text-align: center;"><?php
		if($wardVal['Patient']['patient_id']){
                          				//echo $this->Html->image('icons/locked-icon.png',array('title'=>'Locked'))."&nbsp;";
                          			}else{
                          			 //BOF waiting
                          			 $waitingFlag =false;
                            		/* if(is_array($wardVal['WardPatient'])){
                            		 foreach($wardVal['WardPatient'] as $wpKey =>$wpVal){
                            		 	 	if($wpVal['is_discharge']==1){
                            		 	 		 //check the patient discharge time.
		                            		 	 //if yes ,then it shud be in waiting state till 45 min from discharge time
			                             		 //calculate time diff
			                             		 $convertDate = strtotime($wpVal['out_date']);
			                             		 $currentTime = mktime();
			                             		 $minus = $currentTime - $convertDate ;
			                             		 $intoMin = round(($minus)/60) ;
		                            			 if($intoMin<=45 && $wardVal['Bed']['is_released']==0){
		                            			 	$waiting++;
		                            			 	$waitingFlag =true ;
		                            			 	echo $this->Html->image('icons/locked-icon.png',array('title'=>'Waiting'));
		                            			 }
                            		 	 	}
                            		 	 }
                            		}*/
                            		//EOF waiting
										$convertDate = strtotime($wpVal['out_date']);
										$currentTime = mktime();
										$minus = $currentTime - $convertDate ;
										$intoMin = round(($minus)/60) ;
										if($wardVal['Bed']['under_maintenance']==1){
                            				$maintenance++;
                            				echo $this->Html->image('icons/management-icon.png',array('title'=>'Under Maintenance'))."&nbsp;&nbsp;&nbsp;";
                            			}else if($wardVal['Bed']['is_released']==1 && $intoMin<=45){
                            				$waiting++;
                            				echo $this->Html->image('icons/locked-icon.png',array('title'=>'Waiting'));
                            			}else if(!$waitingFlag){
                          					echo $this->Html->image('icons/free-icon.png',array('title'=>'Free'))."&nbsp;&nbsp;&nbsp;";
                            			}
                          			}
                          			if($wardVal['Patient']['sex']=='male'){
                          				$male++;
                          				echo $this->Html->image('icons/male-icon.png',array('title'=>'Male'))."&nbsp;&nbsp;&nbsp;";
                     				}else if($wardVal['Patient']['sex']=='female'){
                     					$female++;
                     					echo $this->Html->image('icons/female-icon.png',array('title'=>'Female'))."&nbsp;&nbsp;&nbsp;";
                     				}

                     				?>&nbsp; <?php
                     				if($wardVal['Patient']['patient_id']){
                          				$booked++;
                          				//echo $this->Html->image('icons/notes-icon.png',array('title'=>'Add Note','id'=>"note-".$wardVal['Patient']['id'],'class'=>'add-note'))."&nbsp;&nbsp;&nbsp;";
                          				//echo $this->Html->link($this->Html->image('icons/patient-data-icon.png',array('title'=>'View Patient Details')),array('controller'=>'patients','action'=>'patient_information',$wardVal['Patient']['id']),array('escape'=>false))."&nbsp;&nbsp;&nbsp;";
                          				echo $this->Html->image('icons/transfer-icon.png',array('title'=>'Transfer Patient','id'=>$wardVal['Patient']['id'],'class'=>'transfer'))."&nbsp;&nbsp;&nbsp;";
                          			}
                          				
                          			echo
											$this->Html->link($this->Html->image('icons/free.png',array('title'=>'Vacant Bed','height'=>'20','weight'=>'20' )),
											array('controller'=>'wards','action'=>'vacantBed',$wardVal['Patient']['id'],$wardVal['Bed']['id']),array('escape'=>false)); 
                          			?>
		</td>
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
	jQuery("#WardNewWardManagementForm").validationEngine({
        validateNonVisibleFields: true,
        updatePromptsPosition:true,
    });
});
$('#ward_id').change(function(){
	$('.roomSel').hide();
	$('.room').hide();//for hiding the room select box
	$('.roomRow').hide();
	$('.room').attr('disabled',true);
	selectedWard=$(this).val();
	if(selectedWard){
		$('.roomRow').show();
		$('#room_'+selectedWard).attr('disabled',false);
		$('#room_'+selectedWard).show();
	}
	if(selectedWard=='Select All'){
		$('.roomRow').hide();
	}
});

jQuery(document).ready(function(){
	$('.transfer').click(function(){
	    var patient_id = $(this).attr('id') ;
		 
		$.fancybox({
            'width'    : '80%',
		    'height'   : '80%',
		    'autoScale': true,
		    'transitionIn': 'fade',
		    'transitionOut': 'fade',
		    'type': 'iframe',
		    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "patient_transfer")); ?>"+'/'+patient_id 
	    });
		
  });

  $('.add-note').click(function(){
	  var patient = $(this).attr('id') ;
	  var patient_id = patient.split("-");
	  
		$.fancybox({
            'width'    : '80%',
		    'height'   : '80%',
		    'autoScale': true,
		    'transitionIn': 'fade',
		    'transitionOut': 'fade',
		    'type': 'iframe',
		    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "patient_note")); ?>"+'/'+patient_id[1] 
	    });
  });

  $('#printID').click(function(){
	var openWin = window.open("<?php echo $this->Html->url(array('action'=>'ward_management','print','?'=>$this->params->query)); ?>", '_blank',
           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
  });
});


</script>
