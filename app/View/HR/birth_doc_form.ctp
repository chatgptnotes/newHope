<?php echo $this->Html->css(array('internal_style.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css' ));  
 echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js','ui.datetimepicker.3.js','default','jquery-1.9.1.js','jquery-ui-1.10.2.js','validationEngine-en.jquery.js'));?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
@media print {
	#printButton {
		display: none;
	}
}
.tdLabel{
	color: #000;
	font-size: 13px;
	padding-left: 15px !important;
	padding-right: 15px;
	padding-top: 5px !important;
	text-align: left;
	width: 50%;
}
</style>
</head>
<html moznomarginboxes mozdisallowselectionprint>
<body style="background: none; width: 1000px; margin: auto;">
	 <div align="right" id="printButton">
		<?php // echo $this->Html->link(__('Print',true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();')); ?>
	</div> 
	<?php echo $this->Form->create('birthForm',array('url'=>array('controller'=>'HR','action'=>'birthDocForm'),'name'=>'birthForm','type'=>'post','id'=>'birthForm','inputDefaults'=>array('div'=>false,'label'=>false,'error'=>false)));  ?>
	<?php echo $this->Form->hidden('BirthDocumentation.id',array('id'=>'id'));
			echo $this->Form->hidden('BirthDocumentation.patient_id',array('id'=>'patient_id','value'=>$patientDetail['Patient']['id']));
		?>
	<table width="100%" align="center" cellpadding="0" cellspacing="1" class=" ">
		<tr>
			<td></td>
			<td align="center">
				<h3 align="center">
					<?php echo __('BIRTH DOCUMENTATION FORM(BDF)' ); ?>
				</h3>
			</td>
			<td colspan="2"><div style="float: right">
					<?php echo  $this->Html->image('icons/lifespring.jpg',array('width'=>136,'height'=>72)) ; ?>
			</div></td>
		</tr>
		<tr>
			<td>Customer Name :</td>
			<td><?php echo $this->Form->input('BirthDocumentation.lookup_name', array('class' => 'textBoxExpnd','label'=>false,'readonly'=>'readonly','label'=>false ,'value'=>$patientDetail['Patient']['lookup_name']));  ?>
			</td>
		</tr>
		<tr>
			<td>Doctor(Who Conducted Delivery) :</td>
			<td><?php echo $this->Form->input('BirthDocumentation.name',array('class' =>'textBoxExpnd','label'=>false,'readonly'=>'readonly','label'=>false ,'value'=>$patientDetail[0]['name'])); ?>
			</td>
			<td>Date & Time Of Delivery :</td>
			<td><?php
			 	
					$datetime = $this->DateFormat->formatDate2Local($patientDetail['BirthDocumentation']['datetime_of_delivery'],Configure::read('date_format'),true);
					echo $this->Form->input('BirthDocumentation.datetime_of_delivery', array('class' =>'validate[required,custom[mandatory-date]]','id'=>'toDate','type'=>'text','label'=> false,'style'=>'float:left','div' => false, 'error' => false ,'value'=>$datetime));?>
			</td>
		</tr>
		<tr>
		<td><?php echo $this->Form->radio('BirthDocumentation.book_unbook',array('Booked(B)','Unbooked(UB)'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
		</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan ="2">
				<table align="left" width="100%" cellpadding="0" cellspacing="1" class="">
					
					<tr>
						<td><?php echo __('G');?></td>
						<td><?php echo $this->Form->checkbox("BirthDocumentation.before_delivery.0", array('legend'=>false,'label'=>false)); ?>
						</td>

						<td><?php echo __('P');?></td>
						<td><?php echo $this->Form->checkbox("BirthDocumentation.before_delivery.1", array('legend'=>false,'label'=>false)); ?>
						</td>

						<td><?php echo __('L');?></td>
						<td><?php echo $this->Form->checkbox("BirthDocumentation.before_delivery.2", array('legend'=>false,'label'=>false)); ?>
						</td>

						<td><?php echo __('A');?></td>
						<td><?php echo $this->Form->checkbox('BirthDocumentation.before_delivery.3', array('legend'=>false,'label'=>false)); ?>
						</td>

						<td><?php echo __('S');?></td>
						<td><?php echo $this->Form->checkbox('BirthDocumentation.before_delivery.4', array('legend'=>false,'label'=>false)); ?>
						</td>

						<td><?php echo __('D');?></td>
						<td><?php echo $this->Form->checkbox('BirthDocumentation.before_delivery.5', array('legend'=>false,'label'=>false)); ?>
						<span>(Before Delivery)</span>
						</td>
					</tr>
				</table>
			</td>
			<td>Fetal Weight At Birth(Kgs) </td>
			<td><?php echo $this->Form->input('BirthDocumentation.fetal_weight', array('class' =>'textBoxExpnd','type'=>'text','autocomplete'=>'off','div'=>false,'label'=>false)); ?>
			</td>
		</tr>
		</tr>
		<tr>
			<td>Gestation Age:</td>
			<td>
				<div>
					<?php echo __('Wks').$this->Form->checkbox('BirthDocumentation.gestation_age_wks', array('legend'=>false,'label'=>false)); ?>
					<?php echo __('Days').$this->Form->checkbox('BirthDocumentation.gesttaion_age_days', array('legend'=>false,'label'=>false,)); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td>APGAR:</td>
			<td>
				<div>
					<?php echo __('1min :' ).$this->Form->checkbox('BirthDocumentation.apgar_one_min', array('legend'=>false,'label'=>false,)); ?>
					<?php echo __('5min :').$this->Form->checkbox('BirthDocumentation.apgar_five_min', array('legend'=>false,'label'=>false,)); ?>
				</div>
			</td>
			<td>Please Detail Any NICU Admissions:</td>
			<td><?php echo $this->Form->input('BirthDocumentation.nicu_admission', array('class' => 'textBoxExpnd','type'=>'text','autocomplete'=>'off')); ?>
			</td>
		</tr>
		<tr>
			<td>AFI At Turm :</td>
			<td><?php echo $this->Form->input('BirthDocumentation.afi_at_turm',array('class' =>'textBoxExpnd','type'=>'text','autocomplete'=>'off')); ?>
			</td>
			<td>CPD AFI At Turm :</td>
			<td><?php echo $this->Form->radio('BirthDocumentation.cpd_afi_at_turm', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
		</tr>
	</table>
	<table width="100%" align="center" cellpadding="0" cellspacing="1"
		class="">
		<tr>
			<td style='font-weight: bold;'><h3>Caesarean Section ?</h3> <?php echo $this->Form->radio('BirthDocumentation.caesarean_section', array('NO','YES'),array('legend'=>false,'id'=>'section','label'=>false,'class' => 'section','unchecked'=>true));?>
			</td>
		</tr>
	</table>
	<table width="100%" align="center" cellpadding="0" cellspacing="1" style="display: none;" class="no">
		<tr>
			<td id='cesNO' colspan="2" style="font-weight: bold;"><?php echo $this->Form->radio('BirthDocumentation.labor_type', array('SPONTANEOUS LABOUR','INDUCED LABOR'),array('legend'=>false,'label'=>false,'class' => 'labor','unchecked'=>true));?>
			</td>
		</tr>
		<tr id='spLabour' style="display: none; font-weight: bold;">
			<td class="tdLabel" valign="top" align="left" colspan="2">
			<?php echo $this->Form->radio('BirthDocumentation.progress', array('Spontaneous Progress ?','AUGMENTED'),array('class'=>'spAug','legend'=>false,'label'=>false ,'unchecked'=>true));?>
			</td>
		</tr>
		<tr class="induceLabour" style="display: none;">
			<td class="tdLabel" valign="top" align="left"><?php echo __('1. Gest. Age > 38ks :')."&nbsp".$this->Form->radio('BirthDocumentation.gest_age', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
			<td class="tdLabel" valign="top" align="left"><?php echo __('3. Pelvic exam :')."&nbsp".$this->Form->radio('BirthDocumentation.pelvic_exam', array('Adeq','Inadeq'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
		</tr>
		<tr class="induceLabour" style="display: none;">
			<td class="tdLabel" valign="top" align="left"><?php   echo __('2. FHR Status:')."&nbsp".$this->Form->radio('BirthDocumentation.fhr_status', array('Normal','Abnormal'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
			<td class="tdLabel" valign="top" align="left"><?php echo __('4.  Tachystatole :')."&nbsp".$this->Form->radio('BirthDocumentation.tachystatole', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
		</tr>

		<tr class="agumentsec" style="display: none;">
			<td class="tdLabel" valign="top" align="left"><?php echo __('1.Est. Fetal wgt BEFORE Aug.__________') ?>
			</td>
			<td class="tdLabel" valign="top" align="left"><?php echo __('3. Pelvic exam :')."&nbsp".$this->Form->radio('BirthDocumentation.pelvic_exam', array('Adeq','Inadeq'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
		</tr>
		<tr class="agumentsec" style="display: none;">
			<td class="tdLabel" valign="top" align="left"><?php   echo __('2.FHR Status:')."&nbsp".$this->Form->radio('BirthDocumentation.fhr_status', array('Normal','Abnormal'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
			<td class="tdLabel" valign="top" align="left"><?php echo __('4.Tachystatole :')."&nbsp".$this->Form->radio('BirthDocumentation.Tachystatole', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
		</tr>
		<tr class="induceLabour spLabour " style="display: none;">
			<td class="tdLabel" valign="top" align="left"><?php echo __('PARTOGRAM ? :')."&nbsp".$this->Form->radio('BirthDocumentation.partogram', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
		</tr>
		<tr class="spLabour induceLabour agumentsec " style="display: none;">
			<td class="tdLabel" valign="top" align="left"><?php echo __('Oxytocin used ?:')."&nbsp".$this->Form->radio('BirthDocumentation.oxytocin_used', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
		</tr>
		<tr class="agumentsec induceLabour" style="display: none;">
			<td class="tdLabel" valign="top" align="left"><?php echo __('Episiotomy? :')."&nbsp".$this->Form->radio('BirthDocumentation.episiotomy', array('No','yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
		</tr>
		<tr class="agumentsec induceLabour" style="display: none;">
			<td class="tdLabel" valign="top" align="left"><span
				style='float: left;'>Number of PGE2 doses?</span> <?php echo $this->Form->input('BirthDocumentation.number_of_pge2',array('class' =>'textBoxExpnd','type'=>'text','label'=>false,'autocomplete'=>'off','div'=>false,'style'=>'width:20%')); ?>
			</td>
		</tr>
		<tr class="agumentsec induceLabour" style="display: none;">
			<td class="tdLabel" valign="top" align="left"><span
				style="float: left; font-weight: bold; font-style: italic;">Episiotomy
					Indication</span> <?php echo $this->Form->input('BirthDocumentation.epsiotomy_indication',array('class' =>'textBoxExpnd','type'=>'text','div'=>false,'label'=>false,'style' =>"width:50%;",'autocomplete'=>'off')); ?>
			</td>
		</tr>
		</tr>
		<tr class="agumentsec induceLabour" style="display: none;">
			<td class="tdLabel" id="boxSpace" valign="top" align="left"><?php echo __('Episiotomy ? :')."&nbsp".$this->Form->radio('BirthDocumentation.episiotomy', array('No','yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
		</tr>
		<tr class="agumentsec induceLabour" style="display: none;">
			<td class="tdLabel" id="boxSpace" valign="top" align="left"><?php echo __('Partogram ?:')."&nbsp".$this->Form->radio('BirthDocumentation.partogram', array('No','yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
			</td>
		</tr>
	</table>
	<table width="100%" align="center" cellpadding="0" cellspacing="1" style="display: none;" class="yes">
		<tr>
			<td>
				<table width="100%" align="center" cellpadding="0" cellspacing="1">

					<tr class="yessel" "style="display: none;">
						<td><?php echo __('In Labor ? :')."&nbsp".$this->Form->radio('BirthDocumentation.is_labor', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>
					<tr class="yessel" "style="display: none; font-weight: bold;">
						<td><?php echo __( 'CS Emergency :')."&nbsp".$this->Form->radio('BirthDocumentation.cs_emergency',array('No','Yes'),array('legend'=>false,'label'=>false,'class'=>'csEmergency','unchecked'=>true));?>
						</td>
					</tr>
					<tr class="steps" style="display: none;">
						<td class="tdLabel" valign="top" align="left"><?php echo __('1.cm dilated when CS done').$this->Form->checkbox('BirthDocumentation.cm_dilated', array('legend'=>false,'label'=>false,))."cm"; ?>
						</td>
					</tr>
					<tr class="steps" style="display: none;">
						<td class="tdLabel" valign="top" align="left"><?php echo __('2.Partogram')."&nbsp".$this->Form->radio('BirthDocumentation.partogram', array('No','Yes'),array('legend'=>false,'label'=>false));?>
						</td>
					</tr>
					<tr class="steps" style="display: none; font-weight:bold;">
						<td class="tdLabel" valign="top" align="left"><?php  echo __('3').$this->Form->radio('BirthDocumentation.yinduced_labor', array('Spontaneces','Induced labour'),array('legend'=>false,'label'=>false,'class' =>'n'));?>
						</td>
					</tr>
					<tr class='indLabour' style="display: none;">
						<td class="tdLabel" valign="top" align="left"><?php echo __('1. Gest. Age > 18ks  :')."&nbsp".$this->Form->radio('BirthDocumentation.gest_age', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
						<td class="tdLabel" valign="top" align="left"><?php echo __('3. Pelvic exam   :')."&nbsp".$this->Form->radio('BirthDocumentation.pelvic_exam', array('Adeq','Inadeq'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>
					<tr class='indLabour' style="display: none;">
						<td class="tdLabel" valign="top" align="left"><?php   echo __('2.FHR Status  :')."&nbsp".$this->Form->radio('BirthDocumentation.fhr_status', array('Normal','Abnormal'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
						<td class="tdLabel" valign="top" align="left"><?php echo __( '4. Tachystatole  :')."&nbsp".$this->Form->radio('BirthDocumentation.tachystatole', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>
					<tr class="steps" style="display: none;">
						<td class="tdLabel" valign="top" align="left"><?php echo __('5.Oxytocin used  :')."&nbsp".$this->Form->radio('BirthDocumentation.oxytocin', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>
					<tr class="steps" style="display: none;">
						<td class="tdLabel" valign="top" align="left"><?php echo __('6. Number of PGE2 does?  :').$this->Form->checkbox('BirthDocumentation.number_of_PGE2', array('legend'=>false,'label'=>false,))."cm"; ?>
						</td>
					</tr>
					<tr class="yessel" "style="display: none;">
						<td><?php echo __( 'CS Elective :')."&nbsp".$this->Form->radio('BirthDocumentation.cs_elective',array('Absolute','Non-Absolute'),array('legend'=>false,'label'=>false,'class' =>'elective','unchecked'=>true));?>
						</td>
					</tr>
				</table>
				<table width="100%" align="center" cellpadding="0" cellspacing="1" class="" style="display: none;" id="absolute">
					<tr>
						<td class="tdLabel" valign="top" align="right"><?php echo __('Failed Induction  :' ).$this->Form->checkbox('BirthDocumentation.failed_induction', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'failed_indction')); ?></td>
						
						<td class="tdLabel pro_monitoring" style= "display: none">Proper Monitoring</td>
					</tr>
					<tr>
						<td class="tdLabel" valign="top" align="right"><?php echo __('Fetal Distress :' ).$this->Form->checkbox('BirthDocumentation.fetal_distress', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'fetal_distres')); ?></td>
						
						<td class="tdLabel distress" valign="top"  style="display: none"><?php echo __('1. Thik MSK' ).$this->Form->checkbox('BirthDocumentation.thik_MSK', array('legend'=>false,'label'=>false,'class' => 'ffetal_hypoxia')); ?></td>
						
					</tr>
					<tr>
						<td></td>
						<td class="tdLabel distress" valign="top" align="right" style="display: none"><?php echo __('2.Fetal hypoxia' ).$this->Form->checkbox('BirthDocumentation.fetal_hypoxia', array('legend'=>false,'label'=>false,'class' => 'ffetal_hypoxia')); ?></td>
						<td class="doppeler" style= "display: none"><?php  echo "&nbsp&nbsp".__('Doppeler results documented?').$this->Form->radio('BirthDocumentation.doppeler_result', array('No','Yes'),array('legend'=>false,'label'=>false,'style'=>'float:left','div'=>false,'unchecked'=>true));?></td>
					</tr>
					<tr>
						<td></td><?php //swa?>
						<td class="tdLabel distress" valign="top" align="right" style="display:none"><?php echo __('3.Persistent bradycardia < 110bpm' ).$this->Form->checkbox('BirthDocumentation.persistent_bradycardia', array('legend'=>false,'label'=>false,'class' => 'persistent_bradycar')); ?></td>
						<td class="trace" style="display: none;float: right;'">NST trace in notes?<?php echo $this->Form->radio('BirthDocumentation.persist_nst_trace', array('No','Yes'),array('legend'=>false,'style'=>'float:left','label'=>false,'div'=>false,'unchecked'=>true));?></td>
					</tr>
					<tr>
						<td></td>
						<td class="tdLabel distress" valign="top" align="right" style="display:none"><?php echo __('4.Decreased or absent variability' ).$this->Form->checkbox('BirthDocumentation.decreased_absent_variability', array('legend'=>false,'label'=>false,'class' => 'persistent_bradycar')); ?></td>
						<td class="trace" style="display: none;float: right;'">NST trace in notes?<?php echo $this->Form->radio('BirthDocumentation.variability_nst_trace', array('No','Yes'),array('legend'=>false,'label'=>false,'style'=>'float:left','div'=>false,'unchecked'=>true));?></td>
												
					</tr>
					<tr>
						<td></td>
						<td class="tdLabel distress" valign="top" align="right" style="display:none"><?php echo __('5.Late / Variable deccelerations' ).$this->Form->checkbox('BirthDocumentation.late_variable_deccelerations', array('style'=>'','legend'=>false,'label'=>false,'class' => 'persistent_bradycar','id'=>'')); ?></td>
						<td class="trace" style="display: none;float: right;'">NST trace in notes?<?php echo $this->Form->radio('BirthDocumentation.deccelerations_nst_trace', array('No','Yes'),array('legend'=>false,'label'=>false,'style'=>'float:left','div'=>false,'unchecked'=>true));?></td>				
					</tr>
					<tr>
						<td class="tdLabel" valign="top" align="left"><?php echo $this->Form->radio('BirthDocumentation.prior_cs', array('Prior 1 cs','Prior 2 cs'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>
					<tr>
		         	 <td class="tdLabel" valign="top" align="right"><?php echo __('Oligohydramnios <= 4' ).$this->Form->checkbox('BirthDocumentation.Oligohydramnios', array('style'=>'float:left','legend'=>false,
		          		'label'=>false,'class' =>'oligohydramssss','id'=>'')); ?></td>
					<td class="afii"  style="display:none;">AFI: <?php echo $this->Form->input('BirthDocumentation.afi',array('class' =>'textBoxExpnd','type'=>'text','label'=>false,'div'=>false,'autocomplete'=>'off',
							'style'=>'width:20%;float:initial'));?> cm--->document in USG box?</td>
					</tr>
					<tr>
					 <td class="tdLabel" valign="top" align="right"><?php echo __('Malpresentations' ).$this->Form->checkbox('BirthDocumentation.malpresentations', 
					 		array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'malpre_scan_find','id'=>'')); ?></td>
						<td class="sell" style="display: none;">Scan findings documented in USG box?<?php echo $this->Form->radio('BirthDocumentation.scan_findings_docu', array('NO ','YES'),array('legend'=>false,'label'=>false,'div'=>false,'unchecked'=>true));?></td>
					</tr>
					<tr>
						<td class="tdLabel distress" valign="top" ><?php echo __('Contracted pelvis' ).$this->Form->checkbox('BirthDocumentation.contracted_pelvis', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'contracted_pelvis')); ?></td>
						
						<td class="tdLabel det_pel_fin" style="display:none">Detailed pelvic findings</td>
					</tr>
					<tr>
						<td class="tdLabel distress" valign="top" ><?php echo __('IUGR' ).$this->Form->checkbox('BirthDocumentation.iugr', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'birth_iugr','id'=>'')); ?></td>
						<td class="tdLabel abn_dopp_fin" style="display:none">Abnormal doppler findings documented</td>
					</tr>
					<tr>
					<td class="tdLabel" valign="top" align="right"><?php echo __('Estimated Birth Weight > 4kg').$this->Form->checkbox('BirthDocumentation.estimated_birth_wt', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'est_birth_wt','id'=>'')); ?></td>
							
					<td class=" est_weight"  style='display:none'><span style='float:left;'>Estimated Weight</span> <?php echo $this->Form->input('BirthDocumentation.estimated_weight',array('class' =>'textBoxExpnd','type'=>'text','autocomplete'=>'off','label'=>false,'style'=>'width:20%','div'=>false)); ?>kg
					</tr>
					<tr>
						<td></td>
						<td class=" act_weight" style='display:none'><span style='float: left;'>Actual Weight</span> <?php echo $this->Form->input('BirthDocumentation.actual_weight',array('class' =>'textBoxExpnd','type'=>'text','autocomplete'=>'off','label'=>false,'style'=>'width:20%','div'=>false)); ?>kg
					</tr>
					<tr>
						<td class="tdLabel " valign="top" align="right"><?php echo __('Non Progress of Labor').$this->Form->checkbox('BirthDocumentation.non_progress_labor', array('style'=>'float:left','legend'=>false,'label'=>false,)); ?></td>
					</tr>
					<tr>
						<td class="tdLabel " valign="top" align="right"><?php echo __('Obstructed Labor:').$this->Form->checkbox('BirthDocumentation.obstructed_labor', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'obst_labor')); ?></td>
						
					</tr>
					<tr>
						<td class="tdLabel " valign="top" align="right"><?php echo __('Other Primary Indication:').$this->Form->checkbox('BirthDocumentation.other_primary_indication', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'other_pri_indication')); ?></td>
						
						<td  class="tdLabel other_inc" valign="top" align="right" style='display:none'><?php echo $this->Form->input('BirthDocumentation.primary_indication)',array('type' =>'textarea','type'=>'text','label'=>false,'style'=>'width: 300px;','rows'=>'1')); ?></td>
						
					</tr>
				</table>
				<table width="100%" align="center" cellpadding="0" cellspacing="1"class="" style="display: none;" id="nonAbsolute">
					<tr>
						<td class="tdLabel" valign="top" align="left"><?php echo __('CPD' ).$this->Form->checkbox('BirthDocumentation.cpd', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => '','id'=>'cpd')); ?></td>
						
						<td class="tdLabel ss"  valign="top" align="left" style="display:none">
							<?php echo $this->Form->radio('BirthDocumentation.cpd_documented', array('1.Full TOL documented?','2.Detailed pelvic documented?'),array('legend'=>false,'label'=>false,'div'=>false,'class'=> 'docu','unchecked'=>true));?>
						<span id='fetal' style="display:none; float: right;"><?php echo $this->Form->radio('BirthDocumentation.detail_doc', array('No','Yes'),array('legend'=>false,'label'=>false,'div'=>false,'unchecked'=>true));?></span>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" valign="top" align="left"><?php echo __('Oligohydramnios>4' ).$this->Form->checkbox('BirthDocumentation.oligohydramn', array('style'=>'float:left','legend'=>false,'label'=>false,'id'=>'oligohydramnios')); ?></td>
						
						<td class="tdLabel tol_yn"  valign="top" align="left" style="display:none"><?php echo __('ToL?').$this->Form->radio('BirthDocumentation.is_tol', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" valign="top" align="left"><?php echo __('IUGR' ).$this->Form->checkbox('BirthDocumentation.iugr', array('style'=>'float:left','legend'=>false,'label'=>false,'id'=>'iugr')); ?></td>
						
						<td class="tdLabel symAsym" style="display:none" valign="top" align="left" ><?php echo $this->Form->radio('BirthDocumentation.sym_asy_doppler', array('0'=>'Symmetric/asymmetric','1'=>'doppler normal'),array('legend'=>false,'label'=>false,'class' => 'iugr','unchecked'=>true));?>
							<span id="selIUGR" style="display: none;"><?php echo $this->Form->radio('BirthDocumentation.doppler_normal', array('No','Yes'),array('value'=>'ss','legend'=>false,'label'=>false,'div'=>false,'unchecked'=>true));?>
						</span>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" valign="top" align="left"><?php echo __('BOH' ).$this->Form->checkbox('BirthDocumentation.boh', array('style'=>'float:left','legend'=>false,'label'=>false,'class' =>'boh')); ?></td>
						
						<td class="tdLabel shw" valign="top" align="left" style="display:none">-Recureent
							Absortions?<?php echo $this->Form->radio('BirthDocumentation.recureent_absortions', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td class="tdLabel shw" valign="top" align="left" style="display:none">Previous still
							births? <?php echo $this->Form->radio('BirthDocumentation.previous_still', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td class="tdLabel shw" valign="top" align="left" style="display:none">Neonatal deaths? <?php echo $this->Form->radio('BirthDocumentation.neonatal_deaths', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td class="tdLabel shw" valign="top" align="left" style="display:none">Infant deaths? <?php echo $this->Form->radio('BirthDocumentation.infant_deaths', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>

					<tr>
						<td class="tdLabel" valign="top" align="left"><?php echo __('PROM' ).$this->Form->checkbox('BirthDocumentation.prom', array('style'=>'float:left','legend'=>false,'label'=>false,'class' =>'prom','id'=>'')); ?></td>
						
						<td class="tdLabel pre" style="display:none"><?php echo $this->Form->radio('BirthDocumentation.prom_val', array('Preterm / term','Duration <24hrs / >24 hrs','Liquor colour - clear / MSL grade : 1  /  2  / 3','Any associated infection'),array('legend'=>false,'label'=>false,'class' => 's','id' => '','unchecked'=>true));?>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" valign="top" align="left"><?php echo __('Preeclampsia' ).$this->Form->checkbox('BirthDocumentation.preeclampsia', array('style'=>'float:left','legend'=>false,'label'=>false,'class' =>'pree')); ?></td>
						
						<td class="tdLabel mild" style="display:none"><?php echo $this->Form->radio('BirthDocumentation.mild_associated_IUGR', array('0'=>'Mild/severe','1'=>'Associated IUGR'),array('legend'=>false,'label'=>false,'class' => 'preeclampsia','unchecked'=>true)); ?>
							<span id="assIUGR" style="display: none;"><?php echo $this->Form->radio('BirthDocumentation.associated_IUGR', array('No','Yes'),array('legend'=>false,'label'=>false,'div'=>'false','unchecked'=>true));?>
						</span>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" valign="top" align="left"><?php echo __('Multifetal gestation' ).$this->Form->checkbox('BirthDocumentation.multifetal_gestation', array('style'=>'float:left','legend'=>false,'label'=>false,'class' =>'multi_ges')); ?></td>
						
						<td class="tdLabel mul_sel" style="display:none"><?php echo $this->Form->radio('BirthDocumentation.multifetal_gestation_val', array('Both cephalic alic-TOL?','1st breech','2nd breech','Transverse lie'),array('legend'=>false,'label'=>false,'class' => 'mulGest','unchecked'=>true));?>
						</td>
					</tr>
					<tr id='tol' style="display: none;">
						<td></td>
						<td><?php echo $this->Form->radio('BirthDocumentation.both_cephalic_tol', array('NO','YES'),array('legend'=>false,'label'=>false,'id' => '','unchecked'=>true));?>
						</td>
					</tr>
					<tr>
					<td class="tdLabel" valign="top" align="left" ><?php echo __('Patient option' ).$this->Form->checkbox('BirthDocumentation.patient_option', array('style'=>'float:left','legend'=>false,'label'=>false,'class' =>'patient_option')); ?></td>
						
						<td class="tdLabel councelling" style="display: none;">Councelling done? <?php echo $this->Form->radio('BirthDocumentation.councelling_done', array('No','Yes'),array('legend'=>false,'label'=>false,'unchecked'=>true));?>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" valign="top" align="left" ><?php echo __('Other').$this->Form->checkbox('BirthDocumentation.other', array('style'=>'float:left','legend'=>false,'label'=>false,'class' =>'others')); ?></td>
						<td  class="tdLabel oth" style='display:none'><?php echo $this->Form->input('BirthDocumentation.other_info',array('class' =>'textBoxExpnd','type'=>'text','autocomplete'=>'off','label'=>false,'style'=>'width:50%;')); ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="100%"  border="0" cellpadding="0" cellspacing="1" class="">
		<tr><td valign="top" style="font-weight: bold;">Detail any other contributing indications/complications here:</td></tr>
		<tr>
		<td colspan="4"><?php echo $this->Form->input('BirthDocumentation.indications_complications',array('type'=>'textarea','style'=>'width: 995px;','label'=>false,'rows'=>'3','cols'=>'4'));
					?>
			</td>
		</tr>
		
	</table>
	<table width="100%" align="center" cellpadding="0" cellspacing="1"  height="90px"
		class="">
		<tr>
			<td style='text-align: right'>SIGNATURE OF DOCTOR</td>
		</tr>
	</table>
	<span><?php echo $this->Form->submit(__('Submit and Print '),array('style'=>'padding:0px;float:right;width:109px;','class'=>'blueBtn','id'=>'submit','onclick'=>'window.print();','div'=>false,'label'=>false));?>
	</span>
	<?php echo $this->Form->end();?>
</body>
</html>

<script>

 $(document).ready(function(){ 
 $('.section:radio').click(function(){				
			if($(this).val() =='1'){ 
				$('.yes').show();	
				$('.no').hide();
				}else{
					$('.yes').hide();	
					$('.no').show();
				}
			});
 $('.no:radio').click(function(){	
		if($(this).val() =='0'){  
			$('#cesNO').show();	
		
			}else{
				$('#cesNO').hide();	
			}
		});
 
 $('.labor:radio').click(function(){ 
		if($(this).val() =='0'){ 
			$('#spLabour').show();
			$('.induceLabour').hide();	
			}else{
				$('#spLabour').hide();
				$('.induceLabour').show();		
			}
		});
		
 $('.spAug:radio').click(function(){ 
				if($(this).val() =='1'){ 
					$('.agumentsec').show();
					
					}else{
						$('.agumentsec').hide();
						
					}
				});	
 $('.no:radio').click(function(){ 
		if($(this).val() =='1'){ 
			$('.yessel').show();
			
			}else{
				$('.yessel').hide();
				
			}
		});	
 $('.csEmergency:radio').click(function(){ 
			if($(this).val() =='1'){ 
					$('.steps').show();
					
					}else{
						$('.steps').hide();
						
					}
				});	
 $('.elective:radio').click(function(){  
		if($(this).val() =='0'){ 
			$('#absolute').show();
			$('#nonAbsolute').hide();
			
			}else{
				$('#nonAbsolute').show();
				$('#absolute').hide();
			}
		});	
	
$('.n:radio').click(function(){  
		if($(this).val() =='1'){ 
			$('.indLabour').show();
			}else{
				$('.indLabour').hide();
			}
		}); 

$('.mulGest:radio').click(function(){  
			if($(this).val() =='0'){ 
				$('#tol').show();
				}else{
					$('#tol').hide();
				}
			}); 
$('.preeclampsia:radio').click(function(){ 
			if($(this).val() =='1'){ 
				$('#assIUGR').show();
				}else{
					$('#assIUGR').hide();
				}
			}); 
$('.iugr:radio').click(function(){  
				if($(this).val() =='1'){ 
					$('#selIUGR').show();
					}else{
						$('#selIUGR').hide();
					}
				}); fetal
$('#cpd').click(function(){			
	if($("#cpd").is(':checked')){	
		$('.ss').show();
			}else{
			$('.ss').hide();
		  	}
		});	
	$('.docu:radio').click(function(){   
		if($(this).val() =='1'){ 
		$('#fetal').show();
		}else{
		$('#fetal').hide();
		 }
	});	
	$('#oligohydramnios').click(function(){	
		if($("#oligohydramnios").is(':checked')){	
			$('.tol_yn').show();
				}else{
				$('.tol_yn').hide();
			  	}
			});	
					
	$('#iugr').click(function(){	
		if($("#iugr").is(':checked')){	
			$('.symAsym').show();
				}else{
				$('.symAsym').hide();
			  	}
			});	
					
	$('.boh').click(function(){	
		if($(".boh").is(':checked')){	
			$('.shw').show();
				}else{
				$('.shw').hide();
			  	}
			});	
	$('.prom').click(function(){	
		if($(".prom").is(':checked')){	
			$('.pre').show();
				}else{
				$('.pre').hide();
			  	}
			});	
		
	$('.pree').click(function(){	
		if($(".pree").is(':checked')){	
			$('.mild').show();
				}else{
				$('.mild').hide();
			  	}
			});		
	$('.multi_ges').click(function(){	
		if($(".multi_ges").is(':checked')){	
				$('.mul_sel').show();
					}else{
					$('.mul_sel').hide();
					}
				});	
	$('.patient_option').click(function(){	
			if($(".patient_option").is(':checked')){	
				$('.councelling').show();
					}else{
					$('.councelling').hide();
				}
				});				
	$('.failed_indction').click(function(){	
		if($(".failed_indction").is(':checked')){	
		$('.pro_monitoring').show();
			}else{
			$('.pro_monitoring').hide();
			}
		});	
	$('.fetal_distres').click(function(){	
			if($(".fetal_distres").is(':checked')){	
			$('.distress').show();
				}else{
				$('.distress').hide();
				}
			});			
	$('.ffetal_hypoxia').click(function(){	
		if($(".ffetal_hypoxia").is(':checked')){	
		$('.doppeler').show();
			}else{
			$('.doppeler').hide();
		}
	});
	$('.persistent_bradycar').click(function(){	
		if($(".persistent_bradycar").is(':checked')){	
		$('.trace').show();
			}else{
			$('.trace').hide();
		}
	}); 

	$('.contracted_pelvis').click(function(){	
		if($(".contracted_pelvis").is(':checked')){	
		$('.det_pel_fin').show();
			}else{
			$('.det_pel_fin').hide();
		}
	}); 

	$('.birth_iugr').click(function(){	
		if($(".birth_iugr").is(':checked')){	
		$('.abn_dopp_fin').show();
			}else{
			$('.abn_dopp_fin').hide();
		}
	}); 
	$('.est_birth_wt').click(function(){	
		if($(".est_birth_wt").is(':checked')){	
		$('.est_weight , .act_weight').show();
			}else{
			$('.est_weight , .act_weight').hide();
		}
	}); 
	
	$('.other_pri_indication').click(function(){	
		if($(".other_pri_indication").is(':checked')){	
		$('.other_inc').show();
			}else{
			$('.other_inc').hide();
		}
	}); 

	$('.malpre_scan_find').click(function(){	
		if($(".malpre_scan_find").is(':checked')){	
		$('.sell').show();
			}else{
			$('.sell').hide();
		}
	});
	$('.oligohydramssss').click(function(){	
		if($(".oligohydramssss").is(':checked')){	
			$('.afii').show();
				}else{
				$('.afii').hide();
				}
			});	
	$('.others').click(function(){	
		if($(".others").is(':checked')){	
			$('.oth').show();
				}else{
				$('.oth').hide();
				}
			});	
								
  $("#toDate").datepicker({
				showOn: "both",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				maxDate: new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',		
			});


 });

</script>
<noscript>
	<div
		style="text-align: center; background-color: red; width: 100%; color: white; font-weight: bold;">
		It seems JavaScript is either disabled or not supported by your
		browser, enable JavaScript by changing your browser options</div>
</noscript>
<script>
var matched, browser;

jQuery.uaMatch = function( ua ) {
  ua = ua.toLowerCase();

  var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
      /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
      /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
      /(msie) ([\w.]+)/.exec( ua ) ||
      ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
      [];

  return {
      browser: match[ 1 ] || "",
      version: match[ 2 ] || "0"
  };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
  browser[ matched.browser ] = true;
  browser.version = matched.version;
}

//Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
  browser.webkit = true;
} else if ( browser.webkit ) {
  browser.safari = true;
}

jQuery.browser = browser;

  </script>
