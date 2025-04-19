<!-- First Tab Department -->
        <div class="tab_dept">
        <span> <?php echo __('System Centric Specilty',true); ?></span>
        
        <!-- Row 1 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
			    <td align="center" valign="top">

                                <?php echo $this->Html->link($this->Html->image('/img/icons/emergency.jpg', array('alt' => 'Emergency')),array("controller" => "patients", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Registration',true); ?></p>
				</td>
				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/in-patient.jpg', array('alt' => 'In Patient')),array("controller" => "locations", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Locations',true); ?></p>
				</td>
				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'Out Patient')),array("controller" => "users", "action" => "index", "admin" => true,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Users',true); ?></p>
				</td>

        	</tr>
        </table>
        </div>

        </div>


  