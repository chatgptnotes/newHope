<style>
table td{ font-size:13px; color:#000;}
</style>
<div class="inner_title">
<h3> &nbsp;<?php echo __('Patient Reminder', true); ?></h3>

</div>
<br/>
<table border="1" id="managerial" width="100%" cellspacing="5" cellpadding="5">
  <tr>
   <td valign="">&nbsp;1</td>
   <td class="tdLabel">&nbsp;Cervical Cancer Screening</td>
   <td class="tdLabel">&nbsp;Recommends screening for cervical cancer in women ages 21 to 65 </td>
   <td><?php echo $this->Html->link(__('Send Reminder'),array('controller'=>'Patientreminders','action' => 'sendToPatient','cancer'),array('id'=>'cervicalCancerScreening','escape' => false,'class'=>'blueBtn'),__('Are you sure to send reminder for Cervical Cancer Screening?', true));?></td>
  </tr>
  <tr>
   <td valign="" >&nbsp;2</td>
   <td class="tdLabel">&nbsp;Influenza Vaccination</td>
   <td class="tdLabel">&nbsp;Flu shot. All persons aged 6 months and older should be vaccinated annually, with rare exceptions.</td>
   <td><?php echo $this->Html->link(__('Send Reminder'),array('controller'=>'Patientreminders','action' => 'sendToPatient','influenza'),array('id'=>'influenzaVaccination','escape' => false,'class'=>'blueBtn'),__('Are you sure to send reminder for Influenza Vaccination?', true));?></td>
  </tr>
  <tr>
   <td valign="">&nbsp;3</td>
   <td class="tdLabel">&nbsp;Smoking</td>
   <td class="tdLabel">&nbsp;Recommends that clinicians ask all adults about tobacco use and 
provide tobacco cessation interventions for those who use tobacco 
products.
</td>
<td><?php echo $this->Html->link(__('Send Reminder'),array('controller'=>'Patientreminders','action' => 'sendToPatient','smoking'),array('id'=>'smoking','escape' => false,'class'=>'blueBtn'),__('Are you sure to send reminder for Smoking?', true));?></td>
  </tr>
  <tr>
   <td valign="">&nbsp;4</td>
   <td class="tdLabel">&nbsp;Diabetes</td>
   <td class="tdLabel">&nbsp;Recommends screening for type 2 diabetes in asymptomatic adults with sustained blood pressure (either treated or untreated) greater than 135/80 mm Hg.
</td>
<td><?php echo $this->Html->link(__('Send Reminder'),array('controller'=>'Patientreminders','action' => 'sendToPatient','diabetes'),array('id'=>'diabetes','escape' => false,'class'=>'blueBtn'),__('Are you sure to send reminder for Diabetes?', true));?></td>
  </tr>
  <tr>
   <td valign="">&nbsp;5</td>
   <td class="tdLabel">&nbsp;High Blood Pressure</td>
   <td class="tdLabel">&nbsp;Recommends screening for high blood pressure in adults age 18 and older. </td>
   <td><?php echo $this->Html->link(__('Send Reminder'),array('controller'=>'Patientreminders','action' => 'sendToPatient','highbp'),array('id'=>'highBloodPressure','escape' => false,'class'=>'blueBtn'),__('Are you sure to send reminder for High Blood Pressure?', true));?></td>
  </tr>
  <tr>
   <td valign="">&nbsp;6</td>
   <td class="tdLabel">&nbsp;Depression</td>
   <td class="tdLabel">&nbsp;Recommends screening adults for depression when staff-assisted 
depression care supports are in place to assure accurate diagnosis, 
effective treatment, and followup.
</td>
<td><?php echo $this->Html->link(__('Send Reminder'),array('controller'=>'Patientreminders','action' => 'sendToPatient','depression'),array('id'=>'depression','escape' => false,'class'=>'blueBtn'),__('Are you sure to send reminder for Depression?', true));?></td>
  </tr>
</table>
</div>
<script>


</script>
