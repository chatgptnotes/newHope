<style>
.table_format td {
	padding-right: 0px !important;
}
img {
	text-align: center;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Patient refferal for counselling'); ?>
	</h3>
</div>
<?php /*?>
<div id="inner_menu" style="float:right; width:100%; padding-top:10px;">   
<?php echo $this->Form->create('Estimates', array('action'=>'residentDashboard','id'=>'residentfrm','type'=>'get','inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>             
	<div cellpadding="0" cellspacing="0" border="0"  align="left" style="float:left; width:100%; ">
		<div >

			<?php 
				echo __("Patient Name : ")."&nbsp;".$this->Form->input('lookup_name', array('id' => 'lookup_name', 'value'=>$this->params->query['lookup_name'],'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name'))."&nbsp;&nbsp;&nbsp;";
			?> 
		 <span>
	    	<?php 
	    		echo "Date From : "."&nbsp;".$this->Form->input('from', array('id'=>'from','value'=>$this->request->query['from'],'label'=> false, 'div' => false, 'error' => false)); 
	    	?>
	    </span>
	    <span>
	    	<?php 
	    		echo "To Date : "."&nbsp;".$this->Form->input('to', array('id'=>'to','value'=>$this->request->query['to'],'label'=> false, 'div' => false, 'error' => false));
	    	?>
	    </span>
	   	<span id="look_up_name" class="LookUpName">
			<?php 
				echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false))."&nbsp;";	?>
				
		</span>   
		 <span> <?php  echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'residentDashboard'),array('escape'=>false,'style'=>'float: right' , 'title' => 'refresh')); ?>
		 
		</div></span>
    </div>
    <?php echo $this->Form->end(); ?>
</div>	

	
<div style="text-align: right;" class="clr inner_title"></div>
<?php */?>

<?php if(isset($results) && !empty($results)){
	?>
<table border="0" width="100%" valign="top">
	<tr>
		<?php $r=0;
		foreach($results as $getData){

		$getDiffDate=date('Y-m-d',strtotime($getData['EstimateConsultantBilling']['surgery_date'].Configure::read('before_days_surgery')));	///before 2 days
		if(date('Y-m-d')==$getDiffDate){
			$surgeryDate1 = $this->DateFormat->formatDate2Local($getData['EstimateConsultantBilling']['surgery_date'],Configure::read('date_format'));
			?>
		<td style="color: rebeccapurple; font-size: 16px;" valign="top"
			colspan="2"><ul>
				<li><strong><i><?php echo $getData['Patient']['lookup_name']." is scheduled for surgery on ".$surgeryDate1.'.';?>
					</i> </strong></li>
			</ul>
		</td>
		<?php   $r++;		 
		if($r%2==0){
echo "</tr><tr>";?>
		<?php }?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php }		

	}?>
	</tr>
</table>

<?php }?>


<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	
	<tr class="row_title">
		</strong>
		</td>
		<td class="table_cell" align="left"><strong><?php echo __("Physician name");?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __("Patient name (Gender / Age)"); ?>
		</strong></td>
		
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('EstimateConsultantBilling.approved', __('Package status', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __("Package name ");?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __("Tentative admission date");?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __("Surgery date");?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __("Admit to hospital");?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo __("View estimate details");?>
		</strong></td>
	</tr>
	<?php 
		if(isset($results) && !empty($results)){ ?>
	<?php $rowCount = 1;?>
	<?php foreach($results as $key=>$patients){  ?>
	<?php if($rowCount %2 == 0){?>
	<tr class="row_gray">

		<?php }else{ ?>
	
	
	<tr>
		<?php }?>
		<td class="row_format" align="left"><?php echo $patients[0]['name']; ?>
		</td>
		<?php $patientId=$patients['Patient']['id'];?>
		<td class="row_format" align="left"><?php echo $patients['Patient']['lookup_name']." (".ucfirst(strtolower($patients['Person']['sex']))." / ".$this->General->getCurrentAge($patients['Person']['dob']).") ";
				echo $this->Form->hidden('EstimateConsultantBilling.patient_name',array('id'=>'patientname')); ?>
		</td>
		<td><?php  echo $status = ($patients['EstimateConsultantBilling']['approved']) ? 'Approved' : 'Inprocess'; ?>
		</td>
		<td><?php echo $patients['PackageEstimate']['name']?></td>
		<td><?php  echo $admissionDate = $this->DateFormat->formatDate2Local($patients['EstimateConsultantBilling']['date'],Configure::read('date_format'));   
		?>
		</td>
		<td><?php $surgeryDate = $this->DateFormat->formatDate2Local($patients['EstimateConsultantBilling']['surgery_date'],Configure::read('date_format')); 
		          echo $surgeryDate = ($surgeryDate != '00/00/0000') ? $surgeryDate : '';
		     
		?>
		</td>
		<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php //register to ipd
		if($patients['EstimateConsultantBilling']['approved']){
			if(in_array($patients['EstimateConsultantBilling']['patient_id'], $admittedPatients))
				echo $this->Html->image('icons/green.png',array('style'=>'cursor : no-drop;'));
			else
				echo $this->Html->link($this->Html->image('icons/red.png'),array('controller'=>'Patients','action'=>'add','?'=>array('type'=>'IPD','is_opd'=>'1','patient_id'=>$patients['EstimateConsultantBilling']['patient_id'],'packaged'=>'1')),array('escape'=>false));
		}else{
			echo $this->Html->image('icons/grey.png',array('style'=>'cursor : no-drop;'));
			}
			?>
		</td>
		<td><?php  echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'packageEstimate', $patients['EstimateConsultantBilling']['id'],'?'=>array('type'=>'view')), array('escape' => false)); ?>
		</td>

	</tr>
	<?php $rowCount++;
			}
			//set get variables to pagination url
			$this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
			?>
	<tr>
		<TD colspan="8" align="Center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		
		</TD>
	</tr>
	<?php  }else{ ?>
	<tr>
			<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
	<?php }?>

</table>
<script>    
$(document).ready(function(){
	$('#lookup_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","lookup_name",'null','no','no',"admin" => false,"plugin"=>false)); ?>",
		minLength: 1,
		select: function( event, ui ) {
		$('#patient_id').val(ui.item.id);
		},
		messages: {
		noResults: '',
		results: function() {}
		}
	});
	$('.LookUpName').click(function(){
		  	
		var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;
        var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Estimates', "action" => "residentDashboard", "admin" => true));?>";
         $.ajax({
			beforeSend:function(data){
         		$('#busy-indicator').show();
         	},
         	success: function(data){
         		$('#busy-indicator').hide();
         		$("#container").html(data).fadeIn('slow');
         	}
         });
	});
	
	 /* $("#search_status").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","EstimateConsultantBilling",'approved',"admin" => false,"plugin"=>false)); ?>",
					{
				    	width: 50,
				    	selectFirst: true
					}); */
		
	$('#admission_id').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","admission_id",'null','no','no',"admin" => false,"plugin"=>false)); ?>",
		minLength: 1,
		select: function( event, ui ) {
		$('#patient_id').val(ui.item.id);
		},
		messages: {
		noResults: '',
		results: function() {}
		}
	});
	
	$( ".date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		changeTime:true,
		showTime: true,  		
		dateFormat:'<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();
		}
	});

	$("#from").datepicker
	({
       	showOn: "button",
       	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
       	buttonImageOnly: true,
       	changeMonth: true,
       	changeYear: true,
       	yearRange: '1950',
       	maxDate: new Date(),
       	dateFormat: 'dd/mm/yy',			
	});	
	       		
	$("#to").datepicker
	({
		showOn: "button",
       	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
       	buttonImageOnly: true,
       	changeMonth: true,
       	changeYear: true,
       	yearRange: '1950',
       	maxDate: new Date(),
       	dateFormat: 'dd/mm/yy',			
	});
});                       
</script>
