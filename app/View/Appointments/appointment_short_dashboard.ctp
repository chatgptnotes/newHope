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
.pastClass{
	background-color: pink ;
}

</style>

<!-- <div class="patient_info"> -->
<div class="">
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
		<td width="1%" style="text-align: center;" valign="top"
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
				<td width="1%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Patient UID ");?></td>
				<td width="3%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo $this->Paginator->sort('Person.dob',__("Gender,Age,Date Of Birth",true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));
				 //echo __("Gender<br>Age <br> DOB");?></td>
				 <td width="2%" valign="top"
				style="text-align: center; min-width: 84px;" class="table_cell"><?php echo $this->Paginator->sort('Appointment.status',__("Status",true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));?>
			</td>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Admit To Hospital");?></td>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Payment Received");?></td>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Followup Schedule");?></td>
			<td width="1%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo $this->Paginator->sort('Appointment.start_time',__("Scheduled   Arrived   Elapsed ",true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));
				?>
			</td>
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
			<?php if($future != 'future'){ ?>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo 'Task'?></td>
			<?php }?>
			<td width="5%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __("Encounter Closed");?></td>
			
		</tr>
		<?php 
			$toggle =0;
			$i=0 ;
			foreach($data as $appkey => $appointment){
				$futureFlag=0;
				foreach($schedule as $sche){
					if($sche['Appointment']['patient_id']==$appointment['Appointment']['patient_id'] && $sche[0]['scheCount']>=1){
						$futureFlag=1;
					}
				}
				$i++;
				$rowClass='';
				if($appointment['Appointment']['date']<date("Y-m-d")){
					$rowClass='pastClass';
				}else{
					$rowClass='';
				}
				
			if($toggle == 0) {
				
			   echo "<tr class='row_gray $rowClass'>";
			   $toggle = 1;
		    }else{
				echo "<tr class='row_gray_dark $rowClass'>";
			   $toggle = 0;
		    }
			?>
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
			<?php 
				$tooltip  ='<b>Age: </b>'.($age).'</br> <b>Mobile No: </b>'.$appointment['Person']['mobile']
				.'<br /><b> Email: </b>'.$appointment['Person']['email'].'<br /><b> Patient UID: </b>'.$appointment['Patient']['patient_id'].'<br /><b> Tariff: </b>'.$appointment['TariffStandard']['name']?>
		
				<td style="text-align: center;" class="tdLabel tooltip" id="boxSpace"
					title="<?php echo $tooltip?>"><?php //Pic
				$tooltip = '';
				
				if(file_exists(WWW_ROOT."/uploads/patient_images/thumbnail/".$appointment['Person']['photo']) && !empty($appointment['Person']['photo'])){ ?>
					<?php echo $this->Html->link($this->Html->image("/uploads/patient_images/thumbnail/".$appointment['Person']['photo'], array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$appointment['Person']['id'],"?"=>array('from'=>"appointments_management")), array('escape' => false)); ?>
					<?php }else{
						echo $this->Html->link($this->Html->image('icons/default_img.png', array('width'=>'50','height'=>'50','class'=>'pateintpic','title'=>'Edit EMPI','alt'=>'Edit EMPI')),array('controller'=>'Persons','action'=>'edit',$appointment['Person']['id'],"?"=>array('from'=>"appointments_management")), array('escape' => false));
				}?>
		</td>
		<td
			style="text-align: left; float: left; width: 110px; margin: 20px 0 0 0;"
			class="tdLabel" id="boxSpace"><?php  //Patient Name
			
			/*if($this->Session->read('website.instance')=='kanpur')
				$admission_id="<span style='color:red;font-size:16px;'> (".$appointment['Patient']['admission_id'].")</span>";
			else
				$admission_id="";*/
			
			$name=trim(ucwords(strtolower($appointment['Patient']['lookup_name']))).$admission_id;
			
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
							array('controller'=>'Persons','action'=>'patient_information',$appointment['Appointment']['person_id']),
							array('style'=>'text-decoration:underline;padding:2px 0px;','escape'=>false)).$flagEvent; 
							
					}else{
							if($appointment['Person']['vip_chk']=='1'){
								echo $this->Html->image("vip.png", array("alt" => "VIP", "title" => "VIP"));
							}else if($appointment['Person']['vip_chk']=='2'){
								echo $this->Html->image("foreigner.png", array("alt" => "Foreigner", "title" => "Foreigner"));
							}
						if(!empty($appointment['Diagnosis']['flag_event'])){
							$flagEvent=$this->Html->image('icons/context/flag.png',array('style'=>'float: none;','id'=>'flagEvent_'.$appointment['Appointment']['patient_id'],'class'=>'tooltip','title'=>$appointment['Diagnosis']['flag_event']));
						}
						else{
							$flagEvent='';
						}
						echo $this->Html->link($text,
								array('controller'=>'PatientsTrackReports','action'=>'sbar',$appointment['Appointment']['patient_id'],'Summary','appt'=>$appointment['Appointment']['id']),
								array('style'=>'text-decoration:underline;padding:2px 0px;','escape'=>false)).'  '.$flagEvent;	
										
					}
				} ?>
		</td>
		<td class="table_cell"><?php echo $appointment['Patient']['patient_id'];?></td>
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
		<td style="text-align: left;" class="chamberAllotted"><input
			type="hidden"
			id="<?php echo $appointment['Appointment']['patient_id'].$appointment['Appointment']['chamber_id']; ?>"
			name="<?php echo $appointment['Appointment']['patient_id'].$appointment['Appointment']['chamber_id']; ?>"
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
			
				if($appointment['Appointment']['status']!='' && $appointment['Appointment']['status'] != 'Scheduled' && $appointment['Appointment']['status']!='Pending' && $appointment['Appointment']['status']!='Confirmed with Patient'){
					 if($appointment['Appointment']['status']=='Arrived'|| $appointment['Appointment']['status']=='Ready'){
						$website = $this->Session->read('website.instance');
					if($website == 'kanpur' or $website == 'hope')
						$seen = array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen'/*,'disabled'=>'disabled','style'=>'display:none'*/);
		    		else
						$seen = array('name' => 'Seen',   'value' => 'Seen', 'class'=>'lightGreen','disabled'=>'disabled','style'=>'display:none');
							$status = array(array('name' => 'Scheduled',   'value' => 'Scheduled', 'class'=>'darkBrown','disabled'=>'disabled'),
									  array('name' => 'Arrived',   'value' => 'Arrived', 'class'=>'blue'),
									  array('name'=>'Next In Line','value'=>'Ready','class'=>'orange'),
									  array('name' => 'Assigned',   'value' => 'Assigned', 'class'=>'darkBlue','disabled'=>'disabled'),//style for hidding the options from this user..
									  array('name' => 'In-Progress',   'value' => 'In-Progress', 'class'=>'yellow','disabled'=>'disabled','style'=>'display:none'),
										$seen,
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
				$value= $appointment['Appointment']['status'] ;
				$currentId= $appointment['Person']['id']."_".$appointment['Appointment']['id'] ;
				if(!$future){
					if(!empty($dateSearch)){
						if($appointment['Appointment']['date']<date("Y-m-d")){
							echo __('Past Appointment');
						}else if($appointment['Appointment']['date']>date("Y-m-d")){
							echo $this->Form->input('status',array('type'=>'select','options'=>$options,'disabled'=>'disabled','patient_id'=>$appointment['Appointment']['patient_id'],
								 'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));
						}
						else{
							if($role != Configure::read('doctorLabel') /*&& $role != Configure::read('nurseLabel')*/ && $appointment['Appointment']['status']=='Seen'){
								echo $this->Form->input('status',array('type'=>'select','options'=>$options,'disabled'=>'disabled','patient_id'=>$appointment['Appointment']['patient_id'],
											'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));
							}elseif($role == Configure::read('doctorLabel')&& ( $appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show' || $appointment['Appointment']['status']=='Closed')){
								echo $this->Form->input('status',array('type'=>'select','options'=>$options,'disabled'=>'disabled','patient_id'=>$appointment['Appointment']['patient_id'],
										'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));?>
		</td>
		<?php 					 }else{
										echo $this->Form->input('status',array('type'=>'select','options'=>$options,'patient_id'=>$appointment['Appointment']['patient_id'],
				 							'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));?>
		</td>
		<?php 						  }
						         }//else dateSearch
					 }else{
							if($appointment['Appointment']['date']<date("Y-m-d")){
								echo __('Past Appointment');
							}else{
								if($role != Configure::read('doctorLabel') /*&& $role != Configure::read('nurseLabel')*/ && $appointment['Appointment']['status']=='Seen'){
									echo $this->Form->input('status',array('type'=>'select','options'=>$options,'disabled'=>'disabled','patient_id'=>$appointment['Appointment']['patient_id'],
									   'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));
								}elseif(($role == Configure::read('doctorLabel') /*|| $role == Configure::read('nurseLabel')*/)&& ( $appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show' || $appointment['Appointment']['status']=='Closed')){
									echo $this->Form->input('status',array('type'=>'select','options'=>$options,'disabled'=>'disabled','patient_id'=>$appointment['Appointment']['patient_id'],
										'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));?>
				</td>
				<?php 		    }//eof elseif
							       else{
								      echo $this->Form->input('status',array('type'=>'select','options'=>$options,'patient_id'=>$appointment['Appointment']['patient_id'],
									      'label'=>false,'div'=>false, 'class'=>$class,'id'=>$currentId,'value'=>$value,'style' => $style));?>
				</td>
				<?php 		  	       }// eof else
								  }
						  	}// eof else
				     }//eof $future if
			    }//eof parent else
			    ?>
			    
			    <td style="text-align: center;" class="tdLabel" id="boxSpace"><?php //register to ipd-- Pooja
			if($appointment['Patient']['is_opd']=='1'){
					echo $this->Html->image('icons/green.png');
			}else{
			echo $this->Html->link($this->Html->image('icons/red.png'),array('controller'=>'Patients','action'=>'add','?'=>array('type'=>'IPD','is_opd'=>'1','patient_id'=>$appointment['Appointment']['patient_id'],'apptId'=>$appointment['Appointment']['id'])),array('escape'=>false));
			}
			?>
			
			</td>
			<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php //paid
				if(!empty($appointment['Billing']['patient_id'])){
					if($appointment['Appointment']['is_future_app']=='1'){ // future appt is 1
						echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Register Patient First/Patient Not arrived yet'));
					}else{
						if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show'){
							echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet'));
						}else{
							$paid=$billData[$appointment['Appointment']['patient_id']]['total']-($billData[$appointment['Appointment']['patient_id']]['paid']+$billData[$appointment['Appointment']['patient_id']]['discount']);
								if($paid<=0 /*&& $appointment['0']['amount_pending']<=0*/){		
						    		echo $this->Html->link($this->Html->image('icons/green.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd', $appointment['Appointment']['patient_id'],'#'=>'serviceOptionDiv','?'=>array('apptId'=>$appointment['Appointment']['id'])), array('escape' => false,'title'=>'View Payment Info'));
						    	}else{
									echo $this->Html->link($this->Html->image('icons/orange_new.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd', $appointment['Appointment']['patient_id'],'#'=>'serviceOptionDiv','?'=>array('apptId'=>$appointment['Appointment']['id'])), array('escape' => false,'title'=>'View Payment Info'));
								}
						}
					
				}
			}else{
				if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending' || $appointment['Appointment']['status']=='Confirmed with Patient' || $appointment['Appointment']['status']=='Cancelled' ||$appointment['Appointment']['status']=='No-Show'){
					echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet'));
				}else{
					//echo $this->Html->link($this->Html->image('icons/red.png',array()),array('controller'=>'Billings','action'=>'dischargeBill',$appointment['Appointment']['patient_id']),array('escape'=>false));
					echo $this->Html->link($this->Html->image('icons/red.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd', $appointment['Appointment']['patient_id'],'#'=>'serviceOptionDiv','?'=>array('apptId'=>$appointment['Appointment']['id'])), array('escape' => false,'title'=>'View Payment Info'));
						
				}
			}?>
		</td>
		<td style="image-align: center;" class="tdLabel" id="boxSpace"><?php //Schedule 
			if($this->Session->read('website.instance')=='vadodara'){
					echo $this->Html->link($this->Html->image('icons/red.png',array()),'javascript:void(0)',
							 array('escape' => false,'title'=>'Followup Scheduled','id'=>'setMultiApp_'.$appointment['Appointment']['patient_id'],'class'=>'setMultiApp'));
			}else{
				if(!empty($appointment['Note']['has_no_followup'])||!empty($appointment['Appointment']['has_no_followup'])){
					echo $this->Html->image('icons/grey.png',array('title'=>'No Followup Needed'));
				}else{
					if($futureFlag==1){
						echo $this->Html->link($this->Html->image('icons/green.png',array()), array('controller'=>'DoctorSchedules','action' => 'doctor_event','patientid'=>$appointment['Appointment']['patient_id']),
							 array('escape' => false,'title'=>'Followup Scheduled'));
	                 }else{
						$futureDate=date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 day'));
						if(empty($appointment['Appointment']['status'])){//checking of empty status to create the equivalent id which is used in javascript
								echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'context-menu-two','id'=>'schedule_'.$appointment['Appointment']['id'].'_'.$appointment['Appointment']['patient_id'].'_1')), array('controller'=>'DoctorSchedules','action' => 'doctor_event','1',$appointment['Appointment']['doctor_id'],$appointment['Appointment']['doctor_id'],$futureDate, 'patientid'=>$appointment['Appointment']['patient_id']),
									 array('escape' => false,'title'=>'Schedule Appointment/Right Click For No Follow Up'));
							}else{
							    echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'context-menu-two','id'=>'schedule_'.$appointment['Appointment']['id'].'_'.$appointment['Appointment']['patient_id'].'_'.$appointment['Appointment']['status'])), array('controller'=>'DoctorSchedules','action' => 'doctor_event','1',$appointment['Appointment']['doctor_id'],$appointment['Appointment']['doctor_id'],$futureDate, 'patientid'=>$appointment['Appointment']['patient_id']),
									 array('escape' => false,'title'=>'Schedule Appointment/Right Click For No Follow Up'));
							}
						 }
					}
			    }?>
		</td>
		<!-- /********* Schedule Arrived and Elapsed Time **************/ -->
		<td style="text-align: center;" class="" id="boxSpace">
		<?php if(!$dateSearch){ ?>
		<span><?php echo $this->DateFormat->formatDate2Local($appointment['Appointment']['date'],Configure::read('date_format'),false);?></span>
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
			<?php $start=$appointment['Appointment']['date'].' '.$appointment['Appointment']['arrived_time'];
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
		<!-- /********* end of elapsed Time **************/ -->
		<?php if($future == 'future' || !empty($dateSearch)){?>
		<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php  //Date
				echo $this->DateFormat->formatDate2LocalForReport($appointment['Appointment']['date'],Configure::read('date_format')); ?>
		</td>
		<?php } if($future != 'future'){ ?>
		<td> <?php 
			if(isFingerPrintEnable==1)
			   $taskOptions=array('qrCode'=>'Print QR Code',/* 'packageEstimate'=>'Estimate', */'Patient Survey'=>'Patient Survey','fingerprint'=>'Capture Fingerprint','printsheet'=>'Print Sheet');
			else
				$taskOptions=array('qrCode'=>'Print QR Code',/* 'packageEstimate'=>'Estimate', */'Patient Survey'=>'Patient Survey','printsheet'=>'Print Sheet');
			
			
			 echo $this->Form->input('task',array('style'=>'width:100px;','type'=>'select','label'=>false,
						     'options'=>$taskOptions,'empty'=>"Select Task",'value'=>'','class'=>'currentDropdown task','patient_id'=>$appointment['Appointment']['patient_id'],'person_id'=>$appointment['Appointment']['person_id'],
							 'id'=>'task_'.$appointment['Appointment']['patient_id']));?></td>
		<?php }?>
		<td style="image-align: center;" class="tdLabel" id="boxSpace"><?php // close encounter
		      if(!empty($appointment['Note']['sign_note']) && /*$appointment[0]['paidCount']!=0 && */$appointment[0]['initCount']!=0){
					if($appointment['Appointment']['is_future_app']==1){
					echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet'));
					}else{
						if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending'){
							echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet'));
						}else{
								//The script will run only when the status is Seen and role other than doctor and nurse---- Pooja
								if($appointment['Appointment']['status']=='Seen'){?>
								<script>
								$(document).ready(function (){
									currentId="<?php echo $appointment['Appointment']['person_id'].'_'.$appointment['Appointment']['id'];?>";
									$.ajax({
										type : "POST",
										url: "<?php echo $this->Html->url(array("controller" => 'appointments', "action" => "update_appointment_status",'Closed','status',"admin" => false)); ?>",
										data:"id="+<?php echo $appointment['Appointment']['id']?>,//Pooja
									  context: document.body,	   
									  beforeSend:function(){
									    // this is where we append a loading image
									   //loading();	
									  }, 	  		  
									  success: function(data){
										  $('#'+currentId).val('Closed');
										  $('#'+currentId).addClass('darkGreen');
										  load_list();
									  }
								});
								});	
								</script>
						<?php 	} echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed;','title'=>'Encounter Closed'));?>							
							<?php 
						}
					}
				}else{
								if($appointment['Appointment']['status']=='Closed'){
									//if the staus is closed then the button will be green
									echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed;','title'=>'Encounter Closed'));
								}else{
									if($appointment['Appointment']['status']=='' || $appointment['Appointment']['status'] == 'Scheduled' || $appointment['Appointment']['status']=='Pending'){
										echo $this->Html->image('icons/red.png',array('style'=>'cursor:not-allowed;','title'=>'Patient Not arrived yet'));
									}else{
										echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'encounter','id'=>'encounter_'.$appointment['Appointment']['person_id'].'_'.$appointment['Appointment']['id'],'title'=>'Close Encounter')),'javascript:void(0)',array('escape'=>false));
									}
								}
							
							
							
						}?>
		</td>
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
			}else if(value=='Patient Survey'){
		        window.location.href = '<?php echo $this->Html->url(array('controller'=>'surveys','action'=>'opd_patient_surveys'));?>'+'/'+$(this).attr('patient_id');
			}else if(value=='fingerprint'){
		        window.location.href = '<?php echo $this->Html->url(array('controller'=>'persons','action'=>'finger_print'));?>'+'/'+$(this).attr('person_id')+'/capturefingerprint:'+$(this).attr('person_id')+'?'+$(this).attr('person_id');
			}else if(value=='printsheet'){
				var website= '<?php echo $this->Session->read("website.instance");?>'; 
				if(website=='vadodara'){
					    var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'opd_print_sheet'))?>/'+id, '_blank',
				        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=100,top=200,height=800');
					
					}else{
				   var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'opd_patient_detail_print'))?>/'+id, '_blank',
		            'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=100,top=200,height=800');
					}
			}
			else{
				window.location.href = '<?php echo $this->Html->url(array('controller'=>'Estimates','action'=>'packageEstimate'));?>'+'/null/'+$(this).attr('person_id')+'/?patientId='+$(this).attr('patient_id');
			}
		});
		</script>
		
		
				