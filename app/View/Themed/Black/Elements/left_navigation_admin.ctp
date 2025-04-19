<!-- First Tab Department -->
        <div class="tab_dept">
        <span> <?php echo __('System Centric Specilty',true); ?></span>
        
        <!-- Row 1 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
			<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/UIDpatient.jpg', array('alt' => 'UID Allocation','title'=>'UID Allocation')),array("controller" => "persons", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('UID Allocation',true); ?></p>
				</td>
					<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'OPD','title'=>'OPD')),array("controller" => "users", "action" => "frondesk_patient", "admin" => false,"?type=opd",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('OPD',true); ?></p>
				</td>
				
					<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/in-patient.jpg', array('alt' => 'IPD','title'=>'IPD')),array("controller" => "users", "action" => "frondesk_patient", "admin" => false,"?type=ipd",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('IPD',true); ?></p>
				</td>
			
			    <td align="center" valign="top">

                                <?php echo $this->Html->link($this->Html->image('/img/icons/emergency.jpg', array('alt' => 'Emergency','title'=>'Emergency')),array("controller" => "users", "action" => "frondesk_patient", "admin" => false,"?type=emergency",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Emergency',true); ?></p>
				</td>
			

        	</tr>
        </table>
        </div>
    <!-- Row 1 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/master.jpg', array('alt' => 'Master','title'=>'Master')),array("controller" => "users", "action" => "menu", "admin" => true,"?type=master",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Master',true); ?></p>
				</td>
			

			<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/doctor.jpg', array('alt' => 'Doctor Enquiry','title'=>'Doctor Enquiry')),array("controller" => "doctors", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Doctor Enquiry',true); ?></p>
				</td>
			    <td align="center" valign="top">

                                <?php echo $this->Html->link($this->Html->image('/img/icons/consultant.jpg', array('alt' => 'Consultant Enquiry','title'=>'Consultant Enquiry')),array("controller" => "consultants", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Consultant Enquiry',true); ?></p>
				</td>
				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/reports1.jpg', array('alt' => 'Reports','title'=>'Reports')),array("controller" => "reports", "action" => "all_report", "admin" => true,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Reports',true); ?></p>
				</td>
				

        	</tr>
        </table>
        </div>
		
		
		
		   <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
			  <td align="center" valign="top">
                        <?php echo $this->Html->link($this->Html->image('/img/icons/appointment.jpg', array('alt' => 'Appointment','title'=>'Appointment')),array("controller" => "doctor_schedules", "action" => "doctor_event", "superadmin" => false, "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Appointments',true); ?></p>
		       </td>
                       <td align="center" valign="top">
                        <?php echo $this->Html->link($this->Html->image('/img/icons/ward.jpg', array('alt' => 'Wards','title'=>'Wards')),array("controller" => "wards", "action" => "index", "admin" => false, 'plugin' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Wards',true); ?></p>
		       </td>
			   
			     <td align="center" valign="top">
                 <?php echo $this->Html->link($this->Html->image('/img/icons/pharmacy.jpg', array('alt' => 'Pharmacy','title'=>'Pharmacy')),array("controller" => "pharmacy", "action" => "index","inventory"=>true, 'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Pharmacy',true); ?></p>
		
				
					<td align="center" valign="top">

                                <?php echo $this->Html->link($this->Html->image('/img/icons/permission.jpg', array('alt' => 'Permissions','title'=>'Permissions')),array("controller" => "acl", "action" => "index", "admin" => true), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Permissions',true); ?></p>
                                </td>
        	</tr>
        </table>
        </div>
		
		
		   <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
		  <td align="center" valign="top">
		           <?php echo $this->Html->link($this->Html->image('icons/billing-activities.jpg', array('alt' => __('Billing Services'), 'title'=> __('Billing Services'))),array("controller" => "services", "action" => "service_bill_list", "admin" => false, "superadmin" => false,'plugin' => false), array('escape' => false)); ?>
						<p style="margin:0px; padding:0px;"><?php echo __('Billing Services'); ?></p>
			  </td>
			   <td align="center" valign="top">
		           <?php echo $this->Html->link($this->Html->image('icons/billing-activities.jpg', array('alt' => __('Billing Activity'), 'title'=> __('Billing Activity'))),array("controller" => "billings", "action" => "PatientSearch", "admin" => false, "superadmin" => false,'plugin' => false), array('escape' => false)); ?>
						<p style="margin:0px; padding:0px;"><?php echo __('Billing Activity'); ?></p>
			  </td>
			  
			  
			    <td align="center" valign="top">
	   <?php echo $this->Html->link($this->Html->image('icons/appointment1.jpg', array('alt' => __('OT'), 'title' => __('OT Appointments'))),array("controller" => "opt_appointments", "action" => "index", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
           <p style="margin:0px; padding:0px;"><?php echo __('OT',true); ?></p>
	  </td>
	  
	  	<td align="center" valign="top">
			   <?php echo $this->Html->link($this->Html->image('icons/staff-plan.jpg', array('alt' => __('Staff Plan'), 'title' => __('Staff Plan'))),array("controller" => "staff_plans", "action" => "index", "inventory" => false,"admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
				   <p style="margin:0px; padding:0px;"><?php echo __('Staff Plan',true); ?></p>
			  </td>
        	</tr>
        </table>
        </div>
		
		
				   <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
		 	
			  
			            <td align="center" valign="top">
	   <?php echo $this->Html->link($this->Html->image('icons/survey.jpg', array('alt' => __('Survey'), 'title' => __('Survey'))),array("controller" => "surveys", "action" => "staff_surveys", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
           <p style="margin:0px; padding:0px;"><?php echo __('Survey',true); ?></p>
	 </td>
	
				 <td align="center" valign="top">
						   <?php echo $this->Html->link($this->Html->image('icons/laboratory-manager.jpg', array('alt' => __('Lab Manager'), 'title' => __('Lab Manager'))),array("controller" => "laboratories", "action" => "lab_manager", "admin" => false,'plugin' => false, 'superadmin'=> false), array('escape' => false)); ?>
							   <p style="margin:0px; padding:0px;"><?php echo __('Lab Manager',true); ?></p>
						 </td>
						 
			 	<td align="center" valign="top">
                <?php echo $this->Html->link($this->Html->image('/img/icons/nursing.jpg', array('alt' => 'Nursing', 'title' => __('Nursing'))),array("controller" => "nursings", "action" => "search", "admin" =>false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Nursing',true); ?></p>
		  	</td>			 
						 
						 </tr>
        </table>
        </div>
        </div>


  