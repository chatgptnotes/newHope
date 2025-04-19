<!-- First Tab Department -->
        <div class="tab_dept">
        <span> <?php echo __('System Centric Specilty',true); ?></span>
        
        <!-- Row 1 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/out-patient.jpg', array('alt' => 'OPD')),array("controller" => "users", "action" => "doctor_patient", "admin" => false,"?type=opd",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('OPD',true); ?></p>
				</td>

				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/in-patient.jpg', array('alt' => 'IPD')),array("controller" => "users", "action" => "doctor_patient", "admin" => false,"?type=ipd",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('IPD',true); ?></p>
				</td>
			
			    <td align="center" valign="top">

                                <?php echo $this->Html->link($this->Html->image('/img/icons/emergency.jpg', array('alt' => 'Emergency')),array("controller" => "users", "action" => "doctor_patient", "admin" => false,"?type=emergency",'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Emergency',true); ?></p>
				</td>
						<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/appointment1.jpg', array('alt' => 'OT')),array("controller" => "opt_appointments", "action" => "index", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('OT',true); ?></p>
				</td>
				
				
        	</tr>
        </table>
        </div>


   <!-- Row 1 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
				<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/invoice.jpg', array('alt' => 'Invoice')),array("controller" => "billings", "action" => "PatientSearch", "admin" => false,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Invoice',true); ?></p>
				</td>

					<td align="center" valign="top">
                                <?php echo $this->Html->link($this->Html->image('/img/icons/reports1.jpg', array('alt' => 'Report')),array("controller" => "reports", "action" => "all_report", "admin" => true,'plugin' => false), array('escape' => false)); ?>
				<p style="margin:0px; padding:0px;"><?php echo __('Reports',true); ?></p>
				</td>
			
        	</tr>
        </table>
        </div>

        </div>


  