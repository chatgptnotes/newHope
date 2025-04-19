<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));      
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
									'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));?>
<?php $role = $_SESSION['role'];?>
<?php if($role == 'Patient'){?>
<?php echo $this->element('portal_header');?>
<!--  <div align="right" > <a href="#" id="change_login_date"><?php echo __("Change Login Date");?></a></div>-->
<?php }?>

<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
 <tr>
  <td colspan="2" align="center">
   <h2><?php // echo __('Welcome',true);
   //&& $patient['Patient']['is_discharge']==0  ?> </h2>
  </td>
  
 </tr>
 <tr>
 </table>
 <?php //echo '<pre>';print_r($_SESSION['Auth']['User']['patient_uid']);exit;?>
 <script>
 $('#change_login_date')
	.click(
			function() { 
				//	var patient_id = $('#selectedPatient').val();

				
						$.fancybox({
							'width' : '70%',
							'height' : '90%',
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe',
							'onComplete' : function() {
								$("#allergies").css({
									'top' : '20px',
									'bottom' : 'auto',
									
								});
							},
							'href' : "<?php echo $this->Html->url(array("controller" => "messages", "action" => "changeLoginDate",$_SESSION['Auth']['User']['patient_uid'])); ?>"

						});

			});
 </script>