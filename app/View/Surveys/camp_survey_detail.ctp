<style>
.camp{
	width:700px;
    background: #ffffd0 !important;
    padding: 10px; 
    margin-top:10px; 
    border:solid 1px #DFDB2C ;
}
.camp td {
	background:none !important;
}

.headTr{
	background:#dfdb2c;
}

</style>
<div class="inner_title">
	<h3>Camp Details</h3>
	<span><?php if($camp['0']['CampDetail']['id']){
				$url=$this->Html->url(array('controller'=>'Surveys','action'=>'camp_survey_detail',$camp['0']['CampDetail']['id'],
											'?'=>array('print'=>'print')));
				echo $this->Html->link('Print','#',
											   array('id'=>'print','class'=>'blueBtn','escape'=>false,'onclick'=>
									   "var openWin = window.open('".$url."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"
));	
				echo $this->Html->link('Add Camp Participants Details',array('action'=>'add_camp_participant',$camp['0']['CampDetail']['id']),array('escape'=>false,'class'=>'blueBtn'));}?></span>
</div>
<?php echo $this->Form->create('camp',array('id'=>'camp'));
$camp=$camp['0']['CampDetail'];?>
<table class="camp" cellspacing=0 cellpadding=1>
	<tr class="headTr">
		<th colspan="4">Camp Details Particulars</th>
	</tr>
	<tr>
		<td>Camp Name:</td>
		<td>
			<?php echo $this->Form->input('camp_name',array('name'=>'camp_name','class'=>'validate[required,custom[mandatory-enter]]',
															'div'=>false,'label'=>false,'value'=>$camp['camp_name']));?>
		</td>
		<td>Camp Date:</td>
		<td>
			<?php echo $this->Form->input('camp_date',array('name'=>'camp_date','class'=>'validate[required,custom[mandatory-enter]] date',
															'div'=>false,'label'=>false,'style'=>'float:left',
															'value'=>$this->DateFormat->formatDate2Local($camp['camp_date'],Configure::read('date_format'),false)));?>
		</td>
	</tr>
	<tr>
		<td>Nature of Camp:</td>
		<td>
			<?php echo $this->Form->input('camp_nature',array('name'=>'camp_nature','class'=>'',
															'div'=>false,'label'=>false,'value'=>$camp['camp_nature']));?>
		</td>
		<td>Camp Venue:</td>
		<td>
			<?php echo $this->Form->input('camp_venue',array('name'=>'camp_venue','class'=>'validate[required,custom[mandatory-enter]]',
															'div'=>false,'label'=>false,'value'=>$camp['camp_venue']));?>
		</td>
	</tr>
	<tr>
		<td>Camp days:</td>
		<td>
			<?php echo $this->Form->input('camp_days',array('name'=>'camp_days','class'=>'','value'=>$camp['camp_days'],
															'div'=>false,'label'=>false));?>
		</td>
		<td colspan="2">&nbsp</td>		
	</tr>
	<tr>
		<td colspan="4" style="color: grey;">(NOTE:Enter name seperated by commas ',')</td>
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" cellspacing="0">
				<tr class="headTr">
					<th>Name of Doctors</th><th>Name of Nursing Staffs</th>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('doctors_name',array('name'=>'doctors_name','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['doctors_name']))?></td>
					<td><?php echo $this->Form->input('nursing_staff_name',array('name'=>'nursing_staff_name','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['nursing_staff_name']))?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" cellspacing="0">
				<tr class="headTr" >
					<th>Pharmacy Staff</th><th>Pathalogy Staff</th>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('pharmacy_staff',array('name'=>'pharmacy_staff','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['pharmacy_staff']))?></td>
					<td><?php echo $this->Form->input('pathalogy_staff',array('name'=>'pathalogy_staff','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['pathalogy_staff']))?></td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" cellspacing="0">
				<tr class="headTr">
					<th>Other Staff</th><th>Organizers</th>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('other_staff',array('name'=>'other_staff','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['other_staff']))?></td>
					<td><?php echo $this->Form->input('organizers_name',array('name'=>'organizers_name','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['organizers_name']))?></td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="4">
			<table width="100%" cellspacing="0">
				<tr class="headTr">
					<th>Drivers Name</th><th>Vehicle Name/No</th>
				</tr>
				<tr>
					<td><?php echo $this->Form->input('driver_name',array('name'=>'driver_name','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['driver_name']))?></td>
				    <td><?php echo $this->Form->input('vehicle_name_no',array('name'=>'vehicle_name_no','label'=>false,'div'=>false,
																		'type'=>'textarea','rows'=>'5','cols'=>'25','value'=>$camp['vehicle_name_no']))?></td>
				</tr>
			</table>
		</td>		
	</tr>
	<tr>
		<td colspan="4">
			<?php $compile=unserialize($camp['compilation']);?>
			<table width="100%" cellspacing="0" id="compile">
				<tr class="headTr">
					<th colspan="3">Compilation</th>
				</tr>
				<tr>
					<th>Label</th>
					<th>Value</th>
					<th>&nbsp;</th>
				</tr>
				<?php if($compile){ $j=1;
						foreach($compile['label'] as $cKey=>$comData){?>
								<tr id="<?php echo "row_$j"?>">
									<td><?php echo $this->Form->input('',array('name'=>'Compile[label][]','label'=>false,'div'=>false,
																				'value'=>$comData,
																				'type'=>'text','id'=>"label_$j"))?></td>
								    <td><?php echo $this->Form->input('',array('name'=>'Compile[value][]','label'=>false,'div'=>false,
								    										   'value'=>$compile['value'][$cKey],
																			   'type'=>'text','id'=>"cvalue_$j"))?></td>
									<?php if($j>1){?>
											<td><?php echo $this->Html->image('icons/cross.png',array('class'=>'removeCompile',
															'title'=>"Remove current row",'id'=>"removeCompile_$j",'style'=>"float: left;" ))?>
											</td>
									<?php }else{?>
											<td>&nbsp;</td>
									<?php }?>
								</tr>
				<?php 		$j++;
						}
						$i=$j;
					  }else{ $i=2;	?>
				<tr>
					<td><?php echo $this->Form->input('',array('name'=>'Compile[label][]','label'=>false,'div'=>false,
																		'type'=>'text','id'=>'label_1'))?></td>
				    <td><?php echo $this->Form->input('',array('name'=>'Compile[value][]','label'=>false,'div'=>false,
																		'type'=>'text','id'=>'cvalue_1'))?></td>
					<td>&nbsp;</td>
				</tr>
				<?php }?>
			</table>
		</td>		
	</tr>
	<tr><td colspan="4" style="padding: 10px 0px 10px 0px"><?php echo $this->Html->link('Add More Compilation','javascript:void(0)',
			array('escape'=>false,'class'=>'blueBtn','id'=>'addCompile'))?></td></tr>

</table>
<div style="text-align: center;width:700px;padding-top:10px"><?php echo $this->Form->button('Submit',
		array('type'=>'Submit','div'=>false,'label'=>false,'class'=>'blueBtn'));?></div>
<?php $this->Form->end();?>
<script>
$(document).ready(function(){
	$('#camp').validationEngine();
	$(".date").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		//minDate: 0,
		dateFormat: '<?php echo $this->General->GeneralDate();?>',		
	});	
});
$(document).on('click','#addCompile', function() { 
	addCompileHtml();
});
var count="<?php echo $i;?>";
function addCompileHtml(){
	$("#compile")
			.append($('<tr>').attr({'id':'row_'+count,'class':'addRows'})
				.append($('<td>').append($('<input>').attr({'id':'label_'+count/*,'class':'validate[required,custom[mandatory-enter]] name '*/,'type':'text','name':'data[Compile][label][]','autocomplete':'off'})))
				.append($('<td>').append($('<input>').attr({'id':'cvalue_'+count,'autocomplete':'off','type':'text','name':'data[Compile][value][]'})))
				.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
				                 .attr({'class':'removeCompile','id':'removeCompile_'+count,'title':'Remove current row'}).css('float','left')))
				);
	count++;
};

$(document).on('click','.removeCompile', function() {
	currentId=$(this).attr('id');
	splitedId=currentId.split('_');
	ID=splitedId['1'];
	$("#row_"+ID).remove();		
});
</script>