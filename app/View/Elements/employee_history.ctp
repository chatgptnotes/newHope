<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	<tr>
		<th style="padding-left: 10px;" colspan="11"><?php echo __('Type Of Employment');?>
		</th>
	</tr>
	<tr>
		<td style="width:20%;padding-left: 10px;">Type</td>
		<td style="width:20%"><?php echo $this->Form->input('HrDetail.employee_type',array('type'=>'select','options'=>Configure::read('employee_type'),
				'empty' => __ ( 'Select Type' ),'id'=>'employee_type','onchange'=>'onEmployeeTypeChange();','class'=>'textBoxExpnd', 'div'=>false,'label'=>false));?>
		</td>

		<td style="width:20%" id ="desig">Date of Joining</td>
		<td style="width:20%" id ="desig"><?php echo $this->Form->input('HrDetail.date_of_join', array('type'=>'text', 'id' => 'dateOfJoin', 'style'=>'float: left;','class' => 'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly'));
		?></td>
	</tr>
	<tr>
	<td style="padding-left: 10px;">Role in system</td>
		<td width="30%"><?php echo $this->Form->input('HrDetail.role_in_system', array('type'=>'select','options'=>$roles,'empty' => __ ( 'Select ' ), 'legend'=>false,'label'=>false,'id' => 'role_in_system','class'=>'textBoxExpnd ')); ?>
		</td></tr> 
	<tr>
		<td id="valid_till" style="display: none; padding-left: 10px;">Valid
			Till</td>
		<td id="valid_till" style="display: none;"><?php echo $this->Form->input('HrDetail.valid_till', array('type'=>'text', 'id' => 'valid_til', 'style'=>'float: left;','class' => 'textBoxExpnd', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly'));
		?></td>
		<td id ="desig" style="padding-left: 10px;">Designation</td>
		<td id ="desig"><?php echo $this->Form->input('HrDetail.history_designation_id',array('type'=>'select','options'=>$designations,'empty' => __ ( 'Select' ),'div'=>false,'label'=>false,'class'=>'textBoxExpnd '));?>
		</td>
	</tr>
	<tr style="display: none;" id="apprentice">
		<td style="padding-left: 10px;">Apprentice</td>
		<td><?php echo $this->Form->checkbox('HrDetail.apprentice', array('style'=>'float:left','legend'=>false,'label'=>false,'id' => 'apprentices')); ?>
		</td>
	</tr>
	<tr class="yes" style="display: none">
		<td style="padding-left: 10px;">BoAT Registration No</td>
		<td><?php echo $this->Form->input('HrDetail.boat_reg_no', array('class' => 'textBoxExpnd','id' => 'boat_reg_no', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>'off'));?>
		</td>
	</tr>
	<tr class="yes" style="display: none">
		<td style="padding-left: 10px;">Starts on</td>
		<td><?php	echo $this->Form->input('HrDetail.starts_on', array('type'=>'text','class' => 'textBoxExpnd', 'id' => 'starts_on', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly')); ?>
		</td>
		<td style="padding-left: 10px;">Ends on</td>
		<td><?php	echo $this->Form->input('HrDetail.ends_on', array('type'=>'text','class' => 'textBoxExpnd',
				 'id' => 'ends_on', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly')); ?>
		</td>
	</tr>
	<tr id="probation_completion" style="display: none">
		<td style="padding-left: 10px;">Date of probation completion</td>
		<td><?php	echo $this->Form->input('HrDetail.probation_complition_date', array('type'=>'text', 'id' => 'probation_complition_date','class' => 'textBoxExpnd', 'style'=>'float: left;', 'label'=> false, 'div' => false, 'error' => false,'readonly' => 'readonly')); ?>
		</td>
	</tr>
	<tr>
		<th style="padding-left: 10px;" colspan="11"><?php echo __('Placement and promotion history');?>
		</th>
	</tr>
	<tr>
		<td colspan="4">
		
                    <?php $displayPlacement = $this->data['HrDetail']['employee_type'] ? '' : 'display : none'; ?>
			<table width="99%" border="0" cellspacing="0" cellpadding="0" style="<?php echo $displayPlacement; ?>"
				align="center" class="formFull" id="placementHistory">
				<tr>
					<th class="text"><?php echo __('Sr.No');?></th>
					<th><?php echo __('Cadre');?></th>
					<th class="level" style="display: none"><?php echo __('Grade');?></th>
					<th class="level" style="display: none"><?php echo __('Level');?></th>
					<th><?php echo __('Designation');?></th>
					<th><?php echo __('Unit Placed');?></th>
					<th><?php echo __('From(Date)');?></th>
					<th><?php echo __('To(Date)');?></th>
					<th><?php echo __('Reporting Manager');?></th>
					<th><?php echo __('Shifts Allowed');?></th>
					<th><?php echo __('Management Approval');?></th>
                    <th><?php echo __('Multiple Punch');?></th>
					<th><?php echo __('Action');?></th>
				</tr>
                 <?php $shiftData= '';
                 if($this->data['HrDetail']['role_in_system']){
	                 if($roles[$this->data['HrDetail']['role_in_system']] == Configure::read('doctor')) {
	                 		$shiftData = $allShiftData;
	                 	}
                 	else{
						$shiftData = $allShiftData;
						}
                 }
                 //overwrite allShiftData
                 $shiftData = $allShiftData;
                  ?>
                  
				<?php  if($placementHisData){ ?>
                                <?php $key = 0;?>
				<?php   foreach($placementHisData as $value){?>
				
				<tr id="removeHistoryRow-<?php echo $key;?>">
					<td class="text"><?php echo $placementSrNo = $key+1;?></td>
					<td><?php echo $this->Form->hidden("PlacementHistory.$key.id",array('id'=>'id','value'=>$value['PlacementHistory']['id']));?>
					<?php echo $this->Form->input("PlacementHistory.$key.cadre",array('id'=>"cadre-".$key,'value'=>$value['PlacementHistory']['cadre'],'style'=>'width:100px','options' => $cadres,'empty'=>'Select'));?>
					</td>
					<td class="level" style="display: none"><?php echo $this->Form->input("PlacementHistory.$key.grade",array('options' => $greades,'empty'=>'Select','style'=>'width:100px','value'=>$value['PlacementHistory']['grade'],'id'=>"grade-".$key));?>
					</td>
					<td class="level" style="display: none"><?php echo $this->Form->input("PlacementHistory.$key.level",array('options' =>$level,'empty'=>'Select','value'=>$value['PlacementHistory']['level'],'style'=>'width:100px','id'=>"level-".$key));?>
					</td>
					<td ><?php echo $this->Form->input("PlacementHistory.$key.designation",array('id'=>"designation-".$key,'style'=>'width:100px','options' => $departments,'value'=>$value['PlacementHistory']['designation'],'empty'=>'Select'));?>
					</td>
					<td><?php echo $this->Form->input("PlacementHistory.$key.unit_placed",array('options' => $locations,'style'=>'width:100px','empty'=>'Select','value'=>$value['PlacementHistory']['unit_placed'],'id'=>"unit_placed-".$key));?>
					</td>
					<td class="text"><?php echo $this->Form->input("PlacementHistory.$key.cadre_from_date",array('type'=>'text','class'=>'cadre_from_date','value'=>$value['PlacementHistory']['cadre_from_date'],'readonly'=>'readonly','style'=>'width:78px;float:left'));?>
					</td>
					<td class="text"><?php echo $this->Form->input("PlacementHistory.$key.cadre_to_date",array('type'=>'text','class'=>'cadre_to_date','value'=>$value['PlacementHistory']['cadre_to_date'],'readonly' => 'readonly','style'=>'width:78px;float:left'));?>
					</td>
					<td class="text"><?php echo $this->Form->input("PlacementHistory.$key.reporting_manager_name",array('value'=>$manager[$value['PlacementHistory']['reporting_manager']],'style'=>'width:138px','id'=>"reporting_manager-".$key,'class'=>'reporting_manager'));
					echo $this->Form->hidden("PlacementHistory.$key.reporting_manager",array('value'=>$value['PlacementHistory']['reporting_manager'],'id'=>"reporting_manager_id-".$key));?>
					</td>
					<td class="text"><?php echo $this->Form->input("PlacementHistory.$key.shifts",array('options' => $shiftData,'empty'=>'Select','value'=>$value['PlacementHistory']['shifts'],'class'=>"shiftname ",'style'=>'width:100px','id'=>"shifts-".$key));?>
					</td>
					<?php if($this->Session->read('role')==Configure::read('managementRoleLabel')){?>
					<td class="text"><?php echo $this->Form->input("PlacementHistory.$key.management_approval",array('type'=>'checkbox','value'=>$value['PlacementHistory']['management_approval'],'checked'=>$value['PlacementHistory']['management_approval']=='1'?'checked':'','class'=>"managementApproval",'id'=>"managementApproval-".$key,'title'=>'managementApproval','hiddenField'=>false));?>
					</td><?php }else{ ?>
						<td class="text"><?php 
						if(!empty($value['PlacementHistory']['management_approval'])){
						echo " Shift Approved"; } ?>
								</td>
					<?php }?>
                    <td class="text"><?php echo $this->Form->input("PlacementHistory.$key.multiple_punch_allowed",array('type'=>'checkbox','value'=>$value['PlacementHistory']['multiple_punch_allowed'],'checked'=>$value['PlacementHistory']['multiple_punch_allowed']=='1'?'checked':'','class'=>"isMultiplePunchAllowed ",'id'=>"multiplePunchAllowed-".$key,'title'=>'check to allowed multiple punch','onclick'=>"if(this.checked){ $(this).val(1); }else{ $(this).val(0); }",'hiddenField'=>false));?>
					</td>
					<?php if($key == 0) { ?>
					<td class="text"><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
							'alt'=> __('Add', true),'id'=>'addMores','style'=>'float:none;'));?>
					</td>
					<?php } else{ ?>
					 <td class="text"><?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
	   			 					'alt'=> __('Remove', true),'class'=>'removeHistory','style'=>'float:none;','id'=>$key));?>
				    </td> <?php }?>
				</tr>
				<?php $key++;}?>
				<?php }else{  ?>
				<?php $key = 0;?>
					<tr>
					<td class="text"><?php echo $placementsrNo = $key+1;?></td>
					<td><?php echo $this->Form->hidden("PlacementHistory.$key.id",array('id'=>'id',));?>
					<?php echo $this->Form->input("PlacementHistory.$key.cadre",array('id'=>"cadre-".$key,'style'=>'width:100px','options' =>$cadres,'empty'=>'Select'));?>
					</td>
					<td class="level" style="display: none"><?php echo $this->Form->input("PlacementHistory.$key.grade",array('options' => $greades,'empty'=>'Select','style'=>'width:100px','id'=>"grade-".$key));?>
					</td>
					<td class="level" style="display: none"><?php echo $this->Form->input("PlacementHistory.$key.level",array('options' =>$level,'empty'=>'Select','style'=>'width:100px','id'=>"level-".$key));?>
					</td>
					<td><?php echo $this->Form->input("PlacementHistory.$key.designation",array('id'=>"designation-".$key,'style'=>'width:100px','options' => $departments,'empty'=>'Select'));?>
					</td>
					<td><?php echo $this->Form->input("PlacementHistory.$key.unit_placed",array('options' => $locations,'style'=>'width:100px','empty'=>'Select','id'=>"unit_placed-".$key));?>
					</td>
					<td class="text"><?php echo $this->Form->input("PlacementHistory.$key.cadre_from_date",array('type'=>'text','class'=>'cadre_from_date','readonly' => 'readonly','style'=>'width: 78px; float: left;'));?>
					</td>
					<td class="text"><?php echo $this->Form->input("PlacementHistory.$key.cadre_to_date",array('type'=>'text','class'=>'cadre_to_date','readonly' => 'readonly','style'=>'width: 78px; float: left;'));?>
					</td>
					<td class="text"><?php echo $this->Form->input("PlacementHistory.$key.reporting_manager_name",array('class' => ' textBoxExpnd','style'=>'width:138px','id'=>"reporting_manager-".$key,'class'=>'reporting_manager'));
					echo $this->Form->hidden("PlacementHistory.$key.reporting_manager",array('value'=>'','id'=>"reporting_manager_id-".$key));?>
					</td>
					<td class="text"><?php echo $this->Form->input("PlacementHistory.$key.shifts",array('empty'=>'Select','options' =>$shiftData,'value'=>$value['shifts'],'class'=>"shiftname freshShift",'style'=>'width:100px','id'=>"shifts-".$key));?>
					<?php if($this->Session->read('role')==Configure::read('managementRoleLabel')){ ?>
					</td>
                       <td class="text"><?php echo $this->Form->input("PlacementHistory.$key.management_approval",array('type'=>'checkbox','value'=>$value['management_approval'],'class'=>"managementApproval ",'id'=>"managementApproval-".$key,'title'=>'check to allowed Shift','hiddenField'=>false,'onclick'=>"if(this.checked){ $(this).val(1); }else{ $(this).val(0); }"));?>
					</td>
					<?php }else{?>
						            <td class="text">
											</td>
					<?php } ?>
                       <td class="text"><?php echo $this->Form->input("PlacementHistory.$key.multiple_punch_allowed",array('type'=>'checkbox','value'=>$value['multiple_punch_allowed'],'class'=>"isMultiplePunchAllowed ",'id'=>"multiplePunchAllowed-".$key,'title'=>'check to allowed multiple punch','hiddenField'=>false,'onclick'=>"if(this.checked){ $(this).val(1); }else{ $(this).val(0); }"));?>
					</td>
					
					<td class="text"><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
							'alt'=> __('Add', true),'id'=>'addMores','style'=>'float:none;'));?>
					</td>
				</tr>
				<?php }?>
			</table>
		</td>
	</tr>	
<tr>
		<th style="padding-left: 10px;" colspan="11"><?php echo __('Appraisal history');?>
		</th>
	</tr>	
<tr>
        <td colspan="3">
            <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="formFull" id= Appraisalhistory >
                <tr>
                    <th class="text" ><?php echo __('Sr.No');?>
                    </th>
                    <th ><?php echo __('Month/Year of appraisal');?>
                    </th>
                    <th><?php echo __('Appraisal Rating');?>
                    </th>
                    <th><?php echo __('Appraisal Result');?>
                    </th>
                    <th><?php echo __('Action');?></th>
                </tr>
                <?php if($this->data['HrDetail']['appraisal_history']){ ?>
                <?php $key = 0; ?>
                <?php  foreach($this->data['HrDetail']['appraisal_history'] as $value){ ?> 
                <tr id="removeAppraisalhistory-<?php echo $key;?>">
                    <td class="text" ><?php echo $srNoAppr = $key+1;?>
                    </td>
                    <td><?php echo $this->Form->input("HrDetail.appraisal_history.$key.month_year_appraisal",array('type'=>'text','class'=>'month_year_appraisal','id'=>"month_year_appraisal-$key",'value'=>$value['month_year_appraisal'],'class'=>'month_year_appraisal textBoxExpnd'));?>
                    </td>
                    <td><?php echo $this->Form->input("HrDetail.appraisal_history.$key.appraisal_rating", array('class' => 'textBoxExpnd','value'=>$value['appraisal_rating'],'style'=>'width:160px', 'id' => "appraisal_rating-$key", 'label'=> false, 'div' => false, 'error' => false));?></td>
                    </td>
                    <td><?php echo $this->Form->input("HrDetail.appraisal_history.$key.appraisal_result",array('type'=>'text','style'=>'width:160px','id'=>"appraisal_result-$key",'value'=>$value['appraisal_result'],'class'=>'textBoxExpnd'));?>
                    </td>
                    <?php if($key == 0) { ?>
                    <td class="text"><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
                                    'alt'=> __('Add', true),'id'=>'addMoreAppraisalhistory','style'=>'float:none;'));?>
                    </td>
                    <?php } else{ ?>
                       <td class="text"><?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
                                                    'alt'=> __('Remove', true),'class'=>'removeAppraisalhistory','style'=>'float:none;','id'=>$key));?>
                    </td> <?php }?>
                </tr> 
                    <?php $key++;
						 }?>
                    <?php }else{?>
                <?php $key = 0;?>
                <tr>
                    <td class="text" ><?php echo $key+1;?>
                    </td>
                    <td><?php echo $this->Form->input("HrDetail.appraisal_history.$key.month_year_appraisal",array('type'=>'text','id'=>"month_year_appraisal-$key",'value'=>$value['member_name'],'class'=>'month_year_appraisal textBoxExpnd'));?>
                    </td>
                    <td><?php echo $this->Form->input("HrDetail.appraisal_history.$key.appraisal_rating", array('class' => 'textBoxExpnd','style'=>'width:160px','value'=>$value['appraisal_rating'], 'id' => "member_sex-$key", 'label'=> false, 'div' => false, 'error' => false));?>
                    </td>
                    <td><?php echo $this->Form->input("HrDetail.appraisal_history.$key.appraisal_result",array('type'=>'text','style'=>'width:160px','id'=>"appraisal_result-$key",'value'=>$value['appraisal_result'],'class'=>'textBoxExpnd'));?>
                    </td>
                     <td class="text"><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true), 
                                    'alt'=> __('Add', true),'id'=>'addMoreAppraisalhistory','style'=>'float:none;'));?>
                    </td>
                </tr>
                <?php }?>	
            </table>  
        </td>
    </tr>
</table>
<script>
	var placementSrNo = isNaN(parseInt('<?php echo $placementSrNo;?>')) ? 1 : parseInt('<?php echo $placementSrNo;?>');
    var srNoAppr = isNaN(parseInt('<?php echo $srNoAppr;?>')) ? 1 : parseInt('<?php echo $srNoAppr;?>');
	var designations = jQuery.parseJSON('<?php echo json_encode($departments);?>');
	var levels = jQuery.parseJSON('<?php echo json_encode($level);?>');
	var greades = jQuery.parseJSON('<?php echo json_encode($greades);?>');
	var locations = jQuery.parseJSON('<?php echo json_encode($locations);?>');
	var cadre = jQuery.parseJSON('<?php echo json_encode($cadres);?>');
	var multiplePunchVal = jQuery.parseJSON('<?php echo json_encode($value['multiple_punch_allowed']);?>');
	var allShiftData  = jQuery.parseJSON('<?php echo json_encode($allShiftData);?>');

	var shiftData = "";
	var getUSER = $("#role_in_system option:selected").text(); 
	if( getUSER == '<?php echo Configure::read('doctor'); ?>'){  
		var	shiftData = jQuery.parseJSON('<?php echo json_encode($doctorShiftData);?>');
    }else{
    	var	shiftData =  jQuery.parseJSON('<?php echo json_encode($allShiftData);?>');
    }	
	
	

	$(function(){
            $('#employee_type').change(function (){
                if($(this).val() != '')
                    $('#placementHistory').show();
                else
                    $('#placementHistory').hide();
            });
            
		$('#addMores').click(function () {
                    if($('#employee_type').val() != 'On-roll')
                        var levelGrade = 'none';
			$('#placementHistory tbody:last')
				.append($('<tr>').attr('id','removeHistoryRow-'+placementSrNo)
					.append($('<td>').text(placementSrNo+1).attr('class','text'))
				 		.append($('<td>')
						 		.append($('<select>').css('width','100px').attr({'name':'data[PlacementHistory]['+placementSrNo+'][cadre]','id' : 'cadre-'+placementSrNo})
				 				.append(new Option("Select", ""))))
                         .append($('<td>').css('display', levelGrade).attr('class','level')
				 		 		.append($('<select>').css('width','100px').attr({'name':'data[PlacementHistory]['+placementSrNo+'][grade]', 'id' : 'grade-'+placementSrNo})
				 		 				.append(new Option("Select", ""))))
				 		 .append($('<td>').css('display', levelGrade).attr('class','level')
				 		 		.append($('<select>').css('width','100px').attr({'name':'data[PlacementHistory]['+placementSrNo+'][level]', 'id' : 'level-'+placementSrNo})
				 		 				.append(new Option("Select", ""))))
                         .append($('<td>').append($('<select>').css('width','100px')
					 		 	.attr({'name':'data[PlacementHistory]['+placementSrNo+'][designation]', 'id' : 'designation-'+placementSrNo})
			 		 			.append(new Option( 'Select' , ''))))
		 				.append($('<td>').append($('<select>').css('width','100px')
					 		 	.attr({'name':'data[PlacementHistory]['+placementSrNo+'][unit_placed]','id' : 'unit_placed-'+placementSrNo})
			 		 			.append(new Option("Select",''))))
		 				.append($('<td>')
				 				.append($('<input>').css({'width':'78px','float' : 'left'})
						 				.attr({'name':'data[PlacementHistory]['+placementSrNo+'][cadre_from_date]','class':'cadre_from_date','readonly':'readonly','id' : 'cadre_from_date-'+placementSrNo})))
				 		.append($('<td>')
				 				.append($('<input>').css({'width':'78px','float' : 'left'})
						 				.attr({'name':'data[PlacementHistory]['+placementSrNo+'][cadre_to_date]','class':'cadre_to_date','readonly':'readonly','id' : 'cadre_to_date-'+placementSrNo})))
				 		.append($('<td>').attr('class','text')
                                       .append($('<input>').css('width','138px')
					 		 	.attr({'name':'data[PlacementHistory]['+placementSrNo+'][reporting_manager_name]' ,'id' : 'reporting_manager-'+placementSrNo})))
					 	.append($('<input>').attr({'name':'data[PlacementHistory]['+placementSrNo+'][reporting_manager]','class':' textBoxExpnd' ,'id' : 'reporting_manager_id-'+placementSrNo,'type':'hidden'}))
					 		 		 	
			 		 	.append($('<td>').attr('class','text').append($('<select>').css('width','100px')
					 		 			.attr({'name':'data[PlacementHistory]['+placementSrNo+'][shifts]', 'id' : 'shifts-'+placementSrNo})
					 		 			.append(new Option("Select",''))))
			 		 	.append($('<td>').attr('class','text')
			 				.append($('<input>').attr({'name':'data[PlacementHistory]['+placementSrNo+'][management_approval]','value':'management_approval','type':'checkbox','class':'isMultiplePunchAllowed' ,'id' : 'multiplePunchAllowed-'+placementSrNo})))												
				 		
			 		 	.append($('<td>').attr('class','text')
			 				.append($('<input>').attr({'name':'data[PlacementHistory]['+placementSrNo+'][multiple_punch_allowed]','value':'multiplePunchVal','type':'checkbox','class':'isMultiplePunchAllowed' ,'id' : 'multiplePunchAllowed-'+placementSrNo})))												
				 		.append($('<td class="text">').attr('id','Td-'+placementSrNo).append($('<span>').attr({'class':'removeHistory','id' : placementSrNo})
			 		 		 	.append('<?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
		   			 					'alt'=> __('Remove', true),'style'=>'float:none;'));?>')))
			    );
				$.each( designations, function( key, value ) {
					$('#designation-'+placementSrNo).append( new Option(value , key));
					});
				var shiftData = ""
				if( $("#role_in_system option:selected").text() == '<?php echo Configure::read('doctorLabel'); ?>'){  
	       		  	shiftData = allShiftData;
	         	}else if($("#role_in_system option:selected").text() != '<?php echo Configure::read('doctorLabel'); ?>' && $("#role_in_system").val() != "") { 
	         		 
	         		shiftData =  allShiftData;
	         	}else{
	         		shiftData =  allShiftData;
		         	}
				$.each(allShiftData, function( key, value ) { 
					
					$('#shifts-'+placementSrNo).append( new Option(value , key));
				});
				$.each(levels, function( key, value ) { 
					$('#level-'+placementSrNo).append( new Option(value , key));
				});
				$.each(greades, function( key, value ) { 
					$('#grade-'+placementSrNo).append( new Option(value , key));
				});
				$.each(locations, function( key, value ) { 
					$('#unit_placed-'+placementSrNo).append( new Option(value , key));
				});
				$.each(cadre, function( key, value ) { 
					$('#cadre-'+placementSrNo).append( new Option(value , key));
					});
				
			$('.removeHistory').on('click' , function (){
				$("#removeHistoryRow-" + $(this).attr('id')).remove();
			});
			
			$( '#reporting_manager-'+placementSrNo).autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "App", "action" => "advanceMultipleAutocomplete","User","full_name",'null',"null","no","admin" => false,"plugin"=>false)); ?>/location_id=<?php echo $this->Session->read('locationid') ?>",
		           // setPlaceHolder: false,
		        select: function( event, ui ) {
		            $("#reporting_manager_id-".placementSrNo).val(ui.item.id);
		        },
		        messages: {
		          noResults: '',
		          results: function() {}
		        }
		    });	
			   
			placementSrNo++;
			
			$(".cadre_from_date,.cadre_to_date").datepicker({
				showOn: "both",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				//maxDate: new Date(),
				dateFormat:'<?php echo $this->General->GeneralDate();?>',		
			});
		});
			
			$('.reporting_manager').autocomplete({
				source: "<?php echo $this->Html->url(array("controller" => "App", "action" => "advanceMultipleAutocomplete","User","full_name",'null',"null",'no',"admin" => false,"plugin"=>false)); ?>/location_id=<?php echo $this->Session->read('locationid') ?>",
		           // setPlaceHolder: false,
                                select: function( event, ui ) {
			        var thisId = $(this).attr('id');
		        	var idCounter = thisId.split('-');
                                $("#reporting_manager_id-"+idCounter[1]).val(ui.item.id);
		        },
		        messages: {
		          noResults: '',
		          results: function() {}
		        }
		    });	
	});
	    $(function(){
	        $('#addMoreAppraisalhistory').click(function () {
				
	            $('#Appraisalhistory tbody:last').append($('<tr>').attr('id','removeAppraisalhistory-'+srNoAppr)
	                .append($('<td>').text(srNoAppr+1).attr('class','text'))  
	                .append($('<td>')
	                 .append($('<input>').attr({'name':'data[HrDetail][appraisal_history]['+srNoAppr+'][month_year_appraisal]','class':'textBoxExpnd month_year_appraisal','readonly': 'readonly', 'id' : 'month_year_appraisal-'+srNoAppr})))
	                  .append($('<td>').attr('class','text')
	                  .append($('<input>').attr({'name':'data[HrDetail][appraisal_history]['+srNoAppr+'][appraisal_rating]','type':'text','class':'textBoxExpnd',  'id' : 'appraisal_rating-'+srNoAppr})
	                  .css('width','160px')))	
	                   .append($('<td>').attr('class','text')
	                  .append($('<input>').attr({'name':'data[HrDetail][appraisal_history]['+srNoAppr+'][appraisal_result]','type':'text','class':'textBoxExpnd',  'id' : 'appraisal_result-'+srNoAppr})
	                  .css('width','160px')))	
	               
	                .append($('<td class="text">').attr('id','Td-'+srNoAppr).append($('<span>').attr({'class':'removeAppraisalhistory','id' : srNoAppr})
	                                .append('<?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
	                                                'alt'=> __('Remove', true),'style'=>'float:none;'));?>')))
	             );
	            $('.removeAppraisalhistory').on('click' , function (){
	                    $("#removeAppraisalhistory-" + $(this).attr('id')).remove();
	            });	

	            $(".month_year_appraisal").datepicker({ 
	        		showOn: "both",
	        		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	        		buttonImageOnly: true,
	        		changeMonth: true,
	        		changeYear: true,
	        		yearRange: '1950',
	        		maxDate: new Date(),
	        		dateFormat:'<?php echo $this->General->GeneralDate();?>',		
	        	});
	            srNoAppr++;    
	        });
	    });
	        $(document).ready(function (){
	    		var getType=$("#employee_type option:selected").val();       
	    		if(getType=='Trainee'){ 
	                            //$("#apprentices").attr('checked',false);
	    			$("#apprentice,#valid_till,#desig").show();
	    			$("#probation_completion,.level").hide();
	    		}else if(getType =='On-roll'){ 
	    			$("#probation_completion,.level,#desig").show()
	    			$("#apprentice,.yes,#valid_till").hide();
	    		}else if(getType=='Contract'){ 
	    			$("#valid_till,#desig").show();
	    		    $("#probation_completion,#apprentice,.level,.yes ").hide();
	    			}
    			 var shiftData = "";
	         $('#role_in_system').change(function (){
	        	 var shiftData = "";
	    				var getUSER =$("#role_in_system option:selected").text(); 
	    				if( getUSER == '<?php echo Configure::read('doctor'); ?>'){  
	    	       		  	shiftData = doctorShiftData;
	    	         	}else{
	    	         		
	    	         		shiftData =  allShiftData;
	    	         	}	
	    	         	 $('.freshShift option').remove();
	    				 $.each(shiftData, function( key, value ) { 
	    						$('.freshShift').append( new Option(value , key));
	    					}); 
	    					$('select').removeClass('freshShift');	     
	    		 });
	    });	
	
	function onEmployeeTypeChange(){ 
		$('#boat_reg_no').val('');
		$('#starts_on').val('');
		$('#ends_on').val('');
		var getType=$("#employee_type option:selected").val();       
		if(getType=='Trainee'){ 
                        $("#apprentices").attr('checked',false);
			$("#apprentice,#valid_till,#desig").show();
			$("#probation_completion,.level").hide();
		}else if(getType =='On-roll'){  
			$("#probation_completion, .level ,#desig").show()
			$("#apprentice,.yes,#valid_till").hide();
		}else if(getType=='Contract'){ 
			$("#valid_till,#desig").show();
		    $("#probation_completion,#apprentice, .level ,.yes").hide();
			}
	}
	   if('<?php echo $this->data['HrDetail']['apprentice']; ?>' =='1'){  
				$('.yes').show();
		}else{
				$('.yes').hide(); 
		}
	$('#apprentices').click(function(){	
		if($("#apprentices").is(':checked')){	
			$('.yes').show();
		}else{
				$('.yes').hide(); 
				$('#boat_reg_no').val('');
				$('#starts_on').val('');
				$('#ends_on').val('');
		}
	});
	
	$("#dateOfJoin").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>',		
	});

	$("#valid_til").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		//maxDate: new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>',		
	});
	$(".cadre_from_date, .cadre_to_date").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		//maxDate: new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>',		
	});
	$("#starts_on, #ends_on").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
        dateFormat:'<?php echo $this->General->GeneralDate();?>',		
	});
	
	$("#probation_complition_date").datepicker({ 
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		//maxDate: new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>',		
	});
	$(".month_year_appraisal").datepicker({ 
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate();?>',		
	});
	$( ".cadre_to_date, .cadre_from_date ").click(function(){ 
		$('.cadre_to_date, .cadre_from_date ').validationEngine('hide');
		   var fromdate = new Date($('.cadre_from_date').val());
	     var todate = new Date($('.cadre_to_date').val());
	     if(fromdate.getTime() > todate.getTime()) {
	    $('.cadre_from_date').validationEngine('showPrompt', 'To date should be greater than from date');
	     return false;
	    }
	});	
	$( "#starts_on,#ends_on").click(function(){  
		$('#starts_on,#ends_on').validationEngine('hide');
		   var fromdate = new Date($('#starts_on').val());
	     var todate = new Date($('#ends_on').val());
	     if(fromdate.getTime() > todate.getTime()) {
	    $('#ends_on').validationEngine('showPrompt', 'start date should be greater than end date');
	     return false;
	    }
	});	
	</script>
