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
<body style="background:#fff;color:#000" >
<div id="printButton" style="float: right;  padding: 20px;"><?php 

		echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
		?></div>
		<div class="cardArea">
			<div class="cardLeft"> 
		    	<?php $complete_name  = $patient[0]['lookup_name'] ; ?>
				<p class="cardName"><?php
					$ageSex = $patient['Patient']['age']." / ".ucfirst($patient['Patient']['sex']) ; 
    				echo $complete_name." ($ageSex)" ;
				?></p>
		        <p class="hospName"><?php echo $hospital['Facility']['name'] ; ?></p>   
		        <p class="hospAddress"><?php echo __("Visit ID")?>:&nbsp;<?php echo $patient['Patient']['admission_id'] ;?>  </p>
		        <?php if(!empty($address)) { ?>     
		        	<p class="hospAddress"><?php echo $address ;?></p>
		        <?php } ?> 
		        <?php if(!empty($phone)){ ?>   
		        	<p class="hospAddress">Phone:&nbsp;<?php echo $phone ;?></p>
		        <?php } ?>
		        <?php if(!empty($blood_group)) {?>
		        	<p class="hospAddress">Blood Group: &nbsp;<?php echo $blood_group ;?></p>
		        <?php } ?>
		        
		        <?php if(!empty($company)) {?>
		        	<p class="hospAddress">Category: &nbsp;<?php echo $company ;?></p>
		        <?php }  
		        
		       
		        if(!empty($relatives_name)) {
	        		$relativeLabel = "Relative's Name"  ;
	        		$relativeValue = $relatives_name ;
		        	//<p class="hospAddress">Relative's Name: 
	            }else if(!empty($relatives_phone_no)){
	            	$relativeLabel = "Relative's Phone"  ;
	            	$relativeValue = $relatives_phone_no ;
	            }
	              
	            if(!empty($relatives_name) && !empty($relatives_phone_no)){
	        		$relativeLabel .=  "/Phone" ;
	        		$relativeValue .= "/".$relatives_phone_no ;
	        	}
		        if(!empty($relatives_name) || !empty($relatives_phone_no)){     
		          
		        	echo '<p class="hospAddress">';
		        	echo $relativeLabel.": " ;
		        	echo $relativeValue ;
		        	echo '</p>'; 
		        }
		        
		        if(!empty($doctor_name)) {
	        		$famLabel = "Family Physician "  ;
	        		$famValue = $doctor_name ; 
	            }else if(!empty($doctor_phone)){
	            	$famLabel = "Family Physician Phone"  ;
	            	$famValue = $doctor_phone ;
	            } 
	            if(!empty($doctor_name) && !empty($doctor_phone)){
	        		$famLabel .=  "/Phone" ;
	        		$famValue .= "/".$doctor_phone ;
	        	}
		        if(!empty($doctor_name) || !empty($doctor_phone)){      
		        	echo '<p class="hospAddress">';
		        	echo $famLabel.": " ;
		        	echo $famValue ;
		        	echo '</p>'; 
		        }
	        
	       if(!empty($allergies)) {?>
		        	 <p class="hospAddress">Allergies: &nbsp;<?php echo $allergies ;?></p>
		        <?php } ?>
		        <?php if(!empty($patient['Patient']['instructions'])) { ?>
		        	 <p class="hospAddress">Instructions: &nbsp;<?php 
		        	 $instructions = array(
		        	 				'Diabetic'=>'Diabetic- If found Unconscious give sugar/sweet/chocolate.',
		        	 			    'Epileptic'=>'Epileptic- In case of attack/fit turn patient to one side & refrain from feeding.',
		        	 			    'High Blood Pressure'=>'High Blood Pressure- If found unconscious or paralyzed, turn patient to one side & refrain from feeding.',
		        	 			    'Low Blood Pressure'=>'Low Blood Pressure- In case of vertigo keep head in low position & take plenty of fluids.',
		        	 			    'Cardiac Problem'=>'Cardiac Problem- In case of symtoms like chest pain or sweating administer Tablet Disprin & sublingual Tablet Sorbitrate.',
		        	 			    'Asthma'=>'Asthma- In case of acute attack administer 2 puffs of Scroflo inhaler & shift to hospital.');
        			echo $instructions[$patient['Patient']['instructions']] ;?></p>   
		        <?php } ?> 
		        <p class="hospAddress" style="width:80px;float:left;padding:6px 0px;">Signature: </p>
				<div style="border: 1px solid rgb(0, 0, 0); padding: 10px; float: right; width: 122px;"></div> 
				<p style="width: 325px; position: absolute; top: 0px; margin-top: 174px;" class="hospAddress"> 
					Card is a property of <?php echo ucwords($this->Session->read('facility'));?> and must be returned on request.
					Use confirms acceptance of terms and conditions of schemes and benefits
					hereafter.<br>Report loss of card to <?php echo ucwords($this->Session->read('facility'));?>.
				</p>
			 </div>
		     <div class="cardRight">
		    	<?php
					if(!empty($photo)){
						echo $this->Html->image("/uploads/patient_images/thumbnail/".$photo, 
						array('alt' => $complete_name,'title'=>$complete_name,'width'=>'80','height'=>'80','style'=>'float:right'));
			 	    } 
			 	    echo "<br />" ;
			 	    if(file_exists(WWW_ROOT."uploads/qrcodes/".$patient['Patient']['admission_id'].".png")){ ?> 
    						<?php echo $this->Html->image("/uploads/qrcodes/".$patient['Patient']['admission_id'].".png", 
    						array('style'=>'float:right','alt' => $complete_name,'title'=>$complete_name, 'width'=> '80', 'height' => '80')); 
			 	    }
		 	    ?>
		    </div>
		</div>
				    			 
		</body>
</html>
