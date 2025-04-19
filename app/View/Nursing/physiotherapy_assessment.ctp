<style>
.tddate img{float:inherit;}
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>
<?php 
  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');  
?>
<style>
	.tabularForm td td{
	padding:0px;
	font-size:13px;
	
	}
	.tabularForm th td{
	padding:0px;
	font-size:13px;
	color:#e7eeef;
	background:none;
	}

</style>
<script>
	$(document).ready(function(){
		 $("#date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			onSelect:function(){$(this).focus();}
		});

		$("#PhysiotherapyAssessment").validationEngine();
	});
	 
	 
</script>

<div class="inner_title">
  <h3><?php echo __('Physiotherapy Assessment Form'); ?></h3>
  <span><?php 
  if($flag != 'sbar'){
  	echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'physiotherapy_assessment_view',$patient_id), array('escape' => false,'class'=>'blueBtn'));
  }else{
	echo $this->Html->link(__('Back', true),array('controller'=>'PatientsTrackReports','action' => 'sbar',$patient_id,'Assessment'), array('escape' => false,'class'=>'blueBtn'));
  }?></span>  
 </div>
 <?php echo $this->element('patient_information');?>
   <p class="ht5"></p>  
   
    
   <?php echo $this->Form->create('PhysiotherapyAssessment',array('id'=>'PhysiotherapyAssessment','url'=>array("controller" => $this->params['controller'], "action" => "physiotherapy_assessment")));?>	
   <?php 
        echo $this->Form->input('PhysiotherapyAssessment.patient_id', array('type'=>'hidden', 'value'=> $patient_id, 'id'=>'patient_id','label'=> false, 'div' => false));
        echo $this->Form->input('PhysiotherapyAssessment.id', array('type'=>'hidden', 'value'=> $patientPhysioAssessDetails['PhysiotherapyAssessment']['id'], 'label'=> false, 'div' => false));
        echo $this->Form->input('PhysiotherapyAssessment.sbar', array('type'=>'hidden', 'value'=> $flag, 'label'=> false, 'div' => false));
        
   ?>
   <table width="100%" cellpadding="0" cellspacing="0" border="0" align="right"  >
		<tr>
			<td width="6%%" align="right" style="font-size: 13px">Date<font color="red">*</font>&nbsp;</td>
			<td width="92%" class="tddate">
			<?php 
				echo $this->Form->input('PhysiotherapyAssessment.submit_date', array('class'=>'validate[required,custom[mandatory-date]] textBoxExpnd','type'=>'text','id'=>'date','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly', 'value' => $this->DateFormat->formatDate2Local($patientPhysioAssessDetails['PhysiotherapyAssessment']['submit_date'],Configure::read('date_format'), true)));
			?>
			</td>
		</tr>
	</table>
	
	<div class="clr ht5"></div>
	<table width="100%" border="0" cellspacing="2" cellpadding="0" class="tabularForm">
                      <tr>
                      	 <th colspan="2">Basic Information</th>
                      </tr>
                      <tr>
                        <td width="50%" align="left" valign="top" style="padding-top:7px;">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                              <tr>
                                <td width="40%" class="tdLabel">Physiotherapist<font color="red">*</font> </td>
                                <td>
                                 <input type="text" name="data[PhysiotherapyAssessment][physiotherapist_incharge]" value="<?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['physiotherapist_incharge']; ?>" class="validate[required,custom[customname]] textBoxExpnd" id="physiotherapist_incharge" style="" />
                                </td>
                               </tr>
                              <tr>
                                <td class="tdLabel">Chief Complaints</td>
                                <td>
                                 <textarea name="data[PhysiotherapyAssessment][chief_complaints]" class="textBoxExpnd" id="chief_complaints" style=""><?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['chief_complaints']; ?></textarea>
                                </td>
                              </tr>
                              <tr>
                                <td class="tdLabel">Observation</td>
                                <td>
                                 <textarea name="data[PhysiotherapyAssessment][observation]" class="textBoxExpnd" id="observation" style=""><?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['observation']; ?></textarea>
                                </td>
                              </tr>
                              <tr>
                                <td class="tdLabel">Sensory</td>
                                <td>
                                 <input type="text" name="data[PhysiotherapyAssessment][sensory]" value="<?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['sensory']; ?>" class="textBoxExpnd" id="sensory" style="" />
                                </td>
                               </tr>
                              
                               
                       	  </table>
                        </td>
                        <td  align="left" valign="top" style="padding-top:7px;" width="50%">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                                <tr>
                                <td width="40%" class="tdLabel">Reflexes</td>
                                <td>
                                 <input type="text" name="data[PhysiotherapyAssessment][reflexes]" value="<?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['reflexes']; ?>" class="textBoxExpnd" id="reflexes" style="" />
                                </td>
                               </tr>
                                <tr>
                                <td class="tdLabel">Motor</td>
                                <td>
                                 <input type="text" name="data[PhysiotherapyAssessment][motor]" value="<?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['motor']; ?>" class="textBoxExpnd" id="motor" style="" />
                                </td>
                               </tr>
                               <tr>
                                <td class="tdLabel">Notes</td>
                                <td>
                                 <textarea name="data[PhysiotherapyAssessment][notes]" class="textBoxExpnd" id="notes" style=""><?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['notes']; ?></textarea>
                                 
                                </td>
                               </tr>
                               <tr>
                                <td class="tdLabel">Chest PT</td>
                                <td>
                                 <input type="text" name="data[PhysiotherapyAssessment][chest_pt]" value="<?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['chest_pt']; ?>" class="textBoxExpnd" id="chest_pt" style="" />
                                </td>
                               </tr>
                               <tr>
                                <td class="tdLabel">Limb PT</td>
                                <td>
                                 <input type="text" name="data[PhysiotherapyAssessment][limb_pt]" value="<?php echo $patientPhysioAssessDetails['PhysiotherapyAssessment']['limb_pt']; ?>" class="textBoxExpnd" id="limb_pt" style="" />
                                </td>
                               </tr>
                       	  </table>
                        </td>
                      </tr>
                    </table> 
<div class="btns">
	<input type="submit" value="Save" class="blueBtn" tabindex="17" onClick="return getValidate();"/> 
	 
	
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->end(); ?> 
 