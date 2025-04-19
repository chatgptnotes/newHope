<?php echo $this->element('advance_header'); ?>
	
<!-- Body Part Template 
<div class="body_template">-->

<!-- Left Part Template  
<div class="left_template">-->

<!-- First Tab Department
<div class="tab_dept">-->
<?php
if($this->Session->read('role') != 'superadmin'){?>
<div id="slideIcon" style="display: inline"> 
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
	   ?>

	<?php
	/* if($patient['Patient']['id']!="" && $this->Session->read('role')!='Patient'){
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub.png', array('title' => 'Go to Patient Hub', 'alt'=> 'Go to Patient Hub','id'=>'patienthubicon','style'=>'padding-left:5px')),
				array('controller'=>'patients','action' => 'patient_information',$patient['Patient']['id'],'?'=>array('type'=>$patient['Patient']['admission_type'],'is_emergency'=>'0')),
				array('update' => '#list_content','method'=>'post','escape'=>false,
													'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
													'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
	echo $this->Html->image('/img/icons/arrow_1.png',array('id'=>'closeicon','style'=>'margin-left:160px;display:none;','title'=>'Hide','alt'=>'Hide'));
	} */

	?>
</div>

<?php }?>
<?php if($this->Session->read('role') != 'superadmin'){?>
<div style="float:right;display:inline">
<?php 
$defaultHosiptalMode = $this->Session->read('hospital_default_mode');
if(empty($defaultHosiptalMode))
	$defaultHosiptalMode = Configure::read('hospital_default_mode');
$firstLocationId = $this->Session->read('locationid');
$secondLocationId = $this->Session->read('second_location_id');
if(!empty($firstLocationId) && (!empty($secondLocationId)))
	//echo $this->Form->input('hospital_mode_selection', array('label'=>false,'value'=>$defaultHosiptalMode,'empty'=>__('Please Select'),'options'=>Configure::read('hospital_mode'),'class' => "textBoxExpnd",'id' => 'hospital_mode_selection'));
?>
</div>
<?php }?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="main-grid">
	<tr>

		<!-- Left Part Template -->
		<td height="550"  valign="top" class="left_template" id="slidePanel">
			<?php   
				$roleType = $this->Session->read('role');
				
				
			
				if($roleType == 'superadmin'){
					echo $this->element('left_navigation_superadmin');	
				}else{

			/*  $this->Navigation->getMenu(); */  /* commented by gulshan */
			 
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
			
			?>
			
		</td></tr>
				<tr>
		<?php if($patient['Patient']['id']!="" && $roleType!='Patient'){?>
		<td valign="top" class="left_template_patient" id="slidePanelPatient"
			align="center" style="display:none"><?php 

			echo $this->element('left_navigation_patient');
			//echo $this->element('left_navigation_note_list');
			?></td>
		<?php }else if((strtolower($this->request->params['controller']) == 'accounting1')){?>
		<td>
		<?php 
// 			echo $this->element('left_navigation_accounting');
		 ?>
</td>
		<?php } ?>
		
	 	<td valign="top"  class="rightTopBg">
	    	<?php 
				$flashMsg = $this->Session->flash() ;
				if(!empty($flashMsg)){ ?>
			<div>
				<?php echo $flashMsg ;?>
			</div> 
			<?php } ?>
	    	 <div align="center" id = 'busy-indicator'>	
				&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
			 </div>
			 <?php  echo $content_for_layout; ?>
	    </td>
    </tr>
</table>


</div>
<?php echo $this->element('preferences'); ?>
<!-- Body Part Template Ends here -->
<!-- element by swapnil for chat on 10.09.2015--> 
<?php echo $this->element('chat'); ?>
<?php echo $this->element('footer');
//echo $this->element('sql_dump'); ?>

<script>
$(document).ready(function (){
	timer ='' ; 
	setIntervalForSessionMsgHide();
	$("#flashMsgClose").click(function(){
		hideSessionMsg();//hide and clear timeing
	});
});

function setIntervalForSessionMsgHide(){ 
	//$("#flashMessage").append('<?php //echo $this->Html->image('/icons/cross.png',array("id"=>'flashMsgClose')); ?> ') ;
	window.setTimeout("hideSessionMsg()", (5000));
}

function hideSessionMsg(){  
	$("#flashMessage").fadeOut("slow");
	clearInterval(timer);
} 
</script>
	
