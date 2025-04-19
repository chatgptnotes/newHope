<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"bsnl_report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Bsnl Report" );
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
		   		<h2><?php echo __('BSNL Patient Report'); ?></h2>
		   </td>
	 </tr>
	<tr>
            <th width="5px"  align="center" style="text-align:center;">No.</th>
            <th width="122px"  align="center" style="text-align:center;"> Name Of Patient</th>
            <th width="110px"  align="center"	style="text-align:center;"> Name Of Employee<br />(rank)</th>
            <th width="107px"  align="center"	style="text-align:center;"> Relation with Employee</td>
            <th width="100px"  align="center"  style="text-align: center;"> Date of Addmision</th>
            <th width="127px"  align="center"  style="text-align: center;"> Bill NO</th>
            <th width="103px"  align="center"  style="text-align: center;"> Date of Discharge</th>
            <th width="127px"  align="center"  style="text-align: center;"> Hospital Invoice Amount</th>
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
		$i=1; 
		foreach($results as $result)
		{ 
	 ?>
		<tr>
			<td width="5" align="center" style="text-align:center;">
    			<?php 
    				echo $i++;
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
	   
		<td width="106px"  align="center" style="text-align: center;">
		<?php
				echo $result['FinalBilling']['bill_number'];  //bill no ?>
	    </td>
			     	
		<td width="107px"  align="center"style="text-align: center;">
			     	<?php echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format')); //date of discharge?>
	    </td>
	    
		<td width="112px"  align="center"style="text-align: center;">
                    <?php 
                    $totamt = $result['FinalBilling']['hospital_invoice_amount'];
                    echo $this->Number->currency(ceil($totamt)); //Hospital Invoice Amount 
                     ?>

		</td>
		  
		
		<td width="115px"  align="center" style="text-align: center;">
			<?php echo //$this->Number->currency(ceil($result['FinalBilling']['amount_paid'])); //advance paid 
		                $advRecevied=$totalPaid[$result['Patient']['id']];
				$this->Number->currency(ceil($advRecevied));			//debug($advRecevied);
			 ?>
	   </td>
	   
		<td width="116px"  align="center" style="text-align: center;"> 
		    <?php                            // TDS
		 	 echo //$this->Form->input('tds', array('id'=>'tds_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_tds','value'=>$result['FinalBilling']['tds']));
		 	 $tdsAmnt=$result['FinalBilling']['tds'];
		    ?>
		  </td>
		
		 <td width="120px"  align="center" style="text-align: center;">
			<?php 
		
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
		 <td width="102px"  align="center" style="text-align: center;">
		 	<?php 
		 	echo $this->DateFormat->formatDate2Local($result['FinalBilling']['cmp_paid_date'],Configure::read('date_format'			));  ?>	
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
		 <?php  $bill_due = add_dates($result['FinalBilling']['bill_uploading_date'], 15);
			echo $this->DateFormat->formatDate2Local($bill_due,Configure::read('date_format'));   //Bill Due date?>
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