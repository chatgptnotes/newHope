<?php 
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"ECHS Report".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true).".xls");
header ("Content-Description: ECHS OUtstanding Report" );	
ob_clean();
flush();
?>
<style>

textarea 
{
	width: 60px;
}

.tabularForm th {
   
    padding: 5px 0px;
   
}

</style>



 <div class="inner_title" align="center"> 
 	<h3>&nbsp;ECHS Report</h3> 
 </div>

	
	<div class="clr">&nbsp;</div>
	<div id="container">
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm top-header" >
	
		<tr>
		  	<thead>
				
				<th width="20px" valign="top" align="center" style="text-align:center;">#</th>
				<th width="55px" valign="top" align="center" style="text-align:center;">Patient Name</th>
				<th width="7%" valign="top" align="center" style="text-align: center; ">Name Of Employee (rank)</th>
				<th width="30px" valign="top" align="center" style="text-align:center; ">Relation with Emp. </th>
				<th width="7%" valign="top" align="center" style="text-align:center; ">ECHS<br>Card No</th>
                                <th width="7%" valign="top" align="center" style="text-align:center; ">Admission<br>Date</th>
				<th width="50" valign="top" align="center" style="text-align:center; ">Bill No.</th>
				<th width="6%" valign="top" align="center" style="text-align:center; ">Discharge<br>Date</th>
				<th width="50" valign="top" align="center" style="text-align:center; ">Total Amount</th>
				<th width="40"  valign="top" align="center" style="text-align:center; ">Amount Recieved</th>
				<th width="50" valign="top" align="center" style="text-align:center;">TDS</th>
				<th width="50" valign="top" align="center" style="text-align:center;">Other<br>Deduction</th>
<!--				<th width="80px" valign="top" align="center" style="text-align:center;">InvoiceDate</th>-->
				<th width="50" valign="top" align="center" style="text-align:center;">Bill Submission Date</th>
				<th width="50"  valign="top" align="center" style="text-align:center;">Remark</th> 
<!--				<th width="50" valign="top" align="center" style="text-align:center;">Bill Due Date</th>-->
				
	   		</thead>
      	</tr>
    </table>   
    
    <table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm"> 
    
    <?php  $i=0; $totalAMT = 0; $totalReceived = 0; $totOtherDed = 0;
    	foreach($results as $result) 
    	  {	
    	  	$patient_id = $result['Patient']['id'];
    	  	$bill_id = $result['FinalBilling']['id'];
    	  	$i++;
    	  	$total = $result['FinalBilling']['cmp_amt_paid'];
		$val = $val + $total;
		
		$total = $result['FinalBilling']['package_amount'];
		$val1 = $val1 + $total;
		
		$total = $result['FinalBilling']['amount_paid'];
		$val2 = $val2 + $total;
		
		$total = $result['FinalBilling']['tds'];
		$tds=$tds+$tdsAmnt;
    	  	
    ?>
    	<tr>

    		<td width="15px" valign="top" align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    		</td>
	    	<td width="66px" style="text-align:center;">
				<?php echo $result['Patient']['lookup_name'];?>
			</td>
			
			<td width="61px" style="text-align:center;"><?php 
			echo $result['Patient']['relative_name'];   ?></td>
			
			<td width="52" style="text-align:center;">
				<?php echo $result['Person']['relation_to_employee'];?>
			</td>
			
                        <td width="50" style="text-align:center;"> 
				    <?php echo $result['Patient']['card_no'];?> 
			</td>
			<td width="50" style="text-align:center;">
				<?php 
					// Admission Date
	 				$admitn_date =($result['Patient']['form_received_on']);	
	 				echo $this->DateFormat->formatDate2Local($admitn_date, Configure::read('date_format'));
				?> 
			</td>
			
			<td width="70px" style="text-align:center;">
				<?php 
						// Bill No	
		 			   echo $result['FinalBilling']['bill_number'];
				?>
			</td>
			
			<td width="50" style="text-align:center;">
				<?php 
						// Discharge Date
		 				$discharg_date =($result['Patient']['discharge_date']);	
		 				echo $this->DateFormat->formatDate2Local($discharg_date, Configure::read('date_format'));
				?>
			</td>
			
			<td width="50" style="text-align:center;">
				<?php 
						// Hospital Invoice Amount
                                    $totalAMT += $invoiceAmnt = $totalAmount[$patient_id];
                                    echo $this->Number->currency(ceil($invoiceAmnt));
		 			   
				?>
			</td>   
			
			<td width="60" style="text-align:center;">
				 <?php	
				 		// Amount Recieved= amount paid by echs
                                        $totalReceived += $advRecevied = $totalPaid[$patient_id];
					echo   $this->Number->currency(ceil($advRecevied)); 
				?>	
			</td>
			
			<td width="50" style="text-align:center;">
				<?php 
						// TDS	
		 			  echo  $this->Number->currency(ceil($result['FinalBilling']['tds']));
		 			  $tdsAmnt =$result['FinalBilling']['tds'];
		 			   
				?>
			</td>
			
			<td width="50" style="text-align:center;">
				<?php	
                                    // Other Deduction
				   $totOtherDed += $otherDeduct = $totalDiscount[$patient_id];;
				    
                    echo  $this->Number->currency(ceil($otherDeduct));
					
				?>	
			</td> 
			
			<td width="50" style="text-align:center;">
                            <?php	
                                    if(!empty($result['FinalBilling']['bill_uploading_date'])){
                                        echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
                                    }else{
                                        $bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
                                            echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));
                                    }
                            ?>  
			</td>
			
			<td width="50" style="text-align:center;">
				<?php 
					//Remark
	 				echo $result['Patient']['remark'];
				?>	
			</td> 
			
			
    	</tr>
    	
<!--     		<td>  -->
    		<?php //echo $bill_id; ?>
<!--     		</td> -->
    <?php } ?>	
   <tr>
            <td colspan="8" align="center">
                <b>Total Receivable Amount</b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice)); ?></b></td> 
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalAdvancePaid)); ?></b></td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="8" align="left">
                <b><?php echo $suspenseDetails; ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="8" align="center">
                <b><?php echo __('Actual Receivable'); ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="4"></td>
        </tr>
    </table>
	



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
 