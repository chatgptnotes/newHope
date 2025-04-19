<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
			<?php echo $this->Html->css(array('internal_style.css')); ?>
</head>
<body style="background:none;">
	<?php
			$complete_name  = ucfirst($patient['Initial']['name'])." ".ucfirst($patient['Patient']['first_name'])." ".ucfirst($patient['Patient']['last_name']) ;
			//echo __('Set Appoinment For-')." ".$complete_name;
	?> 
	
		 
	<?php 
	  if(!empty($errors)) {
	?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	 <tr>
	  <td colspan="2" align="left" class="error">
	   <?php 
	     foreach($errors as $errorsval){
	         echo $errorsval[0];
	         echo "<br />";
	     }
	   ?>
	  </td>
	 </tr>
	</table>
	<?php } ?>
	<div class="inner_left">
    	<div class="title">Patient Information</div>
	 		<div class="patient_info">
	    		<table>
	    		<tr>
	    				<td valign="top">
	    					<table>
		    					<?php if($patient['Patient']['photo']){   ?>
		    					<tr>
		    					
			    					<td width="100px" valign="top" align="center" rowspan="5">
			    						<?php echo $this->Html->image("/uploads/patient_images/thumbnail/".$patient['Patient']['photo'], array('alt' => $complete_name,'title'=>$complete_name)); ?>
			    					</td>
			 					</tr>
			 					<?php } ?> 					
			 					<tr>
									<td valign="top" align="right"><strong>Name :</strong></td><td valign="top" align="left"><?php echo $complete_name ;?></td>
								</tr>				    
								<tr>				 
									<td valign="top" align="right">
										<strong>Address :</strong>
									</td>
									<td valign="top" n="left" alig="">
										 
								    	<?php 
								    		echo $address ;
								    	?>
								  	</td>
								 </tr>
								 <tr>
								 
								 <td valign="top" align="right">
								 	<strong>Last Appointment :</strong>
								 </td>
								 <?php if(!empty($patient['Patient']['last_appointment'])){
								 			$dateFormat = Configure::read('date_format');
								 	   		$convertToTime = strtotime($patient['Patient']['last_appointment']);
								 	   		echo "<td>".date('d/m/Y',$convertToTime)."</td>";
								 	   }else{
								  	   		echo "<td>--/--/--</td>";
								  	   }
								  	   ?>
								  </tr>						    
								  <tr>						 
									 <td valign="top" align="right"><strong>Account Balance :</strong></td>
								 	 <?php if(!empty($patient['Patient']['account_balance'])){									 			 
								 	   		echo "<td>".$patient['Patient']['account_balance']."</td>";
								 	   }else{
								  	   		echo "<td>--.--.--</td>";
								  	   }
								  	   ?>									 	
								</tr>	
							</table>
	    				</td>
	    				<td valign="top">
	    					<table>
	    						<?php if(file_exists(WWW_ROOT."uploads/qrcodes/".$patient['Patient']['patient_id'].".png")){ ?>
			    				<tr>
			    					
			    					<td width="100px" valign="top" align="center" rowspan="5">
			    						<?php echo $this->Html->image("/uploads/qrcodes/".$patient['Patient']['patient_id'].".png", array('alt' => $complete_name,'title'=>$complete_name)); ?>
			    					</td>
			 					</tr>
			 					<?php  } ?>
			 				</table>
	    				</td>
	    				</tr>
	    		</table> 
			</div> 
			</div>
			<div class="clr"></div>
			
<table width="100%"><tr>
<td width="80%">

<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  
  <tr class="row_title">
  <td class="table_cell"><strong><?php echo __('Bed', true); ?> </strong></td>
  <td class="table_cell"><strong><?php echo __('Name', true); ?></strong></td>
  <td class="table_cell"><strong><?php echo __('Date of Birth', true); ?></strong></td>
  <td class="table_cell"><strong><?php echo __('Admisson No.', true); ?></strong></td>
  <td class="table_cell"><strong><?php echo __('Actions', true); ?></strong></td>
  </tr>
  
  <?php 
  $toggle = 0;
  for($i=1; $i <= $data['Room']['no_of_beds']; $i++) { 
  	if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
	
  <?php if($data['Room']['bed_prefix'] != '') { ?>
  <td class="row_format"><?php echo $data['Room']['bed_prefix'].$i;?> </td>
  <?php }else{ ?>
  <td><?php echo $i;?> </td>
  <?php } ?>
  
  <?php #echo '<pre>';print_r($data['Room']['id']);exit;
  	$isAssigned = 0;
  	foreach($patientsData as $patient){
  	
  		if($patient['Patient']['bed_id'] == $i){
  			echo '<td class="row_format">'.$patient['Patient']['last_name'].'&nbsp;'. $patient['Patient']['first_name'].'</td>';
  			echo '<td class="row_format">'.$patient['Patient']['dob'].'</td>';
  			echo '<td class="row_format">'.$patient['Patient']['admission_id'].'</td>';
  			echo '<td class="row_format">Action</td></tr>';
  			$isAssigned =1;
  			break;
  		}
  	}
  	
   if($isAssigned == 0){
  		echo '<td>';
  		echo $this->Html->link($this->Form->button(__('Assign', true), array('type' => 'button','class' => 'blueBtn', 'onclick' => 'window.opener.location.reload();')), array('action' => 'assignBed', $i,$patient['Patient']['id'],$data['Room']['id']), array('escape' => false));
  		echo '</td>';
  		echo '<td>&nbsp;</td>';
  		echo '<td>&nbsp;</td>';
  		echo '<td>';
  		#echo $this->Html->link($this->Html->image("icons/ward_assign.gif"), array('action' => 'add', $data['Room']['id']), array('escape' => false),__('Are you sure?', true));
   		echo '&nbsp;</td>';
  		echo '</tr>';
  	}
  	
  ?> 
  </tr>
  <?php } ?>
 
  
 </table>
 </body>
</html>
	