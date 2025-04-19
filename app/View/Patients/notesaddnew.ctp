<?php 
echo $this->Html->css(array('drag_drop_accordian.css','ros_accordian.css'));
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4','pager'));
echo $this->Html->script(array(/* 'jquery-1.9.1.js','jquery-ui-1.10.2.js', */'expand.js','jquery.selection.js','jquery.blockUI'));


?>
<?php 
echo $this->Html->css(array('tooltipster.css'));
echo $this->Html->script(array('jquery.tooltipster.min.js'));

?>
<style>
.spNoteTextArea {
	width: 983px !important;
	height: 150px;
}

.resize-input {
	height: 18px;
	width: 183px;
}

.scrollBoth {
	scroll: both;
}

.elapsedRed {
	color: red;
}

.elapsedGreen {
	color: Green;
}

.elapsedYellow {
	color: orange;
}
</style>
<style>
.pointer {
	cursor: pointer;
}

.ui-widget-content {
	color: #fff;
	font-size: 13px;
}

.top-header .table_format td {
	padding-right: 0 !important;
}

.top-header .table_form,.table_format a {
	float: left;
}

.light:hover {
	background-color: #F7F6D9;
	text-decoration: none;
	color: #000000;
}

.pateintpic {
	border-radius: 25px !important;
}

.light td {
	font-size: 13px;
}

.patientHub .patientInfo .heading {
	float: left;
	width: 121px !important;
}

.system {
	cursor: pointer;
	text-decoration: underline;
}

.gender>span { /*float: right;*/
	font-weight: bold;
	margin: 0 0 0 90px;
	/*padding: 0 0 0 2px;*/
}

.dob>span {
	font-weight: bold;
	margin: 0 0 0 56px;
}

.pref_lang>span {
	font-weight: bold;
	margin: 0 0 0 9px;
}

.vis_typ>span {
	font-weight: bold;
	margin: 0 0 0 30px;
}

.clnt_snc>span {
	font-weight: bold;
	margin: 0 0 0 15px;
}

.elaps_time>span {
	font-weight: bold;
	margin: 0 0 0 6px;
}
input.blueBtn {
    height: 0;
    padding: 3px 8px;
}
</style>
<div class="message" id="flashMessage"
	style="display: none;">
	<!-- flash Message-->
</div>
<script>
var sample;
var global_note_id = "<?php echo $global_note_id;?>";	
var diagnosisSelectedArray = new Array();
function addDiagnosisDetails(){
	var selectedPatientId = '<?php echo $patientId?>';
	if(selectedPatientId != ''){
		
		var currEle = diagnosisSelectedArray.pop();
		if((currEle !='') && (currEle !== undefined)){
			openbox(currEle,selectedPatientId,parent.global_note_id);
		}
	}
	
}
function openbox(icd,note_id,linkId) { 
	// disable link after first click
	///---split for sending via url
	if(global_note_id==''){
		global_note_id='<?php echo $noteId?>';
		
	}
	icd = icd.split("::");
	var patient_id = '<?php echo $patientId?>';
	if (patient_id == '') {
		alert("Please select patient");
		return false;
	}
	$.fancybox({
		 		'autoDimensions': false, 
	        	'height': 500,
	        	'width': 600,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':false,
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
						 + '/' + patient_id + '/' + icd  + '/'+global_note_id , 
				'onClosed':function(){
					getproblem();
				} 				
			}); 


	/*$('#fancybox-overlay').live('click',function(){
		var chk=confirm('Do you wish to cancel diagnosis?');
		if(chk==true){ 			
			addDiagnosisDetails();
			$.fancybox.close();			
		}else{ 
			return false;
		} 
	});*/

}
var currTab = "<?php echo $this->request->params['pass']['1']; ?>" ;
var sbarURL =  "<?php echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "sbar",$patientId,"admin" => false)); ?>" ;
  $(document).ready(function () {

	  //**********************************************SmartPharse************************************************************
	  $("#subShow").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			delay:500,
			//autoFill:true,
			select: function(e){ }
		});
	  $("#objectShow").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			delay:500,
			//autoFill:true,
			select: function(e){ }
		});
	  $("#AssesShow").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			delay:500,
			//autoFill:true,
			select: function(e){ }
		});
	  $("#planShow").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			delay:500,
			//autoFill:true,
			select: function(e){ }
		});
	  $("#subShowRos").autocomplete("<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "getSmartPhrase","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			//selectFirst: true,
			isSmartPhrase:true,
			delay:500,
			//autoFill:true,
			select: function(e){ }
		});
	  //********************************************************************************************************
		$(".Hope_Aditya-tab").click(function(){  
	        	var tabClicked = $("#"+this.id).html();
		         $(location).attr('href',sbarURL+'/'+tabClicked);
		});
		
		$("#tabs li").removeClass("ui-tabs-active");
        $("#tabs li").removeClass("ui-state-active");
        $("#"+currTab).addClass("ui-tabs-active");
        $("#"+currTab).addClass("ui-state-active");
        
	  $( "#tabs" ).tabs({
	    beforeLoad: function( event, ui ) {
	     // alert("sdgsgdsgd");
	      //event.preventDefault();
	      if(ui.jqXHR){
	    	  ui.jqXHR.abort();
	      }
	      //return;
	    }
	  });
	});
  </script>
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
<style>
* {
	padding: 0px;
	margin: 0px;
}

.td_add img {
	float: right;
	padding-right: 17px;
}

.header_navigation {
	width: 100%;
	padding: 0px;
	margin: 0px;
	border: px;
	height: 20px;
}

.header_navigation li {
	border: none;
	width: 18%
}

.mainInpatientSummaryWrapper {
	width: 100%;
	padding: 5px;
	border: 1px solid #EEEEEE;
	height: auto;
}

.mainul {
	
}

.mainul li {
	display: inline;
	width: 100%;
	list-style-type: none;
	list-style: none;
	padding-left: 10px;
}

.
.onelineli {
	width: 100%;
}

.onelineli li {
	display: inline;
	list-style-type: none;
	list-style: none;
	line-height: 0px;
	border-bottom: 1px thin #fff;
}

.textalign {
	text-align: left;
}

#talltabs-blue {
	border-top: 6px solid #8A9C9C;
	clear: left;
	float: left;
	font-family: Georgia, serif;
	overflow: hidden;
	padding: 0;
	width: 100%;
}

#talltabs-blue ul { /*  left: 50%; */
	list-style: none outside none;
	margin: 0;
	padding: 0;
	position: relative;
	text-align: center;
}

#talltabs-blue ul li {
	display: block;
	float: left;
	list-style: none outside none;
	margin: 0;
	padding: 0;
	position: relative;
	/* right: 50%;*/
}

#talltabs-blue ul li a {
	background: none repeat scroll 0 0 #8A9C9C;
	color: #FFFFFF !important;
	display: block;
	float: left;
	margin: 0 1px 0 0;
	padding: 8px 10px 6px;
	text-decoration: none;
}

#talltabs-blue ul li a:hover {
	background: #DDDDDD;
	color: #31859C !important;
}

.dragbox-content span {
	font-size: 13px;
}

.dragbox-content a {
	font-size: 13px;
}

#talltabs-blue ul li.active a,#talltabs-blue ul li.active a:hover {
	/*padding: 30px 10px 6px;*/
	background: #DDDDDD;
	color: #31859C !important;
}

.top-header {
	background: #d2ebf2;
	left: 0;
	right: 0;
	top: 0px;
	margin: 155px auto 0;
	position: absolute;
	z-index: 1000;
	width: 93%;
}

.table_format {
	padding: 10px;
}
</style>
<div id="mydiv">
	<?php 
	echo $this->Html->css(array('tooltipster.css'));
	echo $this->Html->script(array('jquery.tooltipster.min.js'));
	?>
	<div class="inner_title">
		<h3>
			<?php echo __('Add Progress Notes '); ?>
		</h3>
<?php echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Preview summary of care')),array('controller'=>'PatientsTrackReports',
			'action'=>'printSummary',$patientId,$getElement['Patient']['person_id'],$getElement['Patient']['patient_id'],
			'?'=>array('return'=>'soapNote','noteId'=>$noteId,'patient_id'=>$patientId)),array('div'=>false,'escape'=>false));?>
	</div>
	
	<?php 
$arr[]=Configure::read('patient_visit_type');// echo $this->element('patient_information');  ?>
	<?php $start=date('Y-m-d')." ".$_SESSION['elpeTym'];
	$elapsed=$this->DateFormat->dateDiff($start,date('Y-m-d H:i')) ;
	?>

	<?php
	if($elapsed->i!=0){
					$min=$elapsed->i;
				}else{
					$min='00';
				}
				if($elapsed->h!=0){
				if($elapsed->h>=12){
					$hrs=$elapsed->h-12;
				}else{
					$hrs=$elapsed->h;
				}
				$hrs= ($hrs * 60);
				$showTime=$hrs+$min;
				$soap_in=$hrs+$min;
			}else{
				$showTime=$min;
				$soap_in=$min;
			}
			if($showTime<15){
		 		$elapsedClass='elapsedGreen';
			}else if($showTime>=15 && $showTime<=30){
				$elapsedClass='elapsedYellow';
			}
			else if($showTime>30){
				$elapsedClass='elapsedRed';
				if($showTime>180){
					$showTime='180';
				}
			}
			?>
<div class="outerDivNew">
	<div class="top-header">
		<!-- top-header -->
		<table border="0" class="table_format" cellpadding="0" cellspacing="2"
			width="100%" id="addTable">
			<tr>
				<td class="tdClass" valign="top" style="width: 1%;">
					<table border="0" class="table_form" cellpadding="0"
						cellspacing="2" style="padding: 0px; width: 100px;">
						<tr>
							<td width='1%'><?php 
							if(!empty($getElement['Person']['photo'])){
							echo $this->Html->link($this->Html->image("/uploads/patient_images/thumbnail/".$getElement['Person']['photo'], array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$getElement['Patient']['person_id']), array('escape' => false));
						}else{
							echo $this->Html->link($this->Html->image('icons/default_img.png', array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$getElement['Patient']['person_id']), array('escape' => false));
						}

				  ?>
							</td>
						</tr>
						<td width='5%'><font color="#31859C"><?php echo $this->Html->link($getElement['Patient']['lookup_name'],array('controller'=>'PatientsTrackReports','action'=>'sbar',$patientId,'Summary'),array('label'=>false,'style'=>'font-size:12px!important;'));?>
						</font>
						</td>
					</table>
				</td>

				<!--<td width='5%'><font color="#31859C"><?php echo $this->Html->link($getElement['Patient']['lookup_name'],array('controller'=>'PatientsTrackReports','action'=>'sbar',$patientId,'Summary'),array('label'=>false));?></font>
		</td>-->
				<td class="tdClass" valign="top" style="width: 15%;">
				 <table border="0" class="table_form" cellpadding="0"cellspacing="2" style="padding: 0px;">
					<tr>
							<td>
								<table style="width: 330px">
									<td width='5%' class="gender" style="padding: 0 0 5px;"><b
										style="color: #31859c;"><?php echo "Gender"?> </b><span>:</span>
										<?php echo $getElement['Person']['sex'];?>
									</td>
									</tr>
									<tr>
										<td width='9%' class="dob" style="padding: 0 0 5px;"><b
											style="color: #31859c;"><?php echo "Date Of Birth"?> </b><span>:</span>
											<?php echo $this->DateFormat->formatDate2Local($getElement['Person']['dob'],Configure::read('date_format'))." (".$getElement['Person']['age'].")";?>
										</td>
									</tr>
									<tr>
										<?php if(empty($getElement['Person']['language'])){
											$language='Denied to Specify';
										}
										else{
													$lan=explode(',',$getElement['Person']['language']);
													for($i=0;$i< count($lan); $i++){
														if($i<count($lan)-1){
															$languageValue.=$language[$lan[$i]].',';
														}
														else{
															$languageValue.=$language[$lan[$i]];
														}
													}
										}?>
										<td width='10%' class="pref_lang" style="padding: 0 0 5px;"><b
											style="color: #31859c;"><?php echo "Preferred Language"?> </b><span>:</span>
											<?php echo " ".$languageValue;?>
										</td>
									</tr>
								</table>
							</td>
							<td width="15%"></td>
							<td>
								<table style="width: 311px; float: left;">
									<tr>
										<?php if(empty($getElement['Patient']['treatment_type'])){
											$vTpye='Not Indicated';
										}
										else{
											$vTpye=$arr['0'][$getElement['Patient']['treatment_type']];
										}?>

										<td width='10%' class="vis_typ" style="padding: 0 0 5px;"><b
											style="color: #31859c;"><?php echo "Visit Type"?> </b><span>:</span>
											<?php echo $vTpye;?>
										</td>
									</tr>
									<tr>
										<td width='6%' class="clnt_snc" style="padding: 0 0 5px;"><b
											style="color: #31859c;"><?php echo "Client Since"?> </b><span>:</span>
											<?php echo $this->DateFormat->formatDate2Local($getElement['Patient']['form_received_on'],Configure::read('date_format'));?>
										</td>
									</tr>
									<tr>
										<?php if(!empty($getVitals['Note']['soap_out'])){
											if($getVitals['Note']['soap_out'] >180){
						$showTime = 180;
					}else{
						$showTime=$getVitals['Note']['soap_out'];
					}
}?>
										<td width='6%' class="elaps_time" style="padding: 0 0 5px;"><b
											style="color: #31859c;">Elapsed Time</b><span>:</span> <span
											id="<?php echo 'elapsedtym';?>"
											class="<?php echo "elapsed ".$elapsedClass; ?>"> <?php echo $showTime.' Min';?>
										</span>
										</td>
									</tr>
								</table>
							</td>
				</tr>
						</table>
						</td>
						<td class="tdClass" valign="top" width="3%">

							<table border="0" class="" cellpadding="0" style="width: 323px;">
								<tr>

									<td><?php echo $this->Form->create('Note',array('action'=>'soapNote','id'=>'cc_id','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
										<table border="0" class="table_format" cellpadding="0"
											cellspacing="2" style="padding: 0px; width: 320px;">
											<tr>
												<div width="37%"
													style="color: #31859c; float: left; width: 150px;">
													<b><?php echo __("Chief Complaints");?> </b><font color="red">*</font>
												</div>
												<div width="1%" style="float: left;">
												<?php if(!empty($ccdata)){
												$checkccVal=1;
												echo $this->Form->hidden('',array('value'=>$checkccVal,'label'=>false,'id'=>'ccCheck'));
												}else{
												$checkccVal=0;
												echo $this->Form->hidden('',array('value'=>$checkccVal,'label'=>false,'id'=>'ccCheck'));
												}?>
													<?php echo $this->Form->input('cc',array('type'=>'text','cols'=>'1','rows'=>'1','style'=>'height:27px;','value'=>$ccdata,'label'=>false,'id'=>'cc','class'=>'resize-input'));?>
												</div>
												<?php echo $this->Form->hidden('id',array('value'=>$id));?>
												<?php echo $this->Form->hidden('patient_id',array('value'=>$patientId));?>
												<?php echo $this->Form->hidden('id',array('id'=>'ccid','value'=>$noteId));?>
												<?php echo $this->Form->hidden('appt',array('value'=>$appt));?>
												<?php echo $this->Form->hidden('soap_in',array('value'=>$soap_in));?>
												<?php echo $this->Form->hidden('soap_out',array('id'=>'soap_outCC','value'=>$soap_in));?>
												<div width="27%" style="float: left;">
													<?php //echo $this->Html->link($this->Html->image('icons/saveSmall.png'),'javascript:void(0)',array('onclick'=>"saveSoap('cc')",'label'=>false,'id'=>'cc_submit','escape'=>false));?>
												</div>
											</tr>
										</table> <?php echo $this->Form->end();?></td>
								</tr>
								<tr>
									<td><?php echo $this->Form->create('Note',array('action'=>'soapNote','id'=>'familyfrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
										<table border="0" class="table_format" cellpadding="0"
											cellspacing="2" style="padding: 0px;">
											<tr>
												<div style="color: #31859c; float: left; width: 150px;">
													<b><?php echo __("Family Personal Notes");?> </b>
												</div>
												<div style="float: left;">
												<?php if(!empty($family_tit_bit)){
												$checkFamilyVal=1;
												//echo $this->Form->hidden('',array('value'=>$checkFamilyVal,'label'=>false,'id'=>'ccCheck'));
												}else{
												$checkFamilyVal=0;
												//echo $this->Form->hidden('',array('value'=>$checkFamilyVal,'label'=>false,'id'=>'ccCheck'));
												}?>
													<?php echo $this->Form->input('family_tit_bit',
															array('type'=>'text','cols'=>'1','rows'=>'1','class'=>'resize-input', 'style'=>'height:27px;', 
																'value'=>$family_tit_bit,'label'=>false,'id'=>'family_tit_bit'));?>
												</div>
												<?php echo $this->Form->hidden('id',array('value'=>$id));?>
												<?php echo $this->Form->hidden('patient_id',array('value'=>$patientId));?>
												<?php echo $this->Form->hidden('id',array('id'=>'familyid','value'=>$noteId));?>
												<?php echo $this->Form->hidden('appt',array('value'=>$appt));?>
												<?php echo $this->Form->hidden('soap_in',array('value'=>$soap_in));?>
												<?php echo $this->Form->hidden('soap_out',array('id'=>'soap_outFamily','value'=>$soap_in));?>
												<div style="float: left;">
													<?php //echo $this->Html->link($this->Html->image('icons/saveSmall.png'),'javascript:void(0)',array('onclick'=>"saveSoap('familyfrm')",'label'=>false,'id'=>'cc1_submit','escape'=>false));?>
												</div>
											</tr>
										</table> <?php echo $this->Form->end();?></td>

								</tr>
								<tr>
									
								</tr>
							</table>
						</td>
						<td width="50%" valign="top" class="tdClass">
							<table border="0" class="table_form" cellpadding="0"
								cellspacing="2" style="padding: float:left;">
								<tr>
									<?php if($getVitals['Note']['positive_id']=='1'){
										$displayGreen='block';
										$displayRed='none';
									}
									else{
			$displayGreen='none';
			$displayRed='block';
		}
		?>
									<div
										style="padding: 5px 0 0 9px !important; color: #31859c; float: left;"
										colspan="2">
										<b><?php echo __("Positive Id Check");?> </b>
									</div>
									<div width='1%'
										style="padding-right: 0 !important; padding-left: 5px; float: left;">
										<span id="positiveRed" style="display:<?php echo $displayRed;?>">
											<?php echo $this->Html->image('icons/red.png',array('style'=>'cursor:pointer;','alt'=>'Patient Image','title'=>'Check Positive ID','id'=>'checkPostive'));?>
										</span> <span id="positiveGreen" style="display:<?php echo $displayGreen;?>">
											<?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed;','alt'=>'Positive ID Checked','title'=>' Positive ID Checked'));?>
										</span>
									</div>
									
								</tr>
								<div  width="20%" valign="top" style="padding-right:0!important; float:left;">
								<table style="float:left; width:300px;">
								<tr>
					                  <td><!--
										<table border="0" class="table_format" cellpadding="0"
											cellspacing="2" style="padding: 0px;">
											<tr>-->

												<div style="color: #31859c; width: 143px; float: left; width: 91px;">
													<?php if(empty($flagEvent)){
														$display='none';
													}else{
														$display='block';
														$checked='checked';
														$disabledCheckBox='disabled';
														}?>
													<b><?php echo __("Chart Alert"); 
													echo ' '.$this->Form->checkbox('',array('id'=>'showFlagEvent','checked'=>$checked,'disabled'=>$disabledCheckBox))?>
													</b>
													
												</div>
												<div >
												<?php if(!empty($flagEvent)){
												$checkFlagVal=1;
												//echo $this->Form->hidden('',array('value'=>$checkFlagVal,'label'=>false));
												}else{
												$checkFlagVal=0;
												//echo $this->Form->hidden('',array('value'=>$checkFlagVal,'label'=>false));
												}?>
													<span style="display:<?php echo $display;?>" id='eventText'><?php echo $this->Form->input('flag_event',array('type'=>'text','cols'=>'1','rows'=>'1','id'=>'flagEventId','class'=>'resize-input','style'=>'height:27px;', 'value'=>$flagEvent,'label'=>false));?>
													</span>
												</div>
												<?php echo $this->Form->hidden('patient_id',array('value'=>$patientId));?>
												<?php echo $this->Form->hidden('id',array('id'=>'familyid1','value'=>$id));?>
												<div style="float:left; font-size:13px;padding-left: 5px;">
													<span style="display:<?php echo $display;?>" id='eventTextSubmit'>
													</span>
												</div>
											<!--  </tr>
										</table>-->
										
									</td>
								</tr>
							</table>
							</div>
						</td>
						
						</tr>
					</table>
					<table border="0" class="table_form" cellpadding="0"
						cellspacing="2" style="padding: 0px;">
						<tr>
							<td class="tdClass" valign="top">
								<table border="0" class="table_form" cellpadding="0"
									cellspacing="2" style="padding: 0px;">
									<tr>
										<td style="font-size: 13px;"><b style="color: #1e7289;"></b> <?php //foreach($allergies_data_top as $key => $dataAll){?>
											<?php //if($key<count($dataAll)) 
		//	echo ucfirst($dataAll['NewCropAllergies']['name'].',');
		//else
		//	echo ucfirst($dataAll['NewCropAllergies']['name']);

		?> <?php //}?><span id="showAllergy"></span></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

					</div>

					<div class="clear"></div>

					<div id="loading-indicator" style="display: none">
						<?php echo $this->Html->image('/img/icons/loading-indicator.gif',array('alt'=>'Loading','title'=>'Loading'))?>
					</div> <!-- Alerts Of CDS -->
					<div style='text-align: center; padding-top: 225px;'>
						<?php /* foreach($clinicalArray as $keys=>$clinicalArrays){
					 if(!empty($clinicalArrays)){
							$displayAlerts='block';
						}else{
							$displayAlerts='none';
						} */?>
						<div style='text-align:center;display:<?php  //echo $displayAlerts;?>' >
							<table align="center">
								<tr>
									<td><?php 
									i/* f(!in_array($sendReminders[$keys],$clinicalArray)){
									echo $this->Html->image('icons/red.png');
									$color='red';
								}else{
									echo $this->Html->image('icons/green.png');
									$color='green';
								} */?>
									</td>

									<td><font color="<?php //echo $color;?>"><strong><?php //echo "Clinical Reminder:".$clinicalArrays;?>
										</strong> </font></td>
								</tr>
							</table>

						</div>
					</div> <?php //}?> <!-- EOD -->
					<div class="clr ht5"></div> <!--  myNoteId --> <?php //debug($_SESSION['myNoteId']);?>
					<div style="float: left; margin: 0 10px 0 0;">
						<?php if(!empty($diagnosisId)) {
							echo $this->Html->link(__('Initial Assessment'),
									array('controller'=>'Diagnoses','action' =>'initialAssessment',$patientId,$diagnosisId,$_SESSION['apptDoc']),
									array('escape' => false,'class'=>'blueBtn'));
						}else{
echo $this->Html->link(__('Initial Assessment'),
		array('controller'=>'Diagnoses','action' =>'initialAssessment',$patientId,'null',$_SESSION['apptDoc']),
		array('escape' => false,'class'=>'blueBtn'));
}
?>
					</div>
					<div style="float: left; margin: 0 10px 0 0;">
						<?php echo $this->Html->link(__('Preview Power Note'),'#', array('onclick'=>'previewPowerNote()','escape' => false,'class'=>'blueBtn'));?>
					</div>
					<div style="float: left">
						<?php //echo $this->Html->link(__('Smart Phrases'),'#', array('id'=>'smartphrases','escape' => false,'class'=>'blueBtn'));?>
					</div>
					<div class="clr ht5"></div>
					<div id="add-template-form" style="display: none; align: left;">
						<?php echo $this->Form->create('NoteTemplate',array('id'=>'doctortemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
						<table border="0" class="table_format" cellpadding="0"
							cellspacing="0" width="29%">
							<tr>
								<td style="text-align: center;"><?php echo __('Add Template Title');?>:</td>
								<td><?php 
								echo $this->Form->hidden('id');
								echo $this->Form->input('template_name',array('type'=>'text','rows'=>'3','cols'=>'4','id'=>'addTitle'));
								?>
								</td>
							</tr>

							<tr>
								<td colspan="2" align="right">
									<div style="float: right;">
										<?php echo $this->Html->link(__('Cancel'),"javascript:void(0)",array('id'=>'close-template-form','class'=>'grayBtn','style'=>'margin: 10px 0 0 !important;')); ?>
										<?php echo $this->Form->input(__('Submit'),array('type'=>'button','id'=>'submitTemplate','class'=>'grayBtn'))?>
									</div>

								</td>
							</tr>
						</table>

						<?php $this->Form->end();?>

					</div>
					<div id="search_template" style="padding-top:2px;margin:0px 3px;display:<?php echo $search_template ;?>">
						<table>
							<tr>
								<td>
									<table>
										<tr id="sHide">
											<td><?php echo $this->Form->input('',array('type'=>'text', 'style'=>'','lable','id'=>'search','placeholder'=>'Search Template'));
											?>
											</td>
											<td><?php 
								echo $this->Html->link('Search','javascript:void(0)',array('escape'=>false,'id'=>'searchBtn','title'=>'Search','alt'=>'Search','class'=>'blueBtn'));?>
											</td>
											<td>
												<table border="0" style="display: none" id="wheel">
													<tr>
														<td class="gradient_img" style="padding: 10px;">
															<table border="0">
																<tr>
																	<td class="black_white"
																		style="padding: 5px 10px 10px; font-size: 11px;">
																		<div class="bloc">
																			<?php echo $this->Form->input('language', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','options'=>$tName,'style'=>'margin:1px 0 0 10px;','multiple'=>'true','id' => 'language','autocomplete'=>'off')); ?>
																			<?php  // echo $this->Form->input('language', array('empty'=>__('Select'),'options'=>$languages,'id' => 'language','style'=>'width:230px')); ?>
																		</div>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
											<td><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',array('escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));
														echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'add-template','style'=>'padding-left:5px;cursor:pointer'));?>
											</td>
										</tr>
									</table>
								</td>
								<td>
									<table cellspacing="10">
										<tr id="templateTitleContainer">
											<!-- dynamic td place to show template Title  -->
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<div id="talltabs-blue">
						<ul>
							<?php if(empty($noteId)){
								$notAllowed='none';
							}else{
$notAllowed='block';

}?>
							<!--  <ul>
								<li id="hpi"><a> <span style="cursor: pointer; cursor: hand"
										id="hpi"><?php echo __('HPI')?> </span>&nbsp;&nbsp;
								</a></li>
							</ul>-->
							</ul>
							<ul style="float: right;">
								<li id="expand_id1"><a> <span
										style="cursor: pointer; cursor: hand" id="expand_id"
										onclick="expandCollapseAll('expand_id')">Expand All</span>&nbsp;&nbsp;
								</a>
								</li>
								<li id="collapse_id1"><a> <span
										style="cursor: pointer; cursor: hand" id="collapse_id"
										onclick="expandCollapseAll('collapse_id')">Collapse All</span>
								</a>
								</li>
							
					</ul></div></td></tr></table>
					</div>
					<div class="clear">&nbsp;</div> <?php 
					$lastColumn = '';
					echo'<div class="outerDiv">';
					foreach($columns as $key =>$column) {


	if(!empty($lastColumn) && ($lastColumn != trim($column['Widget']['column_id']))){

		echo '</div></div>';


		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="column" style="width:100%;">';
		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="">';//columnInternal
	}else if(empty($lastColumn)){

		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="column" style="width:100%">';
		echo '<div id="column'.$column['Widget']['column_id'].'" class="">';//columnInternal
	}

	$boxHtml =  '<div class="dragbox" id="item'.$column['Widget']['id'].'" >';
	$boxHtml .= '<h2><div style="display:inline" >'.$column['Widget']['title'].'</div><span style="padding-left:30px; font-size:10px">{{recordCount}}</span></h2>';
	if($column['Widget']['collapsed'] == '1'){
		$collapsedDiv = 'style="display:none;"';
	}else{
		$collapsedDiv = 'style="display:block;"';
	}
	$boxHtml .= '<div class="dragbox-content" '.$collapsedDiv.'>';

	switch (strtolower($column['Widget']['title'])) {
		case 'vitals':
			echo vitals($getVitals,$boxHtml,$patientId,$noteId,$appt);
			break;
		case 'chief complaints':
			echo chiefComplaints($getVitals,$boxHtml,$patientId,$noteId,$appt);
			break;
		case 'subjective':
			$subjectivelink =  $this->Html->image('icons/plus_6.png' , array('id'=>'ros','style'=>'padding-right:327px;',
			'title'=>'Review if System'));
			$Hpilink =  $this->Html->image('icons/plus_6.png' , array('id'=>'hpi','style'=>'padding-right:327px;',
			'title'=>'HPI'));
			echo subjective($getVitals,$boxHtml,$subjectivelink,$patientId,$noteId,$appt,$ccdata,$soap_in,$hpiMasterData,
							$templateTypeContent,$Hpi,$getPastProblems,$getElement,$ccdata,$Hpilink,$rosMasterData);
			break;
		case 'objective':
			$objectivelink =  $this->Html->image('icons/plus_6.png' , array('id'=>'soe'));
			$vitallink =  $this->Html->image('icons/plus_6.png' , array('id'=>'vitalLink'));
			echo objective($getVitals,$boxHtml,$objectivelink,$patientId,$noteId,$testOrdered,$resultRadiology,
			$appt,$vitallink,$getVitals1,$soap_in,$peMasterData,$physicalExamination);
			break;
		case 'assessment':
			$assessmentlink =  $this->Html->image('icons/plus_6.png' , array('id'=>'assessment1'));
			echo assessment($getVitals,$boxHtml,$patientId,$noteId,$appt,$assessmentlink,$soap_in);
			break;
		case 'documents':
			/* $documentLink = $this->Html->link($this->Html->image('icons/plus_6.png'),
			 array('controller'=>'PatientDocuments','action' => 'add',$patientId,'null','soap'),
			 array('escape' => false,'title'=>'Add Document')); */
			$documentLink=$this->Html->image('icons/plus_6.png');
			echo document($getPatientDocuments,$trarifName,$optDoctor,$boxHtml,$this->DateFormat,$documentLink,$diagnosisSurgeries,$patientId,$noteId);
			break;
		case 'plan':
			$orderlink =  $this->Html->image('icons/plus_6.png' , array('class'=>'orders'));
			echo plan($getVitals,$boxHtml,$orderlink,$patientId,$noteId,$appt,$soap_in,$getProblem);
			break;
		}

		$lastColumn = $column['Widget']['column_id'];
		$userId = $column['Widget']['user_id'];
		$screenApplicationName = $column['Widget']['application_screen_name'];
}?>


					<div style="float: left">
						<!--  <form action="'.Router::url("/").'Notes/soapSign" method=post>-->
						<?php echo $this->Form->create('Notes',array('action'=>'soapSign')); ?>
						<span id='lowerSubmit' style='display: block;'> <input type=hidden
							name=Note[sign_note] value='1'> <input type=hidden
							name=Note[patient_id] value='<?php echo $patientId;?>'><input
							type=hidden name=Note[id] id=signNoteId
							value='<?php echo $noteId;?>'> <input type=hidden name=Note[appt]
							value='<?php echo $_SESSION['apptDoc'];?>'> <?php if($_SESSION[role]!='Residents'){?>
							<input type="submit" value="Sign" class="blueBtn"
							id="soap_submit1" style='border-color: red;'> <?php }?> <?php echo $this->Html->link('Back',array('controller'=>'Appointments','action'=>'appointments_management'),array('name'=>'Back','value'=>'Back', 'class'=>"blueBtn"));?>
						</span>
					</div> <?php if($_SESSION[role]=='Residents'){ 
						if(!empty($getVitals['Note']['signed_by'])){
							$checked='checked';
							$disabled=true;
							}
							else{
							$checked='';
							$disabled=false;
						}?>
					<div style="float: left">
						<span style="padding-left: 5px;"><?php echo $this->Form->input('residentCheck',array('type'=>'checkbox','id'=>'residentCheck','checked'=>$checked,'disabled'=>$disabled,'label'=>false,'div'=>false));?><span
							width="215px"> Note completed by resident doctor</span> </span>
						<?php }?>
						<?php echo $this->Form->end();?>
					</div>
	
	</div>
</div>
<?php 
function subjective($getVitals,$boxHtml,$subjectivelink,$patientId,$noteId,$appt,$ccdata=null,
		$showTimeS,$hpiMasterData,$templateTypeContent,$Hpi,$getPastProblems,$getElement,$ccdata,$Hpilink,$rosMasterData){
$ageExp=explode(' ',$getElement['Person']['age']);
if(!empty($getPastProblems)){
$strBeforeHpi=$ageExp[0]." Year old ".$getElement['Person']['sex']." with past medical history of ".implode(',',$getPastProblems).
" here for ". $ccdata;
}
else{
$strBeforeHpi=$ageExp[0]." Year old ".$getElement['Person']['sex']." here for ". $ccdata;
}
if(!empty($templateTypeContent)){
			foreach($rosMasterData as  $dataRos =>$datakey) {
				if($datakey['Template']['template_category_id']==1){
				$selectedOptions= unserialize($templateTypeContent[$datakey['Template']['id']]);
				foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {
						$subCategory=$selectedOptions[$subkey['id']];
						if($subCategory =='1' )
						{
							$yesROS[$sub]=$subkey['sub_category'];
						}
						if($subCategory =='2' )
						{
							$no[]=$subkey['sub_category'];
						}
						//EOF if
					} //EOF inner foreach
					if(!empty($yesROS))
						$yesNewROS.=$datakey['Template']['category_name'].": ".implode(',',$yesROS).'.'."\n";
					unset($yesROS);
					}//EOF first if for template check
			}// EOF foreach
		}//EOF outer if
		if(!empty($yesNewROS))
			$ROSTextpositive=$yesNewROS;
		/* if(!empty($no))
			$ROSTextnegative="Historian denied ".implode(',',$no); */
		unset($yesROS);
		unset($no);
		$RosNew=$ROSTextpositive."\n".$ROSTextnegative;
		/* if(!empty($getVitals['Note']['ros'])){
			$RosNew=$RosNew." ".$getVitals['Note']['ros'];
		} */
		//-------------------------------------------------------------------------
		if(!empty($Hpi)){

			foreach($hpiMasterData as  $dataRos =>$datakey) {
				if($datakey['Template']['template_category_id']==3){
						$selectedOptions= unserialize($Hpi[$datakey['Template']['id']]);
						foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {
								$subCategory=$selectedOptions[$subkey['id']];
								if($subCategory =='1' )
								{
									$yes[$sub]=$subkey['sub_category'];
								}
								if($subCategory =='2' )
								{
									$no[$sub]=$subkey['sub_category'];
								}//EOF if

								}
								if($datakey['Template']['category_name']=='Location'){
									if(!empty($yes))
										$yesNew=ucfirst('Historian')." reported symptoms located in ".implode(',',$yes).'.';
								}
								if($datakey['Template']['category_name']=='Quality'){
									if(!empty($yes))
										$yesNew=ucfirst('Historian')."  describes the symptom as ".implode(',',$yes)." in nature.";
								}
								if($datakey['Template']['category_name']=='Severity & Pain Scale'){
									if(!empty($yes)){
										$servere1=array('Mild','Moderate','Severe');
										if(in_array($yes[0],$servere1) || in_array($yes[1],$servere1) || in_array($yes[2],$servere1))
											$yesNew="Severity is ".implode(',',$yes).".";
										else
											$yesNew="Rates the pain ".implode(',',$yes)."/10 at its worst.";
										}
								}
								if($datakey['Template']['category_name']=='Duration'){
									if(!empty($yes))
										$yesNew=ucfirst('It')." is since ".implode(',',$yes).".";
								}
								if($datakey['Template']['category_name']=='Timing'){
									if(!empty($yes))
										$yesNew=ucfirst('It')." is ".implode(',',$yes).".";
								}
								if($datakey['Template']['category_name']=='Context'){
									if(!empty($yes))
										$yesNew=ucfirst('It')." is ".implode(',',$yes)." in nature.";
								}
								if($datakey['Template']['category_name']=='Modifying Factors'){
									if(!empty($yes))
										$yesNew=ucfirst('It')." is ".implode(',',$yes).".";
								}
								if($datakey['Template']['category_name']=='Assoc Signs and Symptoms'){
									if(!empty($yes))
										$yesNew=ucfirst('It')." is associated with ".implode(',',$yes).".";
								}
								//-------------------------------------------------------------------------------------------------------
								if($datakey['Template']['category_name']=='Location'){
									if(!empty($no))
										$noNew="Denies symptoms in ".implode(',',$no).'.';
								}
								if($datakey['Template']['category_name']=='Quality'){
									if(!empty($no))
										$noNew="Its not of ".implode(',',$no)." nature.";
								}
								if($datakey['Template']['category_name']=='Severity & Pain Scale'){
									if(!empty($no))
										$noNew="Rates the pain ".implode(',',$no).".";
								}
								if($datakey['Template']['category_name']=='Duration'){
									if(!empty($no))
										$noNew="It is since ".implode(',',$no).".";
								}
								if($datakey['Template']['category_name']=='Timing'){
									if(!empty($no))
										$noNew="It is not".implode(',',$no).".";
								}
								if($datakey['Template']['category_name']=='Context'){
									if(!empty($no))
										$noNew="It is not".implode(',',$no)." in nature.";
								}
								if($datakey['Template']['category_name']=='Modifying Factors'){
									if(!empty($no))
										$noNew="It is not".implode(',',$no).".";
								}
								if($datakey['Template']['category_name']=='Assoc Signs and Symptoms'){
									if(!empty($no))
										$noNew="It is not associated with ".implode(',',$no).".";
								}
								//---------------------------------------------------------------------------------------------------------
								//debug($yesNew);//EOF inner foreach
						}//EOF first if for template check
						if(!empty($yesNew))
							$newYes.=$yesNew."\n";
						$yesNew='';
						unset($yes);
						//	debug($noNew);
						if(!empty($noNew))
							$newNo.=$noNew."\n";
						$noNew='';
						unset($no);
						//debug($newYes);

					}// EOF foreach
					if(!empty($newYes))
						//$hpiPos="Historian reported ".implode(',',$yes);
						$hpiPos=$newYes;
					if(!empty($noNew))
						
					$hpiNeg= $newNo;
					unset($yes);
					unset($no);
					$HpiNew=$strBeforeHpi.". ".$hpiPos/*." ".$hpiNeg*/; // $hpiNeg commented to remove -ve hpi sentence. - gaurav

				}
				//EOF outer if
if(empty($getVitals["Note"]["subject"])){
$getVitals["Note"]["subject"]=$ccdata;
}
$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
$subjectiveHtml= $boxHtml;
$subjectiveHtml.='</form><form action="'.Router::url("/").'Notes/soapNote" method=post id="subject">
		<table  width="100%" class="formFull formFullBorder" id="subjectTable">
		<tr><td colspan="2"><div id="subjectiveDisplay"></div></td></tr>
		<tr><td><b>History of Presenting Illness</b></td>
		<td><a href="#" id="ros1">'./*$subjectivelink.*/'&nbsp;&nbsp;</a></td><td width="10%"><a href="#" onclick="callDragon(\'subject\')"
			style="text-align: left; float:right;"><font color="#000">Use speech
			recognition</font> </a></td></tr>
			<tr><td>'.$HpiNew.'</td>
			</tr>
			<tr><td class="td_add"><textarea name=Note[subject] id="subShow" class="spNoteTextArea">'.$getVitals["Note"]["subject"].'</textarea>'.$Hpilink.'</td></tr>
			<tr><td colspan="2"><div id="rosDisplay"></div></td></tr>
			<tr><td><b>Review of System</b></td>
			<td><a href="#" id="ros2">'./*$subjectivelink.*/'&nbsp;&nbsp;</a></td><td width="10%"><a href="#" onclick="callDragon(\'subjectRos\')"
			style="text-align: left; float:right;"><font color="#000">Use speech
			recognition</font> </a></td></tr>
			<tr><td>'.$RosNew.'</td>
			</tr>
			<tr><td class="td_add"><textarea name=Note[ros] id="subShowRos" class="spNoteTextArea">'.$getVitals['Note']['ros'].'</textarea>'.$subjectivelink.'</td></tr>';

$subjectiveHtml .='<tr><td class="td_add" clospan="4" style="align:right">
			<input type=button name=Update value=Update class="blueBtn" onclick="saveSoap(\'subject\')" >';
$subjectiveHtml .='</td><input type=hidden name=Note[appt] value='.$appt.'><input type=hidden name=Note[patient_id] value='.$patientId.'>
			<input type=hidden  id="subjectNoteId" name=Note[id] value='.$noteId.'>
			<input type=hidden  id="soap_outSubjective" name=Note[soap_out] value='.$showTimeS.'>';
$subjectiveHtml.='</table></form>';
//******************************Medication Details****************************************
$subjectiveHtml.='<table  width="100%" class="formFull formFullBorder">
		<tr><td width="100%"></td></tr></table>';
$subjectiveHtml.='</div></div>';
return $subjectiveHtml ;
}
function objective($getVitals,$boxHtml,$objectivelink,$patientId,$noteId,$testOrdered,
						$resultRadiology,$appt,$vitallink,$getVitals1,$showTimeO,$peMasterData,$physicalExamination){
if(!empty($physicalExamination)){
	foreach($peMasterData as  $dataRos =>$datakey) {
		if($datakey['Template']['template_category_id']==2){
				$selectedOptions= unserialize($physicalExamination[$datakey['Template']['id']]);
				foreach($datakey['TemplateSubCategories'] as $sub =>$subkey) {
						$subCategory=$selectedOptions[$subkey['id']];
						if($subCategory =='1' )
						{
							$yesPE[$sub]=$subkey['sub_category'];
						}
						if($subCategory =='2' )
						{
							$no[]=$subkey['sub_category'];
						}
						//EOF if
					} //EOF inner foreach
					if(!empty($yesPE))
						$yesNewPE.=$datakey['Template']['category_name'].": ".implode(',',$yesPE).'.'."\n";
					unset($yesPE);
				}//EOF first if for template check
			}// EOF foreach
			if(!empty($yesNewPE))
				$peNewDataPostive=$yesNewPE;
			if(!empty($no))
				$peNewDataNegative= "Historian denied ".implode(',',$no);
			unset($yes);
			unset($no);
			$peNewData=$peNewDataPostive;

		} //EOF outer if
		if($getVitals1['Note']['bp']=='/'){
	$setBp="";
}
else{
	$setBp=$getVitals1['Note']['bp'];
}
$date=explode(' ',$getVitals['Note']['note_date']);
if(!empty($date[0])){
	$date1=explode('-',$date[0]);
	$nDate=$date1[1]."/".$date1[2]."/".$date1[0];
}else{
	$nDate="";
}

$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
$objHtml = $boxHtml;


$objHtml.='<form action="'.Router::url("/").'Notes/soapNote" method=post id="objective">
								<div id="objectiveTable">
								<table  width="100%" class="formFull formFullBorder" >
								<tr>

								<td><a href="#" id="soe1">'.$objectivelink.'&nbsp;&nbsp;<b>Physical Examination</b></a></td><td colspan=3 width="10%"><a href="#" onclick="callDragon(\'objective\')"
									style="text-align: left; float:right;"><font color="#000">Use speech
									recognition</font> </a></td>
									</tr>
									<tr>
									<td <td colspan="2"><div id="objectiveDisplay"></div></td>
									</tr>
									<tr><td>'.$peNewData.'</td></tr>
									<tr>
									<td class="td_add"><textarea name=Note[object] id="objectShow" class="spNoteTextArea">'.$getVitals['Note']['object'].'</textarea>

									</td>
									</tr></table>';
//$objHtml .=	'<table  width="200px" border="1"><tr><td>kjdshhsdfk</td></tr>';

$objHtml .=	'<table  style="width:100%;" class="formFull formFullBorder">
								<tr bgcolor="#d2ebf2"><td colspan=4 style="text-align:left;padding: 5px 0 5px 10px;" >
								<strong>Vitals Information'.$vitallink.'</strong></td></tr></table>';
$objHtml .=	'<table width="100%" class="formFull formFullBorder">
						<tr class="trShow">
						<td style="padding: 5px 0 5px 10px;">Temperature</td>
						<td style="padding: 5px 0 5px 10px;">Blood Pressure</td>
						<td style="padding: 5px 0 5px 10px;">Pluse Rate</td>
						<td style="padding: 5px 0 5px 10px;">Respiratory Rate</td>
						</tr>';
//$heartRate=unserialize($getVitals1["Note"]["pr"]);
$objHtml .='<tr class="">
										<td style="padding: 5px 0 5px 10px;">'.$getVitals1["Note"]["temp"].'</td>
											<td style="padding: 5px 0 5px 10px;">'.$getVitals1["Note"]["bp"].'</td>
												<td style="padding: 5px 0 5px 10px;">'.$getVitals1["Note"]["pr"].'</td>
											<td style="padding: 5px 0 5px 10px;">'.$getVitals1["Note"]["rr"].'</td>
													</tr>
													<tr><td class="td_add" clospan="4" style="align:right">
													<input type=button name=Submit value=Update class="blueBtn" onclick="saveSoap(\'objective\')" >
													</td>
													<input type=hidden name=Note[appt] value='.$appt.'><input type=hidden name=Note[patient_id] value='.$patientId.'>
												<input type=hidden name=Note[id] id="objectiveNoteId" value='.$noteId.'>
		<input type=hidden  id="soap_outOjective" name=Note[soap_out] value='.$showTimeO.'></tr> </table></div></form>';
$objHtml.='</div></div>';
return $objHtml ;
}
function assessment($getVitals,$boxHtml,$patientId,$noteId,$appt,$assessmentlink,$showTimeA){
					$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
					$assessmentHtml = $boxHtml;
					$assessmentHtml.='<div id="assessmentTable"><table  width="100%" class="formFull formFullBorder" id="assessmentTable"><tr><td>
													<a href="javascript:icdwin()" disabled='.$disabled.'>'.$assessmentlink.'Add Diagnosis</a><br/><td>';
					$assessmentHtml.='<td><a href="#" onclick="callDragon(\'assessment\')"
													style="text-align: left;float:right;"><font color="#000">Use speech
													recognition</font> </a></td>

													</tr></table>';

					$assessmentHtml.='<form action="'.Router::url("/").'Notes/soapNote" method=post id="assessment"><table  width="100%" class="formFull formFullBorder">
									<tr>
									<td id="getAssessment" width="100%"></td>
									</tr>
									<div id="assessmentDisplay"></div>
									<tr><input type=hidden name=Note[appt] value='.$appt.'><td class="td_add"><textarea name=Note[assis] id="AssesShow">'.$getVitals["Note"]["assis"].'</textarea></td></tr>';
					$assessmentHtml .='<tr><td class="td_add" clospan="4" style="align:right"><input type=button name=Submit value=Update  class="blueBtn" onclick="saveSoap(\'assessment\')"  >
															</td>
															<input type=hidden name=Note[patient_id] value='.$patientId.'>
														<input type=hidden name=Note[id] id="assessmentNoteId" value='.$noteId.'>
														<input type=hidden  id="soap_outAssessment" name=Note[soap_out] value='.$showTimeA.'></tr></table></div></form>';
					$assessmentHtml.='</div></div>';

					return $assessmentHtml ;
}
function plan($getVitals,$boxHtml,$orderlink,$patientId,$noteId,$showTimeP,$pass,$getProblem){

					$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
					$planHtml = $boxHtml;
					$planHtml.='<form action="'.Router::url("/").'Notes/soapNote" method=post id="plan">
								<div id="planTable">
								<table  width="100%" class="formFull formFullBorder" >
								<tr>
								<td colspan=4><a href="#" onclick="callDragon(\'plan\')"
								style="text-align: left;float:right;"><font color="#000">Use speech
								recognition</font> </a></td>
								</tr>
								<tr>
								<td width="20%"><a href="javascript:addMedication('.$patientId.')")>'.$orderlink.'</a>&nbsp;&nbsp;Medication</td>
												<td width="20%"><a href="javascript:addAllergy('.$patientId.')")>'.$orderlink.'</a>&nbsp;&nbsp;Allergy</td>
												<!--<td colspan="2"><span id="send">'.$orderlink.'</span>Send Referral</td>-->
												<td colspan=2><a href="javascript:sendReferral();")>'.$orderlink.'</a>&nbsp;&nbsp;Send Referral</td></tr>';
					if(!empty($getProblem)){
					$planHtml.='<tr><td colspan="3"><label style="padding:0px !important;">Diagnosis Name</label><select id="problemLabRad"><option value="0">Please select</option>';
					foreach($getProblem as $key=>$dropDownData){
						$key++;
						$planHtmlHidden.='<span id="hiddenspanDiv"></span>';
						$planHtml.='<option  value='.$key.'>'.$dropDownData['NoteDiagnosis']['diagnoses_name'].'</option>';
						
					}
					$planHtml.='</select></td></tr>';
					}
					$planHtml.='<tr><td width="20%"><a href="javascript:addLabOrder('.$patientId.')")>'.$orderlink.'</a>&nbsp;&nbsp;Lab Orders</td>';

					$planHtml.='<td><a href="javascript:addRadOrder('.$patientId.')")>'.$orderlink.'</a>&nbsp;&nbsp;Radiology Orders</td>';
					$planHtml.='<td><a href="javascript:addProcedurePerform('.$patientId.')")>'.$orderlink.'</a>&nbsp;&nbsp;Procedure Performed</td></tr></table>';
					//******************************Lab Save Code***********************************************************
					$planHtml.='<table  width="100%" class="formFull formFullBorder"></table>';
					//********************************************************************************************************
					//Explode for Diagnosis Lab

					$DiagnosisLabPlan=$getVitals['Note']['plan'];
					
				    $DiagnosisLabPlanexplode=explode('$',$DiagnosisLabPlan);
				   
					$currentExplode=explode(':::',$DiagnosisLabPlanexplode[0]);
					
					if(count($DiagnosisLabPlanexplode)=='1'){
						$LabDiagnosisFirst['0']=$DiagnosisLabPlanexplode['sample'];
						
						$cntproblem=0;
						// this loop is just to create the Span and put the content
						foreach($getProblem as $dataProblem){
							$cntproblem++;
							$LabDiagnosis=explode(':::',$DiagnosisLabPlanexplode[$cntproblem]);
							if(empty($LabDiagnosis[0])){
								$LabDiagnosisFirst=$LabDiagnosis;
							}else{
								$LabDiagnosisFirst=$LabDiagnosis;
							}
							$planHtml.='<span id="'.$currentExplode['0'].'" class="mainTextboxData"></span>';
							$planHtml.='<span id="'.$LabDiagnosis['0'].'" class="'.$cntproblem.'"></span>';
						}
							
					}else{



                       $cntproblem=0;
                      // debug($DiagnosisLabPlanexplode)
						foreach($getProblem as $dataProblem){
                        $cntproblem++;
						$LabDiagnosis=explode(':::',$DiagnosisLabPlanexplode[$cntproblem]);
						if(empty($LabDiagnosis[0])){
							$LabDiagnosisFirst=$LabDiagnosis;
						}else{
							$LabDiagnosisFirst=$LabDiagnosis;
						}
						$planHtml.='<span id="'.$currentExplode['0'].'" class="mainTextboxData"></span>';
						$planHtml.='<span id="'.$LabDiagnosis['0'].'" class="'.$cntproblem.'"></span>';
					}
					}
					//EOD
					$planHtml.='<table  width="100%" class="formFull formFullBorder">
								<tr><td><div id="planDisplay"></td></tr></div>
								<tr><td class="td_add"><textarea name=Note[plan] id="planShow">'.$currentExplode['0'].'</textarea></td></tr>
											<tr><td class="td_add"><input type="checkbox" name="Note[refer_to_hospital]" value="1">&nbsp;&nbsp;Patient to be referred to hospital.</td></tr> ';
					$planHtml .='<tr><td class="td_add" clospan="4" style="align:right"><input type=button id="planBtn" name=Submit value=Update class="blueBtn" onclick="saveSoap(\'plan\')" ></td>
											<input type=hidden name=Note[appt] value='.$appt.'><input type=hidden name=Note[patient_id] value='.$patientId.'>
							<input type=hidden name=Note[id]  id="planNoteId" value='.$noteId.'>
									<input type=hidden name=Note[oneOneDiagosis]  id="oneOneDiagosis" value="">
									<input type=hidden  id="soap_outPlan" name=Note[soap_out] value='.$showTimeP.'></tr></table></div></form>';
					$planHtml.='<div id="loadLab"></div>';
					$planHtml.='<div id="loadRad"></div>';
					$planHtml.='<div id="MedicationData"></div>';
					$planHtml.='</div></div>';

					return $planHtml ;

}


function document($getPatientDocuments,$trarifName,$optDoctor,$boxHtml,$dateFormate,$documentLink,$diagnosisSurgeries,$patientId,$noteId){
	$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
	$docHtml = $boxHtml;
	/*
	 *
	$documentLink = $this->Html->link($this->Html->image('icons/plus_6.png'),
			array('controller'=>'PatientDocuments','action' => 'add',$patientId,'null','soap'),
			array('escape' => false,'title'=>'Add Document'));
	*/
	$docHtml.='<table  width="100%"> <tr><td class="td_add tdLabel" style="background:#8A9C9C;height:20px;padding-top:0px!important;">
							<a href="javascript:void(0)" onclick="javascript:callDoc('.$patientId.')">'.$documentLink.'</a></td></tr></table>';

	//===========****
	if(!empty($getPatientDocuments)){
		$docHtml.= '<table cellpadding="0" cellspacing="0" width="100%">
									<tr style="background-color:grey;">
									<td style="height:20px;width:33%;">Link / Document</td>
									<td  style="height:20px;width:50%;">Provider</td>
									<td   align="center" style="height:20px;width:33%;">Date</td>
									</tr>';

		foreach($getPatientDocuments as $getDocuments){

			$toolTip = 'Document : '.$getDocuments['PatientDocument']['link'].'
												Procedure Date : '.$dateFormate->formatDate2Local($getDocuments['PatientDocument']['date'],Configure::read('date_format'),false).'
												Provider : '.$getDocuments['User']['first_name'].' '.$getDocuments['User']['last_name'].'
												Comment : '.$getDocuments['PatientDocument']['comment'].'';


			$docHtml .='<tr class="tooltip light" title="'.$toolTip.'">';
			if(!empty($getDocuments['PatientDocument']['link'])){
				$docHtml .='<td><a target="_blank" href="'.$getDocuments['PatientDocument']['link'].'">'.$getDocuments['PatientDocument']['link'].'</a></td>';
			}
			else if(!empty($getDocuments['PatientDocument']['filename'])){
				$image=  FULL_BASE_URL.Router::url("/")."uploads/user_images/".$getDocuments['PatientDocument']['filename'];
				$docHtml .='<td><a  target="_blank" href="'.$image.'">'.$getDocuments['PatientDocument']['filename'].'</a></td>';
			}
			else{
				$docHtml .='<td> &nbps; </td>';
			}

			$docHtml .='<td>'.$getDocuments['User']['first_name'].' '.$getDocuments['User']['last_name'].'</td>
															<td align="center">'.$dateFormate->formatDate2Local($getDocuments['PatientDocument']['date'],Configure::read('date_format'),false).'</td>
																			</tr>';
		}
		$docHtml .='	</table>';
	}


	//=========***
	$docHtml.='</div></div>';
	return $docHtml;
}
?>

<div class="clear"></div>
<!-- </div> -->
<div class="clear"></div>

<div>
	<input type="hidden" name="user_id" id="user_id"
		value="<?php echo $this->Session->read('userid'); ?>"> <input
		type="hidden" name="screen_application_name"
		id="screen_application_name"
		value="<?php echo $screenApplicationName; ?>">
</div>
</div>
<script type="text/javascript">

		$('#soap_submit1').click(function(){
			var disableReconcile=document.getElementById("reconcilecheck").disabled;
			var disableMed=document.getElementById("nomedcheck").disabled;
		var reconForMed=$('#reconcilecheck:checked').length;
		var noForMed=$('#nomedcheck:checked').length;
		if(reconForMed==0 && disableReconcile!=true){
			//$('#flashMessage').show();
			//$(window).scrollTop($('#flashMessage').offset().top);
			//$('#flashMessage').html('Please Reconcile Medication.');
			return false;
		}
		if(noForMed==0 && disableMed!=true){
			$('#flashMessage').show();
			$(window).scrollTop($('#flashMessage').offset().top);
			//$('#flashMessage').html('Please Check No known active medication.');
			return false;
		}
		
	$('#noteSign').val('1');
	if(confirm("This will permanently finalize this encounter as a legal document.You will not be able to make edits after signing")){
		return true;
	}else{
		return false;
	}
});
function expandCollapseAll(id){
	if(id=='collapse_id'){//dragbox-content
		$(".dragbox-content").css('display','none');
		$('#expand_id').removeClass('active');
		$('#collapse_id').addClass('active');
	}else{
		$(".dragbox-content").css('display','block');
		$('#expand_id').addClass('active');
		$('#collapse_id').removeClass('active');
	}

}
$(function(){
	$('.dragbox')
	.each(function(){
		$(this).hover(function(){
			$(this).find('h2').addClass('collapse');
		}, function(){
			$(this).find('h2').removeClass('collapse');
		})
		.find('h2').hover(function(){
			$(this).find('.configure').css('visibility', 'visible');
		}, function(){
			$(this).find('.configure').css('visibility', 'hidden');
		})
		.click(function(){
			$(this).siblings('.dragbox-content').toggle();
			//Save state on change of collapse state of panel
			updateWidgetData();
		})
		.end()
		.find('.configure').css('visibility', 'hidden');
	});

	$('.dragbox_inner')
	.each(function(){
		$(this).hover(function(){
			$(this).find('h2').addClass('collapse');
		}, function(){
			$(this).find('h2').removeClass('collapse');
		})
		.find('h2').hover(function(){
			$(this).find('.configure').css('visibility', 'visible');
		}, function(){
			$(this).find('.configure').css('visibility', 'hidden');
		})
		.click(function(){
			$(this).siblings('.dragbox-content_inner').toggle();
			//Save state on change of collapse state of panel
			updateWidgetData();
		})
		.end()
		.find('.configure').css('visibility', 'hidden');
	});
	$('.columnInternal').sortable({
		connectWith: '.columnInternal',
		handle: 'h2',
		cursor: 'move',
		placeholder: 'placeholder',
		forcePlaceholderSize: true,
		opacity: 0.4,
		start: function(event, ui){
			//Firefox, Safari/Chrome fire click event after drag is complete, fix for that
			//if($.browser.mozilla || $.browser.safari)
			$(ui.item).find('.dragbox-content').toggle();
		},
		stop: function(event, ui){
			ui.item.css({
				'top':'0','left':'0'}); //Opera fix
				//if(!$.browser.mozilla && !$.browser.safari)
				updateWidgetData();
		}
	})
	.disableSelection();
});

	function updateWidgetData(){
		var items=[];
		$('.columnInternal').each(function(){
			var columnId=$(this).attr('id');
			$('.dragbox', this).each(function(i){
				var collapsed=0;
				if($(this).find('.dragbox-content').css('display')=="none")
					collapsed=1;
				//Create Item object for current panel
				var item={
					id: $(this).attr('id'),
					collapsed: collapsed,
					order : i,
					column: columnId,
					title: $('h2 div',this).html(),
					user_id:$('#user_id').val(),
					application_screen_name:$('#screen_application_name').val(),
					section:"<?php echo $section ;?>"
				};
				//Push item object into items array
				items.push(item);
			});
		});
		//Assign items array to sortorder JSON variable
		var sortorder={
			items: items };
			//Pass sortorder variable to server using ajax to save state
			//var ajaxUrl = "<?php //echo $this->Html->url(array("controller" => 'PatientsTrackReports', "action" => "saveWidget","admin" => false)); ?>";
		/*	$.post(ajaxUrl, 'data='+JSON.stringify(sortorder), function(response){
				if(response=="success")
					$("#console").html('<div class="success">Saved</div>').hide().fadeIn(1000);
				setTimeout(function(){
					$('#console').fadeOut(1000);
				}, 2000);
			});*/

				//ROS

				/*  function reviewOfSystems(){
				 alert('hi');
		  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "reviewOfSystem","admin" => false)); ?>";
				$.ajax({
						type: 'POST',
						url: ajaxUrl,
						//data: formData,
						dataType: 'html',
						success: function(data){
			   alert(data);
						},
						});
				 
				return false;
				}*/

				//EOF ROS
	}
	//*******************ROS***********************************
	$('#ros,#ros1').click(function(){
		if('<?php echo $noteId?>'==''){	
			var noteID=	$('#subjectNoteId').val();
		}else{
			var noteID=	'<?php echo $noteId?>';
		}
		window.location.href="<?php echo $this->Html->url(array("controller" => "Notes", "action" => "reviewOfSystem")); ?>"
		+"/"+'<?php echo $patientId?>'+'/'+noteID;

	});
//***************************************SOE******************************
	$('#soe,#soe1').click(function(){
		if('<?php echo $noteId?>'==''){	
			var noteID=	$('#subjectNoteId').val();
		}else{
			var noteID=	'<?php echo $noteId?>';
		}
		window.location.href="<?php echo $this->Html->url(array("controller" => "Notes", "action" => "systemicExamination")); ?>"
		+"/"+'<?php echo $patientId?>'+'/'+noteID;
		});
	//***************************************Vital******************************
	$('#vitalLink').click(function(){
		insertStatusForApp();
		if('<?php echo $noteId?>'==''){	
			var noteID=	$('#subjectNoteId').val();
		}else{
			var noteID=	'<?php echo $noteId?>';
		}
		window.location.href="<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "addVital")); ?>"
		+"/"+'<?php echo $patientId?>'+'/'+'null/'+ '<?php echo $_SESSION["apptDoc"] ?>?form=soap&noteId='+noteID;
		});
	function insertStatusForApp(){
		 var ajaxUrlVitals = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "setAppStatus","admin" => false)); ?>";
		  $.ajax({
	        	beforeSend : function() {
	        		//loading();
	        	},
	        	type: 'POST',
	        	url: ajaxUrlVitals,
	        	dataType: 'html',
	        	success: function(data){
		        	},
		  });
		
	}
//*******************HPI***********************************
	$('#hpi').click(function(){
		if('<?php echo $noteId?>'==''){	
			var noteID=	$.trim($('#subjectNoteId').val());
		}else{
			var noteID=	'<?php echo trim($noteId);?>';
		}
		window.location.href="<?php echo $this->Html->url(array("controller" => "PatientForms", "action" => "hpiCall")); ?>"+'/'+'<?php echo $patientId?>'+'/'+noteID;
		});
	</script>
<script type="text/javascript">
	function numericFilter(txb) {
  	   txb.value = txb.value.replace(/[^\0-9]/ig, "");
  	}

  	
	 function icdwin() {
		 var patientId='<?php echo $patientId?>';
		 var myNoteId= $('#subjectNoteId').val(); 
		 if('<?php echo $noteId ?>'=='' && myNoteId==''){
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "checkNoteIdForDiagnosis","admin" => false)); ?>";
			  $.ajax({
		        	beforeSend : function() {
		        		//loading();
		        	},
		        	type: 'POST',
		        	url: ajaxUrl+"/"+'<?php echo $patientId?>',
		        	//data: formData,
		        	dataType: 'html',
		        	success: function(data){
			        	var noteid=parseInt($.trim(data));
			        	 $('#familyid').val(data);
						  $('#ccid').val(data); 
						  $('#subjectNoteId').val(data); 
						  $('#assessmentNoteId').val(data); 
						  $('#objectiveNoteId').val(data); 
						  $('#planNoteId').val(data); 
						  $('#signNoteId').val(data);
						  note_id  = "<?php echo $noteId ?>" ;
						  if(note_id!='')
							window.location.href =  "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>"+'/'+ patientId+'/'+'0'+'/'+note_id ;
							else
								window.location.href =  "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>"+'/'+ patientId+'/'+'0'+'/'+noteid ;
		        },
				});
		 }
		 else{
			 if('<?php echo $noteId ?>'==''){
			 note_id  =$.trim(myNoteId);
			 }else{
				 note_id  = '<?php echo $noteId ?>';
				 note_id=$.trim(note_id);
			 }
					window.location.href =  "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>"+'/'+ patientId+'/'+'0'+'/'+note_id ;
					
			
		}
	 }
	
		function addMedication(patientId){
			 note_id  = "<?php echo $noteId ?>" ;
			 if(note_id==''){
				 note_id=$('#subjectNoteId').val(); 
			 }	
			
			 if(note_id==""){
				 var ajaxUrl1 = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "checkNoteIdForDiagnosis","admin" => false)); ?>";
				  $.ajax({
			        	beforeSend : function() {
			        		//loading();
			        	},
			        	type: 'POST',
			        	url: ajaxUrl1+"/"+patientId,
			        	dataType: 'html',
			        	success: function(data){
				        	var note_id1=$.trim(data);
				        	window.location.href =  "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addMedication")); ?>"+'/'+ patientId+'/'+null+'/'+null+'/'+null+'/'+note_id1 ;
				        	},
				  });
			 }else{
				 window.location.href =  "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addMedication")); ?>"+'/'+ patientId+'/'+null+'/'+null+'/'+null+'/'+note_id ;
			 }

		}
		function addAllergy(patientId,al_id,flag){
			 note_id  = "<?php echo $noteId ?>" ;
			 if(note_id==''){
				 note_id=$('#subjectNoteId').val(); 
			 }	
			
			 if(note_id==""){
				 var ajaxUrl1 = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "checkNoteIdForDiagnosis","admin" => false)); ?>";
				  $.ajax({
			        	beforeSend : function() {
			        		//loading();
			        	},
			        	type: 'POST',
			        	url: ajaxUrl1+"/"+patientId,
			        	dataType: 'html',
			        	success: function(data){
			        		var noteid=parseInt($.trim(data));
				        	 $('#familyid').val(noteid);
							  $('#ccid').val(noteid); 
							  $('#subjectNoteId').val(noteid); 
							  $('#assessmentNoteId').val(noteid); 
							  $('#objectiveNoteId').val(noteid); 
							  $('#planNoteId').val(noteid); 
							  $('#signNoteId').val(noteid);
				        	},
				  });
			 }
			$.fancybox({
				'width' : '100%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'onClosed':function(){
					getmedication();
					getAllergy();
				},
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "allallergies")); ?>"+"/"+patientId
				+ '/' + al_id + '/' + 'null'+'/'+'?personId=<?php echo $getElement['Patient']['person_id']?>&allergyAbsent='+flag+'&controllerFlag=Notes',

			});
		}
		//$('#TreatmentAdvised').click(function(){
		$( document ).ready(function(){
			if('<?php echo $noteId?>'=='' || $('#subjectNoteId').val()==''){
				//$('#residentCheck').disabled=true;
				$('#residentCheck').attr('disabled',true);
			}
			var location='<?php echo $getVitals['Note']['location'];?>'
			var pain='<?php echo $getVitals['Note']['pain'];?>'
			$('#locations').val(location);
			$('#pain').val(pain);
			getmedication();
			
			//getLAbRadEkg();
			});

		function getmedication() {
			var noteId='<?php echo $noteId?>';
			if(noteId==''){
				noteId= $('#subjectNoteId').val(); 
			}
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getMedication",$patientId,"admin" => false)); ?>"
			 +"/"+noteId+"/"+'?personId=<?php echo $getElement['Patient']['person_id']?>';
			 $.ajax({
		        	beforeSend : function() {
		        		$("#TreatmentAdvised").html("<table><tr><td>Loading Medication Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
		        	},
		        	type: 'POST',
		        	url: ajaxUrl,
		        	//data: formData,
		        	dataType: 'html',
		        	success: function(data){
		        	$("#TreatmentAdvised").html('TreatmentAdvised');
		        	if(data!=''){
		       			 $('#MedicationData').html(data);
		        	}
		        	getproblem();
					
		        },
				});
		}
		function getAllergy() {
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getAllergy",$patientId,"admin" => false)); ?>"+'?personId=<?php echo $getElement['Patient']['person_id']?>';;
			 $.ajax({
		        	beforeSend : function() {
		        		
		        	},
		        	type: 'POST',
		        	url: ajaxUrl,
		        	//data: formData,
		        	dataType: 'html',
		        	success: function(data){
		        	if(data!=''){
		       			 $('#showAllergy').html(data);
		        	}
		        	getLab();
					
		        },
				});
		}
		function getproblem() {
			var patientId='<?php echo $patientId?>';
			var personID='<?php echo $getElement['Patient']['person_id']?>';
				var noteId='<?php echo $noteId?>';
				if(noteId==''){
					noteId= $('#subjectNoteId').val(); 
				}
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getDiagnosis","admin" => false)); ?>";
			 $.ajax({
		        	beforeSend : function() {
		        		$("#Assessment").html("<table><tr><td>Loading Assessment Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
		        	},
		        	type: 'POST',
		        	url: ajaxUrl+'/'+patientId+'/'+noteId+'/'+'?personId=<?php echo $getElement['Patient']['person_id']?>',
		        	//data: formData,
		        	dataType: 'html',
		        	success: function(data){
		        	$("#Assessment").html('Assessment');
		        	if(data!=''){
		       			 $('#getAssessment').html(data);
		        	}
		        	getAllergy();
					
		        },
				});
		}
		function getLab() {
			var noteId='<?php echo $noteId?>';
			if(noteId==''){
				noteId= $('#subjectNoteId').val(); 
			}
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getLab",$patientId,"admin" => false)); ?>"+'/'+noteId;
			 $.ajax({
		        	beforeSend : function() {
		        		//$("#l").html("<table><tr><td>Loading Assessment Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
		        	},
		        	type: 'POST',
		        	url: ajaxUrl,
		        	//data: formData,
		        	dataType: 'html',
		        	success: function(data){
		        	if(data!=''){
		       			 $('#loadLab').html(data);
		        	}
		        	getRad();
		        },
				});
		}
		function getRad() {
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "getRad",$patientId,"admin" => false)); ?>";
			 $.ajax({
		        	beforeSend : function() {
		        		//$("#l").html("<table><tr><td>Loading Assessment Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
		        	},
		        	type: 'POST',
		        	url: ajaxUrl,
		        	//data: formData,
		        	dataType: 'html',
		        	success: function(data){
		        	if(data!=''){
		       			 $('#loadRad').html(data);
		        	}
		        },
				});
		}
	/*	function getLAbRadEkg(){
			var ajaxUrl = "<?php //echo $this->Html->url(array("controller" => 'diagnoses', "action" => "investigation",$patientId) ,array('escape'=>false)); ?>";

			$.ajax({
		 			  type: "POST",
		 			  url: ajaxUrl,
		 			  beforeSend : function() {
		 			  	$("#Investigation").html("<table><tr><td>Loading Investigation Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
		 			  },
		 			  complete: function() {
								$("#temp-busy-indicator1").hide();
							},
					  success: function(data){
						  $("#Investigation").html('Investigation');
						  $("#CPOE").html(data);
						  $("#CPOE").css("height","auto");
					  }
					});
		}*/
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
		   //***************************************hide show add part******************************************************
		   $('#add-template').click(function(){
			   $('#add-template-form').show();
			   });
			   $('#close-template-form').click(function(){
			   $('#add-template-form').hide();
			   $('#sHide').show();
			   });
			   //*****************************************EOF******************************************************************
			   //*********************Add new title in noteTemplate Table*********************************************************
			   $('#submitTemplate').click(function(){
				   $('#addTitle').focus();
				 var checkPatch=$("*:focus").attr('id');
				  if(checkPatch=='addTitle'){
			  var title=$('#addTitle').val();
			   if(title==''){
				   alert('Please enter value to save');
				   return false;
			   }
			   else{
				   $('#sHide').show();
			   }
			   var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "addTempleteTitle","admin" => false)); ?>";
			   $.ajax({
			 			  type: "POST",
			 			  url: ajaxUrl+"/"+title,
			 			  context: document.body,
			 			  beforeSend:function(){
			 			  	// this is where we append a loading image
			 			  	$('#busy-indicator').show('fast');
			 			  	 
			 			  },
			 			  success: function(data){
			 				 $("#language").append( new Option(data , data) );
							  $('#busy-indicator').hide('slow');
							  $('#addTitle').val("");
							  $('#add-template-form').hide();
								$('#flashMessage').show();
								$('#flashMessage').html('Template Title Successfully Added.');
							  	
							  	
						  }
					});
				}
			});
			//*******************************************EOF********************************************************************************
			//*****************************************Search the title present************************************************************
			$("#search").keypress(function(e) {
   				 if(e.which == 13) {
    						searchTemplate();
    					}
				});
			$("#searchBtn").click(function() {	 
   						searchTemplate();
				});
			
				function searchTemplate(searchTitle,searchFrom){
				searchFromTemplate = (searchFrom === undefined) ? searchFromTemplate : searchFrom;
				var serachText=$('#search').val();
				if(serachText==''){
					alert('Please enter data');
					return false;
				}
				searchTitle = (searchTitle === undefined) ? serachText : searchTitle;
				
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getSoap","admin" => false)); ?>";
				$.ajax({
				 			  type: "POST",
				 			  url: ajaxUrl+"/"+searchTitle+"/"+ searchFromTemplate,
				 			  beforeSend:function(){
				 			  	// this is where we append a loading image
				 			  	$('#busy-indicator').show('fast');
				 			  },
				 			  success: function(data){
					 			  if(searchFromTemplate == 'true'){
					 				 searchFromTemplate = 'false';
				 				 	var displayData=data.split('|~|');
									$('#subjectiveDisplay').html(displayData[0]);
									$('#objectiveDisplay').html(displayData[1]);
									$('#assessmentDisplay').html(displayData[2]);
									$('#planDisplay').html(displayData[3]);
									$('#rosDisplay').html(displayData[4]);
									$('#busy-indicator').hide('slow');
					 			  }else{
					 				 $('#search').val('');
					 				 var data=jQuery.parseJSON(data);
					 				$('#templateTitleContainer').html('');
					 				 $.each(data,function (key, value){
						 				$('#templateTitleContainer').append($('<td>').attr({onclick:'javascript:searchTemplate("'+value+'","true")'})
						 						.css({ 'font-size' : '13px', 'color' : '#31859c', 'text-decoration' : 'underline', 'cursor' : 'pointer' }).text(value));
								 	});
					 				 
					 				$('#busy-indicator').hide('slow');
					 			  }
							  }
						});
			}
			//********************************************EOF******************************************************************************
			$('#add-template').click(function(){
				$('#addTitle').focus();
				$('#sHide').hide();
				});

			$('#checkPostive').click(function(){
				if('<?php echo $noteId ?>'==''){
									var sunNoteId=$('#subjectNoteId').val();
									if(sunNoteId==''){
													var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "postiveCheck",$patientId,"admin" => false)); ?>";
													$.ajax({
											 			  type: "POST",
											 			  url: ajaxUrl+"/"+'1',
											 			  beforeSend:function(){
											 			  	// this is where we append a loading image
											 			  	$('#busy-indicator').show('fast');
											 			  },
											 			  success: function(data){
															  var nId=$.trim(data);
															 // if($.trim(data)=='save'){
															  $('#positiveGreen').show();
															  $('#positiveRed').hide();
															  $('#familyid').val(nId);
															  $('#ccid').val(nId); 
															  $('#subjectNoteId').val(nId); 
															  $('#assessmentNoteId').val(nId); 
															  $('#objectiveNoteId').val(nId); 
															  $('#planNoteId').val(nId); 
															  $('#signNoteId').val(nId);
															 	
														// }
														 $('#busy-indicator').hide('slow');

														  }
													});
									}
									else{
										var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "postiveCheck",$patientId,"admin" => false)); ?>";
										$.ajax({
								 			  type: "POST",
								 			  url: ajaxUrl+"/"+'1'+'/'+sunNoteId,
								 			  beforeSend:function(){
								 			  	// this is where we append a loading image
								 			  	$('#busy-indicator').show('fast');
								 			  },
								 			  success: function(data){
												  if($.trim(data)=='save'){
												 $('#positiveGreen').show();
												 $('#positiveRed').hide();
												 	
											 }else{
										
											 }
											 $('#busy-indicator').hide('slow');

											  }
										});
									}
				}
				else{
					var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "postiveCheck",$patientId,"admin" => false)); ?>";
					$.ajax({
			 			  type: "POST",
			 			  url: ajaxUrl+"/"+'1'+'/'+'<?php echo $noteId?>',
			 			  beforeSend:function(){
			 			  	// this is where we append a loading image
			 			  	$('#busy-indicator').show('fast');
			 			  },
			 			  success: function(data){
							  if($.trim(data)=='save'){
							 $('#positiveGreen').show();
							 $('#positiveRed').hide();
							 	
						 }else{
					
						 }
						 $('#busy-indicator').hide('slow');

						  }
					});
				}		
				});
				function saveFamily(){
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "soapNote","admin" => false)); ?>";
				var formData = $('#family_id').serialize();
				//
				$.ajax({
		 			  type: "POST",
		 			  url: ajaxUrl,
		 			  data: formData,
		 			  beforeSend:function(){
		 			  	// this is where we append a loading image
		 			  	$('#busy-indicator').show('fast');
		 			  },
		 			  success: function(data){
						  $('#busy-indicator').hide('slow');
						  alert('Saved Successfully');
					  }
				});
				}
				function saveSoap(recive){
					// elapsed tym calculation
					var eTime=$('#elapsedtym').html().split(" ");
					if($('#soap_outCC').val() < eTime['0'])
						$('#soap_outCC').val(eTime['0']);
					$('#soap_outPlan').val(eTime['0']);
					$('#soap_outAssessment').val(eTime['0']);
					$('#soap_outSubjective').val(eTime['0']);
					$('#soap_outOjective').val(eTime['0']);
					$('#soap_outFamily').val(eTime['0']);
					if($('#cc').val()==''){
						$(window).scrollTop($('#flashMessage').offset().top);
						$('#cc').focus();
						$('#flashMessage').show();
						$('#flashMessage').html('Please fill Chief Complaints.');
					return false;
					}
					
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "soapNote","admin" => false)); ?>";
				var formData='';
				var saveMsg="";
				if(recive=='familyfrm'){
				 formData = $('#familyfrm').serialize();
				 if($('#family_tit_bit').val()==''){
					 saveMsg="Family Personal Notes Saved.";
					 }
					 else{
						 saveMsg="Family Personal Notes Updated."; 
					 }
				 
				}
				else if(recive=='cc'){
					formData = $('#cc_id').serialize();
					if($('#cc').val()==''){
						 saveMsg="Chief Complaints Saved.";
						 }
						 else{
							 saveMsg="Chief Complaint Updated.";
						 }
				}
				else if(recive=='subject'){
					 formData = $('#subject').serialize();
					 if($('#subShow').val()==''){
					 saveMsg="Subjective Data Saved.";
					 }
					 else{
						 saveMsg="Subjective Data Updated.";
					 }
				}
				else if(recive=='objective'){  
					
					var formData = $('#objective').serialize();
				if($('#objectShow').val()==''){
					 saveMsg="Objective Data Saved.";
					 }
					 else{
						 saveMsg="Objective Data Updated.";
					 }
				}
				else if(recive=='plan'){

					//diagnosis drop down value chage text code
					var problemSelected=$('#problemLabRad option:selected').val();
					var planShowVal=$('#planShow').val();
					if(problemSelected=="0")
						$('.mainTextboxData').attr('id',planShowVal);
					else
						$('.'+problemSelected).attr('id',planShowVal);
					
					 formData = $('#plan').serialize();
					 if($('#planShow').val()==''){
						 saveMsg="Plan Data Saved.";
						 }
						 else{
							 saveMsg="Plan Data Updated.";
						 }
				}
				else if(recive=='assessment'){
					 formData = $('#assessment').serialize();
					 if($('#AssesShow').val()==''){
						 saveMsg="Assessment Data Saved.";
						 }
						 else{
							 saveMsg="Assessment Data Updated.";
						 }
				}
				//
				if(recive=='cc'){
					recive='add';
				}else if(recive=='familyfrm'){
					recive='add';
				}
				$.ajax({
		 			  type: "POST",
		 			  url: ajaxUrl,
		 			  data: formData,
		 			  beforeSend:function(){
		 			  	// this is where we append a loading image
		 			  	//$('#busy-indicator').show('fast'); 
		 			   loading(recive+'Table','id'); 
		 			  },
		 			  success: function(data){
		 				var noteid=parseInt(data);
						 // $('#busy-indicator').hide('slow');
						  onCompleteRequest(recive+'Table','id');
						  $('#familyid').val(noteid);
						  $('#ccid').val(noteid); 
						  $('#subjectNoteId').val(noteid); 
						  $('#assessmentNoteId').val(noteid); 
						  $('#objectiveNoteId').val(noteid); 
						  $('#planNoteId').val(noteid); 
						  $('#signNoteId').val(noteid);
						  $('#flashMessage').html(saveMsg);
						  $('#flashMessage').show();
						  $('#residentCheck').attr('disabled',false);
					  }
				});
				}
				$( "#dateID" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				//yearRange: '1950',
				//yearRange : '-50:+50',
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				maxDate: new Date(),
				onSelect:function(){
					$(this).focus()}
			});
			$("#checkVital").click(function(){
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getInitalData",$patientId,'fromSoap',"admin" => false)); ?>";
				$.ajax({
		 			  type: "POST",
		 			  url: ajaxUrl,
		 			  beforeSend:function(){
		 			  	// this is where we append a loading image
		 			  	$('#busy-indicator').show('fast');
		 			  },
		 			  success: function(data){
						  var data=jQuery.parseJSON(data);
						  if(data.temperature!=null)
						  	$('#temp').val(data.temp);

						  if(data.rr!=null)
						  	$('#rr').val(data.rr);
						  	
						  if(data.pr!=null)
						  	$('#pr').val(data.pr);
						  	
						  if(data.bp!=null)
						  	$('#bp').val(data.bp);
						 	
						 if(data.spo2!=null)
						 	$('#spo').val(data.spo2);
						 	
						 if(data.location!=null)
						 	$('#locations').val(data.location);
						 	
						 if(data.duration!=null)
						 	$('#duration').val(data.duration);
						 	
						 if(data.frequency!=null)
						 	$('#frequency').val(data.frequency);
						 	
						 if(data.pain!=null)
						 	$('#pain option:selected').text(data.pain);
						 	
						 $('#busy-indicator').hide('slow');

					  }
				});

				});
				$("#checkVital1").click(function(){
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getInitalData",$patientId,"admin" => false)); ?>";
				$.ajax({
		 			  type: "POST",
		 			  url: ajaxUrl,
		 			  beforeSend:function(){
		 			  	// this is where we append a loading image
		 			  	$('#busy-indicator').show('fast');
		 			  },
		 			  success: function(data){
						  var data=jQuery.parseJSON(data);
						  //var CData=$('#Cc').val();
						  $('#Cc').val(data.chiefComplaints);

						  	
						  $('#busy-indicator').hide('slow');

					  }
				});
				});


		/*	$(function() {

			    var $sidebar   = $(".top-header"),
			    $window    = $(window),
			    offset     = $sidebar.offset(),
			    topPadding = 0;

			    $window.scroll(function() {
			        if ($window.scrollTop() > offset.top) {
			            /*$sidebar.stop().animate({
			             top: $window.scrollTop() - offset.top + topPadding
			            });*/ 
			          /*  $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
			        } else {
			        	$sidebar.stop().animate({
			                top: 0
			            });
			        }
			    });
			 
			});*/
			var searchFromTemplate= 'false';
			$("#search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NoteTemplate","template_name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				onItemSelect : function (){
					searchFromTemplate = 'true';
				}
			});
		
			$("#icon_search").click( function(){
				$('#wheel').show();
			});
			$("#wheel").click( function(){
				var valWheel=$('#wheel option:selected').text();
				$('#search').val(valWheel);
				searchFromTemplate = 'true';
				$('#search').focus();
			});

			//***********************callDragon***************************************
			function callDragon(notetype){
				

				$
				.fancybox({
					'width' : '50%',
					'height' : '50%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "dragon")); ?>"+'/'+ notetype
				});
				 
			}
		//***************************************************************************************************************
		function addLabOrder(patientId){
var problemLabRad=$('#problemLabRad option:selected').text();
			 note_id  = "<?php echo $noteId ?>" ;
			 appt  = "<?php echo $_SESSION['apptDoc']; ?>" ;
			 if(note_id==''){
				 note_id=$('#subjectNoteId').val(); 
				 if(note_id=='')
				 note_id='null';
			 }	 
			window.location.href =  "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addLab")); ?>"
			+'/'+ patientId+'/'+note_id+'/'+null+'/'+appt+'/'+'?labRad='+problemLabRad;
		}
		function addRadOrder(patientId){

			 note_id  = "<?php echo $noteId ?>" ;
			 appt  = "<?php echo $_SESSION['apptDoc']; ?>" ;
			 if(note_id==''){
				 note_id=$('#subjectNoteId').val(); 
				 if(note_id=='')
				 note_id='null';
			 }	 
			window.location.href =  "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addRad")); ?>"+'/'+ patientId+'/'+note_id+'/'+appt;
		}
		function addProcedurePerform(patientId){
			 note_id  = "<?php echo $noteId ?>" ;
			 appt  = "<?php echo $_SESSION['apptDoc']; ?>" ;
			 if(note_id==''){
				 note_id=$('#subjectNoteId').val(); 
				 if(note_id=='')
				 note_id='null';
			 }	 
			window.location.href =  "<?php echo $this->Html->url(array("controller" => "notes", "action" => "addProcedurePerform")); ?>"+'/'+ patientId+'/'+note_id+'/'+appt;
		}



		</script>
<script>
$(function(){
	setInterval(function(){	 
		$(".elapsed").each(function() {
		  currentID= this.id ; //elapsed container id
		  currentValue = $(this).html(); 
		  status=$('#'+currentID).val();
		 var maxTime= $.trim(currentValue).split(" ") ; 
		 
		 if(maxTime[0]>=180){
			 return false;
		 }
		  if(currentValue.trim() ==  ''){
			  $(this).html("1 Min");
		  }else{
			  splittedVal= $.trim(currentValue).split(" ") ; //split number and "minutes" text
			  currentMin =  parseInt(splittedVal[0],10)+1 ;
			  if(currentMin<15){
			  $(this).html(currentMin+" Min");
			  }
			  else if(currentMin>15 && currentMin<=30){
				  $("#"+currentID).removeClass("elapsedGreen");
				  $("#"+currentID).addClass("elapsedYellow");
				  $(this).html(currentMin+" Min");
			  }
			  else if(currentMin>30){
				  $("#"+currentID).removeClass("elapsedYellow");
				  $("#"+currentID).addClass("elapsedRed");
				  $(this).html(currentMin+" Min");
			  }
		  } 
		})	;				
	},60000);
	
	
});

function sendReferral(){ 
	var noteIDR=	'<?php echo trim($noteId)?>'; 
	if((noteIDR) != ''){
		var noteIDR=   $('#subjectNoteId').val();
	}
	if(noteIDR==""){
		 var ajaxUrl1 = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "checkNoteIdForDiagnosis","admin" => false)); ?>";
		  $.ajax({
	        	beforeSend : function() {
	        		//loading();
	        	},
	        	type: 'POST',
	        	url: ajaxUrl1+"/"+<?php echo $patientId?>,
	        	dataType: 'html',
	        	success: function(data){
	        		var noteIDR=parseInt($.trim(data));
		        	 $('#familyid').val(noteIDR);
					  $('#ccid').val(noteIDR); 
					  $('#subjectNoteId').val(noteIDR); 
					  $('#assessmentNoteId').val(noteIDR); 
					  $('#objectiveNoteId').val(noteIDR); 
					  $('#planNoteId').val(noteIDR); 
					  $('#signNoteId').val(noteIDR);
					  window.location.href = "<?php echo $this->Html->url(array('controller'=>'messages','action'=>'composeCcda',$patientId)); ?>"
							+'/'+'null'+'/'+noteIDR+'/'+'?returnUrl=compose';
		        	},
		  });
	 }
	else{
		 window.location.href = "<?php echo $this->Html->url(array('controller'=>'messages','action'=>'composeCcda',$patientId)); ?>"
				+'/'+'null'+'/'+noteIDR+'/'+'?returnUrl=compose';
	}
	
}


var toogle=0;
$('#showFlagEvent').click(function(){
if($('#showFlagEvent:checked').length > 0){
	$('#eventText').show();
	$('#eventTextSubmit').show();
}
else{
	$('#eventText').hide();
	$('#eventTextSubmit').hide();
}
	
});
/*
 * 
 $('#showFlagEvent').click(function(){
	toogle++;
	if(toogle%2!=0){
		$('#eventText').show();
		$('#eventTextSubmit').show();
	}
	else{
		$('#eventText').hide();
		$('#eventTextSubmit').hide();
	}
	});*/

	var checkValChartAlert='<?php echo $checkFlagVal ?>';
		$('#flagEventId').change(function(){
			checkValChartAlert=2;
			 $('#showFlagEvent').prop('disabled', false);
			//$('#showFlagEvent').disabled(false);
			
 });
function updateEventFlag(){
	if($('#flagEventId').val()=='' || checkValChartAlert==1 || checkValChartAlert==0){
		return false;
	}else{
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "updateEventFlag",$patientId,$_SESSION['apptDoc'],"admin" => false)); ?>";
			  var formData =$('#flagEventId').val();
			$.ajax({
					  type: "POST",
					  url: ajaxUrl,
					  data:{"expression" : formData},
					  beforeSend:function(){
					  	// this is where we append a loading image
					  //	$('#busy-indicator').show('fast');
					  	 loading('wrapper','class'); 
					  },
					  success: function(data){
					//  $('#busy-indicator').hide('slow');
					if($('#flagEventId').val()==''){
						$('#flashMessage').show();
						$('#flashMessage').html('Chart Alert Saved');
					}
					else{
						$('#flashMessage').show();
						$('#flashMessage').html('Chart Alert Updated');
					}
					  	onCompleteRequest('wrapper','class');
					  
		
				  }
			});
	}
	}
	 function callDoc(id){
		 var noteIDCall=	'<?php echo trim($noteId)?>'; 
			if((noteIDCall) == ''){
				var noteIDCall=   $('#subjectNoteId').val();
			}

		window.location.href = "<?php echo $this->Html->url(array('controller'=>'PatientDocuments','action'=>'add',$patientId)); ?>"
			+'/'+'null'+'/'+'soap'+'/'+noteIDCall
	}


	 function edit_radorder(id){
			$.fancybox({
				'width' : '70%',
				'height' : '70%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "editRad")); ?>"
				+'/'+id,

			});
	}
		var checkValCC='<?php echo $checkccVal ?>';
	 		$('#cc').change(function(){
		 	checkValCC=2;

		 });
	 		var checkValFamily='<?php echo $checkFamilyVal ?>';
	 		$('#family_tit_bit').change(function(){
		 	checkValFamily=2;
		 });
		$('#cc').blur(function(){
			if($('#cc').val()=='' || checkValCC==1 || checkValCC==0 ){
			//	alert('Please fill data in Chief Complaint.');
				return false;
			}else{
			saveSoap('cc');
			}
			});
		$('#family_tit_bit').blur(function(){
			if($('#family_tit_bit').val()=='' || checkValFamily==1 || checkValFamily==0){
				return false;
			}else{
				saveSoap('familyfrm');
			}
			
			});
		$('#flagEventId').blur(function(){
			updateEventFlag();
			});
		function previewPowerNote(){
			 var noteIDPreview=	'<?php echo trim($noteId)?>'; 
				if((noteIDPreview) == ''){
					var noteIDPreview=$('#subjectNoteId').val();
				}
				if(noteIDPreview==''){
				alert('Please fill Subjective to proceed');
				return false;
				}
				window.location.href = "<?php echo $this->Html->url(array('controller'=>'PatientForms','action'=>'power_note'))?>"
					+'/'+noteIDPreview+'/'+'<?php echo $patientId?>'+'/'+'?Preview=preview';
		}
		$('#residentCheck').click(function(){
			
			if('<?php echo $noteId?>'==''){	
				var noteID=	$('#subjectNoteId').val();
			}else{
				var noteID=	'<?php echo $noteId?>';
			}
			var chk=confirm('Are you sure that note is completed?');
			if(chk==true){ 	
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "UpdateResident","admin" => false)); ?>";
				$.ajax({
						  type: "POST",
						  url: ajaxUrl+'/'+'<?php echo $patientId ?>'+'/'+noteID,
						  //data:{"expression" : formData},
						  beforeSend:function(){
						  	// this is where we append a loading image
						  	$('#busy-indicator').show('fast');
						  },
						  success: function(data){
						  $('#busy-indicator').hide('slow');

					  }
				});		
						
			}else{ 
				return false;
			} 
			});
			$('#problemLabRad').change(function(){
				var currentId =$.trim($('#problemLabRad').val());
				if(currentId=="0")
				{
					
					var mainTextboxData= $('.mainTextboxData').attr('id');	
					$('#planBtn').val('Update');
					 $('#planShow').val(mainTextboxData);
					 $('#oneOneDiagosis').val(currentId);
					 return false;
				}
				else
				{	
				   var showData=$('.'+currentId).attr('id');
				   $('#planBtn').val('Save for this Diagnosis');
				   $('#planShow').val(showData);
				   $('#oneOneDiagosis').val(currentId);
				}
				});


				$('#send').click(function(){				
					$
					.fancybox({
						'width' : '80%',
						'height' : '80%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "Ccda", "action" => "referral_note")); ?>"+'/'+<?php echo $patientId?>
						

					});
				});
					$('#smartphrases').click(function(){
					 var noteIDPreview=	'<?php echo trim($noteId)?>'; 
						if((noteIDPreview) == ''){
							var noteIDPreview=$('#subjectNoteId').val();
						}
						window.location.href = "<?php echo $this->Html->url(array('controller'=>'SmartPhrases','action'=>'admin_index','admin'=>true))?>"
							+'/'+'?patientId=<?php echo $patientId?>&noteId='+noteIDPreview;
				});
</script>
