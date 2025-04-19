<?php //debug($test_data);exit;
echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js','jquery.blockUI'));
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->css(array('jquery-ui-1.8.16.custom.css','jquery.fancybox-1.3.4.css','jquery.ui.all.css','internal_style.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));?>
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
<?php echo $this->Form->create('EditRad',array('action'=>'edit','id'=>'editrad','type'=>'post'));?>
<div id="radiology-investigation" style="display: block;">

	<div class="clr ht5"></div>
<div class="inner_title">
	<h3>
		<?php echo __('Edit Radiology '); ?>
	</h3>

</div>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="80%" style="text-align: left; color: #fff;">
		<tr>

			<td width="25%" class="tdlabel" id="boxspace">Test Name:<font color="red">*</font></td>
			<td width="50%"><?php  echo $this->Form->input('RadiologyTestOrder.testname',
					array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','div'=>false,
					'label'=>false,'id'=>'rad_testname','readonly'=>'readonly','style'=>'','value'=>$test_data['Radiology']['name'],'readonly'=>'readonly'));  
			echo $this->Form->hidden('RadiologyTestOrder.id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'','value'=>$test_data['RadiologyTestOrder']['id']));
			
			?>
			</td>
		</tr>

		<tr>

			<td class="tdlabel" id="boxspace">Start Date: <!--  <font color="red">*</font> -->
			</td>

			<td class="tddate"><?php echo $this->Form->input('RadiologyTestOrder.start_date',array('class'=>'start_cal textBoxExpnd','id'=>'start_date','readonly'=>'readonly','autocomplete'=>'off','type'=>'text','value'=>$this->DateFormat->formatDate2Local($test_data['RadiologyTestOrder']['start_date'],Configure::read('date_format'),false),'label'=>false )); ?>
			</td>
		</tr>
			<tr>
			<td class="tdlabel" id="boxspace">Accessession Number:</td>
			<td><?php echo $this->Form->input('RadiologyTestOrder.order_id', array('type'=>'text','id' => 'order_id','label'=>false,'class' => 'textBoxExpnd','style'=>'','value'=>$test_data['RadiologyTestOrder']['order_id'],'readonly'=>'readonly' )); ?>
			</td>
		</tr>
	<!--  	<tr>
			<td class="tdlabel" id="boxspace">Number of written radiology orders:</td>
			<td><?php echo $this->Form->input('RadiologyTestOrder.radiology_order', 
					array('type'=>'text','id' => 'radiology_order','value'=>$test_data['RadiologyTestOrder']['radiology_order'],'label'=>false,'class' => 'textBoxExpnd','style'=>'' )); ?>
			</td>
		</tr>-->
		<tr>
			<td class="tdlabel" id="boxspace">Date of order:</td>
			<td class="tddate"><?php echo $this->Form->input('RadiologyTestOrder.radiology_order_date',
					 array('class' => 'textBoxExpnd','value'=>$this->DateFormat->formatDate2Local($test_data['RadiologyTestOrder']['radiology_order_date'],Configure::read('date_format'),false),'id' => 'radiology_order_date','type'=>'text','label'=>false )); ?>
			</td>


		</tr>
	<!-- 	<tr>
			<td width="19%" id="boxSpace" class="tdLabel"><?php echo __("Send To Radiology Facility");?>:</td>
			<td width="31%"><?php echo $this->Form->input('RadiologyTestOrder.service_provider_id', array('class'=>'textBoxExpnd','empty'=>'Please Select','id'=>'rad_service_provider_id','options'=>$serviceProviders,'label' => false)); ?>
			<?php //echo $this->Form->hidden('RadiologyTestOrder.patient_id',array('label'=>false,'type'=>'text','value'=>$patientId));?>
			</td>


			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr> --> 
			<tr>
			<td width="19%" id="boxSpace" class="tdLabel">Relevant Clinical Information<span style="font-size:11px;font-style:italic">(Comments or Special Instructions)</span></td>
			<td width="19%"><?php echo $this->Form->input('RadiologyTestOrder.relevant_clinical_info', array('class'=>'textBoxExpnd','id' => 'relevant_clinical_info','type'=>'text','label'=>false ,'value'=>$test_data['RadiologyTestOrder']['relevant_clinical_info'])); ?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="19%" id="boxSpace" class="tdLabel">Ordering Provider</td>
			<td width="19%"><?php $getDocName=$this->Session->read('first_name').' '.$this->Session->read('last_name');
			echo $this->Form->input('RadiologyTestOrder.primary_care_pro', array('class'=>'textBoxExpnd','id' => 'primary_care_pro','type'=>'text','label'=>false,'value'=>$getDocName,'value'=>$test_data['RadiologyTestOrder']['primary_care_pro'] )); ?>
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
		<tr>
			<td colspan='2' align='right' valign='bottom'><?php  echo $this->Form->submit(__('Submit'),array('id'=>'radsubmit','class'=>'blueBtn','onclick'=>"javascript:save_rad(); return false;")); ?>
			</td>
		</tr>
		
	</table>
	<div style="height:300px"></div>

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
		echo $this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit', 'onclick'=>"edit_radorder($radio_id);return false;"), array('escape' => false));
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
				min:new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					//$(this).focus();
				//	$(this).validationEngine("hidePrompt");
				}

			});
	function save_rad(Clinical){
		var testOrdId = $('#radTestId').val();
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "notes", "action" => "editRad","admin" => false)); ?>";
		   var formData = $('#editrad').serialize();
	           $.ajax({
	            type: 'POST',
	           url: ajaxUrl,
	            data: formData,
	            dataType: 'html',
	            success: function(data){
	            	$( '#flashMessage', parent.document).html('Radiology Updated.');
					$('#flashMessage', parent.document).show();
					parent.$.fancybox.close();
		            }
		            ,
					error: function(message){
						$( '#flashMessage', parent.document).html('Please try later.');
						$('#flashMessage', parent.document).show();
						parent.$.fancybox.close();
		            }        });
		      
		      return false;
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
	jQuery(document).ready(function(){
		$("#SelectRad1").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","Radiology",'id',"name",'dhr_flag=1',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'rad_testname,rad_testcode',
			onItemSelect:function(event, ui) { getRadDetail();},
		});
		
		$('#checkPro').click(function(){
			$('#radsubmit').removeClass('grayBtn').addClass('blueBtn');
	        $('#radsubmit').attr("disabled",false);

			});
});
	</script>

</div>