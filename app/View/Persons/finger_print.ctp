<style type="text/css">
iframe {
  border-top: #ccc 1px solid;
  border-right: #ccc 1px solid;
  border-left: #ccc 1px solid;
  border-bottom: #ccc 1px solid;
} 
</style>
<div class="inner_title">
<h3><?php echo __('Biometric Identification', true); ?></h3>
</div>


<form name="fingerprint" id="fingerprint" action="<?php echo $this->Html->url(array("controller" => "persons", "action" => "finger_print")); ?>" method="post" >
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="47%"  align="center">
	<tr>
	<td colspan="2" align="center">
	<br>
	</td>
	</tr>
	<?php if(!empty($someData['Person']['patient_uid'])){?>
	<tr>
		<td width="23%" class="form_lables">
		<?php echo __('Patient ID'); ?>
		</td>
		<td width="44%">
	        <?php 
	       
			 echo $this->Form->input('Person.patient_uid', array('class' => 'textBoxExpnd ','type'=>'text',  'id' => 'p_id', 'label'=> false, 'div' => false,'value'=>$someData['Person']['patient_uid'] ));
			
	        ?>
		</td>
		
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('Patient Name'); 
	
	?>
	</td>
	<td id="name">
        <?php 
       
        echo $this->Form->input('Person.full_name', array('type'=>'text','class' => ' textBoxExpnd', 'id' => 'name', 'label'=> false, 'div' => false,'value'=>$someData['Person']['full_name']));
        ?>
	</td>
	</tr>
	<?php }?>
		<tr>
		
			<td valign="bottom" align="left" colspan="2">
			
			
			<applet CODEBASE="<?php echo Router::url('/')?>files/FDxSDKProforJavav1.3rev386"
  code     = "applet.JSGDApplet.class"
  name     = "JSGDApplet"
  archive  = "AppletDemo.jar"
  width    = "550"
  height   = "550"
  hspace   = "0"
  vspace   = "0"
  align    = "middle">

<PARAM name="codebase_lookup" value="false">
</applet>
			</td>
		</tr>

		<tr>
	<td colspan="2" align="center" style="padding-top: 10px;padding-left: 12%">
	<?php 
	if(!empty($someData['Person']['patient_uid']))
		   echo $this->Html->link(__('Done', true),array('controller'=>'appointments','action' => 'appointments_management'), array('escape' => false,'class'=>'blueBtn'));
	else
		echo $this->Html->link(__('Done', true),array('controller'=>'persons','action' => 'searchPatient'), array('escape' => false,'class'=>'blueBtn'));
	?>
	
	</td>
	</tr>
	</table>
</form>