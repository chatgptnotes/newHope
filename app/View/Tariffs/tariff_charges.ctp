<?php 
function displayDays($chargeDays){
	if($chargeDays['monday']) $dayString[] = 'Monday';
	if($chargeDays['tuesday']) $dayString[] = 'Tuesday';
	if($chargeDays['wednesday']) $dayString[] = 'Wednesday';
	if($chargeDays['thursday']) $dayString[] = 'Thursday';
	if($chargeDays['friday']) $dayString[] = 'Friday';
	if($chargeDays['saturday']) $dayString[] = 'Saturday';
	if($chargeDays['sunday']) $dayString[] = 'Sunday';

	return implode(',',$dayString);
}

for($i = strtotime("00:00:00");$i <= strtotime("23:00:00"); $i =  strtotime('+60 minutes', $i)){
	$timeValues[date("H:i:s", $i)] =  date("h:i A", $i);
}
?>
<style>
select.textBoxExpnd,.textBoxExpnd {
	width: 50%;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __($tariffStandardsData['TariffStandard']['name'], true); ?>
	</h3>
	<span><?php  echo $this->Html->link('Back',array('action'=>'tariffListOptions',$tariffStandardsData['TariffStandard']['id']),array('escape'=>false,'class'=>'blueBtn')); ?>
	</span>
</div>
<?php
echo $this->Form->create('',array('url'=>array('action'=>'saveTariffCharges'), 'id'=>'servicefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));
?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" align="left">
	<tr>
		<td class="form_lables" align="right" valign="top"><?php echo __('Service Name'); ?><font
			color="red">*</font></td>
		<td><?php	echo $this->Form->input('service_name',array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'serviceName',
				'value'=>$tariffStandardsData['TariffList']['name'],'readOnly'=>true));
		echo $this->Form->hidden('TariffCharge.tariff_list_id', array('id' => 'tariffListId','value'=>$tariffStandardsData['TariffList']['id']));
		echo $this->Form->hidden('TariffCharge.tariff_standard_id',array('value'=>$tariffStandardsData['TariffStandard']['id']));
		echo $this->Form->hidden('TariffCharge.tariff_amount_id',array('value'=>$tariffStandardsData['TariffAmount']['id']));
		echo $this->Form->hidden('TariffCharge.id',array('id'=>'tariffChargeId'));
		?>
		</td>
	</tr>
	<tr>
		<td class="form_lables" align="right" valign="top">Doctor Name<font color="red">*</font></td>
		<td><?php	echo $this->Form->input('TariffCharge.doctor_id',array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd',
				'id'=>'doctorId','empty'=>'Please Select','options'=>$doctorList)); ?>
		</td>
	</tr>

	<tr id="weekdaysrow">
		<td class="form_lables" align="right" valign="top"><?php echo $this->Form->input('Tariff.daySelected',array('id'=>'selectedDay',
				'value'=>$this->data['TariffCharge']['id'],'class'=>'validate[required,custom[mandatory-select]]',"style"=>"visibility: hidden;"));?>
		<?php echo __('Week Days'); ?><font
			color="red">*</font></td>
		<td>
			<table>
				<tr>
					<td><?php echo $this->Form->input('TariffCharge.sunday',array('type'=>'checkbox','class'=>'daySelect'));?>SUNDAY
					
					</td>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('TariffCharge.monday',array('type'=>'checkbox','class'=>'daySelect'));?>MONDAY</td>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('TariffCharge.tuesday',array('type'=>'checkbox','class'=>'daySelect'));?>TUESDAY</td>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('TariffCharge.wednesday',array('type'=>'checkbox','class'=>'daySelect'));?>WEDNESDAY</td>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('TariffCharge.thursday',array('type'=>'checkbox','class'=>'daySelect'));?>THUSDAY</td>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('TariffCharge.friday',array('type'=>'checkbox','class'=>'daySelect'));?>FRIDAY</td>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('TariffCharge.saturday',array('type'=>'checkbox','class'=>'daySelect'));?>SATURDAY</td>
				</tr>

			</table>
		</td>
	</tr>
	<tr>
		<td class="form_lables" align="right" valign="top"><?php echo __('Time'); ?><font
			color="red">*</font></td>
		<td><?php	echo $this->Form->input('TariffCharge.start',array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'start',
				'empty'=>'Please Select','options'=>$timeValues)); ?>
		</td>
		<td><?php	echo $this->Form->input('TariffCharge.end',array('class'=>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'end',
				'empty'=>'Please Select','options'=>$timeValues)); ?>
		</td>
	</tr>
	<tr>
		<td class="form_lables" align="right" valign="top">Validity<font color="red">*</font></td>
		<td><?php	echo $this->Form->input('TariffCharge.unit_days',array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd',
				'id'=>'unitDays','type'=>'text')); ?>
		</td>
	</tr>
	<tr>
		<?php  $nabhType=$this->Session->read('hospitaltype');?>
		<td class="form_lables" align="right" valign="top"><?php echo ($nabhType=='NABH') ? 'NABH Charges' : 'NON-NABH Charges'; ?><font
			color="red">*</font>
		</td>
		<?php if($nabhType=='NABH'){?>
		<td><input type="text"
			name="<?php echo "data[TariffCharge][nabh_charges]";?>"
			value="<?php echo $this->Number->format($this->data['TariffCharge']['nabh_charges'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>">
		</td>
		<?php }else{ ?>
		<td><input type="text"
			name="<?php echo "data[TariffCharge][non_nabh_charges]";?>"
			value="<?php echo $this->Number->format($this->data['TariffCharge']['non_nabh_charges'],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));?>">
		</td>
		<?php }?>
	</tr>

	<tr>
		<td align="right" colspan="2"><?php echo $this->Form->submit('Submit',array('id'=>'submit','class'=>'blueBtn'));?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<?php if(!empty($tariffChargeData)){?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">
	<tr>
		<th width="25%"><?php echo $tariffStandardsData['TariffList']['name'];?>
			on Days</th>
		<th width="25%" style="text-align: center;">Doctor Name</th>
		<?php 
		$nabhType=$this->Session->read('hospitaltype');
                            if($nabhType=='NABH'){?>
		<th width="15%" style="text-align: center;">NABH Charges</th>
		<?php }else{?>
		<th width="15%" style="text-align: center;">Non NABH Charges</th>
		<?php }?>
		<th width="25%" style="text-align: center;">Validity</th>
		<th width="15%" style="text-align: center;">Action</th>
	</tr>
	<?php  

 foreach($tariffChargeData as $tariff){ ?>
	<tr>
		<td><?php echo displayDays($tariff['TariffCharge'])." (".date("h:i A", strtotime($tariff['TariffCharge']['start']))." - ".date("h:i A", strtotime($tariff['TariffCharge']['end'])).")";?>
		</td>
		<?php $validatyDays[$tariff['TariffCharge']['doctor_id']] = $tariff['TariffCharge']['unit_days'];?>
		<td align="center"><?php echo $doctorList[$tariff['TariffCharge']['doctor_id']];?>
		</td>
		<?php if($nabhType=='NABH'){?>
		<td align="center"><?php echo $tariff['TariffCharge']['nabh_charges'];?>
		</td>
		<?php }else{ ?>
		<td align="center"><?php echo $tariff['TariffCharge']['non_nabh_charges'];?>
		</td>
		<?php }?>
		<td align="center"><?php echo $tariff['TariffCharge']['unit_days'];?>
		</td>
		<?php $tariffStandardId = $tariff['TariffCharge']['tariff_standard_id'];
		$tariffListId = $tariff['TariffCharge']['tariff_list_id'];
			  $tariffChargeId = $tariff['TariffCharge']['id'];?>
		<td align="center"><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'tariffCharges',$tariffStandardId,$tariffListId,$tariffChargeId), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));?>
		<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'),array('action' => 'deleteTariffCharges',$tariffChargeId,$tariffStandardId,$tariffListId), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)),__('Are you sure?', true));?>
		</td>
	</tr>
	<?php }?>
	<tr>
		<TD colspan="5" align="center" class="table_format"><?php 
		//$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		//$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
		echo $this->Paginator->counter(array('class' => 'paginator_links'));
		echo $this->Paginator->prev(__('« Previous', true), array(/*'update'=>'#doctemp_content',*/
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

			<?php 
			echo $this->Paginator->numbers(); ?> <?php echo $this->Paginator->next(__('Next »', true), array(/*'update'=>'#doctemp_content',*/
							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

			<span class="paginator_links"> </span>
		</TD>
	</tr>
</table>
<div>&nbsp;</div>
<?php }?>

<script>
$(function (){
	jQuery("#servicefrm").validationEngine();		
});
$('#serviceName1').autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","TariffList","id&name",'null',"null","null","admin" => false,"plugin"=>false)); ?>",
	 minLength: 1,
	 select: function( event, ui ) {
		$('#tariffListId').val(ui.item.id);
		
	 },
	 messages: {noResults: '',results: function() {}
	 }
});
var timeoutReference = '';
var test = 0;
$('.daySelect').click(function(){
	$('#selectedDay').val('');
	$('.daySelect').each(function(){
		if($(this).is(":checked"))$('#selectedDay').val('selected');
		});
	test++;
	clearTimeout(timeoutReference);
	timeoutReference = setTimeout( function(){
		if(test > 0){
	    	test = 0;
	    	//retainValuesCreateTimeSlot($('#tariffListId').val());
		}
	  }, 3000);
	
});

var validDays = '<?php echo json_encode($validatyDays);?>';
$('#doctorId').change(function(){
	validDays = jQuery.parseJSON(validDays);
	var docId = $( "#doctorId option:selected" ).val(); 
	$('#unitDays').val(validDays[docId]);
});
</script>
