<?php  
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Raymond_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description:Raymond_Report" );
ob_clean();
flush();
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
	width: 85px;
	color:black;
}

.tabularForm td {
       padding: 5px 4px;
}
</style>


<div class="inner_title" align="center">
	<h3 style="float: left;">Raymond Report</h3>

	
	<div class="clr"></div>


</div>
<div class="clr ht5"></div>


<table width="100%" cellpadding="0" cellspacing="1" border="1"
	class="tabularForm top-header">
	<tr>
                <td width="10px" valign="top" align="center"
			style="text-align: center; ">Sr.No</td>
		<td width="101px" valign="top" align="center"
			style="text-align: center; ">Name Of Patient</td>
		<td width="91px" valign="top" align="center"
			style="text-align: center; ">Name Of Employee (rank)</td>
		<td width="97px" valign="top" align="center"
			style="text-align: center;">Relation with Employee</td>
		<td width="95px" valign="top" align="center"
			style="text-align: center;">Date of Addmision</td>
		<td width="115px" valign="top" align="center"
			style="text-align: center;">Bill No</td>
		<td width="95px" valign="top" align="center"
			style="text-align: center;">Date of Discharge</td>
		<td width="100px" valign="top" align="center"
			style="text-align: center; ">Total Bill</td>
		<td width="83px" valign="top" align="center"
			style="text-align: center; ">Advance Received</td>
		<td width="96px" valign="top" align="center"
			style="text-align: center; ">TDS</td>
		<td width="95px" valign="top" align="center"
			style="text-align: center;">Other deduct</td>
		<td width="88px" valign="top" align="center"
			style="text-align: center;">Bill Submission</td>
		<td width="129px" valign="top" align="center"
			style="text-align: center;">Remark</td>
		<td width="107px" valign="top" align="center"
			style="text-align: center; ">Bill due Date</td>

	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="1"
	class="tabularForm">
	<?php 
	$i=0;
	foreach($results as $result)
	{
		$bill_id = $result['FinalBilling']['id'];
		$patient_id = $result['Patient']['id'];
		$i++;	
		//holds the id of patient
		?>
	<tr>
                <td width="10px" valign="top" align="center" style="text-align: center; "><?php 
            echo $i;
			?></td>
		<td width="101px" valign="top" align="center" style="text-align: center; "><?php 
            echo $result['Patient']['lookup_name'];
			?></td>
		<td width="137px" valign="top" align="center" style="text-align: center;"><?php 
			echo $result['Patient']['relative_name'];   ?></td>

		<td width="163px" valign="top" align="center" style="text-align: center; "><?php 
			echo $result['Person']['relation_to_employee'];  ?></td>
			
		<td width="105px" valign="top" align="center" style="text-align: center; "><?php
			echo $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); //date of admission?></td>
			
		<td width="100px" valign="top" align="center" style="text-align: center; "><?php 
		    echo $result['FinalBilling']['bill_number'];  //bill no ?></td>

		<td width="95px" valign="top" align="center" style="text-align: center; "><?php 
		    echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); //date of discharge?></td>
		    
		<td width="94px" valign="top" align="center"	style="text-align: center; "><?php   
		    $totalBill=$result['FinalBilling']['hospital_invoice_amount'];
                   echo $this->Number->currency(ceil($totalBill));
		     //total bill?></td>
		
		<td width="115px" valign="top" align="center" style="text-align: center;"><?php 
		    $amtReceived = $totalPaid[$patient_id]; 
                    echo $this->Number->currency(ceil($amtReceived));
		    //advance recevied ?></td>
		    
		<td width="95px" style="text-align:center; min-width:50px;"><?php // TDS	
		 	echo  $tds=$this->Number->currency(ceil($result['FinalBilling']['tds']));
		 	$tds=$result['FinalBilling']['tds'];
				?>
		</td>

		<td width="95px" style="text-align:center; min-width:50px;"><?php	// Other Deduction
			 //$otherDeduct=$totalBill-($amtReceived+$tds);
			 echo $this->Number->currency(ceil($otherDeduct));	?>
	    </td>
			     			
		
		<td width="95px" valign="top" align="center"	style="text-align: center;"><?php	
					//Bill Submission date
					echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
				?></td>

		<td width="95px" valign="top" align="center"	style="text-align: center;">
			<?php 
                    if(isset($result['Patient']['remark']))
                    {
                            echo $result['Patient']['remark'];
                    }
                    else
                    {
                            echo "";
                    }
			?>
		</td>
		<td width="95px" valign="top" align="center" style="text-align: center; min-width: 25px;"><?php  //Bill Due Date
						
                    if(isset($result['FinalBilling']['bill_uploading_date']))
                    {
                    $bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
                                            echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));
		     }
		     else echo "";
		     ?>
		</td>
	</tr>
	<?php }  ?>
        <tr>
            <td colspan="7" align="center">
                <b>Total Receivable Amount</b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice)); ?></b></td> 
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalAdvancePaid)); ?></b></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="7" align="left">
                <b><?php echo $suspenseDetails; ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="7" align="center">
                <b><?php echo __('Actual Receivable'); ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="5"></td>
        </tr>
	
</table>

<?php 

function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
{
	$date = $cur_date;
	$date = strtotime($date);
	$date = strtotime("+$no_days day", $date);
	return date('Y-m-d', $date);
}


?>

<script>

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
  				<?php// echo $this->Html->image('/ajax-loader.gif') ?>	
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
    				  remarkId = splittedId[1];
    				  alert(remarkId);
    				  var val = $(this).val();
    				  alert(val);

    				$.ajax({
    				url : "<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "getRemark", "admin" => false));?>"+"/"+remarkId+"/"+val,
    				
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
    				  alert(splittedId);
    				  deductionId = splittedId[1];
    				  
    				  var val = $(this).val();
    				  alert(val);

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
    	
 		  
</script>
