<?php
//echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min'));
//echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
//echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
echo $this->Html->css(array('internal_style.css'));
//echo $this->Html->script(array('/theme/Black/js/jquery.ui.widget.js','/theme/Black/js/jquery.ui.mouse.js','/theme/Black/js/jquery.ui.core.js','/theme/Black/js/ui.datetimepicker.3.js',
	//	'/theme/Black/js/permission.js','/theme/Black/js/pager.js'));
?>
<html>
<div class="inner_title">
	<h3 align="center">
		&nbsp;
		<?php  if($get_details !=""){
		 echo __('Drug Information for '.$get_details, true);	
		}else {?>
	<?php echo __('Drug Information' , true);	} ?>
	</h3>

</div>


<?php
if($get_details ==""){ ?>
<p align="center"><font color="red"><?php
echo __("No Records Founds");}
else{

	?></font></p>
<p align="center">
<strong>
<?php 
echo $get_details."&nbsp";	?></strong>
<a  target="_blank" href="<?php echo $new_url;?>"><u>View details</u></a><?php }?></p>
</html>