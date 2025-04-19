<?php
	echo $this->Html->css(array('jquery.fancybox.css','jquery.autocomplete.css'));      
	echo $this->Html->script(array('jquery.fancybox','jquery.selection.js','jquery.blockUI','inline_msg','jquery.autocomplete'));
	echo $this->Html->script(array('soapMinJs001.min.js','inline_msg.js'));
	echo $this->Html->css(array('soapMin.min.css'));
?>
<style>
	.table_format{
		padding: 1px !important;
	}
	#mainContianer{
		width: 100%;
		background-color: #DDEBF9;
	}
	.subDiv{
		/*float: left;
		max-height: 500px;*/
		/*text-align: center;*/
	}
	#orderSet{
		background-color: #DDEBF9;
	}
	#servicesData{
		background-color: #DDEBF9;
	}
	#doctorNotes{
		background-color: #DDEBF9;
		
	}
	.subHead{ 
		text-align: left !important;
		font-style: italic;
		font-weight: bold;
		padding: 10px;
	}
	.row_title td {
	    background: #d2ebf2 none repeat scroll 0 0 !important;
	    border-bottom: 1px solid #3e474a;
	    color: #31859c !important;
	}
	.tdOrders{
		background-color: #42647F !important;
	    font-size: 15px !important;
	    max-width: 25% !important;
	    padding: 5px !important;
	    text-align: center !important;
	    color: #fff !important;
	}

	.tabs input[type=radio] {
	position: absolute;
	top: -9999px;
	left: -9999px;
	}
	.tabs {
	width: 100%;
	float: none;
	list-style: none;
	position: relative;
	padding: 0;
	}

	.tabs label {
	display: block;
	padding: 10px 20px;
	border-radius: 10px 10px 0 0;
	color: #08C;
	font-size: 24px;
	font-weight: normal;
	font-family: 'Lily Script One', helveti;
	background: rgba(255,255,255,0.2);
	cursor: pointer;
	position: relative;
	top: 3px;
	text-align: center;
	-webkit-transition: all 0.2s ease-in-out;
	-moz-transition: all 0.2s ease-in-out;
	-o-transition: all 0.2s ease-in-out;
	transition: all 0.2s ease-in-out;
	}

	.tabs label:hover {
	background: rgba(255,255,255,0.5);
	background-color: #9FC4FF;
	top: 0;
	}

	[id^=tab]:checked + label {
	background: #4279E1;
	color: white !important;
	top: 0;
	}

	[id^=tab]:checked ~ [id^=tab-content] {
		display: block;
	}
	.tab-content{
	/*z-index: 2;*/
	display: none;
	text-align: left;
	width: 100%;
	font-size: 20px;
	line-height: 140%;
	padding-top: 10px;
	background: #DBEAF9;
	padding: 15px;
	/*color: white;*/
	position: absolute;
	/*top: 53px;*/
	left: 0;
	border-radius: 0px 10px 10px 10px;
	box-sizing: border-box;
	-webkit-animation-duration: 0.5s;
	-o-animation-duration: 0.5s;
	-moz-animation-duration: 0.5s;
	animation-duration: 0.5s;
	}
	ul.tabs li {
	    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
	    cursor: pointer;
	    display: inline-block;
	    padding: 0px 0px !important;
	}



		label {
		    color: #000 ;
		    float: none !important;
		    font-size: 13px;
		    margin-right: 10px;
		    padding-top: 7px;
		    text-align: right;
		    width: none !important;
		    cursor: pointer;
		}
		 
		#msg{
		 	 background:light-green;
			 padding:7px 5px;
			 border:1px solid #e8d495;
			 font-size:13px;  
			 color:black;
			 font-weight:bold;
			 text-shadow:1px 1px 1px #ecdca8;
			 margin: 5px 0;
			 display:block;
			 left: 40%;
		     margin: 0 auto;
		     padding: 5px 10px 5px 18px;
		     position: absolute;
		     top: 0;
		     z-index: 2000;
		}


		.preLink{
			color:indigo !important;
		}

		.cursor{
			cursor: pointer;
		}


		.spNoteTextArea {
			width:100% !important;
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
			color: yellow;
		}
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
		.bgTitle{
			background-color: #96CDCD !important;
			color: white !important;
		}
		.jrHead{
			background-color: #96CDCD;
			text-align: left;
			color: white;
		}	
</style>
  <div class="inner_title">
	<h3>
		<?php echo __('Orders Information');?>
		<span style='text-align: right; padding-top: 15px'>
			<?php 
				echo $this->Html->link(__('Back'), array('controller'=>'Users','action' => 'doctor_dashboard'), array('escape' => false,'class'=>'blueBtn'));

				if($this->Session->read('roleid')!=Configure::read('nurseId')){echo $this->Html->link(__('Add Order'),'#',array('onclick'=>'getPackage("'.$patient_id.'")','class'=>'blueBtn','div'=>false,'label'=>false));}
			?>
		</span>
	</h3>
</div>
<div style="width:50%;margin:10px;" id="">
	<table width="100%" class="formFull formFullBorder" style="background-color:#42647F;" >
		<tr>
			<td width="10%" align="right"><b><font color="#fff"><?php echo __('Name :')?></font></b></td>
			<td align="left"><font color="#fff"><?php echo $admission_type['Patient']['lookup_name'];?></font>
			</td>
			<td width="10%" align="right"><b><font color="#fff"><?php echo __('Gender :')?></font> </b></td>
			<td align="left"><font color="#fff"><?php echo ucfirst($admission_type['Person']['sex']);?></font>
			</td>
			<td width="10%" align="right"><b><font color="#fff"><?php echo __('DOB :')?></font> </b></td>
			<td align="left"><font color="#fff"><?php echo date("F d, Y", strtotime($admission_type['Person']['dob']));?></font>
			</td>
			<td width="10%" align="right"><b><font color="#fff"><?php echo __('Visit ID :')?></font> </b></td>
			<td align="left"><font color="#fff"><?php echo $admission_type['Patient']['admission_id'];?></font>
			</td>

		</tr>
	</table>
  </div>
  <div class="outerDivNew">
	 <div style="width:100%">
		 <div >
			<ul class="tabs">
		        <li>
		          <input type="radio" checked name="tabs" id="tab1">
		          <label for="tab1">OrderSet</label>
		          <div id="tab-content1" class="tab-content animated fadeIn">
		    		<table id="mainContianer">
						<tr>
							<td width="50%" valign="top">
								<table width="100%" border="0" id="orderSet" class="subDiv">
									<tr>
									<?php if($setCount<1){?>	
										<td width="95%" valign="top">
										<font style="font-family:Arial,Helvetica,sans-serif;font-style:italic;color:#42647F">No records added...</font>
										</td>
									<?php }else{?>
										<td width="95%" valign="top">
											<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" >
												<tr class="" >
													<td class="tdOrders" width="10%" >
														<strong>
															<?php echo __('');?>
														</strong>
													</td>
													<td class="tdOrders" width="40%">
														<strong>
															<?php echo __('Order Name');?>
														</strong>
													</td>
													<td class="tdOrders" width="10%">
														<strong>
															<?php echo __('Status'); ?>
														</strong>
													</td>
													<td class="tdOrders" width="50%">
														<strong>
															<?php echo  __('Details'); ?>
														</strong>
													</td>
											</tr>
											<?php 
												$i=0;
												foreach($setdata as $setdatas){			
									       		$cnt_order=count($setdatas['PatientOrder']);
									            if($cnt_order!=0){
									           		if($setdatas['OrderCategory']['order_description']=='Lab'){
									           				$subName="lab";
									           			}elseif($setdatas['OrderCategory']['order_description']=='Diagnostic Test'){
									           				$subName="rad";
									           			}elseif ($setdatas['OrderCategory']['order_description']=='Medication') {
									           				$subName="med";
									           			}
									        ?>
											<tr>
												<td class="table_cell jrHead" colspan='4' >
													<strong>
														<?php 
															echo $setdatas['OrderCategory']['order_description'];
														?>
													</strong>
													<?php 
														if($setdatas['OrderCategory']['order_description']=="Medication"){
															echo $this->Form->checkbox('',array('name'=>'reconcilecheck','id'=>'reconcilecheck','checked'=>$reconchecked,'onclick'=>'javascript:save_reconcilecheck();','disabled'=>$disabled1,'title'=>"Reconcile Medication"));
														}?>
														<span id="reconcileMsg"></span>
												</td>
											</tr>
											<?php }
												$j=0;
												for($i=0;$i<count($setdatas['PatientOrder']);$i++){
													$trIDMain='Tr_'.$subName.'_'.$setdatas['PatientOrder'][$i]['id'];
													$checkID='check_'.$subName.'_'.$setdatas['PatientOrder'][$i]['id'];
													if($i%2=='0'){
														$class="background-color:grey";
													}else{
														$class="background-color:#fff";
													}
											?>
											<tr id='<?php echo $trIDMain;?>' style="background-color: white;">
												<?php 
													if(($setdatas['PatientOrder'][$i]['status'])=='Ordered'){
														$orderchecked='checked';
														$disabled='';
													}
													elseif(($setdatas['PatientOrder'][$i]['status'])=='Cancelled'){
														$orderchecked='';
														$disabled='';
													}
													else{
														$orderchecked='';
														$disabled='disabled=disabled';
													}
												?>
												<?php $trID=$subName.'_'.$setdatas['PatientOrder'][$i]['id'];?>
												<td style="border-bottom:1px solid #000">
													<?php echo $this->Form->checkbox('checkSataus',
														array('name'=>'checkSataus','class'=>'chkStatus','id'=>$checkID,$disabled,'checked'=>$orderchecked,$ischkdisable,'onclick'=>'update_patient_record("'.$setdatas['PatientOrder'][$i]['patient_id'].'","'.$setdatas['PatientOrder'][$i]['id'].'",this.id,"'.$setdatas['PatientOrder'][$i]['type'].'")'));
													 ?>
												</td>
												<td style="border-bottom:1px solid #000">
													<a href="#formdisplayid" onclick="javascript:display_formdisplay('<?php echo $trID;?>',<?php echo $patient_id?>,<?php echo $setdatas['PatientOrder'][$i]['id']?>,'<?php echo $setdatas[PatientOrder][$i][type]?>','ipd')"><?php echo __($setdatas['PatientOrder'][$i]['name']);?>
													</a>
												</td>
												<td style="border-bottom:1px solid #000"><span id="update_<?php echo $trID?>">
													<?php echo __($setdatas['PatientOrder'][$i]['status']); ?></span>
												</td>
												<td style="border-bottom:1px solid #000">
													<?php echo __(rtrim($setdatas['PatientOrder'][$i]['sentence'],", ")); ?>
												</td>
											</tr>
											<?php } }
													unset($cnt_order);
											?>
										</table> <?php }?>
										</td>
										</tr>
										<?php if(empty($setdata)){?>
										<tr>
											<td colspan="4" align="center"><b><?php echo __("No record added...");?></b></td>
										</tr>
										<?php }?>
								</table>	
							</td>
							<td width="50%" valign="top">
								<table id="doctorNotes" class="subDiv" width="100%">
									<tr>
										<td width="100%">
											<div style="height: 550px;overflow-x:hidden;">
												<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
													<tr>
								           				<td class="tdOrders" style="align:left;" colspan="4"><b>Vitals Record</b></td>
								           			</tr>
													<tr class="tdOrders">
														<td class="jrHead">Temperature</td>
														<td class="jrHead">Respiration</td>
														<td class="jrHead">Blood Presure</td>
														<td class="jrHead">Heart Rate</td>
													</tr>
													<?php if(isset($allViewData['vitalsResult']) && !empty($allViewData['vitalsResult'])){
													 	?>
													<tr>
														<td><?php echo __($allViewData['vitalsResult']['BmiResult']['temperature']." ".$allViewData['vitalsResult']['BmiResult']['myoption']);?></td>
														<td><?php echo __($allViewData['vitalsResult']['BmiResult']['respiration'] ." Breaths per minute");?></td>
														<td><?php echo __($allViewData['vitalsResult']['BmiBpResult']['systolic']."/".$allViewData['vitalsResult']['BmiBpResult']['diastolic']." mmHg");?></td>
														<td><?php echo __($allViewData['vitalsResult']['BmiBpResult']['pulse_text']." Beats per minute");?></td>
													</tr>
													<?php }?>
												</table>
							            		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
													<tr>
								           				<td class="tdOrders" style="align:left;" colspan="2"><b>Diagnosis</b></td>
								           			</tr>
													<tr class="tdOrders">
														<td class="jrHead">Diagnosis Name</td>
														<td class="jrHead">Status</td>
													</tr>
													<?php if(isset($allViewData['problem']) && !empty($allViewData['problem'])){
													 	foreach($allViewData['problem'] as $pData){?>
													<tr>
														<td><?php echo __($pData['NoteDiagnosis']['diagnoses_name']);?></td>
														<td><?php echo __($pData['NoteDiagnosis']['disease_status']);?></td>
													</tr>
													<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
												</table>
												<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
								           			<tr>
								           				<td class="tdOrders" style="align:left;" colspan="2"><b>Medication</b></td>
								           			</tr>
								           			<tr>
								           				<td class="jrHead">Medication Name</td>
								           				<td class="jrHead">Medication Order Date</td>
								           			</tr>
								           			<?php if(isset($allViewData['med']) && !empty($allViewData['med'])){
								           				foreach($allViewData['med'] as $meddata){?>
								           			<tr>
								           				<td><?php echo $meddata['NewCropPrescription']['description']?></td>
								           				<td><?php echo date('m/d/Y',strtotime($meddata['NewCropPrescription']['created']));?></td>
								           			</tr>
								           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
								           		</table>
								           		<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
								           			<tr>
								           				<td class="tdOrders" style="align:left;" colspan="3"><b>Allergy</b></td>
								           			</tr>
								           			<tr>
								           				<td class="jrHead">Allergy Name</td>
								           				<td class="jrHead">Allergy Severity</td>
								           				<td class="jrHead">Allergy Order Date</td>
								           			</tr>
								           			<?php if(isset($allViewData['allergy']) && !empty($allViewData['allergy'])){
								           				foreach($allViewData['allergy'] as $allerdata){?>
								           			<tr>
								           				<td><?php echo $allerdata['NewCropAllergies']['name']?></td>
								           				<td><?php echo $allerdata['NewCropAllergies']['AllergySeverityName']?></td>
								           				<td><?php echo date('m/d/Y',strtotime($allerdata['NewCropAllergies']['created']));?></td>
								           			</tr>
								           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
								           		</table>
								           		<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
								           			<tr>
								           				<td class="tdOrders" style="align:left;" colspan="2"><b>Labs</b></td>
								           			</tr>
								           			<tr>
								           				<td class="jrHead">Lab Name</td>
								           				<td class="jrHead">Lab Order Date</td>
								           			</tr>
								           			<?php if(isset($allViewData['labs']) && !empty($allViewData['labs'])){
								           				foreach($allViewData['labs'] as $labdata){?>
								           			<tr>
								           				<td><?php echo $labdata['Laboratory']['name']?></td>
								           				<td><?php echo date('m/d/Y',strtotime($labdata['LaboratoryTestOrder']['start_date']));?></td>
								           			</tr>
								           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
								           		</table>
								           		<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
								           			<tr>
								           				<td class="tdOrders" style="align:left;" colspan="2"><b>Radiology</b></td>
								           			</tr>
								           			<tr>
								           				<td class="jrHead">Radiology Name</td>
								           				<td class="jrHead">Radiology Order Date</td>
								           			</tr>
								           			<?php if(isset($allViewData['rad']) && !empty($allViewData['rad'])){
								           				foreach($allViewData['rad'] as $labdata){?>
								           			<tr>
								           				<td><?php echo $labdata['Radiology']['name']?></td>
								           				<td><?php 
								           				$labdata['RadiologyTestOrder']['start_date']=isset($labdata['RadiologyTestOrder']['start_date'])?$labdata['RadiologyTestOrder']['start_date']:$labdata['RadiologyTestOrder']['radiology_order_date'];
								           				echo date('m/d/Y',strtotime($labdata['RadiologyTestOrder']['start_date']));?></td>
								           			</tr>
								           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
								           		</table>
			           						</div>
										</td>
									</tr>
								</table>
								<table id="servicesData" class="subDiv" style="cursor:pointer;display:none;">
									<tr>
										<td>
											<table>
												<tr>
													<td>
														<span style="cursor:pointer;display: none" id="switchTwo">
															<i>
																<?php echo __("Add Services");?>
															</i>
														</span>
													</td>
												</tr>
												<tr>
													<td id="servicesDataLoad" style="display: none;"></td>
												</tr>
											</table>
										</td>
									</tr>
								</table>	
							</td>
						</tr>
						<?php //<!-- diplay table orders --> ?>
						<tr>
							<td colspan="2" id="formdisplayid" width="50%" style="margin-top: 10px"></td>
						</tr>
					</table>
		          </div>
		        </li>
		        <li>
		          <input type="radio" name="tabs" id="tab2">
		          <label for="tab2">Notes</label>
		          <div id="tab-content2" class="tab-content animated fadeIn">
			           <table class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%" style="border-radius: 5px;">
			           <tr>
			           	<td width="40%" valign="top">
			           		<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
			           			<tr>
			           			<td class="tdOrders bgTitle" id="cN" ><?php echo __("Clinical Notes");?></td>
			           			<td class="tdOrders" id="preN"><?php echo __("Pre-op Notes");?></td>
			           			<td class="tdOrders" id="postN"><?php echo __("Post-op Notes");?></td>
			           			<td class="tdOrders" id="sN"><?php echo __("Surgical Notes");?></td>
			           			<td class="tdOrders" id="aN"><?php echo __("Anesthesia Notes");?></td>
				           		</tr>
				           		<tr> 
	           						<td colspan="5" id="cNView">
	           							<table>
											<tr>
												<td>
													<table>
														<tr id="sHide">
															<td>
																<?php
																 	echo $this->Form->input('',array('type'=>'text', 'style'=>'','label'=>false,'id'=>'search','placeholder'=>'Search Template'));
																?>
															</td>
															<td>
																<?php 
																	echo $this->Html->link($this->Html->image('/img/icons/folderSearch.png'),'javascript:void(0)',array('escape'=>false,'id'=>'searchBtn','title'=>'Search','alt'=>'Search','style'=>"padding-top:15px"));
																?>
															</td>
															<td>
																<table border="0" style="display: none" id="wheel">
																 <tr>
																  <td class="gradient_img" style="padding: 10px;">
																   <table border="0">
																    <tr>
																     <td class="black_white" style="padding: 5px 10px 10px; font-size: 11px;">
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
															<td>
																
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>

										<?php //template load section ?>
										<table width="90%">
											<tr>
												<td width="100%" id="loadTemplate"></td>
											</tr>
										</table>
										<?php //Eod ?>

										<?php //<!--save doctor Templates  --> ?>
										<table width="90%">
											<tr>
												<td>
													<?php echo __("Notes recorded on:");?>
												</td>
											</tr>
										</table>
											<div style="width: 250px;overflow-y:hidden;">
												<table width="90%">
													<tr class="dateNote" style="font-family: Arial,Helvetica,sans-serif;"> 
													<?php 
													foreach($noteData as $key=>$data){?>
																<td>
																<?php
																	if($key=='0'){
																		echo $this->Html->link(__(date('m/d/Y',strtotime($data['Note']['note_date']))),'javascript:void(0)', array('escape' => false,'class'=>'copyData','id'=>$data['Note']['cc'],'current'=>'yes'));
																	}else{
																		echo $this->Html->link(__(date('m/d/Y',strtotime($data['Note']['note_date']))),'javascript:void(0)', array('escape' => false,'class'=>'copyData','id'=>$data['Note']['cc']));
																	}
																		
																?>
																</td>
															
														
													
													<?php }?>
													</tr>
												</table>
											</div>
											<table width="90%">
											<tr>
												<td id="saveMsg"></td>
											</tr>
											<tr>
												<td>
													<?php 
														echo $this->Form->input('cc',array('type'=>'textArea','id'=>'cc','label'=>false, 'style'=>"width: 594px; height: 122px;",'value'=>$currentDayNotes['cc']));
														echo $this->Form->hidden('id',array('type'=>'text','id'=>'note_id','label'=>false,'value'=>$currentDayNotes['id']));
													?>
												</td>
											</tr>
											<tr>
												<td>
													<?php echo $this->Form->input('Submit',array('type'=>'button','class'=>'blueBtn','label'=>false,'id'=>'saveNotes'));?>
												</td>
											</tr>
										</table>
										<?php //Eod ?>
	           						</td>
	           						<td valign="top" colspan="5" id="preNView" style="display: none"></td>
	           						<td valign="top" colspan="5" id="postNView" style="display: none"></td>
	           						<td valign="top" colspan="5" id="sNView" style="display: none"><?php echo "4";?></td>
	           						<td valign="top" colspan="5" id="aNView" style="display: none"><?php echo "5";?></td>
	           					</tr>
			           		</table>
			           	</td>
			           	<td width="40%" valign="top">
				           		<div style="height: 550px;overflow-x:hidden;">
				           		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
													<tr>
								           				<td class="tdOrders" style="align:left;" colspan="4"><b>Vitals Record</b></td>
								           			</tr>
													<tr class="tdOrders">
														<td class="jrHead">Temperature</td>
														<td class="jrHead">Respiration</td>
														<td class="jrHead">Blood Presure</td>
														<td class="jrHead">Heart Rate</td>
													</tr>
													<?php if(isset($allViewData['vitalsResult']) && !empty($allViewData['vitalsResult'])){
													 	?>
													<tr>
														<td><?php echo __($allViewData['vitalsResult']['BmiResult']['temperature']." ".$allViewData['vitalsResult']['BmiResult']['myoption']);?></td>
														<td><?php echo __($allViewData['vitalsResult']['BmiResult']['respiration'] ." Breaths per minute");?></td>
														<td><?php echo __($allViewData['vitalsResult']['BmiBpResult']['systolic']."/".$allViewData['vitalsResult']['BmiBpResult']['diastolic']." mmHg");?></td>
														<td><?php echo __($allViewData['vitalsResult']['BmiBpResult']['pulse_text']." Beats per minute");?></td>
													</tr>
													<?php }?>
												</table>
			            		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
									<tr>
				           				<td class="tdOrders" style="align:left;" colspan="2"><b>Diagnosis</b></td>
				           			</tr>
									<tr class="tdOrders">
										<td class="jrHead">Diagnosis Name</td>
										<td class="jrHead">Status</td>
									</tr>
									<?php if(isset($allViewData['problem']) && !empty($allViewData['problem'])){
									 	foreach($allViewData['problem'] as $pData){?>
									<tr>
										<td><?php echo __($pData['NoteDiagnosis']['diagnoses_name']);?></td>
										<td><?php echo __($pData['NoteDiagnosis']['disease_status']);?></td>
									</tr>
									<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
								</table>
								<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
				           			<tr>
				           				<td class="tdOrders" style="align:left;" colspan="2"><b>Medication</b></td>
				           			</tr>
				           			<tr>
				           				<td class="jrHead">Medication Name</td>
				           				<td class="jrHead">Medication Order Date</td>
				           			</tr>
				           			<?php if(isset($allViewData['med']) && !empty($allViewData['med'])){
				           				foreach($allViewData['med'] as $meddata){?>
				           			<tr>
				           				<td><?php echo $meddata['NewCropPrescription']['description']?></td>
				           				<td><?php echo date('m/d/Y',strtotime($meddata['NewCropPrescription']['created']));?></td>
				           			</tr>
				           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
				           		</table>
				           		<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
				           			<tr>
				           				<td class="tdOrders" style="align:left;" colspan="3"><b>Allergy</b></td>
				           			</tr>
				           			<tr>
				           				<td class="jrHead">Allergy Name</td>
				           				<td class="jrHead">Allergy Severity</td>
				           				<td class="jrHead">Allergy Order Date</td>
				           			</tr>
				           			<?php if(isset($allViewData['allergy']) && !empty($allViewData['allergy'])){
				           				foreach($allViewData['allergy'] as $allerdata){?>
				           			<tr>
				           				<td><?php echo $allerdata['NewCropAllergies']['name']?></td>
				           				<td><?php echo $allerdata['NewCropAllergies']['AllergySeverityName']?></td>
				           				<td><?php echo date('m/d/Y',strtotime($allerdata['NewCropAllergies']['created']));?></td>
				           			</tr>
				           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
				           		</table>
				           		<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
				           			<tr>
				           				<td class="tdOrders" style="align:left;" colspan="2"><b>Labs</b></td>
				           			</tr>
				           			<tr>
				           				<td class="jrHead">Lab Name</td>
				           				<td class="jrHead">Lab Order Date</td>
				           			</tr>
				           			<?php if(isset($allViewData['labs']) && !empty($allViewData['labs'])){
				           				foreach($allViewData['labs'] as $labdata){?>
				           			<tr>
				           				<td><?php echo $labdata['Laboratory']['name']?></td>
				           				<td><?php echo date('m/d/Y',strtotime($labdata['LaboratoryTestOrder']['start_date']));?></td>
				           			</tr>
				           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
				           		</table>
				           		<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
				           			<tr>
				           				<td class="tdOrders" style="align:left;" colspan="2"><b>Radiology</b></td>
				           			</tr>
				           			<tr>
				           				<td class="jrHead">Radiology Name</td>
				           				<td class="jrHead">Radiology Order Date</td>
				           			</tr>
				           			<?php if(isset($allViewData['rad']) && !empty($allViewData['rad'])){
				           				foreach($allViewData['rad'] as $labdata){?>
				           			<tr>
				           				<td><?php echo $labdata['Radiology']['name']?></td>
				           				<td><?php
				           				$labdata['RadiologyTestOrder']['start_date']=isset($labdata['RadiologyTestOrder']['start_date'])?$labdata['RadiologyTestOrder']['start_date']:$labdata['RadiologyTestOrder']['radiology_order_date']; 
				           				echo date('m/d/Y',strtotime($labdata['RadiologyTestOrder']['start_date']));?></td>
				           			</tr>
				           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
				           		</table>
			           		</div>
			           	</td>
			           </tr>
			           	</table>
				   </div>
		        </li>
		        <li>
		          <input type="radio" name="tabs" id="tab3">
		          <label for="tab3" id="assessmentTab">Services</label>
		          <div id="tab-content3" class="tab-content animated fadeIn">
		            <div id="assessmentTable">
		            <table width="100%">
		            	<tr>
		            		<td id="serviceHtml" width="50%" valign="top">
		            			
		            		</td>
		            		<td width="50%">
		            		<div style="height: 844px;overflow-x:hidden;">
		            			<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
													<tr>
								           				<td class="tdOrders" style="align:left;" colspan="4"><b>Vitals Record</b></td>
								           			</tr>
													<tr class="tdOrders">
														<td class="jrHead">Temperature</td>
														<td class="jrHead">Respiration</td>
														<td class="jrHead">Blood Presure</td>
														<td class="jrHead">Heart Rate</td>
													</tr>
													<?php if(isset($allViewData['vitalsResult']) && !empty($allViewData['vitalsResult'])){
													 	?>
													<tr>
														<td><?php echo __($allViewData['vitalsResult']['BmiResult']['temperature']." ".$allViewData['vitalsResult']['BmiResult']['myoption']);?></td>
														<td><?php echo __($allViewData['vitalsResult']['BmiResult']['respiration'] ." Breaths per minute");?></td>
														<td><?php echo __($allViewData['vitalsResult']['BmiBpResult']['systolic']."/".$allViewData['vitalsResult']['BmiBpResult']['diastolic']." mmHg");?></td>
														<td><?php echo __($allViewData['vitalsResult']['BmiBpResult']['pulse_text']." Beats per minute");?></td>
													</tr>
													<?php }?>
												</table>
			            		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
									<tr>
				           				<td class="tdOrders" style="align:left;" colspan="2"><b>Diagnosis</b></td>
				           			</tr>
									<tr class="tdOrders">
										<td class="jrHead">Diagnosis Name</td>
										<td class="jrHead">Status</td>
									</tr>
									<?php if(isset($allViewData['problem']) && !empty($allViewData['problem'])){
									 	foreach($allViewData['problem'] as $pData){?>
									<tr>
										<td><?php echo __($pData['NoteDiagnosis']['diagnoses_name']);?></td>
										<td><?php echo __($pData['NoteDiagnosis']['disease_status']);?></td>
									</tr>
									<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
								</table>
								<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
				           			<tr>
				           				<td class="tdOrders" style="align:left;" colspan="2"><b>Medication</b></td>
				           			</tr>
				           			<tr>
				           				<td class="jrHead">Medication Name</td>
				           				<td class="jrHead">Medication Order Date</td>
				           			</tr>
				           			<?php if(isset($allViewData['med']) && !empty($allViewData['med'])){
				           				foreach($allViewData['med'] as $meddata){?>
				           			<tr>
				           				<td><?php echo $meddata['NewCropPrescription']['description']?></td>
				           				<td><?php echo date('m/d/Y',strtotime($meddata['NewCropPrescription']['created']));?></td>
				           			</tr>
				           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
				           		</table>
				           		<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
				           			<tr>
				           				<td class="tdOrders" style="align:left;" colspan="3"><b>Allergy</b></td>
				           			</tr>
				           			<tr>
				           				<td class="jrHead">Allergy Name</td>
				           				<td class="jrHead">Allergy Severity</td>
				           				<td class="jrHead">Allergy Order Date</td>
				           			</tr>
				           			<?php if(isset($allViewData['allergy']) && !empty($allViewData['allergy'])){
				           				foreach($allViewData['allergy'] as $allerdata){?>
				           			<tr>
				           				<td><?php echo $allerdata['NewCropAllergies']['name']?></td>
				           				<td><?php echo $allerdata['NewCropAllergies']['AllergySeverityName']?></td>
				           				<td><?php echo date('m/d/Y',strtotime($allerdata['NewCropAllergies']['created']));?></td>
				           			</tr>
				           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
				           		</table>
				           		<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
				           			<tr>
				           				<td class="tdOrders" style="align:left;" colspan="2"><b>Labs</b></td>
				           			</tr>
				           			<tr>
				           				<td class="jrHead">Lab Name</td>
				           				<td class="jrHead">Lab Order Date</td>
				           			</tr>
				           			<?php if(isset($allViewData['labs']) && !empty($allViewData['labs'])){
				           				foreach($allViewData['labs'] as $labdata){?>
				           			<tr>
				           				<td><?php echo $labdata['Laboratory']['name']?></td>
				           				<td><?php echo date('m/d/Y',strtotime($labdata['LaboratoryTestOrder']['start_date']));?></td>
				           			</tr>
				           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
				           		</table>
				           		<table  class="table_format" cellspacing="0" cellpadding="0" border="0" width="100%">
				           			<tr>
				           				<td class="tdOrders" style="align:left;" colspan="2"><b>Radiology</b></td>
				           			</tr>
				           			<tr>
				           				<td class="jrHead">Radiology Name</td>
				           				<td class="jrHead">Radiology Order Date</td>
				           			</tr>
				           			<?php if(isset($allViewData['rad']) && !empty($allViewData['rad'])){
				           				foreach($allViewData['rad'] as $labdata){?>
				           			<tr>
				           				<td><?php echo $labdata['Radiology']['name']?></td>
				           				<td><?php 
				           					$labdata['RadiologyTestOrder']['start_date']=isset($labdata['RadiologyTestOrder']['start_date'])?$labdata['RadiologyTestOrder']['start_date']:$labdata['RadiologyTestOrder']['radiology_order_date'];
				           				echo date('m/d/Y',strtotime($labdata['RadiologyTestOrder']['start_date']));?></td>
				           			</tr>
				           			<?php }echo '<td><?php echo __("No records added...");?></td>';}?>
				           		</table>
			           		</div>
		            		</td>
		            	</tr>
		            </table>
		            </div>
		          </div>
		        </li>
		        <!-- <li>
		          <input type="radio" name="tabs" id="tab4">
		          <label for="tab4" id='planTab'>Plan</label>
		          <div id="tab-content4" class="tab-content animated fadeIn">
		          </div>
		        </li>
		      -->
			</ul>
		 </div>
  	  </div>
 </div> 
<script>
	/*Order Set*/
	function display_formdisplay(trID,patient_id,patient_order_id,patient_order_type,type){	
	$('#formdisplayid').show();
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "displayorderform","admin" => false)); ?>";
	  
	   var formData = $('#patientnotesfrm').serialize();
         $.ajax({	
        	 beforeSend : function() {
        		// this is where we append a loading image
        		$('#busy-indicator').show('fast');
        		},
        		                           
          type: 'POST',
         url: ajaxUrl+"/"+patient_id+"/"+patient_order_id+"/"+patient_order_type+"/?trId="+trID+"&type=IPD",
          data: formData,
          dataType: 'html',
          success: function(data){
        	  $('#busy-indicator').hide('fast');
	        	$("#formdisplayid").html(data);
	        
	        
          },
			error: function(message){
				alert("Error in Retrieving data");
          }        });
    
    return false; 
	}
	function getPackage(patientId){
		var getPackageUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "getPackage","admin" => false)); ?>" ;
		$.fancybox({

			'width' : '70%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : getPackageUrl+"/"+patientId+"/IPD"
		});
	}
	/* Eod*/
 	/* Doctors Data*/
		$('#viewNotes').click(function(){
			$('.dateNote').show('slow');
			$('#addNotes').toggle('slow');
			$('#viewNotes').toggle('slow');
		});
		$('#addNotes').click(function(){
			$('.dateNote').hide('slow');
			$('#saveNotes').show('slow');
			$('#addNotes').toggle('slow');
			$('#viewNotes').toggle('slow');
		});
		$('.copyData').click(function(){
			var valOld=$(this).attr('id');
			var checkCurrent=$(this).attr('current');
			
			if(checkCurrent!='yes')
				$('#saveNotes').fadeOut();
			else
				$('#saveNotes').fadeIn();
			
			$('#cc').val(valOld);
		});
	/* Eod*/
	/*Template serach and load functions*/
	$("#search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NoteTemplate","template_name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				onItemSelect : function (){
					searchFromTemplate = 'true';
				}
			});

	$("#search").keypress(function(e) {
	 	if(e.which == 13) {
			searchTemplateAll();
 		}
	});

	$("#searchBtn").click(function() {	 
		searchTemplateAll();
	});	

	function searchTemplateAll(searchTitle,searchFrom){
		searchFromTemplate = (searchFrom === undefined) ? searchFromTemplate : searchFrom;
		var serachText=$('#search').val();
		var serachText=serachText.split(' (');
		
		if(serachText==''){
			alert('Please enter data');
			return false;
		}
		searchTitle = (searchTitle === undefined) ? serachText['0'] : searchTitle;

		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getSoapTemplates","admin" => false)); ?>";
		$.ajax({
			type: "POST",
			url: ajaxUrl+"/"+searchTitle+"/"+ searchFromTemplate,
			beforeSend:function(){
			$('#busy-indicator').show('fast');
			},
			success: function(data){
				//if(searchFromTemplate == 'true'){
					searchFromTemplate = 'false';
					$('#loadTemplate').html(data);//diplay templates
					$('#search').val('');
					$('#busy-indicator').hide('slow');
			}
		});
	}
	/* Eod*/

	/*Save Notes*/
	$('#saveNotes').click(function(){
		$('#saveNotes').hide();
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "ajaxNoteSave","admin" => false)); ?>";
		var patientID='<?php echo $patientID;?>';
		var id=$('#note_id').val();
		var valueText=$('#cc').val();
	       $.ajax({
		       	beforeSend : function() {
		           	$("#busy-indicator").show();
		        },
		       type: 'POST',
		       url: ajaxUrl,
		       data:'patientID='+patientID+'&noteID='+id+'&noteData='+valueText,
		       dataType: 'html',
	       	   success: function(data){
	       	   		$("#busy-indicator").hide();
	       			if(data!=''){ 
	      			 	$('#note_id').val($.trim(data));
	      			}
	      			$('#saveMsg').css('font-color:red');
	      			$('#saveMsg').html('Data Saved Successfully...');
	      			$("#saveMsg").css("color", "#42647F");
	      			
	      			setTimeout(function(){
	      			 $('#saveMsg').html('');
	      			}, 3000);
	      			
	      			$('#saveNotes').show();
	       		},
			});
	});
	/* Eod */

	/*Switch Task*/ //servicesData doctorNotes
		$('#switch').click(function(){ 
			searchFromTemplate=true;
			$('#servicesData').toggle();
			$('#doctorNotes').toggle();

			

		});
		
		$('#assessmentTab').click(function(){ 
			searchFromTemplate=true;	
			$('#servicesDataLoad').html('');
			var patientID='<?php echo $patientID;?>';
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addProcedurePerform","admin" => false)); ?>" +"/"+patientID+"/?LoadSet=loadSet";
			   $.ajax({
			       	beforeSend : function() {
			           	$("#busy-indicator").show();
			        },
			       type: 'POST',
			       url: ajaxUrl,
			       dataType: 'html',
		       	   success: function(data){
		       	   		$("#busy-indicator").hide();
		     			$('#serviceHtml').html(data);
		      		},
				});
		});
	/*Eod*/
	/***BOF Reconcile Check***/	
		function save_reconcilecheck(){
			if($('#reconcilecheck').prop('checked')) 
			{	var checkreconcile=1;
			}else{
			  	var checkreconcile=0;
		    }
			
			patientid="<?php echo $patient_id?>";
			person_id="<?php echo $admission_type['Patient']['person_id']?>";
			
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "setReconcile","admin" => false)); ?>";
		    
		    $.ajax({
		     type: 'POST',
		     url: ajaxUrl+"/"+patientid+"/"+checkreconcile+"/"+person_id,
		     dataType: 'html',
		     success: function(data){
		    	 $('#reconcileMsg').html('Reconciled Successfully...');
		    	 $('#reconcileMsg').css('color',"green");

		    	 setTimeout(function(){
	      			 $('#reconcileMsg').html('');
	      			}, 3000);
		     },
			 error: function(message){
		        alert(message);
		     }        
		   });
		}
	/*EOF Reconcile Check*/

	/* Set Refferal*/
		$('#sendRef').click(function(){
			sendReferral();
		});
		function sendReferral(){ 
		 var ajaxUrl1 = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "checkNoteIdForDiagnosis","admin" => false)); ?>";
		  $.ajax({
	        	beforeSend : function() {
	        		//loading();
	        	},
	        	type: 'POST',
	        	url: ajaxUrl1+"/"+<?php echo $patient_id?>,
	        	dataType: 'html',
	        	success: function(data){
	        		window.location.href = "<?php echo $this->Html->url(array('controller'=>'messages','action'=>'composeCcda',$patient_id)); ?>";
		        	},
		  });
		}
	/*EOD*/

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
		$('#cN,#preN,#postN,#sN,#aN').click(function(){
			var currentID=$(this).attr('id');
			$('#'+currentID+"View").show();
			if(currentID=='cN'){
				$('#cN').addClass('bgTitle');
				$('#preN,#postN,#sN,#aN').removeClass('bgTitle');
				$('#preNView,#postNView,#sNView,#aNView').hide();
			}else if(currentID=='preN'){
				$('#preN').addClass('bgTitle');
				$('#cN,#postN,#sN,#aN').removeClass('bgTitle');
				
				$('#cNView,#postNView,#sNView,#aNView').hide();
				$('#postNView,#sNView,#aNView').html('');
				
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "preOtNotes","admin" => false)); ?>";
					
					$.ajax({
						type: "POST",
						url: ajaxUrl+"/"+'<?php echo $patient_id?>',
						
						beforeSend:function(){
							$('#busy-indicator').show('fast');
						},
						
						success: function(data){
								$('#preNView').html(data);//diplay templates
								$('#busy-indicator').hide('slow');
						}
					});

			}else if(currentID=='postN'){
				$('#postN').addClass('bgTitle');
				$('#cN,#preN,#sN,#aN').removeClass('bgTitle');
				
				$('#cNView,#preNView,#sNView,#aNView').hide();
				$('#preNView,#sNView,#aNView').html('');

				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "postOptNotes","admin" => false)); ?>";
					
					$.ajax({
						type: "POST",
						url: ajaxUrl+"/"+'<?php echo $patient_id?>'+"?type=postNotes",
						
						beforeSend:function(){
							$('#busy-indicator').show('fast');
						},
						
						success: function(data){
								$('#postNView').html(data);//diplay templates
								$('#busy-indicator').hide('slow');
						}
					});
			}else if(currentID=='sN'){
				$('#sN').addClass('bgTitle');
				$('#cN,#preN,#postN,#aN').removeClass('bgTitle');

				$('#cNView,#preNView,#postNView,#aNView').hide();
				$('#preNView,#postNView,#aNView').html('');

				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "sugOptNotes","admin" => false)); ?>";
					
					$.ajax({
						type: "POST",
						url: ajaxUrl+"/"+'<?php echo $patient_id?>',
						
						beforeSend:function(){
							$('#busy-indicator').show('fast');
						},
						
						success: function(data){
								$('#sNView').html(data);//diplay templates
								$('#busy-indicator').hide('slow');
						}
					});
			}else if(currentID=='aN'){
				$('#aN').addClass('bgTitle');
				$('#cN,#preN,#postN,#sN').removeClass('bgTitle');

				$('#cNView,#preNView,#postNView,#sNView').hide();
				$('#preNView,#postNView,#sNView').html('');
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "anesthesiaOptNotes","admin" => false)); ?>";
					
					$.ajax({
						type: "POST",
						url: ajaxUrl+"/"+'<?php echo $patient_id?>',
						
						beforeSend:function(){
							$('#busy-indicator').show('fast');
						},
						
						success: function(data){
								$('#aNView').html(data);//diplay templates
								$('#busy-indicator').hide('slow');
						}
					});
			}
		});
		/*$('#LoadSet').click(function(){
			 window.scrollTo(0,500);
		});*/
		function update_patient_record(id,order_id,chkId,type){
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "updateorderset","admin"=>false)); ?>"+"/"+id+"/"+order_id+"/"+type;
			$.ajax({
				type : "POST",
				url : ajaxUrl , 
				
				beforeSend:function(){
					$('#busy-indicator').show('fast');
                },
				success: function(data){

					data = jQuery.parseJSON(data);
					data = data.status;
					if(type=='med'){
						$('#busy-indicator').hide('fast');
						if($.trim(data)=='Y'|| data=='1'){
							var changeStatus='Cancelled';
							$("#update_med_"+order_id).html(changeStatus);
						}
						else if($.trim(data)|| data=='0'){
							var changeStatus='Ordered';
							$("#update_med_"+order_id).html(changeStatus);
						}
						else{
							var changeStatus='Pending';
							$("#update_med_"+order_id).html('Pending');
						}
					}
					else if(type=='lab'){
						if(data=='1'){
							$("#update_lab_"+order_id).html('Cancelled');
						}else{
							$("#update_lab_"+order_id).html('Ordered');
						}
					}
					else if(type=='rad'){
						if(data=='1'){
							$("#update_rad_"+order_id).html('Cancelled');
						}else{
							$("#update_rad_"+order_id).html('Ordered');
						}
					}
					$('#busy-indicator').hide('fast');
					},
				
				error: function(message){
				alert('Please try later.');
				}
				
			});
}
</script>