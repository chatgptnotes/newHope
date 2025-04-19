<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
		 background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 3px 8px;
	}
#msg {
    width: 180px;
    margin-left: 34%;
}
</style>
<?php if($type != 'excel') { ?>
<div class="inner_title">
	<h3>
		<?php echo __('IPD Corporate Report', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Dashboard'), array('controller'=>'Users','action' => 'doctor_dashboard','admin'=>false), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div> 
<?php }else{ ?>
	<table>
		<tr>
			<th colspan="8">
			
				<?php echo __('IPD Corporate Report', true); ?>
		
			</th>
		</tr>
	</table>
<?php } ?>
<?php echo $this->Form->create('Patient',array('type'=>'get','id'=>'Patient','url'=>array('controller'=>'Reports','action'=>'ipd_corporate_report','admin'=>false),));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<?php if($type != 'excel') { ?>
		<table align="center" style="margin-top: 10px">
			<tr>
				<td><?php echo $this->Form->input('Patient.from_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from_date','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Select Date','value'=>$this->params->query['from_date']));?></td>
				<td><?php echo $this->Form->input('Patient.to_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to_date','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Select Date','value'=>$this->params->query['to_date']));?></td>

				

			

			
				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'ipd_corporate_report'),array('escape'=>false));?></td>
				
				<?php if($this->params->query){
						$qryStr=$this->params->query;
						}?>
				
				<td><?php echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>'Reports','action'=>'ipd_corporate_report','excel','?'=>$qryStr,'admin'=>false,'alt'=>'Export To Excel'),array('escape'=>false,'title' => 'Export To Excel'))?><?php echo $this->Form->end();?></td>
			</tr>
		</table>
		<?php $border = '0' ;  }else{  $border = '1' ; }?>
		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="<?php echo $border ;  ?>" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="2%" align="center" valign="top"><?php echo __('Sr.No');?></th> 
						<th width="20%" align="center" valign="top"><?php echo __('Patient Name');?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Corporate');?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('DOA');?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('DOD');?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Bill Amount');?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Bill Submit Date');?></th> 
					</tr> 
				</thead>
				
				<tbody>
				<?php 
				$i = 1 ;
				foreach($record as $key=> $value) { 
						if($value['Patient']['lookup_name'] == '') continue;
						
 					?>	
					<tr>
						<td><?php echo $i ; ?></td>
						<td><?php echo $value['Patient']['lookup_name'] ; ?></td>
						<td><?php echo $value['TariffStandard']['name'] ; ?></td>
						<td><?php echo $this->DateFormat->formatdate2Local($value['Patient']['form_received_on'],Configure::read('date_format'),false); ?></td>
						<td><?php echo $this->DateFormat->formatdate2Local($value['Patient']['discharge_date'],Configure::read('date_format'),false); ?></td>
						<td><?php echo $value['total_amount'] ; ?></td>
						<td><?php echo $this->DateFormat->formatdate2Local($value['FinalBilling']['dr_claim_date'],Configure::read('date_format'),false); ?></td>
						
				  	</tr>
			  	<?php $i++; }?>
				</tbody>
		
			
			</table>
		</div>
	</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<script>

$(document).ready(function(){
	
	
 	$("#from_date").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});

	$("#to_date").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});

	

});
</script>
	