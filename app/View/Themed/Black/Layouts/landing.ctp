<style>
.clear {
	clear: both;
}

</style>

<?php echo $this->element('landing_header'); ?>

<!-- Body Part Template 
<div class="body_template">-->

<!-- Left Part Template  
<div class="left_template">-->

<!-- First Tab Department
<div class="tab_dept">-->
<?php $roleType = $this->Session->read('role');

	if($roleType != 'superadmin'){?>
<div id="slideIcon" style="float: left; width: 200px; padding: 0px 0px 0px 13px;">
	<?php 
	/* if($patient['Patient']['id']=="")
	{
		echo $this->Html->image('/img/icons/home.png',array('id'=>'homeicon','title'=>'Home','alt'=>'Home'));
		echo $this->Html->image('/img/icons/home.png',array('id'=>'patienticon','style'=>'display:none;','title'=>'Patient Hub','alt'=>'Patient Hub'));
	}
	else
	{
		echo $this->Html->image('/img/icons/home.png',array('id'=>'patienticon','title'=>'Home','alt'=>'Home'));
		echo $this->Html->image('/img/icons/home.png',array('id'=>'homeicon','title'=>'Home','alt'=>'Home','style'=>'display:none;'));
	} */

	//Customize chart dashboard
	/* LIVE chat commented by Gulshan  */
/* 	echo $this->Html->link($this->Html->image('/img/icons/bar_image.png', array('title' => 'Go to chart dashboard','id'=>'dashboardicon','style'=>'padding-left:5px;padding-top:0px')),
			array('controller'=>'users','action' => 'chart_dashboard'),
			array('update' => '#list_content','method'=>'post','escape'=>false,
					'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
					'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)))); */

	if($patient['Patient']['id']!="" && $roleType!='Patient'){
	//	echo $this->Html->link($this->Html->image('/img/icons/patient_hub.png', array('title' => 'Go to Patient Hub', 'alt'=> 'Go to Patient Hub','id'=>'patienthubicon','style'=>'padding-left:5px')),
				//array('controller'=>'patients','action' => 'patient_information',$patient['Patient']['id'],'?'=>array('type'=>$patient['Patient']['admission_type'],'is_emergency'=>'0')),
				//array('update' => '#list_content','method'=>'post','escape'=>false,
					//	'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
					//	'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
		//cho $this->Html->link($this->Html->image('/img/icons/patient_hub/HPI.png'),"javascript:void(0)",array('onclick'=>'HpiFancy('.$patient['Patient']['id'].')','title' => 'HPI', 'alt'=> 'HPI','escape'=>false));

	 echo $this->Html->image('/img/icons/arrow_1.png',array('id'=>'closeicon','style'=>'margin-left:160px;display:none;','title'=>'Hide','alt'=>'Hide'));
	}





	?>

</div>
<?php }?>
<?php if($this->Session->read('role') != 'superadmin'){?>
<div style="float: right; display: inline">
	<?php 
	$defaultHosiptalMode = $this->Session->read('hospital_default_mode');
	if(empty($defaultHosiptalMode))
		$defaultHosiptalMode = Configure::read('hospital_default_mode');
	$firstLocationId = $this->Session->read('locationid');
	$secondLocationId = $this->Session->read('second_location_id');
	if(!empty($firstLocationId) && (!empty($secondLocationId)))
		echo $this->Form->input('hospital_mode_selection', array('label'=>false,'value'=>$defaultHosiptalMode,'empty'=>__('Please Select'),'options'=>Configure::read('hospital_mode'),'class' => "textBoxExpnd",'id' => 'hospital_mode_selection'));
	?>
</div>
<?php }?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	id="main-grid">
	<tr>
		<?php //debug($this->params['pass']['0'])?>
		<!-- Left Part Template -->
		<?php $roleType = $this->Session->read('role');
		if($roleType != 'superadmin'){
?>
		<td height="550" valign="top" class="left_template" id="slidePanel"><?php   
		$roleType = $this->Session->read('role');
			
		if($roleType == 'superadmin'){
					echo $this->element('left_navigation_superadmin');
				}else{
					 echo $this->element('left_navigation');
				}

				//if($roleType == 'Patient' || $roleType == 'Receptionist' || $roleType == 'Medical Assistant'){
/* LIVE chat commented by Gulshan  */
				/* echo '<div class="row_modules">';
				echo  '<a href="'.$this->Html->url(array("controller" => "Supports", "action" => "web_chat")).'">'.$this->Html->image('icons/webchat.png', array('alt' => 'Live Help')).'</a>';
				echo '<p style="margin:0px; padding:0px;">'.__('Live Help',true).'</p>';
				echo '</div>'; */
				//}
				$usertype=$this->Session->read('facilityu',$facility['Facility']['usertype']);
				//$role = $this->Session->read('role');echo $role;exit;
				if(($usertype=='hospital' || $usertype=='') && strtolower($roleType) !='patient'){
					//echo $this->element('quality_management_navigation');
				}
					
				?></td></tr>
				<tr>
		<?php if($patient['Patient']['id']!="" && $roleType!='Patient'){ ?>
		<td valign="top" class="left_template_patient" id="slidePanelPatient"
			align="center"  ><?php 
			
			 //exit;
			//Removed by pankaj
			 echo $this->element('left_navigation_patient');
			 //echo $this->element('left_navigation_note_list');
			?>
		</td>
		<?php }else if((strtolower($this->request->params['controller']) == 'accounting')){?>
		<td><?php 
	//	echo $this->element('left_navigation_accounting');
		 }?>
		</td>

		<?php }else{?>

		<td height="550" valign="top" class="left_template" id=""><?php   
		$roleType = $this->Session->read('role');
			
		if($roleType == 'superadmin'){
					echo $this->element('left_navigation_superadmin');
				}else{
					echo $this->element('left_navigation'); //common left navigation
				}

				if($roleType == 'Patient'){
					 echo '<div class="row_modules">';
					 echo  '<a href="'.$this->Html->url(array("controller" => "Supports", "action" => "web_chat")).'">'.$this->Html->image('icons/webchat.png', array('alt' => 'Live Help')).'</a>';
					 echo '<p style="margin:0px; padding:0px;">'.__('Live Help',true).'</p>';
					 echo '</div>';
				}
				$usertype=$this->Session->read('facilityu',$facility['Facility']['usertype']);
				//$role = $this->Session->read('role');echo $role;exit;
				if(($usertype=='hospital' || $usertype=='') && strtolower($roleType) !='patient'){
					//echo $this->element('quality_management_navigation');
				}
					
				?></td>
		<?php }?>

		</tr>
		<tr>
		<td valign="top" class="rightTopBg">
			<?php if($this->Session->flash()){ ?>
			<div style="padding-top: 60px;">
				<?php echo $this->Session->flash();?>
			</div> 
			<?php } ?>
			<div align="center" id='busy-indicator'>
				&nbsp;
				<?php echo $this->Html->image('indicator.gif', array()); ?>
			</div>
			<div style="min-height: 545px">
				<?php  echo $content_for_layout; ?>
			</div>
		</td>
	</tr>
</table>


<?php echo $this->element('preferences'); ?>
<div class="clear"></div>
<?php echo $this->element('footer'); ?>

<!-- Body Part Template Ends here -->

<script>
/*$.fn.preload = function() {
    this.each(function(){
        $('<img/>')[0].src = "/workspace/hope/theme/Black/img/icons/"+this;
    });
}*/

// Usage:
 
//$(['new_patient.png','new_patient.png','new_patient.png']).preload();
</script>


<script>
function HpiFancy(id){

			$.fancybox({
				'width' : '80%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':true,
				'href' : "<?php echo $this->Html->url(array("controller" => "PatientForms", "action" => "hpiCall")); ?>"+"/"+id
	
			});
}
$( "#hospital_mode_selection" ).change(function() {
	var mode = $("#hospital_mode_selection").val();
	$(location).attr('href',"<?php echo $this->Html->url(array("controller" => 'users', "action" => "changeHospitalMode","admin" => false)); ?>/"+mode);
});		
</script>
