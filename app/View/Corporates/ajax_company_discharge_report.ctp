<?php 
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));  
	echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js')); 
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
</style>




<div id="container">
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm top-header">
	<tr>
	
	
	<thead>
		<th width="70	" valign="top" align="center"
			style="text-align: center; min-width: 70px;">DISCHARGE DATE</th>
		<th width="78" valign="top" align="center"
			style="text-align: center; min-width: 78px;">PATIENT NAME</th>
		<th width="64" valign="top" align="center"
			style="text-align: center; min-width: 60px;">BILL AMOUNT</th>
		<th width="60" valign="top" align="center"
			style="text-align: center; min-width: 60px;">AMOUNT SANCTIONED</th>
		<th width="60" valign="top" align="center"
			style="text-align: center; min-width: 60px;">LAB<br>PHARMACY<br>IMPLANT<br>INSTRUMENTS
		</th>
		<th width="55" valign="top" align="center"
			style="text-align: center; min-width: 55px;">HOSPITAL REVENUE</th>
		<th width="75" valign="top" align="center"
			style="text-align: center; min-width: 75px;">REFFERED BY</th>
		<th width="70" valign="top" align="center"
			style="text-align: center; min-width: 70px;">BILL SUBMISSION DATE</th>
		<th width="60" valign="top" align="center"
			style="text-align: center; min-width: 60px;">AMOUNT RECIEVED</th>
		<th width="160" valign="top" align="center"
			style="text-align: center; min-width: 160px;">STATUS</th>
		<th width="107" valign="top" align="center"
			style="text-align: center; min-width: 107px;">REMARKS</th>

		<!-- <th width="25" valign="top" align="center" style="text-align:center; min-width:25px;">PRINT</th> -->

	</thead>
	</tr>
</table>


<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm">
	<?php 
	$patient_id=$result[Patient][id];
	$i=0;
	foreach($results as $result)
     {
     	$bill_id = $result['FinalBilling']['id'];
     	 ?>
	<TR>
		<td width="63" align="center"><?php echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); ?>
		</td>
		<td width="70" align="center"><?php echo $result['Patient']['lookup_name']; ?>
		</td>
		<td width="60" align="right" min-width: 60px;><?php 
		echo $this->Number->currency(ceil($bill_amt=$result['FinalBilling']['total_amount']));?>
		</td>

		<td width="73" align="center"><?php  

		foreach($advancePayment as $pay)
		{
			if($result['Patient']['id'] == $pay['Billing']['patient_id'])
			{
				$pay_amount = $pay_amount+$pay['Billing']['amount'];
			}
		}
		echo $this->Number->currency(ceil($pay_amount));
		unset($pay_amount);?>
		</td>

		<td width="75" align="center"><?php echo $this->Number->currency(ceil($pharm=$result['PharmacySalesBill']['total']));
		echo "/"."<br>";
		echo $this->Number->currency(ceil($lab=$result['LabTestPayment']['total_amount']+ $result['RadiologyTestPayment']['total_amount'])); ?>
		</td>


		<td width="55" align="right"><?php echo $this->Number->currency(ceil($bill_amt-($pharm+$lab)))?>
		</td>

		<td width="75" align="center"><?php  echo $result['Consultant']['first_name']; ?>
		</td>
		<td width="70" align="center">
		<?php 
			if(isset($result['FinalBilling']['bill_uploading_date']))
			{
				echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
			}
			else
			{
				echo $this->Form->input("bill_uploading_date_$bill_id",array('style'=>"width: 65%;",'class'=>'textBoxExpnd bill_uploading_date','div'=>false,'label'=>false));
			}
		?>
	
		<td width="60" align="center">
			<?php 
			
				echo $this->Html->link('Pay Here',array('controller'=>'billings','action' => 'advancePayment',$result['Patient']['id'],'admin'=>false),array('escape' => false)); 
				echo $result['FinalBilling']['amount_paid'];
		   	?>
		</td>
		
		<td width="77" align="center"
			style="text-align: center; min-width: 77px;">
			 <?php
			 	echo $this->Form->input('status', array('type' => 'select','label'=>false ,'div'=>false,'class'=>'add_status','id'=>'status_'.$result['Patient']['id'],'options' => array('empty'=>'--Select--',$status_update),'selected'=>$result['Patient']['discharge_status']));
			?>
		</td>


		<td width="107`" align="center"min-width: 107px;>
		<?php 
			echo $this->Form->input('remark',
				array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','label'=>false,'rows'=>'1','cols'=>'3','class'=>'add_remark','value'=>$result['Patient']['remark']));
			?>
		
		</td>


		<!-- <td width="25"  align="center"  min-width:25px;"><?php
		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Invoice')),'#',
						     		array('escape' => false,'onclick'=>"var openWin = window.open('".html_entity_decode($this->Html->url(array('action'=>'printReceipt',
						     		$result['Patient']['id'],$mode),true))."',
						           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
	?>	</td> -->
<!-- 		<td> -->
			<?php// echo $result['Patient']['id']; ?>
<!-- 		</td> -->
	</TR>
	
	<?php } ?>

</table>


</div>

<script>
           jQuery(document).ready(function()
		   {
				$('.clickMe').click(function()
				{
				var patient = $(this).attr('id') ;
				var val = $("#remark"+patient).val();
				
				$.ajax({
				url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getRemark", "admin" => false));?>"+"/"+patient+"/"+val,
				success: function(data){
				//alert(data);
				}
				});}
				);

				

				$(function() {

	                var $sidebar   = $(".top-header"), 
	                    $window    = $(window),
	                    offset     = $sidebar.offset(),
	                    topPadding = 0;

	                $window.scroll(function() {
	                    if ($window.scrollTop() > offset.top) {
	                        /*$sidebar.stop().animate({
	                            top: $window.scrollTop() - offset.top + topPadding
	                        });*/

	                        $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
	                    } else {
	                        $sidebar.stop().animate({
	                            top: 0
	                        });
	                    }
	                });


	                $( ".bill_uploading_date" ).datepicker({
	                	showOn: "button",
	                	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	                	onSelect:function(date){
	                		var idd = $(this).attr('id');
	                		//alert(idd);
	                		 splittedId=idd.split('_');
	                		var newId = splittedId[3];
	                		 
	                		$.ajax({
	                			type:'POST',
	                   			url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "billUploadDate", "admin" => false));?>"+"/"+newId,
	                   			data:'id='+newId+"&date="+date,
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
	                
	            });

		   });

           $('.add_remark').blur(function()
        			  {
        				  var patient = $(this).attr('id') ;
        				  splittedId = patient.split("_");
        				  newId = splittedId[1];
        				  //alert(newId);
        				  var val = $(this).val();
        				  //alert(val);

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
        				}
        				);
			
           $('.add_status').blur(function()
     			  {
     				  var patient = $(this).attr('id') ;
     				  splittedId = patient.split("_");
     				  statusId = splittedId[1];
     				  //alert(statusId);
     				  var val = $(this).val();
     				  //alert(val);

     				$.ajax({
     				url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getStatus", "admin" => false));?>"+"/"+statusId+"/"+val,
     				
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


		   
</script>

