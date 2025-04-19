<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"cghs_report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: CGHS Report" );
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
}
</style>

<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="1" border="1"
	class="tabularForm top-header">
	<tr class='row_title' > 
		   <td colspan="15" width="100%" height='30px' align='center' valign='middle'>
		   		<h2><?php echo __('CGHS(Ordnance Factory Chanda) Patient Report'); ?></h2>
		   </td>
	 </tr>
	<tr>
	<thead>
		<th width="5px"  align="center" style="text-align:center;">No.</th>
		<th width="81px"  align="center" style="text-align:center;">Name Of Patient</th>
                <th width="65px" valign="top" align="center" style="text-align: center;">Name of Emp(Rank)</th>
                <th width="65px" valign="top" align="center" style="text-align: center;">Relation with Emp</th>
                <th width="65px" valign="top" align="center" style="text-align: center;">CGHS</br>Card No</th>
                <th width="65px" valign="top" align="center" style="text-align: center;">Cliam ID</th>
		<th width="80px"  align="center"style="text-align: center;">Date of Addmision</th>
		<th width="83px"  align="center"style="text-align: center;">Bill NO</th>
		<th width="81px"  align="center"style="text-align: center;">Date of Discharge</th>
		<th width="80px"  align="center"style="text-align: center;">Total Amount</th>
		<th width="80px" align="center"style="text-align: center;">Amount  <br />Received</th> 
		<th width="80px"  align="center" style="text-align: center;">TDS </th>
		<th width="80px"  align="center" style="text-align: center;"> Other deduct</th> 
		<th width="80px"  align="center"style="text-align: center;">Bill Submission</th>
		<th width="91px"  align="center"style="text-align: center;">Remark</th> 
		
	</thead>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="1"
	class="tabularForm">
	<?php 
	$i=0;$val = 0;
	foreach($results as $result)
	{
		$i++;
		$patient_id = $result['Patient']['id'];  
		$bill_id = $result['FinalBilling']['id'];
		//holds the id of patient
		?>
	<tr>
		<td width="21px"  align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    		</td>
		<td width="10%"  align="center"	style="text-align:center; min-width: 53px;">
			<?php echo $result['Patient']['patient_id'];  
				  echo $result['Patient']['lookup_name'];    ?>
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
                        style="text-align: center;"><?php echo $result['Patient']['claim_id'];?>
                </td>
		<td width="12%"  align="center"style="text-align: center; min-width: 94px;">
			<?php 
     				echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); //date of admission	
     		?>
		</td>
		<td width="16%"  align="center" style="text-align: center; min-width: 68px;">
			<?php echo $result['FinalBilling']['bill_number'];  ?>		 
		</td>

		<td width="13%"  align="center"style="text-align: center; min-width: 122px;">
			<?php 
				echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); //date of discharge
			?>
		</td>
		<td width="16%"  align="center"style="text-align: center; min-width: 110px">
			<?php
                            //$totAmt += $totamt =$totalAmount[$patient_id];
                            $totAmt += $totamt = $result['FinalBilling']['hospital_invoice_amount'];
                            echo $this->Number->currency(ceil($totamt)); //Hospital Invoice Amount 
			?>
		 </td>
		 
		 <td width="14%"  align="center"style="text-align: center; min-width: 75px;">
	     	<?php 
                    $totPaid += $amntRecieved = $totalPaid[$patient_id];
                    echo $this->Number->currency(ceil($amntRecieved));
                ?>
		</td>
		
		 
		<td width="50%"  align="center"
			style=" text-align:center; min-width:60px;">
                <?php                
                   $totTds += $tdsAmnt=$result['FinalBilling']['tds'];// TDS
                    echo $this->Number->currency(ceil($tdsAmnt));
                ?> </td>
		
		 <td width="10%"  align="center" style="text-align: center; min-width: 64px">
                    <?php
                        $totOthrDed += $otherDeduct = $result['FinalBilling']['other_deduction'];
                        echo $this->Number->currency(ceil($otherDeduct));
                    ?>
		 		</td>
		 		<td>
		 			<?php 
		 	echo $this->DateFormat->formatDate2Local($result['FinalBilling']['cmp_paid_date'],Configure::read('date_format'			));  ?>	
		 		</td> 
                                
		<td width="10%"  align="center"style="text-align: center; min-width: 101px;">
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
	</tr>
	<?php }  ?>
        <tr>
            <td colspan="9" align="center">
                <b>Total Receivable Amount</b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice)); ?></b></td> 
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalAdvancePaid)); ?></b></td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="9" align="left">
                <b><?php echo $suspenseDetails; ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="9" align="center">
                <b><?php echo __('Actual Receivable'); ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="4"></td>
        </tr>
	
<!--<tr> 
	<td  align="center"style="text-align: center;font-weight:bold;"colspan="9">Actual  Amount Receivable </td>

	<td   align="center"style="text-align: center; font-weight: bold;">
			<?php echo  $totAmt; ?>
	</td>
	<td   align="center"style="text-align: center; font-weight: bold;">
	 		<?php echo  $totPaid;?>
	</td>
			
	<td  align="center"style="text-align: center;font-weight: bold;"> 
	<?php echo  $totTds;?>
	</td>
<td  align="center" style="text-align: center;font-weight:bold;"><?php echo $totOthrDed; ?></td>
 
	<td   align="center"  colspan="2" style="text-align: center;">
    </td>
</tr>-->
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
