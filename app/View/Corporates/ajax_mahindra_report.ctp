<?php 
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));  
	echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js')); 
?>
<style>

textarea 
{
	width: 60px;
}

</style>





<div id="container">
	
	
	<div class="clr">&nbsp;</div>
	
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm top-header" >
	
		<tr>
		  	<thead>
				
				<th width="5" valign="top" align="center" style="text-align:center;">#</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Patient Name</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Relation with Emp. </th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Admission Date</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Bill No.</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Discharge Date</th>
				<th width="60" valign="top" align="center" style="text-align:center; min-width:60px">Total Bill</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px">TDS</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px">Other Deduction</th>
				<th width="60"  valign="top" align="center" style="text-align:center; min-width:60px;">Balance</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Bill Submission Date</th>
				<th width="60"  valign="top" align="center" style="text-align:center; min-width:60px;">Remark</th> 
				<th width="60" valign="top" align="center" style="text-align:center; min-width:60px">Bill Due Date</th>
				
	   		</thead>
      	</tr>
    </table>   
    
    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm"> 
    
    <?php  $i=0; //debug($results);
    	foreach($results as $result) 
    	  {	
    	  	$patient_id = $result['Patient']['id'];
    	  	$bill_id = $result['FinalBilling']['id'];
    	  	$i++;
    	  	
    ?>
    	<tr>

    		<td width="5" valign="top" align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    		</td>
	    	<td width="50" style="text-align:center; min-width:50px;">
				<?php echo $result['Patient']['lookup_name'];?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php echo $result['Person']['relation_to_employee'];?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php 
					// Admission Date
	 				$admitn_date =($result['Patient']['form_received_on']);	
	 				echo $this->DateFormat->formatDate2Local($admitn_date, Configure::read('date_format'));
				?> 
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php 
						// Bill No	
		 			   echo $result['FinalBilling']['bill_number'];
				?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php 
						// Discharge Date
		 				$discharg_date =($result['Patient']['discharge_date']);	
		 				echo $this->DateFormat->formatDate2Local($discharg_date, Configure::read('date_format'));
				?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php 
						// Total Amount	
		 			   echo $result['FinalBilling']['total_amount'];
				?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php 
						// TDS	
		 			   echo $this->Form->input('tds', array('id'=>'tds_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_tds','value'=>$result['FinalBilling']['tds']));
				?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php	
				 		// Other Deduction
					echo $this->Form->input('other_deduction', array('id'=>'deduction_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_other_deduction','value'=>$result['FinalBilling']['other_deduction']));
				?>	
			</td>
			
			<td width="60" style="text-align:center; min-width:60px;">
				 <?php	
				 		// Balance= amount paid by Mahindra
					echo $this->Form->input('package_amount', array('id'=>'package_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_package_amount','value'=>$result['FinalBilling']['package_amount']));
				?>	
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php	
					//Bill Submission date
					echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
				?>	
			</td>
			
			<td width="50" style="text-align:center;">
				<?php 
					//Remark
	 				echo $this->Form->input('remark',
					array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','label'=>false,'rows'=>'1','cols'=>'2','class'=>'add_remark','value'=>$result['Patient']['remark']));
				?>	
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php 
						//Bill Due Date
						$bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
						echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));
				?>
			</td>
			
			
    	</tr>
    	

    <?php } ?>	
    </table>
	<table align="center">
		<tr>
			<?php $this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
			?>
			<TD colspan="8" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			
			</TD>
		</tr>
	</table>

</div>

<!--******************************************* table closed ************************************************************************************-->
<?php 

function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
{
	$date = $cur_date;
	$date = strtotime($date);
	$date = strtotime("+$no_days day", $date);
	return date('Y-m-d', $date);
}


?>
<!--******************************************* functions closed ************************************************************************************-->

<Script>

$('.add_package_amount').blur(function()
		  {
			  var bill = $(this).attr('id') ;
			  splittedId = bill.split("_");
			  packageId = splittedId[1];
			  //alert(packageId);
			  var val = $(this).val();
			  //alert(val);

			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getPackageAmount", "admin" => false));?>"+"/"+packageId+"/"+val,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
				<?php //echo $this->Html->image('/ajax-loader.gif') ?>	
			},
			
			success: function(data){
						$('#busy-indicator').hide();
			     }
			});
			}
			);


$('.add_remark').blur(function()
		  {
			  var patient = $(this).attr('id') ;
			  splittedId = patient.split("_");
			  newId = splittedId[1];
			  //alert(newId);
			  var val = $(this).val();
			  //alert(val);

			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'reports', "action" => "getRemark", "admin" => false));?>"+"/"+newId+"/"+val,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
				//inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
			},
			
			success: function(data){
						$('#busy-indicator').hide();
			     }
			
			});
			}
			);
			


$('.add_other_deduction').blur(function()
		  {
			  var bill = $(this).attr('id') ;
			  splittedId = bill.split("_");
			  deductionId = splittedId[1];
			  
			  var val = $(this).val();
			 

			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getOtherDeduction", "admin" => false));?>"+"/"+deductionId+"/"+val,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
				<?php //echo $this->Html->image('/ajax-loader.gif') ?>	
			},
			
			success: function(data){
						$('#busy-indicator').hide();
			     }
			});
			}
			);
			

$( ".bill_uploading_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	onSelect:function(date){
		var idd = $(this).attr('id');
		 splittedId=idd.split('_');
		 var billDueId = splittedId[3];
		 
		$.ajax({
			type:'POST',
   			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "billDueDate", "admin" => false));?>"+"/"+billDueId,
   			data:'id='+billDueId+"&date="+date,
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

$('.add_tds').blur(function()
		  {
			  var bill = $(this).attr('id') ;
			  splittedId = bill.split("_");
			  tdsId = splittedId[1];
			  //alert(tdsId);
			  var val = $(this).val();
			  //alert(val);
			$.ajax({
			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getTds", "admin" => false));?>"+"/"+tdsId+"/"+val,
			
			beforeSend:function(data){
				$('#busy-indicator').show();
				<?php //echo $this->Html->image('/ajax-loader.gif') ?>	
			},
			
			success: function(data){
						$('#busy-indicator').hide();
			     }
			});
			}
			);
</Script>