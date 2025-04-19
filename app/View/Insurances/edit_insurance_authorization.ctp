<?php 
echo $this->Html->script(array('jquery-1.9.1.js','jquery.validationEngine2.js','languages/jquery.validationEngine-en.js','ui.datetimepicker.3.js','inline_msg','jquery.blockUI','bootstrap.min','bootstrap-dialog'));
echo $this->Html->css(array('validationEngine.jquery.css','jquery-ui-1.8.16.custom.css','jquery.ui.all.css','bootstrap.min.css','internal_style.css'));
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
 <script>
var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
</script>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Edit Insurance Authorizations', true); ?>
	</h3>
	<span></span>
</div>
<?php echo $this->Form->create('Insurances',array('action'=>'editInsuranceAuthorization','id'=>'editInsuranceAuthorizationForm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<?php 
echo $this->Form->hidden("InsuranceAuthorization.id", array('type'=>'text','value'=>$data['InsuranceAuthorization']['id']));
echo $this->Form->hidden("InsuranceAuthorization.patient_id", array('type'=>'text','value'=>$data['InsuranceAuthorization']['patient_id']));
echo $this->Form->hidden("InsuranceAuthorization.patient_uid", array('type'=>'text','value'=>$data['InsuranceAuthorization']['patient_uid']));
echo $this->Form->hidden("InsuranceAuthorization.location_id", array('type'=>'text','value'=>$data['InsuranceAuthorization']['location_id']));

?>
<table style="margin: 10px;" width="80%" cellspacing="0" align="center">
	<tr>
		<td class="table_cell"><?php echo __('Authorization Number')?><font color="red">*</font></td>
		<td><?php 
			echo $this->Form->input('InsuranceAuthorization.authorization_number', array('class' => 'textBoxExpnd validate[required,custom[mandatory-enter]]','id' => 'authorization_number','label'=>false,'value'=>$data['InsuranceAuthorization']['authorization_number']));
		?></td>
	</tr>
	<tr>
		<td class="table_cell"><?php echo __('Start Date')?><font color="red">*</font></td>
		<td>
		<?php $start_date=$this->DateFormat->formatDate2Local($data['InsuranceAuthorization']['start_date'],Configure::read('date_format'),false);
			echo $this->Form->input('InsuranceAuthorization.start_date', array('type'=>'text','class' => 'textBoxExpnd validate[required,custom[mandatory-date]]','id' => 'start_date','label'=>false,'value'=>$start_date));
		?>
		</td>
	</tr>
	<tr>
		<td class="table_cell"><?php echo __('End Date')?><font color="red">*</font></td>
		<td>
		<?php $end_date=$this->DateFormat->formatDate2Local($data['InsuranceAuthorization']['end_date'],Configure::read('date_format'),false);
			echo $this->Form->input('InsuranceAuthorization.end_date', array('type'=>'text','class' => 'textBoxExpnd validate[required,custom[mandatory-date]]','id' => 'end_date','label'=>false,'value'=>$end_date));
		?>
		</td>
	</tr>
	<tr>
		<td class="table_cell"><?php echo __('Number of visits')?><font color="red">*</font></td>
		<td>
		<?php 
			echo $this->Form->input('InsuranceAuthorization.visit_approved', array('class' => 'textBoxExpnd validate[required,custom[onlyNumber]]','id' => 'visits_approved','label'=>false,'value'=>$data['InsuranceAuthorization']['visit_approved']));
		?>
		</td>
	</tr>
	<tr>
		<td class="table_cell"><?php echo __('Notes')?></td>
		<td>
		<?php 
			echo $this->Form->input('InsuranceAuthorization.notes', array('class' => 'textBoxExpnd','id' => 'notes','label'=>false,'value'=>$data['InsuranceAuthorization']['notes']));
		?>
		</td>
	</tr>
	<tr>
		<td class="table_cell"><?php echo __('Procedure Codes')?></td>
		<td>
		<?php echo $this->Form->input('InsuranceAuthorization.procedure_code', array('class' => 'textBoxExpnd','id' => 'procedure_code','label'=>false,'value'=>$data['TariffList']['name']));?>
		<?php echo $this->Form->hidden("InsuranceAuthorization.cbt", array('type'=>'text','id'=>"cbt",'value'=>$data['InsuranceAuthorization']['procedure_code'])); ?>
		</td>
	</tr>	
	<tr>
		<td>&nbsp;</td>
		<td style="padding-right:33px;padding-top:10px"><?php 
		echo $this->Form->button('Save', array('class'=>'blueBtn','style'=>'float:right;','type' => 'button','id'=>'saveNewInsurance'));
		?></td>
	</tr>
</table>
<?php echo $this->element('alert'); ?>
<?php echo $this->Form->end(); ?>
<script>
		
$(document).ready(function(){
	$("#procedure_code").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","TariffList","cbt","name",'service_category_id=36',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true,
		valueSelected:true,
		showNoId:true,
		loadId : 'name,cbt'
	});
	});
		
var httpRequestNewInsuranceURL = '';
var newInsuranceURL = "<?php echo $this->Html->url(array("controller" => 'Insurances', "action" => "editInsuranceAuthorization",$patientId,"admin" => false)); ?>" ; 
$(document).ready(function() {
	//$('#fancybox-content').css('height', '600');
});

$("#saveNewInsurance").click(function() {
	var validateMandatory = jQuery("#editInsuranceAuthorizationForm").validationEngine('validate');
	if(validateMandatory == false){
		return false;
	}
	
	if(httpRequestNewInsuranceURL) httpRequestFileCashBookSet.abort();
	var formData = $("#editInsuranceAuthorizationForm").serialize();
	 
	var httpRequestNewInsuranceURL = $.ajax({
		  beforeSend: function(){
			  //loading(); // loading screen
		  },
	      url: newInsuranceURL
	       ,
	      context: document.body,
	      data : formData, 
	      type: "POST",
	      success: function(data){ 
		      if(data == 1){
		    	  //window.setTimeout(function() { alert.alert('close') }, 2000)
		    	  parent.location.reload(true);
			      parent.$.fancybox.close();
		    	  BootstrapDialog.alert('Record has been saved successfully.');
		      }else{
		    	  BootstrapDialog.alert('Please try again');
		      }
 		  },
		  error:function(){
			  BootstrapDialog.alert('Please try again');
				
			  }
	});
});

$( "#start_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
});

$( "#end_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate();?>',
});
</script>
