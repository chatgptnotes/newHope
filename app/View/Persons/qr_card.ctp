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
</style>
<style>
	a {
		color:blue;
	}
	a:hover{
		color:blue;
	} 
	 /*.cardArea{width:330px; height:180px; border:1px solid #CCCCCC; padding:10px 20px;} */
	.cardArea{width:330px; height:200px;padding:4px;} 
	.cardLeft{width:225px; float:left;}
	.cardRight{width:100px; float:right;padding-right:4px;}
	.cardName{font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; text-decoration:none;  margin:0; padding:0; letter-spacing:-0.5px;}
	.hospName{font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; text-decoration:none;  margin:0; padding:0 0 2px 0;}
	.hospAddress{font-family:Arial, Helvetica, sans-serif; 
				font-size:8px; font-weight:bold; text-decoration:none; margin:0; padding:0;}
	
	@media print {
	#printButton {
		display: none;
	}
}
</style>

</head> <!--  onload="window.print();window.close();" -->
<div style="float: right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
<body style="background:#fff;color:#000"  >
<div class="cardArea">
	<div class="cardLeft"> 
    	<p class="cardName"> 
    		<?php
    			$complete_name  = ucfirst($person['Initial']['name'])." ".ucfirst($person['Person']['first_name'])." ".ucfirst($person['Person']['last_name']) ;
    			$ageSex = $person['Person']['age']." / ".ucfirst($person['Person']['sex']) ; 
    			echo $complete_name." ($ageSex)" ;
    		?>
    	</p>
        <p class="hospName"><?php echo $hospital['Facility']['name'] ; ?></p>   
        <p class="hospAddress">Patient ID:&nbsp;<?php echo $person['Person']['patient_uid'] ;?>  </p>
        <?php if(!empty($address)) { ?>   
        <p class="hospAddress"><?php  echo $address ; ?></p>
        <?php } ?>
        <?php if(!empty($person['Person']['mobile'])){ ?>  
        	<p class="hospAddress">Phone:&nbsp;<?php echo ($person['Person']['mobile']=='')?__(''):$person['Person']['mobile'] ;?></p>
        <?php } ?>
        <?php if(!empty($person['Person']['blood_group'])){ ?> 
        	<p class="hospAddress">Blood Group:&nbsp;<?php echo ($person['Person']['blood_group']=='')?__(''):$person['Person']['blood_group'] ;?></p>
        <?php } ?>
        <?php if(!empty($company)) {?>
		        	<p class="hospAddress">Category: &nbsp;<?php echo $company ;?></p>
		<?php } ?>
		
        <?php 
        	if(!empty($person['Person']['relative_name'])) {
        		$relativeLabel = "Relative's Name"  ;
        		$relativeValue = $person['Person']['relative_name'] ;
        	//<p class="hospAddress">Relative's Name: 
            }else if(!empty($person['Person']['relative_phone'])){
            	$relativeLabel = "Relative's Phone"  ;
            	$relativeValue = $person['Person']['relative_phone'] ;
            }
              
            if(!empty($person['Person']['relative_name']) && !empty($person['Person']['relative_phone'])){
        		$relativeLabel .=  "/Phone" ;
        		$relativeValue .= "/".$person['Person']['relative_phone'] ;
        	}
	        if(!empty($person['Person']['relative_name']) || !empty($person['Person']['relative_phone'])){     
	          
	        	echo '<p class="hospAddress">';
	        	echo $relativeLabel.": " ;
	        	echo $relativeValue ;
	        	echo '</p>'; 
	        }
	        
	        if(!empty($doctor_name)) {
        		$famLabel = "Family Physician "  ;
        		$famValue = $doctor_name ; 
            }else if(!empty($person['Person']['family_phy_con_no'])){
            	$famLabel = "Family Physician Phone"  ;
            	$famValue = $person['Person']['family_phy_con_no'] ;
            } 
            if(!empty($doctor_name) && !empty($person['Person']['family_phy_con_no'])){
        		$famLabel .=  "/Phone" ;
        		$famValue .= "/".$person['Person']['family_phy_con_no'] ;
        	}
	        if(!empty($doctor_name) || !empty($person['Person']['family_phy_con_no'])){      
	        	echo '<p class="hospAddress">';
	        	echo $famLabel.": " ;
	        	echo $famValue ;
	        	echo '</p>'; 
	        }
	  
         if(!empty($person['Person']['allergies'])){ ?>
        	<p class="hospAddress">Allergies: &nbsp;<?php echo $person['Person']['allergies'] ;?></p>
        <?php } ?>
        <?php if(!empty($person['Person']['instruction'])){ ?>
	        <p class="hospAddress">Instructions: &nbsp;<?php
	   			$instructions = array('Diabetic'=>'Diabetic- If found Unconscious give sugar/sweet/chocolate.','Epileptic'=>'Epileptic- In case of attack/fit turn patient to one side & refrain from feeding.','High Blood Pressure'=>'High Blood Pressure- If found unconscious or paralyzed, turn patient to one side & refrain from feeding.','Low Blood Pressure'=>'Low Blood Pressure- In case of vertigo keep head in low position & take plenty of fluids.','Cardiac Problem'=>'Cardiac Problem- In case of symtoms like chest pain or sweating administer Tablet Disprin & sublingual Tablet Sorbitrate.','Asthma'=>'Asthma- In case of acute attack administer 2 puffs of Scroflo inhaler & shift to hospital.');
	        	echo $instructions[$person['Person']['instruction']] ;
	        	?></p>
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
			 
			if(!empty($person['Person']['photo'])){
				echo $this->Html->image("/uploads/patient_images/thumbnail/".$person['Person']['photo'], 
				array('alt' => $complete_name,'title'=>$complete_name,'width'=>'80','height'=>'80','style'=>'float:right'));
	    		 
	 	    } 
	 	    echo "<br />" ;
	 	    if(file_exists(WWW_ROOT."uploads/qrcodes/".$person['Person']['patient_uid'].".png")){  
	    		 echo $this->Html->image("/uploads/qrcodes/".$person['Person']['patient_uid'].".png", array('alt' => $complete_name,'title'=>$complete_name,'width'=> '80', 'height' => '80','style'=>'float:right'));  
	         }
 	    ?>
    </div>
</div>

 
		</body>
</html>
