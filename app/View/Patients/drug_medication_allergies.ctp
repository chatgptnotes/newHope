<?php
echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('/theme/Black/js/jquery.ui.widget.js','/theme/Black/js/jquery.ui.mouse.js','/theme/Black/js/jquery.ui.core.js','/theme/Black/js/ui.datetimepicker.3.js',
		'/theme/Black/js/permission.js','/theme/Black/js/pager.js'));
?>
<html>
<div class="inner_title">
	<h3 align="center">
		&nbsp;
		
		 
		
	<?php echo __('Message: Because of its potiential for side effect and higher incidence of medication allergy it is not advisable to use in the elderly.' , true);	 ?>
	<?php echo "<br/>"?>
	<font color ='red'><?php echo __('Please use alternative listed below.' , true);	 ?></font>
	</h3>

</div>   
	<table width="50%" cellpadding="0" cellspacing="0" border="0"
				align='left' class="formFull formFullBorder">
						
						<?php if(!empty($medi_name)){ ?>
						<tr>
							<td><strong> <?php echo __(" ");?>
							</strong></td>
							<td><strong> <?php echo __("Medication Name");?>
							</strong></td>
							<td><strong> <?php echo __("Alternative Medication Name");?>
							</strong></td>
							
						</tr>


						<tr>
							<?php 	/*  echo "<pre>"; print_r($get_lab); exit  */;if($medi_name==0){ ?>
							<td>No data recorded</td>
						</tr>
						<?php } ?>
						<?php foreach($medi_name as $medi_names){
							$medicine_name=$medi_names['Highrisk']['medicine_name'];
							$alternative_medi=$medi_names['Highrisk']['alternative_medi'];

							?>
						<tr>
							<td><?php echo "<tr><td width='40%'>". " " ."</td>"; echo "<td width='40%'>". $medi_names['Highrisk']['medicine_name']."</td>"; echo "<td width='40%'>". $medi_names['Highrisk']['alternative_medi']."</td></tr>";
						} ?> 
							<?php }?>
							</td>
						</tr>
						
					</table>


</html>

