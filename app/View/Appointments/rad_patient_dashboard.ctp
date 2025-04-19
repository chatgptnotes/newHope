<style>
.elapsedRed {
	color: red;
}

.elapsedGreen {
	color: Green;
}

.elapsedYellow {
	color: yellow;
}
</style>

<!-- <div class="patient_info"> -->
<div class="">
RAD Dashboard
	<div id="no_app">
		<?php 
		if(empty($data)&& $closed=='closed'){
			echo "<span class='error'>";
			echo __('There are no Closed Appointments.');
			echo "</span>";
		}
		else if(empty($data)){
			echo "<span class='error'>";
			echo __('There is no pending appointment.');
			echo "</span>";
		}
		?>
	</div>
	<div id="parent-content" style="display: none;">
		<div id="chambers"
			style="height: 100px; width: 350px; background-color: rgb(204, 204, 204); text-align: center; padding: 10px; border-radius: 6px;">
			<span style="float: right;"> <?php 
			echo $this->Html->link($this->Html->image('icons/cross.png',array("title"=>"Remove","style"=>"cursor: pointer;" ,"alt"=>"Remove")),
							"#",array("onclick"=>"onCompleteRequest();",'escape'=>false));
				?>
			</span>
			<p style="color: #000; font-weight: bold;">Examination Room</p>
			<?php 
			echo $this->Form->input('Room',array('empty'=>'Please Select','div'=>false,'label'=>false,'type'=>'select','options'=>$chambers,'div'=>false,'class'=>"textBoxExpnd",'id'=>'appointment-room'));

			?>
		</div>
	</div>
	<?php $role=$this->Session->read('role');
		if(!empty($data)){ 
			$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%"
		class="table_format textAlign">
		<tr class="row_title">
			<?php if($future != 'future'){?>
			<td width="2%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Action Pending");?></td>
			<?php }?>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Patient Image");?></td>
			<td width="2%" style="text-align: center;" valign="top"
				class="table_cell"><?php  
				echo $this->Paginator->sort('Patient.lookup_name', __('Patient Name', true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));
				?></td>
			<!--  <td width="1%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Gender");?></td>-->
			<td width="3%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo $this->Paginator->sort('Person.dob',__("Gender,Age,Date Of Birth",true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));
				 //echo __("Gender<br>Age <br> DOB");?></td>			
		<!-- 	<td width="2%" valign="top"
				style="text-align: center; min-width: 84px;" class="table_cell"><?php echo $this->Paginator->sort('Appointment.status',__("Status",true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));?>
			</td>-->
			<?php if(($role != Configure::read('doctorLabel') && $role != Configure::read('nurseLabel')) && $role!=Configure::read('medicalAssistantLabel') && !$future){?>
			<!-- <td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __('Positive ID Done')?></td>				
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __('Eligibility Check')?></td> -->
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Admit To Hospital");?></td>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Payment Received");?></td>
			
			<?php }?>
			<?php if(($role==Configure::read('doctorLabel')||$role==Configure::read('nurseLabel')||$role==Configure::read('medicalAssistantLabel') || $role==Configure::read('residentLabel'))&& $future!='future'){ ?>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Medication Administered");?></td>
			<?php }?>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Registered In Portal");?></td>
			<?php if($future != 'future'){?>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __('Managed Critical Alerts')?></td>
			<?php }?>
			<?php if($future != 'future'){?>
			<td width="6%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Critical Results");?></td>
			<!--  <td width="6%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Send Referrals");?></td>-->
			<?php }?>
			<td width="1%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo $this->Paginator->sort('Appointment.start_time',__("Scheduled   Arrived   Elapsed ",true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));
				?>
			</td>
			<!-- <td width="1%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __(" Arrived  Time");?></td> -->
			<?php //if(($role==Configure::read('doctorLabel')||$role==Configure::read('nurseLabel')|| $role==Configure::read('medicalAssistantLabel')) && $future!='future'){?>
			<td width="3%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Initial Assessment");?></td>
				<?php //}  if(($role==Configure::read('doctorLabel')||$role==Configure::read('nurseLabel') || $role==Configure::read('medicalAssistantLabel') || $role==Configure::read('residentLabel')) && $future!='future'){ ?>
			<td width="1%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Document Signed");?></td>
			<?php //}?>
			<?php if($future == 'future'||!empty($dateSearch)){?>
			<td width="2%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo $this->Paginator->sort('Appointment.date',__("Date",true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));
				?></td>
			<?php }?>
			<?php if(($role!=Configure::read('doctorLabel')) || !empty($rtSelect)){?>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Provider / Room / Nurse");?></td>
			<?php }?>
			<?php if($future != 'future'){ ?>
			<?php //if(/*$role!=Configure::read('nurseLabel')) || */!empty($viewAll)){?>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo 'Task'?></td>
			<?php //}?>
			<!--  <td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Room Allotted");?></td> -->
			<?php }?>			
			<td width="2%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Reason of visit");?></td>
			<?php if($future == 'future'){?>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Instruction");?></td>
			<?php }?>
			<?php if(($role == Configure::read('backOfficeLabel')) && !$future){?>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Claim Docs Sent");?></td>
			<?php }?>
			<?php if(($role != Configure::read('doctorLabel') && $role != Configure::read('nurseLabel')) && $role!=Configure::read('medicalAssistantLabel') && !$future){?>
			<!--<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Followup Schedule");?></td> -->
			 <td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Encounter Closed");?></td>
			<!--<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Payment & Receipt");?></td> -->
			<?php } ?>
		</tr>
		<?php 
		$toggle =0;
		$i=0 ;
		//No need of these status
		/* if(strtolower($appointment['Appointment']['role']) == Configure::read('patientLabel')){
			$status = array(
					array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown'),
					array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue'),
					array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled'),
					array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow','disabled'=>'disabled'),
					array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled'),
					array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'));
		}else{
			$status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown'),
							array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue'),
							array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled'),
							array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow','disabled'=>'disabled'),
							array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled'),
							array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'));
							}
							*/

		//	$seen_status = array('In Lobby'=>'In Lobby','Pending'=>'Pending','In Room'=>'In Room','Seen'=>'Seen') ;
		/* $seen_status = array(
		 array('name' => 'In Lobby',  'value' => 'In Lobby', 'class'=>'blue'),
		 array('name' => 'Pending',   'value' => 'Pending', 'class'=>'red'),
		 array('name' => 'In Room',   'value' => 'In Room', 'class'=>'green'),
		 array('name' => 'Seen',      'value' => 'Seen',    'class'=>'orange')); */
		//
		//($data);
		// 				if($appointment[0]['Appointment']['status']=='Arrived'){
		// 					$status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown'),
		// 							array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue'),
		// 							array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue'),
		// 							array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow'),
		// 							array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen'),
		// 							array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen'));
		// 					}
	
	foreach($data as $appkey => $appointment){
		$futureFlag=0;
		foreach($schedule as $sche){
				if($sche['Patient']['id']==$appointment['Patient']['id'] && $sche[0]['scheCount']>=1){
					$futureFlag=1;
				}
			}
			$i++;
			if($toggle == 0) {
			   echo "<tr class='row_gray'>";
			   $toggle = 1;
		    }else{
			   echo "<tr class='row_gray_dark'>";
			   $toggle = 0;
		    }
		    ?>
		<?php 
		if($appointment['Appointment']['is_future_app']==1){
		if($appointment['Appointment']['status']!='Cancelled' && $appointment['Appointment']['status']!='No-Show'){
			$appointment['Appointment']['status']='Scheduled';	//If patient has not been registered
		}
	}
	if($appointment['Appointment']['status']=='Pending'||empty($appointment['Appointment']['status'])){
			$appointment['Appointment']['status']='Scheduled';
		}
	if($future != 'future'){
		if($role == Configure::read('doctorLabel')){
			//Action for doctor login when the  Document has not signed and status is other than scheduled
			if($appointment['Appointment']['status']!='Seen' && $appointment['Appointment']['status']!='Closed'){
				$classBulb='yellowBulb';
			}
			else{
				$classBulb='greyBulb';
			}
 		}else if($role == Configure::read('nurseLabel')){
			//Action for Nurse login when initial asses has not filled or status is other than schedule
		    if(empty($appointment[0]['initCount']) &&($appointment['Appointment']['status']!='' && $appointment['Appointment']['status'] != 'Scheduled' && $appointment['Appointment']['status']!='Pending' && $appointment['Appointment']['status']!='Cancelled' && $appointment['Appointment']['status']!='No-Show') ){
				$classBulb='yellowBulb';
			}else{
				$classBulb='greyBulb';
			}
		 }else {
			//Action
		    if(($appointment['Appointment']['status']=='Arrived'|| $appointment['Appointment']['status']=='Seen')){
				if($appointment['Appointment']['status']=='Arrived'){
					if(empty($appointment['Patient']['nurse_id']) || empty($appointment['Appointment']['chamber_id'])){
						$classBulb='yellowBulb';
					}
					else{
						$classBulb='greyBulb';
					}
				}else if ($futureFlag!=1 && empty($appointment['Note']['has_no_followup'])){
					if(empty($appointment['Appointment']['has_no_followup'])){
						$classBulb='yellowBulb';
					}
					else{
						$classBulb='greyBulb';
					}

				}else{
					$classBulb='greyBulb';
				}
			}// end of if
			else{
					$classBulb='greyBulb';
				}
			}//end of else?>
		<td width="2%" style="text-align: center; padding: 13px 0 0 11px;"
			valign="top" class="<?php echo $classBulb;?> table_cell"
			id="<?php echo "blink_".$appointment['Appointment']['id']; ?>"></td>
		<?php }// end of $future if?>
		<?php  
		if($appointment['Person']['dob'] == '0000-00-00' || $appointment['Person']['dob'] == ''){
			$age = "";
		}else{
		$date1 = new DateTime($appointment['Person']['dob']);
		$date2 = new DateTime();
		$interval = $date1->diff($date2);
		$date1_explode = explode("-",$appointment['Person']['dob']);
		$person_age_year =  $interval->y . " Year";
		$personn_age_month =  $interval->m . " Month";
		$person_age_day = $interval->d . " Day";
		if($person_age_year == 0 && $personn_age_month > 0){
				$age = $interval->m ;
				if($age==1){
					$age=$age . "M";
				}else{
					$age=$age . "M";
				}
			}else if($person_age_year == 0 && $personn_age_month == 0 && $person_age_day > -1){
				$age = $interval->d . " " + 1 ;
				if($age==1){
					$age=$age . "D";
				}else{
					$age=$age . "D";
				}
			}else{
				$age = $interval->y;
				if($age==1){
				$age=$age . "Y";
				}else{
				$age=$age . "Y";
				}
			}
	}?>
		<?php /** --gaurav EOF-------- */ ?>

		<?php $tooltip  ='<b>Age: </b>'.($age).'</br> <b>Mobile No: </b>'.$appointment['Person']['mobile']
		.'<br /><b> Email: </b>'.$appointment['Person']['email'].'<br /><b> Patient UID: </b>'.$appointment['Patient']['patient_id']?>

		<td style="text-align: center;" class="tdLabel tooltip" id="boxSpace"
			title="<?php echo $tooltip?>"><?php //Pic
		$tooltip = '';
		if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$appointment['Person']['photo']) && !empty($appointment['Person']['photo'])){ ?>
			<?php echo $this->Html->link($this->Html->image("/uploads/patient_images/thumbnail/".$appointment['Person']['photo'], array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$appointment['Person']['id']), array('escape' => false)); ?>
			<?php }else{
				echo $this->Html->link($this->Html->image('icons/default_img.png', array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$appointment['Person']['id']), array('escape' => false));
			}?>
		</td>
		<td
			style="text-align: left; float: left; width: 110px; margin: 20px 0 0 0;"
			class="tdLabel" id="boxSpace"><?php  //Patient Name
			$name=trim($appointment['Patient']['lookup_name']);
			//$text = str_replace(" ", " <br/>", $name);
			$text = $name;//by mahalaxmi
			if($appointment['Appointment']['is_future_app']==1){
					/* if($appointment['Appointment']['date']==date('Y-m-d')){						
						echo $this->Html->image('icons/future-app.png',array('title'=>'Please register patient'));						
						echo $appointment['Patient']['lookup_name'] ;
					}else{ */
						if($appointment['Person']['vip_chk']=='1'){
							echo $this->Html->image("vip.png", array("alt" => "VIP", "title" => "VIP"));
						}else if($appointment['Person']['vip_chk']=='2'){
								echo $this->Html->image("foreigner.png", array("alt" => "Foreigner", "title" => "Foreigner"));
							}
						 echo $this->Html->image('icons/future-app.png',array('title'=>'Please register patient'));
						 echo $text  ;
						
						//}
						
					
				}else{
					
					if($role!=Configure::read('doctorLabel')&& $role!=Configure::read('nurseLabel') && $role!=Configure::read('residentLabel') && $role!=Configure::read('medicalAssistantLabel')){
							if($appointment['Person']['vip_chk']=='1'){
									echo $this->Html->image("vip.png", array("alt" => "VIP", "title" => "VIP"));
							}else if($appointment['Person']['vip_chk']=='2'){
								echo $this->Html->image("foreigner.png", array("alt" => "Foreigner", "title" => "Foreigner"));
							}
							echo $this->Html->link($text,
							array('controller'=>'Persons','action'=>'edit',$appointment['Person']['id'],"?"=>array('from'=>"appointments_management")),
							array('style'=>'text-decoration:underline;padding:2px 0px;','escape'=>false)).$flagEvent; 
							
					}else{
							if($appointment['Person']['vip_chk']=='1'){
								echo $this->Html->image("vip.png", array("alt" => "VIP", "title" => "VIP"));
							}else if($appointment['Person']['vip_chk']=='2'){
								echo $this->Html->image("foreigner.png", array("alt" => "Foreigner", "title" => "Foreigner"));
							}
						if(!empty($appointment['Diagnosis']['flag_event'])){
							$flagEvent=$this->Html->image('icons/context/flag.png',array('style'=>'float: none;','id'=>'flagEvent_'.$appointment['Patient']['id'],'class'=>'tooltip','title'=>$appointment['Diagnosis']['flag_event']));
						}
						else{
							$flagEvent='';
						}
						echo $this->Html->link($text,
								array('controller'=>'PatientsTrackReports','action'=>'sbar',$appointment['Patient']['id'],'Summary','appt'=>$appointment['Appointment']['id']),
								array('style'=>'text-decoration:underline;padding:2px 0px;','escape'=>false)).'  '.$flagEvent;	
										
					}
				} ?>
		</td>
		<!--  <td style="text-align: center;" class="tdLabel" id="boxSpace"><?php  //Gender
		if(strtolower($appointment['Person']['sex'])=='male'){
				echo "M";
			}else if(strtolower($appointment['Person']['sex'])=='female'){
				echo "F";
			}else{
				echo "Others";
			} 	?>
		</td>-->
		<td class="tdLabel" id="boxSpace">
		<?php  //Gender
		if(strtolower($appointment['Person']['sex'])=='male'){
				$sex= "M";
			}else if(strtolower($appointment['Person']['sex'])=='female'){
				$sex= "F";
			}else{
				$sex= "Others";
			} 	?>
		<?php 
		if($appointment['Person']['dob'] == '0000-00-00' || $appointment['Person']['dob'] == ''){
			$dob = "";
		}else{
			$dob = $this->DateFormat->formatDate2Local($appointment['Person']['dob'],Configure::read('date_format'),false);
		}
		echo $sex.$age.'<br>'.$dob;?></td>
		
		<?php if($future == 'future'){?>
		<?php if($appointment['Appointment']['status']=='Pending'){
			$valueFuture=$appointment['Appointment']['role'];
		}else{
					$valueFuture=$appointment['Appointment']['status'];
				}
				$currentId= $appointment['Person']['id']."_".$appointment['Appointment']['id'] ;
				if(strtolower($appointment['Appointment']['role']) == Configure::read('patientLabel')){
					$futureColours = array(
			        array('name' => 'Scheduled by Doctor',   'value' => 'Scheduled', 'class'=>'darkBrown'),
			     	// array('name' => 'Scheduled by Doctor', 'value' => 'PrimaryCareProvider', 'class'=>'blue'),
			        array('name' => 'Confirmed with Patient',  'value' => 'Confirmed with Patient','class'=>'darkGreen'));
				}else{
					$futureColours = array(
					//array('name' => 'Scheduled by Patient',   'value' => 'Patient', 'class'=>'red'),
				   	array('name' => 'Scheduled by Patient', 'value' => 'Scheduled', 'class'=>'darkBrown'/*'#AB0198'*/),
					array('name' => 'Confirmed with Patient',  'value' => 'Confirmed with Patient','class'=>'darkGreen'));
				}?>
		<?php if($valueFuture =='Patient'){
			$futureStyle='';
		}else if(strtolower($valueFuture) == strtolower(Configure::read('doctor'))){
					$futureStyle='background-color: #1C6A16;';//#AB0198
			  }else if(strtolower($valueFuture) == 'confirmed by patient'){
						$futureStyle='background-color: green;';
			  }
			  if($appointment['Appointment']['status']==''||$appointment['Appointment']['status']=='Scheduled'||$appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']!='Confirmed with Patient'){
					$classFuture='darkBrown';
			  }else{
					$classFuture='darkGreen';
			  }?>

		<td width="10%" style="text-align: center;"><?php echo $this->Form->input('status',array('type'=>'select','options'=>$futureColours,
				'label'=>false,'div'=>false,'class'=>$classFuture.' status furtueDropdown hover', 'id'=>$currentId,'value'=>$valueFuture,'style' => $futureStyle.' width:100px'));?>
		</td>
		<?php }// end of $future
		else{ ?>
		<!-- <td style="text-align: left;" class="chamberAllotted"><input
			type="hidden"
			id="<?php echo $appointment['Patient']['id'].$appointment['Appointment']['chamber_id']; ?>"
			name="<?php echo $appointment['Patient']['id'].$appointment['Appointment']['chamber_id']; ?>"
			value="<?php echo $appointment['Appointment']['chamber_id']; ?>"> <?php  //status
		$disabled ="" ;
		$class = "status " ;
		if($appointment['Appointment']['status']=='Arrived'){
			$class.=' blue';
		}
		elseif($appointment['Appointment']['status']=='Assigned'){
			$class.=' darkBlue';
		}
		elseif($appointment['Appointment']['status']=='In-Progress'){
			$class.=' yellow';
		}
		elseif($appointment['Appointment']['status']=='Seen'){
			$class.=' lightGreen';
		}
		elseif($appointment['Appointment']['status']=='Closed'){
			$class.=' darkGreen';
		}
		elseif($appointment['Appointment']['status']=='Cancelled'){
			$class.=' red ';
		}
		elseif($appointment['Appointment']['status']=='No-Show'){
			$class.=' purple ';
		}
		elseif($appointment['Appointment']['status']=='Ready'){
			$class.=' orange ';
		}
		elseif(empty($appointment['Appointment']['status'])|| $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient'){
			$class.=' darkBrown';
		}


	/*	if($role==Configure::read('doctorLabel')){
			if( $appointment['Appointment']['status']!='' && $appointment['Appointment']['status'] != 'Scheduled' && $appointment['Appointment']['status']!='Pending' && $appointment['Appointment']['status']!='Confirmed with Patient')
			{
				if($appointment['Appointment']['status']=='Seen'){
						$status = array(array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue','disabled'=>'disabled'),
								  array('name'=> 'Ready','value'=> 'Ready','class'=>'orange','disabled'=>'disabled'),
								  array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled'),
								  array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow','disabled'=>'disabled'),
								  array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen'),
								  array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen'));
				}else{
						$status = array(array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue','disabled'=>'disabled'),
								  array('name'=> 'Ready','value'=> 'Ready','class'=>'orange','disabled'=>'disabled'),
								  array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled'),
								  array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow'),
								  array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen'),
								  array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'),
								  array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple','style'=>'display:none'),
								  array('name' => 'Cancelled',   'value' => 'Cancelled','class'=>'red'));
					 }

			}else{
					   $status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown'),
								 array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue','disabled'=>'disabled','style'=>'display:none'),
						         array('name'=> 'Ready','value'=> 'Ready','class'=>'orange','disabled'=>'disabled'),
						         array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled','style'=>'display:none'),
						         array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow','disabled'=>'disabled'),
						         array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled'),
						         array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'),
								 array('name' => 'Cancelled',   'value' => 'Cancelled','class'=>'red'));
				}
		  }else if($role==Configure::read('nurseLabel') || $role==Configure::read('medicalAssistantLabel')){
				if( $appointment['Appointment']['status']!='' && $appointment['Appointment']['status'] != 'Scheduled'&&$appointment['Appointment']['status']!='Pending' && $appointment['Appointment']['status']!='Confirmed with Patient'){
					  $status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown','disabled'=>'disabled'),
							 	array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue' ,'disabled'=>'disabled'),
							  	array('name'=> 'Ready','value'=> 'Ready','class'=>'orange','disabled'=>'disabled'),
							  	array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled'),
							    array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow','disabled'=>'disabled'),
							    array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled'),
							    array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'),
							    array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple'),
								array('name' => 'Cancelled',   'value' => 'Cancelled','class'=>'red'));
					}
					else{
						$status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown','disabled'=>'disabled'),
								//array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue'/*,'disabled'=>'disabled'),
								//array('name'=> 'Ready','value'=> 'Ready','class'=>'orange'/*,'disabled'=>'disabled'),
								//array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled'),
								//array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow','disabled'=>'disabled'),
								array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled'),
								array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'),
								array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple'),
								array('name' => 'Cancelled',   'value' => 'Cancelled','class'=>'red'));
					}
		 }else{
			  if($appointment['Appointment']['status']!='' && $appointment['Appointment']['status'] != 'Scheduled' && $appointment['Appointment']['status']!='Pending' && $appointment['Appointment']['status']!='Confirmed with Patient'){
				 if($appointment['Appointment']['status']=='Arrived'|| $appointment['Appointment']['status']=='Ready'){
						$status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown','disabled'=>'disabled'),
								  array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue'),
								  array('name'=>'Ready','value'=>'Ready','class'=>'orange'),
								  array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled'),//style for hidding the options from this user..
								  array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow','disabled'=>'disabled','style'=>'display:none'),
								  array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled','style'=>'display:none'),
								  array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'),
								  array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple'),
								  array('name' => 'Cancelled',   'value' => 'Cancelled','class'=>'red'));
				 }else if($appointment['Appointment']['status']=='Assigned'){
						$status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown','disabled'=>'disabled',),
								  array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue','disabled'=>'disabled',),
							      array('name'=> 'Ready','value'=> 'Ready','class'=>'orange','disabled'=>'disabled'),
								  array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue'),//style for hidding the options from this user..
								  array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow','disabled'=>'disabled','style'=>'display:none'),
								  array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled','style'=>'display:none'),
								  array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'),
								  array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple'));
				 }else if($appointment['Appointment']['status']=='In-Progress'){
						$status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown','disabled'=>'disabled'),
								  array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue','disabled'=>'disabled'),
								  array('name'=> 'Ready','value'=> 'Ready','class'=>'orange','disabled'=>'disabled'),
								  array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled'),
								  array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow'),
							      array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled','style'=>'display:none'),
								  array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'),
								  array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple'));
				}else if($appointment['Appointment']['status']=='Cancelled' || $appointment['Appointment']['status']=='No-Show'){
					   $status = array(array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple'),
								 array('name' => 'Cancelled',   'value' => 'Cancelled','class'=>'red'));
				}else{
					   $status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown'),
								 array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue','disabled'=>'disabled'),
								 array('name'=> 'Ready','value'=> 'Ready','class'=>'orange'/*,'disabled'=>'disabled'),
								 array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled'),
								 array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'),
								 array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple'),
								 array('name' => 'Cancelled',   'value' => 'Cancelled','class'=>'red'));
					 }
					 				}*/
				if($appointment['Appointment']['status']!='' && $appointment['Appointment']['status'] != 'Scheduled' && $appointment['Appointment']['status']!='Pending' && $appointment['Appointment']['status']!='Confirmed with Patient'){
					 if($appointment['Appointment']['status']=='Arrived'|| $appointment['Appointment']['status']=='Ready'){
							$status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown','disabled'=>'disabled'),
									  array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue'),
									  array('name'=>'Next In Line','value'=>'Ready','class'=>'orange'),
									  array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled'),//style for hidding the options from this user..
									  array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow','disabled'=>'disabled','style'=>'display:none'),
									  array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled','style'=>'display:none'),
									  array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen','disabled'=>'disabled'),
									  array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple'),
									  array('name' => 'Cancelled',   'value' => 'Cancelled','class'=>'red'));
						} else{
								$status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown','disabled'=>'disabled'),
										array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue','disabled'=>'disabled'),
										array('name'=>'Next In Line','value'=>'Ready'/*,'disabled'=>'disabled'*/,'class'=>'orange','disabled'=>'disabled'),
										array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue'/*,'disabled'=>'disabled'*/),//style for hidding the options from this user..
										array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow'/*,'disabled'=>'disabled','style'=>'display:none'*/),
										array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen'/*,'disabled'=>'disabled','style'=>'display:none'*/),
										array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen'/*,'disabled'=>'disabled'*/),
										array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple'),
										array('name' => 'Cancelled',   'value' => 'Cancelled','class'=>'red'));
					}
				}else{ 
					  $status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown'),
								array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue'),
								array('name'=>'Next In Line','value'=>'Ready'/*,'disabled'=>'disabled'*/,'class'=>'orange'),
								array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue'/*,'disabled'=>'disabled'*/),//style for hidding the options from this user..
								array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow'/*,'disabled'=>'disabled','style'=>'display:none'*/),
								array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen'/*,'disabled'=>'disabled','style'=>'display:none'*/),
								array('name' => 'Closed', 'value' => 'Closed', 'class'=>'darkGreen'/*,'disabled'=>'disabled'*/),
								array('name' => 'No-Show',   'value' => 'No-Show','class'=>'purple'),
								array('name' => 'Cancelled',   'value' => 'Cancelled','class'=>'red'));
						}
				//}
				$options= $status;
				$value= 'Arrived' ;$class='blue';
				$currentId= $appointment['Person']['id']."_".$appointment['Appointment']['id'] ;
				if(!$future){
					if(!empty($dateSearch)){
						if($appointment['Patient']['form_received_on']<date("Y-m-d")){
							echo __('Past Appointment');
						}else if($appointment['Patient']['form_received_on']>date("Y-m-d")){
							echo $this->Form->input('status',array('type'=>'select','options'=>$options,'disabled'=>'disabled','patient_id'=>$appointment['Patient']['id'],
								 'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));
						}
						else{
							if($role != Configure::read('doctorLabel') /*&& $role != Configure::read('nurseLabel')*/ && $appointment['Appointment']['status']=='Seen'){
								echo $this->Form->input('status',array('type'=>'select','options'=>$options,'disabled'=>'disabled','patient_id'=>$appointment['Patient']['id'],
											'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));
							}elseif($role == Configure::read('doctorLabel')&& ( $appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show' || $appointment['Appointment']['status']=='Closed')){
								echo $this->Form->input('status',array('type'=>'select','options'=>$options,'disabled'=>'disabled','patient_id'=>$appointment['Patient']['id'],
										'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));?>
		</td>
		<?php 					 }else{
										echo $this->Form->input('status',array('type'=>'select','options'=>$options,'patient_id'=>$appointment['Patient']['id'],
				 							'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));?>
		</td>
		<?php 						  }
						         }//else dateSearch
					 }else{
						if($role != Configure::read('doctorLabel') /*&& $role != Configure::read('nurseLabel')*/ && $appointment['Appointment']['status']=='Seen'){
							echo $this->Form->input('status',array('type'=>'select','options'=>$options,'disabled'=>'disabled','patient_id'=>$appointment['Patient']['id'],
							   'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));
						}elseif(($role == Configure::read('doctorLabel') /*|| $role == Configure::read('nurseLabel')*/)&& ( $appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show' || $appointment['Appointment']['status']=='Closed')){
							echo $this->Form->input('status',array('type'=>'select','options'=>$options,'disabled'=>'disabled','patient_id'=>$appointment['Patient']['id'],
								'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));?>
		</td>
		<?php 		    }//eof elseif
					       else{
						      echo $this->Form->input('status',array('type'=>'select','options'=>$options,'patient_id'=>$appointment['Patient']['id'],
							      'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));?>
		</td>
		<?php 		  	       }// eof else
						  }// eof else
				     }//eof $future if
			    }//eof parent else
			    ?>-->
		<?php if(($role != Configure::read('doctorLabel') && $role != Configure::read('nurseLabel')) && $role!=Configure::read('medicalAssistantLabel') && !$future){?>
		<!--<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php 
		if(!empty($appointment['Appointment']['positive_id'])){
			if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient'){
				echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet'));
			}else{
				echo $this->Html->image('icons/green.png',array('title'=>'Positive Id Confirmed'));
				 }
			}else{
				if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient'){
					echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet'));
				}else{
					echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'positiveId','id'=>'positiveId_'.$appointment['Appointment']['id'],'title'=>'Positive ID')),'javascript:void(0)',array('escape'=>false));
				}
			} ?></td> -->
			<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php //register to ipd-- Pooja
			if($appointment['Patient']['is_opd']=='1'){
					echo $this->Html->image('icons/green.png');
			}else{
			echo $this->Html->link($this->Html->image('icons/red.png'),array('controller'=>'Patients','action'=>'add','?'=>array('type'=>'IPD','is_opd'=>'1','patient_id'=>$appointment['Patient']['id'],'apptId'=>$appointment['Appointment']['id'])),array('escape'=>false));
			}
			?>
			
			</td>
		<!-- BOF Insurance  -->
		<!--  <td style="text-align: center;" class="tdLabel" id="boxSpace"><?php //eligibility check
			
			/*if($appointment['NewInsurance']['is_eligible']=='0' || $appointment['NewInsurance']['is_eligible']==''){
			    echo $this->Html->link($this->Html->image('icons/red.png',array()),
					 array('controller'=>'Patients','action'=>'insuranceindex',$appointment['Patient']['id'],'?'=>array('person_id'=>$appointment['Appointment']['person_id'])), array('escape' => false));
			}else */

			if($appointment['Person']['payment_category']=='Insurance'){
				echo $this->Html->link($this->Html->image('icons/green.png',array()),
					array('controller'=>'Patients','action'=>'insuranceindex',$appointment['Patient']['id']), array('escape' => false));
			}else{
				echo $this->Html->link($this->Html->image('icons/red.png',array()),
				array('controller'=>'Patients','action'=>'insuranceindex',$appointment['Patient']['id'],'?'=>array('person_id'=>$appointment['Person']['id'])), array('escape' => false));
			}?>
		</td> -->
		<!--  EOF Insurance  -->
		<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php //paid
			    if(!empty($appointment['Billing']['patient_id'])){	
					$amt=$appointment['0']['amount_paid'];
					if($appointment['0']['refund']){
					$amt=$amt-$appointment['0']['refund'];
					}
					if($appointment['0']['discount']){
						$amt=$amt+$appointment['0']['discount'];
					}
					$paid=$appointment['Billing']['total_amount']-($amt);
						if($paid<=0 /*&& $appointment['0']['amount_pending']<=0*/){		
				    		echo $this->Html->link($this->Html->image('icons/green.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd', $appointment['Patient']['id']), array('escape' => false,'title'=>'View Payment Info'));
				    	}else if($paid==$appointment['Billing']['total_amount']){
							echo $this->Html->link($this->Html->image('icons/red.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd', $appointment['Patient']['id']), array('escape' => false,'title'=>'View Payment Info'));
 						}
				    	else{
							echo $this->Html->link($this->Html->image('icons/orange_new.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd', $appointment['Patient']['id']), array('escape' => false,'title'=>'View Payment Info'));
						}				
				
			}else{
				echo $this->Html->link($this->Html->image('icons/red.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd', $appointment['Patient']['id']), array('escape' => false,'title'=>'View Payment Info'));
				
			}?>
		</td>
		<?php }?>
		<?php if(($role==Configure::read('doctorLabel') || $role==Configure::read('nurseLabel') || $role==Configure::read('medicalAssistantLabel')  || $role==Configure::read('residentLabel'))&& $future!='future'){
			$title = 'Medication Administered';
			$medTDid = 'med_'.$appointment['Patient']['id'].'_'.$appointment['Appointment']['id'].'_'.$appointment['Patient']['patient_id'];
			if(!empty($appointment['NewCropPrescriptionAlias']['id'])||!empty($appointment['NewCropPrescription']['id'])){
					if($appointment['NewCropPrescription']['is_med_administered']!='1'|| !empty($appointment['VerifyMedicationOrder']['id'])){
				         $medClass=  "med greenBulb MEDUNIQUECLASS_".$appointment['Patient']['id'];
			         }else{
				         $medClass=  "med redBulb MEDUNIQUECLASS_".$appointment['Patient']['id'];
			         }
		        }else{
			        $medClass=  "med greyBulb MEDUNIQUECLASS_".$appointment['Patient']['id'];
		             }?>
		<td>
			<div title="<?php echo $title;?>"
				style="cursor: pointer; width: 35px; margin: 0 0 11px 30px; height: 44px;"
				class="<?php echo $medClass;?>" id="<?php echo $medTDid;?>">
				&nbsp;
				<!-- medication administered -->
			</div>
		</td>
		<?php }?>
		<td style="image-align: center;" class="tdLabel" id="boxSpace"><?php // Patient credentials
		             $pat_uid=trim($appointment['Patient']['id']);
		             $person_id=trim($appointment['Person']['id']);
		             if(!empty($appointment['Person']['patient_credentials_created_date']) ||  $appointment['Person']['decline_portal']!=0){
			echo $this->Html->link($this->Html->image('icons/green.png',array('class'=>'')),'javascript:void(0)', array('onClick'=>"createPatientCredentials('$person_id','$pat_uid')",'escape' => false,'title'=>'Patient Credentials'));
		}else{
			echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'cred_'.$person_id)),'javascript:void(0)', array('onClick'=>"createPatientCredentials('$person_id','$pat_uid')",'escape' => false,'title'=>'Patient Credentials'));
		}?>
		</td>
		<?php if($future != 'future'){?>
		<!-- BOF Managed Critical Value  -->
		<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php //Managed critical alerts
		if (in_array($appointment['Patient']['id'], $criticalArray)) {
					if($appointment['Patient']['is_dr_chk'] != 0){
						if($appointment['Appointment']['is_future_app']=='1'){ //future appt is 1
							echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;'));
						}else{
						echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed;'));
						}
					}else{
						if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient'){
							echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;'));
						}else{
							echo $this->Html->link($this->Html->image('icons/red.png',array()),array("controller" => "Messages", "action" => "compose",$appointment['Patient']['id'],'null','alert',$appointment['Appointment']['id'],'arrive_time='.$appointment['Appointment']['arrived_time']), array('escape' => false,'class'=>'manage_alert','id'=>'alert_'.$appointment['Patient']['id']));
						}
					}
				}else{
					echo $this->Html->image('icons/grey.png',array('style'=>'cursor:not-allowed;'));
				}?>
		</td>
		<?php }?>
		<!--  eof Managed Critical Value  -->
		<!-- *******  -->
		<?php if($future != 'future'){?>
		<td style="text-align: left;" class="tdLabel" id="boxSpace"><?php //Critical results
				/** lab Counting - gaurav*/
				$labOrder=count($labCount[$appointment['Patient']['id']]);
				$countOfResult = 0;
				$isAbnormal=false;
				$showFlag=false;
				foreach($labCount[$appointment['Patient']['id']] as $resultCount){
				$countOfResult = ($resultCount['is_Resulted'] == 1) ? $countOfResult+1 : $countOfResult;
				$isAbnormal = ($isAbnormal)? true : $resultCount['abnormalFlag'];
				$showFlag = ($showFlag)? true : $resultCount['showFlag'];
		   }
		   if($isAbnormal){
			  $labResult  = "<font color='red'>".$countOfResult."</font>"  ;
		   }else{
			 $labResult  = $countOfResult  ;
		   }
		   if($labOrder > 0)
		   	$labResUrl = array('controller'=>'laboratories','action'=>'labTestHl7List',$appointment['Patient']['id'],'?'=>array('return'=>'laboratories')) ;
		   else
		   	$labResUrl = "#" ;

		   $flag = ($showFlag)?$this->Html->image('icons/context/flag.png',array('style'=>'float: right;','id'=>'labOverDue_'.$appointment['Patient']['id'],'class'=>'labRadOverDue')) : '';
		   if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient'|| $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show'){
			echo 'LAB 0/0'.'<br />';// if the status is pending/scheduled the count will be shown as 0/0
			}else{
		   if($role==Configure::read('doctorLabel') || $role==Configure::read('nurseLabel')){
			      if($labResUrl=='#'){
				      echo 'LAB '."$labResult/$labOrder"." ".$flag.'<br />';
			      }else{
				      echo 'LAB '.$this->Html->link("$labResult/$labOrder",$labResUrl,array('escape' => false,'title' =>'Click to view result','style'=>'curson:pointer;'))." ".$flag.'<br />';
			      }
		      }
		      else{ echo 'LAB '."$labResult/$labOrder"." ".$flag.'<br />';
             }
             }
             /** End of lab */
             /** Rad Counting */
             $radOrder=count($radCount[$appointment['Patient']['id']]);
             $countOfResult = 0;
             $showFlag=false;
             $isAbnormal=false;
             foreach($radCount[$appointment['Patient']['id']] as $resultCount){
				$countOfResult = ($resultCount['is_Resulted'] == 1) ? $countOfResult+1 : $countOfResult;
				$showFlag = ($showFlag)? true : $resultCount['showFlag'];
				$isAbnormal = ($isAbnormal)? true : $resultCount['abnormalFlag'];
		    }
		    $flag = ($showFlag)?$this->Html->image('icons/context/flag.png',array('style'=>'float: right;','id'=>'radOverDue_'.$appointment['Patient']['id'],'class'=>'labRadOverDue')) : '';
		    //$radResult  = $countOfResult ;
		    if($isAbnormal){
			   $radResult  = "<font color='red'>".$countOfResult."</font>"  ;
		    }else{
			   $radResult  = $countOfResult  ;
		    }
		    if($radOrder > 0)
		    	$radResUrl = array('controller'=>'radiologies','action'=>'radiology_test_list',$appointment['Patient']['id'],'?'=>array('return'=>'radiologies')) ;
		    else
		    	$radResUrl = "#" ;
		    if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient'|| $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show'){
			echo ' RAD 0/0'; // if the status is pending/scheduled the count will be shown as 0/0
			}else{
		    if($role==Configure::read('doctorLabel') || $role==Configure::read('nurseLabel') || $role==Configure::read('medicalAssistantLabel')){
				if($radResUrl=='#'){
					echo ' RAD '. "$radResult/$radOrder"." ".$flag ;
				}else{
					echo ' RAD '.$this->Html->link("$radResult/$radOrder",$radResUrl,array('escape' => false,'title' =>'Click to view result','style'=>'curson:pointer;'))." ".$flag;
				}
			}
			else{
				echo ' RAD '. "$radResult/$radOrder"." ".$flag ;
            }
            }
            /** End of Rad */
            ?></td>
            <?php /*if($referalCount[$appointment['Patient']['id']]['nCount']){
            	$denoCount=$referalCount[$appointment['Patient']['id']]['nCount'];
            	$referName=implode(',',$referSpecialist[$appointment['Patient']['id']]);
            	$referalSpeciality=implode(',',$referSpeciality[$appointment['Patient']['id']]);
				}else{
				$denoCount='0';
				}
				if($referalCount[$appointment['Patient']['id']]['yCount']){
            	$numCount=$referalCount[$appointment['Patient']['id']]['yCount'];
				}else{
				$numCount='0';
				}
				if(!empty($referalName))
					$nameTitle='Referred To : '.$referName;
				if(!empty($referalSpeciality)){
					$speciality='Speciality : '.$referalSpeciality;
				}
				$referal  ='<b>Referred To : </b>'.$referName.'</br> <b>Speciality : </b>'.$referalSpeciality;*/?>
		
           <!--   <td style="text-align: center;" class="tdLabel tooltip" id="boxSpace" title="<?php if($denoCount)
          /*  echo $referal;
            else echo "Not refered"?>"><?php   
            if(empty($denoCount)){
						echo $numCount.'/'.$denoCount;
				}else{          
				echo $this->Html->link("$numCount/$denoCount",array('controller'=>'Messages','action'=>'composeCcda',$appointment['Patient']['id'],'?'=>array('referred_to'=>$referName)),array('escape'=>false));}*/?></td>-->
		<?php 
}?>
		<!-- /********* Schedule Arrived and Elapsed Time **************/ -->
		<td style="text-align: center;" class="" id="boxSpace">
		<?php if(!$dateSearch){ ?>
		<span><?php echo $this->DateFormat->formatDate2Local($appointment['Patient']['form_received_on'],Configure::read('date_format'),false);?></span>
		<br><?php }?>
		<span> <font
				color="#000"><?php echo $appointment['Appointment']['start_time']; // date('h:i a',strtotime($appointment['Appointment']['start_time'])); ?>
			</font>
		</span> <!-- /*********end of Schedule Time **************/--> <!-- /*********start of Arrived Time **************/ -->
			<br> <?php if($future != 'future'){ ?> <span
			id="<?php echo 'arrived_time_'.$appointment['Appointment']['id']; ?>"
			style="color: #4985A8;"><?php echo   $appointment['Appointment']['arrived_time']//date('h:i a',strtotime($appointment['Appointment']['arrived_time'])); ?>
		</span> <!-- /*********end of Arrived Time **************/ --> <!-- /*********start of elapsed Time **************/ -->
			<br> <?php if($appointment['Appointment']['status']!='Seen' && $appointment['Appointment']['status']!='Scheduled' && $appointment['Appointment']['status']!='Pending' && $appointment['Appointment']['status']!='' ){?>
			<?php $start=$appointment['Patient']['form_received_on'].' '.$appointment['Appointment']['arrived_time'];
			$elapsed=$this->DateFormat->dateDiff($start,date('Y-m-d H:i')) ;
			if(($appointment['Appointment']['status']=='Arrived') && ($elapsed->invert==0))
			{?> <span id="<?php echo 'elapsed-'.$currentId;?>"
			class="<?php echo "elapsed elapsedGreen "; ?>"> <?php echo '00 Min';?>
		</span> <?php }else{
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
			}else{
				$showTime=$min;
			}
			if($showTime<15){
		 		$elapsedClass='elapsedGreen';
			}else if($showTime>=15 && $showTime<=30){
				$elapsedClass='elapsedYellow';
			}
			else if($showTime>30){
				$elapsedClass='elapsedRed';
			}
			?> <span id="<?php echo 'elapsed-'.$currentId;?>"
			class="<?php echo "elapsed ".$elapsedClass; ?>"> <?php echo $showTime.' Min';?>
		</span> <?php }//else
            }//end parent if

            if($appointment['Appointment']['status']=="Seen"){
			if($appointment['Appointment']['elapsed_time']<15){
				$elapsedClass="elapsedGreen";
			}else if($appointment['Appointment']['elapsed_time']>=15 && $appointment['Appointment']['elapsed_time']<=30){
			    $elapsedClass='elapsedYellow';
		    }else if($appointment['Appointment']['elapsed_time']>30){
			    $elapsedClass='elapsedRed';
		    }
		    ?> <span id="<?php echo 'elapsed_'.$currentId;?>"
			class="<?php echo $elapsedClass; ?>"> <?php echo $appointment['Appointment']['elapsed_time'].' Min';?>
		</span> <?php }//seen end
            }//future end?>
		</td>
		<!-- /*********end of elapsed Time **************/ -->
		<?php //if(($role==Configure::read('doctorLabel') || $role==Configure::read('nurseLabel') || $role==Configure::read('medicalAssistantLabel'))&& $future!='future')
				//{ ?>
		<td style="image-align: center;" class="tdLabel" id="boxSpace"><?php //debug($appointment['Diagnosis']);//initial
				if(!empty($appointment[0]['initCount'])){
						if($appointment['Appointment']['is_future_app']=='1'){
							echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet/ First Register Patient'));
						}else{
							if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient'|| $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show'){
								echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet/Not Assigned nurse/room'));
							}else{
					 			echo $this->Html->link($this->Html->image('icons/green.png',array()),array("controller" => "Diagnoses", "action" => "initialAssessment",$appointment['Patient']['id'],$appointment['Diagnosis']['id'],$appointment['Appointment']['id'],'?'=>array('type'=>$appointment['Appointment']['arrived_time']),"admin" => false),array('escape'=>false,'class'=>'initialGreen','id'=>'initial_'.$appointment['Appointment']['id'].'_'.$appointment['Patient']['id']));
							}
						}
					}else{
						if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show' /* || $appointment['Appointment']['status']=='Arrived' */){
							echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet/Not Assigned nurse/room'));
						}else{
							echo $this->Html->link($this->Html->image('icons/red.png',array()),'javascript:void(0)',array('escape'=>false,'class'=>'initial','id'=>'initial_'.$appointment['Appointment']['id'].'_'.$appointment['Patient']['id']));
						}
					} 
				//}?>
		</td>
		<?php //	if(($role==Configure::read('doctorLabel') || $role==Configure::read('nurseLabel') || $role==Configure::read('residentLabel') || $role==Configure::read('medicalAssistantLabel'))&& $future!='future'){
		?>
		<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php  //Doc
		//The doc signed button is active only if the mandatory charges payment is fully paid or the patient is VIP --Pooja
 
	if($appointment['0']['aliasTotal']!=''){
		$manTotal=$appointment['0']['aliasTotal']-$appointment['0']['aliasPaid'];
		}else{
				$manTotal=1;// if no record in Billing for mandatory services payment category
		}
 
		
		if(($appointment['Person']['vip_chk']!='1' || $appointment['Patient']['tariff_standard_id']!=$privateId) &&	$manTotal > 0 ){
			echo $this->Html->image('icons/grey.png',array('title'=>'Please Pay Mandatory charges'));
		}else{
					//if($appointment[0]['noteCount']==0){ this conditions is replace by below conditions
			if(empty($appointment['Note']['id']) ||empty($appointment['Note']['sign_note']) ||($appointment['Note']['sign_note']==0) ){
					if(!empty($appointment['Note']['id'])){
						if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show'/* || $appointment['Appointment']['status']=='Arrived'*/){
							echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet/Not Assigned nurse/room'));
						}else{
							if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show' /*|| $appointment['Appointment']['status']=='Arrived'*/){
								echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet/Not Assigned nurse/room'));
							}else{
								echo $this->Html->link($this->Html->image('icons/green.png',array()),array('controller'=>'Notes','action'=>'clinicalNote',$appointment['Patient']['id'],$appointment['Appointment']['id'],$appointment['Note']['id'],'?'=>array('arrived_time'=>$appointment['Appointment']['arrived_time'])),array('id'=>$appointment['Patient']['id'],'escape'=>false,'title'=>'Documentation Complete'/*,'class'=>'context-menu-one'*/));
							}
						}
					}else{
						if($appointment['Appointment']['is_future_app']=='1'){
							echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet/ First Register Patient'));
						}else{
							if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show' /*|| $appointment['Appointment']['status']=='Arrived'*/){
								echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet/Not Assigned nurse/room'));
							}else{
								echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'doc_clicked'/* ,'title'=>'Right Click To view Rx ' */)),array('controller'=>'Notes','action'=>'clinicalNote',$appointment['Patient']['id'],$appointment['Appointment']['id'],'?'=>array('arrived_time'=>$appointment['Appointment']['arrived_time'])),array('id'=>$appointment['Patient']['id'],'escape'=>false,'title'=>'Documentation Not Completed'/*,'class'=>'context-menu-one'*/));
								//echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'doc_clicked')),array('controller'=>'Notes','action'=>'soapNote',$appointment['Patient']['id'],$appointment['Note']['id']),array('id'=>$appointment['Patient']['id'],'escape'=>false,'title'=>'Documentation Complete','class'=>'context-menu-one'));
							}
						}
					}
			}else{
        		if($appointment['Appointment']['is_future_app']=='1'){
					echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet/ First Register Patient'));
				}else{
					if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show' /*|| $appointment['Appointment']['status']=='Arrived'*/){
						echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet'));
					}else{
						echo $this->Html->link($this->Html->image('icons/green.png',array()),array('controller'=>'PatientForms','action'=>'power_note',$appointment['Note']['id'],$appointment['Patient']['id'],'?'=>array('appointmentId'=>$appointment['Appointment']['id'])),
							 array('id'=>$appointment['Patient']['id'],'escape'=>false/* ,'title'=>'Documentation Complete/Right Click To view Rx ','class'=>'context-menu-one' */));
						}
					}
				}
				}	?>
		</td>
		<?php //}// Role conditions if end?>
		<?php if($future == 'future' || !empty($dateSearch)){?>
		<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php  //Date
				echo $this->DateFormat->formatDate2LocalForReport($appointment['Patient']['form_received_on'],Configure::read('date_format')); ?>
		</td>
		<?php } ?>
		<?php if(($role!=Configure::read('doctorLabel')) || !empty($rtSelect)){?>
		<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php //Provider
				if($appointment[Appointment]['status']==''||$appointment[Appointment]['status']=='Scheduled'||$appointment['Appointment']['status']=='Pending'|| $appointment['Appointment']['status']=='In-Progress' || $appointment['Appointment']['status']=='Seen' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show'){
					echo $this->Form->input('doctor_id',array('style'=>'width:100px;','type'=>'select','label'=>false,'disabled'=>'disabled',
						'options'=>$doctors,'value'=>$appointment['Patient']['doctor_id'],'class'=>'currentDropdown doctor',
						'id'=>'doctor_'.$appointment['Appointment']['id']));
				}else{
						if(empty($appointment['Appointment']['doctor_id'])){
							echo $this->Form->input('doctor_id',array('style'=>'width:100px;','type'=>'select','label'=>false,'empty'=>'Please Select',
								'options'=>$doctors,'value'=>$appointment['Appointment']['doctor_id'],'class'=>'currentDropdown doctor',
								'id'=>'doctor_'.$appointment['Appointment']['id'].'_'.$appointment['Appointment']['doctor_id'].'_'.$appointment['Patient']['id']));
						}
						else{
							echo $this->Form->input('doctor_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
									'options'=>$doctors,'value'=>$appointment['Appointment']['doctor_id'],'class'=>'currentDropdown doctor',
									'id'=>'doctor_'.$appointment['Appointment']['id'].'_'.$appointment['Appointment']['doctor_id'].'_'.$appointment['Patient']['id']));

						}
				}
				//echo '<br />'?>
				<?php //Room 
					 if($appointment[Appointment]['status']==''||$appointment[Appointment]['status']=='Scheduled'||$appointment['Appointment']['status']=='Pending'||$appointment['Appointment']['status']=='Cancelled'||$appointment['Appointment']['status']=='No-Show'){
					echo $this->Form->input('room_id',array('style'=>'width:100px;','type'=>'select','label'=>false,'disabled'=>'disabled',
						 'options'=>$chambers,'empty'=>"Select Room",'value'=>'','class'=>'currentDropdown room',
						 'id'=>'room_'.$appointment['Appointment']['id'],'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id']));
				}else{
				    if($appointment['Appointment']['is_future_app']=='1'){
				         echo $this->Form->input('room_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
							  'options'=>$chambers,'empty'=>"Select Room",'value'=>'','class'=>'currentDropdown room',
							  'id'=>'room_'.$appointment['Appointment']['id'],'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id']));
					}else{
						/*if($appointment['Appointment']['status']=='In-Progress'){
							$disabled='disabled';
						}else{
							$disabled='';
						}*/
						if(empty($appointment['Appointment']['chamber_id'])){
							echo $this->Form->input('room_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
								 'options'=>$chambers,'empty'=>"Select Room",'value'=>$appointment['Appointment']['chamber_id'],'class'=>'currentDropdown room','disabled'=>$disabled,
								 'id'=>'room_'.$appointment['Appointment']['id'],'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id']));
						}else{
								echo $this->Form->input('room_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
								 'options'=>$chambers,'value'=>$appointment['Appointment']['chamber_id'],'class'=>'currentDropdown room'/*,'disabled'=>$disabled*/,
							     'id'=>'room_'.$appointment['Appointment']['id'],'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id']));
						}
					}
				}//end of else?>
				<?php if($future != 'future'){ ?>
		<?php    if(/*$role!=Configure::read('nurseLabel')) || */!empty($viewAll)){?>
		<?php //Nurse
				if($appointment[Appointment]['status']==''||$appointment[Appointment]['status']=='Scheduled'||$appointment['Appointment']['status']=='Pending'||$appointment['Appointment']['status']=='Cancelled'||$appointment['Appointment']['status']=='No-Show'){
						echo $this->Form->input('nurse_id',array('style'=>'width:100px;','type'=>'select','label'=>false,'disabled'=>'disabled',
						     'options'=>$nurses,'empty'=>"Select Nurse",'value'=>'','class'=>'currentDropdown nurse','patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id'],
							 'id'=>'nurse_'.$appointment['Patient']['id'].'_'.$appointment['Appointment']['id']));
					}else{
						if($appointment['Appointment']['is_future_app']=='1'){
							echo $this->Form->input('nurse_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
								'options'=>$nurses,'empty'=>"Select Nurse",'value'=>'','class'=>'currentDropdown nurse','patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id'],
								'id'=>'nurse_'.$appointment['Patient']['id'].'_'.$appointment['Appointment']['id']));
						}else{
								/*if($appointment['Appointment']['status']=='In-Progress'){
									$disabled='disabled';
								}else{
								    $disabled='';
								}*/
								if(empty($appointment['Appointment']['nurse_id'])){
										echo $this->Form->input('nurse_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
											 'options'=>$nurses,'empty'=>"Select Nurse",'value'=>$appointment['Appointment']['nurse_id'],'class'=>'currentDropdown nurse','disabled'=>$disabled,'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id'],
						                     'id'=>'nurse_'.$appointment['Patient']['id'].'_'.$appointment['Appointment']['id']));
						         }else{
							            echo $this->Form->input('nurse_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
								             'options'=>$nurses,'value'=>$appointment['Appointment']['nurse_id'],'class'=>'currentDropdown nurse'/*,'disabled'=>$disabled*/,'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id'],
								             'id'=>'nurse_'.$appointment['Patient']['id'].'_'.$appointment['Appointment']['id']));
								 }
							}
					 }//end of else ?>
		
		<?php }
				}?>
		</td>
		<?php }?>
		<?php if($future != 'future'){ ?>
		<td> <?php $taskOptions=array('qrCode'=>'Print QR Code','packageEstimate'=>'Estimate');
		 echo $this->Form->input('task',array('style'=>'width:100px;','type'=>'select','label'=>false,
						     'options'=>$taskOptions,'empty'=>"Select Task",'value'=>'','class'=>'currentDropdown task','patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id'],
							 'id'=>'task_'.$appointment['Patient']['id']));?></td>
		<?php   /* if(/*$role!=Configure::read('nurseLabel')) || !empty($viewAll)){?>
		<td style="text-align: center;" class="tdLabel td_ht" id="boxSpace"><?php //Nurse
				if($appointment[Appointment]['status']==''||$appointment[Appointment]['status']=='Scheduled'||$appointment['Appointment']['status']=='Pending'||$appointment['Appointment']['status']=='Cancelled'||$appointment['Appointment']['status']=='No-Show'){
						echo $this->Form->input('nurse_id',array('style'=>'width:100px;','type'=>'select','label'=>false,'disabled'=>'disabled',
						     'options'=>$nurses,'empty'=>"Select",'value'=>'','class'=>'currentDropdown nurse','patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id'],
							 'id'=>'nurse_'.$appointment['Patient']['id'].'_'.$appointment['Appointment']['id']));
					}else{
						if($appointment['Appointment']['is_future_app']=='1'){
							echo $this->Form->input('nurse_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
								'options'=>$nurses,'empty'=>"Select",'value'=>'','class'=>'currentDropdown nurse','patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id'],
								'id'=>'nurse_'.$appointment['Patient']['id'].'_'.$appointment['Appointment']['id']));
						}else{
								/*if($appointment['Appointment']['status']=='In-Progress'){
									$disabled='disabled';
								}else{
								    $disabled='';
								}
								if(empty($appointment['Appointment']['nurse_id'])){
										echo $this->Form->input('nurse_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
											 'options'=>$nurses,'empty'=>"Select",'value'=>$appointment['Appointment']['nurse_id'],'class'=>'currentDropdown nurse','disabled'=>$disabled,'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id'],
						                     'id'=>'nurse_'.$appointment['Patient']['id'].'_'.$appointment['Appointment']['id']));
						         }else{
							            echo $this->Form->input('nurse_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
								             'options'=>$nurses,'value'=>$appointment['Appointment']['nurse_id'],'class'=>'currentDropdown nurse'/*,'disabled'=>$disabled,'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id'],
								             'id'=>'nurse_'.$appointment['Patient']['id'].'_'.$appointment['Appointment']['id']));
								 }
							}
					 }*///end of else ?>
		</td>
		<?php //}?>
		<!-- <td style="text-align: center;" class="tdLabel td_ht" id="boxSpace"><?php //Room 
					 if($appointment[Appointment]['status']==''||$appointment[Appointment]['status']=='Scheduled'||$appointment['Appointment']['status']=='Pending'||$appointment['Appointment']['status']=='Cancelled'||$appointment['Appointment']['status']=='No-Show'){
					echo $this->Form->input('room_id',array('style'=>'width:100px;','type'=>'select','label'=>false,'disabled'=>'disabled',
						 'options'=>$chambers,'empty'=>"Select",'value'=>'','class'=>'currentDropdown room',
						 'id'=>'room_'.$appointment['Appointment']['id'],'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id']));
				}else{
				    if($appointment['Appointment']['is_future_app']=='1'){
				         echo $this->Form->input('room_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
							  'options'=>$chambers,'empty'=>"Select",'value'=>'','class'=>'currentDropdown room',
							  'id'=>'room_'.$appointment['Appointment']['id'],'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id']));
					}else{
						/*if($appointment['Appointment']['status']=='In-Progress'){
							$disabled='disabled';
						}else{
							$disabled='';
						}*/
						if(empty($appointment['Appointment']['chamber_id'])){
							echo $this->Form->input('room_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
								 'options'=>$chambers,'empty'=>"Select",'value'=>$appointment['Appointment']['chamber_id'],'class'=>'currentDropdown room','disabled'=>$disabled,
								 'id'=>'room_'.$appointment['Appointment']['id'],'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id']));
						}else{
								echo $this->Form->input('room_id',array('style'=>'width:100px;','type'=>'select','label'=>false,
								 'options'=>$chambers,'value'=>$appointment['Appointment']['chamber_id'],'class'=>'currentDropdown room'/*,'disabled'=>$disabled*/,
							     'id'=>'room_'.$appointment['Appointment']['id'],'patient_id'=>$appointment['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id']));
						}
					}
				}//end of else?>
		</td> -->
		<?php }//end of future if?>
		<?php /** --gaurav BOF-------- */?>
		
		<td style="text-align: left;" class="tdLabel td_ht "
			title="<?php echo $appointment['Appointment']['purpose']; ?>"
			id="boxSpace"><?php //reason of visit
			echo substr($appointment['Appointment']['purpose'],0,7).'..' ; ?></td>
		<?php if($future == 'future'){ ?>
		<?php //instruction
				 if($appointment['Appointment']['to_tast_fast'] == '0'){?>
		<td style="text-align: center;"></td>
		<?php }else{?>
		<td style="text-align: center; width: 5%"><?php  echo $appointment['Appointment']['to_tast_fast'] ; ?>
		</td>
		<?php    }
		      } ?>
		<?php 
		if(($role != Configure::read('doctorLabel') && $role != Configure::read('nurseLabel') && $role!=Configure::read('medicalAssistantLabel')) && !$future){?>
		<!--<td style="image-align: center;" class="tdLabel" id="boxSpace"><?php //Schedule 
			if(!empty($appointment['Note']['has_no_followup'])||!empty($appointment['Appointment']['has_no_followup'])){
				echo $this->Html->image('icons/grey.png',array('title'=>'No Followup Needed'));
			}else{
				if($futureFlag==1){
					echo $this->Html->link($this->Html->image('icons/green.png',array()), array('controller'=>'DoctorSchedules','action' => 'doctor_event','patientid'=>$appointment['Patient']['id']),
						 array('escape' => false,'title'=>'Followup Scheduled'));
                 }else{
					$futureDate=date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 day'));
					if(empty($appointment['Appointment']['status'])){//checking of empty status to create the equivalent id which is used in javascript
							echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'context-menu-two','id'=>'schedule_'.$appointment['Appointment']['id'].'_'.$appointment['Patient']['id'].'_1')), array('controller'=>'DoctorSchedules','action' => 'doctor_event','1',$appointment['Appointment']['doctor_id'],$appointment['Appointment']['doctor_id'],$futureDate, 'patientid'=>$appointment['Patient']['id']),
								 array('escape' => false,'title'=>'Schedule Appointment/Right Click For No Follow Up'));
						}else{
						    echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'context-menu-two','id'=>'schedule_'.$appointment['Appointment']['id'].'_'.$appointment['Patient']['id'].'_'.$appointment['Appointment']['status'])), array('controller'=>'DoctorSchedules','action' => 'doctor_event','1',$appointment['Appointment']['doctor_id'],$appointment['Appointment']['doctor_id'],$futureDate, 'patientid'=>$appointment['Patient']['id']),
								 array('escape' => false,'title'=>'Schedule Appointment/Right Click For No Follow Up'));
						}
					 }
				}?>
		</td>-->
		<td style="image-align: center;" class="tdLabel" id="boxSpace"><?php // close encounter
				if($appointment['Patient']['is_discharge']=='1'){
		     		 echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed;','title'=>'Encounter Closed'));							
				}else{
					echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'encounter','id'=>'encounter_'.$appointment['Patient']['id'],'title'=>'Positive ID')),'javascript:void(0)',array('escape'=>false));
				}
			//}?>
			</td>
		<!-- <td><?php echo $this->Html->link($this->Html->image('icons/icon2.png', array('alt' => 'Payment')),array("controller" => "patients", "action" => "payment","?"=>array('type'=>'OPD'), "admin" => false,'plugin' => false), array('escape' => false));?></td> -->
		<?php }?>
		
		</tr>
		<?php }
		$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		if(empty($queryStr)){
			if($this->params->pass[0]=='closed'){
				$queryStr='closed=closed';
			}
		}
		$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
		
		// code added by- Leena
		
		echo	$this->Paginator->options(array(
				'update' => '#content-list',
				'evalScripts' => true,
				'before' => "loading();",'complete' => "onCompleteRequest();",
				'url' =>array("?"=>$queryStr)
				//'convertKeys'=>array($this->request->data['User']['All Doctors'])
		));
		?>
		<tr style="text-align: center; height: 40px;">
			<td colspan="20">&nbsp;<!-- blank row to unhide lower rows -->
			</td>
		</tr>
		<tr style="text-align: center;">
			<td colspan="20">
			
			<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));?>
			<!-- Shows the next and previous links --> <?php 
			echo $this->Paginator->first(__('« First', true),array('class' => 'paginator_links'));
			echo $this->Paginator->prev(__('« Previous', true),array('class' => 'paginator_links'));
			echo $this->Paginator->numbers(array('update'=>'#content-list'  ));
			echo $this->Paginator->next(__('Next »', true),array('class' => 'paginator_links'));
			echo $this->Paginator->last(__('Last »', true),array('class' => 'paginator_links'));
			?> <!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>			
			    <!-- Below code Commented by- Leena -->
				<!-- Shows the next and previous links --> <?php /* echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#content-list',    												
						'complete' => "onCompleteRequest();",
		    		 	'before' => "loading();"), null, array('class' => 'paginator_links')); ?>
		    		 	<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); */ ?>
			</span>
				 <?php /* echo $this->Paginator->next(__('Next »', true), array('update'=>'#content-list',    												
						'complete' => "onCompleteRequest();",
		    		 	'before' => "loading();"), null, array('class' => 'paginator_links'));  */ ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				
			</td>
		</tr>
	</table>
	<?php } 
	echo	$this->Paginator->options(array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));

		echo $this->Js->writeBuffer();
		$paggingArray = $this->Paginator->params() ;
			
		echo $this->Form->hidden('patient_count',array('id'=>'patient-count' , "value"=>$paggingArray['count'] ,'url'=>$this->Paginator->url()));
		/****** For refreshing - Pooja**********/
		if(!empty($this->params->pass)){
			$is_search='1';
		}else if(!empty($this->request->data)){
			$is_search='1';
		}else if(!empty($this->request->query['dateFrom'])||!empty($this->request->query['dateTo'])){
			$is_search='1';
		}else if(!empty($this->request->query['doctorsId'])){
			$is_search='1';
		}else if(!empty($this->params->query['closed'])){
			$is_search='1';
		}
		else{
			$is_search='0';
		}
		echo $this->Form->input('search',array('type'=>'hidden','id'=>'is_search','value'=>$is_search));
		/****** End of refreshing **********/
		?>
</div>
<script> 
$( document ).ready(function () {
		//To change the status of selected options from disabled to enable.--Pooja
	$(".status").find("option:selected").attr('disabled', false);
	
	$('.tooltip').tooltipster({
 		interactive:true,
 		position:"right", 
 	});

	$('select').hover(function() {
		var value=$(this).val();
		 this.title = this.options[this.selectedIndex].text; 
	})
 	});

$('.task').change(function(){
	var id=$(this).attr('patient_id');
	var value=$(this).val();
	if(value=='qrCode'){
		var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'qr_card'))?>/'+id, '_blank',
        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');
	}else{
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Estimates','action'=>'packageEstimate'));?>'+'/null/'+$(this).attr('person_id')+'/?patientId='+$(this).attr('patient_id');
	}
});
</script>


