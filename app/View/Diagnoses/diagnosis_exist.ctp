<?php
echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('/theme/Black/js/jquery.ui.widget.js','/theme/Black/js/jquery.ui.mouse.js','/theme/Black/js/jquery.ui.core.js','/theme/Black/js/ui.datetimepicker.3.js',
		'/theme/Black/js/permission.js','/theme/Black/js/pager.js'));
?>
<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; ?>
</title>

</head>
<body>

	<div class="inner_title">
		<h3>
			&nbsp;
			<?php echo __('Make a diagnosis', true);
						?>
		</h3>

	</div>
	
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="500px">
		<tr class="row_title">
			<td class="patientHub" width="500px" cellpadding="5px"
				valign="bottom" colspan='2'><strong> <?php echo __('Patient Diagnosis Already Exists') ?>
					</strong>
					</td>
					</tr>
			
	</table>
	<?php echo $this->Form->end(); ?>
</body>

