
<?php
echo $this->Html->css(array('jquery.autocomplete.css'));
echo $this->Html->script(array('jquery.autocomplete.js'));
?>

 <style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}

.top-header {
	background: #3e474a;
	height: 60px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

textarea {
	width: 100px;
	padding: 0;
}

.inner_title span{ margin:-26px 0px;}
#inner_menu img{ float:none !important;}
div{ font-size:13px;}

</style>

 <div class="inner_title" >
 	<h3>&nbsp; Discharge Summary Report-All Patients</h3> 
    <div style="float:right;">
				<span style="float:right;">
					<?php
						echo $this->Form->create('dischargereport',array('url'=>array('controller'=>'Corporates','action'=>'discharge_summary_report_all','admin'=>'TRUE'),'id'=>'dischargereport','type'=>'get')); 
						echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'float:right;margin-left:10px;'));  	
						echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',		
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));	
					?>
				</span>
			</div>
 </div>
<div id="inner_menu" style="float:right; width:100%; padding-top:10px;">                
	<div cellpadding="0" cellspacing="0" border="0"  align="left" style="float:left; width:100%; ">
		<div style="float: Left;">
			<?php
				echo __("Patient Name : ")."&nbsp;".$this->Form->input('lookup_name', array('id' => 'lookup_name', 'value'=>$this->params->query['lookup_name'],'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name'))."&nbsp;&nbsp;&nbsp;";
			?> 
		 <span>
	    	<?php echo "Company :"."&nbsp;".$this->Form->input('', array('name'=>'tariff_standared','type'=>'text','id' => 'search_tariff_standared','label'=> false, 'div' => false, 'error' => false))."&nbsp;&nbsp;&nbsp;";
		?>
	    </span>	
	    <span>
	    	<?php 
	    		echo "Date From : "."&nbsp;".$this->Form->input('CompReport.from', array('id'=>'from','value'=>$this->request->query['from'] ,'label'=> false, 'div' => false, 'error' => false)); 
	    	?>
	    </span>
	    <span>
	    	<?php 
	    		echo "To Date : "."&nbsp;".$this->Form->input('CompReport.to', array('id'=>'to','value'=>$this->request->query['to'],'label'=> false, 'div' => false, 'error' => false));
	    	?>
	    </span>
		
		
		</div>
		<div style="float: Left;">
			<span>
	    	<?php 
	    		echo "Patient is: "."&nbsp;".$this->Form->input('', array('id'=>'is_discharge','type'=>'select','empty'=>'none','options'=>array('on_bed'=>"On Bed",'discharge'=>'Discharge'),'name'=>'is_discharge','value'=>$this->request->query['is_discharge'],'label'=> false, 'div' => false, 'error' => false));
	    	?>
	    </span>
		
		<span>
	    	<?php 
	    		echo "Status: "."&nbsp;".$this->Form->input('', array('id'=>'discharge_status','name'=>'discharge_status','type'=>'select','empty'=>'none','options'=>array(array_merge(Configure::read('onBedStatus'),Configure::read('onDischargeStatus'))),'value'=>$this->request->query['discharge_status'],'label'=> false, 'div' => false, 'error' => false));
	    	?>
	    </span>
	   
	   	<span >
			<?php 
				echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false));	
			?>
		</span>
			<?php
				echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'admin_discharge_summary_report_all'),array('escape'=>false, 'title' => 'refresh'));
				
			?>
		</div>
    </div>
</div>	
<?php echo $this->Form->end(); ?>
	<div class="clr"></div>

	<div class="clr ht5"></div>


<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm ">
	<thead>
	<tr>
		<th width="2%" valign="top" align="center" style="text-align:center;">Sr No</th>
		
		<th width="15%" valign="top" align="center"
			style="text-align: center;">PATIENT NAME</th>
		<th width="10%" valign="top" align="center"
			style="text-align: center;">COMPANY NAME</th>	
		<th width="10%" valign="top" align="center"
			style="text-align: center;">ADMISSION DATE</th>
		<th width="10%" valign="top" align="center"
			style="text-align: center;">DISCHARGE DATE</th>
		<th width="5%" valign="top" align="center"
			style="text-align: center;">IS DISCHARGE</th>
		<th width="30%" valign="top" align="center"
			style="text-align: center;">STATUS</th>
	</tr>
	</thead>
	<?php //debug($results);?>
	<tbody>
		<?php 
			$i=0;
			foreach($results as $result)
	     	{
		     	$bill_id = $result['FinalBilling']['id'];
		     	$patient_id = $result['Patient']['id'];
		     	$i++;
	    ?>
	<tr>
		<td valign="top" align="center" style="text-align:center;">
    		<?php echo $i;?>
    	</td>
    	
		<td align="center">
			<?php echo $result['Patient']['lookup_name']; ?>
		</td>
		<td align="center">
			<?php echo $result['TariffStandard']['name'];
			echo $this->Form->hidden('TariffStandard.name',array('value'=>$result['TariffStandard']['name'],
				'class'=>'tariffStandard','id'=>'tariffStandard_'.$result['Patient']['id']));
			?>
		</td>
		<td align="center">
			<?php echo $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); ?>
		</td>
	
		<td align="center">
			<?php echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); ?>
		</td>
		
		<td align="center">
		<?php $isDischarge = $result['Patient']['is_discharge']; 
			if($isDischarge == 1){
				$checked = "checked";
				$status = 'onDischargeStatus';
			}else{
				$checked = "";
				$status = 'onBedStatus';
			}?>			
			<?php echo $this->Form->input('',array('type'=>'checkbox','name'=>"data['is_discharge'][]",'tariff_standard'=>$result['TariffStandard']['name'],'checked'=>$checked,'id'=>'isDischarge_'.$result['Patient']['id'],'class'=>'isDischarge','div'=>false,'label'=>false)); ?>
		</td>
	
		<td align="center" style="text-align: center;">
			 <?php
			 /*$status_update = array(
			 		'0'=>'On Bed',
			 		'1'=>'Discharged and Payment Pending',
			 		'2'=>'Discharged and Payment Recevied',
			 		'3'=>'Discharged but bill not made',
			 		'4'=>'Discharged and bill made but file not submitted ',
			 		'5'=>' File Submitted',
					'6'=>'Discharged but bill not Open',
					'7'=>'File Pending for submission(RGJAY)',
					'8'=>'Preauth Approved',
					'9'=>'Preauth Pending',
					'10'=>'Surgery Update',
					'11'=>'Discharge Update',
					'12'=>'Claim Doctor Pending',
					'13'=>'Claim Doctor Pending Updated',
					'14'=>'Bill Submitted');*/
                    // debug($result['Patient']['discharge_status']);exit;
			 	echo $this->Form->input('status', array('type' => 'select','empty'=>'Please Select','label'=>false ,'style'=>"width:100%;",'div'=>false,'class'=>'add_status','id'=>'status_'.$result['Patient']['id'],
				'options' =>Configure::read($status),'default'=>$result['Patient']['discharge_status'])); 
			?>
		</td>

	</tr>
	<?php } ?>
</tbody>
</table>

<table align="center">
	<tr>
		<?php echo $this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
		?>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('� Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next �', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		
		</TD>
	</tr>
</table>


<script>

	$('.LookUpName').click(function(){
         			  	
		var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;
        var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "discharge_summary_report_all", "admin" => true));?>";
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

	$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient",'lookup_name',"admin" => false,"plugin"=>false)); ?>",
	{
    	width: 50,
    	selectFirst: true
	}); 
  $("#search_tariff_standared").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffStandard",'name',"admin" => false,"plugin"=>false)); ?>",
	{
    	width: 50,
    	selectFirst: true
	}); 

	/*$(function() {
		var $sidebar   = $(".top-header"), 
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 0;

	    $window.scroll(function() {
	    	if ($window.scrollTop() > offset.top) {
	        	$sidebar.stop().animate({
	            	top: $window.scrollTop() - offset.top + topPadding
	            });
				$sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
	        } else {
	            $sidebar.stop().animate({
	               top: 0
	        });
	    	}
		});
	});*/
	var selectedStatus = '';			
        $('.add_status').focus(function(){
            selectedStatus = $(this).val();
        });
        
	$('.add_status').change(function(){
     		var patient = $(this).attr('id') ; 
     		splittedId = patient.split("_");
     		statusId = splittedId[1]; 
     		var tariff = $("#tariffStandard_"+statusId).val(); 
     		var tariffStandard = tariff.trim();
     		var val = $(this).val(); 
     		
                    $.ajax({
                    url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getUpdateStatus", "admin" => false));?>"+"/"+statusId+"/"+val+"/"+tariffStandard,
                    beforeSend:function(data){
                            $('#busy-indicator').show();
                    },
                    success: function(data){ 
                        var obj = $.parseJSON(data);
                        if(obj == '2'){
                            alert('Please Finalize Billing');
                            $("#status_"+statusId).val(selectedStatus);
                        }
                        $('#busy-indicator').hide();
                    }
     		});
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

	$(".isDischarge").click(function(){
		var id = $(this).attr('id');
		var patient_id = id.split("_")[1];
		if($("#"+id).is(":checked")){
			if($(this).attr('tariff_standard') === "Private"){
				$("#"+id).attr("checked",false);
				alert("Could not be able to discharge the private patient from here..");
			}else{
				if(doDischarge(patient_id,'1')){
					return true;	
				}
			}
		}else{
			if(doDischarge(patient_id,'0')){
				return true;
			}
		}
	});
	
	//function to discharge by swapnil - 27.06.2015
	function doDischarge(patient_id,status){
		$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "doDischarge", "admin" => false));?>"+"/"+patient_id+"/"+status,
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success: function(data){
				$('#busy-indicator').hide();
				displayDischargeStatus(patient_id,status);
			}
		});
	}
	 
	//function to display the statuses options according to discharge by swapnil - 27.06.2015
	function displayDischargeStatus(patient_id,status){
		var noBedStatusArray = $.parseJSON('<?php echo json_encode(Configure::read('onBedStatus')); ?>');
		var noDisStatusArray = $.parseJSON('<?php echo json_encode(Configure::read('onDischargeStatus')); ?>');
		$("#status_"+patient_id+" option").remove();
		$("#status_"+patient_id).append( "<option value=''>Please Select</option>" );
		if(status === "0"){
			$.each(noBedStatusArray, function(id,value){
				$("#status_"+patient_id).append( "<option value='"+id+"'>"+value+"</option>" ); 
			});
		}else if(status === "1"){
			$.each(noDisStatusArray, function(id,value){
				$("#status_"+patient_id).append( "<option value='"+id+"'>"+value+"</option>" ); 
			});
		}
	}
</script>