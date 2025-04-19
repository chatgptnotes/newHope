<?php 


echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<style>
.tdclass {
	padding-left: 10px;
}

.td1 {
	padding-left: 5px;
	width: 20%;
	border-bottom: 1px solid #3E4D4A;
	border-right: 1px solid #3E4D4A;
}

.td2 {
	border-bottom: 1px solid #3E4D4A;
	width: 100%;
}

.tr1 {
	height: 50px;
	border-bottom:;
}

.table {
	border: 1px solid #3E4D4A;
}
</style>
<div>
	<h3>Ventilator/Sedation Order Test</h3>
</div>
<div>

	<?php echo $this->Form->create('ventilation_test',array('type' => 'file','id'=>'ventilation_test','inputDefaults' => array(
		'label' => false,'action'=> 'ventilation_test',	'div' => false,	'error' => false))); ?>


	<table width="100%" cellspacing="0" cellpadding="0"
		border="1px solid #3E4D4A" class="table">
		<tbody>
			<tr>
				<td width="49%" valign="top" align="left">
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
						<tbody>



							<tr width="100%" valign="middle" class="tr1">


								<td class="td1"><strong><?php echo __('Ventilator Management :');?>
								</strong></td>
								<td class="td2">
									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Anesthesia</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Medical</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo ('Consult Dr Setting :');?> </strong>
								</td>
								<td width="20%"class="td2"><?php echo $this->Form->input('consult_name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'consult_name','label'=> false,'div' => false, 'error' => false)); ?>
								</td>
								<td class="td2"></td>
								<td class="td2"></td>
							</tr>


							<tr width="100%" valign="middle" id="boxSpace" class="tdLabel">
								<td class="td1"><strong><?php echo __('Ventilator Setting :');?>
								</strong></td>
								<td class="td2">
									<table>
										<tr class="td1">
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												SIMV</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Assist Control</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												PSV</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Radiology :');?> </strong>
								</td>
								<td class="td2">
									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Portable Chest X-Ray on arrival</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Portable Chest X-Ray on every other day while intubated</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Labs :');?> </strong></td>
								<td class="td2">
									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));	?>
												ABG 30 minutes after interval ventilator setting andcall
												results</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));	?>
												ABG Daily q AM while intubated</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Studies :');?> </strong>
								</td>
								<td class="td2">
									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Post Operative wean when criteria met</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Wean from ventilator when criteria met</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Evaluate patient for weaning in Am</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Vital Signs :');?> </strong>
								
								<td class="td2">
									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Q 15 min X 4 then q 1 hr and prn as needed with SpO2%</td>
										</tr>
									</table>
								</td>

							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Activity :');?> </strong>
								</td>
								<td class="td2">
									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Bed Rest with head of bed elevated 30-45 degrees if not
												contraindicaed</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Consults :');?> </strong>
								</td>
								<td class="td2">
									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Dr</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Sedation :');?> </strong>
								</td>
								<td class="td2">
									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Midazolam infusion protocol:Titrate to obtain selected Rass
											</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Midazolam mg IV q 30 min prn for agitation</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Lorazepam infusion protocol: Titrate to obtain selected RASS
											</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Lorazepam Img IV q 15 minutes prn for agitation</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Propofol infusion protocol. titrate to obtaining selected
												RASS</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Analgesia :');?> </strong>
								</td>
								<td class="td2">
									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Morphine 2 mg IV q 1 hrs prn minor pain & Morphine 4 mg IV q
												1 hrs prn major pain</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Morphine infusion:loading dose___ mg IV then:Infusion Rate
												mg/hr</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												PCA see additional orders</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('Oral Care :');?> </strong>
								</td>
								<td class="td2">

									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Q 4 hrs with 0.12% chlorexidine solution, and brush teeth q
												12 hrs if possible.</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('DVT Prophaxis :');?> </strong>
								</td>
								<td class="td2">
									<table>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Ted Stocking knee length</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Sequential Compression Device</td>
										</tr>
										<tr>
											<td><?php echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Heaprin 5000 units Sub Que q 12 hrs</td>
										</tr>
									</table>
								</td>


							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td class="td1"><strong><?php echo __('PUD Prophaxis :');?> </strong>
								</td>
								<td class="td2">
									<table>
										<tr>
											<td><?php 	echo $this->Form->checkbox('ventilator', array('class'=>'servicesClick','id' => 'ventilator'));?>
												Zantac 50 mg IV q 8 hrs</td>
										</tr>
									</table>
								</td>
							</tr>

							<tr width="100%" valign="middle" id="boxSpace" class="tr1">
								<td></td>
								<td align="right" style="padding-right: 5px";><input
									class="blueBtn" type="submit" value="Submit"></td>

							</tr>
					
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
</form>
