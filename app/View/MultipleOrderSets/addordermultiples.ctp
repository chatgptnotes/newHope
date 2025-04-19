<?php 
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3'));
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css','internal_style.css'));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull">
	<tr>
		<th colspan="5"><?php echo __("Add Order Details") ; ?></th>
	</tr>
	<tr>
		<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo __("Find OrderSet");?>
		</td>

		<td width="10%" valign="middle" class="tdLabel" id="boxspace"><?php echo $this->Form->input('findrecords',
				 array('type'=>'text','label'=>false,'style'=>'width:250px','id' =>'finddata',true)); ?>
			<?php  echo $this->Form->hidden('patientid',
				 array('type'=>'text','value'=>$patient_id,'label'=>false,'style'=>'width:200px','id' =>'patientid',true)); ?>
		</td>
		<td width="19%" valign="middle" class="tdLabel" id="boxspace">
			<?php
			echo  $this->Js->link('<input type="button" value="Search" class="blueBtn">', array('controller'=>'patients', 'action'=>'addordermultiples', 'admin' => false),
 array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('hide', array('buffer' => false)),'update'=>'#resultorder', 'data' => '{finddata:$("#finddata").val(),patientid:$("#patientid").val()}','dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();
				?>
		</td>
	</tr>
</table>
<div align="center" id='busy-indicator' style="display: none;">
	&nbsp;
	<?php echo $this->Html->image('indicator.gif', array()); ?>
</div>
<div id="resultorder"></div>
<script>
	$(document).ready(function(){

		$("#finddata").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","OrdersetMaster","name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
	});
		
		</script>
