<?php  
echo $this->Html->css(array('internal_style','jquery.autocomplete'));
echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete' ,'ui.datetimepicker.3.js','jquery.blockUI','default.js'));  
echo $this->Html->script(array('validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en'));
echo $this->Html->css(array('validationEngine.jquery.css','jquery.ui.all.css','jquery-ui-1.8.16.custom.css'));
?>
<?php 
if(empty($patientHealthPlanID))
    $patientHealthPlanIDfreq=0;
else
    $patientHealthPlanIDfreq=$patientHealthPlanID;
?>
<div class="inner_title">
    <h3 style="font-size:13px; margin-left: 5px;">
        <?php  echo __('Add Medication & Immunization'); ?>
    </h3>
</div>
<div>
    <table width="60%" class="formFull formFullBorder">
        <tr>
            <td width="10%" align="right"><b><?php echo __('Name :')?> </b></td>
            <td align="left"><?php echo $patientDetails['Patient']['lookup_name'];?>
            </td>
            <td>&nbsp;&nbsp;&nbsp;</td>

            <td width="10%" align="right"><b><?php echo __('Gender :')?> </b></td>
            <td align="left"><?php echo ucfirst($patientDetails['Person']['sex']);?>
            </td>
            <td>&nbsp;&nbsp;&nbsp;</td>

            <td width="10%" align="right"><b><?php echo __('DOB :')?> </b></td>
            <td align="left"><?php echo date("F d, Y", strtotime($patientDetails['Person']['dob']));?>
            </td>
            <td>&nbsp;&nbsp;&nbsp;</td>

            <td width="10%" align="right"><b><?php echo __('Visit ID :')?> </b></td>
            <td align="left"><?php echo $patientDetails['Patient']['admission_id'];?>
            </td>

        </tr>
    </table>
</div>
<?php
echo $this->Form->create('Note',array('id'=>'patientnotesfrm','inputDefaults' => array('label' => false,'div' => false,'error'=>false)));
echo $this->Form->hidden('patientId',array('id'=>'patientId','value'=>$patientId,'autocomplete'=>"off"));
echo $this->Form->hidden('uid',array('id'=>'uid','value'=>$Uid,'autocomplete'=>"off"));
echo $this->Form->hidden('noteId',array('id'=>'noteId','value'=>$noteId,'autocomplete'=>"off"));

if($flag=='notPresent'){?>
<div align="center">
    <font color="red"><?php echo __('Drug is not present in our database, so select alternate drug.', true); ?></font>
    <?php echo $this->Form->button(__('Change Drug'), array('id'=>'changeMed','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' )); ?>
    <?php //echo $this->Form->input('NewCropPrescription.newMed', array('options'=>$temp,'empty'=>'Select alternate medication','class' => 'textBoxExpnd','id' => 'newMed','label'=> false,'style'=>'display:none'));?>
</div>
<div align="center">
    <?php echo $this->Form->input('NewCropPrescription.newMed', array('options'=>$temp,'empty'=>'Select alternate drug','class' => '','id' => 'newMed','label'=> false,'style'=>'display:none; width:250px'));?>
</div>
<?php }?>
<table class="loading" style="text-align: left; padding: 0px !important;margin: 11px auto 0; " width="99%">
    <tr>
        <td width="100%" valign="top" align="left" style="padding: 2px;" colspan="4">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabularForm">
                <!-- row 1 -->
                <tr>
                    <td width="100%" valign="top" align="left" colspan="6">
                        <table width="100%" border="0" cellspacing="1" cellpadding="0"
                            id='DrugGroup' style="padding: 0px !important;margin-top: 10px;" class="tabularForm">
                             <tr style='border: none;'>
                                <td width="100%" colspan='15' style="border: none; display:none;">
                                    <div class="message" id='successMsg'
                                        style='display: none; color: green; text-align: center'>
                                        <!-- Show  sevirity  -->
                                    </div>
                                </td>
                            </tr> 

                            <!-- ALL DEVELOPER ITS INTERACTION DO NOT COMMENT OR DELETE -->
                            <tr style='border: none !important;' id="tr0">
                                <td width="100%" colspan='16'>
                                    <div id='showsevirity' style='display: none; color: #cc3333; border: none;'>
                                        <!-- Show  sevirity  -->
                                    </div>
                                </td>
                            </tr> 

                             <tr style='border: none !important;' id="tr1">
                                <td width="100%" colspan='16'>
                                    <div id='interactionData' style='display: none; color: #cc3333 border: none;'>
                                        <!-- interaction Data  -->
                                    </div>
                                </td>
                            </tr>

                             <tr style='border: none !important;' id="tr2">
                                <td width="50%" colspan='2'>
                                    <div id='overRide' style='display: none; border: none;'>
                                        <?php
                                                echo $this->Form->input(__('Override Instructions'),array('name'=>'override_inst[]','class'=>'','id'=>'overText','type'=>'text'));?>
                                    </div>
                                </td>
                                <td width="50%" colspan='15'>
                                    <div id='overRideButton' style='display: none; border: none;'>
                                        <?php $isOverride='1';
                                                echo $this->Form->submit(__('Override Instructions'),array('id'=>'oversubmit','class'=>'blueBtn','onclick'=>"javascript:save_med(".$isOverride.");return false;"));?>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td  class="tdLabel">Drug Name</td>
                                <td  class="tdLabel" style="width:5px;">Unit</td>
                                <td  class="tdLabel">Strength</td>
                                <td  class="tdLabel" style="width:5px;">Dosage</td> 
                                <td  class="tdLabel">Dosage Form</td>
                                <td  class="tdLabel">Route</td>
                                <td  class="tdLabel">Frequency</td>
                                <td  class="tdLabel">Days</td>
                                <td  class="tdLabel">Qty</td>
                                <td  class="tdLabel">Refills</td>
                                <td  class="tdLabel">As Needed (p.r.n)</td>
                                <td  class="tdLabel">Dispense As Written</td>
                                <td  class="tdLabel" style="width:11%">First Dose Date/Time</td>
                                <td  class="tdLabel" style="width:11%">Stop Date/Time</td>
                                <td  class="tdLabel">Active</td>
                                <td  class="tdLabel" title="Medication to be administered in clinic">Administered in Clinic?</td>
                                <?php 
                                if(isset($getMedicationRecords) && !empty($getMedicationRecords)){ 
                                    if($pastEncounter != 'pastEncounter'){?>
                                        <td  class="tdLabel">Action</td>
                                <?php }
                                }?>
                            </tr>
                            <?php  /*debug($getMedicationRecords);*//*exit;*/
                            if(isset($getMedicationRecords) && !empty($getMedicationRecords)){
                                    foreach($getMedicationRecords as $i=>$data){
                                    ?>
                            <tr id="DrugGroup<?php echo $i;?>">
                            <td align="left" valign="top" style="padding-right: 3px">
                                <?php echo $this->Form->input('', array('type'=>'text','class' => 'medName validate[required,custom[mandatory-enter]]' ,'id'=>"drugText_$i",'name'=> 'drugText[]','value'=>stripslashes($data['NewCropPrescription']['description']),'readonly'=>'readonly','autocomplete'=>'off','counter'=>$i,'style'=>'width:150px!important;','label'=>false)); 
                                echo $this->Form->hidden("",array('class'=>'allHiddenId','id'=>"drug_$i",'name'=>'drug_id[]','value'=>$data['NewCropPrescription']['drug_id']));
                                echo $this->Form->hidden("",array('id'=>"newCrop$i",'name'=>'newCrop[]','value'=>$data['NewCropPrescription']['id']));
                                ?>
                                <span id="drugType_<?php echo $k?>"></span>&nbsp;<span id="formularylinkId_<?php echo $i?>"></span>
                            </td>
                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('style'=>'margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]] dose_val','id'=>"unit$k",'name' => 'unit[]','value'=>$data['NewCropPrescription']['dose_unit'],'label'=>false,'style'=>'width:46px!important;')); ?>
                            </td>
                            

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('strength'),'style'=>'margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]]','id'=>"Dform".$i,'name' => 'DosageForm[]','value'=>$data['NewCropPrescription']['strength'],'label'=>false));?>
                            </td>
                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('dose_type'),'style'=>'margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]] dose_val','id'=>"dose_type$i",'name' => 'dose_type[]','value'=>$data['NewCropPrescription']['dose'],'label'=>false)); ?>
                            </td>

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('dose_type_name'),'style'=>'margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]]','id'=>"DfromType$k",'name' => 'DfromType[]','value'=>$data['NewCropPrescription']['dosageType'],'label'=>false));?>
                            </td>

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('route_administration'),'style'=>'width:67px;margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]]','id'=>"route_administration".$i,'name' => 'route_administration[]','value'=>$data['NewCropPrescription']['route'],'label'=>false)); ?>
                            </td>

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('frequency'),'style'=>'width:67px;margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]] frequency_value','id'=>"frequency_$i",'name' => 'frequency[]','value'=>$data['NewCropPrescription']['frequency'],'label'=>false)); ?>
                            </td>
                            
                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => 'day','id'=>"day$i",'autocomplete'=>'off','style'=>'margin: 0 0 0 10px;','name' => 'day[]','value'=>$data['NewCropPrescription']['day'],'label'=>false)); ?>
                            </td>

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off','class' => "quantity_$i",'id'=>"quantity$i",'style'=>'margin: 0 0 0 10px;','name' => 'quantity[]','value'=>$data['NewCropPrescription']['quantity'],'label'=>false)); ?>
                            </td>

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('refills'),'empty'=>'Select','style'=>'width:80px','class' => '','id'=>"refills$i",'name' => 'refills[]','value'=>$data['NewCropPrescription']['refills'],'label'=>false));  ?>
                            </td>

                            <td align="center" valign="top" style=""><?php $options = array('1'=>'Yes','0'=>'No');
                                        echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"prn$i",'name' => 'prn[]','value'=>$data['NewCropPrescription']['prn'],'label'=>false));?>
                            </td>

                            <td align="center" valign="top" style=""><?php echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"daw$i",'name' => 'daw[]',
                                    'value'=>$data['NewCropPrescription']['daw'],'label'=>false));?>
                            </td>

                            <td align="center" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('readonly'=>'readonly','type'=>'text','size'=>16, 'class'=>'my_start_date1 textBoxExpnd','name'=> 'start_date[]','value'=> $this->DateFormat->formatDate2Local($data['NewCropPrescription']['firstdose'],Configure::read('date_format'),true), 'id' =>"start_date".$i ,'counter'=>$count,'label'=>false )); ?>
                            </td>

                            <td align="center" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('readonly'=>'readonly','type'=>'text','size'=>16,'class'=>'my_end_date1 textBoxExpnd','name'=> 'end_date[]','value'=>$this->DateFormat->formatDate2Local($data['NewCropPrescription']['stopdose'],Configure::read('date_format'),true),'id' => "end_date".$i,'counter'=>$count,'label'=>false)); ?>
                            </td>

                            <td align="center" valign="top" style=""><?php $options_active = array('1'=>'Yes','0'=>'No');
                                        echo $this->Form->input('', array( 'options'=>$options_active,'class' => 'showLogPopUp','id'=>"isactive$i",'name' => 'isactive[]','value'=>$data['NewCropPrescription']['isactive'],'label'=>false));?>
                            </td>
                            <td align="center" valign="top" style=""><?php $options_avd = array('0'=>'No','1'=>'Yes');
                            if($data['NewCropPrescription']['is_med_administered']==2){
                            $runtimeChangeVaribale1='1';
                            }
                            else{
                                $runtimeChangeVaribale1=$data['NewCropPrescription']['is_med_administered'];
                            }
                                echo $this->Form->input('', array('options'=>$options_avd,'class' => "isadv",'id'=>"isadv$i",'name' => 'isadv[]','selected'=>$runtimeChangeVaribale1,'label'=>false));?>
                            </td>
                            <?php if($pastEncounter != 'pastEncounter'){?>
                            <td><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_history','id'=>"pMH$i"));?>
                            </td>
                            <?php }?>
                                        
                            </tr>
                            <tr>
                                <td align="center" colspan='16' valign="top" style="display:none" id='showlogTextArea'>
                                <?php echo $this->Form->input('', array('type'=>'textarea','rows'=>'3','cols'=>'4', 'class'=>'yello_bg textBoxExpnd validate[required,custom[mandatory-enter]]','name'=> 'inactive_log[]','counter'=>$count,'label'=>false,'placeholder'=>'(Reason for discontinuing drug)')); ?>
                                </td>
                            </tr>
                            <?php }
}else{
                                /* debug($this->data); */

                                        $count  = 1 ;

                                        /*  debug($this->data); */
                                    for($k=0;$k<$count;$k++){?>
                            <tr id="DrugGroup<?php echo $k;?>">
                            <td align="left" valign="top" style="padding-right: 3px">
                                <?php echo $this->Form->input('', array('type'=>'text','class' => 'drugText validate[required,custom[mandatory-enter]]' ,'id'=>"drugText_$k",'name'=> 'drugText[]','value'=>stripslashes($data['NewCropPrescription']['description']),'autocomplete'=>'off','counter'=>$k,'style'=>'width:150px!important;','label'=>false)); 
                                echo $this->Form->hidden("",array('class'=>'allHiddenId','id'=>"drug_$k",'name'=>'drug_id[]'));
                                ?>
                                <span id="drugType_<?php echo $k?>"></span>&nbsp;<span id="formularylinkId_<?php echo $k?>"></span>
                            </td>
                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('style'=>'margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]] dose_val','id'=>"unit$k",'name' => 'unit[]','value'=>$data['NewCropPrescription']['dose'],'label'=>false,'style'=>'width:46px!important;')); ?>
                            </td>
                            

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('strength'),'style'=>'margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]]','id'=>"Dfrom$k",'name' => 'DosageForm[]','value'=>$data['NewCropPrescription']['strength'],'label'=>false));?>
                            </td>
                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('dose_type'),'style'=>'margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]] dose_val','id'=>"dose_type$k",'name' => 'dose_type[]','value'=>$data['NewCropPrescription']['dose'],'label'=>false)); ?>
                            </td>

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('dose_type_name'),'style'=>'margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]]','id'=>"DfromType$k",'name' => 'DfromType[]','value'=>$data['NewCropPrescription']['strength'],'label'=>false));?>
                            </td>

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('route_administration'),'style'=>'width:67px;margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]]','id'=>"route_administration$k",'name' => 'route_administration[]','value'=>$data['NewCropPrescription']['route'],'label'=>false)); ?>
                            </td>

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('empty'=>'Select','options'=>Configure :: read('frequency'),'style'=>'width:67px;margin: 0 0 0 0px;','class' => 'validate[required,custom[mandatory-select]] frequency_value','id'=>"frequency_$k",'name' => 'frequency[]','value'=>$data['NewCropPrescription']['frequency'],'label'=>false)); ?>
                            </td>
                            
                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','class' => 'day','autocomplete'=>'off','id'=>"day$k",'style'=>'margin: 0 0 0 10px;','name' => 'day[]','value'=>$data['NewCropPrescription']['day'],'label'=>false)); ?>
                            </td>

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('size'=>2,'type'=>'text','autocomplete'=>'off','class' => "quantity_$k",'id'=>"quantity$k",'style'=>'margin: 0 0 0 10px;','name' => 'quantity[]','value'=>$data['NewCropPrescription']['quantity'],'label'=>false)); ?>
                            </td>

                            <td align="left" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array( 'options'=>Configure :: read('refills'),'empty'=>'Select','style'=>'width:80px','class' => '','id'=>"refills$k",'name' => 'refills[]','value'=>$data['NewCropPrescription']['refills'],'label'=>false));  ?>
                            </td>

                            <td align="center" valign="top" style=""><?php $options = array('1'=>'Yes','0'=>'No');
                                        echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"prn$k",'name' => 'prn[]','value'=>$data['NewCropPrescription']['prn'],'label'=>false));?>
                            </td>

                            <td align="center" valign="top" style=""><?php echo $this->Form->input('', array( 'options'=>$options,'class' => '','id'=>"daw$k",'name' => 'daw[]','value'=>$data['NewCropPrescription']['daw'],'label'=>false));?>
                            </td>

                            <td align="center" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','size'=>16, 'class'=>'my_start_date1 textBoxExpnd','name'=> 'start_date[]','value'=>$data['NewCropPrescription']['start_date'], 'id' =>"start_date".$k ,'counter'=>$count,'label'=>false,'readonly'=>'readonly' )); ?>
                            </td>

                            <td align="center" valign="top" style="padding-right: 3px"><?php echo $this->Form->input('', array('type'=>'text','size'=>16,'class'=>'my_end_date1 textBoxExpnd','name'=> 'end_date[]','value'=>$data['NewCropPrescription']['end_date'],'id' => "end_date".$k,'counter'=>$count,'label'=>false,'readonly'=>'readonly')); ?>
                            </td>

                            <td align="center" valign="top" style=""><?php $options_active = array('1'=>'Yes','0'=>'No');
                                        echo $this->Form->input('', array( 'options'=>$options_active,'class' => '','id'=>"isactive$k",'name' => 'isactive[]','value'=>$data['NewCropPrescription']['isactive'],'label'=>false));?>
                            </td>
                            <td align="center" valign="top" style=""><?php $options_avd = array('0'=>'No','1'=>'Yes'); 
                                        echo $this->Form->input('', array( 'options'=>$options_avd,'class' => "isadv",'id'=>"isadv$k",'name' => 'isadv[]','value'=>$data['NewCropPrescription']['is_med_administered'],'label'=>false));?>
                            </td>
                            <!-- <td><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','class'=>'DrugGroup_history','id'=>"pMH$k"));?>
                            </td> -->
                            </tr>
                            <?php }?>
                            
                        <?php }?>
                        </table>
                    </td>
                </tr>
                <!-- row 3 end -->
                <?php if(empty($getMedicationRecords)){?>
                  <tr>
                    
                    <td align="left" style="padding-left: 20px" colspan='6'>
                        <input type="button" id="addButton" value="Add Row"> <?php if($count > 0){?>
                        <input type="button" id="removeButton" value="Remove"> <?php }else{ ?> 
                        <input type="button" id="removeButton" value="Remove"  style="display: none;"> <?php } ?></td>
                </tr>
                <?php }?>
                
                <tr>
                    <!--  <td class="tdLabel"><?php 
                     echo $this->Form->input('no_medication', array('type'=>'checkbox','id'=>'namecheck',
                                        'checked'=>$checked,'disabled'=>false,'label'=> false, 'div' => false, 'error' => false));?>
                        <?php echo __("No Medications Currently Prescribed");?></td>-->
                    <td align='left'><?php if(empty($getMedicationRecords)){ echo $this->Html->link('Frequently Prescribed Medication',
                                    'javascript:void(0)',array('onclick'=>'frequentMedication('.$Uid.','.$patientHealthPlanIDfreq.');'));}?>    
                    </td>
                    <td align='right'>
                    <?php if(!empty($encPatientId)){
                        echo $this->Html->link(__('Back'), array('controller'=>'Notes','action' => 'soapNote',$encPatientId,$noteId,'appt'=>$this->params->query['appt'],'#'=>'item'.$this->params->query['widgetId'],'?'=>array('expand'=>'Plan')), array('class'=>'blueBtn','style'=>'float:right; width:40px; height:15px !important; text-align:center;'));
                    }else{?>
                    <?php echo $this->Html->link(__('Back'), array('controller'=>'Notes','action' => 'soapNote',$patientId,$noteId,'appt'=>$this->params->query['appt'],'#'=>'item'.$this->params->query['widgetId'],'?'=>array('expand'=>'Plan')), array('class'=>'blueBtn','style'=>'float:right; width:40px; height:15px !important; text-align:center;'));}?>
                    <?php echo $this->Form->submit(__('Update Medication'),array('id'=>'','class'=>'blueBtn','onclick'=>"javascript:save_med();return false;",'style'=>'float:right; width:150px; margin: 0 10px 0 0;')); ?>
                    </td>
                    

                </tr>
                <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            </table>
        </td>
    </tr>
</table>
<?php echo $this->Form->end(); ?>
<div id="formularyData"></div>
<script>
var currentDateForAddMore='';
var splitCurrentDateForAddMore='';
        $('.drugText').live('focus',
                function() {
                    var currentId=  $(this).attr('id').split("_"); // Important
                    var attrId = this.id;
                    
                var counter = $(this).attr(
                            "counter");
                    
                    if ($(this).val() == "") {
                        $("#Pack" + counter).val("");
                    }
                    $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','Status=A',"admin" => false,"plugin"=>false)); ?>",
                                    {   width : 250,
                                        selectFirst : true,
                                        valueSelected:true,
                                        minLength: 3,
                                        delay: 1000,
                                        isOrderSet:true,
                                        showNoId:true,
                                        loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'_')+','+$(this).attr('id').replace("drugText_",'dose_type')
                                        +','+$(this).attr('id').replace("drugText_",'strength')
                                            +','+$(this).attr('id').replace("drugText_",'route_administration'),
                                        
                                    });
                    

                });//EOF autocomplete
                //add n remove drud inputs
                var counter = '<?php echo $count?>';
                var calenderAry = new Array();
                 $("#addButton").click(
                            function() {
                                //$("#patientnotesfrm").validationEngine('detach');  
                                var newCostDiv = $(document.createElement('tr'))
                                     .attr("id", 'DrugGroup' + counter);
                                var str_option_value='<?php echo $str;?>';
                                var route_option_value='<?php echo $str_route;?>';
                                var dose_option_value='<?php echo $str_dose;?>'; 
                                var freq_option_value='<?php echo $freq_dose;?>';
                                var dose_option ='<select style="" id="dose_type'+counter+'" class="validate[required,custom[mandatory-select]] dose_val" name="dose_type[]"><option value="">Select</option>'+dose_option_value;
                                var dosage_form = '<select style="margin: 0 0 0 0px;", id="Dfrom'+counter+'" class="validate[required,custom[mandatory-select]] dosageform" name="DosageForm[]"><option value="">Select</option><option value="1">APPLICATION</option><option value="3">DROP</option><option value="4">GM</option><option value="19">%</option><option value="5">LOZENGE</option><option value="6">ML</option><option value="7">PATCH</option><option value="8">PILL</option><option value="9">PUFF</option><option value="10">SQUIRT</option><option value="11">SUPPOSITORY</option><option value="13">TROCHE</option><option value="14">UNIT</option><option value="16">PACKAGE</option><option value="17">MCG</option><option value="18">MG</option></select>';
                                var unit = '<input class="validate[required,custom[mandatory-select]" type="text" style="width:50px!important;" name="unit[]" id="unit'+counter+'"></input>';
                                var dosage_form2 = '<select class="validate[required,custom[mandatory-select]" id="DfromType' + counter + '" name="DfromType[]"><option value="">Select</option><option value="tablet">tablet</option><option value="application">application</option><option value="capsule">capsule</option><option value="drop">drop</option><option value="patch">patch</option><option value="pill">pill</option><option value="puff">puff</option><option value="syringe">syringe</option><option value="package">package</option></select>';
                                var route_option = '<select style="width:67px;margin: 0 0 0 0px;" id="route_administration'+counter+'" class="validate[required,custom[mandatory-select]] frequency" name="route_administration[]"><option value="">Select</option>'+route_option_value;
                var frequency_option = '<select  style="width:67px;margin: 0 0 0 0px;"  id="frequency_'+counter+'" class="validate[required,custom[mandatory-select]] frequency_value" name="frequency[]"><option value="">Select</option>'+freq_option_value;
                var strength_option = '<select style="width:79px;" id="strength'+counter+'" class="frequency" name="strength[]"><option value="">Select</option>'+str_option_value;
                var refills_option = '<select style="width:80px;" id="refills_'+counter+'" class="frequency" name="refills[]"><option value="">Select</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
                var prn_option = '<select style="width:auto;" id="prn'+counter+'" class="" name="prn[]"><option value="1">Yes</option><option value="0">No</option></select>';
                var daw_option = '<select style="width:auto;" id="daw'+counter+'" class="" name="daw[]"><option value="1">Yes</option><option value="0">No</option></select>';
                var active_option = '<select  id="isactive'+counter+'" class="" name="isactive[]"><option value="1">Yes</option><option value="0">No</option></select>';
                
                                var is_adv = '<select id="isadv'+counter+'" class="isadv" name="isadv[]"><option value="0">No</option><option value="1">Yes</option></select>';
                                //var route_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
                                var options = '<option value=""></option>';
                    for (var i = 1; i < 25; i++) {
                        if (i < 13) {
                            str = i + 'am';
                        } else {
                            str = (i - 12) + 'pm';
                        }
                        options += '<option value="'+i+'"'+'>'
                                + str + '</option>';
                    }

                    timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
                            + options
                            + '</select></td> ';
                    timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 67px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
                            + options
                            + '</select></td> ';
                    timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
                            + options
                            + '</select></td> ';
                    timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
                            + options
                            + '</select></td> ';
                    timer = timerHtml1 + timerHtml2
                            + timerHtml3 + timerHtml4
                            + '</tr></table></td>';
                    var newHTml = '<td valign="top"><input  type="text" style="width:150px!important;" value="" id="drugText_' + counter + '"  class=" drugText validate[required,custom[mandatory-enter]]" name="drugText[]" autocomplete="off" counter='+counter+'>'+
                                        '<input  type="hidden" class="allHiddenId" id="drug_' + counter + '"  name="drug_id[]" > <span id="drugType_' + counter + '"></span>&nbsp;<span id="formularylinkId_' + counter + '"></span></td><td valign="top">'
                            + unit
                            + '</td><td valign="top">'
                            + dosage_form
                            + '</td><td valign="top">'
                            + dose_option
                            + '</td><td valign="top">'
                            + dosage_form2
                            + '</td><td valign="top">'
                            + route_option
                            + '</td>'
                            
                            + '<td valign="top">'
                            + frequency_option
                            + '</td>'
                            + '<td valign="top" ><input size="2" type="text" value="" id="day'+counter+'" class="day" name="day[]" "autocomplete"="off" style="margin: 0 0 0 10px;"></td>'
                            + '<td valign="top"><input size="2" type="text" value="" id="quantity'+counter+'" class="quantity_'+counter+'" name="quantity[]" style="margin: 0 0 0 10px;"></td>'
                            + '<td valign="top">'
                            + refills_option
                            + '</td>'
                            + '<td valign="top" align="center">'
                            + prn_option
                            + '</td>'
                            + '<td valign="top" align="center">'
                            + daw_option
                            + '</td>'
                            + '<td valign="top" align="center"><input  type="text" value="" id="start_date' + counter + '"  class="my_start_date'+ counter +' textBoxExpnd" name="start_date[]"  size="16" counter='+counter+' readonly="readonly"></td>'
                            + '<td valign="top" align="center"><input  type="text" value="" id="end_date' + counter + '"  class="my_end_date'+ counter +' textBoxExpnd" name="end_date[]"  size="16" counter='+counter+' readonly="readonly"></td>'
                            + '<td valign="top" align="center">'
                            + active_option
                            +'</td>'
                            + '<td valign="top" align="center">'
                            + is_adv
                            + '</td>';

                    //newCostDiv.append(newHTml);
                    //newCostDiv.appendTo("#DrugGroup");
                    //$("#patientnotesfrm").validationEngine('attach');                          
                    newCostDiv.append(newHTml);      
                    newCostDiv.appendTo("#DrugGroup");  
                    //$("#patientnotesfrm").validationEngine('attach');                      
                    var endDate = $("#start_date"+counter).val();
                        spltEndDate = endDate.split(' ');
                        spltEndDate[0] = spltEndDate[0].split('/');
                        spltEndDate[0][1]--;
                        spltEndDate = spltEndDate[0]+','+spltEndDate[1];
                        var dateStr = '';
                            $("#start_date"+counter).datepicker({
                                showOn : 'both',
                                changeYear : true,
                                changeMonth : true,
                                yearRange : '1950',
                                buttonText: "Calendar",
                                buttonImageOnly : true,
                                dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
                                minDate:new Date(<?php echo $this->General->minDate(date('Y-m-d')); ?>),
                                buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                                onSelect : function(selDate) {
                                    spltDateSplitted = selDate.split(' ');
                                    var splitDate = spltDateSplitted[0].split("/");
                                      splitDate[1]--;
                                      dateStr = splitDate+' '+spltDateSplitted[1];
                                      
                                //    $("#end_date"+counter).datepicker("destroy");

                                   
                                      $("#end_date"+counter).datepicker({
                                            changeMonth : true,
                                            changeYear : true,
                                            yearRange : '1950',
                                            dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
                                            showOn : 'both',
                                            buttonText: false ,
                                            minDate: new Date(dateStr),
                                            buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                                            buttonImageOnly : true,
                                            buttonText: "Calendar",
                                            onSelect : function() {
                                                if($("#start_date"+counter).val() == '') $(this).val('');
                                            }
                                        });
                                }
                            });

                          $("#end_date"+counter).datepicker({
                                changeMonth : true,
                                changeYear : true,
                                yearRange : '1950',
                                dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
                                showOn : 'both',
                                buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                                buttonImageOnly : true,
                                buttonText: "Calendar",
                                minDate: new Date(),
                                onSelect : function() {
                                    if($("#start_date"+counter).val() == '') $(this).val('');
                                }
                            });
                            
                    counter++;
                    if (counter > 0)
                        $('#removeButton').show('slow');
                });

                    
                    $(document).ready(function(){
                    $(".drugText").keypress(function(e){
                        //$(".drugText ").keypress(function(e) {
                        if(e.which == 13) {
                            return;
                            var newCostDiv = $(document.createElement('tr'))
                                     .attr("id", 'DrugGroup' + counter);
                                var str_option_value='<?php echo $str;?>';
                                var route_option_value='<?php echo $str_route;?>';
                                var dose_option_value='<?php echo $str_dose;?>'; 
                                var freq_option_value='<?php echo $freq_dose;?>';
                                var dose_option ='<select style="" id="dose_type'+counter+'" class="validate[required,custom[mandatory-select]] dose_val" name="dose_type[]"><option value="">Select</option>'+dose_option_value;
                                var dosage_form = '<select style="margin: 0 0 0 0px;" id="Dfrom'+counter+'" class="validate[optional,custom[mandatory-select]] dosageform" name="DosageForm[]"><option value="">Select</option><option value="1">APPLICATION</option><option value="3">DROP</option><option value="4">GM</option><option value="19">%</option><option value="5">LOZENGE</option><option value="6">ML</option><option value="7">PATCH</option><option value="8">PILL</option><option value="9">PUFF</option><option value="10">SQUIRT</option><option value="11">SUPPOSITORY</option><option value="13">TROCHE</option><option value="14">UNIT</option><option value="16">PACKAGE</option><option value="17">MCG</option><option value="18">MG</option></select>';
                                var route_option = '<select style="width:67px;margin: 0 0 0 0px;" id="route_administration'+counter+'" class="validate[required,custom[mandatory-select]] frequency" name="route_administration[]"><option value="">Select</option>'+route_option_value;
                var frequency_option = '<select  style="width:67px;margin: 0 0 0 0px;", id="frequency_'+counter+'" class="validate[optional,custom[mandatory-select]] frequency_value " name="frequency[]"><option value="">Select</option>'+freq_option_value;
                var strength_option = '<select style="width:79px;" id="strength'+counter+'" class="frequency" name="strength[]"><option value="">Select</option>'+str_option_value;
                var refills_option = '<select style="width:80px;" id="refills_'+counter+'" class="frequency" name="refills[]"><option value="">Select</option><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
                var prn_option = '<select style="width:auto;" id="prn'+counter+'" class="" name="prn[]"><option value="1">Yes</option><option value="0">No</option></select>';
                var daw_option = '<select style="width:auto;" id="daw'+counter+'" class="" name="daw[]"><option value="1">Yes</option><option value="0">No</option></select>';
                var active_option = '<select  id="isactive'+counter+'" class="" name="isactive[]"><option value="1">Yes</option><option value="0">No</option></select>';
                
                                var is_adv = '<select id="isadv'+counter+'" class="isadv" name="isadv[]"><option value="0">No</option><option value="1">Yes</option></select>';
                                //var route_opt = '<td><input type="text" size=2 value="" id="quantity'+counter+'" class="" name="quantity[]"></td>';
                                var options = '<option value=""></option>';
                    for (var i = 1; i < 25; i++) {
                        if (i < 13) {
                            str = i + 'am';
                        } else {
                            str = (i - 12) + 'pm';
                        }
                        options += '<option value="'+i+'"'+'>'
                                + str + '</option>';
                    }

                    timerHtml1 = '<td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width="25%" height="20" align="center" valign="top"><select class="first" style="width: 80px;" id="first_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
                            + options
                            + '</select></td> ';
                    timerHtml2 = '<td width="25%" height="20" align="center" valign="top"><select class="second" style="width: 67px;" id="second_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
                            + options
                            + '</select></td> ';
                    timerHtml3 = '<td width="25%" height="20" align="center" valign="top"><select class="third" style="width: 80px;" id="third_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
                            + options
                            + '</select></td> ';
                    timerHtml4 = '<td width="25%" height="20" align="center" valign="top"><select class="forth" style="width: 80px;" id="forth_'+counter+'" disabled="" name="drugTime['+counter+'][]">'
                            + options
                            + '</select></td> ';
                    timer = timerHtml1 + timerHtml2
                            + timerHtml3 + timerHtml4
                            + '</tr></table></td>';
                    var newHTml = '<td valign="top"><input  type="text" style="width:150px!important;" value="" id="drugText_' + counter + '"  class=" drugText validate[required,custom[mandatory-enter]]" name="drugText[]" autocomplete="off" counter='+counter+'>'+
                                        '<input  type="hidden" class="allHiddenId" id="drug_' + counter + '"  name="drug_id[]" > <span id="drugType_' + counter + '"></span>&nbsp;<span id="formularylinkId_' + counter + '"></span></td><td valign="top">'
                            + dose_option
                            + '</td><td valign="top">'
                            + dosage_form
                            + '</td><td valign="top">'
                            + route_option
                            + '</td>'
                            
                            + '<td valign="top">'
                            + frequency_option
                            + '</td>'
                            + '<td valign="top" ><input size="2" type="text" value="" id="day'+counter+'" class="day" name="day[]" "autocomplete"="off" style="margin: 0 0 0 10px;"></td>'
                            + '<td valign="top"><input size="2" type="text" value="" id="quantity'+counter+'" class="quantity_'+counter+'" name="quantity[]" style="margin: 0 0 0 10px;"></td>'
                            + '<td valign="top">'
                            + refills_option
                            + '</td>'
                            + '<td valign="top" align="center">'
                            + prn_option
                            + '</td>'
                            + '<td valign="top" align="center">'
                            + daw_option
                            + '</td>'
                            + '<td valign="top" align="center"><input  type="text" value="" id="start_date' + counter + '"  class="my_start_date'+ counter +' textBoxExpnd" name="start_date[]"  size="16" counter='+counter+'></td>'
                            + '<td valign="top" align="center"><input  type="text" value="" id="end_date' + counter + '"  class="my_end_date'+ counter +' textBoxExpnd" name="end_date[]"  size="16" counter='+counter+'></td>'
                            + '<td valign="top" align="center">'
                            + active_option
                            +'</td>'
                            + '<td valign="top" align="center">'
                            + is_adv
                            + '</td>';

                    //newCostDiv.append(newHTml);
                    //newCostDiv.appendTo("#DrugGroup");
                    //$("#patientnotesfrm").validationEngine('attach');                          
                    newCostDiv.append(newHTml);      
                    newCostDiv.appendTo("#DrugGroup");  
                    //$("#patientnotesfrm").validationEngine('attach');                      
                    var endDate = $("#start_date"+counter).val();
                        spltEndDate = endDate.split(' ');
                        spltEndDate[0] = spltEndDate[0].split('/');
                        spltEndDate[0][1]--;
                        spltEndDate = spltEndDate[0]+','+spltEndDate[1];
                        var dateStr = '';
                            $("#start_date"+counter).datepicker({
                                showOn : 'both',
                                changeYear : true,
                                changeMonth : true,
                                yearRange : '1950',
                                buttonText: "Calendar",
                                buttonImageOnly : true,
                                dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
                                minDate:new Date(<?php echo $this->General->minDate(date('Y-m-d')); ?>),
                                buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                                onSelect : function(selDate) {
                                    spltDateSplitted = selDate.split(' ');
                                    var splitDate = spltDateSplitted[0].split("/");
                                      splitDate[1]--;
                                      dateStr = splitDate+' '+spltDateSplitted[1];
                                      
                                //    $("#end_date"+counter).datepicker("destroy");

                                   
                                      $("#end_date"+counter).datepicker({
                                            changeMonth : true,
                                            changeYear : true,
                                            yearRange : '1950',
                                            dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
                                            showOn : 'both',
                                            buttonText: false ,
                                            minDate: new Date(dateStr),
                                            buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                                            buttonImageOnly : true,
                                            buttonText: "Calendar",
                                            onSelect : function() {
                                                if($("#start_date"+counter).val() == '') $(this).val('');
                                            }
                                        });
                                }
                            });

                          $("#end_date"+counter).datepicker({
                                changeMonth : true,
                                changeYear : true,
                                yearRange : '1950',
                                dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
                                showOn : 'both',
                                buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                                buttonImageOnly : true,
                                buttonText: "Calendar",
                                minDate: new Date(),
                                onSelect : function() {
                                    if($("#start_date"+counter).val() == '') $(this).val('');
                                }
                            });
                            
                    counter++;
                    if (counter > 0)
                        $('#removeButton').show('slow');
                        }
                        });


                        var endDate = $("#start_date0").val();
                        spltEndDate = endDate.split(' ');
                        spltEndDate[0] = spltEndDate[0].split('/');
                    //  spltEndDate[0][1]--;
                        spltEndDate = spltEndDate[0]+','+spltEndDate[1];
                            $("#start_date0").datepicker({
                                showOn : 'both',
                                changeYear : true,
                                changeMonth : true,
                                yearRange : '1950',
                                buttonText: "Calendar",
                                buttonImageOnly : true,
                                dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
                                minDate:new Date(<?php echo $this->General->minDate(date('Y-m-d')); ?>),
                                buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                                onSelect : function(selDate) {
                                    spltDateSplitted = selDate.split(' ');
                                    var splitDate = spltDateSplitted[0].split("/");
                                    //  splitDate[1]--;
                                      var dateStr = splitDate+' '+spltDateSplitted[1];
                                    //tt(dateStr);
                                    $("#end_date0").datepicker("option", "minDate", new Date(splitDate[2], splitDate[0], splitDate[1], 0, 0, 0, 0));
                                }
                            });

                          function tt(dateStr){
                            // $('#end_date0').removeClass('hasDatepicker');
                             $("#end_date0").datepicker("destroy");
                             // $._clearDate(); 
                              $("#end_date0").datepicker({
                                    changeMonth : true,
                                    changeYear : true,
                                    yearRange : '1950',
                                    dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
                                    showOn : 'both',
                                    buttonText: false ,
                                    //minDate: 
                                    buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                                    buttonImageOnly : true,
                                    buttonText: "Calendar",
                                    onSelect : function() {
                                        if($("#start_date0").val() == '') $(this).val('');
                                    }
                                });
                              
                          }
                            
                            
                            $("#end_date0").datepicker({
                                changeMonth : true,
                                changeYear : true,
                                yearRange : '1950',
                                dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
                                showOn : 'both',
                                buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
                                buttonImageOnly : true,
                                buttonText: "Calendar",
                                //minDate: new Date(),
                                onSelect : function() {
                                    if($("#start_date0").val() == '') $(this).val('');
                                }
                            });
                        
                    });
                    $("#removeButton").click(function() {
                        /*if(counter==3){
                          alert("No more textbox to remove");
                          return false;
                        }  */
                        counter--;

                        
                        $("#DrugGroup"+counter).remove();
                        if (counter == 0)
                            $('#removeButton').hide('slow');
                    });

                 $('.DrugGroup_history').live('click',function (){
                    if(confirm("Do you really want to delete this record?")){
                        var trId = $(this).attr('id').replace("pMH","DrugGroup");
                        $('#' + trId).remove();
                        counter--;           
                        if(counter == 0) $('#removeButton').hide('slow');
                    }else{
                        return false;
                    }

                    if('<?php echo $getMedicationRecords[0][NewCropPrescription][id];?>'!=''){
                    currentId = '<?php echo $getMedicationRecords[0][NewCropPrescription][id];?>';
                    }else{
                        currentId='null';
                    }

                    if('<?php echo $getMedicationRecords[0][NewCropPrescription][drug_id];?>'!=''){
                        drugId = '<?php echo $getMedicationRecords[0][NewCropPrescription][drug_id];?>';
                    }else{
                        drugId='null';
                    }
                    
                    is_deleted='1';
                    $.ajax({
                              type : "POST",
                              url: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addMedication",$patientId,"admin" => false)); ?>"+"/"+drugId+"/"+currentId+"/"+is_deleted,
                              context: document.body,   
                            //  data : "value="+value,
                              beforeSend:function(){
                                  loading('loading','class');
                              },              
                              success: function(data){
                                  window.location.href="<?php echo $this->Html->url(array('controller'=>'Notes','action' => 'soapNote',$encPatientId,$noteId,'appt'=>$this->params->query['appt'],'#'=>'item'.$this->params->query['widgetId'],'?'=>array('expand'=>'Plan')))?>",//+"/"+null+"?msg=saved",
                                    //$('#flashMessage', parent.document).html("Medication Deleted Successfully.");
                                    //$('#flashMessage', parent.document).show();
                                  onCompleteRequest('loading','class')();
                              }
                        });         
                    //}         
                     
                    

                    
                 });
                    function save_med(isOverride){
                        var checkExit='0';
                        var validateDiagnosis = jQuery("#patientnotesfrm").validationEngine('validate');
                        jQuery('.allHiddenId').each(function() {
                            var currentElement = $(this);
                            var value = currentElement.val(); 
                            if(value==''){
                                var currentElementId = $(this).attr('id');
                                var faultValue=currentElementId.split('_');
                                var faultNameById=$('#drugText_'+faultValue['1']).val();
                                checkExit++;
                                
                            }
                        });
                        if(checkExit>0){
                            //return false;
                        }
                        if (validateDiagnosis) {
                            $(this).css('display', 'none');
                        }else{
                            return false ;
                        }
                        if((isOverride!='1')||(isOverride==='undefined')){
                            isOverride='0';
                        }
                        else{
                            var chkConfrim=confirm('Are you sure you want to override?');
                            if($.trim(chkConfrim)=='false'){
                                 $('#successMsg').show();
                                 $('#successMsg').html("Please change the medication.");
                                 $('#busy-indicator').hide('fast');
                                 return false;
                            }
                            isOverride=isOverride;
                        }
                        var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "save_med","admin" => false)); ?>"+"/"+isOverride;
                        var ClinicalEffects='';
                        $.ajax({
                            type : "POST",
                            data:$('#patientnotesfrm').serialize(),
                            url : ajaxUrl , 
                            beforeSend : function() {
                                loading('loading','class');
                                },
                            //context : document.body,
                            success: function(data){
                                if((data != '') && (data !== undefined) && (data != 1)){
                                    data = jQuery.parseJSON(data);
                                    //console.log(data);
                                    if(data.DrugDrug != null ){
                                        $.each(data.DrugDrug,function(index,value){
                                            ClinicalEffects+=value;
                                            ClinicalEffects += '</br>';
                                        });
                                        //if(data.DrugDrug.SeverityLevel!=null){
                                            ////var ClinicalEffects= data.DrugDrug.rowDta.DrugInteraction.ClinicalEffects;
                                            $('#showInteractions').show();
                                            $('#showInteractions').html(ClinicalEffects);

                                            //var SeverityLevel=data.DrugDrug.rowDta.DrugInteraction.SeverityLevel;
                                            $('#showsevirity').show();
                                            $('#showsevirity').html(ClinicalEffects);
                                        //} 
                                    }else{
                                        $('#interactionData').html("");
                                    }
                                    
                                    
                                    var allergy='';
                                if(data.Interaction!= null){
                                    //console.log(data.Interaction.rowDta);
                                    $.each(data.Interaction,function(index,value){
                                        //alert(value);
                                        //return false;
                                        allergy+=value;
                                        allergy += '</br>';
                                    });
                                  //  var interactionData=data.Interaction;
                                    $('#interactionData').show();
                                    $('#interactionData').html("ALLERGY INTERACTION:<br/>"+allergy);
                                }else{
                                    $('#interactionData').html("");
                                }
                                    $('#overRide').show();
                                    $('#overRideButton').show();
                                    onCompleteRequest('loading','class')();
                                    return false;
                                
                                }else{
                                     
                                        $('#showsevirity').hide();
                                        $('#showInteractions').hide();
                                        $('#overRide').hide();
                                        $('#overRideButton').hide();
                                        $('#interactionData').hide();
                                        $('#busy-indicator').hide('fast');
                                        if('<?php echo $encPatientId?>'!=''){
                                        window.location.href='<?php echo $this->Html->url(array("controller"=>'notes',"action" => "soapNote",$encPatientId,$noteId,'appt'=>$this->params->query['appt'],'#'=>'item'.$this->params->query['widgetId'],'?'=>array('expand'=>'Plan')));?>'
                                        }else{
                                            window.location.href='<?php echo $this->Html->url(array("controller"=>'notes',"action" => "soapNote",$patientId,$noteId,'appt'=>$this->params->query['appt'],'#'=>'item'.$this->params->query['widgetId'],'?'=>array('expand'=>'Plan')));?>'
                                        }
                                                    $( '#flashMessage', parent.document).html("Medication saved succesfully.");
                                        $('#flashMessage', parent.document).show();
                                        //parent.$.fancybox.close();
                                    
                                }
                                },
                            
                            error: function(message){
                            alert("Connection Error please try after some time.");
                            }
                            
                        });
                    }
                    
                    
        $('.frequency_value').live('change',function(){ 
            currentId = $(this).attr('id') ;
            splittedVar = currentId.split("_");      
            Id = splittedVar[1];

            if($(this).val()=='32'){
                $('#dose_type'+Id).val('2');    
                $('#day'+Id).val('1');
                $('#quantity'+Id).val('1');
                return false;
            }else if($('#frequency_'+Id).val()=='31'){ 
                $('#day'+Id).val('1');
                freq='1';
                dose=$('#dose_type'+Id+' option:selected').text();
                if($('#dose_type'+Id).val()=='')dose='1';
                if(dose=='As directed')dose='1';
                if(dose=='0.5/half')dose='0.5';
                if(dose=='1-2')dose='2';
                if(dose=='1-3')dose='3';
                if(dose=='2-3')dose='3';
                if(dose=='0.33/third')dose='0.33';
                if(dose=='0.5-1')dose='1';
                qty=(dose)*(freq);
                qtyId=$('#quantity'+Id).val(qty);
                $('#dose_type'+Id).val('2'); 
            }else if($('#dose_type'+Id).val()=="" || $('#frequency_'+Id).val()==""){
                $('#quantity'+Id).val("");
                return false;
            }else{
                freq_val = <?php echo json_encode(Configure::read('frequency_value'));?>;
                freq=$(this).val(); 
                dose=$('#dose_type'+Id+' option:selected').text();
                if(dose=='As directed')dose='1';
                if(dose=='0.5/half')dose='0.5';
                if(dose=='1-2')dose='2';
                if(dose=='1-3')dose='3';
                if(dose=='2-3')dose='3';
                if(dose=='0.33/third')dose='0.33';
                if(dose=='0.5-1')dose='1';
                freq_val1=freq_val[$.trim(freq)];
                qty=(dose)*(freq_val1);
                qtyId=$('#quantity'+Id).val(qty);
                $('#day'+Id).val("30");
            }
        });

        $('.dose_val').live('change',function(){ 
            currentId = $(this).attr('id') ;
            Id = currentId.slice(-1);

            if($('#dose_type'+Id).val()=="" || $('#frequency_'+Id).val()==""){
                $('#quantity'+Id).val("");
                return false;
            }else if($('#frequency_'+Id).val()=='31'){ 
                $('#day'+Id).val('1');
                doseID=$(this).attr('id');
                dose=$('#'+doseID+' option:selected').text();
                if(dose=='As directed')dose='1';
                if(dose=='0.5/half')dose='0.5';
                if(dose=='1-2')dose='2';
                if(dose=='1-3')dose='3';
                if(dose=='2-3')dose='3';
                if(dose=='0.33/third')dose='0.33';
                if(dose=='0.5-1')dose='1';
                freq='1';
                qty=(dose)*(freq); 
                qtyId=$('.quantity_'+Id).val(qty);
            }else if($('#frequency_'+Id).val()=='32'){ 
                $('#day'+Id).val('1');
                doseID=$(this).attr('id');
                dose=$('#'+doseID+' option:selected').text();
                if(dose=='As directed')dose='1';
                if(dose=='0.5/half')dose='0.5';
                if(dose=='1-2')dose='2';
                if(dose=='1-3')dose='3';
                if(dose=='2-3')dose='3';
                if(dose=='0.33/third')dose='0.33';
                if(dose=='0.5-1')dose='1';
                freq='1';
                qty=(dose)*(freq); 
                qtyId=$('.quantity_'+Id).val(qty);
            }else{
                doseID=$(this).attr('id');
                dose=$('#'+doseID+' option:selected').text();
                if(dose=='As directed')dose='1';
                if(dose=='0.5/half')dose='0.5';
                if(dose=='1-2')dose='2';
                if(dose=='1-3')dose='3';
                if(dose=='2-3')dose='3';
                if(dose=='0.33/third')dose='0.33';
                if(dose=='0.5-1')dose='1';
                freq=$('#frequency_'+Id).val();
                freq_val = <?php echo json_encode(Configure::read('frequency_value'));?>;
                freq_val1=freq_val[$.trim(freq)];
                qty=(dose)*(freq_val1);
                qtyId=$('.quantity_'+Id).val(qty);
                $('#day'+Id).val("30");
            }
        });

    
        /*
        $('#oversubmit').click(function(){
            if($('#overText').val()==''){
                alert('Please Override Text');
                return false;
            }
            });
        */
        /* audit for the inactive medications Aditya*/
        $('.showLogPopUp').change(function(){
            //newCrop
            var currentIdOfDropDown=$(this).attr('id');
            var currentValue=$('#'+currentIdOfDropDown).val();
            if(currentValue=='0'){
                $('#showlogTextArea').show();
            }
            });

        function selectAlternateDrug(patientId,drugId,healthPlanId,sequenceNo)
        {
            
                $.ajax({

                    
                 type: 'POST',
                 url:  "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getAlternateDrugFormulary", "admin" => false)); ?>"+"/"+patientId+"/"+drugId+"/"+healthPlanId+"/"+sequenceNo,
                 dataType: 'html',
                 beforeSend:function(){ 
                     $('#busy-indicator').show('fast');; 
                 },
                 success: function(data){       
                      data = data.trim();   
                         
                      if(data != ''){
                          $("#formularyData").html(data);
                          
                         
                      }else{
                          inlineMsg(id,$('#loading-text').html(),10); 
                         
                      }
                      $('#busy-indicator').hide('fast');; 
                 },
                 error: function(message){
                      inlineMsg(id,$('#loading-text').html(),5);         
                       
                 }        
            });
            
        }
        /*----------------EOF-----------------------*/
        function frequentMedication(patientId,healthPlanId)
        {
                $.ajax({
                 type: 'POST',
                 url:  "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "getFrequentMedication", "admin" => false)); ?>"+"/"+patientId+"/"+healthPlanId,
                 dataType: 'html',
                 beforeSend:function(){ 
                     $('#busy-indicator').show('fast');; 
                 },
                 success: function(data){       
                      data = data.trim();   
                         
                      if(data != ''){
                          $("#formularyData").html(data);
                          
                         
                      }else{
                          inlineMsg(id,$('#loading-text').html(),10); 
                         
                      }
                      $('#busy-indicator').hide('fast');; 
                 },
                 error: function(message){
                      inlineMsg(id,$('#loading-text').html(),5);         
                       
                 }        
            });
            
        }

        /*$('.isadv').live('change',function(){
            if($(this).val()=='1'){
                currentId = $(this).attr('id') ;
                Id = currentId.slice(-1);
                $('#dose_type'+Id).val('2');    
                $('#frequency_'+Id).val('32');
                $('#day'+Id).val('1');
                $('#quantity'+Id).val('1');
            }
        });*/


$('#changeMed').click(function(){
    $('#newMed').show();
    return false;
});

$('#newMed').change(function(){ 
    if($(this).val() !=""){
        valmed=document.getElementById("newMed").options[document.getElementById('newMed').selectedIndex].text;
        $('.medName').val(valmed);
        $('.allHiddenId').val($(this).val());
    }
});
</script>
