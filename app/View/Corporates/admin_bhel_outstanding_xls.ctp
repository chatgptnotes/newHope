<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"bhel_outstanding_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: BHEL Outstanding Report" );
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
 

<div class="inner_title">
	<h3 align="center">&nbsp; BHEL Outstanding Report</h3>
</div>
    <div id="container">

	<table width="100%" cellpadding="0" cellspacing="1" border="1"
		class="tabularForm top-header">
		<tr>
		
		  	<thead>
				
			<th width="21" valign="top" align="center" style="text-align: center; min-width: 21px;">No.</th>
			<th width="80" valign="top" align="center" style="text-align: center; min-width: 80px;">Patient name</th>
			<th width="90" valign="top" align="center" style="text-align: center; min-width: 90px;">Name of Employee</th>
			<th width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">Relation with Emp</th>
			<th width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">Staff no</th>
			<th width="65" valign="top" align="center" style="text-align: center; min-width: 65px">Admission Date</th>
			<th width="80" valign="top" align="center" style="text-align: center; min-width: 80px;">Bill No</th></th>
			<th width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">Discharge Date</th>
			<th width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">Hospital Invoice Amount</th>
			<th width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">Amount Recieved</th>
			<th width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">20% Adv Recieved</th>
			<th width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">TDS</th>
			<th width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">Other Deduct</th>
			<th width="80px" valign="top" align="center" style="text-align:center;">InvoiceDate</th>
			<th width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">Bill Submission</th>
			<th width="120" valign="top" align="center"	style="text-align: center; min-width: 120px;">Remark</th>
			<th width="65" valign="top" align="center" style="text-align:center; min-width:65px">Bill Due Date</th>
				
	   		</thead>
      	</tr>
    </table>   
    
   <table width="100%" cellpadding="0" cellspacing="1" border="1"
		class="tabularForm">
		<?php $curnt_date = date("Y-m-d");	//for current date
		$i=0; $amount=0; 
        $totaladvnce=0;
    	$total=0; $totalamnt=0; 
    	$totalDeductAmnt=0; $totalTds=0;
			foreach($results as $key=>$result)
			{
				$patient_id = $result['Patient']['id']; 	//holds the id of patient
				$bill_id = $result['FinalBilling']['id'];	//holds the bill id of patient
			    $i++;
				?>

			<tr>
				<td align="center" valign="middle" width="21" style="text-align: center; min-width: 21px;"><? echo $i++; ?></td>
				<td width="80" valign="top" align="center" style="text-align: center; min-width: 80px;"><?php echo $result['Patient']['lookup_name'];?></td>
				<td width="90" valign="top" align="center" style="text-align: center; min-width: 90px;"><?php echo $result['Person']['name_of_ip'];?></td>
				<td width="65" valign="top" align="center" style="text-align: center; min-width: 65px;"><?php echo $result['Person']['relation_to_employee'];?></td>
				<td width="65" valign="top" align="center" style="text-align: center; min-width: 65px;"><?php echo $result['Person']['executive_emp_id_no'];?></td>
				<td width="65" valign="top" align="center" style="text-align: center; min-width: 65px"><?php echo $result['Patient']['form_received_on'];?></td>
				<td width="80" valign="top" align="center" style="text-align: center; min-width: 80px;"><?php echo $result['FinalBilling']['bill_number'];  ?></td></td>
				<td width="65" valign="top" align="center" style="text-align: center; min-width: 65px;"><?php echo $result['FinalBilling']['discharge_date'];  ?></td>
				
				<td width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">
				<?php
		              echo $this->Number->currency(ceil($result['FinalBilling']['cmp_amt_paid']));
		              $invoiceAmnt =$result['FinalBilling']['cmp_amt_paid'];
		         ?>
		         </td>
		         <td width="65" valign="top" align="center" style="text-align: center; min-width: 65px;"> <?php
					      echo $this->Number->currency(ceil($result['FinalBilling']['package_amount']));
				        	$amntRecieved =$result['FinalBilling']['package_amount'];
					
				?>	</td>
				
		 		<td width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">
		 		     <?php echo $this->Number->currency(ceil($result['FinalBilling']['amount_paid'])); 
				           $advRcv=$result['FinalBilling']['amount_paid'];
				      ?>
		 		</td>
		 		
				<td width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">
				<?php 
		      	     echo $this->Number->currency(ceil( $result['FinalBilling']['tds']));
				     $tdsAmnt = $result['FinalBilling']['tds'];
		         ?> </td>
		         
				<td width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">
				<?php		
					 $otherDeduct = $invoiceAmnt-($amntRecieved+$tdsAmnt+$advRcv);
				     echo $this->Number->currency(ceil($otherDeduct));
	
				?>	
				</td>
			<td>
			<?php	echo $this->DateFormat->formatDate2Local($result['FinalBilling']['cmp_paid_date'],Configure::read('date_format')); ?>
			</td>
				<td width="65" valign="top" align="center" style="text-align: center; min-width: 65px;">
				<?php	
					//Bill Submission date
					echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format'));
				?>	
				</td>
				
				<td width="120" valign="top" align="center"	style="text-align: center; min-width: 120px;">
				 <?php echo $result['Patient']['remark'];?>
				</td>
			    <td width="65" valign="top" align="center" style="text-align: center; min-width: 65px;"><?php 
						//Bill Due Date
						$bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
						echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));
				?>
			    </td>
			</tr>
		<?php 
        $total=$total+$invoiceAmnt;
        $totaladvnce=$totaladvnce+$advRcv;
     	$totalamnt=$totalamnt+$amntRecieved;
    	$totalTds=$totalTds+$tdsAmnt;
    	$totalDeductAmnt=$totalDeductAmnt+$otherDeduct;}?>
    	
    	<tr style="font-weight: bold;">
    		<td colspan="8" width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				TOTAL
			</td>
			
			<td width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				<?php echo $this->Number->currency(ceil($total));?>
			</td>
			
			<td width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				<?php echo $this->Number->currency(ceil($totalamnt)); ?>
			</td>
			<td width="100%" height='30px' align='center' valign='middle' style="font-weight: bold;">
				<?php echo $this->Number->currency(ceil($totaladvnce)); ?>
			</td>
			<td width="50" style="text-align:center; min-width:50px;">
				<?php  echo $this->Number->currency(ceil($totalTds)); ?>
			</td>
			
			<td width="50" style="text-align:center; min-width:50px;">
				<?php echo $this->Number->currency(ceil($totalDeductAmnt)); ?>
			</td>
			
    	</tr>
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