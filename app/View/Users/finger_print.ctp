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

<?php //debug($this->params->query);?>
<form name="fingerprint" id="fingerprint" action="<?php echo $this->Html->url(array("controller" => "persons", "action" => "finger_print")); ?>" method="post" >
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="47%"  align="center">
	<tr>
	<td colspan="2" align="center">
	<br>
	</td>
	</tr>
	<tr>
		<td width="23%" class="form_lables">
		<?php echo __('User ID'); ?>
		</td>
		<td width="44%">
	        <?php 
	       
			 echo $this->Form->input('User.user_id', array('class' => 'textBoxExpnd ','type'=>'text',  'id' => 'p_id', 'label'=> false, 'div' => false,'value'=>$someData['User']['id']));
			
	        ?>
		</td>
		
	</tr>
	<tr>
	<td class="form_lables">
	<?php echo __('User Name'); 
	
	?>
	</td>
	<td id="name">
        <?php 
       
        echo $this->Form->input('User.full_name', array('type'=>'text','class' => ' textBoxExpnd', 'id' => 'name', 'label'=> false, 'div' => false,'value'=>$someData['User']['first_name']." ".$someData['User']['last_name']));
        ?>
	</td>
	</tr>
		<tr>
		
			<td valign="bottom" align="left" colspan="2">
			
			
			<applet CODEBASE="<?php echo Configure::read('appletUrl')?>/files/FDxSDKProforJavav1.3rev386"
  code     = "applet.JSGDApplet.class"
  name     = "JSGDApplet"
  archive  = "AppletDemo.jar,mysql-connector-java-5.1.6-bin.jar"
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
	
	if($this->params->query['newUser']=='ls'){
		echo $this->Html->link(__('Done', true),array('controller'=>'users','action' => 'index','admin'=>true,'?'=>array('newUser'=>'ls')), array('escape' => false,'class'=>'blueBtn'));
	}else{
		echo $this->Html->link(__('Done', true),array('controller'=>'users','action' => 'index','admin'=>true), array('escape' => false,'class'=>'blueBtn'));

	}
	?>&nbsp;&nbsp;<?php 
	 if($this->params->query['newUser']=='ls'){
		echo $this->Html->link(__('Done', true),array('controller'=>'users','action' => 'index','submitandregister' =>$this->request->params['named']['capturefingerprint'],'?'=>array('type'=>$this->request->query['type'],'newUser'=>'ls')), array('escape' => false,'class'=>'blueBtn'));
	}else{	
    	echo $this->Html->link(__('Done', true),array('controller'=>'users','action' => 'index','submitandregister' =>$this->request->params['named']['capturefingerprint'],'?'=>array('type'=>$this->request->query['type'])), array('escape' => false,'class'=>'blueBtn'));
	}?>
	</td>
	</tr>
	</table>
</form>