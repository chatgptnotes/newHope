<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#staffsurveysfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('Staff Satisfaction Survey Questionnaire', true); ?></h3>
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
<form name="staffsurveysfrm" id="staffsurveysfrm" action="<?php echo $this->Html->url(array("controller" => "surveys", "action" => "staffSurveySave", "admin" => false)); ?>" method="post"  >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">   	  
      <tr>
        <td width="49%" align="left" valign="top" style="padding-top:7px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <td width="100" height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __('Name of Staff: -', true); ?></td>
                <td align="left" valign="top">
                	<?php echo $staffDetails["User"]["full_name"]; ?>
				</td>
              </tr>
              <tr>
                <td valign="top" class="tdLabel1" id="boxSpace1"><?php echo __('Designation: -', true); ?></td>
                <td align="left" valign="top" style="padding-bottom:10px;">
                  <?php 
                       if($staffDetails["Designation"]["name"]) {
                         echo $staffDetails["Designation"]["name"]; 
                       } else {
                         echo __('Not Available', true);
                       }
                  ?>
        	</td>
              </tr>
              <tr>
                <td valign="top" class="tdLabel1" id="boxSpace1"><?php echo __('Date: -', true); ?></td>
                <td align="left" valign="top" style="padding-bottom:10px;">
                  <?php echo $this->Form->input('StaffSurvey.create_time', array('type'=>'text','class' => 'textBoxExpnd','id' => 'create_time',"style"=>"width:85px",'label'=>false)); ?>
        	</td>
              </tr>
        </table>                        </td>
        <td width="" align="left" valign="top">&nbsp;</td>
        <td width="49%" align="left" valign="top" style="padding-top:7px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" >
          <tr>
            <td width="140" height="25" valign="top" class="tdLabel1" id="boxSpace1"><?php echo __('Age / Sex: -', true); ?></td>
            <td align="left" valign="top">
	     <?php 
                  if((!$staffDetails["User"]["dob"] || $staffDetails["User"]["dob"] == "0000-00-00") && (!$staffDetails["User"]["gender"])) {
                     $agegender = __('Not Available', true);
                  } else {
                     $agegender = (date("Y") - date("Y", strtotime($staffDetails["User"]["dob"]))).__('yrs', true)." / ".$staffDetails["User"]["gender"];
                  }
                  echo $agegender;
             ?>
	    </td>
          </tr>
         </table></td>
      </tr>
    </table>
	<!-- two column table end here -->
	
    <div>&nbsp;</div>    
     <div class="clr ht5"></div>
                   
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
                   		<tr>
						 <th><?php echo __('Sr.No.', true); ?></th>
						 <th><?php echo __('Questions', true); ?></th>
						 <th><?php echo __('Yes / No', true); ?></th>
						</tr>
						<tr>
						 <td>1.</td>
						 <td>Safe At Work?</td>
						 <td>
						  <?php $options = array('N' => 'No', 'Y' => 'Yes');
                               echo $this->Form->input('StaffSurvey.question_id.1', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>2.</td>
						 <td>We Work Well Together?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.2', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>3.</td>
						 <td>Opportunity To Participate?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.3', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>4.</td>
						 <td>Chance To Be Creative?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.4', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>5.</td>
						 <td>Kept Informed?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.5', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>6.</td>
						 <td>Satisfied With Workload?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.6', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>7.</td>
						 <td>Given Tools To Do The Job?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.7', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>8.</td>
						 <td>Chance To Move Up?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.8', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>9.</td>
						 <td>Chance For Education & Training?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.9', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>10.</td>
						 <td>Recognized For My Service?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.10', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>11.</td>
						 <td>Get The Training I Need?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.11', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>12.</td>
						 <td>Happy With My Work Hours?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.12', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>13.</td>
						 <td> I Understand What is Expected?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.13', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>14.</td>
						 <td>Paid Based On Responsibility?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.14', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>15.</td>
						 <td>Comfortable With Level of Job Security?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.15', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>16.</td>
						 <td>Satisfied With benefits?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.16', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>17.</td>
						 <td>Chance To Help Make Decisions?</td>
						 
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.17', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>18.</td>
						 <td>Boss Treats Me Fairly?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.18', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
						<tr>
						 <td>19.</td>
						 <td>Satisfied With My Job?</td>
						 <td>
						  <?php 
                               echo $this->Form->input('StaffSurvey.question_id.19', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $options,'empty' => 'Select',  'label'=> false, 'div' => false, 'error' => false));
        ?>
						 </td>
						</tr>
                   </table>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
	<div class="btns">
           <?php echo $this->Form->submit(__('Submit'), array('class'=>'blueBtn','div'=>false)); ?>       
		   <?php //echo $this->Html->link(__('Cancel'),array('controller'=>'patients','action'=>'patient_information',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false)); ?>
    </div>
    <?php echo $this->Form->end(); ?>
    
    <script>
    $(function() {
		
		$("#create_time" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("H:I:S");?>',
			
		});

    });

    </script>
   