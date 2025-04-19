<style>#report1{ font-weight: bold;};</style>
<?php 
$selectedAction = $this->params->action ;
$$selectedAction = 'report1' ;
?>
<div class=" nav_link">
     <div class="links" id="<?php echo $referal_to_specialist_report ;?>">
    <?php    
        echo $this->Html->link('Referrals to Specialist',array('controller'=>'Ccda','action'=>'referal_to_specialist_report'),
		array('escape'=>false,'class'=>$referal_to_specialist_report)) ;?>
     </div>
     <div class="links" id="<?php echo $summary_to_hospital_report ;?>">
      <?php echo $this->Html->link('Referrals To Hospital ',array('controller'=>'ccda','action'=>'summary_to_hospital_report'),array('escape'=>false,'class'=>'activelink')) ;  ?>
     </div>
     <div class="links" id="<?php echo $referral_to_care_giver ;?>">
       <?php echo $this->Html->link('Referrals To Caregiver ',array('controller'=>'Ccda','action'=>'referral_to_care_giver'),array('escape'=>false,'class'=>$referral_to_care_giver)) ; ?>
     </div>
     <div class="links" id="<?php echo $overdue_summary_care ;?>">
       <?php echo $this->Html->link('Over Due Summary of Care',array('controller'=>'Ccda','action'=>'overdue_summary_care'),array('escape'=>false,'class'=>$overdue_summary_care)) ; ?>
     </div>
  
     <div class="links" id="report_4">
       <?php echo $this->Html->link('Other information To Hospital Report',array('controller'=>'Ccda','action'=>'#'),array('escape'=>false,'class'=>'activelink')) ;  ?>
     </div>
       <div class="links" id="<?php echo $referral_to_hospital_report ;?>">
       <?php echo $this->Html->link('Tracking Of Referral To Hospital',array('controller'=>'Ccda','action'=>'referral_to_hospital_report'),array('escape'=>false,'class'=>$referralToHospital)) ;  ?>
     </div>
     <div class="links" id="<?php echo $referral_to_specialist_report ;?>">
       <?php echo $this->Html->link('Tracking Of Referral To Specialist',array('controller'=>'Ccda','action'=>'referral_to_specialist_report'),array('escape'=>false,'class'=>$referralToSpecialist)) ;  ?>
     </div>
   </div>