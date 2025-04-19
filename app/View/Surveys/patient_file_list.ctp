<style>
.tabularForm td{
	background: none !important;
}

 .tabularForm tr:nth-child(even) {background: #E2EDF7 !important}
 .tabularForm tr:nth-child(odd) {background: #c2cfdc !important}
 
 .content{
 		max-height: 500px;
 		overflow: scroll;
 		width: 700px;
 	}

</style>
<div class="inner_title">
	<h3>Patient File Number List</h3>
</div>
<?php echo $this->Form->create('file_list',array('id'=>'file_list'));?>
	<table>
		<tr>
			<td>Patient Name</td>
			<td><?php echo $this->Form->input('patient_name',array('id'=>'patient_name','div'=>false,'label'=>false));
					  echo $this->Form->hidden('patient_id',array('id'=>'patient_id','div'=>false,'label'=>false));?></td>
			<td>Date From</td><td><?php echo $this->Form->input('date_from',array('id'=>'from','div'=>false,'label'=>false,
												'style'=>'float:left'));?></td>
			<td>Date To</td><td><?php echo $this->Form->input('date_to',array('id'=>'to','div'=>false,'label'=>false,
												'style'=>'float:left'));?></td>
			<td><?php echo $this->Form->button('Search',array('id'=>'search','class'=>'blueBtn','div'=>false,'label'=>false));?></td>
		</tr>
	</table>
<?php echo $this->Form->end();?>
<div class="content">
	<table class="tabularForm" width="100%">
		<tr>
			<th>Patient UID</th>
			<th>Patient Name</th>
			<th>Admission Date</th>
			<th>Patient File no</th>
		</tr>
		<?php if($list){
			  foreach($list as $patient){ ?>
					<tr>
						<td><?php echo $patient['Patient']['patient_id'];?></td>
						<td><?php echo $patient['Patient']['lookup_name'];?></td>
						<td><?php echo $this->DateFormat->formatDate2Local($patient['Patient']['form_received_on'],Configure::read('date_format'),false);?></td>
						<td><?php echo $this->Form->input('file_no',array('type'=>'text','value'=>$patient['Patient']['file_number'],
										'id'=>"number_".$patient['Patient']['id'],'class'=>'file_number','label'=>false,'div'=>false));?></td>
					</tr>
		<?php }}else{?>
					<tr><td align="center" colspan="4">No records found.</td></tr>
		<?php }?>
	</table>
</div>

<script>
$(document).ready(function (){
	$("#from, #to").datepicker({
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
$("#patient_name").autocomplete({
    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","IPD",'',"admin" => false,"plugin"=>false)); ?>", 
	select: function(event,ui){
		$( "#patient_id" ).val(ui.item.id);		
	},
	 messages: {
	     noResults: '',
	     results: function() {},
	}
});

$('.file_number').blur(function(){
	var id=$(this).attr('id');
	var patId=id.split('_')['1'];
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Surveys","action" => "saveFileNumber")); ?>/"+patId;
	var fileNumber=$(this).val();
	if(fileNumber){
	     $.ajax({
	     	beforeSend : function() {
	         	//loading("outerDiv","class");
	     		$("#busy-indicator").show();
	       	},
	     type: 'POST',
	     data : "file_number="+fileNumber,
	     url: ajaxUrl,
	     dataType: 'html',
	     success: function(data){
	     	//onCompleteRequest("outerDiv","class");
	     	//inlineMsg(id," File Number Saved!",3,'message');
	     	$("#busy-indicator").hide();	     	
	     },
		});
	 }
});


</script>