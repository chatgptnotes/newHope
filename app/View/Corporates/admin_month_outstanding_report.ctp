<?php echo $this->Html->css(array( 'jquery.fancybox' /*,'colResizable.css'*/));  
 	  echo $this->Html->script(array('jquery.fancybox' /*,'colResizable-1.4.min.js'*/ )); ?> 
 	  <?php 
echo $this->Html->script('topheaderfreeze') ;
?>
<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}
element.style {
    min-height: 77px;
}

textarea {
	width: 85px;
}

.tdLabel2 img{ float:none ! ortant;}


#ui-datepicker-div{z-index:10000;}

#busy-indicator{z-index:10000;}
</style>
<script type="text/javascript">

$(function() {
	$("#from").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
		
 $("#to").datepicker({
		showOn: "both",
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

<div class="inner_title">
	<h3>Outstanding Report - <?php echo $tariffData[$tariffStandardID];?></h3>
    	<div style="float:right;">
		<span style="float:right;">
    		<?php	
 	  			echo $this->Form->create('',array('url'=>array('controller'=>'Corporates','action'=>'month_outstanding_report',$tariffStandardID,'admin'=>'TRUE'),'id'=>'otherOutRepFrm','type'=>'get')); 
				echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
				echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,$this->params->pass[0],'excel',		
					'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));	?>
		</span>
	</div>			
</div>
<div class="clr ht5"></div>
<table width="" cellpadding="0" cellspacing="0" border="0" class="tdLabel2" style="color: #000;">
	<tr>	
		
		<td style="padding-right:10px;">
			<?php 
			
			echo $this->Form->input('tariff_standard_id', array(  'empty'=>__('Please Select Corporate') , 'options'=>$tariffData,'class' => ' textBoxExpnd','id'=>'tariff','label'=>false,'div'=>false,'value'=>$tariffStandardID,'style'=>'width:200px;')); ?>
		</td>		
		<td style="color:#000;">
			<?php echo $this->Form->input('lookup_name', array('id' => 'lookup_name','value'=>$this->params->query['lookup_name'],'label'=> false, 'div' => false ,'autocomplete'=>'off','class'=>'name textBoxExpnd','placeHolder'=>'Search By Patient Name/Id'));
			
					echo $this->Form->hidden('patient_id',array('id'=>'patient_id'));
			?> 
		</td>
		
		
		
		  <td >
			<?php echo $this->Form->input('from', array('id'=>'from','label'=> false,'value'=>$this->request->query['from']/*?$this->request->query['from']:date('d/m/Y') */,'div' => false, 'error' => false,'placeHolder'=>'From Date','class'=>'textBoxExpnd'));?>		
		  </td>
		  <td >
			<?php echo $this->Form->input('to',array('id'=>'to','label'=> false, 'div' => false,'value'=>$this->params->query['to']/*?$this->request->query['to']:date('d/m/Y')*/, 'error' => false,'placeHolder'=>'To Date','class'=>'textBoxExpnd'));?>
		  </td>
		 <td><?php echo "Delay In Bill Preparation - Aging Report <br>".$this->Form->input('delay_in_bill_preparation',array('class'=>'textBoxExpnd','empty'=>'Please Select',
		  'options'=>array('7 Days'=>'7 Days After Discharge','15 Days'=>'15 Days After Discharge','1 Month'=>'1 Month After Discharge','3 Month'=>'3 Month After Discharge','More Than 3 Months'=>'More Than 3 Months'),'value'=>$this->params->query['delay_in_bill_preparation'],'label'=>false,'div'=>false));?></td> 

		   <td><?php echo "Delay In Receiving Payment - Aging Report <br>".$this->Form->input('delay_in_receiving_payment',array('class'=>'textBoxExpnd','empty'=>'Please Select',
		  'options'=>array('15 Days'=>'15 Days to 1 Month After Submission','1 Month'=>'1 Month to 3 Months After Submission','3 Month'=>'3 Month To 6 Months After Submission','6 Month'=>'6 Month To 12 Months After Submission','More Than 1 Year'=>'More Than 1 Year'),'value'=>$this->params->query['delay_in_receiving_payment'],'label'=>false,'div'=>false));?></td> 

		   <td><?php echo "Bill Submitted/ Not in date period<br>".$this->Form->input('bill_status',array('class'=>'textBoxExpnd','empty'=>'Please Select',
		  'options'=>array('bill_submitted'=>'Bill Submitted','bill_not_submitted'=>'Bill Not Submitted'),'value'=>$this->params->query['bill_status'],'label'=>false,'div'=>false));?></td> 
		  	
		  	<td style="padding-right:10px;">
			<?php 
			
			 echo "Admission Type:<br>".$this->Form->input('admission_type', array(  'empty'=>__('Please Select') , 'options'=>array('IPD'=>'IPD','OPD'=>'OPD'),'class' => ' textBoxExpnd','id'=>'admissionType','label'=>false,'div'=>false,'value'=>$this->params->query['admission_type'],'style'=>'width:200px;')); ?>
		</td>	
		  <td>
		  	<?php echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false));?>
			<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'month_outstanding_report',$tariffStandardID,'admin'=>'TRUE'),array('escape'=>false, 'title' => 'Refresh'));?>
		  </td>	

		

	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"> First select corporate and date period for all these three dropdowns</td>
	</tr>
</table>
<?php  echo $this->Form->end();?>	
 <div class="clr">&nbsp;</div>
<div id="container">                

<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable resizable sticky" id="container-table" style="top:0px;  overflow: scroll;">
	<thead>
	    <th width="2%"   align="center" style="text-align:center;">No.</th>
	    	<th width="10%"  align="center" style="text-align:center;">Invoice No.  </th>
		<th width="10%"  align="center" style="text-align:center;">Name Of Patient  </th>
		<th width="10%"  align="center" style="text-align: center;">Submission Date </th>
		<th width="10%"  align="center" style="text-align: center;">Outstanding Amount  </th> 

		<!--<th width="10%"  align="center" style="text-align: center;">Aging (In day) not imp </th>-->
	
		
		<th width="10%"  align="center" style="text-align: centser;">Aging (In day)  </th>
			<th width="10%"  align="center" style="text-align: centser;">Aging Category </th>
	
		<th width="10%"  align="center" style="text-align: center;">Remark </th> 
	</thead>
	 
	<?php 
	echo $this->Form->hidden('patient_id_place_holder',array('id'=>'patient_id_place_holder')) ;
	$i=0;$val = 0;
	foreach($results as $result)
	{	
	

			$discDate = new DateTime($result['Patient']['discharge_date']);
			$currentDate = new DateTime();
			$noOfDaysAfterDischargeInterVal = $discDate->diff($currentDate);
        
        	$billSubmitDate = new DateTime($result['FinalBilling']['dr_claim_date']);
			$currentDate = new DateTime();
			$noOfDaysAfterBillSubmitInterVal = $billSubmitDate->diff($currentDate);     

		
		if(!empty($this->request->query['delay_in_bill_preparation'])){
			$date1 = new DateTime($result['Patient']['discharge_date']);
			$date2 = new DateTime();
			$interval = $date1->diff($date2);
           
        }

        if($this->request->query['bill_options']=='not submitted'){
        	$date1 = new DateTime($result['Patient']['discharge_date']);
			$date2 = new DateTime($result['FinalBilling']['bill_uploading_date']);
			$interval = $date1->diff($date2);            
        }

        
		$i++;
		$patient_id = $result['Patient']['id'];
		$bill_id = $result['FinalBilling']['id'];
		//holds the id of patient corpotateDiscount
		$totalBillAmount = ($result['FinalBilling']['hospital_invoice_amount']) ? $result['FinalBilling']['hospital_invoice_amount'] : $result[0]['total_amount'] ;
		$total_amount = $totalBillAmount-$result[0]['patientPaid'];
		$advance_paid=$result[0]['advacnePAid'];//$result[0]['paid_amount'];
		$tds=$result[0]['TDSPAid'];
		$discount = $result[0]['total_discount'];
		$totalPaid = $advance_paid+ $tds+$discount ; 
		$color = '' ;
		$showEdit='';
		$showDelete='';
		$advacneCardPAid=$patientCardData[$result['Patient']['person_id']];
		
		if($total_amount == $totalPaid && $result[0]['total_amount']>'0'){
			$color = 'paid_payment';
			$showEdit='none';
			if($result['FinalBilling']['amount_pending']<='0')$showDelete='';
		}else{
			$showEdit='';
			$showDelete='none';
		}
		
		if($result['FinalBilling']['amount_pending']<='0'){
			$showSettlement='none';
		}else{
			$showSettlement='';
		}

		if($this->params->query['delay_in_bill_preparation'] == '7 Days'){
			if($noOfDaysAfterDischargeInterVal->days < 7 || $noOfDaysAfterDischargeInterVal->days > 15) continue; 
		}

		if($this->params->query['delay_in_bill_preparation'] == '15 Days'){
			if($noOfDaysAfterDischargeInterVal->days < 15 || $noOfDaysAfterDischargeInterVal->days > 30) continue; 
		}

		if($this->params->query['delay_in_bill_preparation'] == '1 Month'){
			if($noOfDaysAfterDischargeInterVal->days < 30 || $noOfDaysAfterDischargeInterVal->days > 90) continue; 
		}

		if($this->params->query['delay_in_bill_preparation'] == '3 Month'){
			if($noOfDaysAfterDischargeInterVal->days < 90 || $noOfDaysAfterDischargeInterVal->days > 365) continue; 
		}

		if($this->params->query['delay_in_bill_preparation'] == 'More Than 3 Months'){
			if($noOfDaysAfterDischargeInterVal->days < 90 ) continue; 
		}
		/**************************************************************************************/
		if($this->params->query['delay_in_receiving_payment'] == '15 Days'){
			if($noOfDaysAfterBillSubmitInterVal->days < 15 || $noOfDaysAfterBillSubmitInterVal->days > 30 || $result['FinalBilling']['dr_claim_date'] == '') continue; 
		}

		if($this->params->query['delay_in_receiving_payment'] == '1 Month'){
			if($noOfDaysAfterBillSubmitInterVal->days < 30 || $noOfDaysAfterBillSubmitInterVal->days > 90 || $result['FinalBilling']['dr_claim_date'] == '') continue; 
		}

		if($this->params->query['delay_in_receiving_payment'] == '3 Month'){
			if($noOfDaysAfterBillSubmitInterVal->days < 90 || $noOfDaysAfterBillSubmitInterVal->days > 180 || $result['FinalBilling']['dr_claim_date'] == '') continue; 
		}

		if($this->params->query['delay_in_receiving_payment'] == '6 Month' ){
			if($noOfDaysAfterBillSubmitInterVal->days < 180 || $noOfDaysAfterBillSubmitInterVal->days > 365 && $result['FinalBilling']['dr_claim_date'] == '') continue; 
		}

		if($this->params->query['delay_in_receiving_payment'] == 'More Than 1 Year' ){
			if($noOfDaysAfterBillSubmitInterVal->days < 365 || $result['FinalBilling']['dr_claim_date'] == '' ) continue; 
		}

		if($this->params->query['bill_status'] == 'bill_submitted'){
			if($result['FinalBilling']['dr_claim_date'] == '') continue;
		}

		if($this->params->query['bill_status'] == 'bill_not_submitted'){
			if($result['FinalBilling']['dr_claim_date'] != '') continue;
		}
		

		?>
	<tr >
		<td width="21px"  align="center" style="text-align:center;" class="<?php echo $color ;?>"> <?php  echo $i; ?> </td>
			<td width="89px"  align="center" style="text-align:center;" class="<?php echo $color ;?>">  <?php echo $result['FinalBilling']['bill_number'];  ?>  </td> 
		<td width="89px"  align="center" style="text-align:center;" class="<?php echo $color ;?>"> <?php echo $result['Patient']['lookup_name'];  ?>  <?php echo ' '; ?> </td> 

		<td width="119px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
	<?php  
if (!empty($result['FinalBilling']['bill_uploading_date'])) {
    echo $this->DateFormat->formatDate2Local(
        $result['FinalBilling']['bill_uploading_date'],
        Configure::read('date_format')
    );
} else {
    if (!empty($result['Patient']['is_discharge']) && $result['Patient']['is_discharge'] == 1) {
        echo '<span style="color: red; "> Bill Not Submitted</span>';
    } else {
        echo '<span style="color: red; ">Patient Admitted in Hospital</span>';
    }
}
?>

		</td>
		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>"> 
			<?php 

			$totalBillAmount = ($result['FinalBilling']['hospital_invoice_amount']) ? $result['FinalBilling']['hospital_invoice_amount'] : $result[0]['total_amount'] ;
			echo $this->Form->hidden('cmp_amt_paid', array('id'=>'amt_'.$bill_id,'type' => 'text','style'=>"width:20%",'label'=>false ,
					'div'=>false,'style'=>"width: 70%;",'class'=>'cmp_amt_paid','value'=> $totalBillAmount/*$total_amount*/));
				  echo  $totalBillAmount;//$total_amount ;?> <?php echo ' '; ?> 
		</td> 
		
	

	
		

		<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
		<?php echo $noOfDaysAfterBillSubmitInterVal->days; ?>
		</td>

			<td width="89px"  align="center" style="text-align: center;" class="<?php echo $color ;?>">
<?php
$days = $noOfDaysAfterBillSubmitInterVal->days;

if ($days >= 0 && $days <= 30) {
    echo '<span style="color: black;background: green;padding: 3px;border-radius: 5px;">1-30 day</span>';
} elseif ($days >= 31 && $days <= 60) {
    echo '<span style="color: black;background: yellow;padding: 3px;border-radius: 5px;">31-60 day</span>';
} elseif ($days >= 61 && $days <= 90) {
    echo '<span style="color: black;background: Orange;padding: 3px;border-radius: 5px;">61-90 day</span>';
} elseif ($days >= 91 && $days <= 120) {
    echo '<span style="color: black;background: Red;padding: 3px;border-radius: 5px;">91-120 day</span>';
} else {
    echo '<span style="color: black;background: Red;padding: 3px;border-radius: 5px;">120+ day</span>';
}
?>

		</td>
	
	
		
		<td width="89px" align="center" style="text-align: center;" class="<?php echo $color; ?>">
    <input type="text" 
           value="<?php echo h($result['FinalBilling']['reason_for_delay']); ?>" 
           class="reason-input" 
           data-bill-id="<?php echo $result['FinalBilling']['id']; ?>" 
           style="width: 100%; text-align: center;">
</td>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $(".reason-input").on("input", function() {
        var billId = $(this).data("bill-id"); // Get bill ID
        var reason = $(this).val(); // Get input value
        
        // AJAX request to update reason in the database
        $.ajax({
            url: "<?php echo $this->Html->url(array('controller' => 'Corporates', 'action' => 'updateReason')); ?>",
            type: "POST",
            data: { bill_id: billId, reason_for_delay: reason },
            success: function(response) {
                console.log("Reason Updated: " + response);
            },
            error: function(xhr, status, error) {
                console.error("Error Updating Reason: " + error);
            }
        });
    });
});
</script>

		  
		
	</tr>
	<?php } ?>
</table>

 
 </div>
		<?php 	 

		function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
		{
			$date = $cur_date;
			$date = strtotime($date);
			$date = strtotime("+$no_days day", $date);
			return date('Y-m-d', $date);
		}

?>
<Script>  
	$(document).ready(function(){ 
			$("#container-table").freezeHeader({ 'height': '450px' });
		$('.fancybox').click(function(){
			$('#patient_id_place_holder').val($(this).attr('patient_id')); 
			$('#patient_name').val($(this).attr('patient_name'));
			$('#advance_received').val($(this).attr('advance_received'));
			$('#total_amount').val($(this).attr('total_amount'));
			var tariffId = $(this).attr('tariff_standard_id');
			var patientId = $(this).attr('patient_id'); 
			 
			$('.fancybox').fancybox({ 
				'type':'ajax',
				'href':'<?php echo $this->Html->url(array('controller'=>"corporates",'action'=>"corporate_advance_payment",'admin'=>false)) ?>/'+tariffId+"/"+patientId ,
			     helpers     : { 
			    	locked     : true, 
			        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
			     }
			}); 
		});
		
		
		$(".final_payment").click(function(){ 
			$.fancybox({
				'autoDimensions':false,
		    	'width'    : '85%',
			    'height'   : '90%',
			    'autoScale': true,
			  	'transitionIn': 'fade',
			    'transitionOut': 'fade', 
			    'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200,				    
			    'type': 'iframe',
			    'helpers'   : { 
			    	   'overlay' : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox 
			    	  },
			    'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"full_payment","admin"=>false)); ?>/"+$(this).attr('patient_id')+"?corporate=corporate",
			});
		}); 
	});
	
	$(function(){ 
		//to preveny redirect on edit and delte buttons of all services 
		$(document).on('click',".corporateClaimSave",function(event){ 
			    event.preventDefault();
		});
		
		
		
				/*  var onSampleResized = function(e){  
				    var table = $(e.currentTarget); //reference to the resized table
				  };  
	
				 $("#item-row").colResizable({
				    liveDrag:true,
				    gripInnerHtml:"<div class='grip'></div>", 
				    draggingClass:"dragging", 
				    onResize:onSampleResized
				  });    */


		
		

		
		
			});	
	
	$("#lookup_name").autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no",'is_discharge=1',"admin" => false,"plugin"=>false)); ?>", 
		select: function(event,ui){ 
 			$("#patient_id").val(ui.item.id);
		},
		messages: {
	         noResults: '',
	         results: function() {},
	  	}
	});
	
	$( ".cmp_paid_date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		onSelect:function(date){
			var idd = $(this).attr('id');
			 splittedId=idd.split('_'); 
			 var bill_id = $("#bill_"+splittedId[3]).val(); 
			$.ajax({
				type:'POST',
	   			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "CMPpaidDate", "admin" => false));?>"+"/"+bill_id,
	   			data:'id='+bill_id+"&date="+date,
	   			success: function(data)
	   			{
		   			//alert(data);
		   		}
			});
		},
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '-50:+50',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',
	});

	$('.uploadExcel').click(function(){
		var currentID=$(this).attr('id');
		var splitedVar=currentID.split('_');
		patient_id=splitedVar[1];
		tariffStdId='<?php echo $tariffStandardID;?>';
		
		$('.uploadExcel').fancybox({ 
			'type':'ajax',
			'href':'<?php echo $this->Html->url(array('controller'=>"Billings",'action'=>"uploadCorporateExcel",'admin'=>false)) ?>'+'/'+patient_id+'?flag=reportUpload&tariffStdId='+tariffStdId,
		     helpers     : { 
		    	locked     : true, 
		        overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
		     }
		}); 
	});
 
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script>
document.getElementById("downloadExcel").addEventListener("click", function () {
    var table = document.getElementById("container-table").cloneNode(true); // Clone table to avoid modifying original
    var inputs = table.querySelectorAll("input"); // Select input fields
    inputs.forEach(input => {
        var cell = document.createElement("td");
        cell.textContent = input.value; // Replace input with text value
        input.parentNode.replaceChild(cell, input);
    });

    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.table_to_sheet(table);
    
    XLSX.utils.book_append_sheet(wb, ws, "Billing Data");
    XLSX.writeFile(wb, "Final_Billing_Report.xlsx");
});
</script>