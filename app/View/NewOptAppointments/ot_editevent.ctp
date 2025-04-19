<link href="<?php echo $this->Html->url('/wdcss/main.css'); ?>" rel="stylesheet" type="text/css" /> 


<?php
	echo $this->Html->script(array('jscompress','ui.datetimepicker.3','jquery.fancybox')); 
	echo $this->Html->css(array('jquery-ui-1.8.16.custom','jquery.ui.all.css','jquery.autocomplete.css','jquery-ui','jquery.fancybox'));
?>
<script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.validate.1.4.0.js'); ?>"></script>
<script src="<?php echo $this->Html->url('/wdsrc/Plugins/jquery.form.js'); ?>"></script>
<script src="<?php echo $this->Html->url('/wdsrc/Plugins/Common.js'); ?>"></script>
<script type="text/javascript"> 
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
  
<style type="text/css">
body{margin:0;padding:0;font-family:Arial,Helvetica,sans-serif;background:#fff;font-size:13px!important}
.calpick {
	width: 16px;
	height: 16px;
	border: none;
	cursor: pointer;
	background:
		url("<?php echo $this->Html->url('/wdcss/sample-css/cal.gif'); ?>")
		no-repeat center 2px;
	/*   margin-left:-22px; */
	padding: 11px 0 0;
}

#busy-indicator {
	display: none;
	left: 50%;
	position: fixed;
	top: 50%;
	z-index: 2000;
}

a.imgbtn span{
    font-size: 17px !important;
    padding: 2px 1px 5px 25px !important;
}
</style>
</head>
<body>
	<div>
		<div style="clear: both"></div>
		<div class="infocontainer">
			<form action="<?php echo $this->Html->url('/new_opt_appointments/datafeed/'); ?>?method=adddetails<?php echo isset($getOptDetails['OptAppointment']['id'])?"&id=".$getOptDetails['OptAppointment']['id']:""; ?>" 
			 class="fform" id="fmEdit" method="post">
				<?php
				echo $this->Form->input(null,array('type' => 'hidden', 'name' => 'admissionid', 'id'=> 'admissionid', 'label' => false, 'value'=> $getPatientDetaiils['Patient']['admission_id']));
				echo $this->Form->input(null,array('type' => 'hidden', 'name' => 'patientid', 'id'=> 'patientid', 'label' => false, 'value'=> $getOptDetails['OptAppointment']['patient_id']));
				?>
				<div align="center" id="busy-indicator" style="display: none;">
					<?php echo $this->Html->image('indicator.gif'); ?>
				</div>
				<label> <span> <?php echo __('Patient Name');?><font color="red"> *</font>:
				</span>
					<div id="calendarPatientName"></div> <input MaxLength="100"
					class="required safe" id="calendarPatientNameText"
					name="patient_name_text" style="width: 456px;" type="text"
					value="<?php echo isset($getOptDetails['Patient']['lookup_name'])?$getOptDetails['Patient']['lookup_name']:"" ?>" />
					<input id="calendarPatientNameValue" name="patient_name_value"
					type="hidden"
					value="<?php echo isset($getOptDetails['Patient']['id'])?$getOptDetails['Patient']['id']:"" ?>" />
				</label> <label> <span>Date & Time<font color="red"> *</font>:
				</span>
					<div>
						<?php
						$sdate = $stime = $edate = $etime = ""; 
						if(isset($startDate)){ 
				 	if (isset($getOptDetails['OptAppointment']['id'])) { 
						$sdate = $sarr1[0]." ".$sarr1[1];  
				 		// $sdate = date("n/j/Y", strtotime($sarr1[0]));
				 		 $stime = $sarr1[1];

					} else {
					$dateTime = explode(" ",$startDate);
					$sdate = $dateTime[0];
					//$stime = $dateTime[1];
					}
				}   
				if(isset($endDate)){
					if (isset($getOptDetails['OptAppointment']['id'])) {
						$edate = $earr1[0]." ".$earr1[1];
						//$edate = date("d/m/Y", strtotime($earr1[0]));
						$etime = $earr1[1];

					} else {

						$dateTime = explode("_",$endDate);
						$edate = $dateTime[0];
						//$stime = $dateTime[1];
					}
				} 
				
				if(isset($getOptDetails['OptAppointment']['ot_in_date'])) {
					$getOtInDate = date("Y-m-d H:i", strtotime($getOptDetails['OptAppointment']['ot_in_date']));
					$otDateTime = explode(" ", $getOtInDate);
				}
				if(isset($getOptDetails['OptAppointment']['incision_date'])) {
					$getIncisionDate = date("Y-m-d H:i", strtotime($getOptDetails['OptAppointment']['incision_date']));
					$incisionDateTime = explode(" ", $getIncisionDate);
				}
				if(isset($getOptDetails['OptAppointment']['skin_closure_date'])) {
					$getSkinClosureDate = date("Y-m-d H:i", strtotime($getOptDetails['OptAppointment']['skin_closure_date']));
					$skinClosureDateTime = explode(" ", $getSkinClosureDate);
				}
				if(isset($getOptDetails['OptAppointment']['out_date'])) {
					$getOutDate = date("Y-m-d H:i", strtotime($getOptDetails['OptAppointment']['out_date']));
					$outDateTime = explode(" ", $getOutDate);
				}
			 ?>
			 <?php if ($getOptDetails['OptAppointment']['procedure_complete']=='1') { ?>
					<input class="required"  name="stpartdate" style="padding-left: 2px; width: 11%;" type="text" value="<?php echo $sdate; ?>" readonly="readonly"/> 
					<input type = "hidden" MaxLength="5" class="required time"  name="stparttime" autocomplete="off" style="width: 60px;" type="text" value="<?php echo $stime; ?>" />
					<span style="font-size: 12px;">To<font color="red"> *</font>: </span> 
					<input  class="required"  name="etpartdate" style="padding-left: 2px; width: 11%;" type="text" value="<?php echo $edate; ?>" readonly="readonly"/> 
					<input type = "hidden"  MaxLength="50" class="required time"  autocomplete="off" name="etparttime" style="width: 60px;" type="text" value="<?php echo $etime; ?>" />
				<?php }else{?>
					<input class="required" id="stpartdate" name="stpartdate" style="padding-left: 2px; width: 11%;" type="text" value="<?php echo $sdate; ?>" readonly="readonly"/> 
					<input type = "hidden" MaxLength="5" class="required time" id="stparttime" name="stparttime" autocomplete="off" style="width: 60px;" type="text" value="<?php echo $stime; ?>" />
					<span style="font-size: 12px;">To<font color="red"> *</font>: </span> 
					<input  class="required" id="etpartdate" name="etpartdate" style="padding-left: 2px; width: 11%;" type="text" value="<?php echo $edate; ?>" readonly="readonly"/> 
					<input type = "hidden"  MaxLength="50" class="required time" id="etparttime" autocomplete="off" name="etparttime" style="width: 60px;" type="text" value="<?php echo $etime; ?>" />
				<?php } ?>
				
				<!--<label class="checkp"> 
					 <input id="IsAllDayEvent" name="is_all_day_event" type="checkbox" value="1" <?php if(isset($getOptDetails['OptAppointment']['id'])&&$getOptDetails['OptAppointment']['is_all_day_event']!=0) {echo "checked";} ?> />
						All Day Event
					</label>
				 -->
			</div>
		</label>
				
	<div class="twoCol">
          <label>
            <span>
             <?php echo __('OT Room')?><font color="red"> *</font>:
            </span>
            <?php echo $this->Form->input(null,array('name' => 'opt_id', 'id'=> 'opt_id', 'empty'=>__('Select OT'), 'options'=> $opts, 'label' => false, 'default' => $getOptDetails['OptAppointment']['opt_id'], 'style'=>'width:190px;', 'class'=> 'required safe'));?>
	    </label>
	    </div>

	    <div class="twoCol">
            <div id="changeOptTableList" style="<?php if($getOptDetails['OptAppointment']['opt_table_id']) echo 'display:block;'; else echo 'display:none;'; ?>">
            <?php if($getOptDetails['OptAppointment']['opt_table_id']) { ?>
             <label>
            <span>
             <?php echo __('OT Table')?><font color="red"> *</font>:</span>
               <?php echo $this->Form->input(null,array('name' => 'opt_table_id', 'id'=> 'opt_table_id', 'empty'=>__('Select OT Table'), 'options'=> $optTables, 'label' => false, 'default' => $getOptDetails['OptAppointment']['opt_table_id'], 'style'=>'width:190px;', 'class'=> 'required safe'));?>
            </label>
            <?php } ?>
            </div>
	   </div>
		
		<div class="twoCol">
			<label> <span></span> <strong><?php echo $this->Html->link('Add Surgical Implant', array('action' => 'implantIndex'), array('escape' => false,'style'=>'text-decoration: underline;','target'=>"_blank"));  ?> </strong>
			</label>
		</div>
		<!-- for surgery - by swapnil -->
		<div id="surgeryDiv">
		<?php $count = 1; ?>
		<table id="SurgeryTable" border="0">
		
		
		
		<?php #debug($getSurgeryDetails);
		if(isset($getSurgeryDetails) && count($getSurgeryDetails)>0){ 

			//edit case of surgery
			$temp = '';
			foreach($getSurgeryDetails as $key => $surgery){ 
			
			if($key!=0) { $subCount = 1;?>
				<tr id="mainRow_<?php echo $count; ?>"> 
			<td>
			<table id="SurgeonTable_<?php echo $count; ?>">
			<?php foreach($surgery as $skey=>$val){  ?>
				<tr id="row_<?php echo $count."_".$subCount;?>" class="surgeonRow">
					<td>
						<?php if($key != $temp) { $options = array('Surgeon'=>'Surgeon'); $display = "none";?>
						<div class="twoCol">
							<label><span><?php echo __('Surgery')?><font color="red"> *</font>:</span> 
								<?php echo $this->Form->input(null,array('name' => "data[surgery][surgery_name][$count]",'value'=>$val['Surgery']['name'] ,'id'=> "surgeryName_".$count."_".$subCount,'field_no'=>$subCount,'class'=> 'surgery_name required safe','label' => false, 'style'=>'width:190px;'));
									echo $this->Form->hidden('',array('id'=>"surgeryID_".$count."_".$subCount,'name'=>"data[surgery][surgery_id][$count]",'value'=>$val['Surgery']['id'],'class'=>"alertMsg surgeryID"));
									echo $this->Form->hidden('',array('id'=>"surgenTariffListId_".$count."_".$subCount,'name'=>"data[surgery][surgen_tariff_list_id][$count]",'value'=>$val['Surgery']['tariff_list_id']));
									?>
							</label> 
						</div>
						<?php } else{ $options = array('Surgeon'=>'Surgeon','Assistant'=>'Assistant'); $display = "block"; }?>
					</td>
					<td>
						<div class="twoCol">
							<label><span><?php echo __('User')?>:</span> 
								<?php echo $this->Form->input(null,array('name' => "data[surgery][user_type][$count][$subCount]", 'id'=> "userType_".$count."_".$subCount,'field_no'=>$count,'label' => false,'options'=> $options,'value'=>$val['OptAppointmentDetail']['user_type'], 'style'=>'width:190px;','class'=>'required safe'));?>
							</label> 
						</div>
					</td>
					<td>
						<div class="twoCol">
							<label><span><?php echo __('Name')?>:</span> 
								<?php echo $this->Form->input(null,array('name' => "data[surgery][doctor_name][$count][$subCount]",'value'=>$val['DoctorProfile']['doctor_name'],'class'=>'doctor_name required safe' ,'field_no'=>$subCount,'id'=> "doctorName_".$count."_".$subCount,'label' => false,'style'=>'width:190px;'));
									echo $this->Form->hidden(null,array('name' => "data[surgery][doctor_id][$count][$subCount]",'class'=>'doctor_id' ,'id'=> "doctorId_".$count."_".$subCount,'value'=>$val['DoctorProfile']['user_id']));
									echo $this->Form->hidden(null,array('id'=>"serviceBillId_".$count."_".$subCount,'name'=>"data[surgery][service_bill_id][$count]",'value'=>$val['OptAppointmentDetail']['service_bill_id'])); ?>
							</label> 
						</div>
					</td>
					
					<td align="left" style="padding-left:<?php if($display=='none') echo "20px"; ?>;">
						<div class="showDelete" style="display:<?php echo $display; ?>;">
							<label><span>&nbsp;</span> 
								<?php echo $this->Html->link($this->Html->image('icons/cross.png', array('alt' => __('Delete Row'),'title' => __('Delete Row'),
										'onclick'=>"deletRow(".$count.",".$subCount.")")),'javascript:void(0);', array('escape' => false)); ?>
							</label> 
						</div>
					</td>
					<?php if(count($options)=='1'){?>
					
					<td>
						<div class="twoCol">
							<label><span><?php echo __('Surgical Implant')?>:</span> 
								<?php echo $this->Form->input(null,array('name' => "data[surgery][implant_name][$count]",'class'=>'implant_name required safe' ,'field_no'=>$subCount,'id'=> "implantName_".$count."_".$subCount,'label' => false,'style'=>'width:190px;','value'=>$val['SurgicalImplant']['name']));
									echo $this->Form->hidden(null,array('name' => "data[surgery][implant_id][$count]",'class'=>'implant_id' ,'id'=> 'implantId_'.$count."_".$subCount,'value'=>$val['OptAppointmentDetail']['implant_id']));?>
							</label> 
						</div>
					</td>
					<td>
						<div class="twoCol">
							<label><span><?php echo __('Description')?>:</span> 
								<?php echo $this->Form->textarea(null,array('name' => "data[surgery][implant_description][$count]",'class'=>'implant_description safe' ,'field_no'=>$subCount,'id'=> "implantDescription_".$count."_".$subCount,'label' => false,'rows'=>"1",'style'=>'width:190px;','value'=>$val['OptAppointmentDetail']['implant_description']));	?>
							</label> 
						</div>
					</td>
					<?php }?>

				</tr>
				<?php $temp = $key; $subCount++;} ?>
			</table>
			</td>
			<td valign="bottom">
				<!-- <div class="twoCol">
					<label><span>&nbsp;</span>   -->
						<input name="" type="button" value="Add More Surgeon" class="blueBtn Add_more" onclick="addFieldSurgeon('<?php echo $count; ?>')" />
						<input type="hidden" value="<?php echo $subCount; ?>" id="nofield_<?php echo $count; ?>"/>
					<!-- </label> 
				</div> -->
			</td>
			<td></td>
			</tr>	
		<?php $count++; } } ?>
		<?php } else { 
		//new ?>
			<tr id="mainRow_1"> 
			<td>
			<table id="SurgeonTable_1">
				<tr id="row_1_1" class="surgeonRow">
					<td>
						<div class="twoCol">
							<label><span><?php echo __('Surgery For Billing')?><font color="red"> *</font>:</span> 
								<?php echo $this->Form->input(null,array('name' => "data[surgery][surgery_name][1]", 'id'=> 'surgeryName_1_1','field_no'=>'1','class'=> 'surgery_name required safe','label' => false, 'style'=>'width:190px;'));
									echo $this->Form->hidden('',array('id'=>'surgeryID_1_1','name'=>"data[surgery][surgery_id][1]", 'class'=>"alertMsg surgeryID"));
									echo $this->Form->hidden('',array('id'=>"surgenTariffListId_1_1",'name'=>"data[surgery][surgen_tariff_list_id][1]"));?>
							</label> 
						</div>
					</td>
					<td>
						<div class="twoCol">
							<label><span><?php echo __('User')?>:</span> 
								<?php echo $this->Form->input(null,array('name' => "data[surgery][user_type][1][1]", 'id'=> 'userType_1_1','field_no'=>'1','label' => false,'options'=> array('Surgeon'=>'Surgeon'),'value'=>'Surgeon', 'style'=>'width:190px;'));?>
							</label> 
						</div>
					</td>
					<td>
						<div class="twoCol">
							<label><span><?php echo __('Name')?>:</span> 
								<?php echo $this->Form->input(null,array('name' => "data[surgery][doctor_name][1][1]",'class'=>'doctor_name required safe' ,'field_no'=>'1','id'=> 'doctorName_1_1','label' => false,'style'=>'width:190px;'));
									echo $this->Form->hidden(null,array('name' => "data[surgery][doctor_id][1][1]",'class'=>'doctor_id' ,'id'=> 'doctorId_1_1'));?>
							</label> 
						</div>
					</td>
					<td>
						<div class="twoCol">
							<label><span><?php echo __('Surgical Implant')?>:</span> 
								<?php echo $this->Form->input(null,array('name' => "data[surgery][implant_name][1]",'class'=>'implant_name required safe' ,'field_no'=>'1','id'=> 'implantName_1_1','label' => false,'style'=>'width:190px;'));
									echo $this->Form->hidden(null,array('name' => "data[surgery][implant_id][1]",'class'=>'implant_id' ,'id'=> 'implantId_1_1'));?>
							</label> 
						</div>
					</td>
					<td>
						<div class="twoCol">
							<label><span><?php echo __('Surgical Implant Description')?>:</span> 
								<?php echo $this->Form->textarea(null,array('name' => "data[surgery][implant_description][1]",'class'=>'implant_description safe' ,'field_no'=>'1','id'=> 'implantDescription_1_1','label' => false,'style'=>'width:190px;'));	?>
							</label> 
						</div>
					</td>
					
					<td>
						<div class="">
							<label><span>&nbsp;</span> 
								<?php //echo $this->Html->link($this->Html->image('icons/cross.png', array('alt' => __('Delete Row'),'title' => __('Delete Row'),'onclick'=>"deletRow(1,1)")),'javascript:void(0);', array('escape' => false)); ?>
							</label> 
						</div>
					</td>
				</tr>
			</table>
			</td>
			<td valign="bottom">
				<!-- <div class="twoCol">
					<label><span>&nbsp;</span>  --> 
						<input name="" type="button" value="Add More Surgeon" class="blueBtn Add_more" onclick="addFieldSurgeon('1')" />
						<input type="hidden" value="1" id="nofield_1"/>
					<!-- </label> 
				</div> -->
			</td>
			<td></td>
			</tr>
		<?php } ?>
		</table>
		</div>
		<?php if($this->Session->read('website.instance') == 'vadodara'){
				if(!empty($getOptDetails['OptAppointment']['dummy_surgery_name'])){?>
					<div id="dummy_surgery">
					<label> <span> <?php echo __('Dummy Surgery')?><font color="red"> *</font>:
					</span> <?php echo $this->Form->input(null,array('name' => 'dummy_surgery_name', 'type'=>'text','id'=> 'dummy_id',
							 'label' => false,'style'=>'width:190px;', 'class'=> 'safe','value'=>$getOptDetails['OptAppointment']['dummy_surgery_name']));?>
					</label>
					</div>
					<?php }else{?>
					<div id="dummy_surgery" style="display:none">
					<label> <span> <?php echo __('Dummy Surgery')?><font color="red"> *</font>:
					</span> <?php echo $this->Form->input(null,array('name' => 'dummy_surgery_name', 'type'=>'text','id'=> 'dummy_id',
							 'label' => false,'style'=>'width:190px;', 'class'=> 'safe','value'=>$getOptDetails['OptAppointment']['dummy_surgery_name']));?>
					</label>
					</div>
					<?php }?>
					
				<?php }?>
		<div>
			<label>   
				<input name="" type="button" value="Add More Surgery" class="blueBtn Add_more"onclick="addFieldsSurgery()" />
				<input type="hidden" value="<?php echo $count;?>" id="no_of_field" />
			</label> 
		</div>
		<div class="clr"></div>
		  <!-- <div class="twoCol">
			<label> <span> <?php echo __('Category'); ?> <font color="red">*</font>:
			</span> <?php 
           				// echo $this->Form->input(null,array('name' => 'surgery_category_id', 'id'=> 'surgery_category_id', 'empty'=>__('Select Category'),'options'=> $surgery_categories, 'label' => false, 'default'=> $getOptDetails['OptAppointment']['surgery_category_id'], 'style'=>'width:190px;', 'class'=> 'required safe'));	?>
			</label>
		  </div> 
				<div id="changeSurgerySubcategoryList" class="twoCol" style="<?php if($getOptDetails['OptAppointment']['surgery_subcategory_id'] && false) echo 'display:block;'; else echo 'display:none;'; ?>">
					<?php if($getOptDetails['OptAppointment']['surgery_subcategory_id']) { ?>
					<label> <span><?php echo __('Surgery Subcategory')?>:</span> <?php //echo $this->Form->input(null,array('name' => 'surgery_subcategory_id', 'id'=> 'surgery_subcategory_id', 'empty'=>__('Select Surgery Subcategory'), 'options'=> $surgery_subcategories, 'label' => false, 'default' => $getOptDetails['OptAppointment']['surgery_subcategory_id'], 'style'=>'width:190px;'));?>
					</label>
					<?php } ?>
				</div>
				<div id="changeSurgeryList" class="twoCol">
					<?php
           			if($getOptDetails['OptAppointment']['surgery_id']) { ?>
					<label> <span> <?php echo __('Surgery')?><font color="red"> *</font>:
					</span> <?php //echo $this->Form->input(null,array('name' => 'surgery_id', 'id'=> 'surgery_id', 'empty'=>__('Select Surgery'), 'options'=> $surgeries, 'label' => false, 'default' => $getOptDetails['OptAppointment']['surgery_id'],'style'=>'width:190px;', 'class'=> 'required safe'));?>
					</label>
					<?php } else { ?>
					<label> <span> <?php echo __('Surgery')?><font color="red"> *</font>:
					</span>   <select name="surgery_id" id="surgery_id"
						class="required safe" style="width: 190px;">
							<option value="">
								<?php echo __('Select Surgery'); ?>
							</option>
					</select>  
					</label>

					<?php }?>
				</div> -->
				
				<?php if($this->Session->read('website.instance') == 'kanpur'){
					echo $this->Form->hidden(null,array('name'=>'editOnly','id'=>'editOnly','value'=>0));
				?>
				<div class="clr"></div>
				<div id="updateOTRule">
					<span>
                  <?php  $role=$this->Session->read('role');
                  $type = ( $role != Configure::read('adminLabel') )  ? 'hidden' : 'text'; ?>
                     
						<div>
							<?php echo __('Surgeon Charge'); ?>
							<font color="red"> *</font><br />
							<div style="height: 4%;">
							<?php  echo $this->Form->input(null,array('name' => 'doctor_id', 'id'=> 'doctor_id', 'empty'=>__('Select Surgeon'), 'options'=> $doctorlist,
								'label' => false,'style'=>'width:190px;','div'=>false, 'class'=> 'required safe surgeon','default'=>$getOptDetails['OptAppointment']['doctor_id']));
							?></div>
							<?php
								 echo $this->Form->input(null,array('name' => 'surgeon_amt','type'=>$type,'id'=> 'surgeonCharge','label' => false, 'div' => false, 
									'class' => ' digits safe','value'=>$getOptDetails['OptAppointment']['surgeon_amt'],"style"=>"width:190px",'readOnly'=>true));
                            ?>
						</div>
						<div style="float: left; width: 22%;">
							<?php echo __('Asst. Surgeon I'); ?><br />
							<div style="height: 4%;">
							<?php echo $this->Form->input(null,array('name' =>'asst_surgeon_one','id'=> 'asstDoctorIdOne','empty'=>__('Select Surgeon'),'options'=> $doctorlist,
								'label' => false, 'style'=>'width:190px;','div'=>false,'class'=> ' safe surgeon','default'=>$getOptDetails['OptAppointment']['asst_surgeon_one']));
							?></div>
							<?php 
							       echo $this->Form->input(null,array('name' =>'asst_surgeon_one_charge','type'=>$type,'id'=> 'asstSurgeonOneCharge','label' => false,'div' => false,
								   'value'=>$getOptDetails['OptAppointment']['asst_surgeon_one_charge'], 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
                              ?>
						</div>
						<div>
							<?php echo __('Asst. Surgeon II'); ?><br />
							<div style="height: 4%;">
							<?php echo $this->Form->input(null,array('name' => 'asst_surgeon_two', 'id'=> 'asstDoctorIdTwo', 'empty'=>__('Select Surgeon'), 'options'=> $doctorlist,
							'label' => false, 'style'=>'width:190px;','div'=>false, 'class'=> ' safe surgeon','default'=>$getOptDetails['OptAppointment']['asst_surgeon_two']));?>
							</div>
							<?php 
							       echo $this->Form->input(null,array('name' => 'asst_surgeon_two_charge','type'=>$type ,'id'=> 'asstSurgeonTwoCharge','label' => false, 
										'div' => false,'value'=>$getOptDetails['OptAppointment']['asst_surgeon_two_charge'],'class' => ' digits safe',
										"style"=>"width:190px",'readOnly'=>true));
                           ?>
						</div>
						<div style="float: left;  width: 22%;">
							<?php echo __('Anaesthesist'); ?><br />
							<div style="height: 4%;">
							<?php   echo $this->Form->input(null,array('name'=>'department_id','id'=>'department_id','empty'=>__('Select Anaesthetist'),'options'=> $departmentlist,
									'label' => false,'style'=>'width:190px;','div'=>false, 'class'=> ' safe','default'=>$getOptDetails['OptAppointment']['department_id']));?>
							</div>
							<?php $displayDD = ($type == 'hidden') ? 'none' : 'block';
								echo $this->Form->input(null, array('type'=>'hidden','name' => 'anaesthesia_service_group_id','id' => 'anaesthesia_service_group_id',
								'value'=>isset($getOptDetails['OptAppointment']['anaesthesia_service_group_id'])?$getOptDetails['OptAppointment']['anaesthesia_service_group_id']:$anesthesiaCategoryId['ServiceCategory']['id'],
              			 				'label'=> false, 'div' => false, 'error' => false));
									echo $this->Form->input(null,array('name' => 'anaesthesia_tariff_list_id', 'id'=> 'anaesthesia_tariff_list_id',
										 'empty'=>__('Select Service'), 'options'=> $services, 'label' => false,
										 'default' => $getOptDetails['OptAppointment']['anaesthesia_tariff_list_id'], 'style'=>'width:190px;'/*display:'.$displayDD*/));?>
						<?php 
							         echo $this->Form->input(null,array('name' => 'anaesthesia_cost','type'=>'hidden', 'id'=> 'anaesthesistCharge','label' => false,
									'value'=>$getOptDetails['OptAppointment']['anaesthesia_cost'],'div' => false, 'class' => ' digits safe',"style"=>"width:190px"));
                           ?>
						</div>
						<div>
							<?php echo __('Cardiologist'); ?><br />
							<div style="height: 4%;">
							<?php echo $this->Form->input(null,array('name' =>'cardiologist_id','id'=>'cardiologist_id','empty'=>__('Select Cardiologist'),'options'=> $cardiologist,
									'label' => false,'style'=>'width:190px;','div' => false, 'class'=> ' safe','default'=>$getOptDetails['OptAppointment']['cardiologist_id']));?>
									</div>
							<?php 
							     echo $this->Form->input(null,array('name' => 'cardiologist_charge','type'=>$type ,'id'=> 'cardiologistCharge','label' => false, 'div' => false,
									'value'=>$getOptDetails['OptAppointment']['cardiologist_charge'], 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
                            ?>
						</div>
						<?php $show = ($type == 'hidden') ? 'none' : 'block'  ?>
						<div style="float: left; width: 22%; display: <?php echo $show;?>">
							<?php echo __('OT Assistant'); ?><br />
							<?php 
								echo $this->Form->input(null,array('name' => 'ot_asst_charge','type'=>$type ,'id'=> 'otAsstCharge','value'=>$getOptDetails['OptAppointment']['ot_asst_charge'],
 									'label' => false, 'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
                         	?>
						</div>
						<div style="float: left; display: <?php echo $show;?>">
							<?php echo __('OT Charges'); ?><br />
							<?php 
								echo $this->Form->input(null,array('name' => 'ot_charges','type'=>$type,'id'=> 'ot_charges','value'=>$getOptDetails['OptAppointment']['ot_charges'],
 									'label' => false, 'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
                           ?>
						</div>
					</span>
					
					<div class="clr" style="height: 2%;"></div>
				<?php 
				
				$selectedServices = unserialize($getOptDetails['OptAppointment']['ot_service']);
				$toggle = 1;
                $chargeType = ( $this->Session->read('hospitaltype') == 'NABH' ) ? 'nabh_charges' : 'non_nabh_charges';
                          
				foreach(Configure::read('otExtraServices') as $key =>$service){

					$checked = (array_key_exists($key, $selectedServices)) ? true : false;
					$width = ($toggle % 2 == 0) ? '50%' : '30%';
					?>
				<div class="twoCol" style="height: 20px; width: <?php echo $width?>;">
					<span>  <?php 
					$checkboxValue=$selectedServices[$key];
					if($checkboxValue==0)
						$checkboxfinalValue=$selectedServices[$service];
					else
						$checkboxfinalValue=$charges[$service."_discount"];
						
					echo $this->Form->checkbox(null,array('name'=>"ot_service[".$key."]",'id' =>$service,
							 'label'=> false,'value'=>$checkboxfinalValue,'checked'=>$checked,'hiddenField'=>false));
					?> </span><span style="font-size: 14px"> <?php echo __($key); ?></span>
				</div><?php $toggle++;?>
				<?php }?>
				
				</div>
								
				<?php }?>
				
				<div class="twoCol" id="showSurgenServiceGroup" style="display:none;<?php //if($getOptDetails['OptAppointment']['surgen_service_group_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
					<label> <span> <?php echo __('Service Group'); ?> <font color="red">*</font>:
					</span> <?php
					echo $this->Form->input(null, array('name' => 'surgen_service_group_id', 'options' => $anaesServiceGroup, 'empty' => 'Select Service Group', 'id' => 'surgen_service_group_id','default' => $getOptDetails['OptAppointment']['surgen_service_group_id'], 'label'=> false, 'div' => false, 'error' => false));
					?>
					</label>
				</div>
				<div id="autoservice" class="twoCol" style="width:250px;display:none<?php //if($getOptDetails['OptAppointment']['surgen_service_group_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
					<label> <span>&nbsp;</span> <?php echo $this->Form->input(null,array('name' => 'autoservice', 'id'=> 'autoservicesearch',  "value"=>"Search Service",'label' => false, 'style'=>'width:190px;'));?>
					</label>
				</div>
				<div id="showSurgenService" class="twoCol" style=" display:none;<?php //if($getOptDetails['OptAppointment']['surgen_service_group_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
					<label> <span><?php echo __('Service')?><font color="red">*</font>:</span>
						<?php //echo $this->Form->input(null,array('name' => 'surgen_tariff_list_id', 'id'=> 'surgen_tariff_list_id', 'empty'=>__('Select Service'), 'options'=> $surgeon_services, 'label' => false, 'default' => $getOptDetails['OptAppointment']['tariff_list_id'], 'style'=>'width:190px;'));?>
					</label>
				</div>
				<?php if($this->Session->read('website.instance') != 'kanpur'){?>
				<div class="clr"></div>
				<?php /* ?>
					<div class="twoCol">
					<label> <span> <?php echo __('Cardiologist'); ?>:
					</span> <?php echo $this->Form->input(null,array('name' => 'card_id', 'id'=> 'cardiologist_id', 'empty'=>__('Select Cardiologist'),
            		'options'=> $cardiologist, 'label' => false,'default'=> $getOptDetails['OptAppointment']['department_id'], 'style'=>'width:190px;', 'class'=> 'safe'));?>
					</label>
					</div>
					<div class="clr"></div>
				<?php */?>
				<div class="twoCol">
					<label> <span> <?php echo __('Anaesthetist'); ?>:
					</span> <?php echo $this->Form->input(null,array('name' => 'department_id', 'id'=> 'department_id', 'empty'=>__('Select Anaesthetist'),'options'=> $departmentlist, 'label' => false,'default'=> $getOptDetails['OptAppointment']['department_id'], 'style'=>'width:190px;', 'class'=> 'safe'));?>
					</label>
				</div>

				
				<!-- <div class="twoCol" id="showAnaesthesiaServiceGroup" style="<?php if($getOptDetails['OptAppointment']['department_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
          <label>
            <span>
              <?php echo __('Service Group'); ?> <font color="red">*</font>:
            </span>
            <?php
              echo $this->Form->input(null, array('name' => 'anaesthesia_service_group_id', 'options' => $anaesServiceGroup,
			 'empty' => 'Select Service Group', 'id' => 'anaesthesia_service_group_id','value'=>isset($getOptDetails['OptAppointment']['anaesthesia_service_group_id'])?$getOptDetails['OptAppointment']['anaesthesia_service_group_id']:$anesthesiaCategoryId['ServiceCategory']['id'],
			'default' => $getOptDetails['OptAppointment']['anaesthesia_service_group_id'],'readonly'=>'readonly', 'label'=> false, 'div' => false, 'error' => false));
			
			//'onchange'=> $this->Js->request(array('action' => 'getAnaesthesiaServices'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			  //  'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#showAnaesthesiaService', 'data' => '{anaesthesia_service_group_id:$("#anaesthesia_service_group_id").val()}', 'dataExpression' => true)))); ?>
			     
           </label>
	</div>
	 <div class="twoCol" id="autoserviceAnaesthesia" style="width:250px;<?php //if($getOptDetails['OptAppointment']['department_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
          <label>
            <span>
              <?php echo __('Anaesthesia'); ?>:
            </span>
            <?php // echo $this->Form->input(null,array('name' => 'anaesthesia', 'id'=> 'anaesthesia', 'label' => false, "value"=>"Search Service" ,'style'=>'width:190px;'));?>
         <?php //echo $this->Form->hidden(null, array('type'=>'text','id'=>'anaesthesia','name' => 'anaesthesia')); ?>
          </label>
	</div>-->

				<div id="showAnaesthesiaService" class="twoCol" style="<?php if($getOptDetails['OptAppointment']['department_id']) echo 'display:block;';  else echo 'display:none;'; ?>">
					<label> <span><?php 
					echo __('Service')?>:</span> <?php
					echo $this->Form->input(null, array('type'=>'hidden','name' => 'anaesthesia_service_group_id','id' => 'anaesthesia_service_group_id','value'=>isset($getOptDetails['OptAppointment']['anaesthesia_service_group_id'])?$getOptDetails['OptAppointment']['anaesthesia_service_group_id']:$anesthesiaCategoryId['ServiceCategory']['id'],
              			 'label'=> false, 'div' => false, 'error' => false));

			  		echo $this->Form->input(null,array('name' => 'anaesthesia_tariff_list_id', 'id'=> 'anaesthesia_tariff_list_id', 'empty'=>__('Select Service'), 'options'=> $services, 'label' => false, 'default' => $getOptDetails['OptAppointment']['anaesthesia_tariff_list_id'], 'style'=>'width:190px;'));?>
					</label>
				</div>
				<?php }?>
				
				<div class="clr"></div>
				<!-- <div class="twoCol">
					<label> <span> <?php echo __('Surgical Implant'); ?>:
					</span> <?php echo $this->Form->input(null,array('name' => 'implant_name', 'id'=> 'implant_name', 'label' => false,'default'=> $getTarrifData['SurgicalImplant']['name'], 'style'=>'width:190px;', 'class'=> 'safe'));
					echo $this->Form->input(null,array('name'=>'implant_id','id'=> 'implant_id','value'=>$getOptDetails['OptAppointment']['implant_id'],'label' => false,'type'=>'hidden','div'=>false, 'style'=>'width:190px;'));?>
					</label>
				</div>
				<div class="twoCol">
					<label> <span> <?php echo __('Surgical Implant Description'); ?>:
					</span> <?php echo $this->Form->textarea(null,array('name' => 'implant_description', 'id'=> 'implant_description', 'label' => false,'default'=> $getOptDetails['OptAppointment']['implant_description'], 'style'=>'width:300px;', 'class'=> 'safe'));?>
					</label>
				</div> -->
				
				
				<!--  <div class="twoCol">
					<label> <span> <?php echo __('OT Charge'); ?>:
					</span> <?php echo $this->Form->input('ot_charge',array('type'=>'checkbox','name' => 'ot_charge', 'id'=> 'ot_charge','label' => false, 'class'=> 'safe'));?>
					</label>
				</div>
				-->
				<?php if($this->Session->read('website.instance') != 'kanpur'){?>
				<div class="clr"></div>
				<!-- 
				<div class="twoCol" style="width: 250px;">
					<label> <span> <?php echo __('Surgeon'); ?><font color="red"> *</font>:</span> 
					<?php //echo $this->Form->input(null,array('name' => 'doctor_id', 'id'=> 'doctor_id', 'empty'=>__('Select Surgeon'), 'options'=> $doctorlist, 'label' => false,'default'=> $getOptDetails['OptAppointment']['doctor_id'], 'style'=>'width:190px;', 'class'=> 'required safe'));
					?>
					</label>
				</div> -->
				<!-- <div class="twoCol">
					<label> <span> <?php echo __('Cost To Hospital'); ?> <font
							color="red">*</font>:
					</span>
					</label>
					<?php if($this->Session->read('website.instance') == 'vadodara' ){
						$class='optional';
					}else{
						$class='required';
					}?>
					<?php  echo $this->Form->input(null, array('name' => 'cost_to_hospital','label'=> false, 'div' => false, 'error' => false, 'value'=>$getOptDetails['OptAppointment']['cost_to_hospital'],'class'=> "$class numbers")); ?>
				</div>-->
				<?php }?>
				
				<div class="clr"></div>
				<label class="notForKanpur"> <span> <?php echo __('Procedure Complete'); ?>:
				<?php  if($this->params->query['procedurecomplete']) $selectedOption = $this->params->query['procedurecomplete'];
				?>
				</span> <?php 
				if($this->Session->read('website.instance')=='vadodara'){
				//For vadodara the there should Only "No" option -- Pooja
					$proOptions=array('0'=>'No');
				}else{
					$proOptions=array('0' => 'No', '1' => 'Yes');
				}
				echo $this->Form->input(null,array('name' => 'procedurecomplete', 'id'=> 'procedurecomplete', 'options'=>$proOptions ,
						'label' => false, 'default' => $getOptDetails['OptAppointment']['procedure_complete'],'value'=>$selectedOption,'class'=>'editable'));
				?>
				</label>
				<?php if($getOptDetails['OptAppointment']['procedure_complete'] == 1){
					$displayTimeBlock = 'block';
						$addClass = 'required safe';
					}else{
						$displayTimeBlock = 'none';
						$addClass = '';
					}?>
				<div id="allottime" style="display:<?php echo $displayTimeBlock; ?>">
					<?php
					for ($i = 0; $i <= 23; $i++) {
						for($min = 0; $min <= 55 ; $min+=5){
							$hour = $i >= 10 ? $i : "0" . $i;
							$minute = $min >= 10 ? $min : "0" . $min;
							$time = $hour.":".$minute;
							$timeOptions[$time] = $time;
						}
					}
					$stDate=explode(' ',$sdate);
					?>

					<div style="width: 270px; float: left;">
						<span style="display: block; font-size: 13px; font-family: arial;">
							<strong><?php echo __('OT In Time'); ?>:</strong>
						</span>
						<?php if(!isset($otDateTime[0])){
							
						echo $this->Form->input(null, array( 'name' => 'ot_in_date', 'id' => 'ot_in_date', 'label'=> false, 'div' => false,'error' => false,
								 'class'=>$addClass.' allottime editable','value' => isset($otDateTime[0]) ? date('m/d/Y', strtotime($otDateTime[0])) : $stDate['0'])); ?>
						<?php echo $this->Form->input(null, array( 'name' => 'otintime', 'id' => 'otintime', 'label'=> false, 'div' => false,'error' => false,
								'class'=>$addClass.' allottime editable', 'options'=> $timeOptions, 'default' => isset($otDateTime[1])?$otDateTime[1]:'')); }
						else{
						/*echo $this->Form->hidden(null, array( 'name' => 'ot_in_date', 'id' => 'ot_in_date', 'label'=> false, 'div' => false,'error' => false,
								 'class'=>$addClass.' allottime editable','value' => isset($otDateTime[0]) ? date('m/d/Y', strtotime($otDateTime[0])) : $stDate['0'])); ?>
						<?php echo $this->Form->hidden(null, array( 'name' => 'otintime', 'id' => 'otintime', 'label'=> false, 'div' => false,'error' => false,
								'class'=>$addClass.' allottime editable', 'options'=> $timeOptions, 'default' => isset($otDateTime[1])?$otDateTime[1]:''));*/
								echo $stDate['0'].' '.$otDateTime[1];
							}?>
					</div>
					<?php if($this->Session->read('website.instance') != 'kanpur'){?>
					<div style="width: 270px; float: left;">
						<span style="display: block; font-size: 13px; font-family: arial;">
							<strong><?php echo __('Incision Time'); ?>:</strong>
						</span>
						<?php if(!isset($incisionDateTime[0])){
							echo $this->Form->input(null, array( 'name' => 'incision_date', 'id' => 'incision_date', 'label'=> false, 'div' => false,'error' => false,
									 'value' => isset($incisionDateTime[0])?date('m/d/Y', strtotime($incisionDateTime[0])):$stDate['0'],'class'=>'editable')); ?>
							<?php echo $this->Form->input(null, array('name' => 'incisiontime', 'id' => 'incisiontime', 'label'=> false,'div' => false,'error' => false,
									 'options'=> $timeOptions, 'default' => isset($incisionDateTime[1])?$incisionDateTime[1]:'','class'=>'editable'));
									 }else{
									 	/*echo $this->Form->hidden(null, array( 'name' => 'incision_date', 'id' => 'incision_date', 'label'=> false, 'div' => false,'error' => false,
									 'value' => isset($incisionDateTime[0])?date('m/d/Y', strtotime($incisionDateTime[0])):$stDate['0'],'class'=>'editable')); ?>
							<?php echo $this->Form->hidden(null, array('name' => 'incisiontime', 'id' => 'incisiontime', 'label'=> false,'div' => false,'error' => false,
									 'options'=> $timeOptions, 'default' => isset($incisionDateTime[1])?$incisionDateTime[1]:'','class'=>'editable'));*/
									 	echo $stDate['0'].' '.$incisionDateTime[1];
									 } ?>
					</div>
					<div class="clr"></div>
					<div style="width: 270px; float: left;">
						<span style="display: block; font-size: 13px; font-family: arial;">
							<strong><?php echo __('Skin Closure'); ?>:</strong>
						</span>
						<?php if(!isset($skinClosureDateTime[0])){
						echo $this->Form->input(null, array( 'name' => 'skin_closure_date', 'id' => 'skin_closure_date', 'label'=> false, 'div' => false,
								'error' => false, 'value' => isset($skinClosureDateTime[0])?date('m/d/Y', strtotime($skinClosureDateTime[0])):$stDate['0'],'class'=>'editable')); ?>
						<?php echo $this->Form->input(null, array('name' => 'skinclosure', 'id' => 'skinclosure', 'label'=> false,'div' => false,'error' => false,
								 'options'=> $timeOptions, 'default' => isset($skinClosureDateTime[1])?$skinClosureDateTime[1]:'','class'=>'editable'));
					}else{
						/*echo $this->Form->hidden(null, array( 'name' => 'skin_closure_date', 'id' => 'skin_closure_date', 'label'=> false, 'div' => false,
								'error' => false, 'value' => isset($skinClosureDateTime[0])?date('m/d/Y', strtotime($skinClosureDateTime[0])):$stDate['0'],'class'=>'editable')); ?>
						<?php echo $this->Form->hidden(null, array('name' => 'skinclosure', 'id' => 'skinclosure', 'label'=> false,'div' => false,'error' => false,
								 'options'=> $timeOptions, 'default' => isset($skinClosureDateTime[1])?$skinClosureDateTime[1]:'','class'=>'editable'));*/
						echo $stDate['0'].' '.$skinClosureDateTime[1];
					}
								  ?>
					</div>
					<?php }?>
					<div style="width: 270px; float: left;">
						<span style="display: block; font-size: 13px; font-family: arial;">
							<strong><?php echo __('Out Time'); ?>:</strong>
						</span>
						<?php if(!isset($outDateTime[0])){
						 echo $this->Form->input(null, array( 'name' => 'out_date', 'id' => 'out_date', 'label'=> false, 'div' => false,'error' => false,
								'class'=>$addClass.' allottime editable', 'value' => isset($outDateTime[0])?date('m/d/Y', strtotime($outDateTime[0])):$stDate['0'])); ?>
						
						<?php echo $this->Form->input(null, array('name' => 'outtime', 'id' => 'outtime', 'label'=> false,'div' => false,'error' => false,
								'class'=>$addClass.' allottime editable', 'options'=> $timeOptions, 'default' => isset($outDateTime[1])?$outDateTime[1]:''));}
						else{
								/*echo $this->Form->hidden(null, array( 'name' => 'out_date', 'id' => 'out_date', 'label'=> false, 'div' => false,'error' => false,
								'class'=>$addClass.' allottime editable', 'value' => isset($outDateTime[0])?date('m/d/Y', strtotime($outDateTime[0])):$stDate['0'])); ?>
						
						<?php echo $this->Form->hidden(null, array('name' => 'outtime', 'id' => 'outtime', 'label'=> false,'div' => false,'error' => false,
								'class'=>$addClass.' allottime editable', 'options'=> $timeOptions, 'default' => isset($outDateTime[1])?$outDateTime[1]:''));*/
								echo $stDate['0'].' '.$outDateTime[1];
									} ?>
					</div>
				</div>
				<?php if($this->Session->read('website.instance') != 'kanpur'){ ?>
				<div class="clr"></div>
				<div class="twoCol">
					<lable> <span> <?php echo __('Preference Card'); ?>
					</span> <?php 
					echo $this->Form->input(null,array('empty'=>'Please select','name'=>'preferencecard_id','options'=>$prefCard,'id' => 'card_title', 'label'=> false,'style'=> 'width:190px','value'=>$getOptDetails['OptAppointment']['preferencecard_id'],'class'=>'required'));
					?> </lable>
				</div> 
				<div class="clr"></div>
				<div class="twoCol">
					<label> <span> <?php echo __('Major/Minor'); ?>:
					</span> <?php echo $this->Form->input(null,array('name' => 'operation_type', 'id'=> 'operation_type', 'label' => false, 'div' => false, 'options' => array('major'=> 'Major', 'minor'=> 'Minor'), 'default'=> $getOptDetails['OptAppointment']['operation_type']));?>
					</label>
				</div>
		<div class="clr"></div>
				<div class="twoCol">
					<label> <span> <?php echo __('Surgery For Internal Report And Yojna'); ?>:
					</span> <?php echo $this->Form->input(null,array('type'=>'text','name' => 'internal_surgery_name', 'id'=> 'internal_surgery_name', 'label' => false, 'div' => false, 'default'=> $getOptDetails['OptAppointment']['operation_type']));
								echo $this->Form->input(null,array('type'=>'hidden','name' => 'internal_surgery_id', 'id'=> 'internal_surgery_id'));
					?>
					</label>
				</div>


				<?php } ?>
				<div class="clr"></div>
				<label> <span>Note: </span> <textarea cols="20" id="Description" name="note" rows="2" style="width: 95%; height: 70px"><?php echo isset($getOptDetails['OptAppointment']['id'])?$getOptDetails['OptAppointment']['description']:""; ?></textarea>
				</label>
				<?php echo $this->Form->input(null,array('name'=>'surgen_tariff_list_id','id'=> 'surgon_tariff_list_id','value'=>$getOptDetails['OptAppointment']['tariff_list_id'],'label' => false,'type'=>'hidden','div'=>false, 'style'=>'width:190px;'));?>

				<input id="timezone" name="timezone" type="hidden" value="" />
			</form>
		</div>
		<div class="toolBotton">
			<a id="Savebtn" class="imgbtn" href="javascript:void(0);"> 
			<span class="Save" title="Save the calendar">Save </span>
			</a>
			<?php //if(isset($getOptDetails['OptAppointment']['id'])){ ?>
			<!--  <a id="Deletebtn" class="imgbtn" href="javascript:void(0);">
          <span class="Delete" title="Cancel the calendar" style="font-size:12px;">Delete
          </span>
        </a>-->
			<?php //} ?>
			<a id="Closebtn" class="imgbtn" href="javascript:void(0);"> <span
				class="Close" title="Close the window">Close </span>
			</a>
		</div>
	</div>


	<script>
	var websiteInstance = '<?php echo $this->Session->read('website.instance');?>';

	function init() {
		$(".surgery_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "getSurgeryAutocomplete","admin" => false,"plugin"=>false)); ?>",
			select:function( event, ui ) {				
				var id = $(this).attr('id').split("_");
				var subID = id[1]+"_"+id[2];
				var currentPatientId = $("#patientid").val();
				
				$("#surgeryID_"+id[1]+"_"+id[2]).val(ui.item.id); 
				$("#surgenTariffListId_"+id[1]+"_"+id[2]).val(ui.item.tariff_list_id);

				var surgId = ui.item.id;  
				var exist = false;
				var thisFeild = ''; 
	            $(".surgeryID").each(function(key, value){  
	    			if(this.value == surgId){
	    				var idd = $(this).attr('id').split("_");
	        			thisField = idd[1]+"_"+idd[2]; 
	    				exist = true;
	    				return false;
	    			}
	    		});	
	    		
	           if(exist == true && subID !== thisField){
	            	alert('This surgery already selected'); 
					$("#surgeryID_"+subID).val('');
					$("#surgeryName_"+subID).val('');
					$("#surgeryName_"+subID).focus();
	   				return false;
				}

	           getAppointedSurgery(currentPatientId,surgId,subID);							// function call by mrunal
	            //alert(is_appointed);
	            
				
			},
			messages: {
		        noResults: '',
		        results: function() {}
		 	}
		});
	

		$(".doctor_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "getDoctors","admin" => false,"plugin"=>false)); ?>",
			select:function( event, ui ) {
				var id = $(this).attr('id').split("_"); 
				$("#doctorId_"+id[1]+"_"+id[2]).val(ui.item.id); 
 
				var subID = id[1]+"_"+id[2];
				var docId = ui.item.id;  
				var exist = false;
				var thisFeild = ''; 
				
	            $(".doctor_id").each(function(key, value){ 
    				var idd = $(this).attr('id').split("_"); 
	    			if(this.value == docId && idd[1] === id[1]){
	        			thisField = idd[1]+"_"+idd[2]; 
	    				exist = true;
	    				return false;
	    			}
	    		});	
				
	            if(exist == true && subID !== thisField ){
	            	alert('This doctor is already selected'); 
					$("#doctorId_"+subID).val('');
					$("#doctorName_"+subID).val('');
					$("#doctorName_"+subID).focus();
	   				return false;
				}
			},
			messages: {
		        noResults: '',
		        results: function() {}
		 }	
		});


		$("#internal_surgery_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "getPackageSurgeryAutocomplete","admin" => false,"plugin"=>false)); ?>",
				select:function( event, ui ) {				     
					$('#internal_surgery_id').val(ui.item.id);
			},
			messages: {
		        noResults: '',
		        results: function() {}
		 	}
		});
	}
	
$(document).ready(function(){
	init(); 
	 var options = {
             beforeSubmit: function() {
             	$('#busy-indicator').show(); 
                 return true;
             },
             dataType: "json",
             success: function(data) {
             	$('#busy-indicator').hide(); 
                 	alert(data.Msg);
                 	 if (data.IsSuccess) {
                     	if(parent.jQuery().fancybox) {
                     		parent.formChildFormSubmitted = $('#procedurecomplete').val();// parent variable @OR dashboard
                     		parent.jQuery.fancybox.close();
                        	}else
                         	CloseModelWindow(null,true);
                 }

             }
             
         };
     
	 $("#fmEdit").validate({
         submitHandler: function(form) { $("#fmEdit").ajaxSubmit(options); },
         errorElement: "div",
         errorClass: "cusErrorPanel",
         errorPlacement: function(error, element) {
             showerror(error, element);
         }
     });
     function showerror(error, target) {
         var pos = target.position();
         var height = target.height();
         var newpos = { left: pos.left, top: pos.top + height + 2 }
         var form = $("#fmEdit");
         error.appendTo(form).css(newpos);
     }
    
	 $("#Savebtn").click(function() {
	 	//BOF-Mahalaxmi for valid surgery name
	 //	$(document).on( 'click', '#Savebtn', function() {	     
		    var errors = 0;
		    $(".surgeonRow :hidden").map(function(){    	
               $('.alertMsg').each(function() {//loop through each value hidden serviceId        
        	    if( !$(this).val() ) {         					
          			$(this).parents('label').addClass('warning');
         			errors++;
    			} else if ($(this).val()) {
         			 $(this).parents('label').removeClass('warning');
   				 }               	 
               });		              
		    });
		    console.log(errors);
		    if(errors > 0){
		    	alert("Please Select Valid Surgery First.");
		        //$('#errorwarn').fadeIn("slow");
		      //  $('#errorwarn').text("Please Select Valid Service First");
		        return false;
		    }
		    // do the ajax..        
   // });
   		//EOF-Mahalaxmi for valid surgery name
		 $("#fmEdit").submit();

         /*
		var formData = $("#fmEdit").serialize();
		 $.ajax({
	        	url: "<?php echo $this->Html->url(array("action"=>"datafeed")); ?>"+'?method=adddetails/'+params,
	          	type: "POST", 
	         	data: formData,
	          	success:   function (data) {
	        	  var data = $.parseJSON(data);  
	        	  alert(data);
	           	},
	            error: function (error) {
	               alert('error;' + eval(error));
	            }
	      	});
	      	return false;
		var validatePerson = jQuery("#fmEdit").validationEngine('validate'); 
	 	if(!validatePerson){
	 		
 
		 	return false;
			 $("#fmEdit").submit(); 
		}else{
			$('#Savebtn').hide();
		} */
	});

		
     $("#Closebtn").click(function() { CloseModelWindow(); });
     
	if(websiteInstance == 'hope'){
		$("#calendarPatientNameText").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "newOTAutoComplete","IPD","OT","admin" => false,"plugin"=>false)); ?>",
			select:function( event, ui ) { 
				$("#admissionid").val(ui.item.admission_id);
				$("#patientid").val(ui.item.id);
				$("#calendarPatientNameValue").val(ui.item.id);
			},
			
			messages: {
		        noResults: '',
		        results: function() {}
		 	}
		});
		
		/*$("#calendarPatientNameText").autocomplete("<?php echo $this->Html->url(array("controller" => "Patients", "action" => "OTAutoComplete","admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'calendarPatientNameText,calendarPatientNameValue',
			onItemSelect:function (data1) { 
				
			}
		});*/
	}else{
		$("#calendarPatientNameText").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocompleteForPatientNameAndDob",0,'Patient.admission_type=IPD&Patient.is_discharge=0','Patient.admission_id',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
			valueSelected:true,
			showNoId:true,
			loadId : 'calendarPatientNameText,calendarPatientNameValue',
			onItemSelect:function (data1) { 
				if(websiteInstance == 'kanpur'){
					var chargeType = "<?php echo $chargeType;?>";
					$.ajax({
				          url: "<?php echo $this->Html->url(array("action" => "getOtServiceCharges", "admin" => false)); ?>",
				          type: "GET",
				          dataType:"json",
				          data: "patientId="+$('#calendarPatientNameValue').val(),
				          success:   function (data) {
				        	  //var data = $.parseJSON(data); 
				            $.each( data, function( key, value ) {
					            $('input[name="ot_service['+value.TariffList.name+']"]').val($.trim(value.TariffAmount[chargeType]));
				            	console.log(value.TariffList.name);
				            	console.log(value.TariffAmount[chargeType]);
							});
				           }
				      });
				}
			}
		});
	}
	

          $("#opt_id").change(function() {
          $('#busy-indicator').show();
          var data = 'opt_id=' + $('#opt_id').val() ;
          // for surgery category name field //
          $.ajax({url: "<?php echo $this->Html->url(array("action" => "getOptTableList", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) {  $('#changeOptTableList').show(); $('#changeOptTableList').html(html);  $('#busy-indicator').hide();  } });

         });

         // show service group and service if anaesthetist select //
      /*  var departmentVal = $('#department_id').val(); alert(departmentVal);
         if(departmentVal) {
           $('#anaesthesia_service_group_id').attr("class", "required safe");
           $('#anaesthesia_tariff_list_id').attr("class", "required safe");
         } else {
           $('#anaesthesia_service_group_id').removeAttr("class", "required safe");
           $('#anaesthesia_tariff_list_id').removeAttr("class", "required safe");
         }
        $('#department_id').change(function(){
            departmentVal = $('#department_id').val();
                  if(departmentVal != "") {
                     $('#showAnaesthesiaServiceGroup').show();
                     $('#showAnaesthesiaService').show();
                     $('#anaesthesia_service_group_id').attr("class", "required safe");
                     $('#anaesthesia_tariff_list_id').attr("class", "required safe");
                  } else {
                     $('#showAnaesthesiaServiceGroup').hide();
                     $('#showAnaesthesiaService').hide();
                     $('#anaesthesia_service_group_id').removeAttr("class", "required safe");
                     $('#anaesthesia_tariff_list_id').removeAttr("class", "required safe");
                  }
          });*/
          if(websiteInstance == 'kanpur'){
        	  
          	if($('select[name=procedurecomplete]').val() == 1) {
                  $('#allottime').show('slow');
                  $('.allottime').addClass('required safe');
               } else {
                  $('#allottime').hide('slow');
                  $('.allottime').removeClass('required').removeClass('safe');
               }
          	if(parent.jQuery().fancybox) {
        		//  $("input").not(".editable").prop("readonly",true);
        		//  $("#fmEdit input:not(.editable)").prop("readonly",true);
        		  $( "#fmEdit input:not(.editable)" ).attr("readonly", "readonly");
        		  $( "#fmEdit select:not(.editable)" ).attr("disabled", "disabled");
        		  $('#editOnly').val(1);
        	}else{
            	$('.notForKanpur , .allottime, #allottime').hide();
        	}
  	        // drop down timepicker for OT in time //
  	        $('select[name=procedurecomplete]').change(function(){
  	                  if($('select[name=procedurecomplete]').val() == 1) {
  	                     $('#allottime').fadeIn('slow');
  	                     $('.allottime').addClass('required safe');
  	                  } else {
  	                	  $('#allottime').hide('slow');
  	                      $('.allottime').removeClass('required').removeClass('safe');
  	                  }
  	        });
          }
    	// for automatic patient search//
     /*   $("#admissionid").autocomplete("<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "autoSearchAdmissionId", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
                                onSelected: function(value) { alert(value);}
                        // on select change the patient name value automatically //
			}).result(function(event, optiondata, formatted) {
                          var paid = $('#admissionid').val();
                          var data = 'paid=' + paid ;
                          // for patient name field //
                         $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetPatientName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#patientname').val(html); $('#busy-indicator1').hide();} });
                         // for diagnosis field //
                         $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetDiagnosisName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#diagnosis').val(html); $('#busy-indicator1').hide();} });

                        });*/
        // for automatic patient search//
       /* $("#patientname").autocomplete("<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "autoSearchPatientName", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
                        // on select change the admission value automatically //
			}).result(function(event, data, formatted) {
                          var patientname = $('#patientname').val();
                          var patient_admissionid = patientname.substring(patientname.indexOf("(")-1, patientname.indexOf(")")+1);
                          $('#patientname').val(patientname.replace(patient_admissionid,''));
                          $('#admissionid').val(patient_admissionid.replace(/[\(\)\s]/g,''));
                          var paid = $('#admissionid').val();
                          var data = 'paid=' + paid ;
                          // for diagnosis field //
                          $.ajax({url: "<?php echo $this->Html->url(array("controller" => "doctor_schedules", "action" => "ajaxGetDiagnosisName", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { $('#diagnosis').val(html); $('#busy-indicator1').hide();} });
                        });*/

         $("#surgery_category_id").change(function() {
			var category=$('#surgery_category_id option:selected').text();
			<?php if($this->Session->read('website.instance')=='vadodara'){?>
				 //if(category.contains("Dummy")){
				 if(category.indexOf("Dummy") > -1){
						$('#dummy_surgery').show();
	             }else{
	            	 $('#dummy_surgery').hide();
	             }
            <?php }?>
          $('#busy-indicator').show();
          //$('#changeSurgerySubcategoryList').hide();
          var surgery_category = $('#surgery_category_id').val();
          var data = 'surgery_category=' + surgery_category ;
          // for surgery category name field //
         /* $.ajax({
              url: "<?php echo $this->Html->url(array("action" => "getSurgerySubCategoryList", "admin" => false)); ?>",
              type: "GET",
              data: data,
              success:   function (html) {
                  if(html == "norecord"){
                       $('#changeSurgerySubCategoryList').hide();
                  } else {
                      $('#changeSurgerySubcategoryList').show();
                      $('#changeSurgerySubcategoryList').html(html);
                  }
                  $('#busy-indicator').hide();
               }
          });*/
          $.ajax({
              url: "<?php echo $this->Html->url(array("action" => "getSurgeryList", "admin" => false)); ?>",
              type: "GET",
              data: data,
              success:   function (html) {
              	$('#changeSurgeryList').show();
             	$('#changeSurgeryList').html(html);
             	if ( $("#surgery_id option[value='Dummy']").length != 0 ){
             	 $("#surgery_id option:selected").attr("Dummy", "selected");
             	}
             	$('#busy-indicator').hide(); 
              } 
          });
         });

         // remove error pop up //
       /*  $(".infocontainer").click(function () {
           $("div:.cusErrorPanel").css({'display' : 'none'});
         });
*/
 		//BOF-Mahalaxmi for implant service //+"/service_category_id="+"<?php echo $implantServiceCatId?>",	
		$(".implant_name").autocomplete({
							source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","SurgicalImplant","id&name",'null','null','null','is_deleted=0&is_active=1',"admin" => false,"plugin"=>false)); ?>", 
							select:function( event, ui ) { 											  					
								$("#implantId_1_1").val(ui.item.id); 									
							},
							messages: {
						        noResults: '',
						        results: function() {}
							 }
							});
		//EOF-Mahalaxmi for implant service


});


$('#doctor_id').change(function(){
            var surgenVal = $('#doctor_id').val();
                  /*if(surgenVal != "") {
                     $('#showSurgenServiceGroup').show();
                      $('#autoservice').show();
                     $('#showSurgenService').show();autoservice
                     $('#surgen_service_group_id').attr("class", "required safe");
                     $('#surgen_tariff_list_id').attr("class", "required safe");
                  } else {
                     $('#showSurgenServiceGroup').hide();
                      $('#autoservice').hide();
                     $('#showSurgenService').hide();
                     $('#surgen_service_group_id').removeAttr("class", "required safe");
                     $('#surgen_tariff_list_id').removeAttr("class", "required safe");
                  }*/
        });
 /*$(".surgeon").live('change',function() {
	 
	var surgeonOption = $('#doctor_id').val();
	var asstOneOption = $('#asstDoctorIdOne option:selected').text();
	var asstTwoOption = $('#asstDoctorIdTwo option:selected').text();alert(asstTwoOption);
	$("#doctor_id option[value*='"+asstOneOption+"/"+asstTwoOption+"']").prop('disabled',true);
	///$("#asstDoctorIdOne option[value*='"+surgeonOption+"/"+asstTwoOption+"']").prop('disabled',true);
//	$("#asstDoctorIdTwo option[value*='"+surgeonOption+"/"+asstOneOption+"']").prop('disabled',true);
	//$(".surgeon option[value=" + doc + "]").attr("disabled", "disabled");	
	//$('#doctor_id option:contains({"'+asstTwoOption+'" , "'+asstOneOption+'" })').attr("disabled","disabled");
});*/


$('#surgen_service_group_id').change(function(){
$('#autoservicesearch').val("Search Service");
$("#busy-indicator").fadeIn();
    $.ajax({async:true, beforeSend:function (XMLHttpRequest) {
 },
     complete:function (XMLHttpRequest, textStatus) { $("#busy-indicator").remove();$("#busy-indicator").fadeOut();},
      data:{anaesthesia_service_group_id:$("#surgen_service_group_id").val(),surgeon:"true"},
      dataType:"html",
      success:function (data, textStatus) {$("#showSurgenService").html(data);},
       url:"<?php echo $this->Html->url(array("action"=>'getAnaesthesiaServices'));?>"

        });
     });


$('#department_id').change(function(){
    var anesVal = $('#department_id').val();
          if(anesVal != "") {
             $('#showAnaesthesiaServiceGroup').show();
             $('#autoserviceAnaesthesia').show();
             $('#showAnaesthesiaService').show();
             $('#anaesthesia_service_group_id').attr("class", "required safe");
             $('#anaesthesia_tariff_list_id').attr("class", "required safe");
          } else {
             $('#showAnaesthesiaServiceGroup').hide();
             $('#autoserviceAnaesthesia').hide();
             $('#showAnaesthesiaService').hide();
             $('#anaesthesia_service_group_id').removeAttr("class", "required safe");
             $('#anaesthesia_tariff_list_id').removeAttr("class", "required safe");
          }
});
$('#anaesthesia_service_group_id').change(function(){
$('#anaesthesia').val("Search Service");
$("#busy-indicator").fadeIn();
$.ajax({async:true, beforeSend:function (XMLHttpRequest) {
},
complete:function (XMLHttpRequest, textStatus) { $("#busy-indicator").remove();$("#busy-indicator").fadeOut();},
data:{anaesthesia_service_group_id:$("#anaesthesia_service_group_id").val()},
dataType:"html",
success:function (data, textStatus) {$("#showAnaesthesiaService").html(data);},
url:"<?php echo $this->Html->url(array("action"=>'getAnaesthesiaServices'));?>"

});
});

/*
$('#anaesthesia_service_group_id').change(function(){
//$("#busy-indicator3").fadeIn();
    $.ajax({async:true, beforeSend:function (XMLHttpRequest) {
 },
     complete:function (XMLHttpRequest, textStatus) {$("#busy-indicator").remove();$("#busy-indicator3").fadeOut();},
      data:{anaesthesia_service_group_id:$("#anaesthesia_service_group_id").val()},
      dataType:"html",
      success:function (data, textStatus) {$("#showAnaesthesiaService").html(data);},
       url:"<?php echo $this->Html->url(array("action"=>'getAnaesthesiaServices'));?>"

        });
     });*/

$('#autoservicesearch').focus( function(){
    if($(this).val() =="Search Service"){
        $(this).val("");
    }
    if($('#surgen_service_group_id').val() ==""){
        alert("Please select Surgeon Service Group");
        return false;
    }
	$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList",
		 				                    "name",'null','null','service_category_id', "admin" => false,"plugin"=>false)); ?>/service_category_id="+$('#surgen_service_group_id').val(), {
                                            	matchSubset:1,
                            				matchContains:1,
                            				autoFill:true,
		 							    	onItemSelect:function (data) {
		 									var itemID = data.extra[0];
		 									$("#surgen_tariff_list_id").val(itemID);
		 								}
		 							}).result(function(event, data, formatted) {
	                                   $("#surgen_tariff_list_id").val(data[1]);
	                                   
                        });

});
$('#autoservicesearch').blur( function(){
    if($(this).val() == ""){
        $(this).val("Search Service");
    }
});

/*$(document).ready(function(){
$("#anaesthesia_id").autocomplete("<?php //echo $this->Html->url(array("controller" => "app", "action" => "autocomplete",
	//	"TariffList",'id','name','anaesthesia_id='.Configure::read('anaesthesiaId'),'service_category_id',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
	valueSelected:true,
	    showNoId:true,
	selectFirst: true,
	loadId : 'anaesthesia_id,anaesthesia'
	});
});*/


$('#anaesthesia').focus( function(){ 
    if(  $(this).val() =="Search Service"){
       $(this).val("");
   }
   if($('#anaesthesia_service_group_id').val() ==""){
       alert("Please select anaesthesia Service Group");
       return false;
   }
	$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList",
		 				                    "name",'null','null','service_category_id', "admin" => false,"plugin"=>false)); ?>/service_category_id="+$('#anaesthesia_service_group_id').val(), {
                                           	matchSubset:1,
                           				matchContains:1,
                           				autoFill:true,
		 							    	onItemSelect:function (data) {
		 									var itemID = data.extra[0];
		 									$("#anaesthesia_tariff_list_id").val(itemID);
		 								}
		 							}).result(function(event, data, formatted) {
	                                   $("#anaesthesia_tariff_list_id").val(data[1]);
                       });

});


$('#anaesthesia').blur( function(){
   if($(this).val() == ""){
       $(this).val("Search Service");
   }
});

$('#surgery_id').on('change',function(){
	var id =$(this).val();
	$.ajax({
		  type : "POST",
		  url: "<?php echo $this->Html->url(array("action" => "getSurgeryTariff", "admin" => false)); ?>",
		  context: document.body,
		  beforeSend:function(data){
				$('#busy-indicator').show();
				},
		  data:'id='+id,		  	  		  
		  success: function(data){ 
			  $('#surgon_tariff_list_id').val($.trim(data));
			  $('#busy-indicator').hide();
			}
		  
	});
	if(websiteInstance == 'kanpur'){
		 $.ajax({
	          url: "<?php echo $this->Html->url(array("action" => "getOtRuleList", "admin" => false)); ?>",
	          type: "GET",
	          data: "surgery_id="+id+"&patientId="+$('#calendarPatientNameValue').val(),
	          beforeSend:function(data){
					$('#busy-indicator').show();
					},
	          success:   function (html) {
	             $('#updateOTRule').html(html);
	             $('#busy-indicator').hide();
	           }
	      });
    }
    
});
$(function (){
	if(websiteInstance == 'kanpur' && $('#doctor_id').val() == ''){
		 $.ajax({
	          url: "<?php echo $this->Html->url(array("action" => "getOtRuleList", "admin" => false)); ?>",
	          type: "GET",
	          data: "surgery_id="+$('#surgery_id').val()+"&tariff_standard_id=<?php echo $getPatientDetaiils['Patient']['tariff_standard_id'];?>",
	          beforeSend:function(data){
					$('#busy-indicator').show();
					},
	          success:   function (html) {
	             $('#updateOTRule').html(html);
	             $('#busy-indicator').hide();
	           }
	      });
   }
});

function addFieldSurgeon(no){
	var count = parseInt($("#nofield_"+no).val())+1;
	var field = '';
	field += '<tr id="row_'+no+'_'+count+'" class="surgeonRow">';
	field += "<td>"; 
	field += "</td>";
	field += "<td>";
	field += 	"<div class='twoCol'>";
	field += 		"<label><span>User:</span> ";
	field += 		"<select name='data[surgery][user_type]["+no+"]["+count+"]' id='userType_"+no+"_"+count+"' style='width:190px;'><option value='Surgeon'>Surgeon</option><option value='Assistant' selected='selected'>Assistant</option></select>";
	field += 		"</label> ";
	field += 	"</div>";
	field += "</td>";
	field += "<td>";
	field += 	"<div class='twoCol'>";
	field += 		"<label><span>Name:</span> ";
	field += 			"<input type='text' id='doctorName_"+no+"_"+count+"' class='doctor_name required safe' name='data[surgery][doctor_name]["+no+"]["+count+"]' style='width:190px;'/>";
	field += 			"<input type='hidden' id='doctorId_"+no+"_"+count+"' class='doctor_id' name='data[surgery][doctor_id]["+no+"]["+count+"]'/>";
	field += 		"</label> ";
	field += 	"</div>";
	field += "</td>";
	field += "<td>";
	//field += "<div class=''>";
	//field += 	"<label><span>&nbsp;</span>"; 
	field += 		 '<a href="javascript:void(0);" id="delete" onclick="deletRow('+no+','+count+');"> <?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?></a>';
	//field += 	"</label>";
	//field += "</div>";
	field += "</td>";
	field += "</tr>";

	$("#SurgeonTable_"+no).append(field);
	$("#nofield_"+no).val(count);
	init();
}


function addFieldsSurgery(){
	var no_of_field = parseInt($("#no_of_field").val())+1; 
	var field = '';
	field += '<tr id="mainRow_'+no_of_field+'" class="surgeonRow">';
	field += '<td>';
	field += '<table id="SurgeonTable_'+no_of_field+'">';
	field += 	'<tr id="row_'+no_of_field+'_1">';
	field += 		'<td>';
	field += 			'<div class="twoCol">';
	field += 				'<label><span>Surgery<font color="red"> *</font>:</span> ';
	field += 					'<input name="data[surgery][surgery_name]['+no_of_field+']" id="surgeryName_'+no_of_field+'_1" style="width:190px;" class="surgery_name required safe"/>';
	field +=					'<input type="hidden" id="surgeryID_'+no_of_field+'_1" name="data[surgery][surgery_id]['+no_of_field+']" class="alertMsg surgeryID"/>';
	field +=					'<input type="hidden" id="surgenTariffListId_'+no_of_field+'_1" name="data[surgery][surgen_tariff_list_id]['+no_of_field+']"/>';
	field +=				'</label>'; 
	field +=			'</div>';
	field +=		'</td>';
	field += 		"<td>";
	field += 			"<div class='twoCol'>";
	field += 				"<label><span>User:</span> ";
	field += 					"<select name='data[surgery][user_type]["+no_of_field+"][1]' id='userType_"+no_of_field+"_1' style='width:190px;'><option value='Surgeon' selected='selected'>Surgeon</option></select>";
	field += 				"</label> ";
	field += 			"</div>";
	field += 		"</td>";
	field += 		"<td>";
	field += 			"<div class='twoCol'>";
	field += 				"<label><span>Name:</span> ";
	field += 					"<input type='text' name='data[surgery][doctor_name]["+no_of_field+"][1]' class='doctor_name required safe' id='doctorName_"+no_of_field+"_1' style='width:190px;'/>";
	field += 					"<input type='hidden' id='doctorId_"+no_of_field+"_1' class='doctor_id' name='data[surgery][doctor_id]["+no_of_field+"][1]'/>";
	field += 				"</label> ";
	field += 			"</div>";
	field += 		"</td>";	
	field += 		"<td >";
	field += 			"<div class='twoCol'>";
	field += 				"<label><span>Surgical Implant:</span> ";
	field += 					"<input type='text' name='data[surgery][implant_name]["+no_of_field+"]' class='implant_name required safe' id='implantName_"+no_of_field+"_1' style='width:190px;'/>";
	field += 					"<input type='hidden' id='implantId_"+no_of_field+"_1' class='implant_id' name='data[surgery][implant_id]["+no_of_field+"]'/>";
	field += 				"</label> ";
	field += 			"</div>";
	field += 		"</td>";
	field += 		"<td>";
	field += 			"<div class='twoCol'>";
	field += 				"<label><span></span> ";
	field += 					"<textarea type='textarea' name='data[surgery][implant_description]["+no_of_field+"]' class='implant_description safe' id='doctorDescription_"+no_of_field+"_1' style='width:190px;' rows='1' />";	
	field += 				"</label> ";
	field += 			"</div>";
	field += 		"</td>";
	field += 		"<td>";
	//field += 			"<div class=''>";
	//field += 				"<label><span>&nbsp;</span>"; 
	//field += 					 '<a href="javascript:void(0);" id="delete" onclick="deletRow('+no_of_field+',1);"> <?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Row", "title"=>"Remove Item")); ?></a>';
	//field += 				"</label>";
	//field += 			"</div>";
	field += 		"</td>";
	field += 	"</tr>";
	field += '</table>';
	field += '</td>';
	field += '<td valign="bottom">';
	//field += 	'<div class="twoCol">';
	//field += 		'<label><span>&nbsp;</span> ' ;
	field += 			'<input name="" type="button" value="Add More Surgeon" class="blueBtn Add_more" onclick="addFieldSurgeon('+no_of_field+')" />';
	field += 			'<input type="hidden" value="1" id="nofield_'+no_of_field+'"/>';
	//field += 		'</label> ';
	//field += 	'</div>';
	field += '</td>';
	field += '<td valign="bottom">';
	//field += 	'<div class="twoCol">';
	//field += 		'<label><span>&nbsp;</span> ' ; 
	field += 			 '<a href="javascript:void(0);" id="delete" onclick="deleteSurgeryRow('+no_of_field+');"> <?php echo $this->Html->image("icons/cross.png",array("alt"=>"Remove Surgery Row", "title"=>"Remove Surgery Row")); ?></a>';
	//field += 		'</label> ';
	//field += 	'</div>';
	field += '</td>';
	field += '</tr>';

	$("#SurgeryTable").append(field);
	//BOF-Mahalaxmi for implant service //+"/service_category_id="+"<?php echo $implantServiceCatId?>",	
		$(".implant_name").autocomplete({
							source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","SurgicalImplant","id&name",'null','null','null','is_deleted=0&is_active=1',"admin" => false,"plugin"=>false)); ?>", 
							select:function( event, ui ) { 						
								currentId = $(this).attr('id') ;
  								splittedVar = currentId.split("_");  				
  								ImplantId1 = splittedVar[1];	   	
  								ImplantId2 = splittedVar[2];				  					
								$("#implantId_"+ImplantId1+"_"+ImplantId2).val(ui.item.id); 										
							},
							messages: {
						        noResults: '',
						        results: function() {}
							 }
							});
		//EOF-Mahalaxmi for implant service
	$("#no_of_field").val(no_of_field);
	init();
}
 
	function deletRow(surgeryID,SurgeonRow){ 
		$("#row_"+surgeryID+"_"+SurgeonRow).remove(); 
	}

	function deleteSurgeryRow(surgeryID){ 
		$("#mainRow_"+surgeryID).remove(); 
	}


	$(document).ready(function(){
		$( "#stpartdate" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',	
			onSelect:function(date){
				var startTime = date.split(" ")[1];
				$("#stparttime").val(startTime);
			},	 	 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
		});

		$( "#etpartdate" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',	
			onSelect:function(date){
				var endTime = date.split(" ")[1];
				$("#etparttime").val(endTime);
			},		 
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
		});
	}); 

	$('#ot_charge').click(function(){
		patientID=$('#patientid').val();
		if(!patientID){
			alert('Please Select Patient First');
			return false;
		}
		$.fancybox(
			    {	
			    	'autoDimensions':false,
			    	'width'    : '85%',
				    'height'   : '90%',
				    'autoScale': true,
				  	'transitionIn': 'fade',
				    'transitionOut': 'fade', 
				    'transitionIn'	:	'elastic',
					'transitionOut'	:	'elastic',
					'speedIn'		:	600, 
					'speedOut'		:	200,				    
				    'type': 'iframe',
				    'iframe' : {
						scrolling : 'auto',
						preload   : false //opening the fancy box before it gets loaded 
					},
				    'helpers'   : { 
				    	   'overlay' : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox 
				    	  },
				    'href' : "<?php echo $this->Html->url(array("controller" =>"NewOptAppointments","action" =>"otExtraService","admin"=>false)); ?>"+'/'+patientID
		});

	});

	
	function getAppointedSurgery(currentPatientId,surgeryId,subID){
		var is_appointed = false;
		 $.ajax({
	          url: "<?php echo $this->Html->url(array("action" => "getPatientSurgeryId", "admin" => false)); ?>"+"/"+currentPatientId+"/"+surgeryId,
	          type: "GET",
	          //dataType: "json",
	          success:   function (data) {
	        	  var obj = jQuery.parseJSON( data );
	        	  $.each( obj, function( id, value ) {
		        	  if(value == true){
		        		result = confirm("The surgery already appointed for this patient.\n Would you like to proceed?");
		        		if(result == false){
	        		    	$("#surgeryID_"+subID).val('');
							$("#surgeryName_"+subID).val('');
							$("#surgeryName_"+subID).focus();
		   					return false;
		        		}
		        	  }
				  });
	           }
			  
	      });
		 
	}
	
	
  </script>
  
  