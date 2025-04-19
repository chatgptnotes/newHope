<?php
// view for lab order
$radioRadio = '';
$radiohisto = '';
$radioLab = '';

if (isset ( $this->params->query ['dept'] ) && $this->params->query ['dept'] == 'radiology') {
	$radioRadio = 'checked';
	$deptHtml = $this->element ( 'radiology_order' );
	$pageHeading = __ ( 'Radiology Test Order' );
} else if (isset ( $this->params->query ['dept'] ) && $this->params->query ['dept'] == 'histology') {
	$radiohisto = 'checked';
	$deptHtml = $this->element ( 'histology_order' );
	$pageHeading = __ ( 'Histology Test Order' );
} else {
	$radioLab = 'checked';
	$deptHtml = $this->element ( 'lab_order' );
	$pageHeading = __ ( 'Lab Test Order' );
}
?>
<div class="inner_title">
	<h3><?php echo $pageHeading; ?></h3>
</div>
<p class="ht5"></p>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<?php
echo $this->Form->create ( 'Laboratory', array (
		'url' => array (
				'controller' => 'laboratories',
				'action' => 'lab_order',
				$patient_id 
		),
		'id' => 'orderfrm',
		'type' => 'get',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );

?>

<div style="float: left">
                   		<?php
																					if ($this->Session->check ( 'labReturn' )) {
																						$returnUrl = $this->Session->read ( 'labReturn' );
																						if ($returnUrl == 'invoice') {
																							echo $this->Html->link ( 'Back To Generate Invoice', array (
																									'controller' => 'billings',
																									'action' => 'patient_information',
																									$patient_id 
																							), array (
																									'escape' => false,
																									'class' => 'blueBtn' 
																							) );
																						} else if ($returnUrl == 'assessment') {
																							echo $this->Html->link ( 'Back To Initial Assessment', array (
																									'controller' => 'diagnoses',
																									'action' => 'add',
																									$patient_id 
																							), array (
																									'escape' => false,
																									'class' => 'blueBtn' 
																							) );
																						} else if ($returnUrl == 'investigation') {
																							echo $this->Html->link ( 'Back To Patient List', array (
																									'controller' => 'laboratories',
																									'action' => 'patient_search' 
																							), array (
																									'escape' => false,
																									'class' => 'blueBtn' 
																							) );
																						} else if ($returnUrl == 'ot') {
																							echo $this->Html->link ( 'Back To OT', array (
																									'controller' => 'OptAppointments',
																									'action' => 'patient_information',
																									$patient_id 
																							), array (
																									'escape' => false,
																									'class' => 'blueBtn' 
																							) );
																						} else {
																							echo $this->Html->link ( 'Back To Patient Info', array (
																									'controller' => 'patients',
																									'action' => 'patient_information',
																									$patient_id 
																							), array (
																									'escape' => false,
																									'class' => 'blueBtn' 
																							) );
																						}
																					} else {
																						echo $this->Html->link ( 'Back to Patient Info', array (
																								'controller' => 'patients',
																								'action' => 'patient_information',
																								$patient_id 
																						), array (
																								'escape' => false,
																								'class' => 'blueBtn' 
																						) );
																					}
																					
																					?>
                   </div>
<table width="" cellpadding="0" cellspacing="0" border="0" align="">
	<tr>
		<td width="25"><input type="radio" name="dept"
			<?php echo $radioLab ;?> value="labs"
			onclick="javascript:this.form.submit();" /></td>
		<td class="tdLabel2" width="" style="font-size: 15px;"><strong>Labs</strong></td>
		<td width="25"><input type="radio" <?php echo $radioRadio ;?>
			name="dept" value="radiology"
			onclick="javascript:this.form.submit();" /></td>
		<td class="tdLabel2" width="100" style="font-size: 15px;"><strong>Radiology</strong></td>
		<!--
                            <td width="25"><input type="radio" <?php echo $radiohisto ;?> name="dept" value="histology" onclick="javascript:this.form.submit();"/></td>
                          <td class="tdLabel2" width="100" style="font-size:15px;"><strong>Histology</strong></td>
                        -->
	</tr>
</table>

<div class='clr'></div>


<?php echo $this->Form->end() ;?>

<div class="clr ht5"></div>
<div class="clr ht5"></div>

<?php
echo $deptHtml;
?>

<!-- Right Part Template ends here -->
