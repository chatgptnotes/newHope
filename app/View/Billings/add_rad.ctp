  
<style>
.bluebtton{ background:#4EB5FF repeat-x; color:#fff; border:none; height:25px; line-height:20px; margin:0px;}
</style>
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
<?php echo $this->Form->create('AddRad',array('action'=>'addRab','id'=>'Radfrm','type'=>'post'));?>
<div id="radiology-investigation" style="display: block;">

	<div class="clr ht5"></div>
	<!-- <table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm" style="color: #fff;">

		<tr>
			<td valign="top" width="30%">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
 		<td><?php 
//debug($radTest);
						/*echo $this->Form->input('RadiologyTestOrder.toTest',array('empty'=>__('Please Select'),'options'=>$radTest,'escape'=>false,'multiple'=>false,
	                                  'style'=>'width:220px;','placeholder'=>'Radiology Search','id'=>'SelectRad','label'=>false,'div'=>false,'onChange'=>'javascript:getRadDetail()'));*/
echo $this->Html->image('/img/favourite-icon.png',array('style'=>'margin: 4px 5px 0 0;'));
echo $this->Form->input('RadiologyTestOrder.toTest',array('empty'=>__('Please Select'),'escape'=>false,'multiple'=>false,
		'style'=>'width:400px; border: 1px solid #9fbdd2 !important; height:25px;margin-top:2px;','placeholder'=>'Radiology Search','id'=>'SelectRad1','label'=>false,'div'=>false));
	//	echo $this->Form->input('Search',array('type'=>'button','label'=>false,'div'=>false,'class'=>'bluebtton'));
	                                 ?>
                                     <?php //echo $this->Html->link(__('Extended Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:proceduresearch("forrad")','id'=>'checkPro'));?>
						</td>
						<!--<td><?php echo $this->Html->link(__('Extended Search'),"javascript:void(0)",array('class'=>'blueBtn','onclick'=>'javascript:proceduresearch("forrad")'));?>
						</td>->
					</tr>

				</table>
			</td>

		</tr>

	</table> -->

	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: left; color: #fff;">
		<tr>

			<td width="25%" class="tdlabel" id="boxspace">Test Name:<font color="red">*</font></td>
			<td width="40%"><?php  echo $this->Form->input('RadiologyTestOrder.testname',array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false,'label'=>false,'id'=>'rad_testname','readonly'=>'readonly','style'=>''));  
			echo $this->Form->hidden('RadiologyTestOrder.testcode',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_testcode','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.rad_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_id','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.sct_concept_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_sctCode','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.lonic_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_LonicCode','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.cpt_code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_cptCode','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.icd9code',array('type'=>'text','div'=>false,'label'=>false,'id'=>'rad_icd9code','readonly'=>'readonly'));
			echo $this->Form->hidden('RadiologyTestOrder.radTestId',array('id'=>'radTestId'));
			echo $this->Form->hidden('RadiologyTestOrder.sbar',array('id'=>'sbar','value'=>$flag));
			echo $this->Form->hidden('RadiologyTestOrder.noteId',array('id'=>'noteId','value'=>$noteId));
			?>
			</td>
		</tr>

		<!--  <tr>

			<td class="tdlabel" id="boxspace">Start Date: <!--  <font color="red">*</font> 
			</td>

			<td class="tddate"><?php echo $this->Form->input('RadiologyTestOrder.start_date',array('class'=>'start_cal textBoxExpnd','id'=>'start_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>'','label'=>false )); ?>
			</td>
		</tr> -->

	<!--   	<tr>
			<td class="tdlabel" id="boxspace">Number of written radiology orders:</td>
			<td><?php echo $this->Form->input('RadiologyTestOrder.radiology_order', array('type'=>'text','id' => 'radiology_order','label'=>false,'class' => 'textBoxExpnd','style'=>'' )); ?>
			</td>
		</tr>-->
		<tr>
			<td class="tdlabel" id="boxspace">Accessession Number:</td>
			<td><?php echo $this->Form->input('RadiologyTestOrder.order_id', array('type'=>'text','id' => 'order_id','label'=>false,'class' => 'textBoxExpnd','style'=>'','value'=>$accesionIdRad,'readonly'=>'readonly' )); ?>
			</td>
		</tr>
		<tr>
			<td class="tdlabel" id="boxspace">Date of order:</td>
			<?php $curentTime= $this->DateFormat->formatDate2LocalForReport(date('Y-m-d H:i:s'),Configure::read('date_format'),true);?> 
			<td class="tddate"><?php echo $this->Form->input('RadiologyTestOrder.radiology_order_date', array('class' => 'textBoxExpnd','id' => 'radiology_order_date','type'=>'text','label'=>false,'value'=>$curentTime )); ?>
			</td>


		</tr>
		<!--  <tr>
			<td width="19%" id="boxSpace" class="tdLabel"><?php echo __("Send To Radiology Facility");?>:</td>
			<td width="31%"><?php echo $this->Form->input('RadiologyTestOrder.service_provider_id', array('class'=>'textBoxExpnd','empty'=>'Please Select','id'=>'rad_service_provider_id','options'=>$serviceProviders,'label' => false)); ?>
			
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>-->
		<?php echo $this->Form->hidden('RadiologyTestOrder.patient_id',array('label'=>false,'type'=>'text','value'=>$patientId));?>
		 <tr>
			<td width="19%" id="boxSpace" class="tdLabel">Relevant Clinical Information<span style="font-size:11px;font-style:italic">(Comments or Special Instructions)</span></td>
			<td width="19%"><?php echo $this->Form->input('RadiologyTestOrder.relevant_clinical_info', array('class'=>'textBoxExpnd','id' => 'relevant_clinical_info','type'=>'text','label'=>false )); ?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel">Ordering Provider</td>
			<td width="19%"><?php //if($this->Session->read('role')=='Primary Care Provider'){
							$getDocName=$dName; // From Appointment	
						//}	
			echo $this->Form->input('RadiologyTestOrder.primary_care_pro', array('class'=>'textBoxExpndAutocomplete','id' => 'primary_care_pro','type'=>'text',
					'style'=>'background: none;','label'=>false,'value'=>$getDocName )); ?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel"><?php echo __("Additional Notes");?>
			<span style="font-size:11px;font-style:italic"><?php echo __("(Max 150 characters)");?></span>
			</td>
			<td width="19%"><?php 
		echo $this->Form->textarea('RadiologyTestOrder.additional_notes', array('class'=>'textBoxExpnd','cols' => '2', 'rows' => '2', 'id' => 'additionalNotes', 'label'=> false, 'div' => false, 'error' => false,'maxlength'));
		?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr id="appendQuestions_0">
						<td width="19%" id="boxSpace" class="tdLabel">Select Diagnosis<font color="red">*</font></td>
						<td width="19%"><?php  
						echo $this->Form->input('RadiologyTestOrder.icd9_code',array('class'=>'textBoxExpnd icd9_code validate[required,custom[mandatory-select]]','empty'=>'Please Select','options'=>$diagnosesData,'id'=>'icd9_code','div'=>false,'label'=>false,'selected'=>$labRad));
						echo $this->Form->input('RadiologyTestOrder.diagnosis',array('class'=>'textBoxExpnd diagnoses_lab_name','type'=>'hidden','id'=>'diagnoses_rad_name_0','div'=>false,'label'=>false,'value'=>reset($diagnosesData)));
						?>
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
		
		<!-- <tr>
			<td colspan='2' align='right' valign='bottom'>
            <div style="text-align:center; margin:0 60px 0 0;"><?php  
			if($noteId=='null'){
			 echo $this->Html->link(__('Cancel'),array("controller"=>'notes',"action"=>'soapNote',$patientId),array('id'=>'labsubmit1','class'=>'blueBtn'));
			  echo $this->Form->submit(__('Submit'),array('disabled'=>'disabled','id'=>'radsubmit','class'=>'grayBtn','onclick'=>"javascript:save_rad(); return false;",'div'=>false)); 
			}else{
				echo $this->Html->link(__('Cancel'),array("controller"=>'notes',"action"=>'soapNote',$patientId,$noteId),array('id'=>'labsubmit1','class'=>'blueBtn'));
				 echo $this->Form->submit(__('Submit'),array('disabled'=>'disabled','id'=>'radsubmit','class'=>'grayBtn','onclick'=>"javascript:save_rad(); return false;",'div'=>false));
}?>
			</div>
			</td>
		</tr> -->
		
	</table>
	<!-- <div style="height:300px"></div> -->

	<!--BOF list -->
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%" style="text-align: center;">
		<?php if(isset($radiology_test_ordered) && !empty($radiology_test_ordered)){ 

			//debug($radiology_test_ordered);

			?>
		<tr class="row_title">
			<td class="table_cell" align="left"><strong> <?php echo  __('Radiology Order id', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo  __('Order Time', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo __('Test Name', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo  __('CPT Code', true); ?>
			</strong></td>
			<td class="table_cell" align="left"><strong> <?php echo  __('Status'); ?>
			</strong></td>

			<td class="table_cell" align="left"><strong> <?php echo  __('Action'); ?>
			</strong></td>

		</tr>
		<?php //echo "<pre>"; print_r($radiology_test_ordered);
			$toggle =0;
			$time ='' ;
			if(count($radiology_test_ordered) > 0) {
									foreach($radiology_test_ordered as $labs){
							   			   /*$splitDateTime   = explode(" ",$labs['RadiologyTestOrder']['create_time']) ;
							   			    $splitTime = explode(":",$splitDateTime[1]);
							   			   $currentTime =  $splitTime[0].":".$splitTime[1];
							   			   $timeWtoutSec = $splitDateTime[0]." ".$currentTime ;*/
										   $currentTime = $labs['RadiologyTestOrder']['batch_identifier'];
										   if($time != $currentTime ){
										   		if(!empty($radiology_test_ordered)) {
										   			echo "<tr class='row_title'><td colspan='6' align='right' style='padding: 8px 5px;'>" ;
										   			echo $this->Form->Button(__('Print Slip'),
													     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'radiologies','action'=>'investigation_print',$patient_id,$currentTime))."', '_blank',
															   'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
													echo "</td></tr>" ;
		                                 		}else{
		                                 			echo "<tr class='row_title'><td colspan='6'>&nbsp;</td></tr>" ;
		                                 		}
										   }

										   $time  =  $currentTime;
										   if($toggle == 0) {
												echo "<tr class='row_gray'>";
												$toggle = 1;
										   }else{
												echo "<tr>";
												$toggle = 0;
										   }
										   //status of the report
										   if($labs['RadiologyResult']['confirm_result']==1){
										   		$status = 'Result published';

										   }else{
										   		$status = 'Pending';

										   }
										   ?>
		<td class="row_format" align="left"><?php echo $labs['RadiologyTestOrder']['order_id']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($labs['RadiologyTestOrder']['start_date'],Configure::read('date_format')); ?>
		</td>
		<td class="row_format" align="left"><?php echo ucfirst($labs['Radiology']['name']); ?>

		</td>
		<td class="row_format" align="left"><?php echo $labs['Radiology']['cpt_code']; ?>
		</td>

		<td class="row_format" align="left"><?php echo $status; ?>
		</td>

		<td class="row_format" align="left"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'radiologies','action' => 'ra', $labs['RadiologyTestOrder']['id'],$currentTime), array('escape' => false),__('Are you sure?', true));
		$radio_id = $labs['RadiologyTestOrder']['id'];
		echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_radorder($radio_id);return false;")), array(), array('escape' => false));
		?>
		</td>
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
		<?php } ?>
		<?php					  
		} else { }?>

		<?php echo $this->Js->writeBuffer();?>
		<?php echo $this->Form->end();?>
	</table>
	<script>
	function getRadDetail(){
		   var labid = $('#rad_testcode').val();
		   if(labid==''){
			   $('#rad_testname').val('');
		   }
		   if(labid!=''){
			  var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "diagnoses", "action" => "getRadDetails","admin" => false)); ?>";
		        $.ajax({
		          type: 'POST',
		          beforeSend : function() {
						//this is where we append a loading image
		            	$('#busy-indicator').show('fast');
					},
		          url: ajaxUrl+"/"+labid,
		          data: '',
		          dataType: 'html',
		          success: function(data){ 
		        	  $('#busy-indicator').hide('fast');
		          data = jQuery.parseJSON(data);
		        $("#rad_testname").val(data.name);
		        $("#rad_sctCode").val(data.test_code);
		        $("#rad_LonicCode").val(data.lonic_code);
		        $("#rad_testcode").val(data.sct_concept_id);
		        $("#rad_cptCode").val(data.cpt_code);
		        $("#rad_id").val(labid);
		        $('#radsubmit').removeClass('grayBtn').addClass('blueBtn');
		        $('#radsubmit').attr("disabled",false);
		        },
					
					error: function(message){
		              alert("Internal Error Occured. Unable to set data.");
		          }        });
		    
		    return false; 
		}
	}
	$("#start_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange: '-100:' + new Date().getFullYear(),
				max : new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
				//	$(this).focus();
				//	$(this).validationEngine("hidePrompt");
				}

			});
	$("#radiology_order_date")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange: '-100:' + new Date().getFullYear(),
				//maxDate : new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
				onSelect : function() {
					//$(this).focus();
				//	$(this).validationEngine("hidePrompt");
				}

			});
	function save_rad(Clinical){
		var getdata=Clinical;
		
		var validateMandatory = jQuery("#Radfrm").validationEngine('validate');
		if(validateMandatory == false){ 
			return false;
		}else{ 	
		var testOrdId = $('#radTestId').val();
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addRad",$patientId,$noteId,"admin" => false)); ?>";
		   var formData = $('#Radfrm').serialize();
	           $.ajax({
	            type: 'POST',
	            beforeSend:function(){
	 			  	// this is where we append a loading image
	 			  	$('#busy-indicator').show('fast');
	 			  	 
	 			  },
	           url: ajaxUrl,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
		            if($.trim(data)=='sbar'){
		            	//window.location.href='<?php echo $this->Html->url(array("controller"=>'notes',"action" => "soapNote",$patientId,$noteId));?>'
		            	$('#busy-indicator').hide('fast');
		            	$( '#flashMessage', parent.document).html('Radiology Saved.');
						$('#flashMessage', parent.document).show();
						parent.$.fancybox.close();
						parent.location.reload(true);
		            }
		            else{
			            var fromNoteId=$.trim(data);
		            	window.location.href='<?php echo $this->Html->url(array("controller"=>'notes',"action" => "soapNote",$patientId));?>'+'/'+fromNoteId
		            	$('#busy-indicator').hide('fast');
		            	$( '#flashMessage', parent.document).html('Radiology Saved.');
						$('#flashMessage', parent.document).show();
						parent.$.fancybox.close();
		            }
				            
	            	
		            }
		            ,
					error: function(message){
						$( '#flashMessage', parent.document).html('Please try later.');
						$('#flashMessage', parent.document).show();
						parent.$.fancybox.close();
		            }        });
	           return false;
		}
		      
		      
		}
	function proceduresearch(source) {
	    var identify =""; 
		identify = source;
		$.fancybox({
					'width' : '100%',
					'height' : '1000',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "proceduresearch")); ?>" + "/" + identify,
				});
	   } 
	jQuery(document).ready(function(){//dhr_flag=1
		$("#SelectRad1").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "labRadAutocomplete","Radiology",'id',"dhr_order_code","name",'dhr_flag=1',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'rad_testname,rad_testcode',
			onItemSelect:function(event, ui) { getRadDetail();},
		});
		
		$('#checkPro').click(function(){
			$('#radsubmit').removeClass('grayBtn').addClass('blueBtn');
	        $('#radsubmit').attr("disabled",false);

			});
	/*$("#primary_care_pro").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'doctor_id_txt,doctorID',
		});*/
});
	$('#icd9_code').change(function(){
		$('#diagnoses_rad_name_0').val($("#icd9_code option:selected").text());
		});
	</script>

</div>