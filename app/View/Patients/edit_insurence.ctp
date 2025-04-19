<?php echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','ui.datetimepicker.3.js',
		'jquery.validationEngine','/js/languages/jquery.validationEngine-en',
		'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','jquery-ui-1.10.2.js','jquery.fancybox-1.3.4'));?>
<?php echo $this->Html->css(array('jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css',
		'home-slider.css','ibox.css','jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));?>
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"> -->
<!--  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
<!--  <link rel="stylesheet" href="/resources/demos/style.css"> -->
<style type="text/css">
body {
	margin-top: 0px;
	font-family: inherit;
	line-height: 1.6
}

.container {
	width: 1200px;
	margin: 0 auto;
}

ul.tabs li {
	background: none;
	color: #222;
	display: inline-block;
	padding: 10px 15px;
	cursor: pointer;
}

ul.tabs li.current {
	background: #ededed;
	color: #222;
}

.tab-content {
	background: none;
}

.ui-widget-header {
	background: none;
}

.tab-content current {
	display: inherit;
}

.ui-helper-clearfix {
	display: table-header-group;
}

.ui-state-default {
	background: #4C5E64 !important;
	color: #000 !important;
}

.ui-state-active {
	background: #4C5E64 !important;
	color: #fff !important;
}

.ui-state-active a,.ui-state-active a:link,.ui-state-active a:visited {
	background: #4C5E64 !important;
	color: #fff !important;
}

.ui-state-default a,.ui-state-default a:link,.ui-state-default a:visited
	{
	color: #fff !important;
}
</style>
<style>
label {
	width: 126px;
	padding: 0px;
}
</style>
<style>
.checkbox {
	float: left;
	width: 100%
}

.checkbox label {
	float: none;
}

.dat img {
	float: inherit;
}
</style>
<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
    </script>
<div id="flashMessage"></div>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Manage Patient Insurance', true);
			?>
	</h3>
	
	<span style="padding-right: 25px;"> <?php echo $this->Html->link(__('Back', true),array('controller' => 'patients', 'action' => 'insuranceindex',$patient_id), array('escape' => false,'class'=>'blueBtn'));?>
	</span>

</div>

<div id="tabs" class="container" style="padding-top: 10px;">
	<ul class="tabs">
		<li class="tab-link" data-tab="tab-1"><a href="#tabs-1">Payer
				Information</a></li>
		<li class="tab-link" data-tab="tab-2"><a href="#tabs-2">Employer
				Information</a></li>
		<li class="tab-link" data-tab="tab-3"><a href="#tabs-3">Subscribers
				Insurance</a></li>
	</ul>
	<?php  echo $this->Form->create('NewInsurance',array('url'=>array('controller'=>'patients','action'=>'editInsurence',$patient_id),'id'=>'editinsurance','enctype' => 'multipart/form-data'));?>
	<?php echo $this->Form->input('id',array('type'=>'hidden'));?>
	<?php echo $this->Form->input('uploadedImageName',array('type'=>'hidden','value'=>$this->request->data['NewInsurance']['upload_image']));
	echo $this->Form->hidden('web_cam',array('id'=>'web_cam'));
	?>

	<div id="tabs-1" style="padding-top: 5px;" class="tab-content current">



		<table width="100%">
			<tr>
				<td width="60%" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0"
						class="formFull">

						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace">Payer
								Name<font color="red">*</font>
							</td>
							<td width="250"><?php echo $this->Form->input('NewInsurance.insurance_type_id', array('label'=>false,'empty'=>__('Select'),'options'=>$getDataInsuranceType
                        		,'id' => 'insurance_type_id','onChange'=>'javascript:insurance_type_onchange()','autocomplete'=> 'off','class' => 'validate[required,custom[mandatory-select]]','selected'=>$getDataForEdit['0']['NewInsurance']['insurance_type_id'])); ?></td>
							<td width="">&nbsp;</td>
							<td width="100" class="tdLabel" id="boxSpace">Plan<font
								color="red">*</font></td>
							<td width="250">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width=""><?php 
                         echo $this->Form->input('NewInsurance.insurance_company_id', array('label'=>false,'selected'=>$this->request->data['NewInsurance']['insurance_company_id'],'empty'=>__('Select'),'options'=>$getDataInsuranceCompany
                            		,'id' => 'insurance_company_id','class' => 'validate[required,custom[mandatory-select]]')); ?></td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td class="tdLabel" id="boxSpace">Priority<font color="red">*</font></td>
							<td><?php echo $this->Form->input('NewInsurance.priority', array('label'=>false,'empty'=>__('Select'),'options'=>array('Primary'=>'Primary','Secondary'=>'Secondary','Unknown'=>'Unknown')
                        		,'class' => 'validate[required,custom[mandatory-select]]','id' => 'priority','selected'=>$getDataForEdit['0']['NewInsurance']['priority'])); ?></td>
							<td>&nbsp;</td>
							<td class="tdLabel" id="boxSpace">Insurance ID</td>
							<td><?php echo $this->Form->input('NewInsurance.insurance_number', array('label'=>false,'id' => 'insurance_number')); ?></td>
						</tr>
						<tr>
							<td valign="middle" class="tdLabel" id="boxSpace">Group ID</td>
							<td><?php echo $this->Form->input('NewInsurance.group_number', array('label'=>false,'id' => 'group_number')); ?></td>
							<td>&nbsp;</td>
							<td class="tdLabel" id="boxSpace">Effective from</td>
							
							<td><?php echo $this->Form->input('NewInsurance.effective_date', array('label'=>false,'type'=>'text','class' => 'textBoxExpnd','id' => 'efdate',"style"=>"width:85px")); ?></td>
						</tr>
						<tr>
							<td class="tdLabel" id="boxSpace">Copay type<font
								color="red">*</font></td>
							<td><?php  echo $this->Form->input('NewInsurance.copay_type', array('label'=>false,'empty'=>__("Select"),'options'=>array('Fixed','Percentage'),'id' => 'copay_type','class' => 'validate[required,custom[mandatory-select]]','onchange'=>'javascript:getPercentage()','selected'=>$getDataForEdit['0']['NewInsurance']['copay_type'])); ?></td>
							<td>&nbsp;</td>
							<td class="tdLabel" id="boxSpace">Relation to insured</td>
							<td><table width="100%" cellpadding="0" cellspacing="0"
									border="0">
									<tr>

										<td><?php echo $this->Form->input('NewInsurance.relation', array('label'=>false,'empty'=>__("Select"),'options'=>array('self'=>'Self','spouse'=>'Spouse','child'=>'Child','other'=>'Other')
                        		,'id' => 'relation','selected'=>$getDataForEdit['0']['NewInsurance']['relation'])); ?></td>
										<td>&nbsp;</td>

									</tr>
								</table></td>
						</tr>
						<tr>
							<?php  if(!empty($getDataForEdit['0']['NewInsurance']['fixed_percentage'])){
                     $dataFixPercentage=$getDataForEdit['0']['NewInsurance']['fixed_percentage'];
                  
                     }
                     else{
						$dataFixPercentage="Enter Percentage(ex:30%)";
					
						}
						if(!empty($getDataForEdit['0']['NewInsurance']['fixed_amt'])){
							$dataFix=$getDataForEdit['0']['NewInsurance']['fixed_amt'];
						}
						else{
							$dataFix="Enter Amount(ex:$300)";
						}
						?>
							<td valign="middle" class="tdLabel" id="boxSpace"></td>
							<td><?php echo $this->Form->input('NewInsurance.fixed_percentage', array('label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd fixed_percent','id' => 'fixed_percentage','onclick'=>'javascript:removetext()'));
                           echo $this->Form->input('NewInsurance.fixed_amt', array('label'=>false,'class' => 'validate[required,custom[name],custom[onlyNumberSp]] textBoxExpnd','id' => 'fixed_amt','onclick'=>'javascript:removetext()')); ?></td>
							<td>&nbsp;</td>
							<?php $checked = ($this->request->data['NewInsurance']['is_active'] == '1') ? true : false; ?>
							<td class="tdLabel" id="boxSpace">Active</td>
							<td><?php echo $this->Form->checkbox('NewInsurance.is_active', array('label'=>false,'id' => 'is_active','checked'=>$checked)); ?></td>

						</tr>
						<tr>
							<td>
						<tr>
							<td class="tdLabel" id="boxSpace">Upload Insurance Card</td>
							<td>
								<table width="300">
									<tr>
										<td width="1200px" class="tdLabel" id="boxSpace"><?php 
					echo $this->Form->input('upload_image', array('type'=>'file','id' => 'patient_photo', 'class'=>"textBoxExpnd",'label'=> false,
					 				'div' => false, 'error' => false));
							
								?>
										</td>
										<?php//if(!empty($getDataForEdit['NewInsurance']['id'])){?>
										<td id="viewImage" width="300px" class="tdLabel"><?php //debug($this->request->data);
										$imageName =  $this->request->data['NewInsurance']['upload_image']; ?>
										<span style="cursor:pointer;" title="View Image" onclick="getImage('<?php echo $imageName ?>');return false;">View Card</span></td>
									</tr>
									<tr><td><?php echo $this->Html->image('/img/icons/webcam.png',array('id'=>'camera','title'=>'Capture photo from webcam'));?>                        
                               <canvas width="320" height="240" id="parent_canvas"        style="display: none;"></canvas>     </td></tr>
								</table>

								</td>
						</tr>
						<?php echo $this->Form->hidden('NewInsurance.location_id', array('label'=>false,'value'=>$this->Session->read('locationid'),'id' => 'location_id')); ?>

						<?php echo $this->Form->hidden('NewInsurance.patient_uid', array('label'=>false,'value'=>$patient_id,'id' => 'patient_uid')); ?>
						</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div id="tabs-2" class="tab-content" style="padding-top: 5px;">
		<table width="100%">
			<tr>
				<td width="60%" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0"
						class="formFull">
						<tr>
							<td style="padding-left: 10px; width: 50px;">Employer</td>
							<td style="padding-left: 10px; width: 50px;"><?php echo $this->Form->input('NewInsurance.employer', array('label'=>false,'div'=>false,'id' => 'employer','width'=>'30px','value'=>$getDataForEdit['0']['NewInsurance']['employer'])); ?></td>
							<td>&nbsp;</td>
						</tr>
						
						<tr>
							<td style="padding-left: 10px; width: 50px;">Note</td>
							<td style="padding-left: 10px; width: 50px;"><?php echo $this->Form->input('NewInsurance.note', array('label'=>false,'rows'=>'3','cols'=>'5','div'=>false,'id' => 'employer','width'=>'30px','type'=>'textarea')); ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div id="tabs-3" class="tab-content" style="padding-top: 5px;">

		<table width="100%">
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0"
						class="formFull">

						<tr>
							<th style="padding-left: 10px;" colspan="2"><?php echo __('');?>
								<?php echo $this->Form->input('NewInsurance.chkclick', array('type'=>'checkbox','id' => 'ckeckGua','label'=>'Check to copy Guaranter details')); ?>
							</th>
						</tr>

						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace">Subscriber
								name</td>
							<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_name', array('id'=>'subscriber_name','label'=>false,'style'=>'width:150px','div'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['subscriber_name'])); ?>
								<?php  echo $this->Form->input('NewInsurance.subscriber_initial', array('id'=>'gau_middle_name','label'=>false,'style'=>'width:90px','div'=>false)); ?></td>
						</tr>

						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right">Subscriber Last name</td>
							<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_last_name', array('id'=>'gau_last_name','label'=>false,'style'=>'width:260px')); ?></td>
						</tr>

						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right"><br />Date of Birth</td>
							<td width="250"><br /> 
								<?php echo $this->Form->input('NewInsurance.subscriber_dob',array('id'=>'dobg','type'=>'text','autocomplete'=>"off",'legend'=>false,'div'=>false,'label'=>false));?>
								&nbsp;Gender <?php echo $this->Form->input('NewInsurance.subscriber_gender', array('id'=>'gau_sex','empty'=>__("Select"),'options' => array('m'=>'Male','f'=>'Female'), 'default' => '','label'=>false,'div'=>false,'value'=>$getDataForEdit['0']['NewInsurance']['subscriber_gender']));?></td>
						</tr>

						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right"><br />Social Security Number</td>
							<td width="250"><br /> <?php echo $this->Form->input('NewInsurance.subscriber_security', array('id'=>'gau_ssn','maxLength'=>'10','label'=>false,'style'=>'width:260px')); ?></td>
						</tr>

						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right"><br />Address1</td>
							<td width="250"><br /> <?php echo $this->Form->input('NewInsurance.subscriber_address1', array('id'=>'gau_plot_no','label'=>false,'style'=>'width:260px')); ?></td>
						</tr>
						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right">Address2</td>
							<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_address2', array('id'=>'gau_landmark','label'=>false,'style'=>'width:260px')); ?></td>
						</tr>
						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right">Country</td>
							<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_country', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry1', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'persons','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#customstate1', 'data' => '{reference_id:$("#customcountry1").val()}', 'dataExpression' => true, 'div'=>false)))); ?>
							</td>
						</tr>
						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right">State</td>
							<td width="250" id="customstate1"><?php 
                        echo $this->Form->input('NewInsurance.subscriber_state', array('id'=>'customstate12','options' => $state, 'empty' => 'Select State', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:126px')); ?></td>
						</tr>
						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right">City</td>
							<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_city', array('id'=>'city','label'=>false,'style'=>'width:170px','div'=>false)); ?>
							</td>
						</tr>
						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right">Zip Code</td>
							<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_zip', array('id'=>'subscriber_zip','label'=>false,'style'=>'width:260px')); ?></td>
						</tr>
						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right">Primary Phone</td>
							<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_primary_phone', array('id'=>'gau_home_phone','label'=>false,'style'=>'width:170px','div'=>false)); ?>
							</td>
						</tr>
						<tr>
							<td width="100" valign="middle" class="tdLabel" id="boxSpace"
								align="right">Secondary Phone</td>
							<td width="250"><?php echo $this->Form->input('NewInsurance.subscriber_secondary_phone', array('id'=>'gau_mobile','label'=>false,'style'=>'width:170px','div'=>false)); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div>
		<?php
   echo $this->Form->submit(__('Submit'), array('escape' => false,'class'=>'blueBtn','id'=>'submit'));
   ?>
		<?php echo $this->Form->end();?>
	</div>
</div>
<script>
function insurance_type_onchange(){
	var id = $('#insurance_type_id').val();
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "insurance_onchange","admin" => false)); ?>";
	$.ajax({
	type: 'POST',
	url: ajaxUrl+"/"+id,
	data: '',
	dataType: 'html',
	success: function(data){
	  	data= $.parseJSON(data);
	  	if(data !=''){
	  		$("#insurance_company_id option").remove();
	  		//$("#save").removeAttr('disabled');
		  	$.each(data, function(val, text) {
			  	if(text)
			    $("#insurance_company_id").append( "<option value='"+val+"'>"+text+"</option>" );
			}); 
	  	}else{  
	  		$("#insurance_company_id option").remove();
	  		//$("#save").attr('disabled','disabled');
		  	alert("Data not available");
	  	} 
	  	
	  	    
	},

	error: function(message){
	alert("Internal Error Occured. Unable to set data.");
	} });

	return false;
	}
$(document).ready(function(){
	$("#dobg")
	.datepicker(
			{
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,

			changeYear : true,

			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
			$(this).focus();
			}

		});	
	 });
$("#efdate")
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
				$(this).focus();
				//foramtEnddate(); //is not defined hence commented
			}

		});

$('#camera')
.click(
		function() {
			$
					.fancybox({
						'autoDimensions' : false,
						'width' : '85%',
						'height' : '90%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : '<?php echo $this->Html->url(array("action" => "webcam")); ?>'
					});
		});

function getImage(imageName){ //alert(imageName);
	$.fancybox({
		'width' : '19%',
		'height' : '40%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		
		'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "viewImage")); ?>"+'?image='+imageName

	});
}
 </script>
<script>

 function getPercentage(){
	var getData = $("#copay_type option:selected").val();
	
	if(getData=='1'){
		$("#fixed_percentage").show();
		$("#fixed_amt").hide();
		//alert('if');
	}	
	else if(getData=='0'){
		$("#fixed_amt").show();
		$("#fixed_percentage").hide();//alert('else');
	}
}
 function removetext(){
	 
	 $("#fixed_amt").val(" ");
	 $("#fixed_percentage").val(" ");
 }


 $("#ckeckGua").change(function edit_loadGauranter(){
var id='<?php echo $patient_id ;?>';
	// alert(id);
		//return;
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "edit_loadGauranter","admin" => false)); ?>
	";
						var formData = $('#editinsurance').serialize();
						if (formData == "") {
							var formData = $('#patientnotesfrm').serialize();
							var renderpage = true;
						}
						$.ajax({
							type : 'POST',
							url : ajaxUrl + "/" + id,
							//  data: formData,
							dataType : 'html',
							success : function(data) {

								var data = data.split("|"); //alert(data[9]);
								$("#person_id").val(id);
								$("#subscriber_name").val(data[0]);//alert(data[0]);
								$("#gau_middle_name").val(data[1]);
								$("#gau_last_name").val(data[2]);
								$("#dobg").val(data[3]);
								$("#gau_sex").val(data[4]);
								$("#gau_ssn").val(data[5]);
								$("#gau_plot_no").val(data[6]);
								$("#gau_landmark").val(data[7]);
								$("#customcountry1").val(data[8]);
								$("#customstate12").val(data[9]);
								$("#city").val(data[10]);
								$("#subscriber_zip").val(data[11]);
								$("#gau_home_phone").val(data[12]);
								$("#gau_mobile").val(data[13]);
							},
							error : function(message) {
								alert("Error in Retrieving data");
							}
						});
						return false;

					});
</script>
<script>
	$(document).ready(
			function() {
				var copay_type = $('#copay_type').val();
				if (copay_type == '0') {
					$('#fixed_amt').show();
					$('#fixed_percentage').hide();
				} else if (copay_type == '1') {
					$('#fixed_percentage').show();
					$('#fixed_amt').hide();
				} else {
					$("#fixed_percentage").hide();
					$("#fixed_amt").hide();
				}
				// alert(copay_type);
				///	fixed_amtfixed_percentage
				jQuery("#editinsurance").validationEngine({
					validateNonVisibleFields : true,
					updatePromptsPosition : true,
				});
				$('#submit').click(
						function() {
							//alert("hello");
							var validatePerson = jQuery("#editinsurance")
									.validationEngine('validate');
							//alert(validatePerson);
							if (validatePerson) {
								$(this).css('display', 'none');
							}
							//return false;
						});
			});
</script>