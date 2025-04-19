<?php
$freq=Configure :: read('frequency');
$route_admin=Configure :: read('route_administration');
$freq_fullform=Configure :: read('frequency_fullform');
?>
<style>
.inner_title h3{ font-size:13px;}
</style>
<?php 
	$flashMsg = $this->Session->flash('still') ;
	if(!empty($flashMsg)){ ?>
	<div>
		<?php echo $flashMsg ;?>
	</div> 
<?php } ?>

<?php echo $this->Html->script(array('jquery.autocomplete','jquery.ui.accordion.js','jquery.fancybox-1.3.4'));
 echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css')); ?>
<div>&nbsp;<?php echo $this->element('portal_header');?></div>

<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Recent Activities - Patient', true); ?>
	</h3>
</div>
<?php //debug($getAllAppointments);//debug($recentallg);debug($recentproblem);debug($recentimmu);?>

	<h3 style="font-size:13px;"><?php echo __('Appointments')?></a></h3>
	<div class="section">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center" valign='top'>
			<tr class="row_title">
				<td class="tdLabel" id="boxSpace">Appointment with</td>
				<td class="tdLabel" id="boxSpace">Timing</td>
				<td class="tdLabel" id="boxSpace">Date</td>
				<td class="tdLabel" id="boxSpace">Status</td>
			</tr>
			<?php foreach($getAllAppointments as $getAllAppointments){
				$start_time=date('h:i:s a', strtotime($getAllAppointments['Appointment']['start_time']));
				$end_time=date('h:i:s a', strtotime($getAllAppointments['Appointment']['end_time']));
				
				?>
			<tr class="">
				<td class="tdLabel" id="boxSpace"><?php echo $getAllAppointments['DoctorProfile']['doctor_name'];?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $start_time." ".'to'." ".$end_time;?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $this->DateFormat->formatDate2Local($getAllAppointments['Appointment']['date'],Configure::read('date_format'),false);?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $getAllAppointments['Appointment']['status'];?></td>
			</tr>
<?php }?>
		</table>
	</div>
	
			<h3 style="font-size:13px;"><?php if(in_array(1,$permit))
		{
	echo __('Last Problem Recorded')?></h3>
	<div class="section">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center" valign='top'>
			<tr class="row_title">
				<td class="tdLabel" id="boxSpace">Problem</td>
				<td class="tdLabel" id="boxSpace">Status</td>
			</tr>
			<tr class="">
				<td class="tdLabel" id="boxSpace"><?php echo $recentproblem['diagnoses_name']?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $recentproblem['disease_status']?></td>
			</tr>

		</table>
	</div><?php }?>
	<h3 style="font-size:13px;"><?php //debug($recentmed);
		//if(in_array(2,$permit))
		{
		echo __('Last Medication Prescribed')?></a></h3>
	<div class="section">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center" valign='top'>
			<tr class="row_title">
				<td class="tdLabel" id="boxSpace">Medication</td>
				<td class="tdLabel" id="boxSpace">Route</td>
				<td class="tdLabel" id="boxSpace">Dose</td>
				<td class="tdLabel" id="boxSpace">Frequency</td>
				
			</tr>
			<?php foreach($recentmed as $recentmed){ ?>
			<tr class="">
				<td class="tdLabel" id="boxSpace"><?php echo $recentmed['NewCropPrescription']['description']?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $route_admin[$recentmed['NewCropPrescription']['route']]?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $recentmed['NewCropPrescription']['dose']?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $freq_fullform[$recentmed['NewCropPrescription']['frequency']]?></td>
				
			</tr>
			<?php } ?>

		</table>
	</div><?php }?>
	
	<h3 style="font-size:13px;"> <?php if(in_array(3,$permit))
		{
	echo __('Last Allergies Recorded')?></a></h3>
	<div class="section">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center" valign='top'>
			<tr class="row_title">
				<td class="tdLabel" id="boxSpace">Allergy</td>
				<td class="tdLabel" id="boxSpace">Severity</td>
				<td class="tdLabel" id="boxSpace">Note</td>
				<td class="tdLabel" id="boxSpace">Status</td>
			</tr>
			<tr class="">
				<td class="tdLabel" id="boxSpace"><?php echo $recentallg['name']?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $recentallg['AllergySeverityName']?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $recentallg['note']?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $recentallg['status']?></td>
			</tr>

		</table>
	</div><?php }?>
			<h3 style="font-size:13px;"><?php if(in_array(4,$permit))
		{
	 echo __('Last Lab Recorded')?></a></h3>
	<div class="section">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center" valign='top'>
			<tr class="row_title">
				<td class="tdLabel" id="boxSpace">Lab</td>
				<td class="tdLabel" id="boxSpace">Result</td>
			</tr>
			<tr class="">
				<?php //debug($recentlab);exit;?>
				<td class="tdLabel" id="boxSpace"><?php echo $recentlab['Laboratory']['name']?></td>
				<td class="tdLabel" id="boxSpace"><?php echo $recentlab['LaboratoryHl7Result']['result'].$recentlab['LaboratoryHl7Result']['uom'];?>
				</td>
			</tr>

		</table>
	</div><?php }?>
	<h3 style="font-size:13px;"><?php if(in_array(5,$permit))
		{
	 echo __('Radiology Recorded')?></a></h3>
	<div class="section">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center" valign='top'>
			<tr class="row_title">
				<td class="tdLabel" id="boxSpace">Radiology Test Name</td>
				<td class="tdLabel" id="boxSpace">Order Id</td>
				<td class="tdLabel" id="boxSpace">Oder Date</td>
			</tr>
			<?php foreach($radiologyRecords as $data){?>
			<tr class="">
				<td class="tdLabel" id="boxSpace"><?php if(!empty($data['Radiology']['name'])) echo $data['Radiology']['name'];else echo '...';?></td>
				<td class="tdLabel" id="boxSpace"><?php if(!empty($data['RadiologyTestOrder']['order_id'])) echo $data['RadiologyTestOrder']['order_id'];else echo '...';?></td>
				<td class="tdLabel" id="boxSpace"><?php if(!empty($data['RadiologyTestOrder']['radiology_order_date'])) echo $this->DateFormat->formatDate2Local($data['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),true);else echo '...';?></td>
				
			</tr>
			<?php }?>

		</table>
	</div><?php }?>
	
	
	
		
	
	
	

<div class = "clr"></div>
<script>
	 function sendrefill(id){
		 $.fancybox({
				'width' : '40%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'href' : "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "sendRefill")); ?>"+"/"+id,
				
			});
	 }
$(document).ready(function(){
	$( "#accordionCust" ).accordion({
	collapsible: true,
	autoHeight: false,
	clearStyle :true,

	navigation: true,
	change:function(event,ui){

	//BOF template call
	var currentEleID = $(ui.newContent).attr("id") ;
	var replacedID = "templateArea-"+currentEleID;


	}


	});
	});
			</script>
