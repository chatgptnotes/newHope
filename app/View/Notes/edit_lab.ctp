<?php //debug($token_data);exit;?>
<div class="inner_title">
	<h3 style="padding: 0 0 0 20px">
		<?php echo __('Edit Lab '); ?>
	</h3>

</div>
<?php 
echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js','jquery.blockUI','jquery.autocomplete',
		'jquery.fancybox-1.3.4','ui.datetimepicker.3.js'));
echo $this->Html->css(array('jquery.autocomplete.css','jquery-ui-1.8.16.custom.css','jquery.fancybox-1.3.4.css',
		'jquery.ui.all.css','internal_style.css'));
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
<?php echo $this->Form->create('EditLab',array('action'=>'editLab','id'=>'labfrm','type'=>'post'));?>
<div id="lab-investigation" style= "display:'<?php echo $display ;?>'">

	<div class="clr ht5"></div>
	<!-- billing activity form end here -->
	<table border="0" class="" cellpadding="0" cellspacing="3" width="100%"
		style="text-align: left; color: #000; font-size: 13px;">
		<tr>
			<td width="35%" id="boxSpace" class="tdLabel">Universal Service
				Identifier: <font color="red">*</font>
			</td>
			<td width="65%"><?php
			echo $this->Form->input('LaboratoryToken.testname',array('class'=>'textBoxExpnd','div'=>false,'label'=>false,'id'=>'testname',
				'readonly'=>'readonly','value'=>$token_data['Laboratory']['name']));
			echo $this->Form->hidden('LaboratoryTestOrder.id', array('value'=>$token_data['LaboratoryTestOrder']['id']));
			echo $this->Form->hidden('LaboratoryTestOrder.patient_id', array('value'=>$token_data['LaboratoryTestOrder']['patient_id']));
			echo $this->Form->hidden('LaboratoryTestOrder.laboratory_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testCode','value'=>$token_data['Laboratory']['id']));
			echo $this->Form->hidden('LaboratoryToken.id',array('type'=>'text','div'=>false,'label'=>false,'value'=>$token_data['LaboratoryToken']['id']));
			echo $this->Form->hidden('LaboratoryToken.laboratory_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'testcodeToken','value'=>$token_data['Laboratory']['id']));
			echo $this->Form->hidden('LaboratoryToken.patient_id',array('label'=>false,'type'=>'text','value'=>$token_data['LaboratoryTestOrder']['patient_id']));

			?></td>
		</tr>

		<tr>
			<td id="specimen_type_name" class="tdLabel">Specimen Type:</td>
			<td><?php  
			//pr($token_data);
			echo $this->Form->input('LaboratoryTestOrder.specimen_type_option',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd',
				'value'=>$token_data['LaboratoryTestOrder']['specimen_type_option'],'id'=>'specimen_type_option','div'=>false,'label'=>false));
			?>
			</td>
		</tr>
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel">Date of Order <font
				color="red">*</font>
			</td>
			<?php $startDate = $this->DateFormat->formatDate2Local($token_data['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),true);?>
			<td width="19%" style="width: 163px; float: left;"><?php echo $this->Form->input('LaboratoryTestOrder.start_date',array('class'=>'textBoxExpnd dateCalender',
					'id'=>'start_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','label'=>false,'value'=>$startDate )); ?>
			</td>
		</tr>

		<tr>
			<td class="tdLabel">Priority:</td>
			<td><?php  $Priority=array('Stat'=>'Stat','Daily'=>'Daily','Tommorrow'=>'Tommorrow','Today'=>'Today');
			echo $this->Form->input('LaboratoryToken.priority',array('class'=>'textBoxExpnd','empty'=>'Please Select',
					'options'=>$Priority,'id'=>'','div'=>false,'label'=>false,'value'=>$token_data['LaboratoryToken']['priority']));  ?>

			</td>

		</tr>
		<tr>
			<td class="tdLabel">Frequency:</td>
			<td><?php  echo $this->Form->input('LaboratoryToken.frequency',array('class'=>'textBoxExpnd','empty'=>'Please Select',
					'options'=>Configure::read('frequency'),'id'=>'','div'=>false,'label'=>false,'selected'=>$token_data['LaboratoryToken']['frequency']));  ?>

			</td>
		</tr>

		<tr>

			<td width="19%" id="boxSpace" class="tdLabel">Specimen Collection
				Date:</td>
			<?php $labOrderDate = $this->DateFormat->formatDate2Local($token_data['LaboratoryTestOrder']['lab_order_date'],Configure::read('date_format'),true);?>
			<td width="19%"><?php echo $this->Form->input('LaboratoryTestOrder.lab_order_date', array('class'=>'textBoxExpnd dateCalender',
					'id' => 'lab_order_date','type'=>'text','label'=>false,'value'=>$labOrderDate )); ?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel">Clinical Information <span
				style="font-size: 11px; font-style: italic">(Comments or Special
					Instructions)</span>
			</td>
			<?php ;?>
			<td width="19%"><?php echo $this->Form->input('LaboratoryToken.relevant_clinical_info', array('class'=>'textBoxExpnd',
					'id' => 'relevant_clinical_info','type'=>'text','label'=>false,'value' =>$token_data['LaboratoryToken']['relevant_clinical_info'])); ?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel">Primary Care Provider</td>
			<td width="19%"><?php echo $this->Form->input('LaboratoryToken.primary_care_pro', array('class'=>'textBoxExpnd',
					'id' => 'primary_care_pro','type'=>'text','label'=>false ,'value'=>$token_data['LaboratoryToken']['primary_care_pro'])); ?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel">Select Diagnosis</td>
			<td width="19%"><?php  echo $this->Form->input('LaboratoryToken.diagnosis',array('class'=>'textBoxExpnd','empty'=>'Please Select',
					'options'=>$diagnosesData,'id'=>'diagnoses_lab_name','div'=>false,'label'=>false,'value'=>$token_data['LaboratoryToken']['diagnosis']));
			?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<?php 
		$questions = unserialize($token_data['LaboratoryToken']['question']);
			
			
		foreach($questions as $key=>$value){
						$test = strpos($key, 'radio_question_');
						if (strpos($key, 'radio_question_') !== false) {
							$temp = explode("radio_question_",$key);
							$temp = $temp['1'];
							?>
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel"><?php echo $aoeCodes[$temp];?>
			</td>
			<td width="19%" style="color: #000"><?php echo $this->Form->input('LaboratoryTokenSerialize.radio_question_'.$temp,array('type'=>'radio',
					'options'=>	array(true=>'Yes',false=>'No'),
								'label'=>false,'div'=>false,'legend'=>false,'hiddenField'=>false,'value'=>$value,'style'=>'color:black'));?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>

			<?php }else
				if (strpos($key, 'free_text_question_') !== false) {
				$temp = explode("free_text_question_",$key);
				$temp = $temp['1'];
				?>
		
		
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel"><?php echo $aoeCodes[$temp];?>
			</td>
			<td width="19%"><?php echo $this->Form->input('LaboratoryTokenSerialize.free_text_question_'.$temp, array('class'=>'textBoxExpnd',
					'id' => 'free_text_question_'.$temp,'type'=>'text','label'=>false ,'value'=>$value)); ?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<?php }else
				if (strpos($key, 'drop_down_question_') !== false) {
				$temp = explode("drop_down_question_",$key);
				$temp = $temp['1'];
				?>
		
		
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel"><?php echo $aoeCodes[$temp];?>
			</td>
			<td width="19%"><?php echo $this->Form->input('LaboratoryTokenSerialize.drop_down_question_'.$temp, array('type'=>'select',
					'class'=>'textBoxExpnd','id' => 'drop_down_question_'.$temp,'type'=>'text','label'=>false ,'value'=>$value)); ?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<?php }
			?>

		</tr>
		<?php }
		?>
		<tr>
			<td></td>
			<td colspan='2' align='left' valign='bottom'>
				<div style="margin-top: 10px;">
					<?php echo $this->Form->submit(__('Submit'),array('id'=>'labsubmit','class'=>'blueBtn','onclick'=>"javascript:save_lab();return false;")); ?>
				</div>
			</td>

		</tr>
	</table>
	<!--BOF list -->
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="10%" style="text-align: center;">
		<?php if(isset($test_ordered) && !empty($test_ordered)){  ?>
		<tr class="row_title">
			<td class="table_cell" align="left"><strong> <?php echo __('Lab Order id'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Lab creation Date'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Lab Name'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php  echo __('Lonic Code'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Speci. Type'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Speci. Cond.'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Status'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Is Sample Taken'); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Action'); ?>
			</strong></td>
		</tr>

		<?php 
		$toggle =0;
		$time = '';
		if(count($test_ordered) > 0) {

							foreach($test_ordered as $labs){


					   			   $currentTime = $labs['LaboratoryTestOrder']['batch_identifier'];
					   			   if($time != $currentTime ){
								   		if(!empty($test_ordered)) {
								   			echo "<tr class='row_title'><td colspan='11' align='right' style='padding: 8px 5px;'>" ;
								   			echo $this->Form->button(__('Print Slip'),
											     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'laboratories','action'=>'investigation_print',$patient_id,$currentTime))."', '_blank',
													   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
											echo "</td></tr>" ;
                                 		}else{
                                 			echo "<tr class='row_title'><td colspan='11'>&nbsp;</td></tr>" ;
                                 		}
								   }

								   $time  =  $currentTime;
								   if($toggle == 0) {
										echo "<tr class='row_gray'>";
										$toggle = 1;
								   }else{
										echo "<tr class='row_gray'>";
										$toggle = 0;
								   }
								   //status of the report
								   if($labs['LaboratoryResult']['confirm_result']==1){
								   		$status = 'Result published' ;

								   }else{
								   		$status = 'Pending';

								   }
								   ?>
		<td class="row_format" align="left"><?php echo $labs['LaboratoryTestOrder']['order_id']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($labs['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),false); ?>
		</td>
		<td class="row_format" align="left"><?php  echo ucfirst($labs['Laboratory']['name']); ?>
		</td>
		<td class="row_format" align="left"><?php  echo $labs['Laboratory']['lonic_code']; ?>
		</td>
		<td class="row_format" align="left"><?php echo ucfirst($labs['LaboratoryToken'][0]['specimen_type_id']); ?>

		</td>


		<td class="row_format" align="left"><?php echo $labs['LaboratoryToken'][0]['specimen_condition_id']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $status; ?>
		</td>
		<td class="row_format"><?php 
		if(!empty($labs['LaboratoryToken'][0]['ac_id']) || !empty($labs['LaboratoryToken'][0]['specimen_type_id'])){
					echo "Yes";
				  }else{
					echo "No";
				 }
				 ?>
		</td>

		<td class="row_format" align="left"><?php 
		if($status == 'Pending'){
					echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'laboratories','action' => 'deleteLabTest', $labs['LaboratoryTestOrder']['id']), array('escape' => false),__('Are you sure?', true));
				}
					
				$labo_id = $labs['LaboratoryToken'][0]['id'];
				echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_laborder($labo_id);return false;")), array(), array('escape' => false));
				$ord_id = $labs['LaboratoryTestOrder']['order_id'];

				/* $rolename = $this->Session->read('role');
				 if((strtolower($rolename) != strtolower(trim(Configure::read('medicalAssistantLabel'))))){
				echo $this->Html->link($this->Html->image('icons/sign-icon.png',array('title'=>'Generate HL7','alt'=>'Generate HL7', 'onclick'=>"gen_HL7_Lab('$ord_id');return false;")), array(), array('escape' => false));
				} */
				?></td>
		</tr>
		<?php } 	
		//set get variables to pagination url
		$this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
		?>
		<tr>
			<TD colspan="8" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"> <?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span>
			</TD>
		</tr>

		<?php 

		} ?>
		<?php					  
			} else {} ?>

		<?php  echo $this->Js->writeBuffer(); ?>
		<?php //echo $this->Form->end(); ?>
	</table>
</div>
<script>
jQuery(document).ready(function(){
			$("#test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","Laboratory",'id',"name",'dhr_flag=1',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				valueSelected:true,
				showNoId:true,
				loadId : 'testname,testcode',
				onItemSelect:function () { 
					getSpecimenOptions();
				}
			});
});

//Pawan get Specimen Options
function getSpecimenOptions(){//specimen_type_option//specimen_type_name
	$('#specimen_type_option option[value!=0]').remove();
	$("#specimen_type_name").html('Specimen Type'+':');
	$.ajax({
        type: 'POST',
       	url: specimenCollectionUrl+'/'+$("#testcode").val(),
       	//data: {laboratory_id: $("#testcode").val()},
        dataType: 'html',
        beforeSend : function() {
        	loading('lab-investigation','id');
		},
		success: function(data){ 
			
			data = jQuery.parseJSON(data);
			options = data['0'];
			name  = data['1'];
			//if(name != 'null'){
				//$("#specimen_type_name").html(name+':');
				$.each(options, function (i, item) {
					isOption = true;
					$("#specimen_type_option").append( new Option(item,i) );
					onCompleteRequest('lab-investigation','id');
				});
			//}else{
			//	$("#specimen_type_option").append( new Option('Blood Specimen','') );
			//}
			if(isOption == false){
			//	$("#specimen_type_option").append( new Option('Blood Specimen','') );
			}
				
			onCompleteRequest('lab-investigation','id');
        },
		error: function(message){
			 alert("Please try again") ;
        }        
});
}
	


/// End (Pawan)

$(".start_cal")
.datepicker(
		{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				
			}

		});


$(".dateCalender").datepicker({
	showOn : "both",
	buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly : true,
	changeMonth : true,
	changeYear : true,
	yearRange: '-100:' + new Date().getFullYear(),
	//maxDate : new Date(),
	dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
	onSelect : function() {
		
	}
});

function save_lab(Clinical){
	var specimenType = $('#specimen_type_id').val();
	if(specimenType==""){
		alert('Check validations');
		return false;
	}
	if($('#testname').val()==""){
		alert('Check validations');
		return false;
	}

	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "editLab",$patient_id,"admin" => false)); ?>";

	 var formData = $('#labfrm').serialize(); 
	   $.ajax({
            type: 'POST',
           	url: ajaxUrl,
            data: formData,
            dataType: 'html',
            beforeSend : function() {
				//this is where we append a loading image
            	$('#busy-indicator').show('fast');
			},
			success: function(data){ 
				$('#busy-indicator').hide('fast');
				$( '#flashMessage', parent.document).html('Lab Updated.');
				$('#flashMessage', parent.document).show();
				parent.$.fancybox.close();
            },
			error: function(message){
				$( '#flashMessage', parent.document).html('Please try later.');
				$('#flashMessage', parent.document).show();
				parent.$.fancybox.close();
            }        
         });
      
      return false;
}
function proceduresearch(source) {
    var identify =""; 
	identify = source;
	$.fancybox({
				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "proceduresearch")); ?>" + "/" + identify,
			});
   } 
		</script>
