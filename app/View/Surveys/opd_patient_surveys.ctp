<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#opdpatientsurveyfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('OPD Patient Satisfaction Survey', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		<tr>
	  		<td colspan="2" align="left" class="error">
		   		<?php 
		     		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		   		?>
	  		</td>
	 </tr>
	</table>
<?php } ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">   	  
      <tr>
        	<th colspan="3" style="text-transform:uppercase;"><?php echo __("OPD Patient's Information", true); ?></th>
      </tr>                      
      <tr>
        <td width="49%" align="left" valign="top" style="padding-top:7px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <td width="100" height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __("Name", true); ?></td>
                <td align="left" valign="top">
                	<?php
                		echo $patient['Patient']['lookup_name'];
                	?>
				</td>
              </tr>
              <tr>
                <td valign="top" class="tdLabel1" id="boxSpace1"><?php echo __("Address", true); ?></td>
                <td align="left" valign="top" style="padding-bottom:10px;">
                	<?php
                	 
        				echo $address ;
        			?>
        		</td>
              </tr>
        </table>                        </td>
        <td width="" align="left" valign="top">&nbsp;</td>
        <td width="49%" align="left" valign="top" style="padding-top:7px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="140" height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __("Visit ID", true); ?></td>
            <td align="left" valign="top"><?php
            	echo $patient['Patient']['admission_id'];
            ?></td>
          </tr>
          <tr>
            <td width="140" height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __("Patient ID", true); ?></td>
            <td align="left" valign="top">
            <?php
            	echo $patientUID  ;
            ?>
            </td>
          </tr>
          <tr>
            <td height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __("Sex", true); ?></td>
            <td align="left" valign="top"><?php
            	echo ucfirst($patient['Patient']['sex']);
            ?></td>
          </tr>
          <tr>
            <td height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __("Age", true); ?></td>
            <td align="left" valign="top"><?php
            	echo $patient['Patient']['age'];
            ?></td>
          </tr>
        </table></td>
      </tr>
    </table>
	<!-- two column table end here -->
	<form name="opdpatientsurveyfrm" id="opdpatientsurveyfrm" action="<?php echo $this->Html->url(array("controller" => "surveys", "action" => "opdPatientSurveySave", "admin" => false)); ?>" method="post" >
	<?php
             echo $this->Form->input('PatientSurvey.patient_id', array('type' => 'hidden', 'value' => $patient['Patient']['id'])); 
             echo $this->Form->input('PatientSurvey.patient_type', array('type' => 'hidden', 'value' => 'OPD'));
        ?>
    <div>&nbsp;</div>    
     <div class="clr ht5"></div>
                   
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
						 <th><?php echo __('Sr.No.', true); ?></th>
						 <th><?php echo __('Questions', true); ?></th>
						 <th><?php echo __('Answers', true); ?></th>
						</tr>
						<tr>
						 <td>1.</td>
						 <td><?php echo __('The cleanliness and comfort in the waiting area met my expectation?'); ?></td>
						 <td>
						  <?php $options = array('Strongly Agree' => 'Strongly Agree', 'Agree' => 'Agree', 'Neither Agree Nor  Disagree' => 'Neither Agree Nor  Disagree.', 'Disagree' => 'Disagree','Strongly Disagree' => 'Strongly Disagree');
                               echo $this->Form->input('PatientSurvey.question_id.1', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>2.</td>
						 <td><?php echo __('Toilets were clean and well maintained?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.2', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>3.</td>
						 <td><?php echo __('All my doubts were answered by reception staff?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.3', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>4.</td>
						 <td><?php echo __('Staff ensured that privacy of my information was maintained?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.4', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>5.</td>
						 <td><?php echo __('I was seen at the appointment time by the doctor?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.5', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>6.</td>
						 <td><?php echo __('I was guided for the doctor\'s consultation?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.6', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>7.</td>
						 <td><?php echo __('I was taken in for my investigation at the appointed time?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.7', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>8.</td>
						 <td><?php echo __('I was well informed about the procedure?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.8', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>9.</td>
						 <td><?php echo __('I was informed about collecting report days and timing?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.9', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>10.</td>
						 <td><?php echo __('Billing procedure was completed in 5 minute?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.10', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>11.</td>
						 <td><?php echo __('I received my investigation reports at the scheduled time?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.11', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>12.</td>
						 <td><?php echo __('I was able to get all the medicine in the Hospital pharmacy prescribed by the doctor?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.12', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>13.</td>
						 <td><?php echo __('Reception Staff was polite, respectful and friendly with me?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.13', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>14.</td>
						 <td><?php echo __('I was able to find my way to the investigation room easily?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.14', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>15.</td>
						 <td><?php echo __('My personal privacy was maintained during investigation?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.15', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>16.</td>
						 <td><?php echo __('I was given full attention by the doctor?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.16', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>17.</td>
						 <td><?php echo __('All my queries were answered by the doctor?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.17', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>18.</td>
						 <td><?php echo __('I would recommend this hospital to others?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.18', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>19.</td>
						 <td><?php echo __('Overall I am satisfied with the OPD services received in Hope Hospital?'); ?></td>
						 <td>
						  <?php 
                               echo $this->Form->input('PatientSurvey.question_id.19', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						
                   </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
	<div class="btns">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'patients','action'=>'patient_information',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false)); ?>
           <?php echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false)); ?>       
       </div>
    <?php echo $this->Form->end(); ?>
   