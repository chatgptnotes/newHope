<div class="inner_title">
 <h3>OT</h3>
</div>
<ul class="interIcons">
  <li> 
    <?php echo $this->Html->link($this->Html->image('/img/icons/register.jpg', array('alt' => 'OT Appointment')),array("controller" => "opt_appointments", "action" => "otevent", "admin" => false, 'plugin' => false), array('escape' => false,'label'=>'OT Scheduling')); ?>
  </li>
  <li> 
    <?php echo $this->Html->link($this->Html->image('/img/icons/surgery-consent-form.jpg', array('alt' => 'Surgery Consent Form')),array("controller" => "opt_appointments", "action" => "frontdesk_ot_appointment", 'plugin' => false), array('escape' => false,'label'=>'Surgery Consent Form')); ?>
  </li>
  <li> 
    <?php echo $this->Html->link($this->Html->image('/img/icons/ward-management.jpg', array('alt' => 'Ward Management')),array("controller" => "wards", "action" => "ward_occupancy", "admin" => false, 'plugin' => false), array('escape' => false,'label'=>'Ward Management')); ?>
  </li>
  <li>
    <?php echo $this->Html->link($this->Html->image('/img/icons/advance-payment.jpg', array('alt' => 'Advance Payment')),array("controller" => "billings", "action" => "patientSearch",'?'=>array('type'=>'IPD'),"admin" => false,'plugin' => false), array('escape' => false,'label'=>'Advance Payment')); ?>
  </li>
  <li>
    <?php echo $this->Html->link($this->Html->image('/img/icons/anesthesia-consent-form.jpg', array('alt' => 'Anaesthesia Consent Form')),array("controller" => "opt_appointments", "action" => "anaesthesia_consent", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Anaesthesia Consent Form')); ?>
  </li>
  <li>
    <?php echo $this->Html->link($this->Html->image('/img/icons/consent-form.jpg', array('alt' => 'Patient Specific Consent Form')),array("controller" => "patients", "action" => "search", "?type=IPD","admin" => false,'plugin' => false), array('escape' => false,'label'=>'Patient Specific Consent Form')); ?>
  </li>
  <li>
    <?php echo $this->Html->link($this->Html->image('/img/icons/investigation.jpg', array('alt' => 'Investigation')),array("controller" => "laboratories", "action" => "lab_manager", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Investigation')); ?>
  </li>
  <li>
   <?php echo $this->Html->link($this->Html->image('/img/icons/pre-operative-instruction.jpg', array('alt' => 'Pre Operative Checklist')),array("controller" => "opt_appointments", "action" => "ot_pre_operative_checklist", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Pre Operative Checklist')); ?>
  </li>
  <li>
   <?php echo $this->Html->link($this->Html->image('/img/icons/post-operative-instruction.jpg', array('alt' => 'Post Operative Checklist')),array("controller" => "patients", "action" => "ot_post_operative_checklist", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Post Operative Checklist')); ?>
  </li>
<li>
   <?php echo $this->Html->link($this->Html->image('/img/icons/post-operative-instruction.jpg', array('alt' => 'Surgical Safety Checklist')),array("controller" => "opt_appointments", "action" => "surgical_safety_checklist", "admin" => false,'plugin' => false), array('escape' => false,'label'=>'Surgical Safety Checklist')); ?>
  </li>
 </ul>
