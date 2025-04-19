<?php
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
$vals = array('Hispanic','Non-Hispanic','Latino','Others');

?>
<style>
#span_new {
	float: left;
	margin-left: 113px;
	padding: 0;
}
</style>
<div class="inner_title">
	<!-- Start for search -->
	<div align="left">
			<?php //echo "<pre>"; print_r($config_data); exit;?>
		<?php echo $this->Form->create('config',array('url'=>array('controller'=>'doctors','action'=>'config'),'type'=>'post','id'=>'frm1'));?>
		<div>
			<h3>Configurations</h3>

			<table width="100%" border="0" cellspacing="0" cellpadding="0"
				class="formFull">
				<?php if($config_data['0']['ClinicalSupport']['Hyptension']=='1'){  ?>
				<tr>
					<?php 
				echo $this->Form->hidden('dname',array('value'=>$d_name));?>
					<td width="20px" ,colspan="2"><h4>
							<?php 
							echo __("Hypertension Intervention");?>
						</h4></td>
				</tr>
				<tr>
					<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Patient Age");?><font
						color="red">*</font>
					</td>
					<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
							border="0">
							<tr>
								<?php $com=array('>'=>'Greater Than','<'=>'less Than');?>
								<?php $com_h_recive=$config_data['0']['ClinicalSupport']['com_h'];?>
								<td><?php echo $this->Form->input('com_h', array('empty'=>__('Select'),'options'=>$com,'selected'=>$com_h_recive,'class' => 'validate[required,custom[mandatory-enter]]','id' => 'test_cancer','label'=>false)); ?>
								</td>
								<td><?php echo $this->Form->input('age', array('class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]]','id' => 'age',
										'label'=>false,'value'=>$config_data['0']['ClinicalSupport']['age'])); ?>
								</td>
								<td width="20px"><?php echo $this->Html->link(__('Blogs', true), array('controller' => 'Doctors', 'action' => 'a') ); ?>
								</td>
								<td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncqa.org/HEDISQualityMeasurement/PerformanceMeasurement.aspx','target' => '_blank'));?>
								</td>
							</tr>
						</table></td>
					<td width="">&nbsp;</td>

				</tr>
				<?php }?>
					<?php if($config_data['0']['ClinicalSupport']['ccr']=='1'){  ?>
				<tr>
					<td width="20px" ,colspan="2"><h4>
							<?php echo __("Cervical Cancer");?>
						</h4></td>
				</tr>
				<tr>
					<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Patient Age");?><font
						color="red">*</font>
					</td>
					<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
							border="0">
							<tr>
								<?php $com=array('>'=>'Greater Than','<'=>'less Than');?>
								<?php $com_c_recive=$config_data['0']['ClinicalSupport']['com_c'];?>
								<td><?php echo $this->Form->input('com_c', array('empty'=>__('Select'),'options'=>$com,'selected'=>$com_c_recive,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'test_cancer','label'=>false)); ?>
								
								<td><?php echo $this->Form->input('c_age', array('class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]]','id' => 'c_age1','label'=>false,'value'=>$config_data['0']['ClinicalSupport']['c_age'])); ?>
								</td>
							
							
							<tr>
								<td align="center"><?php echo __('Range');?></td>
							</tr>

							</tr>
							<tr>
								<?php $com=array('>'=>'Greater Than','<'=>'less Than');?>
								<?php $com_c_recive=$config_data['0']['ClinicalSupport']['com_c1'];?>
								<td><?php echo $this->Form->input('com_c1', array('empty'=>__('Select'),'options'=>$com,'selected'=>$com_c_recive,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'test_cancer','label'=>false)); ?>
								
								<td><?php echo $this->Form->input('c_age1', array('class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]]','id' => 'c_age2','label'=>false,'value'=>$config_data['0']['ClinicalSupport']['c_age1'])); ?>
								</td>

							</tr>
						</table></td>
					<td width="">&nbsp;</td>
					<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Test Name");?><font
						color="red">*</font>
					</td>
					<td width="30%"><?php $test_c_recive=$config_data['0']['ClinicalSupport']['test_c'];?>
						<?php $vals = array('Pap smear'=>'Pap smear','human papillomavirus (HPV) 11 antigen detection'=>'human papillomavirus (HPV) 11 antigen detection');?>
						<?php echo $this->Form->input('test_c', array('empty'=>__('Select'),'options'=>$vals,'selected'=>$test_c_recive,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'test_cancer','label'=>false)); ?>



					</td>
					<td width="20px"><?php echo $this->Html->link(__('Blogs', true), array('controller' => 'Doctors', 'action' => 'b') ); ?>
					</td>
					<td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncqa.org/HEDISQualityMeasurement/PerformanceMeasurement.aspx','target' => '_blank'));?>
					</td>
				</tr>
				<?php }?>
					<?php if($config_data['0']['ClinicalSupport']['dr']=='1'){  ?>
				<tr>
					<td width="20px" ,colspan="2"><h4>
							<?php echo __("Diabetes");?>
						</h4></td>
				</tr>
				<tr>
					<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Patient Age");?><font
						color="red">*</font>
					</td>
					<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
							border="0">
							<tr>
								<?php $com=array('>'=>'Greater Than','<'=>'less Than');?>
								<?php $com_d_recive=$config_data['0']['ClinicalSupport']['com_d'];?>
								<td><?php echo $this->Form->input('com_d', array('empty'=>__('Select'),'options'=>$com,'selected'=>$com_d_recive,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'test_cancer','label'=>false)); ?>
								
								<td><?php echo $this->Form->input('d_age', array('class' =>'validate[required,custom[mandatory-enter],custom[onlyNumber]]','id' => 'd_age3','label'=>false,'value'=>$config_data['0']['ClinicalSupport']['d_age'])); ?>
								</td>

							</tr>
							<tr>
								<td align="center"><?php echo __('Range');?></td>
							</tr>
							<tr>
								<?php $com=array('>'=>'Greater Than','<'=>'less Than');?>
								<?php $com_d_recive=$config_data['0']['ClinicalSupport']['com_d1'];?>
								<td><?php echo $this->Form->input('com_d1', array('empty'=>__('Select'),'options'=>$com,'selected'=>$com_d_recive,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'test_cancer','label'=>false)); ?>
								
								<td><?php echo $this->Form->input('d_age1', array('class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]]','id' => 'd_age4','label'=>false,'value'=>$config_data['0']['ClinicalSupport']['d_age1'])); ?>
								</td>

							</tr>
						</table></td>
					<td width="">&nbsp;</td>
					<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Test Name");?><font
						color="red">*</font>
					</td>
					<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
							border="0">
							<tr>
								<?php $vals = array('Hemoglobin A1c'=>'Hemoglobin A1c','Glucose tolerance test'=>'Glucose tolerance test');?>
								<?php $test_d_recive=$config_data['0']['ClinicalSupport']['test_d'];?>
								<td><?php echo $this->Form->input('test_d', array('empty'=>__('Select'),'options'=>$vals,'selected'=>$test_d_recive,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'test_d','label'=>false)); ?>
								</td>
								<td width="20px"><?php echo $this->Html->link(__('Blogs', true), array('controller' => 'Doctors', 'action' => 'c') ); ?>
								</td>
								<td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncqa.org/HEDISQualityMeasurement/PerformanceMeasurement.aspx','target' => '_blank'));?>
								</td>
							</tr>
						</table></td>

				</tr>
				<?php }?>
				<?php if($config_data['0']['ClinicalSupport']['dmc']=='1'){  ?>
				<tr>
					<td width="20px" ,colspan="2"><h4>
							<?php echo __("Elderly High Risk Medication")?>
						</h4></td>
				</tr>
				<tr>
					<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Patient Age");?><font
						color="red">*</font>
					</td>
					<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
							border="0">
							<tr>
								<?php $com_e=array('>'=>'Greater Than','<'=>'less Than');?>
								<?php $com_e_recive=$config_data['0']['ClinicalSupport']['com_e'];?>
								<td><?php echo $this->Form->input('com_e', array('empty'=>__('Select'),'options'=>$com_e,'selected'=>$com_e_recive,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'test_cancer','label'=>false)); ?>
								</td>
								<td><?php echo $this->Form->input('age_e', array('class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]]','id' => 'age5',
										'label'=>false,'value'=>$config_data['0']['ClinicalSupport']['age_e'])); ?>
								</td>
								<td width="20px"><?php echo $this->Html->link(__('Blogs', true), array('controller' => 'Doctors', 'action' => 'd') ); ?>
								</td>
								<td width="20px"><?php echo $this->Html->image('/img/icons/infobutton.png',array('url' =>'http://www.ncqa.org/HEDISQualityMeasurement/PerformanceMeasurement.aspx','target' => '_blank'));?>
								</td>
							</tr>
						</table></td>
					<td width="">&nbsp;</td>
<?php }?>
				</tr>
				<!--  <tr>
					<td width="20px" ,colspan="2"><h4>
							<?php echo __("Name not decided ")?>
						</h4></td>
				</tr>
				<tr>
					<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php echo __("Patient Age");?>
					</td>
					<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
							border="0">
							<tr>
								<?php $com_nnd=array('>'=>'Greater Than','<'=>'less Than');?>
								<?php $com_nnd_recive=$config_data['0']['ClinicalSupport']['com_nnd'];?>
								<td><?php echo $this->Form->input('com_nnd', array('empty'=>__('Select'),'options'=>$com_nnd,'selected'=>$com_nnd_recive,'class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'test_cancer','label'=>false)); ?></td>
								<td>	<?php echo $this->Form->input('age_nnd', array('class' => 'validate[required,custom[mandatory-enter],custom[onlyNumber]]','id' => 'age',
										'label'=>false,'value'=>$config_data['0']['ClinicalSupport']['age_nnd'])); ?>
								</td>

							</tr>
						</table></td>
					<td width="">&nbsp;</td>

				</tr> -->
				<?php if($config_data['0']['ClinicalSupport']['dmc']=='1'|| $config_data['0']['ClinicalSupport']['dr']=='1' || $config_data['0']['ClinicalSupport']['ccr']=='1' || $config_data['0']['ClinicalSupport']['Hyptension']=='1' ){  ?>
				<tr>
					<td><?php  echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'makd'));?>
					</td>
				</tr>
				<?php }?>
			</table>
			<script>
jQuery(document)
.ready(
		
		function() {

			// binds form submission and fields to the validation engine
			// detach validations for emergency patients
			

					//jQuery("#personfrm").validationEngine();
					 jQuery("#frm1").validationEngine({
				            validateNonVisibleFields: true,
				            updatePromptsPosition:true,
				        });

			$('#makd')
					.click(
							function() {
								var validatePerson = jQuery(
										"#frm1")
										.validationEngine(
												'validate');
								if (validatePerson) {
									$(this).css('display', 'none');
								}
							});
		});
								</script>