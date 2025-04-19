<div class="inner_title">
	<h3>
		<?php echo __('View Notes'); ?>
	</h3>
</div>
<table border="0" class="table_format">
	<tr>
		<td class="row_format" width="30%"><strong> <?php echo __('S/B Consultant',true); ?></strong>
		</td>
		<td class="row_format">
			<?php  echo ucfirst($registrar[0]['fullname']); ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('S/B Registrar',true); ?></strong>
		</td>
		<td class="row_format">
			<?php echo ucfirst($consultant[0]['fullname']); ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Date',true); ?></strong>
		</td>
		<td class="row_format">
			<?php $splitDate = explode(' ',$note['Note']['note_date']);
		   echo $this->DateFormat->formatDate2Local($note['Note']['note_date'],Configure::read('date_format'),true);?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Note Type',true); ?></strong>
		</td>
		<td class="row_format">
			<?php echo ucfirst($note['Note']['note_type']); ?>
		</td>
	</tr>
	<?php  //debug($note);
 		 if(isset($note['Note']['note_type'])){
		 	 	 $note_type  = $note['Note']['note_type'] ;
		 	 	 if($note_type=='general'){
		 	 	 	?>
	<tr>
		<td class="row_format" valign="top"><strong> <?php echo __('SOAP Note'); ?></strong>
		</td>
		<?php if(!empty($note['Note']['temp']) || !empty($note['Note']['pr']) || !empty($note['Note']['bp']) || !empty($note['Note']['spo2']) || !empty($note['Note']['rr'])){ ?>
		<td class="row_format">Vitals:
			<table width="100%" border="0" cellspacing="1" cellpadding="3"
				class="tabularForm" align="center">
				<tr>

					<td valign="top" width="15%">Temp in &#8457;</td>
					<td valign="top" width="15%">P.R /Min</td>
					<td valign="top" width="15%">R.R /Min</td>
					<td valign="top" width="15%">BP in mm/hg</td>
					<td valign="top" width="20%">SPO<sub>2</sub>% in Room Air
					</td>
				</tr>
				<td valign="top" width="15%">
					<?php echo ucfirst($note['Note']['temp']); ?>
				</td>
				<td valign="top" width="15%">
					<?php echo ucfirst($note['Note']['pr']); ?>
				</td>
				<td valign="top" width="15%">
					<?php echo ucfirst($note['Note']['rr']); ?>
				</td>
				<td valign="top" width="15%">
					<?php echo ucfirst($note['Note']['bp']); ?>
				</td>
				<td valign="top" width="20%">
					<?php echo ucfirst($note['Note']['spo2']); ?>
				</td>
				<tr>
				</tr>
			</table>
		</td><?php } ?>
	</tr>
	<tr>
		<td class="row_format" valign="top"></td>
		<td>SOAP
			<table width="100%" border="0" cellspacing="1" cellpadding="3"
				class="tabularForm" align="center">
				<tr>
					<td valign="top" width="10%">CC:</td>
					<td valign="top" width="70%">
						<?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$note['Note']['cc']); ?>
					</td>
				</tr>
				<tr>
					<td valign="top" width="10%">Subjective:</td>
					<td valign="top" width="70%">
						<?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$note['Note']['subject']); ?>
					</td>
				</tr>
				<tr>
					<td valign="top" width="10%">Objective:</td>
					<td valign="top" width="70%">
						<?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$note['Note']['object']); ?>
					</td>
				</tr>
				<tr>
					<td valign="top" width="10%">Assessment:</td>
					<td valign="top" width="70%">
						<?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$note['Note']['assis']); ?>
					</td>
				</tr>
				<?php
				if(!empty($note['Note']['icd']))
				{
				
				?>
				<tr>
					<td valign="top" width="10%"></td>
					<td valign="top" width="70%">
						<?php for($i=0;$i<count($icddesc)-1;$i++){ ?>
						<table>
							<tr>
								<td>
									<?php echo str_ireplace($search,'<font color="green">' .ucfirst($search) .'</font>',$icddesc[$i]); ?>
								</td>
								
							</tr>
						</table> <?php	} ?>
					</td>
				</tr>

				<?php } ?>
				<tr>
					<td valign="top" width="10%">Plan:</td>
					<td valign="top" width="70%">
						<?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$note['Note']['plan']); ?>
					</td>
				</tr>
				<?php 	if(!empty($note['Note']['visitid']) || !empty($note['Note']['bmi']) || !empty($note['Note']['final']))
				{ ?>
				<tr>
					<td valign="top" width="10%">Finalization:</td>
					<td valign="top" width="70%">
						<table>
							<tr>
								<td width="10%">Visit Type:</td>
							</tr>
							<?php	foreach($visittyp as $visit){ ?>
							<tr>
							<td></td>
								<td>
									<?php echo ucfirst($visit['Finalization']['description']); ?>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<td>Weight Screening:</td>
							</tr>
							<tr>
								<td></td>
								<td>Height:<?php echo $note['Note']['ht'] ?>cm &nbsp;&nbsp;&nbsp;&nbsp; Weight:<?php echo $note['Note']['wt'] ?>kg&nbsp;&nbsp;&nbsp;&nbsp; BMI:<?php echo $note['Note']['bmi'] ?>%(tile) </td>
							</tr>
							<?php $notescr = explode('|',$note['Note']['final']); 

							foreach($notescr as $scr){?>
							<tr>
								<td></td>
								<td><?php echo $scr;?></td>
							</tr>
							<?php } ?>
						</table>
					</td>
				</tr>
				<?php	} ?>
			</table>
		</td>
	</tr>
	<?php if(!empty($note['Note']['investigation'])){ ?>
	<tr>
		<td class="row_format"><strong> <?php echo __('Investigation'); ?></strong>
		</td>
		<td class="row_format">
			<?php echo str_ireplace($search,'<font color="green">' .$search .'</font>',$note['Note']['investigation']); ?>
		</td>
	</tr>
	<?php } 

if(!empty($medicines[0][PharmacyItem][name])){?>
	<tr>
		<td class="row_format"><strong> <?php echo __('Treatment Adviced',true); ?></strong>
		</td>
	</tr>
	<tr>
		<td width="100%" valign="top" align="left" colspan="6">
			<table width="100%" border="0" cellspacing="1" cellpadding="0" id='DrugGroup' class="tabularForm">
				<tr>
					<td width="27%" height="20" align="left" valign="top"><b>Name
							of Medication </b></td>
					<td width="18%" height="20" align="left" valign="top">Unit</td>
					<td width="10%" align="left" valign="top"><b>Start Date</b></td>
					<td width="10%" align="left" valign="top"><b>End date</b></td>
					<td width="7%" align="left" valign="top"><b>Routes</b></td>
					<td width="8%" align="left" valign="top"><b>Dose</b></td>
					<td width="9%" align="left" valign="top"><b>Quantity</b></td>
					<td width="9%" align="left" valign="top"><b>No. Of Days</b></td>
					<td width="20%" valign="top" colspan="4" align="center"><b>Timings</b></td>
				</tr>
				<?php  foreach($medicines as $drugs) {?>
				<tr>
					<td>
						<?php echo str_ireplace($search,'<font color="green">' .strtoupper($search) .'</font>',$drugs['PharmacyItem']['name']); ?>
					</td>
					<td>
						<?php echo $drugs['PharmacyItem']['pack']; ?>
					</td>
					<td>
						<?php echo $drugs['SuggestedDrug']['start_date']; ?>
					</td>
					<td>
						<?php echo $drugs['SuggestedDrug']['end_date']; ?>
					</td>
					<td>
						<?php echo $drugs['SuggestedDrug']['route']; ?>
					</td>
					<td>
						<?php echo $drugs['SuggestedDrug']['frequency']; ?>
					</td>
					<td>
						<?php echo $drugs['SuggestedDrug']['quantity']; ?>
					</td>
					<td>
						<?php echo $drugs['SuggestedDrug']['dose']; ?>
					</td>
					<?php if(!empty($drugs['SuggestedDrug']['first'])){  ?>
					<td>
						<?php 
						if($drugs['SuggestedDrug']['first'] < 12){
							echo $drugs['SuggestedDrug']['first'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['first'] == 12)
								echo $drugs['SuggestedDrug']['first'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['first']-12 .' PM' ; 
						}
					}else {?>
					</td>
					<td>--</td>
					<?php } ?>
					<?php if(!empty($drugs['SuggestedDrug']['second'])){ 
							 
					?>
					<td>
						<?php 
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
					<td>--</td>
					<?php } ?>
					<?php if(!empty($drugs['SuggestedDrug']['third'])){ ?>
					<td>
						<?php 
						if($drugs['SuggestedDrug']['third'] < 12){
							echo $drugs['SuggestedDrug']['third'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['third'] == 12)
								echo $drugs['SuggestedDrug']['third'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['third']-12 .' PM' ; 
						}
					}else {?>
					</td>
					<td>--</td>
					<?php } ?>
					<?php if(!empty($drugs['SuggestedDrug']['forth'])){ 
							 	
					?>
					<td>
						<?php 
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
					<td>--</td>
					<?php } ?>
				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
	<?php } ?>
	<?php 
		 	 	 	
		 	 	 }else if($note_type=='pre-operative'){
		 	 	 	?>
	<tr>
		<td class="row_format"><strong> <?php echo __('Pre Operative Note',true); ?></strong>
		</td>
		<td class="row_format">
			<?php echo $note['Note']['pre_opt']?>
		</td>
	</tr>
	<?php 
		 	 	 }else if($note_type=='post-operative'){
		 	 	 	?>
	<tr>
		<td class="row_format"><strong> <?php echo __('Post Operative Note',true); ?></strong>
		</td>
		<td class="row_format">
			<?php echo $note['Note']['post_opt']?>
		</td>
	</tr>
	<?php 
		 	 	 }else if($note_type=='OT'){
		 	 	 	?>
	<tr>
		<td class="row_format"><strong> <?php echo __('Description of Surgery'); ?></strong>
		</td>
		<td class="row_format">
			<?php echo $note['Note']['surgery']?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Implants',true); ?></strong>
		</td>
		<td class="row_format">
			<?php echo $note['Note']['implants']?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Event Note'); ?></strong>
		</td>
		<td class="row_format">
			<?php echo $note['Note']['event_note']?>
		</td>
	</tr>

	<?php 
		 	 	 }else {
		 	 		?>
	<tr>
		<td class="row_format"><strong> <?php echo __('Note',true); ?></strong>
		</td>
		<td class="row_format">
			<?php echo $note['Note']['note']?>
		</td>
	</tr>
	<?php 
 		 		}
		 	 }
 	?>


	<tr>
		<td class="row_format" colspan="2">
			<?php 
       echo $this->Js->link(__('Cancel'), array('controller'=>'patients','action' => 'patient_notes', $patientid), array('escape' => false,'update'=>'#list_content','method'=>'post','class'=>'blueBtn'));
         
	   if($note['Note']['note_type']=='general'){
       		echo $this->Html->link(__('Print'),
								     '#',
								     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'notes','action'=>'print_prescription',$note['Note']['id'],$patientid))."', '_blank',
								           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=800,left=400,top=400');  return false;"));
   								
		}
       echo $this->Js->writeBuffer(); 	
  ?>
		</td>
	</tr>

</table>
