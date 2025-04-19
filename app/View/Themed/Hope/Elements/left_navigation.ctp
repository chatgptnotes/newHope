<!-- First Tab Department -->
        <div class="tab_dept">
        <span>Patient Centric Specilty</span>
        
        <!-- Row 1 -->
        <div class="row_modules">
        <table cellpadding="0px" cellspacing="0px" align="center">
        	<tr>
			     <td align="center" valign="top">
					<a href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "index", "superadmin" => false, 'plugin' => false));?>"">
								<img src="<?php echo $this->Html->url("/img/icons/patient_record.jpg");?>" />
							</a>
					
					<p style="margin:0px; padding:0px;"><?php echo __('Patients',true); ?></p>
				</td>
				<td align="center" valign="top">
					<a href="<?php echo $this->Html->url(array("controller" => "appointments", "action" => "index", 'plugin' => false));?>"">
								<img src="<?php echo $this->Html->url("/img/icons/appointment.jpg");?>" />
							</a>
					
					<p style="margin:0px; padding:0px;"><?php echo __('Appointments',true); ?></p>
				</td>				 
        	</tr>
        </table>
        </div>
       
        <!-- Row 1 Ends Here -->
        </div>
        <!-- First Tab Department Ends Here -->
    </td>