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
		<?php echo __('Region Wise Patient List', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div> 
<?php }else{ ?>
	<table>
		<tr>
			<th colspan="8">
			
				<?php echo __('Region Wise Patient List', true); ?>
		
			</th>
		</tr>
	</table>
<?php } ?>
<?php echo $this->Form->create('Patient',array('type'=>'get','id'=>'Patient','url'=>array('controller'=>'Reports','action'=>'getRegionWisePatientList','admin'=>false),));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<?php if($type != 'excel') { ?>
		<table align="center" style="margin-top: 10px">
			<tr>
				<td><?php echo $this->Form->input('Patient.from_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from_date','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Select Date','value'=>$this->params->query['from_date']));?></td>
				<td><?php echo $this->Form->input('Patient.to_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to_date','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Select Date','value'=>$this->params->query['to_date']));?></td>

				<td><?php echo $this->Form->input('Patient.city', array('class'=>'textBoxExpnd','style'=>'width:150px','id'=>'city','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Search By City','value'=>$this->params->query['city']));?></td>

				<td><?php echo $this->Form->input('Patient.state_name', array('class'=>'textBoxExpnd','style'=>'width:150px','id'=>'state_name','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Search By State','value'=>$this->params->query['state_name']));
						  echo $this->Form->hidden('Patient.state_id',array('id'=>'state_id','value'=>$this->params->query['state_id']))
			?></td>

			<td><?php echo $this->Form->input('Patient.admission_type', array('type'=>'select','empty'=>'All','options'=>array('IPD'=>'IPD','OPD'=>'OPD'),'class'=>'textBoxExpnd','style'=>'width:150px','id'=>'admission_type','label'=> false, 'div' => false, 'error' => false,'value'=>$this->params->query['admission_type']));
			?></td>

			<td><?php echo $this->Form->input('Patient.doctor_id', array('type'=>'select','empty'=>'Please Select','options'=>$doctorList,'class'=>'textBoxExpnd','style'=>'width:150px','id'=>'doctor_id','label'=> false, 'div' => false, 'error' => false,'value'=>$this->params->query['doctor_id']));
			?></td>

				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'getRegionWisePatientList'),array('escape'=>false));?></td>
				
				<?php if($this->params->query){
						$qryStr=$this->params->query;
						}?>
				
				<td><?php echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>'Reports','action'=>'getRegionWisePatientList','excel','?'=>$qryStr,'admin'=>false,'alt'=>'Export To Excel'),array('escape'=>false,'title' => 'Export To Excel'))?><?php echo $this->Form->end();?></td>
			</tr>
		</table>
		<?php $border = '0' ;  }else{  $border = '1' ; }?>
		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="<?php echo $border ;  ?>" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="2%" align="center" valign="top"><?php echo __('Sr.No');?></th> 
						<th width="20%" align="center" valign="top"><?php echo __('Patient Name');?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Patient ID');?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Age/Gender');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Mobile');?></th> 
						<th width="20%" align="center" valign="top" style="text-align: center;"><?php echo __('Address');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('City');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('State');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Consultant');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Diagnosis');?></th> 
					</tr> 
				</thead>
				
				<tbody>
				<?php 
				$i = 1 ;
				foreach($regionData as $key=> $value) { 
						$age = explode(" ",$value['Person']['age']);
						if($value['Patient']['lookup_name'] == '') continue;
 					?>	
					<tr>
						<td><?php echo $i ; ?></td>
						<td><?php echo $value['Patient']['lookup_name'] ; ?></td>
						<td><?php echo $value['Patient']['patient_id'] ; ?></td>
						<td><?php echo $age[0]." / ".ucfirst($value['Person']['sex']) ; ?></td>
						<td><?php echo $value['Person']['mobile'] ; ?></td>
						<td><?php echo $value['Person']['plot_no'] ; ?></td>
						<td><?php echo ($value['Person']['city']) ? $value['Person']['city'] : $value['Person']['district'] ; ?></td>
						<td><?php echo $value['State']['name'] ; ?></td>
						<td><?php echo $value['User']['first_name']." ".$value['User']['last_name'] ; ?></td>
						<td><?php echo $value['Diagnosis']['final_diagnosis'] ; ?></td>
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

	$('#city').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","City","id&name",'null',"no","no","","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 setPlaceHolder : false,
		 select: function( event, ui ) {
		},
		 messages: {noResults: '',results: function() {}
		 }
	});

	$('#state_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","State","id&name",'null',"no","no","","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 setPlaceHolder : false,
		 select: function( event, ui ) {
		 	$('#state_id').val(ui.item.id) ;
		},
		 messages: {noResults: '',results: function() {}
		 }
	});

});
</script>
	