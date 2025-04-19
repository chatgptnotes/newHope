<?php /*echo $this->Html->script(array('inline_msg','permission','jquery.blockUI','jquery.fancybox'));
echo $this->Html->css(array('jquery.fancybox'));  
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');*/
 ?>
<style>
label {
	width: 126px;
	padding: 0px;
}

.ui-datepicker-trigger {
	padding: 0px 0 0 0;
	clear: right;
}

.tddate img {
	float: inherit;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Patient History Report', true);?>
	</h3> 
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Patient',array('id'=>'encounterForm','type'=>'get','default'=>false));?>
<table border="0" class=" " cellpadding="0" cellspacing="0" width="100%" align="center">
	<tbody>
		<tr class="row_title">
			<td class="tdLabel" id="boxSpace" align="right" width="12%"><?php echo __('Patient Name ') ?>:</td>
			<td class=" " width="20%"><?php 
				echo $this->Form->input('person_uid', array('id' => 'uid','label'=> false,'class'=>'validate[required,custom[mandatory-enter]]','div' => false,'error' => false,
					'autocomplete'=>false));?></td>
			<td class=" " align="center" width="10%"><?php echo $this->Form->submit(__('Search'),array('id'=>'search','class'=>'blueBtn','div'=>false,'label'=>false));?></td>
			<td class=" " align="center" width="10%"><?php 
				echo $this->Html->link($this->Html->image('icons/refresh-icon.png',array('style'=>'height:20px;width:18px;')),array('controller'=>'Billings','action'=>'billingReceiptReport'),
					array('id'=>'refresh','class'=>'refresh','escape' => false,'title'=>'Refresh')); ?></td>
			<td></td>
		</tr>
	</tbody>
</table>
<?php echo $this->Form->end();
$data = $this->Js->get('#encounterForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#encounterForm')->event(
		'submit',
		$this->Js->request(
				array('controller' => 'Billings', 'action' => 'patientEncounterList'),
				array(
						'update' => '#encounterList',
						'data' => $data,
						'async' => true,
						'dataExpression'=>true,
						'method' => 'Get'
				)
		)
);
echo $this->Js->writeBuffer();
?>
<div class="clr inner_title"  ">

	<div id="encounterList">
	
	</div>

</div>

<script>
$(document).ready(function(){ 
	
$('#search').click(function(){
	var validatePerson = jQuery("#encounterForm").validationEngine('validate'); 
 	if(!validatePerson){
	 	return false;
	}
});


$(document).on('focus','#uid', function() {
	ID=$(this).attr('id');
	 
	$(this).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "Billings", "action" => "allUIDAutocomplete","admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) { 
				 
				 
			 },
			 messages: {
			        noResults: '',
			        results: function() {},
			 }
		});
 });



});

</script>