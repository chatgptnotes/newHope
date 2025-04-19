<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"mpkay_report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: MPKAY Report" );
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

.tabularForm th {
	padding: 5px 0px;
}

.top-header {
	background: #3e474a;
	height: 75px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

textarea {
	width: 100px;
}

.inner_title span {
	margin: -33px 0 0 !important;
}

.inner_menu {
	padding: 10px 0px;
}
</style>

<div class="inner_title">
	<h3 align="center">&nbsp; MPKAY Outstanding Report</h3>
</div>
<div id="container">
	<div class="clr ht5"></div>

	<table width="100%" cellpadding="0" cellspacing="1" border="1"
		class="tabularForm top-header">
		<tr>
		
		
		<thead>
			<th width="21px" valign="top" align="center"
				style="text-align: center;">No.</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Sanction ID No.</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Name of Patient</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Name of Emp(Rank)</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Relation with Emp</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Main Member UHID No.</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Date Of Admission</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Bill No</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Discharge Date</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Hospital Invoice Amount</th>
		    <th width="65px" valign="top" align="center"
				style="text-align: center;">Amount Recieved</th> 
			<th width="65px" valign="top" align="center"
				style="text-align: center;">TDS</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Other Deduct</th>
			<th width="80px" valign="top" align="center"
			 style="text-align:center;">InvoiceDate</th>	
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Bill Submission</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Unit Name</th>
			<th width="120px" valign="top" align="center"
				style="text-align: center;">Remark</th>
			<th width="65px" valign="top" align="center"
				style="text-align: center;">Bill Due Date</th>
		</thead>
		</tr>
	</table>

	<table width="100%" cellpadding="0" cellspacing="1" border="1"
		class="tabularForm">
		<?php $curnt_date = date("Y-m-d");	//for current date
        $i=1; $amount=0; 
        $totaladvnce=0;
    	$totalTds=0; $totalamnt=0; 
    	$totalDeductAmnt=0; $totalTds=0;
    	
    foreach($results as $key=>$result)
    {
	$patient_id = $result['Patient']['id']; 	//holds the id of patient
	$bill_id = $result['FinalBilling']['id'];	//holds the bill id of patient
	 
	?>

		<tr>
			<td align="center" valign="middle" width="21px"
				style="text-align: center;"><?php echo $i++; ?></td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Patient']['sanction_no'];?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Patient']['lookup_name'];?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Person']['name_of_ip'];?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Person']['relation_to_employee'];?>
			</td>
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Patient']['card_no'];?>
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
                                //$totalamnt += $invoiceAmnt = $totalAmount[$patient_id];
								
                                $totalamnt += $invoiceAmnt =  $totalAmount[$patient_id];;
				echo $this->Number->currency(ceil($invoiceAmnt));
				
				?>
			</td>
			 <td width="65px" valign="top" align="center" style="text-align: center;">
		        <?php 
                            $totaladvnce += $amntRecieved = $totalPaid[$patient_id];
		            echo $this->Number->currency(ceil($amntRecieved)); 	
			     ?>
		        </td>    

			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php 
                                $totalTds += $tdsAmnt = $result['FinalBilling']['tds'];
				echo $this->Number->currency(ceil($tdsAmnt));
				
				?>
			</td>

			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php		
				   $totalDeductAmnt += $otherDeduct = $totalDiscount[$patient_id];;
			
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
			<td width="65px" valign="top" align="center"
				style="text-align: center;"><?php echo $result['Person']['unit_name'];?>
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
		<?php 
        /*$total=$total+$invoiceAmnt;
        $totaladvnce=$totaladvnce+$advRcv;
     	$totalamnt=$totalamnt+$amntRecieved;
    	$totalTds=$totalTds+$tdsAmnt;
    	$totalDeductAmnt=$totalDeductAmnt+$otherDeduct;*/}?>
    	<tr>
            <td colspan="9" align="center">
                <b>Total Receivable Amount</b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice)); ?></b></td> 
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalAdvancePaid)); ?></b></td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="9" align="left">
                <b><?php echo $suspenseDetails; ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="9" align="center">
                <b><?php echo __('Actual Receivable'); ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="7"></td>
        </tr>
<!--    	<tr style="font-weight: bold;">
    		<td colspan="9" width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				TOTAL
			</td>
			
			<td width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				<?php echo $this->Number->currency(ceil($totalamnt));?>
			</td>
			
			<td width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				<?php echo $this->Number->currency(ceil($totaladvnce)); ?>
			</td>
			<td width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				<?php echo $this->Number->currency(ceil($totalTds)); ?>
			</td>
			<td width="50" style="text-align:center; min-width:50px;">
				<?php  echo $this->Number->currency(ceil($totalTds)); ?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php echo $this->Number->currency(ceil($totalDeductAmnt)); ?>
			</td> 
			<td>
			</td>
			
			<td>
			</td>
    	</tr>-->
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




<!--*******************************************************************************************************************-->





