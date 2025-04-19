<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"wcl_report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Wcl Report" );
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
		   <td colspan="16" width="100%" height='30px' align='center' valign='middle'>
		   		<h2><?php echo __('WCL Patient Report Monthwise'); ?></h2>
		   </td>
	 </tr>
	<tr>
	
		 <th width="5px"  align="center" style="text-align:center;">No.</th>
		<th width="122px"  align="center" style="text-align:center;"> Name Of Patient</th>
		<th width="110px"  align="center"	style="text-align:center;"> Name Of Employee<br />(rank)</th>
		<th width="107px"  align="center"	style="text-align:center;"> Relation with Employee</td>
		<th width="100px"  align="center"  style="text-align: center;"> Date of Addmision</th>
		<th width="70px"  align="center" style="text-align: center;">Sub Location</th>
		<th width="127px"  align="center"  style="text-align: center;"> Bill NO</th>
		<th width="103px"  align="center"  style="text-align: center;"> Date of Discharge</th>
		<th width="127px"  align="center"  style="text-align: center;"> Total Bill</th>
		<th width="109px" align="center" style="text-align: center;"> Amount Received</th> 
		<th width="183px"  align="center"    style="text-align: center;">TDS </th>
		<th width="126px"  align="center"    style="text-align: center;"> Other Deduction</th>
		<th width="80px" valign="top" align="center" style="text-align:center;">InvoiceDate</th>
		<th width="86px"  align="center"  style="text-align: center;"> Bill Submission</th>
		<th width="109px" align="center" style="text-align:center;"> Overdue<br />(days)</th>
		<th width="189px"  align="center"  style="text-align: center;"> Remark</th>
		<th width="167px"  align="center"  style="text-align: center;"> Bill Due <br />Date</th>
	

	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="1" class="tabularForm">
	<?php 
		$i=0; $totAMT = 0; $totTds = 0; $totPAID = 0; $totOthrDed = 0;
		foreach($results as $result)
		{
			$i++;
			$bill_id=$result['FinalBilling']['id'];
			$patient_id = $result['Patient']['id']; 
		$total = $result['FinalBilling']['cmp_amt_paid'];
		$val = $val + $total;
		
		$total = $result['FinalBilling']['package_amount'];
		$val1 = $val1 + $total;
		
		$total = $result['FinalBilling']['amount_paid'];
		$val2 = $val2 + $total;
		
		$total = $result['FinalBilling']['tds'];
		$tds=$tds+$tdsAmnt;
		
		$otherDeduct=$result['FinalBilling']['other_deduction'];
		$tot = $tot + $otherDeduct;
			//holds the id of patient
	 ?>
		<tr>
			<td width="5" align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    		</td>
			<td width="102px" align="center" style="text-align:center;">
				<?php 
				
					echo $result['Patient']['patient_id'];  
			     	echo $result['Patient']['lookup_name']; 
			     	?>
		    </td>
		    
			<td width="142px"  align="center"	style="text-align:center;">
			     	<?php echo $result['Patient']['patient_id']."<br>";
			     	echo $result['Patient']['relative_name'];   ?>
		     </td>
			     	
		     <td width="132px"  align="center"	style="text-align:center;">
			     	<?php echo $result['Person']['Person_id']."<br>";
			     			echo $result['Person']['relation_to_employee']."<br>";  ?>
	          </td>
	    
			<td width="108px" align="center"  style="text-align: center;">
		<?php
			    echo $form_received_on = $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format')); //date of admission?>
	   </td>
	   <td width="91px"  align="center"  style="text-align: center;">
				<?php
			   		 echo $subLocations[$result['Patient']['corporate_sublocation_id']];?>
	   </td>
	   
		<td width="106px"  align="center" style="text-align: center;">
		<?php
				echo $result['FinalBilling']['bill_number'];  //bill no ?>
	    </td>
			     	
		<td width="107px"  align="center"style="text-align: center;">
			     	<?php echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); //date of discharge?>
	    </td>
	    
		<td width="112px"  align="center"style="text-align: center;">
                  	<?php  
                            $totalAmount = $result['FinalBilling']['hospital_invoice_amount'];
                           // $totAMT += $totalAmount[$patient_id];
			      echo $this->Number->currency(ceil($totalAmount));?>

		</td>
		 
		 <td width="12%"  align="center"style="text-align: center; min-width: 60px;">
	     	<?php
	     	   $totPAID += $amntRecieved =  $totalPaid[$patient_id];
                  echo $totalPaid[$patient_id];
	     	 //echo  $this->Form->input('package_amount', array('id'=>'package_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_package_amount','value'=>$result['FinalBilling']['package_amount']));
					
			 ?>
		 </td> 
	   
		<td width="116px"  align="center" style="text-align: center;"> 
		    <?php                            // TDS
		 	   $totTds += $tdsAmnt = $result['FinalBilling']['tds'];
                           echo $tdsAmnt;
		    ?>
		  </td>
		
		 <td width="120px"  align="center" style="text-align: center;">
			<?php   $totOthrDed += $totalDiscount[$patient_id];
                        echo $totalDiscount[$patient_id];
			?>
		 </td>
		 <td>
			<?php	echo $this->DateFormat->formatDate2Local($result['FinalBilling']['cmp_paid_date'],Configure::read('date_format')); ?>
			</td>
	
	   <td width="102px"  align="center" style="text-align: center;">  
	      <?php 
	          echo $this->DateFormat->formatDate2Local($result['FinalBilling']['bill_uploading_date'],Configure::read('date_format')); ?>
	    </td>
	   
		<td width="64px" valign="top" align="center" style="text-align: center;">     
		<?php 	$curnt_date = '';
				$discharge_date=explode(' ',$result['Patient']['discharge_date']);
				$diff =$this->General->getDateDifference(trim($discharge_date[0]),date("Y-m-d"));				
	      		echo ($diff);
	     ?>

		</td>
		 
		<td width="95px"  align="center" style="text-align: center;">
			<?php 
		 			if(isset($result['Patient']['remark']))
		 			{
						echo $result['Patient']['remark'];
					}
					else
					{
		 				echo "";
		 			}?>
		</td>
        <td width="95px"  align="center" style="text-align: center;"> 
		 <?php  
		 if($result['FinalBilling']['bill_uploading_date']){
		 	$bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
		 	echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));  
		 }else{
		   	echo "-";
		   }

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
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7" align="left">
                <b><?php echo $suspenseDetails; ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7" align="center">
                <b><?php echo __('Actual Receivable'); ?></b>
            </td>
            <td align="right"><b><?php echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td> 
            <td align="right"><b><?php //echo $this->Number->currency(ceil($totalInvoice-$suspenseAmount)); ?></b></td>
            <td colspan="7"></td>
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