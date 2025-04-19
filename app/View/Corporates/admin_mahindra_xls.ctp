<?php
//header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
//header ("Content-Disposition: attachment; filename=\"TOR_report_".date('d-m-Y').".xls");
header ("Content-Disposition: attachment; filename=\"Mahindra Patient Report ".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: Mahindra & Mahindra Report" );
ob_clean();
flush();
?>

<style>
.tableTd {
	   	border-width: 0.5pt; 
		border: solid; 
	}
	.tableTdContent{
		border-width: 0.5pt; 
		border: solid;
	}
	#titles{
		font-weight: bolder;
	}
textarea 
{
	width: 85px;
}

</style>
 

<div id="container">                
	
	<div class="clr">&nbsp;</div>
	<table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm top-header" >
		<tr class='row_title'> 
		   <td colspan="13" width="100%" height='30px' align='center' valign='middle'>
		   		<h2><?php echo __('Mahindra Patient Report'); ?></h2>
		   </td>
	  	</tr>
		<tr>
		  	<thead>
				
				<th width="5" valign="top" align="center" style="text-align:center;">#</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Patient Name</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Relation with Emp. </th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Admission Date</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Bill No.</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Discharge Date</th>
				<th width="60" valign="top" align="center" style="text-align:center; min-width:60px">Hospital Invoice Amount</th>
				<th width="60"  valign="top" align="center" style="text-align:center; min-width:60px;">Amount Recieved</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px">TDS</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px">Other Deduction</th>
				<th width="80px" valign="top" align="center" style="text-align:center;">InvoiceDate</th>
				<th width="50" valign="top" align="center" style="text-align:center; min-width:50px;">Bill Submission Date</th>
				<th width="60"  valign="top" align="center" style="text-align:center; min-width:60px;">Remark</th> 
				<th width="60" valign="top" align="center" style="text-align:center; min-width:60px">Bill Due Date</th>
				
	   		</thead>
      	</tr>
    </table>   
    
    <table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm"> 
    <?php $i=0; $amount=0; 
    	$total=0; $totalamnt=0; 
    	$totalDeductAmnt=0; $totalTds=0;
    
    	foreach($results as $result) 
    	  {	$i++;
    	  	
    	  	
    ?>
    	<tr>
    		<td width="10" valign="top" align="center" style="text-align:center;">
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
						// Hospital Invoice Amount	
		 			   //echo $invoiceAmnt = $result['FinalBilling']['cmp_amt_paid'];
                                echo $invoiceAmnt = $result['FinalBilling']['hospital_invoice_amount'];
		 			   
				?>
			</td>
			
			<td width="60" style="text-align:center; min-width:60px;">
				 <?php	
				 		// Amount Recieved= amount paid by Mahindra
					//echo $amntRecieved =$result['FinalBilling']['package_amount'];
                                 echo $amntRecieved =$totalPaid[$result['Patient']['id']];
				?>	
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php 
						// TDS	
		 			   echo $tdsAmnt = $result['FinalBilling']['tds'];
		 		?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php	
				 		// Other Deduction

					if(isset($result['FinalBilling']['other_deduction']))
					{
						echo $otherDeduct = $result['FinalBilling']['other_deduction'];
					}
					else
					{
						echo "";
					}		
				?>	
			</td>
			<td>
			<?php	echo $this->DateFormat->formatDate2Local($result['FinalBilling']['cmp_paid_date'],Configure::read('date_format')); ?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php	
					//Bill Submission date
					echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
				?>
			</td>
			
			<td width="60" style="text-align:center;">
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
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php 
						//Bill Due Date
						$bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
						echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));
				?>
			</td>
			
    	</tr>
    <?php 
    	$total=$total+$invoiceAmnt;
    	$totalamnt=$totalamnt+$amntRecieved;
    	$totalTds=$totalTds+$tdsAmnt;
    	$totalDeductAmnt=$totalDeductAmnt+$otherDeduct;
    	  } 
    	  
    ?>	
        <tr>
            <td colspan="6" align="center">
                <b>Total Receivable Amount</b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice)); ?></b></td> 
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalAdvancePaid)); ?></b></td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6" align="left">
                <b><?php echo $suspenseDetails; ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6" align="center">
                <b><?php echo __('Actual Receivable'); ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="6"></td>
<!--        </tr>
    	<tr style="font-weight: bold;">
    		<td colspan="6" width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				TOTAL
			</td>
			
			<td width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				<?php echo $total; ?>
			</td>
			
			<td width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				<?php echo $totalamnt; ?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php echo $totalTds; ?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php echo $totalDeductAmnt; ?>
			</td>
			
			
			
			<td>
			</td>
			
			<td>
			</td>
    	</tr>-->
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


</Script>