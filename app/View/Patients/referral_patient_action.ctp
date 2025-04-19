<div class="inner_title">
<h3><?php echo __('Patient referral-Prepare letter', true); ?></h3>
<span>
<?php
//echo $this->Html->link(__('View Preference Card', true),array('action' => 'view_preference',$patient_id,$getData['Preferencecard']['patient_id']), array('escape' => false,'class'=>'blueBtn'));
 //echo $this->Html->link(__('Add Preference Card', true),array('action' => 'add',$patient_id), array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Back'), array('controller'=>'patients','action' => 'referral',$patient_id), array('escape' => false,'class'=>"blueBtn"));
 ?>
</span>
</div>
<!--  <h3 style="display: &amp;amp;" id="subjective-link">
		<a href="#">Patient referral-Prepare letter</a>
	</h3>-->
	<div class="section" id="subjective">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			class="formFull formFullBorder">
			<tr>
				<td width="27%" align="left" valign="top">Template:
					<div align="center" id='temp-busy-indicator-subjective'
						style="display: none;">
						&nbsp;
						<?php echo $this->Html->image('indicator.gif', array()); ?>
					</div>
					<div id="templateArea-subjective"></div>
				</td>
				<td width="70%" align="left" valign="top">

					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr class="patient_info"><td width="20">&nbsp;</td>
 <td valign="top" colspan="4"><?php echo $this->element('patient_information');?></td>
</tr>
					<tr>
							<td width="20">&nbsp;<?php echo ('')?></td>
							<td valign="top" colspan="4"><?php echo $this->Form->input('subject', array('type'=>'text','label'=>false,'id' => 'subjective_desc'  ,'style'=>'width:90%','value'=>'Hello Steve Buckner')); ?><br />
								
							</td>


					
						<tr>
							<td width="20">&nbsp;</td>
							<td valign="top" colspan="4"><?php echo $this->Form->textarea('Introduction', array('id' => 'subjective_desc'  ,'label'=>true,'rows'=>'4','style'=>'width:90%','value'=>'I wish to refer patient of mine, to you for an appointment. I have included information pertaining to this patient below to better assist in continuiy of care.')); ?><br />
								
							</td>


						</tr>
						</table><table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
<tr class="row_title"><td><strong><?php echo ('Vital')?></strong></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr class="">
							<td width="20"><?php echo ('Height:')?></td>
							<td width="20"><?php echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?>
							</td>
							<td width="20"><?php echo ('Weight:')?></td>
							<td width="20"><?php echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?>
							</td>
							<td width="20"><?php echo ('B.M.I.:')?></td>
							<td width="20"><?php echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?>
							</td>
							<td width="20"><?php echo ('Blood Pressure:')?></td>
							<td width="20"><?php echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?>
							</td>
							<td width="20"><?php echo ('Temp:')?></td>
							<td width="20"><?php echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?>
							</td>


						</tr>
					</table>
					
					<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
						<tr class="row_title"> <td width="50"><strong><?php echo ('Diagnoses')?></strong></td><td></td>
							<td width="25"><strong><?php echo ('Start')?></strong></td>
							<td width="25"><strong><?php echo ('Stop')?></strong></td>
						</tr>
						<tr class="">
							<td width="20"><?php echo ('360.0')?></td>
							<td width="20"><?php echo ('Classical migraine')?><?php //echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?></td>
							
							<td width="20"><?php echo ('22/12/2013')?><?php //echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?></td>
							
							<td width="20"><?php echo ('22/12/2013')?><?php //echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?></td>
						</tr>
					</table>
					
					<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
						<tr class="row_title"> <td width="50"><strong><?php echo ('Medication')?></strong></td><td></td>
						<td width="20"><?php echo ('')?></td>
						
							<td width="25"><strong><?php echo ('Start')?></strong></td>
							<td width="25"><strong><?php echo ('Stop')?></strong></td>
							
						</tr>
						<tr class="">
							
							<td width="20"><?php echo ('Lipitor Oral tablet')?><?php //echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?></td>
							<td width="20"><?php echo ('')?></td>
							<td width="20"><?php echo ('')?></td>
							<td width="20"><?php echo ('22/12/2013')?><?php //echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?></td>
							
							<td width="20"><?php echo ('22/12/2013')?><?php //echo $this->Form->input('height', array('id' => 'subjective_desc' ,'label'=>false,)); ?></td>
						</tr>
					</table>
					<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
						<tr class="row_title"> <td width="50"><strong><?php echo ('Conclusion')?></strong></td><td></td>
							<td width="25"><strong><?php echo ('')?></strong></td>
							<td width="25"><strong><?php echo ('')?></strong></td>
						</tr>
						<tr class="">
							<td width="100%"><?php echo $this->Form->input('subject', array('type'=>'text','label'=>false,'id' => 'subjective_desc'  ,'style'=>'width:98%','value'=>"For follow  up, I would appericiate it if you could",)); ?></td>
							
						</tr>
					</table>
					<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
						<tr > 
							<td width="100%" ><?php echo $this->Form->input('subject', array('type'=>'text','label'=>false,'id' => 'subjective_desc'  ,'style'=>'width:20%; float:right','value'=>"Sincerely",)); ?></td>
						</tr>
						<tr class="">
							<td width="100%" ><?php echo $this->Form->input('subject', array('type'=>'text','label'=>false,'id' => 'subjective_desc'  ,'style'=>'width:20%; float:right','value'=>"XYZ",)); ?></td>
							
						</tr>
						
					</table>
					<table width="100%" class="row_format" border="0" cellspacing="0" cellpadding="0">
						<tr > 
						</tr>
						<tr class="">
							
						</tr>
						
					</table>
					
					<div class="inner_title">

<span>
<?php
//echo $this->Html->link(__('View Preference Card', true),array('action' => 'view_preference',$patient_id,$getData['Preferencecard']['patient_id']), array('escape' => false,'class'=>'blueBtn'));
 //echo $this->Html->link(__('Add Preference Card', true),array('action' => 'add',$patient_id), array('escape' => false,'class'=>'blueBtn'));
echo $this->Html->link(__('Change to simple letter'), array('controller'=>'patients','action' => 'referral',$patient_id), array('escape' => false,'class'=>"blueBtn"));
 //echo $this->Html->link(__('Preview'), array('onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'patients','action'=>'referral_preview',$patient_id))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700'); "));
 echo $this->Html->link(__('Preview'),'#',array('escape' => false,'class'=>"blueBtn",'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'referral_preview',$patient_id))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
 ?>
</span>
</div>
				</td>
			</tr>
		</table>
	</div>