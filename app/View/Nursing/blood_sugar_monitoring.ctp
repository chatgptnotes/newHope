<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));      
 	echo $this->Html->script(array('jquery.fancybox-1.3.4'));?>
<style>
.formError .formErrorContent {
	width: 60px;
}
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Blood Sugar Monitoring Chart'); ?>
	</h3>
	<span> <?php 
	echo $this->Html->link(__('Blood Sugar Chart'),'#',array('escape'=>false, 'class'=>"blueBtn", 'id'=>'pres_glucose','onClick'=>"pres_glucose('{$patient['Patient']['id']}')"));
	
	echo $this->Html->link(__('View BLOOD SUGAR MONITORING CHART'),'#', array('id'=>'print','escape' => false,'class'=>'blueBtn','style'=>'padding:3px;12px;',
			'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'blood_sugar_monitoring',$patient['Patient']['id'],true))."', '_blank',
			'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
	echo $this->Html->link(__('Back'), array('action' => 'patient_information', $patient['Patient']['id']), array('escape' => false,'class'=>"blueBtn"));?>
	</span>
</div>

<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>


<?php echo $this->Form->create('PatientBloodSugarMonitoring');?>

<table width="98%" border="0" cellspacing="1" cellpadding="0"
	class="tabularForm" style="margin: 5px 10px" id="item-row">
	<tr class="row_title">
		<th width="10">Sr.</th>
		<th width="190">Date / Time<font color="red">*</font>
		</th>
		<th width="140">Blood Sugar (mg/dl)<font color="red">*</font>
		</th>
		<th width="140" style="text-align: center;">Treatment Given</th>
		<th width="20" style="text-align: center;">Delete</th>
	</tr>

	<?php
	$cnt=0;
	if(count($bloodsugardetails) > 0){
	foreach($bloodsugardetails as $key=>$value){
				   $cnt++;
				   ?>
	<tr id="row<?php echo $cnt;?>">
		<td class="sr_number"><?php echo $cnt;?></td>
		<td width="150"><input type="hidden" name="PatientBloodSugarMonitoring[<?php echo $cnt;?>][id]" value="<?php echo $value['PatientBloodSugarMonitoring']['id'];?>" /><input
			name="PatientBloodSugarMonitoring[<?php echo $cnt;?>][datetime]" type="text" fieldNo="<?php echo $cnt;?>" class="textBoxExpnd datetime validate[required]"
			id="datetime<?php echo $cnt;?>" style="width: 70%;" value="<?php echo $this->DateFormat->formatDate2Local($value['PatientBloodSugarMonitoring']['datetime'],Configure::read('date_format'),true);?>" ,readonly = readonly/>
		</td>
		<td><input
			name="PatientBloodSugarMonitoring[<?php echo $cnt;?>][blood_sugar]"
			type="text" class="textBoxExpnd validate[required]"
			id="bloodsugar<?php echo $cnt;?>" style="width: 120px;"
			fieldNo="<?php echo $cnt;?>"
			value="<?php echo $value['PatientBloodSugarMonitoring']['blood_sugar'];?>" />
		</td>
		<td><input
			name="PatientBloodSugarMonitoring[<?php echo $cnt;?>][treatment]"
			type="text" class="textBoxExpnd" id="treatment<?php echo $cnt;?>"
			style="width: 96%;" fieldNo="<?php echo $cnt;?>"
			value="<?php echo $value['PatientBloodSugarMonitoring']['treatment'];?>" />
		</td>

		<td width="20"><input type="checkbox" id="deleteCh"
			name="PatientBloodSugarMonitoring[<?php echo $cnt;?>][deleteId]"
			value="<?php echo $value['PatientBloodSugarMonitoring']['id'];?>" />
		</td>
	</tr>
	<?php }
	}?>

</table>

<div class="btns">
	<input type="button" value="Add Row" class="blueBtn"
		onclick="addFields()" /> <input id="submitForm" name="submit"
		type="submit" value="Submit" class="blueBtn" />
</div>

<input
	type="hidden" value="<?php echo $cnt;?>" id="no_of_fields" />

<?php echo $this->Form->end();?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#PatientBloodSugarMonitoringBloodSugarMonitoringForm").validationEngine();
	});
$( ".datetime" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
			onSelect:function(){$(this).focus();}
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

    if($("#no_of_fields").val()==0){
        $("#submitForm").hide() ;
        
    }
})(jQuery);

function addFields(){
	 		$("#submitForm").show() ;
		   var number_of_field = parseInt($("#no_of_fields").val())+1;
           var field = '';
           field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
           field += '<td width="150"><input name="PatientBloodSugarMonitoring['+number_of_field+'][datetime]" id="datetime'+number_of_field+'" type="text" class="textBoxExpnd validate[required] item_name"  tabindex="6" value="" style="width:70%;" fieldNo="'+number_of_field+'" readonly = readonly) /> </td>';
		   field += '<td><input name="PatientBloodSugarMonitoring['+number_of_field+'][blood_sugar]" style="width:120px" id="bloodsugar'+number_of_field+'" type="text" class="textBoxExpnd  validate[required]"  tabindex="7" value="" fieldNo="'+number_of_field+'" /></td>';
           field += '<td align="center" valign="middle"><input name="PatientBloodSugarMonitoring['+number_of_field+'][treatment]"  style="width:96%;" id="treatment'+number_of_field+'" type="text" class="textBoxExpnd"  tabindex="8" value=""  fieldNo="'+number_of_field+'" /></td>';
          
  		     field +='<td valign="middle" style="text-align:center;"> <a href="#this" id="delete row" onclick="deletRow('+number_of_field+');"><?php echo $this->Html->image('/img/cross.png');?></a></td>';
  		  field +='  </tr>    ';
  		  
      	$("#no_of_fields").val(number_of_field);
      	$("#item-row").append(field);
		$("#datetime"+number_of_field).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
			 
			
		});
		
}

function deletRow(id){
	 var number_of_field = parseInt($("#no_of_fields").val());
	// alert(number_of_field) ;
	 if(number_of_field == 1){
		 $("#submitForm").hide() ;
	 }	 
	 
	$("#row"+id).remove();
	$('.bloodsugar'+number_of_field+"formError").remove();
	$('.treatment'+number_of_field+"formError").remove();
	$('.datetime'+number_of_field+"formError").remove();
		var table = $('#item-row');
		summands = table.find('tr');
		var sr_no = 1;
		summands.each(function ()
		{
				var cell = $(this).find('.sr_number');
				cell.each(function ()
				{
					$(this).html(sr_no);
					sr_no = sr_no+1;
				});

		});
    $("#no_of_fields").val(number_of_field-1);
}

function pres_glucose(patientid){

	$
	.fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "glucose_chart")); ?>"
		+ '/' + patientid+'/'+"<?php echo $patient['Patient']['patient_id']?>"
		


	});
		 
	}


</script>
