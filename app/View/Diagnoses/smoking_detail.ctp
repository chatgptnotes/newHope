<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
			<?php  	
					echo $this->Html->css(array('internal_style','jquery.autocomplete'));
					echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css'));  
	 echo $this->Html->script(array( 'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4'));
			?>
</head>
<body>
<div class="inner_title"> 
			<h3><?php echo __('Smoking Details'); ?> </h3>
			
</div>		
		<div class="patient_info">
						
			
				<table border="0"    cellpadding="0" cellspacing="2" width="100%" style="text-align:center;">
				 <tr>				
					   <td><strong><?php echo __('Previous Status'); ?></strong></td> 				   					   
				  </tr> 			
				   <tr>
				 		<td>&nbsp;</td>
				 	</tr> 	
				 <tr class="row_title row_gray_dark">				
					   <td class="table_cell"><strong><?php echo  __('Snomed Code', true); ?></strong> : </td>
					   				<td>
								 		<?php			echo $detail['SmokingStatusOncs1']['snomed_id']; 	?> </td>	   					   
				  </tr> 			
				   <tr>
				 		<td>&nbsp;</td>
				 	</tr> 
				  <tr class="row_title row_gray_dark">				
					   <td class="table_cell"><strong><?php echo  __('Current Status', true); ?></strong> : </td>
					   				<td>
								 		<?php			echo $detail['SmokingStatusOncs1']['description']; 	?> </td>	   					   
				  </tr>
				 	<tr>
				 		<td>&nbsp;</td>
				 	</tr>						  
					 <tr class="row_title row_gray_dark">				
					   <td class="table_cell"><strong><?php echo  __('Description', true); ?></strong> : </td>
					   				<td>
								 		<?php			echo $detail['SmokingStatusOncs1']['detail']; 	?> </td>	   					   
				  </tr>   	
				  
				 						  
							 
					   		
				 
		</div>
		
		<div class="patient_info">
						
			
				<table border="0"    cellpadding="0" cellspacing="2" width="100%" style="text-align:center;">
				<tr>
				 		<td>&nbsp;</td>
				 	</tr> 
				 <tr>				
					   <td><strong><?php echo __('Current Status'); ?></strong></td> 				   					   
				  </tr> 			
				   <tr>
				 		<td>&nbsp;</td>
				 	</tr> 	
				 <tr class="row_title row_gray_dark">				
					   <td class="table_cell"><strong><?php echo  __('Snomed Code', true); ?></strong> : </td>
					   				<td>
								 		<?php			echo $detail['SmokingStatusOncs']['snomed_id']; 	?> </td>	   					   
				  </tr> 			
				   <tr>
				 		<td>&nbsp;</td>
				 	</tr> 
				  <tr class="row_title row_gray_dark">				
					   <td class="table_cell"><strong><?php echo  __('Current Status', true); ?></strong> : </td>
					   				<td>
								 		<?php			echo $detail['SmokingStatusOncs']['description']; 	?> </td>	   					   
				  </tr>
				 	<tr>
				 		<td>&nbsp;</td>
				 	</tr>						  
					 <tr class="row_title row_gray_dark">				
					   <td class="table_cell"><strong><?php echo  __('Description', true); ?></strong> : </td>
					   				<td>
								 		<?php			echo $detail['SmokingStatusOncs']['detail']; 	?> </td>	   					   
				  </tr>   	
				  
				 						  
							 
					   		
				 
		</div>
	</body>
	</html>	