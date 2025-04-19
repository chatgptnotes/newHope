<span>
   <?php  $role=$this->Session->read('role');
                  $type = ( $role != Configure::read('adminLabel') )  ? 'hidden' : 'text'; ?>
	<div>
		<?php echo __('Surgeon Charge'); ?>
		<font color="red"> *</font><br />
		<div style="height: 4%;">
		<?php echo $this->Form->input(null,array('name' => 'doctor_id', 'id'=> 'doctor_id', 'empty'=>__('Select Surgeon'), 'options'=> $doctorlist,
				'label' => false,'div'=>false,'style'=>'width:190px;', 'class'=> 'required safe surgeon')); ?>
				</div>
		<?php
		     echo $this->Form->input(null,array('name' => 'surgeon_amt', 'type'=>$type,'id'=> 'surgeonCharge','value'=>$charges['surgeon'],
			'label' => false, 'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
        ?>
	</div>
	<div style="float: left; width: 22%;">
		<?php echo __('Asst. Surgeon I'); ?><br />
		<div style="height: 4%;">
		<?php echo $this->Form->input(null,array('name' => 'asst_surgeon_one', 'id'=> 'asstDoctorIdOne', 'empty'=>__('Select Surgeon'), 'options'=> $doctorlist,
				'label' => false,'div'=>false, 'style'=>'width:190px;', 'class'=> ' safe surgeon')); ?>
				</div>
		<?php
	          echo $this->Form->input(null,array('name' => 'asst_surgeon_one_charge','type'=>$type ,'id'=> 'asstSurgeonOneCharge','label' => false,'value'=>$charges['assistantOne'],
			'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
        ?>
	</div>
	<div>
		<?php echo __('Asst. Surgeon II'); ?><br />
		<div style="height: 4%;">
		<?php echo $this->Form->input(null,array('name' => 'asst_surgeon_two', 'id'=> 'asstDoctorIdTwo', 'empty'=>__('Select Surgeon'), 'options'=> $doctorlist,
				'label' => false, 'div' => false,  'style'=>'width:190px;', 'class'=> 'safe surgeon')); ?>
				</div>
		<?php
		 	echo $this->Form->input(null,array('name' => 'asst_surgeon_two_charge','type'=>$type ,'id'=> 'asstSurgeonTwoCharge','value'=>$charges['assistantTwo'],
 			'label' => false, 'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
		 ?>
	</div>
	<div style="float: left;  width: 22%;">
		<?php echo __('Anaesthesist'); ?><br />
		<div style="height: 4%;">
		<?php echo $this->Form->input(null,array('name' => 'department_id', 'id'=> 'department_id', 'empty'=>__('Select Anaesthetist'),'options'=> $departmentlist,
 			 		 'label' => false, 'div' => false, 'style'=>'width:190px;', 'class'=> ' safe'));?>
 			 		 </div>
 		<?php $displayDD = ($type == 'hidden') ? 'none' : 'block';
			echo $this->Form->input(null, array('type'=>'hidden','name' => 'anaesthesia_service_group_id','id' => 'anaesthesia_service_group_id',
				'label'=> false, 'div' => false, 'error' => false));
			echo $this->Form->input(null,array('name' => 'anaesthesia_tariff_list_id', 'id'=> 'anaesthesia_tariff_list_id',
				 'empty'=>__('Select Service'), 'options'=> $services, 'label' => false,'style'=>'width:190px;'/* display:'.$displayDD */));?>
		<?php 
			echo $this->Form->input(null,array('name' => 'anaesthesia_cost','type'=>'hidden','id'=> 'anaesthesistCharge','label' => false,'value'=>$charges['anaesthesist'],
	 			 'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
       ?>
	</div>
	<div>
		<?php echo __('Cardiologist'); ?><br />
		<div style="height: 4%;">
		<?php echo $this->Form->input(null,array('name' => 'cardiologist_id', 'id'=> 'cardiologist_id', 'empty'=>__('Select Cardiologist'),
            		'options'=> $cardiologist, 'div' => false, 'label' => false,'style'=>'width:190px;', 'class'=> ' digits safe'));?>
            		</div>
		<?php 
		     echo $this->Form->input(null,array('name' => 'cardiologist_charge', 'type'=>$type ,'id'=> 'cardiologistCharge','value'=>$charges['cardiologist'],
 			'label' => false, 'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
         ?>
	</div>
	<?php $show = ($type == 'hidden') ? 'none' : 'block'  ?>
	<div style="float: left; width: 22%; display: <?php echo $show;?>">
		<?php echo __('OT Assistant'); ?> <br />
		<?php 
		      echo $this->Form->input(null,array('name' => 'ot_asst_charge','type'=>$type , 'id'=> 'otAsstCharge','value'=>$charges['otAssistant'],
 			'label' => false, 'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
       ?>
	</div>
	<div style="float: left; display: <?php echo $show;?>">
		<?php echo __('OT Charges'); ?><br />
		<?php
		 echo $this->Form->input(null,array('name' => 'ot_charges','type'=>$type, 'id'=> 'ot_charges','value'=>$charges['otCharge'],
 										'label' => false, 'div' => false, 'class' => ' digits safe',"style"=>"width:190px",'readOnly'=>true));
         ?>
	</div>
</span>
<div class="clr" style="height: 2%;"></div>
				<?php $selectedServices = unserialize($getOptDetails['OptAppointment']['ot_service']);
				$toggle = 1;
                                $chargeType = ( $this->Session->read('hospitaltype') == 'NABH' ) ? 'nabh_charges' : 'non_nabh_charges';
                          
				foreach(Configure::read('otExtraServices') as $key =>$service){

					$checked = (array_key_exists($key, $selectedServices)) ? true : false;
					$width = ($toggle % 2 == 0) ? '50%' : '30%';
					?>
				<div class="twoCol" style="height: 20px; width: <?php echo $width?>;">
					<span>  <?php 
					
					$checkboxValue=$assistantAndOtherCharges[$service."_discount"];
					if($checkboxValue==0)
						$checkboxfinalValue=$assistantAndOtherCharges[$service];
					else
						$checkboxfinalValue=$assistantAndOtherCharges[$service."_discount"];
						
					echo $this->Form->checkbox(null,array('name'=>"ot_service[".$key."]",'id' =>$service,
							 'label'=> false,'value'=>$checkboxfinalValue,'checked'=>$checked,'hiddenField'=>false));
					?> </span><span style="font-size: 14px"> <?php echo __($key); ?></span>
				</div><?php $toggle++;?>
				<?php }?>