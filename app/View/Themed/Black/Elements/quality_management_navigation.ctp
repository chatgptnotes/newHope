<div class="tab_dept" id="quality-management-section" style="display: none;">
       <span style="padding-top:25px;text-align:center;font-size:19px;">Quality Management System</span>
        
         <!--Row 1 -->
        <div class="row_modules">
         <?php echo $this->Html->link($this->Html->image('../img/icons/aac.gif', array('alt' => 'AAC')),"http://qc.hopehospitals.in/", array('escape' => false,'target' => '_blank')); ?>
       </div>
        <div class="row_modules">
           <?php echo $this->Html->link($this->Html->image('../img/icons/cop.gif', array('alt' => 'COP')),"http://qc.hopehospitals.in/nabh-standards-gui/aac", array('escape'
										 => false,'target' => '_blank')); ?>
       </div>
       <div class="row_modules">
           <?php echo $this->Html->link($this->Html->image('../img/icons/mom.gif', array('alt' => 'MOM')),"http://qc.hopehospitals.in/nabh-standards-gui/mom", array('escape' => false,'target' => '_blank')); ?>
       </div>
       <div class="row_modules">
           <?php echo $this->Html->link($this->Html->image('../img/icons/pre.gif', array('alt' => 'PRE')),"http://qc.hopehospitals.in/nabh-standards-gui/pre", array('escape' => false,'target' => '_blank')); ?>
       </div>
       
      <!-- Row 2 -->

       <div class="row_modules">
           <?php echo $this->Html->link($this->Html->image('../img/icons/hic.gif', array('alt' => 'HIC')),"http://qc.hopehospitals.in/nabh-standards-gui/pcs-05-hic", array('escape'
										 => false,'target' => '_blank')); ?>
       </div>
       <div class="row_modules">
           <?php echo $this->Html->link($this->Html->image('../img/icons/cqi.gif', array('alt' => 'CQI')),"http://qc.hopehospitals.in/nabh-standards-gui/06-ocs-cqi", array('escape' => false,'target' => '_blank')); ?>
       </div>
       <div class="row_modules">
           <?php echo $this->Html->link($this->Html->image('../img/icons/rom.gif', array('alt' => 'ROM')),"http://qc.hopehospitals.in/nabh-standards-gui/07-ocs-rom", array('escape' => false,'target' => '_blank')); ?>
       </div>
       <div class="row_modules">
         <?php echo $this->Html->link($this->Html->image('../img/icons/fms.gif', array('alt' => 'FMS')),"http://qc.hopehospitals.in/nabh-standards-gui/08-ocs-fms", array('escape' => false,'target' => '_blank')); ?>
       </div>
       
      <!-- Row 3 -->
       <div class="row_modules">
           <?php echo $this->Html->link($this->Html->image('../img/icons/hrm.gif', array('alt' => 'HRM')),"http://qc.hopehospitals.in/nabh-standards-gui/human-resource-managemen-1", array('escape'
										 => false,'target' => '_blank')); ?>
       </div>
       <div class="row_modules">
           <?php echo $this->Html->link($this->Html->image('../img/icons/ims.gif', array('alt' => 'IMS')),"http://qc.hopehospitals.in/nabh-standards-gui/10-ocs-ims", array('escape' => false,'target' => '_blank')); ?>
       </div>
       <div class="row_modules">
           <?php echo $this->Html->link($this->Html->image('../img/icons/qm.gif', array('alt' => 'qm')),"http://qc.hopehospitals.in/nabh-standards-gui", array('escape' => false,'target' => '_blank')); ?>
       </div>
       <div class="row_modules">
         <?php echo $this->Html->link($this->Html->image('../img/icons/proc.gif', array('alt' => 'PROC')),"https://sites.google.com/a/hopehospitals.in/for-dot-in/", array('escape' => false,'target' => '_blank')); ?>
       </div>
       <?php  $role = $this->Session->read('role');   if($role=='Admin'){?>
       <div class="row_modules">
         <?php  //echo $this->Html->link($this->Html->image('../img/icons/webchat.png', array('alt' => 'PROC')),"http://drmcaduceus.com/support//login.php", array('escape' => false,'target' => '_blank')); ?>
      </div><?php  } ?>
   <?php   $role = $this->Session->read('role');
   $usertype=$this->Session->read('facilityu',$facility['Facility']['usertype']);
    
     if($role=='Patient'){
   ?>
   <div class="row_modules">
        <?php  //echo $this->Html->link($this->Html->image('../img/icons/webchat.png', array('alt' => 'PROC')),"http://localhost/craftysyntax3.4.4/livehelp.php", array('escape' => false,'target' => '_blank')); ?>
      </div>
       
  <?php  }?>
  
</div> 
      
    
	<script>
		//$("#quality-management-section > .row_modules > a").attr("href","#this");
		//$("#quality-management-section > .row_modules > a").removeAttr("target");
	</script>