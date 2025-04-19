<?php 
    echo $this->Html->script(array('ui.timepicker.js?v=0.3.1'));
    echo $this->Html->css(array('ui.ui.timepicker'));
	$intake_detail = unserialize($PatientIvf['PatientIvf']['intake_detail']);
?>
<style>
.formError .formErrorContent{
width:60px;
}
.tabularForm {
    margin: 10px;
}
.textBoxExpnd{padding:3px;}
</style>
 <div class="inner_title">
	<h3><?php echo __('I.V.F. - Edit'); ?></h3>
 </div>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
 

	   <p class="ht5"></p> 
	   <!-- billing activity form start here -->
	 <?php echo $this->Form->create('PatientIvf');?>      
			 <table width="98%" border="0" cellspacing="0" cellpadding="0"  class="tabularForm">
                              <tr>
                                <td >Date:<font color="red">*</font> &nbsp;<input name="PatientIvf[date]" type="text" class="textBoxExpnd validate[required]" id="date" style="width:100px;" value="<?php echo  $this->DateFormat->formatDate2local($PatientIvf['PatientIvf']['date'],Configure::read('date_format')); ?>"/></td>
                                
                              </tr>
                            </table> 
                 
			 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" id="tabularForm">
                      <tr>
                      		<th   align="center" style="text-align:center; min-width:40px;">TIME<font color="red">*</font> </th>
                        	<th   align="center" style="text-align:center;">TEMP</th>
                            <th   align="center" style="text-align:center;">PULSE</th>
                            <th  align="center" style="text-align:center;">RR</th>
                            <th  align="center" style="text-align:center;">BP</th>
                            <th  align="center" style="text-align:center;">CVP</th>
                            <th  align="center" style="text-align:center;">SPO<sub>2</sub></th>
                            <th  align="center" style="text-align:center;">I.V. INTAKE</th>
                            <th  align="center" style="text-align:center;">R.T.F.</th>
                            <th  align="center" style="text-align:center;">BGL/ INSULINE</th>
                            <th   align="center" style="text-align:center;">R.T.A.</th>
                            <th   align="center" style="text-align:center;">URINE OUTPUT</th>
                            <th  align="center" style="text-align:center;">STOOL</th>
                            <th   align="center" style="text-align:center;">VOM-ITING</th>
                            <th   align="center" style="text-align:center;">ABD. GIRTH</th>
                     </tr>	
					 <?php
					 $i = 0;			 
					 foreach($intake_detail['time']  as $key => $value){					
						$datestdtoLocal = $this->DateFormat->formatDate2Local($value,Configure::read('date_format'),true) ;
						$splitDate = explode(" ",$datestdtoLocal);
						$splitDate[1] = date("g:i a",strtotime($splitDate[1]));
						$i++;
					?>
					  <tr id = "row<?php echo $i;?>">
                      		<td align="center"><input name="intake_detail[time][]" type="text" class="textBoxExpnd time  validate[required]" readonly="true" value="<?php echo $splitDate[1];?>"/> </td>
                            <td><input type="text" name="intake_detail[temp][]" class="textBoxExpnd" id="textfield" value="<?php echo $intake_detail['temp'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[pulse][]" class="textBoxExpnd" id="textfield2" value="<?php echo $intake_detail['pulse'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[rr][]" class="textBoxExpnd" id="textfield5" value="<?php echo $intake_detail['rr'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[bp][]" class="textBoxExpnd" id="textfield8" value="<?php echo $intake_detail['bp'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[cvp][]" class="textBoxExpnd" id="textfield9" value="<?php echo $intake_detail['cvp'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[spo2][]" class="textBoxExpnd" id="textfield10" value="<?php echo $intake_detail['spo2'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[iv][]" class="textBoxExpnd" id="textfield11" value="<?php echo $intake_detail['iv'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[rtf][]" class="textBoxExpnd" id="textfield12" value="<?php echo $intake_detail['rtf'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[bgl][]" class="textBoxExpnd" id="textfield13"  value="<?php echo $intake_detail['bgl'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[rta][]" class="textBoxExpnd" id="textfield14"  value="<?php echo $intake_detail['rta'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[urineoutput][]" class="textBoxExpnd" id="textfield15"  value="<?php echo $intake_detail['urineoutput'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[stool][]" class="textBoxExpnd" id="textfield16"  value="<?php echo $intake_detail['stool'][$key];?>"/></td>
                            <td><input type="text" name="intake_detail[vom-iting][]" class="textBoxExpnd" id="textfield17"  value="<?php echo $intake_detail['vom-iting'][$key];?>"/></td>
                        <td><input type="text" name="intake_detail[abd-girth][]" class="textBoxExpnd" id="textfield18"  value="<?php echo $intake_detail['abd-girth'][$key];?>"/></td>
                     </tr> 
					  <?php
					  }
					  ?>
					  <input type="hidden" value="<?php echo $i;?>" id="no_of_fields"/>
				   </table>
				    <table width="98%" border="0" cellspacing="0" cellpadding="0"   class="tabularForm">
                              <tr>
                                <td width="550">6AM - 6 PM TOTAL INTAKE {I.V. + ORAL - R.T.F.}</td>
                                <td width="160">OUTPUT :</td>
                                <td width="160">STOOL :</td>
                                <td width="160">DRAIN :</td>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
      <div class="btns">
                           <input type="button" value="Add Row" class="blueBtn" onclick="addFields()"/><input name="" type="button" value="Remove" class="blueBtn" tabindex="36" id="remove-btn"  style="display:none" onclick="removeRow()"/>
                           <input name="submit" type="submit" value="Submit" class="blueBtn"/>
						   <input type="button" value="Print" onclick="window.open('<?php echo
							   $this->Html->url(array('action' => 'patient_ivf',$patient['Patient']['id'],$PatientIvf['PatientIvf']['id'],true ));
							   ?>');"
								class="blueBtn">
						    <?php  echo $this->Html->link(__('Back'), array('action' => 'patient_ivf_list', $patient['Patient']['id']), array('escape' => false,'class'=>"blueBtn"));?>
                     </div>
                
 <?php echo $this->Form->end();?>  
 
<script> 
jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PatientIvfPatientIvfForm").validationEngine();
	});
	
    $('.time').timepicker({
    showPeriod: true,
    showLeadingZero: true
});
             
  
$( "#date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			minDate: new Date(),
		});	

(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText":"Required.",
                    "alertTextCheckboxMultiple": "* Please select an option",
                    "alertTextCheckboxe": "* This checkbox is required"
                } 
            };
            
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

function addFields(){
		   var number_of_field = parseInt($("#no_of_fields").val())+1;
           var field = '';
		   field += '<tr id="row'+number_of_field+'"> ';
           field += '<td align="center"><input name="intake_detail[time][]" type="text" class="textBoxExpnd time  validate[required]" readonly="true" id="time'+number_of_field+'"/> </td>';
		   field += '<td><input type="text" name="intake_detail[temp][]" class="textBoxExpnd" id="textfield" /></td>';		   
           field += '<td><input type="text" name="intake_detail[pulse][]" class="textBoxExpnd" id="textfield2"/></td>';
		   field += '  <td><input type="text" name="intake_detail[rr][]" class="textBoxExpnd" id="textfield5"/></td>';
		   field += '<td><input type="text" name="intake_detail[bp][]" class="textBoxExpnd" id="textfield8" /></td>';
		   field += ' <td><input type="text" name="intake_detail[cvp][]" class="textBoxExpnd" id="textfield9" /></td>';
		   field += '  <td><input type="text" name="intake_detail[spo2][]" class="textBoxExpnd" id="textfield10" /></td>';
		   field += '  <td><input type="text" name="intake_detail[iv][]" class="textBoxExpnd" id="textfield11" /></td>';
		   field += '<td><input type="text" name="intake_detail[rtf][]" class="textBoxExpnd" id="textfield12" /></td>';
		   field += '<td><input type="text" name="intake_detail[bgl][]" class="textBoxExpnd" id="textfield13"  /></td>';
		   field += ' <td><input type="text" name="intake_detail[rta][]" class="textBoxExpnd" id="textfield14"  /></td>';
		   field += '<<td><input type="text" name="intake_detail[urineoutput][]" class="textBoxExpnd" id="textfield15"  /></td>';
		   field += '<td><input type="text" name="intake_detail[stool][]" class="textBoxExpnd" id="textfield16"  /></td>';
		   field += '<td><input type="text" name="intake_detail[vom-iting][]" class="textBoxExpnd" id="textfield17"  /></td>';
		   field += ' <td><input type="text" name="intake_detail[abd-girth][]" class="textBoxExpnd" id="textfield18"  /></td>';
		   field +='  </tr>    ';		   
		   $("#no_of_fields").val(number_of_field);
		   $("#tabularForm").append(field); 
		   if (parseInt($("#no_of_fields").val()) == 1){
				$("#remove-btn").css("display","none");
		   }else{
				$("#remove-btn").css("display","inline");
		   }
		   $('#time'+number_of_field).timepicker({
				showPeriod: true,
				showLeadingZero: true
			});
}

function removeRow(){
 	var number_of_field = parseInt($("#no_of_fields").val());
	$('.dateformError '+number_of_field+"formError").remove();
	$('.time'+number_of_field+"formError").remove();
	if(number_of_field > 1){
		$("#row"+number_of_field).remove();

		$("#no_of_fields").val(number_of_field-1);
	}
	if (parseInt($("#no_of_fields").val()) == 1){
		$("#remove-btn").css("display","none");
	}
}
 </script>