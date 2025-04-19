
<style>
.drop {
	border: 0.1em solid #808000;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Account Payable', true); ?>
	</h3>
</div>
<?php echo $this->Form->create('Consultant_Account_Payable',array('id'=>'consultant_account_Payable','url'=>array('controller'=>'Accounting','action'=>'consultant_account_payable',$user[0]['Consultant']['id'],'admin'=>false),));?>
<table align="center" style="margin-top: 10px">
<tr>
<td align="center"><strong><?php echo __('Account');?></strong>
</td><?php $name=$user[0]['Initial']['name'].$user[0]['Consultant']['first_name']." ".$user[0]['Consultant']['last_name'];?>
<td><?php echo $this->Form->input('JournalEntryConsultant.name',array('id'=>'name','label'=>false,'div'=>false,'value'=>$name))?>
<td><?php echo __('From');?></td><td><?php 
        echo $this->Form->input('JournalEntryConsultant.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
<td><?php echo __('To');?></td><td><?php 
        echo $this->Form->input('JournalEntryConsultant.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 'div' => false, 'error' => false));?>
		
	  </td>
	  <td><?php echo $this->Form->submit('Submit',array('class'=>'blueBtn','label'=> false, 'div' => false));
	  echo $this->Form->end();?></td>
</tr>

</table>

<table class="formFull" width="70%" align="center" cellspacing="0" style="margin-top: 20px">
<tr class="row_gray">
<td class="tdLabel"><?php echo __('Date');?></td>
<td class="tdLabel"><?php echo __('Ref.No');?></td>
<td class="tdLabel"><?php echo __('Party`s name');?></td>
<td class="tdLabel"><?php echo __('Pending Amount');?></td>
<td class="tdLabel"><?php echo __('Due On');?></td>
<td class="tdLabel"><?php echo __('overdue by days');?></td>
</tr>
<?php foreach($payable as $pay){?>
<tr>
<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($pay['JournalEntryConsultant']['date'],Configure::read('date_format'),false); ?></td>
<td class="tdLabel"></td>
<td class="tdLabel"><?php echo $name;?></td>
<td class="tdLabel" ><?php echo $currency.$pay['JournalEntryConsultant']['credit']?></td>
<td class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($pay['JournalEntryConsultant']['date'],Configure::read('date_format'),false);?></td>
<td class="tdLabel"></td>
</tr>
<?php $total=$total+$pay['JournalEntryConsultant']['credit']; }?>

</table>
<table align="right" style="margin-right: 350px" class="formFull" width="15%">
<tr>
<td colspan="4" align="right" ><?php echo __('Total   :');?></td>
<td class="tdLabel">&nbsp;<?php echo $currency.$total;?></td>
</tr>
</table>
<script>
$(function() {
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	
		
 $("#to").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});
});	
$( "#account_Payable" ).click(function(){
	   var fromdate = new Date($( '#from' ).val());
     var todate = new Date($( '#to' ).val());
     if(fromdate.getTime() > todate.getTime()) {
     alert("To date should be greater than from date");
     return false;
    }
});
        
</script>
