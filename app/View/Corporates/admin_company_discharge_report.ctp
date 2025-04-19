<?php $website= $this->Session->read('website.instance');?>

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

<?php
$status_update = array(
						'Discharged'=>'Discharged','Bill Submitted'=>'Bill Submitted','Amount Received'=>'Amount Received','Bill Ready'=>'Bill Ready');
?>
<?php //echo $this->element("reports_menu");?>
 <div class="inner_title" >
 	<h3>&nbsp; Discharge Report-Company</h3> 
    <div style="float:right;">
				<span style="float:right;">
					<?php
						echo $this->Form->create('surgeonreport',array('url'=>array('controller'=>'Corporates','action'=>'company_discharge_report','admin'=>'TRUE'),'id'=>'surgeonreport','type'=>'get', 'style'=> 'float:left;')); 
						echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
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
	    	<?php 
	    		echo "Date From : "."&nbsp;".$this->Form->input('CompReport.from', array('id'=>'from','value'=>$this->request->query['from'] ,'label'=> false, 'div' => false, 'error' => false)); 
	    	?>
	    </span>
	    <span>
	    	<?php 
	    		echo "To Date : "."&nbsp;".$this->Form->input('CompReport.to', array('id'=>'to','value'=>$this->request->query['to'],'label'=> false, 'div' => false, 'error' => false));
	    	?>
	    </span>
	   	<span id="look_up_name" class="LookUpName">
			<?php 
				echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false));	
			?>
			</span>
			<?php
				echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'admin_company_discharge_report'),array('escape'=>false, 'title' => 'refresh'));
				echo $this->Form->end();
			?>
	
		</div>
    </div>
</div>	


	<div class="clr"></div>

	<div class="clr ht5"></div>


<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm ">
	<thead>
	<tr>
		<th width="5px" valign="top" align="center" style="text-align:center;">#</th>
		<th width="50px" valign="top" align="center"
			style="text-align: center;">DISCHARGE DATE</br>
			<?php 
		    if($website == 'kanpur')
              {?>DISCHARGED BY
              <?php }?></th>
		<th width="72px" valign="top" align="center"
			style="text-align: center;">PATIENT NAME</th>
		<th width="72px" valign="top" align="center"
			style="text-align: center;">PAYER</th>	
		<th width="65px" valign="top" align="center"
			style="text-align: center;">BILL AMOUNT</th>
<!-- 		<th width="60px" valign="top" align="center"
			style="text-align: center;">AMOUNT SANCTIONED</th> -->
		<?php 
		
		if($website == 'kanpur')
        {?>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">LAB</th>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">RADIOLOGY</th>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">PHARMACY</th>
		<!-- <th width="82px;" valign="top" align="center" style="text-align:center; ">IMPLANT</th> -->
		<?php } else {?>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">LAB<br>PHARMACY<br>IMPLANT</th>
		<?php }?>
		<th width="65px" valign="top" align="center"
			style="text-align: center;">HOSPITAL REVENUE</th>
		<th width="75px" valign="top" align="center"
			style="text-align: center;">Consultant</th>
 	<th width="70px" valign="top" align="center"

			style="text-align: center;">BILL SUBMISSION DATE</th>
		<th width="60px" valign="top" align="center"
			style="text-align: center;">AMOUNT RECIEVED</th> 
		<th width="139px" valign="top" align="center"
			style="text-align: center;">STATUS</th>
		<th width="110px" valign="top" align="center"
			style="text-align: center;">REMARKS</th>
		<th width="21" valign="center" align="center"
			style="text-align: center; min-width: 21px;">
				<?php echo $this->Html->image('icons/delete-icon.png'); ?></th>
	</tr>
	</thead>

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
		<td width="8px" valign="top" align="center" style="text-align:center;">
    		<?php echo $i;?>
    	</td>
    	
    	<td width="65px" align="center">
			<?php echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format'),true).'</br>'?> 
			<?php if($website == 'kanpur')
                   { 	echo $userName;
	     	        }?> 
		</td>
			
		<td width="50px" align="center">
			<?php echo $result['Patient']['lookup_name']; ?>
		</td>
		<td width="50px" align="center">
			<?php echo $result['TariffStandard']['name']; ?>
		</td>
		<td width="50px" align="right" min-width: 50px;>
			<?php echo $this->Number->currency(ceil($bill_amt=$result['FinalBilling']['total_amount']));?>
		</td>
		
<!-- 		<td width="73px" align="center"> -->
			<?php  
// 				foreach($advancePayment as $pay){
// 					if($result['Patient']['id'] == $pay['Billing']['patient_id'])
// 					{
// 						$pay_amount = $pay_amount+$pay['Billing']['amount'];
// 					}
// 				}
// 				echo $this->Number->currency(ceil($pay_amount));
// 				unset($pay_amount);?>
<!-- 		</td> -->
		
		
		<?php 
		$website= $this->Session->read('website.instance');
		if($website == 'kanpur')
        {?>	
        <td width="97px;"align="right"><?php echo $this->Number->currency(ceil($lab=$result['LaboratoryTestOrder']['total'])); ?></td>
        <td width="97px;"align="right"><?php echo $this->Number->currency(ceil($rad=$result['RadiologyTestOrder']['total'])); ?></td>
        <td width="97px;"align="right"><?php echo $this->Number->currency(ceil($pharm=$result['PharmacySalesBill']['total']));?></td>
		<!-- <td></td> -->
		<?php }else{?>	
		<td width="97px;"align="right"><?php echo $this->Number->currency(ceil($lab=$result['LaboratoryTestOrder']['total']));
		echo "/"."<br>";
		echo $this->Number->currency(ceil($pharm=$result['PharmacySalesBill']['total']));
		echo "/"."<br>";
		//echo $this->Number->currency(ceil($pharm=$result['RadiologyTestOrder']['total']));
		 //echo$this->Number->currency(ceil($lab=$result['LabTestPayment']['total_amount']+ $result['RadiologyTestPayment']['total_amount'])); 
		?>
		</td>
		<?php }?>
		
		<td width="74px;" align="right"><?php echo $this->Number->currency(ceil($bill_amt-($pharm+$lab+$rad)))?> </td>
		<td width="75px" align="center">
			<?php echo $result['Initial']['name']." ".$result[0]['name']; ?> </td>	
		</td>
		
       <td width="70px" align="center">

		<?php 
			if(isset($result['FinalBilling']['bill_uploading_date']))
			{
				echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
			}
			else
			{
				echo $this->Form->input("bill_uploading_date_$bill_id",array('id'=>'bill_uploading_date_'.$bill_id,'style'=>"width: 65%;",'class'=>'textBoxExpnd bill_uploading_date','label'=>false));
			}
		?>
	
		<td width="60px" align="center">
			<?php 
				echo $this->Html->link('Pay Here',array('controller'=>'billings','action' => 'multiplePaymentModeIpd',$result['Patient']['id'],'admin'=>false),array('escape' => false)); 
				echo $result['FinalBilling']['amount_paid'];
		   	?>
		</td> 
		
		<td width="77px" align="center" style="text-align: center;">
			 <?php
			 	echo $this->Form->input('status', array('type' => 'select','label'=>false ,'div'=>false,'class'=>'add_status','id'=>'status_'.$result['Patient']['id'],'options' => array('empty'=>'--Select--',$status_update),'selected'=>$result['Patient']['discharge_status_company']));
			?>
		</td>

		<td width="107px" align="center">
			<?php 
				echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','label'=>false,'rows'=>'1','cols'=>'3','class'=>'add_remark','value'=>$result['Patient']['remark']));
			?>
		</td>

		<td width="21" valign="center" align="center" style="text-align: center; min-width: 21px;" >
			<?php echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('controller'=>'Corporates','action' =>'patient_delete', $result['Patient']['id'],'admin'=>false),array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));?>
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
        var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "company_discharge_report", "admin" => true));?>";
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

	$(".bill_uploading_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		onSelect:function(date){
	    	var idd = $(this).attr('id');
	        splittedId=idd.split('_');
	        bilSubId = splittedId[3];
	        $.ajax({
                type:'POST',
                   url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "billUploadDate", "admin" => false));?>"+"/"+bilSubId,
                   data:'id='+bilSubId+"&date="+date,
                   success: function(data){}
	             });
	           },
       buttonImageOnly: true,
       changeMonth: true,
       changeYear: true,
       yearRange: '-50:+50',
       maxDate: new Date(),
       dateFormat: 'dd/mm/yy',
       });
	
	$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient",'lookup_name',"admin" => false,"plugin"=>false)); ?>",
	{
    	width: 50,
    	selectFirst: true
	}); 

    $('.clickMe').click(function(){
		var patient = $(this).attr('id') ;
		var val = $("#remark"+patient).val();
		$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getRemark", "admin" => false));?>"+"/"+patient+"/"+val,
			success: function(data){}
			});
	});

	$(function() {
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
	});
				
	

       $('.add_remark').blur(function(){
        	var patient = $(this).attr('id') ; 
        	splittedId = patient.split("_");
        	newId = splittedId[1];
        	var val = $(this).val();
        	$.ajax({
        		url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getRemark", "admin" => false));?>"+"/"+newId+"/"+val,
        		beforeSend:function(data){
        			$('#busy-indicator').show();
        				//inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
        		},
        		success: function(data){
        			$('#busy-indicator').hide();
        		}
        	});
        });
			
        $('.add_status').blur(function(){
     		var patient = $(this).attr('id') ;
     		splittedId = patient.split("_");
     		statusId = splittedId[1];
     		var val = $(this).val();
			$.ajax({
     			url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getStatus", "admin" => false));?>"+"/"+statusId+"/"+val,
     			beforeSend:function(data){
     				$('#busy-indicator').show();
     			},
     			success: function(data){
     				$('#busy-indicator').hide();
     			}
     		});
     	});

       function deleteRecord(patient_id) 
       {  
          if (patient_id == '') {
	          alert("Something went wrong");
	          return false;
      	  } 
          $("#Patientsid").val(patient_id);
          	$.fancybox({ 
          		'width' : '70%',
          		'height' : '120%',
          		'autoScale' : true, 
          		'transitionIn' : 'fade',
          		'transitionOut' : 'fade',
          		'type' : 'iframe', 
          		'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>" + '/' + patient_id,
          	});
      }		

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


</script>