<!-- First Tab Department -->
        <div class="tab_dept">
        <span> <?php echo __('System Centric Specilty',true); ?></span>
        
        <!-- Row 1 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
			    <td align="center" valign="top">

                                <?php echo $this->Html->link($this->Html->image('/img/icons/patient_record.jpg', array('alt' => 'Registration')),array("controller" => "patients", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Registration',true); ?></p>
				</td>
				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/location.jpg', array('alt' => 'Locations')),array("controller" => "locations", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Locations',true); ?></p>
				</td>
				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/role.jpg', array('alt' => 'Users')),array("controller" => "users", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Users',true); ?></p>
				</td>
				<td align="center" valign="top">

                                <?php echo $this->Html->link($this->Html->image('/img/icons/permission.jpg', array('alt' => 'Permissions')),array("controller" => "acl", "action" => "index", "admin" => true), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Permissions',true); ?></p>
                                </td>
                                
			 
        	</tr>
        </table>
        </div>
       
    
        
        </div>


  