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
 
	.cardArea{width:330px; height:180px; border:1px solid #CCCCCC; padding:10px 20px;}
	.cardLeft{width:330px; float:left;}
	.cardRight{width:100px; float:right; padding-top:15px;}
	.cardName{font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:bold; text-decoration:none; color:#000000; margin:0; padding:0; letter-spacing:-0.5px;}
	.hospName{font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; text-decoration:none; color:#333333; margin:0; padding:0 0 1px 0;}
	.hospAddress{font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:normal; text-decoration:none; color:#333333; margin:0; padding:0;}
	#printButton{
		float:right;
		margin-top:10px;
	}
	@media print {

  		#printButton{display:none;}
   }
 
</style>
</head> <!--  onload="window.print();window.close();" -->
<body style="background:#fff;color:#000" >
		<div id="printButton">
                     <a href="#" class="blueBtn" onclick="window.print();window.close();"><?php echo __('Print'); ?></a>
                </div>
		<div class="cardArea">
			<div class="cardLeft"> 
		    	<?php 
		    	$complete_name  = $patient[0]['lookup_name'] ;
				
		    	 ?>
		    	<table width="150" height="150" border="0" cellpadding="0" cellspacing="0"   align="right">
		    		<tr>
		    			<td valign="top" class="cardName"><?php echo __('Token No.'); ?></td>
		    		</tr>
		    		<tr>
		    			<td valign="top" class="cardName" style="border:1px solid;padding:20px;font-size:60px;text-align:center;"><?php echo $token ;?></td>
		    		</tr>
		    	</table>
				<p class="cardName"><?php 
				echo $complete_name ;?></p>
		        <p class="hospName"><?php echo $hospital['Facility']['name'] ; ?></p>   
		        <!--<p class="hospAddress"><?php echo Configure::read('doctor');?>:&nbsp;<?php echo $doctor_name ;?>  </p>
		        --><p class="hospAddress"><?php echo __('MRN'); ?>:&nbsp;<?php echo $patient['Patient']['admission_id'] ;?>  </p>     
		        <p class="hospAddress"><?php 
					    		echo $address ;
					    	?></p>    
		        <p class="hospAddress"><?php echo __('Age'); ?>:&nbsp;<?php echo $age." Yrs";?></p>
		        <p class="hospAddress"><?php echo __('Sex'); ?>:&nbsp;<?php echo ucfirst($sex);?></p>
		        <p class="hospAddress"><?php echo __('Blood Group'); ?>: &nbsp;<?php echo $blood_group ;?></p> 
			 </div>
		    
		</div>
				    			 
		</body>
</html>
