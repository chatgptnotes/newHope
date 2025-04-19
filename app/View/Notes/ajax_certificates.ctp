<style>
a.blueBtn {
    padding: 4px 3px; 
}
.interIconLink .iconLink{
	min-height:40px;
}
.interIconLink{
	height:160px;
}
</style>
<?php
	//BOF print OPD patient sheet
	if(isset($this->params->query['registration']) && $this->params->query['registration']=='done'){  
		echo "<script>var win = window.open('".$this->Html->url(array('action'=>'opd_patient_detail_print',$patientId))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  </script>"  ;
		?>
		<script> 
			if (!win)
			    alert("Please enabled popups to continue.");
			else {
				win.onload = function() {
			        setTimeout(function() {
			            if (win.screenX === 0) {
			                alert("Please enabled popups to continue.");
			            } else {
			                // close the test window if popups are allowed.
			            	//window.location='<?php echo $this->Html->url(array('action'=>'patient_information',$patientId));?>' ;  
			            }
			        }, 0);
			    };
			} 
		</script>
	<?php 
	}
	//EOF print OPD patinet sheet
	
	 ?>
<div class="inner_title">
	<?php 
			$complete_name  = $patient[0]['lookup_name'] ;
			//echo __('Set Appoinment For-')." ".$complete_name;
	?> 
</div> 
	 
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
				   <div class="internalIcon">
				<?php ?>
                   <!-- <div class="tdLabel2">OPD</div> -->
                
                   <div class="interIconLink">
						<div class="icon">
							<?php echo $this->Html->link($this->Html->image('/img/icons/police-form.jpg'), array('controller'=>'patients','action' => 'police_forms',$patientId,'?'=>array('return'=>'patientInfo')),
						 	array('escape' => false,'title'=>'Police Form','target'=>'_blank'));?></div>
						<div class="iconLink"><?php echo __('Police Form'); ?></div>
                   </div> 
                   <!-- <div class="tdLabel2">IPD</div> -->
                 
                   
                   <div class="interIconLink">
						<div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/consent-form.png'), array('controller'=>'consents','action' => 'index',$patientId),
								 array('escape' => false,'title'=>'Consent Form','target'=>'_blank'));	?></div>                      
                        <div class="iconLink">Consent Form</div>
                   </div>
                		<div class="interIconLink" >
			<div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/tracheostomy-consent.jpg'), array('controller'=>'nursings','action' => 'tracheostomy_consent_list',$patientId), 
					array('admin'=>false,'escape' => false,'title'=>'Tracheostomy Consent Form','target'=>'_blank'));	?></div>
			<div class="iconLink"><?php echo __('Tracheostomy Consent Form');?></div>
			
			   </div>
			<div class="interIconLink" >
			<div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/ventilator-consent.jpg'), array('controller'=>'nursings','action' => 'ventilator_consent_list',$patientId),
					 array('escape' => false,'title'=>'Ventilator Consent Form','target'=>'_blank'));	?></div>
			<div class="iconLink"><?php echo __('Ventilator Consent Form');?></div>
	  </div> 
                   
                    <div class="interIconLink">
						 <div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/hia-assessment.png'), array('controller'=>'hospital_acquire_infections','action' => 'index',$patientId),
						 		 array('escape' => false, 'title'=>'HAI Assessment', 'alt'=>'HAI Assessment','target'=>'_blank'));?></div>
                        <div class="iconLink">HAI Assessment</div>
                   </div>
                   <?php if($patient['Patient']['is_discharge']==0){ ?>
                    <div class="interIconLink">
						<div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/patient-survey.png'), array('controller'=>'surveys','action' => 'patient_surveys',$patientId),
								 array('escape' => false,'title'=>'IPD Patient Survey','target'=>'_blank'));?></div>
						<div class="iconLink">Patient Survey</div>
                   </div>
                   <?php } ?>
                    <div class="interIconLink">
						<div class=""><?php echo $this->Html->link($this->Html->image('/img/icons/incident-form.png'), array('controller'=>'incidents','action' => 'add',$patientId), 
								array('escape' => false,'title'=>'Incident Form','target'=>'_blank'));?></div>
						<div class="iconLink">Incident Form</div>
                   </div>
                   <div class="interIconLink">
						<div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/nursing/dietary-assessment.jpg'), array('controller'=>'nursings','action' => 'dietaryAssessment',$patientId,'patients'),
								 array('escape' => false,'title'=>'Dietary Assessment','target'=>'_blank'));?></div>
						<div class="iconLink">Dietary Assessment</div>
	           	   </div>
	           	   <?php if($patient['Patient']['sex']=='female'){ ?>
	           	   <div class="interIconLink">
                   		<div class="icon">
                   			<?php echo $this->Html->link($this->Html->image('/img/icons/child-birth.jpg'), array('controller'=>'patients','action' => 'child_birth_list',$patientId,'?'=>array('return'=>'patients')),
						 	array('escape' => false,'title'=>'Child Birth','target'=>'_blank'));?>
                   		</div>
                   		<div class="iconLink"><?php echo __('Child Birth'); ?></div>
                   </div>
                   <?php } ?>
                   <div class="interIconLink" >
			<div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/blood-sugar-monitor-chart.jpg'), array('controller'=>'nursings','action' => 'blood_sugar_monitoring',$patientId), 
					array('escape' => false,'title'=>'Blood Sugar Monitoring Chart','target'=>'_blank'));	?></div>
			<div class="iconLink"><?php echo __('Blood Sugar Monitoring Chart');?></div>
	   </div>	
     <div class="interIconLink">
			<div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/blood-requisition.jpg'),
					 array('controller'=>'blood_banks','action' => 'index',$patientId), array('escape' => false,'title'=>'Blood Requisition','target'=>'_blank'));	?></div>
			<div class="iconLink"><?php echo __('Blood Requisition');?></div>
	   </div>	
	   <div class="interIconLink">
			<div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/blood-transfusion.jpg'), array('controller'=>'nursings','action' => 'patient_blood_transfusion_list',$patientId),
					 array('escape' => false,'title'=>'Blood Transfusion Progress Form','target'=>'_blank'));	?></div>
			<div class="iconLink"><?php echo __('Blood Transfusion Progress Form');?></div>
	   </div>
	   
		<div class="interIconLink"  >
			<div class="icon"><?php echo $this->Html->link($this->Html->image('/img/icons/ivf.jpg'), array('controller'=>'nursings','action' => 'patient_ivf_list',$patientId), 
					array('escape' => false,'title'=>'I.V.F.','target'=>'_blank'));	?></div>
			<div class="iconLink"><?php echo __('I.V.F.');?></div>
	    </div>
  </div>
			  
	</div>
	<?php echo $this->Js->writeBuffer();?>
<script>
   jQuery(document).ready(function(){
      $('#dischargebyconsultant').click(function(){
			    $.fancybox({
		            'width'    : '80%',
				    'height'   : '80%',
				    'autoScale': true,
				    'transitionIn': 'fade',
				    'transitionOut': 'fade',
				    'type': 'iframe',
				    'href': "<?php echo $this->Html->url(array("controller" => "patients", "action" => "child_birth", $patientId)); ?>"
			    });
				
		  });
$("#prescriptionLink").click(function(){
				 
			window.location.href = "#list_content" ;
				 
			});

   });

   jQuery(document).click(function(){
                        $("a").click(function(){
                            $("form").validationEngine('hide');
                           });
			
   });
                
 </script>
