<?php
	echo $this->Html->css(array('drag_drop_accordian.css','ros_accordian.css'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4','pager','jquery.are-you-sure.js'));
echo $this->Html->script(array('jquery.selection.js','jquery.blockUI'));
echo $this->Html->css(array('tooltipster.css'));
echo $this->Html->script(array('jquery.tooltipster.min.js'));
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
	
	if($appointmentID=='')
		$appointmentID = 'null';

	if($this->Session->read('diagnosesID') == '')
		$diagnosesID = 'null';
	else
		$diagnosesID = $this->Session->read('diagnosesID');
?>
<style>
	#msg{
		z-index:2000 ;
	}
	.table_form td {
	    font-size: 13px;
	    padding-right: 10px;
	}
	.tdClass {
	    font-size: 13px;
	    padding-right:0px;
	}

	.elapsedRed {
		color: red;
	}
	.elapsedGreen {
		color: Green;
	}
	.elapsedYellow {
		color: yellow;
	}
	#Chiefcomplaint textarea{ width:50%}
	#significantTestForm textarea{width:50%}
	.pointer{
		cursor: pointer;
	}
	.info_button2{
		float: right;
		padding-right: 35px
	}
	.ui-widget-content {
		color: #fff;
		font-size:13px;
	}
	 .light:hover {
	background-color: #F7F6D9;
	text-decoration:none;
	    color: #000000; 
	}
	.light td{ font-size:13px;}

	.patientHub .patientInfo .heading {
	float: left;
	width: 121px !important;
	}

	.top-header .table_form td {
	    padding-right: 0 !important;
	}
	.paraclass{ font-weight:bold; padding:0px; margin:0px; float:left;}

	.resize-input{
		height: 18px;
	    width: 183px; 
	}
	* {
		padding: 0px;
		margin: 0px;
	}
	.td_add img{float:right;padding-right: 15px;}
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
		font-weight:bold;
		overflow: hidden;
		padding: 0;
		width: 100%;
	}

	#talltabs-blue ul {
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
	    background:#DDDDDD;
		color:#31859C !important;
	}
	.dragbox-content span {
	    font-size: 13px;
	}
	.dragbox-content a {
	    font-size: 13px;
	}
	#talltabs-blue ul li.active a,#talltabs-blue ul li.active a:hover {
		background:#DDDDDD;
		color:#31859C !important;
	}
	.top-header {
		background:#d2ebf2;
		top: 0px;
		/*margin: 110px auto 0;
		position: absolute;
		z-index:1000;
		width:93%;
		display:block;
		overflow:hidden;*/
	}
	.stable{ position:relative; white-space: nowrap;}

	.gender > span {
	    float: left;
	    font-weight: bold;
	}

	.dob > span {
	    font-weight: bold;
		color: #31859c;
		float: left;
	}

	.pref_lang > span {
	    font-weight: bold;
	}

	.vis_typ > span {
	    font-weight: bold;
		float: left;
	}

	.clnt_snc > span {
	    font-weight: bold;
		float: left;
	}
	.elaps_time > span{
		font-weight:bold; float:left;
	}

	.top-header-save{
		border:0px; !important;
	}
</style>

<script>
<?php if($this->Session->read('initialAppointmentID')){
	$appointmentSessionId = $this->Session->read('initialAppointmentID');
}?>
var currTab = "<?php echo $this->request->params['pass']['1']; ?>" ;
var initialURL =  "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "initialAssessment",$patientId,"admin" => false)); ?>" ;
  $(document).ready(function () {
		$(".drmhope-tab").click(function(){  
	        	var tabClicked = $("#"+this.id).html();
		         $(location).attr('href',initialURL+'/'+tabClicked);
		});
		
		$("#tabs li").removeClass("ui-tabs-active");
        $("#tabs li").removeClass("ui-state-active");
        $("#"+currTab).addClass("ui-tabs-active");
        $("#"+currTab).addClass("ui-state-active");
        
	  $( "#tabs" ).tabs({
	    beforeLoad: function( event, ui ) {
	      if(ui.jqXHR){
	    	  ui.jqXHR.abort();
	      }
	    }
	  });
	});


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
<div class="message" id="flashMessage" style="display: none;">
	<!-- flash Message-->
</div>
<?php 
echo $this->Html->css(array('tooltipster.css'));
echo $this->Html->script(array('jquery.tooltipster.min.js'));

?>

<div class="inner_title" style="margin-top: 2px;">
	<h3>
		<?php echo __('Initial Assessment'); ?>
	</h3>
	<span><?php echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Preview summary of care')),array('controller'=>'PatientsTrackReports',
				'action'=>'printSummary',
			$getElement['Person']['id'],$patientId,'?'=>array('return'=>'InitialAssessment','patient_id'=>$patientId,'diagnosesId'=>$diagnosesID,'appt'=>$appointmentID)),
			array('div'=>false,'escape'=>false));"&nbsp"?>
	
	<?php if(strtolower($getElement['Patient']['admission_type']) == 'ipd'){?>
	 <?php echo $this->Html->link('Back',array('controller'=>'Users','action'=>'doctor_dashboard'),
	 		array('escape'=>false,'id'=>'ipdDashboard','title'=>'Ipd Dashboard','alt'=>'Ipd Dashboard','class'=>'blueBtn'));?>
	</span>
	<?php }else{?>
	
	<?php if($fromSoapNote == 'fromSoapNote'){?>
	 <?php echo $this->Html->link('Back',array('controller'=>'Notes','action'=>'soapNote',$patientId,$noteID,"appt" =>$appointmentID),array('escape'=>false,'id'=>'backToSoap','title'=>'Back To SOAP Note','alt'=>'Back To SOAP Note','class'=>'blueBtn'));?>
	</span>
	<?php }else{?>
	  <?php echo $this->Html->link('Back',array('controller'=>'Appointments','action'=>'appointments_management','?'=>array('from'=>'InitialSoap','pageCount'=>$this->Session->read('opd_dashboard_pageCount'))),array('escape'=>false,'id'=>'backToOpd','title'=>'Back To OPD Dashboard','alt'=>'Back To OPD Dashboard','class'=>'blueBtn'));?>
	</span>
	<?php }}?>
</div>

<div class="top-header" id="top_header">
	<!-- top-header -->
	<?php echo $this->Form->create('Diagnosis',array('action'=>'updateDiagnosisSection','id'=>'cc_id','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
	<table border="0" class="" cellpadding="0" cellspacing="2" width="100%" style="margin:5px;">
	<tr>
		<td class="tdClass" valign="top" style="width:10%;">
			<table border="0" class="table_form" cellpadding="0"
					cellspacing="2" style="padding: 0px; width:81px;">
				<tr>
					<td width='3%'><?php 
						if(!empty($getElement['Person']['photo'])){
							echo $this->Html->link($this->Html->image("/uploads/patient_images/thumbnail/".$getElement['Person']['photo'], array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$person_id), array('escape' => false));
						}else{
							echo $this->Html->link($this->Html->image('icons/default_img.png', array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$person_id), array('escape' => false));
						}

				 		 ?>
					</td>
				</tr>
					<tr>
						<td colspan="2">
						<?php  echo ucwords($getElement['Patient']['lookup_name']);?></td>
				</tr>
				
				
				
			</table>
		</td>
		
		<td class="tdClass" valign="top" style="width:30%;">
			
			
			
			<table border="0" class="table_form" cellpadding="0"
					cellspacing="2" style="padding: 0px;">
					<tr>
					<td>
					<table style="width:319px">
						<tr>
							<td style="width:46%;padding: 0 0 5px; color:#31859c;" class="gender">
								<p class="paraclass" style="width:137px;">
									<?php echo "Gender";?>
								</p>
								<span>:</span>
							</td>
							<td>
								<?php 
									echo $getElement['Person']['sex'];
								?>
							</td>
						</tr>
						<tr>
							<td class="dob" style="padding: 0 0 5px;color:#31859c;">
								<p class="paraclass" style="width:137px;">
									<?php echo "Date Of Birth";?>
								</p>
								<span>:</span>
							</td>
							<td>
								<?php 
									echo $this->DateFormat->formatDate2Local($getElement['Person']['dob'],Configure::read('date_format'))." (".$getElement['Person']['age'].")";
								?>
							</td>
						</tr>
						<tr>
							<td class="dob" style="padding: 0 0 5px;color:#31859c;">
								<p class="paraclass" style="width:137px;">
									<?php echo "Provider";?>
								</p>
								<span>:</span>
							</td>
							<td>
								<?php echo $doctors[$getElement['Patient']['doctor_id']]?>
							</td>
						</tr>
						<tr>
							<?php if(empty($getElement['Person']['language'])){
										$language='Denied to Specify';
								  }else{
										$lan=explode(',',$getElement['Person']['preferred_language']);
										for($i=0;$i< count($lan); $i++){
											if($i<count($lan)-1){
												$languageValue.=$language[$lan[$i]].',';
											}
											else{
												$languageValue.=$language[$lan[$i]];
											}
										}
									}?>
							<td class="pref_lang" style="padding: 0 0 5px;color:#31859c;">
								<p class="paraclass" style="width:137px;">
									<?php echo "Preferred Language";?>
								</p>
								<span>:</span>
							</td>
							<td>
								<?php echo " ".$languageValue;?>
							</td>
						</tr>
						<tr>
							<td class="pref_lang" style="padding: 0 0 5px;color:#31859c;">
								<p class="paraclass" style="width:137px;">
									<?php echo "Diagnosis Suspected";?>
								</p>
								<span>:</span>
							</td>
							<td>
								<?php echo $getElement['Patient']['instructions'];?>
							</td>
						</tr>
						
					</table>
				</td>
				
				<td>
					<table style="width:313px">
						<tr>
							<?php 
									$arr[]=Configure::read('patient_visit_type');
									if(strtolower($getElement['Patient']['admission_type']) == 'ipd'){
										$vTpye='IPD';
									}else{
									if(empty($getElement['Appointment']['visit_type'])){
										$vTpye='Not Indicated';
									}else{
										$vTpye='OPD';
									}}?>
							<td style="width:32%;padding: 0 0 5px;color:#31859c;" class="vis_typ"><p class="paraclass" style="width:90px;"><?php echo "Visit Type";?></p><span>:</span></td><td><?php echo $vTpye;?></td>
						</tr>
						<tr>
							<td class="clnt_snc" style="padding: 0 0 5px;color:#31859c;"><p class="paraclass" style="width:90px;"><?php echo "Client Since";?></p><span>:</span></td><td><?php echo $this->DateFormat->formatDate2LocalForReport($getElement['Person']['create_time'],Configure::read('date_format'));?></td>
						</tr>
						<tr>
							
		<?php 
		if(!empty($elaspseData['Appointment']['elapsed_time'])){
		$showTime=$elaspseData['Appointment']['elapsed_time'];
		$label='Elapsed Time';
		if($showTime<15){
	 		$elapsedClass='elapsedGreen';
		}else if($showTime>=15 && $showTime<=30){
			$elapsedClass='elapsedYellow';
		}
		else if($showTime>30){
			$elapsedClass='elapsedRed';
		}
	}else{
				$label='Elapsed Time';
				$start=$getElement['Appointment']['date']." ".$_SESSION['elpeTym'];
				if($start>date('Y-m-d H:i')){//debug('1');
					$elapsed=$this->DateFormat->dateDiff(date('Y-m-d H:i'),date('Y-m-d H:i')) ;
				}else{//debug('2');
					$elapsed=$this->DateFormat->dateDiff($start,date('Y-m-d H:i')) ;
				}
				if(!empty($elaspseData['Appointment']['elapsed_time'])){// after night 12
					$showTime=$elaspseData['Appointment']['elapsed_time'];
					$label='Elapsed Time';
				}else{
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
				}
		}}
		if($getElement['Patient']['admission_type']=='OPD'){
		?>
			<td class="elaps_time" style="padding: 0 0 5px;color:#31859c;">
				<p class="paraclass" style="width:94px;">
					<?php echo $label;?></b><span style="float:right; font-weight:bold;">:</span></td>
							<td><span id="<?php echo 'elapsedtym';?>"	class="<?php echo "elapsed ".$elapsedClass; ?>"><b><?php echo $showTime.' Min';?></b></span> </td><?php  }?>
						</tr>
					</table>
				</td>
				
			</tr>

			</table>
		</td>
		
		<td class="tdClass" valign="top" width="3%">
			<table width="225pxpx">
				<tr>
					<td>
				<table border="0" class="" cellpadding="0"
					cellspacing="2" style="padding: 0px; width:228px; float:left;">
                 
			
					<tr>
						<td>
						<div valign="" style="color:#31859c; float:left; font-size:13px;width:150px;padding:5px 0 5px;"><b><?php echo __("Chief Complaints");?></b></div>
						<div width="1%" style="float:left; font-size:13px;padding: 0 0 5px;">
						<?php echo $this->Form->input('complaints',array('type'=>'text','cols'=>'1','rows'=>'1', 'class'=>'resize-input validate[optional,custom[mandatory-enter]]','value'=>stripslashes($getDiagnosisData['Diagnosis']['complaints']),'label'=>false,'id'=>'cc'));?>
						</div>
						<?php echo $this->Form->hidden('hidden_sure_cc',array('value'=>'','type'=>'text','id'=>'hidden_sure_cc'));?>
						<?php echo $this->Form->hidden('appointment_id',array('value'=>$appointmentID));?>
						<?php echo $this->Form->hidden('patient_id',array('value'=>$patientId));?>
						<?php echo $this->Form->hidden('id',array('id'=>'ccid','value'=>$id));?>
						<?php echo $this->Form->hidden('diagnoses_in',array('value'=>$soap_in));?>
						<?php echo $this->Form->hidden('diagnoses_out',array('id'=>'diagnoses_outCC','value'=>$soap_in));?>
						</td>
                     </tr>

                     <?php if(!empty($getDiagnosisData['Diagnosis']['family_tit_bit']) && strtolower($this->Session->read('role')) != 'admin'){
                     			$disableFTB = 'disabled';
                     		}else{
                     			$disableFTB = '';
                     		}

                     		if(!empty($getDiagnosisData['Diagnosis']['family_tit_bit1']) && strtolower($this->Session->read('role')) != 'admin'){
                     			$disableFTB1 = 'disabled';
                     		}else{
                     			$disableFTB1 = '';
                     		}

                     		if(!empty($getDiagnosisData['Diagnosis']['family_tit_bit2']) && strtolower($this->Session->read('role')) != 'admin'){
                     			$disableFTB2 = 'disabled';
                     		}else{
                     			$disableFTB2 = '';
                     		}
                     ?>
                    <tr>
                        <td>
                        <div style="color:#31859c;float:left; font-size:13px; clear:left;width:150px;padding:5px 0 5px;"><b>
                        	<?php echo __("Family Personal Notes");?></b></div>
						<div style="float:left;padding: 0 0 5px;"><?php echo $this->Form->input('family_tit_bit',array('type'=>'text','cols'=>'1','rows'=>'1', 'class'=>'resize-input', 'value'=>stripslashes($getDiagnosisData['Diagnosis']['family_tit_bit']),'label'=>false,'id'=>'family_tit_bit','disabled'=>$disableFTB));?>
						</div>
						<?php echo $this->Form->hidden('hidden_sure_family_tit_bit',array('value'=>'','id'=>'hidden_sure_family_tit_bit'));?>
						<?php echo $this->Form->hidden('appointment_id',array('value'=>$appointmentID));?>
						<?php echo $this->Form->hidden('patient_id',array('value'=>$patientId));?>
						<?php echo $this->Form->hidden('id',array('id'=>'familyid','value'=>$id));?>
						<?php echo $this->Form->hidden('diagnoses_in',array('value'=>$soap_in));?>
						<?php echo $this->Form->hidden('diagnoses_out',array('id'=>'diagnoses_outFamily','value'=>$soap_in));?>
						</td>
					</tr>

					<tr>
                        <td>
                       
						<div style="float:left;padding: 0 0 5px;"><?php echo $this->Form->input('family_tit_bit1',array('type'=>'text','cols'=>'1','rows'=>'1', 'class'=>'resize-input', 'value'=>stripslashes($getDiagnosisData['Diagnosis']['family_tit_bit1']),'label'=>false,'id'=>'family_tit_bit1','disabled'=>$disableFTB1));?>
						</div>
						
						<?php echo $this->Form->hidden('appointment_id',array('value'=>$appointmentID));?>
						<?php echo $this->Form->hidden('patient_id',array('value'=>$patientId));?>
						
						</td>
					</tr>

					<tr>
                        <td>
                      
						<div style="float:left;padding: 0 0 5px;"><?php echo $this->Form->input('family_tit_bit2',array('type'=>'text','cols'=>'1','rows'=>'1', 'class'=>'resize-input', 'value'=>stripslashes($getDiagnosisData['Diagnosis']['family_tit_bit2']),'label'=>false,'id'=>'family_tit_bit2','disabled'=>$disableFTB2));?>
						</div>
						
						<?php echo $this->Form->hidden('appointment_id',array('value'=>$appointmentID));?>
						<?php echo $this->Form->hidden('patient_id',array('value'=>$patientId));?>
						
						</td>
					</tr>
					 
				</table> </td>
				</tr>
				
			</table>
		</td>
        <td width="50%" valign="top" class="tdClass">
         <table border="0" class="table_form" cellpadding="0"
					cellspacing="2" style="padding:float:left; width:200px;">
                    
                    <tr>
							<!--Is positive  -->
							<?php  

									
									if($getDiagnosisData['Diagnosis']['positive_id'] == '1'){
										$displayGreen='block';
										$displayRed='none';
									}else{
										$displayGreen='none';
										$displayRed='block';	
									}
								
									
							?>
                                <td valign="top">
                                <div style=""></div>
          			 <div class="tdLabel" valign="top" style="padding: 10px 0 0 3px!important;color:#31859c; padding-right:0px !important; float:left;"><b><?php echo __("Positive Id Check");?></b></div>&nbsp;
		           <div width="1%" valign="top" style="padding-right: 0 !important; float: left;">
				   <table>
						<tr>
							<td>
							
							<span id='checkPostive' style="display:<?php echo $displayRed;?>"><?php echo $this->Html->image('icons/red.png',array('style'=>'cursor:pointer;','title'=>'Check Positive ID'));?></span>
						  	<span id='' style="display:<?php echo $displayGreen;?>"><?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed;','title'=>'Check Positive ID'));?></span>
							</td>
						</tr>
					</table>
					</div>
					<!--<div class="clr"></div>-->
					<div  width="20%" valign="top" style="padding-right:0!important; float:left;">
					<table style="float:left; width:300px;">
					 <tr>
					  <td>
					   <?php 
							
							if(empty($getDiagnosisData['Diagnosis']['flag_event'])){
								$display='none';
							}else{
								$display='block';
								$checked='checked';
								$disabledCheckBox='disabled';
								}?>
                        <div style="color:#31859c;float:left; font-size:13px; clear:left; width:90px; padding-top:5px;"><b><?php echo __("Chart Alert"); 
                        echo ' '.$this->Form->checkbox('flag_chk',array('id'=>'showFlagEvent','checked'=>$checked,'disabled'=>$disabledCheckBox,'autocomplete'=>'off'))
                      ?></b></div>
						<div style="float:left; font-size:13px;"><span style="display:<?php echo $display?>" id='eventText'><?php echo $this->Form->input('flag_event',array('type'=>'text','cols'=>'1','rows'=>'1', 'class'=>'resize-input', 'value'=>stripslashes($getDiagnosisData['Diagnosis']['flag_event']),'label'=>false,'id'=>'flag_event'));?>
						</span></div>
						<?php echo $this->Form->hidden('hidden_sure_flag_event',array('value'=>'','id'=>'hidden_sure_flag_event'));?>
						<?php echo $this->Form->hidden('appointment_id',array('value'=>$appointmentID));?>
						<?php echo $this->Form->hidden('patient_id',array('value'=>$patientId));?>
						<?php echo $this->Form->hidden('id',array('id'=>'familyid1','value'=>$id));?>
						<?php echo $this->Form->hidden('diagnoses_in',array('value'=>$soap_in));?>
						<?php echo $this->Form->hidden('diagnoses_out',array('id'=>'diagnoses_flagEvent','value'=>$soap_in));?>
						<div style="float:left; font-size:13px;padding-left: 5px;">
						<span style="display:<?php echo $display?>" id='eventTextSubmit'>
			
						</span></div>
						</td>
					</tr>
					</table>
					</div>
		          
				</td>
          	</tr>
          	<?php // Sync Newcrop -Gullu?>
								<tr>
								<td><?php echo $this->Html->image('icons/Refresh.png',array('style'=>'cursor:pointer;','alt'=>
										'Sync with Newcrop','title'=>'Sync with Newcrop','class'=>'newCropSync',
										'patientId'=>$patientId,'id'=>$personid['Patient']['person_id']));?><span is="syncMsg"></span>
									</td>
								</tr>
								<?php // Sync Newcrop -EOD?>
         </table>
        </td> 
	</tr>
</table>
	<?php echo $this->Form->end();
		  echo $this->Js->writeBuffer(); 
	?> 
<table border="0" class="table_form stable" cellpadding="0" cellspacing="2" style="padding: 0px;">
	<tr>
		<td class="tdClass" valign="top">
		<table border="0" class="table_form" cellpadding="0"
					cellspacing="2" style="padding: 0px;">
					<tr>
						<td id="topAllergy"></td>
						
					</tr>
			</table>
		</td>
	</tr>
	</table>	
		
</div>
<div id="search_template" style="padding-bottom:10px;margin:0px 3px;display:<?php echo $search_template ;?>">
	<table>
		<tr id="sHide">
			<td>
				<?php echo $this->Form->input('',array('type'=>'text','lable','id'=>'search','placeholder'=>'Search Template'));?>
			</td>
			<td>
				<?php echo $this->Html->link('Search Template','javascript:void(0)',array('escape'=>false,'id'=>'searchBtn','title'=>'Search','alt'=>'Search','class'=>'blueBtn'));?>
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
											<?php 
												natcasesort($tName);
												echo $this->Form->input('language', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','options'=>$tName,'style'=>'margin:1px 0 0 10px;','multiple'=>'true','id' => 'language','autocomplete'=>'off'));
											?>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td id="addTitleTd">
				<?php 
					echo $this->Html->link($this->Html->image('/img/icons/search_icon.png'),'javascript:void(0)',array('escape'=>false,'id'=>'icon_search','title'=>'Search','alt'=>'Search'));
					echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'add-template','style'=>'padding-left:5px;cursor:pointer'));
				?>
			</td>
		</tr>
	</table>
</div>

<div id="add-template-form" style="display: none; align: left;">
	<?php 
		echo $this->Form->create('NoteTemplate',array('id'=>'doctortemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));
	?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="30%">
		<tr>
			<td style="text-align: center;">
				<?php echo __('Add Template Title');?>:
			</td>
			<td>
				<?php 
					echo $this->Form->hidden('id');
					echo $this->Form->input('template_name',array('type'=>'text','rows'=>'3','cols'=>'4','id'=>'addTitle'));
				?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<div style="float:right;">
					<?php 
						echo $this->Html->link(__('Cancel'),"javascript:void(0)",array('id'=>'close-template-form','class'=>'grayBtn','style'=>'margin:10px 0 0 0!important;'));
						echo $this->Form->input(__('Submit'),array('type'=>'button','id'=>'submitTemplate','class'=>'grayBtn'));
					?>
            	</div>
			</td>
		</tr>
	</table>
	<?php $this->Form->end();?>
</div>

<div id="talltabs-blue">
	<ul style="float: right;">
		<li id="expand_id">
			<a>
				<span style="cursor: pointer; cursor: hand" id="expand_id" onclick="expandCollapseAll('expand_id')">Expand All</span>&nbsp;&nbsp;
			</a>
		</li>
		<li id="collapse_id">
			<a>
				<span style="cursor: pointer; cursor: hand" id="collapse_id" onclick="expandCollapseAll('collapse_id')">Collapse All</span>
			</a>
		</li>
	</ul>
</div>
<!-- template EOF -->
<div class="clear">&nbsp;</div>

<?php 
	$lastColumn = '';
	echo '<div class="outerDiv">';  
	foreach($columns as $key =>$column) { 
	if(!empty($lastColumn) && ($lastColumn != trim($column['Widget']['column_id']))){
		echo '</div></div>';
		if($column['Widget']['column_id'] == '3')
			$float = 'float:right;';
		else $float = 'float:left;';
		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="column" style="width:32%;'.$float.'">';
		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="">';/*class="columnInternal">  */
	}else if(empty($lastColumn)){
		echo '<div id="mainColumn'.$column['Widget']['column_id'].'" class="column" style="width:100%">';
		echo '<div id="column'.$column['Widget']['column_id'].'" class="">';/*class="columnInternal">  */
	}
	$boxHtml =  '<div class="dragbox" id="item'.$column['Widget']['id'].'" >';
	$boxHtml .= '<h2><div style="display:inline" >'.$column['Widget']['title'].'</div><span style="padding-left:30px; font-size:10px" id="record">{{recordCount}}</span></h2>';
	$expandBlock  = str_replace('_', ' ', $expandBlock);
	if($column['Widget']['collapsed'] == '1'){
		if($column['Widget']['title'] == $expandBlock){
			$collapsedDiv = 'style="display:block;"';
		}else{
			$collapsedDiv = 'style="display:none;"';
		}
	}else{
		$collapsedDiv = 'style="display:block;"';
	}
	$boxHtml .= '<div class="dragbox-content" '.$collapsedDiv.'>';
	switch (strtolower($column['Widget']['title'])) {
		case 'nursing notes':
			echo nursingNotes($getDiagnosisData,$boxHtml,$patientId,$id,$appointmentID,$soap_in);
			break;
		case 'chief complaint':
			echo chiefComplaint($getDiagnosisData,$boxHtml,$patientId,$id,$appointmentID,$soap_in);
			break;
		case 'current medication':
			$currentTreatmentsLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array("controller" => "Diagnoses", "action" => "currentTreatment",$patientId,$id,$patientUid['Patient']['patient_id'],'null','null',$diagnosesID,$appointmentID,'?'=>array('patientId'=>$patientId,'type'=>'addNew')), array('escape' => false,'title'=>'Add Current Medication'));
			echo currentTreatment($getDiagnosisData,$boxHtml,$currentTreatmentsLink,$patientUid,$this->Form,$newCropPrescription);
			break;
		case 'medication history':
			$medicationHistoryLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array("controller" => "Diagnoses", "action" => "medicationHistory",$patientId,$id,$patientUid['Patient']['patient_id'],'null','null',$diagnosesID,$appointmentID,'?'=>array('patientId'=>$patientId,'type'=>'addNew')), array('escape' => false,'title'=>'Add Medication History'));
			if(!empty($pharmacyData)){
				$edit=$this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => ('Edit'), 'title' => __('Edit'))),
					array("controller"=>"Persons","action"=>"edit",$personIDforEdit,'?'=>array('from'=>'initial','patientId'=>$patientId,'diagnosisId'=>$id,'apptId'=>$appointmentID)),
					 array('id'=>$personIDforEdit,'class'=>'editType','escape' => false));
				$delete=$this->Html->link($this->Html->image('icons/cross.png', array('alt' => ('Delete'), 'title' => __('Delete'))),"javascript:void(0)", array('id'=>$personIDforEdit,'class'=>'deleteType','escape' => false));
			}else{
				$edit='';
				$delete='';
			}
			
			echo medicationHistory($getDiagnosisData,$boxHtml,$medicationHistoryLink,$patientId,$getPatientPharmacy,$pharmacyData,$last_drug,$edit,$delete);
			break;
		case 'history':
			$significantHistoryLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'Diagnoses','action' => 'significantHistory',$patientId,$getElement['Person']['id'],$appointmentID,$id), array('escape' => false,'title'=>'Add'));
			echo significantHistory($getDiagnosisData,$boxHtml,$significantHistoryLink);
			break;
		case 'vitals':
			$vitalsLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array('controller'=>'Diagnoses','action' => 'addVital',$patientId,$id,$appointmentID,$arr_time), array('escape' => false,'title'=>'Add Vitals'));
			echo vitals($getDiagnosisData,$boxHtml,$vitalsLink,$interactiveLink);
			break;
		case 'immunizations':
			if(!empty($imunizationCount['Immunization']['id'])){
			 	$immunizationLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array("controller" =>"Imunization","action" =>"index",$patientId,'InitialAssessment',$diagnosesID,$appointmentID), array('escape' => false,'title'=>'Add Immunizations'));
			}else{
				$immunizationLink = $this->Html->link($this->Html->image('icons/plus_6.png'), array("controller" =>"Imunization","action" =>"add",$patientId,'null','initialAssessment',$diagnosesID,$appointmentID,'?'=>array('pageView'=>"ajax")), array('escape' => false,'title'=>'Add Immunizations'));
			}
			echo immunization($getImmunization,$boxHtml,$this->DateFormat,$immunizationLink);
			break;
		case 'allergies':
			$allergiesLink = $this->Html->image('icons/plus_6.png', array('id'=>'allergy','title'=>'Add Allergy'));
			echo allergy($newCropAllergies,$boxHtml,$allergiesLink,$patientId,$this->Form);
			break;
	}

	$lastColumn = $column['Widget']['column_id'];
	$userId = $column['Widget']['user_id'];
	$screenApplicationName = $column['Widget']['application_screen_name'];
	}
?>
</div>
</div>
<?php 
	function chiefComplaint($getDiagnosisData,$boxHtml,$patientId,$id,$appointmentID,$showTimecc){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$chiefComplaintHtml = $boxHtml;
		$chiefComplaintHtml.='</form><form onSubmit="event.returnValue = false; return false;" action="'.Router::url("/").'Diagnoses/updateCC" method=post id="Chiefcomplaint"><table class="formFull formFullBorder">
								 		<tr><td><div id="showCheifComplaints" class="manageWidthContainer"></div></td></tr>
										<tr><td class="td_add"><textarea style="width: 300px !important; height: 323px !important;" name="Diagnosis[complaints]" id="subShow">'.$getDiagnosisData["Diagnosis"]["complaints"].'</textarea></td></tr>';
		$chiefComplaintHtml .='<tr><td class="td_add" clospan="4" style="align:right"><input type=submit name=Submit value=Update class="blueBtn" id="ccSubmit"></td>
			<input type=hidden name=Diagnosis[hidden_sure_id] value="" id="hidden_sure_cc_id">
		<input type=hidden name=Diagnosis[patient_id] value='.$patientId.'><input type=hidden name=Diagnosis[id] value='.$id.'><input type=hidden name=Diagnosis[appointment_id] value='.$appointmentID.'>
			<input type=hidden  id="diagnoses_outcc" name=Diagnosis[diagnoses_out] value='.$showTimecc.'></tr></table></form>';
		
		$chiefComplaintHtml.='</div></div>';
		return $chiefComplaintHtml ;
	}
	
	/* Nursing Notes */
	function nursingNotes($getDiagnosisData,$boxHtml,$patientId,$id,$appointmentID,$showTimecc){
		 
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$chiefComplaintHtml = $boxHtml;
		$chiefComplaintHtml.='</form>
								<form onSubmit="event.returnValue = false; return false;" action="'.Router::url("/").'Diagnoses/updateCC" method=post id="NursingNotes"><table  width="100%" class="formFull formFullBorder">
							 		 
									<tr><td class="td_add"><textarea style="width: 300px !important; height: 323px !important;" name="Diagnosis[nursing_notes]" id="nursing_notes">'.$getDiagnosisData["Diagnosis"]["nursing_notes"].'</textarea></td></tr>';
		$chiefComplaintHtml .='<tr>
        							<td class="td_add" clospan="4" style="align:right">
        								<input type=submit name=Submit value=Update class="blueBtn" id="nurseSubmit">
        							</td>
									<input type=hidden name=Diagnosis[patient_id] value='.$patientId.'>
							      	<input type=hidden name=Diagnosis[id] value='.$id.'>
    								<input type=hidden name=Diagnosis[hidden_sure_nurse_id] value="" id=hidden_sure_nurse_id>
							    	<input type=hidden name=Diagnosis[appointment_id] value='.$appointmentID.'>
							</tr></table></form>';
	
		$chiefComplaintHtml.='</div></div>';
		return $chiefComplaintHtml ;
	}

	function currentTreatment($data,$boxHtml,$currentTreatmentsLink,$patientUid,$form,$newCropPrescription){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$currentTreatmentHtml.= $boxHtml;
		$currentTreatmentHtml .='<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
		$currentTreatmentHtml .='<table  width="100%" class="formFull formFullBorder">
        <tr><td id="treatmentloader" width="100%"></td></tr>
		<tr><td class="td_add tdLabel" style="background:#8A9C9C">Add Current Medications'.$currentTreatmentsLink.'
			</td></tr>
		<tr><td id="CT" class="td_add">
		</td></tr></table>';
		$currentTreatmentHtml.='</div></div>';
		return $currentTreatmentHtml ;
	}
	
	function medicationHistory($getDiagnosisData,$boxHtml,$medicationHistoryLink,$patientId,$getPatientPharmacy,$pharmacyData,$last_drug,$edit,$delete){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$medicationHistoryHtml.= $boxHtml;
		$medicationHistoryHtml .='<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
		$medicationHistoryHtml .='<table  width="100%" class="formFull formFullBorder">
		<tr>
		<td id="treatmentloader" width="100%"></td>
		</tr>
		<tr>
			<td class="td_add tdLabel" style="background:#8A9C9C">Add Medications History'.$medicationHistoryLink.'</td>
		</tr>
		<tr><td id="MA" class="td_add">
		</td></tr>
		</table></form>';
		
		$preferredPharmacyHtml='<form id=pharmacyForm  method=post>';
		$preferredPharmacyHtml .='<table  width="100%" class="formFull formFullBorder"> 
		<tr><td colspan="6" valign=top id="PharmacyShowDetail"> Preferred Pharmacy : '.$pharmacyData['PharmacyMaster']['Pharmacy_StoreName'].'';
	 	$preferredPharmacyHtml .='</tr>
		
		<tr id="showheader" style="background-color:#ccc;">
			<td style="padding:5px 0 5px 10px;">Address</td>
			<td style="padding:5px 0 5px 10px;">Zip</td>
			<td style="padding:5px 0 5px 10px;">State/City</td>
			<td style="padding:5px 0 5px 10px;">Telephone/Fax</td>
			<td style="padding:5px 0 5px 10px;"></td>
		</tr>
		<tr id="showdetail">
			<td style="padding:5px 0 5px 10px;" id="address">'.$pharmacyData['PharmacyMaster']['Pharmacy_Address1'].' '.$pharmacyData['PharmacyMaster']['Pharmacy_Address2'].'</td>
			<td style="padding:5px 0 5px 10px;" id="zip">'.$pharmacyData['PharmacyMaster']['Pharmacy_Zip'].'</td>
			<td style="padding:5px 0 5px 10px;" id="city">'.$pharmacyData['PharmacyMaster']['Pharmacy_StateAbbr'].'/'.$pharmacyData['PharmacyMaster']['Pharmacy_City'].'</td>
			<td style="padding:5px 0 5px 10px;" id="phone">'.$pharmacyData['PharmacyMaster']['Pharmacy_Telephone1'].'</br>'.$pharmacyData['PharmacyMaster']['Pharmacy_Fax'].'</td>
			<td style="padding:5px 0 5px 10px;" id="fax">'.$edit.' </br>'.$delete.'</td>
		</tr>
    	</table>
	 	</form>';
    	$insuranceHtml='<form id=InsuranceForm  method=post>';
		$insuranceHtml .='<table  width="100%" class="formFull formFullBorder"> 
		<tr><td valign=top><label style="width:200px; padding-top:2px!important;"> Health Plan for Formulary Check: </label><input type="text" name="Patient[insurance_company_name]" id="insurance_company_name" value="'.$getPatientPharmacy["Patient"]["insurance_company_name"].'">
	 		<input type=hidden name=Patient[id] id=insurance_patient_id value='.$patientId.'>
			<input type=hidden name=Patient[patient_health_plan_id] id=patient_health_plan_id value="'.$getPatientPharmacy["Patient"]["patient_health_plan_id"].'">
			<!--<input type=hidden name=NewInsurance[id] id=insurance_id value="'.$getInsurancesData["NewInsurance"]["id"].'">		
			<input type=hidden name=NewInsurance[is_active] id=is_active value=1>
			<input type=hidden name=NewInsurance[is_formulatory_check] id=is_formulatory_check value=yes>-->
			<input type=button name=submit value=Update id=insurance_update  class= blueBtn style="margin:-2px 0px -22px 11px"></td>
	 	</tr>
		</table>
	 	</form>';
		$medicationHistoryHtml.=$preferredPharmacyHtml.=$insuranceHtml.'</div></div>';
		return $medicationHistoryHtml ;
	}

	function significantHistory($data,$boxHtml,$significantHistoryLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$significantHistoryHtml .= $boxHtml;
		 
		$significantHistoryHtml .= '<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
		$significantHistoryHtml .='<table  width="100%" class="formFull formFullBorder">
        		<tr>
        		<td id="treatmentloader" width="100%"></td>
        		</tr>
        		<tr>
        		<td class="td_add tdLabel" style="background:#8A9C9C">History'.$significantHistoryLink.'</td>
				</tr>
		<tr><td id="SH" class="td_add">
		</td></tr></table>';

		$significantHistoryHtml.='</div></div>';
		return $significantHistoryHtml ;
	}

	function vitals($data,$boxHtml,$vitalsLink, $interactiveLink){
		$boxHtml = str_replace("{{recordCount}}","",$boxHtml);
		$activitiesHtml = $boxHtml;
		$activitiesHtml .='<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
		$activitiesHtml .='<table  width="100%" class="formFull formFullBorder">
		<tr>
		<td id="treatmentloader" width="100%"></td>
		</tr>
		<tr>
			<td class="td_add tdLabel" style="background:#8A9C9C">Add Vitals'.$interactiveLink.' '.$vitalsLink.'</td>
		</tr>
		<tr><td id="vital" class="td_add">
		</td></tr></table>';
		$activitiesHtml.='</div></div>';
		return $activitiesHtml ;
	}
	
	function immunization($getImmunization,$boxHtml,$dateformate,$immunizationLink){
		$countgetImmunization = count($getImmunization);
		$boxHtml = str_replace("{{recordCount}}",''.$countgetImmunizations.'',$boxHtml);
		$immunizationHtml = $boxHtml;
		$immunizationHtml .='<form action="'.Router::url("/").'Diagnoses/initialAssessment" method=post>';
		$immunizationHtml .='<table  width="100%" class="formFull formFullBorder">
		<tr>
		<td id="treatmentloader" width="100%"></td>
		</tr>
		<tr>
			<td class="td_add tdLabel" style="background:#8A9C9C">Add Immunization'.$immunizationLink.'</td>
		</tr>
		<tr><td id="imu" class="td_add">
		</td></tr></table>';
		$immunizationHtml.='</div></div>';
		return $immunizationHtml;
	}
	
	function allergy($newCropAllergies,$boxHtml,$allergiesLink,$patientId,$form){
		$countnewCropAllergies = count($newCropAllergies);
		$boxHtml = str_replace("{{recordCount}}",''.$countnewCropAllergie.'',$boxHtml);
		$allergyHtml = $boxHtml;
		$allergyHtml.='<table id="addAllergy"  width="100%"><tr><td class="td_add tdLabel" style="background:#8A9C9C">Add Allergy'.$allergiesLink.'</td></tr>';
		$allergyHtml.='<tr><td id="allergyData"></td></tr></table>';
		$allergyHtml .= "</div></div>" ;
		return $allergyHtml;
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

<script type="text/javascript">
$(function() {

    var $sidebar   = $(".top-header"),
    $window    = $(window),
    offset     = $sidebar.offset(),
    topPadding = 0;

    $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
            $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
        } else {
        	$sidebar.stop().animate({
                top: 0
            });
        }
    });

});

window.history.forward();
function noBack()
{
    window.history.forward();
}
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
	getAllergyTop();
	getImunization();
	

	$('#ccSubmit') .click( function (){
		chief_name = $('#subShow').val();
		$('#cc').val(chief_name);
	});
	$('#cc') .blur( function (){
		name_chief = $('#cc').val();
		$('#subShow').val(name_chief); 
	});
	
	 	$('#pharmacy').click(function(){
		 	$.ajax({
	 			  type : "POST",
	 			  url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "updatePharmacy", "admin" => false)); ?>",
	 			  context: document.body,
	 			  data:$('#pharmacyForm').serialize(),
	 			  beforeSend:function(){
	 				  loading('outerDiv','class');
	 			  }, 	  		  
	 			  success: function(data){
		 			 onCompleteRequest('outerDiv','class');
	 			  }
	 		});
	 	});
	 	$('#insurance_update').click(function(){
		 	$.ajax({
	 			  type : "POST",
	 			  url: "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "updateInsurance", "admin" => false)); ?>",
	 			  context: document.body,
	 			  data:$('#InsuranceForm').serialize(),
	 			  beforeSend:function(){
	 				  loading('outerDiv','class');
	 			  }, 	  		  
	 			  success: function(data){
		 			 onCompleteRequest('outerDiv','class');
	 			  }
	 		});
	 	});

	
    $('.dragbox').each(function(){  
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
            ui.item.css({'top':'0','left':'0'}); //Opera fix  
            //if(!$.browser.mozilla && !$.browser.safari)  
                updateWidgetData();  
        }  
    })  
    .disableSelection();  
});  

 

	$('#checkPostive').click(function(){
		 	
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "postiveCheck",$patientId,$getDiagnosisData['Diagnosis']['id'],"admin" => false)); ?>";
			$.ajax({
	 			  type: "POST",
	 			  url: ajaxUrl,
	 			  beforeSend:function(){
	 			  	// this is where we append a loading image
	 				 loading('top-header','class');
	 				loading("outerDiv","class");
	 			  },
	 			  success: function(data){
		 			//  alert(data);
					//  if($.trim(data)=='save'){
					 $('#checkPostive').html('<?php echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed;'));?>');
					 onCompleteRequest('top-header','class');
					 onCompleteRequest("outerDiv","class");
					 	
					// }else{
				
				//	 }
					 

				  }
			});
		 		
		});



//=== Other Treatment ===
	/*
	
$('#otherTreatments').click(function(){
	$.fancybox({
		
		'width' : '100%',
		'height' : '60%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			getTreatment();
		},
		'href' : "<?php //echo $this->Html->url(array("controller" => "Diagnoses", "action" => "otherTreatment",$patientId,$appointmentID)); ?>",
				
	
	});
});

function getTreatment() {
	 var ajaxUrl = "<?php //echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getTreatment",$patientId,"admin" => false)); ?>";
        $.ajax({
        	beforeSend : function() {
        		
            	loading("outerDiv","class");
          	},
        type: 'POST',
        url: ajaxUrl,
        //data: formData,
        dataType: 'html',
        success: function(data){
        	onCompleteRequest("outerDiv","class");
        	if(data!=''){
       			 $('#ot').html(data);
        	}
        },
		});
}

*/

//=== EOF Other Treatment ===
//=== significant Historys ===
$('#significantHistorys').click(function(){
	$.fancybox({
		
		'width' : '100%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			getSignificantHistory();
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "significantHistory",$patientId,$getElement['Person']['id'])); ?>",
				
		
	});
});

function getSignificantHistory() {
	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getSignificantHistory",$patientId,$getElement['Person']['id'],$id,$appointmentID,"admin" => false)); ?>";
        $.ajax({
        	beforeSend : function() {
        		loading("outerDiv","class");
          	},
        type: 'POST',
        url: ajaxUrl,
        //data: formData,
        dataType: 'html',
        success: function(data){
        	onCompleteRequest("outerDiv","class");
	        if(data!=''){
       			 $('#SH').html(data);
        	}
        },
		});
}



//=== EOF significant Historys ===

$('#interactive').click(function(){
	$.fancybox({
		'width' : '100%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick':false,
		'showCloseButton':true,
		'onClosed':function(){
			getvital();
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Nursings", "action" => "interactive_view",$patientId,'initialAssessment')); ?>",
	});
});

 	

 	$('#allergy').click(function(){

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
				getAllergy();
				getAllergyTop();
				//window.location.reload();
			},
			'href' : "<?php echo $this->Html->url(array("controller" =>"Diagnoses","action" =>"allallergies",$patientId,'null','null',$getElement['Person']['id'],"admin"=>false)); ?>"+'?controllerFlag=Diagnoses',
					
			
		});

	 	//$("html, body").animate({ scrollTop: 0 }, "slow");
	 	$(document).scrollTop(0);
	});

 	
 	function getAllergyTop() {
 		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getAllergyTop",$patientId,$getElement['Person']['id'],"admin" => false)); ?>";
 		 $.ajax({
	        	beforeSend : function() {
	            	//loading("outerDiv","class");
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        dataType: 'html',
	        success: function(data){
	        	//onCompleteRequest("outerDiv","class");
		        if(data!=''){
	       			 $('#topAllergy').html(data);
	       			 getMedicationHistory();
	        	}
	        },
	        error:function(){
	        	 getMedicationHistory();
	        }
			});
 	}

 	function getMedicationHistory() {
	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getMedicationHistory",$patientId,$patientUid['Patient']['patient_id'],$getElement['Person']['id'],$appointmentID,$diagnosesID,"admin" => false)); ?>";
        $.ajax({
        	beforeSend : function() {
            //	loading("outerDiv","class");
          	},
        type: 'POST',
        url: ajaxUrl,
        //data: formData,
        dataType: 'html',
        success: function(data){
        	//onCompleteRequest("outerDiv","class");
        	if(data!=''){
       			 $('#MA').html(data);
       			 getmedication();
        	}
        },
        error:function(){
        	getmedication();
        }
		});
	}

	function getmedication() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getMedication",$patientId,$patientUid['Patient']['patient_id'],$getElement['Person']['id'],$appointmentID,$diagnosesID,"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	           // 	loading("outerDiv","class");
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
	        	//onCompleteRequest("outerDiv","class");
	        	if(data!=''){
	       			 $('#CT').html(data);
	       			 medCount = $("#noMeddisable").val() ;
	      			 if(medCount > 0){ 
						 $("#medcheck").attr('disabled',true);
					 }else{
						 $("#medcheck").attr('disabled',false);
				 
		       			 if($("#noMedCheck").val()== 'yes'){ 
							 $("#medcheck").attr('checked',true);
						 }else if($("#noMedCheck").val()== 'no'){
							 $("#medcheck").attr('checked',false); 
						 } 
					 }
	        	}
	        	getAllergy();
	        },
	        error:function(){
	        	getAllergy();
	        }
			});
	}

function getAllergy() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getAllergy",$patientId,$getElement['Person']['id'],"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	            //	loading("outerDiv","class");
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
	        	//onCompleteRequest("outerDiv","class");
		        if(data!=''){
	       			 $('#allergyData').html(data);
	       			 $('#record').html()+1; 
	       			 allergyCount = $("#allergyCnt").val() ;
	       			 if(allergyCount > 0){ 
	       				 $("#allergycheck").attr('checked',false); 
						 $("#allergycheck").attr('disabled',true);
					 }else{
						 $("#allergycheck").attr('disabled',false);

						 if($("#noallergycheck").val()=='yes'){
				       			$("#allergycheck").attr('checked',true);
						 }else if($("#noallergycheck").val()=='no'){
								$("#allergycheck").attr('checked',false); 
						 } 
					 }
	        	}
	        	getvital();
	        },
	        error:function(){
	        	getvital();
	        }
			});
	}
	function getvital() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getvital",$patientId,$id,$getElement['Person']['id'],$appointmentID,"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	            	//loading("outerDiv","class");
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
	        	//onCompleteRequest("outerDiv","class");
	        	if(data!=''){
	       			 $('#vital').html(data);
	       			 getImunization();
	        	}
	        },
	        error:function(){
	        	getImunization();
	        }
			});
	}
 	function getImunization() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getImunization",$patientId,$personid['Patient']['person_id'],"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	            //	loading("outerDiv","class");
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
	        	//onCompleteRequest("outerDiv","class");
	        	if(data!=''){
	       			 $('#imu').html(data);
	       			 getSignificantHistory();
	        	}
	        },
	        error:function(){
	         getSignificantHistory();
	        }
			});
	}

//=== For Medication History ===	 
$('#medicationHistory').click(function(){	
	window.location.href = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "medicationHistory",$patientId,$id,$patientUid['Patient']['patient_id'],'null','null',$appointmentID,'?'=>array('patientId'=>$patientId))); ?>" ;
	
});

//=== EOF Medication History ===
 	function getvital() {
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "getvital",$patientId,$id,$getElement['Person']['id'],$appointmentID,"admin" => false)); ?>";
	        $.ajax({
	        	beforeSend : function() {
	            //	loading("outerDiv","class");
	          	},
	        type: 'POST',
	        url: ajaxUrl,
	        //data: formData,
	        dataType: 'html',
	        success: function(data){
	        	//onCompleteRequest("outerDiv","class");
	        	if(data!=''){
	       			 $('#vital').html(data);
	        	}
	        },
			});
	}
 	
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
    var sortorder={ items: items };  
    //Pass sortorder variable to server using ajax to save state  
   /* 
   var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "saveWidget","admin" => false)); ?>";
    $.post(ajaxUrl, 'data='+JSON.stringify(sortorder), function(response){  
        if(response=="success")  
            $("#console").html('<div class="success">Saved</div>').hide().fadeIn(1000);  
        setTimeout(function(){  
            $('#console').fadeOut(1000);  
        }, 2000);  
    });  */
}
</script>
<script type="text/javascript">
	 $(document).ready(function() {
		 $("#cc_id").validationEngine();
		 if($("#cc").val() == ""){
		 //	$("#cc").focus();
		 }
	 	$('.tooltip').tooltipster({
	 		interactive:true,
	 		position:"right",
	 	});
	 	$("#search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NoteTemplate","template_name",'null','null','null','template_type=all',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			setPlaceHolder : false
		});

	 	$("#icon_search").click( function(){
 			$('#wheel').toggle('slow');
			$('#cc').focusout();
		});
		$("#wheel").click( function(){
			var valWheel=$('#wheel option:selected').text();
			$('#search').val(valWheel);
			//$('#search').focus();
		});




		 

});
	

	 $('#soe').click(function(){
			
			$.fancybox({
				'width' : '80%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "systemicExamination",$patientId,$id)); ?>",
				'onClosed':function(){
					},
			});

			});

	 /*
		$('#soe').click(function(){
			$('#soe').addClass('active');
			$('#hpi').removeClass('active');
			$('#assessment').removeClass('active');
			$('#dam').removeClass('active');
			
			  var ajaxUrl = "<?php // echo $this->Html->url(array("controller" => "Diagnoses", "action" => "systemicExamination",$patientId,$id,"admin" => false)); ?>";
		        $.ajax({
		        	beforeSend : function() {
		        		loading('outerDiv','class');
		          	},
		        type: 'POST',
		        url: ajaxUrl,
		        //data: formData,
		        dataType: 'html',
		        success: function(data){
		        	onCompleteRequest('outerDiv','class');
				     $(".outerDiv").html(data);
		        },
				});
		
		});
		
		$('#hpi').click(function(){
			$('#hpi').addClass('active');
			$('#soe').removeClass('active');
			$('#assessment').removeClass('active');
			$('#dam').removeClass('active');
			
			  var ajaxUrl = "<?php // echo $this->Html->url(array("controller" => "Diagnoses", "action" => "hpiCall",$patientId,$id,"admin" => false)); ?>";
		        $.ajax({
		        	beforeSend : function() {
		        		loading('outerDiv','class');
		          	},
		        type: 'POST',
		        url: ajaxUrl,
		        //data: formData,
		        dataType: 'html',
		        success: function(data){
		        	
		        	onCompleteRequest('outerDiv','class');
				     $(".outerDiv").html(data);
				     
		        },
				});
			
		});*/
		$('#hpi').click(function(){
			
			$.fancybox({
				'width' : '90%',
				'height' : '90%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "hpiCall",$patientId,$id)); ?>",
				'onClosed':function(){
					},
			});

			});
		$('#assessment').click(function(){
			$('#assessment').addClass('active');
			$('#hpi').removeClass('active');
			$('#soe').removeClass('active');
			$('#dam').removeClass('active');
			
			  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "initialAssessment",$patientId,$id,"admin" => false)); ?>";
		        $.ajax({
		        	beforeSend : function() {
		        		loading('outerDiv','class');
		          	},
		        type: 'POST',
		        url: ajaxUrl,
		        //data: formData,
		        dataType: 'html',
		        success: function(data){ 
		        	onCompleteRequest('outerDiv','class');
				     $(".outerDiv").html(data); 
		        },
				});
			
		});

		$('#dam').click(function(){
			$('#dam').addClass('active');
			$('#soe').removeClass('active');
			$('#assessment').removeClass('active');
			$('#hpi').removeClass('active');
			
			  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "age_milestone",$patientId,'age_milestone',"admin" => false)); ?>";
		        $.ajax({
		        	beforeSend : function() {
		        		loading('outerDiv','class');
		          	},
		        type: 'POST',
		        url: ajaxUrl,
		        //data: formData,
		        dataType: 'html',
		        success: function(data){
		        	
		        	onCompleteRequest('outerDiv','class');
				     $(".outerDiv").html(data);
				     
		        },
				});
			
		});

		 
		

//*****************************************Search the title present************************************************************
$("#language").dblclick(function(){searchTemplate();});
		$("#search").keypress(function(e) {
   				 if(e.which == 13) {
    						searchTemplate();
    					}
				});
		$("#searchBtn").click(function() {	 
				searchTemplate();
	});
			function searchTemplate(){
				var serachText=$('#search').val();
				var serachText=serachText.split(' (');
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "getIntials","admin" => false)); ?>";
						$.ajax({  
				 			  type: "POST",						 		  	  	    		
							  url: ajaxUrl+"/"+serachText['0'],
							  beforeSend:function(){
						    		// this is where we append a loading image
						    		$('#busy-indicator').show('fast');
							  },					  		  
							  success: function(data){	
								 
							  var displayData=data.split('|~|');
								 
								  $('#showCheifComplaints').html(displayData[0]);
								  $('#showSignificantTests').html(displayData[1]);
								  
								  $('#busy-indicator').hide('slow');
								  //expandCollapseAll('expand_id');
							  }
						});
			}
			//********************************************EOF******************************************************************************
			//*****************************************Search the title present************************************************************
			/*
			
			function searchTemplate(){
				var serachText=$('#search').val();
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "getIntials","admin" => false)); ?>";
						$.ajax({  
				 			  type: "POST",						 		  	  	    		
							  url: ajaxUrl+"/"+serachText,
							  beforeSend:function(){
						    		// this is where we append a loading image
						    		$('#busy-indicator').show('fast');
							  },					  		  
							  success: function(data){	
							  var displayData=data.split('|~|');
								  
								  $('#subjectiveDisplay').html(displayData[0]);
								  $('#objectiveDisplay').html(displayData[1]);
								  $('#assessmentDisplay').html(displayData[2]);
								  $('#planDisplay').html(displayData[3]);
								  $('#busy-indicator').hide('slow');
							   		
							  }
						});
			}*/
			//********************************************EOF******************************************************************************
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
			 			  	$("#language").append( new Option($.trim(data),$.trim(data)) );
							  $('#busy-indicator').hide('slow');
							  $('#addTitle').val("");
							  $('#add-template-form').hide();
								//$('#flashMessage').show();
								//$('#flashMessage').html('Template Title Successfully Added.');
								inlineMsg("addTitleTd","Template Title Successfully Added.");
							  	
							  	
						  }
					});
				}
			});
			//*******************************************EOF********************************************************************************//
			/******************* Preferred Pharmacy Auto complete**********************/
			$("#pharmacy_value").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","PharmacyMaster",'Pharmacy_NCPDP',"Pharmacy_StoreName","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'pharmacy_value,pharmacy_id',
			onItemSelect:function () {
				if($( "#pharmacy_id" ).val() != '');
				$( "#pharmacy_id" ).trigger( "change" );
			}
		});
			/******************* EOF Preferred Pharmacy Auto complete**********************/	
			/******************* Health Plan for Formulatory Check Auto complete**********************/
			
			$("#insurance_company_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","InsuranceCompany","HealthplanSummaryID","name")); ?>"+'/'+'Status=A&'+'HealthplanSummaryID<>=""',
			 {
					width: 250,
					selectFirst: true,
					valueSelected:true,
					showNoId:true,
					loadId : 'insurance_company_name,patient_health_plan_id'
				
				});					
		$('#insurance_company_name').keydown(function(){
			$("#patient_health_plan_id").val('');	 
		});
			/******************* EOF Health Plan for Formulatory Check Auto complete**********************/	


$(".top-header-save").attr('type','image');
$(".top-header-save").attr('src',"<?php echo $this->Html->url('/theme/Black/img/icons/saveSmall.png')?>");  
//$(".top-header-save").css('border','border:0px');


$(document).ready(function() { 
	
	// $.APP.startTimer('sw');
    (function($){
    
        $.extend({
            
            APP : {                
                
                formatTimer : function(a) {
                    if (a < 10) {
                        a = '0' + a;
                    }                              
                    return a;
                },    
                
                startTimer : function(dir) {
                    
                    var a;
                    
                    // save type
                    $.APP.dir = dir;
                    
                    // get current date
                    $.APP.d1 = new Date();
                    
                    switch($.APP.state) {
                            
                        case 'pause' :
                            
                            // resume timer
                            // get current timestamp (for calculations) and
                            // substract time difference between pause and now
                            $.APP.t1 = $.APP.d1.getTime() - $.APP.td;                            
                            
                        break;
                            
                        default :
                            
                            // get current timestamp (for calculations)
                            $.APP.t1 = $.APP.d1.getTime(); 
                            
                            // if countdown add ms based on seconds in textfield
                            if ($.APP.dir === 'cd') {
                                $.APP.t1 += parseInt($('#cd_seconds').val())*1000;
                            }    
                        
                        break;
                            
                    }                                   
                    
                    // reset state
                    $.APP.state = 'alive';   
                    $('#' + $.APP.dir + '_status').html('Running');
                    
                    // start loop
                    $.APP.loopTimer();
                    
                },
                
                pauseTimer : function() {
                    
                    // save timestamp of pause
                    $.APP.dp = new Date();
                    $.APP.tp = $.APP.dp.getTime();
                    
                    // save elapsed time (until pause)
                    $.APP.td = $.APP.tp - $.APP.t1;
                    
                    // change button value
                    $('#' + $.APP.dir + '_start').val('Resume');
                    
                    // set state
                    $.APP.state = 'pause';
                    $('#' + $.APP.dir + '_status').html('Paused');
                    
                },
                
                stopTimer : function() {
                    
                    // change button value
                    $('#' + $.APP.dir + '_start').val('Restart');                    
                    
                    // set state
                    $.APP.state = 'stop';
                    $('#' + $.APP.dir + '_status').html('Stopped');
                    
                },
                
                resetTimer : function() {

                    // reset display
                    $('#' + $.APP.dir + '_ms,#' + $.APP.dir + '_s,#' + $.APP.dir + '_m,#' + $.APP.dir + '_h').html('00');                 
                    
                    // change button value
                    $('#' + $.APP.dir + '_start').val('Start');                    
                    
                    // set state
                    $.APP.state = 'reset';  
                    $('#' + $.APP.dir + '_status').html('Reset & Idle again');
                    
                },
                
                endTimer : function(callback) {
                   
                    // change button value
                    $('#' + $.APP.dir + '_start').val('Restart');
                    
                    // set state
                    $.APP.state = 'end';
                    
                    // invoke callback
                    if (typeof callback === 'function') {
                        callback();
                    }    
                    
                },    
                
                loopTimer : function() {
                    
                    var td;
                    var d2,t2;
                    
                    var ms = 0;
                    var s  = 0;
                    var m  = 0;
                    var h  = 0;
                    
                    if ($.APP.state === 'alive') {
                                
                        // get current date and convert it into 
                        // timestamp for calculations
                        d2 = new Date();
                        t2 = d2.getTime();   
                        
                        // calculate time difference between
                        // initial and current timestamp
                        if ($.APP.dir === 'sw') {
                            td = t2 - $.APP.t1;
                        // reversed if countdown
                        } else {
                            td = $.APP.t1 - t2;
                            if (td <= 0) {
                                // if time difference is 0 end countdown
                                $.APP.endTimer(function(){
                                    $.APP.resetTimer();
                                    $('#' + $.APP.dir + '_status').html('Ended & Reset');
                                });
                            }    
                        }    
                        
                        // calculate milliseconds
                        ms = td%1000;
                        if (ms < 1) {
                            ms = 0;
                        } else {    
                            // calculate seconds
                            s = (td-ms)/1000;
                            if (s < 1) {
                                s = 0;
                            } else {
                                // calculate minutes   
                                var m = (s-(s%60))/60;
                                if (m < 1) {
                                    m = 0;
                                } else {
                                    // calculate hours
                                    var h = (m-(m%60))/60;
                                    if (h < 1) {
                                        h = 0;
                                    }                             
                                }    
                            }
                        }
                      
                        // substract elapsed minutes & hours
                        ms = Math.round(ms/100);
                        s  = s-(m*60);
                        m  = m-(h*60);                             
                       // alert(m);
                        // update display
                        $('#' + $.APP.dir + '_ms').html($.APP.formatTimer(ms));
                        if(m < 5 ){
                             $('#' + $.APP.dir + '_s').css('color','green');
                             $('#' + $.APP.dir + '_m').css('color','green');
                        }
                        else if(m >5 ){
                        	 $('#' + $.APP.dir + '_s').css('color','orange');
                        	   $('#' + $.APP.dir + '_m').css('color','orange');
                        }
                        else if(m >10 ){
                        	 $('#' + $.APP.dir + '_s').css('color','red');
                        	   $('#' + $.APP.dir + '_m').css('color','red');
                        }
                        $('#' + $.APP.dir + '_s').html($.APP.formatTimer(s));
                        $('#' + $.APP.dir + '_m').html($.APP.formatTimer(m));
                        $('#' + $.APP.dir + '_h').html($.APP.formatTimer(h));

                        
                        // loop
                        $.APP.t = setTimeout($.APP.loopTimer,1);
                        var getM=$.APP.formatTimer(m);
                        
                    } else {
                    
                        // kill loop
                        clearTimeout($.APP.t);
                        return true;
                    
                    }  
                    
                }
                    
            }    
        
        });
          
       // $('#sw_start').on('click', function() {
            $.APP.startTimer('sw');
       // });    

        $('#cd_start').on('click', function() {
            $.APP.startTimer('cd');
        });           
        
        $('#sw_stop,#cd_stop').on('click', function() {
            $.APP.stopTimer();
        });
        
        $('#sw_reset,#cd_reset').on('click', function() {
            $.APP.resetTimer();
        });  
        
        $('#sw_pause,#cd_pause').on('click', function() {
            $.APP.pauseTimer();
        });  
         function start() {
            $.APP.startTimer('sw');
        }              
           
    })(jQuery);

    //ajax submission for 2nd chief complaints
    $("#Chiefcomplaint , #significantTestForm").submit(function(){
    	$.ajax({
			  type : "POST",
			  url: $(this).attr('action'), 
			  data:$(this).serialize(),
			  beforeSend:function(){
				  loading('outerDiv','class');
			  }, 	  		  
			  success: function(data){
				  $("#hidden_sure_cc_id").val(0);
	 			 onCompleteRequest('outerDiv','class');
			  }
		});
    });
            
});

		$('#patient_info').click(function(){
			$("#top_header").toggle();
		});
		$(function(){
			/*setInterval(function(){	 
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
			},60000);*/
			
			
		});
		

/***BOF No Active Allergy***/	
	function save_checkallergy(){
		if($('#allergycheck').prop('checked')) 
		{	var checkall=1;
		 	//$('#addAllergy').hide();
		}else{
		  	var checkall=0;
		  	//$('#addAllergy').show();
	    }
	patientid="<?php echo $patientId?>";
	patient_uid="<?php echo $personid['Patient']['person_id']?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "setNoActiveAllergy","admin" => false)); ?>";
	    $.ajax({
	     type: 'POST',
	     url: ajaxUrl+"/"+patientid+"/"+checkall+"/"+patient_uid,
	     //data: formData,
	     dataType: 'html',
	     success: function(data){
	    	 inlineMsg('allergycheck',"Saved Successfully.");
	    	 //alert(hello);
	     },
		 error: function(message){
	        alert(message);
	     }        
	   });
	}
/***EOF No Active Allergy***/
	
	
/***BOF No Active Medication***/	
	function save_checkmed(){
		if($('#medcheck').prop('checked')) 
		{	var checkmed=1;
		 	//$('#addMed').hide();
		}else{
		  	var checkmed=0;
		  	//$('#addMed').show();
	    }
	patientid="<?php echo $patientId?>";
	patient_uid="<?php echo $personid['Patient']['person_id']?>";
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "setNoActiveMed","admin" => false)); ?>";
	    $.ajax({
	     type: 'POST',
	     url: ajaxUrl+"/"+patientid+"/"+checkmed+"/"+patient_uid,
	     //data: formData,
	     dataType: 'html',
	     success: function(data){
	    	 inlineMsg('medcheck',"Saved Successfully.");
	    	 //alert(hello);
	     },
		 error: function(message){
	        alert(message);
	     }        
	   });
	}
/***EOF No Active Medication***/

/****BOF advance_search fancybox****/
	$('#advance_search').click(function(){
		$.fancybox({
			'width' : '90%',
			'height' : '90%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "advancePharmacySearch",$patientId)); ?>",
			'onClosed':function(){
				},
		});

	});

	$("#last_dose").datepicker(
		{
			showOn : "both",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange : '-50:+50',
			dateFormat : "<?php echo $this->General->GeneralDate();?>"

		});


	$('#dose_update').click(function(){
	 	$.ajax({
 			  type : "POST",
 			  url: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "lastDoseTaken",$patientId, "admin" => false)); ?>",
 			  context: document.body,
 			  data:$('#LastDoseForm').serialize(),
 			  beforeSend:function(){
 				  loading('outerDiv','class');
 			  }, 	  		  
 			  success: function(data){
	 			 onCompleteRequest('outerDiv','class');
 			  }
 		});
 	});
	

		//*********add/update cc**********
		$("#cc,#family_tit_bit,#family_tit_bit1,#family_tit_bit2,#flag_event").blur(function(){
			currentId = $(this).attr('id') ;
				 if(currentId == "cc"){
					 var oldData ='<?php echo str_replace("\r\n","",addslashes($getDiagnosisData['Diagnosis']['complaints'])); ?>';
	 			 }else if(currentId == "family_tit_bit"){
	 				var oldData ='<?php echo str_replace("\r\n","",addslashes($getDiagnosisData['Diagnosis']['family_tit_bit'])); ?>';
	 			 }else if(currentId == "family_tit_bit1"){
	 				var oldData ='<?php echo str_replace("\r\n","",addslashes($getDiagnosisData['Diagnosis']['family_tit_bit1'])); ?>';
	 			 }else if(currentId == "family_tit_bit2"){
	 				var oldData ='<?php echo str_replace("\r\n","",addslashes($getDiagnosisData['Diagnosis']['family_tit_bit2'])); ?>';
	 			 }else{
	 				var oldData='<?php echo str_replace("\r\n","",addslashes($getDiagnosisData['Diagnosis']['flag_event'])); ?>';
	 			 }
				if(currentId == "cc"){
					 if($('#'+currentId).val()==''){
							//$("#cc").focus();
							return false;
					 }
				}

			textAreaVal = $('#'+currentId).val() ;
			textAreaVal = textAreaVal.replace(/\r?\n/g, '');
			if(textAreaVal==oldData){
				return false;
			}else{
		 	$.ajax({
	 			  type : "POST",
	 			  url: "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "updateCC", "admin" => false)); ?>",
	 			  context: document.body,
	 			  data:$('#cc_id').serialize(), 
	 			  beforeSend:function(){
	 				  loading('top-header','class');
	 				 loading("outerDiv","class");
	 			  }, 	  		  
	 			  success: function(data){
         			
		 			onCompleteRequest('top-header','class');
		 			onCompleteRequest("outerDiv","class");
		 			 if(currentId == "cc"){
		 				inlineMsg(currentId,"Chief Complaints Saved");
		 				$("#hidden_sure_cc").val(0);
		 			 }else if(currentId == "family_tit_bit"){
		 				inlineMsg("family_tit_bit","Family Personal Notes Saved.");
		 				$("#hidden_sure_family_tit_bit").val(0);
		 			 }else if(currentId == "family_tit_bit1"){
		 				inlineMsg("family_tit_bit1","Family Personal Notes Saved.");
		 				
		 			 }else if(currentId == "family_tit_bit2"){
		 				inlineMsg("family_tit_bit2","Family Personal Notes Saved.");
		 				
		 			 }else{
		 				inlineMsg("flag_event","Chart Alert Notes Saved");
		 				$("#hidden_sure_flag_event").val(0);
		 			 }
		 			 
	 			  }
	 		});
			}
	 	});

		
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
		// Sync with NewCrop-Gullu
		$('.newCropSync').click(function(){
		var currentPersonID=$(this).attr('id');
		var currentPatientID=$(this).attr('patientId');
			$.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "newCropSync", "admin" => false)); ?>"+'/'+currentPersonID+'/'+currentPatientID,
				  context: document.body,
				  success: function(data){ 
					$("#busy-indicator").hide();
					alert('Sync successfully');
					//inlineMsg('#syncMsg','Sync successfully',10);
				  },
				  beforeSend:function(){
						$("#busy-indicator").show();
					  },		  
			});
		});
		// Sync with NewCrop-EOD
	$('.deleteType').click(function(){
		var cuurentId=$(this).attr('id');
		var txt;
		var r = confirm("Are you sure?");
		if (r == true) {
		    $.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "deletePharmacy", "admin" => false)); ?>"+'/'+cuurentId,
				  context: document.body,
				  success: function(data){ 
				  	if($.trim(data)=='updated'){
				  		$("#busy-indicator").hide();
				  		$("#showdetail").hide();
				  		$("#PharmacyShowDetail").html('Preferred Pharmacy :');
						alert('Deleted successfully');
				  	}else{
				  		$("#busy-indicator").hide();
						alert('Operation failed');
				  	}
				  },
				  beforeSend:function(){
						$("#busy-indicator").show();
					  },		  
			});
		} else {
		    return false;
		}
	});
	//****************************************Paycheck***********************************************************************
		function confirmInsurance(patientId,diagnosesId,appointmentID,pTariffStandardID,pPersonID) {
			if(pTariffStandardID=='437'){
				var chk=confirm('This Patient is Self Pay. Do you want to continue?');// check self pay
					if(chk==true){
						var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "updatePatientStatus","admin" => false)); ?>";
						$.ajax({
						  type: "POST",
						  url: ajaxUrl+'/'+patientId,
						  beforeSend:function(){
						  	$('#busy-indicator').show('fast');
						  },
						  success: function(data){
						  	$('#busy-indicator').hide('slow');
						  	window.location.href="<?php  echo $this->Html->url( array("controller" =>"Imunization","action" =>"add")); ?>"+"/"+patientId+'/null/null'+'/'+diagnosesId+"/"+appointmentID+'?pageView=ajax';
					  	  }
						});	
					}else{
						var insurance=confirm('Do you want to add insurance?');// Add insurance
							if(insurance==true){
								window.location.href =  "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "insuranceIndex")); ?>"+'/'+ patientId+'/?person_id='+pPersonID+"&backTo=IA/"+diagnosesId+"/"+appointmentID+"&expand=Immunizations";
							}else{
								
							}
					}
			}else{
				alert('Please Select Insurance');
				window.location.href =  "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "insuranceIndex")); ?>"+'/'+ patientId+'/?person_id='+pPersonID+"&backTo=IA/"+diagnosesId+"/"+appointmentID+"&expand=Immunizations";
			}

		}
		$("#nurseSubmit").click(function(){

			$.ajax({
	 			  type : "POST",
	 			  url: "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "updateCC", "admin" => false)); ?>",
	 			  context: document.body,
	 			  data:$('#NursingNotes').serialize(),
	 			  beforeSend:function(){
	 				  loading('top-header','class');
	 				 loading("outerDiv","class");
	 			  }, 	  		  
	 			  success: function(data){
	 				 $("#hidden_sure_nurse_id").val(0);
		 			 onCompleteRequest('top-header','class');
		 			onCompleteRequest("outerDiv","class");
		 			 	 			 
	 			  }
	 		});
		});

		/**/
		var unsaved = false;
		$("#cc").keyup(function(){ //trigers change in all input fields including text type
		    $("#hidden_sure_cc").val('1');
		});
		$("#family_tit_bit").keyup(function(){ //trigers change in all input fields including text type
		    $("#hidden_sure_family_tit_bit").val('1');
		});
		$("#flag_event").keyup(function(){ //trigers change in all input fields including text type
		    $("#hidden_sure_flag_event").val('1');
		});
		
		$("#subShow").keyup(function(){ //trigers change in all input fields including text type
		    $("#hidden_sure_cc_id").val('1');
		});
		$("#nursing_notes").keyup(function(){ //trigers change in all input fields including text type
		    $("#hidden_sure_nurse_id").val('1');
		});
		
		function unloadPage(){ 
			if($("#hidden_sure_cc").val() == 1 ){
		        return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
		    }
			if($("#hidden_sure_family_tit_bit").val() == 1 ){
		        return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
		    }
			if($("#hidden_sure_flag_event").val() == 1 ){
		        return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
		    }
		    if($("#hidden_sure_cc_id").val() == 1 ){
		        return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
		    }
		    if($("#hidden_sure_nurse_id").val() == 1){
		    	 return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
		    } 
		    
		}
		
		window.onbeforeunload = unloadPage;
		/**/
</script>
