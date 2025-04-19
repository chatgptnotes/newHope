<?php echo $this->Form->create('',array('id'=>'leave_type_details'));?>
	<table class="table_format" cellspacing="1">
            <tr class="row_title">
			<td>Name</td>
			<?php $tdcount=count($leaveType);
			foreach ($leaveType as $type){?>
					<td><?php echo ucwords($type);?></td>
			<?php }?>
		</tr>
		<?php if($getDetailList){ //debug($getDetailList);?>
				<tr>
					<td><?php echo $getDetailList['role_leave']['role_name'];
							  echo $this->Form->hidden('role_id',array('name'=>'role_id','value'=>$getDetailList['role_leave']['role_id']));
							  echo $this->Form->hidden('department_id',array('name'=>'department_id','value'=>$getDetailList['role_leave']['department_id']));
					?></td>
					<?php $leaveArray=unserialize($getDetailList['role_leave']['leaves']);
						  foreach ($leaveType as $key=>$type){?>
							<td style="text-align: center;"><input class='textbox leaves' value="<?php echo $leaveArray[$key];?>" 
									   id="<?php echo $key?>" name="<?php echo "leave[$key]";?>" style="width: 50px;!important"></td>
					<?php }?>
				</tr>
		
		<?php }?>
		<tr>
			<td colspan="<?php echo $tdcount+1?>" style="text-align: right;" height="35px">
				<?php echo $this->Html->link('Save & Copy To All Emp','javascript:void(0)',array('class'=>'blueBtn','escape'=>false,'id'=>'copyAll'))?></td>
		</tr>
	</table>
<?php echo  $this->Form->end();?>
<div class="clr" style="margin-top: 20px; font-weight: bold;font-size: 14px;background: pink; padding:5px; text-align: center"> Employee Leave Configurations</div>
<div style="overflow: auto; max-height: 300px;" id="empDetail">
<?php echo $this->Form->create('',array('id'=>'emp_details'));?>
<table class="table_format" cellspacing="1">
    <tr class="row_title">
		<td>Sr.No</td>
		<td>Name</td>
		<?php foreach ($leaveType as $type){?>
				<td><?php echo ucwords($type);?></td>
		<?php }?>
	</tr>
	<?php if(!empty($getDetailList['user_leaves'])){ 
				$i=1;
				echo $this->Form->hidden('role_id',array('name'=>'role_id','value'=>$getDetailList['role_leave']['role_id']));				
				foreach($getDetailList['user_leaves'] as $emp){?>
			<tr>
				<th><?php echo $i;?></th>
				<td><?php echo $emp['name']?></td>
				<?php $leaveArray=unserialize($emp['leaves']);
					  echo $this->Form->hidden('department_id',array('name'=>'department_id[]','value'=>$emp['department_id']));
					  echo $this->Form->hidden('user_id',array('name'=>'user_id[]','value'=>$emp['user_id']));
					  foreach ($leaveType as $key=>$type){
						?>
						<td style="text-align: center;">
						<input class='textbox <?php echo $key;?>'  value="<?php echo $leaveArray[$key];?>"
								   id="<?php echo $key.'_'.$emp['user_id']?>" name="<?php echo "leave[$emp[user_id]][$key]";?>"
								    style="width: 50px !important;"></td>
				<?php }?>
			</tr>
	
	<?php $i++; }
		}
		else{?>
			<tr><td colspan="<?php echo $tdcount+2?>" style="text-align: center;"><?php echo "No Records Found"; ?></td></tr>
		<?php }?>
</table>
<?php echo  $this->Form->end();?>
</div>
<div style="clear:both; margin-top: 10px;"><?php echo $this->Html->link('Save Employee Leave Details','javascript:void(0)',array('class'=>'blueBtn','escape'=>false,'id'=>'empSave'))?></div>
<script>
	$('#copyAll').click(function(){
		formData = $('#leave_type_details').serialize();
		$.ajax({
			  type : "POST",
			  data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Leaves", "action" => "saveLeaveDetails",'?'=>array('type'=>'role_leave'), "admin" => false)); ?>",
			  context: document.body,
                          beforeSend:function(){
                            $('#busy-indicator').show('fast');
                          },
			//  data:"mapTarget="+icd_id+"&diagnoses_name="+diagnoses_name+"&patient_id="+patient_id+"&id="+dia_id+"&patient_info="+patientInfo,
			  success: function(data){
				    $('.leaves').each(function(){
						var tdClass=$(this).attr('id');
						$('.'+tdClass).val($(this).val());
					});
                                 $('#busy-indicator').hide('fast');
			  }
		});
		
	});
	$('#empSave').click(function(){
		formData = $('#emp_details').serialize();
		$.ajax({
			  type : "POST",
			  data: formData,
			  url: "<?php echo $this->Html->url(array("controller" => "Leaves", "action" => "saveLeaveDetails",'?'=>array('type'=>'emp_leave'), "admin" => false)); ?>",
			  context: document.body,
                           beforeSend:function(){
                            $('#busy-indicator').show('fast');
                          },
			//  data:"mapTarget="+icd_id+"&diagnoses_name="+diagnoses_name+"&patient_id="+patient_id+"&id="+dia_id+"&patient_info="+patientInfo,
			  success: function(data){
			    $('#busy-indicator').hide('fast');
			  }
		});
	});
        
        
        $(document).on("input",".textbox",function(){
            if (/[^0-9]/g.test(this.value))
            {
                this.value = this.value.replace(/[^0-9]/g,'');
            }
        });
</script>
