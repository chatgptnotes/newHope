<!-- First Tab Department -->
        <div class="tab_dept">
        <span> <?php echo __('System Centric Specilty',true); ?></span>
        
        <!-- Row 1 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
			    <td align="center" valign="top">

                                <?php echo $this->Html->link($this->Html->image('/img/icons/patient_record.jpg', array('alt' => 'Patients')),array("controller" => "patients", "action" => "index", "admin" => true,'plugins' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Patients',true); ?></p>
				</td>
				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/location.jpg', array('alt' => 'Locations')),array("controller" => "locations", "action" => "index", "admin" => true,'plugins' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Locations',true); ?></p>
				</td>
				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/role.jpg', array('alt' => 'Users')),array("controller" => "users", "action" => "index", "admin" => true,'plugins' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Users',true); ?></p>
				</td>
				<td align="center" valign="top">

                                <?php echo $this->Html->link($this->Html->image('/img/icons/permission.jpg', array('alt' => 'Permissions')),array("controller" => "acl", "action" => "index", "admin" => true), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Permissions',true); ?></p>
                                </td>
                                
			 
        	</tr>
        </table>
        </div>
       
        <!-- Row 1 Ends Here -->
        <!-- Row 2 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        <tr>
		                        <td align="center" valign="top">
                            <?php echo $this->Html->link($this->Html->image('/img/icons/city.jpg', array('alt' => 'Cities')),array("controller" => "cities", "action" => "index", "admin" => true,'plugins' => false), array('escape' => false)); ?>
   			    <p style="margin:0px; padding:0px;"><?php echo __('City',true); ?></p>
				</td>
				<td align="center" valign="top">
                            <?php echo $this->Html->link($this->Html->image('/img/icons/state.jpg', array('alt' => 'States')),array("controller" => "states", "action" => "index", "admin" => true,'plugins' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('State',true); ?></p>
				</td>
				<td align="center" valign="top">
                            <?php echo $this->Html->link($this->Html->image('/img/icons/country.jpg', array('alt' => 'Countries')),array("controller" => "countries", "action" => "index", "admin" => true,'plugins' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Country',true); ?></p>
				</td>
				<td align="center" valign="top">
                            <?php echo $this->Html->link($this->Html->image('/img/icons/roomready.jpg', array('alt' => 'Roles')),array("controller" => "roles", "action" => "index", "admin" => true,'plugins' => false), array('escape' => false)); ?>
					<p style="margin:0px; padding:0px;"><?php echo __('Role',true); ?></p>
			    </td>
        	</tr>
        </table>
        </div>
        <!-- Row 2 Ends Here -->
        <!-- Row 3 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        <tr>
		       <td align="center" valign="top">
                         <?php echo $this->Html->link($this->Html->image('/img/icons/doctor.jpg', array('alt' => 'Doctor')),array("controller" => "doctors", "action" => "index", "admin" => true,'plugins' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Doctor',true); ?></p>
		       </td>
                       <td align="center" valign="top">
                        <?php echo $this->Html->link($this->Html->image('/img/icons/appointment.jpg', array('alt' => 'Appointment')),array("controller" => "appointments", "action" => "index", "superadmin" => false, "admin" => false,'plugins' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Appointments',true); ?></p>
		       </td>
                       <td align="center" valign="top">
                        <?php echo $this->Html->link($this->Html->image('/img/icons/roomready.jpg', array('alt' => 'Wards')),array("controller" => "wards", "action" => "index", "admin" => true, 'plugins' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Wards',true); ?></p>
		       </td>
                       <td align="center" valign="top">
                        <?php echo $this->Html->link($this->Html->image('/img/icons/roomready.jpg', array('alt' => 'Specilty')),array("controller" => "departments", "action" => "index", "admin" => true, 'plugins' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Appointments',true); ?></p>
		       </td>
        </tr>
        </table>
        </div>
        <!-- Row 3 -->
        <!-- Row 4 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        <tr>
		       <td align="center" valign="top">
                         <?php echo $this->Html->link($this->Html->image('/img/icons/permission.jpg', array('alt' => 'Permissions')),array("controller" => "acl", "action" => "index", "admin" => true,'plugins' => false), array('escape' => false)); ?>
			<p style="margin:0px; padding:0px;"><?php echo __('Permissions',true); ?></p>
		       </td>
                       
        </tr>
        </table>
        </div>
        <!-- Row 4 -->
        </div>


  