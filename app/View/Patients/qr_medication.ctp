<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; //onload="window.print();window.close();"?>
</title>
			<?php echo $this->Html->css(array('internal_style.css')); ?>
<style>
	a {
		color:blue;
	}
	a:hover{
		color:blue;
	}
 
	.cardArea{width:330px; height:200px;padding:4px;} 
	.cardLeft{width:225px; float:left;}
	.cardRight{width:100px; float:right;padding-right:4px;}
	.cardName{font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; text-decoration:none;  margin:0; padding:0; letter-spacing:-0.5px;}
	.hospName{font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; text-decoration:none;  margin:0; padding:0 0 2px 0;}
	.hospAddress{font-family:Arial, Helvetica, sans-serif; 
				font-size:8px; font-weight:bold; text-decoration:none; margin:0; padding:0;}
	
 
</style>
</head> <!--  onload="window.print();window.close();" -->
<body style="background:#fff;color:#000" onload="window.print();">
		<div class="cardArea">
			<div class="cardLeft"> 
		    	<?php $complete_name  = $patient[0]['lookup_name'] ; ?>
				<p class="cardName"><?php
					$ageSex = $patient['Patient']['age']." / ".ucfirst($patient['Patient']['sex']) ; 
    				echo $complete_name." ($ageSex)" ;
				?></p>
		        <p class="hospName"><?php echo $hospital['Facility']['name'] ; ?></p>   
		        <p class="hospAddress"><?php echo __("MRN")?>:&nbsp;<?php echo $patient['Patient']['admission_id'] ;?>  </p>
		       
		        <?php if(!empty($blood_group)) {?>
		        	<p class="hospAddress">Blood Group: &nbsp;<?php echo $blood_group ;?></p>
		        <?php } ?>
		         <?php if(!empty($medication)) { ?>     
		        	<p class="hospAddress"><?php echo __("Medications")?>:&nbsp;<?php echo $medication ;?></p>
		        <?php } ?> 
		        
		        
		        <p class="hospAddress" style="width:80px;float:left;padding:6px 0px;">Signature: </p>
				<div style="border: 1px solid rgb(0, 0, 0); padding: 10px; float: right; width: 122px;"></div> 
				
			 </div>
		     <div class="cardRight">
		    	<?php 
				//if(file_exists(DS."uploads".DS."qrcodes".DS."medicationQrCode".DS."medicationQR".DS.$patient_uid.".png")){ ?> 
					<?php //echo WWW_ROOT."uploads".DS."qrcodes".DS."medicationQrCode".DS."medicationQR".DS.$patient_uid.".png";?>
    						<?php echo $this->Html->image("/uploads/qrcodes/medicationQrCode/medicationQR/".$patient['Patient']['patient_id'].".png", 
    						array('style'=>'float:right','alt' => $complete_name,'title'=>$complete_name, 'width'=> '80', 'height' => '80')); 
			 	// }
		 	    ?>
		    </div>
		</div>
				    			 
		</body>
</html>
