<style>
#changeUserLocation {
	border: 0.1em solid #808000;
	border-radius: 25px;
	color: #E7EEEF;
	font-size: 13px;
	outline: medium none;
	padding: 0;
	resize: none;
}
#changeUserRole {
	border: 0.1em solid #808000;
	border-radius: 25px;
	color: #E7EEEF;
	font-size: 13px;
	outline: medium none;
	padding: 0;
	resize: none;
}

</style>
<div id="logout_wrapper" style="display: none; position:absolute;">
	<div class="arrow_top">
		<?php  echo $this->Html->image('icons/yellow_arrow.png');?>
	</div>

	<div>
		<div class="top_header">
			<?php $firstname = $this->Session->read('first_name');
			if(!empty($firstname)) {
				$roleId = $this->Session->read('roleid');
				$userName = $this->Session->read('username');
				$roleTyp = $this->Session->read('role');
				$location_name = $this->Session->read('location_name');
				// if($roleId == 2 && $userName != 'admin'){
				//echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in as Doctor in ".ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location'))." | ";
				//}else{
				if(strtolower($roleTyp) == strtolower(Configure::read('doctorLabel'))){
					echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in as ".strtoupper($this->Session->read('department'))." in ".ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location'))."";?>
			</br> </br>
			<?php }else{
				echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))." logged in as ".strtoupper($this->Session->read('role'))." in ".ucfirst($this->Session->read('facility'))." at ".ucfirst($this->Session->read('location'))."";?>
			</br> </br>
			<?php 	}
			//}
	}?>
			<?php 
			/* $this->WorldTime->setTimeZone(0);
			 if ($this->WorldTime->query()) {
    	echo date("M d Y, H:i:s", $this->WorldTime->getResult())."&nbsp;"."(".$this->WorldTime->getHost().")"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}*/
			//echo $this->Session->read('last_login');exit;
			echo  __('Last Account Activity :');
			$datediff = $this->DateFormat->dateDiff($this->Session->read('last_login'), date("Y-m-d H:i:s"));
			if($datediff->days > 0)
				echo $datediff->days." days ";
			if($datediff->h > 0)
				echo $datediff->h." hrs ";
			if($datediff->i > 0)
				echo $datediff->i." min ";
			else
				echo "0 min ";
			//if($datediff->s > 0)
			// echo $datediff->s." sec ";
			?>
		</div>
		<div class="acc_privacy_sec">
			<div class="top_sec">
				<b> <?php 
				echo $this->Session->read('initial_name')."&nbsp;".ucfirst($firstname)."&nbsp;".ucfirst($this->Session->read('last_name'))?>
				</b></br>
				<?php echo $this->Session->read('email')?>
				</br>
				<?php echo $this->Session->read('plot_no')?>
				</br>
				<?php echo $this->Session->read('local_no');?>
				</br>

				<?php $id=$this->Session->read('userid');?>

			</div>
			<?php if($roleTyp != 'Patient'){?>
			<div class="bottom_sec">
				<span style="float: left;"> <?php echo $this->Html->link('Account',array('controller' => 'users', 'action' => 'admin_edit',$id,'prefix'=>'admin','admin'=>true));?>
				</span>
				<?php $realRole = ($this->Session->read('realRole')) ? $this->Session->read('realRole') : $roleTyp?>
				<?php /*if($realRole == configure::read('doctorLabel') || $realRole == configure::read('nurseLabel') || $realRole == configure::read('frontOfficeLabel')){
					if($realRole == configure::read('doctorLabel'))
						$roleAry = array(configure::read('doctorLabel')=>configure::read('doctorLabel'),
								configure::read('residentLabel')=>configure::read('residentLabel'),
								configure::read('nurseLabel')=>configure::read('nurseLabel'),
								configure::read('frontOfficeLabel')=>configure::read('frontOfficeLabel')
						);
					if($realRole == configure::read('nurseLabel') || $realRole == configure::read('frontOfficeLabel'))
						$roleAry = array(configure::read('frontOfficeLabel')=>configure::read('frontOfficeLabel'),
								configure::read('nurseLabel')=>configure::read('nurseLabel'));?>
				<?php }*/  ?>
				
				<?php if(strtolower($roleTyp) != strtolower(Configure::read('superAdminLabel')) && $this->Session->read('website.instance')!='vadodara'){
			      if($this->Session->read('accessableRoles') && count($this->Session->read('accessableRoles')) != 1){?>
				<label style="padding-top: 0; color: #31859C !important;"><?php echo "Select Role";?>
				</label> <span> <?php echo $this->Form->input('roles',array('default'=>$this->Session->read('role'),'options'=>$this->Session->read('accessableRoles'),//$roleAry,
							'id'=>'changeUserRole','label'=>false,'div'=>false,'style'=>'width: 40%;')); ?>
				</span>
				<?php }?>
					
				<div style="float: left; margin:5px 0px 0px 47px;">
				<label style="padding-top: 0; color: #31859C !important;"><?php echo "Select Location";?>
				</label> <span> <?php echo $this->Form->input('locations',array('default'=>$this->Session->read('location_name'),'options'=>$this->Session->read('accessableLocation'),//$locationArray,
							'id'=>'changeUserLocation','label'=>false,'div'=>false,'style'=>'width: 49%;')); ?>
							</span>
					</div> 		
				<?php }?>
				<!--  <li><a href="#">Privacy</a></li> -->
			</div>
			<?php }?>
			
		</div>
		<div id="main_footer">
			<div class="footer">
				<div class="abb_btn">
					<?php  echo $this->Html->link(__('Change Password', true), array('controller' => 'users', 'action' => 'change_password', 'admin'=>false, 'plugin'=>false ,'class'=>'abb_btn','type'=>'button'),array('style'=>"text-decoration:none"));?>
				</div>
				<div class="abb_btn">
					<?php  echo $this->Html->link(__('Sign Out', true), array('controller' => 'users', 'action' => 'logout', 'admin'=>false, 'plugin'=>false ,'class'=>'abb_btn','type'=>'button'),array('style'=>"text-decoration:none"));?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#changeUserRole').change(function(){
		var realRole = '<?php echo $roleTyp; ?>';
		var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "app", "action" => "changeUserRole","admin" => false)); ?>";
		 $.ajax({
          url: ajaxUrl +"/"+ $(this).val() +'/'+ realRole,
          dataType: 'html',
          success: function(data){ 
              window.location.href = "<?php echo $this->Html->url(array("controller" => "Landings", "action" => "index", "admin" => false));?>";
        	}

	     });
		});

	$('#changeUserLocation').change(function(){
		var locationName = '<?php echo $location_name; ?>';
		var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "app", "action" => "changeUserLocation","admin" => false)); ?>";
		 $.ajax({
          url: ajaxUrl +"/"+ $(this).val() +'/'+ locationName,
          dataType: 'html',
          success: function(data){ 
              window.location.href = "<?php echo $this->Html->url(array("controller" => "Landings", "action" => "index", "admin" => false));?>";
        	}

	     });
		});
</script>
