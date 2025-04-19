<style>
.heading
{
    background: #FFFFFF	;
    color: #180000;
    
}

.margin
{
    margin-bottom: 5px;
}
</style>
<html>
<head>
<?php echo $this->Html->script(array('patient_access_js1.js','patient_access_js2.js') );
  echo $this->Html->css(array('patient_access.css',));?>


<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
</head>
<body>
	<div>
		<h1>Medication</h1>
		<p>Listed below are all medication on file for you. "Prescribed
			medication " are those on file with the patient's provide. "Other
			medication" are those that have been entered via CCDA. Click the tabs
			to move between the lists</p>
		<p>This may not a complete and accurate list depending on when a last
			review and update was done. We appreciate your assistance with
			updating your medication lists.</p>
	</div>


	<p>Every effort will be made to respond to your request within 24
		hours, excepts when the offer is closed on weekends and holidays.</p>
	<p style="background:">
		<b>Need immediate service?</b> Please call your healthcare provider
		directly at +91-937311709
	</p>
	<div>
		<h2>Report Medication</h2>
	</div>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1"><b>Prescribed Med</b></a></li>
			<li><a href="#tabs-2"><b>Other Med</b></a></li>
			<!--<li><a href="#tabs-3">Aenean lacinia</a></li>-->
		</ul>
		<div id="tabs-1" style="color: #33ccff; background: #000;">
			
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align="center" valign='top'>
				<tr class="heading">
					<td style="padding-left: 10px"><b>Medication</b></td>
					<td style="padding-left: 10px"><b>Route</b></td>
					<td style="padding-left: 10px"><b>Dose</b></td>
					<td style="padding-left: 10px"><b>Frequency</b></td>
					<td style="padding-left: 10px"><b>Status</b></td>
				
				
				<tr class="margin ">
					<?php foreach($medicationRecords as $medicationdatas){ ?>
				
				
				<tr class="row_title">
					<?php if($medicationdatas['NewCropPrescription']['is_ccda']!='1'){?>
					<td><?php echo $medicationdatas['NewCropPrescription']['description'];?>
					</td>
					<td><?php echo $medicationdatas['NewCropPrescription']['route'];?>
					</td>
					<td><?php echo $medicationdatas['NewCropPrescription']['dose'];?>
					</td>
					<td><?php echo $medicationdatas['NewCropPrescription']['frequency'];?>
					</td>
					<?php if($medicationdatas['NewCropPrescription']['archive']=='N'){
						$statusMed='Active';
					}
					else if($medicationdatas['NewCropPrescription']['archive']=='C'){
						$statusMed='Not Complete';
  					}
  					else{
						$statusMed='Inactive';
  					}?>
					<td><?php echo $statusMed;?>
					</td>
				
				
				<tr>
					<?php }
}?>
			
			</table>
		</div>
		<div id="tabs-2" style="color: #33ccff; background: #000;">
			<p>
				<?php //debug($medicationRecords);?>
			</p>
			<table width="100%" cellpadding="0" cellspacing="0" border="0"
				align="center" valign='top'>
				<tr class="row_title">
					<td>Medication Name</td>
					<td>Route</td>
					<td>Dose</td>
					<td>Frequency</td>
					<td>Status</td>
				
				
				<tr>
					<?php foreach($medicationRecords as $medicationdatas){ ?>
				
				
				<tr class="row_title">
					<?php if($medicationdatas['NewCropPrescription']['is_ccda']=='1'){?>
					<td><?php echo $medicationdatas['NewCropPrescription']['description'];?>
					</td>
					<td><?php echo $medicationdatas['NewCropPrescription']['route'];?>
					</td>
					<td><?php echo $medicationdatas['NewCropPrescription']['dose'];?>
					</td>
					<td><?php echo $medicationdatas['NewCropPrescription']['frequency'];?>
					</td>
					<?php if($medicationdatas['NewCropPrescription']['archive']=='N'){
						$statusMed='Active';
					}
					else if($medicationdatas['NewCropPrescription']['archive']=='C'){
						$statusMed='Not Complete';
  					}
  					else{
						$statusMed='Inactive';
  					}?>
					<td><?php echo $statusMed;?>
					</td>
				
				
				<tr>
					<?php }
}?>
			
			</table>
		</div>
		<!--<div id="tabs-3">
    <p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
    <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
  </div>-->
	</div>


</body>
</html>
