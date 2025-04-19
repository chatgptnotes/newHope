<?php 
 
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"FCI_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description:FCI_Report" );
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
	<h3 style="float: left;" a>FCI Report</h3>

	
	<div class="clr"></div>


</div>
<div class="clr ht5"></div>


<table width="100%" cellpadding="0" cellspacing="1" border="1"
	class="tabularForm top-header">
	<tr>
	
		<th width="10px" valign="top" align="center"
			style="text-align: center;">#</th>
		<th width="83px" valign="top" align="center"
			style="text-align: center;">Name Of Patient</th>
		<th width="80px" valign="top" align="center"
			style="text-align: center;">Name Of Employee (rank)</th>
		<th width="80px" valign="top" align="center"
			style="text-align: center;">Relation with Employee</th> 
		<th width="81px" valign="top" align="center"
			style="text-align: center;">FCI Medical<br>Health ID<br>Card No
		</th>
		<th width="80px" valign="top" align="center"
			style="text-align: center;">Date of Addmision</th>
		<th width="97px" valign="top" align="center"
			style="text-align: center;">Bill No</th>
		<th width="80px" valign="top" align="center"
			style="text-align: center;">Date of Discharge</th>
		<th width="80px" valign="top" align="center"
			style="text-align: center;">Hospital Invoice Amount</th>
		<th width="80px" valign="top" align="center"
			style="text-align: center;">Amount Received</th>
		<th width="86px" valign="top" align="center"
			style="text-align: center;">TDS</th>
		<th width="80px" valign="top" align="center"
			style="text-align: center;">Other deduct</th>
		<th width="80px" valign="top" align="center" 
		style="text-align:center;">InvoiceDate</th>	
		<th width="70px" valign="top" align="center"
			style="text-align: center;">Bill Submission</th>
		<th width="115px" valign="top" align="center"
			style="text-align: center;">Remark</th>
		<th width="93px" valign="top" align="center"
			style="text-align: center;">Bill due Date</th>

	</tr>

	
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="1"
	class="tabularForm">
	<?php 
	$i=0; $totAmnt = $totPaid = $totTds = $totOthrDed = 0;
	foreach($results as $result)
	{
		$bill_id = $result['FinalBilling']['id'];
		$patient_id = $result['Patient']['id'];
		$i++;	
		//holds the id of patient
		?>
	<tr>
			<td align="center" valign="middle" width="21px"
				style="text-align: center;"><? echo $i++; ?></td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Patient']['lookup_name'];?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Person']['name_of_ip'];?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Person']['relation_to_employee'];?>
			</td>
			<td width="86px" valign="top" style="text-align: center;"><?php
		        echo $result['Patient']['card_no'];?>
	    	</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Patient']['form_received_on'];?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['FinalBilling']['bill_number'];  ?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Patient']['discharge_date'];  ?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php
                                $totAmnt += $invoiceAmnt =$result['FinalBilling']['hospital_invoice_amount'];
				echo $this->Number->currency(ceil($invoiceAmnt));
				
				?>
			</td>
			 <td width="65px" valign="top" align="center" style="text-align: center;">
		        <?php 
                            $totPaid += $amntRecieved =$totalPaid[$patient_id];
		            echo $this->Number->currency(ceil($amntRecieved));
					
			     ?>
		        </td>   

			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php 
                                $totTds += $tdsAmnt = $result['FinalBilling']['tds'];
				echo $this->Number->currency(ceil( $tdsAmnt));
				
				?>
			</td>

			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php		
				   $totOthrDed += $otherDeduct = $totalDiscount[$patient_id];
			     echo $this->Number->currency(ceil($otherDeduct));
                      ?>
			</td>
			<td>
			<?php	echo $this->DateFormat->formatDate2Local($result['FinalBilling']['cmp_paid_date'],Configure::read('date_format')); ?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php	
				//Bill Submission date
				echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
				?>
			</td>
			
			<td width="120px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Patient']['remark'];
				?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php 
				//Bill Due Date
				$bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
				echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));
				?>
			</td>
		</tr>
	<?php }  ?>
        <tr>
            <td colspan="8" align="center">
                <b>Total Receivable Amount</b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice)); ?></b></td> 
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalAdvancePaid)); ?></b></td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="8" align="left">
                <b><?php echo $suspenseDetails; ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="8" align="center">
                <b><?php echo __('Actual Receivable'); ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="6"></td>
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
